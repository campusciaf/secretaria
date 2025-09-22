<?php
require "../config/Conexion.php";
class MensajeWhatsapp{
    //Implementamos un método para insertar seguimiento
    public function insertarMensaje($estado, $fecha)
    {
        $sql="INSERT INTO mensaje_whatsapp (estado, fecha)
        VALUES ('$estado', '$fecha')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }
}



?>