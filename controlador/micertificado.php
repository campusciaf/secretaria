<?php
require 'vendor/autoload.php';
require_once "../modelos/MiCertificado.php";
session_start();

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

$micertificado = new MiCertificado();
$phpWord = new PhpWord();
$periodo_actual = $_SESSION['periodo_actual'];
$id_credencial = $_SESSION['id_usuario'];
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d-H:i:s');
switch ($_GET["op"]) {
	case 'listar':
		$rspta = $micertificado->listar($id_credencial);
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$rspta3 = $micertificado->programa($rspta[$i]["id_programa"]);
			$data[] = array(
				"0" => $rspta3["nombre"],
				"1" => '<a href="../files/certificados/' . $rspta[$i]["certificado_archivo"] . '" target="_blank"><i class="fa fa-file-pdf" style="color: red"></i> Ver<a/>',
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
	case 'documento_word_certificado':
		echo "trabajando";
		try {
			$section = $phpWord->addSection();
			$section->addText(
				"CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS C.I.A.F",
				['bold' => true, 'size' => 16],
				['align' => 'center']
			);
			$section->addText("NIT.891.408.248-5", ['size' => 12], ['align' => 'center']);
			$section->addText("REGISTRO Y CONTROL", ['size' => 12], ['align' => 'center']);
			$section->addText("CERTIFICA:", ['bold' => true, 'size' => 14], ['align' => 'center']);
			$section->addTextBreak(1);
			// Datos del estudiante
			$nombre_estudiante = "David González Manrique";
			$tipo_doc = "Cédula de Ciudadanía";
			$identificacion = "1004681758";
			$expedido_en = "PEREIRA";
			$semestre_actual = "I";
			$programa = "Idiomas A1";
			$periodo_actual = "2025-1";
			// Agregar información del certificado
			$section->addText(
				"Que: $nombre_estudiante, identificado(a) con $tipo_doc número $identificacion, expedida en $expedido_en, 
    		se encuentra cursando el $semestre_actual semestre del programa $programa durante el periodo $periodo_actual.",
				['size' => 12]
			);
			$section->addTextBreak(2);
			// Calificaciones
			$section->addText("Obteniendo las siguientes calificaciones:", ['bold' => true, 'size' => 12]);
			$table = $section->addTable();
			$table->addRow();
			$table->addCell(4000)->addText("Asignatura", ['bold' => true]);
			$table->addCell(2000)->addText("Créditos", ['bold' => true]);
			$table->addCell(2000)->addText("Notas", ['bold' => true]);
			$table->addCell(2000)->addText("I.H.S", ['bold' => true]);
			// Agregar datos de calificaciones
			$table->addRow();
			$table->addCell(4000)->addText("A1-1");
			$table->addCell(2000)->addText("2");
			$table->addCell(2000)->addText("0.00");
			$table->addCell(2000)->addText("2");
			$section->addTextBreak(2);
			$section->addText("Las asignaturas se califican de 0.0 a 5.0, siendo 3.0 la calificación aprobatoria.", ['size' => 10], ['align' => 'center']);
			$section->addTextBreak(3);
			// Fecha y firma
			$fecha_certificado = "Martes (25) de Febrero de (2025)";
			$section->addText("Para constancia se firma en Pereira el día $fecha_certificado.", ['size' => 12], ['align' => 'left']);
			$section->addTextBreak(4);
			$section->addText("____________________________", ['size' => 12], ['align' => 'left']);
			$section->addText("Wilbert Rene Ramirez Delgado", ['bold' => true, 'size' => 12], ['align' => 'left']);
			$section->addText("Registro y Control Académico", ['size' => 12], ['align' => 'left']);
			// Guardar el archivo Word
			$nuevoArchivo = 'certificado_generado.docx';
			$writer = IOFactory::createWriter($phpWord, 'Word2007');
			if ($writer->save($nuevoArchivo)) {
				echo json_encode($nuevoArchivo);
			} else {
				echo json_encode("Error al guardar el archivo");
			}
			// Descargar el documento
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$nuevoArchivo");
			header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
			header("Content-Length: " . filesize($nuevoArchivo));
			readfile($nuevoArchivo);
			unlink($nuevoArchivo); // Eliminar el archivo después de la descarga
		} catch (\Throwable $th) {
			print_r($th);
		}
		break;
}