<?php
session_start();
require_once "../modelos/OncenterValFormulario.php";
$oncentervalformulario = new OncenterValFormulario();
$rsptaperiodo = $oncentervalformulario->periodoactual();
$periodo_campana = $rsptaperiodo["periodo_campana"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
$periodo_medible = $rsptaperiodo["periodo_medible"];
$periodo_actual = $_SESSION['periodo_actual'];
//$periodo_siguiente = $_SESSION['periodo_siguiente'];
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
			$rspta = $oncentervalformulario->insertar($nombre);
			echo $rspta ? "Programa registrado " : "No se pudo registrar el programa";
		} else {
			$rspta = $oncentervalformulario->editar($id_programa, $nombre);
			echo $rspta ? "Programa actualizado" : "Programa no se pudo actualizar";
		}
		break;
	case 'listar':
		$rspta = $oncentervalformulario->listar($periodo_campana);
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
			$data[] = array(
				"0" => $rspta[$i]["id_estudiante"],
				"1" => $rspta[$i]["identificacion"],
				"2" => '<div class="text-lowercase m-0 p-0 fila' . $i . '">
						<a onclick="perfilEstudiante(' . $rspta[$i]["id_estudiante"] . ',' . $rspta[$i]["identificacion"] . ',' . $i . ')" title="Perfil estudiante" class="text-primary text-capitalize p-0 pointer" >
							' . $rspta[$i]["apellidos"] . " " . $rspta[$i]["apellidos_2"] . " " . $rspta[$i]["nombre"] . " " . $rspta[$i]["nombre_2"] . '
						</a>
					</div>',
				"3" => '<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
				 		<button onclick="agregar(' . $rspta[$i]["id_estudiante"] . ')" id="t2-seg" class="btn btn-outline-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button>',
				"4" => $rspta[$i]["fo_programa"],
				"5" => $rspta[$i]["jornada_e"],
				"6" => ($rspta[$i]["formulario"] == 1 ? '<a class="badge badge-sm bg-primary pointer" title="Validar formulario" onclick=validarFormulario(' . $rspta[$i]["id_estudiante"] . ')><i class="fas fa-check-square text-white"></i> Validar</a>' : '<i class="fas fa-check-square text-green"></i> Validado'),
				"7" => ($rspta[$i]["inscripcion"] == 1 ? '<i class="fas fa-check-square text-danger"></i> Pendiente' : '<i class="fas fa-check-square text-green"></i> Validado'),
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
		$rspta = $oncentervalformulario->perfilEstudiante($id_estudiante);
		echo json_encode($rspta);
		break;
	case "selectPrograma":
		$rspta = $oncentervalformulario->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectJornada":
		$rspta = $oncentervalformulario->selectJornada();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectTipoDocumento":
		$rspta = $oncentervalformulario->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectNivelEscolaridad":
		$rspta = $oncentervalformulario->selectNivelEscolaridad();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case 'editarPerfil':
		$registrovalido = $oncentervalformulario->verFormularioEstudiante($id_estudiante);
		$formulario = $registrovalido["formulario"];
		if ($formulario == 1) { // si el formulario no se ha validado puede actualizar perfil
			$rspta = $oncentervalformulario->editarPerfil($id_estudiante, $fo_programa, $jornada_e, $tipo_documento, $nombre, $nombre_2, $apellidos, $apellidos_2, $celular, $email, $nivel_escolaridad, $nombre_colegio, $fecha_graduacion);
			echo $rspta ? "1" : "2";
		} else {
			echo $formulario;
		}
		break;
	case 'validarFormulario':
		$id_estudiante = $_POST["id_estudiante"];
		$data = array(); //Vamos a declarar un array
		$data["resultado"] = ""; //iniciamos el arreglo
		$data["estado"] = ""; //iniciamos el arreglo
		$rspta = $oncentervalformulario->actualizarFormulario($id_estudiante);
		$data["resultado"] .= $rspta ? "1" : "0";
		$motivo = "Seguimiento";
		$mensaje_seguimiento = "Validación Formulario de Inscripción";
		$ressegui = $oncentervalformulario->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);
		$rspta2 = $oncentervalformulario->verDatosEstudiante($id_estudiante);
		$formulario = $rspta2["formulario"];
		$inscripcion = $rspta2["inscripcion"];
		if ($formulario == 0 and $inscripcion == 0) {
			$rspta3 = $oncentervalformulario->cambioEstado($id_estudiante);
			$motivo2 = "Seguimiento";
			$mensaje_seguimiento2 = "Cambio de estado a Inscrito";
			$ressegui2 = $oncentervalformulario->registrarSeguimiento($id_usuario, $id_estudiante, $motivo2, $mensaje_seguimiento2, $fecha, $hora);
			$registrarestado = $oncentervalformulario->registrarestado($id_usuario, $id_estudiante, 'Inscrito', $fecha, $hora, $periodo_campana);
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
		$rspta = $oncentervalformulario->listarDatos($mensaje_seguimiento, $periodo_campana); // formularios validados de la campaña actual hasta hoy
		$rspta2 = $oncentervalformulario->listarDatos($mensaje_seguimiento, $periodo_medible); // formularios validados en la campaña medible (la de hace un año)
		$rspta3 = $oncentervalformulario->listarDatosFecha($mensaje_seguimiento, $periodo_medible, $nuevafecha); // formularios validados en la campaña medible (la de hace un año)
		$rspta4 = $oncentervalformulario->listarDatos($mensaje_inscrito, $periodo_campana); // personas que validaron formulario y pasaron a inscrito en la campaña actual
		$rspta5 = $oncentervalformulario->listarDatosFecha($mensaje_inscrito, $periodo_medible, $nuevafecha); // personas preinscritas que pasaron a inscritos en la campaña medible hasta el dia de hoy
		$rspta6 = $oncentervalformulario->listarDatosMatriculados($mensaje_inscrito, $periodo_campana); // personas que validaron formulario y estan matriculados
		$rspta7 = $oncentervalformulario->listarDatosMatriculados($mensaje_inscrito, $periodo_medible); // personas que validaron formulario y estan matriculados en campaña medible
		$rspta8 = $oncentervalformulario->listarDatosMatriculadosFecha($mensaje_inscrito, $periodo_medible, $nuevafecha); // personas que validaron formulario y estan matriculados a la fecha
		$avance = $oncentervalformulario->calPorcentaje(count($rspta), count($rspta3));
		if ($avance > 0) {
			$davance = '<span class="text-success">' . round($avance, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance = '<span class="text-danger">' . round($avance, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$avance2 = $oncentervalformulario->calPorcentaje(count($rspta), count($rspta2));
		if ($avance2 > 0) {
			$davance2 = '<span class="text-success">' . round($avance2, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance2 = '<span class="text-danger">' . round($avance2, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$avance3 = $oncentervalformulario->calPorcentaje(count($rspta4), count($rspta5));
		if ($avance3 > 0) {
			$davance3 = '<span class="text-success">' . round($avance3, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance3 = '<span class="text-danger">' . round($avance3, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$avance4 = $oncentervalformulario->calPorcentaje(count($rspta6), count($rspta8));
		if ($avance4 > 0) {
			$davance4 = '<span class="text-success">' . round($avance4, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance4 = '<span class="text-danger">' . round($avance4, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$data["data1"] .= '
			<div class="col-xl-4 col-12 py-3 pl-xl-4 m-0 ml-xl-0 ml-4 " id="t-fval">
				<h5 class="fw-light mb-4 text-secondary">Formularios validados,</h5>
				<h1 class="titulo-2 fs-36 text-semibold"><span>' . count($rspta) . '</span> <small>a la fecha</small></h1>
				<h5 class="titulo-2 fs-18 text-semibold"><span title="Formularios validados campaña comparada">' . count($rspta3) . '</span> <small>' . $davance . '</small></h5>
			</div>
			<div class="row cd-single-step col-12" id="step1" style="left:20%; top:-60px">
				<div class="col-2 left">
					<span class="product-tour-js-pulse"></span>
					<span><i class="fa-solid fa-caret-left fa-2x caret"></i></span>
				</div>
				<div class="col-10  card">
					<div class="row">
						<div class="col-12 tono-3 py-3 borde-bottom">
							<div class="row">
								<div class="col-3 paso"></div>
								<div class="col-7 pt-2">
									<div class="progress progress-sm">
										<div class="progress-bar bg-primary avance"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 cd-more-info  p-4">
							<h6 class="titulo-2 fs-18 text-semibold">Formularios validados</h2>
							<p>Muestra la cantidad de formularios validados en la campaña  actual y se compara con los resultados del periodo anterior (Campaña  1 año atras)</p>
						</div>
						<div class="col-12 py-3">
							<div class="row">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-8 col-12 d-flex justify-content-end pt-2">
				<div class="row">
					<div class="row cd-single-step col-12" id="step2" style="left:-46px; top:-70px">
						<div class="col-2 right">
							<span class="product-tour-js-pulse"></span>
							<span><i class="fa-solid fa-caret-left fa-2x caret"></i></span>
						</div>
						<div class="col-10  card">
							<div class="row">
								<div class="col-12 tono-3 py-3 borde-bottom">
									<div class="row">
										<div class="col-3 paso"></div>
										<div class="col-7 pt-2">
											<div class="progress progress-sm">
												<div class="progress-bar bg-primary avance"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 cd-more-info  p-4">
									<h6 class="titulo-2 fs-18 text-semibold">Formularios validados</h2>
									<p>Tarjeta que contiene la cantidad de formularios validados en la campaña actual y la cantidad de formularios validados en la campaña comparada.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-auto col-6">
						<div class="card px-3 py-2">
							<div class="row align-items-center" id="t-val">
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
					<div class="row cd-single-step col-12" id="step3" style="left:18%; top:-70px">
						<div class="col-2 right">
							<span class="product-tour-js-pulse"></span>
							<span><i class="fa-solid fa-caret-left fa-2x caret"></i></span>
						</div>
						<div class="col-10  card" >
							<div class="row">
								<div class="col-12 tono-3 py-3 borde-bottom">
									<div class="row">
										<div class="col-3 paso"></div>
										<div class="col-7 pt-2">
											<div class="progress progress-sm">
												<div class="progress-bar bg-primary avance"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 cd-more-info  p-4" >
									<h6 class="titulo-2 fs-18 text-semibold">Inscritos</h2>
									<p>Tarjeta que contiene la cantidad de personas que validaron formulario y pasarón al estado Inscrito, en el segundo renglon se puede ver el dato de la campaña comparada al día de hoy</p>
								</div>
								<div class="col-12 py-3">
									<div class="row">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-auto col-6">
						<div class="card px-3 py-2">
							<div class="row align-items-center" id="t-ins">
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
					<div class="row cd-single-step col-12" id="step4" style="left:44%; top:-70px">
						<div class="col-2 right">
							<span class="product-tour-js-pulse"></span>
							<span><i class="fa-solid fa-caret-left fa-2x caret"></i></span>
						</div>
						<div class="col-10  card">
							<div class="row">
								<div class="col-12 tono-3 py-3 borde-bottom">
									<div class="row">
										<div class="col-3 paso"></div>
										<div class="col-7 pt-2">
											<div class="progress progress-sm">
												<div class="progress-bar bg-primary avance"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 cd-more-info  p-4">
									<h6 class="titulo-2 fs-18 text-semibold">Matriculados</h2>
									<p>Tarjeta que contiene la cantidad de personas que validaron formulario y pasarón al estado Matriculado, en el segundo renglón se puede ver el dato de la campaña comparada al día de hoy</p>
								</div>
								<div class="col-12 py-3">
									<div class="row">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-auto col-12">
						<div class="card px-3 py-2">
							<div class="row align-items-center" id="t-matri">
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