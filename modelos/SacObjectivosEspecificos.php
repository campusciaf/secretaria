<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class SacObjectivosEspecificos
{
	//Implementamos nuestro constructor
	public function __construct() {

	}

	//Implementamos un método para agregar un objetivo general
	public function insertarobjetivoespecifico($nombre_objetivo_especifico, $id_objetivo)
	{
		global $mbd;
		$sql="INSERT INTO `sac_objetivo_especifico`(`nombre_objetivo_especifico`, `id_objetivo`) VALUES('$nombre_objetivo_especifico', $id_objetivo)";
		//echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar registros
	public function editarobjetivoespecifico($id_objetivo_especifico, $nombre_objetivo_especifico)
	{
		global $mbd;
		$sql="UPDATE sac_objetivo_especifico SET id_objetivo_especifico='$id_objetivo_especifico', nombre_objetivo_especifico='$nombre_objetivo_especifico' WHERE id_objetivo_especifico='$id_objetivo_especifico'";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

}

?>