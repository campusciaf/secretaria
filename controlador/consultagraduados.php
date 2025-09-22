<?php
session_start();
require_once "../modelos/ConsultaGraduados.php";

date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:S');


$consultagraduados = new ConsultaGraduados();
$rsptaperiodo = $consultagraduados->periodoactual();
$periodo_campana = $rsptaperiodo["periodo_campana"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];

//$periodo_campana=$_SESSION['periodo_campana'];
//$periodo_siguiente=$_SESSION['periodo_siguiente'];

switch ($_GET["op"]) {
	case 'listarDos':
		$periodo = $_POST["periodo"];
		$estado = $_POST["estado"];
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$data["0"] .= '
		<div class="col-xl-12 col-lg-12 col-md-12 col-12">

		<a class="btn btn-success" style="color: white !important;"> Estudiantes Graduados</a>
		<a class="btn btn-primary"> Estudiantes Egresados</a>
		
		</div>';
		// $data["0"] .= '';
		$data["0"] .= '<table id="tbllistado" class="table">';
		$data["0"] .= '<thead>';
		$data["0"] .= '<th>Programa</th>';
		$consulta1 = $consultagraduados->listarJornada(); // consulta pra listar las jornadas en la tabla
		for ($a = 0; $a < count($consulta1); $a++) {
			$data["0"] .= '<th>' . $consulta1[$a]["codigo"] . '</th>';
		}
		$data["0"] .= '<thead>';
		$data["0"] .= '<tbody>';
		$consulta2 = $consultagraduados->listarPrograma(); // consulta para traer los programas activos
		for ($b = 0; $b < count($consulta2); $b++) {
			$nombre_programa = $consulta2[$b]["nombre"];
			$data["0"] .= '<tr>';
			$data["0"] .= '<td>';
			$data["0"] .= $nombre_programa;
			$data["0"] .= '</td>';
			$consulta3 = $consultagraduados->listarJornada(); // consulta pra listar el total por jornadas y programa
			for ($c = 0; $c < count($consulta3); $c++) {
				$jornada = $consulta3[$c]["nombre"];
				$consulta4 = $consultagraduados->listargraduados($periodo, $jornada, $nombre_programa); // listar estudiantes nuevos
				$consulta4_1 = $consultagraduados->listaregresados($periodo, $jornada, $nombre_programa); // listar estudiantes nuevos homologaciones
				$consulta4_2 = $consultagraduados->listarprogramajornadasuma($periodo, $jornada, $nombre_programa); // listar estudiantes nuevos total
				$data["0"] .= '<td>';
				// consulta para traer los estudiantes nuevos
				if (count($consulta4) > 0) {
					$data["0"] .= '<a onclick="verEstudiantes(`' . $periodo . '`,`' . $jornada . '`,`' . $nombre_programa . '`,1)" class="btn btn-success btn-xs" style="width:40px" title="Estudiantes Graduados">' . count($consulta4) . ' </a>';
				} else {
					$data["0"] .= '<a class="btn" style="width:40px"></a>';
				}
				// consulta para traer los estudiantes nuevos homologados
				if (count($consulta4_1) > 0) {
					$data["0"] .= '<a onclick="verEstudiantes(`' . $periodo . '`,`' . $jornada . '`,`' . $nombre_programa . '`,2)" class="btn btn-primary btn-xs" style="width:40px" title="Estudiantes Egresados">' . count($consulta4_1) . '</a>';
				} else {
					$data["0"] .= '<a class="btn" style="width:40px"></a>';
				}
				// consulta para traer los estudiantes nuevos total
				if (count($consulta4_2) > 0) {
					$data["0"] .= '<a onclick="verEstudiantes(`' . $periodo . '`,`' . $jornada . '`,`' . $nombre_programa . '`,3)" class="btn btn-secondary text-white btn-xs" style="width:60px" title="Total estudiantes">=' . count($consulta4_2) . '</a>';
				} else {
					$data["0"] .= '<a class="btn" style="width:40px"></a>';
				}
				$data["0"] .= '</a>';
				$data["0"] .= '</td>';
			}
			$data["0"] .= '</tr>';
		}
		$data["0"] .= '<tr>';
		$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';

		$consulta4 = $consultagraduados->listarJornada(); // consulta pra listar las sumas de las columnas
		for ($d = 0; $d < count($consulta4); $d++) {
			$jornadasuma = $consulta4[$d]["nombre"];
			$consulta5 = $consultagraduados->sumaporjornadagraduados($jornadasuma, $periodo); // consulta para estudiantes graduados
			$consulta5_1 = $consultagraduados->sumaporjornadaegresados($jornadasuma, $periodo); // consulta para estudiantes egresados
			$consulta5_2 = $consultagraduados->sumaporjornada($jornadasuma, $periodo); // consulta para estudiantes totales

			$data["0"] .= '<td>';
			if (count($consulta5) > 0) {
				$data["0"] .= '<a onclick="verEstudiantesSuma(`' . $jornadasuma . '`,`' . $periodo . '`,1)" class="btn btn-success btn-sm" style="width:40px" title="Estudiantes Graduados">' . count($consulta5) . '</a>';
			} else {
				$data["0"] .= '<a class="btn" style="width:40px"></a>';
			}
			if (count($consulta5_1) > 0) {
				$data["0"] .= '<a onclick="verEstudiantesSuma(`' . $jornadasuma . '`,`' . $periodo . '`,2)" class="btn btn-primary btn-sm" style="width:40px" title="Estudiantes Egresados">' . count($consulta5_1) . '</a>';
			} else {
				$data["0"] .= '<a class="btn" style="width:40px"></a>';
			}
			if (count($consulta5_2) > 0) {
				$data["0"] .= '<a onclick="verEstudiantesSuma(`' . $jornadasuma . '`,`' . $periodo . '`,3)" class="btn btn-secondary btn-sm" style="width:60px" title="Total Estudiantes"> =' . count($consulta5_2) . '</a>';
			} else {
				$data["0"] .= '<a class="btn" style="width:40px"></a>';
			}
			$data["0"] .= '</td>';
		}
		$data["0"] .= '</tr>';
		$data["0"] .= '</tbody>';
		$data["0"] .= '</table>';
		$consulta6 = $consultagraduados->listartotalgraduados($periodo); // consulta para traer total graduados
		$consulta6_1 = $consultagraduados->listartotalegresados($periodo); // consulta para traer total egresados
		$consulta6_2 = $consultagraduados->listartotal($periodo); // consulta para traer total de estudiantes graduados y egresados
		$data["0"] .= '<div class="alert pull-right"><h3>Total General <a onclick="verEstudiantesTotal(`' . $periodo . '`,1)" class="btn btn-success" title="Total Estudiantes Graduados">' . count($consulta6) . '</a>';
		$data["0"] .= ' <a onclick="verEstudiantesTotal(`' . $periodo . '`,2)" class="btn btn-primary" title="Total Estudiantes Egresados">' . count($consulta6_1) . '</a>';
		$data["0"] .= ' <a onclick="verEstudiantesTotal(`' . $periodo . '`,3)" class="btn btn-secondary" title="Total estudiantes Graduados y Egresados">' . count($consulta6_2) . '</a></h3></div>';

		$results = array($data);
		echo json_encode($results);

		break;

	case 'listarTres':

		$estado = $_POST["nombre_estado"];
		$medio = $_POST["medio"];
		$periodo = $_POST["periodo"];
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$data["0"] .= '<table id="tbllistado" class="table">';
		$data["0"] .= '<thead>';
		$data["0"] .= '<th>Programa</th>';
		$consulta1 = $consultagraduados->listarJornada(); // consulta pra listar las jornadas en la tabla
		for ($a = 0; $a < count($consulta1); $a++) {
			$data["0"] .= '<th>' . $consulta1[$a]["nombre"] . '</th>';
		}
		$data["0"] .= '<thead>';
		$data["0"] .= '<tbody>';
		$consulta2 = $consultagraduados->listarPrograma(); // consulta para traer los programas activos
		for ($b = 0; $b < count($consulta2); $b++) {
			$nombre_programa = $consulta2[$b]["nombre"];
			$data["0"] .= '<tr>';
			$data["0"] .= '<td>';
			$data["0"] .= $nombre_programa;
			$data["0"] .= '</td>';
			$consulta3 = $consultagraduados->listarJornada(); // consulta pra listar el total por jornadas y programa
			for ($c = 0; $c < count($consulta3); $c++) {
				$jornada = $consulta3[$c]["nombre"];
				$consulta4 = $consultagraduados->listarprogramamedio($nombre_programa, $jornada, $medio, $estado, $periodo);
				$data["0"] .= '<td>';
				$data["0"] .= '<a onclick="verEstudiantesmedio(`' . $nombre_programa . '`,`' . $jornada . '`,`' . $medio . '`,`' . $estado . '`,`' . $periodo . '`)" class="btn">' . count($consulta4) . '</a>';
				$data["0"] .= '</td>';
			}
			$data["0"] .= '</tr>';
		}
		$data["0"] .= '<tr>';
		$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';

		$consulta4 = $consultagraduados->listarJornada(); // consulta pra listar las sumas de las columnas
		for ($d = 0; $d < count($consulta4); $d++) {
			$jornadasuma = $consulta4[$d]["nombre"];
			$consulta5 = $consultagraduados->sumapormedio($jornadasuma, $medio, $estado, $periodo);
			$data["0"] .= '<td>';
			$data["0"] .= '<a onclick="verEstudiantesSumaMedio(`' . $jornadasuma . '`,`' . $medio . '`,`' . $estado . '`,`' . $periodo . '`)" class="btn btn-default btn-sm">' . count($consulta5) . '</a>';
			$data["0"] .= '</td>';
		}
		$data["0"] .= '</tr>';
		$data["0"] .= '</tbody>';
		$data["0"] .= '</table>';
		$consulta6 = $consultagraduados->listarmedio($medio, $periodo, $estado); // consulta para traer los interesados de la 
		$data["0"] .= '<div class="alert pull-right"><h3>Total General <a onclick="verEstudiantesTotalMedio(`' . $medio . '`,`' . $periodo . '`,`' . $estado . '`)" class="btn btn-primary">' . count($consulta6) . '</a></h3></div>';
		$results = array($data);
		echo json_encode($results);

		break;
	case 'verEstudiantes':
		$fo_programa = $_GET["fo_programa"];
		$jornada = $_GET["jornada"];
		$periodo = $_GET["periodo"];
		$estado = $_GET["estado"];
		if ($estado == 1) { // si son estudiantes nuevos
			$rspta = $consultagraduados->listargraduados($periodo, $jornada, $fo_programa);
		}
		if ($estado == 2) {
			$rspta = $consultagraduados->listaregresados($periodo, $jornada, $fo_programa);
		}
		if ($estado == 3) {
			$rspta = $consultagraduados->listarprogramajornadasuma($periodo, $jornada, $fo_programa);
		}
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$id_credencial = $reg[$i]["id_credencial"];
			$datoscredencialestudiante = $consultagraduados->datoscredencialestudiante($id_credencial);
			$data[] = array(
				"0" => $datoscredencialestudiante["credencial_identificacion"],
				"1" => $datoscredencialestudiante["credencial_nombre"] . " " . $datoscredencialestudiante["credencial_nombre_2"] . " " . $datoscredencialestudiante["credencial_apellido"] . " " . $datoscredencialestudiante["credencial_apellido_2"],
				"2" => $reg[$i]["fo_programa"],
				"3" => $reg[$i]["jornada_e"],
				"4" => $reg[$i]["semestre_estudiante"],
				"5" => $datoscredencialestudiante["credencial_login"],
				"6" => $reg[$i]["celular"],
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
	case 'verEstudiantesMedio':
		$nombre_programa = $_GET["nombre_programa"];
		$jornada = $_GET["jornada"];
		$medio = $_GET["medio"];
		$estado = $_GET["estado"];
		$periodo = $_GET["periodo"];

		$rspta = $consultagraduados->listarprogramamedio($nombre_programa, $jornada, $medio, $estado, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {

			$data[] = array(
				"0" => $reg[$i]["id_estudiante"],
				"1" => $reg[$i]["identificacion"],
				"2" => $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
				"3" => $reg[$i]["fo_programa"],
				"4" => $reg[$i]["jornada_e"],
				"5" => $consultagraduados->fechaesp($reg[$i]["fecha_ingreso"]),
				"6" => $reg[$i]["medio"],
				"7" => $reg[$i]["conocio"],
				"8" => $reg[$i]["contacto"]
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

	case 'verEstudiantesSuma':
		$jornada = $_GET["jornada"];
		$periodo = $_GET["periodo"];
		$estado = $_GET["estado"];
		if ($estado == 1) {
			$rspta = $consultagraduados->sumaporjornadagraduados($jornada, $periodo);
		}
		if ($estado == 2) {
			$rspta = $consultagraduados->sumaporjornadaegresados($jornada, $periodo);
		}
		if ($estado == 3) {
			$rspta = $consultagraduados->sumaporjornada($jornada, $periodo);
		}
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {

			$id_credencial = $reg[$i]["id_credencial"];
			$datoscredencialestudiante = $consultagraduados->datoscredencialestudiante($id_credencial);
			$data[] = array(
				"0" => $datoscredencialestudiante["credencial_identificacion"],
				"1" => $datoscredencialestudiante["credencial_nombre"] . " " . $datoscredencialestudiante["credencial_nombre_2"] . " " . $datoscredencialestudiante["credencial_apellido"] . " " . $datoscredencialestudiante["credencial_apellido_2"],
				"2" => $reg[$i]["fo_programa"],
				"3" => $reg[$i]["jornada_e"],
				"4" => $reg[$i]["semestre_estudiante"],
				"5" => $datoscredencialestudiante["credencial_login"],
				"6" => $reg[$i]["celular"],
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
	case 'verEstudiantesTotal':
		$periodo = $_GET["periodo"];
		$estado = $_GET["estado"];
		if ($estado == 1) {
			$rspta = $consultagraduados->listartotalgraduados($periodo);
		}
		if ($estado == 2) {
			$rspta = $consultagraduados->listartotalegresados($periodo);
		}
		if ($estado == 3) {
			$rspta = $consultagraduados->listartotal($periodo);
		}

		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;

		for ($i = 0; $i < count($reg); $i++) {
			$id_credencial = $reg[$i]["id_credencial"];
			$datoscredencialestudiante = $consultagraduados->datoscredencialestudiante($id_credencial);

			if ($reg[$i]["estado"] == 2) {
				$estado = "graduado";
			} elseif ($reg[$i]["estado"] == 5) {
				$estado = "egresado";
			} else {
				$estado = "otro estado";
			}


			$data[] = array(
				"0" => $datoscredencialestudiante["credencial_identificacion"],
				"1" => $datoscredencialestudiante["credencial_nombre"] . " " . $datoscredencialestudiante["credencial_nombre_2"] . " " . $datoscredencialestudiante["credencial_apellido"] . " " . $datoscredencialestudiante["credencial_apellido_2"],
				"2" => $reg[$i]["fo_programa"],
				"3" => $reg[$i]["jornada_e"],
				"4" => $reg[$i]["semestre_estudiante"],
				"5" => $datoscredencialestudiante["credencial_login"],
				"6" => $reg[$i]["celular"],
				"7" => $estado,
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
	case 'verEstudiantesTotalMedio':
		$medio = $_GET["medio"];
		$estado = $_GET["estado"];
		$periodo = $_GET["periodo"];
		$rspta = $consultagraduados->listarmedio($medio, $periodo, $estado);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {

			$data[] = array(
				"0" => $reg[$i]["id_estudiante"],
				"1" => $reg[$i]["identificacion"],
				"2" => $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
				"3" => $reg[$i]["fo_programa"],
				"4" => $reg[$i]["jornada_e"],
				"5" => $consultagraduados->fechaesp($reg[$i]["fecha_ingreso"]),
				"6" => $reg[$i]["medio"],
				"7" => $reg[$i]["conocio"],
				"8" => $reg[$i]["contacto"]
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

	case "selectPeriodo":
		$rspta = $consultagraduados->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
		break;
}
