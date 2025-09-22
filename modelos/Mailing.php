<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Mailing
{
    public function listar()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `plantillas_mailing` WHERE estado = 1 ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }
    public function visualizar_estructura($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `plantillas_mailing` WHERE id = :id");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        echo json_encode($registro);
    }

    public function listardise()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `plantillas_mailing2` ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function duplicar($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `plantillas_mailing` WHERE id = :id");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $titulo = $registro['titulo'];
        $conte = $registro['contenido'];
        $num = explode(" ", $titulo);
        $miniatura = "r_".$num[1].".png";

        $sentencia2 = $mbd->prepare(" INSERT INTO `plantillas_mailing2`(`titulo`, `contenido`, `tipo`,`miniatura`) VALUES (:titulo,:conte,1,:mini) ");
        $sentencia2->bindParam(":titulo",$titulo);
        $sentencia2->bindParam(":mini",$miniatura);
        $sentencia2->bindParam(":conte",$conte);
        if ($sentencia2->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "error";
        }

        echo json_encode($data);
    }

    public function listarPre($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `plantillas_mailing2` WHERE id = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function editar($id,$conte,$titulo)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `plantillas_mailing2` SET `contenido`= :conte, `titulo` = :titu WHERE `id` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":conte",$conte);
        $sentencia->bindParam(":titu",$titulo);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "error";
        }

        echo json_encode($data);
        
    }

    public function eliminarplantilla($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" DELETE FROM `plantillas_mailing2` WHERE `id` = :id ");
        $sentencia->bindParam(":id",$id);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "error";
        }

        echo json_encode($data);
        
    }

    public function crear()
    {
        global $mbd;
        $id = "12";
        $sentencia = $mbd->prepare(" SELECT * FROM `plantillas_mailing` WHERE id = :id");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $titulo = $registro['titulo'];
        $conte = $registro['contenido'];
        $num = explode(" ", $titulo);
        $miniatura = "r_".$num[1].".png";

        $sentencia2 = $mbd->prepare(" INSERT INTO `plantillas_mailing2`(`titulo`, `contenido`, `tipo`,`miniatura`) VALUES (:titulo,:conte,1,:mini) ");
        $sentencia2->bindParam(":titulo",$titulo);
        $sentencia2->bindParam(":mini",$miniatura);
        $sentencia2->bindParam(":conte",$conte);
        if ($sentencia2->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "error";
        }

        echo json_encode($data);
    }

}


?>