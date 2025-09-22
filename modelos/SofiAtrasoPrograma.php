<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
// session_start();
date_default_timezone_set('America/Bogota');
class SofiAtrasoPrograma
{
    //lista todos los financiados
    public function selectProgramas()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT DISTINCT(`programa`) FROM `sofi_matricula` ORDER BY `sofi_matricula`.`programa` ASC");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function listarAtrasados($programa)
    {
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT ROUND(SUM(`sf`.`valor_cuota`) - SUM(`sf`.`valor_pagado`), 2) AS `total_deuda`, `sp`.`nombres`, `sf`.`plazo_pago`, `sp`.`numero_documento`, `sp`.`labora`, `sp`.`id_persona`, `sp`.`apellidos`, `sp`.`celular`, `sm`.`programa`, `sm`.`estado_ciafi`, `sm`.`jornada`, `sm`.`semestre`, `sm`.`id` AS consecutivo, `sf`.`valor_cuota`, `sf`.`fecha_pago`, `sm`.`en_cobro`, `sp`.`periodo`, `sp`.`email`, `ce`.`id_credencial` FROM `sofi_persona` sp INNER JOIN `sofi_matricula` sm ON `sp`.`id_persona` = `sm`.`id_persona` INNER JOIN `sofi_financiamiento` sf ON `sf`.`id_matricula` = `sm`.`id` LEFT JOIN `credencial_estudiante` ce ON `sp`.`numero_documento` = `ce`.`credencial_identificacion` WHERE `sf`.`plazo_pago` < DATE(:fecha) AND (`sf`.`estado` = 'A Pagar' OR `sf`.`estado` = 'Abonado') AND `sm`.`estado_financiacion` = 1 AND `sp`.`estado` <> 'Anulado' AND `sm`.`programa` = :programa GROUP BY `sm`.`id`, `sp`.`nombres`, `sf`.`plazo_pago`, `sp`.`numero_documento`, `sp`.`labora`, `sp`.`id_persona`, `sp`.`apellidos`, `sp`.`celular`, `sm`.`programa`, `sm`.`estado_ciafi`, `sm`.`jornada`, `sm`.`semestre`, `sf`.`valor_cuota`, `sf`.`fecha_pago`, `sm`.`en_cobro`, `sp`.`periodo`, `sp`.`email`, `ce`.`id_credencial`;");
        $sentencia->bindParam(":fecha", $hoy);
        $sentencia->bindParam(":programa", $programa);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    //lista todos los financiados
    public function cantCuotasAtrasado($consecutivo)
    {
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT COUNT(`sofi_financiamiento`.`id_financiamiento`) as num_cuotas, SUM(`sofi_financiamiento`.`valor_cuota`) as total, SUM(`sofi_financiamiento`.`valor_pagado`) as pagado FROM (`sofi_persona` INNER JOIN `sofi_matricula` ON `sofi_persona`.`id_persona` = `sofi_matricula`.`id_persona` INNER JOIN `sofi_financiamiento` ON `sofi_financiamiento`.`id_matricula` = `sofi_matricula`.`id`) WHERE `sofi_financiamiento`.`plazo_pago` < DATE(:fecha) AND (`sofi_financiamiento`.`estado` = 'A Pagar' OR `sofi_financiamiento`.`estado` = 'Abonado') AND `sofi_matricula`.`estado_financiacion` = 1 AND `sofi_matricula`.`id` = :consecutivo AND `sofi_persona`.`estado` <> 'Anulado'");
        $sentencia->bindParam(":fecha", $hoy);
        $sentencia->bindParam(":consecutivo", $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico
    public function verInfoSolicitante($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_persona` WHERE id_persona = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico
    public function verRefeSolicitante($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_referencias` WHERE idpersona = :id_persona ORDER BY `sofi_referencias`.`idrefencia` ASC");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
    //Muestra las tareas que el estudiante tiene registrada 
    public function verSeguimientos($id_credencial)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sofi_seguimientos`.*, `usuario`.`usuario_nombre`,  `usuario`.`usuario_nombre_2`, `usuario`.`usuario_apellido`, `usuario`.`usuario_apellido_2` FROM `usuario` INNER JOIN `sofi_seguimientos` on `sofi_seguimientos`.`id_asesor` = `usuario`.`id_usuario` WHERE `sofi_seguimientos`.`id_credencial` = :id_credencial");
        $sentencia->bindParam(':id_credencial', $id_credencial);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //hace la insercion de la tarea para  los fiananciados
    // public function insertarTarea($id_persona, $id_usuario, $tarea_motivo, $tarea_observacion, $tarea_fecha, $tarea_hora)
    // {
    //     global $mbd;
    //     $sentencia = $mbd->prepare("INSERT INTO `sofi_tareas`(`id_persona`, `id_asesor`, `tarea_motivo`, `tarea_observacion`, `tarea_fecha`, `tarea_hora`) VALUES (:id_persona, :id_usuario, :tarea_motivo, :tarea_observacion, :tarea_fecha, :tarea_hora)");

    //     // Asegúrate de que los nombres de placeholders y variables coincidan

    //     $sentencia->bindParam(':id_persona', $id_persona);
    //     $sentencia->bindParam(':id_usuario', $id_usuario);
    //     $sentencia->bindParam(':tarea_motivo', $tarea_motivo);
    //     $sentencia->bindParam(':tarea_observacion', $tarea_observacion);
    //     $sentencia->bindParam(':tarea_fecha', $tarea_fecha);
    //     $sentencia->bindParam(':tarea_hora', $tarea_hora);
    //     return $sentencia->execute();
    // }



    public function insertarTarea($id_persona, $id_asesor, $tarea_motivo, $tarea_observacion, $tarea_fecha, $tarea_hora)
    {
        $sql = "INSERT INTO sofi_tareas (id_persona,id_asesor,tarea_motivo,tarea_observacion,tarea_fecha,tarea_hora)
		VALUES ('$id_persona','$id_asesor','$tarea_motivo','$tarea_observacion','$tarea_fecha','$tarea_hora')";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }

    public function insertarSeguimiento($descripcion, $tipo, $id_asesor, $id_persona, $id_credencial)
    {
        $sql = "INSERT INTO sofi_seguimientos (`seg_descripcion`, `seg_tipo`, `id_asesor`, `id_persona`, `id_credencial`)
		VALUES ('$descripcion','$tipo','$id_asesor','$id_persona', '$id_credencial')";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
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

    //traer el numero de whatsapp estudiantes
    public function traerCelularEstudiante($numero_documento){
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    
    public function obtenerRegistroWhastapp($numero_celular){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `whatsapp_registros` WHERE `numero_whatsapp` LIKE :numero_celular ORDER BY `numero_whatsapp` ASC");
        $sentencia->bindParam(':numero_celular', $numero_celular);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }



}
