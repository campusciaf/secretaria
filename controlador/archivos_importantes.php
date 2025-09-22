<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/ArchivosImportantes.php";
$archivosimportantes = new ArchivosImportantes();
$agregar_documento_archivo = isset($_POST["agregar_documento_archivo"]) ? limpiarCadena($_POST["agregar_documento_archivo"]) : "";
$id_dependencia_subir_documento = isset($_POST["id_dependencia_subir_documento"]) ? limpiarCadena($_POST["id_dependencia_subir_documento"]) : "";
// para saber si es para editar o crear el documento.
$id_dependencia_editar_subir_documento = isset($_POST["id_dependencia_editar_subir_documento"]) ? limpiarCadena($_POST["id_dependencia_editar_subir_documento"]) : "";
$id_dependencia_subir_archivo_importante = isset($_POST["id_dependencia_subir_archivo_importante"]) ? limpiarCadena($_POST["id_dependencia_subir_archivo_importante"]) : "";
$id_archivos_importantes_documentos = isset($_POST["id_archivos_importantes_documentos"]) ? limpiarCadena($_POST["id_archivos_importantes_documentos"]) : "";
$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('H:i:s');
$fechaarchivo = date('d-h-i-s');
$id_usuario = $_SESSION['id_usuario'];
//post para insertar el formulario de crear archivo importante
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$entidad = isset($_POST["entidad"]) ? limpiarCadena($_POST["entidad"]) : "";
$fecha_vencimiento = isset($_POST["fecha_vencimiento"]) ? limpiarCadena($_POST["fecha_vencimiento"]) : "";
$detalles = isset($_POST["detalles"]) ? limpiarCadena($_POST["detalles"]) : "";
switch ($_GET["op"]) {
		// lista la tabla de los registros
	case 'listar_registros':
		$id_usuario = $_SESSION['id_usuario'];
		$obtener_dependencia = $archivosimportantes->obtenerDependenciaUsuario($id_usuario);
		$dependencia = $obtener_dependencia['dependencia'];
		$id_dependencias = $obtener_dependencia['id_dependencias'];
		$data = array();
		$usuario_por_dependencia = $archivosimportantes->listarArchivosPorDependencia($dependencia);
		if ($usuario_por_dependencia) {
			$ruta = "../files/archivos_importantes/";
			for ($i = 0; $i < count($usuario_por_dependencia); $i++) {
				$dependencia_usuarios = $usuario_por_dependencia[$i]['dependencia'];
				$entidad = $usuario_por_dependencia[$i]['entidad'];
				$telefono = $usuario_por_dependencia[$i]['telefono'];
				$hora_convertida = $usuario_por_dependencia[$i]['hora'];
				$fecha = $archivosimportantes->fechaesp($usuario_por_dependencia[$i]['fecha']);
				$hora_convertida = $usuario_por_dependencia[$i]['hora'];
				$hora_formato = date('h:i:s A', strtotime($hora_convertida));
				$data[] = array(
					"0" => '
					<div class="btn-group">
						<button class="tooltip-agregar btn btn-primary" onclick="mostrar_archivo_importante(' . $usuario_por_dependencia[$i]["id_archivos_importante"] . ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
						<button class="tooltip-agregar btn btn-danger" onclick="eliminar_documento(' . $usuario_por_dependencia[$i]["id_archivos_importante"] . ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
						<button onclick="mostrardocumentosimportantes(' . $usuario_por_dependencia[$i]["id_archivos_importante"] . ')" class="btn btn-primary btn-sm" title="Ver Documentos">
						<i class="fas fa-eye"></i>
						</button>
					</div>',
					"1" => $entidad,
					"2" => $telefono,
					"3" => $fecha,
					"4" => $hora_formato
				);
			}
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data,
			"id_dependencias" => $id_dependencias,
			"dependencia_usuarios" => $dependencia,
		);
		echo json_encode($results);
		break;
	case 'formulariosubirarchivoimportante':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$id_dependencia_archivo_importante = isset($_POST["id_dependencia_archivo_importante"]) ? limpiarCadena($_POST["id_dependencia_archivo_importante"]) : "";
		$id_dependencia_subir_documento = isset($_POST['id_dependencia_subir_documento']) ? $_POST['id_dependencia_subir_documento'] : "";
		$fecha_respuesta = date("Y-m-d");
		$hora_respuesta = date("H:i:s");
		$id_usuario = $_SESSION['id_usuario'];
		if (empty($id_dependencia_archivo_importante)) {
			$rspta = $archivosimportantes->InsertarArchivoImportante($id_dependencia_subir_documento, $entidad, $telefono, $fecha_respuesta, $hora_respuesta, $id_usuario, $fecha_vencimiento, $detalles);
			$resultado = $rspta ? "1" : "2";
			$data["0"] = $resultado;
		} else {
			$modificar_sw = $archivosimportantes->editarArchivoImportante($id_dependencia_archivo_importante, $entidad, $telefono,  $fecha_vencimiento, $detalles);
			$data["0"] = $modificar_sw ? "1" : "2";
		}
		echo json_encode(array($data));
		break;
	case 'mostrardocumentosimportantes':
		$id_archivos_importante = $_POST['id_archivos_importante'];
		$documentos_importantes = $archivosimportantes->ListarDocumentosImportantes($id_archivos_importante);
		$data = array();
		if ($documentos_importantes) {
			$ruta = "../files/archivos_importantes/";
			for ($i = 0; $i < count($documentos_importantes); $i++) {
				$archivo_importante_nombre = $documentos_importantes[$i]['archivo_importante_nombre'];
				$enlace_archivo = "<a href='" . $ruta . $archivo_importante_nombre . "' target='_blank'>" . $archivo_importante_nombre . "</a>";
				$hora_convertida = $documentos_importantes[$i]['hora'];
				$hora_formato = date('h:i:s A', strtotime($hora_convertida));
				$data[] = array(
					"0" => '
					<div class="btn-group">
						<button class="tooltip-agregar btn btn-primary" onclick="mostrar_documento_importante(' . $documentos_importantes[$i]["id_archivos_importantes_documentos"] . ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
						<button class="tooltip-agregar btn btn-danger" onclick="eliminar_documento_importante(' . $documentos_importantes[$i]["id_archivos_importantes_documentos"] . ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
					</div>',
					"1" => $enlace_archivo,
					"2" => $archivosimportantes->fechaesp($documentos_importantes[$i]['fecha']),
					"3" => $hora_formato,
				);
			}
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data,
			"id_dependencias" => isset($id_dependencias) ? $id_dependencias : null,
			"dependencia_usuarios" => isset($dependencia_usuarios) ? $dependencia_usuarios : null,
		);
		echo json_encode($results);
		break;
	case 'subirdocumentosimportantes':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$target_path = '../files/archivos_importantes/';
		$agregar_documento_archivo = $_FILES['agregar_documento_archivo']['name'];
		$extension = strtolower(pathinfo($agregar_documento_archivo, PATHINFO_EXTENSION));
		$img1path = $target_path . $agregar_documento_archivo;
		$fecha_respuesta = date("Y-m-d");
		$hora_respuesta = date("H:i:s");
		$id_usuario = $_SESSION['id_usuario'];
		if (empty($id_archivos_importantes_documentos)) {
			if ($agregar_documento_archivo && move_uploaded_file($_FILES['agregar_documento_archivo']['tmp_name'], $img1path)) {
				$archivo_documento_final = $agregar_documento_archivo;
				$rspta = $archivosimportantes->InsertarDocumentoImportante($id_dependencia_subir_archivo_importante, $archivo_documento_final, $fecha_respuesta, $hora_respuesta, $id_usuario);
				$data["0"] = $rspta ? "1" : "2";
			} else {
				$data["0"] = "3";
			}
		} else {
			$documento_anterior = $archivosimportantes->MostrarDocumento($id_archivos_importantes_documentos);
			$ruta_img_anterior = isset($documento_anterior['archivo_importante_nombre']) ? $documento_anterior['archivo_importante_nombre'] : null;
			if ($ruta_img_anterior && file_exists($target_path . $ruta_img_anterior)) {
				unlink($target_path . $ruta_img_anterior);
			}
			if ($agregar_documento_archivo && move_uploaded_file($_FILES['agregar_documento_archivo']['tmp_name'], $img1path)) {
				$ruta_img = $agregar_documento_archivo;
				$modificar_sw = $archivosimportantes->EditarDocumentoImportante($id_archivos_importantes_documentos, $ruta_img);
				$data["0"] = $modificar_sw ? "1" : "2";
			} else {
				$data["0"] = "3";
			}
		}
		echo json_encode(array($data));
		break;
	case 'mostrar_documento':
		$id_archivos_importante = $_POST['id_archivos_importante'];
		$rspta = $archivosimportantes->MostrarDocumento($id_archivos_importante);
		echo json_encode($rspta);
		break;
	case 'mostrar_documento_importante':
		$id_archivos_importante = $_POST['id_archivos_importante'];
		$rspta = $archivosimportantes->MostrarDocumentoImportante($id_archivos_importante);
		echo json_encode($rspta);
		break;
	case 'eliminar_documento':
		$id_archivos_importante = $_POST["id_archivos_importante"];
		$rspta = $archivosimportantes->EliminarDocumento($id_archivos_importante);
		echo json_encode($rspta);
		break;
	case 'eliminar_documento_importantes':
		$id_archivos_importantes_documentos = $_POST["id_archivos_importantes_documentos"];
		$documento = $archivosimportantes->ObtenerRutaImagen($id_archivos_importantes_documentos);
		if ($documento && isset($documento['archivo_importante_nombre'])) {
			$target_path = '../files/archivos_importantes/';
			$file_path = $target_path . $documento['archivo_importante_nombre'];
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
		$rspta = $archivosimportantes->EliminarArchivosImportantes($id_archivos_importantes_documentos);
		echo json_encode($rspta);
		break;
}