<?php

require_once "../modelos/CvDepartamentos.php";

$ciudad = new Departamento();
$op = $_GET["op"];
switch($op){
	case 'mostrar':
		$array = array();
		$data = $ciudad->mostrar();
		foreach($data as $reg){
			$array[]=array(
				"0"=>$reg["id_departamento"],
				"1"=>$reg["departamento"]
			);
		}
		echo json_encode($array);
	break;
}

?>