<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Ejes
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_ejes,$periodo,$objetivo)
	{
		$sql="INSERT INTO ejes (nombre_ejes,periodo,objetivo)
		VALUES ('$nombre_ejes','$periodo','$objetivo')";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
		

	}

	//Implementamos un método para editar registros
	public function editar($id_ejes,$nombre_ejes,$periodo,$objetivo)
	{
		$sql="UPDATE ejes SET nombre_ejes='$nombre_ejes',periodo='$periodo',objetivo='$objetivo' WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		return $consulta->execute();

		
		
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_ejes)
	{
		$sql="SELECT * FROM ejes WHERE id_ejes= :id_ejes";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para eliminar los datos de un registro 
	public function eliminar($id_ejes)
	{
		$sql="DELETE FROM ejes WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
	
	}

	//Implementar un método para listar los registros
	public function listar()
	{	
		$sql="SELECT * FROM ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
	//Implementar un método para listar los registros en un select
	// public function select()
	// {	
	// 	$sql="SELECT * FROM ejes";
	// 	return ejecutarConsulta($sql);		
	// }


}

?>