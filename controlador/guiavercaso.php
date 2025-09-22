<?php 
session_start();
date_default_timezone_set('America/Bogota');
require_once "../modelos/Guiavercaso.php";

require ('../public/mail/sendQuedate.php');
require ('../public/mail/templateRemision.php');

$vercaso = new Vercaso();
switch ($_GET['op']) {
    case 'verdatos':
        $id_caso = $_POST['id'];
        $datos = $vercaso->guia_casos($id_caso);

        $datos_seguimiento = $vercaso->guia_seguimientos($id_caso);
        $datos_remsiones = $vercaso->guia_remsiones($id_caso);
        $datos_tareas = $vercaso->guia_tareas($id_caso);
        $data = array();
        $data_envia['conte'] = '';
        for ($i=0; $i < count($datos_seguimiento); $i++) { 
            //$data .= '{ `tipo`: seguimiento,  `conte`: '.$datos_seguimiento[$i].'}';
            if ($datos_seguimiento) {
                $data[] = array(
                    'tipo' => 'seguimiento',
                    'conte' => $datos_seguimiento[$i]
                );
            }
        }
        for ($i=0; $i < count($datos_remsiones); $i++) { 
            if ($datos_remsiones AND $datos_seguimiento) {
                array_push($data,array(
                    'tipo' => 'remisiones',
                    'conte' => $datos_remsiones[$i]
                ));
            }else{
                $data[] = array(
                    'tipo' => 'remisiones',
                    'conte' => $datos_remsiones[$i]
                );
            }
        }
        for ($i=0; $i < count($datos_tareas); $i++) { 
            if ($datos_tareas || $datos_seguimiento || $datos_remsiones) {
                array_push($data,array(
                    'tipo' => 'tareas',
                    'conte' => $datos_tareas[$i]
                ));
            }else{
                $data[] = array(
                    'tipo' => 'tareas',
                    'conte' => $datos_tareas[$i]
                );
            }
        }
        function compara_fecha($a, $b){
            return strtotime(trim($a['conte']['created_at'])) < strtotime(trim($b['conte']['created_at']));
        }
        $button = ($datos['caso_estado'] == "Activo") ? '<div class="col-12 col-md-6 text-right" >
                                    <button class="btn btn-success" data-toggle="modal" data-target="#modal_seguimiento">Seguimiento</button>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal_tarea">Tarea</button>
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#modal_remitir">Remitir</button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#modal_cerrar">Cerrar</button>
                                </div>' : '' ;
        $color = ($datos['caso_estado'] == "Activo") ? 'success' : 'danger' ;
        $url = ($datos['caso_estado'] == "Activo") ? '../public/evidencias_guia/seguimiento/' : '../public/evidencias_guia/seguimiento/' ;
        $data_envia['conte'] .= '<h3 class="col-12 col-md-6 tab-content-title text-'.$color.'">
                '.$datos['caso_asunto'].'
                <span class="label label-'.$color.'" style="font-size: 50%; margin-left: 5px">'.$datos['caso_estado'].'</span>
            </h3>'.$button.'
            <div class="timeline col-12 pt-2">';          
        if ($datos_seguimiento || $datos_remsiones || $datos_tareas) {
            usort($data, 'compara_fecha');
            for($i=0; $i < count($data); $i++){
                if($data[$i]['tipo'] == 'seguimiento'){
                    $evidencia = '';
                    if($data[$i]['conte']['evidencia_seguimiento']!=""){
                        $extencion = explode(".",$data[$i]['conte']['evidencia_seguimiento']);
                        $evidencia = ($extencion[1] == 'pdf') ? '<p> Evidencia: 
                            <a href="../public/evidencias_guia/seguimiento/'.$data[$i]['conte']['evidencia_seguimiento'].'" target="_blank" rel="noopener noreferrer" class="text-danger">
                                <i class="far fa-file-pdf fa-2x"></i>
                            </a>
                        </p>':'<p> Evidencia: 
                            <a href="../public/evidencias_guia/seguimiento/'.$data[$i]['conte']['evidencia_seguimiento'].'" target="_blank" rel="noopener noreferrer">
                                <i class="far fa-image fa-2x"></i>
                            </a>
                        </p>';
                    }
                    $beneficio = ($data[$i]['conte']['seguimiento_beneficio'] == "") ? '' : 'Beneficio: '.$data[$i]['conte']['seguimiento_beneficio'];
                    $tipo_encuentro = ($data[$i]['conte']['seguimiento_tipo_encuentro'] == "") ? '' : 'Tipo de encuentro: '.$data[$i]['conte']['seguimiento_tipo_encuentro'];
                    $docente = ($data[$i]['conte']['docente'] == "") ? '' : 'Docente involucrado: '. strtoupper($vercaso->guia_nombre_docente($data[$i]['conte']['docente']));
                    $data_envia['conte'] .='
                    <div>
                        <i class="fas fa-binoculars bg-green"></i>
                        <div class="timeline-item" >
                            <span class="text-muted time">'.$data[$i]['conte']['created_at'].'</span>
                            <h3 class="timeline-header">
                                <a href="#"> Seguimiento</a>
                            </h3>
                            <div class="timeline-body">
                                <p>Contenido: '.$data[$i]['conte']['seguimiento_contenido'].'</p>
                                <p>'.$beneficio.'</p>
                                <p>'.$tipo_encuentro.'</p>
                                <p>'.$docente.'</p>
                                '.$evidencia.'
                            </div>
                        </div>
                    </div>';
                }
                if ($data[$i]['tipo'] == 'remisiones') {
                    $dependencia_desde = $vercaso->guia_consulta_dependencia($data[$i]['conte']['remision_desde']);
                    $dependencia_para = $vercaso->guia_consulta_dependencia($data[$i]['conte']['remision_para']);
                    $data_envia['conte'] .='
                        <div>
                            <i class="fas fa-paper-plane bg-yellow"></i>
                            <div class="timeline-item" >
                                <span class="text-muted time">'.$data[$i]['conte']['created_at'].'</span>
                                <h3 class="timeline-header">
                                    <a href="#"> Remisiones  </a>
                                </h3>
                                <div class="timeline-body">
                                    <small class="text-muted">'.$dependencia_desde['usuario_cargo'].' <i class="fas fa-long-arrow-alt-right"></i> '.$dependencia_para['usuario_cargo'].'</small>
                                    <p>Obersevación: '.$data[$i]['conte']['remision_observacion'].'</p>
                                </div>
                            </div>
                        </div>';
                }
                if ($data[$i]['tipo'] == 'tareas') {
                    $contenido = ($data[$i]['conte']['tarea_contenido'] == '') ? '' : 'Contenido: '.$data[$i]['conte']['tarea_contenido'];
                    $docente = ($data[$i]['conte']['docente'] == "") ? '' : 'Docente involucrado: '. strtoupper($vercaso->guia_nombre_docente($data[$i]['conte']['docente']));
                    $data_envia['conte'] .='
                        <div>
                            <i class="fas fa-user-clock bg-blue"></i>
                            <div class="timeline-item" >
                                <span class="text-muted time">'.$data[$i]['conte']['created_at'].'</span>
                                <h3 class="timeline-header">
                                    <a href="#"> Tareas</a>
                                </h3>
                                <div class="timeline-body">
                                    <p>Asunto: '.$data[$i]['conte']['tarea_asunto'].'</p>
                                    <p>'.$contenido.'</p>
                                    <p>'.$docente.'</p>
                                </div>
                            </div>
                        </div>';
                }    
            }
        }
        $data_envia['conte'].= '</div>';
        //print_r($data);
        echo json_encode($data_envia);
    break;
    case 'listar_docentes':
        echo json_encode($vercaso->guia_datos_docente());
    break;
    case 'listar_dependencias':
        $vercaso->guia_listar_dependencias();
    break;
    case 'agregar_seguimiento':
        $descripcion = $_POST['descripcion'];
        $id = $_POST['id'];
        $encuentro = $_POST['encuentro'];
        @$recomendacion = $_POST['recomendacion'];
        @$docente = $_POST['docente'];
        $allowedExts = array("pdf", "png", "jpg","jpeg"); 
        if (!empty($_FILES['evidencia']['name'])) {
            $nombre_archivo = $_FILES["evidencia"]["name"];
            $explode_var = explode(".", $nombre_archivo);
            $extension = end($explode_var);
            $target_path = '../public/evidencias_guia/seguimiento/';
            $img1path = $target_path.$_FILES['evidencia']['name'];
            if (in_array($extension, $allowedExts)) {
                if(move_uploaded_file($_FILES['evidencia']['tmp_name'], $img1path)){
                    $evidencia = $_FILES['evidencia']['name'];
                    $vercaso->guia_agregar_seguimiento($descripcion, $id, $encuentro, $recomendacion, $evidencia, $docente);
                }
            }else{
                $data['status'] = 'error';
                $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
                echo json_encode($data);
            }
        } else {
            $evidencia = '';
            $vercaso->guia_agregar_seguimiento($descripcion, $id, $encuentro, $recomendacion, $evidencia, $docente);
        }
    break;
    case 'agregar_tarea':
        $asunto = $_POST['asunto'];
        $id = $_POST['id'];
        $fecha = $_POST['fecha'];
        $descripcion = $_POST['descripcion'];
        $referencia = $_POST['referencia'];
        $docente = $_POST['docente'];
        $fecha = explode(' ',$fecha);
        $hora = date("H:i", strtotime($fecha[1].$fecha[2]));
        $fecha_final = $fecha[0].' '.$hora;
        $vercaso->guia_agregar_tarea($asunto,$id,$fecha_final,$descripcion,$referencia,$docente);
    break;
    case 'cambia_estado_remision':
        $id = $_POST['id'];
        $vercaso->guia_cambia_estado_remision($id);
    break;

    case 'guia_agregar_remision':
        $observacion = $_POST['observacion'];
        $dependencia = $_POST['dependencia'];
        $id = $_POST['caso_id'];
        $email = $vercaso->guia_consulta_dependencia($dependencia);
        $mensaje = templateRemision($id);
        $asunto = "Tienes una nueva remisión en guia";
        $vercaso->guia_agregar_remision($observacion,$dependencia,$id);
        enviar_correo($email['usuario_login'], $asunto, $mensaje, $id);
    break;
    case 'guia_cerrar_caso':
        //echo 1;
        $id = $_POST['caso_id'];
        $observacion = $_POST['observacion'];
        $categoria_cerrar = $_POST['categoria_cerrar'];
        $logro = $_POST['logro'];
        $allowedExts = array("pdf","PDF", "png","PNG", "jpg","JPG","jpeg","JPEG"); 
        if (!empty($_FILES['evidencia']['name'])) {
            $nombre_archivo = $_FILES["evidencia"]["name"];
            $explode_var = explode(".", $nombre_archivo);
            $extension = end($explode_var);
            $target_path = '../public/evidencias_guia/seguimiento/';
            $img1path = $target_path.$_FILES['evidencia']['name'];
            if (in_array($extension, $allowedExts)) {
                if(move_uploaded_file($_FILES['evidencia']['tmp_name'], $img1path)){
                    $evidencia = $_FILES['evidencia']['name'];
                    $vercaso->guia_cerrar_caso($id,$observacion,$logro,$evidencia,$categoria_cerrar);
                }
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }
        
    break;

    case 'buscar_docente':
        $id_caso = $_POST['caso_id'];
        $dato = $vercaso->guia_consulta_id_caso($id_caso);
        $rsta = $vercaso->guia_consultaDocente($dato['id_docente']);
        if(empty($rsta)){
            $data = array(
                'exito' => '0',
                'info' => 'Revisa el documento, no se encontraron datos.'
            );
        }else{
            //verificacion de la imagen
            if (file_exists('../files/docentes/'.$rsta['usuario_identificacion'].'.jpg')) {
                $foto = '../files/docentes/'.$rsta['usuario_identificacion'].'.jpg';
            } else {
                $foto = '../files/null.jpg';
            }
            $data = array(
                'exito' => '1',
                'info' => array(
                    'id_usuario' => $rsta["id_usuario"],
                    'usuario_nombre' => $rsta["usuario_nombre"]." ".$rsta["usuario_nombre_2"],
                    'usuario_apellido' => $rsta["usuario_apellido"]." ".$rsta["usuario_apellido_2"],
                    'usuario_tipo_documento' => $rsta["usuario_tipo_documento"],
                    'usuario_identificacion' => $rsta["usuario_identificacion"],
                    'usuario_direccion' => $rsta["usuario_direccion"],
                    'usuario_celular' => $rsta["usuario_celular"],
                    'usuario_email_ciaf' => $rsta["usuario_email_ciaf"],
                    'foto' => $foto,
                )  
            );
            $html = "";
            $programas = $vercaso->consultaProgramas($rsta["id_usuario"]); 
            for($i =0 ; $i < count($programas);$i++){
                $html .='<li class="list-group-item">
                        <b> Programa:</b><br> <a class=" box-profiledates profile-programa">'.$programas[$i]['nombre'].'</a>
                        </li>
                        <li class="list-group-item">
                        <b>Semestre:</b> <a class="pull-right box-profiledates profile-semestre">'.$programas[$i]['semestre'].'</a>
                        </li>';
            }
            $data['programas'] = $html;
        }
        
        echo(json_encode($data));
    break;

    case 'listar_notificaciones':
        $tares = $vercaso->guia_estado_tareas();
        $remisiones = $vercaso->guia_estado_remisiones();
        $data = array();
        $datos['conte'] = '';
        $datos['cantidad'] = '';
        if ($tares || $remisiones) {


            for ($i=0; $i < count($tares); $i++) { 
                $data[] = array(
                    'tipo' => 'tareas',
                    'conte' => $tares[$i]
                );
            }

            for ($i=0; $i < count($remisiones); $i++) { 
                if ($tares) {
                    array_push($data,array(
                        'tipo' => 'remisiones',
                        'conte' => $remisiones[$i]
                    ));
                }else{
                    $data[] = array(
                        'tipo' => 'remisiones',
                        'conte' => $remisiones[$i]
                    );
                }
            }

            function compara_fecha($a, $b){
                return strtotime(trim($a['conte']['created_at'])) < strtotime(trim($b['conte']['created_at']));
            }

            usort($data, 'compara_fecha');

            $datos['cantidad'] = count($data);
            

            for ($i=0; $i < count($data); $i++) { 
                
                if ($data[$i]['tipo'] == "tareas") {
                    $fecha_ini = new DateTime();//fecha inicial
                    $fecha_fin = new DateTime($data[$i]['conte']['tarea_fecha_ejecucion']);//fecha de cierre

                    $intervalo = $fecha_ini->diff($fecha_fin);
                    $fecha_imprime = '';
                    /* $intervalo->format('%Y años %m meses %d days %H horas %i minutos %s segundos'); */
                    if ($intervalo->format('%d') >= 1) {
                        $fecha_imprime = $intervalo->format('Falta %d dias');
                    }else {
                        $fecha_imprime = $intervalo->format('Falta %H horas %i minutos %s segundos');
                    }
                    
                    $datos['conte'] .= '
                        <li>
                            <a href="guiavercaso.php?op=verC&caso='.$data[$i]['conte']["caso_id"].'">
                                <div class="pull-left">
                                    <i class="text-primary fas fa-user-clock fa-2x"></i>
                                </div>
                                <h4><small><i class="fa fa-clock-o"></i>'.$fecha_imprime.'</small></h4></br>
                                <h4>
                                    '.$data[$i]['conte']['tarea_asunto'].'
                                </h4>
                                <p style="white-space: nowrap; text-overflow: ellipsis; overflow: hidden;" >'.$data[$i]['conte']['tarea_contenido'].'</p>
                            </a>
                        </li>
                    ';
                }

                if ($data[$i]['tipo'] == "remisiones") {
                    $dependencia = $vercaso->guia_consulta_dependencia($data[$i]['conte']['remision_desde']);
                    $fecha_ini = new DateTime();//fecha inicial
                    $fecha_fin = new DateTime($data[$i]['conte']['remision_fecha']);//fecha de cierre

                    $intervalo = $fecha_fin->diff($fecha_ini);
                    $fecha_imprime = '';
                    /* $intervalo->format('%Y años %m meses %d days %H horas %i minutos %s segundos'); */
                    if ($intervalo->format('%d') >= 1) {
                        $fecha_imprime = $intervalo->format('Hace %d dias');
                    }else {
                        $fecha_imprime = $intervalo->format('Hace %H horas %i minutos %s segundos');
                    }
                    $datos['conte'] .= '
					<div class="dropdown-divider"></div>
						<a href="guiavercaso.php?op=verC&caso='.$data[$i]['conte']["caso_id"].'" onclick="cambia_estado_remision('.$data[$i]['conte']['remision_id'].')" class="dropdown-item">
						
						<div class="media">

					
						<div class="media-body">
							<h3 class="dropdown-item-title">
							'.substr($dependencia['usuario_cargo'],0,25).'...
							<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
							</h3>
							<p class="text-sm" >'.$data[$i]['conte']['remision_observacion'].'</p>
							<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> '.$fecha_imprime.'</p>
						</div>
						</div>

					</a>
					<div class="dropdown-divider"></div>

                    ';
                }
            }
        }else {
            $datos['cantidad'] = 0;
        }

        echo json_encode($datos);

    break;
    
    case 'guia_mostrarCategoria':
        $registro = $vercaso->guia_mostrarCategoria();
        echo json_encode($registro);
    break;

}

?>