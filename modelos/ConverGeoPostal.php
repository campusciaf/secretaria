<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ConverGeoPostal
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
public function listar(){
		$sql="SELECT * FROM estudiantes_datos_personales WHERE latitud !='' and cod_postal='' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
	
	//Implementamos un método para editar registros
public function actualizar($id_estudiante,$cod_postal)
	{
		$sql="UPDATE estudiantes_datos_personales SET cod_postal='$cod_postal' WHERE id_estudiante='$id_estudiante'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();

	}


	
}

?>



