<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class ResultadosAutoevaluacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function periodoactual()
	{
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//listar todos periodos
	public function listarPeriodos()
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT `periodo` FROM `periodo` where lista_evaluacion_docente='1' ORDER BY `periodo`.`periodo` DESC");
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}

	//Función para listar los docentes que se encuentran activos
	public function listarDocentes()
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `docente` WHERE `usuario_condicion` = 1");
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}

	//Función para listar los docentes que se encuentran activos
	public function listarResultadoAutoevaluacion($id_docente, $periodo)
	{
		$sql = "SELECT * FROM autoevaluacion_docente WHERE id_usuario= :id_usuario and periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//
	public function mostrarEstadoEvalaucion($tipo)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT `estado` FROM `activar_evaluaciones` WHERE `tipo` = :tipo ");
		$sentencia->bindParam(":tipo", $tipo);
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
	}
	public function cambiarEstadoEvalaucion($tipo, $estado){
		$estado_docente = ($estado)?0:1;
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE `activar_evaluaciones` SET `estado` = :estado WHERE `tipo` = :tipo ");
		$sentencia->bindParam(":tipo", $tipo);
		$sentencia->bindParam(":estado", $estado);
		$sentencia->execute();
		
		$sentencia2 = $mbd->prepare("UPDATE `docente` SET `activar_autoevaluacion` = :estado_docente");
		$sentencia2->bindParam(":estado_docente", $estado_docente);
		return $sentencia2->execute();
	}

	//Función para cargar la fecha en formato español
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


	//Implementar un método para listar los estudiantes que contestaron
	public function totaldocentecontestaron($periodo)
	{
		$sql = "SELECT * FROM autoevaluacion_docente WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Función para listar los docentes que se encuentran activos
	public function mostrarresultados($id_docente, $periodo)
	{
		$sql = "SELECT * FROM autoevaluacion_docente WHERE id_usuario= :id_usuario and periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
