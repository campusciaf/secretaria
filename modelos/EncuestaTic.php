<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class EncuestaTic{
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
	
	
	//listar todos periodos
    public function listarPeriodos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `periodo` FROM `periodo` ORDER BY `periodo`.`periodo` DESC");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Función para listar los docentes que se encuentran activos

    public function listarDocentes(){
    	$sql="SELECT * FROM `docente` WHERE `usuario_condicion` = 1"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
    }


    public function DatosDocente($id_docente){
    	$sql="SELECT * FROM `docente` WHERE id_usuario= :id_docente"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    public function listarDocentesContestaron($periodoconsulta){
    	$sql="SELECT DISTINCT id_docente FROM encuesta_tic WHERE periodo= :periodoconsulta"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodoconsulta", $periodoconsulta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
    }

	//Función para cargar la fecha en formato español
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

    	
			//Implementar un método para listar los creditos matriculados
	public function TotalRespuesta($id_docente,$periodoconsulta)
	{

		$sql="SELECT sum(respuesta) as suma_respuesta FROM encuesta_tic WHERE id_docente= :id_docente and periodo= :periodoconsulta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
        $consulta->bindParam(":periodoconsulta", $periodoconsulta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

//Implementar un método para sumar la columna respuestas
	public function TotalGeneralRespuestas($periodoconsulta)
	{

		$sql="SELECT sum(respuesta) as suma_general FROM encuesta_tic WHERE periodo= :periodoconsulta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodoconsulta", $periodoconsulta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function DatosTabla($periodoconsulta){
    	$sql="SELECT id_encuesta_tic FROM encuesta_tic WHERE periodo= :periodoconsulta"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodoconsulta", $periodoconsulta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
    }



}