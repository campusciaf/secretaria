<?php 
session_start();
require_once "../modelos/Faltas.php";
date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:s');

$faltas =  new Faltas();

switch ($_GET['op']) {

    case "selectPeriodo":	
		$rspta = $faltas->selectPeriodo();
        echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
            {
                echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
            }
	break;

    case 'periodo':
		$data= Array();
		$rsptaperiodo = $faltas->periodoactual();
		$periodo_campana=$rsptaperiodo["periodo_campana"];	
        $data["periodo"]=$periodo_campana;

		echo json_encode($data);

	break;
    
	case 'listar':
        $periodo=$_GET["periodo"];
		$rspta=$faltas->listar($periodo);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
			$datosestudiante=$faltas->consultaEstudiante($reg[$i]["id_estudiante"],$reg[$i]["programa"]);
			$datosdocente=$faltas->consultaDocente($reg[$i]["id_docente"]);
			$datosprograma=$faltas->programa($reg[$i]["programa"]);
			
 			$data[]=array(                
            "0"=> @$datosestudiante["credencial_identificacion"] ,
            "1"=> @$datosestudiante["credencial_nombre"]  . " ". @$datosestudiante["credencial_nombre_2"]. " ". @$datosestudiante["credencial_apellido"],
            "2"=> $reg[$i]["motivo_falta"],
            "3"=> $datosdocente["usuario_nombre"] . " ". $datosdocente["usuario_apellido"],
            "4"=> $faltas->fechaesp($reg[$i]["fecha_falta"]),
            "5"=> $reg[$i]["materia_falta"],
            "6"=> $datosprograma["nombre"],
            "7"=> $datosestudiante["jornada_e"],
            "8"=> '<button class="btn btn-danger btn-sm" onclick="eliminarfalta('.$reg[$i]["id_falta"].','.$reg[$i]["id_materia"].','.$reg[$i]["ciclo"].')" ><i class="fa fa-trash"></i></button>'
            );
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	case 'eliminarfalta':
        $id_falta = $_POST['id_falta'];
        $id_materia = $_POST['id_materia'];
        $ciclo = $_POST['ciclo'];
        $rspta=$faltas->eliminarfalta($id_falta);
            if (!$rspta) {
				$rspta2=$faltas->eliminarfaltamateria($id_materia,$ciclo);
 				$data['status'] = 1;
            } else {
               $data['status'] = 0;
            }


        echo json_encode($data);
	break;
	
	

}


?>