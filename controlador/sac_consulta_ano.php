<?php 
require_once "../modelos/SacConsultaAno.php";
$ConsultaPoaAno= new SacConsultaAno();

$meses = array( "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre","Noviembre","Diciembre");


/* campos para agregar una ación */
$nombre_accion = isset($_POST["nombre_accion"]) ? limpiarCadena($_POST["nombre_accion"]) : "";
$id_meta  = isset($_POST["id_meta"]) ? limpiarCadena($_POST["id_meta"]) : "";
$fecha_accion = isset($_POST["fecha_accion"]) ? limpiarCadena($_POST["fecha_accion"]) : "";
$fecha_fin  = isset($_POST["fecha_fin"]) ? limpiarCadena($_POST["fecha_fin"]) : "";
$accion_estado  = isset($_POST["accion_estado"]) ? limpiarCadena($_POST["accion_estado"]) : "";
$hora_accion  = isset($_POST["hora_accion"]) ? limpiarCadena($_POST["hora_accion"]) : "";


/* ************************************ */

/* campos para aditar las acciones */
$id_accion  = isset($_POST["id_accion"])? limpiarCadena($_POST["id_accion"]):"";

switch ($_GET["op"]){

	//guardar y editar una accion
	case 'guardaryeditaraccion':
		if (empty($id_accion)) {
			$fecha_accion = date("Y-m-d");
			$rspta = $ConsultaPoaAno->insertaraccion($nombre_accion, $id_meta, $fecha_accion, $fecha_fin, $hora_accion);
			echo $rspta ? "Acción registrada" : "Acción no se pudo registrar";
		} else {
			$rspta = $ConsultaPoaAno->editaraccion($id_accion, $nombre_accion, $id_meta, $fecha_accion, $fecha_fin);
			echo $rspta ? "Accion actualizada" : "Accion no se pudo actualizar";
		}
	break;
	// //listar los nombres de meta por usuario
	case 'buscar':
		$fecha_ano=$_POST["fecha_ano"];
		
		$data[0] = "";
		$data['datosContador'] = "";
		$contadorTabla = 0;
		$rspta = $ConsultaPoaAno->listarproyecto();// lista los proyectos del plan

		
			for ($a = 0; $a < count($rspta) ; $a++) {
				$id_proyecto=$rspta[$a]["id_proyecto"];
				$rspta2=$ConsultaPoaAno->listarproyectousuario($id_proyecto,$_SESSION["id_usuario"]);// consulta para saber si tiene metas en el proyecto
				if($rspta2==true){// si tiene una meta en el proyecto

						$data[0] .='


						<div class="col-12">
					<div class="card card-outline card-primary">
						<div class="card-header">
							<h6 id="nombre_eje" class="card-title fs-20"><b>' . $rspta[$a]["nombre_proyecto"] . '</b></h6>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
							<div class="card-body" style="display: block;">';

							$rspta3=$ConsultaPoaAno->listarmeta($_SESSION["id_usuario"],$rspta2["id_proyecto"],$fecha_ano);// consulta para traer las metas del proyecto
							for ($b = 0; $b < count($rspta3) ; $b++) {
								// $contador=$b+1;
								$contadorTabla++;  // Incrementa el contador de tablas
								$contador = $b + 1;
								$data['datosContador'] .= $contadorTabla;
								$data[0] .='

								<p>
									<a onclick="agregaraccion(' . $rspta3[$b]["id_meta"] . ')" id="agregar_accion" class="bg-orange float-right p-1" style="cursor:pointer">
										<i class="fas fa-plus"></i> Agregar Acciones
									</a>
									<span class="p-1"> 
									
									<button type="button" class="tooltip-agregar btn bg-purple btn-flat btn-xs" title="Agregar metas" data-toggle="tooltip" data-placement="top"><i class="fas fa-flag-checkered"></i></button>
									Meta: ' . $contador . '</span> ' . $rspta3[$b]["meta_nombre"] . '
								</p>
								<hr>';
								$data[0] .='
									<b class="fs-16">Metodología</b>
							<div class="col-12 pt-2">
								<div class="panel-body table-responsive p-4" >
									<table id="refrescar_tabla_accion" class="table" style="width:100%">
										<thead class="text-center">
											<th scope="col" class="col-1" style="width: 50px;"># Acción</th>
											<th scope="col" >¿Cómo?</th>
											<th scope="col" >¿Cuándo?</th>
											<th scope="col" >Hora</th>
											<th scope="col" >Opciones</th>
										</thead>
										<tbody>';

										$listaracciones = $ConsultaPoaAno->listaracciones($rspta3[$b]["id_meta"]);
										for ($c = 0; $c < count($listaracciones); $c++) {
												$accion = $listaracciones[$c];
												$hora = $accion["hora"];
												$hora_formato = date('h:i:s A', strtotime($hora));
												$data[0] .= '		
													<tr>
														<th scope="row">' . ($c + 1) . '</th>
														<td class="fs-14"><b>' . $accion["nombre_accion"] . '</b></td>
														<td class="fs-14"> <b>Fecha Entrega:</b> '. $ConsultaPoaAno-> fechaesp($accion["fecha_fin"]).'</td>
														<td class="fs-14" >' . $hora_formato . '</td>
														
														<td align="right">';
														if($listaracciones[$c]["accion_estado"]==0){
															$data[0] .= '
															<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_accion('.$listaracciones[$c]["id_accion"]. ')" title="marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>   
															<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_accion('.$listaracciones[$c]["id_accion"]. ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
															<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_accion('.$listaracciones[$c]["id_accion"]. ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
														}else{
															$data[0] .= '<span class="badge-success badge p-1"><i class="fas fa-check-double"></i> Acción terminada</span>';
														}
														$data[0] .= '
													</td>
														
														';

														
												$data[0] .= '</td></tr>';
											}
												$data[0] .= '
										</tbody>
									</table>
								</div>
							</div>';


											// $listaracciones = $ConsultaPoaAno->listaracciones($rspta3[$b]["id_meta"]);// consulta para listas las acciones
											// for ($c = 0; $c < count($listaracciones) ; $c++) {
											// 	$fech_max = intval($listaracciones[$c]["fecha_accion"]) - 1;
											// 	$fech_min = intval($listaracciones[$c]["fecha_fin"]) - 1;											
											// 	$tiempo = "";
											// 	for ($d = $fech_max; $d <= $fech_min; $d++) {
											// 		if($d == $fech_min){
											// 			$tiempo .=  $meses[$d];
											// 		}
											// 		else{
											// 			$tiempo .=  $meses[$d]." - ";
											// 		}
											// 	}
											// 	$data[0] .= '		
											// 	<tr>
											// 		<td scope="row">'.($c+1).'</td>
											// 		<td class="text-semibold fs-16 parrafo-normal"> <b> '.$listaracciones[$c]["nombre_accion"].'</b></td>
											// 		<td class="text-semibold fs-16 parrafo-normal">'.$tiempo. '</td>
											// 		<td class="text-semibold fs-16 parrafo-normal">'.$tiempo. '</td>
											// 		<td align="right">';
											// 			if($listaracciones[$c]["accion_estado"]==0){
											// 				$data[0] .= '
											// 				<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_accion('.$listaracciones[$c]["id_accion"]. ')" title="marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>   
											// 				<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_accion('.$listaracciones[$c]["id_accion"]. ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
											// 				<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_accion('.$listaracciones[$c]["id_accion"]. ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
											// 			}else{
											// 				$data[0] .= '<span class="badge-success badge p-1"><i class="fas fa-check-double"></i> Acción terminada</span>';
											// 			}
											// 			$data[0] .= '
											// 		</td>
											// 	</tr>
											// 	';
											// }
								// $data[0] .= '</tbody>';
								// $data[0] .= '</table>';
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
		$rspta = $ConsultaPoaAno->mostrar_accion($id_accion);
		echo json_encode($rspta);
	break;
	//eliminar una accion
	case 'eliminar_accion':
		$rspta = $ConsultaPoaAno->eliminar_accion($id_accion);
		echo json_encode($rspta);
	break;

	//terminar una accion
	case 'terminar_accion':
		$rspta = $ConsultaPoaAno->terminar_accion($id_accion);
		echo json_encode($rspta);
	break;
}
?>