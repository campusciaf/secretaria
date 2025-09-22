<?php
require_once "../modelos/Salones.php";
$salon = new Salones();
// variable para determinar si entra en insertar o editar.
$id_oculto_salon = isset($_POST["id_oculto_salon"]) ? limpiarCadena($_POST["id_oculto_salon"]) : "";

$codigo = isset($_POST["codigo_s"]) ? limpiarCadena($_POST["codigo_s"]) : "";
$capacidad = isset($_POST["capacidad"]) ? limpiarCadena($_POST["capacidad"]) : "";
$piso = isset($_POST["piso"]) ? limpiarCadena($_POST["piso"]) : "";
$tv = isset($_POST["tv"]) ? limpiarCadena($_POST["tv"]) : "";
$video_beam = isset($_POST["video_beam"]) ? limpiarCadena($_POST["video_beam"]) : "";
$estado_formulario = isset($_POST["estado_formulario"]) ? limpiarCadena($_POST["estado_formulario"]) : "";
$sede = isset($_POST["sede"]) ? limpiarCadena($_POST["sede"]) : "";
$sede_otro = isset($_POST["sede_otro"]) ? limpiarCadena($_POST["sede_otro"]) : "";
$sede_final = (strcasecmp($sede, 'otro') === 0 && $sede_otro !== '') ? $sede_otro : $sede;


switch ($_GET['op']) {

	case 'listarSalones':
		$rspta = $salon->listarSalones();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$tv = ($rspta[$i]['tv'] == "0") ? '<div class="text-center"><button type="button" onclick=televi("' . $rspta[$i]['codigo'] . '",1) class="btn btn-danger btn-sm"><i class="far fa-times-circle"></i></button></div>' : '<div class="text-center"><button type="button" onclick=televi("' . $rspta[$i]['codigo'] . '",0) class="btn btn-success btn-sm"><i class="far fa-check-circle"></i></button></div>';
			$vide_beam = ($rspta[$i]['video_beam'] == "0") ? '<div class="text-center"><button type="button" onclick=video("' . $rspta[$i]['codigo'] . '",1) class="btn btn-danger btn-sm"><i class="far fa-times-circle"></i></button></div>' : '<div class="text-center"><button type="button" onclick=video("' . $rspta[$i]['codigo'] . '",0) class="btn btn-success btn-sm"><i class="far fa-check-circle"></i></button></div>';
			$button = ($rspta[$i]['estado'] == "0") ? '<button onclick=estado("' . $rspta[$i]['codigo'] . '",1) class="btn btn-success btn-xs"><i class="fas fa-lock-open"></i></button>' : '<button onclick=estado("' . $rspta[$i]['codigo'] . '",0) class="btn btn-danger btn-xs"><i class="fas fa-lock"></i></button>';
			$e = ($rspta[$i]['estado'] == "1") ? '<span class="label label-success">Activo</span>' : '<span  class="label label-danger">Desactivado</span>';
			$codigo_salones = $reg[$i]["codigo"];
			$estado_formulario = $reg[$i]["estado_formulario"];
			$boton_formulario = ($rspta[$i]['estado_formulario'] == "1") ? '<div class="text-center"><button type="button" onclick=activar_formulario("' . $rspta[$i]['codigo'] . '",0) class="btn btn-success btn-sm"><i class="far fa-check-circle"></i></button></div>' : '<div class="text-center"><button type="button" onclick=activar_formulario("' . $rspta[$i]['codigo'] . '",1) class="btn btn-danger btn-sm"><i class="far fa-times-circle"></i></button></div>';

			$data[] = array(
				"0" => '<div>
					
				<button class="tooltip-agregar btn btn-warning btn-xs" onclick="mostrar_salones(`' . $codigo_salones . '`)" title="Editar Salón" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
			</div>',
				"1" => $rspta[$i]['codigo'],
				"2" => $rspta[$i]['capacidad'],
				"3" => $tv,
				"4" => $vide_beam,
				"5" => $rspta[$i]['piso'],
				"6" => $e,
				"7" => $boton_formulario,
				"8" => '<button onclick=eliminarSalon("' . $rspta[$i]['codigo'] . '") class="btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></button> ' . $button
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


	case 'guardaryeditarsalon':
		if (empty($id_oculto_salon)) {
			$rspta = $salon->agregar($codigo, $capacidad, $piso, $tv, $video_beam, $sede_final, $estado_formulario);
			echo $rspta ? "Salón registrada" : "Salón no se pudo registrar";
		} else {
			$rspta = $salon->editarprogramas($codigo, $capacidad, $piso, $id_oculto_salon, $sede_final, $estado_formulario, $tv, $video_beam);
			echo $rspta ? "Salón registrada" : "Salón no se pudo registrar";
		}
		break;

	case 'eliminar':
		$id = $_POST['id'];
		$salon->eliminar($id);
		break;

	case 'estado':
		$id = $_POST['id'];
		$est = $_POST['est'];
		$salon->estado($id, $est);
		break;
	case 'video':
		$id = $_POST['id'];
		$est = $_POST['est'];
		$salon->video($id, $est);
		break;

	case 'televi':
		$id = $_POST['id'];
		$est = $_POST['est'];
		$salon->televi($id, $est);
		break;

		case 'formulario_activar':
		$id = $_POST['id'];
		$est = $_POST['est'];
		$salon->formulario_activar($id, $est);
		break;


	case 'mostrar_salones':
		$codigo_salones = $_POST['codigo_salones'];
		$rspta = $salon->mostrar_salones($codigo_salones);
		echo json_encode($rspta);
		break;


}
