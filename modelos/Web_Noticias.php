<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Web_Noticias
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	public function mostrarnoticias(){	
		global $mbd;
		$sql="SELECT * FROM `web_noticias` ORDER BY `web_noticias`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar el id del banner
	public function mostrar_noticias($id_noticias){

		$sql = "SELECT * FROM `web_noticias` WHERE `id_noticias` = :id_noticias";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_noticias", $id_noticias);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos metodo para insertar el banner
	public function insertarnoticias($id_noticias, $img_noticias, $titulo_noticias, $subtitulo_noticias, $contenido_noticias, $fecha_noticias, $id_categoria_noticias,$link_noticia,$estado, $ip, $hora, $fecha, $id_usuario, $material){

		$sql="INSERT INTO `web_noticias`(`id_noticias`, `img_noticias`, `titulo_noticias`, `subtitulo_noticias`, `contenido_noticias`, `fecha_noticias`, `id_categoria_noticias`, `link_noticia`,`estado`, `ip`, `hora`, `fecha`, `id_usuario`, `material`) VALUES (NULL,'$img_noticias','$titulo_noticias','$subtitulo_noticias','$contenido_noticias','$fecha_noticias ','$id_categoria_noticias','$link_noticia','$estado','$ip','$hora','$fecha','$id_usuario','$material')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


	//Implementamos metodo para insertar el banner
	public function insertarnoticiasimagenyvideo($id_noticias, $url_video, $img_noticias, $titulo_noticias, $subtitulo_noticias, $contenido_noticias, $fecha_noticias, $id_categoria_noticias,$link_noticia_video, $estado, $ip, $hora, $fecha, $id_usuario, $material){

		$sql="INSERT INTO `web_noticias`(`id_noticias`, `url_video`,`img_noticias`, `titulo_noticias`, `subtitulo_noticias`, `contenido_noticias`, `fecha_noticias`, `id_categoria_noticias`,`link_noticia`,`estado`, `ip`, `hora`, `fecha`, `id_usuario`, `material`) VALUES (NULL,'$url_video','$img_noticias','$titulo_noticias','$subtitulo_noticias','$contenido_noticias','$fecha_noticias ','$id_categoria_noticias','$link_noticia_video','$estado','$ip','$hora','$fecha','$id_usuario','$material')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
		
	//Implementamos un método para editar el permiso del docente
	public function editarnoticias($url_video,$img_noticias,$titulo_noticias,$subtitulo_noticias,$contenido_noticias,$id_categoria_noticias, $id_noticias, $link_noticia){
		$sql="UPDATE `web_noticias` SET `url_video` = '$url_video',`img_noticias` = '$img_noticias', `titulo_noticias` = '$titulo_noticias', `subtitulo_noticias` = '$subtitulo_noticias', `contenido_noticias` = '$contenido_noticias' , `id_categoria_noticias` = '$id_categoria_noticias' , `link_noticia` = '$link_noticia' WHERE `id_noticias` = $id_noticias";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

	//Implementamos un método para editar el permiso del docente
	public function editarnoticiasimagen($img_noticias,$titulo_noticias,$subtitulo_noticias,$contenido_noticias,$id_categoria_noticias, $id_noticias, $link_noticia){
		$sql="UPDATE `web_noticias` SET `img_noticias` = '$img_noticias', `titulo_noticias` = '$titulo_noticias', `subtitulo_noticias` = '$subtitulo_noticias', `contenido_noticias` = '$contenido_noticias' , `id_categoria_noticias` = '$id_categoria_noticias', `link_noticia` = '$link_noticia'  WHERE `id_noticias` = $id_noticias";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

	public function eliminarNoticia($id_noticias)
	{
		$sql="DELETE FROM web_noticias WHERE id_noticias= :id_noticias";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_noticias", $id_noticias);
		$consulta->execute();
	
	}
	
	public function noticias_categoria()
	{	
		$sql="SELECT * FROM web_categorias_noticias";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}

	public function desactivar_noticia($id_noticias)
	{
		$sql="UPDATE web_noticias SET estado='0' WHERE id_noticias= :id_noticias";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_noticias", $id_noticias);
		$consulta->execute();
	
	}


	public function activar_noticia($id_noticias)
	{
		$sql="UPDATE web_noticias SET estado='1' WHERE id_noticias= :id_noticias";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_noticias", $id_noticias);
		$consulta->execute();
	
	}

		//Implementamos un método para activar categorías
	public function seleccionar_video($id_noticias)
	{
		$sql="UPDATE web_noticias SET material='1' WHERE id_noticias= :id_noticias";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_noticias", $id_noticias);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para desactivar categorías
	public function seleccionar_imagen($id_noticias)
	{
		$sql="UPDATE web_noticias SET material='2' WHERE id_noticias= :id_noticias";
		//return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_noticias", $id_noticias);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

	public function Extension_Categoria()
	{	
		$sql="SELECT * FROM web_extension";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}

	 public function cambiar_formato($id_noticias)
	 {
		 $sql = "UPDATE web_noticias SET material='2' WHERE :id_noticias= :id_noticias";
		 //return ejecutarConsulta($sql);
		 global $mbd;
		 $consulta = $mbd->prepare($sql);
		 $consulta->bindParam(":id_noticias", $id_noticias);
		 $consulta->execute();
		 $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		 return $resultado;
	 }


}

?>