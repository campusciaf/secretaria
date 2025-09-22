<?php
session_start();
date_default_timezone_set("America/Bogota");
require_once "../modelos/ResultadosAutoevaluacion.php";
$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('h:i:s');

$resultadosautoevaluacion = new ResultadosAutoevaluacion();

$rsptaperiodo = $resultadosautoevaluacion->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$estado = isset($_POST["estado"]) ? $_POST["estado"] : "";

switch ($_GET["op"]) {

	case 'selectPeriodo':
		$rspta = $resultadosautoevaluacion->listarPeriodos();
		echo json_encode($rspta);
		break;

	case 'datospanel':
		$periodobuscar = $_POST["periodobuscar"];
		if ($periodobuscar == "") {
			$periodoconsulta = $periodo_actual;
		} else {
			$periodoconsulta = $periodobuscar;
		}
		$data = array();
		$data["0"] = "";
		$docentesactivos = $resultadosautoevaluacion->listarDocentes();
		$totalactivos = count($docentesactivos);
		$docentes = $resultadosautoevaluacion->totaldocentecontestaron($periodoconsulta);
		$total = count($docentes);

		$porcentaje = ($total * 100) / $totalactivos;


		$data["0"] = '
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Avance ' . $periodoconsulta . '</span>
                <span class="info-box-number">' . $totalactivos . ' /' . $total . '</span>
                <div class="progress">
                    <div class="progress-bar" style="width: ' . $porcentaje . '%"></div>
                </div>
                <span class="progress-description">
                    ' . round($porcentaje, 0) . '% de Avance en la evaluación
                </span>
            </div>
        </div>
        
        ';
		echo json_encode($data);
		break;
	case 'listar':
		$periodobuscar = $_POST["periodobuscar"];
		if ($periodobuscar == "") {
			$periodoconsulta = $periodo_actual;
		} else {
			$periodoconsulta = $periodobuscar;
		}
		$datos = $resultadosautoevaluacion->listarDocentes();
		$array = array();
		for ($i = 0; $i < count($datos); $i++) {
			$id_docente = $datos[$i]["id_usuario"];
			$cargar_informacion = $resultadosautoevaluacion->listarResultadoAutoevaluacion($id_docente, $periodoconsulta);
			//print_r($cargar_informacion);
			if (count($cargar_informacion) == 1) {
				$suma = $cargar_informacion[0]["r1"] + $cargar_informacion[0]["r2"] + $cargar_informacion[0]["r3"] + $cargar_informacion[0]["r4"] + $cargar_informacion[0]["r5"] + $cargar_informacion[0]["r6"] + $cargar_informacion[0]["r7"] + $cargar_informacion[0]["r8"] + $cargar_informacion[0]["r9"] + $cargar_informacion[0]["r10"]; // suma los resultados
				$total = round((($suma * 100) / 30), 2) . " %";
				$barravalor = ($suma * 100) / 30;
				if ($barravalor > 90) {
					$colorbarra = 'bg-success';
				} else if ($barravalor > 80) {
					$colorbarra = 'bg-primary';
				} else if ($barravalor > 70) {
					$colorbarra = 'bg-warning';
				} else {
					$colorbarra = 'bg-danger';
				}
				$barra = '<div  style="padding-top:5px"><div class="progress progress-xs"><div class="progress-bar ' . $colorbarra . '" style="width: ' . $barravalor . '%"></div></div>' . $total . '</div>';
				$boton = '<a onclick="resultados(' . $id_docente . ')" class="btn btn-primary btn-xs">Ver</a>';
			} else {
				$total = "0 %";
				$barra = '';
				$boton = '';
			}
			if (file_exists("../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg")) {
				$img = "../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg";
			} else {
				$img = "../files/null.jpg";
			}
			$data[] = array(
				"0" => $datos[$i]["usuario_identificacion"],
				"1" => $datos[$i]["usuario_nombre"] . " " . $datos[$i]["usuario_nombre_2"] . " " . $datos[$i]["usuario_apellido"] . " " . $datos[$i]["usuario_apellido_2"],
				"2" => $datos[$i]["usuario_celular"],
				"3" => $datos[$i]["usuario_email_p"],
				"4" => $datos[$i]["usuario_email_ciaf"],
				"5" => $barra,
				"6" => $boton,
				"7" => "<img src='" . $img . "' height='30px' width='30px' class='direct-chat-img'>"
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
	break;


	case 'resultados':
		$id_docente = $_POST["id_docente"];
		$periodobuscar = $_POST["periodobuscar"];
		if ($periodobuscar == "") {
			$periodoconsulta = $periodo_actual;
		} else {
			$periodoconsulta = $periodobuscar;
		}
		$data = array();
		$data["0"] = "";
		$resultado = $resultadosautoevaluacion->mostrarresultados($id_docente, $periodoconsulta);

	
		$preguntas = array( "¿Hago uso óptimo del campus virtual CIAFi?", 
							"Hago uso eficiente de las tecnologías de la información en el desarrollo de mis clases", 
							"Apoyo el plan de permanencia del estudiante con comunicación oportuna de inasistencias u observaciones especiales",
							"Conozco y aplico los reglamentos que intervienen en mi labor",
							"Participo activamente en las actividades académicas programadas por la institución.",
							"Participo activamente en las actividades administrativas, deportivas y culturales programadas por la institución.",
			 				"Comunico oportunamente los ajustes realizados a las clases, tanto a las direcciones de escuela como a los estudiantes",
							"Demuestro dominio en mi área o disciplina",
							"¿Doy cumplimiento al acuerdo de labor firmado?",
							"¿Muestro compromiso y entusiasmo en las actividades para docentes?"
		);

        $array = array();
		$respuesta='';
		$a=1;
		$sumatoria=0;

        for ($i = 0; $i < sizeof($preguntas); $i++) {
			
			if ($resultado['r'.$a] == '3') {
				$respuesta = 'Siempre';
			} else if ($resultado['r'.$a] == '2') {
				$respuesta = 'Casi siempre';
			} else if ($resultado['r'.$a] == '1') {
				$respuesta = 'A veces';
			} else {
				$respuesta = 'Nunca';
			}

                $array[] = array(
                    "0" => $i+1,
                    "1" => $preguntas[$i],
                    "2" => $respuesta

                );
			$sumatoria=$sumatoria+$resultado['r'.$a];
           	$a++; 
		   
        }

		$total = round((($sumatoria * 100) / 30), 2) . " %";

			$array[] = array(
				"0" => '11',
				"1" => '<b>Total autoevaluación</b>',
				"2" => '<b>'.$total.'</b>',

			);

        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
	break;




	case 'mostrarEstadoEvalaucion':
		$rspta = $resultadosautoevaluacion->mostrarEstadoEvalaucion($tipo);
		echo json_encode($rspta);
		break;
	case 'cambiarEstadoEvalaucion':
		$rspta = $resultadosautoevaluacion->cambiarEstadoEvalaucion($tipo, $estado);
		$rpsta = ($rspta) ? 1 : 0;
		echo json_encode(array("exito" => $rpsta));
		break;
}