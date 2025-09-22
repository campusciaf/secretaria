<?php 
require "../config/Conexion.php";

Class CarReporteActivos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


	public function periodoactual()
    {
    	$sql="SELECT * FROM periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	//Implementar un método para listar los estudiantes activos
	public function listar($periodo)
	{	
		$sql="SELECT * FROM estudiantes_info_completa WHERE periodo=:periodo ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


    //Implementar un método para listar las preguntas de seres originales
	public function seresoriginales($id_credencial){	
		$sql="SELECT * FROM carseresoriginales WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;		
	}
	
	
    //Implementar un método para listar las preguntas de inspiradores
	public function inspiradores($id_credencial){	
		$sql="SELECT * FROM carinspiradores WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;		
	}

       //Implementar un método para listar las preguntas de inspiradores
	public function empresas($id_credencial){	
		$sql="SELECT * FROM carempresas WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;		
	}
      //Implementar un método para listar las preguntas de inspiradores
    public function confiamos($id_credencial){	
		$sql="SELECT * FROM carconfiamos WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;		
	}

      //Implementar un método para listar las preguntas de inspiradores
    public function experiencia($id_credencial){	
		$sql="SELECT * FROM carexperiencia WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;		
	}

          //Implementar un método para listar las preguntas de inspiradores
    public function bienestar($id_credencial){	
		$sql="SELECT * FROM carbienestar WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;		
	}

	//Implementar un método para listar datos del sofi
    public function sofi($identificacion,$periodo){	
		$sql="SELECT * FROM creditos_control WHERE cedula= :identificacion and periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":identificacion", $identificacion);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;		
	}


}

?>