<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/HorarioDocente.php";
$horariodocente = new HorarioDocente();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$id_programa_ac = isset($_POST["programa_ac"]) ? limpiarCadena($_POST["programa_ac"]) : "";
$jornada = isset($_POST["jornada"]) ? limpiarCadena($_POST["jornada"]) : "";
// $dia=isset($_POST["dia"])? limpiarCadena($_POST["dia"]):"";
// $periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$grupo = isset($_POST["grupo"]) ? limpiarCadena($_POST["grupo"]) : "";
$semestre = isset($_POST["semestre"]) ? limpiarCadena($_POST["semestre"]) : "";

// modal asignar horario
$id_horario_fijo = isset($_POST["id_horario_fijo"]) ? limpiarCadena($_POST["id_horario_fijo"]) : "";
$id_materia = isset($_POST["id_materia"]) ? limpiarCadena($_POST["id_materia"]) : "";
$jornadamateria = isset($_POST["jornadamateria"]) ? limpiarCadena($_POST["jornadamateria"]) : "";
$grupomateria = isset($_POST["grupomateria"]) ? limpiarCadena($_POST["grupomateria"]) : "";
$dia = isset($_POST["dia"]) ? limpiarCadena($_POST["dia"]) : "";
$corte = isset($_POST["corte"]) ? limpiarCadena($_POST["corte"]) : "";
$hora = isset($_POST["hora"]) ? limpiarCadena($_POST["hora"]) : "";
$hasta = isset($_POST["hasta"]) ? limpiarCadena($_POST["hasta"]) : "";
$diferencia = isset($_POST["diferencia"]) ? limpiarCadena($_POST["diferencia"]) : "";

$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');

$rsptaperiodo = $horariodocente->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];

switch ($_GET["op"]) {

	case 'iniciarcalendario':
		$id_docente = $_GET["id_docente"];
		$periodo = $_GET["periodo"];
		$impresion = "";
		$traerhorario = $horariodocente->TraerHorariocalendario($id_docente, $periodo);
		
		$impresion .= '[';
		for ($i = 0; $i < count($traerhorario); $i++) {
			$id_programa=$traerhorario[$i]["id_programa"];
			$id_materia = $traerhorario[$i]["id_materia"];
			$jornada = $traerhorario[$i]["jornada"];
			$semestre = $traerhorario[$i]["semestre"];
			$diasemana = $traerhorario[$i]["dia"];
			$horainicio = $traerhorario[$i]["hora"];
			$horafinal = $traerhorario[$i]["hasta"];
			$salon = $traerhorario[$i]["salon"];
			$corte = $traerhorario[$i]["corte"];
			$id_usuario_doc = $traerhorario[$i]["id_docente"];
			$datosmateria = $horariodocente->BuscarDatosAsignatura($id_materia);
			$nombre_materia = $datosmateria["nombre"];
			$nombre_programa = $datosmateria["programa"];
			$ciclo=$traerhorario[$i]["ciclo"];
			$grupo=$traerhorario[$i]["grupo"];

			$bucarnumestudiantes=$horariodocente->buscarNumEstudiantes($ciclo,$nombre_materia,$jornada,$id_programa,$grupo,$periodo_actual);

			if ($id_usuario_doc == null) {
				$nombre_docente = "Sin Asignar";
			} else {
				$datosdocente = $horariodocente->datosDocente($id_usuario_doc);
				$nombre_docente = $datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_apellido"];
			}
			//$nombre_docente=$id_docente;
			switch ($diasemana) {
				case 'Lunes':
					$dia = 1;
					break;
				case 'Martes':
					$dia = 2;
					break;
				case 'Miercoles':
					$dia = 3;
					break;
				case 'Jueves':
					$dia = 4;
					break;
				case 'Viernes':
					$dia = 5;
					break;
				case 'Sabado':
					$dia = 6;
				break;
				case 'Domingo':
					$dia = 0;
				break;
			}
			if($corte=="1"){
				$color="#fff";
			}else{
				$color="#252e53";
			}
			$impresion .= '{"title":"' . $nombre_materia . ' - Salón ' . $salon . ' - doc: ' . $nombre_docente . ' - ' .$nombre_programa. ' - ' .$jornada. ' - Sem: ' .$semestre. ' - #Est: '.count($bucarnumestudiantes).' ","daysOfWeek":"' . $dia . '","startTime":"' . $horainicio . '","endTime":"' . $horafinal . '","color":"' . $color . '"}';
			if ($i + 1 < count($traerhorario)) {
				$impresion .= ',';
			}
		}
		$impresion .= ']';
		echo $impresion;
	break;

	case "selectPeriodo":
		$rspta = $horariodocente->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
	break;

	case "selectDocente":
		$rspta = $horariodocente->selectDocente();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_nombre"] . " " . $rspta[$i]["usuario_nombre_2"] . " " . $rspta[$i]["usuario_apellido"] . " " . $rspta[$i]["usuario_apellido_2"] . "</option>";
		}
	break;
}
