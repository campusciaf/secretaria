<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class OncenterConocio
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$opcion)
	{
		$sql="INSERT INTO on_conocio (nombre,opcion) VALUES ('$nombre','$opcion')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
		//Implementamos un método para editar registros
	public function editar($id_conocio,$nombre,$opcion)
	{
		$sql="UPDATE on_conocio SET nombre='$nombre', opcion='$opcion' WHERE id_conocio='$id_conocio'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_conocio", $id_conocio);
		return $consulta->execute();

	}
	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM on_conocio";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_conocio)
	{
		$sql="SELECT * FROM on_conocio WHERE id_conocio= :id_conocio";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_conocio", $id_conocio);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	
		//Implementamos un método para desactivar conocio
	public function desactivar($id_conocio)
	{
		$sql="UPDATE on_conocio SET estado='0' WHERE id_conocio= :id_conocio";
		//return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_conocio", $id_conocio);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	
		//Implementamos un método para activar conocio
	public function activar($id_conocio)
	{
		$sql="UPDATE on_conocio SET estado='1' WHERE id_conocio= :id_conocio";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_conocio", $id_conocio);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para eliminar los datos de un registro 
	public function eliminar($id_conocio)
	{
		$sql="DELETE FROM on_conocio WHERE id_conocio= :id_conocio";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_conocio", $id_conocio);
		$consulta->execute();
	
	}
	
		//Implementar un método para listar los tipos documentos
	public function selectOpcion()
	{	
		$sql="SELECT * FROM on_opcion";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	

}

?>