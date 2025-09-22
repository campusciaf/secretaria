<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Idiotranfe
{
    public function listar()
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_pagos` WHERE `periodo_activo` = :periodo ");
        $sentencia->bindParam(":periodo",$periodo);
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

    public function programa($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT nombre,id_programa,cant_asignaturas FROM `programa_ac` WHERE id_programa = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function consulta($cc)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` WHERE `credencial_identificacion` = :cc ");
        $sentencia->bindParam(":cc",$cc);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function consulta_programa()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT id_programa,nombre,cant_asignaturas,escuela FROM `programa_ac` WHERE `escuela` LIKE 'Idiomas' ORDER BY `programa_ac`.`nombre` ASC ");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function consulta_pagos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_pagos` WHERE `id` = :id  ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

}


?>