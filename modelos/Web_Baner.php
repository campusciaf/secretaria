<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Web_Baner
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	//Muestra el total de acciones por proyecto 
	public function mostrarbanner(){	
		global $mbd;
		$sql="SELECT * FROM `web_baner`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para mostrar el id del banner
	public function mostrar_banner($id_banner){

		$sql = "SELECT * FROM `web_baner` WHERE `id_banner` = :id_banner";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_banner", $id_banner);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementamos metodo para insertar el banner
	public function insertarbanner($img_pc,$img_movil,$titulo,$subtitulo,$descripcion,$ruta_url,$fecha,$hora,$ip,$id_usuario)
	{
		$sql="INSERT INTO web_baner (img_pc,img_movil,titulo,subtitulo,descripcion,ruta_url,fecha,hora,ip,id_usuario) VALUES ('$img_pc','$img_movil','$titulo','$subtitulo','$descripcion','$ruta_url','$fecha','$hora','$ip','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	public function editarbanner($img_pc,$img_movil,$titulo,$subtitulo,$descripcion,$ruta_url ,$id_banner){
		$sql="UPDATE `web_baner` SET `img_pc` = '$img_pc', `img_movil` = '$img_movil', `titulo` = '$titulo', `subtitulo` = '$subtitulo', `descripcion` = '$descripcion' , `ruta_url` = '$ruta_url' WHERE `id_banner` = $id_banner";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

	public function eliminarBaner($id_banner)
	{
		$sql="DELETE FROM web_baner WHERE id_banner= :id_banner";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_banner", $id_banner);
		$consulta->execute();
	
	}


}

?>