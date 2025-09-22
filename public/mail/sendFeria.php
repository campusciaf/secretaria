<?php 

function enviar_correo($destino, $asunto, $mensaje){	
    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Cabeceras adicionales
    $cabeceras .= 'From: Contacto <Contacto@ciaf.edu.co>' . "\r\n";
    // Enviarlo
    return mail($destino, $asunto, $mensaje, $cabeceras);
}
?>