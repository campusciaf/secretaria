<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiConsultarCuotas
{
    //lista todos los financiados
    public function listarCuotas($tipo_busqueda, $dato_busqueda)
    {
        global $mbd;
        $sql = "SELECT `sofi_persona`.`estado` AS estado_credito , `sofi_persona`.*, `sofi_matricula`.*
                FROM (`sofi_persona` 
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
        //condicion para listar los datos
        if ($tipo_busqueda == 1) {
            $condition = "WHERE `sofi_persona`.`numero_documento` = :dato ORDER BY `sofi_matricula`.`periodo` DESC";
        } else if ($tipo_busqueda == 2) {
            $sql = "SELECT `sofi_persona`.`estado` AS estado_credito, `sofi_persona`.*, `sofi_financiamiento`.*, `sofi_matricula`.* 
                FROM ((`sofi_financiamiento` 
                INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`)
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
            $condition = "WHERE `sofi_financiamiento`.`id_matricula` = :dato  ORDER BY `sofi_financiamiento`.`numero_cuota` ASC";
        } else if ($tipo_busqueda == 3) {
            $dato_busqueda = "%" . $dato_busqueda . "%";
            $condition = "WHERE `sofi_persona`.`nombres` LIKE :dato OR `sofi_persona`.`apellidos` LIKE :dato ORDER BY `sofi_matricula`.`periodo` DESC";
        } else if ($tipo_busqueda == 4) {
            $condition = "WHERE `sofi_persona`.`celular` = :dato ORDER BY `sofi_matricula`.`periodo` DESC";
        }
        $sql = $sql . $condition;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":dato", $dato_busqueda);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico por CONSECUTIVO
    public function verInfoSolicitante($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sp`.*, `sm`.*, `ce`.`id_credencial` FROM (`sofi_persona` `sp` INNER JOIN `sofi_matricula` `sm` ON `sm`.`id_persona` = `sp`.`id_persona`) LEFT JOIN `credencial_estudiante` `ce` ON `sp`.`numero_documento` = `ce`.`credencial_identificacion` WHERE `sm`.`id` = :consecutivo;");
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
    //muestra el historial de pagos  del financiamiento
    public function historialPagos($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_historial_pagos` 
        WHERE `consecutivo` = :consecutivo
        ORDER BY `sofi_historial_pagos`.`numero_cuota` ASC");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra el historial de pagos  del financiamiento
    public function historialPagosMora($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_pagos_mora` 
        WHERE `consecutivo` = :consecutivo
        ORDER BY `sofi_pagos_mora`.`numero_cuota` ASC");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
    //cambia el estado de financiacion
    public function generarHistorialCiafi($consecutivo, $estado, $id_usuario){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT `sofi_historial_bloqueos`(`estado`, `consecutivo`, `id_usuario`) VALUES(:estado, :consecutivo, :id_usuario)");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':estado', $estado);
        $sentencia->bindParam(':id_usuario', $id_usuario);
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
    public function pagarCuota($id_financiamiento, $consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento`
                SET `valor_pagado` = `valor_cuota`, `estado` = 'Pagado' 
                WHERE `sofi_financiamiento`.`id_financiamiento` = :id_financiamiento");
        $sentencia->bindParam(':id_financiamiento', $id_financiamiento);
        if ($sentencia->execute()) {
            $rspta = self::getAtrasado($consecutivo);
            if (!(is_array($rspta) && count($rspta) > 0)) {
                self::cambiarEstadoCiafi(1, $consecutivo);
            }
            return true;
        } else {
            return false;
        }
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
    public function consultarCuotasNoPagadasTotales($consecutivo)
    {
        global $mbd;
        $fecha_actual = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado'");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':fecha_actual', $fecha_actual);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra la cuota especifica
    public function consultarCuotasNoPagadas($consecutivo)
    {
        global $mbd;
        $fecha_actual = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' AND `plazo_pago` <= :fecha_actual ");
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
    // Función para calcular los días entre dos fechas
    function calcularDiasTranscurridos($fecha_inicio, $fecha_fin)
    {
        $datetime1 = new DateTime($fecha_inicio);
        $datetime2 = new DateTime($fecha_fin);
        $interval = $datetime1->diff($datetime2);
        return $interval->days;
    }
    //lista todos los financiados
    public function generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_a_pagar, $id_financiamiento)
    {
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("INSERT INTO `sofi_historial_pagos`(`id_historial`, `consecutivo`, `id_financiamiento`, `numero_cuota`, `fecha_pagada`, `fecha_pago`, `valor_pagado`) VALUES(NULL, :consecutivo, :id_financiamiento, :numero_cuota, :fecha_pagada, :fecha_pago, :valor_a_pagar);");
        $sentencia->bindParam(":consecutivo", $consecutivo);
        $sentencia->bindParam(":id_financiamiento", $id_financiamiento);
        $sentencia->bindParam(":numero_cuota", $numero_cuota);
        $sentencia->bindParam(":fecha_pagada", $hoy);
        $sentencia->bindParam(":fecha_pago", $fecha_pago);
        $sentencia->bindParam(":valor_a_pagar", $valor_a_pagar);
        return $sentencia->execute();
    }
    //hace la insercion del seguimiento para los fiananciados
    public function guardarCategoria($consecutivo_credito, $categoria_credito)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula` SET `categoria_credito` = :categoria_credito WHERE `id` = :consecutivo_credito");
        $sentencia->bindParam(':consecutivo_credito', $consecutivo_credito);
        $sentencia->bindParam(':categoria_credito', $categoria_credito);
        return $sentencia->execute();
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
    //actualiza el estado de la cuota para indicar que se envio el mail
    public function actualizarEstadoMail($id_persona)
    {
        global $mbd;
        $hoy = /*"2020-10-12"*/ date("Y-m-d");
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento` SET `estado_mail`= 1 WHERE `numero_documento` = :id_persona and `fecha_pago` BETWEEN :fecha AND DATE_ADD(:fecha, INTERVAL 3 DAY)");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':fecha', $hoy);
        return $sentencia->execute();
    }
    //Paga el valor de mora que se haya agregado
    public function pagarMora($consecutivo, $numero_cuota, $fecha_pago, $valor_a_pagar)
    {
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("INSERT INTO `sofi_pagos_mora` VALUES(NULL, :consecutivo, :numero_cuota, :fecha_pagada, :fecha_pago, :valor_a_pagar)");
        $sentencia->bindParam(":consecutivo", $consecutivo);
        $sentencia->bindParam(":numero_cuota", $numero_cuota);
        $sentencia->bindParam(":fecha_pagada", $hoy);
        $sentencia->bindParam(":fecha_pago", $fecha_pago);
        $sentencia->bindParam(":valor_a_pagar", $valor_a_pagar);
        return $sentencia->execute();
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
    public function Categoriacredito($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `categoria_credito` 
                                    FROM `sofi_matricula` 
                                    WHERE `id` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //actualiza el estado de la cuota para indicar que se envio el mail
    public function editarCuota($id_financiamiento, $valor_pagado, $fecha_pago, $plazo_pago, $estado)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento` 
                                    SET `valor_pagado`= :valor_pagado, `fecha_pago`= :fecha_pago, `plazo_pago`= :plazo_pago, `estado` = :estado 
                                    WHERE `id_financiamiento`= :id_financiamiento");
        $sentencia->bindParam(':id_financiamiento', $id_financiamiento);
        $sentencia->bindParam(':valor_pagado', $valor_pagado);
        $sentencia->bindParam(':fecha_pago', $fecha_pago);
        $sentencia->bindParam(':plazo_pago', $plazo_pago);
        $sentencia->bindParam(':estado', $estado);
        return $sentencia->execute();
    }
    // Función para traer los eventos
    public function getAtrasado($consecutivo)
    {
        //fecha actual
        $hoy = date("Y-m-d");
        $hoy = date("Y-m-d", strtotime($hoy . " -5 days"));
        //return $hoy;
        //sentencia para traer datos de los estudiantes
        $sql = "SELECT 
                    `sofi_financiamiento`.`plazo_pago`, 
                    `sofi_matricula`.`estado_ciafi`, 
                    COUNT(*) AS `cant_cuotas`, 
                    `sofi_financiamiento`.`id_matricula` 
                FROM 
                    ((`sofi_financiamiento` 
                    INNER JOIN `sofi_matricula` ON `sofi_matricula`.`id` = `sofi_financiamiento`.`id_matricula`) 
                    INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`) 
                WHERE 
                    `sofi_financiamiento`.`plazo_pago` <= :hoy 
                    AND (`sofi_financiamiento`.`estado` = 'A Pagar' OR `sofi_financiamiento`.`estado` = 'Abonado' )
                    AND `sofi_persona`.`estado` != 'Anulado' 
                    AND `sofi_matricula`.`id` = :consecutivo 
                GROUP BY 
                    `sofi_financiamiento`.`id_matricula`, `sofi_financiamiento`.`plazo_pago`, `sofi_matricula`.`estado_ciafi` 
                ORDER BY 
                    `sofi_financiamiento`.`plazo_pago` DESC;";
        //variable de conexion global
        global $mbd;
        //preparamos el $sql
        $consulta = $mbd->prepare($sql);
        //agregamos parametros
        $consulta->bindParam(":hoy", $hoy);
        $consulta->bindParam(":consecutivo", $consecutivo);
        //ejecutamos la consulta
        $consulta->execute();
        //transformamos datos en array
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        //devolvemos al objeto una array con los respectivos datos
        return $resultado;
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
    //calculo de intereses abonados a la cuota que se deben pagar
    public function calculoAbonoInteres($consecutivo)
    {
        global $mbd;
        $sql = "SELECT IFNULL(SUM(`valor_pagado`), 0) as `total_abono_interes` FROM `sofi_pagos_mora` WHERE `consecutivo` = :consecutivo;";
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":consecutivo", $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro["total_abono_interes"];
    }
    //traer el numero de whatsapp estudiantes
    public function traerCelularEstudiante($numero_documento)
    {
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function obtenerRegistroWhastapp($numero_celular)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `whatsapp_registros` WHERE `numero_whatsapp` LIKE :numero_celular ORDER BY `numero_whatsapp` ASC");
        $sentencia->bindParam(':numero_celular', $numero_celular);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function calcularValoresDeuda($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT SUM(`valor_cuota`) AS `total_deuda`, SUM(`valor_pagado`) AS `total_pagado` FROM `sofi_financiamiento` WHERE `id_matricula` = $consecutivo");
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function finalizarCredito($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula` SET `sofi_matricula`.`credito_finalizado` = 1 WHERE `sofi_matricula`.`id` = :id;");
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
    }
    public function limpiarInteresAcumulado($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento` SET `interes_acumulado` = 0 WHERE `sofi_financiamiento`.`id_matricula` = :id_matricula");
        $sentencia->bindParam(':id_matricula', $consecutivo);
        $sentencia->execute();
    }
    public function actualizarInteresCuota($id_financiamiento, $valor_interes)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento` SET `interes_acumulado` = `interes_acumulado` + :valor_interes WHERE `sofi_financiamiento`.`id_financiamiento` = :id_financiamiento");
        $sentencia->bindParam(':id_financiamiento', $id_financiamiento);
        $sentencia->bindParam(':valor_interes', $valor_interes);
        $sentencia->execute();
    }
    function consultarCuotasAntiguaNoPagada($consecutivo)
    {
        global $mbd;
        $fecha_actual = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `plazo_pago` FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' AND `plazo_pago` <= :fecha_actual ORDER BY `sofi_financiamiento`.`plazo_pago` ASC LIMIT 1;");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':fecha_actual', $fecha_actual);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    function consultarCuotaAtrasada($consecutivo, $anio_mes_plazo)
    {
        global $mbd;
        $fecha_actual = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `id_financiamiento`, `plazo_pago`, `valor_cuota`, `valor_pagado` FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' AND `plazo_pago` <= :fecha_actual AND `plazo_pago` LIKE '$anio_mes_plazo%' ORDER BY `sofi_financiamiento`.`plazo_pago` ASC LIMIT 1;");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':fecha_actual', $fecha_actual);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    function contarMeses($fechaInicio, $fechaFin){
        $inicio = new DateTime($fechaInicio);
        $fin = new DateTime($fechaFin);
        // Ajustar la fecha final para que incluya el mes en caso de que no sea el último día del mes
        if ($inicio > $fin) {
            // Si la fecha de inicio es mayor a la de fin, devolver 0
            return 0; 
        }
        // Contamos el primer mes
        $meses = 1; 
        while ($inicio->format('Y-m') !== $fin->format('Y-m')) {
            $inicio->modify('+1 month');
            $meses++;
        }
        return $meses;
    }
}
