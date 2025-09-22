<?php 
require_once "../modelos/Oncentermistareas.php";
date_default_timezone_set('America/Bogota');
session_start();
$consulta =  new Consulta();

$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$fecha_tarea_tabla = $rsptaperiodo["fecha_tareas"];

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

            $datos = $consulta->consulta_datos($asesores[$i]['id_usuario'],'llamada',$fecha_tarea_tabla);
            $datos2 = $consulta->consulta_datos($asesores[$i]['id_usuario'],'cita',$fecha_tarea_tabla);
            $datos3 = $consulta->consulta_datos($asesores[$i]['id_usuario'],'seguimiento',$fecha_tarea_tabla);

            // consultamos las tareas que hay para el dia de hoy 
            $datos5 = $consulta->consulta_datos_hoy($asesores[$i]['id_usuario'],'cita',$fecha_hoy);
            $datos6 = $consulta->consulta_datos_hoy($asesores[$i]['id_usuario'],'seguimiento',$fecha_hoy);
            $datos7= $consulta->consulta_datos_hoy($asesores[$i]['id_usuario'],'llamada',$fecha_hoy);


            $total = count($datos)+count($datos2)+count($datos3);

            $total_hoy = count($datos5)+count($datos6)+count($datos7);

            // Inicio valida las citas cunplidas, de hoy y las no realizadas
            $c_cumplida = 0;
            $c_hoy = 0;
            $c_no_realizada = 0;

            if ($datos2) {
                for ($a=0; $a < count($datos2); $a++) { 
                    if ($datos2[$a]['fecha_programada'] >= $fecha_hoy AND $datos2[$a]['estado'] == 1) {
                        $c_hoy++;
                    }
                    if ($datos2[$a]['fecha_programada'] < $fecha_hoy  AND $datos2[$a]['estado'] == 1) {
                        $c_no_realizada++;
                    }
                    if ($datos2[$a]['estado'] == 0) {
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
                    if ($datos3[$a]['fecha_programada'] >= $fecha_hoy AND $datos3[$a]['estado'] == 1) {
                        $s_hoy++;
                    }
                    if ($datos3[$a]['fecha_programada'] < $fecha_hoy  AND $datos3[$a]['estado'] == 1) {
                        $s_no_realizada++;
                    }
                    if ($datos3[$a]['estado'] == 0) {
                        $s_cumplida++;
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
                    if ($datos[$a]['fecha_programada'] >= $fecha_hoy AND $datos[$a]['estado'] == 1) {
                        $l_hoy++;
                    }
                    if ($datos[$a]['fecha_programada'] < $fecha_hoy  AND $datos[$a]['estado'] == 1) {
                        $l_no_realizada++;
                    }
                    if ($datos[$a]['estado'] == 0) {
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

            $datos = $consulta->consulta_datos_dia($asesores[$i]['id_usuario'],'llamada',$fecha_tarea_tabla,$fecha_hoy);
            $datos2 = $consulta->consulta_datos_dia($asesores[$i]['id_usuario'],'cita',$fecha_tarea_tabla,$fecha_hoy);
            $datos3 = $consulta->consulta_datos_dia($asesores[$i]['id_usuario'],'seguimiento',$fecha_tarea_tabla,$fecha_hoy);



            $total = count($datos)+count($datos2)+count($datos3);

 

            // Inicio valida las citas cunplidas, de hoy y las no realizadas
            $c_cumplida = 0;
            $c_no_realizada = 0;

            if ($datos2) {
                for ($a=0; $a < count($datos2); $a++) { 
                    if ($datos2[$a]['fecha_programada'] == $fecha_hoy  AND $datos2[$a]['estado'] == 1 ) {
                        $c_no_realizada++;
                    }
                    if ($datos2[$a]['estado'] == 0 AND $datos2[$a]['fecha_programada'] == $fecha_hoy) {
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
                    if ($datos3[$a]['fecha_programada'] == $fecha_hoy  AND $datos3[$a]['estado'] == 1) {
                        $s_no_realizada++;
                    }
                    if ($datos3[$a]['estado'] == 0 AND $datos3[$a]['fecha_programada'] == $fecha_hoy) {
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

                    if ($datos[$a]['fecha_programada'] == $fecha_hoy  AND $datos[$a]['estado'] == 1) {
                        $l_no_realizada++;
                    }
                    if ($datos[$a]['estado'] == 0 AND $datos3[$a]['fecha_programada'] == $fecha_hoy)  {
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
            $sql = "='cita'";
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

        if ($cslt == "1") {
            $sql2 = "";
        }
        if ($cslt == "2") {
            $sql2 = "AND estado = 0";
        }
        if ($cslt == "3") {
            $sql2 = "AND fecha_programada >= '$fecha_hoy' AND estado = 1";
        }
        if ($cslt == "4") {
            $sql2 = "AND fecha_programada < '$fecha_hoy' AND estado = 1";
        }
        if ($cslt == "5") {
            $sql2 = "AND fecha_programada = '$fecha_hoy' AND estado = 1";  
        }

        if ($cslt == "6") {
            $sql2 = "AND fecha_programada = '$fecha_hoy'";  
        }

        if ($cslt == "7") {
            $sql2 = "AND fecha_programada = '$fecha_hoy' AND estado = 0";  
        }

        if ($cslt == "8") {
            $sql2 = "AND fecha_programada = '$fecha_hoy' AND estado = 1";  
        }

        $asesores = $consulta->asesores_todos();

        if($cslt==5){
            $datos = $consulta->buscarhoy($id,$sql,$sql2);
        }else{
            $datos = $consulta->buscar($id,$sql,$sql2,$periodo_actual);
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
                                <th id="t2-paso1">Etiqueta</th>
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

                            $etiquetas = $consulta->etiquetas();

                            
                            
                            for ($i=0; $i <count($datos); $i++) {
                                $datos_estudia = $consulta->datos_estudiante($datos[$i]['id_estudiante']);

                                $nombre_estudiante =  is_array($datos_estudia) ? $datos_estudia["nombre"].' '.$datos_estudia['nombre_2'].' '.$datos_estudia['apellidos'].' '.$datos_estudia['apellidos_2']: "nombre";

                                
                                
                                // $datos_estudia['nombre'].' '.$datos_estudia['nombre_2'].' '.$datos_estudia['apellidos'].' '.$datos_estudia['apellidos_2'];

                                $select  = '';
                                
                                $select .= '<select class="form-control asesor" onchange="cambiarasesor('.$datos[$i]['id_tarea'].',this.value,'.intval($tipo).','.intval($id).','.intval($cslt).')">';
                                    for ($s=0; $s < count($asesores); $s++) {
                                        
                                        if ($asesores[$s]['id_usuario'] == $datos[$i]['id_usuario']) {
                                            $select .= '<option value="'.$asesores[$s]['id_usuario'].'" selected>'.$asesores[$s]['usuario_nombre'].' '.$asesores[$s]['usuario_apellido'].'</option>';
                                            $nombre = $asesores[$s]['usuario_nombre'].' '.$asesores[$s]['usuario_apellido'];
                                        } else {
                                            $select .= '<option value="'.$asesores[$s]['id_usuario'].'">'.$asesores[$s]['usuario_nombre'].' '.$asesores[$s]['usuario_apellido'].'</option>';
                                        }
                                    }
                                $select .= '</select>';

                                $selecte  = '';
		
                                $selecte .= '<select class="form-control asesor" onchange="cambiarEtiqueta('.$datos[$i]["id_estudiante"].',this.value)" style="height:auto;font-size:12px">';
                                    for ($s=0; $s < count($etiquetas); $s++) {
                                        
                                        if ($etiquetas[$s]['id_etiquetas'] == $datos_estudia["id_etiqueta"]) {
                                            $selecte .= '<option value="'.$etiquetas[$s]['id_etiquetas'].'" selected>'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
                                        } else {
                                            $selecte .='<option value="'.$etiquetas[$s]['id_etiquetas'].'">'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
                                        }
                                    }
                                $selecte .= '</select>';


                                $fecha_inut = '';

                                if ($datos[$i]['fecha_programada'] >= $fecha_hoy AND $datos[$i]['estado'] == 1 || $datos[$i]['estado'] == 1) {                    
                                    $fecha_inut = '<input class="form-control" type="date" onchange="cambiarfecha('.$datos[$i]['id_tarea'].',this.value,'.intval($tipo).','.intval($id).','.intval($cslt).')" min="'.$fecha_hoy.'" value="'.$datos[$i]['fecha_programada'].'">';
                                }else{
                                    @$select = $nombre;
                                    $fecha_inut = $datos[$i]['fecha_programada'];
                                }
                                $validar_tarea = '';
                                if ($datos[$i]['fecha_programada'] >= $fecha_hoy  AND $datos[$i]['estado'] == 1) {
                                    $validar_tarea = '<a onclick="validarTarea('.$id.','.$tipo.','.$cslt.','.$datos[$i]['id_tarea'].')" class="btn btn-warning btn-xs" title="Tarea realizada"><i class="fas fa-check"></i></a>';
                                }

                                if (isset($datos_estudia["celular"])) {
                                    $estilo_whatsapp = 'btn-success';
                                    $numero_celular = $datos_estudia["celular"];
                                } else {
                                    $estilo_whatsapp = 'btn-danger disabled';
                                    $numero_celular = '';
                                }

                                $fecha_obj = new DateTime($datos[$i]['hora_programada']);
                                $formato_12_horas = $fecha_obj->format('g:i A');

                                $data['conte'] .= '
                                <tr>
                                    
                                    <td>'.$datos[$i]['id_tarea'].'</td>
                                    <td><div style="width:200px">'.$selecte.'</div></td>
                                    <td>'.$nombre_estudiante.'</td>
                                    <td>'.$datos[$i]['motivo_tarea'].'</td>
                                    <td>'.$datos[$i]['mensaje_tarea'].'</td>
                                    <td>'.$fecha_inut.'</td>
                                    <td><div style="width:100px">'.$formato_12_horas.'</div></td>
                                    <td>'.$select.'</td>
                                    <td>    
                                        <a onclick="verHistorial('.$datos[$i]['id_estudiante'].')" class="btn btn-primary btn-xs" title="Ver General">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a onclick="agregar('.$datos[$i]['id_estudiante'].')" class="btn btn-success btn-xs" title="Agregar Seguimiento">
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
        $consulta->cambiarfecha($id_tarea,$fecha,$dato['fecha_programada']);
    break;

    // inicio agregar tareas, seguimientos y ver historial

    case 'verHistorialTabla':
		$id_estudiante=$_GET["id_estudiante"];
	
		$rspta=$consulta->verHistorialTabla($id_estudiante);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			$datoasesor=$consulta->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
 			$data[]=array(
 				"0"=>$reg[$i]["id_estudiante"],
				"1"=>$reg[$i]["motivo_seguimiento"],
				"2"=>$reg[$i]["mensaje_seguimiento"],
 				"3"=>$consulta->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],			
 				"4"=>$nombre_usuario
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
		
	case 'verHistorialTablaTareas':
		$id_estudiante=$_GET["id_estudiante"];
	
		$rspta=$consulta->verHistorialTablaTareas($id_estudiante);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			$datoasesor=$consulta->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
			
			$data[]=array(
				"0"=>($reg[$i]["estado"]==1)?'Pendiente':'Realizada',
				"1"=>$reg[$i]["motivo_tarea"],
				"2"=>$reg[$i]["mensaje_tarea"],
				"3"=>$consulta->fechaesp($reg[$i]["fecha_programada"]) .' a las '. $reg[$i]["hora_programada"],		
				"4"=>$nombre_usuario

				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

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
        $fecha=date('Y-m-d');
        $periodo_actual=$_SESSION['periodo_actual'];
        $hora=date('H:i:s');
        $id_usuario=$_SESSION['id_usuario'];
        $id_estudiante_tarea=isset($_POST["id_estudiante_tarea"])? limpiarCadena($_POST["id_estudiante_tarea"]):"";
        $motivo_tarea=isset($_POST["motivo_tarea"])? limpiarCadena($_POST["motivo_tarea"]):"";
        $mensaje_tarea=isset($_POST["mensaje_tarea"])? limpiarCadena($_POST["mensaje_tarea"]):"";
        $fecha_programada=isset($_POST["fecha_programada"])? limpiarCadena($_POST["fecha_programada"]):"";
        $hora_programada=isset($_POST["hora_programada"])? limpiarCadena($_POST["hora_programada"]):"";
		$rspta=$consulta->insertarTarea($id_usuario,$id_estudiante_tarea,$motivo_tarea,$mensaje_tarea,$fecha,$hora,$fecha_programada,$hora_programada,$periodo_actual);
        echo $rspta ? "Tarea Programada" : "Tarea no se pudo Programar";
    break;

    case 'agregar':
		$id_estudiante=$_POST["id_estudiante"];
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		
		$consulta1=$consulta->verHistorial($id_estudiante);// consulta para traer los interesados

 		
		$nombre=$consulta1["nombre"];
		$nombre_2=$consulta1["nombre_2"];
		$apellidos=$consulta1["apellidos"];
		$apellidos_2=$consulta1["apellidos_2"];
		$programa=$consulta1["fo_programa"];
		$jornada=$consulta1["jornada_e"];
		$celular=$consulta1["celular"];
		$email=$consulta1["email"];
		$periodo_ingreso=$consulta1["periodo_ingreso"];
		$fecha_ingreso=$consulta1["fecha_ingreso"];
		$hora_ingreso=$consulta1["hora_ingreso"];
		$medio=$consulta1["medio"];
		$conocio=$consulta1["conocio"];
		$contacto=$consulta1["contacto"];
		$modalidad=$consulta1["nombre_modalidad"];
		$estado=$consulta1["estado"];
		$periodo_campana=$consulta1["periodo_campana"];

		$nivel_escolaridad=$consulta1["nivel_escolaridad"];
		$nombre_colegio=$consulta1["nombre_colegio"];
		$fecha_graduacion=$consulta1["fecha_graduacion"];
		$jornada_academico=$consulta1["jornada_academico"];
		$departamento_academico=$consulta1["departamento_academico"];
		$municipio_academico=$consulta1["municipio_academico"];
		$codigo_pruebas=$consulta1["codigo_pruebas"];
		$codigo_saber_pro=$consulta1["codigo_saber_pro"];
		$colegio_articulacion=$consulta1["colegio_articulacion"];
		$grado_articulacion=$consulta1["grado_articulacion"];

        $data["0"] .= '

            <div class="row">
            
                <div class="col-12" id="accordion">
                    <div class="card-header tono-4">
                        <h4 class="card-title w-100">
                        <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                            <i class="fa-regular fa-address-card bg-light-blue text-primary p-2"></i>
                            Datos de Contacto
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="collapse in" data-parent="#accordion" style="">
                        <div class="card-body tono-3">
                            <div class="row">
                                <div class="col-xl-6">
                                    <dt>Nombre</dt>
                                    <dd>'. $nombre . ' ' . $nombre_2 . ' ' . $apellidos . ' ' . $apellidos_2 . '</dd>
                                    <dt>Programa</dt>
                                    <dd>'.$programa.'</dd>
                                    <dt>Celular</dt>
                                    <dd>'.$celular.'</dd>
                                    <dt>Email</dt>
                                    <dd>'.$email.'</dd>
                                    <dt>Fecha de Ingreso</dt>
                                    <dd>'.$consulta->fechaesp($fecha_ingreso).' a las '.$hora_ingreso.' del '.$periodo_ingreso.'</dd>
                                    <dt>Medio</dt>
                                    <dd>'.$medio.'</dd>
                                </div>
                                    <div class="col-xl-6">							
                                    <dt>Conocio</dt>
                                    <dd>'.$conocio.'</dd>
                                    <dt>Contacto</dt>
                                    <dd>'.$contacto.'</dd>
                                    <dt>Modalidad</dt>
                                    <dd>'.$modalidad.'</dd>
                                    <dt>Estado</dt>
                                    <dd>'.$estado.'</dd>
                                    <dt>Campaña</dt>
                                    <dd>'.$periodo_campana.'</dd>
                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-header tono-4">
                        <h4 class="card-title w-100">
                        <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseTwo">
                            <i class="fa-solid fa-school bg-light-blue p-2 text-primary"></i>
                            Datos Academicos
                        </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        <div class="card-body tono-3">

                            <div class="row">
                                <div class="col-xl-6">
                                    <dl class="dl-horizontal">
                                        <dt>Nivel de Escolaridad</dt>
                                        <dd>'. $nivel_escolaridad . '</dd>
                                        <dt>Nombre Colegio</dt>
                                        <dd>'.$nombre_colegio.'</dd>
                                        <dt>Fecha Graduacion</dt>
                                        <dd>'.$fecha_graduacion.'</dd>
                                        <dt>Jornada Academico</dt>
                                        <dd>'.$jornada_academico.'</dd>
                                        <dt>Departamento Academico</dt>
                                        <dd>'.$departamento_academico.'</dd>
                                        <dt>Municipio Academico</dt>
                                        <dd>'.$municipio_academico.'</dd>
                                    </dl>
                                </div>
                                <div class="col-xl-6">
                                    </dl>
                                        <dt>Codigo Pruebas</dt>
                                        <dd>'.$codigo_pruebas.'</dd>
                                        <dt>Codigo Saber Pro</dt>
                                        <dd>'.$codigo_saber_pro.'</dd>
                                        <dt>Colegio Articulacion</dt>
                                        <dd>'.$colegio_articulacion.'</dd>
                                        <dt>Grado Articulacion</dt>
                                        <dd>'.$grado_articulacion.'</dd>
                                        <dt>Campaña</dt>
                                        <dd>'.$periodo_campana.'</dd>
                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        
        ';
		$results = array($data);
 		echo json_encode($results);
    break;
    
    case 'verHistorial':
		$id_estudiante=$_POST["id_estudiante"];
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		
		$consulta1=$consulta->verHistorial($id_estudiante);// consulta para traer los interesados

 		
		$nombre=$consulta1["nombre"];
		$nombre_2=$consulta1["nombre_2"];
		$apellidos=$consulta1["apellidos"];
		$apellidos_2=$consulta1["apellidos_2"];
		$programa=$consulta1["fo_programa"];
		$jornada=$consulta1["jornada_e"];
		$celular=$consulta1["celular"];
		$email=$consulta1["email"];
		$periodo_ingreso=$consulta1["periodo_ingreso"];
		$fecha_ingreso=$consulta1["fecha_ingreso"];
		$hora_ingreso=$consulta1["hora_ingreso"];
		$medio=$consulta1["medio"];
		$conocio=$consulta1["conocio"];
		$contacto=$consulta1["contacto"];
		$modalidad=$consulta1["nombre_modalidad"];
		$estado=$consulta1["estado"];
		$periodo_campana=$consulta1["periodo_campana"];

		$nivel_escolaridad=$consulta1["nivel_escolaridad"];
		$nombre_colegio=$consulta1["nombre_colegio"];
		$fecha_graduacion=$consulta1["fecha_graduacion"];
		$jornada_academico=$consulta1["jornada_academico"];
		$departamento_academico=$consulta1["departamento_academico"];
		$municipio_academico=$consulta1["municipio_academico"];
		$codigo_pruebas=$consulta1["codigo_pruebas"];
		$codigo_saber_pro=$consulta1["codigo_saber_pro"];
		$colegio_articulacion=$consulta1["colegio_articulacion"];
		$grado_articulacion=$consulta1["grado_articulacion"];
        
        $ref_familiar=$consulta1["ref_familiar"];
		$ref_telefono=$consulta1["ref_telefono"];
			
		$data["0"] .= '

            <div class="row">
           
                <div class="col-12" id="accordion">
                    <div class="card-header tono-4">
                        <h4 class="card-title w-100">
                        <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                            <i class="fa-regular fa-address-card bg-light-blue text-primary p-2"></i>
                            Datos de Contacto
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="collapse in" data-parent="#accordion" style="">
                        <div class="card-body tono-3">

                            <div class="row">
                                <div class="col-xl-6">
                                    <dt>Nombre</dt>
                                    <dd>'. $nombre . ' ' . $nombre_2 . ' ' . $apellidos . ' ' . $apellidos_2 . '</dd>
                                    <dt>Programa</dt>
                                    <dd>'.$programa.'</dd>
                                    <dt>Celular</dt>
                                    <dd>'.$celular.'</dd>
                                    <dt>Email</dt>
                                    <dd>'.$email.'</dd>
                                    <dt>Fecha de Ingreso</dt>
                                    <dd>'.$consulta->fechaesp($fecha_ingreso).' a las '.$hora_ingreso.' del '.$periodo_ingreso.'</dd>
                                    <dt>Medio</dt>
                                    <dd>'.$medio.'</dd>
                                </div>
                                    <div class="col-xl-6">							
                                    <dt>Conocio</dt>
                                    <dd>'.$conocio.'</dd>
                                    <dt>Contacto</dt>
                                    <dd>'.$contacto.'</dd>
                                    <dt>Modalidad</dt>
                                    <dd>'.$modalidad.'</dd>
                                    <dt>Estado</dt>
                                    <dd>'.$estado.'</dd>
                                    <dt>Campaña</dt>
                                    <dd>'.$periodo_campana.'</dd>
                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-header tono-4">
                        <h4 class="card-title w-100">
                        <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseTwo">
                            <i class="fa-solid fa-school bg-light-blue p-2 text-primary"></i>
                            Datos Academicos
                        </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        <div class="card-body tono-3">

                            <div class="row">
                                <div class="col-xl-6">
                                    <dl class="dl-horizontal">
                                        <dt>Nivel de Escolaridad</dt>
                                        <dd>'. $nivel_escolaridad . '</dd>
                                        <dt>Nombre Colegio</dt>
                                        <dd>'.$nombre_colegio.'</dd>
                                        <dt>Fecha Graduacion</dt>
                                        <dd>'.$fecha_graduacion.'</dd>
                                        <dt>Jornada Academico</dt>
                                        <dd>'.$jornada_academico.'</dd>
                                        <dt>Departamento Academico</dt>
                                        <dd>'.$departamento_academico.'</dd>
                                        <dt>Municipio Academico</dt>
                                        <dd>'.$municipio_academico.'</dd>
                                    </dl>
                                </div>
                                <div class="col-xl-6">
                                    </dl>
                                        <dt>Codigo Pruebas</dt>
                                        <dd>'.$codigo_pruebas.'</dd>
                                        <dt>Codigo Saber Pro</dt>
                                        <dd>'.$codigo_saber_pro.'</dd>
                                        <dt>Colegio Articulacion</dt>
                                        <dd>'.$colegio_articulacion.'</dd>
                                        <dt>Grado Articulacion</dt>
                                        <dd>'.$grado_articulacion.'</dd>
                                        <dt>Campaña</dt>
                                        <dd>'.$periodo_campana.'</dd>
                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
           
            </div>
        ';
		$results = array($data);
 		echo json_encode($results);
    break;

    // fin agregar tareas, seguimientos y ver historial

    case 'validarTarea':
        $id_tarea = $_POST['id_tarea'];
        $fecha=date('Y-m-d');
        $hora=date('H:i:s');
        $consulta->validarTarea($id_tarea,$hora,$fecha);
    break;

    case 'cambiarEtiqueta':
        
        $id_estudiante = $_POST['id_estudiante'];
        $valor = $_POST['valor'];

        $rspta = $consulta->cambiarEtiqueta($id_estudiante,$valor);

        if ($rspta == 0) {
			echo "1";
		} else {

			echo "0";
		}

    break;

}

?>