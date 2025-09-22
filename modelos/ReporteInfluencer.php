<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class ReporteInfluencer
{
	//Implementamos nuestro constructor
	public function __construct() {}
	public function mostrarreporteinfluencer($periodo)
	{
		global $mbd;
		$sql = "SELECT * FROM `influencer_reporte` WHERE `influencer_reporte`.`periodo` = :periodo ORDER BY `influencer_reporte`.`id_influencer_reporte` DESC";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar el nombre de la meta responsable
	public function datos_estudiantes($id_estudiante)
	{
		global $mbd;
		$sql = "SELECT * FROM `estudiantes` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `estudiantes`.`id_credencial`WHERE `estudiantes`.`id_estudiante` = :id_estudiante";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar el nombre de la meta responsable
	public function datosdocente($id_docente)
	{
		global $mbd;
		$sql = "SELECT * FROM docente WHERE id_usuario ='$id_docente'";
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return  $resultado;
	}
	//Implementar un método para listar el nombre de la meta responsable
	public function datosUsuario($id_usuario)
	{
		global $mbd;
		$sql = "SELECT * FROM usuario WHERE id_usuario='$id_usuario'";
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return  $resultado;
	}
	//Implementar un método para listar el nombre de la meta responsable
	public function datos_materia($id_programa, $id_docente, $id_materia, $periodo)
	{
		// SELECT * FROM `docente_grupos` WHERE `id_programa` = :id_programa and id_docente = :id_docente and id_materia = :id_materia
		global $mbd;
		$sql = "SELECT * FROM `docente_grupos` WHERE `id_programa` = :id_programa and id_docente = :id_docente and id_materia = :id_materia and periodo = :periodo";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar el nombre de la meta responsable
	public function consulta_nombre_materia($id)
	{
		// SELECT * FROM `docente_grupos` WHERE `id_programa` = :id_programa and id_docente = :id_docente and id_materia = :id_materia
		global $mbd;
		$sql = "SELECT * FROM `materias_ciafi` WHERE `id` = :id ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Funcion para mostrar las fechas con letras
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
	//Implementar un método para listar el nombre de la meta responsable
	public function nombre_materia($id)
	{
		global $mbd;
		$sql = "SELECT * FROM `materias_ciafi` WHERE `id` = :id";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function mostrarPeriodos()
	{
		$sql = "SELECT * FROM periodo ORDER BY `periodo` DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	function mostrarInfoReporteDocente($id_influencer_reporte)
	{
		global $mbd;
		$sql = "SELECT CONCAT(`d`.`usuario_nombre`, ' ' ,`d`.`usuario_apellido`) AS `docente_nombre`, `ce`.`credencial_identificacion`,`d`.`usuario_login`, CONCAT(`ce`.`credencial_nombre`, ' ', `ce`.`credencial_nombre_2`, ' ', `ce`.`credencial_apellido`, ' ', `ce`.`credencial_apellido_2`) AS nombre_estudiante, `ce`.`credencial_login`, `e`.`fo_programa`, `ir`.`influencer_nivel_accion`, `ir`.`influencer_mensaje`, `ir`.`fecha`, `ir`.`hora`  
		FROM `influencer_reporte` `ir`
		INNER JOIN `estudiantes` `e` ON `ir`.`id_estudiante` = `e`.`id_estudiante`
		INNER JOIN `credencial_estudiante` `ce` ON `e`.`id_credencial` = `ce`.`id_credencial`
		INNER JOIN `docente` `d` ON `ir`.`id_docente` = `d`.`id_usuario`
		WHERE `ir`.`id_influencer_reporte` = :id_influencer_reporte";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_influencer_reporte", $id_influencer_reporte);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	function mostrarInfoReporteUsuario($id_influencer_reporte)
	{
		global $mbd;
		$sql = "SELECT CONCAT(`u`.`usuario_nombre`, ' ' ,`u`.`usuario_apellido`) AS `docente_nombre`, `ce`.`credencial_identificacion`, `u`.`usuario_login`, CONCAT(`ce`.`credencial_nombre`, ' ', `ce`.`credencial_nombre_2`, ' ', `ce`.`credencial_apellido`, ' ', `ce`.`credencial_apellido_2`) AS nombre_estudiante, `ce`.`credencial_login`, `e`.`fo_programa`, `ir`.`influencer_nivel_accion`, `ir`.`influencer_mensaje`, `ir`.`fecha`, `ir`.`hora`  
		FROM `influencer_reporte` `ir`
		INNER JOIN `estudiantes` `e` ON `ir`.`id_estudiante` = `e`.`id_estudiante`
		INNER JOIN `credencial_estudiante` `ce` ON `e`.`id_credencial` = `ce`.`id_credencial`
		INNER JOIN `usuario` `u` ON `ir`.`id_usuario` = `u`.`id_usuario`
		WHERE `ir`.`id_influencer_reporte` = :id_influencer_reporte";
		
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_influencer_reporte", $id_influencer_reporte);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	function respuestasReporteInfluencer($id_influencer_reporte)
	{
		global $mbd;
		$sql = "SELECT `ir`.`id_influencer_respuesta`, `u`.`usuario_nombre`, `u`.`usuario_apellido`, `ir`.`mensaje_respuesta`, `ir`.`created_dt` 
		FROM `influencer_respuesta` `ir` INNER JOIN `usuario` `u` ON `ir`.`id_usuario` = `u`.`id_usuario`
		WHERE `ir`.`id_influencer_reporte` = :id_influencer_reporte ORDER BY `ir`.`created_dt` ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_influencer_reporte", $id_influencer_reporte);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	function insertarRespuestaReporte($id_influencer_reporte, $mensaje_respuesta, $id_usuario)
	{
		global $mbd;
		$sql = "INSERT INTO `influencer_respuesta` (`id_influencer_reporte`, `mensaje_respuesta`, `id_usuario`) VALUES (:id_influencer_reporte, :mensaje_respuesta, :id_usuario)";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_influencer_reporte", $id_influencer_reporte);
		$consulta->bindParam(":mensaje_respuesta", $mensaje_respuesta);
		$consulta->bindParam(":id_usuario", $id_usuario);
		return $consulta->execute();
	}
}
