<?php 
require_once "../modelos/Estadisticapoa.php";

$estadisticapoa=new Estadisticapoa();


switch ($_GET["op"]){

	case 'listar':
		
		$rspta=$estadisticapoa->listarEjes();
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";
		
		$reg=$rspta;
		$j=0;
		$k=0;
		$coma=",";
		$ejes=array();		
			for ($i=0;$i<count($reg);$i++){
			array_push($ejes, $reg[$i]["nombre_ejes"]);
		}
		

		
				
		$data["0"] .= "[";
		while($j < count($reg)){

			$coma=",";
			$rsptasuma=$estadisticapoa->sumarMetas($reg[$j]["id_ejes"]);
			$reg2=$rsptasuma;
			
		$data["0"] .= '{"label": "'. $ejes[$j] . '" , "y": '.count($reg2).'}'.$coma;
			$j++;

		}

		
		while($k < count($reg)){
			if($k == (count($reg)-1)){
				$coma="";
			}
			
			$rsptasumaterminada=$estadisticapoa->sumarMetasTerminadas($reg[$k]["id_ejes"]);
			$reg3=$rsptasumaterminada;
			
		$data["0"] .= '{"label": "'. $ejes[$k] . '" , "y": '.count($reg3).'}'.$coma;
			$k++;

		}
		$data["0"] .= "]";
		

		$results = array($data);
 		echo json_encode($data) ;

	break;
}
?>