<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/WhatsappDependencia.php";
$consulta = new whatsappDependencia();
$id_dependencia = $_SESSION["id_dependencia"];
$_SESSION["dependencia"] = isset($_SESSION["dependencia"])? $_SESSION["dependencia"]:$consulta->Dependencia($id_dependencia);
$meses = array("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
$icono_mensaje = array(
    "audio" => "<i class='fas fa-microphone'></i>  Audio",
    "sticker" => "<i class='fas fa-sticky-note'></i> Sticker ",
    "image" => "<i class='far fa-image'></i>  Imagen",
    "video" => "<i class='fas fa-video'></i>  Video",
    "document" => "<i class='fas fa-file-invoice'></i> Documento",
);
//TOKEN QUE NOS DA FACEBOOK
$token = 'EAAk4f3NT6VwBOzzZBzYY5PFJd76rX80WvBMPZBkARguKTnyScQCqK9xZA6ZBTOxLuFDxdID3UM8v4C9gRHx2KPq1twwu5x1zUcSWGzFCGny9gLv0snyag7hAK8EeiU5M0yYcRu3HW41wLsH1lOp1cIq2sprZAm0UktShtna8UvkbWNfap81EgjZCF8gXld9j6dEh8ZBK7N1W8LOHmBD';
//IDENTIFICADOR DE NÚMERO DE TELÉFONO
$telefonoID = '105782292504697';
switch ($_GET['op']) {
    case 'listarChats':
        $data = array();
        //cuando se procesa con el servidor, se envia esta variable para busdcar en el server
        $valor_buscado = isset($_POST['valor_buscado']) ? $_POST['valor_buscado'] : "";
        $estado_chat = isset($_POST['estado_chat']) ? $_POST['estado_chat'] : "";
        $chats = $consulta->listarChats($valor_buscado, $estado_chat);
        $total_sin_mostrar = $consulta->CantidadNoMostrados();
        for ($i = 0; $i < count($chats); $i++) {
            $identificacion = $chats[$i]["credencial_identificacion"];
            $id_credencial = $chats[$i]["id_credencial"];
            $datos_escuela = $consulta->ListarEscuela($id_credencial);
            $nombre_escuela = isset($datos_escuela["nombre_corto"]) ? $datos_escuela["nombre_corto"] : "";
            $bg_color = isset($datos_escuela["bg_color"]) ? $datos_escuela["bg_color"] : "";
            $nombre_completo = trim($chats[$i]["credencial_nombre"] . " " . $chats[$i]["credencial_nombre_2"] . " " . $chats[$i]["credencial_apellido"]);
            $numero_whatsapp = "57" . $chats[$i]["numero_whatsapp"];
            $ultimo_mensaje = $chats[$i]["ultimo_mensaje"];
            $tipo_mensaje_masivo = (!is_null($chats[$i]["tipo_mensaje_masivo"])) ? '<span class="badge bg-navy"> ' . $chats[$i]["tipo_mensaje_masivo"] . '</span>' : '';
            $mensajes_no_vistos = $chats[$i]["mensajes_no_vistos"];
            $fecha = explode(" ", $chats[$i]["ultima_modificacion"])[0];
            $dia = explode("-", $fecha)[2];
            $mes = explode("-", $fecha)[1];
            $url = "../files/estudiantes/" . $identificacion . ".jpg";
            if (file_exists($url)) {
                $url = "../files/estudiantes/" . $identificacion . ".jpg";
            } else {
                $url = 'https://ciaf.digital/files/null.jpg';
            }
            $text_success = "";
            $display_num_vistos = "d-none";
            $font_bold = "";
            if ($mensajes_no_vistos > 0) {
                $text_success = "text-success";
                $display_num_vistos = "";
                $font_bold = "font-weight-bold";
            }
            $data[] =  array('
                <div class="container pointer" onclick="seleccionarChat(this,' . $numero_whatsapp . ')" data-chat="' . $numero_whatsapp . '">
                    <div class="row ' . $font_bold . '">
                    <img class="img_whatsapp_user" src="' . $url . '" alt="Imagen estudiante" />
                        <div class="col-8 mt-2">
                            ' . (empty($nombre_completo) ? $numero_whatsapp : $nombre_completo) .' <span class="badge ' . $bg_color . '">' . $nombre_escuela . '</span> '. $tipo_mensaje_masivo.'
                            <br>  

                            <div style="height:24px" class="overflow-hidden small ultimo_mensaje_' . $numero_whatsapp . '">' . json_decode('"' . $ultimo_mensaje . '"') . '</div>
                        </div>
                        <div class="time col "> 
                            <div class="col-12 text-center  ' . $text_success . '">
                                ' . $dia . '  ' . $meses[intval($mes)] . ' 
                                <div class="rounded rounded-circle bg-success p-1 mt-2 mensajes_no_vistos text-white ' . $display_num_vistos . '" style=" width: 20px !important; height: 20px !important; margin: 0 auto"> 
                                    ' . $mensajes_no_vistos . ' 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>');
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data,
            "total_sin_mostrar" => $total_sin_mostrar
        );
        $consulta->actualizarMostrados();
        echo json_encode($results);
        break;
    }
