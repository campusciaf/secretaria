<?php 
require "../config/Conexion.php";

Class CajaHerramientasEstudiantes
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

	public function filtrarSoftwareLibre($opcion){
		$sql_filtrar = "SELECT * FROM software_libre WHERE id_software_categoria =:opcion";
		
		global $mbd;
		$consulta_filtrar = $mbd->prepare($sql_filtrar);
		$consulta_filtrar->execute(array(
			"opcion" => $opcion));
		$resultado_filtrar = $consulta_filtrar->fetchall();
		return $resultado_filtrar;
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
