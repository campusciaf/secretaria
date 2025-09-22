<?php 
require_once "../modelos/Visualizar_Veedores.php";
$visualizar_veedores = new Visualizar_Veedores();
switch ($_GET["op"]){

	case 'listar_veedores':
		$rspta	= $visualizar_veedores->listar_veedores();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i ++){
            $nombre_completo  = $reg[$i]["credencial_nombre"]." ".$reg[$i]["credencial_nombre_2"]." ".$reg[$i]["credencial_apellido"]." ".$reg[$i]["credencial_apellido_2"];
            $credencial_identificacion = $reg[$i]["credencial_identificacion"];
			$credencial_login = $reg[$i]["credencial_login"];
			$nombre  = $reg[$i]["nombre"];
			$estado  = $reg[$i]["estado"];
			$estado_modal = ($estado == 1) ?'<span class="badge badge-success p-1">Acepto</span>' :'<span class="badge badge-danger p-1">No acepto</span>';
			
			
			$data[]=array(	
				"0"=>$nombre_completo,
				"1"=>$credencial_identificacion,
				"2"=>$credencial_login,
				"3"=>$nombre,
				"4"=>$estado_modal,	       
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
