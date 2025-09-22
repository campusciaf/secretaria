<?php
require_once "../modelos/PanelAdmin.php";
$panel_admin = new PanelAdmin();
// error_reporting(1); 
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$dia_actual = date("d");
$mesActual_Eventos = date('n') - 1;
$mes_actual = date('Y-m') . "-00";
$fecha_anterior = date("Y-m-d", strtotime($fecha . "- 1 days"));
$semana = date("Y-m-d", strtotime($fecha . "- 1 week"));
$semana_posterior = date("Y-m-d", strtotime($fecha . "+ 1 week"));
$semana_area = date("Y-m-d", strtotime($fecha . "- 1 week"));
$ip_publica = $_SERVER['REMOTE_ADDR'];
$rsptaperiodo = $panel_admin->periodoactual();
$periodo_actual = $_SESSION['periodo_actual'];
$id_usuario = $_SESSION['id_usuario'];
$s_identificacion = $_SESSION['usuario_identificacion'];
$r1 = isset($_POST["r1"]) ? limpiarCadena($_POST["r1"]) : "";
$r2 = isset($_POST["r2"]) ? limpiarCadena($_POST["r2"]) : "";
$r3 = isset($_POST["r3"]) ? limpiarCadena($_POST["r3"]) : "";
$r4 = isset($_POST["r4"]) ? limpiarCadena($_POST["r4"]) : "";
$r5 = isset($_POST["r5"]) ? limpiarCadena($_POST["r5"]) : "";
$r6 = isset($_POST["r6"]) ? limpiarCadena($_POST["r6"]) : "";
$fecha_actual = isset($_POST["fecha_actual"]) ? limpiarCadena($_POST["fecha_actual"]) : "";
$id_usuario_cv = isset($_POST["id_usuario_cv"]) ? limpiarCadena($_POST["id_usuario_cv"]) : "";
switch ($_GET["op"]) {
	case 'listarEscuelas':
		$rpsta = $panel_admin->listarEscuelas();
		echo json_encode($rpsta);
		break;
	case 'listardatos':
		$rango = $_GET["rango"];
		$data = array();
		$data["totalfun"] = "";
		$data["totaldoc"] = "";
		$data["totalest"] = "";
		$data["totalfaltas"] = "";
		$data["totalquedate"] = "";
		$data["totalcontactanos"] = "";
		$data["totalcaracterizados"] = "";
		$data["totalactividades"] = "";
		$data["totalcv"] = "";
		$data["totalperfil"] = "";
		$data["totalperfildoc"] = "";
		$data["totalperfilest"] = "";
		switch ($rango) {
			case '1':
				$rspta1 = $panel_admin->listaringresos($fecha, "Funcionario");
				$rspta2 = $panel_admin->listaringresos($fecha, "Docente");
				$rspta3 = $panel_admin->listaringresos($fecha, "Estudiante");
				$rspta4 = $panel_admin->listarfaltas($fecha);
				$rspta5 = $panel_admin->listarQuedate($fecha);
				$rspta6 = $panel_admin->listarContactanos($fecha);
				$rspta7 = $panel_admin->listarCaracterizados($fecha);
				$rspta8 = $panel_admin->listarActividades($fecha);
				$rspta9 = $panel_admin->ListarCv($fecha);
				$rspta10 = $panel_admin->listarPerfilAdminRango($fecha);
				$rspta11 = $panel_admin->perfilactualizadodocente($fecha);
				$rspta12 = $panel_admin->perfilactualizadoestudiante($fecha);
				$totalfuncionarios = count($rspta1);
				$totaldocentes = count($rspta2);
				$totalestudiantes = count($rspta3);
				$totalfaltas = count($rspta4);
				$totalquedate = count($rspta5);
				$totalcontactanos = count($rspta6);
				$totalcaracterizados = count($rspta7);
				$totalactividades = count($rspta8);
				$totalcv = count($rspta9);
				$totalperfil = count($rspta10);
				$totalperfildoc = count($rspta11);
				$totalperfilest = count($rspta12);
				break;
			case '2':
				$fecha_anterior = date("Y-m-d", strtotime($fecha . "- 1 days"));
				$rspta1 = $panel_admin->listaringresos($fecha_anterior, "Funcionario");
				$rspta2 = $panel_admin->listaringresos($fecha_anterior, "Docente");
				$rspta3 = $panel_admin->listaringresos($fecha_anterior, "Estudiante");
				$rspta4 = $panel_admin->listarfaltas($fecha_anterior);
				$rspta5 = $panel_admin->listarQuedate($fecha_anterior);
				$rspta6 = $panel_admin->listarContactanos($fecha_anterior);
				$rspta7 = $panel_admin->listarCaracterizados($fecha_anterior);
				$rspta8 = $panel_admin->listarActividades($fecha_anterior);
				$rspta9 = $panel_admin->ListarCv($fecha_anterior);
				$rspta10 = $panel_admin->listarPerfilAdminRango($fecha_anterior);
				$rspta11 = $panel_admin->perfilactualizadodocente($fecha_anterior);
				$rspta12 = $panel_admin->perfilactualizadoestudiante($fecha_anterior);
				$totalfuncionarios = count($rspta1);
				$totaldocentes = count($rspta2);
				$totalestudiantes = count($rspta3);
				$totalfaltas = count($rspta4);
				$totalquedate = count($rspta5);
				$totalcontactanos = count($rspta6);
				$totalcaracterizados = count($rspta7);
				$totalactividades = count($rspta8);
				$totalcv = count($rspta9);
				$totalperfil = count($rspta10);
				$totalperfildoc = count($rspta11);
				$totalperfilest = count($rspta12);
				break;
			case '3':
				$semana = date("Y-m-d", strtotime($fecha . "- 1 week"));
				$rspta1 = $panel_admin->listaringresossemana($semana, "Funcionario");
				$rspta2 = $panel_admin->listaringresossemana($semana, "Docente");
				$rspta3 = $panel_admin->listaringresossemana($semana, "Estudiante");
				$rspta4 = $panel_admin->listarFaltasSemana($semana);
				$rspta5 = $panel_admin->listarQuedateSemana($semana);
				$rspta6 = $panel_admin->listarContactanosSemana($semana);
				$rspta7 = $panel_admin->listarCaracterizadosSemana($semana);
				$rspta8 = $panel_admin->listarActividadesSemana($semana);
				$rspta9 = $panel_admin->ListarCvSemana($semana);
				$rspta10 = $panel_admin->listarPerfilAdminRango($semana);
				$rspta11 = $panel_admin->perfilactualizadodocente($semana);
				$rspta12 = $panel_admin->perfilactualizadoestudiante($semana);
				$totalfuncionarios = count($rspta1);
				$totaldocentes = count($rspta2);
				$totalestudiantes = count($rspta3);
				$totalfaltas = count($rspta4);
				$totalquedate = count($rspta5);
				$totalcontactanos = count($rspta6);
				$totalcaracterizados = count($rspta7);
				$totalactividades = count($rspta8);
				$totalcv = count($rspta9);
				$totalperfil = count($rspta10);
				$totalperfildoc = count($rspta11);
				$totalperfilest = count($rspta12);
				break;
			case '4':
				$rspta1 = $panel_admin->listaringresossemana($mes_actual, "Funcionario");
				$rspta2 = $panel_admin->listaringresossemana($mes_actual, "Docente");
				$rspta3 = $panel_admin->listaringresossemana($mes_actual, "Estudiante");
				$rspta4 = $panel_admin->listarFaltasSemana($mes_actual);
				$rspta5 = $panel_admin->listarQuedateSemana($mes_actual);
				$rspta6 = $panel_admin->listarContactanosSemana($mes_actual);
				$rspta7 = $panel_admin->listarCaracterizadosSemana($mes_actual);
				$rspta8 = $panel_admin->listarActividadesSemana($mes_actual);
				$rspta9 = $panel_admin->ListarCvSemana($mes_actual);
				$rspta10 = $panel_admin->listarPerfilAdminRango($mes_actual);
				$rspta11 = $panel_admin->perfilactualizadodocente($mes_actual);
				$rspta12 = $panel_admin->perfilactualizadoestudiante($mes_actual);
				$totalfuncionarios = count($rspta1);
				$totaldocentes = count($rspta2);
				$totalestudiantes = count($rspta3);
				$totalfaltas = count($rspta4);
				$totalquedate = count($rspta5);
				$totalcontactanos = count($rspta6);
				$totalcaracterizados = count($rspta7);
				$totalactividades = count($rspta8);
				$totalcv = count($rspta9);
				$totalperfil = count($rspta10);
				$totalperfildoc = count($rspta11);
				$totalperfilest = count($rspta12);
				break;
			case '5':
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$rspta1 = $panel_admin->listaringresosrango($fecha_inicial, $fecha_final, "Funcionario");
				$rspta2 = $panel_admin->listaringresosrangodocente($fecha_inicial, $fecha_final, "Docente");
				$rspta3 = $panel_admin->listaringresosrango($fecha_inicial, $fecha_final, "Estudiante");
				// $rspta3 = $panel_admin->listaringresosrangoestudiante($fecha_inicial,$fecha_final);
				$rspta4 = $panel_admin->listarFaltasRango($fecha_inicial, $fecha_final);
				$rspta5 = $panel_admin->listarQuedateRango($fecha_inicial, $fecha_final);
				$rspta6 = $panel_admin->listarContactanosRango($fecha_inicial, $fecha_final);
				$rspta7 = $panel_admin->listarCaracterizadosRango($fecha_inicial, $fecha_final);
				$rspta8 = $panel_admin->listarActividadesRango($fecha_inicial, $fecha_final);
				$rspta9 = $panel_admin->listarCvRango5($fecha_inicial, $fecha_final);
				$rspta10 = $panel_admin->listarPerfilAdminRango($fecha_inicial, $fecha_final);
				$rspta11 = $panel_admin->listarPerfilDocRango($fecha_inicial, $fecha_final);
				$rspta12 = $panel_admin->listarPerfilEstRango($fecha_inicial, $fecha_final);
				$totalfuncionarios = count($rspta1);
				$totaldocentes = count($rspta2);
				$totalestudiantes = count($rspta3);
				$totalfaltas = count($rspta4);
				$totalquedate = count($rspta5);
				$totalcontactanos = count($rspta6);
				$totalcaracterizados = count($rspta7);
				$totalactividades = count($rspta8);
				$totalcv = count($rspta9);
				$totalperfil = count($rspta10);
				$totalperfildoc = count($rspta11);
				$totalperfilest = count($rspta12);
				break;
		}
		$data["totalfun"] .= $totalfuncionarios;
		$data["totaldoc"] .= $totaldocentes;
		$data["totalest"] .= $totalestudiantes;
		$data["totalfaltas"] .= $totalfaltas;
		$data["totalquedate"] .= $totalquedate;
		$data["totalcontactanos"] .= $totalcontactanos;
		$data["totalcaracterizados"] .= $totalcaracterizados;
		$data["totalactividades"] .= $totalactividades;
		$data["totalcv"] .= $totalcv;
		$data["totalperfil"] .= $totalperfil;
		$data["totalperfildoc"] .= $totalperfildoc;
		$data["totalperfilest"] .= $totalperfilest;
		echo json_encode($data);
		break;
	case 'listarrango':
		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];
		$data = array();
		$data["totalfun"] = "";
		$data["totaldoc"] = "";
		$data["totalest"] = "";
		$data["totalfaltas"] = "";
		$data["totalquedate"] = "";
		$data["totalcontactanos"] = "";
		$data["totalcaracterizados"] = "";
		$data["totalactividades"] = "";
		$data["totalcv"] = "";
		$data["totalperfiladmin"] = "";
		$data["totalperfildoc"] = "";
		$data["totalperfilest"] = "";
		$rspta1 = $panel_admin->listaringresosrango($fecha_inicial, $fecha_final, "Funcionario");
		$rspta2 = $panel_admin->listaringresosrangodocente($fecha_inicial, $fecha_final, "Docente");
		$rspta3 = $panel_admin->listaringresosrangoestudiante($fecha_inicial, $fecha_final);
		// $rspta3=$panel_admin->listaringresosrango($fecha_inicial,$fecha_final,"Estudiante");
		$rspta4 = $panel_admin->listarFaltasRango($fecha_inicial, $fecha_final);
		$rspta5 = $panel_admin->listarQuedateRango($fecha_inicial, $fecha_final);
		$rspta6 = $panel_admin->listarContactanosRango($fecha_inicial, $fecha_final);
		$rspta7 = $panel_admin->listarCaracterizadosRango($fecha_inicial, $fecha_final);
		$rspta8 = $panel_admin->listarActividadesRango($fecha_inicial, $fecha_final);
		$rspta9 = $panel_admin->listarCvRango5($fecha_inicial, $fecha_final);
		$rspta10 = $panel_admin->listarPerfilAdminRango($fecha_inicial, $fecha_final);
		$rspta11 = $panel_admin->listarPerfilDocRango($fecha_inicial, $fecha_final);
		$rspta12 = $panel_admin->listarPerfilEstRango($fecha_inicial, $fecha_final);
		$totalfuncionarios = count($rspta1);
		$totaldocentes = count($rspta2);
		$totalestudiantes = count($rspta3);
		$totalfaltas = count($rspta4);
		$totalquedate = count($rspta5);
		$totalcontactanos = count($rspta6);
		$totalcaracterizados = count($rspta7);
		$totalactividades = count($rspta8);
		$totalcv = count($rspta9);
		$totalperefiladmin = count($rspta10);
		$totalperfildoc = count($rspta11);
		$totalperfilest = count($rspta12);
		$data["totalfun"] .= $totalfuncionarios;
		$data["totaldoc"] .= $totaldocentes;
		$data["totalest"] .= $totalestudiantes;
		$data["totalfaltas"] .= $totalfaltas;
		$data["totalquedate"] .= $totalquedate;
		$data["totalcontactanos"] .= $totalcontactanos;
		$data["totalcaracterizados"] .= $totalcaracterizados;
		$data["totalactividades"] .= $totalactividades;
		$data["totalcv"] .= $totalcv;
		$data["totalperfiladmin"] .= $totalperefiladmin;
		$data["totalperfildoc"] .= $totalperfildoc;
		$data["totalperfilest"] .= $totalperfilest;
		echo json_encode($data);
		break;
		// case 'listar-eventos-academicos':
		// 	$data["contenido"] = "";
		// 	$eventosacademicos = $panel_admin->traercalendariopic();
		// 	// print_r($eventos);
		// 	$data["contenido"] .= '
		// 	<div class="col-12 pb-4">
		// 		<div class="row p-0 m-0">
		// 		<div class="col-xl-12 bg-white tarjetas">
		// 			<div id="forcecentered1">
		// 				<div class="event-list2 bd-highlight">';
		// 	for ($a = 0; $a < count($eventosacademicos); $a++) {
		// 		$color = $eventosacademicos[$a]["color"];
		// 		$fechaini = date($eventosacademicos[$a]["fecha_inicio"]);
		// 		$dia = date("d", strtotime($fechaini));
		// 		$mes = date("m", strtotime($fechaini));
		// 		$fechahoy = new DateTime($fecha);
		// 		$inicial = new DateTime($eventosacademicos[$a]["fecha_inicio"]);
		// 		$final = new DateTime($eventosacademicos[$a]["fecha_final"]);
		// 		$diferencia = $fechahoy->diff($final)->format("%r%a");
		// 		$fecha_final = $eventosacademicos[$a]["fecha_final"];
		// 		$fechaComoEntero = strtotime($fecha_final);
		// 		$dia_final = date("d", $fechaComoEntero);
		// 		$mes_final = date("m", $fechaComoEntero);
		// 		$anio_final = date("Y", $fechaComoEntero);
		// 		switch ($mes_final) {
		// 			case '01':
		// 				$meses = "Ene";
		// 				break;
		// 			case '02':
		// 				$meses = "Feb";
		// 				break;
		// 			case '03':
		// 				$meses = "Mar";
		// 				break;
		// 			case '04':
		// 				$meses = "Abr";
		// 				break;
		// 			case '05':
		// 				$meses = "May";
		// 				break;
		// 			case '06':
		// 				$meses = "Jun";
		// 				break;
		// 			case '07':
		// 				$meses = "Jul";
		// 				break;
		// 			case '08':
		// 				$meses = "Ago";
		// 				break;
		// 			case '09':
		// 				$meses = "Sep";
		// 				break;
		// 			case '10':
		// 				$meses = "Oct";
		// 				break;
		// 			case '11':
		// 				$meses = "Nov";
		// 				break;
		// 			case '12':
		// 				$meses = "Dic";
		// 				break;
		// 		}
		// 		$data["contenido"] .= '
		// 		<div class="event-dash-card tarjeta2">
		// 			<div class="bg-primary p-1"></div>
		// 			<div class="row">
		// 				<div class="col-5 ">
		// 					<div class="fecha-tarjeta pl-2">
		// 						<span class="titulo-mes">Hasta</span><br>
		// 						<span class="titulo-dia">'.$dia_final.'</span><br>
		// 						<span class="titulo-mes">'.$meses.' ' .$anio_final. '</span>
		// 					</div>
		// 				</div>
		// 				<div class="col-7" style="line-height:14px">
		// 				<span class="badge badge-warning float-right mt-1 mr-3" >'.$diferencia.' Días </span><br>
		// 					<b>'.$eventosacademicos[$a]["actividad"].'</b>
		// 				</div>
		// 			</div>
		// 		</div>';
		// 	}
		// 	$data["contenido"] .= '	   
		// 				</div>
		// 			</div>
		// 		</div>
		// 		</div>
		// 	</div>';
		// 	echo json_encode($data);
		// 	break;
		// case 'listar-eventos':
		// 	$mes_actual_evento = date('m');
		// 	switch($mes_actual_evento){
		// 		case '01':
		// 			$meses="Enero";
		// 		break;
		// 		case '02':
		// 			$meses="Febrero";
		// 		break;
		// 		case '03':
		// 			$meses="Marzo";
		// 		break;
		// 		case '04':
		// 			$meses="Abril";
		// 		break;
		// 		case '05':
		// 			$meses="Mayo";
		// 		break;
		// 		case '06':
		// 			$meses="Junio";
		// 		break;
		// 		case '07':
		// 			$meses="Julio";
		// 		break;
		// 		case '08':
		// 			$meses="Agosto";
		// 		break;
		// 		case '09':
		// 			$meses="Septiembre";
		// 		break;
		// 		case '10':
		// 			$meses="Octubre";
		// 		break;
		// 		case '11':
		// 			$meses="Noviembre";
		// 		break;
		// 		case '12':
		// 			$meses="Diciembre";
		// 		break;
		// 	}
		// 	$data["contenido"] = "";
		// 	$eventos = $panel_admin->listarEventos();
		// 	$data["contenido"] .= '
		// 	<div class="col-12 " >
		// 		<div class="row p-0 m-0">
		// 			<div class="col-xl-12 border-top">
		// 				<h2>
		// 				<span class="titulo-5">Eventos </span> <span class="dia titulo-5 text-success"> '.$meses.'</span> 
		// 				</h2> 
		// 			</div>
		// 			<div class="col-xl-12">
		// 				<div class="row">';
		// 					for ($a = 0; $a < count($eventos); $a++) {
		// 						$fecha_inicio_evento = date($eventos[$a]["fecha_inicio"]);
		// 						$dia = date("d", strtotime($fecha_inicio_evento));
		// 						$mes = date("m", strtotime($fecha_inicio_evento));
		// 						$año = date("y", strtotime($fecha_inicio_evento));
		// 						$horas = date($eventos[$a]["hora"]);
		// 						$hora = date("h:i a",  strtotime($horas));
		// 						$dia_semana = date('l', strtotime($fecha_inicio_evento));
		// 						switch ($dia_semana) {
		// 							case "Sunday":
		// 								$dia_semana_final = "Domingo";
		// 								break;
		// 							case "Monday":
		// 								$dia_semana_final = "Lunes";
		// 								break;
		// 							case "Tuesday":
		// 								$dia_semana_final = "Martes";
		// 								break;
		// 							case "Wednesday":
		// 								$dia_semana_final = "Miercoles";
		// 								break;
		// 							case "Thursday":
		// 								$dia_semana_final = "Jueves";
		// 								break;
		// 							case "Friday":
		// 								$dia_semana_final = "Viernes";
		// 								break;
		// 							case "Saturday":
		// 								$dia_semana_final = "Sabado";
		// 								break;
		// 						}
		// 						$actividad_pertenece = $panel_admin->selectActividadActiva($eventos[$a]["id_actividad"]);
		// 						$totalparticipante = $panel_admin->totalactividad($eventos[$a]["id_evento"]);
		// 						$total_participantes = $totalparticipante["total_participantes"];
		// 						if($mes_actual_evento==$mes && ($fecha_inicio_evento) >= $semana){
		// 							$data["contenido"] .= '
		// 								<div class="col-xl-4">
		// 									<div class="row d-flex justify-content-center">
		// 										<div class="col-xl-11  mb-2 p-0 pb-2 tarjeta-evento" >
		// 											<div class="' . $actividad_pertenece["color"] . ' p-1"></div>
		// 											<div class="row">
		// 												<div class="col-xl-6" style="line-height:14px">
		// 													<p class="titulo-evento pt-4 pl-2">' . $eventos[$a]["evento"] . ' </p>
		// 												</div>
		// 												<div class="col-xl-6 pt-4 pl-4 text-center">
		// 													<span class="event-dash-card-icon"><i class="bi bi-calendar3"></i> </span>
		// 													<span>' . $dia_semana_final . '</span><br>
		// 													<span class="dia">' . $dia . '</span><br>
		// 													<span>' . $hora . '</span><br>
		// 												</div>
		// 												<div class="col-12">
		// 													<span class="ml-2 badge ' . $actividad_pertenece["color"] . '">' . $actividad_pertenece["actividad"] . '</span>
		// 												</div>
		// 											</div>
		// 										</div>
		// 									</div>
		// 								</div>';
		// 						}
		// 					}
		// 				$data["contenido"] .= '	   
		// 				</div>
		//  			</div>
		// 		</div>
		// 	</div>';
		// 	echo json_encode($data);
		// 	break;
		//Nombres de los funcionarios
	case 'mostrar_nombre_funcionario':
		$rangofuncionario = $_GET["rangofuncionario"];
		// $data["totalfun"] ="";
		$data = array();
		$data[0] = "";
		switch ($rangofuncionario) {
			case 1:
				$data[0] = "";
				$data[0] .= '		
					<table id="mostrarfuncionario" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Cédula</th>
							<th scope="col">Nombre</th>
							<th scope="col">Fecha ingreso</th>
							<th scope="col">Hora</th>
							<th scope="col">IP</th>
						</tr>
					</thead>
					<tbody>';
				$totalfuncionarios = $panel_admin->mostrarfuncionarios($fecha);
				// print_r($totalfuncionarios);
				for ($n = 0; $n < count($totalfuncionarios); $n++) {
					// Datos Funcionario 
					$usuario_nombre = $totalfuncionarios[$n]["usuario_nombre"];
					$usuario_nombre = $totalfuncionarios[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totalfuncionarios[$n]["usuario_nombre_2"];
					$usuario_apellido = $totalfuncionarios[$n]["usuario_apellido"];
					$usuario_identificacion = $totalfuncionarios[$n]["usuario_identificacion"];
					$fecha = $totalfuncionarios[$n]["fecha"];
					$hora = $totalfuncionarios[$n]["hora"];
					$ip = $totalfuncionarios[$n]["ip"];
					$data[0] .= '
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td>' . $usuario_identificacion . '</td> 
							<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
							<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
							<td>' . $hora . '</td> 
							<td>' . $ip . '</td> 
						</tr>';
				}
				$data[0] .= '
					</tbody>
					</table>';
				break;
			case 2:
				$data["0"] = "";
				$data[0] .= '		
				<table id="mostrarfuncionario" class="table" style="width:100%">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Cédiula</th>
								<th scope="col">Nombre</th>
								<th scope="col">Fecha ingreso</th>
								<th scope="col">Hora</th>
								<th scope="col">IP</th>
							</tr>
						</thead>
					<tbody>';
				$totalfuncionarios = $panel_admin->mostrarfuncionarios($fecha_anterior);
				for ($n = 0; $n < count($totalfuncionarios); $n++) {
					// Datos Funcionario 
					$usuario_identificacion = $totalfuncionarios[$n]["usuario_identificacion"];
					$usuario_nombre = $totalfuncionarios[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totalfuncionarios[$n]["usuario_nombre_2"];
					$usuario_apellido = $totalfuncionarios[$n]["usuario_apellido"];
					$fecha = $totalfuncionarios[$n]["fecha"];
					$hora = $totalfuncionarios[$n]["hora"];
					$ip = $totalfuncionarios[$n]["ip"];
					$data[0] .= '		
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td>' . $usuario_identificacion . '</td> 
							<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
							<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
							<td>' . $hora . '</td> 
							<td>' . $ip . '</td> 
						</tr>';
				}
				$data[0] .= '</tbody>
				</table>';
				break;
			case 3:
				$data["0"] = "";
				$data[0] .= '		
				<table id="mostrarfuncionario" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Cédula</th>
							<th scope="col">Nombre</th>
							<th scope="col">Fecha ingreso</th>
							<th scope="col">Hora</th>
							<th scope="col">IP</th>
						</tr>
					</thead>
					<tbody>';
				$totalfuncionarios = $panel_admin->mostrarfuncionarios($semana);
				// print_r($semana);
				for ($n = 0; $n < count($totalfuncionarios); $n++) {
					// Datos Funcionario 
					$usuario_identificacion = $totalfuncionarios[$n]["usuario_identificacion"];
					$usuario_nombre = $totalfuncionarios[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totalfuncionarios[$n]["usuario_nombre_2"];
					$usuario_apellido = $totalfuncionarios[$n]["usuario_apellido"];
					$fecha = $totalfuncionarios[$n]["fecha"];
					$hora = $totalfuncionarios[$n]["hora"];
					$ip = $totalfuncionarios[$n]["ip"];
					$data[0] .= '
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td>' . $usuario_identificacion . '</td> 
							<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
							<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
							<td>' . $hora . '</td> 
							<td>' . $ip . '</td> 
						</tr>';
				}
				$data[0] .= '
				</tbody>
				</table>';
				break;
			case 4:
				$data["0"] = "";
				$data[0] .= '		
				<table id="mostrarfuncionario" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Cédula</th>
							<th scope="col">Nombre</th>
							<th scope="col">Fecha ingreso</th>
							<th scope="col">Hora</th>
							<th scope="col">IP</th>
						</tr>
					</thead>
					<tbody>';
				$totalfuncionarios = $panel_admin->mostrarfuncionarios($mes_actual);
				// print_r($mes_actual);
				for ($n = 0; $n < count($totalfuncionarios); $n++) {
					// Datos Funcionario 
					$usuario_identificacion = $totalfuncionarios[$n]["usuario_identificacion"];
					$usuario_nombre = $totalfuncionarios[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totalfuncionarios[$n]["usuario_nombre_2"];
					$usuario_apellido = $totalfuncionarios[$n]["usuario_apellido"];
					$fecha = $totalfuncionarios[$n]["fecha"];
					$hora = $totalfuncionarios[$n]["hora"];
					$ip = $totalfuncionarios[$n]["ip"];
					$data[0] .= '	
						<tr>
						<th scope="row">' . ($n + 1) . '</th>
							<td>' . $usuario_identificacion . '</td> 
							<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
							<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
							<td>' . $hora . '</td> 
							<td>' . $ip . '</td> 
						</tr>';
				}
				$data[0] .= '</tbody>
				</table>';
				break;
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data["0"] = "";
				$data[0] .= '		
				<table id="mostrarfuncionario" class="table" style="width:100%">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Cédula</th>
								<th scope="col">Nombre</th>
								<th scope="col">Fecha ingreso</th>
								<th scope="col">Hora</th>
								<th scope="col">IP</th>
							</tr>
						</thead>
					<tbody>';
				$funcionarioporrango = $panel_admin->listaringresosrangofuncionario($fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($funcionarioporrango); $n++) {
					$usuario_identificacion = $funcionarioporrango[$n]["usuario_identificacion"];
					$fecha = $funcionarioporrango[$n]["fecha"];
					$usuario_nombre = $funcionarioporrango[$n]["usuario_nombre"];
					$usuario_nombre_2 = $funcionarioporrango[$n]["usuario_nombre_2"];
					$usuario_apellido = $funcionarioporrango[$n]["usuario_apellido"];
					$fecha = $funcionarioporrango[$n]["fecha"];
					$hora = $funcionarioporrango[$n]["hora"];
					$ip = $funcionarioporrango[$n]["ip"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>  
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
								<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
								<td>' . $hora . '</td> 
								<td>' . $ip . '</td>  
							</tr>';
				}
				$data[0] .= '</tbody>
				</table>';
				break;
		}
		echo json_encode($data);
		break;
		//Nombres de los docentes
	case 'mostrar_nombre_docente':
		$rangodocente = $_GET["rangodocente"];
		$data["totaldoc"] = "";
		$data = array();
		$data[0] = "";
		switch ($rangodocente) {
			case 1:
				$data[0] = "";
				$data[0] .= '		
					<table id="mostrardocente" class="table" style="width:100%">
						<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Cédula</th>
							<th scope="col">Nombre</th>
							<th scope="col">Fecha</th>
							<th scope="col">Hora</th>
							<th scope="col">ip</th>
						</tr>
					</thead>';
				$totaldocente = $panel_admin->mostrardocente($fecha);
				for ($n = 0; $n < count($totaldocente); $n++) {
					// Datos Funcionario 
					$usuario_nombre = $totaldocente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totaldocente[$n]["usuario_nombre_2"];
					$usuario_apellido = $totaldocente[$n]["usuario_apellido"];
					$fecha = $totaldocente[$n]["fecha"];
					$hora = $totaldocente[$n]["hora"];
					$ip = $totaldocente[$n]["ip"];
					$usuario_identificacion = $totaldocente[$n]["usuario_identificacion"];
					$data[0] .= '
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td>' . $usuario_identificacion . '</td>  
							<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td>
							<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
							<td>' . $hora . '</td>  
							<td>' . $ip . '</td>  
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$data[0] .= '		
				<table id="mostrardocente" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Cédula</th>
							<th scope="col">Nombre</th>
							<th scope="col">Fecha</th>
							<th scope="col">Hora</th>
							<th scope="col">ip</th>
						</tr>
					</thead>
				<tbody>';
				$totaldocente = $panel_admin->mostrardocente($fecha_anterior);
				for ($n = 0; $n < count($totaldocente); $n++) {
					// Datos Funcionario 
					$usuario_identificacion = $totaldocente[$n]["usuario_identificacion"];
					$usuario_nombre = $totaldocente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totaldocente[$n]["usuario_nombre_2"];
					$usuario_apellido = $totaldocente[$n]["usuario_apellido"];
					$fecha = $totaldocente[$n]["fecha"];
					$hora = $totaldocente[$n]["hora"];
					$ip = $totaldocente[$n]["ip"];
					$data[0] .= '		
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td>' . $usuario_identificacion . '</td>  
							<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
							<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
							<td>' . $hora . '</td>  
							<td>' . $ip . '</td>  
						</tr>';
				}
				$data[0] .= '</tbody>
				</table>';
				break;
			case 3:
				$data["0"] = "";
				$data[0] .= '		
				<table id="mostrardocente" class="table" style="width:100%">
						<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Cédula</th>
							<th scope="col">Nombre</th>
							<th scope="col">Fecha</th>
							<th scope="col">Hora</th>
							<th scope="col">ip</th>
						</tr>
						</thead>
						<tbody>';
				$totaldocente = $panel_admin->mostrardocente($semana);
				for ($n = 0; $n < count($totaldocente); $n++) {
					// Datos Docente
					$usuario_identificacion = $totaldocente[$n]["usuario_identificacion"];
					$usuario_nombre = $totaldocente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totaldocente[$n]["usuario_nombre_2"];
					$usuario_apellido = $totaldocente[$n]["usuario_apellido"];
					$fecha = $totaldocente[$n]["fecha"];
					$hora = $totaldocente[$n]["hora"];
					$ip = $totaldocente[$n]["ip"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>  
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
								<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
								<td>' . $hora . '</td>  
								<td>' . $ip . '</td>  
							</tr>
						';
				}
				$data[0] .= '</tbody>
				</table>';
				break;
			case 4:
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrardocente" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				<th scope="col">ip</th>
				</tr>
				</thead>
				<tbody>';
				$totaldocente = $panel_admin->mostrardocente($mes_actual);
				for ($n = 0; $n < count($totaldocente); $n++) {
					// Datos Docente 
					$usuario_identificacion = $totaldocente[$n]["usuario_identificacion"];
					$usuario_nombre = $totaldocente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totaldocente[$n]["usuario_nombre_2"];
					$usuario_apellido = $totaldocente[$n]["usuario_apellido"];
					$ip = $totaldocente[$n]["ip"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>  
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
								<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
								<td>' . $hora . '</td>  
								<td>' . $ip . '</td>  
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrardocente" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha ingreso</th>
				<th scope="col">Hora</th>
				<th scope="col">IP</th>
				</tr>
				</thead>
				<tbody>';
				$funcionarioporrango = $panel_admin->listaringresosrangodocente($fecha_inicial, $fecha_final, "Docente");
				for ($n = 0; $n < count($funcionarioporrango); $n++) {
					// Datos Funcionario 
					// $roll = $funcionarioporrango[$n]["roll"];
					$usuario_identificacion = $funcionarioporrango[$n]["usuario_identificacion"];
					$fecha = $funcionarioporrango[$n]["fecha"];
					$usuario_nombre = $funcionarioporrango[$n]["usuario_nombre"];
					$usuario_nombre_2 = $funcionarioporrango[$n]["usuario_nombre_2"];
					$usuario_apellido = $funcionarioporrango[$n]["usuario_apellido"];
					$fecha = $funcionarioporrango[$n]["fecha"];
					$hora = $funcionarioporrango[$n]["hora"];
					$ip = $funcionarioporrango[$n]["ip"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>  
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
								<td>' . $panel_admin->fechaespcalendario($fecha) . '</td> 
								<td>' . $hora . '</td> 
								<td>' . $ip . '</td>  
							</tr>
						';
				}
				$data[0] .= '</tbody>
				</table>';
				break;
		}
		echo json_encode($data);
		break;
		//Nombres de los estudiantes
	case 'mostrar_nombre_estudiante':
		$rangoestudiante = $_GET["rangoestudiante"];
		$data = array();
		$data[0] = "";
		switch ($rangoestudiante) {
			case 1:
				$data[0] = "";
				$data[0] .= '		
					<table id="mostrarestudiante" class="table" style="width:100%">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Cédula</th>
								<th scope="col">Nombre</th>
								<th scope="col">ip</th>
								<th scope="col">Hora</th>
							</tr>
					</thead><tbody>';
				$mostrar_estudiante = $panel_admin->mostrarestudiantes($fecha);
				for ($n = 0; $n < count($mostrar_estudiante); $n++) {
					// Datos Estudiantes
					$credencial_identificacion = $mostrar_estudiante[$n]["credencial_identificacion"];
					$credencial_nombre = $mostrar_estudiante[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_estudiante[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_estudiante[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_estudiante[$n]["credencial_apellido_2"];
					$ip = $mostrar_estudiante[$n]["ip"];
					$hora = $mostrar_estudiante[$n]["hora"];
					$data[0] .= '
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td>' . $credencial_identificacion . '</td>
							<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
							<td>' . $ip . '</td>
							<td>' . $hora . '</td>
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$data[0] .= '		
				<table id="mostrarestudiante" class="table" style="width:100%">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Cédula</th>
								<th scope="col">Nombre</th>
								<th scope="col">ip</th>
								<th scope="col">Hora</th>
							</tr>
						</thead><tbody>';
				$mostrar_estudiante = $panel_admin->mostrarestudiantes($fecha_anterior);
				for ($n = 0; $n < count($mostrar_estudiante); $n++) {
					// Datos Estudiantes 
					$credencial_identificacion = $mostrar_estudiante[$n]["credencial_identificacion"];
					$credencial_nombre = $mostrar_estudiante[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_estudiante[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_estudiante[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_estudiante[$n]["credencial_apellido_2"];
					$ip = $mostrar_estudiante[$n]["ip"];
					$hora = $mostrar_estudiante[$n]["hora"];
					$data[0] .= '
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td>' . $credencial_identificacion . '</td>
							<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
							<td>' . $ip . '</td>
							<td>' . $hora . '</td>
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 3:
				$data["0"] = "";
				$data[0] .= '		
				<table id="mostrarestudiante" class="table" style="width:100%">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Cédula</th>
								<th scope="col">Nombre</th>
								<th scope="col">ip</th>
								<th scope="col">Hora</th>
							</tr>
						</thead><tbody>';
				$mostrar_estudiante = $panel_admin->mostrarestudiantes($semana);
				for ($n = 0; $n < count($mostrar_estudiante); $n++) {
					// Datos Estudiantes 
					$credencial_identificacion = $mostrar_estudiante[$n]["credencial_identificacion"];
					$credencial_nombre = $mostrar_estudiante[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_estudiante[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_estudiante[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_estudiante[$n]["credencial_apellido_2"];
					$ip = $mostrar_estudiante[$n]["ip"];
					$hora = $mostrar_estudiante[$n]["hora"];
					$data[0] .= '
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td>' . $credencial_identificacion . '</td>
							<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
							<td>' . $ip . '</td>
							<td>' . $hora . '</td>
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 4:
				$data["0"] = "";
				$data[0] .= '		
				<table id="mostrarestudiante" class="table" style="width:100%">
						<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Cédula</th>
							<th scope="col">Nombre</th>
							<th scope="col">ip</th>
							<th scope="col">Hora</th>
						</tr>
						</thead><tbody>';
				$mostrar_estudiante = $panel_admin->mostrarestudiantes($mes_actual);
				for ($n = 0; $n < count($mostrar_estudiante); $n++) {
					// Datos Estudiantes
					$credencial_identificacion = $mostrar_estudiante[$n]["credencial_identificacion"];
					$credencial_nombre = $mostrar_estudiante[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_estudiante[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_estudiante[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_estudiante[$n]["credencial_apellido_2"];
					$ip = $mostrar_estudiante[$n]["ip"];
					$hora = $mostrar_estudiante[$n]["hora"];
					$data[0] .= '
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td>' . $credencial_identificacion . '</td>
							<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
							<td>' . $ip . '</td>
							<td>' . $hora . '</td>
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 5:
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrarestudiante" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula</th>
				<th scope="col">Nombre</th>
				<th scope="col">ip</th>
				<th scope="col">Hora</th>
				</tr>
				</thead><tbody>';
				$mostrar_estudiante = $panel_admin->listaringresosrangoestudiante($fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($mostrar_estudiante); $n++) {
					// Datos Estudiantes
					$credencial_identificacion = $mostrar_estudiante[$n]["credencial_identificacion"];
					$credencial_nombre = $mostrar_estudiante[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_estudiante[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_estudiante[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_estudiante[$n]["credencial_apellido_2"];
					$ip = $mostrar_estudiante[$n]["ip"];
					$hora = $mostrar_estudiante[$n]["hora"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $credencial_identificacion . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $ip . '</td>
								<td>' . $hora . '</td>
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
		}
		echo json_encode($data);
		break;
	case 'mostrar_faltas':
		$rangofaltas = $_GET["rangofaltas"];
		$data = array();
		$data[0] = "";
		switch ($rangofaltas) {
			case 1:
				$data[0] = "";
				$data[0] .=
					'		
				<table id="mostrarfaltasreportadas" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula Docente</th>
				<th scope="col">Nombre Docente</th>
				<th scope="col">Cédula Estudiante</th>
				<th scope="col">Nombre Estudiante</th>
				<th scope="col">Materia Falta</th>
				<th scope="col">Motivo Falta</th>
				</tr>
				</thead><tbody>
				';
				$mostrar_faltas = $panel_admin->mostrarfaltas($fecha);
				for ($n = 0; $n < count($mostrar_faltas); $n++) {
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$materia_falta = $mostrar_faltas[$n]["materia_falta"];
					$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];
					// Faltas variables nombre 
					$usuario_nombre = $mostrar_faltas[$n]["usuario_nombre"];
					$usuario_nombre_2 = $mostrar_faltas[$n]["usuario_nombre_2"];
					$usuario_apellido = $mostrar_faltas[$n]["usuario_apellido"];
					$usuario_apellido_2 = $mostrar_faltas[$n]["usuario_apellido_2"];
					//Faltas  variables estudiante
					$credencial_nombre = $mostrar_faltas[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_faltas[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_faltas[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_faltas[$n]["credencial_apellido_2"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $credencial_identificacion . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $materia_falta . '</td>
								<td>' . $motivo_falta . '</td>
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrarfaltasreportadas" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula Docente</th>
				<th scope="col">Nombre Docente</th>
				<th scope="col">Cédula Estudiante</th>
				<th scope="col">Nombre Estudiante</th>
				<th scope="col">Materia Falta</th>
				<th scope="col">Motivo Falta</th>
				</tr>
				</thead><tbody>';
				$mostrar_faltas = $panel_admin->mostrarfaltasayer($fecha_anterior);
				for ($n = 0; $n < count($mostrar_faltas); $n++) {
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$materia_falta = $mostrar_faltas[$n]["materia_falta"];
					$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];
					// Faltas variables nombre 
					$usuario_nombre = $mostrar_faltas[$n]["usuario_nombre"];
					$usuario_nombre_2 = $mostrar_faltas[$n]["usuario_nombre_2"];
					$usuario_apellido = $mostrar_faltas[$n]["usuario_apellido"];
					$usuario_apellido_2 = $mostrar_faltas[$n]["usuario_apellido_2"];
					//Faltas  variables estudiante
					$credencial_nombre = $mostrar_faltas[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_faltas[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_faltas[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_faltas[$n]["credencial_apellido_2"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $credencial_identificacion . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $materia_falta . '</td>
								<td>' . $motivo_falta . '</td>
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 3:
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrarfaltasreportadas" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula Docente</th>
				<th scope="col">Nombre Docente</th>
				<th scope="col">Cédula Estudiante</th>
				<th scope="col">Nombre Estudiante</th>
				<th scope="col">Materia Falta</th>
				<th scope="col">Motivo Falta</th>
				</tr>
				</thead><tbody>';
				$mostrar_faltas = $panel_admin->mostrarfaltas($semana);
				for ($n = 0; $n < count($mostrar_faltas); $n++) {
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$materia_falta = $mostrar_faltas[$n]["materia_falta"];
					$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];
					// Faltas variables nombre 
					$usuario_nombre = $mostrar_faltas[$n]["usuario_nombre"];
					$usuario_nombre_2 = $mostrar_faltas[$n]["usuario_nombre_2"];
					$usuario_apellido = $mostrar_faltas[$n]["usuario_apellido"];
					$usuario_apellido_2 = $mostrar_faltas[$n]["usuario_apellido_2"];
					//Faltas  variables estudiante
					$credencial_nombre = $mostrar_faltas[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_faltas[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_faltas[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_faltas[$n]["credencial_apellido_2"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $credencial_identificacion . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $materia_falta . '</td>
								<td>' . $motivo_falta . '</td>
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 4:
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrarfaltasreportadas" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula Docente</th>
				<th scope="col">Nombre Docente</th>
				<th scope="col">Cédula Estudiante</th>
				<th scope="col">Nombre Estudiante</th>
				<th scope="col">Materia Falta</th>
				<th scope="col">Motivo Falta</th>
				</tr>
				</thead><tbody>';
				$mostrar_faltas = $panel_admin->mostrarfaltas($mes_actual);
				for ($n = 0; $n < count($mostrar_faltas); $n++) {
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$materia_falta = $mostrar_faltas[$n]["materia_falta"];
					$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];
					// Faltas variables nombre 
					$usuario_nombre = $mostrar_faltas[$n]["usuario_nombre"];
					$usuario_nombre_2 = $mostrar_faltas[$n]["usuario_nombre_2"];
					$usuario_apellido = $mostrar_faltas[$n]["usuario_apellido"];
					$usuario_apellido_2 = $mostrar_faltas[$n]["usuario_apellido_2"];
					//Faltas  variables estudiante
					$credencial_nombre = $mostrar_faltas[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_faltas[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_faltas[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_faltas[$n]["credencial_apellido_2"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $credencial_identificacion . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $materia_falta . '</td>
								<td>' . $motivo_falta . '</td>
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data[0] .=
					'		
					<table id="mostrarfaltasreportadas" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula Docente</th>
				<th scope="col">Nombre Docente</th>
				<th scope="col">Cédula Estudiante</th>
				<th scope="col">Nombre Estudiante</th>
				<th scope="col">Materia Falta</th>
				<th scope="col">Motivo Falta</th>
				</tr>
				</thead><tbody>';
				$mostrar_faltas = $panel_admin->listarFaltasPorRango5($fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($mostrar_faltas); $n++) {
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$materia_falta = $mostrar_faltas[$n]["materia_falta"];
					$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];
					// Faltas variables nombre 
					$usuario_nombre = $mostrar_faltas[$n]["usuario_nombre"];
					$usuario_nombre_2 = $mostrar_faltas[$n]["usuario_nombre_2"];
					$usuario_apellido = $mostrar_faltas[$n]["usuario_apellido"];
					$usuario_apellido_2 = $mostrar_faltas[$n]["usuario_apellido_2"];
					//Faltas  variables estudiante
					$credencial_nombre = $mostrar_faltas[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_faltas[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_faltas[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_faltas[$n]["credencial_apellido_2"];
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $credencial_identificacion . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $materia_falta . '</td>
								<td>' . $motivo_falta . '</td>
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
		}
		echo json_encode($data);
		break;
		// muestro los nombres de caso quedate id y asunto 
	case 'casosquedate':
		$casosquedate = $_GET["casosquedate"];
		$data = array();
		$data[0] = "";
		switch ($casosquedate) {
			case 1:
				$data[0] = "";
				$data[0] .=
					'		
				<table id="mostrarcasoquedate" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Nombre Estudiante</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Creado Por</th>
						<th scope="col" class="text-center">Hora</th>
					</tr>
					</thead>';
				$casoquedate = $panel_admin->casoquedate($fecha);
				for ($n = 0; $n < count($casoquedate); $n++) {
					$credencial_identificacion = $casoquedate[$n]["credencial_identificacion"];
					$credencial_nombre = $casoquedate[$n]["credencial_nombre"];
					$credencial_nombre_2 = $casoquedate[$n]["credencial_nombre_2"];
					$credencial_apellido = $casoquedate[$n]["credencial_apellido"];
					$credencial_apellido_2 = $casoquedate[$n]["credencial_apellido_2"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];
					$updated_at = $casoquedate[$n]["updated_at"];
					$separar_fecha = (explode(" ", $updated_at));
					// $fecha = $separar[0];
					$hora = $separar_fecha[1];
					$data[0] .= '
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
								<td class="text-center">' . $hora . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';
				break;
			case 2:
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrarcasoquedate" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Nombre Estudiante</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Creado Por</th>
						<th scope="col" class="text-center">Hora</th>
					</tr>
					</thead>';
				$casoquedate = $panel_admin->casoquedate($fecha_anterior);
				for ($n = 0; $n < count($casoquedate); $n++) {
					$credencial_identificacion = $casoquedate[$n]["credencial_identificacion"];
					$credencial_nombre = $casoquedate[$n]["credencial_nombre"];
					$credencial_nombre_2 = $casoquedate[$n]["credencial_nombre_2"];
					$credencial_apellido = $casoquedate[$n]["credencial_apellido"];
					$credencial_apellido_2 = $casoquedate[$n]["credencial_apellido_2"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];
					$updated_at = $casoquedate[$n]["updated_at"];
					$separar_fecha = (explode(" ", $updated_at));
					// $fecha = $separar[0];
					$hora = $separar_fecha[1];
					$data[0] .= '
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
								<td class="text-center">' . $hora . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';
				break;
			case 3:
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrarcasoquedate" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Nombre Estudiante</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Creado Por</th>
						<th scope="col" class="text-center">Hora</th>
					</tr>
					</thead>';
				$casoquedate = $panel_admin->casoquedateultimasemana($semana);
				for ($n = 0; $n < count($casoquedate); $n++) {
					$credencial_identificacion = $casoquedate[$n]["credencial_identificacion"];
					$credencial_nombre = $casoquedate[$n]["credencial_nombre"];
					$credencial_nombre_2 = $casoquedate[$n]["credencial_nombre_2"];
					$credencial_apellido = $casoquedate[$n]["credencial_apellido"];
					$credencial_apellido_2 = $casoquedate[$n]["credencial_apellido_2"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];
					$updated_at = $casoquedate[$n]["updated_at"];
					$separar_fecha = (explode(" ", $updated_at));
					// $fecha = $separar[0];
					$hora = $separar_fecha[1];
					$data[0] .= '
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
								<td class="text-center">' . $hora . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';
				break;
			case 4:
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrarcasoquedate" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Nombre Estudiante</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Creado Por</th>
						<th scope="col" class="text-center">Hora</th>
					</tr>
					</thead>';
				$casoquedate = $panel_admin->casoquedateultimasemana($mes_actual);
				for ($n = 0; $n < count($casoquedate); $n++) {
					$credencial_identificacion = $casoquedate[$n]["credencial_identificacion"];
					$credencial_nombre = $casoquedate[$n]["credencial_nombre"];
					$credencial_nombre_2 = $casoquedate[$n]["credencial_nombre_2"];
					$credencial_apellido = $casoquedate[$n]["credencial_apellido"];
					$credencial_apellido_2 = $casoquedate[$n]["credencial_apellido_2"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];
					$updated_at = $casoquedate[$n]["updated_at"];
					$separar_fecha = (explode(" ", $updated_at));
					// $fecha = $separar[0];
					$hora = $separar_fecha[1];
					$data[0] .= '
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
								<td class="text-center">' . $hora . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';
				break;
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data[0] .=
					'		
					<table id="mostrarcasoquedate" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Nombre Estudiante</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Creado Por</th>
						<th scope="col" class="text-center">Hora</th>
					</tr>
					</thead>';
				$casoquedate = $panel_admin->listarQuedatePorRango($fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($casoquedate); $n++) {
					$credencial_identificacion = $casoquedate[$n]["credencial_identificacion"];
					$credencial_nombre = $casoquedate[$n]["credencial_nombre"];
					$credencial_nombre_2 = $casoquedate[$n]["credencial_nombre_2"];
					$credencial_apellido = $casoquedate[$n]["credencial_apellido"];
					$credencial_apellido_2 = $casoquedate[$n]["credencial_apellido_2"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];
					$updated_at = $casoquedate[$n]["updated_at"];
					$separar_fecha = (explode(" ", $updated_at));
					// $fecha = $separar[0];
					$hora = $separar_fecha[1];
					$data[0] .= '
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
								<td class="text-center">' . $hora . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';
				break;
		}
		echo json_encode($data);
		break;
	case 'perfilesactualizadosestudiante':
		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];
		$perfilactualizadoestudiante = $_GET["perfilactualizadoestudiante"];
		$data = array();
		$data[0] = "";
		switch ($perfilactualizadoestudiante) {
			case 1:
				$data["0"] = "";
				$estudiante = $panel_admin->perfilactualizadoestudiante($fecha);
				$data[0] .=
					'		
				<table id="mostrarperfilesactualizadosestudiante" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($estudiante); $i++) {
					$nombre_estudiante = isset($estudiante[$i]["credencial_nombre"]) ? $estudiante[$i]["credencial_nombre"] . " " . $estudiante[$i]["credencial_nombre_2"] . " " . $estudiante[$i]["credencial_apellido"] . " " . $estudiante[$i]["credencial_apellido_2"] : "";
					$fecha_estudiante =  $estudiante[$i]["fecha_actualizacion"];
					$fecha_estudiante = $panel_admin->fechaesp($fecha_estudiante);
					$credencial_identificacion =  $estudiante[$i]["credencial_identificacion"];
					$telefono = $estudiante[$i]["telefono"];
					$celular = $estudiante[$i]["celular"];
					$email = $estudiante[$i]["email"];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_estudiante . '</td>
						<td class="text-center">' . $telefono . '</td>
						<td class="text-center">' . $celular . '</td>
						<td class="text-center">' . $email . '</td>
						<td class="text-center">' . $fecha_estudiante . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$estudiante = $panel_admin->perfilactualizadoestudiante($fecha_anterior);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosestudiante" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($estudiante); $i++) {
					$nombre_estudiante = isset($estudiante[$i]["credencial_nombre"]) ? $estudiante[$i]["credencial_nombre"] . " " . $estudiante[$i]["credencial_nombre_2"] . " " . $estudiante[$i]["credencial_apellido"] . " " . $estudiante[$i]["credencial_apellido_2"] : "";
					$fecha_estudiante =  $estudiante[$i]["fecha_actualizacion"];
					$fecha_estudiante = $panel_admin->fechaesp($fecha_estudiante);
					$credencial_identificacion =  $estudiante[$i]["credencial_identificacion"];
					$telefono = $estudiante[$i]["telefono"];
					$celular = $estudiante[$i]["celular"];
					$email = $estudiante[$i]["email"];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_estudiante . '</td>
						<td class="text-center">' . $telefono . '</td>
						<td class="text-center">' . $celular . '</td>
						<td class="text-center">' . $email . '</td>
						<td class="text-center">' . $fecha_estudiante . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 3:
				$data["0"] = "";
				$estudiante = $panel_admin->perfilactualizadoestudiante($semana);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosestudiante" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($estudiante); $i++) {
					$nombre_estudiante = isset($estudiante[$i]["credencial_nombre"]) ? $estudiante[$i]["credencial_nombre"] . " " . $estudiante[$i]["credencial_nombre_2"] . " " . $estudiante[$i]["credencial_apellido"] . " " . $estudiante[$i]["credencial_apellido_2"] : "";
					$fecha_estudiante =  $estudiante[$i]["fecha_actualizacion"];
					$fecha_estudiante = $panel_admin->fechaesp($fecha_estudiante);
					$credencial_identificacion =  $estudiante[$i]["credencial_identificacion"];
					$telefono = $estudiante[$i]["telefono"];
					$celular = $estudiante[$i]["celular"];
					$email = $estudiante[$i]["email"];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_estudiante . '</td>
						<td class="text-center">' . $telefono . '</td>
						<td class="text-center">' . $celular . '</td>
						<td class="text-center">' . $email . '</td>
						<td class="text-center">' . $fecha_estudiante . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 4:
				$data["0"] = "";
				$estudiante = $panel_admin->perfilactualizadoestudiante($mes_actual);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosestudiante" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($estudiante); $i++) {
					$nombre_estudiante = isset($estudiante[$i]["credencial_nombre"]) ? $estudiante[$i]["credencial_nombre"] . " " . $estudiante[$i]["credencial_nombre_2"] . " " . $estudiante[$i]["credencial_apellido"] . " " . $estudiante[$i]["credencial_apellido_2"] : "";
					$fecha_estudiante =  $estudiante[$i]["fecha_actualizacion"];
					$fecha_estudiante = $panel_admin->fechaesp($fecha_estudiante);
					$credencial_identificacion =  $estudiante[$i]["credencial_identificacion"];
					$telefono = $estudiante[$i]["telefono"];
					$celular = $estudiante[$i]["celular"];
					$email = $estudiante[$i]["email"];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_estudiante . '</td>
						<td class="text-center">' . $telefono . '</td>
						<td class="text-center">' . $celular . '</td>
						<td class="text-center">' . $email . '</td>
						<td class="text-center">' . $fecha_estudiante . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
				//Mostrar los perfiles por rango
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				// Listar los perfiles actualizados de los Estudiantes
				$estudiante = $panel_admin->listaringresosrangoestudiantes($fecha_inicial, $fecha_final);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosestudiante" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($estudiante); $i++) {
					$nombre_estudiante = isset($estudiante[$i]["credencial_nombre"]) ? $estudiante[$i]["credencial_nombre"] . " " . $estudiante[$i]["credencial_nombre_2"] . " " . $estudiante[$i]["credencial_apellido"] . " " . $estudiante[$i]["credencial_apellido_2"] : "";
					$fecha_estudiante =  $estudiante[$i]["fecha_actualizacion"];
					$fecha_estudiante = $panel_admin->fechaesp($fecha_estudiante);
					$credencial_identificacion =  $estudiante[$i]["credencial_identificacion"];
					$telefono = $estudiante[$i]["telefono"];
					$celular = $estudiante[$i]["celular"];
					$email = $estudiante[$i]["email"];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_estudiante . '</td>
						<td class="text-center">' . $telefono . '</td>
						<td class="text-center">' . $celular . '</td>
						<td class="text-center">' . $email . '</td>
						<td class="text-center">' . $fecha_estudiante . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
		}
		echo json_encode($data);
		break;
	case 'perfilesactualizadosdocente':
		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];
		$perfilactualizadodocente = $_GET["perfilactualizadodocente"];
		$data = array();
		$data[0] = "";
		switch ($perfilactualizadodocente) {
			case 1:
				$data["0"] = "";
				$docente = $panel_admin->perfilactualizadodocente($fecha);
				$data[0] .=
					'		
				<table id="mostrarperfilesactualizadosdocente" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email ciaf</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($docente); $i++) {
					$nombre_docente = $docente[$i]["usuario_nombre"] . " " . $docente[$i]["usuario_nombre_2"] . " " . $docente[$i]["usuario_apellido"] . " " . $docente[$i]["usuario_apellido_2"];
					$fecha_docente =  $docente[$i]["fecha_actualizacion"];
					$fecha_docente = $panel_admin->fechaesp($fecha_docente);
					$credencial_identificacion =  $docente[$i]["usuario_identificacion"];
					$usuario_telefono = $docente[$i]['usuario_telefono'];
					$usuario_celular = $docente[$i]['usuario_celular'];
					$usuario_email_ciaf = $docente[$i]['usuario_email_ciaf'];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_docente . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email_ciaf . '</td>
						<td class="text-center">' . $fecha_docente . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$docente = $panel_admin->perfilactualizadodocente($fecha_anterior);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosdocente" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email ciaf</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($docente); $i++) {
					$nombre_docente = $docente[$i]["usuario_nombre"] . " " . $docente[$i]["usuario_nombre_2"] . " " . $docente[$i]["usuario_apellido"] . " " . $docente[$i]["usuario_apellido_2"];
					$usuario_telefono = $docente[$i]['usuario_telefono'];
					$usuario_celular = $docente[$i]['usuario_celular'];
					$usuario_email_ciaf = $docente[$i]['usuario_email_ciaf'];
					$fecha_docente =  $docente[$i]["fecha_actualizacion"];
					$fecha_docente = $panel_admin->fechaesp($fecha_docente);
					$credencial_identificacion =  $docente[$i]["usuario_identificacion"];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_docente . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email_ciaf . '</td>
						<td class="text-center">' . $fecha_docente . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 3:
				$data["0"] = "";
				$docente = $panel_admin->perfilactualizadodocente($semana);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosdocente" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email ciaf</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($docente); $i++) {
					$nombre_docente = $docente[$i]["usuario_nombre"] . " " . $docente[$i]["usuario_nombre_2"] . " " . $docente[$i]["usuario_apellido"] . " " . $docente[$i]["usuario_apellido_2"];
					$usuario_telefono = $docente[$i]['usuario_telefono'];
					$usuario_celular = $docente[$i]['usuario_celular'];
					$usuario_email_ciaf = $docente[$i]['usuario_email_ciaf'];
					$fecha_docente =  $docente[$i]["fecha_actualizacion"];
					$fecha_docente = $panel_admin->fechaesp($fecha_docente);
					$credencial_identificacion =  $docente[$i]["usuario_identificacion"];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_docente . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email_ciaf . '</td>
						<td class="text-center">' . $fecha_docente . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 4:
				$data["0"] = "";
				$docente = $panel_admin->perfilactualizadodocente($mes_actual);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosdocente" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email ciaf</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($docente); $i++) {
					$nombre_docente = $docente[$i]["usuario_nombre"] . " " . $docente[$i]["usuario_nombre_2"] . " " . $docente[$i]["usuario_apellido"] . " " . $docente[$i]["usuario_apellido_2"];
					$usuario_telefono = $docente[$i]['usuario_telefono'];
					$usuario_celular = $docente[$i]['usuario_celular'];
					$usuario_email_ciaf = $docente[$i]['usuario_email_ciaf'];
					$fecha_docente =  $docente[$i]["fecha_actualizacion"];
					$fecha_docente = $panel_admin->fechaesp($fecha_docente);
					$credencial_identificacion =  $docente[$i]["usuario_identificacion"];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_docente . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email_ciaf . '</td>
						<td class="text-center">' . $fecha_docente . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
				//Mostrar los perfiles por rango
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				// Listar los perfiles actualizados de los Estudiantes
				$docente = $panel_admin->listarPerfilDocRango($fecha_inicial, $fecha_final);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosdocente" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email ciaf</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($docente); $i++) {
					$nombre_docente = $docente[$i]["usuario_nombre"] . " " . $docente[$i]["usuario_nombre_2"] . " " . $docente[$i]["usuario_apellido"] . " " . $docente[$i]["usuario_apellido_2"];
					$usuario_telefono = $docente[$i]['usuario_telefono'];
					$usuario_celular = $docente[$i]['usuario_celular'];
					$usuario_email_ciaf = $docente[$i]['usuario_email_ciaf'];
					$fecha_docente =  $docente[$i]["fecha_actualizacion"];
					$fecha_docente = $panel_admin->fechaesp($fecha_docente);
					$credencial_identificacion =  $docente[$i]["usuario_identificacion"];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $credencial_identificacion . '</td>
						<td class="text-center">' . $nombre_docente . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email_ciaf . '</td>
						<td class="text-center">' . $fecha_docente . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
		}
		echo json_encode($data);
		break;
	case 'perfilesactualizadosadministradores':
		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];
		$perfilactualizadoadministrativo = $_GET["perfilactualizadoadministrativo"];
		$data = array();
		$data[0] = "";
		switch ($perfilactualizadoadministrativo) {
			case 1:
				$data["0"] = "";
				$administrador = $panel_admin->listarPerfilAdminRango($fecha);
				$data[0] .=
					'		
				<table id="mostrarperfilesactualizadosadministradores" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($administrador); $i++) {
					$nombre_administradores = isset($administrador[$i]["usuario_nombre"]) ? $administrador[$i]["usuario_nombre"] . " " . $administrador[$i]["usuario_nombre_2"] . " " . $administrador[$i]["usuario_apellido"] . " " . $administrador[$i]["usuario_apellido_2"] : "";
					$usuario_identificacion = $administrador[$i]['usuario_identificacion'];
					$fecha_actualizacion = $administrador[$i]['fecha_actualizacion'];
					$fecha_actualizacion = $panel_admin->fechaesp($fecha_actualizacion);
					$usuario_telefono = $administrador[$i]['usuario_telefono'];
					$usuario_celular = $administrador[$i]['usuario_celular'];
					$usuario_email = $administrador[$i]['usuario_email'];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $usuario_identificacion . '</td>
						<td class="text-center">' . $nombre_administradores . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email . '</td>
						<td class="text-center">' . $fecha_actualizacion . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$administrador = $panel_admin->listarPerfilAdminRango($fecha_anterior);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosadministradores" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($administrador); $i++) {
					$nombre_administradores = isset($administrador[$i]["usuario_nombre"]) ? $administrador[$i]["usuario_nombre"] . " " . $administrador[$i]["usuario_nombre_2"] . " " . $administrador[$i]["usuario_apellido"] . " " . $administrador[$i]["usuario_apellido_2"] : "";
					$usuario_identificacion = $administrador[$i]['usuario_identificacion'];
					$fecha_actualizacion = $administrador[$i]['fecha_actualizacion'];
					$fecha_actualizacion = $panel_admin->fechaesp($fecha_actualizacion);
					$usuario_telefono = $administrador[$i]['usuario_telefono'];
					$usuario_celular = $administrador[$i]['usuario_celular'];
					$usuario_email = $administrador[$i]['usuario_email'];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $usuario_identificacion . '</td>
						<td class="text-center">' . $nombre_administradores . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email . '</td>
						<td class="text-center">' . $fecha_actualizacion . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 3:
				$data["0"] = "";
				$administrador = $panel_admin->listarPerfilAdminRango($semana);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosadministradores" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>		
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($administrador); $i++) {
					$nombre_administradores = isset($administrador[$i]["usuario_nombre"]) ? $administrador[$i]["usuario_nombre"] . " " . $administrador[$i]["usuario_nombre_2"] . " " . $administrador[$i]["usuario_apellido"] . " " . $administrador[$i]["usuario_apellido_2"] : "";
					$usuario_identificacion = $administrador[$i]['usuario_identificacion'];
					$fecha_actualizacion = $administrador[$i]['fecha_actualizacion'];
					$fecha_actualizacion = $panel_admin->fechaesp($fecha_actualizacion);
					$usuario_telefono = $administrador[$i]['usuario_telefono'];
					$usuario_celular = $administrador[$i]['usuario_celular'];
					$usuario_email = $administrador[$i]['usuario_email'];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $usuario_identificacion . '</td>
						<td class="text-center">' . $nombre_administradores . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email . '</td>
						<td class="text-center">' . $fecha_actualizacion . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 4:
				$data["0"] = "";
				$administrador = $panel_admin->listarPerfilAdminRango($mes_actual);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosadministradores" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>		
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($administrador); $i++) {
					$nombre_administradores = isset($administrador[$i]["usuario_nombre"]) ? $administrador[$i]["usuario_nombre"] . " " . $administrador[$i]["usuario_nombre_2"] . " " . $administrador[$i]["usuario_apellido"] . " " . $administrador[$i]["usuario_apellido_2"] : "";
					$usuario_identificacion = $administrador[$i]['usuario_identificacion'];
					$fecha_actualizacion = $administrador[$i]['fecha_actualizacion'];
					$fecha_actualizacion = $panel_admin->fechaesp($fecha_actualizacion);
					$usuario_telefono = $administrador[$i]['usuario_telefono'];
					$usuario_celular = $administrador[$i]['usuario_celular'];
					$usuario_email = $administrador[$i]['usuario_email'];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $usuario_identificacion . '</td>
						<td class="text-center">' . $nombre_administradores . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email . '</td>
						<td class="text-center">' . $fecha_actualizacion . '</td>
						</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
				//Mostrar los perfiles por rango
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				// Listar los perfiles actualizados de los Administrativos
				$administrador = $panel_admin->listarPerfilAdminRango($fecha_inicial, $fecha_final);
				$data[0] .=
					'		
					<table id="mostrarperfilesactualizadosadministradores" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>	
							<th scope="col" class="text-center">Nombre Estudiante</th>	
							<th scope="col" class="text-center">Telefono</th>	
							<th scope="col" class="text-center">Celular</th>	
							<th scope="col" class="text-center">Email</th>	
							<th scope="col" class="text-center">Fecha</th>	
						</tr>
					</thead>
				<tbody>';
				for ($i = 0; $i < count($administrador); $i++) {
					$nombre_administradores = isset($administrador[$i]["usuario_nombre"]) ? $administrador[$i]["usuario_nombre"] . " " . $administrador[$i]["usuario_nombre_2"] . " " . $administrador[$i]["usuario_apellido"] . " " . $administrador[$i]["usuario_apellido_2"] : "";
					$usuario_identificacion = $administrador[$i]['usuario_identificacion'];
					$fecha_actualizacion = $administrador[$i]['fecha_actualizacion'];
					$fecha_actualizacion = $panel_admin->fechaesp($fecha_actualizacion);
					$usuario_telefono = $administrador[$i]['usuario_telefono'];
					$usuario_celular = $administrador[$i]['usuario_celular'];
					$usuario_email = $administrador[$i]['usuario_email'];
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $usuario_identificacion . '</td>
						<td class="text-center">' . $nombre_administradores . '</td>
						<td class="text-center">' . $usuario_telefono . '</td>
						<td class="text-center">' . $usuario_celular . '</td>
						<td class="text-center">' . $usuario_email . '</td>
						<td class="text-center">' . $fecha_actualizacion . '</td>
					</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
		}
		echo json_encode($data);
		break;
	case 'contactanos':
		$contactanos = $_GET["contactanos"];
		$data = array();
		$data[0] = "";
		switch ($contactanos) {
			case 1:
				$data[0] = "";
				$data[0] .=
					'		
				<table id="mostrarcontactanos" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Id</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Mensaje </th>
					<th scope="col" class="text-center">Estado </th>
					<th scope="col" class="text-center">Creado por </th>
					<th scope="col" class="text-center">Dirigido a </th>
					<th scope="col" class="text-center">Fecha</th>
					<th scope="col" class="text-center">Hora </th>
				</tr>
				</thead><tbody>';
				$contactanos = $panel_admin->contactanos($fecha);
				for ($n = 0; $n < count($contactanos); $n++) {
					$nombre_estudiante = $contactanos[$n]["credencial_nombre"] . " " . $contactanos[$n]["credencial_nombre_2"] . " " . $contactanos[$n]["credencial_apellido"] . " " . $contactanos[$n]["credencial_apellido_2"];
					$credencial_identificacion = $contactanos[$n]["credencial_identificacion"];
					$id_credencial = $contactanos[$n]["id_credencial"];
					$mensaje = $contactanos[$n]["mensaje"];
					$estado = $contactanos[$n]["estado"];
					$usuario_nombre	= $contactanos[$n]["usuario_nombre"];
					$usuario_nombre_2 = $contactanos[$n]["usuario_nombre_2"];
					$usuario_apellido = $contactanos[$n]["usuario_apellido"];
					$usuario_apellido_2 = $contactanos[$n]["usuario_apellido_2"];
					$dependencia = $contactanos[$n]["dependencia"];
					$fecha_solicitud = $contactanos[$n]["fecha_solicitud"];
					$hora_solicitud = $contactanos[$n]["hora_solicitud"];
					$solicitud_fecha = $panel_admin->fechaesp($fecha_solicitud);
					$nombre_estado = ($estado == 1) ? '<span class="badge badge-danger p-1">Pendiente</span>' : '<span class="badge badge-success p-1"> Finalizado</span>';
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $id_credencial . '</td>
								<td class="text-center">' . $nombre_estudiante . '</td>
								<td class="text-center">' . $mensaje . '</td>
								<td class="text-center">' . $nombre_estado . '</td>
								<td >' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td class="text-center">' . $dependencia . '</td>
								<td class="text-center">' . $solicitud_fecha . '</td>
								<td class="text-center">' . $hora_solicitud . '</td>
								</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrarcontactanos" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Id</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Mensaje </th>
					<th scope="col" class="text-center">Estado </th>
					<th scope="col" class="text-center">Creado por </th>
					<th scope="col" class="text-center">Dirigido a </th>
					<th scope="col" class="text-center">Fecha</th>
					<th scope="col" class="text-center">Hora </th>
				</tr>
				</thead><tbody>';
				$contactanos = $panel_admin->contactanos($fecha_anterior);
				for ($n = 0; $n < count($contactanos); $n++) {
					$nombre_estudiante = $contactanos[$n]["credencial_nombre"] . " " . $contactanos[$n]["credencial_nombre_2"] . " " . $contactanos[$n]["credencial_apellido"] . " " . $contactanos[$n]["credencial_apellido_2"];
					$credencial_identificacion = $contactanos[$n]["credencial_identificacion"];
					$id_credencial = $contactanos[$n]["id_credencial"];
					$mensaje = $contactanos[$n]["mensaje"];
					$estado = $contactanos[$n]["estado"];
					$usuario_nombre	= $contactanos[$n]["usuario_nombre"];
					$usuario_nombre_2 = $contactanos[$n]["usuario_nombre_2"];
					$usuario_apellido = $contactanos[$n]["usuario_apellido"];
					$usuario_apellido_2 = $contactanos[$n]["usuario_apellido_2"];
					$dependencia = $contactanos[$n]["dependencia"];
					$fecha_solicitud = $contactanos[$n]["fecha_solicitud"];
					$hora_solicitud = $contactanos[$n]["hora_solicitud"];
					$solicitud_fecha = $panel_admin->fechaesp($fecha_solicitud);
					$nombre_estado = ($estado == 1) ? '<span class="badge badge-danger p-1">Pendiente</span>' : '<span class="badge badge-success p-1"> Finalizado</span>';
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $id_credencial . '</td>
								<td class="text-center">' . $nombre_estudiante . '</td>
								<td class="text-center">' . $mensaje . '</td>
								<td class="text-center">' . $nombre_estado . '</td>
								<td >' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td class="text-center">' . $dependencia . '</td>
								<td class="text-center">' . $solicitud_fecha . '</td>
								<td class="text-center">' . $hora_solicitud . '</td>
								</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 3:
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrarcontactanos" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Id</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Mensaje </th>
					<th scope="col" class="text-center">Estado </th>
					<th scope="col" class="text-center">Creado por </th>
					<th scope="col" class="text-center">Dirigido a </th>
					<th scope="col" class="text-center">Fecha</th>
					<th scope="col" class="text-center">Hora </th>
				</tr>
				</thead><tbody>';
				$contactanos = $panel_admin->contactanos($semana);
				for ($n = 0; $n < count($contactanos); $n++) {
					$nombre_estudiante = $contactanos[$n]["credencial_nombre"] . " " . $contactanos[$n]["credencial_nombre_2"] . " " . $contactanos[$n]["credencial_apellido"] . " " . $contactanos[$n]["credencial_apellido_2"];
					$credencial_identificacion = $contactanos[$n]["credencial_identificacion"];
					$id_credencial = $contactanos[$n]["id_credencial"];
					$mensaje = $contactanos[$n]["mensaje"];
					$estado = $contactanos[$n]["estado"];
					$usuario_nombre	= $contactanos[$n]["usuario_nombre"];
					$usuario_nombre_2 = $contactanos[$n]["usuario_nombre_2"];
					$usuario_apellido = $contactanos[$n]["usuario_apellido"];
					$usuario_apellido_2 = $contactanos[$n]["usuario_apellido_2"];
					$dependencia = $contactanos[$n]["dependencia"];
					$fecha_solicitud = $contactanos[$n]["fecha_solicitud"];
					$hora_solicitud = $contactanos[$n]["hora_solicitud"];
					$solicitud_fecha = $panel_admin->fechaesp($fecha_solicitud);
					$nombre_estado = ($estado == 1) ? '<span class="badge badge-danger p-1">Pendiente</span>' : '<span class="badge badge-success p-1"> Finalizado</span>';
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $id_credencial . '</td>
								<td class="text-center">' . $nombre_estudiante . '</td>
								<td class="text-center">' . $mensaje . '</td>
								<td class="text-center">' . $nombre_estado . '</td>
								<td >' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td class="text-center">' . $dependencia . '</td>
								<td class="text-center">' . $solicitud_fecha . '</td>
								<td class="text-center">' . $hora_solicitud . '</td>
								</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 4:
				$data["0"] = "";
				$data[0] .=
					'		
					<table id="mostrarcontactanos" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Id</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Mensaje </th>
					<th scope="col" class="text-center">Estado </th>
					<th scope="col" class="text-center">Creado por </th>
					<th scope="col" class="text-center">Dirigido a </th>
					<th scope="col" class="text-center">Fecha</th>
					<th scope="col" class="text-center">Hora </th>
				</tr>
				</thead><tbody>';
				$contactanos = $panel_admin->contactanos($mes_actual);
				for ($n = 0; $n < count($contactanos); $n++) {
					$nombre_estudiante = $contactanos[$n]["credencial_nombre"] . " " . $contactanos[$n]["credencial_nombre_2"] . " " . $contactanos[$n]["credencial_apellido"] . " " . $contactanos[$n]["credencial_apellido_2"];
					$credencial_identificacion = $contactanos[$n]["credencial_identificacion"];
					$id_credencial = $contactanos[$n]["id_credencial"];
					$mensaje = $contactanos[$n]["mensaje"];
					$estado = $contactanos[$n]["estado"];
					$usuario_nombre	= $contactanos[$n]["usuario_nombre"];
					$usuario_nombre_2 = $contactanos[$n]["usuario_nombre_2"];
					$usuario_apellido = $contactanos[$n]["usuario_apellido"];
					$usuario_apellido_2 = $contactanos[$n]["usuario_apellido_2"];
					$dependencia = $contactanos[$n]["dependencia"];
					$fecha_solicitud = $contactanos[$n]["fecha_solicitud"];
					$hora_solicitud = $contactanos[$n]["hora_solicitud"];
					$solicitud_fecha = $panel_admin->fechaesp($fecha_solicitud);
					$nombre_estado = ($estado == 1) ? '<span class="badge badge-danger p-1">Pendiente</span>' : '<span class="badge badge-success p-1"> Finalizado</span>';
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $id_credencial . '</td>
								<td class="text-center">' . $nombre_estudiante . '</td>
								<td class="text-center">' . $mensaje . '</td>
								<td class="text-center">' . $nombre_estado . '</td>
								<td >' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td class="text-center">' . $dependencia . '</td>
								<td class="text-center">' . $solicitud_fecha . '</td>
								<td class="text-center">' . $hora_solicitud . '</td>
								</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data[0] .=
					'		
					<table id="mostrarcontactanos" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Id</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Mensaje </th>
					<th scope="col" class="text-center">Estado </th>
					<th scope="col" class="text-center">Creado por </th>
					<th scope="col" class="text-center">Dirigido a </th>
					<th scope="col" class="text-center">Fecha</th>
					<th scope="col" class="text-center">Hora </th>
				</tr>
				</thead><tbody>';
				$contactanos = $panel_admin->listarContactanosPorRango5($fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($contactanos); $n++) {
					$nombre_estudiante = $contactanos[$n]["credencial_nombre"] . " " . $contactanos[$n]["credencial_nombre_2"] . " " . $contactanos[$n]["credencial_apellido"] . " " . $contactanos[$n]["credencial_apellido_2"];
					$credencial_identificacion = $contactanos[$n]["credencial_identificacion"];
					$id_credencial = $contactanos[$n]["id_credencial"];
					$mensaje = $contactanos[$n]["mensaje"];
					$estado = $contactanos[$n]["estado"];
					$usuario_nombre	= $contactanos[$n]["usuario_nombre"];
					$usuario_nombre_2 = $contactanos[$n]["usuario_nombre_2"];
					$usuario_apellido = $contactanos[$n]["usuario_apellido"];
					$usuario_apellido_2 = $contactanos[$n]["usuario_apellido_2"];
					$dependencia = $contactanos[$n]["dependencia"];
					$fecha_solicitud = $contactanos[$n]["fecha_solicitud"];
					$hora_solicitud = $contactanos[$n]["hora_solicitud"];
					$solicitud_fecha = $panel_admin->fechaesp($fecha_solicitud);
					$nombre_estado = ($estado == 1) ? '<span class="badge badge-danger p-1">Pendiente</span>' : '<span class="badge badge-success p-1"> Finalizado</span>';
					$data[0] .= '
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $credencial_identificacion . '</td>
								<td class="text-center">' . $id_credencial . '</td>
								<td class="text-center">' . $nombre_estudiante . '</td>
								<td class="text-center">' . $mensaje . '</td>
								<td class="text-center">' . $nombre_estado . '</td>
								<td >' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td class="text-center">' . $dependencia . '</td>
								<td class="text-center">' . $solicitud_fecha . '</td>
								<td class="text-center">' . $hora_solicitud . '</td>
								</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
		}
		echo json_encode($data);
		break;
		//Mostramos nombres y cedula de la hoja de vida
	case 'hojadevidanueva':
		$hojasdevidanueva = $_GET["hojasdevidanueva"];
		// $id_usuario_cv = $_GET["id_usuario_cv"];
		// print_r($id_usuario_cv);
		$data = array();
		$data[0] = "";
		switch ($hojasdevidanueva) {
			case 1:
				$data["0"] = "";
				$data[0] .=
					'
				<table id="mostrarhojadevida" class="table" style="width:100%">
				<thead>
				<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Nombre Area</th>
					<th scope="col" class="text-center">Hora</th>
					<th scope="col" class="text-center">Fecha</th>
				</tr>
				<tbody></thead>';
				$listarhojasdevida = $panel_admin->hojadevida($fecha);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$nombre_area = $listarhojasdevida[$n]["nombre_area"];
					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$usuario_nombre_apellido = $listarhojasdevida[$n]["usuario_nombre"] . " " . $listarhojasdevida[$n]["usuario_apellido"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $panel_admin->fechaesp($fecha);
					$hora = $separar_fecha[1];
					$data[0] .= '
						<tr>	
							<th scope="row" class="text-center">' . ($n + 1) . '</th>
							<td><p>' . $usuario_identificacion . '</p></td>
							<td><p>' . $usuario_nombre_apellido . '</p></td>
							<td><p>' . $nombre_area . '</p></td>
							<td><p>' . $hora . '</p></td>
							<td><p>' . $fecha . '</p></td>
						</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$data[0] .=
					'
				<table id="mostrarhojadevida" class="table" style="width:100%">
				<thead>
				<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Nombre Area</th>
					<th scope="col" class="text-center">Hora</th>
					<th scope="col" class="text-center">Fecha</th>
				</tr>
				<tbody></thead>';
				$listarhojasdevida = $panel_admin->hojadevida($fecha_anterior);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$nombre_area = $listarhojasdevida[$n]["nombre_area"];
					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$usuario_nombre_apellido = $listarhojasdevida[$n]["usuario_nombre"] . " " . $listarhojasdevida[$n]["usuario_apellido"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $panel_admin->fechaesp($fecha);
					$hora = $separar_fecha[1];
					$data[0] .= '
						<tr>	
							<th scope="row" class="text-center">' . ($n + 1) . '</th>
							<td><p>' . $usuario_identificacion . '</p></td>
							<td><p>' . $usuario_nombre_apellido . '</p></td>
							<td><p>' . $nombre_area . '</p></td>
							<td><p>' . $hora . '</p></td>
							<td><p>' . $fecha . '</p></td>
						</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 3:
				$semana_2 = date("Y-m-d", strtotime($fecha . "- 1 week"));
				$data["0"] = "";
				$data[0] .=
					'
				<table id="mostrarhojadevida" class="table" style="width:100%">
				<thead>
				<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Nombre Area</th>
					<th scope="col" class="text-center">Hora</th>
					<th scope="col" class="text-center">Fecha</th>
				</tr>
				<tbody></thead>';
				$listarhojasdevida = $panel_admin->hojadevidasemanaymes($semana_2);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$nombre_area = $listarhojasdevida[$n]["nombre_area"];
					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$usuario_nombre_apellido = $listarhojasdevida[$n]["usuario_nombre"] . " " . $listarhojasdevida[$n]["usuario_apellido"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $panel_admin->fechaesp($fecha);
					$hora = $separar_fecha[1];
					$data[0] .= '
						<tr>	
							<th scope="row" class="text-center">' . ($n + 1) . '</th>
							<td><p>' . $usuario_identificacion . '</p></td>
							<td><p>' . $usuario_nombre_apellido . '</p></td>
							<td><p>' . $nombre_area . '</p></td>
							<td><p>' . $hora . '</p></td>
							<td><p>' . $fecha . '</p></td>
						</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 4:
				$data["0"] = "";
				$data[0] .=
					'
				<table id="mostrarhojadevida" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Nombre Area</th>
					<th scope="col" class="text-center">Hora</th>
					<th scope="col" class="text-center">Fecha</th>
				</tr>
				<tbody></thead>';
				$listarhojasdevida = $panel_admin->hojadevidasemanaymes($mes_actual);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$nombre_area = $listarhojasdevida[$n]["nombre_area"];
					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$usuario_nombre_apellido = $listarhojasdevida[$n]["usuario_nombre"] . " " . $listarhojasdevida[$n]["usuario_apellido"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $panel_admin->fechaesp($fecha);
					$hora = $separar_fecha[1];
					$data[0] .= '
						<tr>	
						<th scope="row" class="text-center">' . ($n + 1) . '</th>	
							<td><p>' . $usuario_identificacion . '</p></td>
							<td><p>' . $usuario_nombre_apellido . '</p></td>
							<td><p>' . $nombre_area . '</p></td>
							<td><p>' . $hora . '</p></td>
							<td><p>' . $fecha . '</p></td>
						</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data[0] .=
					'		
				<table id="mostrarhojadevida" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Aerea de Conocimiento</th>
					<th scope="col" class="text-center">Hora</th>
					<th scope="col" class="text-center">Fecha</th>
				</tr>
				<tbody></thead>';
				$listarhojasdevida = $panel_admin->listarPorCvRango($fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$usuario_nombre = $listarhojasdevida[$n]["usuario_nombre"];
					$usuario_apellido = $listarhojasdevida[$n]["usuario_apellido"];
					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$nombre_area = $listarhojasdevida[$n]["nombre_area"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $panel_admin->fechaesp($fecha);
					$hora = $separar_fecha[1];
					$data[0] .= '
							<tr>
								<th scope="row" class="text-center">' . ($n + 1) . '</th>	
								<td class="text-center">' . $usuario_identificacion . '</td>
									<td class="text-center">' . $usuario_nombre . " " . $usuario_apellido . '</td>
									<td class="text-center">' . $nombre_area . '</td>
									<td class="text-center">' . $hora . '</td>
									<td class="text-center">' . $fecha . '</td>
								</tr>
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
		}
		echo json_encode($data);
		break;
	case 'caracterizados':
		$caracterizados = $_GET["caracterizados"];
		$data = array();
		$data[0] = "";
		switch ($caracterizados) {
			case 1:
				$data[0] = "";
				$data[0] .=
					'		
				<table id="mostrarcaracterizados" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
				<th scope="col" class="text-center">Nombre</th>
				<th scope="col" class="text-center">Jornada </th>
				<th scope="col" class="text-center">Fecha </th>
			</tr>
				</thead><tbody>';
				$caracterizacion = $panel_admin->caracterizacion($fecha);
				for ($n = 0; $n < count($caracterizacion); $n++) {
					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $panel_admin->fechaesp($fecha);
					$credencial_identificacion = $caracterizacion[$n]["credencial_identificacion"];
					$data[0] .= '
							<tr>
								<th scope="row" class="text-center">' . ($n + 1) . '</th>	
								<td class="text-center">' . $credencial_identificacion . '</td>
									<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . '</td>
									<td class="text-center">' . $jornada . '</td>
									<td class="text-center">' . $fecha_caracterizacion . '</td>
								</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrarcaracterizados" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
				<th scope="col" class="text-center">Nombre</th>
				<th scope="col" class="text-center">Jornada </th>
				<th scope="col" class="text-center">Fecha </th>
			</tr>
				</thead><tbody>';
				$caracterizacion = $panel_admin->caracterizacion($fecha_anterior);
				for ($n = 0; $n < count($caracterizacion); $n++) {
					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $panel_admin->fechaesp($fecha);
					$credencial_identificacion = $caracterizacion[$n]["credencial_identificacion"];
					$data[0] .= '
							<tr>
								<th scope="row" class="text-center">' . ($n + 1) . '</th>	
								<td class="text-center">' . $credencial_identificacion . '</td>
									<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . '</td>
									<td class="text-center">' . $jornada . '</td>
									<td class="text-center">' . $fecha_caracterizacion . '</td>
								</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 3:
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrarcaracterizados" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
				<th scope="col" class="text-center">Nombre</th>
				<th scope="col" class="text-center">Jornada </th>
				<th scope="col" class="text-center">Fecha </th>
			</tr>
				</thead><tbody>';
				$caracterizacion = $panel_admin->caracterizacionsemana($semana);
				for ($n = 0; $n < count($caracterizacion); $n++) {
					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $panel_admin->fechaesp($fecha);
					$credencial_identificacion = $caracterizacion[$n]["credencial_identificacion"];
					$data[0] .= '
							<tr>
								<th scope="row" class="text-center">' . ($n + 1) . '</th>	
								<td class="text-center">' . $credencial_identificacion . '</td>
									<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . '</td>
									<td class="text-center">' . $jornada . '</td>
									<td class="text-center">' . $fecha_caracterizacion . '</td>
								</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 4:
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrarcaracterizados" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
				<th scope="col" class="text-center">Nombre</th>
				<th scope="col" class="text-center">Jornada </th>
				<th scope="col" class="text-center">Fecha </th>
			</tr>
				</thead><tbody>';
				$caracterizacion = $panel_admin->caracterizacionsemana($mes_actual);
				for ($n = 0; $n < count($caracterizacion); $n++) {
					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $panel_admin->fechaesp($fecha);
					$credencial_identificacion = $caracterizacion[$n]["credencial_identificacion"];
					$data[0] .= '
						<tr>
							<th scope="row" class="text-center">' . ($n + 1) . '</th>	
							<td class="text-center">' . $credencial_identificacion . '</td>
							<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . '</td>
							<td class="text-center">' . $jornada . '</td>
							<td class="text-center">' . $fecha_caracterizacion . '</td>
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 5:
				$data["0"] = "";
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data[0] .=
					'		
				<table id="mostrarcaracterizados" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">#</th>
				<th scope="col" class="text-center">Cédula</th>
				<th scope="col" class="text-center">Nombre</th>
				<th scope="col" class="text-center">Jornada </th>
				<th scope="col" class="text-center">Fecha </th>
			</tr>
				</thead><tbody>';
				$caracterizacion = $panel_admin->listarCaracterizadosPorRango($fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($caracterizacion); $n++) {
					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $panel_admin->fechaesp($fecha);
					$credencial_identificacion = $caracterizacion[$n]["credencial_identificacion"];
					$data[0] .= '
						<tr>
							<th scope="row" class="text-center">' . ($n + 1) . '</th>	
							<td class="text-center">' . $credencial_identificacion . '</td>
							<td class="text-center">' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . '</td>
							<td class="text-center">' . $jornada . '</td>
							<td class="text-center">' . $fecha_caracterizacion . '</td>
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
		}
		echo json_encode($data);
		break;
	case 'actividadesnuevas':
		$actividadesnuevas = $_GET["actividadesnuevas"];
		$data = array();
		$data[0] = "";
		switch ($actividadesnuevas) {
			case 1:
				$data[0] = "";
				$data[0] .= '
					<table id="mostraractividades" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Docente</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					</tr>
					<tbody></thead>';
				$caracterizacion = $panel_admin->listaractividades($fecha);
				for ($h = 0; $h < count($caracterizacion); $h++) {
					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];
					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];
					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $panel_admin->fechaesp($fecha_actividad);
					$data[0] .= '
							<tr>
								<th scope="row" class="text-center">' . ($h + 1) . '</th>	
									<td class="text-center">' . $usuario_identificacion . '</td>
									<td class="text-center">' . $nombre_docente . '</td>
									<td class="text-center">' . $nombre_documento . '</td>
									<td class="text-center">' . $descripcion_documento . '</td>
									<td class="text-center">' . $archivo_documento . '</td>
									<td class="text-center">' . $actividad_fecha . '</td>
								</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 2:
				$data["0"] = "";
				$data[0] .= '
				<table id="mostraractividades" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Docente</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					</tr>
					<tbody></thead>';
				$caracterizacion = $panel_admin->listaractividades($fecha_anterior);
				for ($h = 0; $h < count($caracterizacion); $h++) {
					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];
					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];
					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $panel_admin->fechaesp($fecha_actividad);
					$data[0] .= '	
						<tr>
							<th scope="row" class="text-center">' . ($h + 1) . '</th>	
								<td class="text-center">' . $usuario_identificacion . '</td>
								<td class="text-center">' . $nombre_docente . '</td>
								<td class="text-center">' . $nombre_documento . '</td>
								<td class="text-center">' . $descripcion_documento . '</td>
								<td class="text-center">' . $archivo_documento . '</td>
								<td class="text-center">' . $actividad_fecha . '</td>
							</tr>
					';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 3:
				$data["0"] = "";
				$data[0] .= '
				<table id="mostraractividades" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Docente</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					</tr>
					<tbody></thead>';
				$caracterizacion = $panel_admin->listarActividadesSemana($semana);
				for ($h = 0; $h < count($caracterizacion); $h++) {
					// print_r($caracterizacion);
					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];
					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];
					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $panel_admin->fechaesp($fecha_actividad);
					$data[0] .= '
					<tr>
						<th scope="row" class="text-center">' . ($h + 1) . '</th>	
							<td class="text-center">' . $usuario_identificacion . '</td>
							<td class="text-center">' . $nombre_docente . '</td>
							<td class="text-center">' . $nombre_documento . '</td>
							<td class="text-center">' . $descripcion_documento . '</td>
							<td class="text-center">' . $archivo_documento . '</td>
							<td class="text-center">' . $actividad_fecha . '</td>
						</tr>
				';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 4:
				$data["0"] = "";
				$data[0] .= '
				<table id="mostraractividades" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Docente</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					</tr>
					<tbody></thead>';
				$caracterizacion = $panel_admin->listarActividadesSemana($mes_actual);
				for ($h = 0; $h < count($caracterizacion); $h++) {
					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];
					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];
					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $panel_admin->fechaesp($fecha_actividad);
					$data[0] .= '
						<tr>
							<th scope="row" class="text-center">' . ($h + 1) . '</th>	
							<td class="text-center">' . $usuario_identificacion . '</td>
							<td class="text-center">' . $nombre_docente . '</td>
							<td class="text-center">' . $nombre_documento . '</td>
							<td class="text-center">' . $descripcion_documento . '</td>
							<td class="text-center">' . $archivo_documento . '</td>
							<td class="text-center">' . $actividad_fecha . '</td>
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
			case 5:
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data["0"] = "";
				$data[0] .= '
				<table id="mostraractividades" class="table" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Cédula</th>
						<th scope="col" class="text-center">Docente</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					</tr>
					<tbody></thead>';
				// $caracterizacion = $panel_admin->listaractividades($id_usuario, $fecha_inicial, $fecha_final);
				$caracterizacion = $panel_admin->listarActividadesRango($fecha_inicial, $fecha_final);
				for ($h = 0; $h < count($caracterizacion); $h++) {
					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];
					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];
					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $panel_admin->fechaesp($fecha_actividad);
					$data[0] .= '
						<tr>
							<th scope="row" class="text-center">' . ($h + 1) . '</th>	
							<td class="text-center">' . $usuario_identificacion . '</td>
							<td class="text-center">' . $nombre_docente . '</td>
							<td class="text-center">' . $nombre_documento . '</td>
							<td class="text-center">' . $descripcion_documento . '</td>
							<td class="text-center">' . $archivo_documento . '</td>
							<td class="text-center">' . $actividad_fecha . '</td>
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
		}
		echo json_encode($data);
		break;
	case 'iniciarcalendario':
		$impresion = "";
		$traerhorario = $panel_admin->listarcalendarioacademico();
		$impresion .= '[';
		for ($i = 0; $i < count($traerhorario); $i++) {
			$id_actividad = $traerhorario[$i]["id_actividad"];
			$actividad = $traerhorario[$i]["actividad"];
			$fecha_inicial = $traerhorario[$i]["fecha_inicio"];
			$fecha_final = $traerhorario[$i]["fecha_final"];
			$color = $traerhorario[$i]["color"];
			$estado = $traerhorario[$i]["estado"];
			// switch ($diasemana) {
			// 	case 'Lunes':
			// 		$dia = 1;
			// 		break;
			// 	case 'Martes':
			// 		$dia = 2;
			// 		break;
			// 	case 'Miercoles':
			// 		$dia = 3;
			// 		break;
			// 	case 'Jueves':
			// 		$dia = 4;
			// 		break;
			// 	case 'Viernes':
			// 		$dia = 5;
			// 		break;
			// 	case 'Sabado':
			// 		$dia = 6;
			// 		break;
			// }
			$impresion .= '{"title":"' . $actividad . '","start":"' . $fecha_inicial . '","end":"' . $fecha_final . '","color":"' . $color . '"}';
			if ($i + 1 < count($traerhorario)) {
				$impresion .= ',';
			}
		}
		$impresion .= ']';
		echo $impresion;
		break;
	case 'clasesDelDia':
		$days = array(
			"0" => "Domingo",
			"1" => "Lunes",
			"2" => "Martes",
			"3" => "Miercoles",
			"4" => "Jueves",
			"5" => "Viernes",
			"6" => "Sabado"
		);
		$num_day = date("N", strtotime(date("Y-m-d")));
		// $num_day = 0;
		$impresion = "";
		$traerhorario = $panel_admin->listarClasesDelDia($days[$num_day]);
		// $traerhorario = $panel_admin->listarClasesDelDia('Lunes');
		$impresion .= '[';
		for ($i = 0; $i < count($traerhorario); $i++) {
			$materia = $traerhorario[$i]["nombre"];
			$salon = $traerhorario[$i]["salon"];
			$fecha_inicial = $traerhorario[$i]["hora"];
			$fecha_final = $traerhorario[$i]["hasta"];
			$jornada = $traerhorario[$i]["jornada"];
			$id_programa = $traerhorario[$i]["id_programa"];
			$traer_nombre_programa = $panel_admin->nombrePrograma($id_programa);
			$nombre_programa = $traer_nombre_programa["nombre"];
			$id_docente = $traerhorario[$i]["id_docente"];
			$traer_nombre_docente = $panel_admin->nombreDocente($id_docente);
			@$nombre_docente = $traer_nombre_docente["usuario_nombre"] . ' ' . $traer_nombre_docente["usuario_nombre_2"] . ' ' . $traer_nombre_docente["usuario_apellido"] . ' ' . $traer_nombre_docente["usuario_apellido_2"];
			$color = $traerhorario[$i]["color"];
			$impresion .= '{"title":"' . $materia . ' - ' . $salon . ' - ' . $jornada . ' - ' . @$nombre_docente . ' " , "daysOfWeek": "' . $num_day . '", "start":"' . $fecha_inicial . '","end":"' . $fecha_final . '", "color": "' . $color . '"}';
			if ($i + 1 < count($traerhorario)) {
				$impresion .= ',';
			}
		}
		$impresion .= ']';
		echo $impresion;
		break;
	case 'ListarClasesEscuela':
		$escuela = $_GET["escuela"];
		$days = array(
			"0" => "Domingo",
			"1" => "Lunes",
			"2" => "Martes",
			"3" => "Miercoles",
			"4" => "Jueves",
			"5" => "Viernes",
			"6" => "Sabado"
		);
		$num_day = date("N", strtotime(date("Y-m-d")));
		$impresion = "";
		$traerhorario = $panel_admin->ListarClasesEscuela($days[$num_day], $escuela);
		$impresion .= '[';
		for ($i = 0; $i < count($traerhorario); $i++) {
			$materia = $traerhorario[$i]["nombre"];
			$salon = $traerhorario[$i]["salon"];
			$fecha_inicial = $traerhorario[$i]["hora"];
			$fecha_final = $traerhorario[$i]["hasta"];
			$jornada = $traerhorario[$i]["jornada"];
			$color = $traerhorario[$i]["color"];
			$id_programa = $traerhorario[$i]["id_programa"];
			$traer_nombre_programa = $panel_admin->nombrePrograma($id_programa);
			$nombre_programa = $traer_nombre_programa["nombre"];
			$id_docente = $traerhorario[$i]["id_docente"];
			$traer_nombre_docente = $panel_admin->nombreDocente($id_docente);
			@$nombre_docente = $traer_nombre_docente["usuario_nombre"] . ' ' . $traer_nombre_docente["usuario_nombre_2"] . ' ' . $traer_nombre_docente["usuario_apellido"] . ' ' . $traer_nombre_docente["usuario_apellido_2"];
			$impresion .= '{"title":"' . $materia . ' - ' . $salon . ' - ' . $jornada . ' - ' . @$nombre_docente . ' " , "daysOfWeek": "' . $num_day . '", "start":"' . $fecha_inicial . '","end":"' . $fecha_final . '", "color": "' . $color . '"}';
			if ($i + 1 < count($traerhorario)) {
				$impresion .= ',';
			}
		}
		$impresion .= ']';
		echo $impresion;
		break;
	case 'listarCursosEC':
		$cursos = $panel_admin->listarCursosEC($fecha);
		$data = array(
			'exito' => 0,
			'info' => '',
			'thumbs' => '',
			'plantilla' => ''
		);
		/* se ejecuta en caso tal de no tener ningun curso ofertado */
		$data['plantilla'] .= '
		<div class="card-header mb-0">
			<div class="row align-items-center">
				<div class="col-auto">
					<i class="fa-solid fa-hashtag bg-light-yellow rounded p-3 text-warning fs-16"></i>
				</div>
				<div class="col pt-2 line-height-16">
					<h6 class="mb-0 titulo-1 fs-22 text-semibold">Vuelvete</h6>
					<p class="text-muted fs-18">Emprendedor</p>
				</div>
			</div>
		</div>';
		$data['plantilla'] .= '
		<div class="card border-0 position-relative mb-4">
			<div class="coverimg position-absolute  rounded" style="background-image: url(../public/img_educacion/plantilla-continuada.webp); width:40%;background-position: 50% 50%;background-size: cover; right:0">
				<img src="../public/img_educacion/plantilla-continuada.webp" alt="" style="display: none;">
			</div>
			<div class="row">
				<div class="col-xl-9 col-lg-9 col-md-8 col-8">
					<div class="card border-0 tono-7 shadow-none m-0">
						<div class="card-body">
							<div class="row">
								<div class="col-xl-3 col-8">
									<div class="rounded tono-6 text-white p-3">
										<i class="fa-regular fa-building fa-2x"></i>
										<p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
											Próximos<br>Cursos
										</p>
										<p class="text-semibold fs-20">AQUÍ</p>
									</div>
								</div>
								<div class="col-xl-9 ps-0 align-self-center">
									<p class="text-secondary fs-18 mb-0 line-height-18">Educación<br><span class="titulo-2 fs-28 text-semibold">Continuada</span></p>
									<div class="mt-4">
										<div class="progress h-5 mb-1 bg-light-theme">
											<div class="progress-bar bg-theme w-25" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<p class="fs-16 text-secondary">Los cursos y diplomados producen mayores ingresos</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';
		$data['plantilla'] .= '
		<div class="row px-4">
			<div class="col-12">
				<h6 class="title">En CIAF encuentras</h6>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-3 col-6 mb-1">
				<div class="rounded bg-light-blue text-white p-3 text-center">
				<i class="fa-solid fa-laptop-code fa-2x text-primary p-3"></i>
					<p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
						Cursos
					</p>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-3 col-6 mb-1">
				<div class="rounded bg-light-blue text-white p-3 text-center">
				<i class="fa-solid fa-desktop fa-2x text-primary p-3"></i>
					<p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
						Seminarios
					</p>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-3 col-6 mb-1">
				<div class="rounded bg-light-blue text-white p-3 text-center">
					<i class="fa-solid fa-laptop fa-2x text-primary p-3"></i>
					<p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
						Diplomados
					</p>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-3 col-6 mb-1">
				<div class="rounded bg-light-green  p-3 text-center">
				<i class="fa-brands fa-creative-commons-nd text-success p-2 fa-2x"></i>
					<p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
						Experiencias <br>Creativas
					</p>
				</div>
			</div>
		</div>';
		/* ******************* ******************************** */
		$data['info'] .= '
		<div class="card-header mb-0">
			<div class="row align-items-center">
				<div class="col-auto">
					<i class="fa-solid fa-hashtag bg-light-yellow rounded p-3 text-warning fs-16"></i>
				</div>
				<div class="col pt-2 line-height-16">
					<h6 class="mb-0 titulo-1 fs-22 text-semibold">Vuelvete</h6>
					<p class="text-muted fs-18">Emprendedor</p>
				</div>
			</div>
		</div>';
		// esto es para el inicio se quito porque no quieren que salga la fecha
		// ' . $fecha_inicio["dia"] . ' ' . $fecha_inicio["mes_texto"] . ' //
		$data['info'] .= '<div class="continuada">';
		for ($i = 0; $i < count($cursos); $i++) {
			$fecha_creacion = explode(" ", $cursos[$i]["create_dt"]);
			$fecha_inicio = $panel_admin->convertirFechaAtexto($cursos[$i]["fecha_inicio"]);
			$create_dt = $panel_admin->convertirFechaAtexto($fecha_creacion[0]);
			$data['exito'] = 1;
			$data['info'] .= '
				<!-- Social card -->
				<div class="card bg-radial-gradient text-white h-100">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-xl-12">
								<h5 class="titulo-2 text-semibold fs-20">' . $cursos[$i]["nombre_curso"] . '</h5>
								<figure class="m-0" style="background-image: url("../public/img_educacion/' . $cursos[$i]["imagen_curso"] . '");">
									<img src="../public/img_educacion/' . $cursos[$i]["imagen_curso"] . '" width="100%">
								</figure>
							</div>
							<div class="col-xl-9">
							</div>
							<div class="col-12" style="height:350px; overflow-y:scroll">
								<p class="text-muted fs-14">
									' . $cursos[$i]["descripcion_curso"] . '
								</p>
							</div>
						</div>
					</div>
					<div class="card-footer justify-content-center">
						<div class="row tono-1 py-2 ">
							<div class="col-xl-4 col-lg-4 col-md-6 col-6">
								<div class="row justify-content-center">
									<div class="col-12 hidden">
										<div class="row align-items-center">
											<div class="col-auto">
												<div class="p-2 rounded bg-light-blue text-primary">
													<i class="fa-solid fa-check" aria-hidden="true"></i>
												</div>
											</div>
											<div class="col ps-0">
												<div class="parrafo-normal small mb-0">Nivel</div>
												<div class="parrafo-normal text-semibold nivel_curso fs-14 text-capitalize">' . $cursos[$i]["nivel_educacion"] . '</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-6 col-6">
								<div class="row justify-content-center">
									<div class="col-12 hidden">
										<div class="row align-items-center">
											<div class="col-auto">
												<div class="p-2 rounded bg-light-blue text-primary">
													<i class="fa-solid fa-check" aria-hidden="true"></i>
												</div>
											</div>
											<div class="col ps-0">
												<div class="parrafo-normal small mb-0">Inicia</div>
												<div class="parrafo-normal text-semibold modalidad_curso fs-14 text-capitalize">Próximamente</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-6 col-6">
								<div class="row justify-content-center">
									<div class="col-12 hidden">
										<div class="row align-items-center">
											<div class="col-auto">
												<div class="p-2 rounded bg-light-blue text-primary">
													<i class="fa-regular fa-clock"></i>
												</div>
											</div>
											<div class="col ps-0">
												<div class="parrafo-normal small mb-0">Duración</div>
												<div class="parrafo-normal text-semibold duracion_curso fs-14 text-capitalize">' . $cursos[$i]["duracion_educacion"] . ' Horas</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class=" row align-items-center py-4">
							<div class="col-xl-8">
								<div class="row align-items-center">
									<div class="col-auto">
										<div class="p-3 rounded bg-light-green text-success">
											<i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col ps-0">
										<div class="small mb-0 parrafo-normal">Inversión</div>
										<span class="boton fs-24 text-semibold parrafo-normal">$ <span class="valor_curso">' . $cursos[$i]["precio_curso"] . '</span>
									</span></div>
								</div>
							</div>
							<div class="col-xl-4">
								<a class="btn btn-pagos float-right p-3" onclick="separarCupo(' . $cursos[$i]["id_curso"] . ')">Separa tu cupo</a>
							</div>
						</div>
					</div>
				</div>';
		}
		$data['info'] .= '</div>';
		echo json_encode($data);
		break;
	case 'separarCupo':
		$id_curso = $_POST["id_curso"];
		$data['conte'] = '';
		$miscursos = $panel_admin->verificarInteresado($id_curso, $s_identificacion);
		if ($miscursos) {
			$data['conte'] .= 'si';
		} else {
			$estado = "Interesado";
			$insertarinteresado = $panel_admin->insertarInteresado($s_identificacion, $id_curso, $periodo_actual, $fecha, $hora, $estado, $periodo_actual, $id_usuario);
			if ($insertarinteresado) {
				$data['conte'] .= 'ok';
			} else {
				$data['conte'] .= 'no';
			}
		}
		echo json_encode($data);
		break;
	case 'listarDetallesCursoEc':
		//generamos un array con todos los datos a enviar pero vacios
		$data = array("exito" => 0, "nombre_curso" => "", "docente_curso" => "", "descripcion_curso" => "", "modalidad_curso" => "", "fecha_inicio" => "", "fecha_fin" => "", "horario_curso" => "", "estado_curso" => "", "sede_curso" => "", "precio_curso" => "", "imagen_curso" => "", "estado_educacion" => "", "duracion_educacion" => "", "nivel_educacion" => "", "categoria" => "", "create_dt" => "");
		//tomamos el id del curso enviado desde el POST
		$id_curso = isset($_POST["id_curso"]) ? $_POST["id_curso"] : "";
		//consultamos en base de datos los detalles del id del curso
		$detalles = $panel_admin->listarDetallesCursoEc($id_curso);
		$boton_epayco = '
			<!-- =====================================================================
			///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
			===================================================================== -->
			<form>
				<script src="https://checkout.epayco.co/checkout.js" 
					data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
					class="epayco-button" 
					data-epayco-amount="' . $detalles["precio_curso"] . '" 
					data-epayco-tax="0"
					data-epayco-tax-base="' . $detalles["precio_curso"] . '"
					data-epayco-name="' .  $detalles["nombre_curso"] . '" 
					data-epayco-description="Pago curso ' . $detalles["nombre_curso"] . ' CC. ' . $_SESSION["usuario_identificacion"] . '" 
					data-epayco-extra1="' . $id_curso . '"
					data-epayco-extra2="' . $_SESSION["id_usuario"] . '"
					data-epayco-extra3="' . $_SESSION["roll"] . '"
					data-epayco-currency="cop"    
					data-epayco-country="CO" 
					data-epayco-test="false" 
					data-epayco-external="true"
					data-epayco-response="https://ciaf.digital/vistas/gracias_educacion_continuada.php"  
					data-epayco-confirmation="https://ciaf.digital/vistas/pagos_educacion_continuada.php" 
					data-epayco-button="https://ciaf.digital/public/img/epayco_web.webp">
				</script> 
			</form>';
		if (count($detalles) > 0) {
			//consultamos si el cliente se encuentra aliado a este curso
			$inscrito = $panel_admin->verificarInscritoEC($_SESSION["id_usuario"], $_SESSION["roll"], $id_curso);
			if (is_array($inscrito) && count($inscrito) > 0) {
				$div_botones = '<div class="col-12 text-center h6 font-weight-bold">
					Te encuentras <span class="text-success">' . $inscrito["estado_inscrito"] . '</span> en este curso
				</div>';
				$div_botones .= ($inscrito["estado_inscrito"] == "inscrito") ? '<div class="col-12 text-center"> ' . $boton_epayco . ' </div>' : "";
				$div_inscripcion = '';
			} else {
				//generamos el boton de pago con informacion del estudiante
				$div_botones = '
				<div class="col-12 border-bottom p-1"></div>
				<div class="col-6 pt-2" >
					<a class="pointer" onclick=$("#precarga_modal").show()>' . $boton_epayco . '</a>
				</div>
				';
				$div_inscripcion = '<div class="col-12 pt-2 justify-content-center">
										<a class="btn btn-pagos" onclick="inscripcionEducacioncontinua(' . $id_curso . ')">
											<span class="text-white">Inscríbete <br>Aquí</span>
										</a>
									</div>';
			}
			$data = array(
				"exito" => 1,
				"nombre_curso" => $detalles["nombre_curso"],
				"docente_curso" => $detalles["docente_curso"],
				"descripcion_curso" => $detalles["descripcion_curso"],
				"modalidad_curso" => $detalles["modalidad_curso"],
				"fecha_inicio" => $panel_admin->fechaesp($detalles["fecha_inicio"]),
				"fecha_fin" => $detalles["fecha_fin"],
				"horario_curso" => $detalles["horario_curso"],
				"estado_curso" => $detalles["estado_curso"],
				"sede_curso" => $detalles["sede_curso"],
				"precio_curso" => $detalles["precio_curso"],
				"imagen_curso" => $detalles["imagen_curso"],
				"estado_educacion" => $detalles["estado_educacion"],
				"duracion_educacion" => $detalles["duracion_educacion"],
				"nivel_educacion" => $detalles["nivel_educacion"],
				"categoria" => $detalles["categoria"],
				"create_dt" => $detalles["create_dt"],
				"boton_epayco" => $div_botones,
				"boton_inscripcion" => $div_inscripcion,
			);
		}
		echo json_encode($data);
		break;
	case 'inscripcionEducacioncontinua':
		$id_curso = isset($_POST["id_curso"]) ? $_POST["id_curso"] : die(json_encode(array("exito" => 0, "info" => "Debes seleccionar un curso para inscribirte.")));
		$stmt = $panel_admin->insertarInscritoEC($id_curso, $_SESSION["id_usuario"], $_SESSION["roll"], $periodo_actual);
		if ($stmt) {
			$data = array(
				"exito" => 1,
				"info" => "Te has inscrito correctamente al curso"
			);
		} else {
			$data = array(
				"exito" => 0,
				"info" => "Ha ocurrido un error al intentar ejecutar la petición. Intenta mas tarde, por favor."
			);
		}
		echo json_encode($data);
		break;
	case 'mostrarcursosinscritos':
		$data['conte'] = '';
		$miscursos = $panel_admin->mostrarcursosinscritos($s_identificacion);
		for ($i = 0; $i < count($miscursos); $i++) {
			if ($miscursos[$i]["estado_interesado"] == "Interesado") {
				if ($miscursos[$i]["fecha_inicio"] >= $fecha) {
					$data['conte'] .= '
						<div class="col-12 tono-3 ml-2 mb-4">
							<div class="row">		
								<div class="col-xl-5 bg-light-blue rounded">
									<div class="row d-flex align-items-center">
										<div class="col-auto">
											<i class="fa-solid fa-hashtag p-3 fa-2x bg-light-blue rounded my-2"></i>
										</div>
										<div class="col-auto line-height-18">
											<span class="text-capitalize">' . $miscursos[$i]["categoria"] . '</span> <br>
											<span class="titulo-2 text-semibold fs-20">' . $miscursos[$i]["nombre_curso"] . '</span> 
										</div>
									</div>
								</div>
								<div class="col-xl-1 pl-3 d-flex align-items-center">
									<div class="row ">
										<div class="col-auto line-height-18">
											<span class="">Estado <br><span class="text-success"><b>Interesado</b></span> <br>
										</div>
									</div>
								</div>
								<div class="col-xl-5 d-flex align-items-center">
									<div class="row">
										<div class="col-auto line-height-18">
											<span class="">Inversión</span> <br>
											<span class="text-semibold fs-20">$' . $miscursos[$i]["precio_curso"] . '</span> 
										</div>
										<div class="col-auto line-height-18 ">
											<!-- =====================================================================
											///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
											===================================================================== -->
											<form>
												<script src="https://checkout.epayco.co/checkout.js" 
													data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
													class="epayco-button" 
													data-epayco-amount="' . $miscursos[$i]["precio_curso"] . '" 
													data-epayco-tax="0"
													data-epayco-tax-base="' . $miscursos[$i]["precio_curso"] . '"
													data-epayco-name="' .  $miscursos[$i]["nombre_curso"] . '" 
													data-epayco-description="Pago curso ' . $miscursos[$i]["nombre_curso"] . ' CC. ' . $_SESSION["usuario_identificacion"] . '" 
													data-epayco-extra1="' . $miscursos[$i]["id_curso"] . '"
													data-epayco-extra2="' . $_SESSION["id_usuario"] . '"
													data-epayco-extra3="' . $_SESSION["usuario_identificacion"] . '"
													data-epayco-currency="cop"    
													data-epayco-country="CO" 
													data-epayco-test="false" 
													data-epayco-external="true"
													data-epayco-response="https://ciaf.digital/vistas/gracias_educacion_continuada.php"  
													data-epayco-confirmation="https://ciaf.digital/vistas/pagos_educacion_continuada.php" 
													data-epayco-button="https://ciaf.digital/public/img/epayco_web.webp">
												</script> 
											</form>
										</div>
										<div class="col-auto line-height-18 border-left">
											<span class="">Solicita ya</span> <br>
											<span class="text-semibold fs-20">Tu crédito</span> 
										</div>
									</div>
								</div>
								<div class="col-xl-1 rounded-0 pt-2">
									<button type="button" class="close" title="Eliminar Inscripción" onclick="eliminarInscripcion(' . $miscursos[$i]["id_edu_cont_in"] . ')">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>
						</div>
					';
				}
			} else {
				if ($miscursos[$i]["fecha_inicio"] >= $fecha) {
					$data['conte'] .= '
						<div class="col-12 py-2 pl-3">
							<div class="row">
								<div class="col-xl-5 alert alert-success pl-2">
									<div class="row align-items-center">
										<div class="col-auto">
											<span class="rounded bg-white p-3 text-success">
												<i class="fa-solid fa-hashtag" aria-hidden="true"></i>
											</span> 
										</div>
										<div class="col-auto line-height-18">
											<span class="text-capitalize">' . $miscursos[$i]["categoria"] . '</span> en: <br>
											<span class="text-semibold fs-20">' . $miscursos[$i]["nombre_curso"] . '</span> 
										</div>
									</div>
								</div>
								<div class="col-xl-1 alert tono-3">
									<div class="row align-items-center">
										<div class="col-auto line-height-18">
											<span class="">Estado  <br> <span class="text-success"><b>Matriculado</b></span>
										</div>
									</div>
								</div> 
								<div class="col-xl-6 alert tono-3">
									<div class="row align-items-center">
										<div class="col-auto line-height-18">
											<span class="">' . $fecha . '</span> <br>
											<span class="text-semibold fs-20">' . $miscursos[$i]["fecha_inicio"] . '</span> 
										</div>
									</div>
								</div>
							</div>
						</div>
					';
				}
			}
		}
		echo json_encode($data);
		break;
	case 'eliminarInscripcion':
		$valor = $_POST["valor"];
		$data['conte'] = '';
		$miscursos = $panel_admin->eliminarinscripcion($valor);
		echo json_encode($data);
		break;
	case 'mostrarcalendario':
		//print_r($_POST['check_list']);
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		$anio_actual = date("Y");
		$mes_actual = date("m");
		$data[0] = "";
		if (!empty($_POST['check_list'])) {
			$check = $_POST['check_list'][0];
			// Variable para almacenar el nombre del mes
			$mes_nombre = $meses[$check]; 
			if ($check < 10) {
				$check = "0" . $check;
			} else {
				$check;
			}
			//echo "$anio_actual - $check - $mes_nombre";
			$fecha_actual_eventos = date("m");
			$data[0] .= '<div class="academico">';
			// imprime las actividades del calendario 
			$cuenta = 0;
			$eventosacademicos = $panel_admin->traercalendario($anio_actual . "-" . $check);
			if ($eventosacademicos) {
				for ($a = 0; $a < count($eventosacademicos); $a++) {
					$fechahoy = new DateTime($fecha);
					$final = new DateTime($eventosacademicos[$a]["fecha_final"]);
					$diferencia = $fechahoy->diff($final)->format("%r%a");
					$fecha_final = $eventosacademicos[$a]["fecha_final"];
					$fecha_inicio_actividad = $eventosacademicos[$a]["fecha_inicio"];
					$fechaComoEntero = strtotime($fecha_final);
					$dia_final = date("d", $fechaComoEntero);
					$mes_final = date("m", $fechaComoEntero);
					$anio_final = date("Y", $fechaComoEntero);
					if ($fecha_inicio_actividad >= $fecha_actual_eventos) {
						$cuenta++;
						$data[0] .= '
								<div class="borde rounded px-3 py-2 m-2">
									<div class="row">
										<div class="col-5">
											<div class="row">
												<div class="col-12 fs-14">Hasta </div>
												<div class="col-12 fs-48 titulo-7" style="line-height:34px">' . $dia_final . '</div>
												<div class="col-12 fs-14">' . $mes_nombre . ' ' . $anio_final . '</div>
											</div>
										</div>
										<div class="col-7" style="line-height:14px">
											<div class="row">
												<div class="col-12" style="z-index:1">
													<span class="badge bg-light-green float-right mt-1 mr-3 text-success" >' . $diferencia . ' Días </span>
												</div>
												<div class="col-12 d-flex align-content-center flex-wrap position-absolute fs-14" style="height:100%;">
													<b>' . $eventosacademicos[$a]["actividad"] . '</b>
												</div>
											</div>
										</div>
									</div>
								</div>';
					}
				}
			}
			$data[0] .= '</div>';
			if ($cuenta == 0) {
				$data[0] .= '<div class="col-12 pb-3">
						<div class="row">
							<div class="col-xl-4">
								<div class="rounded tono-6 text-white p-3">
									<p class="titulo-2 fs-14 mb-1 line-height-16">
										Súmate<br>
										<span class="fs-20 text-semibold">al Parche</span>
									</p>
									<p class="pt-2">Siguiente <i class="fa-solid fa-play"></i></p>
								</div>
							</div>
							<div class="col-xl-8 align-self-center">
								<div class="row">
									<div class="col-12 col-lg">
										<p class="text-secondary small mb-0">Sin eventos</p>
										<p class="fs-16">El siguiente mes llegara cargado de nuevas experiencias</p>
									</div>
								</div>
								<p class="small text-secondary">Publicado: <span class="float-end">' . $fecha . '</span></p>
							</div>
						</div>
					</div>';
			}
		}
		echo json_encode($data);
		break;
	case 'mostrarcalendarioeventos':
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		$anio_actual = date("Y");
		$mes_actual = date("m");
		$data[0] = "";
		if (!empty($_POST['check_list'])) {
			foreach ($_POST['check_list'] as $check) {
				switch ($check) {
					case '01':
						$meses = "Enero";
						break;
					case '02':
						$meses = "Febrero";
						break;
					case '03':
						$meses = "Marzo";
						break;
					case '04':
						$meses = "Abril";
						break;
					case '05':
						$meses = "Mayo";
						break;
					case '06':
						$meses = "Junio";
						break;
					case '07':
						$meses = "Julio";
						break;
					case '08':
						$meses = "Agosto";
						break;
					case '09':
						$meses = "Septiembre";
						break;
					case '10':
						$meses = "Octubre";
						break;
					case '11':
						$meses = "Noviembre";
						break;
					case '12':
						$meses = "Diciembre";
						break;
				}
				if ($check < 10) {
					$check = "0" . $check;
				} else {
					$check;
				}
			}
			$fecha_actual_eventos = date("Y-m-d");
			// listar eventos del calendario eventos
			$eventos = $panel_admin->listarEventos($anio_actual . "-" . $check, $fecha_actual_eventos);
			$cuantos = count($eventos);
			if ($cuantos == 0) {
				$data[0] .= '<div class="col-12 pb-3">
					<div class="row">
						<div class="col-xl-4">
							<div class="rounded tono-6 text-white p-3">
								<p class="titulo-2 fs-14 mb-1 line-height-16">
									Súmate<br>
									<span class="fs-20 text-semibold">al Parche</span>
								</p>
								<p class="pt-2">Siguiente <i class="fa-solid fa-play"></i></p>
							</div>
						</div>
						<div class="col-xl-8 align-self-center">
							<div class="row">
								<div class="col-12 col-lg">
									<p class="text-secondary small mb-0">Sin eventos</p>
									<p class="fs-16">El siguiente mes llegara cargado de nuevas experiencias</p>
								</div>
							</div>
							<p class="small text-secondary">Publicado: <span class="float-end">' . $fecha . '</span></p>
						</div>
					</div>
				</div>';
			}
			$data[0] .= '<div class="eventos">';
			for ($d = 0; $d < count($eventos); $d++) {
				$fecha_inicio_evento = date($eventos[$d]["fecha_inicio"]);
				$dia = date("d", strtotime($fecha_inicio_evento));
				$mes = date("m", strtotime($fecha_inicio_evento));
				$año = date("y", strtotime($fecha_inicio_evento));
				$horas = date($eventos[$d]["hora"]);
				$hora = date("h:i a",  strtotime($horas));
				$dia_semana = date('l', strtotime($fecha_inicio_evento));
				switch ($dia_semana) {
					case "Sunday":
						$dia_semana_final = "Domingo";
						break;
					case "Monday":
						$dia_semana_final = "Lunes";
						break;
					case "Tuesday":
						$dia_semana_final = "Martes";
						break;
					case "Wednesday":
						$dia_semana_final = "Miercoles";
						break;
					case "Thursday":
						$dia_semana_final = "Jueves";
						break;
					case "Friday":
						$dia_semana_final = "Viernes";
						break;
					case "Saturday":
						$dia_semana_final = "Sabado";
						break;
				}
				$actividad_pertenece = $panel_admin->selectActividadActiva($eventos[$d]["id_actividad"], $check);
				if ($cuantos <= 2) { //si tenemos menos de dos eventos
					$data[0] .= '
							<div class="col-xl-6 mx-2">
								<div class="row ">
									<div class="col-xl-12 mb-2 p-0 pb-2 borde rounded" style="min-width:200px">
										<div class="row">
											<div class="col-xl-6 d-flex align-content-center flex-wrap" style="line-height:14px">
												<p class="fs-14 pt-4 pl-2"><b>' . $eventos[$d]["evento"] . ' </b></p>
											</div>
											<div class="col-xl-6 pt-4 pl-4 text-center">
												<span class="event-dash-card-icon"><i class="fa-regular fa-calendar"></i> </span>
												<span>' . $dia_semana_final . '</span><br>
												<span class="fs-48 titulo-7" style="line-height:34px">' . $dia . '</span><br>
												<span>' . $hora . '</span><br>
											</div>
											<div class="col-12">
												<span class="ml-2 badge ' . @$actividad_pertenece["color"] . '">' . @$actividad_pertenece["actividad"] . '</span>
											</div>
										</div>
									</div>
								</div>
							</div>';
				} else { // si tenemos mas de dos eventos
					$data[0] .= '
							<div class="col-xl-4">
								<div class="row d-flex justify-content-center">
									<div class="col-xl-11  mb-2 p-0 pb-2 borde rounded" >
										<div class="row">
											<div class="col-xl-6 d-flex align-content-center flex-wrap" style="line-height:14px">
												<p class="fs-16 pt-4 pl-2"><b>' . $eventos[$d]["evento"] . ' </b></p>
											</div>
											<div class="col-xl-6 pt-4 pl-4 text-center">
												<span class="event-dash-card-icon"><i class="fa-regular fa-calendar"></i> </span>
												<span>' . $dia_semana_final . '</span><br>
												<span class="fs-48 titulo-7" style="line-height:34px">' . $dia . '</span><br>
												<span>' . $hora . '</span><br>
											</div>
											<div class="col-12">
												<span class="ml-2 badge ' . $actividad_pertenece["color"] . '">' . $actividad_pertenece["actividad"] . '</span>
											</div>
										</div>
									</div>
								</div>
							</div>';
				}
			}
			$data[0] .= '</div>';
		}
		echo json_encode($data);
		break;
	case 'checkbox':
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		$anio_actual = date("Y");
		$mes_actual = date("m");
		$data[0] = "";
		if (!empty($_POST['check_list'])) {
			foreach ($_POST['check_list'] as $check) {
				switch ($check) {
					case '01':
						$meses = "Enero";
						break;
					case '02':
						$meses = "Febrero";
						break;
					case '03':
						$meses = "Marzo";
						break;
					case '04':
						$meses = "Abril";
						break;
					case '05':
						$meses = "Mayo";
						break;
					case '06':
						$meses = "Junio";
						break;
					case '07':
						$meses = "Julio";
						break;
					case '08':
						$meses = "Agosto";
						break;
					case '09':
						$meses = "Septiembre";
						break;
					case '10':
						$meses = "Octubre";
						break;
					case '11':
						$meses = "Noviembre";
						break;
					case '12':
						$meses = "Diciembre";
						break;
				}
				if ($check < 10) {
					$check = "0" . $check;
				} else {
					$check;
				}
			}
			$fecha_actual_eventos = date("Y-m-d");
			// imprime las actividades del calendario 
			$eventosacademicos = $panel_admin->traercalendario($anio_actual . "-" . $check, $fecha_actual_eventos);
			$data[0] .= '
			<div class="col-12 pb-4">
				<div class="row p-0 m-0">
				<div class="col-6 py-4 text-regular fs-20">Calendario Académico</div>
				<div class="col-6 py-4">
					<a onclick="iniciarcalendario()" class="btn btn-primary btn-sm float-right">
						Ver completo
					</a></div>
				<div class="col-xl-12 tarjetas">
					<div id="forcecentered1">
						<div class="event-list2 bd-highlight">';
			for ($a = 0; $a < count($eventosacademicos); $a++) {
				$fechahoy = new DateTime($fecha);
				$final = new DateTime($eventosacademicos[$a]["fecha_final"]);
				$diferencia = $fechahoy->diff($final)->format("%r%a");
				$fecha_final = $eventosacademicos[$a]["fecha_final"];
				$fecha_inicio_actividad = $eventosacademicos[$a]["fecha_inicio"];
				$fechaComoEntero = strtotime($fecha_final);
				$dia_final = date("d", $fechaComoEntero);
				$mes_final = date("m", $fechaComoEntero);
				$anio_final = date("Y", $fechaComoEntero);
				if ($fecha_inicio_actividad >= $fecha_actual_eventos) {
					$data[0] .= '
									<div class=" tarjeta2">
										<div class="bg-warning p-1"></div>
										<div class="row">
											<div class="col-5 ">
												<div class="fecha-tarjeta pl-2">
													<span class="titulo-mes">Hasta </span><br>
													<span class="titulo-dia">' . $dia_final . '</span><br>
													<span class="titulo-mes">' . $meses . ' ' . $anio_final . '</span>
												</div>
											</div>
											<div class="col-7" style="line-height:14px">
												<div class="row">
													<div class="col-12" style="z-index:1">
														<span class="badge badge-warning float-right mt-1 mr-3" >' . $diferencia . ' Días </span>
													</div>
													<div class="col-12 d-flex align-content-center flex-wrap position-absolute" style="height:100%;">
														<b>' . $eventosacademicos[$a]["actividad"] . '</b>
													</div>
												</div>
											</div>
										</div>
									</div>';
				}
			}
			$data[0] .= '	   
						</div>
					</div>
				</div>
				</div>
			</div>';
			// listar eventos del calendario eventos
			$eventos = $panel_admin->listarEventos($anio_actual . "-" . $check, $fecha_actual_eventos);
			$data[0] .= '
				<div class="col-12 " >
					<div class="row p-0 m-0">
						<div class="col-xl-12 pb-4">
							<h2>
							<span class="fs-20 text-regular">Calendario Eventos </span>
							</h2> 
						</div>
						<div class="col-xl-12">
							<div class="row">';
			for ($d = 0; $d < count($eventos); $d++) {
				$fecha_inicio_evento = date($eventos[$d]["fecha_inicio"]);
				$dia = date("d", strtotime($fecha_inicio_evento));
				$mes = date("m", strtotime($fecha_inicio_evento));
				$año = date("y", strtotime($fecha_inicio_evento));
				$horas = date($eventos[$d]["hora"]);
				$hora = date("h:i a",  strtotime($horas));
				$dia_semana = date('l', strtotime($fecha_inicio_evento));
				switch ($dia_semana) {
					case "Sunday":
						$dia_semana_final = "Domingo";
						break;
					case "Monday":
						$dia_semana_final = "Lunes";
						break;
					case "Tuesday":
						$dia_semana_final = "Martes";
						break;
					case "Wednesday":
						$dia_semana_final = "Miercoles";
						break;
					case "Thursday":
						$dia_semana_final = "Jueves";
						break;
					case "Friday":
						$dia_semana_final = "Viernes";
						break;
					case "Saturday":
						$dia_semana_final = "Sabado";
						break;
				}
				$actividad_pertenece = $panel_admin->selectActividadActiva($eventos[$d]["id_actividad"], $check);
				if ($fecha_inicio_evento >= $fecha_actual_eventos) {
					$data[0] .= '
							<div class="col-xl-4">
								<div class="row d-flex justify-content-center">
									<div class="col-xl-11  mb-2 p-0 pb-2 tarjeta-evento" >
										<div class="' . $actividad_pertenece["color"] . ' p-1"></div>
										<div class="row">
											<div class="col-xl-6 d-flex align-content-center flex-wrap" style="line-height:14px">
												<p class="fs-16 pt-4 pl-2"><b>' . $eventos[$d]["evento"] . ' </b></p>
											</div>
											<div class="col-xl-6 pt-4 pl-4 text-center">
												<span class="event-dash-card-icon"><i class="bi bi-calendar3"></i> </span>
												<span>' . $dia_semana_final . '</span><br>
												<span class="dia">' . $dia . '</span><br>
												<span>' . $hora . '</span><br>
											</div>
											<div class="col-12">
												<span class="ml-2 badge ' . $actividad_pertenece["color"] . '">' . $actividad_pertenece["actividad"] . '</span>
											</div>
										</div>
									</div>
								</div>
							</div>';
				}
			}
			$data[0] .= '	   
						</div>
					</div>
				</div>
				</div>';
		}
		echo json_encode($data);
		break;
	case 'cajadeherramientas':
		$data['conte'] = '';
		$data['conte'] .= '  
                    <div class="mostrarcajadeherramientas">';
		$respuesta = $panel_admin->mostrarElementos();
		for ($i = 0; $i < count($respuesta); $i++) {
			$data['conte'] .= '
									<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 ">
										<div class="card   direct-chat direct-chat-primary p-2">
											<div class="contenedor-img ejemplo-1">
												<div class="d-flex justify-content-center mx-auto d-block align-items-center bg-white rounded" style="height:100px">
													<img src="../public/img/software_libre/' . $respuesta[$i]["ruta_img"] . '" style="width: 100%; max-height: 100%;" alt="' . $respuesta[$i]["nombre"] . '">
												</div>
												<div class="col-12 mt-2" style="height:60px">
													<span class="titulo-2 fs-12 text-semibold text-center line-height-16"><b>' . $respuesta[$i]["nombre"] . '</b></span>  
												</div>
												<div class="col-12 text-center">
														<a href="' . $respuesta[$i]["url"] . '" class="btn btn-outline-primary btn-xs" target="_blank">Leer más</a>
												</div>
											</div>
										</div>
									';
			$i++;
			$data['conte'] .= '
										<div class="card   direct-chat direct-chat-primary p-2">
											<div class="contenedor-img ejemplo-1">
												<div class="d-flex justify-content-center mx-auto d-block align-items-center bg-white rounded" style="height:100px">
													<img src="../public/img/software_libre/' . $respuesta[$i]["ruta_img"] . '" style="width: 100%; max-height: 100%;" alt="' . $respuesta[$i]["nombre"] . '">
												</div>
												<div class="col-12 mt-2" style="height:60px"> 
													<span class="titulo-2 fs-12 text-semibold text-center line-height-16"><b>' . $respuesta[$i]["nombre"] . '</b></span>  
												</div>
												<div class="col-12 text-center">
														<a href="' . $respuesta[$i]["url"] . '" class="btn btn-outline-primary btn-xs" target="_blank">Leer más</a>
												</div>
											</div>
										</div>
									</div>';
		}
		$data['conte'] .= '
                    </div>
            ';
		echo json_encode($data);
		break;
	case 'vershopping':
		$data['vershopping'] = '';
		$data['vershopping'] .= '   
					<div class="mostrarshopping">';
		$respuesta = $panel_admin->mostrarshopping();
		for ($i = 0; $i < count($respuesta); $i++) {
			$data['vershopping'] .= '
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
								<div class="row h-100 tono-3 mr-1 rounded justify-content-center pb-2">
									<div class="col-12 m-0 p-3">
										<div class="d-flex justify-content-center mx-auto d-block align-items-center">
											<img src="../files/shopping/' . $respuesta[$i]["shopping_img"] . '" class="rounded" style="width: 100%; height: 200px" alt="' . $respuesta[$i]["shopping_img"] . '">
										</div>
										<div class="col-12 mt-2 d-flex align-items-center justify-content-center" style="height:60px">
											<p class="fs-14 text-center text-semibold line-height-16 titulo-2">' . $respuesta[$i]["shopping_nombre"] . '</p>  
										</div>
									</div>
									<div class="col-4 bg-primary p-2 text-center">';
			if ($respuesta[$i]["shopping_facebook"] != "") {
				$data['vershopping'] .= '<a href="' . $respuesta[$i]["shopping_facebook"] . '" target="_blank"><i class="fa-brands fa-facebook-f "></i></a>';
			} else {
				$data['vershopping'] .= ' <i class="fa-brands fa-facebook-f  text-primary"></i>';
			}
			$data['vershopping'] .= '
									</div>
									<div class="col-4 bg-info p-2 text-center">';
			if ($respuesta[$i]["shopping_instagram"] != "") {
				$data['vershopping'] .= '<a href="' . $respuesta[$i]["shopping_instagram"] . '" target="_blank"><i class="fa-brands fa-instagram "></i></a>';
			} else {
				$data['vershopping'] .= ' <i class="fa-brands fa-instagram  text-info"></i>';
			}
			$data['vershopping'] .= '
									</div>
								</div>
							</div>
							';
		}
		$data['vershopping'] .= '
					</div>
			';
		echo json_encode($data);
		break;
	case 'guardarmonitoriandoadministrativos':
		$p1 = isset($_POST["p1"]) ? limpiarCadena($_POST["p1"]) : "";
		$p2 = isset($_POST["p2"]) ? limpiarCadena($_POST["p2"]) : "";
		$p3 = isset($_POST["p3"]) ? limpiarCadena($_POST["p3"]) : "";
		$p4 = isset($_POST["p4"]) ? limpiarCadena($_POST["p4"]) : "";
		$p5 = isset($_POST["p5"]) ? limpiarCadena($_POST["p5"]) : "";
		$p6 = isset($_POST["p6"]) ? limpiarCadena($_POST["p6"]) : "";
		$p7 = isset($_POST["p7"]) ? limpiarCadena($_POST["p7"]) : "";
		$p8 = isset($_POST["p8"]) ? limpiarCadena($_POST["p8"]) : "";
		$p9 = isset($_POST["p9"]) ? limpiarCadena($_POST["p9"]) : "";
		$p10 = isset($_POST["p10"]) ? limpiarCadena($_POST["p10"]) : "";
		$p11 = isset($_POST["p11"]) ? limpiarCadena($_POST["p11"]) : "";
		$p12 = isset($_POST["p12"]) ? limpiarCadena($_POST["p12"]) : "";
		$p13 = isset($_POST["p13"]) ? limpiarCadena($_POST["p13"]) : "";
		$p14 = isset($_POST["p14"]) ? limpiarCadena($_POST["p14"]) : "";
		$p15 = isset($_POST["p15"]) ? limpiarCadena($_POST["p15"]) : "";
		$p16 = isset($_POST["p16"]) ? limpiarCadena($_POST["p16"]) : "";
		$p17 = isset($_POST["p17"]) ? limpiarCadena($_POST["p17"]) : "";
		$p18 = isset($_POST["p18"]) ? limpiarCadena($_POST["p18"]) : "";
		$p19 = isset($_POST["p19"]) ? limpiarCadena($_POST["p19"]) : "";
		$p20 = isset($_POST["p20"]) ? limpiarCadena($_POST["p20"]) : "";
		$p21 = isset($_POST["p21"]) ? limpiarCadena($_POST["p21"]) : "";
		$p22 = isset($_POST["p22"]) ? limpiarCadena($_POST["p22"]) : "";
		$p23 = isset($_POST["p23"]) ? limpiarCadena($_POST["p23"]) : "";
		$p24 = isset($_POST["p24"]) ? limpiarCadena($_POST["p24"]) : "";
		$p25 = isset($_POST["p25"]) ? limpiarCadena($_POST["p25"]) : "";
		$p26 = isset($_POST["p26"]) ? limpiarCadena($_POST["p26"]) : "";
		$p27 = isset($_POST["p27"]) ? limpiarCadena($_POST["p27"]) : "";
		$p28 = isset($_POST["p28"]) ? limpiarCadena($_POST["p28"]) : "";
		$p29 = isset($_POST["p29"]) ? limpiarCadena($_POST["p29"]) : "";
		$p30 = isset($_POST["p30"]) ? limpiarCadena($_POST["p30"]) : "";
		$p31 = isset($_POST["p31"]) ? limpiarCadena($_POST["p31"]) : "";
		$p32 = isset($_POST["p32"]) ? limpiarCadena($_POST["p32"]) : "";
		$p33 = isset($_POST["p33"]) ? limpiarCadena($_POST["p33"]) : "";
		$p34 = isset($_POST["p34"]) ? limpiarCadena($_POST["p34"]) : "";
		$p35 = isset($_POST["p35"]) ? limpiarCadena($_POST["p35"]) : "";
		$p36 = isset($_POST["p36"]) ? limpiarCadena($_POST["p36"]) : "";
		$p37 = isset($_POST["p37"]) ? limpiarCadena($_POST["p37"]) : "";
		$p38 = isset($_POST["p38"]) ? limpiarCadena($_POST["p38"]) : "";
		$p39 = isset($_POST["p39"]) ? limpiarCadena($_POST["p39"]) : "";
		$p40 = isset($_POST["p40"]) ? limpiarCadena($_POST["p40"]) : "";
		$p41 = isset($_POST["p41"]) ? limpiarCadena($_POST["p41"]) : "";
		$p42 = isset($_POST["p42"]) ? limpiarCadena($_POST["p42"]) : "";
		$p43 = isset($_POST["p43"]) ? limpiarCadena($_POST["p43"]) : "";
		$p44 = isset($_POST["p44"]) ? limpiarCadena($_POST["p44"]) : "";
		$fecha = date('Y-m-d');
		$verificar_id_usuario = $panel_admin->verificarRegistromonitoreandoadministrativo($id_usuario);
		if ($verificar_id_usuario) {
			$inserto = array(
				"estatus" => 0,
				"valor" => "Ya realizaste la evaluación."
			);
		} else {
			$rspta = $panel_admin->GuardarMonitoriandoAdministrativos($id_usuario, $fecha, $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15, $p16, $p17, $p18, $p19, $p20, $p21, $p22, $p23, $p24, $p25, $p26, $p27, $p28, $p29, $p30, $p31, $p32, $p33, $p34, $p35, $p36, $p37, $p38, $p39, $p40, $p41, $p42, $p43, $p44);
			if ($rspta) {
				$inserto = array(
					"estatus" => 1,
					"valor" => "Información Guardada"
				);
			} else {
				$inserto = array(
					"estatus" => 0,
					"valor" => "La información no se pudo Guardar"
				);
			}
		}
		echo json_encode($inserto);
		break;

	case 'traer_estado_modal':
		$respuesta = $panel_admin->estadoModalMonitorando($id_usuario);
		$data = array("estado" => $respuesta["estado"]);
		echo json_encode($data);
	break;

	case 'verificarFotoPerfil':
		require_once "../modelos/PanelAdmin.php";
		$panel_admin = new PanelAdmin();
		$id_usuario = $_SESSION['id_usuario'];
		$sin_foto = $panel_admin->usuarioSinFoto($id_usuario);
		echo json_encode(['mostrar' => $sin_foto]);
	break;

	case 'puntos':
		$total = $panel_admin->puntos(); // <-- esto ya es un número, no un array
		$formateado = number_format($total, 0, ',', '.');
		echo json_encode(['total_puntos' => $formateado]);
    break;

	
	case 'puntos_docente':
		$total = $panel_admin->puntos_docente(); 
		$formateado = number_format($total, 0, ',', '.');
		echo json_encode(['total_puntos' => $formateado]);
    break;

		case 'puntos_colaborador':
		$total = $panel_admin->puntos_colaborador(); 
		$formateado = number_format($total, 0, ',', '.');
		echo json_encode(['total_puntos' => $formateado]);
    break;

	case 'ingresosCampus':

		// Establece la semana que quieres consultar
		$fecha_base = date('Y-m-d'); // hoy
		$dia_semana = date('w', strtotime($fecha_base)); // 0 (domingo) a 6 (sábado)
		$dias_a_restar = ($dia_semana == 6) ? 0 : $dia_semana + 1;
		$fecha_sabado = date('Y-m-d', strtotime("-$dias_a_restar days", strtotime($fecha_base)));

		$data = array(
			'exito' => 0,
			'info' => '',
			'thumbs' => '',
			'plantilla' => '',
			'racha' => ''
		);

		$data['plantilla'] .= '
		<div class="col-10 bg-3 py-3">
			<span class="fs-20 text-white font-weight-bolder">Momento actual</span>
		</div>
		<div class="col-2 bg-3 text-center d-flex align-items-center">
			<span class="fs-24">&#128293;</span> 
		</div>
		
		<div class="col-12">

			<div class="row">
				<div class="col-12 d-flex justify-content-center">
					<div class="day-circle">Sa</div>
					<div class="day-circle">Do</div>
					<div class="day-circle">Lu</div>
					<div class="day-circle">Ma</div>
					<div class="day-circle">Mi</div>
					<div class="day-circle">Ju</div>
					<div class="day-circle">Vi</div>
				</div>
				<div class="col-12 d-flex justify-content-center">';

				$racha=0;
				for ($i = 0; $i < 7; $i++) {
					$fecha = date('Y-m-d', strtotime("+$i days", strtotime($fecha_sabado)));
					$hoy = date('Y-m-d');
				
					if ($fecha > $hoy) {
						// Día futuro
						$fondo = 'bg-light';
						$icono = '<span class="text-white">P</span>'; // o usa un ícono de reloj si prefieres
						// Ejemplo con ícono de reloj:
						// $icono = '<i class="fa-regular fa-clock text-white"></i>';
					} else {
						// Día actual o pasado
						$ingresos = $panel_admin->ingresoDia($id_usuario, $fecha);
						$ingreso = !empty($ingresos) ? 'Si' : 'No';
				
						if ($ingreso == 'Si') {
							$fondo = 'bg-7';
							$icono = '<i class="fa-solid fa-check text-success"></i>';
							$racha++;
						} else {
							$fondo = 'bg-danger';
							$icono = '<i class="fa-solid fa-xmark text-white"></i>';
						}
					}
				
					$data['plantilla'] .= '<div class="day-circle ' . $fondo . ' ">' . $icono . '</div>';
				}
				
			

				$data['plantilla'] .= '
			</div>

		</div>';

		if($racha==7){// si ingresa los 7 dias de la semana

			$punto_nombre="ingreso";
            $puntos_cantidad=5;
            $validarpuntos=$panel_admin->validarpuntos($punto_nombre,$fecha,$id_usuario);// para validar si el punto de perfil fue otorgado
            if ($validarpuntos) {
                // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
                
            } else {
                // No se obtuvo ningún resultado no hay punto otorgado
                $insertarpunto=$panel_admin->insertarPunto($id_usuario,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);

                $totalpuntos=$panel_admin->verpuntos($id_usuario);
                $puntoscredencial=$totalpuntos["puntos"];
                $sumapuntos=$puntos_cantidad+$puntoscredencial;
                $panel_admin->actulizarValor($id_usuario,$sumapuntos);

				$data["racha"]=$racha;

            }


		}
		

		echo json_encode($data);

	break;



}
