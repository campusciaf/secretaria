<?php
session_start();
require_once "../modelos/AdminCalendarioEventos.php";
$admin_calendario_eventos = new AdminCalendarioEventos();
$id_tipo_asistente = isset($_POST["id_tipo_asistente"]) ? limpiarCadena($_POST["id_tipo_asistente"]) : "";
$id_actividad = isset($_POST["id_actividad"]) ? limpiarCadena($_POST["id_actividad"]) : "";
$id_evento = isset($_POST["id_evento"]) ? limpiarCadena($_POST["id_evento"]) : "";
$rsptaperiodo = $admin_calendario_eventos->periodoactual();
$periodo_actual = $_SESSION['periodo_actual'];
$id_usuario = $_SESSION['id_usuario'];
$anno = $_SESSION['sac_periodo'];
$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'leer';
switch ($accion) {

	case 'agregar':
		// Recibir datos del POST
		$actividad = $_POST['title'];
		$fecha_inicio = $_POST['start'];
		$fecha_final = $_POST['end'];
		$hora = $_POST['time'];
		$descripcion = $_POST['descripcion'];
		$id_actividad = $_POST['id_actividad'];
		$respuesta = $admin_calendario_eventos->insertarEventos($actividad, $descripcion, $fecha_inicio, $fecha_final, $hora, $id_actividad, $anno);
		echo json_encode($respuesta);
		// Insertar datos de evento en la tabla calendario
		break;

	case 'eliminar':
		// Recibir id del POST
		$id = $_POST['id'];
		$respuesta = false;
		// Condicional para validar que haya id
		if (isset($id)) {
			// Eliminar evento en la tabla calendario
			$respuesta = $admin_calendario_eventos->eliminarEventos($id);
			echo json_encode($respuesta);
		}
		break;

	case 'modificar':
		// Recibir id del POST
		$id = $_POST['id'];
		$actividad = $_POST['title'];
		$descripcion = $_POST['descripcion'];
		$fecha_inicio = $_POST['start'];
		$fecha_final = $_POST['end'];
		$hora = $_POST['time'];
		$id_actividad = $_POST['id_actividad'];
		$respuesta = false;
		// Condicional para validar que haya id
		if (isset($id)) {
			// Modificar evento en la tabla calendario
			$respuesta = $admin_calendario_eventos->modificarEventos($id, $actividad, $descripcion, $fecha_inicio, $fecha_final, $hora, $id_actividad);
			// print_r($respuesta);
			echo json_encode($respuesta);
		}
		break;

	case 'listar-eventos':
		$data["contenido"] = "";
		$eventos = $admin_calendario_eventos->listarEventosActual($anno);
		$data["contenido"] .= '
			<div class="col-12">
				<div class="row p-0 m-0">
					<div class="col-xl-2 col-lg-8 col-md-8 col-12 pt-2 tono-3 ">
						<div class="row align-items-center pt-2 mb-4">
							<div class="col-xl-3">
								<span class="rounded bg-light-green p-3 text-success">
									<i class="fa-solid fa-headset" aria-hidden="true"></i>
								</span> 
							</div>
							<div class="col-xl-9">
								<span class="fs-14 line-height-18">Siguiente</span><br>
								<span class="text-semibold fs-16 titulo-2 line-height-16" id="dato_periodo">Nivel </span> 
							</div>
						</div>
						<div class="row">
							<div class="col-xl-12 p-4 borde-top ">
								<span>Eventos Bienestar</span>
								<span class="titulo-2 text-semibold fs-24 line-height-16">' . $anno . '</span>
							</div>
							<div class="col-12"><a onclick="todosEventosPorPeriodo()" class="btn btn-success text-white">Ver todos los eventos</a></div>
						</div>
					</div>
					<div class="col-xl-10 pt-2 ">
						<div id="forcecentered">
							<div class="event-list bd-highlight eventos">

		';
		for ($a = 0; $a < count($eventos); $a++) {
			$fecha = date($eventos[$a]["fecha_inicio"]);
			// echo "-".$fecha;
			// print_r($fecha);
			$dia = date("d", strtotime($fecha));
			$mes = date("m", strtotime($fecha));
			$horas = date($eventos[$a]["hora"]);
			$hora = date("h:i a",  strtotime($horas));
			switch ($mes) {
				case '01':
					$meses = "Ene";
					break;
				case '02':
					$meses = "Feb";
					break;
				case '03':
					$meses = "Mar";
					break;
				case '04':
					$meses = "Abr";
					break;
				case '05':
					$meses = "May";
					break;
				case '06':
					$meses = "Jun";
					break;
				case '07':
					$meses = "Jul";
					break;
				case '08':
					$meses = "Ago";
					break;
				case '09':
					$meses = "Sep";
					break;
				case '10':
					$meses = "Oct";
					break;
				case '11':
					$meses = "Nov";
					break;
				case '12':
					$meses = "Dic";
					break;
			}

			$actividad_pertenece = $admin_calendario_eventos->selectActividadActiva($eventos[$a]["id_actividad"]);
			$totalparticipante = $admin_calendario_eventos->totalactividad($eventos[$a]["id_evento"]);
			$total_participantes = $totalparticipante["total_participantes"];
			// echo date("H:i:s");
			// echo $dia_sistema;
			// if((strtotime(date("H:i:s")) == strtotime($meses) && strtotime(date("H:i:s")) <= strtotime($fecha)  )){
			$data["contenido"] .= '
				<div class="card m-2">
					<div class="col-auto p-2 line-height-16 fs-14 d-flex align-items-center text-white text-semibold" style="height:50px; background-color:' . $actividad_pertenece["color"] . '">
						' . $actividad_pertenece["actividad"] . '
					</div>
					<div class="row px-3">
						<div class="col-5 d-flex align-items-center">
							<div class="row">
								<div class="col-12">
									<span class="day fs-36 titulo-2 text-semibold p-2">' . $dia . '</span><span class="fs-12">' . $meses . ' </span>
								</div>
								<div class="col-12">
									<span class="fs-16">' . $hora . '</span>
								</div>
							</div>
							
						</div>
						<div class="col-7 d-flex align-items-center pt-2 titulo-2 line-height-16 fs-14" style="height:80px" >
							' . $eventos[$a]["evento"] . '
						</div>
						<div class="col-12 py-4">
							<a onclick="gestionEvento(' . $eventos[$a]["id_evento"] . ')" title="Gestionar" class="btn btn-success btn-sm text-white">
								<i class="fas fa-plus"></i> Gestionar
							</a>
							<span class="borde p-2" title="Total Participantes"><i class="fa-solid fa-users"></i> ' . $total_participantes . '</span>
						</div>
					</div>
				</div>
			';
		}
		$data["contenido"] .= '	   
			
							</div>
						</div>
					</div>
				</div>
			</div>';

		echo json_encode($data);

		break;

	case 'todos-eventos':

		$data["contenido"] = "";
		$eventos = $admin_calendario_eventos->listarEventos();


		$data["contenido"] .= '

			<div class="col-8 px-4 py-3 tono-3">
				<div class="row align-items-center">
					<div class="col-auto">
						<span class="rounded bg-light-green p-2 text-success ">
						<i class="fa-regular fa-calendar" aria-hidden="true"></i>
						</span> 
					</div>
					<div class="col-9">
						<span class="">Eventos</span> <br>
						<span class="text-semibold fs-16 titulo-2 line-height-16">2024</span> 
					</div>
				</div>
			</div>
			<div class="col-4 p-4 tono-3">
				<a onclick="volver()" class="btn btn-primary float-right">Volver</a>
			</div>
			
			<div class="col-12 card">
				<div class="row">
		';

		for ($a = 0; $a < count($eventos); $a++) {

			$fecha = date($eventos[$a]["fecha_inicio"]);
			// echo "-".$fecha;
			// print_r($fecha);
			$dia = date("d", strtotime($fecha));
			$mes = date("m", strtotime($fecha));

			$horas = date($eventos[$a]["hora"]);
			$hora = date("h:i a",  strtotime($horas));


			switch ($mes) {
				case '01':
					$meses = "Ene";
					break;
				case '02':
					$meses = "Feb";
					break;
				case '03':
					$meses = "Mar";
					break;
				case '04':
					$meses = "Abr";
					break;
				case '05':
					$meses = "May";
					break;
				case '06':
					$meses = "Jun";
					break;
				case '07':
					$meses = "Jul";
					break;
				case '08':
					$meses = "Ago";
					break;
				case '09':
					$meses = "Sep";
					break;
				case '10':
					$meses = "Oct";
					break;
				case '11':
					$meses = "Nov";
					break;
				case '12':
					$meses = "Dic";
					break;
			}

			$actividad_pertenece = $admin_calendario_eventos->selectActividadActiva($eventos[$a]["id_actividad"]);

			$totalparticipante = $admin_calendario_eventos->totalactividad($eventos[$a]["id_evento"]);
			$total_participantes = $totalparticipante["total_participantes"];
			// echo date("H:i:s");
			// echo $dia_sistema;
			// if((strtotime(date("H:i:s")) == strtotime($meses) && strtotime(date("H:i:s")) <= strtotime($fecha)  )){

			$data["contenido"] .= '

							<div class="col-3 mt-2">
								<div class="row">
									<div class="col-12 px-4">
										<div class="row borde">
											<div class=" col-12 p-2 text-white text-semibold" style="background-color:' . $actividad_pertenece["color"] . '">' . $actividad_pertenece["actividad"] . '</div>
											<div class="col-5 d-flex align-items-center">
												<div class="row">
													<div class="col-12">
														<span class="day fs-36 titulo-2 text-semibold p-2">' . $dia . '</span><span class="fs-12">' . $meses . ' </span>
													</div>
													<div class="col-12">
														<span class="fs-16">' . $hora . '</span>
													</div>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center pt-2 titulo-2 line-height-16 fs-14" style="height:80px" >
												' . $eventos[$a]["evento"] . '
											</div>

											<div class="col-12 py-4">
												<a onclick="gestionEvento(' . $eventos[$a]["id_evento"] . ')" title="Gestionar" class="btn btn-success btn-sm text-white">
													<i class="fas fa-plus"></i> Gestionar
												</a>
												<span class="borde p-2" title="Total Participantes"><i class="fa-solid fa-users"></i> ' . $total_participantes . '</span>
											</div>
										
										</div>
									</div>
								</div>
							</div>
						';

			// }




		}

		$data["contenido"] .= '
				</div>
			</div>';

		echo json_encode($data);

		break;

	case "selectActividad":

		$id_actividad = $_POST["id_actividad"];
		if ($id_actividad == 0) {

			$rspta = $admin_calendario_eventos->selectActividad();
			for ($i = 0; $i < count($rspta); $i++) {
				echo "<option value='" . $rspta[$i]["id_actividad"] . "'>" . $rspta[$i]["actividad"] . "</option>";
			}
		} else {
			$rspta1 = $admin_calendario_eventos->selectActividadActiva($id_actividad);
			echo "<option value='" . $id_actividad . "' selected >" . $rspta1["actividad"] . "</option>";
			$rspta2 = $admin_calendario_eventos->selectActividad();
			for ($j = 0; $j < count($rspta2); $j++) {
				echo "<option value='" . $rspta2[$j]["id_actividad"] . "'>" . $rspta2[$j]["actividad"] . "</option>";
			}
		}


		break;

	case 'actividades':

		$data["contenido"] = "";
		$estudiantes_activos = $admin_calendario_eventos->estudiantesactivos($periodo_actual);


		$actividad = $admin_calendario_eventos->selectActividad();

		$data["contenido"] .= '
		<div class="row">
			<div class="col-7 px-4 py-3 tono-3">
				<div class="row align-items-center">
					<div class="col-auto">
						<span class="rounded bg-light-green p-2 text-success ">
						<i class="fa-regular fa-calendar" aria-hidden="true"></i>
						</span> 
					</div>
					<div class="col-9">
						<span class="">Impacto</span> <br>
						<span class="text-semibold fs-16 titulo-2 line-height-16">Actividades</span> 
					</div>
				</div>
			</div>
			<div class="col-5 p-4 tono-3"><span class="badge badge-success">Población Actual:' . count($estudiantes_activos) . '</span></div>
		
		
			<div class="col-12 card pt-2">
				<div class="row">';


		$num_eventos = 0;
		for ($a = 0; $a < count($actividad); $a++) {
			$eventos = $admin_calendario_eventos->listarEventoActividad($actividad[$a]["id_actividad"]);
			for ($b = 0; $b < count($eventos); $b++) {
				$num_eventos++;
			}

			$totalparticipante = $admin_calendario_eventos->totalactividadgeneral($actividad[$a]["id_actividad"]);
			$total_participantes = $totalparticipante["total_participantes"];

			$por_participacion = round(($total_participantes * 100) / count($estudiantes_activos));

			$data["contenido"] .= '
						<div class="col-12">
							<div class="info-box" >
								<span class="info-box-icon text-white" style="background-color:' . $actividad[$a]["color"] . '"><i class="far fa-bookmark"></i></span>
								<div class="info-box-content">
									<span class="titulo-2 fs-14 line-height-16">' . $actividad[$a]["actividad"] . '</span>
									<span class="info-box-number"><span title="Número de eventos">' . $num_eventos . '</span>/ <span title="Número de Participantes">' . $total_participantes . '</span>
									<div class="progress">
										<div class="progress-bar" style="width: ' . $por_participacion . '%" ></div>
									</div>
									<span class="progress-description d-none">
										' . $por_participacion . '% 
									</span>
								</div>
							</div>
						</div>';
			$num_eventos = 0;
		}
		$data["contenido"] .= '	
				</div>
			</div>
		</div>';
		echo json_encode($data);

		break;

	case 'gestionEvento':

		$id_evento = $_POST["id_evento"];
		$data["contenido"] = "";

		$eventos = $admin_calendario_eventos->listarEventoModificar($id_evento);
		$id_actividad = $eventos["id_actividad"];
		$nombre_evento = $eventos["evento"];
		$fecha_inicio = $eventos["fecha_inicio"];
		$descripcion = $eventos["descripcion"];

		$data["contenido"] .= '<h2 class="titulo-2 fs-18"><b>' . $nombre_evento . '</b></h2>';
		$data["contenido"] .= '<span class="titulo-2 text-semibold fs-14 line-height-16">Fecha del evento: </span> ' . $admin_calendario_eventos->fechaesp($fecha_inicio) . '<br>';
		$data["contenido"] .= '<br><span class="titulo-2 text-semibold fs-14 line-height-16">Descripción: </span><br><span>' . $descripcion . '</span>';
		$data["contenido"] .= '
			<div class="col-12 px-4 py-4 tono-3 mt-2">
				<div class="row align-items-center">
					<div class="col-auto">
						<span class="rounded bg-light-green p-3 text-success ">
						<i class="fa-regular fa-calendar" aria-hidden="true"></i>
						</span> 
					</div>
					<div class="col-9">
						<span class="">Asistentes</span> <br>
						<span class="text-semibold fs-16 titulo-2 line-height-16">al evento</span> 
					</div>
				</div>
			</div>
		';

		$listaasistentes = $admin_calendario_eventos->listarasistentesevento($id_evento);
		$data["contenido"] .= '<div class="card p-4">';
		$data["contenido"] .= '<table class="table table-hover ">';
		$data["contenido"] .= '<thead>';
		$data["contenido"] .= '<th></th>';
		$data["contenido"] .= '<th>Asistente</th>';
		$data["contenido"] .= '<th>Participación</th>';
		$data["contenido"] .= '</thead>';
		$data["contenido"] .= '<tbody>';

		for ($b = 0; $b < count($listaasistentes); $b++) {
			$id_calendario_asistente = $listaasistentes[$b]["id_calendario_asistente"];
			$id_tipo_asistente = $listaasistentes[$b]["id_tipo_asistente"];
			$total = $listaasistentes[$b]["total"];

			$datoasistente = $admin_calendario_eventos->nombreasistente($id_tipo_asistente);
			$data["contenido"] .= '<tr>';

			$data["contenido"] .= '
							<td><a onclick="eliminarasistente(' . $id_calendario_asistente . ',' . $id_evento . ')" class="btn btn-danger btn-sm"> <i class="fas fa-trash text-white"></i></a></td>
							<td>' . $datoasistente["nombre_asistente"] . '</td>
							<td>
							<div class="input-group input-group-sm">
							 		<input type="text" class="form-control" id="total' . $b . '" name="total' . $b . '" value="' . $total . '">
									<span class="input-group-append">
										<a onclick="agregarTotal(' . $id_calendario_asistente . ',' . $id_evento . ',' . $b . ')" class="btn btn-primary btn-sm text-white">Modificar</a>
							 		</span>
							 	</div>							

							</td>';

			$data["contenido"] .= '</tr>';
		}

		$data["contenido"] .= '</tbody>';
		$data["contenido"] .= '</table>';
		$data["contenido"] .= '</div>';


		$asistente = $admin_calendario_eventos->selecttipoasistente();

		$data["contenido"] .= '

		<form id="agregarasistente" name="agregarasistente" method="POST">

			<div class="input-group input-group-sm"> 
			<input type="hidden" name="id_evento" id="id_evento" value="' . $id_evento . '">
			<input type="hidden" name="id_actividad" id="id_actividad" value="' . $id_actividad . '">

			<div class="col-10 m-0 p-0">
				<div class="form-group mb-3 position-relative check-valid">
					<div class="form-floating">
						<select value="" required class="form-control border-start-0 "  name="id_tipo_asistente" id="id_tipo_asistente">';
		for ($a = 0; $a < count($asistente); $a++) {
			$data["contenido"] .= '<option value="' . $asistente[$a]["id_tipo_asistente"] . '">' . $asistente[$a]["nombre_asistente"] . '</option>';
		}

		$data["contenido"] .= '
						</select>
						<label>Tipo de asistente</label>
					</div>
				</div>
				<div class="invalid-feedback">Please enter valid input</div>
			</div>
			<div class="col-2 m-0 p-0">
				<button type="submit" class="btn btn-success py-3">Agregar</button>
			</div>

		</form>';

		echo json_encode($data);

		break;

	case 'guardarasistente':

		$data["contenido"] = "";
		$data["contenidoid"] = "";
		$rspta = $admin_calendario_eventos->insertarasistente($id_evento, $id_tipo_asistente, $id_actividad);

		$data["contenido"] .= $rspta ? "1" : "0";
		$data["contenidoid"] .= $id_evento;
		echo json_encode($data);

		break;

	case 'eliminarasistente':

		$data["contenido"] = "";
		$data["contenidoid"] = "";

		$id_calendario_asistente = $_POST['id_calendario_asistente'];
		$id_evento = $_POST['id_evento'];

		$rspta = $admin_calendario_eventos->eliminarasistente($id_calendario_asistente);

		$data["contenido"] .= $rspta ? "1" : "0";
		$data["contenidoid"] .= $id_evento;

		echo json_encode($data);
		break;

	case 'guardarparticipantes':
		$id_calendario_asistente = $_POST["id_calendario_asistente"];
		$id_evento = $_POST["id_evento"];
		$total = $_POST["total"];

		$data["contenido"] = "";
		$data["contenidoid"] = "";
		$rspta = $admin_calendario_eventos->actualizarparticipantes($id_calendario_asistente, $total);

		$data["contenido"] .= $rspta ? "1" : "0";
		$data["contenidoid"] .= $id_evento;
		echo json_encode($data);

		break;

	case 'todos-eventos-por-periodo':
		$periodoSeleccionado = isset($_POST["periodoSeleccionado"]) ? $_POST["periodoSeleccionado"] : date("Y");
		$rspta = $admin_calendario_eventos->listarEventosPorAnnio($periodoSeleccionado);
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$fecha = date($reg[$i]["fecha_inicio"]);
			$dia = date("d", strtotime($fecha));
			$mes = date("m", strtotime($fecha));
			$horas = date($reg[$i]["hora"]);
			$hora = date("h:i a",  strtotime($horas));
			switch ($mes) {
				case '01':
					$meses = "Ene";
					break;
				case '02':
					$meses = "Feb";
					break;
				case '03':
					$meses = "Mar";
					break;
				case '04':
					$meses = "Abr";
					break;
				case '05':
					$meses = "May";
					break;
				case '06':
					$meses = "Jun";
					break;
				case '07':
					$meses = "Jul";
					break;
				case '08':
					$meses = "Ago";
					break;
				case '09':
					$meses = "Sep";
					break;
				case '10':
					$meses = "Oct";
					break;
				case '11':
					$meses = "Nov";
					break;
				case '12':
					$meses = "Dic";
					break;
			}
			$actividad_pertenece = $admin_calendario_eventos->selectActividadActiva($reg[$i]["id_actividad"]);
			$totalparticipante = $admin_calendario_eventos->totalactividad($reg[$i]["id_evento"]);
			$total_participantes = $totalparticipante["total_participantes"];
			$data[] = array(
				"0" => '<a onclick="gestionEvento(' . $reg[$i]["id_evento"] . ')" title="Gestionar" class="btn btn-success btn-sm text-white"><i class="fas fa-plus"></i> Gestionar</a>',
				"1" => '<div style="width: 20px; height: 20px; border-radius: 50%; background-color:' . $actividad_pertenece["color"] . '; margin: auto;"></div>',
				"2" => $actividad_pertenece["actividad"],
				"3" => $dia . '  ' . $meses . '  ' . $hora,
				"4" => $reg[$i]["evento"],
				"5" => $total_participantes,
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);
		echo json_encode($results);
		break;

	case "listar_anios":
		$rspta = $admin_calendario_eventos->mostrarAnios();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			$anio = $rspta[$i]["anio"];
			echo "<option value='" . $anio . "'>" . $anio . "</option>";
		}
		break;

	default:
		$consulta = $admin_calendario_eventos->mostrarEventos();
		//Codificar el resultado utilizando json
		echo json_encode($consulta);
		break;
}
