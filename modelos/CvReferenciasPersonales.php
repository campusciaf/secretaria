<?php

require "../config/Conexion.php";

class CvReferenciasPersonales{

    //experiencia_laboral

    public function cv_traerIdUsuario($documento){
        $sql = "SELECT `id_usuario_cv` ,`porcentaje_avance` FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    } 
        public function cvinsertarReferencias($id_usuario_cv,$referencias_nombre,$referencias_profesion, $referencias_empresa, $referencias_telefono){
        $sql = "INSERT INTO `cv_referencias_personal`(`id_usuario_cv`, `referencias_nombre`, `referencias_profesion`, `referencias_empresa`, `referencias_telefono`) VALUES(:id_usuario_cv, :referencias_nombre, :referencias_profesion, :referencias_empresa, :referencias_telefono);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":referencias_nombre",$referencias_nombre);
        $consulta->bindParam(":referencias_profesion",$referencias_profesion);
        $consulta->bindParam(":referencias_empresa",$referencias_empresa);
        $consulta->bindParam(":referencias_telefono",$referencias_telefono);
        if($consulta->execute()){
            return($mbd->lastInsertId());  
        }else{
            return FALSE;
        }

    }
    public function cveditarReferencias($id_usuario_cv,$referencias_nombre,$referencias_profesion, $referencias_empresa, $referencias_telefono, $id_referencias){
        $sql = "UPDATE `cv_referencias_personal` SET `id_usuario_cv`= :id_usuario_cv, `referencias_nombre`= :referencias_nombre, `referencias_profesion`= :referencias_profesion, `referencias_empresa`= :referencias_empresa, `referencias_telefono`= :referencias_telefono WHERE `id_referencias` =  :id_referencias";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":id_referencias",$id_referencias);
        $consulta->bindParam(":referencias_nombre",$referencias_nombre);
        $consulta->bindParam(":referencias_profesion",$referencias_profesion);
        $consulta->bindParam(":referencias_empresa",$referencias_empresa);
        $consulta->bindParam(":referencias_telefono",$referencias_telefono);
        return($consulta->execute());
    }
    public function cvlistarReferencias($documento){
        $sql = "SELECT `cv_referencias_personal`.* FROM `cv_referencias_personal` INNER JOIN `cv_usuario` ON `cv_referencias_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv` WHERE `cv_usuario`.`usuario_identificacion` = :documento";
        // $sql = "SELECT * FROM `cv_referencias_personal` WHERE `id_usuario` = :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":documento",$documento);
        $consulta->execute();
        return $consulta;
    } 
    public function cvlistarReferenciasEspecifica($id_referencias){
        $sql = "SELECT * FROM `cv_referencias_personal` WHERE `id_referencias` = :id_referencias";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_referencias",$id_referencias);
        $consulta->execute();
        return $consulta;
    }
    public function cveliminarReferencias($id_referencias){
        $sql = "DELETE FROM `cv_referencias_personal` WHERE `id_referencias` = :id_referencias";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_referencias",$id_referencias);
        $consulta->execute();
        return $consulta;
    }

     public function CuentoRegistros($id_usuario_cv)
    {
        $sql = "SELECT COUNT(*) as total FROM cv_referencias_personal WHERE id_usuario_cv = :id_usuario_cv";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id_usuario_cv', $id_usuario_cv);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    // public function actualizar_porcentaje_personal($porcentaje_avance, $id_usuario_cv)
    // {
    //     $sql = "UPDATE `cv_usuario` SET `porcentaje_avance` = :porcentaje_avance WHERE `id_usuario_cv` = :id_usuario_cv";
    //     // echo $sql;
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":porcentaje_avance", $porcentaje_avance);
    //     $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
    //     $consulta->execute();
    //     return $consulta;
    // }

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