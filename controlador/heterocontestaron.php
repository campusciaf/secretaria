<?php
require_once "../modelos/HeteroContestaron.php";
session_start();
$resultado = new HeteroContestaron();

date_default_timezone_set("America/Bogota");	
$fecha=date('Y-m-d');
$hora=date('H:i:S');


switch ($_GET['op']) {
   		
	case 'periodo':
		$data= Array();
		$rsptaperiodo = $resultado->periodoactual();
		$periodo_actual=$rsptaperiodo["periodo_actual"];	
        $data["periodo"]=$periodo_actual;
		echo json_encode($data);

	break;


    case 'listar':
        $periodo=$_GET["periodo"];
        $datos = $resultado->listarEstudiantes($periodo);
        $array = array();
        for ($i = 0; $i < count($datos); $i++) {
            $datosestudiante = $resultado->datosestudiante($datos[$i]["id_estudiante"]);
            $nombre=$datosestudiante["credencial_nombre"] . ' ' . $datosestudiante["credencial_nombre_2"] . ' ' . $datosestudiante["credencial_apellido"] . ' ' . $datosestudiante["credencial_apellido_2"]; 
            $array[] = array(
                "0" => $datos[$i]["id_estudiante"],
                "1" => $nombre ,
                "2" => $datosestudiante["credencial_identificacion"],
                "3" => $datosestudiante["jornada_e"],

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

    case "selectPeriodo":	
		$rspta = $resultado->selectPeriodo();
        echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;
    
    
}
