<?php
require "../config/Conexion.php";
class sofiReporteGeneral
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }
    public function listar_creditos($periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sp`.`numero_documento`, `sp`.`nombres`, `sp`.`apellidos`, `sp`.`id_programa`, `sm`.`programa`,`sm`.`valor_total`, `sm`.`valor_financiacion`, `sm`.`semestre`, `sm`.`jornada`, 'Financiado' AS `tipo_matricula`, 0 AS `valor_pagado` FROM `sofi_persona` AS `sp` INNER JOIN `sofi_matricula` AS `sm` ON `sm`.`id_persona` = `sp`.`id_persona` WHERE `sm`.`periodo` = '$periodo';");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listar_rematricula($periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `ce`.`credencial_identificacion` AS numero_documento, CONCAT(`ce`.credencial_nombre, ' ',`ce`.`credencial_nombre_2` ) AS `nombres`, CONCAT(`ce`.`credencial_apellido`, ' ', `ce`.`credencial_apellido_2`) AS `apellidos`, `e`.`id_programa_ac` AS `id_programa`, `pr`.`x_description` AS `programa`, `pr`.`x_amount_base` AS `valor_pagado`, `e`.`semestre_estudiante` AS `semestre`, `e`.`jornada_e` AS `jornada`, 'Rematricula' AS `tipo_matricula`, 0 AS `valor_financiacion` FROM ((`pagos_rematricula` AS `pr` INNER JOIN `estudiantes` AS `e` ON `e`.`id_estudiante` = `pr`.`id_estudiante`) INNER JOIN `credencial_estudiante` AS `ce` ON `ce`.`id_credencial` = `e`.`id_credencial`) WHERE `pr`.`periodo_pecuniario` = '$periodo' AND `pr`.`x_respuesta` = 'Aceptada';");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listar_pagos_web($periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `identificacion_estudiante` AS `numero_documento`, `nombre_completo` as `nombres`, '' AS `apellidos`, `x_description` AS `programa`, `x_amount_base` AS `valor_pagado`, 'Web' AS `tipo_matricula`, 0 AS `valor_financiacion` FROM `web_pagos_pse` WHERE periodo = '$periodo' AND `x_respuesta` = 'Aceptada';");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listar_pagos_sofi_de_contado($periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `documento` AS `numero_documento`, `nombre` AS `nombres`, `apellido` AS `apellidos`, `jornada`, `semestre`, `programa`, `valor_total`, `valor_pagado`, `descuento`, 'Contado' AS `tipo_matricula`, 0 AS `valor_financiacion` FROM `sofi_de_contado` WHERE `periodo` = '$periodo'");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
}
