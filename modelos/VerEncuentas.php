<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class VerEncuesta{
    public function listarPeriodos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `periodo` FROM `periodo` WHERE lista_evaluacion_docente='1' ORDER BY `periodo`.`periodo` DESC");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function mostrarEstadoEvalaucion($tipo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `estado` FROM `activar_evaluaciones` WHERE `tipo` = :tipo ");
        $sentencia->bindParam(":tipo", $tipo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function cambiarEstadoEvalaucion($tipo, $estado){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `activar_evaluaciones` SET `estado` = :estado WHERE `tipo` = :tipo ");
        // echo $sentencia;
        $sentencia->bindParam(":tipo", $tipo);
        $sentencia->bindParam(":estado", $estado);
        return $sentencia->execute();
    }
    public function listarDocentes(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `docente` WHERE `usuario_condicion` = 1  ORDER BY `usuario_nombre` ASC");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarGrupos($id_docente, $periodo ){
        global $mbd;
        $tabla = ($periodo>="2022-2")?"docente_grupos":"docente_grupos_2";
        $sentencia = $mbd->prepare("SELECT $tabla.`id_docente_grupo`, $tabla.`ciclo` , $tabla.`id_programa` , $tabla.`jornada` , $tabla.`semestre` , $tabla.`grupo`, $tabla.`id_materia`, $tabla.`id_materia`, `programa_ac`.`nombre` AS `nombre_programa` FROM $tabla INNER JOIN `programa_ac` ON `programa_ac`.`id_programa` = $tabla.`id_programa` WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function materiasPorDocente($id_docente, $periodo ){
        $tabla = ($periodo >= "2022-2") ? "docente_grupos" : "docente_grupos_2";
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS `total` FROM $tabla WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function listarResultados($id_docente_grupo, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(`id_docente_grupos`) AS `cantidad`, SUM(`total`) AS `total`, `id_docente`,      `id_docente_grupos`, (SUM(`total`) / COUNT(`id_docente_grupos`)) AS `promedio` FROM `encuesta_evaluacion` WHERE `id_docente_grupos` = :id_docente_grupo AND `periodo` = :periodo GROUP BY `id_docente`, `id_docente_grupos`;");
        
        $sentencia->bindParam(":id_docente_grupo", $id_docente_grupo);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function docente($id){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT CONCAT(usuario_nombre,' ',usuario_nombre_2,' ',usuario_apellido,' ',usuario_apellido_2) as nombre FROM `docente` WHERE `id_usuario` = $id");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function programa($id){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT nombre FROM `programa_ac` WHERE id_programa = $id");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    
    public function listarComentarios($id_docente, $periodo, $pregunta){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT $pregunta FROM `encuesta_evaluacion` WHERE `id_docente` = :id_docente AND `periodo` = :periodo  And $pregunta <> '0' AND $pregunta <> ''");
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->bindParam(":id_docente",$id_docente);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarRespuestas($id_docente, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS total_respuestas, `id_estudiante`, `id_docente`, `id_docente_grupos`, SUM(p1) AS sum_p1, SUM(p2) AS sum_p2, SUM(p3) AS sum_p3, SUM(p4) AS sum_p4, SUM(p5) AS sum_p5, SUM(p6) AS sum_p6 FROM `encuesta_evaluacion` WHERE `id_docente` = :id_docente AND `periodo` = :periodo GROUP BY `id_estudiante`, `id_docente`, `id_docente_grupos`;");

        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
 
    public function TotalTipo9($id_docente, $periodo, $pregunta, $tipo){
        $si_no = ($tipo == "no")?0:1;
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS total_tipo FROM `encuesta_evaluacion`  WHERE `id_docente` = :id_docente AND `periodo` = :periodo AND `$pregunta` = $si_no");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC)["total_tipo"];
    }
    	//Implementar un método para listar los estudiantes que contestaron
	public function totalestudiantescontestaron($periodo){
		$sql="SELECT DISTINCT id_estudiante FROM encuesta_evaluacion WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
    }
        	//Implementar un método para listar los estudiantes que contestaron
	public function totalestudiantesactivos($periodo){
		$sql="SELECT DISTINCT id_credencial FROM estudiantes_activos WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    public function nombre_materia($id_materia){
        $sql="SELECT id,nombre FROM `materias_ciafi` WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

    }

    public function traernummaterias($ciclo,$nombre_materia,$jornada,$periodo,$semestre,$id_programa,$grupo){

        $tabla="materias".$ciclo;
		$sql = "SELECT COUNT(id_estudiante) AS total_matriculadas FROM `$tabla` WHERE nombre_materia= :nombre_materia and jornada= :jornada and periodo= :periodo and semestre= :semestre and programa= :id_programa and grupo= :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":nombre_materia", $nombre_materia);
		$consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":grupo", $grupo);

		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
	}

}

?>