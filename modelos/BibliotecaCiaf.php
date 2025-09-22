<?php 
require "../config/Conexion.php";

Class BibliotecaCiaf
{
	// Implementamos nuestro constructor
	public function __construct() {

	}

	// Traemos los datos que están en la base de datos
	public function mostrarLibros(){
		$sql_mostrar = "SELECT * FROM biblioteca";
		global $mbd;
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetchall();
		return $resultado_mostrar;
	}

	// Traemos los datos que están en la base de datos
	public function cargarFormModal($id_libro_seleccionado){
		$sql_cargar_form = "SELECT * FROM biblioteca WHERE id_libro = '".$id_libro_seleccionado."'";
		global $mbd;
		$consulta_cargar_form = $mbd->prepare($sql_cargar_form);
		$consulta_cargar_form->execute();
		$resultado_cargar_form = $consulta_cargar_form->fetchall();
		return $resultado_cargar_form;
	}

	// Función para modificar los datos que están seleccionados
	public function modificarLibro($id_libro_modificar,$portada,$titulo,$fechaLanz,$autor,$categoria,$programa,$editorial,$isbn,$idioma,$paginas,$formato,$descripcion,$palabclave,$ejemplares){
		$sql_modificar = "UPDATE biblioteca SET portada=:portada, titulo=:titulo, fecha_lanzamiento=:fechaLanz, autor=:autor, categoria=:categoria, programa=:programa, editorial=:editorial, isbn=:isbn, idioma=:idioma, paginas=:paginas, formato=:formato, descripcion=:descripcion, palabras_claves=:palabclave, ejemplares=:ejemplares WHERE id_libro=:id_libro_modificar";

		global $mbd;
		$consulta_modificar = $mbd->prepare($sql_modificar);
		$consulta_modificar->execute(array(
			"id_libro_modificar" => $id_libro_modificar,
			"portada" => $portada,
			"titulo" => $titulo,
			"fechaLanz" => $fechaLanz,
			"autor" => $autor,
			"categoria" => $categoria,
			"programa" => $programa,
			"editorial" => $editorial,
			"isbn" => $isbn,
			"idioma" => $idioma,
			"paginas" => $paginas,
			"formato" => $formato,
			"descripcion" => $descripcion,
			"palabclave" => $palabclave,
			"ejemplares" => $ejemplares));
		return $consulta_modificar;
	}
	public function agregarLibro($url,$titulo,$fechaLanz,$autor,$categoria,$programa,$editorial,$isbn,$idioma,$paginas,$formato,$descripcion,$palabclave,$ejemplares){
		$sql_agregar = "INSERT INTO biblioteca VALUES('',:url,:titulo,:fechaLanz,:autor,:categoria,:programa,:editorial,:isbn,:idioma,:paginas,:formato,:descripcion,:palabclave,:ejemplares)";
		global $mbd;
		$consulta_agregar = $mbd->prepare($sql_agregar);
		$consulta_agregar->bindParam(':url', $this->url);
		$consulta_agregar->execute(array(
			"url" => $url,
			"titulo" => $titulo,
			"fechaLanz" => $fechaLanz,
			"autor" => $autor,
			"categoria" => $categoria,
			"programa" => $programa,
			"editorial" => $editorial,
			"isbn" => $isbn,
			"idioma" => $idioma,
			"paginas" => $paginas,
			"formato" => $formato,
			"descripcion" => $descripcion,
			"palabclave" => $palabclave,
			"ejemplares" => $ejemplares));
		return $consulta_agregar;
	}

	public function eliminarLibro($id_libro_eliminar){
		$sql_eliminar = "DELETE FROM biblioteca WHERE id_libro=:id_libro_eliminar";

		global $mbd;
		$consulta_eliminar = $mbd->prepare($sql_eliminar);
		$consulta_eliminar ->execute(array(
			"id_libro_eliminar" => $id_libro_eliminar));
		return $consulta_eliminar;
	}

	public function buscarLibros($busqueda){
		$sql_buscar = "SELECT * FROM biblioteca WHERE autor LIKE '%".$busqueda."%' or titulo LIKE '%".$busqueda."%' or isbn LIKE '%".$busqueda."%' or palabras_claves LIKE '%".$busqueda."%'";

		global $mbd;
		$consulta_buscar = $mbd->prepare($sql_buscar);
		$consulta_buscar->execute();
		$resultado_buscar = $consulta_buscar->fetchall();
		return $resultado_buscar;
	}
 
}



?>