<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Consulta
{
    public function consultaGraduados($periodo)
    {
        if ($periodo == "todos") {
            $sql = " SELECT * FROM `estudiantes_antes_2012` INNER JOIN estado_estudiantes_antes_2012 ON estudiantes_antes_2012.identificacion = estado_estudiantes_antes_2012.identificacion  ";
        } else {
            $sql = " SELECT * FROM `estudiantes_antes_2012` INNER JOIN estado_estudiantes_antes_2012 ON estudiantes_antes_2012.identificacion = estado_estudiantes_antes_2012.identificacion WHERE estudiantes_antes_2012.periodo = $periodo ";
        }
        

        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;

    }

    public function convertir_fecha($date) 
    {
        $dia    = explode("-", $date, 3);
        $year   = $dia[0];
        $month  = (string)(int)$dia[1];
        $day    = (string)(int)$dia[2];

        $dias       = array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
        $tomadia    = $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return $day." de ".$meses[$month]." de ".$year;
    }
}


?>