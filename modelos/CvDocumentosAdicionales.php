<?php

require "../config/Conexion.php";

class CvDocumentosAdicionales{
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
        public function cvinsertarDocumentosA($id_usuario_cv,$documento_nombre){
        $sql = "INSERT INTO `cv_documentacion_usuario`(`id_usuario_cv`, `documento_nombre`) VALUES(:id_usuario_cv, :documento_nombre);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":documento_nombre",$documento_nombre);
        if($consulta->execute()){
            return($mbd->lastInsertId());  
        }else{
            return FALSE;
        }
    }
    public function cvalistarDocumentosAdicionales($id_usuario_cv){
        $sql = "SELECT * FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv AND `tipo_documento` = 'Adicional'";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }

    public function cvdocumentosAeliminar($id_documento){
        $sql = "DELETE FROM `cv_documentacion_usuario` WHERE `id_documentacion` = :id_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_documento",$id_documento);
        $consulta->execute();
        return $consulta;

    }
    public function editarDocumentoA($id_documento, $nombre_img){
        /*echo($id_documento." - ".$nombre_img);*/
        $sql = "UPDATE `cv_documentacion_usuario` SET `documento_archivo` = :documento_archivo WHERE `id_documentacion` = :id_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_documento",$id_documento);
        $consulta->bindParam(":documento_archivo",$nombre_img);
        $consulta->execute();
        return $consulta;
    }

     public function CuentoRegistros($id_usuario_cv)
    {
        $sql = "SELECT COUNT(*) as total FROM cv_documentacion_usuario WHERE id_usuario_cv = :id_usuario_cv";
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