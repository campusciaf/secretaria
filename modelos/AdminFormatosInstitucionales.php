<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class AdminFormatosInstitucionales
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($formato_nombre,$archivo,$fecha,$hora)
	{
		$sql="INSERT INTO formatos (formato_nombre,formato_archivo,fecha,hora)
		VALUES ('$formato_nombre','$archivo','$fecha','$hora')";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para editar registros
	public function editar($id_formato,$formato_nombre,$archivo)
	{
		$sql="UPDATE formatos SET formato_nombre='$formato_nombre',formato_archivo='$archivo' WHERE id_formato= :id_formato";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_formato", $id_formato);
		return $consulta->execute();


	}




	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_formato)
	{
		$sql="SELECT id_formato,formato_nombre,formato_archivo FROM formatos WHERE id_formato= :id_formato";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_formato", $id_formato);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM formatos";	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}
	//Implementar un método para eliminar archivo 
	public function eliminarFormato($id_formato)
	{
		$sql="DELETE FROM formatos WHERE id_formato= :id_formato";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_formato", $id_formato);
		return $consulta->execute();

	}
	

	
}

?>