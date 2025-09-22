<?php
session_start();
require_once "../modelos/OncenterValEntrevista.php";
$oncentervalentrevista = new OncenterValEntrevista();
$rsptaperiodo = $oncentervalentrevista->periodoactual();
$periodo_campana = $rsptaperiodo["periodo_campana"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
$periodo_medible = $rsptaperiodo["periodo_medible"];
$periodo_actual = $_SESSION['periodo_actual'];
//$periodo_siguiente=$_SESSION['periodo_siguiente'];
$usuario_cargo = $_SESSION['usuario_cargo'];
$id_usuario = $_SESSION['id_usuario'];
/* variables para editar perfil*/
$id_estudiante = isset($_POST["id_estudiante"]) ? limpiarCadena($_POST["id_estudiante"]) : "";
$fo_programa = isset($_POST["fo_programa"]) ? limpiarCadena($_POST["fo_programa"]) : "";
$jornada_e = isset($_POST["jornada_e"]) ? limpiarCadena($_POST["jornada_e"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$nombre_2 = isset($_POST["nombre_2"]) ? limpiarCadena($_POST["nombre_2"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$apellidos_2 = isset($_POST["apellidos_2"]) ? limpiarCadena($_POST["apellidos_2"]) : "";
$celular = isset($_POST["celular"]) ? limpiarCadena($_POST["celular"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$nivel_escolaridad = isset($_POST["nivel_escolaridad"]) ? limpiarCadena($_POST["nivel_escolaridad"]) : "";
$nombre_colegio = isset($_POST["nombre_colegio"]) ? limpiarCadena($_POST["nombre_colegio"]) : "";
$fecha_graduacion = isset($_POST["fecha_graduacion"]) ? limpiarCadena($_POST["fecha_graduacion"]) : "";
/* ********************* */
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
switch ($_GET["op"]) {
	case 'periodo':
		$data = array();
		$rsptaperiodo = $oncentervalentrevista->periodoactual();
		$periodo_campana = $rsptaperiodo["periodo_campana"];
		$data["periodo"] = $periodo_campana;
		echo json_encode($data);
		break;
	case 'guardaryeditar':
		if (empty($id_programa)) {
			$rspta = $oncentervalentrevista->insertar($nombre);
			echo $rspta ? "Programa registrado " : "No se pudo registrar el programa";
		} else {
			$rspta = $oncentervalentrevista->editar($id_programa, $nombre);
			echo $rspta ? "Programa actualizado" : "Programa no se pudo actualizar";
		}
		break;
	case 'listar':
		$rspta = $oncentervalentrevista->listar($periodo_campana);
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			if (isset($rspta[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $rspta[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}
			$verentrevista = $oncentervalentrevista->verEntrevista($rspta[$i]["id_estudiante"]);
			//$nombre_archivo=$verentrevista["archivo_inscripcion"];
			if ($verentrevista) {
				if ($rspta[$i]["entrevista"] == 1) {
					$enlace = '<a class="badge badge-warning pointer text-white" title="validar entrevista" onclick=validarEntrevista(' . $rspta[$i]["id_estudiante"] . ')><i class="fas fa-check-square text-white"></i> Validar</a>';
				} else {
					$enlace = '<i class="fas fa-check-square text-green"></i> Validado';
				}
			} else {
				$enlace = '';
			}
			$data[] = array(
				"0" => $rspta[$i]["id_estudiante"],
				"1" => $rspta[$i]["identificacion"],
				"2" => '<div class="tooltips fila' . $i . '" style="width:350px"><a onclick="perfilEstudiante(' . $rspta[$i]["id_estudiante"] . ',' . $rspta[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link" style="padding:0px">' . $rspta[$i]["nombre"] . " " . $rspta[$i]["nombre_2"] . " " . $rspta[$i]["apellidos"] . " " . $rspta[$i]["apellidos_2"] . '</a></div>',
				"3" => '<div style="width:150px"><button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
				 		<button onclick="agregar(' . $rspta[$i]['id_estudiante'] . ')" id="t2-seg" class="btn btn-outline-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button></div>',
				"4" => '<div style="width:100px">'.$oncentervalentrevista->getBarraProgreso($verentrevista["probabilidad_desercion"]).'</div>',
				"5" => '<div style="width:350px">'.$rspta[$i]["fo_programa"].'</div>',
				"6" => $rspta[$i]["jornada_e"],
				"7" => ($verentrevista ? "<a onclick=verEntrevista(" . $rspta[$i]["id_estudiante"] . ") class='badge badge-primary pointer text-white' title='Ver Entrevista'><i class='fas fa-eye'></i> Ver </a>" : "Pendiente"),
				"8" => $enlace,
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
	case 'perfilEstudiante':
		$id_estudiante = $_POST["id_estudiante"];
		$rspta = $oncentervalentrevista->perfilEstudiante($id_estudiante);
		echo json_encode($rspta);
		break;
	case "selectPrograma":
		$rspta = $oncentervalentrevista->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectJornada":
		$rspta = $oncentervalentrevista->selectJornada();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectTipoDocumento":
		$rspta = $oncentervalentrevista->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectNivelEscolaridad":
		$rspta = $oncentervalentrevista->selectNivelEscolaridad();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case 'editarPerfil':
		$registrovalido = $oncentervalentrevista->verFormularioEstudiante($id_estudiante);
		$formulario = $registrovalido["formulario"];
		if ($formulario == 1) { // si el formulario no se ha validado puede actualizar perfil
			$rspta = $oncentervalentrevista->editarPerfil($id_estudiante, $fo_programa, $jornada_e, $tipo_documento, $nombre, $nombre_2, $apellidos, $apellidos_2, $celular, $email, $nivel_escolaridad, $nombre_colegio, $fecha_graduacion);
			echo $rspta ? "1" : "2";
		} else {
			echo $formulario;
		}
		break;
	case 'verEntrevista':
		$id_etudiante = $_POST["id_estudiante"];
		$rspta = $oncentervalentrevista->verEntrevista($id_estudiante);
		echo json_encode($rspta);
		break;
	case 'validarEntrevista':
		$id_estudiante = $_POST["id_estudiante"];
		$data = array(); //Vamos a declarar un array
		$data["resultado"] = ""; //iniciamos el arreglo
		$data["estado"] = ""; //iniciamos el arreglo
		$rspta = $oncentervalentrevista->actualizarEntrevista($id_estudiante);
		$data["resultado"] .= $rspta ? "1" : "0";
		$motivo = "Seguimiento";
		$mensaje_seguimiento = "Validación Entrevista, Cambio a Seleccionado";
		$ressegui = $oncentervalentrevista->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);
		$registrarestado = $oncentervalentrevista->registrarestado($id_usuario, $id_estudiante, 'Seleccionado', $fecha, $hora, $periodo_campana);
		echo json_encode($data);
		break;
	case 'listarDatos':
		$nuevafecha = strtotime('-1 year', strtotime($fecha)); //Se quita un año para comparar con el año pasado los datos
		$nuevafecha = date('Y-m-d', $nuevafecha);
		$data = array(); //Vamos a declarar un array
		$data["data1"] = ""; //iniciamos el arreglo
		$mensaje_seguimiento = "Validación Entrevista, Cambio a Seleccionado";
		$mensaje_inscrito = "Cambio de estado a Inscrito";
		$rspta = $oncentervalentrevista->listarDatos($mensaje_seguimiento, $periodo_campana); // formularios validados de la campaña actual hasta hoy
		$rspta3 = $oncentervalentrevista->listarDatosFecha($mensaje_seguimiento, $periodo_medible, $nuevafecha); // formularios validados en la campaña medible (la de hace un año)
		$avance = $oncentervalentrevista->calPorcentaje(count($rspta), count($rspta3));
		if ($avance > 0) {
			$davance = '<span class="text-success">' . round($avance, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance = '<span class="text-danger">' . round($avance, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$data["data1"] .= '
			<div class="col-xl-4 col-12 py-3 pl-xl-4 m-0 ml-xl-0 ml-4" id="t-data">
				<h5 class="fw-light mb-4 text-secondary">Entrevistas validadas,</h5>
				<h1 class="titulo-2 fs-36 text-semibold"><span>' . count($rspta) . '</span> <small>a la fecha</small></h1>
				<h5 class="titulo-2 fs-18 text-semibold"><span title="Entrevistas validadas campaña comparada">' . count($rspta3) . '</span> <small>' . $davance . '</small></h5>
			</div>
		';
		echo json_encode($data);
		break;
}
