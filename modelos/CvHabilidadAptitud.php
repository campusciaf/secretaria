<?php

require "../config/Conexion.php";

class CvHabilidadAptitud{

    public function cv_traerIdUsuario($documento){
        $sql = "SELECT `id_usuario_cv`,`porcentaje_avance`  FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    } 
    public function cv_insertarHabilidad($id_usuario_cv,$nombre_categoria,$nivel_habilidad){
        $sql = "INSERT INTO `cv_habilidades_aptitudes`(`id_usuario_cv`, `nombre_categoria`, `nivel_habilidad`) VALUES(:id_usuario_cv, :nombre_categoria, :nivel_habilidad);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":nombre_categoria",$nombre_categoria);
        $consulta->bindParam(":nivel_habilidad",$nivel_habilidad);
        if($consulta->execute()){
            return($mbd->lastInsertId());  
        }else{
            return FALSE;
        }
    }
    public function cv_editarHabilidad($id_usuario_cv,$id_habilidad, $nombre_categoria,$nivel_habilidad){
        $sql = "UPDATE `cv_habilidades_aptitudes` SET `id_usuario_cv`= :id_usuario_cv, `nombre_categoria`= :nombre_categoria, `nivel_habilidad`= :nivel_habilidad WHERE `id_habilidad` =  :id_habilidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":id_habilidad",$id_habilidad);
        $consulta->bindParam(":nombre_categoria",$nombre_categoria);
        $consulta->bindParam(":nivel_habilidad",$nivel_habilidad);
        return($consulta->execute());
    }
    public function cv_listarHabilidad($id_usuario_cv){
        $sql = "SELECT * FROM `cv_habilidades_aptitudes` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;

    } 
    public function cv_listarHabilidadEspecifica($id_habilidad){
        $sql = "SELECT * FROM `cv_habilidades_aptitudes` WHERE `id_habilidad` = :id_habilidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_habilidad",$id_habilidad);
        $consulta->execute();
        return $consulta;
    }

    public function cv_eliminarHabilidad($id_habilidad){
        $sql = "DELETE FROM `cv_habilidades_aptitudes` WHERE `id_habilidad` = :id_habilidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_habilidad",$id_habilidad);
        $consulta->execute();
        return $consulta;
    }

    public function editarCertificado($id_habilidad, $nombre_img){
        $sql = "UPDATE `cv_habilidades_aptitudes` SET `certificado_educacion` = :certificado_educacion WHERE `id_habilidad` = :id_habilidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_habilidad",$id_habilidad);
        $consulta->bindParam(":certificado_educacion",$nombre_img);
        $consulta->execute();
        return $consulta;
    }
    public function CuentoRegistros($id_usuario_cv)
    {
        $sql = "SELECT COUNT(*) as total FROM cv_habilidades_aptitudes WHERE id_usuario_cv = :id_usuario_cv";
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