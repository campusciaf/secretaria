<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";



Class GeolocalizacionZona
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
public function listar($cod_postal){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
	
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.cod_postal= :cod_postal and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":cod_postal", $cod_postal);
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

public function listarPrograma($programa,$cod_postal){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.cod_postal= :cod_postal and est.id_programa_ac= :programa and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":cod_postal", $cod_postal);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
public function listarJornada($jornada,$cod_postal){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.cod_postal= :cod_postal and est.jornada_e= :jornada and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":cod_postal", $cod_postal);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
public function listarSemestre($semestre,$cod_postal){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.cod_postal= :cod_postal and est.semestre_estudiante= :semestre and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":cod_postal", $cod_postal);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
	
public function listarProgramaJornada($programa,$jornada,$cod_postal){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.cod_postal= :cod_postal and est.id_programa_ac= :programa and est.jornada_e= :jornada and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":cod_postal", $cod_postal);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
public function listarProgramaJornadaSemestre($programa,$jornada,$semestre,$cod_postal){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.cod_postal= :cod_postal and est.id_programa_ac= :programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":cod_postal", $cod_postal);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
	
public function listarProgramaSemestre($programa,$semestre,$cod_postal){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT DISTINCT edp.id_credencial FROM estudiantes_datos_personales edp INNER JOIN estudiantes est ON edp.id_credencial=est.id_credencial WHERE edp.cod_postal= :cod_postal and est.id_programa_ac= :programa and est.semestre_estudiante= :semestre and est.periodo_activo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":cod_postal", $cod_postal);
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
	
	
	
		//Implementar un método para listar los departamentos en un select
	public function selectDepartamento()
	{	
		$sql="SELECT * FROM departamentos";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
			//Implementar un método para listar los municipios en un select
	public function selectMunicipio($id_departamento)
	{	
		$sql="SELECT * FROM municipios WHERE departamento_id= :id_departamento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_departamento", $id_departamento);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los municipios en un select
	public function selectCodPostal($id_municipio)
	{	
		$sql="SELECT * FROM cod_postal WHERE id_municipio= :id_municipio";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_municipio", $id_municipio);
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