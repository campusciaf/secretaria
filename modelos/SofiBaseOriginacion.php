<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');

class SofiBaseOriginacion{
    public function listarBaseOriginacion(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sp`.`nombres`, `sp`.`apellidos`, `sp`.`tipo_documento`, `sp`.`numero_documento`, `sm`.`id` AS `consecutivo`, `sp`.`id_persona`, `sp`.`genero`, `sp`.`fecha_nacimiento`, timestampdiff(year, `sp`.`fecha_nacimiento`, curdate()) AS `edad`, `sp`.`estado_civil`, `sp`.`numero_hijos`, `sp`.`nivel_educativo`, `sp`.`ocupacion`, `sp`.`direccion`, `sp`.`ciudad`, `sp`.`nacionalidad`, `sp`.`persona_a_cargo`, `sp`.`estrato`, `sm`.`fecha_inicial`, `sm`.`valor_financiacion`, `sm`.`cantidad_tiempo`, `sm`.`periodo`, `sm`.`programa`, `sm`.`semestre`, `si`.`tiempo_servicio`, `si`.`salario`, `si`.`tipo_vivienda`, `si`.`sector_laboral`, `sm`.`create_dt`, `sm`.`ultima_fecha_cuota` FROM `sofi_persona` `sp` LEFT JOIN `sofi_ingresos` `si` ON `sp`.`id_persona` = `si`.`idpersona` INNER JOIN  `sofi_matricula` `sm` ON  `sp`.`id_persona` = `sm`.`id_persona`;");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function calcularDeuda($consecutivo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT SUM(`valor_cuota`) AS `total`, SUM(`valor_pagado`) AS `pagado` FROM `sofi_financiamiento` WHERE id_matricula = :consecutivo;");
        $sentencia->bindParam(":consecutivo", $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listarReferenciaFamiliar($id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_referencias` WHERE `idpersona` = :id_persona AND `tipo_referencia` = 'Familiar' ORDER BY `sofi_referencias`.`idrefencia` ASC LIMIT 1;");
        $sentencia->bindParam(":id_persona", $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
}
?>