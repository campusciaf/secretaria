<?php
session_start();
require_once "../modelos/EgresadosGraduadosPrograma.php";

date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:S');
$egresadosgraduadosprograma = new EgresadosGraduadosPrograma();
$rsptaperiodo = $egresadosgraduadosprograma->periodoactual();
$periodo_campana = $rsptaperiodo["periodo_campana"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];

switch ($_GET["op"]) {
	case 'listar':
		$id_programa = $_GET["id_programa"];
		$data = array();
		$datos = $egresadosgraduadosprograma->listargraduadosegresado($id_programa);
		for ($i = 0; $i < count($datos); $i++) {
			$estado = "";
			if ($datos[$i]["estado"] == 2) {
				$estado = "Graduado";
			} else {
				$estado = "Egresado";
			}
			$data[] = array(
				"0" => $datos[$i]["credencial_identificacion"],
				"1" => $datos[$i]["credencial_apellido"] . " " . $datos[$i]["credencial_apellido_2"] . " " . $datos[$i]["credencial_nombre"] . " " . $datos[$i]["credencial_nombre_2"],
				"2" => $datos[$i]["fo_programa"],
				"3" => $datos[$i]["jornada_e"],
				"4" => $datos[$i]["semestre_estudiante"],
				"5" => $datos[$i]["credencial_login"],
				"6" => $datos[$i]["celular"],
				"7" => $estado,
				"8" => $datos[$i]["periodo_activo"],
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
	case "selectPrograma":
		$rspta = $egresadosgraduadosprograma->selectPrograma();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
}
