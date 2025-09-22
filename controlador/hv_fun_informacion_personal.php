<?php
session_start();
require_once "../modelos/HvFunInformacionPersonal.php";
require_once "../modelos/HvFunEducacionFormacion.php";
$informacionPersonal = new HvFunInformacionPersonal();
$educacionFormacion = new HvFunEducacionFormacion();
//Informacion_personal
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die(json_encode(array("estatus" => 0, "valor" => "Tu sesión ha caducad, Reinicia la pagina")));
}
$hv_fun_id_informacion_personal = isset($_POST['hv_fun_id_informacion_personal']) ? $_POST['hv_fun_id_informacion_personal'] : "";
$nombres = isset($_POST['nombres']) ? $_POST['nombres'] : "";
$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : "";
$fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : "";
$fecha_nacimiento = empty($fecha_nacimiento) ? NULL : $fecha_nacimiento;
$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : "";
$estado_civil = isset($_POST['estado_civil']) ? $_POST['estado_civil'] : "";
$ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : "";
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : "";
$celular = isset($_POST['celular']) ? $_POST['celular'] : "";
$nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : "";
$pagina_web = isset($_POST['pagina_web']) ? $_POST['pagina_web'] : "";
$titulo_profesional = isset($_POST['titulo_profesional']) ? $_POST['titulo_profesional'] : "";
$categoria_profesion = isset($_POST['categoria_profesion']) ? $_POST['categoria_profesion'] : "";
$situacion_laboral = isset($_POST['situacion_laboral']) ? $_POST['situacion_laboral'] : "";
$resumen_perfil = isset($_POST['resumen_perfil']) ? $_POST['resumen_perfil'] : "";
$experiencia_docente = isset($_POST['view2']) ? $_POST['view2'] : "";
$usuario_imagen = isset($_POST['usuario_imagen']) ? $_POST['usuario_imagen'] : "";
//experiencialaboral
$id_experiencia = isset($_POST['id_experiencia']) ? $_POST['id_experiencia'] : "";
$id_formacion = isset($_POST['id_formacion']) ? $_POST['id_formacion'] : "";
$nombre_empresa = isset($_POST['nombre_empresa']) ? $_POST['nombre_empresa'] : "";
$cargo_empresa = isset($_POST['cargo_empresa']) ? $_POST['cargo_empresa'] : "";
$desde_cuando = isset($_POST['desde_cuando']) ? $_POST['desde_cuando'] : "";
// $hasta_cuando = isset($_POST['hasta_cuando']) ? $_POST['hasta_cuando'] : "";
$hasta_cuando = isset($_POST['hasta_cuando']) && $_POST['hasta_cuando'] !== '' ? $_POST['hasta_cuando'] : null;

$mas_detalles = isset($_POST['mas_detalles']) ? $_POST['mas_detalles'] : "";
// $id_cvadministrativos = isset($_POST['id_cvadministrativos'])?$_POST['id_cvadministrativos']:"";

// datos de emergencia
$nombre_emergencia = isset($_POST['nombre_emergencia']) ? $_POST['nombre_emergencia'] : "";
$parentesco = isset($_POST['parentesco']) ? $_POST['parentesco'] : "";
$numero_telefonico_emergencia = isset($_POST['numero_telefonico_emergencia']) ? $_POST['numero_telefonico_emergencia'] : "";
//campos nuevos
$genero = isset($_POST['genero']) ? $_POST['genero'] : "";
$genero_otro = isset($_POST['genero_otro']) ? $_POST['genero_otro'] : "";
$tipo_vivienda = isset($_POST['tipo_vivienda']) ? $_POST['tipo_vivienda'] : "";
$estrato = isset($_POST['estrato']) ? $_POST['estrato'] : "";
$hijos_menores_10 = isset($_POST['hijos_menores_10']) ? $_POST['hijos_menores_10'] : "";
$numero_hijos = isset($_POST['numero_hijos']) ? $_POST['numero_hijos'] : "";
$personas_a_cargo = isset($_POST['personas_a_cargo']) ? $_POST['personas_a_cargo'] : "";
$nivel_escolaridad = isset($_POST['nivel_escolaridad']) ? $_POST['nivel_escolaridad'] : "";
$trabajo_actual = isset($_POST['trabajo_actual']) ? $_POST['trabajo_actual'] : 0;
// subir imagen certificado_laboral.
$certificado_laboral = isset($_FILES['certificado_laboral']) ? $_FILES['certificado_laboral'] : "";

$cedula = $_SESSION["usuario_identificacion"];
$rspta_usuario = $informacionPersonal->cv_traerIdUsuario($cedula);
// traemos el id del usuario 
$id_cvadministrativos = $rspta_usuario["id_cvadministrativos"];
$porcentaje_actual = $rspta_usuario["porcentaje_avance"];
$nuevo_porcentaje = $porcentaje_actual;
switch ($_GET['op']) {
    case 'guardaryeditar':
        //die(json_encode($rspta_usuario["id_cvadministrativos"]));
        if (empty($hv_fun_id_informacion_personal)) {
            $rspta = $informacionPersonal->cv_insertar($id_cvadministrativos, $fecha_nacimiento, $estado_civil, $departamento, $ciudad, $direccion, $celular, $nacionalidad, $pagina_web, $titulo_profesional, $categoria_profesion,  $situacion_laboral, $resumen_perfil, $experiencia_docente, $nombre_emergencia, $parentesco, $numero_telefonico_emergencia, $genero, $genero_otro, $tipo_vivienda, $estrato, $hijos_menores_10, $numero_hijos, $personas_a_cargo, $nivel_escolaridad);

            $conteo = $informacionPersonal->CuentoRegistrosDatosPersonales($id_cvadministrativos);
            $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
            if ($rspta) {
                $nuevo_porcentaje = 11;
                if ($porcentaje_actual < $nuevo_porcentaje) {
                    $informacionPersonal->actualizar_porcentaje_personal($nuevo_porcentaje, $id_cvadministrativos);
                    $porcentaje_actual = $informacionPersonal->obtener_porcentaje_actual($id_cvadministrativos);
                }
                $inserto = array(
                    "estatus" => 1,
                    "valor" => "Información Actualizada",
                    "nuevo_porcentaje" => $porcentaje_actual,
                    "total_registros" => $totalRegistros,

                );
                echo json_encode($inserto);
            } else {
                $inserto = array(
                    "estatus" => 0,
                    "valor" => "La información no se pudo Insertada con éxito $id_cvadministrativos - $hv_fun_id_informacion_personal"
                );
                echo json_encode($inserto);
            }
        } else {
            $rspta = $informacionPersonal->cv_editar($id_cvadministrativos, $fecha_nacimiento, $estado_civil, $departamento, $ciudad, $direccion, $celular, $nacionalidad, $pagina_web, $titulo_profesional, $categoria_profesion,  $situacion_laboral, $resumen_perfil, $experiencia_docente, $hv_fun_id_informacion_personal, $nombre_emergencia, $parentesco, $numero_telefonico_emergencia, $genero, $genero_otro, $tipo_vivienda, $estrato, $hijos_menores_10, $numero_hijos, $personas_a_cargo, $nivel_escolaridad);


            // $nombreCompleto = $nombres . ' ' . $apellidos;

            $conteo = $informacionPersonal->CuentoRegistrosDatosPersonales($id_cvadministrativos);
            $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
            if ($rspta) {
                $rspta2 = $informacionPersonal->editarUser($nombres, $apellidos, $id_cvadministrativos);
                if ($rspta2) {
                    //si el campo de procentaje esta igual a 0 lo modifica,si es mayor de 0 no lo modifica.
                    $nuevo_porcentaje = 11;
                    if ($porcentaje_actual < $nuevo_porcentaje) {
                        $informacionPersonal->actualizar_porcentaje_personal($nuevo_porcentaje, $id_cvadministrativos);
                        $porcentaje_actual = $informacionPersonal->obtener_porcentaje_actual($id_cvadministrativos);
                    }
                    $_SESSION['usuario_nombre'] = $nombres;
                    $_SESSION['usuario_apellido'] = $apellidos;
                    $inserto = array(
                        "estatus" => 1,
                        "valor" => "Información Actualizada ",
                        "nuevo_porcentaje" => $porcentaje_actual,
                        "total_registros" => $totalRegistros,
                    );
                }
                echo json_encode($inserto);
            } else {
                $inserto = array(
                    "estatus" => 0,
                    "valor" => "La información no se pudo actualizar"
                );
                echo json_encode($inserto);
            }
        }
        break;

    case 'guardaryeditarexperiencialaboral':


        //revisar si el tipo de archivo es compatible con los que deseamos guardar en la base de datos 
        $file_type = $certificado_laboral['type'];
        $allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf", ""); //archivos permitidos
        if (!in_array($file_type, $allowed)) {
            $inserto = array(
                "estatus" => 0,
                "valor" => "Formato de imagen no reconocido"
            );
            echo json_encode($inserto);
            exit();
        }
        if (empty($id_experiencia)) {
            $rspta = $informacionPersonal->cv_insertarExperiencia($id_cvadministrativos, $nombre_empresa, $cargo_empresa, $desde_cuando, $hasta_cuando, $mas_detalles, "imagen", $trabajo_actual);
            if ($rspta) {
                $conteo = $educacionFormacion->CuentoRegistros($id_cvadministrativos);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($totalRegistros >= 2 && $porcentaje_actual < 33) {
                    // Aumenta a 20% si tiene 2 o más registros y aún no llega
                    $nuevo_porcentaje = 33;
                    $educacionFormacion->actualizar_porcentaje_personal($nuevo_porcentaje, $id_cvadministrativos);
                }
                $carpeta_destino = '../cv_funcionarios/certificado_laboral/';
                $url_imagen = '../cv_funcionarios/certificado_laboral/';
                if ($file_type == "application/pdf") {
                    $img1path = $carpeta_destino . "certificado_U" . $id_usuario . "_F" . $rspta . ".pdf";
                    $url_imagen = $url_imagen . "certificado_U" . $id_usuario . "_F" . $rspta . ".pdf";
                } else {
                    $img1path = $carpeta_destino . "certificado_U" . $id_usuario . "_F" . $rspta . ".jpg";
                    $url_imagen = $url_imagen . "certificado_U" . $id_usuario . "_F" . $rspta . ".jpg";
                }
                if ($file_type == "") {
                    $inserto = array(
                        "estatus" => 1,
                        "valor" => "Información Guardada",
                        "total_registros" => $totalRegistros,
                        "porcentaje" => $nuevo_porcentaje
                    );
                    echo json_encode($inserto);
                } else {
                    if (move_uploaded_file($_FILES['certificado_laboral']['tmp_name'], $img1path)) {
                        $rspta2 = $informacionPersonal->editarCertificadoLabral($rspta, $url_imagen);
                        if ($rspta2) {
                            $conteo = $informacionPersonal->CuentoRegistros($id_cvadministrativos);
                            $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                            if ($totalRegistros >= 2 && $porcentaje_actual < 22) {
                                // Aumenta a 22% si tiene 2 o más registros y aún no llega
                                $nuevo_porcentaje = 22;
                                $informacionPersonal->actualizar_porcentaje_personal($nuevo_porcentaje, $id_cvadministrativos);
                            }
                            $inserto = array(
                                "estatus" => 1,
                                "valor" => "Información Guardada",
                                "total_registros" => $totalRegistros,
                                "porcentaje" => $nuevo_porcentaje,
                                "id_cvadministrativos" => $id_cvadministrativos,
                            );
                        }
                        echo json_encode($inserto);
                    }
                }
            } else {
                $inserto = array(
                    "estatus" => 0,
                    "valor" => "La información no se pudo guardar",
                    "total_registros" => $totalRegistros,
                    "porcentaje" => $nuevo_porcentaje
                );
                echo json_encode($inserto);
            }
        } else {
            $rspta = $informacionPersonal->cveditarExperiencia($id_cvadministrativos, $nombre_empresa, $cargo_empresa, $desde_cuando, $hasta_cuando, $mas_detalles, $id_experiencia, "imagen", $trabajo_actual);
            if ($rspta) {
                $conteo = $informacionPersonal->CuentoRegistros($id_cvadministrativos);
                $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
                if ($totalRegistros >= 2 && $porcentaje_actual < 33) {
                    // Aumenta a 20% si tiene 2 o más registros y aún no llega
                    $nuevo_porcentaje = 33;
                    $informacionPersonal->actualizar_porcentaje_personal($nuevo_porcentaje, $id_cvadministrativos);
                }
                $carpeta_destino = '../cv_funcionarios/certificados_estudio_funcionarios/';
                $url_imagen = '../cv_funcionarios/certificados_estudio_funcionarios/';

                if ($file_type == "application/pdf") {
                    $img1path = $carpeta_destino . "certificado_U" . $id_cvadministrativos . "_F" . $id_experiencia . ".pdf";
                    $url_imagen = $url_imagen . "certificado_U" . $id_cvadministrativos . "_F" . $id_experiencia . ".pdf";
                } else {
                    $img1path = $carpeta_destino . "certificado_U" . $id_cvadministrativos . "_F" . $id_experiencia . ".jpg";
                    $url_imagen = $url_imagen . "certificado_U" . $id_cvadministrativos . "_F" . $id_experiencia . ".jpg";
                }
                if ($file_type == "") {
                    $inserto = array(
                        "estatus" => 1,
                        "valor" => "Información Actualizada, Recuerda anexar el certificado",
                        "porcentaje" => $nuevo_porcentaje
                    );
                    echo json_encode($inserto);
                } else {
                    if (move_uploaded_file($_FILES['certificado_laboral']['tmp_name'], $img1path)) {
                        $rspta = $informacionPersonal->editarCertificadoLabral($id_experiencia, $url_imagen);
                        if ($rspta) {
                            $inserto = array(
                                "estatus" => 1,
                                "valor" => "Información Actualizada",
                                "porcentaje" => $nuevo_porcentaje
                            );
                        }
                        echo json_encode($inserto);
                    }
                }



                // $inserto = array(
                //     "estatus" => 1,
                //     "valor" => "Información Guardada",
                //     "porcentaje" => $nuevo_porcentaje
                // );
                // echo json_encode($inserto);
            } else {
                $inserto = array(
                    "estatus" => 0,
                    "valor" => "La información no se pudo guardar",
                    "porcentaje" => $nuevo_porcentaje
                );
                echo json_encode($inserto);
            }
        }
        break;





    //experiencia_laboral
    case 'guardaryeditarEducacion':
        if (empty($id_experiencia)) {
            $rspta = $informacionPersonal->cv1_insertarEducacion($id_cvadministrativos, $nombre_empresa, $cargo_empresa, $desde_cuando, $hasta_cuando, $mas_detalles, "$imagen");
            // print_r($rspta);
            if ($rspta) {
                $inserto = array(
                    "estatus" => 1,
                    "valor" => "Información Guardada"
                );
                echo json_encode($inserto);
            } else {
                $inserto = array(
                    "estatus" => 0,
                    "valor" => "La información no se pudo guardar"
                );
                echo json_encode($inserto);
            }
        } else {
            $rspta = $EducacionFormacion->editareducacion($id_cvadministrativos, $nombre_empresa, $cargo_empresa, $desde_cuando, $hasta_cuando, $mas_detalles, $id_educacion);
            if ($rspta) {
                $inserto = array(
                    "estatus" => 1,
                    "valor" => "Información Guardada"
                );
                echo json_encode($inserto);
            } else {
                $inserto = array(
                    "estatus" => 0,
                    "valor" => "La información no se pudo guardar"
                );
                echo json_encode($inserto);
            }
        }
        break;

    case 'guardaryeditarImagen':
        $file_type = $_FILES['foto']['type'];
        $allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png");
        if (!in_array($file_type, $allowed)) {
            $inserto = array(
                "estatus" => 0,
                "valor" => "Formato de imagen no reconocido"
            );
            echo json_encode($inserto);
            exit();
        }
        $target_path = '../cv_funcionarios/usuarios';
        $img1path = $target_path . "" . $_SESSION['usuario_identificacion'] . ".jpg";
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $img1path)) {
            $usuario_imagen = $_SESSION['usuario_identificacion'] . ".jpg";
            $rspta = $informacionPersonal->editarImagen($id_cvadministrativos, $usuario_imagen);
            if ($rspta) {
                $_SESSION['usuario_imagen_cv'] = $_SESSION['usuario_identificacion'] . ".jpg";
                $inserto = array(
                    "estatus" => 1,
                    "valor" => "Información Guardada",
                    "imagen" => $usuario_imagen
                );
            }
            echo json_encode($inserto);
        }
        break;
    //experiencia_laboral

    case 'mostrarexperiencias':

        $experiencias_stmt = $informacionPersonal->cv_listarExperiencias($id_cvadministrativos);
        if ($experiencias_stmt->rowCount() > 0) {
            $experiencias_arr = array();
            while ($row_experiencias = $experiencias_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_experiencias);
                $experiencias_arr[] = array(
                    'id_cvadministrativos' => $id_cvadministrativos,
                    'nombre_empresa' => $nombre_empresa,
                    'cargo_empresa' => $cargo_empresa,
                    'desde_cuando' => $desde_cuando,
                    'hasta_cuando' => $hasta_cuando,
                    'mas_detalles' => $mas_detalles,
                    'certificado_laboral' => $certificado_laboral,
                    'id_experiencia' => $id_experiencia
                );
            }
        } else {
            $experiencias_arr[] = array(
                'id_cvadministrativos' => "0",
                'nombre_empresa' => "",
                'cargo_empresa' => "",
                'desde_cuando' => "",
                'hasta_cuando' => "",
                'mas_detalles' => "",
                'certificado_laboral' => "",
                'id_experiencia' => ""
            );
        }
        echo (json_encode($experiencias_arr));

        //print_r($experiencias_stmt);
        break;
    case 'eliminarExperiencia':
        $rspta = $informacionPersonal->cv_eliminarExperiencia($id_experiencia);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Información Elimanada"
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo eliminar"
            );
            echo json_encode($inserto);
        }
        break;
    case 'verExperienciaEspecifica':
        $experiencias_stmt = $informacionPersonal->cv_listarExperienciaEspecifica($id_experiencia);
        if ($experiencias_stmt->rowCount() > 0) {
            $experiencias_arr = array();
            $row_experiencias = $experiencias_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row_experiencias);
            $experiencias_arr[] = array(
                'id_cvadministrativos' => $id_cvadministrativos,
                'nombre_empresa' => $nombre_empresa,
                'cargo_empresa' => $cargo_empresa,
                'desde_cuando' => $desde_cuando,
                'hasta_cuando' => $hasta_cuando,
                'mas_detalles' => $mas_detalles,
                'certificado_laboral' => $certificado_laboral,
                'id_experiencia' => $id_experiencia
            );
        } else {
            $experiencias_arr[] = array(
                'id_cvadministrativos' => "0",
                'nombre_empresa' => "",
                'cargo_empresa' => "",
                'desde_cuando' => "",
                'hasta_cuando' => "",
                'mas_detalles' => "",
                'certificado_laboral' => "",
                'id_experiencia' => ""
            );
        }
        echo (json_encode($experiencias_arr));
        break;

    case 'mostrarEducacion':
        $educacions_stmt = $educacionFormacion->cv_listareducacion($_SESSION["usuario_identificacion"]);
        if ($educacions_stmt->rowCount() > 0) {
            $educacions_arr = array();
            while ($row_educacions = $educacions_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_educacions);
                $educacions_arr[] = array(
                    'id_cvadministrativos' => $id_cvadministrativos,
                    'nombre_empresa' => $nombre_empresa,
                    'cargo_empresa' => $cargo_empresa,
                    'desde_cuando' => $desde_cuando,
                    'hasta_cuando' => $hasta_cuando,
                    'mas_detalles' => $mas_detalles,
                    'id_educacion' => $id_educacion
                );
            }
        } else {
            $educacions_arr[] = array(
                'id_cvadministrativos' => "0",
                'nombre_empresa' => "",
                'cargo_empresa' => "",
                'desde_cuando' => "",
                'hasta_cuando' => "",
                'mas_detalles' => "",
                'id_experiencia' => ""
            );
        }
        echo (json_encode($experiencias_arr));
        break;
    case 'eliminarExperiencia':
        $rspta = $informacionPersonal->cv_eliminarExperiencia($id_experiencia);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Información Elimanada"
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo eliminar"
            );
            echo json_encode($inserto);
        }
        break;

    // laboral
    case 'verExperienciaLaboral':
        $experiencias_stmt = $informacionPersonal->cv_listarExperienciaEspecifica($id_experiencia);
        if ($experiencias_stmt->rowCount() > 0) {
            $experiencias_arr = array();
            $row_experiencias = $experiencias_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row_experiencias);
            $experiencias_arr[] = array(
                'id_cvadministrativos' => $id_cvadministrativos,
                'nombre_empresa' => $nombre_empresa,
                'cargo_empresa' => $cargo_empresa,
                'desde_cuando' => $desde_cuando,
                'hasta_cuando' => $hasta_cuando,
                'mas_detalles' => $mas_detalles,
                'estado_trabajo_actual' => $estado_trabajo_actual,
                'id_experiencia' => $id_experiencia
            );
        } else {
            $experiencias_arr[] = array(
                'id_cvadministrativos' => "0",
                'nombre_empresa' => "",
                'cargo_empresa' => "",
                'desde_cuando' => "",
                'hasta_cuando' => "",
                'mas_detalles' => "",
                'estado_trabajo_actual' => "",
                'id_experiencia' => ""
            );
        }
        echo (json_encode($experiencias_arr));
        break;
    // educacion y formacion
    case 'verEducacionFormacion':
        $experiencias_stmt = $informacionPersonal->cv_listarEducacionFormacion($id_formacion);
        if ($experiencias_stmt->rowCount() > 0) {
            $experiencias_arr = array();
            $row_experiencias = $experiencias_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row_experiencias);
            $experiencias_arr[] = array(
                'id_cvadministrativos' => $id_cvadministrativos,
                'institucion_academica' => $institucion_academica,
                'titulo_obtenido' => $titulo_obtenido,
                'desde_cuando_f' => $desde_cuando_f,
                'hasta_cuando_f' => $hasta_cuando_f,
                'mas_detalles_f' => $mas_detalles_f,
                'certificado_educacion' => $certificado_educacion,
                'nivel_formacion' => $nivel_formacion,
                'id_formacion' => $id_formacion
            );
        } else {
            $experiencias_arr[] = array(
                'id_cvadministrativos' => "0",
                'institucion_academica' => "",
                'titulo_obtenido' => "",
                'desde_cuando_f' => "",
                'hasta_cuando_f' => "",
                'mas_detalles_f' => "",
                'certificado_educacion' => "",
                'nivel_formacion' => "",
                'id_formacion' => ""
            );
        }
        echo (json_encode($experiencias_arr));
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

    // actualizamos el estado de la experiencia docente.
    case 'ActualizarEstadoExperienciaDocente':
        //devuelve si o no en 1 si 0 no.
        $valor = isset($_POST['valor']) ? $_POST['valor'] : "";
        // id del usuario que lo subio.
        $id_cvadministrativos = isset($_POST['id_cvadministrativos']) ? $_POST['id_cvadministrativos'] : "";
        $rspta = $informacionPersonal->editarEstadoExperienciaDocente($id_cvadministrativos, $valor);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Información Actualizada"
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo Actualizar"
            );
            echo json_encode($inserto);
        }
        break;


    // actualizamos el estado de la Politicamente Expuesto.
    case 'ActualizarEstadoPoliticamenteExpuesto':
        //devuelve si o no en 1 si 0 no.
        $valor = isset($_POST['valor']) ? $_POST['valor'] : "";
        // id del usuario que lo subio.
        $id_cvadministrativos = isset($_POST['id_cvadministrativos']) ? $_POST['id_cvadministrativos'] : "";
        $rspta = $informacionPersonal->editarEstadoPoliticamenteExpuesto($id_cvadministrativos, $valor);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Información Actualizada"
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo Actualizar"
            );
            echo json_encode($inserto);
        }
        break;
}
