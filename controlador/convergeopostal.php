<?php 
require_once "../modelos/ConverGeoPostal.php";

$convergeopostal=new ConverGeoPostal();



switch ($_GET["op"]){
		
	case 'listar':
		$data= Array();
		$data["0"] ="";
		
		$rspta=$convergeopostal->listar();
		$reg=$rspta;
		
 		for ($i=0;$i<count($reg);$i++){
			$id_estudiante=$reg[$i]["id_estudiante"];
			$latitud= $reg[$i]["latitud"];
			$longitud= $reg[$i]["longitud"];
			
			$data [] = array(
				
				'0' => $latitud.', ' .$longitud,
				'1' => $id_estudiante,
			); 
		}
		$results = array($data);
 		echo json_encode($data) ;
	break;
		
	case 'actualizar':
		$id_estudiante=$_POST["id_estudiante"];
		$cod_postal=$_POST["cod_postal"];
		$rspta=$convergeopostal->actualizar($id_estudiante,$cod_postal);
		
	break;
		
}


?>