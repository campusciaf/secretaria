<?php 
require_once "../modelos/SofiAdminTareas.php";
date_default_timezone_set('America/Bogota');
session_start();
$consulta =  new Consulta();

switch ($_GET['op']) {

    case 'consulta':

        $data['conte'] = '';
        
        $asesores = $consulta->asesores();

        $data['conte'] .= '
        
            <div class="row d-flex justify-content-center pb-4">

                    <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                            <div class="col-12 hidden">
                                    <div class="row align-items-center" id="t-tog">
                                        <div class="col-auto">
                                        <div class="avatar rounded bg-light-white text-black">
                                            <i class="fa-solid fa-tags"></i>
                                        </div>
                                        </div>
                                        <div class="col ps-0">
                                        <div class="small mb-0">Total</div>
                                        <h4 class="text-dark mb-0">
                                                <span class="text-semibold" id="dato_caracterizados">0</span> 
                                                <small class="text-regular">OK</small>
                                        </h4>
                                        <div class="small">General <span class="text-green"></span></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                            <div class="col-12 hidden">
                                    <div class="row align-items-center" id="t-toc">
                                        <div class="col-auto">
                                        <div class="avatar rounded bg-light-green text-success">
                                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                        </div>
                                        </div>
                                        <div class="col ps-0">
                                        <div class="small mb-0">Total</div>
                                        <h4 class="text-dark mb-0">
                                                <span class="text-semibold" id="dato_caracterizados">0</span> 
                                                <small class="text-regular">OK</small>
                                        </h4>
                                        <div class="small">Cumplidas <span class="text-green"></span></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                            <div class="col-12 hidden">
                                    <div class="row align-items-center" id="t-top">
                                        <div class="col-auto">
                                        <div class="avatar rounded bg-light-yellow text-warning">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </div>
                                        </div>
                                        <div class="col ps-0">
                                        <div class="small mb-0">Total</div>
                                        <h4 class="text-dark mb-0">
                                                <span class="text-semibold" id="dato_caracterizados">0</span> 
                                                <small class="text-regular">OK</small>
                                        </h4>
                                        <div class="small">Próximas <span class="text-green"></span></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                            <div class="col-12 hidden">
                                    <div class="row align-items-center" id="t-tcm">
                                        <div class="col-auto">
                                        <div class="avatar rounded bg-light-red text-danger">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                        </div>
                                        <div class="col ps-0">
                                        <div class="small mb-0">Total</div>
                                        <h4 class="text-dark mb-0">
                                                <span class="text-semibold" id="dato_caracterizados">0</span> 
                                                <small class="text-regular">OK</small>
                                        </h4>
                                        <div class="small">No Cumplidas <span class="text-green"></span></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                            <div class="col-12 hidden">
                                    <div class="row align-items-center" id="t-tod">
                                        <div class="col-auto">
                                        <div class="avatar rounded bg-light-blue text-primary">
                                            <i class="fa-regular fa-sun"></i>
                                        </div>
                                        </div>
                                        <div class="col ps-0">
                                        <div class="small mb-0">Total</div>
                                        <h4 class="text-dark mb-0">
                                                <span class="text-semibold" id="dato_caracterizados">0</span> 
                                                <small class="text-regular">OK</small>
                                        </h4>
                                        <div class="small">Del día <span class="text-green"></span></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
            </div>

        ';

		$data['conte'] .= '<div class="row">';
        
        for ($i=0; $i < count($asesores); $i++) {

            $datos2 = $consulta->consulta_datos($asesores[$i]['id_usuario'],'Cita');
            $datos3 = $consulta->consulta_datos($asesores[$i]['id_usuario'],'Observacion');
            $datos4 = $consulta->consulta_datos($asesores[$i]['id_usuario'],'Acuerdo de Pago');
            $datos = $consulta->consulta_datos($asesores[$i]['id_usuario'],'Llamada');

            $total = count($datos)+count($datos2)+count($datos3);
            $fecha_hoy = date("Y-m-d");
            

            // Inicio valida las citas cunplidas, de hoy y las no realizadas
            $c_cumplida = 0;
            $c_para_hoy = 0;
            $c_hoy = 0;
            $c_no_realizada = 0;

            if ($datos2) {
                for ($a=0; $a < count($datos2); $a++) { 
                    if ($datos2[$a]['tarea_fecha'] == $fecha_hoy AND $datos2[$a]['tarea_estado'] == 0) {
                        $c_para_hoy++;
                    }
                    else if ($datos2[$a]['tarea_fecha'] > $fecha_hoy AND $datos2[$a]['tarea_estado'] == 0) {
                        $c_hoy++;
                    }
                    else if ($datos2[$a]['tarea_fecha'] < $fecha_hoy  AND $datos2[$a]['tarea_estado'] == 0) {
                        $c_no_realizada++;
                    }
                    else{
                        $c_cumplida++;
                    } 
                }
            }
            // Fin valida las citas cunplidas, de hoy y las no realizadas

            // Inicio valida las seguimientos cunplidas, de hoy y las no realizadas
            $s_cumplida = 0;
            $s_para_hoy= 0;
            $s_hoy = 0;
            $s_no_realizada = 0;

            if ($datos3) {
                for ($a=0; $a < count($datos3); $a++) { 
                    if ($datos3[$a]['tarea_fecha'] == $fecha_hoy AND $datos3[$a]['tarea_estado'] == 0) {
                        $s_para_hoy++;
                    }
                    else if ($datos3[$a]['tarea_fecha'] > $fecha_hoy AND $datos3[$a]['tarea_estado'] == 0) {
                        $s_hoy++;
                    }
                    else if ($datos3[$a]['tarea_fecha'] < $fecha_hoy  AND $datos3[$a]['tarea_estado'] == 0) {
                        $s_no_realizada++;
                    }
                    else{
                        $s_cumplida++;
                    }
                }
            }
            // Inicio valida las seguimientos cunplidas, de hoy y las no realizadas
            $acuerdos_cumplida = 0;
            $acuerdos_para_hoy= 0;
            $acuerdos_hoy = 0;
            $acuerdos_no_realizada = 0;

            if ($datos4) {
                for ($a=0; $a < count($datos4); $a++) { 
                    if ($datos4[$a]['tarea_fecha'] == $fecha_hoy AND $datos4[$a]['tarea_estado'] == 0) {
                        $acuerdos_para_hoy++;
                    }
                    else if ($datos4[$a]['tarea_fecha'] > $fecha_hoy AND $datos4[$a]['tarea_estado'] == 0) {
                        $acuerdos_hoy++;
                    }
                    else if ($datos4[$a]['tarea_fecha'] < $fecha_hoy  AND $datos4[$a]['tarea_estado'] == 0) {
                        $acuerdos_no_realizada++;
                    }
                    else{
                        $acuerdos_cumplida++;
                    }
                }
            }
            // Fin valida las seguimientos cunplidas, de hoy y las no realizadas

            // Inicio valida las llamadas cunplidas, de hoy y las no realizadas
            $l_cumplida = 0;
            $l_para_hoy = 0;
            $l_hoy = 0;
            $l_no_realizada = 0;

            if ($datos) {
                for ($a=0; $a < count($datos); $a++) { 
                    if ($datos[$a]['tarea_fecha'] == $fecha_hoy AND $datos[$a]['tarea_estado'] == 0) {
                        $l_para_hoy++;
                    }
                   else if ($datos[$a]['tarea_fecha'] > $fecha_hoy AND $datos[$a]['tarea_estado'] == 0) {
                        $l_hoy++;
                    }
                    else if ($datos[$a]['tarea_fecha'] < $fecha_hoy  AND $datos[$a]['tarea_estado'] == 0) {
                        $l_no_realizada++;
                    }
                    else{
                        $l_cumplida++;
                    }
                }
            }
            // Fin valida las llamadas cunplidas, de hoy y las no realizadas



            $nombre = $asesores[$i]['usuario_nombre'].' '.$asesores[$i]['usuario_apellido'];
            $data['conte'] .= '                
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="t-as">
                    <div class="card col-12">
                       
                        <div class="row tono-3">
                            <div class="col-12 p-2 py-3">
                                <div class="row align-items-center">
                                    <div class="pl-4">
                                        <span class="rounded bg-light-green p-2 text-success ">
                                            <i class="fa-solid fa-headset"></i>
                                        </span> 
                                    </div>
                                    <div class="col-10">
                                    <div class="col-8 fs-14 line-height-18"> 
                                        <span class="">'.$asesores[$i]['usuario_cargo'].'</span> <br>
                                        <span class="text-semibold fs-16">'.$nombre.'</span> 
                                    </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table table-hover">
                                <tbody>
                                    <tr id="t-C">
                                        <td>Citas</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(1,'.$asesores[$i]['id_usuario'].',1)">'.count($datos2).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(1,'.$asesores[$i]['id_usuario'].',2)">'.$c_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(1,'.$asesores[$i]['id_usuario'].',3)">'.$c_hoy.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(1,'.$asesores[$i]['id_usuario'].',4)">'.$c_no_realizada.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(1,'.$asesores[$i]['id_usuario'].',5)">'.$c_para_hoy.'</button></td>
                                    </tr>
                                    <tr >
                                        <td id="t-seg" >Seguimientos</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(2,'.$asesores[$i]['id_usuario'].',1)">'.count($datos3).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(2,'.$asesores[$i]['id_usuario'].',2)">'.$s_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(2,'.$asesores[$i]['id_usuario'].',3)">'.$s_hoy.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(2,'.$asesores[$i]['id_usuario'].',4)">'.$s_no_realizada.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(2,'.$asesores[$i]['id_usuario'].',5)">'.$s_para_hoy.'</button></td>
                                    </tr>
                                    <tr id="t-Lla">
                                        <td>Llamadas</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(3,'.$asesores[$i]['id_usuario'].',1)">'.count($datos).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(3,'.$asesores[$i]['id_usuario'].',2)">'.$l_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(3,'.$asesores[$i]['id_usuario'].',3)">'.$l_hoy.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(3,'.$asesores[$i]['id_usuario'].',4)">'.$l_no_realizada.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(3,'.$asesores[$i]['id_usuario'].',5)">'.$l_para_hoy.'</button></td>
                                    </tr>
                                    <tr id="t-Acuerdos">
                                        <td>Acuerdos de Pago</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(5,'.$asesores[$i]['id_usuario'].',1)">'.count($datos4).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(5,'.$asesores[$i]['id_usuario'].',2)">'.$acuerdos_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(5,'.$asesores[$i]['id_usuario'].',3)">'.$acuerdos_hoy.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(5,'.$asesores[$i]['id_usuario'].',4)">'.$acuerdos_no_realizada.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(5,'.$asesores[$i]['id_usuario'].',5)">'.$acuerdos_para_hoy.'</button></td>
                                    </tr>
                                    <tr id="t-to">
                                        <td>Totales</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(4,'.$asesores[$i]['id_usuario'].',1)">'.$total.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(4,'.$asesores[$i]['id_usuario'].',2)">'.($c_cumplida+$l_cumplida+$s_cumplida+$acuerdos_cumplida).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(4,'.$asesores[$i]['id_usuario'].',3)">'.($c_hoy+$l_hoy+$s_hoy+$acuerdos_hoy).'</button> </td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(4,'.$asesores[$i]['id_usuario'].',4)">'.($c_no_realizada+$l_no_realizada+$s_no_realizada+$acuerdos_no_realizada).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(4,'.$asesores[$i]['id_usuario'].',5)">'.($c_para_hoy+$l_para_hoy+$s_para_hoy+$acuerdos_para_hoy).'</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                ';
        }
        
		$data['conte'] .= '</div>';
        

        echo json_encode($data);

    break;

    case 'buscar':
        $id = $_POST['id'];
        $tipo = $_POST['tipo'];
        $cslt = $_POST['consulta'];
        $fecha_hoy = date("Y-m-d");

        if ($tipo == "1") {
            $sql = "='Cita'";
        }
        if ($tipo == "2") {
            $sql = "='Observacion'";
        }
        if ($tipo == "3") {
            $sql = "='Llamada'";
        }
        if ($tipo == "5") {
            $sql = "='Acuerdo de Pago'";
        }
        if ($tipo == "4") {
            $sql = "!=''";
        }

        if ($cslt == "1") {
            $sql2 = "";
        }
        if ($cslt == "2") {
            $sql2 = "AND tarea_estado = 1";
        }
        if ($cslt == "3") {
            $sql2 = "AND tarea_fecha > '$fecha_hoy' AND tarea_estado = 0";
        }
        if ($cslt == "4") {
            $sql2 = "AND tarea_fecha < '$fecha_hoy' AND tarea_estado = 0";
        }
        if ($cslt == "5") {
            $sql2 = "AND tarea_fecha = '$fecha_hoy' AND tarea_estado = 0";
        }

        $asesores = $consulta->asesores();

        $datos = $consulta->buscar($id,$sql,$sql2);
        
        $data['conte'] = '';
        $data['conte'] .= '
        
        <div class="row">

            <div class="col-12 py-3 pr-4 text-right ">
                <button class="btn btn-danger" onclick="volver()"><i class="fas fa-arrow-left"></i> Volver </button>
            </div>

            <div class="card col-12">
                <div class="row">
                    <div class="col-12 p-4">
                        <table class="table" id="tbl_buscar" style="width:100%">
                            <thead>
                            <tr>
                                <th>Ref#</th>
                                <th>Nombre</th>
                                <th>Motivo</th>
                                <th>Recordatorio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Asesor</th>
                                <th>Seguimiento</th>
                            </tr>
                            </thead>
                            <tbody>';
                            
                            for ($i=0; $i <count($datos); $i++) {
                                $datos_estudia = $consulta->datos_estudiante($datos[$i]['id_persona']);
                                $nombre_estudiante = $datos_estudia['nombre'].' '.$datos_estudia['nombres'].' '.$datos_estudia['apellidos'];

                                $select  = '';
                                
                                $select .= '<select class="form-control asesor" onchange="cambiarasesor('.$datos[$i]['id_tarea'].',this.value,'.intval($tipo).','.intval($id).','.intval($cslt).')">';
                                    for ($s=0; $s < count($asesores); $s++) {
                                        
                                        if ($asesores[$s]['id_usuario'] == $datos[$i]['id_asesor']) {
                                            $select .= '<option value="'.$asesores[$s]['id_usuario'].'" selected>'.$asesores[$s]['usuario_nombre'].' '.$asesores[$s]['usuario_apellido'].'</option>';
                                            $nombre = $asesores[$s]['usuario_nombre'].' '.$asesores[$s]['usuario_apellido'];
                                        } else {
                                            $select .='<option value="'.$asesores[$s]['id_usuario'].'">'.$asesores[$s]['usuario_nombre'].' '.$asesores[$s]['usuario_apellido'].'</option>';
                                        }
                                    }
                                $select .= '</select>';

                                $fecha_inut = '';

                                if ($datos[$i]['tarea_estado'] == 0) {                    
                                    $fecha_inut = '<input class="form-control" type="date" onchange="cambiarfecha('.$datos[$i]['id_tarea'].',this.value,'.intval($tipo).','.intval($id).','.intval($cslt).')" min="'.$fecha_hoy.'" value="'.$datos[$i]['tarea_fecha'].'">';
                                }else{
                                    $select = $nombre;
                                    $fecha_inut = $datos[$i]['tarea_fecha'];
                                }
                                $validar_tarea = '';
                                if ($datos[$i]['tarea_estado'] == 0) {
                                    $validar_tarea = '<a onclick="validarTarea('.$id.','.$tipo.','.$cslt.','.$datos[$i]['id_tarea'].')" class="btn btn-warning btn-xs" title="Tarea realizada"><i class="fas fa-check"></i></a>';
                                }
                                if (isset($datos_estudia["celular"])) {
                                    $estilo_whatsapp = 'btn-success';
                                    $numero_celular = $datos_estudia["celular"];
                                } else {
                                    $estilo_whatsapp = 'btn-danger disabled';
                                    $numero_celular = '';
                                }

                                $data['conte'] .= '
                                <tr>
                                    <td>'.$datos[$i]['id_tarea'].'</td>
                                    <td>'.$nombre_estudiante.'</td>
                                    <td>'.$datos[$i]['tarea_motivo'].'</td>
                                    <td>'.$datos[$i]['tarea_observacion'].'</td>
                                    <td>'.$fecha_inut.'</td>
                                    <td>'.$datos[$i]['tarea_hora'].'</td>
                                    <td>'.$select.'</td>
                                    <td>
                                        <a onclick="verHistorial('.$datos[$i]['id_credencial'].')" class="btn btn-primary btn-xs" title="Ver General">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a onclick="agregarTareaSegui('.$datos[$i]['id_credencial'].','.$datos[$i]['id_persona'].')" class="btn btn-success btn-xs text-white" title="Agregar Seguimiento">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        <button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
                                        '.$validar_tarea.'
                                        </td>
                                </tr>';
                            }

                        $data['conte'] .= '</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        ';

        echo json_encode($data);

    break;

    case 'cambiarasesor':
        $id_tarea = $_POST['id_tarea'];
        $id_asesor = $_POST['id_asesor'];
        $dato = $consulta->consultaTarea($id_tarea);
        $consulta->cambiarasesor($id_tarea,$id_asesor,$dato['id_asesor']);
    break;

    case 'cambiarfecha':
        $id_tarea = $_POST['id_tarea'];
        $fecha = $_POST['fecha'];
        $dato = $consulta->consultaTarea($id_tarea);
        $consulta->cambiarfecha($id_tarea,$fecha,$dato['tarea_fecha']);
    break;
    
    case 'agregarSeguimiento':

        $id_usuario=$_SESSION['id_usuario'];
        $id_estudiante_agregar=isset($_POST["id_estudiante_agregar"])? limpiarCadena($_POST["id_estudiante_agregar"]):"";
        $motivo_seguimiento=isset($_POST["motivo_seguimiento"])? limpiarCadena($_POST["motivo_seguimiento"]):"";
        $mensaje_seguimiento=isset($_POST["mensaje_seguimiento"])? limpiarCadena($_POST["mensaje_seguimiento"]):"";
        $fecha=date('Y-m-d');
        $hora=date('H:i:s');

		$rspta=$consulta->insertarSeguimiento($id_usuario,$id_estudiante_agregar,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora);
        echo $rspta ? "Seguimiento registrado" : "Seguimiento no se pudo registrar";
	break;	
		
	case 'agregarTarea':
		$fecha_realizo=NULL;
        $hora_realizo=NULL;
        $fecha=date('Y-m-d');
        $periodo_actual=$_SESSION['periodo_actual'];
        $hora=date('H:i:s');
        $id_usuario=$_SESSION['id_usuario'];
        $id_estudiante_tarea=isset($_POST["id_estudiante_tarea"])? limpiarCadena($_POST["id_estudiante_tarea"]):"";
        $motivo_tarea=isset($_POST["motivo_tarea"])? limpiarCadena($_POST["motivo_tarea"]):"";
        $mensaje_tarea=isset($_POST["mensaje_tarea"])? limpiarCadena($_POST["mensaje_tarea"]):"";
        $fecha_programada=isset($_POST["fecha_programada"])? limpiarCadena($_POST["fecha_programada"]):"";
        $hora_programada=isset($_POST["hora_programada"])? limpiarCadena($_POST["hora_programada"]):"";
		$rspta=$consulta->insertarTarea($id_usuario,$id_estudiante_tarea,$motivo_tarea,$mensaje_tarea,$fecha,$hora,$fecha_programada,$hora_programada,$fecha_realizo,$hora_realizo,$periodo_actual);
        echo $rspta ? "Tarea Programada" : "Tarea no se pudo Programar";
    break;

    case 'validarTarea':
        $id_tarea = $_POST['id_tarea'];
        $fecha=date('Y-m-d');
        $hora=date('H:i:s');
        $consulta->validarTarea($id_tarea,$hora,$fecha);
    break;

}

?>