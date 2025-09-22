<?php 
require_once "../modelos/PanelComercial.php";
$panelcomercial = new PanelComercial();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";
$fecha_anterior=date("Y-m-d",strtotime($fecha."- 1 days"));
$semana = date("Y-m-d",strtotime($fecha."- 1 week")); 
$semana_area = date("Y-m-d",strtotime($fecha."- 1 week")); 

$rsptaperiodo = $panelcomercial->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_campana = $rsptaperiodo["periodo_campana"];
$periodo_medible = $rsptaperiodo["periodo_medible"];
$id_usuario = $_SESSION['id_usuario'];

$estado1="Preinscrito";
$estado2="Inscrito";
$estado3="Seleccionado";
$estado4="Admitido";
$estado5="Matriculado";

$medio1 ="Marketing-digital";
$medio2 ="Web";
$medio3 ="Asesor";



$lastChar = substr($periodo_actual, -1);


$nuevafecha = strtotime ( '-1 year' , strtotime ( $fecha ) ) ; 
$periodo_comparado_uno = date ( 'Y' , $nuevafecha );
$periodo_comparado=$periodo_comparado_uno . "-".$lastChar;

switch ($_GET["op"]){

	case 'listardatos':
        $rango=$_GET["rango"];

		$data= Array();
        $data["totaluno"] ="hola";

        $data["totaluno"] ="";
        $data["totaldos"] ="";
        $data["totaltres"] ="";
        $data["totalcuatro"] ="";
        $data["totalcinco"] ="";
        $data["totalseis"] ="";
        $data["totalmarketing"] ="";
        $data["totalweb"] ="";
        $data["totalasesor"] ="";

        $data["totaltarea"] ="";
        $data["totalrealizadas"] ="";
        $data["totalseguimiento"] ="";
        $data["totalllamada"] ="";
        $data["totalcita"] ="";
        $data["totalsinexito"] ="";
        $data["totalcontactanos"] ="";
        
        

        switch($rango){

            case '1':
            $rspta1=$panelcomercial->listarUno($fecha);
            // print_r($fecha);
            $rspta2=$panelcomercial->listarNombreDos($fecha,$estado1);
            $rspta3=$panelcomercial->listarDos($fecha,$estado2);
            $rspta4=$panelcomercial->listarDos($fecha,$estado3);
            $rspta5=$panelcomercial->listarDos($fecha,$estado4);
            $rspta6=$panelcomercial->listarDos($fecha,$estado5);
			
            $rspta8=$panelcomercial->listarTarea($fecha);
            $rspta9=$panelcomercial->listarTareaRealizadas($fecha);
            $rspta10=$panelcomercial->listarSeguimiento($fecha,"Seguimiento");
            $rspta11=$panelcomercial->listarSeguimiento($fecha,"Llamada");
            $rspta12=$panelcomercial->listarSeguimiento($fecha,"cita");
			
            $rspta13=$panelcomercial->sinexito($fecha,"Retirado");
            $rspta14=$panelcomercial->sinexito($fecha,"No_Interesado");
			$totalsinexito =$rspta13 + $rspta14;

			$mediomarketingdigital =$panelcomercial->listarDatosMedios($fecha,$medio1);
			$totalweb=$panelcomercial->listarDatosMedios($fecha,$medio2);
			$totalasesor=$panelcomercial->listarDatosMedios($fecha,$medio3);


            
			
			// $medios=$panelcomercial->listarMedios();
            // for($i=0;$i < count($medios); $i++){
            //     $nombremedio=$medios[$i]["nombre"];
            //     $rspta7=$panelcomercial->listarDatosMedios($fecha,$nombremedio);
                
                // $data["totalsiete"] .='

                //     <li class="nav-item">
                //         <a href="#" class="nav-link" onclick="'.$nombremedio.'()">
                //             '.$nombremedio.'  <span class="float-right badge bg-primary" >'.$totalsiete=count($rspta7).'</span>
                //         </a>
                //     </li>';
                    // $totalsiete=0;
            // }

            $totaluno=count($rspta1);
            // print_r($totaluno);
            $totaldos=count($rspta2);
            $totaltres=count($rspta3);
            $totalcuatro=count($rspta4);
            $totalcinco=count($rspta5);
            $totalseis=count($rspta6);
			$totalmarketing=count($mediomarketingdigital);
			$totalweb=count($totalweb);
			$totalasesor=count($totalasesor);
            $totaltarea=count($rspta8);
            $totalrealizadas=count($rspta9);
            $totalseguimiento=count($rspta10);
            $totalllamada=count($rspta11);
            $totalcita=count($rspta12);
            $totalsinexito=count($totalsinexito);
            break;

            case '2':
                $rspta1=$panelcomercial->listarUno($fecha_anterior);
                // print_r($rspta1);
                $rspta2=$panelcomercial->listarNombreDos($fecha_anterior,$estado1);
                $rspta3=$panelcomercial->listarDos($fecha_anterior,$estado2);
                $rspta4=$panelcomercial->listarDos($fecha_anterior,$estado3);
                $rspta5=$panelcomercial->listarDos($fecha_anterior,$estado4);
                $rspta6=$panelcomercial->listarDos($fecha_anterior,$estado5);
    
                $rspta8=$panelcomercial->listarTarea($fecha_anterior);
                $rspta9=$panelcomercial->listarTareaRealizadas($fecha_anterior);
                $rspta10=$panelcomercial->listarSeguimiento($fecha_anterior,"Seguimiento");
                $rspta11=$panelcomercial->listarSeguimiento($fecha_anterior,"Llamada");
                $rspta12=$panelcomercial->listarSeguimiento($fecha_anterior,"cita");

				$mediomarketingdigital =$panelcomercial->listarDatosMedios($fecha_anterior,$medio1);
				$totalweb=$panelcomercial->listarDatosMedios($fecha_anterior,$medio2);
				$totalasesor=$panelcomercial->listarDatosMedios($fecha_anterior,$medio3);

				$rspta13=$panelcomercial->sinexito($fecha_anterior,"Retirado");
				$rspta14=$panelcomercial->sinexito($fecha_anterior,"No_Interesado");
				$totalsinexito =$rspta13 + $rspta14;

    
				$totaluno=count($rspta1);
				// print_r($totaluno);
				$totaldos=count($rspta2);
				$totaltres=count($rspta3);
				$totalcuatro=count($rspta4);
				$totalcinco=count($rspta5);
				$totalseis=count($rspta6);
				$totalmarketing=count($mediomarketingdigital);
				$totalweb=count($totalweb);
				$totalasesor=count($totalasesor);
				$totaltarea=count($rspta8);
				$totalrealizadas=count($rspta9);
				$totalseguimiento=count($rspta10);
				$totalllamada=count($rspta11);
				$totalcita=count($rspta12);
				$totalsinexito=count($totalsinexito);
                break;

                case '3':
                    $rspta1=$panelcomercial->listarUnoSemana($semana);
                    $rspta2=$panelcomercial->listarNombreDosSemana($semana,$estado1);
                    $rspta3=$panelcomercial->listarNombreDosSemana($semana,$estado2);
                    $rspta4=$panelcomercial->listarNombreDosSemana($semana,$estado3);
                    $rspta5=$panelcomercial->listarNombreDosSemana($semana,$estado4);
                    $rspta6=$panelcomercial->listarNombreDosSemana($semana,$estado5);
        
                    $rspta8=$panelcomercial->listarTareaSemana($semana);
                    $rspta9=$panelcomercial->listarTareaRealizadasSemana($semana);
                    $rspta10=$panelcomercial->listarSeguimientoSemana($semana,"Seguimiento");
                    $rspta11=$panelcomercial->listarSeguimientoSemana($semana,"Llamada");
                    $rspta12=$panelcomercial->listarSeguimientoSemana($semana,"cita");
					
					$mediomarketingdigital =$panelcomercial->listarDatosMediosSemana($semana,$medio1);
					$totalweb=$panelcomercial->listarDatosMediosSemana($semana,$medio2);
					$totalasesor=$panelcomercial->listarDatosMediosSemana($semana,$medio3);
					
					$rspta13=$panelcomercial->sinexitosemana($semana,"Retirado");
					$rspta14=$panelcomercial->sinexitosemana($semana,"No_Interesado");
					$totalsinexito =$rspta13 + $rspta14;

        
					$totaluno=count($rspta1);
					// print_r($totaluno);
					$totaldos=count($rspta2);
					$totaltres=count($rspta3);
					$totalcuatro=count($rspta4);
					$totalcinco=count($rspta5);
					$totalseis=count($rspta6);
					$totalmarketing=count($mediomarketingdigital);
					$totalweb=count($totalweb);
					$totalasesor=count($totalasesor);
					$totaltarea=count($rspta8);
					$totalrealizadas=count($rspta9);
					$totalseguimiento=count($rspta10);
					$totalllamada=count($rspta11);
					$totalcita=count($rspta12);
					$totalsinexito=count($totalsinexito);
                    break;

                    case '4':
                        $rspta1=$panelcomercial->listarUnoSemana($mes_actual);
                        $rspta2=$panelcomercial->listarNombreDosSemana($mes_actual,$estado1);
                        $rspta3=$panelcomercial->listarNombreDosSemana($mes_actual,$estado2);
                        $rspta4=$panelcomercial->listarNombreDosSemana($mes_actual,$estado3);
                        $rspta5=$panelcomercial->listarNombreDosSemana($mes_actual,$estado4);
                        $rspta6=$panelcomercial->listarNombreDosSemana($mes_actual,$estado5);
            
                        $rspta8=$panelcomercial->listarTareaSemana($mes_actual);
                        $rspta9=$panelcomercial->listarTareaRealizadasSemana($mes_actual);
                        $rspta10=$panelcomercial->listarSeguimientoSemana($mes_actual,"Seguimiento");
                        $rspta11=$panelcomercial->listarSeguimientoSemana($mes_actual,"Llamada");
                        $rspta12=$panelcomercial->listarSeguimientoSemana($mes_actual,"cita");
						
						$mediomarketingdigital =$panelcomercial->listarDatosMediosSemana($mes_actual,$medio1);
						$totalweb=$panelcomercial->listarDatosMediosSemana($mes_actual,$medio2);
						$totalasesor=$panelcomercial->listarDatosMediosSemana($mes_actual,$medio3);
						
						$rspta13=$panelcomercial->sinexitosemana($mes_actual,"Retirado");
						$rspta14=$panelcomercial->sinexitosemana($mes_actual,"No_Interesado");
						
						$totalsinexito =$rspta13 + $rspta14;

						$totaluno=count($rspta1);
						// print_r($totaluno);
						$totaldos=count($rspta2);
						$totaltres=count($rspta3);
						$totalcuatro=count($rspta4);
						$totalcinco=count($rspta5);
						$totalseis=count($rspta6);
						$totalmarketing=count($mediomarketingdigital);
						$totalweb=count($totalweb);
						$totalasesor=count($totalasesor);
						$totaltarea=count($rspta8);
						$totalrealizadas=count($rspta9);
						$totalseguimiento=count($rspta10);
						$totalllamada=count($rspta11);
						$totalcita=count($rspta12);
						$totalsinexito=count($totalsinexito);
                        break;

						case '5':
							$fecha_inicial=$_GET["fecha_inicial"];
							$fecha_final=$_GET["fecha_final"];
							
							$rspta1=$panelcomercial->listarUnoRango($fecha_inicial,$fecha_final);
							$rspta2=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado1);
							$rspta3=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado2);
							$rspta4=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado3);
							$rspta5=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado4);
							$rspta6=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado5);

							$rspta8=$panelcomercial->listarRangoTarea($fecha_inicial,$fecha_final);
							
							$rspta9=$panelcomercial->listarRangoTareaTerminada($fecha_inicial,$fecha_final);

							$rspta10=$panelcomercial->listarSeguimientoRango($fecha_inicial,$fecha_final,"Seguimiento");
							$rspta11=$panelcomercial->listarSeguimientoRango($fecha_inicial,$fecha_final,"Llamada");
							$rspta12=$panelcomercial->listarSeguimientoRango($fecha_inicial,$fecha_final,"cita");

							$mediomarketingdigital =$panelcomercial->listarDatosMediosSemana($semana,$medio1);
							$totalweb=$panelcomercial->listarDatosMediosSemana($semana,$medio2);
							$totalasesor=$panelcomercial->listarDatosMediosSemana($semana,$medio3);

							$rspta13=$panelcomercial->sinexitoRango($fecha_inicial,$fecha_final,"Retirado");
							$rspta14=$panelcomercial->sinexitoRango($fecha_inicial,$fecha_final,"No_Interesado");
							$totalsinexito =$rspta13 + $rspta14;

				
							$totaluno=count($rspta1);
							// print_r($totaluno);
							$totaldos=count($rspta2);
							$totaltres=count($rspta3);
							$totalcuatro=count($rspta4);
							$totalcinco=count($rspta5);
							$totalseis=count($rspta6);
							$totalmarketing=count($mediomarketingdigital);
							$totalweb=count($totalweb);
							$totalasesor=count($totalasesor);
							$totaltarea=count($rspta8);
							$totalrealizadas=count($rspta9);
							$totalseguimiento=count($rspta10);
							$totalllamada=count($rspta11);
							$totalcita=count($rspta12);
							$totalsinexito=count($totalsinexito);
							break;
        }
        $data["totaluno"] .=$totaluno;
        $data["totaldos"] .=$totaldos;
        $data["totaltres"] .=$totaltres;
        $data["totalcuatro"] .=$totalcuatro;
        $data["totalcinco"] .=$totalcinco;
        $data["totalseis"] .=$totalseis;
        $data["totalmarketing"] .=$totalmarketing;
        $data["totalweb"] .=$totalweb;
        $data["totalasesor"] .=$totalasesor;
        $data["totaltarea"] .=$totaltarea;
        $data["totalrealizadas"] .=$totalrealizadas;
        $data["totalseguimiento"] .=$totalseguimiento;
        $data["totalllamada"] .=$totalllamada;
        $data["totalcita"] .=$totalcita;
        $data["totalsinexito"] .=$totalsinexito;

        echo json_encode($data);

	break;

    case 'listarrango':

		
		
		$fecha_inicial=$_GET["fecha_inicial"];
		$fecha_final=$_GET["fecha_final"];

		$data= Array();
		$data["totaluno"] ="hola";

        $data["totaluno"] ="";
        $data["totaldos"] ="";
        $data["totaltres"] ="";
        $data["totalcuatro"] ="";
        $data["totalcinco"] ="";
        $data["totalseis"] ="";
        $data["totalmarketing"] ="";
        $data["totalweb"] ="";
        $data["totalasesor"] ="";

        $data["totaltarea"] ="";
        $data["totalrealizadas"] ="";
        $data["totalseguimiento"] ="";
        $data["totalllamada"] ="";
        $data["totalcita"] ="";
        $data["totalsinexito"] ="";

		$data["totalcontactanos"] ="";

        $estado1="Preinscrito";
        $estado2="Inscrito";
        $estado3="Seleccionado";
        $estado4="Admitido";
        $estado5="Matriculado";

		$rspta1=$panelcomercial->listarUnoRango($fecha_inicial,$fecha_final);
		$rspta2=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado1);
		$rspta3=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado2);
		$rspta4=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado3);
		$rspta5=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado4);
		$rspta6=$panelcomercial->listarDosRango($fecha_inicial,$fecha_final,$estado5);

		$rspta8=$panelcomercial->listarRangoTarea($fecha_inicial,$fecha_final);
		
		$rspta9=$panelcomercial->listarRangoTareaTerminada($fecha_inicial,$fecha_final);
		$rspta10=$panelcomercial->listarSeguimientoRango($fecha_inicial,$fecha_final,"Seguimiento");
		$rspta11=$panelcomercial->listarSeguimientoRango($fecha_inicial,$fecha_final,"Llamada");
		$rspta12=$panelcomercial->listarSeguimientoRango($fecha_inicial,$fecha_final,"cita");

		$medio1 ="Marketing-digital";
		$medio2 ="Web";
		$medio3 ="Asesor";

		$mediomarketingdigital =$panelcomercial->listarDatosMediosRango($fecha_inicial,$fecha_final,$medio1);
		$totalweb=$panelcomercial->listarDatosMediosRango($fecha_inicial,$fecha_final,$medio2);
		$totalasesor=$panelcomercial->listarDatosMediosRango($fecha_inicial,$fecha_final,$medio3);

		$rspta13=$panelcomercial->sinexitoRango($fecha_inicial,$fecha_final,"Retirado");
		$rspta14=$panelcomercial->sinexitoRango($fecha_inicial,$fecha_final,"No_Interesado");
		$totalsinexito =$rspta13 + $rspta14;

		$totaluno=count($rspta1);
		$totaldos=count($rspta2);
		$totaltres=count($rspta3);
		$totalcuatro=count($rspta4);
		$totalcinco=count($rspta5);
		$totalseis=count($rspta6);
		$totalmarketing=count($mediomarketingdigital);
		$totalweb=count($totalweb);
		$totalasesor=count($totalasesor);
		$totaltarea=count($rspta8);
		$totalrealizadas=count($rspta9);
		$totalseguimiento=count($rspta10);
		$totalllamada=count($rspta11);
		$totalcita=count($rspta12);
		$totalsinexito=count($totalsinexito);


		$data["totaluno"] .=$totaluno;
        $data["totaldos"] .=$totaldos;
        $data["totaltres"] .=$totaltres;
        $data["totalcuatro"] .=$totalcuatro;
        $data["totalcinco"] .=$totalcinco;
        $data["totalseis"] .=$totalseis;
        $data["totalmarketing"] .=$totalmarketing;
        $data["totalweb"] .=$totalweb;
        $data["totalasesor"] .=$totalasesor;
        $data["totaltarea"] .=$totaltarea;
        $data["totalrealizadas"] .=$totalrealizadas;
        $data["totalseguimiento"] .=$totalseguimiento;
        $data["totalllamada"] .=$totalllamada;
        $data["totalcita"] .=$totalcita;
        $data["totalsinexito"] .=$totalsinexito;
		
		echo json_encode($data);

	break;

    //Mostramos las tareas 
	case 'tareascreadas':

		$tareas = $_GET["tareas"];
		// $data["totalfun"] ="";
		$data= array();
		$data[0] ="";
		
        switch($tareas){
			case 1:
				
                $data[0] ="";

				$data[0] .= 
				'		
				<table id="tareascreadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>
				';

                $listartareas=$panelcomercial->listarTarea($fecha);
				for ($n = 0; $n < count($listartareas) ; $n++) {
                    // Datos listartareas 
					$mensaje_tarea=$listartareas[$n]["mensaje_tarea"];
					$motivo_tarea=$listartareas[$n]["motivo_tarea"];
					$fecha_programada=$listartareas[$n]["fecha_programada"];
					$hora_programada=$listartareas[$n]["hora_programada"];
					$estado=$listartareas[$n]["estado"];

                    $estado = ($estado == 1) ?'<span class="badge badge-danger p-1">Pendiente</span>' :'<span class="badge badge-success p-1"> Finalizado</span>';
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_programada).'</td>
                                <td>'.$hora_programada.'</td> 
                                <td>'.$estado.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="tareascreadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>
				';
		
                $listartareas=$panelcomercial->listarTarea($fecha_anterior);
				for ($n = 0; $n < count($listartareas) ; $n++) {

					$mensaje_tarea=$listartareas[$n]["mensaje_tarea"];
					$motivo_tarea=$listartareas[$n]["motivo_tarea"];
					$fecha_programada=$listartareas[$n]["fecha_programada"];
					$hora_programada=$listartareas[$n]["hora_programada"];
					$estado=$listartareas[$n]["estado"];

                    $estado = ($estado == 1) ?'<span class="badge badge-danger p-1">Pendiente</span>' :'<span class="badge badge-success p-1"> Finalizado</span>';
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_programada).'</td>
                                <td>'.$hora_programada.'</td> 
                                <td>'.$estado.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="tareascreadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>
				';
		
                $listartareas=$panelcomercial->listarTareaSemana($semana);
				for ($n = 0; $n < count($listartareas) ; $n++) {

					$mensaje_tarea=$listartareas[$n]["mensaje_tarea"];
					$motivo_tarea=$listartareas[$n]["motivo_tarea"];
					$fecha_programada=$listartareas[$n]["fecha_programada"];
					$hora_programada=$listartareas[$n]["hora_programada"];
					$estado=$listartareas[$n]["estado"];

                    $estado = ($estado == 1) ?'<span class="badge badge-danger p-1">Pendiente</span>' :'<span class="badge badge-success p-1"> Finalizado</span>';
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_programada).'</td>
                                <td>'.$hora_programada.'</td> 
                                <td>'.$estado.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="tareascreadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>';
		
                $listartareas=$panelcomercial->listarTareaSemana($mes_actual);
				for ($n = 0; $n < count($listartareas) ; $n++) {

					$mensaje_tarea=$listartareas[$n]["mensaje_tarea"];
					$motivo_tarea=$listartareas[$n]["motivo_tarea"];
					$fecha_programada=$listartareas[$n]["fecha_programada"];
					$hora_programada=$listartareas[$n]["hora_programada"];
					$estado=$listartareas[$n]["estado"];

                    $estado = ($estado == 1) ?'<span class="badge badge-danger p-1">Pendiente</span>' :'<span class="badge badge-success p-1"> Finalizado</span>';
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_programada).'</td>
                                <td>'.$hora_programada.'</td> 
                                <td>'.$estado.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:
				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];


				$data[0] ="";

				$data[0] .= 
				'		
                <table id="tareascreadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>';
		
                $listartareas=$panelcomercial->listarRangoTarea($fecha_inicial,$fecha_final);
				for ($n = 0; $n < count($listartareas) ; $n++) {

					$mensaje_tarea=$listartareas[$n]["mensaje_tarea"];
					$motivo_tarea=$listartareas[$n]["motivo_tarea"];
					$fecha_programada=$listartareas[$n]["fecha_programada"];
					$hora_programada=$listartareas[$n]["hora_programada"];
					$estado=$listartareas[$n]["estado"];

                    $estado = ($estado == 1) ?'<span class="badge badge-danger p-1">Pendiente</span>' :'<span class="badge badge-success p-1"> Finalizado</span>';
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_programada).'</td>
                                <td>'.$hora_programada.'</td> 
                                <td>'.$estado.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			
		}
		
		echo json_encode($data);		
	break;


    //Mostramos las tareas realizadas 
	case 'tareasrealizadas':

		$tareasrealizadas = $_GET["tareasrealizadas"];
		$data= array();
		$data[0] ="";
		
        switch($tareasrealizadas){
			case 1:
				
                $data[0] ="";

				$data[0] .= 
				'		
                <table id="tareasfinalizadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Registro</th>
				<th scope="col">Hora Registro</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Fecha realizo</th>
				</tr>
				</thead>
				<tbody>
				';
                
                $listartareasrealizadas=$panelcomercial->listarTareaRealizadas($fecha);
				for ($n = 0; $n < count($listartareasrealizadas) ; $n++) {
                    
                    // Datos Funcionario 
					$motivo_tarea=$listartareasrealizadas[$n]["motivo_tarea"];
					$mensaje_tarea=$listartareasrealizadas[$n]["mensaje_tarea"];
					$fecha_registro=$listartareasrealizadas[$n]["fecha_registro"];
					$hora_registro=$listartareasrealizadas[$n]["hora_registro"];
					$fecha_programada=$listartareasrealizadas[$n]["fecha_programada"];
					$hora_programada=$listartareasrealizadas[$n]["hora_programada"];
					$fecha_realizo=$listartareasrealizadas[$n]["fecha_realizo"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_registro).'</td> 
                                <td>'.$hora_registro.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_programada).'</td> 
                                <td>'.$hora_programada.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_realizo).'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="tareasfinalizadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Registro</th>
				<th scope="col">Hora Registro</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Fecha realizo</th>
				</tr>
				</thead>
				<tbody>
				';
                
                $listartareasrealizadas=$panelcomercial->listarTareaRealizadas($fecha_anterior);
				for ($n = 0; $n < count($listartareasrealizadas) ; $n++) {
                    
                    // Datos listartareasrealizadas 
					$motivo_tarea=$listartareasrealizadas[$n]["motivo_tarea"];
					$mensaje_tarea=$listartareasrealizadas[$n]["mensaje_tarea"];
					$fecha_registro=$listartareasrealizadas[$n]["fecha_registro"];
					$hora_registro=$listartareasrealizadas[$n]["hora_registro"];
					$fecha_programada=$listartareasrealizadas[$n]["fecha_programada"];
					$hora_programada=$listartareasrealizadas[$n]["hora_programada"];
					$fecha_realizo=$listartareasrealizadas[$n]["fecha_realizo"];
					
					
                    
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_registro).'</td> 
                                <td>'.$hora_registro.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_programada).'</td> 
                                <td>'.$hora_programada.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_realizo).'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="tareasfinalizadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Registro</th>
				<th scope="col">Hora Registro</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Fecha realizo</th>
				</tr>
				</thead>
				<tbody>
				';
                
                $listartareasrealizadas=$panelcomercial->listarTareaRealizadasSemana($semana);
				for ($n = 0; $n < count($listartareasrealizadas) ; $n++) {
                    
                    // Datos listartareasrealizadas 
					$motivo_tarea=$listartareasrealizadas[$n]["motivo_tarea"];
					$mensaje_tarea=$listartareasrealizadas[$n]["mensaje_tarea"];
					$fecha_registro=$listartareasrealizadas[$n]["fecha_registro"];
					$hora_registro=$listartareasrealizadas[$n]["hora_registro"];
					$fecha_programada=$listartareasrealizadas[$n]["fecha_programada"];
					$hora_programada=$listartareasrealizadas[$n]["hora_programada"];
					$fecha_realizo=$listartareasrealizadas[$n]["fecha_realizo"];
					
					
                    
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_registro).'</td> 
                                <td>'.$hora_registro.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_programada).'</td> 
                                <td>'.$hora_programada.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_realizo).'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="tareasfinalizadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Registro</th>
				<th scope="col">Hora Registro</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Fecha realizo</th>
				</tr>
				</thead>
				<tbody>
				';
                
                $listartareasrealizadas=$panelcomercial->listarTareaRealizadasSemana($mes_actual);
				for ($n = 0; $n < count($listartareasrealizadas) ; $n++) {
                    
                    // Datos listartareasrealizadas 
					$motivo_tarea=$listartareasrealizadas[$n]["motivo_tarea"];
					$mensaje_tarea=$listartareasrealizadas[$n]["mensaje_tarea"];
					$fecha_registro=$listartareasrealizadas[$n]["fecha_registro"];
					$hora_registro=$listartareasrealizadas[$n]["hora_registro"];
					$fecha_programada=$listartareasrealizadas[$n]["fecha_programada"];
					$hora_programada=$listartareasrealizadas[$n]["hora_programada"];
					$fecha_realizo=$listartareasrealizadas[$n]["fecha_realizo"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_registro).'</td> 
                                <td>'.$hora_registro.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_programada).'</td> 
                                <td>'.$hora_programada.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_realizo).'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:
				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];


				$data[0] .= 
				'		
                <table id="tareasfinalizadas" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Mensaje Tarea</th>
				<th scope="col">Motivo Tarea</th>
				<th scope="col">Fecha Registro</th>
				<th scope="col">Hora Registro</th>
				<th scope="col">Hora Programada</th>
				<th scope="col">Fecha Programada</th>
				<th scope="col">Fecha realizo</th>
				</tr>
				</thead>
				<tbody>
				';
		
                $listartareasrealizadas=$panelcomercial->listarRangoTareaTerminada($fecha_inicial,$fecha_final);
				for ($n = 0; $n < count($listartareasrealizadas) ; $n++) {

					// Datos listartareasrealizadas 
					$motivo_tarea=$listartareasrealizadas[$n]["motivo_tarea"];
					$mensaje_tarea=$listartareasrealizadas[$n]["mensaje_tarea"];
					$fecha_registro=$listartareasrealizadas[$n]["fecha_registro"];
					$hora_registro=$listartareasrealizadas[$n]["hora_registro"];
					$fecha_programada=$listartareasrealizadas[$n]["fecha_programada"];
					$hora_programada=$listartareasrealizadas[$n]["hora_programada"];
					$fecha_realizo=$listartareasrealizadas[$n]["fecha_realizo"];

                    $data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$mensaje_tarea.'</td> 
                                <td>'.$motivo_tarea.'</td> 
                                <td>'. $panelcomercial->fechaesp($fecha_registro).'</td> 
                                <td>'.$hora_registro.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_programada).'</td> 
                                <td>'.$hora_programada.'</td> 
                                <td>'.$panelcomercial->fechaesp($fecha_realizo).'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			
		}
		
		echo json_encode($data);		
	break;

    //Mostramos las llamadas
	case 'llamadas':

		$llamadas = $_GET["llamadas"];
		$data= array();
		$data[0] ="";
		
        switch($llamadas){
			case 1:
				
                $data[0] ="";

				$data[0] .= 
				'		
                <table id="llamadastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>';
                
                $llamadas=$panelcomercial->listarSeguimiento($fecha,"Llamada");
				for ($n = 0; $n < count($llamadas) ; $n++) {
                    
                    // Datos LLamadas
                    $nombre = $llamadas[$n]["usuario_nombre"]." ".$llamadas[$n]["usuario_nombre_2"]." ".$llamadas[$n]["usuario_apellido"]." ".$llamadas[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$llamadas[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$llamadas[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$llamadas[$n]["hora_seguimiento"];
					$asesor=$llamadas[$n]["asesor"];
					
					$data[0] .= '
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="llamadastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>';
                
                $llamadas=$panelcomercial->listarSeguimiento($fecha_anterior,"Llamada");
				for ($n = 0; $n < count($llamadas) ; $n++) {
                    
                    // Datos LLamadas
                    $nombre = $llamadas[$n]["usuario_nombre"]." ".$llamadas[$n]["usuario_nombre_2"]." ".$llamadas[$n]["usuario_apellido"]." ".$llamadas[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$llamadas[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$llamadas[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$llamadas[$n]["hora_seguimiento"];
					$asesor=$llamadas[$n]["asesor"];
					
					$data[0] .= '
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;		
			
			case 3:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="llamadastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>';
                
                $llamadas=$panelcomercial->listarSeguimientoSemana($semana,"Llamada");
				for ($n = 0; $n < count($llamadas) ; $n++) {
                    
                    // Datos LLamadas
                    $nombre = $llamadas[$n]["usuario_nombre"]." ".$llamadas[$n]["usuario_nombre_2"]." ".$llamadas[$n]["usuario_apellido"]." ".$llamadas[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$llamadas[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$llamadas[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$llamadas[$n]["hora_seguimiento"];
					$asesor=$llamadas[$n]["asesor"];
					
					$data[0] .= '
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="llamadastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>';
                
                $llamadas=$panelcomercial->listarSeguimientoSemana($mes_actual,"Llamada");
				for ($n = 0; $n < count($llamadas) ; $n++) {
                    
                    // Datos LLamadas
                    $nombre = $llamadas[$n]["usuario_nombre"]." ".$llamadas[$n]["usuario_nombre_2"]." ".$llamadas[$n]["usuario_apellido"]." ".$llamadas[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$llamadas[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$llamadas[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$llamadas[$n]["hora_seguimiento"];
					$asesor=$llamadas[$n]["asesor"];
					
					$data[0] .= '
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 5:
				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];

				$data[0] ="";

				$data[0] .= 
				'		
                <table id="llamadastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>';
                

				$llamadas=$panelcomercial->listarSeguimientoRango($fecha_inicial,$fecha_final,"Llamada");
				for ($n = 0; $n < count($llamadas) ; $n++) {
                    
                    // Datos LLamadas
                    $nombre = $llamadas[$n]["usuario_nombre"]." ".$llamadas[$n]["usuario_nombre_2"]." ".$llamadas[$n]["usuario_apellido"]." ".$llamadas[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$llamadas[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$llamadas[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$llamadas[$n]["hora_seguimiento"];
					$asesor=$llamadas[$n]["asesor"];
					
					$data[0] .= '
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			
		}
		
		echo json_encode($data);		
	break;

     //Mostramos los seguimientos
	case 'seguimientos':

		$seguimientos = $_GET["seguimientos"];
		$data= array();
		$data[0] ="";
		
        switch($seguimientos){
			case 1:
				
                $data[0] ="";

				$data[0] .= 
				'		
                <table id="seguimientostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
                $seguimientos=$panelcomercial->listarSeguimiento($fecha,"Seguimiento");
				for ($n = 0; $n < count($seguimientos) ; $n++) {
                    $nombre = $seguimientos[$n]["usuario_nombre"]." ".$seguimientos[$n]["usuario_nombre_2"]." ".$seguimientos[$n]["usuario_apellido"]." ".$seguimientos[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$seguimientos[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$seguimientos[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$seguimientos[$n]["hora_seguimiento"];
					$asesor=$seguimientos[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="seguimientostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
                $seguimientos=$panelcomercial->listarSeguimiento($fecha_anterior,"Seguimiento");
				for ($n = 0; $n < count($seguimientos) ; $n++) {
                    
                    $nombre = $seguimientos[$n]["usuario_nombre"]." ".$seguimientos[$n]["usuario_nombre_2"]." ".$seguimientos[$n]["usuario_apellido"]." ".$seguimientos[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$seguimientos[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$seguimientos[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$seguimientos[$n]["hora_seguimiento"];
					$asesor=$seguimientos[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="seguimientostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
                $seguimientos=$panelcomercial->listarSeguimientoSemana($semana,"Seguimiento");
				for ($n = 0; $n < count($seguimientos) ; $n++) {
                    $nombre = $seguimientos[$n]["usuario_nombre"]." ".$seguimientos[$n]["usuario_nombre_2"]." ".$seguimientos[$n]["usuario_apellido"]." ".$seguimientos[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$seguimientos[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$seguimientos[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$seguimientos[$n]["hora_seguimiento"];
					$asesor=$seguimientos[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="seguimientostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
                $seguimientos=$panelcomercial->listarSeguimientoSemana($mes_actual,"Seguimiento");
				for ($n = 0; $n < count($seguimientos) ; $n++) {
                    $nombre = $seguimientos[$n]["usuario_nombre"]." ".$seguimientos[$n]["usuario_nombre_2"]." ".$seguimientos[$n]["usuario_apellido"]." ".$seguimientos[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$seguimientos[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$seguimientos[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$seguimientos[$n]["hora_seguimiento"];
					$asesor=$seguimientos[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:
				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];

				$data[0] ="";

				$data[0] .= 
				'		
                <table id="seguimientostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
				$seguimientos=$panelcomercial->listarSeguimientoRango($fecha_inicial,$fecha_final,"Seguimiento");
				for ($n = 0; $n < count($seguimientos) ; $n++) {
                    $nombre = $seguimientos[$n]["usuario_nombre"]." ".$seguimientos[$n]["usuario_nombre_2"]." ".$seguimientos[$n]["usuario_apellido"]." ".$seguimientos[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$seguimientos[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$seguimientos[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$seguimientos[$n]["hora_seguimiento"];
					$asesor=$seguimientos[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';


			break;

			
		}
		
		echo json_encode($data);		
	break;

    //Mostramos las citas
	case 'citas':

		$citas = $_GET["citas"];
		$data= array();
		$data[0] ="";
		
        switch($citas){
			case 1:
				
                $data[0] ="";

				$data[0] .= 
				'		
                <table id="citastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
                $cita=$panelcomercial->listarSeguimiento($fecha,"cita");
				for ($n = 0; $n < count($cita) ; $n++) {

                    // Datos Cita
                    $nombre = $cita[$n]["usuario_nombre"]." ".$cita[$n]["usuario_nombre_2"]." ".$cita[$n]["usuario_apellido"]." ".$cita[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$cita[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$cita[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$cita[$n]["hora_seguimiento"];
					$asesor=$cita[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="citastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
                $cita=$panelcomercial->listarSeguimiento($fecha_anterior,"cita");
				for ($n = 0; $n < count($cita) ; $n++) {

                    // Datos Cita
                    $nombre = $cita[$n]["usuario_nombre"]." ".$cita[$n]["usuario_nombre_2"]." ".$cita[$n]["usuario_apellido"]." ".$cita[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$cita[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$cita[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$cita[$n]["hora_seguimiento"];
					$asesor=$cita[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="citastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
                $cita=$panelcomercial->listarSeguimientoSemana($semana,"cita");
				for ($n = 0; $n < count($cita) ; $n++) {

                    // Datos Cita
                    $nombre = $cita[$n]["usuario_nombre"]." ".$cita[$n]["usuario_nombre_2"]." ".$cita[$n]["usuario_apellido"]." ".$cita[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$cita[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$cita[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$cita[$n]["hora_seguimiento"];
					$asesor=$cita[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="citastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
                $cita=$panelcomercial->listarSeguimientoSemana($mes_actual,"cita");
				for ($n = 0; $n < count($cita) ; $n++) {

                    // Datos Cita
                    $nombre = $cita[$n]["usuario_nombre"]." ".$cita[$n]["usuario_nombre_2"]." ".$cita[$n]["usuario_apellido"]." ".$cita[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$cita[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$cita[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$cita[$n]["hora_seguimiento"];
					$asesor=$cita[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:
				// $data["0"] ="";

				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];
				
				$data[0] ="";

				$data[0] .= 
				'		
                <table id="citastabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Motivo Seguimiento</th>
				<th scope="col">Mensaje Seguimiento</th>
				<th scope="col">Hora Seguimiento</th>
				<th scope="col">Asesor</th> 
				</tr>
				</thead>
				<tbody>
				';
                
				$cita=$panelcomercial->listarSeguimientoRango($fecha_inicial,$fecha_final,"cita");
				for ($n = 0; $n < count($cita) ; $n++) {

                    // Datos Cita
                    $nombre = $cita[$n]["usuario_nombre"]." ".$cita[$n]["usuario_nombre_2"]." ".$cita[$n]["usuario_apellido"]." ".$cita[$n]["usuario_apellido_2"];
					$motivo_seguimiento=$cita[$n]["motivo_seguimiento"];
					$mensaje_seguimiento=$cita[$n]["mensaje_seguimiento"];
					$hora_seguimiento=$cita[$n]["hora_seguimiento"];
					$asesor=$cita[$n]["asesor"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
                                <td>'.$motivo_seguimiento.'</td> 
                                <td>'.$mensaje_seguimiento.'</td> 
                                <td>'.$hora_seguimiento.'</td> 
                                <td>'.$nombre.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			
		}
		
		echo json_encode($data);		
	break;
	
	//Mostramos los preinscritos
	case 'preinscritos':

		$preinscritos = $_GET["preinscritos"];
		$data= array();
		$data[0] ="";
		
        switch($preinscritos){
			case 1:
				

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="preinscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$preinscritos=$panelcomercial->listarNombreDos($fecha,$estado1);
				for ($n = 0; $n < count($preinscritos) ; $n++) {
                
					$id_estudiante = $preinscritos[$n]["id_estudiante"];
					$identificacion = $preinscritos[$n]["identificacion"];
					$nombre = $preinscritos[$n]["nombre"] . " " . $preinscritos[$n]["nombre_2"] . " " . $preinscritos[$n]["apellidos"] . " " . $preinscritos[$n]["apellidos_2"];
					
					$fo_programa = $preinscritos[$n]["fo_programa"];
					$jornada = $preinscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($preinscritos[$n]["fecha_ingreso"]);
					$medio = $preinscritos[$n]["medio"];
					$conocio = $preinscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="preinscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$preinscritos=$panelcomercial->listarNombreDos($fecha_anterior,$estado1);
				for ($n = 0; $n < count($preinscritos) ; $n++) {
                
					$id_estudiante = $preinscritos[$n]["id_estudiante"];
					$identificacion = $preinscritos[$n]["identificacion"];
					$nombre = $preinscritos[$n]["nombre"] . " " . $preinscritos[$n]["nombre_2"] . " " . $preinscritos[$n]["apellidos"] . " " . $preinscritos[$n]["apellidos_2"];
					
					$fo_programa = $preinscritos[$n]["fo_programa"];
					$jornada = $preinscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($preinscritos[$n]["fecha_ingreso"]);
					$medio = $preinscritos[$n]["medio"];
					$conocio = $preinscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="preinscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$preinscritos=$panelcomercial->listarNombreDosSemana($semana,$estado1);
				for ($n = 0; $n < count($preinscritos) ; $n++) {
                
					$id_estudiante = $preinscritos[$n]["id_estudiante"];
					$identificacion = $preinscritos[$n]["identificacion"];
					$nombre = $preinscritos[$n]["nombre"] . " " . $preinscritos[$n]["nombre_2"] . " " . $preinscritos[$n]["apellidos"] . " " . $preinscritos[$n]["apellidos_2"];
					
					$fo_programa = $preinscritos[$n]["fo_programa"];
					$jornada = $preinscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($preinscritos[$n]["fecha_ingreso"]);
					$medio = $preinscritos[$n]["medio"];
					$conocio = $preinscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="preinscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$preinscritos=$panelcomercial->listarNombreDosSemana($mes_actual,$estado1);
				for ($n = 0; $n < count($preinscritos) ; $n++) {
                
					$id_estudiante = $preinscritos[$n]["id_estudiante"];
					$identificacion = $preinscritos[$n]["identificacion"];
					$nombre = $preinscritos[$n]["nombre"] . " " . $preinscritos[$n]["nombre_2"] . " " . $preinscritos[$n]["apellidos"] . " " . $preinscritos[$n]["apellidos_2"];
					
					$fo_programa = $preinscritos[$n]["fo_programa"];
					$jornada = $preinscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($preinscritos[$n]["fecha_ingreso"]);
					$medio = $preinscritos[$n]["medio"];
					$conocio = $preinscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:


				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="preinscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$preinscritos=$panelcomercial->listarNombreDosRango($fecha_inicial,$fecha_final,$estado1);
				for ($n = 0; $n < count($preinscritos) ; $n++) {
                
					$id_estudiante = $preinscritos[$n]["id_estudiante"];
					$identificacion = $preinscritos[$n]["identificacion"];
					$nombre = $preinscritos[$n]["nombre"] . " " . $preinscritos[$n]["nombre_2"] . " " . $preinscritos[$n]["apellidos"] . " " . $preinscritos[$n]["apellidos_2"];
					
					$fo_programa = $preinscritos[$n]["fo_programa"];
					$jornada = $preinscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($preinscritos[$n]["fecha_ingreso"]);
					$medio = $preinscritos[$n]["medio"];
					$conocio = $preinscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';	
			break;

			
		}
		
		echo json_encode($data);		
	break;



	//Mostramos los inscritos
	case 'inscritos':

		$inscritos = $_GET["inscritos"];
		$data= array();
		$data[0] ="";
		
        switch($inscritos){
			case 1:
				

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="inscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$inscritos=$panelcomercial->listarNombreDos($fecha,$estado2);
				for ($n = 0; $n < count($inscritos) ; $n++) {
                
					$id_estudiante = $inscritos[$n]["id_estudiante"];
					$identificacion = $inscritos[$n]["identificacion"];
					$nombre = $inscritos[$n]["nombre"] . " " . $inscritos[$n]["nombre_2"] . " " . $inscritos[$n]["apellidos"] . " " . $inscritos[$n]["apellidos_2"];
					
					$fo_programa = $inscritos[$n]["fo_programa"];
					$jornada = $inscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($inscritos[$n]["fecha_ingreso"]);
					$medio = $inscritos[$n]["medio"];
					$conocio = $inscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="inscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$inscritos=$panelcomercial->listarNombreDos($fecha_anterior,$estado2);
				for ($n = 0; $n < count($inscritos) ; $n++) {
                
					$id_estudiante = $inscritos[$n]["id_estudiante"];
					$identificacion = $inscritos[$n]["identificacion"];
					$nombre = $inscritos[$n]["nombre"] . " " . $inscritos[$n]["nombre_2"] . " " . $inscritos[$n]["apellidos"] . " " . $inscritos[$n]["apellidos_2"];
					
					$fo_programa = $inscritos[$n]["fo_programa"];
					$jornada = $inscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($inscritos[$n]["fecha_ingreso"]);
					$medio = $inscritos[$n]["medio"];
					$conocio = $inscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="inscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$inscritos=$panelcomercial->listarNombreDosSemana($semana,$estado2);
				for ($n = 0; $n < count($inscritos) ; $n++) {
                
					$id_estudiante = $inscritos[$n]["id_estudiante"];
					$identificacion = $inscritos[$n]["identificacion"];
					$nombre = $inscritos[$n]["nombre"] . " " . $inscritos[$n]["nombre_2"] . " " . $inscritos[$n]["apellidos"] . " " . $inscritos[$n]["apellidos_2"];
					
					$fo_programa = $inscritos[$n]["fo_programa"];
					$jornada = $inscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($inscritos[$n]["fecha_ingreso"]);
					$medio = $inscritos[$n]["medio"];
					$conocio = $inscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="inscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$inscritos=$panelcomercial->listarNombreDosSemana($mes_actual,$estado2);
				
				
				for ($n = 0; $n < count($inscritos) ; $n++) {
                
					$id_estudiante = $inscritos[$n]["id_estudiante"];
					$identificacion = $inscritos[$n]["identificacion"];
					$nombre = $inscritos[$n]["nombre"] . " " . $inscritos[$n]["nombre_2"] . " " . $inscritos[$n]["apellidos"] . " " . $inscritos[$n]["apellidos_2"];
					
					$fo_programa = $inscritos[$n]["fo_programa"];
					$jornada = $inscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($inscritos[$n]["fecha_ingreso"]);
					$medio = $inscritos[$n]["medio"];
					$conocio = $inscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:


				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="inscritostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$inscritos=$panelcomercial->listarNombreDosRango($fecha_inicial,$fecha_final,$estado2);
				for ($n = 0; $n < count($inscritos) ; $n++) {
                
					$id_estudiante = $inscritos[$n]["id_estudiante"];
					$identificacion = $inscritos[$n]["identificacion"];
					$nombre = $inscritos[$n]["nombre"] . " " . $inscritos[$n]["nombre_2"] . " " . $inscritos[$n]["apellidos"] . " " . $inscritos[$n]["apellidos_2"];
					
					$fo_programa = $inscritos[$n]["fo_programa"];
					$jornada = $inscritos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($inscritos[$n]["fecha_ingreso"]);
					$medio = $inscritos[$n]["medio"];
					$conocio = $inscritos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';	
			break;

			
		}
		
		echo json_encode($data);		
	break;


	//Mostramos los seleccionados
	case 'seleccionados':

		$seleccionados = $_GET["seleccionados"];
		$data= array();
		$data[0] ="";
		
        switch($seleccionados){
			case 1:
				

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="seleccionadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$seleccionados=$panelcomercial->listarNombreDos($fecha,$estado3);
				for ($n = 0; $n < count($seleccionados) ; $n++) {
                
					$id_estudiante = $seleccionados[$n]["id_estudiante"];
					$identificacion = $seleccionados[$n]["identificacion"];
					$nombre = $seleccionados[$n]["nombre"] . " " . $seleccionados[$n]["nombre_2"] . " " . $seleccionados[$n]["apellidos"] . " " . $seleccionados[$n]["apellidos_2"];
					
					$fo_programa = $seleccionados[$n]["fo_programa"];
					$jornada = $seleccionados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($seleccionados[$n]["fecha_ingreso"]);
					$medio = $seleccionados[$n]["medio"];
					$conocio = $seleccionados[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="seleccionadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$seleccionados=$panelcomercial->listarNombreDos($fecha_anterior,$estado3);
				for ($n = 0; $n < count($seleccionados) ; $n++) {
                
					$id_estudiante = $seleccionados[$n]["id_estudiante"];
					$identificacion = $seleccionados[$n]["identificacion"];
					$nombre = $seleccionados[$n]["nombre"] . " " . $seleccionados[$n]["nombre_2"] . " " . $seleccionados[$n]["apellidos"] . " " . $seleccionados[$n]["apellidos_2"];
					
					$fo_programa = $seleccionados[$n]["fo_programa"];
					$jornada = $seleccionados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($seleccionados[$n]["fecha_ingreso"]);
					$medio = $seleccionados[$n]["medio"];
					$conocio = $seleccionados[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="seleccionadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$seleccionados=$panelcomercial->listarNombreDosSemana($semana,$estado3);
				for ($n = 0; $n < count($seleccionados) ; $n++) {
                
					$id_estudiante = $seleccionados[$n]["id_estudiante"];
					$identificacion = $seleccionados[$n]["identificacion"];
					$nombre = $seleccionados[$n]["nombre"] . " " . $seleccionados[$n]["nombre_2"] . " " . $seleccionados[$n]["apellidos"] . " " . $seleccionados[$n]["apellidos_2"];
					
					$fo_programa = $seleccionados[$n]["fo_programa"];
					$jornada = $seleccionados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($seleccionados[$n]["fecha_ingreso"]);
					$medio = $seleccionados[$n]["medio"];
					$conocio = $seleccionados[$n]["conocio"];
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="seleccionadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$seleccionados=$panelcomercial->listarNombreDosSemana($mes_actual,$estado3);
				
				
				for ($n = 0; $n < count($seleccionados) ; $n++) {
                
					$id_estudiante = $seleccionados[$n]["id_estudiante"];
					$identificacion = $seleccionados[$n]["identificacion"];
					$nombre = $seleccionados[$n]["nombre"] . " " . $seleccionados[$n]["nombre_2"] . " " . $seleccionados[$n]["apellidos"] . " " . $seleccionados[$n]["apellidos_2"];
					
					$fo_programa = $seleccionados[$n]["fo_programa"];
					$jornada = $seleccionados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($seleccionados[$n]["fecha_ingreso"]);
					$medio = $seleccionados[$n]["medio"];
					$conocio = $seleccionados[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:


				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="seleccionadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$seleccionados=$panelcomercial->listarNombreDosRango($fecha_inicial,$fecha_final,$estado3);
				for ($n = 0; $n < count($seleccionados) ; $n++) {
                
					$id_estudiante = $seleccionados[$n]["id_estudiante"];
					$identificacion = $seleccionados[$n]["identificacion"];
					$nombre = $seleccionados[$n]["nombre"] . " " . $seleccionados[$n]["nombre_2"] . " " . $seleccionados[$n]["apellidos"] . " " . $seleccionados[$n]["apellidos_2"];
					
					$fo_programa = $seleccionados[$n]["fo_programa"];
					$jornada = $seleccionados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($seleccionados[$n]["fecha_ingreso"]);
					$medio = $seleccionados[$n]["medio"];
					$conocio = $seleccionados[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';	
			break;

			
		}
		
		echo json_encode($data);		
	break;


	//Mostramos los admitidos
	case 'admitidos':

		$admitidos = $_GET["admitidos"];
		$data= array();
		$data[0] ="";
		
        switch($admitidos){
			case 1:
				

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="admitidostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$admitidos=$panelcomercial->listarNombreDos($fecha,$estado4);
				for ($n = 0; $n < count($admitidos) ; $n++) {
                
					$id_estudiante = $admitidos[$n]["id_estudiante"];
					$identificacion = $admitidos[$n]["identificacion"];
					$nombre = $admitidos[$n]["nombre"] . " " . $admitidos[$n]["nombre_2"] . " " . $admitidos[$n]["apellidos"] . " " . $admitidos[$n]["apellidos_2"];
					
					$fo_programa = $admitidos[$n]["fo_programa"];
					$jornada = $admitidos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($admitidos[$n]["fecha_ingreso"]);
					$medio = $admitidos[$n]["medio"];
					$conocio = $admitidos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="admitidostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$admitidos=$panelcomercial->listarNombreDos($fecha_anterior,$estado4);
				for ($n = 0; $n < count($admitidos) ; $n++) {
                
					$id_estudiante = $admitidos[$n]["id_estudiante"];
					$identificacion = $admitidos[$n]["identificacion"];
					$nombre = $admitidos[$n]["nombre"] . " " . $admitidos[$n]["nombre_2"] . " " . $admitidos[$n]["apellidos"] . " " . $admitidos[$n]["apellidos_2"];
					
					$fo_programa = $admitidos[$n]["fo_programa"];
					$jornada = $admitidos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($admitidos[$n]["fecha_ingreso"]);
					$medio = $admitidos[$n]["medio"];
					$conocio = $admitidos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="admitidostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$admitidos=$panelcomercial->listarNombreDosSemana($semana,$estado4);
				for ($n = 0; $n < count($admitidos) ; $n++) {
                
					$id_estudiante = $admitidos[$n]["id_estudiante"];
					$identificacion = $admitidos[$n]["identificacion"];
					$nombre = $admitidos[$n]["nombre"] . " " . $admitidos[$n]["nombre_2"] . " " . $admitidos[$n]["apellidos"] . " " . $admitidos[$n]["apellidos_2"];
					
					$fo_programa = $admitidos[$n]["fo_programa"];
					$jornada = $admitidos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($admitidos[$n]["fecha_ingreso"]);
					$medio = $admitidos[$n]["medio"];
					$conocio = $admitidos[$n]["conocio"];
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="admitidostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$admitidos=$panelcomercial->listarNombreDosSemana($mes_actual,$estado4);
				
				
				for ($n = 0; $n < count($admitidos) ; $n++) {
                
					$id_estudiante = $admitidos[$n]["id_estudiante"];
					$identificacion = $admitidos[$n]["identificacion"];
					$nombre = $admitidos[$n]["nombre"] . " " . $admitidos[$n]["nombre_2"] . " " . $admitidos[$n]["apellidos"] . " " . $admitidos[$n]["apellidos_2"];
					
					$fo_programa = $admitidos[$n]["fo_programa"];
					$jornada = $admitidos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($admitidos[$n]["fecha_ingreso"]);
					$medio = $admitidos[$n]["medio"];
					$conocio = $admitidos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:


				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="admitidostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$admitidos=$panelcomercial->listarNombreDosRango($fecha_inicial,$fecha_final,$estado4);
				for ($n = 0; $n < count($admitidos) ; $n++) {
                
					$id_estudiante = $admitidos[$n]["id_estudiante"];
					$identificacion = $admitidos[$n]["identificacion"];
					$nombre = $admitidos[$n]["nombre"] . " " . $admitidos[$n]["nombre_2"] . " " . $admitidos[$n]["apellidos"] . " " . $admitidos[$n]["apellidos_2"];
					
					$fo_programa = $admitidos[$n]["fo_programa"];
					$jornada = $admitidos[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($admitidos[$n]["fecha_ingreso"]);
					$medio = $admitidos[$n]["medio"];
					$conocio = $admitidos[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';	
			break;

			
		}
		
		echo json_encode($data);		
	break;

	//Mostramos los matriculados
	case 'matriculados':

		$matriculados = $_GET["matriculados"];
		$data= array();
		$data[0] ="";
		
        switch($matriculados){
			case 1:
				

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="matriculadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$matriculados=$panelcomercial->listarNombreDos($fecha,$estado5);
				for ($n = 0; $n < count($matriculados) ; $n++) {
                
					$id_estudiante = $matriculados[$n]["id_estudiante"];
					$identificacion = $matriculados[$n]["identificacion"];
					$nombre = $matriculados[$n]["nombre"] . " " . $matriculados[$n]["nombre_2"] . " " . $matriculados[$n]["apellidos"] . " " . $matriculados[$n]["apellidos_2"];
					
					$fo_programa = $matriculados[$n]["fo_programa"];
					$jornada = $matriculados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($matriculados[$n]["fecha_ingreso"]);
					$medio = $matriculados[$n]["medio"];
					$conocio = $matriculados[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="matriculadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$matriculados=$panelcomercial->listarNombreDos($fecha_anterior,$estado5);
				for ($n = 0; $n < count($matriculados) ; $n++) {
                
					$id_estudiante = $matriculados[$n]["id_estudiante"];
					$identificacion = $matriculados[$n]["identificacion"];
					$nombre = $matriculados[$n]["nombre"] . " " . $matriculados[$n]["nombre_2"] . " " . $matriculados[$n]["apellidos"] . " " . $matriculados[$n]["apellidos_2"];
					
					$fo_programa = $matriculados[$n]["fo_programa"];
					$jornada = $matriculados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($matriculados[$n]["fecha_ingreso"]);
					$medio = $matriculados[$n]["medio"];
					$conocio = $matriculados[$n]["conocio"];
					
					
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>	
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="matriculadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$matriculados=$panelcomercial->listarNombreDosSemana($semana,$estado5);
				for ($n = 0; $n < count($matriculados) ; $n++) {
                
					$id_estudiante = $matriculados[$n]["id_estudiante"];
					$identificacion = $matriculados[$n]["identificacion"];
					$nombre = $matriculados[$n]["nombre"] . " " . $matriculados[$n]["nombre_2"] . " " . $matriculados[$n]["apellidos"] . " " . $matriculados[$n]["apellidos_2"];
					
					$fo_programa = $matriculados[$n]["fo_programa"];
					$jornada = $matriculados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($matriculados[$n]["fecha_ingreso"]);
					$medio = $matriculados[$n]["medio"];
					$conocio = $matriculados[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="matriculadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$matriculados=$panelcomercial->listarNombreDosSemana($mes_actual,$estado5);
				
				
				for ($n = 0; $n < count($matriculados) ; $n++) {
                
					$id_estudiante = $matriculados[$n]["id_estudiante"];
					$identificacion = $matriculados[$n]["identificacion"];
					$nombre = $matriculados[$n]["nombre"] . " " . $matriculados[$n]["nombre_2"] . " " . $matriculados[$n]["apellidos"] . " " . $matriculados[$n]["apellidos_2"];
					
					$fo_programa = $matriculados[$n]["fo_programa"];
					$jornada = $matriculados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($matriculados[$n]["fecha_ingreso"]);
					$medio = $matriculados[$n]["medio"];
					$conocio = $matriculados[$n]["conocio"];
					
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:


				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="matriculadostabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$matriculados=$panelcomercial->listarNombreDosRango($fecha_inicial,$fecha_final,$estado5);
				for ($n = 0; $n < count($matriculados) ; $n++) {
                
					$id_estudiante = $matriculados[$n]["id_estudiante"];
					$identificacion = $matriculados[$n]["identificacion"];
					$nombre = $matriculados[$n]["nombre"] . " " . $matriculados[$n]["nombre_2"] . " " . $matriculados[$n]["apellidos"] . " " . $matriculados[$n]["apellidos_2"];
					
					$fo_programa = $matriculados[$n]["fo_programa"];
					$jornada = $matriculados[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($matriculados[$n]["fecha_ingreso"]);
					$medio = $matriculados[$n]["medio"];
					$conocio = $matriculados[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';	
			break;

			
		}
		
		echo json_encode($data);		
	break;

	//Mostramos los marketingdigital
	case 'marketingdigital':

		$marketingdigital = $_GET["marketingdigital"];
		$data= array();
		$data[0] ="";
		
        switch($marketingdigital){
			case 1:
				

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="marketingdigitaltabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$marketingdigital=$panelcomercial->listarDatosMedios($fecha,$medio1);

				for($n=0;$n < count($marketingdigital); $n++){
					$id_estudiante = $web[$n]["id_estudiante"];
					$identificacion = $web[$n]["identificacion"];
					$nombre = $web[$n]["nombre"] . " " . $web[$n]["nombre_2"] . " " . $web[$n]["apellidos"] . " " . $web[$n]["apellidos_2"];
					
					$fo_programa = $web[$n]["fo_programa"];
					$jornada = $web[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($web[$n]["fecha_ingreso"]);
					$medio = $web[$n]["medio"];
					$conocio = $web[$n]["conocio"];
						
						$data[0] .= '
							
							
								<tr>
									<th scope="row">'.($n +1).'</th>

									<td>'.$id_estudiante.'</td> 
									<td>'.$identificacion.'</td> 
									<td>'.$nombre.'</td> 
									<td>'.$fo_programa.'</td> 
									<td>'.$jornada.'</td> 
									<td>'.$fecha_ingreso.'</td> 
									<td>'.$medio.'</td> 
									<td>'.$conocio.'</td> 
									
								</li>
								</tr>';
							
					}
						$data[0].= '
						</tbody>
						</table>';
					
			break;

			case 2:


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="marketingdigitaltabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$marketingdigital=$panelcomercial->listarDatosMedios($fecha_anterior,$medio1);

				for($n=0;$n < count($marketingdigital); $n++){
					$id_estudiante = $marketingdigital[$n]["id_estudiante"];
					$identificacion = $marketingdigital[$n]["identificacion"];
					$nombre = $marketingdigital[$n]["nombre"] . " " . $marketingdigital[$n]["nombre_2"] . " " . $marketingdigital[$n]["apellidos"] . " " . $marketingdigital[$n]["apellidos_2"];
					
					$fo_programa = $marketingdigital[$n]["fo_programa"];
					$jornada = $marketingdigital[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($marketingdigital[$n]["fecha_ingreso"]);
					$medio = $marketingdigital[$n]["medio"];
					$conocio = $marketingdigital[$n]["conocio"];
						
						$data[0] .= '
							
							
								<tr>
									<th scope="row">'.($n +1).'</th>

									<td>'.$id_estudiante.'</td> 
									<td>'.$identificacion.'</td> 
									<td>'.$nombre.'</td> 
									<td>'.$fo_programa.'</td> 
									<td>'.$jornada.'</td> 
									<td>'.$fecha_ingreso.'</td> 
									<td>'.$medio.'</td> 
									<td>'.$conocio.'</td> 
									
								</li>
								</tr>';
							
					}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="marketingdigitaltabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$marketingdigital=$panelcomercial->listarDatosMediosSemana($semana,$medio1);

				for($n=0;$n < count($marketingdigital); $n++){
					$id_estudiante = $marketingdigital[$n]["id_estudiante"];
					$identificacion = $marketingdigital[$n]["identificacion"];
					$nombre = $marketingdigital[$n]["nombre"] . " " . $marketingdigital[$n]["nombre_2"] . " " . $marketingdigital[$n]["apellidos"] . " " . $marketingdigital[$n]["apellidos_2"];
					
					$fo_programa = $marketingdigital[$n]["fo_programa"];
					$jornada = $marketingdigital[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($marketingdigital[$n]["fecha_ingreso"]);
					$medio = $marketingdigital[$n]["medio"];
					$conocio = $marketingdigital[$n]["conocio"];
						
						$data[0] .= '
							
							
								<tr>
									<th scope="row">'.($n +1).'</th>

									<td>'.$id_estudiante.'</td> 
									<td>'.$identificacion.'</td> 
									<td>'.$nombre.'</td> 
									<td>'.$fo_programa.'</td> 
									<td>'.$jornada.'</td> 
									<td>'.$fecha_ingreso.'</td> 
									<td>'.$medio.'</td> 
									<td>'.$conocio.'</td> 
									
								</li>
								</tr>';
							
					}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="marketingdigitaltabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$marketingdigital=$panelcomercial->listarDatosMediosSemana($mes_actual,$medio1);

				for($n=0;$n < count($marketingdigital); $n++){
					$id_estudiante = $marketingdigital[$n]["id_estudiante"];
					$identificacion = $marketingdigital[$n]["identificacion"];
					$nombre = $marketingdigital[$n]["nombre"] . " " . $marketingdigital[$n]["nombre_2"] . " " . $marketingdigital[$n]["apellidos"] . " " . $marketingdigital[$n]["apellidos_2"];
					
					$fo_programa = $marketingdigital[$n]["fo_programa"];
					$jornada = $marketingdigital[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($marketingdigital[$n]["fecha_ingreso"]);
					$medio = $marketingdigital[$n]["medio"];
					$conocio = $marketingdigital[$n]["conocio"];
						
						$data[0] .= '
							
							
								<tr>
									<th scope="row">'.($n +1).'</th>

									<td>'.$id_estudiante.'</td> 
									<td>'.$identificacion.'</td> 
									<td>'.$nombre.'</td> 
									<td>'.$fo_programa.'</td> 
									<td>'.$jornada.'</td> 
									<td>'.$fecha_ingreso.'</td> 
									<td>'.$medio.'</td> 
									<td>'.$conocio.'</td> 
									
								</li>
								</tr>';
							
					}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:


				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="marketingdigitaltabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$marketingdigital=$panelcomercial->listarDatosMediosRango($fecha_inicial,$fecha_final,$medio1);
				for ($n = 0; $n < count($marketingdigital) ; $n++) {
                
					$id_estudiante = $marketingdigital[$n]["id_estudiante"];
					$identificacion = $marketingdigital[$n]["identificacion"];
					$nombre = $marketingdigital[$n]["nombre"] . " " . $marketingdigital[$n]["nombre_2"] . " " . $marketingdigital[$n]["apellidos"] . " " . $marketingdigital[$n]["apellidos_2"];
					
					$fo_programa = $marketingdigital[$n]["fo_programa"];
					$jornada = $marketingdigital[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($marketingdigital[$n]["fecha_ingreso"]);
					$medio = $marketingdigital[$n]["medio"];
					$conocio = $marketingdigital[$n]["conocio"];
						
						$data[0] .= '
							
							
								<tr>
									<th scope="row">'.($n +1).'</th>
									<td>'.$id_estudiante.'</td> 
									<td>'.$identificacion.'</td> 
									<td>'.$nombre.'</td> 
									<td>'.$fo_programa.'</td> 
									<td>'.$jornada.'</td> 
									<td>'.$fecha_ingreso.'</td> 
									<td>'.$medio.'</td> 
									<td>'.$conocio.'</td> 
									
								</li>
								</tr>';
							
					}
					$data[0].= '
					</tbody>
					</table>';
			break;

			
		}
		
		echo json_encode($data);		
	break;

	case 'web':

		$web = $_GET["web"];
		$data= array();
		$data[0] ="";
		
        switch($web){
			case 1:
				

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="webtabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$web=$panelcomercial->listarDatosMedios($fecha,$medio2);
				
            for($n=0;$n < count($web); $n++){
                
				$id_estudiante = $web[$n]["id_estudiante"];
				$identificacion = $web[$n]["identificacion"];
				$nombre = $web[$n]["nombre"] . " " . $web[$n]["nombre_2"] . " " . $web[$n]["apellidos"] . " " . $web[$n]["apellidos_2"];
				
				$fo_programa = $web[$n]["fo_programa"];
				$jornada = $web[$n]["jornada_e"];
				$fecha_ingreso = $panelcomercial->fechaesp($web[$n]["fecha_ingreso"]);
				$medio = $web[$n]["medio"];
				$conocio = $web[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="webtabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$web=$panelcomercial->listarDatosMedios($fecha_anterior,$medio2);
				
            for($n=0;$n < count($web); $n++){
                
				$id_estudiante = $web[$n]["id_estudiante"];
				$identificacion = $web[$n]["identificacion"];
				$nombre = $web[$n]["nombre"] . " " . $web[$n]["nombre_2"] . " " . $web[$n]["apellidos"] . " " . $web[$n]["apellidos_2"];
				
				$fo_programa = $web[$n]["fo_programa"];
				$jornada = $web[$n]["jornada_e"];
				$fecha_ingreso = $panelcomercial->fechaesp($web[$n]["fecha_ingreso"]);
				$medio = $web[$n]["medio"];
				$conocio = $web[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="webtabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$web=$panelcomercial->listarDatosMediosSemana($semana,$medio2);
				
            for($n=0;$n < count($web); $n++){
                
				$id_estudiante = $web[$n]["id_estudiante"];
				$identificacion = $web[$n]["identificacion"];
				$nombre = $web[$n]["nombre"] . " " . $web[$n]["nombre_2"] . " " . $web[$n]["apellidos"] . " " . $web[$n]["apellidos_2"];
				
				$fo_programa = $web[$n]["fo_programa"];
				$jornada = $web[$n]["jornada_e"];
				$fecha_ingreso = $panelcomercial->fechaesp($web[$n]["fecha_ingreso"]);
				$medio = $web[$n]["medio"];
				$conocio = $web[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="webtabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$web=$panelcomercial->listarDatosMediosSemana($mes_actual,$medio2);
				
				for($n=0;$n < count($web); $n++){
					
					$id_estudiante = $web[$n]["id_estudiante"];
					$identificacion = $web[$n]["identificacion"];
					$nombre = $web[$n]["nombre"] . " " . $web[$n]["nombre_2"] . " " . $web[$n]["apellidos"] . " " . $web[$n]["apellidos_2"];
					
					$fo_programa = $web[$n]["fo_programa"];
					$jornada = $web[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($web[$n]["fecha_ingreso"]);
					$medio = $web[$n]["medio"];
					$conocio = $web[$n]["conocio"];
						
						$data[0] .= '
							
							
								<tr>
									<th scope="row">'.($n +1).'</th>
									<td>'.$id_estudiante.'</td> 
									<td>'.$identificacion.'</td> 
									<td>'.$nombre.'</td> 
									<td>'.$fo_programa.'</td> 
									<td>'.$jornada.'</td> 
									<td>'.$fecha_ingreso.'</td> 
									<td>'.$medio.'</td> 
									<td>'.$conocio.'</td> 
									
								</li>
								</tr>';
							
					}
						$data[0].= '
						</tbody>
						</table>';
			break;

			case 5:


				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="webtabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$web=$panelcomercial->listarDatosMediosRango($fecha_inicial,$fecha_final,$medio2);
				for($n=0;$n < count($web); $n++){
					
					$id_estudiante = $web[$n]["id_estudiante"];
					$identificacion = $web[$n]["identificacion"];
					$nombre = $web[$n]["nombre"] . " " . $web[$n]["nombre_2"] . " " . $web[$n]["apellidos"] . " " . $web[$n]["apellidos_2"];
					
					$fo_programa = $web[$n]["fo_programa"];
					$jornada = $web[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($web[$n]["fecha_ingreso"]);
					$medio = $web[$n]["medio"];
					$conocio = $web[$n]["conocio"];
						
						$data[0] .= '
							
							
								<tr>
									<th scope="row">'.($n +1).'</th>

									<td>'.$id_estudiante.'</td> 
									<td>'.$identificacion.'</td> 
									<td>'.$nombre.'</td> 
									<td>'.$fo_programa.'</td> 
									<td>'.$jornada.'</td> 
									<td>'.$fecha_ingreso.'</td> 
									<td>'.$medio.'</td> 
									<td>'.$conocio.'</td> 
									
								</li>
								</tr>';
							
					}
						$data[0].= '
						</tbody>
						</table>';
			break;

			
		}
		
		echo json_encode($data);		
	break;

	case 'asesor':

		$asesor = $_GET["asesor"];
		$data= array();
		$data[0] ="";
		
        switch($asesor){
			case 1:
				

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="asesortabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$asesor=$panelcomercial->listarDatosMedios($fecha,"Asesor");

				for($n=0;$n < count($asesor); $n++){
                
					$id_estudiante = $asesor[$n]["id_estudiante"];
					$identificacion = $asesor[$n]["identificacion"];
					$nombre = $asesor[$n]["nombre"] . " " . $asesor[$n]["nombre_2"] . " " . $asesor[$n]["apellidos"] . " " . $asesor[$n]["apellidos_2"];
					
					$fo_programa = $asesor[$n]["fo_programa"];
					$jornada = $asesor[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($asesor[$n]["fecha_ingreso"]);
					$medio = $asesor[$n]["medio"];
					$conocio = $asesor[$n]["conocio"];
					
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="asesortabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$asesor=$panelcomercial->listarDatosMedios($fecha_anterior,"Asesor");

				for($n=0;$n < count($asesor); $n++){
                
					$id_estudiante = $asesor[$n]["id_estudiante"];
					$identificacion = $asesor[$n]["identificacion"];
					$nombre = $asesor[$n]["nombre"] . " " . $asesor[$n]["nombre_2"] . " " . $asesor[$n]["apellidos"] . " " . $asesor[$n]["apellidos_2"];
					
					$fo_programa = $asesor[$n]["fo_programa"];
					$jornada = $asesor[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($asesor[$n]["fecha_ingreso"]);
					$medio = $asesor[$n]["medio"];
					$conocio = $asesor[$n]["conocio"];
					
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="asesortabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$asesor=$panelcomercial->listarDatosMediosSemana($semana,"Asesor");

				for($n=0;$n < count($asesor); $n++){
                
					$id_estudiante = $asesor[$n]["id_estudiante"];
					$identificacion = $asesor[$n]["identificacion"];
					$nombre = $asesor[$n]["nombre"] . " " . $asesor[$n]["nombre_2"] . " " . $asesor[$n]["apellidos"] . " " . $asesor[$n]["apellidos_2"];
					
					$fo_programa = $asesor[$n]["fo_programa"];
					$jornada = $asesor[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($asesor[$n]["fecha_ingreso"]);
					$medio = $asesor[$n]["medio"];
					$conocio = $asesor[$n]["conocio"];
					
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="asesortabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$asesor=$panelcomercial->listarDatosMediosSemana($mes_actual,"Asesor");

				for($n=0;$n < count($asesor); $n++){
                
					$id_estudiante = $asesor[$n]["id_estudiante"];
					$identificacion = $asesor[$n]["identificacion"];
					$nombre = $asesor[$n]["nombre"] . " " . $asesor[$n]["nombre_2"] . " " . $asesor[$n]["apellidos"] . " " . $asesor[$n]["apellidos_2"];
					
					$fo_programa = $asesor[$n]["fo_programa"];
					$jornada = $asesor[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($asesor[$n]["fecha_ingreso"]);
					$medio = $asesor[$n]["medio"];
					$conocio = $asesor[$n]["conocio"];
					
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:


				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="asesortabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';
				
				$asesor=$panelcomercial->listarDatosMediosRango($fecha_inicial,$fecha_final,"Asesor");

            	for($n=0;$n < count($asesor); $n++){
                
					$id_estudiante = $asesor[$n]["id_estudiante"];
					$identificacion = $asesor[$n]["identificacion"];
					$nombre = $asesor[$n]["nombre"] . " " . $asesor[$n]["nombre_2"] . " " . $asesor[$n]["apellidos"] . " " . $asesor[$n]["apellidos_2"];
					
					$fo_programa = $asesor[$n]["fo_programa"];
					$jornada = $asesor[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($asesor[$n]["fecha_ingreso"]);
					$medio = $asesor[$n]["medio"];
					$conocio = $asesor[$n]["conocio"];
					
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';

			break;

			
		}
		
		echo json_encode($data);		
	break;



    //interesados 
	case 'interesados':

		$interesado = $_GET["interesado"];
		$data= array();
		$data[0] ="";
		
        switch($interesado){
			case 1:
				
                $data[0] ="";

				$data[0] .= 
				'		
				<table id="mostrarinteresados" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

                $rspta1=$panelcomercial->listarUno($fecha);
				for ($n = 0; $n < count($rspta1) ; $n++) {
                
					$id_estudiante = $rspta1[$n]["id_estudiante"];
					$identificacion = $rspta1[$n]["identificacion"];
					$nombre = $rspta1[$n]["nombre"] . " " . $rspta1[$n]["nombre_2"] . " " . $rspta1[$n]["apellidos"] . " " . $rspta1[$n]["apellidos_2"];
					
					$fo_programa = $rspta1[$n]["fo_programa"];
					$jornada = $rspta1[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($rspta1[$n]["fecha_ingreso"]);
					$medio = $rspta1[$n]["medio"];
					$conocio = $rspta1[$n]["conocio"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="mostrarinteresados" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

                $rspta1=$panelcomercial->listarUno($fecha_anterior);
				for ($n = 0; $n < count($rspta1) ; $n++) {
                    // print_r($rspta1);
                    // Datos Funcionario 


					$id_estudiante = $rspta1[$n]["id_estudiante"];
					$identificacion = $rspta1[$n]["identificacion"];
					$nombre = $rspta1[$n]["nombre"] . " " . $rspta1[$n]["nombre_2"] . " " . $rspta1[$n]["apellidos"] . " " . $rspta1[$n]["apellidos_2"];
					
					$fo_programa = $rspta1[$n]["fo_programa"];
					$jornada = $rspta1[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($rspta1[$n]["fecha_ingreso"]);
					$medio = $rspta1[$n]["medio"];
					$conocio = $rspta1[$n]["conocio"];
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="mostrarinteresados" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

                $rspta1=$panelcomercial->listarUnoSemana($semana);
				for ($n = 0; $n < count($rspta1) ; $n++) {
                    // print_r($rspta1);
                    // Datos Funcionario 


					$id_estudiante = $rspta1[$n]["id_estudiante"];
					$identificacion = $rspta1[$n]["identificacion"];
					$nombre = $rspta1[$n]["nombre"] . " " . $rspta1[$n]["nombre_2"] . " " . $rspta1[$n]["apellidos"] . " " . $rspta1[$n]["apellidos_2"];
					
					$fo_programa = $rspta1[$n]["fo_programa"];
					$jornada = $rspta1[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($rspta1[$n]["fecha_ingreso"]);
					$medio = $rspta1[$n]["medio"];
					$conocio = $rspta1[$n]["conocio"];
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="mostrarinteresados" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$rspta1=$panelcomercial->listarUnoSemana($mes_actual);
				for ($n = 0; $n < count($rspta1) ; $n++) {
                    
					$id_estudiante = $rspta1[$n]["id_estudiante"];
					$identificacion = $rspta1[$n]["identificacion"];
					$nombre = $rspta1[$n]["nombre"] . " " . $rspta1[$n]["nombre_2"] . " " . $rspta1[$n]["apellidos"] . " " . $rspta1[$n]["apellidos_2"];
					
					$fo_programa = $rspta1[$n]["fo_programa"];
					$jornada = $rspta1[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($rspta1[$n]["fecha_ingreso"]);
					$medio = $rspta1[$n]["medio"];
					$conocio = $rspta1[$n]["conocio"];
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:

				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="mostrarinteresados" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				</tr>
				</thead>
				<tbody>';

				$rspta1=$panelcomercial->listarUnoSemana($fecha_inicial,$fecha_final);
				for ($n = 0; $n < count($rspta1) ; $n++) {
                
					$id_estudiante = $rspta1[$n]["id_estudiante"];
					$identificacion = $rspta1[$n]["identificacion"];
					$nombre = $rspta1[$n]["nombre"] . " " . $rspta1[$n]["nombre_2"] . " " . $rspta1[$n]["apellidos"] . " " . $rspta1[$n]["apellidos_2"];
					
					$fo_programa = $rspta1[$n]["fo_programa"];
					$jornada = $rspta1[$n]["jornada_e"];
					$fecha_ingreso = $panelcomercial->fechaesp($rspta1[$n]["fecha_ingreso"]);
					$medio = $rspta1[$n]["medio"];
					$conocio = $rspta1[$n]["conocio"];
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			
		}
		
		echo json_encode($data);		
	break;

	//Mostramos sinexito
	case 'sinexito':

		$sinexito = $_GET["sinexito"];
		$data= array();
		$data[0] ="";
		
        switch($sinexito){
			case 1:
				

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="sinexitotabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>';
				

				$rspta13=$panelcomercial->sinexito($fecha,"Retirado");
				$rspta14=$panelcomercial->sinexito($fecha,"No_Interesado");
				$sinexito =$rspta13 + $rspta14;
				
            for($n=0;$n < count($sinexito); $n++){
                
				$id_estudiante = $sinexito[$n]["id_estudiante"];
				$identificacion = $sinexito[$n]["identificacion"];
				$nombre = $sinexito[$n]["nombre"] . " " . $sinexito[$n]["nombre_2"] . " " . $sinexito[$n]["apellidos"] . " " . $sinexito[$n]["apellidos_2"];
				
				$fo_programa = $sinexito[$n]["fo_programa"];
				$jornada = $sinexito[$n]["jornada_e"];
				$fecha_ingreso = $panelcomercial->fechaesp($sinexito[$n]["fecha_ingreso"]);
				$medio = $sinexito[$n]["medio"];
				$conocio = $sinexito[$n]["conocio"];

				$estado = $sinexito[$n]["estado"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								<td>'.$estado.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
					
			break;

			case 2:


				$data[0] ="";

				$data[0] .= 
				'		
				<table id="sinexitotabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>';
				

				$rspta13=$panelcomercial->sinexito($fecha_anterior,"Retirado");
				$rspta14=$panelcomercial->sinexito($fecha_anterior,"No_Interesado");
				$sinexito =$rspta13 + $rspta14;
				
            for($n=0;$n < count($sinexito); $n++){
                
				$id_estudiante = $sinexito[$n]["id_estudiante"];
				$identificacion = $sinexito[$n]["identificacion"];
				$nombre = $sinexito[$n]["nombre"] . " " . $sinexito[$n]["nombre_2"] . " " . $sinexito[$n]["apellidos"] . " " . $sinexito[$n]["apellidos_2"];
				
				$fo_programa = $sinexito[$n]["fo_programa"];
				$jornada = $sinexito[$n]["jornada_e"];
				$fecha_ingreso = $panelcomercial->fechaesp($sinexito[$n]["fecha_ingreso"]);
				$medio = $sinexito[$n]["medio"];
				$conocio = $sinexito[$n]["conocio"];
				$estado = $sinexito[$n]["estado"];
				$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								<td>'.$estado.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;		
			
			case 3:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="sinexitotabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>';
				

				$rspta13=$panelcomercial->sinexitosemana($semana,"Retirado");
				$rspta14=$panelcomercial->sinexitosemana($semana,"No_Interesado");
				$sinexito =$rspta13 + $rspta14;
            for($n=0;$n < count($sinexito); $n++){
                
				$id_estudiante = $sinexito[$n]["id_estudiante"];
				$identificacion = $sinexito[$n]["identificacion"];
				$nombre = $sinexito[$n]["nombre"] . " " . $sinexito[$n]["nombre_2"] . " " . $sinexito[$n]["apellidos"] . " " . $sinexito[$n]["apellidos_2"];
				
				$fo_programa = $sinexito[$n]["fo_programa"];
				$jornada = $sinexito[$n]["jornada_e"];
				$fecha_ingreso = $panelcomercial->fechaesp($sinexito[$n]["fecha_ingreso"]);
				$medio = $sinexito[$n]["medio"];
				$conocio = $sinexito[$n]["conocio"];
				$estado = $sinexito[$n]["estado"];
				// $estado = ($estado == "No_Interesado" and $estado == "Retirado") ?'<span class="badge badge-danger p-1">Retirado</span>' :'<span class="badge badge-success p-1"> No_Interesado</span>';
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								<td>'.$estado.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 4:
				
				$data[0] ="";

				$data[0] .= 
				'		
				<table id="sinexitotabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>';
				

				$rspta13=$panelcomercial->sinexitosemana($mes_actual,"Retirado");
				$rspta14=$panelcomercial->sinexitosemana($mes_actual,"No_Interesado");
				$sinexito =$rspta13 + $rspta14;
				
            for($n=0;$n < count($sinexito); $n++){
                
				$id_estudiante = $sinexito[$n]["id_estudiante"];
				$identificacion = $sinexito[$n]["identificacion"];
				$nombre = $sinexito[$n]["nombre"] . " " . $sinexito[$n]["nombre_2"] . " " . $sinexito[$n]["apellidos"] . " " . $sinexito[$n]["apellidos_2"];
				
				$fo_programa = $sinexito[$n]["fo_programa"];
				$jornada = $sinexito[$n]["jornada_e"];
				$fecha_ingreso = $panelcomercial->fechaesp($sinexito[$n]["fecha_ingreso"]);
				$medio = $sinexito[$n]["medio"];
				$conocio = $sinexito[$n]["conocio"];
				$estado = $sinexito[$n]["estado"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								<td>'.$estado.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			case 5:

				$fecha_inicial=$_GET["fecha_inicial"];
				$fecha_final=$_GET["fecha_final"];

				$data[0] ="";

				$data[0] .= 
				'		
				<table id="sinexitotabla" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Caso</th>
				<th scope="col">Identificación</th>
				<th scope="col">Nombre</th>
				<th scope="col">Programa</th>
				<th scope="col">Jornada</th>
				<th scope="col">Ingreso </th>
				<th scope="col">Medio</th>
				<th scope="col">Conocio</th>
				<th scope="col">Estado</th>
				</tr>
				</thead>
				<tbody>';
				

				$rspta13=$panelcomercial->sinexitoRango($fecha_inicial,$fecha_final,"Retirado");
				$rspta14=$panelcomercial->sinexitoRango($fecha_inicial,$fecha_final,"No_Interesado");
				$sinexito =$rspta13 + $rspta14;
				
			for($n=0;$n < count($sinexito); $n++){
				
				$id_estudiante = $sinexito[$n]["id_estudiante"];
				$identificacion = $sinexito[$n]["identificacion"];
				$nombre = $sinexito[$n]["nombre"] . " " . $sinexito[$n]["nombre_2"] . " " . $sinexito[$n]["apellidos"] . " " . $sinexito[$n]["apellidos_2"];
				
				$fo_programa = $sinexito[$n]["fo_programa"];
				$jornada = $sinexito[$n]["jornada_e"];
				$fecha_ingreso = $panelcomercial->fechaesp($sinexito[$n]["fecha_ingreso"]);
				$medio = $sinexito[$n]["medio"];
				$conocio = $sinexito[$n]["conocio"];
				$estado = $sinexito[$n]["estado"];
					
					$data[0] .= '
						
						
							<tr>
								<th scope="row">'.($n +1).'</th>
								<td>'.$id_estudiante.'</td> 
								<td>'.$identificacion.'</td> 
								<td>'.$nombre.'</td> 
								<td>'.$fo_programa.'</td> 
								<td>'.$jornada.'</td> 
								<td>'.$fecha_ingreso.'</td> 
								<td>'.$medio.'</td> 
								<td>'.$conocio.'</td> 
								<td>'.$estado.'</td> 
								
							</li>
							</tr>';
						
				}
					$data[0].= '
					</tbody>
					</table>';
			break;

			
		}
		
		echo json_encode($data);		
	break;

    case 'listarconversion':

		$data= Array();
        $data["dato1"] ="";

        $rspta1=$panelcomercial->listarInteresado($periodo_campana);
        $rspta2=$panelcomercial->listarOtrosEstados("Preinscrito",$periodo_campana);
        $rspta3=$panelcomercial->listarOtrosEstados("Inscrito",$periodo_campana);
        $rspta4=$panelcomercial->listarOtrosEstados("Seleccionado",$periodo_campana);
        $rspta5=$panelcomercial->listarOtrosEstados("Admitido",$periodo_campana);
        $rspta6=$panelcomercial->listarMatriculado($periodo_campana,"Matriculado");

        $totalinteresados=count($rspta1);
        $totalpreinscritos=count($rspta2);
        $totalinscritos=count($rspta3);
        $totalseleccionado=count($rspta4);
        $totaladmitido=count($rspta5);
        $totalmatriculado=count($rspta6);
        
        // $por_inte_pre=round(($totalpreinscritos*100)/$totalinteresados);
        // $por_pre_insc=round(($totalinscritos*100)/$totalpreinscritos);
        // $por_insc_selec=round(($totalseleccionado*100)/$totalinscritos);
        // $por_selec_admi=round(($totaladmitido*100)/$totalseleccionado);
        // $por_admi_matri=round(($totalmatriculado*100)/$totaladmitido);
		$por_inte_pre = $totalinteresados ? round(($totalpreinscritos * 100) / $totalinteresados) : 0;
		$por_pre_insc = $totalpreinscritos ? round(($totalinscritos * 100) / $totalpreinscritos) : 0;
		$por_insc_selec = $totalinscritos ? round(($totalseleccionado * 100) / $totalinscritos) : 0;
		$por_selec_admi = $totalseleccionado ? round(($totaladmitido * 100) / $totalseleccionado) : 0;
		$por_admi_matri = $totaladmitido ? round(($totalmatriculado * 100) / $totaladmitido) : 0;


		
        $data["dato1"] .='
            <div class="col-12">Campaña Actual: '.$periodo_campana.'</div>
            <div class="col-xl-3">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Interesado/Preinscrito</strong>
                    </p>
                    <div class="progress-group">
                        '.$por_inte_pre.'%
                        <span class="float-right"><b>'.$totalinteresados.'</b>/'.$totalpreinscritos.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-secondary" style="width: '.$por_inte_pre.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';

            $data["dato1"] .='

            <div class="col-xl-2">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Preinscrito/Inscrito</strong>
                    </p>
                    <div class="progress-group">
                    '.$por_pre_insc.'%
                        <span class="float-right"><b>'.$totalpreinscritos.'</b>/'.$totalinscritos.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" style="width: '.$por_pre_insc.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';

            $data["dato1"] .='

            <div class="col-xl-2">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Inscrito/Seleccionado</strong>
                    </p>
                    <div class="progress-group">
                        '. $por_insc_selec.'%
                        <span class="float-right"><b>'.$totalinscritos.'</b>/'.$totalseleccionado.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: '. $por_insc_selec.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';

            $data["dato1"] .='

            <div class="col-xl-2">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Seleccionado/Admitido</strong>
                    </p>
                    <div class="progress-group">
                        '.$por_selec_admi.'%
                        <span class="float-right"><b>'.$totalseleccionado.'</b>/'.$totaladmitido.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: '.$por_selec_admi.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';

            $data["dato1"] .='

            <div class="col-xl-3">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Admitidos/Matriculados</strong>
                    </p>
                    <div class="progress-group">
                    '. $por_admi_matri.'%
                        <span class="float-right"><b>'.$totaladmitido.'</b>/'.$totalmatriculado.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: '. $por_admi_matri.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';


    echo json_encode($data);

	break;

    case 'listarconversioncomparacion':

		$data= Array();
        $data["dato1"] ="";


        $rspta1=$panelcomercial->listarInteresado($periodo_comparado);
        $rspta2=$panelcomercial->listarOtrosEstados("Preinscrito",$periodo_comparado);
        $rspta3=$panelcomercial->listarOtrosEstados("Inscrito",$periodo_comparado);
        $rspta4=$panelcomercial->listarOtrosEstados("Seleccionado",$periodo_comparado);
        $rspta5=$panelcomercial->listarOtrosEstados("Admitido",$periodo_comparado);
        $rspta6=$panelcomercial->listarMatriculado($periodo_comparado,"Matriculado");
		

        $totalinteresados=count($rspta1);
        $totalpreinscritos=count($rspta2);
        $totalinscritos=count($rspta3);
        $totalseleccionado=count($rspta4);
        $totaladmitido=count($rspta5);
        $totalmatriculado=count($rspta6);
        
        // $por_inte_pre=round(($totalpreinscritos*100)/$totalinteresados);
        // $por_pre_insc=round(($totalinscritos*100)/$totalpreinscritos);
        // $por_insc_selec=round(($totalseleccionado*100)/$totalinscritos);
        // $por_selec_admi=round(($totaladmitido*100)/$totalseleccionado);
        // $por_admi_matri=round(($totalmatriculado*100)/$totaladmitido);

		$por_inte_pre = $totalinteresados ? round(($totalpreinscritos * 100) / $totalinteresados) : 0;
		$por_pre_insc = $totalpreinscritos ? round(($totalinscritos * 100) / $totalpreinscritos) : 0;
		$por_insc_selec = $totalinscritos ? round(($totalseleccionado * 100) / $totalinscritos) : 0;
		$por_selec_admi = $totalseleccionado ? round(($totaladmitido * 100) / $totalseleccionado) : 0;
		$por_admi_matri = $totaladmitido ? round(($totalmatriculado * 100) / $totaladmitido) : 0;


        $data["dato1"] .='
            <div class="col-12">Campaña Comparada: '.$periodo_medible.'</div>
            <div class="col-xl-3">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Interesado/Preinscrito</strong>
                    </p>
                    <div class="progress-group">
                        '.$por_inte_pre.'%
                        <span class="float-right"><b>'.$totalinteresados.'</b>/'.$totalpreinscritos.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-secondary" style="width: '.$por_inte_pre.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';

            $data["dato1"] .='

            <div class="col-xl-2">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Preinscrito/Inscrito</strong>
                    </p>
                    <div class="progress-group">
                    '.$por_pre_insc.'%
                        <span class="float-right"><b>'.$totalpreinscritos.'</b>/'.$totalinscritos.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" style="width: '.$por_pre_insc.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';

            $data["dato1"] .='

            <div class="col-xl-2">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Inscrito/Seleccionado</strong>
                    </p>
                    <div class="progress-group">
                        '. $por_insc_selec.'%
                        <span class="float-right"><b>'.$totalinscritos.'</b>/'.$totalseleccionado.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: '. $por_insc_selec.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';

            $data["dato1"] .='

            <div class="col-xl-2">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Seleccionado/Admitido</strong>
                    </p>
                    <div class="progress-group">
                        '.$por_selec_admi.'%
                        <span class="float-right"><b>'.$totalseleccionado.'</b>/'.$totaladmitido.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: '.$por_selec_admi.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';

            $data["dato1"] .='

            <div class="col-xl-3">
                <div class="card p-2">
                    <p class="text-center">
                        <strong>Admitidos/Matriculados</strong>
                    </p>
                    <div class="progress-group">
                    '. $por_admi_matri.'%
                        <span class="float-right"><b>'.$totaladmitido.'</b>/'.$totalmatriculado.'</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: '. $por_admi_matri.'%"></div>
                        </div>
                    </div>
                </div>
            </div>';


    echo json_encode($data);

	break;

}

?>