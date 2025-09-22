<?php

require "../config/Conexion.php";

class HvFunDocumentosAdicionales{
    //experiencia_laboral
    public function cv_traerIdUsuario($documento){
        $sql = "SELECT `id_cvadministrativos`,`porcentaje_avance` FROM `cvadministrativos` WHERE `cvadministrativos_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    } 
        public function cvinsertarDocumentosA($id_cvadministrativos,$documento_nombre){
        $sql = "INSERT INTO `hv_fun_documentacion_usuario`(`id_cvadministrativos`, `documento_nombre`) VALUES(:id_cvadministrativos, :documento_nombre);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->bindParam(":documento_nombre",$documento_nombre);
        if($consulta->execute()){
            return($mbd->lastInsertId());  
        }else{
            return FALSE;
        }
    }
    public function cvalistarDocumentosAdicionales($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_documentacion_usuario` WHERE `id_cvadministrativos` = :id_cvadministrativos AND `tipo_documento` = 'Adicional'";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }

    public function cvdocumentosAeliminar($id_documento){
        $sql = "DELETE FROM `hv_fun_documentacion_usuario` WHERE `id_documentacion` = :id_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_documento",$id_documento);
        $consulta->execute();
        return $consulta;

    }
    public function editarDocumentoA($id_documento, $nombre_img){
        /*echo($id_documento." - ".$nombre_img);*/
        $sql = "UPDATE `hv_fun_documentacion_usuario` SET `documento_archivo` = :documento_archivo WHERE `id_documentacion` = :id_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_documento",$id_documento);
        $consulta->bindParam(":documento_archivo",$nombre_img);
        $consulta->execute();
        return $consulta;
    }

    public function CuentoRegistros($id_cvadministrativos)
    {
        $sql = "SELECT COUNT(*) as total FROM hv_fun_documentacion_usuario WHERE id_cvadministrativos = :id_cvadministrativos";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id_cvadministrativos', $id_cvadministrativos);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function actualizar_porcentaje_personal($porcentaje_avance, $id_cvadministrativos)
    {
        $sql = "UPDATE `cvadministrativos` SET `porcentaje_avance` = :porcentaje_avance WHERE `id_cvadministrativos` = :id_cvadministrativos";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":porcentaje_avance", $porcentaje_avance);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }

}

?>