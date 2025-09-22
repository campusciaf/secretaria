<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once "../modelos/Quedatevercaso.php";
require('../public/mail/sendQuedate.php');
require('../public/mail/templateRemision.php');
$vercaso = new Vercaso();
switch ($_GET['op']) {
    case 'verdatos':
        $id_caso = $_POST['id'];
        $datos = $vercaso->caso($id_caso);
        $datos_seguimiento = $vercaso->seguimientos($id_caso);
        $datos_remsiones = $vercaso->remsiones($id_caso);
        $datos_tareas = $vercaso->tareas($id_caso);
        $data = array();
        $data_envia['conte'] = '';
        for ($i = 0; $i < count($datos_seguimiento); $i++) {
            //$data .= '{ `tipo`: seguimiento,  `conte`: '.$datos_seguimiento[$i].'}';
            if ($datos_seguimiento) {
                $data[] = array(
                    'tipo' => 'seguimiento',
                    'conte' => $datos_seguimiento[$i]
                );
            }
        }
        for ($i = 0; $i < count($datos_remsiones); $i++) {
            if ($datos_remsiones and $datos_seguimiento) {
                array_push($data, array(
                    'tipo' => 'remisiones',
                    'conte' => $datos_remsiones[$i]
                ));
            } else {
                $data[] = array(
                    'tipo' => 'remisiones',
                    'conte' => $datos_remsiones[$i]
                );
            }
        }
        for ($i = 0; $i < count($datos_tareas); $i++) {
            if ($datos_tareas || $datos_seguimiento || $datos_remsiones) {
                array_push($data, array(
                    'tipo' => 'tareas',
                    'conte' => $datos_tareas[$i]
                ));
            } else {
                $data[] = array(
                    'tipo' => 'tareas',
                    'conte' => $datos_tareas[$i]
                );
            }
        }
        // function compara_fecha($a, $b)
        // {
        //     return strtotime(trim($a['conte']['created_at'])) < strtotime(trim($b['conte']['created_at']));
        // }
        function compara_fecha($a, $b) {
            $fechaA = strtotime(trim($a['conte']['created_at']));
            $fechaB = strtotime(trim($b['conte']['created_at']));
            if ($fechaA == $fechaB) {
                return 0;
            } else if ($fechaA < $fechaB) {
                return -1;
            } else {
                return 1;
            }
        }

        $button = ($datos['caso_estado'] == "Activo") ? '
            <div class="col-xl-4 text-right btn-group btn-sm pb-4" >
                <button id="t-S" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_seguimiento">Seguimiento</button>
                <button id="t-T" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_tarea">Tarea</button>
                <button id="t-R" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_remitir">Remitir</button>
                <button id="t-CER" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_cerrar">Cerrar</button>
            </div>' : '';
        $color = ($datos['caso_estado'] == "Activo") ? 'success' : 'danger';

        $data_envia['conte'] .=

            '<div class="col-8 pb-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="rounded bg-light-blue p-2 text-primary">
                            <i class="fa-solid fa-handshake-angle" aria-hidden="true"></i>
                        </span> 
                    
                    </div>
                    <div class="col-10">
                        <span class="fs-12 fs-16 text-semibold line-height-16 text-' . $color . '">' . $datos['caso_estado'] . '</span> <br>
                        <span class="text-semibold fs-14 line-height-16 titulo-2">' . $datos['caso_asunto'] . '</span> 
                    </div>
                </div>
            </div>

            </h3>' . $button . '
            <div class="timeline col-12 pt-2">';


        if ($datos_seguimiento || $datos_remsiones || $datos_tareas) {
            usort($data, 'compara_fecha');
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['tipo'] == 'seguimiento') {
                    $evidencia = '';
                    if ($data[$i]['conte']['evidencia_seguimiento'] != "") {
                        $extencion = explode(".", $data[$i]['conte']['evidencia_seguimiento']);
                        $evidencia = ($extencion[1] == 'pdf') ? '<p> Evidencia: 
                            <a href="../public/evidencias_quedate/seguimiento/' . $data[$i]['conte']['evidencia_seguimiento'] . '" target="_blank" rel="noopener noreferrer" class="text-danger">
                                <i class="far fa-file-pdf fa-2x"></i>
                            </a>
                        </p>' : '<p> Evidencia: 
                            <a href="../public/evidencias_quedate/seguimiento/' . $data[$i]['conte']['evidencia_seguimiento'] . '" target="_blank" rel="noopener noreferrer">
                                <i class="far fa-image fa-2x"></i>
                            </a>
                        </p>';
                    }
                    $beneficio = ($data[$i]['conte']['seguimiento_beneficio'] == "") ? '' : 'Beneficio: ' . $data[$i]['conte']['seguimiento_beneficio'];
                    $tipo_encuentro = ($data[$i]['conte']['seguimiento_tipo_encuentro'] == "") ? '' : 'Tipo de encuentro: ' . $data[$i]['conte']['seguimiento_tipo_encuentro'];
                    $docente = ($data[$i]['conte']['docente'] == "") ? 'Docente involucrado: Ninguno' : 'Docente involucrado: ' . strtoupper($vercaso->nombre_docente($data[$i]['conte']['docente']));
                    $data_envia['conte'] .= '
                    <div>
                        <i class="fas fa-binoculars bg-green"></i>
                        <div class="timeline-item" id="t-SG">
                            <span class="text-muted time pointer" title="' . $data[$i]['conte']['created_at'] . '">' . $vercaso->fechaesp($data[$i]['conte']['created_at']) . '</span>
                            <h3 class="timeline-header">
                                <a href="#"> Seguimiento</a>
                            </h3>
                            <div class="timeline-body">
                                <p>Contenido: ' . $data[$i]['conte']['seguimiento_contenido'] . '</p>
                                <p>' . $beneficio . '</p>
                                <p>' . $tipo_encuentro . '</p>
                                <p>' . $docente . '</p>
                                ' . $evidencia . '
                            </div>
                        </div>
                    </div>';
                }
                if ($data[$i]['tipo'] == 'remisiones') {
                    $dependencia_desde = $vercaso->consulta_dependencia($data[$i]['conte']['remision_desde']);
                    $dependencia_para = $vercaso->consulta_dependencia($data[$i]['conte']['remision_para']);
                    $data_envia['conte'] .= '
                        <div>
                            <i class="fas fa-paper-plane bg-yellow"></i>
                            <div class="timeline-item" >
                                <span class="text-muted time pointer" title="' . $data[$i]['conte']['created_at'] . '">' . $vercaso->fechaesp($data[$i]['conte']['created_at']) . '</span>
                                <h3 class="timeline-header">
                                    <a href="#"> Remisiones  </a>
                                </h3>
                                <div class="timeline-body">
                                    <small class="text-muted">' . $dependencia_desde['usuario_cargo'] . ' <i class="fas fa-long-arrow-alt-right"></i> ' . $dependencia_para['usuario_cargo'] . '</small>
                                    <p>Obersevación: ' . $data[$i]['conte']['remision_observacion'] . '</p>
                                </div>
                            </div>
                        </div>';
                }
                if ($data[$i]['tipo'] == 'tareas') {
                    $contenido = ($data[$i]['conte']['tarea_contenido'] == '') ? '' : 'Contenido: ' . $data[$i]['conte']['tarea_contenido'];
                    $docente = ($data[$i]['conte']['docente'] == "") ? 'Docente involucrado: Ninguno' : 'Docente involucrado: ' . strtoupper($vercaso->nombre_docente($data[$i]['conte']['docente']));
                    $data_envia['conte'] .= '
                        <div>
                            <i class="fas fa-user-clock bg-blue"></i>
                            <div class="timeline-item" id="t-TAE">
                                <span class="text-muted time">' . $data[$i]['conte']['created_at'] . '</span>
                                <h3 class="timeline-header">
                                    <a href="#"> Tareas</a>
                                </h3>
                                <div class="timeline-body">
                                    <p>Asunto: ' . $data[$i]['conte']['tarea_asunto'] . '</p>
                                    <p>' . $contenido . '</p>
                                    <p>' . $docente . '</p>
                                </div>
                            </div>
                        </div>';
                }
            }
        }
        $data_envia['conte'] .= '</div>';
        //print_r($data);
        echo json_encode($data_envia);
        break;
    case 'listar_docentes':
        $vercaso->datos_docente();
        break;
    case 'listar_dependencias':
        $vercaso->listar_dependencias();
        break;
    case 'agregar_seguimiento':
        $descripcion = $_POST['descripcion'];
        $id = $_POST['id'];
        $encuentro = $_POST['encuentro'];
        @$recomendacion = $_POST['recomendacion'];
        @$docente = $_POST['docente'];
        $allowedExts = array("pdf", "png", "jpg", "jpeg");
        if (!empty($_FILES['evidencia']['name'])) {
            $extension = end(explode(".", $_FILES["evidencia"]["name"]));
            $target_path = '../public/evidencias_quedate/seguimiento/';
            $img1path = $target_path . $_FILES['evidencia']['name'];
            if (in_array($extension, $allowedExts)) {
                if (move_uploaded_file($_FILES['evidencia']['tmp_name'], $img1path)) {
                    $evidencia = $_FILES['evidencia']['name'];
                    $vercaso->agregar_seguimiento($descripcion, $id, $encuentro, $recomendacion, $evidencia, $docente);
                }
            } else {
                $data['status'] = 'error';
                $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
                echo json_encode($data);
            }
        } else {
            $evidencia = '';
            $vercaso->agregar_seguimiento($descripcion, $id, $encuentro, $recomendacion, $evidencia, $docente);
        }
        break;
    case 'agregar_tarea':
        $asunto = $_POST['asunto'];
        $id = $_POST['id'];
        $fecha = $_POST['fecha'];
        $descripcion = $_POST['descripcion'];
        $referencia = $_POST['referencia'];
        $docente = $_POST['docente'];
        $fecha = explode(' ', $fecha);
        $hora = date("H:i", strtotime($fecha[1] . $fecha[2]));
        $fecha_final = $fecha[0] . ' ' . $hora;
        $vercaso->agregar_tarea($asunto, $id, $fecha_final, $descripcion, $referencia, $docente);
        break;
    case 'cambia_estado_remision':
        $id = $_POST['id'];
        $vercaso->cambia_estado_remision($id);
        break;

    case 'agregar_remision':
        $observacion = $_POST['observacion'];
        $dependencia = $_POST['dependencia'];
        $id = $_POST['id'];
        $email = $vercaso->consulta_dependencia($dependencia);
        $mensaje = templateRemision($id);
        $asunto = "Tienes una nueva remisión en quedate";
        $vercaso->agregar_remision($observacion, $dependencia, $id);
        enviar_correo($email['usuario_login'], $asunto, $mensaje, $id);
        break;
    case 'cerrar_caso':
        $id = $_POST['id'];
        $observacion = $_POST['observacion'];
        $categorias_cerrado = $_POST['categorias_cerrado'];
        $logro = $_POST['logro'];
        $allowedExts = array("pdf", "PDF", "png", "PNG", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["evidencia"]["name"]);
        $target_path = '../public/evidencias_quedate/';
        $img1path = $target_path . $_FILES['evidencia']['name'];
        if (in_array($extension[1], $allowedExts)) {
            if (move_uploaded_file($_FILES['evidencia']['tmp_name'], $img1path)) {
                $evidencia = $_FILES['evidencia']['name'];
                $vercaso->cerrar_caso($id, $observacion, $logro, $evidencia, $categorias_cerrado);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }
        break;

    case 'buscar_estudiante':
        $id_caso = $_POST['id_caso'];
        $dato = $vercaso->consulta_id_caso($id_caso);
        $rsta = $vercaso->consultaEstudiante($dato['id_estudiante']);
        if (empty($rsta)) {
            $data = array(
                'exito' => '0',
                'info' => 'Revisa el documento, no se encontraron datos.'
            );
        } else {
            //verificacion de la imagen
            if (file_exists('../files/estudiantes/' . $rsta['credencial_identificacion'] . '.jpg')) {
                $foto = '../files/estudiantes/' . $rsta['credencial_identificacion'] . '.jpg';
            } else {
                $foto = '../files/null.jpg';
            }
            $data = array(
                'exito' => '1',
                'info' => array(
                    'id_credencial' => $rsta["id_credencial"],
                    'nombre_estudiante' => $rsta["credencial_nombre"] . " " . $rsta["credencial_nombre_2"],
                    'apellido_estudiante' => $rsta["credencial_apellido"] . " " . $rsta["credencial_apellido_2"],
                    'tipo_identificacion' => $rsta["tipo_documento"],
                    'numero_documento' => $rsta["credencial_identificacion"],
                    'direccion' => $rsta["direccion"],
                    'celular' => $rsta["celular"],
                    'email' => $rsta["credencial_login"],
                    'foto' => $foto,
                )
            );
            $html = "";
            $html .= '<div class="row">';
            $programas = $vercaso->consultaProgramas($rsta["id_credencial"]);
            for ($i = 0; $i < count($programas); $i++) {
                $html .= '<div class="col-6 borde rounded">
                            <b> Programa:</b><br> <a class=" box-profiledates profile-programa">' . $programas[$i]['fo_programa'] . '</a>
                            <b>Semestre:</b> <a class="pull-right box-profiledates profile-semestre">' . $programas[$i]['semestre_estudiante'] . '</a>
                        </div>';
            }
            $html .= '</div>';
            $data['programas'] = $html;
        }

        echo (json_encode($data));
        break;

    case 'listar_notificaciones':
        $tares = $vercaso->estado_tareas();
        $remisiones = $vercaso->estado_remisiones();
        $data = array();
        $datos['conte'] = '';
        $datos['cantidad'] = '';
        if ($tares || $remisiones) {


            for ($i = 0; $i < count($tares); $i++) {
                $data[] = array(
                    'tipo' => 'tareas',
                    'conte' => $tares[$i]
                );
            }

            for ($i = 0; $i < count($remisiones); $i++) {
                if ($tares) {
                    array_push($data, array(
                        'tipo' => 'remisiones',
                        'conte' => $remisiones[$i]
                    ));
                } else {
                    $data[] = array(
                        'tipo' => 'remisiones',
                        'conte' => $remisiones[$i]
                    );
                }
            }

            function compara_fecha($a, $b)
            {
                return strtotime(trim($a['conte']['created_at'])) < strtotime(trim($b['conte']['created_at']));
            }

            usort($data, 'compara_fecha');

            $datos['cantidad'] = count($data);


            for ($i = 0; $i < count($data); $i++) {

                if ($data[$i]['tipo'] == "tareas") {
                    $fecha_ini = new DateTime(); //fecha inicial
                    $fecha_fin = new DateTime($data[$i]['conte']['tarea_fecha_ejecucion']); //fecha de cierre

                    $intervalo = $fecha_ini->diff($fecha_fin);
                    $fecha_imprime = '';
                    /* $intervalo->format('%Y años %m meses %d days %H horas %i minutos %s segundos'); */
                    if ($intervalo->format('%d') >= 1) {
                        $fecha_imprime = $intervalo->format('Falta %d dias');
                    } else {
                        $fecha_imprime = $intervalo->format('Falta %H horas %i minutos %s segundos');
                    }

                    $datos['conte'] .= '
                        <li>
                            <a href="quedatevercaso.php?op=verC&caso=' . $data[$i]['conte']["caso_id"] . '">
                                <div class="pull-left">
                                    <i class="text-primary fas fa-user-clock fa-2x"></i>
                                </div>
                                <h4><small><i class="fa fa-clock-o"></i>' . $fecha_imprime . '</small></h4></br>
                                <h4>
                                    ' . $data[$i]['conte']['tarea_asunto'] . '
                                </h4>
                                <p style="white-space: nowrap; text-overflow: ellipsis; overflow: hidden;" >' . $data[$i]['conte']['tarea_contenido'] . '</p>
                            </a>
                        </li>
                    ';
                }

                if ($data[$i]['tipo'] == "remisiones") {
                    $dependencia = $vercaso->consulta_dependencia($data[$i]['conte']['remision_desde']);
                    $fecha_ini = new DateTime(); //fecha inicial
                    $fecha_fin = new DateTime($data[$i]['conte']['remision_fecha']); //fecha de cierre

                    $intervalo = $fecha_fin->diff($fecha_ini);
                    $fecha_imprime = '';
                    /* $intervalo->format('%Y años %m meses %d days %H horas %i minutos %s segundos'); */
                    if ($intervalo->format('%d') >= 1) {
                        $fecha_imprime = $intervalo->format('Hace %d dias');
                    } else {
                        $fecha_imprime = $intervalo->format('Hace %H horas %i minutos %s segundos');
                    }
                    $datos['conte'] .= '
					<div class="dropdown-divider"></div>
						<a href="quedatevercaso.php?op=verC&caso=' . $data[$i]['conte']["caso_id"] . '" onclick="cambia_estado_remision(' . $data[$i]['conte']['remision_id'] . ')" class="dropdown-item">
						
						<div class="media">

					
						  <div class="media-body">
							<h3 class="dropdown-item-title">
							  ' . substr($dependencia['usuario_cargo'], 0, 25) . '...
							  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
							</h3>
							<p class="text-sm" >' . $data[$i]['conte']['remision_observacion'] . '</p>
							<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ' . $fecha_imprime . '</p>
						  </div>
						</div>

					  </a>
					<div class="dropdown-divider"></div>

                    ';
                }
            }
        } else {
            $datos['cantidad'] = 0;
        }

        echo json_encode($datos);

        break;

    case 'mostrarCategoria':
        $vercaso->mostrarCategoria();
        break;
}
