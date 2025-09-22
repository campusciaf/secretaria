<?php
session_start();
require_once "../modelos/CursoParaCreativos.php";
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$curso = new CursoParaCreativos();
switch ($_GET["op"]) {
	case 'listarCategorias':
		$reg = $curso->listarCategorias($_SESSION["id_usuario"]);
		// Vamos a declarar un array
		$html = "";
		$data["exito"] = 1;
		for ($i = 0; $i < count($reg); $i++) {
			// Verificamos si la categoría ya fue aprobada
			$aprobada = $curso->verificarAprobadas($reg[$i]["id_induccion_docente_categoria"], $_SESSION["id_usuario"]);
			if (count($aprobada) > 0) {
				$html .= '<div class="col mb-4">
							<div class="card card-primary card-outline pointer" onclick="mostrarVideoPreguntasAprobadas(' . $reg[$i]["id_induccion_docente_categoria"] . ')">
								<img src="https://img.youtube.com/vi/' . $reg[$i]["enlace_video_categoria"] . '/hqdefault.jpg" class="card-img-top" alt="' . $reg[$i]["nombre_categoria"] . '">
								<div class="card-body">
									<h4 class="font-weight-bold ">' . $reg[$i]["nombre_categoria"] . '</h4>
									<p class="card-text">
										<span class="badge badge-success"> Aprobada </span>
										<button class="btn btn-primary btn-xs rounded-pill" onclick="mostrarVideoPreguntasAprobadas(' . $reg[$i]["id_induccion_docente_categoria"] . ')"> <i class="fas fa-play"></i> Ver Video </button>
									</p>
								</div>
							</div>
						</div>';
			}else{
				$html .= '<div class="col mb-4">
							<div class="card card-primary card-outline pointer" onclick="mostrarVideoPreguntas(' . $reg[$i]["id_induccion_docente_categoria"] . ')">
								<img src="https://img.youtube.com/vi/' . $reg[$i]["enlace_video_categoria"] . '/hqdefault.jpg" class="card-img-top" alt="' . $reg[$i]["nombre_categoria"] . '">
								<div class="card-body">
									<h4 class="font-weight-bold ">' . $reg[$i]["nombre_categoria"] . '</h4>
									<p class="card-text">
										<span class="badge badge-warning"> Pendiente </span>
										<button class="btn btn-primary btn-xs rounded-pill" onclick="mostrarVideoPreguntas(' . $reg[$i]["id_induccion_docente_categoria"] . ')"> <i class="fas fa-play"></i> Ver Video </button>
									</p>
								</div>
							</div>
						</div>';
			}
		}
		if (count($reg) == 0) {
			$html = '<div class="col-12 text-center">
						<h4 class="text-muted"> No hay categorías pendientes </h4>
					</div>';
		}
		$data["html"] = $html;
		echo json_encode($data);
		break;
	case 'mostrarVideoPreguntas':
		$id_induccion_docente_categoria = isset($_POST['categoria']) ? limpiarCadena($_POST["categoria"]) : "";
		$rspta = $curso->mostrarCategoria($id_induccion_docente_categoria);
		if (isset($rspta["id_induccion_docente_categoria"])) {
			$data = array("exito" => 1, "enlace_video_categoria" => $rspta["enlace_video_categoria"]);
		} else {
			$data = array("exito" => 0, "info" => "No se encontró el video");
		}
		echo json_encode($data);
		break;
	case 'mostrarVideoPreguntasAprobadas':
		$id_induccion_docente_categoria = isset($_POST['categoria']) ? limpiarCadena($_POST["categoria"]) : "";
		$rspta = $curso->mostrarCategoria($id_induccion_docente_categoria);
		if (isset($rspta["id_induccion_docente_categoria"])) {
			$data = array("exito" => 1, "info" => '<iframe src="https://www.youtube.com/embed/' . $rspta["enlace_video_categoria"] . '" class="rounded mb-0" title="YouTube video player" frameborder="0" style="width: 100% !important; height: 70vh !important;"></iframe>');
		} else {
			$data = array("exito" => 0, "info" => "No se encontró el video");
		}
		echo json_encode($data);
		break;
	case 'listarPreguntas':
		$id_induccion_docente_categoria = isset($_POST['categoria']) ? limpiarCadena($_POST["categoria"]) : "";
		$data["exito"] = 0;
		$html = "";
		$reg = $curso->listarPreguntas($id_induccion_docente_categoria);
		for ($i = 0; $i < count($reg); $i++) {
			$data["exito"] = 1;
			$html .= '
				<div class="form-group">
					<label for="pregunta">' . ($i + 1) . '. Pregunta: ' . $reg[$i]["texto_pregunta"] . ' </label>';
			$total_opciones = $curso->listarOpciones($reg[$i]["id_pregunta"]);
			if ($reg[$i]["tipo_pregunta"] == "multiple") {
				for ($x = 0; $x < count($total_opciones); $x++) {
					$html .=
						'<div class="form-check">
							<input class="form-check-input pointer" type="radio" name="respuesta_pregunta_' . $reg[$i]["id_pregunta"] . '" id="respuesta_pregunta_' . $reg[$i]["id_pregunta"] . ($x + 1) . '" value="opcion' . ($x + 1) . '" required>
							<label class="form-check-label pointer" for="respuesta_pregunta_' . $reg[$i]["id_pregunta"] . ($x + 1) . '">
								' . $total_opciones[$x]["texto_opcion"] . '
							</label>
						</div>';
				}
			} else {
				$verdadero_falso = array("verdadero", "falso");
				for ($x = 0; $x < count($total_opciones); $x++) {
					$html .=
						'<div class="form-check">
							<input class="form-check-input pointer" type="radio" name="respuesta_pregunta_' . $reg[$i]["id_pregunta"] . '" id="respuesta_pregunta_' . $reg[$i]["id_pregunta"] . ($x + 1) . '" value="' . $verdadero_falso[$x] . '" required>
							<label class="form-check-label pointer" for="respuesta_pregunta_' . $reg[$i]["id_pregunta"] . ($x + 1) . '">
								' . $total_opciones[$x]["texto_opcion"] . '
							</label>
						</div>';
				}
			}
			$html .= '</div>';
		}
		$html .= '
				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary"> Responder </button>
				</div>
			</div>';
		$data["html"] = $html;
		echo json_encode($data);
		break;
	case 'verificarRespuestas':
		$cantidad_preguntas = 0;
		$cantidad_correctas = 0;
		foreach ($_POST as $key => $value) {
			if (strpos($key, 'respuesta_pregunta_') !== false) {
				$cantidad_preguntas++;
				$id_pregunta = explode("_", $key)[2];
				$rspta = $curso->mostrarPregunta($id_pregunta);
				$respuesta = $value;
				$opcion_correcta = $rspta["opcion_correcta"];
				$categoria = $rspta["categoria"];
				if ($respuesta == $opcion_correcta) {
					$cantidad_correctas++;
				}
			}
		}
		if ($cantidad_correctas == $cantidad_preguntas) {
			$curso->aprobarCategoria($_SESSION["id_usuario"], $categoria);
			$data = json_encode(array("exito" => 1, "correctas" => $cantidad_correctas, "total" => $cantidad_preguntas, "categoria" => $categoria));
		} else {
			$data = json_encode(array("exito" => 0, "correctas" => $cantidad_correctas, "total" => $cantidad_preguntas, "categoria" => $categoria));
		}
		echo $data;
		break;
}
