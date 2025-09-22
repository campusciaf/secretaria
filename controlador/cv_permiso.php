<?php 

require_once "../modelos/Permiso.php";
$permiso=new Permiso();
switch ($_GET["op"]){
	case 'listar':
		$rspta=$permiso->listar();
 		//Vamos a declarar un array
		$data= Array();
			$i = 0;			
			while ($i < count($rspta)){
				$data[]=array(
					"0"=>$rspta[$i]["permiso_nombre"]
				);
				$i++;
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