<?php
require_once "../modelos/SofiRecaudoDia.php";
$consulta = new SofiRecaudoDia();
switch ($_GET['op']) {
    case 'listar':
        $inicio = $_POST["fechaini"];
        $fin = $_POST["fechafin"];
        $rsta = $consulta->listarPagosPorDia($inicio, $fin);
        //Vamos a declarar un array
        $data = array();
        $reg = $rsta;
        for ($i = 0; $i < count($reg); $i++) {
            $asesordatos = $consulta->asesordatos($rsta[$i]["sofi_matricula_id_asesor"]);
            $nombre = !empty($asesordatos) ? $asesordatos['usuario_nombre'] . ' ' . $asesordatos['usuario_apellido'] : '';
            $valorPagado = $rsta[$i]["valor_pagado"];
            $valorFormateado = number_format($valorPagado, 0, '.', ',');
            $semanaEnQuePago = date("W", strtotime($rsta[$i]["fecha_pagada"]));
            $semanaPago = date("W", strtotime($rsta[$i]["fecha_pago"]));
            $observacion = ($semanaEnQuePago == $semanaPago) ? "Dentro de la semana" : (($semanaEnQuePago < $semanaPago) ? "Anticipado" : "Atrasado");
            $data[] = array(
                "0" => $rsta[$i]["tipo_documento"],
                "1" => $rsta[$i]["numero_documento"],
                "2" => $rsta[$i]["consecutivo"],
                "3" => $consulta->fechaesp($rsta[$i]["fecha_pagada"]),
                "4" => $valorFormateado,
                "5" => "En Proceso",
                "6" => ($rsta[$i]["en_cobro"] == 1)? "Si" : "No",
                "7" => $semanaEnQuePago,
                "8" => $semanaPago,
                "9" => $consulta->fechaesp($rsta[$i]["fecha_pago"]),
                "10" => $observacion,
                "11" => $rsta[$i]["numero_cuota"],
                "12" => $rsta[$i]["periodo"],
                "13" => $nombre,
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
    case 'valorrecaudo':
        $inicio = $_POST["fechaini"];
        $fin = $_POST["fechafin"];
        $totalPagos = $consulta->valorrecaudo($inicio, $fin);
        //creamos un array
        $data = array();
        $data["valor"] = "";
        $totalValorPagado = $totalPagos['total_pagado'];
        $data["valor"] .= $totalValorPagado;
        echo json_encode($data);
        break;
}
