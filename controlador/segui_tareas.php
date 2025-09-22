<?php
session_start();
date_default_timezone_set("America/Bogota");
require_once "../modelos/SeguiTareas.php";
$consulta = new SeguiTareas();
$id_usuario = $_SESSION['id_usuario'];
$periodo_actual = $_SESSION['periodo_actual'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');
switch ($_GET['op']) {
	case 'verHistorial':
		$id_credencial = $_POST["id_credencial"];
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$results = array($data);
		echo json_encode($results);
		break;
	case 'verSeguimiento':
		$id_credencial = $_GET["id_credencial"];
		$rspta = $consulta->sofiSeguimientos($id_credencial);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $consulta->datosAsesor($reg[$i]["id_asesor"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];
			$datetime = $reg[$i]["created_at"];
			list($date, $time) = explode(" ", $datetime);
			$time_12_hour_format = date("g:i A", strtotime($time));
			$data[] = array(
				"0" => $reg[$i]["id_persona"],
				"1" => $reg[$i]["seg_tipo"],
				"2" => $reg[$i]["seg_descripcion"],
				"3" => $consulta->fechaesp($date),
				"4" => $time_12_hour_format,
				"5" => $nombre_usuario
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'verTareasProgramadas':
		$id_credencial = $_GET["id_credencial"];
		$rspta = $consulta->sofiTareasProgramadas($id_credencial);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $consulta->datosAsesor($reg[$i]["id_asesor"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];
			$time_12_hour_format = date("g:i A", strtotime($reg[$i]["tarea_hora"]));
			$data[] = array(
				"0" => ($reg[$i]["tarea_estado"] == 0) ? 'Pendiente' : 'Realizada',
				"1" => $reg[$i]["tarea_motivo"],
				"2" => $reg[$i]["tarea_observacion"],
				"3" => $consulta->fechaesp($reg[$i]["tarea_fecha"]),
				"4" => $time_12_hour_format,
				"5" => $nombre_usuario
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
}