<?php
session_start(); 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Panel{
	//Implementamos nuestro constructor
	public function __construct(){}
    public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	//Implementar un método para listar los micompromisos
	public function listar(){	
		$sql="SELECT * FROM educacion_continuada WHERE estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para saber si realizo la encuesta
	public function buscarEncuestaEstudiante($id_usuario){
		$sql="SELECT * FROM encuesta_semana_original WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar registros
	public function insertarEncuestaEstudiante($id_usuario ,$identificacion ,$programa ,$jornada ,$fecha ,$hora ,$r1 ,$r2 ,$r3 , $r4){
		$sql="INSERT INTO encuesta_semana_original (id_usuario,identificacion,programa,jornada,fecha,hora,r1,r2,r3,r4)
		VALUES ('$id_usuario','$identificacion','$programa','$jornada','$fecha','$hora','$r1','$r2','$r3','$r4')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
    //Implementar un método para saber si realizo la encuesta
	public function autoevaluacionEstado($id_usuario, $periodo_actual){
		$sql="SELECT * FROM `docente` WHERE `id_usuario` = :id_usuario AND `activar_autoevaluacion` = 0 ORDER BY `usuario_condicion` DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}//Implementar un método para saber si realizo la encuesta
	public function actualizarEstadoAutoevaluacion($id_usuario){
		$sql="UPDATE `docente` SET `activar_autoevaluacion` = '1' WHERE `docente`.`id_usuario` = :id_usuario;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		return $consulta->execute();
	}
    //Implementamos un método para insertar registros
	public function insertarEncuestaDocente($id_usuario, $r1, $r2, $r3, $r4, $r5, $r6, $fecha, $hora, $periodo){
		$sql="INSERT INTO `autoevaluacion_docente`(id_usuario, r1, r2, r3, r4, r5, r6, fecha, hora, periodo) VALUES ('$id_usuario', '$r1', '$r2', '$r3', '$r4', '$r5', '$r6', '$fecha', '$hora', '$periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
    public function consultaDatos($id){
		$sql="SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial = edp.id_credencial INNER JOIN estudiantes est ON ce.id_credencial = est.id_credencial WHERE ce.id_credencial = :id and est.estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id",$id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function alertacalendario(){
        global $mbd;
		$fecha_actual = date('Y-m-d');
        $consulta = $mbd->prepare("SELECT * FROM `calendario` WHERE `fecha_inicio` <= :fecha_actual AND `fecha_final` >= :fecha_actual");
		$consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
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
	public function mostrarMunicipios($id_departamento)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `municipios` WHERE `departamento_id` = :id_departamento");
		$sentencia->bindParam(":id_departamento", $id_departamento);
		$sentencia->execute();
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}


    //Implementar un método para saber si realizo la encuesta
    //public function buscarEncuestaEstudiante($id_usuario){
    //		$sql="SELECT * FROM encuesta_web_referido WHERE id_usuario= :id_usuario";
    //		global $mbd;
    //		$consulta = $mbd->prepare($sql);
    //		$consulta->bindParam(":id_usuario", $id_usuario);
    //		$consulta->execute();
    //		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    //		return $resultado;
    //	}
    //Implementamos un método para insertar registros
    //public function insertarEncuestaEstudiante($id_usuario,$fecha,$hora){
    //		$sql="INSERT INTO encuesta_web_referido (id_usuario,fecha,hora)
    //		VALUES ('$id_usuario','$fecha','$hora')";
    //		global $mbd;
    //		$consulta = $mbd->prepare($sql);
    //		return $consulta->execute();
    //	}
}
?>