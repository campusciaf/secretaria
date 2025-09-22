<?php

use function Symfony\Component\VarDumper\Dumper\esc;

require_once "../modelos/SofiConsultarCuotas.php";
//modelo en el cual estan las funciones a base de datos 
$consulta = new SofiConsultarCuotas();
//dependiendo de la opcion que envien por el GET, el switch determinara donde entrar
switch ($_GET['op']) {
    case 'listarCuotas':
        /*print_r($_POST);*/
        $tipo_busqueda = isset($_POST["tipo_busqueda"]) ? $_POST["tipo_busqueda"] : die();
        $dato_busqueda = isset($_POST["dato_busqueda"]) ? $_POST["dato_busqueda"] : die();
        //$permiso_edicion = isset($_SESSION["editar_cuotas"]) ? $_SESSION["editar_cuotas"] : die();
        $hoy = date("Y-m-d");
        //hacemos peticion al modelo
        $rsta = $consulta->listarCuotas($tipo_busqueda, $dato_busqueda);
        //creamos un array
        $array = array();
        //2 = consecutivo; 1 y 3 = nombre o cedula  
        if ($tipo_busqueda == 2) {
            //creamos las variables de los botones
            $btn_pagado = '<button class="btn btn-sm bg-green  btn-flat btn-block" disabled><i class="fas fa-check"></i><i> Pagado</i></button>';
            $btn_progreso_normal = '<button class="btn btn-sm bg-yellow btn-flat btn-block" disabled><i class="fas fa-spinner"></i><i> En proceso</i></button>';
            $btn_proceso_atrasado = '<button class="btn btn-sm btn-danger btn-flat btn-block" disabled> <i class="fas fa-calendar-times"></i> <i> Atrasado </i> </button>';
            $btn_anulado = '<button class="btn btn-sm bg-orange btn-flat btn-block"disabled><i class="fas fa-handshake-alt-slash"></i> <i> Anulado</i></button>';
            $flag = false;
            //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
            for ($i = 0; $i < count($rsta); $i++) {
                if (strtotime($hoy) >= strtotime($rsta[$i]["fecha_pago"]) and $flag) {
                    $btn_progreso = $btn_proceso_atrasado;
                } else {
                    $btn_progreso = $btn_progreso_normal;
                }
                //calculamos los dias de atraso
                $dias_atraso = $consulta->diferenciaFechas(date("Y-m-d"), $rsta[$i]["plazo_pago"]);
                //creamos las variables de los botones que tienen accion
                $e = $rsta[$i]["estado"];
                //id del financiamiento
                $id_cuota = $rsta[$i]["id_financiamiento"];
                //el valor de la cuota actual
                $valor_a_pagar = intval($rsta[$i]["valor_cuota"] - $rsta[$i]["valor_pagado"]);
                $btn_pagar = '<button class="btn btn-sm bg-navy btn-flat" onclick="pagar_cuota(' . $id_cuota . ', ' . $dato_busqueda . ', `tabla_cuotas`)">
                                <i data-toggle="tooltip" data-original-title="Pagar Cuota"><i class="fas fa-hand-holding-usd"></i></i>
                            </button>';
                $btn_abonar = '<button class="btn btn-sm btn-info btn-flat" data-toggle="modal" data-target="#modal_abonos" onclick="ajustes_abono(' . $valor_a_pagar . ', ' . $id_cuota . ')">
                            <i data-toggle="tooltip" data-original-title="Abonar Cuota"><i class="fas fa-coins"></i></i>
                        </button>';
                $btn_adelantar = '<button class="btn btn-sm btn-warning btn-flat" data-toggle="modal" data-target="#modal_adelantos" onclick="ajustes_adelanto( ' . $valor_a_pagar . ', ' . $dato_busqueda . ')">
                            <i data-toggle="tooltip" data-original-title="Adelantar Cuota"><i class="fas fa-angle-double-right"></i></i>
                        </button>';
                $btn_atraso = '<button class="btn btn-sm btn-danger btn-flat btn-block" data-toggle="modal" data-target="#modal_atrasos" onclick="ajustes_atrasado(' . $id_cuota . ', ' . $valor_a_pagar . ',' . $dato_busqueda . ')">
                            <i data-toggle="tooltip" data-original-title="Pagar Atrasado">
                                <i class="fas fa-calendar-times"></i> 
                                <i> Atrasado</i>
                            </i>
                        </button>';
                $btn_abonado = '<button class="btn btn-sm bg-teal btn-flat" onclick="total_abono_cuota(' . $id_cuota . ', ' . $dato_busqueda . ', `tabla_cuotas`)">
                            <i data-toggle="tooltip" data-original-title="Pagar total abonado"><i class="fas fa-handshake"></i></i>
                        </button>';
                //array con info
                //echo $rsta[$i]["estado_credito"];
                $array[] = array(
                    "0" => '<div class="text-center" style="padding:0px  !important; margin:0px !important;">
                                ' . (($rsta[$i]["estado_credito"] == "Anulado") ? $btn_anulado : (($e == "Pagado") ? $btn_pagado : (($flag) ? $btn_progreso : (($e == "Abonado" && (strtotime($hoy) <= strtotime($rsta[$i]["plazo_pago"]))) ? $btn_abonado . $btn_abonar . ((($i + 1) < count($rsta)) ? $btn_adelantar : "") : ((strtotime($hoy) > strtotime($rsta[$i]["plazo_pago"])) ? $btn_atraso : $btn_pagar . $btn_abonar . ((($i + 1) < count($rsta)) ? $btn_adelantar : "")))))) . '
                            </div>',
                    "1" => $rsta[$i]["numero_cuota"],
                    "2" => "$ " . $consulta->formatoDinero($rsta[$i]["valor_cuota"]),
                    "3" => "$ " . $consulta->formatoDinero($rsta[$i]["valor_pagado"]),
                    "4" => $rsta[$i]["plazo_pago"],
                    "5" => "$ " . $consulta->formatoDinero($rsta[$i]["interes_acumulado"]),
                    "6" => ($rsta[$i]["estado"] == "A Pagar" && strtotime($hoy) >= strtotime($rsta[$i]["fecha_pago"])) ? $dias_atraso : (($rsta[$i]["estado"] == "A Pagar" && strtotime($hoy) < strtotime($rsta[$i]["fecha_pago"])) ? "-" . $dias_atraso : 0),
                    // "7" => '<button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal_editar_cuotas" onclick="ajustes_info_cuotas(' . $id_cuota . ')"><i class="fas fa-edit"></i></button>',
                    "7" => '',

                );
                $flag = ($e == "Pagado") ? false : true;
            }
        } else {
            //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
            for ($i = 0; $i < count($rsta); $i++) {
                $array[] = array(
                    "0" => '<button class="btn btn-warning btn-flat" onclick="listar_cuotas(2, ' . $rsta[$i]["id"] . ',`' . "tabla_cuotas" . '`)"><i class="fas fa-calendar-alt"></i></button>',
                    "1" => $rsta[$i]["periodo"],
                    "2" => $rsta[$i]["id"],
                    "3" => $rsta[$i]["nombres"] . " " . $rsta[$i]["apellidos"],
                    "4" => $rsta[$i]["programa"],
                    "5" => $consulta->formatoDinero($rsta[$i]["valor_total"]),
                    "6" => $consulta->formatoDinero($rsta[$i]["valor_financiacion"]),
                    "7" => $rsta[$i]["descuento"],
                    "8" => date("Y-m-d", strtotime($rsta[$i]["fecha_inicial"])),
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
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->verInfoSolicitante($consecutivo);
        $celular_estudiante = $consulta->traerCelularEstudiante($rsta["numero_documento"]);
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
        if ($rsta >= 1) {
            // estado_ciafi 0 = bloqueado, 1 = desbloqueado 
            if($rsta["estado_ciafi"] == 0){
                $estado_ciafi = "Bloqueado";
                $color_estado = "btn-danger";
            }else{
                $estado_ciafi = "Sin Bloqueo";
                $color_estado = "btn-success";
            }
            // estado_financiacion 0 = inactivo, 1 = activo 
            $estado_financiacion = ($rsta["estado"] == "Anulado") ? "Anulado" : "Activo";
            $estado_credito = ($rsta["estado"] == "Anulado") ? 0 : 1;
            // en_cobro 0 = no, 1 = si 
            $en_cobro = ($rsta["en_cobro"] == 0) ? "NO" : "SI";
            //boton para abrir modal de categorizacion
            $categorizar =  '<button class="btn btn-flat btn-sm btn-primary" onclick="modal_categoria(' . $consecutivo . ')" data-toggle="modal" data-target="#modal_categoria">
                                <i class="fas fa-user-check" data-toggle="tooltip" title="Categorizar Crédito"></i>
                            </button>';
            $array = array(
                "exito" => 1,
                "id_persona" => $rsta["id_persona"],
                "tipo_documento" => $rsta["tipo_documento"],
                "numero_documento" => $rsta["numero_documento"],
                "nombres" => $rsta["nombres"],
                "apellidos" => $rsta["apellidos"],
                "direccion" => $rsta["direccion"],
                "telefono" => $rsta["telefono"],
                "celular" => $rsta["celular"],
                "email" => $rsta["email"],
                "periodo" => $rsta["periodo"],
                "id" => $rsta["id"],
                "programa" => $rsta["programa"],
                "jornada" => $rsta["jornada"],
                "semestre" => $rsta["semestre"],
                "dia_pago" => $rsta["dia_pago"],
                "valor_financiacion" => $rsta["valor_financiacion"],
                "cantidad_tiempo" => $rsta["cantidad_tiempo"],
                "estado_financiacion" => $estado_financiacion . ' <button class="btn btn-flat btn-sm btn-primary" onclick="cambiar_estado_financiacion( ' . $estado_credito . ', ' . $consecutivo . ', ' . $rsta["id_persona"] . ' )"><i class="fas fa-handshake" data-toggle="tooltip" title="' . (($rsta["estado_financiacion"] == 0) ? "Activar" : "Inactivar") . ' Persona"></i></button>',
                "estado_ciafi" => ' <button class="btn btn-flat btn-sm '. $color_estado.'" onclick="cambiar_estado_ciafi(' . $rsta["estado_ciafi"] . ',' . $consecutivo . ')"> '.$estado_ciafi.' </button>',
                "en_cobro" => $en_cobro . ' <button class="btn btn-flat btn-sm btn-primary" onclick="cambiar_estado_cobro(' . $rsta["en_cobro"] . ',' . $consecutivo . ')"><i class="fas fa-file' . (($rsta["en_cobro"] == 0) ? "-import" : "-export") . '" data-toggle="tooltip" title="' . (($rsta["en_cobro"] == 0) ? "Enviar A" : "Sacar De") . ' Cobro"></i></button>',
                "seguimiento" => '<button class="btn bg-lightblue btn-sm" title="Ver seguimientos" data-toggle="modal" onclick="verHistorial(' . $rsta["id_credencial"] . ')" data-target="#verTareas"><i data-toggle="tooltip" class="fas fa-eye" data-original-title="Ver y Añadir Seguimientos"></i></button> <button class="btn bg-purple btn-sm" title="Nuevo seguimiento o tarea" data-toggle="modal" onclick="agregarTareaSegui(' . $rsta["id_credencial"] . ', ' . $rsta["id_persona"] . ')" data-target="#anadirTareas"><i data-toggle="tooltip" class="fa-solid fa-plus data-original-title="Añadir Seguimientos"></i></button>' . $boton_whatsapp,
                "categorizar" => $rsta["categoria_credito"] . " " . $categorizar,
                "dias_atrados" => $rsta["dias_atrasados"],
                "historial_pagos" => '<button class="btn bg-purple btn-flat" data-toggle="modal" data-target="#modal_historial_pagos" onclick="historial_pagos(' . $consecutivo . ')"> 
                                        <i data-toggle="tooltip" class="fas fa-history" data-original-title="Historial De Pagos"></i>
                                    </button>'
            );
        } else {
            $array = array("exito" => 0);
        }
        echo json_encode($array);
        break;
        //Muestra la informacion especifica del solicitante
    case 'saldoDebito':
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->saldoDebito($consecutivo);
        if ($rsta >= 1) {
            $array = array("exito" => 1, "saldo_debito" => $consulta->formatoDinero($rsta["saldo_debito"]), "saldo_debito_sin_formato" => $rsta["saldo_debito"]);
        } else {
            $array = array("exito" => 0);
        }
        echo json_encode($array);
        break;
        //muestra el historial de los pagos realizados
    case "historialPagos":
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die();
        //hacemos peticion al modelo
        $rsta = $consulta->historialPagos($consecutivo);
        //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
        $array = array();
        for ($i = 0; $i < count($rsta); $i++) {
            $array[] = array(
                "0" => $rsta[$i]["consecutivo"],
                "1" => $rsta[$i]["numero_cuota"],
                "2" => date("Y-m-d", strtotime($rsta[$i]["fecha_pago"] . " +3 days")),
                "3" => $rsta[$i]["fecha_pagada"],
                "4" => $consulta->formatoDinero($rsta[$i]["valor_pagado"])
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
    case "historialPagosMora":
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die();
        //hacemos peticion al modelo
        $rsta = $consulta->historialPagosMora($consecutivo);
        //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
        $array = array();
        for ($i = 0; $i < count($rsta); $i++) {
            $array[] = array(
                "0" => $rsta[$i]["consecutivo"],
                "1" => $rsta[$i]["numero_cuota"],
                "2" => date("Y-m-d", strtotime($rsta[$i]["fecha_pago"] . " +3 days")),
                "3" => $rsta[$i]["fecha_pagada"],
                "4" => $consulta->formatoDinero($rsta[$i]["valor_pagado"])
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
        //cambiar Estado Financiacion
    case 'cambiarEstadoFinanciacion':
        $estado_financiacion = isset($_POST["estado_financiacion"]) ? $_POST["estado_financiacion"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : "";
        $estado_financiacion = ($estado_financiacion == "0") ? "Aprobado" : "Anulado";
        $rsta = $consulta->cambiarEstadoFinanciacion($estado_financiacion, $id_persona);
        if ($rsta) {
            $array = array("exito" => 1, "info" => "Cambio realizado con exito");
        } else {
            $array = array("exito" => 0, "info" => "Error al realizar el cambio");
        }
        echo json_encode($array);
        break;
        //cambiar Estado CIAFI
    case 'cambiarEstadoCiafi':
        $estado_ciafi = isset($_POST["estado_ciafi"]) ? $_POST["estado_ciafi"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : "";
        $id_usuario = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
        $rsta = $consulta->cambiarEstadoCiafi((($estado_ciafi == 0) ? 1 : 0), $consecutivo);
        if ($rsta) {
            $generarHistorial = $consulta->generarHistorialCiafi($consecutivo, (($estado_ciafi == 0) ? "Desbloqueo" : "Bloqueo"), $id_usuario);
            $array = array("exito" => 1, "info" => "Cambio realizado con exito");
        } else {
            $array = array("exito" => 0, "info" => "Error al realizar el cambio");
        }
        echo json_encode($array);
        break;
        //cambiar Estado Cobro
    case 'cambiarEstadoCobro':
        $en_cobro = isset($_POST["en_cobro"]) ? $_POST["en_cobro"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : "";
        $rsta = $consulta->cambiarEstadoCobro((($en_cobro == 0) ? 1 : 0), $consecutivo);
        if ($rsta) {
            $array = array("exito" => 1, "info" => "Cambio realizado con exito");
        } else {
            $array = array("exito" => 0, "info" => "Error al realizar el cambio");
        }
        echo json_encode($array);
        break;
        //ver las tareas del aprobado
    case "pagarCuota":
        $id_financiamiento = isset($_POST["id_financiamiento"]) ? $_POST["id_financiamiento"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->consultarCuota($id_financiamiento);
        $consecutivo = $rsta["id_matricula"];
        $numero_cuota = $rsta["numero_cuota"];
        $fecha_pago = $rsta["fecha_pago"];
        $valor_a_pagar = intval($rsta["valor_cuota"] - $rsta["valor_pagado"]);
        $rsta = $consulta->pagarCuota($id_financiamiento, $consecutivo);
        if ($rsta) {
            $array = array("exito" => 1);
            $consulta->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_a_pagar, $id_financiamiento);
            $valores_x_credito = $consulta->calcularValoresDeuda($consecutivo);
            if ($valores_x_credito["total_deuda"] == $valores_x_credito["total_pagado"]) {
                $consulta->finalizarCredito($consecutivo);
            }
        } else {
            $array = array("exito" => 0);
        }
        echo json_encode($array);
        break;
    case "abonarCuota":
        $id_financiamiento = isset($_POST["id_financiamiento"]) ? $_POST["id_financiamiento"] : die(json_encode(array("exito" => 0, "info" => "Cuota obligatoria")));
        $cantidad_abono = isset($_POST["cantidad_abono"]) ? $_POST["cantidad_abono"] : die(json_encode(array("exito" => 0, "info" => "Valor obligatorio")));
        $rsta = $consulta->consultarCuota($id_financiamiento);
        $consecutivo = $rsta["id_matricula"];
        $numero_cuota = $rsta["numero_cuota"];
        $fecha_pago = $rsta["fecha_pago"];
        $valor_a_pagar = intval($rsta["valor_cuota"] - $rsta["valor_pagado"]);
        if ($valor_a_pagar > $cantidad_abono) {
            $rsta = $consulta->abonarCuota($id_financiamiento, $cantidad_abono);
            if ($rsta) {
                $consulta->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $cantidad_abono, $id_financiamiento);
                $array = array("exito" => 1, "info" => "Abono realizado con éxito", "consecutivo" => $consecutivo);
            } else {
                $array = array("exito" => 0, "info" => "Error al realizar el abono");
            }
        } else {
            $array = array("exito" => 0, "info" => "Error el monto es incorrecto " . $rsta["valor_cuota"]);
        }
        $valores_x_credito = $consulta->calcularValoresDeuda($consecutivo);
        if ($valores_x_credito["total_deuda"] == $valores_x_credito["total_pagado"]) {
            $consulta->finalizarCredito($consecutivo);
        }
        echo json_encode($array);
        break;
    case "totalAbonoCuota":
        $id_financiamiento = isset($_POST["id_financiamiento"]) ? $_POST["id_financiamiento"] : die(json_encode(array("exito" => 0, "info" => "Cuota obligatoria")));
        $rsta = $consulta->consultarCuota($id_financiamiento);
        $consecutivo = $rsta["id_matricula"];
        $numero_cuota = $rsta["numero_cuota"];
        $fecha_pago = $rsta["fecha_pago"];
        $valor_a_pagar = intval($rsta["valor_cuota"] - $rsta["valor_pagado"]);
        $rsta = $consulta->pagarCuota($id_financiamiento, $consecutivo);
        if ($rsta) {
            $consulta->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_a_pagar, $id_financiamiento);
            $array = array("exito" => 1, "info" => "Pago realizado con éxito", "consecutivo" => $consecutivo);
        } else {
            $array = array("exito" => 0, "info" => "Error al realizar el pago");
        }
        $valores_x_credito = $consulta->calcularValoresDeuda($consecutivo);
        if ($valores_x_credito["total_deuda"] == $valores_x_credito["total_pagado"]) {
            $consulta->finalizarCredito($consecutivo);
        }
        echo json_encode($array);
        break;
    case "adelantarCuota":
        $consecutivo  = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Consecutivo obligatorio")));
        $cantidad_adelanto  = isset($_POST["cantidad_adelanto"]) ? $_POST["cantidad_adelanto"] : die(json_encode(array("exito" => 0, "info" => "Cantidad obligatoria")));
        $rsta = $consulta->consultarCuotasNoPagadas($consecutivo);
        $flag = true;
        for ($i = 0; $i < count($rsta) && $flag == true; $i++) {
            $id_financiamiento = $rsta[$i]["id_financiamiento"];
            $numero_cuota = $rsta[$i]["numero_cuota"];
            $fecha_pago = $rsta[$i]["fecha_pago"];
            $estado = $rsta[$i]["estado"];
            $valor_a_pagar = intval($rsta[$i]["valor_cuota"] - $rsta[$i]["valor_pagado"]);
            if ($valor_a_pagar <= $cantidad_adelanto) {
                $consulta->pagarCuota($id_financiamiento, $consecutivo);
                $consulta->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_a_pagar, $id_financiamiento);
                $cantidad_adelanto = $cantidad_adelanto - $valor_a_pagar;
            } else {
                $consulta->abonarCuota($id_financiamiento, $cantidad_adelanto);
                $consulta->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $cantidad_adelanto, $id_financiamiento);
                $flag = false;
            }
        }
        $valores_x_credito = $consulta->calcularValoresDeuda($consecutivo);
        if ($valores_x_credito["total_deuda"] == $valores_x_credito["total_pagado"]) {
            $consulta->finalizarCredito($consecutivo);
        }
        $array = array("exito" => 1, "info" => "Adelanto realizado con éxito", "consecutivo" => $consecutivo);
        echo json_encode($array);
        break;
    case 'calcularInteresAnterior':
        // Obtener el id del financiamiento
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Cuota obligatoria")));
        $data = array();
        // Definimos en cero todas las variables que se van a usar 
        $valor_deuda_total = 0;
        // El calculo de la suma de la cuot a + interes y ese mismo se suma sobre los mismos intereses 
        $valor_mas_interes = 0;
        // La suma del interes neto
        $interes_total = 0;
        // Consultamos en la base de datos las cuotas que no se han pagado hasta la fecha actual
        $rspta = $consulta->consultarCuotasNoPagadas($consecutivo);
        //vacea el interes para que el valor sea cero y no sume valores antiguos
        $consulta->limpiarInteresAcumulado($consecutivo);
        // Realizamos un for a través de las cuotas 
        for ($i = 0; $i < count($rspta); $i++) {
            $id_financiamiento = $rspta[$i]["id_financiamiento"];
            /*Guarda el plazo de la primer cuota atrasada, cuando el estudiante esta atrasado el mes de la cuota, de eso depende el mes actual */
            $plazo_primer_cuota = ($i == 0) ? $rspta[$i]["plazo_pago"] : $plazo_primer_cuota;
            // Tomamos el plazo de la cuota 
            $plazo_pago = $rspta[$i]["plazo_pago"];
            // Obtenemos el valor real de la cuota
            $valor_cuota = $rspta[$i]["valor_cuota"];
            // Obtenemos el valor abonado a la cuota
            $valor_pagado = $rspta[$i]["valor_pagado"];
            // Calculamos el valor restante a pagar (es por si se ha realizado abonos)
            $valor_cuota =  $valor_cuota - $valor_pagado;
            // Almacenamos el valor total de la deuda indica lo que lleva atrasado sin mora
            $valor_deuda_total += $valor_cuota;
            // Almacenamos el valor de la deuda pero ahora teniendo en cuenta el valor del interés
            $valor_mas_interes += $valor_cuota;
            // Tomamos el año de la cuota
            $anio_cuota = date("Y", strtotime($plazo_pago));
            // Tomamos el mes de la cuota
            $mes_cuota = date("m", strtotime($plazo_pago));
            // Tomamos el día de la cuota
            $dia_cuota = date("d", strtotime($plazo_pago));
            // Obtenemos los datos del interés mora del mes y el año de la cuota
            $interes = $consulta->TraerInteresMora("$anio_cuota-$mes_cuota");
            // Obtenemos el interés
            $porcentaje_interes = $interes["porcentaje"];
            // Obtenemos el nombre del mes de interés
            $nombre_mes = $interes['nombre_mes'];
            // Obtenemos la fecha límite de interés
            $fecha_interes = $interes["fecha_mes"];
            // Obtenemos solo el día límite de interés
            $dia_final_interes = date("d", strtotime($fecha_interes));
            //si la cuota esta en el mes actual, nos devolvemos un mes atras, para calcularlo en con la formula de actual
            if ($anio_cuota == date("Y") && $mes_cuota == date("m")) {
                //si es enero, debemos devolver a diciembre
                $mes_cuota = ($mes_cuota == 01) ? 12 : $mes_cuota - 1;
                //si es enero, debemos devolver un año atras
                $anio_cuota = ($mes_cuota == 01) ? $anio_cuota-- : $anio_cuota;
            } else {
                // Calculamos los días transcurridos
                $dias_transcurridos =  $dia_final_interes - $dia_cuota;
                // Si es el primer ciclo, el valor debe ser la resta de los días, sino, sería el total del mes 
                $dias_transcurridos = ($i == 0) ? $dias_transcurridos : $dia_final_interes;
                // pow es potenciación, es decir calculamos el porcentaje por medio de un cálculo que incluye potenciación
                $porcentaje = pow((1 + ($porcentaje_interes / 100)), (1 / 12)) - 1;
                // Se calcula el valor del interés
                $valor_interes = $valor_deuda_total * ($porcentaje / $dia_final_interes * $dias_transcurridos);
                // Se suma al total de los intereses
                $interes_total += $valor_interes;
                // Este valor es simplemente datos de ayuda a la tabla
                $valor_mas_interes += $valor_interes;
                // Mostrar el valor final en la tabla
                $data[] = array(
                    '0' => $nombre_mes . " - $anio_cuota",
                    '1' => $dias_transcurridos,
                    '2' => round($valor_deuda_total),
                    '3' => round($valor_interes),  // Días hasta hoy en el mes actual
                    '4' => round($valor_mas_interes),
                    '5' => number_format(($porcentaje * 100), 2)
                );
                $consulta->actualizarInteresCuota($id_financiamiento, round($valor_interes));
            }
        }
        /* Calcular los intereses desde la última cuota hasta la fecha actual  */
        //bandera que me indica que los meses restantes aparte de las cuotas ya finalizaron
        $finalizo = true;
        $aux = 0;
        //este do-while se ejecuta hasta que llegue el mes actual y la bandera $finalizo sea false
        do {
            //si el mes es igual a 12 quiere decir que el procimo mes es enero por ende 1, sino sumamos uno mas
            $mes_cuota = ($mes_cuota == 12) ? 1 : $mes_cuota + 1;
            //sumamos uno a uno los meses teniendo en cuenta que puede haber cuotas de un año para otro
            $anio_cuota = ($mes_cuota == 12) ? $anio_cuota + 1 : $anio_cuota;
            //agregamos el cero del 1 al 9 para temas de evitar errores al momento de consultar interes
            $mes_cuota = ($mes_cuota <= 9) ? "0" . $mes_cuota : $mes_cuota;
            // Obtenemos los datos del interés mora del mes y el año de la cuota
            $interes = $consulta->TraerInteresMora("$anio_cuota-$mes_cuota");
            //echo "$anio_cuota-$mes_cuota";
            // Obtenemos el interés
            $porcentaje_interes = $interes["porcentaje"];
            // Obtenemos el nombre del mes de interés
            $nombre_mes = $interes['nombre_mes'];
            // Obtenemos la fecha límite de interés
            $fecha_interes = $interes["fecha_mes"];
            // Obtenemos solo el día límite de interés
            $dia_final_interes = date("d", strtotime($fecha_interes));
            if (date("m") == $mes_cuota && $anio_cuota == date("Y")) {
                $mes_primer_cuota_atrasada = date("m", strtotime($plazo_primer_cuota));
                if ($mes_primer_cuota_atrasada == $mes_cuota) {
                    $dia_primer_cuota_atrasada = date("d", strtotime($plazo_primer_cuota));
                    $dia_actual = date("d");
                    $dias_transcurridos = $dia_actual - $dia_primer_cuota_atrasada;
                } else {
                    $dias_transcurridos = date("d");
                }
                $finalizo = false;
            } else {
                $dias_transcurridos = $dia_final_interes;
            }
            // pow es potenciación, es decir calculamos el porcentaje por medio de un cálculo que incluye potenciación
            $porcentaje = pow((1 + ($porcentaje_interes / 100)), (1 / 12)) - 1;
            // Se calcula el valor del interés
            $valor_interes = $valor_deuda_total * ($porcentaje / $dia_final_interes * $dias_transcurridos);
            // Se suma al total de los intereses
            $interes_total += $valor_interes;
            // Este valor es simplemente datos de ayuda a la tabla
            $valor_mas_interes += $valor_interes;
            $data[] = array(
                '0' => $nombre_mes . " - $anio_cuota",
                '1' => $dias_transcurridos,
                '2' => round($valor_deuda_total),
                '3' => round($valor_interes),  // Días hasta hoy en el mes actual
                '4' => round($valor_mas_interes),
                '5' => number_format(($porcentaje * 100), 2)
            );
            $consulta->actualizarInteresCuota($id_financiamiento, round($valor_interes));
            $aux++;
            if ($aux == 6000) {
                $finalizo = false;
            }
        } while ($finalizo);
        // Preparar los resultados para el datatables
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data,
            "total_interes" => round($interes_total),
            "total_abono_interes" => $consulta->calculoAbonoInteres($consecutivo),
        );
        echo json_encode($results);
        break;
    case "desatrasoCuota":
        //id de la cuota que se va a pagar
        $id_financiamiento = isset($_POST["financiamiento_atrasado"]) ? $_POST["financiamiento_atrasado"] : die(json_encode(array("exito" => 0, "info" => "Faltan Datos")));
        //consecutivo con todas las cuotas a pagar
        $consecutivo = isset($_POST["consecutivo_atrasado"]) ? $_POST["consecutivo_atrasado"] : die(json_encode(array("exito" => 0, "info" => "Faltan Datos")));
        //este almacena le dinero que dio el estudiante
        $valor_que_pago = isset($_POST["cantidad_atrasado"]) ? $_POST["cantidad_atrasado"] : die(json_encode(array("exito" => 0, "info" => "Faltan Datos")));
        //valor que se inserta en la tabla de mora
        $valor_mora = isset($_POST["valor_mora"]) ? $_POST["valor_mora"] : die(json_encode(array("exito" => 0, "info" => "Faltan Datos")));
        $rsta = $consulta->consultarCuota($id_financiamiento);
        $valor_real_cuota = $rsta["valor_cuota"];
        $numero_cuota = $rsta["numero_cuota"];
        $fecha_pago = $rsta["fecha_pago"];
        if ($valor_mora != 0) {
            if ($valor_mora <= $valor_que_pago) {
                $valor_que_pago = $valor_que_pago - $valor_mora;
                $consulta->pagarMora($consecutivo, $numero_cuota, $fecha_pago, $valor_mora);
            } else {
                $consulta->pagarMora($consecutivo, $numero_cuota, $fecha_pago, $valor_que_pago);
                $valor_que_pago = 0;
            }
        }
        if ($valor_real_cuota == $valor_que_pago) { //pago parcial
            $rsta = $consulta->pagarCuota($id_financiamiento, $consecutivo);
            if ($rsta) {
                $consulta->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_que_pago, $id_financiamiento);
                $array = array("exito" => 1, "info" => "Pago realizado con éxito", "consecutivo" => $consecutivo);
            } else {
                $array = array("exito" => 0, "info" => "Error al realizar el Pago");
            }
        } else if ($valor_real_cuota < $valor_que_pago) { //ADELANTO
            $rsta = $consulta->consultarCuotasNoPagadas($consecutivo);
            $flag = true;
            for ($i = 0; $i < count($rsta) && $flag == true; $i++) {
                $id_financiamiento = $rsta[$i]["id_financiamiento"];
                $numero_cuota = $rsta[$i]["numero_cuota"];
                $fecha_pago = $rsta[$i]["fecha_pago"];
                $estado = $rsta[$i]["estado"];
                $valor_a_pagar = intval($rsta[$i]["valor_cuota"] - $rsta[$i]["valor_pagado"]);
                if ($valor_a_pagar <= $valor_que_pago) {
                    $consulta->pagarCuota($id_financiamiento, $consecutivo);
                    $consulta->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_a_pagar, $id_financiamiento);
                    $valor_que_pago = $valor_que_pago - $valor_a_pagar;
                } else {
                    $consulta->abonarCuota($id_financiamiento, $valor_que_pago);
                    $consulta->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_que_pago, $id_financiamiento);
                    $flag = false;
                }
                $array = array("exito" => 1, "info" => "Adelanto realizado con éxito", "consecutivo" => $consecutivo);
            }
        } else if ($valor_real_cuota > $valor_que_pago && $valor_que_pago > 0) { //abono
            $rsta = $consulta->abonarCuota($id_financiamiento, $valor_que_pago);
            if ($rsta) {
                $consulta->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_que_pago, $id_financiamiento);
                $array = array("exito" => 1, "info" => "Abono realizado con éxito", "consecutivo" => $consecutivo);
            } else {
                $array = array("exito" => 0, "info" => "Error al realizar el abono");
            }
        } else {
            $array = array("exito" => 1, "info" => "No se realizo ningun cambio al crédito", "consecutivo" => $consecutivo);
        }
        $valores_x_credito = $consulta->calcularValoresDeuda($consecutivo);
        if (
            $valores_x_credito["total_deuda"] == $valores_x_credito["total_pagado"]
        ) {
            $consulta->finalizarCredito($consecutivo);
        }
        echo json_encode($array);
        break;
        //Muestra la informacion especifica de la cuota
    case 'verInfoCuota':
        $id_cuota = isset($_POST["id_cuota"]) ? $_POST["id_cuota"] : die(json_encode(array("exito" => 0, "info" => "Cuota obligatoria")));
        $rsta = $consulta->infoCuota($id_cuota);
        echo json_encode($rsta);
        break;
        //edita la informacion especifica de la cuota
    case 'editarCuota':
        $id_cuota = isset($_POST["id_editar_cuota"]) ? $_POST["id_editar_cuota"] : die(json_encode(array("exito" => 0, "info" => "Cuota obligatoria")));
        $valor_pagado = isset($_POST["valor_pagado"]) ? $_POST["valor_pagado"] : "";
        $fecha_pago = isset($_POST["fecha_pago"]) ? $_POST["fecha_pago"] : "";
        $plazo_pago = isset($_POST["fecha_plazo_pago"]) ? $_POST["fecha_plazo_pago"] : "";
        $estado = isset($_POST["estado_cuota"]) ? $_POST["estado_cuota"] : "";
        $rsta = $consulta->editarCuota($id_cuota, $valor_pagado, $fecha_pago, $plazo_pago, $estado);
        if ($rsta) {
            $array = array("exito" => 1, "info" => "Editado con éxito");
        } else {
            $array = array("exito" => 0, "info" => "Error al editar");
        }
        echo json_encode($array);
        break;
        //edita la informacion especifica de la cuota
    case 'traerCategoria':
        $consecutivo_credito = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : "";
        //$categoria_credito = isset($_POST["categoria_credito"]) ? $_POST["categoria_credito"] : "";
        $rsta = $consulta->Categoriacredito($consecutivo_credito);
        if ($rsta >= 1) {
            $array = array("exito" => 1, "info" => $rsta["categoria_credito"]);
        } else {
            $array = array("exito" => 0, "info" => "Error al editar");
        }
        echo json_encode($array);
        break;
        //edita la informacion especifica de la cuota
    case 'guardarCategoria':
        $consecutivo_credito = isset($_POST["consecutivo_categoria"]) ? $_POST["consecutivo_categoria"] : "";
        $categoria_credito = isset($_POST["categoria_credito"]) ? $_POST["categoria_credito"] : "";
        $rsta = $consulta->guardarCategoria($consecutivo_credito, $categoria_credito);
        if ($rsta) {
            $array = array("exito" => 1, "info" => "El Consecutivo $consecutivo_credito ha sido asignado a $categoria_credito");
        } else {
            $array = array("exito" => 0, "info" => "Error al editar");
        }
        echo json_encode($array);
        break;
    case 'calcularInteres':
        $valor_deuda_total = 0;
        $valor_mas_interes = 0;
        $data = array();
        // Obtener el id del financiamiento
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Cuota obligatoria")));
        // Consultamos en la base de datos las cuotas que no se han pagado hasta la fecha actual
        $plazo_pago = $consulta->consultarCuotasAntiguaNoPagada($consecutivo)["plazo_pago"];
        $fecha_actual = date("Y-m-d"); 
        $meses_diferencias =  $consulta->contarMeses($plazo_pago, $fecha_actual);
        $anio_mes_plazo = date("Y-m", strtotime($plazo_pago));
        $dia_cuota = date("d", strtotime($plazo_pago));
        
        for ($i = 0; $i < $meses_diferencias ; $i++) { 
            
            $interes = $consulta->TraerInteresMora($anio_mes_plazo);
            $porcentaje_interes = $interes["porcentaje"];
            $nombre_mes = $interes['nombre_mes'];
            $fecha_interes = $interes["fecha_mes"];
            $dia_final_interes = date("d", strtotime($fecha_interes));

            $cuota = $consulta->consultarCuotaAtrasada($consecutivo, $anio_mes_plazo);
            // Obtenemos el plazo para pagar a la cuota
            $id_financiamiento = isset($cuota["id_financiamiento"])?$cuota["id_financiamiento"]:0;
            // Obtenemos el plazo para pagar a la cuota
            $plazo_pago = isset($cuota["plazo_pago"])?$cuota["plazo_pago"]:0;
            // Obtenemos el valor abonado a la cuota
            $valor_cuota = isset($cuota["valor_cuota"])?$cuota["valor_cuota"]:0;
            // Obtenemos el valor abonado a la cuota
            $valor_pagado = isset($cuota["valor_pagado"])?$cuota["valor_pagado"]:0;
            // Calculamos el valor restante a pagar (es por si se ha realizado abonos)
            $valor_cuota =  $valor_cuota - $valor_pagado;
            // Almacenamos el valor total de la deuda indica lo que lleva atrasado sin mora
            $valor_deuda_total += $valor_cuota;
            // Almacenamos el valor de la deuda pero ahora teniendo en cuenta el valor del interés
            $valor_mas_interes += $valor_cuota;
            // Obtenemos solo el año y mes actual
            $anio_mes_actual = date("Y-m");
            if ($anio_mes_actual == $anio_mes_plazo) {
                $dias_transcurridos = ($id_financiamiento == 0)?date("d"):date("d") - $dia_cuota;
            } else {
                // Calculamos los días transcurridos
                $dias_transcurridos =  $dia_final_interes - $dia_cuota;
                // Si es el primer ciclo, el valor debe ser la resta de los días, sino, sería el total del mes 
                $dias_transcurridos = ($i == 0) ? $dias_transcurridos : $dia_final_interes;
            }
            // pow es potenciación, es decir calculamos el porcentaje por medio de un cálculo que incluye potenciación
            $porcentaje = pow((1 + ($porcentaje_interes / 100)), (1 / 12)) - 1;
            // Se calcula el valor del interés
            $valor_interes = $valor_deuda_total * ($porcentaje / $dia_final_interes * $dias_transcurridos);
            // Se suma al total de los intereses
            $interes_total += $valor_interes;
            // Este valor es simplemente datos de ayuda a la tabla
            $valor_mas_interes += $valor_interes;
            // Mostrar el valor final en la tabla
            $data[] = array(
                '0' => $nombre_mes . " - $anio_mes_plazo",
                '1' => $dias_transcurridos,
                '2' => round($valor_deuda_total),
                '3' => round($valor_interes),  // Días hasta hoy en el mes actual
                '4' => round($valor_mas_interes),
                '5' => number_format(($porcentaje * 100), 2)
            );
            $consulta->actualizarInteresCuota($id_financiamiento, round($valor_interes));


            $anio_mes_plazo  = date("Y-m", strtotime($anio_mes_plazo . "+1 month"));
        }
        // Preparar los resultados para el datatables
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data,
            "total_interes" => round($interes_total),
            "total_abono_interes" => $consulta->calculoAbonoInteres($consecutivo),
        );
        echo json_encode($results);
        break;
}
