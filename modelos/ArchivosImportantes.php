<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");
class ArchivosImportantes
{
	public function __construct() {}
	public function obtenerDependenciaUsuario($id_usuario)
	{
		$sql = "SELECT * FROM usuario u INNER JOIN dependencias d ON u.id_dependencia = d.id_dependencias WHERE u.id_usuario = :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarArchivosPorDependencia($dependencia)
	{
		$sql = "SELECT * FROM archivos_importantes ai INNER JOIN dependencias d ON ai.id_dependencia = d.id_dependencias WHERE d.dependencia = :dependencia ORDER BY d.dependencia ASC";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":dependencia", $dependencia);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function InsertarArchivoImportante($id_dependencia, $entidad,  $telefono,  $fecha, $hora, $id_usuario, $fecha_vencimiento, $detalles)
	{
		$sql = "INSERT INTO archivos_importantes (id_dependencia, entidad, telefono,fecha, hora,id_usuario,fecha_vencimiento,detalles) VALUES ('$id_dependencia','$entidad','$telefono', '$fecha', '$hora', '$id_usuario' , '$fecha_vencimiento' , '$detalles')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function editarArchivoImportante($id_archivos_importante, $entidad, $telefono, $fecha_vencimiento, $detalles)
	{
		$sql = "UPDATE `archivos_importantes` SET `entidad` = '$entidad', `telefono` = '$telefono', `fecha_vencimiento` = '$fecha_vencimiento', `detalles` = '$detalles' WHERE `id_archivos_importante` = $id_archivos_importante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	public function MostrarDocumento($id_archivos_importante)
	{
		global $mbd;
		$sql_mostrar = "SELECT * FROM `archivos_importantes` WHERE `id_archivos_importante` = :id_archivos_importante";
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->bindParam(":id_archivos_importante", $id_archivos_importante);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetch(PDO::FETCH_ASSOC);
		return $resultado_mostrar;
	}
	public function EliminarDocumento($id_archivos_importante)
	{
		$sql = "DELETE FROM archivos_importantes WHERE id_archivos_importante= :id_archivos_importante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_archivos_importante", $id_archivos_importante);
		$consulta->execute();
		return $consulta;
	}
	public function ObtenerRutaImagen($id_archivos_importantes_documentos)
	{
		global $mbd;
		$sql_mostrar = "SELECT * FROM archivos_importantes_documentos WHERE id_archivos_importantes_documentos = :id_archivos_importantes_documentos LIMIT 1";
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->bindParam(":id_archivos_importantes_documentos", $id_archivos_importantes_documentos);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetch(PDO::FETCH_ASSOC);
		return $resultado_mostrar;
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
	public function InsertarDocumentoImportante($id_archivos_importante, $archivo_importante_nombre, $fecha, $hora, $id_usuario)
	{
		$sql = "INSERT INTO archivos_importantes_documentos (id_archivos_importante, archivo_importante_nombre, fecha, hora,id_usuario) VALUES ('$id_archivos_importante','$archivo_importante_nombre', '$fecha', '$hora', '$id_usuario' )";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function EditarDocumentoImportante($id_archivos_importantes_documentos, $archivo_importante_nombre){
		$sql = "UPDATE `archivos_importantes_documentos` SET `archivo_importante_nombre` = '$archivo_importante_nombre' WHERE `id_archivos_importantes_documentos` = $id_archivos_importantes_documentos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	public function ListarDocumentosImportantes($id_archivos_importante){
		$sql = "SELECT * FROM archivos_importantes_documentos WHERE id_archivos_importante = :id_archivos_importante";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_archivos_importante", $id_archivos_importante);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function MostrarDocumentoImportante($id_archivos_importantes_documentos){
		global $mbd;
		$sql_mostrar = "SELECT * FROM `archivos_importantes_documentos` WHERE `id_archivos_importantes_documentos` = :id_archivos_importantes_documentos";
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->bindParam(":id_archivos_importantes_documentos", $id_archivos_importantes_documentos);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetch(PDO::FETCH_ASSOC);
		return $resultado_mostrar;
	}
	public function EliminarArchivosImportantes($id_archivos_importantes_documentos){
		$sql = "DELETE FROM archivos_importantes_documentos WHERE id_archivos_importantes_documentos= :id_archivos_importantes_documentos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_archivos_importantes_documentos", $id_archivos_importantes_documentos);
		$consulta->execute();
		return $consulta;
	}
}
