<?php 
session_start();
require_once "../modelos/OncenterNoInteresados.php";

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:s');


$oncenternointeresados=new OncenterNoInteresados();
$rsptaperiodo = $oncenternointeresados->periodoactual();	
$periodo_campana=$rsptaperiodo["periodo_campana"];
$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];
$periodo_actual=$_SESSION['periodo_actual'];

//$periodo_campana=$_SESSION['periodo_campana'];
//$periodo_siguiente=$_SESSION['periodo_siguiente'];

$usuario_cargo=$_SESSION['usuario_cargo'];
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

switch ($_GET["op"]){
	
	
	case 'listar':
		
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		
		$consulta1=$oncenternointeresados->listarestados();// consulta para traer los interesados
		
//		$data["0"] .='<div class="well col-lg-3">';
//			$data["0"] .= 'Campaña Actual <span class="pull-right badge bg-blue">'.count($consulta2).'</span>';
//		$data["0"] .='</div>';
		$data["0"] .='<div class="row">';
		
 		for ($a=0;$a<count($consulta1);$a++){
			$nombre_estado=$consulta1[$a]["nombre_estado"];
			$icono=$consulta1[$a]["icono"];
			$consulta2=$oncenternointeresados->listar($periodo_campana,$nombre_estado);// consulta para traer los interesados de la campaña actual
			
		   
		$data["0"] .='	

			<div class="col-4 m-0 p-2">
				<div class="row p-0 m-0" id="t-eto">
					<div class="card col-12 p-0 m-0">
						<div class="row p-0 m-0">
							
							<div class="col-12 py-3 tono-3">
								<div class="row align-items-center">
									<div class="pl-2">
										<span class="rounded bg-light-red p-2 text-danger">
											<i class="fa-solid fa-headset" aria-hidden="true"></i>
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
								<ul class="nav flex-column">
									<li class="nav-item" id="t-ca">
										<a href="#" onclick=listarDos("'.$periodo_campana.'","'.$nombre_estado.'") class="nav-link">
											Campaña Actual  <span class="float-right badge bg-primary">'.count($consulta2).'</span>
										</a>
									</li>
									<li class="nav-item" id="t-cn">
										<div style="height:50px; padding-top:10px">
											<div class="row">
												<div class="nav-link col-lg-6">Campañas Anteriores</div>
												<div class="col-lg-6">
													<form action="">
														<select name="periodo_buscar'.$a.'" id="periodo_buscar'.$a.'" class="form-control pull-right" data-live-search="true" onChange=listarDos(this.value,"'.$nombre_estado.'")>
														</select>
													<form>
												</div>
											</div>
										</div>	
									</li>';

									$consulta3=$oncenternointeresados->listarmedios();// consulta para traer los estudiantes por medio
									for ($b=0;$b<count($consulta3);$b++){
									$medio=$consulta3[$b]["nombre"];
									$consulta4=$oncenternointeresados->listarmedioscantidad($nombre_estado,$medio,$periodo_campana);// cantidad de estudiantes por medio		
									$data["0"] .='
										<li class="nav-item" id="t-paso'.$b.'">
											<a onclick="listarTres(`'.$nombre_estado.'`,`'.$medio.'`,`'.$periodo_campana.'`)" class="nav-link">'.$medio.' <span class="float-right badge bg-green">'.count($consulta4).'</span>
											</a>
										</li>';
									}

									$data["0"] .='  
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>';

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
				
				$data["0"] .= '<table id="tbllistado" class="table table-hover" width="100%">';
					$data["0"] .= '<thead>';
						$data["0"] .= '<th >Programa</th>';
								$consulta1=$oncenternointeresados->listarJornada();// consulta pra lñistar las jornadas en la tabla
								for ($a=0;$a<count($consulta1);$a++){
								$data["0"] .= '<th >'.$consulta1[$a]["nombre"].'</th>';
								
								}		
					$data["0"] .= '</thead>';
					$data["0"] .= '<tbody>';
						
					
						$consulta2=$oncenternointeresados->listarPrograma();// consulta para traer los programas activos
						for ($b=0;$b<count($consulta2);$b++){
							$nombre_programa=$consulta2[$b]["nombre"];
							$data["0"] .= '<tr>';
								$data["0"] .= '<td>';
									$data["0"] .= $nombre_programa;
								$data["0"] .= '</td>';
							
								$consulta3=$oncenternointeresados->listarJornada();// consulta pra listar el total por jornadas y programa
								for ($c=0;$c<count($consulta3);$c++){
									$jornada=$consulta3[$c]["nombre"];
									$consulta4=$oncenternointeresados->listarprogramajornada($nombre_programa,$jornada,$estado,$periodo);	
									$data["0"] .= '<td>';
										$data["0"] .= '<a onclick="verEstudiantes(`'.$nombre_programa.'`,`'.$jornada.'`,`'.$estado.'`,`'.$periodo.'`)" class="btn">'. count($consulta4) . '</a>';
									$data["0"] .= '</td>';
								}					
							$data["0"] .= '</tr>';
						}
							$data["0"] .= '<tr>';
								$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';
				
									$consulta4=$oncenternointeresados->listarJornada();// consulta pra listar las sumas de las columnas
									for ($d=0;$d<count($consulta4);$d++){
										$jornadasuma=$consulta4[$d]["nombre"];
										$consulta5=$oncenternointeresados->sumaporjornada($jornadasuma,$estado,$periodo);
										$data["0"] .= '<td>';
											$data["0"] .= '<a onclick="verEstudiantesSuma(`'.$jornadasuma.'`,`'.$estado.'`,`'.$periodo.'`)" class="btn btn-primary btn-sm">'. count($consulta5) . '</a>';
										$data["0"] .= '</td>';
									}
						
				
							$data["0"] .= '</tr>';
				
					$data["0"] .= '</tbody>';
				$data["0"] .= '</table>';
			$data["0"] .= '</div>';
		
			$consulta6=$oncenternointeresados->listar($periodo,$estado);// consulta para traer los interesados de la 
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
			$data["0"] .= '<table id="tbllistado" class="table table-hover" style="width:100%">';
				$data["0"] .= '<thead>';
					$data["0"] .= '<th id="t2-paso0">Programa</th>';
					$consulta1=$oncenternointeresados->listarJornada();// consulta pra lñistar las jornadas en la tabla
					$num_paso=1;
						for ($a=0;$a<count($consulta1);$a++){
							$data["0"] .= '<th id="t2-paso'.$num_paso.'">'.$consulta1[$a]["nombre"].'</th>';
							$num_paso++;
						}		

				$data["0"] .= '<thead>';
				$data["0"] .= '<tbody>';
					
				
				$consulta2=$oncenternointeresados->listarPrograma();// consulta para traer los programas activos
				for ($b=0;$b<count($consulta2);$b++){
					$nombre_programa=$consulta2[$b]["nombre"];
					$data["0"] .= '<tr>';
						$data["0"] .= '<td>';
							$data["0"] .= $nombre_programa;
						$data["0"] .= '</td>';
					
						$consulta3=$oncenternointeresados->listarJornada();// consulta pra listar el total por jornadas y programa
						for ($c=0;$c<count($consulta3);$c++){
							$jornada=$consulta3[$c]["nombre"];
							$consulta4=$oncenternointeresados->listarprogramamedio($nombre_programa,$jornada,$medio,$estado,$periodo);	
							$data["0"] .= '<td>';
								$data["0"] .= '<a onclick="verEstudiantesmedio(`'.$nombre_programa.'`,`'.$jornada.'`,`'.$medio.'`,`'.$estado.'`,`'.$periodo.'`)" class="btn">'. count($consulta4) . '</a>';
							$data["0"] .= '</td>';
						}					
					$data["0"] .= '</tr>';
				}
				$data["0"] .= '<tr>';
					$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';
			
					$consulta4=$oncenternointeresados->listarJornada();// consulta pra listar las sumas de las columnas
						for ($d=0;$d<count($consulta4);$d++){
							$jornadasuma=$consulta4[$d]["nombre"];
							$consulta5=$oncenternointeresados->sumapormedio($jornadasuma,$medio,$estado,$periodo);
							$data["0"] .= '<td>';
								$data["0"] .= '<a onclick="verEstudiantesSumaMedio(`'.$jornadasuma.'`,`'.$medio.'`,`'.$estado.'`,`'.$periodo.'`)" class="btn btn-primary btn-sm">'. count($consulta5) . '</a>';
							$data["0"] .= '</td>';
						}
			
			
				$data["0"] .= '</tr>';
			
				$data["0"] .= '</tbody>';
			$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		
			$consulta6=$oncenternointeresados->listarmedio($medio,$periodo,$estado);// consulta para traer los interesados de la 
			$data["0"] .= '<div class="alert pull-right"><h3>Total General <a onclick="verEstudiantesTotalMedio(`'.$medio.'`,`'.$periodo.'`,`'.$estado.'`)" class="btn btn-primary">'.count($consulta6).'</a></h3></div>';

		$results = array($data);
		echo json_encode($results);

	break;		
		
		
		
		
	case 'verEstudiantes':
		$nombre_programa=$_GET["nombre_programa"];
		$jornada=$_GET["jornada"];
		$estado=$_GET["estado"];
		$periodo=$_GET["periodo"];
		
		$rspta=$oncenternointeresados->listarprogramajornada($nombre_programa,$jornada,$estado,$periodo);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				
 				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
						<!--<a onclick="eliminar('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
					</div></div>',
				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenternointeresados->fechaesp($reg[$i]["fecha_ingreso"]),
 				"7"=>$reg[$i]["medio"]
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
		
		$rspta=$oncenternointeresados->listarprogramamedio($nombre_programa,$jornada,$medio,$estado,$periodo);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				
				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
						<!--<a onclick="eliminar('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
					</div></div>',
 				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenternointeresados->fechaesp($reg[$i]["fecha_ingreso"]),
 				"7"=>$reg[$i]["medio"]
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
		
		$rspta=$oncenternointeresados->sumaporjornada($jornada,$estado,$periodo);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
						<!--<a onclick="eliminar('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
					</div></div>',
				
 				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenternointeresados->fechaesp($reg[$i]["fecha_ingreso"]),
 				"7"=>$reg[$i]["medio"]
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
		
		$rspta=$oncenternointeresados->sumapormedio($jornada,$medio,$estado,$periodo);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
						<!--<a onclick="eliminar('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
					</div></div>',
 				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenternointeresados->fechaesp($reg[$i]["fecha_ingreso"]),
 				"7"=>$reg[$i]["medio"]
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
		
		$rspta=$oncenternointeresados->listar($periodo,$estado);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
				
				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
						<!--<a onclick="eliminar('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
					</div></div>',
 				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenternointeresados->fechaesp($reg[$i]["fecha_ingreso"]),
 				"7"=>$reg[$i]["medio"]
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
		
		$rspta=$oncenternointeresados->listarmedio($medio,$periodo,$estado);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
			
 			$data[]=array(
				"0"=>'<div class="fila'.$i.'"><div class="btn-group">
						<!--<a onclick="eliminar('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover('.$reg[$i]["id_estudiante"].','.$i.')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial('.$reg[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar('.$reg[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
					</div></div>',
 				"1"=>$reg[$i]["id_estudiante"],
				"2"=>$reg[$i]["identificacion"],
 				"3"=>$reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
 				
 				"4"=>$reg[$i]["fo_programa"],
 				"5"=>$reg[$i]["jornada_e"],
 				"6"=>$oncenternointeresados->fechaesp($reg[$i]["fecha_ingreso"]),
 				"7"=>$reg[$i]["medio"]
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
		
		$rspta = $oncenternointeresados->selectPeriodo();
		
		$data["0"] .='<option value="">Seleccionar</option>';
		for ($i=0;$i<count($rspta);$i++)
				{
					$data["0"] .="<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
		$data["1"] .=$i+10;
		
		$results = array($data);
		echo json_encode($results);
	break;	
		
		
	case "selectEstado":	
		$rspta = $oncenternointeresados->selectEstado();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre_estado"] . "'>" . $rspta[$i]["nombre_estado"] . "</option>";
				}
	break;
		
	case "selectPeriodoDos":	
		$rspta = $oncenternointeresados->selectPeriodo();
		
		
		echo '<option value="'.$periodo_campana.'">'.$periodo_campana.'</option>';
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;	
		
	case 'moverUsuario':

		$rspta=$oncenternointeresados->moverUsuario($id_estudiante_mover,$estado,$periodo_dos);
			echo $rspta ? "Usuario Actualizado" : "Usuario no se pudo mover";
		
		if($rspta=="Usuario Actualizado"){// se puede insertar un  seguimiento
			$motivo_seguimiento="Seguimiento";
			$mensaje_seguimiento="Cambio de estado a: ".$estado;
			$rspta2=$oncenternointeresados->insertarSeguimiento($id_usuario,$id_estudiante_mover,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora);
		}
		
	break;	
		

	case 'verHistorial':
		$id_estudiante=$_POST["id_estudiante"];
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		
		$consulta1=$oncenternointeresados->verHistorial($id_estudiante);// consulta para traer los interesados

 		
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
                                    <dd>'.$oncenternointeresados->fechaesp($fecha_ingreso).' a las '.$hora_ingreso.' del '.$periodo_ingreso.'</dd>
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
	
		$rspta=$oncenternointeresados->verHistorialTabla($id_estudiante);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			$datoasesor=$oncenternointeresados->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
			
 			$data[]=array(
 				"0"=>$reg[$i]["id_estudiante"],
				"1"=>$reg[$i]["motivo_seguimiento"],
				"2"=>$reg[$i]["mensaje_seguimiento"],
 				"3"=>$oncenternointeresados->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],			
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
	
		$rspta=$oncenternointeresados->verHistorialTablaTareas($id_estudiante);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			$datoasesor=$oncenternointeresados->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
			
			$data[]=array(
				"0"=>($reg[$i]["estado"]==1)?'Pendiente':'Realizada',
				"1"=>$reg[$i]["motivo_tarea"],
				"2"=>$reg[$i]["mensaje_tarea"],
				"3"=>$oncenternointeresados->fechaesp($reg[$i]["fecha_programada"]) .' a las '. $reg[$i]["hora_programada"],		
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
			
	//case 'eliminar':
		//$id_estudiante=$_POST["id_estudiante"];
		//$rspta1=$oncenternointeresados->eliminarDatos($id_estudiante);
		//$rspta2=$oncenternointeresados->eliminarSeguimiento($id_estudiante);
		//$rspta3=$oncenternointeresados->eliminarTareas($id_estudiante);
		//$rspta=$oncenternointeresados->eliminar($id_estudiante);
		
		//if($rspta==0){
			//echo "1";
			//$estado="No_interesado";
			//$rspta4=$oncenternointeresados->insertarEliminar($id_estudiante,$estado,$fecha,$hora,$id_usuario);
		//}else{
			//echo "0";
		//}

	//break;
		
		
}

?>
