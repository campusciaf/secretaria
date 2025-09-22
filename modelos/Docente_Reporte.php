<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Docente_Reporte
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


	public function listarGrupos($periodo)
	{
	
		$sql = "SELECT * FROM docente_grupos WHERE periodo = :periodo";
		
		
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar las horas del dia
	public function listar_docentes($id_usuario)
	{
		$sql="SELECT * FROM docente WHERE id_usuario= :id_usuario and usuario_condicion= 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function MostrarCargoDocentes($documento_docente, $periodo)
	{
		global $mbd;
		$sql = "SELECT * FROM contrato_docente WHERE documento_docente = :documento_docente AND periodo = :periodo ORDER BY fecha_realizo DESC LIMIT 1";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC); 
		return $resultado;
	}

		
	// //Implementar un método para listar los registros
	public function listarGrupos_3($id_docente,$periodo)
	{
		$sql="SELECT * FROM docente_grupos WHERE id_docente= :id_docente AND periodo= :periodo";
		// echo $sql;
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":id_docente", $id_docente);
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

		public function periodoactual()
		{
			$sql = "SELECT periodo_actual FROM periodo_actual";
	
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}
































	
	

}

?>