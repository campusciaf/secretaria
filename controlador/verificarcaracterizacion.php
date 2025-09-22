<?php 
require_once "../modelos/VerificarCaracterizacion.php";

$verificarcaracterizacion=new VerificarCaracterizacion();

$id_ejes=isset($_POST["id_ejes"])? limpiarCadena($_POST["id_ejes"]):"";
$nombre_ejes=isset($_POST["nombre_ejes"])? limpiarCadena($_POST["nombre_ejes"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$objetivo=isset($_POST["objetivo"])? limpiarCadena($_POST["objetivo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_ejes)){
			$rspta=$verificarcaracterizacion->insertar($nombre_ejes,$periodo,$objetivo);			
			echo $rspta ? "ejes registrada" : "ejes no se pudo registrar";
		}
		else {
			$rspta=$verificarcaracterizacion->editar($id_ejes,$nombre_ejes,$periodo,$objetivo);
			
			echo $rspta ? "ejes actualizada" : "ejes no se pudo actualizar";
		}
	break;


	case 'mostrar':
		$rspta=$verificarcaracterizacion->mostrar($id_ejes);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$verificarcaracterizacion->listar();
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
 		for ($i=0;$i<count($reg);$i++){
			
			$rspta2= $verificarcaracterizacion->verificarDato($reg[$i]["id_credencial"]);
			if($rspta2==false){
			
 			$data[]=array(
				"0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg[$i]["id_credencial"].')" title="Ver Caracterización"><i class="fas fa-pencil-alt"></i></button>
				
				<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg[$i]["id_credencial"].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>',
				"1"=>$reg[$i]["credencial_identificacion"],
 				"2"=>$reg[$i]["credencial_nombre"] .' '. $reg[$i]["credencial_nombre_2"] .' '. $reg[$i]["credencial_apellido"] .' '. $reg[$i]["credencial_apellido_2"],
				"3"=>$reg[$i]["celular"],
				"4"=>$reg[$i]["email"] .' - '. $reg[$i]["credencial_login"],
				"5"=>$verificarcaracterizacion->fechaesp($reg[$i]["fecha"]),
				"6"=>$reg[$i]["periodo"],
 				);
			}
			
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
		case 'eliminar':
		$id_credencial=$_POST["id_credencial"];
		$rspta=$verificarcaracterizacion->eliminar($id_credencial);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
}
?>