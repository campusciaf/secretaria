<?php
session_start();
require_once "../modelos/CuentaDocente.php";

$cuenta_docente = new CuentaDocente();
$periodo_actual = $_SESSION['periodo_actual'];
date_default_timezone_set("America/Bogota");
$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('h:i:sa');

switch ($_GET["op"]) {

	case 'listar':
		$cargar_informacion = $cuenta_docente->listar();
		$data = array();
		$reg = $cargar_informacion;

		$rsptaperiodo = $cuenta_docente->periodoactual();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		for ($i = 0; $i < count($reg); $i++) {
			$usuario_identificacion_contrato = $reg[$i]['usuario_identificacion'];

			if (file_exists("../files/docentes/" . $reg[$i]["usuario_identificacion"] . ".jpg")) {
				$img = "../files/docentes/" . $reg[$i]["usuario_identificacion"] . ".jpg";
			} else {
				$img = "../files/null.jpg";
			}
			$usuario_cargo = $cuenta_docente->MostrarCargoDocentes($usuario_identificacion_contrato,$periodo_actual);
			if ($usuario_cargo) {
				$ultimo_contrato = $usuario_cargo['tipo_contrato'];
			} else {
				$ultimo_contrato = ''; 
			}
			$data[] = array(
				"0" => "<img src='" . $img . "' height='40px' width='40px' >",
				"1" => $reg[$i]["usuario_identificacion"],
				"2" => strtoupper($reg[$i]["usuario_apellido"]) . " " . strtoupper($reg[$i]["usuario_apellido_2"]),
				"3" => strtoupper($reg[$i]["usuario_nombre"]) . " " . strtoupper($reg[$i]["usuario_nombre_2"]),
				"4" => '<div class="tooltips">' . $reg[$i]["usuario_celular"] . '<span class="tooltiptext">' . $reg[$i]["usuario_telefono"] . ' ' . $reg[$i]["usuario_celular"] . '</span></div>',
				"5" => '<div class="tooltips">' . $reg[$i]["usuario_email_p"] . '<span class="tooltiptext">' . $reg[$i]["usuario_email_p"] . ' ' . $reg[$i]["usuario_email_ciaf"] . '</span></div>',
				"6" => $ultimo_contrato,
				"7" => '<div class="btn-group">
						<button class="btn btn-primary btn-xs" onclick="listarGrupos(' . $reg[$i]["id_usuario"] . ')" title="Listar Grupos">Grupos</button>
						<button class="btn btn-info btn-xs" onclick="iniciarcalendario(' . $reg[$i]["id_usuario"] . ')">Horario</button>
				</div>'


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

	case 'cargarOpciones':
		$id_docente = $_POST['id_docente'];
		// Cargar grupos que tenga el docente en el periodo Actual
		$cargar_grupos = $cuenta_docente->cargarGrupos($id_docente, $periodo_actual);
		// Declaramos un array
		$data = array();
		$reg = $cargar_grupos;
		// Bucle para recorrer el resultado y almacenarlo en un array
		for ($i = 0; $i < count($reg); $i++) {
			// Cargar los datos del programa
			$id_programa = $reg[$i]['id_programa'];
			$cargar_programa = $cuenta_docente->cargarPrograma($id_programa);
			$id_materia = $reg[$i]['id_materia'];
			$datomateria = $cuenta_docente->datosmateria($id_materia);
			$nombre_materia = $datomateria["nombre"];

			$info = $cargar_programa;
			$ciclo = $reg[$i]['ciclo'];
			$id_programa = $reg[$i]['id_programa'];
			$grupo = $reg[$i]['grupo'];
			$data[] = array(
				"jornada" => $reg[$i]['jornada'],
				"materia" => $nombre_materia,
				"id_docente_grupo" => $reg[$i]['id_docente_grupo'],
				"nombre_programa" => $info['nombre']
			);
		}
		echo json_encode($data);
		break;

	case 'listarEstudiantes':
		$id_docente_grupo = $_POST['grupo_seleccionado'];
		$cargar_grupo = $cuenta_docente->cargarPrograma2($id_docente_grupo);
		$info_grupo = $cargar_grupo;

		$id_materia = $info_grupo["id_materia"]; // materia docente

		$datomateria = $cuenta_docente->datosmateria($id_materia);
		$materia = $datomateria["nombre"];


		$id = $info_grupo["id_docente"]; // id del docente
		$ciclo = $info_grupo["ciclo"]; // materia docente
		$jornada = $info_grupo["jornada"]; // jornada de la materia
		$id_programa = $info_grupo["id_programa"]; // programa de la materia
		$grupo = $info_grupo["grupo"]; // grupo del programa de la materia

		$listar_estudiantes = $cuenta_docente->listarEstudiantes($ciclo, $materia, $jornada, $id_programa, $grupo);
		$info_estudiantes = $listar_estudiantes;
		$estado = "";
		$cargar_programa = $cuenta_docente->cargarPrograma($id_programa);
		$info = $cargar_programa;
		$cortes = $info['cortes'];
		$inicio_cortes = 1;
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		// Imprimimos la tabla que listará a los estudiantes
		$data["0"] .= '<h3 class=" text-center">' . $materia . '</h3>';

		$data["0"] .= '<table id="estudiantes_grupo" class="table table-sm compact" style="width:100%">
			<thead>
				<tr>
					<th>Estado</th>
				   <th>Identificación</th>
				   <th>Apellidos</th>
				   <th>Nombre</th>
				   <th>Correo CIAF</th>
				   <th>Faltas</th>';
		while ($inicio_cortes <= $cortes) {
			$data["0"] .= '<th>C' . $inicio_cortes . '</th>';
			$inicio_cortes++;
		}
		$data["0"] .= '<th>Final</th>
			</tr>
		</thead>
		<tbody>';
		$num_id = 1;
		for ($i = 0; $i < count($info_estudiantes); $i++) {
			$datos_estudiante = $cuenta_docente->id_estudiante($info_estudiantes[$i]["id_estudiante"]);
			$id_credencial = $datos_estudiante["id_credencial"];
			$habeas_carac = $cuenta_docente->est_carac_habeas($id_credencial);
			if (empty($habeas_carac)) {
				$caracterizado = "<span class='badge bg-orange'>No</span>";
			} else {
				$caracterizado = "<span class='badge bg-navy'>Si</span>";
			}
			$datos_credencial = $cuenta_docente->estudiante_datos($id_credencial);
			if (file_exists('../files/estudiantes/' . $datos_credencial["credencial_identificacion"] . '.jpg')) {
				$foto = '<img src=../files/estudiantes/' . $datos_credencial["credencial_identificacion"] . '.jpg width=40px height=40px>';
			} else {
				$foto = '<img src=../files/null.jpg width=40px height=40px>';
			}
			if ($datos_estudiante["estado"] == 1) {
				$estado = "<span class='badge badge-success'>Activo</span>";
			} else {
				$estado = "<span class='badge badge-warning'>Inactivo</span>";
			}
			$data["0"] .= '<tr>
				<td>' . $estado . ' ' . $caracterizado . '</td>
				<td><input type="hidden" value="' . $materia . '" id="materia">' . $foto . '  ' . $datos_credencial["credencial_identificacion"] . '</td>
				<td>' .$datos_credencial["credencial_apellido"] . ' ' . $datos_credencial["credencial_apellido_2"] . ' </td>
				<td>' . $datos_credencial["credencial_nombre"] . ' ' . $datos_credencial["credencial_nombre_2"] . ' ' . '</td>
				<td>' .  $datos_credencial["credencial_login"] . ' ' . '</td>
				<td>' . $info_estudiantes[$i]["faltas"] . '</td>';
			$inicio_cortes = 1;
			$corte_nota = "";
			while ($inicio_cortes <= $cortes) {
				$corte_nota = "c" . $inicio_cortes;
				$data["0"] .= '<td>' . $info_estudiantes[$i][$corte_nota] . '</td>';
				$inicio_cortes++;
			}
			$data["0"] .= '<td>' . $info_estudiantes[$i]["promedio"] . '</td>
			</tr>';
		}
		$data["0"] .= '</tbody>
		</table>';
		$results = array($data);
		echo json_encode($results);
		break;

	case 'cargarDatosPrograma':
		$id_docente_grupo = $_POST['grupo_seleccionado'];
		$cargar_grupo = $cuenta_docente->cargarPrograma2($id_docente_grupo);
		$info_grupo = $cargar_grupo;
		$materia = $info_grupo["materia"]; // materia docente
		$id_programa = $info_grupo["id_programa"]; // programa de la materia
		$data[] = array(
			"materia" => $materia,
			"id_programa" => $id_programa
		);
		echo json_encode($data);
		break;

	case 'comprobar':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$id_docente_grupo = $_POST['id_docente_grupo'];
		$materia = $_POST['materia'];
		$id_programa = $_POST["id_programa"]; // programa de la materia
		$rspta = $cuenta_docente->tienepea($id_docente_grupo);
		$datos = $rspta;
		if ($rspta == false) { // si no tiene pea docente
			$verpea = $cuenta_docente->pea($id_programa, $materia);
			$id_pea = $verpea["id_pea"];
			if ($verpea == false) { // no tiene pea creado por el admin
				$data["0"] .= '1'; // quiere decir que no tiene pea por el admin y tampoco por el docente
			}
		} else { // si tiene pea docente
			$data["0"] .= '3'; //puede ver el pea
		}
		$results = array($data);
		echo json_encode($results);
		break;

	case 'listarPea':
		//Vamos a declarar un array
		$data = array();
		$id_programa = $_GET["id_programa"];
		$materia = $_GET["materia"];
		$id_docente_grupo = $_GET["id_docente_grupo"];
		$verpea = $cuenta_docente->pea($id_programa, $materia);
		$id_pea = $verpea["id_pea"];
		$rspta = $cuenta_docente->listarPea($id_pea);
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$data[] = array(
				// '.$rspta[$i]["id_tema"].','.$id_docente_grupo.'
				"0" => '<button onclick="mostrarTemas(' . $rspta[$i]["id_tema"] . ',' . $id_docente_grupo . ')" title=" Ver Actividades" class="btn btn-success btn-xs"><i class="fas fa-tasks"> Ver Actividades</i></button>',
				"1" => $rspta[$i]["sesion"],
				"2" => $rspta[$i]["conceptuales"],
				"3" => $rspta[$i]["procedimentales"],
				"4" => $rspta[$i]["actitudinales"],
				"5" => $rspta[$i]["criterios"]
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

	case 'listaractividades':
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$id_tema = $_POST["id_tema"];
		$id_docente_grupo = $_POST["id_docente_grupo"];
		//Vamos a declarar un array 
		$rspta = $cuenta_docente->listaractividades($id_tema, $id_docente_grupo);
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$data["0"] .= '
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="box box-solid">
				<div class="box-header with-border">
				<h3 class="box-title">' . $reg[$i]["nombre_actividad"] . '</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				<blockquote>
					<p>' . $reg[$i]["descripcion_actividad"] . '</p>';
			if ($reg[$i]["tipo_archivo"] == 1 or $reg[$i]["tipo_archivo"] == 2) { // si el tipo de archivo es imagen o pdf
				$data["0"] .= '
						<a href="../files/pea/' . $reg[$i]["archivo_actividad"] . '" class="btn btn-link" target="_blank">
							<i class="fas fa-cloud-download-alt"></i> Descargar
						</a>';
			} else { // si el archivo es un video o un link
				$data["0"] .= '
						<a href="' . $reg[$i]["archivo_actividad"] . '" class="btn btn-link" target="_blank">
							<i class="fas fa-link"></i> Enlace
						</a>';
			}
			$data["0"] .= '
					<small> Publicado: ' . $cuenta_docente->fechaesp($reg[$i]["fecha_actividad"]) . ' - <cite title="Source Title">' . $reg[$i]["hora_actividad"] . '</cite></small>
				</blockquote>
				</div>
			</div>
		</div>';
		}
		$results = array($data);
		echo json_encode($results);
		break;

	case 'listarHorario':
		$opcion = $_POST["opcion"];
		$id_docente = $_POST["id_docente"];
		$periodo = $_SESSION['periodo_actual']; // periodo actual
		$data = array(); // declaramos la variable
		$data["0"] = ""; // iniciamos la variable
		if ($opcion == 1) {
			$semana = array("Lunes", "Martes", "Miercoles", "Jueves", "Viernes"); /// variable que contiene los dias de la semana
			$titulohorario = "Horario Semana";
		} else if ($opcion == 2) {
			$semana = array("Viernes_FDS_Corte1", "Sabado_FDS_Corte1", "Viernes_FDS_Corte2", "Sabado_FDS_Corte2", "----"); /// variable que contiene los dias de la semana
			$titulohorario = "Horario Fin de Semana";
		} else {
			$semana = array("Sabado", "Sabado_2", "----", "----", "----"); /// variable que contiene los dias de la semana
			$titulohorario = "Horario Sólo Sábados";
		}
		$data["0"] .= '
			<center><h1>' . $titulohorario . '</h1></center>
			<table id="horario_docente" class="table table-hover table-nowarp display compact">
			<thead>
				<tr style="height: 40px">
					<th>#</th>
					<th>Hora</th>
					<th>' . $semana[0] . '</th>
					<th>' . $semana[1] . '</th>
					<th>' . $semana[2] . '</th>
					<th>' . $semana[3] . '</th>
					<th>' . $semana[4] . '</th>
				</tr>
			</thead>
			<tbody>';
		$rspta = $cuenta_docente->listarHorasDia(); // consulta para traer los horas de clase
		for ($i = 0; $i < count($rspta); $i++) { // bucle horas de clase
			// consulta para las clases del lunes
			$rsptalunes = $cuenta_docente->docenteGrupos($id_docente, $periodo, $semana[0], $rspta[$i]["horas"]);
			$rsptamartes = $cuenta_docente->docenteGrupos($id_docente, $periodo, $semana[1], $rspta[$i]["horas"]);
			$rsptamiercoles = $cuenta_docente->docenteGrupos($id_docente, $periodo, $semana[2], $rspta[$i]["horas"]);
			$rsptajueves = $cuenta_docente->docenteGrupos($id_docente, $periodo, $semana[3], $rspta[$i]["horas"]);
			$rsptaviernes = $cuenta_docente->docenteGrupos($id_docente, $periodo, $semana[4], $rspta[$i]["horas"]);
			if ($rsptalunes == true or $rsptamartes == true or $rsptamiercoles == true or $rsptajueves == true or $rsptaviernes == true) {
				$data["0"] .= '<tr align="center">';
				$data["0"] .= '<td>' . $i . '</td>';
				$data["0"] .= '<td>' . $rspta[$i]["formato"] . '</td>';
				$data["0"] .= '<td>';
				$contadorlunes = 0;
				for ($lunes = 0; $lunes < count($rsptalunes); $lunes++) {
					$datosprogramalunes = $cuenta_docente->mostrarDatosPrograma($rsptalunes[$lunes]["id_programa"]);
					$data["0"] .= $rsptalunes[$lunes]["materia"] . '-' . $rsptalunes[$lunes]["salon"] . ' - Sem: ' . $rsptalunes[$lunes]["semestre"] . '<br>' . $datosprogramalunes["nombre"];
					$contadorlunes++;
				}
				if ($rsptamartes == true or $rsptamiercoles == true or $rsptajueves == true or $rsptaviernes == true) {
					if ($contadorlunes == 0) {
						$rsptalunesrow = $cuenta_docente->docenteGruposRow($id_docente, $periodo, $semana[0], $rspta[$i]["horas"]);
						if ($rsptalunesrow == true) {
							$datosprogramalunesrow = $cuenta_docente->mostrarDatosPrograma($rsptalunesrow["id_programa"]);
							$data["0"] .= $rsptalunesrow["materia"] . '-' . $rsptalunesrow["salon"] . ' - Sem: ' . $rsptalunesrow["semestre"] . '<br>' . $datosprogramalunesrow["nombre"];
						}
					}
				}
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
				$contadormartes = 0;
				for ($martes = 0; $martes < count($rsptamartes); $martes++) {
					$datosprogramamartes = $cuenta_docente->mostrarDatosPrograma($rsptamartes[$martes]["id_programa"]);
					$data["0"] .= $rsptamartes[$martes]["materia"] . '-' . $rsptamartes[$martes]["salon"] . ' - Sem: ' . $rsptamartes[$martes]["semestre"] . '<br>' . $datosprogramamartes["nombre"];
					$contadormartes++;
				}
				if ($rsptalunes == true or $rsptamiercoles == true or $rsptajueves == true or $rsptaviernes == true) {
					if ($contadormartes == 0) {
						$rsptamartesrow = $cuenta_docente->docenteGruposRow($id_docente, $periodo, $semana[1], $rspta[$i]["horas"]);
						if ($rsptamartesrow == true) {
							$datosprogramamartesrow = $cuenta_docente->mostrarDatosPrograma($rsptamartesrow["id_programa"]);
							$data["0"] .= $rsptamartesrow["materia"] . '-' . $rsptamartesrow["salon"] . ' - Sem: ' . $rsptamartesrow["semestre"] . '<br>' . $datosprogramamartesrow["nombre"] . '<br>';
						}
					}
				}
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
				$contadormiercoles = 0;
				for ($miercoles = 0; $miercoles < count($rsptamiercoles); $miercoles++) {
					$datosprogramamiercoles = $cuenta_docente->mostrarDatosPrograma($rsptamiercoles[$miercoles]["id_programa"]);
					$data["0"] .= $rsptamiercoles[$miercoles]["materia"] . '-' . $rsptamiercoles[$miercoles]["salon"] . ' - Sem: ' . $rsptamiercoles[$miercoles]["semestre"] . '<br>' . $datosprogramamiercoles["nombre"];
					$contadormiercoles++;
				}
				if ($rsptalunes == true or $rsptamartes == true or $rsptajueves == true or $rsptaviernes == true) {
					if ($contadormiercoles == 0) {
						$rsptamiercolesrow = $cuenta_docente->docenteGruposRow($id_docente, $periodo, $semana[2], $rspta[$i]["horas"]);
						if ($rsptamiercolesrow == true) {
							$datosprogramamiercolesrow = $cuenta_docente->mostrarDatosPrograma($rsptamiercolesrow["id_programa"]);
							$data["0"] .= $rsptamiercolesrow["materia"] . '-' . $rsptamiercolesrow["salon"] . ' - Sem: ' . $rsptamiercolesrow["semestre"] . '<br>' . $datosprogramamiercolesrow["nombre"] . '<br>';
						}
					}
				}
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
				$contadorjueves = 0;
				for ($jueves = 0; $jueves < count($rsptajueves); $jueves++) {
					$datosprogramajueves = $cuenta_docente->mostrarDatosPrograma($rsptajueves[$jueves]["id_programa"]);
					$data["0"] .= $rsptajueves[$jueves]["materia"] . '-' . $rsptajueves[$jueves]["salon"] . ' - Sem: ' . $rsptajueves[$jueves]["semestre"] . '<br>' . $datosprogramajueves["nombre"];
					$contadorjueves++;
				}
				if ($rsptalunes == true or $rsptamartes == true or $rsptamiercoles == true or $rsptaviernes == true) {
					if ($contadorjueves == 0) {
						$rsptajuevesrow = $cuenta_docente->docenteGruposRow($id_docente, $periodo, $semana[3], $rspta[$i]["horas"]);
						if ($rsptajuevesrow == true) {
							$datosprogramajuevesrow = $cuenta_docente->mostrarDatosPrograma($rsptajuevesrow["id_programa"]);
							$data["0"] .= $rsptajuevesrow["materia"] . '-' . $rsptajuevesrow["salon"] . ' - Sem: ' . $rsptajuevesrow["semestre"] . '<br>' . $datosprogramajuevesrow["nombre"] . '<br>';
						}
					}
				}
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
				$contadorviernes = 0;
				for ($viernes = 0; $viernes < count($rsptaviernes); $viernes++) {
					$datosprogramaviernes = $cuenta_docente->mostrarDatosPrograma($rsptaviernes[$viernes]["id_programa"]);
					$data["0"] .= $rsptaviernes[$viernes]["materia"] . '-' . $rsptaviernes[$viernes]["salon"] . ' - Sem: ' . $rsptaviernes[$viernes]["semestre"] . '<br>' . $datosprogramaviernes["nombre"];
					$contadorviernes++;
				}
				if ($rsptalunes == true or $rsptamartes == true or $rsptamiercoles == true or $rsptajueves == true) {
					if ($contadorviernes == 0) {
						$rsptaviernesrow = $cuenta_docente->docenteGruposRow($id_docente, $periodo, $semana[4], $rspta[$i]["horas"]);
						if ($rsptaviernesrow == true) {
							$datosprogramaviernesrow = $cuenta_docente->mostrarDatosPrograma($rsptaviernesrow["id_programa"]);
							$data["0"] .= $rsptaviernesrow["materia"] . '-' . $rsptaviernesrow["salon"] . ' - Sem: ' . $rsptaviernesrow["semestre"] . '<br>' . $datosprogramaviernesrow["nombre"] . '<br>';
						}
					}
				}
				$data["0"] .= '</td>';
				$data["0"] .= '</tr>';
			}
		} // cierra bucle horas de clase
		$data["0"] .= '</tbody></table>';
		$results = array($data);
		echo json_encode($results);
		break;

	case 'iniciarcalendario':

		$id_docente = $_GET["id_docente"];

		$impresion = "";

		$traerhorario = $cuenta_docente->TraerHorariocalendario($id_docente, $periodo_actual);

		$impresion .= '[';

		for ($i = 0; $i < count($traerhorario); $i++) {
			$id_materia = $traerhorario[$i]["id_materia"];
			$diasemana = $traerhorario[$i]["dia"];
			$horainicio = $traerhorario[$i]["hora"];
			$horafinal = $traerhorario[$i]["hasta"];
			$salon = $traerhorario[$i]["salon"];
			$corte = $traerhorario[$i]["corte"];
			$id_usuario_doc = $traerhorario[$i]["id_docente"];

			$datosmateria = $cuenta_docente->BuscarDatosAsignatura($id_materia);
			$nombre_materia = $datosmateria["nombre"];

			if ($id_usuario_doc == null) {
				$nombre_docente = "Sin Asignar";
			} else {
				$datosdocente = $cuenta_docente->datosDocente($id_usuario_doc);
				$nombre_docente = $datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_apellido"];
			}

			//$nombre_docente=$id_docente;


			switch ($diasemana) {
				case 'Lunes':
					$dia = 1;
					break;
				case 'Martes':
					$dia = 2;
					break;
				case 'Miercoles':
					$dia = 3;
					break;
				case 'Jueves':
					$dia = 4;
					break;
				case 'Viernes':
					$dia = 5;
					break;
				case 'Sabado':
					$dia = 6;
					break;
			}

			if ($corte == "1") {
				$color = "gray";
			} else {
				$color = "blue";
			}

			$impresion .= '{"title":"' . $nombre_materia . ' - Salón ' . $salon . ' - doc: ' . $nombre_docente . ' ","daysOfWeek":"' . $dia . '","startTime":"' . $horainicio . '","endTime":"' . $horafinal . '","color":"' . $color . '"}';
			if ($i + 1 < count($traerhorario)) {
				$impresion .= ',';
			}
		}



		$impresion .= ']';

		echo $impresion;


		break;
}