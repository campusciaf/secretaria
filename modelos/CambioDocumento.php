<?php
require "../config/Conexion.php";
class CambioDocumento{
	// Implementamos nuestro constructor
	public function __construct(){}
	public function verificarDocumento($documento, $tipo_documento){
		$sql_verificar_doc = "SELECT `ce`.`id_credencial`, `ce`.`credencial_nombre`, `ce`.`credencial_nombre_2`, `ce`.`credencial_apellido`, `ce`.`credencial_apellido_2`, `ce`.`credencial_login` FROM `credencial_estudiante` AS `ce` INNER JOIN `estudiantes_datos_personales` AS `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `edp`.`tipo_documento` = :tipo_documento AND `ce`.`credencial_identificacion` = :documento";
		global $mbd;
		$consulta_verificar = $mbd->prepare($sql_verificar_doc);
		$consulta_verificar->execute(array("tipo_documento" => $tipo_documento, "documento" => $documento));
		$resultado_verificar = $consulta_verificar->fetch(PDO::FETCH_ASSOC);
		return $resultado_verificar;
	}

	public function verificarCedulaCambio($nueva_cedula){
		$sql_verificar_cedula_cambio = "SELECT * FROM `credencial_estudiante` WHERE `credencial_identificacion` = :nueva_cedula";
		global $mbd;
		$consulta_verificar_cedula_cambio = $mbd->prepare($sql_verificar_cedula_cambio);
		$consulta_verificar_cedula_cambio->execute(array("nueva_cedula" => $nueva_cedula));
		$resultado_verificar_cedula_cambio = $consulta_verificar_cedula_cambio->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_verificar_cedula_cambio;
	}

	public function cambiarTarjetaCedula($id_reemplazar, $num_cedula, $fecha_exp, $tipo_documento){
		$sql_cambiar_tarjeta = "UPDATE `credencial_estudiante` SET `credencial_identificacion` = '$num_cedula' WHERE `id_credencial` = '$id_reemplazar';";
		$sql_cambiar_fecha_exp = "UPDATE `estudiantes_datos_personales` SET `tipo_documento` = '$tipo_documento', fecha_expedicion = '$fecha_exp' WHERE `id_estudiante` = '$id_reemplazar';";
		global $mbd;
		$consulta_cambiar_tarjeta_cedula = $mbd->prepare($sql_cambiar_tarjeta);
		$consulta_cambiar_tarjeta_cedula->execute();
		$consulta_cambiar_fecha_exp = $mbd->prepare($sql_cambiar_fecha_exp);
		$consulta_cambiar_fecha_exp->execute();
		return $consulta_cambiar_tarjeta_cedula;
	}

	public function actualizarCedula($id_reemplazar, $nueva_cedula){
		$sql_actualizar_documento = "UPDATE `credencial_estudiante` SET `credencial_identificacion` = '$nueva_cedula' WHERE `id_credencial` = '$id_reemplazar'; ";
		global $mbd;
		$consulta_actualizar_documento = $mbd->prepare($sql_actualizar_documento);
		$consulta_actualizar_documento->execute();
		return $consulta_actualizar_documento;
	}
	public function verificarDocumentoCoreregir($documento)
	{
		$sql_verificar_doc = "SELECT `id_credencial`, `credencial_identificacion` FROM `credencial_estudiante` WHERE `credencial_identificacion` = :documento";
		global $mbd;
		$consulta_verificar = $mbd->prepare($sql_verificar_doc);
		$consulta_verificar->execute(array("documento" => $documento));
		$resultado_verificar = $consulta_verificar->fetch(PDO::FETCH_ASSOC);
		return $resultado_verificar;
	}
	public function editarDocumentoEstudiante($credencial_identificacion, $id_credencial)
	{
		$sql = "UPDATE `credencial_estudiante` SET `credencial_identificacion` = '$credencial_identificacion' WHERE `id_credencial` = $id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
}
