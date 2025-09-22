<?php
session_start();
require_once "../modelos/CvAdmin.php";
$usuario = new CvAdmin();

$id_cvadministrativos = isset($_POST["id_cvadministrativos"]) ? limpiarCadena($_POST["id_cvadministrativos"]) : "";
$cvadministrativos_nombre = isset($_POST["cvadministrativos_nombre"]) ? limpiarCadena($_POST["cvadministrativos_nombre"]) : "";
$cvadministrativos_identificacion   = isset($_POST["cvadministrativos_identificacion"]) ? limpiarCadena($_POST["cvadministrativos_identificacion"]) : "";
$cvadministrativos_celular = isset($_POST["cvadministrativos_celular"]) ? limpiarCadena($_POST["cvadministrativos_celular"]) : "";
$cvadministrativos_correo = isset($_POST["cvadministrativos_correo"]) ? limpiarCadena($_POST["cvadministrativos_correo"]) : "";
$cvadministrativos_cargo = isset($_POST["cvadministrativos_cargo"]) ? limpiarCadena($_POST["cvadministrativos_cargo"]) : "";

switch ($_GET["op"]) {
    case 'listar_funcionarios':
        $rspta = $usuario->listar();
        //Vamos a declarar un array
        $data  = array();
        $reg   = $rspta;
        $id_cvadministrativos_cv_eliminar = $_SESSION["id_usuario"];
        for ($i = 0; $i < count($reg); $i++) {
            $porcentaje_avance = $reg[$i]["porcentaje_avance"];
            $clase_barra = $porcentaje_avance > 96 ? 'bg-success' : ($porcentaje_avance > 70 ? 'bg-warning' : 'bg-danger');
            $boton_porcentaje_avance = '
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <span class="text-semibold fs-12">' . $porcentaje_avance . '% de Avance</span>
                        </div>
                        <div class="col-12">
                            <div class="progress progress-sm">
                                <div class="progress-bar ' . $clase_barra . '" style="width: ' . $porcentaje_avance . '%"></div>
                            </div>
                        </div>
                    </div>
                </div>';
            $editar = '<button class="btn btn-warning btn-flat btn-xs" onclick="mostrar(' . $reg[$i]["id_cvadministrativos"] . ')" title="editar"><i class="fas fa-pen"></i></button>';
            $citar = '<button class="btn btn-primary btn-flat btn-xs" onclick="citar(' . $reg[$i]["id_cvadministrativos"] . ',`' . $reg[$i]["cvadministrativos_correo"] . '` )" title="Citar a entrevista" data-toggle="modal" data-target="#modal-default"><i class="fas fa-envelope"></i></button>';
            // solo mostramos el boton de visualizar hoja de vida si tiene los datos personales llenos.
            $ver_hoja = '';
            if (!empty($reg[$i]["estado"])) {
                $ver_hoja = '<a class="btn btn-info btn-flat btn-xs" href="hv_fun_hoja_online.php?uid=' . $reg[$i]["cvadministrativos_identificacion"] . '" target="_blank" title="Ver hoja de vida"><i class="fas fa-eye"></i></a>';
            }
            $eliminar_usuario = '<button class="btn btn-danger btn-xs btn-flat" onclick="eliminar_usuario_cv(' . $reg[$i]["id_cvadministrativos"] . ')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
            if ($id_cvadministrativos_cv_eliminar == 1) {
                $botones_posicion_0 = $editar . $ver_hoja . $citar;
                if ($reg[$i]["cvadministrativos_estado"]) {
                    $botones_posicion_0 .= '<button class="btn btn-danger btn-xs btn-flat" onclick="desactivar(' . $reg[$i]["id_cvadministrativos"] . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button>';
                } else {
                    $botones_posicion_0 .= '<button class="btn btn-primary btn-xs btn-flat" onclick="activar(' . $reg[$i]["id_cvadministrativos"] . ')" title="Activar"><i class="fas fa-lock"></i></button>';
                }
                $botones_posicion_0 .= $eliminar_usuario;
                $data[] = array(
                    "0" => $botones_posicion_0,
                    "1" => $reg[$i]["cvadministrativos_nombre"],
                    "2" => $reg[$i]["cvadministrativos_identificacion"],
                    "3" => $reg[$i]["cvadministrativos_celular"],
                    "4" => $reg[$i]["cvadministrativos_correo"],
                    "5" => $reg[$i]["titulo_profesional"],
                    "6" => '<button class="btn btn-info btn-xs btn-flat" onclick="window.location.href=\'https://ciaf.edu.co/cvadmin/' . $reg[$i]["cvadministrativos_pdf"] . '\'" title="Ver PDF"><i class="fas fa-file-pdf"></i> Ver PDF</button>',
                    "7" => $usuario->fechaesp($reg[$i]["cvadministrativos_fecha"]),
                    "8" => ($reg[$i]["cvadministrativos_estado"])
                        ? '<span class="badge bg-success">Activado</span>'
                        : '<span class="badge bg-danger">Desactivado<span>',
                    "9" => $reg[$i]["cvadministrativos_cargo"],
                    "10" =>  $boton_porcentaje_avance
                );
            } else {
                $data[] = array(
                    "0" => $editar . $ver_hoja . $citar  . (($reg[$i]["cvadministrativos_estado"])
                        ? '<button class="btn btn-danger btn-xs btn-flat" onclick="desactivar(' . $reg[$i]["id_cvadministrativos"] . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button>'
                        : '<button class="btn btn-primary btn-xs btn-flat" onclick="activar(' . $reg[$i]["id_cvadministrativos"] . ')" title="Activar"><i class="fas fa-lock"></i></button>'),
                    "1" => $reg[$i]["cvadministrativos_nombre"],
                    "2" => $reg[$i]["cvadministrativos_identificacion"],
                    "3" => $reg[$i]["cvadministrativos_celular"],
                    "4" => $reg[$i]["cvadministrativos_correo"],
                    "5" => $reg[$i]["titulo_profesional"],
                    "6" => '<button class="btn btn-info btn-xs btn-flat" onclick="window.open(\'https://ciaf.edu.co/cvadmin/' . $reg[$i]["cvadministrativos_pdf"] . '.pdf\', \'_blank\')" title="Ver PDF"><i class="fas fa-file-pdf"></i> Ver PDF</button>',
                    "7" => $usuario->fechaesp($reg[$i]["cvadministrativos_fecha"]),
                    "8" => ($reg[$i]["cvadministrativos_estado"])
                        ? '<span class="badge bg-success">Activado</span>'
                        : '<span class="badge bg-danger">Desactivado<span>',
                    "9" => $reg[$i]["cvadministrativos_cargo"],
                    "10" =>  $boton_porcentaje_avance
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;


    case 'mostrar':
        $rspta = $usuario->mostrar($id_cvadministrativos);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'guardaryeditar':
        $rspta  = $usuario->editar($id_cvadministrativos, $cvadministrativos_identificacion, $cvadministrativos_nombre, $cvadministrativos_celular, $cvadministrativos_correo, $cvadministrativos_cargo);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Usuario actualizado",
                "valores" => "$id_cvadministrativos, $cvadministrativos_identificacion, $cvadministrativos_nombre, $cvadministrativos_celular,$cvadministrativos_correo,$cvadministrativos_cargo"
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "Usuario no se pudo actualizar"
            );
            echo json_encode($inserto);
        }

        break;










    case 'desactivar':
        $rspta = $usuario->desactivar($id_cvadministrativos);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        //echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
        break;

    case 'activar':
        $rspta = $usuario->activar($id_cvadministrativos);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        //echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;

    case 'contratar':
        $rspta = $usuario->contratar($id_cvadministrativos);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        //echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;

    case 'desvincular':
        $rspta = $usuario->desvincular($id_cvadministrativos);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        //echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;





    case "selectDepartamento":
        $rspta = $usuario->selectDepartamento();
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["id_departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
        }
        break;

    case "selectMunicipio":
        $rspta = $usuario->selectMunicipio();
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["id_municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
        }
        break;
    //eliminar una categoria
    case 'eliminar_usuario_cv':
         $id_cvadministrativos = $_POST['id_cvadministrativos'];
        $rspta = $usuario->eliminarUsuarioCv($id_cvadministrativos);
        echo json_encode($rspta);
        break;


    case "selectDependencia":
        $rspta = $usuario->selectDependencia();
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
        break;
}
