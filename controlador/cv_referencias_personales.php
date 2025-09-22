<?php

session_start();

require_once "../modelos/CvReferenciasPersonales.php";
$referenciasPersonales = new CvReferenciasPersonales();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die(json_encode(array("estatus" => 0, "valor" => "Tu sesión ha caducado, Reinicia la pagina")));
}
$id_referencias = isset($_POST['id_referencias']) ? $_POST['id_referencias'] : "";
$referencias_nombre = isset($_POST['referencias_nombre']) ? $_POST['referencias_nombre'] : "";
$referencias_profesion = isset($_POST['referencias_profesion']) ? $_POST['referencias_profesion'] : "";
$referencias_empresa = isset($_POST['referencias_empresa']) ? $_POST['referencias_empresa'] : "";
$referencias_telefono = isset($_POST['referencias_telefono']) ? $_POST['referencias_telefono'] : "";



if ($_SESSION["usuario_cargo"] == 'Docente') {


    $cadena = $_SESSION["usuario_imagen"];
    $separador = ".";
    $separada = explode($separador, $cadena);
    $cedula = $separada[0];
    $rspta_usuario = $referenciasPersonales->cv_traerIdUsuario($cedula);
} else {
    $cedula = $_SESSION["usuario_identificacion"];
    $rspta_usuario = $referenciasPersonales->cv_traerIdUsuario($cedula);
}

// $rspta_usuario = $referenciasPersonales->cv_traerIdUsuario($_SESSION["usuario_identificacion"]);
$id_usuario_cv = $rspta_usuario["id_usuario_cv"];
$porcentaje_actual = $rspta_usuario["porcentaje_avance"];
$nuevo_porcentaje = $porcentaje_actual;

switch ($_GET['op']) {
    case 'guardaryeditarreferencias_personales':
        if (empty($id_referencias)) {
            $rspta = $referenciasPersonales->cvinsertarReferencias($id_usuario_cv, $referencias_nombre, $referencias_profesion, $referencias_empresa, $referencias_telefono);
            if ($rspta) {
                $conteo = $referenciasPersonales->CuentoRegistros($id_usuario_cv);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($totalRegistros >= 2 && $porcentaje_actual < 60) {
                    $nuevo_porcentaje = 60;
                    $referenciasPersonales->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
                }
                $inserto = array(
                    "estatus" => 1,
                    "valor" => "Información Guardada",
                    "total_registros" => $totalRegistros,
                    "porcentaje" => $nuevo_porcentaje
                );
                echo json_encode($inserto);
            } else {
                $inserto = array(
                    "estatus" => 0,
                    "valor" => "La información no se pudo Guardar",
                    "total_registros" => $totalRegistros,
                    "porcentaje" => $nuevo_porcentaje
                );
                echo json_encode($inserto);
            }
        } else {
            $rspta = $referenciasPersonales->cveditarReferencias($id_usuario_cv, $referencias_nombre, $referencias_profesion, $referencias_empresa, $referencias_telefono, $id_referencias);
            if ($rspta) {
                $conteo = $referenciasPersonales->CuentoRegistros($id_usuario_cv);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($totalRegistros >= 2 && $porcentaje_actual < 60) {
                    $nuevo_porcentaje = 60;
                    $referenciasPersonales->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
                }
                $inserto = array(
                    "estatus" => 1,
                    "valor" => "Información Actualizada",
                    "porcentaje" => $nuevo_porcentaje
                );
                echo json_encode($inserto);
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
    case 'mostrarReferenciasPersonales':
        // if ($_SESSION["usuario_imagen"] || $_SESSION["usuario_imagen"]){

        //     $cadena = $_SESSION["usuario_imagen"];
        //     $separador = ".";
        //     $separada = explode($separador, $cadena);
        //     $cedula = $separada[0];
        //     $rspta_usuario = $referenciasPersonales->cv_traerIdUsuario($cedula);

        // }


        if ($_SESSION["usuario_cargo"] == 'Docente') {


            $cadena = $_SESSION["usuario_imagen"];
            $separador = ".";
            $separada = explode($separador, $cadena);
            $cedula = $separada[0];
            $rspta_usuario = $referenciasPersonales->cv_traerIdUsuario($cedula);
        } else {
            $cedula = $_SESSION["usuario_identificacion"];
            $rspta_usuario = $referenciasPersonales->cv_traerIdUsuario($cedula);
        }

        $referencias_stmt = $referenciasPersonales->cvlistarReferencias($cedula);
        if ($referencias_stmt->rowCount() > 0) {
            $referencias_arr = array();
            while ($row_referencias = $referencias_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_referencias);
                $referencias_arr[] = array(
                    'id_referencias' => $id_referencias,
                    'referencias_nombre' => $referencias_nombre,
                    'referencias_profesion' => $referencias_profesion,
                    'referencias_empresa' => $referencias_empresa,
                    'referencias_telefono' => $referencias_telefono,
                    'id_usuario' => $id_usuario,
                );
            }
        } else {
            $referencias_arr[] = array(
                'id_referencias' => "",
                'referencias_nombre' => "",
                'referencias_profesion' => "",
                'referencias_empresa' => "",
                'referencias_telefono' => "",
                'id_usuario' => "0"
            );
        }
        echo (json_encode($referencias_arr));
        break;
    case 'eliminarReferenciaPersonal':
        $rspta = $referenciasPersonales->cveliminarReferencias($id_referencias);
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

    case 'verReferenciaPersonalEspecifica':
        $referencias_stmt = $referenciasPersonales->cvlistarReferenciasEspecifica($id_referencias);
        if ($referencias_stmt->rowCount() > 0) {
            $referencias_arr = array();
            $row_referencias = $referencias_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row_referencias);
            $referencias_arr[] = array(
                'id_referencias' => $id_referencias,
                'referencias_nombre' => $referencias_nombre,
                'referencias_profesion' => $referencias_profesion,
                'referencias_empresa' => $referencias_empresa,
                'referencias_telefono' => $referencias_telefono,
                'id_usuario' => $id_usuario,
            );
        } else {
            $referencias_arr[] = array(
                'id_referencias' => "",
                'referencias_nombre' => "",
                'referencias_profesion' => "",
                'referencias_empresa' => "",
                'referencias_telefono' => "",
                'id_usuario' => "0"
            );
        }
        echo (json_encode($referencias_arr));
        break;
}
