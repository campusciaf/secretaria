<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Ayuda
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Implementamos un método para insertar registros
	public function insertar($id_credencial, $id_asunto, $id_asunto_opcion, $id_usuario, $mensaje, $fecha, $hora, $periodo_actual)
	{
		$sql = "INSERT INTO `ayuda`(`id_credencial`, `id_asunto`, `id_asunto_opcion`, `id_usuario`, `mensaje`, `fecha_solicitud`, `hora_solicitud`, `periodo_ayuda`, `fecha_cierre`, `hora_cierre`)
		VALUES ('$id_credencial', '$id_asunto', '$id_asunto_opcion', '$id_usuario', '$mensaje', '$fecha', '$hora', '$periodo_actual', NULL, NULL)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$id_credencial = $_SESSION['id_usuario'];
		$sql = "SELECT * FROM ayuda ayd INNER JOIN credencial_estudiante ce ON ayd.id_credencial=ce.id_credencial WHERE ayd.id_credencial='" . $id_credencial . "'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las opciones
	public function listaropciones($id_asunto)
	{
		$sql = "SELECT * FROM asunto_opcion WHERE id_asunto= :id_asunto";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_asunto", $id_asunto);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listarRespuesta($id_ayuda)
	{
		$sql = "SELECT * FROM ayuda_respuesta WHERE id_ayuda='" . $id_ayuda . "'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para buscar la dependencia de la opcion asunto
	public function buscardependencia($id_asunto_opcion)
	{
		$sql = "SELECT * FROM asunto_opcion WHERE id_asunto_opcion= :id_asunto_opcion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_asunto_opcion", $id_asunto_opcion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para buscar el correo de la dependencia
	public function datosDependencia($dependencia)
	{
		$sql = "SELECT * FROM usuario WHERE id_usuario='" . $dependencia . "'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para buscar el asunto
	public function buscarasunto($id_asunto)
	{
		$sql = "SELECT * FROM asunto WHERE id_asunto= :id_asunto";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_asunto", $id_asunto);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para buscar el opcion asunto
	public function buscaropcionasunto($id_asunto_opcion)
	{
		$sql = "SELECT * FROM asunto_opcion WHERE id_asunto_opcion= :id_asunto_opcion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_asunto_opcion", $id_asunto_opcion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los asuntos
	public function selectAsunto()
	{
		$sql = "SELECT * FROM asunto";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los cargos
	public function selectDependencia()
	{
		$sql = "SELECT * FROM dependencias WHERE ayuda=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function fechaesp($date)
	{
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
}
