<?php

require_once "../modelos/CvCiudad.php";

$ciudad = new Ciudad();

$op = $_GET["op"];

switch($op){

	case 'mostrar':
		$array = array();
		$data = $ciudad->cv_mostrar($_GET["id_departamento"]);
		foreach($data as $reg){
			$array[]=array(
				"0"=>$reg["id_municipio"],
				"1"=>$reg["municipio"],
				"2"=>$reg["estado"]
			);
		}
		echo json_encode($array);
	break;
}

?>