<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class OncenterMedio
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO on_medio (nombre) VALUES ('$nombre')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
		//Implementamos un método para editar registros
	public function editar($id,$nombre)
	{
		$sql="UPDATE on_medio SET nombre='$nombre' WHERE id='$id'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();

	}
	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM on_medio";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_medio)
	{
		$sql="SELECT * FROM on_medio WHERE id= :id";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id_medio);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	
		//Implementamos un método para desactivar programa
	public function desactivar($id)
	{
		$sql="UPDATE on_medio SET estado='0' WHERE id= :id";
		//return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	
		//Implementamos un método para activar programa
	public function activar($id)
	{
		$sql="UPDATE on_medio SET estado='1' WHERE id= :id";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para eliminar los datos de un registro 
	public function eliminar($id)
	{
		$sql="DELETE FROM on_medio WHERE id= :id";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
	
	}


}

?>