<?php
require_once "../modelos/SofiAtrasoPrograma.php";
//modelo en el cual estan las funciones a base de datos 
$consulta = new SofiAtrasoPrograma();
session_start();
//creamos array con valores del mes para añadirlos al mail
$nombres_mes = array( "1" => "Enero", "2" => "Febrero", "3" => "Marzo", "4" => "Abril", "5" => "Mayo", "6" => "Junio", "7" => "Julio", "8" => "Agosto", "9" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
//dependiendo de la opcion que envien por el GET, el switch determinara donde entrar
switch ($_GET['op']) {
    case "selectPrograma":
        $rspta = $consulta->selectProgramas();
        echo "<option value='' selected disabled>- Selecciona un programa -</option>";
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["programa"] . "'>" . $rspta[$i]["programa"] . "</option>";
        }
        break;
    case 'listarAtrasados': //Listar todos los financiados que esten a 3 dias de cumplir su cuota
        $programa = isset($_POST["programa"]) ? $_POST["programa"] : "";
        //echo $programa;
        //hacemos peticion al modelo
        $rsta = $consulta->listarAtrasados($programa);
        //creamos un array
        $array = array();
        //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
        if (count($rsta) > 0) {
            for ($i = 1; $i < count($rsta); $i++) {
                $verDetalles = '<button class="btn bg-teal btn-sm" data-toggle="modal" onclick="verInfoSolicitante(' . $rsta[$i]["id_persona"] . ')" data-target="#verInfoSolicitante"><i data-toggle="tooltip" class="fa-solid fa-user" data-original-title="Ver detalles"></i></button>';
                $tareas = '<button class="btn bg-lightblue btn-sm" title="Ver seguimientos" data-toggle="modal" onclick="verHistorial(' . $rsta[$i]["id_credencial"] . ')" data-target="#verTareas"><i data-toggle="tooltip" class="fas fa-eye" data-original-title="Ver y Añadir Seguimientos"></i></button>';
                $cuotas = '<button class="btn bg-yellow btn-sm" data-toggle="modal" onclick="verCuotas(' . $rsta[$i]["consecutivo"] . ')" data-target="#modal_cuotas"><i data-toggle="tooltip" data-original-title="Información Cuotas" class="fas fa-calendar-alt"></i></button>';
                $anadir = '<button class="btn bg-purple btn-sm" title="Nuevo seguimiento o tarea" data-toggle="modal" onclick="agregarTareaSegui(' . $rsta[$i]["id_credencial"] . ', ' . $rsta[$i]["id_persona"] . ')" data-target="#anadirTareas"><i data-toggle="tooltip" class="fa-solid fa-plus data-original-title="Añadir Seguimientos"></i></button>';

                $celular_estudiante = $consulta->traerCelularEstudiante($rsta[$i]["numero_documento"]);
                $mensajes_no_vistos = 0;
                if (isset($rsta[$i]["celular"])) {
                    $estilo_whatsapp = 'btn-success';
                    $numero_celular = $rsta[$i]["celular"];
                    $registro_whatsapp = $consulta->obtenerRegistroWhastapp($numero_celular);
                    $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
                } else {
                    $estilo_whatsapp = 'btn-danger disabled';
                    $numero_celular = '';
                }
                $boton_whatsapp = '
                <button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                    <i class="fab fa-whatsapp"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        ' . $mensajes_no_vistos . '
                    </span>
                </button>';
                
                
                $array[] = array(
                    "0" => "<div class='btn-group'>$verDetalles $cuotas $tareas $anadir $boton_whatsapp </div>",
                    "1" => $rsta[$i]["numero_documento"],
                    "2" => $rsta[$i]["nombres"] . " " . $rsta[$i]["apellidos"],
                    "3" => $rsta[$i]["celular"],
                    "4" => $rsta[$i]["email"],
                    "5" => $rsta[$i]["semestre"],
                    "6" => $rsta[$i]["jornada"],
                    "7" => $rsta[$i]["labora"],
                    "8" => $consulta->cantCuotasAtrasado($rsta[$i]["consecutivo"])["num_cuotas"],
                    "9" => $consulta->diferenciaFechas($rsta[$i]["fecha_pago"], date("Y-m-d")) . " días",
                    "10" => $rsta[$i]["total_deuda"],
                    "11" => $rsta[$i]["periodo"]
                );
            }
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
        //Muestra la informacion especifica del solicitante
    case 'verInfoSolicitante':
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->verInfoSolicitante($id_persona);
        if ($rsta >= 1) {
            $array = array(
                "exito" => 1,
                "id_persona" => $rsta["id_persona"],
                "tipo_documento" => $rsta["tipo_documento"],
                "numero_documento" => $rsta["numero_documento"],
                "nombres" => $rsta["nombres"],
                "apellidos" => $rsta["apellidos"],
                "fecha_nacimiento" => $rsta["fecha_nacimiento"],
                "direccion" => $rsta["direccion"],
                "ciudad" => $rsta["ciudad"],
                "telefono" => $rsta["telefono"],
                "celular" => $rsta["celular"],
                "email" => $rsta["email"],
                "ocupacion" => $rsta["ocupacion"],
                "periodo" => $rsta["periodo"],
            );
        } else {
            $array = array(
                "exito" => 0
            );
        }
        echo json_encode($array);
        break;
        //Muestra las referencias del solicitante
    case 'verRefeSolicitante':
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->verRefeSolicitante($id_persona);
        if ($rsta >= 1) {
            for ($i = 0; $i < count($rsta); $i++) {
                $array[] = array(
                    "exito" => 1,
                    "tipo_referencia" => $rsta[$i]["tipo_referencia"],
                    "nombre" => $rsta[$i]["nombre"],
                    "telefono" => $rsta[$i]["telefono"],
                    "celular" => $rsta[$i]["celular"],
                    "tipo_cuenta" => $rsta[$i]["tipo_cuenta"],
                    "numero_cuenta" => $rsta[$i]["numero_cuenta"],
                );
            }
        } else {
            $array = array(
                "exito" => 0
            );
        }
        echo json_encode($array);
        break;
        //ver las tareas del aprobado
    case "verTareas":
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->verTareas($id_persona);
        $array = array();
        for ($i = 0; $i < count($rsta); $i++) {
            $array[] = array(
                "0" => $rsta[$i]["tarea_motivo"],
                "1" => $rsta[$i]["tarea_observacion"],
                "2" => $rsta[$i]["tarea_fecha"],
                "3" => $rsta[$i]["tarea_hora"],
                "4" => $rsta[$i]["usuario_nombre"] . " " . $rsta[$i]["usuario_nombre_2"] . " " . $rsta[$i]["usuario_apellido"] . " " . $rsta[$i]["usuario_apellido_2"]
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
        //ver los seguimientos del aprobado    
    case "verSeguimientos":
        $id_credencial = isset($_POST["id_credencial"]) ? $_POST["id_credencial"] :"";
        if(empty($id_credencial)) die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->verSeguimientos($id_credencial);
        $array = array();
        for ($i = 0; $i < count($rsta); $i++) {
            $array[] = array(
                "0" => $rsta[$i]["seg_tipo"],
                "1" => $rsta[$i]["seg_descripcion"],
                "2" => $rsta[$i]["created_at"],
                "3" => $rsta[$i]["usuario_nombre"] . " " . $rsta[$i]["usuario_nombre_2"] . " " . $rsta[$i]["usuario_apellido"] . " " . $rsta[$i]["usuario_apellido_2"]
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
    case 'guardarTareaSofi': //Guarda la tarea
        $id_usuario = $_SESSION['id_usuario'];

        $id_persona = isset($_POST["id_persona_tarea_sofi"]) ? $_POST["id_persona_tarea_sofi"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $tarea_motivo = isset($_POST["tarea_motivo"]) ? limpiarCadena($_POST["tarea_motivo"]) : "";
        $tarea_observacion = isset($_POST["tarea_descripcion_sofi"]) ? limpiarCadena($_POST["tarea_descripcion_sofi"]) : "";
        $tarea_hora = isset($_POST["tarea_hora"]) ? limpiarCadena($_POST["tarea_hora"]) : "";
        $tarea_fecha = isset($_POST["tarea_fecha"]) ? limpiarCadena($_POST["tarea_fecha"]) : "";
        $rsta = $consulta->insertarTarea($id_persona, $id_usuario, $tarea_motivo, $tarea_observacion, $tarea_fecha, $tarea_hora);
        if ($rsta) {
            $array = array("exito" => 1, "info" => "Tarea agregada con exito", "id_persona" => $id_persona);
        } else {
            $array = array("exito" => 0, "info" => "Error al agregar la tarea");
        }
        echo json_encode($array);
        break;
    case 'guardarSeguimientos': //Guarda El seguimiento
        $id_usuario = $_SESSION['id_usuario'];

        $id_persona = isset($_POST["id_persona_seguimiento_sofi"]) ? $_POST["id_persona_seguimiento_sofi"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $id_credencial = isset($_POST["id_credencial_seguimiento"]) ? $_POST["id_credencial_seguimiento"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $tipo = isset($_POST["seg_tipo_sofi"]) ? limpiarCadena($_POST["seg_tipo_sofi"]) : "";
        $descripcion = isset($_POST["seg_descripcion_sofi"]) ? limpiarCadena($_POST["seg_descripcion_sofi"]) : "";

        $rsta = $consulta->insertarSeguimiento($descripcion, $tipo, $id_usuario, $id_persona, $id_credencial);
        if ($rsta) {
            $array = array("exito" => 1, "info" =>"Seguimiento realizado con exito", "id_persona" =>$id_persona, "id_credencial" => $id_credencial);
        } else {
            $array = array("exito" => 0, "info" => "Error al agregar el seguimiento");
        }
        echo json_encode($array);
        break;
    case 'verCuotas': //lista las cuotas del aprobado
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->verCuotas($consecutivo);
        $array = array();
        $hoy = date("Y-m-d");
        for ($i = 0; $i < count($rsta); $i++) {
            if ($rsta[$i]["estado"] == "A Pagar" && $hoy >= $rsta[$i]["fecha_pago"]) {
                $estado = '<font color="red"> Atrasado </font>';
            } else if ($rsta[$i]["estado"] == "Abonado") {
                $estado = '<font color="orange"> Abonado </font>';
            } else if ($rsta[$i]["estado"] == "Pagado") {
                $estado = '<font color="green"> Pagado </font>';
            } else {
                $estado = '<font color="blue"> A Pagar </font>';
            }

            $array[] = array(
                "0" => $estado,
                "1" => $rsta[$i]["numero_cuota"],
                "2" => $rsta[$i]["valor_cuota"],
                "3" => $rsta[$i]["valor_pagado"],
                "4" => $rsta[$i]["fecha_pago"],
                "5" => $rsta[$i]["plazo_pago"],
                "6" => ($rsta[$i]["estado"] == "Pagado") ? 0 : $consulta->diferenciaFechas($rsta[$i]["fecha_pago"], $hoy) . " días"
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array,
            "nombreAprobado" => $rsta[0]["nombres"] . " " . $rsta[0]["apellidos"]
        );
        echo json_encode($results);
        break;
}
