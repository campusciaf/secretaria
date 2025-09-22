<?php

session_start();
require_once "../modelos/HvFunPortafolio.php";
$Portafolio = new HvFunPortafolio();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die(json_encode(array("estatus" => 0, "valor" => "Tu sesión ha caducado, Reinicia la pagina")));
}
$id_portafolio = isset($_POST['id_portafolio']) ? $_POST['id_portafolio'] : "";
$titulo_portafolio = isset($_POST['titulo_portafolio']) ? $_POST['titulo_portafolio'] : "";
$video_portafolio = isset($_POST['video_portafolio']) ? $_POST['video_portafolio'] : "";
$descripcion_portafolio = isset($_POST['descripcion_portafolio']) ? $_POST['descripcion_portafolio'] : "";
$portafolio_archivo = isset($_FILES['portafolio_archivo']) ? $_FILES['portafolio_archivo'] : "";


$cedula = $_SESSION["usuario_identificacion"];
$rspta_usuario = $Portafolio->cv_traerIdUsuario($cedula);
$id_cvadministrativos = $rspta_usuario["id_cvadministrativos"];
$porcentaje_actual = $rspta_usuario["porcentaje_avance"];
$nuevo_porcentaje = $porcentaje_actual;

switch ($_GET['op']) {
    case 'guardaryeditarportafolio':
        //echo"asd";
        //revisar si el tipo de archivo es compatible con los que deseamos guardar en la base de datos 
        $file_type = $portafolio_archivo['type'];
        $allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf", ""); //archivos permitidos
        if (!in_array($file_type, $allowed)) {
            $inserto = array(
                "estatus" => 0,
                "valor" => "Formato de imagen no reconocido"
            );
            echo json_encode($inserto);
            exit();
        }
        if (empty($id_portafolio)) {
            $rspta = $Portafolio->cvinsertarPortafolio($id_cvadministrativos, $titulo_portafolio, $video_portafolio, $descripcion_portafolio,  "imagen");
            if ($rspta) {

                $conteo = $Portafolio->CuentoRegistros($id_cvadministrativos);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($porcentaje_actual < 50) {
                    // Aumenta a 20% si tiene 2 o más registros y aún no llega
                    $nuevo_porcentaje = 50;
                    $Portafolio->actualizar_porcentaje_personal($nuevo_porcentaje, $id_cvadministrativos);
                }
                $carpeta_destino = '../cv_funcionarios/portafolio/';
                $url_imagen = '../cv_funcionarios/portafolio/';

                if ($file_type == "application/pdf") {
                    $img1path = $carpeta_destino . "Portafolio_U" . $id_cvadministrativos . "_P" . $rspta . ".pdf";
                    $url_imagen = $url_imagen . "Portafolio_U" . $id_cvadministrativos . "_P" . $rspta . ".pdf";
                } else {
                    $img1path = $carpeta_destino . "Portafolio_U" . $id_cvadministrativos . "_P" . $rspta . ".jpg";
                    $url_imagen = $url_imagen . "Portafolio_U" . $id_cvadministrativos . "_P" . $rspta . ".jpg";
                }

                if ($file_type == "") {
                    $inserto = array(
                        "estatus" => 1,
                        "valor" => "Información Guardada, Recuerda anexar el certificado",
                        "porcentaje" => $nuevo_porcentaje
                    );
                    echo json_encode($inserto);
                } else {
                    if (move_uploaded_file($_FILES['portafolio_archivo']['tmp_name'], $img1path)) {
                        $rspta2 = $Portafolio->editarPortafolioArchivo($rspta, $url_imagen);
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
    case 'mostrarPortafolio':

        // if ($_SESSION["usuario_imagen"] || $_SESSION["usuario_imagen"]){

        //     $cadena = $_SESSION["usuario_imagen"];
        //     $separador = ".";
        //     $separada = explode($separador, $cadena);
        //     $cedula = $separada[0];
        //     $rspta_usuario = $Portafolio->cv_traerIdUsuario($cedula);

        // }

        if ($_SESSION["usuario_cargo"] == 'Docente') {


            $cadena = $_SESSION["usuario_imagen"];
            $separador = ".";
            $separada = explode($separador, $cadena);
            $cedula = $separada[0];
            $rspta_usuario = $Portafolio->cv_traerIdUsuario($cedula);
        } else {
            $cedula = $_SESSION["usuario_identificacion"];
            $rspta_usuario = $Portafolio->cv_traerIdUsuario($cedula);
        }

        $portafolios_stmt = $Portafolio->listarportafolio($cedula);
        if ($portafolios_stmt->rowCount() > 0) {
            $portafolios_arr = array();
            while ($row_portafolios = $portafolios_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_portafolios);
                $portafolios_arr[] = array(
                    'id_cvadministrativos' => $id_cvadministrativos,
                    'video_portafolio' => $video_portafolio,
                    'titulo_portafolio' => $titulo_portafolio,
                    'descripcion_portafolio' => $descripcion_portafolio,
                    'portafolio_archivo' => $portafolio_archivo,
                    'id_portafolio' => $id_portafolio
                );
            }
        } else {
            $portafolios_arr[] = array(
                'id_cvadministrativos' => "0",
                'video_portafolio' => "",
                'titulo_portafolio' => "",
                'descripcion_portafolio' => "",
                'id_portafolio' => ""
            );
        }
        echo (json_encode($portafolios_arr));
        break;
    case 'eliminarPortafolio':
        $rspta = $Portafolio->eliminarPortafolio($id_portafolio);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Información Elimanada"
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
