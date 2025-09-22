<?php

require "../config/Conexion.php";

class HvFunReferenciasLaborales
{

    //experiencia_laboral

    public function cv_traerIdUsuario($documento)
    {
        $sql = "SELECT `id_cvadministrativos`,`porcentaje_avance` FROM `cvadministrativos` WHERE `cvadministrativos_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function cvinsertarReferencias($id_cvadministrativos, $referencias_nombre, $referencias_profesion, $referencias_empresa, $referencias_telefono)
    {
        $sql = "INSERT INTO `hv_fun_referencias_laborales`(`id_cvadministrativos`, `referencias_nombre`, `referencias_profesion`, `referencias_empresa`, `referencias_telefono`) VALUES(:id_cvadministrativos, :referencias_nombre, :referencias_profesion, :referencias_empresa, :referencias_telefono);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":referencias_nombre", $referencias_nombre);
        $consulta->bindParam(":referencias_profesion", $referencias_profesion);
        $consulta->bindParam(":referencias_empresa", $referencias_empresa);
        $consulta->bindParam(":referencias_telefono", $referencias_telefono);
        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }
    public function cveditarReferencias($id_cvadministrativos, $referencias_nombre, $referencias_profesion, $referencias_empresa, $referencias_telefono, $id_referencias)
    {
        $sql = "UPDATE `hv_fun_referencias_laborales` SET `id_cvadministrativos`= :id_cvadministrativos, `referencias_nombre`= :referencias_nombre, `referencias_profesion`= :referencias_profesion, `referencias_empresa`= :referencias_empresa, `referencias_telefono`= :referencias_telefono WHERE `id_referencias` =  :id_referencias";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":id_referencias", $id_referencias);
        $consulta->bindParam(":referencias_nombre", $referencias_nombre);
        $consulta->bindParam(":referencias_profesion", $referencias_profesion);
        $consulta->bindParam(":referencias_empresa", $referencias_empresa);
        $consulta->bindParam(":referencias_telefono", $referencias_telefono);
        return ($consulta->execute());
    }
    public function cv_listarReferencias($documento)
    {
        $sql = "SELECT `hv_fun_referencias_laborales`.* FROM `hv_fun_referencias_laborales` INNER JOIN `cvadministrativos` ON `hv_fun_referencias_laborales`.`id_cvadministrativos` = `cvadministrativos`.`id_cvadministrativos` WHERE `cvadministrativos`.`cvadministrativos_identificacion` = :documento";
        // $sql = "SELECT * FROM `hv_fun_referencias_laborales` WHERE `id_usuario` = :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":documento", $documento);
        $consulta->execute();
        return $consulta;
    }
    public function cvlistarReferenciasEspecifica($id_referencias)
    {
        $sql = "SELECT * FROM `hv_fun_referencias_laborales` WHERE `id_referencias` = :id_referencias";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_referencias", $id_referencias);
        $consulta->execute();
        return $consulta;
    }
    public function cveliminarReferencias($id_referencias)
    {
        $sql = "DELETE FROM `hv_fun_referencias_laborales` WHERE `id_referencias` = :id_referencias";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_referencias", $id_referencias);
        $consulta->execute();
        return $consulta;
    }
    public function cveditarCertificado($id_referencias, $nombre_img)
    {
        $sql = "UPDATE `hv_fun_referencias_laborales` SET `certificado_educacion` = :certificado_educacion WHERE `id_referencias` = :id_referencias";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_referencias", $id_referencias);
        $consulta->bindParam(":certificado_educacion", $nombre_img);
        $consulta->execute();
        return $consulta;
    }
    public function CuentoRegistros($id_cvadministrativos)
    {
        $sql = "SELECT COUNT(*) as total FROM hv_fun_referencias_laborales WHERE id_cvadministrativos = :id_cvadministrativos";
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
