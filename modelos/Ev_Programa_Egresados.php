<?php
require "../config/Conexion.php";
class Consulta{

    public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	//Implementar un método para listar los registros
	public function listar(){
		$sql="SELECT * FROM evaluacion_programa_egresado epe INNER JOIN credencial_estudiante ce ON epe.credencial_identificacion=ce.credencial_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	
    
   	//Implementar un método para mostrar los datos de un registro a modificar
	public function buscarprogramaactivo($id_credencial,$periodo_actual)
	{
		$sql="SELECT * FROM estudiantes WHERE id_credencial = :id_credencial AND ciclo = ( SELECT MAX(ciclo) FROM estudiantes WHERE id_credencial = :id_credencial AND ciclo IN (1,2,3))";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
?>