<?php 
require_once "../modelos/SacCompromiso.php";
$sac_compromiso = new SacCompromiso();
//$id_eje, $nombre_compromiso, $fecha_compromiso, $compromiso_val_admin, $compromiso_val_usuario, $resposable_compromiso
$id_compromiso=isset($_POST["id_compromiso"])? limpiarCadena($_POST["id_compromiso"]):"";
$id_eje =isset($_POST["id_eje"])? limpiarCadena($_POST["id_eje"]):"";
$nombre_compromiso=isset($_POST["nombre_compromiso"])? limpiarCadena($_POST["nombre_compromiso"]):"";
$fecha_compromiso=isset($_POST["fecha_compromiso"])? limpiarCadena($_POST["fecha_compromiso"]):"";
$compromiso_val_admin=isset($_POST["compromiso_val_admin"])? limpiarCadena($_POST["compromiso_val_admin"]):"";
$compromiso_val_usuario=isset($_POST["compromiso_val_usuario"])? limpiarCadena($_POST["compromiso_val_usuario"]):"";
$resposable_compromiso=isset($_POST["resposable_compromiso"])? limpiarCadena($_POST["resposable_compromiso"]):"";
$id_meta=isset($_POST["id_meta"])? limpiarCadena($_POST["id_meta"]):"";
$id_compromiso=isset($_POST["id_compromiso_meta"])? limpiarCadena($_POST["id_compromiso_meta"]):"";
$id_eje=isset($_POST["id_eje"])? limpiarCadena($_POST["id_eje"]):"";
$meta_nombre=isset($_POST["nombre_meta"])? limpiarCadena($_POST["nombre_meta"]):"";
$meta_fecha=isset($_POST["meta_fecha"])? limpiarCadena($_POST["meta_fecha"]):"";
$meta_val_admin=isset($_POST["meta_val_admin"])? limpiarCadena($_POST["meta_val_admin"]):"";
$meta_val_usuario=isset($_POST["meta_val_usuario"])? limpiarCadena($_POST["meta_val_usuario"]):"";
$meta_valida=isset($_POST["meta_valida"])? limpiarCadena($_POST["meta_valida"]):"";
// $meta_periodo=isset($_POST["meta_periodo"])? limpiarCadena($_POST["meta_periodo"]):"";
//=isset($_POST["corresponsabilidad"])? limpiarCadena($_POST["corresponsabilidad"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_compromiso)){
			$rspta=$sac_compromiso->sacinsertar($id_eje, $nombre_compromiso, $fecha_compromiso, $compromiso_val_admin, $compromiso_val_usuario, $resposable_compromiso);
			echo $rspta ? "compromiso registrado" : "compromiso no se pudo registrar";
		}
		else {
			$rspta=$sac_compromiso->saceditar($id_compromiso, $id_eje, $nombre_compromiso, $fecha_compromiso, $compromiso_val_admin, $compromiso_val_usuario, $resposable_compromiso);
			echo $rspta ? "compromiso actualizado" : "compromiso no se pudo actualizar";
		}
	break;		
	case 'guardaryeditarmeta':
		if (empty($id_meta)){
			$rspta=$sac_compromiso->sacinsertarmeta($id_compromiso_meta,$id_meta, $id_eje, $nombre_meta, $meta_fecha, $meta_val_admin, $meta_val_usuario, $meta_valida, $condicion_institucional_meta, $condicion_programa, $_POST["condicion_institucional_meta"],$_POST["condicion_programa"]);
			echo $rspta ? "meta registrado" : "meta no se pudo registrar";
		}
		else {
			$rspta=$sac_compromiso->editarmeta($$id_meta,$id_compromiso_meta,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo,$condicion_institucional,$condicion_programa,$_POST["condicion_institucional_meta"],$_POST["condicion_programa"]);
			echo $rspta ? "meta actualizada" : "meta no se pudo actualizar";
		}
	break;	
	case 'mostrar':
		$rspta=$sac_compromiso->mostrar($id_compromiso);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;
		
	case 'mostrarmetaeditar':
		$rspta=$sac_compromiso->mostrarMetaEditar($id_meta);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;	
	case 'mostrarmeta':
		$contador=0;
		$rsptaperiodo=$compromiso->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		$rspta=$sac_compromiso->mostrarMeta($id_compromiso,$periodo_actual);
		$data= Array();
		$data["0"] ="";
		$data["0"] .= '<table class="table table-bordered">';
		$reg=$rspta;
		for ($i=0;$i<count($reg);$i++){	
			$rsptaeje=$sac_compromiso->buscarEjes($reg[$i]["id_eje"]);
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
						<i class="far fa-calendar-alt"></i> '.$compromiso->fechaesp($reg[$i]["meta_fecha"]).' | 
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
		$rsptaperiodo=$sac_compromiso->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		$rspta=$sac_compromiso->listarUsuarioPoa();
		//Vamos a declarar un array
		$data= Array();
		$data["0"] ="";
		$color=array('primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt');
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
						<button class="btn btn-success btn-sm" id="btnagregar" title="Agregar Compromiso" onclick=mostrarform(true);numerocampo('.$reg[$i]["id_usuario"].',"'.$periodo_actual.'")><i class="fa fa-plus-circle"></i> Agregar compromiso </button> 

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
			
			$rsptadatos=$sac_compromiso->listarCompromiso($reg[$i]["id_usuario"],$periodo_actual);
			$regdatos=$rsptadatos;
			
			for ($j=0;$j<count($regdatos);$j++){	
				
				
			$data["0"] .= '	
				
				<div class="card col-xl-6 col-lg-6 col-md-12 col-12" style="padding-top:5px;">
				<div class="box box-solid">
					<div class="box-body">
						<h4 style="background-color:#f7f7f7; font-size: 14px; text-align: center; padding: 7px 10px; margin-top: 0;">
							<i class="fas fa-hands-helping"></i> <b> '.$regdatos[$j]["nombre_compromiso"].'</b>
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
										<button type="button" class="btn bg-purple btn-flat btn-xs" onclick=mostrarMeta('.$regdatos[$j]["id_compromiso"].',"'.$regdatos[$j]["fecha_compromiso"].'") title="Agregar metas del Compromiso"><i class="fas fa-flag-checkered"></i> Metas </button>
								
										
										<button class="btn btn-warning btn-xs" onclick="mostrar('.$regdatos[$j]["id_compromiso"].')" title="Editar Compromiso"><i class="fas fa-pencil-alt"></i> Editar</button>
										
										<button class="btn btn-danger btn-xs" onclick="eliminar('.$regdatos[$j]["id_compromiso"].')" title="Eliminar Compromiso"><i class="far fa-trash-alt"></i> Eliminar</button>
										
									</p> 
									<h4 style="margin-top: 0">Impacto </h4>
									<p>';
				
									$rsptameta=$sac_compromiso->mostrarMeta($regdatos[$j]["id_compromiso"],$periodo_actual);
									

									for ($k=0;$k<count($rsptameta);$k++){
										
										$rsptaeje=$sac_compromiso->buscarEjes($rsptameta[$k]["id_eje"]);

										$data["0"] .= '<span class="text-primary">'.$rsptaeje["nombre_ejes"].'</span> | ';
									}
				
				
				
				
									$data["0"] .= '	
									</p>
									<p style="margin-bottom: 0">
										<i class="far fa-calendar-alt"></i> '.$sac_compromiso->fechaesp($regdatos[$j]["fecha_compromiso"]).'
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
		$rspta=$sac_compromiso->eliminar($id_compromiso_meta);
		
		$rspta2=$sac_compromiso->eliminarCompromisoMeta($id_compromiso);

		echo json_encode($rspta);
	break;
	case 'validarcompromiso':
		$rspta=$sac_compromiso->validarCompromiso($id_compromiso);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;	
	case 'eliminarmeta':
		$rspta=$sac_compromiso->eliminarMeta($id_meta);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;
	
	case "selectEjes":	
		$rspta = $sac_compromiso->selectEjes();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_ejes"] . "'>" . $rspta[$i]["nombre_ejes"] . "</option>";
				}
	break;
		
	case "selectPeriodo":	
		$rspta = $sac_compromiso->selectPeriodo();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"]. "</option>";
				}
	break;
		
	case "selectListaSiNo":	
	$rspta = $sac_compromiso->selectListaSiNo();
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["valor"] . "'>" . $rspta[$i]["nombre_lista"] . "</option>";
			}
	break;
		
	case "selectListarCargo":	
	$rspta = $sac_compromiso->selectlistarCargo();
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["usuario_cargo"]. "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
			}
	break;
		
	case "selectListarCorresponsable":	
	$rspta = $sac_compromiso->selectlistarCargo();
		echo "<option value='Ninguno'>Ninguno</option>";
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["usuario_cargo"]. "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
			}
	break;	
	
	case 'imprimir':
		$num=0;
		$contador=0;
		
		$rsptaperiodo=$sac_compromiso->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		
		$id_usuario_reporte=$_POST["id_usuario"];
		$rspta=$sac_compromiso->listarImprimir($id_usuario_reporte);
		//Vamos a declarar un array
		$data= Array();
		$data["0"] ="";
		$data["0"] .= '<h3>' . $rspta["usuario_cargo"] .'</h3>';
		
		$rsptadatos=$sac_compromiso->listarCompromiso($id_usuario_reporte,$periodo_actual);
			$regdatos=$rsptadatos;
			
			for ($j=0;$j<count($regdatos);$j++){
				
				$data["0"] .= '<i class="fas fa-hands-helping"></i> <b> '.$regdatos[$j]["nombre_compromiso"].'</b><br>
				Compromiso para entregar: '.$sac_compromiso->fechaesp($regdatos[$j]["fecha_compromiso"]).'<br><br>
				
				';
				$rsptameta=$sac_compromiso->mostrarMeta($regdatos[$j]["id_compromiso"],$periodo_actual);					
				$data["0"] .= '<ol>';
									for ($k=0;$k<count($rsptameta);$k++){
										$data["0"] .= '<li><b>'. $rsptameta[$k]["meta_nombre"].'</b>';
										$rsptaeje=$sac_compromiso->buscarEjes($rsptameta[$k]["id_eje"]);
										$data["0"] .= '<br>Eje Estratégico: <span class="text-primary">'.$rsptaeje["nombre_ejes"].'</span> <br>
										<b>Fecha de entrega:</b> '.$sac_compromiso->fechaesp($rsptameta[$k]["meta_fecha"]).'<br>';
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
	$rspta = $sac_compromiso->fechaLimite($id_compromiso);
		
		echo $rspta["fecha_compromiso"];

	break;
		
	case 'condiciones_institucionales':

		$rspta = $sac_compromiso->listarCondicionesInstitucionales();

		//Obtener las condiciones asignadas a la meta
		$id=$_GET['id'];
		$marcados = $sac_compromiso->listarcondicionesmarcadas($id);
		//Declaramos el array para almacenar todos las condiciones marcados
		$valores=array();

		
				$i = 0;
					while ($i < count($marcados)){
						array_push($valores, $marcados[$i]["condicion_institucional_meta"]);
						$i++;
					}

//		Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
		$j=0;
		
		while ($j < count($rspta))
				{

					$sw=in_array($rspta[$j]["id_condicion_institucional"],$valores)?'checked':'';
					echo '<li> <input type="checkbox" '.$sw.' name="condicion_institucional_meta[]" value="'.$rspta[$j]["id_condicion_institucional"].'">'.$rspta[$j]["nombre_condicion"].'</li>';
		$j++;
				}
	
	break;

	case 'condiciones_programa':

		$rspta = $sac_compromiso->listarCondicionesprograma();

		//Obtener las condiciones asignadas a la meta
		$id=$_GET['id'];
		$marcados = $sac_compromiso->listarcondicionesmarcadasprograma($id);
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