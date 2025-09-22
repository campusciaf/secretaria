<?php
session_start();
require "../config/Conexion.php";

class Consulta {

public function listarCategoriasSinFiltro() {
    global $mbd;
    $sql = "SELECT DISTINCT punto_nombre 
            FROM puntos 
            WHERE punto_nombre IS NOT NULL AND punto_nombre != ''
            ORDER BY punto_nombre ASC";
    $consulta = $mbd->prepare($sql);
    $consulta->execute();
    return $consulta;
}



    public function graficoPuntosPorCategoria($categoria, $fecha_inicio, $fecha_fin)
    {
        global $mbd;
        $sql = "SELECT punto_fecha, SUM(puntos_cantidad) AS total_puntos
                FROM puntos
                WHERE punto_nombre = :cat
                  AND punto_fecha BETWEEN :fecha_inicio AND :fecha_fin
                GROUP BY punto_fecha
                ORDER BY punto_fecha ASC";

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":cat", $categoria);
        $consulta->bindParam(":fecha_inicio", $fecha_inicio);
        $consulta->bindParam(":fecha_fin", $fecha_fin);
        $consulta->execute();
        return $consulta;
    }

    public function graficoPuntos($fecha_inicio, $fecha_fin)
    {
        global $mbd;
        $sql = "SELECT punto_fecha, SUM(puntos_cantidad) AS total_puntos
                FROM puntos
                WHERE punto_fecha BETWEEN :fecha_inicio AND :fecha_fin
                GROUP BY punto_fecha
                ORDER BY punto_fecha ASC";

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicio", $fecha_inicio);
        $consulta->bindParam(":fecha_fin", $fecha_fin);
        $consulta->execute();
        return $consulta;
    }
    public function totalGeneral($fecha_inicio, $fecha_fin)
{
    global $mbd;
    $sql = "SELECT SUM(puntos_cantidad) AS total_gen
            FROM puntos
            WHERE punto_fecha BETWEEN :inicio AND :fin";
    $stmt = $mbd->prepare($sql);
    $stmt->bindParam(":inicio", $fecha_inicio);
    $stmt->bindParam(":fin",   $fecha_fin);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total_gen'] ?? 0;
}

public function obtenerTotalPuntosPorCategoria($categoria, $fecha_inicio, $fecha_fin)
{
    global $mbd;
    $sql = "SELECT COALESCE(SUM(puntos_cantidad), 0) AS total 
            FROM puntos
            WHERE punto_nombre = :nombre
              AND punto_fecha BETWEEN :inicio AND :fin";
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":nombre", $categoria);
    $consulta->bindParam(":inicio", $fecha_inicio);
    $consulta->bindParam(":fin", $fecha_fin);
    $consulta->execute();
    $res = $consulta->fetch(PDO::FETCH_ASSOC);
    return $res['total'];
}

public function listarTodasLasCategorias()
{
    global $mbd;
    $sql = "SELECT DISTINCT punto_nombre 
            FROM puntos
            WHERE punto_nombre IS NOT NULL AND punto_nombre != ''
            ORDER BY punto_nombre ASC";
    $consulta = $mbd->prepare($sql);
    $consulta->execute();
    return $consulta;
}

public function listarPersonasPorCategoria($categoria, $fecha_inicio, $fecha_fin)
{
    global $mbd;

    if ($categoria === '') {
        // Listado general sin filtrar por categoría
        $sql = "SELECT c.credencial_identificacion, 
                       c.credencial_nombre, 
                       c.credencial_nombre_2, 
                       c.credencial_apellido, 
                       c.credencial_apellido_2,
                       p.puntos_cantidad,
                       p.punto_fecha
                FROM puntos p
                INNER JOIN credencial_estudiante c ON p.id_credencial = c.id_credencial
                WHERE p.punto_fecha BETWEEN :inicio AND :fin
                ORDER BY p.punto_fecha DESC";

        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":inicio", $fecha_inicio);
        $stmt->bindParam(":fin", $fecha_fin);
    } else {
        
        $sql = "SELECT c.credencial_identificacion, 
                       c.credencial_nombre, 
                       c.credencial_nombre_2, 
                       c.credencial_apellido, 
                       c.credencial_apellido_2,
                       p.puntos_cantidad,
                       p.punto_fecha
                FROM puntos p
                INNER JOIN credencial_estudiante c ON p.id_credencial = c.id_credencial
                WHERE p.punto_nombre = :categoria
                  AND p.punto_fecha BETWEEN :inicio AND :fin
                ORDER BY p.punto_fecha DESC";

        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->bindParam(":inicio", $fecha_inicio);
        $stmt->bindParam(":fin", $fecha_fin);
    }

    $stmt->execute();
    return $stmt;
}


 public function puntos_totales()
    {
        $sql = "SELECT SUM(`puntos_cantidad`) AS total_puntos FROM `puntos`";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado['total_puntos'] ?? 0;
    }

 
 
public function obtenerTotalesGeneralesPorCategoria()
{
    global $mbd;

    $sql = "SELECT punto_nombre, COALESCE(SUM(puntos_cantidad), 0) AS total
            FROM puntos
            GROUP BY punto_nombre";
    
    $stmt = $mbd->prepare($sql);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resultados);
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
}

