<?php
session_start();
require_once "../modelos/OncenterValInscripcion.php";
$oncentervalinscripcion = new OncenterValInscripcion();
$rsptaperiodo = $oncentervalinscripcion->periodoactual();
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
	case 'guardaryeditar':
		if (empty($id_programa)) {
			$rspta = $oncentervalinscripcion->insertar($nombre);
			echo $rspta ? "Programa registrado " : "No se pudo registrar el programa";
		} else {
			$rspta = $oncentervalinscripcion->editar($id_programa, $nombre);
			echo $rspta ? "Programa actualizado" : "Programa no se pudo actualizar";
		}
		break;
	case 'listar':
		$rspta = $oncentervalinscripcion->listar($periodo_campana);
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
			$verrecibo = $oncentervalinscripcion->verRecibo($rspta[$i]["id_estudiante"]);
			@$nombre_archivo = $verrecibo["nombre_archivo"];
			if ($verrecibo) {
				if ($rspta[$i]["inscripcion"] == 1) {
					$enlace = '<a class="badge badge-warning pointer" title="validar inscripción" onclick=validarInscripcion(' . $rspta[$i]["id_estudiante"] . ')><i class="fas fa-check-square text-white"></i> Validar</a>';
				} else {
					$enlace = '<i class="fas fa-check-square text-green"></i> Validado';
				}
			} else {
				$enlace = '';
			}
			$data[] = array(
				"0" => $rspta[$i]["id_estudiante"],
				"1" => $rspta[$i]["identificacion"],
				"2" => '<div class="text-lowercase m-0 p-0 fila' . $i . '">
							<a onclick="perfilEstudiante(' . $rspta[$i]["id_estudiante"] . ',' . $rspta[$i]["identificacion"] . ',' . $i . ')" title="Perfil estudiante" class="text-primary text-capitalize p-0 pointer" >
								' . $rspta[$i]["apellidos"] . " " . $rspta[$i]["apellidos_2"] . " " . $rspta[$i]["nombre"] . " " . $rspta[$i]["nombre_2"] . '
							</a>
						</div>',
				"3" => '<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
				 <button onclick="agregar(' . $rspta[$i]['id_estudiante'] . ')" id="t2-seg" class="btn btn-outline-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button>',
				"4" => $rspta[$i]["fo_programa"],
				"5" => $rspta[$i]["jornada_e"],
				"6" => ($verrecibo ? "<a href='../files/oncenter/img_inscripcion/" . $nombre_archivo . "' target='_blank' class='badge badge-primary pointer' title='Ver Soporte'><i class='fas fa-eye'></i> Ver recibo</a>" : "Pendiente"),
				"7" => $enlace,
				"8" => ($rspta[$i]["formulario"] == 1 ? '<i class="fas fa-check-square text-red"></i> Pendiente' : '<i class="fas fa-check-square text-green"></i> Validado'),
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
		$rspta = $oncentervalinscripcion->perfilEstudiante($id_estudiante);
		echo json_encode($rspta);
		break;
	case "selectPrograma":
		$rspta = $oncentervalinscripcion->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectJornada":
		$rspta = $oncentervalinscripcion->selectJornada();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectTipoDocumento":
		$rspta = $oncentervalinscripcion->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectNivelEscolaridad":
		$rspta = $oncentervalinscripcion->selectNivelEscolaridad();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case 'editarPerfil':
		$registrovalido = $oncentervalinscripcion->verFormularioEstudiante($id_estudiante);
		$formulario = $registrovalido["formulario"];
		if ($formulario == 1) { // si el formulario no se ha validado puede actualizar perfil
			$rspta = $oncentervalinscripcion->editarPerfil($id_estudiante, $fo_programa, $jornada_e, $tipo_documento, $nombre, $nombre_2, $apellidos, $apellidos_2, $celular, $email, $nivel_escolaridad, $nombre_colegio, $fecha_graduacion);
			echo $rspta ? "1" : "2";
		} else {
			echo $formulario;
		}
		break;
	case 'validarInscripcion':
		$id_estudiante = $_POST["id_estudiante"];
		$data = array(); //Vamos a declarar un array
		$data["resultado"] = ""; //iniciamos el arreglo
		$data["estado"] = ""; //iniciamos el arreglo
		$rspta = $oncentervalinscripcion->actualizarInscripcion($id_estudiante);
		$data["resultado"] .= $rspta ? "1" : "0";
		$motivo = "Seguimiento";
		$mensaje_seguimiento = "Validación Recibo de Inscripción";
		$ressegui = $oncentervalinscripcion->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);
		$rspta2 = $oncentervalinscripcion->verDatosEstudiante($id_estudiante);
		$formulario = $rspta2["formulario"];
		$inscripcion = $rspta2["inscripcion"];
		if ($formulario == 0 and $inscripcion == 0) {
			$rspta3 = $oncentervalinscripcion->cambioEstado($id_estudiante);
			$motivo2 = "Seguimiento";
			$mensaje_seguimiento2 = "Cambio de estado a Inscrito";
			$ressegui2 = $oncentervalinscripcion->registrarSeguimiento($id_usuario, $id_estudiante, $motivo2, $mensaje_seguimiento2, $fecha, $hora);
			$registrarestado = $oncentervalinscripcion->registrarestado($id_usuario, $id_estudiante, 'Inscrito', $fecha, $hora, $periodo_campana);
			$data["estado"] .= '1';
		} else {
			$data["estado"] .= '0';
		}
		echo json_encode($data);
		break;
	case 'listarDatos':
		$nuevafecha = strtotime('-1 year', strtotime($fecha)); //Se quita un año para comparar con el año pasado los datos
		$nuevafecha = date('Y-m-d', $nuevafecha);
		$data = array(); //Vamos a declarar un array
		$data["data1"] = ""; //iniciamos el arreglo
		$mensaje_seguimiento = "Validación Formulario de Inscripción";
		$mensaje_inscrito = "Cambio de estado a Inscrito";
		$rspta = $oncentervalinscripcion->listarDatos($mensaje_seguimiento, $periodo_campana); // formularios validados de la campaña actual hasta hoy
		$rspta2 = $oncentervalinscripcion->listarDatos($mensaje_seguimiento, $periodo_medible); // formularios validados en la campaña medible (la de hace un año)
		$rspta3 = $oncentervalinscripcion->listarDatosFecha($mensaje_seguimiento, $periodo_medible, $nuevafecha); // formularios validados en la campaña medible (la de hace un año)
		$rspta4 = $oncentervalinscripcion->listarDatos($mensaje_inscrito, $periodo_campana); // personas que validaron formulario y pasaron a inscrito en la campaña actual
		$rspta5 = $oncentervalinscripcion->listarDatosFecha($mensaje_inscrito, $periodo_medible, $nuevafecha); // personas preinscritas que pasaron a inscritos en la campaña medible hasta el dia de hoy
		$rspta6 = $oncentervalinscripcion->listarDatosMatriculados($mensaje_inscrito, $periodo_campana); // personas que validaron formulario y estan matriculados
		$rspta7 = $oncentervalinscripcion->listarDatosMatriculados($mensaje_inscrito, $periodo_medible); // personas que validaron formulario y estan matriculados en campaña medible
		$rspta8 = $oncentervalinscripcion->listarDatosMatriculadosFecha($mensaje_inscrito, $periodo_medible, $nuevafecha); // personas que validaron formulario y estan matriculados a la fecha
		$avance = $oncentervalinscripcion->calPorcentaje(count($rspta), count($rspta3));
		if ($avance > 0) {
			$davance = '<span class="text-success">' . round($avance, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance = '<span class="text-danger">' . round($avance, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$avance2 = $oncentervalinscripcion->calPorcentaje(count($rspta), count($rspta2));
		if ($avance2 > 0) {
			$davance2 = '<span class="text-success">' . round($avance2, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance2 = '<span class="text-danger">' . round($avance2, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$avance3 = $oncentervalinscripcion->calPorcentaje(count($rspta4), count($rspta5));
		if ($avance3 > 0) {
			$davance3 = '<span class="text-success">' . round($avance3, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance3 = '<span class="text-danger">' . round($avance3, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$avance4 = $oncentervalinscripcion->calPorcentaje(count($rspta6), count($rspta8));
		if ($avance4 > 0) {
			$davance4 = '<span class="text-success">' . round($avance4, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance4 = '<span class="text-danger">' . round($avance4, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$data["data1"] .= '
			<div class="col-xl-4 col-12 py-3 pl-xl-4 m-0 ml-xl-0 ml-4">
				<h5 class="fw-light mb-4 text-secondary">Formularios validados,</h5>
				<h1 class="titulo-2 fs-36 text-semibold"><span>' . count($rspta) . '</span> <small>a la fecha</small></h1>
				<h5 class="titulo-2 fs-18 text-semibold"><span title="Formularios validados campaña comparada">' . count($rspta3) . '</span> <small>' . $davance . '</small></h5>
			</div>
			<div class="col-xl-8 col-12 d-flex justify-content-end pt-2">
				<div class="row">
						<div class="col-2 right">
						</div>	
					</div>
					<div class="col-xl-auto col-6">
						<div class="card px-3 py-2">
							<div class="row align-items-center">
								<div class="col-auto">
								<i class="fa-solid fa-align-justify p-3 bg-purple rounded-circle" style="color:#fff !important"></i>
								</div>
								<div class="col ps-0 line-height-16">
									<h4 class="titulo-2 fs-24 text-semibold"><span class="increamentcount" title="Total campaña actual">' . count($rspta) . '</span> <small class="h6">Val.</small></h4>
									<p class="fs-14 mb-0"><span class="titulo-2 fs-14" title="Campaña comparada">' . count($rspta2) . '</span> <span class="text-secondary">' . $periodo_medible . '</span></p>
									<p class="small">' . count($rspta) - count($rspta2) . ' ' . $davance2 . '</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-auto col-6">
						<div class="card px-3 py-2">
							<div class="row align-items-center">
								<div class="col-auto">
								<i class="fa-solid fa-align-justify p-3 bg-orange rounded-circle" style="color:#fff !important"></i>
								</div>
								<div class="col ps-0 line-height-16">
									<h4 class="titulo-2 fs-24 text-semibold"><span class="increamentcount" title="Avanzarón al estado de inscrito">' . count($rspta4) . '</span> <small class="h6">Inscritos</small></h4>
									<p class="fs-14 mb-0"><span class="titulo-2 fs-14" title="Avanzarón a inscritos al día de hoy">' . count($rspta5) . '</span> <span class="text-secondary">' . $periodo_medible . '</span></p>
									<p class="small">' . count($rspta4) - count($rspta5) . ' ' . $davance3 . '</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-auto col-12">
						<div class="card px-3 py-2">
							<div class="row align-items-center">
								<div class="col-auto">
								<i class="fa-solid fa-align-justify p-3 bg-success rounded-circle" style="color:#fff !important"></i>
								</div>
								<div class="col ps-0 line-height-16">
									<h4 class="titulo-2 fs-24 text-semibold"><span class="increamentcount" title="Avanzarón a matriculados campaña actual">' . count($rspta6) . '</span> <small class="h6">Matri.</small></h4>
									<p class=" fs-14 mb-0"><span class="titulo-2 fs-14" title="Avanzarón a matriculados hasta el día de hoy">' . count($rspta8) . '</span> <span class="text-secondary">' . $periodo_medible . '</span></p>
									<p class="small">' . count($rspta6) - count($rspta8) . ' ' . $davance4 . '</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		';
		echo json_encode($data);
		break;
}
