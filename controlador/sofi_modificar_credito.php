<?php
require_once "../modelos/SofiModificarCredito.php";
//modelo en el cual estan las funciones a base de datos 
$consulta = new SofiModificarCredito();
//dependiendo de la opcion que envien por el GET, el switch determinara donde entrar
switch ($_GET['op']) {
        //Listar todos los financiados que esten a 3 dias de cumplir su cuota
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
            //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
            for ($i = 0; $i < count($rsta); $i++) {
                $array[] = array(
                    "0" => '<div class="input-group">
                        <input type="number" class="form-control form-control-sm" name="numero_cuota" onChange="modificarCampo(`numero_cuota`, this.value, ' . $rsta[$i]["id_financiamiento"] . ', ' . $rsta[$i]["id_matricula"] . ')" value="' . $rsta[$i]["numero_cuota"] . '">
                        <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="button" onclick="eliminarCuota(' . $rsta[$i]["id_financiamiento"] . ', ' . $rsta[$i]["id_matricula"] . ')" title="Eliminar Cuota"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>',
                    "1" => '<select class="form-control form-control-sm " name="estado" onchange="modificarCampo(`estado`, this.value, ' . $rsta[$i]["id_financiamiento"] . ', ' . $rsta[$i]["id_matricula"] . ')">
                                <option ion disabled value=""> -- Seleccione un estado --</option>
                                <option value="A Pagar" ' . (($rsta[$i]["estado"] == "A Pagar") ? "selected" : "") . '> A pagar </option>
                                <option value="Abonado" ' . (($rsta[$i]["estado"] == "Abonado") ? "selected" : "") . '> Abonado </option>
                                <option value="Pagado"  ' . (($rsta[$i]["estado"] == "Pagado") ? "selected" : "") . '> Pagado</option>
                            </select>',
                    "2" => '<input type="number" class="form-control form-control-sm " name="valor_cuota" onChange="modificarCampo(`valor_cuota`, this.value, ' . $rsta[$i]["id_financiamiento"] . ', ' . $rsta[$i]["id_matricula"] . ')" value="' . $rsta[$i]["valor_cuota"] . '">',
                    "3" => '<input type="number" class="form-control form-control-sm " name="valor_pagado" onChange="modificarCampo(`valor_pagado`, this.value, ' . $rsta[$i]["id_financiamiento"] . ', ' . $rsta[$i]["id_matricula"] . ')" value="' . $rsta[$i]["valor_pagado"] . '">',
                    "4" => '<input type="date" class="form-control form-control-sm " name="fecha_pago" onChange="modificarCampo(`fecha_pago`, this.value, ' . $rsta[$i]["id_financiamiento"] . ', ' . $rsta[$i]["id_matricula"] . ')" value="' . $rsta[$i]["fecha_pago"] . '">',
                    "5" => '<input type="date" class="form-control form-control-sm " name="plazo_pago" onChange="modificarCampo(`plazo_pago`, this.value, ' . $rsta[$i]["id_financiamiento"] . ', ' . $rsta[$i]["id_matricula"] . ')" value="' . $rsta[$i]["plazo_pago"] . '">',
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
                "estado_financiacion" => $estado_financiacion . ' <button class="btn btn-flat btn-sm btn-primary" onclick="cambiar_estado_financiacion( ' . $estado_credito . ', ' . $consecutivo . ', ' . $rsta["id_persona"] . ' )"><i class="fas fa-handshake" data-toggle="tooltip" title="' . (($rsta["estado_financiacion"] == 0) ? "Activar" : "Inactivar") . ' Persona"></i></button>',
                "estado_ciafi" => $estado_ciafi . ' <button class="btn btn-flat btn-sm btn-primary" onclick="cambiar_estado_ciafi(' . $rsta["estado_ciafi"] . ',' . $consecutivo . ')"><i class="fas fa-lock' . (($rsta["estado_ciafi"] == 0) ? "-open" : "") . '" data-toggle="tooltip" title="' . (($rsta["estado_ciafi"] == 0) ? "Desbloquear" : "Bloquear") . ' Persona"></i></button>',
                "en_cobro" => $en_cobro . ' <button class="btn btn-flat btn-sm btn-primary" onclick="cambiar_estado_cobro(' . $rsta["en_cobro"] . ',' . $consecutivo . ')"><i class="fas fa-file' . (($rsta["en_cobro"] == 0) ? "-import" : "-export") . '" data-toggle="tooltip" title="' . (($rsta["en_cobro"] == 0) ? "Enviar A" : "Sacar De") . ' Cobro"></i></button>',
                "seguimiento" => '<button class="btn bg-info btn-flat btn-sm" data-toggle="modal" onclick="verTareas(' . $rsta["id_persona"] . ')" data-target="#verTareas"><i data-toggle="tooltip" class="fas fa-search-plus" data-original-title="Ver y Añadir Seguimientos"></i>&nbsp;</button>',
                "categorizar" => $rsta["categoria_credito"] . " " . $categorizar,
                "historial_pagos" => '
                        <button class="btn bg-purple btn-flat" data-toggle="modal" data-target="#modal_historial_pagos" onclick="historial_pagos(' . $consecutivo . ')"> 
                            <i data-toggle="tooltip" class="fas fa-history" data-original-title="Historial De Pagos"></i>
                        </button>
                        <button class="btn bg-info btn-flat" data-toggle="modal" data-target="#modal_crear_cuota" onclick="datos_para_cuota(' . $consecutivo . ',' . $rsta["id_persona"] . ')"> 
                            <i data-toggle="tooltip" class="fas fa-plus" data-original-title="Inserta nueva cuota"></i>
                        </button>
                        '
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
            $array = array("exito" => 1, "saldo_debito" => $consulta->formatoDinero($rsta["saldo_debito"]));
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
                "2" => $rsta[$i]["fecha_pago"],
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
        $rsta = $consulta->cambiarEstadoCiafi((($estado_ciafi == 0) ? 1 : 0), $consecutivo);
        if ($rsta) {
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
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->verSeguimientos($id_persona);
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
        //Guarda la tarea
    case 'guardarTarea':
        $id_persona = isset($_POST["id_persona_tarea"]) ? $_POST["id_persona_tarea"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $tarea_motivo = isset($_POST["tarea_motivo"]) ? $_POST["tarea_motivo"] : "";
        $descripcion = isset($_POST["tarea_descripcion"]) ? $_POST["tarea_descripcion"] : "";
        $tarea_hora = isset($_POST["tarea_hora"]) ? $_POST["tarea_hora"] : "";
        $tarea_fecha = isset($_POST["tarea_fecha"]) ? $_POST["tarea_fecha"] : "";
        $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
        $rsta = $consulta->insertarTarea($descripcion, $tarea_motivo, $id_usuario, $id_persona, $tarea_fecha, $tarea_hora);
        if ($rsta) {
            $array = array("exito" => 1, "info" => "Tarea agregada con exito", "id_persona" => $id_persona);
        } else {
            $array = array("exito" => 0, "info" => "Error al agregar la tarea");
        }
        echo json_encode($array);
        break;
        //Guarda El seguimiento
    case 'guardarSeguimientos':
        $id_persona = isset($_POST["id_persona_seguimiento"]) ? $_POST["id_persona_seguimiento"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
        $tipo = isset($_POST["seg_tipo"]) ? $_POST["seg_tipo"] : "";
        $descripcion = isset($_POST["seg_descripcion"]) ? $_POST["seg_descripcion"] : "";
        $rsta = $consulta->insertarSeguimiento($descripcion, $tipo, $id_usuario, $id_persona);
        if ($rsta) {
            $array = array("exito" => 1, "info" => "Seguimiento realizado con exito", "id_persona" => $id_persona);
        } else {
            $array = array("exito" => 0, "info" => "Error al agregar el seguimiento");
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
        //Modificar algun campo de la base de datos
    case 'modificarCampo':
        $campo = isset($_POST["campo"]) ? $_POST["campo"] : die(json_encode(array('exito' => 0, 'info' => 'Campo Obligatorio')));
        $valor = isset($_POST["valor"]) ? $_POST["valor"] : die(json_encode(array('exito' => 0, 'info' => 'Valor Obligatorio')));
        $id_financiamiento = isset($_POST["id_financiamiento"]) ? $_POST["id_financiamiento"] : die(json_encode(array('exito' => 0, 'info' => 'Cuota Obligatoria')));
        $rsta = $consulta->modificarCampo($campo, $valor, $id_financiamiento);
        if ($rsta) {
            $data = array('exito' => 1, 'info' => 'Cambio realizado con exito');
        } else {
            $data = array('exito' => 0, 'info' => 'Error al guardar la información');
        }
        echo json_encode($data);
        break;
        //eliominar cuota especifica 
    case 'eliminarCuota':
        $id_financiamiento = isset($_POST["id_financiamiento"]) ? $_POST["id_financiamiento"] : die(json_encode(array('exito' => 0, 'info' => 'Cuota Obligatoria')));
        $rsta = $consulta->eliminarCuota($id_financiamiento);
        if ($rsta) {
            $data = array('exito' => 1, 'info' => 'Eliminada con exito');
        } else {
            $data = array('exito' => 0, 'info' => 'Error al eliminar la información');
        }
        echo json_encode($data);
        break;
        //eliminar numero de cuota especifica
    case 'guardarCuota':
        $id_matricula = isset($_POST["consecutivo_cuota"]) ? $_POST["consecutivo_cuota"] : "";
        $id_persona = isset($_POST["persona_cuota"]) ? $_POST["persona_cuota"] : "";
        $numero_cuota = isset($_POST["numero_cuota"]) ? $_POST["numero_cuota"] : "";
        $estado = isset($_POST["estado"]) ? $_POST["estado"] : "";
        $valor_cuota = isset($_POST["valor_cuota"]) ? $_POST["valor_cuota"] : "";
        $valor_pagado = isset($_POST["valor_pagado"]) ? $_POST["valor_pagado"] : "";
        $fecha_pago = isset($_POST["fecha_pago"]) ? $_POST["fecha_pago"] : "";
        $plazo_pago = isset($_POST["plazo_pago"]) ? $_POST["plazo_pago"] : "";
        $rspta = $consulta->guardarCuota($id_matricula, $id_persona, $numero_cuota, $estado, $valor_cuota, $valor_pagado, $fecha_pago, $plazo_pago);
        if ($rspta) {
            $data = array('exito' => 1, 'info' => 'Cuota registrada con exito');
        } else {
            $data = array('exito' => 0, 'info' => 'Todo lo que podia fallar, ¡Falló!');
        }
        echo json_encode($data);
        break;
}
