<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class HorarioOcupacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	//Implementar un método para listar las horas del dia
	public function traerSalones($sede)
	{
		$sql="SELECT * FROM salones WHERE sede= :sede";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":sede", $sede);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    public function verificarhorario($salon,$dia,$hora,$periodo){
			
		$sql="SELECT * FROM docente_grupos WHERE salon= :salon AND dia= :dia AND (:hora BETWEEN hora AND hasta) and periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":salon", $salon);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
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
    //Implementar un método para listar las sedes
	public function selectSede()
	{	
		$sql="SELECT DISTINCT sede  FROM salones ";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los salones
	public function selectSalon()
	{	
		$sql="SELECT * FROM salones";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	




}

?>