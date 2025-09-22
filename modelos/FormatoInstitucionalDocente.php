<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class FormatoInstitucionalDocente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

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

	
}

?>