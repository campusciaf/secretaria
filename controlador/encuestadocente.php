<?php

require_once "../modelos/EncuestaDocente.php";
$encuestadocente = new EncuestaDocente();

switch ($_GET['op']) {
		
    case 'listar':
		$rspta=$encuestadocente->listar();// consulta para listar los docentes que contestaron la encuesta
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){// arreglo para imprimir los estudiantes que contestaron la encuesta
			
 			$data[]=array(
 				"0"=>$reg[$i]["id_usuario"],
 				"1"=>$reg[$i]["usuario_nombre"] . " " . $reg[$i]["usuario_nombre_2"] . " " . $reg[$i]["usuario_apellido"] . " " . $reg[$i]["usuario_apellido_2"],
				"2"=>$reg[$i]["usuario_celular"],
				"3"=>$reg[$i]["usuario_login"],
 				"4"=>$reg[$i]["r1"],
 				"5"=>$reg[$i]["r2"],
				"6"=>$reg[$i]["r3"],
				"7"=>$reg[$i]["r4"],
				"8"=>$reg[$i]["r5"]
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