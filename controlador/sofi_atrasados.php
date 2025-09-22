<?php
require_once "../modelos/SofiAtrasados.php";
//modelo en el cual estan las funciones a base de datos 
$consulta = new SofiAtrasados();
//creamos array con valores del mes para añadirlos al mail
$nombres_mes = array(
    "1" => "Enero",
    "2" => "Febrero",
    "3" => "Marzo",
    "4" => "Abril",
    "5" => "Mayo",
    "6" => "Junio",
    "7" => "Julio",
    "8" => "Agosto",
    "9" => "Septiembre",
    "10" => "Octubre",
    "11" => "Noviembre",
    "12" => "Diciembre",
);
$id_usuario = $_SESSION["id_usuario"];
//dependiendo de la opcion que envien por el GET, el switch determinara donde entrar
switch ($_GET['op']) {
    case 'traerPeriodos':
        $rspta = $consulta->traerPeriodos();
        if (count($rspta) >= 1) {
            echo json_encode($rspta);
        } else {
            echo json_encode(array());
        }
        break;
        //Listar todos los financiados que esten a 3 dias de cumplir su cuota
    case 'agregarMensajeTodos':
        $cantidad_agregados = 0;
        $mensaje_todos = $_POST["mensaje_todos"];
        //hacemos peticion al modelo
        $rsta = $consulta->listarAtrasadosNoEnCobro();
        //creamos un array
        $array = array();
        for ($i = 0; $i < count($rsta); $i++) {
            if ($rsta[$i]["consecutivo"] != @$rsta[($i - 1)]["consecutivo"]) {
                //agregar Seguimiento indicando que ya se envio en mensaje
                $id_persona = $rsta[$i]["id_persona"];
                $id_credencial = $rsta[$i]["id_credencial"];
                $tipo = "mensaje";
                $id_usuario = $_SESSION['id_usuario'];
                $consulta->insertarSeguimiento($mensaje_todos, $tipo, $id_usuario, $id_persona, $id_credencial);
                $cantidad_agregados++;
            }
        }
        echo json_encode(array("exito" => 1, "info" => "Se han agregado $cantidad_agregados seguimientos exitosamente"));
        break;
    case 'listarAtrasados': //Listar todos los financiados que esten a 3 dias de cumplir su cuota
        $periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
        //hacemos peticion al modelo
        $rsta = $consulta->listarAtrasados($periodo);
        //creamos un array
        $array = array();
        $etiquetas = $consulta->etiquetas();
        $buscarAsesor = $consulta->buscarAsesores();
        for ($i = 0; $i < count($rsta); $i++) {
            $datossofimatricula = $consulta->sofimatricula($rsta[$i]["id_persona"]);
            $ultimoseguimiento = $consulta->ultimoseguimiento($rsta[$i]["id_persona"]);
            $fecha_hora = $ultimoseguimiento["created_at"];
            $partes = explode(' ', $fecha_hora);
            $fecha = $partes[0]; // '2020-04-30'
            $hora = $partes[1];  // '11:28:25'
            $fecha_obj = new DateTime($fecha_hora);
            $formato_12_horas = $fecha_obj->format('g:i A');
            if ($fecha != "") {
                $fecha = $consulta->fechaesp($fecha);
            } else {
                $fecha = "";
                $formato_12_horas = "";
            }
            $verDetalles = '<button class="btn bg-teal btn-sm" data-toggle="modal" onclick="verInfoSolicitante(' . $rsta[$i]["id_persona"] . ')" data-target="#verInfoSolicitante"><i data-toggle="tooltip" title="" class="fas fa-user" data-original-title="Ver detalles" style="color: white !important"></i></button>';
            $tareas = '<button class="btn bg-lightblue btn-sm" title="Ver seguimientos" data-toggle="modal" onclick="verHistorial(' . $rsta[$i]["id_credencial"] . ')" data-target="#verTareas"><i data-toggle="tooltip" class="fas fa-eye" data-original-title="Ver y Añadir Seguimientos"></i></button>';
            $cuotas = '<button class="btn btn-sm bg-yellow" data-toggle="modal" onclick="verCuotas(' . $rsta[$i]["consecutivo"] . ')" data-target="#modal_cuotas"><i data-toggle="tooltip" data-original-title="Información Cuotas" class="fas fa-calendar-alt"></i></button>';
            $anadir = '<button class="btn bg-purple btn-sm" title="Nuevo seguimiento o tarea" data-toggle="modal" onclick="agregarTareaSegui(' . $rsta[$i]["id_credencial"] . ',' . $rsta[$i]["id_persona"] . ')" data-target="#anadirTareas"><i data-toggle="tooltip" class="fa-solid fa-plus data-original-title="Añadir Seguimientos"></i></button>';
            $consecutivo_anterior = @$rsta[($i - 1)]["consecutivo"];
            if ($rsta[$i]["consecutivo"] != $consecutivo_anterior) {
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
                $consulta_atrasado = $consulta->cantCuotasAtrasado($rsta[$i]["consecutivo"]);
                $numero_cuotas = $consulta_atrasado["num_cuotas"];
                $total_atrasado = $consulta_atrasado["total"] - $consulta_atrasado["pagado"];
                $select  = '';
                $select .= '<select class="form-control asesor" onchange="cambiarEtiqueta(' . $rsta[$i]["id_persona"] . ',this.value)" style="height:auto;font-size:12px">';
                for ($s = 0; $s < count($etiquetas); $s++) {
                    if ($etiquetas[$s]['id_etiquetas'] == $datossofimatricula['id_etiqueta']) {
                        $select .= '<option value="' . $etiquetas[$s]['id_etiquetas'] . '" selected>' . $etiquetas[$s]['etiqueta_nombre'] . '</option>';
                    } else {
                        $select .= '<option value="' . $etiquetas[$s]['id_etiquetas'] . '">' . $etiquetas[$s]['etiqueta_nombre'] . '</option>';
                    }
                }
                $select .= '</select>';
                $selectasesores  = '';
                $selectasesores .= '<select class="form-control asesor selectpicker_asesor" data-live-search="true" onchange="cambiarAsesor(' . $datossofimatricula["id"] . ',this.value)" style="height:auto;font-size:12px">';
                $selectasesores .= '<option value="" >Sin asignar</option>';
                for ($t = 0; $t < count($buscarAsesor); $t++) {
                    if ($buscarAsesor[$t]['id_usuario'] == $datossofimatricula['sofi_matricula_id_asesor']) {
                        $selectasesores .= '<option value="' . $buscarAsesor[$t]['id_usuario'] . '" selected>' . $buscarAsesor[$t]['usuario_nombre'] . ' ' . $buscarAsesor[$t]['usuario_apellido'] . '</option>';
                    } else {
                        $selectasesores .= '<option value="' . $buscarAsesor[$t]['id_usuario'] . '">' . $buscarAsesor[$t]['usuario_nombre'] . ' ' . $buscarAsesor[$t]['usuario_apellido'] . '</option>';
                    }
                }
                $selectasesores .= '</select>';
                $diasatraso = $consulta->diferenciaFechas($rsta[$i]["fecha_pago"], date("Y-m-d"));
                $array[] = array(
                    "0" => '<div class="btn-group">' . $verDetalles . $cuotas . $tareas . $anadir . $boton_whatsapp . '</div>',
                    "1" => '<div style="width:180px">' . $select . '</div>',
                    "2" => $rsta[$i]["numero_documento"],
                    "3" => '<div style="width:380px">' . $rsta[$i]["nombres"] . " " . $rsta[$i]["apellidos"] . '</div>',
                    "4" => $rsta[$i]["celular"],
                    "5" => $rsta[$i]["email"],
                    "6" => '<div style="width:420px">' . $rsta[$i]["programa"] . '</div>',
                    "7" => $rsta[$i]["semestre"],
                    "8" => '<div style="width:220px">' . $rsta[$i]["jornada"] . '</div>',
                    "9" => $rsta[$i]["labora"],
                    "10" => $numero_cuotas,
                    "11" =>  $diasatraso,
                    "12" => $consulta->formatoDinero($rsta[$i]["valor_cuota"]),
                    "13" => $consulta->formatoDinero($total_atrasado),
                    "14" => ($rsta[$i]["en_cobro"] == 1) ? "SI" : "NO",
                    "15" => $rsta[$i]["periodo"],
                    "16" => '<div style="width:220px">' . $consulta->fechaesp($rsta[$i]["fecha_pago"]) . '</div>',
                    "17" => '<div style="width:220px">' . $fecha . '</div>',
                    "18" => $formato_12_horas,
                    "19" => '<div style="width:180px">' . $selectasesores . '</div>',
                );
            }
            $numero_cuotas = 0;
            $total_atrasado = 0;
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
    case 'cambiarAsesor':
        $id_sofi_matricula = $_POST['id'];
        $valor = $_POST['valor'];
        $rspta = $consulta->cambiarAsesor($id_sofi_matricula, $valor);
        if ($rspta == 0) {
            echo "1";
        } else {
            echo "0";
        }
        break;
}