<?php

session_start();

require_once "../modelos/CvReferenciasLaborales.php";
$referenciasLaborales = new CvReferenciasLaborales();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die(json_encode(array("estatus" => 0, "valor" => "Tu sesión ha caducado, Reinicia la pagina")));
}
$id_referenciasl = isset($_POST['id_referenciasl']) ? $_POST['id_referenciasl'] : "";
$referencias_nombrel = isset($_POST['referencias_nombrel']) ? $_POST['referencias_nombrel'] : "";
$referencias_profesionl = isset($_POST['referencias_profesionl']) ? $_POST['referencias_profesionl'] : "";
$referencias_empresal = isset($_POST['referencias_empresal']) ? $_POST['referencias_empresal'] : "";
$referencias_telefonol = isset($_POST['referencias_telefonol']) ? $_POST['referencias_telefonol'] : "";



if ($_SESSION["usuario_cargo"] == 'Docente') {


    $cadena = $_SESSION["usuario_imagen"];
    $separador = ".";
    $separada = explode($separador, $cadena);
    $cedula = $separada[0];
    $rspta_usuario = $referenciasLaborales->cv_traerIdUsuario($cedula);
} else {
    $cedula = $_SESSION["usuario_identificacion"];
    $rspta_usuario = $referenciasLaborales->cv_traerIdUsuario($cedula);
}

// $rspta_usuario = $referenciasLaborales->cv_traerIdUsuario($_SESSION["usuario_identificacion"]);
$id_usuario_cv = $rspta_usuario["id_usuario_cv"];
$porcentaje_actual = $rspta_usuario["porcentaje_avance"];
$nuevo_porcentaje = $porcentaje_actual;

switch ($_GET['op']) {
    case 'guardaryeditarreferencias_laborales':
        if (empty($id_referenciasl)) {
            $rspta = $referenciasLaborales->cvinsertarReferencias($id_usuario_cv, $referencias_nombrel, $referencias_profesionl, $referencias_empresal, $referencias_telefonol);
            if ($rspta) {
                $conteo = $referenciasLaborales->CuentoRegistros($id_usuario_cv);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($totalRegistros >= 2 && $porcentaje_actual < 70) {
                    $nuevo_porcentaje = 70;
                    $referenciasLaborales->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
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
            $rspta = $referenciasLaborales->cveditarReferencias($id_usuario_cv, $referencias_nombrel, $referencias_profesionl, $referencias_empresal, $referencias_telefonol, $id_referenciasl);
            if ($rspta) {
                $conteo = $referenciasLaborales->CuentoRegistros($id_usuario_cv);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($totalRegistros >= 2 && $porcentaje_actual < 70) {
                    $nuevo_porcentaje = 70;
                    $referenciasLaborales->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
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
    case 'mostrarReferenciasLaborales':

        // if ($_SESSION["usuario_imagen"] || $_SESSION["usuario_imagen"]){

        //     $cadena = $_SESSION["usuario_imagen"];
        //     $separador = ".";
        //     $separada = explode($separador, $cadena);
        //     $cedula = $separada[0];
        //     $rspta_usuario = $referenciasLaborales->cv_traerIdUsuario($cedula);

        // }

        if ($_SESSION["usuario_cargo"] == 'Docente') {


            $cadena = $_SESSION["usuario_imagen"];
            $separador = ".";
            $separada = explode($separador, $cadena);
            $cedula = $separada[0];
            $rspta_usuario = $referenciasLaborales->cv_traerIdUsuario($cedula);
        } else {
            $cedula = $_SESSION["usuario_identificacion"];
            $rspta_usuario = $referenciasLaborales->cv_traerIdUsuario($cedula);
        }

        $referencias_stmt = $referenciasLaborales->cv_listarReferencias($cedula);
        if ($referencias_stmt->rowCount() > 0) {
            $referencias_arr = array();
            while ($row_referencias = $referencias_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_referencias);
                $referencias_arr[] = array(
                    'id_referenciasl' => $id_referencias,
                    'referencias_nombrel' => $referencias_nombre,
                    'referencias_profesionl' => $referencias_profesion,
                    'referencias_empresal' => $referencias_empresa,
                    'referencias_telefonol' => $referencias_telefono,
                    'id_usuario' => $id_usuario,
                );
            }
        } else {
            $referencias_arr[] = array(
                'id_referenciasl' => "",
                'referencias_nombrel' => "",
                'referencias_profesionl' => "",
                'referencias_empresal' => "",
                'referencias_telefonol' => "",
                'id_usuario' => "0"
            );
        }
        echo (json_encode($referencias_arr));
        break;
    case 'eliminarReferenciaLaborales':
        $rspta = $referenciasLaborales->cveliminarReferencias($id_referenciasl);
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

    case 'verReferencialaboralespecifica':
        $referencias_stmt = $referenciasLaborales->cvlistarReferenciasEspecifica($id_referenciasl);
        if ($referencias_stmt->rowCount() > 0) {
            $referencias_arr = array();
            $row_referencias = $referencias_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row_referencias);
            $referencias_arr[] = array(
                'id_referenciasl' => $id_referencias,
                'referencias_nombrel' => $referencias_nombre,
                'referencias_profesionl' => $referencias_profesion,
                'referencias_empresal' => $referencias_empresa,
                'referencias_telefonol' => $referencias_telefono,
                'id_usuario' => $id_usuario,
            );
        } else {
            $referencias_arr[] = array(
                'id_referenciasl' => "",
                'referencias_nombrel' => "",
                'referencias_profesionl' => "",
                'id_usuario' => "0"
            );
        }
        echo (json_encode($referencias_arr));
        break;
}
