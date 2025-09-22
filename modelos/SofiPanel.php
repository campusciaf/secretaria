<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');

class SofiPanel{
    public function RecaudadoHoy(){
        global $mbd;
        $fecha_hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT COALESCE(SUM(`valor_pagado`), 0) AS `RecaudadoHoy` FROM `sofi_historial_pagos` WHERE DATE(`fecha_pagada`) = :fecha_hoy;");
        $sentencia->bindParam(":fecha_hoy", $fecha_hoy);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function NoRecaudadoHoy(){
        global $mbd;
        $fecha_hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT COALESCE(SUM(`sf`.`valor_cuota`), 0) - COALESCE(SUM(`sf`.`valor_pagado`), 0) AS `NoRecaudadoHoy` FROM `sofi_financiamiento` `sf` WHERE `sf`.`plazo_pago` = :fecha_hoy AND (`sf`.`estado` = 'A Pagar' OR `sf`.`estado` = 'Abonado');");
        $sentencia->bindParam(":fecha_hoy", $fecha_hoy);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listarInteres(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `porcentaje` FROM `sofi_interes_mora` ORDER BY `id_interes_mora` DESC LIMIT 1");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listarTotalCreditos($periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(`estado`) as `cantidad`, `estado` FROM `sofi_persona` `sp` WHERE `sp`.`periodo` = :periodo GROUP BY `estado`;");
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function fechaPrimerCreditoPeriodo($periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `fecha_inicial` FROM `sofi_matricula` WHERE `periodo` LIKE :periodo AND `estado_financiacion` = 1 ORDER BY `sofi_matricula`.`fecha_inicial` ASC LIMIT 1;");
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function NoRecaudadoTotal($periodo, $fecha_inicio, $fecha_fin){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COALESCE(SUM(`sf`.`valor_cuota`), 0) - COALESCE(SUM(`sf`.`valor_pagado`), 0) AS `NoRecaudadoTotal` FROM `sofi_persona` `sp` INNER JOIN `sofi_matricula` `sm` ON `sm`.`id_persona` = `sp`.`id_persona` INNER JOIN `sofi_financiamiento` `sf` ON `sf`.`id_matricula` = `sm`.`id` WHERE `sm`.`periodo`= :periodo AND `sp`.`estado` = 'Aprobado' AND (`sf`.`estado` = 'A Pagar' OR `sf`.`estado` = 'Abonado') AND `sf`.`fecha_pago` BETWEEN :fecha_inicio AND :fecha_fin;");
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":fecha_inicio", $fecha_inicio);
        $sentencia->bindParam(":fecha_fin", $fecha_fin);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listarCategorias(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(`categoria_credito`) AS `cantidad`, `categoria_credito` FROM `sofi_matricula` GROUP BY `categoria_credito`;");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listarCuotasVencidas(){
        global $mbd;
        $hoy = date("Y-m-d");
        $desde =date("Y-m-d",strtotime($hoy."- 3 days")); 
        
        $sentencia = $mbd->prepare("SELECT COUNT(*) as `cantidad` FROM `sofi_financiamiento` WHERE `plazo_pago` BETWEEN :desde AND :hoy AND (estado = 'A Pagar' or estado = 'Abonado') AND estado_mail = 0");
        $sentencia->bindParam(":hoy", $hoy);
        $sentencia->bindParam(":desde", $desde);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listarCuotasAVencer(){
        global $mbd;
        $hoy = date("Y-m-d");
        $desde =date("Y-m-d",strtotime($hoy."+ 3 days")); 

        $sentencia = $mbd->prepare("SELECT COUNT(*) as `cantidad` FROM `sofi_financiamiento` WHERE `plazo_pago` BETWEEN :hoy AND :desde AND (estado = 'A Pagar' or estado = 'Abonado') AND estado_mail = 0");
        $sentencia->bindParam(":hoy", $hoy);
        $sentencia->bindParam(":desde", $desde);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listarAtrasados(){
        global $mbd;
        $fecha_actual = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT COUNT(*) as cantidad FROM (`sofi_persona` INNER JOIN `sofi_matricula` ON `sofi_persona`.`id_persona` = `sofi_matricula`.`id_persona` INNER JOIN `sofi_financiamiento` ON `sofi_financiamiento`.`id_matricula` =  `sofi_matricula`.`id`) WHERE `sofi_financiamiento`.`plazo_pago` < DATE('".$fecha_actual."') AND `sofi_financiamiento`.`estado` = 'A Pagar' AND `sofi_matricula`.`estado_financiacion` = 1 AND `sofi_persona`.`estado` <> 'Anulado'");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function cantidadCarteraRecuado($periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT SUM(valor_cuota) as cartera, SUM(valor_pagado) as pagado FROM `sofi_financiamiento` INNER JOIN `sofi_matricula` ON `sofi_financiamiento`.`id_matricula` = `sofi_matricula`.`id` INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_matricula`.`id_persona` WHERE `sofi_matricula`.`periodo` = :periodo AND `sofi_matricula`.`estado_financiacion` = 1 AND `sofi_persona`.`estado` <> 'Anulado'");
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function charProyeccion($mes, $anio){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT SUM(`valor_cuota`) as total, SUM(`valor_pagado`) as entro FROM `sofi_financiamiento` INNER JOIN `sofi_persona` on `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento` WHERE `sofi_persona`.`estado` <> 'Anulado' AND  MONTH(`plazo_pago`) = :mes AND YEAR(`plazo_pago`) = :anio");
        $sentencia->bindParam(":mes", $mes);
        $sentencia->bindParam(":anio", $anio);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function moneyFormat($price){
        $currencies['EUR'] = array(2, ',', '.'); // Euro
        $currencies['ESP'] = array(2, ',', '.'); // Euro
        $currencies['USD'] = array(2, '.', ','); // US Dollar
        $currencies['COP'] = array(2, ',', '.'); // Colombian Peso
        $currencies['CLP'] = array(0,  '', '.'); // Chilean Peso
        return number_format($price, $currencies['COP'][0], $currencies['COP'][1], $currencies['COP'][2]);
    }
}
?>