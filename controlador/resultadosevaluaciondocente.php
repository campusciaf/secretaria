<?php
require_once "../modelos/Resultadosevaluaciondocente.php";
$resultado = new Resultados();
$periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
$periodo = empty($periodo) ? $_SESSION['periodo_actual'] : $periodo;
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$estado = isset($_POST["estado"]) ? $_POST["estado"] : "";
switch ($_GET['op']) {
    case 'selectPeriodo':
        $rspta = $resultado->listarPeriodos();
        echo json_encode($rspta);
        break;
    case 'mostrarEstadoEvalaucion':
        $rspta = $resultado->mostrarEstadoEvalaucion($tipo);
        echo json_encode($rspta);
        break;
    case 'cambiarEstadoEvalaucion':
        $rspta = $resultado->cambiarEstadoEvalaucion($tipo, $estado);
        $rpsta = ($rspta) ? 1 : 0;
        echo json_encode(array("exito" => $rpsta));
        break;
    case 'datospanel':
        $periodobuscar = $_POST["periodobuscar"];
        if ($periodobuscar == "") {
            $periodoconsulta = $periodo;
        } else {
            $periodoconsulta = $periodobuscar;
        }
        $data = array();
        $data["0"] = "";
        $estudiantesactivos = $resultado->totalestudiantesactivos($periodoconsulta);
        $totalactivos = count($estudiantesactivos);
        $estudiantes = $resultado->totalestudiantescontestaron($periodoconsulta);
        $total = count($estudiantes);
        $porcentaje = ($totalactivos == 0) ? 0 : ($total * 100) / $totalactivos;
        $data["0"] = '
        <div class="col-xl-6 col-4 info-box">
            <span class="info-box-icon bg-light-green"><i class="far fa-thumbs-up"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Avance ' . $periodoconsulta . '</span>
                <span class="info-box-number">' . $totalactivos . ' /' . $total . '</span>
                <div class="progress">
                    <div class="progress-bar" style="width: ' . $porcentaje . '%"></div>
                </div>
                <span class="progress-description">
                    ' . round($porcentaje, 0) . '% de Avance en la evaluación
                </span>
            </div>
        </div>';
        echo json_encode($data);
        break;
    case 'consulta':
        $datos = $resultado->listarDocentes();
        $array = array();
        for ($i = 0; $i < count($datos); $i++) {
            $sumar_promedio = 0;
            $promedio_total = 0;
            $id_docente = $datos[$i]["id_usuario"];
            $promediocalculado = $resultado->promedioCalculado($id_docente, $periodo);
            // $docente_grupos = $resultado->listarGrupos($id_docente, $periodo);
            // for ($j = 0; $j < count($docente_grupos); $j++) {
            //     $promedio = $resultado->listarResultados($docente_grupos[$j]['id_docente_grupo'], $periodo);
            //     if (is_array($promedio) && count($promedio) > 0) {
            //         if (!empty($promedio["promedio"]) || !$promedio["promedio"] == 0) {
            //             $sumar_promedio += $promedio["promedio"];
            //             $promedio_total += 1;
            //         }
            //     }
            // }
            $promedio_total = ($promedio_total == 0) ? 1 : $promedio_total;
            $img = (file_exists("../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg")) ? "../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg" : "../files/null.jpg";
            $nombre = $datos[$i]["usuario_nombre"] . " " . $datos[$i]["usuario_nombre_2"] . " " . $datos[$i]["usuario_apellido"] . " " . $datos[$i]["usuario_apellido_2"];
            $total_asignaturas = $resultado->materiasPorDocente($datos[$i]["id_usuario"], $periodo)["total"];
            // $porcentaje = $sumar_promedio / $promedio_total;
            $porcentaje = round($promediocalculado, 2);
            if ($porcentaje > 90) {
                $color = "bg-success";
            } else if ($porcentaje > 80) {
                $color = "bg-orange";
            } else if ($porcentaje > 70) {
                $color = "bg-warning";
            } else {
                $color = "bg-danger";
            }
            $array[] = array(
                "0" => "<img src='" . $img . "' class='direct-chat-img' width='50px' height='50px'>",
                "1" => mb_convert_case($nombre, MB_CASE_TITLE, "UTF-8") .
                    '<br><b style="font-size: 12px;" class="text-primary" title="Identificación"><i class="fa fa-id-card"></i> ' . $datos[$i]["usuario_identificacion"] . '</b>',
                "2" => $datos[$i]["usuario_celular"],
                "3" => $datos[$i]["usuario_email_p"],
                "4" => '<div style="padding-top:5px">
                            <div class="progress progress-xs">
                                <div class="progress-bar ' . $color . '" style="width: ' . $promediocalculado . '%"></div>
                            </div>' . number_format($promediocalculado, 2) . ' % 
                        </div>',
                "5" => '<div class="text-center">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-info btn-xs" onclick="listarResultados(' . $datos[$i]["id_usuario"] . ', `' . $periodo . '` )" title="Ver resultados por asignatura"> 
                                    <i class="fa fa-book"></i> ' . $total_asignaturas . ' 
                                </button>
                                <button type="button" class="btn btn-success btn-xs"  onclick="listarRespuestas(' . $datos[$i]["id_usuario"] . ', `' . $periodo . '` )" title="Ver resultados por pregunta">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-primary btn-xs"  onclick="listarRespuestasComentarios(' . $datos[$i]["id_usuario"] . ', `' . $periodo . '` )" title="Ver comentarios">
                                <i class="fa-regular fa-comment"></i>
                                </button>
                                <!-- <button type="button" class="btn btn-success btn-xs" onclick="ver_resultados(134,23.976377952756,15,2)" title="Ver resultados">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-primary btn-xs" onclick="ver_resultados(134,23.976377952756,15,3)" title="Ver resultados detallados">
                                        <i class="fa fa-chart-bar"></i>
                                </button> -->
                            </div>
                    </div> ',
            );
        }
        //se crea otro array para almacenar toda la informacion que analizara el datatable
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
    case "listarResultados":
        $id_docente = isset($_POST["id_docente"]) ? $_POST["id_docente"] : 0;
        $periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
        $periodo = empty($periodo) ? $_SESSION['periodo_actual'] : $periodo;
        $docente_grupos = $resultado->listarGrupos($id_docente, $periodo);
        $array = array();
        for ($i = 0; $i < count($docente_grupos); $i++) {
            $ciclo = $docente_grupos[$i]['ciclo'];
            $id_programa = $docente_grupos[$i]['id_programa'];
            $jornada = $docente_grupos[$i]['jornada'];
            $semestre = $docente_grupos[$i]['semestre'];
            $grupo = $docente_grupos[$i]['grupo'];
            $id_materia = $docente_grupos[$i]['id_materia'];
            $promedio = $resultado->listarResultados($docente_grupos[$i]['id_docente_grupo'], $periodo);
            $buscar_nombre_materia = $resultado->nombre_materia($id_materia);
            $nombre_materia = $buscar_nombre_materia["nombre"];
            $traernummaterias = $resultado->traernummaterias($ciclo, $nombre_materia, $jornada, $periodo, $semestre, $id_programa, $grupo);
            $totalmatriculadas = $traernummaterias["total_matriculadas"];
            if (is_array($promedio) && count($promedio) > 0) {
                $array[] = array(
                    "0" => '<strong> ' . $docente_grupos[$i]['id_docente_grupo'] . '</strong>',
                    "1" => $docente_grupos[$i]["nombre_programa"],
                    "2" => $nombre_materia,
                    "3" => $jornada,
                    "4" => empty($promedio["total"]) ? 0 : $promedio["total"],
                    "5" => empty($promedio["cantidad"]) ? 0 : $promedio["cantidad"],
                    "6" => $totalmatriculadas,
                    "7" => empty($promedio["promedio"]) ? 0 : $promedio["promedio"],
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
    case "listarRespuestas2":
        //id_docente post
        $id_docente = isset($_POST["id_docente"]) ? $_POST["id_docente"] : 0;
        //periodo por post
        $periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
        //si el periodo por alguna razon llega vacio, tomamos por defecto el actual
        $periodo = empty($periodo) ? $_SESSION['periodo_actual'] : $periodo;
        //listamos todas las preguntas
        $preguntas = $resultado->listarPreguntas();
        //listamos las respuestas
        $respuestas = $resultado->listarRespuestas($id_docente, $periodo);
        $array = array();
        for ($i = 1; $i <= count($preguntas); $i++) {
            $a = $i - 1;
            //Cuando el tipo es cero indica que la pregunta es opcion multiple
            if ($preguntas[$a]["tipo"] == 0) {
                $promedio = $respuestas["sum_p" . $i] / $respuestas["total_respuestas"];
                $array[] = array(
                    "0" => $preguntas[$a]["id"],
                    "1" => $preguntas[$a]["pregunta"],
                    "2" => number_format((float)$promedio, 2, '.', ''),
                );
            } elseif ($preguntas[$a]["tipo"] == 9) {
                $total_si = $resultado->TotalTipo9($id_docente, $periodo, "p" . $preguntas[$a]["id"], "si");
                $total_no = $resultado->TotalTipo9($id_docente, $periodo, "p" . $preguntas[$a]["id"], "no");
                $array[] = array(
                    "0" => $preguntas[$a]["id"],
                    "1" => $preguntas[$a]["pregunta"],
                    "2" => '<b>Si: </b> ' . $total_si . ' <br> <b>No: </b>' . $total_no,
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
    case "listarRespuestas":
        //id_docente post
        $id_docente = isset($_POST["id_docente"]) ? $_POST["id_docente"] : 0;
        //periodo por post
        $periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
        //si el periodo por alguna razon llega vacio, tomamos por defecto el actual
        $periodo = empty($periodo) ? $_SESSION['periodo_actual'] : $periodo;
        //listamos todas las preguntas
        $preguntas = $resultado->listarPreguntas();
        //listamos las respuestas
        $array = array();
        for ($i = 1; $i <= count($preguntas); $i++) {
            $respuestas = $resultado->listarRespuestasNuevo($id_docente, $periodo, $i);
            $a = $i - 1;
            //Cuando el tipo es cero indica que la pregunta es opcion multiple
            if ($preguntas[$a]["tipo"] == 0) {
                $array[] = array(
                    "0" => $preguntas[$a]["id"],
                    "1" => $preguntas[$a]["pregunta"],
                    "2" => number_format($respuestas, 2)
                );
            } elseif ($preguntas[$a]["tipo"] == 9) {
                $total_si = $resultado->TotalTipo9($id_docente, $periodo, "p" . $preguntas[$a]["id"], "si");
                $total_no = $resultado->TotalTipo9($id_docente, $periodo, "p" . $preguntas[$a]["id"], "no");
                $array[] = array(
                    "0" => $preguntas[$a]["id"],
                    "1" => $preguntas[$a]["pregunta"],
                    "2" => '<b>Si: </b> ' . $total_si . ' <br> <b>No: </b>' . $total_no,
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
    case "listarRespuestasComentarios":
        //id_docente post
        $id_docente = isset($_POST["id_docente"]) ? $_POST["id_docente"] : 0;
        //periodo por post
        $periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
        //si el periodo por alguna razon llega vacio, tomamos por defecto el actual
        $periodo = empty($periodo) ? $_SESSION['periodo_actual'] : $periodo;
        //listamos las respuestas
        $respuestas = $resultado->listarRespuestasComentarios($id_docente, $periodo);
        $array = array();
        $a = 1;
        for ($i = 1; $i <= count($respuestas); $i++) {
            if (is_array($respuestas[$i]) && $respuestas[$i]["p23"] != "") {
                $array[] = array(
                    "0" => $a,
                    "1" => $respuestas[$i]["p23"],
                );
                $a++;
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
}