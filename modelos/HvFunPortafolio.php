<?php

require "../config/Conexion.php";

class HvFunPortafolio{
    //trae el id del usuario 
    public function cv_traerIdUsuario($documento){
        $sql = "SELECT `id_cvadministrativos`,`porcentaje_avance` FROM `cvadministrativos` WHERE `cvadministrativos_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
        public function cvinsertarPortafolio($id_cvadministrativos,$titulo_portafolio,$video_portafolio,$descripcion_portafolio,$imagen){
        $sql = "INSERT INTO `hv_fun_portafolio`(`id_cvadministrativos`, `titulo_portafolio`, `video_portafolio`, `descripcion_portafolio`) VALUES(:id_cvadministrativos, :titulo_portafolio, :video_portafolio,:descripcion_portafolio);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
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
        $sql = "SELECT `hv_fun_portafolio`.* FROM `hv_fun_portafolio` INNER JOIN `cvadministrativos` ON `hv_fun_portafolio`.`id_cvadministrativos` = `cvadministrativos`.`id_cvadministrativos` WHERE `cvadministrativos`.`cvadministrativos_identificacion` = :documento";
        // $sql = "SELECT * FROM `hv_fun_portafolio` WHERE `id_usuario` = :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":documento",$documento);
        $consulta->execute();
        return $consulta;

    } 
    public function eliminarPortafolio($id_portafolio){
        $sql = "DELETE FROM `hv_fun_portafolio` WHERE `id_portafolio` = :id_portafolio";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_portafolio",$id_portafolio);
        $consulta->execute();
        return $consulta;
    }
    public function editarPortafolioArchivo($id_portafolio, $portafolio_archivo){
        $sql = "UPDATE `hv_fun_portafolio` SET `portafolio_archivo` = :portafolio_archivo WHERE `id_portafolio` = :id_portafolio";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_portafolio",$id_portafolio);
        $consulta->bindParam(":portafolio_archivo",$portafolio_archivo);
        $consulta->execute();
        return $consulta;
    }

    public function CuentoRegistros($id_cvadministrativos)
    {
        $sql = "SELECT COUNT(*) as total FROM hv_fun_portafolio WHERE id_cvadministrativos = :id_cvadministrativos";
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