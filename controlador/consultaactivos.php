<?php 
session_start();
require_once "../modelos/ConsultaActivos.php";

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:S');


$consultaactivos=new ConsultaActivos();
$rsptaperiodo = $consultaactivos->periodoactual();	
$periodo_actual=$rsptaperiodo["periodo_actual"];
$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];

//$periodo_campana=$_SESSION['periodo_campana'];
//$periodo_siguiente=$_SESSION['periodo_siguiente'];

switch ($_GET["op"]){
	case 'configurar':

		$rspta=$consultaactivos->totalprogramas();
		
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){

			$nombre=$reg[$i]["nombre"];
			$estado=$reg[$i]["estado_activos"];
			$id_programa=$reg[$i]["id_programa"];

			$boton="";
			if($estado==1){
				$boton="<a onclick='cambioestado($id_programa,0)' class='btn btn-success btn-xs'>Activado</a>";
			}else{
				$boton="<a onclick='cambioestado($id_programa,1)' class='btn btn-danger btn-xs'>Bloqueado</a>";
			}

			// $datoscredencialestudiante=$consultaactivos->datoscredencialestudiante($id_credencial);
			
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

		$rspta = $consultaactivos->cambioestado($id_programa,$estado);

		if ($rspta == 0) {
			$data["0"] = "1";
		} else {

			$data["0"] = "0";
		}

		echo json_encode($data);

	break;

		
	case 'listarActivos':

		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo

		$data["0"] .= '<div class="table-responsive">';
			$data["0"] .= '<table id="tbllistado" class="table table-hover" style="width:100%">';
				$data["0"] .= '<thead>';
					$data["0"] .= '<th>Programa</th>';
					$consulta1=$consultaactivos->listarJornada();// consulta pra listar las jornadas en la tabla
						for ($a=0;$a<count($consulta1);$a++){
							$data["0"] .= '<th>'.$consulta1[$a]["codigo"].'</th>';
						}		
				$data["0"] .= '<thead>';
				$data["0"] .= '<tbody>';
					
				
					$consulta2=$consultaactivos->listarPrograma();// consulta para traer los programas activos
					for ($b=0;$b<count($consulta2);$b++){
						$nombre_programa=$consulta2[$b]["nombre"];
						$data["0"] .= '<tr>';
							$data["0"] .= '<td>';
								$data["0"] .= $nombre_programa;
							$data["0"] .= '</td>';
						
							$consulta3=$consultaactivos->listarJornada();// consulta pra listar el total por jornadas y programa
							for ($c=0;$c<count($consulta3);$c++){
								$jornada=$consulta3[$c]["nombre"];
								$consulta4=$consultaactivos->listarprogramajornadanuevos($periodo_actual,$jornada,$nombre_programa);// consulta estuidantes nuevos	
								$consulta4_1=$consultaactivos->listarprogramajornadanuevoshomologados($periodo_actual,$jornada,$nombre_programa);// consulta estuidantes nuevos	 homologación
								$consulta4_2=$consultaactivos->listarprogramajornadarematricula($periodo_actual,$jornada,$nombre_programa);// consulta estuidantes rematricula	
								$consulta4_3=$consultaactivos->listarprogramajornada($periodo_actual,$jornada,$nombre_programa);// consulta estudiantes total por programa
								$consulta4_4=$consultaactivos->listarprogramajornadanuevosinterno($periodo_actual,$jornada,$nombre_programa);// consulta estudiantes total por programa
								
								$data["0"] .= '<td>';
									$data["0"] .= '<div class="btn-group">';
										if(count($consulta4)>0){
											$data["0"] .= '<a onclick="verEstudiantes(`'.$periodo_actual.'`,`'.$jornada.'`,`'.$nombre_programa.'`,1)" class="badge badge-success text-white pointer" title="Estudiantes nuevos" style="width:25px">'. count($consulta4) . '</a>';
										}else{
											$data["0"] .= '<a class="btn" style="width:25px"></a>';
										}

										if(count($consulta4_1)>0){
											$data["0"] .= '<a onclick="verEstudiantes(`'.$periodo_actual.'`,`'.$jornada.'`,`'.$nombre_programa.'`,2)" class="badge badge-primary text-white pointer" title="Estudiantes nuevos homologados" style="width:25px">'. count($consulta4_1) . '</a>';
										}else{
											$data["0"] .= '<a class="btn" style="width:25px"></a>';
										}

										//  enlace para ver los estudiantes nuevos que no pasaron por admisiones
										if(count($consulta4_4)>0){
											$data["0"] .= '<a onclick="verEstudiantes(`'.$periodo_actual.'`,`'.$jornada.'`,`'.$nombre_programa.'`,5)" class="badge badge-info text-white pointer" title="Estudiantes nuevos interno" style="width:25px">'. count($consulta4_4) . '</a>';
										}else{
											$data["0"] .= '<a class="btn" style="width:25px"></a>';
										}
										/* **************************** */

										if(count($consulta4_2)>0){
											$data["0"] .= '<a onclick="verEstudiantes(`'.$periodo_actual.'`,`'.$jornada.'`,`'.$nombre_programa.'`,3)" class="badge badge-warning text-white pointer" title="Estudiantes rematriculados" style="width:25px">'. count($consulta4_2) . '</a>';
										}else{
											$data["0"] .= '<a class="btn" style="width:25px"></a>';
										}

										if(count($consulta4_3)>0){
											$data["0"] .= '<a onclick="verEstudiantes(`'.$periodo_actual.'`,`'.$jornada.'`,`'.$nombre_programa.'`,4)" class="badge badge-secondary text-white pointer" title="Estudiantes activos" style="width:50px">='. count($consulta4_3) . '</a>';
										}else{
											$data["0"] .= '<a class="btn" style="width:25px"></a>';
										}	
									$data["0"] .= '</div>';
									


								$data["0"] .= '</td>';
							}					
						$data["0"] .= '</tr>';
					}
					$data["0"] .= '<tr>';
						$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';
				
						$consulta4=$consultaactivos->listarJornada();// consulta pra listar las sumas de las columnas
							for ($d=0;$d<count($consulta4);$d++){
								$jornadasuma=$consulta4[$d]["nombre"];
								$consulta5=$consultaactivos->sumaporjornadanuevos($jornadasuma,$periodo_actual);// consulta suma estuidantes nuevos por jornada
								$consulta5_1=$consultaactivos->sumaporjornadanuevoshomologados($jornadasuma,$periodo_actual);// consulta suma estudiantes nuevos por jornada homologados
								$consulta5_2=$consultaactivos->sumaporjornadarematricula($jornadasuma,$periodo_actual);// consulta suma estudiantes rematricula
								$consulta5_3=$consultaactivos->sumaporjornada($jornadasuma,$periodo_actual);// consulta suma estudiantes rematricula
								$consulta5_4=$consultaactivos->sumaporjornadanuevosinterno($jornadasuma,$periodo_actual);// consulta suma estudiantes nuevos interno

								$data["0"] .= '<td>';
									$data["0"] .= '<div class="btn-group">';
										$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo_actual.'`,1)" class="badge badge-success text-white pointer" title="Estudiantes nuevos" style="width:25px">'. count($consulta5) . '</a>';
										$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo_actual.'`,2)" class="badge badge-primary text-white pointer" title="Estudiantes nuevos homologados" style="width:25px">'. count($consulta5_1) . '</a>';
										$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo_actual.'`,5)" class="badge badge-info text-white pointer" title="Estudiantes nuevos internos" style="width:25px">'. count($consulta5_4) . '</a>';
										$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo_actual.'`,3)" class="badge badge-warning text-white pointer" title="Estudiantes rematriculados" style="width:25px">'. count($consulta5_2) . '</a>';
										$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$periodo_actual.'`,4)" class="badge badge-secondary text-white pointer" title="Estudiantes activos" style="width:50px">='. count($consulta5_3) . '</a>';
									$data["0"] .= '</div>';
								$data["0"] .= '</td>';
							}
				
				
					$data["0"] .= '</tr>';
			
				$data["0"] .= '</tbody>';
			$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		
			$consulta6=$consultaactivos->listarnuevos($periodo_actual);// consulta para traer los estudiantes nuevos
			$consulta6_1=$consultaactivos->listarnuevoshomologados($periodo_actual);// consulta para traer los interesados de la
			$consulta6_2=$consultaactivos->listarrematriculas($periodo_actual);// consulta para traer los rematriculados
			$consulta6_3=$consultaactivos->listar($periodo_actual);// consulta para traer todos los activos
			$consulta6_4=$consultaactivos->listarnuevosinterno($periodo_actual);// consulta para traer nuevos interno


				$data["0"] .='<div class="row" style="position:fixed; bottom:0px; right:0px; z-index:1">';
				




				$data["0"] .='
							<div class="tono-1">
								<div class="card-body p-0">
									<table class="table table-sm">
										<thead>
											<tr>
												<th>Nuevos</th>
												<th>Homologados</th>
												<th>Internos</th>
												<th>Renovación</th>
												<th style="width: 40px">Total</th>
											</tr>
										</thead>
										<tbody>
											<tr class="text-center">
												<td>
													<a onclick="verEstudiantesTotal(`'.$periodo_actual.'`,1)" class="btn btn-success text-white" title="Total Estudiantes nuevos">'.count($consulta6).'</a>
												</td>
												<td>
													<a onclick="verEstudiantesTotal(`'.$periodo_actual.'`,2)" class="btn btn-primary text-white" title="Total Estudiantes nuevos homologaciones">'.count($consulta6_1).'</a>
												</td>
												<td>
												<a onclick="verEstudiantesTotal(`'.$periodo_actual.'`,5)" class="btn btn-info text-white" title="Total Estudiantes nuevos interno">'.count($consulta6_4).'</a>
												</td>
												<td>
													<a onclick="verEstudiantesTotal(`'.$periodo_actual.'`,3)" class="btn btn-warning text-white" title="Total Estudiantes rematriculados">'.count($consulta6_2).'</a>
												</td>
												<td>
													<a onclick="verEstudiantesTotal(`'.$periodo_actual.'`,4)" class="btn btn-secondary text-white" title="Total Estudiantes total activos">'.count($consulta6_3).'</a>
												</td>
											</tr>
									
										</tbody>
									</table>
								</div>
							</div>';
								
					$data["0"] .='	</div>';

		$results = array($data);
		echo json_encode($results);

	break;

		
		
		
		
		
	case 'verEstudiantes':
		$fo_programa=$_GET["fo_programa"];
		$jornada=$_GET["jornada"];
		$periodo=$_GET["periodo"];
		$estado=$_GET["estado"];
		
		if($estado==1){
			$rspta=$consultaactivos->listarprogramajornadanuevos($periodo,$jornada,$fo_programa);
		}
		if($estado==2){
			$rspta=$consultaactivos->listarprogramajornadanuevoshomologados($periodo,$jornada,$fo_programa);
		}
		if($estado==3){
			$rspta=$consultaactivos->listarprogramajornadarematricula($periodo,$jornada,$fo_programa);
		}

		if($estado==4){
			$rspta=$consultaactivos->listarprogramajornada($periodo,$jornada,$fo_programa);
		}
		if($estado==5){
			$rspta=$consultaactivos->listarprogramajornadanuevosinterno($periodo,$jornada,$fo_programa);
		}
		
		
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){

			$id_credencial=$reg[$i]["id_credencial"];

			$datoscredencialestudiante=$consultaactivos->datoscredencialestudiante($id_credencial);
			
 			$data[]=array(
				"0"=>$datoscredencialestudiante["credencial_identificacion"],
 				"1"=>$datoscredencialestudiante["credencial_nombre"],
				"2"=>$datoscredencialestudiante["credencial_nombre_2"],
				"3"=>$datoscredencialestudiante["credencial_apellido"],
				"4"=>$datoscredencialestudiante["credencial_apellido_2"],
 				"5"=>$reg[$i]["fo_programa"],
 				"6"=>$reg[$i]["jornada_e"],
 				"7"=>$reg[$i]["semestre_estudiante"],
				"8"=>$datoscredencialestudiante["credencial_login"],
				"9"=>$datoscredencialestudiante["celular"],
				"10"=>$datoscredencialestudiante["muni_residencia"] . ' ' . $datoscredencialestudiante["direccion"] . ' ' . $datoscredencialestudiante["barrio"],

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
		
		
	
		
	case 'verEstudiantesSuma':
		$jornada=$_GET["jornada"];
		$periodo=$_GET["periodo"];
		$estado=$_GET["estado"];

		if($estado==1){
			$rspta=$consultaactivos->sumaporjornadanuevos($jornada,$periodo);
		}
		if($estado==2){
			$rspta=$consultaactivos->sumaporjornadanuevoshomologados($jornada,$periodo);
		}
		if($estado==3){
			$rspta=$consultaactivos->sumaporjornadarematricula($jornada,$periodo);
		}
		if($estado==4){
			$rspta=$consultaactivos->sumaporjornada($jornada,$periodo);
		}

		if($estado==5){
			$rspta=$consultaactivos->sumaporjornadanuevosinterno($jornada,$periodo);
		}
			

 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){

			$id_credencial=$reg[$i]["id_credencial"];
			$datoscredencialestudiante=$consultaactivos->datoscredencialestudiante($id_credencial);
			
			$data[]=array(
				"0"=>$datoscredencialestudiante["credencial_identificacion"],
 				"1"=>$datoscredencialestudiante["credencial_nombre"],
				"2"=>$datoscredencialestudiante["credencial_nombre_2"],
				"3"=>$datoscredencialestudiante["credencial_apellido"],
				"4"=>$datoscredencialestudiante["credencial_apellido_2"],
 				"5"=>$reg[$i]["fo_programa"],
 				"6"=>$reg[$i]["jornada_e"],
 				"7"=>$reg[$i]["semestre_estudiante"],
				"8"=>$datoscredencialestudiante["credencial_login"],
				"9"=>$datoscredencialestudiante["celular"],
				"10"=>$datoscredencialestudiante["muni_residencia"] . ' ' . $datoscredencialestudiante["direccion"] . ' ' . $datoscredencialestudiante["barrio"],
				

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

		
	case 'verEstudiantesTotal':
		$periodo=$_GET["periodo"];
		$estado=$_GET["estado"];

		if($estado==1){
			$rspta=$consultaactivos->listarnuevos($periodo_actual);// consulta para traer los estudiantes nuevos
		}
		if($estado==2){
			$rspta=$consultaactivos->listarnuevoshomologados($periodo_actual);// consulta para traer los interesados de la
		}
		if($estado==3){
			$rspta=$consultaactivos->listarrematriculas($periodo_actual);// consulta para traer los rematriculados
		}
		if($estado==4){
			$rspta=$consultaactivos->listar($periodo);// consulta para traer todos los activos
		}
		if($estado==5){
			$rspta=$consultaactivos->listarnuevosinterno($periodo);// consulta para traer todos los activos
		}
		
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
		for ($i=0;$i<count($reg);$i++){

			$id_credencial=$reg[$i]["id_credencial"];

			$datoscredencialestudiante=$consultaactivos->datoscredencialestudiante($id_credencial);
			
 			$data[]=array(
				"0"=>$datoscredencialestudiante["credencial_identificacion"],
 				"1"=>$datoscredencialestudiante["credencial_nombre"],
				"2"=>$datoscredencialestudiante["credencial_nombre_2"],
				"3"=>$datoscredencialestudiante["credencial_apellido"],
				"4"=>$datoscredencialestudiante["credencial_apellido_2"],
 				"5"=>$reg[$i]["fo_programa"],
 				"6"=>$reg[$i]["jornada_e"],
 				"7"=>$reg[$i]["semestre_estudiante"],
				"8"=>$datoscredencialestudiante["credencial_login"],
				"9"=>$datoscredencialestudiante["celular"],
				"10"=>$datoscredencialestudiante["muni_residencia"],
				"11"=> $datoscredencialestudiante["direccion"] . ' ' . $datoscredencialestudiante["barrio"],
				"12"=>$datoscredencialestudiante["fecha_nacimiento"],
				"13"=>$datoscredencialestudiante["genero"],
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;		
	
		
		
		
    
    case "selectPeriodo":	
		$rspta = $consultaactivos->selectPeriodo();
        echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;
}

?>
