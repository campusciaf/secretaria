<?php
require_once "../modelos/SacListarDependencia.php";
$sacListarDependencia = new SacListarDependencia();

$rsptaperiodo = $sacListarDependencia->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
list($anio, $semestre) = explode('-', $periodo_actual);
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
$sac_periodo = $rsptaperiodo["sac_periodo"];


date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:s');


$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");


$id_usuario  = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$usuario_poa  = isset($_POST["usuario_poa"]) ? limpiarCadena($_POST["usuario_poa"]) : "";
$usuario_cargo  = isset($_POST["usuario_cargo"]) ? limpiarCadena($_POST["usuario_cargo"]) : "";
// $meta_responsable  = isset($_POST["meta_responsable"]) ? limpiarCadena($_POST["meta_responsable"]) : "";
$id_meta  = isset($_POST["id_meta"]) ? limpiarCadena($_POST["id_meta"]) : "";
$periodo  = isset($_POST["periodo"]) ? limpiarCadena($_POST["periodo"]) : "";

//variables agregar la meta
$meta_nombre  = isset($_POST["meta_nombre"]) ? limpiarCadena($_POST["meta_nombre"]) : "";
$plan_mejoramiento  = isset($_POST["plan_mejoramiento"]) ? limpiarCadena($_POST["plan_mejoramiento"]) : "";
$anio_eje = isset($_POST["anio_eje"]) ? limpiarCadena($_POST["anio_eje"]) : "";
$fecha_inicio = isset($_POST["fecha_inicio"]) ? limpiarCadena($_POST["fecha_inicio"]) : "";
$meta_fecha = isset($_POST["meta_fecha"]) ? limpiarCadena($_POST["meta_fecha"]) : "";
$meta_responsable = isset($_POST["meta_responsable"]) ? limpiarCadena($_POST["meta_responsable"]) : "";


$id_eje  = isset($_POST["nombre_ejes"]) ? limpiarCadena($_POST["nombre_ejes"]) : "";
$condicion_programa   = isset($_POST["condicion_programa"]) ? limpiarCadena($_POST["condicion_programa"]) : "";
$condicion_institucional  = isset($_POST["condicion_institucional"]) ? limpiarCadena($_POST["condicion_institucional"]) : "";
$dependencias  = isset($_POST["dependencias"]) ? $_POST["dependencias"] : "";
// variables de id_eje y id_proyecto para insertar
$id_eje  = isset($_POST["id_eje"]) ? limpiarCadena($_POST["id_eje"]) : "";
$id_proyecto  = isset($_POST["id_proyecto"]) ? limpiarCadena($_POST["id_proyecto"]) : "";

// variables de id_eje y id_proyecto para editar
$nombre_ejes  = isset($_POST["nombre_ejes"]) ? limpiarCadena($_POST["nombre_ejes"]) : "";
$nombre_proyectos  = isset($_POST["nombre_proyectos"]) ? limpiarCadena($_POST["nombre_proyectos"]) : "";


// variables indicadores
$indicador_inserta  = isset($_POST["indicador_inserta"]) ? limpiarCadena($_POST["indicador_inserta"]) : "";
$puntaje_anterior  = isset($_POST["puntaje_anterior"]) ? limpiarCadena($_POST["puntaje_anterior"]) : "";
$puntaje_actual  = isset($_POST["puntaje_actual"]) ? limpiarCadena($_POST["puntaje_actual"]) : "";
$indicador_sin_formula  = isset($_POST["indicador_sin_formula"]) ? limpiarCadena($_POST["indicador_sin_formula"]) : "";
$indicador_formula_o_sin_formula  = isset($_POST["indicador_formula_o_sin_formula"]) ? limpiarCadena($_POST["indicador_formula_o_sin_formula"]) : "";

// valores indicadores de participacion 
$nombre_indicador  = isset($_POST["nombre_indicador"]) ? limpiarCadena($_POST["nombre_indicador"]) : "";
// se hace esta validacion para que cuando llegue el porcentaje avance  vacio le agregue un 0
$porcentaje_avance_indicador = isset($_POST["porcentaje_avance_indicador"]) && is_numeric($_POST["porcentaje_avance_indicador"]) && $_POST["porcentaje_avance_indicador"] !== '' ? (int)$_POST["porcentaje_avance_indicador"] : 0;

// Cumplimiento de las metas
$meta_lograda  = isset($_POST["meta_lograda"]) ? limpiarCadena($_POST["meta_lograda"]) : "";
// $nombre_proyectos  = isset($_POST["nombre_proyectos"]) ? limpiarCadena($_POST["nombre_proyectos"]) : "";
// plan de mejoramiento.

// qagregar accion
$id_meta_accion  = isset($_POST["id_meta_accion"]) ? limpiarCadena($_POST["id_meta_accion"]) : "";
$nombre_accion  = isset($_POST["nombre_accion"]) ? limpiarCadena($_POST["nombre_accion"]) : "";
$fecha_fin  = isset($_POST["fecha_fin"]) ? limpiarCadena($_POST["fecha_fin"]) : "";
$hora_accion  = isset($_POST["hora_accion"]) ? limpiarCadena($_POST["hora_accion"]) : "";

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


	//listar los nombres de meta por usuario
	case 'modopanel':
		$meta_responsable = $_POST["meta_responsable"];
		$data[0] = "";
		$contaacordeonp = 1;
		$contaacordeon = 1;

		$misejes = $sacListarDependencia->selectlistarEjes();
		$data[0] .= '
			<div class="row mx-0 ">';
		for ($e = 0; $e < count($misejes); $e++) {
			$id_ejes = $misejes[$e]["id_ejes"];
			$data[0] .= '
					<div class="col-xl-3">
						<div class="col-12 text-semibold fs-12 text-center">' . $misejes[$e]["nombre_corto"] . '</div>';


			$nombre_meta = $sacListarDependencia->listarMetaUsuario($id_ejes, $sac_periodo);


			$data[0] .= '
						<div  class="row m-0" id="ocultar_datos">';
			for ($f = 0; $f < count($nombre_meta); $f++) {
				$contador = $f + 1;
				$id_meta = $nombre_meta[$f]["id_meta"];

				$meta = mb_strtolower($nombre_meta[$f]["meta_nombre"], 'UTF-8');
				$primera_letra = mb_strtoupper(mb_substr($meta, 0, 1, 'UTF-8'), 'UTF-8');
				$resto_texto = mb_substr($meta, 1, null, 'UTF-8');
				$texto_formateado = $primera_letra . $resto_texto;

				$listarresponsables = $sacListarDependencia->listarresponsables($id_meta);


				$fecha_entrega = $nombre_meta[$f]["meta_fecha"];
				$responsable = $nombre_meta[$f]["usuario_cargo"];
				$nombre_proyecto = $nombre_meta[$f]["nombre_proyecto"];
				$plan_mejoramiento = $nombre_meta[$f]["plan_mejoramiento"];
				$contaacordeonp++;
				$data[0] .= '
								<div class="col-12 p-2">
									<div class="row mx-0">
										<div class="card col-12">
											<div class="row mx-0">
												
												<div class="col-12 py-2 borde-bottom">
													<div class="row">
														<div class="col-9">
															<i class="fa-solid fa-calendar-days text-gray"></i> <span class="text-gray"> ' . $sacListarDependencia->fechaCompletaCorta($fecha_entrega) . '</span>
														</div>
														<div class="col-3 text-right">
															<button onclick="listar_marcadas_meta(' . $id_meta . ')" class="btn btn-primary btn-xs" title="Editar Meta"><i class="fas fa-pencil-alt"></i></button>
															<button onclick="eliminar_meta_listar_dependencia(' . $id_meta . ')" class="btn btn-danger btn-xs" title="Eliminar Meta"><i class="far fa-trash-alt"></i></button>
														</div>
													</div>
												</div>
											

												<div class="col-12 p-2 line-height-16 ">
													<div class="fs-14 font-weight-bolder pb-2"><a onclick="detalle(' . $id_meta . ')" class="pointer">' . $contador . '. ' . $texto_formateado . '</a></div>
													
												</div>';

				foreach ($listarresponsables as $id_responsable) {
					$datosresponsable = $sacListarDependencia->DatosUsuario($id_responsable);
					$nombre_responsable = $datosresponsable["usuario_nombre"] . ' ' . $datosresponsable["usuario_apellido"];
					$colorusuario = $datosresponsable["usuario_color"];
					$primernombre = mb_strtoupper(mb_substr($datosresponsable["usuario_nombre"], 0, 1, 'UTF-8'), 'UTF-8');
					$primerapellido = mb_strtoupper(mb_substr($datosresponsable["usuario_apellido"], 0, 1, 'UTF-8'), 'UTF-8');
					$iniciales = $primernombre . $primerapellido;
					$data[0] .= '<span class="pt-2 rounded-circle text-center  text-semibold text-white fs-12" title="' . $nombre_responsable . '" style="background-color:' . $colorusuario . ';width:36px;height:36px">' . $iniciales . '</span>';
				}



				$data[0] .= '
												<div class="col-12 accordion m-0 p-0" id="accordionprincipal' . $contador . '">

													<div class="m-0 p-0">
														<div class="card-header" id="posicion' . $contaacordeonp . '">
															<h2 class="mb-0">
																<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#conteac' . $contaacordeonp . '" aria-expanded="false" aria-controls="conteac' . $contaacordeonp . '">
																	Ver contenido de la meta
																	<i class="fa-solid fa-chevron-down float-right"></i>
																</button>
															</h2>
														</div>
														<div id="conteac' . $contaacordeonp . '" class="collapse" aria-labelledby="posicion" data-parent="#accordionprincipal' . $contador . '">
															<div class="card-body p-1">
																<div class="row">

																	<div class="fs-12 ml-2">' . $nombre_proyecto . '</div>

																	<div class="col-12 p-2 line-height-16">
																		
																		<div class="fs-14 font-weight-bolder pb-2">Opción de mejora</div>
																		<div class="fs-12 ml-4">' . $plan_mejoramiento . '</div>
																	</div>

																	
																	<div class="col-6 p-2">';
				// Condiciones institucionales
				$condicionesinstitucionales = $sacListarDependencia->listarCondicionInstitucionalMeta($id_meta);
				$data[0] .= '<div><b>Condiciones Institucionales</b></div>';
				for ($ci = 0; $ci < count($condicionesinstitucionales); $ci++) {
					$nombre_condicion = $condicionesinstitucionales[$ci]["nombre_condicion"];
					$data[0] .= '<div class="fs-12 text-gray">' . $nombre_condicion . '</div>';
				}
				$data[0] .= '
																	</div>
																	<div class="col-6 p-2">';

				// Condiciones de programa
				$condicionesdeprograma = $sacListarDependencia->listarCondicionProgramaMeta($id_meta);
				$data[0] .= '<div><b>Condiciones de programa:</b></div>';
				for ($cp = 0; $cp < count($condicionesdeprograma); $cp++) {
					$nombre_programa = $condicionesdeprograma[$cp]["nombre_condicion"];
					$data[0] .= '<div class="small text-gray">' . $nombre_programa . '</div>';
				}
				$data[0] .= '
																	</div>';
				// Acciones de la meta
				$data[0] .= '
																	<div class="col-12 p-2">
																			<span class="fs-18"><b>Acciones</b></span>
																			<a onclick="agregaraccion(' . $id_meta . ')" class="btn  btn-primary btn-sm float-right text-white">
																				<i class="fas fa-plus"></i>  Acciones
																			</a>
																	</div>';
				$listaracciones = $sacListarDependencia->listaracciones($id_meta);
				$todas_acciones_y_tareas_terminadas = true;
				$data[0] .= '

																	<div class="accordion col-12" id="accordionExample' . $contador . '">';
				for ($c = 0; $c < count($listaracciones); $c++) {
					$accion = $listaracciones[$c];
					$id_accion = $accion["id_accion"];
					$total_tareas = $sacListarDependencia->contarTareasPorAccion($id_accion);
					$tareas_finalizadas = $sacListarDependencia->contarTareasFinalizadasPorAccion($id_accion);
					$porcentaje = $total_tareas > 0 ? round(($tareas_finalizadas / $total_tareas) * 100) : 0;

					$color_barra = '';
					if ($porcentaje < 50) {
						$color_barra = 'bg-danger';
					} elseif ($porcentaje < 100) {
						$color_barra = 'bg-warning';
					} else {
						$color_barra = 'bg-success';
					}
					$mostrar_tareas = $sacListarDependencia->mostrartareas($id_accion);
					$cantidad_tareas = count($mostrar_tareas);
					$todas_terminadas = true;


					for ($j = 0; $j < $cantidad_tareas; $j++) {
						if ($mostrar_tareas[$j]["estado_tarea"] == 0) {
							$todas_terminadas = false;
							break;
						}
					}
					if ($accion["accion_estado"] == 0 || !$todas_terminadas) {
						$todas_acciones_y_tareas_terminadas = false;
					}

					$contaacordeon++;
					$data[0] .= '

																			<div class="card">
																				<div class="card-header tono-2" id="headingOne' . $contaacordeon . '">
																					
																						<div class="row">
																							<div class="col-10">
																								<i class="fa-solid fa-calendar-days text-gray fs-12"></i> <span class="text-semibold fs-12 text-gray">' . $sacListarDependencia->fechaesp($accion["fecha_fin"]) . '</span>
																							</div>
																							<div class="col-2 ">';

					if ($accion["accion_estado"] == 0) {

						if ($cantidad_tareas > 0 && $todas_terminadas) {
							$data[0] .= '<button class="btn  btn-xs text-primary" onclick="terminar_accion_dependencia(' . $id_accion . ')" title="Terminar acción"><i class="fas fa-check"></i></button>';
						}
						$data[0] .= '
																									<button class="btn  btn-xs text-warning" onclick="mostrar_accion_modal(' . $id_accion . ')" title="Editar acción"><i class="fas fa-pencil-alt"></i></button>';
						if ($cantidad_tareas == 0) {
							$data[0] .= '
																										<button class="btn  btn-xs " onclick="eliminar_accion(' . $id_accion . ')" title="Eliminar acción">
																											<i class="far fa-trash-alt text-danger"></i>
																										</button>';
						}
					} else {
						$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
					}
					$data[0] .= '
																						
																							</div>
																							<div class="col-12">
																								<span class="text-left collapsed pointer btn-block"  data-toggle="collapse" data-target="#collapseOne' . $contaacordeon . '" aria-expanded="false" aria-controls="collapseOne' . $contaacordeon . '">
																									<span class="fs-14 ">' . $accion["nombre_accion"] . '</span>
																								</span>
																							</div>
																							
																							<div class="col-7 pt-2">
																								<div class="progress progress-sm">
																									<div class="progress-bar ' . $color_barra . '" style="width: ' . $porcentaje . '%"></div>
																								</div>
																							</div>
																							<div class="col-2 pt-1">
																								<span class="text-semibold fs-12">' . $porcentaje . '% </span>
																							</div>
																							<div class="col-3 text-right">
																								<div class="btn-group">
																									<button class="btn bg-purple btn-xs" onclick="CrearTarea(' . $id_accion . ', ' . $id_meta . ')"><i class="fas fa-plus-circle"></i> tarea</button>
																								</div>
																							</div>
																							
																							
																						</div>
																					
																				</div>

																				<div id="collapseOne' . $contaacordeon . '" class="collapse" aria-labelledby="headingOne' . $contaacordeon . '" data-parent="#accordionExample' . $contador . '">
																					<div class="card-body col-12">';

					for ($n = 0; $n < count($mostrar_tareas); $n++) {
						$id_tarea_sac = $mostrar_tareas[$n]["id_tarea_sac"];
						$nombre_tarea = $mostrar_tareas[$n]["nombre_tarea"];
						$fecha_entrega =    $mostrar_tareas[$n]["fecha_entrega_tarea"];
						$meta_responsable = $mostrar_tareas[$n]["responsable_tarea"];
						$link_evidencia_tarea = $mostrar_tareas[$n]["link_evidencia_tarea"];
						$datosusuario = $sacListarDependencia->DatosUsuario($meta_responsable);
						$nombre1 = $datosusuario["usuario_nombre"];
						$nombre2 = $datosusuario["usuario_nombre_2"];
						$apellido1 = $datosusuario["usuario_apellido"];
						$apellido2 = $datosusuario["usuario_apellido_2"];
						$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;

						$data[0] .= '
																										<div class="row borde-bottom py-2" >
																									
																											<div class="col-8">

																												<div class="row">
																													<div class="col-12 fs-14">' . ($n + 1) . ' ' . $nombre_tarea . ' </div>
																												
																													<div class="col-12 small text-gray">' . $sacListarDependencia->fechaesp($fecha_entrega) . '</div>
																													<div class="col-12 fs-12">' . $nombre_completo . '</div>

																												</div>
																											</div>

																											<div class="col-4">
																												<div class="row">
																													<div class="col-12" >';
						if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
							$data[0] .= '<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_tarea_accion(' . $mostrar_tareas[$n]["id_tarea_sac"] . ', ' . $id_accion . ')" title="Marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>';
						} else {
							$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
						}

						if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
							$data[0] .= '
																																<button class="btn text-warning btn-xs" onclick="mostrar_tarea(' . $id_tarea_sac . ', ' . $id_accion . ')" title="Editar tarea"><i class="fas fa-pencil-alt"></i></button>
																																<button class="btn text-danger btn-xs" onclick="eliminar_tareas(' . $id_tarea_sac . ')" title="Eliminar tarea">
																																	<i class="far fa-trash-alt"></i>
																																</button>';
						}

						$data[0] .= '
																															' . ($link_evidencia_tarea
							? '<a href="' . htmlspecialchars($link_evidencia_tarea) . '" target="_blank"><i class="fa-solid fa-link"></i></a>'
							: '') . '
																													</div>
																												</div>
																											</div>
																										</div>';
					}

					$data[0] .= '
																							
																					</div>
																				</div>
																			</div>';

					if ($todas_acciones_y_tareas_terminadas && count($listaracciones) > 0) {
						$data[0] .= '
																				<div class="row">
																					<label>Estado Meta</label>
																					<div class="btn-group btn-group-toggle col-12" data-toggle="buttons">
																						<label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'active' : '') . '">
																							<input style="height: 0.5px" type="radio" id="meta_lograda" name="meta_lograda" value="1" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'checked' : '') . '> SI
																						</label>
																						<label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'active' : '') . '">
																							<input style="height: 0.5px" name="meta_lograda" value="0" type="radio" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'checked' : '') . '> NO
																						</label>
																					</div>
																				</div>';
					}
				}
				$data[0] .= ' 
																	</div>';


				$data[0] .= '
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
			$data[0] .= '
						</div>';


			$data[0] .= '	
					</div>';
		}

		$data[0] .= '
			</div>';

		echo json_encode($data);
		break;

	case 'modocuadricula':
		$metas = $sacListarDependencia->listarMetaGeneral($sac_periodo);
		//Vamos a declarar un array
		$data = array();

		for ($i = 0; $i < count($metas); $i++) {
			$id_meta = $metas[$i]["id_meta"];
			$fechainiciometa = $metas[$i]["fecha_inicio"];

			$meta = mb_strtolower($metas[$i]["meta_nombre"], 'UTF-8');
			$primera_letra = mb_strtoupper(mb_substr($meta, 0, 1, 'UTF-8'), 'UTF-8');
			$resto_texto = mb_substr($meta, 1, null, 'UTF-8');
			$nombremeta = $primera_letra . $resto_texto;

			$acciones = $sacListarDependencia->listaracciones($id_meta);
			$tareas = $sacListarDependencia->listartareas($id_meta);

			$vencimiento = $metas[$i]["meta_fecha"];

			$responsable = $metas[$i]["meta_responsable"];
			$datosresponsable = $sacListarDependencia->DatosUsuario($responsable);
			$responsable = $datosresponsable["usuario_nombre"] . ' ' . $datosresponsable["usuario_apellido"];

			$id_eje = $metas[$i]["id_eje"];
			$datosejes = $sacListarDependencia->datosEjes($id_eje);

			$dataResponsables = ''; // inicializa antes del foreach
			$listarresponsables = $sacListarDependencia->listarresponsables($id_meta);



			foreach ($listarresponsables as $id_responsable) {
				$datosresponsablet = $sacListarDependencia->DatosUsuario($id_responsable);

				if (!empty($datosresponsablet)) {
					$nombre_responsable = trim(($datosresponsablet["usuario_nombre"] ?? '') . ' ' . ($datosresponsablet["usuario_apellido"] ?? ''));
					$colorusuario       = $datosresponsablet["usuario_color"] ?? '#000000'; // valor por defecto
					$primernombre       = mb_strtoupper(mb_substr($datosresponsablet["usuario_nombre"] ?? '', 0, 1, 'UTF-8'), 'UTF-8');
					$primerapellido     = mb_strtoupper(mb_substr($datosresponsablet["usuario_apellido"] ?? '', 0, 1, 'UTF-8'), 'UTF-8');
				} else {
					$nombre_responsable = 'Sin responsable';
					$colorusuario       = '#000000';
					$primernombre       = '';
					$primerapellido     = '';
				}


				$iniciales = $primernombre . $primerapellido;
				$dataResponsables .= '<span class="p-1 rounded-circle text-center  text-semibold text-white fs-10" title="' . $nombre_responsable . '" style="background-color:' . $colorusuario . ';width:36px !important;height:36px !important">' . $iniciales . '</span>';
			}
			//listamos los usuarios responsables que estan activos
			$responsable_meta = '<span class="editar-responsable small" data-id_meta="' . $id_meta . '" data-responsable_nombre="' . htmlspecialchars($responsable) . '">' . htmlspecialchars($responsable) . '</span>';
			$data[] = array(
				"0" => $id_meta,
				"1" => '<div class="row" style="width:440px">
							<div class="pt-2" style="width:400px; height:25px !important; overflow:hidden !important">
								<span class="nombremeta-editable pointer" title="' . htmlspecialchars($nombremeta) . '" data-id="' . $id_meta . '" data-nombre="' . htmlspecialchars($nombremeta) . '">' . htmlspecialchars($nombremeta) . '</span>
							</div>
							<div class="" style="width:20px; padding-top:12px">
								<a onclick="detalle(' . $id_meta . ')" class="text-primary pointer" title="Ver detalles de la meta">
									<i class="fa-solid fa-circle-info "></i>
								</a>
							</div>
							<div class="dropdown" style="width:20px">
								<button class="btn btn-sm dropdown-toggle semibold titulo-2 fs-12 p-0 m-0" type="button" data-toggle="dropdown" aria-expanded="false">
									<i class="fa-solid fa-ellipsis-vertical"></i>
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" onclick="detalle(' . $id_meta . ')">Abrir detalles</a>
									<a class="dropdown-item" href="#">Proyecto</a>
									<a class="dropdown-item" onclick="acciones(' . $id_meta . ')" >Acciones y tareas</a>
									<a class="dropdown-item" href="#">Condiciones</a>
									<a class="dropdown-item" onclick="eliminar_meta_listar_dependencia(' . $id_meta . ')" >Eliminar Meta</a>
								</div>
							</div>
						</div>',
				"2" => $responsable_meta,
				"3" => $dataResponsables,
				"4" => count($acciones) . ' / ' . count($tareas),
				"5" => '<div style="width:180px" class="fecha-editable pointer" data-id="' . $id_meta . '" data-fecha="' . $fechainiciometa . '">' . $sacListarDependencia->fechaCompletaCorta($fechainiciometa) . '</div>',
				"6" => '<div style="width:180px" class="fecha-final-editable pointer" data-id="' . $id_meta . '" data-fecha="' . $vencimiento . '">' . $sacListarDependencia->fechaCompletaCorta($vencimiento) . '</div>',
				"7" => '<div style="width:280px">' . $datosejes["nombre_corto"] . '</div>',
				"8" => '',
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


	// abre los detalles de la meta 
	//listar los nombres de meta por usuario
	case 'detalle':

		$id_meta = $_POST['id_meta'];

		// $meta_responsable = $_POST["meta_responsable"];
		// $fecha_ano = $_POST["fecha_ano"];
		$data[0] = "";
		$contaacordeonp = 1;
		$contaacordeon = 1;
		$nombre_meta = $sacListarDependencia->listarMimeta($id_meta);
		$data[0] .= '
						<div  class="row m-0" id="ocultar_datos">';
		$contador = 1;
		$id_meta = $nombre_meta["id_meta"];
		$id_eje = $nombre_meta["id_eje"];
		$meta = mb_strtolower($nombre_meta["meta_nombre"], 'UTF-8');
		$primera_letra = mb_strtoupper(mb_substr($meta, 0, 1, 'UTF-8'), 'UTF-8');
		$resto_texto = mb_substr($meta, 1, null, 'UTF-8');
		$texto_formateado = $primera_letra . $resto_texto;
		$fecha_entrega = $nombre_meta["meta_fecha"];
		$plan_mejoramiento = $nombre_meta["plan_mejoramiento"];
		$contaacordeonp++;
		$buscarproyecto = $sacListarDependencia->traer_proyecto_eje($id_eje);
		$data[0] .= '
			<div class="col-12 p-2">
				<div class="row mx-0">
					<div class="col-12 py-2 borde-bottom">
						<div class="row">
							<div class="col-9">
								<i class="fa-solid fa-calendar-days"></i> <span class="text-gray"> ' . $sacListarDependencia->fechaesp($fecha_entrega) . '</span>
							</div>
						</div>
					</div>
					<div class="col-12 p-2 line-height-16 ">
						<div class="fs-14 font-weight-bolder pb-2">' . $contador . '. ' . $texto_formateado . '</div>
					</div>
					<div class="col-12">
						<div class="row">
							<div class="col-12 p-2 line-height-16">
								<div class="fs-14 font-weight-bolder pb-2">Proyecto</div>
								<div class="fs-12 ml-4">' . $buscarproyecto["nombre_proyecto"]  . '</div>
							</div>
							<div class="col-12 p-2 line-height-16">
								<div class="fs-14 font-weight-bolder pb-2">Opción de mejora</div>
								<div class="fs-12 ml-4">' . $plan_mejoramiento . '</div>
							</div>	
							<div class="col-6 p-2">';
		// Condiciones institucionales
		$condicionesinstitucionales = $sacListarDependencia->listarCondicionInstitucionalMeta($id_meta);
		$data[0] .= '<div><b>Condiciones Institucionales</b></div>';
		for ($ci = 0; $ci < count($condicionesinstitucionales); $ci++) {
			$nombre_condicion = $condicionesinstitucionales[$ci]["nombre_condicion"];
			$data[0] .= '<div class="fs-12 text-gray">' . $nombre_condicion . '</div>';
		}
		$data[0] .= '
		</div>
		<div class="col-6 p-2">';
		// Condiciones de programa
		$condicionesdeprograma = $sacListarDependencia->listarCondicionProgramaMeta($id_meta);
		$data[0] .= '<div><b>Condiciones de programa:</b></div>';
		for ($cp = 0; $cp < count($condicionesdeprograma); $cp++) {
			$nombre_programa = $condicionesdeprograma[$cp]["nombre_condicion"];
			$data[0] .= '<div class="small text-gray">' . $nombre_programa . '</div>';
		}
		$data[0] .= '
		</div>';
		// Acciones de la meta
		$listaracciones = $sacListarDependencia->listaracciones($id_meta);
		$todas_acciones_y_tareas_terminadas = true;
		$data[0] .= '
		<div class="accordion col-12" id="accordionExample' . $contador . '">';
		for ($c = 0; $c < count($listaracciones); $c++) {
			$accion = $listaracciones[$c];
			$id_accion = $accion["id_accion"];
			$total_tareas = $sacListarDependencia->contarTareasPorAccion($id_accion);
			$tareas_finalizadas = $sacListarDependencia->contarTareasFinalizadasPorAccion($id_accion);
			$porcentaje = $total_tareas > 0 ? round(($tareas_finalizadas / $total_tareas) * 100) : 0;

			$color_barra = '';
			if ($porcentaje < 50) {
				$color_barra = 'bg-danger';
			} elseif ($porcentaje < 100) {
				$color_barra = 'bg-warning';
			} else {
				$color_barra = 'bg-success';
			}
			$mostrar_tareas = $sacListarDependencia->mostrartareas($id_accion);
			$cantidad_tareas = count($mostrar_tareas);
			$todas_terminadas = true;


			for ($j = 0; $j < $cantidad_tareas; $j++) {
				if ($mostrar_tareas[$j]["estado_tarea"] == 0) {
					$todas_terminadas = false;
					break;
				}
			}
			if ($accion["accion_estado"] == 0 || !$todas_terminadas) {
				$todas_acciones_y_tareas_terminadas = false;
			}

			$contaacordeon++;
			$data[0] .= '
			<div class="card">
				<div class="card-header tono-2" id="headingOne' . $contaacordeon . '">
					
						<div class="row">
							<div class="col-10">
								<i class="fa-solid fa-calendar-days text-gray fs-12"></i> <span class="text-semibold fs-12 text-gray">' . $sacListarDependencia->fechaesp($accion["fecha_fin"]) . '</span>
							</div>
							<div class="col-2 ">';
			$data[0] .= '											
				</div>
				<div class="col-12">
					<span class="text-left collapsed pointer btn-block"  data-toggle="collapse" data-target="#collapseOne' . $contaacordeon . '" aria-expanded="false" aria-controls="collapseOne' . $contaacordeon . '">
						<i class="fa-solid fa-chevron-down text-primary"></i> <span class="fs-14 ">' . $accion["nombre_accion"] . '</span>
					</span>
				</div>
				
				<div class="col-7 pt-2">
					<div class="progress progress-sm">
						<div class="progress-bar ' . $color_barra . '" style="width: ' . $porcentaje . '%"></div>
					</div>
				</div>
				<div class="col-2 pt-1">
					<span class="text-semibold fs-12">' . $porcentaje . '% </span>
				</div>
				
			</div>				
			</div>

			<div id="collapseOne' . $contaacordeon . '" class="collapse" aria-labelledby="headingOne' . $contaacordeon . '" data-parent="#accordionExample' . $contador . '">
				<div class="card-body col-12">';

			for ($n = 0; $n < count($mostrar_tareas); $n++) {
				$id_tarea_sac = $mostrar_tareas[$n]["id_tarea_sac"];
				$nombre_tarea = $mostrar_tareas[$n]["nombre_tarea"];
				$fecha_entrega =    $mostrar_tareas[$n]["fecha_entrega_tarea"];
				$meta_responsable = $mostrar_tareas[$n]["responsable_tarea"];
				$link_evidencia_tarea = $mostrar_tareas[$n]["link_evidencia_tarea"];
				$datosusuario = $sacListarDependencia->DatosUsuario($meta_responsable);
				$nombre1 = $datosusuario["usuario_nombre"];
				$nombre2 = $datosusuario["usuario_nombre_2"];
				$apellido1 = $datosusuario["usuario_apellido"];
				$apellido2 = $datosusuario["usuario_apellido_2"];
				$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;

				$data[0] .= '
				<div class="row borde-bottom py-2">
			
					<div class="col-8">

						<div class="row">
							<div class="col-12 fs-14">' . ($n + 1) . ' ' . $nombre_tarea . ' </div>
						
							<div class="col-12 small text-gray">' . $sacListarDependencia->fechaesp($fecha_entrega) . '</div>
							<div class="col-12 fs-12">' . $nombre_completo . '</div>

						</div>
					</div>

					<div class="col-4">
						<div class="row">
							<div class="col-12">';
				if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
					// $data[0] .= '<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_tarea_accion(' . $mostrar_tareas[$n]["id_tarea_sac"] . ', ' . $id_accion . ')" title="Marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>';
				} else {
					$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
				}

				if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
					// $data[0] .= '
					// 	<button class="btn text-warning btn-xs" onclick="mostrar_tarea(' . $id_tarea_sac . ', ' . $id_accion . ')" title="Editar tarea"><i class="fas fa-pencil-alt"></i></button>
					// 	<button class="btn text-danger btn-xs" onclick="eliminar_tareas(' . $id_tarea_sac . ')" title="Eliminar tarea">
					// 		<i class="far fa-trash-alt"></i>
					// 	</button>';
				}

				$data[0] .= '
																										' . ($link_evidencia_tarea
					? '<a href="' . htmlspecialchars($link_evidencia_tarea) . '" target="_blank"><i class="fa-solid fa-link"></i></a>'
					: '') . '
																								</div>
																							</div>
																						</div>
																					</div>';
			}

			$data[0] .= '
																		
																</div>
															</div>
														</div>';

			if ($todas_acciones_y_tareas_terminadas && count($listaracciones) > 0) {
				$data[0] .= '
															<div class="row">
																<label>Estado Meta</label>
																<div class="btn-group btn-group-toggle col-12" data-toggle="buttons">
																	<label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'active' : '') . '">
																		<input style="height: 0.5px" type="radio" id="meta_lograda" name="meta_lograda" value="1" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'checked' : '') . '> SI
																	</label>
																	<label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'active' : '') . '">
																		<input style="height: 0.5px" name="meta_lograda" value="0" type="radio" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'checked' : '') . '> NO
																	</label>
																</div>
															</div>';
			}
		}
		$contador++;
		$data[0] .= ' 
												</div>';


		$data[0] .= '
											</div>
										</div>

										
									</div>
								</div>';

		$data[0] .= '
						</div>';


		$data[0] .= '	
					';



		$data[0] .= '
			';

		echo json_encode($data);
	break;

	case 'cambiofechainicio':
		$data = array();
		$id_meta = $_POST["id_meta"];
		$nuevafecha = $_POST["nuevaFecha"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->cambiofechainicio($nuevafecha, $id_meta);
		if ($rspta) {
			$data["status"] = "success";
			$data["message"] = "Fecha de inicio actualizada correctamente.";
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo actualizar la fecha de inicio.";
		}
		echo json_encode($data);
		break;

	case 'cambiofechafinal':
		$data = array();
		$id_meta = $_POST["id_meta"];
		$nuevafecha = $_POST["nuevaFecha"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->cambiofechafinal($nuevafecha, $id_meta);
		if ($rspta) {
			$data["status"] = "success";
			$data["message"] = "Fecha final actualizada correctamente.";
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo actualizar la fecha final.";
		}
		echo json_encode($data);
		break;

	case 'cambiofechaaccion':
		$data = array();
		$id_accion = $_POST["id_accion"];
		$nuevafecha = $_POST["nuevaFecha"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->cambiofechaaccion($nuevafecha, $id_accion);
		if ($rspta) {
			$data["status"] = "success";
			$data["message"] = "Fecha de acción actualizada correctamente.";
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo actualizar la fecha de acción.";
		}
		echo json_encode($data);
		break;

	case 'cambionombremeta':
		$data = array();
		$id_meta = $_POST["id_meta"];
		$nombre = $_POST["nombre"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->cambioNombreMeta($nombre, $id_meta);
		if ($rspta) {
			$data["status"] = "success";
			$data["message"] = "Fecha final actualizada correctamente.";
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo actualizar la fecha final.";
		}
		echo json_encode($data);
		break;

	case 'cambionombreaccion':
		$data = array();
		$id_accion = $_POST["id_accion"];
		$nombre = $_POST["nuevoNombre"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->cambioNombreAccion($nombre, $id_accion);
		if ($rspta) {
			$data["status"] = "success";
			$data["message"] = "Fecha final actualizada correctamente.";
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo actualizar la fecha final.";
		}
		echo json_encode($data);
		break;

	case 'nuevameta':

		if (empty($id_meta)) {
			$rspta = $sacListarDependencia->SacNuevaMeta($meta_nombre, $fecha_inicio, $meta_fecha, $anio_eje, $id_eje, $id_proyecto, $meta_responsable, $plan_mejoramiento, $fecha, $hora);
			echo $rspta ? "meta registrada" : "meta no se pudo registrar";
		} else {
			$rspta = $sacListarDependencia->saceditometa($id_meta, $plan_mejoramiento, $meta_nombre, $meta_fecha, $id_eje, $id_proyecto, $meta_responsable, $id_concondiciones_ins, $id_condiciones_pro, $anio_eje, $nombre_indicador, $porcentaje_avance_indicador, $nombre_proyectos);
			echo $rspta ? "meta actualizada" : "meta no se pudo actualizar";
		}
		break;

	//listar los nombres de meta por usuario
	case 'acciones':

		$id_meta = $_POST['id_meta'];
		$data[0] = "";
		$contaacordeonp = 1;
		$contaacordeon = 1;



		$nombre_meta = $sacListarDependencia->listarMimeta($id_meta);

		$contador = 1;
		$id_meta = $nombre_meta["id_meta"];

		$meta = mb_strtolower($nombre_meta["meta_nombre"], 'UTF-8');
		$primera_letra = mb_strtoupper(mb_substr($meta, 0, 1, 'UTF-8'), 'UTF-8');
		$resto_texto = mb_substr($meta, 1, null, 'UTF-8');
		$texto_formateado = $primera_letra . $resto_texto;




		$fecha_entrega = $nombre_meta["meta_fecha"];
		$responsable = $nombre_meta["meta_responsable"];
		$id_proyecto = $nombre_meta["id_proyecto"];
		$plan_mejoramiento = $nombre_meta["plan_mejoramiento"];
		$contaacordeonp++;
		$data[0] .= '
			<div class="col-12 p-2">
				<div class="row">
				
					<div class="col-12 p-2 line-height-16 ">
						<div class="fs-14 font-weight-bolder pb-2">Meta: ' . $contador . '. ' . $texto_formateado . '</div>
						
					</div>
					<div class="col-12 p-2 ">
						<a class="btn btn-primary btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
							<i class="fas fa-plus"></i> Nueva acción
						</a>
					</div>
					<div class="col-12 collapse" id="collapseExample">
						<form class="row" name="formularioaccionguardar" id="formularioaccionguardar" method="POST">
							<div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
								<div class="form-group mb-3 position-relative check-valid">
									<label>¿Nombre de la acción?</label>
									<div class="form-floating">
										<textarea rows="3" type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_accion" id="nombre_accion" required></textarea>
									</div>
								</div>
								<div class="invalid-feedback">Please enter valid input</div>
							</div>
							
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
								<div class="form-group mb-3 position-relative check-valid">
									<div class="form-floating">
										<input type="date" required class="form-control border-start-0" name="fecha_fin" id="fecha_fin" max="' . $fecha_entrega . '">
										<label for="fecha_fin">Fecha de entrega:</label>
										</input>
									</div>
								</div>
								<div class="invalid-feedback">Please enter valid input</div>
							</div>
								
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
								<div class="form-group mb-3 position-relative check-valid">
									<div class="form-floating">
										<input type="time" class="form-control border-start-0" name="hora_accion" id="hora_accion" required  >
										<label for="hora_accion">Hora de entrega</label>
									</div>
								</div>
								<div class="invalid-feedback">Por favor, ingrese una hora válida</div>
							</div>
							<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<input type="number" class="d-none" id="id_meta_accion" name="id_meta_accion" value="' . $id_meta . '">
								<button class="btn btn-primary btn-block" type="submit" id="btnGuardarAccion"><i class="fa fa-save"></i> Guardar acción</button>
							</div>
						</form>
					</div>';

		$listaracciones = $sacListarDependencia->listaracciones($id_meta);
		$todas_acciones_y_tareas_terminadas = true;
		$data[0] .= '

					<div class="accordion col-12" id="accordionExample' . $contador . '">';
		for ($c = 0; $c < count($listaracciones); $c++) {
			$accion = $listaracciones[$c];
			$id_accion = $accion["id_accion"];
			$fechaaccion = $accion["fecha_fin"];
			$nombre_accion = $accion["nombre_accion"];
			$total_tareas = $sacListarDependencia->contarTareasPorAccion($id_accion);
			$tareas_finalizadas = $sacListarDependencia->contarTareasFinalizadasPorAccion($id_accion);
			$porcentaje = $total_tareas > 0 ? round(($tareas_finalizadas / $total_tareas) * 100) : 0;

			$color_barra = '';
			if ($porcentaje < 50) {
				$color_barra = 'bg-danger';
			} elseif ($porcentaje < 100) {
				$color_barra = 'bg-warning';
			} else {
				$color_barra = 'bg-success';
			}
			$mostrar_tareas = $sacListarDependencia->mostrartareas($id_accion);
			$cantidad_tareas = count($mostrar_tareas);
			$todas_terminadas = true;


			for ($j = 0; $j < $cantidad_tareas; $j++) {
				if ($mostrar_tareas[$j]["estado_tarea"] == 0) {
					$todas_terminadas = false;
					break;
				}
			}
			if ($accion["accion_estado"] == 0 || !$todas_terminadas) {
				$todas_acciones_y_tareas_terminadas = false;
			}

			$contaacordeon++;
			$data[0] .= '

							<div class="card">
								<div class="card-header tono-2" id="headingOne' . $contaacordeon . '">
									
										<div class="row">
											<div class="col-10">
												<div style="100%" class="fecha-editable-accion text-gray pointer" data-id="' . $id_accion . '" data-fecha="' . $fechaaccion . '"> 
													<i class="fa-solid fa-calendar-days text-gray fs-12"></i>  ' . $sacListarDependencia->fechaCompletaCorta($fechaaccion) . '
												</div>
											</div>
											<div class="col-2 text-right">';

			if ($accion["accion_estado"] == 0) {

				if ($cantidad_tareas > 0 && $todas_terminadas) {
					$data[0] .= '<button class="btn  btn-xs text-primary" onclick="terminar_accion_dependencia(' . $id_accion . ')" title="Terminar acción"><i class="fas fa-check"></i></button>';
				}

				if ($cantidad_tareas == 0) {
					$data[0] .= '
														<button class="btn  btn-xs " onclick="eliminar_accion(' . $id_accion . ',' . $id_meta . ')" title="Eliminar acción">
															<i class="far fa-trash-alt text-danger"></i>
														</button>';
				}
			} else {
				$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
			}
			$data[0] .= '
										
											</div>
											<div class="col-auto pt-1">
												<span class="text-left collapsed pointer btn-block"  data-toggle="collapse" data-target="#collapseOne' . $contaacordeon . '" aria-expanded="false" aria-controls="collapseOne' . $contaacordeon . '">
													<i class="fa-solid fa-chevron-down text-primary"></i> 
												</span>
											</div>
											<div class="col-11">
												<span class="nombreaccion-editable pointer"  data-id="' . $id_accion . '" data-nombre="' . htmlspecialchars($nombre_accion) . '">' . htmlspecialchars($nombre_accion) . '</span>
											</div>
											
											<div class="col-7 pt-2">
												<div class="progress progress-sm">
													<div class="progress-bar ' . $color_barra . '" style="width: ' . $porcentaje . '%"></div>
												</div>
											</div>
											
											<div class="col-2 pt-1">
												<span class="text-semibold fs-12">' . $porcentaje . '% </span>
											</div>
											<div class="col-3 text-right">
												<div class="btn-group">
													<button class="btn bg-purple btn-xs d-none" onclick="CrearTarea(' . $id_accion . ', ' . $id_meta . ')"><i class="fas fa-plus-circle"></i> tarea</button>
													<button class="btn bg-purple btn-xs" onclick="CrearTareaPopover(event,' . $id_accion . ', ' . $id_meta . ')">
														<i class="fas fa-plus-circle"></i> tareas
													</button>
													
												</div>
											</div>


											

											
											
										</div>
									
								</div>

								<div id="collapseOne' . $contaacordeon . '" class="collapse" aria-labelledby="headingOne' . $contaacordeon . '" data-parent="#accordionExample' . $contador . '">
									<div class="card-body col-12">';

			for ($n = 0; $n < count($mostrar_tareas); $n++) {
				$filatarea = $contaacordeon . $n;
				$id_tarea_sac = $mostrar_tareas[$n]["id_tarea_sac"];
				$nombre_tarea = $mostrar_tareas[$n]["nombre_tarea"];
				$fecha_entrega =    $mostrar_tareas[$n]["fecha_entrega_tarea"];
				$meta_responsable = $mostrar_tareas[$n]["responsable_tarea"];
				$link_evidencia_tarea = $mostrar_tareas[$n]["link_evidencia_tarea"];
				$datosusuario = $sacListarDependencia->DatosUsuario($meta_responsable);
				$nombre1 = $datosusuario["usuario_nombre"];
				$nombre2 = $datosusuario["usuario_nombre_2"];
				$apellido1 = $datosusuario["usuario_apellido"];
				$apellido2 = $datosusuario["usuario_apellido_2"];
				$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;
				// <div class="col-12 fs-14">' . ($n + 1) . ' ' . $nombre_tarea . ' </div>


				$nombre_tarea_html = '
					<div class="col-12 fs-14">
						<span';

				if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
					$nombre_tarea_html .= ' class="nombre_editar_tarea" data-id="' . $id_tarea_sac . '" data-nombre="' . htmlspecialchars($nombre_tarea) . '"';
				}

				$nombre_tarea_html .= '>' . htmlspecialchars($nombre_tarea) . '</span>
					</div>';

				if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
					$responsable_meta = '
							<span class="editar-responsable-tarea small" data-id_tarea_sac="' . $id_tarea_sac . '" data-responsable_nombre="' . htmlspecialchars($nombre_completo) . '">' . htmlspecialchars($nombre_completo) . '</span>';
				} else {
					$responsable_meta = '
							<span>' . htmlspecialchars($nombre_completo) . '</span>';
				}



				if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
					$fecha_tarea = '

							<div style="100%" class="fecha-editable-tarea text-gray pointer" data-id="' . $id_tarea_sac . '" data-fecha="' . $fecha_entrega . '"> 
								<i class="fa-solid fa-calendar-days text-gray fs-12"></i>  ' . $sacListarDependencia->fechaesp($fecha_entrega) . '
							</div>
						';
				} else {
					$fecha_tarea = '
							<div class="col-12 small text-gray">' . $sacListarDependencia->fechaesp($fecha_entrega) . '</div>';
				}




				$data[0] .= '
														<div class="row borde-bottom py-2"  id="filatareas' . $filatarea . '">
															<div class="col-8">
																<div class="row">' .
					$nombre_tarea_html .
					'
																	<div class="col-12 small text-gray">' . $fecha_tarea . '</div>

																	<div class="col-12 fs-12">' . $responsable_meta . '</div>

																</div>
															</div>

															<div class="col-4">
																<div class="row">
																	<div class="col-12">';
				if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
					$data[0] .= '<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_tarea_accion(' . $mostrar_tareas[$n]["id_tarea_sac"] . ', ' . $id_accion . ')" title="Marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>';
				} else {
					$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
				}

				if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
					$data[0] .= '
																				<button class="btn text-danger btn-xs" onclick="eliminar_tareas(' . $id_tarea_sac . ', ' . $filatarea . ')" title="Eliminar tarea">
																					<i class="far fa-trash-alt"></i>
																				</button>';
				}

				$data[0] .= '
																			' . ($link_evidencia_tarea
					? '<a href="' . htmlspecialchars($link_evidencia_tarea) . '" target="_blank"><i class="fa-solid fa-link"></i></a>'
					: '') . '
																	</div>
																</div>
															</div>
														</div>';
			}

			$data[0] .= '
											
									</div>
								</div>
							</div>';

			if ($todas_acciones_y_tareas_terminadas && count($listaracciones) > 0) {
				$data[0] .= '
								<div class="row">
									<label>Estado Meta</label>
									<div class="btn-group btn-group-toggle col-12" data-toggle="buttons">
										<label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'active' : '') . '">
											<input style="height: 0.5px" type="radio" id="meta_lograda" name="meta_lograda" value="1" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'checked' : '') . '> SI
										</label>
										<label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'active' : '') . '">
											<input style="height: 0.5px" name="meta_lograda" value="0" type="radio" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'checked' : '') . '> NO
										</label>
									</div>
								</div>';
			}
		}
		$data[0] .= ' 
					</div>';


		$data[0] .= '
					
				</div>
			</div>';


		echo json_encode($data);
		break;

	case 'guardaraccion':

		$data = array();
		$fecha_accion = date("Y-m-d");
		if (empty($id_accion)) {
			$rspta = $sacListarDependencia->insertaraccion($nombre_accion, $id_meta_accion, $fecha_accion, $fecha_fin, $hora_accion);
			if ($rspta) {
				$data["status"] = "success";
				$data["id_meta"] = $id_meta_accion;
			}
		} else {
			$rspta = $sacListarDependencia->editaraccion($id_accion, $nombre_accion, $id_meta_accion, $fecha_accion, $fecha_fin);
			echo $rspta ? "Acción editada" : "Acción no se pudo editar";
		}
		echo json_encode($data);
		break;

	case 'eliminar_accion':
		$id_meta = $_POST['id_meta'];
		$id_accion = $_POST['id_accion'];
		$data = array();

		$rspta = $sacListarDependencia->eliminar_accion($id_accion);
		if ($rspta) {
			$data["status"] = "success";
			$data["id_meta"] = $id_meta;
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo eliminar la acción";
		}
		echo json_encode($data);
		break;


	case 'guardaryeditartarea':

		$data = array();
		$fecha_accion = date("Y-m-d");
		$rspta = $sacListarDependencia->insertartarea($nombre_tarea, $fecha_tarea, $responsable_tarea, $id_accion_tarea, $anio, $id_meta_tarea);
		if ($rspta) {
			$data["status"] = "success";
			$data["id_meta"] = $id_meta_tarea;
		}
		echo json_encode($data);
		break;




	// //listar los nombres de meta por usuario
	case 'nombre_accion_usuario':

		$nombre_accion_usuario = $sacListarDependencia->listarNombreAccion($meta_responsable);
		// echo $meta_responsable;
		$data[0] = "";
		for ($f = 0; $f < count($nombre_accion_usuario); $f++) {
			$nombre_accion = $nombre_accion_usuario[$f]["nombre_accion"];
			$nombre_meta = $nombre_accion_usuario[$f]["meta_nombre"];
			$nombre_meta_anterior = isset($nombre_accion_usuario[($f - 1)]["meta_nombre"]) ? $nombre_accion_usuario[($f - 1)]["meta_nombre"] : "";
			$nombre_accion_anterior = isset($nombre_accion_usuario[($f - 1)]["nombre_accion"]) ? $nombre_accion_usuario[($f - 1)]["nombre_accion"] : "";
			if ($nombre_meta_anterior != $nombre_meta) {
				$data[0] .= '<hr><strong> Meta:</strong><strong class="text-secondary"><br>' . $nombre_meta . '</strong>
				<br>';
				$data[0] .= '<br><label>Acciones: </label>';
			};
			if ($nombre_accion_anterior != $nombre_accion) {
				$data[0] .= '
				
				<strong class="text-secondary"><br> ' . ($f + 1) . '</span>: </b>' . $nombre_accion . '</strong>
				<br>';
			};
		}
		echo json_encode($data);
		break;
	case 'mostrar_accion_modal':
		$id_accion = $_POST["id_accion"];
		$rspta = $sacListarDependencia->mostrar_accion($id_accion);
		echo json_encode($rspta);
		break;



	case 'editarestadometa':
		$id_meta = $_POST["id_meta"];
		$estado_meta = $_POST["estado_meta"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->editarestadometa($estado_meta, $id_meta);
		break;


	// case 'listar_tabla_campana':
	// 	$periodo_sac = $_GET["periodo_sac"];
	// 	$rspta = $sacListarDependencia->listarusuariopoa();
	// 	for ($i = 0; $i < count($rspta); $i++) {
	// 		$rsptausuario = $sacListarDependencia->contarmeta($rspta[$i]["id_usuario"], $periodo_sac);
	// 		// saber el porcentaje de la barra
	// 		$metasCumplidas = $sacListarDependencia->porcentajeavance($rspta[$i]["id_usuario"], $periodo_sac);
	// 		$totalmetas = count($rsptausuario);
	// 		$totalmetascumplidas = count($metasCumplidas);
	// 		// $total_avance_metas = floor(($totalmetascumplidas / $totalmetas) * 100);
	// 		if ($totalmetas > 0) {
	// 			$total_avance_metas = floor(($totalmetascumplidas / $totalmetas) * 100);
	// 		} else {
	// 			// Manejar la situación en la que $totalmetas es cero.
	// 			// Podrías establecer $total_avance_metas a 0 o manejarlo de otra manera.
	// 			$total_avance_metas = 0; // o cualquier otro valor apropiado
	// 		}
	// 		$nombre = $rspta[$i]["usuario_nombre"] . ' ' . $rspta[$i]["usuario_nombre_2"] . ' ' . $rspta[$i]["usuario_apellido"] . ' ' . $rspta[$i]["usuario_apellido_2"];
	// 		$cedula = $rspta[$i]["usuario_identificacion"];
	// 		$cargo = $rspta[$i]["usuario_cargo"];
	// 		$clase_barra = '';
	// 		if ($total_avance_metas > 96) {
	// 			$clase_barra = 'bg-success';
	// 		} elseif ($total_avance_metas > 70) {
	// 			$clase_barra = 'bg-warning';
	// 		} else {
	// 			$clase_barra = 'bg-danger';
	// 		}
	// 		$data[] = array(
	// 			"0" => $nombre,
	// 			"1" => $cargo,
	// 			"2" => '<div class="col-12 text-center"> 	
	// 						<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="modopanel(`' . $rspta[$i]["id_usuario"] . '`,' . $periodo_sac . ')" title="Ver Meta">' . count($rsptausuario) . ' </a>
	// 					</div>
	// 					',
	// 			"3" => '
	// 					<div class="col-12 ">
	// 						<div class="row">
	// 							<div class="col-12">
	// 								<span class="text-semibold fs-12">' . $total_avance_metas . '% de Avance</span>
	// 							</div>
	// 							<div class="col-12">
	// 								<div class="progress progress-sm">
	// 									<div class="progress-bar ' . $clase_barra . '" style="width: ' . $total_avance_metas . '%"></div>
	// 								</div>
	// 							</div>
	// 						</div>
	// 					</div>

	// 					',
	// 		);
	// 	}
	// 	$results = array(
	// 		"sEcho" => 1, //Información para el datatables
	// 		"iTotalRecords" => count($data), //enviamos el total registros al datatable
	// 		"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
	// 		"aaData" => $data
	// 	);
	// 	echo json_encode($results);

	// 	break;
	case 'periodo':
		$data = array();
		$rsptaperiodo = $sacListarDependencia->periodoactual();
		$sac_periodo = $rsptaperiodo["sac_periodo"];
		$data["periodo"] = $sac_periodo;
		echo json_encode($data);
		break;

	case 'listar_marcadas_meta':

		$data = $sacListarDependencia->mostrar_meta($id_meta);
		$id_proyecto = $data["id_proyecto"];
		$data['id_proyecto'] = $id_proyecto;

		$proyecto_nombre = $sacListarDependencia->traer_proyecto($id_proyecto);
		$id_ejes = $proyecto_nombre["id_ejes"];
		$eje_nombre = $sacListarDependencia->traer_eje_nombre($id_ejes);

		$data['id_ejes'] = $eje_nombre["id_ejes"];


		$marcados = $sacListarDependencia->listarCondicionInstitucionalMarcada($id_meta);
		for ($i = 0; $i < count($marcados); $i++) {
			$data["condicion_institucional"][] = $marcados[$i]["id_con_ins"];
		}
		$marcados = $sacListarDependencia->listarCondicionProgramaMarcada($id_meta);
		for ($i = 0; $i < count($marcados); $i++) {
			$data["condicion_programa"][] = $marcados[$i]["id_con_pro"];
		}
		$marcados = $sacListarDependencia->listarCondicionDependencia($id_meta);
		for ($i = 0; $i < count($marcados); $i++) {
			$data["dependencias"][] = $marcados[$i]["id_con_dep"];
		}
		//Codificar el resultado utilizando json
		echo json_encode($data);
		break;
	case "selectListarCargo":
		$rspta = $sacListarDependencia->selectlistarCargo();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
		}
		break;
	// listamos los tipos de indicador 
	case "selectListarTiposIndicadores":
		$rspta = $sacListarDependencia->selectListarTiposIndicadores();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["tipo_id_indicador"] . "'>" . $rspta[$i]["nombre_indicador"] . "</option>";
		}
		break;
	case 'dependencias':
		$rspta = $sacListarDependencia->listardependencias();
		//Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
		for ($i = 0; $i < count($rspta); $i++) {
			echo '<input class="form-check-input" type="checkbox" name="dependencias[]" id="check_dep_' . $i . '" value="' . $rspta[$i]["id_dependencias"] . '" >
						<label class="form-check-label" for="check_dep_' . $i . '">' . $rspta[$i]["nombre"] . '</label> <br> ';
		}
		break;
	case 'condiciones_programa':
		$rspta = $sacListarDependencia->listarCondicionesPrograma();
		//Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
		for ($i = 0; $i < count($rspta); $i++) {
			echo '<input class="form-check-input " type="checkbox" name="condicion_programa[]" id="check_pro_' . $i . '" value="' . $rspta[$i]["id_condicion_programa"] . '" >
							<label class="form-check-label" for="check_pro_' . $i . '">' . $rspta[$i]["nombre_condicion"] . '</label> <br> 	';
		}
		break;
	case "selectListarTiposIndicadores":
		$rspta = $sacListarDependencia->selectListarTiposIndicadores();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["tipo_id_indicador"] . "'>" . $rspta[$i]["nombre_indicador"] . "</option>";
		}
		break;
	// case 'condiciones_institucionales':
	// 	$rspta = $sacListarDependencia->listarCondicionesInstitucionales();
	// 	//Mostramos la lista de condicones-insitucionales en la vista y si están o no marcados
	// 	for ($i = 0; $i < count($rspta); $i++) {
	// 		echo '<input class="form-check-input" type="checkbox" name="condicion_institucional[]" id="check_' . $i . '" value="' . $rspta[$i]["id_condicion_institucional"] . '" >
	// 						<label class="form-check-label " for="check_' . $i . '">' . $rspta[$i]["nombre_condicion"] . '</label> <br>	';
	// 	}
	// 	break;
	case 'condiciones_institucionales':
		$rspta = $sacListarDependencia->listarCondicionesInstitucionales();

		for ($i = 0; $i < count($rspta); $i++) {
			$id = $rspta[$i]["id_condicion_institucional"];
			$nombre = $rspta[$i]["nombre_condicion"];

			$checked = ($nombre === 'Ninguno') ? 'checked' : ''; // Marcar por defecto "Ninguno"

			echo '<input class="form-check-input condicion_institucional" type="checkbox" name="condicion_institucional[]" id="check_' . $id . '" value="' . $id . '" ' . $checked . '>
				<label class="form-check-label" for="check_' . $id . '">' . $nombre . '</label><br>';
		}
		break;



	case 'historico_tabla_indicadores':
		$id_meta_global = $_POST["id_meta_global"];
		$data[0] = "";
		$data[0] .= '<div class="container mt-3">';
		$data[0] .= '<h4>Historial de Indicadores</h4>';
		$listarhistoricoindicadores = $sacListarDependencia->listarhistoricoindicadores($id_meta_global);
		if (empty($listarhistoricoindicadores)) {
			$data[0] .= '<div class="alert alert-danger mt-3" role="alert">';
			$data[0] .= 'No se encontraron registros de indicadores para procesar.';
			$data[0] .= '</div>';
		}
		for ($c = 0; $c < count($listarhistoricoindicadores); $c++) {
			$id_meta = $listarhistoricoindicadores[$c]["id_meta"];
			$tipo_indicador = $listarhistoricoindicadores[$c]["tipo_indicador"];
			$fecha = $sacListarDependencia->fechaesp($listarhistoricoindicadores[$c]["fecha"]);
			$hora = $listarhistoricoindicadores[$c]["hora"];
			if ($tipo_indicador == 1) {
				$puntaje_anterior = $listarhistoricoindicadores[$c]["puntaje_anterior"];
				if ($puntaje_anterior != 0) {
					$puntaje_anterior = $listarhistoricoindicadores[$c]["puntaje_anterior"];
					$puntaje_actual = $listarhistoricoindicadores[$c]["puntaje_actual"];
					$resultado_incremento = (($puntaje_actual - $puntaje_anterior) / $puntaje_anterior) * 100;
					$data[0] .= '<div class="alert alert-primary mt-3" role="alert">';
					$data[0] .= '<strong>Indicador de Incrementos:</strong><br>';
					$data[0] .= 'Resultado: ' . $resultado_incremento . '%<br>';
					$data[0] .= 'Fecha: ' . $fecha . ' Hora: ' . $hora;
					$data[0] .= '</div>';
				} else {
					$data[0] .= '<div class="alert alert-warning mt-3" role="alert">';
					$data[0] .= 'El incremento no puede ser calculado debido a un puntaje anterior de 0.';
					$data[0] .= '</div>';
				}
			} elseif ($tipo_indicador == 2) {
				$poblacion = $listarhistoricoindicadores[$c]["poblacion"];
				if ($poblacion != 0) {
					$participa = $listarhistoricoindicadores[$c]["participa"];
					$poblacion = $listarhistoricoindicadores[$c]["poblacion"];
					$resultado_participa = ($participa / $poblacion) * 100;
					$data[0] .= '<div class="alert alert-info mt-3" role="alert">';
					$data[0] .= '<strong>Indicador de Participación:</strong><br>';
					$data[0] .= 'Resultado: ' . $resultado_participa . '%<br>';
					$data[0] .= 'Fecha: ' . $fecha . ' Hora: ' . $hora;
					$data[0] .= '</div>';
				} else {
					$data[0] .= '<div class="alert alert-warning mt-3" role="alert">';
					$data[0] .= 'La participación no puede ser calculada debido a una población de 0.';
					$data[0] .= '</div>';
				}
			} elseif (empty($id_meta)) {
				$data[0] .= '<div class="alert alert-warning mt-3" role="alert">';
				$data[0] .= 'No Tiene registros.';
				$data[0] .= '</div>';
			}
		}
		$data[0] .= '</div>';
		echo json_encode($data);
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
			//en editar el nombre_ejes es el id_eje
			// en editar para nombre_proyectos es el id_proyecto

			// $rspta = $sacListarDependencia->saccrearmeta($plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_proyecto, $id_concondiciones_ins, $id_condiciones_pro, $anio_eje, $nombre_indicador, $meta_lograda, $porcentaje_avance);
			$rspta = $sacListarDependencia->SacCrearMeta($meta_nombre, $plan_mejoramiento, $meta_fecha, $meta_responsable, $id_eje, $id_proyecto, $nombre_proyectos, $id_concondiciones_ins, $id_condiciones_pro, $anio_eje, $nombre_indicador, $porcentaje_avance_indicador);
			echo $rspta ? "meta registrada" : "meta no se pudo registrar";
		} else {
			$rspta = $sacListarDependencia->eliminar_con_ins($id_meta);
			$rspta = $sacListarDependencia->eliminar_con_pro($id_meta);
			$rspta = $sacListarDependencia->eliminar_con_dep($id_meta);;
			$rspta = $sacListarDependencia->saceditometa($id_meta, $plan_mejoramiento, $meta_nombre, $meta_fecha, $nombre_ejes, $id_proyecto, $meta_responsable, $id_concondiciones_ins, $id_condiciones_pro, $anio_eje, $nombre_indicador, $porcentaje_avance_indicador, $nombre_proyectos);
			// $rspta = $sacListarDependencia->saceditometa($id_meta,$plan_mejoramiento,$meta_nombre, $meta_fecha, $meta_responsable, $id_concondiciones_ins, $id_condiciones_pro, $id_dependencias, $anio_eje, $indicador_inserta, $puntaje_actual, $puntaje_anterior, $indicador_formula_o_sin_formula, $indicador_sin_formula, $participa, $poblacion, $select_tipo_indicador, $meta_lograda);
			// $rspta = $sacListarDependencia->insertareditarregistroindicadores($puntaje_actual, $puntaje_anterior, $indicador_formula_o_sin_formula, $indicador_sin_formula, $participa, $poblacion, $select_tipo_indicador, $id_meta, $fecha, $hora);
			echo $rspta ? "meta actualizada" : "meta no se pudo actualizar";
		}
		break;

	case 'eliminar_meta_listar_dependencia':
		$rspta = $sacListarDependencia->eliminar_meta_listar_dependencia($id_meta);
		echo json_encode($rspta);
		break;

	case "selectListarEjes":
		$rspta = $sacListarDependencia->selectlistarEjes();
		// echo "<option selected>Nothing selected</option>";
		echo "<option value='' selected disabled>Seleccione un Eje</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_ejes"] . "'>" . $rspta[$i]["nombre_ejes"] . "</option>";
		}
		break;

	case "selectListarProyectos":
		$id_ejes = isset($_POST["id_ejes"]) ? $_POST["id_ejes"] : "";
		$rspta = $sacListarDependencia->selectlistarProyectos($id_ejes);
		echo "<option value='' selected disabled>Seleccione un proyecto</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_proyecto"] . "'>" . $rspta[$i]["nombre_proyecto"] . "</option>";
		}
		break;


	// case "selectListarResponsables":
	// $rspta = $sacListarDependencia->selectlistarResponsable();
	// // echo "<option selected>Nothing selected</option>";
	// echo "<option value='' selected disabled>Seleccione Responsable</option>";
	// for ($i = 0; $i < count($rspta); $i++) {
	// 	echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_cargo"] . " - " . $rspta[$i]["usuario_nombre"] . "  " . $rspta[$i]["usuario_apellido"] . "</option>";
	// }
	// break;


	case "selectListarResponsables":
		$rspta = $sacListarDependencia->selectlistarResponsable();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_nombre"] . "  " . $rspta[$i]["usuario_apellido"] . "</option>";
		}
		break;


	// case 'visualizar_tareas':

	// 	$id_accion = $_POST["id_accion"];
	// 	$data = array();
	// 	$data[0] = "";
	// 	$data[0] .=
	// 		'		
	// 			<table id="mostrartareas" class="table" style="width:100%">
	// 			<thead>
	// 			<tr>
	// 			<th scope="col">#</th>
	// 			<th scope="col">Nombre Tarea</th>
	// 			<th scope="col">Fecha entrega</th>
	// 			<th scope="col">Responsable</th>
	// 			<th scope="col">Link tarea</th>
	// 			<th scope="col">Marcar tarea</th>
	// 			</tr>
	// 			</thead><tbody>';
	// 	$mostrar_tareas = $sacListarDependencia->mostrartareas($id_accion);
	// 	for ($n = 0; $n < count($mostrar_tareas); $n++) {
	// 		$nombre_tarea = $mostrar_tareas[$n]["nombre_tarea"];
	// 		$fecha_entrega = $mostrar_tareas[$n]["fecha_entrega"];
	// 		$meta_responsable = $mostrar_tareas[$n]["meta_responsable"];
	// 		$link_evidencia_tarea = $mostrar_tareas[$n]["link_evidencia_tarea"];
	// 		$data[0] .= '
	// 			<tr>
	// 				<th scope="row">' . ($n + 1) . '</th>
	// 				<td>' . $nombre_tarea . '</td>
	// 				<td>' . $fecha_entrega . '</td>
	// 				<td>' . $meta_responsable . '</td>
	// 				<td>' . $meta_responsable . '</td>
	// 				<td>';
	// 		if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
	// 			$data[0] .= '<button class="tooltip-agregar btn btn-primary btn-xs" onclick="terminar_tarea_accion(' . $mostrar_tareas[$n]["id_tarea_sac"] . ', ' . $id_accion . ')" title="Marcar como terminada" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>';
	// 		} else {
	// 			$data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
	// 		}
	// 		$data[0] .= '</td>
	// 			</tr>';
	// 	}
	// 	$data[0] .= '</tbody></table>';
	// 	echo json_encode($data[0]);
	// 	break;




	case 'terminar_accion':
		$rspta = $sacListarDependencia->terminar_accion($id_accion);
		echo json_encode($rspta);
		break;

	case 'terminar_tarea_accion':
		$id_tarea_sac = $_POST["id_tarea_sac"];
		$rspta = $sacListarDependencia->terminar_tarea($id_tarea_sac);
		echo json_encode($rspta);
		break;

	case 'mostrar_tarea':
		// $id_accion = $_POST["id_accion"];
		$rspta = $sacListarDependencia->mostrar_tarea($id_tarea_sac);
		echo json_encode($rspta);
		break;

	case 'eliminar_tareas':
		// $id_tarea_sac = $_POST["id_tarea_sac"];
		$rspta = $sacListarDependencia->eliminar_tarea($id_tarea_sac);
		echo json_encode($rspta);
		break;

	case "selectListarResponsableTrea":
		$rspta = $sacListarDependencia->selectlistarResponsableTarea();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_cargo"] . " - " . $rspta[$i]["usuario_nombre"] . "  " . $rspta[$i]["usuario_apellido"] . "</option>";
		}
		break;


	case 'cambionombreresponsable':
		$data = array();
		$id_meta = $_POST["id_meta"];
		$id_usuario = $_POST["id_usuario"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->cambioNombreResponsable($id_usuario, $id_meta);


		if ($rspta) {
			$data["status"] = "success";
			$data["message"] = "Responsable actualizado correctamente.";
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo actualizar el Responsable.";
		}
		echo json_encode($data);
		break;


	case 'cambionombreresponsableTarea':
		$data = array();
		$id_tarea_sac = $_POST["id_tarea_sac"];
		$id_usuario = $_POST["id_usuario"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->cambioNombreResponsableTarea($id_usuario, $id_tarea_sac);
		if ($rspta) {
			$data["status"] = "success";
			$data["message"] = "Responsable actualizado correctamente.";
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo actualizar el Responsable.";
		}
		echo json_encode($data);
		break;

	case 'cambionombretarea':
		$data = array();
		$id_tarea_sac = $_POST["id_tarea_sac"];
		$nombre = $_POST["nuevoNombre"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->cambioNombreTarea($nombre, $id_tarea_sac);
		if ($rspta) {
			$data["status"] = "success";
			$data["message"] = "Tarea actualizada correctamente.";
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo actualizar la Tarea.";
		}
		echo json_encode($data);
		break;


	case 'cambiofechatarea':
		$data = array();
		$id_tarea_sac = $_POST["id_tarea_sac"];
		$nuevafecha = $_POST["nuevaFecha"]; // Asegúrate de obtener el valor enviado desde el cliente.
		$rspta = $sacListarDependencia->cambiofechatarea($nuevafecha, $id_tarea_sac);
		if ($rspta) {
			$data["status"] = "success";
			$data["message"] = "Fecha de acción actualizada correctamente.";
		} else {
			$data["status"] = "error";
			$data["message"] = "No se pudo actualizar la fecha de acción.";
		}
		echo json_encode($data);
		break;
}
