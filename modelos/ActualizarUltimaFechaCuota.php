<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
ob_start(); // Inicia el buffering de salida
date_default_timezone_set('America/Bogota');
class SofiConsultaCreditos{
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarFinanciados($periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `id` FROM `sofi_matricula` WHERE `periodo` LIKE :periodo;");
        $sentencia->bindParam(':periodo', $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarFinanciamiento($id){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `plazo_pago` FROM `sofi_financiamiento` WHERE `id_matricula` = :id ORDER BY `sofi_financiamiento`.`plazo_pago` DESC LIMIT 1;");
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    // Actualiza la última fecha de cuota del crédito
    public function ActualizarUltimaFechaCuota($consecutivo, $plazo_pago){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula` SET `ultima_fecha_cuota` = :plazo_pago WHERE `id` = :consecutivo; UPDATE `creditos_control` SET `ultima_fecha_cuota` = :plazo_pago WHERE `consecutivo` = :consecutivo;");
        $sentencia->bindParam(':plazo_pago', $plazo_pago);
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        return true; // Retorna true si la actualización fue exitosa
    }
}
$consulta = new SofiConsultaCreditos();
// Lista de periodos a procesar
$periodos = array("2019-1", "2019-2", "2020-1", "2020-2", "2021-1", "2021-2", "2022-1", "2022-2", "2023-1", "2023-2", "2024-1", "2024-2", "2025-1", "2025-2");
foreach ($periodos as $periodo) {
    // Mostrar en pantalla qué periodo se está procesando
    echo "<strong> Procesando periodo $periodo</strong><br>";
    ob_flush();
    flush(); // Forzar salida al navegador inmediatamente
    // Consultar todos los estudiantes financiados con estado "Aprobado" para el periodo actual
    $rsta = $consulta->listarFinanciados($periodo);
    // Dividir el resultado en bloques de 100 registros para evitar sobrecarga
    $bloques = array_chunk($rsta, 100);
    foreach ($bloques as $bloque) {
        global $mbd; // Objeto de conexión PDO
        try {
            // Iniciar transacción para agrupar múltiples inserts
            $mbd->beginTransaction();
            foreach ($bloque as $registro) {
                $consecutivo = $registro["id"];
                // Consultar los datos del crédito
                $rsta_2 = $consulta->listarFinanciamiento($consecutivo);
                $plazo_pago = $rsta_2["plazo_pago"];
                $consultar = $consulta->ActualizarUltimaFechaCuota($consecutivo, $plazo_pago);
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
