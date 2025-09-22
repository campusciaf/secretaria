<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class CajaHerramientasCategoria
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	//Muestra el total de las categorias
	public function mostrarcategoria(){	
		global $mbd;
		$sql="SELECT * FROM `software_categoria`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//inserta las categorias 
	public function insertarCategoria($nombre_categoria, $id_software_categoria){
		global $mbd;
		$sql="INSERT INTO `software_categoria`(`nombre_categoria`, `id_software_categoria`) VALUES('$nombre_categoria', NULL)";
		//echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//edita la categoria
	public function editarCategoria($id_software_categoria, $nombre_categoria){
		$sql="UPDATE `software_categoria` SET `nombre_categoria` = :nombre_categoria  WHERE `id_software_categoria` = :id_software_categoria";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_software_categoria", $id_software_categoria);
		$consulta->bindParam(":nombre_categoria", $nombre_categoria);
		$consulta->execute();
		return $consulta;	
	}


	// muestra la categoria por id 
	public function mostrar_categoria($id_software_categoria){
		global $mbd;
		$sql = "SELECT * FROM `software_categoria` WHERE `id_software_categoria` = :id_software_categoria";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_software_categoria", $id_software_categoria);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}

	//eliminamos la categoria 
	public function eliminarcategoria($id_software_categoria){
		$sql = "DELETE FROM `software_categoria` WHERE `id_software_categoria` = :id_software_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_software_categoria", $id_software_categoria);
		return $consulta->execute();
	}


}

?>