<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class HorarioEstudiante
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($credencial_nombre,$credencial_nombre_2,$credencial_apellido,$credencial_apellido_2,$credencial_identificacion,$credencial_login,$credencial_clave)
	{
		$sql="INSERT INTO credencial_estudiante (credencial_nombre,credencial_nombre_2,credencial_apellido,credencial_apellido_2,credencial_identificacion,credencial_login,credencial_clave)
		VALUES ('$credencial_nombre','$credencial_nombre_2','$credencial_apellido','$credencial_apellido_2','$credencial_identificacion','$credencial_login','$credencial_clave')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	


	//Implementar un método para listar los registros
	public function verificardocumento($credencial_identificacion)
	{
		$sql="SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para traer el id del estudiante cuando se crea una credencial
	public function traeridcredencial($credencial_identificacion)
	{
		$sql="SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para listar los registros
	public function listar($id_credencial)
	{
		$sql="SELECT * FROM estudiantes WHERE id_credencial= :id_credencial";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
		//Implementar un método para listar las materias
	public function listarDos($id,$ciclo,$grupo)
	{
		$tabla="materias".$ciclo;
		$sql="SELECT * FROM $tabla WHERE id_estudiante= :id and periodo='".$_SESSION['periodo_actual']."' and grupo= :grupo";
		
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para traer el id de la materia matriculada por el estudiante
	public function buscaridmateria($id_programa_ac,$nombre)
	{
		$sql="SELECT id, modelo FROM materias_ciafi WHERE id_programa_ac= :id_programa_ac and nombre= :nombre";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	

		//Implementar un método para listar los registros
	public function listarMaterias($id_programa_ac,$semestre)
	{
		$sql="SELECT * FROM materias_ciafi WHERE id_programa_ac= :id_programa_ac and semestre= :semestre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
			//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrardatos($id_credencial)
	{
		$sql="SELECT ce.id_credencial, 
					ce.credencial_nombre,  
					ce.credencial_nombre_2, 
					ce.credencial_apellido, 
					ce.credencial_apellido_2, 
					ce.credencial_identificacion,
					ce.credencial_login, 
					edp.id_credencial, 
					edp.celular FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial WHERE ce.id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
			//Implementar un método para mostrar a que programa pertenece
	public function mostrarescuela($programa)
	{
		$sql="SELECT * FROM programa_ac WHERE nombre= :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para mirar el programa
	public function programaacademico($id_programa)
    {
    	$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }



	
		//Implementar un método para listar las escuelas
	public function selectJornada()
	{	
		$sql="SELECT * FROM jornada";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para listar las escuelas
	public function selectPrograma()
	{	
		$sql="SELECT * FROM programa_ac";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
			//Implementar un método para listar los periodos en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo ORDER BY id_periodo DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
			//Implementar un método para listar los grupos en un select
	public function selectGrupo()
	{	
		$sql="SELECT * FROM grupo ORDER BY grupo ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
	//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa)
	{	
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para mostrar los datos de una materia matriculada
	public function datosMateriaMatriculada($ciclo,$id_estudiante,$materia,$semestre)
	{	
		$sql="SELECT * FROM $ciclo WHERE id_estudiante= :id_estudiante and nombre_materia= :materia and semestre= :semestre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":ciclo", $ciclo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para mostrar los datos del programa del estudiante
	public function datosEstudiante($id_estudiante)
	{
		$sql="SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
	//Implementar un método para buscar los datos de la materia a matricular
	public function MateriaDatos($id)
	{
		$sql="SELECT * FROM materias_ciafi WHERE id= :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para traer el nombre del estado
	public function listarEstado($id_estado_academico)
	{
		$sql="SELECT * FROM estado_academico WHERE id_estado_academico= :id_estado_academico ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado_academico", $id_estado_academico);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	

	
			//Implementar un método para listar los creditos matriculados
	public function creditosMatriculados($id_estudiante,$ciclo)
	{
		$tabla="materias".$ciclo;
		$sql="SELECT sum(creditos) as suma_creditos FROM $tabla WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para mirar el docente
	public function docente_grupo($id_materia,$jornada,$periodo,$semestre,$id_programa,$grupo)
    {
    	$sql="SELECT * FROM docente_grupos WHERE id_materia= :id_materia and jornada= :jornada and periodo= :periodo and semestre= :semestre and id_programa= :id_programa and grupo= :grupo"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
			//Implementar un método para mirar datos del docente
	public function docente_datos($id_docente)
    {
    	$sql="SELECT * FROM docente WHERE id_usuario= :id_docente"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
				//Implementar un método para traer la hora de la materia
	public function horas_grupos($id_docente_grupo)
    {
    	$sql="SELECT * FROM horas_grupos WHERE id_docente_grupo= :id_docente_grupo"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	

	public function docente_grupo_horario($id_materia)
	{
		
		$sql = "SELECT * FROM materias9 INNER JOIN horario_especial ON materias9.nombre_materia = horario_especial.nombre_materia INNER JOIN docente_grupos ON `docente_grupos`.`id_docente_grupo` = `horario_especial`.`id_docente_grupo`INNER JOIN docente ON docente_grupos.id_docente = docente.id_usuario WHERE materias9.id_materia = :id_materia";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}



	//Implementar un método para listar las materias
	public function listar_estudiante($id,$ciclo,$grupo)
	{
		$tabla="materias".$ciclo;
		$sql="SELECT * FROM $tabla WHERE id_estudiante= :id and periodo='".$_SESSION['periodo_actual']."' and grupo= :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para mirar el docente
		public function docente_grupo_h($id_materia,$periodo,$id_programa)
		{
			$sql="SELECT * FROM docente_grupos WHERE id_materia= :id_materia and periodo= :periodo and id_programa= :id_programa"; 
			// echo $sql;
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_materia", $id_materia);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->bindParam(":id_programa", $id_programa);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}


		//Implementar un método para traer el id de la materia matriculada por el estudiante
	public function buscaridmateria_h($programa,$nombre_materia)
	{
		$sql="SELECT * FROM materias9 WHERE programa= :programa and nombre_materia= :nombre_materia";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para listar los programas matriculados
		public function listarmatriculados($id_credencial, $periodo_actual){
			$sql = "SELECT * FROM estudiantes WHERE `id_credencial` = :id_credencial AND `periodo_activo` = :periodo_actual";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_credencial", $id_credencial);
			$consulta->bindParam(":periodo_actual", $periodo_actual);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

			//Implementar un método para listar las materias
	public function listar2($id, $ciclo, $grupo){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE `id_estudiante` = :id AND `periodo` = :periodo_actual AND `grupo` = :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":periodo_actual", $_SESSION['periodo_actual']);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mirar el docente
	public function docente_grupo_calendario($id_materia, $jornada, $periodo, $semestre, $id_programa, $grupo){
		$sql = "SELECT * FROM docente_grupos WHERE id_materia= :id_materia and jornada= :jornada and periodo= :periodo and semestre= :semestre and id_programa= :id_programa and grupo= :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

			//Implementar un método para traer el id del programa de la materia
	public function BuscarDatosAsignatura($id_materia){
		$sql = "SELECT id_programa_ac,nombre,semestre FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function docente_grupo_por_id($id_docente_grupo){
		$sql = "SELECT * FROM `docente_grupos` WHERE `id_docente_grupo` = :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



}

?>
