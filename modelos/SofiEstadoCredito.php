<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiEstadoCredito{
    public function listarConsecutivos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sm`.`id`, `sp`.`id_persona`, `sp`.`estado` FROM `sofi_matricula` `sm` INNER JOIN `sofi_persona` `sp` ON `sm`.`id_persona` = `sp`.`id_persona` WHERE `sp`.`estado` = 'Aprobado';");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listarUltimaCuota($id){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sofi_financiamiento`.`numero_cuota`, `sofi_financiamiento`.`estado` FROM `sofi_financiamiento` WHERE `id_matricula` = :id_matricula ORDER BY `sofi_financiamiento`.`numero_cuota` DESC LIMIT 1;");
        $sentencia->bindParam(':id_matricula', $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //actualizar el estado del credito
    public function actualizarEstadoCredito($id, $estado){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula` SET `sofi_matricula`.`credito_finalizado` = :estado WHERE `sofi_matricula`.`id` = :id;");
        $sentencia->bindParam(':id', $id);
        $sentencia->bindParam(':estado', $estado);
        return $sentencia->execute();
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarCreditosActivos($periodo){
        global $mbd;
        if ($periodo == "Todos") {
            $periodo = "%%";
        }
        $sentencia = $mbd->prepare("SELECT `sofi_persona`.`nombres`, `sofi_persona`.`apellidos`, `sofi_persona`.`email`, `sofi_persona`.`celular`, `sofi_matricula`.`id`, `sofi_matricula`.`programa`,`sofi_matricula`.`semestre`, `sofi_matricula`.`jornada`, `sofi_matricula`.`periodo`, `sofi_matricula`.`motivo_financiacion`, `sofi_financiamiento`.`numero_cuota`, `sofi_financiamiento`.`fecha_pago`, `sofi_financiamiento`.`plazo_pago`, `sofi_financiamiento`.`valor_cuota`, `sofi_financiamiento`.`valor_pagado`, `sofi_persona`.`numero_documento` AS `cedula`, `shp`.`fecha_pagada`, `shp`.`numero_cuota` AS `cuota_pagada`, `shp`.`valor_pagado` AS `historico_valor_pagado`, CASE WHEN `sofi_matricula`.`credito_finalizado` = 1 THEN 'Finalizado' WHEN `sofi_matricula`.`credito_finalizado` = 0 THEN 'Al día' END AS `credito_finalizado`FROM `sofi_persona`INNER JOIN `sofi_matricula` ON `sofi_persona`.`id_persona` = `sofi_matricula`.`id_persona` INNER JOIN `sofi_financiamiento` ON `sofi_financiamiento`.`id_matricula` = `sofi_matricula`.`id`LEFT JOIN `sofi_historial_pagos` `shp` ON `shp`.`id_financiamiento` = `sofi_financiamiento`.`id_financiamiento` WHERE `sofi_persona`.`estado` <> 'Anulado'   AND `sofi_matricula`.`periodo` LIKE :periodo ORDER BY `cedula` DESC, `sofi_financiamiento`.`numero_cuota` ASC;");
        $sentencia->bindParam(':periodo', $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarFinanciamiento($id){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :id");
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista los periodos en los que el sofi tiene creditos
    public function periodosEnSofi(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT DISTINCT `periodo` FROM `sofi_persona`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    function EliminarCeros(){
        global $mbd;
        $sentencia = $mbd->prepare("DELETE FROM sofi_historial_pagos WHERE valor_pagado = 0" );
        return $sentencia->execute();
        
    }
    function listarCuotasID() {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT id_historial, consecutivo, numero_cuota FROM sofi_historial_pagos WHERE id_financiamiento IS NULL" );
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    function financiamientoPorConsecutivoCuota($consecutivo,$numero_cuota){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT id_financiamiento FROM sofi_financiamiento WHERE id_matricula = :consecutivo AND numero_cuota = :numero_cuota" );
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':numero_cuota', $numero_cuota);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro["id_financiamiento"];
    }
    function UpdatePagos($id_historial, $id_financiamiento){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE sofi_historial_pagos SET id_financiamiento = :id_financiamiento WHERE id_historial = :id_historial");
        $sentencia->bindParam(':id_financiamiento', $id_financiamiento);
        $sentencia->bindParam(':id_historial', $id_historial);
        $sentencia->execute();
    }
}
?>