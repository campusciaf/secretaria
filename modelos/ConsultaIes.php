<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class ConsultaIes
{
    //Selecciona las IES 
    public function selectIes()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `escuela_jornada` WHERE sede <> 'ciaf'");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }       
    //Trae todos los periodos 
    public function selectPeriodo()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `periodo` ORDER BY `periodo`.`periodo` DESC");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //Trae todos los datos del estudiante a partir de la jornada y periodo   
    public function consultaies($jornada,$periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `ce`.`credencial_nombre`,`ce`.`credencial_nombre_2`,`ce`.`credencial_apellido`,`ce`.`credencial_apellido_2`,`ce`.`credencial_identificacion`, `e`.`jornada_e`,`e`.`periodo`,`e`.`fo_programa`, `e`.`semestre_estudiante`,`e`.`periodo_activo`,`e`.`id_estudiante` FROM `credencial_estudiante` ce INNER JOIN `estudiantes` `e` ON `ce`.`id_credencial`= `e`.`id_credencial` WHERE `e`.`jornada_e` =:jornada AND `e`.`periodo`=:periodo;");
        $sentencia->bindParam(":jornada",$jornada);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
          
    }

   
    public function mostrar($periodo)
	{

		global $mbd;
		$sql = ("SELECT ce.credencial_nombre,ce.credencial_nombre_2,ce.credencial_apellido,ce.credencial_apellido_2,ce.credencial_identificacion,  e.jornada_e,e.periodo,e.fo_programa, e.semestre_estudiante,e.periodo_activo,e.id_estudiante, ej.sede FROM credencial_estudiante ce INNER JOIN estudiantes e ON ce.id_credencial = e.id_credencial INNER JOIN escuela_jornada ej ON e.jornada_e = ej.jornada WHERE e.jornada_e IN (SELECT aj.jornada FROM escuela_jornada aj WHERE aj.sede != 'ciaf' )  AND e.periodo = :periodo");
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
         //echo $sql;
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


    public function consultafaltas($id_estudiante,$periodo_falta){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS cantidad_faltas FROM faltas WHERE id_estudiante=:id_estudiante AND periodo_falta=:periodo_falta;");
        $sentencia->bindParam(":id_estudiante",$id_estudiante);
        $sentencia->bindParam(":periodo_falta",$periodo_falta);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
          
    }
    public function verfaltas($id_estudiante,$periodo_activo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `fecha_falta`, `periodo_falta`, `motivo_falta`,`materia_falta` FROM faltas  WHERE id_estudiante=:id_estudiante AND periodo_falta=:periodo_falta;");
        $sentencia->bindParam(":id_estudiante",$id_estudiante);
        $sentencia->bindParam(":periodo_falta",$periodo_activo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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



}
?>