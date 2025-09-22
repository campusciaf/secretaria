<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class MatriculaMaterias{
	//Implementamos nuestro constructor
	public function __construct(){}
	//Implementamos un método para insertar registros
	public function insertar($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave){
		$sql = "INSERT INTO `credencial_estudiante`(`credencial_nombre`, `credencial_nombre_2`, `credencial_apellido`, `credencial_apellido_2`, `credencial_identificacion`, `credencial_login`, `credencial_clave`) VALUES ('$credencial_nombre', '$credencial_nombre_2', '$credencial_apellido', '$credencial_apellido_2', '$credencial_identificacion', '$credencial_login', '$credencial_clave')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//insertar el nuevo programa
	public function insertarnuevoprograma($id_credencial, $fo_programa, $jornada_e, $escuela_ciaf, $periodo_ingreso, $periodo_activo){
		$sql = "INSERT INTO `estudiantes`(id_credencial, `fo_programa`, `jornada_e`, `escuela_ciaf`, `periodo`, `periodo_activo`) VALUES ('$id_credencial', '$fo_programa', '$jornada_e', '$escuela_ciaf', '$periodo_ingreso', '$periodo_activo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar registros
	public function editar($id, $programa, $nombre, $semestre, $area, $creditos, $codigo, $presenciales, $independiente, $escuela){
		$sql = "UPDATE `materias_ciafi` SET `programa` ='$programa', `nombre` = '$nombre', `semestre` = '$semestre', `area` = '$area', `creditos` = '$creditos', `codigo` = '$codigo', `presenciales` = '$presenciales', `independiente` = '$independiente', `escuela` = '$escuela' WHERE `id` = '$id'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el periodo activo del estudiante
	public function actualizarperiodo($id_estudiante, $periodo_activo){
		$sql = "UPDATE `estudiantes` SET `periodo_activo` = :periodo_activo WHERE `id_estudiante` = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_activo", $periodo_activo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementar un método para listar los registros
	public function verificardocumento($credencial_identificacion){
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `credencial_identificacion` = :credencial_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer el id del estudiante cuando se crea una credencial
	public function traeridcredencial($credencial_identificacion){
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `credencial_identificacion` = :credencial_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listar($id_credencial){
		$sql = "SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listarMaterias($id_programa_ac, $semestre){
		global $mbd;
		$sql = "SELECT * FROM `materias_ciafi` WHERE `id_programa_ac` = :id_programa_ac AND `semestre` = :semestre";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
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
		$sql = "SELECT * FROM `programa_ac` WHERE `nombre` = :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las escuelas
	public function selectJornada(){
		$sql = "SELECT * FROM `jornada`";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las escuelas
	public function selectPrograma(){
		$sql = "SELECT * FROM `programa_ac`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los periodos en un select
	public function selectPeriodo(){
		$sql = "SELECT * FROM `periodo` ORDER BY `id_periodo` DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los grupos en un select
	public function selectGrupo(){
		$sql = "SELECT * FROM `grupo` ORDER BY `grupo` ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa){
		$sql = "SELECT * FROM `programa_ac` WHERE `id_programa` = :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de una materia matriculada
	public function datosMateriaMatriculada($ciclo, $id_estudiante, $materia, $semestre){
		$sql = "SELECT * FROM $ciclo WHERE `id_estudiante` = :id_estudiante AND `nombre_materia` = :materia AND `semestre` = :semestre";
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
	public function datosEstudiante($id_estudiante){
		$sql = "SELECT * FROM `estudiantes` WHERE `id_estudiante` = :id_estudiante";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para buscar los datos de la materia a matricular
	public function MateriaDatos($id){
		$sql = "SELECT * FROM `materias_ciafi` WHERE `id` = :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el nombre del estado
	public function listarEstado($id_estado_academico){
		$sql = "SELECT * FROM `estado_academico` WHERE `id_estado_academico` = :id_estado_academico ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado_academico", $id_estado_academico);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar registros
	public function insertarmateria($id_estudiante, $nombre_materia, $jornada_e, $periodo, $semestre, $creditos, $programa, $ciclo, $fecha, $usuario, $grupo){
		$tabla = "materias" . $ciclo;
		$sql = "INSERT INTO $tabla (id_estudiante, `nombre_materia`, `jornada_e`, `jornada`, `periodo`, `semestre`, `creditos`, `programa`, `fecha`, `usuario`, `grupo`) VALUES ('$id_estudiante', '$nombre_materia', '$jornada_e', '$jornada_e', '$periodo', '$semestre', '$creditos', '$programa', '$fecha', '$usuario', '$grupo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para listar los creditos matriculados
	public function creditosMatriculados($id_estudiante, $ciclo){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT sum(`creditos`) as `suma_creditos` FROM $tabla WHERE `id_estudiante` = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para actualizar el semestre del estudiante
	public function actualizarsemestre($id_estudiante, $semestre_nuevo){
		$sql = "UPDATE `estudiantes` SET `semestre_estudiante` = :semestre_nuevo WHERE `id_estudiante` = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre_nuevo", $semestre_nuevo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementamos un método para ieliminar la materia
	public function eliminarMateria($id_materia_matriculada, $ciclo){
		$tabla = "materias" . $ciclo;
		$sql = "DELETE FROM $tabla WHERE `id_materia` = :id_materia_matriculada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia_matriculada", $id_materia_matriculada);
		return $consulta->execute();
	}
	//Implementamos un método para insertar registros
	public function trazabilidadMateriaEliminada($id_estudiante, $nombre_materia, $jornada_e, $periodo, $semestre, $promedio, $programa, $fecha, $usuario){
		$sql = "INSERT INTO `trazabilidad_materias_eliminadas`(id_estudiante, `nombre_materia`, `jornada_e`, `periodo`, `semestre`, `promedio`, `programa`, `fecha`, `usuario`) VALUES ('$id_estudiante', '$nombre_materia', '$jornada_e', '$periodo', '$semestre', '$promedio', '$programa', '$fecha', '$usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar la jornada de la ateria matriculada
	public function actualizarJornada($id_materia, $jornada, $ciclo){
		$sql = "UPDATE $ciclo SET `jornada` = :jornada WHERE `id_materia` = :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_materia", $id_materia);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el periodo de la materia matriculada
	public function actualizarPeriodoMateria($id_materia, $periodo, $ciclo){
		$sql = "UPDATE $ciclo SET `periodo` = :periodo WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":id_materia", $id_materia);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el grupo de la materia matriculada
	public function actualizarGrupoMateria($id_materia, $grupo, $ciclo){
		$sql = "UPDATE $ciclo SET `grupo` = :grupo WHERE `id_materia` = :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":id_materia", $id_materia);
		return $consulta->execute();
	}
	//lista todas las clases
	public function ListarClasesEscuela($dia, $escuela){
		global $mbd;
		$periodo = $_SESSION["periodo_actual"];
		$sql = "SELECT `dc`.`id_docente_grupo`, `dc`.`id_docente`, `dc`.`hora`, `dc`.`hasta`, `dc`.`salon`, `mc`.`nombre`, `escuelas`.`color`, `d`.`usuario_nombre`, `d`.`usuario_nombre_2`, `d`.`usuario_apellido`, `d`.`usuario_apellido_2` FROM `docente_grupos` AS `dc` INNER JOIN `materias_ciafi` AS `mc` ON `mc`.`id` = `dc`.`id_materia` INNER JOIN `programa_ac` ON `programa_ac`.`id_programa` = `dc`.`id_programa` INNER JOIN `escuelas` ON `escuelas`.`id_escuelas` = `programa_ac`.`escuela` INNER JOIN `docente` AS `d` on `dc`.`id_docente` = `d`.`id_usuario` WHERE `dc`.`dia` LIKE :dia AND `dc`.`periodo` = :periodo AND `escuelas`.`id_escuelas` = :escuela";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//asignar docente a un grupo en especifico
	public function asignarDocenteGrupoEspecial($id_docente_grupo, $id_materia_matriculada, $ciclo_matriculado){
		global $mbd;
		$sql = "UPDATE `$ciclo_matriculado` SET `id_docente_grupo_esp` = :id_docente_grupo, `activar_grupo_esp` = 1 WHERE `id_materia` = :id_materia_matriculada;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":id_materia_matriculada", $id_materia_matriculada);
		return $consulta->execute();
	}
	//asignar docente a un grupo en especifico
	public function CrearHorarioEspecial($id_docente_grupo, $periodo_especial, $ciclo_matriculado, $id_estudiante_especial){
		// Obtener el último carácter de la cadena
		$ciclo_matriculado = substr($ciclo_matriculado, -1);
		global $mbd;
		$sql = "INSERT `horario_especial`(`id_docente_grupo`, `periodo_especial`, `ciclo_matriculado`, `id_estudiante`) VALUES(:id_docente_grupo, :periodo_especial, :ciclo_matriculado, :id_estudiante)";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":periodo_especial", $periodo_especial);
		$consulta->bindParam(":ciclo_matriculado", $ciclo_matriculado);
		$consulta->bindParam(":id_estudiante", $id_estudiante_especial);
		return $consulta->execute();
	}
	//listar docentes por grupos
	public function listarDocentePorGrupo($id_docente_grupo_esp){
		$sql = "SELECT `docente_grupos`.`dia`, `docente_grupos`.`hora`, `docente_grupos`.`hasta`, `docente`.`usuario_nombre`, `docente`.`usuario_nombre_2`, `docente`.`usuario_apellido`, `docente`.`usuario_apellido_2` FROM `docente_grupos` INNER JOIN `docente` ON `docente`.`id_usuario` = `docente_grupos`.`id_docente` WHERE `docente_grupos`.`id_docente_grupo` = $id_docente_grupo_esp";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//elimnar docente grupo a estudiante
	public function limpiarHorarioEspecial($id_materia_matriculada, $ciclo_matriculado){
		global $mbd;
		$sql = "UPDATE `$ciclo_matriculado` SET `id_docente_grupo_esp` = NULL, `activar_grupo_esp` = 0 WHERE `id_materia` = :id_materia_matriculada;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia_matriculada", $id_materia_matriculada);
		return $consulta->execute();
	}
	//elimnar docente grupo a s
	public function eliminarHorarioEspecial($id_docente_grupo, $id_estudiante){
		global $mbd;
		$sql = "DELETE FROM `horario_especial` WHERE `id_estudiante` = :id_estudiante AND `id_docente_grupo` = :id_docente_grupo";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		return $consulta->execute();
	}
	//metodo para consultar las modalidades de la materia
	public function buscarmodalidad($id_materia){
		$sql = "SELECT * FROM `materias_ciafi_modalidad` WHERE `id_materia` = :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para insertar rematriculas
	public function addasignaturamodalidad($id_credencial, $id_estudiante, $id_programa_ac, $id_materia, $id_materias_ciafi_modalidad, $periodo_pecuniario, $fecha, $hora){
		$sql = "INSERT INTO `materias_modalidad`(`id_credencial`, `id_estudiante`, `id_programa`, `id_materia`, `id_materias_ciafi_modalidad`, `periodo`, `fecha`, `hora`) VALUES ('$id_credencial', '$id_estudiante', '$id_programa_ac', '$id_materia', '$id_materias_ciafi_modalidad', '$periodo_pecuniario', '$fecha', '$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute();
		return $resultado;
	}
	//verificar que sea el estudiante
	public function datos_estudiante($id_estudiante){
		$sql = "SELECT * FROM `estudiantes` WHERE  `id_estudiante` = :id_estudiante";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//verificar si tiene matriculada una modalidad
	public function buscarmodalidadmatriculada($id_estudiante, $id_materia, $periodo_actual){
		$sql = "SELECT * FROM `materias_modalidad` WHERE `id_estudiante` = :id_estudiante AND `id_materia` = :id_materia AND `periodo` = :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//traer datos de la modalidad matriculada
	public function datosmodalidadmatriculada($id_materias_ciafi_modalidad){
		$sql = "SELECT * FROM `materias_ciafi_modalidad` WHERE `id_materias_ciafi_modalidad` = :id_materias_ciafi_modalidad";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materias_ciafi_modalidad", $id_materias_ciafi_modalidad);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para eliminar la modalidad
	public function eliminarModalidad($id_materias_modalidad){
		$sql = "DELETE FROM `materias_modalidad` WHERE `id_materias_modalidad` = :id_materias_modalidad";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materias_modalidad", $id_materias_modalidad);
		return $consulta->execute();
	}
	//verificar que sea el estudiante
	public function datos_usuario_ingreso($id_usuario){
		$sql = "SELECT * FROM `usuario` WHERE  `id_usuario` = :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Funcion para mostrar las fechas con letras
	public function fechaesp($date){
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
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