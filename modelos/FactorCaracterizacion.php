<?php
session_start(); 
require "../config/Conexion.php";
class FactorCaracterizacion
{


    public function __construct() {
        
    }

    public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	public function periodoanterior($id_periodo){
    	$sql="SELECT * FROM periodo WHERE id_periodo= :id_periodo"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_periodo", $id_periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	

	//Implementar un método para listar los programas en un select
	public function selectPeriodo(){	
		$sql="SELECT * FROM periodo order by id_periodo DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los programas en un select
	public function selectPeriodoid($periodo){	
		$sql="SELECT * FROM periodo WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    
	//Implementar un método para listar los programas en un select
	public function selectPrograma($escuela,$nivel){

		$sql="SELECT * FROM programa_ac WHERE estado=1 AND ciclo !='4' AND ciclo !='6' AND ciclo !='9' $escuela $nivel";	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar las jornadas
	public function selectJornada(){
		$sql="SELECT * FROM jornada WHERE estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar los periodos académicos
	public function periodo(){
		$sql="SELECT * FROM periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes de la tabla activos sin registros dobles

public function total($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_info_completa WHERE periodo= :periodo and nivel NOT IN (4, 6, 8, 9) $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para encontrar la sede o el convenio
	public function buscarconvenio($jornada){	
		$sql="SELECT * FROM escuela_jornada WHERE jornada= :jornada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



	




          

   
}

?>