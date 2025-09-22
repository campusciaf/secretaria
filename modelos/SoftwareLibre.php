<?php 
require "../config/Conexion.php";

Class SoftwareLibre
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

	public function agregarSoftwareLibre($nombre,$sitio,$url,$ruta_img,$descripcion,$valor,$categoria){
		$sql_agregar = "INSERT INTO software_libre VALUES('',:nombre,:sitio,:url,:ruta_img,:descripcion,:valor,:categoria)";
		global $mbd;
		$consulta_agregar = $mbd->prepare($sql_agregar);
		$consulta_agregar->bindParam(':ruta_img', $this->ruta_img);
		$consulta_agregar->execute(array(
			"nombre" => $nombre,
			"sitio" => $sitio,
			"url" => $url,
			"ruta_img" => $ruta_img,
			"descripcion" => $descripcion,
			"valor" => $valor,
			"categoria" => $categoria));
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

	public function modificarSoftwareLibre($id_software_modificar,$nombre,$sitio,$url,$portada,$descripcion,$valor,$categoria){
		$sql_modificar = "UPDATE software_libre SET nombre=:nombre, sitio=:sitio, url=:url, ruta_img=:ruta_img, descripcion=:descripcion, valor=:valor, categoria=:categoria WHERE id_software=:id_software_modificar";
		global $mbd;
		$consulta_modificar = $mbd->prepare($sql_modificar);
		$consulta_modificar->execute(array(
			"id_software_modificar" => $id_software_modificar,
			"nombre" => $nombre,
			"sitio" => $sitio,
			"url" => $url,
			"ruta_img" => $portada,
			"descripcion" => $descripcion,
			"valor" => $valor,
			"categoria" => $categoria));
		return $consulta_modificar;
	}
	public function eliminarSoftwareLibre($id_sw_eliminar){
		$sql_eliminar = "DELETE FROM software_libre WHERE id_software=:id_sw_eliminar";

		global $mbd;
		$consulta_eliminar = $mbd->prepare($sql_eliminar);
		$consulta_eliminar->execute(array(
			"id_sw_eliminar" => $id_sw_eliminar));
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

	//Implementar un método para eliminar los datos de un registro 
	public function mostrarSoftware($id_software)
	{
		$sql="SELECT * FROM software_libre WHERE id_software= :id_software";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_software", $id_software);
		// $consulta->bindParam(":nombre", $nombre);
		$consulta->execute();
	
	}

	public function agregarSoftwareLibreDocente($nombre,$sitio,$url,$ruta_img,$descripcion,$valor,$categoria){
		$sql_agregar = "INSERT INTO software_libre VALUES('',:nombre,:sitio,:url,:ruta_img,:descripcion,:valor,:categoria)";
		global $mbd;
		$consulta_agregar = $mbd->prepare($sql_agregar);
		$consulta_agregar->bindParam(':ruta_img', $this->ruta_img);
		$consulta_agregar->execute(array(
			"nombre" => $nombre,
			"sitio" => $sitio,
			"url" => $url,
			"ruta_img" => $ruta_img,
			"descripcion" => $descripcion,
			"valor" => $valor,
			"categoria" => $categoria));
		return $consulta_agregar;
	}

	public function SoftwareLibrecategorias(){
		$sql_mostrar = "SELECT * FROM software_categoria";
		global $mbd;
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetchall();
		return $resultado_mostrar;
	}

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
	
}



?>
