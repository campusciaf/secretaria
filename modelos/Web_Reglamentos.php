<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Web_Reglamentos{
	//Implementamos nuestro constructor
	public function __construct() {}
	public function mostrarreglamento()
	{
		global $mbd;
		$sql = "SELECT * FROM `web_reglamentos` ORDER BY `web_reglamentos`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las categorias de los reglamentos
	public function selectCategoriasReglamentos()
	{
		$sql = "SELECT * FROM web_categoria_reglamentos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar el id del reglamento
	public function mostrar_reglamento($id_web_reglamentos)
	{
		$sql = "SELECT * FROM `web_reglamentos` WHERE `id_web_reglamentos` = :id_web_reglamentos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_reglamentos", $id_web_reglamentos);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos metodo para insertar los reglamento
	public function insertarreglamento($id_web_reglamentos, $nombre_reglamento, $url_reglamento, $ip, $hora, $fecha, $id_usuario, $id_categoria_reglamento)
	{
		$sql = "INSERT INTO `web_reglamentos`(`id_web_reglamentos`, `nombre_reglamento`, `url_reglamento`, `ip`, `hora`, `fecha`, `id_usuario`,`id_categoria_reglamento`) VALUES (NULL,'$nombre_reglamento','$url_reglamento','$ip','$hora','$fecha','$id_usuario','$id_categoria_reglamento')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar los reglamento
	public function editarreglamento($nombre_reglamento, $url_reglamento, $id_web_reglamentos, $id_categoria_reglamento)
	{
		$sql = "UPDATE `web_reglamentos` SET `nombre_reglamento` = '$nombre_reglamento', `url_reglamento` = '$url_reglamento', `id_web_reglamentos` = '$id_web_reglamentos', `id_categoria_reglamento` = '$id_categoria_reglamento' WHERE `id_web_reglamentos` = $id_web_reglamentos";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	public function eliminarreglamento($id_web_reglamentos)
	{
		$sql = "DELETE FROM web_reglamentos WHERE id_web_reglamentos= :id_web_reglamentos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_reglamentos", $id_web_reglamentos);
		$consulta->execute();
	}
	public function desactivar_reglamento($id_web_reglamentos)
	{
		$sql = "UPDATE web_reglamentos SET estado='0' WHERE id_web_reglamentos= :id_web_reglamentos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_reglamentos", $id_web_reglamentos);
		$consulta->execute();
	}
	public function activar_reglamento($id_web_reglamentos)
	{
		$sql = "UPDATE web_reglamentos SET estado='1' WHERE id_web_reglamentos= :id_web_reglamentos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_reglamentos", $id_web_reglamentos);
		$consulta->execute();
	}
	//Implementamos un método para traer el nombre de la categoria a la que pertenece el reglamento
	public function mostrarnombrereglamento($id_categoria_reglamento)
	{
		$sql = "SELECT * FROM web_categoria_reglamentos WHERE id_categoria_reglamento= :id_categoria_reglamento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_categoria_reglamento", $id_categoria_reglamento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
