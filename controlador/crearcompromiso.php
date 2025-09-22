<?php 
require_once "../modelos/CrearCompromiso.php";

$crearcompromiso=new CrearCompromiso();

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
			$rspta=$crearcompromiso->insertar($id_usuario,$compromiso_nombre,$compromiso_fecha,'0','0',$compromiso_valida,$compromiso_periodo);
			echo $rspta ? "compromiso registrado" : "compromiso no se pudo registrar";
		}
		else {
			$rspta=$crearcompromiso->editar($id_compromiso,$id_usuario,$compromiso_nombre,$compromiso_fecha,$compromiso_val_admin,$compromiso_val_usuario,$compromiso_valida,$compromiso_periodo);
			echo $rspta ? "compromiso actualizado" : "compromiso no se pudo actualizar";
		}
	break;

		
	case 'guardaryeditarmeta':
	    $meta_val_admin=0;
	    $meta_val_usuario=0;
		if (empty($id_meta)){
			$rspta=$crearcompromiso->insertarmeta($id_compromiso_meta,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo,$corresponsabilidad,$_POST["condicion_institucional"],$_POST["condicion_programa"]);
			echo $rspta ? "meta registrado" : "meta no se pudo registrar";
		}
		else {
			$rspta=$crearcompromiso->editarmeta($id_meta,$id_compromiso_meta,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo,$corresponsabilidad,$_POST["condicion_institucional"],$_POST["condicion_programa"]);
			echo $rspta ? "meta actualizada" : "meta no se pudo actualizar";
			
		}
	break;
		

		
		
		

	case 'mostrar':
		$rspta=$crearcompromiso->mostrar($id_compromiso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
		
	case 'mostrarmetaeditar':
		$rspta=$crearcompromiso->mostrarMetaEditar($id_meta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;	
		
	case 'mostrarmeta':
		$contador=0;
		
		$rsptaperiodo=$crearcompromiso->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		
		$rspta=$crearcompromiso->mostrarMeta($id_compromiso,$periodo_actual);
 		$data= Array();
		$data["0"] ="";
		
		$data["0"] .= '<table class="table table-bordered">';
		
		$reg=$rspta;
		
 		for ($i=0;$i<count($reg);$i++){	
				
			$rsptaeje=$crearcompromiso->buscarEjes($reg[$i]["id_eje"]);
			$regeje=count($rsptaeje);
			
			$rspta2=$crearcompromiso->mostrar($id_compromiso);
			
			
			if($rspta2["aprobado"]==0){
			
				$data["0"] .= '
				<tr id="linea_borrar_'.$contador.'">
					<td width="80px">
					
					<button class="btn btn-warning btn-xs" onclick=mostrarMetaEditar('.$reg[$i]["id_meta"].');numerocompromiso('.$reg[$i]["id_compromiso"].') title="Editar Compromiso"><i class="fas fa-pencil-alt"></i></button>
					
					<button class="btn btn-danger btn-xs" onclick=eliminarMeta('.$reg[$i]["id_meta"].','.$contador.') title="Eliminar Meta"><i class="fas fa-trash-alt"></i></button>';
			}
				
				$data["0"] .= '
					</td>
					<td>
					<i class="fas fa-hands-helping"></i> <b> '.$reg[$i]["meta_nombre"].'</b>
								| <b class="text-success"> '.$regeje[$i]["nombre_ejes"].'</b>
					
					<hr style="margin:0px">
						<i class="far fa-calendar-alt"></i> '.$crearcompromiso->fechaesp($reg[$i]["meta_fecha"]).' | 
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
		
	case 'mostrarmeta2':
		$contador=0;
		
		$rsptaperiodo=$crearcompromiso->buscarperiodo();
		$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];
		
		$rspta=$crearcompromiso->mostrarMeta($id_compromiso,$periodo_siguiente);
 		$data= Array();
		$data["0"] ="";
		
		$data["0"] .= '<table class="table table-bordered">';
		
		$reg=$rspta;
		
 		for ($i=0;$i<count($reg);$i++){	
				
			$rsptaeje=$crearcompromiso->buscarEjes($reg[$i]["id_eje"]);
			$regeje=count($rsptaeje);
			
			$rspta2=$crearcompromiso->mostrar($id_compromiso);
			
			
			if($rspta2["aprobado"]==0){
			
				$data["0"] .= '
				<tr id="linea_borrar_'.$contador.'">
					<td width="80px">
					
					<button class="btn btn-warning btn-xs" onclick=mostrarMetaEditar('.$reg[$i]["id_meta"].');numerocompromiso('.$reg[$i]["id_compromiso"].') title="Editar Compromiso"><i class="fas fa-pencil-alt"></i></button>
					
					<button class="btn btn-danger btn-xs" onclick=eliminarMeta('.$reg[$i]["id_meta"].','.$contador.') title="Eliminar Meta"><i class="fas fa-trash-alt"></i></button>';
			}
				
				$data["0"] .= '
					</td>
					<td>
					<i class="fas fa-hands-helping"></i> <b> '.$reg[$i]["meta_nombre"].'</b>
								| <b class="text-success"> '.$regeje[$i]["nombre_ejes"].'</b>
					
					<hr style="margin:0px">
						<i class="far fa-calendar-alt"></i> '.$crearcompromiso->fechaesp($reg[$i]["meta_fecha"]).' | 
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
		

		case 'listar3':
		$num=0;
		$contador=0;
		
		$rsptaperiodo=$crearcompromiso->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		
		$rsptadatos=$crearcompromiso->listarCompromiso($periodo_actual);
		$data= Array();
		$data["0"] ="";
		$regdatos=$rsptadatos;
		
		$data["0"].='
	<div class="panel-body table-responsive" id="listadoregistros">	
		<div class="alert" style="margin-bottom:0px; padding-bottom:0px;">
			<button class="btn btn-success btn-sm" id="btnagregar" title="Agregar Compromiso" onclick="mostrarform(true);numerocampo('.$_SESSION['id_usuario'].')"><i class="fa fa-plus-circle"></i> Agregar Compromiso</button> 
		</div>
		';
			
			for ($j=0;$j<count($regdatos);$j++){	

				$data["0"] .= '	
				
				<div class="col-sm-12 col-md-12 col-lg-6 alto_div">
                <div class="box box-solid">
                    <div class="box-body">
                        <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
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
                                        <button type="button" class="btn bg-purple btn-flat btn-xs btn-block" onclick=mostrarMeta('.$regdatos[$j]["id_compromiso"].',"'.$regdatos[$j]["compromiso_fecha"].'") title="Agregar metas del Compromiso"><i class="fas fa-flag-checkered"></i> Metas</button>
								
										
										<button class="btn btn-warning btn-xs btn-block" onclick="mostrar('.$regdatos[$j]["id_compromiso"].')" title="Editar Compromiso"><i class="fas fa-pencil-alt"></i> Editar</button>
										
										<button class="btn btn-danger btn-xs btn-block" onclick="eliminar('.$regdatos[$j]["id_compromiso"].')" title="Eliminar Compromiso"><i class="far fa-trash-alt"></i> Eliminar</button>';
							}else{
							$data["0"] .= '	
								<a class="btn btn-app">             
									<i class="fa fa-check-circle" style="color:#00a65a"></i> Aprobado
								</a>';
								
							}
										
						$data["0"] .= '					
                                    </p> 
									<h4 style="margin-top: 0">Impacto </h4>
									<p>';
				
									$rsptameta=$crearcompromiso->mostrarMeta($regdatos[$j]["id_compromiso"],$periodo_actual);
									

									for ($k=0;$k<count($rsptameta);$k++){
										
										$rsptaeje=$crearcompromiso->buscarEjes($rsptameta[$k]["id_eje"]);

										$data["0"] .= '<span class="text-primary">'.$rsptaeje["nombre_ejes"].'</span> | ';
									}
				
				
				
				
									$data["0"] .= '	
                                    </p>
                                    <p style="margin-bottom: 0">
                                        <i class="far fa-calendar-alt"></i> '.$crearcompromiso->fechaesp($regdatos[$j]["compromiso_fecha"]).'
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
		
	case 'listar':
		
		$num=0;
		$contador=0;
		
		$rsptaperiodo=$crearcompromiso->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		
		$rsptadatos=$crearcompromiso->listarCompromiso($periodo_actual);
		
		$data= Array();
		$regdatos=$rsptadatos;
		
		for ($i=0;$i<count($regdatos);$i++){	
			
				$data[]=array(
				"0"=>($regdatos[$i]["aprobado"]==0)?
					
					'<button type="button" class="btn bg-purple btn-flat btn-xs" onclick=mostrarMeta('.$regdatos[$i]["id_compromiso"].',"'.$regdatos[$i]["compromiso_fecha"].'","'.$periodo_actual.'") title="Agregar metas del Compromiso"><i class="fas fa-flag-checkered"></i> Agregar Metas</button>


					<button class="btn btn-warning btn-xs" onclick="mostrar('.$regdatos[$i]["id_compromiso"].')" title="Editar Compromiso"><i class="fas fa-pencil-alt"></i> Editar</button>

					<button class="btn btn-danger btn-xs" onclick="eliminar('.$regdatos[$i]["id_compromiso"].')" title="Eliminar Compromiso"><i class="far fa-trash-alt"></i> Eliminar</button>':
					
					'<i class="fa fa-check-circle" style="color:#00a65a"></i> Aprobado
					
					<button type="button" class="btn bg-purple btn-flat btn-xs" onclick=mostrarMeta('.$regdatos[$i]["id_compromiso"].',"'.$regdatos[$i]["compromiso_fecha"].'","'.$periodo_actual.'") title="Metas del Compromiso"><i class="fas fa-flag-checkered"></i> Ver metas</button>
					
					',
					
					
 				"1"=>$regdatos[$i]["compromiso_nombre"],
				"2"=>'<i class="far fa-calendar-alt"></i> '.$crearcompromiso->fechaesp($regdatos[$i]["compromiso_fecha"]),
					
 				);
				
			}
		
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
		
		case 'listar2':
		
		$num=0;
		$contador=0;
		
		$rsptaperiodo=$crearcompromiso->buscarperiodo();
		$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];
		
		$rsptadatos=$crearcompromiso->listarCompromiso($periodo_siguiente);
		
		$data= Array();
		$regdatos=$rsptadatos;
		
		for ($i=0;$i<count($regdatos);$i++){	
			
				$data[]=array(
				"0"=>($regdatos[$i]["aprobado"]==0)?
					
					'<button type="button" class="btn bg-purple btn-flat btn-xs" onclick=mostrarMeta2('.$regdatos[$i]["id_compromiso"].',"'.$regdatos[$i]["compromiso_fecha"].'","'.$periodo_siguiente.'") title="Agregar metas del Compromiso"><i class="fas fa-flag-checkered"></i> Agregar Metas</button>


					<button class="btn btn-warning btn-xs" onclick="mostrar('.$regdatos[$i]["id_compromiso"].')" title="Editar Compromiso"><i class="fas fa-pencil-alt"></i> Editar</button>

					<button class="btn btn-danger btn-xs" onclick="eliminar('.$regdatos[$i]["id_compromiso"].')" title="Eliminar Compromiso"><i class="far fa-trash-alt"></i> Eliminar</button>':
					
					'<i class="fa fa-check-circle" style="color:#00a65a"></i> Aprobado',
					
					
 				"1"=>$regdatos[$i]["compromiso_nombre"],
				"2"=>'<i class="far fa-calendar-alt"></i> '.$crearcompromiso->fechaesp($regdatos[$i]["compromiso_fecha"]),
					
 				);
				
			}
		
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
		
		
	case 'eliminar':
		$rspta=$crearcompromiso->eliminar($id_compromiso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
		
	case 'eliminarmeta':
		$rspta=$crearcompromiso->eliminarMeta($id_meta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	
	case "selectEjes":	
		$rspta = $crearcompromiso->selectEjes();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_ejes"] . "'>" . $rspta[$i]["nombre_ejes"] . "</option>";
				}
	break;
		
	case "selectPeriodo":	
		$rspta = $crearcompromiso->selectPeriodo();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"]. "</option>";
				}
	break;
		
	case "selectListaSiNo":	
	$rspta = $crearcompromiso->selectListaSiNo();
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["valor"] . "'>" . $rspta[$i]["nombre_lista"] . "</option>";
			}
	break;
		
	case "selectListarCargo":	
	$rspta = $crearcompromiso->selectlistarCargo();
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["usuario_cargo"]. "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
			}
	break;	
		
	case "selectListarCorresponsable":	
	$rspta = $crearcompromiso->selectlistarCargo();
		echo "<option value='Ninguno'>Ninguno</option>";
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["usuario_cargo"]. "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
			}
	break;
		
	case "fechaLimite":	
	$rspta = $crearcompromiso->fechaLimite($id_compromiso);
		
		echo $rspta["compromiso_fecha"];

	break;
		
		
	case 'condiciones_institucionales':

		$rspta = $crearcompromiso->listarCondicionesInstitucionales();

		//Obtener las condiciones asignadas a la meta
		$id=$_GET['id'];
		$marcados = $crearcompromiso->listarcondicionesmarcadas($id);
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

		$rspta = $crearcompromiso->listarCondicionesprograma();

		//Obtener las condiciones asignadas a la meta
		$id=$_GET['id'];
		$marcados = $crearcompromiso->listarcondicionesmarcadasprograma($id);
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