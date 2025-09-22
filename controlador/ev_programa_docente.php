<?php
session_start();
require_once "../modelos/Ev_Programa_Docente.php";
$consulta = new Consulta();

$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$id_usuario = $_SESSION['id_usuario'];


switch ($_GET['op']) {
		
    case 'listar':
		$rspta=$consulta->listar();// consulta para listar los docentes que contestaron la encuesta
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){// arreglo para imprimir los estudiantes que contestaron la encuesta
			$datos=$consulta->buscardatos($reg[$i]["usuario_identificacion"]);
 			$data[]=array(
                "0"=>$datos["id_usuario"],
 				"1"=>$reg[$i]["usuario_identificacion"],
 				"2"=>$datos["usuario_nombre"] . " " . $datos["usuario_nombre_2"] . " " . $datos["usuario_apellido"] . " " . $datos["usuario_apellido_2"],
				"3"=>$datos["usuario_login"],
                "4"=>$datos["usuario_email_p"],
 				"5"=>$reg[$i]["p1"],
 				"6"=>$reg[$i]["p2"],
				"7"=>$reg[$i]["p3"],
				"8"=>$reg[$i]["p4"],
                "9"=>$reg[$i]["p5"],
				"10"=>$reg[$i]["p6"],
                "11"=>$reg[$i]["p7"],
                "12"=>$reg[$i]["p8"],
                "13"=>$reg[$i]["p9"],
                "14"=>$reg[$i]["p10"],
                "15"=>$reg[$i]["p11"],
                "16"=>$reg[$i]["p12"],
                "17"=>$reg[$i]["p13"],
				"18"=>$reg[$i]["p14"],
				"19"=>$reg[$i]["p15"],
				"20"=>$reg[$i]["p16"],
				"21"=>$reg[$i]["p17"],
				"22"=>$reg[$i]["p18"],
				"23"=>$reg[$i]["p19"],
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

}


?>