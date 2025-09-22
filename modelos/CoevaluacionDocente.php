<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Coevaluacion{
    //listar todos periodos
    // public function listarPeriodos(){
    //     global $mbd;
    //     $sentencia = $mbd->prepare("SELECT `periodo` FROM `periodo` where lista_evaluacion_docente='1' ORDER BY `periodo`.`periodo` DESC");
    //     $sentencia->execute();
    //     return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    // }
    public function listarPeriodos(){
        global $mbd;
        $sentencia = $mbd->prepare("
            SELECT `periodo` 
            FROM `periodo` 
            WHERE lista_evaluacion_docente = '1' 
            GROUP BY `periodo` 
            ORDER BY `periodo` DESC
        ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarDocentes(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `docente` WHERE `usuario_condicion` = 1");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarResultadoPeriodo($id_docente, $periodo_actual){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT ((r1 + r2 + r3 + r4 + r5 + r6 + r7 + r8 + r9 + r10) * 100)/30 AS total FROM `coevaluacion_docente` WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":periodo", $periodo_actual);
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insertarCoevaluacionDocente($id_calificador, $id_docente, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $fecha, $hora, $periodo_actual){
        global $mbd;
        $consulta = $mbd->prepare("INSERT INTO `coevaluacion_docente`(`id_coevaluacion`, `id_calificador`, `id_docente`, `r1`, `r2`, `r3`, `r4`, `r5`, `r6`, `r7`, `r8`, `r9`, `r10`, `fecha`, `hora`, `periodo`) VALUES (NULL, :id_calificador, :id_docente, :r1, :r2, :r3, :r4, :r5, :r6, :r7, :r8, :r9, :r10, :fecha, :hora, :periodo)");
        $consulta->bindParam(":id_calificador", $id_calificador);
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->bindParam(":r1", $r1);
        $consulta->bindParam(":r2", $r2);
        $consulta->bindParam(":r3", $r3);
        $consulta->bindParam(":r4", $r4);
        $consulta->bindParam(":r5", $r5);
        $consulta->bindParam(":r6", $r6);
        $consulta->bindParam(":r7", $r7);
        $consulta->bindParam(":r8", $r8);
        $consulta->bindParam(":r9", $r9);
        $consulta->bindParam(":r10", $r10);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":hora", $hora);
        $consulta->bindParam(":periodo", $periodo_actual);
        return $consulta->execute();
    }
    public function Visualizar_Respuestas($id_docente, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `coevaluacion_docente` WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}
