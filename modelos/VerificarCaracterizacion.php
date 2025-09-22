<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class VerificarCaracterizacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_ejes,$periodo,$objetivo)
	{
		$sql="INSERT INTO ejes (nombre_ejes,periodo,objetivo)
		VALUES ('$nombre_ejes','$periodo','$objetivo')";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
		

	}

	//Implementamos un método para editar registros
	public function editar($id_ejes,$nombre_ejes,$periodo,$objetivo)
	{
		$sql="UPDATE ejes SET nombre_ejes='$nombre_ejes',periodo='$periodo',objetivo='$objetivo' WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		return $consulta->execute();

		
		
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_ejes)
	{
		$sql="SELECT * FROM ejes WHERE id_ejes= :id_ejes";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para eliminar los datos de un registro 
	public function eliminar($id_credencial)
	{
		$sql="DELETE FROM caracterizacion_data WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
	
	}

	//Implementar un método para listar los registros
	public function listar()
	{	
		$sql="SELECT * FROM caracterizacion_data cd INNER JOIN credencial_estudiante ce ON cd.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON cd.fecha>='2024-03-01' and edp.id_credencial=cd.id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}	
	
	//Implementar un método para listar los registros
	public function verificarDato($id_credencial)
	{	
		$sql="SELECT * FROM caracterizacion WHERE id_usuario= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;		
	}
	
	
		//Implementar un método para mostrar los datos de un registro a modificar
	public function datosEstudiante($id_credencial)
	{
		$sql="SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		//return ejecutarConsultaSimpleFila($sql);
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
	

}

?>