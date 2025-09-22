<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class SacConsultaAno
{
	//Implementamos nuestro constructor
	public function __construct() {

	}

	//Implementar un método para listar la ejecucion
	public function listarproyecto(){	
		global $mbd;
		$sql="SELECT * FROM sac_proyecto";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar la ejecucion
	public function listarproyectousuario($id_proyecto,$responsable){	
		global $mbd;
		$sql="SELECT * FROM sac_meta WHERE id_proyecto= :id_proyecto and meta_responsable= :responsable";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":responsable", $responsable);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar las matas del usuario dependiendo del proyecto
	public function listarmeta($meta_responsable,$id_proyecto,$anio){	
		// $anio = 2023;
		global $mbd;
		$sql="SELECT * FROM sac_meta WHERE meta_responsable= :meta_responsable and id_proyecto= :id_proyecto and anio_eje= :anio ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para insertar una accion
	public function insertaraccion($nombre_accion, $id_meta, $fecha_accion, $fecha_fin, $hora)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_accion`(`nombre_accion`,`id_meta`,`fecha_accion`, `fecha_fin` , `hora` ) VALUES('$nombre_accion','$id_meta', '$fecha_accion', '$fecha_fin' , '$hora')";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar una accion
	public function editaraccion($id_accion, $nombre_accion, $id_meta, $fecha_accion, $fecha_fin)
	{
		$sql = "UPDATE `sac_accion` SET `id_accion` = '$id_accion', `nombre_accion` = '$nombre_accion' , `id_meta` = '$id_meta', `fecha_accion` = '$fecha_accion' , `fecha_fin` = '$fecha_fin' WHERE `id_accion` = $id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	//Implementar un método para mostrar lasacciones
	public function listaracciones($id_meta){
		$sql = "SELECT * FROM `sac_accion` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_accion($id_accion){
		$sql = "SELECT * FROM `sac_accion` WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function eliminar_accion($id_accion)
	{
		$sql = "DELETE FROM sac_accion WHERE id_accion= :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		return $consulta;
	}


	public function terminar_accion($id_accion)
	{
		$sql = "UPDATE `sac_accion` SET `accion_estado` = '1' WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		return $consulta;
	}


	// public function terminar_accion($id_accion)
	// {
	// 	$sql="UPDATE `sac_accion` SET `accion_estado` = '1' WHERE `id_accion` = :id_accion";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":id_accion", $id_accion);
	// 	$consulta->execute();
	
	// }

	//Implementar un método para listar las matas del usuario dependiendo del proyecto
	public function listarmeta2022($meta_responsable,$id_proyecto){	
		$anio = 2022;
		global $mbd;
		$sql="SELECT * FROM sac_meta WHERE meta_responsable= :meta_responsable and id_proyecto= :id_proyecto and anio_eje= :anio ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function fechaesp($date)
	{
		$dia     = explode("-", $date, 3);
		$year     = $dia[0];
		$month     = (string)(int)$dia[1];
		$day     = (string)(int)$dia[2];

		$dias         = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}

}

?>