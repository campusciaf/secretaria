<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();

class PerEstudiante
{
    
    public function listarTema()
    {
        global $mbd;
        $id = intval($_SESSION["id_usuario"]);
        $sentencia = $mbd->prepare(" SELECT id_credencial,modo_ui FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function cambioTema($valor)
    {
        global $mbd;
        $id = intval($_SESSION["id_usuario"]);
        $sentencia = $mbd->prepare("UPDATE `credencial_estudiante` SET `modo_ui`=:valor WHERE `id_credencial` = :id ");

        $sentencia->bindParam(":id", $id);
        $sentencia->bindParam(":valor", $valor);
        $sentencia->execute();
        return $sentencia;
        

    }




}


?>