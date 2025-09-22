<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CalendarioPoa
{

	//Implementamos nuestro constructor
	public function __construct(){

	}
	// Función para cargar el id del compromiso con la sesión abierta
	public function cargarCompromisoIndividual(){
		$sql_compromiso = "SELECT id_compromiso FROM compromiso WHERE id_usuario = '".$_SESSION['id_usuario']."'";
		global $mbd;
		$consulta_compromiso = $mbd->prepare($sql_compromiso);
		$consulta_compromiso->execute();
		$resultado_compromiso = $consulta_compromiso->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_compromiso;
	}

	//Traemos los datos que llenen el calendario por sesión
	// Función para cargar los eventos de cada dependencia por compromiso consultado en la anterior función
	public function mostrarEventosIndivual($id_compromiso){
		$sql_leer="SELECT id_meta as id, meta_nombre as title, meta_fecha as start, id_compromiso, meta_valida, meta_periodo, meta_val_admin, meta_val_usuario FROM meta WHERE id_compromiso = '".$id_compromiso."'";
		global $mbd;
		$consulta_leer = $mbd->prepare($sql_leer);
		$consulta_leer->execute();
		$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_leer;
	}

	// Traemos los datos que llenen el calendario con filtro Académico
	// Función para cargar los compromisos que valida la dirección académica
	public function cargarCompromisosAcademicos(){
		$sql_compromiso = "SELECT id_compromiso FROM compromiso WHERE compromiso_valida LIKE '%Rector%'";
		global $mbd;
		$consulta_compromiso = $mbd->prepare($sql_compromiso);
		$consulta_compromiso->execute();
		$resultado_compromiso = $consulta_compromiso->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_compromiso;
	}

	// Función para mostrar las metas en forma de evento respecto a cada compromiso.
	public function mostrarEventosAcademicos($id_compromiso){
		$sql_leer="SELECT id_meta as id, meta_nombre as title, meta_fecha as start, id_compromiso, meta_valida, meta_periodo, meta_val_admin, meta_val_usuario FROM meta WHERE id_compromiso = '".$id_compromiso."'";
		global $mbd;
		$consulta_leer = $mbd->prepare($sql_leer);
		$consulta_leer->execute();
		$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_leer;
	}

	// Traemos los datos que llenen el calendario con filtro Académico
	// Función para cargar los compromisos que valida la dirección académica
	public function cargarCompromisosAdministrativos(){
		$sql_compromiso = "SELECT id_compromiso FROM compromiso WHERE compromiso_valida LIKE '%Dirección Administrativa%'";
		global $mbd;
		$consulta_compromiso = $mbd->prepare($sql_compromiso);
		$consulta_compromiso->execute();
		$resultado_compromiso = $consulta_compromiso->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_compromiso;
	}

	// Función para mostrar las metas en forma de evento respecto a cada compromiso.
	public function mostrarEventosAdministrativos($id_compromiso){
		$sql_leer="SELECT id_meta as id, meta_nombre as title, meta_fecha as start, id_compromiso, meta_valida, meta_periodo, meta_val_admin, meta_val_usuario FROM meta WHERE id_compromiso = '".$id_compromiso."'";
		global $mbd;
		$consulta_leer = $mbd->prepare($sql_leer);
		$consulta_leer->execute();
		$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_leer;
	}

	//Traemos los datos que llenen el calendario del admin
	// Función para cargar todas las metas de la base de datos
	public function mostrarEventos(){
		$sql_leer="SELECT id_meta as id, meta_nombre as title, meta_fecha as start, id_compromiso, meta_valida, meta_periodo, meta_val_admin, meta_val_usuario FROM meta";
		global $mbd;
		$consulta_leer = $mbd->prepare($sql_leer);
		$consulta_leer->execute();
		$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_leer;
	}

	// Función para cargar la ainformación del compromiso que corresponde a la meta
	public function cargarCompromiso($id_compromiso){
		$sql_compromiso = "SELECT compromiso_nombre, id_usuario FROM compromiso WHERE id_compromiso='".$id_compromiso."'";
		global $mbd;
		$consulta_compromiso = $mbd->prepare($sql_compromiso);
		$consulta_compromiso->execute();
		$resultado_compromiso = $consulta_compromiso->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_compromiso;
	}
	// Función para cargar los datos de usuario que se verán en el modal
	public function cargarDatosUsuario($id_usuario){
		$sql_usuario = "SELECT usuario_cargo, usuario_imagen, usuario_nombre, usuario_nombre_2, usuario_apellido, usuario_apellido_2, usuario_telefono, usuario_celular FROM usuario WHERE id_usuario ='".$id_usuario."'";
		global $mbd;
		$consulta_usuario= $mbd->prepare($sql_usuario);
		$consulta_usuario->execute();
		$resultado_usuario = $consulta_usuario->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_usuario;
	}

}