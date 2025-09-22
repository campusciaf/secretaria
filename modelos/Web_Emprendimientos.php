<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Web_Emprendimientos
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function listar()
	{
		global $mbd;
		$sql = "SELECT * FROM `web_emprendimientos` ORDER BY `web_emprendimientos`.`id_Web_emprendimientos` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar el id del emprendimiento
	public function mostrar_editar($id_web_emprendimientos)
	{

		$sql = "SELECT * FROM `web_emprendimientos` WHERE `id_web_emprendimientos` = :id_web_emprendimientos";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_emprendimientos", $id_web_emprendimientos);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementamos metodo para insertar los emprendimiento
	public function insertar($nombre_emprendimiento, $nombre_emprendedor, $descripcion_emprendimiento, $telefono_contacto, $imagen_emprendimiento, $estado_emprendimiento, $fecha, $hora, $id_usuario)
	{

		$sql = "INSERT INTO `web_emprendimientos`(`nombre_emprendimiento`, `nombre_emprendedor`, `descripcion_emprendimiento`, `telefono_contacto`, `imagen_emprendimiento`,`estado_emprendimiento`, `fecha_publicacion`, `hora_publicacion`, `id_usuario`) VALUES ('$nombre_emprendimiento','$nombre_emprendedor','$descripcion_emprendimiento','$telefono_contacto','$imagen_emprendimiento','$estado_emprendimiento','$fecha','$hora','$id_usuario')";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


	//Implementamos un método para editar los emprendimiento
	public function editaremprendimiento($id_web_emprendimientos_editar, $nombre_emprendimiento, $nombre_emprendedor, $descripcion_emprendimiento, $telefono_contacto, $imagen_emprendimiento_editar)
	{
		$sql = "UPDATE `web_emprendimientos` SET `nombre_emprendimiento` = '$nombre_emprendimiento', `nombre_emprendedor` = '$nombre_emprendedor', `descripcion_emprendimiento` = '$descripcion_emprendimiento', `telefono_contacto` = '$telefono_contacto', `imagen_emprendimiento` = '$imagen_emprendimiento_editar' WHERE `id_web_emprendimientos` = $id_web_emprendimientos_editar";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}

	public function eliminarEmperendimiento($id_web_emprendimientos)
	{
		$sql = "DELETE FROM web_emprendimientos WHERE id_web_emprendimientos= :id_web_emprendimientos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_emprendimientos", $id_web_emprendimientos);
		$consulta->execute();
	}
	public function desactivarEmperendimiento($id_web_emprendimientos)
	{
		$sql = "UPDATE web_emprendimientos SET estado_emprendimiento='0' WHERE id_web_emprendimientos= :id_web_emprendimientos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_emprendimientos", $id_web_emprendimientos);
		$consulta->execute();
	}
	public function activarEmperendimiento($id_web_emprendimientos)
	{
		$sql = "UPDATE web_emprendimientos SET estado_emprendimiento='1' WHERE id_web_emprendimientos= :id_web_emprendimientos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_emprendimientos", $id_web_emprendimientos);
		$consulta->execute();
	}
}
