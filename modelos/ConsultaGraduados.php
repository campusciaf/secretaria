<?php
require "../config/Conexion.php";

class ConsultaGraduados
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function periodoactual()
	{
		$sql = "SELECT * FROM on_periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estuidantes nuevos
	public function listargraduados($periodo, $jornada, $fo_programa)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE est.periodo_activo= :periodo and est.jornada_e= :jornada and est.fo_programa= :fo_programa and est.estado='2'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estuidantes nuevos
	public function listaregresados($periodo, $jornada, $fo_programa)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE est.periodo_activo= :periodo and est.jornada_e= :jornada and est.fo_programa= :fo_programa and est.estado='5'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estuidantes nuevos
	public function listarprogramajornadasuma($periodo, $jornada, $fo_programa)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE (est.periodo_activo= :periodo and est.jornada_e= :jornada and est.fo_programa= :fo_programa and est.estado='2') or (est.periodo_activo= :periodo and est.jornada_e= :jornada and est.fo_programa= :fo_programa and est.estado='5')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los interesados
	public function listartotalgraduados($periodo)
	{

		// SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE est.periodo_activo= :periodo and est.jornada_e= :jornada and est.fo_programa= :fo_programa and est.estado='2'


		$sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE est.periodo_activo= :periodo and est.estado='2'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los interesados
	public function listartotalegresados($periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE est.periodo_activo= :periodo and est.estado='5'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar el total de los nuevos
	public function listartotal($periodo)
	{


		// SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE (est.periodo_activo= :periodo and est.estado='2') or (est.periodo_activo= :periodo and est.estado='5')
		
		$sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE (est.periodo_activo= :periodo and est.estado='2') or (est.periodo_activo= :periodo and est.estado='5')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar el id del programa
	public function listarPrograma()
	{
		$sql = "SELECT * FROM programa_ac where estado_graduados=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar el id del programa
	public function listarJornada()
	{
		$sql = "SELECT * FROM jornada where estado_graduados=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function datoscredencialestudiante($id_credencial)
	{
		$sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para sumar los datos por jornada
	public function sumaporjornadagraduados($jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='2'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para sumar los datos por jornada
	public function sumaporjornadaegresados($jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='5'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para sumar los datos por jornada
	public function sumaporjornada($jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial WHERE (est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='2') or (est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='5')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
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
	//Implementar un método para listar los departamentos en un select
	public function selectPeriodo()
	{
		$sql = "SELECT * FROM periodo order by id_periodo DESC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarmedio($medio, $periodo, $estado)
	{
		$sql = "SELECT * FROM on_interesados WHERE medio= :medio and estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":medio", $medio);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estados del proceso con el medio
	public function listarprogramamedio($programa, $jornada, $medio, $estado, $periodo)
	{
		$sql = "SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and medio= :medio and estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":medio", $medio);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function sumapormedio($jornada, $medio, $estado, $periodo)
	{
		$sql = "SELECT * FROM on_interesados WHERE jornada_e= :jornada and medio= :medio and estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":medio", $medio);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
}
