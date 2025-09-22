<?php 
require_once "../modelos/Arquitectura.php";

$arquitectura=new Arquitectura();

$id_compromiso=isset($_POST["id_compromiso"])? limpiarCadena($_POST["id_compromiso"]):"";
$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$compromiso_nombre=isset($_POST["compromiso_nombre"])? limpiarCadena($_POST["compromiso_nombre"]):"";
$compromiso_fecha=isset($_POST["compromiso_fecha"])? limpiarCadena($_POST["compromiso_fecha"]):"";
$compromiso_val_admin=isset($_POST["compromiso_val_admin"])? limpiarCadena($_POST["compromiso_val_admin"]):"";
$compromiso_val_usuario=isset($_POST["compromiso_val_usuario"])? limpiarCadena($_POST["compromiso_val_usuario"]):"";
$compromiso_valida=isset($_POST["compromiso_valida"])? limpiarCadena($_POST["compromiso_valida"]):"";
$compromiso_periodo=isset($_POST["compromiso_periodo"])? limpiarCadena($_POST["compromiso_periodo"]):"";



$id_meta=isset($_POST["id_meta"])? limpiarCadena($_POST["id_meta"]):"";
$id_compromiso_meta=isset($_POST["id_compromiso_meta"])? limpiarCadena($_POST["id_compromiso_meta"]):"";
$id_eje=isset($_POST["meta_ejes"])? limpiarCadena($_POST["meta_ejes"]):"";
$meta_nombre=isset($_POST["meta_nombre"])? limpiarCadena($_POST["meta_nombre"]):"";
$meta_fecha=isset($_POST["meta_fecha"])? limpiarCadena($_POST["meta_fecha"]):"";
$meta_val_admin=isset($_POST["meta_val_admin"])? limpiarCadena($_POST["meta_val_admin"]):"";
$meta_val_usuario=isset($_POST["meta_val_usuario"])? limpiarCadena($_POST["meta_val_usuario"]):"";
$meta_valida=isset($_POST["meta_valida"])? limpiarCadena($_POST["meta_valida"]):"";
$meta_periodo=isset($_POST["meta_periodo"])? limpiarCadena($_POST["meta_periodo"]):"";
$corresponsabilidad=isset($_POST["corresponsabilidad"])? limpiarCadena($_POST["corresponsabilidad"]):"";




switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_compromiso)){
			$rspta=$arquitectura->insertar($id_usuario,$compromiso_nombre,$compromiso_fecha,'0','0',$compromiso_valida,$compromiso_periodo);
			echo $rspta ? "compromiso registrado" : "compromiso no se pudo registrar";
		}
		else {
			$rspta=$arquitectura->editar($id_compromiso,$id_usuario,$compromiso_nombre,$compromiso_fecha,$compromiso_val_admin,$compromiso_val_usuario,$compromiso_valida,$compromiso_periodo);
			echo $rspta ? "compromiso actualizado" : "compromiso no se pudo actualizar";
		}
	break;

		
	case 'guardaryeditarmeta':
		if (empty($id_meta)){
			$rspta=$arquitectura->insertarmeta($id_compromiso_meta,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo,$corresponsabilidad,$_POST["condicion_institucional"],$_POST["condicion_programa"]);
			echo $rspta ? "meta registrado" : "meta no se pudo registrar";
		}
		else {
			$rspta=$arquitectura->editarmeta($id_meta,$id_compromiso_meta,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo,$corresponsabilidad,$_POST["condicion_institucional"],$_POST["condicion_programa"]);
			echo $rspta ? "meta actualizada" : "meta no se pudo actualizar";
		}
	break;	

	case 'mostrar':
		$rspta=$arquitectura->mostrar($id_compromiso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
		
	case 'mostrarmetaeditar':
		$rspta=$arquitectura->mostrarMetaEditar($id_meta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;	
		
	case 'mostrarmeta':
		$contador=0;
		
		$rsptaperiodo=$arquitectura->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		
		
		$rspta=$arquitectura->mostrarMeta($id_compromiso,$periodo_actual);
 		$data= Array();
		$data["0"] ="";
		
		$data["0"] .= '<table class="table table-bordered">';
		
		$reg=$rspta;
		
 		for ($i=0;$i<count($reg);$i++){	
				
			$rsptaeje=$arquitectura->buscarEjes($reg[$i]["id_eje"]);
			$regeje=count($rsptaeje);
				
				$data["0"] .= '
				<tr id="linea_borrar_'.$contador.'">
					<td width="80px">
					
					<button class="btn btn-warning btn-xs" onclick=mostrarMetaEditar('.$reg[$i]["id_meta"].');numerocompromiso('.$reg[$i]["id_compromiso"].') title="Editar Compromiso"><i class="fas fa-pencil-alt"></i></button>
					
					<button class="btn btn-danger btn-xs" onclick=eliminarMeta('.$reg[$i]["id_meta"].','.$contador.') title="Eliminar Meta"><i class="fas fa-trash-alt"></i></button>
					
					</td>
					<td>
					<i class="fas fa-hands-helping"></i> <b> '.$reg[$i]["meta_nombre"].'</b>
								| <b class="text-success"> '.@$regeje[$i]["nombre_ejes"].'</b>
					
					<hr style="margin:0px">
						<i class="far fa-calendar-alt"></i> '.$arquitectura->fechaesp($reg[$i]["meta_fecha"]).' | 
						<i class="fas fa-user-check"></i> '.$reg[$i]["meta_valida"].'
						<b>Corresponsable:</b> '.$reg[$i]["corresponsabilidad"].'
					</td>
				</tr>';
				$contador++;
			}
		$data["0"] .= '</table>';
		
 		$results = array($data);
 		echo json_encode($results);
	break;


		
	case 'listar':
		$num=0;
		$contador=0;
		$data= Array();
		$data["0"] ="";
		
		$rsptaperiodo=$arquitectura->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		
		$jer1=$arquitectura->buscardependencias(1);//consulta para traer las dependencias con jerarquia 1
		
		for ($a=0;$a<count($jer1);$a++){	// bucle para imprimir las dependencias
				$data["0"] .= '<center><span class="well jerarquia">'.$jer1[$a]["usuario_cargo"].'</span></center>';
			
		}
		
//		$data["0"] .= '<center><div class="col-xl-6 col-lg-6 col-md-6 col-6" style="border-right: solid 1px #000; height:80px"></div></center>';
		
		// codigo para el revisor fiscal
		$jer11=$arquitectura->buscardependencias("1.1");//consulta para traer las dependencias con jerarquia 1.1
				for ($a11=0;$a11<count($jer11);$a11++){	// bucle para imprimir las dependencias
					$data["0"] .= '<div class="alert alert-success col-xl-6 col-lg-6 col-md-6 col-12" style="margin-bottom:0px">
									<img src="../files/usuarios/'.$jer11[$a11]["usuario_imagen"].'" class="img-circle" width="50px" height="50px" style="float:left; margin-right:2%">'
											.$jer11[$a11]["usuario_cargo"].
											'<br><button type="button" class="btn btn-default btn-xs" title="Ver Compromisos" onclick=listarcompromisos('.$jer11[$a11]["id_usuario"].',"'.$periodo_actual.'")><i class="fas fa-check"></i> Compromisos</button>
								</div>';
					}
		
	
		
		
		$jer2=$arquitectura->buscardependencias(2);//consulta para traer las dependencias con jerarquia 2
			$data["0"] .= '<center>';
				for ($b=0;$b<count($jer2);$b++){	// bucle para imprimir las dependencias
					$data["0"] .= '<span class="well jerarquia">'.$jer2[$b]["usuario_cargo"].'</span>';
					}
			$data["0"] .= '</center>';
		$data["0"] .= '<center><div class="linea-centro"></div></center>';
		
		
		$data["0"] .= '<center><div class="linea-horizontal"></div></center>';
		
		
			
		$data["0"] .= '<div class="row">';
		
			$data["0"] .= '<div class="col-xl-6 col-lg-6 col-md-6 col-12">';
			$jer3a=$arquitectura->buscardependencias("3a");//consulta para traer las dependencias con jerarquia 3a
				for ($ab=0;$ab<count($jer3a);$ab++){	// bucle para imprimir las dependencias
					$data["0"] .= '<div class="alert alert-success col-lg-12" style="background-color:#d6e2c1!important; ">
									<img src="../files/usuarios/'.$jer3a[$ab]["usuario_imagen"].'" class="img-circle" width="50px" height="50px" style="float:left; margin-right:2%">'
											.$jer3a[$ab]["usuario_cargo"].
											'<br><button type="button" class="btn btn-default btn-xs" title="Ver Compromisos" onclick=listarcompromisos('.$jer3a[$ab]["id_usuario"].',"'.$periodo_actual.'")><i class="fas fa-eye"></i> Compromisos</button>
								</div>';
					}

				
		

		
	
				$jera=$arquitectura->buscardependencias("a");//consulta para traer las dependencias con jerarquia 2
					for ($d=0;$d<count($jera);$d++){	// bucle para imprimir las dependencias
						
						if(strpos($jera[$d]["orden"], '.') !== false){
								$col="col-xl-10 col-lg-10 col-md-10 col-10";
							}
						else{
								$col="col-xl-12 col-lg-12 col-md-12 col-12";
							}
						
						
						$cant_compromisos1=$arquitectura->listarCompromiso($jera[$d]["id_usuario"],$periodo_actual);// Consulta para traer los compromisos
						$total_compromisos1=count($cant_compromisos1);// variable que contiene la cantidad de compromisos
						$progreso1=0;
						$total_metas1=0;
						$total_metas_terminadas1=0;
						
						for ($cant11=0;$cant11<count($cant_compromisos1);$cant11++){	// bucle para mirar la cantidad de metas
							
							$cant_metas1=$arquitectura->mostrarMeta($cant_compromisos1[$cant11]["id_compromiso"],$periodo_actual);// consulta para mirar las metas
							for ($cant21=0;$cant21<count($cant_metas1);$cant21++){//bucle que muetra la cantidad de metas
								$total_metas1++;
								if($cant_metas1[$cant21]["meta_val_usuario"]==1){//condicion para ver cuales metas estan terminadas por el usuario
									$total_metas_terminadas1++;
								}
							}
						
						}
						
						@$progreso1=round(($total_metas_terminadas1*100)/$total_metas1);
						$progreso_porcentaje1=0;
						
						if($progreso1<40){
							$progreso_porcentaje1=$progreso1;
							$barra1="bg-danger";
							$progreso1=100;
						}
						else if($progreso1<60){
							$progreso_porcentaje1=$progreso1;
							$barra1="bg-warning";						
						}
						else if($progreso1<80){
							$progreso_porcentaje1=$progreso1;
							$barra1="";
						}
						else{
							$progreso_porcentaje1=$progreso1;
							$barra1="bg-success";
							
						}
						
						$data["0"] .= '<div class="info-box '.$col.'" style="padding:2%">
							<div class="row col-12">
								<div class="col-xl-2">
										<img src="../files/usuarios/'.$jera[$d]["usuario_imagen"].'" class="img-circle" width="50px" height="50px">
								</div>
								<div class="col-xl-10">
											'.$jera[$d]["usuario_cargo"].'
											<br><button type="button" class="btn btn-default btn-xs" title="Ver Compromisos" onclick=listarcompromisos('.$jera[$d]["id_usuario"].',"'.$periodo_actual.'")><i class="fas fa-eye"></i> Compromisos</button>
								</div>
								<div class="col-xl-12">			
										<br>	
									<div style="overflow: auto; background-color:#F9f9f9; border:solid 1px #fff"> 
											<div class="progress-bar '.$barra1.' progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="'.$progreso1.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$progreso1.'%">
											'.$total_compromisos1. ' Com - '. $total_metas1 .'metas/'.$total_metas_terminadas1.'ok --- '.$progreso_porcentaje1.'%
										  </div>
									 </div>
										
								</div>
											
											
							</div>
						</div>';
						
						}

		$data["0"] .= '</div>';
		

		
		
		$data["0"] .= '<div class="col-xl-6 col-lg-6 col-md-6 col-12">';
		$jer3b=$arquitectura->buscardependencias("3b");//consulta para traer las dependencias con jerarquia 3b
				for ($bb=0;$bb<count($jer3b);$bb++){	// bucle para imprimir las dependencias
					$data["0"] .= '<div class="alert alert-success col-12" style="background-color:#d6e2c1!important; margin-bottom:8px">
									
										<img src="../files/usuarios/'.$jer3b[$bb]["usuario_imagen"].'" class="img-circle" width="50px" height="50px" style="float:left; margin-right:2%">'
									
									
										.$jer3b[$bb]["usuario_cargo"].
										'<br><button type="button" class="btn btn-default btn-xs" title="Ver Compromisos" onclick=listarcompromisos('.$jer3b[$bb]["id_usuario"].',"'.$periodo_actual.'")><i class="fas fa-eye"></i> Compromisos</button>
									
								</div>';
					}
			$data["0"] .= '<center><div class="linea-centro" style="float:none; clear:both"></div></center>';
		$data["0"] .= '<center><div class="linea-centro" style="float:none; clear:both"></div></center>';
		
		$jer4b=$arquitectura->buscardependencias("4b");//consulta para traer las dependencias con jerarquia 3b
				for ($d=0;$d<count($jer4b);$d++){	// bucle para imprimir las dependencias
					
					$data["0"] .= '<div class="alert alert-info col-lg-12" style="background-color:#478dc6!important">
									
										<img src="../files/usuarios/'.$jer4b[$d]["usuario_imagen"].'" class="img-circle" width="50px" height="50px" style="float:left; margin-right:2%">'
									
									
										.$jer4b[$d]["usuario_cargo"].
										'<br><button type="button" class="btn btn-default btn-xs" title="Ver Compromisos" onclick=listarcompromisos('.$jer4b[$d]["id_usuario"].',"'.$periodo_actual.'")><i class="fas fa-eye"></i> Compromisos</button>
									
								</div>';
					}
		
		
				$jerb=$arquitectura->buscardependencias("b");//consulta para traer las dependencias con jerarquia 2
					for ($c=0;$c<count($jerb);$c++){	// bucle para imprimir las dependencias
						if(strpos($jerb[$c]["orden"], '.') !== false){
								$col="col-lg-10 col-md-10 col-sm-10 col-xs-10";
							}
						else{
								$col="col-lg-12 col-md-12 col-sm-12 col-xs-12";
							}
						
						$cant_compromisos=$arquitectura->listarCompromiso($jerb[$c]["id_usuario"],$periodo_actual);// Consulta para traer los compromisos
						$total_compromisos=count($cant_compromisos);// variable que contiene la cantidad de compromisos
						$progreso=0;
						$total_metas=0;
						$total_metas_terminadas=0;
						
						for ($cant1=0;$cant1<count($cant_compromisos);$cant1++){	// bucle para mirar la cantidad de metas
							
							$cant_metas=$arquitectura->mostrarMeta($cant_compromisos[$cant1]["id_compromiso"],$periodo_actual);// consulta para mirar las metas
							for ($cant2=0;$cant2<count($cant_metas);$cant2++){//bucle que muetra la cantidad de metas
								$total_metas++;
								if($cant_metas[$cant2]["meta_val_usuario"]==1){//condicion para ver cuales metas estan terminadas por el usuario
									$total_metas_terminadas++;
								}
							}
						
						}
						
						@$progreso=round(($total_metas_terminadas*100)/$total_metas);
						$progreso_porcentaje=0;
						
						if($progreso<40){
							$progreso_porcentaje=$progreso;
							$barra="bg-danger";
							$progreso=100;
						}
						else if($progreso<60){
							$progreso_porcentaje=$progreso;
							$barra="bg-warning";						
						}
						else if($progreso<80){
							$progreso_porcentaje=$progreso;
							$barra="";
						}
						else{
							$progreso_porcentaje=$progreso;
							$barra="bg-success";
						}
						
						$data["0"] .= '<div class="info-box '.$col.'" style="float:right">
							<div class="row col-12">
								<div class="col-xl-2">
										<img src="../files/usuarios/'.$jerb[$c]["usuario_imagen"].'" class="img-circle" width="50px" height="50px" style="margin-right:2%">
								</div>	
								<div class="col-xl-10">	
									'.$jerb[$c]["usuario_cargo"].'
									<br><button type="button" class="btn btn-default btn-xs" title="Ver Compromisos" onclick=listarcompromisos('.$jerb[$c]["id_usuario"].',"'.$periodo_actual.'")><i class="fas fa-eye"></i> Compromisos</button>
								</div>			
								<div class="col-xl-12">
								<br>
										<div style="overflow: auto; background-color:#f9f9f9; border:solid 1px #fff"> 
											<div class="progress-bar '.$barra.' progress-bar-striped active" role="progressbar" aria-valuenow="'.$progreso.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$progreso.'%">
											'.$total_compromisos. ' Com - '. $total_metas .'metas/'.$total_metas_terminadas.'ok ---'.$progreso_porcentaje.'%
										  	</div>
										 </div>
								</div>		
							</div>	
						</div>';
						
						}

		$data["0"] .= '</div></div>';
		
		
		
		
		
 		$results = array($data);
 		echo json_encode($results);

	break;
		
	case 'listarcompromisos':
		
		$id_usuario=$_POST["id_usuario"];
		$periodo=$_POST["periodo"];
		
		$data= Array();
		$data["0"] ="";
		$rsptadatos=$arquitectura->listarCompromiso($id_usuario,$periodo);
			$regdatos=$rsptadatos;
			
			$data["0"] .= '<div class="row">';			
			for ($j=0;$j<count($regdatos);$j++){	
				
				
			$data["0"] .= '	
			
				<div class="card col-xl-6 col-lg-6 col-md-6 col-12">
                <div class="box box-solid">
                    <div class="box-body">
                        <h4 style="background-color:#f7f7f7; font-size: 14px; text-align: center; padding: 7px 10px; margin-top: 0;">
                            <i class="fas fa-hands-helping"></i> <b> '.$regdatos[$j]["compromiso_nombre"].'</b>
                        </h4>
                        <div class="media">
                            <div class="media-left">
                               
                            </div>
                            <div class="media-body">
                                <div class="clearfix">
                                    <p class="pull-right">';
								if($regdatos[$j]["aprobado"]==0){	
									$data["0"] .= '	
										<button type="button" class="btn btn-success btn-xs" onclick=validarCompromiso('.$regdatos[$j]["id_compromiso"].') title="validar compromiso"><i class="fas fa-check"></i> Validar</button>
									';
								}
								else{
									$data["0"] .= '	
										<button type="button" class="btn btn-success btn-disabled btn-xs" title="validado"><i class="fas fa-check"></i> Validado</button>
									';
								}
				
					$data["0"] .= '	
                                        <button type="button" class="btn bg-purple btn-flat btn-xs" onclick=mostrarMeta('.$regdatos[$j]["id_compromiso"].',"'.$regdatos[$j]["compromiso_fecha"].'") title="Agregar metas del Compromiso"><i class="fas fa-flag-checkered"></i> Metas </button>
								
										
										<button class="btn btn-warning btn-xs " onclick="mostrar('.$regdatos[$j]["id_compromiso"].')" title="Editar Compromiso"><i class="fas fa-pencil-alt"></i> Editar</button>
										
										<button class="btn btn-danger btn-xs " onclick="eliminar('.$regdatos[$j]["id_compromiso"].')" title="Eliminar Compromiso"><i class="far fa-trash-alt"></i> Eliminar</button>
										
                                    </p> 
									<h4 style="margin-top: 0">Impacto </h4>
									<p>';
				
									$rsptameta=$arquitectura->mostrarMeta($regdatos[$j]["id_compromiso"],$periodo);
									

									for ($k=0;$k<count($rsptameta);$k++){
										
										$rsptaeje=$arquitectura->buscarEjes($rsptameta[$k]["id_eje"]);

										$data["0"] .= '<span class="text-primary">'.$rsptaeje["nombre_ejes"].'</span> | ';
									}
				
				
				
				
									$data["0"] .= '	
                                    </p>
                                    <p style="margin-bottom: 0">
                                        <i class="far fa-calendar-alt"></i> '.$arquitectura->fechaesp($regdatos[$j]["compromiso_fecha"]).'
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

			
			}
		
		$results = array($data);
 		echo json_encode($results);
	break;
		
	case 'eliminar':
		$rspta=$arquitectura->eliminar($id_compromiso);
		
		$rspta2=$arquitectura->eliminarCompromisoMeta($id_compromiso);

 		echo json_encode($rspta);
	break;
	
	case 'validarcompromiso':
		$rspta=$arquitectura->validarCompromiso($id_compromiso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;	
		
		
	case 'eliminarmeta':
		$rspta=$arquitectura->eliminarMeta($id_meta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	
	case "selectEjes":	
		$rspta = $arquitectura->selectEjes();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_ejes"] . "'>" . $rspta[$i]["nombre_ejes"] . "</option>";
				}
	break;
		
	case "selectPeriodo":	
		$rspta = $arquitectura->selectPeriodo();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"]. "</option>";
				}
	break;
		
	case "selectListaSiNo":	
	$rspta = $arquitectura->selectListaSiNo();
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["valor"] . "'>" . $rspta[$i]["nombre_lista"] . "</option>";
			}
	break;
		
	case "selectListarCargo":	
	$rspta = $arquitectura->selectlistarCargo();
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["usuario_cargo"]. "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
			}
	break;
		
	case "selectListarCorresponsable":	
	$rspta = $arquitectura->selectlistarCargo();
		echo "<option value='Ninguno'>Ninguno</option>";
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["usuario_cargo"]. "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
			}
	break;	
		
		
		
	case 'imprimir':
		$num=0;
		$contador=0;
		
		$rsptaperiodo=$arquitectura->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		
		$id_usuario_reporte=$_POST["id_usuario"];
		$rspta=$arquitectura->listarImprimir($id_usuario_reporte);
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";
		$data["0"] .= '<h3>' . $rspta["usuario_cargo"] .'</h3>';
		
		$rsptadatos=$arquitectura->listarCompromiso($id_usuario_reporte,$periodo_actual);
			$regdatos=$rsptadatos;
			
			for ($j=0;$j<count($regdatos);$j++){
				
				$data["0"] .= '<i class="fas fa-hands-helping"></i> <b> '.$regdatos[$j]["compromiso_nombre"].'</b><br>
				Compromiso para entregar: '.$arquitectura->fechaesp($regdatos[$j]["compromiso_fecha"]).'<br><br>
				
				';
				
				$rsptameta=$arquitectura->mostrarMeta($regdatos[$j]["id_compromiso"],$periodo_actual);
									
				$data["0"] .= '<ol>';
									for ($k=0;$k<count($rsptameta);$k++){
										$data["0"] .= '<li><b>'. $rsptameta[$k]["meta_nombre"].'</b>';
										$rsptaeje=$arquitectura->buscarEjes($rsptameta[$k]["id_eje"]);

										$data["0"] .= '<br>Eje Estratégico: <span class="text-primary">'.$rsptaeje["nombre_ejes"].'</span> <br>
										<b>Fecha de entrega:</b> '.$arquitectura->fechaesp($rsptameta[$k]["meta_fecha"]).'<br>';
										if($rsptameta[$k]["meta_val_usuario"]==0){
											$valor_val_usuario="No";
										}
										else{
											$valor_val_usuario="Si";
										}
										if($rsptameta[$k]["meta_val_admin"]==0){
											$valor_val_admin="No";
										}
										else{
											$valor_val_admin="Si";
										}
										
										$data["0"] .= '
										Meta cumplida por dependencia: '.$valor_val_usuario.'<br>
										Meta validada por experto: '.$valor_val_admin.'
										
										</li> ';
									}
				$data["0"] .= '</ol>';
			}
				

		
 		$results = array($data);
 		echo json_encode($results);

	break;	
		
		
	case "fechaLimite":	
	$rspta = $arquitectura->fechaLimite($id_compromiso);
		
		echo $rspta["compromiso_fecha"];

	break;
		
	case 'condiciones_institucionales':

		$rspta = $arquitectura->listarCondicionesInstitucionales();

		//Obtener las condiciones asignadas a la meta
		$id=$_GET['id'];
		$marcados = $arquitectura->listarcondicionesmarcadas($id);
		//Declaramos el array para almacenar todos las condiciones marcados
		$valores=array();

		
				$i = 0;
					while ($i < count($marcados)){
						array_push($valores, $marcados[$i]["condicion_institucional"]);
						$i++;
					}

//		Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
		$j=0;
		
		while ($j < count($rspta))
				{

					$sw=in_array($rspta[$j]["id_condicion_institucional"],$valores)?'checked':'';
					echo '<li> <input type="checkbox" '.$sw.' name="condicion_institucional[]" value="'.$rspta[$j]["id_condicion_institucional"].'">'.$rspta[$j]["nombre_condicion"].'</li>';
		$j++;
				}
	
	break;
		
	case 'condiciones_programa':

		$rspta = $arquitectura->listarCondicionesPrograma();

		//Obtener las condiciones asignadas a la meta
		$id=$_GET['id'];
		$marcados = $arquitectura->listarcondicionesmarcadasprograma($id);
		//Declaramos el array para almacenar todos las condiciones marcados
		$valores=array();

		
				$i = 0;
					while ($i < count($marcados)){
						array_push($valores, $marcados[$i]["condicion_programa"]);
						$i++;
					}

//		Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
		$j=0;
		
		while ($j < count($rspta))
				{

					$sw=in_array($rspta[$j]["id_condicion_programa"],$valores)?'checked':'';
					echo '<li> <input type="checkbox" '.$sw.' name="condicion_programa[]" value="'.$rspta[$j]["id_condicion_programa"].'">'.$rspta[$j]["nombre_condicion"].'</li>';
		$j++;
				}
	
	break;
	
		
}
?>