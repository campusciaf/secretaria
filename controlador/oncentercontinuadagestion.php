<?php
require_once "../modelos/OncenterContinuadaGestion.php";
$oncentercontinuadagestion = new OncenterContinuadaGestion();



$rsptaperiodo = $oncentercontinuadagestion->periodoactual();	
$periodo_actual=$rsptaperiodo["periodo_actual"];
$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];


switch ($_GET['op']) {

    case 'consultaEstudiantes':

		$rspta=$oncentercontinuadagestion->totalEstudiantes($periodo_actual);
		
		//Vamos a declarar un array
		$data= Array();
	   	$reg=$rspta;
   
		for ($i=0;$i<count($reg);$i++){
			$nombre=$reg[$i]["nombre"] . ' ' . $reg[$i]["apellidos"];
			$datoscurso=$oncentercontinuadagestion->datoscurso($reg[$i]["id_curso"]);
		   
			$data[]=array(
			   	"0"=>"",
				"1"=>$reg[$i]["identificacion"],
				"2"=>$nombre,
				"3"=>$datoscurso["nombre_curso"],
				"4"=>$reg[$i]["celular"],
				"5"=>$reg[$i]["email"],
				"6"=>($reg[$i]["matricula"]==1)?"no":"si",
				"7"=>$reg[$i]["estado_interesado"],
				"8"=>$oncentercontinuadagestion->fechaesp($reg[$i]["fecha_ingreso"]),
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