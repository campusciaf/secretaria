<?php 

require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");
session_start();

class Encuestasalud
{
    public function buscar($cc)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `datos_visitantes` WHERE `identificacion` = :cc ");
        $sentencia->bindParam(":cc", $cc);
        $sentencia->execute();
        $resgistro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resgistro;
    }

    

    public function consultaEncuesta($id)
    {
        global $mbd;
        $fecha = date("Y-m-d");
        $sentencia = $mbd->prepare(" SELECT * FROM `respuesta_encuesta_salud_visitantes` WHERE `id_visitante` = :id AND `fecha` = :fecha AND `estado` = '0' ");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":fecha",$fecha);
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

    public function insertar_visitante($identificacion,$nombre,$nombre_2,$apellido,$apellido_2,$genero,$fecha_nacimiento,$tipo_sangre,$celular)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" INSERT INTO `datos_visitantes`(`nombre`, `nombre_2`, `apellido`, `apellido_2`, `fecha_nacimiento`, `tipo_sangre`, `genero`, `identificacion`, `celular`) VALUES ('$nombre','$nombre_2','$apellido','$apellido_2','$fecha_nacimiento','$tipo_sangre','$genero','$identificacion','$celular') ");
        $sentencia->execute();
        $id = $mbd->lastInsertId();

        return $id;
    }

    public function registro($array,$id,$temperatura)
    {
        $sql1 = "";
        $sql2 = "";
        global $mbd;
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $id_usuario = $_SESSION['id_usuario'];

        for ($i=0; $i < count($array); $i++) {
            if (count($array) == ($i+1)) {
                $sql1 .= "`respuesta".($i+1)."`";
                $sql2 .= "'".$array[$i]."'";
            } else {
                $sql1 .= "`respuesta".($i+1)."`,";
                $sql2 .= "'".$array[$i]."',";
            }          
            
        }

        
        $final = "INSERT INTO `respuesta_encuesta_salud_visitantes`(`id_visitante`,`temperatura`,".$sql1.",`fecha`,`hora_ingreso`,`hora_salida`,`id_usuario_entrada`) VALUES( $id, '$temperatura', ".$sql2.",'$fecha','$hora','00:00:00','$id_usuario')";


        
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
        $hora = date("H:i:s");
        $id_usuario = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" UPDATE `respuesta_encuesta_salud_visitantes` SET `hora_salida`= :hora ,`estado`= '1', `id_usuario_salida` = :id_salida WHERE `id` = :id ");
        $sentencia->bindParam(":hora",$hora);
        $sentencia->bindParam(":id_salida",$id_usuario);
        $sentencia->bindParam(":id",$id);
        if ($sentencia->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function actualizardato($id,$identificacion,$nombre,$nombre_2,$apellido,$apellido_2,$genero,$fecha_nacimiento,$tipo_sangre,$celular)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `datos_visitantes` SET `nombre`= '$nombre',`nombre_2`= '$nombre_2',`apellido`='$apellido',`apellido_2`='$apellido_2',`fecha_nacimiento`= '$fecha_nacimiento',`tipo_sangre`= '$tipo_sangre',`genero`= '$genero',`identificacion`='$identificacion',`celular`= '$celular',`estado`= 1 WHERE `id` = '$id' ");
        
        if ($sentencia->execute()) {
           $data['status'] = 'si';
        } else {
           $data['status'] = 'no';
        }
        
        /* echo json_encode("UPDATE `datos_visitantes` SET `nombre`= '$nombre',`nombre_2`= '$nombre_2',`apellido`='$apellido',`apellido_2`='$apellido_2',`fecha_nacimiento`= '$fecha_nacimiento',`tipo_sangre`= '$tipo_sangre',`genero`= '$genero',`identificacion`='$identificacion',`celular`= '$celular',`estado`= 1 WHERE `id` = '$id'"); */
        
    }


}


?>