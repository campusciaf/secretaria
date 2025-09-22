<?php
// Se incluye el archivo de conexión a la base de datos
require "../config/Conexion.php";
class Consultaprograma
{
	// Implementamos nuestro constructor
	public function __construct() {}
	public function periodoactual()
	{
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// Implementamos una función para cargar los estudiantes que estan pendientes por renovar
	public function listarnuevos($periodo_actual)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo= :periodo_actual and periodo_activo= :periodo_actual and estado='1' and admisiones='si' and homologado='1' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estuidantes homologados
	public function listarnuevoshomologados($periodo_actual)
	{
		$sql = "SELECT * FROM estudiantes WHERE  periodo= :periodo_actual and estado='1' and admisiones='si' and homologado='0' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estuidantes internos
	public function listarinternos($periodo_actual)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo= :periodo_actual and periodo_activo= :periodo_actual and estado='1'  and admisiones='no' and homologado='1' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estuidantes rematriculados
	public function listarrematricula($periodo_actual)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo!= :periodo_actual and periodo_activo= :periodo_actual and estado='1' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listaraplazos($periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo and estado='3'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarinactivos($periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo and renovar='1' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estuidantes rematriculados
	public function listartotalactivos($periodo_actual)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo_actual and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// funcion para mirar los nuevos del nivel
	public function listarnivelnuevos($periodo_actual, $ciclo)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo= :periodo_actual and periodo_activo= :periodo_actual and estado='1' and ciclo= :ciclo and admisiones='si'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// function para mirar los que renovaroen el nivel
	public function listarnivelrenovaron($periodo_actual, $ciclo)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo!= :periodo_actual and periodo_activo= :periodo_actual and estado='1' and ciclo= :ciclo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function totalprograma($id_programa, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and periodo_activo= :periodo and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function totalprogramaporrenovar($id_programa, $periodo)
	{
		$sql = "SELECT * FROM estudiantes_activos WHERE programa= :id_programa and periodo= :periodo AND `jornada_e` IN ('N01', 'D01', 'F01', 'S01') AND (NOT (`nivel` = 3 AND `graduado` = 0))";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// public function totalprogramaporrenovar($id_programa, $periodo)
	// {
	// 	$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and periodo_activo= :periodo and (estado='1' or estado='3') and renovar='1'";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":id_programa", $id_programa);
	// 	$consulta->bindParam(":periodo", $periodo);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll();
	// 	return $resultado;
	// }
	public function traernuevoprograma($id_programa, $elsemestre, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo= :periodo and estado='1' and admisiones='si' and homologado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":elsemestre", $elsemestre);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function traerprogramahomologado($id_programa, $elsemestre, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo= :periodo and periodo_activo= :periodo and estado='1' and admisiones='si' and homologado='0'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":elsemestre", $elsemestre);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function traerprogramainterno($id_programa, $elsemestre, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo= :periodo and periodo_activo= :periodo and estado='1' and admisiones='no' and homologado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":elsemestre", $elsemestre);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function traerporrenovar($id_programa, $elsemestre, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo_activo= :periodo and (estado='1' or estado='3') and renovar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":elsemestre", $elsemestre);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function traerporrenovarcambio($id_programa, $elsemestre, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo_activo= :periodo and (estado='2' or estado='5') and renovar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":elsemestre", $elsemestre);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function traerprogramarenovacion($id_programa, $elsemestre, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo!= :periodo and periodo_activo= :periodo and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":elsemestre", $elsemestre);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function traerprogramatotaljornadasemestre($id_programa, $elsemestre, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo_activo= :periodo and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":elsemestre", $elsemestre);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function sumaporrenovar($id_programa, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornada and periodo_activo= :periodo and (estado='1' or estado='3') and renovar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function sumanuevos($id_programa, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornada and periodo= :periodo and periodo_activo= :periodo and estado='1' and admisiones='si' and homologado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function sumahomologado($id_programa, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornada and periodo= :periodo and periodo_activo= :periodo and estado='1' and admisiones='si' and homologado='0'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function sumainternos($id_programa, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and  jornada_e= :jornada and periodo= :periodo and periodo_activo= :periodo and estado='1' and admisiones='no' and homologado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function sumarenovacion($id_programa, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornada and periodo!= :periodo and periodo_activo= :periodo and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function sumajornada($id_programa, $jornada, $periodo)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornada and periodo_activo= :periodo and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	/* consultas para listar los estudiantes en la visa general */
	public function listarestudaintesactivos($periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo and est.estado='1' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesnuevos($periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo= :periodo and est.estado='1' and est.admisiones='si'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesnuevoshomologados($periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo= :periodo and est.estado='1' and est.admisiones='si' and est.homologado='0'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesinternos($periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo= :periodo and est.estado='1' and est.admisiones='no' and est.homologado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesrematricula($periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo!= :periodo and est.estado='1' and est.periodo_activo= :periodo ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesaplazados($periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo and est.estado='3' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesporrenovar($periodo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo  and est.renovar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	/* ************************************** */
	/* consultas para listar los estudiantes en la vista por nivel */
	public function listarestudaintesactivosnivel($periodo, $ciclo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo and est.estado='1' and est.ciclo= :ciclo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesnuevosnivel($periodo, $ciclo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo= :periodo and est.estado='1' and est.admisiones='si' and est.ciclo= :ciclo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesnuevoshomologadosnivel($periodo, $ciclo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo= :periodo and est.estado='1' and est.admisiones='si' and est.homologado='0' and est.ciclo= :ciclo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesinternosnivel($periodo, $ciclo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo= :periodo and est.estado='1' and est.admisiones='no' and est.homologado='1' and est.ciclo= :ciclo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesrematriculanivel($periodo, $ciclo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo!= :periodo and est.estado='1' and est.periodo_activo= :periodo and est.ciclo= :ciclo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesporrenovarnivel($periodo, $ciclo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo  and est.renovar='1' and est.ciclo= :ciclo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarestudaintesaplazadosnivel($periodo, $ciclo)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo est.estado='3' and est.ciclo= :ciclo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	/* ************************************** */
	public function verestudiantes($id_programa, $jornada, $semestre, $periodo, $valor)
	{
		if ($valor == "1.1") {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.periodo_activo= :periodo and (est.estado='1' or est.estado='3') and est.renovar='1'";
		}
		if ($valor == 1) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='si' and est.homologado='1'";
		}
		if ($valor == 2) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='si' and est.homologado='0'";
		}
		if ($valor == 3) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='no' and est.homologado='1'";
		}
		if ($valor == 4) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email  
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.periodo!= :periodo and est.periodo_activo= :periodo and est.estado='1' ";
		}
		if ($valor == 5) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email  
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre  and est.periodo_activo= :periodo and est.estado='1' ";
		}
		if ($valor == "4.1") {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial 
			WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre  and est.periodo_activo= :periodo and (est.estado='2' or est.estado='5') and est.renovar='1' ";
			
		}
		if ($valor == "4.2") {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre  and est.periodo_activo= :periodo and (est.estado='2' or est.estado='5') and est.renovar='1' ";
		}
		if ($valor == 6) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and  est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='si' and est.homologado='1'";
		}
		if ($valor == 7) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='si' and est.homologado='0'";
		}
		if ($valor == 8) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='no' and est.homologado='1'";
		}
		if ($valor == 9) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo!= :periodo and est.periodo_activo= :periodo and est.estado='1' ";
		}
		if ($valor == "10") {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='1' ";
		}
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		@$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function verestudiantestotal($id_programa, $jornada, $periodo, $valor)
	{
		if ($valor == "6.1") {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada  and est.periodo_activo= :periodo and (est.estado='1' or est.estado='3') and est.renovar='1'";
		}
		if ($valor == 6) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and  est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='si' and est.homologado='1'";
		}
		if ($valor == 7) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='si' and est.homologado='0'";
		}
		if ($valor == 8) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='no' and est.homologado='1'";
		}
		if ($valor == 9) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo!= :periodo and est.periodo_activo= :periodo and est.estado='1' ";
		}
		if ($valor == 10) {
			$sql = "SELECT est.id_estudiante AS miidestudiante, est.fo_programa, est.periodo, est.periodo_activo,
			ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, ce.credencial_login,
			edp.celular, edp.email 
			FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='1' ";
		}
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Implementamos una función para cargar los programas asociados
	public function programaAc($profesional)
	{
		$sql = "SELECT * FROM programa_ac WHERE profesional= :profesional ORDER BY id_programa ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":profesional", $profesional);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Implementamos una función para cargar los jorandas de por renovar activas
	public function jornadas()
	{
		$sql = "SELECT nombre,estado,codigo FROM jornada WHERE estado_consulta_programa	='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Implementamos una función para cargartodas las jornadas
	public function jornadastodas()
	{
		$sql = "SELECT id_jornada,nombre,estado,codigo,estado_consulta_programa FROM jornada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Implementamos una función para cargartodas las jornadas
	public function activarjornada($id_jornada, $valor)
	{
		$sql = "UPDATE jornada SET porrenovar= :valor WHERE id_jornada= :id_jornada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_jornada", $id_jornada);
		$consulta->bindParam(":valor", $valor);
		return $consulta->execute();
	}
	public function aplazadosnivel($periodo, $nivel)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo and estado='3' and ciclo= :nivel";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":nivel", $nivel);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function homologadosnivel($periodo, $nivel)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo= :periodo and estado='1' and admisiones='si' and homologado='0' and ciclo= :nivel";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":nivel", $nivel);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function internosnivel($periodo, $nivel)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo= :periodo and estado='1' and admisiones='no' and ciclo= :nivel";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":nivel", $nivel);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function inactivosnivel($periodo, $nivel)
	{
		$sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo and ciclo= :nivel and renovar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":nivel", $nivel);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// consulta para saber si el estudiante renovo
	public function mirarsirenovocambiodenivel($id_credencial, $periodo_actual)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial AND periodo= :periodo_actual and admisiones='no' and homologado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
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

	public function datosestudiante($id_credencial)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial WHERE ce.id_credencial= :id_credencial");
		$sentencia->bindParam(':id_credencial', $id_credencial);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
}
