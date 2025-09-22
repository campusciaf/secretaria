<?php
    require_once("../modelos/MensajeWhatsapp.php");
    $mensaje_whastapp = new MensajeWhatsapp();

	date_default_timezone_set("America/Bogota");	
	$fecha = date('Y-m-d-H:i:s');
  
    $estado = "2";
    $rspta = $mensaje_whastapp->insertarMensaje($estado,$fecha);

    $challenge = $_REQUEST['hub_challenge'];
    $verify_token = $_REQUEST['hub_verify_token'];

    if ($verify_token === 'adminciaf') {
        echo $challenge;
    }