<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiRecaudoDia
{
    //Función para listar los pagos
    public function listarPagosPorDia($inicio, $fin)
    {
        $sql = "SELECT `shp`.*, `sm`.*, `sp`.`tipo_documento`, `sp`.`numero_documento` FROM (`sofi_historial_pagos` `shp` INNER JOIN `sofi_matricula` `sm` ON `shp`.`consecutivo` = `sm`.`id`) INNER JOIN `sofi_persona` `sp` ON `sp`.`id_persona` = `sm`.`id_persona` WHERE `shp`.`fecha_pagada` BETWEEN :inicio AND :fin";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":inicio", $inicio);
        $consulta->bindParam(":fin", $fin);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
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
    public function valorrecaudo($inicio, $fin)
    {
        // Consulta para sumar la columna 'valor_pagado' en el rango de fechas
        $sql = "SELECT SUM(valor_pagado) AS total_pagado FROM `sofi_historial_pagos` WHERE `fecha_pagada` BETWEEN :inicio AND :fin";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":inicio", $inicio);
        $consulta->bindParam(":fin", $fin);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC); // Usamos fetch para obtener un único resultado
        return $resultado;
    }
    public function asesordatos($id_asesor)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario = :id_asesor";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_asesor", $id_asesor);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC); // Usamos fetch para obtener un único resultado
        return $resultado;
    }
}
