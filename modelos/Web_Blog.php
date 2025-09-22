<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Web_Blog
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	public function mostrarnoticias(){	
		global $mbd;
		$sql="SELECT * FROM `web_blog` ORDER BY `web_blog`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar el id del banner
	public function mostrar_blog($id_blog){

		$sql = "SELECT * FROM `web_blog` WHERE `id_blog` = :id_blog";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_blog", $id_blog);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos metodo para insertar el banner

	public function insertarblog($id_blog, $img_blog, $titulo_blog, $subtitulo_blog, $contenido_blog, $fecha_blog, $link_blog,$estado, $ip, $hora, $fecha, $id_usuario, $material){

		$sql="INSERT INTO `web_blog`(`id_blog`, `blog_img`, `titulo_blog`, `subtitulo_blog`, `contenido_blog`, `fecha_blog`, `link_blog`, `estado`, `ip`, `hora`, `fecha`, `id_usuario`, `material`) VALUES (NULL,'$img_blog','$titulo_blog','$subtitulo_blog','$contenido_blog','$fecha_blog ','$link_blog','$estado','$ip','$hora','$fecha','$id_usuario','$material')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


	//Implementamos metodo para insertar el banner
	public function insertarblogimagenyvideo($id_blog, $url_video, $blog_img, $titulo_blog, $subtitulo_blog, $contenido_blog, $fecha_blog,$link_blog_video, $estado, $ip, $hora, $fecha, $id_usuario, $material){

		$sql="INSERT INTO `web_blog`(`id_blog`, `url_video`,`blog_img`, `titulo_blog`, `subtitulo_blog`, `contenido_blog`, `fecha_blog`, `link_blog`,`estado`, `ip`, `hora`, `fecha`, `id_usuario`, `material`) VALUES (NULL,'$url_video','$blog_img','$titulo_blog','$subtitulo_blog','$contenido_blog','$fecha_blog ','$link_blog_video','$estado','$ip','$hora','$fecha','$id_usuario','$material')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
		
	//Implementamos un método para editar el permiso del docente
	public function editarblog($url_video,$blog_img,$titulo_blog,$subtitulo_blog,$contenido_blog, $id_blog, $link_blog){
		$sql="UPDATE `web_blog` SET `url_video` = '$url_video',`blog_img` = '$blog_img', `titulo_blog` = '$titulo_blog', `subtitulo_blog` = '$subtitulo_blog', `contenido_blog` = '$contenido_blog' , `link_blog` = '$link_blog' WHERE `id_blog` = $id_blog";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

	//Implementamos un método para editar el permiso del docente
	public function editarblogimagen($blog_img,$titulo_blog,$subtitulo_blog,$contenido_blog, $id_blog, $link_blog){
		$sql="UPDATE `web_blog` SET `blog_img` = '$blog_img', `titulo_blog` = '$titulo_blog', `subtitulo_blog` = '$subtitulo_blog', `contenido_blog` = '$contenido_blog' , `link_blog` = '$link_blog'  WHERE `id_blog` = $id_blog";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

	public function eliminarBlog($id_blog)
	{
		$sql="DELETE FROM web_blog WHERE id_blog= :id_blog";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_blog", $id_blog);
		$consulta->execute();
	
	}
	
	public function noticias_categoria()
	{	
		$sql="SELECT * FROM web_categorias_blog";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}

	public function desactivar_blog($id_blog)
	{
		$sql="UPDATE web_blog SET estado='0' WHERE id_blog= :id_blog";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_blog", $id_blog);
		$consulta->execute();
	
	}


	public function activar_noticia($id_blog)
	{
		$sql="UPDATE web_blog SET estado='1' WHERE id_blog= :id_blog";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_blog", $id_blog);
		$consulta->execute();
	
	}

		//Implementamos un método para activar categorías
	public function seleccionar_video($id_blog)
	{
		$sql="UPDATE web_blog SET material='1' WHERE id_blog= :id_blog";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_blog", $id_blog);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para desactivar categorías
	public function seleccionar_imagen($id_blog)
	{
		$sql="UPDATE web_blog SET material='2' WHERE id_blog= :id_blog";
		//return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_blog", $id_blog);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	public function cambiar_formato($id_blog)
	{
		$sql = "UPDATE web_blog SET material='2' WHERE :id_blog= :id_blog";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_blog", $id_blog);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


}

?>