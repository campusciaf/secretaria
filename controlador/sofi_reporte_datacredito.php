<?php
require_once "../modelos/SofiReporteDatacredito.php";
$consulta = new SofiReporteDatacredito();
switch ($_GET['op']){
    case 'listar':
        $array = array(
            "Cédula de Ciudadanía" => 1,
            "NIT" => 2,
            "NIT EXTRANJERIA" => 3,
            "CEDULA DE EXTRANJERIA" => 4,
            "Pasaporte" => 5,
            "ppt" => 6,
            "Tarjeta de Identidad" => 7,
            "DNI " => 8,
            "Número de Permiso" => 9,
        );
        $rsta = $consulta->listarCreditosActivos();
 		//Vamos a declarar un array
 		$data = array();
 		for ($i = 0; $i < count($rsta); $i++){
            $data[] = array(
                "0" => $array[$rsta[$i]["tipo_documento"]],
                "1" => $rsta[$i]["cedula"],
                "2" => $rsta[$i]["nombre_completo"],
                "3" => $rsta[$i]["consecutivo"],
                "4" => str_replace( "-", "", $rsta[$i]["fecha_inicio"]), 
                "5" => str_replace( "-", "", $rsta[$i]["ultima_fecha_cuota"]), 
                "6" => '00',
                "7" => $rsta[$i]["novedad"],
                "8" => $rsta[$i]["situacion_cartera"],
                "9" => $rsta[$i]["credito"],
                "10" => $rsta[$i]["faltante"],
                "11" => $rsta[$i]["valor_disponible"],
                "12" => intval($rsta[$i]["valor_cuota"]),
                "13" => ' - ',  
                "14" => $rsta[$i]["cuotas"],
                "15" => $rsta[$i]["cuotas_pagadas"],
                "16" => $rsta[$i]["cuotas_en_mora"],
                "17" => " - ",
                "18" => str_replace( "-", "", $rsta[$i]["fecha_ultimo_pago"]), 
                "19" => $rsta[$i]["ciudad"],
                "20" => $rsta[$i]["direccion"],
                "21" => $rsta[$i]["email"],
                "22" => $rsta[$i]["celular"],
            );
 		}
 		$results = array(
 			"sEcho" => 1, //Información para el datatables
 			"iTotalRecords" => count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
 			"aaData" => $data);
 		echo json_encode($results);
	break;
}
?>