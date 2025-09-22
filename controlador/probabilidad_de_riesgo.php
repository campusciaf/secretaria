<?php
require_once "../modelos/ProbabilidadReRiesgo.php";

$probabilidadriesgo = new ProbabilidadReRiesgo();
switch ($_GET['op']) {
    // case "selectlistaranios":
    //     $rspta = $probabilidadriesgo->selectPeriodo();
    //     for ($i = 0; $i < count($rspta); $i++) {
    //         echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
    //     }
    //     break;

    case 'buscar_por_porcentaje':
        $val_boton_seleccionado = $_POST["val_boton_seleccionado"];
        // $periodoSeleccionado = $_POST["periodoSeleccionado"];
        $rspta    = $probabilidadriesgo->consultar_resultado($val_boton_seleccionado);
        $data = array();
        $reg = $rspta;
        for ($i = 0; $i < count($reg); $i++) {
            $probabilidad_desercion = $reg[$i]["probabilidad_desercion"];
            $credencial_identificacion = $reg[$i]["credencial_identificacion"];
            $nombre = $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"] . ' ' . $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"];
            $barra = '<div style="width:100px" data-toggle="tooltip" data-placement="top" title="Probabilidad de deserción">'
                . $probabilidadriesgo->getBarraProgreso($probabilidad_desercion)
                . '</div>';
            $data[] = array(
                "0" => $credencial_identificacion,
                "1" => $nombre,
                "2" => $barra,

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;
}
