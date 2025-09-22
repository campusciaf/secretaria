<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Calificaciondocente
{
    public function listarProgra()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE estado = 1 ORDER BY `programa_ac`.`nombre` ASC ");
        $sentencia->execute();
        echo json_encode($sentencia->fetchAll(PDO::FETCH_ASSOC));
    }
    public function listarJornada()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `jornada` WHERE estado = 1 ");
        $sentencia->execute();
        echo json_encode($sentencia->fetchAll(PDO::FETCH_ASSOC));
    }
    public function buscar($programa,$jornada)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `docente_grupos` WHERE id_programa = :programa AND jornada = :jornada AND periodo = :periodo ");
        $sentencia->bindParam(":programa",$programa);
        $sentencia->bindParam(":jornada",$jornada);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function nombre_usuario($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(`usuario_apellido`,' ',`usuario_apellido_2`,' ',`usuario_nombre`,' ',`usuario_nombre_2`) AS nombre FROM `docente` WHERE `id_usuario` = $id ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro['nombre'];
    }
    public function cambiarestado($id,$val)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `docente_grupos` SET estado = :val WHERE id_docente_grupo = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":val",$val);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
        } else {
            $data['status'] = 'error';
        }

        echo json_encode($data);
        
    }
    public function nombre_programa($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE id_programa = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro['nombre'];
    }
    public function materianombre($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `materias_ciafi` WHERE id= :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro['nombre'];
    }
}


?>