<?php
require_once "../modelos/Ejes.php";

$ejes = new Ejes();

$id_ejes = isset($_POST["id_ejes"]) ? limpiarCadena($_POST["id_ejes"]) : "";
$nombre_ejes = isset($_POST["nombre_ejes"]) ? limpiarCadena($_POST["nombre_ejes"]) : "";
$periodo = isset($_POST["periodo"]) ? limpiarCadena($_POST["periodo"]) : "";
$objetivo = isset($_POST["objetivo"]) ? limpiarCadena($_POST["objetivo"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($id_ejes)) {
			$rspta = $ejes->insertar($nombre_ejes, $periodo, $objetivo);
			echo $rspta ? "ejes registrada" : "ejes no se pudo registrar";
		} else {
			$rspta = $ejes->editar($id_ejes, $nombre_ejes, $periodo, $objetivo);

			echo $rspta ? "ejes actualizada" : "ejes no se pudo actualizar";
		}
		break;


	case 'mostrar':
		$rspta = $ejes->mostrar($id_ejes);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $ejes->listar();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$data[] = array(
				"0" => '<button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg[$i]["id_ejes"] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
				
				<button class="btn btn-danger btn-sm" onclick="eliminar(' . $reg[$i]["id_ejes"] . ')" title="Eliminar"><i class="far fa-trash-alt"></i></button>',
				"1" => $reg[$i]["nombre_ejes"],
				"2" => $reg[$i]["periodo"],
				"3" => $reg[$i]["objetivo"]
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
	case 'eliminar':
		$rspta = $ejes->eliminar($id_ejes);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
}
