<?php 
session_start();
date_default_timezone_set("America/Bogota");
require_once "../modelos/EncuestaTic.php";
$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('h:i:s');

$encuestatic = new EncuestaTic();

$rsptaperiodo = $encuestatic->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];

switch ($_GET["op"]){

    case 'selectPeriodo':
        $rspta = $encuestatic->listarPeriodos();
        echo json_encode($rspta);
    break;

	case 'datospanel':
        $periodobuscar=$_POST["periodobuscar"];
        if($periodobuscar==""){
            $periodoconsulta=$periodo_actual;  
        }else{
            $periodoconsulta=$periodobuscar;
        }
        $data= Array();
        $data["0"] ="";
        $docentesactivos=$encuestatic->listarDocentes();
        $totalactivos=count($docentesactivos);
        $docentes=$encuestatic->listarDocentesContestaron($periodoconsulta);
        $total=count($docentes);

        $porcentaje=($total*100)/$totalactivos;

        $data["0"] .='<div class="row">';
            $data["0"] .='
            <div class="col-xl-3">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Encuesta '.$periodoconsulta.'</span>
                        <span class="info-box-number">'.$totalactivos.' /'.$total.'</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: '.$porcentaje.'%"></div>
                        </div>
                        <span class="progress-description">
                            '.round($porcentaje,0).'% de Avance encuestados
                        </span>
                    </div>
                </div>
            </div>
            
            ';

            $totalgeneralrespuestas=$encuestatic->TotalGeneralRespuestas($periodoconsulta);
            $total_general_respuestas=$totalgeneralrespuestas["suma_general"];

            $datostabla=$encuestatic->DatosTabla($periodoconsulta);
            $totaldatostabla=count($datostabla);

            $porcentajegeneral=($total_general_respuestas*100)/$totaldatostabla;

            $data["0"] .='
            <div class="col-xl-3">
                <div class="info-box bg-primary">
                    <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">General encuesta</span>
                        <span class="info-box-number">'.$totaldatostabla.'/'.$total_general_respuestas.'</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: '.round($porcentajegeneral,0).'%"></div>
                        </div>
                        <span class="progress-description">
                            '.round($porcentajegeneral,0).'% de Aprobación
                        </span>
                    </div>
                </div>
            </div>
            ';

            

        $data["0"] .='</div>';

        echo json_encode($data);
    break;

    case 'listar':

        $periodobuscar=$_POST["periodobuscar"];
        if($periodobuscar==""){
            $periodoconsulta=$periodo_actual;  
        }else{
            $periodoconsulta=$periodobuscar;
        }

        $datos = $encuestatic->listarDocentesContestaron($periodoconsulta);
        
        $array = array();
        for($i = 0; $i < count($datos); $i++){
            $id_docente=$datos[$i]["id_docente"];

            $cargar_informacion = $encuestatic->DatosDocente($id_docente);

            $respuestas = $encuestatic->TotalRespuesta($id_docente,$periodoconsulta);//suma el total de respuestas
			$total_respuestas=$respuestas["suma_respuesta"];

            $barravalor=($total_respuestas*100)/45;
            $total = round((($total_respuestas * 100)/45),2) ." %";
            //print_r($cargar_informacion);



				if($barravalor>90){
					$colorbarra='bg-success';
				}
				else if($barravalor>70){
					$colorbarra='bg-primary';
				}
				else if($barravalor>50){
					$colorbarra='bg-warning';
				}
				else{
					$colorbarra='bg-danger';
				}

				$barra='<div  style="padding-top:5px"><div class="progress progress-xs"><div class="progress-bar '.$colorbarra.'" style="width: '.$barravalor.'%"></div></div>'.$total.'</div>';
				$boton= '<a onclick="resultados('.$id_docente.')" class="btn btn-primary btn-xs">Ver</a>';


            if(file_exists("../files/docentes/".$cargar_informacion["usuario_identificacion"].".jpg")){
				$img = "../files/docentes/".$cargar_informacion["usuario_identificacion"].".jpg";
			}else{
				$img = "../files/null.jpg";
			}
      
            $data[] = array(
 				"0" => $cargar_informacion["usuario_identificacion"],
 				"1" => $cargar_informacion["usuario_nombre"] . " " . $cargar_informacion["usuario_nombre_2"] . " " . $cargar_informacion["usuario_apellido"] . " " . $cargar_informacion["usuario_apellido_2"],
 				"2" => $cargar_informacion["usuario_celular"],
 				"3" => $cargar_informacion["usuario_email_p"],
				"4" => $cargar_informacion["usuario_email_ciaf"],
				"5" =>$barra,
 				"6" => $boton,
 				"7" => "<img src='".$img."' height='30px' width='30px' class='direct-chat-img'>"
 			);
            
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
	break;

	case 'resultados':

		$id_docente=$_POST["id_docente"];
		$periodobuscar=$_POST["periodobuscar"];

        if($periodobuscar==""){
            $periodoconsulta=$periodo_actual;  
        }else{
            $periodoconsulta=$periodobuscar;
        }
        
		

        $data= Array();
        $data["0"] ="";

		$resultado=$encuestatic->mostrarresultados($id_docente, $periodoconsulta);


		if($resultado["r1"]=='3'){
			$respuesta1='Siempre';
		}
		else if($resultado["r1"]=='2'){
			$respuesta1='Casi siempre';
		}
		else if($resultado["r1"]=='1'){
			$respuesta1='A veces';
		}
		else{
			$respuesta1='Nunca';
		}

		if($resultado["r2"]=='3'){
			$respuesta2='Siempre';
		}
		else if($resultado["r1"]=='2'){
			$respuesta2='Casi siempre';
		}
		else if($resultado["r1"]=='1'){
			$respuesta2='A veces';
		}
		else{
			$respuesta2='Nunca';
		}

		if($resultado["r3"]=='3'){
			$respuesta3='Siempre';
		}
		else if($resultado["r3"]=='2'){
			$respuesta3='Casi siempre';
		}
		else if($resultado["r3"]=='1'){
			$respuesta3='A veces';
		}
		else{
			$respuesta3='Nunca';
		}

		if($resultado["r4"]=='3'){
			$respuesta4='Siempre';
		}
		else if($resultado["r4"]=='2'){
			$respuesta4='Casi siempre';
		}
		else if($resultado["r4"]=='1'){
			$respuesta4='A veces';
		}
		else{
			$respuesta4='Nunca';
		}

		if($resultado["r5"]=='3'){
			$respuesta5='Siempre';
		}
		else if($resultado["r5"]=='2'){
			$respuesta5='Casi siempre';
		}
		else if($resultado["r5"]=='1'){
			$respuesta5='A veces';
		}
		else{
			$respuesta5='Nunca';
		}

		if($resultado["r6"]=='3'){
			$respuesta6='Siempre';
		}
		else if($resultado["r6"]=='2'){
			$respuesta6='Casi siempre';
		}
		else if($resultado["r6"]=='1'){
			$respuesta6='A veces';
		}
		else{
			$respuesta6='Nunca';
		}

		if($resultado["r7"]=='3'){
			$respuesta7='Siempre';
		}
		else if($resultado["r7"]=='2'){
			$respuesta7='Casi siempre';
		}
		else if($resultado["r7"]=='1'){
			$respuesta7='A veces';
		}
		else{
			$respuesta7='Nunca';
		}

		if($resultado["r8"]=='3'){
			$respuesta8='Siempre';
		}
		else if($resultado["r8"]=='2'){
			$respuesta8='Casi siempre';
		}
		else if($resultado["r8"]=='1'){
			$respuesta8='A veces';
		}
		else{
			$respuesta8='Nunca';
		}

		if($resultado["r9"]=='3'){
			$respuesta9='Siempre';
		}
		else if($resultado["r9"]=='2'){
			$respuesta9='Casi siempre';
		}
		else if($resultado["r9"]=='1'){
			$respuesta9='A veces';
		}
		else{
			$respuesta9='Nunca';
		}

		if($resultado["r10"]=='3'){
			$respuesta10='Siempre';
		}
		else if($resultado["r10"]=='2'){
			$respuesta10='Casi siempre';
		}
		else if($resultado["r10"]=='1'){
			$respuesta10='A veces';
		}
		else{
			$respuesta10='Nunca';
		}


        $data["0"] .='<table class="table table-bordered table-sm compact">';
			$data["0"] .='<thead>';
				$data["0"] .='<th>Pregunta</th>';
				$data["0"] .='<th>respuesta</th>';
			$data["0"] .='</thead>';
			$data["0"] .='<tbody>';

				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='¿Hago uso óptimo del campus virtual CIAFi?';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta1;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='Hago uso eficiente de las tecnologías de la información en el desarrollo de mis clases';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta2;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='Apoyo el plan de permanencia del estudiante con comunicación oportuna de inasistencias u observaciones especiales';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta3;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='Conozco y aplico los reglamentos que intervienen en mi labor';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta4;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='Participo activamente en las actividades académicas programadas por la institución.';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta5;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';


				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='Participo activamente en las actividades administrativas, deportivas y culturales programadas por la institución.';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta6;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='Comunico oportunamente los ajustes realizados a las clases, tanto a las direcciones de escuela como a los estudiantes';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta7;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='Demuestro dominio en mi área o disciplina';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta8;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='¿Doy cumplimiento al acuerdo de labor firmado?';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta9;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

				$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='¿Muestro compromiso y entusiasmo en las actividades para docentes?';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$respuesta10;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

			$suma=$resultado["r1"]+$resultado["r2"]+$resultado["r3"]+$resultado["r4"]+$resultado["r5"]+$resultado["r6"]+$resultado["r7"]+$resultado["r8"]+$resultado["r9"]+$resultado["r10"];
			$total = round((($suma * 100)/30),2) ." %";

			$data["0"] .='<tr>';
					$data["0"] .='<td>';
						$data["0"] .='Resultado';
					$data["0"] .='</td>';
					$data["0"] .='<td>';
						$data["0"] .=$total;
					$data["0"] .='</td>';
				$data["0"] .='</tr>';

			$data["0"] .='</tbody>';
		$data["0"] .='</table>';



        echo json_encode($data);
    break;
}
?>