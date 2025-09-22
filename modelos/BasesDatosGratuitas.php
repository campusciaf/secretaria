<?php 
require "../config/Conexion.php";

Class BDGratuita
{
	// Implementamos nuestro constructor
	public function __construct() {

	}

	// Traemos los datos que están en la base de datos
	public function mostrarElementos(){
		$sql_mostrar = "SELECT * FROM bases_datos";
		global $mbd;
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetchall();
		return $resultado_mostrar;
	}
	// Traemos los datos que están en la base de datos
	public function cargarFormModal($id_base_datos_seleccionada){
		$sql_cargar_form = "SELECT * FROM bases_datos WHERE id_base_datos = '".$id_base_datos_seleccionada."'";
		global $mbd;
		$consulta_cargar_form = $mbd->prepare($sql_cargar_form);
		$consulta_cargar_form->execute();
		$resultado_cargar_form = $consulta_cargar_form->fetchall();
		return $resultado_cargar_form;
	}

	public function agregarBaseDatos($nombre,$sitio,$url,$ruta_img,$descripcion,$valor){
		$sql_agregar = "INSERT INTO bases_datos VALUES('',:nombre,:sitio,:url,:ruta_img,:descripcion,:valor)";
		global $mbd;
		$consulta_agregar = $mbd->prepare($sql_agregar);
		$consulta_agregar->bindParam(':ruta_img', $this->ruta_img);
		$consulta_agregar->execute(array(
			"nombre" => $nombre,
			"sitio" => $sitio,
			"url" => $url,
			"ruta_img" => $ruta_img,
			"descripcion" => $descripcion,
			"valor" => $valor));
		return $consulta_agregar;		
	}
	public function modificarBaseDatos($id_bd_modificar,$nombre,$sitio,$url,$portada,$descripcion,$valor){
		$sql_modificar = "UPDATE bases_datos SET nombre=:nombre, sitio=:sitio, url=:url, ruta_img=:ruta_img, descripcion=:descripcion, valor=:valor WHERE id_base_datos=:id_bd_modificar";

		global $mbd;
		$consulta_modificar = $mbd->prepare($sql_modificar);
		$consulta_modificar->execute(array(
			"id_bd_modificar" => $id_bd_modificar,
			"nombre" => $nombre,
			"sitio" => $sitio,
			"url" => $url,
			"ruta_img" => $portada,
			"descripcion" => $descripcion,
			"valor" => $valor));
		return $consulta_modificar;
	}
	public function eliminarBaseDatos($id_bd_eliminar){
		$sql_eliminar = "DELETE FROM bases_datos WHERE id_base_datos=:id_bd_eliminar";

		global $mbd;
		$consulta_eliminar = $mbd->prepare($sql_eliminar);
		$consulta_eliminar ->execute(array(
			"id_bd_eliminar" => $id_bd_eliminar));
		return $consulta_eliminar;
	}
 
}



?>