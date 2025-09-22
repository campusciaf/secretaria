<?php
date_default_timezone_set("America/Bogota");

require_once "../modelos/ConveniosDocumentacion.php";

$conveniosdocumentacion = new ConveniosDocumentacion();
$carpeta = isset($_POST["carpeta"]) ? limpiarCadena($_POST["carpeta"]) : "";
$nombre_convenio = isset($_POST["nombre_convenio"]) ? limpiarCadena($_POST["nombre_convenio"]) : "";
$id_convenio_documento = isset($_POST["id_convenio_documento"]) ? limpiarCadena($_POST["id_convenio_documento"]) : "";
$tipo = isset($_POST["tipo"]) ? limpiarCadena($_POST["tipo"]) : "";
$id_convenio_carpeta = isset($_POST["id_convenio_carpeta"]) ? limpiarCadena($_POST["id_convenio_carpeta"]) : "";
$id_convenio_documento_subir = isset($_POST["id_convenio_documento_subir"]) ? limpiarCadena($_POST["id_convenio_documento_subir"]) : "";
$id_convenio_subir_archivo = isset($_POST["id_convenio_subir_archivo"]) ? limpiarCadena($_POST["id_convenio_subir_archivo"]) : "";
$archivo_documento = isset($_POST["archivo_documento"]) ? limpiarCadena($_POST["archivo_documento"]) : "";
$comentarios = isset($_POST["comentarios"]) ? limpiarCadena($_POST["comentarios"]) : "";
$id_convenio_documento_comentarios = isset($_POST["id_convenio_documento_comentarios"]) ? limpiarCadena($_POST["id_convenio_documento_comentarios"]) : "";
$id_convenio_documento_subir_editar = isset($_POST["id_convenio_documento_subir_editar"]) ? limpiarCadena($_POST["id_convenio_documento_subir_editar"]) : "";
$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('H:i:s');
$fechaarchivo = date('d-h-i-s');
$id_usuario = $_SESSION['id_usuario'];

switch ($_GET["op"]) {

	case 'guardaryeditarcarpeta':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		if (empty($id_convenio_carpeta)) {
			$rspta = $conveniosdocumentacion->insertarCarpetaConvenio($id_usuario, $carpeta, $fecha_respuesta, $hora_respuesta);
			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
		} else {
			$rspta = $conveniosdocumentacion->editarCarpeta($id_convenio_carpeta, $carpeta);
			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		$data["1"] = $id_usuario;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'listar_carpetas_usuario':
		$rspta = $conveniosdocumentacion->verCarpetas($id_usuario);
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$carpeta = $reg[$i]["carpeta"];
			$id_convenio_carpeta = $reg[$i]["id_convenio_carpeta"];
			$id_convenio_documento = $reg[$i]["id_convenio_documento"];
			$fecha = $reg[$i]["fecha"];
			$hora = $reg[$i]["hora"];
			$hora_formato = date('h:i:s A', strtotime($hora));
			$data[] = array(
				"0" => '
				<div class="text-center btn-group">
					
					<a onclick="vercheclistcreados(' . $id_convenio_carpeta . ')" class="btn btn-primary btn-sm" title="Ver Items">
						<i class="fas fa-eye"></i>
					</a>

					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="editar_carpeta(' . $id_convenio_carpeta . ')" title="Editar Carpeta" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_carpeta(' . $id_convenio_carpeta . ')" title="Eliminar Carpeta" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
				</div>',
				"1" => $carpeta,
				"2" => $conveniosdocumentacion->fechaesp($fecha),
				"3" => $hora_formato,
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
	case 'vercheclistcreados':
		$id_convenio_carpeta = $_POST["id_convenio_carpeta"];
		$rspta = $conveniosdocumentacion->verDocumentoschecklist($id_convenio_carpeta);
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$carpeta = $reg[$i]["carpeta"];
			$id_convenio_carpeta = $reg[$i]["id_convenio_carpeta"];
			$nombre_convenio = $reg[$i]["nombre_convenio"];
			$fecha_creacion = $reg[$i]["fecha_creacion"];
			$id_convenio_documento = $reg[$i]["id_convenio_documento"];
			$hora = $reg[$i]["hora_creacion"];
			$hora_formato = date('h:i:s A', strtotime($hora));
			$estado_terminado = $conveniosdocumentacion->ConsultarEstadoFinalizado($id_convenio_documento);
			$estado = $estado_terminado
				? '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Item terminado</span>'
				: '<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_item(' . $id_convenio_documento . ')" title="Marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>';
				$desactivar_botones = !$estado_terminado
				? '<button class="tooltip-agregar btn btn-primary btn-xs" onclick="editar_items(' . $id_convenio_documento . ')" title="Editar Item" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
				<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_items(' . $id_convenio_documento . ')" title="Eliminar Item" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>'
				: '';
			$data[] = array(
				"0" => '
                <div class="text-center btn-group">
                    <a onclick="verarchivoscheckList(' . $id_convenio_documento . ')" class="btn btn-primary btn-sm" title="Ver Documento">
                        <i class="fas fa-file-alt"></i>
                    </a>
                    <a onclick="verarcomentarios(' . $id_convenio_documento . ')" class="btn btn-primary btn-sm" title="Ver Comentarios">
                        <i class="fas fa-comments"></i>
                    </a>
                    ' . $desactivar_botones . '
                </div>',
				"1" => $nombre_convenio,
				"2" => $estado,
				"3" => $conveniosdocumentacion->fechaesp($fecha_creacion),
				"4" => $hora_formato,
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
	case 'guardaryeditarchecklist':
		$fecha_respuesta_creacion = date('Y-m-d');
		$hora_respuesta_creacion = date('H:i:s');
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		if (empty($id_convenio_documento_subir_editar)) {
			$rspta = $conveniosdocumentacion->insertarDocumento($id_convenio_documento_subir, $nombre_convenio, $fecha_respuesta_creacion, $hora_respuesta_creacion, $id_usuario);
			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
		} else {
			$rspta = $conveniosdocumentacion->editarDocumento($id_convenio_documento_subir_editar, $nombre_convenio);
			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		echo json_encode(array($data));
		break;
	case 'subirarchivoform':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$target_path = '../files/convenio_documentos/';
		$archivo_documento = $_FILES['archivo_documento']['name'];
		$extension = strtolower(pathinfo($archivo_documento, PATHINFO_EXTENSION));
		$img1path = $target_path . $archivo_documento;
		if (move_uploaded_file($_FILES['archivo_documento']['tmp_name'], $img1path)) {
			$archivo_documento_final = $_FILES['archivo_documento']['name'];
			$rspta = $conveniosdocumentacion->InsertarArchivoConvenio($id_convenio_subir_archivo,  $archivo_documento_final, $fecha_respuesta, $hora_respuesta, $comentarios, $id_usuario);
			$resultado = $rspta ? "1" : "2";
			$data["0"] = $resultado;
		} else {
			$data["0"] = "3";
		}
		echo json_encode(array($data));
		break;
	case 'verarchivoscheckList':
		$id_convenio_documento = $_POST["id_convenio_documento"];
		$rspta = $conveniosdocumentacion->verArchivosCheckList($id_convenio_documento);
		$data = array();
		$reg = $rspta;
		$ruta_base = "/campus-virtual/files/convenio_documentos/";
		for ($i = 0; $i < count($reg); $i++) {
			$nombre_archivo = $reg[$i]["nombre_archivo"];
			$fecha = $reg[$i]["fecha"];
			$enlace_archivo = "<a href='" . $ruta_base . $nombre_archivo . "' target='_blank'>" . $nombre_archivo . "</a>";
			$data[] = array(
				"0" => $enlace_archivo,
				"1" => $conveniosdocumentacion->fechaesp($fecha),
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
	case 'verarcomentarios':
		$id_convenio_documento = $_POST["id_convenio_documento"];
		$rspta = $conveniosdocumentacion->vercomentarios($id_convenio_documento);
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$comentario = $reg[$i]["comentario"];
			$fecha = $reg[$i]["fecha_creacion"];
			$estado = $reg[$i]["estado"];
			$hora_creacion = $reg[$i]["hora_creacion"];
			$hora_formato = date('h:i:s A', strtotime($hora_creacion));
			$data[] = array(
				"0" => $comentario,
				"1" => $conveniosdocumentacion->fechaesp($fecha),
				"2" => $hora_formato,
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
	case 'crearcomentarios':
		$data = array();
		$data["0"] = "";
		$rspta = $conveniosdocumentacion->InsertarComentarios($id_convenio_documento_comentarios, $comentarios, $fecha_respuesta, $hora_respuesta, $id_usuario);
		$resultado = $rspta ? "1" : "2";
		$data["0"] = $resultado;

		echo json_encode(array($data));
		break;
	case 'terminar_item':
		$fecha_finalizacion = date('Y-m-d');
		$id_convenio_documento = $_POST["id_convenio_documento"];
		$rspta = $conveniosdocumentacion->InsertarEstadoFinalizoConvenio($id_convenio_documento, $id_usuario, $fecha_finalizacion);
		echo json_encode($rspta);
		break;
	case 'editar_carpeta':
		$id_convenio_carpeta = $_POST["id_convenio_carpeta"];
		$rspta = $conveniosdocumentacion->editar_carpeta($id_convenio_carpeta);
		echo json_encode($rspta);
		break;
	case 'eliminar_carpeta':
		$id_convenio_carpeta = $_POST["id_convenio_carpeta"];
		$rspta = $conveniosdocumentacion->eliminar_carpeta($id_convenio_carpeta);
		echo json_encode($rspta);
		break;
	case 'editar_items':
		$id_convenio_documento = $_POST["id_convenio_documento"];
		$rspta = $conveniosdocumentacion->editar_item($id_convenio_documento);
		echo json_encode($rspta);
		break;

	case 'eliminar_items':
		$id_convenio_documento = $_POST["id_convenio_documento"];
		$rspta = $conveniosdocumentacion->eliminar_items($id_convenio_documento);
		echo json_encode($rspta);
		break;
}
