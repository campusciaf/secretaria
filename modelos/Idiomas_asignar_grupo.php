<?php 

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class IdiomasAsig
{
    public function listar()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_pagos` ");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }
    public function estudiante($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiantes` WHERE `id_estudiante` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function estudiante_datos_pero($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiantes_datos_personales` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function datos_estudiante($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function fo_programa($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE `id_programa` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function grupos()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_grupos` ");
        $sentencia->execute();

        return $sentencia->fetchAll();
    }
    public function docente($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_docente` WHERE `id` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function tipo_grupo($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_tipo_grupo` WHERE `id` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function asignar_grupo($id,$id_credencial)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" INSERT INTO `ingles_estudiante`(`id_grupo`, `id_credencial`, `periodo_activo`) VALUES (:id,:id_credencial,:periodo) ");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":id_credencial",$id_credencial);
        $sentencia->bindParam(":periodo",$periodo);
        if ($sentencia->execute()) {
            $data['msj'] = 'Grupo asignado con exito.';
            $data['status'] = 'ok';
        } else {
            $data['msj'] = 'Error al asignar un grupo';
            $data['status'] = 'error';
        }

        echo json_encode($data);
        

    }
    public function programa_activo($id_credencial)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_estudiante` WHERE `id_credencial` = :id_credencial AND `periodo_activo` = :periodo ");
        $sentencia->bindParam(":id_credencial",$id_credencial);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function grupos_datos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_grupos` WHERE id = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function sacar_grupo($id_credencial)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" DELETE FROM `ingles_estudiante` WHERE `id_credencial` = :id_credencial AND `periodo_activo` = :periodo ");
        $sentencia->bindParam(":id_credencial",$id_credencial);
        $sentencia->bindParam(":periodo",$periodo);
        if ($sentencia->execute()) {
            $data['msj'] = 'Estudiante expulsado del grupo con exito.';
            $data['status'] = 'ok';
        } else {
            $data['msj'] = 'Error al expulsar al estudiante del grupo';
            $data['status'] = 'error';
        }

        echo json_encode($data);
    }

}


?>