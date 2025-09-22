<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
// session_start();

Class CalendarioPoaAcademico
{

	//Implementamos nuestro constructor
	public function __construct(){

	}

	// Función para mostrar el id del usuario
	public function cargaridUsuario($id_usuario){
		// SELECT `id_compromiso` FROM `compromiso` WHERE `id_usuario` = :id_usuario
		$sql_compromiso = "SELECT * FROM `usuario` WHERE `id_usuario` = :id_usuario ";
		global $mbd;
		$consulta_compromiso = $mbd->prepare($sql_compromiso);
		$consulta_compromiso->bindParam(":id_usuario", $id_usuario);
		$consulta_compromiso->execute();
		$resultado_compromiso = $consulta_compromiso->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_compromiso;
	}

	// Función para cargar los eventos  
	public function mostrarEventos(){

		$sql_leer="SELECT `sac_meta`.`id_meta` as id, `sac_meta`.`meta_nombre` as title, `sac_meta`.`meta_fecha` as start, `sac_meta`.`id_proyecto`,`sac_meta`.`meta_responsable`, `sac_accion`.`nombre_accion`, `sac_meta`.`anio_eje` FROM `sac_meta` INNER JOIN `sac_accion` ON `sac_accion`.`id_meta` = `sac_meta`.`id_meta` INNER JOIN `usuario` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta`";

		global $mbd;
		// echo($sql_leer);
		$consulta_leer = $mbd->prepare($sql_leer);
		// $consulta_leer->bindParam(":id_usuario", $id_usuario);	
		$consulta_leer->execute();
		$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_leer;
	}
	

	// Función para cargar los datos de usuario que se verán en el modal
	public function cargarDatosUsuario($id_usuario){
		$sql_usuario = "SELECT `usuario_cargo`, `usuario_imagen`, `usuario_nombre`, `usuario_nombre_2`, `usuario_apellido`, `usuario_apellido_2`, `usuario_telefono`, `usuario_celular` FROM `usuario` WHERE `id_usuario` = :id_usuario";
		global $mbd;
		$consulta_usuario= $mbd->prepare($sql_usuario);
		$consulta_usuario->bindParam(":id_usuario", $id_usuario);
		$consulta_usuario->execute();
		$resultado_usuario = $consulta_usuario->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_usuario;
	}

	public function cargarAccion($id_proyecto){
		$sql_compromiso = "SELECT `nombre_accion`, `meta_nombre` FROM `sac_meta` INNER JOIN `sac_accion` ON `sac_accion`.`id_meta` = `sac_meta`.`id_meta` WHERE `sac_meta`.`id_proyecto` = :id_proyecto";
		global $mbd;
		// echo $sql_compromiso;
		$consulta_accion = $mbd->prepare($sql_compromiso);
		$consulta_accion->bindParam(":id_proyecto", $id_proyecto);
		$consulta_accion->execute();
		$resultado_accion = $consulta_accion->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_accion;
	}



	
	

	
	//Traemos los datos que llenen el calendario del admin
	// Función para cargar todas las metas de la base de datos
	
	// SELECT id_meta as id, meta_nombre as title, meta_fecha as start, id_compromiso, meta_valida, meta_periodo, meta_val_admin, meta_val_usuario FROM meta
	// public function mostrarEventos(){

	// 	$sql_leer="SELECT `sac_meta`.`id_meta` as id, `sac_meta`.`meta_nombre` as title, `sac_meta`.`meta_fecha` as start, `sac_meta`.`id_proyecto`,`sac_meta`.`meta_responsable`, `sac_accion`.`nombre_accion`, `sac_meta`.`anio_eje` FROM `sac_meta` INNER JOIN `sac_accion` WHERE `meta_responsable` LIKE 'Dirección Sistemas de Información'";
		
	// 	global $mbd;
	// 	// echo $sql_leer;
	// 	$consulta_leer = $mbd->prepare($sql_leer);
	// 	$consulta_leer->execute();
	// 	$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
	// 	return $resultado_leer;
	// }

	// Traemos los datos que llenen el calendario con filtro Académico
	// Función para cargar los compromisos que valida la dirección académica
	public function cargarCompromisosAcademicos(){
		$sql_compromiso = "SELECT `id_meta` FROM `sac_meta` WHERE `meta_responsable` LIKE '%Coordinación Bienestar Institucional%'";
		global $mbd;
		$consulta_compromiso = $mbd->prepare($sql_compromiso);
		$consulta_compromiso->execute();
		$resultado_compromiso = $consulta_compromiso->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_compromiso;
	}

	// Función para mostrar las metas en forma de evento respecto a cada compromiso.
	public function mostrarEventosAcademicos($id_usuario){
		$sql_leer="SELECT `sac_meta`.`id_meta` as id, `sac_meta`.`meta_nombre` as title, `sac_meta`.`meta_fecha` as start, `sac_meta`.`id_proyecto`,`sac_meta`.`meta_responsable`, `sac_accion`.`nombre_accion`, `sac_meta`.`anio_eje` FROM `sac_meta` INNER JOIN `sac_accion` ON `sac_accion`.`id_meta` = `sac_meta`.`id_meta` INNER JOIN `usuario` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` WHERE `usuario`.`id_usuario` = :id_usuario";
		global $mbd;
		$consulta_leer = $mbd->prepare($sql_leer);
		$consulta_leer->bindParam(":id_usuario", $id_usuario);
		$consulta_leer->execute();
		$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_leer;
	}

	// Traemos los datos que llenen el calendario con filtro Académico
	// Función para cargar los compromisos que valida la dirección académica
	// public function cargarCompromisosAdministrativos(){
	// 	$sql_compromiso = "SELECT `id_compromiso` FROM `compromiso` WHERE `compromiso_valida` LIKE '%Dirección Administrativa%'";
	// 	global $mbd;
	// 	$consulta_compromiso = $mbd->prepare($sql_compromiso);
	// 	$consulta_compromiso->execute();
	// 	$resultado_compromiso = $consulta_compromiso->fetchAll(PDO::FETCH_ASSOC);
	// 	return $resultado_compromiso;
	// }

	// Función para mostrar las metas en forma de evento respecto a cada compromiso.
	// public function mostrarEventosAdministrativos($id_compromiso){
	// 	$sql_leer="SELECT `id_meta` as id, `meta_nombre` as title, `meta_fecha` as start, `id_compromiso`, `meta_valida`, `meta_periodo`, `meta_val_admin`, `meta_val_usuario` FROM `meta` WHERE `id_compromiso` = :id_compromiso";
	// 	global $mbd;
	// 	$consulta_leer = $mbd->prepare($sql_leer);
	// 	$consulta_leer->bindParam(":id_compromiso", $id_compromiso);
	// 	$consulta_leer->execute();
	// 	$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
	// 	return $resultado_leer;
	// }


	// Función para cargar la ainformación del compromiso que corresponde a la meta
	// public function cargarCompromiso($id_compromiso){
	// 	$sql_compromiso = "SELECT `compromiso_nombre`, `id_usuario` FROM `compromiso` WHERE `id_compromiso`= :id_compromiso";
	// 	global $mbd;
	// 	$consulta_compromiso = $mbd->prepare($sql_compromiso);
	// 	$consulta_compromiso->bindParam(":id_compromiso", $id_compromiso);
	// 	$consulta_compromiso->execute();
	// 	$resultado_compromiso = $consulta_compromiso->fetchAll(PDO::FETCH_ASSOC);
	// 	return $resultado_compromiso;
	// }

	// Función para cargar la ainformación del compromiso que corresponde a la meta
	// public function cargarAccion($id_meta){
	// 	$sql_compromiso = "SELECT * FROM `sac_accion` WHERE `id_meta`= :id_meta";
	// 	global $mbd;
	// 	// echo $sql_compromiso;
	// 	$consulta_compromiso = $mbd->prepare($sql_compromiso);
	// 	$consulta_compromiso->bindParam(":id_meta", $id_meta);
	// 	$consulta_compromiso->execute();
	// 	$resultado_compromiso = $consulta_compromiso->fetchAll(PDO::FETCH_ASSOC);
	// 	return $resultado_compromiso;
	// }

	// Función para cargar los datos de usuario que se verán en el modal
	// public function cargarAccion(){
	// 	$sql_accion = "SELECT `nombre_accion`,`id_meta` FROM `sac_accion`";
	// 	global $mbd;
	// 	// echo $sql_accion;
	// 	$consulta_accion= $mbd->prepare($sql_accion);
	// 	// $consulta_accion->bindParam(":id_meta", $id_meta);
	// 	$consulta_accion->execute();
	// 	$resultado_accion = $consulta_accion->fetchAll(PDO::FETCH_ASSOC);
	// 	return $resultado_accion;
	// }

	

	

}