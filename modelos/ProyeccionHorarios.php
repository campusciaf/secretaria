<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ProyeccionHorarios
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
	
	public function listar(){
		$periodo_actual=$_SESSION['periodo_actual'];// sesión que contiene le periodo actual
		$sql="SELECT * FROM docente_grupos dg INNER JOIN horas_grupos hg ON dg.id_docente_grupo=hg.id_docente_grupo WHERE periodo='".$periodo_actual."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}

	public function insertarRegistro($id_docente,$materia,$jornada,$semestre,$id_programa,$grupo,$ciclo,$num_estu,$c1,$c2,$c3,$c4,$c5,$restriccion,$confirmacion,$periodo_siguiente){
		$sql="INSERT INTO docente_grupos (id_docente,materia,jornada,semestre,id_programa,grupo,ciclo,num_estu,c1,c2,c3,c4,c5,restriccion,confirmacion,periodo) VALUES ('$id_docente','$materia','$jornada','$semestre','$id_programa','$grupo','$ciclo','$num_estu','$c1','$c2','$c3','$c4','$c5','$restriccion','$confirmacion','$periodo_siguiente')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
	public function insertarHora($idusuarionew,$dia,$hora,$hasta,$diferencia,$salon,$periodo_siguiente){
		$sql="INSERT INTO horas_grupos (id_docente_grupo,dia,hora,hasta,diferencia,salon,periodo_hora) VALUES ('$idusuarionew','$dia','$hora','$hasta','$diferencia','$salon','$periodo_siguiente')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


}

?>