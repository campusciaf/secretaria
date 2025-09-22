<?php
require_once "../modelos/MateriasPrograma.php";
$materiasprograma = new MateriasPrograma();
$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$programa = isset($_POST["programa"]) ? limpiarCadena($_POST["programa"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$semestre = isset($_POST["semestre"]) ? limpiarCadena($_POST["semestre"]) : "";
$area = isset($_POST["area"]) ? limpiarCadena($_POST["area"]) : "";
$creditos = isset($_POST["creditos"]) ? limpiarCadena($_POST["creditos"]) : "";
$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$presenciales = isset($_POST["presenciales"]) ? limpiarCadena($_POST["presenciales"]) : "";
$independiente = isset($_POST["independiente"]) ? limpiarCadena($_POST["independiente"]) : "";
$escuela = isset($_POST["escuela"]) ? limpiarCadena($_POST["escuela"]) : "";
$modelo = isset($_POST["modelo"]) ? limpiarCadena($_POST["modelo"]) : "";
$modalidad_grado = isset($_POST["modalidad_grado"]) ? limpiarCadena($_POST["modalidad_grado"]) : "";
/* modalidada agregar */
$id_materias_ciafi_modalidad = isset($_POST["id_materias_ciafi_modalidad"]) ? limpiarCadena($_POST["id_materias_ciafi_modalidad"]) : "";
$id_materia_add = isset($_POST["id_materia_add"]) ? limpiarCadena($_POST["id_materia_add"]) : "";
$modalidad_add = isset($_POST["modalidad_add"]) ? limpiarCadena($_POST["modalidad_add"]) : "";
switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($id)) {
			$rspta1 = $materiasprograma->mostrarIdPrograma($programa);
			$id_programa = $rspta1["id_programa"];
			$rspta = $materiasprograma->insertar($id_programa, $programa, $nombre, $semestre, $area, $creditos, $codigo, $presenciales, $independiente, $escuela, $modelo, $modalidad_grado);
			echo $rspta ? "Materia registrada " : "No se pudo registrar la materia";
		} else {
			$rspta = $materiasprograma->editar($id, $programa, $nombre, $semestre, $area, $creditos, $codigo, $presenciales, $independiente, $escuela, $modelo, $modalidad_grado);
			echo $rspta ? "Materia actualizado" : "Materia no se pudo actualizar";
		}
		break;
	case 'guardaryeditarmodalidad':
		$data["datos"] = "";
		$data["id"] = "";
		if (empty($id_materias_ciafi_modalidad)) {
			$rspta = $materiasprograma->insertarModalidad($id_materia_add, $modalidad_add);
			$rspta ? "1" : "2";
			$data["datos"] = $rspta;
			$data["id"] = $id_materia_add;
		} else {
			$rspta = $materiasprograma->editar($id, $programa, $nombre, $semestre, $area, $creditos, $codigo, $presenciales, $independiente, $escuela, $modelo, $modalidad_grado);
			$rspta ? "1" : "2";
			$data["datos"] = $rspta;
		}
		echo json_encode($data);
		break;
	case "ModalidadGrado":
		$data = array();
		$data["datos"] = "";
		$data["id"] = "";
		$id_materia = $_POST["id_materia"];
		$modalidaddatos = $materiasprograma->ModalidadGrado($id_materia);
		$data["datos"] .= '
		<table class="table table-sm">
			<tbody>';
		for ($a = 0; $a < count($modalidaddatos); $a++) {
			$modalidad = $modalidaddatos[$a]["modalidad"];
			$id_materias_ciafi_modalidad = $modalidaddatos[$a]["id_materias_ciafi_modalidad"];
			$data["datos"] .= '

					<tr>
						<td>' . $modalidad . '</td>
						<td>
							<button class="btn btn-danger btn-sm" onclick="eliminarmodalidad(' . $id_materias_ciafi_modalidad . ',' . $id_materia . ')" title="Eliminar">
								<i class="fa fa-trash"></i>
							</button>
							
						</td>
					</tr>';
		}
		$data["datos"] .= '
			</tbody>
		</table>';
		$data["id"] = $id_materia;
		echo json_encode($data);
		break;
	case 'listar':
		$programa = $_GET["programa"];
		$rspta = $materiasprograma->listar($programa);
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$boton_editar = '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $rspta[$i]["id"] . ')" title="Editar">
								<i class="fas fa-pencil-alt"></i>
							</button>';
			$boton_agregar = '<button class="btn btn-primary btn-xs" onclick="modalidadGrado(' . $rspta[$i]["id"] . ')" title="Agregar materia">
								<i class="fas fa-plus"></i>
							</button>';
			$data[] = array(
				"0" => ($rspta[$i]["modalidad_grado"] == 1) ? $boton_editar : $boton_editar . '' . $boton_agregar,
				"1" => $rspta[$i]["nombre"],
				"2" => $rspta[$i]["semestre"],
				"3" => $rspta[$i]["area"],
				"4" => $rspta[$i]["creditos"],
				"5" => $rspta[$i]["codigo"],
				"6" => $rspta[$i]["presenciales"],
				"7" => $rspta[$i]["independiente"],
				"8" => $rspta[$i]["escuela"]
			);
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
	case 'mostrar':
		$rspta = $materiasprograma->mostrar($id);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case "selectEscuela":
		$rspta = $materiasprograma->selectEscuela();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["escuelas"] . "'>" . $rspta[$i]["escuelas"] . "</option>";
		}
		break;
	case "selectPrograma":
		$rspta = $materiasprograma->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectArea":
		$rspta = $materiasprograma->selectArea();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["area_nombre"] . "'>" . $rspta[$i]["area_nombre"] . "</option>";
		}
		break;
	case 'eliminarmodalidad':
		$data = array();
		$data["datos"] = "";
		$id_materias_ciafi_modalidad = $_POST['id_materias_ciafi_modalidad'];
		$rspta = $materiasprograma->eliminarmodalidad($id_materias_ciafi_modalidad);
		if (!$rspta) {
			$data['datos'] = 1;
		} else {
			$data['datos'] = 2;
		}
		echo json_encode($data);
		break;
}