<?php 
require_once "../modelos/PropuestaPoa.php";

$propuestapoa=new PropuestaPoa();

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
			$rspta=$propuestapoa->insertar($id_usuario,$compromiso_nombre,$compromiso_fecha,'0','0',$compromiso_valida,$compromiso_periodo);
			echo $rspta ? "compromiso registrado" : "compromiso no se pudo registrar";
		}
		else {
			$rspta=$propuestapoa->editar($id_compromiso,$id_usuario,$compromiso_nombre,$compromiso_fecha,$compromiso_val_admin,$compromiso_val_usuario,$compromiso_valida,$compromiso_periodo);
			echo $rspta ? "compromiso actualizado" : "compromiso no se pudo actualizar";
		}
	break;

		
	case 'guardaryeditarmeta':
		if (empty($id_meta)){
			$rspta=$propuestapoa->insertarmeta($id_compromiso_meta,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo,$corresponsabilidad,$_POST["condicion_institucional"],$_POST["condicion_programa"]);
			echo $rspta ? "meta registrado" : "meta no se pudo registrar";
		}
		else {
			$rspta=$propuestapoa->editarmeta($id_meta,$id_compromiso_meta,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo,$corresponsabilidad,$_POST["condicion_institucional"],$_POST["condicion_programa"]);
			echo $rspta ? "meta actualizada" : "meta no se pudo actualizar";
		}
	break;	

	case 'mostrar':
		$rspta=$propuestapoa->mostrar($id_compromiso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
		
	case 'mostrarmetaeditar':
		$rspta=$propuestapoa->mostrarMetaEditar($id_meta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;	
		
	case 'mostrarmeta':
		$contador=0;
		
		$rsptaperiodo=$propuestapoa->buscarperiodo();
		$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];
		
		
		$rspta=$propuestapoa->mostrarMeta($id_compromiso,$periodo_siguiente);
 		$data= Array();
		$data["0"] ="";
		
		$data["0"] .= '<table class="table table-bordered">';
		
		$reg=$rspta;
		
 		for ($i=0;$i<count($reg);$i++){	
				
			$rsptaeje=$propuestapoa->buscarEjes($reg[$i]["id_eje"]);
			$regeje=count($rsptaeje);
				
				$data["0"] .= '
				<tr id="linea_borrar_'.$contador.'">
					<td width="80px">
					
					<button class="btn btn-warning btn-xs" onclick=mostrarMetaEditar('.$reg[$i]["id_meta"].');numerocompromiso('.$reg[$i]["id_compromiso"].') title="Editar Compromiso"><i class="fas fa-pencil-alt"></i></button>
					
					<button class="btn btn-danger btn-xs" onclick=eliminarMeta('.$reg[$i]["id_meta"].','.$contador.') title="Eliminar Meta"><i class="fas fa-trash-alt"></i></button>
					
					</td>
					<td>
					<i class="fas fa-hands-helping"></i> <b> '.$reg[$i]["meta_nombre"].'</b>
								| <b class="text-success"> '.$regeje[$i]["nombre_ejes"].'</b>
					
					<hr style="margin:0px">
						<i class="far fa-calendar-alt"></i> '.$propuestapoa->fechaesp($reg[$i]["meta_fecha"]).' | 
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
		$rsptaperiodo=$propuestapoa->buscarperiodo();
		$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];
		
		$rspta=$propuestapoa->listarUsuarioPoa();
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";
		$color=array('primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt');
		$abrir="show";
		
		$data["0"] .= '
		
		<div class="panel-body table-responsive" id="listadoregistros">
			<div class="card-body">
				<div id="accordion">
		';
		
		//bg-'.$color[$contador].'//
		$reg=$rspta;
		
 		for ($i=0;$i<count($reg);$i++){	
			
			if($contador==0){
				//$abrir="in"; si queremos que el primer acordeon aparezca abierto
				$abrir="";
			}else{
				$abrir="";
			}
			
	

				$data["0"] .= '
				
				 <div class="card box box-'.$color[$contador].'">
                  <div class="card-header">
                      <h4 class="card-title w-100">
						<button class="btn btn-success btn-sm" id="btnagregar" title="Agregar Compromiso" onclick=mostrarform(true);numerocampo('.$reg[$i]["id_usuario"].',"'.$periodo_siguiente.'")><i class="fa fa-plus-circle"></i> Agregar </button> 

						<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$contador.'" aria-expanded="false" class="collapsed">
							 '.$reg[$i]["usuario_cargo"] .'
						</a>
						<a onclick="imprimir('.$reg[$i]["id_usuario"].')" class="btn bg-orange btn-flat margin float-right"><i class="fas fa-print"></i> Reporte</a>
						
                    </h4>
					
                  </div>
				<div id="collapse'.$contador.'" class="collapse '.$abrir.'" data-parent="#accordion">  

				<div class="box-body">
				<div class="row">
				  
				';
			
			$rsptadatos=$propuestapoa->listarCompromiso($reg[$i]["id_usuario"],$periodo_siguiente);
			$regdatos=$rsptadatos;
			
			for ($j=0;$j<count($regdatos);$j++){	
				
				
			$data["0"] .= '	
				
				<div class="card col-xl-6 col-lg-6 col-md-12 col-12" style="padding-top:5px;">
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
										<button type="button" class="btn btn-disabled btn-xs" title="validado"><i class="fas fa-check"></i> Validado</button>
									';
								}
				
					$data["0"] .= '	
                                        <button type="button" class="btn bg-purple btn-flat btn-xs" onclick=mostrarMeta('.$regdatos[$j]["id_compromiso"].',"'.$regdatos[$j]["compromiso_fecha"].'") title="Agregar metas del Compromiso"><i class="fas fa-flag-checkered"></i> Metas </button>
								
										
										<button class="btn btn-warning btn-xs" onclick="mostrar('.$regdatos[$j]["id_compromiso"].')" title="Editar Compromiso"><i class="fas fa-pencil-alt"></i> Editar</button>
										
										<button class="btn btn-danger btn-xs" onclick="eliminar('.$regdatos[$j]["id_compromiso"].')" title="Eliminar Compromiso"><i class="far fa-trash-alt"></i> Eliminar</button>
										
                                    </p> 
									<h4 style="margin-top: 0">Impacto </h4>
									<p>';
				
									$rsptameta=$propuestapoa->mostrarMeta($regdatos[$j]["id_compromiso"],$periodo_siguiente);
									

									for ($k=0;$k<count($rsptameta);$k++){
										
										$rsptaeje=$propuestapoa->buscarEjes($rsptameta[$k]["id_eje"]);

										$data["0"] .= '<span class="text-primary">'.$rsptaeje["nombre_ejes"].'</span> | ';
									}
				
				
				
				
									$data["0"] .= '	
                                    </p>
                                    <p style="margin-bottom: 0">
                                        <i class="far fa-calendar-alt"></i> '.$propuestapoa->fechaesp($regdatos[$j]["compromiso_fecha"]).'
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

			
			}
			$contador++;
			
			$data["0"] .= '
					</div>
				</div>
			  </div>
			</div>';
			
 		}
		
		$data["0"] .= '
		</div>
				</div>
				<!-- /.box-body -->
			  </div>
		</div>
		';
		
		
 		$results = array($data);
 		echo json_encode($results);

	break;
		
	case 'eliminar':
		$rspta=$propuestapoa->eliminar($id_compromiso);
		
		$rspta2=$propuestapoa->eliminarCompromisoMeta($id_compromiso);

 		echo json_encode($rspta);
	break;
	
	case 'validarcompromiso':
		$rspta=$propuestapoa->validarCompromiso($id_compromiso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;	
		
		
	case 'eliminarmeta':
		$rspta=$propuestapoa->eliminarMeta($id_meta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	
	case "selectEjes":	
		$rspta = $propuestapoa->selectEjes();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_ejes"] . "'>" . $rspta[$i]["nombre_ejes"] . "</option>";
				}
	break;
		
	case "selectPeriodo":	
		$rspta = $propuestapoa->selectPeriodo();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"]. "</option>";
				}
	break;
		
	case "selectListaSiNo":	
	$rspta = $propuestapoa->selectListaSiNo();
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["valor"] . "'>" . $rspta[$i]["nombre_lista"] . "</option>";
			}
	break;
		
	case "selectListarCargo":	
	$rspta = $propuestapoa->selectlistarCargo();
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["usuario_cargo"]. "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
			}
	break;
		
	case "selectListarCorresponsable":	
	$rspta = $propuestapoa->selectlistarCargo();
		echo "<option value='Ninguno'>Ninguno</option>";
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["usuario_cargo"]. "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
			}
	break;	
		
		
		
	case 'imprimir':
		$num=0;
		$contador=0;
		
		$rsptaperiodo=$propuestapoa->buscarperiodo();
		$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];
		
		$id_usuario_reporte=$_POST["id_usuario"];
		$rspta=$propuestapoa->listarImprimir($id_usuario_reporte);
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";
		$data["0"] .= '<h3>' . $rspta["usuario_cargo"] .'</h3>';
		
		$rsptadatos=$propuestapoa->listarCompromiso($id_usuario_reporte,$periodo_siguiente);
			$regdatos=$rsptadatos;
			
			for ($j=0;$j<count($regdatos);$j++){
				
				$data["0"] .= '<i class="fas fa-hands-helping"></i> <b> '.$regdatos[$j]["compromiso_nombre"].'</b><br>
				Compromiso para entregar: '.$propuestapoa->fechaesp($regdatos[$j]["compromiso_fecha"]).'<br><br>
				
				';
				
				$rsptameta=$propuestapoa->mostrarMeta($regdatos[$j]["id_compromiso"],$periodo_siguiente);
									
				$data["0"] .= '<ol>';
									for ($k=0;$k<count($rsptameta);$k++){
										$data["0"] .= '<li><b>'. $rsptameta[$k]["meta_nombre"].'</b>';
										$rsptaeje=$propuestapoa->buscarEjes($rsptameta[$k]["id_eje"]);

										$data["0"] .= '<br>Eje Estratégico: <span class="text-primary">'.$rsptaeje["nombre_ejes"].'</span> <br>
										<b>Fecha de entrega:</b> '.$propuestapoa->fechaesp($rsptameta[$k]["meta_fecha"]).'<br>';
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
	$rspta = $propuestapoa->fechaLimite($id_compromiso);
		
		echo $rspta["compromiso_fecha"];

	break;
	
	case 'condiciones_institucionales':

		$rspta = $propuestapoa->listarCondicionesInstitucionales();

		//Obtener las condiciones asignadas a la meta
		$id=$_GET['id'];
		$marcados = $propuestapoa->listarcondicionesmarcadas($id);
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

		$rspta = $propuestapoa->listarCondicionesprograma();

		//Obtener las condiciones asignadas a la meta
		$id=$_GET['id'];
		$marcados = $propuestapoa->listarcondicionesmarcadasprograma($id);
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