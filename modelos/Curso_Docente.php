<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Curso
{
	//Implementamos nuestro constructor
	public function __construct() {}
	public function listarCategorias(){
		$sql = "SELECT * FROM `induccion_docente_categorias`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function insertarCategoria($nombre_categoria, $enlace_video_categoria){
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `induccion_docente_categorias`(`nombre_categoria`, `enlace_video_categoria`) VALUES (:nombre_categoria, :enlace_video_categoria)");
		$sentencia->bindParam(":nombre_categoria", $nombre_categoria);
		$sentencia->bindParam(":enlace_video_categoria", $enlace_video_categoria);
		$sentencia->execute();
		$id_categoria = $mbd->lastInsertId();
		return $id_categoria;
	}
	public function mostrarCategoria($id_induccion_docente_categoria)
	{
		$sql = "SELECT * FROM `induccion_docente_categorias` WHERE `id_induccion_docente_categoria` = :id_induccion_docente_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_induccion_docente_categoria", $id_induccion_docente_categoria);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function editarCategoria($id_induccion_docente_categoria, $nombre_categoria, $enlace_video_categoria){
		$sql = "UPDATE `induccion_docente_categorias` SET `nombre_categoria` = :nombre_categoria, `enlace_video_categoria` = :enlace_video_categoria WHERE `id_induccion_docente_categoria` = :id_induccion_docente_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_induccion_docente_categoria", $id_induccion_docente_categoria);
		$consulta->bindParam(":nombre_categoria", $nombre_categoria);
		$consulta->bindParam(":enlace_video_categoria", $enlace_video_categoria);
		return $consulta->execute();
	}
	public function eliminarCategoria($id_induccion_docente_categoria) {
		global $mbd;
		$sql1 = "DELETE FROM `induccion_docente_categorias` WHERE `id_induccion_docente_categoria` = :id_induccion_docente_categoria;";
		$consulta1 = $mbd->prepare($sql1);
		$consulta1->bindParam(":id_induccion_docente_categoria", $id_induccion_docente_categoria);
		return $consulta1->execute();
	}
	public function verVideo($id_induccion_docente_categoria){
		$sql = "SELECT `enlace_video_categoria` FROM `induccion_docente_categorias` WHERE `id_induccion_docente_categoria` = :id_induccion_docente_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_induccion_docente_categoria", $id_induccion_docente_categoria);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function cantidadPreguntas($id_induccion_docente_categoria){
		$sql = "SELECT COUNT(*) AS `cantidad` FROM `preguntas_induccion_docente` WHERE `categoria` = :id_induccion_docente_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_induccion_docente_categoria", $id_induccion_docente_categoria);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado["cantidad"];
	}
	public function listarPreguntas($categoria){
		$sql = "SELECT * FROM `preguntas_induccion_docente` WHERE `categoria` = :categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":categoria", $categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function agregarPregunta($texto_pregunta, $opcion_correcta, $tipo_pregunta, $categoria){
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `preguntas_induccion_docente`(`texto_pregunta`, `opcion_correcta`, `tipo_pregunta`,`categoria`) VALUES (:texto_pregunta, :opcion_correcta, :tipo_pregunta, :categoria)");
		$sentencia->bindParam(":texto_pregunta", $texto_pregunta);
		$sentencia->bindParam(":opcion_correcta", $opcion_correcta);
		$sentencia->bindParam(":tipo_pregunta", $tipo_pregunta);
		$sentencia->bindParam(":categoria", $categoria);
		$sentencia->execute();
		$id_pregunta = $mbd->lastInsertId();
		return $id_pregunta;
	}
	public function editar($id_pregunta, $texto_pregunta, $opcion_correcta, $tipo_pregunta, $categoria)
	{
		$sql = "UPDATE `preguntas_induccion_docente` SET `texto_pregunta` = :texto_pregunta, `opcion_correcta` = :opcion_correcta, `tipo_pregunta` = :tipo_pregunta, `categoria` = :categoria  WHERE `id_pregunta` = :id_pregunta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pregunta", $id_pregunta);
		$consulta->bindParam(":texto_pregunta", $texto_pregunta);
		$consulta->bindParam(":opcion_correcta", $opcion_correcta);
		$consulta->bindParam(":tipo_pregunta", $tipo_pregunta);
		$consulta->bindParam(":categoria", $categoria);
		return $consulta->execute();
	}
	public function mostrar($id_pregunta)
	{
		$sql = "SELECT * FROM preguntas_induccion_docente WHERE id_pregunta= :id_pregunta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pregunta", $id_pregunta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function mostrarOpciones($id_pregunta)
	{
		$sql = "SELECT * FROM opciones_preguntas_induccion_docente WHERE id_pregunta= :id_pregunta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pregunta", $id_pregunta);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminar($id_pregunta)
	{
		global $mbd;
		$sql1 = "DELETE FROM `preguntas_induccion_docente` WHERE `id_pregunta` = :id_pregunta;
				 DELETE FROM `opciones_preguntas_induccion_docente` WHERE `id_pregunta` = :id_pregunta";
		$consulta1 = $mbd->prepare($sql1);
		$consulta1->bindParam(":id_pregunta", $id_pregunta);
		return $consulta1->execute();
	}
	
	public function agregarmultiple($texto_opcion, $id_pregunta)
	{
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `opciones_preguntas_induccion_docente`(`texto_opcion`, `id_pregunta`) VALUES (:texto_opcion,:id_pregunta)");
		$sentencia->bindParam(":texto_opcion", $texto_opcion);
		$sentencia->bindParam(":id_pregunta", $id_pregunta);
		return $sentencia->execute();
	}
	public function agregarverdaderofalso($texto_opcion, $id_pregunta)
	{
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `opciones_preguntas_induccion_docente`(`texto_opcion`,`id_pregunta`) VALUES (:texto_opcion,:id_pregunta)");
		$sentencia->bindParam(":texto_opcion", $texto_opcion);
		$sentencia->bindParam(":id_pregunta", $id_pregunta);
		return $sentencia->execute();
	}
	public function eliminarOpciones($id_pregunta)
	{
		global $mbd;
		$sql = "DELETE FROM `opciones_preguntas_induccion_docente` WHERE `id_pregunta` = :id_pregunta";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pregunta", $id_pregunta);
		return $consulta->execute();
	}
	public function editarOpcion($id_opcion, $texto_opcion)
	{
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE `opciones_preguntas_induccion_docente` SET `texto_opcion` = :texto_opcion WHERE `id_opcion` = :id_opcion");
		$sentencia->bindParam(":texto_opcion", $texto_opcion);
		$sentencia->bindParam(":id_opcion", $id_opcion);
		return $sentencia->execute();
	}
	public function obtenerOpcionesPorPregunta($id_pregunta)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT `id_opcion`, `texto_opcion` FROM `opciones_preguntas_induccion_docente` WHERE `id_pregunta` = :id_pregunta ORDER BY `id_opcion` ASC");
		$sentencia->bindParam(":id_pregunta", $id_pregunta, PDO::PARAM_INT);
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}
}
