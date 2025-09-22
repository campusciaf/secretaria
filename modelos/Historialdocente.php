<?php 
require "../config/Conexion.php";
class Historial{

    public function listarDocente(){	
		global $mbd;
		$sql="SELECT * FROM `docente` ORDER BY `docente`.`usuario_apellido` ASC";
		
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	

    public function listar($id,$tabla){

		$sql = "SELECT COUNT(*) AS total_grupos FROM `$tabla` WHERE `id_docente` = :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
	}

    public function historialAsig($id){

		$sql = "SELECT id_materia, periodo, jornada, grupo,id_programa,ciclo,dia,hora,hasta,diferencia FROM `docente_grupos` WHERE id_docente = :id";
        // echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function historialAsig2($id){

		$sql = "SELECT materia,periodo, jornada, grupo,id_programa,ciclo FROM `docente_grupos_2` WHERE id_docente = :id";
        // echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function nombre_materia_asig($id, $id_programa){
		$sql = "SELECT `mc`.`creditos`, `mc`.`semestre`, `pa`.`nombre` AS `nombre_programa`, `mc`.`nombre` FROM `materias_ciafi` AS `mc` INNER JOIN `programa_ac` AS `pa` ON `pa`.`id_programa` = `mc`.`id_programa_ac` WHERE `mc`.`id` = :id AND `pa`.`id_programa` = :id_programa;";
        // echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		// $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function obtener_datos_materia($nombre_materia, $id_programa){
		$sql = "SELECT `mc`.`creditos`, `pa`.`nombre` FROM `materias_ciafi` AS `mc` INNER JOIN `programa_ac` AS `pa` ON `pa`.`id_programa` = `mc`.`id_programa_ac` WHERE `mc`.`nombre` = :nombre_materia AND `pa`.`id_programa` = :id_programa";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		// $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    
    public function registros($nombre_materia,$semestre,$periodo,$jornada,$grupo,$programa,$ciclo){
        $tabla = "materias".$ciclo;
		$sql = "SELECT COUNT(*) AS total_estudiante_reg1 FROM `$tabla` WHERE `nombre_materia` LIKE :nombre_materia AND `semestre` = :semestre AND periodo = :periodo AND jornada = :jornada AND grupo = :grupo AND programa = :programa";
		// echo $sql;
        global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		// $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function estudiantes_aprobados($nombre_materia,$semestre,$periodo,$jornada,$grupo,$programa,$ciclo){
        $tabla = "materias".$ciclo;

		$sql = "SELECT COUNT(*) AS total_aprobados_reg1, SUM(`$tabla`.`promedio`) AS suma_promedio_aprobados_reg1 FROM `$tabla` WHERE `nombre_materia` LIKE :nombre_materia AND `semestre` = :semestre AND periodo = :periodo AND jornada = :jornada AND grupo = :grupo AND programa = :programa AND `$tabla`.`promedio` >= 3";
		// echo $sql;
        global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		// $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	// AND `periodo` LIKE '2019-2' AND `programa` LIKE '70' AND `jornada` = 'D01'
    public function estudiantes_aprobadosAsig2($nombre_materia,$jornada,$grupo,$programa,$ciclo_asig2,$periodo){
        $tabla = "materias".$ciclo_asig2;
		// SELECT COUNT(*) AS total_estudiantes FROM `materias2` WHERE `nombre_materia` = 'Informatica y herramientas de productividad' AND `jornada` = 'N01' AND `programa` = 70 AND `grupo` = 1 AND `periodo` = '2018-2'
		$sql = "SELECT COUNT(*) AS total_aprobados, SUM(`$tabla`.`promedio`) AS suma_promedio_aprobados FROM `$tabla` WHERE `nombre_materia` LIKE :nombre_materia AND jornada = :jornada AND grupo = :grupo  AND `programa` = :programa AND periodo = :periodo AND `$tabla`.`promedio` >= 3";
		// echo $sql;
        global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function estudiantes_reprobados($nombre_materia,$semestre,$periodo,$jornada,$grupo,$programa,$ciclo){
        $tabla = "materias".$ciclo;

		$sql = "SELECT COUNT(*) AS total_reprobados_reg1, SUM(`$tabla`.`promedio`) AS suma_promedio_reg1 FROM `$tabla` WHERE `nombre_materia` LIKE :nombre_materia AND `semestre` = :semestre AND periodo = :periodo AND jornada = :jornada AND grupo = :grupo AND programa = :programa AND `$tabla`.`promedio` <= 3";
		// echo $sql;
        global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		// $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	// AND `periodo` LIKE '2019-2' AND `programa` LIKE '70' AND `jornada` = 'D01' AND materias2.`promedio` <= 3
	public function estudiantes_reprobadosasig2($nombre_materia,$jornada,$grupo,$ciclo_asig2,$periodo,$programa){
		$tabla = "materias".$ciclo_asig2;
	
		// $periodo_actual = $_SESSION["periodo_actual"];
	
		$sql = "SELECT COUNT(*) AS total_reprobados, SUM(`$tabla`.`promedio`) AS suma_promedio FROM `$tabla` WHERE `nombre_materia` LIKE :nombre_materia AND jornada = :jornada AND grupo = :grupo  AND periodo = :periodo AND `programa` = :programa AND `$tabla`.`promedio` <= 3";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		// $consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		// $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar las materias
	public function listar_materias($ciclo,$materia,$jornada,$id_programa,$periodo,$grupo){

		$tabla = "materias".$ciclo;
		// $periodo_actual = $_SESSION["periodo_actual"];
		// $periodo_anterior = 2022-2;

		$sql = "SELECT COUNT(*) AS total_materias FROM `$tabla` WHERE `nombre_materia` = :materia AND `jornada` = :jornada AND `programa` = :id_programa AND `periodo` = :periodo AND `grupo` = :grupo";

		
        
        
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		// $resultado = $consulta->fetchAll();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	


	// AND `periodo` LIKE '2019-2' AND `programa` LIKE '70' AND `jornada` = 'D01'
	//Implementar un método para listar las materias
	public function en_lista_Asig2($ciclo,$materia,$jornada,$id_programa,$grupo,$periodo){

		$tabla = "materias".$ciclo;
		// $periodo_actual = $_SESSION["periodo_actual"];
		// $periodo_anterior = 2022-2;

		$sql = "SELECT COUNT(*) AS total_estudiantes FROM `$tabla` WHERE `nombre_materia` = :materia AND `jornada` = :jornada AND `programa` = :id_programa AND `grupo` = :grupo AND `periodo` = :periodo";
        // echo $sql;
        
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		// $resultado = $consulta->fetchAll();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar los ingresos e los estudiantes
    public function consulta_por_mes_2($id_usuario, $fecha){

        $sql = "SELECT count(id_usuario) as total_ingreso, `fecha` as fecha FROM `ingresos_campus` WHERE `id_usuario` LIKE :id_usuario AND `fecha` LIKE '%$fecha%' GROUP BY `fecha`";
		
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

	//Implementar un método para listar los ingresos e los estudiantes
    public function consulta_ultimo_ingreso($id_usuario){
		
        $sql = "SELECT MAX(`ingresos_campus`.`fecha`) as ultima FROM `ingresos_campus` INNER JOIN `docente` ON `docente`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE `ingresos_campus`.`id_usuario` LIKE :id_usuario and roll = 'Docente' AND docente.usuario_condicion = 1";
		// echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

	public function fechaesp($date) {
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}


	public function sumarhorasdocentes($id){

		$sql = "SELECT SUM(diferencia) AS suma_diferencia FROM `docente_grupos` WHERE id_docente = :id";
        // echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}



	public function traer_id_docente_historico_contrato($id_usuario){

		$sql = "SELECT * FROM `docente` WHERE `id_usuario` = :id_usuario ";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
	}

	public function historicodoce($documento_docente){

		$sql = "SELECT * FROM `contrato_docente` WHERE documento_docente = :documento_docente";
        // echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function MostrarCargoDocentes($documento_docente, $periodo)
	{
		global $mbd;
		$sql = "SELECT * FROM contrato_docente WHERE documento_docente = :documento_docente AND periodo = :periodo ORDER BY fecha_realizo DESC LIMIT 1";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC); 
		return $resultado;
	}

	public function nombreusuario($id_usuario) {
		$sql = "SELECT * FROM `usuario` WHERE id_usuario = :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function periodoactual()
	{
		$sql = "SELECT periodo_actual FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
	

	
}
?>