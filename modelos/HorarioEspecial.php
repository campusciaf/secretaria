<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class HorarioEspecial
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
	

	//Implementar un método para listar los registros
	public function listar($id_credencial, $ciclo)
	{
		$sql="SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and `ciclo`= :ciclo";
		
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrardatos($id_credencial)
	{
		$sql="SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
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

			//Implementar un método para listar los registros
	public function listarMaterias($id_programa_ac,$semestre)
	{
		$sql="SELECT * FROM materias_ciafi WHERE id_programa_ac= :id_programa_ac and semestre= :semestre";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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
	

	//Implementar un método para mostrar los datos de una materia matriculada
	public function horarioEspecial($nombre)
	{	
		$sql="SELECT * from horario_especial WHERE nombre_materia = :nombre";
			

		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


	
	public function asignar_docente($id_docente_grupo,$dia,$hora,$hasta,$diferencia,$salon,$nombre_materia,$periodo)
	{
		$docente_asignado = 1;
		$sql="INSERT INTO horario_especial (id_docente_grupo,dia,hora,hasta,diferencia,salon,nombre_materia,periodo_hora,docente_asignado)
		VALUES ('$id_docente_grupo','$dia','$hora','$hasta' ,'$diferencia','$salon','$nombre_materia','$periodo','$docente_asignado')";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	
	//Implementar un método para mostrar los datos de una materia matriculada
	public function mostrarmateriasdisponibles($nombre)
	{	
		$sql="SELECT * from docente_grupos INNER JOIN materias_ciafi ON materias_ciafi.id = docente_grupos.id_materia INNER JOIN docente ON docente_grupos.id_docente = docente.id_usuario WHERE materias_ciafi.nombre = :nombre";
			
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}



	//Implementar un método para mostrar los datos de una materia matriculada
	public function nombre_docente($id_docente_grupo)
	{	
		$sql="SELECT * from docente_grupos INNER JOIN docente ON docente.id_usuario = docente_grupos.id_docente INNER JOIN horario_especial ON horario_especial.id_docente_grupo = docente_grupos.id_docente_grupo WHERE `docente_grupos`.`id_docente_grupo` = :id_docente_grupo ";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":ciclo", $ciclo);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementar un método para mostrar los datos de una materia matriculada
	public function mostrarmateriasdisponiblestodos()
	{	
		$sql="SELECT * from docente_grupos INNER JOIN materias_ciafi ON materias_ciafi.id = docente_grupos.id_materia INNER JOIN docente ON docente_grupos.id_docente = docente.id_usuario";
			

		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":nombre", $nombre);
		$consulta->execute();
		// $resultado = $consulta->fetchAll();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementar un método para mostrar el id del calidad
	public function mostrar_docente($id_horas_grupos){

		$sql = "SELECT `horario_especial`.`dia`,`horario_especial`.`hora`,`horario_especial`.`hasta`,`horario_especial`.`salon`,`docente`.`usuario_nombre`,`docente`.`usuario_nombre_2`,`docente`.`usuario_apellido`,`docente`.`usuario_apellido_2` from docente_grupos INNER JOIN docente ON docente.id_usuario = docente_grupos.id_docente INNER JOIN horario_especial ON horario_especial.id_docente_grupo = docente_grupos.id_docente_grupo WHERE `horario_especial`.`id_horas_grupos` = :id_horas_grupos";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_horas_grupos", $id_horas_grupos);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function eliminarDocente($id_horas_grupos){
		$sql_eliminar = "DELETE FROM horario_especial WHERE id_horas_grupos=:id_horas_grupos";
		// echo $sql_eliminar;
		global $mbd;
		$consulta_eliminar = $mbd->prepare($sql_eliminar);
		$consulta_eliminar->execute(array(
			"id_horas_grupos" => $id_horas_grupos));
		return $consulta_eliminar;
	}

	//Implementamos un método para editar los calidad
	public function EditarDocenteCualquiera($dia, $hora, $hasta, $salon,$id_horas_grupos,$id_docente_grupo){

		$sql="UPDATE `horario_especial` SET `dia` = '$dia', `hora` = '$hora', `hasta` = '$hasta', `salon` = '$salon', `id_docente_grupo` = '$id_docente_grupo' WHERE `id_horas_grupos` = $id_horas_grupos";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

	
	
}

?>
