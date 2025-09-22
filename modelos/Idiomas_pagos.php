<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Idiotranfe
{
    public function listar($fecha)
    {
        global $mbd;
        $fecha2 = $fecha.' %%:%%:%%';
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_pagos_epayco` WHERE `x_fecha_transaccion` LIKE :fecha ");
        $sentencia->bindParam(":fecha",$fecha2);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function datos_estu($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
}


?>