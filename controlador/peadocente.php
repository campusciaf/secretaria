<?php
require_once "../modelos/PeaDocente.php";
require_once "../public/mail/sendmailClave.php"; // incluye el codigo para enviar link de clave
require_once "../mail/templatenotiejerciciodocente.php"; // incluye el codigo para enviar link de clave
require_once "../mail/templateneliminataller.php"; // incluye el codigo para enviar link de clave


$peadocente = new PeaDocente();
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('h:i:s');


$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('h:i:s');
$fechaarchivo = date('d-h-i-s');
$condicion = 0;


$id_pea_actividades = isset($_POST["id_pea_actividades"]) ? limpiarCadena($_POST["id_pea_actividades"]) : "";
$id_tema = isset($_POST["id_tema"]) ? limpiarCadena($_POST["id_tema"]) : "";
$id_docente_grupo = isset($_POST["id_docente_grupo"]) ? limpiarCadena($_POST["id_docente_grupo"]) : "";
$nombre_actividad = isset($_POST["nombre_actividad"]) ? limpiarCadena($_POST["nombre_actividad"]) : "";
$descripcion_actividad = isset($_POST["descripcion_actividad"]) ? limpiarCadena($_POST["descripcion_actividad"]) : "";
$tipo_archivo_id = isset($_POST["tipo_archivo_id"]) ? limpiarCadena($_POST["tipo_archivo_id"]) : "";
$archivo_actividad = isset($_POST["archivo"]) ? limpiarCadena($_POST["archivo"]) : "";

$id_usuario = $_SESSION['id_usuario'];


/* carpeta documentos */
$id_pea_documento_carpeta = isset($_POST["id_pea_documento_carpeta"]) ? limpiarCadena($_POST["id_pea_documento_carpeta"]) : ""; // id de la carpeta documento
$id_tema_documento = isset($_POST["id_tema_documento"]) ? limpiarCadena($_POST["id_tema_documento"]) : ""; // id del tema
$id_pea_docentes = isset($_POST["id_pea_docentes"]) ? limpiarCadena($_POST["id_pea_docentes"]) : "";
$carpeta = isset($_POST["carpeta"]) ? limpiarCadena($_POST["carpeta"]) : "";
/* ********************** */

/* subir documentos */
$id_pea_documento = isset($_POST["id_pea_documento"]) ? limpiarCadena($_POST["id_pea_documento"]) : ""; // id de la carpeta documento
$id_pea_documento_carpeta_subir = isset($_POST["id_pea_documento_carpeta_subir"]) ? limpiarCadena($_POST["id_pea_documento_carpeta_subir"]) : "";
$id_pea_docentes_subir = isset($_POST["id_pea_docentes_subir"]) ? limpiarCadena($_POST["id_pea_docentes_subir"]) : "";
$tipo_archivo = isset($_POST["tipo"]) ? limpiarCadena($_POST["tipo"]) : "";
$nombre_documento = isset($_POST["nombre_documento"]) ? limpiarCadena($_POST["nombre_documento"]) : "";
$descripcion_documento = isset($_POST["descripcion_documento"]) ? limpiarCadena($_POST["descripcion_documento"]) : "";
$archivo_documento = isset($_FILES['archivo_documento']['name']) ? limpiarCadena($_FILES['archivo_documento']['name']) : "";


$condicion_finalizacion_documento   = isset($_POST["condicion_finalizacion_documento"]) ? limpiarCadena($_POST["condicion_finalizacion_documento"]) : "";
$tipo_condicion_documento   		= isset($_POST["tipo_condicion_documento"]) ? limpiarCadena($_POST["tipo_condicion_documento"]) : 0;
$fecha_inicio_documento    			= isset($_POST["fecha_inicio_documento"]) ? limpiarCadena($_POST["fecha_inicio_documento"]) : "";
$fecha_limite_documento     		= isset($_POST["fecha_limite_documento"]) ? limpiarCadena($_POST["fecha_limite_documento"]) : "";
$porcentaje_documento       		= isset($_POST["porcentaje_documento"]) ? limpiarCadena($_POST["porcentaje_documento"]) : "";
$otorgar_puntos_documento   		= isset($_POST["otorgar_puntos_documento"]) ? limpiarCadena($_POST["otorgar_puntos_documento"]) : "";
$puntos_actividad_documento 		= isset($_POST["puntos_actividad_documento"]) ? limpiarCadena($_POST["puntos_actividad_documento"]) : 0;
/* ********************** */

/* subir documentos link*/
$id_pea_documentolink = isset($_POST["id_pea_documentolink"]) ? limpiarCadena($_POST["id_pea_documentolink"]) : ""; // id de la carpeta documento
$id_tema_subirlink = isset($_POST["id_tema_subirlink"]) ? limpiarCadena($_POST["id_tema_subirlink"]) : "";
$id_pea_documento_carpeta_subirlink = isset($_POST["id_pea_documento_carpeta_subirlink"]) ? limpiarCadena($_POST["id_pea_documento_carpeta_subirlink"]) : "";
$id_pea_docentes_subirlink = isset($_POST["id_pea_docentes_subirlink"]) ? limpiarCadena($_POST["id_pea_docentes_subirlink"]) : "";
$tipo_archivolink = isset($_POST["tipolink"]) ? limpiarCadena($_POST["tipolink"]) : "";
$nombre_documentolink = isset($_POST["nombre_documentolink"]) ? limpiarCadena($_POST["nombre_documentolink"]) : "";
$descripcion_documentolink = isset($_POST["descripcion_documentolink"]) ? limpiarCadena($_POST["descripcion_documentolink"]) : "";
$archivo_documentolink = isset($_POST["archivo_documentolink"]) ? limpiarCadena($_POST["archivo_documentolink"]) : "";
/* ********************** */

/* carpeta ejercicios */

$id_pea_ejercicios_carpeta = isset($_POST["id_pea_ejercicios_carpeta"]) ? limpiarCadena($_POST["id_pea_ejercicios_carpeta"]) : "";
$id_pea_docentes_ejercicios_carpeta = isset($_POST["id_pea_docentes_ejercicios_carpeta"]) ? limpiarCadena($_POST["id_pea_docentes_ejercicios_carpeta"]) : ""; // id de la carpeta documento
$carpeta_ejercicios = isset($_POST["carpeta_ejercicios"]) ? limpiarCadena($_POST["carpeta_ejercicios"]) : "";
/* ********************** */

/* subir ejercicios */
$id_pea_ejercicios = isset($_POST["id_pea_ejercicios"]) ? limpiarCadena($_POST["id_pea_ejercicios"]) : "";
$id_pea_ejercicios_carpeta_subir = isset($_POST["id_pea_ejercicios_carpeta_subir"]) ? limpiarCadena($_POST["id_pea_ejercicios_carpeta_subir"]) : ""; // id de la carpeta documento
$id_pea_docente_subir_ejercicios = isset($_POST["id_pea_docente_subir_ejercicios"]) ? limpiarCadena($_POST["id_pea_docente_subir_ejercicios"]) : "";
$tipo_archivo_ejercicios = isset($_POST["tipo_archivo_ejercicios"]) ? limpiarCadena($_POST["tipo_archivo_ejercicios"]) : "";
$nombre_ejercicios = isset($_POST["nombre_ejercicios"]) ? limpiarCadena($_POST["nombre_ejercicios"]) : "";
$descripcion_ejercicios = isset($_POST["descripcion_ejercicios"]) ? limpiarCadena($_POST["descripcion_ejercicios"]) : "";
$archivo_ejercicios = isset($_FILES['archivo_ejercicios']['name']) ? limpiarCadena($_FILES['archivo_ejercicios']['name']) : "";
$imagenactual_ejercicios = isset($_POST["imagenactual_ejercicios"]) ? limpiarCadena($_POST["imagenactual_ejercicios"]) : "";
$fecha_inicio = isset($_POST["fecha_inicio"]) ? limpiarCadena($_POST["fecha_inicio"]) : "";
$fecha_entrega = isset($_POST["fecha_entrega"]) ? limpiarCadena($_POST["fecha_entrega"]) : "";
$por_ejercicios = isset($_POST["por_ejercicios"]) ? limpiarCadena($_POST["por_ejercicios"]) : "";
/* ********************** */

/* ***************** enlaces ***************/

$id_pea_enlaces = isset($_POST["id_pea_enlaces"]) ? limpiarCadena($_POST["id_pea_enlaces"]) : ""; // id de la carpeta documento
$id_pea_docentes_enlace = isset($_POST["id_pea_docentes_enlace"]) ? limpiarCadena($_POST["id_pea_docentes_enlace"]) : ""; // id de la carpeta documento
$id_tema_enlace = isset($_POST["id_tema_enlace"]) ? limpiarCadena($_POST["id_tema_enlace"]) : ""; // id de la carpeta documento
$titulo_enlace = isset($_POST["titulo_enlace"]) ? limpiarCadena($_POST["titulo_enlace"]) : ""; // id de la carpeta documento
$descripcion_enlace = isset($_POST["descripcion_enlace"]) ? limpiarCadena($_POST["descripcion_enlace"]) : ""; // id de la carpeta documento
$ciclo_enlace = isset($_POST["ciclo_enlace"]) ? limpiarCadena($_POST["ciclo_enlace"]) : ""; // id de la carpeta documento
$enlace = isset($_POST["enlace"]) ? limpiarCadena($_POST["enlace"]) : ""; // id de la carpeta documento

$condicion_finalizacion_enlace   	= isset($_POST["condicion_finalizacion_enlace"]) ? limpiarCadena($_POST["condicion_finalizacion_enlace"]) : "";
$tipo_condicion_enlace   			= isset($_POST["tipo_condicion_enlace"]) ? limpiarCadena($_POST["tipo_condicion_enlace"]) : 0;
$fecha_inicio_enlace    			= isset($_POST["fecha_inicio_enlace"]) ? limpiarCadena($_POST["fecha_inicio_enlace"]) : "";
$fecha_limite_enlace     			= isset($_POST["fecha_limite_enlace"]) ? limpiarCadena($_POST["fecha_limite_enlace"]) : "";
$porcentaje_enlace       			= isset($_POST["porcentaje_enlace"]) ? limpiarCadena($_POST["porcentaje_enlace"]) : "";
$otorgar_puntos_enlace   			= isset($_POST["otorgar_puntos_enlace"]) ? limpiarCadena($_POST["otorgar_puntos_enlace"]) : 0;
$puntos_actividad_enlace 			= isset($_POST["puntos_actividad_enlace"]) ? limpiarCadena($_POST["puntos_actividad_enlace"]) : 0;
/* ****************          ***************/


/* ***************** glosario ***************/
$id_pea_glosario = isset($_POST["id_pea_glosario"]) ? limpiarCadena($_POST["id_pea_glosario"]) : ""; // id de la carpeta documento
$id_tema_glosario = isset($_POST["id_tema_glosario"]) ? limpiarCadena($_POST["id_tema_glosario"]) : ""; // id del tema
$id_pea_docentes_glosario = isset($_POST["id_pea_docentes_glosario"]) ? limpiarCadena($_POST["id_pea_docentes_glosario"]) : ""; // id de la carpeta documento
$titulo_glosario = isset($_POST["titulo_glosario"]) ? limpiarCadena($_POST["titulo_glosario"]) : ""; // id de la carpeta documento
$definicion_glosario = isset($_POST["definicion_glosario"]) ? limpiarCadena($_POST["definicion_glosario"]) : ""; // id de la carpeta documento
$otorgar_puntos_glosario  		= isset($_POST["otorgar_puntos_glosario"]) ? limpiarCadena($_POST["otorgar_puntos_glosario"]) : 0;
$puntos_actividad_glosario		= isset($_POST["puntos_actividad_glosario"]) ? limpiarCadena($_POST["puntos_actividad_glosario"]) : 0;
$ciclo_glosario					= isset($_POST["ciclo_glosario"]) ? limpiarCadena($_POST["ciclo_glosario"]) : "";
/* ****************          ***************/

/* subir video */
$id_pea_video = isset($_POST["id_pea_video"]) ? limpiarCadena($_POST["id_pea_video"]) : ""; // id de la carpeta video
$id_pea_docentes_video = isset($_POST["id_pea_docentes_video"]) ? limpiarCadena($_POST["id_pea_docentes_video"]) : "";
$id_tema_video = isset($_POST["id_tema_video"]) ? limpiarCadena($_POST["id_tema_video"]) : ""; // id del tema
$tipo_video = isset($_POST["tipo_video"]) ? limpiarCadena($_POST["tipo_video"]) : "";
$titulo_video = isset($_POST["titulo_video"]) ? limpiarCadena($_POST["titulo_video"]) : "";
$descripcion_video = isset($_POST["descripcion_video"]) ? limpiarCadena($_POST["descripcion_video"]) : "";
$url_video = isset($_POST["url_video"]) ? limpiarCadena($_POST["url_video"]) : "";
$condicion_finalizacion_video   = isset($_POST["condicion_finalizacion_video"]) ? limpiarCadena($_POST["condicion_finalizacion_video"]) : "";
$tipo_condicion_video   		= isset($_POST["tipo_condicion_video"]) ? limpiarCadena($_POST["tipo_condicion_video"]) : 0;
$fecha_inicio_video    			= isset($_POST["fecha_inicio_video"]) ? limpiarCadena($_POST["fecha_inicio_video"]) : "";
$fecha_limite_video     		= isset($_POST["fecha_limite_video"]) ? limpiarCadena($_POST["fecha_limite_video"]) : "";
$ciclo_video					= isset($_POST["ciclo_video"]) ? limpiarCadena($_POST["ciclo_video"]) : "";
$porcentaje_video       		= isset($_POST["porcentaje_video"]) ? limpiarCadena($_POST["porcentaje_video"]) : "";
$otorgar_puntos_video   		= isset($_POST["otorgar_puntos_video"]) ? limpiarCadena($_POST["otorgar_puntos_video"]) : 0;
$puntos_actividad_video 		= isset($_POST["puntos_actividad_video"]) ? limpiarCadena($_POST["puntos_actividad_video"]) : 0;
/* ********************** */

switch ($_GET["op"]) {

	case 'guardaryeditar':
		if ($tipo_archivo_id == 1 or $tipo_archivo_id == 2) {
			if (!file_exists($_FILES['archivo']['tmp_name']) || !is_uploaded_file($_FILES['archivo']['tmp_name'])) {
				$archivo_actividad = $_POST["archivoactual"];
			} else {
				$ext = explode(".", $_FILES["archivo"]["name"]);
				if ($_FILES['archivo']['type'] == "image/jpg" || $_FILES['archivo']['type'] == "image/jpeg" || $_FILES['archivo']['type'] == "image/png" || $_FILES['archivo']['type'] == "application/pdf") {
					$condicion = 1;
					$archivo_actividad = round(microtime(true)) . '.' . end($ext);
					move_uploaded_file($_FILES["archivo"]["tmp_name"], "../files/pea/" . $archivo_actividad);
				}
			}
		}

		if (empty($id_pea_actividades)) {
			$rspta = $peadocente->insertar($id_tema, $id_docente_grupo, $nombre_actividad, $descripcion_actividad, $tipo_archivo_id, $archivo_actividad, $fecha_respuesta, $hora_respuesta, $id_usuario);
			echo $rspta ? "Actividad registrada " : "Registro fallido";
		} else {
			$rspta = $peadocente->editar($id_pea_actividades, $nombre_actividad, $descripcion_actividad, $archivo_actividad, $fecha_respuesta, $hora_respuesta);

			echo $rspta ? "Actividad actualizada" : "Actividad no se pudo actualizar";
		}
	break;

	case 'guardaryeditarglosario':

		$data = array();
		$data["0"] = "";
		$data["1"] = "";


		if (empty($id_pea_glosario)) { //si el id esta vacio es que se insertara una nuevo glosario

			$rspta = $peadocente->insertarGlosario($id_pea_docentes_glosario,$id_tema_glosario, $titulo_glosario, $definicion_glosario, $fecha_respuesta, $hora_respuesta,$otorgar_puntos_glosario,$puntos_actividad_glosario,$ciclo_glosario); // inserta glosario

			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
		} else { // si el id tiene algo quiere decir que es una edición

			$rspta = $peadocente->actualizarGlosario($id_pea_glosario, $titulo_glosario, $definicion_glosario,$otorgar_puntos_glosario,$puntos_actividad_glosario); // inserta el tema

			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		$data["1"] = $id_pea_docentes_glosario;
		$results = array($data);
		echo json_encode($results);
	break;

	case 'guardaryeditarcarpeta':

		$data = array();
		$data["0"] = "";
		$data["1"] = "";


		if (empty($id_pea_documento_carpeta)) { //si el id esta vacio es que se insertara una nueva carpeta


			$rspta = $peadocente->insertarCarpeta($id_pea_docentes, $carpeta, $fecha_respuesta, $hora_respuesta); // inserta el tema

			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
		} else { // si el id tiene algo
			$rspta = $peadocente->editarCarpeta($id_pea_documento_carpeta, $carpeta);
			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		$data["1"] = $id_pea_docentes;
		$results = array($data);
		echo json_encode($results);
	break;

	case 'guardaryeditardocumento':

		$data = array();
		$data["0"] = "";
		$data["1"] = "";


		if (empty($id_pea_documento)) { //si el id esta vacio es que se insertara una nueva carpeta


			$traerid_pea_docentes = $peadocente->traeridpeadocente($id_pea_docentes_subir);
			$traeredatosdocentegrupos = $peadocente->comprobar($traerid_pea_docentes["id_docente_grupo"]);
			$ciclo = $traeredatosdocentegrupos["ciclo"];
			if ($tipo_archivo == 1) { // imagen
				$allowedExts = array("PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
				$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
				$extension = explode(".", $archivo_documento);
				$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
			}
			if ($tipo_archivo == 2) { // word
				$allowedExts = array("docx", "doc");
				$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
				$extension = explode(".", $archivo_documento);
				$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
			}
			if ($tipo_archivo == 3) { // excel
				$allowedExts = array("xlsx", "xls");
				$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
				$extension = explode(".", $archivo_documento);
				$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
			}
			if ($tipo_archivo == 4) { // excel
				$allowedExts = array("pptx", "ppt");
				$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
				$extension = explode(".", $archivo_documento);
				$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
			}
			if ($tipo_archivo == 5) { // PDF
				$allowedExts = array("pdf", "PDF");
				$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
				$extension = explode(".", $archivo_documento);
				$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
			}
			if ($tipo_archivo == 6) { // comprimido
				$allowedExts = array("rar");
				$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
				$extension = explode(".", $archivo_documento);
				$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
			}

			//$allowedExts = array("pdf","PDF", "PNG", "png","jpg","JPG","jpeg","JPEG"); 


			if (in_array($extension[1], $allowedExts)) {

				if (move_uploaded_file($_FILES['archivo_documento']['tmp_name'], $img1path)) {
					$archivo_documento_final = '' . $fechaarchivo . '-' . $_FILES['archivo_documento']['name'];

					$rspta = $peadocente->insertarDocumento($id_pea_docentes_subir, $id_tema_documento, $nombre_documento, $descripcion_documento, $tipo_archivo, $archivo_documento_final, $fecha_respuesta, $hora_respuesta, $ciclo, $condicion_finalizacion_documento, $tipo_condicion_documento, $fecha_inicio_documento, $fecha_limite_documento,$porcentaje_documento,$otorgar_puntos_documento,$puntos_actividad_documento); // inserta el tema

					$resultado = $rspta ? "1" : "2";
					$data["0"] .= $resultado;
				}
			} else {
				$data["0"] .= "5"; // error de formato

			}
		} else { // si el id tiene algo quiere decir que es una edición

			if (!file_exists($_FILES['archivo_documento']['tmp_name']) || !is_uploaded_file($_FILES['archivo_documento']['tmp_name'])) { // si el archivo es el mismo
				$archivo_documento_final = $_POST["imagenactual"];

				$rspta = $peadocente->actualizarArchivo($id_pea_documento, $nombre_documento, $descripcion_documento, $archivo_documento_final,$condicion_finalizacion_documento, $tipo_condicion_documento, $fecha_inicio_documento, $fecha_limite_documento,$porcentaje_documento,$otorgar_puntos_documento,$puntos_actividad_documento); // inserta el tema

				$resultado = $rspta ? "3" : "4";
				$data["0"] .= $resultado;
			} else { // si cambia el archivo
				$traerid_pea_docentes = $peadocente->traeridpeadocente($id_pea_docentes_subir);
				$traeredatosdocentegrupos = $peadocente->comprobar($traerid_pea_docentes["id_docente_grupo"]);
				$ciclo = $traeredatosdocentegrupos["ciclo"];

				if ($tipo_archivo == 1) { // imagen
					$allowedExts = array("PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
					$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
					$extension = explode(".", $archivo_documento);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
				}
				if ($tipo_archivo == 2) { // word
					$allowedExts = array("docx", "doc");
					$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
					$extension = explode(".", $archivo_documento);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
				}
				if ($tipo_archivo == 3) { // excel
					$allowedExts = array("xlsx", "xls");
					$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
					$extension = explode(".", $archivo_documento);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
				}
				if ($tipo_archivo == 4) { // excel
					$allowedExts = array("pptx", "ppt");
					$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
					$extension = explode(".", $archivo_documento);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
				}
				if ($tipo_archivo == 5) { // PDF
					$allowedExts = array("pdf", "PDF");
					$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
					$extension = explode(".", $archivo_documento);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
				}
				if ($tipo_archivo == 6) { // comprimido
					$allowedExts = array("rar");
					$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/';
					$extension = explode(".", $archivo_documento);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_documento;
				}

				if (in_array($extension[1], $allowedExts)) {



					if (move_uploaded_file($_FILES['archivo_documento']['tmp_name'], $img1path)) {
						unlink('../files/pea/ciclo' . $ciclo . '/documentos/' . $_POST["imagenactual"]); // elimina el archivo actual

						$archivo_documento_final = '' . $fechaarchivo . '-' . $_FILES['archivo_documento']['name'];

						$rspta = $peadocente->actualizarArchivo($id_pea_documento, $nombre_documento, $descripcion_documento, $archivo_documento_final, $fecha_respuesta, $hora_respuesta,$condicion_finalizacion_documento, $tipo_condicion_documento, $fecha_inicio_documento, $fecha_limite_documento,$porcentaje_documento,$otorgar_puntos_documento,$puntos_actividad_documento); // inserta el tema

						$resultado = $rspta ? "3" : "4";
						$data["0"] .= $resultado;
					}
				} else {
					$data["0"] .= "5"; // error de formato

				}
			}
		}
		$data["1"] = $id_pea_docentes_subir;
		$results = array($data);
		echo json_encode($results);
	break;

	case 'guardaryeditarvideo':

		$data = array();
		$data["0"] = "";
		$data["1"] = "";


		if (empty($id_pea_video)) { //si el id esta vacio es que se insertara un nuevo video la url


			$traerid_pea_docentes = $peadocente->traeridpeadocente($id_pea_docentes_subir);
			$traeredatosdocentegrupos = $peadocente->comprobar($traerid_pea_docentes["id_docente_grupo"]);
			$ciclo = $traeredatosdocentegrupos["ciclo"];
			$rspta = $peadocente->insertarVideo($id_pea_docentes_video, $id_tema_video, $titulo_video, $descripcion_video,$url_video, $fecha_respuesta, $hora_respuesta, $ciclo_video, $condicion_finalizacion_video, $tipo_condicion_video, $fecha_inicio_video, $fecha_limite_video,$porcentaje_video,$otorgar_puntos_video,$puntos_actividad_video); // inserta el tema
			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
			
			
		} else { // si el id tiene algo quiere decir que es una edición
			$rspta = $peadocente->actualizarVideo($id_pea_video,$id_pea_docentes_video, $id_tema_video, $titulo_video, $descripcion_video,$url_video, $ciclo_video, $condicion_finalizacion_video, $tipo_condicion_video, $fecha_inicio_video, $fecha_limite_video,$porcentaje_video,$otorgar_puntos_video,$puntos_actividad_video); // actualizar el tema
		
			if ($rspta) {
				// acceder al rowCount
				global $mbd;
				$filas = $mbd->query("SELECT ROW_COUNT()")->fetchColumn();

				if ($filas > 0) {
					$resultado = "3"; // se actualizó
				} else {
					$resultado = "5"; // ejecutó pero no cambió nada (datos iguales)
				}
			} else {
				$resultado = "4"; // error de ejecución
			}

			$data["0"] = $resultado;

		}
			$data["1"] = $id_pea_docentes_subir;
			$results = array($data);
		echo json_encode($results);
	break;

	case 'guardaryeditarenlace':

		$data = array();
		$data["0"] = "";
		$data["1"] = "";


		if (empty($id_pea_enlaces)) { //si el id esta vacio es que se insertara una nuevo enlace

			$rspta = $peadocente->insertarEnlace($id_pea_docentes_enlace, $id_tema_enlace, $titulo_enlace, $descripcion_enlace, $enlace, $fecha_respuesta, $hora_respuesta, $condicion_finalizacion_enlace, $tipo_condicion_enlace, $fecha_inicio_enlace, $fecha_limite_enlace,$porcentaje_enlace,$otorgar_puntos_enlace,$puntos_actividad_enlace,$ciclo_enlace); // inserta enlace

			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
		} else { // si el id tiene algo quiere decir que es una edición

			$rspta = $peadocente->actualizarEnlace($id_pea_enlaces, $titulo_enlace, $descripcion_enlace, $enlace, $condicion_finalizacion_enlace, $tipo_condicion_enlace, $fecha_inicio_enlace, $fecha_limite_enlace,$porcentaje_enlace,$otorgar_puntos_enlace,$puntos_actividad_enlace); // inserta el tema

			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		$data["1"] = $id_pea_docentes_enlace;
		$results = array($data);
		echo json_encode($results);
	break;

	case 'guardaryeditarcarpetaejercicios':

		$data = array();
		$data["0"] = "";
		$data["1"] = "";


		if (empty($id_pea_ejercicios_carpeta)) { //si el id esta vacio es que se insertara una nueva carpeta

			$rspta = $peadocente->insertarCarpetaEjercicios($id_pea_docentes_ejercicios_carpeta, $carpeta_ejercicios, $fecha_respuesta, $hora_respuesta); // insertar carpeta

			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
		} else { // si el id tiene algo
			$rspta = $peadocente->editarCarpetaEjercicios($id_pea_ejercicios_carpeta, $carpeta_ejercicios);
			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		$data["1"] = $id_pea_docentes_ejercicios_carpeta;
		$results = array($data);
		echo json_encode($results);
	break;

	case 'guardaryeditarejercicios':

		$data = array();
		$data["0"] = "";
		$data["1"] = "";



		if (empty($id_pea_ejercicios)) { //si el id esta vacio es que se insertara un nuevo ejercicio

			$sumarproejercicioscar = $peadocente->sumarProEjerciciosCarpeta($id_pea_ejercicios_carpeta_subir);
			$totalproejercicioscar = $sumarproejercicioscar["suma_por_ejercicios"];
			$nuevototal = $totalproejercicioscar + $por_ejercicios;

			if ($nuevototal < 100) { // si los ejercicios no superan el 100%


				$traerid_pea_docentes = $peadocente->traeridpeadocente($id_pea_docente_subir_ejercicios);
				$traeredatosdocentegrupos = $peadocente->comprobar($traerid_pea_docentes["id_docente_grupo"]);
				$ciclo = $traeredatosdocentegrupos["ciclo"];

				if ($tipo_archivo_ejercicios == 1) { // imagen
					$allowedExts = array("PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}
				if ($tipo_archivo_ejercicios == 2) { // word
					$allowedExts = array("docx", "doc");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}
				if ($tipo_archivo_ejercicios == 3) { // excel
					$allowedExts = array("xlsx", "xls");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}
				if ($tipo_archivo_ejercicios == 4) { // excel
					$allowedExts = array("pptx", "ppt");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}
				if ($tipo_archivo_ejercicios == 5) { // PDF
					$allowedExts = array("pdf", "PDF");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}
				if ($tipo_archivo_ejercicios == 6) { // comprimido
					$allowedExts = array("rar");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}


				if (in_array($extension[1], $allowedExts)) {

					if (move_uploaded_file($_FILES['archivo_ejercicios']['tmp_name'], $img1path)) {
						$archivo_ejercicios_final = '' . $fechaarchivo . '-' . $_FILES['archivo_ejercicios']['name'];

						$rspta = $peadocente->insertarEjercicio($id_pea_ejercicios_carpeta_subir, $nombre_ejercicios, $descripcion_ejercicios, $tipo_archivo_ejercicios, $archivo_ejercicios_final, $fecha_inicio, $fecha_entrega, $fecha_respuesta, $hora_respuesta, $ciclo, $por_ejercicios); // inserta el tema

						$resultado = $rspta ? "1" : "2";
						$data["0"] .= $resultado;
					}
				} else {
					$data["0"] .= "5"; // error de formato

				}
			} else { // si los ejercicios superan el 100%
				$data["0"] .= "6"; // sobrepasa el 100%
			}
		} else { // si el id tiene algo quiere decir que es una edición

			if (!file_exists($_FILES['archivo_ejercicios']['tmp_name']) || !is_uploaded_file($_FILES['archivo_ejercicios']['tmp_name'])) { // si el archivo es el mismo
				$archivo_ejercicios_final = $_POST["imagenactual_ejercicios"];

				$rspta = $peadocente->actualizarArchivoEjercicios($id_pea_ejercicios, $nombre_ejercicios, $descripcion_ejercicios, $archivo_ejercicios_final, $fecha_inicio, $fecha_entrega, $fecha_respuesta, $hora_respuesta, $por_ejercicios); // inserta el tema

				$resultado = $rspta ? "3" : "4";
				$data["0"] .= $resultado;
			} else { // si cambia el archivo
				$traerid_pea_docentes = $peadocente->traeridpeadocente($id_pea_docente_subir_ejercicios);
				$traeredatosdocentegrupos = $peadocente->comprobar($traerid_pea_docentes["id_docente_grupo"]);
				$ciclo = $traeredatosdocentegrupos["ciclo"];

				if ($tipo_archivo_ejercicios == 1) { // imagen
					$allowedExts = array("PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}


				if ($tipo_archivo_ejercicios == 2) { // word
					$allowedExts = array("docx", "doc");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}
				if ($tipo_archivo_ejercicios == 3) { // excel
					$allowedExts = array("xlsx", "xls");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}
				if ($tipo_archivo_ejercicios == 4) { // excel
					$allowedExts = array("pptx", "ppt");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}
				if ($tipo_archivo_ejercicios == 5) { // PDF
					$allowedExts = array("pdf", "PDF");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}
				if ($tipo_archivo_ejercicios == 6) { // comprimido
					$allowedExts = array("rar");
					$target_path = '../files/pea/ciclo' . $ciclo . '/ejercicios/';
					$extension = explode(".", $archivo_ejercicios);
					$img1path = $target_path . '' . $fechaarchivo . '-' . $archivo_ejercicios;
				}

				if (in_array($extension[1], $allowedExts)) {



					if (move_uploaded_file($_FILES['archivo_ejercicios']['tmp_name'], $img1path)) {
						unlink('../files/pea/ciclo' . $ciclo . '/ejercicios/' . $_POST["imagenactual_ejercicios"]); // elimina el archivo actual

						$archivo_ejercicios_final = '' . $fechaarchivo . '-' . $_FILES['archivo_ejercicios']['name'];

						$rspta = $peadocente->actualizarArchivoEjercicios($id_pea_ejercicios, $nombre_ejercicios, $descripcion_ejercicios, $archivo_ejercicios_final, $fecha_inicio, $fecha_entrega, $fecha_respuesta, $hora_respuesta, $por_ejercicios);

						$resultado = $rspta ? "3" : "4";
						$data["0"] .= $resultado;
					}
				} else {
					$data["0"] .= "5"; // error de formato

				}
			}
		}
		$data["1"] = $id_pea_docente_subir_ejercicios;

		$results = array($data);
		echo json_encode($results);
	break;



	case 'comprobar':

		//Vamos a declarar un array
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo


		$id_docente_grupo = $_POST['id_docente_grupo'];
		$id_materia = $_POST['id_materia'];
		$id_programa = $_POST['id_programa'];

		$rspta = $peadocente->tienepea($id_docente_grupo);
		$datos = $rspta;

		if ($rspta == false) { // si no tiene pea docente
			$verpea = $peadocente->pea($id_programa, $materia);
			$id_pea = $verpea["id_pea"];
			if ($verpea == false) { // no tiene pea creado por el admin
				$data["0"] .= '1'; // quiere decir que no tiene pea por el admin y tampoco por el docente
			} else { //si tiene pea creado por el admin

				$rspta2 = $peadocente->insertarpeadocente($id_pea, $id_docente_grupo, $fecha_respuesta, $hora_respuesta); // crear el pea en la tabla pea docente
				$data["0"] .= '2';
			}
		} else { // si tiene pea docente
			$data["0"] .= '3'; //puede ver el pea
		}

		$results = array($data);
		echo json_encode($results);

	break;

	case 'listar':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";

		$id_materia = $_POST["id_materia"];
		$id_programa = $_POST["id_programa"];
		$id_docente_grupo = $_POST["id_docente_grupo"];

		$pea_docente = $peadocente->peadocente($id_docente_grupo);
		$id_pea = $pea_docente["id_pea"];
		$id_pea_docente = $pea_docente["id_pea_docentes"];
		$ciclo = $pea_docente["ciclo"];

		$datosmateria = $peadocente->datosmateria($id_materia);
		$materia = $datosmateria["nombre"];

			$data["0"] .= '
		<div class="row">';
			/*
			$data["0"] .= '
			<div class="col-xl-3">
				<div class="row">

					<div class="col-xl-12">
						<div class="card ">
							<div class="tono-3 p-3">
							<div class="row align-items-center">
									<div class="col-auto">
										<i class="fa-regular fa-file bg-light-blue rounded p-3 text-primary fs-16" aria-hidden="true"></i>
								
									</div>
									<div class="col pt-2 line-height-16">
										<h6 class="mb-0 titulo-1 fs-22 text-semibold">Documentos</h6>
										<p class="text-muted fs-18">de apoyo</p>
									</div>
								</div>
							</div>
							<div class="px-4 pb-4 pt-2">
								<div class="col-12">
									Son aquellos de carácter general, temporal y solamente informativos. 
								</div>
								<div class="row mb-3">
								
									<div class="col-auto pt-2">
										<span class="text-secondary fs-14">
											<a onclick="documentos(' . $id_pea_docente . ')" title="Documentos" class="btn btn-primary text-white">Gestionar</a>
										</span>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-xl-12">
						<div class="card ">
							<div class="tono-3 p-3">
							<div class="row align-items-center">
									<div class="col-auto">
										<i class="fa-solid fa-link bg-light-blue rounded p-3 text-primary fs-16" aria-hidden="true"></i>
									</div>
									<div class="col pt-2 line-height-16">
										<h6 class="mb-0 titulo-1 fs-22 text-semibold">Enlaces</h6>
										<p class="text-muted fs-18">de apoyo</p>
									</div>
								</div>
							</div>
							<div class="px-4 pb-4 pt-2">
								<div class="col-12">
									Publique enlaces web que sirvan de apoyo y crecimiento a este espacio 
								</div>
								<div class="row mb-3">

									<div class="col-auto pt-2">
										<span class="text-secondary fs-14">
											<a  onclick="enlaces(' . $id_pea_docente . ')" title="Enlaces" class="btn btn-primary text-white">Gestionar</a>
										</span>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-xl-12">
						<div class="card ">
							<div class="tono-3 p-3">
							<div class="row align-items-center">
									<div class="col-auto">
										<i class="fa-solid fa-chalkboard-user bg-light-green rounded p-3 text-success fs-16" aria-hidden="true"></i>
									</div>
									<div class="col pt-2 line-height-16">
										<h6 class="mb-0 titulo-1 fs-22 text-semibold">Ejercicios</h6>
										<p class="text-muted fs-18">Digitales</p>
									</div>
								</div>
							</div>
							<div class="px-4 pb-4 pt-2">
								<div class="col-12">
									Realización de actividades qué facilitan el aprendizaje de los estudiantes. 
								</div>
								<div class="row mb-3">

									<div class="col-auto pt-2">
										<span class="text-secondary fs-14">
											<a onclick="ejercicios(' . $id_pea_docente . ')" title="Ejercicios" class="btn btn-success text-white">Gestionar</a>
										</span>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-xl-12">
						<div class="card ">
							<div class="tono-3 p-3">
							<div class="row align-items-center">
									<div class="col-auto">
										<i class="fa-solid fa-circle-info bg-light-blue rounded p-3 text-primary fs-16" aria-hidden="true"></i>
									</div>
									<div class="col pt-2 line-height-16">
										<h6 class="mb-0 titulo-1 fs-22 text-semibold">Glosario</h6>
										<p class="text-muted fs-18">Digital</p>
									</div>
								</div>
							</div>
							<div class="px-4 pb-4 pt-2">
								<div class="col-12">
									Definiciones concretas sobre temas determinados y de fácil apropiación.
								</div>
								<div class="row mb-3">
									<div class="col-auto pt-2">
										<span class="text-secondary fs-14">
											<a onclick="glosario(' . $id_pea_docente . ')" title="Ejercicios" class="btn btn-primary text-white">Gestionar</a>
										</span>
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>
			</div>
			';
			*/

			$rspta = $peadocente->verPea($id_pea); // Temas del PEA
			$totalTemas = count($rspta);
			$temasVistos = 0;

			// Contar progreso
			for ($i = 0; $i < $totalTemas; $i++) {
				$id_tema = $rspta[$i]["id_tema"];
				$verificarestado = $peadocente->verEstadoTema($ciclo, $id_pea, $id_pea_docente, $id_tema);
				if ($verificarestado && $verificarestado["estado_tema"] == 2) {
					$temasVistos++;
				}
			}

			$porcentaje_progreso = ($totalTemas > 0) ? round(($temasVistos / $totalTemas) * 100) : 0;

			$data["0"] .= '
			<div class="col-xl-5">
				<div class="row align-items-center">
					<div class="col-auto">
						<p class="fs-18 mb-0">Asignatura</p>
						<h4 class="fw-medium">
							<a onclick="planestudios()" class="pointer text-white">'.$materia.'</a>
						</h4>
					</div>
					
				</div>
			</div>
			<div class="col-12"></div>
			<div class="col-xl-5 col-12 position-relative timeline3">
				<div class="timeline-line-base"></div>
				<div class="timeline-line-progress" style="height: '.$porcentaje_progreso.'%;"></div>

				<div class="row justify-content-center">
					<div class="col-xl-12 col-12">
						<div class="row">

					<div class="col-xl-12 mb-3" style="margin-left:-34px">
							<a onclick="descripcion('.$id_pea.')" class="btn bg-7 text-white">Ver Proyecto</a>
					</div>


							<div class="col-xl-12 col-12 pb-3">
								<ol>';

									$temanun = 1;
									for ($i = 0; $i < $totalTemas; $i++) {
										$id_tema = $rspta[$i]["id_tema"];
										$conceptuales = $rspta[$i]["conceptuales"];
										$verificarestado = $peadocente->verEstadoTema($ciclo, $id_pea, $id_pea_docente, $id_tema);

										$estado_tema = 0;
										$clase_estado = "";
										$icono_estado = "";
										$botonvisto = "";
										$color_bg = "bg-navy";

										if ($verificarestado) {
											$estado_tema = $verificarestado["estado_tema"];
											$id_pea_tema_ciclo = $verificarestado["id_pea_tema_ciclo"];
											$clase_estado = ($estado_tema == 2) ? "estado-verde" : "";
											$color_bg = ($estado_tema == 2) ? "bg-success" : "bg-purple";
											$icono_estado = ($estado_tema == 2) ? '<i class="fa fa-check text-white fs-16"></i>' : '';
											$botonvisto = ($estado_tema == 1) ? 
												'<a class="btn titulo-2" title="Marcar tema visto" onclick="marcarVisto('.$id_materia.','.$id_programa.','.$ciclo.','.$id_pea_tema_ciclo.')">
													<i class="fa-solid fa-circle-check text-success"></i> Marcar tema visto
												</a>' 
												: '';
										}

										$data["0"] .= '
										<div class="timeline__event '.$clase_estado.' mb-3 tono-3">
											<div class="timeline__event__icon '.$color_bg.'">
											 '.$temanun++.'
											</div>
											<div class="timeline__event__content">
												<p class="titulo-2 fs-14 mb-1">'.$conceptuales.'</p>
												<div class="">';
												if($estado_tema==0){
														$data["0"] .= '
														<a onclick="validartema('.$id_materia.','.$id_programa.','.$id_pea.','.$id_tema.','.$id_pea_docente.','.$ciclo.')" 
															class="btn btn-xs bg-warning text-white">
															<i class="fa fa-plus"></i> Validar Tema
														</a>';
												}else{
													$data["0"] .= '
													<a onclick="agregarrecurso('.$id_materia.','.$id_programa.','.$id_pea.','.$id_tema.','.$id_pea_docente.','.$ciclo.')" 
														class="btn btn-xs bg-purple text-white">
														<i class="fa fa-plus"></i> Agregar recurso
													</a>';
												}
													
														$data["0"] .= '
													'.$botonvisto.'
												</div>
											</div>
										</div>';
									}

									$data["0"] .= '
								</ol>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';



		//$datosdelpea=$pea->datospea($id_pea);



		// $data["0"] .= '<div class="border col-12 mt-4">';
		// 	$data["0"] .= '<div class="border col-12 bg-1 p-2 m-0 text-white text-center"> Contenidos </div>';
		// 		$data["0"] .= '<ul>';
		// 		$rspta=$peadocente->listaractividades($id_tema,$id_docente_grupo);//Consulta para ver los Temas del PEA
		// 			for($i=0;$i<count($rspta);$i++){

		// 				$data["0"] .= '<li>
		// 									<a onclick="mostrareditartema('.$rspta[$i]["id_tema"].','.$id_pea.')" title="Editar Tema" class="btn btn-warning btn-xs text-white"><i class="fas fa-pencil-alt"></i></a> 
		// 									<a onclick="eliminartema('.$rspta[$i]["id_tema"].','.$id_pea.')" title="Eliminar Tema" class="btn btn-danger btn-xs text-white"><i class="fas fa-trash-alt"></i></a> '
		// 										.$rspta[$i]["conceptuales"].
		// 								'</li>';

		// 			}
		// 		$data["0"] .= '</ul>';

		// $data["0"] .= '</div>';

		$results = array($data);
		echo json_encode($results);

	break;

	case 'descripcion':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";

		$id_pea = $_POST["id_pea"];



		$datosdelpea = $peadocente->datospea($id_pea);
		$id_materia = $datosdelpea["id_materia"];
		$fecha_aprobacion = $datosdelpea["fecha_aprobacion"];
		$version = $datosdelpea["version"];

		$datosmateria = $peadocente->datosmateria($id_materia);
		$materia = $datosmateria["nombre"];
		$id_programa_ac = $datosmateria["id_programa_ac"];
		$semestre = $datosmateria["semestre"];
		$area = $datosmateria["area"];
		$creditos = $datosmateria["creditos"];
		$presenciales = $datosmateria["presenciales"];
		$independientes = $datosmateria["independiente"];
		$prerequisito = $datosmateria["prerequisito"];

		$datosprograma = $peadocente->datosprograma($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];

		$datosescuela = $peadocente->datosescuela($id_escuela);
		$escuela = $datosescuela["escuelas"];

		if ($prerequisito == null) {
			$prerequisito = "";
		} else {
			$datosmateriapre = $peadocente->datosmateriapre($prerequisito);
			$prerequisito = $datosmateriapre["nombre"];
		}

		$data["0"] .= '<div class="row justify-content-center">';

		$data["0"] .= '<div class="col-12 text-right">
									<a href="docentegrupos.php" class="btn btn-link btn-sm">listado de grupos</a>/ 
									<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
									/ Descripción
								</div>';

		$data["0"] .= '<div class="col-xl-8 mt-2 p-0">';
		$data["0"] .= '<table class="table">';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td><img src="../public/img/logo_print.jpg" width="150px"></td>';
		$data["0"] .= '<td><b>Fecha: </b>' . $fecha_aprobacion . '<br> <b>Versión: </b>' . $version . '</td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';

		$data["0"] .= '<div class="col-xl-8 mt-1 p-0">';
		$data["0"] .= '<table class="table">';
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
		$data["0"] .= '<table class="table">';
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


		$data["0"] .= '<div class="borde col-xl-8 mt-1 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-1 p-2 m-0 text-white text-center"> COMPETENCIA DE LA ASIGNATURA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
										' . $datosdelpea["competencias"] . '
									</div>';
		$data["0"] .= '</div>';

		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-1 p-2 m-0 text-white text-center"> RESULTADO DE APRENDIZAJE </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
										' . $datosdelpea["resultado"] . '
									</div>';
		$data["0"] .= '</div>';

		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-1 p-2 m-0 text-white text-center"> CRITERIOS DE EVALUACIÓN DE LA ASIGNATURA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
										' . $datosdelpea["criterio"] . '
									</div>';
		$data["0"] .= '</div>';

		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-1 p-2 m-0 text-white text-center"> METODOLOGÍA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
										' . $datosdelpea["metodologia"] . '
									</div>';
		$data["0"] .= '</div>';

		/* consulta para teaer los temas */
		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-1 p-2 m-0 text-white text-center"> Contenidos </div>';
		$data["0"] .= '<ul>';
		$rspta = $peadocente->verPea($id_pea); //Consulta para ver los Temas del PEA
		for ($i = 0; $i < count($rspta); $i++) {
			$data["0"] .= '<li>' . $rspta[$i]["conceptuales"] . '</li>';
		}
		$data["0"] .= '</ul>';

		$data["0"] .= '</div>';
		/* **************************** */


		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-1 p-2 m-0 text-white text-center"> REFERENCIAS </div>';
		$data["0"] .= '<ul>';
		$rspta2 = $peadocente->verPeaReferencia($id_pea); //Consulta para ver los Temas del PEA
		for ($j = 0; $j < count($rspta2); $j++) {
			$data["0"] .= '<li>' . $rspta2[$j]["referencia"] . '</li>';
		}
		$data["0"] .= '</ul>';

		$data["0"] .= '</div>';

		$data["0"] .= '</div>';



		$results = array($data);
		echo json_encode($results);

	break;

	// case 'documentos':
	// 	//Vamos a declarar un array
	// 	$data = array();
	// 	$data["0"] = "";

	// 	$id_pea_docente = $_POST["id_pea_docente"];


	// 	$data["0"] .= '<div class="row justify-content-center">';

	// 	$data["0"] .= '
	// 		<div class="col-12 text-right">
	// 			<a href="docentegrupos.php" class="btn btn-link btn-sm">listado de grupos</a>/ 
	// 			<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
	// 			/ Documentos
	// 		</div>';

	// 	$data["0"] .= '
	// 		<div class="col-12 mb-2">
	// 			<a onclick="carpetaDocumento(' . $id_pea_docente . ')" class="btn btn-default btn-sm "> <i class="fas fa-folder text-warning"></i> Crear carpeta </a>
	// 		</div>';

	// 	/* consulta para teaer las carpetas */

	// 	$rspta = $peadocente->verCarpetas($id_pea_docente); //Consulta para ver llas carpetas

	// 	for ($i = 0; $i < count($rspta); $i++) {

	// 		if ($i == 0) {
	// 			$colapso = "";
	// 		} else {
	// 			$colapso = "collapsed-card";
	// 		}

	// 		$data["0"] .= '
	// 			<div class="col-12">
	// 				<div class="card card-primary ' . $colapso . '">
	// 					<div class="card-header">
	// 						<h3 class="card-title">
	// 							<a a onclick="editarCarpetaDocumento(' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" class="btn btn-warning btn-xs" title="Editar Carpeta"><i class="fas fa-edit"></i></a>
	// 							' . $rspta[$i]["carpeta"] . '
	// 						</h3>
	// 						<div class="card-tools">
	// 							<button type="button" class="btn btn-tool" data-card-widget="collapse">
	// 								<i class="fas fa-minus"></i>
	// 							</button>
	// 						</div>
	// 					</div>';

	// 		$data["0"] .= '
	// 					<div class="card-body p-0 m-0">
	// 						<div class="col-12 text-right bg-1 p-2">
	// 							<span class="text-white">Publicar un documento</span>
	// 							<a onclick="archivo(1,' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" title="Imagen, jpg, png" class="btn m-0 p-0"><i class="fas fa-file-image text-info fa-2x"></i></a>
	// 							<a onclick="archivo(2,' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" title="Documento en WORD" class="btn m-0 p-0"><i class="fas fa-file-word fa-2x text-primary"></i></a>
	// 							<a onclick="archivo(3,' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" title="Documento en Excel" class="btn m-0 p-0"><i class="fas fa-file-excel fa-2x text-success"></i></a>
	// 							<a onclick="archivo(4,' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" title="Documento en PowerPoint" class="btn m-0 p-0"><i class="fas fa-file-powerpoint fa-2x text-pink"></i></a>
	// 							<a onclick="archivo(5,' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" title="Documento en PDF" class="btn m-0 p-0"><i class="fas fa-file-pdf fa-2x text-danger"></i></a>
	// 							<a onclick="archivo(6,' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" title="Docuemento en RAR" class="btn m-0 p-0"><i class="fas fa-file-archive fa-2x text-orange"></i></a>
	// 							<a onclick="archivolink(7,' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" title="Link del VIDEO" class="btn m-0 p-0"><i class="fas fa-file-video fa-2x text-danger"></i></a>
	// 							<a onclick="archivolink(8,' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" title="Link de DRIVE" class="btn m-0 p-0"><i class="fab fa-google-drive fa-2x text-primary"></i></a>
	// 							<a onclick="archivolink(9,' . $rspta[$i]["id_pea_documento_carpeta"] . ',' . $id_pea_docente . ')" title="Link WEB" class="btn m-0 p-0"><i class="fas fa-link fa-2x text-indigo"></i></a>
	// 						</div>';

	// 		$data["0"] .= '<div class="row p-2">';

	// 		/* consulta para traer los documentos de cada carpeta */
	// 		$rsptadoc = $peadocente->verPeaDocumentos($rspta[$i]["id_pea_documento_carpeta"]); //Consulta para ver los Temas del PEA
	// 		for ($j = 0; $j < count($rsptadoc); $j++) {

	// 			$id_pea_documento = $rsptadoc[$j]["id_pea_documento"];
	// 			$tipo_archivo = $rsptadoc[$j]["tipo_archivo"];
	// 			$nombre_documento = $rsptadoc[$j]["nombre_documento"];
	// 			$descripcion_documento = $rsptadoc[$j]["descripcion_documento"];
	// 			$fecha_actividad = $rsptadoc[$j]["fecha_actividad"];
	// 			$archivo_documento = $rsptadoc[$j]["archivo_documento"];
	// 			$ciclo = $rsptadoc[$j]["ciclo"];


	// 			$fecha_inicio_evento = date($fecha_actividad);
	// 			$dia = date("d", strtotime($fecha_inicio_evento));
	// 			$mes = date("m", strtotime($fecha_inicio_evento));

	// 			switch ($tipo_archivo) {
	// 				case '1':
	// 					$icono_doc = '../files/pea/imagen.webp';
	// 					$documento_tipo = "Imagen";
	// 					$btneliminar = '<a onclick="eliminarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>';
	// 					$btneditar = '<a onclick="editarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer"><i class="fas fa-edit"></i></a>';
	// 					$linkdescarga = '<a href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Descargar</a>';
	// 					break;
	// 				case '2':
	// 					$icono_doc = '../files/pea/word.webp';
	// 					$documento_tipo = "Word";
	// 					$btneliminar = '<a onclick="eliminarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>';
	// 					$btneditar = '<a onclick="editarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer"><i class="fas fa-edit"></i></a>';
	// 					$linkdescarga = '<a href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Descargar</a>';
	// 					break;
	// 				case '3':
	// 					$icono_doc = '../files/pea/excel.webp';
	// 					$documento_tipo = "Excel";
	// 					$btneliminar = '<a onclick="eliminarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>';
	// 					$btneditar = '<a onclick="editarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer"><i class="fas fa-edit"></i></a>';
	// 					$linkdescarga = '<a href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Descargar</a>';
	// 					break;
	// 				case '4':
	// 					$icono_doc = '../files/pea/powerpoint.webp';
	// 					$documento_tipo = "PowerPoint";
	// 					$btneliminar = '<a onclick="eliminarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>';
	// 					$btneditar = '<a onclick="editarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer"><i class="fas fa-edit"></i></a>';
	// 					$linkdescarga = '<a href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Descargar</a>';
	// 					break;
	// 				case '5':
	// 					$icono_doc = '../files/pea/pdf.webp';
	// 					$documento_tipo = "PDF";
	// 					$btneliminar = '<a onclick="eliminarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>';
	// 					$btneditar = '<a onclick="editarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer"><i class="fas fa-edit"></i></a>';
	// 					$linkdescarga = '<a href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Descargar</a>';
	// 					break;
	// 				case '6':
	// 					$icono_doc = '../files/pea/rar.webp';
	// 					$documento_tipo = "Comprimido";
	// 					$btneliminar = '<a onclick="eliminarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>';
	// 					$btneditar = '<a onclick="editarArchivo(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer"><i class="fas fa-edit"></i></a>';
	// 					$linkdescarga = '<a href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Descargar</a>';
	// 					break;
	// 				case '7':
	// 					$icono_doc = '../files/pea/youtube.webp';
	// 					$documento_tipo = "Video Youtube";
	// 					$btneliminar = '<a onclick="eliminarArchivoLink(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>';
	// 					$btneditar = '<a onclick="editarArchivoLink(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer"><i class="fas fa-edit"></i></a>';
	// 					$linkdescarga = '<a href="' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
	// 					break;
	// 				case '8':
	// 					$icono_doc = '../files/pea/drive.webp';
	// 					$documento_tipo = "Link DRIVE";
	// 					$btneliminar = '<a onclick="eliminarArchivoLink(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>';
	// 					$btneditar = '<a onclick="editarArchivoLink(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer"><i class="fas fa-edit"></i></a>';
	// 					$linkdescarga = '<a href="' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
	// 					break;
	// 				case '9':
	// 					$icono_doc = '../files/pea/meet.webp';
	// 					$documento_tipo = "Link WEB";
	// 					$btneliminar = '<a onclick="eliminarArchivoLink(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>';
	// 					$btneditar = '<a onclick="editarArchivoLink(' . $id_pea_documento . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer"><i class="fas fa-edit"></i></a>';
	// 					$linkdescarga = '<a href="' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
	// 					break;
	// 			}

	// 			switch ($mes) {
	// 				case '01':
	// 					$meses = "Ene";
	// 					break;
	// 				case '02':
	// 					$meses = "Feb";
	// 					break;
	// 				case '03':
	// 					$meses = "Mar";
	// 					break;
	// 				case '04':
	// 					$meses = "Abr";
	// 					break;
	// 				case '05':
	// 					$meses = "May";
	// 					break;
	// 				case '06':
	// 					$meses = "Jun";
	// 					break;
	// 				case '07':
	// 					$meses = "Jul";
	// 					break;
	// 				case '08':
	// 					$meses = "Ago";
	// 					break;
	// 				case '09':
	// 					$meses = "Sep";
	// 					break;
	// 				case '10':
	// 					$meses = "Oct";
	// 					break;
	// 				case '11':
	// 					$meses = "Nov";
	// 					break;
	// 				case '12':
	// 					$meses = "Dic";
	// 					break;
	// 			}

	// 			$descargasdoc = $peadocente->descargasDoc($id_pea_documento);
	// 			$totaldescargas = count($descargasdoc);

	// 			$data["0"] .= '<div class="col-xl-3">';
	// 			$data["0"] .= '
	// 									<div class="post-module">
	// 										<div class="thumbnail">
	// 											<div class="date">
	// 												<div class="day">' . $dia . '</div>
	// 												<div class="month">' . $meses . '</div>
	// 											</div>
	// 											<img src="' . $icono_doc . '" alt="Documento de imagen">
	// 										</div>
	// 										<div class="post-content">
	// 											<div class="category">' . $documento_tipo . '</div>
	// 											<h1 class="title">' . $nombre_documento . '</h1>
	// 											<h2 class="sub_title">Complemento</h2>
	// 											<p class="description" style="display: none; height: 76px; opacity: 1;">' . $descripcion_documento . '</p>
	// 											<div class="post-meta">
	// 												' . $btneliminar . '
	// 												' . $btneditar . '
	// 												' . $linkdescarga . '
	// 												<span class="float-right badge bg-success mt-1"><a onclick="verDescargas(' . $id_pea_documento . ')" title="Ver comentarios" style="cursor:pointer">' . $totaldescargas . ' <i class="fas fa-comment"></i></a></span>
	// 												<span class="float-right badge bg-primary mt-1"><a onclick="verDescargas(' . $id_pea_documento . ')" title="Ver descargas" style="cursor:pointer">' . $totaldescargas . ' <i class="fas fa-download"></i></a></span>
	// 											</div>
	// 										</div>
	// 									</div>';
	// 			$data["0"] .= '</div>';
	// 		}
	// 		/* **************************** */
	// 		$data["0"] .= '</div>';

	// 		$data["0"] .= '</div>';

	// 		$data["0"] .= '</div>';
	// 	}

	// 	$data["0"] .= '</div>';


	// 	$results = array($data);
	// 	echo json_encode($results);

	// break;

	case 'enlaces':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";

		$id_pea_docente = $_POST["id_pea_docente"];


		$data["0"] .= '<div class="row">';

		$data["0"] .= '
			<div class="col-12 text-right">
				<a href="docentegrupos.php" class="btn btn-link btn-sm">listado de grupos</a>/ 
				<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
				/ Enlaces
			</div>';

		$data["0"] .= '
			<div class="col-12 mb-4 border-bottom pb-3">
				<a onclick="crearEnlace(' . $id_pea_docente . ')" class="btn btn-default btn-sm "> <i class="fas fa-globe text-primary"></i> Crear enlace </a>
			</div>';

		/* consulta para teaer los enlaces */

		$rspta = $peadocente->verEnlaces($id_pea_docente); //Consulta para ver los enlaces

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
									<a onclick="eliminarEnlace(' . $id_pea_enlaces . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>
									<a onclick="editarEnlace(' . $id_pea_enlaces . ',' . $id_pea_docente . ')" title="Editar Enlace" style="cursor:pointer"><i class="fas fa-edit"></i></a>
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

	case 'ejercicios':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";

		$id_pea_docente = $_POST["id_pea_docente"];
		$taerdocgrupo = $peadocente->traeridpeadocente($id_pea_docente);
		$id_docente_grupo = $taerdocgrupo["id_docente_grupo"];


		$data["0"] .= '<div class="row justify-content-center">';

		$data["0"] .= '
			<div class="col-12 text-right">
				<a href="docentegrupos.php" class="btn btn-link btn-sm">listado de grupos</a>/ 
				<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
				/ Ejercicios
			</div>';

		$data["0"] .= '
			<div class="col-12 mb-2">
				<a onclick="carpetaEjercicios(' . $id_pea_docente . ')" class="btn btn-default btn-sm "> <i class="fas fa-folder text-warning"></i> Crear carpeta </a>
			</div>';

		/* consulta para teaer las carpetas */

		$rspta = $peadocente->verCarpetasEjercicios($id_pea_docente); //Consulta para ver llas carpetas

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
								<a a onclick="editarCarpetaEjercicios(' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" class="btn btn-warning btn-xs" title="Editar Carpeta"><i class="fas fa-edit"></i></a>
								' . $rspta[$i]["carpeta_ejercicios"] . '
							</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>';

			$data["0"] .= '<div class="card-body p-0 m-0">';
			$data["0"] .= '<div class="row m-0 bg-1">';

			$sumarproejercicioscar = $peadocente->sumarProEjerciciosCarpeta($rspta[$i]["id_pea_ejercicios_carpeta"]);
			$totalproejercicioscar = $sumarproejercicioscar["suma_por_ejercicios"];

			$data["0"] .= '<div class="col-6 p-2 text-white">';
			$data["0"] .= 'Ejercicios: <span class="text-success p-1">' . $totalproejercicioscar . '%</span>';
			$data["0"] .= '<a onclick="listarCalificarCompleto(' . $id_docente_grupo . ',' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ')" class="btn btn-primary btn-xs">Ver Completo</a>';
			$data["0"] .= '</div>';

			$data["0"] .= '<div class="col-6 text-right p-2 d-none">
									<span class="text-white">Publicar un ejercicio</span>
									<a onclick="archivoEjercicios(1,' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" title="Imagen, jpg, png" class="btn m-0 p-0"><i class="fas fa-file-image text-info fa-2x"></i></a>
									<a onclick="archivoEjercicios(2,' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" title="Documento en WORD" class="btn m-0 p-0"><i class="fas fa-file-word fa-2x text-primary"></i></a>
									<a onclick="archivoEjercicios(3,' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" title="Documento en Excel" class="btn m-0 p-0"><i class="fas fa-file-excel fa-2x text-success"></i></a>
									<a onclick="archivoEjercicios(4,' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" title="Documento en PowerPoint" class="btn m-0 p-0"><i class="fas fa-file-powerpoint fa-2x text-pink"></i></a>
									<a onclick="archivoEjercicios(5,' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" title="Documento en PDF" class="btn m-0 p-0"><i class="fas fa-file-pdf fa-2x text-danger"></i></a>
									<a onclick="archivoEjercicios(6,' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" title="Docuemento en RAR" class="btn m-0 p-0"><i class="fas fa-file-archive fa-2x text-orange"></i></a>
									<a onclick="archivoEjercicios(7,' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" title="Link video YOUTUBE" class="btn m-0 p-0"><i class="fas fa-file-video fa-2x text-danger"></i></a>
									<a onclick="archivoEjercicios(8,' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" title="Link de DRIVE" class="btn m-0 p-0"><i class="fab fa-google-drive fa-2x text-primary"></i></a>
									<a onclick="archivoEjercicios(9,' . $rspta[$i]["id_pea_ejercicios_carpeta"] . ',' . $id_pea_docente . ')" title="Link WEB" class="btn m-0 p-0"><i class="fas fa-link fa-2x text-indigo"></i></a>
								</div>';
			$data["0"] .= '</div>';

			$data["0"] .= '<div class="row p-2">';

			/* consulta para traer los documentos de cada carpeta */
			$rsptadoc = $peadocente->verPeaDocumentosEjercicios($rspta[$i]["id_pea_ejercicios_carpeta"]); //Consulta para ver los Temas del PEA
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
				$por_ejercicios = $rsptadoc[$j]["por_ejercicios"];

				$linkdescarga = "../files/pea/ciclo" . $ciclo . "/ejercicios/" . $archivo_ejercicios;

				$fecha_inicio_evento = date($fecha_inicio);
				$dia = date("d", strtotime($fecha_inicio_evento));
				$mes = date("m", strtotime($fecha_inicio_evento));

				/* calcular los dias que hacen falta para entregar el ejercicio */
				$fechahoy = new DateTime($fecha_respuesta);
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

				// $descargasdoc=$peadocente->descargasDoc($id_pea_documento);
				// $totaldescargas=count($descargasdoc);

				if ($fecha_respuesta >= $fecha_inicio) {
					if ($diferencia < 0) { // quiere decir que termino el evento
						$botondescarga = '<a href="' . $linkdescarga . '" target="_blank" class="btn bg-orange btn-xs text-white">Archivo</a>';
						$diaevento = '
											<div class="date bg-orange" title="iniciado" style="width:65px; height:65px">
												<div class="small text-white">Finalizó</div>
												<div class="day text-white">0</div>
												<div class="month text-white">Días</div>
											</div>';
						$categoria = '<div class="category bg-orange text-white">' . $documento_tipo . '</div>';
						$verentregas = '<span class="float-right badge bg-primary mt-1"><a onclick="listarCalificar(' . $id_docente_grupo . ',' . $id_pea_ejercicios . ')" title="Ver entregas" style="cursor:pointer"> <i class="fas fa-upload"></i> Ejercicios </a></span>';
						$comentarios = '<span class="float-right badge bg-success mt-1"><a onclick="verDescargas(' . $id_pea_ejercicios . ')" title="Ver comentarios" style="cursor:pointer"><i class="fas fa-comment"></i></a></span>';
					} else { // el evento esta activo
						// boton para notificar al estudiante cuando el profesor envia el taller por medio del correo
						// . '<a class="btn btn-warning btn-xs text-white" onclick="NotificarEstudiantes(' . $id_docente_grupo . ',' . $id_pea_ejercicios . ')" title="Notificar Estudiantes"  style="cursor:pointer;margin:3px"> <i class="far fa-bell	"></i> Notificar </a>'
						$botondescarga = '<a href="' . $linkdescarga . '" target="_blank" class="btn btn-primary btn-xs text-white">Ver Ejercicio </a>';
						$diaevento = '
											<div class="date" title="iniciado" style="width:65px; height:65px">
												<div class="small">Faltan</div>
												<div class="day">' . $diferencia . '</div>
												<div class="month">Días</div>
											</div>';
						$categoria = '<div class="category">' . $documento_tipo . '</div>';
						$verentregas = '<span class="float-right badge bg-primary mt-1"><a onclick="listarCalificar(' . $id_docente_grupo . ',' . $id_pea_ejercicios . ')" title="Ver entregas" style="cursor:pointer"> <i class="fas fa-upload"></i> Ejercicios </a></span>';
						$comentarios = '<span class="float-right badge bg-success mt-1"><a onclick="verDescargas(' . $id_pea_ejercicios . ')" title="Ver comentarios" style="cursor:pointer"><i class="fas fa-comment"></i></a></span>';
					}
				} else { // el evento no ha iniciado
					$botondescarga = '<a href="#" class="btn bg-1 btn-sm text-white">Proximamente</a>';
					$diaevento = '
										<div class="date bg-1" title="inicia el" style="width:65px; height:65px">
											<div class="small">Inicia</div>
											<div class="day">' . $dia . '</div>
											<div class="month">' . $meses . '</div>
										</div>';
					$categoria = '<div class="category bg-1">' . $documento_tipo . '</div>';
					$verentregas = '';
					$comentarios = '';
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
												<span class="badge bg-success float-right" title="Porcentaje ejercicio" style="margin-top:-10px">' . $por_ejercicios . '%</span><br>
												<h2 class="title">' . $nombre_ejercicios . ' </h2>
												<p class="text-danger">Hasta: ' . $peadocente->fechaesp($fecha_entrega) . '</p>
												<p class="description" style="display: none; height: 76px; opacity: 1;">' . $descripcion_ejercicios . '</p>
												<div class="post-meta">
													<a onclick="eliminarArchivo(' . $id_pea_ejercicios . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt"></i></a>
													<a onclick="editarArchivoEjercicios(' . $id_pea_ejercicios . ',' . $id_pea_docente . ')" title="Editar Ejercicio" style="cursor:pointer"><i class="fas fa-edit"></i></a>
													' . $botondescarga . '
													' . $comentarios . '
													' . $verentregas . '
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

	case 'listaractividades':

		$data = array();
		$data["0"] = ""; //iniciamos el arreglo

		$id_tema = $_POST["id_tema"];
		$id_docente_grupo = $_POST["id_docente_grupo"];
		//Vamos a declarar un array



		$rspta = $peadocente->listaractividades($id_tema, $id_docente_grupo);
		$reg = $rspta;
		$data["0"] .= '<div class="row">';
		for ($i = 0; $i < count($reg); $i++) {

			$data["0"] .= '
				<div class="col-xl-6 col-lg-6 col-md-12 col-12">
					<div class="row">
						<div class="card col-12 p-2">
							<div class="row">
								<div class="col-8">
									<h3 class="box-title">' . $reg[$i]["nombre_actividad"] . '</h3>
								</div>

								<div class="col-4">
									<a onclick="eliminar(' . $reg[$i]["id_pea_actividades"] . ',' . $reg[$i]["tipo_archivo"] . ',' . $id_tema . ',' . $id_docente_grupo . ')" class="btn btn-danger btn-xs float-right"><i class="fas fa-minus-square"></i> Eliminar</a>
									<a onclick="mostrar(' . $reg[$i]["id_pea_actividades"] . ',' . $reg[$i]["tipo_archivo"] . ')" class="btn btn-warning btn-xs float-right"><i class="fas fa-pen-square "></i> Editar</a>
								</div>


								<div class="col-12">
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
									<small> Publicado: ' . $peadocente->fechaesp($reg[$i]["fecha_actividad"]) . ' - <cite title="Source Title">' . $reg[$i]["hora_actividad"] . '</cite></small>
								</div>
							</div>
						</div>					
					</div>
					
				</div>';
		}
		$data["0"] .= '</div>';
		$results = array($data);
		echo json_encode($results);

		break;

	case "selectTipoArchivo":
		//Vamos a declarar un array
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo

		$rspta = $peadocente->selectTipoArchivo();
		for ($i = 0; $i < count($rspta); $i++) {
			$data["0"] .= '<a class="dropdown-item" onclick="agregaractividad(' . $rspta[$i]["id_tipo_archivo"] . ')" style="cursor:pointer">' . $rspta[$i]["tipo_archivo"] . '</a>';
		}
		$results = array($data);
		echo json_encode($results);

		break;

	case 'mostrar':
		$rspta = $peadocente->mostrar($id_pea_actividades);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);

		break;

	case 'eliminar':
		$id_pea_actividades = $_POST["id_pea_actividades"];
		$tipo_archivo_id = $_POST["tipo"];

		if ($tipo_archivo_id == 1 or $tipo_archivo_id == 2) {
			$rspta2 = $peadocente->mostrar($id_pea_actividades);
			unlink("../files/pea/" . $rspta2['archivo_actividad']);
		}
		$rspta = $peadocente->eliminar($id_pea_actividades, $tipo_archivo_id);


		echo json_encode($rspta);
		break;

	case 'eliminarArchivo':
		$data = array();
		$data["0"] = "";

		$id_pea_documento = $_POST["id_pea_documento"];

		$verpeadocumento = $peadocente->verDatosDocumento($id_pea_documento);
		$archivo_documento = $verpeadocumento["archivo_documento"];
		$ciclo = $verpeadocumento["ciclo"];

		$target_path = '../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento;
		unlink($target_path);

		$rspta = $peadocente->eliminarArchivo($id_pea_documento);
		$resultado = $rspta ? "1" : "2";

		$data["0"] .= $resultado;

		$results = array($data);
		echo json_encode($results);
	break;

	case 'eliminarVideo':
		$data = array();
		$data["0"] = "";

		$id_pea_video = $_POST["id_pea_video"];

		$verpeavideo = $peadocente->datosvideo($id_pea_video);
		$archivo_video = $verpeavideo["archivo_video"];
		$ciclo = $verpeavideo["ciclo"];

		$target_path = '../files/pea/ciclo' . $ciclo . '/videosest/' . $archivo_video;
		unlink($target_path);

		$rspta = $peadocente->eliminarVideo($id_pea_video);
		$resultado = $rspta ? "1" : "2";

		$data["0"] .= $resultado;

		$results = array($data);
		echo json_encode($results);
	break;

	case 'eliminarArchivoLink':
		$data = array();
		$data["0"] = "";

		$id_pea_documento = $_POST["id_pea_documento"];

		$rspta = $peadocente->eliminarArchivo($id_pea_documento);
		$resultado = $rspta ? "1" : "2";

		$data["0"] .= $resultado;

		$results = array($data);
		echo json_encode($results);
		break;

	case 'eliminarEnlace':
		$data = array();
		$data["0"] = "";

		$id_pea_enlaces = $_POST["id_pea_enlaces"];


		$rspta = $peadocente->eliminarEnlace($id_pea_enlaces);
		$resultado = $rspta ? "1" : "2";

		$data["0"] .= $resultado;

		$results = array($data);
		echo json_encode($results);
		break;

	case 'eliminarGlosario':
		$data = array();
		$data["0"] = "";

		$id_pea_glosario = $_POST["id_pea_glosario"];

		$rspta = $peadocente->eliminarGlosario($id_pea_glosario);
		$resultado = $rspta ? "1" : "2";

		$data["0"] .= $resultado;

		$results = array($data);
		echo json_encode($results);
		break;

	case 'editarCarpetaDocumento':
		$id_pea_documento_carpeta = $_POST["id_pea_documento_carpeta"];
		$rspta = $peadocente->editarCarpetaDocumento($id_pea_documento_carpeta);
		echo json_encode($rspta);

		break;

	case 'editarCarpetaEjercicios':
		$id_pea_ejercicios_carpeta = $_POST["id_pea_ejercicios_carpeta"];
		$rspta = $peadocente->mostrarCarpetaEjercicios($id_pea_ejercicios_carpeta);
		echo json_encode($rspta);

		break;

	case 'editarArchivo':
		$id_pea_documento = $_POST["id_pea_documento"];
		$rspta = $peadocente->editarArchivo($id_pea_documento);
		echo json_encode($rspta);

	break;

	case 'editarArchivoEjercicios':
		$id_pea_ejercicios = $_POST["id_pea_ejercicios"];
		$rspta = $peadocente->editarArchivoEjercicios($id_pea_ejercicios);
		echo json_encode($rspta);

		break;

	case 'editarEnlace':

		$id_pea_enlaces = $_POST["id_pea_enlaces"];
		$rspta = $peadocente->editarEnlace($id_pea_enlaces);
		echo json_encode($rspta);

	break;

	case 'editarVideo':

		$id_pea_video = $_POST["id_pea_video"];
		$rspta = $peadocente->editarVideo($id_pea_video);
		echo json_encode($rspta);

	break;

	case 'editarGlosario':
		$id_pea_glosario = $_POST["id_pea_glosario"];
		$rspta = $peadocente->editarGlosario($id_pea_glosario);
		echo json_encode($rspta);

	break;

	case 'verDescargas':
		//Vamos a declarar un array
		$data = array();
		$id_pea_documento = $_GET["id_pea_documento"];

		$verdescargas = $peadocente->descargasDoc($id_pea_documento);
		$reg = $verdescargas;

		for ($i = 0; $i < count($reg); $i++) {
			$verdatosdocumento = $peadocente->verDatosDocumento($id_pea_documento);

			$datosestudiante = $peadocente->datosEstudiante($reg[$i]["id_credencial"]);
			$nombre = $datosestudiante["credencial_nombre"] . ' ' . $datosestudiante["credencial_nombre_2"] . ' ' . $datosestudiante["credencial_apellido"] . ' ' . $datosestudiante["credencial_apellido_2"];
			$correo = $datosestudiante["credencial_login"];
			$identificacion = $datosestudiante["credencial_identificacion"];
			$fecha = $peadocente->fechaesp($reg[$i]["fecha"]);
			$data[] = array(
				"0" => $identificacion,
				"1" => $nombre,
				"2" => $correo,
				"3" => $verdatosdocumento["nombre_documento"],
				"4" => $fecha,
				"5" => $reg[$i]["hora"],
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

	case 'glosario':
		//Vamos a declarar un array
		$data = array();
		$id_pea_docente = $_GET["id_pea_docente"];

		$verglosario = $peadocente->verGlosario($id_pea_docente);
		$reg = $verglosario;

		for ($i = 0; $i < count($reg); $i++) {

			$id_pea_glosario = $reg[$i]["id_pea_glosario"];
			$titulo = $reg[$i]["titulo_glosario"];
			$definicion_glosario = $reg[$i]["definicion_glosario"];
			$fecha_glosario = $reg[$i]["fecha_glosario"];
			$hora_glosario = $reg[$i]["hora_glosario"];

			$fecha = $peadocente->fechaesp($fecha_glosario);
			$data[] = array(
				"0" => '<a onclick="eliminarGlosario(' . $id_pea_glosario . ',' . $id_pea_docente . ')" title="Eliminar Documento" style="cursor:pointer"><i class="fas fa-trash-alt text-danger"></i></a>
				<a onclick="editarGlosario(' . $id_pea_glosario . ',' . $id_pea_docente . ')" title="Editar Enlace" style="cursor:pointer"><i class="fas fa-edit text-warning"></i></a>',
				"1" => $titulo,
				"2" => $definicion_glosario,
				"3" => $fecha,
				"4" => $hora_glosario,
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

	case 'glosarioCabecera':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";

		$id_pea_docente = $_POST["id_pea_docente"];


		$data["0"] .= '<div class="row">';

		$data["0"] .= '
			<div class="col-12 text-right">
				<a href="docentegrupos.php" class="btn btn-link btn-sm">listado de grupos</a>/ 
				<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
				/ Glosario
			</div>';

		$data["0"] .= '
			<div class="col-12 mb-4 border-bottom pb-3">
				<a onclick="crearGlosario(' . $id_pea_docente . ')" class="btn btn-default btn-sm "> <i class="fas fa-book-reader text-danger"></i> Agregar  </a>
			</div>';


		$data["0"] .= '</div>';


		$results = array($data);
		echo json_encode($results);

		break;

	case 'listarCalificar':

		//Vamos a declarar un array
		$data = array();

		$id_docente_grupo = $_GET["id_docente_grupo"];
		$id_pea_ejercicios = $_GET["id_pea_ejercicios"];
		//listar todos los grupos que 
		$listarelgrupo = $peadocente->listarelgrupo($id_docente_grupo);
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
		$datosmateriaciafi = $peadocente->materiaDatos($id_materia); // consuta pra traer los datos de la materia
		$materia = $datosmateriaciafi["nombre"]; // nombre de la materia
		$rspta = $peadocente->listarCalificar($ciclo, $materia, $jornada, $id_programa, $grupo);
		$reg = $rspta;
		$traerdatospeaejercicios = $peadocente->editarArchivoEjercicios($id_pea_ejercicios);
		$id_pea_ejercicios = $traerdatospeaejercicios["id_pea_ejercicios"];
		$nombre_ejercicios = $traerdatospeaejercicios["nombre_ejercicios"];

		for ($i = 0; $i < count($reg); $i++) {
			$id_estudiante = $reg[$i]["id_estudiante"];
			$rspta3 = $peadocente->id_estudiante($id_estudiante);
			$id_credencial = $rspta3["id_credencial"];
			$rspta4 = $peadocente->estudiante_datos($id_credencial);
			$nombre = $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' ' . $rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"];
			$credencial_login = $rspta4["credencial_login"];
			if (file_exists('../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg')) {
				$foto = '<img src=../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg width=30px height=30px class=rounded-circle>';
			} else {
				$foto = '<img src=../files/null.jpg width=30px height=30px class=rounded-circle>';
			}
			$traerejercicio = $peadocente->traerejercicio($id_pea_ejercicios, $id_estudiante);
			$resultadotraerejercicio = $traerejercicio ? "1" : "2";
			if ($resultadotraerejercicio == 1) {
				$id_pea_ejercicios_est = $traerejercicio["id_pea_ejercicios_est"];
				$archivo_ejercicios = $traerejercicio["archivo_ejercicios"];
				$nota_ejercicios = $traerejercicio["nota_ejercicios"];
				$linkarchivo = "../files/pea/ciclo" . $ciclo . "/ejerciciosest/" . $archivo_ejercicios;
				$linkdescarga = '<a href="' . $linkarchivo . '" target="_blank" title="Descargar" class="btn btn-success btn-xs"><i class="fas fa-eye"></i> Ver</a>';
				$eliminararchivo = '<a onclick=borrararchivo(' . $id_pea_ejercicios_est . ',`'.$nombre_ejercicios.'`,`'.$credencial_login
				.'`) title="Eliminar archivo" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i>Borrar</a>';
				$fecha_enviado = $peadocente->fechaesp($traerejercicio["fecha_enviado"]);
				$hora_enviado = $traerejercicio["hora_enviado"];
				$calificar = '<input type="number" id="nota_' . $id_pea_ejercicios_est . '" name="nota_' . $id_pea_ejercicios_est . '" onchange="calificarTaller(' . $id_pea_ejercicios_est . ')" min="0" max="5"  value="' . $nota_ejercicios . '" class="form-control" ></input>';
			} else {
				$archivo_ejercicios = "";
				$linkarchivo = "";
				$linkdescarga = '';
				$eliminararchivo = "";
				$fecha_enviado = '';
				$hora_enviado = '';
				$calificar = "";
			}
			$data[] = array(
				"0" => $foto,
				"1" => $rspta4["credencial_identificacion"],
				"2" => strtoupper($nombre),
				"3" => $linkdescarga . ' ' . $eliminararchivo,
				"4" => $fecha_enviado,
				"5" => $calificar,

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

	case 'calificarTaller':
		$data = array();
		$data["0"] = "";

		$id_pea_ejercicios_est = $_POST["id_pea_ejercicios_est"];
		$nota = $_POST["nota"];
		if ($nota >= 0 and $nota <= 5) {
			$rspta = $peadocente->calificarTaller($id_pea_ejercicios_est, $nota);
			$resultado = $rspta ? "1" : "2";
		} else {
			$resultado = "3";
		}
		$data["0"] .= $resultado;

		$results = array($data);
		echo json_encode($results);
		break;

	case 'listarCalificarCompletoPrueba':

		//Vamos a declarar un array
		$data = array();
		$id_docente_grupo = $_GET["id_docente_grupo"];
		$id_pea_ejercicios_carpeta = $_GET["id_pea_ejercicios_carpeta"];
		$id_pea_ejercicios = '';
		//listar todos los grupos que 
		$listarelgrupo = $peadocente->listarelgrupo($id_docente_grupo);
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

		$datosmateriaciafi = $peadocente->materiaDatos($id_materia); // consuta pra traer los datos de la materia
		$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

		$rspta = $peadocente->listarCalificar($ciclo, $materia, $jornada, $id_programa, $grupo);
		$reg = $rspta;

		// $traerdatospeaejercicios=$peadocente->editarArchivoEjercicios($id_pea_ejercicios);
		// $id_pea_ejercicios=$traerdatospeaejercicios["id_pea_ejercicios"];
		// $nombre_ejercicios=$traerdatospeaejercicios["nombre_ejercicios"];

		for ($i = 0; $i < count($reg); $i++) {
			$id_estudiante = $reg[$i]["id_estudiante"];
			$rspta3 = $peadocente->id_estudiante($id_estudiante);
			$id_credencial = $rspta3["id_credencial"];
			$rspta4 = $peadocente->estudiante_datos($id_credencial);
			$nombre = $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' ' . $rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"];

			if (file_exists('../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg')) {
				$foto = '<img src=../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg width=30px height=30px class=rounded-circle>';
			} else {
				$foto = '<img src=../files/null.jpg width=30px height=30px class=rounded-circle>';
			}

			// $traerejercicio=$peadocente->traerejercicio($id_pea_ejercicios,$id_estudiante);
			// $resultadotraerejercicio= $traerejercicio ? "1" : "2";
			// if($resultadotraerejercicio==1){
			// 	$id_pea_ejercicios_est =$traerejercicio["id_pea_ejercicios_est"];
			// 	$archivo_ejercicios=$traerejercicio["archivo_ejercicios"];
			// 	$nota_ejercicios=$traerejercicio["nota_ejercicios"];

			// 	$linkarchivo="../files/pea/ciclo".$ciclo."/ejerciciosest/".$archivo_ejercicios;
			// 	$linkdescarga='<a href="'.$linkarchivo.'" target="_blank" title="Descargar" class="btn btn-success btn-xs"><i class="fas fa-eye"></i> Ver</a>';
			// 	$fecha_enviado=$peadocente->fechaesp($traerejercicio["fecha_enviado"]);
			// 	$hora_enviado=$traerejercicio["hora_enviado"];
			// 	$calificar='<input type="number" id="nota_'.$id_pea_ejercicios_est.'" name="nota_'.$id_pea_ejercicios_est.'" onchange="calificarTaller('.$id_pea_ejercicios_est.')" min="0" max="5"  value="'.$nota_ejercicios.'" class="form-control" ></input>';



			// }else{
			// 	$archivo_ejercicios="";
			// 	$linkarchivo="";
			// 	$linkdescarga='';
			// 	$fecha_enviado='';
			// 	$hora_enviado='';
			// 	$calificar="";
			// }


			$data[] = array(
				"0" => $foto,
				"1" => $rspta4["credencial_identificacion"],
				"2" => strtoupper($nombre),
				"3" => '$linkdescarga',
				"4" => '$fecha_enviado',
				"5" => '$calificar',

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

	case 'listarCalificarCompleto':

		//Vamos a declarar un array
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo

		$id_docente_grupo = $_GET["id_docente_grupo"];
		$id_pea_ejercicios_carpeta = $_GET["id_pea_ejercicios_carpeta"];
		//listar todos los grupos que 
		$listarelgrupo = $peadocente->listarelgrupo($id_docente_grupo);
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

		$datosmateriaciafi = $peadocente->materiaDatos($id_materia); // consuta pra traer los datos de la materia
		$materia = $datosmateriaciafi["nombre"]; // nombre de la materia

		$rspta = $peadocente->listarCalificar($ciclo, $materia, $jornada, $id_programa, $grupo);
		$reg = $rspta;

		$traerejercicios = $peadocente->verPeaDocumentosEjercicios($id_pea_ejercicios_carpeta);

		$data["0"] .= '<thead>';
		$data["0"] .= '<th>Foto</th>';
		$data["0"] .= '<th>Identificación</th>';
		$data["0"] .= '<th>Nombre completo</th>';

		for ($a = 0; $a < count($traerejercicios); $a++) {
			$data["0"] .= '<th>' . $traerejercicios[$a]["nombre_ejercicios"] . '</th>';
		}

		$data["0"] .= '</thead>';

		$data["0"] .= '<tbody';
		for ($i = 0; $i < count($reg); $i++) {

			$id_estudiante = $reg[$i]["id_estudiante"];
			$rspta3 = $peadocente->id_estudiante($id_estudiante);
			$id_credencial = $rspta3["id_credencial"];
			$rspta4 = $peadocente->estudiante_datos($id_credencial);
			$nombre = $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' ' . $rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"];

			if (file_exists('../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg')) {
				$foto = '<img src=../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg width=30px height=30px class=rounded-circle>';
			} else {
				$foto = '<img src=../files/null.jpg width=30px height=30px class=rounded-circle>';
			}
			$data["0"] .= '<tr>';
			$data["0"] .= '<td>' . $foto . '</td>';
			$data["0"] .= '<td>' . $rspta4["credencial_identificacion"] . '</td>';
			$data["0"] .= '<td>' . strtoupper($nombre) . '</td>';

			for ($b = 0; $b < count($traerejercicios); $b++) {
				$id_pea_ejercicios = $traerejercicios[$b]["id_pea_ejercicios"];

				$traerejercicio = $peadocente->traerejercicio($id_pea_ejercicios, $id_estudiante);
				$resultadotraerejercicio = $traerejercicio ? "1" : "2";

				if ($resultadotraerejercicio == 1) {
					$id_pea_ejercicios_est = $traerejercicio["id_pea_ejercicios_est"];
					$archivo_ejercicios = $traerejercicio["archivo_ejercicios"];
					$nota_ejercicios = $traerejercicio["nota_ejercicios"];

					$linkarchivo = "../files/pea/ciclo" . $ciclo . "/ejerciciosest/" . $archivo_ejercicios;
					$linkdescarga = '<a href="' . $linkarchivo . '" target="_blank" title="Descargar" class="btn btn-xs float-left"><i class="fas fa-eye text-successs"></i></a>';
					$fecha_enviado = $peadocente->fechaesp($traerejercicio["fecha_enviado"]);
					$hora_enviado = $traerejercicio["hora_enviado"];
					$calificar = '<input type="number" id="nota_' . $id_pea_ejercicios_est . '" name="nota_' . $id_pea_ejercicios_est . '" onchange="calificarTaller(' . $id_pea_ejercicios_est . ')" min="0" max="5"  value="' . $nota_ejercicios . '"  style="width:50px"></input>';
				} else {
					$archivo_ejercicios = "";
					$linkarchivo = "";
					$linkdescarga = '';
					$fecha_enviado = '';
					$hora_enviado = '';
					$calificar = "";
				}
				$data["0"] .= '<td>' . $linkdescarga . ' ' . $calificar . '</td>';
			}


			$data["0"] .= '</tr>';
		}
		$data["0"] .= '</tbody>';



		$results = array($data);
		echo json_encode($results);

		break;

	case 'borrararchivo':
		$data = array();
		$data["0"] = "";
		$nombre_ejercicios = $_POST["nombre_ejercicios"];
		$id_pea_ejercicios_est = $_POST["id_pea_ejercicios_est"];
		$credencial_login = $_POST["credencial_login"];
		$verpeadocumentoest = $peadocente->traerejercicioparaeliminar($id_pea_ejercicios_est);
		$archivo_documento = $verpeadocumentoest["archivo_ejercicios"];
		$ciclo = $verpeadocumentoest["ciclo"];
		$target_path = '../files/pea/ciclo' . $ciclo . '/ejerciciosest/' . $archivo_documento;
		unlink($target_path);
		$rspta = $peadocente->eliminarArchivoEstudiante($id_pea_ejercicios_est);
		$resultado = $rspta ? "1" : "2";
		$data["0"] .= $resultado;
		//template para enviar el correo al estudiante de que se elimino el taller
		$template = set_template_elimina_taller($nombre_ejercicios);
		// correo de docente
		$destino = $credencial_login;
		$asunto = "Taller eliminado";
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
		$results = array($data);
		echo json_encode($results);
		break;

	case 'validartema':
		$data = [];
		$data["data1"] = "";
		$data["opciones"]="";

		$id_pea = $_POST["id_pea"];
		$id_tema = $_POST["id_tema"];
		$id_pea_docente = $_POST["id_pea_docente"];

		$ciclo = $_POST["ciclo"];
		$id_materia= $_POST["id_materia"];
		$id_programa =$_POST["id_programa"];
		

				/* consulta para teaer las carpetas */

			$rspta = $peadocente->validarsiexistema($ciclo,$id_pea,$id_pea_docente,$id_tema); //Consulta para ver si hay tema 
			if (!$rspta) {
				// No existe el registro, entonces lo insertamos
				$insertado = $peadocente->insertarTema($ciclo,$id_materia, $id_programa, $id_pea, $id_pea_docente, $id_tema);
				$data["data1"] .= $mensaje = $insertado ? "1" : "2";
			}

		echo json_encode($data);
		break;

	case 'agregarrecurso':
		$data = [];
		$data["data1"] = "";
		$data["opciones"]="";

		$id_pea = $_POST["id_pea"];
		$id_tema = $_POST["id_tema"];
		$id_pea_docente = $_POST["id_pea_docente"];

		$ciclo = $_POST["ciclo"];
		$id_materia= $_POST["id_materia"];
		$id_programa =$_POST["id_programa"];
		


				$data["data1"] .= $mensaje = "3";

					$data["opciones"] .= '
					<div class="row p-0 m-0">
						<div class="col-12  p-2  mb-2">
							<a class="btn btn-app tono-3 titulo-2" onclick="archivo('.$ciclo.',1,' . $id_pea_docente . ','.$id_tema.','.$id_materia.', '.$id_programa.')" title="Imagen, jpg, png">
								<i class="fas fa-file-image text-info fa-2x"></i> Imagen
							</a>
							<a class="btn btn-app tono-3 titulo-2" onclick="archivo('.$ciclo.',2,' . $id_pea_docente . ','.$id_tema.','.$id_materia.', '.$id_programa.')" title="Documento en WORD">
								<i class="fas fa-file-word fa-2x text-primary"></i> Word
							</a>
							<a class="btn btn-app tono-3 titulo-2" onclick="archivo('.$ciclo.',3,' . $id_pea_docente . ','.$id_tema.','.$id_materia.', '.$id_programa.')" title="Documento en Excel">
								<i class="fas fa-file-excel fa-2x text-success"></i> Excel
							</a>
							<a class="btn btn-app tono-3 titulo-2" onclick="archivo('.$ciclo.',4,' . $id_pea_docente . ','.$id_tema.','.$id_materia.', '.$id_programa.')" title="Documento en PowerPoint">
								<i class="fas fa-file-powerpoint fa-2x text-pink"></i> PowerPoint
							</a>
							<a class="btn btn-app tono-3 titulo-2" onclick="archivo('.$ciclo.',5,' . $id_pea_docente . ','.$id_tema.','.$id_materia.', '.$id_programa.')" title="Documento en PDF">
								<i class="fas fa-file-pdf fa-2x text-danger"></i> PDF
							</a>
							<a class="btn btn-app tono-3 titulo-2" onclick="archivo('.$ciclo.',6,' . $id_pea_docente . ','.$id_tema.','.$id_materia.', '.$id_programa.')" title="Docuemento en RAR">
								<i class="fas fa-file-archive fa-2x text-orange"></i> WinRAR
							</a>
							<a class="btn btn-app tono-3 titulo-2" disabled onclick="archivovideo('.$ciclo.',7,'.$id_pea_docente.','.$id_tema.','.$id_materia.','.$id_programa.')" title="Link del VIDEO">
								<i class="fas fa-file-video fa-2x text-danger"></i> Video
							</a>
							<a class="btn btn-app tono-3 titulo-2 disabled" onclick="archivolink('.$ciclo.',8,' . $id_pea_docente . ','.$id_tema.','.$id_materia.', '.$id_programa.')" title="Inscrustar Video">
								<i class="fab fa-google-drive fa-2x text-primary"></i> DRIVE
							</a>

							<a class="btn btn-app tono-3 titulo-2" onclick="crearEnlace('.$ciclo.',' . $id_pea_docente . ','.$id_tema.','.$id_materia.', '.$id_programa.')" title="Cargar un link">
								<i class="fa-solid fa-link"></i> <br>URL
							</a>

							<a class="btn btn-app tono-3 titulo-2" onclick="crearGlosario('.$ciclo.',' . $id_pea_docente . ','.$id_tema.','.$id_materia.', '.$id_programa.')" title="Palabras claves">
								<i class="fas fa-book-reader text-danger"></i>Glosario
							</a>

							<a class="btn btn-app tono-3 titulo-2 disabled" onclick="crearConsulta(' . $id_pea_docente . ','.$id_tema.')" title="Test o consulta rapida">
								<i class="fa-solid fa-code-branch"></i><br>Consulta
							</a>
							
							
						</div>
						
						<div class="col-6 p-2 borde mb-2 d-none">
							<div class="text-white">Publicar un ejercicio</div>
							<a onclick="archivoEjercicios(1,' . $id_pea_docente . ','.$id_tema.')" title="Imagen, jpg, png" class="btn m-0 p-0"><i class="fas fa-file-image text-info fa-2x"></i></a>
							<a onclick="archivoEjercicios(2,' . $id_pea_docente . ','.$id_tema.')" title="Documento en WORD" class="btn m-0 p-0"><i class="fas fa-file-word fa-2x text-primary"></i></a>
							<a onclick="archivoEjercicios(3,' . $id_pea_docente . ','.$id_tema.')" title="Documento en Excel" class="btn m-0 p-0"><i class="fas fa-file-excel fa-2x text-success"></i></a>
							<a onclick="archivoEjercicios(4,' . $id_pea_docente . ','.$id_tema.')" title="Documento en PowerPoint" class="btn m-0 p-0"><i class="fas fa-file-powerpoint fa-2x text-pink"></i></a>
							<a onclick="archivoEjercicios(5,' . $id_pea_docente . ','.$id_tema.')" title="Documento en PDF" class="btn m-0 p-0"><i class="fas fa-file-pdf fa-2x text-danger"></i></a>
							<a onclick="archivoEjercicios(6,' . $id_pea_docente . ','.$id_tema.')" title="Docuemento en RAR" class="btn m-0 p-0"><i class="fas fa-file-archive fa-2x text-orange"></i></a>
							<a onclick="archivoEjercicios(7,' . $id_pea_docente . ','.$id_tema.')" title="Link video YOUTUBE" class="btn m-0 p-0"><i class="fas fa-file-video fa-2x text-danger"></i></a>
							<a onclick="archivoEjercicios(8,' . $id_pea_docente . ','.$id_tema.')" title="Link de DRIVE" class="btn m-0 p-0"><i class="fab fa-google-drive fa-2x text-primary"></i></a>
							<a onclick="archivoEjercicios(9,' . $id_pea_docente . ','.$id_tema.')" title="Link WEB" class="btn m-0 p-0"><i class="fas fa-link fa-2x text-indigo"></i></a>
						</div>

							

					</div>';

					$documentos = $peadocente->verPeaDocumentos($id_pea_docente, $id_tema);
					foreach ($documentos as &$documento) {
						$documento['tipo'] = 'documento';
						$documento['fecha_completa'] = $documento['fecha_actividad'] . ' ' . $documento['hora_actividad'];
					}

					// Obtener enlaces y glosario
					$enlaces = $peadocente->verEnlacesTema($id_pea_docente, $id_tema);
					foreach ($enlaces as &$enlace) {
						$enlace['tipo'] = 'enlace';
						$enlace['fecha_completa'] = $enlace['fecha_enlace'] . ' ' . $enlace['hora_enlace'];
					}

					$glosarios = $peadocente->verGlosarioTema($id_pea_docente, $id_tema);
					foreach ($glosarios as &$glosario) {
						$glosario['tipo'] = 'glosario';
						$glosario['fecha_completa'] = $glosario['fecha_glosario'] . ' ' . $glosario['hora_glosario'];
					}

					$videos = $peadocente->verVideosTema($id_pea_docente, $id_tema);
					foreach ($videos as &$video) {
						$video['tipo'] = 'video';
						$video['fecha_completa'] = $video['fecha_video'] . ' ' . $video['hora_video'];
					}

					// Mezclar y ordenar todos los recursos
					$recursos = array_merge($documentos, $enlaces, $glosarios, $videos);
					usort($recursos, function($a, $b) {
						return strtotime($a['fecha_completa']) - strtotime($b['fecha_completa']);
					});

					// Construcción HTML
					$mifila=1;
					

					foreach ($recursos as $recurso) {

						if ($recurso['tipo'] === 'documento') {

							$tipo_archivo=$recurso["tipo_archivo"];

							switch ($tipo_archivo) {
								case '1':
									$documento_tipo = '<i class="fas fa-file-image text-info fa-2x"></i>';
									$btneliminar = '<a class="dropdown-item" onclick="eliminarArchivo(' . $recurso["id_pea_documento"] . ','.$mifila.')" title="Eliminar Documento" style="cursor:pointer">Eliminar</a>';
									$btneditar = '<a class="dropdown-item" onclick="editarArchivo(' . $recurso["id_pea_documento"] . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer">Editar</a>';
									$linkdescarga = '<a class="dropdown-item" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $recurso["archivo_documento"] . '" target="_blank" class="btn bg-orange btn-xs text-white"> Material</a>';
									break;
								case '2':
									$documento_tipo = '<i class="fas fa-file-word fa-2x text-primary"></i>';
									$btneliminar = '<a class="dropdown-item" onclick="eliminarArchivo(' . $recurso["id_pea_documento"] . ','.$mifila.')" title="Eliminar Documento" style="cursor:pointer">Eliminar</a>';
									$btneditar = '<a class="dropdown-item" onclick="editarArchivo(' . $recurso["id_pea_documento"] . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer">Editar</a>';
									$linkdescarga = '<a class="dropdown-item" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $recurso["archivo_documento"] . '" target="_blank" class="btn bg-orange btn-xs text-white"> Material</a>';
									break;
								case '3':
									$documento_tipo = '<i class="fas fa-file-excel fa-2x text-success"></i>';
									$btneliminar = '<a class="dropdown-item" onclick="eliminarArchivo(' . $recurso["id_pea_documento"] . ','.$mifila.')" title="Eliminar Documento" style="cursor:pointer">Eliminar</a>';
									$btneditar = '<a class="dropdown-item" onclick="editarArchivo(' . $recurso["id_pea_documento"] . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer">Editar</a>';
									$linkdescarga = '<a class="dropdown-item" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $recurso["archivo_documento"] . '" target="_blank" class="btn bg-orange btn-sm text-white"> Material</a>';
									break;
								case '4':
									$documento_tipo = '<i class="fas fa-file-powerpoint fa-2x text-pink"></i>';
									$btneliminar = '<a class="dropdown-item" onclick="eliminarArchivo(' . $recurso["id_pea_documento"] . ','.$mifila.')" title="Eliminar Documento" style="cursor:pointer">Eliminar</a>';
									$btneditar = '<a class="dropdown-item" onclick="editarArchivo(' . $recurso["id_pea_documento"] . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer">Editar</a>';
									$linkdescarga = '<a class="dropdown-item" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $recurso["archivo_documento"] . '" target="_blank" class="btn bg-orange btn-sm text-white"> Material</a>';
									break;
								case '5':
									$documento_tipo = '<i class="fas fa-file-pdf fa-2x text-danger"></i>';
									$btneliminar = '<a class="dropdown-item"onclick="eliminarArchivo(' . $recurso["id_pea_documento"] . ','.$mifila.')" title="Eliminar Documento" style="cursor:pointer">Eliminar</a>';
									$btneditar = '<a class="dropdown-item" onclick="editarArchivo(' . $recurso["id_pea_documento"] . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer">Editar</a>';
									$linkdescarga = '<a class="dropdown-item" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $recurso["archivo_documento"] . '" target="_blank" class="btn bg-orange btn-sm text-white"> Material</a>';
									break;
								case '6':
									$documento_tipo = '<i class="fas fa-file-archive fa-2x text-orange"></i>';
									$btneliminar = '<a class="dropdown-item" onclick="eliminarArchivo(' . $recurso["id_pea_documento"] . ','.$mifila.')" title="Eliminar Documento" style="cursor:pointer">Eliminar</a>';
									$btneditar = '<a class="dropdown-item" onclick="editarArchivo(' . $recurso["id_pea_documento"] . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer">Editar</a>';
									$linkdescarga = '<a class="dropdown-item" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $recurso["archivo_documento"] . '" target="_blank" class="btn bg-orange btn-sm text-white"> Material</a>';
									break;
								case '7':
									$documento_tipo = '<i class="fas fa-file-video fa-2x text-danger"></i>';
									$btneliminar = '<a class="dropdown-item" onclick="eliminarArchivoLink(' . $recurso["id_pea_documento"] . ','.$mifila.')" title="Eliminar Documento" style="cursor:pointer">Eliminar</a>';
									$btneditar = '<a class="dropdown-item" onclick="editarArchivoLink(' . $recurso["id_pea_documento"] . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer">Editar</a>';
									$linkdescarga = '<a class="dropdown-item" href="' . $recurso["archivo_documento"] . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
									break;
								case '8':
									$documento_tipo = '<i class="fab fa-google-drive fa-2x text-primary"></i>';
									$btneliminar = '<a class="dropdown-item" onclick="eliminarArchivoLink(' . $recurso["id_pea_documento"] . ','.$mifila.')" title="Eliminar Documento" style="cursor:pointer">Eliminar</a>';
									$btneditar = '<a class="dropdown-item" onclick="editarArchivoLink(' . $recurso["id_pea_documento"] . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer">Editar</a>';
									$linkdescarga = '<a class="dropdown-item" href="' . $recurso["archivo_documento"] . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
									break;
								case '9':
									$documento_tipo = '<i class="fas fa-link fa-2x text-indigo"></i>';
									$btneliminar = '<a class="dropdown-item" onclick="eliminarArchivoLink(' . $recurso["id_pea_documento"] . ','.$mifila.')" title="Eliminar Documento" style="cursor:pointer">Eliminar</a>';
									$btneditar = '<a class="dropdown-item" onclick="editarArchivoLink(' . $recurso["id_pea_documento"]  . ',' . $id_pea_docente . ')" title="Editar Documento" style="cursor:pointer">Editar</a>';
									$linkdescarga = '<a class="dropdown-item" href="' . $recurso["archivo_documento"] . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
									break;
							}

							switch ($recurso["condicion_finalizacion_documento"]) {
								case 1:
									$texto_condicion_documento = "No";
									break;
								case 2:
									$texto_condicion_documento = "Estudiante marca";
									break;
								case 3:
									$texto_condicion_documento = "subir archivo";
									break;
								default:
									$texto_condicion_documento = "desconocido";
							}

							switch ($recurso["tipo_condicion_documento"]) {
								case 0:
									$texto_tipo_documento = "nada";
									break;
								case 1:
									$texto_tipo_documento = "Archivo";
									break;
								case 2:
									$texto_tipo_documento = "Link evidencia";
									break;
								case 3:
									$texto_tipo_documento = "mensaje";
									break;
								default:
									$texto_tipo_documento = "desconocido";
							}

				
							if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_documento"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_documento"])) {
								$terminodocumento="no";
							}else{
								$terminodocumento="si";
							}
							
							// $descargasdoc = $peadocente->descargasDoc($id_pea_documento);
							// $totaldescargas = count($descargasdoc);

							
							$data["opciones"] .= '

							<div class="col-12 my-2 py-2 border-bottom" id="mifila'.$mifila.'">
								<div class="row justify-content-center align-items-center">
									<div class="col-1">
									' . $documento_tipo . '
									</div>
									<div class="col-11">
										<div class="row">
											<div class="col-12">
												<div class="row">
													<div class="col-auto" >
														<button class="btn btn-sm dropdown-toggle semibold titulo-2 fs-12 p-0 m-0" type="button" data-toggle="dropdown" aria-expanded="false">
															<i class="fa-solid fa-ellipsis-vertical"></i>
														</button>
														<div class="dropdown-menu" >
															<a class="dropdown-item" onclick="informacionDoc(' . $recurso["id_pea_documento"] . ')">Abrir detalles</a>
															' . $linkdescarga . '
															' . $btneditar . '
															' . $btneliminar . '
														</div>
													</div>
													<div class="col-10">
														' . htmlspecialchars($recurso["nombre_documento"]) . '
													</div>
												</div>
											</div>';

											if(strtotime($fecha) < strtotime($recurso["fecha_inicio_documento"])){

													$data["opciones"] .= '
													<div class="col-12">
														<div class="row">
															
															<div class="col-4">
																<span>Inicia: ' . $peadocente->fechaespsinano($recurso["fecha_inicio_documento"]) . '</span><br>
																<span>Hasta: ' . $peadocente->fechaespsinano($recurso["fecha_limite_documento"]) . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Condición</span><br>
																<span>' . $texto_condicion_documento . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Entrega</span><br>
																<span>' . $texto_tipo_documento . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Porcentaje</span><br>
																<span>' . $recurso["porcentaje_documento"] . '%</span>
															</div>
															<div class="col-2 text-center">	
																<span>Otorga</span><br>
																<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
																<span>' . $recurso["puntos_actividad_documento"] . ' Pts.</span>
															</div>
															</div>
															<div class="col-12 titulo-2 fs-10 mx-0 px-0">Publicado '.$peadocente->fechaesp($recurso["fecha_actividad"]).'</div>
														</div>
													</div>';


												$data["opciones"] .= '<div class="col-12 fs-18 text-success"><i class="fa-solid fa-hourglass-half"></i> Proximamente</div>';
											}else{

												if($terminodocumento=="no"){
														$data["opciones"] .= '
													<div class="col-12">
														<div class="row">
															
															<div class="col-4">
																<span>De: ' . $peadocente->fechaespsinano($recurso["fecha_inicio_documento"]) . '</span><br>
																<span>Hasta: ' . $peadocente->fechaespsinano($recurso["fecha_limite_documento"]) . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Condición</span><br>
																<span>' . $texto_condicion_documento . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Entrega</span><br>
																<span>' . $texto_tipo_documento . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Porcentaje</span><br>
																<span>' . $recurso["porcentaje_documento"] . '%</span>
															</div>
															<div class="col-2 text-center">	
																<span>Otorga</span><br>
																<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
																<span>' . $recurso["puntos_actividad_documento"] . ' Pts.</span>
															</div>
															</div>
															<div class="col-12 titulo-2 fs-10 mx-0 px-0">Publicado '.$peadocente->fechaesp($recurso["fecha_actividad"]).'</div>
														</div>
													</div>';
												}else{

														$data["opciones"] .= '
													<div class="col-12">
														<div class="row">
															
															<div class="col-4">
																<span>Inicio: ' . $peadocente->fechaespsinano($recurso["fecha_inicio_documento"]) . '</span><br>
																<span>Cerro: <i class="fa-solid fa-lock text-danger"></i> ' . $peadocente->fechaespsinano($recurso["fecha_limite_documento"]) . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Condición</span><br>
																<span>' . $texto_condicion_documento . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Entrega</span><br>
																<span>' . $texto_tipo_documento . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Porcentaje</span><br>
																<span>' . $recurso["porcentaje_documento"] . '%</span>
															</div>
															<div class="col-2 text-center">	
																<span>Otorga</span><br>
																<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
																<span>' . $recurso["puntos_actividad_documento"] . ' Pts.</span>
															</div>
															</div>
															<div class="col-12 titulo-2 fs-10 mx-0 px-0">Publicado '.$peadocente->fechaesp($recurso["fecha_actividad"]).'</div>
														</div>
													</div>';
												}

											}

											$data["opciones"] .= '
										</div>
									</div>

								</div>
							</div>';
							$mifila++;
						}
						elseif ($recurso['tipo'] === 'enlace') {

							switch ($recurso["condicion_finalizacion_enlace"]) {
								case 1:
									$texto_condicion = "No";
									break;
								case 2:
									$texto_condicion = "Estudiante marca";
									break;
								case 3:
									$texto_condicion = "subir archivo";
									break;
								default:
									$texto_condicion = "desconocido";
							}

							switch ($recurso["tipo_condicion_enlace"]) {
								case 0:
									$texto_tipo = "nada";
									break;
								case 1:
									$texto_tipo = "Archivo";
									break;
								case 2:
									$texto_tipo = "Link evidencia";
									break;
								case 3:
									$texto_tipo = "mensaje";
									break;
								default:
									$texto_tipo = "desconocido";
							}


							if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_enlace"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_enlace"])) {
								$terminoenlace="no";
							}else{
								$terminoenlace="si";
							}

								$data["opciones"] .= '
							<div class="col-12 my-2 py-2 border-bottom" id="mifila'.$mifila.'">
								<div class="row justify-content-center align-items-center">
									<div class="col-1">
										<i class="fa-solid fa-link fa-2x"></i></i>
									</div>
									<div class="col-11">
										<div class="row">
											<div class="col-12">
												<div class="row">
													<div class="dropdown" style="width:20px">
														<button class="btn btn-sm dropdown-toggle semibold titulo-2 fs-12 p-0 m-0" type="button" data-toggle="dropdown" aria-expanded="false">
															<i class="fa-solid fa-ellipsis-vertical"></i>
														</button>
														<div class="dropdown-menu" style="">
															<a class="dropdown-item" onclick="informacionEnlace('.$recurso["id_pea_enlaces"].')">Abrir detalles</a>
															<a class="dropdown-item" href="' . htmlspecialchars($recurso["enlace"]) . '" target="_blank">Material</a>
															<a class="dropdown-item" onclick="editarEnlace(' . $recurso["id_pea_enlaces"] . ',' . $id_pea_docente . ')">Editar</a>
															<a class="dropdown-item" onclick="eliminarEnlace(' . $recurso["id_pea_enlaces"] . ','.$mifila.')">Eliminar </a>
														</div>
													</div>
													<div class="col-10">
														<span class="text-semibold">' . htmlspecialchars($recurso["titulo_enlace"]) . '</span>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="row">';
												if(strtotime($fecha) < strtotime($recurso["fecha_inicio_enlace"])){
														$data["opciones"] .= '
													<div class="col-4">
														<span>Inicia: ' . $peadocente->fechaespsinano($recurso["fecha_inicio_enlace"]) . '</span><br>
														<span>Hasta: ' . $peadocente->fechaespsinano($recurso["fecha_limite_enlace"]) . '</span>
														<div class="col-12 fs-18 text-success"><i class="fa-solid fa-hourglass-half"></i> Proximamente...</div>
													</div>
													<div class="col-2 text-center">	
														<span>Condición</span><br>
														<span>' . $texto_condicion . '</span>
													</div>
													<div class="col-2 text-center">	
														<span>Entrega</span><br>
														<span>' . $texto_tipo . '</span>
													</div>
													<div class="col-2 text-center">	
														<span>Porcentaje</span><br>
														<span>' . $recurso["porcentaje_enlace"] . '%</span>
													</div>
													<div class="col-2 text-center">	
														<span>Otorga</span><br>
														<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
														<span>' . $recurso["puntos_actividad_enlace"] . ' Pts.</span>
													</div>
													<div class="col-12 titulo-2 fs-10 mx-0 px-0">Publicado '.$peadocente->fechaesp($recurso["fecha_enlace"]).'</div>';

												}else{

													if($terminoenlace=="no"){

															$data["opciones"] .= '
														<div class="col-4">
															<span>De: ' . $peadocente->fechaespsinano($recurso["fecha_inicio_enlace"]) . '</span><br>
															<span>Hasta: ' . $peadocente->fechaespsinano($recurso["fecha_limite_enlace"]) . '</span>
														</div>
														<div class="col-2 text-center">	
															<span>Condición</span><br>
															<span>' . $texto_condicion . '</span>
														</div>
														<div class="col-2 text-center">	
															<span>Entrega</span><br>
															<span>' . $texto_tipo . '</span>
														</div>
														<div class="col-2 text-center">	
															<span>Porcentaje</span><br>
															<span>' . $recurso["porcentaje_enlace"] . '%</span>
														</div>
														<div class="col-2 text-center">	
															<span>Otorga</span><br>
															<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
															<span>' . $recurso["puntos_actividad_enlace"] . ' Pts.</span>
														</div>
														<div class="col-12 titulo-2 fs-10 mx-0 px-0">Publicado '.$peadocente->fechaesp($recurso["fecha_enlace"]).'</div>';

													}else{

														$data["opciones"] .= '
														<div class="col-4">
															<span>De: ' . $peadocente->fechaespsinano($recurso["fecha_inicio_enlace"]) . '</span><br>
															<span><i class="fa-solid fa-lock text-danger"></i> Cerro: ' . $peadocente->fechaespsinano($recurso["fecha_limite_enlace"]) . '</span>
														</div>
														<div class="col-2 text-center">	
															<span>Condición</span><br>
															<span>' . $texto_condicion . '</span>
														</div>
														<div class="col-2 text-center">	
															<span>Entrega</span><br>
															<span>' . $texto_tipo . '</span>
														</div>
														<div class="col-2 text-center">	
															<span>Porcentaje</span><br>
															<span>' . $recurso["porcentaje_enlace"] . '%</span>
														</div>
														<div class="col-2 text-center">	
															<span>Otorga</span><br>
															<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
															<span>' . $recurso["puntos_actividad_enlace"] . ' Pts.</span>
														</div>
														<div class="col-12 titulo-2 fs-10 mx-0 px-0">Publicado '.$peadocente->fechaesp($recurso["fecha_enlace"]).'</div>';

													}

												}

													$data["opciones"] .= '
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>';
							$mifila++;
						} 
						elseif ($recurso['tipo'] === 'glosario') {
							
								$data["opciones"] .= '
							<div class="my-2 py-2 border-bottom" id="mifila'.$mifila.'">
								<div class="row justify-content-center align-items-center">
									
									<div class="col-1 text-center"><i class="fas fa-book-reader text-danger fa-2x"></i></div>
										<div class="col-11">
											<div class="row">

												<div class="col-12 my-0 py-0">
													<div class="row">
														<div class="col-auto dropdown" >
															<button class="btn btn-sm dropdown-toggle semibold titulo-2 fs-12 p-0 m-0" type="button" data-toggle="dropdown" aria-expanded="false">
																<i class="fa-solid fa-ellipsis-vertical"></i>
															</button>
															<div class="dropdown-menu" style="">
																<a class="dropdown-item" onclick="informacionGlosario(' . $recurso["id_pea_glosario"] . ')">Abrir detalles</a>
																<a class="dropdown-item" onclick="editarGlosario(' . $recurso["id_pea_glosario"] . ',' . $id_pea_docente . ')">Editar</a>
																<a class="dropdown-item" onclick="eliminarGlosario(' . $recurso["id_pea_glosario"] . ','.$mifila.')">Eliminar </a>
															</div>
														</div>
														<div class="col-11">
															<div class="row">
																<div class="col-10">
																	<span class="text-semibold">' . htmlspecialchars($recurso["titulo_glosario"]) . '</span>
																</div>
																<div class="col-2 text-center">
																	Otorga<br>
																	<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
																	<span>' . $recurso["puntos_actividad_glosario"] . 'Pts.</span>
																</div>
															</div>
															
														</div>
														
													</div>
												</div>
												<div class="col-12 titulo-2 fs-10 mx-0 px-0">
													Publicado '.$peadocente->fechaesp($recurso["fecha_glosario"]).'
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>';
							$mifila++;
						}
						elseif ($recurso['tipo'] === 'video') {

							switch ($recurso["condicion_finalizacion_video"]) {
								case 1:
									$texto_condicion = "No";
									break;
								case 2:
									$texto_condicion = "Estudiante marca";
									break;
								case 3:
									$texto_condicion = "subir archivo";
									break;
								default:
									$texto_condicion = "desconocido";
							}

							switch ($recurso["tipo_condicion_video"]) {
								case 0:
									$texto_tipo = "nada";
									break;
								case 1:
									$texto_tipo = "Archivo";
									break;
								case 2:
									$texto_tipo = "Link evidencia";
									break;
								case 3:
									$texto_tipo = "mensaje";
									break;
								default:
									$texto_tipo = "desconocido";
							}


							if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_video"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_video"])) {
								$terminovideo="no";
							}else{
								$terminovideo="si";
							}

							$data["opciones"] .= '
								<div class="col-12 my-2 py-2 border-bottom" id="mifila'.$mifila.'">
									<div class="row justify-content-center align-items-center">
										<div class="col-1">
											<i class="fas fa-file-video fa-2x text-danger"></i></i>
										</div>
										<div class="col-11">
											<div class="row">
												<div class="col-12">
													<div class="row">
														<div class="dropdown" style="width:20px">
															<button class="btn btn-sm dropdown-toggle semibold titulo-2 fs-12 p-0 m-0" type="button" data-toggle="dropdown" aria-expanded="false">
																<i class="fa-solid fa-ellipsis-vertical"></i>
															</button>
															<div class="dropdown-menu" style="">
																<a class="dropdown-item" onclick="informacionVideo('.$recurso["id_pea_video"].')">Abrir detalles</a>
																<a class="dropdown-item" href="' . htmlspecialchars($recurso["video"]) . '" target="_blank">Material</a>
																<a class="dropdown-item" onclick="editarVideo(' . $recurso["id_pea_video"] . ',' . $id_pea_docente . ')">Editar</a>
																<a class="dropdown-item" onclick="eliminarVideo(' . $recurso["id_pea_video"] . ','.$mifila.')">Eliminar </a>
															</div>
														</div>
														<div class="col-10">
															<span class="text-semibold">' . htmlspecialchars($recurso["titulo_video"]) . '</span>
														</div>
													</div>
												</div>
												<div class="col-12">
													<div class="row">';
													if(strtotime($fecha) < strtotime($recurso["fecha_inicio_video"])){
															$data["opciones"] .= '
														<div class="col-4">
															<span>Inicia: ' . $peadocente->fechaespsinano($recurso["fecha_inicio_video"]) . '</span><br>
															<span>Hasta: ' . $peadocente->fechaespsinano($recurso["fecha_limite_video"]) . '</span>
															<div class="col-12 fs-18 text-success"><i class="fa-solid fa-hourglass-half"></i> Proximamente...</div>
														</div>
														<div class="col-2 text-center">	
															<span>Condición</span><br>
															<span>' . $texto_condicion . '</span>
														</div>
														<div class="col-2 text-center">	
															<span>Entrega</span><br>
															<span>' . $texto_tipo . '</span>
														</div>
														<div class="col-2 text-center">	
															<span>Porcentaje</span><br>
															<span>' . $recurso["porcentaje_video"] . '%</span>
														</div>
														<div class="col-2 text-center">	
															<span>Otorga</span><br>
															<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
															<span>' . $recurso["puntos_actividad_video"] . ' Pts.</span>
														</div>
														<div class="col-12 titulo-2 fs-10 mx-0 px-0">Publicado '.$peadocente->fechaesp($recurso["fecha_video"]).'</div>';

													}else{

														if($terminovideo=="no"){

																$data["opciones"] .= '
															<div class="col-4">
																<span>De: ' . $peadocente->fechaespsinano($recurso["fecha_inicio_video"]) . '</span><br>
																<span>Hasta: ' . $peadocente->fechaespsinano($recurso["fecha_limite_video"]) . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Condición</span><br>
																<span>' . $texto_condicion . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Entrega</span><br>
																<span>' . $texto_tipo . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Porcentaje</span><br>
																<span>' . $recurso["porcentaje_video"] . '%</span>
															</div>
															<div class="col-2 text-center">	
																<span>Otorga</span><br>
																<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
																<span>' . $recurso["puntos_actividad_video"] . ' Pts.</span>
															</div>
															<div class="col-12 titulo-2 fs-10 mx-0 px-0">Publicado '.$peadocente->fechaesp($recurso["fecha_video"]).'</div>';

														}else{

															$data["opciones"] .= '
															<div class="col-4">
																<span>De: ' . $peadocente->fechaespsinano($recurso["fecha_inicio_video"]) . '</span><br>
																<span><i class="fa-solid fa-lock text-danger"></i> Cerro: ' . $peadocente->fechaespsinano($recurso["fecha_limite_video"]) . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Condición</span><br>
																<span>' . $texto_condicion . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Entrega</span><br>
																<span>' . $texto_tipo . '</span>
															</div>
															<div class="col-2 text-center">	
																<span>Porcentaje</span><br>
																<span>' . $recurso["porcentaje_video"] . '%</span>
															</div>
															<div class="col-2 text-center">	
																<span>Otorga</span><br>
																<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
																<span>' . $recurso["puntos_actividad_video"] . ' Pts.</span>
															</div>
															<div class="col-12 titulo-2 fs-10 mx-0 px-0">Publicado '.$peadocente->fechaesp($recurso["fecha_video"]).'</div>';

														}

													}

														$data["opciones"] .= '
													</div>
												</div>
											</div>
										</div>

									</div>
								</div>';
							$mifila++;
						} 
					}

					// Indicador para JS
					$data[] = [
						"data1" => $mensaje,
						"opciones" => $data["opciones"]
					];
				

		echo json_encode($data);
		break;


	case 'marcarvisto':
		$data = array();
		$data["data1"] = "";

		$ciclo = $_POST["ciclo"];
		$id_pea_tema_ciclo = $_POST["id_pea_tema_ciclo"];

		// Ejecutamos el método para marcar como visto
		$rspta = $peadocente->marcarvisto($ciclo, $id_pea_tema_ciclo);

		// Si se ejecutó correctamente, mandamos "1", de lo contrario "2"
		if ($rspta) {
			$data["data1"] = "1"; // actualizado correctamente
		} else {
			$data["data1"] = "2"; // no se pudo actualizar
		}

		echo json_encode([$data]);
		break;

	case 'informacionDoc':
		$data = [];
		$data["data1"] = "";
		$id_pea_documento = $_POST["id_pea_documento"];
		$datostaller=$peadocente->datostaller($id_pea_documento);
			$id_pea_docente=$datostaller["id_pea_docentes"];
			$id_tema=$datostaller["id_tema"];
			$nombre_documento=$datostaller["nombre_documento"];
			$descripcion_documento=$datostaller["descripcion_documento"];
			$tipo_archivo=$datostaller["tipo_archivo"];
			$archivo_documento=$datostaller["archivo_documento"];
			$fecha_actividad=$datostaller["fecha_actividad"];
			$hora_actividad=$datostaller["hora_actividad"];
			$ciclo=$datostaller["ciclo"];
			$condicion_finalizacion_documento=$datostaller["condicion_finalizacion_documento"];
			$tipo_condicion_documento=$datostaller["tipo_condicion_documento"];
			$fecha_inicio_documento=$datostaller["fecha_inicio_documento"];
			$fecha_limite_documento=$datostaller["fecha_limite_documento"];
			$porcentaje_documento=$datostaller["porcentaje_documento"];
			$otorgar_puntos_documento=$datostaller["otorgar_puntos_documento"];
			$puntos_actividad_documento=$datostaller["puntos_actividad_documento"];

			$id_docente_grupo=$datostaller["id_docente_grupo"];

			switch ($tipo_archivo) {
				case '1':
					$documento_tipo = '<i class="fas fa-file-image text-info fa-1x"></i>';
					$linkdescarga = '<a class="" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-xs text-white"> Ver Material</a>';
					break;
				case '2':
					$documento_tipo = '<i class="fas fa-file-word fa-1x text-primary"></i>';
					$linkdescarga = '<a class="" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-xs text-white"> Ver Material</a>';
					break;
				case '3':
					$documento_tipo = '<i class="fas fa-file-excel fa-1x text-success"></i>';
					$linkdescarga = '<a class="" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Ver Material</a>';
					break;
				case '4':
					$documento_tipo = '<i class="fas fa-file-powerpoint fa-1x text-pink"></i>';
					$linkdescarga = '<a class="" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Ver Material</a>';
					break;
				case '5':
					$documento_tipo = '<i class="fas fa-file-pdf fa-1x text-danger"></i>';
					$linkdescarga = '<a class="" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Ver Material</a>';
					break;
				case '6':
					$documento_tipo = '<i class="fas fa-file-archive fa-1x text-orange"></i>';
					$linkdescarga = '<a class="" href="../files/pea/ciclo' . $ciclo . '/documentos/' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white"> Ver Material</a>';
					break;
				case '7':
					$documento_tipo = '<i class="fas fa-file-video fa-1x text-danger"></i>';
					$linkdescarga = '<a class="" href="' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
					break;
				case '8':
					$documento_tipo = '<i class="fab fa-google-drive fa-1x text-primary"></i>';
					$linkdescarga = '<a class="" href="' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
					break;
				case '9':
					$documento_tipo = '<i class="fas fa-link fa-1x text-indigo"></i>';
					$linkdescarga = '<a class="" href="' . $archivo_documento . '" target="_blank" class="btn bg-orange btn-sm text-white">Ver Link</a>';
					break;
			}

			switch ($condicion_finalizacion_documento) {
				case 1:
					$texto_condicion_documento = "solo ver el material";
					break;
				case 2:
					$texto_condicion_documento = "Marca terminado";
					break;
				case 3:
					$texto_condicion_documento = "subir archivo";
					break;
				default:
					$texto_condicion_documento = "no aplica";
			}

			switch ($tipo_condicion_documento) {
				case 0:
					$texto_tipo_documento = "solo ver el material";
					break;
				case 1:
					$texto_tipo_documento = "Subir un documento";
					break;
				case 2:
					$texto_tipo_documento = "Link evidencia";
					break;
				case 3:
					$texto_tipo_documento = "Escribir Mensaje";
					break;
				default:
					$texto_tipo_documento = "N/A";
			}

			

			$data["data1"] .= '
			<div class="col-12">
				<div class="card card-tabs">
					<div class="card-header p-0 pt-1">
						<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
							<li class="nav-items">
								<a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Estudiantes</a>
							</li>
							<li class="nav-items">
								<a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Detalles</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="custom-tabs-one-tabContent">
							<div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">';

								$datsodelgrupodocente=$peadocente->listarelgrupo($id_docente_grupo);
									$ciclogrupo=$datsodelgrupodocente["ciclo"];
									$jornada=$datsodelgrupodocente["jornada"];
									$id_programa=$datsodelgrupodocente["id_programa"];
									$grupo=$datsodelgrupodocente["grupo"];
									$id_materia=$datsodelgrupodocente["id_materia"];

									$datosmateriaciafi = $peadocente->materiaDatos($id_materia);
									$materia=$datosmateriaciafi["nombre"];

										$data["data1"] .= '
									<div class="col-12 table-responsive">
										<table id="example" class="table table-hover table-xs" style="width:100%">
											<thead>
												<th id="t2-paso1">Opciones</th>
												<th id="t2-paso6">Identificación</th>
												<th id="t2-paso7">Nombre completo</th>
												<th id="t2-paso8">'.$texto_condicion_documento.'</th>
												<th id="t2-paso9">'.$texto_tipo_documento .'</th>
												<th id="t2-paso10">Entregado</th>
												<th id="t2-paso10">Nota</th>
												<th id="t2-paso10">Puntos</th>
											</thead>
											<tbody>';

												$estudiantes = $peadocente->listarEstudiantes($ciclogrupo, $materia, $jornada, $id_programa, $grupo);

												for ($i = 0; $i < count($estudiantes); $i++) {

													$rspta3 = $peadocente->id_estudiante($estudiantes[$i]["id_estudiante"]);
														$id_credencial = $rspta3["id_credencial"];
													$rspta4 = $peadocente->estudiante_datos($id_credencial);

													$nombre= $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' ' . $rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"] ;

													$entrega ="";
													$fecha_enviado="";
													$hora_enviado="";
													$material="";
													$entregarpuntos="";
													$calificar="";

													$rspta5 = $peadocente->verEjerciciosEntregados($id_pea_documento,$estudiantes[$i]["id_estudiante"],$ciclo);
														if(!empty($rspta5)){// si hay algo que muestre estos datos
															$id_pea_ejercicios_est=$rspta5["id_pea_ejercicios_est"];
															$estado_ejercicios=$rspta5["estado_ejercicios"];
															$id_credencial=$rspta5["id_credencial"];
														}

														if($condicion_finalizacion_documento == 3 && $tipo_condicion_documento == 1){ // si el estudiante debe entrergar y es un archivo

															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material='<a href="../files/pea/ciclo'.$ciclo.'/ejerciciosest/'.$rspta5["archivo_ejercicio"].'" target="_blank">Ver Documento</a>';
																
																	if($porcentaje_documento>0 && $estado_ejercicios==1){// si tiene porcentaje y el taller no esta calificado
																		$calificar = '<input type="text" 
																						name="'.$id_pea_ejercicios_est.'" 
																						id="'.$id_pea_ejercicios_est.'" 
																						style="width:50px" 
																						onblur="notaDocumento(this.value, '.$id_pea_ejercicios_est.', '.$ciclo.','.$id_pea_documento.')"  
																						onkeydown="if(event.key === \'Enter\'){ notaDocumento(this.value,'.$id_pea_ejercicios_est.','.$ciclo.','.$id_pea_documento.'); }">';

																	}else{
																		if($estado_ejercicios==2){// si ya esta calificado el taller
																			$calificar=$rspta5["nota_ejercicios"];
																		}
																	}
																	if($otorgar_puntos_documento == 1 && $rspta5["puntos_otorgados"]== 0){// si se otorgan puntos
																		$entregarpuntos='<a class="btn bg-orange btn-xs" onclick="enviarPuntos('.$id_pea_ejercicios_est.','.$ciclo.','.$id_pea_documento.')"><img src="../public/img/coin.webp" alt="coin" class="img-fluid">Enviar</a>';
																	}else{
																		$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> '.$rspta5["puntos_otorgados"] . ' Pts.';
																	}
																
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
																$calificar="";
															}
														}

														if($condicion_finalizacion_documento == 3 && $tipo_condicion_documento == 2){ // si el estudiante debe entrergar y es un link de evidencia

															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material='<a href="'.$rspta5["link_archivo"].'" target="_blank")">Ver Enlace</a>';
														
																if($porcentaje_documento>0 && $estado_ejercicios==1){// si tiene porcentaje y el taller no esta calificado
																	$calificar = '<input type="text" 
																					name="'.$id_pea_ejercicios_est.'" 
																					id="'.$id_pea_ejercicios_est.'" 
																					style="width:50px" 
																					onblur="notaDocumento(this.value, '.$id_pea_ejercicios_est.', '.$ciclo.','.$id_pea_documento.')"  
																					onkeydown="if(event.key === \'Enter\'){ notaDocumento(this.value,'.$id_pea_ejercicios_est.','.$ciclo.','.$id_pea_documento.'); }">';

																}else{
																	if($estado_ejercicios==2){// si ya esta calificado el taller
																		$calificar=$rspta5["nota_ejercicios"];
																	}
																}
																if($otorgar_puntos_documento == 1 && $rspta5["puntos_otorgados"]== 0){// si se otorgan puntos
																	$entregarpuntos='<a class="btn bg-orange btn-xs" onclick="enviarPuntos('.$id_pea_ejercicios_est.','.$ciclo.','.$id_pea_documento.')"><img src="../public/img/coin.webp" alt="coin" class="img-fluid">Enviar</a>';
																}else{
																	$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> '.$rspta5["puntos_otorgados"] . ' Pts.';
																}

															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
																$calificar="";
															}
														}

														if($condicion_finalizacion_documento == 3 && $tipo_condicion_documento == 3){ // si el estudiante debe entrergar y es un mensaje

															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material='<a class="btn bg-success btn-xs" onclick="verDocumentoMensaje(' .$rspta5["id_pea_ejercicios_est"]. ',' .$rspta5["id_pea_documento"]. ')"> Ver Mensaje</a>';
																if($porcentaje_documento>0 && $estado_ejercicios==1){// si tiene porcentaje y el taller no esta calificado
																	$calificar = '<input type="text" 
																					name="'.$id_pea_ejercicios_est.'" 
																					id="'.$id_pea_ejercicios_est.'" 
																					style="width:50px" 
																					onblur="notaDocumento(this.value, '.$id_pea_ejercicios_est.', '.$ciclo.','.$id_pea_documento.')"  
																					onkeydown="if(event.key === \'Enter\'){ notaDocumento(this.value,'.$id_pea_ejercicios_est.','.$ciclo.','.$id_pea_documento.'); }">';

																}else{
																	if($estado_ejercicios==2){// si ya esta calificado el taller
																		$calificar=$rspta5["nota_ejercicios"];
																	}
																}
																if($otorgar_puntos_documento == 1 && $rspta5["puntos_otorgados"]== 0){// si se otorgan puntos
																	$entregarpuntos='<a class="btn bg-orange btn-xs" onclick="enviarPuntos('.$id_pea_ejercicios_est.','.$ciclo.','.$id_pea_documento.')"><img src="../public/img/coin.webp" alt="coin" class="img-fluid">Enviar</a>';
																}else{
																	$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> '.$rspta5["puntos_otorgados"] . ' Pts.';
																}
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
																$calificar="";
															}
														}

														if($condicion_finalizacion_documento == 2){ // si el estudiante debe marcar como terminado
														
															
															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material="";
																$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> ' . $puntos_actividad_documento . ' Pts.';
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
															}
														}
														
													$data["data1"] .= '
												<tr>
													<td>1</td>
													<td>'.$rspta4["credencial_identificacion"].'</td>
													<td>'.$nombre.'</td>
													<td>'.$entrega.'</td>
													<td>'.$material.'</td>
													<td>'.$peadocente->fechaespsinano($fecha_enviado). ' ' . $peadocente->horaAMPM($hora_enviado) . '</td>
													<td>'.$calificar.'</td>
													<td>'.$entregarpuntos.'</td>
												
												</tr>
													';

												}

													$data["data1"] .= '
											</tbody>
													
										</table>
									</div>
								
								
								
							</div>
							<div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
								<div class="row">

									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2>'.$documento_tipo.'  '.$nombre_documento.'</h2>
											</div>
											<div class="col-12 borde-bottom">
												<p><span class="titulo-2 fs-10 text-semibold">Comentario docente</span><br>
												<span class="titulo-2 fs-14">'.$descripcion_documento.'</span></p>
											</div>
											<div class="col-12 pt-2">
												<p>Documento de apoyo <i class="fa-solid fa-paperclip"></i>'.$linkdescarga.' </p>
											</div>
										</div>
										
									</div>
									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2 class="fs-24">Detalles de la entrega</h2>
											</div>
											<div class="col-6">
												<span>Fecha de inicio</span><br>
												<span class="text-semibold">'. $peadocente->fechaesp($fecha_inicio_documento) . '</span>
											</div>
											<div class="col-6">
												<span>Fecha de cierre</span><br>
												<span class="text-semibold">' . $peadocente->fechaesp($fecha_limite_documento) . '</span>
											</div>
										</div>
									</div>
									<div class="col-12 pt-2">
										<div class="row">
											<div class="col-3 borde">
												<span>Los estudiantes deben </span><br>
												<span class="text-semibold">' . $texto_condicion_documento . '</span>
											</div>
											<div class="col-3 borde">
												<span>Debe ser </span><br>
												<span class="text-semibold">' . $texto_tipo_documento . '</span>
											</div>
											<div class="col-3 borde">
												<span>Se otorgaran </span><br>
												<img src="../public/img/coin.webp" alt="coin" class="pb-2" ><span class="fs-18 text-semibold"> ' . $puntos_actividad_documento . ' Pts.</span>
											</div>
											
											<div class="col-3 borde"><h3 class="fs-14">Porcentaje del taller</h3><span class="fs-18">'.$porcentaje_documento.'%</span></div>
										</div>
									</div>
							
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>';

		echo json_encode($data);
		break;

	case 'informacionEnlace':
		$data = [];
		$data["data1"] = "";
		$id_pea_enlace = $_POST["param1"];
		$datostaller=$peadocente->datosenlace($id_pea_enlace);
			$id_pea_docente=$datostaller["id_pea_docentes"];
			$id_tema=$datostaller["id_tema"];
			$titulo_enlace=$datostaller["titulo_enlace"];
			$descripcion_enlace=$datostaller["descripcion_enlace"];
			$enlace=$datostaller["enlace"];
			$fecha_enlace=$datostaller["fecha_enlace"];
			$hora_enlace=$datostaller["hora_enlace"];
			$condicion_finalizacion_enlace=$datostaller["condicion_finalizacion_enlace"];
			$tipo_condicion_enlace=$datostaller["tipo_condicion_enlace"];
			$fecha_inicio_enlace=$datostaller["fecha_inicio_enlace"];
			$fecha_limite_enlace=$datostaller["fecha_limite_enlace"];
			$porcentaje_enlace=$datostaller["porcentaje_enlace"];
			$otorgar_puntos_enlace=$datostaller["otorgar_puntos_enlace"];
			$puntos_actividad_enlace=$datostaller["puntos_actividad_enlace"];
			$ciclo=$datostaller["ciclo"];

			$id_docente_grupo=$datostaller["id_docente_grupo"];


			switch ($condicion_finalizacion_enlace) {
				case 1:
					$texto_condicion_enlace= "solo ver el material";
					break;
				case 2:
					$texto_condicion_enlace = "Marca terminado";
					break;
				case 3:
					$texto_condicion_enlace = "subir archivo";
					break;
				default:
					$texto_condicion_enlace = "no aplica";
			}

			switch ($tipo_condicion_enlace) {
				case 0:
					$texto_tipo_enlace = "solo ver el material";
					break;
				case 1:
					$texto_tipo_enlace = "Subir un documento";
					break;
				case 2:
					$texto_tipo_enlace = "Link evidencia";
					break;
				case 3:
					$texto_tipo_enlace = "Escribir Mensaje";
					break;
				default:
					$texto_tipo_enlace = "N/A";
			}

			

			$data["data1"] .= '
			<div class="col-12">
				<div class="card card-tabs">
					<div class="card-header p-0 pt-1">
						<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
							<li class="nav-items">
								<a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Estudiantes</a>
							</li>
							<li class="nav-items">
								<a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Detalles</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="custom-tabs-one-tabContent">
							<div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">';

								$datsodelgrupodocente=$peadocente->listarelgrupo($id_docente_grupo);
									$ciclogrupo=$datsodelgrupodocente["ciclo"];
									$jornada=$datsodelgrupodocente["jornada"];
									$id_programa=$datsodelgrupodocente["id_programa"];
									$grupo=$datsodelgrupodocente["grupo"];
									$id_materia=$datsodelgrupodocente["id_materia"];

									$datosmateriaciafi = $peadocente->materiaDatos($id_materia);
									$materia=$datosmateriaciafi["nombre"];

										$data["data1"] .= '
									<div class="col-12 table-responsive">
										<table id="example" class="table table-hover table-xs" style="width:100%">
											<thead>
												<th id="t2-paso1">Opciones</th>
												<th id="t2-paso6">Identificación</th>
												<th id="t2-paso7">Nombre completo</th>
												<th id="t2-paso8">'.$texto_condicion_enlace.'</th>
												<th id="t2-paso9">'.$texto_tipo_enlace .'</th>
												<th id="t2-paso10">Entregado</th>
												<th id="t2-paso10">Nota</th>
												<th id="t2-paso10">Puntos</th>
											</thead>
											<tbody>';

												$estudiantes = $peadocente->listarEstudiantes($ciclogrupo, $materia, $jornada, $id_programa, $grupo);

												for ($i = 0; $i < count($estudiantes); $i++) {

													$rspta3 = $peadocente->id_estudiante($estudiantes[$i]["id_estudiante"]);
														$id_credencial = $rspta3["id_credencial"];
													$rspta4 = $peadocente->estudiante_datos($id_credencial);

													$nombre= $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' ' . $rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"] ;

													$entrega ="";
													$fecha_enviado="";
													$hora_enviado="";
													$material="";
													$entregarpuntos="";
													$calificar="";

													$rspta5 = $peadocente->verEnlacesEntregados($id_pea_enlace,$estudiantes[$i]["id_estudiante"],$ciclo);
														if(!empty($rspta5)){// si hay algo que muestre estos datos
															$id_pea_enlace_est=$rspta5["id_pea_enlaces_est"];
															$estado_ejercicios=$rspta5["estado_ejercicios"];
															$id_credencial=$rspta5["id_credencial"];
														}

														if($condicion_finalizacion_enlace == 3 && $tipo_condicion_enlace == 1){ // si el estudiante debe entrergar y es un archivo

															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material='<a href="../files/pea/ciclo'.$ciclo.'/enlacesest/'.$rspta5["archivo_ejercicio"].'" target="_blank">Ver Documento</a>';
																
																	if($porcentaje_enlace>0 && $estado_ejercicios==1){// si tiene porcentaje y el taller no esta calificado
																		$calificar = '<input type="text" 
																						name="'.$id_pea_enlace_est.'" 
																						id="'.$id_pea_enlace_est.'" 
																						style="width:50px" 
																						onblur="notaEnlace(this.value, '.$id_pea_enlace_est.', '.$ciclo.','.$id_pea_enlace.')"  
																						onkeydown="if(event.key === \'Enter\'){ notaEnlace(this.value,'.$id_pea_enlace_est.','.$ciclo.','.$id_pea_enlace.'); }">';

																	}else{
																		if($estado_ejercicios==2){// si ya esta calificado el taller
																			$calificar=$rspta5["nota_ejercicios"];
																		}
																	}
																	if($otorgar_puntos_enlace == 1 && $rspta5["puntos_otorgados"]== 0){// si se otorgan puntos
																		$entregarpuntos='<a class="btn bg-orange btn-xs" onclick="enviarPuntosEnlace('.$id_pea_enlace_est.','.$ciclo.','.$id_pea_enlace.')"><img src="../public/img/coin.webp" alt="coin" class="img-fluid">Enviar</a>';
																	}else{
																		$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> '.$rspta5["puntos_otorgados"] . ' Pts.';
																	}
																
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
																$calificar="";
															}
														}

														if($condicion_finalizacion_enlace == 3 && $tipo_condicion_enlace == 2){ // si el estudiante debe entrergar y es un link de evidencia

															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material='<a href="'.$rspta5["link_archivo"].'" target="_blank")">Ver Enlace</a>';
														
																if($porcentaje_enlace>0 && $estado_ejercicios==1){// si tiene porcentaje y el taller no esta calificado
																	$calificar = '<input type="text" 
																					name="'.$id_pea_enlace_est.'" 
																					id="'.$id_pea_enlace_est.'" 
																					style="width:50px" 
																					onblur="notaEnlace(this.value, '.$id_pea_enlace_est.', '.$ciclo.','.$id_pea_enlace.')"  
																					onkeydown="if(event.key === \'Enter\'){ notaEnlace(this.value,'.$id_pea_enlace_est.','.$ciclo.','.$id_pea_enlace.'); }">';

																}else{
																	if($estado_ejercicios==2){// si ya esta calificado el taller
																		$calificar=$rspta5["nota_ejercicios"];
																	}
																}
																if($otorgar_puntos_enlace == 1 && $rspta5["puntos_otorgados"]== 0){// si se otorgan puntos
																	$entregarpuntos='<a class="btn bg-orange btn-xs" onclick="enviarPuntosEnlace('.$id_pea_enlace_est.','.$ciclo.','.$id_pea_enlace.')"><img src="../public/img/coin.webp" alt="coin" class="img-fluid">Enviar</a>';
																}else{
																	$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> '.$rspta5["puntos_otorgados"] . ' Pts.';
																}

															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
																$calificar="";
															}
														}

														if($condicion_finalizacion_enlace == 3 && $tipo_condicion_enlace == 3){ // si el estudiante debe entrergar y es un mensaje

															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material='<a class="btn bg-success btn-xs" onclick="verEnlaceMensaje(' .$rspta5["id_pea_enlaces_est"]. ',' .$rspta5["id_pea_enlaces"]. ')"> Ver Mensaje</a>';
																if($porcentaje_enlace>0 && $estado_ejercicios==1){// si tiene porcentaje y el taller no esta calificado
																	$calificar = '<input type="text" 
																					name="'.$id_pea_enlace_est.'" 
																					id="'.$id_pea_enlace_est.'" 
																					style="width:50px" 
																					onblur="notaEnlace(this.value, '.$id_pea_enlace_est.', '.$ciclo.','.$id_pea_enlace.')"  
																					onkeydown="if(event.key === \'Enter\'){ notaEnlace(this.value,'.$id_pea_enlace_est.','.$ciclo.','.$id_pea_enlace.'); }">';

																}else{
																	if($estado_ejercicios==2){// si ya esta calificado el taller
																		$calificar=$rspta5["nota_ejercicios"];
																	}
																}
																if($otorgar_puntos_enlace == 1 && $rspta5["puntos_otorgados"]== 0){// si se otorgan puntos
																	$entregarpuntos='<a class="btn bg-orange btn-xs" onclick="enviarPuntosEnlace('.$id_pea_enlace_est.','.$ciclo.','.$id_pea_enlace.')"><img src="../public/img/coin.webp" alt="coin" class="img-fluid">Enviar</a>';
																}else{
																	$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> '.$rspta5["puntos_otorgados"] . ' Pts.';
																}
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
																$calificar="";
															}
														}

														if($condicion_finalizacion_enlace == 2){ // si el estudiante debe marcar como terminado
														
															
															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material="";
																$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> ' . $puntos_actividad_enlace . ' Pts.';
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
															}
														}
														
													$data["data1"] .= '
												<tr>
													<td>1</td>
													<td>'.$rspta4["credencial_identificacion"].'</td>
													<td>'.$nombre.'</td>
													<td>'.$entrega.'</td>
													<td>'.$material.'</td>
													<td>'.$peadocente->fechaespsinano($fecha_enviado). ' ' . $peadocente->horaAMPM($hora_enviado) . '</td>
													<td>'.$calificar.'</td>
													<td>'.$entregarpuntos.'</td>
												
												</tr>
													';

												}

													$data["data1"] .= '
											</tbody>
													
										</table>
									</div>
								
								
								
							</div>
							<div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
								<div class="row">

									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2><i class="fa-solid fa-link fa-1x"></i>  '.$titulo_enlace.'</h2>
											</div>
											<div class="col-12 borde-bottom">
												<p><span class="titulo-2 fs-10 text-semibold">Comentario docente</span><br>
												<span class="titulo-2 fs-14">'.$descripcion_enlace.'</span></p>
											</div>
											<div class="col-12 pt-2">
												<p>Documento de apoyo <i class="fa-solid fa-paperclip"></i><a href="'.$enlace.'" target="_blank">Ver enlace</a> </p>
											</div>
										</div>
										
									</div>
									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2 class="fs-24">Detalles de la entrega</h2>
											</div>
											<div class="col-6">
												<span>Fecha de inicio</span><br>
												<span class="text-semibold">'. $peadocente->fechaesp($fecha_inicio_enlace) . '</span>
											</div>
											<div class="col-6">
												<span>Fecha de cierre</span><br>
												<span class="text-semibold">' . $peadocente->fechaesp($fecha_limite_enlace) . '</span>
											</div>
										</div>
									</div>
									<div class="col-12 pt-2">
										<div class="row">
											<div class="col-3 borde">
												<span>Los estudiantes deben </span><br>
												<span class="text-semibold">' . $texto_condicion_enlace . '</span>
											</div>
											<div class="col-3 borde">
												<span>Debe ser </span><br>
												<span class="text-semibold">' . $texto_tipo_enlace . '</span>
											</div>
											<div class="col-3 borde">
												<span>Se otorgaran </span><br>
												<img src="../public/img/coin.webp" alt="coin" class="pb-2" ><span class="fs-18 text-semibold"> ' . $puntos_actividad_enlace . ' Pts.</span>
											</div>
											
											<div class="col-3 borde"><h3 class="fs-14">Porcentaje del taller</h3><span class="fs-18">'.$porcentaje_enlace.'%</span></div>
										</div>
									</div>
							
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>';

		echo json_encode($data);
		break;

	case 'informacionVideo':
		$data = [];
		$data["data1"] = "";
		$id_pea_video = $_POST["param1"];
		$datostaller=$peadocente->datosvideo($id_pea_video);
		$id_pea_docente=$datostaller["id_pea_docentes"];
		$id_tema=$datostaller["id_tema"];
		$titulo_video=$datostaller["titulo_video"];
		$descripcion_video=$datostaller["descripcion_video"];
		$video=$datostaller["video"];
		$fecha_video=$datostaller["fecha_video"];
		$hora_video=$datostaller["hora_video"];
		$condicion_finalizacion_video=$datostaller["condicion_finalizacion_video"];
		$tipo_condicion_video=$datostaller["tipo_condicion_video"];
		$fecha_inicio_video=$datostaller["fecha_inicio_video"];
		$fecha_limite_video=$datostaller["fecha_limite_video"];
		$porcentaje_video=$datostaller["porcentaje_video"];
		$otorgar_puntos_video=$datostaller["otorgar_puntos_video"];
		$puntos_actividad_video=$datostaller["puntos_actividad_video"];
		$ciclo=$datostaller["ciclo"];

		$id_docente_grupo=$datostaller["id_docente_grupo"];

		$preguntas_video = $peadocente->getQuestionsVideo($id_pea_video);

		// print_r(count($preguntas_video));

		switch ($condicion_finalizacion_video) {
			case 1:
				$texto_condicion_video= "solo ver el material";
				break;
			case 2:
				$texto_condicion_video = "Marca terminado";
				break;
			case 3:
				$texto_condicion_video = "subir archivo";
				break;
			default:
				$texto_condicion_video = "no aplica";
		}

		switch ($tipo_condicion_video) {
			case 0:
				$texto_tipo_video = "solo ver el material";
				break;
			case 1:
				$texto_tipo_video = "Subir un documento";
				break;
			case 2:
				$texto_tipo_video = "Link evidencia";
				break;
			case 3:
				$texto_tipo_video = "Escribir Mensaje";
				break;
			default:
				$texto_tipo_video = "N/A";
		}

		$data["video"] .= $datostaller["video"];
		$data["data1"] .= '
			<div class="col-12">
				<div class="card card-tabs">
					<div class="card-header p-0 pt-1">
						<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
							<li class="nav-items">
								<a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Estudiantes</a>
							</li>
							<li class="nav-items">
								<a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Detalles</a>
							</li>
							<li class="nav-items">
								<a class="nav-link" id="custom-tabs-one-video-tab" data-toggle="pill" href="#custom-tabs-one-video" role="tab" aria-controls="custom-tabs-one-video" aria-selected="false">Control del video</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="custom-tabs-one-tabContent">
							<div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">';

								$datsodelgrupodocente=$peadocente->listarelgrupo($id_docente_grupo);
									$ciclogrupo=$datsodelgrupodocente["ciclo"];
									$jornada=$datsodelgrupodocente["jornada"];
									$id_programa=$datsodelgrupodocente["id_programa"];
									$grupo=$datsodelgrupodocente["grupo"];
									$id_materia=$datsodelgrupodocente["id_materia"];

									$datosmateriaciafi = $peadocente->materiaDatos($id_materia);
									$materia=$datosmateriaciafi["nombre"];

										$data["data1"] .= '
									<div class="col-12 table-responsive">
										<table id="example" class="table table-hover table-xs" style="width:100%">
											<thead>
												<th id="t2-paso1">Ver respuestas</th>
												<th id="t2-paso6">Identificación</th>
												<th id="t2-paso7">Nombre completo</th>
												<th id="t2-paso8">'.$texto_condicion_video.'</th>
												<th id="t2-paso9">'.$texto_tipo_video .'</th>
												<th id="t2-paso10">Entregado</th>
												<th id="t2-paso10">Nota</th>
												<th id="t2-paso10">Puntos</th>
											</thead>
											<tbody>';

												$estudiantes = $peadocente->listarEstudiantes($ciclogrupo, $materia, $jornada, $id_programa, $grupo);

												for ($i = 0; $i < count($estudiantes); $i++) {

													$rspta3 = $peadocente->id_estudiante($estudiantes[$i]["id_estudiante"]);
														$id_credencial = $rspta3["id_credencial"];
													$rspta4 = $peadocente->estudiante_datos($id_credencial);

													$nombre= $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' ' . $rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"] ;

													$entrega ="";
													$fecha_enviado="";
													$hora_enviado="";
													$material="";
													$entregarpuntos="";
													$calificar="";

													$rspta5 = $peadocente->verVideosEntregados($id_pea_video,$estudiantes[$i]["id_estudiante"],$ciclo);
														if(!empty($rspta5)){// si hay algo que muestre estos datos
															$id_pea_video_est=$rspta5["id_pea_videos_est"];
															$estado_ejercicios=$rspta5["estado_ejercicios"];
															$id_credencial=$rspta5["id_credencial"];
														}

														if($condicion_finalizacion_video == 3 && $tipo_condicion_video == 1){ // si el estudiante debe entrergar y es un archivo

															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material='<a href="../files/pea/ciclo'.$ciclo.'/videosest/'.$rspta5["archivo_ejercicio"].'" target="_blank">Ver Documento</a>';
																
																	if($porcentaje_video>0 && $estado_ejercicios==1){// si tiene porcentaje y el taller no esta calificado
																		$calificar = '<input type="text" 
																						name="'.$id_pea_video_est.'" 
																						id="'.$id_pea_video_est.'" 
																						style="width:50px" 
																						onblur="notaEnlace(this.value, '.$id_pea_video_est.', '.$ciclo.','.$id_pea_video.')"  
																						onkeydown="if(event.key === \'Enter\'){ notaEnlace(this.value,'.$id_pea_video_est.','.$ciclo.','.$id_pea_video.'); }">';

																	}else{
																		if($estado_ejercicios==2){// si ya esta calificado el taller
																			$calificar=$rspta5["nota_ejercicios"];
																		}
																	}
																	if($otorgar_puntos_video == 1 && $rspta5["puntos_otorgados"]== 0){// si se otorgan puntos
																		$entregarpuntos='<a class="btn bg-orange btn-xs" onclick="enviarPuntosEnlace('.$id_pea_video_est.','.$ciclo.','.$id_pea_video.')"><img src="../public/img/coin.webp" alt="coin" class="img-fluid">Enviar</a>';
																	}else{
																		$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> '.$rspta5["puntos_otorgados"] . ' Pts.';
																	}
																
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
																$calificar="";
															}
														}

														if($condicion_finalizacion_video == 3 && $tipo_condicion_video == 2){ // si el estudiante debe entrergar y es un link de evidencia

															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material='<a href="'.$rspta5["link_archivo"].'" target="_blank")">Ver Enlace</a>';
														
																if($porcentaje_video>0 && $estado_ejercicios==1){// si tiene porcentaje y el taller no esta calificado
																	$calificar = '<input type="text" 
																					name="'.$id_pea_video_est.'" 
																					id="'.$id_pea_video_est.'" 
																					style="width:50px" 
																					onblur="notaEnlace(this.value, '.$id_pea_video_est.', '.$ciclo.','.$id_pea_video.')"  
																					onkeydown="if(event.key === \'Enter\'){ notaEnlace(this.value,'.$id_pea_video_est.','.$ciclo.','.$id_pea_video.'); }">';

																}else{
																	if($estado_ejercicios==2){// si ya esta calificado el taller
																		$calificar=$rspta5["nota_ejercicios"];
																	}
																}
																if($otorgar_puntos_video == 1 && $rspta5["puntos_otorgados"]== 0){// si se otorgan puntos
																	$entregarpuntos='<a class="btn bg-orange btn-xs" onclick="enviarPuntosEnlace('.$id_pea_video_est.','.$ciclo.','.$id_pea_video.')"><img src="../public/img/coin.webp" alt="coin" class="img-fluid">Enviar</a>';
																}else{
																	$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> '.$rspta5["puntos_otorgados"] . ' Pts.';
																}

															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
																$calificar="";
															}
														}

														if($condicion_finalizacion_video == 3 && $tipo_condicion_video == 3){ // si el estudiante debe entrergar y es un mensaje

															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material='<a class="btn bg-success btn-xs" onclick="verEnlaceMensaje(' .$rspta5["id_pea_videos_est"]. ',' .$rspta5["id_pea_videos"]. ')"> Ver Mensaje</a>';
																if($porcentaje_video>0 && $estado_ejercicios==1){// si tiene porcentaje y el taller no esta calificado
																	$calificar = '<input type="text" 
																					name="'.$id_pea_video_est.'" 
																					id="'.$id_pea_video_est.'" 
																					style="width:50px" 
																					onblur="notaEnlace(this.value, '.$id_pea_video_est.', '.$ciclo.','.$id_pea_video.')"  
																					onkeydown="if(event.key === \'Enter\'){ notaEnlace(this.value,'.$id_pea_video_est.','.$ciclo.','.$id_pea_video.'); }">';

																}else{
																	if($estado_ejercicios==2){// si ya esta calificado el taller
																		$calificar=$rspta5["nota_ejercicios"];
																	}
																}
																if($otorgar_puntos_video == 1 && $rspta5["puntos_otorgados"]== 0){// si se otorgan puntos
																	$entregarpuntos='<a class="btn bg-orange btn-xs" onclick="enviarPuntosEnlace('.$id_pea_video_est.','.$ciclo.','.$id_pea_video.')"><img src="../public/img/coin.webp" alt="coin" class="img-fluid">Enviar</a>';
																}else{
																	$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> '.$rspta5["puntos_otorgados"] . ' Pts.';
																}
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
																$calificar="";
															}
														}

														if($condicion_finalizacion_video == 2){ // si el estudiante debe marcar como terminado
														
															
															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material="";
																$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> ' . $puntos_actividad_video . ' Pts.';
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
															}
														}
														
													$data["data1"] .= '
												<tr>
													<td>
														<button
															class="btn btn-sm btn-success"
															onclick="verRespuestasEstudiante('.$id_pea_video.', '.$rspta4["id_credencial"].')"
														>
															<i class="fa fa-eye"></i>
														</button>
													</td>
													<td>'.$rspta4["credencial_identificacion"].'</td>
													<td>'.$nombre.'</td>
													<td>'.$entrega.'</td>
													<td>'.$material.'</td>
													<td>'.$peadocente->fechaespsinano($fecha_enviado). ' ' . $peadocente->horaAMPM($hora_enviado) . '</td>
													<td>'.$calificar.'</td>
													<td>'.$entregarpuntos.'</td>
												
												</tr>
													';

												}

													$data["data1"] .= '
											</tbody>
													
										</table>
									</div>
								
								
								
							</div>
							<div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
								<div class="row">

									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2><i class="fa-solid fa-link fa-1x"></i>  '.$titulo_video.'</h2>
											</div>
											<div class="col-12 borde-bottom">
												<p><span class="titulo-2 fs-10 text-semibold">Comentario docente</span><br>
												<span class="titulo-2 fs-14">'.$descripcion_video.'</span></p>
											</div>
											<div class="col-12 pt-2">
												<p>Documento de apoyo <i class="fa-solid fa-paperclip"></i><a href="'.$video.'" target="_blank">Ver video</a> </p>
											</div>
										</div>
										
									</div>
									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2 class="fs-24">Detalles de la entrega</h2>
											</div>
											<div class="col-6">
												<span>Fecha de inicio</span><br>
												<span class="text-semibold">'. $peadocente->fechaesp($fecha_inicio_video) . '</span>
											</div>
											<div class="col-6">
												<span>Fecha de cierre</span><br>
												<span class="text-semibold">' . $peadocente->fechaesp($fecha_limite_video) . '</span>
											</div>
										</div>
									</div>
									<div class="col-12 pt-2">
										<div class="row">
											<div class="col-3 borde">
												<span>Los estudiantes deben </span><br>
												<span class="text-semibold">' . $texto_condicion_video . '</span>
											</div>
											<div class="col-3 borde">
												<span>Debe ser </span><br>
												<span class="text-semibold">' . $texto_tipo_video . '</span>
											</div>
											<div class="col-3 borde">
												<span>Se otorgaran </span><br>
												<img src="../public/img/coin.webp" alt="coin" class="pb-2" ><span class="fs-18 text-semibold"> ' . $puntos_actividad_video . ' Pts.</span>
											</div>
											
											<div class="col-3 borde"><h3 class="fs-14">Porcentaje del taller</h3><span class="fs-18">'.$porcentaje_video.'%</span></div>
										</div>
									</div>
							
								</div>
							</div>
							<div class="tab-pane fade" id="custom-tabs-one-video" role="tabpanel" aria-labelledby="custom-tabs-one-video-tab">
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2><i class="fa-solid fa-link fa-1x"></i>&ensp;'.$titulo_video.'</h2>
											</div>
											<div class="col-12 borde-bottom">
												<p>
													<span class="titulo-2 fs-10 text-semibold">Comentario docente</span><br>
													<span class="titulo-2 fs-14">'.$descripcion_video.'</span>
												</p>
											</div>
											<div class="col-12 pt-2">
												<p>
													Documento de apoyo <i class="fa-solid fa-paperclip"></i>
													<a href="'.$video.'" target="_blank">Ver video</a>
												</p>
											</div>
										</div>
									</div>

									<div class="col-12 pt-3 text-center">
										<div id="player"></div>
									</div>

									<div class="col-12">
										<div class="row">
											<div class="col-12 d-flex justify-content-between align-items-center p-2">
												<h2 class="fs-24 mb-0">Preguntas para el video.</h2>

												<button class="btn btn-xs bg-purple text-white add-field-list-question">
													<i class="fa fa-plus"></i> Agregar pregunta
												</button>
											</div>

											<table class="table table-hover">
												<thead>
													<tr class="table-active">
														<th>
															Segundo
														</th>
														<th>
															Elaborar pregunta.
														</th>
														<th>
															Tipo de respuesta
														</th>
														<th>
															Acciones
														</th>
													</tr>
												</thead>
												<tbody id="times-video">';

													if (!empty($preguntas_video)) {
														foreach ($preguntas_video as $pregunta) {
															$id_pregunta = $pregunta["id"];
															$tiempo = $pregunta["tiempo_segundos"];
															$texto = $pregunta["pregunta"];
															$tipo = $pregunta["tipo_pregunta"];

															$tipoTexto = ($tipo == 1) ? "Verdadero / Falso" : "Texto corta";

															$data["data1"] .= '
															<tr>
																<td>'.$tiempo.'</td>
																<td>'.$texto.'</td>
																<td>'.$tipoTexto.'</td>
																<td>
																	<button class="btn btn-sm btn-primary edit-question" data-id="'.$id_pregunta.'" data-tiempo="'.$tiempo.'" data-pregunta="'.htmlspecialchars($texto).'" data-tipo="'.$tipo.'">
																		<i class="fa fa-edit"></i>
																	</button>
																	<button class="btn btn-sm btn-danger delete-question" data-id="'.$id_pregunta.'">
																		<i class="fa fa-trash"></i>
																	</button>
																</td>
															</tr>';
														}
													} else {
														$data["data1"] .= '<tr><td colspan="4" class="text-center">No hay preguntas registradas.</td></tr>';
													}
												
							$data["data1"] .= '</tbody>
											</table>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';

			echo json_encode($data);
		break;

	case 'respuestasEstudiante':
		$data = [];
		$data["data1"] = "";
		$id_pea_video = $_POST["param1"];
		$id_estudiante = $_POST["param2"];

		$datostaller=$peadocente->datosvideo($id_pea_video);
		$id_pea_docente=$datostaller["id_pea_docentes"];
		$id_tema=$datostaller["id_tema"];
		$titulo_video=$datostaller["titulo_video"];
		$descripcion_video=$datostaller["descripcion_video"];
		$video=$datostaller["video"];
		$fecha_video=$datostaller["fecha_video"];
		$hora_video=$datostaller["hora_video"];
		$condicion_finalizacion_video=$datostaller["condicion_finalizacion_video"];
		$tipo_condicion_video=$datostaller["tipo_condicion_video"];
		$fecha_inicio_video=$datostaller["fecha_inicio_video"];
		$fecha_limite_video=$datostaller["fecha_limite_video"];
		$porcentaje_video=$datostaller["porcentaje_video"];
		$otorgar_puntos_video=$datostaller["otorgar_puntos_video"];
		$puntos_actividad_video=$datostaller["puntos_actividad_video"];
		$ciclo=$datostaller["ciclo"];

		$id_docente_grupo=$datostaller["id_docente_grupo"];
		$preguntas_video = $peadocente->getQuestionsVideo($id_pea_video);

		$respuestas_video = $peadocente->getRequetsVideo($id_pea_video, $id_estudiante);

		$data["data1"] .= '
			<div class="col-12">
				<div class="card card-tabs">
					<div class="card-header p-0 pt-1">
						<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
							<li class="nav-items">
								<a class="nav-link active" id="custom-tabs-one-video-tab" data-toggle="pill" href="#custom-tabs-one-video" role="tab" aria-controls="custom-tabs-one-video" aria-selected="false">Respustas</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="custom-tabs-one-tabContent">
							<div class="tab-pane fade active show" id="custom-tabs-one-video" role="tabpanel" aria-labelledby="custom-tabs-one-video-tab">
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2><i class="fa-solid fa-link fa-1x"></i>&ensp;'.$titulo_video.'</h2>
											</div>
											<div class="col-12 borde-bottom">
												<p>
													<span class="titulo-2 fs-10 text-semibold">Comentario docente</span><br>
													<span class="titulo-2 fs-14">'.$descripcion_video.'</span>
												</p>
											</div>
											<div class="col-12 pt-2">
												<p>
													Documento de apoyo <i class="fa-solid fa-paperclip"></i>
													<a href="'.$video.'" target="_blank">Ver video</a>
												</p>
											</div>
										</div>
									</div>

									<div class="col-12 pt-3 text-center">
										<div id="player"></div>
									</div>

									<div class="col-12">
										<div class="row">
											<div class="col-12 d-flex justify-content-between align-items-center p-2">
												<h2 class="fs-24 mb-0">Respuestas del estudiante</h2>
											</div>

											<table class="table table-hover">
												<thead>
													<tr class="table-active">
														<th>
															Segundo
														</th>
														<th>
															Elaborar pregunta.
														</th>
														<th>
															Tipo de respuesta
														</th>
														<th>
															Respuesta:
														</th>
													</tr>
												</thead>
												<tbody id="times-video">';

													if (!empty($respuestas_video)) {
														foreach ($respuestas_video as $pregunta) {
															$id_pregunta = $pregunta["id"];
															$tiempo = $pregunta["tiempo_segundos"];
															$texto = $pregunta["pregunta"];
															$tipo = $pregunta["tipo_pregunta"];

															$tipoTexto = ($tipo == 1) ? "Verdadero / Falso" : "Texto corta";

															$data["data1"] .= '
															<tr>
																<td>'.$tiempo.'</td>
																<td>'.$texto.'</td>
																<td>'.$tipoTexto.'</td>
																<td>
																	'.$pregunta["respuesta"].'
																</td>
															</tr>';
														}
													} else {
														$data["data1"] .= '<tr><td colspan="4" class="text-center">No hay preguntas registradas.</td></tr>';
													}
												
							$data["data1"] .= '</tbody>
											</table>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';

			echo json_encode($data);
		break;

	case 'saveQuestionVideo':
		$tipo = $_POST["tipo"];
		$tiempo = $_POST["tiempo"];
		$pregunta = $_POST["pregunta"];
		$video = $_POST["video"];

		$data = array();
		$data["data1"] = "";

		$rspta = $peadocente->saveQuestionVideo($tiempo,$pregunta,$video,$tipo);

		if ($rspta) {
			$data["data1"] = true;
			$data["id_pregunta"] = $rspta;
		} else {
			$data["data1"] = 0;
		}

		echo json_encode($data);
		break;

	case 'editQuestionVideo':
		$id_pregunta =  $_POST["id"];
		$tipo = $_POST["tipo"];
		$pregunta = $_POST["pregunta"];

		$data = array();
		$data["data1"] = "";

		$rspta = $peadocente->editQuestionVideo($id_pregunta, $pregunta, $tipo);

		if ($rspta) {
			$data["data1"] = $rspta["pregunta_actualizada"];
		} else {
			$data["data1"] = 0;
		}

		echo json_encode($data);
		break;

	case 'deleteQuestionVideo':
		$id_pregunta = $_POST["id_pregunta"];

		$data = array();

		$rspta = $peadocente->deleteQuestionVideo($id_pregunta);

		if ($rspta) {
			$data = true;
		} else {
			$data = false;
		}

		echo json_encode($data);
		break;
		

	case 'informacionGlosario':
		$data = [];
		$data["data1"] = "";
		$id_pea_glosario = $_POST["param1"];
		$datostaller=$peadocente->datosglosario($id_pea_glosario);
			$id_pea_docente=$datostaller["id_pea_docentes"];
			$id_tema=$datostaller["id_tema"];
			$titulo_glosario=$datostaller["titulo_glosario"];
			$definicion_glosario=$datostaller["definicion_glosario"];
			$fecha_glosario=$datostaller["fecha_glosario"];
			$hora_glosario=$datostaller["hora_glosario"];
			$otorgar_puntos_glosario=$datostaller["otorgar_puntos_glosario"];
			$puntos_actividad_glosario=$datostaller["puntos_actividad_glosario"];
			$ciclo=$datostaller["ciclo"];

			$id_docente_grupo=$datostaller["id_docente_grupo"];


			$data["data1"] .= '
			<div class="col-12">
				<div class="card card-tabs">
					<div class="card-header p-0 pt-1">
						<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
							<li class="nav-items">
								<a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Estudiantes</a>
							</li>
							<li class="nav-items">
								<a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Detalles</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="custom-tabs-one-tabContent">
							<div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">';

								$datsodelgrupodocente=$peadocente->listarelgrupo($id_docente_grupo);
									$ciclogrupo=$datsodelgrupodocente["ciclo"];
									$jornada=$datsodelgrupodocente["jornada"];
									$id_programa=$datsodelgrupodocente["id_programa"];
									$grupo=$datsodelgrupodocente["grupo"];
									$id_materia=$datsodelgrupodocente["id_materia"];

									$datosmateriaciafi = $peadocente->materiaDatos($id_materia);
									$materia=$datosmateriaciafi["nombre"];

										$data["data1"] .= '
									<div class="col-12 table-responsive">
										<table id="example" class="table table-hover table-xs" style="width:100%">
											<thead>
												<th id="t2-paso1">Opciones</th>
												<th id="t2-paso6">Identificación</th>
												<th id="t2-paso7">Nombre completo</th>
												<th id="t2-paso10">Entregado</th>
												<th id="t2-paso10">Puntos</th>
											</thead>
											<tbody>';

												$estudiantes = $peadocente->listarEstudiantes($ciclogrupo, $materia, $jornada, $id_programa, $grupo);

												for ($i = 0; $i < count($estudiantes); $i++) {

													$rspta3 = $peadocente->id_estudiante($estudiantes[$i]["id_estudiante"]);
														$id_credencial = $rspta3["id_credencial"];
													$rspta4 = $peadocente->estudiante_datos($id_credencial);

													$nombre= $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' ' . $rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"] ;

													$entrega ="";
													$fecha_enviado="";
													$hora_enviado="";
													$material="";
													$entregarpuntos="";


													$rspta5 = $peadocente->verGlosarioEntregados($id_pea_glosario,$estudiantes[$i]["id_estudiante"],$ciclo);
														if(!empty($rspta5)){// si hay algo que muestre estos datos
															$id_pea_enlace_est=$rspta5["id_pea_glosario_est"];
															$id_credencial=$rspta5["id_credencial"];

														
															
															if(!empty($rspta5)){
																$entrega ="Si";
																$fecha_enviado=$rspta5["fecha_enviado"];
																$hora_enviado=$rspta5["hora_enviado"];
																$material="";
																$entregarpuntos='<i class="fa-solid fa-check-double text-success"></i><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px"> ' . $puntos_actividad_glosario . ' Pts.';
															}else{
																$entrega ="No";
																$fecha_enviado="";
																$hora_enviado="";
																$material="";
																$entregarpuntos="";
															}
														}
														
													$data["data1"] .= '
												<tr>
													<td>1</td>
													<td>'.$rspta4["credencial_identificacion"].'</td>
													<td>'.$nombre.'</td>
													<td>'.$peadocente->fechaespsinano($fecha_enviado). ' ' . $peadocente->horaAMPM($hora_enviado) . '</td>
													<td>'.$entregarpuntos.'</td>
												
												</tr>
													';

												}

													$data["data1"] .= '
											</tbody>
													
										</table>
									</div>
								
								
								
							</div>
							<div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
								<div class="row">

									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2><i class="fa-solid fa-link fa-1x"></i>  '.$titulo_glosario.'</h2>
											</div>
											<div class="col-12 borde-bottom">
												<p><span class="titulo-2 fs-10 text-semibold">Comentario docente</span><br>
												<span class="titulo-2 fs-14">'.$definicion_glosario.'</span></p>
											</div>
										</div>
										
									</div>
									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<h2 class="fs-24">Detalles de la entrega</h2>
											</div>
											<div class="col-6">
												<span>Fecha de publicación</span><br>
												<span class="text-semibold">'. $peadocente->fechaesp($fecha_glosario) . '</span>
												<span class="text-semibold">' . $peadocente->fechaesp($hora_glosario) . '</span>
											</div>
										</div>
									</div>
									<div class="col-12 pt-2">
										<div class="row">
											<div class="col-3 borde">
												<span>Se otorgaran </span><br>
												<img src="../public/img/coin.webp" alt="coin" class="pb-2" ><span class="fs-18 text-semibold"> ' . $puntos_actividad_glosario . ' Pts.</span>
											</div>

										</div>
									</div>
							
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>';

		echo json_encode($data);
		break;

	case 'documentoMensaje':
		$data = [];
		$data["data1"] = "";

		$id_pea_ejercicios_est = $_POST["id_pea_ejercicios_est"];
		$id_pea_documento = $_POST["id_pea_documento"];

		$datos = $peadocente->datosdocumento($id_pea_documento);
		$id_pea_docente= $datos["id_pea_docentes"];
		$id_tema = $datos["id_tema"];
		$puntos_otorgados = $datos["puntos_actividad_documento"];
		$ciclo = $datos["ciclo"];

		$datos_delid_usuario = $peadocente->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];

		$estado_ejercicios=2; 
		$rspta2 = $peadocente->verDocumentoMensaje($id_pea_ejercicios_est,$ciclo);

		if ($rspta2) {
			$data["data1"] = $rspta2["comentario_archivo"]; // Éxito
		} else {
			$data["data1"] = 0; // Error
		}
				

		echo json_encode($data);
		break;

	case 'enlaceMensaje':
		$data = [];
		$data["data1"] = "";

		$id_pea_enlaces_est = $_POST["id_pea_enlaces_est"];
		$id_pea_enlaces = $_POST["id_pea_enlaces"];

		$datos = $peadocente->datosenlace($id_pea_enlaces);
		$id_pea_docente= $datos["id_pea_docentes"];
		$id_tema = $datos["id_tema"];
		$puntos_otorgados = $datos["puntos_actividad_enlaces"];
		$ciclo = $datos["ciclo"];

		$datos_delid_usuario = $peadocente->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];

		$estado_ejercicios=2; 
		$rspta2 = $peadocente->verEnlacesMensaje($id_pea_enlaces_est,$ciclo);

		if ($rspta2) {
			$data["data1"] = $rspta2["comentario_archivo"]; // Éxito
		} else {
			$data["data1"] = 0; // Error
		}

		echo json_encode($data);
		break;

	case 'notadocumento':
		$data = [];
		$data["data1"] = "";

		$nota = $_POST["valor"];
		$id_pea_ejercicios_est = $_POST["para1"];
		$ciclo = $_POST["para2"];

		$rspta2 = $peadocente->notadocumento($nota,$id_pea_ejercicios_est,$ciclo);

		// Evaluar si la inserción fue exitosa
		if ($rspta2) {
			$data["data1"] = 1; // Éxito
		} else {
			$data["data1"] = 0; // Error
		}
				

		echo json_encode($data);
	break;

	case 'notaenlace':
		$data = [];
		$data["data1"] = "";

		$nota = $_POST["valor"];
		$id_pea_enlace_est = $_POST["para1"];
		$ciclo = $_POST["para2"];

		$rspta2 = $peadocente->notaenlace($nota,$id_pea_enlace_est,$ciclo);

		// Evaluar si la inserción fue exitosa
		if ($rspta2) {
			$data["data1"] = 1; // Éxito
		} else {
			$data["data1"] = 0; // Error
		}
				

		echo json_encode($data);
	break;

	case 'enviarPuntos':
		$data = [];
		$data["data1"] = "";
		$data["puntosotorgados"] = "";
		$data["puntos"] = "";

		$id_pea_ejercicios_est = $_POST["param1"];
		$ciclo = $_POST["param2"];

		$rspta2 = $peadocente->verDocumentoMensaje($id_pea_ejercicios_est,$ciclo);// trae los datos del taller del estudiante
		$id_pea_docente=$rspta2["id_pea_docente"];
		$id_credencial=$rspta2["id_credencial"];
		$id_pea_documento=$rspta2["id_pea_documento"];

		$verpeadocumento = $peadocente->verDatosDocumento($id_pea_documento);// mirar cuantos puentos da la actividad
		$puntos_otorgados=$verpeadocumento["puntos_actividad_documento"];
	
		$buscarbilleteradocente=$peadocente->buscarBilleteraDocente($id_pea_docente);
			$billetera_asignatura=$buscarbilleteradocente["billetera_asignatura"];// saldo billetera
			if(($billetera_asignatura-$puntos_otorgados)>=0){
				$nuevosaldo=$billetera_asignatura-$puntos_otorgados;
				$descontarbilletra=$peadocente->actualizarBilleteraDocente($id_pea_docente,$nuevosaldo);// descontamos los puntos a la billetra del profe, damos el nuevo saldo pea docente

				$punto_nombre="peadocente";// nombre de los puntos para la tabla puntos
				$puntos_cantidad=$puntos_otorgados;
				$insertarpunto=$peadocente->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora);// inserta en la tabla puntos

				$totalpuntos=$peadocente->verpuntos($id_credencial);// buscamos cuantos puntos tiene el estudiante
				$puntoscredencial=$totalpuntos["puntos"];// variable que contiene el total de puntos
				$sumapuntos=$puntos_cantidad+$puntoscredencial;
				$peadocente->actulizarValor($sumapuntos,$id_credencial);
				$data["puntos"] = "si";
				$data["puntosotorgados"] = $puntos_cantidad;
				$data["data1"] = "Puntos otorgados";

				$actulizarpuntotaller=$peadocente->actulizarPuntoTaller($id_pea_ejercicios_est,$puntos_otorgados,$ciclo);

			}else{
				$data["puntos"] = "no";
				$data["data1"] = "Puntos no otorgados";
			}
	

		echo json_encode($data);
	break;

	case 'enviarPuntosEnlace':
		$data = [];
		$data["data1"] = "";
		$data["puntosotorgados"] = "";
		$data["puntos"] = "";

		$id_pea_enlaces_est = $_POST["param1"];
		$ciclo = $_POST["param2"];

		$rspta2 = $peadocente->verEnlaceMensaje($id_pea_enlaces_est,$ciclo);// trae los datos del taller del estudiante
		$id_pea_docente=$rspta2["id_pea_docente"];
		$id_credencial=$rspta2["id_credencial"];
		$id_pea_enlaces=$rspta2["id_pea_enlaces"];

		$verpeaenlaces = $peadocente->verDatosEnlaces($id_pea_enlaces);// mirar cuantos puentos da la actividad pea_enalces
		$puntos_otorgados=$verpeaenlaces["puntos_actividad_enlace"];
	
		$buscarbilleteradocente=$peadocente->buscarBilleteraDocente($id_pea_docente);
			$billetera_asignatura=$buscarbilleteradocente["billetera_asignatura"];// saldo billetera
			if(($billetera_asignatura-$puntos_otorgados)>=0){
				$nuevosaldo=$billetera_asignatura-$puntos_otorgados;
				$descontarbilletra=$peadocente->actualizarBilleteraDocente($id_pea_docente,$nuevosaldo);// descontamos los puntos a la billetra del profe, damos el nuevo saldo pea docente

				$punto_nombre="peadocente";// nombre de los puntos para la tabla puntos
				$puntos_cantidad=$puntos_otorgados;
				$insertarpunto=$peadocente->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora);// inserta en la tabla puntos

				$totalpuntos=$peadocente->verpuntos($id_credencial);// buscamos cuantos puntos tiene el estudiante
				$puntoscredencial=$totalpuntos["puntos"];// variable que contiene el total de puntos
				$sumapuntos=$puntos_cantidad+$puntoscredencial;
				$peadocente->actulizarValor($sumapuntos,$id_credencial);
				$data["puntos"] = "si";
				$data["puntosotorgados"] = $puntos_cantidad;
				$data["data1"] = "Puntos otorgados";

				$actulizarpuntotaller=$peadocente->actulizarPuntoTallerEnlaces($id_pea_enlaces_est,$puntos_otorgados,$ciclo);

			}else{
				$data["puntos"] = "no";
				$data["data1"] = "Puntos no otorgados";
			}
	

		echo json_encode($data);
	break;
}
