<?php 
function enviar_correo($destino, $asunto, $mensaje, $copia = null) {	
    // codificar el asunto en UTF-8
    $asunto = mb_encode_mimeheader($asunto, "UTF-8");

    $cabeceras  = "MIME-Version: 1.0" . "\r\n";
    $cabeceras .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $cabeceras .= "From: Contacto <Contacto@ciaf.edu.co>" . "\r\n";
    
    if ($copia) {
        $cabeceras .= "Cc: " . $copia . "\r\n";
    }

    return mail($destino, $asunto, $mensaje, $cabeceras);
}
?>
