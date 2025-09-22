<?php
session_start(); 
require "../config/Conexion.php";
class PanelAcademico
{


    public function __construct() {
        
    }

    public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	//Implementar un método para listar los programas en un select
	public function selectPeriodo(){	
		$sql="SELECT * FROM periodo order by id_periodo DESC";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
    
	//Implementar un método para listar los programas en un select
	public function selectPrograma(){	
		$sql="SELECT * FROM programa_ac WHERE estado=1";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar las jornadas
	public function selectJornada(){
		$sql="SELECT * FROM jornada WHERE estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar los periodos académicos
	public function periodo(){
		$sql="SELECT * FROM periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes de la tabla activos sin registros dobles
	public function totalestudiantesactivos($periodo,$nivel,$escuela,$programa,$jornada,$semestre){
		if($nivel==0){$vnivel="";}else{$vnivel="and nivel='$nivel'";}
		if($escuela==0){$vescuela="";}else{$vescuela="and escuela='$escuela'";}
		if($programa==null || $programa==0){$vprograma="";}else{$vprograma="and programa='$programa'";}
		if($jornada =="" || $jornada == "0"){ $vjornada="";}else{$vjornada="and jornada_e='$jornada'";}
		if($semestre==0){$vsemestre="";}else{$vsemestre="and semestre='$semestre'";}

		$sql="SELECT DISTINCT id_credencial FROM estudiantes_activos WHERE periodo= :periodo $vnivel $vescuela $vprograma $vjornada $vsemestre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes de la tabla activos sin registros dobles
	public function estudiantesnuevos($periodo,$nivel,$escuela,$programa,$jornada,$semestre){

		if($nivel==0){$vnivel="";}else{$vnivel="and ciclo='$nivel'";}
		if($escuela==0){$vescuela="";}else{$vescuela="and escuela_ciaf='$escuela'";}
		if($programa==null || $programa==0){$vprograma="";}else{$vprograma="and id_programa_ac='$programa'";}
		if($jornada =="" || $jornada == "0"){ $vjornada="";}else{$vjornada="and jornada_e='$jornada'";}
		if($semestre==0){$vsemestre="";}else{$vsemestre="and semestre_estudiante='$semestre'";}

		$sql="SELECT DISTINCT id_credencial FROM estudiantes WHERE periodo= :periodo and admisiones='si' $vnivel $vescuela $vprograma $vjornada $vsemestre and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar los programas activos
	public function programas($nivel,$escuela,$programa){
		if($nivel==0){$vnivel="";}else{$vnivel="and ciclo='$nivel'";}
		if($escuela==0){$vescuela="";}else{$vescuela="and escuela='$escuela'";}
		if($programa==null || $programa==0){$vprograma="";}else{$vprograma="and id_programa='$programa'";}
		
		$sql="SELECT * FROM programa_ac WHERE panel_academico=1 $vnivel $vescuela $vprograma order by nombre DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para listar los estudiantes de la tabla activos por programa
	public function totalestudiantesactivosprograma($periodo,$programa,$jornada,$semestre){

		if($jornada =="" || $jornada == "0"){ $vjornada="";}else{$vjornada="and jornada_e='$jornada'";}
		if($semestre==0){$vsemestre="";}else{$vsemestre="and semestre='$semestre'";}

		$sql="SELECT DISTINCT id_credencial FROM estudiantes_activos WHERE periodo= :periodo and programa= :programa $vjornada $vsemestre ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes de la tabla activos por programa
	public function totalestudiantesactivospornivel($periodo,$nivel){
		$sql="SELECT DISTINCT id_credencial FROM estudiantes_activos WHERE periodo= :periodo and nivel= :nivel";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":nivel", $nivel);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes activos por nivel
	public function totalestudiantes($periodo,$tabla){
		$sql="SELECT DISTINCT id_estudiante FROM $tabla WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para listar los estudiantes activos en estudiantes activos
		public function totalmatriculaestudiantes($periodo){
			$sql="SELECT id_estudiante FROM estudiantes_activos WHERE periodo= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}


	//Implementar un método para listar los estudiantes de la tabla activos sin registros dobles
	public function totalestudiantesactivos1($periodo){


		$sql="SELECT DISTINCT id_credencial FROM estudiantes_activos WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

          

   
}

?>