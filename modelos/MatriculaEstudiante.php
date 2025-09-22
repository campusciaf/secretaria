<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class MatriculaEstudiante
{
	//Implementamos nuestro constructor
	public function __construct(){
	}
	//Implementamos un método para insertar registros
	public function insertar($credencial_nombre,$credencial_nombre_2,$credencial_apellido,$credencial_apellido_2,$credencial_identificacion,$credencial_login,$credencial_clave,$credencial_usuario,$credencial_fecha){
		$sql="INSERT INTO credencial_estudiante (credencial_nombre,credencial_nombre_2,credencial_apellido,credencial_apellido_2,credencial_identificacion,credencial_login,credencial_clave,credencial_usuario,credencial_fecha)
		VALUES ('$credencial_nombre','$credencial_nombre_2','$credencial_apellido','$credencial_apellido_2','$credencial_identificacion','$credencial_login','$credencial_clave','$credencial_usuario','$credencial_fecha')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function insertarnuevoprograma($id_credencial,$id_programa_ac,$fo_programa,$jornada_e,$escuela_ciaf,$periodo_ingreso,$ciclo,$periodo_activo,$grupo,$id_usuario_matriculo,$fecha_matricula,$hora_matricula,$admisiones,$pago){
		$sql="INSERT INTO estudiantes (id_credencial,id_programa_ac,fo_programa,jornada_e,escuela_ciaf,periodo,ciclo,periodo_activo,grupo,id_usuario_matriculo,fecha_matricula,hora_matricula,admisiones,pago_renovar)
		VALUES ('$id_credencial','$id_programa_ac','$fo_programa','$jornada_e','$escuela_ciaf','$periodo_ingreso','$ciclo','$periodo_activo','$grupo','$id_usuario_matriculo','$fecha_matricula','$hora_matricula','$admisiones','$pago')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para insertar registros
	public function matriculaprograma($credencial_nombre,$credencial_nombre_2,$credencial_apellido,$credencial_apellido_2,$credencial_identificacion,$credencial_login,$credencial_clave){
		$sql="INSERT INTO estudiantes (credencial_nombre,credencial_nombre_2,credencial_apellido,credencial_apellido_2,credencial_identificacion,credencial_login,credencial_clave)
		VALUES ('$credencial_nombre','$credencial_nombre_2','$credencial_apellido','$credencial_apellido_2','$credencial_identificacion','$credencial_login','$credencial_clave')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}	
	
	//Implementamos un método para insertar registros en la tabla estudiantes datos personales
	public function insertardatosestudiante($id_credencial){
		$fecha_expedicion=NULL;
		$fecha_nacimiento=NULL;
		$sql="INSERT INTO estudiantes_datos_personales (id_credencial,fecha_expedicion,fecha_nacimiento)
		VALUES ('$id_credencial','$fecha_expedicion','$fecha_nacimiento')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
	//Implementamos un método para editar registros
	public function editar($id,$programa,$nombre,$semestre,$area,$creditos,$codigo,$presenciales,$independiente,$escuela){
		$sql="UPDATE materias_ciafi SET programa='$programa', nombre='$nombre', semestre='$semestre', area='$area', creditos='$creditos', codigo='$codigo', presenciales='$presenciales', independiente='$independiente', escuela='$escuela' WHERE id='$id'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();

	}
	//Implementar un método para listar los registros
	public function verificardocumento($credencial_identificacion){
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
	public function traeridcredencial($credencial_identificacion){
		$sql="SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listar($id_credencial){
		$sql="SELECT * FROM estudiantes WHERE id_credencial= :id_credencial";
		
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Cargar los estados académicos
	public function cargarEstadosAcademicos(){
		$sql="SELECT * FROM estado_academico";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Actualizar los estados académicos
	public function cambiarEstado($nuevo_estado,$id_estudiante){
		$sql = "UPDATE estudiantes SET estado=:nuevo_estado WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("nuevo_estado" => $nuevo_estado, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}
	// Registrar los datos del Graduado
	public function registrarGraduado($id_estudiante,$id_credencial,$periodo_grado,$id_programa_ac,$saber_pro,$acta_grado,$folio,$fecha_grado){
		$sql = "INSERT INTO graduados (`id_graduado`, `id_estudiante`, `id_credencial`, `periodo_grado`, `id_programa_ac`, `pruebas_saber_pro`, `acta_grado`, `folio`, `fecha_grado`) 
		VALUES (NULL, '$id_estudiante', '$id_credencial', '$periodo_grado', '$id_programa_ac', '$saber_pro', '$acta_grado', '$folio', '$fecha_grado')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	// Cargar jornadas
	public function cargarJornadas(){
		$sql="SELECT * FROM jornada WHERE estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		// Actualizar la jornada
	public function cambiarJornada($nueva_jornada,$id_estudiante){
		$sql = "UPDATE estudiantes SET jornada_e=:nueva_jornada WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("nueva_jornada" => $nueva_jornada, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}
	
	
	// Cargar los grupos
	public function cargarGrupos(){
		$sql="SELECT * FROM grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Actualizar el grupo
	public function cambiarGrupo($nuevo_grupo,$id_estudiante){
		$sql = "UPDATE estudiantes SET grupo=:nuevo_grupo WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("nuevo_grupo" => $nuevo_grupo, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listarMaterias($original){
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
	public function mostrardatos($id_credencial){
		$sql="SELECT * FROM credencial_estudiante ce  WHERE ce.id_credencial= :id_credencial";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar a que programa pertenece
	public function mostrarescuela($programa){
		$sql="SELECT * FROM programa_ac WHERE nombre= :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_materia){
		$sql="SELECT * FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para listar las escuelas
	public function selectJornada(){	
		$sql="SELECT * FROM jornada";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las escuelas
	public function selectPrograma(){	
		$sql="SELECT * FROM programa_ac WHERE estado_matricula_estudiante='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los grupos en un select
	public function selectGrupo(){	
		$sql="SELECT * FROM grupo ORDER BY grupo ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}


	public function telefono_estudiante($identificacion)
	{	
		$sql="SELECT * FROM on_interesados WHERE identificacion= :identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":identificacion", $identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
?>