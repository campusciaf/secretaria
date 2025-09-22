<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiPagoMatriculaActivos{
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
        $sentencia = $mbd->prepare("SELECT DISTINCT `periodo` FROM `sofi_matricula`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los programas
    public function listarProgramas(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `programa_ac`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los programas
    public function traerNombrePrograma($id_programa){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `nombre` FROM `programa_ac` WHERE `id_programa` = :id_programa");
        $sentencia->bindParam(":id_programa", $id_programa);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarActivos($periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM estudiantes_activos ea INNER JOIN credencial_estudiante ce ON ea.id_credencial=ce.id_credencial WHERE  ea.periodo = :periodo  ORDER BY ea.programa ASC");
        $sentencia->bindParam(':periodo', $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarFinanciados($estado, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_persona` WHERE `estado` = :estado AND `periodo` = :periodo AND `tipo` = 'Solicitante' ORDER BY `sofi_persona`.`nombres` ASC");
        $sentencia->bindParam(':estado', $estado);
        $sentencia->bindParam(':periodo', $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista los pagos de la rematricula
    public function buscarPagoRematricula($id_estudiante, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT id_estudiante,x_amount_base,x_respuesta,periodo_pecuniario,realiza_proceso FROM pagos_rematricula WHERE id_estudiante = :id_estudiante AND x_respuesta='Aceptada' AND periodo_pecuniario = :periodo");
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista los creditos aprobados
    public function buscarCredito($numero_documento, $periodo, $id_programa){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT numero_documento,periodo,estado,id_programa FROM sofi_persona WHERE numero_documento = :numero_documento AND estado='Aprobado' AND periodo = :periodo AND id_programa= :id_programa");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":id_programa", $id_programa);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista los pagos a primer curso
    public function buscarPagoWeb($identificacion_estudiante, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT identificacion_estudiante,periodo,x_description,x_respuesta,x_amount_base FROM web_pagos_pse WHERE identificacion_estudiante = :identificacion_estudiante AND periodo = :periodo AND x_description LIKE '%Pago matricula primera vez%' AND x_respuesta='Aceptada'");
        $sentencia->bindParam(":identificacion_estudiante", $identificacion_estudiante);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
}
