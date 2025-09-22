<?php
session_start();
require_once "../modelos/Curso_Docente.php";
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$curso = new Curso();
switch ($_GET["op"]) {
	case 'listarCategorias':
		$rspta = $curso->listarCategorias();
		// Vamos a declarar un array
		$data = array();
		$options = "";
		$reg = $rspta;

		for ($i = 0; $i < count($reg); $i++) {
			$id_induccion_docente_categoria = $reg[$i]["id_induccion_docente_categoria"];
			$cantidad_preguntas = $curso->cantidadPreguntas($id_induccion_docente_categoria);
			$options .= '<option value="' . $id_induccion_docente_categoria . '"> ' . $reg[$i]["nombre_categoria"] . '</option>';
			$data[] = array(
				"0" => '<button class="btn btn-danger pull-right" onclick="verVideo(' . $id_induccion_docente_categoria . ')">
							<i class="fa fa-play" aria-hidden="true"></i>
						</button>',
				"1" =>  $reg[$i]["nombre_categoria"] . '<br> <small class="badge bg-info btn-xs pointer" onclick="listarPreguntas(' . $id_induccion_docente_categoria . ')">' . $cantidad_preguntas . ' preguntas</small>',
				"2" => '<div class="btn-group"> 
							<button class="btn btn-warning btn-xs" onclick="mostrarCategoria(' . $id_induccion_docente_categoria . ')" title="Editar">
								<i class="fas fa-pencil-alt"></i>
							</button>
							<button class="btn btn-danger btn-xs" onclick="eliminarCategoria(' . $id_induccion_docente_categoria . ')" title="Eliminar Registro">
								<i class="far fa-trash-alt"></i>
							</button>
						</div>',
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data,
			"optionsCategorias" => $options
		);
		echo json_encode($results);
		break;
	case 'guardaryeditarCategoria':
		$id_induccion_docente_categoria = isset($_POST["id_induccion_docente_categoria"]) ? limpiarCadena($_POST["id_induccion_docente_categoria"]) : "";
		$nombre_categoria = isset($_POST["nombre_categoria"]) ? limpiarCadena($_POST["nombre_categoria"]) : "";
		$enlace_video_categoria = isset($_POST["enlace_video_categoria"]) ? limpiarCadena($_POST["enlace_video_categoria"]) : "";
		if (empty($id_induccion_docente_categoria)) {
			$rspta = $curso->insertarCategoria($nombre_categoria, $enlace_video_categoria);
		} else {
			$rspta = $curso->editarCategoria($id_induccion_docente_categoria, $nombre_categoria, $enlace_video_categoria);
		}
		if ($rspta) {
			$data = array("exito" => 1, "info" => "Categoria registrada con éxito");
		} else {
			$data = array("exito" => 0, "info" => "Error al registrar la categoria");
		}
		echo json_encode($data);
		break;
	case 'verVideo':
		$id_induccion_docente_categoria = $_POST["id_induccion_docente_categoria"];
		$ver_video = $curso->verVideo($id_induccion_docente_categoria);
		$url_video = $ver_video["enlace_video_categoria"];
		$data[0] = '<iframe src="https://www.youtube.com/embed/' . $url_video . '?controls=0&amp;" title="YouTube video player" frameborder="0" style="width: 478px !important; height: 341px !important;"></iframe>';
		echo json_encode($data);
		break;
	case 'listarPreguntas':
		$id_induccion_docente_categoria = $_POST["id_induccion_docente_categoria"];
		$rspta = $curso->listarPreguntas($id_induccion_docente_categoria);
		// Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$data[] = array(
				"0" => $reg[$i]["texto_pregunta"],
				"1" => $reg[$i]["opcion_correcta"],
				"2" => $reg[$i]["tipo_pregunta"],
				"3" => '<div class="btn-group"> 
								<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg[$i]["id_pregunta"] . ')" title="Editar">
								<i class="fas fa-pencil-alt"></i></button>
								<button class="btn btn-danger btn-xs" onclick="eliminar(' . $reg[$i]["id_pregunta"] . ')" title="Eliminar Registro">
								<i class="far fa-trash-alt"></i></button>
							</div>'
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
	case 'guardaryeditar':
		$id_pregunta = isset($_POST['id_pregunta']) ? limpiarCadena($_POST["id_pregunta"]) : "";
		$texto_pregunta = isset($_POST["texto_pregunta"]) ? limpiarCadena($_POST["texto_pregunta"]) : "";
		$opcion_correcta = isset($_POST["opcion_correcta"]) ? limpiarCadena($_POST["opcion_correcta"]) : null;
		$tipo_pregunta = isset($_POST["tipo_pregunta"]) ? limpiarCadena($_POST["tipo_pregunta"]) : null;
		$categoria = isset($_POST["categoria"]) ? limpiarCadena($_POST["categoria"]) : null;
		if (empty($opcion_correcta)) {
			$data = array("exito" => 0, "info" => "Debe seleccionar una opción correcta.");
			echo json_encode($data);
			exit();
		}
		if (empty($id_pregunta)) {
			// Insertar nueva pregunta
			$id_pregunta = $curso->agregarPregunta($texto_pregunta, $opcion_correcta, $tipo_pregunta, $categoria);
			if ($id_pregunta) {
				$data = array("exito" => 1, "info" => "Pregunta registrada con éxito");
				if ($tipo_pregunta == "multiple") {
					for ($i = 1; $i <= 4; $i++) {
						$texto_opcion = isset($_POST["opcion$i"]) ? limpiarCadena($_POST["opcion$i"]) : null;
						if (!empty($texto_opcion)) {
							$curso->agregarmultiple($texto_opcion, $id_pregunta);
						}
					}
				} elseif ($tipo_pregunta == "falsoVerdadero") {
					$respuesta_verdadero = isset($_POST["respuestaVerdadero"]) ? limpiarCadena($_POST["respuestaVerdadero"]) : null;
					$respuesta_falso = isset($_POST["respuestaFalso"]) ? limpiarCadena($_POST["respuestaFalso"]) : null;
					if (!empty($respuesta_verdadero)) {
						$curso->agregarverdaderofalso($respuesta_verdadero, $id_pregunta);
					}
					if (!empty($respuesta_falso)) {
						$curso->agregarverdaderofalso($respuesta_falso, $id_pregunta);
					}
				}
			} else {
				$data = array("exito" => 0, "info" => "Error al registrar la pregunta");
			}
		} else {
			// Editar pregunta existente
			$curso->editar($id_pregunta, $texto_pregunta, $opcion_correcta, $tipo_pregunta, $categoria);
			// Obtener opciones actuales
			$opciones_actuales = $curso->obtenerOpcionesPorPregunta($id_pregunta);
			$total_opciones_actuales = count($opciones_actuales);
			if ($tipo_pregunta == "multiple") {
				for ($i = 0; $i < 4; $i++) {
					$texto_opcion = isset($_POST["opcion" . ($i + 1)]) ? limpiarCadena($_POST["opcion" . ($i + 1)]) : null;
					if (isset($opciones_actuales[$i])) {
						// Editar opción existente
						$curso->editarOpcion($opciones_actuales[$i]['id_opcion'], $texto_opcion);
					} elseif (!empty($texto_opcion)) {
						// Agregar nueva opción si no existe en la base de datos
						$curso->agregarmultiple($texto_opcion, $id_pregunta);
					}
				}
				// Eliminar opciones sobrantes si hay más de 4
				if ($total_opciones_actuales > 4) {
					for ($j = 4; $j < $total_opciones_actuales; $j++) {
						$curso->eliminarOpciones($opciones_actuales[$j]['id_opcion']);
					}
				}
			} elseif ($tipo_pregunta == "falsoVerdadero") {
				$respuesta_verdadero = isset($_POST["respuestaVerdadero"]) ? limpiarCadena($_POST["respuestaVerdadero"]) : null;
				$respuesta_falso = isset($_POST["respuestaFalso"]) ? limpiarCadena($_POST["respuestaFalso"]) : null;
				if (isset($opciones_actuales[0])) {
					$curso->editarOpcion($opciones_actuales[0]['id_opcion'], $respuesta_verdadero);
				} else {
					$curso->agregarverdaderofalso($respuesta_verdadero, $id_pregunta);
				}
				if (isset($opciones_actuales[1])) {
					$curso->editarOpcion($opciones_actuales[1]['id_opcion'], $respuesta_falso);
				} else {
					$curso->agregarverdaderofalso($respuesta_falso, $id_pregunta);
				}
				// Eliminar opciones sobrantes si hay más de 2
				if ($total_opciones_actuales > 2) {
					for ($j = 2; $j < $total_opciones_actuales; $j++) {
						$curso->eliminarOpciones($opciones_actuales[$j]['id_opcion']);
					}
				}
			}
			$data = array("exito" => 1, "info" => "Pregunta actualizada con éxito");
		}
		echo json_encode($data);
		break;
	case 'mostrar':
		$id_pregunta = isset($_POST['id_pregunta']) ? limpiarCadena($_POST["id_pregunta"]) : "";
		$rspta = $curso->mostrar($id_pregunta);
		$opciones = $curso->mostrarOpciones($id_pregunta);
		$rspta["opciones"] = $opciones;
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case 'mostrarCategoria':
		$id_induccion_docente_categoria = isset($_POST['id_induccion_docente_categoria']) ? limpiarCadena($_POST["id_induccion_docente_categoria"]) : "";
		$rspta = $curso->mostrarCategoria($id_induccion_docente_categoria);
		echo json_encode($rspta);
		break;
	case 'eliminar':
		if (isset($_POST['id_pregunta'])) {
			$id_pregunta = $_POST['id_pregunta'];
			$rspta = $curso->eliminar($id_pregunta);
			if ($rspta) {
				$data = array("exito" => 1, "info" => "Pregunta eliminada con éxito");
			} else {
				$data = array("exito" => 0, "info" => "Error al eliminar la pregunta, ponte en contacto con el administrador del sistema.");
			}
			echo json_encode($data);
		} else {
			$data = array("exito" => 0, "info" => "error");
			error_log("error: " . json_encode($_POST));
			echo json_encode($data);
		}
		break;
	case 'eliminarCategoria':
		$id_induccion_docente_categoria = isset($_POST['id_induccion_docente_categoria']) ? limpiarCadena($_POST["id_induccion_docente_categoria"]) : "";
		$rspta = $curso->eliminarCategoria($id_induccion_docente_categoria);
		if ($rspta) {
			$data = array("exito" => 1, "info" => "Categoria eliminada con éxito");
		} else {
			$data = array("exito" => 0, "info" => "Error al eliminar la categoria, ponte en contacto con el administrador del sistema.");
		}
		echo json_encode($data);
		break;
}
