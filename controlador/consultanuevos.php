<?php 
session_start();
require_once "../modelos/ConsultaNuevos.php";

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:S');


$consultanuevos=new ConsultaNuevos();
$rsptaperiodo = $consultanuevos->periodoactual();	
$periodo_campana=$rsptaperiodo["periodo_campana"];
$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];

//$periodo_campana=$_SESSION['periodo_campana'];
//$periodo_siguiente=$_SESSION['periodo_siguiente'];

switch ($_GET["op"]){

		
	case 'periodo':
		$data= Array();
		$rsptaperiodo = $consultanuevos->periodoactual();
		$periodo_campana=$rsptaperiodo["periodo_campana"];	
        $data["periodo"]=$periodo_campana;

		echo json_encode($data);

	break;
		
	case 'listarDos':
		$periodo=$_POST["periodo"];
		$estado=$_POST["estado"];
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
			$data["0"] .= '<div class="row">';
				$data["0"] .= '<div class="col-12 table-responsive">';
					$data["0"] .= '<table id="tbllistado" class="table table-hover" style="width:100%">';
						$data["0"] .= '<thead>';
							$data["0"] .= '<th>Programa</th>';
							$consulta1=$consultanuevos->listarJornada();// consulta pra listar las jornadas en la tabla
								for ($a=0;$a<count($consulta1);$a++){
									$data["0"] .= '<th>'.$consulta1[$a]["codigo"].'</th>';
								}		
						$data["0"] .= '<thead>';
						$data["0"] .= '<tbody>';
							
						

						$consulta2=$consultanuevos->listarPrograma();// consulta para traer los programas activos
						for ($b=0;$b<count($consulta2);$b++){
							$nombre_programa=$consulta2[$b]["nombre"];
							$data["0"] .= '<tr>';
								$data["0"] .= '<td>';
									$data["0"] .= $nombre_programa;
								$data["0"] .= '</td>';

								$totalconsulta4=0;
							
								$consulta3=$consultanuevos->listarJornada();// consulta pra listar el total por jornadas y programa
								for ($c=0;$c<count($consulta3);$c++){
									$jornada=$consulta3[$c]["nombre"];

									$consulta4=$consultanuevos->listarprogramajornadanuevos($periodo,$jornada,$nombre_programa);// listar estudiantes nuevos
									$consulta4_1=$consultanuevos->listarprogramajornadanuevoshomologaciones($periodo,$jornada,$nombre_programa); // listar estudiantes nuevos homologaciones
									$consulta4_2=$consultanuevos->listarprogramajornadasuma($periodo,$jornada,$nombre_programa); // listar estudiantes nuevos total

								

									$data["0"] .= '<td>';
									// consulta para traer los estudiantes nuevos

										if(count($consulta4)>0){
											
											
											$data["0"] .= '<a onclick="verEstudiantes(`'.$periodo.'`,`'.$jornada.'`,`'.$nombre_programa.'`,1)" class="badge badge-success pointer text-white" style="width:25px"  title="Estudiantes Nuevos">'. count($consulta4) . ' </a>';
										}
										else{
											$data["0"] .= '<a class="btn" style="width:40px"></a>';	
										}

									// consulta para traer los estudiantes nuevos homologados
										
										if(count($consulta4_1)>0){
											$data["0"] .= '<a onclick="verEstudiantes(`'.$periodo.'`,`'.$jornada.'`,`'.$nombre_programa.'`,2)" class="badge badge-primary pointer text-white" style="width:25px" title="Estudiantes nuevos homologados">'. count($consulta4_1) . '</a>';	
										}
										else{
											$data["0"] .= '<a class="btn" style="width:25px"></a>';
										}

									// consulta para traer los estudiantes nuevos total
										
									if(count($consulta4_2)>0){
										$data["0"] .= '=<a onclick="verEstudiantes(`'.$periodo.'`,`'.$jornada.'`,`'.$nombre_programa.'`,3)" class="badge badge-secondary pointer text-white" style="width:25px" title="Total estudiantes">'. count($consulta4_2) . '</a>';	
									}
									else{
										$data["0"] .= '<a class="btn" style="width:25px"></a>';
									}	


										$data["0"] .= '</a>';
									$data["0"] .= '</td>';
								}
								
								

							$data["0"] .= '</tr>';
						}
						
					
						$data["0"] .= '<tr>';
							$data["0"] .= '<td><b>zTotal Estudiantes </b></td>';

							
							
							
								
									
							
							
							$consulta4=$consultanuevos->listarJornada();// consulta pra listar las sumas de las columnas
							
							for ($d=0;$d<count($consulta4);$d++){
								$jornadasuma=$consulta4[$d]["nombre"];

								$totalconsulta5=0;
								$totalconsulta5_1=0;
								$totalconsulta5_2=0;

								$consultasumajornada=$consultanuevos->listarPrograma();// consulta para traer los programas activos
								for ($f=0;$f<count($consultasumajornada);$f++){

									$id_programa_fila=$consultasumajornada[$f]["id_programa"];

								
									$consulta5=$consultanuevos->sumaporjornadanuevos($id_programa_fila,$jornadasuma,$periodo);// consulta para estudiantes nuevos
									$consulta5_1=$consultanuevos->sumaporjornadahomologaciones($id_programa_fila,$jornadasuma,$periodo);// consulta para estudiantes nuevos homologaciones
									$consulta5_2=$consultanuevos->sumaporjornada($id_programa_fila,$jornadasuma,$periodo);// consulta para estudiantes nuevos homologaciones
									
									$totalconsulta5=$totalconsulta5+count($consulta5);
									$totalconsulta5_1=$totalconsulta5_1+count($consulta5_1);
									$totalconsulta5_2=$totalconsulta5_2+count($consulta5_2);

								}

								$data["0"] .= '<td>';
								if($totalconsulta5>0){
									$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo.'`,1)" class="badge badge-success pointer text-white" style="width:25px" title="Estudiantes Nuevos jornada">'. $totalconsulta5 . '</a>';
								}else{
									$data["0"] .= '<a class="btn" style="width:25px"></a>';
								}
								if($totalconsulta5_1>0){
									$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo.'`,2)" class="badge badge-primary pointer text-white" style="width:25px" title="Estudiantes Nuevos homologados jornada">'. $totalconsulta5_1 . '</a>';
								}else{
									$data["0"] .= '<a class="btn" style="width:25px"></a>';
								}
								if($totalconsulta5_2>0){
									$data["0"] .= '=<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo.'`,3)" class="badge badge-secondary pointer text-white" style="width:25px" title="Total Estudiantes Nuevos">'. $totalconsulta5_2 . '</a>';
								}else{
									$data["0"] .= '=<a class="btn" style="width:25px"></a>';
								}
								$data["0"] .= '</td>';


							}
							
							
							

							// $data["0"] .= '<td>';
							// if(count($consulta5)>0){
							// 	$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo.'`,1)" class="btn btn-success btn-sm" style="width:40px" title="Estudiantes Nuevos jornada">'. $totalconsulta5 . '1</a>';
							// }else{
							// 	$data["0"] .= '<a class="btn" style="width:40px"></a>';
							// }
							// if(count($consulta5_1)>0){
							// 	$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo.'`,2)" class="btn btn-primary btn-sm" style="width:40px" title="Estudiantes Nuevos homologados jornada">'. count($consulta5_1) . '2</a>';
							// }else{
							// 	$data["0"] .= '<a class="btn" style="width:40px"></a>';
							// }
							// if(count($consulta5_2)>0){
							// 	$data["0"] .= '=<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo.'`,3)" class="btn btn-secondary btn-sm" style="width:40px" title="Total Estudiantes Nuevos">'. count($consulta5_2) . '3</a>';
							// }else{
							// 	$data["0"] .= '=<a class="btn" style="width:40px"></a>';
							// }
							// $data["0"] .= '</td>';

								

								
					
					
							$data["0"] .= '</tr>';
					
						$data["0"] .= '</tbody>';
					$data["0"] .= '</table>';
				$data["0"] .= '</div>';
			$data["0"] .= '</div>';
	/* **************************************************** */

			$consultatotal6=0;
			$consultatotal6_1=0;
			$consultatotal6_2=0;

			$consultafinal=$consultanuevos->listarPrograma();// consulta para traer los programas activos con la columna estados_nuevos
			for ($e=0;$e<count($consulta2);$e++){
				$id_programa=$consulta2[$e]["id_programa"];

				$consultafloat6=$consultanuevos->listartotalnuevos($id_programa,$periodo);// consulta para traer total interesados nuevos
				$consultafloat6_1=$consultanuevos->listartotalnuevoshomologaciones($id_programa,$periodo);// consulta para traer total homologaciones nuevos
				$consultafloat6_2=$consultanuevos->listartotalnuevostotal($id_programa,$periodo);// consulta para traer total de estudiantes nuevos con homologaciones
				
				$consultatotal6=$consultatotal6+count($consultafloat6);
				$consultatotal6_1=$consultatotal6_1+count($consultafloat6_1);
				$consultatotal6_2=$consultatotal6_2+count($consultafloat6_2);

			}

		
	

			$data["0"] .='
			<div class="row" style="position:fixed; bottom:0px; right:0px; z-index:1; width:auto">';
				$data["0"] .='

					<div class="row tono-1 p-2">
						<div class="col-4">
							<div class="row">
								<div class="col-5 text-center pt-1">
									<i class="fa-solid fa-trophy p-2 bg-light-blue text-primary rounded-circle mb-2 fa-1x"></i>
								</div>
								<div class="col-7">
									<div class="row">
										<div class="col-12 m-0 p-0"><a onclick="verEstudiantesTotal(`'.$periodo.'`,1)" class="btn btn-link p-0 m-0" title="Total Estudiantes Nuevos">'.$consultatotal6.'</a></div>
										<div class="col-12 m-0 p-0"><span class="small text-secondary">Nuevos</span></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-4">
							<div class="row">
								<div class="col-5  text-center pt-1">
									<i class="fa-solid fa-bullhorn p-2 bg-light-orange text-orange rounded-circle mb-2 fa-1x"></i>
								</div>
								<div class="col-7">
									<div class="row">
										<div class="col-12"><a onclick="verEstudiantesTotal(`'.$periodo.'`,2)" class="btn btn-link p-0 m-0" title="Total Estudiantes Nuevos homologaciones">'.$consultatotal6_1.'</a></div>
										<div class="col-12"><span class="small text-secondary">Homo.</span></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-4">
							<div class="row">
								<div class="col-5 text-center pt-1">
									<i class="fa-solid p-2 fa-user-check bg-light-green text-success rounded-circle mb-2 fa-1x"></i>
								</div>
								<div class="col-7">
									<div class="row">
										<div class="col-12"><a onclick="verEstudiantesTotal(`'.$periodo.'`,3)" class="btn btn-link p-0 m-0" title="Total estudiantes">'.$consultatotal6_2.'</a></div>
										<div class="col-12"><span class="small text-secondary">Matri.</span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				';
							
				$data["0"] .='	
			</div>';

		$results = array($data);
		echo json_encode($results);

	break;

		
	case 'verEstudiantes':
		$fo_programa=$_GET["fo_programa"];
		$jornada=$_GET["jornada"];
		$periodo=$_GET["periodo"];
		$estado=$_GET["estado"];
		
		if($estado==1){// si son estudiantes nuevos
			$rspta=$consultanuevos->listarprogramajornadanuevos($periodo,$jornada,$fo_programa);
		}if($estado==2){
			$rspta=$consultanuevos->listarprogramajornadanuevoshomologaciones($periodo,$jornada,$fo_programa);
		}if($estado==3){
			$rspta=$consultanuevos->listarprogramajornadasuma($periodo,$jornada,$fo_programa);
		}
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){

			$id_credencial=$reg[$i]["id_credencial"];

			$datoscredencialestudiante=$consultanuevos->datoscredencialestudiante($id_credencial);
			
 			$data[]=array(
				"0"=>$datoscredencialestudiante["credencial_identificacion"],
 				"1"=>$datoscredencialestudiante["credencial_nombre"] . " " . $datoscredencialestudiante["credencial_nombre_2"] . " " . $datoscredencialestudiante["credencial_apellido"] . " " . $datoscredencialestudiante["credencial_apellido_2"],
 				"2"=>$reg[$i]["fo_programa"],
 				"3"=>$reg[$i]["jornada_e"],
 				"4"=>$reg[$i]["semestre_estudiante"],
				"5"=>$datoscredencialestudiante["credencial_login"],

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
		
		
		
	case 'verEstudiantes':
		$fo_programa = $_GET["fo_programa"];
		$jornada = $_GET["jornada"];
		$periodo = $_GET["periodo"];
		$estado = $_GET["estado"];
		
		if ($estado == 1) { // si son estudiantes nuevos
			$rspta = $consultanuevos->listarprogramajornadanuevos($periodo, $jornada, $fo_programa);
		} elseif ($estado == 2) {
			$rspta = $consultanuevos->listarprogramajornadanuevoshomologaciones($periodo, $jornada, $fo_programa);
		} elseif ($estado == 3) {
			$rspta = $consultanuevos->listarprogramajornadasuma($periodo, $jornada, $fo_programa);
		}
		
		// Vamos a declarar un array
		$data = array();
		$reg = $rspta;
	
		for ($i = 0; $i < count($reg); $i++) {
			$id_credencial = $reg[$i]["id_credencial"];
			$datoscredencialestudiante = $consultanuevos->datoscredencialestudiante($id_credencial);

			$data[] = array(
				"0" => $datoscredencialestudiante["credencial_identificacion"],
				"1" => $datoscredencialestudiante["credencial_nombre"] . " " . $datoscredencialestudiante["credencial_nombre_2"] . " " . $datoscredencialestudiante["credencial_apellido"] . " " . $datoscredencialestudiante["credencial_apellido_2"],
				"2" => $reg[$i]["fo_programa"],
				"3" => $reg[$i]["jornada_e"],
				"4" => $reg[$i]["semestre_estudiante"],
				"5" => $datoscredencialestudiante["credencial_login"],
				"6" => $datoscredencialestudiante["email"],

			);
		}
		$results = array(
			"sEcho" => 1, // Información para el datatables
			"iTotalRecords" => count($data), // enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), // enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
	
		break;

		case 'verEstudiantesTotal':
			$periodo = $_GET["periodo"];
			$estado = $_GET["estado"];
			
			if($estado == 1){
				$rspta = $consultanuevos->listargeneraltotalnuevos($periodo);
			}
			if($estado == 2){
				$rspta = $consultanuevos->listargeneraltotalnuevoshomologaciones($periodo);
			}
			if($estado == 3){
				$rspta = $consultanuevos->listargeneraltotalnuevostotal($periodo);
			}
		
			// Vamos a declarar un array
			$data = Array();
			$reg = $rspta;
		
			for ($i = 0; $i < count($reg); $i++) {
				$id_credencial = $reg[$i]["id_credencial"];
				$datoscredencialestudiante = $consultanuevos->datoscredencialestudiante($id_credencial);
		
				if ($estado == 1) {
					// Verificamos si la fecha de nacimiento existe antes de calcular la edad
					if (!empty($datoscredencialestudiante["fecha_nacimiento"])) {
						$fecha_nacimiento = $datoscredencialestudiante["fecha_nacimiento"];
						$tiempo = strtotime($fecha_nacimiento);
						$ahora = time();
						$edad = ($ahora - $tiempo) / (60 * 60 * 24 * 365.25);
						$edad = floor($edad) . " años"; // Concatenamos "años" a la edad
					} else {
						$edad = "0 años"; // Si no tiene fecha de nacimiento, asignamos "0 años"
					}
				} else {
					$edad = null;
				}
		
				$data[] = array(
					"0" => $datoscredencialestudiante["credencial_identificacion"],
					"1" => $datoscredencialestudiante["credencial_nombre"] . " " . $datoscredencialestudiante["credencial_nombre_2"] . " " . $datoscredencialestudiante["credencial_apellido"] . " " . $datoscredencialestudiante["credencial_apellido_2"],
					"2" => $reg[$i]["fo_programa"],
					"3" => $reg[$i]["jornada_e"],
					"4" => $reg[$i]["semestre_estudiante"],
					"5" => $datoscredencialestudiante["credencial_login"],
					"6" => $datoscredencialestudiante["email"],
					"7" => $edad,
				);
			}
		
			$results = array(
				"sEcho" => 1, // Información para el datatables
				"iTotalRecords" => count($data), // Enviamos el total de registros al datatable
				"iTotalDisplayRecords" => count($data), // Enviamos el total de registros a visualizar
				"aaData" => $data
			);
		
			echo json_encode($results);
			break;
		
		
	
	
    case "selectPeriodo":	
		$rspta = $consultanuevos->selectPeriodo();
        echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;


	case 'configurar':

		$rspta=$consultanuevos->totalprogramas();
		
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){

			$nombre=$reg[$i]["nombre"];
			$estado=$reg[$i]["estado_nuevos"];
			$id_programa=$reg[$i]["id_programa"];

			$boton="";
			if($estado==1){
				$boton="<a onclick='cambioestado($id_programa,0)' class='badge badge-success text-white pointer'>Activado</a>";
			}else{
				$boton="<a onclick='cambioestado($id_programa,1)' class='badge badge-danger text-white pointer'>Bloqueado</a>";
			}

			// $datoscredencialestudiante=$consultanuevos->datoscredencialestudiante($id_credencial);
			
 			$data[]=array(
				"0"=>$nombre,
 				"1"=>$boton,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

	case 'cambioestado':
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		
		$id_programa=$_POST["id_programa"];
		$estado=$_POST["estado"];

		$rspta = $consultanuevos->cambioestado($id_programa,$estado);

		if ($rspta == 0) {
			$data["0"] = "1";
		} else {

			$data["0"] = "0";
		}

		echo json_encode($data);

	break;


}

?>
