<?php
session_start();
require "../config/Conexion.php";

class EncuestaEstudiante
{



	public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	//Implementar un método para listar los registros
	public function totalestudiantesactivos($periodo_actual)
	{
		$sql="SELECT DISTINCT id_credencial FROM estudiantes WHERE periodo_activo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}

	//Implementar un método para listar los registros
	public function totalrespuestas()
	{
		$sql="SELECT * FROM encuesta_docente";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}

	//Implementar un método para listar los datos de la pregunta 1
	public function pre1($respuesta)
	{
		$sql="SELECT * FROM encuesta_docente WHERE pre1='$respuesta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}

	//Implementar un método para listar los datos de la pregunta 2
	public function pre2($respuesta)
	{
		$sql="SELECT * FROM encuesta_docente WHERE pre2='$respuesta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}
	//Implementar un método para listar los datos de la pregunta 2
	public function pre3($respuesta)
	{
		$sql="SELECT * FROM encuesta_docente WHERE pre3='$respuesta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}

	//Implementar un método para listar los docentes activos
	public function listardocentes()
	{
		$sql="SELECT * FROM docente WHERE usuario_condicion='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}

	public function listardocentestotal($id_docente)
	{
		$sql="SELECT * FROM encuesta_docente WHERE pre3='$id_docente'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}


	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM encuesta_web_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}
		public function programa($id_credencial)
	{
		$sql="SELECT max(id_estudiante) AS id_encontrado FROM estudiantes WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch();
		return $resultado;
		
	}
	
		public function datosestudiante($id_estudiante)
	{
		$sql="SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	
	public function datosestudiantepersonales($id_credencial)
	{
		$sql="SELECT * FROM estudiantes_datos_personales WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	
		public function datosestudiantecredencial($id_credencial)
	{
		$sql="SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
}


?>