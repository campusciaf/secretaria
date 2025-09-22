<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/DocenteCursosEC.php";
$docenteCurso = new DocenteCursosEC();
$id_docente = $_SESSION['id_usuario'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$rsptaperiodo = $docenteCurso->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$color_estado = array('Proximamente' => "warning", 'Abierto' => "success", 'Cerrado' => "danger");
$color_activo = array(0 => "danger", 1 => "success");
$texto_activo = array(0 => "Inactivo", 1 => "Activo");
$icon_button = array(0 => "fas fa-lock", 1 => "fas fa-lock-open");
$function = array(0 => 1, 1 => 0);
switch ($_GET["op"]) {
	case 'listarCursosDocente':
		//echo "$fecha_hoy, ".$_SESSION["id_usuario"];
		$rspta = $docenteCurso->listarCursosEC($id_docente);
		//Vamos a declarar un array
		$data = array();
		$estado = "";
		//while ($rspta = $rspta[$i]["fetch_object"]()) {
		for ($i = 0; $i < count($rspta); $i++) {
			$estado_educacion = "<span class='badge badge-" . $color_activo[$rspta[$i]["estado_educacion"]] . "'>" . $texto_activo[$rspta[$i]["estado_educacion"]] . "</span>";
			$data[] = array(
				"0" => $rspta[$i]["nombre_curso"],
				"1" => $rspta[$i]["sede_curso"],
				"2" => $rspta[$i]["modalidad_curso"],
				"3" => $docenteCurso->fechaesp($rspta[$i]["fecha_inicio"]),
				"4" => $docenteCurso->fechaesp($rspta[$i]["fecha_fin"]),
				"5" => $rspta[$i]["horario_curso"],
				"6" => '<button class="btn btn-info btn-xs" onclick="listarEstudiantes('. $rspta[$i]["id_curso"].')"> listar estudiantes </button>',
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
	case 'listarEstudiantes':
		$id_docente = $_SESSION["id_usuario"];
		//docente enviado por post
		$id_curso = $_GET["id_curso"];
		//Vamos a declarar un array
		$data = array();
		$roll = ['Estudiante', 'Funcionario', 'Docente'];
		//echo "$fecha_hoy, ".$_SESSION["id_usuario"];
		for ($a = 0; $a < count($roll); $a++) {
			$rspta = $docenteCurso->listarInscritos($roll[$a], $id_docente, $id_curso);
			$estado = "";
			for ($i = 0; $i < count($rspta); $i++) {
				$color =  ($rspta[$i]["estado_inscrito"] == 'finalizado')?"success":"danger";
				$btn_calificar = '
					<button title="Sí" data-toggle="tooltip" data-placement="top" class="b_tooltip btn btn-sm btn-success" onclick="calificarEstudiante(`finalizado`, ' . $rspta[$i]["id_inscrito"] . ')">
						<i class="fas fa-check"></i>
					</button>
					<button title="No" data-toggle="tooltip" data-placement="top" class="b_tooltip btn btn-sm btn-danger" onclick="calificarEstudiante(`no finalizado`, ' . $rspta[$i]["id_inscrito"] . ')"> 
						<i class="fas fa-times"></i>
					</button>';
				$badge_calificar = '<h4 class="badge badge-'.$color.'"> '.$rspta[$i]["estado_inscrito"].'</h4>';
				$btn_calificar = ($rspta[$i]["estado_inscrito"] == 'matriculado')?$btn_calificar:$badge_calificar;

				$nombre = ucfirst(mb_strtolower($rspta[$i]["usuario_nombre"] . " " . $rspta[$i]["usuario_nombre_2"], 'UTF-8'));
				$apellidos = ucfirst(mb_strtolower($rspta[$i]["usuario_apellido"] . " " . $rspta[$i]["usuario_apellido_2"], 'UTF-8'));
				$data[] = array(
					"0" => $nombre,
					"0" => $nombre,
					"1" => $apellidos,
					"2" => $rspta[$i]["nombre_curso"],
					"3" => $roll[$a],
					"4" => '<div class="col-12 text-center">
						<div class="estado_inscrito_'.$rspta[$i]["id_inscrito"].'">
							'.$btn_calificar.'
						</div>	
					</div>',
				);
			}
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'calificarEstudiante':
		$id_inscrito = $_POST["id_inscrito"];
		$estado_inscrito = $_POST["estado_inscrito"];
		$rspta = $docenteCurso->calificarEstudiante($id_inscrito, $estado_inscrito);
		if($rspta){
			$data = array('exito' => 1, 'info' => "Estudiante calificado correctamente");
		}else{
			$data = array('exito' => 0, 'info' => "Error al calificar al estudiante");
		}
		echo json_encode($data);
		break;
	case 'aggfalta':
		$id_credencial = $_POST['id_credencial'];
		$id_docente_grupo = $_POST['id_docente_grupo'];
		$id_docente = $_SESSION['id_usuario'];
		$ciclo = $_POST['ciclo'];
		$id_estudiante = $_POST['id_estudiante'];
		$id_programa = $_POST['id_programa'];
		$programa = $_POST['programa'];
		$id_materia = $_POST['id_materia'];
		$motivo_falta = $_POST['motivo_falta'];
		$fecha = date("Y-m-d");
		$tabla = "materias" . $ciclo;
		//echo "$id_credencial ,$id_docente_grupo ,$id_docente ,$ciclo ,$id_estudiante ,$id_programa ,$programa ,$id_materia ,$fecha ,$tabla";
		$buscarsitienefalta = $docenteCurso->buscarsitienefalta($id_estudiante, $id_materia, $id_docente, $fecha);
		$nombremateriafalta = $docenteCurso->buscarnombremateria($tabla, $id_materia);
		$nombre_materia = $nombremateriafalta["nombre_materia"];
		if ($buscarsitienefalta) { //si tiene falta ese dia
			$data['tienefalta'] = 1;
		} else {
			//si no tiene falta ese dia
			$data['tienefalta'] = 0;
			$agregarfaltaenmaterias = $docenteCurso->agregarfaltaenmaterias($tabla, $id_materia);
			$agregarfaltaenfaltas = $docenteCurso->agregarfaltaenfaltas($id_estudiante, $id_materia, $id_docente, $fecha, $ciclo, $id_programa, $nombre_materia, $motivo_falta);
			$correo = $docenteCurso->consultaCorreoCredencial($id_credencial);
			$destino = $correo["credencial_login"];
			$asunto = $nombre_materia;
			$mensaje = "El docente reporto una falta el día de hoy<br><br>Correo seguro y certificado.";
			error_reporting(0);
			enviar_correo($destino, $asunto, $mensaje);
		}
		$data['id_docente_grupo'] = $id_docente_grupo;
		echo json_encode($data);
		break;
	case 'listarFaltas':
		$id_docente = $_SESSION['id_usuario'];
		$id_estudiante = $_POST['id_estudiante'];
		$id_materia = $_POST['id_materia'];
		$ciclo = $_POST['ciclo'];
		$reg = $docenteCurso->listarFaltas($id_estudiante, $id_materia, $id_docente);
		$data = array();
		$datetime1 = new DateTime(date("Y-m-d H:i:s")); //start time
		for ($i = 0; $i < count($reg); $i++) {
			$datetime2 = new DateTime($reg[$i]["create_dt"]); //end time
			$interval = $datetime1->diff($datetime2);
			$hours = $interval->format('%d');
			//print_r($interval);
			if ($hours < 1) {
				$boton_eliminar = "
					<div class='text-center'>
						<button class='btn btn-danger btn-xs' onclick='eliminarFalta(" . $reg[$i]["id_falta"] . ", $id_estudiante, $id_materia, $ciclo)'> <i class='fas fa-trash'></i> </button>
					</div>	
					";
			} else {
				$boton_eliminar = "<span class='badge badge-info'> No se puede eliminar</span>";
			}
			$data[] = array(
				"0" => $boton_eliminar,
				"1" => $reg[$i]["create_dt"],
				"2" => $reg[$i]["motivo_falta"]
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
	case 'eliminarFalta':
		$falta_id = isset($_POST["falta_id"]) ? $_POST["falta_id"] : die(json_encode(array("status" => 0, "info" => "No ha seleccionado nada")));
		$ciclo = isset($_POST["ciclo"]) ? $_POST["ciclo"] : die(json_encode(array("status" => 0, "info" => "No ha seleccionado nada")));
		$id_materia = isset($_POST["id_materia"]) ? $_POST["id_materia"] : die(json_encode(array("status" => 0, "info" => "Nada seleccionado")));
		$rsptaDoc = $docenteCurso->eliminarFalta($falta_id);
		$tabla = "materias$ciclo";
		if ($rsptaDoc) {
			$docenteCurso->eliminarFaltaenMaterias($tabla, $id_materia);
			$data = array("status" => 1, "info" => "Eliminado satisfactoriamente");
		} else {
			$data = array("s" => 0, "info" => "Error al eliminar");
		}
		echo json_encode($data);
		break;
	case 'consultaContacto':
		$ciclo = $_GET['ciclo'];
		$materia = $_GET['materia'];
		$jornada = $_GET['jornada'];
		$id_programa = $_GET['id_programa'];
		$grupo = $_GET['grupo'];
		$rsptaDoc = $docenteCurso->datosDocente($id_docente);
		$data['docente'] = $rsptaDoc['usuario_nombre'] . ' ' . $rsptaDoc['usuario_nombre_2'] . ' ' . $rsptaDoc['usuario_apellido'] . ' ' . $rsptaDoc['usuario_apellido_2'];
		
		
		
		$ciclo_homologados = 9;
		$listado_homologados = $docenteCurso->listarhomolog($ciclo_homologados, $materia);
		$listado_normales = $docenteCurso->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo);

		$listado= array_merge($listado_normales,$listado_homologados);


		//Vamos a declarar un array
		$data = array();
		for ($i = 0; $i < count($listado); $i++) {
			$id_estudiante = $listado[$i]["id_estudiante"];
			$buscardatos = $docenteCurso->estudianteDatos($id_estudiante);
			$data[] = array(
				"0" => $buscardatos["credencial_identificacion"],
				"1" => $buscardatos["credencial_apellido"] . ' ' . $buscardatos["credencial_apellido_2"] . ' ' . $buscardatos["credencial_nombre"] . ' ' . $buscardatos["credencial_nombre_2"],
				"2" => $buscardatos["email"],
				"3" => $buscardatos["credencial_login"],
				"4" => $buscardatos["celular"]
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
	case 'consultaContacto2':
		//print_r($id);
		$cantidad = count($id);
		$data['table'] = "";
		$data['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Email</th><th scope="col">Email CIAF</th><th scope="col">Cel</th>
					</tr>
				</thead>
				<tbody>';
		for ($i = 0; $i < $cantidad; $i++) {
			$datos = $docenteCurso->estudiante_datos_completos($id[$i]['0']);
			//print_r($datos);
			$data['table'] .= '<tr>
					<td>' . $datos['credencial_identificacion'] . '</td>
					<td>' . $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . ' ' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'] . '</td>
					<td>' . $datos['email'] . '</td>
					<td>' . $datos['credencial_login'] . '</td>
					<td>' . $datos['celular'] . '</td>
				</tr>';
		}
		$data['table'] .= '	</tbody></table>';
		$data['materia'] = $materia;
		$data['jornada'] = $jornada;
		$data['fecha'] = date("d/m/Y");
		$progra = $docenteCurso->programaacademico($id_programa);
		$data['programa'] = $progra['nombre'];
		echo json_encode($data);
		break;
	case 'consultaEstudiante':
		$ciclo = $_POST['ciclo'];
		$materia = $_POST['materia'];
		$jornada = $_POST['jornada'];
		$id_programa = $_POST['id_programa'];
		$grupo = $_POST['grupo'];
		$medio = $_POST['medio'];
		$rsptaDoc = $docenteCurso->datosDocente($id_docente);
		$data['docente'] = $rsptaDoc['usuario_nombre'] . ' ' . $rsptaDoc['usuario_nombre_2'] . ' ' . $rsptaDoc['usuario_apellido'] . ' ' . $rsptaDoc['usuario_apellido_2'];
		if ($medio == "1") {
			$id = $docenteCurso->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo, $medio);
			//print_r($id);
			$cantidad = count($id);
			$data['table'] = "";
			$data['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Email</th><th scope="col">Email CIAF</th><th scope="col">Cel</th>
					</tr>
				</thead>
				<tbody>';
			for ($i = 0; $i < $cantidad; $i++) {
				$datos = $docenteCurso->estudiante_datos_completos($id[$i]['0']);
				//print_r($datos);
				$data['table'] .= '<tr>
					<td>' . $datos['credencial_identificacion'] . '</td>
					<td>' . $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . ' ' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'] . '</td>
					<td>' . $datos['email'] . '</td>
					<td>' . $datos['credencial_login'] . '</td>
					<td>' . $datos['celular'] . '</td>
				</tr>';
			}
			$data['table'] .= '	</tbody></table>';
			$data['materia'] = $materia;
			$data['jornada'] = $jornada;
			$data['fecha'] = date("d/m/Y");
			$progra = $docenteCurso->programaacademico($id_programa);
			$data['programa'] = $progra['nombre'];
			echo json_encode($data);
		}
		if ($medio == "2") {
			$id = $docenteCurso->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo, $medio);
			$cantidad = count($id);
			$data['table'] = "";
			$data['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Firma</th><th scope="col">Firma 2</th>
					</tr>
				</thead>
				<tbody>';
			for ($i = 0; $i < $cantidad; $i++) {
				$datos = $docenteCurso->estudiante_datos_completos($id[$i]['0']);
				$data['table'] .= '<tr>
					<td>' . $datos['credencial_identificacion'] . '</td>
					<td>' . $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . ' ' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'] . '</td>
					<td></td>
					<td></td>
				</tr>';
			}
			$data['table'] .= '	</tbody></table>';
			$data['materia'] = $materia;
			$data['jornada'] = $jornada;
			$data['fecha'] = date("d/m/Y");
			$progra = $docenteCurso->programaacademico($id_programa);
			$data['programa'] = $progra['nombre'];
			echo json_encode($data);
		}
		if ($medio == "3") {
			$id = $docenteCurso->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo, $medio);
			$cantidaEstu = count($id);
			$a = 0;
			$e = 0;
			$fechas = "";
			$datos['table'] = "";
			$datos['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Fecha</th>
					</tr>
				</thead>
				<tbody>';
			while ($a < $cantidaEstu) {
				$result = $docenteCurso->consultaInasistencia($id[$a]['0']);
				if (count($result) > 0) {
					$datos['table'] .= "<tr>";
					$fechas = "";
					$i = 0;
					while ($i < count($result)) {
						$fechas .= "Falta N° " . ($i + 1) . " : " . $docenteCurso->convertir_fecha($result[$i]['fecha_falta']) . " \n <br>" . PHP_EOL;
						$i++;
					}
					$datosPerso = $docenteCurso->estudiante_datos_completos($id[$a]['0']);
					$data[] = array(
						"0" => '<td>' . $datosPerso['credencial_identificacion'] . '</td>',
						"1" => '<td>' . $datosPerso['credencial_nombre'] . ' ' . $datosPerso['credencial_nombre_2'] . ' ' . $datosPerso['credencial_apellido'] . ' ' . $datosPerso['credencial_apellido_2'] . '</td>',
						"2" => '<td>' . $fechas . '</td>'
					);
					$datos['table'] .= $data[$e]['0'];
					$datos['table'] .= $data[$e]['1'];
					$datos['table'] .= $data[$e]['2'];
					$e++;
					$datos['table'] .= "</tr>";
				}
				/* $datos['table'] .= '</tbody></table>';*/
				$datos['materia'] = $materia;
				$datos['jornada'] = $jornada;
				$datos['fecha'] = date("d/m/Y");
				$progra = $docenteCurso->programaacademico($id_programa);
				$datos['programa'] = $progra['nombre'];
				$a++;
			}
			echo json_encode($datos);
		}
		break;
	case 'consultaReporteFinal':
		$id_docente = $_POST['id_docente'];
		$ciclo = $_POST['ciclo'];
		$materia = $_POST['materia'];
		$jornada = $_POST['jornada'];
		$id_programa = $_POST['id_programa'];
		$grupo = $_POST['grupo'];
		//Vamos a declarar un array
		$data = array();
		$data["table"] = "";
		$rsptaDoc = $docenteCurso->datosDocente($id_docente);
		$data['docente'] = $rsptaDoc['usuario_nombre'] . ' ' . $rsptaDoc['usuario_nombre_2'] . ' ' . $rsptaDoc['usuario_apellido'] . ' ' . $rsptaDoc['usuario_apellido_2'];



		$ciclo_homologados = 9;
		$listado_homologados = $docenteCurso->listarhomolog($ciclo_homologados, $materia);
		$listado_normales = $docenteCurso->listar($ciclo, $materia, $jornada, $id_programa, $grupo);

		$rspta= array_merge($listado_normales,$listado_homologados);
		$reg = $rspta;
		$estado = "";
		$rspta2 = $docenteCurso->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$inicio_cortes = 1;
		$data['programa'] = $rspta2['nombre']; // variable que sirve para imprimir el programa y utilizarlo en datatable
		$data["table"] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th>
						<th scope="col">Estudiante(Nombre completo)</th>
						<th scope="col">Faltas</th>';
		while ($inicio_cortes <= $cortes) {
			$data["table"] .= '<th>C' . $inicio_cortes . '</th>';
			$inicio_cortes++;
		}
		$data["table"] .= '
						<th>Final</th>
            		</tr>
        		</thead>
        <tbody>';
		$num_id = 1;
		for ($i = 0; $i < count($reg); $i++) {
			$rspta3 = $docenteCurso->id_estudiante($reg[$i]["id_estudiante"]);
			$id_credencial = $rspta3["id_credencial"];
			$rspta4 = $docenteCurso->estudiante_datos($id_credencial);
			if (file_exists('../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg')) {
				$foto = '<img src=../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg width=50px height=50px class=img-circle>';
			} else {
				$foto = '<img src=../files/null.jpg width=50px height=50px class=img-circle>';
			}

			if ($rspta3["estado"] == 1) {
				$estado = "<span class='label label-success'>Activo</span>";
			} else {
				$estado = "<span class='label label-warning'>Inactivo</span>";
			}

			$habeas_carac = $docenteCurso->est_carac_habeas($id_credencial);
			if (empty($habeas_carac)) {
				$caracterizado = "<span class='label bg-orange'>No</span>";
			} else {
				$caracterizado = "<span class='label bg-navy'>Si</span>";
			}
			$data["table"] .= '
			<tr>
				<td>
					<input type="hidden" value="' . $materia . '" id="materia">' .
				$rspta4["credencial_identificacion"] . ' | ' . $estado . ' | ' . $caracterizado . '
				</td>
				<td>' .
				$rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"] . ' ' . $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' ' . '
				</td>
				<td>' . $reg[$i]["faltas"] . '</td>';
			$inicio_cortes = 1;
			$corte = $docenteCurso->consultaCorte($id_programa, $materia, $id_docente, $reg[$i]["semestre"], $jornada);
			$corte_nota = "";
			while ($inicio_cortes <= $cortes) {
				$corte_nota = "c" . $inicio_cortes;
				$data["table"] .= '<td class="col-md-1">' . $reg[$i][$corte_nota] . '</td>';
				$inicio_cortes++;
			}
			$data["table"] .= '	
				<td>' . round($reg[$i]["promedio"], 2) . '</td>	
			</tr>';
		}
		$data["table"] .= '
			</tbody>
    	</table>';
		//$results = array($data);
		echo json_encode($data);
		break;
	case 'enviarCorreos':
		$ciclo = $_POST['ciclo'];
		$materia = $_POST['materia'];
		$jornada = $_POST['jornada'];
		$id_programa = $_POST['id_programa'];
		$grupo = $_POST['grupo'];
		$contenido = $_POST['contenido'];
		$medio = "";
		$id = $docenteCurso->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo, $medio);
		$nombreDocente = $_SESSION['usuario_nombre'] . " " . $_SESSION['usuario_apellido'];
		$correoDocente = $_SESSION['usuario_login'];
		//correo enviado al docente para que quede evidencia
		$asunto_docente = "Evidencia Comunicado docente";
		$template_mensaje = set_templateComunicadoDocente($contenido, $nombreDocente);
		$asunto_estudiantes = "Comunicado Docente - " . $nombreDocente;
		enviar_correo($correoDocente, $asunto_docente, $template_mensaje);
		//ciclo para ir enviardo a cada uno de los estudiantes el correo
		for ($i = 0; $i < count($id); $i++) {
			//toma el correo del estudiante
			$correo = $docenteCurso->consultaCorreoEstudiante($id[$i]["id_estudiante"]);
			//mail para los estudiantes
			enviar_correo($correo['credencial_login'], $asunto_estudiantes, $template_mensaje);
		}
		$data['result'] = "ok";
		echo json_encode($data);
		break;
	case 'nota':
		$id_docente = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : die(json_encode(array("status" => "Su sesión ha caducado, actualiza la ventana e inicia sesion.")));
		//id materia
		$id = $_POST['id'];
		//nota asignada por el profe
		$nota = $_POST['nota'];
		//corte 
		$tl = $_POST['tl'];
		//ciclo
		$c = $_POST['c'];
		//programa
		$pro = $_POST['pro'];
		//agregar nota
		$rspta = $docenteCurso->agreganota($id, $nota, $tl, $c, $pro);
		echo json_encode(($rspta) ? array("status" => "ok") : array("status" => "err"));
		/*$consulta_programas = $docenteCurso->consulta_programas($_SESSION['id_usuario']);
		for ($j = 0; $j < count($consulta_programas); $j++) {
			$vernombreestudiante = $docenteCurso->vernombreestudiante($_SESSION['id_usuario']);
			$nombre_estudiante = $vernombreestudiante[$j]["credencial_nombre"] ." ".$vernombreestudiante[$j]["credencial_nombre_2"]." ".$vernombreestudiante[$j]["credencial_apellido"]." ".$vernombreestudiante[$j]["credencial_apellido_2"];
			$correo_electronico = $vernombreestudiante[$j]['credencial_login'];
			echo $correo_electronico;
			$mensaje = set_template($nombre_estudiante, $nota, $c, $pro);
			if(enviar_correo($correo_electronico, "Entrevista CIAF", $mensaje)){
				$inserto = array( "estatus" => 1, "valor" => "Cita Agendada con exito");
				echo json_encode($inserto);     
			}else{
				$inserto = array("estatus" => 1, "valor" => "Error al enviar el correo");
				echo json_encode($inserto);
			}
		} */
		//echo base64_decode($id);
		break;
	case 'programa':
		$id_programa = $_GET["id_programa"]; // variable que contiene el id del programa
		$buscar_programa = $docenteCurso->programa($id_programa); // consulta para buscar el nombre de la materia	
		echo  $buscar_programa["nombre"];
		break;
	case 'iniciarcalendario':
		$id_estudiante = $_GET["id_estudiante"]; // id del estudiante
		$ciclo = $_GET["ciclo"]; // ciclo
		$id_programa = $_GET["id_programa"]; // programa del estudiante
		$grupo = $_GET["grupo"]; // programa del estudiante
		$impresion = "";
		$rspta = $docenteCurso->listarDos($id_estudiante, $ciclo, $grupo);
		$rspta2 = $docenteCurso->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$inicio_cortes = 1;
		$reg = $rspta;
		$impresion .= '[';
		for ($i = 0; $i < count($reg); $i++) {
			$buscaridmateria = $docenteCurso->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
			$idmateriaencontrada = $buscaridmateria["id"];
			$rspta3 = $docenteCurso->docente_grupo($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
			@$id_docente = $rspta3["id_docente"];
			@$id_docente_grupo = $rspta3["id_docente_grupo"];
			@$id_materia = $rspta3["id_materia"];
			@$salon = $rspta3["salon"];
			@$diasemana = $rspta3["dia"];
			@$horainicio = $rspta3["hora"];
			@$horafinal = $rspta3["hasta"];
			@$corte = $rspta3["corte"];
			$datosmateria = $docenteCurso->BuscarDatosAsignatura($id_materia);
			@$nombre_materia = $datosmateria["nombre"];
			if ($id_docente == null) {
				$nombre_docente = "Sin Asignar";
			} else {
				$datosdocente = $docenteCurso->datosDocente($id_docente);
				$nombre_docente = $datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_apellido"];
			}
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
			if ($i + 1 < count($reg)) {
				$impresion .= ',';
			}
		}
		$impresion .= ']';
		echo $impresion;
		break;
	case 'horarioestudiante':
		$id = $_POST["id"]; // id del estudiante
		$ciclo = $_POST["ciclo"]; // ciclo
		$id_programa = $_POST["id_programa"]; // programa del estudiante
		$grupo = $_POST["grupo"]; // programa del estudiante
		$rspta = $docenteCurso->listarDos($id, $ciclo, $grupo);
		$rspta2 = $docenteCurso->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$inicio_cortes = 1;
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$data["0"] .= '
		<button onclick=iniciarcalendario("' . $id . '","' . $ciclo . '","' . $id_programa . '","' . $grupo . '") title="Ver horario de clase" class="btn btn-primary btn-xs float-right">
			Ver calendario
		</button>';
		$traercredencial = $docenteCurso->id_estudiante($id);
		$credencialestudiante = $traercredencial["id_credencial"];
		$datosestudiante = $docenteCurso->estudiante_datos($credencialestudiante);
		$nombrecompleto = $datosestudiante["credencial_apellido"] . ' ' . $datosestudiante["credencial_apellido_2"] . ' ' . $datosestudiante["credencial_nombre"] . ' ' . $datosestudiante["credencial_nombre_2"];
		$data["0"] .= $nombrecompleto;
		$data["0"] .= '
		<table class="table table-bordered table-sm compact" style="width:100%">
			<thead>
				<tr>
					<th>Asignatura</th>
					<th >Docente</th>
					';
		$data["0"] .= '
					<th >Horario</th>
					<th >Faltas</th>
				</tr>
			</thead>
			<tbody>';
		$reg = $rspta;
		$num_id = 1;
		for ($i = 0; $i < count($reg); $i++) {
			$buscaridmateria = $docenteCurso->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
			$idmateriaencontrada = $buscaridmateria["id"];
			$rspta3 = $docenteCurso->docente_grupo($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
			@$id_docente = $rspta3["id_docente"];
			@$id_docente_grupo = $rspta3["id_docente_grupo"];
			@$dia = $rspta3["dia"];
			@$hora = $rspta3["hora"];
			@$hasta = $rspta3["hasta"];
			if ($id_docente == true) { // si existe grupo
				$rspta4 = $docenteCurso->docente_datos($id_docente);
				$nombre_docente = $rspta4["usuario_nombre"] . ' ' . $rspta4["usuario_nombre_2"] . ' <br>' . $rspta4["usuario_apellido"] . ' ' . $rspta4["usuario_apellido_2"];
				$dia_clase = $dia . ' <br> ' . $hora . ' - ' . $hasta;
			} else {
				$nombre_docente = "";
				$dia_clase = "";
			}
			$data["0"] .= '
				<tr>
					<td>
					<span id=' . $num_id . '>
					';
			$data["0"] .= '
					</span>
						<span class="label label-default" title="Créditos">[' . $reg[$i]["creditos"] . ']</span> ' .
				$reg[$i]["nombre_materia"] . '
					</td>
					<td>' . $nombre_docente . '
					</td>';
			$data["0"] .= '	
					<td>' . $dia_clase . '</td>
					<td>' . $reg[$i]["faltas"] . '</td>
				</tr>
				';
			$num_id++;
		}
		$data["0"] .= '
				</tbody>
		</table>';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'activarPea':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$id_pea = $_POST["id_pea"];
		$resutlado = "";
		$activarpea = $docenteCurso->activarpea($id_pea, $id_docente_grupo, $fecha, $hora, $periodo_actual);
		$activarpearesultado = $activarpea ? 'si' : 'no';
		if ($activarpearesultado == "si") {
			$resultado = 1;
		} else {
			$resultado = 2;
		}
		echo json_encode($resultado);
		break;
}