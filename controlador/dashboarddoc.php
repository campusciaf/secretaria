<?php
require_once "../modelos/DashboardDoc.php";
// require_once "../mail/send.php";
error_reporting(1);
// require_once "../mail/templatealertadocentes.php";
$dashboarddoc = new DashboardDoc();
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$dia_actual = date("d");
$mes_actual = date('Y-m') . "-00";
$fecha_anterior = date("Y-m-d", strtotime($fecha . "- 1 days"));
$semana = date("Y-m-d", strtotime($fecha . "- 1 week"));
$fecha_rango=date("Y-m-d",strtotime($fecha."- 2 week")); 

$hora_actual_sistema = date('H:i');
$hora_actual = date("g:i a", strtotime($hora_actual_sistema));
$diaentreSemana = date("w");

$rsptaperiodo = $dashboarddoc->periodoactual();
$periodo_actual = $_SESSION['periodo_actual'];
$id_usuario = $_SESSION['id_usuario'];
// echo $id_usuario;
// print_r()

$usuario_direccion = isset($_POST["usuario_direccion"]) ? limpiarCadena($_POST["usuario_direccion"]) : "";
$usuario_telefono = isset($_POST["usuario_telefono"]) ? limpiarCadena($_POST["usuario_telefono"]) : "";
$usuario_celular = isset($_POST["usuario_celular"]) ? limpiarCadena($_POST["usuario_celular"]) : "";
$usuario_email = isset($_POST["usuario_email"]) ? limpiarCadena($_POST["usuario_email"]) : "";
$fecha_actual = isset($_POST["fecha_actual"]) ? limpiarCadena($_POST["fecha_actual"]) : "";




/* utoevaluacion */
$r1 = isset($_POST["r1"]) ? limpiarCadena($_POST["r1"]) : "";
$r2 = isset($_POST["r2"]) ? limpiarCadena($_POST["r2"]) : "";
$r3 = isset($_POST["r3"]) ? limpiarCadena($_POST["r3"]) : "";
$r4 = isset($_POST["r4"]) ? limpiarCadena($_POST["r4"]) : "";
$r5 = isset($_POST["r5"]) ? limpiarCadena($_POST["r5"]) : "";
$r6 = isset($_POST["r6"]) ? limpiarCadena($_POST["r6"]) : "";
$r7 = isset($_POST["r7"]) ? limpiarCadena($_POST["r7"]) : "";
$r8 = isset($_POST["r8"]) ? limpiarCadena($_POST["r8"]) : "";
$r9 = isset($_POST["r9"]) ? limpiarCadena($_POST["r9"]) : "";
$r10 = isset($_POST["r10"]) ? limpiarCadena($_POST["r10"]) : "";

/* ****************** */


/* encuenta tic */

$er1 = isset($_POST["er1"]) ? limpiarCadena($_POST["er1"]) : "";


/* ************* */


switch ($_GET["op"]) {

	case 'guardaryeditar':
		$data = array();
		$data["0"] = "";
		if ($_SESSION['usuario_cargo'] == "Docente") {
			$rspta = $dashboarddoc->insertarEncuestaDocente($id_usuario, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $fecha, $hora, $periodo_actual);
			$dashboarddoc->actualizarEstadoAutoevaluacion($id_usuario);
			$data["0"] .= 'd';
		} else {
			// $estudiante = $dashboarddoc->consultaDatos($id_usuario);
			// $identificacion=$estudiante["credencial_identificacion"];
			// $programa=$estudiante["fo_programa"];
			// $jornada=$estudiante["jornada_e"];	
			// $rspta=$dashboarddoc->insertarEncuestaEstudiante($id_usuario,$identificacion,$programa,$jornada,$fecha,$hora,$r1,$r2,$r3,$r4);		
			// $data["0"] .= 'e';
		}
		$results = array($data);
		echo json_encode($results);

	break;

	case 'listar':
		$rspta = $dashboarddoc->listar();
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$data["0"] .= '<div class="box box-default">
			<div class="box-header with-border bg-green">
			<h3 class="box-title">' . $reg[$i]["nombre_educacion_continuada"] . '</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			<strong><i class="fa fa-book margin-r-5"></i> ' . $reg[$i]["tipo_educacion_continuada"] . '</strong>
			<p class="text-muted">
			' . $reg[$i]["descripcion_educacion_continuada"] . '
			</p>
			<hr>
			<strong><i class="fas fa-file-alt margin-r-5"></i> Modalidad:</strong>
			' . $reg[$i]["modalidad_educacion_continuada"] . '
			</div>
			<!-- /.box-body -->
		</div>';
		}
		$results = array($data);
		echo json_encode($results);
	break;

	case 'verificarAutoevaluacion':
		$valor = "-";
		$estado = $dashboarddoc->consultarEstadoAutoevaluacion('autoevaluacion')["estado"];
		if ($_SESSION['usuario_cargo'] == "Docente" and $estado == 1) {
			$rspta = $dashboarddoc->autoevaluacionEstado($id_usuario, $periodo_actual);
			if ($rspta == true) {
				$valor = 1;
			} else {
				$valor = 0;
			}
		}
		echo json_encode($valor);
	break;

	case 'alertacalendario':

		$fecha_actual = isset($_POST["fecha_actual"]) ? limpiarCadena($_POST["fecha_actual"]) : "";
		$alerta = $dashboarddoc->alertacalendario();
		$alertacalendario = $alerta;
		$data[0] = '';

		for ($r = 0; $r < count($alertacalendario); $r++) {
			$nombre = utf8_encode($alertacalendario[$r]['actividad']);
			$data[0] .= '
				<div class="form-group col-xl-12 col-lg-6 col-md-12 col-sm-12">
				<b>' . $nombre . '<br> </b>	
				<br><b> Fecha de Inicio :</b> ' . $dashboarddoc->fechaesp($alertacalendario[$r]["fecha_inicio"]) .

				'<br><b>Fecha de Final : </b>' . $dashboarddoc->fechaesp($alertacalendario[$r]["fecha_final"]) . '<hr>
				</div>';
		};

		echo utf8_decode($data[0]);

	break;

	case 'verperfilactualizado':
		$data = array();
		$data["estado"] = "";

		$semanas = date("Y-m-d", strtotime($fecha . "- 8 week"));
		$rspta = $dashboarddoc->verperfilactualizado($id_usuario, $semanas);

		if ($rspta == true) {
			$data["estado"] = "1";
		} else {
			$data["estado"] = "2";
		}
		echo json_encode($data);

	break;

	case 'actualizarperfil':
		$data = array();
		$data["estado"] = "";
		$rspta = $dashboarddoc->actualizarperfil($id_usuario, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email, $fecha);
		$rspta ? "si" : "no";

		$data["estado"] = $rspta;

		echo json_encode($data);
	break;

	case 'mostrar':
		$rspta = $dashboarddoc->mostrar($id_usuario);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;

	case 'listardatos':
		$rango = $_GET["rango"];

		$data = array();
		$data["totalingresos"] = "";
		$data["totalfaltas"] = "";
		$data["totalactividades"] = "";
		$data["totalguia"] = "";
		$data["totalperfilactualizado"] = "";
		$data["totalusuariohojadevida"] = "";
		$data["totalestudiantesacargo"] = "";

		// $data["perfilactualizado"] ="";
		$data["cvactualizado"] = "";

		// $data= Array();




		switch ($rango) {
			case '1':
				$rspta1 = $dashboarddoc->listaringresos($id_usuario, $fecha);
				$rspta2 = $dashboarddoc->listarfaltas($id_usuario, $fecha);
				$rspta3 = $dashboarddoc->listar_actividades($id_usuario,$fecha);
				$rspta4 = $dashboarddoc->listarguia($id_usuario, $fecha);
				$rspta5 = $dashboarddoc->perfilactualizadodocente($fecha, $id_usuario);
				$rspta6 = $dashboarddoc->usuariohojadevida($fecha);


				$rspta1 = $dashboarddoc->fechaperfilactualizado($id_usuario);

				// $perfilactualizado=$rspta1["fecha_actualizacion"];

				// $fechaperfilactualizado=$dashboarddoc->fechaesp($perfilactualizado);

				$listarhojasdevida = $dashboarddoc->datosDocente($id_usuario);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$usuario_identificacion = $listarhojasdevida["usuario_identificacion"];
				}
				$usuario_cv = $dashboarddoc->usuario_cv($usuario_identificacion);
				$id_usuario_cv = $usuario_cv["id_usuario_cv"];

				$cv_informacion_personal = $dashboarddoc->usuario_cv_personal($id_usuario_cv);

				$ultima_actualizacion_hj = $cv_informacion_personal["ultima_actualizacion"];

				$actualizacion_hoja_de_vida = $dashboarddoc->fechaesp($ultima_actualizacion_hj);


				// creamos el contador
				$contador = 0;
				$listar_grupos = $dashboarddoc->listargrupos($id_usuario);
				for ($i = 0; $i < count($listar_grupos); $i++) {

					$id_materia = $listar_grupos[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $listar_grupos[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $listar_grupos[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $listar_grupos[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $listar_grupos[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $listar_grupos[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $listar_grupos[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $listar_grupos[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($listar_grupos[$i]["id_docente_grupo"]);
					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];

					//traemos las materias del docente
					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias para contarlas y mostraslas en el panel
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);

					$contador = $contador + count($listar_materias);
					// echo "-".$contador;
					// print_r($contador)
					// echo "-".count($listar_materias);

				}

				$totalingresos = '
					<div class="row">
						<div class="col-6 pointer" onclick="mostrar_nombre_docente()">
							<p class="text-secondary small mb-0"> Ingresos hoy</p><p class=""> '.count($rspta1) . ' Ingresos</p>
						</div>
						<div class="col-6 pointer" >
							<p class="text-secondary small mb-0"> Racha</p><p class=""> '.count($rspta1) . ' diás</p>
						</div>
						<div class="col-12 pointer">
							<p class="text-secondary small mb-0"> Calificación</p>
							<p class="">
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
							</p>
						</div>

					</div>
					';
				$totalfaltas = count($rspta2);
				$totalactividades = count($rspta3);
				$totalguia = count($rspta4);
				$totalperfilactualizado = count($rspta5);
				$totalusuariohojadevida = count($rspta6);
				$totalestudiantesacargo = $contador;

				// $fechaperfilactualizado;
				$actualizacion_hoja_de_vida;

				break;
			case '2':

				$fecha_anterior = date("Y-m-d", strtotime($fecha . "- 1 days"));

				$rspta1 = $dashboarddoc->listaringresos($id_usuario, $fecha_anterior);
				$rspta2 = $dashboarddoc->listarfaltas($id_usuario, $fecha_anterior);
				$rspta3 = $dashboarddoc->listar_actividades($id_usuario,$fecha_anterior);
				$rspta4 = $dashboarddoc->listarguia($id_usuario, $fecha_anterior);
				$rspta5 = $dashboarddoc->perfilactualizadodocente($fecha_anterior, $id_usuario);
				$rspta6 = $dashboarddoc->usuariohojadevida($fecha_anterior);

				// creamos el contador
				$contador = 0;
				$listar_grupos = $dashboarddoc->listargrupos($id_usuario);
				for ($i = 0; $i < count($listar_grupos); $i++) {

					$id_materia = $listar_grupos[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $listar_grupos[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $listar_grupos[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $listar_grupos[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $listar_grupos[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $listar_grupos[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $listar_grupos[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $listar_grupos[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($listar_grupos[$i]["id_docente_grupo"]);
					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];

					//traemos las materias del docente
					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias para contarlas y mostraslas en el panel
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);

					$contador = $contador + count($listar_materias);
					// echo "-".$contador;
					// print_r($contador)
					// echo "-".count($listar_materias);

				}
				$totalingresos = '
					<div class="row">
						<div class="col-6 pointer" onclick="mostrar_nombre_docente()">
							<p class="text-secondary small mb-0"> Ingresos hoy</p><p class=""> '.count($rspta1) . ' Ingresos</p>
						</div>
						<div class="col-6 pointer" >
							<p class="text-secondary small mb-0"> Racha</p><p class=""> '.count($rspta1) . ' Diás</p>
						</div>
						<div class="col-12 pointer">
							<p class="text-secondary small mb-0"> Calificación</p>
							<p class="">
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
							</p>
						</div>

					</div>
					';
				$totalfaltas = count($rspta2);
				$totalactividades = count($rspta3);
				$totalguia = count($rspta4);
				$totalperfilactualizado = count($rspta5);
				$totalusuariohojadevida = count($rspta6);
				$totalestudiantesacargo = $contador;

				break;
			case '3':
				$semana = date("Y-m-d", strtotime($fecha . "- 1 week"));

				$rspta1 = $dashboarddoc->listaringresossemana($id_usuario, $semana);
				$rspta2 = $dashboarddoc->listarfaltassemana($id_usuario, $semana);
				$rspta3 = $dashboarddoc->listar_pea_actividades_semana($id_usuario,$semana);
				$rspta4 = $dashboarddoc->listarguiasemana($id_usuario, $semana);
				$rspta5 = $dashboarddoc->perfilactualizadodocente($semana, $id_usuario);
				$rspta6 = $dashboarddoc->usuariohojadevida($semana);

				// creamos el contador
				$contador = 0;
				$listar_grupos = $dashboarddoc->listargrupos($id_usuario);
				for ($i = 0; $i < count($listar_grupos); $i++) {

					$id_materia = $listar_grupos[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $listar_grupos[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $listar_grupos[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $listar_grupos[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $listar_grupos[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $listar_grupos[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $listar_grupos[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $listar_grupos[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($listar_grupos[$i]["id_docente_grupo"]);
					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];

					//traemos las materias del docente
					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias para contarlas y mostraslas en el panel
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);

					$contador = $contador + count($listar_materias);
					// echo "-".$contador;
					// print_r($contador)
					// echo "-".count($listar_materias);

				}
				$totalingresos = '
					<div class="row">
						<div class="col-6 pointer" onclick="mostrar_nombre_docente()">
							<p class="text-secondary small mb-0"> Ingresos hoy</p><p class=""> '.count($rspta1) . ' Ingresos</p>
						</div>
						<div class="col-6 pointer" >
							<p class="text-secondary small mb-0"> Racha</p><p class=""> '.count($rspta1) . ' Días</p>
						</div>
						<div class="col-12 pointer">
							<p class="text-secondary small mb-0"> Calificación</p>
							<p class="">
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
							</p>
						</div>

					</div>
					';
				$totalfaltas = count($rspta2);
				$totalactividades = count($rspta3);
				$totalguia = count($rspta4);
				$totalperfilactualizado = count($rspta5);
				$totalusuariohojadevida = count($rspta6);
				$totalestudiantesacargo = $contador;



				break;
			case '4':

				$rspta1 = $dashboarddoc->listaringresossemana($id_usuario, $mes_actual);
				$rspta2 = $dashboarddoc->listarfaltassemana($id_usuario, $mes_actual);
				$rspta3 = $dashboarddoc->listar_pea_actividades_semana($id_usuario,$mes_actual);
				$rspta4 = $dashboarddoc->listarguiasemana($id_usuario, $mes_actual);
				$rspta5 = $dashboarddoc->perfilactualizadodocente($mes_actual, $id_usuario);
				$rspta6 = $dashboarddoc->usuariohojadevida($mes_actual);

				// creamos el contador
				$contador = 0;
				$listar_grupos = $dashboarddoc->listargrupos($id_usuario);
				for ($i = 0; $i < count($listar_grupos); $i++) {

					$id_materia = $listar_grupos[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $listar_grupos[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $listar_grupos[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $listar_grupos[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $listar_grupos[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $listar_grupos[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $listar_grupos[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $listar_grupos[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($listar_grupos[$i]["id_docente_grupo"]);
					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];

					//traemos las materias del docente
					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias para contarlas y mostraslas en el panel
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);

					$contador = $contador + count($listar_materias);
					// echo "-".$contador;
					// print_r($contador)
					// echo "-".count($listar_materias);

				}
				$totalingresos = '
					<div class="row">
						<div class="col-6 pointer" onclick="mostrar_nombre_docente()">
							<p class="text-secondary small mb-0"> Ingresos hoy</p><p class=""> '.count($rspta1) . ' Ingresos</p>
						</div>
						<div class="col-6 pointer" >
							<p class="text-secondary small mb-0"> Racha</p><p class=""> '.count($rspta1) . ' Días</p>
						</div>
						<div class="col-12 pointer">
							<p class="text-secondary small mb-0"> Calificación</p>
							<p class="">
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
							</p>
						</div>

					</div>
					';
				$totalfaltas = count($rspta2);
				$totalactividades = count($rspta3);
				$totalguia = count($rspta4);
				$totalperfilactualizado = count($rspta5);
				$totalusuariohojadevida = count($rspta6);
				$totalestudiantesacargo = $contador;
				break;

			case '5':

				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];

				$data = array();
				$data["totalingresos"] = "";
				$data["totalfaltas"] = "";
				$data["totalactividades"] = "";
				$data["totalguia"] = "";
				$data["totalperfilactualizado"] = "";
				$data["totalusuariohojadevida"] = "";
				$data["totalestudiantesacargo"] = "";

				$rspta1 = $dashboarddoc->listaringresosrango($id_usuario, $fecha_inicial, $fecha_final);
				$rspta2 = $dashboarddoc->listarfaltasrango($id_usuario, $fecha_inicial, $fecha_final);
				$rspta3 = $dashboarddoc->listaractividades($id_usuario, $fecha_inicial, $fecha_final);
				$rspta4 = $dashboarddoc->listarguiarango($id_usuario, $fecha_inicial, $fecha_final);
				$rspta5 = $dashboarddoc->perfilactualizadodocenterango($id_usuario, $fecha_inicial, $fecha_final);
				$rspta6 = $dashboarddoc->usuariohojadevidarango($fecha_inicial, $fecha_final);
				// creamos el contador
				$contador = 0;
				$listar_grupos = $dashboarddoc->listargrupos($id_usuario);
				for ($i = 0; $i < count($listar_grupos); $i++) {

					$id_materia = $listar_grupos[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $listar_grupos[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $listar_grupos[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $listar_grupos[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $listar_grupos[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $listar_grupos[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $listar_grupos[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $listar_grupos[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($listar_grupos[$i]["id_docente_grupo"]);
					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];

					//traemos las materias del docente
					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias para contarlas y mostraslas en el panel
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);

					$contador = $contador + count($listar_materias);
					// echo "-".$contador;
					// print_r($contador)
					// echo "-".count($listar_materias);

				}

				$totalingresos = '
					<div class="row">
						<div class="col-6 pointer" onclick="mostrar_nombre_docente()">
							<p class="text-secondary small mb-0"> Ingresos hoy</p><p class=""> '.count($rspta1) . ' Ingresos</p>
						</div>
						<div class="col-6 pointer" >
							<p class="text-secondary small mb-0"> Racha</p><p class=""> '.count($rspta1) . ' Días</p>
						</div>
						<div class="col-12 pointer">
							<p class="text-secondary small mb-0"> Calificación</p>
							<p class="">
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
							</p>
						</div>

					</div>
					';
				$totalfaltas = count($rspta2);
				$totalactividades = count($rspta3);
				$totalguia = count($rspta4);
				$totalperfilactualizado = count($rspta5);
				$totalusuariohojadevida = count($rspta6);
				$totalestudiantesacargo = $contador;

				break;
		}

		$data["totalingresos"] .= $totalingresos;
		$data["totalfaltas"] .= $totalfaltas;
		$data["totalactividades"] .= $totalactividades;
		$data["totalguia"] .= $totalguia;
		$data["totalperfilactualizado"] .= $totalperfilactualizado;
		$data["totalestudiantesacargo"] .= $totalestudiantesacargo;




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

				$data[0] .=
					'		
				<table id="mostrardocente" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead>';

				$totaldocente = $dashboarddoc->listaringresos($id_usuario, $fecha);

				for ($n = 0; $n < count($totaldocente); $n++) {
					// $totaldocente = $dashboarddoc->mostrardocente($id_usuario, $fecha);
					// Datos Funcionario 
					$usuario_identificacion = $totaldocente[$n]["usuario_identificacion"];
					$usuario_nombre = $totaldocente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totaldocente[$n]["usuario_nombre_2"];
					$usuario_apellido = $totaldocente[$n]["usuario_apellido"];
					$fecha = $totaldocente[$n]["fecha"];
					$hora = $totaldocente[$n]["hora"];

					$data[0] .= '
						
						
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>  
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td>
								<td>' . $dashboarddoc->fechaespcalendario($fecha) . '</td> 
								<td>' . $hora . '</td>  
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';


				break;

			case 2:
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrardocente" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead>
				<tbody>';
				$totaldocente = $dashboarddoc->listaringresos($id_usuario, $fecha_anterior);
				// print_r($totaldocente);
				for ($n = 0; $n < count($totaldocente); $n++) {
					// $totaldocente = $dashboarddoc->mostrardocente($id_usuario, $fecha_anterior);
					// Datos Funcionario 
					$usuario_identificacion = $totaldocente[$n]["usuario_identificacion"];
					$usuario_nombre = $totaldocente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totaldocente[$n]["usuario_nombre_2"];
					$usuario_apellido = $totaldocente[$n]["usuario_apellido"];
					$fecha = $totaldocente[$n]["fecha"];
					$hora = $totaldocente[$n]["hora"];
					$data[0] .= '
						
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $$usuario_identificacion . '</td>  
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
								<td>' . $dashboarddoc->fechaespcalendario($fecha) . '</td> 
								<td>' . $hora . '</td>  
							</tr>
						';
				}
				$data[0] .= '</tbody>
				</table>';
				break;

			case 3:
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrardocente" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead>
				<tbody>';
				$totaldocente = $dashboarddoc->mostrardocentesemana($id_usuario, $semana);
				for ($n = 0; $n < count($totaldocente); $n++) {

					// Datos Docente
					$usuario_identificacion = $totaldocente[$n]["usuario_identificacion"];
					$usuario_nombre = $totaldocente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $totaldocente[$n]["usuario_nombre_2"];
					$usuario_apellido = $totaldocente[$n]["usuario_apellido"];
					$fecha = $totaldocente[$n]["fecha"];
					$hora = $totaldocente[$n]["hora"];
					$data[0] .= '
						
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td>' . $usuario_identificacion . '</td>  
								<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . '</td> 
								<td>' . $dashboarddoc->fechaespcalendario($fecha) . '</td> 
								<td>' . $hora . '</td>  
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
				<table id="mostrardocente" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead>
				<tbody>';
				// $totaldocente=$dashboarddoc->listaringresos($id_usuario,$mes_actual);
				$totaldocente = $dashboarddoc->mostrardocentesemana($id_usuario, $mes_actual);

				for ($n = 0; $n < count($totaldocente); $n++) {
					// $totaldocente = $dashboarddoc->mostrardocente($id_usuario, $mes_actual);
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
								<td>' . $dashboarddoc->fechaespcalendario($fecha) . '</td> 
								<td>' . $hora . '</td>  
							</tr>
						';
				}
				$data[0] .= '</tbody></table>';
				break;

			case 5:

				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];

				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrardocente" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Cédula</th>
				<th scope="col">Nombre</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead>
				<tbody>';

				$totaldocente = $dashboarddoc->listaringresosrangonombredocente($id_usuario, $fecha_inicial, $fecha_final);

				for ($n = 0; $n < count($totaldocente); $n++) {
					// $totaldocente = $dashboarddoc->mostrardocente($id_usuario, $mes_actual);
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
								<td>' . $dashboarddoc->fechaespcalendario($fecha) . '</td> 
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
				<table id="mostrarfaltas" class="table table-hover" style="width:100%">
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


				$mostrar_faltas = $dashboarddoc->mostrarfaltas($_SESSION['id_usuario'], $fecha);

				for ($n = 0; $n < count($mostrar_faltas); $n++) {

					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
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

				$data[0] = "";

				$data[0] .=
					'		
				<table id="mostrarfaltas" class="table table-hover" style="width:100%">
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


				$mostrar_faltas = $dashboarddoc->mostrarfaltas($_SESSION['id_usuario'], $fecha_anterior);

				for ($n = 0; $n < count($mostrar_faltas); $n++) {

					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
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

				$data[0] = "";

				$data[0] .=
					'		
				<table id="mostrarfaltas" class="table table-hover" style="width:100%">
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


				$mostrar_faltas = $dashboarddoc->mostrarfaltassemana($_SESSION['id_usuario'], $semana);

				for ($n = 0; $n < count($mostrar_faltas); $n++) {

					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
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
				// $data["0"] = "";
				// $data[0] .=
				// 	'		
				// 	<table id="mostrarfaltas" class="table table-hover" style="width:100%">
				// 	<thead>
				// <tr>
				// <th scope="col">#</th>
				// <th scope="col">Nombre Docente</th>
				// <th scope="col">Nombre Estudiante</th>
				// <th scope="col">Cédula Estudiante</th>
				// <th scope="col">Materia Falta</th>
				// <th scope="col">Motivo Falta</th>
				// </tr>
				// </thead><tbody>
				
				// ';


				// $mostrar_faltas = $dashboarddoc->mostrarfaltassemana($_SESSION['id_usuario'], $semana);



				// for ($n = 0; $n < count($mostrar_faltas); $n++) {

				// 	$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
				// 	$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
				// 	$materia_falta = $mostrar_faltas[$n]["materia_falta"];
				// 	$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];


				// 	// print_r($mostrar_faltas);
				// 	// Faltas variables nombre 
				// 	$usuario_nombre = $mostrar_faltas[$n]["usuario_nombre"];
				// 	$usuario_nombre_2 = $mostrar_faltas[$n]["usuario_nombre_2"];
				// 	$usuario_apellido = $mostrar_faltas[$n]["usuario_apellido"];
				// 	$usuario_apellido_2 = $mostrar_faltas[$n]["usuario_apellido_2"];
				// 	//Faltas  variables estudiante
				// 	$credencial_nombre = $mostrar_faltas[$n]["credencial_nombre"];
				// 	$credencial_nombre_2 = $mostrar_faltas[$n]["credencial_nombre_2"];
				// 	$credencial_apellido = $mostrar_faltas[$n]["credencial_apellido"];
				// 	$credencial_apellido_2 = $mostrar_faltas[$n]["credencial_apellido_2"];

				// 	$data[0] .= '
						
						
				// 			<tr>
				// 				<th scope="row">' . ($n + 1) . '</th>
				// 				<td>' . $usuario_identificacion . '</td>
				// 				<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
				// 				<td>' . $credencial_identificacion . '</td>
				// 				<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
				// 				<td>' . $materia_falta . '</td>
				// 				<td>' . $motivo_falta . '</td>
				// 			</tr>
				// 		';
				// }
				// $data[0] .= '</tbody></table>';
				break;

			case 4:

				$data[0] = "";

				$data[0] .=
					'		
				<table id="mostrarfaltas" class="table table-hover" style="width:100%">
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

				$mostrar_faltas = $dashboarddoc->mostrarfaltassemana($_SESSION['id_usuario'], $mes_actual);

				for ($n = 0; $n < count($mostrar_faltas); $n++) {

					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
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
				
				// $data["0"] = "";
				// $data[0] .=
				// 	'		
				// 	<table id="mostrarfaltas" class="table table-hover" style="width:100%">
				// 	<thead>
				// <th scope="col">#</th>
				// <th scope="col">Nombre Docente</th>
				// <th scope="col">Nombre Estudiante</th>
				// <th scope="col">Cédula Estudiante</th>
				// <th scope="col">Materia Falta</th>
				// <th scope="col">Motivo Falta</th>
				// </tr>
				// </thead><tbody>
				
				// ';


				// 

				// for ($n = 0; $n < count($mostrar_faltas); $n++) {

				// 	$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
				// 	$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
				// 	$materia_falta = $mostrar_faltas[$n]["materia_falta"];
				// 	$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];


				// 	// print_r($mostrar_faltas);
				// 	// Faltas variables nombre 
				// 	$usuario_nombre = $mostrar_faltas[$n]["usuario_nombre"];
				// 	$usuario_nombre_2 = $mostrar_faltas[$n]["usuario_nombre_2"];
				// 	$usuario_apellido = $mostrar_faltas[$n]["usuario_apellido"];
				// 	$usuario_apellido_2 = $mostrar_faltas[$n]["usuario_apellido_2"];
				// 	//Faltas  variables estudiante
				// 	$credencial_nombre = $mostrar_faltas[$n]["credencial_nombre"];
				// 	$credencial_nombre_2 = $mostrar_faltas[$n]["credencial_nombre_2"];
				// 	$credencial_apellido = $mostrar_faltas[$n]["credencial_apellido"];
				// 	$credencial_apellido_2 = $mostrar_faltas[$n]["credencial_apellido_2"];

				// 	$data[0] .= '
						
						
				// 			<tr>
				// 				<th scope="row">' . ($n + 1) . '</th>
				// 				<td>' . $usuario_identificacion . '</td>
				// 				<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
				// 				<td>' . $credencial_identificacion . '</td>
				// 				<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
				// 				<td>' . $materia_falta . '</td>
				// 				<td>' . $motivo_falta . '</td>
				// 			</tr>
				// 		</tbody>';
				// }
				// $data[0] .= '</table>';
				break;



			case 5:

				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];

				$data[0] = "";

				$data[0] .=
					'		
				<table id="mostrarfaltas" class="table table-hover" style="width:100%">
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

				$mostrar_faltas = $dashboarddoc->listarfaltasrangonombre($_SESSION['id_usuario'], $fecha_inicial, $fecha_final);

				for ($n = 0; $n < count($mostrar_faltas); $n++) {

					$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
					$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
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

				// $data["0"] = "";


				// $data[0] .=
				// 	'		
				// 	<table id="mostrarfaltas" class="table table-hover" style="width:100%">
				// 	<thead>
				// <tr>
				// <th scope="col">#</th>
				// <th scope="col">Nombre Docente</th>
				// <th scope="col">Nombre Estudiante</th>
				// <th scope="col">Cédula Estudiante</th>
				// <th scope="col">Materia Falta</th>
				// <th scope="col">Motivo Falta</th>
				// </tr>
				// </thead><tbody>
				
				// ';


				// $mostrar_faltas = $dashboarddoc->listarfaltasrangonombre($_SESSION['id_usuario'], $fecha_inicial, $fecha_final);

				// for ($n = 0; $n < count($mostrar_faltas); $n++) {

				// 	$credencial_identificacion = $mostrar_faltas[$n]["credencial_identificacion"];
				// 	$usuario_identificacion = $mostrar_faltas[$n]["usuario_identificacion"];
				// 	$materia_falta = $mostrar_faltas[$n]["materia_falta"];
				// 	$motivo_falta = $mostrar_faltas[$n]["motivo_falta"];


				// 	// print_r($mostrar_faltas);
				// 	// Faltas variables nombre 
				// 	$usuario_nombre = $mostrar_faltas[$n]["usuario_nombre"];
				// 	$usuario_nombre_2 = $mostrar_faltas[$n]["usuario_nombre_2"];
				// 	$usuario_apellido = $mostrar_faltas[$n]["usuario_apellido"];
				// 	$usuario_apellido_2 = $mostrar_faltas[$n]["usuario_apellido_2"];
				// 	//Faltas  variables estudiante
				// 	$credencial_nombre = $mostrar_faltas[$n]["credencial_nombre"];
				// 	$credencial_nombre_2 = $mostrar_faltas[$n]["credencial_nombre_2"];
				// 	$credencial_apellido = $mostrar_faltas[$n]["credencial_apellido"];
				// 	$credencial_apellido_2 = $mostrar_faltas[$n]["credencial_apellido_2"];

				// 	$data[0] .= '
						
						
				// 			<tr>
				// 				<th scope="row">' . ($n + 1) . '</th>
				// 				<td>' . $usuario_identificacion . '</td>
				// 				<td>' . $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
				// 				<td>' . $credencial_identificacion . '</td>
				// 				<td>' . $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido . " " . $credencial_apellido_2 . '</td>
				// 				<td>' . $materia_falta . '</td>
				// 				<td>' . $motivo_falta . '</td>
				// 			</tr>
				// 		</tbody>';
				// }
				// $data[0] .= '</table>';




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
				$data[0] .=
					'<table id="mostraractividades" class="table table-hover" >
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					</tr>
					<tbody></thead>';
				$documentos_pea = $dashboarddoc->listar_actividades($id_usuario, $fecha);
				for ($h = 0; $h < count($documentos_pea); $h++) {
					$nombre_documento = $documentos_pea[$h]["nombre_documento"];
					$descripcion_documento = $documentos_pea[$h]["descripcion_documento"];
					$archivo_documento = $documentos_pea[$h]["archivo_documento"];
					$fecha_actividad = $documentos_pea[$h]["fecha_actividad"];
					$data[0] .= '<tr>
							<th scope="row" class="text-center">' . ($h + 1) . '</th>	
								<td class="text-center">' . $nombre_documento . '</td>
								<td class="text-center">' . $descripcion_documento . '</td>
								<td class="text-center">' . $archivo_documento . '</td>
								<td class="text-center">' . $fecha_actividad . '</td>
							</tr>';
				}
				$data[0] .= '</tbody>
				</table>';
				break;
			case 2:
				$data[0] = "";
				$data[0] .=
					'<table id="mostraractividades" class="table table-hover" >
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					</tr>
					<tbody></thead>';
				$documentos_pea = $dashboarddoc->listar_actividades($id_usuario, $fecha_anterior);
				for ($h = 0; $h < count($documentos_pea); $h++) {
					$nombre_documento = $documentos_pea[$h]["nombre_documento"];
					$descripcion_documento = $documentos_pea[$h]["descripcion_documento"];
					$archivo_documento = $documentos_pea[$h]["archivo_documento"];
					$fecha_actividad = $documentos_pea[$h]["fecha_actividad"];
					$data[0] .= '<tr>
							<th scope="row" class="text-center">' . ($h + 1) . '</th>	
								<td class="text-center">' . $nombre_documento . '</td>
								<td class="text-center">' . $descripcion_documento . '</td>
								<td class="text-center">' . $archivo_documento . '</td>
								<td class="text-center">' . $fecha_actividad . '</td>
							</tr>';
				}
				$data[0] .= '</tbody>
				</table>';
			break;
			case 3:
				$data[0] = "";
				$data[0] .=
					'<table id="mostraractividades" class="table table-hover" >
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					</tr>
					<tbody></thead>';
				$documentos_pea = $dashboarddoc->listar_pea_actividades_semana($id_usuario, $semana);
				for ($h = 0; $h < count($documentos_pea); $h++) {
					$nombre_documento = $documentos_pea[$h]["nombre_documento"];
					$descripcion_documento = $documentos_pea[$h]["descripcion_documento"];
					$archivo_documento = $documentos_pea[$h]["archivo_documento"];
					$fecha_actividad = $documentos_pea[$h]["fecha_actividad"];
					$data[0] .= '<tr>
							<th scope="row" class="text-center">' . ($h + 1) . '</th>	
								<td class="text-center">' . $nombre_documento . '</td>
								<td class="text-center">' . $descripcion_documento . '</td>
								<td class="text-center">' . $archivo_documento . '</td>
								<td class="text-center">' . $fecha_actividad . '</td>
							</tr>';
				}
				$data[0] .= '</tbody>
				</table>';
			break;
			case 4:
				$data[0] = "";
				$data[0] .=
					'<table id="mostraractividades" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					</tr>
					<tbody></thead>';
				$documentos_pea = $dashboarddoc->listar_pea_actividades_semana($id_usuario, $mes_actual);
				for ($h = 0; $h < count($documentos_pea); $h++) {
					$nombre_documento = $documentos_pea[$h]["nombre_documento"];
					$descripcion_documento = $documentos_pea[$h]["descripcion_documento"];
					$archivo_documento = $documentos_pea[$h]["archivo_documento"];
					$fecha_actividad = $documentos_pea[$h]["fecha_actividad"];
					$data[0] .= '<tr>
							<th scope="row" class="text-center">' . ($h + 1) . '</th>	
								<td class="text-center">' . $nombre_documento . '</td>
								<td class="text-center">' . $descripcion_documento . '</td>
								<td class="text-center">' . $archivo_documento . '</td>
								<td class="text-center">' . $fecha_actividad . '</td>
							</tr>';
				}
				$data[0] .= '</tbody>
				</table>';
			break;
			case 5:

				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];

				$data["0"] = "";


				$data[0] .=
					'		
				<table id="mostraractividades" class="table table-hover" style="width:100%">
				<thead>
				<tr>
						<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Descripción </th>
						<th scope="col" class="text-center">Archivo </th>
						<th scope="col" class="text-center">Fecha </th>
					
				</tr>
				</thead><tbody>
				
				';


				$caracterizacion = $dashboarddoc->listar_actividades_por_fecha($id_usuario, $fecha_inicial, $fecha_final);

				for ($h = 0; $h < count($caracterizacion); $h++) {

					$nombre_documento = $caracterizacion[$h]["nombre_documento"];
					$descripcion_documento = $caracterizacion[$h]["descripcion_documento"];
					$archivo_documento = $caracterizacion[$h]["archivo_documento"];
					$fecha_actividad = $caracterizacion[$h]["fecha_actividad"];

					$data[0] .= '
						
						
							<tr>
								<th scope="row">' . ($h + 1) . '</th>
								<td class="text-center">' . $nombre_documento . '</td>
								<td class="text-center">' . $descripcion_documento . '</td>
								<td class="text-center">' . $archivo_documento . '</td>
								<td class="text-center">' . $fecha_actividad . '</td>
							</tr>
						';
				}
				$data[0] .= '</table></tbody>';

			break;

		}
		echo json_encode($data);
	break;

	case 'siguienteclase':

		$siguienteclase = $_GET["siguienteclase"];
		$data = array();
		$data[0] = "";

		switch ($siguienteclase) {
			case 1:

				$data["0"] = "";

				//trae los programas activos de el estudiante en session
				$array = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "viernes", "Sabado");
				$num_dia = date("N", strtotime(date("Y-m-d")));

				$data[0] = "No tienes clases activas ";

				$reg = $dashboarddoc->listargrupos_dia_actual($id_usuario, $array[$num_dia]);

				for ($i = 0; $i < count($reg); $i++) {

					$datosmateriaciafi = $dashboarddoc->materiaDatos($reg[$i]["id_materia"]); // consuta pra traer los datos de la materia
					$nombreMateria = $datosmateriaciafi["nombre"]; // nombre de la materia

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					$id_docente = $reg[$i]["id_docente"];
					$semestre = $reg[$i]["semestre"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					$materia = $nombreMateria;

					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$inicio_clase = $dashboarddoc->horasFormato($hora);
					$hora_inicio = $inicio_clase["formato"];
					// consulta para traer el formato de hasta
					$fin_clase = $reg[$i]["hasta"];
					$diasemana = $reg[$i]["dia"];

					$hora_inicio_materia = date("g:i a", strtotime($hora));
					$hora_final_materia = date("g:i a", strtotime($fin_clase));

					if (strtotime(date("H:i:s")) <= strtotime($hora) || (strtotime(date("H:i:s")) >= strtotime($hora) && strtotime(date("H:i:s")) < strtotime($fin_clase))) {
						$data[0] = '
						<p class="text-secondary small mb-0">' . $array[$num_dia] .' </p>
						<p class="pointer" id="dato_funcionarios" onclick="mostrar_nombre_funcionario()" title="Ver Estudiantes">' . $hora_inicio_materia . ' a ' . $hora_final_materia . '</p>
						<p>' . $nombreMateria .'</p>';
						break;
						
					}
				}


			break;

			case 2:
				$data["0"] = "";

				//trae los programas activos de el estudiante en session
				$array = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "viernes", "Sabado");
				$num_dia = date("N", strtotime(date("Y-m-d")));

				$data[0] = "No tienes clases activas ";

				$reg = $dashboarddoc->listargrupos_dia_actual($id_usuario, $array[$num_dia]);

				for ($i = 0; $i < count($reg); $i++) {

					$datosmateriaciafi = $dashboarddoc->materiaDatos($reg[$i]["id_materia"]); // consuta pra traer los datos de la materia
					$nombreMateria = $datosmateriaciafi["nombre"]; // nombre de la materia

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					$id_docente = $reg[$i]["id_docente"];
					$semestre = $reg[$i]["semestre"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					$materia = $nombreMateria;

					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$inicio_clase = $dashboarddoc->horasFormato($hora);
					$hora_inicio = $inicio_clase["formato"];
					// consulta para traer el formato de hasta
					$fin_clase = $reg[$i]["hasta"];
					$diasemana = $reg[$i]["dia"];

					$hora_inicio_materia = date("g:i a", strtotime($hora));
					$hora_final_materia = date("g:i a", strtotime($fin_clase));

					if (strtotime(date("H:i:s")) <= strtotime($hora) || (strtotime(date("H:i:s")) >= strtotime($hora) && strtotime(date("H:i:s")) < strtotime($fin_clase))) {
						$data[0] = '<br>
					
						' . $nombreMateria . '<br>
						' . $array[$num_dia] . '<br>
						' . $hora_inicio_materia . ' a
						' . $hora_final_materia . '<br>';
						break;
					}
				}
			break;

			case 3:
				$data["0"] = "";

				//trae los programas activos de el estudiante en session
				$array = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "viernes", "Sabado");
				$num_dia = date("N", strtotime(date("Y-m-d")));

				$data[0] = "No tienes clases activas ";

				$reg = $dashboarddoc->listargrupos_dia_actual($id_usuario, $array[$num_dia]);

				for ($i = 0; $i < count($reg); $i++) {

					$datosmateriaciafi = $dashboarddoc->materiaDatos($reg[$i]["id_materia"]); // consuta pra traer los datos de la materia
					$nombreMateria = $datosmateriaciafi["nombre"]; // nombre de la materia

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					$id_docente = $reg[$i]["id_docente"];
					$semestre = $reg[$i]["semestre"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					$materia = $nombreMateria;

					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$inicio_clase = $dashboarddoc->horasFormato($hora);
					$hora_inicio = $inicio_clase["formato"];
					// consulta para traer el formato de hasta
					$fin_clase = $reg[$i]["hasta"];
					$diasemana = $reg[$i]["dia"];

					$hora_inicio_materia = date("g:i a", strtotime($hora));
					$hora_final_materia = date("g:i a", strtotime($fin_clase));

					if (strtotime(date("H:i:s")) <= strtotime($hora) || (strtotime(date("H:i:s")) >= strtotime($hora) && strtotime(date("H:i:s")) < strtotime($fin_clase))) {
						$data[0] = '<br>
					
						' . $nombreMateria . '<br>
						' . $array[$num_dia] . '<br>
						' . $hora_inicio_materia . ' a
						' . $hora_final_materia . '<br>';
						break;
					}
				}
			break;

			case 4:
				$data["0"] = "";

				//trae los programas activos de el estudiante en session
				$array = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "viernes", "Sabado");
				$num_dia = date("N", strtotime(date("Y-m-d")));

				$data[0] = "No tienes clases activas ";

				$reg = $dashboarddoc->listargrupos_dia_actual($id_usuario, $array[$num_dia]);

				for ($i = 0; $i < count($reg); $i++) {

					$datosmateriaciafi = $dashboarddoc->materiaDatos($reg[$i]["id_materia"]); // consuta pra traer los datos de la materia
					$nombreMateria = $datosmateriaciafi["nombre"]; // nombre de la materia

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					$id_docente = $reg[$i]["id_docente"];
					$semestre = $reg[$i]["semestre"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					$materia = $nombreMateria;

					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$inicio_clase = $dashboarddoc->horasFormato($hora);
					$hora_inicio = $inicio_clase["formato"];
					// consulta para traer el formato de hasta
					$fin_clase = $reg[$i]["hasta"];
					$diasemana = $reg[$i]["dia"];

					$hora_inicio_materia = date("g:i a", strtotime($hora));
					$hora_final_materia = date("g:i a", strtotime($fin_clase));

					if (strtotime(date("H:i:s")) <= strtotime($hora) || (strtotime(date("H:i:s")) >= strtotime($hora) && strtotime(date("H:i:s")) < strtotime($fin_clase))) {
						$data[0] = '<br>
					
						' . $nombreMateria . '<br>
						' . $array[$num_dia] . '<br>
						' . $hora_inicio_materia . ' a
						' . $hora_final_materia . '<br>';
						break;
					}
				}

			break;

			case 5:

				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];

				$data["0"] = "";

				//trae los programas activos de el estudiante en session
				$array = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "viernes", "Sabado");
				$num_dia = date("N", strtotime(date("Y-m-d")));

				$data[0] = "No tienes clases activas ";

				$reg = $dashboarddoc->listargrupos_dia_actual($id_usuario, $array[$num_dia]);

				for ($i = 0; $i < count($reg); $i++) {

					$datosmateriaciafi = $dashboarddoc->materiaDatos($reg[$i]["id_materia"]); // consuta pra traer los datos de la materia
					$nombreMateria = $datosmateriaciafi["nombre"]; // nombre de la materia

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					$id_docente = $reg[$i]["id_docente"];
					$semestre = $reg[$i]["semestre"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					$materia = $nombreMateria;

					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$inicio_clase = $dashboarddoc->horasFormato($hora);
					$hora_inicio = $inicio_clase["formato"];
					// consulta para traer el formato de hasta
					$fin_clase = $reg[$i]["hasta"];
					$diasemana = $reg[$i]["dia"];

					$hora_inicio_materia = date("g:i a", strtotime($hora));
					$hora_final_materia = date("g:i a", strtotime($fin_clase));

					if (strtotime(date("H:i:s")) <= strtotime($hora) || (strtotime(date("H:i:s")) >= strtotime($hora) && strtotime(date("H:i:s")) < strtotime($fin_clase))) {
						$data[0] = '<br>
					
						' . $nombreMateria . '<br>
						' . $array[$num_dia] . '<br>
						' . $hora_inicio_materia . ' a
						' . $hora_final_materia . '<br>';
						break;
					}
				}

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
				<table id="mostrarcasoguia" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Dep Origen</th>
					</tr>
					</thead>';

				// $casoquedate=$dashboarddoc->casoquedate($fecha);
				$casoquedate = $dashboarddoc->listarguia($id_usuario, $fecha);
				for ($n = 0; $n < count($casoquedate); $n++) {
					// print_r($casoquedate	);

					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$caso_estado = $casoquedate[$n]["caso_estado"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];

					$data[0] .= '
						
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';

				break;

			case 2:
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrarcasoguia" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Dep Origen</th>
					</tr>
					</thead>';

				$casoquedate = $dashboarddoc->listarguiaayer($id_usuario, $fecha_anterior);
				// print_r($casoquedate);
				for ($n = 0; $n < count($casoquedate); $n++) {

					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$caso_estado = $casoquedate[$n]["caso_estado"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];

					$data[0] .= '
						
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';

				break;

			case 3:
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrarcasoguia" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Dep Origen</th>
					</tr>
					</thead>';

				$casoquedate = $dashboarddoc->listarguiatablasemana($id_usuario, $semana);
				for ($n = 0; $n < count($casoquedate); $n++) {

					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$caso_estado = $casoquedate[$n]["caso_estado"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];

					$data[0] .= '
						
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';
				break;

			case 4:
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrarcasoguia" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Dep Origen</th>
					</tr>
					</thead>';

				$casoquedate = $dashboarddoc->listarguiatablasemana($id_usuario, $mes_actual);
				for ($n = 0; $n < count($casoquedate); $n++) {

					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$caso_estado = $casoquedate[$n]["caso_estado"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];

					$data[0] .= '
						
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';
				break;
			case 5:
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data["0"] = "";
				$data[0] .=
					'		
				<table id="mostrarcasoguia" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Caso Id</th>
						<th scope="col" class="text-center">Asunto</th>
						<th scope="col" class="text-center">Dep Origen</th>
					</tr>
					</thead>';

				// $casoquedate=$dashboarddoc->listarguiatabla($id_usuario,$mes_actual);
				$casoquedate = $dashboarddoc->listarguiarango5($id_usuario, $fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($casoquedate); $n++) {

					$caso_asunto = $casoquedate[$n]["caso_asunto"];
					$caso_estado = $casoquedate[$n]["caso_estado"];
					$caso_id = $casoquedate[$n]["caso_id"];
					$usuario_cargo = $casoquedate[$n]["usuario_cargo"];

					$data[0] .= '
						
						<tbody>
							<tr>
								<th scope="row">' . ($n + 1) . '</th>
								<td class="text-center">' . $caso_id . '</td>
								<td class="text-center">' . $caso_asunto . '</td>
								<td class="text-center">' . $usuario_cargo . '</td>
							</tr>
						</tbody>';
				}
				$data[0] .= '</table>';
				break;
		}

		echo json_encode($data);

	break;

	case 'perfilesactualizados':

		$perfilactualizado = $_GET["perfilactualizado"];
		$data = array();
		$data[0] = "";

		switch ($perfilactualizado) {

			case 1:

				$data[0] = "";

				$data[0] .=
					'		
				<table id="mostrarperfilactualizado" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Fecha</th>
					</tr>
					</thead><tbody>';


				// $perfilactualizado=$dashboarddoc->perfilesactualizados($fecha);

				$docente = $dashboarddoc->perfilactualizadodocente($fecha, $id_usuario);

				for ($n = 0; $n < count($docente); $n++) {

					//Datos personales Docente
					$usuario_nombre_docente = $docente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $docente[$n]["usuario_nombre_2"];
					$usuario_apellido = $docente[$n]["usuario_apellido"];
					$usuario_apellido_2 = $docente[$n]["usuario_apellido_2"];
					$fecha_actualizacion = $docente[$n]["fecha_actualizacion"];

					$data[0] .= '
							
							
								<tr>
									<th scope="row" class="text-center">' . ($n + 1) . '</th>	
									
										<td class="text-center">' . $usuario_nombre_docente . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
										<td>' . $dashboarddoc->fechaespcalendario($fecha_actualizacion) . '</td> 
									</tr>
							';
				}
				$data[0] .= '</tbody></table>';

				break;

			case 2:

				$data[0] = "";

				$data[0] .=
					'		
				<table id="mostrarperfilactualizado" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Fecha</th>
					</tr>
					</thead><tbody>';

				// $perfilactualizado=$dashboarddoc->perfilesactualizados($fecha_anterior);

				$docente = $dashboarddoc->perfilactualizadodocenteayer($fecha_anterior, $id_usuario);
				for ($n = 0; $n < count($docente); $n++) {

					//Datos personales Docente
					$usuario_nombre_docente = $docente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $docente[$n]["usuario_nombre_2"];
					$usuario_apellido = $docente[$n]["usuario_apellido"];
					$usuario_apellido_2 = $docente[$n]["usuario_apellido_2"];
					$fecha_actualizacion = $docente[$n]["fecha_actualizacion"];

					$data[0] .= '
							
							
								<tr>
									<th scope="row" class="text-center">' . ($n + 1) . '</th>	
									
										<td class="text-center">' . $usuario_nombre_docente . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
										<td>' . $dashboarddoc->fechaespcalendario($fecha_actualizacion) . '</td> 
										
									</tr>
							';
				}
				$data[0] .= '</tbody></table>';

				break;

			case 3:

				$data[0] = "";

				$data[0] .=
					'		
				<table id="mostrarperfilactualizado" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Fecha</th>
					</tr>
					</thead><tbody>';

				$docente = $dashboarddoc->perfilactualizadodocente($semana, $id_usuario);

				for ($n = 0; $n < count($docente); $n++) {
					//Datos personales Docente
					$usuario_nombre_docente = $docente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $docente[$n]["usuario_nombre_2"];
					$usuario_apellido = $docente[$n]["usuario_apellido"];
					$usuario_apellido_2 = $docente[$n]["usuario_apellido_2"];
					$fecha_actualizacion = $docente[$n]["fecha_actualizacion"];

					$data[0] .= '
							
							
								<tr>
									<th scope="row" class="text-center">' . ($n + 1) . '</th>	
									
										<td class="text-center">' . $usuario_nombre_docente . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
										<td>' . $dashboarddoc->fechaespcalendario($fecha_actualizacion) . '</td> 
										
									</tr>
							';
				}
				$data[0] .= '</tbody></table>';
				break;

			case 4:

				$data[0] = "";

				$data[0] .=
					'		
				<table id="mostrarperfilactualizado" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Fecha</th>
					</tr>
					</thead><tbody>';

				$docente = $dashboarddoc->perfilactualizadodocente($mes_actual, $id_usuario);
				for ($n = 0; $n < count($docente); $n++) {

					//Datos personales Docente
					$usuario_nombre_docente = $docente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $docente[$n]["usuario_nombre_2"];
					$usuario_apellido = $docente[$n]["usuario_apellido"];
					$usuario_apellido_2 = $docente[$n]["usuario_apellido_2"];
					$fecha_actualizacion = $docente[$n]["fecha_actualizacion"];

					$data[0] .= '
							
							
								<tr>
									<th scope="row" class="text-center">' . ($n + 1) . '</th>	
									
										<td class="text-center">' . $usuario_nombre_docente . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
										<td>' . $dashboarddoc->fechaespcalendario($fecha_actualizacion) . '</td> 
										
									</tr>
							';
				}
				$data[0] .= '</tbody></table>';
				break;

			case 5:
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data[0] = "";

				$data[0] .=
					'		
				<table id="mostrarperfilactualizado" class="table table-hover" style="width:100%">
					<thead>
					<tr>
					<th scope="col" class="text-center">#</th>
						<th scope="col" class="text-center">Nombre</th>
						<th scope="col" class="text-center">Fecha</th>
					</tr>
					</thead><tbody>';

				$docente = $dashboarddoc->perfilactualizadodocenterango($id_usuario, $fecha_inicial, $fecha_final);
				for ($n = 0; $n < count($docente); $n++) {

					//Datos personales Docente
					$usuario_nombre_docente = $docente[$n]["usuario_nombre"];
					$usuario_nombre_2 = $docente[$n]["usuario_nombre_2"];
					$usuario_apellido = $docente[$n]["usuario_apellido"];
					$usuario_apellido_2 = $docente[$n]["usuario_apellido_2"];
					$fecha_actualizacion = $docente[$n]["fecha_actualizacion"];

					$data[0] .= '
						
						
						<tr>
							<th scope="row" class="text-center">' . ($n + 1) . '</th>	
							
								<td class="text-center">' . $usuario_nombre_docente . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2 . '</td>
								<td>' . $dashboarddoc->fechaespcalendario($fecha_actualizacion) . '</td> 	
						</tr>';
				}
				$data[0] .= '</tbody></table>';
				break;
		}

		echo json_encode($data);

	break;

		//Mostramos nombres y cedula de la hoja de vida
	case 'hojadevidanueva':

		$hojasdevidanueva = $_GET["hojasdevidanueva"];
		$data = array();
		$data[0] = "";

		switch ($hojasdevidanueva) {
			case 1:

				$data[0] = "";

				$data[0] .=
					'
				<table id="mostrarhojadevidanueva" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Ultima Actualización</th>
				</tr>
				</thead>';


				$listarhojasdevida = $dashboarddoc->datosDocente($id_usuario);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$usuario_identificacion = $listarhojasdevida["usuario_identificacion"];
				}

				$usuario_cv = $dashboarddoc->usuario_cv($usuario_identificacion);
				$id_usuario_cv = $usuario_cv["id_usuario_cv"];
				$usuario_identificacion = $usuario_cv["usuario_identificacion"];
				$nombre_docente = $usuario_cv["usuario_nombre"] . "" . $usuario_cv["usuario_apellido"];
				$cv_informacion_personal = $dashboarddoc->usuario_cv_personal($id_usuario_cv, $fecha);
				$ultima_actualizacion = $cv_informacion_personal["ultima_actualizacion"];
				$arreglo_fecha = explode(" ", $ultima_actualizacion);


				$data[0] .= '
						
						<tbody>
							<tr>
								<td class="text-center">' . $usuario_identificacion . '</td>
								<td class="text-center">' . $nombre_docente . '</td>
								<td>' . $dashboarddoc->fechaespcalendario($arreglo_fecha[0]) . '</td> 
								</tr>
						</tbody>';


				$data[0] .= '</table>';
				break;

			case 2:
				$data[0] = "";

				$data[0] .=
					'		
				
				<table id="mostrarhojadevidanueva" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
				</tr>
				</thead>';


				$listarhojasdevida = $dashboarddoc->datosDocente($id_usuario);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$usuario_identificacion = $listarhojasdevida["usuario_identificacion"];
				}

				$usuario_cv = $dashboarddoc->usuario_cv($usuario_identificacion);
				$id_usuario_cv = $usuario_cv["id_usuario_cv"];
				$usuario_identificacion = $usuario_cv["usuario_identificacion"];
				$nombre_docente = $usuario_cv["usuario_nombre"] . "" . $usuario_cv["usuario_apellido"];
				$cv_informacion_personal = $dashboarddoc->usuario_cv_personal($id_usuario_cv, $fecha_anterior);
				// $ultima_actualizacion=$cv_informacion_personal["ultima_actualizacion"];
				// print_r($cv_informacion_personal);

				$data[0] .= '
						
						<tbody>
							<tr>
								<td class="text-center">' . $usuario_identificacion . '</td>
								<td class="text-center">' . $nombre_docente . '</td> 
								
								</tr>
						</tbody>';


				$data[0] .= '</table>';

				break;

			case 3:
				$data[0] = "";

				$data[0] .=
					'		
				
				<table id="mostrarhojadevidanueva" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
				</tr>
				</thead>';


				$listarhojasdevida = $dashboarddoc->datosDocente($id_usuario);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$usuario_identificacion = $listarhojasdevida["usuario_identificacion"];
				}

				$usuario_cv = $dashboarddoc->usuario_cv($usuario_identificacion);
				$id_usuario_cv = $usuario_cv["id_usuario_cv"];
				$usuario_identificacion = $usuario_cv["usuario_identificacion"];
				$nombre_docente = $usuario_cv["usuario_nombre"] . "" . $usuario_cv["usuario_apellido"];
				$cv_informacion_personal = $dashboarddoc->usuario_cv_personal($id_usuario_cv, $semana);
				// $ultima_actualizacion=$cv_informacion_personal["ultima_actualizacion"];
				// print_r($cv_informacion_personal);

				$data[0] .= '
						
						<tbody>
							<tr>
								<td class="text-center">' . $usuario_identificacion . '</td>
								<td class="text-center">' . $nombre_docente . '</td>
								</tr>
						</tbody>';


				$data[0] .= '</table>';
				break;

			case 4:
				$data[0] = "";

				$data[0] .=
					'		
				
				<table id="mostrarhojadevidanueva" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
				</tr>
				</thead>';


				$listarhojasdevida = $dashboarddoc->datosDocente($id_usuario);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$usuario_identificacion = $listarhojasdevida["usuario_identificacion"];
				}

				$usuario_cv = $dashboarddoc->usuario_cv($usuario_identificacion);
				$id_usuario_cv = $usuario_cv["id_usuario_cv"];
				$usuario_identificacion = $usuario_cv["usuario_identificacion"];
				$nombre_docente = $usuario_cv["usuario_nombre"] . "" . $usuario_cv["usuario_apellido"];
				$cv_informacion_personal = $dashboarddoc->usuario_cv_personal($id_usuario_cv, $mes_actual);
				// $ultima_actualizacion=$cv_informacion_personal["ultima_actualizacion"];
				// print_r($cv_informacion_personal);

				$data[0] .= '
						
						<tbody>
							<tr>
								<td class="text-center">' . $usuario_identificacion . '</td>
								<td class="text-center">' . $nombre_docente . '</td>
								</tr>
						</tbody>';


				$data[0] .= '</table>';
				break;

			case 5:
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];

				$data[0] = "";

				$data[0] .=
					'		
				
				<table id="mostrarhojadevidanueva" class="table table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col" class="text-center">Cédula</th>
					<th scope="col" class="text-center">Nombre</th>
				</tr>
				</thead>';


				$listarhojasdevida = $dashboarddoc->datosDocente($id_usuario);
				for ($n = 0; $n < count($listarhojasdevida); $n++) {
					$usuario_identificacion = $listarhojasdevida["usuario_identificacion"];
				}

				$usuario_cv = $dashboarddoc->usuario_cv($usuario_identificacion);
				$id_usuario_cv = $usuario_cv["id_usuario_cv"];
				$usuario_identificacion = $usuario_cv["usuario_identificacion"];
				$nombre_docente = $usuario_cv["usuario_nombre"] . "" . $usuario_cv["usuario_apellido"];
				$cv_informacion_personal = $dashboarddoc->usuario_cv_personal_rango($id_usuario_cv, $fecha_inicial, $fecha_final);

				// print_r($cv_informacion_personal);

				$data[0] .= '
						
						<tbody>
							<tr>
								<td class="text-center">' . $usuario_identificacion . '</td>
								<td class="text-center">' . $nombre_docente . '</td>
								
								</tr>
						</tbody>';


				$data[0] .= '</table>';
				break;
		}

		echo json_encode($data);

	break;

	case 'estudiantesacargo':

		$estudiantesacargo = $_GET["estudiantesacargo"];
		// $data= array();
		$data[0] = "";

		switch ($estudiantesacargo) {

			case 1:
				$data["0"] .= '
							<table id="datosusuario_cargo" class="table table-hover" style="width:100%">
							<thead>
							<tr>
								<th scope="col" class="text-center">Nombre</th>
								<th scope="col" class="text-center">Cédula</th>
								<th scope="col" class="text-center">Materia</th>
							</tr>
							</thead><tbody>
						';
				$reg = $dashboarddoc->listargrupos($id_usuario);
				// print_r($reg);
				for ($i = 0; $i < count($reg); $i++) {
					// print_r($reg);
					$id_materia = $reg[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $reg[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($reg[$i]["id_docente_grupo"]);

					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];
					//con la variables recolectadas, listamos los estudiantes

					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias 
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);
					for ($j = 0; $j < count($listar_materias); $j++) {

						//listamos los estudiantes por materia
						$estudiante_id = $dashboarddoc->id_estudiante($listar_materias[$j]["id_estudiante"]);
						$id_credencial = $estudiante_id["id_credencial"];
						$datos_estudiante = $dashboarddoc->estudiante_datos($id_credencial);
						$nombre_estudiante = $datos_estudiante["credencial_apellido"] . ' ' . $datos_estudiante["credencial_apellido_2"] . ' ' . $datos_estudiante["credencial_nombre"] . ' ' . $datos_estudiante["credencial_nombre_2"];
						$credencial_identificacion = $datos_estudiante["credencial_identificacion"];

						$data[0] .= '
					
						<tr>
							<td class="text-center">' . $nombre_estudiante . '</td>
							<td class="text-center">' . $credencial_identificacion . '</td>
							<td class="text-center">' . $materia . '</td>
						</tr>
					';
					}
				}

				$data[0] .= '</tbody></table>';


				break;

			case 2:
				$data["0"] .= '
						<table id="datosusuario_cargo" class="table table-hover" style="width:100%">
							<thead>
							<tr>
								<th scope="col" class="text-center">Nombre</th>
								<th scope="col" class="text-center">Cédula</th>
								<th scope="col" class="text-center">Materia</th>
							</tr>
							</thead><tbody>
						';
				$reg = $dashboarddoc->listargrupos($id_usuario);
				for ($i = 0; $i < count($reg); $i++) {
					$id_materia = $reg[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $reg[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($reg[$i]["id_docente_grupo"]);
					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];
					//con la variables recolectadas, listamos los estudiantes

					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias 
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);
					for ($j = 0; $j < count($listar_materias); $j++) {

						//listamos los estudiantes por materia
						$estudiante_id = $dashboarddoc->id_estudiante($listar_materias[$j]["id_estudiante"]);
						$id_credencial = $estudiante_id["id_credencial"];
						$datos_estudiante = $dashboarddoc->estudiante_datos($id_credencial);
						$nombre_estudiante = $datos_estudiante["credencial_apellido"] . ' ' . $datos_estudiante["credencial_apellido_2"] . ' ' . $datos_estudiante["credencial_nombre"] . ' ' . $datos_estudiante["credencial_nombre_2"];
						$credencial_identificacion = $datos_estudiante["credencial_identificacion"];

						$data[0] .= '
					
					
						<tr>
							<td class="text-center">' . $nombre_estudiante . '</td>
							<td class="text-center">' . $credencial_identificacion . '</td>
							<td class="text-center">' . $materia . '</td>
						</tr>
					';
					}
				}

				$data[0] .= '</tbody></table>';
				break;

			case 3:

				$data["0"] .= '
							<table id="datosusuario_cargo" class="table table-hover" style="width:100%">
							<thead>
							<tr>
								<th scope="col" class="text-center">Nombre</th>
								<th scope="col" class="text-center">Cédula</th>
								<th scope="col" class="text-center">Materia</th>
							</tr>
							</thead><tbody>
						';
				$reg = $dashboarddoc->listargrupos($id_usuario);
				for ($i = 0; $i < count($reg); $i++) {
					$id_materia = $reg[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $reg[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($reg[$i]["id_docente_grupo"]);
					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];
					//con la variables recolectadas, listamos los estudiantes

					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias 
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);
					for ($j = 0; $j < count($listar_materias); $j++) {

						//listamos los estudiantes por materia
						$estudiante_id = $dashboarddoc->id_estudiante($listar_materias[$j]["id_estudiante"]);
						$id_credencial = $estudiante_id["id_credencial"];
						$datos_estudiante = $dashboarddoc->estudiante_datos($id_credencial);
						$nombre_estudiante = $datos_estudiante["credencial_apellido"] . ' ' . $datos_estudiante["credencial_apellido_2"] . ' ' . $datos_estudiante["credencial_nombre"] . ' ' . $datos_estudiante["credencial_nombre_2"];
						$credencial_identificacion = $datos_estudiante["credencial_identificacion"];

						$data[0] .= '
					
					
						<tr>
							<td class="text-center">' . $nombre_estudiante . '</td>
							<td class="text-center">' . $credencial_identificacion . '</td>
							<td class="text-center">' . $materia . '</td>
						</tr>
					';
					}
				}

				$data[0] .= '</tbody></table>';
				break;

			case 4:
				$data["0"] .= '
							<table id="datosusuario_cargo" class="table table-hover" style="width:100%">
							<thead>
							<tr>
								<th scope="col" class="text-center">Nombre</th>
								<th scope="col" class="text-center">Cédula</th>
								<th scope="col" class="text-center">Materia</th>
							</tr>
							</thead><tbody>
						';
				$reg = $dashboarddoc->listargrupos($id_usuario);
				for ($i = 0; $i < count($reg); $i++) {
					$id_materia = $reg[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $reg[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($reg[$i]["id_docente_grupo"]);
					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];
					//con la variables recolectadas, listamos los estudiantes

					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias 
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);
					for ($j = 0; $j < count($listar_materias); $j++) {

						//listamos los estudiantes por materia
						$estudiante_id = $dashboarddoc->id_estudiante($listar_materias[$j]["id_estudiante"]);
						$id_credencial = $estudiante_id["id_credencial"];
						$datos_estudiante = $dashboarddoc->estudiante_datos($id_credencial);
						$nombre_estudiante = $datos_estudiante["credencial_apellido"] . ' ' . $datos_estudiante["credencial_apellido_2"] . ' ' . $datos_estudiante["credencial_nombre"] . ' ' . $datos_estudiante["credencial_nombre_2"];
						$credencial_identificacion = $datos_estudiante["credencial_identificacion"];

						$data[0] .= '
					
					
						<tr>
							<td class="text-center">' . $nombre_estudiante . '</td>
							<td class="text-center">' . $credencial_identificacion . '</td>
							<td class="text-center">' . $materia . '</td>
						</tr>
					';
					}
				}

				$data[0] .= '</tbody></table>';
				break;

			case 5:
				$fecha_inicial = $_GET["fecha_inicial"];
				$fecha_final = $_GET["fecha_final"];
				$data["0"] .= '
							<table id="datosusuario_cargo" class="table table-hover" style="width:100%">
							<thead>
							<tr>
								<th scope="col" class="text-center">Nombre</th>
								<th scope="col" class="text-center">Cédula</th>
								<th scope="col" class="text-center">Materia</th>
							</tr>
							</thead><tbody>
						';
				$reg = $dashboarddoc->listargrupos($id_usuario);
				for ($i = 0; $i < count($reg); $i++) {
					$id_materia = $reg[$i]["id_materia"];

					// contiene el ciclo del programa
					$id_docente_grupo = $reg[$i]["id_docente_grupo"];
					// contiene el ciclo del programa
					$ciclo = $reg[$i]["ciclo"];
					// contiene la materia
					// $materia = $nombreMateria;
					// contiene el id del programa
					$id_programa = $reg[$i]["id_programa"];
					// contiene la variable del grupo
					$grupo = $reg[$i]["grupo"];
					// consulta para traer el nombre del programa
					$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
					// contiene el nombre de la jornada
					$jornada = $reg[$i]["jornada"];
					// consulta para traer el nombre del programa
					$rsptajornada = $dashboarddoc->jornada($jornada);
					// consulta para traer el formato de la hora
					$hora = $reg[$i]["hora"];
					$rsptahora = $dashboarddoc->horasFormato($hora);
					// consulta para traer el formato de hasta
					$hasta = $reg[$i]["hasta"];
					$rsptahasta = $dashboarddoc->horasFormato($hasta);

					$listarelgrupo = $dashboarddoc->listarelgrupo($reg[$i]["id_docente_grupo"]);
					// para saber a que tabla consultar
					$ciclo = $listarelgrupo["ciclo"];
					// materia docente
					$id_materia = $listarelgrupo["id_materia"];
					// jornada de la materia
					$jornada = $listarelgrupo["jornada"];
					// programa de la materia
					$id_programa = $listarelgrupo["id_programa"];
					// grupo del programa de la materia
					$grupo = $listarelgrupo["grupo"];
					// semestre del programa de la materia
					$semestre = $listarelgrupo["semestre"];
					//con la variables recolectadas, listamos los estudiantes

					$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
					$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

					//se traen las materias 
					$listar_materias = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);
					for ($j = 0; $j < count($listar_materias); $j++) {

						//listamos los estudiantes por materia
						$estudiante_id = $dashboarddoc->id_estudiante($listar_materias[$j]["id_estudiante"]);
						$id_credencial = $estudiante_id["id_credencial"];
						$datos_estudiante = $dashboarddoc->estudiante_datos($id_credencial);
						$nombre_estudiante = $datos_estudiante["credencial_apellido"] . ' ' . $datos_estudiante["credencial_apellido_2"] . ' ' . $datos_estudiante["credencial_nombre"] . ' ' . $datos_estudiante["credencial_nombre_2"];
						$credencial_identificacion = $datos_estudiante["credencial_identificacion"];

						$data[0] .= '
					
					
						<tr>
							<td class="text-center">' . $nombre_estudiante . '</td>
							<td class="text-center">' . $credencial_identificacion . '</td>
							<td class="text-center">' . $materia . '</td>
						</tr>
					';
					}
				}

				$data[0] .= '</tbody></table>';
				break;
		}

		echo json_encode($data);
		// echo set_template($nombre_estudiante,$materia);

	break;

	case 'listarrango':
		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];

		$data = array();
		$data["totalingresos"] = "";
		$data["totalfaltas"] = "";
		$data["totalactividades"] = "";
		$data["totalguia"] = "";
		$data["totalperfilactualizado"] = "";
		$data["totalusuariohojadevida"] = "";
		$data["totalestudiantesacargo"] = "";

		$rspta1 = $dashboarddoc->listaringresosrango($id_usuario, $fecha_inicial, $fecha_final);
		$rspta2 = $dashboarddoc->listarfaltasrango($id_usuario, $fecha_inicial, $fecha_final);
		$rspta3 = $dashboarddoc->listar_actividades_por_fecha($id_usuario, $fecha_inicial, $fecha_final);
		$rspta4 = $dashboarddoc->listarguiarango($id_usuario, $fecha_inicial, $fecha_final);
		$rspta5 = $dashboarddoc->perfilactualizadodocenterango($id_usuario, $fecha_inicial, $fecha_final);
		$rspta6 = $dashboarddoc->usuariohojadevidarango($fecha_inicial, $fecha_final);

		$reg = $dashboarddoc->listargrupos($id_usuario);
		for ($i = 0; $i < count($reg); $i++) {
			$id_materia = $reg[$i]["id_materia"];

			// $datosmateriaciafi=$dashboarddoc->MateriaDatos($id_materia);// consuta pra traer los datos de la materia
			// $nombreMateria=$datosmateriaciafi["nombre"];// nombre de la materia
			// contiene el ciclo del programa
			$id_docente_grupo = $reg[$i]["id_docente_grupo"];
			// contiene el ciclo del programa
			$ciclo = $reg[$i]["ciclo"];
			// contiene la materia
			// $materia = $nombreMateria;
			// contiene el id del programa
			$id_programa = $reg[$i]["id_programa"];
			// contiene la variable del grupo
			$grupo = $reg[$i]["grupo"];
			// consulta para traer el nombre del programa
			$rsptaprograma = $dashboarddoc->programaacademico($id_programa);
			// contiene el nombre de la jornada
			$jornada = $reg[$i]["jornada"];
			// consulta para traer el nombre del programa
			$rsptajornada = $dashboarddoc->jornada($jornada);
			// consulta para traer el formato de la hora
			$hora = $reg[$i]["hora"];
			$rsptahora = $dashboarddoc->horasFormato($hora);
			// consulta para traer el formato de hasta
			$hasta = $reg[$i]["hasta"];
			$rsptahasta = $dashboarddoc->horasFormato($hasta);

			$listarelgrupo = $dashboarddoc->listarelgrupo($reg[$i]["id_docente_grupo"]);
			// para saber a que tabla consultar
			$ciclo = $listarelgrupo["ciclo"];
			// materia docente
			$id_materia = $listarelgrupo["id_materia"];
			// jornada de la materia
			$jornada = $listarelgrupo["jornada"];
			// programa de la materia
			$id_programa = $listarelgrupo["id_programa"];
			// grupo del programa de la materia
			$grupo = $listarelgrupo["grupo"];
			// semestre del programa de la materia
			$semestre = $listarelgrupo["semestre"];
			//con la variables recolectadas, listamos los estudiantes

			$datosmateriaciafi = $dashboarddoc->MateriaDatos($id_materia); // consuta pra traer los datos de la materia
			$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

			//se traen las materias 
			$reg = $dashboarddoc->listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo);
			for ($i = 0; $i < count($reg); $i++) {

				//listamos los estudiantes por materia
				$estudiantes = $dashboarddoc->id_estudiante($reg[$i]["id_estudiante"]);
			}
		}



		$totalingresos = count($rspta1);
		$totalfaltas = count($rspta2);
		$totalactividades = count($rspta3);
		$totalguia = count($rspta4);
		$totalperfilactualizado = count($rspta5);
		$totalusuariohojadevida = count($rspta6);
		$totalestudiantesacargo = count($reg);

		$data["totalingresos"] .= $totalingresos;
		$data["totalfaltas"] .= $totalfaltas;
		$data["totalactividades"] .= $totalactividades;
		$data["totalguia"] .= $totalguia;
		$data["totalperfilactualizado"] .= $totalperfilactualizado;
		$data["totalestudiantesacargo"] .= $totalestudiantesacargo;


		echo json_encode($data);

	break;

	case 'listardatosfijos':

		$data = array();
		$data["perfilactualizado"] = "";
		$data["cvactualizado"] = "";

		$rspta1 = $dashboarddoc->fechaperfilactualizado($id_usuario);

		$perfilactualizado = $rspta1["fecha_actualizacion"];
		$fechaperfilactualizado = $dashboarddoc->fechaesp($perfilactualizado);

		$listarhojasdevida = $dashboarddoc->datosDocente($id_usuario);
		for ($n = 0; $n < count($listarhojasdevida); $n++) {
			$usuario_identificacion = $listarhojasdevida["usuario_identificacion"];
		}
		$usuario_cv = $dashboarddoc->usuario_cv($usuario_identificacion);
		$id_usuario_cv = $usuario_cv["id_usuario_cv"];
		$cv_informacion_personal = $dashboarddoc->usuario_cv_personal($id_usuario_cv, $fecha);
		$ultima_actualizacion = $cv_informacion_personal["ultima_actualizacion"];

		$actualizacion_hoja_de_vida = $dashboarddoc->fechaesp($ultima_actualizacion);
		$data["perfilactualizado"] .= '<p class="text-secondary small mb-0">Actualización perfil</p>
										<p class="">'.$fechaperfilactualizado.'</p>
										<p class="text-secondary small mb-0">Fecha Caracterización</p>
										<p class="">'.$fechaperfilactualizado.'</p>';
		$data["cvactualizado"] .= $actualizacion_hoja_de_vida;



		echo json_encode($data);

	break;


	case 'encuestatic':
		$valor = "-";
		if ($_SESSION['usuario_cargo'] == "Docente") {
			$rspta = $dashboarddoc->encuestatic($id_usuario, $periodo_actual);
			if ($rspta == true) {
				$valor = 1;
			} else {
				$valor = 0;
			}
		}
		echo json_encode($valor);

	break;

	case 'encuestaticnueva':
		$valor = "-";
		if ($_SESSION['usuario_cargo'] == "Docente") {
			$rspta = $dashboarddoc->encuestaticpreguntas($id_usuario, $periodo_actual);
			$totalrespuestas = count($rspta) + 1;
			if ($totalrespuestas == 45) {
				$valor = 1;
			} else {
				$valor = 0;
			}
		}
		echo json_encode($valor);

	break;

	case 'encuestaticpreguntas':
		$data = array();
		$data["totalpregunta"] = "";
		$data["pregunta"] = "";
		$data["avancepregunta"] = "";



		$rspta = $dashboarddoc->encuestaticpreguntas($id_usuario, $periodo_actual);
		$totalrespuestas = count($rspta) + 1;
		$data["totalpregunta"] .= count($rspta);


		$traerpregunta = $dashboarddoc->traerpregunta($totalrespuestas);
		$pregunta = $traerpregunta["pregunta"];

		$porcentaje = ($totalrespuestas * 100) / 45;

		$data["avancepregunta"] .= '
			<span class="float-right badge bg-primary">' . $totalrespuestas . '/45</span><br>
			<div style="padding-top:5px">
				<div class="progress progress-xs"><div class="progress-bar bg-success" style="width: ' . $porcentaje . '%"></div></div>' . round($porcentaje, 0) . ' %
			</div><hr>';

		$data["pregunta"] .= $pregunta;

		echo json_encode($data);

	break;

	case 'guardarencuestatic':
		$data = array();
		$valor = "";

		$rspta = $dashboarddoc->encuestaticpreguntas($id_usuario, $periodo_actual);
		$id_pregunta = count($rspta) + 1;

		$rspta = $dashboarddoc->insertarencuestatic($id_usuario, $fecha, $hora, $periodo_actual, $id_pregunta, $er1);
		if ($rspta == true) {
			$valor = 1;
		} else {
			$valor = 0;
		}

		echo json_encode($valor);
	break;

	case 'iniciarcalendario':

		$impresion = "";

		$traerhorario = $dashboarddoc->listarcalendarioacademico($fecha);
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

	case 'porcentaje_evaluacion':
		$sumar_promedio = 0;
		$promedio_total = 0;
		$id_docente = $_SESSION["id_usuario"];
		$docente_grupos = $dashboarddoc->listarGruposPeriodo($id_docente, $periodo_actual);
		for ($j = 0; $j < count($docente_grupos); $j++) {
			$promedio = $dashboarddoc->listarResultados($docente_grupos[$j]['id_docente_grupo'], $periodo_actual);
			if (is_array($promedio) && count($promedio) > 0) {
				if (!empty($promedio["promedio"]) || !$promedio["promedio"] == 0) {
					$sumar_promedio += $promedio["promedio"];
					$promedio_total += 1;
				}
			}
		}
		$promedio_total = ($promedio_total == 0) ? 1 : $promedio_total;
		$porcentaje = $sumar_promedio / $promedio_total;

		if ($porcentaje > 90) {
			$color = "text-success ";
			$icono = "far fa-grin-stars fa-3x";
		} else if ($porcentaje > 80) {
			$color = "text-orange ";
			$icono = "far fa-grin fa-3x";
		} else if ($porcentaje > 70) {
			$color = "text-warning ";
			$icono = "far fa-meh fa-3x";
		} else {
			$color = "text-danger";
			$icono = "far fa-meh fa-3x";
		}

		
		$promedio_final = round(($sumar_promedio / $promedio_total), 2);
		$data = array('exito' => 1, "promedio_final" => $promedio_final, "promedio_icono" => $icono, "promedio_color" => $color);
		//se crea otro array para almacenar toda la informacion que analizara el datatable
		echo json_encode($data);
	break;

	case 'comentarios_heteroevaluacion':
		$id_docente = $_SESSION["id_usuario"];
		$comentario = $dashboarddoc->listarComentarios($id_docente, $periodo_actual);
		//echo $periodo_actual;
		$tabla_comentarios = '<div class="col-12"> 
                <table class="table table-hover " id="tabla_comentarios" style="width:100%">
                    <thead>
                        <th class="text-center">Comentarios</th>
                    </thead>';
		for ($f = 0; $f < count($comentario); $f++) {
			$tabla_comentarios .= '<tr> <td> ' . $comentario[$f]["p23"] . ' </td> </tr>';
		}
		$tabla_comentarios .= '</tbody>
                </table>
            </div>';
		echo $tabla_comentarios;
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

			$fecha_actual_eventos = date("Y-m-d");
			$data[0] .= '<div class="academico">';
				// imprime las actividades del calendario 
				$cuenta=0;
				$eventosacademicos = $dashboarddoc->traercalendario($anio_actual . "-" . $check);
				if($eventosacademicos){
					
				
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
											<div class="col-12 fs-14">' . $meses . ' ' . $anio_final . '</div>
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

			if($cuenta==0){
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

							<p class="small text-secondary">Publicado: <span class="float-end">'.$fecha.'</span></p>
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
				$eventos = $dashboarddoc->listarEventos($anio_actual . "-" . $check,$fecha_actual_eventos);
				$cuantos=count($eventos);
	
				if($cuantos==0){
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
	
								<p class="small text-secondary">Publicado: <span class="float-end">'.$fecha.'</span></p>
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
						
						$actividad_pertenece = $dashboarddoc->selectActividadActiva($eventos[$d]["id_actividad"], $check);
						
	
						if($cuantos <= 2){ //si tenemos menos de dos eventos
	
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
	
						}else{// si tenemos mas de dos eventos
	
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
				$eventosacademicos = $dashboarddoc->traercalendario($anio_actual . "-" . $check,$fecha_actual_eventos);
	
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
				$eventos = $dashboarddoc->listarEventos($anio_actual . "-" . $check,$fecha_actual_eventos);
	
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
	
					$actividad_pertenece = $dashboarddoc->selectActividadActiva($eventos[$d]["id_actividad"], $check);
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
						
							$respuesta = $dashboarddoc->mostrarElementos();
							for ($i = 0; $i < count($respuesta); $i++) {
								
								$data['conte'] .='
								
									<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 ">
										<div class="card   direct-chat direct-chat-primary p-2">
											<div class="contenedor-img ejemplo-1">
												<div class="d-flex justify-content-center mx-auto d-block align-items-center bg-white rounded" style="height:100px">
													<img src="../public/img/software_libre/'.$respuesta[$i]["ruta_img"].'" style="width: 100%; max-height: 100%;" alt="'.$respuesta[$i]["nombre"].'">
												</div>
												<div class="col-12 mt-2" style="height:60px">

													<span class="titulo-2 fs-12 text-semibold text-center line-height-16"><b>'.$respuesta[$i]["nombre"].'</b></span>  
												</div>
												<div class="col-12 text-center">
														<a href="'.$respuesta[$i]["url"].'" class="btn btn-outline-primary btn-xs" target="_blank">Leer más</a>
												</div>
											</div>
										</div>
									';
									$i++;
									$data['conte'] .='
								
									
										<div class="card   direct-chat direct-chat-primary p-2">
											<div class="contenedor-img ejemplo-1">
												<div class="d-flex justify-content-center mx-auto d-block align-items-center bg-white rounded" style="height:100px">
													<img src="../public/img/software_libre/'.$respuesta[$i]["ruta_img"].'" style="width: 100%; max-height: 100%;" alt="'.$respuesta[$i]["nombre"].'">
												</div>
												<div class="col-12 mt-2" style="height:60px"> 
													<span class="titulo-2 fs-12 text-semibold text-center line-height-16"><b>'.$respuesta[$i]["nombre"].'</b></span>  
												</div>
												<div class="col-12 text-center">
														<a href="'.$respuesta[$i]["url"].'" class="btn btn-outline-primary btn-xs" target="_blank">Leer más</a>
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
						$respuesta = $dashboarddoc->mostrarshopping();
						for ($i = 0; $i < count($respuesta); $i++) {
							$data['vershopping'] .='

							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
								<div class="row h-100 tono-3 mr-1 rounded justify-content-center pb-2">
									<div class="col-12 m-0 p-3">
										<div class="d-flex justify-content-center mx-auto d-block align-items-center">
											<img src="../files/shopping/'.$respuesta[$i]["shopping_img"].'" class="rounded" style="width: 100%; height: 200px" alt="'.$respuesta[$i]["shopping_img"].'">
										</div>
										<div class="col-12 mt-2 d-flex align-items-center justify-content-center" style="height:60px">
											<p class="fs-14 text-center text-semibold line-height-16 titulo-2">'.$respuesta[$i]["shopping_nombre"].'</p>  
										</div>
									</div>

									<div class="col-4 bg-primary p-2 text-center">';
										if($respuesta[$i]["shopping_facebook"]!=""){
											$data['vershopping'] .= '<a href="'.$respuesta[$i]["shopping_facebook"].'" target="_blank"><i class="fa-brands fa-facebook-f "></i></a>';

										}else{
											$data['vershopping'] .= ' <i class="fa-brands fa-facebook-f  text-primary"></i>';
										}

										$data['vershopping'] .='
									
									</div>
									<div class="col-4 bg-info p-2 text-center">';
										if($respuesta[$i]["shopping_instagram"]!=""){
											$data['vershopping'] .= '<a href="'.$respuesta[$i]["shopping_instagram"].'" target="_blank"><i class="fa-brands fa-instagram "></i></a>';

										}else{
											$data['vershopping'] .= ' <i class="fa-brands fa-instagram  text-info"></i>';
										}

										$data['vershopping'] .='
									
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


	case "graficoingreso":
        $data["datosuno"] = array();
        for ($i = 0; $i <= 14; $i++) {//15 son los dias de consulta$
          	$fecha_consulta=date("Y-m-d",strtotime($fecha_rango."+" .$i. "days"));  
			$id_usuario= $_SESSION["id_usuario"];
			$roll = "Docente";

            $listaingresos = $dashboarddoc->DocenteIngresos($fecha_consulta,$id_usuario,$roll);
			
            $fecha_enviar = new DateTime($fecha_consulta);
            $fecha_actual_iso = $fecha_enviar->format('c');
            $data["datosuno"][] = array("x" => $fecha_actual_iso, "y" => count($listaingresos) );
        }
        echo json_encode($data);
    break;
	
	
}

