<?php 
session_start(); 
date_default_timezone_set('America/Bogota');
require_once "../modelos/CalendarioPoa.php";

$calendariopoa = new CalendarioPoa();
// Tomamos con la función GET la opción enviada desde el JS
$op = (isset($_GET['op']))?$_GET['op']:'mostrar';
$id_compromiso = isset($_POST["id_compromiso"])? limpiarCadena($_POST["id_compromiso"]):"";
$meta_responsable = isset($_POST["meta_responsable"])? limpiarCadena($_POST["meta_responsable"]):"";
$id_proyecto = isset($_POST["id_proyecto"])? limpiarCadena($_POST["id_proyecto"]):"";
$id_meta = isset($_POST["id_meta"])? limpiarCadena($_POST["id_meta"]):"";
$id_usuario = isset($_SESSION["id_usuario"])? limpiarCadena($_SESSION["id_usuario"]):"";

switch ($op) {

	// Caso solo para cargar las metas de la sesión iniciada
	case 'mostrar_individual':
		// traemos el id del usuario que esta en la sesión actual 
		$consulta=$calendariopoa->cargaridUsuario($id_usuario);
		// print_r($consulta);
		$reg = $consulta;
		$array = array();
		for ($i=0;$i<count($reg);$i++){
			// print_r($reg);
			
			//mostramos las acciones que tiene el usuario en la sesión actual
			$rsptadatos = $calendariopoa->mostrarEventosIndivual($id_usuario);
			// print_r($rsptadatos);
			$title =  $rsptadatos[$i]["title"];

			$today = date("Y-m-d");
			foreach($rsptadatos as $valor) {
				$today_time = strtotime($today);
				$expire_time = strtotime($valor["start"]);

				if($today_time > $expire_time){
					
					$array[]=array(
						"id"=>$valor["id"],
						"start"=>$valor["start"],
						"title"=>$valor["title"],
						"id_proyecto" => $valor["id_proyecto"] ,
						"meta_responsable" => $valor["meta_responsable"],
						"anio_eje" => $valor["anio_eje"],	
						"nombre_accion" => $valor["nombre_accion"],
						"color" => "#dd4b39"
						/*Rojo*/
					);
					
				}else if($today_time < $expire_time){
					$array[]=array(
						"id"=>$valor["id"],
						"start"=>$valor["start"],
						"title"=>$valor["title"],
						"id_proyecto" => $valor["id_proyecto"] ,
						"meta_responsable" => $valor["meta_responsable"],
						"anio_eje" => $valor["anio_eje"],
						"nombre_accion" => $valor["nombre_accion"],
						"color" => "#00c0ef"
						/*Azul Claro*/
					);

				}else if($today_time == $expire_time){
					$array[]=array(
						"id"=>$valor["id"],
						"start"=>$valor["start"],
						"title"=>$valor["title"],
						"id_proyecto" => $valor["id_proyecto"] ,
						"meta_responsable" => $valor["meta_responsable"],
						"anio_eje" => $valor["anio_eje"],
						"nombre_accion" => $valor["nombre_accion"],
						"color" => "#001a35"
						/*Azul Oscuro*/
					);

				}
			}
		}
		
		echo json_encode($array);
	break;

	case 'cargarUsuario':
		// $id_usuario = $_POST['id_usuario'];
		$cargar_usuario = $calendariopoa->cargarDatosUsuario($id_usuario);
		//Codificar el resultado utilizando Json
		echo json_encode($cargar_usuario);
	break;

	// Función para cargar los datos de los compromisos que se van a imprimir en pantalla
	case 'cargarAccion':
		// $id_proyecto = $_POST['id_proyecto'];
		$cargar_accion = $calendariopoa->cargarAccion($id_proyecto);
		//Codificar el resultado utilizando Json
		echo json_encode($cargar_accion); 
	break;
		


	// // Caso para cargar todas las metas
	// case 'mostrar':

	// 	$consulta=$calendariopoa->mostrarEventosIndivual($id_usuario);
	// 	// print_r($consulta);
	// 	//Codificar el resultado utilizando json
	// 	$array = array();
	// 	$today = date("Y-m-d");
	// 	foreach($consulta as $valor) {
	// 		$today_time = strtotime($today);
	// 		$expire_time = strtotime($valor["start"]);

	// 		if($today_time > $expire_time){
	// 			$array[]=array(
	// 				"id"=>$valor["id"],
	// 				"start"=>$valor["start"],
	// 				"title"=>$valor["title"],
	// 				"id_proyecto" => $valor["id_proyecto"] ,
	// 				"meta_responsable" => $valor["meta_responsable"],
	// 				"anio_eje" => $valor["anio_eje"],
	// 				// "meta_val_admin" => $valor["meta_val_admin"],
	// 				"nombre_accion" => $valor["nombre_accion"],
	// 				"color" => "#dd4b39"
	// 				/*Rojo*/
	// 			);
	// 		}else if($today_time < $expire_time){
	// 			$array[]=array(
	// 				"id"=>$valor["id"],
	// 				"start"=>$valor["start"],
	// 				"title"=>$valor["title"],
	// 				"id_proyecto" => $valor["id_proyecto"] ,
	// 				"meta_responsable" => $valor["meta_responsable"],
	// 				"anio_eje" => $valor["anio_eje"],
	// 				// "meta_val_admin" => $valor["meta_val_admin"],
	// 				"nombre_accion" => $valor["nombre_accion"],
	// 				"color" => "#00c0ef"
	// 				/*Azul Claro*/
					
	// 			);
	// 			// print_r($array);
	// 		}else if($today_time == $expire_time){
	// 			$array[]=array(
	// 				"id"=>$valor["id"],
	// 				"start"=>$valor["start"],
	// 				"title"=>$valor["title"],
	// 				"id_proyecto" => $valor["id_proyecto"] ,
	// 				"meta_responsable" => $valor["meta_responsable"],
	// 				"anio_eje" => $valor["anio_eje"],
	// 				// "meta_val_admin" => $valor["meta_val_admin"],
	// 				"nombre_accion" => $valor["nombre_accion"],
	// 				"color" => "#001a35"
	// 				/*Azul Oscuro*/
	// 			);
	// 		}
			
	// 	}
	// 	echo json_encode($array);
	// break;

	

	// // Función para cargar los datos del filtrado por académico
	// case 'mostrarAcademica':

	// 	$consulta=$calendariopoa->cargarCompromisosAcademicos();
	// 	$reg = $consulta;
	// 	$array = array();
	// 	for ($i=0;$i<count($reg);$i++){
	// 		$rsptadatos=$calendariopoa->mostrarEventosAcademicos($reg[$i]["id_compromiso"]);
	// 		$today = date("Y-m-d");
	// 		foreach($rsptadatos as $valor) {

	// 			$today_time = strtotime($today);
	// 			$expire_time = strtotime($valor["start"]);
	// 			if($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 0){

	// 				if($today_time > $expire_time){
	// 					$array[]=array(
	// 						"id"=>$valor["id"],
	// 						"start"=>$valor["start"],
	// 						"title"=>$valor["title"],
	// 						"id_compromiso" => $valor["id_compromiso"] ,
	// 						"meta_valida" => $valor["meta_valida"],
	// 						"meta_periodo" => $valor["meta_periodo"],
	// 						"meta_val_admin" => $valor["meta_val_admin"],
	// 						"nombre_accion" => $valor["nombre_accion"],
	// 						"color" => "#dd4b39"
	// 						/*Rojo*/
	// 					);
	// 				}else if($today_time < $expire_time){
	// 					$array[]=array(

	// 						"id"=>$valor["id"],
	// 						"start"=>$valor["start"],
	// 						"title"=>$valor["title"],
	// 						"id_compromiso" => $valor["id_compromiso"] ,
	// 						"meta_valida" => $valor["meta_valida"],
	// 						"meta_periodo" => $valor["meta_periodo"],
	// 						"meta_val_admin" => $valor["meta_val_admin"],
	// 						"nombre_accion" => $valor["nombre_accion"],
	// 						"color" => "#00c0ef"
	// 						/*Azul Claro*/
	// 					);
	// 				}else if($today_time == $expire_time){
	// 					$array[]=array(

	// 						"id"=>$valor["id"],
	// 						"start"=>$valor["start"],
	// 						"title"=>$valor["title"],
	// 						"id_compromiso" => $valor["id_compromiso"] ,
	// 						"meta_valida" => $valor["meta_valida"],
	// 						"meta_periodo" => $valor["meta_periodo"],
	// 						"meta_val_admin" => $valor["meta_val_admin"],
	// 						"nombre_accion" => $valor["nombre_accion"],
	// 						"color" => "#001a35"
	// 						/*Azul Oscuro*/
	// 					);
	// 				}
	// 			}elseif($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 1){
	// 				$array[]=array(

	// 					"id"=>$valor["id"],
	// 					"start"=>$valor["start"],
	// 					"title"=>$valor["title"],
	// 					"id_compromiso" => $valor["id_compromiso"] ,
	// 					"meta_valida" => $valor["meta_valida"],
	// 					"meta_periodo" => $valor["meta_periodo"],
	// 					"meta_val_admin" => $valor["meta_val_admin"],
	// 					"nombre_accion" => $valor["nombre_accion"],
	// 					"color" => "#f39c12"
	// 					/*Amarillo*/
	// 				);
	// 			}else{
	// 				$array[]=array(

	// 					"id"=>$valor["id"],
	// 					"start"=>$valor["start"],
	// 					"title"=>$valor["title"],
	// 					"id_compromiso" => $valor["id_compromiso"] ,
	// 					"meta_valida" => $valor["meta_valida"],
	// 					"meta_periodo" => $valor["meta_periodo"],
	// 					"meta_val_admin" => $valor["meta_val_admin"],
	// 					"nombre_accion" => $valor["nombre_accion"],
	// 					"color" => "#00a65a"
	// 					/*Verde*/
	// 				);
	// 			}
	// 		}
	// 	}
	// 	echo json_encode($array);
	// break;

	
	// // Función para cargar los datos del filtrado por académico
	// case 'mostrarAdministrativo':

	// 	$consulta=$calendariopoa->cargarCompromisosAdministrativos();
	// 	$reg = $consulta;
	// 	$array = array();
	// 	for ($i=0;$i<count($reg);$i++){

	// 		$rsptadatos=$calendariopoa->mostrarEventosAdministrativos($reg[$i]["id_compromiso"]);
	// 		$today = date("Y-m-d");
	// 		foreach($rsptadatos as $valor) {

	// 			$today_time = strtotime($today);
	// 			$expire_time = strtotime($valor["start"]);
	// 			if($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 0){
	// 				if($today_time > $expire_time){

	// 					$array[]=array(
	// 						"id"=>$valor["id"],
	// 						"start"=>$valor["start"],
	// 						"title"=>$valor["title"],
	// 						"id_compromiso" => $valor["id_compromiso"] ,
	// 						"meta_valida" => $valor["meta_valida"],
	// 						"meta_periodo" => $valor["meta_periodo"],
	// 						"meta_val_admin" => $valor["meta_val_admin"],
	// 						"nombre_accion" => $valor["nombre_accion"],
	// 						"color" => "#dd4b39"
	// 						/*Rojo*/
	// 					);

	// 				}else if($today_time < $expire_time){
	// 					$array[]=array(

	// 						"id"=>$valor["id"],
	// 						"start"=>$valor["start"],
	// 						"title"=>$valor["title"],
	// 						"id_compromiso" => $valor["id_compromiso"] ,
	// 						"meta_valida" => $valor["meta_valida"],
	// 						"meta_periodo" => $valor["meta_periodo"],
	// 						"meta_val_admin" => $valor["meta_val_admin"],
	// 						"nombre_accion" => $valor["nombre_accion"],
	// 						"color" => "#00c0ef"
	// 						/*Azul Claro*/
	// 					);
	// 				}else if($today_time == $expire_time){
	// 					$array[]=array(

	// 						"id"=>$valor["id"],
	// 						"start"=>$valor["start"],
	// 						"title"=>$valor["title"],
	// 						"id_compromiso" => $valor["id_compromiso"] ,
	// 						"meta_valida" => $valor["meta_valida"],
	// 						"meta_periodo" => $valor["meta_periodo"],
	// 						"meta_val_admin" => $valor["meta_val_admin"],
	// 						"nombre_accion" => $valor["nombre_accion"],
	// 						"color" => "#001a35"
	// 						/*Azul Oscuro*/
	// 					);
	// 				}
	// 			}elseif($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 1){
	// 				$array[]=array(

	// 					"id"=>$valor["id"],
	// 					"start"=>$valor["start"],
	// 					"title"=>$valor["title"],
	// 					"id_compromiso" => $valor["id_compromiso"] ,
	// 					"meta_valida" => $valor["meta_valida"],
	// 					"meta_periodo" => $valor["meta_periodo"],
	// 					"meta_val_admin" => $valor["meta_val_admin"],
	// 					"nombre_accion" => $valor["nombre_accion"],
	// 					"color" => "#f39c12"
	// 					/*Amarillo*/
	// 				);
	// 			}else{
	// 				$array[]=array(
	// 					"id"=>$valor["id"],
	// 					"start"=>$valor["start"],
	// 					"title"=>$valor["title"],
	// 					"id_compromiso" => $valor["id_compromiso"] ,
	// 					"meta_valida" => $valor["meta_valida"],
	// 					"meta_periodo" => $valor["meta_periodo"],
	// 					"meta_val_admin" => $valor["meta_val_admin"],
	// 					"nombre_accion" => $valor["nombre_accion"],
	// 					"color" => "#00a65a"
	// 					/*Verde*/
	// 				);
	// 			}
	// 		}
	// 	}
	// 	echo json_encode($array);
	// break;

	

	
}
