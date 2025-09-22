<?php
require_once "../modelos/SofiReporteBloqueos.php";
$consulta = new SofiReporteBloqueos();
switch ($_GET['op']){
    case 'listar':
        $inicio = $_POST["fechaini"];
        $fin = $_POST["fechafin"];
        $rsta = $consulta->listarBloqueosPorDia($inicio, $fin);
 		//Vamos a declarar un array
 		$data = array();
 		for ($i = 0; $i < count($rsta); $i++){
            $nombre = $rsta[$i]["usuario_nombre"]." ".$rsta[$i]["usuario_nombre_2"]." ".$rsta[$i]["usuario_apellido"]." ".$rsta[$i]["usuario_apellido_2"];
            $nombre_completo = ucwords(strtolower($nombre));
            $nombre_estudiante = $rsta[$i]["nombres"]." ".$rsta[$i]["apellidos"];
            $nombre_completo_estudiante = ucwords(strtolower($nombre_estudiante));
            $data[] = array(
                "0" => $rsta[$i]["consecutivo"],
                "1" => $rsta[$i]["numero_documento"],
                "2" => $nombre_completo_estudiante,
                "3" => $rsta[$i]["celular"],
                "4" => $rsta[$i]["email"],
 				"5" => $consulta->fechaesp($rsta[$i]["sofi_historial_fecha"]),
 				"6" => $rsta[$i]["sofi_historial_hora"],
                "7" => $rsta[$i]["estado"],
                "8" => $nombre_completo,
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