<?php 
session_start(); 
date_default_timezone_set('America/Bogota');
require_once "../modelos/CalendarioPoa.php";

$calendariopoa = new CalendarioPoa();
// Tomamos con la función GET la opción enviada desde el JS
$op = (isset($_GET['op']))?$_GET['op']:'mostrar';
switch ($op) {
	// Caso solo para cargar las metas de la sesión iniciada
	case 'mostrar_individual':
		$consulta=$calendariopoa->cargarCompromisoIndividual();
		$reg = $consulta;
		$array = array();
		for ($i=0;$i<count($reg);$i++){
			$rsptadatos=$calendariopoa->mostrarEventosIndivual($reg[$i]["id_compromiso"]);
			$today = date("Y-m-d");
	 		foreach($rsptadatos as $valor) {
	 			$today_time = strtotime($today);
				$expire_time = strtotime($valor["start"]);
			    if($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 0){
			    	if($today_time > $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#dd4b39"
							/*Rojo*/
						);
				    }else if($today_time < $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#00c0ef"
							/*Azul Claro*/
						);
				    }else if($today_time == $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#001a35"
							/*Azul Oscuro*/
						);
				    }
			    }elseif($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 1){
			    	$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#f39c12"
							/*Amarillo*/
						);
				}else{
			    	$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#00a65a"
							/*Verde*/
						);
			    }
			}
		}
		echo json_encode($array);
		break;
	// Caso para cargar todas las metas
	case 'mostrar':
	$consulta=$calendariopoa->mostrarEventos();
 		//Codificar el resultado utilizando json
		$array = array();
		$today = date("Y-m-d");
 		foreach($consulta as $valor) {
 			$today_time = strtotime($today);
			$expire_time = strtotime($valor["start"]);
		    if($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 0){
			    	if($today_time > $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#dd4b39"
							/*Rojo*/
						);
				    }else if($today_time < $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#00c0ef"
							/*Azul Claro*/
						);
				    }else if($today_time == $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#001a35"
							/*Azul Oscuro*/
						);
				    }
			    }elseif($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 1){
			    	$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#f39c12"
							/*Amarillo*/
						);
				}else{
			    	$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#00a65a"
							/*Verde*/
						);
			    }
		}
		echo json_encode($array);
		break;
	// Función para cargar los datos del filtrado por académico
	case 'mostrarAcademica':
		$consulta=$calendariopoa->cargarCompromisosAcademicos();
		$reg = $consulta;
		$array = array();
		for ($i=0;$i<count($reg);$i++){
			$rsptadatos=$calendariopoa->mostrarEventosAcademicos($reg[$i]["id_compromiso"]);
			$today = date("Y-m-d");
	 		foreach($rsptadatos as $valor) {
	 			$today_time = strtotime($today);
				$expire_time = strtotime($valor["start"]);
			    if($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 0){
			    	if($today_time > $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#dd4b39"
							/*Rojo*/
						);
				    }else if($today_time < $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#00c0ef"
							/*Azul Claro*/
						);
				    }else if($today_time == $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#001a35"
							/*Azul Oscuro*/
						);
				    }
			    }elseif($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 1){
			    	$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#f39c12"
							/*Amarillo*/
						);
				}else{
			    	$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#00a65a"
							/*Verde*/
						);
			    }
			}
		}
		echo json_encode($array);
		break;
	// Función para cargar los datos del filtrado por académico
	case 'mostrarAdministrativo':
		$consulta=$calendariopoa->cargarCompromisosAdministrativos();
		$reg = $consulta;
		$array = array();
		for ($i=0;$i<count($reg);$i++){
			$rsptadatos=$calendariopoa->mostrarEventosAdministrativos($reg[$i]["id_compromiso"]);
			$today = date("Y-m-d");
	 		foreach($rsptadatos as $valor) {
	 			$today_time = strtotime($today);
				$expire_time = strtotime($valor["start"]);
			    if($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 0){
			    	if($today_time > $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#dd4b39"
							/*Rojo*/
						);
				    }else if($today_time < $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#00c0ef"
							/*Azul Claro*/
						);
				    }else if($today_time == $expire_time){
						$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#001a35"
							/*Azul Oscuro*/
						);
				    }
			    }elseif($valor["meta_val_admin"] == 0 && $valor["meta_val_usuario"] == 1){
			    	$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#f39c12"
							/*Amarillo*/
						);
				}else{
			    	$array[]=array(
							"id"=>$valor["id"],
							"start"=>$valor["start"],
							"title"=>$valor["title"],
							"id_compromiso" => $valor["id_compromiso"] ,
							"meta_valida" => $valor["meta_valida"],
							"meta_periodo" => $valor["meta_periodo"],
							"meta_val_admin" => $valor["meta_val_admin"],
							"color" => "#00a65a"
							/*Verde*/
						);
			    }
			}
		}
		echo json_encode($array);
		break;
	// Función para cargar los datos de los compromisos que se van a imprimir en pantalla
	case 'cargarCompromiso':
		$id_compromiso = $_POST['id_compromiso'];
		$cargar_compromiso = $calendariopoa->cargarCompromiso($id_compromiso);
		//Codificar el resultado utilizando Json
		echo json_encode($cargar_compromiso); 
		break;
	case 'cargarUsuario':
		$id_usuario = $_POST['id_usuario'];
		$cargar_usuario = $calendariopoa->cargarDatosUsuario($id_usuario);
		//Codificar el resultado utilizando Json
		echo json_encode($cargar_usuario);
		break;
	default:
	break;
}


 ?>