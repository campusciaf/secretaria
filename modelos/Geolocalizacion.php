<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Geolocalizacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
	
public function listar(){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
	
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.latitud!='' and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
	
public function listarDatos($id_credencial){
		$sql="SELECT * FROM estudiantes_datos_personales edp INNER JOIN credencial_estudiante ce ON edp.id_credencial=ce.id_credencial INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}	

public function listarPrograma($programa){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.latitud!='' and est.id_programa_ac= :programa and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
public function listarJornada($jornada){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.latitud!='' and est.jornada_e= :jornada and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
public function listarSemestre($semestre){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.latitud!='' and est.semestre_estudiante= :semestre and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
	
public function listarProgramaJornada($programa,$jornada){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.latitud!='' and est.id_programa_ac= :programa and est.jornada_e= :jornada and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
public function listarProgramaJornadaSemestre($programa,$jornada,$semestre){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.latitud!='' and est.id_programa_ac= :programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
	
public function listarProgramaSemestre($programa,$semestre){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.latitud!='' and est.id_programa_ac= :programa and est.semestre_estudiante= :semestre and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
	
//public function listarprogramajornadasemestreperiodo($programa,$jornada,$semestre,$periodo){
//		$sql="SELECT * FROM estudiantes_datos_personales edp INNER JOIN credencial_estudiante ce ON edp.id_credencial=ce.id_credencial INNER JOIN estudiantes est ON est.id_credencial=edp.id_credencial WHERE edp.latitud!='' and est.id_programa_ac= :programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.periodo_activo= :periodo";
//		global $mbd;
//		$consulta = $mbd->prepare($sql);
//		$consulta->bindParam(":programa", $programa);
//		$consulta->bindParam(":jornada", $jornada);
//		$consulta->bindParam(":semestre", $semestre);
//		$consulta->bindParam(":periodo", $periodo);
//		$consulta->execute();
//		$resultado = $consulta->fetchAll();
//		return $resultado;	
//	}	
	
	//Implementar un método para listar los programas en un select
	public function selectPrograma()
	{	
		$sql="SELECT * FROM programa_ac WHERE estado=1";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
				//Implementar un método para listar los docentes activos
	public function selectJornada()
	{	
		$sql="SELECT * FROM jornada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
//		//Implementar un método para listar los dias en un select
//	public function selectPeriodo()
//	{	
//		$sql="SELECT * FROM periodo order by periodo DESC";
//		//return ejecutarConsulta($sql);
//		global $mbd;
//		$consulta = $mbd->prepare($sql);
//		$consulta->execute();
//		$resultado = $consulta->fetchAll();
//		return $resultado;
//	}
	
}

?>