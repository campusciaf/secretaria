<?php
require "../config/Conexion.php";

Class ConsultaActivosSiguientePeriodo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
	public function periodoactual()
    {
    	$sql="SELECT * FROM periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }


	//Implementar un método para listar los estudiantes nuevos
	public function listarnuevos($periodo)
	{	
		$sql="SELECT * FROM estudiantes WHERE  periodo= :periodo and periodo_activo= :periodo and estado='1' and admisiones='si' and homologado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes nuevos homologados
	public function listarnuevoshomologados($periodo)
	{	
		$sql="SELECT * FROM estudiantes WHERE  periodo= :periodo and periodo_activo= :periodo and estado='1' and admisiones='si' and homologado='0'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para listar los estudiantes nuevos homologados
		public function listarrematriculas($periodo)
		{	
			$sql="SELECT * FROM estudiantes est INNER JOIN programa_ac pac ON est.id_programa_ac=pac.id_programa WHERE  est.periodo!= :periodo and est.periodo_activo= :periodo and est.estado='1' and pac.estado_activos='1'";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

	
	//Implementar un método para listar los interesados
	public function listar($periodo)
	{	
		$sql="SELECT * FROM estudiantes est INNER JOIN programa_ac pac ON est.id_programa_ac=pac.id_programa WHERE  est.periodo_activo= :periodo and est.estado='1' and pac.estado_activos='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los estudiantes nuevos
	public function listarnuevosinterno($periodo)
	{	
		$sql="SELECT * FROM estudiantes est INNER JOIN programa_ac pac ON est.id_programa_ac=pac.id_programa WHERE  est.periodo= :periodo and est.periodo_activo= :periodo and est.estado='1' and est.admisiones='no' and est.homologado='1' and pac.estado_activos='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar todos losprogramas de la plataforma
	public function totalprogramas()
	{
		$sql="SELECT * FROM programa_ac";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para mostrar el id del programa
	public function listarPrograma()
	{
		$sql="SELECT * FROM programa_ac where estado_activos=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para mostrar el id del programa
	public function listarJornada()
	{
		$sql="SELECT * FROM jornada where estado_activos=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar losestudiantes nuevos
    public function listarprogramajornadanuevos($periodo,$jornada,$fo_programa)
    {	
        $sql="SELECT * FROM estudiantes WHERE  periodo= :periodo and periodo_activo= :periodo and jornada_e= :jornada and fo_programa= :fo_programa and homologado='1' and estado='1' and admisiones='si'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los studiantes nuevos homologados
    public function listarprogramajornadanuevoshomologados($periodo,$jornada,$fo_programa)
    {	
        $sql="SELECT * FROM estudiantes WHERE  periodo= :periodo and periodo_activo= :periodo and jornada_e= :jornada and fo_programa= :fo_programa and homologado='0' and estado='1' and admisiones='si'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estuidantes con rematricula
    public function listarprogramajornadarematricula($periodo,$jornada,$fo_programa)
    {	
        $sql="SELECT * FROM estudiantes WHERE periodo!= :periodo and periodo_activo= :periodo and jornada_e= :jornada and fo_programa= :fo_programa and estado='1' and homologado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


    //Implementar un método para listar los estados del proceso
    public function listarprogramajornada($periodo,$jornada,$fo_programa)
    {	
        $sql="SELECT * FROM estudiantes WHERE periodo_activo= :periodo and jornada_e= :jornada and fo_programa= :fo_programa and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar losestudiantes nuevos
    public function listarprogramajornadanuevosinterno($periodo,$jornada,$fo_programa)
    {	
		$sql="SELECT * FROM estudiantes WHERE periodo= :periodo and periodo_activo= :periodo and jornada_e= :jornada and fo_programa= :fo_programa  and estado='1' and admisiones='no' and homologado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	

	public function datoscredencialestudiante($id_credencial)
    {
    	$sql="SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial WHERE ce.id_credencial= :id_credencial"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }


		//Implementar un método para sumar los estudiantes nuevos por jornada
		public function sumaporjornadanuevos($jornada,$periodo)
		{	
			$sql="SELECT * FROM estudiantes WHERE periodo= :periodo and jornada_e= :jornada and periodo_activo= :periodo and estado='1' and admisiones='si' and homologado='1' ";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para sumar los estudiantes nuevos homnologados por jornada
		public function sumaporjornadanuevoshomologados($jornada,$periodo)
		{	
			$sql="SELECT * FROM estudiantes WHERE periodo= :periodo and jornada_e= :jornada and periodo_activo= :periodo and estado='1' and admisiones='si' and homologado='0'";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para sumar los estudiantes nuevos y homologados por jornada
		public function sumaporjornadarematricula($jornada,$periodo)
		{	
			$sql="SELECT * FROM estudiantes est INNER JOIN programa_ac pac ON est.id_programa_ac=pac.id_programa WHERE est.periodo!= :periodo and est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='1' and est.homologado='1' and pac.estado_activos='1'";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		

	
	//Implementar un método para sumar los datos por jornada
	public function sumaporjornada($jornada,$periodo)
	{	
		$sql="SELECT * FROM estudiantes WHERE jornada_e= :jornada and periodo_activo= :periodo and estado='1' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para sumar los estudiantes nuevos por jornada
	public function sumaporjornadanuevosinterno($jornada,$periodo)
	{	
		$sql="SELECT * FROM estudiantes est INNER JOIN programa_ac pac ON est.id_programa_ac=pac.id_programa WHERE est.periodo= :periodo and est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='1'  and est.admisiones='no' and est.homologado='1' and pac.estado_activos='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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
	
		//Implementar un método para listar los departamentos en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo order by id_periodo DESC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para cambiar de estado al programa
	public function cambioestado($id_programa,$estado)
	{
		$sql="UPDATE programa_ac SET estado_activos= :estado WHERE id_programa= :id_programa";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":estado", $estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	
}

?>