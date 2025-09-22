<?php
require_once "../modelos/EgresadosTareas.php";
date_default_timezone_set('America/Bogota');
session_start();
$fecha_hoy = date("Y-m-d");
$egresadistareas =  new EgresadosTareas();

$id_egresdado_est = isset($_POST["id_egresdado_est"]) ? limpiarCadena($_POST["id_egresdado_est"]) : "";
$id_reingreso_estado = isset($_POST["id_reingreso_estado"]) ? limpiarCadena($_POST["id_reingreso_estado"]) : "";

$nombre_estado = isset($_POST["nombre_estado"]) ? limpiarCadena($_POST["nombre_estado"]) : "";


switch ($_GET['op']) {
    case 'consulta':

        $asesores = $egresadistareas->asesores();

        $data['conte'] = '';
        $data['conte'] .= '
            <div class="row d-flex justify-content-center py-3">
                <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                    <div class="row justify-content-center">
                        <div class="col-12 hidden">
                            <div class="row align-items-center">
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
                            <div class="row align-items-center">
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
                            <div class="row align-items-center">
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
                                <div class="small">Pendientes <span class="text-green"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                    <div class="row justify-content-center">
                        <div class="col-12 hidden">
                            <div class="row align-items-center">
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
                <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2" onclick="vizualizartareashoy()">
                    <div class="row justify-content-center">
                        <div class="col-12 hidden">
                            <div class="row align-items-center">
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
                                <div class="small">Tareas de Hoy<span class="text-green"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> ';

        for ($i = 0; $i < count($asesores); $i++) {

            // ver las tareas en general
            $datos = $egresadistareas->consulta_datos($asesores[$i]['id_usuario'], 'llamada');
            $datos2 = $egresadistareas->consulta_datos($asesores[$i]['id_usuario'], 'cita');
            $datos3 = $egresadistareas->consulta_datos($asesores[$i]['id_usuario'], 'seguimiento');

            // consultamos las tareas que hay para el dia de hoy 
            $datos5 = $egresadistareas->consulta_datos_hoy($asesores[$i]['id_usuario'], 'cita', $fecha_hoy);


            $datos6 = $egresadistareas->consulta_datos_hoy($asesores[$i]['id_usuario'], 'seguimiento', $fecha_hoy);
            $datos7 = $egresadistareas->consulta_datos_hoy($asesores[$i]['id_usuario'], 'llamada', $fecha_hoy);

            $total = count($datos) + count($datos2) + count($datos3);

            $total_hoy = count($datos5) + count($datos6) + count($datos7);


            // Inicio valida las citas cunplidas, de hoy y las no realizadas
            $c_cumplida = 0;
            $c_hoy = 0;
            $c_no_realizada = 0;

            if ($datos2) {
                for ($a = 0; $a < count($datos2); $a++) {
                    if ($datos2[$a]['fecha_programada'] >= $fecha_hoy and $datos2[$a]['estado'] == 1) {
                        $c_hoy++;
                    }
                    if ($datos2[$a]['fecha_programada'] < $fecha_hoy  and $datos2[$a]['estado'] == 1) {
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
                for ($a = 0; $a < count($datos3); $a++) {
                    if ($datos3[$a]['fecha_programada'] >= $fecha_hoy and $datos3[$a]['estado'] == 1) {
                        $s_hoy++;
                    }
                    if ($datos3[$a]['fecha_programada'] < $fecha_hoy  and $datos3[$a]['estado'] == 1) {
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
                for ($a = 0; $a < count($datos); $a++) {
                    if ($datos[$a]['fecha_programada'] >= $fecha_hoy and $datos[$a]['estado'] == 1) {
                        $l_hoy++;
                    }
                    if ($datos[$a]['fecha_programada'] < $fecha_hoy  and $datos[$a]['estado'] == 1) {
                        $l_no_realizada++;
                    }
                    if ($datos[$a]['estado'] == 0) {
                        $l_cumplida++;
                    }
                }
            }

            // Fin valida las llamadas cunplidas, de hoy y las no realizadas
            $nombre = $asesores[$i]['usuario_nombre'] . ' ' . $asesores[$i]['usuario_apellido'];
            $data['conte'] .= '    
                    <div class="card col-xl-4 col-lg-6 col-md-6 col-12 mb-4 mt-1 p-2">
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
                                        <span class="">' . $asesores[$i]['usuario_cargo'] . '</span> <br>
                                        <span class="text-semibold fs-16">' . $nombre . '</span> 
                                    </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover ">
                                    <tbody>
                                        <tr>
                                            <td>Citas</td>
                                            <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(1,' . $asesores[$i]['id_usuario'] . ',1)">' . count($datos2) . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(1,' . $asesores[$i]['id_usuario'] . ',2)">' . $c_cumplida . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(1,' . $asesores[$i]['id_usuario'] . ',3)">' . $c_hoy . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(1,' . $asesores[$i]['id_usuario'] . ',4)">' . $c_no_realizada . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(1,' . $asesores[$i]['id_usuario'] . ',5)">' . count($datos5) . '</button></td>
                                        </tr>
                                        <tr>
                                            <td>Seguimientos</td>
                                            <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(2,' . $asesores[$i]['id_usuario'] . ',1)">' . count($datos3) . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(2,' . $asesores[$i]['id_usuario'] . ',2)">' . $s_cumplida . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(2,' . $asesores[$i]['id_usuario'] . ',3)">' . $s_hoy . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(2,' . $asesores[$i]['id_usuario'] . ',4)">' . $s_no_realizada . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(2,' . $asesores[$i]['id_usuario'] . ',5)">' . count($datos6) . '</button></td>
                                        </tr>
                                        <tr>
                                            <td>Llamadas</td>
                                            <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(3,' . $asesores[$i]['id_usuario'] . ',1)">' . count($datos) . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(3,' . $asesores[$i]['id_usuario'] . ',2)">' . $l_cumplida . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(3,' . $asesores[$i]['id_usuario'] . ',3)">' . $l_hoy . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(3,' . $asesores[$i]['id_usuario'] . ',4)">' . $l_no_realizada . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(3,' . $asesores[$i]['id_usuario'] . ',5)">' . count($datos7) . '</button></td>
                                        </tr>


                                        <tr>
                                            <td>Totales</td>
                                            <td><button class="btn btn-sm btn-flat btn-default" onclick="buscar(4,' . $asesores[$i]['id_usuario'] . ',1)">' . $total . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-success" onclick="buscar(4,' . $asesores[$i]['id_usuario'] . ',2)">' . ($c_cumplida + $l_cumplida + $s_cumplida) . '</button></td>
                                            <td><button class="btn btn-sm btn-flat btn-warning" onclick="buscar(4,' . $asesores[$i]['id_usuario'] . ',3)">' . ($c_hoy + $l_hoy + $s_hoy) . '</button> </td>
                                            <td><button class="btn btn-sm btn-flat btn-danger"  onclick="buscar(4,' . $asesores[$i]['id_usuario'] . ',4)">' . ($c_no_realizada + $l_no_realizada + $s_no_realizada) . '</button></td>

                                            <td><button class="btn btn-sm btn-flat btn-primary"  onclick="buscar(4,' . $asesores[$i]['id_usuario'] . ',5)">' . $total_hoy . '</button></td>

                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                ';
        }

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
            $sql = "='Seguimiento'";
        }
        if ($tipo == "3") {
            $sql = "='Llamada'";
        }

        if ($tipo == "4") {
            $sql = "!=''";
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

        $asesores = $egresadistareas->asesores_todos();

        $datos = $egresadistareas->buscar($id, $sql, $sql2);

        // print_r($datos);        
        $data['conte'] = '';
        $data['conte'] .= '
        <div class="col-md-12" style="margin:10px;">
            <button class="btn btn-danger float-right" onclick="volver()"><i class="fas fa-arrow-left"></i> Volver</button>
        </div>
        <table class="table table-striped" id="tbl_buscar">
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
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>';




        for ($i = 0; $i < count($datos); $i++) {
            $datos_estudia = $egresadistareas->datos_estudiante($datos[$i]['id_credencial']);


            $nombre_estudiante = $datos_estudia['credencial_nombre'] . ' ' . $datos_estudia['credencial_nombre_2'] . ' ' . $datos_estudia['credencial_apellido'] . ' ' . $datos_estudia['credencial_apellido_2'];



            $select  = '';

            $select .= '<select class="form-control asesor" onchange="cambiarasesor(' . $datos[$i]['id_tarea'] . ',this.value,' . intval($tipo) . ',' . intval($id) . ',' . intval($cslt) . ')">';
            $nombre = 0;

            $id_credencial_estado = $datos[$i]['id_credencial'];

            $consulta_estado = $egresadistareas->mostrar_estados($id_credencial_estado);
            $mostrar_estado = "Sin estado";
            for ($e = 0; $e < count($consulta_estado); $e++) {

                $mostrar_estado = $consulta_estado[$e]["nombre_estado"];
            }

            for ($s = 0; $s < count($asesores); $s++) {
                $nombre = $asesores[$s]['usuario_nombre'] . ' ' . $asesores[$s]['usuario_apellido'];
                if ($asesores[$s]['id_usuario'] == $datos[$i]['id_usuario']) {
                    $select .= '<option value="' . $asesores[$s]['id_usuario'] . '" selected>' . $asesores[$s]['usuario_nombre'] . ' ' . $asesores[$s]['usuario_apellido'] . '</option>';
                    $nombre = $asesores[$s]['usuario_nombre'] . ' ' . $asesores[$s]['usuario_apellido'];
                } else {
                    $select .= '<option value="' . $asesores[$s]['id_usuario'] . '">' . $asesores[$s]['usuario_nombre'] . ' ' . $asesores[$s]['usuario_apellido'] . '</option>';
                }
            }
            $select .= '</select>';

            $fecha_inut = '';


            if ($datos[$i]['fecha_programada'] >= $fecha_hoy and $datos[$i]['estado'] == 1 || $datos[$i]['estado'] == 1) {
                $fecha_inut = '<input class="form-control" type="date" onchange="cambiarfecha(' . $datos[$i]['id_tarea'] . ',this.value,' . intval($tipo) . ',' . intval($id) . ',' . intval($cslt) . ')" min="' . $fecha_hoy . '" value="' . $datos[$i]['fecha_programada'] . '">';
            } else {
                $select = $nombre;
                $fecha_inut = $datos[$i]['fecha_programada'];
            }
            $validar_tarea = '';
            if ($datos[$i]['fecha_programada'] >= $fecha_hoy  and $datos[$i]['estado'] == 1) {
                $validar_tarea = '<a onclick="validarTarea(' . $id . ',' . $tipo . ',' . $cslt . ',' . $datos[$i]['id_tarea'] . ')" class="btn btn-warning btn-xs" title="Tarea realizada"><i class="fas fa-check"></i></a>';
            }

            $data['conte'] .= '
                <tr>
                    <td>' . $datos[$i]['id_tarea'] . '</td>
                    <td>' . $nombre_estudiante . '</td>
                    <td>' . $datos[$i]['motivo_tarea'] . '</td>
                    <td>' . $datos[$i]['mensaje_tarea'] . '</td>
                    <td>' . $fecha_inut . '</td>
                    <td>' . $datos[$i]['hora_programada'] . '</td>
                    <td>' . $select . '</td>
                    <td><a onclick="verHistorial(' . $datos[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a><a onclick="agregar(' . $datos[$i]['id_credencial'] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>' . $validar_tarea . '</td>
                    <td ></span></div><div><button class=" btn-sm float-right btn btn-warning btn-xs ml-auto " onclick="mostrar_reingreso(' . $id_credencial_estado . ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button></div><div><span class="badge badge-primary p-1 mt-3 ">' . $mostrar_estado . '</td>
                </tr>';
        }

        $data['conte'] .= '</tbody></table>';

        echo json_encode($data);

        break;



    case 'cambiarasesor':
        $id_tarea = $_POST['id_tarea'];
        $id_asesor = $_POST['id_asesor'];
        $dato = $egresadistareas->consultaTarea($id_tarea);
        $egresadistareas->cambiarasesor($id_tarea, $id_asesor, $dato['id_usuario']);
        break;

    case 'cambiarfecha':
        $id_tarea = $_POST['id_tarea'];
        $fecha = $_POST['fecha'];
        $dato = $egresadistareas->consultaTarea($id_tarea);
        $egresadistareas->cambiarfecha($id_tarea, $fecha, $dato['fecha_programada']);
        break;

        // inicio agregar tareas, seguimientos y ver historial

    case 'verHistorialTabla':
        $id_credencial = $_GET["id_credencial"];

        $rspta = $egresadistareas->verHistorialTabla($id_credencial);
        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {
            $datoasesor = $egresadistareas->datosAsesor($reg[$i]["id_usuario"]);
            $nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];
            $data[] = array(
                "0" => $reg[$i]["id_credencial"],
                "1" => $reg[$i]["motivo_seguimiento"],
                "2" => $reg[$i]["mensaje_seguimiento"],
                "3" => $egresadistareas->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],
                "4" => $nombre_usuario

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

    case 'verHistorialTablaTareas':
        $id_credencial = $_GET["id_credencial"];

        $rspta = $egresadistareas->verHistorialTablaTareas($id_credencial);
        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {
            $datoasesor = $egresadistareas->datosAsesor($reg[$i]["id_usuario"]);
            $nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];

            $data[] = array(
                "0" => ($reg[$i]["estado"] == 1) ? 'Pendiente' : 'Realizada',
                "1" => $reg[$i]["motivo_tarea"],
                "2" => $reg[$i]["mensaje_tarea"],
                "3" => $egresadistareas->fechaesp($reg[$i]["fecha_programada"]) . ' a las ' . $reg[$i]["hora_programada"],
                "4" => $nombre_usuario

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

    case 'agregarSeguimiento':

        $id_usuario = $_SESSION['id_usuario'];
        $id_credencial_agregar = isset($_POST["id_credencial_agregar"]) ? limpiarCadena($_POST["id_credencial_agregar"]) : "";
        $motivo_seguimiento = isset($_POST["motivo_seguimiento"]) ? limpiarCadena($_POST["motivo_seguimiento"]) : "";
        $mensaje_seguimiento = isset($_POST["mensaje_seguimiento"]) ? limpiarCadena($_POST["mensaje_seguimiento"]) : "";
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');

        $rspta = $egresadistareas->vernombreestudiantesinactivos($id_credencial_agregar);
        $id_credencial_programa = 0;
        for ($a = 0; $a < count($rspta); $a++) {
            $id_credencial_programa = $rspta[$a]["id_credencial"];
        }
        $rspta = $egresadistareas->insertarSeguimiento($id_usuario, $id_credencial_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $id_credencial_programa);
        echo $rspta ? "Seguimiento registrado" : "Seguimiento no se pudo registrar";
        break;


    case 'agregarTarea':
        $fecha_realizo = NULL;
        $hora_realizo = NULL;
        $fecha = date('Y-m-d');
        $periodo_actual = $_SESSION['periodo_actual'];
        $hora = date('H:i:s');
        $id_usuario = $_SESSION['id_usuario'];
        $id_credencial_tarea = isset($_POST["id_credencial_tarea"]) ? limpiarCadena($_POST["id_credencial_tarea"]) : "";
        $motivo_tarea = isset($_POST["motivo_tarea"]) ? limpiarCadena($_POST["motivo_tarea"]) : "";
        $mensaje_tarea = isset($_POST["mensaje_tarea"]) ? limpiarCadena($_POST["mensaje_tarea"]) : "";
        $fecha_programada = isset($_POST["fecha_programada"]) ? limpiarCadena($_POST["fecha_programada"]) : "";
        $hora_programada = isset($_POST["hora_programada"]) ? limpiarCadena($_POST["hora_programada"]) : "";

        $rspta = $egresadistareas->vernombreestudiantesinactivos($id_credencial_tarea);
        $id_credencial_programa = 0;
        for ($a = 0; $a < count($rspta); $a++) {
            $id_credencial_programa = $rspta[$a]["id_credencial"];
        }


        $rspta = $egresadistareas->insertarTarea($id_usuario, $id_credencial_tarea, $motivo_tarea, $mensaje_tarea, $fecha, $hora, $fecha_programada, $hora_programada, $fecha_realizo, $hora_realizo, $periodo_actual, $id_credencial_programa);
        echo $rspta ? "Tarea Programada" : "Tarea no se pudo Programar";
        break;

    case 'agregar':
        $id_credencial = $_POST["id_credencial"];
        $data = array(); //Vamos a declarar un array
        $data["0"] = ""; //iniciamos el arreglo

        $egresadistareas1 = $egresadistareas->datos_estudiante($id_credencial); // consulta para traer los interesados
        $nombre = $egresadistareas1["credencial_nombre"] . " " . $egresadistareas1["credencial_nombre_2"] . " " . $egresadistareas1["credencial_apellido"] . " " . $egresadistareas1["credencial_apellido_2"];
        $credencial_login = $egresadistareas1["credencial_login"];
        $programa = $egresadistareas1["fo_programa"];
        $celular = $egresadistareas1["celular"];
        $credencial_fecha = $egresadistareas1["credencial_fecha"];
        $codigo_pruebas = $egresadistareas1["codigo_pruebas"];
        $municipio = $egresadistareas1["municipio"];
        $departamento_residencia = $egresadistareas1["departamento_residencia"];
        $jornada_e = $egresadistareas1["jornada_e"];

        $data["0"] .= '
		
		<div class="col-md-12">
                <div id="accordion">
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                  <div class="card ">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                          <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos de contacto
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                      <div class="card-body">
					  
					  
						  <div class="row">
							 <div class="col-xl-6">
								<dt>Nombre</dt>
								<dd>' . $nombre . '</dd>

                                <dt>Email</dt>
                                <dd>' . $credencial_login . '</dd>
								</div>

                                <div class="col-xl-6">
								<dt>Celular</dt>
								<dd>' . $celular . '</dd>
                                
                                </div>
							</div>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                          <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos Académicos
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                      <div class="card-body">
					  	<div class="row">
							<div class="col-xl-6">
							  <dl class="dl-horizontal">
								
								<dt>Jornada Academico</dt>
								<dd>' . $jornada_e . '</dd>
								<dt>Departamento Academico</dt>
								<dd>' . $departamento_residencia . '</dd>
								<dt>Municipio Academico</dt>
								<dd>' . $municipio . '</dd>
							</div>
							<div class="col-xl-6">
								<dt>Codigo Pruebas</dt>
								<dd>' . $codigo_pruebas . '</dd>

                                <dt>Programa</dt>
								<dd>' . $programa . '</dd>
								
								
							  </dl>
							</div>
						</div>

                      </div>
                    </div>
                  </div>
            </div>
          </div>';

        $results = array($data);
        echo json_encode($results);
        break;

    case 'verHistorial':
        $id_credencial = $_POST["id_credencial"];
        $data = array(); //Vamos a declarar un array
        $data["0"] = ""; //iniciamos el arreglo

        // $egresadistareas1=$egresadistareas->verHistorial($id_credencial);// consulta para traer los interesados
        $egresadistareas1 = $egresadistareas->datos_estudiante($id_credencial); // consulta para traer los interesados
        // print_r($egresadistareas1);
        $nombre = $egresadistareas1["credencial_nombre"] . " " . $egresadistareas1["credencial_nombre_2"] . " " . $egresadistareas1["credencial_apellido"] . " " . $egresadistareas1["credencial_apellido_2"];

        $credencial_identificacion = $egresadistareas1['credencial_identificacion'];
        $credencial_login = $egresadistareas1["credencial_login"];
        $programa = $egresadistareas1["fo_programa"];
        $celular = $egresadistareas1["celular"];
        $credencial_fecha = $egresadistareas1["credencial_fecha"];
        $codigo_pruebas = $egresadistareas1["codigo_pruebas"];
        $municipio = $egresadistareas1["municipio"];
        $departamento_residencia = $egresadistareas1["departamento_residencia"];
        $jornada_e = $egresadistareas1["jornada_e"];


        $data["0"] .= '
		
		<div class="col-md-12">
                <div id="accordion">
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                  <div class="card ">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                          <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos de contacto
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                      <div class="card-body">
					  
					  
						  <div class="row">
							 <div class="col-xl-6">
								<dt>Cédula</dt>
								<dd>' . $credencial_identificacion . '</dd>

								<dt>Nombre</dt>
								<dd>' . $nombre . '</dd>

                                
								</div>

                                <div class="col-xl-6">

                                <dt>Email</dt>
                                <dd>' . $credencial_login . '</dd>

								<dt>Celular</dt>
								<dd>' . $celular . '</dd>
                                
                                </div>
							</div>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                          <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos Académicos
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                      <div class="card-body">
					  	<div class="row">
							<div class="col-xl-6">
							  <dl class="dl-horizontal">
								
								<dt>Jornada Academico</dt>
								<dd>' . $jornada_e . '</dd>
								<dt>Departamento Academico</dt>
								<dd>' . $departamento_residencia . '</dd>
								<dt>Municipio Academico</dt>
								<dd>' . $municipio . '</dd>
							</div>
							<div class="col-xl-6">
								<dt>Codigo Pruebas</dt>
								<dd>' . $codigo_pruebas . '</dd>

                                <dt>Programa</dt>
								<dd>' . $programa . '</dd>
								
								
							  </dl>
							</div>
						</div>

                      </div>
                    </div>
                  </div>
            </div>
          </div>';

        $results = array($data);
        echo json_encode($results);
        break;

        // fin agregar tareas, seguimientos y ver historial

    case 'validarTarea':
        $id_tarea = $_POST['id_tarea'];
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $egresadistareas->validarTarea($id_tarea, $hora, $fecha);

        break;

    case 'vizualizartareashoy':
        $id_usuario = $_SESSION['id_usuario'];

        $data["0"] = "";
        $data[0] .= '		
            <table id="tareasparahoy" class="table table-responsive" cellspacing="0" width="100%">

            <thead>
            <tr>
            <th scope="col">#</th>
            <th>Ref#</th>
            <th>Nombre</th>
            <th>Motivo</th>
            <th>Recordatorio</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Asesor</th>
            </tr>
            </thead>
            <tbody>';
        //consulta para traer las tareas del dia de hoy   
        $asesores = $egresadistareas->fechashoymodal($fecha_hoy, $id_usuario);

        for ($i = 0; $i < count($asesores); $i++) {
            // trae el nombre de los estudiantes 
            $datos_estudia = $egresadistareas->datos_estudiante($asesores[$i]['id_credencial']);

            $nombre_estudiante = $datos_estudia['credencial_nombre'] . ' ' . $datos_estudia['credencial_nombre_2'] . ' ' . $datos_estudia['credencial_apellido'] . ' ' . $datos_estudia['credencial_apellido_2'];
            //trae el nombre del asesor


            $nombre_asesor = $egresadistareas->nombreasesores($id_usuario);
            $asesor = 0;
            for ($u = 0; $u < count($nombre_asesor); $u++) {
                $asesor = $nombre_asesor[$u]['usuario_nombre'] . ' ' . $nombre_asesor[$u]['usuario_apellido'];
            }

            // print($nombre_asesor);
            $data[0] .= '	
            <tr>
            <th scope="row">' . ($i + 1) . '</th>
                <td>' . $asesores[$i]['id_tarea'] . '</td>
                <td>' . $nombre_estudiante . '</td> 
                <td>' . $asesores[$i]['motivo_tarea'] . '</td>
                <td>' . $asesores[$i]['mensaje_tarea'] . '</td>
                <td>' . $asesores[$i]['fecha_programada'] . '</td>
                <td>' . $asesores[$i]['hora_programada'] . '</td>
                <td>' . $asesor . '</td>
            </tr>';
        }
        $data[0] .= '
                </tbody>
                </table>';

        $results = array($data);
        echo json_encode($results);
        break;

    case "selectEstadoEgresado":
        $rspta = $egresadistareas->selectEstado();
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["nombre_estado"] . "'>" . $rspta[$i]["nombre_estado"] . "</option>";
        }
        break;


        //edita el estado del egresado
    case 'guardaryeditarreingreso':
        //traemos el id_estudiante
        $rspta = $egresadistareas->vernombreestudiantesinactivos($id_egresdado_est);
        $id_estudiante_programa = 0;
        for ($a = 0; $a < count($rspta); $a++) {
            $id_estudiante_programa = $rspta[$a]["id_estudiante"];
        }
        //consulta para validar si tiene un estado o no 
        $consulta_estado = $egresadistareas->mostrar_estados($id_egresdado_est);
        $id_estud = $consulta_estado["id_estudiante"];

        if (empty($id_estud)) {

            $rspta = $egresadistareas->insertarEstadoEgresado($id_reingreso_estado, $id_egresdado_est, $id_estudiante_programa);
            echo $rspta ? "Estado registrado" : "Estado no se pudo registrar";
        } else {

            $rspta = $egresadistareas->editarreingreso($id_reingreso_estado, $id_egresdado_est, $id_estudiante_programa);
            echo $rspta ? "Estado actualizado" : "Estado no se pudo actualizar";
        }
        break;
}
