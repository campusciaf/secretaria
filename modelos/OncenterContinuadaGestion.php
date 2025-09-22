<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class OncenterContinuadaGestion
{

    public function periodoactual()
    {
    	$sql="SELECT * FROM periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    	//Implementar un método para mostrar todos losprogramas de la plataforma
	public function totalEstudiantes($periodo_ingreso)
	{
		$sql="SELECT * FROM educacion_continuada_interesados WHERE periodo_ingreso= :periodo_ingreso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_ingreso", $periodo_ingreso);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function datoscurso($id_curso)
    {
    	$sql="SELECT * FROM web_educacion_continuada WHERE id_curso= :id_curso"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_curso", $id_curso);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	
	public function fechaesp($date) {
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
		
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		
		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}
	
	
}




?>