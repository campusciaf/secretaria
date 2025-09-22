<?php

require "../config/Conexion.php";
class ReporteHojaVidaDocentes
{

    public function InformacionDatosFuncionario()
    {
        $sql = "SELECT * FROM `cv_informacion_personal` INNER JOIN `cv_usuario` ON `cv_usuario`.`id_usuario_cv` = `cv_informacion_personal`.`id_usuario_cv`  WHERE `cv_usuario`.`usuario_condicion` = 1";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function obtenerDepartamento($id)
    {
        global $mbd;
        $sql = "SELECT departamento FROM departamentos WHERE id_departamento = :id LIMIT 1";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function obtenerMunicipio($id)
    {
        global $mbd;
        $sql = "SELECT municipio FROM municipios WHERE id_municipio = :id LIMIT 1";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
}
