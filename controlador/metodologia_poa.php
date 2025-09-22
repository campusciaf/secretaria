<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/MetodologiaPoa.php";
$SacEjecucion = new MetodologiaPoa();
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

// variables post para agregar las tareas.
$nombre_tarea  = isset($_POST["nombre_tarea"]) ? limpiarCadena($_POST["nombre_tarea"]) : "";
$fecha_tarea  = isset($_POST["fecha_tarea"]) ? limpiarCadena($_POST["fecha_tarea"]) : "";
$meta_responsable  = isset($_POST["meta_responsable"]) ? limpiarCadena($_POST["meta_responsable"]) : "";
$id_accion_tarea  = isset($_POST["id_accion_tarea"]) ? limpiarCadena($_POST["id_accion_tarea"]) : "";



switch ($_GET["op"]) {
	case 'guardaryeditaraccion':
		$fecha_accion = date("Y-m-d");
		if (empty($id_accion)) {
			$rspta = $SacEjecucion->insertaraccion($nombre_accion, $id_meta, $fecha_accion, $fecha_fin, $hora_accion);
			echo $rspta ? "Acción registrada" : "Acción no se pudo registrar";
		} else {
			$rspta = $SacEjecucion->editaraccion($id_accion, $nombre_accion, $id_meta, $fecha_accion, $fecha_fin);
			echo $rspta ? "Accion actualizada" : "Accion no se pudo actualizar";
		}
		break;
	case 'listar':
		$periodos = $SacEjecucion->periodoactual();
		$periodo = $periodos["periodo_actual"];
		$periodo_actual = explode("-", $periodo)[0];

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
				$rspta2 = $SacEjecucion->listarproyectousuario($id_proyecto, $_SESSION["id_usuario"], $periodo_actual); // Consultar metas del usuario
				if ($rspta2) {
					$rspta3 = $SacEjecucion->listarmeta($_SESSION["id_usuario"], $id_proyecto, $periodo_actual); // Consultar metas del proyecto
					for ($k = 0; $k < count($rspta3); $k++) {
						$meta = $rspta3[$k];
						$data[0] .= '
								<p>
									<a onclick="agregaraccion(' . $meta["id_meta"] . ')" id="agregar_accion" class="bg-orange float-right p-1" style="cursor:pointer">
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
											<th scope="col" >Opciones</th>
											<th scope="col" >¿Cómo?</th>
											<th scope="col" >¿Cuándo?</th>
											<th scope="col" >Hora</th>
											<th scope="col">Avance Tareas</th>

										</thead>
										<tbody>';
						$listaracciones = $SacEjecucion->listaracciones($meta["id_meta"]);
						for ($l = 0; $l < count($listaracciones); $l++) {
							$accion = $listaracciones[$l];
							$hora = $accion["hora"];
							$id_accion = $accion["id_accion"];
							$hora_formato = date('h:i:s A', strtotime($hora));

							// calculamos el porcentaje de avance 
							$total_tareas = $SacEjecucion->contarTareasPorAccion($id_accion);
							$tareas_finalizadas = $SacEjecucion->contarTareasFinalizadasPorAccion($id_accion);
							$porcentaje = $total_tareas > 0 ? round(($tareas_finalizadas / $total_tareas) * 100) : 0;
							$color_barra = '';
							if ($porcentaje < 50) {
								$color_barra = 'bg-danger'; // rojo
							} elseif ($porcentaje < 100) {
								$color_barra = 'bg-warning'; // amarillo
							} else {
								$color_barra = 'bg-success'; // verde
							}
							$data[0] .= '		
								<tr>
									<th scope="row">' . ($l + 1) . '</th>
									<td class="fs-14">
										<div class="col-12 text-center btn-group">
											<button type="button" class="tooltip-agregar btn bg-purple btn-flat btn-xs" onclick="CrearTarea(' . $id_accion . ')" title="Crear tarea" data-toggle="tooltip" data-placement="top">
												<i class="fas fa-plus-circle"></i> Crear tarea
											</button>
											<button type="button" class="tooltip-agregar btn btn-primary btn-xs" onclick="Visualizar_Tareas(' . $id_accion . ')" title="Visualizar tareas" data-toggle="tooltip" data-placement="top">
												<i class="fas fa-tasks"></i> Visualizar tareas
											</button>
										</div>
									</td>
									<td class="fs-14"><b>' . $accion["nombre_accion"] . '</b></td>
									<td class="fs-14"> <b>Fecha Entrega:</b> ' . $SacEjecucion->fechaesp($accion["fecha_fin"]) . '</td>
									<td class="fs-14" >' . $hora_formato . '</td>
									<td class="fs-14">
										<div class="row">
											<div class="col-12">
												<span class="text-semibold fs-12">' . $porcentaje . '% de Avance</span>
											</div>
											<div class="col-12">
												<div class="progress progress-sm">
													<div class="progress-bar ' . $color_barra . '" style="width: ' . $porcentaje . '%"></div>
												</div>
											</div>
										</div>
									</td>';
							$data[0] .= '</td></tr>';
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

	case "selectListarCargo":
		$rspta = $SacEjecucion->selectlistarCargo();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
		}
		break;
	case 'guardaryeditartarea':
		$periodos = $SacEjecucion->periodoactual();
		$periodo = $periodos["periodo_actual"];
		$periodo_actual = explode("-", $periodo)[0];
		$rspta = $SacEjecucion->insertartarea($nombre_tarea, $fecha_tarea, $meta_responsable, $id_accion_tarea, $periodo_actual);
		echo $rspta ? "Tarea registrada" : "Tarea no se pudo registrar";
		break;


	case 'visualizar_tareas':

		$id_accion = $_POST["id_accion"];
		$data = array();
		$data[0] = "";

		$data[0] .=
			'		
				<table id="mostrartareas" class="table" style="width:100%">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nombre Tarea</th>
				<th scope="col">Fecha entrega</th>
				<th scope="col">Responsable</th>
				<th scope="col">Marcar tarea</th>
				</tr>
				</thead><tbody>';
		$mostrar_tareas = $SacEjecucion->mostrartareas($id_accion);
		for ($n = 0; $n < count($mostrar_tareas); $n++) {
			$nombre_tarea = $mostrar_tareas[$n]["nombre_tarea"];
			$fecha_entrega = $mostrar_tareas[$n]["fecha_entrega"];
			$meta_responsable = $mostrar_tareas[$n]["meta_responsable"];





			$data[0] .= '
				<tr>
					<th scope="row">' . ($n + 1) . '</th>
					<td>' . $nombre_tarea . '</td>
					<td>' . $fecha_entrega . '</td>
					<td>' . $meta_responsable . '</td>
					<td>';
			if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
				$data[0] .= '<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_tarea_accion(' . $mostrar_tareas[$n]["id_tarea_sac"] . ', ' . $id_accion . ')" title="Marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>';
			} else {
				$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
			}
			$data[0] .= '</td>
				</tr>';
		}
		$data[0] .= '</tbody></table>';
		echo json_encode($data[0]);
		break;


	case 'terminar_tarea_accion':
		$id_tarea_sac = $_POST['id_tarea_sac'];
		$rspta = $SacEjecucion->terminar_tarea($id_tarea_sac);
		echo json_encode($rspta);
		break;


		// case 'mostrar_accion':
		// 	$rspta = $SacEjecucion->mostrar_accion($id_accion);
		// 	echo json_encode($rspta);
		// 	break;
		// 	//eliminar una accion
		// case 'eliminar_accion':
		// 	$rspta = $SacEjecucion->eliminar_accion($id_accion);
		// 	echo json_encode($rspta);
		// 	break;
		// 	//terminar una accion
		// case 'terminar_accion':
		// 	$rspta = $SacEjecucion->terminar_accion($id_accion);
		// 	echo json_encode($rspta);
		// 	break;
}
