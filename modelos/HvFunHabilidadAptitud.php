<?php

require "../config/Conexion.php";

class HvFunHabilidadAptitud
{

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
    public function cv_insertarHabilidad($id_cvadministrativos, $nombre_categoria, $nivel_habilidad)
    {
        $sql = "INSERT INTO `hv_fun_habilidades_aptitudes`(`id_cvadministrativos`, `nombre_categoria`, `nivel_habilidad`) VALUES(:id_cvadministrativos, :nombre_categoria, :nivel_habilidad);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":nombre_categoria", $nombre_categoria);
        $consulta->bindParam(":nivel_habilidad", $nivel_habilidad);
        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }
    public function cv_editarHabilidad($id_cvadministrativos, $id_habilidad, $nombre_categoria, $nivel_habilidad)
    {
        $sql = "UPDATE `hv_fun_habilidades_aptitudes` SET `id_cvadministrativos`= :id_cvadministrativos, `nombre_categoria`= :nombre_categoria, `nivel_habilidad`= :nivel_habilidad WHERE `id_habilidad` =  :id_habilidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":id_habilidad", $id_habilidad);
        $consulta->bindParam(":nombre_categoria", $nombre_categoria);
        $consulta->bindParam(":nivel_habilidad", $nivel_habilidad);
        return ($consulta->execute());
    }
    public function cv_listarHabilidad($id_cvadministrativos)
    {
        $sql = "SELECT * FROM `hv_fun_habilidades_aptitudes` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }
    public function cv_listarHabilidadEspecifica($id_habilidad)
    {
        $sql = "SELECT * FROM `hv_fun_habilidades_aptitudes` WHERE `id_habilidad` = :id_habilidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_habilidad", $id_habilidad);
        $consulta->execute();
        return $consulta;
    }

    public function cv_eliminarHabilidad($id_habilidad)
    {
        $sql = "DELETE FROM `hv_fun_habilidades_aptitudes` WHERE `id_habilidad` = :id_habilidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_habilidad", $id_habilidad);
        $consulta->execute();
        return $consulta;
    }

    public function editarCertificado($id_habilidad, $nombre_img)
    {
        $sql = "UPDATE `hv_fun_habilidades_aptitudes` SET `certificado_educacion` = :certificado_educacion WHERE `id_habilidad` = :id_habilidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_habilidad", $id_habilidad);
        $consulta->bindParam(":certificado_educacion", $nombre_img);
        $consulta->execute();
        return $consulta;
    }

    public function CuentoRegistros($id_cvadministrativos)
    {
        $sql = "SELECT COUNT(*) as total FROM hv_fun_habilidades_aptitudes WHERE id_cvadministrativos = :id_cvadministrativos";
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
