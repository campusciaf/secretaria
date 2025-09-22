<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();

class PerDocente
{
    
    public function listarTema()
    {
        global $mbd;
        $id = intval($_SESSION["id_usuario"]);
        $sentencia = $mbd->prepare(" SELECT id_usuario,modo_ui FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function cambioTema($valor)
    {
        global $mbd;
        $id = intval($_SESSION["id_usuario"]);
        $sentencia = $mbd->prepare("UPDATE `docente` SET `modo_ui`=:valor WHERE `id_usuario` = :id ");

        $sentencia->bindParam(":id", $id);
        $sentencia->bindParam(":valor", $valor);
        $sentencia->execute();
        return $sentencia;
        

    }




}


?>