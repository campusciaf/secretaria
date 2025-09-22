<?php
require_once("../modelos/PagosAgregador.php");
$obj_pago = new PagosAgregador();
date_default_timezone_set("America/Bogota");
//toma de variables tanto de epayco como del sistema para inserta pago matricula
$fecha = date('Y-m-d-H:i:s');
$usuario = "epayco";
$rsptaperiodo = $obj_pago->periodoactual(); //trae el periodo	
$periodo_pecuniario = $rsptaperiodo["periodo_pecuniario"]; // contiene el perido a matricular
$x_id_factura = isset($_GET["x_id_factura"]) ? $_GET["x_id_factura"] : ""; // numero de la factura
$x_description = isset($_GET["x_description"]) ? $_GET["x_description"] : ""; // nombre de la compra
$x_amount_base = isset($_GET["x_amount_base"]) ? $_GET["x_amount_base"] : 0; // monto
$x_currency_code = isset($_GET["x_currency_code"]) ? $_GET["x_currency_code"] : "COP"; // tipo de moneda
$x_bank_name = isset($_GET["x_bank_name"]) ? $_GET["x_bank_name"] : ""; // nombre entidad por la que realizo el pago
$x_respuesta = isset($_GET["x_respuesta"]) ? $_GET["x_respuesta"] : ""; // estado del pago
$x_fecha_transaccion = isset($_GET["x_fecha_transaccion"]) ? $_GET["x_fecha_transaccion"] : ""; // fecha del pago
$x_franchise = isset($_GET["x_franchise"]) ? $_GET["x_franchise"] : ""; // franquisia (la entida recaudadora de dinero)
$identificacion_estudiante = isset($_GET["x_extra1"]) ? $_GET["x_extra1"] : ""; // trae la cédula del estudiante
$id_estudiante = isset($_GET["x_extra2"]) ? $_GET["x_extra2"] : ""; // trae la cédula del estudiante
$ciclo = isset($_GET["x_extra3"]) ? $_GET["x_extra3"] : ""; // trae el ciclo del estudiante
$tiempo_pago = isset($_GET["x_extra4"]) ? $_GET["x_extra4"] : ""; // siempre debe ser pp-e, ordinaria-e, extra-e
$tipo_pago = isset($_GET["x_extra5"]) ? $_GET["x_extra5"] : ""; // 1= matricula completa, 2 = media  matricula
$semestre_matricular = isset($_GET["x_extra6"]) ? $_GET["x_extra6"] : ""; // el semestre que el estudiante esta pagando
$realiza_proceso = isset($_GET["x_extra7"]) ? $_GET["x_extra7"] : ""; // siempre debe ser Administrativa, ticket, estudiante
$x_customer_doctype = isset($_GET["x_customer_doctype"]) ? $_GET["x_customer_doctype"] : "CC"; // tipo documento
$x_customer_document = isset($_GET["x_customer_document"]) ? $_GET["x_customer_document"] : ""; // documento
$x_customer_name = isset($_GET["x_customer_name"]) ? $_GET["x_customer_name"] : ""; // nombre
$x_customer_lastname = isset($_GET["x_customer_lastname"]) ? $_GET["x_customer_lastname"] : ""; // apellido
$x_customer_email = isset($_GET["x_customer_email"]) ? $_GET["x_customer_email"] : ""; //correo
$x_customer_phone = isset($_GET["x_customer_phone"]) ? $_GET["x_customer_phone"] : ""; // telefono fijo
$x_customer_movil = isset($_GET["x_customer_movil"]) ? $_GET["x_customer_movil"] : ""; // celular
$x_customer_ind_pais = isset($_GET["x_customer_ind_pais"]) ? $_GET["x_customer_ind_pais"] : null; // pais
$x_customer_country = isset($_GET["x_customer_country"]) ? $_GET["x_customer_country"] : "CO"; //indicativo del pais
$x_customer_city = isset($_GET["x_customer_city"]) ? $_GET["x_customer_city"] : "N/A"; // ciudad
$x_customer_address = isset($_GET["x_customer_address"]) ? $_GET["x_customer_address"] : "N/A"; //dirección
$x_customer_ip = isset($_GET["x_customer_ip"]) ? $_GET["x_customer_ip"] : ""; // ip del pago
//objeto de la clase de pagos para insertar
$stmt = $obj_pago->insertarpagorematricula($x_id_factura, $identificacion_estudiante, $id_estudiante, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $tiempo_pago, $periodo_pecuniario, $tipo_pago, $semestre_matricular, $realiza_proceso );

if ($x_respuesta == "Aceptada") {
	//trae los datos del estudiante de la tabla estudiante
	$datosestudiante = $obj_pago->datosEstudiante($id_estudiante); 
	$jornada_e = $datosestudiante["jornada_e"];
	$grupo = $datosestudiante["grupo"];
	// trae el dato de las materias matriculadas
	$datospagas = $obj_pago->seleccionarMateriasPagas($id_estudiante, $ciclo); 
	for ($i = 0; $i < count($datospagas); $i++) {
		$id_materia = $datospagas[$i]["id_materia"];
		// trae los datos de las materias
		$datosmateria = $obj_pago->datosMateria($id_materia); 
		$nombre_materia = $datosmateria["nombre"];
		$semestre = $datosmateria["semestre"];
		$creditos = $datosmateria["creditos"];
		$id_programa_ac = $datosmateria["id_programa_ac"];
		// inserta las materias pagas en la tabla materias
		$rspta4 = $obj_pago->insertarmateria($id_estudiante, $nombre_materia, $jornada_e, $periodo_pecuniario, $semestre, $creditos, $id_programa_ac, $ciclo, $fecha, $usuario, $grupo); 
	}
	// actualiza el periodo activo en la tabla estudiante
	$actualizarperiodoactivo = $obj_pago->actualizarperiodoactivo($periodo_pecuniario, $id_estudiante); 
	//suma el total de creditos matriculados
	$rspta6 = $obj_pago->creditosMatriculados($id_estudiante, $ciclo); 
	$creditos_matriculados = $rspta6["suma_creditos"];
	// trae creditos por semestre
	$rspta7 = $obj_pago->datosPrograma($id_programa_ac); 
	$inicio_semestre = $rspta7["inicio_semestre"];
	$semestres_del_programa = $rspta7["semestres"];
	$semestre_nuevo = 0;
	$suma_creditos_tabla = 0;
	while ($inicio_semestre <= $semestres_del_programa) {
		$campo = "c" . $inicio_semestre;
		$semestre_nuevo++;
		$suma_creditos_tabla += $rspta7[$campo];
		if ($creditos_matriculados <= $suma_creditos_tabla) {
			$inicio_semestre = $semestres_del_programa + 1;
		} else {
			$inicio_semestre++;
		}
	}
	// traer creditos por semestre
	$rspta8 = $obj_pago->actualizarsemestre($id_estudiante, $semestre_nuevo); 
}
if ($stmt) {
	echo json_encode(array("status" => "OK"));
} else {
	echo json_encode(array("status" => "ERR"));
}