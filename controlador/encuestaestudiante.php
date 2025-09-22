<?php

require_once "../modelos/EncuestaEstudiante.php";
$encuestaestudiante = new EncuestaEstudiante();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";

$rsptaperiodo = $encuestaestudiante->periodoactual();
$periodo_actual = $_SESSION['periodo_actual'];
$id_usuario = $_SESSION['id_usuario'];



switch ($_GET['op']) {
		
    case 'listar':
		$rspta=$encuestaestudiante->listar();// consulta para listar los estudiantes que contestaron la encuesta
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){// arreglo para imprimir los estudiantes que contestaron la encuesta
			$rspta2=$encuestaestudiante->programa($reg[$i]["id_usuario"]);// consulta para saber el programa mas reciente
			$reg2=$rspta2;
				$id_encontrado=$reg2["id_encontrado"];// id del programa reciente
				$rspta3=$encuestaestudiante->datosestudiante($id_encontrado);
			
			$rspta4=$encuestaestudiante->datosestudiantepersonales($reg[$i]["id_usuario"]);
			$rspta5=$encuestaestudiante->datosestudiantecredencial($reg[$i]["id_usuario"]);
			
 			$data[]=array(
 				"0"=>$reg[$i]["id_usuario"],
				"1"=>$rspta5["credencial_nombre"] . " " . $rspta5["credencial_nombre_2"] . " " . $rspta5["credencial_apellido"] . " " . $rspta5["credencial_apellido_2"],
 				"2"=>$rspta3["fo_programa"],
				"3"=>$rspta3["jornada_e"],
				"4"=>$rspta3["semestre_estudiante"],
				"5"=>$rspta4["celular"],
				"6"=>$rspta4["email"],
				"7"=>$rspta5["credencial_login"],
 				"8"=>$reg[$i]["r1"],
 				"9"=>$reg[$i]["r2"],
				"10"=>$reg[$i]["r3"],
				"11"=>$reg[$i]["r4"],
				"12"=>$reg[$i]["r5"],
				"13"=>$reg[$i]["r6"],
				"14"=>$reg[$i]["r7"]
 			


 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'cargacreatividad':

		$data= Array();
		$data["publico_estudiantil"] ="";
		$data["respuestas"] ="";
		$data["porcentaje"] ="";
		$data["porcentajenumero"] ="";

		$rspta1=$encuestaestudiante->totalestudiantesactivos($periodo_actual);
		$rspta2=$encuestaestudiante->totalrespuestas();
		$totalestudiantes=count($rspta1);
		$totalrespuestas=count($rspta2);

		$porcentaje_avance=round((($totalrespuestas*100)/$totalestudiantes),0);
		
		$data["publico_estudiantil"] .=$totalestudiantes;
		$data["respuestas"] .=$totalrespuestas;
		$data["porcentaje"] .='<div class="progress-bar" style="width:'.$porcentaje_avance.'%"></div>';
		$data["porcentajenumero"] .= $porcentaje_avance . '% de avance';
		

		echo json_encode($data);

	break;
	case 'creatividaddocente':

		$data= Array();
		$data["respuesta"] ="";

		$totalrespuestas=$encuestaestudiante->totalrespuestas();
		$total=count($totalrespuestas);

		$rspta1=$encuestaestudiante->pre1(1);
		$rspta2=$encuestaestudiante->pre1(2);
		$rspta3=$encuestaestudiante->pre1(3);
		$rspta4=$encuestaestudiante->pre1(4);
		$rspta5=$encuestaestudiante->pre1(5);

		$total1=count($rspta1);
		$total2=count($rspta2);
		$total3=count($rspta3);
		$total4=count($rspta4);
		$total5=count($rspta5);

		$por1=round((($total1*100)/$total),0);
		$por2=round((($total2*100)/$total),0);
		$por3=round((($total3*100)/$total),0);
		$por4=round((($total4*100)/$total),0);
		$por5=round((($total5*100)/$total),0);

		/* *************************************** */

		$rspta11=$encuestaestudiante->pre2(1);
		$rspta22=$encuestaestudiante->pre2(2);
		$rspta33=$encuestaestudiante->pre2(3);
		$rspta44=$encuestaestudiante->pre2(4);
		$rspta55=$encuestaestudiante->pre2(5);

		$total11=count($rspta11);
		$total22=count($rspta22);
		$total33=count($rspta33);
		$total44=count($rspta44);
		$total55=count($rspta55);

		$por11=round((($total11*100)/$total),0);
		$por22=round((($total22*100)/$total),0);
		$por33=round((($total33*100)/$total),0);
		$por44=round((($total44*100)/$total),0);
		$por55=round((($total55*100)/$total),0);

		/* *************************************** */
		$ninguno=$encuestaestudiante->pre3(0);
		$totalninguno=count($ninguno);

		$porninguno=round((($totalninguno*100)/$total),0);


		
		$data["respuesta"] .='
		
		<div class="card col-md-4 m-2">
			<p>
			<strong>1. ¿Has podido evidenciar elementos creativos e innovadores en tu experiencia académica?</strong>
			</p>
			<p>Respuestas: <b>'.$total.'</b></p>
			<div class="progress-group">
				Muy Insatisfecho
				<span class="float-right"><b>'.$total1.'</b>/'.$por1.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-danger" style="width: '.$por1.'%"></div>
				</div>
			</div>

			<div class="progress-group">
				Poco Satisfecho
				<span class="float-right"><b>'.$total2.'</b>/'.$por2.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-warning" style="width: '.$por2.'%"></div>
				</div>
			</div>

			<div class="progress-group">
				<span class="progress-text">Regular</span>
				<span class="float-right"><b>'.$total3.'</b>/'.$por3.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-info" style="width: '.$por3.'%"></div>
				</div>
			</div>

			<div class="progress-group">
				Bueno
				<span class="float-right"><b>'.$total4.'</b>/'.$por4.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-primary" style="width: '.$por4.'%"></div>
				</div>
			</div>
			<div class="progress-group">
				Muy Bueno
				<span class="float-right"><b>'.$total5.'</b>/'.$por5.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-success" style="width: '.$por5.'%"></div>
				</div>
			</div>

		</div>

		<div class="card col-md-4 m-2">
			<p>
			<strong>2. ¿En el cumplimiento de tu meta, es decir, el grado ¿te sientes apoyado por la institución?</strong>
			</p>
			<p>Respuestas: <b>'.$total.'</b></p>
			<div class="progress-group">
				Muy Insatisfecho
				<span class="float-right"><b>'.$total11.'</b>/'.$por11.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-danger" style="width: '.$por11.'%"></div>
				</div>
			</div>

			<div class="progress-group">
				Poco Satisfecho
				<span class="float-right"><b>'.$total22.'</b>/'.$por22.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-warning" style="width: '.$por22.'%"></div>
				</div>
			</div>

			<div class="progress-group">
				<span class="progress-text">Regular</span>
				<span class="float-right"><b>'.$total33.'</b>/'.$por33.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-info" style="width: '.$por33.'%"></div>
				</div>
			</div>

			<div class="progress-group">
				Bueno
				<span class="float-right"><b>'.$total44.'</b>/'.$por44.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-primary" style="width: '.$por44.'%"></div>
				</div>
			</div>
			<div class="progress-group">
				Muy Bueno
				<span class="float-right"><b>'.$total55.'</b>/'.$por55.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-success" style="width: '.$por55.'%"></div>
				</div>
			</div>

		</div>


		<div class="card col-md-4 m-2">
			<p>
			<strong>3. ¿Cuál crees tú que es el docente más creativo e innovador de la institución?</strong>
			</p>
			<p>Respuestas: <b>'.$total.'</b></p>
			<div class="progress-group">
				Ningun docente
				<span class="float-right"><b>'.$totalninguno.'</b>/'.$porninguno.'%</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-danger" style="width: '.$porninguno.'%"></div>
				</div>
			</div>';


			$docentes=$encuestaestudiante->listardocentes();

			for($i=0;$i<=count($docentes);$i++){

				@$usuario_nombre=$docentes[$i]["usuario_nombre"] . ' ' . $docentes[$i]["usuario_nombre_2"]  . ' ' . $docentes[$i]["usuario_apellido"]  . ' ' . $docentes[$i]["usuario_apellido_2"];
				@$id_docente=$docentes[$i]["id_usuario"];

				if($id_docente != "" ){
					$docentestotal=$encuestaestudiante->listardocentestotal($id_docente);
					$pordoc=round(((count($docentestotal)*100)/$total),2);

					$data["respuesta"] .='

					<div class="progress-group">
						'.$usuario_nombre.'
						<span class="float-right"><b>'.count($docentestotal).'</b>/'.$pordoc.'% </span>
						<div class="progress progress-sm">
							<div class="progress-bar bg-success" style="width: '.$pordoc.'%"></div>
						</div>
					</div>

					';
				}
	
			}

			
		$data["respuesta"] .='
		</div>
		
		
		
		';

		

		echo json_encode($data);

	break;


	


}


?>