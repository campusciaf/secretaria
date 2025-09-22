<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class EstadoEgresado
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function datosPrograma($programa)
	{
		$sql="SELECT * FROM programa_ac WHERE nombre= :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementar un método para listar los registros
	public function listar($programa,$periodo,$semestre)
	{
		$sql="SELECT * FROM estudiantes es INNER JOIN credencial_estudiante ce ON es.id_credencial=ce.id_credencial WHERE (es.fo_programa= :programa and es.periodo= :periodo and es.semestre_estudiante= :semestre and es.estado=1) or (es.fo_programa= :programa and es.periodo= :periodo and es.semestre_estudiante= :semestre and es.estado=5)";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para listar los registros
	public function listarMaterias($original)
	{
		$sql="SELECT * FROM materias_ciafi WHERE programa= :original";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":original", $original);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para listar la cantidad de asignaturas aprobadas
	public function buscarMaterias($id_estudiante,$ciclo){
		$tabla="materias".$ciclo;
		$sql="SELECT * FROM $tabla WHERE id_estudiante= :id_estudiante and promedio >= 3";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para actualizar el estado del estudiante
	public function actualizarEstado($id_estudiante,$estado)
	{
		$sql="UPDATE estudiantes SET estado= :estado WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":estado", $estado);
		$consulta->execute();
		
		
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	// public function mostrar($id_materia)
	// {
	// 	$sql="SELECT * FROM materias_ciafi WHERE id= :id_materia";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":id_materia", $id_materia);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
	// 	return $resultado;
	// }
	
	//Implementar un método para listar las escuelas
	public function selectPrograma()
	{	
		$sql="SELECT * FROM programa_ac";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar las escuelas
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo ORDER BY id_periodo DESC";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
	
	
	
}

?>