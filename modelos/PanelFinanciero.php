<?php
session_start(); 
require "../config/Conexion.php";
class PanelFinanciero
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

	public function periodoanterior($id_periodo){
    	$sql="SELECT * FROM periodo WHERE id_periodo= :id_periodo"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_periodo", $id_periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	

	//Implementar un método para listar los programas en un select
	public function selectPeriodo(){	
		$sql="SELECT * FROM periodo order by id_periodo DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los programas en un select
	public function selectPeriodoid($periodo){	
		$sql="SELECT * FROM periodo WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    
	//Implementar un método para listar los programas en un select
	public function selectPrograma($escuela,$nivel){

		$sql="SELECT * FROM programa_ac WHERE estado=1 AND ciclo !='4' AND ciclo !='6' AND ciclo !='9' $escuela $nivel";	
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

	//Implementar un método para listar los creditos 

	public function total($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM creditos_control WHERE periodo= :periodo  $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los creditos finalizados
	public function finalizados($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `creditos_control` WHERE `periodo`= :periodo and `credito_finalizado`=1 $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los creditos finalizados
	public function activos($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `creditos_control` WHERE `periodo`= :periodo and `credito_finalizado`=0 $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los creditos finalizados
	public function activosaldia($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `creditos_control` WHERE `periodo`= :periodo and `credito_finalizado`=0 and `estado`='Al día'  $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los creditos finalizados
	public function activosatrasados($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `creditos_control` WHERE `periodo`= :periodo and `credito_finalizado`=0 and `estado`='Atrasado'  $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}




























	//Implementar un método para encontrar la sede o el convenio
	public function buscarconvenio($jornada){	
		$sql="SELECT * FROM escuela_jornada WHERE jornada= :jornada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que terminaron el programa terminal como ciclo3 y 7
	public function terminaronnivel($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo and nivel NOT IN (4, 6, 8, 9) and `graduado`=0 $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que terminaron el programa terminal como ciclo3 y 7
	public function terminaronterminal($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo and (`nivel` LIKE '%3%' OR `nivel` LIKE '%7%') and `graduado`=0 $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes profesionales
	public function soloprofesionales($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo AND `nivel` IN (1, 2, 3, 5) $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes labroales

	public function sololaborales($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo AND `nivel`=7 $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes labroales

	public function debenrenovar($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo  AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar por convenios

	public function porconvenios($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo and nivel NOT IN (4, 6, 8, 9) $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes nuevos
	public function nuevos($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo and nivel NOT IN (4, 6, 8, 9) AND `estado_matricula` LIKE 'Nuevo' AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes homologados
	public function homologados($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Homologado' $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes internos
	public function internos($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Interno' $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes internos
	public function rematricula($periodo,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE `periodo`= :periodo AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Rematricula' $escuela $nivel $jornada $semestre $programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que no renovaron
	public function norenovo($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `renovo_financiera`=1 $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que no renovaron con homologacion
	public function norenovohomo($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Homologado' and `renovo_financiera`=1 $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que no renovaron interno
	public function norenovointerno($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Interno' AND `renovo_financiera`=1 $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que no renovaron rematricula
	public function norenovorema($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Rematricula' AND `renovo_financiera`=1 $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar los estudiantes que no renovaron nuevos
	public function norenovonuevo($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Nuevo' AND `renovo_financiera`=1 $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que si renovaron
	public function sirenovo($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND (`renovo_financiera` IN (2,3)) $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que si renovaron con homologacion
	public function sirenovohomo($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Homologado' AND (`renovo_financiera` IN (2,3)) $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que si renovaron interno
	public function sirenovointerno($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Interno' AND (`renovo_financiera` IN (2,3)) $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que si renovaron remarticula
	public function sirenovorema($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Rematricula' AND (`renovo_financiera` IN (2,3)) $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	

	
	//Implementar un método para listar los estudiantes que si renovaron remarticula
	public function sirenovonuevo($periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) and `estado_matricula`='Nuevo' AND (`renovo_financiera` IN (2,3)) $escuela $nivel $jornada $semestre $programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


		//Implementar un método para listar los estudiantes que si renovaron remarticula
		public function activospornivel($periodo,$periodoantes,$escuela,$nivel,$jornada,$semestre,$programa){

			$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND `semestre` = 1 AND `nivel` = 1 $escuela $nivel $jornada $semestre $programa AND `id_credencial` IN ( SELECT `id_credencial`  FROM `estudiantes_activos`  WHERE `periodo`= :periodo)";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->bindParam(":periodoantes", $periodoantes);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}






	




          

   
}

?>