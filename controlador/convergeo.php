<?php 
require_once "../modelos/ConverGeo.php";

$convergeo=new ConverGeo();



switch ($_GET["op"]){
		
	case 'listar':
		$data= Array();
		$data["0"] ="";
		
		$rspta=$convergeo->listar();
		$reg=$rspta;
		
 		for ($i=0;$i<count($reg);$i++){
			$id_estudiante=$reg[$i]["id_estudiante"];
			$municipio= $reg[$i]["muni_residencia"];
			$barrio= $reg[$i]["barrio"];
			$direccion=$reg[$i]["direccion"];
			$localizar= $municipio.",".$barrio.",".$direccion;
			
			$data [] = array(
				
				'0' => $id_estudiante,
				'1' => $localizar,
			); 
		}
		$results = array($data);
 		echo json_encode($data) ;
	break;
		
	case 'actualizar':
		$id_estudiante=$_POST["id_estudiante"];
		$latitud=$_POST["lat"];
		$longitud=$_POST["lng"];
		
		$rspta=$convergeo->actualizar($id_estudiante,$latitud,$longitud);
		
	break;
		
}


?>