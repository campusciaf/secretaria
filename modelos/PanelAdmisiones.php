<?php
session_start(); 
require "../config/Conexion.php";
class Modelos
{


    public function __construct() {
        
    }

    public function periodoactual(){
    	$sql="SELECT * FROM on_periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
    
	//Implementar un método para listar
    public function listarUno($fecha)
    {
        $sql="SELECT fecha_ingreso FROM on_interesados WHERE fecha_ingreso = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los periodos academicos
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo order by id_periodo DESC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    //Implementar un método para listar los periodos academicos
	public function totalCampana($periodo)
	{	
		$sql="SELECT * FROM on_interesados WHERE periodo_campana=:periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
         $consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
        //Implementar un método para listar los periodos academicos
	public function totalMatriculados($periodo)
	{	
		$sql="SELECT * FROM on_interesados WHERE periodo_campana=:periodo and estado='Matriculado'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
         $consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	
   
}

?>