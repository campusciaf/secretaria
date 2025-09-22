<?php
session_start();
require_once "../modelos/CvDocumentosAdicionales.php";
$documentosAdicionales = new CvDocumentosAdicionales();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die(json_encode(array("estatus" => 0, "valor" => "Tu sesión ha caducado, Reinicia la pagina")));
}
$id_documentoA = isset($_POST['id_documentoA']) ? $_POST['id_documentoA'] : "";
$documento_nombreA = isset($_POST['documento_nombreA']) ? $_POST['documento_nombreA'] : "";
$documento_archivoA = isset($_POST['documento_archivoA']) ? $_POST['documento_archivoA'] : "";
$documento_archivoA_file = isset($_FILES['documento_archivoA']) ? $_FILES['documento_archivoA'] : "";


if ($_SESSION["usuario_cargo"] == 'Docente') {


    $cadena = $_SESSION["usuario_imagen"];
    $separador = ".";
    $separada = explode($separador, $cadena);
    $cedula = $separada[0];
    $rspta_usuario = $documentosAdicionales->cv_traerIdUsuario($cedula);
} else {
    $cedula = $_SESSION["usuario_identificacion"];
    $rspta_usuario = $documentosAdicionales->cv_traerIdUsuario($cedula);
}

$id_usuario_cv = $rspta_usuario["id_usuario_cv"];
$porcentaje_actual = $rspta_usuario["porcentaje_avance"];
$nuevo_porcentaje = $porcentaje_actual;
switch ($_GET['op']) {


    case 'guardaryeditardocumentos_adicionales':
        //echo"asd";
        //revisar si el tipo de archivo es compatible con los que deseamos guardar en la base de datos 
        $file_type = $documento_archivoA_file['type'];
        $allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf", ""); //archivos permitidos
        if (!in_array($file_type, $allowed)) {
            $inserto = array(
                "estatus" => 0,
                "valor" => "Formato de imagen no reconocido"
            );
            echo json_encode($inserto);
            exit();
        }
        if (empty($id_documentacion)) {
            $rspta = $documentosAdicionales->cvinsertarDocumentosA($id_usuario_cv, $documento_nombreA, "imagen");
            if ($rspta) {
                $conteo = $documentosAdicionales->CuentoRegistros($id_usuario_cv);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($porcentaje_actual < 90) {
                    // Aumenta a 20% si tiene 2 o más registros y aún no llega
                    $nuevo_porcentaje = 90;
                    $documentosAdicionales->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
                }
                $carpeta_destino = '../cv/files/documentos/';
                if ($file_type == "application/pdf") {
                    $img1path = $carpeta_destino . "documento_U" . $id_usuario . "_A" . $rspta . ".pdf";
                } else {
                    $img1path = $carpeta_destino . "documento_U" . $id_usuario . "_A" . $rspta . ".jpg";
                }

                if ($file_type == "") {
                    $inserto = array(
                        "estatus" => 1,
                        "valor" => "Información Guardada, Recuerda anexar el certificado"
                    );
                    echo json_encode($inserto);
                } else {
                    if (move_uploaded_file($_FILES['documento_archivoA']['tmp_name'], $img1path)) {
                        $rspta2 = $documentosAdicionales->editarDocumentoA($rspta, $img1path);
                        if ($rspta2) {
                            $inserto = array(
                                "estatus" => 1,
                                "valor" => "Información Guardada",
                                    "porcentaje" => $nuevo_porcentaje
                            );
                        }
                        echo json_encode($inserto);
                    }
                }
            } else {
                $inserto = array(
                    "estatus" => 0,
                    "valor" => "La información no se pudo Actualizar",
                    "porcentaje" => $nuevo_porcentaje
                );
                echo json_encode($inserto);
            }
        }
        break;

    case 'mostrarDocumentosAdicionales':
        $documentosA_stmt = $documentosAdicionales->cvalistarDocumentosAdicionales($id_usuario_cv);
        if ($documentosA_stmt->rowCount() > 0) {
            $documentosA_arr = array();
            while ($documentosArow_ = $documentosA_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($documentosArow_);
                $documentosA_arr[] = array(
                    'id_documentoA' => $id_documentacion,
                    'documento_nombreA' => $documento_nombre,
                    'documento_archivoA' => $documento_archivo,
                    'id_usuario_cv' => $id_usuario_cv,
                );
            }
        } else {
            $documentosA_arr[] = array(
                'id_documentoA' => "",
                'documento_nombreA' => "",
                'documento_archivoA' => "",
                'id_usuario_cv' => "0",
            );
        }
        echo (json_encode($documentosA_arr));
        break;
    case 'eliminarDocumentoAdicional':
        $rspta = $documentosAdicionales->cvdocumentosAeliminar($id_documentoA);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Información Eliminada"
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo eliminar"
            );
            echo json_encode($inserto);
        }
        break;
}
