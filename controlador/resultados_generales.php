<?php
require_once "../modelos/ResultadosGenerales.php";
$resultado = new ResultadosGenerales();
$periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
$periodo = empty($periodo) ? $_SESSION['periodo_actual'] : $periodo;
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$estado = isset($_POST["estado"]) ? $_POST["estado"] : "";
switch ($_GET['op']) {
    case 'selectPeriodo':
        $rspta = $resultado->listarPeriodos();
        echo json_encode($rspta);
        break;
    case 'consulta':
        $datos = $resultado->listarDocentes();
        $array = array();
        for ($i = 0; $i < count($datos); $i++) {
            $sumar_promedio = 0;
            $promedio_total = 0;
            $id_docente = $datos[$i]["id_usuario"];
            $porcentaje = $resultado->promedioCalculado($id_docente, $periodo);
            // for ($j = 0; $j < count($docente_grupos); $j++) {
            //     $promedio = $resultado->listarResultados($docente_grupos[$j]['id_docente_grupo'], $periodo);
            //     if ($promedio && count($promedio) > 0) {
            //         if (!empty($promedio["promedio"]) && $promedio["promedio"] != 0) {
            //             $sumar_promedio += $promedio["promedio"];
            //             $promedio_total += 1;
            //         }
            //     }
            // }
            // $promedio_total = ($promedio_total == 0) ? 1 : $promedio_total;
            $img = (file_exists("../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg")) ? "../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg" : "../files/null.jpg";
            $nombre = $datos[$i]["usuario_nombre"] . " " . $datos[$i]["usuario_nombre_2"] . " " . $datos[$i]["usuario_apellido"] . " " . $datos[$i]["usuario_apellido_2"];
            if ($porcentaje > 90) {
                $color = "bg-success";
            } else if ($porcentaje > 80) {
                $color = "bg-orange";
            } else if ($porcentaje > 70) {
                $color = "bg-warning";
            } else {
                $color = "bg-danger";
            }
            $total_heteroevaluacion = round($porcentaje, 2);
            //Co-evaluacion Docente
            $coevaluacion_rspta = $resultado->buscarResultadoPeriodo($id_docente, $periodo);
            $total_coevaluacion = round((count($coevaluacion_rspta) > 0) ? $coevaluacion_rspta[0]["total"] : 0, 2);
            if ($total_coevaluacion > 90) {
                $color_coevaluacion = "bg-success";
            } else if ($total_coevaluacion > 80) {
                $color_coevaluacion = "bg-orange";
            } else if ($total_coevaluacion > 70) {
                $color_coevaluacion = "bg-warning";
            } else {
                $color_coevaluacion = "bg-danger";
            }
            //Auto-evaluacion Docente
            $autoevaluacion_rspta = $resultado->autoevaluacionDocente($id_docente, $periodo);
            $total_autoevaluacion = round((count($autoevaluacion_rspta) > 0) ? $autoevaluacion_rspta[0]["total"] : 0, 2);
            if ($total_autoevaluacion > 90) {
                $color_autoevaluacion = "bg-success";
            } else if ($total_autoevaluacion > 80) {
                $color_autoevaluacion = "bg-orange";
            } else if ($total_autoevaluacion > 70) {
                $color_autoevaluacion = "bg-warning";
            } else {
                $color_autoevaluacion = "bg-danger";
            }
            //total promedio ponderado
            $total_ponderado = round(($total_heteroevaluacion * 0.30) + ($total_coevaluacion * 0.40) + ($total_autoevaluacion * 0.30), 2);
            if ($total_ponderado > 90) {
                $color_ponderado = "bg-success";
            } else if ($total_ponderado > 80) {
                $color_ponderado = "bg-orange";
            } else if ($total_ponderado > 70) {
                $color_ponderado = "bg-warning";
            } else {
                $color_ponderado = "bg-danger";
            }
            $array[] = array(
                "0" => "<img src='" . $img . "' class='direct-chat-img' width='50px' height='50px'>",
                "1" => mb_convert_case($nombre, MB_CASE_TITLE, "UTF-8") .
                    '<br><b style="font-size: 12px;" class="text-primary" title="Identificación"><i class="fa fa-id-card"></i> ' . $datos[$i]["usuario_identificacion"] . '</b>',
                "2" => $datos[$i]["usuario_celular"],
                "3" => $datos[$i]["usuario_email_p"],
                "4" => '<div style="padding-top:5px"><div class="progress progress-xs"><div class="progress-bar ' . $color . '" style="width: ' . $total_heteroevaluacion . '%"></div></div>' . $total_heteroevaluacion . ' % </div>',
                "5" => '<div style="padding-top:5px"><div class="progress progress-xs"><div class="progress-bar ' . $color_autoevaluacion . '" style="width: ' . $total_autoevaluacion . '%"></div></div>' . $total_autoevaluacion . ' % </div>',
                "6" => '<div style="padding-top:5px"><div class="progress progress-xs"><div class="progress-bar ' . $color_coevaluacion . '" style="width: ' . $total_coevaluacion . '%"></div></div>' . $total_coevaluacion . ' % </div>',
                "7" => '<div style="padding-top:5px"><div class="progress progress-xs"><div class="progress-bar ' . $color_ponderado . '" style="width: ' . $total_ponderado . '%"></div></div>' . $total_ponderado . ' % </div>',
            );
        }
        //se crea otro array para almacenar toda la informacion que analizara el datatable
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
    break;
      
}
