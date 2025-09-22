<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/MetodologiaPoaGeneral.php";
$SacEjecucion = new MetodologiaPoaGeneral();
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
/* campos para agregar una ación */
$nombre_accion = isset($_POST["nombre_accion"]) ? limpiarCadena($_POST["nombre_accion"]) : "";
$id_meta  = isset($_POST["id_meta"]) ? limpiarCadena($_POST["id_meta"]) : "";
$fecha_accion = isset($_POST["fecha_accion"]) ? limpiarCadena($_POST["fecha_accion"]) : "";
$fecha_fin  = isset($_POST["fecha_fin"]) ? limpiarCadena($_POST["fecha_fin"]) : "";
$accion_estado  = isset($_POST["accion_estado"]) ? limpiarCadena($_POST["accion_estado"]) : "";
$hora_accion  = isset($_POST["hora_accion"]) ? limpiarCadena($_POST["hora_accion"]) : "";
/* ************************************ */
/* campos para aditar las acciones */
$id_accion  = isset($_POST["id_accion"]) ? limpiarCadena($_POST["id_accion"]) : "";
/* ************************************ */
// $nombre_accion = isset($_POST["nombre_accion"])? limpiarCadena($_POST["nombre_accion"]):"";
// $meta_responsable = isset($_POST["meta_responsable"])? limpiarCadena($_POST["meta_responsable"]):"";
// $id_objetivo_especifico = isset($_POST["id_objetivo_especifico"])? limpiarCadena($_POST["id_objetivo_especifico"]):"";
// $evidencia_imagen  = isset($_POST["evidencia_imagen"])? limpiarCadena($_POST["evidencia_imagen"]):"";
// $validado_por  = isset($_POST["validado_por"])? limpiarCadena($_POST["validado_por"]):"";
// $validacion  = isset($_POST["validacion"])? limpiarCadena($_POST["validacion"]):"";
//echo " ---".$id_meta;
switch ($_GET["op"]) {
	case 'guardaryeditaraccion':
		$fecha_accion = date("Y-m-d");
		if (empty($id_accion)) {
			$rspta = $SacEjecucion->insertaraccion($nombre_accion, $id_meta, $fecha_accion, $fecha_fin, $hora_accion);
			echo $rspta ? "Acción registrada" : "Acción no se pudo registrar";
		} else {
			$rspta = $SacEjecucion->editaraccion($id_accion, $nombre_accion, $fecha_accion, $fecha_fin, $hora_accion);
			echo $rspta ? "Accion actualizada" : "Accion no se pudo actualizar";
		}
		break;
	case 'listar':
        $id_usuario=$_POST["id_usuario"];

		$periodo_actual = "2025";
		$rspta = $SacEjecucion->listarproyecto();
		$data[0] = "";
		$ejes = [];
		for ($i = 0; $i < count($rspta); $i++) {
			$id_ejes = $rspta[$i]["id_ejes"];
			if (!isset($ejes[$id_ejes])) {
				$ejes[$id_ejes] = [
					"nombre_eje" => "",
					"proyectos" => []
				];
				switch ($id_ejes) {
					case 1:
						$ejes[$id_ejes]["nombre_eje"] = "Eje 01 CIAF en la cultura de la calidad académica";
						break;
					case 2:
						$ejes[$id_ejes]["nombre_eje"] = "Eje 02 CIAF en la Cultura del Conocimiento";
						break;
					case 3:
						$ejes[$id_ejes]["nombre_eje"] = "Eje 03 CIAF en la Cultura de la Transformación Social";
						break;
					case 4:
						$ejes[$id_ejes]["nombre_eje"] = "Eje 04 CIAF en la Cultura del Desarrollo Organización";
						break;
				}
			}
			$ejes[$id_ejes]["proyectos"][] = $rspta[$i];
		}
		$contador = 1;
		foreach ($ejes as $id_ejes => $eje) {
			$data[0] .= '
				<div class="col-12">
					<div class="card card-outline card-primary">
						<div class="card-header">
							<h6 id="nombre_eje" class="card-title fs-20"><b>' . $eje["nombre_eje"] . '</b></h6>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body" style="display: block;">';
			for ($j = 0; $j < count($eje["proyectos"]); $j++) {
				$proyecto = $eje["proyectos"][$j];
				$id_proyecto = $proyecto["id_proyecto"];
				$rspta2 = $SacEjecucion->listarproyectousuario($id_proyecto, $id_usuario, $periodo_actual); // Consultar metas del usuario
				if ($rspta2) {
					$rspta3 = $SacEjecucion->listarmeta($id_usuario, $id_proyecto, $periodo_actual); // Consultar metas del proyecto
					for ($k = 0; $k < count($rspta3); $k++) {
						$meta = $rspta3[$k];
						$data[0] .= '
								<p>
									<a onclick="agregaraccion(' . $meta["id_meta"] . ', '.$id_usuario.')" id="agregar_accion" class="bg-orange float-right p-1" style="cursor:pointer">
										<i class="fas fa-plus"></i> Agregar Acciones
									</a>
									<span class="p-1"> 
									
									<button type="button" class="tooltip-agregar btn bg-purple btn-flat btn-xs" title="Agregar metas" data-toggle="tooltip" data-placement="top"><i class="fas fa-flag-checkered"></i></button>
									Meta: ' . $contador . '</span> ' . $meta["meta_nombre"] . '
								</p>
								<hr>';
						$contador++;
						$data[0] .= '
							<b class="fs-16">Metodología</b>
							<div class="col-12 pt-2">
								<div class="panel-body table-responsive p-4" >
									<table id="refrescar_tabla_accion" class="table" style="width:100%">
										<thead class="text-center">
											<th scope="col" class="col-1" style="width: 50px;"># Acción</th>
											<th scope="col" >¿Cómo?</th>
											<th scope="col" >¿Cuándo?</th>
											<th scope="col" >Hora</th>
											<th style="width:100px"></th>
										</thead>
										<tbody>';
											$listaracciones = $SacEjecucion->listaracciones($meta["id_meta"]);
											for ($l = 0; $l < count($listaracciones); $l++) {
												$id_accion=$listaracciones[$l]["id_accion"];
												$accion = $listaracciones[$l];
												$hora = $accion["hora"];
												$hora_formato = date('h:i:s A', strtotime($hora));
												$data[0] .= '		
													<tr>
														<th scope="row">' . ($l + 1) . '</th>
														<td class="fs-14"><b>' . $accion["nombre_accion"] . '</b></td>
														<td class="fs-14"> <b>Fecha Entrega:</b> '. $SacEjecucion-> fechaesp($accion["fecha_fin"]).'</td>
														<td class="fs-14" >' . $hora_formato . '</td>
														<td>
															<a onclick="editaraccion(' . $id_accion . ', '.$id_usuario.')" title="editar accion" class="bg-orange p-1" style="cursor:pointer">
																<i class="fas fa-edit"></i>
															</a>
															<a onclick="eliminar_accion(' . $id_accion . ', '.$id_usuario.')" title="eliminar accion" class="bg-danger p-1" style="cursor:pointer">
																<i class="fas fa-trash"></i>
															</a>
														</td>';
															$data[0] .= '
														</td>
													</tr>';
											}
											$data[0] .= '
										</tbody>
									</table>
								</div>
							</div>';
					}
				}
			}
			$data[0] .= '</div></div></div>';
		}
		echo json_encode($data);
		break;
		case 'mostrar_accion':
			$id_accion=$_POST["id_accion"];
			$rspta = $SacEjecucion->mostrar_accion($id_accion);
			echo json_encode($rspta);
		break;
		// 	//eliminar una accion
		case 'eliminar_accion':
			$id_accion=$_POST["id_accion"];
			$rspta = $SacEjecucion->eliminar_accion($id_accion);
			echo json_encode($rspta);
		break;
		// 	//terminar una accion
		// case 'terminar_accion':
		// 	$rspta = $SacEjecucion->terminar_accion($id_accion);
		// 	echo json_encode($rspta);
		// 	break;

        case "selectUsuario":
            $rspta = $SacEjecucion->selectUsuario();
            echo "<option value='' selected disabled>" . $usuario_nombre . "</option>";
            for ($i = 0; $i < count($rspta); $i++) {
                $nombre_completo = $rspta[$i]["usuario_nombre"] . " " . $rspta[$i]["usuario_nombre_2"] . " " . $rspta[$i]["usuario_apellido"] . " " . $rspta[$i]["usuario_apellido_2"];
                $usuario_nombre = mb_convert_case(mb_strtolower($nombre_completo, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $usuario_nombre . "</option>";
            }
        break;



}
