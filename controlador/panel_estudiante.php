<?php
require_once "../modelos/Panelestudiante.php";

$panelestudiante = new Panelestudiante();
session_start();
$fecha_actual_eventos = date("m");

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$hora_actual_sistema = date('H:i');
$hora_actual = date("g:i a", strtotime($hora_actual_sistema));
$mes_actual = date('Y-m') . "-00";
$fecha_anterior = date("Y-m-d", strtotime($fecha . "- 1 days"));
$semana = date("Y-m-d", strtotime($fecha . "- 1 week"));
$diaentreSemana = date("w");


$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$celular = isset($_POST["celular"]) ? limpiarCadena($_POST["celular"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$barrio = isset($_POST["barrio"]) ? limpiarCadena($_POST["barrio"]) : "";
$estrato = isset($_POST["estrato"]) ? limpiarCadena($_POST["estrato"]) : "";


$jornada = isset($_POST["jornada"]) ? limpiarCadena($_POST["jornada"]) : "";
$periodo = isset($_POST["periodo"]) ? limpiarCadena($_POST["periodo"]) : "";
$periodo = isset($_POST["periodo"]) ? limpiarCadena($_POST["periodo"]) : "";
$semestre = isset($_POST["semestre"]) ? limpiarCadena($_POST["semestre"]) : "";
$programa = isset($_POST["programa"]) ? limpiarCadena($_POST["programa"]) : "";


$programa = isset($_POST["programa"]) ? limpiarCadena($_POST["programa"]) : "";
// $trae_id_docente_grupo = isset($_POST["trae_id_docente_grupo"]) ? limpiarCadena($_POST["trae_id_docente_grupo"]) : "";

$latitud = isset($_POST["latitud"]) ? limpiarCadena($_POST["latitud"]) : "";
$longitud = isset($_POST["longitud"]) ? limpiarCadena($_POST["longitud"]) : "";




/* ************************** encuesta *********************** */
$pre1 = isset($_POST["pre1"]) ? limpiarCadena($_POST["pre1"]) : "";
$pre2 = isset($_POST["pre2"]) ? limpiarCadena($_POST["pre2"]) : "";
$pre3 = isset($_POST["pre3"]) ? limpiarCadena($_POST["pre3"]) : "";
/* ************************** encuesta *********************** */

$rsptaperiodo = $panelestudiante->periodoactual();
$periodo_actual = $_SESSION['periodo_actual'];
$id_usuario = $_SESSION['id_usuario'];
$s_identificacion = $_SESSION['credencial_identificacion'];

switch ($_GET['op']) {

	case 'menu_titulaciones':
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$data["1"] = ""; //contiene la cantidad de programas matriculados
		$data["2"] = ""; //muestra los progrmas matriculados para el menu del estudiante

		//almacena la cantidad de materias que el estudiante tiene matriculadas
		$matriculadas = 0;
		//acumula las materias que ya hayan sido evaluadas por el estudiante
		$evaluadas = 0;
		//trae los programas activos de el estudiante en session
		$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
		//ciclo por cada programa que tenga activo
		for ($i = 0; $i < count($consulta_programas); $i++) {
			//almacenamos el id
			$id_estudiante = $consulta_programas[$i]['id_estudiante'];
			//almacenamos el ciclo
			$ciclo = $consulta_programas[$i]['ciclo'];
			//almacenamos el grupo
			$grupo = $consulta_programas[$i]['grupo'];
			//consultamos las materia del estudiante activas por cada curso
			$consulta_materias = $panelestudiante->consulta_materias($id_estudiante, $ciclo); // trae las materias matriculadas
			//ciclo por las materias matriculadas
			for ($j = 0; $j < count($consulta_materias); $j++) {
				//almacenamos el nombre de la materia
				$nombre_materia = $consulta_materias[$j]['nombre_materia'];
				$jornada = $consulta_materias[$j]['jornada'];
				//almacenamos el semestre
				$semestre = $consulta_materias[$j]['semestre'];
				//almacenamos el programa
				$programa = $consulta_materias[$j]['programa'];
				//consultamos el docente grupo que tiene asignada esa materia
				$consulta_grupo = $panelestudiante->consulta_grupo($nombre_materia, $jornada, $semestre, $programa, $grupo); // trae los datos del docente grupo
				//almacenamos el id del docente
				@$id_docente = $consulta_grupo["id_docente"];
				//almacenamos el id de la tabla docente_grupos
				@$id_docente_grupo = $consulta_grupo["id_docente_grupo"];
				//almacenamos el estado del docente_grupo
				@$estado = $consulta_grupo["estado"];
				//si el estado es uno quiere decir que la materia esta matriculada
				if ($estado == 1) {
					//sumamos a la cuenta de matriculadas
					$matriculadas++;
					//consultamos si el estudiante ya evaluo a ese docente por la materia especifica
					$consulta_heteroevaluacion = $panelestudiante->consulta_heteroevaluacion($id_estudiante, $id_docente, $id_docente_grupo); //trae las materias evaluadas 
					//si ya lo evaluo, sumamos al contador de materias evaluadas
					if ($consulta_heteroevaluacion) { //si evaluo asigantura que sume
						$evaluadas++;
						// $data["0"] .= "si";
					}
				}
				// $data["0"] .= "\n";
			}
		}
		//LO ACTIVO CUANDO ACTIVO LA EVALUACIÓN DOCENTE, para activar la evaluación docente toca cambiar el estado a 0 de la tabla docente grupos

		//si la cantidad de materias NO son igual a la cantidad de evaluadas entonces tenemos que listar las que tiene que evaluar
		$estado_evaluacion = $panelestudiante->verificarEstadoEvaluacion()["estado"];
		//LO ACTIVO CUADO NO TENEMOS EVALUACIÓN DOCENTE
		$dato = $panelestudiante->listartitulaciones($_SESSION['id_usuario']);
		if ($estado_evaluacion == 1) {
			if ($matriculadas == $evaluadas) {
				$data["0"] .= 1; // quiere decir que esta todo evaluado
				$data["3"] = $estado_evaluacion;
				$_SESSION['status_titulaciones'] = 0;
			} else {
				$data["0"] .= 2; // falta por evaluar
				$_SESSION['status_titulaciones'] = 1;
			}
		}
		$data['1'] = count($dato); // tiene el numero de programas activos=
		for ($k = 0; $k < count($dato); $k++) { // muestra el programa en el ménu
			$nombredelprogramaterminal = $panelestudiante->nombredelprogramaterminal($dato[$k]["id_programa_ac"]); // trae el programa terminal 
			$data["2"] .=
				'<li class="nav-item">
					<a href="estudiante.php?id=' . $dato[$k]["id_estudiante"] . '&ciclo=' . $dato[$k]["ciclo"] . '&id_programa=' . $dato[$k]["id_programa_ac"] . '&grupo=' . $dato[$k]["grupo"] . '" class="nav-link" title="' . $nombredelprogramaterminal["original"] . '">
						<span>' . $nombredelprogramaterminal["original"] . '</span>
					</a>
				</li>';
		}
		$results = array($data);
		echo json_encode($results);
	break;

	case 'jornada_PAT':
		//print_r($_SESSION);
		$credencial =  $_SESSION["id_usuario"];

		$consulta = $panelestudiante->consulta_programas($credencial);
		$data = array();
		for ($i = 0; $i < count($consulta); $i++) {
			$jornada_e = $consulta[$i]["jornada_e"];
			$fo_programa = $consulta[$i]["fo_programa"];

			$consulta_PAT = $panelestudiante->jornada_PAT($jornada_e, $fo_programa);
			$data[] = $consulta_PAT["url"];
		}
		echo json_encode($data);
		//print_r($consulta);
	break;

	case 'alertacalendario':

		$fecha_actual = isset($_POST["fecha_actual"]) ? limpiarCadena($_POST["fecha_actual"]) : "";
		$alerta = $panelestudiante->alertacalendario();
		$alertacalendario = $alerta;
		$data[0] = '';

		for ($r = 0; $r < count($alertacalendario); $r++) {
			$nombre = utf8_encode($alertacalendario[$r]['actividad']);
			$data[0] .= '
				<div class="form-group col-xl-12 col-lg-6 col-md-12 col-sm-12">
				<b>' . $nombre . '<br> </b>	
				<br><b> Fecha de Inicio :</b> ' . $panelestudiante->fechaesp($alertacalendario[$r]["fecha_inicio"]) .

				'<br><b>Fecha de Final : </b>' . $panelestudiante->fechaesp($alertacalendario[$r]["fecha_final"]) . '<hr>
				</div>';
		};

		echo utf8_decode($data[0]);

	break;

	case 'listardatos':
		$rango = $_GET["rango"];

		$data = array();
		$data["totalingresos"] = "";
		$data["totalfaltas"] = "";
		$data["totalnotareportada"] = "";
		$data["totalactividades"] = "";
		$data["totalclasededia"] = "";


		switch ($rango) {
			case '1':

				$rspta1 = $panelestudiante->listaringresos($id_usuario, $fecha);

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				$rspta2 = 0;
				for ($i = 0; $i < count($consulta_programas); $i++) {

					$id_estudiante = $consulta_programas[$i]['id_estudiante'];


					$rspta2 = $panelestudiante->listarfaltas($id_estudiante, $fecha);
				}




				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$i]['id_estudiante'];
					//almacenamos el ciclo
					$ciclo = $consulta_programas[$i]['ciclo'];
					//almacenamos el grupo
					$grupo = $consulta_programas[$i]['grupo'];
					//consultamos las materia del estudiante activas por cada curso
					$rspta3 = $panelestudiante->consulta_materias($id_estudiante, $ciclo); // trae las materias matriculadas
				}

				//trae los programas activos de el estudiante en session
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];

					//consultamos las materia del estudiante activas por cada curso
					$consulta_materias = $panelestudiante->consulta_materiasparanotas($id_estudiante, $ciclo);

					$nombre_materia_ciclo = 0;

					for ($e = 0; $e < count($consulta_materias); $e++) {

						//almacenamos la jornada
						$jornada = $consulta_materias[$e]['jornada'];
						//almacenamos el semestre
						$semestre = $consulta_materias[$e]['semestre'];
						//almacenamos el programa
						$programa = $consulta_materias[$e]['programa'];
						//almacenamos el periodo
						$periodo = $consulta_materias[$e]['periodo'];
						//traemos el nombre de la materia	
						$nombre_materia = $consulta_materias[$e]['nombre_materia'];

						$nocalificado = 0;
						// $nombre_materia_ciclo = $e;
						// traemos el corte 1
						$c1 = $consulta_materias[$e]['c1'];
						// traemos el corte 2
						$c2 = $consulta_materias[$e]['c2'];
						// traemos el corte 3
						$c3 = $consulta_materias[$e]['c3'];

						if (($c1 > $nocalificado) || ($c2 > $nocalificado) || ($c3 > $nocalificado)) {

							$nombre_materia_ciclo++;
						}
					}
				}


				// consultamos los programas que tiene el estudiante
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					//almacenamos el id del estudiante
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];

					//consultamos las materia del estudiante activas por cada curso
					$traerhorario = $panelestudiante->TraerHorariocalendarioactividadespea($id_programa, $jornada, $semestre, $grupo);

					for ($i = 0; $i < count($traerhorario); $i++) {
						$id_materia = $traerhorario[$i]["id_materia"];
						// trae las materias que tiene asignadas el estudiante
						$datosmateria = $panelestudiante->BuscarDatosAsignatura($id_materia);
						// trae el id del docente grupo
						$id_docente_grupo = $panelestudiante->TraerIddocentegrupo($id_materia);

						//traemos el id docente grupo para saber que docente tiene el estudiante
						$trae_id_docente_grupo = $id_docente_grupo["id_docente_grupo"];

						$actividades_total = $panelestudiante->listaractividadespordocente($fecha, $trae_id_docente_grupo);
					}
				}

				$totalingresos = count($rspta1);

				@$totalactividades = count($actividades_total);
				$totalfaltas = count($rspta2);
				$totalnotareportada = $nombre_materia_ciclo;
				// $totalclasededia=count($nombre);

				break;

			case '2':

				// $fecha_anterior=date("Y-m-d",strtotime($fecha."- 1 days"));


				$rspta1 = $panelestudiante->listaringresos($id_usuario, $fecha_anterior);
				// $rspta2 = $panelestudiante->listarfaltas($id_usuario, $fecha_anterior);

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {

					$id_estudiante = $consulta_programas[$i]['id_estudiante'];


					$rspta2 = $panelestudiante->listarfaltas($id_estudiante, $fecha_anterior);
				}


				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);

				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];

					//consultamos las materia del estudiante activas por cada curso
					$consulta_materias = $panelestudiante->consulta_materiasparanotas($id_estudiante, $ciclo);

					$nombre_materia_ciclo = 0;
					for ($e = 0; $e < count($consulta_materias); $e++) {

						//almacenamos la jornada
						$jornada = $consulta_materias[$e]['jornada'];
						//almacenamos el semestre
						$semestre = $consulta_materias[$e]['semestre'];
						//almacenamos el programa
						$programa = $consulta_materias[$e]['programa'];
						//almacenamos el periodo
						$periodo = $consulta_materias[$e]['periodo'];
						//traemos el nombre de la materia	

						$nocalificado = 0;
						// traemos el corte 1
						$c1 = $consulta_materias[$e]['c1'];
						// traemos el corte 2
						$c2 = $consulta_materias[$e]['c2'];
						// traemos el corte 3
						$c3 = $consulta_materias[$e]['c3'];

						if (($c1 > $nocalificado) || ($c2 > $nocalificado) || ($c3 > $nocalificado)) {
							$nombre_materia_ciclo++;
						}
					}
				}






				// $rspta4 = $panelestudiante->listaractividades($fecha_anterior);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {
					//almacenamos el id
					$id_estudiante = $consulta_programas[$i]['id_estudiante'];
					//almacenamos el ciclo
					$ciclo = $consulta_programas[$i]['ciclo'];
					//almacenamos el grupo
					$grupo = $consulta_programas[$i]['grupo'];
					//consultamos las materia del estudiante activas por cada curso
					$rspta3 = $panelestudiante->consulta_materias($id_estudiante, $ciclo); // trae las materias matriculadas
				}


				//trae los programas activos de el estudiante en session
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];

					//consultamos las materia del estudiante activas por cada curso
					$consulta_materias = $panelestudiante->consulta_materiasparanotas($id_estudiante, $ciclo);


					$nombre_materia_ciclo = 0;

					for ($e = 0; $e < count($consulta_materias); $e++) {

						//almacenamos la jornada
						$jornada = $consulta_materias[$e]['jornada'];
						//almacenamos el semestre
						$semestre = $consulta_materias[$e]['semestre'];
						//almacenamos el programa
						$programa = $consulta_materias[$e]['programa'];
						//almacenamos el periodo
						$periodo = $consulta_materias[$e]['periodo'];
						//traemos el nombre de la materia	
						$nombre_materia = $consulta_materias[$e]['nombre_materia'];

						$nocalificado = 0;
						// $nombre_materia_ciclo = $e;
						// traemos el corte 1
						$c1 = $consulta_materias[$e]['c1'];
						// traemos el corte 2
						$c2 = $consulta_materias[$e]['c2'];
						// traemos el corte 3
						$c3 = $consulta_materias[$e]['c3'];

						if (($c1 > $nocalificado) || ($c2 > $nocalificado) || ($c3 > $nocalificado)) {

							$nombre_materia_ciclo++;
						}
					}
				}


				// consultamos los programas que tiene el estudiante
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					//almacenamos el id del estudiante
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];

					//consultamos las materia del estudiante activas por cada curso
					$traerhorario = $panelestudiante->TraerHorariocalendarioactividadespea($id_programa, $jornada, $semestre, $grupo);

					for ($i = 0; $i < count($traerhorario); $i++) {
						$id_materia = $traerhorario[$i]["id_materia"];
						// trae las materias que tiene asignadas el estudiante
						$datosmateria = $panelestudiante->BuscarDatosAsignatura($id_materia);
						// trae el id del docente grupo
						$id_docente_grupo = $panelestudiante->TraerIddocentegrupo($id_materia);

						//traemos el id docente grupo para saber que docente tiene el estudiante
						$trae_id_docente_grupo = $id_docente_grupo["id_docente_grupo"];

						$actividades_total = $panelestudiante->listaractividadespordocente($fecha_anterior, $trae_id_docente_grupo);
					}
				}


				$totalingresos = count($rspta1);
				$totalfaltas = count($rspta2);
				$totalnotareportada = $nombre_materia_ciclo;
				$totalactividades = count($actividades_total);

				break;

			case '3':
				// $semana=date("Y-m-d",strtotime($fecha."- 1 week")); 

				$rspta1 = $panelestudiante->listaringresossemana($id_usuario, $semana);
				// $rspta2 = $panelestudiante->listarfaltassemana($id_usuario, $semana);

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {

					$id_estudiante = $consulta_programas[$i]['id_estudiante'];


					$rspta2 = $panelestudiante->mostrarfaltasemana($id_estudiante, $semana);
				}

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				// $rspta4 = $panelestudiante->listaractividadessemana($semana);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {
					//almacenamos el id
					$id_estudiante = $consulta_programas[$i]['id_estudiante'];
					//almacenamos el ciclo
					$ciclo = $consulta_programas[$i]['ciclo'];
					//almacenamos el grupo
					$grupo = $consulta_programas[$i]['grupo'];
					//consultamos las materia del estudiante activas por cada curso
					$rspta3 = $panelestudiante->consulta_materias($id_estudiante, $ciclo); // trae las materias matriculadas
				}

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					// print_r($consulta_programas);
					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];
				}

				//trae los programas activos de el estudiante en session
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];

					//consultamos las materia del estudiante activas por cada curso
					$consulta_materias = $panelestudiante->consulta_materiasparanotas($id_estudiante, $ciclo);

					// $vernombreestudiante = $panelestudiante->vernombreestudiante($_SESSION['id_usuario']);
					// $nombre_estudiante = $vernombreestudiante[$j]["credencial_nombre"] . " " . $vernombreestudiante[$j]["credencial_nombre_2"] . " " . $vernombreestudiante[$j]["credencial_apellido"] . " " . $vernombreestudiante[$j]["credencial_apellido_2"];
					// $correo_electronico = $vernombreestudiante[$j]['credencial_login'];

					$nombre_materia_ciclo = 0;

					for ($e = 0; $e < count($consulta_materias); $e++) {

						//almacenamos la jornada
						$jornada = $consulta_materias[$e]['jornada'];
						//almacenamos el semestre
						$semestre = $consulta_materias[$e]['semestre'];
						//almacenamos el programa
						$programa = $consulta_materias[$e]['programa'];
						//almacenamos el periodo
						$periodo = $consulta_materias[$e]['periodo'];
						//traemos el nombre de la materia	
						$nombre_materia = $consulta_materias[$e]['nombre_materia'];

						$nocalificado = 0;
						// $nombre_materia_ciclo = $e;
						// traemos el corte 1
						$c1 = $consulta_materias[$e]['c1'];
						// traemos el corte 2
						$c2 = $consulta_materias[$e]['c2'];
						// traemos el corte 3
						$c3 = $consulta_materias[$e]['c3'];

						if (($c1 > $nocalificado) || ($c2 > $nocalificado) || ($c3 > $nocalificado)) {


							$nombre_materia_ciclo++;
						}
					}
				}


				// consultamos los programas que tiene el estudiante
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					//almacenamos el id del estudiante
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];

					//consultamos las materia del estudiante activas por cada curso
					$traerhorario = $panelestudiante->TraerHorariocalendarioactividadespea($id_programa, $jornada, $semestre, $grupo);

					for ($i = 0; $i < count($traerhorario); $i++) {
						$id_materia = $traerhorario[$i]["id_materia"];
						// trae las materias que tiene asignadas el estudiante
						$datosmateria = $panelestudiante->BuscarDatosAsignatura($id_materia);
						// trae el id del docente grupo
						$id_docente_grupo = $panelestudiante->TraerIddocentegrupo($id_materia);

						//traemos el id docente grupo para saber que docente tiene el estudiante
						$trae_id_docente_grupo = $id_docente_grupo["id_docente_grupo"];

						$actividades_total = $panelestudiante->listaractividadespordocentesemana($semana, $trae_id_docente_grupo);
					}
				}

				$totalingresos = count($rspta1);
				$totalfaltas = count($rspta2);
				$totalnotareportada = $nombre_materia_ciclo;
				$totalactividades = count($actividades_total);
				// $totalclasededia=count($nombre_ayer);
				break;

			case '4':

				$rspta1 = $panelestudiante->listaringresossemana($id_usuario, $mes_actual);
				// $rspta2 = $panelestudiante->listarfaltassemana($id_usuario, $mes_actual);
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {

					$id_estudiante = $consulta_programas[$i]['id_estudiante'];


					$rspta2 = $panelestudiante->mostrarfaltasemana($id_estudiante, $mes_actual);
				}

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				// $rspta4 = $panelestudiante->listaractividadessemana($semana);
				// print_r($rspta4);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {
					//almacenamos el id
					$id_estudiante = $consulta_programas[$i]['id_estudiante'];
					//almacenamos el ciclo
					$ciclo = $consulta_programas[$i]['ciclo'];
					//almacenamos el grupo
					$grupo = $consulta_programas[$i]['grupo'];
					//consultamos las materia del estudiante activas por cada curso
					$rspta3 = $panelestudiante->consulta_materias($id_estudiante, $ciclo); // trae las materias matriculadas
				}

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					// print_r($consulta_programas);
					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];

					//consultamos las materia del estudiante activas por cada curso
					// $traerhorario = $panelestudiante->TraerHorariocalendario($id_programa, $jornada, $semestre, $grupo);


				}

				//trae los programas activos de el estudiante en session
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];

					//consultamos las materia del estudiante activas por cada curso
					$consulta_materias = $panelestudiante->consulta_materiasparanotas($id_estudiante, $ciclo);

					$nombre_materia_ciclo = 0;

					for ($e = 0; $e < count($consulta_materias); $e++) {

						//almacenamos la jornada
						$jornada = $consulta_materias[$e]['jornada'];
						//almacenamos el semestre
						$semestre = $consulta_materias[$e]['semestre'];
						//almacenamos el programa
						$programa = $consulta_materias[$e]['programa'];
						//almacenamos el periodo
						$periodo = $consulta_materias[$e]['periodo'];
						//traemos el nombre de la materia	
						$nombre_materia = $consulta_materias[$e]['nombre_materia'];

						$nocalificado = 0;
						// $nombre_materia_ciclo = $e;
						// traemos el corte 1
						$c1 = $consulta_materias[$e]['c1'];
						// traemos el corte 2
						$c2 = $consulta_materias[$e]['c2'];
						// traemos el corte 3
						$c3 = $consulta_materias[$e]['c3'];

						if (($c1 > $nocalificado) || ($c2 > $nocalificado) || ($c3 > $nocalificado)) {


							$nombre_materia_ciclo++;
						}
					}
				}


				// consultamos los programas que tiene el estudiante
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					//almacenamos el id del estudiante
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];

					//consultamos las materia del estudiante activas por cada curso
					$traerhorario = $panelestudiante->TraerHorariocalendarioactividadespea($id_programa, $jornada, $semestre, $grupo);

					for ($i = 0; $i < count($traerhorario); $i++) {
						$id_materia = $traerhorario[$i]["id_materia"];
						// trae las materias que tiene asignadas el estudiante
						$datosmateria = $panelestudiante->BuscarDatosAsignatura($id_materia);
						// trae el id del docente grupo
						$id_docente_grupo = $panelestudiante->TraerIddocentegrupo($id_materia);

						//traemos el id docente grupo para saber que docente tiene el estudiante
						$trae_id_docente_grupo = $id_docente_grupo["id_docente_grupo"];

						$actividades_total = $panelestudiante->listaractividadespordocentesemana($mes_actual, $trae_id_docente_grupo);
					}
				}

				$totalingresos = count($rspta1);
				$totalfaltas = count($rspta2);
				$totalnotareportada = $nombre_materia_ciclo;
				$totalactividades = count($actividades_total);

				break;
		}

		$data["totalingresos"] .= $totalingresos;
		$data["totalfaltas"] .= $totalfaltas;
		$data["totalnotareportada"] .= $totalnotareportada;
		$data["totalactividades"] .= $totalactividades;

		echo json_encode($data);

	break;


	case 'listardatosfijos':

		$data = array();
		$data["perfilactualizado"] = "";
		$data["caracterizado"] = "";



		$rspta1 = $panelestudiante->fechaperfilactualizado($id_usuario);
		$fechaperfilactualizado = $rspta1["fecha_actualizacion"];
		$data["perfilactualizado"] .= $panelestudiante->fechaesp($fechaperfilactualizado);

		$rspta2 = $panelestudiante->caracterizado($id_usuario);
		@$fecha_caracterizado = $rspta2["fecha"];
		$data["caracterizado"] .= $panelestudiante->fechaesp($fecha_caracterizado);

		echo json_encode($data);

	break;

	case 'verperfilactualizado':
		$data = array();
		$data["estado"] = "";

		$semanas = date("Y-m-d", strtotime($fecha . "- 8 week"));
		$rspta = $panelestudiante->verperfilactualizado($id_usuario, $semanas);

		if ($rspta == true) {
			$data["estado"] = "1";
		} else {
			$data["estado"] = "2";
		}
		echo json_encode($data);

	break;

	case 'mostrar':
		$rspta = $panelestudiante->mostrar($id_usuario);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;


	case 'actualizarperfil':
		$data = array();
		$data["estado"] = "";
		$rspta = $panelestudiante->actualizarperfil($id_usuario, $estrato, $telefono, $celular, $email, $barrio, $direccion, $fecha);
		$rspta ? "si" : "no";

		$data["estado"] = $rspta;

		echo json_encode($data);
	break;


	case 'verificarencuesta':
		$rspta = $panelestudiante->verificarencuesta($id_usuario);
		$data["estado"] = ($rspta) ? "1" : "2";
		echo json_encode($data);
	break;

	case "listardocentesactivos":
		$rspta = $panelestudiante->listardocentesactivos();
		echo "<option>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_nombre"] . ' ' . $rspta[$i]["usuario_nombre_2"] . ' ' . $rspta[$i]["usuario_apellido"] . ' ' . $rspta[$i]["usuario_apellido_2"] . "</option>";
		}
		echo "<option value='0'>Ninguno</option>";
	break;

	case "guardarencuesta":

		$rspta = $panelestudiante->insertarencuesta($id_usuario, $fecha, $hora, $pre1, $pre2, $pre3);

		if ($rspta == true) {
			$data["estado"] = "1";
		} else {
			$data["estado"] = "2";
		}

		echo json_encode($data);

	break;

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
		// 	$eventos = $panelestudiante->listarEventos();

		// 	$data["contenido"] .= '
		// 	<div class="col-12 " >
		// 		<div class="row p-0 m-0">
		// 			<div class="col-xl-12">
		// 			<h2><span class="titulo-5">Eventos del mes </span>   <a href="" class="btn btn-primary text-white float-right">Ver todos los eventos</a><span class="dia titulo-5"> '.$meses.'</span>
		// 			</div>
		// 			<div class="col-xl-12">

		// 				<div class="row">';
		// 	for ($a = 0; $a < count($eventos); $a++) {

		// 		$fecha_inicio_evento = date($eventos[$a]["fecha_inicio"]);
		// 		$dia = date("d", strtotime($fecha_inicio_evento));
		// 		$mes = date("m", strtotime($fecha_inicio_evento));

		// 		$horas = date($eventos[$a]["hora"]);
		// 		$hora = date("h:i a",  strtotime($horas));

		// 		$dia_semana = date('l', strtotime($fecha_inicio_evento));


		// 		switch ($dia_semana) {
		// 			case "Sunday":
		// 				$dia_semana_final = "Domingo";
		// 				break;
		// 			case "Monday":
		// 				$dia_semana_final = "Lunes";
		// 				break;
		// 			case "Tuesday":
		// 				$dia_semana_final = "Martes";
		// 				break;
		// 			case "Wednesday":
		// 				$dia_semana_final = "Miercoles";
		// 				break;
		// 			case "Thursday":
		// 				$dia_semana_final = "Jueves";
		// 				break;
		// 			case "Friday":
		// 				$dia_semana_final = "Viernes";
		// 				break;
		// 			case "Saturday":
		// 				$dia_semana_final = "Sabado";
		// 				break;
		// 		}

		// 		$actividad_pertenece = $panelestudiante->selectActividadActiva($eventos[$a]["id_actividad"]);

		// 		$totalparticipante = $panelestudiante->totalactividad($eventos[$a]["id_evento"]);
		// 		$total_participantes = $totalparticipante["total_participantes"];

		// 		if($mes_actual_evento==$mes && strtotime(date("H:i:s")) <= strtotime($fecha_inicio_evento)){

		// 			$data["contenido"] .= '

		// 									<div class="col-xl-4">
		// 										<div class="row d-flex justify-content-center">
		// 											<div class="col-xl-11  mb-2 p-0 pb-2 tarjeta-evento" >

		// 												<div class="' . $actividad_pertenece["color"] . ' p-1"></div>

		// 												<div class="row">


		// 													<div class="col-xl-6" style="line-height:16px">
		// 														<p class="titulo-evento pt-4 pl-2">' . $eventos[$a]["evento"] . ' </p>
		// 													</div>

		// 													<div class="col-xl-6 pt-4 pl-4 text-center">
		// 														<span class="event-dash-card-icon"><i class="bi bi-calendar3"></i> </span>
		// 														<span>' . $dia_semana_final . '</span><br>
		// 														<span class="dia">' . $dia . '</span><br>
		// 														<span>' . $hora . '</span><br>


		// 													</div>
		// 													<div class="col-12">
		// 														<span class="ml-2 badge ' . $actividad_pertenece["color"] . '">' . $actividad_pertenece["actividad"] . '</span>
		// 													</div>


		// 												</div>


		// 											</div>

		// 										</div>

		// 									</div>

		// 								';
		// 		}
		// 	}

		// 	$data["contenido"] .= '	   

		// 				</div>

		//  			</div>
		// 		</div>
		// 	</div>';

		// 	echo json_encode($data);

		// break;

	case 'listar-eventos2':

		$data["contenido"] = "";
		$eventos = $panelestudiante->alertacalendario();
		// print_r($eventos);
		$data["contenido"] .= '
		<div class="card calendario col-12">
			<div class="row p-0 m-0">
			<div class="col-xl-20 bg-white tarjetas">
			<div id="forcecentered1">
					<div class="event-list2 bd-highlight">';
		for ($a = 0; $a < count($eventos); $a++) {

			$fechaini = date($eventos[$a]["fecha_inicio"]);
			$dia = date("d", strtotime($fechaini));
			$mes = date("m", strtotime($fechaini));

			// $horas=date($eventos[$a]["hora"]);
			// $hora=date("h:i a",  strtotime($horas));

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

			$actividad_pertenece = $panelestudiante->selectActividadActiva($eventos[$a]["id_actividad"]);
			$fechahoy = new DateTime($fecha);
			$inicial = new DateTime($eventos[$a]["fecha_inicio"]);
			$final = new DateTime($eventos[$a]["fecha_final"]);

			$diferencia = $fechahoy->diff($final)->format("%r%a");
			$data["contenido"] .= '

								<div class="event-dash-card tarjeta2" >

									
									<div class="bg-primary p-2" style="height:60px; vertical-align:center">
										<b class="card-text body">' . $eventos[$a]["actividad"] . ' </b>
									</div>
									
										<span class="badge badge-warning float-right" style="margin:-10px 10px 0px 0px">' . $diferencia . ' Días </span>
									<div class="p-2">
										<span class="">
											<span><b>Desde: </b>' . $panelestudiante->fechaespcalendario($eventos[$a]["fecha_inicio"]) . '</span>
											<br>
											<span><b>Hasta: </b>' . $panelestudiante->fechaespcalendario($eventos[$a]["fecha_final"]) . '</span>
										</span>
									</div>
									
								</div>';
		}

		$data["contenido"] .= '	   

					</div>
				</div>
			</div>
			</div>
		</div>';

		echo json_encode($data);

	break;

		// case 'listar-eventos-academicos':

		// 	$data["contenido"] = "";
		// 	$eventosacademicos = $panelestudiante->traercalendariopic();
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
		// 			<div class="event-dash-card tarjeta2">
		// 				<div class="bg-primary p-1"></div>
		// 				<div class="row">
		// 					<div class="col-5 ">
		// 						<div class="fecha-tarjeta pl-2">
		// 							<span class="titulo-mes">Hasta</span><br>
		// 							<span class="titulo-dia">'.$dia_final.'</span><br>
		// 							<span class="titulo-mes">'.$meses.' ' .$anio_final. '</span>
		// 						</div>
		// 					</div>
		// 					<div class="col-7" style="line-height:14px">
		// 					<span class="badge badge-warning float-right mt-1 mr-3" >'.$diferencia.' Días </span><br>
		// 						<b>'.$eventosacademicos[$a]["actividad"].'</b>
		// 					</div>
		// 				</div>							
		// 			</div>';
		// 	}

		// 	$data["contenido"] .= '	   

		// 				</div>
		// 			</div>
		// 		</div>
		// 		</div>
		// 	</div>';

		// 	echo json_encode($data);

		// break;

		//Nombres de los estudiantes
	case 'mostrar_nombre_estudiante':

		$rangoestudiante = $_GET["rangoestudiante"];
		$data = array();
		$data[0] = "";

		switch ($rangoestudiante) {
			case 1:

				$data[0] = "";

				$data[0] .=
					'		

			<div class="col-12 p-4 table-responsive">
					
				<table id="mostrarestudiantesnombre" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead><tbody>';
				$mostrar_estudiante = $panelestudiante->listaringresos($id_usuario, $fecha);

				for ($n = 0; $n < count($mostrar_estudiante); $n++) {
					$mostrar_estudiante = $panelestudiante->mostrarestudiantes($id_usuario, $fecha);
					// Datos Estudiantes
					$credencial_nombre = $mostrar_estudiante[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_estudiante[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_estudiante[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_estudiante[$n]["credencial_apellido_2"];
					// $ip=$mostrar_estudiante[$n]["ip"];
					$hora = $mostrar_estudiante[$n]["hora"];
					$fecha = $mostrar_estudiante[$n]["fecha"];

					$data[0] .= '
						
						
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $panelestudiante->fechaespcalendario($fecha) . '</td>
								<td>' . $hora . '</td>
								
							</tr>
						';
				}
				$data[0] .= '</tbody></table></div>';


				break;

			case 2:
				$data["0"] = "";
				$data[0] .=
					'	
				<div class="col-12 p-4 table-responsive">	
				<table id="mostrarestudiantesnombre" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead><tbody>';
				$mostrar_estudiante = $panelestudiante->listaringresos($id_usuario, $fecha_anterior);
				for ($n = 0; $n < count($mostrar_estudiante); $n++) {

					$mostrar_estudiante = $panelestudiante->mostrarestudiantes($id_usuario, $fecha_anterior);
					// Datos Estudiantes 
					$credencial_nombre = $mostrar_estudiante[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_estudiante[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_estudiante[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_estudiante[$n]["credencial_apellido_2"];
					$ip = $mostrar_estudiante[$n]["ip"];
					$hora = $mostrar_estudiante[$n]["hora"];
					$fecha = $mostrar_estudiante[$n]["fecha"];
					$data[0] .= '
						
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $panelestudiante->fechaespcalendario($fecha) . '</td>
								<td>' . $hora . '</td>
							</tr>
						';
				}
				$data[0] .= '</tbody></table></div>';
				break;

			case 3:
				$data["0"] = "";
				$data[0] .=
					'	
				<div class="col-12 p-4 table-responsive">

				<table id="mostrarestudiantesnombre" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead><tbody>';

				$mostrar_estudiante = $panelestudiante->listaringresossemana($id_usuario, $semana);
				// print_r($semana);
				for ($n = 0; $n < count($mostrar_estudiante); $n++) {
					$mostrar_estudiante = $panelestudiante->mostrarestudiantessemana($id_usuario, $semana);
					// Datos Estudiantes 
					$credencial_nombre = $mostrar_estudiante[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_estudiante[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_estudiante[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_estudiante[$n]["credencial_apellido_2"];
					$hora = $mostrar_estudiante[$n]["hora"];
					$fecha = $mostrar_estudiante[$n]["fecha"];
					$data[0] .= '
						
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $panelestudiante->fechaespcalendario($fecha) . '</td>
								<td>' . $hora . '</td>
								
							</tr>
						';
				}
				$data[0] .= '</tbody></table></div>';
				break;

			case 4:
				$data["0"] = "";
				$data[0] .=
					'	
				<div class="col-12 p-4 table-responsive"
				<table id="mostrarestudiantesnombre" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>

				</tr>
				</thead><tbody>';
				$mostrar_estudiante = $panelestudiante->listaringresossemana($id_usuario, $mes_actual);
				for ($n = 0; $n < count($mostrar_estudiante); $n++) {
					$mostrar_estudiante = $panelestudiante->mostrarestudiantessemana($id_usuario, $mes_actual);
					// Datos Estudiantes
					$credencial_nombre = $mostrar_estudiante[$n]["credencial_nombre"];
					$credencial_nombre_2 = $mostrar_estudiante[$n]["credencial_nombre_2"];
					$credencial_apellido = $mostrar_estudiante[$n]["credencial_apellido"];
					$credencial_apellido_2 = $mostrar_estudiante[$n]["credencial_apellido_2"];
					$ip = $mostrar_estudiante[$n]["ip"];
					$hora = $mostrar_estudiante[$n]["hora"];
					$fecha = $mostrar_estudiante[$n]["fecha"];
					$data[0] .= '
						
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $panelestudiante->fechaespcalendario($fecha) . '</td>
								<td>' . $hora . '</td>
							</tr>
						';
				}
				$data[0] .= '</tbody></table></div>';
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
				<div class="col-12 p-4 table-responsive">
				<table id="mostrarfaltas" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre Docente</th>
				<th scope="col">Nombre Estudiante</th>
				<th scope="col">Materia Falta</th>
				<th scope="col">Motivo Falta</th>
				</tr>
				<tbody></thead>
				
				';

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {

					$id_estudiante = $consulta_programas[$i]['id_estudiante'];

					$mostrar_faltas = $panelestudiante->mostrarfaltas($id_estudiante, $fecha);

					for ($n = 0; $n < count($mostrar_faltas); $n++) {

						$materia_falta = $mostrar_faltas[$n]["materia_falta"];
						$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];


						// print_r($mostrar_faltas);
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
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $materia_falta . '</td>
								<td>' . $motivo_falta . '</td>
							</tr>
						';
					}
				}
				$data[0] .= '</tbody></table></div>';


				break;

			case 2:
				$data["0"] = "";
				$data[0] .=
					'	
				<div class="col-12 p-4 table-responsive">	
				<table id="mostrarfaltas" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre Docente</th>
				<th scope="col">Nombre Estudiante</th>
				<th scope="col">Materia Falta</th>
				<th scope="col">Motivo Falta</th>
				</tr>
				<tbody></thead>
				
				';

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {

					$id_estudiante = $consulta_programas[$i]['id_estudiante'];

					$mostrar_faltas = $panelestudiante->mostrarfaltas($id_estudiante, $fecha_anterior);

					for ($n = 0; $n < count($mostrar_faltas); $n++) {

						$materia_falta = $mostrar_faltas[$n]["materia_falta"];
						$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];


						// print_r($mostrar_faltas);
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
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $materia_falta . '</td>
								<td>' . $motivo_falta . '</td>
							</tr>
						';
					}
				}
				$data[0] .= '</tbody></table></div>';
				break;

			case 3:
				$data["0"] = "";
				$data[0] .=
					'	
				<div class="col-12 p-4 table-responsive">
				<table id="mostrarfaltas" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre Docente</th>
				<th scope="col">Nombre Estudiante</th>
				<th scope="col">Materia Falta</th>
				<th scope="col">Motivo Falta</th>
				</tr>
				<tbody></thead>
				
				';

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {

					$id_estudiante = $consulta_programas[$i]['id_estudiante'];

					$mostrar_faltas = $panelestudiante->mostrarfaltasemana($id_estudiante, $semana);

					for ($n = 0; $n < count($mostrar_faltas); $n++) {

						$materia_falta = $mostrar_faltas[$n]["materia_falta"];
						$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];


						// print_r($mostrar_faltas);
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
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $materia_falta . '</td>
								<td>' . $motivo_falta . '</td>
							</tr>
						';
					}
				}
				$data[0] .= '</tbody></table></div>';
				break;

			case 4:
				$data["0"] = "";
				$data[0] .=
					'		
				<div class="col-12 p-4 table-responsive">
				<table id="mostrarfaltas" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre Docente</th>
				<th scope="col">Nombre Estudiante</th>
				<th scope="col">Materia Falta</th>
				<th scope="col">Motivo Falta</th>
				</tr>
				<tbody></thead>
				
				';

				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($i = 0; $i < count($consulta_programas); $i++) {

					$id_estudiante = $consulta_programas[$i]['id_estudiante'];

					$mostrar_faltas = $panelestudiante->mostrarfaltasemana($id_estudiante, $mes_actual);

					for ($n = 0; $n < count($mostrar_faltas); $n++) {

						$materia_falta = $mostrar_faltas[$n]["materia_falta"];
						$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];


						// print_r($mostrar_faltas);
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
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
								<td>' . $materia_falta . '</td>
								<td>' . $motivo_falta . '</td>
							</tr>
						';
					}
				}
				$data[0] .= '</tbody></table></div>';
				break;
		}

		echo json_encode($data);

	break;


	case 'clasedeldia':
		// $data= array();
		$data[0] = "";
		//trae los programas activos de el estudiante en session
		$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
		//ciclo por cada programa que tenga activo
		$data[0] .= ' <div class="mostrarclasesdeldia">';
		for ($j = 0; $j < count($consulta_programas); $j++) {
			//almacenamos el id
			$id_estudiante = $consulta_programas[$j]['id_estudiante'];
			//almacenamos el ciclo en el que esta el estudiante
			$ciclo = $consulta_programas[$j]['ciclo'];
			$id_programa = $consulta_programas[$j]['id_programa_ac'];
			$jornada = $consulta_programas[$j]['jornada_e'];
			$semestre = $consulta_programas[$j]['semestre_estudiante'];
			$grupo = $consulta_programas[$j]['grupo'];
			$rspta = $panelestudiante->listar($id_estudiante, $ciclo, $grupo);
			$reg = $rspta;
			for ($i = 0; $i < count($reg); $i++) {
				$nombre_materia = $reg[$i]["nombre_materia"];
				$buscaridmateria = $panelestudiante->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
				$idmateriaencontrada = $buscaridmateria["id"];
				$traerhorarios = $panelestudiante->docente_grupo_clases($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);


				for ($gru = 0; $gru < count($traerhorarios); $gru++) {
					$n_dia = $traerhorarios[$gru]["dia"];
					$horainicio = $traerhorarios[$gru]["hora"];
					$horafinal = $traerhorarios[$gru]["hasta"];
					$corte = $traerhorarios[$gru]["corte"];
					$salon = $traerhorarios[$gru]["salon"];
					$array = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "viernes", "Sabado");
					$num_dia = date("N", strtotime(date("Y-m-d")));

					if ($n_dia == $array[$num_dia]) {
						$data[0] .= ' 
							
						
						<div class="row">
						<div class="col-12">
							<p class="text-secondary small mb-0">' . $array[$num_dia] . ' ' . $horainicio . ' - ' . $horafinal . '</p>
							<br>
							<p class="" title="Ver Ingresos"><span>' . $nombre_materia . '</span></p>
						</div>
						<div class="col-12 d-flex justify-content-between">
							<p class="text-secondary small mb-0">Salón</p>
							<p class="">' . $salon . '</p>
						</div>
					</div>
					
						
							';
					}
				}
			}

			$data[0] .= ' </div>';
		}
		echo json_encode($data);
	break;




	case 'mostraractividadesnuevas':

		$mostraractividadesnuevas = $_GET["mostraractividadesnuevas"];
		// $trae_id_docente_grupo = $_GET["trae_id_docente_grupo"];

		$data = array();
		$data[0] = "";

		switch ($mostraractividadesnuevas) {
			case 1:
				$data[0] = "";

				$data[0] .=
					'
				<div class="col-12 p-4 table-responsive">
				<table id="activdadespordocente" class="table  table-hover " style="width:100%">
				<thead>
					<tr>
						<th scope="col" class="text-center">Nombre Documento</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
						<th scope="col" class="text-center">Nombre Materia </th>
					</tr>
				<tbody>
				</thead>';
				// consultamos los programas que tiene el estudiante
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					//almacenamos el id del estudiante
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];

					//consultamos las materia del estudiante activas por cada curso
					$traerhorario = $panelestudiante->TraerHorariocalendarioactividadespea($id_programa, $jornada, $semestre, $grupo);

					for ($i = 0; $i < count($traerhorario); $i++) {
						$id_materia = $traerhorario[$i]["id_materia"];
						// trae las materias que tiene asignadas el estudiante
						$datosmateria = $panelestudiante->BuscarDatosAsignatura($id_materia);
						// trae el id del docente grupo
						$id_docente_grupo = $panelestudiante->TraerIddocentegrupo($id_materia);
						//traemos el id docente grupo para saber que docente tiene el estudiante
						$trae_id_docente_grupo = $id_docente_grupo["id_docente_grupo"];
						//materias que tiene el estudiante
						$nombre = $datosmateria["nombre"];
						$caracterizacion = $panelestudiante->listaractividadespordocente($fecha, $trae_id_docente_grupo);
						for ($h = 0; $h < count($caracterizacion); $h++) {
							$nombre_documento = $caracterizacion[$h]["nombre_documento"];
							$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
							$archivo_documento = $caracterizacion[$h]["archivo_documento"];
							$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];

							$data[0] .= '
						
								<tr>
									<td class="text-center">' . $nombre_documento . '</td>
									<td class="text-center">' . $descripcion_documento . '</td>
									<td class="text-center">' . $archivo_documento . '</td>
									<td>' . $panelestudiante->fechaespcalendario($fecha_actividad) . '</td>
									<td class="text-center">' . $nombre . '</td>
								</tr>
							';
						}
					}
				}


				$data[0] .= '</tbody></table></div>';


				break;

			case 2:
				$data["0"] = "";

				$data[0] .=
					'
				<div class="col-12 p-4 table-responsive">
				<table id="activdadespordocente" class="table table-hover" style="width:100%">
				<thead>
					<tr>
						<th scope="col" class="text-center">Nombre Documento</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
						<th scope="col" class="text-center">Nombre Materia </th>
					</tr>
				<tbody>
				</thead>';
				// consultamos los programas que tiene el estudiante
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					//almacenamos el id del estudiante
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];

					//consultamos las materia del estudiante activas por cada curso
					$traerhorario = $panelestudiante->TraerHorariocalendarioactividadespea($id_programa, $jornada, $semestre, $grupo);

					for ($i = 0; $i < count($traerhorario); $i++) {
						$id_materia = $traerhorario[$i]["id_materia"];
						// trae las materias que tiene asignadas el estudiante
						$datosmateria = $panelestudiante->BuscarDatosAsignatura($id_materia);
						// trae el id del docente grupo
						$id_docente_grupo = $panelestudiante->TraerIddocentegrupo($id_materia);

						//traemos el id docente grupo para saber que docente tiene el estudiante
						$trae_id_docente_grupo = $id_docente_grupo["id_docente_grupo"];
						//materias que tiene el estudiante
						$nombre = $datosmateria["nombre"];

						$caracterizacion = $panelestudiante->listaractividadespordocente($fecha_anterior, $trae_id_docente_grupo);

						for ($h = 0; $h < count($caracterizacion); $h++) {

							$nombre_documento = $caracterizacion[$h]["nombre_documento"];
							$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
							$archivo_documento = $caracterizacion[$h]["archivo_documento"];
							$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];

							$data[0] .= '
						
								<tr>
									<td class="text-center">' . $nombre_documento . '</td>
									<td class="text-center">' . $descripcion_documento . '</td>
									<td class="text-center">' . $archivo_documento . '</td>
									<td>' . $panelestudiante->fechaespcalendario($fecha_actividad) . '</td>
									<td class="text-center">' . $nombre . '</td>
								</tr>
							';
						}
					}
				}


				$data[0] .= '</tbody></table></div>';
				break;

			case 3:
				$data["0"] = "";
				$data[0] .=
					'
				<div class="col-12 p-4 table-responsive">
				<table id="activdadespordocente" class="table table-hover" style="width:100%">
				<thead>
					<tr>
						<th scope="col" class="text-center">Nombre Documento</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
						<th scope="col" class="text-center">Nombre Materia </th>
					</tr>
				<tbody>
				</thead>';
				// consultamos los programas que tiene el estudiante
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					//almacenamos el id del estudiante
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];

					//consultamos las materia del estudiante activas por cada curso
					$traerhorario = $panelestudiante->TraerHorariocalendarioactividadespea($id_programa, $jornada, $semestre, $grupo);

					for ($i = 0; $i < count($traerhorario); $i++) {
						$id_materia = $traerhorario[$i]["id_materia"];
						// trae las materias que tiene asignadas el estudiante
						$datosmateria = $panelestudiante->BuscarDatosAsignatura($id_materia);
						// trae el id del docente grupo
						$id_docente_grupo = $panelestudiante->TraerIddocentegrupo($id_materia);

						//traemos el id docente grupo para saber que docente tiene el estudiante
						$trae_id_docente_grupo = $id_docente_grupo["id_docente_grupo"];
						//materias que tiene el estudiante
						$nombre = $datosmateria["nombre"];

						$caracterizacion = $panelestudiante->listaractividadespordocentesemana($semana, $trae_id_docente_grupo);

						for ($h = 0; $h < count($caracterizacion); $h++) {

							$nombre_documento = $caracterizacion[$h]["nombre_documento"];
							$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
							$archivo_documento = $caracterizacion[$h]["archivo_documento"];
							$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];

							$data[0] .= '
						
								<tr>
									<td class="text-center">' . $nombre_documento . '</td>
									<td class="text-center">' . $descripcion_documento . '</td>
									<td class="text-center">' . $archivo_documento . '</td>
									<td>' . $panelestudiante->fechaespcalendario($fecha_actividad) . '</td>
									<td class="text-center">' . $nombre . '</td>
								</tr>
							';
						}
					}
				}


				$data[0] .= '</tbody></table></div>';
				break;

			case 4:
				$data["0"] = "";
				$data[0] .=
					'
				<div class="col-12 p-4 table-responsive">
				<table id="activdadespordocente" class="table table-hover" style="width:100%">
				<thead>
					<tr>
						<th scope="col" class="text-center">Nombre Documento</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
						<th scope="col" class="text-center">Nombre Materia </th>
					</tr>
				<tbody>
				</thead>';
				// consultamos los programas que tiene el estudiante
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);
				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {
					//almacenamos el id del estudiante
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];
					$id_programa = $consulta_programas[$j]['id_programa_ac'];
					$jornada = $consulta_programas[$j]['jornada_e'];
					$semestre = $consulta_programas[$j]['semestre_estudiante'];
					$grupo = $consulta_programas[$j]['grupo'];

					//consultamos las materia del estudiante activas por cada curso
					$traerhorario = $panelestudiante->TraerHorariocalendarioactividadespea($id_programa, $jornada, $semestre, $grupo);

					for ($i = 0; $i < count($traerhorario); $i++) {
						$id_materia = $traerhorario[$i]["id_materia"];
						// trae las materias que tiene asignadas el estudiante
						$datosmateria = $panelestudiante->BuscarDatosAsignatura($id_materia);
						// trae el id del docente grupo
						$id_docente_grupo = $panelestudiante->TraerIddocentegrupo($id_materia);

						//traemos el id docente grupo para saber que docente tiene el estudiante
						$trae_id_docente_grupo = $id_docente_grupo["id_docente_grupo"];
						//materias que tiene el estudiante
						$nombre = $datosmateria["nombre"];

						$caracterizacion = $panelestudiante->listaractividadespordocentesemana($mes_actual, $trae_id_docente_grupo);

						for ($h = 0; $h < count($caracterizacion); $h++) {

							$nombre_documento = $caracterizacion[$h]["nombre_documento"];
							$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
							$archivo_documento = $caracterizacion[$h]["archivo_documento"];
							$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];

							$data[0] .= '
						
								<tr>
									<td class="text-center">' . $nombre_documento . '</td>
									<td class="text-center">' . $descripcion_documento . '</td>
									<td class="text-center">' . $archivo_documento . '</td>
									<td>' . $panelestudiante->fechaespcalendario($fecha_actividad) . '</td>
									<td class="text-center">' . $nombre . '</td>
								</tr>
							';
						}
					}
				}


				$data[0] .= '</tbody></table></div>';

				break;
		}

		echo json_encode($data);

	break;

	case 'notasreportadas':

		$rangonotasreportadas = $_GET["rangonotasreportadas"];
		$data = array();
		$data[0] = "";

		switch ($rangonotasreportadas) {
			case 1:

				$data = array(); //Vamos a declarar un array
				$data["0"] = ""; //iniciamos el arreglo
				$data[0] .=
					'
				<div class="col-12 p-4 table-responsive">
					<table id="notasreportadas" class="table table-hover" style="width:100%">
					<thead>
					<tr>
						<th scope="col" class="text-center">Materia</th>
						<th scope="col" class="text-center">C1</th>
						<th scope="col" class="text-center">C2 </th>
						<th scope="col" class="text-center">C3 </th>
						
					</tr>
					</thead>
					<tbody>
					
					';

				//trae los programas activos de el estudiante en session
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);

				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];

					//consultamos las materia del estudiante activas por cada curso
					$consulta_materias = $panelestudiante->consulta_materiasparanotas($id_estudiante, $ciclo);

					$vernombreestudiante = $panelestudiante->vernombreestudiante($_SESSION['id_usuario']);
					$nombre_estudiante = $vernombreestudiante[$j]["credencial_nombre"] . " " . $vernombreestudiante[$j]["credencial_nombre_2"] . " " . $vernombreestudiante[$j]["credencial_apellido"] . " " . $vernombreestudiante[$j]["credencial_apellido_2"];
					$correo_electronico = $vernombreestudiante[$j]['credencial_login'];


					for ($e = 0; $e < count($consulta_materias); $e++) {

						//almacenamos la jornada
						$jornada = $consulta_materias[$e]['jornada'];
						//almacenamos el semestre
						$semestre = $consulta_materias[$e]['semestre'];
						//almacenamos el programa
						$programa = $consulta_materias[$e]['programa'];
						//almacenamos el periodo
						$periodo = $consulta_materias[$e]['periodo'];
						//traemos el nombre de la materia	
						$nombre_materia = $consulta_materias[$e]['nombre_materia'];

						$nocalificado = 0;
						// traemos el corte 1
						$c1 = $consulta_materias[$e]['c1'];
						// traemos el corte 2
						$c2 = $consulta_materias[$e]['c2'];
						// traemos el corte 3
						$c3 = $consulta_materias[$e]['c3'];

						if (($c1 > $nocalificado) || ($c2 > $nocalificado) || ($c3 > $nocalificado)) {

							$data[0] .= '
							
							<tr>
							<td class="text-center">' . $nombre_materia . '</td>
							<td class="text-center">' . $c1 . '</td>
							<td class="text-center">' . $c2 . '</td>
							<td class="text-center">' . $c3 . '</td>
							
							</tr>';
						}
					}
				}
				$data[0] .= '</tbody>
					</table>
				</div>';


				break;

			case 2:
				$data = array(); //Vamos a declarar un array
				$data["0"] = ""; //iniciamos el arreglo
				$data[0] .=
					'	
				<div class="col-12 p-4 table-responsive">
					<table id="notasreportadas" class="table  table-hover" style="width:100%">
					<thead>
					<tr>
						<th scope="col" class="text-center">Materia</th>
						<th scope="col" class="text-center">C1</th>
						<th scope="col" class="text-center">C2 </th>
						<th scope="col" class="text-center">C3 </th>
						
					</tr>
					</thead>
					<tbody>
						
					';

				//trae los programas activos de el estudiante en session
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);

				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];

					//consultamos las materia del estudiante activas por cada curso
					$consulta_materias = $panelestudiante->consulta_materiasparanotas($id_estudiante, $ciclo);

					$vernombreestudiante = $panelestudiante->vernombreestudiante($_SESSION['id_usuario']);
					$nombre_estudiante = $vernombreestudiante[$j]["credencial_nombre"] . " " . $vernombreestudiante[$j]["credencial_nombre_2"] . " " . $vernombreestudiante[$j]["credencial_apellido"] . " " . $vernombreestudiante[$j]["credencial_apellido_2"];
					$correo_electronico = $vernombreestudiante[$j]['credencial_login'];


					for ($e = 0; $e < count($consulta_materias); $e++) {

						//almacenamos la jornada
						$jornada = $consulta_materias[$e]['jornada'];
						//almacenamos el semestre
						$semestre = $consulta_materias[$e]['semestre'];
						//almacenamos el programa
						$programa = $consulta_materias[$e]['programa'];
						//almacenamos el periodo
						$periodo = $consulta_materias[$e]['periodo'];
						//traemos el nombre de la materia	
						$nombre_materia = $consulta_materias[$e]['nombre_materia'];

						$nocalificado = 0;
						// traemos el corte 1
						$c1 = $consulta_materias[$e]['c1'];
						// traemos el corte 2
						$c2 = $consulta_materias[$e]['c2'];
						// traemos el corte 3
						$c3 = $consulta_materias[$e]['c3'];

						if (($c1 > $nocalificado) || ($c2 > $nocalificado) || ($c3 > $nocalificado)) {

							$data[0] .= '
						
						<tr>
						<td class="text-center">' . $nombre_materia . '</td>
						<td class="text-center">' . $c1 . '</td>
						<td class="text-center">' . $c2 . '</td>
						<td class="text-center">' . $c3 . '</td>
						
						</tr>';
						}
					}
				}
				$data[0] .= '</tbody></table></div>';

				break;

			case 3:
				$data = array(); //Vamos a declarar un array
				$data["0"] = ""; //iniciamos el arreglo
				$data[0] .=
					'
			<div class="col-12 p-4 table-responsive">
					<table id="notasreportadas" class="table table-hover" style="width:100%">		
				<thead>
				<tr>
					<th scope="col" class="text-center">Materia</th>
					<th scope="col" class="text-center">C1</th>
					<th scope="col" class="text-center">C2 </th>
					<th scope="col" class="text-center">C3 </th>
					
				</tr>
				</thead>
				<tbody>
					
					';

				//trae los programas activos de el estudiante en session
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);

				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];

					//consultamos las materia del estudiante activas por cada curso
					$consulta_materias = $panelestudiante->consulta_materiasparanotas($id_estudiante, $ciclo);

					$vernombreestudiante = $panelestudiante->vernombreestudiante($_SESSION['id_usuario']);
					$nombre_estudiante = $vernombreestudiante[$j]["credencial_nombre"] . " " . $vernombreestudiante[$j]["credencial_nombre_2"] . " " . $vernombreestudiante[$j]["credencial_apellido"] . " " . $vernombreestudiante[$j]["credencial_apellido_2"];
					$correo_electronico = $vernombreestudiante[$j]['credencial_login'];


					for ($e = 0; $e < count($consulta_materias); $e++) {

						//almacenamos la jornada
						$jornada = $consulta_materias[$e]['jornada'];
						//almacenamos el semestre
						$semestre = $consulta_materias[$e]['semestre'];
						//almacenamos el programa
						$programa = $consulta_materias[$e]['programa'];
						//almacenamos el periodo
						$periodo = $consulta_materias[$e]['periodo'];
						//traemos el nombre de la materia	
						$nombre_materia = $consulta_materias[$e]['nombre_materia'];

						$nocalificado = 0;
						// traemos el corte 1
						$c1 = $consulta_materias[$e]['c1'];
						// traemos el corte 2
						$c2 = $consulta_materias[$e]['c2'];
						// traemos el corte 3
						$c3 = $consulta_materias[$e]['c3'];

						if (($c1 > $nocalificado) || ($c2 > $nocalificado) || ($c3 > $nocalificado)) {

							$data[0] .= '
						
						<tr>
						<td class="text-center">' . $nombre_materia . '</td>
						<td class="text-center">' . $c1 . '</td>
						<td class="text-center">' . $c2 . '</td>
						<td class="text-center">' . $c3 . '</td>
						
						</tr>';
						}
					}
				}
				$data[0] .= '</tbody></table></div>';

				break;

			case 4:
				$data = array(); //Vamos a declarar un array
				$data["0"] = ""; //iniciamos el arreglo
				$data[0] .=
					'		
			<div class="col-12 p-4 table-responsive">
				<table id="notasreportadas" class="table table-hover" style="width:100%">
				<thead>
				<tr>
					<th scope="col" class="text-center">Materia</th>
					<th scope="col" class="text-center">C1</th>
					<th scope="col" class="text-center">C2 </th>
					<th scope="col" class="text-center">C3 </th>
					
				</tr>
				</thead>
				<tbody>
				
				';

				//trae los programas activos de el estudiante en session
				$consulta_programas = $panelestudiante->consulta_programas($_SESSION['id_usuario']);

				//ciclo por cada programa que tenga activo
				for ($j = 0; $j < count($consulta_programas); $j++) {

					//almacenamos el id
					$id_estudiante = $consulta_programas[$j]['id_estudiante'];
					//almacenamos el ciclo en el que esta el estudiante
					$ciclo = $consulta_programas[$j]['ciclo'];

					//consultamos las materia del estudiante activas por cada curso
					$consulta_materias = $panelestudiante->consulta_materiasparanotas($id_estudiante, $ciclo);

					$vernombreestudiante = $panelestudiante->vernombreestudiante($_SESSION['id_usuario']);
					$nombre_estudiante = $vernombreestudiante[$j]["credencial_nombre"] . " " . $vernombreestudiante[$j]["credencial_nombre_2"] . " " . $vernombreestudiante[$j]["credencial_apellido"] . " " . $vernombreestudiante[$j]["credencial_apellido_2"];
					$correo_electronico = $vernombreestudiante[$j]['credencial_login'];


					for ($e = 0; $e < count($consulta_materias); $e++) {

						//almacenamos la jornada
						$jornada = $consulta_materias[$e]['jornada'];
						//almacenamos el semestre
						$semestre = $consulta_materias[$e]['semestre'];
						//almacenamos el programa
						$programa = $consulta_materias[$e]['programa'];
						//almacenamos el periodo
						$periodo = $consulta_materias[$e]['periodo'];
						//traemos el nombre de la materia	
						$nombre_materia = $consulta_materias[$e]['nombre_materia'];

						$nocalificado = 0;
						// traemos el corte 1
						$c1 = $consulta_materias[$e]['c1'];
						// traemos el corte 2
						$c2 = $consulta_materias[$e]['c2'];
						// traemos el corte 3
						$c3 = $consulta_materias[$e]['c3'];

						if (($c1 > $nocalificado) || ($c2 > $nocalificado) || ($c3 > $nocalificado)) {

							$data[0] .= '
						
						<tr>
						<td class="text-center">' . $nombre_materia . '</td>
						<td class="text-center">' . $c1 . '</td>
						<td class="text-center">' . $c2 . '</td>
						<td class="text-center">' . $c3 . '</td>
						
						</tr>';
						}
					}
				}
				$data[0] .= '</tbody></table></div>';
				break;
		}

		echo json_encode($data);

	break;

	case 'iniciarcalendario':

		$impresion = "";

		$traerhorario = $panelestudiante->listarcalendarioacademico();
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
					default:
						break;
				}


				if ($check < 10) {
					$check = "0" . $check;
				} else {
					$check;
				}
			}


			// if($mes_actual>= $check ){

			// imprime las actividades del calendario 
			$eventosacademicos = $panelestudiante->traercalendario($anio_actual . "-" . $check);
			$data[0] .= '
			<div class="col-12 pb-4">
				<div class="row p-0 m-0">
				<div class="col-xl-12 bg-white tarjetas">
					<div id="forcecentered1">
						<div class="event-list2 bd-highlight">';
			for ($a = 0; $a < count($eventosacademicos); $a++) {
				$fechahoy = new DateTime($fecha);
				$final = new DateTime($eventosacademicos[$a]["fecha_final"]);
				$diferencia = $fechahoy->diff($final)->format("%r%a");
				$fecha_final = $eventosacademicos[$a]["fecha_final"];
				$fechaComoEntero = strtotime($fecha_final);
				$dia_final = date("d", $fechaComoEntero);
				$mes_final = date("m", $fechaComoEntero);
				$anio_final = date("Y", $fechaComoEntero);
				$data[0] .= '
				<div class="event-dash-card tarjeta2">
					<div class="bg-primary p-1"></div>
					<div class="row">
						<div class="col-5 ">
							<div class="fecha-tarjeta pl-2">
								<span class="titulo-mes">Hasta</span><br>
								<span class="titulo-dia">' . $dia_final . '</span><br>
								<span class="titulo-mes">' . $meses . ' ' . $anio_final . '</span>
							</div>
						</div>
						<div class="col-7" style="line-height:14px">
						<span class="badge badge-warning float-right mt-1 mr-3" >' . $diferencia . ' Días </span><br>
							<b>' . $eventosacademicos[$a]["actividad"] . '</b>
						</div>
					</div>
				</div>';
			}
			$data[0] .= '	   
						</div>
					</div>
				</div>
				</div>
			</div>';

			// listar eventos del calendario eventos
			$eventos = $panelestudiante->listarEventos($anio_actual . "-" . $check, $fecha_actual_eventos);
			$data[0] .= '
				<div class="col-12 " >
					<div class="row p-0 m-0">
						<div class="col-xl-12 border-top">
							<h2>
							<span class="titulo-5">Eventos </span> 
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

				$actividad_pertenece = $panelestudiante->selectActividadActiva($eventos[$d]["id_actividad"], $check);
				$data[0] .= '
						<div class="col-xl-4">
							<div class="row d-flex justify-content-center">
								<div class="col-xl-11  mb-2 p-0 pb-2 tarjeta-evento" >
									<div class="' . $actividad_pertenece["color"] . ' p-1"></div>
									<div class="row">
										<div class="col-xl-6" style="line-height:14px">
											<p class="titulo-evento pt-4 pl-2">' . $eventos[$d]["evento"] . ' </p>
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
			$data[0] .= '	   
						</div>
					</div>
				</div>
			</div>';
			// }

			// 	}else {

			// 		$data[0] .= '	';

		}



		echo json_encode($data);

		break;
	case "selectDepartamento":
		$rspta = $panelestudiante->selectDepartamento();
		echo "<option value=''>Seleccionar Departamento de residencia</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
		}
	break;
	case "selectMunicipio":
		$id_departamento = $_POST["id_departamento"];
		$rspta = $panelestudiante->selectMunicipio($id_departamento);
		echo "<option value=''>Seleccionar Municipio</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
		}
		break;
	case "selectBarrio":
		$id_municipio = $_POST["id_municipio"];
		$rspta = $panelestudiante->selectBarrio($id_municipio);
		echo "<option value=''>Seleccionar Barrio</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_barrio"] . "'>" . $rspta[$i]["nombre_barrio"] . "</option>";
		}
		break;

	case 'guardarmapa':
		$data = array();
		$data["estado"] = "";
		$rspta = $panelestudiante->actualizarMapa($latitud, $longitud, $id_usuario);
		$rspta ? "si" : "no";

		$data["estado"] = $rspta;

		echo json_encode($data);
		break;

	case 'pendientes':
		$data = array();
		$data["0"] = "";
		$mensajedir = "";
		/* consulta para traer el header de la tabla */

		$pendienteperfil = $panelestudiante->fechaperfilactualizado($id_usuario);
		$mapavalidado = $pendienteperfil["mapa_validado"];
		if ($mapavalidado == 1) {
			$mensajedir = '
							<a data-toggle="modal" data-target="#myModalDireccion" class="pointer " title="No es obligatorio, pero es necesario para mejorar la experiencia en CIAF, por ejemplo (Gestión de horarios)">
								Validar aquí con mapa
							</a>
						';
		} else {

			$mensajedir = 'Validado';
		}

		$data["0"] .= '

			
				<div class="info-box">
					<span class="info-box-icon bg-light-green elevation-1 text-success">
						<i class="fa-solid fa-location-dot"></i>
					</span>
					<div class="info-box-content cursor-pointer" onclick="contactanos()">
						<span class="info-box-text">Dirección residencia</span>
						<span class="info-box-number">' . $mensajedir . '</span>
					</div>
				</div>';



		$results = array($data);

		echo json_encode($results);
		break;

	case 'mostrarcalendario':
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

			$data[0] .= '<div class="academico row">';
			// imprime las actividades del calendario 
			$cuenta = 0;
			$eventosacademicos = $panelestudiante->traercalendario($anio_actual . "-" . $check);
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

					if($fecha_final > $fecha){

					
						if ($fecha_inicio_actividad >= $fecha_actual_eventos) {
							$cuenta++;
							$data[0] .= '
								<div class="col-12 py-2 px-3">
									<div class="row">
										<div class="col-12 borde rounded">
											<div class="row">
												<div class="col-12 position-absolute" style="z-index:1; margin:-12px 0px 0px 0px">
													<span class="badge bg-light-green  mt-1 mr-3 text-success" >' . $diferencia . ' Días </span>
												</div>
												
												
												<div class="col-7 " style="line-height:14px">
													<div class="row">
														
														<div class="col-12 d-flex align-content-center flex-wrap position-absolute fs-14" style="height:100%;">
															' . $eventosacademicos[$a]["actividad"] . '
														</div>
														
													</div>
												</div>

												<div class="col-5 bg-light-green rounded-right">
													<div class="row">
														<div class="col-12 font-weight-bolder">'.$panelestudiante->fechacorta($fecha_inicio_actividad).'</div>
														<div class="col-12 fs-14 ">Hasta </div>
														<div class="col-12 fs-40 titulo-7" style="line-height:34px">' . $dia_final . '</div>
														<div class="col-12 fs-14">' . $meses . ' ' . $anio_final . '</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>';
						}
					}

				}
			}

			$data[0] .= '</div>';


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
			$eventos = $panelestudiante->listarEventos($anio_actual . "-" . $check, $fecha_actual_eventos);
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

				$actividad_pertenece = $panelestudiante->selectActividadActiva($eventos[$d]["id_actividad"], $check);


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

	case 'vershopping':
		$data['vershopping'] = '';
		$data['vershopping'] .= '   
			
					<div class="mostrarshopping">';
		$respuesta = $panelestudiante->mostrarshopping();
		for ($i = 0; $i < count($respuesta); $i++) {
			$data['vershopping'] .= '

							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
								<div class="row h-100 card-primary card-outline direct-chat direct-chat-primary mr-1 bg-white">
									<div class="col-12 m-0 p-0">
										<div class="d-flex justify-content-center mx-auto d-block align-items-center">
											<img src="../files/shopping/' . $respuesta[$i]["shopping_img"] . '" class="img-fluid" style="width: 100%; height: 200px" alt="' . $respuesta[$i]["shopping_img"] . '">
										</div>
										<div class="col-12 mt-2 d-flex align-items-center justify-content-center" style="height:60px">
											<p class="fs-14 text-center text-semibold line-height-16 text-dark">' . $respuesta[$i]["shopping_nombre"] . '</p>  
										</div>
									</div>

									<div class="col-6 bg-primary p-2 text-center">';
			if ($respuesta[$i]["shopping_facebook"] != "") {
				$data['vershopping'] .= '<a href="' . $respuesta[$i]["shopping_facebook"] . '" target="_blank"><i class="fa-brands fa-facebook-f fa-2x"></i></a>';
			} else {
				$data['vershopping'] .= ' <i class="fa-brands fa-facebook-f fa-2x text-primary"></i>';
			}

			$data['vershopping'] .= '
									
									</div>
									<div class="col-6 bg-info p-2 text-center">';
			if ($respuesta[$i]["shopping_instagram"] != "") {
				$data['vershopping'] .= '<a href="' . $respuesta[$i]["shopping_instagram"] . '" target="_blank"><i class="fa-brands fa-instagram fa-2x"></i></a>';
			} else {
				$data['vershopping'] .= ' <i class="fa-brands fa-instagram fa-2x text-info"></i>';
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

	case 'cajadeherramientas':
		$data['conte'] = '';
		$data['conte'] .= '  
			
					<div class="mostrarcajadeherramientas">';

		$respuesta = $panelestudiante->mostrarElementos();
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

	case 'mostrarcursosinscritos':
		$data['conte'] = '';
		$miscursos = $panelestudiante->mostrarcursosinscritos($s_identificacion);

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
		$miscursos = $panelestudiante->eliminarinscripcion($valor);


		echo json_encode($data);


		break;


	case 'separarCupo':
		$id_curso = $_POST["id_curso"];

		$data['conte'] = '';
		$miscursos = $panelestudiante->verificarInteresado($id_curso, $s_identificacion);
		if ($miscursos) {
			$data['conte'] .= 'si';
		} else {
			$estado = "Interesado";
			$insertarinteresado = $panelestudiante->insertarInteresado($s_identificacion, $id_curso, $periodo_actual, $fecha, $hora, $estado, $periodo_actual, $id_usuario);

			if ($insertarinteresado) {
				$data['conte'] .= 'ok';
			} else {
				$data['conte'] .= 'no';
			}
		}


		echo json_encode($data);


		break;
		// echo json_encode($data);
		// break;



		case 'guardarmonitoreandoestudiante':

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
			$fecha = date('Y-m-d');
		
			$verificar_id_usuario = $panelestudiante->verificarRegistromonitoreandoestudiante($id_usuario, $fecha);
			if ($verificar_id_usuario > 0) {
				$inserto = array(
					"estatus" => 0,
					"valor" => "El estudiante ya tiene un registro para el día de hoy."
				);
			} else {
				$rspta = $panelestudiante->GuardarmonitoreandoEstudiante($id_usuario, $fecha, $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15);
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
		


	case 'traer_estado_modal_estudiante':
		$respuesta = $panelestudiante->estadoModalmonitoreandoEstudiante($id_usuario);
		$data = array("estado" => $respuesta["estado"]);
		echo json_encode($data);
	break;

	case 'listarCursosEC':

		$cursos = $panelestudiante->listarCursosEC($fecha);
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
			$fecha_inicio = $panelestudiante->convertirFechaAtexto($cursos[$i]["fecha_inicio"]);
			$create_dt = $panelestudiante->convertirFechaAtexto($fecha_creacion[0]);
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
						$ingresos = $panelestudiante->ingresoDia($id_usuario, $fecha);
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
            $validarpuntos=$panelestudiante->validarpuntos($punto_nombre,$fecha,$id_usuario);// para validar si el punto de perfil fue otorgado
            if ($validarpuntos) {
                // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
                
            } else {
                // No se obtuvo ningún resultado no hay punto otorgado
                $insertarpunto=$panelestudiante->insertarPunto($id_usuario,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);

                $totalpuntos=$panelestudiante->verpuntos();
                $puntoscredencial=$totalpuntos["puntos"];
                $sumapuntos=$puntos_cantidad+$puntoscredencial;
                $panelestudiante->actulizarValor($sumapuntos);

				$data["racha"]=$racha;

            }


		}
		

		echo json_encode($data);

	break;



}
