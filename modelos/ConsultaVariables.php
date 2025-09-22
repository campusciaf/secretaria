<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ConsultaVariables
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
	
	
    	//Implementar un método para mostrar los botones que activan las preguntas
	public function listarbotones()
	{
		$sql="SELECT * FROM categoria WHERE categoria_estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	    
    	//Implementar un método para listar los registros
	public function listarcategoria($id_categoria)
	{
		$sql="SELECT * FROM variables WHERE id_categoria= :id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	            //Implementar un método para saber cuantas respuestas tenemos sobre la categoria
	public function totalRespuestas($id_categoria,$programa,$jornada,$semestre,$periodo)
	{
		$programa_print="";
		$jornada_print="";
		$semestre_print="";
		$periodo_print="";
		
		if($programa=="todas"){$programa_print="";}else{$programa_print="and id_programa_ac='$programa'";}
		if($jornada=="todas"){$jornada_print="";}else{$jornada_print="and jornada_e='$jornada'";}
		if($semestre=="todas"){$semestre_print="";}else{$semestre_print="and semestre_estudiante='$semestre'";}
		if($periodo=="todas"){$periodo_print="";}else{$periodo_print="and periodo_activo='$periodo'";}
		
		$sql="SELECT * FROM caracterizacion ctz INNER JOIN estudiantes est ON ctz.id_usuario=est.id_credencial WHERE id_categoria= :id_categoria $programa_print '' $jornada_print '' $semestre_print '' $periodo_print";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
//		$consulta->bindParam(":programa", $programa);
//		$consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		            //Implementar un método para saber cuantas variables realizo
	public function totalUsuarios($id_categoria,$programa,$jornada,$semestre,$periodo)
	{
		$programa_print="";
		$jornada_print="";
		$semestre_print="";
		$periodo_print="";
		
		if($programa=="todas"){$programa_print="";}else{$programa_print="and id_programa_ac='$programa'";}
		if($jornada=="todas"){$jornada_print="";}else{$jornada_print="and jornada_e='$jornada'";}
		if($semestre=="todas"){$semestre_print="";}else{$semestre_print="and semestre_estudiante='$semestre'";}
		if($periodo=="todas"){$periodo_print="";}else{$periodo_print="and periodo_activo='$periodo'";}
		
		$sql="SELECT DISTINCT id_usuario FROM caracterizacion ctz INNER JOIN estudiantes est ON ctz.id_usuario=est.id_credencial WHERE id_categoria= :id_categoria  $programa_print '' $jornada_print '' $semestre_print '' $periodo_print";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_categoria", $id_categoria);
//		$consulta->bindParam(":programa", $programa);
//		$consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

public function listarprograma($programa){
		$sql="SELECT * FROM estudiantes_datos_personales edp INNER JOIN credencial_estudiante ce ON edp.id_credencial=ce.id_credencial INNER JOIN estudiantes est ON est.id_credencial=edp.id_credencial WHERE edp.latitud!='' and est.id_programa_ac= :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
	
public function listarprogramajornada($programa,$jornada){
		$sql="SELECT * FROM estudiantes_datos_personales edp INNER JOIN credencial_estudiante ce ON edp.id_credencial=ce.id_credencial INNER JOIN estudiantes est ON est.id_credencial=edp.id_credencial WHERE edp.latitud!='' and est.id_programa_ac= :programa and est.jornada_e= :jornada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}


public function listarprogramajornadasemestre($programa,$jornada,$semestre){
		$sql="SELECT * FROM estudiantes_datos_personales edp INNER JOIN credencial_estudiante ce ON edp.id_credencial=ce.id_credencial INNER JOIN estudiantes est ON est.id_credencial=edp.id_credencial WHERE edp.latitud!='' and est.id_programa_ac= :programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
	
public function listarprogramajornadasemestreperiodo($programa,$jornada,$semestre,$periodo){
		$sql="SELECT * FROM estudiantes_datos_personales edp INNER JOIN credencial_estudiante ce ON edp.id_credencial=ce.id_credencial INNER JOIN estudiantes est ON est.id_credencial=edp.id_credencial WHERE edp.latitud!='' and est.id_programa_ac= :programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.periodo_activo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
	
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
	
		//Implementar un método para listar los dias en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo order by periodo DESC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
}

?>