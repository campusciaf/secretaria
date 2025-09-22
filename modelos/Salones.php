<?php
require "../config/Conexion.php";

class Salones
{
    public function listarSalones()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `salones` ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    // public function agregar($codigo,$capacidad,$piso,$tv,$video_beam,$sede)
    // {
    //     global $mbd;
    //     $sentencia = $mbd->prepare("INSERT INTO `salones`(`codigo`, `capacidad`, `sede`, `estado`, `piso`,`tv`,`video_beam`) VALUES (:codigo,:capacidad,:sede,'1',:piso, :tv, :video)");
    //     $sql = "INSERT INTO `salones`(`codigo`, `capacidad`, `sede`, `estado`, `piso`,`tv`,`video_beam`,`sede`) VALUES ($codigo,$capacidad,$sede,$piso, $tv, $video_beam)";
    //     $sentencia->bindParam(":codigo",$codigo);
    //     $sentencia->bindParam(":capacidad",$capacidad);
    //     $sentencia->bindParam(":piso",$piso);
    //     $sentencia->bindParam(":tv",$tv);
    //     $sentencia->bindParam(":video",$video_beam);
    //     $sentencia->bindParam(":sede",$sede);
    //     if ($sentencia->execute()) {
    //         $data['status'] = "ok";
    //     } else {
    //         $data['status'] = "Error al insertar el salon, ponte en contacto con el administrador";
    //         $data['status_dos'] =$sql;
    //     }
    //     echo json_encode($data);
    // }
    public function agregar($codigo, $capacidad, $piso, $tv, $video_beam, $sede, $estado_formulario)
    {
        global $mbd;
        $sql = "INSERT INTO `salones`(`codigo`, `capacidad`, `sede`, `estado`, `piso`, `tv`, `video_beam`, `estado_formulario` ) VALUES('$codigo','$capacidad','$sede', '1', '$piso', '$tv', '$video_beam', '$estado_formulario')";
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }


    public function eliminar($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("DELETE FROM `salones` WHERE `codigo` = :id ");
        $sentencia->bindParam(":id", $id);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "Error al eliminar el salón, ponte en contacto con el administrador.";
        }
        echo json_encode($data);
    }

    public function estado($id, $est)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `salones` SET `estado` = :est WHERE `codigo` = :id ");
        $sentencia->bindParam(":est", $est);
        $sentencia->bindParam(":id", $id);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "err";
        }

        echo json_encode($data);
    }

    public function video($id, $est)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `salones` SET `video_beam` = :est WHERE `codigo` = :id ");
        $sentencia->bindParam(":est", $est);
        $sentencia->bindParam(":id", $id);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "err";
        }

        echo json_encode($data);
    }

    public function televi($id, $est)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `salones` SET `tv` = :est WHERE `codigo` = :id ");
        $sentencia->bindParam(":est", $est);
        $sentencia->bindParam(":id", $id);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "err";
        }

        echo json_encode($data);
    }

    public function formulario_activar($id, $est)
    {
        global $mbd;
        $sql = "UPDATE `salones` 
            SET `estado_formulario` = :est 
            WHERE `codigo` = :id";
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":est", $est);
        $sentencia->bindParam(":id", $id);

        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "err";
        }

        echo json_encode($data);
    }



    //Implementar un método para mostrar los datos del docente
    public function mostrar_salones($codigo)
    {

        $sql = "SELECT * FROM `salones` WHERE `codigo` = :codigo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":codigo", $codigo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listar_salones()
    {
        $sql = "SELECT `codigo`,`capacidad`,`piso` FROM salones";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    public function editarprogramas($codigo, $capacidad, $piso, $id_oculto_salon, $sede, $estado_formulario, $tv, $video_beam)
    {
        global $mbd;
        $sql = "UPDATE salones SET codigo = :codigo, capacidad = :capacidad, piso = :piso, sede = :sede, estado_formulario = :estado_formulario, tv = :tv, video_beam = :video_beam WHERE codigo = :id_oculto";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":codigo", $codigo);
        $consulta->bindParam(":capacidad", $capacidad);
        $consulta->bindParam(":piso", $piso);
        $consulta->bindParam(":sede", $sede);
        $consulta->bindParam(":estado_formulario", $estado_formulario);
        $consulta->bindParam(":tv", $tv);
        $consulta->bindParam(":video_beam", $video_beam);
        $consulta->bindParam(":id_oculto", $id_oculto_salon);
        $consulta->execute();
        return $consulta;
    }

}
