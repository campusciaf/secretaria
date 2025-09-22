<?php 
require "../config/Conexion.php";

Class SoftwareLibreAdmin
{
	// Implementamos nuestro constructor
	public function __construct() {

	}

	// Traemos los datos que están en la base de datos
	public function mostrarElementos(){
		$sql_mostrar = "SELECT * FROM software_libre";
		global $mbd;
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetchall();
		return $resultado_mostrar;
	}



	public function mostrarSoftware($id_software){
		global $mbd;
		$sql_mostrar = "SELECT * FROM `software_libre` WHERE `id_software` = :id_software";
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->bindParam(":id_software", $id_software);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetch(PDO::FETCH_ASSOC);
		return $resultado_mostrar;
	}



	public function agregarSoftwareLibre($nombre, $sitio, $url, $ruta_img, $descripcion, $valor, $id_software_categoria){
		$sql_agregar = "INSERT INTO `software_libre` VALUES(NULL, :nombre, :sitio, :url, :ruta_img, :descripcion, :valor, :id_software_categoria)";
		global $mbd;
		$consulta_agregar = $mbd->prepare($sql_agregar);
		$consulta_agregar->bindParam(':ruta_img', $ruta_img);
		$consulta_agregar->bindParam(":nombre", $nombre);
		$consulta_agregar->bindParam(":sitio", $sitio);
		$consulta_agregar->bindParam(":url", $url);
		$consulta_agregar->bindParam(":ruta_img", $ruta_img);
		$consulta_agregar->bindParam(":descripcion", $descripcion);
		$consulta_agregar->bindParam(":valor", $valor);
		$consulta_agregar->bindParam(":id_software_categoria", $id_software_categoria);
		$consulta_agregar->execute();
		return $consulta_agregar;
	}


	function cargarFormModal($id_software_seleccionado){
		$sql_cargar_form = "SELECT * FROM software_libre WHERE id_software = '".$id_software_seleccionado."'";
		global $mbd;
		$consulta_cargar_form = $mbd->prepare($sql_cargar_form);
		$consulta_cargar_form->execute();
		$resultado_cargar_form = $consulta_cargar_form->fetchall();
		return $resultado_cargar_form;
	}

	public function modificarSoftwareLibre($id_software,$nombre,$sitio,$url, $ruta_img, $descripcion,$valor,$id_software_categoria){
		$sql_modificar = "UPDATE software_libre SET nombre = :nombre, sitio = :sitio, url = :url, ruta_img = :ruta_img, descripcion = :descripcion, valor = :valor, id_software_categoria = :id_software_categoria WHERE id_software = :id_software";
		global $mbd;

		// echo $sql_modificar;
		$consulta_modificar = $mbd->prepare($sql_modificar);
		$consulta_modificar->execute(array(
			"id_software" => $id_software,
			"nombre" => $nombre,
			"sitio" => $sitio,
			"url" => $url,
			"ruta_img" => $ruta_img,
			"descripcion" => $descripcion,
			"valor" => $valor,
			"id_software_categoria" => $id_software_categoria));
		return $consulta_modificar;
	}
	public function eliminarSoftwareLibre($id_software){
		$sql_eliminar = "DELETE FROM software_libre WHERE id_software=:id_software";

		global $mbd;
		$consulta_eliminar = $mbd->prepare($sql_eliminar);
		$consulta_eliminar->execute(array(
			"id_software" => $id_software));
		return $consulta_eliminar;
	}

	public function filtrarSoftwareLibre($opcion){
		$sql_filtrar = "SELECT * FROM software_libre WHERE id_software_categoria =:opcion";
		global $mbd;
		$consulta_filtrar = $mbd->prepare($sql_filtrar);
		$consulta_filtrar->execute(array(
			"opcion" => $opcion));
		$resultado_filtrar = $consulta_filtrar->fetchall();
		return $resultado_filtrar;
	}



	// // Traemos los datos que están en la base de datos
	// public function mostrarSoftware(){
	// 	$sql_mostrar = "SELECT * FROM software_libre";
	// 	global $mbd;
	// 	$consulta_mostrar = $mbd->prepare($sql_mostrar);
	// 	$consulta_mostrar->execute();
	// 	$resultado_mostrar = $consulta_mostrar->fetchall();
	// 	return $resultado_mostrar;
	// }



	


	//Implementamos un método para agregar un proyecto
	public function insertarSoftware($nombre, $id_software, $sitio){
		global $mbd;
		$sql="INSERT INTO `software_libre`(`nombre`, `id_software` , `sitio`) VALUES('$nombre', '$id_software' , '$sitio')";
		//echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para editar un proyecto
	public function editarsoftware($id_software, $nombre ,$sitio){
		$sql="UPDATE `software_libre` SET `nombre` = :nombre , `sitio` = :sitio WHERE `id_software` = :id_software";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_software", $id_software);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":sitio", $sitio);
		$consulta->execute();
		return $consulta;	
	}

	//Implementar un método para mostrar los datos del docente
	public function mostrar_categorias($id_software_seleccionado){

		$sql = "SELECT * FROM software_libre WHERE id_software = '".$id_software_seleccionado."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_software_seleccionado", $id_software_seleccionado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para eliminar los datos de un registro 
	public function mostrarSoftwareboton($id_usuario)
	{
		global $mbd;
		$id_usuario = $_SESSION['id_usuario'];
		$sql="SELECT * FROM docente WHERE  id_usuario =:id_usuario";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();

		$resultado_mostrar = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado_mostrar;
		
	
	}

	// public function software_categoria(){
	// 	global $mbd;
	// 	$sql_mostrar = "SELECT * FROM `software_categoria`";
	// 	$consulta_mostrar = $mbd->prepare($sql_mostrar);
	// 	$consulta_mostrar->execute();
	// 	$resultado_mostrar = $consulta_mostrar->fetchall();
	// 	return $resultado_mostrar;
	// }

	// public function software_categoria($id_software){
	// 	global $mbd;
	// 	$sql_mostrar = "SELECT * FROM `software_categoria` WHERE `id_software` = :id_software";
	// 	$consulta_mostrar = $mbd->prepare($sql_mostrar);
	// 	$consulta_mostrar->bindParam(":id_software", $id_software);
	// 	$consulta_mostrar->execute();
	// 	$resultado_mostrar = $consulta_mostrar->fetch(PDO::FETCH_ASSOC);
	// 	return $resultado_mostrar;
	// }


	//seleccionamos el cargo 
	public function software_categoria()
	{	
		$sql="SELECT * FROM software_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}

	public function SoftwareLibrecategorias(){
		$sql_mostrar = "SELECT * FROM software_categoria";
		global $mbd;
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetchall();
		return $resultado_mostrar;
	}


}



?>
