<?php
session_start();
require_once "../modelos/SacTareas.php";
$sactareas = new SacTareas();
// enviar correo cuando se finalice la tarea
require_once "../public/mail/send_finaliza_tarea_sac.php"; // incluye el codigo para enviar link de clave
require_once "../mail/set_template_sac_finalizo_tarea.php"; // incluye el codigo para enviar link de clave
date_default_timezone_set("America/Bogota");

$rsptaperiodo = $sactareas->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
$sac_periodo = $rsptaperiodo["sac_periodo"];
switch ($_GET["op"]) {

    case 'listar_tareas_pendientes':
        $responsable_tarea = $_SESSION["id_usuario"];
        $periodo_tarea = isset($_GET["periodo_tarea"]) ? $_GET["periodo_tarea"] : $sac_periodo;
        $tareas = $sactareas->listar_tareas_pendientes($responsable_tarea, $periodo_tarea);
        foreach ($tareas as &$tarea) {
            $tarea['fecha_entrega_tarea'] = !empty($tarea['fecha_entrega_tarea']) ? $sactareas->fechaesp($tarea['fecha_entrega_tarea']) : '';
            $datosusuario = $sactareas->DatosUsuario($tarea['responsable_tarea']);
            $tarea['nombre_completo'] = $nombre1 . ' ' . $apellido1 . ' ' . $apellido2;
        }
        echo json_encode($tareas);
        break;

    case 'listar_tareas_finalizadas':
        $responsable_tarea = $_SESSION["id_usuario"];
        $periodo_tarea = isset($_GET["periodo_tarea"]) ? $_GET["periodo_tarea"] : $sac_periodo;
        $tareas = $sactareas->listar_tareas_finalizadas($responsable_tarea, $periodo_tarea);
        foreach ($tareas as &$tarea) {
            $tarea['fecha_entrega_tarea'] = !empty($tarea['fecha_entrega_tarea']) ? $sactareas->fechaesp($tarea['fecha_entrega_tarea']) : '';
            $datosusuario = $sactareas->DatosUsuario($tarea['responsable_tarea']);
            $tarea['nombre_completo'] = $nombre1 . ' ' . $apellido1 . ' ' . $apellido2;
        }
        echo json_encode($tareas);
        break;

    case 'detalle':

        $periodos = $sactareas->periodoactual();
        $periodo = $periodos["periodo_actual"];
        $anio = explode("-", $periodo)[0];
        $meta_responsable = $_SESSION["id_usuario"];
        $id_meta = $_POST['id_meta'];

        // $meta_responsable = $_POST["meta_responsable"];
        // $fecha_ano = $_POST["fecha_ano"];
        $data[0] = "";
        $contaacordeonp = 1;
        $contaacordeon = 1;

        // print_r($nombre_meta);
        $data[0] .= '
						<div  class="row m-0" id="ocultar_datos">';
        $f = 0;

        $contador = ++$f;
        $nombre_meta = $sactareas->listarMimeta($id_meta);

        // $id_meta = $nombre_meta["id_meta"];
        $meta = mb_strtolower($nombre_meta["meta_nombre"], 'UTF-8');
        $primera_letra = mb_strtoupper(mb_substr($meta, 0, 1, 'UTF-8'), 'UTF-8');
        $resto_texto = mb_substr($meta, 1, null, 'UTF-8');
        $texto_formateado = $primera_letra . $resto_texto;
        $fecha_entrega = $nombre_meta["meta_fecha"];
        // $responsable = $nombre_meta["usuario_cargo"];
        $nombre_proyecto = "sadas";
        $plan_mejoramiento = $nombre_meta["plan_mejoramiento"];
        $contaacordeonp++;
        $data[0] .= '
			<div class="col-12 p-2">
				<div class="row mx-0">
					<div class="col-12 py-2 borde-bottom">
						<div class="row">
							<div class="col-9">
								<i class="fa-solid fa-calendar-days"></i> <span class="text-gray"> ' . $sactareas->fechaesp($fecha_entrega) . '</span>
							</div>
						</div>
					</div>
					<div class="col-12 p-2 line-height-16 ">
						<div class="fs-14 font-weight-bolder pb-2">' . $contador . '. ' . $texto_formateado . '</div>
					</div>
					<div class="col-12">
						<div class="row">
							<div class="fs-12 ml-2">' . $nombre_proyecto . '</div>
							<div class="col-12 p-2 line-height-16">
								<div class="fs-14 font-weight-bolder pb-2">Opción de mejora</div>
								<div class="fs-12 ml-4">' . $plan_mejoramiento . '</div>
							</div>	
							<div class="col-6 p-2">';
        // Condiciones institucionales
        $condicionesinstitucionales = $sactareas->listarCondicionInstitucionalMeta($id_meta);
        $data[0] .= '<div><b>Condiciones Institucionales</b></div>';
        for ($ci = 0; $ci < count($condicionesinstitucionales); $ci++) {
            $nombre_condicion = $condicionesinstitucionales[$ci]["nombre_condicion"];
            $data[0] .= '<div class="fs-12 text-gray">' . $nombre_condicion . '</div>';
        }
        $data[0] .= '
		</div>
		<div class="col-6 p-2">';
        // Condiciones de programa
        $condicionesdeprograma = $sactareas->listarCondicionProgramaMeta($id_meta);
        $data[0] .= '<div><b>Condiciones de programa:</b></div>';
        for ($cp = 0; $cp < count($condicionesdeprograma); $cp++) {
            $nombre_programa = $condicionesdeprograma[$cp]["nombre_condicion"];
            $data[0] .= '<div class="small text-gray">' . $nombre_programa . '</div>';
        }
        $data[0] .= '
		</div>';
        // Acciones de la meta
        $listaracciones = $sactareas->listaraccionesDetalle($meta_responsable, $id_meta);
        $todas_acciones_y_tareas_terminadas = true;
        $data[0] .= '
		<div class="accordion col-12" id="accordionExample' . $contador . '">';
        for ($c = 0; $c < count($listaracciones); $c++) {
            $accion = $listaracciones[$c];
            $id_accion = $accion["id_accion"];
            $total_tareas = $sactareas->contarTareasPorAccion($id_accion);
            $tareas_finalizadas = $sactareas->contarTareasFinalizadasPorAccion($id_accion);
            $porcentaje = $total_tareas > 0 ? round(($tareas_finalizadas / $total_tareas) * 100) : 0;

            $color_barra = '';
            if ($porcentaje < 50) {
                $color_barra = 'bg-danger';
            } elseif ($porcentaje < 100) {
                $color_barra = 'bg-warning';
            } else {
                $color_barra = 'bg-success';
            }
         
            $mostrar_tareas = $sactareas->mostrartareas($id_accion,$meta_responsable);
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
								<i class="fa-solid fa-calendar-days text-gray fs-12"></i> <span class="text-semibold fs-12 text-gray">' . $sactareas->fechaesp($accion["fecha_fin"]) . '</span>
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
                $datosusuario = $sactareas->DatosUsuario($meta_responsable);
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
						
							<div class="col-12 small text-gray">' . $sactareas->fechaesp($fecha_entrega) . '</div>
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
                    ';

                $data[0] .= ' 



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
								</div>';

        $data[0] .= '
						</div>';


        $data[0] .= '	
					';



        $data[0] .= '
			';

        echo json_encode($data);
        break;



    // se valida la tarea 
    case 'validacion_tarea':
        $id_tarea_sac = $_POST["id_tarea_sac"];
        $rspta = $sactareas->terminar_tarea($id_tarea_sac);
        echo json_encode($rspta);
        break;
    // guardamos el link dependiendo del id_tarea_sac
    case 'guardarlinktarea':
        $id_tarea_sac = $_POST["id_tarea_sac"];
        $link_evidencia_tarea = $_POST["link_evidencia_tarea"];
        $rspta = $sactareas->guardarlinktarea($id_tarea_sac, $link_evidencia_tarea);
        echo $rspta ? "Link guardado correctamente" : "No se pudo guardar el link";
        break;


    case 'terminar_tarea_accion':
        $id_tarea_sac = $_POST["id_tarea_sac"];
        $rspta = $sactareas->terminar_tarea($id_tarea_sac);
        echo json_encode($rspta);
        break;


    // enviamos el correo cuando se finalice la tarea, y mostramos la informacion necesaria en el correo
    case "enviarcorrenotificaciontareafinalizada":
        $id_tarea_sac = $_POST["id_tarea_sac"];
        $tarea_finalizada = $sactareas->traerDetallesTarea($id_tarea_sac);
        $nombre_tarea = $tarea_finalizada["nombre_tarea"];
        $link_evidencia_tarea = $tarea_finalizada["link_evidencia_tarea"];
        $responsable_tarea = $tarea_finalizada["responsable_tarea"];
        //nombre de usuario responsable
        $nombre_responsable = $sactareas->traerResponsableTarea($responsable_tarea);
        $nombre_completo = $nombre_responsable["usuario_nombre"] . " " . $nombre_responsable["usuario_nombre_2"] . " " . $nombre_responsable["usuario_apellido"] . " " . $nombre_responsable["usuario_apellido_2"];
        // generamos el template
        $template = set_template_sac_finalizo_tarea($nombre_tarea, $nombre_completo, $link_evidencia_tarea);;
        // correo
        $destino = "jaime.perez@ciaf.edu.co";
        $asunto = " se ha enviado la tarea '" . $nombre_tarea . "'";
        $data = array();
        if (enviar_correo($destino, $asunto, $template)) {
            $data = array(
                'exito' => '1',
                'info' => 'Enviado Correctamente.'
            );
        } else {
            $data = array(
                'exito' => '0',
                'info' => 'Error consulta fallo'
            );
        }
        echo json_encode($data);
        break;



    case 'modopanel':
        // listamos el periodo actual
        $periodos = $sactareas->periodoactual();
        $periodo = $periodos["periodo_actual"];
        $anio = explode("-", $periodo)[0];
        // tomamos el id de la session
        $meta_responsable = $_SESSION["id_usuario"];
        // Traer todos los ejes
        $misejes = $sactareas->listarEjes();
        $data[0] = "";
        $contaacordeonp = 1;
        $contaacordeon = 1;
        // $misejes = $sactareas->selectlistarEjes();
        $data[0] .= '
			<div class="row mx-0 ">';
        for ($e = 0; $e < count($misejes); $e++) {
            $id_ejes = $misejes[$e]["id_ejes"];
            $nombre_ejes = $misejes[$e]["nombre_ejes"];
            $descripcion_eje = $misejes[$e]['descripcion_ejes'] ?? '';
            $data[0] .= '
					<div class="col-xl-3">
						<div class="col-12 text-semibold fs-12 text-center">' . $misejes[$e]["nombre_corto"] . '</div>';
            $nombre_meta = $sactareas->listarTareasPorEjeUsuario($id_ejes, $meta_responsable, $anio);
            $data[0] .= '
						<div  class="row m-0" id="ocultar_datos">';
            for ($f = 0; $f < count($nombre_meta); $f++) {

                $contador = $f + 1;
                $id_meta = $nombre_meta[$f]["id_meta"];
                $meta = mb_strtolower($nombre_meta[$f]["meta_nombre"], 'UTF-8');
                $primera_letra = mb_strtoupper(mb_substr($meta, 0, 1, 'UTF-8'), 'UTF-8');
                $resto_texto = mb_substr($meta, 1, null, 'UTF-8');
                $texto_formateado = $primera_letra . $resto_texto;
                $listarresponsables = $sactareas->listarresponsables($id_meta);
                $fecha_entrega = $nombre_meta[$f]["meta_fecha"];
                $responsable = isset($nombre_meta[$f]["usuario_cargo"]) ? $nombre_meta[$f]["usuario_cargo"] : '';
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
                                            <i class="fa-solid fa-calendar-days text-gray"></i> <span class="text-gray"> ' . $sactareas->fechaCompletaCorta($fecha_entrega) . '</span>
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="col-12 p-2 line-height-16 ">
                                    <div class="fs-14 font-weight-bolder pb-2"><a onclick="detalle(' . $id_meta . ')" class="pointer">' . $contador . '. ' . $texto_formateado . '</a></div>
                                </div> ';
                // muestra todos los usuarios 
                // foreach ($listarresponsables as $id_responsable) {
                //     $datosresponsable = $sactareas->DatosUsuario($id_responsable);
                //     $nombre_responsable = $datosresponsable["usuario_nombre"] . ' ' . $datosresponsable["usuario_apellido"];
                //     $colorusuario = $datosresponsable["usuario_color"];
                //     $primernombre = mb_strtoupper(mb_substr($datosresponsable["usuario_nombre"], 0, 1, 'UTF-8'), 'UTF-8');
                //     $primerapellido = mb_strtoupper(mb_substr($datosresponsable["usuario_apellido"], 0, 1, 'UTF-8'), 'UTF-8');
                //     $iniciales = $primernombre . $primerapellido;
                //     $data[0] .= '<span class="pt-2 rounded-circle text-center  text-semibold text-white fs-12" title="' . $nombre_responsable . '" style="background-color:' . $colorusuario . ';width:36px;height:36px">' . $iniciales . '</span>';
                // }

                // tomamos el usuario que tiene la sesion activa para que unicamente salga ese usuario
                $datosresponsable = $sactareas->DatosUsuario($meta_responsable);
                $nombre_responsable = $datosresponsable["usuario_nombre"] . ' ' . $datosresponsable["usuario_apellido"];
                $colorusuario = $datosresponsable["usuario_color"];
                $primernombre = mb_strtoupper(mb_substr($datosresponsable["usuario_nombre"], 0, 1, 'UTF-8'), 'UTF-8');
                $primerapellido = mb_strtoupper(mb_substr($datosresponsable["usuario_apellido"], 0, 1, 'UTF-8'), 'UTF-8');
                $iniciales = $primernombre . $primerapellido;
                $data[0] .= '<span class="pt-2 rounded-circle text-center text-semibold text-white fs-12" title="' . $nombre_responsable . '" style="background-color:' . $colorusuario . ';width:36px;height:36px">' . $iniciales . '</span>';
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
                                <div class="row">';
                $data[0] .= '
                        <div class="fs-12 ml-2">' . $nombre_proyecto . '</div>

                        <div class="col-12 p-2 line-height-16">
                            
                            <div class="fs-14 font-weight-bolder pb-2">Opción de mejora</div>
                            <div class="fs-12 ml-4">' . $plan_mejoramiento . '</div>
                        </div>
                <div class="col-6 p-2">';
                // Condiciones institucionales
                $condicionesinstitucionales = $sactareas->listarCondicionInstitucionalMeta($id_meta);
                $data[0] .= '<div><b>Condiciones Institucionales</b></div>';
                for ($ci = 0; $ci < count($condicionesinstitucionales); $ci++) {
                    $nombre_condicion = $condicionesinstitucionales[$ci]["nombre_condicion"];
                    $data[0] .= '<div class="fs-12 text-gray">' . $nombre_condicion . '</div>';
                }
                $data[0] .= '
                    </div>
                    <div class="col-6 p-2">';

                // Condiciones de programa
                $condicionesdeprograma = $sactareas->listarCondicionProgramaMeta($id_meta);
                $data[0] .= '<div><b>Condiciones de programa:</b></div>';
                for ($cp = 0; $cp < count($condicionesdeprograma); $cp++) {
                    $nombre_programa = $condicionesdeprograma[$cp]["nombre_condicion"];
                    $data[0] .= '<div class="small text-gray">' . $nombre_programa . '</div>';
                }
                $data[0] .= '
                </div>';
                // Acciones de la meta
                $data[0] .= '
                    <div class="col-12 py-2">
                        <span class="fs-18"><b>Acciones</b></span>
                    </div>';

                $listaracciones = $sactareas->listaraccionesPanel($meta_responsable, $id_meta);
                // print_r($listaracciones);
                $todas_acciones_y_tareas_terminadas = true;
                $data[0] .= '
                <div class="accordion col-12" id="accordionExample' . $contador . '">';
                for ($c = 0; $c < count($listaracciones); $c++) {
                    // variables para la creacion de las acciones
                    $id_accion = $listaracciones[$c]['id_accion'];
                    $accion_estado = $listaracciones[$c]['accion_estado'];
                    $fecha_fin = $listaracciones[$c]['fecha_fin'];
                    $nombre_accion = $listaracciones[$c]['nombre_accion'];
                    // $listaraccionesmias = $sactareas->listaraccionesmias($id_accion);
                    // $accion = $listaraccionesmias;
                    $total_tareas = $sactareas->contarTareasPorAccion($id_accion);
                    $tareas_finalizadas = $sactareas->contarTareasFinalizadasPorAccion($id_accion);
                    $porcentaje = $total_tareas > 0 ? round(($tareas_finalizadas / $total_tareas) * 100) : 0;
                    $color_barra = '';
                    if ($porcentaje < 50) {
                        $color_barra = 'bg-danger';
                    } elseif ($porcentaje < 100) {
                        $color_barra = 'bg-warning';
                    } else {
                        $color_barra = 'bg-success';
                    }
                    $mostrar_tareas = $sactareas->mostrartareasPanel($id_accion, $meta_responsable);
                    // print_r($mostrar_tareas);

                    $cantidad_tareas = count($mostrar_tareas);
                    $todas_terminadas = true;
                    for ($j = 0; $j < $cantidad_tareas; $j++) {
                        if ($mostrar_tareas[$j]["estado_tarea"] == 0) {
                            $todas_terminadas = false;
                            break;
                        }
                    }
                    if ($accion_estado == 0 || !$todas_terminadas) {
                        $todas_acciones_y_tareas_terminadas = false;
                    }
                    $contaacordeon++;
                    $data[0] .= '
                    <div class="card">
                        <div class="card-header tono-2" id="headingOne' . $contaacordeon . '">
                            <div class="row">
                                <div class="col-10">
                                    <i class="fa-solid fa-calendar-days text-gray fs-12"></i> <span class="text-semibold fs-12 text-gray">' . (!empty($fecha_fin) ? $sactareas->fechaesp($fecha_fin) : 'Sin fecha') . '</span>
                                </div>
                                <div class="col-2 ">';
                    $data[0] .= '													
                        </div>
                        <div class="col-12">
                            <span class="text-left collapsed pointer btn-block"  data-toggle="collapse" data-target="#collapseOne' . $contaacordeon . '" aria-expanded="false" aria-controls="collapseOne' . $contaacordeon . '">
                                <span class="fs-14 ">' . $nombre_accion . '</span>
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
                    $data[0] .= '
                    <div class="col-12 py-2">
                        <span class="fs-18"><b>Tareas</b></span>
                    </div>';
                    for ($n = 0; $n < count($mostrar_tareas); $n++) {
                        $id_tarea_sac = $mostrar_tareas[$n]["id_tarea_sac"];
                        $nombre_tarea = $mostrar_tareas[$n]["nombre_tarea"];
                        $fecha_entrega =    $mostrar_tareas[$n]["fecha_entrega_tarea"];
                        $meta_responsable = $mostrar_tareas[$n]["responsable_tarea"];
                        $link_evidencia_tarea = $mostrar_tareas[$n]["link_evidencia_tarea"];
                        $datosusuario = $sactareas->DatosUsuario($meta_responsable);
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
                                        <div class="col-12 small text-gray">' . (!empty($fecha_entrega) ? $sactareas->fechaesp($fecha_entrega) : 'Sin fecha') . '</div>
                                        <div class="col-12 fs-12">' . $nombre_completo . '</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-12" >';
                        if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
                            if ($link_evidencia_tarea) {
                                $data[0] .= '<button class="btn btn-primary btn-xs" onclick="terminar_tarea_accion(' . $id_tarea_sac . ', ' . $id_accion . ')" title="Marcar como terminada"> <i class="fas fa-check"></i> </button>';
                            } else {
                                $data[0] .= '<span class="fs-14">Para poder validar debes subir el link de la tarea.</span>';
                            }
                        } else {
                            $data[0] .= '<span class="bg-success text-white px-2 py-1 rounded"> <i class="fas fa-check-double"></i> </span>';
                        }
                        if ($link_evidencia_tarea) {
                            $data[0] .= '<a href="' . htmlspecialchars($link_evidencia_tarea) . '" target="_blank" class="btn btn-outline-info btn-xs" title="Ver evidencia"> <i class="fas fa-external-link-alt"></i> Ver </a>';
                        } else {
                            $data[0] .= '<button class="btn btn-outline-primary btn-xs" onclick="abrirModalLinkTarea(' . $id_tarea_sac . ')" title="Agregar evidencia"> <i class="fa-solid fa-link"></i> Evidencia </button>';
                        }
                        $data[0] .= '
                                </div>
                            </div>
                        </div>
                    </div>';
                    }
                    $data[0] .= '													
                            </div>
                        </div>
                    </div>';
                    // if ($todas_acciones_y_tareas_terminadas && count($listaracciones) > 0) {
                    //     $data[0] .= '
                    //     <div class="row">
                    //         <label>Estado Meta</label>
                    //         <div class="btn-group btn-group-toggle col-12" data-toggle="buttons">
                    //             <label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'active' : '') . '">
                    //                 <input style="height: 0.5px" type="radio" id="meta_lograda" name="meta_lograda" value="1" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'checked' : '') . '> SI
                    //             </label>
                    //             <label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'active' : '') . '">
                    //                 <input style="height: 0.5px" name="meta_lograda" value="0" type="radio" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'checked' : '') . '> NO
                    //             </label>
                    //         </div>
                    //     </div>';
                    // }
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

        $periodos = $sactareas->periodoactual();
        $periodo = $periodos["periodo_actual"];
        $anio = explode("-", $periodo)[0];
        // tomamos el id de la session
        $meta_responsable = $_SESSION["id_usuario"];
        $metas = $sactareas->listarTareasPorUsuarioCuadricula($meta_responsable, $periodo);
        //Vamos a declarar un array
        $data = array();
        for ($i = 0; $i < count($metas); $i++) {
            $id_meta = $metas[$i]["id_meta"];
            $fechainiciometa = $metas[$i]["fecha_inicio"];
            $meta = mb_strtolower($metas[$i]["meta_nombre"], 'UTF-8');
            $primera_letra = mb_strtoupper(mb_substr($meta, 0, 1, 'UTF-8'), 'UTF-8');
            $resto_texto = mb_substr($meta, 1, null, 'UTF-8');
            $nombremeta = $primera_letra . $resto_texto;
            $acciones = $sactareas->listaraccionesCuadriculaTotal($id_meta,$meta_responsable);
            $tareas = $sactareas->listarTareasCuadricula($id_meta,$meta_responsable);
            $vencimiento = $metas[$i]["meta_fecha"];
            $responsable = $metas[$i]["meta_responsable"];
            $datosresponsable = $sactareas->DatosUsuario($responsable);
            $responsable = $datosresponsable["usuario_nombre"] . ' ' . $datosresponsable["usuario_apellido"];
            $id_eje = $metas[$i]["id_eje"];
            $datosejes = $sactareas->datosEjes($id_eje);
            $dataResponsables = ''; // inicializa antes del foreach
            $listarresponsables = $sactareas->listarresponsables($id_meta);
            // foreach ($listarresponsables as $id_responsable) {
            $datosresponsablet = $sactareas->DatosUsuario($meta_responsable);
            @$nombre_responsable = $datosresponsablet["usuario_nombre"] . ' ' . $datosresponsablet["usuario_apellido"];
            @$colorusuario = $datosresponsablet["usuario_color"];
            @$primernombre = mb_strtoupper(mb_substr($datosresponsablet["usuario_nombre"], 0, 1, 'UTF-8'), 'UTF-8');
            @$primerapellido = mb_strtoupper(mb_substr($datosresponsablet["usuario_apellido"], 0, 1, 'UTF-8'), 'UTF-8');
            $iniciales = $primernombre . $primerapellido;
            $dataResponsables .= '<span class="p-1 rounded-circle text-center  text-semibold text-white fs-10" title="' . $nombre_responsable . '" style="background-color:' . $colorusuario . ';width:36px !important;height:36px !important">' . $iniciales . '</span>';
            // }
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
									<a class="dropdown-item" onclick="acciones(' . $id_meta . ')" >Acciones y tareas</a>
								</div>
							</div>
						</div>',
                "2" => $responsable_meta,
                "3" => $dataResponsables,
                "4" => count($acciones) . ' / ' . count($tareas),
                "5" => '<div style="width:180px" class="fecha-editable pointer" data-id="' . $id_meta . '" data-fecha="' . $fechainiciometa . '">' . $sactareas->fechaCompletaCorta($fechainiciometa) . '</div>',
                "6" => '<div style="width:180px" class="fecha-final-editable pointer" data-id="' . $id_meta . '" data-fecha="' . $vencimiento . '">' . $sactareas->fechaCompletaCorta($vencimiento) . '</div>',
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


    // visualiza las acciones y tareas en modo cuadricula
    case 'acciones':
        $periodos = $sactareas->periodoactual();
        $periodo = $periodos["periodo_actual"];
        $anio = explode("-", $periodo)[0];
        // tomamos el id de la session
        $meta_responsable = $_SESSION["id_usuario"];
        $id_meta = $_POST['id_meta'];
        $data[0] = "";
        $contaacordeonp = 1;
        $contaacordeon = 1;
        // listamos las metas que tiene el usuario de la session
        $nombre_meta = $sactareas->listarTareasPorUsuarioCuadricula($meta_responsable, $anio);
        //mostramos el nombre de la meta seleccionada 
        $nombre_meta_seleccionado = $sactareas->listarMimetaNombre($id_meta);
        // print_r($nombre_meta);
        $contador = 1;
        $meta = mb_strtolower($nombre_meta_seleccionado["meta_nombre"], 'UTF-8');
        $primera_letra = mb_strtoupper(mb_substr($meta, 0, 1, 'UTF-8'), 'UTF-8');
        $resto_texto = mb_substr($meta, 1, null, 'UTF-8');
        $texto_formateado = $primera_letra . $resto_texto;
        $fecha_entrega = $nombre_meta_seleccionado["meta_fecha"];
        $responsable = $nombre_meta_seleccionado["meta_responsable"];
        $id_proyecto = $nombre_meta_seleccionado["id_proyecto"];
        $plan_mejoramiento = $nombre_meta_seleccionado["plan_mejoramiento"];
        $contaacordeonp++;
        $data[0] .= '
			<div class="col-12 p-2">
				<div class="row">
					<div class="col-12 p-2 line-height-16 ">
						<div class="fs-14 font-weight-bolder pb-2">Meta: ' . $contador . '. ' . $texto_formateado . '</div>
					</div>
					';
        $listaracciones = $sactareas->listaraccionescuadricula($meta_responsable, $id_meta);

        $todas_acciones_y_tareas_terminadas = true;
        $data[0] .= '
        <div class="accordion col-12" id="accordionExample' . $contador . '">';
        for ($c = 0; $c < count($listaracciones); $c++) {
            $id_accion = $listaracciones[$c];

            $datos_accion = $sactareas->mostrarnombreaccion($id_accion);
            $fechaaccion = $datos_accion["fecha_fin"];
            $nombre_accion = $datos_accion["nombre_accion"];
            $accion_estado = $datos_accion["accion_estado"];

            // $id_accion = $accion["id_accion"];
            // $fechaaccion = $nombre_accion["fecha_fin"];
            // $nombre_accion = $nombre_accion["nombre_accion"];
            // $accion_estado = $nombre_accion["accion_estado"]; 
            $total_tareas = $sactareas->contarTareasPorAccion($id_accion);
            $tareas_finalizadas = $sactareas->contarTareasFinalizadasPorAccion($id_accion);
            $porcentaje = $total_tareas > 0 ? round(($tareas_finalizadas / $total_tareas) * 100) : 0;
            $color_barra = '';
            if ($porcentaje < 50) {
                $color_barra = 'bg-danger';
            } elseif ($porcentaje < 100) {
                $color_barra = 'bg-warning';
            } else {
                $color_barra = 'bg-success';
            }
            $mostrar_tareas = $sactareas->mostrartareas($id_accion,$meta_responsable);
            $cantidad_tareas = count($mostrar_tareas);
            $todas_terminadas = true;
            for ($j = 0; $j < $cantidad_tareas; $j++) {
                if ($mostrar_tareas[$j]["estado_tarea"] == 0) {
                    $todas_terminadas = false;
                    break;
                }
            }

            // if ($accion_estado == 0 || !$todas_terminadas) {
            //     $todas_acciones_y_tareas_terminadas = false;
            // }

            $contaacordeon++;
            $data[0] .= '
                <div class="card">
                    <div class="card-header tono-2" id="headingOne' . $contaacordeon . '">
                        
                            <div class="row">
                                <div class="col-10">
                                    <div style="100%" class="fecha-editable-accion text-gray pointer" data-id="' . $id_accion . '" data-fecha="' . $fechaaccion . '"> 
                                        <i class="fa-solid fa-calendar-days text-gray fs-12"></i>  ' . $sactareas->fechaCompletaCorta($fechaaccion) . '
                                    </div>
                                </div>
                                <div class="col-2 text-right">';

            // if ($accion_estado == 0) {
            //     if ($cantidad_tareas > 0 && $todas_terminadas) {
            //         $data[0] .= '<button class="btn  btn-xs text-primary" onclick="terminar_accion_dependencia(' . $id_accion . ')" title="Terminar acción"><i class="fas fa-check"></i></button>';
            //     }
            //     if ($cantidad_tareas == 0) {
            //         $data[0] .= '
            //         <button class="btn  btn-xs " onclick="eliminar_accion(' . $id_accion . ',' . $id_meta . ')" title="Eliminar acción">
            //             <i class="far fa-trash-alt text-danger"></i>
            //         </button>';
            //     }
            // } else {
            //     $data[0] .= '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
            // }


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
        </div>
        </div>
        <div id="collapseOne' . $contaacordeon . '" class="collapse" aria-labelledby="headingOne' . $contaacordeon . '" data-parent="#accordionExample' . $contador . '">
        <div class="card-body col-12">';
            for ($n = 0; $n < count($mostrar_tareas); $n++) {
                $filatarea = $contaacordeon . $n;
                $id_tarea_sac = $mostrar_tareas[$n]["id_tarea_sac"];
                $nombre_tarea = $mostrar_tareas[$n]["nombre_tarea"];
                $fecha_entrega =    $mostrar_tareas[$n]["fecha_entrega_tarea"];
                // $meta_responsable = $mostrar_tareas[$n]["responsable_tarea"];
                $link_evidencia_tarea = $mostrar_tareas[$n]["link_evidencia_tarea"];
                $datosusuario = $sactareas->DatosUsuario($meta_responsable);
                $nombre1 = $datosusuario["usuario_nombre"];
                $nombre2 = $datosusuario["usuario_nombre_2"];
                $apellido1 = $datosusuario["usuario_apellido"];
                $apellido2 = $datosusuario["usuario_apellido_2"];
                $nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;
                // <div class="col-12 fs-14">' . ($n + 1) . ' ' . $nombre_tarea . ' </div>
                $data[0] .= '
                    <div class="row borde-bottom py-2" >
                        <div class="col-8">
                            <div class="row">
                                <div class="col-12 fs-14">' . ($n + 1) . ' ' . $nombre_tarea . ' </div>
                                <div class="col-12 small text-gray">' . (!empty($fecha_entrega) ? $sactareas->fechaesp($fecha_entrega) : 'Sin fecha') . '</div>
                                <div class="col-12 fs-12">' . $nombre_completo . '</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-12" >';
                if ($mostrar_tareas[$n]["estado_tarea"] == 0) {
                    if ($link_evidencia_tarea) {
                        $data[0] .= '<button class="btn btn-primary btn-xs" onclick="terminar_tarea_accion(' . $id_tarea_sac . ', ' . $id_accion . ')" title="Marcar como terminada"> <i class="fas fa-check"></i> </button>';
                    } else {
                        $data[0] .= '<span class="fs-14">Para poder validar debes subir el link de la tarea.</span>';
                    }
                } else {
                    $data[0] .= '<span class="bg-success text-white px-2 py-1 rounded"> <i class="fas fa-check-double"></i> </span>';
                }
                if ($link_evidencia_tarea) {
                    $data[0] .= '<a href="' . htmlspecialchars($link_evidencia_tarea) . '" target="_blank" class="btn btn-outline-info btn-xs" title="Ver evidencia"> <i class="fas fa-external-link-alt"></i> Ver </a>';
                } else {
                    $data[0] .= '
                    
                    <button class="btn bg-purple btn-xs" onclick="CrearTareaPopover(event,' . $id_tarea_sac . ')">
                        <i class="fas fa-plus-circle"></i> Evidencia
                    </button>
                    
                    
                    
                    
                    ';
                }
                $data[0] .= '
                        </div>
                    </div>
                </div>
            </div>';
            }
            $data[0] .= '													
                    </div>
                </div>
            </div>';

            // if ($todas_acciones_y_tareas_terminadas && count($listaracciones) > 0) {
            //     $data[0] .= '
            //     <div class="row">
            //         <label>Estado Meta</label>
            //         <div class="btn-group btn-group-toggle col-12" data-toggle="buttons">
            //             <label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'active' : '') . '">
            //                 <input style="height: 0.5px" type="radio" id="meta_lograda" name="meta_lograda" value="1" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 1 ? 'checked' : '') . '> SI
            //             </label>
            //             <label class="btn btn-info col-12 ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'active' : '') . '">
            //                 <input style="height: 0.5px" name="meta_lograda" value="0" type="radio" onchange="actualizar_estado_meta(`' . $id_meta . '`)" ' . ($nombre_meta[$f]["estado_meta"] == 0 ? 'checked' : '') . '> NO
            //             </label>
            //         </div>
            //     </div>';
            // }
        }
        $data[0] .= ' 
                </div>';
        $data[0] .= '
				</div>
			</div>';


        echo json_encode($data);
        break;

         case 'guardarlinktarea':
        $id_tarea_sac = $_POST['id_tarea_sac'];
        $link = $_POST['link_evidencia_tarea'];
        $guardado = $sactareas->guardarlinktarea($id_tarea_sac, $link);
        if ($guardado) {
            // Marcar como finalizada automáticamente
            $sactareas->terminar_tarea($id_tarea_sac);
            echo "Link guardado correctamente";
        } else {
            echo "Error al guardar el link";
        }
        break;

            case 'marcar_tarea_finalizada':
        $id_tarea_sac = $_POST['id_tarea_sac'];
        $marcada = $sactareas->marcarTareaPendienteFinalizada($id_tarea_sac);
        if ($marcada) {
            echo "Tarea marcada como finalizada";
        } else {
            echo "Error al marcar la tarea";
        }
        break;
   
}
