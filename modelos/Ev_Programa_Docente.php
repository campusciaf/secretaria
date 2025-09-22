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
		$sql="SELECT * FROM evaluacion_programa_docente epd ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}	

   	//Implementar un método para mostrar los datos de un registro a modificar
	public function buscardatos($usuario_identificacion)
	{
		$sql="SELECT * FROM docente WHERE usuario_identificacion = :usuario_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
?>