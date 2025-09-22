<?php
require_once "../modelos/Sac_Proyecto.php";
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$proyecto = new SacProyecto();
$fecha = date('Y-m-d');
$hora = date('H:i:s');
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
// $dependencias  = isset($_POST["dependencias"]) ? $_POST["dependencias"] : "";
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
$nombre_indicador  = isset($_POST["nombre_indicador"]) ? limpiarCadena($_POST["nombre_indicador"]) : "";
$porcentaje_avance_indicador  = isset($_POST["porcentaje_avance_indicador"]) ? limpiarCadena($_POST["porcentaje_avance_indicador"]) : "";

// $puntaje_anterior  = isset($_POST["puntaje_anterior"]) ? limpiarCadena($_POST["puntaje_anterior"]) : "";
// $puntaje_actual  = isset($_POST["puntaje_actual"]) ? limpiarCadena($_POST["puntaje_actual"]) : "";
// $indicador_sin_formula  = isset($_POST["indicador_sin_formula"]) ? limpiarCadena($_POST["indicador_sin_formula"]) : "";
// $indicador_formula_o_sin_formula  = isset($_POST["indicador_formula_o_sin_formula"]) ? limpiarCadena($_POST["indicador_formula_o_sin_formula"]) : "";
// valores indicadores de participacion 
// $participa  = isset($_POST["participa"]) ? limpiarCadena($_POST["participa"]) : "";
// $poblacion  = isset($_POST["poblacion"]) ? limpiarCadena($_POST["poblacion"]) : "";
// $select_tipo_indicador  = isset($_POST["indicador"]) ? limpiarCadena($_POST["indicador"]) : "";
// Cumplimiento de las metas
// $meta_lograda  = isset($_POST["meta_lograda"]) ? limpiarCadena($_POST["meta_lograda"]) : "";
// variables para registrar la informacion cuando se edita una accion
$id_usuario = $_SESSION['id_usuario'];
$fecha_accion_anterior_fin  = isset($_POST["fecha_accion_anterior_fin"]) ? limpiarCadena($_POST["fecha_accion_anterior_fin"]) : "";
$hora_anterior  = isset($_POST["hora_anterior"]) ? limpiarCadena($_POST["hora_anterior"]) : "";
$hora_accion  = isset($_POST["hora_accion"]) ? limpiarCadena($_POST["hora_accion"]) : "";
$plan_mejoramiento  = isset($_POST["plan_mejoramiento"]) ? limpiarCadena($_POST["plan_mejoramiento"]) : "";

// variables post para agregar las tareas.
$nombre_tarea  = isset($_POST["nombre_tarea"]) ? limpiarCadena($_POST["nombre_tarea"]) : "";
$fecha_tarea  = isset($_POST["fecha_tarea"]) ? limpiarCadena($_POST["fecha_tarea"]) : "";
$responsable_tarea  = isset($_POST["responsable_tarea"]) ? limpiarCadena($_POST["responsable_tarea"]) : "";
$id_accion_tarea  = isset($_POST["id_accion_tarea"]) ? limpiarCadena($_POST["id_accion_tarea"]) : "";
$id_accion  = isset($_POST["id_accion"]) ? limpiarCadena($_POST["id_accion"]) : "";
$id_meta_tarea  = isset($_POST["id_meta_tarea"]) ? limpiarCadena($_POST["id_meta_tarea"]) : "";
$link_tarea  = isset($_POST["link_tarea"]) ? limpiarCadena($_POST["link_tarea"]) : "";
$id_tarea_sac  = isset($_POST["id_tarea_sac"]) ? limpiarCadena($_POST["id_tarea_sac"]) : "";


switch ($_GET["op"]) {
	//se lista los proyectos
	case 'mostrar_proyecto':
		$rspta = $proyecto->mostrar_proyecto($id_proyecto);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	//se lista los ejes
	case 'mostrar_meta':
		$rspta = $proyecto->mostrar_meta($id_meta);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	//guardo el nombre del proyecto
	case 'guardaryeditarproyecto':
		//echo("$id_proyecto, $nombre_proyecto , $id_ejes");
		if (empty($id_proyecto)) {
			$rspta = $proyecto->insertarProyecto($nombre_proyecto, $id_ejes);
			echo $rspta ? "Proyecto registrado" : "Proyecto no se pudo registrar";
		} else {
			$rspta = $proyecto->editarproyecto($id_proyecto, $nombre_proyecto);
			echo $rspta ? "Proyecto actualiada" : "Proyecto no se pudo actualizar";
		}
		break;
	//eliminar una proyecto
	case 'eliminar_proyecto':
		$rspta = $proyecto->eliminarproyecto($id_proyecto);
		echo json_encode($rspta);
		break;
	//eliminar una proyecto
	case 'eliminar_meta':
		$rspta = $proyecto->eliminarmeta($id_meta);
		// $rspta2 = $proyecto->eliminarobservacion($id_meta);
		echo json_encode($rspta);
		break;
	//listar los nombres de meta por usuario
	case 'listar_meta':
		// $id_proyecto=$_POST["id_proyecto"];
		$nombre_meta = $proyecto->listarMetaProyectos($id_proyecto);
		$data[0] = "";
		$data[0] .= '<div class="row">';
		for ($f = 0; $f < count($nombre_meta); $f++) {
			$contador = $f + 1;
			$id_meta = $nombre_meta[$f]["id_meta"];
			$meta = $nombre_meta[$f]["meta_nombre"];
			$fecha_entrega = $nombre_meta[$f]["meta_fecha"];
			$responsable = $nombre_meta[$f]["meta_responsable"];
			$usuario_cargo = $nombre_meta[$f]["usuario_cargo"];
			$nombre_indicador = $nombre_meta[$f]["nombre_indicador"];
			$estado_meta = $nombre_meta[$f]["estado_meta"];
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
									Fecha de Entrega: <span class="float-right">' . $proyecto->fechaesp($fecha_entrega) . '</span>
								</li>
								<li class="nav-item p-2">
									Responsable: <span class="float-right">' . $usuario_cargo . '</span>
								</li>
								<li class="nav-item p-2">';
			$condicionesinstitucionales = $proyecto->listarCondicionInstitucionalMeta($id_meta);
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
			$condicionesdeprograma = $proyecto->listarCondicionProgramaMeta($id_meta);
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
			// $corresponsabilidades = $proyecto->listarcondicionesdependencia($id_meta);
			// $data[0] .= '
			// 						Corresponsables:</span>
			// 						<span class="float-right bg-success badge ">' . count($corresponsabilidades) . '</span>';
			// for ($co = 0; $co < count($corresponsabilidades); $co++) {
			// 	$nombre = $corresponsabilidades[$co]["nombre"];
			// 	$data[0] .= '<br><span class="small">' . $nombre . '</span>';
			// }
			// $data[0] .= '
			// 						</li>';
			$data[0] .= '
									<li class="nav-item p-2">
									<h5><b>Acciones Por Meta</b></h5>';
			$listaracciones = $proyecto->listaracciones($id_meta); // consulta para listas las acciones
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
											<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_accion(' . $listaracciones[$c]["id_accion"] . ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
											<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_accion(' . $listaracciones[$c]["id_accion"] . ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
											';
				} else {
					$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
				}
				$data[0] .= '
										</span>
									<hr>';
			}
			$data[0] .= '
									<br>
									<li class="nav-item p-2">
									Nombre Indicador: <span class="float-right">' . $nombre_indicador . '</span>
									</li>';
			$data[0] .= '
									<br>
									<li class="nav-item p-2">
										Estado de la meta: 
										<span class="float-right ' . ($estado_meta == 1 ? 'bg-success p-1' : 'bg-danger p-1') . '">
											' . ($estado_meta == 1 ? '<span><i class="fas fa-check"></i> La meta está cumplida</span> ' : '<span><i class="fas fa-times"></i> La meta no está cumplida</span>') . '
										</span>
									</li>';
			$data[0] .=
				'</li>
					</ul>
					</div>
				</div>	
			</div>';
		}
		echo json_encode($data);
		break;
	case 'listarmetas':
		$id_ejes = $_GET["id_ejes"];
		$anio = $_GET["globalperidioseleccionado"];
		// lista las metas
		$rspta	= $proyecto->totaldemetas($id_ejes, $anio);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		$total_cumplidas = 0;
		for ($i = 0; $i < count($reg); $i++) {
			$color_estado = array('0' => 'badge-warning', '1' => 'badge-success');
			$icono_estado = array('0' => 'fas fa-exclamation-triangle', '1' => 'fas fa-check');
			$total_cumplidas = ($reg[$i]["estado_meta"] == 1) ? $total_cumplidas + 1 : $total_cumplidas;
			$acciones = $proyecto->listaracciones($reg[$i]["id_meta"]);
			//cuenta el total de las metas
			$meta_nombre =  $reg[$i]["meta_nombre"];
			// $total_metas = $proyecto->listarMetaProyectosanioactual($reg[$i]["id_proyecto"],$anio);
			$proyecto_nombre =  $reg[$i]["nombre_proyecto"];

			$data[] = array(
				"0" => "
				<div class='col-12 text-center'>
					<span class='badge " . $color_estado[$reg[$i]["estado_meta"]] . "'>
						<i class='" . $icono_estado[$reg[$i]["estado_meta"]] . "'></i> 
					</span>
				</div>",
				"1" => $meta_nombre,
				"2" => $proyecto_nombre,
				"3" => '<input type="number" value="' . $reg[$i]["porcentaje_avance"] . '" 
                min="0" max="100" 
                class="form-control form-control-sm text-center" 
                onchange="actualizarPorcentaje(' . $reg[$i]["id_meta"] . ', this.value)">',
				"4" =>
				'<div class="col-12 text-center"> 	
					<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="listar_proyecto_accion(' . $reg[$i]["id_meta"] . ')" title="Ver Meta">' . count($acciones) . ' </a>
				</div>',
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data,
			"totalMetas" => $i,
			"totalCumplidas" => $total_cumplidas,
			"totalNoCumplidas" => $i - $total_cumplidas
		);
		echo json_encode($results);
		break;
	//listar los nombres de meta por usuario
	case 'listar_proyecto_accion':
		$data[0] = "";
		$rspta_meta	= $proyecto->listaracciones($id_meta);
		for ($p = 0; $p < count($rspta_meta); $p++) {
			$data[0] .= '
				<table class="table  table-responsive">
						<tbody> 	
							<tr>
								<td>' . $rspta_meta[$p]["nombre_accion"] . '</td>
								<td>
									<button class="btn btn-primary btn-xs align-top" onclick="mostrar_accion(' . $rspta_meta[$p]["id_accion"] . ')" title="Editar Acción" data-placement="top"><i class="fas fa-pencil-alt"></i></button></span>
								</td>
							</tr>
						</tbody>
				</table>';
		}
		echo json_encode($data);
		break;
	//listar los nombres de la accion
	case 'nombre_accion':
		$nombre_meta = $proyecto->listarAccionUsuario($id_meta);
		$data[0] = "";
		for ($f = 0; $f < count($nombre_meta); $f++) {
			$accion = $nombre_accion[$f]["nombre_accion"];
			$data[0] .= '
			<div class="alert alert-success alert-dismissible">
				<h6> <i class="icon fa fa-check"> </i>' . $meta . '</h6>
			</div>';
		}
		echo json_encode($data);
		break;
	// listamos las condiciones institucionales
	case 'condiciones_institucionales':
		$rspta = $proyecto->listarCondicionesInstitucionales();
		//Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
		for ($i = 0; $i < count($rspta); $i++) {
			echo '<input class="form-check-input" type="checkbox" name="condicion_institucional[]" id="check_' . $i . '" value="' . $rspta[$i]["id_condicion_institucional"] . '" >
				<label class="form-check-label " for="check_' . $i . '">' . $rspta[$i]["nombre_condicion"] . '</label> <br>	';
		}
		break;
	// listamos las dependencias
	// case 'dependencias':
	// 	$rspta = $proyecto->listardependencias();
	// 	//Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
	// 	for ($i = 0; $i < count($rspta); $i++) {
	// 		echo '<input class="form-check-input" type="checkbox" name="dependencias[]" id="check_dep_' . $i . '" value="' . $rspta[$i]["id_dependencias"] . '" >
	// 		<label class="form-check-label" for="check_dep_' . $i . '">' . $rspta[$i]["nombre"] . '</label> <br> ';
	// 	}
	// 	break;
	// listamos las condiciones de programa
	case 'condiciones_programa':
		$rspta = $proyecto->listarCondicionesPrograma();
		//Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
		for ($i = 0; $i < count($rspta); $i++) {
			echo '<input class="form-check-input " type="checkbox" name="condicion_programa[]" id="check_pro_' . $i . '" value="' . $rspta[$i]["id_condicion_programa"] . '" >
				<label class="form-check-label" for="check_pro_' . $i . '">' . $rspta[$i]["nombre_condicion"] . '</label> <br> 	';
		}
		break;
	// listamos el cargo 
	case "selectListarCargo":
		$rspta = $proyecto->selectlistarCargo();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
		}
		break;

	//mostramos las condiciones institucionales, programas y dependencias marcadas
	case 'listar_marcadas_meta':
		$data = $proyecto->mostrar_meta($id_meta);
		$marcados = $proyecto->listarCondicionInstitucionalMarcada($id_meta);
		for ($i = 0; $i < count($marcados); $i++) {
			$data["condicion_institucional"][] = $marcados[$i]["id_con_ins"];
		}
		$marcados = $proyecto->listarCondicionProgramaMarcada($id_meta);
		for ($i = 0; $i < count($marcados); $i++) {
			$data["condicion_programa"][] = $marcados[$i]["id_con_pro"];
		}
		// $marcados = $proyecto->listarCondicionDependencia($id_meta);
		// for ($i = 0; $i < count($marcados); $i++) {
		// 	$data["dependencias"][] = $marcados[$i]["id_con_dep"];
		// }
		//Codificar el resultado utilizando json
		echo json_encode($data);
		break;
	//se guarda y edita la meta y se listan las condiciones de programa institucional y las dependencias
	case 'guardaryeditometa':
		// Inicializa los arrays
		$id_condiciones_pro = [];
		$id_concondiciones_ins = [];
		// $id_dependencias = [];
		// Verifica y lista las condiciones de programa
		if (is_array($condicion_programa)) {
			foreach ($condicion_programa as $id_con_pro) {
				$id_condiciones_pro[] = $id_con_pro;
			}
		}
		// Verifica y lista las condiciones institucionales
		if (is_array($condicion_institucional)) {
			foreach ($condicion_institucional as $id_con_ins) {
				$id_concondiciones_ins[] = $id_con_ins;
			}
		}
		// Verifica y lista las dependencias
		// if (is_array($dependencias)) {
		// 	foreach ($dependencias as $id_con_dep) {
		// 		$id_dependencias[] = $id_con_dep;
		// 	}
		// }
		//si la meta esta vacia se procede a agregarla
		if (empty($id_meta)) {
			$puntaje_actual = empty($puntaje_actual) ? 0 : $puntaje_actual;
			$puntaje_anterior = empty($puntaje_anterior) ? 0 : $puntaje_anterior;
			$participa = empty($participa) ? 0 : $participa;
			$poblacion = empty($poblacion) ? 0 : $poblacion;

			$rspta = $proyecto->sacinsertometa($plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_proyecto, $id_concondiciones_ins, $id_condiciones_pro, $anio_eje, $nombre_indicador, $porcentaje_avance_indicador);
			echo $rspta ? "meta registrada" : "meta no se pudo registrar";
		} else {
			//elimino las condiciones y dependencias 
			$rspta = $proyecto->eliminar_con_ins($id_meta);
			$rspta = $proyecto->eliminar_con_pro($id_meta);
			$rspta = $proyecto->eliminar_con_dep($id_meta);
			$puntaje_actual = empty($puntaje_actual) ? 0 : $puntaje_actual;
			$puntaje_anterior = empty($puntaje_anterior) ? 0 : $puntaje_anterior;
			$participa = empty($participa) ? 0 : $participa;
			$poblacion = empty($poblacion) ? 0 : $poblacion;
			$rspta = $proyecto->saceditometa($id_meta, $plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_concondiciones_ins, $id_condiciones_pro, $anio_eje, $nombre_indicador, $porcentaje_avance_indicador);
			echo $rspta ? "meta actualizada" : "meta no se pudo actualizar";
		}
		break;
	//listo los ejes 
	case 'listar_ejes':
		$anio = "";
		if (isset($_POST['periodoSeleccionado'])) {
			$anio = $_POST['periodoSeleccionado'];
		}
		$data[0] = "";
		$proyectos = $proyecto->totalproyectos();

		// editar prueba
		$metas_total_informe = $proyecto->totalmetas($anio);






		// $acciones = $proyecto->totalacciones($anio);
		$por_vencer = $proyecto->porvencer();

		// contamos el total de las acciones que hay por periodo seleccionado 
		$ejes = $proyecto->listar();
		$numero_total_acciones = 0;
		for ($a = 0; $a < count($ejes); $a++) {
			$id_ejes = $ejes[$a]["id_ejes"];

			$total_proyectos = $proyecto->listarproyecto($id_ejes);
			for ($b = 0; $b < count($total_proyectos); $b++) {
				$total_metas = $proyecto->listarMetaProyectosanioactual($total_proyectos[$b]["id_proyecto"], $anio);
				for ($c = 0; $c < count($total_metas); $c++) {
					$total_acciones = $proyecto->totalaccionesporeje($total_metas[$c]["id_meta"]);
					$numero_total_acciones += count($total_acciones);
				}
			}
		}

		//tomamos el total de las tareas

		$total_tareas_reporte = $proyecto->total_tareas($anio);





		$data[0] .= '
		<div class="card col-12 mb-4">
			<div class="card-body">
				<div class="row">			
					<div class="col">
						<div class="row align-items-center cursor-pointer" id="vision_general" onclick="ver_plan()">
							<div class="col-auto">
								<div class="avatar avatar-50 rounded bg-light-purple">
									<i class="far fa-file-excel fa-2x text-purple"></i>
								</div>
							</div>
							<div class="col">
								<p class="small text-secondary mb-1">Visión</p>
								<h4 class="fw-medium"> <small style="font-size: 70%;">General</small></h4>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="row align-items-center pointer" onclick="ver_plan_proyecto()" id="plan_proyecto">
							<div class="col-auto">
								<div class="avatar avatar-50 rounded bg-light-yellow">
									<i class="fa-solid fa-diagram-project fa-2x text-warning"></i>
								</div>
							</div>
							<div class="col">
								<p class="small text-secondary mb-1">Objetivos</p>
								<h4 class="fw-medium"  class="btn btn-link">' . count($proyectos) . '</h4>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="row align-items-center cursor-pointer" onclick="ver_plan_metas()" id="ver_plan_metas">
							<div class="col-auto">
								<div class="avatar avatar-50 rounded bg-light-blue">
									<i class="fa-solid fa-flag-checkered fa-2x text-primary"></i>
								</div>
							</div>
							<div class="col">
								<p class="small text-secondary mb-1">Metas</p>
								<h4 class="fw-medium" class="btn btn-link">' . count($metas_total_informe) . '</h4>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="row align-items-center cursor-pointer" onclick="ver_plan_accion()" id="ver_plan_accion">
							<div class="col-auto">
								<div class="avatar avatar-50 rounded bg-light-cyan">
									<i class="far fa-thumbs-up fa-2x text-cyan"></i>
								</div>
							</div>
							<div class="col">
								<p class="small text-secondary mb-1">Estrategías</p>
								<h4 class="fw-medium " class="btn btn-link">' . $numero_total_acciones . ' </h4>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="row align-items-center cursor-pointer" onclick="ver_plan_tareas()" id="ver_plan_accion">
							<div class="col-auto">
								<div class="avatar avatar-50 rounded bg-light-cyan">
									<i class="far fa-thumbs-up fa-2x text-cyan"></i>
								</div>
							</div>
							<div class="col">
								<p class="small text-secondary mb-1">Acciones</p>
								<h4 class="fw-medium " class="btn btn-link">' . count($total_tareas_reporte) . ' </h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		';
		$data[0] .= '
		<div class="col-12 text-center py-4">
			<h3 class="titulo-3 text-bold fs-24">¿Nuestra  <span class="text-gradient">visión para </span> el <span class="text-gradient"> 2030?</span></h3>
			<p class="lead text-secondary line-height-18"> seremos una institución de educación superior reconocida en la sociedad por su creatividad e innovación </p>
		</div>';
		$ejes = $proyecto->listar();
		$contador_metas = 0;
		$contador_acciones = 0;
		$cantidad_metas_grafica = 0;
		$data[0] .= '
			<div class="row">';
		for ($a = 0; $a < count($ejes); $a++) {
			$contador_metas = 0;
			$contador_acciones = 0;
			$id_ejes = $ejes[$a]["id_ejes"];

			$total_metas_por_eje = $proyecto->totaldemetasporanio($id_ejes, $anio);

			$nombre_eje = $ejes[$a]["nombre_ejes"];
			$total_proyectos = $proyecto->listarproyecto($id_ejes);

			$metas_total_grafica = $proyecto->totalmetas($anio);


			$totalCumplidas = 0;
			for ($b = 0; $b < count($total_proyectos); $b++) {
				$total_metas = $proyecto->listarMetaProyectosanioactual($total_proyectos[$b]["id_proyecto"], $anio);
				for ($c = 0; $c < count($total_metas); $c++) {
					// count($total_metas);
					$totalCumplidas = ($total_metas[$c]["estado_meta"] == 1) ? $totalCumplidas + 1 : $totalCumplidas;
					$contador_metas++;
					$data[0] .= '';
					$total_acciones = $proyecto->totalaccionesporeje($total_metas[$c]["id_meta"]);
					$contador_acciones = $contador_acciones + count($total_acciones);

					$total_acciones = $proyecto->totalaccionesporeje($total_metas[$c]["id_meta"]);
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

			// contar total tareas 
			$total_tareas_eje	= $proyecto->totaldetareas($id_ejes, $anio);


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
									
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4 col-md-3 mb-3">
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
							<div class="col-4 col-md-3 mb-3">
								<div class="row justify-content-center cursor-pointer" onclick="listarmetas(' . $id_ejes . ')" id="tour_metas_eje">
									<div class="col-12 text-center">
										<div class="avatar avatar-50 rounded bg-light-blue">
											<i class="fa-solid fa-flag-checkered fa-2x text-primary"></i>
										</div>
									</div>
									<div class="col-12 text-center pt-2">
										<span class="titulo-2 fs-16 line-height-16 text-semibold">' . count($total_metas_por_eje) . " " . '</span><br>
										<span class="fs-14 ">Metas</span>
									</div>
								</div>
							</div>
							<div class="col-4 col-md-3 mb-3">
								<div class="row justify-content-center cursor-pointer" onclick="listaracciones(' . $id_ejes . ')" id="tour_acciones_eje">
									<div class="col-12 text-center">
										<div class="avatar avatar-50 rounded bg-light-cyan">
											<i class="far fa-thumbs-up fa-2x text-cyan"></i>
										</div>
									</div>
									<div class="col-12 text-center pt-2">
										<span class="titulo-2 fs-16 line-height-16 text-semibold">' . $contador_acciones . " " . '</span><br>
										<span class="fs-14 " >Acciones</span>
									</div>
								</div>
							</div>

							<div class="col-4 col-md-3 mb-3">
								<div class="row justify-content-center cursor-pointer" onclick="listartareas(' . $id_ejes . ')" id="tour_tareas_eje">
									<div class="col-12 text-center">
										<div class="avatar avatar-50 rounded bg-light-cyan">
											<i class="fas fa-tasks fa-2x text-cyan"></i>
										</div>
									</div>
									<div class="col-12 text-center pt-2">
										<span class="titulo-2 fs-16 line-height-16 text-semibold">' . count($total_tareas_eje) . " " . '</span><br>
										<span class="fs-14 " >Tareas</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			';
		}
		$data[0] .= '
		</div>';
		echo json_encode($data);
		break;
	case 'listar':
		$id_ejes = $_GET["id_ejes"];
		$rspta = $proyecto->listarproyecto($id_ejes);
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$total_metas_2022 = $proyecto->listarMetaProyectos_2022($reg[$i]["id_proyecto"]);
			$total_metas_2024 = $proyecto->listarMetaProyectos_2024($reg[$i]["id_proyecto"]);
			$total_metas_2025 = $proyecto->listarMetaProyectos_2025($reg[$i]["id_proyecto"]);
			$total_metas = $proyecto->listarMetaProyectos($reg[$i]["id_proyecto"]);
			$proyecto_nombre =  $reg[$i]["nombre_proyecto"];
			$id_proyecto = $reg[$i]["id_proyecto"];
			$data[] = array(
				"0" => '
				<div class="col-12 text-center btn-group">
					<button type="button" class="tooltip-agregar btn bg-purple btn-flat btn-xs" onclick="mostrarMeta(' . $reg[$i]["id_proyecto"] . ')" title="Agregar metas" data-toggle="tooltip" data-placement="top"><i class="fas fa-flag-checkered"></i></button>
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_proyecto(' . $reg[$i]["id_proyecto"] . ')" title="Editar Proyecto" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_proyecto(' . $id_proyecto . ')" title="Eliminar Proyecto" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
				</div>',
				"1" => $proyecto_nombre,
				"2" => '<div class="col-12 text-center"> 	
					<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="listar_meta_2025(`' . $reg[$i]["id_proyecto"] . '`)" title="Ver Meta 2025">' . count($total_metas_2025) . ' </a>
				</div>
',
				"3" =>
				'
				<div class="col-12 text-center"> 	
					<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="listar_meta_2024(`' . $reg[$i]["id_proyecto"] . '`)" title="Ver Meta 2024">' . count($total_metas_2024) . ' </a>
				</div>
				',
				"4" =>
				'<div class="col-12 text-center"> 	
					<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="listar_meta(`' . $reg[$i]["id_proyecto"] . '`)" title="Ver Meta 2023">' . count($total_metas) . ' </a>
				<div>',
				"5" =>
				'
				<div class="col-12 text-center"> 	
					<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="listar_meta_2022(`' . $reg[$i]["id_proyecto"] . '`)" title="Ver Meta 2023">' . count($total_metas_2022) . ' </a>
				</div>
				'
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'eliminar':
		$rspta = $proyecto->eliminar($id_eje);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	//listar las dependencias
	case 'nombre_ejes':
		$nombre_meta = $proyecto->listarMetaEje($id_eje);
		$data[0] = "";
		for ($a = 0; $a < count($nombre_meta); $a++) {
			$meta = $nombre_meta[$a]["meta_nombre"];
			$data[0] .= '
			<div class="alert alert-success alert-dismissible">
				<h6> <i class="icon fa fa-check"> </i>' . $meta . '</h6>
			</div>';
		}
		echo json_encode($data);
		break;
	case 'nombre_accion_ejes':
		$nombre_accion = $proyecto->listarAccionEje($id_eje);
		$data[0] = "";
		$meta_nombre = '';
		for ($r = 0; $r < count($nombre_accion); $r++) {
			$accion = $nombre_accion[$r]["nombre_accion"];
			$nombre_meta_actual = $nombre_accion[$r]["meta_nombre"];
			$nombre_meta_anterior = isset($nombre_accion[($r - 1)]["meta_nombre"]) ? $nombre_accion[($r - 1)]["meta_nombre"] : "";
			$nombre_accion_anterior = isset($nombre_accion[($r - 1)]["nombre_accion"]) ? $nombre_accion[($r - 1)]["nombre_accion"] : "";
			if ($nombre_meta_anterior != $nombre_meta_actual) {
				$data[0] .= '<hr><strong> Meta:</strong><strong class="text-secondary"><br>' . $nombre_meta_actual . '</strong>
				<br> 
				';
				$data[0] .= '<br><label>Acciones: </label>';
			};
			if ($nombre_accion_anterior != $accion) {
				$data[0] .= '
				<strong class="text-secondary"><br>' . ($r + 1) . '</span>: </b>' . $accion . '</strong>
				<br> ';
			};
		}
		echo json_encode($data);
		break;
	case 'ver_plan':
		$anio = $_POST['globalperidioseleccionado'];
		$data[0] = "";
		$ejes = $proyecto->listar();
		$data[0] .= '
			<div class="card col-12">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-8 pt-3 pl-3 tono-3" id="ocultarmetas">
						<div class="row align-items-center pt-2">
							<div class="pl-4 col-auto">
								<div class="rounded bg-light-blue p-3 text-primary">
									<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
								</div>
							</div>
							<div class="col-auto line-height-18">
								<span class="">Plan</span> <br>
								<span class="text-semibold fs-16 titulo-2 fs-18 line-height-16">Estatégico</span>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-4 text-right py-4 pr-4 tono-3" >
						<a onclick="volver_panel()" class="btn btn-danger btn-flat float-right text-semibold" style="color: white !important;"> <i class="fa-solid fa-chevron-left"></i> Atras</a>
					</div>
					<div class="col-12 p-4" id="ver_proyectos">
						<div class="row table-responsive">
							<table class="table" style="width:100%">
								<thead>
									<tr>
										<th> Eje estrategico</th>
										<th> Objetivos</th>
										<th> Meta</th>
										<th> ---</th>
										<th> --</th>
										<th> Responsable</th>
										<th> Corresponsable</th>
										<th> Recursos</th>
									</tr>
								</thead>
								<tbody class="parrafo-normal fs-14">';
		for ($a = 0; $a < count($ejes); $a++) {
			$id_ejes = $ejes[$a]["id_ejes"];
			$nombre_eje = $ejes[$a]["nombre_ejes"];
			$total_proyectos = $proyecto->listarproyecto($id_ejes); // consulta para los proyectos
			$lineasmetas = 0;
			for ($conta1 = 0; $conta1 < count($total_proyectos); $conta1++) { // imprime los proyectos
				$conta_metas = $proyecto->totalMetasPorProyecto($total_proyectos[$conta1]["id_proyecto"], $anio); // consulta para traer las metas
				$contadormetas = count($conta_metas);
				if ($contadormetas == 0) {
					$contadormetas = 1;
				}
				$lineasmetas = $lineasmetas + $contadormetas;
			}
			$data[0] .= '<tr>';
			if ($lineasmetas == 1) {
				$data[0] .= '<td>' . $nombre_eje . '-' . $lineasmetas . '</td>';
			} else {
				$data[0] .= '<td rowspan=' . $lineasmetas . '>' . $nombre_eje . '-+' . $lineasmetas . '</td>';
			}
			if (count($total_proyectos) == 0) {
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
			}
			if ($lineasmetas == 0) {
				$data[0] .= '<td> -- </td>';
			}
			// tabla 1
			for ($b = 0; $b < count($total_proyectos); $b++) { // imprime los proyectos
				$nombre_proyecto = $total_proyectos[$b]["nombre_proyecto"];
				$total_metas = $proyecto->totalMetasPorProyecto($total_proyectos[$b]["id_proyecto"], $anio);
				//si $b es igual a cero quiere decir que acaba de empezar el ciclo
				if ($b == 0) {
					$data[0] .= '<td rowspan=' . count($total_metas) . '>' . $nombre_proyecto . '-' . count($total_metas) . '</td>';
					if (count($total_metas) == 0) {
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
					}
					//print_r($total_metas);
					// traemos las dependencias para mostrarlas en la tabla
					for ($c = 0; $c < count($total_metas); $c++) { // imprime las metas	
						$id_meta = $total_metas[$c]["id_meta"];

						// $responsable = $total_metas[$c]["meta_responsable"];
						$responsable = $total_metas[$c]["usuario_nombre"] . " " . $total_metas[$c]["usuario_nombre_2"] . " " . $total_metas[$c]["usuario_apellido"] . " " . $total_metas[$c]["usuario_apellido_2"];
						$nombre_meta = $total_metas[$c]["meta_nombre"];
						$corresponsabilidades = $proyecto->listarcondicionesdependencia($id_meta);
						$condicionesinstitucionales = $proyecto->listarCondicionInstitucionalMeta($id_meta);
						$condicionesdeprograma = $proyecto->listarCondicionProgramaMeta($id_meta);
						// traemos las dependencias para mostrarlas en la tabla
						$nombre_dependencia = "-- ";
						for ($f = 0; $f < count($corresponsabilidades); $f++) {
							$nombre_dependencia .= "<b> - </b> " . $corresponsabilidades[$f]["nombre"] . "<br>" . "<br>";
						}
						// traemos las condiciones institucionales para mostrarlas en la tabla
						$nombre_condicion = "-- ";
						for ($e = 0; $e < count($condicionesinstitucionales); $e++) {
							$nombre_condicion .= "<b> - </b> " . $condicionesinstitucionales[$e]["nombre_condicion"] . "<br>" . "<br>";
						}
						//traemos las condiciones por programa para mostrarlas en la tabla
						$nombre_programa = "-- ";
						for ($g = 0; $g < count($condicionesdeprograma); $g++) {
							$nombre_programa .= "<b> - </b> " . $condicionesdeprograma[$g]["nombre_condicion"] . "<br>" . "<br>";
						}
						//si el primer ciclo de total de las metas de ese proyecto
						$data[0] .= ($c == 0) ? '' : '<tr>';
						$data[0] .= '<td>' . $nombre_meta . '<br></td>';
						$data[0] .= '<td>' . $nombre_condicion . '</td>';
						$data[0] .= '<td>' . $nombre_programa . '</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>' . $responsable . '</td>';
						$data[0] .= '<td>' . $nombre_dependencia . '</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= ($c == 0) ? '' : '</tr>';
					}
					$data[0] .= '</tr>';
				} else {
					// tabla 2
					$data[0] .= '</tr>';
					if (count($total_metas) == 0) {
						$data[0] .= '<td>' . $nombre_proyecto . '-' . count($total_metas) . '</td>';
					} else {
						$data[0] .= '<td rowspan=' . count($total_metas) . '>' . $nombre_proyecto . '-' . count($total_metas) . '</td>';
					}
					if (count($total_metas) == 0) {
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
					}
					// traemos el id meta para saber en que id estamos 
					for ($s = 0; $s < count($total_metas); $s++) { // imprime las metas
						$id_meta = $total_metas[$s]["id_meta"];
						$id_proyecto = $total_metas[$s]["id_proyecto"];
						$responsable = $total_metas[$s]["usuario_nombre"] . " " . $total_metas[$s]["usuario_nombre_2"] . " " . $total_metas[$s]["usuario_apellido"] . " " . $total_metas[$s]["usuario_apellido_2"];
						// $nombre_meta = $total_metas[$s]["meta_nombre"];
						$corresponsabilidades = $proyecto->listarcondicionesdependencia($id_meta);
						$condicionesinstitucionales = $proyecto->listarCondicionInstitucionalMeta($id_meta);
						$condicionesdeprograma = $proyecto->listarCondicionProgramaMeta($id_meta);
						// listamos los corresponsables 
						$nombre_condicion = "-- ";
						for ($y = 0; $y < count($condicionesinstitucionales); $y++) {
							$nombre_condicion .= "<b> - </b>" . $condicionesinstitucionales[$y]["nombre_condicion"] . "<br>" . "<br>";
						}
						$nombre_programa = "--";
						for ($v = 0; $v < count($condicionesdeprograma); $v++) {
							$nombre_programa .= "<b> - </b>" . $condicionesdeprograma[$v]["nombre_condicion"] . "<br>" . "<br>";
						}
						$nombre_dependencia = "--";
						for ($o = 0; $o < count($corresponsabilidades); $o++) {
							$nombre_dependencia .= "<b> - </b>" . $corresponsabilidades[$o]["nombre"] . "<br>" . "<br>";
						}
						$data[0] .= ($s == 0) ? '' : '<tr>';
						$data[0] .= '<td>' . $nombre_meta . "<br>" . '</td>';
						$data[0] .= '<td> ' . $nombre_condicion . '</td>';
						$data[0] .= '<td>' . $nombre_programa . '</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>' . $responsable . '</td>';
						$data[0] .= '<td>' . $nombre_dependencia . '</td>';
						$data[0] .= '<td>' . $nombre_dependencia . '</td>';
						$data[0] .= ($s == 0) ? '' : '</tr>';
					}
					$data[0] .= '</tr>';
				}
			}
		}
		$data[0] .= '
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>';
		echo json_encode($data);
		break;
	case 'listaracciones':
		$anio = $_GET["globalperidioseleccionado"];
		$id_ejes = $_GET["id_ejes"];
		$rspta	= $proyecto->totaldeacciones($id_ejes, $anio);
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$nombre_accion =  $reg[$i]["nombre_accion"];
			$meta_nombre =  $reg[$i]["meta_nombre"];
			$data[] = array(
				"0" => '
				<div class="btn-group">
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_accion(' . $reg[$i]["id_accion"] . ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_accion(' . $reg[$i]["id_accion"] . ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
				</div>',
				"1" => $nombre_accion,
				"2" => $meta_nombre,
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'mostrar_accion':
		$rspta = $proyecto->mostrar_accion($id_accion);
		echo json_encode($rspta);
		break;
	case 'eliminar_accion':
		$rspta = $proyecto->eliminar_accion($id_accion);
		echo json_encode($rspta);
		break;
	//guardar y editar una accion
	case 'guardaryeditaraccion':
		if (empty($id_accion)) {
			$rspta = $proyecto->insertaraccion($nombre_accion, $id_meta, $fecha_fin);
			echo $rspta ? "Acción registrada" : "Acción no se pudo registrar";
		} else {
			$rspta = $proyecto->editaraccion($id_accion, $nombre_accion, $id_meta, $fecha_fin, $hora_accion);
			$proyecto->sac_registro_fecha($id_usuario, $fecha_accion_anterior_fin, $fecha_fin, $hora_anterior, $hora_accion);
			echo $rspta ? "Accion actualizada" : "Accion no se pudo actualizar";
		}
		break;
	case 'ver_plan_proyecto':
		$anio = $_POST['globalperidioseleccionado'];
		$data[0] = "";
		$listar_proyectos = $proyecto->listar_proyectos();
		$data[0] .= '
		<section class="content" style="padding-top: 0px;">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
				<div class="row">
					<div class="card col-12">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-8 pt-3 pl-3 tono-3" id="ocultargestionproyecto">
								<div class="row align-items-center pt-2">
									<div class="pl-4 col-auto">
										<span class="rounded bg-light-blue p-3 text-primary">
											<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
										</span>
									</div>
									<div class="col">
										<div class="fs-14 line-height-18">
											<span class="">Resultados</span> <br>
											<span class="text-semibold fs-16 titulo-2 fs-18 line-height-16"> Objetivos</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-4 text-right py-4 pr-4 tono-3" >
								<a onclick="volver_panel()" class="btn btn-danger btn-flat float-right text-semibold" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
							</div>
						';
		$data[0] .= ' 
		<div class="panel-body table-responsive p-4" id="ver_tabla_proyecto">
			<table id="ver_tabla_plan" class="table" style="width:100%">';
		$data[0] .= '<thead>';
		$data[0] .= '<th> Objetivos</th>';
		$data[0] .= '</thead>';
		$data[0] .= '<tbody class="parrafo-normal fs-14">';
		for ($a = 0; $a < count($listar_proyectos); $a++) {
			$id_ejes = $listar_proyectos[$a]["id_ejes"];
			$nombre_proyecto = $listar_proyectos[$a]["nombre_proyecto"];
			$total_proyectos = $proyecto->listarproyecto($id_ejes); // consulta para los proyectos
			$lineasmetas = 0;
			for ($conta1 = 0; $conta1 < count($total_proyectos); $conta1++) { // imprime los proyectos
				$conta_metas = $proyecto->totalMetasPorProyecto($total_proyectos[$conta1]["id_proyecto"], $anio); // consulta para traer las metas
				$contadormetas = count($conta_metas);
				if ($contadormetas == 0) {
					$contadormetas = 1;
				}
				$lineasmetas = $lineasmetas + $contadormetas;
			}
			$data[0] .= '<tr>';
			if ($lineasmetas == 0) {
				$data[0] .= '<td>' . '-' . $lineasmetas . '</td>';
			}
			if (count($total_proyectos) == 0) {
				$data[0] .= '<td>--</td>';
			}
			if ($lineasmetas == 0) {
				$data[0] .= '<td>--</td>';
			}
			// tabla 1
			//si $b es igual a cero quiere decir que acaba de empezar el ciclo
			if ($conta1 == 0) {
				$data[0] .= '<td>' . "<h6>$nombre_proyecto</h6>" . '</td>';
				// traemos las dependencias para mostrarlas en la tabla
				for ($c = 0; $c < count($conta_metas); $c++) { // imprime las metas	
					$id_meta = $conta_metas[$c]["id_meta"];
					$responsable = $conta_metas[$c]["meta_responsable"];
					$nombre_meta = $conta_metas[$c]["meta_nombre"];
					//si el primer ciclo de total de las metas de ese proyecto
					$data[0] .= ($c == 0) ? '' : '<tr>';
					$data[0] .= ($c == 0) ? '' : '</tr>';
				}
				$data[0] .= '</tr>';
			} else {
				// tabla 2
				$data[0] .= '</tr>';
				if (count($conta_metas) == 0) {
					$data[0] .= '<td>' . $nombre_proyecto . '-' . count($conta_metas) . '</td>';
				} else {
					$data[0] .= '<td>' . "<h6>$nombre_proyecto</h6>" . '</td>';
				}
				// traemos el id meta para saber en que id estamos 
				for ($s = 0; $s < count($conta_metas); $s++) { // imprime las metas
					$id_meta = $conta_metas[$s]["id_meta"];
					$data[0] .= ($s == 0) ? '' : '<tr>';
					$data[0] .= ($s == 0) ? '' : '</tr>';
				}
				$data[0] .= '</tr>';
			}
		}
		$data[0] .= '</tbody>';
		$data[0] .= '</table>';
		$data[0] .= '</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>';
		echo json_encode($data);
		break;
	//listo los ejes 
	case 'ver_plan_metas':
		$anio = $_POST['globalperidioseleccionado'];
		$data[0] = "";
		$ejes = $proyecto->listar();
		$metas = $proyecto->totalmetas($anio);
		$metasCumplidas = $proyecto->obtenerNumeroMetasCumplidas($anio);
		$metasNoCumplidas = $proyecto->obtenerNumeroMetasNoCumplidas($anio);
		$por_vencer = $proyecto->porvencer();
		$data[0] .= '
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3 pl-4 d-flex justify-content-end">
				<div class="row">
					<div class="col-auto">
						<div class="row ">
							<div class="col-12 hidden">
								<div class="row ">
									<div class="col-auto">
										<div class="avatar rounded bg-light-green text-success">
												<i class="fa-solid fa-check" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col ps-0">
									<div class="small mb-0">Total</div>
									<h4 class="text-dark mb-0">
											<span class="text-semibold" >' . $metasCumplidas . '</span> 
											<small class="text-regular">OK</small>
									</h4>
									<div class="small">Metas Cumplidas <span class="text-green"></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-auto">
						<div class="row">
							<div class="col-12 hidden">
								<div class="row ">
									<div class="col-auto">
									<div class="avatar rounded bg-light-red text-danger">
										<i class="fa-solid fa-xmark"></i>
									</div>
									</div>
									<div class="col ps-0">
									<div class="small mb-0">Total</div>
									<h4 class="text-dark mb-0">
										<span class="text-semibold">' . $metasNoCumplidas . '</span> 
										<small class="text-regular">OK</small>
									</h4>
									<div class="small">Metas No Cumplidas <span class="text-green"></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-8 pt-3 tono-3" id="ocultargestionproyecto">
							<div class="row">
								<div class="col-auto pl-4">
									<div class="rounded bg-light-blue p-3 text-primary">
										<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-auto line-height-18 pt-1">
									<span class="">Resultados</span> <br>
									<span class="text-semibold fs-18 titulo-2 line-height-16">Metas</span>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-4 text-right py-4 pr-4 tono-3">
							<a onclick="volver_panel()" class="btn btn-danger btn-flat float-right text-semibold" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
						</div>
						<div class="card col-12 table-responsive p-4" id="ver_tabla_proyecto">
							<table id="ver_tabla_plan" class="table" style="width:100%">';
		$data[0] .= '<thead>';
		$data[0] .= '<tr>';
		$data[0] .= '<th> Objetivo</th>';
		$data[0] .= '<th>Meta</th>';
		$data[0] .= '</tr>';
		$data[0] .= '</thead>';
		$data[0] .= '<tbody class="parrafo-normal fs-14">';
		for ($a = 0; $a < count($ejes); $a++) {
			$id_ejes = $ejes[$a]["id_ejes"];
			$nombre_eje = $ejes[$a]["nombre_ejes"];
			$total_proyectos = $proyecto->listarproyecto($id_ejes); // consulta para los proyectos
			$lineasmetas = 0;
			for ($conta1 = 0; $conta1 < count($total_proyectos); $conta1++) { // imprime los proyectos
				$conta_metas = $proyecto->totalMetasPorProyecto($total_proyectos[$conta1]["id_proyecto"], $anio); // consulta para traer las metas
				$contadormetas = count($conta_metas);
				if ($contadormetas == 0) {
					$contadormetas = 1;
				}
				$lineasmetas = $lineasmetas + $contadormetas;
			}
			$data[0] .= '<tr>';
			if (count($total_proyectos) == 0) {
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
				$data[0] .= '<td>--</td>';
			}
			// tabla 1
			for ($b = 0; $b < count($total_proyectos); $b++) { // imprime los proyectos
				$nombre_proyecto = $total_proyectos[$b]["nombre_proyecto"];
				$total_metas = $proyecto->totalMetasPorProyecto($total_proyectos[$b]["id_proyecto"], $anio);
				//si $b es igual a cero quiere decir que acaba de empezar el ciclo
				if ($b == 0) {
					$data[0] .= '<td rowspan=' . count($total_metas) . '>' . $nombre_proyecto . '   <span class="badge badge-info right">  ' . count($total_metas) . '</span></td>';
					if (count($total_metas) == 0) {
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
						$data[0] .= '<td>--</td>';
					}
					// traemos las dependencias para mostrarlas en la tabla
					for ($c = 0; $c < count($total_metas); $c++) { // imprime las metas	
						$id_meta = $total_metas[$c]["id_meta"];
						$responsable = $total_metas[$c]["meta_responsable"];
						$nombre_meta = $total_metas[$c]["meta_nombre"];
						$data[0] .= ($c == 0) ? '' : '<tr>';
						$data[0] .= '<td>' . $nombre_meta . '<br></td>';
						$data[0] .= ($c == 0) ? '' : '</tr>';
					}
				} else {
					// tabla 2
					$data[0] .= '</tr>';
					if (count($total_metas) == 0) {
						$data[0] .= '<td>' . $nombre_proyecto . '-' . count($total_metas) . '</td>';
					} else {
						$data[0] .= '<td rowspan=' . count($total_metas) . '>' . $nombre_proyecto . '   <span class="badge badge-info right">  ' . count($total_metas) . '</span></td>';
					}
					// traemos el id meta para saber en que id estamos 
					for ($s = 0; $s < count($total_metas); $s++) { // imprime las metas
						$id_meta = $total_metas[$s]["id_meta"];
						$id_proyecto = $total_metas[$s]["id_proyecto"];
						$responsable = $total_metas[$s]["meta_responsable"];
						$nombre_meta = $total_metas[$s]["meta_nombre"];
						$data[0] .= ($s == 0) ? '' : '<tr>';
						$data[0] .= '<td>' . $nombre_meta . "<br>" . '</td>';
						$data[0] .= ($s == 0) ? '' : '</tr>';
					}
				}
			}
		}
		$data[0] .= '</tbody>';
		$data[0] .= '</table>';
		$data[0] .= '				
						</div>
					</div>
			</div>
		</div>';
		echo json_encode($data);
		break;
	//listo los ejes 
	case 'ver_plan_accion':
		$anio = $_POST["globalperidioseleccionado"];
		$data[0] = "";
		$listar_metas = $proyecto->mostraraccionespormeta($anio);
		$por_vencer = $proyecto->porvencer();
		$data[0] .= '
			<div class="row">
				<div class="col-6 py-3 pl-4">
					<h5 class="fw-light mb-4 text-secondary pl-4"> </h5>
				</div>
				<div class="col-6 py-3 pl-4 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 d-flex align-items-center">
					<div class="row col-12 d-flex justify-content-end">
						<div class="col-auto cursor-pointer">
							<div class="row justify-content-center">
								<div class="col-12 hidden">
									<div class="row align-items-center">
										<div class="col-auto">
										<div class="avatar rounded bg-light-red text-danger">
										<i class="fa-solid fa-triangle-exclamation fa-2x text-danger"></i>
										</div>
										</div>
										<div class="col ps-0">
										<div class="small mb-0">Total</div>
										<h4 class="text-dark mb-0">
											<span class="text-semibold" onclick="acciones_por_vencer()" id="dato_caracterizados">' . count($por_vencer) . '</span> 
											<small class="text-regular">OK</small>
										</h4>
										<div class="small">Acciones Vencidas <span class="text-green"></span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card col-12">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-8  p-4 tono-3" id="ocultargestionproyecto">
							<div class="row align-items-center">
								<div class="col-auto pl-4">
									<div class="rounded bg-light-blue p-3 text-primary ">
										<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-auto">
									<div class="col-12 fs-14 line-height-18">
										<span class="">Resultados</span> <br>
										<span class="text-semibold fs-20 parrafo-normal">Estrategias</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-4 text-right py-4 pr-4 tono-3">
							<a onclick="volver_panel()" class="btn btn-danger btn-flat float-right text-semibold" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
						</div>
						<div class="panel-body table-responsive p-4" id="ver_tabla_proyecto_acciones">
							<table id="ver_tabla_plan" class="table" style="width:100%">';
		$data[0] .= '<thead>';
		$data[0] .= '<tr>';
		$data[0] .= '<th> Objetivos</th>';
		$data[0] .= '<th>Estrategia</th>';
		$data[0] .= '<th>Cargo</th>';
		$data[0] .= '</tr>';
		$data[0] .= '</thead>';
		$data[0] .= '<tbody class="parrafo-normal fs-14">';
		for ($a = 0; $a < count($listar_metas); $a++) {
			$nombre_accion = $listar_metas[$a]["nombre_accion"];
			$nombre_proyecto = $listar_metas[$a]["nombre_proyecto"];
			$meta_responsable = $listar_metas[$a]["usuario_cargo"];
			$total_proyectos = $proyecto->listarproyecto($listar_metas[$a]["id_accion"]); // consulta para los proyectos
			$data[0] .= '
													<tr>
														<td rowspan="1"><p>' . $nombre_proyecto . '</p></td>
														<td ><p>' . $nombre_accion . '</p></td>
														<td ><p>' . $meta_responsable . '</p></td>
													</tr>';
		}
		$data[0] .= '</tbody>';
		$data[0] .= '</table>';
		$data[0] .= '
						</div>		
					</div>
				</div>
			</div>';
		echo json_encode($data);
		break;
	//listo los ejes 
	case 'acciones_por_vencer':
		$anio = $_POST["globalperidioseleccionado"];
		$data[0] = "";
		$listar_metas = $proyecto->mostraraccionespormeta($anio);
		$data[0] .= '
		<section class="content" style="padding-top: 0px;">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
					<div class="row">
						<div class="card col-12">
							<div class="row">
								<div class="col-6 p-4 tono-3" id="ocultaracciones">
									<div class="row align-items-center">
										<div class="pl-4">
											<span class="rounded bg-light-blue p-3 text-primary ">
												<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
											</span>
										</div>
										<div class="col-10">
											<div class="col-12 fs-14 line-height-18">
												<span class="">Resultados</span> <br>
												<span class="text-semibold fs-20">Acciones por vencer</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-6 text-right py-4 pr-4 tono-3" id="ocultaracciones2">
									<a onclick="volver_panel_acciones()" class="btn btn-danger btn-flat float-right text-semibold" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
								</div>
								';
		$data[0] .= ' 
		<div class="panel-body table-responsive p-4" id="ver_tabla_proyecto">
			<table id="ver_tabla_plan" class="table" style="width:100%">';
		$data[0] .= '<thead>';
		$data[0] .= '<th> Objetivos</th>';
		$data[0] .= '<th> Meta</th>';
		$data[0] .= '<th> Acciones a punto de vencer</th>';
		$data[0] .= '<th> Mes a vencer</th>';
		$data[0] .= '<th> Meta Responsable</th>';
		$data[0] .= '</thead>';
		$data[0] .= '<tbody>';
		for ($a = 0; $a < count($listar_metas); $a++) {
			$nombre = $listar_metas[$a]["nombre_accion"];
			$fecha_fin = $listar_metas[$a]["fecha_fin"];
			$fecha_accion = $listar_metas[$a]["fecha_accion"];
			$accion_estado = $listar_metas[$a]["accion_estado"];
			$nombre_proyecto = $listar_metas[$a]["nombre_proyecto"];
			$meta_nombre = $listar_metas[$a]["meta_nombre"];
			$meta_responsable = $listar_metas[$a]["meta_responsable"];
			// saber la fecha en la que estamos
			$fecha_actual = date('Y-m-d');
			// convertimos la fecha 
			$fechaComoEntero = strtotime($fecha_actual);
			// mostramos el mes actual
			$mes = date("m", $fechaComoEntero);
			$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
			if ($mes > $fecha_fin and $accion_estado == 0) {
				$data[0] .= '<tr>';
				$data[0] .= '<td rowspan=' . '>' . $nombre_proyecto . '</td>';
				$data[0] .= '<td rowspan=' . '>' . $meta_nombre . '</td>';
				$data[0] .= '<td rowspan=' . '>' . $nombre . '</td>';
				$data[0] .= '<td rowspan=' . '>' . $meses[$fecha_fin] . '</td>';
				$data[0] .= '<td rowspan=' . '>' . $meta_responsable . '</td>';
				$data[0] .= '</tr>';
			}
		}
		$data[0] .= '</tbody>';
		$data[0] .= '</table>';
		// $data[0] .= '</div>';
		$data[0] .= '</div>
				</div>
			</div>
		</div>
		</div>
		</div>
	</section>';
		echo json_encode($data);
		break;
	//terminar una accion
	case 'terminar_accion':
		$rspta = $proyecto->terminar_accion($id_accion);
		echo json_encode($rspta);
		break;
	//listar los nombres de meta por usuario
	case 'listar_meta_2022':
		$nombre_meta = $proyecto->listarMetaProyectos_2022($id_proyecto);
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
									Fecha de Entrega: <span class="float-right">' . $proyecto->fechaesp($fecha_entrega) . '</span>
								</li>
								<li class="nav-item p-2">
									Responsable: <span class="float-right">' . $usuario_cargo . '</span>
								</li>
								<li class="nav-item p-2">';
			$condicionesinstitucionales = $proyecto->listarCondicionInstitucionalMeta($id_meta);
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
			$condicionesdeprograma = $proyecto->listarCondicionProgramaMeta($id_meta);
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
			// $corresponsabilidades = $proyecto->listarcondicionesdependencia($id_meta);
			// $data[0] .= '
			// 							Corresponsables:</span>
			// 							<span class="float-right bg-success badge ">' . count($corresponsabilidades) . '</span>';
			// for ($co = 0; $co < count($corresponsabilidades); $co++) {
			// 	$nombre = $corresponsabilidades[$co]["nombre"];
			// 	$data[0] .= '<br><span class="small">' . $nombre . '</span>';
			// }
			// $data[0] .= '
			// 					</li>';
			$data[0] .= '
								<li class="nav-item p-2">
								<h5><b>Acciones Por Meta</b></h5>';
			$listaracciones = $proyecto->listaracciones($id_meta); // consulta para listas las acciones
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
													<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_accion(' . $listaracciones[$c]["id_accion"] . ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
													<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_accion(' . $listaracciones[$c]["id_accion"] . ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
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
	//listar los nombres de meta por usuario
	case 'listar_meta_2024':
		$nombre_meta = $proyecto->listarMetaProyectos_2024($id_proyecto);
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
									Fecha de Entrega: <span class="float-right">' . $proyecto->fechaesp($fecha_entrega) . '</span>
								</li>
								<li class="nav-item p-2">
									Responsable: <span class="float-right">' . $usuario_cargo . '</span>
								</li>
								<li class="nav-item p-2">';
			$condicionesinstitucionales = $proyecto->listarCondicionInstitucionalMeta($id_meta);
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
			$condicionesdeprograma = $proyecto->listarCondicionProgramaMeta($id_meta);
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
			// $corresponsabilidades = $proyecto->listarcondicionesdependencia($id_meta);
			// $data[0] .= '
			// 							Corresponsables:</span>
			// 							<span class="float-right bg-success badge ">' . count($corresponsabilidades) . '</span>';
			// for ($co = 0; $co < count($corresponsabilidades); $co++) {
			// 	$nombre = $corresponsabilidades[$co]["nombre"];
			// 	$data[0] .= '<br><span class="small">' . $nombre . '</span>';
			// }
			// $data[0] .= '
			// 					</li>';
			$data[0] .= '
								<li class="nav-item p-2">
								<h5><b>Acciones Por Meta</b></h5>';
			$listaracciones = $proyecto->listaracciones($id_meta); // consulta para listas las acciones
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
													<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_accion(' . $listaracciones[$c]["id_accion"] . ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
													<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_accion(' . $listaracciones[$c]["id_accion"] . ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
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
	// case 'historico_tabla_indicadores':
	// 	$id_meta_global = $_POST["id_meta_global"];
	// 	$data[0] = "";
	// 	$data[0] .= '<div class="container mt-3">';
	// 	$data[0] .= '<h4>Historial de Indicadores</h4>';
	// 	$listarhistoricoindicadores = $proyecto->listarhistoricoindicadores($id_meta_global);
	// 	if (empty($listarhistoricoindicadores)) {
	// 		$data[0] .= '<div class="alert alert-danger mt-3" role="alert">';
	// 		$data[0] .= 'No se encontraron registros de indicadores para procesar.';
	// 		$data[0] .= '</div>';
	// 	}
	// 	for ($c = 0; $c < count($listarhistoricoindicadores); $c++) {
	// 		$id_meta = $listarhistoricoindicadores[$c]["id_meta"];
	// 		$tipo_indicador = $listarhistoricoindicadores[$c]["tipo_indicador"];
	// 		$fecha = $proyecto->fechaesp($listarhistoricoindicadores[$c]["fecha"]);
	// 		$hora = $listarhistoricoindicadores[$c]["hora"];
	// 		if ($tipo_indicador == 1) {
	// 			$puntaje_anterior = $listarhistoricoindicadores[$c]["puntaje_anterior"];
	// 			if ($puntaje_anterior != 0) {
	// 				$puntaje_anterior = $listarhistoricoindicadores[$c]["puntaje_anterior"];
	// 				$puntaje_actual = $listarhistoricoindicadores[$c]["puntaje_actual"];
	// 				$resultado_incremento = (($puntaje_actual - $puntaje_anterior) / $puntaje_anterior) * 100;
	// 				$data[0] .= '<div class="alert alert-primary mt-3" role="alert">';
	// 				$data[0] .= '<strong>Indicador de Incrementos:</strong><br>';
	// 				$data[0] .= 'Resultado: ' . $resultado_incremento . '%<br>';
	// 				$data[0] .= 'Fecha: ' . $fecha . ' Hora: ' . $hora;
	// 				$data[0] .= '</div>';
	// 			} else {
	// 				$data[0] .= '<div class="alert alert-warning mt-3" role="alert">';
	// 				$data[0] .= 'El incremento no puede ser calculado debido a un puntaje anterior de 0.';
	// 				$data[0] .= '</div>';
	// 			}
	// 		} elseif ($tipo_indicador == 2) {
	// 			$poblacion = $listarhistoricoindicadores[$c]["poblacion"];
	// 			if ($poblacion != 0) {
	// 				$participa = $listarhistoricoindicadores[$c]["participa"];
	// 				$poblacion = $listarhistoricoindicadores[$c]["poblacion"];
	// 				$resultado_participa = ($participa / $poblacion) * 100;
	// 				$data[0] .= '<div class="alert alert-info mt-3" role="alert">';
	// 				$data[0] .= '<strong>Indicador de Participación:</strong><br>';
	// 				$data[0] .= 'Resultado: ' . $resultado_participa . '%<br>';
	// 				$data[0] .= 'Fecha: ' . $fecha . ' Hora: ' . $hora;
	// 				$data[0] .= '</div>';
	// 			} else {
	// 				$data[0] .= '<div class="alert alert-warning mt-3" role="alert">';
	// 				$data[0] .= 'La participación no puede ser calculada debido a una población de 0.';
	// 				$data[0] .= '</div>';
	// 			}
	// 		} elseif (empty($id_meta)) {
	// 			$data[0] .= '<div class="alert alert-warning mt-3" role="alert">';
	// 			$data[0] .= 'No Tiene registros.';
	// 			$data[0] .= '</div>';
	// 		}
	// 	}
	// 	$data[0] .= '</div>';
	// 	echo json_encode($data);
	// 	break;
	//ver el total de las metas cumplidas y las no cumplidas
	case 'ver_total_metas_cumplidas':
		$anio = $_POST['globalperidioseleccionado'];
		$metas = $proyecto->totalmetas($anio);
		$total_metas = count($metas);
		$metasCumplidas = $proyecto->obtenerNumeroMetasCumplidas($anio);
		$total_metas_cumplidas = ($metasCumplidas / $total_metas) * 100;
		$metasNoCumplidas = $proyecto->obtenerNumeroMetasNoCumplidas($anio);
		$total_metasNoCumplidas = ($metasNoCumplidas / $total_metas) * 100;
		$data = array();
		$data["datos_grafico"] = [];
		// Agregar metas cumplidas (ya no se necesita count())
		$data["datos_grafico"][] = array("y" => $total_metas_cumplidas, "name" => "Metas Cumplidas");
		// Agregar metas no cumplidas (ya no se necesita count())
		$data["datos_grafico"][] = array("y" => $total_metasNoCumplidas, "name" => "Metas No Cumplidas");
		echo json_encode($data);
		break;

	// case 'mostrargraficosmeta':
	// $id_ejes_graficos = $_POST["id_ejes"];
	// $anio = "";
	// if (isset($_POST['globalperidioseleccionado'])) {
	//     $anio = $_POST['globalperidioseleccionado'];
	// }
	// $total_ejes_grafico = $proyecto->mostrar_eje_grafico($id_ejes_graficos);

	// $id_proyectos_array = [];
	// foreach ($total_ejes_grafico as $fila) {
	//     $id_proyectos_array[] = $fila['id_proyecto'];
	// }
	// $id_proyectos_graficas = implode(",", $id_proyectos_array);
	// // Metas cumplidas y no cumplidas
	// $metasCumplidas = $proyecto->total_metas_grafica_cumplidas($id_proyectos_graficas, $anio);
	// $metasNoCumplidas = $proyecto->total_metas_grafica_no_cumplidas($id_proyectos_graficas, $anio);
	// // Tareas cumplidas y no cumplidas
	// $tareas = $proyecto->totaldetareasgrafica($id_ejes_graficos, $anio);

	// $tareasCumplidas = 0;
	// $tareasNoCumplidas = 0;
	// foreach ($tareas as $tarea) {
	//     if ($tarea['estado_tarea'] == 1) {
	//         $tareasCumplidas++;
	//     } else {
	//         $tareasNoCumplidas++;
	//     }
	// }
	// // Calcular totales para porcentaje (metas)
	// $totalMetas = $metasCumplidas + $metasNoCumplidas;
	// $porcentajeMetasCumplidas = ($totalMetas > 0) ? ($metasCumplidas / $totalMetas) * 100 : 0;
	// $porcentajeMetasNoCumplidas = 100 - $porcentajeMetasCumplidas;
	// // Calcular totales para porcentaje (tareas)
	// $totalTareas = $tareasCumplidas + $tareasNoCumplidas;
	// $porcentajeTareasCumplidas = ($totalTareas > 0) ? ($tareasCumplidas / $totalTareas) * 100 : 0;
	// $porcentajeTareasNoCumplidas = 100 - $porcentajeTareasCumplidas;
	// // Preparar arreglo para tu gráfica (usando "datos_grafico" que usa tu JS)
	// $data = [];

	// // Aquí unifico metas y tareas en un solo arreglo para que puedas usar en la gráfica
	// // Ejemplo: 4 elementos, primero metas cumplidas, metas no cumplidas, tareas cumplidas, tareas no cumplidas
	// $data["datos_grafico"] = [
	//     ["y" => $metasCumplidas, "name" => "Metas Cumplidas"],
	//     ["y" => $metasNoCumplidas, "name" => "Metas No Cumplidas"],
	//     ["y" => $tareasCumplidas, "name" => "Tareas Cumplidas"],
	//     ["y" => $tareasNoCumplidas, "name" => "Tareas No Cumplidas"]
	// ];
	// // Mantener datos para la gráfica 2 si quieres, igual que antes
	// $data["datos_grafico2"] = [];
	// $totalmetasporejes = $proyecto->totalmetasporejes($id_proyectos_graficas, $anio);
	// if (is_array($totalmetasporejes)) {
	//     foreach ($totalmetasporejes as $metasporeje) {
	//         $nombre_proyecto = $metasporeje["nombre_proyecto"];
	//         $data["datos_grafico2"][] = ["y" => $total_metasNoCumplidas, "name" => $nombre_proyecto];
	//     }
	// }
	// echo json_encode($data);
	// break;


	case 'mostrargraficosmeta':
		$id_ejes_graficos = $_POST["id_ejes"];
		$anio = "";
		if (isset($_POST['globalperidioseleccionado'])) {
			$anio = $_POST['globalperidioseleccionado'];
		}
		$total_ejes_grafico = $proyecto->mostrar_eje_grafico($id_ejes_graficos);
		$id_proyectos_array = [];
		for ($i = 0; $i < count($total_ejes_grafico); $i++) {
			$id_proyectos_array[] = $total_ejes_grafico[$i]['id_proyecto'];
		}
		$id_proyectos_graficas = implode(",", $id_proyectos_array);
		//metodo para calcular el promedio de avance de los proyectos según los id_proyectos y el año
		$promedioAvance = $proyecto->promedio_avance_metas_por_eje($id_proyectos_graficas, $anio);
		// Crea un arreglo $data para almacenar la información que se va a enviar en la respuesta JSON
		$data = [];
		// Se almacena el promedio de avance en el arreglo, redondeado a 2 decimales
		$data["datos_grafico"] = [["y" => round($promedioAvance, 2), "name" => " % Avance"]];
		$data["promedio_avance"] = round($promedioAvance, 2);
		echo json_encode($data);

		break;
	case 'listar_meta_2025':
		$nombre_meta = $proyecto->listarMetaProyectos_2025($id_proyecto);
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
										Fecha de Entrega: <span class="float-right">' . $proyecto->fechaesp($fecha_entrega) . '</span>
									</li>
									<li class="nav-item p-2">
										Responsable: <span class="float-right">' . $usuario_cargo . '</span>
									</li>
									<li class="nav-item p-2">';
			$condicionesinstitucionales = $proyecto->listarCondicionInstitucionalMeta($id_meta);
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
			$condicionesdeprograma = $proyecto->listarCondicionProgramaMeta($id_meta);
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
			// $corresponsabilidades = $proyecto->listarcondicionesdependencia($id_meta);
			// $data[0] .= '
			// 								Corresponsables:</span>
			// 								<span class="float-right bg-success badge ">' . count($corresponsabilidades) . '</span>';
			// for ($co = 0; $co < count($corresponsabilidades); $co++) {
			// 	$nombre = $corresponsabilidades[$co]["nombre"];
			// 	$data[0] .= '<br><span class="small">' . $nombre . '</span>';
			// }
			// $data[0] .= '
			// 						</li>';
			$data[0] .= '
									<li class="nav-item p-2">
									<h5><b>Acciones Por Meta</b></h5>';
			$listaracciones = $proyecto->listaracciones($id_meta); // consulta para listas las acciones
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
														<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_accion(' . $listaracciones[$c]["id_accion"] . ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
														<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_accion(' . $listaracciones[$c]["id_accion"] . ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
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

	case 'listartareas':
		$anio = $_GET["globalperidioseleccionado"];
		$id_ejes = $_GET["id_ejes"];
		$rspta	= $proyecto->totaldetareas($id_ejes, $anio);
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$id_tarea_sac = $reg[$i]["id_tarea_sac"];
			$nombre_tarea = $reg[$i]["nombre_tarea"];
			$fecha_entrega = $reg[$i]["fecha_entrega_tarea"];
			$meta_responsable = $reg[$i]["responsable_tarea"];
			$link_evidencia_tarea = $reg[$i]["link_evidencia_tarea"];
			$datosusuario = $proyecto->DatosUsuario($meta_responsable);
			$nombre1 = $datosusuario["usuario_nombre"];
			$nombre2 = $datosusuario["usuario_nombre_2"];
			$apellido1 = $datosusuario["usuario_apellido"];
			$apellido2 = $datosusuario["usuario_apellido_2"];
			$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;
			$estado_tarea = ($reg[$i]["estado_tarea"] == 0)  ? '<span class="bg-danger p-1"><i class="fas fa-times"></i> No Terminada</span>' : '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
			$botones = '<div class="btn-group">';
			$botones .= '<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_tarea(' . $id_tarea_sac . ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>';
			if ($reg[$i]["estado_tarea"] == 0) {
				$botones .= '<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_tareas(' . $id_tarea_sac . ')" title="Eliminar Acción" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
			}
			$botones .= '</div>';

			$data[] = array(
				"0" => $botones,
				"1" => $nombre_tarea,
				"2" => $proyecto->fechaesp($fecha_entrega),
				"3" => $nombre_completo,
				"4" => '<a href="' . $link_evidencia_tarea . '" target="_blank"><i class="fas fa-external-link-alt"></i> Ver</a>',
				"5" => $estado_tarea
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;

	case "selectListarResponsableTrea":
		$rspta = $proyecto->selectlistarResponsableTarea();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
		}
		break;

	case 'mostrar_tarea':
		// $id_accion = $_POST["id_accion"];
		$rspta = $proyecto->mostrar_tarea($id_tarea_sac);
		echo json_encode($rspta);
		break;

	case 'guardaryeditartarea':
		$periodos = $proyecto->periodoactual();
		$periodo = $periodos["periodo_actual"];
		$periodo_actual = explode("-", $periodo)[0];
		if (empty($id_tarea_sac)) {
			$rspta = $proyecto->insertartarea($nombre_tarea, $fecha_tarea, $responsable_tarea, $id_accion_tarea, $periodo_actual, $id_meta_tarea, $link_tarea);
			echo $rspta ? "Tarea registrada" : "Tarea no se pudo registrar";
		} else {
			$rspta = $proyecto->editartarea($nombre_tarea, $fecha_tarea, $responsable_tarea, $link_tarea, $id_tarea_sac);
			echo $rspta ? "Tarea actualiada" : "Tarea no se pudo actualizar";
		}
		break;

	case 'eliminar_tareas':
		// $id_tarea_sac = $_POST["id_tarea_sac"];
		$rspta = $proyecto->eliminar_tarea($id_tarea_sac);
		echo json_encode($rspta);
		break;

	//dependiendo del id_meta recibido y el porcentaje avance lo actualizamos en la tabla de sac_meta.
	case 'actualizarPorcentaje':
		$id_meta = $_POST["id_meta"];
		$porcentaje = $_POST["porcentaje_avance"];
		$rspta = $proyecto->actualizarPorcentajeMeta($id_meta, $porcentaje);
		echo json_encode($rspta);
		break;

	case "selectlistaranios":
		$rspta = $proyecto->selectlistaranios();
		for ($i = 0; $i < count($rspta); $i++) {
			// $anio = $rspta[$i]["anio"];
			// echo "<option value='$anio'>$anio</option>";
			echo "<option value='" . $rspta[$i]["anio"] . "'>" . $rspta[$i]["anio"] . "</option>";
		}

		break;



	case 'ver_plan_tareas':
		$anio = $_GET["globalperidioseleccionado"];
		$listar_tareas = $proyecto->mostrar_tareas($anio);
		// mostramos el total de las tareas cumplidas y las no cumplidas
		$tareasCumplidas1 = $proyecto->obtenerNumeroTareasCumplidas($anio);
		$tareasNoCumplidas2 = $proyecto->obtenerNumeroTareasNoCumplidas($anio);
		$data = array();
		$reg = $listar_tareas;
		$total_cumplidas_tarea = 0;
		$total_no_cumplidas_tarea = 0;
		$hoy = strtotime(date('Y-m-d'));
		for ($a = 0; $a < count($reg); $a++) {
			$total_cumplidas_tarea = ($reg[$a]["estado_tarea"] == 1) ? $total_cumplidas_tarea + 1 : $total_cumplidas_tarea;
			$total_no_cumplidas_tarea = $a - $total_cumplidas_tarea;
			$nombre_tarea = $reg[$a]["nombre_tarea"];
			$meta_nombre = !empty($reg[$a]["meta_nombre"]) ? $reg[$a]["meta_nombre"] : '<span class="text-danger">Sin meta vinculada</span>';
			$fecha_entrega_tarea = $reg[$a]["fecha_entrega_tarea"];
			$link_evidencia_tarea = $reg[$a]["link_evidencia_tarea"];
			$nombre_accion = $reg[$a]["nombre_accion"];
			// traemos el id del responsable para buscar el nombre
			$responsable_tarea = $reg[$a]["responsable_tarea"];
			// para saber si la tarea esta finalizada o no.
			$estado_tarea = $reg[$a]["estado_tarea"];
			
			if ($estado_tarea == 1) {
				$estado_tarea = '<span class="badge badge-success">Finalizada</span>';
			} else {
				$estado_tarea = '<span class="badge badge-danger">No finalizada</span>';
			}
			$nombre_funcionario = $proyecto->nombre_funcionario($responsable_tarea);
			$usuario_nombre = $nombre_funcionario["usuario_nombre"];
			$usuario_nombre_2 = $nombre_funcionario["usuario_nombre_2"];
			$usuario_apellido = $nombre_funcionario["usuario_apellido"];
			$usuario_apellido_2 = $nombre_funcionario["usuario_apellido_2"];
			$nombre_completo_funcionario = $usuario_nombre . " " . $usuario_nombre_2 . " " . $usuario_apellido . " " . $usuario_apellido_2;
			$link_evidencia =  (!empty($link_evidencia_tarea)  ? '<a class="btn btn-info btn-flat btn-xs" href="' . $link_evidencia_tarea . '" target="_blank" title="Ver evidencia"> <i class="fas fa-eye"></i> </a>'  : 'Sin link de evidencia');
			
			// se calcula la diferencia de la siguiente manera en días: si obtenemos el resultado positivo = faltan dias, si es negativo = ya vencio
			$diasComparacionEntrega = (int)((strtotime($fecha_entrega_tarea) - $hoy) / 86400);
			// evaluamos el estado segun los días de diferencia
			if ($diasComparacionEntrega < 0) {
				// Si la diferencia es negativa, ya está vencida
				$estado_vencido = '<span class="badge badge-danger">Vencida</span>';
				// usamos abs para dejar el resultado en positivo
				$dias_vencidos   = abs($diasComparacionEntrega) . ' día' . (abs($diasComparacionEntrega) == 1 ? '' : 's');
			} elseif ($diasComparacionEntrega > 0) {
				// si el resultado es positivo, faltan dias por vencer
				$estado_vencido = '<span class="badge badge-info">Por vencer</span>';
				//si es igual a 1 se mostrara dia y si es diferente de 1 mostrara dias.
				$dias_vencidos   = $diasComparacionEntrega . ' día' . ($diasComparacionEntrega == 1 ? '' : 's');
			} else {
				// si es igual a 0, la fecha de entrega es hoy
				$estado_vencido = '<span class="badge badge-warning">Vence hoy</span>';
				$dias_vencidos   = '0 días';
			}

			$data[] = array(
				"0" => '<strong class="text-secondary"><br>' . ($a + 1) . '</span>: </b>' . $meta_nombre,
				"1" => $nombre_accion,
				"2" => $nombre_tarea,
				"3" => $proyecto->fechaesp($fecha_entrega_tarea),
				"4" => $link_evidencia,
				"5" => $nombre_completo_funcionario,
				"6" => $estado_tarea,
				"7" => $estado_vencido,   
				"8" => $dias_vencidos     

			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data,
			"totalCumplidasTarea" => $total_cumplidas_tarea,
			"totalNoCumplidasTarea" => $total_no_cumplidas_tarea
		);
		echo json_encode($results);
		break;
}
