<?php
require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");
session_start();
class ReservaGeneral
{





    public function consultarSalonesPorsede($sede)
    {
        global $mbd;
        $sql = "SELECT * FROM `salones` WHERE `sede`= :sede ORDER BY `salones`.`codigo` ASC";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":sede", $sede);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function HistorialReservas($periodo)
    {
        global $mbd;
        $consulta = "SELECT * FROM `reservas_salones` WHERE periodo= :periodo";
        $stmt = $mbd->prepare($consulta);
        // $stmt->bindParam(":docente", $id_docente);
        $stmt->bindParam(":periodo", $periodo);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function periodoactual()
    {
        $sql = "SELECT * FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function convertir_fecha_completa($date)
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


    public function consultar_reserva_por_id($id)
    {
        $sql = "SELECT reservas_salones.*, salones.estado_formulario FROM reservas_salones INNER JOIN salones ON reservas_salones.salon = salones.codigo WHERE reservas_salones.id = :id LIMIT 1";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado ?: null;
    }
}
