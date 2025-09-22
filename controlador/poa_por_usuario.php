<?php
require_once "../modelos/PoaPorUsuario.php";
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$poa_por_usuario = new PoaPorUsuario();
$fecha = date('Y-m-d');
$hora = date('H:i:s');



$id_usuario = $_SESSION['id_usuario'];
$id_ejes = isset($_POST["id_ejes"]) ? limpiarCadena($_POST["id_ejes"]) : "";
$nombre_proyecto = isset($_POST["nombre_proyecto"]) ? limpiarCadena($_POST["nombre_proyecto"]) : "";
$id_proyecto  = isset($_POST["id_proyecto"]) ? limpiarCadena($_POST["id_proyecto"]) : "";
$nombre_eje = isset($_POST["nombre_eje"]) ? limpiarCadena($_POST["nombre_eje"]) : "";
$total_meta  = isset($_POST["total_meta"]) ? limpiarCadena($_POST["total_meta"]) : "";
$id_meta  = isset($_POST["id_meta"]) ? limpiarCadena($_POST["id_meta"]) : "";
$total_acciones  = isset($_POST["total_acciones"]) ? limpiarCadena($_POST["total_acciones"]) : "";
// $id_meta  = isset($_POST["id_meta"])? limpiarCadena($_POST["id_meta"]):"";
$meta_nombre  = isset($_POST["meta_nombre"]) ? limpiarCadena($_POST["meta_nombre"]) : "";
$nombre_objetivo  = isset($_POST["nombre_objetivo"]) ? limpiarCadena($_POST["nombre_objetivo"]) : "";
$id_objetivo  = isset($_POST["id_objetivo"]) ? limpiarCadena($_POST["id_objetivo"]) : "";
$id_objetivo_especifico  = isset($_POST["id_objetivo_especifico"]) ? limpiarCadena($_POST["id_objetivo_especifico"]) : "";
$condicion_programa   = isset($_POST["condicion_programa"]) ? limpiarCadena($_POST["condicion_programa"]) : "";
$condicion_institucional  = isset($_POST["condicion_institucional"]) ? limpiarCadena($_POST["condicion_institucional"]) : "";
$dependencias  = isset($_POST["dependencias"]) ? $_POST["dependencias"] : "";
$meta_fecha = isset($_POST["meta_fecha"]) ? limpiarCadena($_POST["meta_fecha"]) : "";
$meta_responsable = isset($_POST["meta_responsable"]) ? limpiarCadena($_POST["meta_responsable"]) : "";
$anio_eje = isset($_POST["anio_eje"]) ? limpiarCadena($_POST["anio_eje"]) : "";
$evidencia_imagen = isset($_POST["evidencia_imagen"]) ? limpiarCadena($_POST["evidencia_imagen"]) : "";
$id_objetivo = isset($_POST["id_objetivo"]) ? limpiarCadena($_POST["id_objetivo"]) : "";
$id_accion  = isset($_POST["id_accion"]) ? limpiarCadena($_POST["id_accion"]) : "";
$nombre_accion  = isset($_POST["nombre_accion"]) ? limpiarCadena($_POST["nombre_accion"]) : "";
$fecha_accion  = isset($_POST["fecha_accion"]) ? limpiarCadena($_POST["fecha_accion"]) : "";
$fecha_fin  = isset($_POST["fecha_fin"]) ? limpiarCadena($_POST["fecha_fin"]) : "";
// variables indicadores
$indicador_inserta  = isset($_POST["indicador_inserta"]) ? limpiarCadena($_POST["indicador_inserta"]) : "";
$puntaje_anterior  = isset($_POST["puntaje_anterior"]) ? limpiarCadena($_POST["puntaje_anterior"]) : "";
$puntaje_actual  = isset($_POST["puntaje_actual"]) ? limpiarCadena($_POST["puntaje_actual"]) : "";
$indicador_sin_formula  = isset($_POST["indicador_sin_formula"]) ? limpiarCadena($_POST["indicador_sin_formula"]) : "";
$indicador_formula_o_sin_formula  = isset($_POST["indicador_formula_o_sin_formula"]) ? limpiarCadena($_POST["indicador_formula_o_sin_formula"]) : "";
// valores indicadores de participacion 
$participa  = isset($_POST["participa"]) ? limpiarCadena($_POST["participa"]) : "";
$poblacion  = isset($_POST["poblacion"]) ? limpiarCadena($_POST["poblacion"]) : "";
$select_tipo_indicador  = isset($_POST["indicador"]) ? limpiarCadena($_POST["indicador"]) : "";
// Cumplimiento de las metas
$meta_lograda  = isset($_POST["meta_lograda"]) ? limpiarCadena($_POST["meta_lograda"]) : "";
$nombre_proyectos  = isset($_POST["nombre_proyectos"]) ? limpiarCadena($_POST["nombre_proyectos"]) : "";
$plan_mejoramiento  = isset($_POST["plan_mejoramiento"]) ? limpiarCadena($_POST["plan_mejoramiento"]) : "";
switch ($_GET["op"]) {

		// listamos el cargo 
	case "selectListarCargo":
		$rspta = $poa_por_usuario->selectlistarCargo();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
		}
		break;
		// listamos las condiciones institucionales
	case 'condiciones_institucionales':
		$rspta = $poa_por_usuario->listarCondicionesInstitucionales();
		//Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
		for ($i = 0; $i < count($rspta); $i++) {
			echo '<input class="form-check-input" type="checkbox" name="condicion_institucional[]" id="check_' . $i . '" value="' . $rspta[$i]["id_condicion_institucional"] . '" >
				<label class="form-check-label " for="check_' . $i . '">' . $rspta[$i]["nombre_condicion"] . '</label> <br>	';
		}
		break;
		// listamos las condiciones de programa
	case 'condiciones_programa':
		$rspta = $poa_por_usuario->listarCondicionesPrograma();
		//Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
		for ($i = 0; $i < count($rspta); $i++) {
			echo '<input class="form-check-input " type="checkbox" name="condicion_programa[]" id="check_pro_' . $i . '" value="' . $rspta[$i]["id_condicion_programa"] . '" >
				<label class="form-check-label" for="check_pro_' . $i . '">' . $rspta[$i]["nombre_condicion"] . '</label> <br> 	';
		}
		break;
	case 'listar':
		$id_ejes = $_GET["id_ejes"];
		$globalperidioseleccionado = $_GET["globalperidioseleccionado"];
		$rspta = $poa_por_usuario->listarproyecto($id_ejes);
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$total_metas = $poa_por_usuario->listarMetaProyectosPorUsuario($reg[$i]["id_proyecto"], $globalperidioseleccionado, $id_usuario);
			$poa_por_usuario_nombre =  $reg[$i]["nombre_proyecto"];
			$id_proyecto = $reg[$i]["id_proyecto"];
			$data[] = array(
				"0" => $poa_por_usuario_nombre,
				"1" => '
					<div class="col-12 text-center"> 	
						<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="listar_metas(`' . $reg[$i]["id_proyecto"] . '`)" title="Ver Meta">' . count($total_metas) . ' </a>
					</div>
					',
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'listar_metas':
		$globalperidioseleccionado = $_POST["globalperidioseleccionado"];
		$nombre_meta = $poa_por_usuario->listarMetaProyectosPorUsuario($id_proyecto, $globalperidioseleccionado, $id_usuario);
		$data[0] = "";
		$data[0] .= '<div class="row">';
		for ($f = 0; $f < count($nombre_meta); $f++) {
			$contador = $f + 1;
			$id_meta = $nombre_meta[$f]["id_meta"];
			$meta = $nombre_meta[$f]["meta_nombre"];
			$fecha_entrega = $nombre_meta[$f]["meta_fecha"];
			$responsable = $nombre_meta[$f]["meta_responsable"];
			$usuario_cargo = $nombre_meta[$f]["usuario_cargo"];
			$data[0] .= '
						<div class="col-xl-6">
							<div class="cards border m-3 p-3">
								<div class="row d-block">
									<div class="float-md-right">
										<button onclick="listar_marcadas_meta(' . $nombre_meta[$f]["id_meta"] . ')" class="btn btn-primary btn-xs" title="Editar Meta" data-toggle="tooltip" data-placement="top"> <i class="fas fa-pencil-alt"></i> </button>
										<button onclick="eliminar_meta(' . $nombre_meta[$f]["id_meta"] . ', ' . $id_proyecto . ')" class="btn btn-danger btn-xs" title="Eliminar Meta" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
									</div>
								</div><br><br>
								<div class="bg-warning p-2">
									<p>' . $contador . ' . ' . $meta . '</p>
								</div>
								<div class="card-footer p-0">
									<ul class="nav flex-column">
										<li class="nav-item p-2">
											Fecha de Entrega: <span class="float-right"></span>
										</li>
										<li class="nav-item p-2">
											Responsable: <span class="float-right">' . $usuario_cargo . '</span>
										</li>
										<li class="nav-item p-2">';
			$condicionesinstitucionales = $poa_por_usuario->listarCondicionInstitucionalMeta($id_meta);
			$data[0] .= '
												Condiciones institucionales:</span>
												<span class="float-right bg-success badge">' . count($condicionesinstitucionales) . '</span>';
			for ($ci = 0; $ci < count($condicionesinstitucionales); $ci++) {
				$nombre_condicion = $condicionesinstitucionales[$ci]["nombre_condicion"];
				$data[0] .= '<br><span class="small">' . $nombre_condicion . '</span>';
			}
			$data[0] .= '	
										</li>
										<li class="nav-item p-2">';
			$condicionesdeprograma = $poa_por_usuario->listarCondicionProgramaMeta($id_meta);
			$data[0] .= '
												Condiciones de programa:</span>	
												<span class="float-right bg-success badge ">' . count($condicionesdeprograma) . '</span>';
			for ($cp = 0; $cp < count($condicionesdeprograma); $cp++) {
				$nombre_programa = $condicionesdeprograma[$cp]["nombre_condicion"];
				$data[0] .= '<br><span class="small">' . $nombre_programa . '</span>';
			}
			$data[0] .= '			
										</li>
										<li class="nav-item p-2">';
			$corresponsabilidades = $poa_por_usuario->listarcondicionesdependencia($id_meta);
			$data[0] .= '
												Corresponsables:</span>
												<span class="float-right bg-success badge ">' . count($corresponsabilidades) . '</span>';
			for ($co = 0; $co < count($corresponsabilidades); $co++) {
				$nombre = $corresponsabilidades[$co]["nombre"];
				$data[0] .= '<br><span class="small">' . $nombre . '</span>';
			}
			$data[0] .= '
										</li>';
			$data[0] .= '
										<li class="nav-item p-2">
										<h5><b>Acciones Por Meta</b></h5>';
			$listaracciones = $poa_por_usuario->listaracciones($id_meta); // consulta para listas las acciones
			// print_r($listaracciones);
			for ($c = 0; $c < count($listaracciones); $c++) {
				$fech_max = intval($listaracciones[$c]["fecha_accion"]) - 1;
				$fech_min = intval($listaracciones[$c]["fecha_fin"]) - 1;
				$tiempo = "";
				for ($d = $fech_max; $d <= $fech_min; $d++) {
					if ($d == $fech_min) {
						$tiempo .=  $meses[$d];
					} else {
						$tiempo .=  $meses[$d] . " - ";
					}
				}
				$data[0] .= '<b>' . ($c + 1) . ' - ' . $listaracciones[$c]["nombre_accion"] . '</b><br>
															<span class="small">' . $tiempo . '</span>
													<span class="float-right">';
				if ($listaracciones[$c]["accion_estado"] == 0) {
					$data[0] .= '
															<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_accion(' . $listaracciones[$c]["id_accion"] . ')" title="marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>   
															';
				} else {
					$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
				}
				$data[0] .= '
							</span>
							<hr>';
			}
			$data[0] .=
				'</li>
							</ul>
						</div>
					</div>	
				</div>';
		}
		$data[0] .= '</div>';
		echo json_encode($data);
		break;
	case 'listar_ejes':
		$anio = "";
		if (isset($_POST['periodoSeleccionado'])) {
			$anio = $_POST['periodoSeleccionado'];
		}
		$data[0] = "";

		$data[0] .= '
		<div class="col-12 text-center py-4">
			<h3 class="titulo-3 text-bold fs-24">¿nuestra  <span class="text-gradient">visión para </span> el <span class="text-gradient"> 2030?</span></h3>
			<p class="lead text-secondary line-height-18"> seremos una institución de educación superior reconocida en la sociedad por su creatividad e innovación </p>
		</div>';
		$ejes = $poa_por_usuario->listar();
		$contador_metas = 0;
		$contador_acciones = 0;
		$cantidad_metas_grafica = 0;
		$data[0] .= '
		<div class="row">';
		for ($a = 0; $a < count($ejes); $a++) {
			$contador_metas = 0;
			$contador_acciones = 0;
			$id_ejes = $ejes[$a]["id_ejes"];
			$nombre_eje = $ejes[$a]["nombre_ejes"];
			$total_proyectos = $poa_por_usuario->listarproyecto($id_ejes);
			$totalCumplidas = 0;
			for ($b = 0; $b < count($total_proyectos); $b++) {
				$total_metas = $poa_por_usuario->totalMetasPorProyecto($total_proyectos[$b]["id_proyecto"], $anio, $id_usuario);
				for ($c = 0; $c < count($total_metas); $c++) {
					$totalCumplidas = ($total_metas[$c]["estado_meta"] == 1) ? $totalCumplidas + 1 : $totalCumplidas;
					$contador_metas++;
					$data[0] .= '';
					$total_acciones = $poa_por_usuario->totalaccionesporeje($total_metas[$c]["id_meta"]);
					$contador_acciones = $contador_acciones + count($total_acciones);
					$total_acciones = $poa_por_usuario->totalaccionesporeje($total_metas[$c]["id_meta"]);
				}
			}
			$totalNoCumplidas = $contador_metas - $totalCumplidas;
			if ($contador_metas != 0) {
				$porcentaje_cumplidas = ($totalCumplidas * 100) / $contador_metas;
			} else {
				$porcentaje_cumplidas = 0;
				$porcentaje_nocumplidas = 100;
			}
			$porcentaje_cumplidas = number_format((float)$porcentaje_cumplidas, 2, '.', '');
			$porcentaje_nocumplidas =  100 - $porcentaje_cumplidas;
			$porcentaje_nocumplidas = number_format((float)$porcentaje_nocumplidas, 2, '.', '');
			$partes = explode(" ", $nombre_eje, 3);
			$parte1 = $partes[0] . " " . $partes[1];
			$parte2 = $partes[2];
			$data[0] .= '
			<div class="col-xl-3 col-lg-6 col-md-6 col-12">
				<div class="card" id="card_para_eje">
					<div class="col-12 p-1 tono-3 py-3" id="ocultargestionproyecto">
						<div class="row align-items-center" id="tour_titulo_eje">
							<div class="col-auto pl-4"> <!-- Clase col-auto para el ícono -->
								<span class="rounded bg-light-blue p-3 text-primary ">
									<i class="fa-solid fa-gear"></i>
								</span>
							</div>
							<div class="col-8"> 
								<div class="line-height-18">
									<span class="titulo-2 fs-20 text-semibold">' . $parte1 . '</span> <br>
									<span class="fs-14">' . $parte2 . '</span> 
								</div> 
							</div> 
						</div>
					</div>	
					<div class="col-12" >
						<div class="col-12 text-center p-4">
							<div class="doughnutchart my-4" id="tour_chart">
								<canvas id="chart' . $id_ejes . '" class="responsive-canvas"></canvas>
								<div class="countvalue">
									<div class="w-100">
										<h5 class="mb-1" >' . $contador_metas . '</h5>
										<p class="text-success small" id="tour_cumplidas">' . $totalCumplidas . ' (' . $porcentaje_cumplidas . ' %)</p>
										<p class="text-danger small" id="tour_no_cumplidas">' . $totalNoCumplidas . ' (' . $porcentaje_nocumplidas . '%)</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4 col-md-4 mb-3">
								<div class="row justify-content-center cursor-pointer" onclick="listar(' . $id_ejes . ')" id="tour_proyectos_eje">
									<div class="col-12 text-center">
										<div class="avatar avatar-50 rounded bg-light-yellow">
											<i class="fa-solid fa-diagram-project fa-2x text-warning"></i>
										</div>
									</div>
									<div class="col-12 text-center pt-2">
										<span class="titulo-2 fs-16 line-height-16 text-semibold">' . count($total_proyectos) . " " . '</span><br>
										<span class="fs-14">Proyectos</span>
									</div>
								</div>
							</div>
							<div class="col-4 col-md-4 mb-3">
								<div class="row justify-content-center cursor-pointer" onclick="listarmetas(' . $id_ejes . ')" id="tour_metas_eje">
									<div class="col-12 text-center">
										<div class="avatar avatar-50 rounded bg-light-blue">
											<i class="fa-solid fa-flag-checkered fa-2x text-primary"></i>
										</div>
									</div>
									<div class="col-12 text-center pt-2">
										<span class="titulo-2 fs-16 line-height-16 text-semibold">' . $contador_metas . " " . '</span><br>
										<span class="fs-14 ">Metas</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';
		}
		$data[0] .= '
			</div>';
		echo json_encode($data);
		break;
	case "selectListarProyectos":
		$id_ejes = isset($_POST["id_ejes"]) ? $_POST["id_ejes"] : "";
		$rspta = $poa_por_usuario->selectlistarProyectos($id_ejes);
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_proyecto"] . "'>" . $rspta[$i]["nombre_proyecto"] . "</option>";
		}
		break;
	case 'guardarcreoyeditometa':
		$id_condiciones_pro = [];
		$id_concondiciones_ins = [];
		$id_dependencias = [];
		if (is_array($condicion_programa)) {
			foreach ($condicion_programa as $id_con_pro) {
				$id_condiciones_pro[] = $id_con_pro;
			}
		}
		if (is_array($condicion_institucional)) {
			foreach ($condicion_institucional as $id_con_ins) {
				$id_concondiciones_ins[] = $id_con_ins;
			}
		}
		if (is_array($dependencias)) {
			foreach ($dependencias as $id_con_dep) {
				$id_dependencias[] = $id_con_dep;
			}
		}
		if (empty($id_meta)) {
			$rspta = $poa_por_usuario->saccrearmeta($plan_mejoramiento,$meta_nombre, $meta_fecha, $meta_responsable, $nombre_proyectos, $id_concondiciones_ins, $id_condiciones_pro, $id_dependencias, $anio_eje);
			echo $rspta ? "meta registrada" : "meta no se pudo registrar";
		} else {
			$rspta = $poa_por_usuario->saceditometa($id_meta,$plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_concondiciones_ins, $id_condiciones_pro, $id_dependencias, $anio_eje);
			echo $rspta ? "meta actualizada" : "meta no se pudo actualizar";
		}
		break;
	case 'mostrargraficosmeta':
		$id_ejes_graficos = $_POST["id_ejes"];
		$anio = "";
		if (isset($_POST['globalperidioseleccionado'])) {
			$anio = $_POST['globalperidioseleccionado'];
		}
		$total_ejes_grafico = $poa_por_usuario->mostrar_eje_grafico($id_ejes_graficos);
		$total_ejes_grafico = $poa_por_usuario->mostrar_eje_grafico($id_ejes_graficos);
		$id_proyectos_array = [];
		foreach ($total_ejes_grafico as $fila) {
			// Acceder a la columna 'id_proyecto'
			$id_proyectos_array[] = $fila['id_proyecto'];
		}
		// Convertir el array a una cadena
		$id_proyectos_graficas = implode(",", $id_proyectos_array);
		$metasCumplidas = $poa_por_usuario->total_metas_grafica_cumplidas($id_proyectos_graficas, $anio, $id_usuario);
		$metasNoCumplidas = $poa_por_usuario->total_metas_grafica_no_cumplidas($id_proyectos_graficas, $anio, $id_usuario);
		$metas = $poa_por_usuario->totalmetas($anio, $id_usuario);
		// print_r($metas);
		$total_metas = count($metas);
		$total_metas_cumplidas = $metasCumplidas;
		$total_metasNoCumplidas = $metasNoCumplidas;
		$data = array();
		// datos para la grafica 2
		$data["datos_grafico2"] = [];
		$totalmetasporejes = $poa_por_usuario->totalmetasporejes($id_proyectos_graficas, $anio, $id_usuario);
		if (is_array($totalmetasporejes)) {
			foreach ($totalmetasporejes as $metasporeje) {
				$nombre_proyecto = $metasporeje["nombre_proyecto"];
				$data["datos_grafico2"][] = array("y" => $total_metasNoCumplidas, "name" => $nombre_proyecto);
			}
		}
		// Datos para la grafica de las metas cumplidas y no cumplidas
		$data["datos_grafico"] = [];
		// Agregar metas cumplidas (ya no se necesita count())
		$data["datos_grafico"][] = array("y" => $total_metas_cumplidas);
		// Agregar metas no cumplidas (ya no se necesita count())
		$data["datos_grafico"][] = array("y" => $total_metasNoCumplidas);
		echo json_encode($data);
		break;
	case 'listarmetas':
		$id_ejes = $_GET["id_ejes"];
		$anio = $_GET["globalperidioseleccionado"];
		// lista las metas
		$rspta	= $poa_por_usuario->totaldemetas($id_ejes, $anio, $id_usuario);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		$total_cumplidas = 0;
		for ($i = 0; $i < count($reg); $i++) {
			$color_estado = array('0' => 'badge-warning', '1' => 'badge-success');
			$icono_estado = array('0' => 'fas fa-exclamation-triangle', '1' => 'fas fa-check');
			$total_cumplidas = ($reg[$i]["estado_meta"] == 1) ? $total_cumplidas + 1 : $total_cumplidas;
			$acciones = $poa_por_usuario->listaracciones($reg[$i]["id_meta"]);
			//cuenta el total de las metas
			$meta_nombre =  $reg[$i]["meta_nombre"];
			$total_metas = $poa_por_usuario->listarMetaProyectosPorUsuario($reg[$i]["id_proyecto"], $anio, $id_usuario);
			$poa_por_usuario_nombre =  $reg[$i]["nombre_proyecto"];
			$data[] = array(
				"0" => "
					<div class='col-12 text-center'>
						<span class='badge " . $color_estado[$reg[$i]["estado_meta"]] . "'>
							<i class='" . $icono_estado[$reg[$i]["estado_meta"]] . "'></i> 
						</span>
					</div>",
				"1" => $meta_nombre,
				"2" => $poa_por_usuario_nombre,
				"3" =>
				'<div class="col-12 text-center"> 	
					<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="listar_proyecto_accion(' . $reg[$i]["id_meta"] . ')" title="Ver Meta">' . count($acciones) . ' </a>
				</div>',
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data,
			"totalMetas" => $i,
			"totalCumplidas" => $total_cumplidas,
			"totalNoCumplidas" => $i - $total_cumplidas
		);
		echo json_encode($results);
		break;
	case 'listar_proyecto_accion':
		$data[0] = "";
		$rspta_meta	= $poa_por_usuario->listaracciones($id_meta);
		for ($p = 0; $p < count($rspta_meta); $p++) {
			$data[0] .= '
			<table class="table  table-responsive">
				<tbody> 	
					<tr>
						<td>' . $rspta_meta[$p]["nombre_accion"] . '</td>
						
					</tr>
				</tbody>
			</table>';
		}
		echo json_encode($data);
		break;
		//ver el total de las metas cumplidas y las no cumplidas
	case 'ver_total_metas_cumplidas':
		$anio = $_POST['globalperidioseleccionado'];
		$metas = $poa_por_usuario->totalmetas($anio);
		$total_metas = count($metas);
		$metasCumplidas = $poa_por_usuario->obtenerNumeroMetasCumplidas($anio);
		$total_metas_cumplidas = ($metasCumplidas / $total_metas) * 100;
		$metasNoCumplidas = $poa_por_usuario->obtenerNumeroMetasNoCumplidas($anio);
		$total_metasNoCumplidas = ($metasNoCumplidas / $total_metas) * 100;
		$data = array();
		$data["datos_grafico"] = [];
		// Agregar metas cumplidas (ya no se necesita count())
		$data["datos_grafico"][] = array("y" => $total_metas_cumplidas, "name" => "Metas Cumplidas");
		// Agregar metas no cumplidas (ya no se necesita count())
		$data["datos_grafico"][] = array("y" => $total_metasNoCumplidas, "name" => "Metas No Cumplidas");
		echo json_encode($data);
		break;
	case "selectListarEjes":
		$rspta = $poa_por_usuario->selectlistarEjes();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_ejes"] . "'>" . $rspta[$i]["nombre_ejes"] . "</option>";
		}
		break;
	case 'listar_marcadas_meta':
		$data = $poa_por_usuario->mostrar_meta($id_meta);
		$marcados = $poa_por_usuario->listarCondicionInstitucionalMarcada($id_meta);
		for ($i = 0; $i < count($marcados); $i++) {
			$data["condicion_institucional"][] = $marcados[$i]["id_con_ins"];
		}
		$marcados = $poa_por_usuario->listarCondicionProgramaMarcada($id_meta);
		for ($i = 0; $i < count($marcados); $i++) {
			$data["condicion_programa"][] = $marcados[$i]["id_con_pro"];
		}
		$marcados = $poa_por_usuario->listarCondicionDependencia($id_meta);
		for ($i = 0; $i < count($marcados); $i++) {
			$data["dependencias"][] = $marcados[$i]["id_con_dep"];
		}
		//Codificar el resultado utilizando json
		echo json_encode($data);
		break;
	case 'mostrar_proyecto':
		$rspta = $poa_por_usuario->mostrar_proyecto($id_proyecto);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case 'terminar_accion':
		$rspta = $poa_por_usuario->terminar_accion($id_accion);
		echo json_encode($rspta);
		break;
	case 'eliminar_meta':
		$rspta = $poa_por_usuario->eliminarmeta($id_meta);
		echo json_encode($rspta);
		break;
}
