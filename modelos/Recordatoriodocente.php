<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Consulta
{
    
    public function listar($jornada)
    {
        $jor = ($jornada == "todos") ? " jornada !=  '' " : "jornada = '$jornada'" ;

        global $mbd;
        $sentencia = $mbd->prepare(" SELECT DISTINCT id_docente FROM `docente_grupos` WHERE $jor ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function correodocete($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT usuario_email_ciaf FROM `docente` WHERE id_usuario = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

}


?>