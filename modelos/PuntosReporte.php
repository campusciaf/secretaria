<?php
session_start();
require "../config/Conexion.php";

class Consulta {

    // Listar puntos de estudiantes
    public function listarPuntosEstudiantes($categoria = '', $fecha_inicio = '', $fecha_fin = '') {
        global $mbd;
        $sql = "SELECT c.credencial_identificacion, c.credencial_nombre, c.credencial_apellido, p.puntos_cantidad, p.punto_fecha, p.punto_nombre FROM puntos p INNER JOIN credencial_estudiante c ON p.id_credencial = c.id_credencial WHERE 1=1";
        if ($categoria != '') {
            $sql .= " AND p.punto_nombre = :categoria";
        }
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $sql .= " AND p.punto_fecha BETWEEN :fecha_inicio AND :fecha_fin";
        }
        $sql .= " ORDER BY p.punto_fecha DESC";
        $stmt = $mbd->prepare($sql);
        if ($categoria != '') {
            $stmt->bindParam(":categoria", $categoria);
        }
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $stmt->bindParam(":fecha_inicio", $fecha_inicio);
            $stmt->bindParam(":fecha_fin", $fecha_fin);
        }
        $stmt->execute();
        return $stmt;
    }

    // Listar puntos de docentes
    public function listarPuntosDocentes($categoria = '', $fecha_inicio = '', $fecha_fin = '') {
        global $mbd;
        $sql = "SELECT d.usuario_identificacion, d.usuario_nombre, d.usuario_apellido, p.puntos_cantidad, p.punto_fecha, p.punto_nombre FROM puntos_docente p INNER JOIN docente d ON p.id_usuario = d.id_usuario WHERE 1=1";
        if ($categoria != '') {
            $sql .= " AND p.punto_nombre = :categoria";
        }
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $sql .= " AND p.punto_fecha BETWEEN :fecha_inicio AND :fecha_fin";
        }
        $sql .= " ORDER BY p.punto_fecha DESC";
        $stmt = $mbd->prepare($sql);
        if ($categoria != '') {
            $stmt->bindParam(":categoria", $categoria);
        }
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $stmt->bindParam(":fecha_inicio", $fecha_inicio);
            $stmt->bindParam(":fecha_fin", $fecha_fin);
        }
        $stmt->execute();
        return $stmt;
    }

    // Listar puntos de colaboradores
    public function listarPuntosColaboradores($categoria = '', $fecha_inicio = '', $fecha_fin = '') {
        global $mbd;
        $sql = "SELECT c.usuario_identificacion, c.usuario_nombre, c.usuario_apellido, p.puntos_cantidad, p.punto_fecha, p.punto_nombre FROM puntos_colaboradores p INNER JOIN usuario c ON p.id_usuario = c.id_usuario WHERE 1=1";
        if ($categoria != '') {
            $sql .= " AND p.punto_nombre = :categoria";
        }
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $sql .= " AND p.punto_fecha BETWEEN :fecha_inicio AND :fecha_fin";
        }
        $sql .= " ORDER BY p.punto_fecha DESC";
        $stmt = $mbd->prepare($sql);
        if ($categoria != '') {
            $stmt->bindParam(":categoria", $categoria);
        }
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $stmt->bindParam(":fecha_inicio", $fecha_inicio);
            $stmt->bindParam(":fecha_fin", $fecha_fin);
        }
        $stmt->execute();
        return $stmt;
    }

    public function fechaesp($date)
    {
        $dia 	= explode("-", $date, 3);
        $year 	= $dia[0];
        $month 	= (string)(int)$dia[1];
        $day 	= (string)(int)$dia[2];

        $dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
        $tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
    }

    
    public function puntos_totales($fecha_inicio = '', $fecha_fin = '')
    {
        global $mbd;
        $sql = "SELECT SUM(`puntos_cantidad`) AS total_puntos FROM `puntos` WHERE 1=1";
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $sql .= " AND `punto_fecha` BETWEEN :fecha_inicio AND :fecha_fin";
        }
        $consulta = $mbd->prepare($sql);
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $consulta->bindParam(":fecha_inicio", $fecha_inicio);
            $consulta->bindParam(":fecha_fin", $fecha_fin);
        }
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado['total_puntos'] ?? 0;
    }

     public function puntos_totales_docente($fecha_inicio = '', $fecha_fin = '')
    {
        global $mbd;
        $sql = "SELECT SUM(`puntos_cantidad`) AS total_puntos FROM `puntos_docente` WHERE 1=1";
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $sql .= " AND `punto_fecha` BETWEEN :fecha_inicio AND :fecha_fin";
        }
        $consulta = $mbd->prepare($sql);
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $consulta->bindParam(":fecha_inicio", $fecha_inicio);
            $consulta->bindParam(":fecha_fin", $fecha_fin);
        }
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado['total_puntos'] ?? 0;
    }

         public function puntos_totales_colaborador($fecha_inicio = '', $fecha_fin = '')
    {
        global $mbd;
        $sql = "SELECT SUM(`puntos_cantidad`) AS total_puntos FROM `puntos_colaboradores` WHERE 1=1";
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $sql .= " AND `punto_fecha` BETWEEN :fecha_inicio AND :fecha_fin";
        }
        $consulta = $mbd->prepare($sql);
        if ($fecha_inicio != '' && $fecha_fin != '') {
            $consulta->bindParam(":fecha_inicio", $fecha_inicio);
            $consulta->bindParam(":fecha_fin", $fecha_fin);
        }
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado['total_puntos'] ?? 0;
    }


}