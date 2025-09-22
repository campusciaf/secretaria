<?php
session_start(); 
require_once "../modelos/HistoricoMaterias.php";
$historicomaterias = new HistoricoMaterias();

$fecha_actual=date('Y-m-d');
$hora_actual=date('H:i:s');

$periodos=$historicomaterias->periodoactual();
$periodo_actual_historico=$periodos["periodo_actual"];

$id_usuario_actual = $_SESSION['id_usuario'];


switch ($_GET["op"]){


	case 'listar':
		$listar = $historicomaterias->listar();
		$data = Array();

        for ($i=0;$i<count($listar);$i++){
            $id_docente=$listar[$i]["id_docente"];

            $datosdocente=$historicomaterias->datosDocente($id_docente);
			
			$data[]=array(
				"0"=>$listar[$i]["nombre"],
				"1"=>$listar[$i]["programa"],
				"2"=>$listar[$i]["jornada"],
				"3"=>$datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_nombre_2"] . ' ' . ' ' . $datosdocente["usuario_apellido"] . ' ' . $datosdocente["usuario_apellido_2"] ,
				"4"=>$listar[$i]["periodo"],

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