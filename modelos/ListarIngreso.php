<?php 

require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");
session_start();

class ListarIngreso
{
    
    public function buscarVisitante()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `respuesta_encuesta_salud_visitantes` ORDER BY `respuesta_encuesta_salud_visitantes`.`fecha` DESC ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function consultaVisitante($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `datos_visitantes` WHERE `id` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function consultaEstudiante($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function consultaDocente($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function consultaAdministra($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function buscarCiaf($val)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `respuesta_encuesta_salud` WHERE `tipo` = :val ORDER BY `respuesta_encuesta_salud`.`fecha` DESC ");
        $sentencia->bindParam(":val",$val);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function convertir_fecha($date) 
    {
        $dia    = explode("-", $date, 3);
        $year   = $dia[0];
        $month  = (string)(int)$dia[1];
        $day    = (string)(int)$dia[2];

        $dias       = array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
        $tomadia    = $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
    }

}


?>