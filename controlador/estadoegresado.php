<?php
require_once "../modelos/EstadoEgresado.php";

$estadoegresado = new EstadoEgresado();
$programa_ac = isset($_POST["programa_ac"]) ? limpiarCadena($_POST["programa_ac"]) : "";
$periodo = isset($_POST["periodo"]) ? limpiarCadena($_POST["periodo"]) : "";

switch ($_GET["op"]) {

	case 'consultar':
		$data = array(); //Vamos a declarar un array
		$data["programa"] = $programa_ac;
		$data["periodo"] = $periodo;
		echo json_encode($data);
		break;
	case 'listar':
		$estado = 5; // quiere decir egresado
		$programa = $_GET["programa"];
		$periodo = $_GET["periodo"];
		$rspta1 = $estadoegresado->datosPrograma($programa);
		$semestre = $rspta1["semestres"];
		$cantidad_asignaturas = $rspta1["cant_asignaturas"];
		$ciclo = $rspta1["ciclo"];
		$rspta = $estadoegresado->listar($programa, $periodo, $semestre);
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$rsptamaterias = $estadoegresado->buscarMaterias($rspta[$i]["id_estudiante"], $ciclo);
			$total = count($rsptamaterias);
			if ($total == $cantidad_asignaturas) {
				$actualizar = $estadoegresado->actualizarEstado($rspta[$i]["id_estudiante"], $estado);
				$data[] = array(
					"0" => $rspta[$i]["credencial_identificacion"],
					"1" => $rspta[$i]["id_estudiante"],
					"2" => $rspta[$i]["jornada_e"],
					"3" => $estado,
					"4" => $rspta[$i]["semestre_estudiante"],
					"5" => "Egresado",
					"6" => $rspta[$i]["periodo_activo"],
				);
			} else {
				$data[] = array(
					"0" => $rspta[$i]["credencial_identificacion"],
					"1" => $rspta[$i]["id_estudiante"],
					"2" => $rspta[$i]["jornada_e"],
					"3" => $rspta[$i]["estado"],
					"4" => $rspta[$i]["semestre_estudiante"],
					"5" => $cantidad_asignaturas . '/' . $total,
					"6" => $rspta[$i]["periodo_activo"],
				);
			}
			$i++;
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;
	// case 'mostrar':
	// 	$rspta = $estadoegresado->mostrar($id);
	// 	//Codificar el resultado utilizando json
	// 	echo json_encode($rspta);

	// 	break;
	case "selectPrograma":
		$rspta = $estadoegresado->selectPrograma();
		echo "<option value='todos'>Todos</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectPeriodo":
		$rspta = $estadoegresado->selectPeriodo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
		break;
}
