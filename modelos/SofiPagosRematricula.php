<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class SofiPagosRematricula
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}
	//traer datos del preiodo actual en la base de datos
	public function periodoactual()
	{
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para validar le documento
	public function verificardocumento($credencial_identificacion)
	{
		$sql = "SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los programas activos
	public function listar($id_credencial)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial  AND `ciclo` NOT IN (4, 6, 8, 9)";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrardatos($id_credencial)
	{
		$sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el nombre del estado
	public function listarEstado($id_estado_academico)
	{
		$sql = "SELECT * FROM estado_academico WHERE id_estado_academico= :id_estado_academico ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado_academico", $id_estado_academico);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer las materias prematriculadas
	public function vercompras($id_estudiante, $ciclo)
	{
		$tabla = "rematricula" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante = :id_estudiante";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para saber si ya pago la rematricula
	public function pagorematricula($id_estudiante, $periodo_pecuniario)
	{
		$sql = "SELECT * FROM `pagos_rematricula` WHERE `id_estudiante` = :id_estudiante AND `periodo_pecuniario` = :periodo_pecuniario AND `x_respuesta` = 'Aceptada';";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer los datos de la tabla estudiantes
	public function traerdatostablaestudiante($id_estudiante)
	{
		$sql = "SELECT * FROM `estudiantes` WHERE `id_estudiante` = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para traer los datos de la materia
	public function traerdatosmateria($id_materia)
	{
		$sql = "SELECT * FROM materias_ciafi WHERE id = :id_materia";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el periodo pecuniario
	public function traerperiodopecuniario()
	{
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los precios del programa por semestre
	public function tablaprecios($id_programa, $periodo_pecuniario, $semestre, $pago_renovar)
	{
		$sql = "SELECT * FROM `lista_precio_programa` WHERE `id_programa` = :id_programa AND `periodo` = :periodo_pecuniario AND `semestre` = :semestre AND `pago_renovar` = :pago_renovar;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":pago_renovar", $pago_renovar);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el valor del derecho pecuniario si es que lo tiene
	public function lista_precio_pecuniario($id_programa, $periodo_pecuniario)
	{
		$sql = "SELECT `valor_pecuniario` FROM `lista_precio_pecuniario` WHERE `id_programa` = :id_programa AND `periodo` = :periodo_pecuniario LIMIT 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function fechaesp($date)
	{ // convertir la fecha corta en larga
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
	//Implementar un método para listar los motivos de los ticket
	public function selectMotivo()
	{
		$sql = "SELECT * FROM `pagos_rematricula_motivo`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para insertar un ticket
	public function crearticket($id_estudiante, $nuevo_valor, $motivo, $fecha_limite, $fecha, $periodo_pecuniario, $tipo_pago, $semestre)
	{
		global $mbd;
		$sql = "INSERT INTO `pagos_rematricula_ticket`(`id_estudiante`, `nuevo_valor`, `motivo`, `fecha_limite`, `fecha_ticket`, `periodo_pecuniario`, `tipo_pago`, `semestre`) VALUES ('$id_estudiante','$nuevo_valor','$motivo','$fecha_limite','$fecha','$periodo_pecuniario', '$tipo_pago', '$semestre')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para traer los datos del estudiante
	public function datosEstudiante($id_estudiante)
	{
		global $mbd;
		$sql = "SELECT `e`.`id_credencial`, `e`.`fo_programa`, `e`.`jornada_e`, `e`.`ciclo`, `e`.`grupo`, `e`.`semestre_estudiante`, `e`.`id_programa_ac`, `p`.`centro_costo_yeminus`, `p`.`codigo_producto`, `p`.`semestres` AS `semestre_programa`, `e`.`pago_renovar` FROM `estudiantes` `e` INNER JOIN `programa_ac` `p` ON `p`.`id_programa` = `e`.`id_programa_ac` WHERE `e`.`id_estudiante` = :id_estudiante;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar un ticket con parte financiada en el sofi
	public function crearticketfinanciado($id_estudiante_financiacion, $nuevo_valor_financiacion, $motivo_financiado, $fecha_limite_financiado, $fecha, $periodo_pecuniario)
	{
		$sql = "INSERT INTO pagos_rematricula_ticket (id_estudiante,nuevo_valor,motivo,fecha_limite,fecha_ticket,periodo_pecuniario)
		VALUES ('$id_estudiante_financiacion','$nuevo_valor_financiacion','$motivo_financiado','$fecha_limite_financiado','$fecha','$periodo_pecuniario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para traer los tickes activos
	public function buscarticket($id_estudiante, $periodo_pecuniario)
	{
		$sql = "SELECT * FROM pagos_rematricula_ticket WHERE id_estudiante= :id_estudiante and periodo_pecuniario= :periodo_pecuniario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//metodo para eliminar producto del carrito
	public function eliminarticket($id_ticket)
	{
		$sql = "DELETE FROM pagos_rematricula_ticket WHERE id_ticket= :id_ticket";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ticket", $id_ticket);
		return $consulta->execute();
	}
	//Implementar un método para listar las materias pagadas
	public function seleccionarMateriasPagas($id_estudiante, $ciclo)
	{
		$tabla = "rematricula" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante=$id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para insertar las materias
	public function insertarmateria($id_estudiante, $nombre_materia, $jornada_e, $periodo, $semestre, $creditos, $programa, $ciclo, $fecha, $usuario, $grupo)
	{
		$tabla = "materias" . $ciclo;
		$sql = "INSERT INTO $tabla (id_estudiante,nombre_materia,jornada_e,jornada,periodo,semestre,creditos,programa,fecha,usuario,grupo)
		VALUES ('$id_estudiante','$nombre_materia','$jornada_e','$jornada_e','$periodo','$semestre','$creditos','$programa','$fecha','$usuario','$grupo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el periodo activo
	public function actualizarperiodoactivo($periodo_pecuniario, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET periodo_activo= :periodo_pecuniario WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementar un método para listar los creditos matriculados
	public function creditosMatriculados($id_estudiante, $ciclo)
	{
		$tabla = "materias" . $ciclo;
		$sql = "SELECT sum(creditos) as suma_creditos FROM $tabla WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa)
	{
		$sql = "SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para actualizar el semestre del estudiante
	public function actualizarsemestre($id_estudiante, $semestre_nuevo)
	{
		$sql = "UPDATE estudiantes SET semestre_estudiante= :semestre_nuevo WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre_nuevo", $semestre_nuevo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementamos un método para insertar un pago de la rematricula
	public function insertarpagorematricula($x_id_factura, $identificacion_estudiante, $id_estudiante, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $tiempo_pago, $periodo_pecuniario, $tipo_pago, $semestrematricular, $realiza_proceso)
	{
		$sql = "INSERT INTO `pagos_rematricula`(`x_id_factura`, `identificacion_estudiante` ,`id_estudiante` ,`x_description` ,`x_amount_base` ,`x_currency_code` ,`x_bank_name` ,`x_respuesta` ,`x_fecha_transaccion` ,`x_franchise` ,`x_customer_doctype` ,`x_customer_document` ,`x_customer_name` ,`x_customer_lastname` ,`x_customer_email` ,`x_customer_phone` ,`x_customer_movil` ,`x_customer_ind_pais` ,`x_customer_country` ,`x_customer_city` ,`x_customer_address` ,`x_customer_ip` ,`tiempo_pago` ,`periodo_pecuniario`, `matricula`, `semestre`, `realiza_proceso` ) VALUES ('$x_id_factura', '$identificacion_estudiante', '$id_estudiante', '$x_description', '$x_amount_base', '$x_currency_code', '$x_bank_name', '$x_respuesta', '$x_fecha_transaccion', '$x_franchise', '$x_customer_doctype', '$x_customer_document', '$x_customer_name', '$x_customer_lastname', '$x_customer_email', '$x_customer_phone', '$x_customer_movil', '$x_customer_ind_pais', '$x_customer_country',  '$x_customer_city', '$x_customer_address', '$x_customer_ip','$tiempo_pago','$periodo_pecuniario', '$tipo_pago', '$semestrematricular', '$realiza_proceso')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $mbd->lastInsertId();
	}
	//metodo para traer los datos de la materia
	public function traernombrejornadaespanol($jornada_e)
	{
		$sql = "SELECT * FROM jornada WHERE nombre= :jornada_e";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada_e", $jornada_e);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para consultar si tiene credito aprobado
	public function consultacreditosofi($credencial_identificacion, $periodo_pecuniario)
	{
		$sql = "SELECT * FROM sofi_persona sp INNER JOIN sofi_matricula sm ON sp.id_persona=sm.id_persona WHERE sp.numero_documento= :credencial_identificacion and sp.periodo= :periodo_pecuniario and sp.estado='Aprobado' and sm.motivo_financiacion='Financiación matricula'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para consultar si tiene credito aprobado
	public function vercreditosofi($credencial_identificacion, $periodo_pecuniario)
	{
		$sql = "SELECT * FROM sofi_persona sp INNER JOIN sofi_matricula sm ON sp.id_persona=sm.id_persona WHERE sp.numero_documento= :credencial_identificacion and sp.periodo= :periodo_pecuniario and sm.motivo_financiacion='Financiación matricula'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para consultar si tiene credito aprobado
	public function verestadocreditosofi($id_persona, $periodo_pecuniario)
	{
		$sql = "SELECT * FROM sofi_persona sp INNER JOIN sofi_matricula sm ON sp.id_persona=sm.id_persona WHERE sp.id_persona= :id_persona and sp.periodo= :periodo_pecuniario and sm.motivo_financiacion='Financiación matricula'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function generarGestionYeminus($id_pagos_rematricula){
		$sql = "INSERT INTO `gestion_yeminus`(`id_pagos_rematricula`) VALUES(:id_pagos_rematricula)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pagos_rematricula", $id_pagos_rematricula);
		$consulta->execute();
		return $mbd->lastInsertId();
	}
	public function gestionCreacionDeFactura($id_gestion_yeminus, $numero_factura){
		$sql = "UPDATE `gestion_yeminus` SET `crear_factura` = 1, `numero_factura` = :numero_factura WHERE `id_gestion_yeminus` = :id_gestion_yeminus;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_gestion_yeminus", $id_gestion_yeminus);
		$consulta->bindParam(":numero_factura", $numero_factura);
		return $consulta->execute();
	}
	public function gestionCierreVenta($id_gestion_yeminus){
		$sql = "UPDATE `gestion_yeminus` SET `cerrar_venta` = 1 WHERE `id_gestion_yeminus` = :id_gestion_yeminus;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_gestion_yeminus", $id_gestion_yeminus);
		return $consulta->execute();
	}
	public function gestionContabilizar($id_gestion_yeminus){
		$sql = "UPDATE `gestion_yeminus` SET `contabilizar` = 1 WHERE `id_gestion_yeminus` = :id_gestion_yeminus;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_gestion_yeminus", $id_gestion_yeminus);
		return $consulta->execute();
	}
	public function gestionCreacionReciboCaja($id_gestion_yeminus){
		$sql = "UPDATE `gestion_yeminus` SET `crear_recibo_caja` = 1 WHERE `id_gestion_yeminus` = :id_gestion_yeminus;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_gestion_yeminus", $id_gestion_yeminus);
		return $consulta->execute();
	}
	
	public function mirarnuevoprograma($id_credencial,$nuevo_id){
		global $mbd;
		$sql = "SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial and `id_programa_ac` = :nuevo_id";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":nuevo_id", $nuevo_id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//metodo para traer los datos de la materia
	public function buscarmateriasperdidas($ciclo,$id_estudiante,$id_programa_ac){
		$tabla="materias".$ciclo;
		global $mbd;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id_estudiante AND programa= :id_programa_ac AND promedio < 3";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function insertarnuevoprograma($id_credencial,$id_programa_ac,$fo_programa,$jornada_e,$escuela_ciaf,$periodo_ingreso,$ciclo,$periodo_activo,$grupo,$id_usuario_matriculo,$fecha_matricula,$hora_matricula,$admisiones,$pago){
		$sql="INSERT INTO estudiantes (id_credencial,id_programa_ac,fo_programa,jornada_e,escuela_ciaf,periodo,ciclo,periodo_activo,grupo,id_usuario_matriculo,fecha_matricula,hora_matricula,admisiones,pago_renovar)
		VALUES ('$id_credencial','$id_programa_ac','$fo_programa','$jornada_e','$escuela_ciaf','$periodo_ingreso','$ciclo','$periodo_activo','$grupo','$id_usuario_matriculo','$fecha_matricula','$hora_matricula','$admisiones','$pago')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

}
