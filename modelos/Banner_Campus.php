<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Banner_Campus
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	public function mostrarimagen(){	
		global $mbd;
		$sql="SELECT * FROM `banner_campus` ORDER BY `banner_campus`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar el id del banner
	public function mostrar_imagen($id_banner){

		$sql = "SELECT * FROM `banner_campus` WHERE `id_banner` = :id_banner";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_banner", $id_banner);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos metodo para insertar el banner
	public function insertarimagen($id_banner, $imagen_banner, $estado, $ip, $hora, $fecha, $id_usuario){

		$sql="INSERT INTO `banner_campus`(`id_banner`, `imagen_banner`, `estado`, `ip`, `hora`, `fecha`, `id_usuario`) VALUES (NULL,'$imagen_banner','$estado','$ip','$hora','$fecha','$id_usuario')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
		

	//Implementamos un método para editar el permiso del docente
	public function editarimagen($imagen_banner, $id_banner){
		$sql="UPDATE `banner_campus` SET `imagen_banner` = '$imagen_banner' WHERE `id_banner` = $id_banner";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

	public function eliminarImagen($id_banner){
		$sql_eliminar = "DELETE FROM banner_campus WHERE id_banner=:id_banner";

		global $mbd;
		$consulta_eliminar = $mbd->prepare($sql_eliminar);
		$consulta_eliminar->execute(array(
			"id_banner" => $id_banner));
		return $consulta_eliminar;
	}

	public function bienestar_programas()
	{	
		$sql="SELECT * FROM web_bienestar_programas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}

	//Implementamos un método para desactivar los convenios
	public function desactivar_convenio($id_banner)
	{
		$sql="UPDATE banner_campus SET estado='0' WHERE id_banner= :id_banner";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_banner", $id_banner);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

	//Implementamos un método para activar los convenios
	public function activar_convenio($id_banner)
	{
		$sql="UPDATE banner_campus SET estado='1' WHERE id_banner= :id_banner";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_banner", $id_banner);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}

?>