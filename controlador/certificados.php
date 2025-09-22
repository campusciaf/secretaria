<?php
session_start();
date_default_timezone_set("America/Bogota");
require '../vendor/autoload.php';
require_once "../modelos/Certificados.php";

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Language;

$fecha = date('Y-m-d');
// Función para convertir la fecha a formato español //	
function fechaesp($date)
{
	$dia 	= explode("-", $date, 3);
	$year 	= $dia[0];
	$month 	= (string)(int)$dia[1];
	$day 	= (string)(int)$dia[2];
	$dias 		= array("Domingo", "Lunes", "Martes", "Mi&eacute;rcoles", "Jueves", "Viernes", "S&aacute;bado");
	$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
	$meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
}
$generar_certificados = new Certificados();
$phpWord = new PhpWord();
$phpWord->getSettings()->setThemeFontLang(new Language(Language::ES_ES));
$tipo_certificado = isset($_POST["tipo_certificado"]) ? limpiarCadena($_POST["tipo_certificado"]) : "";
$id_credencial2 = isset($_POST["id_credencial2"]) ? limpiarCadena($_POST["id_credencial2"]) : "";
$id_estudiante2 = isset($_POST["id_estudiante2"]) ? limpiarCadena($_POST["id_estudiante2"]) : "";
$id_programa_ac2 = isset($_POST["id_programa_ac2"]) ? limpiarCadena($_POST["id_programa_ac2"]) : "";
$archivo_diploma = isset($_POST["archivo_diploma"]) ? limpiarCadena($_POST["archivo_diploma"]) : "";
$op = (isset($_GET['op'])) ? $_GET['op'] : 'mostrar';
switch ($op) {
	case 'verificar':
		$cedula = $_POST["cedula"];
		$verificar_cedula = $generar_certificados->verificarDocumento($cedula);
		if (empty($verificar_cedula)) {
			echo 1;
		} else {
			echo json_encode($verificar_cedula);
		}
		break;
	case 'listar':
		$id_credencial = $_GET["id_credencial"];
		$rspta = $generar_certificados->listar($id_credencial);
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$estado_datos = $generar_certificados->estado_datos($rspta[$i]["estado"]);
			$data[] = array(
				"0" => '
				<button class="btn btn-warning btn-xs" onclick="mostrar(' . $rspta[$i]["id_credencial"] . ',' . $rspta[$i]["id_estudiante"] . ',' . $rspta[$i]["id_programa_ac"] . ')" title="Generar Certificado">
					<i class="fas fa-print "></i>
				</button>',
				"1" => $rspta[$i]["id_estudiante"],
				"2" => $rspta[$i]["fo_programa"],
				"3" => $rspta[$i]["jornada_e"],
				"4" => $estado_datos["estado"],
				"5" => $rspta[$i]["periodo_activo"],
			);
			$i++;
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'cargar':
		$id_credencial = $_POST['id_credencial'];
		$cargar_informacion = $generar_certificados->cargarInformacion($id_credencial);
		echo json_encode($cargar_informacion);
		break;
	case 'historialCertificadosExpedidos2':
		$credencial = $_POST['credencial'];
		$cedula = $_POST['cedula'];
		$historial_certificados = $generar_certificados->verHistorialCertificados($credencial, $cedula);
		echo $historial_certificados;
		break;
	case 'historialCertificadosExpedidos':
		$credencial = $_POST['credencial'];
		$cedula = $_POST['cedula'];
		$rspta = $generar_certificados->verHistorialCertificados($credencial, $cedula);
		$link_descarga = "";
		$eliminar = "";
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$datos_certificado = $generar_certificados->nombreCertificado($rspta[$i]["id_tipo_certificado"]);
			$nombre_certificado = $datos_certificado["nombre"];
			$datos_programa = $generar_certificados->nombrePrograma($rspta[$i]["id_programa"]);
			$nombre_programa = $datos_programa["nombre"];
			if ($rspta[$i]["id_tipo_certificado"] == "9") {
				$link_descarga = '<a href="../files/certificados/' . $rspta[$i]["certificado_archivo"] . '" target="_blank"><i class="fa fa-file-pdf" style="color: red"></i> Ver</a>';
				$eliminar = '<a onclick="eliminarDiploma(' . $rspta[$i]["id_certificado"] . ')" class="cursor-pointer"><i class="fa fa-trash" style="color: red"></i> Eliminar</a>';
			} else {
				$link_descarga = "";
				$eliminar = "";
			}
			$data[] = array(
				"0" => $nombre_certificado,
				"1" => $nombre_programa,
				"2" => $generar_certificados->convertir_fecha($rspta[$i]["fecha_carga"]),
				"3" => $link_descarga . ' - ' . $eliminar,
			);
			$i++;
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'verificar_certificados_expedidos':
		$id_estudiante = $_POST['id_estudiante'];
		$verificar_certificados_expedidos = $generar_certificados->validarCertificadosExpedidos($id_estudiante);
		echo $verificar_certificados_expedidos;
		break;
	case 'cargarDatosEstudiante':
		$id_estudiante = $_POST['id_estudiante'];
		$id_credencial = $_POST['id_credencial'];
		$datos_estudiante = $generar_certificados->cargarDatosEstudiante($id_estudiante, $id_credencial);
		echo $datos_estudiante;
		break;
	case 'cargarTodasCalificaciones':
		$id_estudiante = $_POST['id_estudiante'];
		$ciclo = $_POST['ciclo'];
		$semestres_programa = $_POST['semestres_programa'];
		$semestre_estudiante = $_POST['semestre_estudiante'];
		$cargar_calificaciones = $generar_certificados->cargarTodasCalificaciones($id_estudiante, $ciclo, $semestres_programa, $semestre_estudiante);
		echo $cargar_calificaciones;
		break;
	case 'cargarSemestreActual':
		$periodo_activo = $_POST['periodo_activo'];
		$id_estudiante = $_POST['id_estudiante'];
		$ciclo = $_POST['ciclo'];
		$semestre_estudiante = $_POST['semestre_estudiante'];
		$cargar_calificaciones = $generar_certificados->cargarSemestreActual($id_estudiante, $ciclo, $semestre_estudiante);
		echo $cargar_calificaciones;
		break;
	case 'cargarSemestreAnterior':
		$id_estudiante = $_POST['id_estudiante'];
		$ciclo = $_POST['ciclo'];
		$semestre_anterior = $_POST['semestre_anterior'];
		$periodo_anterior = $_POST['periodo_anterior'];
		$cargar_calificaciones = $generar_certificados->cargarSemestreAnterior($id_estudiante, $ciclo, $semestre_anterior, $periodo_anterior);
		echo $cargar_calificaciones;
		break;
	case 'fecha_pie':
		$date_pie = $_POST['date'];
		$cargar_fecha_pie = $generar_certificados->convertir_fecha($date_pie);
		echo $cargar_fecha_pie;
		break;
	case 'guardarRegistroCertificado':
		$tipo_certificado = $_POST['tipo_certificado'];
		$id_estudiante = $_POST['id_estudiante'];
		$id_credencial = $_POST['id_credencial'];
		$id_programa = $_POST['id_programa_ac'];
		$fechahoyesp = $_POST['fechahoyesp'];
		$guardar_registro_certificado = $generar_certificados->guardar_registro_certificado($tipo_certificado, $id_estudiante, $id_credencial, $id_programa, $fechahoyesp, $_SESSION['id_usuario']);
		if (empty($guardar_registro_certificado)) {
			echo 1;
		} else {
			echo json_encode($guardar_registro_certificado);
		}
		break;
	case "selectcertificados":
		$rspta = $generar_certificados->selectcertificados();
		echo "<option value='' selected>Seleccionar Certificado </option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_certificado_tipo"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case 'guardaryeditar':
		if ($_FILES['archivo_diploma']['type'] == "application/pdf") {
			$nombre_diploma = $fecha . '-' . $_FILES["archivo_diploma"]["name"];
			$rspta = $generar_certificados->insertarDiploma($tipo_certificado, $id_estudiante2, $id_credencial2, $id_programa_ac2, $nombre_diploma, $fecha, $_SESSION['id_usuario']);
			$data["0"] = $rspta ? "1" : "2";
			if ($rspta == "1") {
				move_uploaded_file($_FILES["archivo_diploma"]["tmp_name"], "../files/certificados/" . $nombre_diploma);
			}
		} else {
			$data["0"] = "3";
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'eliminarDiploma':
		$id_certificado = $_POST['id_certificado'];
		$datoarchivo = $generar_certificados->archivoeliminar($id_certificado);
		$nombrearchivo = $datoarchivo["certificado_archivo"];
		$rspta = $generar_certificados->eliminardiploma($id_certificado);
		if (!$rspta) {
			unlink('../files/certificados/' . $nombrearchivo); // elimina el archivo actual
			$data['status'] = 1;
		} else {
			$data['status'] = 2;
		}
		echo json_encode($data);
		break;
	case 'documento_word_certificado':
		$texto_principal = $_POST['texto_principal'];
		$texto_principal = str_replace(["\n", "\t"], " ", $texto_principal);
		$texto_principal = preg_replace('/\s+/', ' ', $texto_principal);
		$pie_certificado = $_POST['pie_certificado'];
		$pie_certificado = str_replace(["\n", "\t"], " ", $pie_certificado);
		$pie_certificado = preg_replace('/\s+/', ' ', $pie_certificado);
		$tabla_html = $_POST['tabla_html'];
		$tabla_html = (empty(trim($tabla_html))) ? '<font size="3"><b></b></font>' : $tabla_html;
		$section = $phpWord->addSection(['marginTop' => 2000, 'marginBottom' => 1500, 'marginLeft' => 1500, 'marginRight' => 1500]);
		$header = $section->addHeader();
		$header->addImage('../files/formatos/marca_de_agua_certificados.jpg', [
			'width' => 600,
			'height' => 860,
			'wrappingStyle' => 'behind',
			'positioning' => 'absolute',
			'posHorizontalRel' => 'page',
			'posVerticalRel' => 'page',
			'posHorizontal' => 'center',
			'posVertical' => 'center',
		]);
		$section->addText("CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS C.I.A.F", ['bold' => true, 'size' => 16], ['align' => 'center']);
		$section->addText("NIT.891.408.248-5", ['size' => 12], ['align' => 'center']);
		$section->addText("REGISTRO Y CONTROL", ['size' => 12], ['align' => 'center']);
		$section->addText("CERTIFICA:", ['bold' => true, 'size' => 14], ['align' => 'center']);
		$section->addTextBreak(1);
		$section->addText($texto_principal, ['size' => 12]);
		$section->addTextBreak(2);
		$tabla_html = mb_convert_encoding($tabla_html, 'HTML-ENTITIES', 'UTF-8');
		$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML($tabla_html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		libxml_clear_errors();
		$titles = $dom->getElementsByTagName('font');
		$tables = $dom->getElementsByTagName('table');
		$index = 0;
		foreach ($titles as $title) {
			$titleText = trim($title->textContent);
			$section->addText($titleText, ['bold' => true, 'size' => 14]);
			if (isset($tables[$index])) {
				$tableDom = $tables[$index];
				$rows = $tableDom->getElementsByTagName('tr');
				$tableStyle = array('borderColor' => '006699', 'borderSize'  => 6, 'cellMargin'  => 50);
				$phpWord->addTableStyle('myTable', $tableStyle);
				$table = $section->addTable('myTable');
				$headerCells = $rows[0]->getElementsByTagName('td');
				$table->addRow();
				foreach ($headerCells as $cell) {
					$table->addCell(3000)->addText(trim($cell->textContent), ['bold' => true]);
				}
				for ($i = 1; $i < $rows->length; $i++) {
					$cells = $rows[$i]->getElementsByTagName('td');
					$table->addRow();
					foreach ($cells as $cell) {
						$table->addCell(3000)->addText(trim($cell->textContent));
					}
				}
				$index++;
			}
			$section->addTextBreak(3);
		}
		$averageText = "Promedio acumulado por los 3 semestres";
		$averageNodes = $dom->getElementsByTagName('u'); // Busca elementos <b>
		foreach ($averageNodes as $node) {
			$section->addText($averageText . " " . $node->textContent, ['bold' => true, 'size' => 12]);
		}
		$section->addText($pie_certificado, ['size' => 12], ['align' => 'left']);
		$section->addTextBreak(5);
		$section->addText("____________________________", ['size' => 12], ['align' => 'left']);
		$section->addText("Wilbert Rene Ramirez Delgado", ['bold' => true, 'size' => 12], ['align' => 'left']);
		$section->addText("Registro y Control Académico", ['size' => 12], ['align' => 'left']);
		$nuevoArchivo = '../files/formatos/certificado_generado.docx';
		$writer = IOFactory::createWriter($phpWord, 'Word2007');
		$writer->save($nuevoArchivo);
		echo json_encode(["success" => true, "fileUrl" => $nuevoArchivo]);
		break;
	case 'eliminarDocumentoTemporal':
		if (file_exists('../files/formatos/certificado_generado.docx')) {
			unlink('../files/formatos/certificado_generado.docx');
			echo json_encode(["success" => true, "message" => "Archivo eliminado."]);
		} else {
			echo json_encode(["success" => false, "message" => "Archivo no encontrado."]);
		}
		break;
}
