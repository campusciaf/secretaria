<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiConsultaCreditos{
    //periodos en los que esta el sofi actualemnte
    public function periodoActualyAnterior(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_periodo`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista los periodos en los que el sofi tiene creditos
    public function periodosEnSofi(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT DISTINCT `periodo` FROM `sofi_persona`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarFinanciados($periodo){
        global $mbd;
        if ($periodo == "Todos") {
            $periodo = "%%";
        }
        $sentencia = $mbd->prepare("SELECT * FROM `creditos_control` WHERE `periodo` LIKE :periodo ORDER BY `creditos_control`.`periodo` DESC");
        $sentencia->bindParam(':periodo', $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarFinanciamiento($id){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :id");
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
}
?>