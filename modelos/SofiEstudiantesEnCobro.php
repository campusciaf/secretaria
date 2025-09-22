<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiEstudiantesEnCobro{
    public function listarEstudiantesEnCobro(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sp`.`id_persona`, `sp`.`numero_documento`, `sp`.`nombres`, `sp`.`apellidos`, `sp`.`email`, `sp`.`celular`, `sp`.`periodo`, `sm`.`id` AS `consecutivo`, `sm`.`fecha_inicial`, `sm`.`ultima_fecha_cuota`  FROM `sofi_matricula` `sm` INNER JOIN `sofi_persona` `sp` ON `sp`.`id_persona` = `sm`.`id_persona` WHERE `sm`.`en_cobro` = 1 AND `sp`.`estado` != 'Anulado' ORDER BY `sp`.`periodo` DESC;");
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
