<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class RematriculaFinanciera{
	//Implementamos nuestro constructor
	public function __construct(){}
	//Implementar un método para listar los registros
	public function periodoactual(){
		$sql = "SELECT * FROM `periodo_actual`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listar($id_credencial){
		global $mbd;
		$sql = "SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial  AND `ciclo` NOT IN (4, 6, 8, 9) ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa){
		global $mbd;
		$sql = "SELECT * FROM `programa_ac` WHERE `id_programa` = :id_programa";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function datosCreditos($credencial_identificacion){
		global $mbd;
		$sql = "SELECT * FROM `sofi_persona` `sp` LEFT JOIN `sofi_ingresos` `si` ON `si`.`idpersona` = `sp`.`id_persona` WHERE `sp`.`numero_documento` LIKE :credencial_identificacion ORDER BY `sp`.`id_persona` DESC LIMIT 1;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el nombre del estado
	public function listarEstado($id_estado_academico){
		global $mbd;
		$sql = "SELECT * FROM `estado_academico` WHERE `id_estado_academico` = :id_estado_academico ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado_academico", $id_estado_academico);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrardatos($id_credencial){
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function verificarjornadaactiva($jornada_e){
		global $mbd;
		$sql = "SELECT * FROM `jornada` WHERE `nombre` = :jornada_e";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada_e", $jornada_e);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los precios del programa por semestre
	public function tablaprecios($id_programa, $periodo_pecuniario, $semestre, $pago_renovar){
		global $mbd;
		$sql = "SELECT * FROM `lista_precio_programa` WHERE `id_programa` = :id_programa AND `periodo` = :periodo_pecuniario AND `semestre` = :semestre AND  `pago_renovar` = :pago_renovar";
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
	public function lista_precio_pecuniario($id_programa, $periodo_pecuniario){
		$sql = "SELECT * FROM `lista_precio_pecuniario` WHERE `id_programa` = :id_programa and `periodo` = :periodo_pecuniario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para traer los datos de la materia
	public function traernombrejornadaespanol($jornada_e){
		global $mbd;
		$sql = "SELECT * FROM `jornada` WHERE `nombre` = :jornada_e";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada_e", $jornada_e);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer los pagos
	public function traerpagos($id_estudiante, $periodo_pecuniario){
		global $mbd;
		$sql = "SELECT * FROM `pagos_rematricula` WHERE `id_estudiante` = :id_estudiante AND `periodo_pecuniario` = :periodo_pecuniario AND `x_respuesta` = 'Aceptada'";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}	
	//Implementar un método para traer los pagos
	public function traerpagoaceptado($id_estudiante, $periodo_pecuniario){
		global $mbd;
		$sql = "SELECT * FROM `pagos_rematricula` WHERE `id_estudiante` = :id_estudiante AND `periodo_pecuniario` = :periodo_pecuniario AND `x_respuesta` = 'Aceptada'";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el nombre del estado
	public function traerValorEstudioCredito(){
		global $mbd;
		$sql = "SELECT `valor_nombre` FROM `sofi_valor_estudio_credito`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC)["valor_nombre"];
		return $resultado;
	}
	// convertir la fecha corta en larga
	public function fechaesp($date){ 
		$dia = explode("-", $date, 3);
		$year = $dia[0];
		$month = (string)(int)$dia[1];
		$day = (string)(int)$dia[2];
		$dias = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
	//metodo para consultar si tiene credito aprobado
	public function vercreditosofi($credencial_identificacion, $periodo_pecuniario){
		$sql = "SELECT * FROM `sofi_persona` `sp` INNER JOIN `sofi_matricula` `sm` ON `sp`.`id_persona` = `sm`.`id_persona` WHERE `sp`.`numero_documento` = :credencial_identificacion AND (`sp`.`periodo` = :periodo_pecuniario OR `sm`.`periodo` = :periodo_pecuniario) AND sm.motivo_financiacion = 'Financiación matricula'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para consultar si tiene credito aprobado
	public function vercreditoPendientes($credencial_identificacion, $periodo_pecuniario, $id_programa){
		global $mbd;
		$sql = "SELECT * FROM `sofi_persona` `sp` WHERE `sp`.`numero_documento` = :credencial_identificacion AND (`sp`.`periodo` = :periodo_pecuniario OR `sp`.`periodo` = :periodo_actual) AND (`sp`.`estado` = 'Pendiente' OR `sp`.`estado` = 'Pre-aprobado') AND `estudio_credito` = 0 AND `id_programa` = :id_programa";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":periodo_actual", $_SESSION['periodo_actual']);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer los tickes activos
	public function buscarticket($id_estudiante, $periodo_pecuniario){
		$sql = "SELECT * FROM `pagos_rematricula_ticket` WHERE `id_estudiante` = :id_estudiante and `periodo_pecuniario` = :periodo_pecuniario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//metodo para consultar si tiene credito aprobado
	public function verTicketAbierto($id_estudiante){
		global $mbd;
		$sql = "SELECT * FROM `sofi_ticket_financion` WHERE `id_estudiante` = :id_estudiante AND `estado_ticket` = 0";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer los tickets activos de la tabla pagos_rematricula_ticket
	public function verificarTicketsRematricula($id_estudiante){
		$hoy = date("Y-m-d");
		global $mbd;
		$sql = "SELECT *  FROM `pagos_rematricula_ticket` WHERE `id_estudiante` = :id_estudiante AND `fecha_limite` >= :hoy;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":hoy", $hoy);
		$consulta->execute();
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultados;
	}
	public function traerdatostablaestudiante($id_estudiante){
		global $mbd;
		$sql = "SELECT * FROM `estudiantes` WHERE `id_estudiante` = :id_estudiante";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el periodo pecuniario
	public function traerperiodopecuniario(){
		$sql="SELECT * FROM `periodo_actual`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}	
	//Implementar un método para traer las materias
	public function vercompras($id_estudiante, $ciclo){
		$tabla = "rematricula".$ciclo;
		$sql="SELECT * FROM $tabla WHERE `id_estudiante` = :id_estudiante";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//metodo para traer los datos de la materia
	public function traerdatosmateria($id_materia){
		$sql="SELECT * FROM materias_ciafi WHERE id= :id_materia";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//informacion personal del estudiante
	public function datosEstudiante($id_credencial){
		global $mbd;
		$sql = "SELECT * FROM `estudiantes_datos_personales` `dp` INNER JOIN `credencial_estudiante` `cd` ON `dp`.`id_credencial` = `cd`.`id_credencial` WHERE `cd`.`id_credencial` =:id_credencial";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//periodos en los que esta el sofi actualemnte
	public function periodoActualyAnterior(){
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `sofi_periodo`");
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function insertarSolicitud($tipo_documento, $numero_documento, $nombres, $apellidos, $fecha_nacimiento, $estado_civil, $direccion, $ciudad, $celular, $email, $persona_a_cargo, $ocupacion, $tipo, $estado, $idsolicitante, $labora, $genero, $numero_hijos, $nivel_educativo, $nacionalidad, $codeudor_nombre, $codeudor_telefono, $id_programa, $estrato){
		$periodo_actual = $this->periodoActualyAnterior()['periodo_actual'];
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `sofi_persona` (`id_persona`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `fecha_nacimiento`, `estado_civil`, `direccion`, `ciudad`, `celular`, `email`, `persona_a_cargo`, `ocupacion`, `periodo`, `tipo`, `estado`, `idsolicitante`, `labora`, `id_programa`, `genero`, `numero_hijos`, `nivel_educativo`, `nacionalidad`, `codeudor_nombre`, `codeudor_telefono`, `estrato`) VALUES (NULL, :tipo_documento, :numero_documento, :nombres, :apellidos, :fecha_nacimiento, :estado_civil, :direccion, :ciudad, :celular, :email, :persona_a_cargo, :ocupacion,  :periodo_actual, :tipo, :estado, :idsolicitante, :labora, :id_programa, :genero, :numero_hijos, :nivel_educativo, :nacionalidad, :codeudor_nombre, :codeudor_telefono, :estrato);");
		$sentencia->bindParam(':tipo_documento', $tipo_documento);
		$sentencia->bindParam(':numero_documento', $numero_documento);
		$sentencia->bindParam(':nombres', $nombres);
		$sentencia->bindParam(':apellidos', $apellidos);
		$sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
		$sentencia->bindParam(':estado_civil', $estado_civil);
		$sentencia->bindParam(':direccion', $direccion);
		$sentencia->bindParam(':ciudad', $ciudad);
		$sentencia->bindParam(':celular', $celular);
		$sentencia->bindParam(':estrato', $estrato);
		$sentencia->bindParam(':email', $email);
		$sentencia->bindParam(':persona_a_cargo', $persona_a_cargo);
		$sentencia->bindParam(':ocupacion', $ocupacion);
		$sentencia->bindParam(':tipo', $tipo);
		$sentencia->bindParam(':estado', $estado);
		$sentencia->bindParam(':idsolicitante', $idsolicitante);
		$sentencia->bindParam(':labora', $labora);
		$sentencia->bindParam(':periodo_actual', $periodo_actual);
		$sentencia->bindParam(':genero', $genero);
		$sentencia->bindParam(':numero_hijos', $numero_hijos);
		$sentencia->bindParam(':nivel_educativo', $nivel_educativo);
		$sentencia->bindParam(':nacionalidad', $nacionalidad);
		$sentencia->bindParam(':codeudor_nombre', $codeudor_nombre);
		$sentencia->bindParam(':codeudor_telefono', $codeudor_telefono);
		$sentencia->bindParam(':id_programa', $id_programa);
		if ($sentencia->execute()) {
			return $mbd->lastInsertId();
		}
	}
	public function insertar_referencia($familiarnombre, $familiartelefono, $idpersona)
	{
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `sofi_referencias`(`tipo_referencia`, `nombre`, `telefono`, `idpersona`) VALUES ('Familiar', :familiarnombre, :familiartelefono, :idpersona);");
		$sentencia->bindParam(":familiarnombre", $familiarnombre);
		$sentencia->bindParam(":familiartelefono", $familiartelefono);
		$sentencia->bindParam(":idpersona", $idpersona);
		return $sentencia->execute();
	}
	public function InsertarReprensentante($nombre_completo_acudiente, $numero_documento_acudiente, $fecha_expedicion_acudiente, $parentesco, $id_persona)
	{
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `sofi_reprensentate_menor`(`nombre_completo_acudiente`, `numero_documento_acudiente`, `fecha_expedicion_acudiente`, `parentesco`, `id_persona`) VALUES(:nombre_completo_acudiente, :numero_documento_acudiente, :fecha_expedicion_acudiente, :parentesco, :id_persona);");
		$sentencia->bindParam(':nombre_completo_acudiente', $nombre_completo_acudiente);
		$sentencia->bindParam(':numero_documento_acudiente', $numero_documento_acudiente);
		$sentencia->bindParam(':fecha_expedicion_acudiente', $fecha_expedicion_acudiente);
		$sentencia->bindParam(':parentesco', $parentesco);
		$sentencia->bindParam(':id_persona', $id_persona);
		return $sentencia->execute();
	}
	public function insertarIngresos($sector_laboral, $tiempo_servicio, $salario, $tipo_vivienda, $id_persona)
	{
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `sofi_ingresos`( `idpersona`, `sector_laboral`, `tiempo_servicio`, `salario`, `tipo_vivienda`) VALUES (:idpersona, :sector_laboral, :tiempo_servicio, :salario, :tipo_vivienda);");
		$sentencia->bindParam(":tiempo_servicio", $tiempo_servicio);
		$sentencia->bindParam(":sector_laboral", $sector_laboral);
		$sentencia->bindParam(":salario", $salario);
		$sentencia->bindParam(":tipo_vivienda", $tipo_vivienda);
		$sentencia->bindParam(":idpersona", $id_persona);
		return $sentencia->execute();
	}
	public function generarScoreDatacredito($id_persona, $numero_documento, $primer_apellido, $score_value)
	{
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `sofi_datacredito_score`(`id_persona`, `numero_documento`, `primer_apellido`, `score_value`) VALUES (:id_persona, :numero_documento, :primer_apellido, :score_value);");
		$sentencia->bindParam(":id_persona", $id_persona);
		$sentencia->bindParam(":numero_documento", $numero_documento);
		$sentencia->bindParam(":primer_apellido", $primer_apellido);
		$sentencia->bindParam(":score_value", $score_value);
		return $sentencia->execute();
	}
	public function obtenerUltimoScore($numero_documento)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `sofi_datacredito_score` WHERE `numero_documento` = :numero_documento ORDER BY `id_score` DESC LIMIT 1;");
		$sentencia->bindParam(":numero_documento", $numero_documento);
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
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
	public function insertarnuevoprograma($id_credencial,$id_programa_ac,$fo_programa,$jornada_e,$escuela_ciaf,$periodo_ingreso,$ciclo,$periodo_activo,$grupo,$id_usuario_matriculo,$fecha_matricula,$hora_matricula,$admisiones,$pago){
		$sql="INSERT INTO estudiantes (id_credencial,id_programa_ac,fo_programa,jornada_e,escuela_ciaf,periodo,ciclo,periodo_activo,grupo,id_usuario_matriculo,fecha_matricula,hora_matricula,admisiones,pago_renovar)
		VALUES ('$id_credencial','$id_programa_ac','$fo_programa','$jornada_e','$escuela_ciaf','$periodo_ingreso','$ciclo','$periodo_activo','$grupo','$id_usuario_matriculo','$fecha_matricula','$hora_matricula','$admisiones','$pago')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
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
	public function verSiPagoEstudioCredito($id_estudiante, $periodo_pecuniario) {
		global $mbd;
		$sql = "SELECT * FROM `sofi_epayco_estudio` WHERE `id_estudiante` = :id_estudiante AND `x_respuesta` = 'Aceptada' AND `periodo_pecuniario` = :periodo_pecuniario ORDER BY `id_pagos` DESC LIMIT 1;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function verificarValorMinimoTicket($id_ticket) {
		global $mbd;
		$sql = "SELECT * FROM `sofi_ticket_financion` WHERE `id_ticket` = :id_ticket AND `estado_ticket` = 0;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ticket", $id_ticket);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function modificarTicket($id_ticket, $valor_ticket) : bool {
		global $mbd;
		$sql = "UPDATE `sofi_ticket_financion` SET `valor_ticket` = :valor_ticket WHERE `id_ticket` = :id_ticket;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ticket", $id_ticket);
		$consulta->bindParam(":valor_ticket", $valor_ticket);
		return $consulta->execute();
	}
}
