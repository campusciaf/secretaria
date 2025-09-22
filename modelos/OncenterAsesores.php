<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class OncenterAsesores
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
	public function listar($id_usuario,$fecha_desde,$fecha_hasta)
	{
		$sql="SELECT * FROM on_seguimiento os INNER JOIN usuario us ON os.id_usuario= us.id_usuario INNER JOIN on_interesados oni ON os.id_estudiante=oni.id_estudiante WHERE os.id_usuario= :id_usuario and os.fecha_seguimiento >= :fecha_desde and os.fecha_seguimiento <= :fecha_hasta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":fecha_desde", $fecha_desde);
		$consulta->bindParam(":fecha_hasta", $fecha_hasta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
	//Implementar un método para listar los programas en un select
	public function selectAsesor()
	{	
		$sql="SELECT * FROM usuario WHERE asesor=0";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function consultaretiqueta($id_etiqueta)
	{
	  $sql = "SELECT * FROM etiquetas WHERE id_etiquetas= :id_etiqueta ";
	  global $mbd;
	  $consulta = $mbd->prepare($sql);
	  $consulta->bindParam(":id_etiqueta", $id_etiqueta);
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

	//Implementar un método para mostrar los botones que activan las preguntas
	public function datos($fecha_tareas,$motivo)
	{
		$sql="SELECT * FROM on_seguimiento WHERE fecha_seguimiento>= :fecha_tareas AND motivo_seguimiento= :motivo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":fecha_tareas", $fecha_tareas);
		$consulta->bindParam(":motivo", $motivo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function traerEtiquetas()
	{
	  $sql = "SELECT * FROM etiquetas WHERE etiqueta_dependencia='Mercadeo'";
	  global $mbd;
	  $consulta = $mbd->prepare($sql);
	  $consulta->execute();
	  $resultado = $consulta->fetchAll();
	  return $resultado;
	}

	public function traerSeguiEtiquetas($fecha_tareas,$id_etiqueta)
	{
		$sql = "SELECT * FROM on_seguimiento ons INNER JOIN on_interesados oni ON ons.id_estudiante=oni.id_estudiante WHERE ons.fecha_seguimiento>= :fecha_tareas and oni.id_etiqueta= :id_etiqueta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":fecha_tareas", $fecha_tareas);
		$consulta->bindParam(":id_etiqueta", $id_etiqueta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	
}

?>