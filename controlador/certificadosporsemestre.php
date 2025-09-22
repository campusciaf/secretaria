<?php 

session_start();
require_once "../modelos/CertificadosPorSemestre.php";

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');

// Función para convertir la fecha a formato español //	
function fechaesp($date) {
	$dia 	= explode("-", $date, 3);
	$year 	= $dia[0];
	$month 	= (string)(int)$dia[1];
	$day 	= (string)(int)$dia[2];

	$dias 		= array("Domingo","Lunes","Martes","Mi&eacute;rcoles" ,"Jueves","Viernes","S&aacute;bado");
	$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

	$meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

	return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
}

$calificaciones_semestre = new CertificadosPorSemestre();

$op = (isset($_GET['op']))?$_GET['op']:'mostrar';

switch ($op) {
	case 'verificar':
		$cedula = $_POST["cedula"];
		$verificar_cedula = $calificaciones_semestre->verificarDocumento($cedula);
		if (empty($verificar_cedula)) {
			echo 1;
		}else{		
			echo json_encode($verificar_cedula);
		}
        break;
    case 'listar':
		$id_credencial=$_GET["id_credencial"];
		$rspta=$calificaciones_semestre->listar($id_credencial);
 		//Vamos a declarar un array
 		$data= Array();
			$i = 0;			
			while ($i < count($rspta)){
				$escueladatos=$calificaciones_semestre->nombreescuela($rspta[$i]["escuela_ciaf"]);
				$estado=$calificaciones_semestre->estado_datos($rspta[$i]["estado"]);

				$data[]=array(
				"0"=>'
				<button class="btn btn-warning btn-xs text-white" onclick="mostrar('.$rspta[$i]["id_credencial"].','.$rspta[$i]["id_estudiante"].')" title="Generar Certificado"><i class="fas fa-print"></i></button>',
				"1"=>$rspta[$i]["id_estudiante"],
 				"2"=>$rspta[$i]["fo_programa"],
				"3"=>$rspta[$i]["jornada_e"],
				"4"=>$escueladatos["escuelas"],
				"5"=>$estado["estado"],
				"6"=>$rspta[$i]["periodo_activo"],
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
	case 'cargar':
		$id_credencial = $_POST['id_credencial'];
		$cargar_informacion = $calificaciones_semestre->cargarInformacion($id_credencial);
		echo json_encode($cargar_informacion);
		break;

		
	case 'fecha_pie':
		$date_pie = $_POST['date'];
		
		$cargar_fecha_pie = $calificaciones_semestre->convertir_fecha($date_pie);
		echo $cargar_fecha_pie;
		break;
	case 'cargarSemestre':
		$id_estudiante = $_POST['id_estudiante'];
		$ciclo = $_POST['ciclo'];
		$semestre_seleccionado = $_POST['semestre_seleccionado'];

		$cargar_calificaciones = $calificaciones_semestre->cargarSemestre($id_estudiante,$ciclo,$semestre_seleccionado);
		echo $cargar_calificaciones;
		break;
	case 'cargarDatosEstudiante':
		$id_estudiante = $_POST['id_estudiante'];
		$id_credencial = $_POST['id_credencial'];
		$datos_estudiante = $calificaciones_semestre->cargarDatosEstudiante($id_estudiante,$id_credencial);
		echo $datos_estudiante;
		break;
	case 'cargarOpciones':
		$id_estudiante = $_POST['id_estudiante'];
		$cargar_opciones = $calificaciones_semestre->cargarOpciones($id_estudiante);
		echo json_encode($cargar_opciones); 
		break;
    }
?>