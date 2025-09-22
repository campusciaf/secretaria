<?php

require "../config/Conexion.php";
class ReporteHojaVida
{

    public function InformacionDatosFuncionario()
    {
        $sql = "SELECT * FROM `hv_fun_informacion_personal` INNER JOIN `cvadministrativos` ON `cvadministrativos`.`id_cvadministrativos` = `hv_fun_informacion_personal`.`id_cvadministrativos`  WHERE `cvadministrativos`.`cvadministrativos_estado` = 1";
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
