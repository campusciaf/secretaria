<?php 
session_start();
require_once "../modelos/OncenterConsultas.php";
date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:s');


$oncenterconsultas=new OncenterConsultas();

$rsptaperiodo = $oncenterconsultas->periodoactual();	
$periodo_campana=$rsptaperiodo["periodo_campana"];
$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];

$periodo_actual=$_SESSION['periodo_actual'];
//$periodo_siguiente=$_SESSION['periodo_siguiente'];
$usuario_cargo=$_SESSION['usuario_cargo'];
$id_usuario=$_SESSION['id_usuario'];


/* variables del formulario */
$periodo_campana=isset($_POST["asesor"])? limpiarCadena($_POST["asesor"]):"";

/* ********************* */




switch ($_GET["op"]){
		
	
	case 'periodo':
		$data= Array();
		$rsptaperiodo = $oncenterconsultas->periodoactual();
		$periodo_campana=$rsptaperiodo["periodo_campana"];	
        $data["periodo"]=$periodo_campana;

		echo json_encode($data);

	break;

	case 'listar':
		$periodo_campana=$_GET["periodo_campana"];
		$rspta=$oncenterconsultas->listar($periodo_campana);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;

 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
 				"0"=>$reg[$i]["id_estudiante"],
				"1"=>$reg[$i]["identificacion"],
				"2"=>$reg[$i]["fo_programa"],
 				"3"=>$reg[$i]["jornada_e"],
 				"4"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
				"5"=>$reg[$i]["fecha_nacimiento"],
				"6"=>$reg[$i]["celular"],
				"7"=>$reg[$i]["email"],
				"8"=>$reg[$i]["periodo_ingreso"],
				"9"=>$reg[$i]["fecha_ingreso"],
				"10"=>$reg[$i]["medio"],
				"11"=>$reg[$i]["conocio"],
				"12"=>$reg[$i]["contacto"],
				"13"=>$reg[$i]["nombre_modalidad"],
				"14"=>$reg[$i]["estado"],
				"15"=>$reg[$i]["segui"],
				"16"=>$reg[$i]["mailing"],
				"17"=>$reg[$i]["periodo_campana"],
				"18"=>$reg[$i]["formulario"],
				"19"=>$reg[$i]["inscripcion"],
				"20"=>$reg[$i]["entrevista"],
				"21"=>$reg[$i]["documentos"],
				"22"=>$reg[$i]["matricula"],
				"23"=>$reg[$i]["programa_m"]
 				);
 		}

 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
		
		
	case "selectCampana":	
		$rspta = $oncenterconsultas->selectCampana();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . " " . $rspta[$i]["usuario_apellido"] . "</option>";
				}
	break;
}



?>
