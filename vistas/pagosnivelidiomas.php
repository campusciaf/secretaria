<?php
require_once "../modelos/Pagosnivelidiomas.php";
$pagos = new Pagos();
// session_start();
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d-H:i:s');
$usuario = "epayco";
$x_id_factura = isset($_GET["x_id_factura"]) ? $_GET["x_id_factura"] : ""; // numero de la factura
$x_description = isset($_GET["x_description"]) ? $_GET["x_description"] : ""; // nombre de la compra
$x_amount_base = isset($_GET["x_amount_base"]) ? $_GET["x_amount_base"] : 0; // monto
$x_currency_code = isset($_GET["x_currency_code"]) ? $_GET["x_currency_code"] : "COP"; // tipo de moneda
$x_bank_name = isset($_GET["x_bank_name"]) ? $_GET["x_bank_name"] : ""; // nombre entidad por la que realizo el pago
$x_respuesta = isset($_GET["x_respuesta"]) ? $_GET["x_respuesta"] : ""; // estado del pago
$x_fecha_transaccion = isset($_GET["x_fecha_transaccion"]) ? $_GET["x_fecha_transaccion"] : ""; // fecha del pago
$x_franchise = isset($_GET["x_franchise"]) ? $_GET["x_franchise"] : ""; // franquisia (la entida recaudadora de dinero)
// variables x_extra
$credencial_estudiante = isset($_GET["x_extra1"]) ? $_GET["x_extra1"] : ""; //  guarda el id credencial del estudiante
$cedula = isset($_GET["x_extra2"]) ? $_GET["x_extra2"] : ""; // trae la cédula del estudiante
$id_programa = isset($_GET["x_extra3"]) ? $_GET["x_extra3"] : ""; // trae el id_programa del estudiante
$nivel_programa_reg = isset($_GET["x_extra4"]) ? $_GET["x_extra4"] : ""; // trae el id_programa del estudiante
$jornada_e = isset($_GET["x_extra5"]) ? $_GET["x_extra5"] : ""; // trae la jornada
// datos personales
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
echo "<pre>";
print_r($_GET);
echo "</pre>";

$stmt = $pagos->insertarPagoIngles($x_id_factura, $credencial_estudiante, $cedula, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip);
if ($x_respuesta == "Aceptada") {
    $id_estudiante_condicional = null;  // Define la variable fuera del bloque if para que tenga un ámbito más amplio
    //echo "$id_estudiante, $id_programa";
    $traer_id_estudiante = $pagos->traeridestudiante($credencial_estudiante, $id_programa);
    // Verifica que $traer_id_estudiante sea un array antes de intentar acceder a él
    if (is_array($traer_id_estudiante) && isset($traer_id_estudiante['id_estudiante'])) {
        $id_estudiante_condicional = $traer_id_estudiante['id_estudiante'];
    }
    if ($id_estudiante_condicional === null) {
        $pagos->insertarnuevoprograma($credencial_estudiante, $jornada_e, $id_programa, $nivel_programa_reg);
    }
    $descriptions = explode(',', $x_description);
    echo count($descriptions);

    if(count($descriptions) >= 1){
        // Itera sobre cada descripción y realiza la inserción
        foreach ($descriptions as $description) {
            echo $description;
            // Trim para eliminar espacios en blanco al principio y al final de la descripción
            $description = trim($description);
            $traer_ultimo_registro = $pagos->traer_ultimo_registro_estudiantes($credencial_estudiante, $id_programa);
            $id_estudiante_idiomas = $traer_ultimo_registro['id_estudiante'];
            $rsptaperiodo = $pagos->periodoactual();
            $periodo_activo = $rsptaperiodo['periodo_actual'];
            $pagos->insertar_estudiante($id_estudiante_idiomas, $description, $jornada_e, $jornada_e, $id_programa, $periodo_activo);
        }
    }else{
        $description = trim($x_description);
        $traer_ultimo_registro = $pagos->traer_ultimo_registro_estudiantes($credencial_estudiante, $id_programa);
        $id_estudiante_idiomas = $traer_ultimo_registro['id_estudiante'];
        $rsptaperiodo = $pagos->periodoactual();
        $periodo_activo = $rsptaperiodo['periodo_actual'];
        $pagos->insertar_estudiante($id_estudiante_idiomas, $description, $jornada_e, $jornada_e, $id_programa, $periodo_activo);
    }
}
