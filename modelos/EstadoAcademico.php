<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class EstadoAcademico
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros
	public function listar($programa,$estado,$periodo_activo)
	{
		$sql="SELECT * FROM estudiantes es INNER JOIN credencial_estudiante ce ON es.id_credencial=ce.id_credencial WHERE 
        (es.fo_programa= :programa and es.estado= :estado and es.periodo_activo= :periodo_activo)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
        $consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo_activo", $periodo_activo);
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
	
		//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_materia)
	{
		$sql="SELECT * FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	

	
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

    		//Implementar un método para listar los estados académicos
	public function selectEstado()
	{	
		$sql="SELECT * FROM estado_academico ORDER BY id_estado_academico DESC";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    //Implementar un método para traer el nombre de los estados
	public function buscarNombreEstado($id_estado_academico)
	{	
		$sql="SELECT * FROM estado_academico WHERE id_estado_academico= :id_estado_academico";

		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estado_academico", $id_estado_academico);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
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

	//Implementamos un método para actualizar el estado a egresado
	public function convertiregresado($id_estudiante)
	{
		$sql="UPDATE estudiantes SET estado='5' WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		
		
	}
	
	
}

?>