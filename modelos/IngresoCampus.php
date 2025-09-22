<?php 

require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");
session_start();

class IngresoCampus
{
    public function consultaingreso($roll, $fecha){
        if($roll == "todos" || $roll == ""){
            $roll = '%%';
        }
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT `fecha`, `hora` FROM `ingresos_campus` WHERE `roll` LIKE :roll AND `fecha` = :fecha ");
        $sentencia->bindParam(":roll",$roll);
        $sentencia->bindParam(":fecha",$fecha);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function CantidadTotalIngresos($roll, $fecha, $fecha_final){
        if($roll == "todos"){
            $roll = '%%';
        }
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT COUNT(*) as total FROM `ingresos_campus` WHERE `roll` LIKE :roll AND `fecha` BETWEEN :fecha AND :fecha_final");
        $sentencia->bindParam(":roll",$roll);
        $sentencia->bindParam(":fecha",$fecha);
        $sentencia->bindParam(":fecha_final",$fecha_final);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
}


?>