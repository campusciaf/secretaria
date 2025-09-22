<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiModificarCredito{
    //lista todos los financiados
    public function listarCuotas($tipo_busqueda, $dato_busqueda){
        global $mbd;
        $sql = "SELECT `sofi_persona`.`estado` AS estado_credito , `sofi_persona`.*, `sofi_matricula`.*
                FROM (`sofi_persona` 
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
        //condicion para listar los datos
        if($tipo_busqueda == 1){
            $condition = "WHERE `sofi_persona`.`numero_documento` = :dato ORDER BY `sofi_matricula`.`periodo` DESC";
        }else if($tipo_busqueda == 2){
            $sql = "SELECT `sofi_persona`.`estado` AS estado_credito, `sofi_persona`.*, `sofi_financiamiento`.*, `sofi_matricula`.* 
                FROM ((`sofi_financiamiento` 
                INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`)
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
            $condition = "WHERE `sofi_financiamiento`.`id_matricula` = :dato  ORDER BY `sofi_financiamiento`.`numero_cuota` ASC";
        }else{
            $dato_busqueda = "%".$dato_busqueda."%";
            $condition = "WHERE `sofi_persona`.`nombres` LIKE :dato OR `sofi_persona`.`apellidos` LIKE :dato ORDER BY `sofi_matricula`.`periodo` DESC";
        }
        $sql = $sql.$condition;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":dato", $dato_busqueda);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico por CONSECUTIVO
    public function verInfoSolicitante($consecutivo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM (`sofi_persona`
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) 
                WHERE `sofi_matricula`.`id` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra el salod debito del financiamiento
    public function saldoDebito($consecutivo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT SUM(`valor_cuota`) - SUM(`valor_pagado`) as saldo_debito FROM `sofi_financiamiento` 
        WHERE `id_matricula` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra el historial de pagos  del financiamiento
    public function historialPagos($consecutivo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_historial_pagos` 
        WHERE `consecutivo` = :consecutivo
        ORDER BY `sofi_historial_pagos`.`numero_cuota` ASC");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //cambia el estado de financiacion
    public function cambiarEstadoFinanciacion($estado_financiacion, $id_persona){
     global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_persona`
                SET `estado` = :estado 
                WHERE `sofi_persona`.`id_persona` = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':estado', $estado_financiacion);
        return $sentencia->execute();
    }
    //cambia el estado de Ciafi
    public function cambiarEstadoCiafi($estado_ciafi, $consecutivo){
     global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula`
                SET `estado_ciafi` = :estado_ciafi 
                WHERE `sofi_matricula`.`id` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':estado_ciafi', $estado_ciafi);
        return $sentencia->execute();
    }
    //cambia el estado de cobro
    public function cambiarEstadoCobro($en_cobro, $consecutivo){
     global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula`
                SET `en_cobro` = :en_cobro 
                WHERE `sofi_matricula`.`id` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':en_cobro', $en_cobro);
        return $sentencia->execute();
    }
    //Muestra las tareas que el estudiante tiene registrada 
    public function verTareas($id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sofi_tareas`.*, `usuario`.`usuario_nombre`, `usuario`.`usuario_nombre_2`, `usuario`.`usuario_apellido`, `usuario`.`usuario_apellido_2` FROM `usuario` INNER JOIN `sofi_tareas` on `sofi_tareas`.`id_asesor` = `usuario`.`id_usuario` WHERE `sofi_tareas`.`id_persona` = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //Muestra las tareas que el estudiante tiene registrada 
    public function verSeguimientos($id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sofi_seguimientos`.*, `usuario`.`usuario_nombre`,  `usuario`.`usuario_nombre_2`, `usuario`.`usuario_apellido`, `usuario`.`usuario_apellido_2` FROM `usuario` INNER JOIN `sofi_seguimientos` on `sofi_seguimientos`.`id_asesor` = `usuario`.`id_usuario` WHERE `sofi_seguimientos`.`id_persona` = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //hace la insercion de la tarea para  los fiananciados
    public function insertarTarea($descripcion, $tarea_motivo, $id_usuario, $id_persona, $tarea_fecha, $tarea_hora){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_tareas`(`id_persona`, `id_asesor`, `tarea_motivo`, `tarea_observacion`, `tarea_fecha`, `tarea_hora`) VALUES(:id_persona, :id_usuario, :motivo, :descripcion, :fecha, :hora)");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->bindParam(':motivo', $tarea_motivo);
        $sentencia->bindParam(':descripcion', $descripcion);
        $sentencia->bindParam(':fecha', $tarea_fecha);
        $sentencia->bindParam(':hora', $tarea_hora);
        return $sentencia->execute();
    }
    //hace la insercion del seguimiento para los fiananciados
    public function insertarSeguimiento($descripcion, $tipo, $id_usuario, $id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_seguimientos`(`seg_descripcion`, `seg_tipo`, `id_asesor`, `id_persona`) VALUES(:descripcion, :tipo, :id_usuario, :id_persona)");
        $sentencia->bindParam(':descripcion', $descripcion);
        $sentencia->bindParam(':tipo', $tipo);
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->bindParam(':id_persona', $id_persona);
        return $sentencia->execute();
    }
    //hace la insercion del seguimiento para los fiananciados
    public function guardarCategoria($consecutivo_credito, $categoria_credito){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula` SET `categoria_credito` = :categoria_credito WHERE `id` = :consecutivo_credito");
        $sentencia->bindParam(':consecutivo_credito', $consecutivo_credito);
        $sentencia->bindParam(':categoria_credito', $categoria_credito);
        return $sentencia->execute();
    }
    //traer categoria de un credito especifico
    public function Categoriacredito($consecutivo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `categoria_credito` 
                                    FROM `sofi_matricula` 
                                    WHERE `id` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //modificar un campo especifico de la tabla de la base de datos
    public function modificarCampo($campo, $valor, $id_financiamiento){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento` SET `$campo` = :valor WHERE `id_financiamiento` = :id_financiamiento");
        $sentencia->bindParam(':id_financiamiento', $id_financiamiento);
        $sentencia->bindParam(':valor', $valor);
        return $sentencia->execute();
    } 
    //elimina una cuota especifico de la tablafinanciacion    
    public function eliminarCuota($id_financiamiento){
        global $mbd;
        $sentencia = $mbd->prepare("DELETE FROM `sofi_financiamiento` WHERE `id_financiamiento` = :id_financiamiento");
        $sentencia->bindParam(':id_financiamiento', $id_financiamiento);
        return $sentencia->execute();
    }
    //modelo para insertar cuota
    public function guardarCuota($id_matricula, $numero_documento, $numero_cuota, $estado, $valor_cuota, $valor_pagado, $fecha_pago, $plazo_pago){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_financiamiento`(`id_matricula`, `numero_documento`, `numero_cuota`, `estado`, `valor_cuota`, `valor_pagado`, `fecha_pago`, `plazo_pago`) VALUES(:id_matricula, :numero_documento, :numero_cuota, :estado, :valor_cuota, :valor_pagado, :fecha_pago, :plazo_pago)");
        $sentencia->bindParam(":id_matricula", $id_matricula);
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->bindParam(":numero_cuota", $numero_cuota);
        $sentencia->bindParam(":estado", $estado);
        $sentencia->bindParam(":valor_cuota", $valor_cuota);
        $sentencia->bindParam(":valor_pagado", $valor_pagado);
        $sentencia->bindParam(":fecha_pago", $fecha_pago);
        $sentencia->bindParam(":plazo_pago", $plazo_pago);
        return $sentencia->execute();
    } 
    //Vuelve cualquier int en formato de dinero
    public function formatoDinero($valor){
        $moneda = array(2, ',', '.');// Peso colombiano 
        return number_format($valor, $moneda[0], $moneda[1], $moneda[2]);
    }
    //devuelve la diferencia entre 2 fechas el formato %A es para devolver en dias
    public function diferenciaFechas($inicial, $final, $formatoDiferencia='%a'){
        $datetime1 = date_create($inicial);
        $datetime2 = date_create($final);
        $intervalo = date_diff($datetime1, $datetime2);
        return $intervalo->format($formatoDiferencia);
    }
}
?>