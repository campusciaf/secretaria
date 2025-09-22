<?php
require_once "../modelos/SofiEstudiantesEnCobro.php";
$consulta = new SofiEstudiantesEnCobro();
switch ($_GET['op']) {
    case 'listarEstudiantesEnCobro': //Listar el ultimo interes mora insertado 
        $rsta = $consulta->listarEstudiantesEnCobro();
        for ($i = 0; $i < count($rsta); $i++) {
            $consecutivo = $rsta[$i]["consecutivo"];
            $valores = $consulta->calcularDeuda($consecutivo);
            $total_credito = $valores["total"];
            $total_pagado = $valores["pagado"];
            $referencias = $consulta->listarReferenciaFamiliar($rsta[$i]["id_persona"]);
            $nombre_referencia = $referencias["nombre"];
            $telefono_referencia = $referencias["telefono"];
            $array[] = array(
                "0" => $rsta[$i]["numero_documento"],
                "1" => $consecutivo,
                "2" => $rsta[$i]["nombres"] . " " . $rsta[$i]["apellidos"],
                "3" => $rsta[$i]["email"],
                "4" => $rsta[$i]["celular"],
                "5" => intval($total_credito) - intval($total_pagado),
                "6" => explode(" ", $rsta[$i]["fecha_inicial"])[0],
                "7" => $rsta[$i]["ultima_fecha_cuota"],
                "8" => $rsta[$i]["periodo"],
                "9" => $nombre_referencia,
                "10" => $telefono_referencia,
                "11" => "En cobro",
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
}