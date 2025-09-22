<?php
require_once "../modelos/CoevaluacionDocente.php";
$resultado = new Coevaluacion();
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
$periodo = empty($periodo) ? $_SESSION['periodo_actual'] : $periodo;
switch ($_GET['op']) {
    case 'selectPeriodo':
        $rspta = $resultado->listarPeriodos();
        echo json_encode($rspta);
        break;
    case 'consulta':
        $datos = $resultado->listarDocentes();
        $array = array();
        for ($i = 0; $i < count($datos); $i++) {
            if (file_exists("../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg")) {
                $img = "../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg";
            } else {
                $img = "../files/null.jpg";
            }
            $coevaluacion_rspta = $resultado->buscarResultadoPeriodo($datos[$i]["id_usuario"], $periodo);
            if (count($coevaluacion_rspta) > 0) {
                $total =  $coevaluacion_rspta[0]["total"];
                $boton = '<span class="badge badge-success"> Evaluado </span> ';
                $boton_visualizar_respuesta = '<button class="btn btn-info btn-flat btn-xs" onclick="visualizar_respuestas(' . $datos[$i]["id_usuario"] . ')" title="editar"><i class="fas fa-eye"></i></button>';
            } else {
                $total = "Pendiente";
                if ($periodo == $_SESSION['periodo_actual']) {
                    $boton = '<button class="btn btn-sm btn-outline-primary" onclick="mostrarFormulario(' . $datos[$i]["id_usuario"] . ')"> <i class="fas fa-list"></i> Realizar Evaluación </button>';
                } else {
                    $boton = '<span class="badge badge-danger"> NO Evaluado </span>';
                    $boton = '<button class="btn btn-sm btn-outline-primary" onclick="mostrarFormulario(' . $datos[$i]["id_usuario"] . ')"> <i class="fas fa-list"></i> Realizar Evaluación </button>';
                    $boton_visualizar_respuesta = '';
                }
            }
            $array[] = array(
                "0" => $boton . $boton_visualizar_respuesta,
                "1" => $datos[$i]["usuario_identificacion"],
                "2" => $datos[$i]["usuario_nombre"] . " " . $datos[$i]["usuario_nombre_2"],
                "3" => $datos[$i]["usuario_apellido"] . " " . $datos[$i]["usuario_apellido_2"],
                "4" => $datos[$i]["usuario_celular"],
                "5" => $datos[$i]["usuario_login"],
                "6" => is_numeric($total) ? round($total, 2) . " %" : $total,
                "7" => "<img src='" . $img . "' height='40px' width='40px'>",
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
    case "guardaryeditar":
        $id_calificador = $_SESSION['id_usuario'];
        $id_docente = isset($_POST["id_docente"]) ? $_POST["id_docente"] : "0";
        $periodo_coevaluacion = isset($_POST["periodo_coevaluacion"]) ? $_POST["periodo_coevaluacion"] : "0";
        $r1 = isset($_POST["r1"]) ? $_POST["r1"] : "0";
        $r2 = isset($_POST["r2"]) ? $_POST["r2"] : "0";
        $r3 = isset($_POST["r3"]) ? $_POST["r3"] : "0";
        $r4 = isset($_POST["r4"]) ? $_POST["r4"] : "0";
        $r5 = isset($_POST["r5"]) ? $_POST["r5"] : "0";
        $r6 = isset($_POST["r6"]) ? $_POST["r6"] : "0";
        $r7 = isset($_POST["r7"]) ? $_POST["r7"] : "0";
        $r8 = isset($_POST["r8"]) ? $_POST["r8"] : "0";
        $r9 = isset($_POST["r9"]) ? $_POST["r9"] : "0";
        $r10 = isset($_POST["r10"]) ? $_POST["r10"] : "0";
        $rspta = $resultado->insertarCoevaluacionDocente($id_calificador, $id_docente, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $fecha, $hora, $periodo_coevaluacion);
        if ($rspta) {
            $array = array("exito" => 1, "info" => "Docente evaluado exitosamente");
        } else {
            $array = array("exito" => 0, "info" => "Error al guardar evaluación");
        }
        echo json_encode($array);
        break;
    case 'visualizar_respuestas':
        $id_usuario = $_POST["id_usuario"];
        $periodo_seleccionado = $_POST["periodo_seleccionado"];
        $rspta = $resultado->Visualizar_Respuestas($id_usuario, $periodo_seleccionado);
        if (is_array($rspta)) {
            $data = array("exito" => 1, "info" => $rspta);
        } else {
            $data = array("exito" => 0, "info" => "Sin respuesta");
        }
        echo json_encode($data);
        break;
}
