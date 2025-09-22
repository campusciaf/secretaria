<?php

session_start();

require_once "../modelos/CvEducacionFormacion.php";

$educacionFormacion = new CvEducacionFormacion();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die(json_encode(array("estatus" => 0, "valor" => "Tu sesión ha caducado, Reinicia la pagina")));
}
$usuario_imagen = isset($_POST['usuario_imagen']) ? $_POST['usuario_imagen'] : "";
$id_formacion = isset($_POST['id_formacion']) ? $_POST['id_formacion'] : "";
$institucion_academica = isset($_POST['institucion_academica']) ? $_POST['institucion_academica'] : "";
$titulo_obtenido = isset($_POST['titulo_obtenido']) ? $_POST['titulo_obtenido'] : "";
$desde_cuando_f = isset($_POST['desde_cuando_f']) ? $_POST['desde_cuando_f'] : "";
$hasta_cuando_f = isset($_POST['hasta_cuando_f']) ? $_POST['hasta_cuando_f'] : "";
$mas_detalles_f = isset($_POST['mas_detalles_f']) ? $_POST['mas_detalles_f'] : "";
$certificado_educacion = isset($_FILES['certificado_educacion']) ? $_FILES['certificado_educacion'] : "";
$nivel_formacion = isset($_POST['nivel_formacion']) ? $_POST['nivel_formacion'] : "";



if ($_SESSION["usuario_cargo"] == 'Docente') {


    $cadena = $_SESSION["usuario_imagen"];
    $separador = ".";
    $separada = explode($separador, $cadena);
    $cedula = $separada[0];
    $rspta_usuario = $educacionFormacion->cv_traerIdUsuario($cedula);
} else {
    $cedula = $_SESSION["usuario_identificacion"];
    $rspta_usuario = $educacionFormacion->cv_traerIdUsuario($cedula);
}

$id_usuario_cv = $rspta_usuario["id_usuario_cv"];
$porcentaje_actual = $rspta_usuario["porcentaje_avance"];
$nuevo_porcentaje = $porcentaje_actual;


switch ($_GET['op']) {
    case 'guardaryeditareducacion':
        //echo"asd";
        //revisar si el tipo de archivo es compatible con los que deseamos guardar en la base de datos 
        $file_type = $certificado_educacion['type'];
        $allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf", ""); //archivos permitidos
        if (!in_array($file_type, $allowed)) {
            $inserto = array(
                "estatus" => 0,
                "valor" => "Formato de imagen no reconocido"
            );
            echo json_encode($inserto);
            exit();
        }
        if (empty($id_formacion)) {
            $rspta = $educacionFormacion->insertarEducacion($id_usuario_cv, $institucion_academica, $titulo_obtenido, $desde_cuando_f, $hasta_cuando_f, $mas_detalles_f, "imagen", $nivel_formacion);
            if ($rspta) {
                $conteo = $educacionFormacion->CuentoRegistros($id_usuario_cv);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($totalRegistros >= 2 && $porcentaje_actual < 20) {
                    // Aumenta a 20% si tiene 2 o más registros y aún no llega
                    $nuevo_porcentaje = 20;
                    $educacionFormacion->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
                }
                $carpeta_destino = '../cv/files/certificados_estudio/';
                $url_imagen = '../files/certificados_estudio/';
                if ($file_type == "application/pdf") {
                    $img1path = $carpeta_destino . "certificado_U" . $id_usuario . "_F" . $rspta . ".pdf";
                    $url_imagen = $url_imagen . "certificado_U" . $id_usuario . "_F" . $rspta . ".pdf";
                } else {
                    $img1path = $carpeta_destino . "certificado_U" . $id_usuario . "_F" . $rspta . ".jpg";
                    $url_imagen = $url_imagen . "certificado_U" . $id_usuario . "_F" . $rspta . ".jpg";
                }

                if ($file_type == "") {
                    $inserto = array(
                        "estatus" => 1,
                        "valor" => "Información Guardada, Recuerda anexar el certificado",
                        "total_registros" => $totalRegistros,
                        "porcentaje" => $nuevo_porcentaje
                    );
                    echo json_encode($inserto);
                } else {
                    if (move_uploaded_file($_FILES['certificado_educacion']['tmp_name'], $img1path)) {
                        $rspta2 = $educacionFormacion->editarCertificado($rspta, $url_imagen);
                        if ($rspta2) {
                            $conteo = $educacionFormacion->CuentoRegistros($id_usuario_cv);
                            $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                            if ($totalRegistros >= 2 && $porcentaje_actual < 20) {
                                // Aumenta a 20% si tiene 2 o más registros y aún no llega
                                $nuevo_porcentaje = 20;
                                $educacionFormacion->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
                            }
                            $inserto = array(
                                "estatus" => 1,
                                "valor" => "Información Guardada",
                                "total_registros" => $totalRegistros,
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
        } else {
            $rspta = $educacionFormacion->editarEducacion($id_usuario_cv, $institucion_academica, $titulo_obtenido, $desde_cuando_f, $hasta_cuando_f, $mas_detalles_f, $id_formacion, "imagen", $nivel_formacion);
            if ($rspta) {
                $conteo = $educacionFormacion->CuentoRegistros($id_usuario_cv);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;

                if ($totalRegistros >= 2 && $porcentaje_actual < 20) {
                    // Aumenta a 20% si tiene 2 o más registros y aún no llega
                    $nuevo_porcentaje = 20;
                    $educacionFormacion->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
                }
                $carpeta_destino = '../cv/files/certificados_estudio/';
                $url_imagen = '../files/certificados_estudio/';
                if ($file_type == "application/pdf") {
                    $img1path = $carpeta_destino . "certificado_U" . $id_usuario_cv . "_F" . $id_formacion . ".pdf";
                    $url_imagen = $url_imagen . "certificado_U" . $id_usuario_cv . "_F" . $id_formacion . ".pdf";
                } else {
                    $img1path = $carpeta_destino . "certificado_U" . $id_usuario_cv . "_F" . $id_formacion . ".jpg";
                    $url_imagen = $url_imagen . "certificado_U" . $id_usuario_cv . "_F" . $id_formacion . ".jpg";
                }
                if ($file_type == "") {
                    $inserto = array(
                        "estatus" => 1,
                        "valor" => "Información Actualizada, Recuerda anexar el certificado",
                        "porcentaje" => $nuevo_porcentaje
                    );
                    echo json_encode($inserto);
                } else {
                    if (move_uploaded_file($_FILES['certificado_educacion']['tmp_name'], $img1path)) {
                        $rspta = $educacionFormacion->editarCertificado($id_formacion, $url_imagen);
                        if ($rspta) {
                            $inserto = array(
                                "estatus" => 1,
                                "valor" => "Información Actualizada",
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
    case 'mostrarEducacion':
        //como tenemos el documento de las tablas cv pero no tenemos el id de esa tabla, toca consultarlo por medio del documento

        // if ($_SESSION["usuario_imagen"] || $_SESSION["usuario_imagen"]){

        //     $cadena = $_SESSION["usuario_imagen"];
        //     $separador = ".";
        //     $separada = explode($separador, $cadena);
        //     $cedula = $separada[0];
        //     $rspta_usuario = $educacionFormacion->cv_traerIdUsuario($cedula);
        // }


        if ($_SESSION["usuario_cargo"] == 'Docente') {


            $cadena = $_SESSION["usuario_imagen"];
            $separador = ".";
            $separada = explode($separador, $cadena);
            $cedula = $separada[0];
            $rspta_usuario = $educacionFormacion->cv_traerIdUsuario($cedula);
        } else {
            $cedula = $_SESSION["usuario_identificacion"];
            $rspta_usuario = $educacionFormacion->cv_traerIdUsuario($cedula);
        }

        $id_usuario_cv = $rspta_usuario["id_usuario_cv"];


        // $rspta_usuario = $educacionFormacion->cv_traerIdUsuario($_SESSION["usuario_identificacion"]);
        // $id_usuario_cv = $rspta_usuario["id_usuario_cv"];
        $educacions_stmt = $educacionFormacion->cv_listareducacion($id_usuario_cv);
        if ($educacions_stmt->rowCount() > 0) {
            $educacions_arr = array();
            while ($row_educacions = $educacions_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_educacions);
                $educacions_arr[] = array(
                    'id_usuario' => $id_usuario_cv,
                    'titulo_obtenido' => $titulo_obtenido,
                    'institucion_academica' => $institucion_academica,
                    'desde_cuando_f' => $desde_cuando_f,
                    'hasta_cuando_f' => $hasta_cuando_f,
                    'mas_detalles_f' => $mas_detalles_f,
                    'certificado_educacion' => $certificado_educacion,
                    'id_formacion' => $id_formacion
                );
            }
        } else {
            $educacions_arr[] = array(
                'id_usuario_cv' => "0",
                'titulo_obtenido' => "",
                'institucion_academica' => "",
                'desde_cuando_f' => "",
                'hasta_cuando_f' => "",
                'mas_detalles_f' => "",
                'id_formacion' => ""
            );
        }
        echo (json_encode($educacions_arr));
        break;
    case 'eliminarEducacion':
        $rspta = $educacionFormacion->eliminarEducacion($id_formacion);
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
    case 'verEducacionEspecifica':
        $educacion_stmt = $educacionFormacion->listarEducacionEspecifica($id_formacion);
        if ($educacion_stmt->rowCount() > 0) {
            $educacion_arr = array();
            $row_educacion = $educacion_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row_educacion);
            $educacion_arr[] = array(
                'id_usuario_cv' => $id_usuario_cv,
                'titulo_obtenido' => $titulo_obtenido,
                'institucion_academica' => $institucion_academica,
                'desde_cuando_f' => $desde_cuando_f,
                'hasta_cuando_f' => $hasta_cuando_f,
                'mas_detalles_f' => $mas_detalles_f,
                'nivel_formacion' => $nivel_formacion,
                'id_formacion' => $id_formacion,
                'certificado_educacion' => $certificado_educacion
            );
        } else {

            $educacion_arr[] = array(
                'id_usuario_cv' => "0",
                'titulo_obtenido' => "",
                'institucion_academica' => "",
                'desde_cuando_f' => "",
                'hasta_cuando_f' => "",
                'mas_detalles_f' => "",
                'id_formacion' => ""
            );
        }
        echo (json_encode($educacion_arr));
        break;



    case "selectListarNivelFormacion":
        $rspta = $educacionFormacion->selectlistarNivelFormacion();
        echo "<option selected>Nothing selected</option>";
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["id_nivel_formacion"] . "'>" . $rspta[$i]["nombre_formacion"] . "</option>";
        }
        break;

    // funcion para actualizar el porcentaje actual del progreso de la hoja de vida,
    case 'actualizar_porcentaje_continuar':
        $id_usuario_cv = $_POST["id_usuario_cv_global"];
        $porcentaje_paso_actual = $_POST["porcentaje"];
        // obtenemos el valor del porcentaje actual.
        $obtener_porcentaje_actual = $educacionFormacion->obtenerPorcentajeAvance_dinamico($id_usuario_cv);
        $porcentaje_actual_guardado = $obtener_porcentaje_actual['porcentaje_avance'];
        if ($porcentaje_paso_actual > $porcentaje_actual_guardado) {
            // Solo actualiza si el nuevo es mayor al porcentaje actual.
            $rspta = $educacionFormacion->actualizar_porcentaje_personal_dinamico($porcentaje_paso_actual, $id_usuario_cv);
            if ($rspta) {
                // actualiza el porcentaje
                echo json_encode([
                    "estatus" => 1,
                    "valor" => "Información actualizada"
                ]);
            } else {
                echo json_encode([
                    "estatus" => 0,
                    "valor" => "La información no se pudo actualizar"
                ]);
            }
        } else {
            // mensaje si no se actualiza cuando esta en un porcentaje mayor.
            echo json_encode([
                "estatus" => 1, // mantenemos estatus en 1 para no bloquear avance
                "valor" => "Información actualizada"
            ]);
        }
        break;
}
