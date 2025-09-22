<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class HorarioDocente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	//Implementar un método para listar las horas del dia
	public function TraerHorariocalendario($id_docente,$periodo)
	{
		$sql="SELECT * FROM docente_grupos WHERE id_docente= :id_docente and periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el id del programa de la materia
	public function BuscarDatosAsignatura($id_materia)
	{
		$sql="SELECT id_programa_ac,programa,nombre,semestre FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar los docentes activos
	public function datosDocente($id_usuario)
	{	
		$sql="SELECT * FROM docente WHERE id_usuario= :id_usuario";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar los programas en un select
	public function selectDocente()
	{	
		$sql="SELECT id_usuario,usuario_nombre,usuario_nombre_2,usuario_apellido,usuario_apellido_2 FROM docente WHERE usuario_condicion=1";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
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
	
		//Implementar un método para listar las materias
		public function buscarNumEstudiantes($ciclo, $materia, $jornada, $id_programa, $grupo,$periodo)
		{
	
			$tabla = "materias" . $ciclo;
	
			$sql = "SELECT * FROM $tabla WHERE `nombre_materia` = :materia AND `jornada` = :jornada AND `programa` = :id_programa AND `periodo` = :periodo AND `grupo` = :grupo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":materia", $materia);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":id_programa", $id_programa);
			$consulta->bindParam(":grupo", $grupo);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}



}

?>