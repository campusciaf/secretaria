<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');

class SofiInteresMora{
    public function listarIntereses(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_interes_mora` ORDER BY id_interes_mora DESC");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    
    public function mostrarInteres($id_interes){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_interes_mora` WHERE id_interes_mora = :id_interes");
        $sentencia->bindParam(':id_interes', $id_interes);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    
    public function insertarInteres($nombre_mes, $fecha_mes, $porcentaje){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_interes_mora`(`nombre_mes`, `fecha_mes`, `porcentaje`) VALUES (:nombre_mes, :fecha_mes, :porcentaje)");
        $sentencia->bindParam(':nombre_mes', $nombre_mes);
        $sentencia->bindParam(':fecha_mes', $fecha_mes);
        $sentencia->bindParam(':porcentaje', $porcentaje);
        return $sentencia->execute();
    }
    
    public function editarInteres($id_interes, $nombre_mes, $fecha_mes, $porcentaje){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_interes_mora` SET `nombre_mes` = :nombre_mes, `fecha_mes` = :fecha_mes, `porcentaje`= :porcentaje WHERE `id_interes_mora`=:id_interes");
        $sentencia->bindParam(':id_interes', $id_interes);
        $sentencia->bindParam(':nombre_mes', $nombre_mes);
        $sentencia->bindParam(':fecha_mes', $fecha_mes);
        $sentencia->bindParam(':porcentaje', $porcentaje);
        return $sentencia->execute();
    }
}
?>