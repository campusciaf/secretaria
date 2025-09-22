<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Web_Programa_Descripcion
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	public function mostrarprogramas(){	
		global $mbd;
		$sql="SELECT * FROM web_programas INNER JOIN web_programa_descripcion ON web_programas.id_programas = `web_programa_descripcion`.`id_programas` ORDER BY `web_programa_descripcion`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los programas por id
	public function mostrar_programas_descripcion($id_web_programa_descripcion){
		$sql = "SELECT * FROM `web_programa_descripcion` WHERE `id_web_programa_descripcion` = :id_web_programa_descripcion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_programa_descripcion", $id_web_programa_descripcion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function insertarprogramas($id_web_programa_descripcion,$id_programas, $imagen_descripcion, $video_descripcion, $titulo_descripcion, $descripcion_programa, $estado, $ip, $hora, $fecha, $id_usuario){
		$sql="INSERT INTO `web_programa_descripcion`(`id_web_programa_descripcion`, `id_programas`, `imagen_descripcion`, `video_descripcion`, `titulo_descripcion`, `descripcion_programa`, `estado`, `ip`, `hora`, `fecha`, `id_usuario`) VALUES (NULL,'$id_programas','$imagen_descripcion','$video_descripcion','$titulo_descripcion','$descripcion_programa','$estado','$ip','$hora','$fecha','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function editarprogramas($imagen_descripcion, $video_descripcion,$titulo_descripcion, $descripcion_programa, $id_web_programa_descripcion,$id_programas){
		$sql="UPDATE `web_programa_descripcion` SET `imagen_descripcion` = '$imagen_descripcion',`video_descripcion` = '$video_descripcion', `titulo_descripcion` = '$titulo_descripcion', `descripcion_programa` = '$descripcion_programa', `id_programas` = '$id_programas'  WHERE `id_web_programa_descripcion` = $id_web_programa_descripcion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}
	public function noticias_categoria()
	{	
		$sql="SELECT * FROM web_programa_desempenate";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	public function noticias_categoria_programas()
	{	
		$sql="SELECT * FROM web_programas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	public function insertarprogramasdesempenate($id_programa_desempenate ,$id_programa, $nombre_desempenate){
		$sql="INSERT INTO `web_programa_desempenate`(`id_programa_desempenate`, `id_programa`, `nombre_desempenate`) VALUES (NULL,'$id_programa','$nombre_desempenate')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para mostrar los programas por id
	public function mostrar_programa_desempenate($id_programa){
		$sql = "SELECT * FROM `web_programa_desempenate` WHERE `id_programa` = :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function desempenate_editar($id_programa_desempenate){
		$sql = "SELECT * FROM `web_programa_desempenate` WHERE `id_programa_desempenate` = :id_programa_desempenate";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_desempenate", $id_programa_desempenate);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function editarprogramasdesempenate($nombre_desempenate,$id_programa_desempenate){
		$sql="UPDATE `web_programa_desempenate` SET `nombre_desempenate` = '$nombre_desempenate'  WHERE `id_programa_desempenate` = $id_programa_desempenate";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}
	//Implementar un método para mostrar el id del banner
	public function mostrar_video_programa($id_programas){
		$sql = "SELECT * FROM `web_programa_descripcion` WHERE `id_programas` = :id_programas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programas", $id_programas);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminarPrograma($id_web_programa_descripcion)
	{
		$sql="DELETE FROM web_programa_descripcion WHERE id_web_programa_descripcion= :id_web_programa_descripcion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_programa_descripcion", $id_web_programa_descripcion);
		$consulta->execute();
	
	}
	public function desactivar_programa($id_web_programa_descripcion)
	{
		$sql="UPDATE web_programa_descripcion SET estado='0' WHERE id_web_programa_descripcion= :id_web_programa_descripcion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_programa_descripcion", $id_web_programa_descripcion);
		$consulta->execute();
	}

	public function activar_programa($id_web_programa_descripcion)
	{
		$sql="UPDATE web_programa_descripcion SET estado='1' WHERE id_web_programa_descripcion= :id_web_programa_descripcion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_programa_descripcion", $id_web_programa_descripcion);
		$consulta->execute();
	}
	public function eliminar_programa_desempenate($id_programa_desempenate)
	{
		$sql="DELETE FROM web_programa_desempenate WHERE id_programa_desempenate= :id_programa_desempenate";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_desempenate", $id_programa_desempenate);
		$consulta->execute();
	}


}

?>