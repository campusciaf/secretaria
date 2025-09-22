<?php
error_reporting(1);
require_once "../modelos/MiHorario.php";
require_once "../public/mail/sendmailClave.php"; // incluye el codigo para enviar link de clave
require_once "../mail/templatenotiejerciciodocente.php"; // incluye el codigo para enviar link de clave
$consulta = new MiHorario();
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('h:i:s');
$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$id_credencial = $_SESSION['id_usuario'];
/* subir ejercicios */
$id_pea_ejercicios = isset($_POST["id_pea_ejercicios"]) ? limpiarCadena($_POST["id_pea_ejercicios"]) : "";
$id_pea_ejercicios_2 = isset($_POST["id_pea_ejercicios_2"]) ? limpiarCadena($_POST["id_pea_ejercicios_2"]) : "";
$id_pea_docente = isset($_POST["id_pea_docente"]) ? limpiarCadena($_POST["id_pea_docente"]) : "";
$comentario_ejercicios = isset($_POST["comentario_ejercicios"]) ? limpiarCadena($_POST["comentario_ejercicios"]) : "";
$archivo_ejercicios = isset($_FILES['archivo_ejercicios']['name']) ? limpiarCadena($_FILES['archivo_ejercicios']['name']) : "";
/* ********************** */
switch ($_GET["op"]) {
	case 'guardaryeditarejercicios':
		$data = array();
		$traerid_pea_docentes = $consulta->traeridpeadocente($id_pea_docente);
		$traeredatosdocentegrupos = $consulta->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $consulta->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $consulta->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $consulta->estudiante_datos_personales($id_credencial);
		$celular = $datos_estudiante["celular"];
		// tipo de archivo debe ser rar */
		$allowedExts = array("rar", "xls", "xlsx", "ppt", "pptx", "pdf", "doc", "docx");
		$target_path = '../files/pea/ciclo' . $ciclo . '/ejerciciosest/';
		$extension = explode(".", $archivo_ejercicios);
		$img1path = $target_path . '' . $fecha . '-' . $archivo_ejercicios;
		$peso = filesize($_FILES['archivo_ejercicios']['tmp_name']);
		$pesofinal = round(($peso / 1024) / 1024);
		/* ************************ */
		if ($pesofinal <= 5) {
			if (in_array(strtolower($extension[count($extension) - 1]), $allowedExts)) {
				if (move_uploaded_file($_FILES['archivo_ejercicios']['tmp_name'], $img1path)) {
					$archivo_ejercicios_final = '' . $fecha . '-' . $_FILES['archivo_ejercicios']['name'];
					$rspta = $consulta->insertarEjercicio($id_pea_ejercicios, $_SESSION['id_estudiante_programa'], $id_credencial, $comentario_ejercicios, $archivo_ejercicios_final, $fecha, $hora, $ciclo); // inserta el tema
					if ($rspta) {
						$data["exito"] = 1;
						$data["info"] = "Archivo insertado correctamente";
						$data["id_pea_docente"] = $id_pea_docente;
						$data["id_programa"] = $id_programa;
					} else {
						$data["exito"] = 0;
						$data["info"] = "Error al inserta en base de datos, contactate con campus@ciaf.edu.co para solicitar verificar el error ";
					}
				} else {
					$data["exito"] = 0;
					$data["info"] = "Error al subir el archivo, contactate con campus@ciaf.edu.co para solicitar verificar el error ";
				}
			} else {
				$data["exito"] = 0;
				$data["info"] = "Tipo de archivo no permitido. Solo se permiten archivos Excel, PowerPoint, RAR, PDF y Word.";
			}
		} else {
			$data["exito"] = 0;
			$data["info"] = "El archivo supera el tamaño máximo permitido de 5 MB.";
		}
		echo json_encode($data);
    break;
	case 'listar':
		// id del estudiante
		$id = $_POST["id"]; 
		$_SESSION['id_estudiante_programa'] = $id;
		// ciclo
		$ciclo = $_POST["ciclo"]; 
		// programa del estudiante
		$id_programa = $_POST["id_programa"]; 
		// programa del estudiante
		$grupo = $_POST["grupo"]; 
		$_SESSION['grupo_programa'] = $grupo;
		$rspta = $consulta->listar($id, $ciclo, $grupo);
		$huella = isset($rspta["huella"]) ? $rspta["huella"] : '';
		$rspta2 = $consulta->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$inicio_cortes = 1;
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$data["0"] .= '
			
				<div class="col-xl-6 col-lg-6 col-md-6 col-7 py-3">
					<div class="row align-items-center">
						<div class="col-auto pl-4">
							<span class="rounded bg-light-blue p-3 text-primary ">
								<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
							</span> 
						</div>
						<div class="col-auto">
							<div class="fs-14 line-height-18"> 
								<span class="">Horario</span> <br>
								<span class="text-semibold fs-20">de clases</span> 
							</div> 
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-5 pr-4 py-3 ">
					<a onclick="iniciarcalendario(' . $id . ',' . $ciclo . ',' . $id_programa . ',' . $grupo . ')" class="btn btn-primary float-right" id="t-paso8"><i class="fa-solid fa-calendar-days" ></i> Ver calendario </a>
				</div>
			
		';
		$data["0"] .= '
		<div class="col-12 tono-3">	
			<table id="example" class="table table-hover table-sm table-responsive col-12">
				<thead>
					<tr>
						<th id="t-paso1">
							PEA 
							<div class="tooltips-bottom">
								<i class="fa-solid fa-circle-info text-primary"></i>
								<span class="tooltiptext">Es lo que se conoce como proyecto educativo de aula.</span>
							</div>
						</th>
						<th id="t-paso2">Asignatura</th>
						<th colspan="2" class="text-center" id="t-paso3">Docente</th>';
		while ($inicio_cortes <= $cortes) {
			$data["0"] .= '<th id="t-paso4" > C' . $inicio_cortes . '</th>';
			$inicio_cortes++;
		}
		$data["0"] .= '
						<th id="t-paso5">Final</th>
						<th id="t-paso6">Horario de la clase</th>
						<th id="t-paso7">Faltas</th>
					</tr>
				</thead>
				<tbody>';
		if ($ciclo == 9) {
			$estudiantes_homologados = $consulta->listar($id, $ciclo, $grupo);
			for ($r = 0; $r < count($estudiantes_homologados); $r++) {
				$huella = $estudiantes_homologados[$r]["huella"];
				$buscar_docente_h = $consulta->buscaridmateria_h();
				// print_r($buscar_docente_h);
				$id_docente_h = $buscar_docente_h[$r]["id_docente"];
				$id_materia_h = $buscar_docente_h[$r]["id_materia"];
				$jornada_h = $buscar_docente_h[$r]["jornada"];
				$periodo_h = $buscar_docente_h[$r]["periodo"];
				$semestre_h = $buscar_docente_h[$r]["semestre"];
				$nombre_materia_h = $buscar_docente_h[$r]["nombre_materia"];
				$docente = $buscar_docente_h[$r]["usuario_nombre"] . ' ' . $buscar_docente_h[$r]["usuario_nombre_2"] . ' <br>' . $buscar_docente_h[$r]["usuario_apellido"] . ' ' . $buscar_docente_h[$r]["usuario_apellido_2"];
				$buscaridmateria = $consulta->buscaridmateria($id_programa, $nombre_materia_h);
				$idmateriaencontrada = $buscaridmateria["id"];
				$resultadorspta3 = $buscar_docente_h ? 1 : 0; // si existe registro
				if ($resultadorspta3 == 1) { // si existe horario para la clase
					$id_docente = $buscar_docente_h[$r]["id_docente"];
					$id_docente_grupo = $buscar_docente_h[$r]["id_docente_grupo"];
					// $rspta4 = $consulta->docente_datos($id_docente);
					if (file_exists('../files/docentes/' . $buscaridmateria["usuario_identificacion"] . '.jpg')) {
						$foto = '<img src=../files/docentes/' . $buscaridmateria["usuario_identificacion"] . '.jpg width=40px height=40px class=img-circle>';
					} else {
						$foto = '<img src=../files/null.jpg width=40px height=40px class=img-circle>';
					}
					$horario = $buscar_docente_h[$r]["dia"] . ' <br> ' . $buscar_docente_h[$r]["hora"] . ' - ' . $buscar_docente_h[$r]["hasta"] . ' - corte ' . $buscar_docente_h[$r]["corte"];
					if ($estudiantes_homologados[$r]["id_pea"] == null) { // si el estudiante no tiene PEA
						$rsptatienepea = $consulta->docente_pea($id_docente_grupo);
						$tienepea = $rsptatienepea ? 1 : 0; // si existe registro
						if ($tienepea == 1) {
							$botonpea = '<a onclick=validar_pea(' . $num_id . ',' . $ciclo . ',' . $estudiantes_homologados[$r]["id_materia"] . ',' . $id_docente_grupo . ') class="btn btn-primary btn-xs" title="PLan Educativo sin Activar">Activar PEA</a>';
						} else { // no tiene pea
							$botonpea = "En proceso";
						}
					} else { // si ya tiene pea
						$botonpea = '<a onclick=verPanel(' . $id_docente_grupo . ') class="btn btn-success btn-sm" title="Plan Educativo de Aula">Ver PEA</a>';
					}
				} else { // no existe doente para la clase
					$foto = "";
					$nombredeldocente = "";
					$horario = "";
				}
				$data["0"] .= '
						<tr>
							<td>
								<span id=' . $num_id . '>';
				$data["0"] .= $botonpea . "<br>" . $huella = ($huella == "") ? '<span class="badge badge-danger p-1">No Homologada</span>' : '<span class="badge badge-success p-1">Homologada</span>';
				$data["0"] .= '
							</span>
							<span id="mostrar_' . $num_id . '" style="display:none">
								<a onclick=verPanel(' . $id_docente_grupo . ') class="btn btn-success btn-sm" title="Plan Educativo de Aula">Ver PEA</a>
							</span>
							</td>';
				$data["0"] .= '
							<td class="text-left">
								<span class="label label-default text-primary" title="Créditos">[' . $estudiantes_homologados[$r]["creditos"] . ']</span> ' .
					$estudiantes_homologados[$r]["nombre_materia"] . '
							</td>
							<td>' .
					$foto . '
							</td>
							<td>' . $docente . '</td>';
				$inicio_cortes = 1;
				$corte_nota = "";
				while ($inicio_cortes <= $cortes) {
					$corte_nota = "c" . $inicio_cortes;
					$data["0"] .= '<td>' . $estudiantes_homologados[$r][$corte_nota] . '</td>';
					$inicio_cortes++;
				}
				$data["0"] .= '	
							<td>' . $estudiantes_homologados[$r]["promedio"] . '</td>
							<td>' . $horario . '</td>
							<td>' . $buscar_docente_h[$r]["salon"] . '</td>
							<td>' . $estudiantes_homologados[$r]["faltas"] . '</td>
						</tr>';
				$num_id++;
			}
		} else {
			$reg = $rspta;
			$num_id = 1;
			$nombre_materia = "";
			for ($i = 0; $i < count($reg); $i++) {
				$nombre_materia = $reg[$i]["nombre_materia"];
				$activar_grupo_esp = $reg[$i]["activar_grupo_esp"];
				if ($activar_grupo_esp == 0) {
					$buscaridmateria = $consulta->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
					$idmateriaencontrada = $buscaridmateria["id"];
					$rspta3 = $consulta->docente_grupo($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
					// si existe registro
					$resultadorspta3 = $rspta3 ? 1 : 0; 
					// si existe horario para la clase
					if ($resultadorspta3 == 1) { 
						$id_docente = $rspta3["id_docente"];
						$id_docente_grupo = $rspta3["id_docente_grupo"];
						$rspta4 = $consulta->docente_datos($id_docente);

							$identificaciondoc = $rspta4["usuario_identificacion"] ?? '';
							if (file_exists('../files/docentes/' . $identificaciondoc . '.jpg') && !empty($identificaciondoc)) {
								$foto = '<img src="../files/docentes/' . $identificaciondoc . '.jpg" width="30px" height="30px" class="img-circle">';
							} else {
								$foto = '<img src="../files/null.jpg" width="30px" height="30px" class="img-circle">';
							}


		
							$nombredeldocente = 
							(isset($rspta4["usuario_nombre"]) ? $rspta4["usuario_nombre"] : '') . ' ' . 
							(isset($rspta4["usuario_nombre_2"]) ? $rspta4["usuario_nombre_2"] : '') . ' <br>' . 
							(isset($rspta4["usuario_apellido"]) ? $rspta4["usuario_apellido"] : '') . ' ' . 
							(isset($rspta4["usuario_apellido_2"]) ? $rspta4["usuario_apellido_2"] : '');

						$horario = '<b>' . $rspta3["dia"] . '</b> ' . $rspta3["hora"] . ' - ' . $rspta3["hasta"] . ' - corte ' . $rspta3["corte"];
						if ($reg[$i]["id_pea"] == null) { // si el estudiante no tiene PEA

							$rsptatienepea = $consulta->docente_pea($id_docente_grupo);
							$tienepea = $rsptatienepea ? 1 : 0; // si existe registro
							if ($tienepea == 1) {
								$botonpea = '<a onclick=validar_pea(' . $num_id . ',' . $ciclo . ',' . $reg[$i]["id_materia"] . ',' . $id_docente_grupo . ') class="btn btn-primary btn-xs" title="PLan Educativo sin Activar">Activar PEA </a>';
							} else { // no tiene pea
								$botonpea = "En proceso";
							}
						} else { // si ya tiene pea
							$botonpea = '<a onclick=verPanel(' . $id_docente_grupo . ') class="btn btn-success btn-sm text-white" title="Plan Educativo de Aula">Ver PEA</a>';
						}
					} else { // no existe doente para la clase
						$foto = "";
						$nombredeldocente = "";
						$horario = "";
					}
					$data["0"] .= '<tr>
								<td style="width:70px">
									<span id=' . $num_id . '>';
					$data["0"] .= $botonpea;
					$data["0"] .= '
								</span>
								<span id="mostrar_' . $num_id . '" style="display:none">
									<a onclick=verPanel(' . $id_docente_grupo . ') class="btn btn-success" title="Plan Educativo de Aula">Ver PEA</a>
								</span>
						</td>';
					$data["0"] .= '
								<td style="width:250px">
								
									<span class="label label-default" title="Créditos"><b>[' . $reg[$i]["creditos"] . ']</b></span> ' .
					$reg[$i]["nombre_materia"] . '
								</td>
								<td >' .
					$foto . '
								</td>
								<td  style="width:150px">' . $nombredeldocente . '</td>';
					$inicio_cortes = 1;
					$corte_nota = "";
					while ($inicio_cortes <= $cortes) {
						$corte_nota = "c" . $inicio_cortes;
						$data["0"] .= '<td>' . $reg[$i][$corte_nota] . '</td>';
						$inicio_cortes++;
					}
					$data["0"] .= '
								<td class="text-primary">' . $reg[$i]["promedio"] . '</td>
								<td>';
					$traerhorarios = $consulta->docente_grupo_clases($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
					for ($gru = 0; $gru < count($traerhorarios); $gru++) {
						$n_dia = $traerhorarios[$gru]["dia"];
						$n_hora = $traerhorarios[$gru]["hora"];
						$n_hasta = $traerhorarios[$gru]["hasta"];
						$n_corte = $traerhorarios[$gru]["corte"];
						$n_salon = $traerhorarios[$gru]["salon"];  
						$data["0"] .= '<b>' . $n_dia . '</b> ' . $n_hora . ' - ' . $n_hasta . ' <b>Salón </b>' . $n_salon . ' - corte ' . $n_corte . '<br>';
					}
					$data["0"] .= '</td>
								<td style="width:50px">' . $reg[$i]["faltas"] . '</td>
							</tr>
							';
					$num_id++;
				}
				else{
					// id docente grupo especial
					$id_docente_grupo_esp = $reg[$i]["id_docente_grupo_esp"];
					$rspta3 = $consulta->docente_grupo_por_id($id_docente_grupo_esp);
					// si existe registro
					$resultadorspta3 = $rspta3 ? 1 : 0;
					// si existe horario para la clase
					if ($resultadorspta3 == 1) {
						$id_docente = $rspta3["id_docente"];
						// se toma el id del docente grupo especial
						$id_docente_grupo = $rspta3["id_docente_grupo"];
						$rspta4 = $consulta->docente_datos($id_docente);
						if (file_exists('../files/docentes/' . $rspta4["usuario_identificacion"] . '.jpg')) {
							$foto = '<img src=../files/docentes/' . $rspta4["usuario_identificacion"] . '.jpg width=30px height=30px class=img-circle>';
						} else {
							$foto = '<img src=../files/null.jpg width=30px height=30px class=img-circle>';
						}
						$nombredeldocente = $rspta4["usuario_nombre"] . ' ' . $rspta4["usuario_nombre_2"] . ' <br>' . $rspta4["usuario_apellido"] . ' ' . $rspta4["usuario_apellido_2"];
						$horario = '<b>' . $rspta3["dia"] . '</b> ' . $rspta3["hora"] . ' - ' . $rspta3["hasta"] . ' - corte ' . $rspta3["corte"];
						if ($reg[$i]["id_pea"] == null) { // si el estudiante no tiene PEA

							$rsptatienepea = $consulta->docente_pea($id_docente_grupo);
							$tienepea = $rsptatienepea ? 1 : 0; // si existe registro
							if ($tienepea == 1) {
								$botonpea = '<a onclick=validar_pea(' . $num_id . ',' . $ciclo . ',' . $reg[$i]["id_materia"] . ',' . $id_docente_grupo . ') class="btn btn-primary btn-xs" title="PLan Educativo sin Activar">Activar PEA </a>';
							} else { // no tiene pea
								$botonpea = "En proceso";
							}
						} else { // si ya tiene pea
							$botonpea = '<a onclick=verPanel(' . $id_docente_grupo . ') class="btn btn-success btn-sm text-white" title="Plan Educativo de Aula">Ver PEA</a>';
						}
					} else { // no existe doente para la clase
						$foto = "";
						$nombredeldocente = "";
						$horario = "";
					}
					$data["0"] .= '<tr>
								<td style="width:70px">
									<span id=' . $num_id . '>';
					$data["0"] .= $botonpea;
					$data["0"] .= '
								</span>
								<span id="mostrar_' . $num_id . '" style="display:none">
									<a onclick=verPanel(' . $id_docente_grupo . ') class="btn btn-success" title="Plan Educativo de Aula">Ver PEA</a>
								</span>
						</td>';
					$data["0"] .= '
								<td style="width:250px">
								
									<span class="label label-default" title="Créditos"><b>[' . $reg[$i]["creditos"] . ']</b></span> ' .
					$reg[$i]["nombre_materia"] . '
								</td>
								<td >' .
					$foto . '
								</td>
								<td  style="width:150px">' . $nombredeldocente . '</td>';
					$inicio_cortes = 1;
					$corte_nota = "";
					while ($inicio_cortes <= $cortes) {
						$corte_nota = "c" . $inicio_cortes;
						$data["0"] .= '<td>' . $reg[$i][$corte_nota] . '</td>';
						$inicio_cortes++;
					}
					$data["0"] .= '
								<td class="bg-primary">' . $reg[$i]["promedio"] . '</td>
								<td>';
						// tomamos rspta3 que es el que nos trae los datos del horario del docente especial
						$n_dia = $rspta3["dia"];
						$n_hora = $rspta3["hora"];
						$n_hasta = $rspta3["hasta"];
						$n_corte = $rspta3["corte"];
						$n_salon = $rspta3["salon"];
						$data["0"] .= '<b>' . $n_dia . '</b> ' . $n_hora . ' - ' . $n_hasta . ' <b>Salón</b> ' . $n_salon . ' - corte ' . $n_corte . '<br>';
					$data["0"] .= '</td>
								<td style="width:50px">' . $reg[$i]["faltas"] . '</td>
							</tr>
							';
					$num_id++;
				}
			}
		}
		$data["0"] .= '
				</tbody>
			</table>
		</div>';
		$results = array($data);
		echo json_encode($results);
    break;
	case 'validar_pea':
		$ciclo = $_POST["ciclo"];
		$id_estudiante_materia = $_POST["id_estudiante_materia"];
		$id_docente_materia = $_POST["id_docente_materia"];
		$rspta = $consulta->docente_pea($id_docente_materia);
		$reg = $rspta;
		$id_pea = $reg["id_pea"];
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$data["0"] .= $id_pea;
		if ($id_pea != "") {
			$rspta2 = $consulta->asignar_pea_docente($ciclo, $id_pea, $id_estudiante_materia);
		}
		$results = array($data);
		echo json_encode($results);
    break;
	case 'verpanel':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$rspta = $consulta->listar_pea($id_docente_grupo, $periodo_actual);
		$reg = $rspta;
		$id_pea = $reg["id_pea"]; //contiene id del pea//
		$id_pea_docentes = $reg["id_pea_docentes"];
		$descripcion = $reg["descripcion"]; //contiene id del pea//
		$referencias = $reg["referencias"]; //contiene id del pea//
		$observaciones = $reg["observaciones"]; //contiene id del pea//	
		$recursos = $reg["recursos"]; //contiene id del pea//
		$datosdocentegrupo = $consulta->datosdocentegrupo($id_docente_grupo, $periodo_actual);
		$id_materia = $datosdocentegrupo["id_materia"];
		$grupo = $datosdocentegrupo["grupo"];
		$ciclo = $datosdocentegrupo["ciclo"];
		$datosmateria = $consulta->datosmateria($id_materia);
		$nombremateria = $datosmateria["nombre"];
		$id_programa_ac = $datosmateria["id_programa_ac"];
		$data["0"] .= '<div class="row">';
		$data["0"] .= '<div class="col-12 text-right">
								<a href="estudiante.php?id=' . $_SESSION['id_estudiante_programa'] . '&ciclo=' . $ciclo . '&id_programa=' . $id_programa_ac . '&grupo=' . $grupo . '"  title="Listado de materias">
									Listado de materias
								</a>/ Contenidos
							</div>';
		$data["0"] .= '<div class="col-12 titulo-5 text-center mt-1 mb-4">' . $nombremateria . ' </div>';
		$data["0"] .= '<div class="col-xl-3">';
		$data["0"] .= '
				<div class="post-module">
					<div class="thumbnail">
						<div class="date" title="iniciado">
							<div class="day">PEA</div>
							<div class="month">CIAF</div>
						</div>
						<img src="../files/pea/descripcion.webp" alt="Ejercicio">
					</div>
					<div class="post-content">
						<div class="category text-white">Proyecto de aula</div>
						<h2 class="title">' . $nombremateria . '</h2>
						<p class="text-danger">Contenido temático</p>
						<p class="description" style="display: none; opacity: 1;">descripción</p>
						<div class="post-meta">
							<a onclick="descripcion(' . $id_pea . ')" title="Descripción de la asignatura" class="btn bg-orange text-white">Ver proyecto</a>
						</div>
					</div>
				</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="col-xl-3">';
		$data["0"] .= '
				<div class="post-module">
					<div class="thumbnail">
						<div class="date" title="iniciado">
							<div class="day">DOC</div>
							<div class="month">CIAF</div>
						</div>
						<img src="../files/pea/documentos.webp" alt="Ejercicio">
					</div>
					<div class="post-content">
						<div class="category text-white">Documentos de apoyo</div>
						<h2 class="title">' . $nombremateria . '</h2>
						<p class="text-danger">Material de apoyo</p>
						<p class="description" style="display: none; opacity: 1;">descripción</p>
						<div class="post-meta">
							<a onclick="documentos(' . $id_pea_docentes . ',' . $id_programa_ac . ')" title="Documentos" class="btn bg-orange text-white">Ver Documentos</a>
						</div>
					</div>
				</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="col-xl-3">';
		$data["0"] .= '
				<div class="post-module">
					<div class="thumbnail">
						<div class="date" title="iniciado">
							<div class="day">ENL</div>
							<div class="month">CIAF</div>
						</div>
						<img src="../files/pea/enlaces.webp" alt="Ejercicio">
					</div>
					<div class="post-content">
						<div class="category text-white">Enlaces de apoyo</div>
						<h2 class="title">' . $nombremateria . '</h2>
						<p class="text-danger">Enlaces Web (https)</p>
						<p class="description" style="display: none; opacity: 1;">descripción</p>
						<div class="post-meta">
							<a onclick="enlaces(' . $id_pea_docentes . ',' . $id_programa_ac . ')" title="Enlaces" class="btn bg-orange text-white">Ver Enlaces</a>
						</div>
					</div>
				</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="col-xl-3">';
		$data["0"] .= '
				<div class="post-module">
					<div class="thumbnail">
						<div class="date" title="iniciado">
							<div class="day">EJE</div>
							<div class="month">CIAF</div>
						</div>
						<img src="../files/pea/ejercicios.webp" alt="Ejercicio">
					</div>
					<div class="post-content">
						<div class="category text-white">Ejercicios</div>
						<h2 class="title">' . $nombremateria . '</h2>
						<p class="text-danger">Actividades calificables</p>
						<p class="description" style="display: none; opacity: 1;">descripción</p>
						<div class="post-meta">
							<a onclick="ejercicios(' . $id_pea_docentes . ',' . $id_programa_ac . ')" title="Ejercicios" class="btn bg-orange text-white">Ver Ejercicios</a>
						</div>
					</div>
				</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="col-xl-3">';
		$data["0"] .= '
				<div class="post-module">
					<div class="thumbnail">
						<div class="date" title="iniciado">
							<div class="day">LEC</div>
							<div class="month">CIAF</div>
						</div>
						<img src="../files/pea/lecciones.webp" alt="Ejercicio">
					</div>
					<div class="post-content">
						<div class="category text-white">Lecciones</div>
						<h2 class="title">' . $nombremateria . '</h2>
						<p class="text-danger">Próximamente</p>
						<p class="description" style="display: none; opacity: 1;">descripción</p>
						<div class="post-meta">
							<a onclick="lecciones()" title="Lecciones" class="btn bg-orange text-white">Ver Lecciones</a>
						</div>
					</div>
				</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="col-xl-3">';
		$data["0"] .= '
				<div class="post-module">
					<div class="thumbnail">
						<div class="date" title="iniciado">
							<div class="day">ANU</div>
							<div class="month">CIAF</div>
						</div>
						<img src="../files/pea/anuncios.webp" alt="Anuncios">
					</div>
					<div class="post-content">
						<div class="category text-white">Anuncios</div>
						<h2 class="title">' . $nombremateria . '</h2>
						<p class="text-danger">Próximamente</p>
						<p class="description" style="display: none; opacity: 1;">descripción</p>
						<div class="post-meta">
							<a onclick="anuncios()" title="Anuncios" class="btn bg-orange text-white">Ver Anuncios</a>
						</div>
					</div>
				</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="col-xl-3">';
		$data["0"] .= '
				<div class="post-module">
					<div class="thumbnail">
						<div class="date" title="iniciado">
							<div class="day">ANU</div>
							<div class="month">CIAF</div>
						</div>
						<img src="../files/pea/glosario.webp" alt="Glosario">
					</div>
					<div class="post-content">
						<div class="category text-white">Glosario</div>
						<h2 class="title">' . $nombremateria . '</h2>
						<p class="text-danger">Terminos o conceptos</p>
						<p class="description" style="display: none; opacity: 1;">Descripción</p>
						<div class="post-meta">
							<a onclick="glosario(' . $id_pea_docentes . ',' . $id_programa_ac . ')" title="Glosario" class="btn bg-orange text-white">Ver Glosario</a>
						</div>
					</div>
				</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '</div>';
		$results = array($data);
		echo json_encode($results);
    break;
	case 'descripcion':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_pea = $_POST["id_pea"];
		$datosdelpea = $consulta->datospea($id_pea);
		$id_materia = $datosdelpea["id_materia"];
		$fecha_aprobacion = $datosdelpea["fecha_aprobacion"];
		$version = $datosdelpea["version"];
		$datosmateria = $consulta->datosmateria($id_materia);
		$materia = $datosmateria["nombre"];
		$id_programa_ac = $datosmateria["id_programa_ac"];
		$semestre = $datosmateria["semestre"];
		$area = $datosmateria["area"];
		$creditos = $datosmateria["creditos"];
		$presenciales = $datosmateria["presenciales"];
		$independientes = $datosmateria["independiente"];
		$prerequisito = $datosmateria["prerequisito"];
		$datosprograma = $consulta->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$datosescuela = $consulta->datosescuela($id_escuela);
		$escuela = $datosescuela["escuelas"];
		if ($prerequisito == null) {
			$prerequisito = "";
		} else {
			$datosmateriapre = $consulta->datosmateriapre($prerequisito);
			$prerequisito = $datosmateriapre["nombre"];
		}
		$data["0"] .= '<div class="row justify-content-center">';
		$data["0"] .= '<div class="col-12 text-right">
									<a href="estudiante.php?id=' . $_SESSION['id_estudiante_programa'] . '&ciclo=' . $ciclo . '&id_programa=' . $id_programa_ac . '&grupo=' . $_SESSION['grupo_programa'] . '"  title="Listado de materias">
										Listado de grupos
									</a>/ 
									<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
									/ Descripción
								</div>';
		$data["0"] .= '<div class="col-xl-8 mt-2 p-0">';
		$data["0"] .= '<table class="table table-bordered">';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td><img src="../public/img/logo_print.jpg" width="150px"></td>';
		$data["0"] .= '<td><b>Fecha: </b>' . $fecha_aprobacion . '<br> <b>Versión: </b>' . $version . '</td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="col-xl-8 mt-1 p-0">';
		$data["0"] .= '<table class="table table-bordered">';
		$data["0"] .= '<thead>';
		$data["0"] .= '<th colspan="2" class="bg-1 text-center text-white">PROYECTO EDUCATIVO DE AULA</th>';
		$data["0"] .= '</thead>';
		$data["0"] .= '<tbody>';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td width="130px">Escuela</td>';
		$data["0"] .= '<td>' . $escuela . '</td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td>Programa</td>';
		$data["0"] .= '<td>' . $programa_ac . '</td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td>Semestre</td>';
		$data["0"] .= '<td>' . $semestre . '</td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td>Asignatura</td>';
		$data["0"] .= '<td>' . $materia . '</td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '</tbody">';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="col-xl-8 mt-2 p-0">';
		$data["0"] .= '<table class="table table-bordered">';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td width="130px">Prerequisitos</td>';
		$data["0"] .= '<td colspan="5">' . $prerequisito . '</td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td>Créditos Académicos</td>';
		$data["0"] .= '<td>' . $creditos . '</td>';
		$data["0"] .= '<td>Total de horas</td>';
		$data["0"] .= '<td colspan="3"></td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td >Área de formación</td>';
		$data["0"] .= '<td >' . $area . '</td>';
		$data["0"] .= '<td>Trabajo Directo</td>';
		$data["0"] .= '<td>' . $presenciales . '</td>';
		$data["0"] .= '<td>Trabajo Independiente</td>';
		$data["0"] .= '<td>' . $independientes . '</td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="border col-xl-8 mt-1 p-0">';
		$data["0"] .= '<div class="border col-12 bg-1 p-2 m-0 text-white text-center"> COMPETENCIA DE LA ASIGNATURA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
										' . $datosdelpea["competencias"] . '
									</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="border col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="border col-12 bg-1 p-2 m-0 text-white text-center"> RESULTADO DE APRENDIZAJE </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
						' . $datosdelpea["resultado"] . '
					</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="border col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="border col-12 bg-1 p-2 m-0 text-white text-center"> CRITERIOS DE EVALUACIÓN DE LA ASIGNATURA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
						' . $datosdelpea["criterio"] . '
					</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="border col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="border col-12 bg-1 p-2 m-0 text-white text-center"> METODOLOGÍA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
							' . $datosdelpea["metodologia"] . '
						</div>';
		$data["0"] .= '</div>';
		/* consulta para teaer los temas */
		$data["0"] .= '<div class="border col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="border col-12 bg-1 p-2 m-0 text-white text-center"> Contenidos </div>';
		$data["0"] .= '<ul>';
		$rspta = $consulta->listar_temas($id_pea); //Consulta para ver los Temas del PEA
		for ($i = 0; $i < count($rspta); $i++) {
			$data["0"] .= '<li>' . $rspta[$i]["conceptuales"] . '</li>';
		}
		$data["0"] .= '</ul>';
		$data["0"] .= '</div>';
		/* **************************** */
		$data["0"] .= '<div class="border col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="border col-12 bg-1 p-2 m-0 text-white text-center"> REFERENCIAS </div>';
		$data["0"] .= '<ul>';
		$rspta2 = $consulta->verPeaReferencia($id_pea); //Consulta para ver los Temas del PEA
		for ($j = 0; $j < count($rspta2); $j++) {
			$data["0"] .= '<li>' . $rspta2[$j]["referencia"] . '</li>';
		}
		$data["0"] .= '</ul>';
		$data["0"] .= '</div>';
		$data["0"] .= '</div>';
		$results = array($data);
		echo json_encode($results);
    break;
	case 'documentos':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_pea_docente = $_POST["id_pea_docente"];
		$id_programa_ac = $_POST["id_programa_ac"];
		$datosprograma = $consulta->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$data["0"] .= '<div class="row justify-content-center">';
		$data["0"] .= '
				<div class="col-12 text-right">
					<a href="estudiante.php?id=' . $_SESSION['id_estudiante_programa'] . '&ciclo=' . $ciclo . '&id_programa=' . $id_programa_ac . '&grupo=' . $_SESSION['grupo_programa'] . '"  title="Listado de materias">
						Listado de materias
					</a>/ 
					<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
					/ Documentos
				</div>';
		/* consulta para teaer las carpetas */
		$rspta = $consulta->verCarpetas($id_pea_docente); //Consulta para ver llas carpetas
		for ($i = 0; $i < count($rspta); $i++) {
			if ($i == 0) {
				$colapso = "";
			} else {
				$colapso = "collapsed-card";
			}
			$data["0"] .= '
						<div class="col-12">
							<div class="card card-primary ' . $colapso . '">
								<div class="card-header">
									<h3 class="card-title">
										<a a onclick="editarCarpetaDocumento(' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" class="btn btn-warning btn-xs" title="Editar Carpeta"><i class="fas fa-edit"></i></a>
										' . $rspta[$i]["carpeta"] . '
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body p-0 m-0">';
			$data["0"] .= '<div class="row p-2">';
			/* consulta para traer los documentos de cada carpeta */
			$rsptadoc = $consulta->verPeaDocumentos($rspta[$i]["id_pea_documento_carpeta"]); //Consulta para ver los Temas del PEA
			for ($j = 0; $j < count($rsptadoc); $j++) {
				$id_pea_documento = $rsptadoc[$j]["id_pea_documento"];
				$tipo_archivo = $rsptadoc[$j]["tipo_archivo"];
				$nombre_documento = $rsptadoc[$j]["nombre_documento"];
				$descripcion_documento = $rsptadoc[$j]["descripcion_documento"];
				$archivo_documento = $rsptadoc[$j]["archivo_documento"];
				switch ($tipo_archivo) {
					case '1':
						$icono_doc = '../files/pea/imagen.webp';
						$documento_tipo = "Imagen";
						$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
						$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn bg-orange btn-sm text-white">Descargar</a>';
						break;
					case '2':
						$icono_doc = '../files/pea/word.webp';
						$documento_tipo = "Word";
						$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
						$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn bg-orange btn-sm text-white">Descargar</a>';
						break;
					case '3':
						$icono_doc = '../files/pea/excel.webp';
						$documento_tipo = "Excel";
						$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
						$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn bg-orange btn-sm text-white">Descargar</a>';
						break;
					case '4':
						$icono_doc = '../files/pea/powerpoint.webp';
						$documento_tipo = "PowerPoint";
						$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
						$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn bg-orange btn-sm text-white">Descargar</a>';
						break;
					case '5':
						$icono_doc = '../files/pea/pdf.webp';
						$documento_tipo = "PDF";
						$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
						$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn bg-orange btn-sm text-white">Descargar</a>';
						break;
					case '6':
						$icono_doc = '../files/pea/rar.webp';
						$documento_tipo = "Comprimido";
						$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
						$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn bg-orange btn-sm text-white">Descargar</a>';
						break;
					case '7':
						$icono_doc = '../files/pea/youtube.webp';
						$documento_tipo = "Video YOUTUBE";
						$linkdescarga = $archivo_documento;
						$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,2)" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
						break;
					case '8':
						$icono_doc = '../files/pea/drive.webp';
						$documento_tipo = "Link DRIVE";
						$linkdescarga = $archivo_documento;
						$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,2)" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
						break;
					case '9':
						$icono_doc = '../files/pea/meet.webp';
						$documento_tipo = "Link WEB";
						$linkdescarga = $archivo_documento;
						$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,2)" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
						break;
				}
				$data["0"] .= '<div class="col-xl-3">';
				$data["0"] .= '<div class="post-module">
									<!-- Thumbnail-->
									<div class="thumbnail">
									<div class="date">
										<div class="day">27</div>
										<div class="month">Mar</div>
									</div>
									<img src="' . $icono_doc . '" alt="Documento de imagen">
									</div>
									<!-- Post Content-->
									<div class="post-content">
									<div class="category">' . $documento_tipo . '</div>
									<h1 class="title">' . $nombre_documento . '</h1>
									<h2 class="sub_title">Entregable</h2>
									
									<p class="description" style="display: none; height: 76px; opacity: 1;">' . $descripcion_documento . '</p>
									<div class="post-meta">
										' . $btnlinkdescargar . '
										<span class="comments"><i class="bi bi-chat-dots-fill"></i><a href="#"> Comentar </a></span>
									</div>
									</div>
								</div>';
				$data["0"] .= '</div>';
			}
			/* **************************** */
			$data["0"] .= '</div>';
			$data["0"] .= '
								</div>
							</div>
						</div>';
		}
		/* **************************** */
		$data["0"] .= '</div>';
		$results = array($data);
		echo json_encode($results);
    break;
	case 'ejercicios':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_pea_docente = $_POST["id_pea_docente"];
		$id_programa_ac = $_POST["id_programa_ac"];
		$datosprograma = $consulta->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$data["0"] .= '<div class="row justify-content-center">';
		$data["0"] .= '
		<div class="col-12 text-right">
			<a href="estudiante.php?id=' . $_SESSION['id_estudiante_programa'] . '&ciclo=' . $ciclo . '&id_programa=' . $id_programa_ac . '&grupo=' . $_SESSION['grupo_programa'] . '"  title="Listado de materias">
				Listado de materias
			</a>/ 
			<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
			/ Ejercicios
		</div>';
		/* consulta para teaer las carpetas */
		$rspta = $consulta->verCarpetasEjercicios($id_pea_docente); //Consulta para ver llas carpetas
		for ($i = 0; $i < count($rspta); $i++) {
			if ($i == 0) {
				$colapso = "";
			} else {
				$colapso = "collapsed-card";
			}
			$data["0"] .= '
				<div class="col-12">
					<div class="card card-primary ' . $colapso . '">
						<div class="card-header">
							<h3 class="card-title">
								
								' . $rspta[$i]["carpeta_ejercicios"] . '
							</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>';
			$data["0"] .= '<div class="row p-2">';
			/* consulta para traer los documentos de cada carpeta */
			$rsptadoc = $consulta->verPeaDocumentosEjercicios($rspta[$i]["id_pea_ejercicios_carpeta"]); //Consulta para ver los Temas del PEA
			for ($j = 0; $j < count($rsptadoc); $j++) {
				$id_pea_ejercicios = $rsptadoc[$j]["id_pea_ejercicios"];
				$nombre_ejercicios = $rsptadoc[$j]["nombre_ejercicios"];
				$descripcion_ejercicios = $rsptadoc[$j]["descripcion_ejercicios"];
				$tipo_archivo = $rsptadoc[$j]["tipo_archivo"];
				$archivo_ejercicios = $rsptadoc[$j]["archivo_ejercicios"];
				$fecha_inicio = $rsptadoc[$j]["fecha_inicio"];
				$fecha_entrega = $rsptadoc[$j]["fecha_entrega"];
				$fecha_publicación = $rsptadoc[$j]["fecha_publicacion"];
				$hora_publicación = $rsptadoc[$j]["hora_publicacion"];
				$ciclo = $rsptadoc[$j]["ciclo"];
				$linkdescarga = "../files/pea/ciclo" . $ciclo . "/ejercicios/" . $archivo_ejercicios;
				$fecha_inicio_evento = date($fecha_inicio);
				$dia = date("d", strtotime($fecha_inicio_evento));
				$mes = date("m", strtotime($fecha_inicio_evento));
				/* calcular los dias que hacen falta para entregar el ejercicio */
				$fechahoy = new DateTime($fecha);
				$f_final = new DateTime($fecha_entrega);
				$diferencia = $fechahoy->diff($f_final)->format("%r%a");
				/* *************************** */
				switch ($tipo_archivo) {
					case '1':
						$icono_doc = '../files/pea/imagen.webp';
						$documento_tipo = "Imagen";
						break;
					case '2':
						$icono_doc = '../files/pea/word.webp';
						$documento_tipo = "Word";
						break;
					case '3':
						$icono_doc = '../files/pea/excel.webp';
						$documento_tipo = "Excel";
						break;
					case '4':
						$icono_doc = '../files/pea/powerpoint.webp';
						$documento_tipo = "PowerPoint";
						break;
					case '5':
						$icono_doc = '../files/pea/pdf.webp';
						$documento_tipo = "PDF";
						break;
					case '6':
						$icono_doc = '../files/pea/rar.webp';
						$documento_tipo = "Comprimido";
						break;
				}
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
				$traerarchivoestudiante = $consulta->taerArchivoEstudiante($id_pea_ejercicios, $_SESSION['id_estudiante_programa']);
				$tienarchivoest = $traerarchivoestudiante ? "1" : "2";
				if ($fecha >= $fecha_inicio) {
					if ($diferencia < 0) { // quiere decir que termino el evento
						$botondescarga = '<a href="' . $linkdescarga . '" target="_blank" class="btn bg-orange btn-sm text-white">Finalizado</a>';
						$botonenviar = '';
						$diaevento = '
											<div class="date bg-orange" title="iniciado" style="width:65px; height:65px">
												<div class="small text-white">Finalizó</div>
												<div class="day text-white">0</div>
												<div class="month text-white">Días</div>
											</div>';
						$categoria = '<div class="category bg-orange text-white">' . $documento_tipo . '</div>';
					} else { // el evento esta activo
						if ($tienarchivoest == 1) { // ya subio archivo
							$archivo_ejercicios_est = $traerarchivoestudiante["archivo_ejercicios"];
							$ciclo_est = $traerarchivoestudiante["ciclo"];
							$linkdescargaest = "../files/pea/ciclo" . $ciclo_est . "/ejerciciosest/" . $archivo_ejercicios_est;
							$botondescarga = '<a href="' . $linkdescargaest . '" target="_blank" class="btn btn-success btn-sm text-white"><i class="fas fa-eye"></i> Enviado </a>';
							$botonenviar = '<small title="Fecha de publicación">' . $consulta->fechaesp($traerarchivoestudiante["fecha_enviado"]) . '</small>';
						} else {
							$botondescarga = '<a href="' . $linkdescarga . '" target="_blank" class="btn btn-primary btn-sm text-white"><i class="fas fa-eye"></i> Ver Ejercicio </a>';
							$botonenviar = '<a onclick=enviarEjercicios("' . $id_pea_ejercicios . '","' . $id_pea_docente . '") class="btn btn-default btn-sm" title="Enviar ejercicio en formato RAR"><i class="fas fa-file-archive text-danger"></i> Enviar Ejercicio</a>';
						}
						$diaevento = '
											<div class="date" title="iniciado" style="width:65px; height:65px">
												<div class="small">Faltan</div>
												<div class="day">' . $diferencia . '</div>
												<div class="month">Días</div>
											</div>';
						$categoria = '<div class="category">' . $documento_tipo . '</div>';
					}
				} else { // el evento no ha iniciado
					$botondescarga = '<a href="#" class="btn bg-1 btn-sm text-white">Proximamente</a>';
					$botonenviar = '';
					$diaevento = '
										<div class="date bg-1" title="inicia el" style="width:65px; height:65px">
											<div class="small">Inicia</div>
											<div class="day">' . $dia . '</div>
											<div class="month">' . $meses . '</div>
										</div>';
					$categoria = '<div class="category bg-1">' . $documento_tipo . '</div>';
				}
				$data["0"] .= '<div class="col-xl-3">';
				$data["0"] .= '
										<div class="post-module">
											<div class="thumbnail">
												' . $diaevento . '
												<img src="' . $icono_doc . '" alt="Ejercicio">
											</div>
											<div class="post-content">
												' . $categoria . '
												<h1 class="title">' . $nombre_ejercicios . '</h1>
												<p class="text-danger">Hasta: ' . $consulta->fechaesp($fecha_entrega) . '</p>
												<p class="description" style="display: none; height: 76px; opacity: 1;">' . $descripcion_ejercicios . '</p>
												<div class="post-meta">
													' . $botondescarga . ' ' . $botonenviar . '
												</div>
											</div>
										</div>';
				$data["0"] .= '</div>';
			}
			/* **************************** */
			$data["0"] .= '</div>';
			$data["0"] .= '</div>';
			$data["0"] .= '</div>';
		}
		$data["0"] .= '</div>';
		$results = array($data);
		echo json_encode($results);
    break;
	case 'demoossss':
		$data["0"] .= '<div class="sticky"><a class="btn btn-danger float-right " onclick="cerrarPea()"><i class="fas fa-chevron-left"></i> Volver a notas</a></div><br><br>';
		$data["0"] .= '<ul class="timeline">';
		$rspta2 = $consulta->listar_temas($id_pea);
		$reg2 = $rspta2;
		$contador_temas = 1;
		for ($i = 0; $i < count($reg2); $i++) {
			$conceptuales = $reg2[$i]["conceptuales"];
			$id_tema = $reg2[$i]["id_tema"];
			$data["0"] .= '
			<div class="row">
			<div class="col-md-12">
			<!-- The time line -->
			<div class="timeline">
				<!-- timeline time label -->
				<div class="time-label">
				<span class="bg-red"> Tema: ' . $contador_temas++ . '</span>
				</div>
				<!-- /.timeline-label -->
				<!-- timeline item -->
				<div>
				<i class="fas fa-envelope bg-blue"></i>
				<div class="timeline-item">
					<span class="time"><i class="fas fa-clock"></i> --</span>
					<h3 class="timeline-header"><a href="#">' . $conceptuales . '</a> --</h3>';
			$rspta3 = $consulta->listar_actividades($id_tema, $id_docente_grupo);
			$reg3 = $rspta3;
			for ($k = 0; $k < count($reg3); $k++) {
				$id_pea_actividades = $reg3[$k]["id_pea_actividades"];
				$nombre_actividad = $reg3[$k]["nombre_actividad"];
				$descripcion_actividad = $reg3[$k]["descripcion_actividad"];
				$fecha_actividad = $reg3[$k]["fecha_actividad"];
				$pic_archivo = $consulta->tipoarchivo($reg3[$k]["tipo_archivo"]);
				$icono = $pic_archivo["icono"];
				$data["0"] .= '
						<div class="row">
							<div class="col-xl-6 col-md-6 col-sm-6 col-12">
								<div class="info-box">
								<span class="info-box-icon bg-info">' . $icono . '</span>
	
								<div class="info-box-content">
									<span class="info-box-text">' . $nombre_actividad . '</span>
									<span class="info-box-text">' . $descripcion_actividad . '</span>
									<span class="info-box-number"><i>Publicado: ' . $consulta->fechaesp($fecha_actividad) . '</i></span>';

				if ($reg3[$k]["tipo_archivo"] == 1 or $reg3[$k]["tipo_archivo"] == 2) {
					$data["0"] .= '
										<a href="../files/pea/' . $reg3[$k]["archivo_actividad"] . '" target="_blank" class="product-title">
										<span class="btn btn-warning pull-right">Descargar</span>
										</a>';
				} else {
					$data["0"] .= '
										<a href="' . $reg3[$k]["archivo_actividad"] . '" target="_blank" class="product-title">
										<span class="btn btn-warning pull-right">Enlace</span>
										</a>';
				}
				$data["0"] .= '		
								</div>
								<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
						</div>';
			}
			$data["0"] .= '
			  </div>
			</div>
			<!-- END timeline item -->
		  </div>
		</div>
		<!-- /.col -->
	  </div>';
		}
		$data["0"] .= '</ul>';
    break;
	case 'iniciarcalendario2':
		$id_estudiante = $_POST["id_estudiante"]; // id del estudiante
		$ciclo = $_POST["ciclo"]; // ciclo
		$id_programa = $_POST["id_programa"]; // programa del estudiante
		$grupo = $_POST["grupo"]; // programa del estudiante
		$impresion = "";
		$rspta = $consulta->listar($id_estudiante, $ciclo, $grupo);
		$reg = $rspta;
		$rspta2 = $consulta->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$inicio_cortes = 1;

		if ($ciclo == 9) {

			$homologados = $consulta->docente_grupo_horario($id_estudiante);
			$reg_h = $homologados;
			$huella = $homologados["huella"];

			$impresion .= '[';
			$huella = "";
			for ($i = 0; $i < count($reg_h); $i++) {
				$id_docente_grupo = $reg_h[$i]["id_docente_grupo"];
				$nombre_materia = $reg_h[$i]["nombre_materia"];
				$id_materia = $reg_h[$i]["id_materia"];
				$salon = $reg_h[$i]["salon"];
				$diasemana = $reg_h[$i]["dia"];
				$horainicio = $reg_h[$i]["hora"];
				$horafinal = $reg_h[$i]["hasta"];
				$huella = $reg_h[$i]["huella"];
				$nombre_docente = $reg_h[$i]["usuario_nombre"] . ' ' . $reg_h[$i]["usuario_apellido"];
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
					case 'Domingo':
						$dia = 0;
						break;
				}
				if ($huella == "Homomologación") {
					$color = "green";
					$huella = ($reg_h[$i]["huella"] = "") ? ' Sin homologar' : 'Homologada';
				} else {
					$color = "blue";
				}
				$impresion .= '{"title":"' . $nombre_materia . ' - Salón ' . $salon . ' - doc: ' . $nombre_docente . ' -  Estado ' . $huella . ' ","daysOfWeek":"' . $dia . '","startTime":"' . $horainicio . '","endTime":"' . $horafinal . '","color":"' . $color . '"}';
				if ($i + 1 < count($reg_h)) {
					$impresion .= ',';
				}
			}
			$impresion .= ']';
			echo $impresion;
		} else {
			$impresion .= '[';
			for ($i = 0; $i < count($reg); $i++) {
				$buscaridmateria = $consulta->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
				$idmateriaencontrada = $buscaridmateria["id"];
				$rspta3 = $consulta->docente_grupo_calendario($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
				for ($j = 0; $j < count($rspta3); $j++) {
					@$id_docente = $rspta3[$j]["id_docente"];
					@$id_docente_grupo = $rspta3[$j]["id_docente_grupo"];
					@$id_materia = $rspta3[$j]["id_materia"];
					@$salon = $rspta3[$j]["salon"];
					@$diasemana = $rspta3[$j]["dia"];
					@$horainicio = $rspta3[$j]["hora"];
					@$horafinal = $rspta3[$j]["hasta"];
					@$corte = $rspta3[$j]["corte"];
					$datosmateria = $consulta->BuscarDatosAsignatura($id_materia);
					@$nombre_materia = $datosmateria["nombre"];
					if ($id_docente == null) {
						$nombre_docente = "Sin Asignar";
					} else {
						$datosdocente = $consulta->docente_datos($id_docente);
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
						case 'Domingo':
							$dia = 0;
							break;
					}
					if ($corte == "1") {
						$color = "#fff";
					} else {
						$color = "#252e53";
					}
					$impresion .= '{"title":"' . $nombre_materia . ' - Salón ' . $salon . ' - doc: ' . $nombre_docente . ' ","daysOfWeek":"' . $dia . '","startTime":"' . $horainicio . '","endTime":"' . $horafinal . '","color":"' . $color . '"}';
					if ($i + 1 < count($reg)) {
						$impresion .= ',';
					}
				}
			}
			$impresion .= ']';
			echo $impresion;
			// echo json_encode($impresion);
		}
    break;
	case 'descargarDoc':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$_SESSION['id_usuario'];
		$id_pea_documento = $_POST["id_pea_documento"];
		$insertardescarga = $consulta->insertarDescarga($id_pea_documento, $_SESSION['id_usuario'], $fecha, $hora);
		$resultado = $insertardescarga ? "1" : "2";
		$data["0"] .= "1";
		$results = array($data);
		echo json_encode($results);
    break;
	case 'enlaces':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_pea_docente = $_POST["id_pea_docente"];
		$id_programa_ac = $_POST["id_programa_ac"];
		$datosprograma = $consulta->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$data["0"] .= '<div class="row">';
		$data["0"] .= '
		<div class="col-12 text-right pr-2">
			<a href="estudiante.php?id=' . $_SESSION['id_estudiante_programa'] . '&ciclo=' . $ciclo . '&id_programa=' . $id_programa_ac . '&grupo=' . $_SESSION['grupo_programa'] . '"  title="Listado de materias">
				Listado de materias
			</a>/ 
			<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
			/ Enlaces
		</div>';
		$data["0"] .= '
		<div class="col-12 border-bottom">
			<span class="titulo-4">Enlaces</span>
		</div>';
		/* consulta para teaer los enlaces */
		$rspta = $consulta->verEnlaces($id_pea_docente); //Consulta para ver los enlaces
		for ($i = 0; $i < count($rspta); $i++) {
			$id_pea_enlaces = $rspta[$i]["id_pea_enlaces"];
			$titulo_enlace = $rspta[$i]["titulo_enlace"];
			$descripcion = $rspta[$i]["descripcion_enlace"];
			$enlace = $rspta[$i]["enlace"];
			$fecha = $rspta[$i]["fecha_enlace"];
			$hora = $rspta[$i]["hora_enlace"];
			$data["0"] .= '<div class="col-xl-3 mt-4">';
			$data["0"] .= '
						<div class="post-module" style="height:190px">
							<div class="thumbnail" style="height:60px">
							<img src="../files/pea/imagen.webp" alt="Documento de imagen">
							</div>
							<div class="post-content">
								<div class="category">' . $titulo_enlace . '</div>
								<p class="description" style="display: none; height: 76px; opacity: 1;">' . $descripcion . '</p>
								<div class="post-meta">
									<a href="' . $enlace . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver enlace</a>	
								</div>
							</div>
						</div>';
			$data["0"] .= '</div>';
		}
		$data["0"] .= '</div>';
		$results = array($data);
		echo json_encode($results);
    break;
	case 'glosarioCabecera':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_pea_docente = $_POST["id_pea_docente"];
		$id_programa_ac = $_POST["id_programa_ac"];
		$datosprograma = $consulta->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$data["0"] .= '<div class="row">';
		$data["0"] .= '
			<div class="col-12 text-right">
				<a href="estudiante.php?id=' . $_SESSION['id_estudiante_programa'] . '&ciclo=' . $ciclo . '&id_programa=' . $id_programa_ac . '&grupo=' . $_SESSION['grupo_programa'] . '"  title="Listado de materias">
					Listado de materias
				</a>/ 
				<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
				/ Glosario
			</div>';
		$data["0"] .= '</div>';
		$results = array($data);
		echo json_encode($results);
    break;
	case 'glosario':
		//Vamos a declarar un array
		$data = array();
		$id_pea_docente = $_GET["id_pea_docente"];
		$verglosario = $consulta->verGlosario($id_pea_docente);
		$reg = $verglosario;
		for ($i = 0; $i < count($reg); $i++) {
			$id_pea_glosario = $reg[$i]["id_pea_glosario"];
			$titulo = $reg[$i]["titulo_glosario"];
			$definicion_glosario = $reg[$i]["definicion_glosario"];
			$fecha_glosario = $reg[$i]["fecha_glosario"];
			$hora_glosario = $reg[$i]["hora_glosario"];
			$fecha = $consulta->fechaesp($fecha_glosario);
			$data[] = array(
				"0" => $titulo,
				"1" => $definicion_glosario,
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
	case "enviarcorreonotificacionestudiante":
		$id_pea_docente_global = $_POST["id_pea_docente_global"];
		$id_pea_ejercicios_global = $_POST["id_pea_ejercicios_global"];
		$archivo_ejercicios_final = $_POST["nombre_archivo_global"];
		$traerNombreEjercicio = $consulta->traerNombreEjecicio($id_pea_ejercicios_global);
		$nombre_ejercicios = $traerNombreEjercicio["nombre_ejercicios"];
		$traerid_pea_docentes = $consulta->traeridpeadocente($id_pea_docente_global);
		// var_dump($id_pea_docente_global);
		$traeredatosdocentegrupos = $consulta->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $consulta->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $consulta->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		//$credencial_login = "ja.perez30@ciaf.edu.co";
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $consulta->estudiante_datos_personales($id_credencial);
		$celular = $datos_estudiante["celular"];
		$template = set_template_notificacion_estudiante($nombre_estudiante, $credencial_identificacion, $archivo_ejercicios_final, $credencial_login, $celular);
		// correo de docente
		$destino = $usuario_login . ", " . $credencial_login;
		//$destino = "ja.perez30@ciaf.edu.co, david.gonzalez@ciaf.edu.co";
		$asunto = $nombre_estudiante . " ha enviado el ejercicio '" . $nombre_ejercicios . "'";
		$data = array();
		if (enviar_correo($destino, $asunto, $template)) {
			$data = array(
				'exito' => '1',
				'info' => 'Enviado Correctamente.'
			);
		} else {
			$data = array(
				'exito' => '0',
				'info' => 'Error consulta fallo'
			);
		}
		echo json_encode($data);
    break;
	case 'iniciarcalendario':

			$impresion = "";
            $control=1;
			$buscarprogramasmatriculados=$consulta->listarmatriculados($id_credencial,$periodo_actual);
			
			$impresion .= '[';
			for ($a = 0; $a < count($buscarprogramasmatriculados); $a++) {// lista los programa matriculados

				
				
				// if(count($buscarprogramasmatriculados)==1){// si solo tiene un programa matriculado en el periodo

				
					$id_estudiante=$buscarprogramasmatriculados[$a]["id_estudiante"];
					$ciclo=$buscarprogramasmatriculados[$a]["ciclo"];
					$grupo=$buscarprogramasmatriculados[$a]["grupo"];
					$id_programa=$buscarprogramasmatriculados[$a]["id_programa_ac"];

					
						$rspta = $consulta->listar($id_estudiante, $ciclo, $grupo);
						$reg = $rspta;
						$rspta2 = $consulta->programaacademico($id_programa);
						$cortes = $rspta2["cortes"];
						$inicio_cortes = 1;
			
						
						for ($i = 0; $i < count($reg); $i++) {
							$buscaridmateria = $consulta->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
							$idmateriaencontrada = $buscaridmateria["id"];
							$rspta3 = $consulta->docente_grupo_calendario($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
							
							for ($j = 0; $j < count($rspta3); $j++) {
								if($rspta3){

									if ($a>0) {
										$impresion .= ',';
									}

									if ($i>0) {
										$impresion .= ',';
									}

									@$id_docente = $rspta3[$j]["id_docente"];
									@$id_docente_grupo = $rspta3[$j]["id_docente_grupo"];
									@$id_materia = $rspta3[$j]["id_materia"];
									@$salon = $rspta3[$j]["salon"];
									@$diasemana = $rspta3[$j]["dia"];
									@$horainicio = $rspta3[$j]["hora"];
									@$horafinal = $rspta3[$j]["hasta"];
									@$corte = $rspta3[$j]["corte"];
									$datosmateria = $consulta->BuscarDatosAsignatura($id_materia);
									@$nombre_materia = $datosmateria["nombre"];
									if ($id_docente == null) {
										$nombre_docente = "Sin Asignar";
									} else {
										$datosdocente = $consulta->docente_datos($id_docente);
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
										case 'Domingo':
											$dia = 0;
											break;
									}
									if ($corte == "1") {
										$color = "#fff";
									} else {
										$color = "#252e53";
									}
									$impresion .= '{"title":"' . $nombre_materia . ' - Salón ' . $salon . ' - doc: ' . $nombre_docente . ' ","daysOfWeek":"' . $dia . '","startTime":"' . $horainicio . '","endTime":"' . $horafinal . '","color":"' . $color . '"}';
		
								}
							}


						}
						


				// }
					
			}

			$impresion .= ']';

		echo $impresion;
		//echo json_encode($impresion);
		

			
	break;


    case 'listar3':

        $buscarprogramasmatriculados=$consulta->listarmatriculados($id_credencial,$periodo_actual);
        //Vamos a declarar un array
        $data= Array();
        $reg=$rspta;
        

        for ($a = 0; $a < count($buscarprogramasmatriculados); $a++) {// lista los programa matriculados
            
            $id_estudiante=$buscarprogramasmatriculados[$a]["id_estudiante"];
            $ciclo=$buscarprogramasmatriculados[$a]["ciclo"];
            $grupo=$buscarprogramasmatriculados[$a]["grupo"];
            $id_programa=$buscarprogramasmatriculados[$a]["id_programa_ac"];

            
            $rspta = $consulta->listar($id_estudiante, $ciclo, $grupo);
            $reg = $rspta;
            $rspta2 = $consulta->programaacademico($id_programa);
            $cortes = $rspta2["cortes"];
            $inicio_cortes = 1;

            for ($i = 0; $i < count($reg); $i++) {
                $buscaridmateria = $consulta->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
                $idmateriaencontrada = $buscaridmateria["id"];
                $rspta3 = $consulta->docente_grupo_calendario($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
                
                for ($j = 0; $j < count($rspta3); $j++) {
                    if($rspta3){


                        @$id_docente = $rspta3[$j]["id_docente"];
                        @$id_docente_grupo = $rspta3[$j]["id_docente_grupo"];
                        @$id_materia = $rspta3[$j]["id_materia"];
                        @$salon = $rspta3[$j]["salon"];
                        @$diasemana = $rspta3[$j]["dia"];
                        @$horainicio = $rspta3[$j]["hora"];
                        @$horafinal = $rspta3[$j]["hasta"];
                        @$corte = $rspta3[$j]["corte"];
                        $datosmateria = $consulta->BuscarDatosAsignatura($id_materia);
                        @$nombre_materia = $datosmateria["nombre"];

                        $hora_formateada_i = date("g:i A", strtotime($horainicio)); // Convierte a formato 12
                        $hora_formateada_f = date("g:i A", strtotime($horafinal)); // Convierte a formato 12

                        if ($id_docente == null) {
                            $nombre_docente = "Sin Asignar";
                        } else {
                            $datosdocente = $consulta->docente_datos($id_docente);
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
                            case 'Domingo':
                                $dia = 0;
                                break;
                        }
                        if ($corte == "1") {
                            $color = "#fff";
                        } else {
                            $color = "#252e53";
                        }

                        $data[]=array(                
                            "0"=> $nombre_materia ,
                            "1"=> $nombre_docente,
                            "2"=> $diasemana,
                            "3"=> $hora_formateada_i,
                            "4"=> $hora_formateada_f,
                            "5"=> $salon
                            );

                    }
                }


            }
            
        
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;






}
