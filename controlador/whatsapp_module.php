<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/WhatsappModule.php";
$consulta = new whatsappModule();
$id_dependencia = $_SESSION["id_dependencia"];
$_SESSION["dependencia"] = isset($_SESSION["dependencia"]) ? $_SESSION["dependencia"] : $consulta->Dependencia($id_dependencia);
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
        $valor_a_buscar = $_POST['search']['value'];
        $chats = $consulta->listarChats($valor_a_buscar);
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
            $mensajes_no_vistos = $chats[$i]["mensajes_no_vistos"];
            $tipo_mensaje_masivo = $chats[$i]["tipo_mensaje_masivo"];
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
                            ' . (empty($nombre_completo) ? $numero_whatsapp : $nombre_completo) . ' <span class="badge ' . $bg_color . '">' . $nombre_escuela . '</span> <span class="badge bg-navy"> ' . $tipo_mensaje_masivo . '</span>
                            <br>  
                            <small class="mt-4 ultimo_mensaje_' . $numero_whatsapp . '">' . json_decode('"' . $ultimo_mensaje . '"') . '</small>
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
    case 'listarConversacion':
        $data = array("exito" => 0);
        $ultima_fecha_estudiante = "2000-01-01";
        $ultima_hora_estudiante = "00:00:00";
        $numero_celular = $_POST["numero_celular"];
        $datos_estudiantes = $consulta->consultaEstudiante($numero_celular);
        $total_sin_mostrar = $consulta->CantidadNoMostradosPorNumero($numero_celular);
        $credencial_nombre = isset($datos_estudiantes["credencial_nombre"]) ? $datos_estudiantes["credencial_nombre"] : "";
        $credencial_nombre_2 = isset($datos_estudiantes["credencial_nombre_2"]) ? $datos_estudiantes["credencial_nombre_2"] : "";
        $credencial_apellido = isset($datos_estudiantes["credencial_apellido"]) ? $datos_estudiantes["credencial_apellido"] : "";
        $nombre_completo =  $credencial_nombre . " " . $credencial_nombre_2 . " " . $credencial_apellido;
        $credencial_identificacion = isset($datos_estudiantes["credencial_identificacion"]) ? $datos_estudiantes["credencial_identificacion"] : "";
        $data["primer_nombre"] = $credencial_nombre;
        $data["nombre_completo"] = $nombre_completo;
        $data["fecha_nacimiento"] = isset($datos_estudiantes["fecha_nacimiento"]) ? $datos_estudiantes["fecha_nacimiento"] : "";
        $data["tipo_documento"] = isset($datos_estudiantes["tipo_documento"]) ? $datos_estudiantes["tipo_documento"] : "";
        $data["direccion"] = isset($datos_estudiantes["direccion"]) ? $datos_estudiantes["direccion"] : "";
        $data["email"] = isset($datos_estudiantes["email"]) ? $datos_estudiantes["email"] : "";
        $data["email_ciaf"] = isset($datos_estudiantes["credencial_login"]) ? $datos_estudiantes["credencial_login"] : "";
        $id_credencial = isset($datos_estudiantes["id_credencial"]) ? $datos_estudiantes["id_credencial"] : "";
        $ruta = "../WhatsappApi/chats/";
        $fecha_anterior = "";
        $url = "../files/estudiantes/" . $credencial_identificacion . ".jpg";
        if (file_exists($url)) {
            $url = "../files/estudiantes/" . $credencial_identificacion . ".jpg";
        } else {
            $url = 'https://ciaf.digital/files/null.jpg';
        }
        //crear el nombre del archivo para almacenar la informacion del propietario
        $data["imagen"] = $url;
        // el archivo en modo de lectura
        $nombre_archivo = $ruta . $numero_celular . '.txt';
        $archivo = fopen($nombre_archivo, "a+");
        // Verifica si el archivo existe
        if (file_exists($nombre_archivo)) {
            //Historial de mensajes 
            $historial_mensajes = '';
            //Datos de respuesta 
            $data["exito"] = 1;
            $data["mostrar_templates"] = 1;
            $data["historial_mensajes"] = $historial_mensajes;
            //Ciclo sobre cada línea del archivo
            while (($linea = fgets($archivo)) !== false) {
                $config = "";
                // Decodificar la línea JSON a un objeto PHP
                $objeto = json_decode($linea);
                $align = isset($objeto->align) ? $objeto->align : "chat-right";
                $background = isset($objeto->background) ? $objeto->background . PHP_EOL : "";
                $fecha = isset($objeto->fecha) ? $objeto->fecha : "";
                $hora = isset($objeto->hora) ? $objeto->hora : "";
                $tipo_mensaje = isset($objeto->tipo_mensaje) ? $objeto->tipo_mensaje : "text";
                $id_usuario = isset($objeto->id_usuario) ? $objeto->id_usuario : "";
                // Convertir la fecha al formato "d m", que sería "día mes" sin el año
                $dia = date("d", strtotime($fecha));
                $mes = date("m", strtotime($fecha));
                $li_fecha = ($fecha == @$fecha_anterior) ? '' : '<li class="text-center"> <span class="badge badge-secondary">' . $dia . ' ' . $meses[intval($mes)] . '</span> </li>';
                switch ($tipo_mensaje) {
                    case 'template':
                        if (isset($objeto->template_imagen)) {
                            $texto = isset($objeto->texto) ? $objeto->texto : "";
                            $imagen = $objeto->template_imagen;
                            // Generar el contenido del mensaje con la etiqueta img y las dimensiones originales
                            $contenido_mensaje = '<img class="pointer rounded-lg" onclick="verImagenGrande(this)" src="' . $imagen . '" width="300px" height="300px"> <br> <p  style="width: 300px;" class="m-0 mt-1">' . $texto . '</p>';
                        } else {
                            $contenido_mensaje = isset($objeto->texto) ? $objeto->texto : "";
                        }
                        break;
                    case 'text':
                        $contenido_mensaje = isset($objeto->texto) ? $objeto->texto : "";
                        break;
                    case 'button':
                        $contenido_mensaje = isset($objeto->texto) ? $objeto->texto : "";
                        break;
                    case 'audio':
                        // Ruta de la imagen original
                        $url = isset($objeto->url) ? $objeto->url : "";
                        $ruta_original = "../WhatsappApi/media/$tipo_mensaje/$url";
                        // Generar el contenido del mensaje con la etiqueta img y las dimensiones originales
                        $contenido_mensaje = '
                        <audio src="' . $ruta_original . '" controls >
                                Tu navegador no soporta la etiqueta <code>audio</code> element.
                        </audio>
                        <br>
                        ';
                        break;
                    case 'sticker':
                        $config = "m-0 p-0";
                        $url = isset($objeto->url) ? $objeto->url : "";
                        // Ruta de la imagen original
                        $ruta_original = "../WhatsappApi/media/$tipo_mensaje/$url";
                        // Generar el contenido del mensaje con la etiqueta img y las dimensiones originales
                        $contenido_mensaje = '<img class="pointer rounded-lg" src="' . $ruta_original . '" width="190px" height="190px"> <br>';
                        break;
                    case 'image':
                        //texto incluido con la imagen
                        $caption = isset($objeto->texto) ? $objeto->texto : "";
                        // Ruta de la imagen original
                        $url = isset($objeto->url) ? $objeto->url : "";
                        $ruta_original = "../WhatsappApi/media/$tipo_mensaje/$url";
                        // Obtener dimensiones originales de la imagen
                        if (file_exists($ruta_original)) {
                            list($ancho_original, $alto_original) = @getimagesize($ruta_original);
                            // Calcular nuevas dimensiones para reducir el tamaño en un 50%
                            $nuevo_ancho = $ancho_original * (1 - 0.8149);
                            $nuevo_alto = $alto_original * (1 - 0.8149);
                        } else {
                            $ruta_original = "../WhatsappApi/media/image/file_not_found.webp";
                            $nuevo_ancho = "150px";
                            $nuevo_alto = "150px";
                        }
                        // Generar el contenido del mensaje con la etiqueta img y las dimensiones originales
                        $contenido_mensaje = '<img class="pointer rounded-lg" onclick="verImagenGrande(this)" src="' . $ruta_original . '" width="' . $nuevo_ancho . '" height="' . $nuevo_alto . '"> <br> <p  style="width:' . $nuevo_ancho . 'px;" class="m-0 mt-1">' . $caption . '</p>';
                        break;
                    case 'document':
                        //texto incluido con la imagen
                        $caption = isset($objeto->texto) ? $objeto->texto : "";
                        // Ruta de la imagen original
                        $url = isset($objeto->url) ? $objeto->url : "";
                        $file_size = isset($objeto->file_size) ? $objeto->file_size : "";
                        $nombre_sin_extension = isset($objeto->nombre_sin_extension) ? $objeto->nombre_sin_extension : "";
                        $ruta_original = "WhatsappApi/media/$tipo_mensaje/$url";
                        $extension = explode(".", $url)[1];
                        $nombre_sin_extension = empty($nombre_sin_extension) ? $url : $nombre_sin_extension;
                        switch ($extension) {
                            case 'txt':
                                $icono = 'fas fa-file-alt';
                                $color = 'color: #4a4a4a;'; // Gris oscuro
                                break;
                            case 'xls':
                            case 'xlsx':
                                $icono = 'fas fa-file-excel';
                                $color = 'color: #1c9b2e;'; // Verde
                                break;
                            case 'doc':
                            case 'docx':
                                $icono = 'fas fa-file-word';
                                $color = 'color: #2a5699;'; // Azul
                                break;
                            case 'ppt':
                            case 'pptx':
                                $icono = 'fas fa-file-powerpoint';
                                $color = 'color: #d04423;'; // Naranja
                                break;
                            case 'pdf':
                                $icono = 'fas fa-file-pdf';
                                $color = 'color: #e31e24;'; // Rojo
                                break;
                            default:
                                $icono = 'fas fa-file';
                                $color = 'color: #6c757d;'; // Gris
                                break;
                        }
                        // Generar el contenido del mensaje con la etiqueta img y las dimensiones originales
                        $contenido_mensaje = '
                            <a href="https://ciaf.digital/' . $ruta_original . '" class="card m-0 file-download">
                                <div class="row no-gutters">
                                    <div class="col-md-2 pt-1 text-center">
                                        <i class="fa-3x ' . $icono . '" style="' . $color . '"></i>   
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body pl-0 pt-2 pb-2 pr-3 ">
                                            <h5 class="card-title col-12 p-0" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">' . $nombre_sin_extension . '</h5>
                                            <p class="card-text"> <small>' . $file_size . '</small> </p>
                                        </div>
                                    </div>
                                </div>
                            </a>';
                        break;
                    case 'video':
                        //texto incluido con la imagen
                        $caption = isset($objeto->texto) ? $objeto->texto : "";
                        // Ruta de la imagen original
                        $url = isset($objeto->url) ? $objeto->url : "";
                        $ruta_original = "../WhatsappApi/media/$tipo_mensaje/$url";
                        // Generar el contenido del mensaje con la etiqueta img y las dimensiones originales
                        $contenido_mensaje = '<video width="320" height="240" controls>
                                                <source src="' . $ruta_original . '" >
                                            </video><br> <p  style="width: 320px;" class="m-0 mt-1">' . $caption . '</p>';
                        break;
                    default:
                        $contenido_mensaje = "No es posible leer este mensaje";
                        break;
                }
                $contenido_mensaje = str_replace("\\n", "\n", $contenido_mensaje);
                $usuario_respuesta = '';
                if (!empty($id_usuario)) {
                    $nombre_completo = $consulta->consultaUsuario($id_usuario)["usuario_nombre_completo"];
                    $nombre_asesor = mb_convert_case(mb_strtolower($nombre_completo, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                    $usuario_respuesta =
                        '<div class="col-12 text-right" style="font-size:13px">
                            ' . $nombre_asesor . '
                        </div>';
                }
                $ultima_fecha_estudiante = ($align == 'chat-left') ? $fecha : $ultima_fecha_estudiante;
                $ultima_hora_estudiante = ($align == 'chat-left') ? $hora : $ultima_hora_estudiante;
                // Acceder a las propiedades del objeto
                if ($align == 'chat-center') {
                    $historial_mensajes .= $li_fecha . '
                        <li class="' . $align . ' mt-2">
                            <div class="badge badge-warning ' . $background . ' ' . $config . '">
                                ' . nl2br($contenido_mensaje) . " <i class='fas fa-arrow-right'></i>  " . $nombre_asesor . '
                                <span class="metadata">
                                    <span class="time text-dark">' . $hora . '</span>
                                </span>
                            </div>
                        </li>';
                } else {
                    $historial_mensajes .= $li_fecha . '
                        <li class="' . $align . ' mt-2">
                            <div class="message sent ' . $background . ' ' . $config . '">
                                ' . $usuario_respuesta . '
                                ' . nl2br($contenido_mensaje) . '
                                <span class="metadata">
                                    <span class="time">' . $hora . '</span>
                                    <span class="tick">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg>
                                    </span>
                                </span>
                            </div>
                        </li>';
                }
                $fecha_anterior = isset($objeto->fecha) ? $objeto->fecha : "";
            }
            //si el mensaje se imprime a la izquierda es que lo envio el usuario
            if ($tipo_mensaje == "text" || $tipo_mensaje == "button" || $tipo_mensaje == "template") {
                $ultimo_mensaje = $contenido_mensaje;
            } else {
                $ultimo_mensaje = $icono_mensaje[$tipo_mensaje];
            }
            if (trim($align) != 'chat-left') {
                $ultimo_mensaje = "Tú: " . $ultimo_mensaje;
            }
            $ultimo_mensaje = substr($ultimo_mensaje, 0, 200);
            $consulta->actualizarUltimoMensaje($numero_celular, $ultimo_mensaje, $id_credencial);
            // Cierra el archivo
            fclose($archivo);
            $fecha1 = new DateTime($ultima_fecha_estudiante . " " . $ultima_hora_estudiante); //fecha inicial
            $fecha2 = new DateTime(date("Y-m-d H:i:s")); //fecha de cierre
            $intervalo = $fecha1->diff($fecha2);
            $data["mostrar_templates"] = $intervalo->format('%d');
            $data["historial_mensajes"] = $historial_mensajes;
            $data["total_sin_mostrar"] = $total_sin_mostrar;
            $data["id_credencial"] = $id_credencial;
            // Enviar mensaje 
            echo json_encode($data);
            $consulta->ActualizarMostradosPorNumero($numero_celular);
        } else {
            // Error al abrir el archivo
            echo json_encode(array("exito" => 0, "info" => "No se pudo abrir el archivo", "imagen" => $data["imagen"]));
        }
        break;
    case 'sendWhatsappMessage':
        // Numero de celular del estudiate
        $numero_celular = isset($_POST["send_numero_celular"]) ? $_POST["send_numero_celular"] : "";
        if (!empty($numero_celular)) {
            // El tipo de mensaje para hacer el proceso de envio  
            $tipo_mensaje = isset($_POST["tipo_mensaje"]) ? $_POST["tipo_mensaje"] : "text";
            // En caso que sea template recibimos la cantidad de variables
            $variables_template = isset($_POST["variables_template"]) ? $_POST["variables_template"] : "text";
            // En caso de template, el nombre es importante para los componentes 
            $nombre_template = isset($_POST["nombre_template"]) ? $_POST["nombre_template"] : "";
            //TELEFONO ESTUDIANTE
            $telefono = $numero_celular;
            //URL A DONDE SE MANDARA EL MENSAJE
            $url = 'https://graph.facebook.com/v17.0/' . $telefonoID . '/messages';
            //URL de almacenar el archivo en nuestro server
            $url_media = '../WhatsappApi/media/';
            switch ($tipo_mensaje) {
                case 'text':
                    // Cuando selecciona texto se envia el mensaje por este input
                    $input_mensaje = isset($_POST["input_mensaje"]) ? $_POST["input_mensaje"] : "";
                    // Sanitizar el texto para evitar inyección de código
                    $input_mensaje = htmlspecialchars($input_mensaje, ENT_QUOTES, 'UTF-8');
                    //CONFIGURACION DEL MENSAJE
                    $mensaje = '{
                        "messaging_product": "whatsapp", 
                        "to": "' . $numero_celular . '", 
                        "type": "text", 
                        "text": {
                            "body": "' . $input_mensaje . '"
                        }, 
                    }';
                    //akamacenar datos en array para genrera el text
                    $datos_mensaje = array(
                        'numero_whatsapp' => $numero_celular,
                        'nombre_perfil' => "CIAF",
                        'texto' => $input_mensaje,
                        'align' => "chat-right",
                        'background' => "color_send_message",
                        'fecha' => date("Y-m-d"),
                        'hora' => date("H:i:s"),
                        'id_usuario' => $_SESSION['id_usuario'],
                        'tipo_mensaje' => $tipo_mensaje,
                    );
                    $datos = $consulta->enviarMensajeMeta($token, $url, $mensaje, $numero_celular, $datos_mensaje);
                    if ($datos["exito"] == 1) {
                    }
                    break;
                case 'template':
                    // Cuando selecciona texto se envia el mensaje por este input
                    $input_mensaje = isset($_POST["input_mensaje"]) ? $_POST["input_mensaje"] : "";
                    // Sanitizar el texto para evitar inyección de código
                    $input_mensaje = htmlspecialchars($input_mensaje, ENT_QUOTES, 'UTF-8');
                    switch ($nombre_template) {
                        case 'saludo_mercadeo':
                            if (!empty($_SESSION['id_usuario'])) {
                                $nombre_completo = $consulta->consultaUsuario($_SESSION['id_usuario'])["usuario_nombre_completo"];
                                $nombre_asesor = mb_convert_case(mb_strtolower($nombre_completo, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                            } else {
                                die();
                            }
                            $mensaje = '{
                                "messaging_product": "whatsapp",
                                "to": "' . $telefono . '",
                                "type": "template",
                                "template": {
                                    "name": "' . $nombre_template . '",
                                    "language": { "code": "es" },
                                    "components": [{
                                        "type": "body",
                                        "parameters": [{
                                            "type": "text",
                                            "text": "' . $nombre_asesor . '"
                                        }]
                                    }]
                                },
                            }';
                            break;
                        case 'presentacion':
                        case 'programa_de_ingles':
                            $horaActual = date("H");
                            // Determinar si es mañana, tarde o noche
                            if ($horaActual >= 6 && $horaActual < 12) {
                                $hora_del_dia = "Buen Día";
                            } elseif ($horaActual >= 12 && $horaActual < 18) {
                                $hora_del_dia = "Buena tarde";
                            } else {
                                $hora_del_dia = "Buena noche";
                            }
                            if (!empty($_SESSION['id_usuario'])) {
                                $nombre_completo = $consulta->consultaUsuario($_SESSION['id_usuario'])["usuario_nombre_completo"];
                                $nombre_asesor = mb_convert_case(mb_strtolower($nombre_completo, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                            } else {
                                die();
                            }
                            $mensaje = '{
                                "messaging_product": "whatsapp",
                                "to": "' . $telefono . '",
                                "type": "template",
                                "template": {
                                    "name": "' . $nombre_template . '",
                                    "language": { "code": "es" },
                                    "components": [{
                                        "type": "body",
                                        "parameters": [{
                                            "type": "text",
                                            "text": "' . $hora_del_dia . '"
                                        },{
                                            "type": "text",
                                            "text": "' . $nombre_asesor . '"
                                        }]
                                    }]
                                },
                            }';
                            break;
                        case 'saludo_director':
                        case 'informar_sobre_opciones_de_grado':
                        case 'renovacion_academica':
                        case 'renovacion_financiera':
                            $horaActual = date("H");
                            // Determinar si es mañana, tarde o noche
                            if ($horaActual >= 6 && $horaActual < 12) {
                                $hora_del_dia = "Buen Día";
                            } elseif ($horaActual >= 12 && $horaActual < 18) {
                                $hora_del_dia = "Buena tarde";
                            } else {
                                $hora_del_dia = "Buena noche";
                            }
                            if (!empty($_SESSION['id_usuario'])) {
                                $datos = $consulta->consultaUsuario($_SESSION['id_usuario']);
                                $nombre_completo = $datos["usuario_nombre_completo"];
                                $usuario_cargo = explode(" ", $datos["usuario_cargo"])[0];
                                $cargo_principal = ($usuario_cargo == "Coordinación") ? "Coordinador" : "Director";
                                $nombre_asesor = mb_convert_case(mb_strtolower($nombre_completo, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                            } else {
                                die();
                            }
                            $mensaje = '{
                                "messaging_product": "whatsapp",
                                "to": "' . $telefono . '",
                                "type": "template",
                                "template": {
                                    "name": "' . $nombre_template . '",
                                    "language": { "code": "es" },
                                    "components": [{
                                        "type": "body",
                                        "parameters": [{
                                            "type": "text",
                                            "text": "' . $hora_del_dia . '"
                                        },{
                                            "type": "text",
                                            "text": "' . $nombre_asesor . '"
                                        },{
                                            "type": "text",
                                            "text": "' . $cargo_principal . '"
                                        }]
                                    }]
                                },
                            }';
                            break;
                        case 'bienvenida_al_programa':
                            $datos_estudiante = $consulta->consultaEstudiante($numero_celular);
                            // Obtiene el id de la credencial del estudiante, si no existe ingresa 0 como valor por defecto
                            $id_credencial = isset($datos_estudiante["id_credencial"]) ? $datos_estudiante["id_credencial"] : 0;
                            // Realiza una busqueda de los programas al que el estudiante esta inscrito y trae el mas reciente
                            $datos_programa = $consulta->listarPrograma($id_credencial);
                            // Nombre del programa
                            $nombre_programa = isset($datos_programa["fo_programa"]) ? $datos_programa["fo_programa"] : "formación";
                            $horaActual = date("H");
                            // Determinar si es mañana, tarde o noche
                            if ($horaActual >= 6 && $horaActual < 12) {
                                $hora_del_dia = "Buen Día";
                            } elseif ($horaActual >= 12 && $horaActual < 18) {
                                $hora_del_dia = "Buena tarde";
                            } else {
                                $hora_del_dia = "Buena noche";
                            }
                            if (!empty($_SESSION['id_usuario'])) {
                                $datos = $consulta->consultaUsuario($_SESSION['id_usuario']);
                                $nombre_completo = $datos["usuario_nombre_completo"];
                                $usuario_cargo = explode(" ", $datos["usuario_cargo"])[0];
                                $cargo_principal = ($usuario_cargo == "Coordinación") ? "Coordinador" : "Director";
                                $nombre_asesor = mb_convert_case(mb_strtolower($nombre_completo, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                            } else {
                                die();
                            }
                            $mensaje = '{
                                "messaging_product": "whatsapp",
                                "to": "' . $telefono . '",
                                "type": "template",
                                "template": {
                                    "name": "' . $nombre_template . '",
                                    "language": { "code": "es" },
                                    "components": [{
                                        "type": "body",
                                        "parameters": [{
                                            "type": "text",
                                            "text": "' . $hora_del_dia . '"
                                        },{
                                            "type": "text",
                                            "text": "' . $nombre_asesor . '"
                                        },{
                                            "type": "text",
                                            "text": "' . $cargo_principal . '"
                                        },{
                                            "type": "text",
                                            "text": "' . $nombre_programa . '"
                                        }]
                                    }]
                                },
                            }';
                            break;
                        case 'pasos_para_pagar_desde_la_plataforma':
                        case 'tec_pro_soft_part1':
                        case 'tec_pro_soft_part2':
                        case 'saludo_mercadeo_2':
                        case 'compartir_informacion_mercadeo':
                            $mensaje = '{
                                "messaging_product": "whatsapp",
                                "to": "' . $telefono . '",
                                "type": "template",
                                "template": {
                                    "name": "' . $nombre_template . '",
                                    "language": {
                                        "code": "es"
                                    }
                                },
                            }';
                            break;
                    }
                    //akamacenar datos en array para genrera el text
                    $datos_mensaje = array(
                        'numero_whatsapp' => $numero_celular,
                        'nombre_perfil' => "CIAF",
                        'texto' => $input_mensaje,
                        'align' => "chat-right",
                        'background' => "color_send_message",
                        'fecha' => date("Y-m-d"),
                        'hora' => date("H:i:s"),
                        'id_usuario' => $_SESSION['id_usuario'],
                        'tipo_mensaje' => $tipo_mensaje,
                    );
                    $datos = $consulta->enviarMensajeMeta($token, $url, $mensaje, $numero_celular, $datos_mensaje);
                    break;
                case 'audio':
                    $url_media .= "audio/";
                    // Si el archivo de audio existe y no hay error deja hacer el proceso
                    if (isset($_FILES['audio']) && $_FILES['audio']['error'] == 0) {
                        // Ruta temporal del archivo en el servidor
                        $tmpFile = $_FILES['audio']['tmp_name'];
                        // Nombre original del archivo
                        $fileName = $_FILES['audio']['name'];
                        // Obtener extensiópn del archivo
                        $extension = explode(".", $fileName)[1];
                        // Puedes también obtener el tipo MIME del archivo si lo necesitas
                        $fileType = $_FILES['audio']['type'];
                        // Enviamos los datos del file al server para que los suba a meta
                        $media_id = $consulta->SubirArchivoMeta($token, $telefonoID, $tmpFile, $fileType, $fileName);
                        //inicializamos la petición
                        if ($media_id) {
                            //CONFIGURACION DEL MENSAJE
                            $mensaje = '{
                                "messaging_product": "whatsapp", 
                                "to": "' . $numero_celular . '", 
                                "type": "audio", 
                                "audio": {
                                    "id": "' . $media_id . '"
                                }, 
                            }';
                            $ubicacion_archivo = $url_media . $numero_celular . "_" . $media_id . "." . $extension;
                            if (move_uploaded_file($_FILES['audio']['tmp_name'], $ubicacion_archivo)) {
                                //akamacenar datos en array para genrera el text
                                $datos_mensaje = array(
                                    'numero_whatsapp' => $numero_celular,
                                    'nombre_perfil' => "CIAF",
                                    'texto' => NULL,
                                    'url' => $numero_celular . "_" . $media_id . "." . $extension,
                                    'align' => "chat-right",
                                    'background' => "color_send_message",
                                    'fecha' => date("Y-m-d"),
                                    'hora' => date("H:i:s"),
                                    'tipo_mensaje' => $tipo_mensaje,
                                    'id_usuario' => $_SESSION['id_usuario'],
                                );
                            } else {
                                $datos["exito"] = 0;
                                $datos["err_info"] = "Error al mover el archivo";
                                die(json_encode($datos));
                            }
                        } else {
                            $datos["exito"] = 0;
                            $datos["err_info"] = "Error al generar ID de audio" . $tmpFile . " " . $fileName . " " . $extension . " " . $fileType;
                            die(json_encode($datos));
                        }
                    } else {
                        $datos["exito"] = 0;
                        $datos["err_info"] = "Archivo de audio no encontrado.";
                        die(json_encode($datos));
                    }
                    $datos = $consulta->enviarMensajeMeta($token, $url, $mensaje, $numero_celular, $datos_mensaje);
                    break;
                case 'image':
                    // Cantidad de archivos subidos
                    $total_archivos = count($_FILES['fileFotoVideo']['name']);
                    // Se va haciendo el proceso individualemente con cada archivo
                    for ($i = 0; $i < $total_archivos; $i++) {
                        // Nombre temporal del archivo
                        $tmpFile = $_FILES['fileFotoVideo']['tmp_name'][$i];
                        // Nombre original del archivo
                        $fileName = $_FILES['fileFotoVideo']['name'][$i];
                        // Obtener extensiópn del archivo
                        $extension = explode(".", $fileName)[1];
                        // Tipo MIME del archivo
                        $fileType = $_FILES['fileFotoVideo']['type'][$i];
                        if (strpos($fileType, 'image') !== false) {
                            $tipo_archivo = "image";
                        } elseif (strpos($fileType, 'video') !== false) {
                            $tipo_archivo = "video";
                        }
                        // Enviamos los datos del file al server para que los suba a meta
                        $media_id = $consulta->SubirArchivoMeta($token, $telefonoID, $tmpFile, $fileType, $fileName);
                        //inicializamos la petición
                        if ($media_id) {
                            //CONFIGURACION DEL MENSAJE
                            $mensaje = '{
                                "messaging_product": "whatsapp", 
                                "to": "' . $numero_celular . '", 
                                "type": "' . $tipo_archivo . '", 
                                "' . $tipo_archivo . '": {
                                    "id": "' . $media_id . '"
                                }, 
                            }';
                            $ubicacion_archivo = $url_media . $tipo_archivo . "/" . $numero_celular . "_" . $media_id . "." . $extension;
                            if (move_uploaded_file($tmpFile, $ubicacion_archivo)) {
                                //akamacenar datos en array para genrera el text
                                $datos_mensaje = array(
                                    'numero_whatsapp' => $numero_celular,
                                    'nombre_perfil' => "CIAF",
                                    'texto' => NULL,
                                    'url' => $numero_celular . "_" . $media_id . "." . $extension,
                                    'align' => "chat-right",
                                    'background' => "color_send_message",
                                    'fecha' => date("Y-m-d"),
                                    'hora' => date("H:i:s"),
                                    'tipo_mensaje' => $tipo_archivo,
                                    'id_usuario' => $_SESSION['id_usuario'],
                                );
                                $datos = $consulta->enviarMensajeMeta($token, $url, $mensaje, $numero_celular, $datos_mensaje);
                            } else {
                                $datos["exito"] = 0;
                                $datos["err_info"] = "Error al mover el archivo" . $tmpFile . " " . $ubicacion_archivo;
                                die(json_encode($datos));
                            }
                        } else {
                            $datos["exito"] = 0;
                            $datos["err_info"] = "Error al generar ID de audio" . $tmpFile . " " . $fileName . " " . $extension . " " . $fileType;
                            die(json_encode($datos));
                        }
                    }
                    break;
                case 'document':
                    // Cantidad de archivos subidos
                    $total_archivos = count($_FILES['fileDocumentos']['name']);
                    // Se va haciendo el proceso individualemente con cada archivo
                    for ($i = 0; $i < $total_archivos; $i++) {
                        // Nombre temporal del archivo
                        $tmpFile = $_FILES['fileDocumentos']['tmp_name'][$i];
                        // Nombre original del archivo
                        $fileName = $_FILES['fileDocumentos']['name'][$i];
                        // Tamaño del archivo
                        $FileSize = $_FILES['fileDocumentos']['size'][$i];
                        // Obtener extensiópn del archivo
                        $extension = explode(".", $fileName)[1];
                        //nmombre sin extension
                        $nombre_sin_extension = explode(".", $fileName)[0];
                        // Tipo MIME del archivo
                        $fileType = $_FILES['fileDocumentos']['type'][$i];
                        // Enviamos los datos del file al server para que los suba a meta
                        $media_id = $consulta->SubirArchivoMeta($token, $telefonoID, $tmpFile, $fileType, $fileName);
                        //inicializamos la petición
                        if ($media_id) {
                            //CONFIGURACION DEL MENSAJE
                            $mensaje = '{
                                "messaging_product": "whatsapp", 
                                "to": "' . $numero_celular . '", 
                                "type": "' . $tipo_mensaje . '", 
                                "' . $tipo_mensaje . '": {
                                    "id": "' . $media_id . '",
                                    "filename": "' . $nombre_sin_extension . '",
                                }, 
                            }';
                            $ubicacion_archivo = $url_media . $tipo_mensaje . "/" . $numero_celular . "_" . $media_id . "." . $extension;
                            if (move_uploaded_file($tmpFile, $ubicacion_archivo)) {
                                //akamacenar datos en array para genrera el text
                                $datos_mensaje = array(
                                    'numero_whatsapp' => $numero_celular,
                                    'nombre_perfil' => "CIAF",
                                    'texto' => NULL,
                                    'url' => $numero_celular . "_" . $media_id . "." . $extension,
                                    'align' => "chat-right",
                                    'background' => "color_send_message",
                                    'fecha' => date("Y-m-d"),
                                    'hora' => date("H:i:s"),
                                    'tipo_mensaje' => $tipo_mensaje,
                                    'id_usuario' => $_SESSION['id_usuario'],
                                    'file_size' => $FileSize . " Kb",
                                    'nombre_sin_extension' => $nombre_sin_extension,
                                );
                                $datos = $consulta->enviarMensajeMeta($token, $url, $mensaje, $numero_celular, $datos_mensaje);
                            } else {
                                $datos["exito"] = 0;
                                $datos["err_info"] = "Error al mover el archivo" . $tmpFile . " " . $ubicacion_archivo;
                                die(json_encode($datos));
                            }
                        } else {
                            $datos["exito"] = 0;
                            $datos["err_info"] = "Error al generar ID de audio" . $tmpFile . " " . $fileName . " " . $extension . " " . $fileType;
                            die(json_encode($datos));
                        }
                    }
                    break;
            }
            $consulta->actualizarMensajesVistos($numero_celular);
            //echo json_encode($datos);
        } else {
            $datos["exito"] = 0;
            $datos["err_info"] = "Numero de celular vacio";
        }
        echo json_encode($datos);
        break;
    case 'listarTemplates':
        $whatsapp_bussines_acount_id = 106844335727929;
        // URL del endpoint para obtener las plantillas
        $url = "https://graph.facebook.com/v16.0/$whatsapp_bussines_acount_id/message_templates";
        // Configuración de cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $token"));
        // Ejecutar la solicitud
        $response = curl_exec($ch);
        // Manejar errores
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            // Decodificar la respuesta JSON
            $data = json_decode($response, true);
            // Recorrer y mostrar los datos en la tabla
            $data_array = array();
            foreach ($data['data'] as $template) {
                $body = "<div id='texto_" . htmlspecialchars($template['name']) . "'>";
                $templates_validas = [
                    "presentacion",
                    "pasos_para_pagar_desde_la_plataforma",
                    "saludo_director",
                    "informar_sobre_opciones_de_grado",
                    "renovacion_financiera",
                    "renovacion_academica",
                    "bienvenida_al_programa",
                    "programa_de_ingles",
                    "saludo_mercadeo",
                    "saludo_mercadeo_2",
                    "compartir_informacion_mercadeo"
                ];
                if (strtolower(htmlspecialchars($template['status'])) == "approved" && in_array(htmlspecialchars($template['name']), $templates_validas)) {
                    // Mostrar el contenido del template
                    foreach ($template['components'] as $component) {
                        if ($component['type'] === 'BODY') {
                            $body .=  htmlspecialchars($component['text']) . "<br>";
                            //creamos el patron para encontrar las variables dentro del texto
                            $patron = '/\{\{\d+\}\}/';
                            // Usamos una expresión regular para buscar las variables que tiene el texto
                            preg_match_all($patron, htmlspecialchars($component['text']), $concidencias);
                            // Contamos las coincidencias
                            $cantidad_variables = count($concidencias[0]);
                        } elseif ($component['type'] === 'HEADER' && isset($component['text'])) {
                            $body .=  htmlspecialchars($component['text']) . "<br>";
                        } elseif ($component['type'] === 'FOOTER' && isset($component['text'])) {
                            $body .=  htmlspecialchars($component['text']) . "<br>";
                        } elseif ($component['type'] === 'BUTTONS') {
                            foreach ($component['buttons'] as $button) {
                                $body .= "- " . htmlspecialchars($button['text']) . " (" . htmlspecialchars($button['type']) . ")<br>";
                            }
                        }
                    }
                    $body .= "</div>";
                    $data_array[] = array(
                        "0" => "<button class='btn btn-success btn-sm' onclick='seleccionarTemplate(`" . htmlspecialchars($template['name']) . "`, $cantidad_variables)'> <i class='fas fa-share-square'></i> Usar</button>",
                        "1" => htmlspecialchars($template['name']),
                        "2" => $body,
                    );
                    $templates[htmlspecialchars($template['name'])] = $body;
                }
            }
            $results = array(
                "sEcho" => 1, //Información para el datatables
                "iTotalRecords" => count($data_array), //enviamos el total registros al datatable
                "iTotalDisplayRecords" => count($data_array), //enviamos el total registros a visualizar
                "aaData" => $data_array,
                "templates" => $templates
            );
            echo json_encode($results);
        }
        // Cerrar cURL
        curl_close($ch);
        break;
    case 'verificarSeguimientoActivo':
        $numero_celular = $_POST["numero_celular"];
        $id_usuario = $_SESSION['id_usuario'];
        //echo "$numero_celular";
        $ya_iniciada = $consulta->verificarSeguimientoActivo($numero_celular);
        if (is_array($ya_iniciada)) {
            if ($ya_iniciada["id_usuario"] == $id_usuario) {
                $data = array("exito" => 1,  "info" => "Esta conversación ha sido activada por ti.");
            } else {
                $data = array("exito" => 0, "info" => "Otro usuario ya está haciendo seguimiento a esta conversación.");
            }
        } else {
            $cantidad_activas = $consulta->CantidadSeguimientosActivos($id_usuario)["total_registros"];
            $cantidad_limite_activas = 20;
            if ($cantidad_activas < 20) {
                $data = array("exito" => 2, "info" => "Puedes activar esta conversación aun no has alcanzado el límite.");
            } else {
                $data = array("exito" => 0, "info" => "Has alcanzado el límite de conversaciones activas. Por favor, finaliza alguna de las actuales para comenzar una nueva. " . $id_usuario);
            }
        }
        echo json_encode($data);
        break;
    case 'ActivarSeguimiento':
        // Recibe el número de celular a través de una solicitud POST
        $numero_celular = $_POST["numero_celular"];
        // Obtiene el id del usuario desde la sesión activa
        $id_usuario = $_SESSION['id_usuario'];
        // Inserta registro que activa el seguimiento, usando el número de celular y el id del usuario
        $iniciada = $consulta->ActivarSeguimiento($numero_celular, $id_usuario);
        // Realiza una consulta para obtener los datos de un estudiante asociado al número de celular
        $datos_estudiante = $consulta->consultaEstudiante($numero_celular);
        // Obtiene el id de la credencial del estudiante, si no existe ingresa 0 como valor por defecto
        $id_credencial = isset($datos_estudiante["id_credencial"]) ? $datos_estudiante["id_credencial"] : 0;
        // Obtenemos el numero de identificacion del estudiante 
        $credencial_identificacion = isset($datos_estudiante["credencial_identificacion"]) ? $datos_estudiante["credencial_identificacion"] : 0;
        // Almacenamos el id del credito mas reciente y aprobado que tenga
        $id_persona = $consulta->consultaCreditoActivo($credencial_identificacion);
        // Actualiza la credencial al número de celular con el id obtenido
        $consulta->ActualizarCredencial($numero_celular, $id_credencial);
        // Verifica si el seguimiento fue iniciado correctamente
        if ($iniciada) {
            // Crea un array de datos para generar un mensaje de texto
            $datos_mensaje = array(
                'numero_whatsapp' => $numero_celular, // Número de WhatsApp
                'nombre_perfil' => "CIAF", // Nombre del perfil 
                'texto' => "Se ha iniciado un seguimiento", // Mensaje de texto a enviar
                'align' => "chat-center", // Alineación del mensaje
                'background' => "bg-warning", // Color de fondo del mensaje
                'fecha' => date("Y-m-d"), // Fecha actual
                'hora' => date("H:i:s"), // Hora actual
                'id_usuario' => $_SESSION['id_usuario'], // ID del usuario de la sesión
                'tipo_mensaje' => "text", // Tipo de mensaje
            );
            // Genera el nombre del archivo de texto basado en el número de celular
            $nombre_archivo = $numero_celular . '.txt';
            // Especifica la ruta para almacenar el archivo de texto
            $contacto = "../WhatsappApi/chats/$nombre_archivo";
            // Almacena los datos del mensaje en un archivo de texto en formato JSON, con bloqueo exclusivo para evitar accesos simultáneos
            file_put_contents($contacto, json_encode($datos_mensaje) . "\n", FILE_APPEND | LOCK_EX);
            // Crea un array de datos que indica éxito, con contenido HTML para mostrar un mensaje
            $data = array(
                "exito" => 1, // Marca el éxito de la operación
                "info" => '
                <li class="chat-center mt-2">
                    <div class="badge badge-warning">
                        Se ha iniciado un seguimiento  
                        <span class="metadata">
                            <span class="time text-dark">' . date("H:i:s") . '</span>
                        </span>
                    </div>
                </li>'
            );
            // Inserta un registro de seguimiento en la base de datos
            $consulta->insertarSeguimiento($numero_celular, "Se ha iniciado un seguimiento", "Whatsapp", $id_usuario, $id_credencial, $id_persona);
        } else {
            // Si no se pudo iniciar el seguimiento, envía un mensaje de error
            $data = array("exito" => 0, "info" => "Error al intentar activar esta consulta.");
        }
        // Devuelve los datos como una respuesta JSON
        echo json_encode($data);
        break;
    case 'FinalizarSeguimiento':
        $numero_celular = $_POST["numero_celular"];
        $id_usuario = $_SESSION['id_usuario'];
        $resultado_seguimiento = $_POST['resultado_seguimiento'];
        $finalizada = $consulta->FinalizarSeguimiento($numero_celular, $id_usuario);
        if ($finalizada) {
            //akamacenar datos en array para genrera el text
            $datos_mensaje = array(
                'numero_whatsapp' => $numero_celular,
                'nombre_perfil' => "CIAF",
                'texto' => "Se ha finalizado el seguimiento",
                'align' => "chat-center",
                'background' => "bg-warning",
                'fecha' => date("Y-m-d"),
                'hora' => date("H:i:s"),
                'id_usuario' => $_SESSION['id_usuario'],
                'tipo_mensaje' => "text",
            );
            //crear el nombre del archivo para almacenar la informacion del propietario
            $nombre_archivo = $numero_celular . '.txt';
            $contacto = "../WhatsappApi/chats/$nombre_archivo";
            //almacenar los datos en un archivo de texto para verficar
            file_put_contents($contacto, json_encode($datos_mensaje) . "\n", FILE_APPEND | LOCK_EX);
            $data = array(
                "exito" => 1,
                "info" => '
                        <li class="chat-center mt-2">
                            <div class="badge badge-warning">
                                Se ha finalizado el seguimiento  
                                <span class="metadata">
                                    <span class="time text-dark">' . date("H:i:s") . '</span>
                                </span>
                            </div>
                        </li>'
            );
            $datos_estudiante = $consulta->consultaEstudiante($numero_celular);
            $id_credencial = isset($datos_estudiante["id_credencial"]) ? $datos_estudiante["id_credencial"] : 0;
            // Obtenemos el numero de identificacion del estudiante 
            $credencial_identificacion = isset($datos_estudiante["credencial_identificacion"]) ? $datos_estudiante["credencial_identificacion"] : 0;
            // Almacenamos el id del credito mas reciente y aprobado que tenga
            $id_persona = $consulta->consultaCreditoActivo($credencial_identificacion);
            $consulta->insertarSeguimiento($numero_celular, "Se ha finalizado el seguimiento: " . $resultado_seguimiento, "Whatsapp", $id_usuario, $id_credencial, $id_persona);
        } else {
            $data = array("exito" => 0,  "info" => "Error al intentar activar esta consulta.");
        }
        echo json_encode($data);
        break;
    case 'ListarDependencias':
        $rspta = $consulta->ListarDependencias($_SESSION["dependencia"]);
        echo json_encode($rspta);
        break;
    case 'redigirChat':
        $id_usuario = $_SESSION['id_usuario'];
        $numero_celular = $_POST["numero_celular"];
        $dependencia = $_POST['dependencias'];
        $redirigir = $consulta->redigirChat($numero_celular, $dependencia);
        $datos_estudiante = $consulta->consultaEstudiante($numero_celular);
        $id_credencial = isset($datos_estudiante["id_credencial"]) ? $datos_estudiante["id_credencial"] : 0;
        // Obtenemos el numero de identificacion del estudiante 
        $credencial_identificacion = isset($datos_estudiante["credencial_identificacion"]) ? $datos_estudiante["credencial_identificacion"] : 0;
        // Almacenamos el id del credito mas reciente y aprobado que tenga
        $id_persona = $consulta->consultaCreditoActivo($credencial_identificacion);
        if ($redirigir) {
            //akamacenar datos en array para genrera el text
            $datos_mensaje = array(
                'numero_whatsapp' => $numero_celular,
                'nombre_perfil' => "CIAF",
                'texto' => $_SESSION["dependencia"] . " Ha Redirigido este chat a " . $dependencia,
                'align' => "chat-center",
                'background' => "bg-info",
                'fecha' => date("Y-m-d"),
                'hora' => date("H:i:s"),
                'id_usuario' => $_SESSION['id_usuario'],
                'tipo_mensaje' => "text",
            );
            //crear el nombre del archivo para almacenar la informacion del propietario
            $nombre_archivo = $numero_celular . '.txt';
            $contacto = "../WhatsappApi/chats/$nombre_archivo";
            //almacenar los datos en un archivo de texto para verficar
            file_put_contents($contacto, json_encode($datos_mensaje) . "\n", FILE_APPEND | LOCK_EX);
            $data = array("exito" => 1, "info" => 'Redirección realizada con exito');
            $consulta->insertarSeguimiento($numero_celular, $_SESSION["dependencia"] . '" Ha Redirigido este chat a " ' . $dependencia, "Whatsapp", $id_usuario, $id_credencial, $id_persona);
        } else {
            $data = array("exito" => 0,  "info" => "Error al intentar redigir este chat.");
        }
        echo json_encode($data);
        break;
    case 'MarcarComoLeido':
        $numero_celular = $_POST["numero_celular"];
        $redirigir = $consulta->MarcarComoLeido($numero_celular);
        if ($redirigir) {
            $data = array("exito" => 1,  "info" => "Se ha marcado como leido.");
        } else {
            $data = array("exito" => 0,  "info" => "Error al intentar marcar como leido.");
        }
        echo json_encode($data);
        break;
}
