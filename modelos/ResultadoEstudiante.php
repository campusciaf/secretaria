<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ResultadoEstudiante
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}





	//Implementar un método para listar los registros
	public function listar($periodo_ingreso)
	{	
		$sql="SELECT * FROM caracterizacion_data cd INNER JOIN credencial_estudiante ce ON cd.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=cd.id_credencial INNER JOIN estudiantes est ON est.id_credencial=cd.id_credencial WHERE est.periodo='$periodo_ingreso' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}	
	
	
			//Implementar un método para mostrar los datos de un registro a modificar
	public function datosCategoria()
	{
		$sql="SELECT * FROM categoria";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para mostrar los datos de un registro a modificar
	public function datosVariablesContestadas($id_credencial,$id_categoria)
	{
		$sql="SELECT * FROM caracterizacion WHERE id_usuario= :id_credencial and id_categoria= :id_categoria";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para mostrar los datos de un registro a modificar
	public function datosVariables($id_variable)
	{
		$sql="SELECT * FROM variables WHERE id_variable= :id_variable";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
			//Implementar un método para mostrar los datos de un registro a modificar
	public function respuesta($respuesta)
	{
		$sql="SELECT * FROM variables_opciones WHERE id_variables_opciones= :respuesta";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
	//Implementar un método para listar los registros
	public function listardatos($id_credencial)
	{	
		$sql="SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial WHERE ce.id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
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

	//Implementar un método para listar los dias en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo order by periodo DESC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

}

?>