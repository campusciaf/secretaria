<?php
session_start();
error_reporting(1);
require_once "../modelos/Historialdocente.php";
$historial_docente = new Historial();
switch ($_GET['op']) {
    case 'listar':
        $rspta = $historial_docente->listarDocente();
        $data = array();
        $reg = $rspta;
        $rsptaperiodo = $historial_docente->periodoactual();
        $periodo_actual=$rsptaperiodo["periodo_actual"];
        for ($i = 0; $i < count($reg); $i++) {
            if (file_exists("../files/docentes/" . $reg[$i]['usuario_identificacion'] . ".jpg")) {
                $imagen = "../files/docentes/" . $reg[$i]['usuario_identificacion'] . ".jpg";
            } else {
                $imagen = "../files/null.jpg";
            }
            if ($reg[$i]['usuario_condicion'] == "1") {
                $estado = '<h6><label class="badge badge-success">Activo</label></h6>';
            } else {
                $estado = '<h6><label class="badge badge-danger">Inactivo</label></h6>';
            }
            $cant_docente_grupos = $historial_docente->listar($reg[$i]['id_usuario'], "docente_grupos")["total_grupos"];
            $cant_docente_grupos_2 = $historial_docente->listar($reg[$i]['id_usuario'], "docente_grupos_2")["total_grupos"];
            $asignaturas = $cant_docente_grupos + $cant_docente_grupos_2;
            $total = '<div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-success btn-xs" title="Visualizar" onclick="ver_historial_del_docente(' . $reg[$i]['id_usuario'] . ')"><i class="fa fa-eye"></i> <span class="badge badge-light">' . $asignaturas . '</span>
                                </button>
                            </div>';
            $ultimo_ingreso = $reg[$i]["ultimo_ingreso"];
            $usuario_cargo = $historial_docente->MostrarCargoDocentes($reg[$i]['usuario_identificacion'],$periodo_actual);
            if ($usuario_cargo) {
                $ultimo_contrato = $usuario_cargo['tipo_contrato'];
            } else {
                $ultimo_contrato = '';
            }
            $historia_contrato_docente = '
                <div class="d-flex align-items-center">
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="toggle-vis btn btn-info btn-flat btn-xs mt-2" title="historico contrato" onclick="historico_docentes_contrato(' . $reg[$i]['id_usuario'] . ')"><i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                    <span> ' . " " . $ultimo_contrato . '</span>
                </div>';

            if ($ultimo_ingreso == '') {
                $ingresos_campus_docente = '';
            } else {
                $ingresos_campus_docente = '
                <div class="d-flex align-items-center">

                <div class="ml-2 col-8">
                        ' . $ultimo_ingreso = $historial_docente->fechaesp($ultimo_ingreso) . '
                    </div>
                    
                    <div class="btn-group ml-2" role="group" aria-label="...">
                        <button type="button" class="toggle-vis btn btn-info btn-flat btn-xs mt-2" title="Visualizar" onclick="ingresos_campus_docentes(' . $reg[$i]['id_usuario'] . ')"><i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>';
            }
            $usuario_identificacion = $reg[$i]["usuario_identificacion"];
            $nombres = $reg[$i]['usuario_nombre'] . ' ' . $reg[$i]['usuario_nombre_2'];
            $apellidos = $reg[$i]['usuario_apellido'] . ' ' . $reg[$i]['usuario_apellido_2'];
            $data[] = array(
                "0" => $usuario_identificacion,
                "1" => '<img style="width: 40px;" src="' . $imagen . '">',
                "2" => $apellidos,
                "3" => $nombres,
                "4" => $estado,
                "5" => $reg[$i]['usuario_email_ciaf'],
                "6" => $total,
                "7" => $historia_contrato_docente,
                "8" => $ingresos_campus_docente
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

    case 'listarHistorial':
        $id = $_GET['id'];
        $reg = $historial_docente->historialAsig($id);
        for ($i = 0; $i < count($reg); $i++) {
            $id_materia  = $reg[$i]["id_materia"];
            $periodo = $reg[$i]["periodo"];
            $jornada = $reg[$i]["jornada"];
            $grupo = $reg[$i]["grupo"];
            $id_programa_ac = $reg[$i]["id_programa"];
            $ciclo = $reg[$i]["ciclo"];
            $dia = $reg[$i]["dia"];
            $hora = $reg[$i]["hora"];
            $hasta = $reg[$i]["hasta"];
            $diferencia = $reg[$i]["diferencia"];
            $horario = "Dia: " . $dia . "<br> Inicia: " . $hora . "<br> Fin: " . $hasta;
            // traemos el nombre de la materia
            $datosmateriaciafi = $historial_docente->nombre_materia_asig($id_materia, $id_programa_ac);
            $nombre_materia = $datosmateriaciafi["nombre"];
            $semestre = $datosmateriaciafi["semestre"];
            $nombre_programa = $datosmateriaciafi["nombre_programa"];
            //total de materias 
            $materia_total_estudiante = $datosmateriaciafi["nombre"];
            $listar_materias = $historial_docente->listar_materias($ciclo, $materia_total_estudiante, $jornada, $id_programa_ac, $periodo, $grupo)["total_materias"];
            //lista los registros del docente
            $datos_promedios_estudiantes = $historial_docente->registros($nombre_materia, $semestre, $periodo, $jornada, $grupo, $id_programa_ac, $ciclo)["total_estudiante_reg1"];
            // cuenta los estudiantes aprobados
            $estudiantes_aprobados = $historial_docente->estudiantes_aprobados($nombre_materia, $semestre, $periodo, $jornada, $grupo, $id_programa_ac, $ciclo);
            $estudiantes_aprobados_reg1 = $estudiantes_aprobados["total_aprobados_reg1"];
            $suma_estudiantes_aprobados_reg1 = $estudiantes_aprobados["suma_promedio_aprobados_reg1"];
            //cuenta estudiantes reprobados 
            $nombre_materia_reprovados = $historial_docente->estudiantes_reprobados($nombre_materia, $semestre, $periodo, $jornada, $grupo, $id_programa_ac, $ciclo);
            $estudiantes_reprobados_reg1 = $nombre_materia_reprovados["total_reprobados_reg1"];
            $suma_estudiantes_rerobados_reg1 = $nombre_materia_reprovados["suma_promedio_reg1"];
            //cuenta los estudiantes del docente por periodo
            $total_estudiantes_reg1 = $datos_promedios_estudiantes;
            $suma_promedio_reg1 = $suma_estudiantes_aprobados_reg1 + $suma_estudiantes_rerobados_reg1;
            $total_promedio = ($suma_promedio_reg1 > 0) ? $suma_promedio_reg1 / $total_estudiantes_reg1 : 0;
            $data[] = array(
                "0" => $nombre_programa,
                "1" => $datosmateriaciafi["nombre"] . " <small><b>[" . $datosmateriaciafi["creditos"] . "]</b></small>",
                "2" => $listar_materias,
                "3" => $estudiantes_aprobados_reg1,
                "4" => $estudiantes_reprobados_reg1,
                "5" => $periodo,
                "6" => number_format($total_promedio, 2),
                "7" => $jornada,
                "8" => $horario,
                "9" => $diferencia
            );
        }
        $historialasig2 = $historial_docente->historialAsig2($id);
        for ($r = 0; $r < count($historialasig2); $r++) {
            $materia_asig2  = $historialasig2[$r]["materia"];
            $id_programa_ac_aseg2 = $historialasig2[$r]["id_programa"];
            $data_materia_grupo_2 = $historial_docente->obtener_datos_materia($materia_asig2, $id_programa_ac_aseg2);
            $creditos_2 = $data_materia_grupo_2["creditos"];
            $nombre_programa = $data_materia_grupo_2["nombre"];
            $periodo_asig2 = $historialasig2[$r]["periodo"];
            $jornada_aseg2 = $historialasig2[$r]["jornada"];
            $grupo_aseg2 = $historialasig2[$r]["grupo"];
            $ciclo_asig2 = $historialasig2[$r]["ciclo"];
            $dia2 = $historialasig2[$r]["dia"];
            $hora2 = $historialasig2[$r]["hora"];
            $hasta2 = $historialasig2[$r]["hasta"];
            $horario2 = "Dia: " . $dia2 . "<br> Inicia: " . $hora2 . "<br> Fin: " . $hasta2;
            // cuenta el total de las materias
            $listar_materias = $historial_docente->en_lista_Asig2($ciclo_asig2, $materia_asig2, $jornada_aseg2, $id_programa_ac_aseg2, $grupo_aseg2, $periodo_asig2)["total_estudiantes"];
            // cuenta los estudiantes aprobados
            $rpsta_estudiantes_aprobados = $historial_docente->estudiantes_aprobadosAsig2($materia_asig2, $jornada_aseg2, $grupo_aseg2, $id_programa_ac_aseg2, $ciclo_asig2, $periodo_asig2);
            $estudiantes_aprobados_asig2 = $rpsta_estudiantes_aprobados["total_aprobados"];
            $suma_estudiantes_aprobados = $rpsta_estudiantes_aprobados["suma_promedio_aprobados"];
            //cuenta los estudiantes reprobados
            $rsptas = $historial_docente->estudiantes_reprobadosasig2($materia_asig2, $jornada_aseg2, $grupo_aseg2, $ciclo_asig2, $periodo_asig2, $id_programa_ac_aseg2);
            $estudiantes_reprobados_asig2 = $rsptas["total_reprobados"];
            $suma_estudiantes_reprobados = $rsptas["suma_promedios"];
            $total_estudiantes = $listar_materias;
            $suma_promedio = $suma_estudiantes_aprobados + $suma_estudiantes_reprobados;
            if ($suma_promedio > 0) {
                $total_promedio = $suma_promedio / $total_estudiantes;
            } else {
                $total_promedio = 0;
            }

            $data[] = array(
                "0" => $nombre_programa,
                "1" => $materia_asig2 . " <small><b>[" . $creditos_2 . "]</b></small>",
                "2" => $listar_materias,
                "3" => $estudiantes_aprobados_asig2,
                "4" => $estudiantes_reprobados_asig2,
                "5" => $periodo_asig2,
                "6" => number_format($total_promedio, 2),
                "7" => $jornada_aseg2,
                "8" => $horario2,
                "9" => $horario2
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

    case 'prueba':
        $id = "22";
        $historialalsig = $historial_docente->historialAsig($id);
        // Historial::historialAsig($id);
        break;

    case 'ingresos_campus_x_fecha':
        $data["0"] = "";
        $data["0"] .= '
            <div id="IngresosCampus">
                <form action="#" class="row" id="form_grafica">
                    <div class="col">
                        <select onchange="generarGrafica()" class="form-control" id="anio" name="anio">
                            <option value="2023" selected>2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" onchange="generarGrafica()" name="mes" id="mes">
                            <option value="" disabled selected> Selecciona el mes </option>
                            <option value="01">Enero</option>
                            <option value="02">febrero</option>
                            <option value="03">marzo</option>
                            <option value="04">abril</option>
                            <option value="05">mayo</option>
                            <option value="06">junio</option>
                            <option value="07">julio</option>
                            <option value="08">agosto</option>
                            <option value="09">septiembre</option>
                            <option value="10">octubre</option>
                            <option value="11">noviembre</option>
                            <option value="12">diciembre</option>
                        </select>
                    </div>
                </form>
                <form name="consultafecha" id="consultafecha" method="POST" enctype="multipart/form-data">
                    <div id="chartContainer2" style="height: 420px; max-width: 920px; margin: 0px auto;"></div>
                </form>
            </div>';
        echo json_encode($data);
        break;
    //grafico para el ingreso de docentes
    case "graficodocentes":
        $id_docente = $_POST["global_id_docente"];
        $mes = isset($_POST["mes"]) ? $_POST["mes"] : date("m");
        $anio = isset($_POST["anio"]) ? $_POST["anio"] : date("Y");
        $data = array();
        $data["datosuno"] = "";
        $coma = ",";
        $valoranterior = 0;
        $valornuevo = 0;
        $figura = "circle";
        $color = "#6B8E24";
        $data["datosuno"] .= '[ ';
        $fecha_consulta = $anio . "-" . $mes;
        $docente_por_mes = $historial_docente->consulta_por_mes_2($id_docente, $fecha_consulta);
        for ($d = 0; $d < count($docente_por_mes); $d++) {
            $casos_x_fecha = $docente_por_mes[$d]["total_ingreso"];
            $fecha_creacion = $docente_por_mes[$d]["fecha"];
            $separar_fecha = explode('-', $fecha_creacion);
            $dia_separado = $separar_fecha[2];
            $valornuevo = $casos_x_fecha;
            $data["datosuno"] .= '{ "label": "' . $dia_separado . '", "y": ' . $casos_x_fecha . ', "indexLabel": "' . $casos_x_fecha . '", "markerType": "' . $figura . '",  "markerColor": "' . $color . '" },';
            $valoranterior = $casos_x_fecha;
        }
        // eliminar la coma de la ultima columna para evitar error.
        $data["datosuno"] = substr($data["datosuno"], 0, -1);
        $data["datosuno"] .= ' ]';
        echo json_encode($data);
        break;

    case 'mostrar_total_horas':

        $id_global = $_POST["id_global"];
        $data[0] = "";
        $suma_docente_horas = $historial_docente->sumarhorasdocentes($id_global);
        $suma_diferencia = $suma_docente_horas[0]['suma_diferencia'];
        if (isset($suma_docente_horas[0]['suma_diferencia'])) {
            $suma_diferencia = $suma_docente_horas[0]['suma_diferencia'];
            $data[0] .= '<div  style="left: 143px  !important; right: 0 !important; top: 45px  !important;" class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-success btn-xs" title="Visualizar">
            Total horas <span class="badge badge-light">' . $suma_diferencia . '</span>
            </button>
            </div>
            
            ';
        } else {
            $historialasig2 = $historial_docente->historialAsig2($id_global);

            $data[0] .= '<div  style="left: 143px  !important; right: 0 !important; top: 45px  !important;" class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-success btn-xs" title="Visualizar">
            Total horas <span class="badge badge-light">0</span>
            </button>
            </div>
            
            ';
        }
        echo json_encode($data);
        break;



    case 'historico_docentes_contrato':
        $id_docente = $_POST["id_usuario"];
        $historico_contrato_docente = $historial_docente->traer_id_docente_historico_contrato($id_docente);
        $cedula = $historico_contrato_docente['usuario_identificacion'];
        $data["0"] = "";
        $mostrar_historico_docente = $historial_docente->historicodoce($cedula);
        $data["0"] .= '<table id ="historico_contrato_docentes" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Documento Docente</th>
                    <th scope="col">Tipo Contrato</th>
                    <th scope="col">Fecha Creación</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Periodo</th>
                    <th scope="col">Quien lo creo</th>
                </tr>
            </thead>
            <tbody>';

        for ($h = 0; $h < count($mostrar_historico_docente); $h++) {
            $documento_docente = $mostrar_historico_docente[$h]["documento_docente"];
            $tipo_contrato = $mostrar_historico_docente[$h]["tipo_contrato"];
            $periodo = $mostrar_historico_docente[$h]["periodo"];
        
            
            $nombre_docente = $historial_docente->nombreusuario($mostrar_historico_docente[$h]["id_usuario"]);
            $nombre_docente_completo = $nombre_docente["usuario_nombre"]." ".$nombre_docente["usuario_nombre_2"]." ".$nombre_docente["usuario_apellido"]." ".$nombre_docente["usuario_apellido_2"];

            $partes = explode(" ", $mostrar_historico_docente[$h]["fecha_realizo"]);
            //tomamos la posicion de la fecha
            $fecha = $partes[0];
            //tomamos la posicion de la hora
            $hora = $partes[1];
            $fecha_creacion = $historial_docente->fechaesp($fecha);
            $data[0] .= '
                <tr>
                    <td class="text-center">' . $documento_docente . '</td>
                    <td class="text-center">' . $tipo_contrato . '</td>
                    <td class="text-center">' . $fecha_creacion. '</td>
                    <td class="text-center">' . $hora . '</td>
                    <td class="text-center">' . $periodo . '</td>
                    <td class="text-center">' . $nombre_docente_completo . '</td>
                </tr>';
        }
        $data[0] .= '</tbody></table>';
        echo json_encode($data);
        break;
}
