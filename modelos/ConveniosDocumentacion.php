<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");


class ConveniosDocumentacion
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Implementamos un método para insertar una carpeta
	public function insertarCarpetaConvenio($id_usuario, $carpeta, $fecha, $hora)
	{
		$sql = "INSERT INTO convenio_carpeta (id_usuario,carpeta,fecha,hora) VALUES ('$id_usuario','$carpeta','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar la carpeta
	public function editarCarpeta($id_convenio_carpeta, $carpeta)
	{
		$sql = "UPDATE convenio_carpeta SET carpeta='$carpeta' WHERE id_convenio_carpeta='$id_convenio_carpeta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para ver las carpetas
	public function verCarpetas()
	{
		$sql = "SELECT * FROM convenio_carpeta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function fechaesp($date)
	{
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
	public function verDocumentoschecklist($id_convenio_carpeta)
	{
		$sql = "SELECT * FROM convenio_items WHERE id_convenio_carpeta= :id_convenio_carpeta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_convenio_carpeta", $id_convenio_carpeta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para insertar una carpeta
	public function insertarDocumento($id_convenio_carpeta, $nombre_documento, $fecha_respuesta_creacion, $hora_respuesta_creacion, $id_usuario)
	{
		$sql = "INSERT INTO convenio_items (id_convenio_carpeta, nombre_convenio, fecha_creacion, hora_creacion, id_usuario) VALUES ('$id_convenio_carpeta', '$nombre_documento', '$fecha_respuesta_creacion', '$hora_respuesta_creacion', '$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function editarDocumento($id_convenio_documento, $nombre_convenio)
	{
		$sql = "UPDATE convenio_items SET nombre_convenio='$nombre_convenio' WHERE id_convenio_documento='$id_convenio_documento'";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function InsertarArchivoConvenio($id_convenio_documento, $nombre_archivo, $fecha, $hora, $comentarios, $id_usuario)
	{
		$sql = "INSERT INTO convenios_archivos (id_convenio_documento, nombre_archivo, fecha, hora,comentarios,id_usuario) VALUES ('$id_convenio_documento', '$nombre_archivo', '$fecha', '$hora' , '$comentarios', '$id_usuario' )";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function verArchivosCheckList($id_convenio_documento)
	{
		$sql = "SELECT * FROM convenios_archivos WHERE id_convenio_documento= :id_convenio_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_convenio_documento", $id_convenio_documento);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function vercomentarios($id_convenio_documento)
	{
		$sql = "SELECT * FROM convenio_comentarios WHERE id_convenio_documento= :id_convenio_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_convenio_documento", $id_convenio_documento);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function InsertarComentarios($id_convenio_documento, $comentario, $fecha_creacion, $hora_creacion, $id_usuario)
	{
		$sql = "INSERT INTO convenio_comentarios (id_convenio_documento, comentario, fecha_creacion, hora_creacion	,id_usuario) VALUES ('$id_convenio_documento', '$comentario', '$fecha_creacion', '$hora_creacion	' , '$id_usuario' )";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function terminar_item($id_convenio_documento)
	{
		$sql = "UPDATE `convenio_items` SET `estado_terminado` = '1' WHERE `id_convenio_documento` = :id_convenio_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_convenio_documento", $id_convenio_documento);
		return $consulta->execute();
	}
	public function InsertarEstadoFinalizoConvenio($id_convenio_documento, $id_usuario, $fecha_finalizado)
	{
		$sql = "INSERT INTO convenio_item_finalizado (id_convenio_documento, id_usuario, fecha_finalizado) VALUES ('$id_convenio_documento', '$id_usuario', '$fecha_finalizado'  )";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function ConsultarEstadoFinalizado($id_convenio_documento)
	{
		$sql = "SELECT COUNT(*) as count FROM `convenio_item_finalizado` WHERE `id_convenio_documento` = :id_convenio_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_convenio_documento", $id_convenio_documento);
		$consulta->execute();
		$resultado = $consulta->fetch();
		return $resultado['count'] > 0;
	}
	public function editar_carpeta($id_convenio_carpeta)
	{
		$sql = "SELECT * FROM `convenio_carpeta` WHERE `id_convenio_carpeta` = :id_convenio_carpeta";
		global $mbd;
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_convenio_carpeta", $id_convenio_carpeta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function editar_item($id_convenio_documento)
	{
		$sql = "SELECT * FROM `convenio_items` WHERE `id_convenio_documento` = :id_convenio_documento";
		global $mbd;
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_convenio_documento", $id_convenio_documento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminar_carpeta($id_convenio_carpeta)
	{
		$sql="DELETE FROM convenio_carpeta WHERE id_convenio_carpeta= :id_convenio_carpeta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_convenio_carpeta", $id_convenio_carpeta);
		$consulta->execute();
		return $consulta;
	}
	public function eliminar_items($id_convenio_documento)
	{
		$sql="DELETE FROM convenio_items WHERE id_convenio_documento= :id_convenio_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_convenio_documento", $id_convenio_documento);
		$consulta->execute();
		return $consulta;
	}

}
