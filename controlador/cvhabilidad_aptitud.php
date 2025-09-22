<?php

session_start();

require_once "../modelos/CvHabilidadAptitud.php";

$habilidadAptitud = new CvHabilidadAptitud();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die(json_encode(array("estatus" => 0, "valor" => "Tu sesión ha caducado, Reinicia la pagina")));
}
$id_habilidad = isset($_POST['id_habilidad']) ? $_POST['id_habilidad'] : "";
$nombre_categoria = isset($_POST['categoria_habilidad']) ? $_POST['categoria_habilidad'] : "";
$nivel_habilidad = isset($_POST['nivel_habilidad']) ? $_POST['nivel_habilidad'] : "";


if ($_SESSION["usuario_cargo"] == 'Docente') {


    $cadena = $_SESSION["usuario_imagen"];
    $separador = ".";
    $separada = explode($separador, $cadena);
    $cedula = $separada[0];
    $rspta_usuario = $habilidadAptitud->cv_traerIdUsuario($cedula);
} else {
    $cedula = $_SESSION["usuario_identificacion"];
    $rspta_usuario = $habilidadAptitud->cv_traerIdUsuario($cedula);
}
$id_usuario_cv = $rspta_usuario["id_usuario_cv"];
$porcentaje_actual = $rspta_usuario["porcentaje_avance"];
$nuevo_porcentaje = $porcentaje_actual;
switch ($_GET['op']) {
    case 'guardaryeditarhabilidad':
        if (empty($id_habilidad)) {
            $rspta = $habilidadAptitud->cv_insertarHabilidad($id_usuario_cv, $nombre_categoria, $nivel_habilidad);
            if ($rspta) {
                $conteo = $habilidadAptitud->CuentoRegistros($id_usuario_cv);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($totalRegistros >= 2 && $porcentaje_actual < 40) {
                    // Aumenta a 20% si tiene 2 o más registros y aún no llega
                    $nuevo_porcentaje = 40;
                    $habilidadAptitud->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
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
                    "valor" => "La información no se pudo Actualizar",
                    "total_registros" => $totalRegistros,
                    "porcentaje" => $nuevo_porcentaje
                );
                echo json_encode($inserto);
            }
        } else {
            $rspta = $habilidadAptitud->cv_editarHabilidad($id_usuario_cv, $id_habilidad, $nombre_categoria, $nivel_habilidad);
            if ($rspta) {
                $conteo = $habilidadAptitud->CuentoRegistros($id_usuario_cv);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;

                if ($totalRegistros >= 2 && $porcentaje_actual < 40) {
                    // Aumenta a 20% si tiene 2 o más registros y aún no llega
                    $nuevo_porcentaje = 40;
                    $habilidadAptitud->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
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

    case 'mostrarHabilidades':
        $habilidad_stmt = $habilidadAptitud->cv_listarHabilidad($id_usuario_cv);
        if ($habilidad_stmt->rowCount() > 0) {
            $habilidad_arr = array();
            while ($row_habilidad = $habilidad_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_habilidad);
                $habilidad_arr[] = array(
                    'id_habilidad' => $id_habilidad,
                    'nombre_categoria' => $nombre_categoria,
                    'nivel_habilidad' => $nivel_habilidad,
                    'id_usuario_cv' => $id_usuario_cv,
                );
            }
        } else {
            $habilidad_arr[] = array(
                'id_habilidad' => "",
                'nombre_categoria' => "",
                'nivel_habilidad' => "",
                'id_usuario' => "0"
            );
        }
        echo (json_encode($habilidad_arr));
        break;
    case 'eliminarHabilidad':
        $rspta = $habilidadAptitud->cv_eliminarHabilidad($id_habilidad);
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
    case 'verHabilidadEspecifica':
        $habilidad_stmt = $habilidadAptitud->cv_listarHabilidadEspecifica($id_habilidad);
        if ($habilidad_stmt->rowCount() > 0) {
            $habilidad_arr = array();
            $row_habilidad = $habilidad_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row_habilidad);
            $habilidad_arr[] = array(
                'id_habilidad' => $id_habilidad,
                'nombre_categoria' => $nombre_categoria,
                'nivel_habilidad' => $nivel_habilidad,
                'id_usuario_cv' => $id_usuario_cv,
            );
        } else {
            $habilidad_arr[] = array(
                'id_habilidad' => "",
                'nombre_categoria' => "",
                'nivel_habilidad' => "",
                'id_usuario_cv' => "0"
            );
        }
        echo (json_encode($habilidad_arr));
        break;
}
