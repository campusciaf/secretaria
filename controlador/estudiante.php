<?php
error_reporting(1);
require_once "../modelos/Estudiante.php";
require_once "../public/mail/sendmailClave.php"; // incluye el codigo para enviar link de clave
require_once "../mail/templatenotiejerciciodocente.php"; // incluye el codigo para enviar link de clave
$estudiante = new Estudiante();

require_once "../modelos/PeaDocente.php"; // incluye el codigo para enviar link de clave
$peadocente = new PeaDocente();

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('h:i:s');
$rsptaperiodo = $estudiante->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$id_credencial = $_SESSION['id_usuario'];
/* subir ejercicios */
$id_pea_ejercicios = isset($_POST["id_pea_ejercicios"]) ? limpiarCadena($_POST["id_pea_ejercicios"]) : "";
$id_pea_ejercicios_2 = isset($_POST["id_pea_ejercicios_2"]) ? limpiarCadena($_POST["id_pea_ejercicios_2"]) : "";

$id_pea_documento = isset($_POST["id_pea_documento"]) ? limpiarCadena($_POST["id_pea_documento"]) : "";
$comentario_ejercicios = isset($_POST["comentario_ejercicios"]) ? limpiarCadena($_POST["comentario_ejercicios"]) : "";
$archivo_ejercicios = isset($_FILES['archivo_ejercicios']['name']) ? limpiarCadena($_FILES['archivo_ejercicios']['name']) : "";

/** datos cuando se envia una evidencia de enlace archivo pero con link */
$id_pea_enlace = isset($_POST["id_pea_enlace"]) ? limpiarCadena($_POST["id_pea_enlace"]) : "";
$comentario_enlace = isset($_POST["comentario_enlace"]) ? limpiarCadena($_POST["comentario_enlace"]) : "";
$archivo_enlace = isset($_FILES['archivo_enlace']['name']) ? limpiarCadena($_FILES['archivo_enlace']['name']) : "";

/** datos cuando se envia una evidencia de link archivo pero con link */
$id_pea_enlace_link = isset($_POST["id_pea_enlace_link"]) ? limpiarCadena($_POST["id_pea_enlace_link"]) : "";
$link_archivo = isset($_POST["link_archivo"]) ? limpiarCadena($_POST["link_archivo"]) : "";
$comentario_enlace_link = isset($_POST["comentario_enlace_link"]) ? limpiarCadena($_POST["comentario_enlace_link"]) : "";
/* ********************** */

/** datos cuando se envia una evidencia de link pero con mensaje */
$id_pea_enlace_mensaje = isset($_POST["id_pea_enlace_mensaje"]) ? limpiarCadena($_POST["id_pea_enlace_mensaje"]) : "";
$comentario_archivo = isset($_POST["comentario_archivo"]) ? limpiarCadena($_POST["comentario_archivo"]) : "";
/* ********************** */

/** datos cuando se envia una evidencia de archivo pero con link */
$id_pea_enlace_documento = isset($_POST["id_pea_enlace_documento"]) ? limpiarCadena($_POST["id_pea_enlace_documento"]) : "";
$link_archivo_documento = isset($_POST["link_archivo_documento"]) ? limpiarCadena($_POST["link_archivo_documento"]) : "";
$comentario_enlace_documento = isset($_POST["comentario_enlace_documento"]) ? limpiarCadena($_POST["comentario_enlace_documento"]) : "";
/* ********************** */

/** datos cuando se envia una evidencia de documento pero con mensaje */
$id_pea_documento_mensaje = isset($_POST["id_pea_documento_mensaje"]) ? limpiarCadena($_POST["id_pea_documento_mensaje"]) : "";
$comentario_archivo_mensaje = isset($_POST["comentario_archivo_mensaje"]) ? limpiarCadena($_POST["comentario_archivo_mensaje"]) : "";
/* ********************** */


switch ($_GET["op"]) {

	case 'guardaryeditarejercicios':
		$data = array();
		$datostaller= $estudiante->datostaller($id_pea_documento);
		$id_pea_docente=$datostaller["id_pea_docentes"];
		$id_tema=$datostaller["id_tema"];
		$ciclo=$datostaller["ciclo"];
		$condicion_finalizacion_documento=$datostaller["condicion_finalizacion_documento"];
		$tipo_condicion_documento=$datostaller["tipo_condicion_documento"];

		$traerid_pea_docentes = $estudiante->traeridpeadocente($id_pea_docente);

		$traeredatosdocentegrupos = $estudiante->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $estudiante->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $estudiante->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $estudiante->estudiante_datos_personales($id_credencial);
		$celular = $datos_estudiante["celular"];
		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];
		// tipo de archivo debe ser rar */
		$allowedExts = array("rar", "xls", "xlsx", "ppt", "pptx", "pdf", "doc", "docx", "zip", "txt", "jpg", "jpeg", "png");
		$target_path = '../files/pea/ciclo' . $ciclo . '/ejerciciosest/';
		$extension = explode(".", $archivo_ejercicios);
		$img1path = $target_path . '' . $fecha . '-' . $archivo_ejercicios;
		$peso = filesize($_FILES['archivo_ejercicios']['tmp_name']);
		$pesofinal = round(($peso / 1024) / 1024);
		/* ************************ */
		if ($pesofinal <= 10) {
			if (in_array(strtolower($extension[count($extension) - 1]), $allowedExts)) {
				if (move_uploaded_file($_FILES['archivo_ejercicios']['tmp_name'], $img1path)) {
					$archivo_ejercicios_final = '' . $fecha . '-' . $_FILES['archivo_ejercicios']['name'];
					$rspta = $estudiante->insertarEjercicio($id_pea_docente,$id_pea_documento,$id_tema, $id_estudiante, $id_credencial, $comentario_ejercicios, $archivo_ejercicios_final, $fecha, $hora, $ciclo); // inserta el tema
					if ($rspta) {
						$data["exito"] = 1;
						$data["info"] = "Archivo insertado correctamente";
						$data["id_pea_docente"] = $id_pea_docente;
						$data["id_tema"] = $id_tema;
						$data["ciclo"] = $ciclo;
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
				$data["info"] = "Tipo de archivo no permitido. Solo se permiten archivos Excel, PowerPoint, RAR, PDF, Word, zip, jpg, png, jpeg.";
			}
		} else {
			$data["exito"] = 0;
			$data["info"] = "El archivo supera el tamaño máximo permitido de 5 MB.";
		}
		echo json_encode($data);
	break;

	case 'guardaryeditarenlace':
		$data = array();
		$datostaller= $estudiante->datosenlace($id_pea_enlace);
		$id_pea_docente=$datostaller["id_pea_docentes"];
		$id_tema=$datostaller["id_tema"];
		$ciclo=$datostaller["ciclo"];
		$condicion_finalizacion_documento=$datostaller["condicion_finalizacion_enlace"];
		$tipo_condicion_documento=$datostaller["tipo_condicion_enlace"];

		$traerid_pea_docentes = $estudiante->traeridpeadocente($id_pea_docente);

		$traeredatosdocentegrupos = $estudiante->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $estudiante->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $estudiante->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $estudiante->estudiante_datos_personales($id_credencial);
		$celular = $datos_estudiante["celular"];
		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];
		// tipo de archivo debe ser rar */
		$allowedExts = array("rar", "xls", "xlsx", "ppt", "pptx", "pdf", "doc", "docx", "zip", "txt", "jpg", "jpeg", "png");
		$target_path = '../files/pea/ciclo' . $ciclo . '/enlacesest/';
		$extension = explode(".", $archivo_enlace);
		$img1path = $target_path . '' . $fecha . '-' . $archivo_enlace;
		$peso = filesize($_FILES['archivo_enlace']['tmp_name']);
		$pesofinal = round(($peso / 1024) / 1024);
		/* ************************ */
		if ($pesofinal <= 10) {
			if (in_array(strtolower($extension[count($extension) - 1]), $allowedExts)) {
				if (move_uploaded_file($_FILES['archivo_enlace']['tmp_name'], $img1path)) {
					$archivo_enlace_final = '' . $fecha . '-' . $_FILES['archivo_enlace']['name'];
					$rspta = $estudiante->insertarEnlace($id_pea_docente,$id_pea_enlace,$id_tema, $id_estudiante, $id_credencial, $comentario_ejercicios, $archivo_enlace_final, $fecha, $hora, $ciclo); // inserta el tema
					if ($rspta) {
						$data["exito"] = 1;
						$data["info"] = "Archivo insertado correctamente";
						$data["id_pea_docente"] = $id_pea_docente;
						$data["id_tema"] = $id_tema;
						$data["ciclo"] = $ciclo;
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
				$data["info"] = "Tipo de archivo no permitido. Solo se permiten archivos Excel, PowerPoint, RAR, PDF, Word, zip, jpg, png, jpeg.";
			}
		} else {
			$data["exito"] = 0;
			$data["info"] = "El archivo supera el tamaño máximo permitido de 5 MB.";
		}
		echo json_encode($data);
	break;

	case 'guardaryeditarenlacelink':
		$data = array();
		$datostaller= $estudiante->datosenlace($id_pea_enlace_link);
		$id_pea_docente=$datostaller["id_pea_docentes"];
		$id_tema=$datostaller["id_tema"];
		$ciclo=$datostaller["ciclo"];
		$condicion_finalizacion_documento=$datostaller["condicion_finalizacion_enlace"];
		$tipo_condicion_documento=$datostaller["tipo_condicion_enlace"];

		$traerid_pea_docentes = $estudiante->traeridpeadocente($id_pea_docente);

		$traeredatosdocentegrupos = $estudiante->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $estudiante->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $estudiante->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $estudiante->estudiante_datos_personales($id_credencial);
		$celular = $datos_estudiante["celular"];
		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];


		$rspta = $estudiante->insertarEnlaceLink($id_pea_docente,$id_pea_enlace_link,$id_tema, $id_estudiante, $id_credencial, $comentario_enlace_link, $link_archivo, $fecha, $hora, $ciclo); // inserta el link
		if ($rspta) {
			$data["exito"] = 1;
			$data["info"] = "Link insertado correctamente";
			$data["id_pea_docente"] = $id_pea_docente;
			$data["id_tema"] = $id_tema;
			$data["ciclo"] = $ciclo;
		} else {
			$data["exito"] = 0;
			$data["info"] = "Error al inserta en base de datos, contactate con campus@ciaf.edu.co para solicitar verificar el error ";
		}
			
		
		
		echo json_encode($data);
	break;

	case 'guardaryeditarenlacedocumento':
		$data = array();
		$datostaller= $estudiante->datosdocumento($id_pea_enlace_documento);
		$id_pea_docente=$datostaller["id_pea_docentes"];
		$id_tema=$datostaller["id_tema"];
		$ciclo=$datostaller["ciclo"];
		$condicion_finalizacion_documento=$datostaller["condicion_finalizacion_enlace"];
		$tipo_condicion_documento=$datostaller["tipo_condicion_enlace"];

		$traerid_pea_docentes = $estudiante->traeridpeadocente($id_pea_docente);

		$traeredatosdocentegrupos = $estudiante->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $estudiante->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $estudiante->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $estudiante->estudiante_datos_personales($id_credencial);
		$celular = $datos_estudiante["celular"];
		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];


		$rspta = $estudiante->insertarDocumentoLink($id_pea_docente,$id_pea_enlace_documento,$id_tema, $id_estudiante, $id_credencial, $comentario_enlace_documento, $link_archivo_documento, $fecha, $hora, $ciclo); // inserta el link
		if ($rspta) {
			$data["exito"] = 1;
			$data["info"] = "Link insertado correctamente";
			$data["id_pea_docente"] = $id_pea_docente;
			$data["id_tema"] = $id_tema;
			$data["ciclo"] = $ciclo;
		} else {
			$data["exito"] = 0;
			$data["info"] = "Error al inserta en base de datos, contactate con campus@ciaf.edu.co para solicitar verificar el error ";
		}
			
		
		
		echo json_encode($data);
	break;
	
	case 'guardaryeditardocumentomensaje':
		$data = array();
		$datostaller= $estudiante->datosdocumento($id_pea_documento_mensaje);
		$id_pea_docente=$datostaller["id_pea_docentes"];
		$id_tema=$datostaller["id_tema"];
		$ciclo=$datostaller["ciclo"];
		$condicion_finalizacion_documento=$datostaller["condicion_finalizacion_enlace"];
		$tipo_condicion_documento=$datostaller["tipo_condicion_enlace"];

		$traerid_pea_docentes = $estudiante->traeridpeadocente($id_pea_docente);

		$traeredatosdocentegrupos = $estudiante->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $estudiante->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $estudiante->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $estudiante->estudiante_datos_personales($id_credencial);
		$celular = $datos_estudiante["celular"];
		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];


		$rspta = $estudiante->insertarDocumentoMensaje($id_pea_docente,$id_pea_documento_mensaje,$id_tema, $id_estudiante, $id_credencial, $comentario_archivo_mensaje, $fecha, $hora, $ciclo); // inserta el link
		if ($rspta) {
			$data["exito"] = 1;
			$data["info"] = "Mensaje enviado correctamente";
			$data["id_pea_docente"] = $id_pea_docente;
			$data["id_tema"] = $id_tema;
			$data["ciclo"] = $ciclo;
		} else {
			$data["exito"] = 0;
			$data["info"] = "Error al inserta en base de datos, contactate con campus@ciaf.edu.co para solicitar verificar el error ";
		}
			
		
		
		echo json_encode($data);
	break;

	case 'guardaryeditarenlacemensaje':
		$data = array();
		$datostaller= $estudiante->datosenlace($id_pea_enlace_mensaje);
		$id_pea_docente=$datostaller["id_pea_docentes"];
		$id_tema=$datostaller["id_tema"];
		$ciclo=$datostaller["ciclo"];
		$condicion_finalizacion_documento=$datostaller["condicion_finalizacion_enlace"];
		$tipo_condicion_documento=$datostaller["tipo_condicion_enlace"];

		$traerid_pea_docentes = $estudiante->traeridpeadocente($id_pea_docente);

		$traeredatosdocentegrupos = $estudiante->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $estudiante->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $estudiante->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $estudiante->estudiante_datos_personales($id_credencial);
		$celular = $datos_estudiante["celular"];
		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];


		$rspta = $estudiante->insertarEnlaceMensaje($id_pea_docente,$id_pea_enlace_mensaje,$id_tema, $id_estudiante, $id_credencial, $comentario_archivo, $fecha, $hora, $ciclo); // inserta el link
		if ($rspta) {
			$data["exito"] = 1;
			$data["info"] = "Mensaje enviado correctamente";
			$data["id_pea_docente"] = $id_pea_docente;
			$data["id_tema"] = $id_tema;
			$data["ciclo"] = $ciclo;
		} else {
			$data["exito"] = 0;
			$data["info"] = "Error al inserta en base de datos, contactate con campus@ciaf.edu.co para solicitar verificar el error ";
		}
			
		
		
		echo json_encode($data);
	break;

	case 'guardaryeditarvideos':
		$data = array();

		$id_pea_video = $_POST['id_pea_video'];
		$comentario_video = $_POST['comentario_video'];
		$archivo_video = $_FILES['archivo_video'];

		$datostaller = $peadocente->datosvideo($id_pea_video);

		$id_pea_docente=$datostaller["id_pea_docentes"];
		$id_tema=$datostaller["id_tema"];
		$ciclo=$datostaller["ciclo"];
		$condicion_finalizacion_documento=$datostaller["condicion_finalizacion_video"];
		$tipo_condicion_documento=$datostaller["tipo_condicion_video"];

		$traerid_pea_docentes = $estudiante->traeridpeadocente($id_pea_docente);

		$traeredatosdocentegrupos = $estudiante->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $estudiante->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $estudiante->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $estudiante->estudiante_datos_personales($id_credencial);
		$celular = $datos_estudiante["celular"];
		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];

		// tipo de archivo debe ser rar */
		$allowedExts = array("rar", "xls", "xlsx", "ppt", "pptx", "pdf", "doc", "docx", "zip", "txt", "jpg", "jpeg", "png");
		$target_path = '../files/pea/ciclo' . $ciclo . '/videosest/';
		$extension = explode(".", $archivo_video['name']);

		$img1path = $target_path . '' . $fecha . '-' . $archivo_video['name'];
		$peso = filesize($_FILES['archivo_video']['tmp_name']);
		$pesofinal = round(($peso / 1024) / 1024);

		/* ************************ */
		if ($pesofinal <= 10) {
			if (in_array(strtolower($extension[count($extension) - 1]), $allowedExts)) {
				if (move_uploaded_file($_FILES['archivo_video']['tmp_name'], $img1path)) {
					$archivo_video_final = '' . $fecha . '-' . $_FILES['archivo_video']['name'];

					// echo($id_pea_docente.' - '.$id_pea_video.' - '.$id_tema.' - '.$id_estudiante.' - '.$id_credencial.' - '.$comentario_video.' - '.$archivo_video_final.' - '.$fecha.' - '.$hora.' - '.$ciclo);

					$rspta = $estudiante->insertarVideo($id_pea_docente,$id_pea_video,$id_tema, $id_estudiante, $id_credencial, $comentario_video, $archivo_video_final, $fecha, $hora, $ciclo); // inserta el tema
					if ($rspta) {
						$data["exito"] = 1;
						$data["info"] = "Archivo insertado correctamente";
						$data["id_pea_docente"] = $id_pea_docente;
						$data["id_tema"] = $id_tema;
						$data["ciclo"] = $ciclo;
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
				$data["info"] = "Tipo de archivo no permitido. Solo se permiten archivos Excel, PowerPoint, RAR, PDF, Word, zip, jpg, png, jpeg.";
			}
		} else {
			$data["exito"] = 0;
			$data["info"] = "El archivo supera el tamaño máximo permitido de 5 MB.";
		}
		echo json_encode($data);
	break;



	
	case 'listar2':
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
		$rspta = $estudiante->listar($id, $ciclo, $grupo);
		$huella = isset($rspta["huella"]) ? $rspta["huella"] : '';
		$rspta2 = $estudiante->programaacademico($id_programa);
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
			$estudiantes_homologados = $estudiante->listar($id, $ciclo, $grupo);
			for ($r = 0; $r < count($estudiantes_homologados); $r++) {
				$huella = $estudiantes_homologados[$r]["huella"];
				$buscar_docente_h = $estudiante->buscaridmateria_h();
				// print_r($buscar_docente_h);
				$id_docente_h = $buscar_docente_h[$r]["id_docente"];
				$id_materia_h = $buscar_docente_h[$r]["id_materia"];
				$jornada_h = $buscar_docente_h[$r]["jornada"];
				$periodo_h = $buscar_docente_h[$r]["periodo"];
				$semestre_h = $buscar_docente_h[$r]["semestre"];
				$nombre_materia_h = $buscar_docente_h[$r]["nombre_materia"];
				$docente = $buscar_docente_h[$r]["usuario_nombre"] . ' ' . $buscar_docente_h[$r]["usuario_nombre_2"] . ' <br>' . $buscar_docente_h[$r]["usuario_apellido"] . ' ' . $buscar_docente_h[$r]["usuario_apellido_2"];
				$buscaridmateria = $estudiante->buscaridmateria($id_programa, $nombre_materia_h);
				$idmateriaencontrada = $buscaridmateria["id"];
				$resultadorspta3 = $buscar_docente_h ? 1 : 0; // si existe registro
				if ($resultadorspta3 == 1) { // si existe horario para la clase
					$id_docente = $buscar_docente_h[$r]["id_docente"];
					$id_docente_grupo = $buscar_docente_h[$r]["id_docente_grupo"];
					// $rspta4 = $estudiante->docente_datos($id_docente);
					if (file_exists('../files/docentes/' . $buscaridmateria["usuario_identificacion"] . '.jpg')) {
						$foto = '<img src=../files/docentes/' . $buscaridmateria["usuario_identificacion"] . '.jpg width=40px height=40px class=img-circle>';
					} else {
						$foto = '<img src=../files/null.jpg width=40px height=40px class=img-circle>';
					}
					$horario = $buscar_docente_h[$r]["dia"] . ' <br> ' . $buscar_docente_h[$r]["hora"] . ' - ' . $buscar_docente_h[$r]["hasta"] . ' - corte ' . $buscar_docente_h[$r]["corte"];
					if ($estudiantes_homologados[$r]["id_pea"] == null) { // si el estudiante no tiene PEA
						$rsptatienepea = $estudiante->docente_pea($id_docente_grupo);
						$tienepea = $rsptatienepea ? 1 : 0; // si existe registro
						if ($tienepea == 1) {
							$botonpea = '<a onclick=validar_pea(' . $num_id . ',' . $ciclo . ',' . $estudiantes_homologados[$r]["id_materia"] . ',' . $id_docente_grupo . ') class="btn btn-primary btn-xs" title="PLan Educativo sin Activar">Activar PEA</a>';
						} else { // no tiene pea
							$botonpea = "En proceso";
						}
					} else { // si ya tiene pea
						$botonpea = '<a onclick="verPanel(' . $id_docente_grupo . ', ' . $id . ')" class="btn btn-success btn-sm" title="Plan Educativo de Aula">Ver PEA</a>';
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
					$buscaridmateria = $estudiante->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
					$idmateriaencontrada = $buscaridmateria["id"];
					$rspta3 = $estudiante->docente_grupo($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
					// si existe registro
					$resultadorspta3 = $rspta3 ? 1 : 0; 
					// si existe horario para la clase
					if ($resultadorspta3 == 1) { 
						$id_docente = $rspta3["id_docente"];
						$id_docente_grupo = $rspta3["id_docente_grupo"];
						$rspta4 = $estudiante->docente_datos($id_docente);

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

							$rsptatienepea = $estudiante->docente_pea($id_docente_grupo);
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
					$traerhorarios = $estudiante->docente_grupo_clases($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
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
					$rspta3 = $estudiante->docente_grupo_por_id($id_docente_grupo_esp);
					// si existe registro
					$resultadorspta3 = $rspta3 ? 1 : 0;
					// si existe horario para la clase
					if ($resultadorspta3 == 1) {
						$id_docente = $rspta3["id_docente"];
						// se toma el id del docente grupo especial
						$id_docente_grupo = $rspta3["id_docente_grupo"];
						$rspta4 = $estudiante->docente_datos($id_docente);
						if (file_exists('../files/docentes/' . $rspta4["usuario_identificacion"] . '.jpg')) {
							$foto = '<img src=../files/docentes/' . $rspta4["usuario_identificacion"] . '.jpg width=30px height=30px class=img-circle>';
						} else {
							$foto = '<img src=../files/null.jpg width=30px height=30px class=img-circle>';
						}
						$nombredeldocente = $rspta4["usuario_nombre"] . ' ' . $rspta4["usuario_nombre_2"] . ' <br>' . $rspta4["usuario_apellido"] . ' ' . $rspta4["usuario_apellido_2"];
						$horario = '<b>' . $rspta3["dia"] . '</b> ' . $rspta3["hora"] . ' - ' . $rspta3["hasta"] . ' - corte ' . $rspta3["corte"];
						if ($reg[$i]["id_pea"] == null) { // si el estudiante no tiene PEA

							$rsptatienepea = $estudiante->docente_pea($id_docente_grupo);
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
		
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$data["0"] .= '


			
			<div class="col-xl-6 col-lg-6 col-md-6 col-7 py-2">
			
				<div class="row">
					<div class="card p-2">
						<div class="row  ">
							<div class="col-auto">
								<div class="avatar avatar-50 rounded bg-light-green">
									<i class="fa-solid fa-landmark text-success fa-2x"></i>
								</div>
							</div>
							<div class="col-auto pt-2">
								<p class="small text-secondary mb-0">Ver mi plan</p>
								<h4 class="fw-medium"><a onclick="planestudios()" title="Descripción de la asignatura" class="pointer">De estudios</a></h4>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="d-none col-xl-6 col-lg-6 col-md-6 col-5 pr-4 pt-4">
				<a onclick="iniciarcalendario(' . $id . ',' . $ciclo . ',' . $id_programa . ',' . $grupo . ')" class="btn btn-primary float-right" id="t-paso8"><i class="fa-solid fa-calendar-days" ></i> Ver calendario </a>
			</div>
			
		';

		$results = array($data);
		echo json_encode($results);
	break;

	case 'validar_pea':
		$ciclo = $_POST["ciclo"];
		$id_estudiante_materia = $_POST["id_estudiante_materia"];
		$id_docente_materia = $_POST["id_docente_materia"];
		$rspta = $estudiante->docente_pea($id_docente_materia);
		$reg = $rspta;
		$id_pea = $reg["id_pea"];
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$data["0"] .= $id_pea;
		if ($id_pea != "") {
			$rspta2 = $estudiante->asignar_pea_docente($ciclo, $id_pea, $id_estudiante_materia);
		}
		$results = array($data);
		echo json_encode($results);
	break;
	case 'verpanel':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$rspta = $estudiante->listar_pea($id_docente_grupo, $periodo_actual);
		$reg = $rspta;
		$id_pea = $reg["id_pea"]; //contiene id del pea//
		$id_pea_docente = $reg["id_pea_docentes"];
		$descripcion = $reg["descripcion"]; //contiene id del pea//
		$referencias = $reg["referencias"]; //contiene id del pea//
		$observaciones = $reg["observaciones"]; //contiene id del pea//	
		$recursos = $reg["recursos"]; //contiene id del pea//
		$datosdocentegrupo = $estudiante->datosdocentegrupo($id_docente_grupo, $periodo_actual);
		$id_materia = $datosdocentegrupo["id_materia"];
		$grupo = $datosdocentegrupo["grupo"];
		$ciclo = $datosdocentegrupo["ciclo"];
		$datosmateria = $estudiante->datosmateria($id_materia);
		$nombremateria = $datosmateria["nombre"];
		$id_programa_ac = $datosmateria["id_programa_ac"];

		$rspta1 = $estudiante->verPea($id_pea); // Temas del PEA
		$totalTemas = count($rspta1);
		$temasVistos = 0;
		// Contar progreso
			for ($i = 0; $i < $totalTemas; $i++) {
				$id_tema = $rspta1[$i]["id_tema"];
				$verificarestado = $estudiante->verEstadoTema($ciclo, $id_pea, $id_pea_docente, $id_tema);
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
						<h4 class="fw-bold titulo-2">
							'.$nombremateria.'
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
										$id_tema = $rspta1[$i]["id_tema"];
										$conceptuales = $rspta1[$i]["conceptuales"];
										$verificarestado = $estudiante->verEstadoTema($ciclo, $id_pea, $id_pea_docente, $id_tema);

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
														$data["0"] .= '<span class="text-warning"><i class="fa fa-plus"></i> Pendiente</span>';
												}else{
													$data["0"] .= '
													<a onclick="agregarrecurso('.$id_tema.','.$id_pea_docente.','.$ciclo.')" 
														class="btn btn-xs bg-purple text-white">
														<i class="fa fa-plus"></i> Ver recursos
													</a>';
												}
													
													$data["0"] .= '
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

		



/*
		<div class="row d-none">

			<div class="col-12 text-right pb-3">
				<a href="estudiante.php" title="Listado de materias">
					Calendario
				</a>/ 
				 Contenidos 
			</div>

			<div class="col-xl-3 col-12  border-0 mb-4 ">
				<div class="p-2">
					<div class="row">

					
						<div class="card bg-primary py-2 col-xl-12 col-12">
							<div class="row align-items-center ">
								<div class="col-auto ">
									<p class="fs-18 mb-0">Asignatura</p>
									<h4 class="fw-medium"><a onclick="planestudios()" title="Descripción de la asignatura" class="pointer">'.$nombremateria.'</a></h4>
								</div>
							</div>
						</div>
					


						<div class="col-6 col-md-12 col-lg-12 col-xl-12 card py-2">
							<div class="row align-items-center">
								<div class="col-auto">
									<div class="avatar avatar-50 rounded bg-light-cyan">
										<i class="fa-solid fa-landmark text-primary fa-2x"></i>
									</div>
								</div>
								<div class="col-auto pt-2">
									<p class="small text-secondary mb-0">Proyecto de</p>
									<h4 class="fw-medium"><a onclick="descripcion(' . $id_pea . ')" title="Descripción de la asignatura" class="pointer">Aula</a></h4>
								</div>
							</div>
						</div>
						<div class="col-6 col-md-12 col-lg-12 col-xl-12 card py-2">
							<div class="row align-items-center">
								<div class="col-auto ">
									<div class="avatar avatar-50 rounded bg-light-cyan">
										<i class="fa-solid fa-cloud fa-2x text-primary"></i>
									</div>
								</div>
								<div class="col pt-2">
									<p class="small text-secondary mb-0">Documentos de </p>
									<h4 class="fw-medium"><a onclick="documentos(' . $id_pea_docentes . ',' . $id_programa_ac . ')" title="Documentos" class="pointer">Apoyo</a></h4>
								</div>
							</div>
						</div>
						<div class="col-6 col-md-12 col-lg-12 col-xl-12 card py-2">
							<div class="row align-items-center">
								<div class="col-auto ">
									<div class="avatar avatar-50 rounded bg-light-cyan">
										<i class="fa-solid fa-link fa-2x text-primary"></i>
									</div>
								</div>
								<div class="col pt-2">
									<p class="small text-secondary mb-0">Ayudas</p>
									<h4 class="fw-medium"><a onclick="enlaces(' . $id_pea_docentes . ',' . $id_programa_ac . ')" title="Enlaces" class="pointer">Digitales</a></h4>
								</div>
							</div>
						</div>
						<div class="col-6 col-md-12 col-lg-12 col-xl-12 card py-2">
							<div class="row align-items-center">
								<div class="col-auto">
									<div class="avatar avatar-50 rounded bg-light-cyan">
										<i class="fa-brands fa-digital-ocean text-primary fa-2x"></i>
									</div>
								</div>
								<div class="col pt-2">
									<p class="small text-secondary mb-0">Ejercicios</p>
									<h4 class="fw-medium"><a onclick="ejercicios(' . $id_pea_docentes . ',' . $id_programa_ac . ')" title="Ejercicios" class="pointer">Generales</a></h4>
								</div>
							</div>
						</div>
						<div class="col-6 col-md-12 col-lg-12 col-xl-12 card py-2">
							<div class="row align-items-center">
								<div class="col-auto">
									<div class="avatar avatar-50 rounded bg-light-cyan">
										<i class="fa-solid fa-blog fa-2x text-primary"></i>
									</div>
								</div>
								<div class="col pt-2">
									<p class="small text-secondary mb-0">Palabras claves</p>
									<h4 class="fw-medium"><a onclick="glosario(' . $id_pea_docentes . ',' . $id_programa_ac . ')" title="Glosario" class="pointer">Glosario</a></h4>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>

			<div class="col-xl-9 col-12 timeline3 px-4">
				<div class="row justify-content-center">
					<div class="col-xl-10 col-12">
						<div class="row">
							<div class="col-12 pb-4">
								<h3 class="text-bold fs-18">Progreso</h3>
								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
										<span class="sr-only">60% Complete (warning)</span>
									</div>
								</div>
								
							</div>
							<div class="col-xl-12 col-12 pb-3">
								<ol>';

									$rspta = $estudiante->listar_temas($id_pea); //Consulta para ver los Temas del PEA
									$temanun=1;
									for ($i = 0; $i < count($rspta); $i++) {
										$conceptuales = $rspta[$i]["conceptuales"];
										$estado = $rspta[$i]["estado"];

										$data["0"] .=' 

												<div class="row timeline__event shadow-sm m-2">
													<div class="col-xl-2 col-12 timeline__event__icon bg-primary">
														<i class="lni-cake"></i>
														<div class="fs-18 text-white">
															Tema: '.$temanun++.'
														</div>
													</div>
													<div class="col-xl-10 col-12 timeline__event__content tono-3">
														<div class="timeline__event__description">
															<p>'.$conceptuales.'</p>
														</div>
													</div>
												</div>
										
										';
									}


									$data["0"] .= '
								</ol>
							</div>
						</div>
					</div>
				</div>
			
			</div>';

			$data["0"] .= '
		</div>
*/
		$results = array($data);
		echo json_encode($results);
	break;
	case 'descripcion':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_pea = $_POST["id_pea"];
		$datosdelpea = $estudiante->datospea($id_pea);
		$id_materia = $datosdelpea["id_materia"];
		$fecha_aprobacion = $datosdelpea["fecha_aprobacion"];
		$version = $datosdelpea["version"];
		$datosmateria = $estudiante->datosmateria($id_materia);
		$materia = $datosmateria["nombre"];
		$id_programa_ac = $datosmateria["id_programa_ac"];
		$semestre = $datosmateria["semestre"];
		$area = $datosmateria["area"];
		$creditos = $datosmateria["creditos"];
		$presenciales = $datosmateria["presenciales"];
		$independientes = $datosmateria["independiente"];
		$prerequisito = $datosmateria["prerequisito"];
		$datosprograma = $estudiante->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$datosescuela = $estudiante->datosescuela($id_escuela);
		$escuela = $datosescuela["escuelas"];
		if ($prerequisito == null) {
			$prerequisito = "";
		} else {
			$datosmateriapre = $estudiante->datosmateriapre($prerequisito);
			$prerequisito = $datosmateriapre["nombre"];
		}

		$data["0"] .= '<div class="col-12 text-right pb-3">
							<a href="estudiante.php"  title="Listado de materias">
								Listado de grupos
							</a>/ 
							<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
							/ Descripción
						</div>';


		$data["0"] .= '<div class="row justify-content-center tono-2 pt-4">';
		
		$data["0"] .= '<div class="col-xl-8 mt-2 p-0">';
		$data["0"] .= '<table class="table borde">';
		$data["0"] .= '<tr>';
		$data["0"] .= '<td><img src="../public/img/logo_print.jpg" width="150px"></td>';
		$data["0"] .= '<td><b>Fecha: </b>' . $fecha_aprobacion . '<br> <b>Versión: </b>' . $version . '</td>';
		$data["0"] .= '</tr>';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="col-xl-8 mt-1 p-0">';
		$data["0"] .= '<table class="table">';
		$data["0"] .= '<thead>';
		$data["0"] .= '<th colspan="2" class="bg-4 text-center text-white">PROYECTO EDUCATIVO DE AULA</th>';
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
		$data["0"] .= '<table class="table borde">';
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
		$data["0"] .= '<div class="borde col-12 bg-4 p-2 m-0 text-white text-center"> COMPETENCIA DE LA ASIGNATURA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
										' . $datosdelpea["competencias"] . '
									</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-4 p-2 m-0 text-white text-center"> RESULTADO DE APRENDIZAJE </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
						' . $datosdelpea["resultado"] . '
					</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-4 p-2 m-0 text-white text-center"> CRITERIOS DE EVALUACIÓN DE LA ASIGNATURA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
						' . $datosdelpea["criterio"] . '
					</div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-4 p-2 m-0 text-white text-center"> METODOLOGÍA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0"> 
							' . $datosdelpea["metodologia"] . '
						</div>';
		$data["0"] .= '</div>';
		/* consulta para teaer los temas */
		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-4 p-2 m-0 text-white text-center"> Contenidos </div>';
		$data["0"] .= '<ul>';
		$rspta = $estudiante->listar_temas($id_pea); //Consulta para ver los Temas del PEA
		for ($i = 0; $i < count($rspta); $i++) {
			$data["0"] .= '<li>' . $rspta[$i]["conceptuales"] . '</li>';
		}
		$data["0"] .= '</ul>';
		$data["0"] .= '</div>';
		/* **************************** */
		$data["0"] .= '<div class="borde col-xl-8 mt-4 p-0">';
		$data["0"] .= '<div class="borde col-12 bg-4 p-2 m-0 text-white text-center"> REFERENCIAS </div>';
		$data["0"] .= '<ul>';
		$rspta2 = $estudiante->verPeaReferencia($id_pea); //Consulta para ver los Temas del PEA
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
		$datosprograma = $estudiante->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$data["0"] .= '<div class="row justify-content-center">';
		$data["0"] .= '
				<div class="col-12 text-right pb-2">
					<a href="estudiante.php"  title="Listado de materias">
						Listado de materias
					</a>/ 
					<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
					/ Documentos
				</div>';
		/* consulta para teaer las carpetas */
		$rspta = $estudiante->verCarpetas($id_pea_docente); //Consulta para ver las carpetas
		for ($i = 0; $i < count($rspta); $i++) {
			if ($i == 0) {
				$colapso = "";
			} else {
				$colapso = "collapsed-card";
			}
			$data["0"] .= '
						<div class="col-12">
							<div class="card tono-2">
								<div class="card-header">
									<div class="row">

										<div class="col-xl-6 col-lg-6 col-md-6 col-6 py-1">
											<div class="row align-items-center">
												<div class="col-auto ">
													<span class="rounded bg-light-blue p-3 text-primary ">
														<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
													</span> 
												</div>
												<div class="col-auto">
													<div class="fs-14 line-height-18"> 
														<span class="">Recursos</span> <br>
														<span class="text-semibold fs-20">' . $rspta[$i]["carpeta"] . '</span> 
													</div> 
												</div>
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-6 py-1 text-right">
											<div class="card-tools">
												<button type="button" class="btn btn-tool" data-card-widget="collapse">
													<i class="fas fa-minus"></i>
												</button>
											</div>
										</div>

									</div>
								</div>
								<div class="card-body p-0 m-0">';




								$data["0"] .= '<div class="row p-2">';
								/* consulta para traer los documentos de cada carpeta */
								$rsptadoc = $estudiante->verPeaDocumentos($rspta[$i]["id_pea_documento_carpeta"],1111111111111111111111111111111); //Consulta para ver los Temas del PEA
								for ($j = 0; $j < count($rsptadoc); $j++) {
									$id_pea_documento = $rsptadoc[$j]["id_pea_documento"];
									$tipo_archivo = $rsptadoc[$j]["tipo_archivo"];
									$nombre_documento = $rsptadoc[$j]["nombre_documento"];
									$descripcion_documento = $rsptadoc[$j]["descripcion_documento"];
									$archivo_documento = $rsptadoc[$j]["archivo_documento"];
									$fecha_actividad=$rsptadoc[$j]["fecha_actividad"];
									$hora_actividad=$rsptadoc[$j]["hora_actividad"];

									switch ($tipo_archivo) {
										case '1':
											$icono_doc = '../files/pea/imagen.webp';
											$documento_tipo = "Imagen";
											$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
											$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn btn-sm  p-0">Descargar <i class="fa-solid fa-play"></i></a>';
											$bg="bg-light-blue";
											break;
										case '2':
											$icono_doc = '../files/pea/word.webp';
											$documento_tipo = "Word";
											$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
											$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn btn-sm  p-0">Descargar <i class="fa-solid fa-play"></i></a>';
											$bg="bg-light-yellow";
											break;
										case '3':
											$icono_doc = '../files/pea/excel.webp';
											$documento_tipo = "Excel";
											$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
											$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn btn-sm  p-0">Descargar <i class="fa-solid fa-play"></i></a>';
											$bg="bg-light-green";
											break;
										case '4':
											$icono_doc = '../files/pea/powerpoint.webp';
											$documento_tipo = "PowerPoint";
											$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
											$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn btn-sm  p-0">Descargar <i class="fa-solid fa-play"></i></a>';
											$bg="bg-light-red";
											break;
										case '5':
											$icono_doc = '../files/pea/pdf.webp';
											$documento_tipo = "PDF";
											$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
											$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn btn-sm  p-0">Descargar <i class="fa-solid fa-play"></i></a>';
											$bg="bg-light-purple";
											break;
										case '6':
											$icono_doc = '../files/pea/rar.webp';
											$documento_tipo = "Comprimido";
											$linkdescarga = "ciclo" . $ciclo . "/documentos/" . $archivo_documento;
											$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,1)" target="_blank" class="btn btn-sm  p-0">Descargar <i class="fa-solid fa-play"></i></a>';
											$bg="bg-light-orange";
											break;
										case '7':
											$icono_doc = '../files/pea/youtube.webp';
											$documento_tipo = "Video YOUTUBE";
											$linkdescarga = $archivo_documento;
											$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,2)" target="_blank" class="btn btn-sm  p-0">Ver Link <i class="fa-solid fa-play"></i></a>';
											$bg="bg-light-cyan";
											break;
										case '8':
											$icono_doc = '../files/pea/drive.webp';
											$documento_tipo = "Link DRIVE";
											$linkdescarga = $archivo_documento;
											$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,2)" target="_blank" class="btn btn-sm  p-0">Ver Link <i class="fa-solid fa-play"></i></a>';
											$bg="bg-light-yellow";
											break;
										case '9':
											$icono_doc = '../files/pea/meet.webp';
											$documento_tipo = "Link WEB";
											$linkdescarga = $archivo_documento;
											$btnlinkdescargar = '<a onclick="descargarDoc(`' . $linkdescarga . '`,`' . $id_pea_documento . '`,2)" target="_blank" class="btn btn-sm p-0">Ver Link <i class="fa-solid fa-play"></i></a>';
											$bg="bg-light-red";
											break;
									}


										$data["0"] .= '
									<div class="col-xl-4 col-12 p-3">
										<div class="row">
											<div class="col-12 col-md-12 col-lg-12 col-xxl-4 mb-4 column-set">
												<div class="card border-0 position-relative">
													<div class="coverimg2 position-absolute rounded" style="background-image: url('. $icono_doc . ');"></div>
													<div class="row">
														<div class="col-9 ">
															<div class=" border-0  shadow-none">
																<div class="card-body tono-3">
																	<div class="row">
																		<div class="col align-self-center">
																			<p class="fs-14 text-secondary mb-0">' . $nombre_documento . '</p>
																			<p>' . $descripcion_documento . '</p>
																			<div class="mt-3">
																				<div class="progress h-5 mb-1 bg-light-theme">
																					<div class="progress-bar bg-theme" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
																				</div>
																			</div>
																			<p class="small text-secondary">Pub: '.$estudiante->fechacorta($fecha_actividad).'</p>
																		</div>
																		<div class="col-auto '.$bg.'">
																			<div class="rounded bg-theme h-100 p-3">
																				<p class=" fs-14 mb-1">
																					Tipo<br>Documento
																				</p>
																				<p class=" font-weight-bolder">' . $documento_tipo . '</p>
																				<p>' . $btnlinkdescargar . '</p>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>';






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
		$datosprograma = $estudiante->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$data["0"] .= '<div class="row justify-content-center">';
		$data["0"] .= '
		<div class="col-12 text-right">
			<a href="estudiante.php"  title="Listado de materias">
				Listado de materias
			</a>/ 
			<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
			/ Ejercicios
		</div>';
		/* consulta para teaer las carpetas */
		$rspta = $estudiante->verCarpetasEjercicios($id_pea_docente); //Consulta para ver llas carpetas
		for ($i = 0; $i < count($rspta); $i++) {
			if ($i == 0) {
				$colapso = "";
			} else {
				$colapso = "collapsed-card";
			}
			$data["0"] .= '


				<div class="col-12">
					<div class="card tono-2">
						<div class="card-header">
							<div class="row">

								<div class="col-xl-6 col-lg-6 col-md-6 col-7 py-1">
									<div class="row align-items-center">
										<div class="col-auto ">
											<span class="rounded bg-light-blue p-3 text-primary ">
												<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
											</span> 
										</div>
										<div class="col-auto">
											<div class="fs-14 line-height-18"> 
												<span class="">Ejercicios</span> <br>
												<span class="text-semibold fs-20">' . $rspta[$i]["carpeta_ejercicios"] . '</span> 
											</div> 
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-7 py-1 text-right">
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>

							</div>
						</div>
						<div class="card-body p-0 m-0">';



			$data["0"] .= '<div class="row p-2">';
			/* consulta para traer los documentos de cada carpeta */
			$rsptadoc = $estudiante->verPeaDocumentosEjercicios($rspta[$i]["id_pea_ejercicios_carpeta"]); //Consulta para ver los Temas del PEA
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
				$traerarchivoestudiante = $estudiante->taerArchivoEstudiante($id_pea_ejercicios, $_SESSION['id_estudiante_programa']);
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
							$botonenviar = '<small title="Fecha de publicación">' . $estudiante->fechaesp($traerarchivoestudiante["fecha_enviado"]) . '</small>';
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
										<div class="post-module ">
											<div class="thumbnail">
												' . $diaevento . '
												<img src="' . $icono_doc . '" alt="Ejercicio">
											</div>
											<div class="post-content tono-3">
												' . $categoria . '
												<h1 class="fs-24">' . $nombre_ejercicios . '</h1>
												<p class="text-danger">Hasta: ' . $estudiante->fechaesp($fecha_entrega) . '</p>
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
		$rspta2 = $estudiante->listar_temas($id_pea);
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
			$rspta3 = $estudiante->listar_actividades($id_tema, $id_docente_grupo);
			$reg3 = $rspta3;
			for ($k = 0; $k < count($reg3); $k++) {
				$id_pea_actividades = $reg3[$k]["id_pea_actividades"];
				$nombre_actividad = $reg3[$k]["nombre_actividad"];
				$descripcion_actividad = $reg3[$k]["descripcion_actividad"];
				$fecha_actividad = $reg3[$k]["fecha_actividad"];
				$pic_archivo = $estudiante->tipoarchivo($reg3[$k]["tipo_archivo"]);
				$icono = $pic_archivo["icono"];
				$data["0"] .= '
						<div class="row">
							<div class="col-xl-6 col-md-6 col-sm-6 col-12">
								<div class="info-box">
								<span class="info-box-icon bg-info">' . $icono . '</span>
	
								<div class="info-box-content">
									<span class="info-box-text">' . $nombre_actividad . '</span>
									<span class="info-box-text">' . $descripcion_actividad . '</span>
									<span class="info-box-number"><i>Publicado: ' . $estudiante->fechaesp($fecha_actividad) . '</i></span>';

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
		$rspta = $estudiante->listar($id_estudiante, $ciclo, $grupo);
		$reg = $rspta;
		$rspta2 = $estudiante->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$inicio_cortes = 1;

		if ($ciclo == 9) {

			$homologados = $estudiante->docente_grupo_horario($id_estudiante);
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
				$buscaridmateria = $estudiante->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
				$idmateriaencontrada = $buscaridmateria["id"];
				$rspta3 = $estudiante->docente_grupo_calendario($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
				for ($j = 0; $j < count($rspta3); $j++) {
					@$id_docente = $rspta3[$j]["id_docente"];
					@$id_docente_grupo = $rspta3[$j]["id_docente_grupo"];
					@$id_materia = $rspta3[$j]["id_materia"];
					@$salon = $rspta3[$j]["salon"];
					@$diasemana = $rspta3[$j]["dia"];
					@$horainicio = $rspta3[$j]["hora"];
					@$horafinal = $rspta3[$j]["hasta"];
					@$corte = $rspta3[$j]["corte"];
					$datosmateria = $estudiante->BuscarDatosAsignatura($id_materia);
					@$nombre_materia = $datosmateria["nombre"];
					if ($id_docente == null) {
						$nombre_docente = "Sin Asignar";
					} else {
						$datosdocente = $estudiante->docente_datos($id_docente);
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
		$insertardescarga = $estudiante->insertarDescarga($id_pea_documento, $_SESSION['id_usuario'], $fecha, $hora);
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
		$datosprograma = $estudiante->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$data["0"] .= '
		<div class="row m-0 p-0">';

			$data["0"] .= '
			<div class="col-xl-6 col-lg-6 col-md-6 col-6 py-3">
				<div class="row align-items-center">
					<div class="col-auto ">
						<span class="rounded bg-light-blue p-3 text-primary ">
							<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
						</span> 
					</div>
					<div class="col-auto">
						<div class="fs-14 line-height-18"> 
							<span class="">Enalces</span> <br>
							<span class="text-semibold fs-20">de apoyo</span> 
						</div> 
					</div>
				</div>
			</div>';

			$data["0"] .= '
			<div class="col-xl-6 col-6 text-right pr-2">
				<a href="estudiante.php"  title="Listado de materias">
					Listado de materias
				</a>/ 
				<a onclick="volverContenidos()" class="btn btn-link btn-sm text-primary"> Contenidos </a>
				/ Enlaces
			</div>';



			$data["0"] .= '
	
			<div class="col-12 col-md-12 col-lg-12 col-xl-6 mb-4">
				<div class="icon-container" >
					<div class="center-icon">
						
						<img src="https://wowdash.wowtheme7.com/bundlelive/assets/images/icons/banner-features-icon0.png" alt="" class="shadow-sm rounded-circle">
					</div>
					<div id="orbit-icons">';


					$fondobg = [
						"bg-maroon",
						"bg-navy",
						"bg-fuchsia",
						"bg-pink",
						"bg-purple",
						"bg-lightblue",
						"bg-teal",
						"bg-olive",
						"bg-primary",
						"bg-success",
						"bg-danger",
						"bg-warning",
						"bg-info",
						"bg-dark",
						"bg-orange"
					  ];
					  
					  

						$rspta = $estudiante->verEnlaces($id_pea_docente); //Consulta para ver los enlaces
						for ($i = 0; $i < count($rspta); $i++) {
							$id_pea_enlaces = $rspta[$i]["id_pea_enlaces"];
							$titulo_enlace = $rspta[$i]["titulo_enlace"];
							$descripcion = $rspta[$i]["descripcion_enlace"];
							$enlace = $rspta[$i]["enlace"];
							$fecha = $rspta[$i]["fecha_enlace"];
							$hora = $rspta[$i]["hora_enlace"];
							$data["0"] .= '
								
								<div class="orbit-icon '.$fondobg[$i] .' shadow-sm">
									<img><p class="p-0 m-0"><span class="bg-white px-1 rounded-circle"><i class="fas fa-globe"></i></span> <a href="'.$enlace.'" target="_blank" class="text-white">'.$titulo_enlace.'</a></p>
								</div>	
									
								';

						}

						$data["0"] .= '
					</div>
				</div>
			
		</div>';
		
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
		$datosprograma = $estudiante->programaacademico($id_programa_ac);
		$programa_ac = $datosprograma["nombre"];
		$id_escuela = $datosprograma["escuela"];
		$ciclo = $datosprograma["ciclo"];
		$data["0"] .= '<div class="row">';
		$data["0"] .= '
			<div class="col-12 text-right">
				<a href="estudiante.php"  title="Listado de materias">
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
		$verglosario = $estudiante->verGlosario($id_pea_docente);
		$reg = $verglosario;
		for ($i = 0; $i < count($reg); $i++) {
			$id_pea_glosario = $reg[$i]["id_pea_glosario"];
			$titulo = $reg[$i]["titulo_glosario"];
			$definicion_glosario = $reg[$i]["definicion_glosario"];
			$fecha_glosario = $reg[$i]["fecha_glosario"];
			$hora_glosario = $reg[$i]["hora_glosario"];
			$fecha = $estudiante->fechaesp($fecha_glosario);
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
		$traerNombreEjercicio = $estudiante->traerNombreEjecicio($id_pea_ejercicios_global);
		$nombre_ejercicios = $traerNombreEjercicio["nombre_ejercicios"];
		$traerid_pea_docentes = $estudiante->traeridpeadocente($id_pea_docente_global);
		// var_dump($id_pea_docente_global);
		$traeredatosdocentegrupos = $estudiante->comprobar($traerid_pea_docentes["id_docente_grupo"]);
		$ciclo = $traeredatosdocentegrupos["ciclo"];
		$id_programa = $traeredatosdocentegrupos["id_programa"];
		$id_docente = $traeredatosdocentegrupos["id_docente"];
		$datos_docente = $estudiante->docente_datos($id_docente);
		$usuario_login = $datos_docente["usuario_login"];
		$datos_estudiante = $estudiante->estudiante_datos($id_credencial);
		$nombre_estudiante = $datos_estudiante["credencial_nombre"] . " " . $datos_estudiante["credencial_nombre_2"] . " " . $datos_estudiante["credencial_apellido"] . " " . $datos_estudiante["credencial_apellido_2"];
		$credencial_login = $datos_estudiante["credencial_login"];
		//$credencial_login = "ja.perez30@ciaf.edu.co";
		$credencial_identificacion = $datos_estudiante["credencial_identificacion"];
		$datos_estudiante = $estudiante->estudiante_datos_personales($id_credencial);
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
			// $id_estudiante = $_POST["id_estudiante"]; // id del estudiante
			// $ciclo = $_POST["ciclo"]; // ciclo
			// $id_programa = $_POST["id_programa"]; // programa del estudiante
			// $grupo = $_POST["grupo"]; // programa del estudiante
			$impresion = "";
			$control=1;
			$buscarprogramasmatriculados=$estudiante->listarmatriculados($id_credencial,$periodo_actual);
			
			$impresion .= '[';
			for ($a = 0; $a < count($buscarprogramasmatriculados); $a++) {// lista los programa matriculados

				
				
				// if(count($buscarprogramasmatriculados)==1){// si solo tiene un programa matriculado en el periodo

				
					$id_estudiante=$buscarprogramasmatriculados[$a]["id_estudiante"];
					$ciclo=$buscarprogramasmatriculados[$a]["ciclo"];
					$grupo=$buscarprogramasmatriculados[$a]["grupo"];
					$id_programa=$buscarprogramasmatriculados[$a]["id_programa_ac"];

					
						$rspta = $estudiante->listar($id_estudiante, $ciclo, $grupo);
						$reg = $rspta;
						$rspta2 = $estudiante->programaacademico($id_programa);
						$cortes = $rspta2["cortes"];
						$inicio_cortes = 1;
			
						
						for ($i = 0; $i < count($reg); $i++) {
							$buscaridmateria = $estudiante->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
							$idmateriaencontrada = $buscaridmateria["id"];
							$rspta3 = $estudiante->docente_grupo_calendario($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
							
							for ($j = 0; $j < count($rspta3); $j++) {
								if($rspta3){

									if ($a>0) {
										$impresion .= ',';
									}

									if ($i>0) {
										$impresion .= ',';
									}

									if($j==1){
									$impresion .= ',';
								}
									// id docente grupo especial
									$id_docente_grupo_esp = $reg[$i]["id_docente_grupo_esp"];
									$rspta4 = $estudiante->docente_grupo_por_id($id_docente_grupo_esp);
									// si existe registro
									$resultadorspta4 = $rspta4 ? 1 : 0;

									if($resultadorspta4==1){// si es un grupo especial
										@$id_docente = $rspta4["id_docente"];
										@$id_docente_grupo = $rspta4["id_docente_grupo"];
										@$id_materia = $rspta4["id_materia"];
										@$salon = $rspta4["salon"];
										@$diasemana = $rspta4["dia"];
										@$horainicio = $rspta4["hora"];
										@$horafinal = $rspta4["hasta"];
										@$corte = $rspta4["corte"];
									}else{
										@$id_docente = $rspta3[$j]["id_docente"];
										@$id_docente_grupo = $rspta3[$j]["id_docente_grupo"];
										@$id_materia = $rspta3[$j]["id_materia"];
										@$salon = $rspta3[$j]["salon"];
										@$diasemana = $rspta3[$j]["dia"];
										@$horainicio = $rspta3[$j]["hora"];
										@$horafinal = $rspta3[$j]["hasta"];
										@$corte = $rspta3[$j]["corte"];
									}


									$datosmateria = $estudiante->BuscarDatosAsignatura($id_materia);
									@$nombre_materia = $datosmateria["nombre"];



									if ($id_docente == null) {
										$nombre_docente = "Sin Asignar";
									} else {
										$datosdocente = $estudiante->docente_datos($id_docente);
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

	case 'iniciarhorario':
		
		$notascortes="";
		$impresion = "[";
		$buscarprogramasmatriculados = $estudiante->listarmatriculados($id_credencial, $periodo_actual);
	
		for ($a = 0; $a < count($buscarprogramasmatriculados); $a++) {
			 
			$id_estudiante = $buscarprogramasmatriculados[$a]["id_estudiante"];
			$ciclo = $buscarprogramasmatriculados[$a]["ciclo"];
			$grupo = $buscarprogramasmatriculados[$a]["grupo"];
			$id_programa = $buscarprogramasmatriculados[$a]["id_programa_ac"];

			$inicio_cortes=1;
	
			$reg = $estudiante->listar($id_estudiante, $ciclo, $grupo);
			$cortes = $estudiante->programaacademico($id_programa)["cortes"];
	
			for ($i = 0; $i < count($reg); $i++) {
				$idmateriamaterias=$reg[$i]["id_materia"]; //este es el id de la materia de la tabla materias
				$id_pea=$reg[$i]["id_pea"]; //este es el id del pea de la tabla materia del estudiante
				$buscaridmateria = $estudiante->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
				$idmateriaencontrada = $buscaridmateria["id"];
	
				$id_docente_grupo_esp = $reg[$i]["id_docente_grupo_esp"];
				if($id_docente_grupo_esp==""){// si no hay docente con grupo especial
					$rspta3 = $estudiante->docente_grupo_calendario($idmateriaencontrada,$reg[$i]["jornada"],$reg[$i]["periodo"],$reg[$i]["semestre"],$id_programa,$grupo);
				}else{// si es grupo especial
					$rspta3 = $estudiante->docente_grupo_por_id($id_docente_grupo_esp);
					
				}
				
	
				for ($j = 0; $j < count($rspta3); $j++) {
					
					// if ($rspta3) {
						// Verificar si es grupo especial
						
						
	
						if ($id_docente_grupo_esp!="") {
							@$id_docente = $rspta3[$j]["id_docente"];
							@$id_materia = $rspta3[$j]["id_materia"];
							@$salon = $rspta3[$j]["salon"];
							@$diasemana = $rspta3[$j]["dia"];
							@$horainicio = $rspta3[$j]["hora"];
							@$horafinal = $rspta3[$j]["hasta"];
							@$corte = $rspta3[$j]["corte"];
							@$corte_clase=$rspta3[$j]["corte"];

							if ($id_pea == null) { // si el estudiante no tiene PEA
								$rsptatienepea = $estudiante->docente_pea($id_docente_grupo_esp);
								$tienepea = $rsptatienepea ? 1 : 0; // si existe registro
								if ($tienepea == 1) {
									$botonpea = '<a onclick=validar_pea(' . $ciclo . ',' . $idmateriamaterias . ',' . $id_docente_grupo_esp . ') class="btn btn-secondary btn-xs text-white" title="Plan Educativo sin Activar">Activar</a>';
								} else { // no tiene pea
									$botonpea = "";
								}
							} else { // si ya tiene pea
								$botonpea = '<a onclick=verPanel(' . $id_docente_grupo_esp . ') class="btn btn-success btn-xs text-white" title="Plan Educativo de Aula"><i class="fa-solid fa-eye"></i> PEA</a>';
							}

							if($cortes==3){
								$nota1=$reg[$i]["c1"];
								$nota2=$reg[$i]["c2"];
								$nota3=$reg[$i]["c3"];
								$promedio=$reg[$i]["promedio"];
								$faltas=$reg[$i]["faltas"];
							}else{
								$nota1=$reg[$i]["c1"];
								$promedio=$reg[$i]["promedio"];
								$faltas=$reg[$i]["faltas"];
							}
							

						} else {
							@$id_docente = $rspta3[$j]["id_docente"];
							@$id_materia = $rspta3[$j]["id_materia"];
							@$salon = $rspta3[$j]["salon"];
							@$diasemana = $rspta3[$j]["dia"];
							@$horainicio = $rspta3[$j]["hora"];
							@$horafinal = $rspta3[$j]["hasta"];
							@$corte = $rspta3[$j]["corte"];
							@$id_docente_grupo = $rspta3[$j]["id_docente_grupo"];
							@$corte_clase=$rspta3[$j]["corte"];

							if ($id_pea == null) { // si el estudiante no tiene PEA
								$rsptatienepea = $estudiante->docente_pea($id_docente_grupo);
								$tienepea = $rsptatienepea ? 1 : 0; // si existe registro
								if ($tienepea == 1) {
									$botonpea = '<a onclick=validar_pea(' . $ciclo . ',' . $idmateriamaterias . ',' . $id_docente_grupo . ') class="btn btn-secondary btn-xs text-white" title="Plan Educativo sin Activar 121212">Activar</a>';
								} else { // no tiene pea
									$botonpea = "";
								}
							} else { // si ya tiene pea
								$botonpea = '<a onclick=verPanel(' . $id_docente_grupo . ') class="btn btn-success btn-xs text-white" title="Plan Educativo de Aula"><i class="fa-solid fa-eye"></i> PEA</a>';
							}

							
							if($cortes == 3){
								$nota1=$reg[$i]["c1"];
								$nota2=$reg[$i]["c2"];
								$nota3=$reg[$i]["c3"];
								$promedio=$reg[$i]["promedio"];
								$faltas=$reg[$i]["faltas"];
							}else{
								$nota1=$reg[$i]["c1"];
								$promedio=$reg[$i]["promedio"];
								$faltas=$reg[$i]["faltas"];
							}

						}
						
						
						$datosmateria = $estudiante->BuscarDatosAsignatura($id_materia);
						@$nombre_materia = ucwords(strtolower($datosmateria["nombre"]));

	
						if ($id_docente == null) {
							$nombre_docente = "Sin Asignar";
							$destacado="";
							$foto = '<img src=../files/null.jpg width=50px height=50px class=img-circle>';
						} else {
							$datosdocente = $estudiante->docente_datos($id_docente);
							$nombre_docente = strtoupper($datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_apellido"]);
							$influencer=$datosdocente["influencer_mas"];

							if (file_exists('../files/docentes/' . $datosdocente["usuario_identificacion"] . '.jpg')) {
								$foto = '<img src=../files/docentes/' . $datosdocente["usuario_identificacion"] . '.jpg width=50px height=50px class=img-circle>';
							} else {
								$foto = '<img src=../files/null.jpg width=50px height=50px class=img-circle>';
							}

							$docdestacado= $estudiante->docenteDestacado($datosdocente["usuario_identificacion"],$periodo_anterior);
							if($docdestacado["ponderado"]>=94.56){
								$destacado='<i class="fa-solid fa-star fs-24 text-warning pointer" style="position:absolute;margin-top:-15px; margin-left:-10px" title="Docente Estrella"></i>';
							}else{
								$destacado="";
							}

							if($influencer == 1){
								$influencermas='<span title="Influencer +"  style="position:absolute;margin-top:8px; margin-left:-2px"><i class="fa-solid fa-heart text-danger fs-24 pointer"></i></span>';
							}else{
								$influencermas='';
							}

						}
	

						// Día de la semana como número
						switch ($diasemana) {
							case 'Lunes': $dia = 1; break;
							case 'Martes': $dia = 2; break;
							case 'Miercoles': $dia = 3; break;
							case 'Jueves': $dia = 4; break;
							case 'Viernes': $dia = 5; break;
							case 'Sabado': $dia = 6; break;
							case 'Domingo': $dia = 0; break;
						}

	
						$color = ($corte == "1") ? "#FFF" : "#252e53";
	
						// Agregar coma si no es el primer elemento
						if ($impresion != "[") {
							$impresion .= ",";
						}
	
						$impresion .= json_encode([
							"materia" => $nombre_materia,
							"salon" => $salon,
							"docente" => $nombre_docente,
							"daysOfWeek" => $dia,
							"startTime" => $horainicio,
							"endTime" => $horafinal,
							"color" => $color,
							"pea" => $botonpea,
							"foto" => $foto,
							"destacado" => $destacado,
							"cortes" => $cortes,
							"nota1" => $nota1,
							"nota2" => $nota2,
							"nota3" => $nota3,
							"promedio" => $promedio,
							"faltas" => $faltas,
							"corte_clase" => $corte_clase,
							"influencer" => $influencermas,
						]);
					// }
				}
			}
		}
	
		$impresion .= ']';

		
		echo $impresion;
	break;

	case 'agregarrecurso':
		$data = [];
		$data["data1"] = "";
		$data["opciones"]="";

		$id_tema = $_POST["id_tema"];
		$id_pea_docente = $_POST["id_pea_docente"];

		$ciclo = $_POST["ciclo"];

		$data["data1"] .= $mensaje = "3";

		$documentos = $estudiante->verPeaDocumentos($id_pea_docente, $id_tema);
		foreach ($documentos as &$documento) {
			$documento['tipo'] = 'documento';
			$documento['fecha_completa'] = $documento['fecha_actividad'] . ' ' . $documento['hora_actividad'];
		}

		// Obtener enlaces y glosario
		$enlaces = $estudiante->verEnlacesTema($id_pea_docente, $id_tema);
		foreach ($enlaces as &$enlace) {
			$enlace['tipo'] = 'enlace';
			$enlace['fecha_completa'] = $enlace['fecha_enlace'] . ' ' . $enlace['hora_enlace'];
		}

		$glosarios = $estudiante->verGlosarioTema($id_pea_docente, $id_tema);
		foreach ($glosarios as &$glosario) {
			$glosario['tipo'] = 'glosario';
			$glosario['fecha_completa'] = $glosario['fecha_glosario'] . ' ' . $glosario['hora_glosario'];
		}

		$videos = $estudiante->verVideoTema($id_pea_docente, $id_tema);
		foreach ($videos as &$video) {
			$video['tipo'] = 'video';
			$video['fecha_completa'] = $video['fecha_video'] . ' ' . $video['hora_video'];
		}

		// Mezclar y ordenar todos los recursos
		$recursos = array_merge($documentos, $enlaces, $glosarios, $videos);
		usort($recursos, function($a, $b) {
			return strtotime($a['fecha_completa']) - strtotime($b['fecha_completa']);
		});

		
		function getYoutubeId($url) {
			preg_match('/(youtu\.be\/|v=)([a-zA-Z0-9_-]{11})/', $url, $matches);
			return $matches[2] ?? null;
		}

		function getYoutubeThumbnail($url, $size = 'default') {
			$id = getYoutubeId($url);
			if (!$id) return null;
			return "https://img.youtube.com/vi/$id/$size.jpg"; // default, mqdefault, hqdefault, maxresdefault
		}

		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];

		// Construcción HTML
		$mifila=1;
		foreach ($recursos as $recurso) {
			if ($recurso['tipo'] === 'documento') {// si es un documento

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

				$terminodocumento="no";
				$puntos_otorgados_documento=0;

				if($recurso["condicion_finalizacion_documento"] == 2 ) {// si el estudiante debe marcar como finalizado traer los puntos que le dieron
					$validarentregadoc=$estudiante->validarentregadocumento($ciclo,$id_pea_docente,$recurso["id_pea_documento"],$id_tema,$id_estudiante);
					$puntos_otorgados_documento=$validarentregadoc["puntos_otorgados"];
				}

				if($recurso["condicion_finalizacion_documento"] == 3 && $recurso["tipo_condicion_documento"] == 1) {// si debe entregar algo y es un archivo
					$validarentregadoc=$estudiante->validarentregadocumento($ciclo,$id_pea_docente,$recurso["id_pea_documento"],$id_tema,$id_estudiante);
					$puntos_otorgados_documento=$validarentregadoc["puntos_otorgados"];

						if($validarentregadoc){// validar si ya subio el archivo el estudiante
							$botonenviararchivo='<a class="btn btn-success btn-xs" href="../files/pea/ciclo'.$ciclo.'/ejerciciosest/'.$validarentregadoc["archivo_ejercicio"].'" target="_blank">Ver entrega</a>';	
						}else{
							if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_documento"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_documento"])) {
								$botonenviararchivo='<a class="btn bg-orange btn-xs" onclick="enviarEjercicios(' .$recurso['id_pea_documento']. ','.$mifila.')"><i class="fa-solid fa-cloud-arrow-up"></i>Enviar taller</a>';
							}else{
								$botonenviararchivo = '';
							}
							
							
						}
						
				}else{
					$botonenviararchivo="";
				}

				if($recurso["condicion_finalizacion_documento"] == 3 && $recurso["tipo_condicion_documento"] == 2) {// entregar un archivo pero con link
					$validarentregadocumentolink=$estudiante->validarentregadocumento($ciclo,$id_pea_docente,$recurso["id_pea_documento"],$id_tema,$id_estudiante);
					
						if($validarentregadocumentolink){// validar si ya subio el archivo el estudiante
							$puntos_otorgados_documento=$validarentregadocumentolink["puntos_otorgados"];
							$botonenviardocumento='<a class="btn bg-success btn-xs" href="'.$validarentregadocumentolink["link_archivo"].'" target="_blank")"> Ver entrega</a>';
						}else{
							if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_documento"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_documento"])) {
								$botonenviardocumento='<a class="btn bg-orange btn-xs" onclick="enviarEnlaceDocumento(' .$recurso["id_pea_documento"]. ','.$mifila.')"><i class="fa-solid fa-cloud-arrow-up"></i> Enviar Link</a>';
							} else {
								$botonenviardocumento= '';
								
							}
						}
					
				}else{
					$botonenviardocumento="";
				}

				if($recurso["condicion_finalizacion_documento"] == 3 && $recurso["tipo_condicion_documento"] == 3) {// si debe entregar archivo  y es un mensaje
					$validarentregadocumentomensaje=$estudiante->validarentregadocumento($ciclo,$id_pea_docente,$recurso["id_pea_documento"],$id_tema,$id_estudiante);
					
						if($validarentregadocumentomensaje){// validar si ya subio el archivo el estudiante
							$puntos_otorgados_documento=$validarentregadocumentomensaje["puntos_otorgados"];
							$botonenviarmensaje='<a class="btn bg-success btn-xs" onclick="verDocumentoMensaje(' .$validarentregadocumentomensaje["id_pea_ejercicios_est"]. ',' .$recurso["id_pea_documento"]. ')"> Ver Mensaje</a>';
						}else{
							if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_documento"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_documento"])) {
								$botonenviarmensaje='<a class="btn bg-orange btn-xs" onclick="enviardocumentoMensaje(' .$recurso["id_pea_documento"]. ','.$mifila.')"><i class="fa-solid fa-cloud-arrow-up"></i> Enviar Mensaje</a>';
						
							} else {
								$botonenviarmensaje= '';
								
							}
						}
					
				}else{
					$botonenviarmensaje="";
				}

				
				if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_documento"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_documento"])) {
					$terminodocumento="no";
				}else{
					$terminodocumento="si";
				}

				// $descargasdoc = $estudiante->descargasDoc($id_pea_documento);
				// $totaldescargas = count($descargasdoc);

				
				$data["opciones"] .= '

				<div class="col-12 my-2 " id="mifila'.$mifila.'">
					<div class="row justify-content-center align-items-center">
						<div class="col-1 text-center">
						' . $documento_tipo . ' 
						</div>
						<div class="col-11 border-bottom pb-3">
							<div class="row">
								<div class="col-12">
									<div class="row">
										<div class="col-auto" >
											<button class="btn btn-sm dropdown-toggle semibold titulo-2 fs-12 p-0 m-0" type="button" data-toggle="dropdown" aria-expanded="false">
												<i class="fa-solid fa-ellipsis-vertical"></i>
											</button>
											<div class="dropdown-menu" >
												<a class="dropdown-item" onclick="informacionDoc(' . $recurso["id_pea_documento"] . ','.$mifila.')">Abrir detalles</a>
												' . $linkdescarga . '
											</div>
										</div>
										<div class="col-10">
											'.$botonenviararchivo.' ' . $botonenviardocumento . ' ' . $botonenviarmensaje . '
											<span class="text-semibold">' . ucfirst(strtolower(htmlspecialchars($recurso["nombre_documento"]))) . '</span>
										</div>
									</div>
								</div>';

								if(strtotime($fecha) < strtotime($recurso["fecha_inicio_documento"])){
									$data["opciones"] .= '<div class="col-12 fs-18"><i class="fa-solid fa-hourglass-half"></i> Proximamente</div>';
								}else{

									if($terminodocumento=="no"){
										$data["opciones"] .= '
									<div class="col-12">
										<div class="row">
											<div class="col-8">
													<span class="titulo-2 fs-12">Desde: ' . $estudiante->fechaespsinano($recurso["fecha_inicio_documento"]) . '</span><br>
												<span class="titulo-2 fs-12">Hasta: ' . $estudiante->fechaespsinano($recurso["fecha_limite_documento"]) . '</span>
											</div>
											<div class="col-2 text-center">	
												<span>Porcentaje</span><br>
												<span>' . $recurso["porcentaje_documento"] . '%</span>
											</div>
											<div class="col-2 text-right">	
												<span>Puntos</span><br>
												<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
												<span>' . $recurso["puntos_actividad_documento"] . ' Pts.</span>
											</div>
											</div>

										</div>
									</div>';
									}else{
											$data["opciones"] .= '
										<div class="col-12">
											<div class="row">
												<div class="col-4">
													<span class="titulo-2 fs-12"><i class="fa-solid fa-lock text-danger"></i> Termino: ' . $estudiante->fechaespsinano($recurso["fecha_limite_documento"]) . '</span>
												</div>
												<div class="col-8 text-right">	
													<span><i class="fa-solid fa-check-double"></i> </span><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
													<span>' . $puntos_otorgados_documento . ' Pts.</span>
												</div>
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
				

			

			} elseif ($recurso['tipo'] === 'enlace') { // si es un elace

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

				
				$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
				$id_estudiante=$datos_delid_usuario["id_estudiante"];

				$terminotarea="no";
				$puntos_otorgados_enlace=0;

				if($recurso["condicion_finalizacion_enlace"] == 2 ){// si el estudiante debe marcar como finalizado traer los puntos que le dieron
					$validarentregaenlacelink=$estudiante->validarentregaenlace($ciclo,$id_pea_docente,$recurso["id_pea_enlaces"],$id_tema,$id_estudiante);
					$puntos_otorgados_enlace=$validarentregaenlacelink["puntos_otorgados"];
				}


				if($recurso["condicion_finalizacion_enlace"] == 3 && $recurso["tipo_condicion_enlace"] == 1){// si debe entregar algo y es un archivo
					$validarentregaenlace=$estudiante->validarentregaenlace($ciclo,$id_pea_docente,$recurso["id_pea_enlaces"],$id_tema,$id_estudiante);
					
						if($validarentregaenlace){// validar si ya subio el archivo el estudiante
							$puntos_otorgados_enlace=$validarentregaenlace["puntos_otorgados"];
							$botonenviararchivo='<a class="btn btn-success btn-xs" href="../files/pea/ciclo'.$ciclo.'/enlacesest/'.$validarentregaenlace["archivo_ejercicio"].'" target="_blank">Ver entrega</a>';	
						}else{
							if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_enlace"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_enlace"])) {
								$botonenviararchivo='<a class="btn bg-orange btn-xs" onclick="enviarEnlace(' .$recurso["id_pea_enlaces"]. ','.$mifila.')"><i class="fa-solid fa-cloud-arrow-up"></i>Enviar taller</a>';
							} else {
								$botonenviararchivo = '';
								
							}
							
						}
						
				}else{
					$botonenviararchivo="";
				}


				if($recurso["condicion_finalizacion_enlace"] == 3 && $recurso["tipo_condicion_enlace"] == 2){// si debe entregar algo y es un link donde esta el taller
					$validarentregaenlacelink=$estudiante->validarentregaenlace($ciclo,$id_pea_docente,$recurso["id_pea_enlaces"],$id_tema,$id_estudiante);
					
						if($validarentregaenlacelink){// validar si ya subio el archivo el estudiante
							$puntos_otorgados_enlace=$validarentregaenlacelink["puntos_otorgados"];
							$botonenviarenlace='<a class="btn bg-success btn-xs" href="'.$validarentregaenlacelink["link_archivo"].'" target="_blank")"> Ver entrega</a>';
						}else{
							if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_enlace"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_enlace"])) {
								$botonenviarenlace='<a class="btn bg-orange btn-xs" onclick="enviarEnlaceLink(' .$recurso["id_pea_enlaces"]. ','.$mifila.')"><i class="fa-solid fa-cloud-arrow-up"></i> Enviar Enlace</a>';
							} else {
								$botonenviarenlace= '';
								
							}
						}
					
				}else{
					$botonenviarenlace="";
				}

				if($recurso["condicion_finalizacion_enlace"] == 3 && $recurso["tipo_condicion_enlace"] == 3){// si debe entregar un enlace y es un mensaje
					$validarentregaenlacemensaje=$estudiante->validarentregaenlace($ciclo,$id_pea_docente,$recurso["id_pea_enlaces"],$id_tema,$id_estudiante);
					
						if($validarentregaenlacemensaje){// validar si ya subio el archivo el estudiante
							$puntos_otorgados_enlace=$validarentregaenlacemensaje["puntos_otorgados"];
							$botonenviarmensaje='<a class="btn bg-success btn-xs" onclick="verEnlaceMensaje(' .$validarentregaenlacemensaje["id_pea_enlaces_est"]. ','.$recurso["id_pea_enlaces"].')"> Ver Mensaje</a>';
						}else{
							if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_enlace"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_enlace"])) {
								$botonenviarmensaje='<a class="btn bg-orange btn-xs" onclick="enviarEnlaceMensaje(' .$recurso["id_pea_enlaces"]. ','.$mifila.')"><i class="fa-solid fa-cloud-arrow-up"></i> Enviar Mensaje</a>';
						
							} else {
								$botonenviarmensaje= '';
								
							}
						}
					
				}else{
					$botonenviarmensaje="";
				}



				if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_enlace"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_enlace"])) {
					$terminotarea="no";
				}else{
					$terminotarea="si";
				}

				

				
					$data["opciones"] .= '
				<div class="col-12 my-2" id="mifila'.$mifila.'">
					<div class="row justify-content-center align-items-center">
						<div class="col-1 text-center">
							<i class="fa-solid fa-link fa-2x"></i></i>
						</div>
						<div class="col-11 border-bottom pb-3">
							<div class="row">
								<div class="col-12">
									<div class="row">
										<div class="dropdown" style="width:20px">
											<button class="btn btn-sm dropdown-toggle semibold titulo-2 fs-12 p-0 m-0" type="button" data-toggle="dropdown" aria-expanded="false">
												<i class="fa-solid fa-ellipsis-vertical"></i>
											</button>
											<div class="dropdown-menu" style="">
												<a class="dropdown-item" onclick="informacionEnlace(' . $recurso["id_pea_enlaces"] . ','.$mifila.')">Abrir detalles</a>
												<a class="dropdown-item" href="' . htmlspecialchars($recurso["enlace"]) . '" target="_blank">Material</a>
											</div>
										</div>
										<div class="col-10">
											<span class=""> '.$botonenviararchivo .' ' . $botonenviarenlace . ' ' . $botonenviarmensaje . '</span> <span class="text-semibold"> ' . ucfirst(strtolower(htmlspecialchars($recurso["titulo_enlace"]))) . '</span>
										</div>
									</div>
								</div>';

								if($terminotarea=="no"){
										$data["opciones"] .= '
									<div class="col-12">
										<div class="row">
											
											<div class="col-8">
												<span class="titulo-2 fs-12">Desde: ' . $estudiante->fechaespsinano($recurso["fecha_inicio_enlace"]) . '</span><br>
												<span class="titulo-2 fs-12">Hasta: ' . $estudiante->fechaespsinano($recurso["fecha_limite_enlace"]) . '</span>
											</div>
											<div class="col-2 text-center">	
												<span>Porcentaje</span><br>
												<span>' . $recurso["porcentaje_enlace"] . '%</span>
											</div>
											<div class="col-2 text-right">	
												<span>Puntos</span><br>
												<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
												<span>' . $recurso["puntos_actividad_enlace"] . ' Pts.</span>
											</div>
											

										</div>
									</div>';
								}else{
									$data["opciones"] .= '
									<div class="col-12">
										<div class="row">
											<div class="col-4">
												<span class="titulo-2 fs-12"><i class="fa-solid fa-lock text-danger"></i> Termino: ' . $estudiante->fechaespsinano($recurso["fecha_limite_enlace"]) . '</span>
											</div>
											<div class="col-8 text-right">	
												<span> <i class="fa-solid fa-check-double"></i> </span><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
												<span>' . $puntos_otorgados_enlace . ' Pts.</span>
											</div>
										</div>
									</div>';
								}


								$data["opciones"] .= '
							</div>
						</div>

					</div>
				</div>';
				$mifila++;

			} elseif ($recurso['tipo'] === 'glosario') { // si es glosario

				$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
				$id_estudiante=$datos_delid_usuario["id_estudiante"];
				
					$data["opciones"] .= '
				<div class="my-2" id="mifila'.$mifila.'">
					<div class="row justify-content-center align-items-center">
						
						<div class="col-1 text-center"><i class="fas fa-book-reader text-danger fa-2x"></i></div>
						<div class="col-11 border-bottom pb-3">
							<div class="row">

								<div class="col-12 my-0 py-0">
									<div class="row">
										<div class="col-auto dropdown" style="width:20px">
											<button class="btn btn-sm dropdown-toggle semibold titulo-2 fs-12 p-0 m-0" type="button" data-toggle="dropdown" aria-expanded="false">
												<i class="fa-solid fa-ellipsis-vertical"></i>
											</button>
											<div class="dropdown-menu" style="">
												<a class="dropdown-item" onclick="informacionGlosario(' . $recurso["id_pea_glosario"] . ')">Abrir detalles</a>
											</div>
										</div>
										<div class="col">
											<span class="text-semibold pl-2">' . htmlspecialchars($recurso["titulo_glosario"]) . '</span><br>
											<span class="titulo-2 fs-12">Publicado: '.$estudiante->fechaespsinano($recurso["fecha_glosario"]).'</span>
							
										</div>';
										if($recurso["otorgar_puntos_glosario"]==1){

											$buscarglosariootorgados=$estudiante->buscarglosariootorgados($id_pea_docente,$recurso["id_pea_glosario"],$id_tema,$id_estudiante,$id_credencial,$ciclo);
											if ($buscarglosariootorgados && count($buscarglosariootorgados) > 0) {
												$data["opciones"] .= '
												<div class="col text-right">
													<span><i class="fa-solid fa-check-double"></i></span>
													<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
													<span> ' . $buscarglosariootorgados["puntos_otorgados"] . 'Pts.</span>
												</div>';
											}else{
												
												$data["opciones"] .= '
											<div class="col text-right">
												<span>Puntos</span><br>
												<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:15px;height:15px">
												<span>' . $recurso["puntos_actividad_glosario"] . 'Pts.</span>
											</div>';
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
			} elseif ($recurso['tipo'] === 'video') {// si es un documento

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

				$terminodocumento="no";
				$puntos_otorgados_documento=0;

				if ($recurso["condicion_finalizacion_video"] == 2 ) {// si el estudiante debe marcar como finalizado traer los puntos que le dieron
					$validarentregadoc=$estudiante->validarEntregaVideo($ciclo,$id_pea_docente,$recurso["id_pea_video"],$id_tema,$id_estudiante);
					$puntos_otorgados_documento=$validarentregadoc["puntos_otorgados"];
				}

				if ($recurso["condicion_finalizacion_video"] == 3 && $recurso["tipo_condicion_video"] == 1) {// si debe entregar algo y es un archivo
					$validarentregadoc=$estudiante->validarEntregaVideo($ciclo,$id_pea_docente,$recurso["id_pea_video"],$id_tema,$id_estudiante);
					$puntos_otorgados_documento=$validarentregadoc["puntos_otorgados"];

					if ($validarentregadoc) {// validar si ya subio el archivo el estudiante
						$botonenviararchivo='<a class="btn btn-success btn-xs" href="../files/pea/ciclo'.$ciclo.'/videosest/'.$validarentregadoc["archivo_video"].'" target="_blank">Ver entrega</a>';	
					}else{
						if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_video"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_video"])) {
							$botonenviararchivo='<a class="btn bg-orange btn-xs" onclick="enviarVideos(' .$recurso['id_pea_video']. ','.$mifila.')"><i class="fa-solid fa-cloud-arrow-up"></i> Enviar taller</a>';
						}else{
							$botonenviararchivo = '';
						}
					}
				}else{
					$botonenviararchivo="";
				}

				if ($recurso["condicion_finalizacion_video"] == 3 && $recurso["tipo_condicion_video"] == 2) {// entregar un archivo pero con link
					$validarentregadocumentolink=$estudiante->validarEntregaVideo($ciclo,$id_pea_docente,$recurso["id_pea_documento"],$id_tema,$id_estudiante);
					
					if ($validarentregadocumentolink) {// validar si ya subio el archivo el estudiante
						$puntos_otorgados_documento=$validarentregadocumentolink["puntos_otorgados"];
						$botonenviardocumento='<a class="btn bg-success btn-xs" href="'.$validarentregadocumentolink["link_archivo"].'" target="_blank")"> Ver entrega</a>';
					}else{
						if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_video"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_video"])) {
							$botonenviardocumento='<a class="btn bg-orange btn-xs" onclick="enviarEnlaceDocumento(' .$recurso["id_pea_video"]. ','.$mifila.')"><i class="fa-solid fa-cloud-arrow-up"></i> Enviar Link</a>';
						} else {
							$botonenviardocumento= '';
							
						}
					}
				}else{
					$botonenviardocumento="";
				}

				if ($recurso["condicion_finalizacion_video"] == 3 && $recurso["tipo_condicion_video"] == 3) {// si debe entregar archivo  y es un mensaje
					$validarentregadocumentomensaje=$estudiante->validarEntregaVideo($ciclo,$id_pea_docente,$recurso["id_pea_documento"],$id_tema,$id_estudiante);
					
					if ($validarentregadocumentomensaje) {// validar si ya subio el archivo el estudiante
						$puntos_otorgados_documento=$validarentregadocumentomensaje["puntos_otorgados"];
						$botonenviarmensaje='<a class="btn bg-success btn-xs" onclick="verDocumentoMensaje(' .$validarentregadocumentomensaje["id_pea_ejercicios_est"]. ',' .$recurso["id_pea_documento"]. ')"> Ver Mensaje</a>';
					}else{
						if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_video"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_video"])) {
							$botonenviarmensaje='<a class="btn bg-orange btn-xs" onclick="enviardocumentoMensaje(' .$recurso["id_pea_documento"]. ','.$mifila.')"><i class="fa-solid fa-cloud-arrow-up"></i> Enviar Mensaje</a>';
					
						} else {
							$botonenviarmensaje= '';
							
						}
					}
				}else{
					$botonenviarmensaje="";
				}


				if (strtotime($fecha) >= strtotime($recurso["fecha_inicio_video"]) && strtotime($fecha) <= strtotime($recurso["fecha_limite_video"])) {
					$terminovideo="no";
				}else{
					$terminovideo="si";
				}

				$thumb = getYoutubeThumbnail($recurso["video"], 'mqdefault');

				$data["opciones"] .= '
					<div class="col-12 my-2 py-2 border-bottom" id="mifila'.$mifila.'">
						<div class="row justify-content-center align-items-center">
							<div class="col-1 d-flex align-items-left pl-0">
								<img src="'.$thumb.'" alt="MiniaturaVideo" class="img-fluid rounded" style="max-width: 60px;">
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
												</div>
											</div>
											<div class="col-10 ml-3">
												'.$botonenviararchivo.' ' . $botonenviardocumento . ' ' . $botonenviarmensaje . '
												<span class="text-semibold">' . ucfirst(strtolower(htmlspecialchars($recurso["titulo_video"]))) . '</span>
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

	case 'informacionDoc':
		$data = [];
		$data["data1"] = "";
		$id_pea_documento = $_POST["id_pea_documento"];
		$datostaller=$estudiante->datostaller($id_pea_documento);
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
					$texto_condicion_documento = "Marcarlos como terminado";
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
					$texto_tipo_documento = "desconocido";
			}

			$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
			$id_estudiante=$datos_delid_usuario["id_estudiante"];


			$botonpuntos = '';
			if($condicion_finalizacion_documento==2 && $otorgar_puntos_documento==1 && $fecha_limite_documento >= $fecha){
				$buscardocumentootorgados=$estudiante->buscardocumentootorgados($id_pea_docente,$id_pea_documento,$id_tema,$id_estudiante,$id_credencial,$ciclo);
				if ($buscardocumentootorgados && count($buscardocumentootorgados) > 0) {
					$botonpuntos="";
				}else{
					
					$botonpuntos='<a class="btn btn-success text-white" onclick="validarDocumento('.$id_pea_documento.','.$id_pea_docente.','.$id_tema.','.$ciclo.')">Marcar como terminado</a>';
				}
			}else{
				$botonpuntos="";
			}

			

				$data["data1"] .= '
			<div class="col-12 >
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
						<span class="text-semibold">'. $estudiante->fechaesp($fecha_inicio_documento) . '</span>
					</div>
					<div class="col-6">
						<span>Fecha de cierre</span><br>
						<span class="text-semibold">' . $estudiante->fechaesp($fecha_limite_documento) . '</span>
					</div>
				</div>
			</div>
			<div class="col-12 pt-2">
				<div class="row">
					<div class="col-4 borde">
						<span>Para este taller debo</span><br>
						<span class="text-semibold">' . $texto_condicion_documento . '</span>
					</div>
					<div class="col-4 borde">
						<span>Debe ser </span><br>
						<span class="text-semibold">' . $texto_tipo_documento . '</span>
					</div>
					<div class="col-4 borde">
						<span>Se otorgaran </span><br>
						<img src="../public/img/coin.webp" alt="coin" class="pb-2" ><span class="fs-18 text-semibold"> ' . $puntos_actividad_documento . ' Pts.</span>
					</div>
				</div>
			</div>
			<div class="col-4 pt-2"><h3 class="fs-14">Porcentaje del taller</h3><span class="fs-18">'.$porcentaje_documento.'%</span></div>
			<div class="col-4 pt-2"><span class="fs-18">'.$botonpuntos.'</span></div>';

		echo json_encode($data);
	break;

	case 'informacionEnlace':
		$data = [];
		$data["data1"] = "";
		$id_pea_enlace = $_POST["id_pea_enlaces"];
		$datosenlace=$estudiante->datosenlace($id_pea_enlace);
			$id_pea_docente=$datosenlace["id_pea_docentes"];
			$id_tema=$datosenlace["id_tema"];
			$titulo_enlace=$datosenlace["titulo_enlace"];
			$descripcion_enlace=$datosenlace["descripcion_enlace"];
			$enlace=$datosenlace["enlace"];
			$fecha_enlace=$datosenlace["fecha_enlace"];
			$hora_enlace=$datosenlace["hora_enlace"];
			$condicion_finalizacion_enlace=$datosenlace["condicion_finalizacion_enlace"];
			$tipo_condicion_enlace=$datosenlace["tipo_condicion_enlace"];
			$fecha_inicio_enlace=$datosenlace["fecha_inicio_enlace"];
			$fecha_limite_enlace=$datosenlace["fecha_limite_enlace"];
			$porcentaje_enlace=$datosenlace["porcentaje_enlace"];
			$otorgar_puntos_enlace=$datosenlace["otorgar_puntos_enlace"];
			$puntos_actividad_enlace=$datosenlace["puntos_actividad_enlace"];
			$ciclo=$datosenlace["ciclo"];

			switch ($condicion_finalizacion_enlace) {
				case 1:
					$texto_condicion_enlace = "solo ver el material";
					break;
				case 2:
					$texto_condicion_enlace = "Marcarlo como terminado";
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
					$texto_tipo_enlace = "no aplica";
			}
			
			$linkdescarga='<a href="'.$enlace.'" target="_blank">Enlace de apoyo</a>';

			$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
			$id_estudiante=$datos_delid_usuario["id_estudiante"];

			$botonpuntos = '';
			if($condicion_finalizacion_enlace ==2 && $otorgar_puntos_enlace==1 && $fecha_limite_enlace >= $fecha){
				$buscarenlaceotorgados=$estudiante->buscarenlaceotorgados($id_pea_docente,$id_pea_enlace,$id_tema,$id_estudiante,$id_credencial,$ciclo);
				if ($buscarenlaceotorgados && count($buscarenlaceotorgados) > 0) {
					$botonpuntos="";
				}else{
					
					$botonpuntos='<a class="btn btn-success text-white" onclick="validarEnlace('.$id_pea_enlace.','.$id_pea_docente.','.$id_tema.','.$ciclo.')">Marcar como terminado</a>';
				}
			}else{
				$botonpuntos="";
			}


				$data["data1"] .= '
			<div class="col-12 >
				<div class="row">
					<div class="col-12">
						<h2><i class="fa-solid fa-link fa-1x"></i></i> '.$titulo_enlace.'</h2>
					</div>
					<div class="col-12 borde-bottom">
						<p><span class="titulo-2 fs-10 text-semibold">Comentario docente</span><br>
						<span class="titulo-2 fs-14">'.$descripcion_enlace.'</span></p>
					</div>
					<div class="col-12 pt-2">
						<p>Documento de apoyo <i class="fa-solid fa-paperclip"></i> '.$linkdescarga.' </p>
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
						<span class="text-semibold">'. $estudiante->fechaesp($fecha_inicio_enlace) . '</span>
					</div>
					<div class="col-6">
						<span>Fecha de cierre</span><br>
						<span class="text-semibold">' . $estudiante->fechaesp($fecha_limite_enlace) . '</span>
					</div>
				</div>
			</div>
			<div class="col-12 pt-2">
				<div class="row">
					<div class="col-4 borde">
						<span>Para este taller debo</span><br>
						<span class="text-semibold">' . $texto_condicion_enlace . '</span>
					</div>
					<div class="col-4 borde">
						<span>Debe ser </span><br>
						<span class="text-semibold">' . $texto_tipo_enlace . '</span>
					</div>
					<div class="col-4 borde">
						<span>Se otorgaran </span><br>
						<img src="../public/img/coin.webp" alt="coin" class="pb-2" ><span class="fs-18 text-semibold"> ' . $puntos_actividad_enlace . ' Pts.</span>
					</div>
				</div>
			</div>
			<div class="col-4 pt-2"><h3 class="fs-14">Porcentaje del taller</h3><span class="fs-18">'.$porcentaje_enlace.'%</span></div>
			<div class="col-4 pt-2"><span class="fs-18">'.$botonpuntos.'</span></div>';

			echo json_encode($data);
	break;

	case 'informacionGlosario':
		$data = [];
		$data["data1"] = "";
		$id_pea_glosario= $_POST["id_pea_glosario"];
		$datosglosario=$estudiante->datosglosario($id_pea_glosario);
			$id_pea_docente=$datosglosario["id_pea_docentes"];
			$id_tema=$datosglosario["id_tema"];
			$titulo_glosario=$datosglosario["titulo_glosario"];
			$definicion_glosario=$datosglosario["definicion_glosario"];
			$fecha_glosario=$datosglosario["fecha_glosario"];
			$hora_glosario=$datosglosario["hora_glosario"];
			$otorgar_puntos_glosario=$datosglosario["otorgar_puntos_glosario"];
			$puntos_actividad_glosario=$datosglosario["puntos_actividad_glosario"];
			$ciclo=$datosglosario["ciclo"];

			$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
			$id_estudiante=$datos_delid_usuario["id_estudiante"];

			$botonpuntos = '';
			if($otorgar_puntos_glosario==1){
				$buscarglosariootorgados=$estudiante->buscarglosariootorgados($id_pea_docente,$id_pea_glosario,$id_tema,$id_estudiante,$id_credencial,$ciclo);
				if ($buscarglosariootorgados && count($buscarglosariootorgados) > 0) {
					$botonpuntos="";
				}else{
					
					$botonpuntos='<a class="btn btn-success text-white" onclick="validarGlosario('.$id_pea_glosario.','.$id_pea_docente.','.$id_tema.','.$ciclo.')">Marcar como visto</a>';
				}
			}else{
				$botonpuntos="";
			}


				$data["data1"] .= '
			<div class="col-12 >
				<div class="row">
					<div class="col-12">
						<h2><i class="fa-solid fa-link fa-1x"></i></i> '.$titulo_glosario.'</h2>
					</div>
					<div class="col-12 borde-bottom">
						<p><span class="titulo-2 fs-10 text-semibold">Comentario docente</span><br>
						<span class="titulo-2 fs-14">'.$definicion_glosario.'</span></p>
					</div>

				</div>
				
			</div>

			<div class="col-12 pt-2">
				<div class="row">
					<div class="col-4 borde">
						<span>Se otorgaran </span><br>
						<img src="../public/img/coin.webp" alt="coin" class="pb-2" ><span class="fs-18 text-semibold"> ' . $puntos_actividad_glosario . ' Pts.</span>
					</div>
					<div class="col-4">
						'.$botonpuntos.'
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
	
		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante = $datos_delid_usuario["id_estudiante"];

		$preguntas_video = $peadocente->getQuestionsVideo($id_pea_video);

		$respuestas_video = $peadocente->getRequetsVideo($id_pea_video, $_SESSION["id_usuario"]);

		$botonpuntos = '';
		if ($condicion_finalizacion_video == 2 && $otorgar_puntos_video == 1 && $fecha_limite_video >= $fecha) {
			$buscarvideootorgados = $estudiante->buscarvideootorgados($id_pea_docente,$id_pea_video,$id_tema,$id_estudiante,$id_credencial,$ciclo);
			if ($buscarvideootorgados && count($buscarvideootorgados) > 0) {
				$botonpuntos="";
			}else{
				$botonpuntos='<a class="btn btn-success text-white" onclick="validarVideo('.$id_pea_video.','.$id_pea_docente.','.$id_tema.','.$ciclo.')">Marcar como terminado</a>';
			}
		}else{
			$botonpuntos="";
		}
		
		$data["preguntas"] .= json_encode($preguntas_video) ;
		$data["video"] .= $datostaller["video"];
		$data["data1"] .= '
			<div class="col-12">
				<div class="card card-tabs">
					<div class="card-header p-0 pt-1">
						<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
							<li class="nav-items">
								<a class="nav-link active" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Detalles</a>
							</li>
							<li class="nav-items">
								<a class="nav-link" id="custom-tabs-one-video-tab" data-toggle="pill" href="#custom-tabs-one-video" role="tab" aria-controls="custom-tabs-one-video" aria-selected="false">Responder cuestionario</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="custom-tabs-one-tabContent">
							<div class="tab-pane fade active show" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
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

									<div class="col-12 pt-2 my-3 d-flex justify-content-center align-items-center">
										<span class="fs-18">'.$botonpuntos.'</span>
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
											<div class="col-12 mt-3">
												<div class="col-12 borde-bottom">
													<h4 class="mb-0 text-semibold">Preguntas del video</h4>
													<p>
														<span class="titulo-2 fs-14">Total de '.count($preguntas_video).' por responder</span>
													</p>
												</div>
												
												<div id="preguntas-listado" class="list-group">';

												$disabled_guardar_preguntas = empty($respuestas_video) ? false : true;

												if (!empty($preguntas_video)) {
													foreach ($respuestas_video as $respuesta) {

														$id = $respuesta["id_respuesta"];
														$respuesta_texto =  $respuesta["respuesta"];
														$pregunta = $respuesta["pregunta"];
														$tipo = $respuesta["tipo_pregunta"];

														if ($tipo == 1) {
															$data["data1"] .= '
																<div class="list-group-item" data-id="'.$id.'" style="background-color: #283157;">
																	<h5>'.$pregunta.'</h5>
																	<div class="form-check">
																		<input class="form-check-input" type="radio" 
																			name="preg-'.$id.'" value="Verdadero"
																			'.($respuesta_texto == 'Verdadero' ? "checked disabled" : "disabled").'>
																		<label class="form-check-label">Verdadero</label>
																	</div>
																	<div class="form-check">
																		<input class="form-check-input" type="radio" 
																			name="preg-'.$id.'" value="Falso"
																			'.($respuesta_texto == "Falso" ? "checked disabled" : "disabled").'>
																		<label class="form-check-label">Falso</label>
																	</div>
																</div>
															';
														} else {
															$data["data1"] .= '
															<div class="list-group-item" data-id="'.$id.'" style="background-color: #283157;" >
																<h5>'.$pregunta.'</h5>
																<input type="text" class="form-control" value="'.$respuesta_texto.'" disabled>
															</div>
															';
														}
													}
												} else {
													$data["data1"] .= '<div colspan="4" class="text-center">No hay preguntas registradas.</div>';
												}

							$data["data1"] .= '</div>

												<div class="text-center mt-3">
													<button id="guardar-todas-respuestas" class="btn btn-primary" disabled="'.$disabled_guardar_preguntas.'">
														Guardar respuestas
													</button>
												</div>
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

	case 'guardarRespuestasVideo':
		$respuestas = json_decode($_POST["respuestas"], true);

		foreach ($respuestas as $r) {
			$id_pregunta = $r["id_pregunta"];
			$respuesta = $r["respuesta"];
			$id_video = $r["id_video"];
			$fecha_actual = date('Y-m-d H:m:s');

			$estudiante->guardarRespuestaVideo($id_pregunta, $respuesta, $fecha_actual);
		}

		echo json_encode(["status" => "ok"]);

	break;

	case 'validarGlosario':
		$data = [];
		$data["data1"] = "";
		$data["puntosotorgados"] = "";
		$data["puntos"] = "";

		$id_pea_glosario = $_POST["id_pea_glosario"];
		$datos = $estudiante->datosglosario($id_pea_glosario);
		$id_pea_docente= $datos["id_pea_docentes"];
		$id_tema = $datos["id_tema"];
		$puntos_otorgados = $datos["puntos_actividad_glosario"];
		$ciclo = $datos["ciclo"];

		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];

		$rspta2 = $estudiante->insertarGlosario($id_pea_docente,$id_pea_glosario,$id_tema,$id_estudiante,$id_credencial,$fecha,$hora,$puntos_otorgados,$ciclo);
		
		// Evaluar si la inserción fue exitosa
		if ($rspta2) {
			$buscarbilleteradocente=$estudiante->buscarBilleteraDocente($id_pea_docente);
			$billetera_asignatura=$buscarbilleteradocente["billetera_asignatura"];// saldo billetera
			if(($billetera_asignatura-$puntos_otorgados)>=0){
				$nuevosaldo=$billetera_asignatura-$puntos_otorgados;
				$descontarbilletra=$estudiante->actualizarBilleteraDocente($id_pea_docente,$nuevosaldo);// descontamos los puntos a la billetra del profe, damos el nuevo saldo pea docente

				$punto_nombre="peadocente";// nombre de los puntos para la tabla puntos
				$puntos_cantidad=$puntos_otorgados;
				$insertarpunto=$estudiante->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);// inserta en la tabla puntos

				$totalpuntos=$estudiante->verpuntos();// buscamos cuantos puntos tiene el estudiante
				$puntoscredencial=$totalpuntos["puntos"];// variable que contiene el total de puntos
				$sumapuntos=$puntos_cantidad+$puntoscredencial;
				$estudiante->actulizarValor($sumapuntos);
				$data["puntos"] = "si";
				$data["puntosotorgados"] = $puntos_cantidad;
				$data["data1"] = "Puntos otorgados";
			}else{
				$data["puntos"] = "no";
				$data["data1"] = "Puntos no otorgados";
			}
		} else {
			$data["data1"] = 0; // Error
		}
				

		echo json_encode($data);
	break;

	case 'validarEnlace':
		$data = [];
		$data["data1"] = "";
		$data["puntosotorgados"] = "";
		$data["puntos"] = "";

		$id_pea_enlace = $_POST["id_pea_enlaces"];
		$datos = $estudiante->datosenlace($id_pea_enlace);
		$id_pea_docente= $datos["id_pea_docentes"];
		$id_tema = $datos["id_tema"];
		$puntos_otorgados = $datos["puntos_actividad_enlace"];
		$ciclo = $datos["ciclo"];

		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];
		$estado_ejercicios=2; //quiere decir que ya esta calificado 
		$rspta2 = $estudiante->marcarEnlace($id_pea_docente,$id_pea_enlace,$id_tema,$id_estudiante,$id_credencial,$fecha,$hora,$estado_ejercicios,$puntos_otorgados,$ciclo);
		
		// Evaluar si la inserción fue exitosa
		if ($rspta2) {

			$buscarbilleteradocente=$estudiante->buscarBilleteraDocente($id_pea_docente);
			$billetera_asignatura=$buscarbilleteradocente["billetera_asignatura"];// saldo billetera
			if(($billetera_asignatura-$puntos_otorgados)>=0){
				$nuevosaldo=$billetera_asignatura-$puntos_otorgados;
				$descontarbilletra=$estudiante->actualizarBilleteraDocente($id_pea_docente,$nuevosaldo);// descontamos los puntos a la billetra del profe, damos el nuevo saldo pea docente

				$punto_nombre="peadocente";// nombre de los puntos para la tabla puntos
				$puntos_cantidad=$puntos_otorgados;
				$insertarpunto=$estudiante->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);// inserta en la tabla puntos

				$totalpuntos=$estudiante->verpuntos();// buscamos cuantos puntos tiene el estudiante
				$puntoscredencial=$totalpuntos["puntos"];// variable que contiene el total de puntos
				$sumapuntos=$puntos_cantidad+$puntoscredencial;
				$estudiante->actulizarValor($sumapuntos);
				$data["puntos"] = "si";
				$data["puntosotorgados"] = $puntos_cantidad;
				$data["data1"] = "Puntos otorgados";
			}else{
				$data["puntos"] = "no";
				$data["data1"] = "Puntos no otorgados";
			}

		} else {
			$data["data1"] = 0; // Error
		}
				

		echo json_encode($data);
	break;

	case 'validarDocumento':
		$data = [];
		$data["data1"] = "";
		$data["puntosotorgados"] = "";
		$data["puntos"] = "";

		$id_pea_documento = $_POST["id_pea_documento"];
		$datos = $estudiante->datosdocumento($id_pea_documento);
		$id_pea_docente= $datos["id_pea_docentes"];
		$id_tema = $datos["id_tema"];
		$puntos_otorgados = $datos["puntos_actividad_documento"];
		$ciclo = $datos["ciclo"];

		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];
		$estado_ejercicios=2; //quiere decir que ya esta calificado 
		$rspta2 = $estudiante->marcarDocumento($id_pea_docente,$id_pea_documento,$id_tema,$id_estudiante,$id_credencial,$fecha,$hora,$estado_ejercicios,$puntos_otorgados,$ciclo);
		
		// Evaluar si la inserción fue exitosa
		if ($rspta2) {
			$buscarbilleteradocente=$estudiante->buscarBilleteraDocente($id_pea_docente);
			$billetera_asignatura=$buscarbilleteradocente["billetera_asignatura"];// saldo billetera
			if(($billetera_asignatura-$puntos_otorgados)>=0){
				$nuevosaldo=$billetera_asignatura-$puntos_otorgados;
				$descontarbilletra=$estudiante->actualizarBilleteraDocente($id_pea_docente,$nuevosaldo);// descontamos los puntos a la billetra del profe, damos el nuevo saldo pea docente

				$punto_nombre="peadocente";// nombre de los puntos para la tabla puntos
				$puntos_cantidad=$puntos_otorgados;
				$insertarpunto=$estudiante->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);// inserta en la tabla puntos

				$totalpuntos=$estudiante->verpuntos();// buscamos cuantos puntos tiene el estudiante
				$puntoscredencial=$totalpuntos["puntos"];// variable que contiene el total de puntos
				$sumapuntos=$puntos_cantidad+$puntoscredencial;
				$estudiante->actulizarValor($sumapuntos);
				$data["puntos"] = "si";
				$data["puntosotorgados"] = $puntos_cantidad;
				$data["data1"] = "Puntos otorgados";
			}else{
				$data["puntos"] = "no";
				$data["data1"] = "Puntos no otorgados";
			}
		} else {
			$data["data1"] = 0; // Error
		}
				
		echo json_encode($data);
	break;

	case 'validarVideo':
		$data = [];
		$data["data1"] = "";
		$data["puntosotorgados"] = "";
		$data["puntos"] = "";

		$id_pea_video = $_POST["id_pea_video"];

		$datos = $peadocente->datosvideo($id_pea_video);
		$id_pea_docente = $datos["id_pea_docentes"];
		$id_tema = $datos["id_tema"];
		$puntos_otorgados = $datos["puntos_actividad_video"];
		$ciclo = $datos["ciclo"];

		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante = $datos_delid_usuario["id_estudiante"];
		$estado_ejercicios = 2; //quiere decir que ya esta calificada

		$rspta2 = $estudiante->marcarVideo($id_pea_docente,$id_pea_video,$id_tema,$id_estudiante,$id_credencial,$fecha,$hora,$puntos_otorgados,$ciclo);
		
		// Evaluar si la inserción fue exitosa
		if ($rspta2) {
			$buscarbilleteradocente=$estudiante->buscarBilleteraDocente($id_pea_docente);
			$billetera_asignatura=$buscarbilleteradocente["billetera_asignatura"]; // saldo billetera
			if(($billetera_asignatura-$puntos_otorgados)>=0){
				$nuevosaldo=$billetera_asignatura-$puntos_otorgados;
				$descontarbilletra=$estudiante->actualizarBilleteraDocente($id_pea_docente,$nuevosaldo);// descontamos los puntos a la billetra del profe, damos el nuevo saldo pea docente

				$punto_nombre="peadocente";// nombre de los puntos para la tabla puntos
				$puntos_cantidad=$puntos_otorgados;
				$insertarpunto=$estudiante->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);// inserta en la tabla puntos

				$totalpuntos=$estudiante->verpuntos();// buscamos cuantos puntos tiene el estudiante
				$puntoscredencial=$totalpuntos["puntos"];// variable que contiene el total de puntos
				$sumapuntos=$puntos_cantidad+$puntoscredencial;
				$estudiante->actulizarValor($sumapuntos);
				$data["puntos"] = "si";
				$data["puntosotorgados"] = $puntos_cantidad;
				$data["data1"] = "Puntos otorgados";
			}else{
				$data["puntos"] = "no";
				$data["data1"] = "Puntos no otorgados";
			}
		} else {
			$data["data1"] = 0; // Error
		}
				
		echo json_encode($data);
	break;

	case 'enlaceMensaje':
		$data = [];
		$data["data1"] = "";

		$id_pea_enlaces_est= $_POST["id_pea_enlaces_est"];
		$id_pea_enlace = $_POST["id_pea_enlaces"];
		
		$datos = $estudiante->datosenlace($id_pea_enlace);
		$id_pea_docente= $datos["id_pea_docentes"];
		$id_tema = $datos["id_tema"];
		$puntos_otorgados = $datos["puntos_actividad_enlace"];
		$ciclo = $datos["ciclo"];

		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];
		$estado_ejercicios=2; //quiere decir que ya esta calificado 
		$rspta2 = $estudiante->verEnlaceMensaje($id_pea_enlaces_est,$ciclo);

		// Evaluar si la inserción fue exitosa
		if ($rspta2) {
			$data["data1"] = $rspta2["comentario_archivo"]; // Éxito
		} else {
			$data["data1"] = 0; // Error
		}
				

		echo json_encode($data);
	break;

	case 'documentoMensaje':
		$data = [];
		$data["data1"] = "";

		$id_pea_ejercicios_est = $_POST["id_pea_ejercicios_est"];
		$id_pea_documento = $_POST["id_pea_documento"];

		$datos = $estudiante->datosdocumento($id_pea_documento);
		$id_pea_docente= $datos["id_pea_docentes"];
		$id_tema = $datos["id_tema"];
		$puntos_otorgados = $datos["puntos_actividad_documento"];
		$ciclo = $datos["ciclo"];

		$datos_delid_usuario = $estudiante->datos_delid_usuario($id_credencial,$ciclo,$periodo_actual);
		$id_estudiante=$datos_delid_usuario["id_estudiante"];

		$estado_ejercicios=2; //quiere decir que ya esta calificado 
		$rspta2 = $estudiante->verDocumentoMensaje($id_pea_ejercicios_est,$ciclo);

		// Evaluar si la inserción fue exitosa
		if ($rspta2) {
			$data["data1"] = $rspta2["comentario_archivo"]; // Éxito
		} else {
			$data["data1"] = 0; // Error
		}
				

		echo json_encode($data);
	break;

}
