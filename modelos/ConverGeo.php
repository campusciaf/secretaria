<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ConverGeo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
public function listar(){
		$sql="SELECT * FROM estudiantes_datos_personales WHERE latitud IS NULL and muni_residencia !='' and direccion !='' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
	
	//Implementamos un método para editar registros
public function actualizar($id_estudiante,$latitud,$longitud)
	{
		$sql="UPDATE estudiantes_datos_personales SET latitud='$latitud', longitud='$longitud' WHERE id_estudiante='$id_estudiante'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();

	}

	
}

?>



