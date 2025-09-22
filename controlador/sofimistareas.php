<?php 
require_once "../modelos/SofiMisTareas.php";
session_start();
$consulta =  new Consulta();

date_default_timezone_set('America/Bogota');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fechahora=date('Y-m-d H:i:s');

$rsptaperiodo = $consulta->periodoactual();
$periodo_campana = $rsptaperiodo["periodo_campana"];

switch ($_GET['op']) {
    case 'consulta':
        $fecha_hoy = date("Y-m-d");
        
        $asesores = $consulta->asesores();

        $data['conte'] = '';
        $data['general'] = '';
        $data['cumplidas'] = '';
        $data['pendientes'] = '';
        $data['nocumplidas'] = '';
        $data['deldia'] = '';
        
        for ($i=0; $i < count($asesores); $i++) {

            $datos = $consulta->consulta_datos($asesores[$i]['id_usuario'],'llamada');
            $datos2 = $consulta->consulta_datos($asesores[$i]['id_usuario'],'Cita');
            $datos3 = $consulta->consulta_datos($asesores[$i]['id_usuario'],'seguimiento');
            $datos4 = $consulta->consulta_datos($asesores[$i]['id_usuario'],'Acuerdo de Pago');

            // consultamos las tareas que hay para el dia de hoy 
            $datos5 = $consulta->consulta_datos_hoy($asesores[$i]['id_usuario'],'Cita',$fecha_hoy);
            $datos6 = $consulta->consulta_datos_hoy($asesores[$i]['id_usuario'],'seguimiento',$fecha_hoy);
            $datos7= $consulta->consulta_datos_hoy($asesores[$i]['id_usuario'],'llamada',$fecha_hoy);
            $datos8= $consulta->consulta_datos_hoy($asesores[$i]['id_usuario'],'Acuerdo de Pago',$fecha_hoy);


            $total = count($datos)+count($datos2)+count($datos3);

            $total_hoy = count($datos5)+count($datos6)+count($datos7)+count($datos8);

            // Inicio valida las citas cunplidas, de hoy y las no realizadas
            $c_cumplida = 0;
            $c_hoy = 0;
            $c_no_realizada = 0;

            if ($datos2) {
                for ($a=0; $a < count($datos2); $a++) { 
                    if ($datos2[$a]['tarea_fecha'] >= $fecha_hoy AND $datos2[$a]['tarea_estado'] == 0) {
                        $c_hoy++;
                    }
                    if ($datos2[$a]['tarea_fecha'] < $fecha_hoy  AND $datos2[$a]['tarea_estado'] == 0) {
                        $c_no_realizada++;
                    }
                    if ($datos2[$a]['tarea_estado'] == 1) {
                        $c_cumplida++;
                    }
                }
            }
            // Fin valida las citas cunplidas, de hoy y las no realizadas

            // Inicio valida las seguimientos cunplidas, de hoy y las no realizadas
            $s_cumplida = 0;
            $s_hoy = 0;
            $s_no_realizada = 0;

            if ($datos3) {
                for ($a=0; $a < count($datos3); $a++) { 
                    if ($datos3[$a]['tarea_fecha'] >= $fecha_hoy AND $datos3[$a]['tarea_estado'] == 0) {
                        $s_hoy++;
                    }
                    if ($datos3[$a]['tarea_fecha'] < $fecha_hoy  AND $datos3[$a]['tarea_estado'] == 0) {
                        $s_no_realizada++;
                    }
                    if ($datos3[$a]['tarea_estado'] == 1) {
                        $s_cumplida++;
                    }
                }
            }

            // Inicio valida las seguimientos cunplidas, de hoy y las no realizadas
            $acuerdos_cumplida = 0;
            $acuerdos_hoy = 0;
            $acuerdos_no_realizada = 0;

            if ($datos4) {
                for ($a=0; $a < count($datos4); $a++) { 
                    if ($datos4[$a]['tarea_fecha'] >= $fecha_hoy AND $datos4[$a]['tarea_estado'] == 0) {
                        $acuerdos_hoy++;
                    }
                    if ($datos4[$a]['tarea_fecha'] < $fecha_hoy  AND $datos4[$a]['tarea_estado'] == 0) {
                        $acuerdos_no_realizada++;
                    }
                    if ($datos4[$a]['tarea_estado'] == 1) {
                        $acuerdos_cumplida++;
                    }
                }
            }
            // Fin valida las seguimientos cunplidas, de hoy y las no realizadas

            // Inicio valida las llamadas cunplidas, de hoy y las no realizadas
            $l_cumplida = 0;
            $l_hoy = 0;
            $l_no_realizada = 0;

            if ($datos) {
                for ($a=0; $a < count($datos); $a++) { 
                    if ($datos[$a]['tarea_fecha'] >= $fecha_hoy AND $datos[$a]['tarea_estado'] == 0) {
                        $l_hoy++;
                    }
                    if ($datos[$a]['tarea_fecha'] < $fecha_hoy  AND $datos[$a]['tarea_estado'] == 0) {
                        $l_no_realizada++;
                    }
                    if ($datos[$a]['tarea_estado'] == 1) {
                        $l_cumplida++;
                    }
                }
            }
            // Fin valida las llamadas cunplidas, de hoy y las no realizadas

            $nombre = $asesores[$i]['usuario_nombre'].' '.$asesores[$i]['usuario_apellido'];
            $data['conte'] .= '                
                <div class="card col-xl-12 col-lg-6 col-md-6 col-12  mt-4" id="t-tr">
                        <div class="row tono-3">
                            <div class="col-12 py-3">
                                <div class="row align-items-center">
                                    <div class="pl-4">
                                        <span class="rounded bg-light-green p-2 text-success ">
                                            <i class="fa-solid fa-headset"></i>
                                        </span> 
                                    </div>
                                    <div class="col-10">
                                    <div class="col-8 fs-14 line-height-18"> 
                                        <span class="">'.$nombre.'</span> <br>
                                        <span class="text-semibold fs-16">Rendimiento general</span> 
                                    </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <table class="table table-hover ">
                                <tbody>
                                    <tr id="t-tci">
                                        <td>Citas</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(1,'.$asesores[$i]['id_usuario'].',1)">'.count($datos2).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(1,'.$asesores[$i]['id_usuario'].',2)">'.$c_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(1,'.$asesores[$i]['id_usuario'].',3)">'.$c_hoy.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(1,'.$asesores[$i]['id_usuario'].',4)">'.$c_no_realizada.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(1,'.$asesores[$i]['id_usuario'].',5)">'.count($datos5).'</button></td>
                                    </tr>
                                    <tr id="t-tse" >
                                        <td>Seguimientos</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(2,'.$asesores[$i]['id_usuario'].',1)">'.count($datos3).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(2,'.$asesores[$i]['id_usuario'].',2)">'.$s_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(2,'.$asesores[$i]['id_usuario'].',3)">'.$s_hoy.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(2,'.$asesores[$i]['id_usuario'].',4)">'.$s_no_realizada.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(2,'.$asesores[$i]['id_usuario'].',5)">'.count($datos6).'</button></td>
                                    </tr>
                                    <tr id="t-tlla">
                                        <td>Llamadas</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(3,'.$asesores[$i]['id_usuario'].',1)">'.count($datos).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(3,'.$asesores[$i]['id_usuario'].',2)">'.$l_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(3,'.$asesores[$i]['id_usuario'].',3)">'.$l_hoy.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(3,'.$asesores[$i]['id_usuario'].',4)">'.$l_no_realizada.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(3,'.$asesores[$i]['id_usuario'].',5)">'.count($datos7).'</button></td>
                                    </tr>
                                    <tr id="t-tacuerdos">
                                        <td>Acuerdos de Pago</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(5,'.$asesores[$i]['id_usuario'].',1)">'.count($datos4).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(5,'.$asesores[$i]['id_usuario'].',2)">'.$acuerdos_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(5,'.$asesores[$i]['id_usuario'].',3)">'.$acuerdos_hoy.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(5,'.$asesores[$i]['id_usuario'].',4)">'.$acuerdos_no_realizada.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(5,'.$asesores[$i]['id_usuario'].',5)">'.count($datos8).'</button></td>
                                    </tr>
                                    <tr id="t-tt">
                                        <td>Totales</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(4,'.$asesores[$i]['id_usuario'].',1)">'.$total.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(4,'.$asesores[$i]['id_usuario'].',2)">'.($c_cumplida+$l_cumplida+$s_cumplida).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(4,'.$asesores[$i]['id_usuario'].',3)">'.($c_hoy+$l_hoy+$s_hoy).'</button> </td>
                                        <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(4,'.$asesores[$i]['id_usuario'].',4)">'.($c_no_realizada+$l_no_realizada+$s_no_realizada).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(4,'.$asesores[$i]['id_usuario'].',5)">'.$total_hoy.'</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    
                </div>
            ';
        }
        
        $data['general'] .= $total;
        $data['cumplidas'] .= ($c_cumplida+$l_cumplida+$s_cumplida);
        $data['pendientes'] .= ($c_hoy+$l_hoy+$s_hoy);
        $data['nocumplidas'] .= ($c_no_realizada+$l_no_realizada+$s_no_realizada);
        $data['deldia'] .= $total_hoy;

        echo json_encode($data);

    break;

    case 'consultahoy':
        $fecha_hoy = date("Y-m-d");
        
        $asesores = $consulta->asesores();

        $data['conte'] = '';
        $data['general'] = '';
        $data['cumplidas'] = '';
        $data['pendientes'] = '';
        $data['nocumplidas'] = '';
        $data['deldia'] = '';
        
        for ($i=0; $i < count($asesores); $i++) {

            $datos = $consulta->consulta_datos_dia($asesores[$i]['id_usuario'],'llamada',$fecha_hoy);
            $datos2 = $consulta->consulta_datos_dia($asesores[$i]['id_usuario'],'Cita',$fecha_hoy);
            $datos3 = $consulta->consulta_datos_dia($asesores[$i]['id_usuario'],'seguimiento',$fecha_hoy);



            $total = count($datos)+count($datos2)+count($datos3);

 

            // Inicio valida las citas cunplidas, de hoy y las no realizadas
            $c_cumplida = 0;
            $c_no_realizada = 0;

            if ($datos2) {
                for ($a=0; $a < count($datos2); $a++) { 
                    if ($datos2[$a]['tarea_fecha'] == $fecha_hoy  AND $datos2[$a]['tarea_estado'] == 0 ) {
                        $c_no_realizada++;
                    }
                    if ($datos2[$a]['tarea_estado'] == 0 AND $datos2[$a]['tarea_fecha'] == $fecha_hoy) {
                        $c_cumplida++;
                    }
                }
            }
            // Fin valida las citas cunplidas, de hoy y las no realizadas

            // Inicio valida las seguimientos cunplidas, de hoy y las no realizadas
            $s_cumplida = 0;
            $s_no_realizada = 0;

            if ($datos3) {
                for ($a=0; $a < count($datos3); $a++) { 
                    if ($datos3[$a]['tarea_fecha'] == $fecha_hoy  AND $datos3[$a]['tarea_estado'] == 0) {
                        $s_no_realizada++;
                    }
                    if ($datos3[$a]['tarea_estado'] == 0 AND $datos3[$a]['tarea_fecha'] == $fecha_hoy) {
                        $s_cumplida++;
                    }
                }
            }
            // Fin valida las seguimientos cunplidas, de hoy y las no realizadas

            // Inicio valida las llamadas cunplidas, de hoy y las no realizadas
            $l_cumplida = 0;
            $l_no_realizada = 0;

            if ($datos) {
                for ($a=0; $a < count($datos); $a++) { 

                    if ($datos[$a]['tarea_fecha'] == $fecha_hoy  AND $datos[$a]['tarea_estado'] == 0) {
                        $l_no_realizada++;
                    }
                    if ($datos[$a]['tarea_estado'] == 0 AND $datos[$a]['tarea_fecha'] == $fecha_hoy)  {
                        $l_cumplida++;
                    }
                }
            }
            // Fin valida las llamadas cunplidas, de hoy y las no realizadas

            $nombre = $asesores[$i]['usuario_nombre'].' '.$asesores[$i]['usuario_apellido'];
            $data['conte'] .= '                
                <div class="card col-xl-12 col-lg-6 col-md-6 col-12  mt-4" id="t-tr">
                        <div class="row tono-3">
                            <div class="col-12 py-3">
                                <div class="row align-items-center">
                                    <div class="pl-4">
                                        <span class="rounded bg-light-green p-2 text-success ">
                                            <i class="fa-solid fa-headset"></i>
                                        </span> 
                                    </div>
                                    <div class="col-10">
                                    <div class="col-8 fs-14 line-height-18"> 
                                        <span class="">'.$nombre.'</span> <br>
                                        <span class="text-semibold fs-16">Rendimiento general</span> 
                                    </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <table class="table table-hover ">
                                <tbody>
                                    <tr id="t-tci">
                                        <td>Citas</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(1,'.$asesores[$i]['id_usuario'].',6)">'.count($datos2).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(1,'.$asesores[$i]['id_usuario'].',7)">'.$c_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(1,'.$asesores[$i]['id_usuario'].',8)">'.$c_no_realizada.'</button></td>

                                    </tr>
                                    <tr id="t-tse" >
                                        <td>Seguimientos</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(2,'.$asesores[$i]['id_usuario'].',6)">'.count($datos3).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(2,'.$asesores[$i]['id_usuario'].',7)">'.$s_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(2,'.$asesores[$i]['id_usuario'].',8)">'.$s_no_realizada.'</button></td>

                                    </tr>
                                    <tr id="t-tlla">
                                        <td>Llamadas</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(3,'.$asesores[$i]['id_usuario'].',6)">'.count($datos).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(3,'.$asesores[$i]['id_usuario'].',7)">'.$l_cumplida.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(3,'.$asesores[$i]['id_usuario'].',8)">'.$l_no_realizada.'</button></td>

                                    </tr>   
                                    <tr id="t-tt">
                                        <td>Totales</td>
                                        <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(4,'.$asesores[$i]['id_usuario'].',6)">'.$total.'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(4,'.$asesores[$i]['id_usuario'].',7)">'.($c_cumplida+$l_cumplida+$s_cumplida).'</button></td>
                                        <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(4,'.$asesores[$i]['id_usuario'].',8)">'.($c_no_realizada+$l_no_realizada+$s_no_realizada).'</button></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    
                </div>
            ';
        }
        
        $data['general'] .= $total;
        $data['cumplidas'] .= ($c_cumplida+$l_cumplida+$s_cumplida);
        $data['pendientes'] .= ($c_hoy+$l_hoy+$s_hoy);
        $data['nocumplidas'] .= ($c_no_realizada+$l_no_realizada+$s_no_realizada);
        $data['deldia'] .= $total_hoy;

        echo json_encode($data);

    break;

    case 'buscar':
        $id = $_POST['id'];
        $tipo = $_POST['tipo'];
        $cslt = $_POST['consulta'];
        $fecha_hoy = date("Y-m-d");
        $titulo='';
      

        if ($tipo == "1") {
            $sql = "='Cita'";
            $titulo="Citas";
        }
        if ($tipo == "2") {
            $sql = "='seguimiento'";
            $titulo="Seguimiento";
        }
        if ($tipo == "3") {
            $sql = "='llamada'";
            $titulo="Llamadas";
        }
        if ($tipo == "4") {
            $sql = "!=''";
            $titulo="General";
        }
        if ($tipo == "5") {
            $sql = "='Acuerdo de Pago'";
            $titulo = "Acuerdos de Pago";
        }

        if ($cslt == "1") {
            $sql2 = "";
        }
        if ($cslt == "2") {
            $sql2 = "AND tarea_estado = 1";
        }
        if ($cslt == "3") {
            $sql2 = "AND tarea_fecha >= '$fecha_hoy' AND tarea_estado = 0";
        }
        if ($cslt == "4") {
            $sql2 = "AND tarea_fecha < '$fecha_hoy' AND tarea_estado = 0";
        }
        if ($cslt == "5") {
            $sql2 = "AND tarea_fecha = '$fecha_hoy' AND tarea_estado = 0";  
        }

        if ($cslt == "6") {
            $sql2 = "AND tarea_fecha = '$fecha_hoy'";  
        }

        if ($cslt == "7") {
            $sql2 = "AND tarea_fecha = '$fecha_hoy' AND tarea_estado = 1";  
        }

        if ($cslt == "8") {
            $sql2 = "AND tarea_fecha = '$fecha_hoy' AND tarea_estado = 0";  
        }

        $asesores = $consulta->asesores_todos();

        if($cslt==5){
            $datos = $consulta->buscarhoy($id,$sql,$sql2);
        }else{
            $datos = $consulta->buscar($id,$sql,$sql2);
        }

        
        
        $data['conte'] = '';
        $data['conte'] .= '
        <div class="row">
            <div class="card col-12">
                <div class="row">
                    <div class="col-6 py-4 tono-3">
                           <div class="row align-items-center">
                              <div class="pl-4">
                                 <span class="rounded bg-light-blue p-3 text-primary ">
                                       <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                 </span> 
                              
                              </div>
                              <div class="col-10">
                              <div class="col-5 fs-14 line-height-18"> 
                                 <span class="">Resultados</span> <br>
                                 <span class="text-semibold fs-20">'.$titulo.'</span> 
                              </div> 
                              </div>
                           </div>
                     </div>
                    <div class="col-6 text-right py-4 pr-4 tono-3" >
                        <button id="t2-paso9" class="btn btn-danger" onclick="volver()"><i class="fas fa-arrow-left"></i> Volver</button>
                    </div>
                    <div class="col-12">
                        <table class="table" id="tbl_buscar">
                            <thead>
                            <tr>
                                <th id="t2-paso1">Ref#</th>
                                <th id="t2-paso2">Nombre</th>
                                <th id="t2-paso3">Motivo</th>
                                <th id="t2-paso4">Recordatorio</th>
                                <th id="t2-paso5">Fecha</th>
                                <th id="t2-paso6">Hora</th>
                                <th id="t2-paso7">Asesor</th>
                                <th id="t2-paso8">Seguimiento</th>
                            </tr>
                            </thead>
                            <tbody>';
                            
                            for ($i=0; $i <count($datos); $i++) {
                                $datos_estudia = $consulta->datos_estudiante($datos[$i]['id_credencial']);

                                $nombre_estudiante =  is_array($datos_estudia) ? $datos_estudia["credencial_nombre"].' '.$datos_estudia['credencial_nombre_2'].' '.$datos_estudia['credencial_apellido'].' '.$datos_estudia['credencial_apellido_2']: "nombre";

                        

                                $select  = '';
                                
                                $select .= '<select class="form-control asesor" onchange="cambiarasesor('.$datos[$i]['id_tarea'].',this.value,'.intval($tipo).','.intval($id).','.intval($cslt).')">';
                                    for ($s=0; $s < count($asesores); $s++) {
                                        
                                        if ($asesores[$s]['id_usuario'] == $datos[$i]['id_asesor']) {
                                            $select .= '<option value="'.$asesores[$s]['id_usuario'].'" selected>'.$asesores[$s]['usuario_nombre'].' '.$asesores[$s]['usuario_apellido'].'</option>';
                                            $nombre = $asesores[$s]['usuario_nombre'].' '.$asesores[$s]['usuario_apellido'];
                                        } else {
                                            $select .= '<option value="'.$asesores[$s]['id_usuario'].'">'.$asesores[$s]['usuario_nombre'].' '.$asesores[$s]['usuario_apellido'].'</option>';
                                        }
                                    }
                                $select .= '</select>';

                                $fecha_inut = '';

                                if ($datos[$i]['tarea_fecha'] >= $fecha_hoy AND $datos[$i]['tarea_estado'] == 0 || $datos[$i]['tarea_estado'] == 0) {                    
                                    $fecha_inut = '<input class="form-control" type="date" onchange="cambiarfecha('.$datos[$i]['id_tarea'].',this.value,'.intval($tipo).','.intval($id).','.intval($cslt).')" min="'.$fecha_hoy.'" value="'.$datos[$i]['tarea_fecha'].'">';
                                }else{
                                    @$select = $nombre;
                                    $fecha_inut = $datos[$i]['tarea_fecha'];
                                }
                                $validar_tarea = '';
                                if ($datos[$i]['tarea_fecha'] >= $fecha_hoy  AND $datos[$i]['tarea_estado'] == 0) {
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
                                        <a onclick="agregarTareaSegui('.$datos[$i]['id_credencial'].','.$datos[$i]['id_persona'].')" class="btn btn-success btn-xs" title="Agregar Seguimiento">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        <button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
                                        '.$validar_tarea.'
                                        </td>
                                </tr>';
                            }

                            $data['conte'] .= '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>';

        echo json_encode($data);

    break;

    case 'cambiarasesor':
        $id_tarea = $_POST['id_tarea'];
        $id_asesor = $_POST['id_asesor'];
        $dato = $consulta->consultaTarea($id_tarea);
        $consulta->cambiarasesor($id_tarea,$id_asesor,$dato['id_usuario']);
    break;

    case 'cambiarfecha':
        $id_tarea = $_POST['id_tarea'];
        $fecha = $_POST['fecha'];
        $dato = $consulta->consultaTarea($id_tarea);
        $consulta->cambiarfecha($id_tarea,$fecha,$dato['tarea_fecha']);
    break;

    case 'validarTarea':
        $id_tarea = $_POST['id_tarea'];
        $consulta->validarTarea($id_tarea,$fecha,$hora);
    break;

}

?>