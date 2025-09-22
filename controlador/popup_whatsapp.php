<?php
require_once "../modelos/Whatsapp.php";
session_start();
date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:s');
$whatsapp = new Whatsapp();

switch ($_GET['op']) {
    case 'listar_no_visto':
        $rspta = $whatsapp->listarWhatsapp();
        //Vamos a declarar un array
        $html = "";
        for ($i = 0; $i < count($rspta); $i++) {
            $mensajes = $whatsapp->listarMensajes($rspta[$i]["sender_id"]);
            $telefono = $rspta[$i]["sender_id"];
            $html .= '
                <div class="box box-primary direct-chat direct-chat-primary bg-white">
                    <div class="box-header with-border">
                        <div class="col-12 float-right text-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="direct-chat-messages">';
            for ($x = 0; $x < count($mensajes); $x++) {
                $fechaOriginal = $mensajes[$x]["create_dt"];
                $fechaFormateada = date("j M g:i a", strtotime($fechaOriginal));
                $html .= '
                    <div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-right">'. $mensajes[$x]["profile_name"].'</span>
                            <span class="direct-chat-timestamp float-left">'.$fechaFormateada. '</span>
                        </div>
                        <img class="direct-chat-img" src="../files/null.jpg" alt="imagen de usuario">
                        <div class="direct-chat-text">
                            '. $mensajes[$x]["message_text"].'
                        </div>
                    </div>';
            }
            $html .=
                        '<div>
                    </div>
                    <div class="box-footer">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-flat">Send</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                ';
            $whatsapp->marcarMostrado($rspta[$i]["sender_id"]);
        }
        echo $html;
        break;
}
