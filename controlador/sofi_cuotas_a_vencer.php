<?php
require_once "../modelos/SofiCuotasAVencer.php";
require "../mail/send.php";
require "../mail/template3DiasAntes.php";
//modelo en el cual estan las funciones a base de datos 
$consulta = new SofiCuotasAVencer();
//creamos array con valores del mes para añadirlos al mail
$nombres_mes = array("1" => "Enero", "2" => "Febrero", "3" => "Marzo", "4" => "Abril", "5" => "Mayo", "6" => "Junio", "7" => "Julio", "8" => "Agosto", "9" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre",);
//dependiendo de la opcion que envien por el GET, el switch determinara donde entrar
switch ($_GET['op']) {
        //Listar todos los financiados que esten a 3 dias de cumplir su cuota


    case 'listarCuotasAVencer': //Listar todos los financiados que esten a 3 dias de cumplir su cuota
        //hacemos peticion al modelo
        $rsta = $consulta->listarCuotasAVencer();
        //creamos un array
        $array = array();
        $etiquetas = $consulta->etiquetas();
        //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
        for ($i = 0; $i < count($rsta); $i++) {
            $datossofimatricula=$consulta->sofimatricula($rsta[$i]["id_persona"]);
            $verDetalles = '<button class="btn bg-teal btn-sm" title="Ver datos" data-toggle="modal" onclick="verInfoSolicitante(' . $rsta[$i]["id_persona"] . ')" data-target="#verInfoSolicitante"><i data-toggle="tooltip" class="fa-solid fa-user" data-original-title="Ver detalles"></i></button>';
            $tareas = '<button class="btn bg-lightblue btn-sm" title="Ver seguimientos" data-toggle="modal" onclick="verHistorial(' . $rsta[$i]["id_credencial"] . ')" data-target="#verTareas"><i data-toggle="tooltip" class="fas fa-eye" data-original-title="Ver y Añadir Seguimientos"></i></button>';
            $cuotas = '<button class="btn bg-yellow btn-sm" title="Ver cuotas" data-toggle="modal" onclick="verCuotas(' . $rsta[$i]["consecutivo"] . ')" data-target="#modal_cuotas"><i data-toggle="tooltip" data-original-title="Información Cuotas" class="fas fa-calendar-alt"></i></button>';
            $anadir = '<button class="btn bg-purple btn-sm" title="Nuevo seguimiento o tarea" data-toggle="modal" onclick="agregarTareaSegui('.$rsta[$i]["id_credencial"].','.$rsta[$i]["id_persona"].')" data-target="#anadirTareas"><i data-toggle="tooltip" class="fa-solid fa-plus data-original-title="Añadir Seguimientos"></i></button>';
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
                                
            $select .= '<select class="form-control asesor" onchange="cambiarEtiqueta('.$rsta[$i]["id_persona"].',this.value)">';
                for ($s=0; $s < count($etiquetas); $s++) {
                    
                    if ($etiquetas[$s]['id_etiquetas'] == $datossofimatricula['id_etiqueta']) {
                        $select .= '<option value="'.$etiquetas[$s]['id_etiquetas'].'" selected>'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
                    } else {
                        $select .='<option value="'.$etiquetas[$s]['id_etiquetas'].'">'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
                    }
                }
            $select .= '</select>';

            $array[] = array(
                "0" => '<div class="btn-group">
                ' . $verDetalles . $cuotas . $tareas . $anadir . $boton_whatsapp . '
                </div>',
                "1" => $rsta[$i]["nombres"],
                "2" => $rsta[$i]["apellidos"],
                "3" => $rsta[$i]["celular"],
                "4" => $rsta[$i]["email"],
                "5" => $rsta[$i]["consecutivo"],
                "6" => $consulta->formatoDinero($rsta[$i]["valor_cuota"]),
                "7" => $rsta[$i]["plazo_pago"],
                "8" => '<button class="btn bg-orange btn-block text-white" onclick="enviarMail(' . $rsta[$i]["id_persona"] . ')"><i class="fas fa-envelope-square text-white"></i> <span class="text-white">Enviar</span></button>',
                "9" => $select,
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

    case 'enviarMail': //envia un mail a un financiado especifico
        //tomamos el valor entero del mes actual
        $mes = intval(date('m'));
        //obtenemos el id del financiado desde un POST 
        $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : die(json_encode(array("exito" => 0, "info" => "El Financiado es obligatorio")));
        //hacemos peticion al modelo para traer datos del finanaciado
        $rsta = $consulta->enviarMailIndividual($id_persona);
        //creamos el contenido del template para el correo con la libreria incluida al inicio
        $contenido = set_template($rsta["nombres"] . " " . $rsta["apellidos"], $nombres_mes[$mes]);
        //si el correo se envia correctamente, devuelve 1 al js y si no un 0
        if (enviar_correo($rsta["email"], "CIAF - Recordatorio de cuota", $contenido)) {
            //actualizamos el estado de mail enviado en financiados
            $array = array(
                "exito" => 1
            );
            //se actualiza si es 1 el exito
            $consulta->actualizarEstadoMail($id_persona);
        } else {
            $array = array(
                "exito" => 0,
            );
        }
        echo json_encode($array);
    break;

    case 'enviarMailTodos': //envia un mail a un financiado especifico
        //tomamos el valor entero del mes actual
        $mes = intval(date('m'));
        //hacemos peticion al modelo
        $rsta = $consulta->listarCuotasAVencer();
        //creamos un array
        $array = array();
        //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
        for ($i = 0; $i < count($rsta); $i++) {
            //creamos el contenido del template para el correo con la libreria incluida al inicio
            $contenido = set_template($rsta[$i]["nombres"] . " " . $rsta[$i]["apellidos"], $nombres_mes[$mes]);
            //se actualiza si es correcto
            if (enviar_correo($rsta[$i]["email"], "CIAF - Recordatorio de cuota", $contenido)) $consulta->actualizarEstadoMail($rsta[$i]["id_persona"]);
        }
        echo json_encode(array("exito" => 1));
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
                $estado = '<span class="badge badge-danger"> Atrasado </span>';
            } else if ($rsta[$i]["estado"] == "Abonado") {
                $estado = '<span class="badge bg-orange"> Abonado </span>';
            } else if ($rsta[$i]["estado"] == "Pagado") {
                $estado = '<span class="badge badge-success"> Pagado </span>';
            } else {
                $estado = '<span class="badge badge-primary"> A Pagar </span>';
            }

            if ($rsta[$i]["plazo_pago"] <= $hoy) {
                if ($rsta[$i]["estado"] == "Pagado") {
                    $diferencia = "0" . ' días';
                } else {
                    $diferencia = $consulta->diferenciaFechas($rsta[$i]["plazo_pago"], $hoy) . ' días';
                }
            } else {
                $diferencia = "";
            }
            $array[] = array(
                "0" => $estado,
                "1" => $rsta[$i]["numero_cuota"],
                "2" => $rsta[$i]["valor_cuota"],
                "3" => $rsta[$i]["valor_pagado"],
                "4" => $rsta[$i]["fecha_pago"],
                "5" => $rsta[$i]["plazo_pago"],
                // "6" => ($rsta[$i]["estado"]=="Pagado")?0:$consulta->diferenciaFechas($rsta[$i]["plazo_pago"],$hoy)." días"
                "6" => $diferencia
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

        $rspta = $consulta->cambiarEtiqueta($id_persona,$valor);

        if ($rspta == 0) {
			echo "1";
		} else {

			echo "0";
		}

    break;

    }
