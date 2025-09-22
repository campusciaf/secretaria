<?php 
require_once "../modelos/SacEjecucion.php";
$SacEjecucion= new SacEjecucion();

$meses = array( "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre","Noviembre","Diciembre");


/* campos para agregar una ación */
$nombre_accion = isset($_POST["nombre_accion"])? limpiarCadena($_POST["nombre_accion"]):"";
$id_meta  = isset($_POST["id_meta"])? limpiarCadena($_POST["id_meta"]):"";
$fecha_accion = isset($_POST["fecha_accion"]) ? limpiarCadena($_POST["fecha_accion"]) : "";
$fecha_fin  = isset($_POST["fecha_fin"])? limpiarCadena($_POST["fecha_fin"]):"";
$accion_estado  = isset($_POST["accion_estado"])? limpiarCadena($_POST["accion_estado"]):"";

/* ************************************ */

/* campos para aditar las acciones */
$id_accion  = isset($_POST["id_accion"])? limpiarCadena($_POST["id_accion"]):"";
/* ************************************ */

// $nombre_accion = isset($_POST["nombre_accion"])? limpiarCadena($_POST["nombre_accion"]):"";

// $meta_responsable = isset($_POST["meta_responsable"])? limpiarCadena($_POST["meta_responsable"]):"";
// $id_objetivo_especifico = isset($_POST["id_objetivo_especifico"])? limpiarCadena($_POST["id_objetivo_especifico"]):"";

// $evidencia_imagen  = isset($_POST["evidencia_imagen"])? limpiarCadena($_POST["evidencia_imagen"]):"";

// $validado_por  = isset($_POST["validado_por"])? limpiarCadena($_POST["validado_por"]):"";
// $validacion  = isset($_POST["validacion"])? limpiarCadena($_POST["validacion"]):"";



//echo " ---".$id_meta;
switch ($_GET["op"]){


	//listar las acciones 

	//guardar y editar una accion
	case 'guardaryeditaraccion':
		if (empty($id_accion)){
			$rspta = $SacEjecucion->insertaraccion($nombre_accion, $id_meta, $fecha_accion, $fecha_fin);
			echo $rspta ? "Acción registrada" : "Acción no se pudo registrar";
		}else{
			$rspta = $SacEjecucion->editaraccion($id_accion, $nombre_accion, $id_meta, $fecha_accion, $fecha_fin);
			echo $rspta ? "Accion actualizada" : "Accion no se pudo actualizar";
		}
	break;

	// //listar los nombres de meta por usuario
	case 'listar':
		
		$rspta = $SacEjecucion->listarproyecto();// lista los proyectos del plan
		// echo $meta_responsable;
		$data[0] = "";
			for ($a = 0; $a < count($rspta) ; $a++) {
				$id_proyecto=$rspta[$a]["id_proyecto"];

				$rspta2=$SacEjecucion->listarproyectousuario($id_proyecto,$_SESSION["id_usuario"]);// consulta para saber si tiene metas en el proyecto

				if($rspta2==true){// si tiene una meta en el proyecto

					$data[0] .='
					<div class="col-md-12">
						<div class="card card-outline card-primary">
							<div class="card-header">
								<h3 id="nombre_proyecto" class="card-title"><b>'.$rspta[$a]["nombre_proyecto"].'</b></h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>

							<div class="card-body" style="display: block;">';

							$rsptaperiodo = $SacEjecucion->periodoactual();
							$periodo_actual = $rsptaperiodo['sac_periodo'];

								$rspta3=$SacEjecucion->listarmeta($_SESSION["id_usuario"],$rspta2["id_proyecto"],$periodo_actual);// consulta para traer las metas del proyecto

								for ($b = 0; $b < count($rspta3) ; $b++) {
									$contador=$b+1;
									$data[0] .='
									<p><a onclick="agregaraccion('.$rspta3[$b]["id_meta"].')" id="agregar_accion" class="bg-orange float-right p-1" style="cursor:pointer"><i class="fas fa-plus"></i> Agregar Acciones</a>
									<span class="bg-gray float-right p-1">Meta: '.$contador.'</span>'
										.$rspta3[$b]["meta_nombre"] .		
									'</p>
									<hr>';

									$data[0] .='
									<div class="table-responsive" id="refrescar_tabla_accion">
										<table class="table compact table-striped table-bordered table-condensed table-hover dataTable no-footer" >
											<thead class="bg-Gray">
												<tr>
												<th scope="col">#</th>
												<th scope="col"><b>Nombre Acción</b></th>
												<th scope="col"><b>Cronograma</b> </th>
												<th scope="col">Opciones</th>
												</tr>
											</thead>
											<tbody>';

												$listaracciones = $SacEjecucion->listaracciones($rspta3[$b]["id_meta"]);// consulta para listas las acciones

												for ($c = 0; $c < count($listaracciones) ; $c++) {
													$fech_max = intval($listaracciones[$c]["fecha_accion"]) - 1;
													$fech_min = intval($listaracciones[$c]["fecha_fin"]) - 1;
																
													$tiempo = "";
													for ($d = $fech_max; $d <= $fech_min; $d++) {
														if($d == $fech_min){
															$tiempo .=  $meses[$d];
														}
														else{
															$tiempo .=  $meses[$d]." - ";
														}
													}


													$data[0] .= '		
													<tr>
														<th scope="row">'.($c+1).'</th>
														
														<td> <b> '.$listaracciones[$c]["nombre_accion"].'</b></td>
														<td>'.$tiempo. '</td>
												
														<td id="terminar_accion" align="right">';
														if($listaracciones[$c]["accion_estado"]==0){
															$data[0] .= '
															<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_accion('.$listaracciones[$c]["id_accion"]. ')" title="marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>   
															<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_accion('.$listaracciones[$c]["id_accion"]. ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
															<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_accion('.$listaracciones[$c]["id_accion"]. ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
														}else{
															$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Acción terminada</span>';
														}
															$data[0] .= '
														</td>
													</tr>
													<tr>';
												}
											$data[0] .= 
											'</tbody>
										</table>
									</div><br>';

								}
							$data[0] .='
							</div>

						</div>

					</div>';
				}

			}	
		echo json_encode($data);
	break;

	case 'mostrar_accion':
		$rspta = $SacEjecucion->mostrar_accion($id_accion);
		echo json_encode($rspta);
	break;
	//eliminar una accion
	case 'eliminar_accion':
		$rspta = $SacEjecucion->eliminar_accion($id_accion);
		echo json_encode($rspta);
	break;

	//terminar una accion
	case 'terminar_accion':
		$rspta = $SacEjecucion->terminar_accion($id_accion);
		echo json_encode($rspta);
	break;
}
?>