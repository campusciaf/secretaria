<?php 
require_once "../modelos/Panel.php";
$panel = new Panel();
date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$rsptaperiodo = $panel->periodoactual();
$periodo_actual = $_SESSION['periodo_actual'];
$id_usuario = $_SESSION['id_usuario'];
$r1 = isset($_POST["r1"]) ? limpiarCadena($_POST["r1"]):"";
$r2 = isset($_POST["r2"]) ? limpiarCadena($_POST["r2"]):"";
$r3 = isset($_POST["r3"]) ? limpiarCadena($_POST["r3"]):"";
$r4 = isset($_POST["r4"]) ? limpiarCadena($_POST["r4"]):"";
$r5 = isset($_POST["r5"]) ? limpiarCadena($_POST["r5"]):"";
$r6 = isset($_POST["r6"]) ? limpiarCadena($_POST["r6"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		$data= Array();
		$data["0"] ="";
		if($_SESSION['usuario_cargo']=="Docente"){
			$rspta = $panel->insertarEncuestaDocente($id_usuario, $r1, $r2, $r3, $r4, $r5, $r6, $fecha, $hora, $periodo_actual);
			$panel->actualizarEstadoAutoevaluacion($id_usuario);
			$data["0"] .= 'd';
		}else{
			$estudiante = $panel->consultaDatos($id_usuario);
			$identificacion=$estudiante["credencial_identificacion"];
			$programa=$estudiante["fo_programa"];
			$jornada=$estudiante["jornada_e"];	
			$rspta=$panel->insertarEncuestaEstudiante($id_usuario,$identificacion,$programa,$jornada,$fecha,$hora,$r1,$r2,$r3,$r4);		
			$data["0"] .= 'e';
		}
		$results = array($data);
		echo json_encode($results);	
	break;	
	case 'listar':
		$rspta=$panel->listar();
		//Vamos a declarar un array
		$data= Array();
		$data["0"] ="";
		$reg=$rspta;
		for ($i=0;$i<count($reg);$i++){	
		$data["0"] .= '<div class="box box-default">
			<div class="box-header with-border bg-green">
			<h3 class="box-title">'.$reg[$i]["nombre_educacion_continuada"].'</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			<strong><i class="fa fa-book margin-r-5"></i> '.$reg[$i]["tipo_educacion_continuada"].'</strong>
			<p class="text-muted">
			'.$reg[$i]["descripcion_educacion_continuada"].'
			</p>
			<hr>
			<strong><i class="fas fa-file-alt margin-r-5"></i> Modalidad:</strong>
			'.$reg[$i]["modalidad_educacion_continuada"].'
			</div>
			<!-- /.box-body -->
		</div>';	
		}
		$results = array($data);
		echo json_encode($results);
	break;
	case 'mostrarMunicipios':
		$id_departamento = isset($_POST["id_departamento"]) ? $_POST["id_departamento"] : "";
		$ciudades = $panel->mostrarMunicipios($id_departamento);
		echo json_encode($ciudades);
		break;


	
}
?>