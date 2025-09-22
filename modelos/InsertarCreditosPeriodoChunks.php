<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
ob_start(); // Inicia el buffering de salida
date_default_timezone_set('America/Bogota');
class SofiConsultaCreditos
{
    //periodos en los que esta el sofi actualemnte
    public function periodoActualyAnterior()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_periodo`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista los periodos en los que el sofi tiene creditos
    public function periodosEnSofi()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT DISTINCT `periodo` FROM `sofi_persona`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarFinanciados($estado, $periodo)
    {
        global $mbd;
        if ($periodo == "Todos") {
            $periodo = "%%";
        }
        //$sentencia = $mbd->prepare("SELECT * FROM sofi_persona INNER JOIN sofi_matricula ON sofi_persona.id_persona = sofi_matricula.id_persona  WHERE estado = :estado AND sofi_matricula.periodo LIKE :periodo AND tipo = 'Solicitante' ORDER BY sofi_persona.nombres ASC");
        $sentencia = $mbd->prepare("SELECT `sp`.`id_persona`, `sp`.`tipo_documento`,`sp`.`numero_documento`, `sp`.`nombres`, `sp`.`apellidos`, `sp`.`id_programa`, `sp`.`email`, `sp`.`celular`, `sp`.`direccion`,`sp`.`ciudad`, `sm`.`id`, `sm`.`programa`, `sm`.`ultima_fecha_cuota`, `sm`.`semestre`, `sm`.`jornada`, `sm`.`valor_financiacion`, `sm`.`motivo_financiacion`, `sm`.`dia_pago`, `sm`.`create_dt` AS `fecha_inicial`, `sm`.`credito_finalizado`, `sm`.`cantidad_tiempo` FROM `sofi_persona` `sp` INNER JOIN `sofi_matricula` `sm` ON `sp`.`id_persona` = `sm`.`id_persona` WHERE `sp`.`estado`= :estado AND `sm`.`periodo` LIKE :periodo;");
        $sentencia->bindParam(':estado', $estado);
        $sentencia->bindParam(':periodo', $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarFinanciamiento($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :id");
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function InsertarCredito($consecutivo, $id_persona, $cedula, $nombre, $programa, $semestre, $jornada, $credito, $faltante, $cuotas, $periodo, $motivo, $atraso, $estado, $fecha_inicio, $cuotas_atrasadas, $fecha_ultimo_pago, $credito_finalizado, $tipo_documento, $ultima_fecha_cuota, $cuotas_pagadas, $email, $celular, $direccion, $ciudad)
    {
        $ultimo_ajuste_cron = date("Y-m-d H:i:s");
        global $mbd;
        // Consulta SQL para insertar datos
        $sql = "INSERT INTO `creditos_control`( `consecutivo`, `id_persona`, `cedula`, `nombre`, `programa`, `semestre`, `jornada`,  `credito`, `faltante`, `cuotas`, `periodo`, `motivo`, `atraso`, `estado`,  `fecha_inicio`, `cuotas_atrasadas`, `fecha_ultimo_pago`, `credito_finalizado`, `tipo_documento`, `ultima_fecha_cuota`, `ultimo_ajuste_cron`, `cuotas_pagadas`, `email`, `celular`, `direccion`, `ciudad`) VALUES ( :consecutivo, :id_persona, :cedula, :nombre, :programa, :semestre, :jornada,  :credito, :faltante, :cuotas, :periodo, :motivo, :atraso, :estado,  :fecha_inicio, :cuotas_atrasadas, :fecha_ultimo_pago, :credito_finalizado, :tipo_documento, :ultima_fecha_cuota, :ultimo_ajuste_cron, :cuotas_pagadas, :email, :celular, :direccion, :ciudad) ON DUPLICATE KEY UPDATE  `id_persona` = VALUES(`id_persona`), `cedula` = VALUES(`cedula`), `nombre` = VALUES(`nombre`), `programa` = VALUES(`programa`), `semestre` = VALUES(`semestre`), `jornada` = VALUES(`jornada`), `credito` = VALUES(`credito`), `faltante` = VALUES(`faltante`), `cuotas` = VALUES(`cuotas`), `periodo` = VALUES(`periodo`), `motivo` = VALUES(`motivo`), `atraso` = VALUES(`atraso`), `estado` = VALUES(`estado`), `fecha_inicio` = VALUES(`fecha_inicio`), `cuotas_atrasadas` = VALUES(`cuotas_atrasadas`), `fecha_ultimo_pago` = VALUES(`fecha_ultimo_pago`), `credito_finalizado` = VALUES(`credito_finalizado`), `tipo_documento` = VALUES(`tipo_documento`), `ultima_fecha_cuota` = VALUES(`ultima_fecha_cuota`), `ultimo_ajuste_cron` = VALUES(`ultimo_ajuste_cron`), `cuotas_pagadas` = VALUES(`cuotas_pagadas`), `email` = VALUES(`email`), `celular` = VALUES(`celular`), `direccion` = VALUES(`direccion`), `ciudad` = VALUES(`ciudad`);";
        // Preparar la consulta
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":consecutivo", $consecutivo);
        $sentencia->bindParam(":id_persona", $id_persona);
        $sentencia->bindParam(":cedula", $cedula);
        $sentencia->bindParam(":nombre", $nombre);
        $sentencia->bindParam(":programa", $programa);
        $sentencia->bindParam(":semestre", $semestre);
        $sentencia->bindParam(":jornada", $jornada);
        $sentencia->bindParam(":credito", $credito);
        $sentencia->bindParam(":faltante", $faltante);
        $sentencia->bindParam(":cuotas", $cuotas);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":motivo", $motivo);
        $sentencia->bindParam(":atraso", $atraso);
        $sentencia->bindParam(":estado", $estado);
        $sentencia->bindParam(":fecha_inicio", $fecha_inicio);
        $sentencia->bindParam(":cuotas_atrasadas", $cuotas_atrasadas);
        $sentencia->bindParam(":fecha_ultimo_pago", $fecha_ultimo_pago);
        $sentencia->bindParam(":credito_finalizado", $credito_finalizado);
        $sentencia->bindParam(":tipo_documento", $tipo_documento);
        $sentencia->bindParam(":ultima_fecha_cuota", $ultima_fecha_cuota);
        $sentencia->bindParam(":ultimo_ajuste_cron", $ultimo_ajuste_cron);
        $sentencia->bindParam(":cuotas_pagadas", $cuotas_pagadas);
        $sentencia->bindParam(":email", $email);
        $sentencia->bindParam(":celular", $celular);
        $sentencia->bindParam(":direccion", $direccion);
        $sentencia->bindParam(":ciudad", $ciudad);
        // Ejecutar la consulta
        return $sentencia->execute();
    }
    public function UltimoPago($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `fecha_pagada` FROM `sofi_historial_pagos` WHERE `consecutivo` = :consecutivo ORDER BY `sofi_historial_pagos`.`fecha_pagada` DESC LIMIT 1;");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
}
$consulta = new SofiConsultaCreditos();
// Lista de periodos a procesar
$periodos = array("2025-2", "2025-1", "2024-2", "2024-1", "2023-2", "2023-1", "2022-2", "2022-1", "2021-2", "2021-1", "2020-2", "2020-1", "2019-2", "2019-1");
foreach ($periodos as $periodo) {
    // Mostrar en pantalla qué periodo se está procesando
    echo "<strong>Procesando periodo $periodo</strong><br>";
    ob_flush();
    flush(); // Forzar salida al navegador inmediatamente
    // Consultar todos los estudiantes financiados con estado "Aprobado" para el periodo actual
    $rsta = $consulta->listarFinanciados("Aprobado", $periodo);
    // Dividir el resultado en bloques de 100 registros para evitar sobrecarga
    $bloques = array_chunk($rsta, 100);
    foreach ($bloques as $bloque) {
        global $mbd; // Objeto de conexión PDO
        try {
            // Iniciar transacción para agrupar múltiples inserts
            $mbd->beginTransaction();
            foreach ($bloque as $registro) {
                // Separar la fecha inicial (descartar la hora si existe)
                $fecha_separada = explode(" ", $registro["fecha_inicial"]);
                $fecha = $fecha_separada[0];
                // Extraer variables del array asociativo para usar como variables simples
                extract($registro);
                $consecutivo = $registro["id"];
                $cedula = $numero_documento;
                // Inicializar variables de control de pagos
                $cuotas_pagadas = 0;
                $dias_de_atraso = 0;
                $cuotas_atrasadas = 0;
                $valor_total_pagado = 0;
                $estado_credito = "Al día";
                // Obtener detalles del financiamiento (cuotas del crédito)
                $rsta_2 = $consulta->listarFinanciamiento($consecutivo);
                // Recorrer cada cuota del crédito
                foreach ($rsta_2 as $cuota) {
                    extract($cuota); // Extraer campos como $estado, $plazo_pago, etc.
                    $datetime1 = new DateTime($plazo_pago); // Fecha de vencimiento de la cuota
                    $datetime2 = new DateTime(date("Y-m-d")); // Fecha actual
                    // Si no está pagado y la fecha ya pasó, hay atraso
                    if ($estado != "Pagado" && $datetime1 < $datetime2) {
                        $dias_de_atraso = $datetime2->diff($datetime1)->format('%a');
                        $estado_credito = "Atrasado";
                        $cuotas_atrasadas++;
                        $valor_total_pagado += $valor_pagado; // Acumular pagos aunque esté en atraso
                        break; // Salir del bucle al encontrar el primer atraso
                    } else {
                        if ($estado == "Pagado"){
                            $cuotas_pagadas++;
                        }
                        // Si está al día, sumar el valor pagado
                        $valor_total_pagado += $valor_pagado;
                    }
                }
                // Consultar la fecha del último pago realizado
                $datos_fecha_pago = $consulta->UltimoPago($id);
                $fecha_pagada = isset($datos_fecha_pago["fecha_pagada"]) ? $datos_fecha_pago["fecha_pagada"] : NULL;
                // Calcular cuánto falta por pagar
                $valor_faltante = intval($valor_financiacion) - intval($valor_total_pagado);
                // Determinar cuántas cuotas tiene el crédito (doble si es quincenal)
                $cuotas = ($dia_pago == "Quincenal") ? 2 * $cantidad_tiempo : $cantidad_tiempo;
                // Insertar o actualizar el registro en la tabla creditos_control
                $consulta->InsertarCredito(
                    $id, // consecutivo
                    $id_persona,
                    $cedula,
                    strtoupper($nombres . " " . $apellidos),
                    strtoupper($programa),
                    $semestre,
                    strtoupper($jornada),
                    $valor_financiacion,
                    $valor_faltante,
                    $cuotas,
                    $periodo,
                    strtoupper($motivo_financiacion),
                    $dias_de_atraso,
                    $estado_credito,
                    $fecha,
                    $cuotas_atrasadas,
                    $fecha_pagada,
                    $credito_finalizado,
                    $tipo_documento,
                    $ultima_fecha_cuota,
                    $cuotas_pagadas,
                    $email,
                    $celular,
                    $direccion,
                    $ciudad
                );
            }
            // Confirmar la transacción: se guardan todos los inserts de este bloque
            $mbd->commit();
            echo "✅ Lote procesado correctamente<br>";
            ob_flush();
            flush();
        } catch (Exception $e) {
            // En caso de error, deshacer los cambios del bloque
            $mbd->rollBack();
            echo "❌ Error procesando lote: " . $e->getMessage() . "<br>";
        }
        // Dormir 1 segundo entre bloques para evitar sobrecargar el servidor
        sleep(1);
    }
}
