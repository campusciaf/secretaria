<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class AyudaDependencia
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Implementamos un método para insertar registros
	public function insertar($id_credencial, $asunto, $mensaje, $fecha, $hora, $dependencia, $periodo_actual)
	{
		$sql = "INSERT INTO `ayuda` (`id_credencial`, `asunto`, `mensaje`, `fecha_solicitud`, `hora_solicitud`, `dependencia`, `periodo_ayuda`)
		VALUES ('$id_credencial', '$asunto', '$mensaje', '$fecha', '$hora', '$dependencia', '$periodo_actual')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function guardarrespuesta($id_ayuda, $accion, $id_usuario, $id_remite_a, $mensaje_dependencia, $fecha, $hora, $periodo_actual)
	{
		$sql = "INSERT INTO ayuda_respuesta (id_ayuda,accion,id_usuario,id_remite_a,mensaje_dependencia,fecha_respuesta,hora_respuesta,periodo_respuesta)
		VALUES ('$id_ayuda','$accion','$id_usuario','$id_remite_a','$mensaje_dependencia','$fecha','$hora','$periodo_actual')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$sql2 = "UPDATE ayuda SET estado=0,fecha_cierre='" . $fecha . "',hora_cierre='" . $hora . "',usuario_cierre='" . $id_usuario . "' WHERE id_ayuda='" . $id_ayuda . "'";
		$consulta2 = $mbd->prepare($sql2);
		$consulta2->execute();
		return $consulta;
	}
	//Implementamos un método para insertar la respuesta directa
	// public function guardarrespuesta($id_ayuda, $accion, $id_usuario, $id_remite_a, $mensaje_dependencia, $fecha, $hora, $periodo_actual){
	// 	$sql = "INSERT INTO ayuda_respuesta (id_ayuda,accion,id_usuario,id_remite_a,mensaje_dependencia,fecha_respuesta,hora_respuesta,periodo_respuesta)
	// 	VALUES ('$id_ayuda','$accion','$id_usuario','$id_remite_a','$mensaje_dependencia','$fecha','$hora','$periodo_actual')";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->execute();
	// 	$sql2 = "UPDATE ayuda SET estado=0,fecha_cierre='" . $fecha . "',hora_cierre='" . $hora . "',usuario_cierre='" . $id_usuario . "' WHERE id_ayuda='" . $id_ayuda;
	// 	$consulta2 = $mbd->prepare($sql2);
	// 	$consulta2->execute();
	// 	return $consulta;
	// }
	//Implementamos un método para insertar la respuesta directa
	public function guardarrespuestaredireccionar($id_ayuda, $accion, $id_usuario, $id_remite_a, $mensaje_dependencia, $fecha, $hora, $periodo_actual)
	{
		$sql = "INSERT INTO ayuda_respuesta (id_ayuda,accion,id_usuario,id_remite_a,mensaje_dependencia,fecha_respuesta,hora_respuesta,periodo_respuesta)
		VALUES ('$id_ayuda','$accion','$id_usuario','$id_remite_a','$mensaje_dependencia','$fecha','$hora','$periodo_actual')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
		//		$sql2="UPDATE ayuda SET dependencia='".$remite_a."' WHERE id_ayuda='".$id_ayuda."'";
		//		$consulta2 = $mbd->prepare($sql2);
		//		$consulta2->execute();
		//		return $consulta;
	}
	//Implementamos un método para editar registros
	public function editar($id_ejes, $nombre_ejes, $periodo, $objetivo)
	{
		$sql = "UPDATE ejes SET nombre_ejes='$nombre_ejes',periodo='$periodo',objetivo='$objetivo' WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		return $consulta->execute();
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_ejes)
	{
		$sql = "SELECT * FROM ejes WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para eliminar los datos de un registro 
	public function eliminar($id_ejes)
	{
		$sql = "DELETE FROM ejes WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$dependencia = $_SESSION['usuario_cargo'];
		$sql = "SELECT * FROM ayuda ayd INNER JOIN credencial_estudiante ce ON ayd.id_credencial=ce.id_credencial WHERE ayd.dependencia='" . $dependencia . "' and ayd.estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los mensajes para las dependencias este se llama desde el header funcionario
	public function listarTabla($periodo_actual)
	{
		$id_usuario = $_SESSION['id_usuario'];
		$sql = "SELECT * FROM ayuda WHERE id_usuario='" . $id_usuario . "' and periodo_ayuda= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function verAyuda($id_ayuda)
	{
		$sql = "SELECT * FROM ayuda ayd INNER JOIN credencial_estudiante ce ON ayd.id_credencial=ce.id_credencial WHERE ayd.id_ayuda= :id_ayuda";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ayuda", $id_ayuda);
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
	//Implementar un método para listar los registros
	public function datosDependencia($id_remite_a)
	{
		$sql = "SELECT * FROM usuario WHERE id_usuario='" . $id_remite_a . "'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los cargos
	public function selectDependencia()
	{
		$sql = "SELECT * FROM usuario usu INNER JOIN dependencias dep ON usu.id_dependencia=dep.id_dependencias  WHERE dep.ayuda=1";
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
	//Implementar un método para listar los registros
	public function contacto($id_credencial)
	{
		$sql = "SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial WHERE ce.id_credencial= :id_credencial";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function datosDataTablePrint($id_credencial)
	{
		$sql = "SELECT * FROM usuario WHERE id_usuario= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
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

	//traer el numero de whatsapp estudiantes
	public function traerCelularEstudiante($id_credencial)
	{
		global $mbd;
		$hoy = date("Y-m-d");
		$sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`id_credencial` = :id_credencial LIMIT 1;");
		$sentencia->bindParam(":id_credencial", $id_credencial);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}

	public function obtenerRegistroWhastapp($numero_celular)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `whatsapp_registros` WHERE `numero_whatsapp` LIKE :numero_celular ORDER BY `numero_whatsapp` ASC");
		$sentencia->bindParam(':numero_celular', $numero_celular);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
}