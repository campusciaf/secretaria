<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class Financiacion{
    //lista todos los financiados
    public function listarCuotas($tipo_busqueda, $dato_busqueda)
    {
        $dato_busqueda = "%" . $dato_busqueda . "%";
        global $mbd;
        $sql = "SELECT `sofi_persona`.`estado` AS estado_credito , `sofi_persona`.*, `sofi_matricula`.*
                FROM (`sofi_persona` 
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
        //condicion para listar los datos
        if ($tipo_busqueda == 1) {
            $condition = "WHERE `sofi_matricula`.`credito_finalizado` = 0 AND `sofi_persona`.`numero_documento` LIKE :dato ORDER BY `sofi_matricula`.`periodo` DESC";
        } else if ($tipo_busqueda == 2) {
            $sql = "SELECT `sofi_persona`.`estado` AS estado_credito, `sofi_persona`.*, `sofi_financiamiento`.*, `sofi_matricula`.* 
                FROM ((`sofi_financiamiento` 
                INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`)
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
            $condition = "WHERE `sofi_matricula`.`credito_finalizado` = 0 AND `sofi_financiamiento`.`id_matricula` LIKE :dato  ORDER BY `sofi_financiamiento`.`numero_cuota` ASC";
        } else {
            $condition = "WHERE `sofi_matricula`.`credito_finalizado` = 0 AND `sofi_persona`.`nombres` LIKE :dato OR `sofi_persona`.`apellidos` LIKE :dato ORDER BY `sofi_matricula`.`periodo` DESC";
        }
        $sql = $sql . $condition;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":dato", $dato_busqueda);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los financiados
    public function listarCuotasFinalizadas($tipo_busqueda, $dato_busqueda)
    {
        $dato_busqueda = "%" . $dato_busqueda . "%";
        //se define la variable global para la conexion a la base de datos
        global $mbd;
        $sql = "SELECT `sofi_persona`.`estado` AS estado_credito , `sofi_persona`.*, `sofi_matricula`.*
                FROM (`sofi_persona` 
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
        //condicion para listar los datos
        if ($tipo_busqueda == 1) {
            $condition = "WHERE `sofi_matricula`.`credito_finalizado` = 1 AND `sofi_persona`.`numero_documento` = :dato ORDER BY `sofi_matricula`.`periodo` DESC";
        } else if ($tipo_busqueda == 2) {
            $sql = "SELECT `sofi_persona`.`estado` AS estado_credito, `sofi_persona`.*, `sofi_financiamiento`.*, `sofi_matricula`.* 
                FROM ((`sofi_financiamiento` 
                INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`)
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
            $condition = "WHERE `sofi_matricula`.`credito_finalizado` = 1 AND `sofi_financiamiento`.`id_matricula` LIKE :dato  ORDER BY `sofi_financiamiento`.`numero_cuota` ASC";
        } else {
            $condition = "WHERE `sofi_matricula`.`credito_finalizado` = 1 AND `sofi_persona`.`nombres` LIKE :dato OR `sofi_persona`.`apellidos` LIKE :dato ORDER BY `sofi_matricula`.`periodo` DESC";
        }
        $sql = $sql . $condition;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":dato", $dato_busqueda);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra el historial de pagos  del financiamiento
    public function pagoMinimoCuota($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT *, CAST((`valor_cuota` - `valor_pagado`) AS SIGNED) AS `valor_pagar` 
                                    FROM `sofi_financiamiento` 
                                    WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' 
                                    ORDER BY `sofi_financiamiento`.`fecha_pago` ASC
                                    LIMIT 1
                                    ");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra el historial de pagos  del financiamiento
    public function pagoTotalCuota($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT *, CAST((SUM(`valor_cuota`) - SUM(`valor_pagado`)) AS SIGNED) AS `valor_total` 
        FROM `sofi_financiamiento` 
        WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' 
        ORDER BY `sofi_financiamiento`.`fecha_pago` ASC 
        LIMIT 1");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico por CONSECUTIVO
    public function verInfoSolicitante($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM (`sofi_persona`
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) 
                WHERE `sofi_matricula`.`id` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra total cuotas por CONSECUTIVO
    public function cuotasTotales($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) as `total` FROM `sofi_financiamiento` where id_matricula = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico por CONSECUTIVO
    public function CuotasPagadas($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) as `total` FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` = 'Pagado'");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra el salod debito del financiamiento
    public function saldoDebito($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT SUM(`valor_cuota`) - SUM(`valor_pagado`) as saldo_debito FROM `sofi_financiamiento` 
        WHERE `id_matricula` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //cambia el estado de financiacion
    public function cambiarEstadoFinanciacion($estado_financiacion, $id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_persona`
                SET `estado` = :estado 
                WHERE `sofi_persona`.`id_persona` = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':estado', $estado_financiacion);
        return $sentencia->execute();
    }
    //cambia el estado de Ciafi
    public function cambiarEstadoCiafi($estado_ciafi, $consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula`
                SET `estado_ciafi` = :estado_ciafi 
                WHERE `sofi_matricula`.`id` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':estado_ciafi', $estado_ciafi);
        return $sentencia->execute();
    }
    //cambia el estado de cobro
    public function cambiarEstadoCobro($en_cobro, $consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula`
                SET `en_cobro` = :en_cobro 
                WHERE `sofi_matricula`.`id` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':en_cobro', $en_cobro);
        return $sentencia->execute();
    }
    //pagar el total de la cuota
    public function pagarCuota($id_financiamiento)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento`
                SET `valor_pagado` = `valor_cuota`, `estado` = 'Pagado' 
                WHERE `sofi_financiamiento`.`id_financiamiento` = :id_financiamiento");
        $sentencia->bindParam(':id_financiamiento', $id_financiamiento);
        return $sentencia->execute();
    }
    //muestra la cuota especifica
    public function consultarCuota($id_financiamiento)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE id_financiamiento = :id_financiamiento");
        $sentencia->bindParam(':id_financiamiento', $id_financiamiento);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //pagar el total de la cuota
    public function abonarCuota($id_financiamiento, $valor_pagado)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento`
                SET `valor_pagado` = `valor_pagado` + :valor_pagado, `estado` = 'Abonado' 
                WHERE `sofi_financiamiento`.`id_financiamiento` = :id_financiamiento");
        $sentencia->bindParam(':id_financiamiento', $id_financiamiento);
        $sentencia->bindParam(':valor_pagado', $valor_pagado);
        return $sentencia->execute();
    }
    //muestra la cuota especifica
    public function consultarCuotasNoPagadas($consecutivo){
        global $mbd;
        $fecha_actual = date("y-m-d");
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' AND `plazo_pago` < :fecha_actual ");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':fecha_actual', $fecha_actual);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra la cantidad de interes mora 
    public function TraerInteresMora($fecha_interes)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_interes_mora`  WHERE `fecha_mes` like '$fecha_interes%' LIMIT 1;");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //Muestra las tareas que el estudiante tiene registrada 
    public function verTareas($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sofi_tareas`.*, `usuario`.`usuario_nombre`, `usuario`.`usuario_nombre_2`, `usuario`.`usuario_apellido`, `usuario`.`usuario_apellido_2` FROM `usuario` INNER JOIN `sofi_tareas` on `sofi_tareas`.`id_asesor` = `usuario`.`id_usuario` WHERE `sofi_tareas`.`id_persona` = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //Muestra las cuotas que el estudiante tiene registradas 
    public function verCuotas($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sofi_persona`.`nombres`, `sofi_persona`.`apellidos`, `sofi_financiamiento`.*, `sofi_matricula`.`estado_financiacion` 
                                    FROM ((`sofi_financiamiento` 
                                    INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`)
                                    INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`)
                                    WHERE `sofi_financiamiento`.`id_matricula` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function infoCuota($id_cuota)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * 
                                    FROM `sofi_financiamiento` 
                                    WHERE `id_financiamiento` = :id_cuota");
        $sentencia->bindParam(':id_cuota', $id_cuota);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function CreditosActivos($numero_documento)
    {
        $numero_documento = "%" . $numero_documento . "%";
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sm`.`id`, `sm`.`motivo_financiacion` FROM `sofi_matricula` `sm` INNER JOIN `sofi_persona` `sp` ON `sm`.`id_persona` = `sp`.`id_persona` WHERE `sp`.`numero_documento` LIKE :numero_documento AND `sm`.`credito_finalizado` = 0 ORDER BY `id` DESC;");
        $sentencia->bindParam(':numero_documento', $numero_documento);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function CreditosFinalizados($numero_documento)
    {
        $numero_documento = "%" . $numero_documento . "%";
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sm`.`id`, `sm`.`motivo_financiacion`, `sm`.`periodo`, `sm`.`programa`, `sm`.`valor_total`, `sm`.`valor_financiacion`, `sm`.`descuento`, `sm`.`fecha_inicial` FROM `sofi_matricula` `sm` INNER JOIN `sofi_persona` `sp` ON `sm`.`id_persona` = `sp`.`id_persona` WHERE `sp`.`numero_documento` LIKE :numero_documento AND `sm`.`credito_finalizado` = 1 ORDER BY `id` DESC;");
        $sentencia->bindParam(':numero_documento', $numero_documento);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function traerCuotas($consecutivo){
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND estado != 'Pagado' AND DATE_FORMAT(`fecha_pago`, '%Y%m') <= DATE_FORMAT(:hoy, '%Y%m') ORDER BY `fecha_pago` ASC LIMIT 1;");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':hoy', $hoy);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    // Actualiza el estado de la financiación
    public function FinalizarFinanciacion($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula` SET `credito_finalizado` = 1 WHERE `id` = :consecutivo;
                                    UPDATE `creditos_control` SET `credito_finalizado` = 1 WHERE `consecutivo` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
    }

    public function fechaesp($date)
    {
        $dia     = explode("-", $date, 3);
        $year     = $dia[0];
        $month     = (string)(int)$dia[1];
        $day     = (string)(int)$dia[2];

        $dias         = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
        $tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
    }

    //Vuelve cualquier int en formato de dinero
    public function formatoDinero($valor)
    {
        $moneda = array(2, ',', '.'); // Peso colombiano 
        return number_format($valor, $moneda[0], $moneda[1], $moneda[2]);
    }
    //devuelve la diferencia entre 2 fechas el formato %A es para devolver en dias
    public function diferenciaFechas($inicial, $final, $formatoDiferencia = '%a')
    {
        $datetime1 = date_create($inicial);
        $datetime2 = date_create($final);
        $intervalo = date_diff($datetime1, $datetime2);
        return $intervalo->format($formatoDiferencia);
    }



    
}
