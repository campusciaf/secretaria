<?php 
require_once "../modelos/HorarioDocentePersonal.php";

$horariodocentepersonal=new HorarioDocentePersonal();



date_default_timezone_set("America/Bogota");	
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');
$id_docente	=	$_SESSION['id_usuario'];// id del docente



$rsptaperiodo = $horariodocentepersonal->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];

switch ($_GET["op"]){
		
	case 'iniciarcalendario':


		$impresion="";

		$traerhorario=$horariodocentepersonal->TraerHorariocalendario($id_docente,$periodo_actual);
		
		$impresion .='[';

		for ($i=0;$i<count($traerhorario);$i++){
			$id_materia=$traerhorario[$i]["id_materia"];
			$diasemana=$traerhorario[$i]["dia"];
			$horainicio=$traerhorario[$i]["hora"];
			$horafinal=$traerhorario[$i]["hasta"];
			$salon=$traerhorario[$i]["salon"];
			$corte=$traerhorario[$i]["corte"];
			$id_usuario_doc=$traerhorario[$i]["id_docente"];

			$datosmateria=$horariodocentepersonal->BuscarDatosAsignatura($id_materia);
			$nombre_materia=$datosmateria["nombre"];

			if($id_usuario_doc==null){
				$nombre_docente="Sin Asignar";
			}else{
				$datosdocente=$horariodocentepersonal->datosDocente($id_usuario_doc);
				$nombre_docente=$datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_apellido"];
			}
			
			//$nombre_docente=$id_docente;


			switch($diasemana){
				case 'Lunes':
					$dia=1;
				break;
				case 'Martes':
					$dia=2;
				break;
				case 'Miercoles':
					$dia=3;
				break;
				case 'Jueves':
					$dia=4;
				break;
				case 'Viernes':
					$dia=5;
				break;
				case 'Sabado':
					$dia=6;
				break;
			}

			if($corte=="1"){
				$color="#fff";
			}else{
				$color="#252e53";
			}
			$impresion .= '{"title":"'.$nombre_materia.' - Salón '.$salon.' - doc: '.$nombre_docente.' ","daysOfWeek":"'.$dia.'","startTime":"'.$horainicio.'","endTime":"'.$horafinal.'","color":"'.$color.'"}';
			if($i+1<count($traerhorario)){
				$impresion .=',';
			}
		}

		
		
		$impresion .=']';

		echo $impresion;
		

	break;


	
		
	case "selectPeriodo":	
		$rspta = $horariodocentepersonal->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;
		
	case "selectDocente":	
		$rspta = $horariodocentepersonal->selectDocente();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_nombre"] . " " . $rspta[$i]["usuario_nombre_2"] . " " . $rspta[$i]["usuario_apellido"] . " " . $rspta[$i]["usuario_apellido_2"] . "</option>";
				}
	break;








}
?>