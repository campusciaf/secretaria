<?php

require "../config/Conexion.php";

class HvFunAreasdeConocimiento{

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

    public function cvinsertarArea($id_cvadministrativos,$nombre_area){
        $sql = "INSERT INTO `hv_fun_areas_de_conocimiento`(`id_cvadministrativos`, `nombre_area`) VALUES(:id_cvadministrativos, :nombre_area);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->bindParam(":nombre_area",$nombre_area);
        if($consulta->execute()){
            return($mbd->lastInsertId());  
        }else{
            return FALSE;
        }     
    }

    public function cv_listarArea($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_areas_de_conocimiento` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }

    public function cveliminarArea($id_area){
        $sql = "DELETE FROM `hv_fun_areas_de_conocimiento` WHERE `id_area` = :id_area";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_area",$id_area);
        $consulta->execute();
        return $consulta;
    }

    public function CuentoRegistros($id_cvadministrativos)
    {
        $sql = "SELECT COUNT(*) as total FROM hv_fun_areas_de_conocimiento WHERE id_cvadministrativos = :id_cvadministrativos";
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