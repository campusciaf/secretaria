<?php

require "../config/Conexion.php";

class CvAreasdeConocimientocv{

    //experiencia_laboral
    public function cv_traerIdUsuario($documento){
        $sql = "SELECT `id_usuario_cv`,`porcentaje_avance` FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    } 
    

    public function cvinsertarArea($id_usuario_cv,$nombre_area){
        $sql = "INSERT INTO `cv_areas_de_conocimiento`(`id_usuario_cv`, `nombre_area`) VALUES(:id_usuario_cv, :nombre_area);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":nombre_area",$nombre_area);
        if($consulta->execute()){
            return($mbd->lastInsertId());  
        }else{
            return FALSE;
        }     
    }

    public function cv_listarArea($id_usuario_cv){
        $sql = "SELECT * FROM `cv_areas_de_conocimiento` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }

    public function cveliminarArea($id_area){
        $sql = "DELETE FROM `cv_areas_de_conocimiento` WHERE `id_area` = :id_area";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_area",$id_area);
        $consulta->execute();
        return $consulta;
    }

    public function CuentoRegistros($id_usuario_cv)
    {
        $sql = "SELECT COUNT(*) as total FROM cv_areas_de_conocimiento WHERE id_usuario_cv = :id_usuario_cv";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id_usuario_cv', $id_usuario_cv);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function actualizar_porcentaje_personal($porcentaje_avance, $id_usuario_cv)
    {
        $sql = "UPDATE `cv_usuario` SET `porcentaje_avance` = :porcentaje_avance WHERE `id_usuario_cv` = :id_usuario_cv";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":porcentaje_avance", $porcentaje_avance);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }

}

?>