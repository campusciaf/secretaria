<?php 
require_once "../modelos/SacSeguimiento.php";
$meses = array( "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre","Noviembre","Diciembre");
$SacSeguimiento = new SacSeguimiento();
$id_usuario  = isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$usuario_poa  = isset($_POST["usuario_poa"])? limpiarCadena($_POST["usuario_poa"]):"";
$usuario_cargo  = isset($_POST["usuario_cargo"])? limpiarCadena($_POST["usuario_cargo"]):"";
$id_accion  = isset($_POST["id_accion"])? limpiarCadena($_POST["id_accion"]):"";
$id_meta  = isset($_POST["id_meta"])? limpiarCadena($_POST["id_meta"]):"";
$nombre_accion = isset($_POST["nombre_accion"])? limpiarCadena($_POST["nombre_accion"]):"";
$fecha_accion = isset($_POST["fecha_accion"]) ? limpiarCadena($_POST["fecha_accion"]) : "";
$meta_responsable = isset($_POST["meta_responsable"])? limpiarCadena($_POST["meta_responsable"]):"";
$id_objetivo_especifico = isset($_POST["id_objetivo_especifico"])? limpiarCadena($_POST["id_objetivo_especifico"]):"";
$nombre_accion = isset($_POST["nombre_accion"])? limpiarCadena($_POST["nombre_accion"]):"";
$evidencia_imagen  = isset($_POST["evidencia_imagen"])? limpiarCadena($_POST["evidencia_imagen"]):"";
$fecha_fin  = isset($_POST["fecha_fin"])? limpiarCadena($_POST["fecha_fin"]):"";
$validado_por  = isset($_POST["validado_por"])? limpiarCadena($_POST["validado_por"]):"";
$validacion  = isset($_POST["validacion"])? limpiarCadena($_POST["validacion"]):"";
$accion_estado  = isset($_POST["accion_estado"])? limpiarCadena($_POST["accion_estado"]):"";
$periodo  = isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$periodo  = isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
switch ($_GET["op"]){

	//guardar y editar una accion
	case 'guardaryeditaraccion':
		if (empty($id_accion)){
			$rspta = $SacSeguimiento->insertaroejecucion($nombre_accion, $id_meta, $fecha_accion, $fecha_fin);
			echo $rspta ? "Ejecucion registrado" : "Ejecucion no se pudo registrar";
		}else{
			$rspta = $SacSeguimiento->editarejecucion($id_accion, $nombre_accion, $id_meta, $fecha_accion, $fecha_fin);
			echo $rspta ? "Ejecucion actualizada" : "Ejecucion no se pudo actualizar";
		}
	break;

	//listar las acciones 
	case 'listarejecucion':
		$rsptausuario = $SacSeguimiento->mostrarusuario($id_usuario);
		//Codificar el resultado utilizando json
		//echo $id_usuario;
		$rspta = $SacSeguimiento->listarmetaejecucion($rsptausuario["usuario_cargo"], $_SESSION["sac_periodo"]);
		//print_r($rspta);
		// print_r($_SESSION);
		//echo($_SESSION["sac_periodo"]);
		$data = array();
		$data[0] = "";
		
		for ($i = 0; $i < count($rspta); $i++){	
			$nombre_ejes = '';
			//se lista las condiciones institucionales
			$condicion_ins_meta = $SacSeguimiento->listarCondicionInstitucionalMeta($rspta[$i]["id_meta"]);
			//se lista las condiciones de programa
			$condicion_pro_meta = $SacSeguimiento->listarCondicionProgramaMeta($rspta[$i]["id_meta"]);
			//se lista las dependencias
			$condicion_dependencia = $SacSeguimiento->listarCondicionDependencia($rspta[$i]["id_meta"]);
			$nombre_objetivo = '';
			$nombre_objetivo_especifico = '';
			
			if($rspta[$i]["accion_estado"] == 1){
				
				$evidencia = "<br><strong class='text-secondary'> <span class='badge bg-warning h5' style='font-size:100% !important'>Pendiente Por Revisión</span> </strong>";
			}elseif($rspta[$i]["accion_estado"] == 2){
				$evidencia = "<br><span class='badge bg-success h5' style='font-size:100% !important'>Evidencia Aceptada</span>";
			}else{
				
				$evidencia = '<button type="file" class="btn btn-primary float-right btn-sm btn-flat tooltip-agregar" onclick="subirEvidencia('.$rspta[$i]["id_meta"].')" data-toggle="tooltip" data-placement="top" title="Agregar Evidencia" id="foto"> <i class="fa fa-file" aria-hidden="true"></i>
				</button>';
			}

			$objetivo_general_ant = isset($rspta[($i - 1)]["nombre_objetivo"])?$rspta[($i - 1)]["nombre_objetivo"]:"";
			if($rspta[$i]["nombre_objetivo"] != $objetivo_general_ant ){
				$nombre_objetivo = '<br><strong>Proyecto: </strong><strong class="text-secondary">'.$rspta[$i]["nombre_objetivo"]. '</strong>';
			}

			$objetivo_especi_ant = isset($rspta[($i - 1)]["nombre_objetivo_especifico"])?$rspta[($i - 1)]["nombre_objetivo_especifico"]:"";
			if($rspta[$i]["nombre_objetivo_especifico"] != $objetivo_especi_ant ){
				$nombre_objetivo_especifico = '<br><strong>Objetivo Especifico: </strong><strong class="text-secondary">'.$rspta[$i]["nombre_objetivo_especifico"]. '</strong>';
			}

			$eje_anterior = isset($rspta[($i - 1)]["nombre_ejes"])?$rspta[($i - 1)]["nombre_ejes"]:"";
			if($rspta[$i]["nombre_ejes"] != $eje_anterior ){
				$nombre_ejes = '<br><strong>Eje: </strong><strong class="text-secondary">'.$rspta[$i]["nombre_ejes"].'</strong>';
				$data[0] .= '
						<div class="card-header bg-dark" id="heading'.$i.'">
							<div class="content-header col-12 p-0">';
			}
								$data[0].='
								<strong class="pl-4 pr-4" > 
								
								'.$nombre_ejes.'</div></div>
								<div class="card">
							
								';
								
								$data[0].='
								'.$nombre_objetivo.$nombre_objetivo_especifico;
								
								$data[0].='
								<br>Meta:  <strong class="text-secondary">'.$rspta[$i]["meta_nombre"].'</strong>';
								$data[0].='<br>  Condiciones De Programa: ';
								
								for ($g=0; $g < count($condicion_pro_meta); $g++) { 
									$data[0] .= '<strong class="text-secondary">'.
									$condicion_pro_meta[$g]["nombre_condicion"]
									.' </strong>';
								}
								
								$data[0].=' <br> Condiciones Institucionales : '; 
								
								for ($e=0; $e <count($condicion_ins_meta); $e++) { 
									$data[0] .=' <strong class="text-secondary">'.
									$condicion_ins_meta[$e]["nombre_condicion"]
									
									.' </strong>';
								}

								$data[0].=' <br> Dependencia : '; 
								
								for ($y=0; $y <count($condicion_dependencia); $y++) { 
									$data[0] .='<strong class="text-secondary"> '.($y+1).'. '.
									$condicion_dependencia[$y]["nombre"]
									
									.'</strong>';
								}
								
								$data[0].= ''.$evidencia.' 
								<button class="btn btn-secondary btn-sm float-right tooltip-agregar" data-toggle="tooltip" data-placement="top" title="Ver evidencia" target="_blank"> 
											<a href="../files/sac_evidencias/'.$rspta[$i]["evidencia_imagen"].'" target="_blank">
												<i class="fa fa-eye green-color" aria-hidden="true"></i>
											</a>
										</button>
									</strong>
								</strong>';

					if($rspta[$i]["nombre_ejes"] != $eje_anterior ){
						$data[0] .= '
							';
					}

			$data[0] .= '<div id="collapse'.$i.'" class="collapse show" aria-labelledby="heading'.$i.'" data-parent="#listadoregistrosobjetivosgenerales">
			<div class="card-body">
				<button type="button" class="btn btn-success float-right btn-sm btn-flat tooltip-agregar" onclick="configurar_limite_fecha('.$rspta[$i]["id_meta"].', `'.$rspta[$i]["meta_fecha"].'`)" data-toggle="tooltip" data-placement="top" title="Agregar Acción"> + </button>
				<div class="row">';
							$listaracciones = $SacSeguimiento->listaracciones($rspta[$i]["id_meta"]);
							
							$data[0] .= '
							<div class="col-12">
								<div class="">
									<div class="row no-gutters">
										<div class="col-12">
										
											<div class="card-body p-0">
												<table class="table table-hover table-active bg-Disabled table-responsive">
													<thead class = "bg-Gray">
														<tr>
														<th scope="col">#</th>
														<th scope="col"><b>Nombre Acción</b></th>
														<th scope="col"><b>Cronograma</b> </th>
														<th scope="col">Opciones</th>
														</tr>
													</thead>
													<tbody>';

												for ($j = 0; $j < count($listaracciones); $j++) {
													
													$fech_max = intval($listaracciones[$j]["fecha_accion"]) - 1;
													$fech_min = intval($listaracciones[$j]["fecha_fin"]) - 1;
													
													$tiempo = "";
													for ($a = $fech_max; $a <= $fech_min; $a++) {
														if($a == $fech_min){
															$tiempo .=  $meses[$a];
														}
														else{
															$tiempo .=  $meses[$a]." - ";
														}
													}
													
													$data[0] .= '
													
													<tr>
													<th scope="row">'.($j+1).'</th>
													
													<td> <b> '.$listaracciones[$j]["nombre_accion"].'</b></td>
													<td>'.$tiempo. '</td>
											
													<td>  <button class="tooltip-agregar btn btn-warning btn-xs" onclick="mostrar_accion('.$listaracciones[$j]["id_accion"]. ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
												
													<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_accion('.$listaracciones[$j]["id_accion"]. ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button></td>
													</tr>
													<tr>';
												}
												$data[0] .= 
													'</tbody>
													</table>'.'
												</form>
												</small>
												</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>';
		}
		echo json_encode($data);
		break;
		//mostrar una accion
		case 'mostrar_accion':
			$rspta = $SacSeguimiento->mostrar_accion($id_accion);
			echo json_encode($rspta);
		break;
		//eliminar una accion
		case 'eliminar_accion':
			$rspta = $SacSeguimiento->eliminar_accion($id_accion);
			echo json_encode($rspta);
		break;

		//guardar y editar imagen de accion
		case 'guardaryeditarevidencia':
			$file_type = $_FILES['foto']['type'];
            $allowed = array("image/jpeg", "image/jpg", "application/msword", "application/vnd.oasis.opendocument.text", "application/rtf", "text/plain", "image/gif", "image/png", "application/pdf", "application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/vnd.ms-powerpoint");
            if(!in_array($file_type, $allowed)) {
                $inserto = Array(
                    "estatus" => 0,
                    "valor" => "Formato de imagen no reconocido"
                );
				echo json_encode($inserto);
                exit();
            }
            $target_path = '../files/sac_evidencias/';
            $img1path = $target_path."".$_FILES['foto']['name'];
            if(move_uploaded_file($_FILES['foto']['tmp_name'], $img1path)){
				$evidencia_imagen = $_FILES['foto']["name"];
                $rspta = $SacSeguimiento->editarImagen($id_meta, $evidencia_imagen);                
                if($rspta){
                    $inserto = Array(
                        "estatus" => 1,
                        "valor" => "Evidencia Guardada",
                        "foto" => $evidencia_imagen
                    );
                }
                echo json_encode($inserto);
            }			
		break;

		// case 'mostrar':
		// 	$rspta2 = $SacSeguimiento->mostrarusuario($id_usuario);
		// 	//Codificar el resultado utilizando json
		// 	$data = array();
		// 	$data[0] = "";
		
		// 	for ($i = 0; $i < count($rspta2); $i++){	

		// 	}
		// 	echo json_encode($rspta2);
		// break;
	
	// case 'seguimiento':
		
	// 	$rspta = $SacSeguimiento->listarusuariopoa($id_usuario);
		
	// 	$data = array();
	// 	$data[0] = "";
	// 	$usuariopoa = "";
	// 	for ($i = 0; $i < count($rspta); $i++){	
			
	// 			$data[0] .= '
	// 			<div class="card">
	// 				<div class="card-header" id="heading'.$i.'">
	// 					<div class="content-header col-12 p-0">
	// 					<b>  <span class="badge bg-primary pb-0">'.($i + 1). '</span>: </b>
	// 						<strong>Usuario cargo: </strong><strong class="text-secondary">'.$rspta[$i]["usuario_cargo"].'</strong>
							
	// 						<br><strong>Usuario Poa: </strong><strong class="text-secondary">'.$rspta[$i]["usuario_poa"]. '</strong>

	// 						<br><strong>Cedula: </strong><strong class="text-secondary">'.$rspta[$i]["usuario_identificacion"]. '</strong>
	// 						</label>
	
	// 						<strong class="text-secondary"> 
	// 						'.$usuariopoa.' 
	// 						</strong>
							
	// 					</div>
	// 				</div>
	// 			</div>';
	// 	}
	// 	echo json_encode($data);
	// 	break;

		
		
		
}
?>