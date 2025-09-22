<?php
use function Symfony\Component\VarDumper\Dumper\esc;
require_once "../modelos/SofiConsultarCuotas.php";
//modelo en el cual estan las funciones a base de datos 
$consulta = new SofiConsultarCuotas();
//dependiendo de la opcion que envien por el GET, el switch determinara donde entrar
switch ($_GET['op']) {
    case 'listarCuotas':
        $tipo_busqueda = isset($_POST["tipo_busqueda"]) ? $_POST["tipo_busqueda"] : die();
        $dato_busqueda = isset($_POST["dato_busqueda"]) ? $_POST["dato_busqueda"] : die();
        $hoy = date("Y-m-d");
        //hacemos peticion al modelo
        $rsta = $consulta->listarCuotas($tipo_busqueda, $dato_busqueda);
        //creamos un array
        $array = array();
        //2 = consecutivo; 1 y 3 = nombre o cedula  
        if ($tipo_busqueda == 2) {
            //creamos las variables de los botones
            $btn_pagado = '<span class="badge bg-green col-12"><i class="fas fa-check"></i><i> Pagado</i></span>';
            $btn_progreso_normal = '<span class="badge bg-yellow col-12"><i class="fas fa-spinner"></i><i> A pagar</i></span>';
            $btn_proceso_atrasado = '<span class="badge bg-danger col"><i class="fas fa-calendar-times"></i> <i> Atrasado </i> </span>';
            $btn_anulado = '<span class="badge bg-orange col"><i class="fas fa-handshake-alt-slash"></i> <i> Anulado</i></span>';
            $btn_abonado = '<span class="badge bg-info col"><i class="fas fa-handshake"></i> <i> Abonado</i></span>';
            //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
            for ($i = 0; $i < count($rsta); $i++) {
                if (strtotime($hoy) >= strtotime($rsta[$i]["fecha_pago"])) {
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
                //echo $rsta[$i]["estado_credito"];
                $array[] = array(
                    "0" => '<div class="text-center" style="padding:0px  !important; margin:0px !important;">
                                ' . (($rsta[$i]["estado_credito"] == "Anulado") ? $btn_anulado : (($e == "Pagado") ? $btn_pagado : (($flag) ? $btn_progreso : (($e == "Abonado" && (strtotime($hoy) <= strtotime($rsta[$i]["plazo_pago"]))) ? $btn_abonado: $btn_progreso)))) . '
                            </div>',
                    "1" => $rsta[$i]["numero_cuota"],
                    "2" => "$ ".$consulta->formatoDinero($rsta[$i]["valor_cuota"]),
                    "3" => "$ ".$consulta->formatoDinero($rsta[$i]["valor_pagado"]),
                    "4" => $rsta[$i]["plazo_pago"],
                    "5" => ($rsta[$i]["estado"] == "A Pagar" && strtotime($hoy) >= strtotime($rsta[$i]["fecha_pago"])) ? $dias_atraso : (($rsta[$i]["estado"] == "A Pagar" && strtotime($hoy) < strtotime($rsta[$i]["fecha_pago"])) ? "-" . $dias_atraso : 0),
                );
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
            $estado_ciafi = ($rsta["estado_ciafi"] == 0) ? "Bloqueado" : "No Bloqueado";
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
                "estado_financiacion" => $estado_financiacion,
                "estado_ciafi" => $estado_ciafi,
                "en_cobro" => $en_cobro,
                "seguimiento" => '<button class="btn bg-lightblue btn-sm" title="Ver seguimientos" data-toggle="modal" onclick="verHistorial(' . $rsta["id_credencial"] . ')" data-target="#verTareas"><i data-toggle="tooltip" class="fas fa-eye" data-original-title="Ver y Añadir Seguimientos"></i></button>',
                "categorizar" => $rsta["categoria_credito"],
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
}
