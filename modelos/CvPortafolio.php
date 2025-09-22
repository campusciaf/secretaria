<?php

require "../config/Conexion.php";

class CvPortafolio{

    //experiencia_laboral

    //trae el id del usuario 
    
    public function cv_traerIdUsuario($documento){
        $sql = "SELECT `id_usuario_cv`,`porcentaje_avance` FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
        public function cvinsertarPortafolio($id_usuario_cv,$titulo_portafolio,$video_portafolio,$descripcion_portafolio,$imagen){
        $sql = "INSERT INTO `cv_portafolio`(`id_usuario_cv`, `titulo_portafolio`, `video_portafolio`, `descripcion_portafolio`) VALUES(:id_usuario_cv, :titulo_portafolio, :video_portafolio,:descripcion_portafolio);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":titulo_portafolio",$titulo_portafolio);
        $consulta->bindParam(":video_portafolio",$video_portafolio);
        $consulta->bindParam(":descripcion_portafolio",$descripcion_portafolio);
        if($consulta->execute()){
            return($mbd->lastInsertId());  
        }else{
            return FALSE;
        }

    }
    public function listarPortafolio($documento){
        $sql = "SELECT `cv_portafolio`.* FROM `cv_portafolio` INNER JOIN `cv_usuario` ON `cv_portafolio`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv` WHERE `cv_usuario`.`usuario_identificacion` = :documento";
        // $sql = "SELECT * FROM `cv_portafolio` WHERE `id_usuario` = :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":documento",$documento);
        $consulta->execute();
        return $consulta;

    } 
    public function eliminarPortafolio($id_portafolio){
        $sql = "DELETE FROM `cv_portafolio` WHERE `id_portafolio` = :id_portafolio";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_portafolio",$id_portafolio);
        $consulta->execute();
        return $consulta;
    }
    public function editarPortafolioArchivo($id_portafolio, $portafolio_archivo){
        $sql = "UPDATE `cv_portafolio` SET `portafolio_archivo` = :portafolio_archivo WHERE `id_portafolio` = :id_portafolio";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_portafolio",$id_portafolio);
        $consulta->bindParam(":portafolio_archivo",$portafolio_archivo);
        $consulta->execute();
        return $consulta;
    }

      public function CuentoRegistros($id_usuario_cv)
    {
        $sql = "SELECT COUNT(*) as total FROM cv_portafolio WHERE id_usuario_cv = :id_usuario_cv";
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