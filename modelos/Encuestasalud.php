<?php 

require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");
session_start();

class Encuestasalud
{
    public function buscar($cc)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial WHERE `credencial_identificacion` = :cc ");
        $sentencia->bindParam(":cc", $cc);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function buscarDocente($cc_final)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE `usuario_identificacion` = :cc ");
        $sentencia->bindParam(":cc",$cc_final);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function buscarAdministra($cc_final)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `usuario_identificacion` = :cc ");
        $sentencia->bindParam(":cc",$cc_final);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function datosestudiante($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiantes` WHERE `id_estudiante` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function consultaEncuesta($id,$tipo)
    {
        global $mbd;
        $fecha = date("Y-m-d");
        $tipo_f = explode("buscar", $tipo);
        $sentencia = $mbd->prepare(" SELECT * FROM `respuesta_encuesta_salud` WHERE `id_usuario` = :id AND `fecha` = :fecha AND `estado` = '0' AND `tipo` = :tipo");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":fecha",$fecha);
        $sentencia->bindParam(":tipo",$tipo_f[1]);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function preguntas()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `encuesta_salud` ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll();
        return $registro;
    }

    public function registro($array,$id_credencial,$tipo,$temperatura)
    {
        $sql1 = "";
        $sql2 = "";

        $id_usuario = $_SESSION['id_usuario'];

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        for ($i=0; $i < count($array); $i++) {
            if (count($array) == ($i+1)) {
                $sql1 .= "`respuesta".($i+1)."`";
                $sql2 .= "'".$array[$i]."'";
            } else {
                $sql1 .= "`respuesta".($i+1)."`,";
                $sql2 .= "'".$array[$i]."',";
            }          
            
        }

        $final = "INSERT INTO `respuesta_encuesta_salud`(`id_usuario`,`tipo`,`temperatura`,".$sql1.",`fecha`,`hora_ingreso`,`hora_salida`,`id_usuario_entrada`) VALUES( $id_credencial, $tipo, '$temperatura', ".$sql2.",'$fecha','$hora','00:00:00','$id_usuario')";


        global $mbd;
        $sentencia = $mbd->prepare($final);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "error";
        }

        echo json_encode($data);
        
    }

    public function registrarsalida($id)
    {
        global $mbd;
        $id_usuario = $_SESSION['id_usuario'];
        $hora = date("H:i:s");
        $sentencia = $mbd->prepare(" UPDATE `respuesta_encuesta_salud` SET `hora_salida`= :hora ,`estado`= '1', `id_usuario_salida` = :id_salida WHERE `id` = :id ");
        $sentencia->bindParam(":hora",$hora);
        $sentencia->bindParam(":id_salida",$id_usuario);
        $sentencia->bindParam(":id",$id);
        if ($sentencia->execute()) {
            return true;
        } else {
            return false;
        }

    }


}


?>