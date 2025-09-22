<?php
require_once "../modelos/VerEncuentas.php";
$ver_ecnuesta = new VerEncuesta();
$periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
$periodo = empty($periodo) ? $_SESSION['periodo_actual'] : $periodo;
// $tipo = "evaluaciondocente";
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$estado = isset($_POST["estado"]) ? $_POST["estado"] : "";

switch ($_GET['op']) {
    case 'selectPeriodo':
        $rspta = $ver_ecnuesta->listarPeriodos();
        echo json_encode($rspta);
        break;
    case 'mostrarEstadoEvalaucion':
        $rspta = $ver_ecnuesta->mostrarEstadoEvalaucion($tipo);
        echo json_encode($rspta);
        break;
    case 'cambiarEstadoEvalaucion':
        $rspta = $ver_ecnuesta->cambiarEstadoEvalaucion($tipo, $estado);
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
        $estudiantesactivos = $ver_ecnuesta->totalestudiantesactivos($periodoconsulta);
        $totalactivos = count($estudiantesactivos);
        $estudiantes = $ver_ecnuesta->totalestudiantescontestaron($periodoconsulta);
        $total = count($estudiantes);
        $porcentaje = ($totalactivos == 0)?0: ($total * 100) / $totalactivos    ;
        $data["0"] = '
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Avance' . $periodoconsulta . '</span>
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
        //lista los docentes del campus
        $datos = $ver_ecnuesta->listarDocentes();
        $array = array();
        for ($i = 0; $i < count($datos); $i++) {
            $sumar_promedio = 0;
            $promedio_total = 0;
            $id_docente = $datos[$i]["id_usuario"];
            //lista los grupos dependiendo del id_docente y periodo
            $docente_grupos = $ver_ecnuesta->listarGrupos($id_docente, $periodo);
            for ($j = 0; $j < count($docente_grupos); $j++) {
                //saca el promedio de la evaluacion docente 
                $promedio = $ver_ecnuesta->listarResultados($docente_grupos[$j]['id_docente_grupo'], $periodo);
                // print_r($promedio);
                if (is_array($promedio) && count($promedio) > 0) {
                    if (!empty($promedio["promedio"]) || !$promedio["promedio"] == 0) {
                        $sumar_promedio += $promedio["promedio"];
                        $promedio_total += 1;
                    }
                }
            }
            $promedio_total = ($promedio_total == 0) ? 1 : $promedio_total;

            $img = (file_exists("../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg")) ? "../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg" : "../files/null.jpg";
            $nombre = $datos[$i]["usuario_nombre"] . " " . $datos[$i]["usuario_nombre_2"] . " " . $datos[$i]["usuario_apellido"] . " " . $datos[$i]["usuario_apellido_2"];
            $total_asignaturas = $ver_ecnuesta->materiasPorDocente($datos[$i]["id_usuario"], $periodo)["total"];

            $porcentaje = $sumar_promedio / $promedio_total;
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
                "4" => '<div style="padding-top:5px"><div class="progress progress-xs"><div class="progress-bar ' . $color . '" style="width: ' . $sumar_promedio / $promedio_total . '%"></div></div>' . round(($sumar_promedio / $promedio_total), 2) . ' %</div>',
                "5" => '<div class="text-center">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-info btn-xs" onclick="listarResultados(' . $datos[$i]["id_usuario"] . ', `' . $periodo . '` )" title="Ver resultados por asignatura"> 
                                    <i class="fa fa-book"></i> ' . $total_asignaturas . ' 
                                </button>
                                
                               
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
        $docente_grupos = $ver_ecnuesta->listarGrupos($id_docente, $periodo);
       
        $array = array();
        for ($i = 0; $i < count($docente_grupos); $i++) {
            $ciclo=$docente_grupos[$i]['ciclo'];
            $id_programa=$docente_grupos[$i]['id_programa'];
            $jornada=$docente_grupos[$i]['jornada'];
            $semestre=$docente_grupos[$i]['semestre'];
            $grupo=$docente_grupos[$i]['grupo'];
            $id_materia=$docente_grupos[$i]['id_materia'];

            $promedio = $ver_ecnuesta->listarResultados($docente_grupos[$i]['id_docente_grupo'],$periodo);

            $buscar_nombre_materia=$ver_ecnuesta->nombre_materia($id_materia);
            $nombre_materia=$buscar_nombre_materia["nombre"];
           
            $traernummaterias=$ver_ecnuesta->traernummaterias($ciclo,$nombre_materia,$jornada,$periodo,$semestre,$id_programa,$grupo);
            $totalmatriculadas=$traernummaterias["total_matriculadas"];

            if (is_array($promedio) && count($promedio) > 0) {
                $array[] = array(
                    "0" => '<strong> ' . $docente_grupos[$i]['id_docente_grupo'] . '</strong>',
                    "1" => $docente_grupos[$i]["nombre_programa"],
                    "2" => $nombre_materia,
                    "3" => empty($promedio["total"]) ? 0 : $promedio["total"],
                    "4" => empty($promedio["cantidad"]) ? 0 : $promedio["cantidad"],
                    "5" => $totalmatriculadas,
                    "6" => empty($promedio["promedio"]) ? 0 : $promedio["promedio"],
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

   

        
}
