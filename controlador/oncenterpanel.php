<?php 
session_start();
require_once "../modelos/OncenterPanel.php";

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:s');


$oncenterpanel=new OncenterPanel();
$rsptaperiodo = $oncenterpanel->periodoactual();	
$periodo_campana=$rsptaperiodo["periodo_campana"];
$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];
$periodo_actual=$_SESSION['periodo_actual'];
$id_usuario=$_SESSION['id_usuario'];

/* variables para mover usuario*/
$id_estudiante_mover=isset($_POST["id_estudiante_mover"])? limpiarCadena($_POST["id_estudiante_mover"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$periodo_dos=isset($_POST["periodo_dos"])? limpiarCadena($_POST["periodo_dos"]):"";
/* ********************* */


/* variables agregar sefuimiento */
$id_estudiante_agregar=isset($_POST["id_estudiante_agregar"])? limpiarCadena($_POST["id_estudiante_agregar"]):"";
$motivo_seguimiento=isset($_POST["motivo_seguimiento"])? limpiarCadena($_POST["motivo_seguimiento"]):"";
$mensaje_seguimiento=isset($_POST["mensaje_seguimiento"])? limpiarCadena($_POST["mensaje_seguimiento"]):"";
/* ********************* */

/* variables para programar tarea */
$id_estudiante_tarea=isset($_POST["id_estudiante_tarea"])? limpiarCadena($_POST["id_estudiante_tarea"]):"";
$motivo_tarea=isset($_POST["motivo_tarea"])? limpiarCadena($_POST["motivo_tarea"]):"";
$mensaje_tarea=isset($_POST["mensaje_tarea"])? limpiarCadena($_POST["mensaje_tarea"]):"";
$fecha_programada=isset($_POST["fecha_programada"])? limpiarCadena($_POST["fecha_programada"]):"";
$hora_programada=isset($_POST["hora_programada"])? limpiarCadena($_POST["hora_programada"]):"";
/* ********************* */

//$periodo_campana=$_SESSION['periodo_campana'];
//$periodo_siguiente=$_SESSION['periodo_siguiente'];

switch ($_GET["op"]){
	
	
	case 'listar':
		
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		
		$consulta1=$oncenterpanel->listarestados();// consulta para traer los interesados


		$rsptaperiodo = $oncenterpanel->periodoactual();	
		$periodo_campana=$rsptaperiodo["periodo_campana"];
		//resultado de la campaña actual por el periodo actual.
		$porcentajecampañaactual = $oncenterpanel->CantidadCasosPorCampaña($periodo_campana);
		$periodo_anterior=$rsptaperiodo["periodo_anterior"];
		//resultado de la camapaña anterior por el periodo actual.
		$porcentajecampañaanterior = $oncenterpanel->CantidadCasosPorCampañaAnterior($periodo_anterior);
		
		//tomamos la temporada actual
		$temporada_actual_info = $oncenterpanel->temporadaanterior($periodo_campana);
		// buscamos el total de la temporada actual
		$temporada_actual = $temporada_actual_info["temporada"];
		// le restamos 2 para obtener el año anterior
		$temporada_hace_un_ano = $temporada_actual - 2;
		// filtramos la temporada resultante para hacer la consulta
		$tomar_periodo_anterior = $oncenterpanel->periodoactualtemporada($temporada_hace_un_ano);
		// tomamos el periodo del año anterior para poder hacer la consulta.
		$periodo_hace_un_año = $tomar_periodo_anterior["periodo"];
		// tomamos la cantidad de hace un año.
		$hace_un_año = $oncenterpanel->CantidadCasosPorCampañaUnaño($periodo_hace_un_año);


		
		$valor_actual = count($porcentajecampañaactual);
		$valor_hace_un_ano = count($hace_un_año);
		
		if ($valor_hace_un_ano != 0) {
			$porcentaje_variacion = (($valor_actual - $valor_hace_un_ano) / $valor_hace_un_ano) * 100;
			$porcentaje_variacion = round($porcentaje_variacion, 2);
		} else {
			$porcentaje_variacion = 0;
		}

		if ($porcentaje_variacion > 0) {
			$clase_icono = 'fa-arrow-up';
			$color_texto = 'text-success'; 
		} elseif ($porcentaje_variacion < 0) {
			$clase_icono = 'fa-arrow-down';
			$color_texto = 'text-danger'; 
		} 
			//		$data["0"] .='<div class="well col-lg-3">';
			//			$data["0"] .= 'Campaña Actual <span class="pull-right badge bg-blue">'.count($consulta2).'</span>';
			//		$data["0"] .='</div>';

			$data["0"] .='
				<div class="col-8 pt-1 pb-1 pl-md-4 pl-2" id="t-ea">
					<h5 class="fw-light mb-4 text-secondary pl-md-4 pl-2">Total Tareas,</h5>
					<h1 class="titulo-2 fs-36 pl-md-4 pl-2 text-semibold" title="Casos Periodo Anterior">'.count($porcentajecampañaanterior).'</h1>
					<h5 class="pl-md-4 pl-2 fs-18 text-semibold mb-0">
						<span title="Casos Hace un año">' . count($hace_un_año) . '</span>
						<small class="' . $color_texto . '" style="display:inline-block; margin-left:6px;">
							<span title="Comparación Hace Un Año">' . $porcentaje_variacion . '% <i class="fa-solid ' . $clase_icono .'" aria-hidden="true"></i></span>
							<span class="fs-14 text-muted d-block" title="Periodo Anterior" style="line-height:1;">' . $periodo_anterior . '</span>
						</small>
					</h5>
				</div>

				<div class="col-4">
					<div class="row d-flex flex-row flex-nowrap justify-content-end align-items-start">
						<div class="col-auto text-center me-3" id="t-cp">
							<i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-green text-green rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
							<h4 title="Periodo Actual" class="titulo-2 fs-18 mb-0">'.$periodo_campana.'</h4>
							<p class="small text-secondary">Campaña</p>
						</div>
						<div class="col-auto text-center" id="t-co">
							<i class="fa-solid fa-trophy avatar avatar-50 bg-light-orange text-orange rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
							<h4 title="Casos Periodo Actual" class="titulo-2 fs-18 mb-0">'.count($porcentajecampañaactual).'</h4>
							<p class="small text-secondary">Caso Periodo Actual</p>
						</div>
					</div>
				</div>';
		
	$data["0"] .='<div class="row">';
 		for ($a=0;$a<count($consulta1);$a++){
			$nombre_estado=$consulta1[$a]["nombre_estado"];
			$icono=$consulta1[$a]["icono"];
			$consulta2=$oncenterpanel->listar($periodo_campana,$nombre_estado);// consulta para traer los interesados de la campaña actual

		$data["0"] .='	
			<div class="col-12 col-md-4 m-0 p-2">
				<div class="row p-0 m-0">
					<div class="card col-12 p-0 m-0 tono-3">
						<div class="row p-0 m-0" id="t-eto">

							<div class="col-12 py-3 tono-3 titulo-3">
								<div class="row align-items-center">
									<div class="pl-2">
										<span class="rounded bg-light-success p-2 text-success">
											'.$icono.'
										</span> 
									</div>
									<div class="col-10">
									<div class="col-8 fs-14 line-height-18"> 
										<span class="">Estado</span> <br>
										<span class="text-semibold fs-16">'.$nombre_estado.'</span> 
									</div> 
									</div>
								</div>
							</div>

							<div class="col-12 p-0">
								<ul class="nav flex-column ">

								<li id="t-ca"><a href="#" class="nav-link titulo-3 fs-12" onclick=listarDos("'.$periodo_campana.'","'.$nombre_estado.'") > Campaña Actual <span class="float-right badge bg-primary">'.count($consulta2).'</span> </a>
								</li>

								<li class="nav-item" id="t-cn">
									<div class="row" style="height:50px; padding-top:10px">
									<div class="nav-link col-lg-6">Campañas Anteriores</div>
									<div class="col-lg-6">
										<form action="">
											<select name="periodo_buscar'.$a.'" id="periodo_buscar'.$a.'" class="form-control pull-right" data-live-search="true" onChange=listarDos(this.value,"'.$nombre_estado.'")>		
											</select>
										<form>
									</div>
									</div>
								</li>';
							
									$consulta3=$oncenterpanel->listarmedios();// consulta para traer los estudiantes por medio
									for ($b=0;$b<count($consulta3);$b++){
										$medio=$consulta3[$b]["nombre"];
										$consulta4=$oncenterpanel->listarmedioscantidad($nombre_estado,$medio,$periodo_campana);// cantidad de estudiantes por medio		
										$data["0"] .='
										<li id="t-paso'.$b.'">
											<a href="#" class="nav-link titulo-3 fs-12" onclick="listarTres(`'.$nombre_estado.'`,`'.$medio.'`,`'.$periodo_campana.'`)" > '.$medio.' <span class="float-right badge bg-success">'.count($consulta4).'</span> </a> 
										</li>';
									}
							
							
									$data["0"] .='
								</ul>
							</div>
						</div>

					</div>
				</div>
			</div>
		';

		}
$data["0"] .='</div>';			
 		$results = array($data);
 		echo json_encode($results);

	break;	
		
	case 'listarDos':
		$periodo=$_POST["periodo"];
		$estado=$_POST["estado"];
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		$data["0"] .= '
		
			<div class="col-12">
				<div class="row">
					<div class="col-6 p-4 tono-3">
						<div class="row align-items-center">
							<div class="pl-1">
								<span class="rounded bg-light-blue p-3 text-primary ">
									<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
								</span> 
							
							</div>
							<div class="col-10">
							<div class="col-5 fs-14 line-height-18"> 
								<span class="">Resultados estado</span> <br>
								<span class="text-semibold fs-20">'.$estado.'</span> 
							</div> 
							</div>
						</div>
					</div>
					<div class="col-6 tono-3 pt-3 pr-4">
						<a onClick="volver()" id="volver" class="btn btn-danger float-right text-white"><i class="fas fa-arrow-circle-left"></i> Volver</a>
					</div>
				</div>
			</div>';

			$data["0"] .= '<div class="card col-12">';
		
					$data["0"] .= '<table id="tbllistado" class="table table-hover col-12" width="100%">';
						$data["0"] .= '<thead>';
							$data["0"] .= '<th>Programa</th>';
							$consulta1=$oncenterpanel->listarJornada();// consulta pra lñistar las jornadas en la tabla
								for ($a=0;$a<count($consulta1);$a++){
									$data["0"] .= '<th>'.$consulta1[$a]["nombre"].'</th>';
									
								}		
						$data["0"] .= '<thead>';
						$data["0"] .= '<tbody>';
							
						
						$consulta2=$oncenterpanel->listarPrograma();// consulta para traer los programas activos
						for ($b=0;$b<count($consulta2);$b++){
							$nombre_programa=$consulta2[$b]["nombre"];
							$data["0"] .= '<tr>';
								$data["0"] .= '<td>';
									$data["0"] .= $nombre_programa;
								$data["0"] .= '</td>';
							
								$consulta3=$oncenterpanel->listarJornada();// consulta pra listar el total por jornadas y programa
								for ($c=0;$c<count($consulta3);$c++){
									$jornada=$consulta3[$c]["nombre"];
									$consulta4=$oncenterpanel->listarprogramajornada($nombre_programa,$jornada,$estado,$periodo);	
									$data["0"] .= '<td>';
										$data["0"] .= '<a onclick="verEstudiantes(`'.$nombre_programa.'`,`'.$jornada.'`,`'.$estado.'`,`'.$periodo.'`)" class="btn">'. count($consulta4) . '</a>';
									$data["0"] .= '</td>';
								}					
							$data["0"] .= '</tr>';
						}
						$data["0"] .= '<tr>';
							$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';
					
							$consulta4=$oncenterpanel->listarJornada();// consulta pra listar las sumas de las columnas
								for ($d=0;$d<count($consulta4);$d++){
									$jornadasuma=$consulta4[$d]["nombre"];
									$consulta5=$oncenterpanel->sumaporjornada($jornadasuma,$estado,$periodo);
									$data["0"] .= '<td>';
										$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$estado.'`,`'.$periodo.'`)" class="btn btn-primary btn-sm">'. count($consulta5) . '</a>';
									$data["0"] .= '</td>';
								}
		
		
							$data["0"] .= '</tr>';
						
							$data["0"] .= '</tbody>';
						$data["0"] .= '</table>';
					$data["0"] .= '</div>';
		
			$consulta6=$oncenterpanel->listar($periodo,$estado);// consulta para traer los interesados de la 
			$data["0"] .= '<div class="alert pull-right"><h3>Total General <a onclick="verEstudiantesTotal(`'.$periodo.'`,`'.$estado.'`)" class="btn btn-primary">'.count($consulta6).'</a></h3></div>';

		$results = array($data);
		echo json_encode($results);

	break;

	case 'listarTres':
		
		$estado=$_POST["nombre_estado"];
		$medio=$_POST["medio"];
		$periodo=$_POST["periodo"];
		
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		$data["0"] .= '
		<div class="col-12">
			<div class="row">
				<div class="col-6 p-4 tono-3">
					<div class="row align-items-center">
						<div class="pl-1">
							<span class="rounded bg-light-blue p-3 text-primary ">
								<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
							</span> 
						
						</div>
						<div class="col-10">
						<div class="col-5 fs-14 line-height-18"> 
							<span class="">Resultados estado</span> <br>
							<span class="text-semibold fs-20">'.$estado.'</span> 
						</div> 
						</div>
					</div>
				</div>
				<div class="col-6 tono-3 pt-3 pr-4">
					<a onClick="volver()" id="t2-volt" class="btn btn-danger float-right text-white"><i class="fas fa-arrow-circle-left"></i> Volver</a>
				</div>
			</div>
		</div>';
		$data["0"] .= '<div class="card col-12">';
		$data["0"] .= '<table id="tbllistado" class="table table-hover">';
			$data["0"] .= '<thead>';
				$data["0"] .= '<th id="t2-paso0">Programa</th>';
				$consulta1=$oncenterpanel->listarJornada();// consulta pra lñistar las jornadas en la tabla
				$num_paso=1;
					for ($a=0;$a<count($consulta1);$a++){
						$data["0"] .= '<th id="t2-paso'.$num_paso.'">'.$consulta1[$a]["nombre"].'</th>';
						$num_paso++;
					}		
			$data["0"] .= '<thead>';
			$data["0"] .= '<tbody>';
                 
			
			$consulta2=$oncenterpanel->listarPrograma();// consulta para traer los programas activos
			for ($b=0;$b<count($consulta2);$b++){
				$nombre_programa=$consulta2[$b]["nombre"];
				$data["0"] .= '<tr>';
					$data["0"] .= '<td>';
						$data["0"] .= $nombre_programa;
					$data["0"] .= '</td>';
				
					$consulta3=$oncenterpanel->listarJornada();// consulta pra listar el total por jornadas y programa
					for ($c=0;$c<count($consulta3);$c++){
						$jornada=$consulta3[$c]["nombre"];
						$consulta4=$oncenterpanel->listarprogramamedio($nombre_programa,$jornada,$medio,$estado,$periodo);	
						$data["0"] .= '<td>';
							$data["0"] .= '<a onclick="verEstudiantesmedio(`'.$nombre_programa.'`,`'.$jornada.'`,`'.$medio.'`,`'.$estado.'`,`'.$periodo.'`)" class="btn">'. count($consulta4) . '</a>';
						$data["0"] .= '</td>';
					}					
				$data["0"] .= '</tr>';
			}
			$data["0"] .= '<tr>';
				$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';
		
				$consulta4=$oncenterpanel->listarJornada();// consulta pra listar las sumas de las columnas
					for ($d=0;$d<count($consulta4);$d++){
						$jornadasuma=$consulta4[$d]["nombre"];
						$consulta5=$oncenterpanel->sumapormedio($jornadasuma,$medio,$estado,$periodo);
						$data["0"] .= '<td>';
							$data["0"] .= '<a onclick="verEstudiantesSumaMedio(`'.$jornadasuma.'`,`'.$medio.'`,`'.$estado.'`,`'.$periodo.'`)" class="btn btn-primary btn-sm">'. count($consulta5) . '</a>';
						$data["0"] .= '</td>';
					}
		
		
			
					$data["0"] .= '</tr>';
			
					$data["0"] .= '</tbody>';
				$data["0"] .= '</table>';
			$data["0"] .= '</div>';
		
			$consulta6=$oncenterpanel->listarmedio($medio,$periodo,$estado);// consulta para traer los interesados de la 
			$data["0"] .= '<div class="alert pull-right"><h3>Total General <a onclick="verEstudiantesTotalMedio(`'.$medio.'`,`'.$periodo.'`,`'.$estado.'`)" class="btn btn-primary">'.count($consulta6).'</a></h3></div>';

		$results = array($data);
		echo json_encode($results);

	break;		
		
		
		
		
	case 'verEstudiantes':
		$nombre_programa=$_GET["nombre_programa"];
		$jornada=$_GET["jornada"];
		$estado=$_GET["estado"];
		$periodo=$_GET["periodo"];
		
		$rspta=$oncenterpanel->listarprogramajornada($nombre_programa,$jornada,$estado,$periodo);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
				 <a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
				 <a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
			 </div></div>',
 				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenterpanel->fechaesp($reg[$i]["fecha_ingreso"]),
 				"7"=>$reg[$i]["conocio"],
				"8"=>$reg[$i]["contacto"],
				"9"=>$reg[$i]["medio"],
				"10"=>$reg[$i]["nombre_acudiente"],
				"11"=>$reg[$i]["celular_acudiente"]
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
		
		
	case 'verEstudiantesMedio':
		$nombre_programa=$_GET["nombre_programa"];
		$jornada=$_GET["jornada"];
		$medio=$_GET["medio"];
		$estado=$_GET["estado"];
		$periodo=$_GET["periodo"];
		
		$rspta=$oncenterpanel->listarprogramamedio($nombre_programa,$jornada,$medio,$estado,$periodo);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
				 <a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
				 <a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
			 </div></div>',
 				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenterpanel->fechaesp($reg[$i]["fecha_ingreso"]),
				"7"=>$reg[$i]["conocio"],
				"8"=>$reg[$i]["contacto"],
 				"9"=>$reg[$i]["medio"],
				"10"=>$reg[$i]["medio"],
				"11"=>$reg[$i]["medio"],
				
				
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
		$estado=$_GET["estado"];
		$periodo=$_GET["periodo"];
		
		$rspta=$oncenterpanel->sumaporjornada($jornada,$estado,$periodo);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(

 				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
				 <a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
				 <a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
			 </div></div>',
 				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenterpanel->fechaesp($reg[$i]["fecha_ingreso"]),
 				"7"=>$reg[$i]["conocio"],
				 "8"=>$reg[$i]["contacto"],
				"9"=>$reg[$i]["medio"],
				"10"=>$reg[$i]["ref_familiar"],
				"11"=>$reg[$i]["ref_telefono"]
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
		
		case 'verEstudiantesSumaMedio':
		$jornada=$_GET["jornada"];
		$medio=$_GET["medio"];
		$estado=$_GET["estado"];
		$periodo=$_GET["periodo"];
		
		$rspta=$oncenterpanel->sumapormedio($jornada,$medio,$estado,$periodo);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				
				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
					<a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
					<a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
					</div></div>',
 				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenterpanel->fechaesp($reg[$i]["fecha_ingreso"]),
 				"7"=>$reg[$i]["conocio"],
				"8"=>$reg[$i]["contacto"],
				"9"=>$reg[$i]["medio"],
				"10"=>$reg[$i]["ref_familiar"],
				"11"=>$reg[$i]["ref_telefono"]
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
		$estado=$_GET["estado"];
		$periodo=$_GET["periodo"];
		
		$rspta=$oncenterpanel->listar($periodo,$estado);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
				<a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
				<a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
			</div></div>',
				"1"=>$reg[$i]["id_estudiante"],
			   "2"=>$reg[$i]["identificacion"],
				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
				
				"4"=>$reg[$i]["fo_programa"],
				"5"=>$reg[$i]["jornada_e"],
				"6"=>$oncenterpanel->fechaesp($reg[$i]["fecha_ingreso"]),
				"7"=>$reg[$i]["conocio"],
				"8"=>$reg[$i]["contacto"],
			   "9"=>$reg[$i]["medio"],
			   "10"=>$reg[$i]["ref_familiar"],
			   "11"=>$reg[$i]["ref_telefono"]
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;		
	
		
		
	case 'verEstudiantesTotalMedio':
		$medio=$_GET["medio"];
		$estado=$_GET["estado"];
		$periodo=$_GET["periodo"];
		
		$rspta=$oncenterpanel->listarmedio($medio,$periodo,$estado);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		

		 for ($i=0;$i<count($reg);$i++){
			
			$data[]=array(
			   "0"=>'<div class="fila'.$i.'"><div class="btn-group">
			   <a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
			   <a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
		   </div></div>',
			   "1"=>$reg[$i]["id_estudiante"],
			  "2"=>$reg[$i]["identificacion"],
			   "3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
			   
			   "4"=>$reg[$i]["fo_programa"],
			   "5"=>$reg[$i]["jornada_e"],
			   "6"=>$oncenterpanel->fechaesp($reg[$i]["fecha_ingreso"]),
			   "7"=>$reg[$i]["conocio"],
			   "8"=>$reg[$i]["contacto"],
			  "9"=>$reg[$i]["medio"],
			  "10"=>$reg[$i]["ref_familiar"],
			  "11"=>$reg[$i]["ref_telefono"]
				);
		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	


	case 'verHistorial':
		$id_estudiante=$_POST["id_estudiante"];
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		
		$consulta1=$oncenterpanel->verHistorial($id_estudiante);// consulta para traer los interesados

 		
		$nombre=$consulta1["nombre"];
		$nombre_2=$consulta1["nombre_2"];
		$apellidos=$consulta1["apellidos"];
		$apellidos_2=$consulta1["apellidos_2"];
		$programa=$consulta1["fo_programa"];
		$jornada=$consulta1["jornada_e"];
		$celular=$consulta1["celular"];
		$email=$consulta1["email"];
		$periodo_ingreso=$consulta1["periodo_ingreso"];
		$fecha_ingreso=$consulta1["fecha_ingreso"];
		$hora_ingreso=$consulta1["hora_ingreso"];
		$medio=$consulta1["medio"];
		$conocio=$consulta1["conocio"];
		$contacto=$consulta1["contacto"];
		$modalidad=$consulta1["nombre_modalidad"];
		$estado=$consulta1["estado"];
		$periodo_campana=$consulta1["periodo_campana"];

		$nivel_escolaridad=$consulta1["nivel_escolaridad"];
		$nombre_colegio=$consulta1["nombre_colegio"];
		$fecha_graduacion=$consulta1["fecha_graduacion"];
		$jornada_academico=$consulta1["jornada_academico"];
		$departamento_academico=$consulta1["departamento_academico"];
		$municipio_academico=$consulta1["municipio_academico"];
		$codigo_pruebas=$consulta1["codigo_pruebas"];
		$codigo_saber_pro=$consulta1["codigo_saber_pro"];
		$colegio_articulacion=$consulta1["colegio_articulacion"];
		$grado_articulacion=$consulta1["grado_articulacion"];

		$ref_familiar=$consulta1["ref_familiar"];
		$ref_telefono=$consulta1["ref_telefono"];
			

		$data["0"] .= '

		<div class="row">
	   
			<div class="col-12" id="accordion">
				<div class="card-header tono-4">
					<h4 class="card-title w-100">
					<a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
						<i class="fa-regular fa-address-card bg-light-blue text-primary p-2"></i>
						Datos de Contacto
					</a>
					</h4>
				</div>
				<div id="collapseOne" class="collapse in" data-parent="#accordion" style="">
					<div class="card-body tono-3">

						<div class="row">
							<div class="col-xl-6">
								<dt>Nombre</dt>
								<dd>'. $nombre . ' ' . $nombre_2 . ' ' . $apellidos . ' ' . $apellidos_2 . '</dd>
								<dt>Programa</dt>
								<dd>'.$programa.'</dd>
								<dt>Celular</dt>
								<dd>'.$celular.'</dd>
								<dt>Email</dt>
								<dd>'.$email.'</dd>
								<dt>Fecha de Ingreso</dt>
								<dd>'.$oncenterpanel->fechaesp($fecha_ingreso).' a las '.$hora_ingreso.' del '.$periodo_ingreso.'</dd>
								<dt>Medio</dt>
								<dd>'.$medio.'</dd>
							</div>
								<div class="col-xl-6">							
								<dt>Conocio</dt>
								<dd>'.$conocio.'</dd>
								<dt>Contacto</dt>
								<dd>'.$contacto.'</dd>
								<dt>Modalidad</dt>
								<dd>'.$modalidad.'</dd>
								<dt>Estado</dt>
								<dd>'.$estado.'</dd>
								<dt>Campaña</dt>
								<dd>'.$periodo_campana.'</dd>
								</dl>
							</div>
						</div>

					</div>
				</div>
				<div class="card-header tono-4">
					<h4 class="card-title w-100">
					<a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseTwo">
						<i class="fa-solid fa-school bg-light-blue p-2 text-primary"></i>
						Datos Academicos
					</a>
					</h4>
				</div>
				<div id="collapseTwo" class="collapse" data-parent="#accordion">
					<div class="card-body tono-3">

						<div class="row">
							<div class="col-xl-6">
								<dl class="dl-horizontal">
									<dt>Nivel de Escolaridad</dt>
									<dd>'. $nivel_escolaridad . '</dd>
									<dt>Nombre Colegio</dt>
									<dd>'.$nombre_colegio.'</dd>
									<dt>Fecha Graduacion</dt>
									<dd>'.$fecha_graduacion.'</dd>
									<dt>Jornada Academico</dt>
									<dd>'.$jornada_academico.'</dd>
									<dt>Departamento Academico</dt>
									<dd>'.$departamento_academico.'</dd>
									<dt>Municipio Academico</dt>
									<dd>'.$municipio_academico.'</dd>
								</dl>
							</div>
							<div class="col-xl-6">
								</dl>
									<dt>Codigo Pruebas</dt>
									<dd>'.$codigo_pruebas.'</dd>
									<dt>Codigo Saber Pro</dt>
									<dd>'.$codigo_saber_pro.'</dd>
									<dt>Colegio Articulacion</dt>
									<dd>'.$colegio_articulacion.'</dd>
									<dt>Grado Articulacion</dt>
									<dd>'.$grado_articulacion.'</dd>
									<dt>Campaña</dt>
									<dd>'.$periodo_campana.'</dd>
								</dl>
							</div>
						</div>

					</div>
				</div>
			</div>
	   
		</div>
	';
	
		
		$results = array($data);
 		echo json_encode($results);
	break;


	case 'verHistorialTabla':
		$id_estudiante=$_GET["id_estudiante"];
	
		$rspta=$oncenterpanel->verHistorialTabla($id_estudiante);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			$datoasesor=$oncenterpanel->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
			
 			$data[]=array(
 				"0"=>$reg[$i]["id_estudiante"],
				"1"=>$reg[$i]["motivo_seguimiento"],
				"2"=>$reg[$i]["mensaje_seguimiento"],
 				"3"=>$oncenterpanel->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],			
 				"4"=>$nombre_usuario
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;		
		
	case 'verHistorialTablaTareas':
		$id_estudiante=$_GET["id_estudiante"];
	
		$rspta=$oncenterpanel->verHistorialTablaTareas($id_estudiante);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			$datoasesor=$oncenterpanel->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
			
			$data[]=array(
				"0"=>($reg[$i]["estado"]==1)?'Pendiente':'Realizada',
				"1"=>$reg[$i]["motivo_tarea"],
				"2"=>$reg[$i]["mensaje_tarea"],
				"3"=>$oncenterpanel->fechaesp($reg[$i]["fecha_programada"]) .' a las '. $reg[$i]["hora_programada"],		
				"4"=>$nombre_usuario

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
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		$data["1"] ="";//iniciamos el arreglo
		
		$rspta = $oncenterpanel->selectPeriodo();
		$data["0"] .='<option value="">Seleccionar</option>';
		for ($i=0;$i<count($rspta);$i++)
				{
					$data["0"] .="<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
		$data["1"] .=$i;
		
		$results = array($data);
		echo json_encode($results);
	break;	


	case "selectEstado":	
		$rspta = $oncenterpanel->selectEstado();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre_estado"] . "'>" . $rspta[$i]["nombre_estado"] . "</option>";
				}
	break;
		
	case "selectPeriodoDos":	
		$rspta = $oncenterpanel->selectPeriodo();
		
		
		echo '<option value="'.$periodo_campana.'">'.$periodo_campana.'</option>';
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;	
		
	case 'moverUsuario':

		$rspta=$oncenterpanel->moverUsuario($id_estudiante_mover,$estado,$periodo_dos);
			echo $rspta ? "Usuario Actualizado" : "Usuario no se pudo mover";
		
		if($rspta=="Usuario Actualizado"){// se puede insertar un  seguimiento
			$motivo_seguimiento="Seguimiento";
			$mensaje_seguimiento="Cambio de estado a: ".$estado;
			$rspta2=$oncenterpanel->insertarSeguimiento($id_usuario,$id_estudiante_mover,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora);
		}
		
	break;


	//case 'eliminar':
		//$id_estudiante=$_POST["id_estudiante"];
		//$rspta1=$oncenterpanel->eliminarDatos($id_estudiante);
		//$rspta2=$oncenterpanel->eliminarSeguimiento($id_estudiante);
		//$rspta3=$oncenterpanel->eliminarTareas($id_estudiante);
		//$rspta=$oncenterpanel->eliminar($id_estudiante);
		
		//if($rspta==0){
			//echo "1";
			//$estado="No_interesado";
			//$rspta4=$oncenterpanel->insertarEliminar($id_estudiante,$estado,$fecha,$hora,$id_usuario);
		//}else{
			//echo "0";
		//}

	//break;




}

?>
