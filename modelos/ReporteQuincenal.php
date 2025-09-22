<?php
require "../config/Conexion.php";
class Reportequincenal{
    public function __construct() {}
    public function estudiante_x_mes($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion){
        global $mbd;
        if ($motivo_financiacion == "Todos") {
            $motivo_financiacion = "%%";
        }
        $sentencia = $mbd->prepare("SELECT 
                                        `sofi_persona`.`id_persona`, `sofi_persona`.`nombres`, `sofi_persona`.`apellidos`, `sofi_matricula`.`id`, `sofi_persona`.`numero_documento`, `sofi_persona`.`celular`, `sofi_persona`.`email`, `sofi_matricula`.`programa`, `sofi_matricula`.`semestre`, `sofi_matricula`.`jornada`, `sofi_persona`.`labora`, `sofi_matricula`.`en_cobro`, `sofi_persona`.`periodo`, `sofi_matricula`.`fecha_inicial`
                                    FROM `sofi_persona` 
                                        INNER JOIN `sofi_matricula` ON `sofi_matricula`.`id_persona` = `sofi_persona`.`id_persona` 
                                        INNER JOIN `sofi_financiamiento` ON `sofi_financiamiento`.`numero_documento` = `sofi_persona`.`id_persona` 
                                    WHERE `sofi_persona`.`estado` <> 'Anulado' 
                                        AND `sofi_matricula`.`estado_financiacion` = 1 
                                        AND `fecha_pago` BETWEEN :fecha_inicial AND :fecha_final 
                                        AND (`sofi_financiamiento`.`estado` = 'A Pagar' or `sofi_financiamiento`.`estado` = 'Abonado') 
                                        AND `sofi_matricula`.`periodo` LIKE :periodo 
                                        AND `motivo_financiacion`  LIKE :motivo_financiacion 
                                    ORDER BY `sofi_financiamiento`.`fecha_pago` DESC");
        $sentencia->bindParam(":fecha_inicial", $fecha_inicial);
        $sentencia->bindParam(":fecha_final", $fecha_final);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":motivo_financiacion", $motivo_financiacion);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function estudiante_x_mes_pagados($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion){
        global $mbd;
        if ($motivo_financiacion == "Todos") {
            $motivo_financiacion = "%%";
        }
        $sentencia = $mbd->prepare("SELECT 
                                        `sofi_persona`.`id_persona`, `sofi_persona`.`nombres`, `sofi_persona`.`apellidos`, `sofi_matricula`.`id`, `sofi_persona`.`numero_documento`, `sofi_persona`.`celular`, `sofi_persona`.`email`, `sofi_matricula`.`programa`, `sofi_matricula`.`semestre`, `sofi_matricula`.`jornada`, `sofi_persona`.`labora`, `sofi_matricula`.`en_cobro`, `sofi_persona`.`periodo`, `sofi_matricula`.`fecha_inicial`
                                    FROM `sofi_persona` 
                                    INNER JOIN `sofi_matricula` ON `sofi_matricula`.`id_persona` = `sofi_persona`.`id_persona` 
                                    INNER JOIN `sofi_financiamiento` ON `sofi_financiamiento`.`numero_documento` = `sofi_persona`.`id_persona` 
                                    WHERE `sofi_persona`.`estado` <> 'Anulado' AND `sofi_matricula`.`estado_financiacion` = 1 AND `fecha_pago` BETWEEN :fecha_inicial AND :fecha_final AND (`sofi_financiamiento`.`estado` = 'Pagado') AND `sofi_matricula`.`periodo` LIKE :periodo AND `motivo_financiacion` LIKE :motivo_financiacion 
                                    ORDER BY `sofi_financiamiento`.`fecha_pago` DESC");
        $sentencia->bindParam(":fecha_inicial", $fecha_inicial);
        $sentencia->bindParam(":fecha_final", $fecha_final);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":motivo_financiacion", $motivo_financiacion);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function cantidad_atrasos($matricula){
        global $mbd;
        $date = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT COUNT(*) as `total` FROM `sofi_financiamiento` WHERE `id_matricula` = :matricula AND (`estado` = 'A Pagar' or `estado` = 'Abonado') and `fecha_pago` <= :fecha_pago");
        $sentencia->bindParam(":matricula", $matricula);
        $sentencia->bindParam(":fecha_pago", $date);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function traerFechas($periodo, $motivo_financiacion){
        global $mbd;
        $motivo_financiacion = ($motivo_financiacion == "Todos") ? "%%" : $motivo_financiacion;
        $sentencia = $mbd->prepare("SELECT MIN(`fecha_pago`) AS inicio, MAX(`fecha_pago`) AS fin FROM `sofi_matricula` INNER JOIN `sofi_financiamiento` ON `sofi_financiamiento`.`id_matricula` = `sofi_matricula`.`id`  WHERE `periodo` LIKE :periodo AND `motivo_financiacion` LIKE :motivo_financiacion");
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":motivo_financiacion", $motivo_financiacion);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function reporte_quincenal($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion){
        global $mbd;
        if ($motivo_financiacion == "Todos") {
            $motivo_financiacion = "%%";
        }
        $sentencia = $mbd->prepare("SELECT count(*) as total 
                                    FROM `sofi_financiamiento` 
                                    INNER JOIN `sofi_persona` on `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento` 
                                    INNER JOIN `sofi_matricula` ON `sofi_matricula`.`id` = `sofi_financiamiento`.`id_matricula` 
                                    WHERE `sofi_persona`.`estado` <> 'Anulado' AND `sofi_matricula`.`periodo` LIKE :periodo AND `fecha_pago` BETWEEN :fecha_inicial AND :fecha_final AND `motivo_financiacion` LIKE :motivo_financiacion 
                                    ORDER BY `sofi_financiamiento`.`fecha_pago` DESC");
        $sentencia->bindParam(":fecha_inicial", $fecha_inicial);
        $sentencia->bindParam(":fecha_final", $fecha_final);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":motivo_financiacion", $motivo_financiacion);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function reporte_quincenal_pagados($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion){
        global $mbd;
        if ($motivo_financiacion == "Todos") {
            $motivo_financiacion = "%%";
        }
        $sentencia = $mbd->prepare("SELECT COUNT(*) as total 
                                    FROM `sofi_financiamiento` 
                                    INNER JOIN `sofi_persona` on `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento` 
                                    INNER JOIN `sofi_matricula` ON `sofi_matricula`.`id` = `sofi_financiamiento`.`id_matricula` 
                                    WHERE `sofi_financiamiento`.`estado` = 'Pagado' AND `sofi_matricula`.`periodo` LIKE :periodo AND `sofi_persona`.`estado` <> 'Anulado' AND `fecha_pago` BETWEEN :fecha_inicial AND :fecha_final AND `motivo_financiacion` LIKE :motivo_financiacion
                                    ORDER BY `sofi_financiamiento`.`fecha_pago` DESC");
        $sentencia->bindParam(":fecha_inicial", $fecha_inicial);
        $sentencia->bindParam(":fecha_final", $fecha_final);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":motivo_financiacion", $motivo_financiacion);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function reporte_valor_cartera($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion){
        global $mbd;
        if ($motivo_financiacion == "Todos") {
            $motivo_financiacion = "%%";
        }
        $sentencia = $mbd->prepare("SELECT SUM(`valor_cuota`) as `valor_total`, SUM(`valor_pagado`) as `valor_pagado`
                                    FROM `sofi_financiamiento` 
                                    INNER JOIN `sofi_persona` on `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento` 
                                    INNER JOIN `sofi_matricula` ON `sofi_matricula`.`id` = `sofi_financiamiento`.`id_matricula` 
                                    WHERE `sofi_persona`.`estado` <> 'Anulado' AND `sofi_matricula`.`periodo` LIKE :periodo AND `fecha_pago` BETWEEN :fecha_inicial AND :fecha_final AND `motivo_financiacion` LIKE :motivo_financiacion 
                                    ORDER BY `sofi_financiamiento`.`fecha_pago` DESC;");
        $sentencia->bindParam(":fecha_inicial", $fecha_inicial);
        $sentencia->bindParam(":fecha_final", $fecha_final);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":motivo_financiacion", $motivo_financiacion);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function moneyFormat($price){
        $currencies['COP'] = array(2, ',', '.'); // Colombian Peso
        // Verificar si $price es null o no es un número
        if ($price === null || !is_numeric($price)) {
            // Aquí uso 'COP' como ejemplo, ajusta según la moneda que necesites
            return number_format(0, $currencies['COP'][0], $currencies['COP'][1], $currencies['COP'][2]);
        }
        return number_format($price, $currencies['COP'][0], $currencies['COP'][1], $currencies['COP'][2]);
    }
    function traerPeriodo(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_periodo`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro["periodo_actual"];
    }
    public function listarperiodos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT DISTINCT(`periodo`) AS `periodo` FROM `sofi_matricula`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function search($dato_busqueda, $tipo_busqueda){
        global $mbd;
        if ($tipo_busqueda == 'Cedula' or $tipo_busqueda == 'Cédula') {
            $sql = "SELECT DISTINCT `sofi_matricula`.*, `sofi_matricula`.`estado_financiacion` FROM ((`sofi_financiamiento` INNER JOIN `sofi_persona` on `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`)INNER JOIN `sofi_matricula` on `sofi_matricula`.`id_persona` = `sofi_persona`.`id_persona`) WHERE ";
            $sql .= " `sofi_persona`.`numero_documento` = '$dato_busqueda';";
        } else if ($tipo_busqueda == 'Consecutivo') {
            $sql = "SELECT `sofi_financiamiento`.*, `sofi_matricula`.`estado_financiacion` FROM ((`sofi_financiamiento` INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`)INNER JOIN `sofi_matricula` ON `sofi_matricula`.`id_persona` = `sofi_persona`.`id_persona`) WHERE";
            $sql .= " `sofi_financiamiento`.`id_matricula` = '$dato_busqueda';";
        } else if ($tipo_busqueda == 'Nombre') {
            $sql = "SELECT DISTINCT `sofi_matricula`.*, `sofi_matricula`.`estado_financiacion`, `sofi_persona`.`numero_documento`, `sofi_persona`.`nombres`, `sofi_persona`.`apellidos`, `sofi_persona`.`fecha_nacimiento` FROM ((`sofi_financiamiento` INNER JOIN `sofi_persona` ON `persona`.`id_persona` = `financiamiento`.`numero_documento`)INNER JOIN `sofi_matricula` ON `sofi_matricula`.`id_persona` = `sofi_persona`.`id_persona`) WHERE";
            $sql .= " `sofi_persona`.`nombres` LIKE '%$dato_busqueda%' OR `sofi_persona`.`apellidos` LIKE '%$dato_busqueda%';";
        }
        $sentencia = $mbd->prepare($sql);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function dias_atrazo($fecha_plazo){
        $hoy = new DateTime(date('Y/m/d'));
        $format_plazo = new DateTime($fecha_plazo);
        $dias = date_diff($hoy, $format_plazo)->format('%a');
        return ($hoy >= $format_plazo) ? $dias : "-" . $dias;
    }
}