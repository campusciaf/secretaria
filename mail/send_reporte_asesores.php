<?php 
function enviar_correo($destino, $asunto, $mensaje, $copia = null) {	
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $cabeceras .= 'From: Contacto <contacto@ciaf.edu.co>' . "\r\n";
    if ($copia) {
        $cabeceras .= 'Cc: ' . $copia . "\r\n";
    }
    return mail($destino, $asunto, $mensaje, $cabeceras);
}