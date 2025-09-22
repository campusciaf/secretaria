<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Web_Convenios
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	public function mostrarconvenios(){	
		global $mbd;
		$sql="SELECT * FROM `web_bienestar_convenios` ORDER BY `web_bienestar_convenios`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar el id del banner
	public function mostrar_convenio($id_web_convenio){

		$sql = "SELECT * FROM `web_bienestar_convenios` WHERE `id_web_convenio` = :id_web_convenio";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_convenio", $id_web_convenio);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos metodo para insertar el banner
	public function insertarconvenio($id_web_convenio, $imagen_convenio, $nombre_convenio, $descripcion_convenio, $url_convenio,$id_bienestar_programas, $estado, $ip, $hora, $fecha, $id_usuario){

		$sql="INSERT INTO `web_bienestar_convenios`(`id_web_convenio`, `imagen_convenio`, `nombre_convenio`, `descripcion_convenio`, `url_convenio`,`id_bienestar_programas`, `estado`, `ip`, `hora`, `fecha`, `id_usuario`) VALUES (NULL,'$imagen_convenio','$nombre_convenio','$descripcion_convenio','$url_convenio','$id_bienestar_programas','$estado','$ip','$hora','$fecha','$id_usuario')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
		

	//Implementamos un método para editar el permiso del docente
	public function editarconvenio($imagen_convenio,$nombre_convenio,$descripcion_convenio,$url_convenio,$id_bienestar_programas, $id_web_convenio){
		$sql="UPDATE `web_bienestar_convenios` SET `imagen_convenio` = '$imagen_convenio', `nombre_convenio` = '$nombre_convenio', `descripcion_convenio` = '$descripcion_convenio', `url_convenio` = '$url_convenio' , `id_bienestar_programas` = '$id_bienestar_programas' WHERE `id_web_convenio` = $id_web_convenio";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}


	public function eliminarConvenio($id_web_convenio)
	{
		$sql="DELETE FROM web_bienestar_convenios WHERE id_web_convenio= :id_web_convenio";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_convenio", $id_web_convenio);
		$consulta->execute();
	
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



	public function desactivar_convenio($id_web_convenio)
	{
		$sql="UPDATE web_bienestar_convenios SET estado='0' WHERE id_web_convenio= :id_web_convenio";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_convenio", $id_web_convenio);
		$consulta->execute();
	
	}

	public function activar_convenio($id_web_convenio)
	{
		$sql="UPDATE web_bienestar_convenios SET estado='1' WHERE id_web_convenio= :id_web_convenio";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_convenio", $id_web_convenio);
		$consulta->execute();
	
	}
}

?>