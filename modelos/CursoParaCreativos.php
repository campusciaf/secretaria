<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class CursoParaCreativos{
	public function __construct() {}
	public function listarCategorias(){
		$sql = "SELECT * FROM `induccion_docente_categorias`;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function verificarAprobadas($id_induccion_docente_categorias, $id_docente){
		$sql = "SELECT * FROM `induccion_docente_aprobada` WHERE `id_induccion_docente_categorias` = :id_induccion_docente_categorias AND `id_docente` = :id_docente";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_induccion_docente_categorias", $id_induccion_docente_categorias);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function mostrarCategoria($id_induccion_docente_categoria){
		$sql = "SELECT * FROM `induccion_docente_categorias` WHERE `id_induccion_docente_categoria` = :id_induccion_docente_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_induccion_docente_categoria", $id_induccion_docente_categoria);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarPreguntas($categoria){
		$sql = "SELECT * FROM `preguntas_induccion_docente` WHERE `categoria` = :categoria ORDER BY RAND() LIMIT 3";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":categoria", $categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarOpciones($id_pregunta){
		$sql = "SELECT * FROM `opciones_preguntas_induccion_docente` WHERE `id_pregunta` = :id_pregunta ORDER BY `opciones_preguntas_induccion_docente`.`id_opcion` ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pregunta", $id_pregunta);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function mostrarPregunta($id_pregunta){
		$sql = "SELECT * FROM `preguntas_induccion_docente` WHERE `id_pregunta` = :id_pregunta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pregunta", $id_pregunta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function aprobarCategoria($id_docente, $id_induccion_docente_categoria)  {
		$sql = "INSERT INTO `induccion_docente_aprobada` (`id_induccion_docente_categorias`, `id_docente`) VALUES (:id_induccion_docente_categoria, :id_docente)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_induccion_docente_categoria", $id_induccion_docente_categoria);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
	}
}
