<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Web_Aliados
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	public function mostraraliados(){	
		global $mbd;
		$sql="SELECT * FROM `web_aliados` ORDER BY `web_aliados`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar el id del aliados
	public function mostrar_aliados($id_web_aliados){

		$sql = "SELECT * FROM `web_aliados` WHERE `id_web_aliados` = :id_web_aliados";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_aliados", $id_web_aliados);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos metodo para insertar los aliados
	public function insertaraliados($id_web_aliados, $nombre_aliado, $imagen_aliado, $url_aliado, $ip, $hora, $fecha, $id_usuario){

		$sql="INSERT INTO `web_aliados`(`id_web_aliados`, `nombre_aliado`, `imagen_aliado`, `url_aliado`, `ip`, `hora`, `fecha`, `id_usuario`) VALUES (NULL,'$nombre_aliado','$imagen_aliado','$url_aliado','$ip','$hora','$fecha','$id_usuario')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	
	//Implementamos un método para editar los aliados
	public function editaraliados($nombre_aliado, $imagen_aliado, $url_aliado, $id_web_aliados){
		$sql="UPDATE `web_aliados` SET `nombre_aliado` = '$nombre_aliado', `imagen_aliado` = '$imagen_aliado', `url_aliado` = '$url_aliado', `id_web_aliados` = '$id_web_aliados' WHERE `id_web_aliados` = $id_web_aliados";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

	public function eliminarAliado($id_web_aliados)
	{
		$sql="DELETE FROM web_aliados WHERE id_web_aliados= :id_web_aliados";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_aliados", $id_web_aliados);
		$consulta->execute();
	
	}

	public function desactivar_aliados($id_web_aliados)
	{
		$sql="UPDATE web_aliados SET estado='0' WHERE id_web_aliados= :id_web_aliados";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_aliados", $id_web_aliados);
		$consulta->execute();
	
	}

	public function activar_aliados($id_web_aliados)
	{
		$sql="UPDATE web_aliados SET estado='1' WHERE id_web_aliados= :id_web_aliados";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_aliados", $id_web_aliados);
		$consulta->execute();
	
	}

}

?>