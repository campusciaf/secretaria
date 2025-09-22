<?php
session_start();
require_once "../modelos/CambioDocumento.php";
require "../mail/send.php";
require "../mail/template_cambio_cedula.php";
$cambio_documento = new CambioDocumento();
$op = (isset($_GET['op']))?$_GET['op']:"";
// variable para corregir el documento.
$numero_documento_estudiante  = isset($_POST["numero_documento_estudiante"]) ? limpiarCadena($_POST["numero_documento_estudiante"]) : "";
$id_credencial  = isset($_POST["id_credencial"]) ? limpiarCadena($_POST["id_credencial"]) : "";

switch ($op) {
	case 'verificar':
		$documento = $_POST['documento'];
		$tipo_documento = $_POST['tipoDocumento'];
		$verificar_documento = $cambio_documento->verificarDocumento($documento, $tipo_documento);
		if (empty($verificar_documento)) {
			echo 1;
		} else {
			echo json_encode($verificar_documento);
		}
		break;
	case 'verificar_cedula_cambio':
		$nueva_cedula = $_POST['nueva_cedula'];
		$verificar_cedula_cambio = $cambio_documento->verificarCedulaCambio($nueva_cedula);
		if (empty($verificar_cedula_cambio)) {
			echo 0;
		} else {
			echo json_encode($verificar_cedula_cambio);
		}
		break;
	case 'cambiar_tarjeta_cedula':
		$id_reemplazar = $_POST['id_reemplazar'];
		$numero_tarjeta = $_POST['numero_tarjeta'];
		$num_cedula = $_POST['num_cedula'];
		$fecha_exp = $_POST['fecha_exp'];
		$tipo_documento = "Cédula de Ciudadanía";
		$correo_institucional = $_POST["correo_institucional"];
		$cambiar_tarjeta_cedula = $cambio_documento->cambiarTarjetaCedula($id_reemplazar, $num_cedula, $fecha_exp, $tipo_documento);
		if ($cambiar_tarjeta_cedula) {
			$mensaje = set_template_cambio_documento($numero_tarjeta, $num_cedula);
			enviar_correo($correo_institucional, "Registro y control - Cambio de documento", $mensaje);
			echo 1;
		}
		break;
	case 'actualizar_cedula':
		$id_reemplazar =  $_POST['id_reemplazar'];
		$nueva_cedula = $_POST['nueva_cedula'];
		$documento_antiguo = $_POST['documento_antiguo_cambio'];
		$correo_institucional = $_POST['correo_institucional_cambio'];
		$actualizar_cedula = $cambio_documento->actualizarCedula($id_reemplazar, $nueva_cedula);
		if ($actualizar_cedula) {
			$mensaje = set_template_cambio_documento($documento_antiguo, $nueva_cedula);
			enviar_correo($correo_institucional, "Registro y control - Cambio de documento", $mensaje);
			echo 1;
		}
		break;

	case 'corregirCedula':
		$cedula_estudiante = $_POST['cedula_estudiante'];
		$verificar_documento_coregir = $cambio_documento->verificarDocumentoCoreregir($cedula_estudiante);
		if (empty($verificar_documento_coregir)) {
			echo 1;
		} else {
			echo json_encode($verificar_documento_coregir);
		}
		break;
	case 'editardocumentoestudiante':
		$rspta = $cambio_documento->editarDocumentoEstudiante($numero_documento_estudiante, $id_credencial);
		echo $rspta ? "Documento actualizado" : "Documento no se pudo actualizar";

		break;
}
