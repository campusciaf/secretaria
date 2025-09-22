<?php
require '../modelos/Registrar2012.php';     
$registro = new Registro();
//datos acta
switch ($_GET['op']) {
    case 'listarSangre':
        $registro->tipoSangre();
        break;
    case 'grupoEtnico':
        $registro->grupoEtnico();
        break;
    case 'nombreEtnico':
        $id = $_GET['id'];
        $registro->nombreEtnico($id);
        break;
    case 'mostrarEscuela':
        $registro->mostrarEscuela();
        break;
    case 'listar':
        $reg = $registro->listar();
        //Vamos a declarar un array
        $data = array();
        for ($i = 0; $i < count($reg); $i++) {
            $fecha_creacion = explode(" ", $reg[$i]["create_dt"])[0];

            $estado_options = '
            <select class="form-control" onchange="cambiarEstadoFallecido(\'' . $reg[$i]["identificacion"] . '\', this.value)">
                <option></option>
                <option value="Vivo" ' . ($reg[$i]["estado_fallecido"] == "Vivo" ? 'selected' : '') . '>Vivo</option>
                <option value="Fallecido" ' . ($reg[$i]["estado_fallecido"] == "Fallecido" ? 'selected' : '') . '>Fallecido</option>
            </select>';
        
            $data[] = array(
                "0" => '<div class="btn-group"> <button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg[$i]["id_estudiante"] . ')" title="Editar"> <i class="fas fa-pencil-alt"></i> </button>' . '<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#estudianteModal"onclick="mostrarIdentificacion( ' . $reg[$i]["numero_documento"] . ', ' . $reg[$i]["id_estudiante"] . ')" title="Agregar datos adicionales"><i class="fas fa-user"></i> </button>' . '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalformulario" onclick="mostrarIdentificacion( ' . $reg[$i]["numero_documento"] . ', ' . $reg[$i]["id_estudiante"] . ')" title="Agregar materias"> <i class="fas fa-book-open-reader"></i> </button>' . '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg[$i]["id_estudiante"].' )" title="Eliminar Registro"><i class="far fa-trash-alt"></i></button>',
                "1" => $reg[$i]["numero_documento"],
                "2" => $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"],
                "3" => $reg[$i]["celular"],
                "4" => $reg[$i]["email"],
                "5" => $reg[$i]["titulo_estudiante"],
                "6" => $reg[$i]["periodo_estudiante"],
                "7" => $fecha_creacion,
                "8" => $reg[$i]["estado"],
                "9" => $reg[$i]["libro"],
                "10" => $reg[$i]["folio"],
                "11" => $reg[$i]["numero_acta"],
                "12" => $reg[$i]["ano_graduacion"],
                "13" => $reg[$i]["titulo_acta"],
                "14" => $reg[$i]["periodo"],
                "15" => $estado_options,
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
    case 'guardaryeditar':
        //Datos de registro de estudiante
        $id_estudiante = isset($_POST['id_estudiante']) ? limpiarCadena($_POST["id_estudiante"]) : "";
        $tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : null;
        $identificacion = isset($_POST["identificacion"]) ? limpiarCadena($_POST["identificacion"]) : "";
        $expedido_en = isset($_POST["expedido_en"]) ? limpiarCadena($_POST["expedido_en"]) : null;
        $expedido_en = ($expedido_en == '' ? null : $expedido_en);
        $fecha_expedicion = isset($_POST["fecha_expedicion"]) ? limpiarCadena($_POST["fecha_expedicion"]) : null;
        $fecha_expedicion = ($fecha_expedicion == '' ? null : $fecha_expedicion);
        $nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
        $nombre_2 = isset($_POST["nombre_2"]) ? limpiarCadena($_POST["nombre_2"]) : "";
        $apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
        $apellidos_2 = isset($_POST["apellidos_2"]) ? limpiarCadena($_POST["apellidos_2"]) : "";
        $lugar_nacimiento = isset($_POST["lugar_nacimiento"]) ? limpiarCadena($_POST["lugar_nacimiento"]) : null;
        $lugar_nacimiento = ($lugar_nacimiento == '' ? null : $lugar_nacimiento);
        $fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? limpiarCadena($_POST["fecha_nacimiento"]) : null;
        $fecha_nacimiento = ($fecha_nacimiento == '' ? null : $fecha_nacimiento);
        $genero = isset($_POST["genero"]) ? limpiarCadena($_POST["genero"]) : null;
        $genero = ($genero == '' ? null : $genero);
        $tipo_sangre = isset($_POST["tipo_sangre"]) ? limpiarCadena($_POST["tipo_sangre"]) : null;
        $tipo_sangre = ($tipo_sangre == '' ? null : $tipo_sangre);
        $eps = isset($_POST["eps"]) ? limpiarCadena($_POST["eps"]) : null;
        $eps = ($eps == '' ? null : $eps);
        $fo_programa = isset($_POST["fo_programa"]) ? limpiarCadena($_POST["fo_programa"]) : "";
        $titulo_estudiante = isset($_POST["titulo_estudiante"]) ? limpiarCadena($_POST["titulo_estudiante"]) : null;
        $titulo_estudiante = ($titulo_estudiante == '' ? null : $titulo_estudiante);
        $escuela_ciaf = isset($_POST["escuela_ciaf"]) ? limpiarCadena($_POST["escuela_ciaf"]) : null;
        $escuela_ciaf = ($escuela_ciaf == '' ? null : $escuela_ciaf);
        $jornada_e = isset($_POST["jornada_e"]) ? limpiarCadena($_POST["jornada_e"]) : null;
        $jornada_e = ($jornada_e == '' ? null : $jornada_e);
        $periodo = isset($_POST["periodo"]) ? limpiarCadena($_POST["periodo"]) : null;
        $periodo = ($periodo == '' ? null : $periodo);
        $grupo_etnico = isset($_POST["grupo_etnico"]) ? limpiarCadena($_POST["grupo_etnico"]) : null;
        $grupo_etnico = ($grupo_etnico == '' ? null : $periodo);
        $nombre_etnico = isset($_POST["nombre_etnico"]) ? limpiarCadena($_POST["nombre_etnico"]) : null;
        $nombre_etnico = ($nombre_etnico == '' ? null : $nombre_etnico);
        $discapacidad = isset($_POST["discapacidad"]) ? limpiarCadena($_POST["discapacidad"]) : null;
        $discapacidad = ($discapacidad == '' ? null : $discapacidad);
        $nombre_discapacidad = isset($_POST["nombre_discapacidad"]) ? limpiarCadena($_POST["nombre_discapacidad"]) : null;
        $nombre_discapacidad = ($nombre_discapacidad == '' ? null : $nombre_discapacidad);
        $direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : null;
        $direccion = ($direccion == '' ? null : $direccion);
        $barrio = isset($_POST["barrio"]) ? limpiarCadena($_POST["barrio"]) : null;
        $barrio = ($barrio == '' ? null : $barrio);
        $municipio = isset($_POST["municipio"]) ? limpiarCadena($_POST["municipio"]) : null;
        $municipio = ($municipio == '' ? null : $municipio);
        $telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : null;
        $telefono = ($telefono == '' ? null : $telefono);
        $telefono2 = isset($_POST["telefono2"]) ? limpiarCadena($_POST["telefono2"]) : null;
        $telefono2 = ($telefono2 == '' ? null : $telefono2);
        $celular = isset($_POST["celular"]) ? limpiarCadena($_POST["celular"]) : null;
        $celular = ($celular == '' ? null : $celular);
        $email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : null;
        $email = ($email == '' ? null : $email);
        $nombre_colegio = isset($_POST["nombre_colegio"]) ? limpiarCadena($_POST["nombre_colegio"]) : null;
        $nombre_colegio = ($nombre_colegio == '' ? null : $nombre_colegio);
        $tipo_institucion = isset($_POST["tipo_institucion"]) ? limpiarCadena($_POST["tipo_institucion"]) : null;
        $tipo_institucion = ($tipo_institucion == '' ? null : $tipo_institucion);
        $jornada_institucion = isset($_POST["jornada_institucion"]) ? limpiarCadena($_POST["jornada_institucion"]) : null;
        $jornada_institucion = ($jornada_institucion == '' ? null : $jornada_institucion);
        $ano_terminacion = isset($_POST["ano_terminacion"]) ? limpiarCadena($_POST["ano_terminacion"]) : null;
        $ano_terminacion = ($ano_terminacion == '' ? null : $ano_terminacion);
        $ciudad_institucion = isset($_POST["ciudad_institucion"]) ? limpiarCadena($_POST["ciudad_institucion"]) : null;
        $ciudad_institucion = ($ciudad_institucion == '' ? null : $ciudad_institucion);
        $fecha_presen_icfes = isset($_POST["fecha_presen_icfes"]) ? limpiarCadena($_POST["fecha_presen_icfes"]) : null;
        $fecha_presen_icfes = ($fecha_presen_icfes == '' ? null : $fecha_presen_icfes);
        $codigo_icfes = isset($_POST["codigo_icfes"]) ? limpiarCadena($_POST["codigo_icfes"]) : null;
        $codigo_icfes = ($codigo_icfes == '' ? null : $codigo_icfes);
        $trabaja_actualmente = isset($_POST["trabaja_actualmente"]) ? limpiarCadena($_POST["trabaja_actualmente"]) : null;
        $trabaja_actualmente = ($trabaja_actualmente == '' ? null : $trabaja_actualmente);
        $cargo_en_empresa = isset($_POST["cargo_en_empresa"]) ? limpiarCadena($_POST["cargo_en_empresa"]) : null;
        $cargo_en_empresa = ($cargo_en_empresa == '' ? null : $cargo_en_empresa);
        $empresa_trabaja = isset($_POST["empresa_trabaja"]) ? limpiarCadena($_POST["empresa_trabaja"]) : null;
        $empresa_trabaja = ($empresa_trabaja == '' ? null : $empresa_trabaja);
        $sector_empresa = isset($_POST["sector_empresa"]) ? limpiarCadena($_POST["sector_empresa"]) : null;
        $sector_empresa = ($sector_empresa == '' ? null : $sector_empresa);
        $tel_empresa = isset($_POST["tel_empresa"]) ? limpiarCadena($_POST["tel_empresa"]) : null;
        $tel_empresa = ($tel_empresa == '' ? null : $tel_empresa);
        $email_empresa = isset($_POST["email_empresa"]) ? limpiarCadena($_POST["email_empresa"]) : null;
        $email_empresa = ($email_empresa == '' ? null : $email_empresa);
        $segundo_idioma = isset($_POST["segundo_idioma"]) ? limpiarCadena($_POST["segundo_idioma"]) : null;
        $segundo_idioma = ($segundo_idioma == '' ? null : $segundo_idioma);
        $cual_idioma = isset($_POST["cual_idioma"]) ? limpiarCadena($_POST["cual_idioma"]) : null;
        $cual_idioma = ($cual_idioma == '' ? null : $cual_idioma);
        $aficiones = isset($_POST["aficiones"]) ? limpiarCadena($_POST["aficiones"]) : null;
        $aficiones = ($aficiones == '' ? null : $aficiones);
        $tiene_pc = isset($_POST["tiene_pc"]) ? limpiarCadena($_POST["tiene_pc"]) : null;
        $tiene_pc = ($tiene_pc == '' ? null : $tiene_pc);
        $tiene_internet = isset($_POST["tiene_internet"]) ? limpiarCadena($_POST["tiene_internet"]) : null;
        $tiene_internet = ($tiene_internet == '' ? null : $tiene_internet);
        $tiene_hijos = isset($_POST["tiene_hijos"]) ? limpiarCadena($_POST["tiene_hijos"]) : null;
        $tiene_hijos = ($tiene_hijos == '' ? null : $tiene_hijos);
        $estado_civil = isset($_POST["estado_civil"]) ? limpiarCadena($_POST["estado_civil"]) : null;
        $estado_civil = ($estado_civil == '' ? null : $estado_civil);
        $persona_emergencia = isset($_POST["persona_emergencia"]) ? limpiarCadena($_POST["persona_emergencia"]) : null;
        $persona_emergencia = ($persona_emergencia == '' ? null : $persona_emergencia);
        $direccion_emergencia = isset($_POST["direccion_emergencia"]) ? limpiarCadena($_POST["direccion_emergencia"]) : null;
        $direccion_emergencia = ($direccion_emergencia == '' ? null : $direccion_emergencia);
        $email_emergencia = isset($_POST["email_emergencia"]) ? limpiarCadena($_POST["email_emergencia"]) : null;
        $email_emergencia = ($email_emergencia == '' ? null : $email_emergencia);
        $tel_fijo_emergencia = isset($_POST["tel_fijo_emergencia"]) ? limpiarCadena($_POST["tel_fijo_emergencia"]) : null;
        $tel_fijo_emergencia = ($tel_fijo_emergencia == '' ? null : $tel_fijo_emergencia);
        $celular_emergencia = isset($_POST["celular_emergencia"]) ? limpiarCadena($_POST["celular_emergencia"]) : null;
        $celular_emergencia = ($celular_emergencia == '' ? null : $celular_emergencia);
        if (empty($id_estudiante)) { //para registrar usuario
            $rpsta = $registro->agregar($tipo_documento, $identificacion, $expedido_en, $fecha_expedicion, $nombre, $nombre_2, $apellidos, $apellidos_2, $lugar_nacimiento, $fecha_nacimiento, $genero, $tipo_sangre, $eps, $fo_programa, $titulo_estudiante, $escuela_ciaf, $jornada_e, $periodo, $grupo_etnico, $nombre_etnico, $discapacidad, $nombre_discapacidad, $direccion, $barrio, $municipio, $telefono, $telefono2, $celular, $email, $nombre_colegio, $tipo_institucion, $jornada_institucion, $ano_terminacion, $ciudad_institucion, $fecha_presen_icfes, $codigo_icfes, $trabaja_actualmente, $cargo_en_empresa, $empresa_trabaja, $sector_empresa, $tel_empresa, $email_empresa, $segundo_idioma, $cual_idioma, $aficiones, $tiene_pc, $tiene_internet, $tiene_hijos, $estado_civil, $persona_emergencia, $direccion_emergencia, $email_emergencia, $tel_fijo_emergencia, $celular_emergencia);
            if ($rpsta) {
                $data = array("exito" => 1, "info" => "Estudiante registrado con éxito");
            } else {
                $data = array("exito" => 0, "info" => "Error al registrar al estudiante, ponte en contacto con el administrador del sistema.");
            }
        } else { // para actualziar datos del usuario
            $rspta =  $registro->editar($id_estudiante, $tipo_documento, $identificacion, $expedido_en, $fecha_expedicion, $nombre, $nombre_2, $apellidos, $apellidos_2, $lugar_nacimiento, $fecha_nacimiento, $genero, $tipo_sangre, $eps, $fo_programa, $titulo_estudiante, $escuela_ciaf, $jornada_e, $periodo, $grupo_etnico, $nombre_etnico, $discapacidad, $nombre_discapacidad, $direccion, $barrio, $municipio, $telefono, $telefono2, $celular, $email, $nombre_colegio, $tipo_institucion, $jornada_institucion, $ano_terminacion, $ciudad_institucion, $fecha_presen_icfes, $codigo_icfes, $trabaja_actualmente, $cargo_en_empresa, $empresa_trabaja, $sector_empresa, $tel_empresa, $email_empresa, $segundo_idioma, $cual_idioma, $aficiones, $tiene_pc, $tiene_internet, $tiene_hijos, $estado_civil, $persona_emergencia, $direccion_emergencia, $email_emergencia, $tel_fijo_emergencia, $celular_emergencia);
            if ($rspta) {
                $data = array("exito" => 1, "info" => "Estudiante Actualizado con éxito");
            } else {
                $data = array("exito" => 0, "info" => "Error al actualizar al estudiante, ponte en contacto con el administrador del sistema.");
            }
        }
        echo json_encode($data);
        break;


    case 'mostrar':
        $id_estudiante = isset($_POST['id_estudiante']) ? limpiarCadena($_POST["id_estudiante"]) : "";
        $rspta = $registro->mostrar($id_estudiante);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'aggMaterias':
        $identificacion2 = isset($_POST['identificacion2']) ?  $_POST['identificacion2'] : "";
        $programa_asig = isset($_POST['programa_asig']) ?  $_POST['programa_asig'] : "";
        $nombre_asig = isset($_POST['nombre_asig']) ?  $_POST['nombre_asig'] : "";
        $creditos_asig = isset($_POST['creditos_asig']) ?  $_POST['creditos_asig'] : "";
        $semestre_asig = isset($_POST['semestre_asig']) ?  $_POST['semestre_asig'] : "";
        $nota_asig = isset($_POST['nota_asig']) ?  $_POST['nota_asig'] : "";
        $periodo_materia = isset($_POST['periodo_materia']) ?  $_POST['periodo_materia'] : "";
        $jornada_asig = isset($_POST['jornada_asig']) ?  $_POST['jornada_asig'] : "";
        $consulta = $registro->aggMaterias($identificacion2, $programa_asig, $nombre_asig, $creditos_asig, $semestre_asig, $nota_asig, $periodo_materia, $jornada_asig);
        if ($consulta) {
            $data = array("exito" => 1, "info" => "Materia registrada con éxito");
        } else {
            $data = array("exito" => 0, "info" => "Error al insertar materia, ponte en contacto con el administrador del sistema.");
        }
        echo json_encode($data);
        break;
    case 'mostrarJornada':
        $registro->mostrarJornada();
        break;
    case 'mostrarprograma':
        $registro->mostrarprograma();
        break;
    case 'mostrar_datos_acta':
        $id_estudiante_acta = isset($_POST['id_estudiante_acta']) ? limpiarCadena($_POST["id_estudiante_acta"]) : "";
        $rspta = $registro->mostrar_datos_acta($id_estudiante_acta);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'listar_materias':
        $identificacion = isset($_GET['identificacion']) ?  $_GET['identificacion'] : "";
        $reg = $registro->listar_materias($identificacion);
        //Vamos a declarar un array
        $data = array();
        for ($i = 0; $i < count($reg); $i++) {
            $data[] = array(
                "0" => $reg[$i]["nombre_materia"],
                "1" => $reg[$i]["estado"],
                "2" => $reg[$i]["jornada"],
                "3" => $reg[$i]["periodo"],
                "4" => $reg[$i]["semestre"],
                "5" => $reg[$i]["nota"],
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


        


    case 'eliminar':
        // Comprobar si los parámetros se están recibiendo
        if (isset($_POST['id_estudiante'])) {
            $id_estudiante = $_POST['id_estudiante'];
            $rspta = $registro->eliminar($id_estudiante);
            if ($rspta) {
                $data = array("exito" => 1, "info" => "Estudiante eliminado con éxito");
            } else {
                $data = array("exito" => 0, "info" => "Error al eliminar el estudiante, ponte en contacto con el administrador del sistema.");
            }
            echo json_encode($data);
        } else {
            $data = array("exito" => 0, "info" => "error");
            error_log("error: " . json_encode($_POST));
            echo json_encode($data);
        }
        break;
        
    case 'guardar_editar_acta':
        $id_so = isset($_POST['id_so']) ? limpiarCadena($_POST["id_so"]) : "";
        $id_estudiante_acta = isset($_POST['id_estudiante_acta']) ? limpiarCadena($_POST["id_estudiante_acta"]) : "";
        $titulo_acta = isset($_POST['titulo_acta']) ? limpiarCadena($_POST["titulo_acta"]) : "";
        $identificacion_acta = isset($_POST['identificacion_acta']) ? limpiarCadena($_POST["identificacion_acta"]) : "";
        $estado_est = isset($_POST['estado_est']) ? limpiarCadena($_POST["estado_est"]) : "";
        $numero_acta = isset($_POST['numero_acta']) ? limpiarCadena($_POST["numero_acta"]) : "";
        $libro = isset($_POST['libro']) ? limpiarCadena($_POST["libro"]) : "";
        $folio = isset($_POST['folio']) ? limpiarCadena($_POST["folio"]) : "";
        $ano_graduacion = isset($_POST['ano_graduacion']) ? limpiarCadena($_POST["ano_graduacion"]) : "";
        $periodo_acta = isset($_POST['periodo_acta']) ? limpiarCadena($_POST["periodo_acta"]) : "";
        //para registrar acta
        if (empty($id_so)) {
            $rpsta = $registro->InsertarActa($id_estudiante_acta, $titulo_acta, $identificacion_acta, $estado_est, $numero_acta, $folio, $ano_graduacion, $periodo_acta, $libro);
            if ($rpsta) {
                $data = array("exito" => 1, "info" => "Acta registrada con éxito");
            } else {
                $data = array("exito" => 0, "info" => "Error al registrar el acta, ponte en contacto con el administrador del sistema.");
            }
        } else { // para actualziar datos de acta
            $rspta =  $registro->EditarActa($id_so, $id_estudiante_acta, $titulo_acta, $estado_est, $numero_acta, $folio, $ano_graduacion, $periodo_acta, $libro);
            if ($rspta) {
                $data = array("exito" => 1, "info" => "Acta Actualizada con éxito");
            } else {
                $data = array("exito" => 0, "info" => "Error al actualizar el acta, ponte en contacto con el administrador del sistema.");
            }
        }
        echo json_encode($data);
        break;

    case 'editar_estado_fallecido':
        $identificacion = isset($_POST['identificacion']) ? limpiarCadena($_POST['identificacion']) : '';
        $estado_fallecido = isset($_POST['estado_fallecido']) ? limpiarCadena($_POST['estado_fallecido']) : '';
        $resultado = $registro->EditarEstadoFallecido($identificacion, $estado_fallecido);
        if ($resultado) {
            $data = array("exito" => 1, "info" => "Actualizado correctamente.");
        } else {
            $data = array("exito" => 0, "info" => "Error al actualizar.");
        }
        echo json_encode($data);
        break;

    }
