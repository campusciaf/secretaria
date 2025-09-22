<?php
session_start(); 
require_once "../modelos/FormatoInstitucionalDocente.php";


$formatoinstitucionaldocente=new FormatoInstitucionalDocente();


switch ($_GET["op"]){


	case 'listar':
		$rspta=$formatoinstitucionaldocente->listar();
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				
 				"0"=>$reg[$i]["formato_nombre"],
 				"1"=>'<a href="../files/formatos/'.$reg[$i]["formato_archivo"].'" target="_blank" class="badge badge-primary"><i class="fas fa-file-download"></i> Descargar Formato</a>',
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




