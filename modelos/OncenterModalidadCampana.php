<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class OncenterModalidadCampana
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO on_modalidad_campana (nombre) VALUES ('$nombre')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
		//Implementamos un método para editar registros
	public function editar($id_modalidad_campana,$nombre)
	{
		$sql="UPDATE on_modalidad_campana SET nombre='$nombre' WHERE id_modalidad_campana='$id_modalidad_campana'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();

	}
	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM on_modalidad_campana";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_modalidad_campana)
	{
		$sql="SELECT * FROM on_modalidad_campana WHERE id_modalidad_campana= :id_modalidad_campana";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_modalidad_campana", $id_modalidad_campana);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	
		//Implementamos un método para desactivar programa
	public function desactivar($id_modalidad_campana)
	{
		$sql="UPDATE on_modalidad_campana SET estado='0' WHERE id_modalidad_campana= :id_modalidad_campana";
		//return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_modalidad_campana", $id_modalidad_campana);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	
		//Implementamos un método para activar programa
	public function activar($id_modalidad_campana)
	{
		$sql="UPDATE on_modalidad_campana SET estado='1' WHERE id_modalidad_campana= :id_modalidad_campana";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_modalidad_campana", $id_modalidad_campana);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para eliminar los datos de un registro 
	public function eliminar($id_modalidad_campana)
	{
		$sql="DELETE FROM on_modalidad_campana WHERE id_modalidad_campana= :id_modalidad_campana";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_modalidad_campana", $id_modalidad_campana);
		$consulta->execute();
	
	}


}

?>