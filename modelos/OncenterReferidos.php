<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class OncenterReferidos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
		
	public function periodoactual()
    {
    	$sql="SELECT * FROM on_periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	
    	//Implementar un método para mostrar los botones que activan las preguntas
	public function listar($periodo_campana)
	{
		$sql="SELECT * FROM referidos WHERE periodo_campana= :periodo_campana";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_campana", $periodo_campana);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los programas en un select
	public function selectCampana()
	{	
		$sql="SELECT * FROM on_periodo order by periodo DESC";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	public function refierea($id_estudiante)
    {
    	$sql="SELECT * FROM on_interesados WHERE id_estudiante= :id_estudiante"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	public function fechaesp($date) {// convertir la fecha corta en larga
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}

	//Implementar un método para listar los datos referidos
	public function listarDatos($periodo)
	{
		$sql="SELECT * FROM referidos WHERE periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":mensaje_seguimiento", $mensaje_seguimiento);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	
	//Implementar un método para listar lod formualrios validados
	public function listarDatosFecha($periodo,$fecha)
	{
		$sql="SELECT * FROM referidos WHERE periodo_campana= :periodo AND fecha <= :fecha";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":fecha", $fecha);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function calPorcentaje($dato1,$dato2) {// calcula el incremento o decremento de dos variables
		if($dato1 == 0){
			return 0;	
		}else{
			$porcentaje=(($dato1-$dato2)/$dato1)*100;
			return round($porcentaje,2);
		}
	}

		//Implementar un método para listar los datos referidos
		public function listarReferidoEstado($periodo,$estado)
		{
			$sql="SELECT * FROM referidos ref INNER JOIN on_interesados oi ON ref.id_estudiante=oi.id_estudiante WHERE ref.periodo_campana= :periodo and oi.estado= :estado";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			// $consulta->bindParam(":mensaje_seguimiento", $mensaje_seguimiento);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->bindParam(":estado", $estado);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
	

	
}

?>