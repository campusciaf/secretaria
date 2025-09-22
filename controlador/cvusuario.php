<?php
session_start();
require_once "../modelos/CvUsuario.php";
$usuario = new CvUsuario();
$id_usuario_cv = isset($_POST["id_usuario_cv"]) ? limpiarCadena($_POST["id_usuario_cv"]) : "";
$usuario_identificacion   = isset($_POST["identificacion"]) ? limpiarCadena($_POST["identificacion"]) : "";
$usuario_nombre = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
$usuario_apellido = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$usuario_clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$usuario_email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$usuario_fecha_nacimiento = isset($_POST["usuario_fecha_nacimiento"]) ? limpiarCadena($_POST["usuario_fecha_nacimiento"]) : "";
$usuario_departamento     = isset($_POST["usuario_departamento"]) ? limpiarCadena($_POST["usuario_departamento"]) : "";
$usuario_municipio = isset($_POST["usuario_municipio"]) ? limpiarCadena($_POST["usuario_municipio"]) : "";
$usuario_direccion = isset($_POST["usuario_direccion"]) ? limpiarCadena($_POST["usuario_direccion"]) : "";
$valorbusqueda = isset($_GET["valorbusqueda"]) ? limpiarCadena($_GET["valorbusqueda"]) : "";
$tipobusqueda = isset($_GET["tipobusqueda"]) ? limpiarCadena($_GET["tipobusqueda"]) : "";
$usuario_sexo = isset($_POST["sexo"]) ? limpiarCadena($_POST["sexo"]) : "";
$usuario_direccion_cv = isset($_POST["usuario_direccion_cv"]) ? limpiarCadena($_POST["usuario_direccion_cv"]) : "";
$usuario_celular_cv = isset($_POST["usuario_celular_cv"]) ? limpiarCadena($_POST["usuario_celular_cv"]) : "";
switch ($_GET["op"]) {

    case 'guardaryeditar':
        $rspta  = $usuario->editar($id_usuario_cv, $usuario_identificacion, $usuario_nombre, $usuario_apellido, $usuario_fecha_nacimiento, $usuario_departamento, $usuario_municipio, $usuario_direccion_cv, $usuario_celular_cv, $usuario_email);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Usuario actualizado",
                "valores" => "$id_usuario_cv, $usuario_identificacion, $usuario_nombre, $usuario_apellido, $usuario_fecha_nacimiento, $usuario_departamento, $usuario_municipio, $usuario_direccion_cv, $usuario_celular_cv"
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
        $rspta = $usuario->desactivar($id_usuario_cv);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        //echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
        break;
    case 'activar':
        $rspta = $usuario->activar($id_usuario_cv);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        //echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;
    case 'contratar':
        $rspta = $usuario->contratar($id_usuario_cv);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        //echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;
    case 'desvincular':
        $rspta = $usuario->desvincular($id_usuario_cv);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        //echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;
    case 'mostrar':
        $rspta = $usuario->mostrar($id_usuario_cv);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'listar':
        $rspta = $usuario->listar();
        //Vamos a declarar un array
        $data  = array();
        $reg   = $rspta;
        $id_usuario_cv_eliminar = $_SESSION["id_usuario"];
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
            $rsptatituloobtenido = $usuario->MostrarTittuloObtenido($reg[$i]["id_usuario_cv"]);
            $titulo_obtenido = is_array($rsptatituloobtenido) && isset($rsptatituloobtenido["titulo_profesional"])? $rsptatituloobtenido["titulo_profesional"]: '';

            if ($reg[$i]["estado"] == "interesado" || $reg[$i]["estado"] == "desvinculado") {
                $estado = '<button class="btn btn-success btn-flat btn-xs" onclick="contratar(' . $reg[$i]["id_usuario_cv"] . ')" title="contratar"><i class="fas fa-user-check"></i></button>';
            } elseif ($reg[$i]["estado"] == "contratado") {
                $estado = '<button class="btn btn-warning btn-flat btn-xs" onclick="desvinculado(' . $reg[$i]["id_usuario_cv"] . ')" title="Desvinculado"><i class="fas fa-user-times"></i></button>';
            } else {
                $estado = $reg[$i]["estado"];
            }
            $editar = '<button class="btn btn-warning btn-flat btn-xs" onclick="mostrar(' . $reg[$i]["id_usuario_cv"] . ')" title="editar"><i class="fas fa-pen"></i></button>';
            $ver_hoja = '<a class="btn btn-info btn-flat btn-xs" href="cv_hoja_personal.php?uid=' . $reg[$i]["id_usuario_cv"] . '" target="_blank" title="Ver hoja de vida"><i class="fas fa-eye"></i></a>';
            $citar = '<button class="btn btn-primary btn-flat btn-xs" onclick="citar(' . $reg[$i]["id_usuario_cv"] . ',`' . $reg[$i]["usuario_email"] . '` )" title="Citar a entrevista" data-toggle="modal" data-target="#modal-default"><i class="fas fa-envelope"></i></button>';

            $eliminar_usuario = '
                
                <button class="btn btn-danger btn-xs btn-flat" onclick="eliminar_usuario_cv(' . $reg[$i]["id_usuario_cv"] . ')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';

            if ($id_usuario_cv_eliminar == 1 || $id_usuario_cv_eliminar == 87) {

                $botones_posicion_0 = $editar . $ver_hoja . $citar . $estado;
                if ($reg[$i]["usuario_condicion"]) {
                    $botones_posicion_0 .= '<button class="btn btn-danger btn-xs btn-flat" onclick="desactivar(' . $reg[$i]["id_usuario_cv"] . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button>';
                } else {
                    $botones_posicion_0 .= '<button class="btn btn-primary btn-xs btn-flat" onclick="activar(' . $reg[$i]["id_usuario_cv"] . ')" title="Activar"><i class="fas fa-lock"></i></button>';
                }
                $botones_posicion_0 .= $eliminar_usuario;
                $data[] = array(
                    "0" => $botones_posicion_0,
                    "1" => $reg[$i]["usuario_nombre"] . " " . $reg[$i]["usuario_apellido"],
                    "2" => $reg[$i]["usuario_identificacion"],
                    "3" => $reg[$i]["telefono"],
                    "4" => $reg[$i]["usuario_email"],
                    "5" => $titulo_obtenido,
                    "6" => $reg[$i]["create_dt"],
                    "7" => ($reg[$i]["usuario_condicion"]) ? '<span class="badge bg-success">Activado</span>' : '<span class="badge bg-danger">Desactivado</span>',
                    "8" =>  $boton_porcentaje_avance
                );
            } else {
                $data[] = array(
                    "0" => $editar . $ver_hoja . $citar . $estado . (($reg[$i]["usuario_condicion"]) ? '<button class="btn btn-danger btn-xs btn-flat" onclick="desactivar(' . $reg[$i]["id_usuario_cv"] . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button>' : '<button class="btn btn-primary btn-xs btn-flat" onclick="activar(' . $reg[$i]["id_usuario_cv"] . ')" title="Activar"><i class="fas fa-lock"></i></button>'),
                    "1" => $reg[$i]["usuario_nombre"] . " " . $reg[$i]["usuario_apellido"],
                    "2" => $reg[$i]["usuario_identificacion"],
                    "3" => $reg[$i]["telefono"],
                    "4" => $reg[$i]["usuario_email"],
                    "5" => $titulo_obtenido,
                    "6" => $reg[$i]["create_dt"],
                    "7" => ($reg[$i]["usuario_condicion"]) ? '<span class="badge bg-success">Activado</span>' : '<span class="badge bg-danger">Desactivado</span>',
                    "8" =>  $boton_porcentaje_avance
                );
            }
            /*$usuario->editarpassword($reg[$i]["id_usuario"],$reg[$i]["usuario_identificacion"]);*/
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case 'listarbusqueda':
        switch ($tipobusqueda) {
            case "porEstado":
                $rspta = $usuario->listarPorEstado($valorbusqueda);
                break;
            case "porCategoria":
                $rspta = $usuario->listarPorCategoria($valorbusqueda);
                break;
            case "porArea":
                $rspta = $usuario->listarPorArea($valorbusqueda);
                break;
            case "porFecha":
                $rspta = $usuario->listarPorFecha($valorbusqueda);
                break;
        }
        //Vamos a declarar un array
        $data = array();
        $reg  = $rspta;
        for ($i = 0; $i < count($reg); $i++) {

            $rsptatituloobtenido = $usuario->ObtenerInformacionUsuario($reg[$i]["id_usuario_cv"]);
            if ($reg[$i]["estado"] == "interesado" || $reg[$i]["estado"] == "desvinculado") {
                $estado = '<button class="btn btn-success btn-flat btn-xs" onclick="contratar(' . $reg[$i]["id_usuario_cv"] . ')" title="contratar"><i class="fas fa-user-check"></i></button>';
            } elseif ($reg[$i]["estado"] == "contratado") {
                $estado = '<button class="btn btn-warning btn-flat btn-xs" onclick="desvinculado(' . $reg[$i]["id_usuario_cv"] . ')" title="Desvincular"><i class="fas fa-user-times"></i></button>';
            } else {
                $estado = "0";
            }
            $editar = '<button class="btn btn-warning btn-flat btn-xs" onclick="mostrar(' . $reg[$i]["id_usuario_cv"] . ')" title="editar"><i class="fas fa-pen"></i></button>';
            $data[] = array(
                "0" => $editar . '<a class="btn btn-info btn-flat btn-xs" href="cv_hoja_personal.php?uid=' . $reg[$i]["id_usuario_cv"] . '" target="_blank" title="Ver hoja de vida"><i class="fas fa-eye"></i></a><button class="btn btn-primary btn-flat btn-xs" onclick="citar(' . $reg[$i]["id_usuario_cv"] . ')" title="Citar a entrevista" data-toggle="modal" data-target="#modal-default"><i class="fas fa-envelope"></i></button>' . $estado . (($reg[$i]["usuario_condicion"]) ? '<button class="btn btn-danger btn-xs btn-flat" onclick="desactivar(' . $reg[$i]["id_usuario_cv"] . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button>' : '<button class="btn btn-primary btn-xs btn-flat" onclick="activar(' . $reg[$i]["id_usuario_cv"] . ')" title="Activar"><i class="fas fa-lock"></i></button>'),
                "1" => $rsptatituloobtenido["usuario_nombre"] . " " . $rsptatituloobtenido["usuario_apellido"],
                "2" => $rsptatituloobtenido["usuario_identificacion"],
                "3" => $reg[$i]["telefono"],
                "4" => $rsptatituloobtenido["usuario_email"],
                "5" => $reg[$i]["titulo_profesional"],
                "6" =>  $reg[$i]["create_dt"],
                "7" => ($rsptatituloobtenido["usuario_condicion"]) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
            );
            /*$usuario->editarpassword($reg[$i]["id_usuario"],$reg[$i]["usuario_clave"]);*/
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'verificar':
        $logina    = $_POST['logina'];
        $clavea    = $_POST['clave'];
        //md5 en la contraseña
        $clavehash = hash('sha256', $clavea);
        $rspta     = $usuario->verificarfuncionario($logina, $clavehash);
        $fetch     = $rspta;
        if ($fetch) {
            //Declaramos las variables de sesión
            $_SESSION['id_usuario_cv'] = $fetch["id_usuario_cv"];
            $_SESSION['usuario_nombre'] = $fetch["usuario_nombre"];
            $_SESSION['usuario_apellido'] = $fetch["usuario_apellido"];
            $_SESSION['usuario_identificacion_cv'] = $fetch["usuario_identificacion"];
            $_SESSION['usuario_email'] = $fetch["usuario_email"];

            //Obtenemos los permisos del usuario
            $marcados = $usuario->listarmarcados($fetch["id_usuario_cv"]);
            //Declaramos el array para almacenar todos los permisos marcados
            $valores = array();

            //Almacenamos los permisos marcados en el array
            $i = 0;
            while ($i < count($marcados)) {
                array_push($valores, $marcados[$i]["id_permiso"]);
                $i++;
            }
            //Determinamos los accesos del usuario
            in_array(1, $valores) ? $_SESSION['menuadmin'] = 1 : $_SESSION['menuadmin'] = 0;
            in_array(2, $valores) ? $_SESSION['iusuario'] = 1 : $_SESSION['usuario'] = 0;
            in_array(3, $valores) ? $_SESSION['permiso'] = 1 : $_SESSION['permiso'] = 0;
        }
        echo json_encode($fetch);
        break;
    case 'salir':
        //Limpiamos las variables de sesión  
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");
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
        $rspta = $usuario->eliminarUsuarioCv($id_usuario_cv);
        echo json_encode($rspta);
        break;
}
