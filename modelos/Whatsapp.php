<?php
require "../config/Conexion.php";
class Whatsapp{
    public function listarWhatsapp(){
        $sql = "SELECT DISTINCT (`sender_id`) FROM `whatsapp_registros` WHERE `state` = 0 AND `mostrado` = 0";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function listarMensajes($sender_id){
        $sql = "SELECT * FROM `whatsapp_registros` WHERE `sender_id` = :sender_id";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":sender_id", $sender_id);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function marcarMostrado($sender_id){
        $sql = "UPDATE `whatsapp_registros` SET `mostrado` = 1 WHERE `sender_id` = :sender_id";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":sender_id", $sender_id);
        $consulta->execute();
    }
}
?>