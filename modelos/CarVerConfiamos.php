<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CarVerConfiamos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function listar(){	
		$sql="SELECT * FROM carconfiamos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}

		
	//Implementar un método para listar los registros
	public function listar2($valor){	
		$sql="SELECT * FROM carconfiamos cro INNER JOIN estudiantes est ON cro.id_credencial=est.id_credencial  WHERE est.escuela_ciaf= :valor";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":valor", $valor);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	

	//Implementar un método para lsitar los datos del estudiante
	public function datosestudiante($id_credencial){	
		$sql="SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes est ON ce.id_credencial=est.id_credencial INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial = edp.id_credencial WHERE ce.id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}

	
			//Implementar un método para mostrar los datos de un registro a modificar
	public function respuesta($id_credencial)
	{
		$sql="SELECT * FROM carconfiamos WHERE id_credencial= :id_credencial";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	

	public function fechaesp($date) {
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
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