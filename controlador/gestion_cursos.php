<?php
session_start();
require_once "../modelos/GestionCursos.php";

$consulta = new GestionCursos();
$id_usuario = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : die(json_encode(array("exito" => "0", "info" => "Sesion caducada, vuelva a iniciar por favor ")));

$id_curso = isset($_POST["id_curso"]) ? $_POST["id_curso"] : "";
$nombre_curso = isset($_POST["nombre_curso"]) ? $_POST["nombre_curso"] : "";
$sede_curso = isset($_POST["sede_curso"]) ? $_POST["sede_curso"] : "";
$precio_curso = isset($_POST["precio_curso"]) ? $_POST["precio_curso"] : "";
$docente_curso = isset($_POST["docente_curso"]) ? $_POST["docente_curso"] : "";
$modalidad_curso = isset($_POST["modalidad_curso"]) ? $_POST["modalidad_curso"] : "";
$fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : "";
$fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : "";
$estado_educacion = isset($_POST["estado_educacion"]) ? $_POST["estado_educacion"] : "";
$descripcion_curso = isset($_POST["descripcion_curso"]) ? $_POST["descripcion_curso"] : "";
$horario_curso = isset($_POST["horario_curso"]) ? $_POST["horario_curso"] : "";
$categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : "";
$nivel_educacion = isset($_POST["nivel_educacion"]) ? $_POST["nivel_educacion"] : "";
$duracion_educacion = isset($_POST["duracion_educacion"]) ? $_POST["duracion_educacion"] : "";
$imagen = isset($_POST["imagen_curso"]) ? $_POST["imagen_curso"] : "";
$color_estado = array('Proximamente' => "warning", 'Abierto' => "success", 'Cerrado' => "danger");
$color_activo = array(0 => "danger", 1 => "success");
$texto_activo = array(0 => "Inactivo", 1 => "Activo");
$icon_button = array(0 => "fas fa-lock", 1 => "fas fa-lock-open");
$function = array(0 => 1, 1 => 0);

switch ($_GET["op"]) {
    
    case 'listar':
        //echo "$fecha_hoy, ".$_SESSION["id_usuario"];
        $rspta = $consulta->listarCursos();
        //Vamos a declarar un array
        $data = array();
        $estado = "";
        //while ($rspta = $rspta[$i]["fetch_object"]()) {
        for ($i = 0; $i < count($rspta); $i++) {
            $docente = ($rspta[$i]["docente_curso"] == 0) ? "Por Definir" : $consulta->listarDocente($rspta[$i]["docente_curso"]);
            $docente = isset($docente["nombre_completo"])? $docente["nombre_completo"]:null;
            $estado_educacion = "<span class='badge badge-" . $color_activo[$rspta[$i]["estado_educacion"]] . "'>" . $texto_activo[$rspta[$i]["estado_educacion"]] . "</span>";
            $btn_estado = '<button class="btn btn-' . $color_activo[$rspta[$i]["estado_educacion"]] . '" onclick="estadoCurso(' . $rspta[$i]["id_curso"] . ',' . $function[$rspta[$i]["estado_educacion"]] . ')"> <i class="' . $icon_button[$rspta[$i]["estado_educacion"]] . '"></i> </button>';
            $docente = is_null($docente)?"":ucfirst(mb_strtolower($docente, "UTF-8"));
            $data[] = array(
                "0" => '<div class="btn-group">
                    <button class="btn btn-xs btn-warning" onclick="mostrarCurso(' . $rspta[$i]["id_curso"] . ')" title="Editar Curso"> <i class="fas fa-pen"></i></button>
                    <button class="btn btn-xs btn-danger" onclick="eliminarCurso(' . $rspta[$i]["id_curso"] . ')" title="Eliminar Curso"> <i class="fas fa-trash"></i></button>
                    ' . $btn_estado . '
                </div>',
                "1" => $rspta[$i]["nombre_curso"],
                "2" => $rspta[$i]["sede_curso"],
                "3" => $rspta[$i]["modalidad_curso"],
                "4" => $docente,
                "5" => $consulta->fechaesp($rspta[$i]["fecha_inicio"]),
                "6" => $consulta->fechaesp($rspta[$i]["fecha_fin"]),
                "7" => $rspta[$i]["horario_curso"],
                "8" => $rspta[$i]["precio_curso"],
                "9" => $estado_educacion
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
    case "mostrarCurso":
        $rspta = $consulta->mostrarCurso($id_curso);
        echo json_encode($rspta);
    break;
    case "eliminarCurso":
        $rspta = $consulta->eliminarCurso($id_curso);
        echo ($rspta) ? json_encode(array('status' => 1)) : json_encode(array('status' => 0,));
    break;
    case "estadoCurso":
        //echo "$id_curso, $estado_educacion";
        $rspta = $consulta->estadoCurso($id_curso, $estado_educacion);
        echo ($rspta) ? json_encode(array('status' => 1)) : json_encode(array('status' => 0,));
    break;
    case "guardaryEditarCurso":
        if (!file_exists($_FILES['imagen_curso']['tmp_name']) || !is_uploaded_file($_FILES['imagen_curso']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen_curso"]["name"]);
            if ($_FILES['imagen_curso']['type'] == "image/webp" || $_FILES['imagen_curso']['type'] == "image/jpg" || $_FILES['imagen_curso']['type'] == "image/jpeg" || $_FILES['imagen_curso']['type'] == "image/png" || $_FILES['imagen_curso']['type'] == "application/pdf") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen_curso"]["tmp_name"], "../public/img_educacion/" . $imagen);
            }
        }

        if (empty($id_curso)) {
            $curso_stmt = $consulta->insertarCurso($nombre_curso, $docente_curso, $descripcion_curso, $modalidad_curso, $fecha_inicio, $fecha_fin, $horario_curso, $sede_curso, $precio_curso, $categoria, $nivel_educacion, $duracion_educacion, $imagen);
        } else {
            $curso_stmt = $consulta->editarCurso($id_curso, $nombre_curso, $docente_curso, $descripcion_curso, $modalidad_curso, $fecha_inicio, $fecha_fin, $horario_curso, $sede_curso, $precio_curso, $categoria, $nivel_educacion, $duracion_educacion, $imagen);
        }

        if ($curso_stmt) {
            echo json_encode(array(
                'status' => 1,
                'valor' => "Realizado con éxito.",
            ));
        } else {
            echo json_encode(array(
                'status' => 0,
                "valor" => "Ha ocurrido un error con el curso. err_code_095"
            ));
        }
    break;
    case 'listarDocentesActivos':
        $rspta = $consulta->listarDocentesActivos();
        //Vamos a declarar un array
        $data["exito"] = 0;
        $data["info"] = '<option value="" disabled selected> -- Selecciona un docente -- </option>
                         <option value="    Por Definir"> Por Definir </option>';;
        //while ($rspta = $rspta[$i]["fetch_object"]()) {
        for ($i = 0; $i < count($rspta); $i++) {
            $data["exito"] = 1;
            $nombre = ucfirst(mb_strtolower($rspta[$i]["usuario_nombre"] . " " . $rspta[$i]["usuario_nombre_2"] . " " . $rspta[$i]["usuario_apellido"] . " " . $rspta[$i]["usuario_apellido_2"], 'UTF-8'));
            $data["info"] .= '<option value="' . $rspta[$i]["id_usuario"] . '"> ' . $nombre . '</option>';
        }
        echo json_encode($data);
        break;
}
