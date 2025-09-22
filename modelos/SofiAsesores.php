<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class SofiAsesores
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
	
	
    	//Implementar un método para mostrar los botones que activan las preguntas
	public function listar($id_usuario,$fecha_desde,$fecha_hasta)
	{
		$sql="SELECT * FROM sofi_seguimientos sof INNER JOIN usuario us ON sof.id_asesor= us.id_usuario INNER JOIN sofi_matricula sofma ON sofma.id_persona=sof.id_persona WHERE sof.id_asesor= :id_usuario and DATE(sof.created_at) >= :fecha_desde and DATE(sof.created_at) <= :fecha_hasta";
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
		$sql="SELECT * FROM usuario WHERE asesor_cartera=0";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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
	

	public function datosEstudiante($id_credencial)
	{
	  $sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial ";
	  global $mbd;
	  $consulta = $mbd->prepare($sql);
	  $consulta->bindParam(":id_credencial", $id_credencial);
	  $consulta->execute();
	  $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
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


	public function datos($fecha_tareas,$motivo)
	{
		$sql="SELECT * FROM  sofi_seguimientos WHERE DATE(created_at)>= :fecha_tareas AND seg_tipo= :motivo";
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
	  $sql = "SELECT * FROM etiquetas WHERE etiqueta_dependencia='Financiera'";
	  global $mbd;
	  $consulta = $mbd->prepare($sql);
	  $consulta->execute();
	  $resultado = $consulta->fetchAll();
	  return $resultado;
	}

	public function traerSeguiEtiquetas($fecha_tareas,$id_etiqueta)
	{
		$sql = "SELECT * FROM sofi_seguimientos sofs INNER JOIN sofi_matricula sofm ON sofs.id_persona=sofm.id_persona WHERE sofs.created_at>= :fecha_tareas and sofm.id_etiqueta= :id_etiqueta";
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