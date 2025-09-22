<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class VerCaracterizacionDocente
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	public function mostrarreporte(){	
		global $mbd;
		$sql="SELECT * FROM caracterizaciondocente ";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado= $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar el nombre del docente
	public function datos_docente($id_docente){	
		global $mbd;
		$sql="SELECT * FROM docente WHERE id_usuario= :id_docente";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function fechaesp($date)
	{
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}


}

?>