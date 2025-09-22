<?php
session_start();
require_once "../modelos/General.php";
$general = new General();

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
$rsptaperiodo = $general->periodoactual();
$periodo_actual = $_SESSION['periodo_actual'];
$id_usuario = $_SESSION['id_usuario'];
$r1 = isset($_POST["r1"]) ? limpiarCadena($_POST["r1"]) : "";
$r2 = isset($_POST["r2"]) ? limpiarCadena($_POST["r2"]) : "";
$r3 = isset($_POST["r3"]) ? limpiarCadena($_POST["r3"]) : "";
$r4 = isset($_POST["r4"]) ? limpiarCadena($_POST["r4"]) : "";
$r5 = isset($_POST["r5"]) ? limpiarCadena($_POST["r5"]) : "";
$r6 = isset($_POST["r6"]) ? limpiarCadena($_POST["r6"]) : "";
$fecha_actual = isset($_POST["fecha_actual"]) ? limpiarCadena($_POST["fecha_actual"]) : "";
$id_usuario_cv = isset($_POST["id_usuario_cv"]) ? limpiarCadena($_POST["id_usuario_cv"]) : "";


switch ($_GET["op"]) {
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
				$rspta1 = $general->listaringresos($fecha, "Funcionario");
				$rspta2 = $general->listaringresos($fecha, "Docente");
				$rspta3 = $general->listaringresos($fecha, "Estudiante");
				//error 
				$rspta4 = $general->listarfaltas($fecha);
				$rspta5 = $general->listarQuedate($fecha);
				$rspta6 = $general->listarContactanos($fecha);
				$rspta7 = $general->listarCaracterizados($fecha);
				$rspta8 = $general->listarActividades($fecha);
				$rspta9 = $general->ListarCv($fecha);
				$rspta10 = $general->listarPerfilAdminRango($fecha);
				$rspta11 = $general->perfilactualizadodocente($fecha);
				$rspta12 = $general->perfilactualizadoestudiante($fecha);
				$totalfuncionarios = is_array($rspta1) ? count($rspta1) : 0;
				$totaldocentes = is_array($rspta2) ? count($rspta2) : 0;
				$totalestudiantes = is_array($rspta3) ? count($rspta3) : 0;
				$totalfaltas = is_array($rspta4) ? count($rspta4) : 0;
				$totalquedate = is_array($rspta5) ? count($rspta5) : 0;
				$totalcontactanos = is_array($rspta6) ? count($rspta6) : 0;
				$totalcaracterizados = is_array($rspta7) ? count($rspta7) : 0;
				$totalactividades = is_array($rspta8) ? count($rspta8) : 0;
				$totalcv = is_array($rspta9) ? count($rspta9) : 0;
				$totalperfil = is_array($rspta10) ? count($rspta10) : 0;
				$totalperfildoc = is_array($rspta11) ? count($rspta11) : 0;
				$totalperfilest = is_array($rspta12) ? count($rspta12) : 0;

				break;
			case '2':
				$fecha_anterior = date("Y-m-d", strtotime($fecha . "- 1 days"));
				$rspta1 = $general->listaringresos($fecha_anterior, "Funcionario");
				$rspta2 = $general->listaringresos($fecha_anterior, "Docente");
				$rspta3 = $general->listaringresos($fecha_anterior, "Estudiante");
				$rspta4 = $general->listarfaltas($fecha_anterior);
				$rspta5 = $general->listarQuedate($fecha_anterior);
				$rspta6 = $general->listarContactanos($fecha_anterior);
				$rspta7 = $general->listarCaracterizados($fecha_anterior);
				$rspta8 = $general->listarActividades($fecha_anterior);
				$rspta9 = $general->ListarCv($fecha_anterior);
				$rspta10 = $general->listarPerfilAdminRango($fecha_anterior);
				$rspta11 = $general->perfilactualizadodocente($fecha_anterior);
				$rspta12 = $general->perfilactualizadoestudiante($fecha_anterior);
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
				$rspta1 = $general->listaringresossemana($semana, "Funcionario");
				$rspta2 = $general->listaringresossemana($semana, "Docente");
				$rspta3 = $general->listaringresossemana($semana, "Estudiante");
				$rspta4 = $general->listarFaltasSemana($semana);
				$rspta5 = $general->listarQuedateSemana($semana);
				$rspta6 = $general->listarContactanosSemana($semana);
				$rspta7 = $general->listarCaracterizadosSemana($semana);
				$rspta8 = $general->listarActividadesSemana($semana);


				$rspta9 = $general->ListarCvSemana($semana);
				$rspta10 = $general->listarPerfilAdminRango($semana);
				$rspta11 = $general->perfilactualizadodocente($semana);
				$rspta12 = $general->perfilactualizadoestudiante($semana);

				// Si la función devuelve null o no es un array, asignar 0
				$totalfuncionarios = is_array($rspta1) ? count($rspta1) : 0;
				$totaldocentes = is_array($rspta2) ? count($rspta2) : 0;
				$totalestudiantes = is_array($rspta3) ? count($rspta3) : 0;
				$totalfaltas = is_array($rspta4) ? count($rspta4) : 0;
				$totalquedate = is_array($rspta5) ? count($rspta5) : 0;
				$totalcontactanos = is_array($rspta6) ? count($rspta6) : 0;
				$totalcaracterizados = is_array($rspta7) ? count($rspta7) : 0;
				$totalactividades = is_array($rspta8) ? count($rspta8) : 0;
				$totalcv = is_array($rspta9) ? count($rspta9) : 0;
				$totalperfil = is_array($rspta10) ? count($rspta10) : 0;
				$totalperfildoc = is_array($rspta11) ? count($rspta11) : 0;
				$totalperfilest = is_array($rspta12) ? count($rspta12) : 0;

				break;

			case '4':
				$rspta1 = $general->listaringresossemana($mes_actual, "Funcionario");
				$rspta2 = $general->listaringresossemana($mes_actual, "Docente");
				$rspta3 = $general->listaringresossemana($mes_actual, "Estudiante");
				$rspta4 = $general->listarFaltasSemana($mes_actual);
				$rspta5 = $general->listarQuedateSemana($mes_actual);
				$rspta6 = $general->listarContactanosSemana($mes_actual);
				$rspta7 = $general->listarCaracterizadosSemana($mes_actual);
				$rspta8 = $general->listarActividadesSemana($mes_actual);
				$rspta9 = $general->ListarCvSemana($mes_actual);
				$rspta10 = $general->listarPerfilAdminRango($mes_actual);
				$rspta11 = $general->perfilactualizadodocente($mes_actual);
				$rspta12 = $general->perfilactualizadoestudiante($mes_actual);
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
				$rspta1 = $general->listaringresosrango($fecha_inicial, $fecha_final, "Funcionario");
				$rspta2 = $general->listaringresosrangodocente($fecha_inicial, $fecha_final, "Docente");
				$rspta3 = $general->listaringresosrango($fecha_inicial, $fecha_final, "Estudiante");
				// $rspta3 = $general->listaringresosrangoestudiante($fecha_inicial,$fecha_final);
				$rspta4 = $general->listarFaltasRango($fecha_inicial, $fecha_final);
				$rspta5 = $general->listarQuedateRango($fecha_inicial, $fecha_final);
				$rspta6 = $general->listarContactanosRango($fecha_inicial, $fecha_final);
				$rspta7 = $general->listarCaracterizadosRango($fecha_inicial, $fecha_final);
				$rspta8 = $general->listarActividadesRango($fecha_inicial, $fecha_final);
				$rspta9 = $general->listarCvRango5($fecha_inicial, $fecha_final);
				$rspta10 = $general->listarPerfilAdminRango($fecha_inicial, $fecha_final);
				$rspta11 = $general->listarPerfilDocRango($fecha_inicial, $fecha_final);
				$rspta12 = $general->listarPerfilEstRango($fecha_inicial, $fecha_final);
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


				$caracterizacion = $general->caracterizacion($fecha);

				for ($n = 0; $n < count($caracterizacion); $n++) {

					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $general->fechaesp($fecha);
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


				$caracterizacion = $general->caracterizacion($fecha_anterior);

				for ($n = 0; $n < count($caracterizacion); $n++) {

					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $general->fechaesp($fecha);
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


				$caracterizacion = $general->caracterizacionsemana($semana);

				for ($n = 0; $n < count($caracterizacion); $n++) {

					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $general->fechaesp($fecha);
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


				$caracterizacion = $general->caracterizacionsemana($mes_actual);

				for ($n = 0; $n < count($caracterizacion); $n++) {

					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $general->fechaesp($fecha);
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


				$caracterizacion = $general->listarCaracterizadosPorRango($fecha_inicial, $fecha_final);

				for ($n = 0; $n < count($caracterizacion); $n++) {

					// datos estudiante
					$id_credencial = $caracterizacion[$n]["id_credencial"];
					$jornada = $caracterizacion[$n]["jornada"];
					$credencial_nombre = $caracterizacion[$n]["credencial_nombre"];
					$credencial_nombre_2 = $caracterizacion[$n]["credencial_nombre_2"];
					$credencial_apellido = $caracterizacion[$n]["credencial_apellido"];
					$fecha = $caracterizacion[$n]["fecha"];
					$fecha_caracterizacion = $general->fechaesp($fecha);
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
		$rspta1 = $general->listaringresosrango($fecha_inicial, $fecha_final, "Funcionario");
		$rspta2 = $general->listaringresosrangodocente($fecha_inicial, $fecha_final, "Docente");
		$rspta3 = $general->listaringresosrangoestudiante($fecha_inicial, $fecha_final);
		// $rspta3=$general->listaringresosrango($fecha_inicial,$fecha_final,"Estudiante");
		$rspta4 = $general->listarFaltasRango($fecha_inicial, $fecha_final);
		$rspta5 = $general->listarQuedateRango($fecha_inicial, $fecha_final);
		$rspta6 = $general->listarContactanosRango($fecha_inicial, $fecha_final);
		$rspta7 = $general->listarCaracterizadosRango($fecha_inicial, $fecha_final);
		$rspta8 = $general->listarActividadesRango($fecha_inicial, $fecha_final);
		$rspta9 = $general->listarCvRango5($fecha_inicial, $fecha_final);
		$rspta10 = $general->listarPerfilAdminRango($fecha_inicial, $fecha_final);
		$rspta11 = $general->listarPerfilDocRango($fecha_inicial, $fecha_final);
		$rspta12 = $general->listarPerfilEstRango($fecha_inicial, $fecha_final);
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
	case 'actividadesnuevas':
		$actividadesnuevas = $_GET["actividadesnuevas"];
		$data = array();
		$data[0] = "";
		switch ($actividadesnuevas) {
			case 1:
				$data[0] = "";
				$data[0] .= '
					<table id="mostraractividades" class="table table-responsive" style="width:100%">
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
				$caracterizacion = $general->listaractividades($fecha);
				for ($h = 0; $h < count($caracterizacion); $h++) {
					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];

					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];


					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $general->fechaesp($fecha_actividad);
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
				$caracterizacion = $general->listaractividades($fecha_anterior);
				for ($h = 0; $h < count($caracterizacion); $h++) {

					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];

					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];

					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $general->fechaesp($fecha_actividad);
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
				$caracterizacion = $general->listarActividadesSemana($semana);
				for ($h = 0; $h < count($caracterizacion); $h++) {
					// print_r($caracterizacion);
					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];

					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];
					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $general->fechaesp($fecha_actividad);
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
				$caracterizacion = $general->listarActividadesSemana($mes_actual);
				for ($h = 0; $h < count($caracterizacion); $h++) {
					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];

					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];
					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $general->fechaesp($fecha_actividad);
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
				// $caracterizacion = $general->listaractividades($id_usuario, $fecha_inicial, $fecha_final);
				$caracterizacion = $general->listarActividadesRango($fecha_inicial, $fecha_final);

				for ($h = 0; $h < count($caracterizacion); $h++) {
					$usuario_identificacion = $caracterizacion[$h]["usuario_identificacion"];

					$nombre_docente = $caracterizacion[$h]["usuario_nombre"] . " " . $caracterizacion[$h]["usuario_nombre_2"] . " " . $caracterizacion[$h]["usuario_apellido"] . " " . $caracterizacion[$h]["usuario_apellido_2"];

					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];
					$actividad_fecha = $general->fechaesp($fecha_actividad);
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

				$listarhojasdevida = $general->hojadevida($fecha);

				for ($n = 0; $n < count($listarhojasdevida); $n++) {

					$nombre_area = $listarhojasdevida[$n]["nombre_area"];
					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$usuario_nombre_apellido = $listarhojasdevida[$n]["usuario_nombre"] . " " . $listarhojasdevida[$n]["usuario_apellido"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $general->fechaesp($fecha);
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

				$listarhojasdevida = $general->hojadevida($fecha_anterior);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {


					$nombre_area = $listarhojasdevida[$n]["nombre_area"];

					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$usuario_nombre_apellido = $listarhojasdevida[$n]["usuario_nombre"] . " " . $listarhojasdevida[$n]["usuario_apellido"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $general->fechaesp($fecha);

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

				$listarhojasdevida = $general->hojadevidasemanaymes($semana_2);

				for ($n = 0; $n < count($listarhojasdevida); $n++) {

					$nombre_area = $listarhojasdevida[$n]["nombre_area"];

					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$usuario_nombre_apellido = $listarhojasdevida[$n]["usuario_nombre"] . " " . $listarhojasdevida[$n]["usuario_apellido"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $general->fechaesp($fecha);

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

				$listarhojasdevida = $general->hojadevidasemanaymes($mes_actual);

				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$nombre_area = $listarhojasdevida[$n]["nombre_area"];

					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$usuario_nombre_apellido = $listarhojasdevida[$n]["usuario_nombre"] . " " . $listarhojasdevida[$n]["usuario_apellido"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $general->fechaesp($fecha);

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
				$listarhojasdevida = $general->listarPorCvRango($fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {

					$usuario_nombre = $listarhojasdevida[$n]["usuario_nombre"];
					$usuario_apellido = $listarhojasdevida[$n]["usuario_apellido"];
					$usuario_identificacion = $listarhojasdevida[$n]["usuario_identificacion"];
					$nombre_area = $listarhojasdevida[$n]["nombre_area"];
					$create_dt = $listarhojasdevida[$n]["create_dt"];
					$separar_fecha = (explode(" ", $create_dt));
					$fecha = $separar_fecha[0];
					$fecha = $general->fechaesp($fecha);
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
				$totalfuncionarios = $general->mostrarfuncionarios($fecha);
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
							<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$totalfuncionarios = $general->mostrarfuncionarios($fecha_anterior);
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
							<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$totalfuncionarios = $general->mostrarfuncionarios($semana);
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
							<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$totalfuncionarios = $general->mostrarfuncionarios($mes_actual);
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
							<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$funcionarioporrango = $general->listaringresosrangofuncionario($fecha_inicial, $fecha_final);
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
								<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$totaldocente = $general->mostrardocente($fecha);
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
							<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$totaldocente = $general->mostrardocente($fecha_anterior);
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
							<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$totaldocente = $general->mostrardocente($semana);
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
								<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$totaldocente = $general->mostrardocente($mes_actual);

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
								<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$funcionarioporrango = $general->listaringresosrangodocente($fecha_inicial, $fecha_final, "Docente");

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
								<td>' . $general->fechaespcalendario($fecha) . '</td> 
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
				$mostrar_estudiante = $general->mostrarestudiantes($fecha);
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
				$mostrar_estudiante = $general->mostrarestudiantes($fecha_anterior);
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
				$mostrar_estudiante = $general->mostrarestudiantes($semana);
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
				$mostrar_estudiante = $general->mostrarestudiantes($mes_actual);
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
				$mostrar_estudiante = $general->listaringresosrangoestudiante($fecha_inicial, $fecha_final);
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
	case 'perfilesactualizadosadministradores':

		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];

		$perfilactualizadoadministrativo = $_GET["perfilactualizadoadministrativo"];
		$data = array();
		$data[0] = "";

		switch ($perfilactualizadoadministrativo) {

			case 1:

				$data["0"] = "";
				$administrador = $general->listarPerfilAdminRango($fecha);

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
					$fecha_actualizacion = $general->fechaesp($fecha_actualizacion);
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
				$administrador = $general->listarPerfilAdminRango($fecha_anterior);

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
					$fecha_actualizacion = $general->fechaesp($fecha_actualizacion);
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
				$administrador = $general->listarPerfilAdminRango($semana);

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
					$fecha_actualizacion = $general->fechaesp($fecha_actualizacion);
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
				$administrador = $general->listarPerfilAdminRango($mes_actual);

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
					$fecha_actualizacion = $general->fechaesp($fecha_actualizacion);
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
				$administrador = $general->listarPerfilAdminRango($fecha_inicial, $fecha_final);

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
					$fecha_actualizacion = $general->fechaesp($fecha_actualizacion);
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
	case 'perfilesactualizadosdocente':
		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];

		$perfilactualizadodocente = $_GET["perfilactualizadodocente"];
		$data = array();
		$data[0] = "";

		switch ($perfilactualizadodocente) {

			case 1:

				$data["0"] = "";
				$docente = $general->perfilactualizadodocente($fecha);

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
					$fecha_docente = $general->fechaesp($fecha_docente);
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

				$docente = $general->perfilactualizadodocente($fecha_anterior);

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
					$fecha_docente = $general->fechaesp($fecha_docente);
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

				$docente = $general->perfilactualizadodocente($semana);

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
					$fecha_docente = $general->fechaesp($fecha_docente);
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

				$docente = $general->perfilactualizadodocente($mes_actual);

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
					$fecha_docente = $general->fechaesp($fecha_docente);
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
				$docente = $general->listarPerfilDocRango($fecha_inicial, $fecha_final);

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
					$fecha_docente = $general->fechaesp($fecha_docente);
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
	case 'perfilesactualizadosestudiante':
		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];

		$perfilactualizadoestudiante = $_GET["perfilactualizadoestudiante"];
		$data = array();
		$data[0] = "";

		switch ($perfilactualizadoestudiante) {

			case 1:

				$data["0"] = "";
				$estudiante = $general->perfilactualizadoestudiante($fecha);

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
					$fecha_estudiante = $general->fechaesp($fecha_estudiante);
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
				$estudiante = $general->perfilactualizadoestudiante($fecha_anterior);

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
					$fecha_estudiante = $general->fechaesp($fecha_estudiante);
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
				$estudiante = $general->perfilactualizadoestudiante($semana);

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
					$fecha_estudiante = $general->fechaesp($fecha_estudiante);
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
				$estudiante = $general->perfilactualizadoestudiante($mes_actual);

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
					$fecha_estudiante = $general->fechaesp($fecha_estudiante);
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
				$estudiante = $general->listaringresosrangoestudiantes($fecha_inicial, $fecha_final);

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
					$fecha_estudiante = $general->fechaesp($fecha_estudiante);
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

				$mostrar_faltas = $general->mostrarfaltas($fecha);

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
				$mostrar_faltas = $general->mostrarfaltasayer($fecha_anterior);
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

				$mostrar_faltas = $general->mostrarfaltas($semana);

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
				$mostrar_faltas = $general->mostrarfaltas($mes_actual);

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

				$mostrar_faltas = $general->listarFaltasPorRango5($fecha_inicial, $fecha_final);

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

				$casoquedate = $general->casoquedate($fecha);

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

				$casoquedate = $general->casoquedate($fecha_anterior);

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

				$casoquedate = $general->casoquedateultimasemana($semana);

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

				$casoquedate = $general->casoquedateultimasemana($mes_actual);

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

				$casoquedate = $general->listarQuedatePorRango($fecha_inicial, $fecha_final);

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

				$contactanos = $general->contactanos($fecha);

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

					$solicitud_fecha = $general->fechaesp($fecha_solicitud);

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

				$contactanos = $general->contactanos($fecha_anterior);

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
					$solicitud_fecha = $general->fechaesp($fecha_solicitud);


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

				$contactanos = $general->contactanos($semana);

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
					$solicitud_fecha = $general->fechaesp($fecha_solicitud);

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

				$contactanos = $general->contactanos($mes_actual);

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
					$solicitud_fecha = $general->fechaesp($fecha_solicitud);

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

				$contactanos = $general->listarContactanosPorRango5($fecha_inicial, $fecha_final);

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
					$solicitud_fecha = $general->fechaesp($fecha_solicitud);

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
	case 'listarEscuelas':
		$rpsta = $general->listarEscuelas();
		echo json_encode($rpsta);
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
		$traerhorario = $general->ListarClasesEscuela($days[$num_day], $escuela);
		$impresion .= '[';
		for ($i = 0; $i < count($traerhorario); $i++) {
			$materia = $traerhorario[$i]["nombre"];
			$salon = $traerhorario[$i]["salon"];
			$fecha_inicial = $traerhorario[$i]["hora"];
			$fecha_final = $traerhorario[$i]["hasta"];
			$jornada = $traerhorario[$i]["jornada"];
			$color = $traerhorario[$i]["color"];

			$id_programa = $traerhorario[$i]["id_programa"];
			$traer_nombre_programa = $general->nombrePrograma($id_programa);
			$nombre_programa = $traer_nombre_programa["nombre"];

			$id_docente = $traerhorario[$i]["id_docente"];
			$traer_nombre_docente = $general->nombreDocente($id_docente);
			@$nombre_docente = $traer_nombre_docente["usuario_nombre"] . ' ' . $traer_nombre_docente["usuario_nombre_2"] . ' ' . $traer_nombre_docente["usuario_apellido"] . ' ' . $traer_nombre_docente["usuario_apellido_2"];


			$impresion .= '{"title":"' . $materia . ' - ' . $salon . ' - ' . $jornada . ' - ' . @$nombre_docente . ' " , "daysOfWeek": "' . $num_day . '", "start":"' . $fecha_inicial . '","end":"' . $fecha_final . '", "color": "' . $color . '"}';
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
		$traerhorario = $general->listarClasesDelDia($days[$num_day]);
		// $traerhorario = $general->listarClasesDelDia('Lunes');
		$impresion .= '[';
		for ($i = 0; $i < count($traerhorario); $i++) {
			$materia = $traerhorario[$i]["nombre"];
			$salon = $traerhorario[$i]["salon"];
			$fecha_inicial = $traerhorario[$i]["hora"];
			$fecha_final = $traerhorario[$i]["hasta"];
			$jornada = $traerhorario[$i]["jornada"];
			$id_programa = $traerhorario[$i]["id_programa"];
			$traer_nombre_programa = $general->nombrePrograma($id_programa);
			$nombre_programa = $traer_nombre_programa["nombre"];

			$id_docente = $traerhorario[$i]["id_docente"];
			$traer_nombre_docente = $general->nombreDocente($id_docente);
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
}
