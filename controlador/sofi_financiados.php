<?php
require_once("../public/sofi_mail/send.php");
require_once("../public/sofi_mail/templatePreAprobado.php");
require_once "../modelos/SofiFinanciados.php";
$consulta = new SofiFinanciados();
$rsta = $consulta->periodoActualyAnterior();
$periodo_actual = $rsta["periodo_actual"];
$periodo_anterior = $rsta["periodo_anterior"];
$estado_array = array(
    'Pendiente' => 'bg-yellow',
    'Pre-Aprobado' => 'bg-lightblue',
    'Anulado' => 'bg-red',
    'Aprobado' => 'bg-success',
);
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : die(json_encode(array("exito" => 0, "info" => "Su sesión ha caducado, vuelva a iniciar sesión")));
switch ($_GET['op']) {
    case 'mostrarDepartamento':
        $departamentos = $consulta->mostrarDepartamentos();
        echo json_encode($departamentos);
        break;
    case 'traerInfoTicket':
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $ticket = $consulta->traerInfoTicket($id_persona);
        $factura_yeminus = $consulta->verInfoSolicitante($id_persona)["factura_yeminus"];
        $factura_yeminus = @explode("-", $factura_yeminus)[2];
        $ticket["factura_yeminus"] = $factura_yeminus;
        echo json_encode($ticket);
        break;
    case 'traerPrograma':
        $id_programa = isset($_POST["id_programa"]) ? $_POST["id_programa"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $nombre = $consulta->traerNombrePrograma($id_programa);
        echo json_encode($nombre);
        break;
    case 'mostrarMunicipios':
        $id_departamento = isset($_POST["id_departamento"]) ? $_POST["id_departamento"] : "";
        $ciudades = $consulta->mostrarMunicipios($id_departamento);
        echo json_encode($ciudades);
        break;
    case 'listarProgramas':
        $rsta = $consulta->listarProgramas();
        $array = array();
        $html = "";
        for ($i = 0; $i < count($rsta); $i++) {
            $html .= "<option value='" . $rsta[$i]["nombre"] . "' >" . $rsta[$i]["nombre"] . "</option>";
        }
        $array = array("exito" => 1, "info" => $html);
        echo json_encode($array);
        break;
    case 'listarFinanciados': //Listar el ultimo interes mora insertado
        $estado = $_GET["estado"];
        $periodo = $_GET["periodo"];
        /*echo $estado;*/
        if ($estado == "Todos") {
            $rsta = $consulta->listarTodos($periodo);
        } else {
            $rsta = $consulta->listarFinanciados($estado, $periodo);
        }
        $array = array();
        $etiquetas = $consulta->etiquetas();
        for ($i = 0; $i < count($rsta); $i++) {
            $datossofimatricula = $consulta->sofimatricula($rsta[$i]["id_persona"]);
            $editar_info = '<button class="btn btn-sm btn-warning btn-flat" onclick="EditarinfoPersona(' . $rsta[$i]["id_persona"] . ')"> <i data-toggle="tooltip" title="" class="fas fa-edit" data-original-title="Editar Informacion personal"></i> </button>';
            $eliminar = '<button class="btn btn-sm btn-danger btn-flat" data-toggle="modal" onclick="infoAnulacion(' . $rsta[$i]["id_persona"] . ')" data-target="#confirmareliminacion"><i data-toggle="tooltip" title="" class="fas fa-trash" data-original-title="Anular Crédito"></i></button>';
            $preaprobar = '';
            //$preaprobar = '<button class="btn btn-info btn-flat btn-sm" data-toggle="modal" onclick="infoPreAprobado('.$rsta[$i]["id_persona"].')" data-target="#confirmarpreaprobacion"><i data-toggle="tooltip" title="" class="fas fa-check" data-original-title="Pre-Aprobar"></i></button>';
            $verDetalles = '<button class="btn bg-teal btn-flat btn-sm" data-toggle="modal" onclick="verInfoSolicitante(' . $rsta[$i]["id_persona"] . ')" data-target="#verInfoSolicitante"><i data-toggle="tooltip" title="" class="fas fa-user" data-original-title="Ver detalles"></i></button>';
            $tareas = '<button class="btn bg-lightblue btn-sm" title="Ver seguimientos" data-toggle="modal" onclick="verHistorial(' . $rsta[$i]["id_credencial"] . ')" data-target="#verTareas"><i data-toggle="tooltip" class="fas fa-eye" data-original-title="Ver y Añadir Seguimientos"></i></button>';
            $anadir = '<button class="btn bg-purple btn-sm" title="Nuevo seguimiento o tarea" data-toggle="modal" onclick="agregarTareaSegui(' . $rsta[$i]["id_credencial"] . ', ' . $rsta[$i]["id_persona"] . ')" data-target="#anadirTareas"><i data-toggle="tooltip" class="fa-solid fa-plus data-original-title="Añadir Seguimientos"></i></button>';
            $aprobado = ($rsta[$i]["estado_ticket"] == 1) ? '<button class="btn btn-sm btn-success btn-flat" data-toggle="modal" onclick="infoPersona(' . $rsta[$i]["id_persona"] . ', ' . $rsta[$i]["id_programa"] . ')" data-target="#confirmaraprobacion"><i data-toggle="tooltip" title="" class="fas fa-check-double" data-original-title="Aprobar"></i></button>' : '<button class="btn btn-sm btn-success btn-flat" disabled title="No ha pagado o generado ningún ticket"><i class="fas fa-check-double"></i></button>';
            $cuotas = '<button class="btn btn-sm btn-success btn-flat" data-toggle="modal" onclick="generarPlan(' . $rsta[$i]["id_persona"] . ')" data-target="#confirmaraprobacion"><i data-toggle="tooltip" title="" class="fas fa-print" data-original-title="Generar Plan"></i></button>';
            $detalles_anulamiento = '<button onclick="detallesAnulamiento(' . $rsta[$i]["id_persona"] . ')" data-toggle="modal" data-target="#modal_detalles_anulado" class="btn btn-sm bg-black color-palette btn-flat"><i data-toggle="tooltip" title="" class="fas fa-paperclip" data-original-title="Ver detallles de anulamiento"></i></button>';
            $botones = $editar_info;
            $btn_primer_curso = "";
            $celular_estudiante = $consulta->traerCelularEstudiante($rsta[$i]["numero_documento"]);
            $mensajes_no_vistos = 0;
            if (isset($celular_estudiante["celular"])) {
                $estilo_whatsapp = 'btn-success';
                $numero_celular = $celular_estudiante["celular"];
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
            $select  = '';
            if ($rsta[$i]["estado"] == "Pendiente") {
                $botones .= $eliminar . $preaprobar . $verDetalles . $tareas . $anadir . $boton_whatsapp . $btn_primer_curso;
            } else if ($rsta[$i]["estado"] == "Pre-Aprobado") {
                $botones .= $eliminar . $aprobado . $verDetalles . $tareas . $anadir . $boton_whatsapp . $btn_primer_curso;
            } else if ($rsta[$i]["estado"] == "Aprobado") {
                $rsta_2 = $consulta->dePrimerCurso($rsta[$i]["id_persona"]);
                $btn_primer_curso = (($rsta_2["primer_curso"] == 1 && $rsta_2["matricula_campus"] == 1) ? "<button onclick='enviarCampus(this," . $rsta[$i]["id_persona"] . ")' class='btn btn-sm btn-secondary btn-flat'><i data-toggle='tooltip' title='' class='fas fa-share-square' data-original-title='Enviar Constancia al Campus'></i></button>" : "");
                $botones .= $eliminar . $cuotas . $verDetalles . $tareas . $anadir . $boton_whatsapp . $btn_primer_curso;
                $select .= '<select class="form-control asesor" onchange="cambiarEtiqueta(' . $rsta[$i]["id_persona"] . ',this.value)">';
                $id_etiqueta_matricula = isset($datossofimatricula['id_etiqueta']) ? $datossofimatricula['id_etiqueta'] : "";
                for ($s = 0; $s < count($etiquetas); $s++) {
                    if ($etiquetas[$s]['id_etiquetas'] == $id_etiqueta_matricula) {
                        $select .= '<option value="' . $etiquetas[$s]['id_etiquetas'] . '" selected>' . $etiquetas[$s]['etiqueta_nombre'] . '</option>';
                    } else {
                        $select .= '<option value="' . $etiquetas[$s]['id_etiquetas'] . '">' . $etiquetas[$s]['etiqueta_nombre'] . '</option>';
                    }
                }
                $select .= '</select>';
            } else {
                $botones .= $detalles_anulamiento . $verDetalles . $tareas . $anadir . $boton_whatsapp . $btn_primer_curso;
            }
            $btn_estudio_ticket = "";
            if ($rsta[$i]["estudio_credito"] == 0) {
                $btn_estudio_ticket = '<a href="sofi_estudio_credito.php" class="btn btn-info btn-sm" title="ver estudio de crédito"> <i class="fas fa-eye text-white"></i> </a>';
            } elseif ($rsta[$i]["estudio_credito"] == 0) {
                $btn_estudio_ticket = '<span class="badge badge-warning"> Pendiente </span>';
            } else {
                $btn_estudio_ticket = '<span class="badge badge-success"> Pagado </span>';
            }
            $estadocredito = $consulta->estadoCredito($rsta[$i]["id_persona"]);
            $estadoresultado = ($estadocredito == 1) ? "Crédito finalizado" : "Crédito activo";
            $score_value = $consulta->traerScoreDatacredito($rsta[$i]["numero_documento"]);
            $array[] = array(
                "0" => "<div class='btn-group text-center' style='width:300px'>" . $botones . "</div>",
                "1" => $estadoresultado,
                "2" => $rsta[$i]["numero_documento"],
                "3" => $rsta[$i]["nombres"] . " " . $rsta[$i]["apellidos"],
                "4" => $rsta[$i]["email"],
                "5" => $rsta[$i]["labora"],
                "6" => $rsta[$i]["periodo"],
                "7" => $score_value,
                "8" => $btn_estudio_ticket,
                "9" => '<span class="badge ' . $estado_array[$rsta[$i]["estado"]] . '">' . $rsta[$i]["estado"] . '</span>',
                "10" => $select,
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
    case 'listarPeriodos': //mostrar el id especifico
        $rsta = $consulta->periodosEnSofi();
        if ($rsta >= 1) {
            $option = "<option disabled value=''>- Selecciona un periodo -</option>";
            for ($i = 0; $i < count($rsta); $i++) {
                $option  .= "<option " . (($rsta[$i]['periodo'] == $periodo_actual) ? "selected" : "") . " value='" . $rsta[$i]['periodo'] . "'>" . $rsta[$i]['periodo'] . "</option>";
            }
            $array = array(
                "exito" => 1,
                "info" => $option,
            );
        } else {
            $array = array(
                "exito" => 0
            );
        }
        echo json_encode($array);
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
                // "departamento" => $rsta["departamento"],
                "ciudad" => $rsta["ciudad"],
                "telefono" => $rsta["telefono"],
                "celular" => $rsta["celular"],
                "email" => $rsta["email"],
                "ocupacion" => $rsta["ocupacion"],
                "periodo" => $rsta["periodo"],
                "persona_a_cargo" => $rsta["persona_a_cargo"],
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
        //cas para anular un credito
    case 'anularSolicitud': //Guardar la matricula del aprobado
        $id_persona = isset($_POST["id_persona_anulada"]) ? $_POST["id_persona_anulada"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $motivo_cancela = isset($_POST["motivo_cancela"]) ? $_POST["motivo_cancela"] : die(json_encode(array("exito" => 0, "info" => "Motivo obligatorio")));
        $rsta = $consulta->anularSolicitud($id_persona, $motivo_cancela);
        if ($rsta) {
            $array = array("exito" => 1);
        } else {
            $array = array("exito" => 0);
        }
        echo json_encode($array);
        break;
        //caso para PRE APROBAR un credito
    case 'preAprobarSolicitud': //Guardar la matricula del aprobado
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->preAprobarSolicitud($id_persona);
        if ($rsta) {
            $rsta_info = $consulta->verInfoSolicitante($id_persona);
            $template = set_template_preAprobar($rsta_info["nombres"] . " " . $rsta_info["apellidos"]);
            /*echo "-".$rsta_info[0]["email"];*/
            if (enviar_correo($rsta_info["email"], "Recordatorio de solicitud de financiación", $template)) {
                $array = array("exito" => 1, "info" => "Realizado correctamente");
            } else {
                $array = array("exito" => 1, "info" => "Realizado correctamente, no se envió correo");
            }
        } else {
            $array = array("exito" => 0, "info" => "Ha ocurrido un error al cambiar el estado al interesado");
        }
        echo json_encode($array);
        break;
    case 'guardarMatricula': //Guardar la matricula del aprobado
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Consecutivo obligatorio")));
        $rspta = $consulta->consultarConsecutivo($consecutivo);
        if (count($rspta) > 0) {
            die(json_encode(array("exito" => 0, "info" => "El consecutivo ya existe")));
        }
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $programa = isset($_POST["programa"]) ? $_POST["programa"] : "";
        $valor_total = isset($_POST["valor_total"]) ? $_POST["valor_total"] : die(json_encode(array("exito" => 0, "info" => "Valor total obligatorio")));
        $valor_financiacion = isset($_POST["valor_financiacion"]) ? $_POST["valor_financiacion"] : die(json_encode(array("exito" => 0, "info" => "Valor de Financiacion obligatorio")));
        $motivo_financiacion = isset($_POST["motivo_financiacion"]) ? $_POST["motivo_financiacion"] : "";
        $descuento = isset($_POST["descuento"]) ? $_POST["descuento"] : "";
        $descuento_por = isset($_POST["descuento_por"]) ? $_POST["descuento_por"] : "";
        $descuento = empty($descuento) ? 0 : $descuento;
        $descuento_por = empty($descuento_por) ? 0 : $descuento_por;
        $periodo = isset($_POST["periodo_credito"]) ? $_POST["periodo_credito"] : "";
        $periodo = empty($periodo) ? $periodo_actual : $periodo;
        $fecha_inicial = isset($_POST["fecha_inicial"]) ? $_POST["fecha_inicial"] : die(json_encode(array("exito" => 0, "info" => "Fecha de Financiacion obligatorio")));
        $dia_pago = isset($_POST["dia_pago"]) ? $_POST["dia_pago"] : die(json_encode(array("exito" => 0, "info" => "Día de pago obligatorio")));
        $cantidad_tiempo = isset($_POST["cantidad_tiempo"]) ? $_POST["cantidad_tiempo"] : die(json_encode(array("exito" => 0, "info" => "Cantidad de tiempo obligatorio")));
        $semestre = isset($_POST["semestre"]) ? $_POST["semestre"] : "";
        $jornada = isset($_POST["jornada"]) ? $_POST["jornada"] : "";
        $primer_curso = isset($_POST["primer_curso"]) ? $_POST["primer_curso"] : "";
        $rsta = $consulta->insertarMatricula($consecutivo, $id_persona, $programa, $valor_total, $valor_financiacion, $motivo_financiacion, $descuento, $descuento_por, $fecha_inicial, $dia_pago, $cantidad_tiempo, $semestre, $jornada, $primer_curso, $periodo, $id_usuario);
        if ($rsta) {
            if ($dia_pago == "Mensual") {
                $num_dia = 1;
                $intervalo = 29;
                $intervalo_cuota = date("d", strtotime($fecha_inicial));
            } else {
                $num_dia = 2;
                $intervalo = 15;
                $intervalo_cuota = 15;
            }
            $num_cuotas = $cantidad_tiempo * $num_dia;
            $cuota_val = $valor_financiacion / $num_cuotas;
            $i = 1;
            $temp_date = $fecha_inicial;
            for ($i = 1; $i <= $num_cuotas; $i++) {
                $ultima_fecha_cuota = $temp_date;
                //echo "$i, $cuota_val , $temp_date, $consecutivo ,$id_persona; ";
                $consulta->insertarCuota($i, $cuota_val, $temp_date, $consecutivo, $id_persona);
                $temp_date = date("Y-m-d", strtotime($temp_date . ' + ' . $intervalo . ' days'));
                $mes_cuota = date("m", strtotime($temp_date));
                $anio_cuota = date("Y", strtotime($temp_date));
                if ($mes_cuota == "2") {
                    if ($dia_pago == "Mensual" && $intervalo_cuota < 28) {
                        $temp_date = date($anio_cuota . "-" . $mes_cuota . "-" . $intervalo_cuota);
                    } else if ($dia_pago == "Mensual" && $intervalo_cuota >= 28) {
                        $temp_date = date($anio_cuota . "-" . $mes_cuota . "-" . "28");
                    } else if ($dia_pago == "Quincenal" && $intervalo_cuota >= 28) {
                        $temp_date = date($anio_cuota . "-" . $mes_cuota . "-" . "28");
                    } else {
                        $temp_date = date($anio_cuota . "-" . $mes_cuota . "-" . $intervalo_cuota);
                    }
                } else {
                    $temp_date = date($anio_cuota . "-" . $mes_cuota . "-" . $intervalo_cuota);
                }
                if ($num_dia == 2 && $intervalo_cuota == 15) {
                    $intervalo_cuota = 30;
                } else if ($num_dia == 2 && $intervalo_cuota == 30) {
                    $intervalo_cuota = 15;
                }
            }
            $ultima_fecha_cuota = date("Y-m-d", strtotime($ultima_fecha_cuota . ' + 3 days'));
            $consulta->aprobarCredito($id_persona, $periodo, $ultima_fecha_cuota);
            $array = array("exito" => 1, "id_persona" => $id_persona);
        } else {
            $array = array("exito" => 0, "info" => "Error al momento de realizar la petición.");
        }
        echo json_encode($array);
        break;
    case 'generarPlan': //envia los datos de la persona para generar el plana de pagos
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->datosPlanPagos($id_persona);
        if (is_array($rsta)) {
            echo json_encode(array("exito" => 1, "info" => $rsta));
        } else {
            echo json_encode(array("exito" => 0, "info" => "Falta información, por ende, no se puede generar el plan de pagos"));
        }
        break;
    case 'listarCuotas': //lista las cuotas del finanaciamiento que se muestra en el plan de pagos
        $consecutivo = isset($_GET["consecutivo"]) ? $_GET["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Consecutivo obligatorio")));
        $rsta = $consulta->listarCuotas($consecutivo);
        $array = array();
        for ($i = 0; $i < count($rsta); $i++) {
            $array[] = array(
                "0" => $rsta[$i]["numero_cuota"],
                "1" => $rsta[$i]["valor_cuota"],
                "2" => $rsta[$i]["fecha_pago"],
                "3" => $rsta[$i]["plazo_pago"]
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
    case 'enviarPrejuridico':
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $estado = isset($_POST["estado"]) ? $_POST["estado"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->enviarPrejuridico($id_persona, $estado);
        //echo "$id_persona, $estado";
        if ($rsta) {
            echo json_encode(array("exito" => 1));
        } else {
            echo json_encode(array("exito" => 0));
        }
        break;
    case "detallesAnulamiento":
        $id_persona = isset($_POST['id_persona']) ? $_POST['id_persona'] : "";
        $rspta = $consulta->detallesAnulamiento($id_persona);
        echo json_encode($rspta);
        break;
    case "enviarCampus":
        //tomo el id desde la vista 
        $id_persona = isset($_POST['id_persona']) ? $_POST['id_persona'] : "";
        //consulto y almaceno el documento. la fecha y hora actual
        $rspta = $consulta->verInfoSolicitante($id_persona);
        $documento = $rspta["numero_documento"];
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        //busco el periodo de campaña en el cual estamos
        $res = $consulta->obtenerPeriodoCampana();
        $periodo = $res["periodo_campana"];
        //con el respectivo periodo y documento buscamos al interesado
        $rspta = $consulta->buscarInteresado($documento, $periodo);
        //si la respuesta tiene datos
        if (is_array($rspta)) {
            $datos = $rspta;
            $id_estudiante_agregar = $datos["id_estudiante"];
            $id_usuario = 38; //Jhuliana Blanco 
            $asesor = "Jhuliana Blanco";
            //si el estudiante tiene los documentos subidos, pasa inmediatamente a admitido y se insertan los respestivos seguimientos
            if ($datos["estado"] == "Seleccionado" && $datos["documentos"] == 0) {
                $rspta = $consulta->actualizar_seleccionado($id_estudiante_agregar);
                $motivo_seguimiento = 'Seguimiento';
                $mensaje_seguimiento = '<div style=background-color:#7AAD21> Cambio de estado: Admitido.</div>';
                $consulta->insertarSeguimientoOncenter($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $asesor);
                $mensaje_seguimiento = 'Validación de pago de matrícula';
                $consulta->insertarSeguimientoOncenter($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $asesor);
            } else { //si no solo se cambia el estado y se agrega el respectivo seguimiento
                $rspta = $consulta->actualizar_matriculado($id_estudiante_agregar);
                $motivo_seguimiento = 'Seguimiento';
                $mensaje_seguimiento = '<span style=background-color:#b806d8> Soporte recibo matrícula verificado</span>';
                $consulta->insertarSeguimientoOncenter($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $asesor);
            }
            //si todo sale correcto se cambias el estado en el sofi
            if ($rspta) {
                $rspta = $consulta->actualizarEnvioCampus($id_persona);
                if ($rspta) {
                    echo (json_encode(array("exito" => 1, "info" => "Todo se ha realizado con exito")));
                } else {
                    echo (json_encode(array("exito" => 0, "info" => "Error al actualizar el envio del SOFI")));
                }
            } else {
                echo (json_encode(array("exito" => 0, "info" => "Error al actualizar el estudiante")));
            }
        } else {
            echo (json_encode(array("exito" => 0, "info" => "No tiene ningún proceso de admisión")));
        }
        break;
    case 'editarDatospersona':
        $id_persona_editar = isset($_POST["id_persona_editar"]) ? $_POST["id_persona_editar"] : "";
        $tipo_documento = isset($_POST["tipo_documento"]) ? $_POST["tipo_documento"] : "";
        $numero_documento = isset($_POST["numero_documento"]) ? $_POST["numero_documento"] : "";
        $nombres = isset($_POST["nombres"]) ? $_POST["nombres"] : "";
        $apellidos = isset($_POST["apellidos"]) ? $_POST["apellidos"] : "";
        $fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? $_POST["fecha_nacimiento"] : "";
        $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
        $ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : "";
        $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
        $celular = isset($_POST["celular"]) ? $_POST["celular"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $ocupacion = isset($_POST["ocupacion"]) ? $_POST["ocupacion"] : "";
        $persona_a_cargo = isset($_POST["persona_a_cargo"]) ? $_POST["persona_a_cargo"] : "";
        $rsta = $consulta->editarPersona($id_persona_editar, $tipo_documento, $numero_documento, $nombres, $apellidos, $fecha_nacimiento, $direccion, $ciudad, $telefono, $celular, $email, $ocupacion, $persona_a_cargo);
        if ($rsta) {
            $data = array("exito" => 1, "info" => "Todo se ha realizado con exito.");
        } else {
            $data = array("exito" => 0, "info" => "Error al almacenar los registros.");
        }
        echo json_encode($data);
        break;
    case 'cambiarEtiqueta':
        $id_persona = $_POST['id_persona'];
        $valor = $_POST['valor'];
        $rspta = $consulta->cambiarEtiqueta($id_persona, $valor);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        break;
}