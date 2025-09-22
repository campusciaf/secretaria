<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Web_Calidad_Crecimiento
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	public function mostrarcalidad(){	
		global $mbd;
		$sql="SELECT * FROM `web_calidad_crecimiento` ORDER BY `web_calidad_crecimiento`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar el id del calidad
	public function mostrar_calidad($id_web_calidad_crecimiento){

		$sql = "SELECT * FROM `web_calidad_crecimiento` WHERE `id_web_calidad_crecimiento` = :id_web_calidad_crecimiento";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_calidad_crecimiento", $id_web_calidad_crecimiento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementamos metodo para insertar los calidad
	public function insertarcalidad($id_web_calidad_crecimiento , $titulo_calidad, $imagen_calidad, $url_calidad, $ip, $hora, $fecha, $id_usuario,$estado){

		$sql="INSERT INTO `web_calidad_crecimiento`(`id_web_calidad_crecimiento`, `titulo_calidad`, `imagen_calidad`, `url_calidad`, `ip`, `hora`, `fecha`, `id_usuario`, `estado`) VALUES (NULL,'$titulo_calidad','$imagen_calidad','$url_calidad','$ip','$hora','$fecha','$id_usuario','$estado')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	
	//Implementamos un método para editar los calidad
	public function editarcalidad($titulo_calidad, $imagen_calidad, $url_calidad, $id_web_calidad_crecimiento){
		$sql="UPDATE `web_calidad_crecimiento` SET `titulo_calidad` = '$titulo_calidad', `imagen_calidad` = '$imagen_calidad', `url_calidad` = '$url_calidad', `id_web_calidad_crecimiento` = '$id_web_calidad_crecimiento' WHERE `id_web_calidad_crecimiento` = $id_web_calidad_crecimiento";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}
	public function eliminarCalidad($id_web_calidad_crecimiento)
	{
		$sql="DELETE FROM web_calidad_crecimiento WHERE id_web_calidad_crecimiento= :id_web_calidad_crecimiento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_calidad_crecimiento", $id_web_calidad_crecimiento);
		$consulta->execute();
	
	}
	public function desactivar_calidad($id_web_calidad_crecimiento)
	{
		$sql="UPDATE web_calidad_crecimiento SET estado='0' WHERE id_web_calidad_crecimiento= :id_web_calidad_crecimiento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_calidad_crecimiento", $id_web_calidad_crecimiento);
		$consulta->execute();
	
	}

	public function activar_calidad($id_web_calidad_crecimiento)
	{
		$sql="UPDATE web_calidad_crecimiento SET estado='1' WHERE id_web_calidad_crecimiento= :id_web_calidad_crecimiento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_calidad_crecimiento", $id_web_calidad_crecimiento);
		$consulta->execute();
	
	}


}

?>