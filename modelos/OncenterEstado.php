<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class OncenterEstado
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO on_estado (nombre_estado,arreglo) VALUES ('$nombre','1')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
		//Implementamos un método para editar registros
	public function editar($id_estado,$nombre)
	{
		$sql="UPDATE on_estado SET nombre_estado='$nombre' WHERE id_estado='$id_estado'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_estado", $id_estado);
		return $consulta->execute();

	}
	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM on_estado WHERE arreglo=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_estado)
	{
		$sql="SELECT * FROM on_estado WHERE id_estado= :id_estado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado", $id_estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	
		//Implementamos un método para desactivar estado
	public function desactivar($id_estado)
	{
		$sql="UPDATE on_estado SET estado='0' WHERE id_estado= :id_estado";
		//return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado", $id_estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	
		//Implementamos un método para activar estado
	public function activar($id_estado)
	{
		$sql="UPDATE on_estado SET estado='1' WHERE id_estado= :id_estado";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado", $id_estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para eliminar los datos de un registro 
	public function eliminar($id_estado)
	{
		$sql="DELETE FROM on_estado WHERE id_estado= :id_estado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado", $id_estado);
		$consulta->execute();
	
	}

}

?>