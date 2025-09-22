<?php

session_start();

require_once "../modelos/HvFunAreasdeConocimiento.php";

$areasdeConocimiento = new HvFunAreasdeConocimiento();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die(json_encode(array("estatus" => 0, "valor" => "Tu sesión ha caducado, Reinicia la pagina")));
}
$nombre_area = isset($_POST['nombre_area']) ? $_POST['nombre_area'] : "";
$id_area = isset($_POST['id_area']) ? $_POST['id_area'] : "";

$cedula = $_SESSION["usuario_identificacion"];
$rspta_usuario = $areasdeConocimiento->cv_traerIdUsuario($cedula);
$id_cvadministrativos = $rspta_usuario["id_cvadministrativos"];
$porcentaje_actual = $rspta_usuario["porcentaje_avance"];
$nuevo_porcentaje = $porcentaje_actual;

switch ($_GET['op']) {
    case 'guardaryeditararea':
        $rspta = $areasdeConocimiento->cvinsertarArea($id_cvadministrativos, $nombre_area);
        if ($rspta) {
            $conteo = $areasdeConocimiento->CuentoRegistros($id_cvadministrativos);
            $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
            if ($totalRegistros >= 2 && $porcentaje_actual < 100) {
                // Aumenta a 20% si tiene 2 o más registros y aún no llega
                $nuevo_porcentaje = 100;
                $areasdeConocimiento->actualizar_porcentaje_personal($nuevo_porcentaje, $id_cvadministrativos);
            }
            $inserto = array(
                "estatus" => 1,
                "valor" => "Información Guardada",
                "porcentaje" => $nuevo_porcentaje
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo Guardar",
                "porcentaje" => $nuevo_porcentaje
            );
            echo json_encode($inserto);
        }
        break;
    case 'mostrarAreas':
        $area_stmt = $areasdeConocimiento->cv_listarArea($id_cvadministrativos);
        if ($area_stmt->rowCount() > 0) {
            $area_arr = array();
            while ($row_area = $area_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_area);
                $area_arr[] = array(
                    'id_area' => $id_area,
                    'nombre_area' => $nombre_area,
                );
            }
        } else {
            $area_arr[] = array(
                'id_area' => "",
                'nombre_area' => "",
                'id_cvadministrativos' => "0"
            );
        }
        echo (json_encode($area_arr));
        break;
    case 'eliminarArea':
        $rspta = $areasdeConocimiento->cveliminarArea($id_area);
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
