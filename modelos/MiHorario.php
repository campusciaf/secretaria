<?php
// Iniciamos session
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class MiHorario{
	//Implementamos nuestro constructor
	public function __construct(){}
	//Implementar un método para mirar el periodo actual
	public function periodoactual(){
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
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
	public function listar($id, $ciclo, $grupo){
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
	//Implementar un método para mirar el programa
	public function programaacademico($id_programa){
		$sql = "SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el id de la materia matriculada por el estudiante
	public function buscaridmateria($id_programa_ac, $nombre){
		$sql = "SELECT id FROM materias_ciafi WHERE id_programa_ac= :id_programa_ac and nombre= :nombre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar el docente
	public function docente_grupo($id_materia, $jornada, $periodo, $semestre, $id_programa, $grupo){
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
	//Implementar un método para trer los horarios de clases
	public function docente_grupo_clases($id_materia, $jornada, $periodo, $semestre, $id_programa, $grupo){
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
	//Implementar un método para mirar datos del docente
	public function docente_datos($id_docente){
		$sql = "SELECT * FROM docente WHERE id_usuario= :id_docente";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar si el docente tiene PEA
	public function docente_pea($id_docente_grupo){
		$sql = "SELECT * FROM pea_docentes WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para asigar el id a la materia del estudiante
	public function asignar_pea_docente($ciclo, $numero_id_pea_encontrado, $id_estudiante_materia){
		$tabla = "materias" . $ciclo;
		$sql = "UPDATE $tabla SET id_pea= :numero_id_pea_encontrado WHERE id_materia= :id_estudiante_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":numero_id_pea_encontrado", $numero_id_pea_encontrado);
		$consulta->bindParam(":id_estudiante_materia", $id_estudiante_materia);
		return $consulta->execute();
	}
	//Implementar un método para listar el contenido del PEA
	public function listar_pea($id_docente_grupo, $periodo_atual){
		$sql = "SELECT * FROM pea_docentes WHERE id_docente_grupo= :id_docente_grupo and periodo_pea= :periodo_atual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":periodo_atual", $periodo_atual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar el contenido del PEA
	public function listar_temas($id_pea){
		$sql = "SELECT * FROM pea_temas WHERE id_pea= :id_pea ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las actividades
	public function listar_actividades($id_tema, $id_docente_grupo){
		$sql = "SELECT * FROM pea_actividades WHERE id_tema= :id_tema and id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las actividades
	public function tipoarchivo($id_tipo_archivo){
		$sql = "SELECT * FROM tipo_archivo WHERE id_tipo_archivo= :id_tipo_archivo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tipo_archivo", $id_tipo_archivo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para hacer conversion de fecha
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
	//Implementar un método para listar las horas de la noche
	public function listarHorasDia(){
		$sql = "SELECT * FROM horas_del_dia"; // mayor a 48, para que coja la jornada de la noche
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las materias
	public function materiasMatriculadas($id, $ciclo, $grupo){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id and periodo='" . $_SESSION['periodo_actual'] . "' and grupo= :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer los datos de la tabla docente grupos
	public function datosdocentegrupo($id_docente_grupo, $periodo_actual){
		$sql = "SELECT * FROM docente_grupos WHERE id_docente_grupo= :id_docente_grupo and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de la materia
	public function datosmateria($id_materia){
		$sql = "SELECT * FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para taer los datos del PEA
	public function datospea($id_pea){
		$sql = "SELECT * FROM pea WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos del programa
	public function datosescuela($id_escuela){
		$sql = "SELECT * FROM escuelas WHERE id_escuelas= :id_escuela";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_escuela", $id_escuela);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de la materia prerequisot
	public function datosmateriapre($prerequisito){
		$sql = "SELECT nombre FROM materias_ciafi WHERE id= :prerequisito";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar las referencias del PEA
	public function verPeaReferencia($id_pea){
		$sql = "SELECT * FROM pea_referencia WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para ver las carpetas
	public function verCarpetas($id_pea_docentes){
		$sql = "SELECT * FROM pea_documento_carpeta WHERE id_pea_docentes= :id_pea_docentes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los documentos de los PEA
	public function verPeaDocumentos($id_pea_documento_carpeta){
		$sql = "SELECT * FROM pea_documentos WHERE id_pea_documento_carpeta= :id_pea_documento_carpeta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_documento_carpeta", $id_pea_documento_carpeta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para insertar una carpeta
	public function insertarDescarga($id_pea_documento, $id_credencial, $fecha, $hora){
		$sql = "INSERT INTO pea_documento_descarga (id_pea_documento,id_credencial,fecha,hora)
		VALUES ('$id_pea_documento','$id_credencial','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para mostrar los enlaces
	public function verEnlaces($id_pea_docente){
		$sql = "SELECT * FROM pea_enlaces WHERE id_pea_docentes= :id_pea_docente";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docente", $id_pea_docente);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los enlaces
	public function verGlosario($id_pea_docentes){
		$sql = "SELECT * FROM pea_glosario WHERE id_pea_docentes= :id_pea_docentes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para ver las carpetas
	public function verCarpetasEjercicios($id_pea_docentes){
		$sql = "SELECT * FROM pea_ejercicios_carpeta WHERE id_pea_docentes= :id_pea_docentes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los documentos de los PEA
	public function verPeaDocumentosEjercicios($id_pea_ejercicios_carpeta){
		$sql = "SELECT * FROM pea_ejercicios WHERE id_pea_ejercicios_carpeta= :id_pea_ejercicios_carpeta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios_carpeta", $id_pea_ejercicios_carpeta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer el id_docnte_grupo
	public function traeridpeadocente($id_pea_docentes){
		$sql = "SELECT id_pea_docentes,id_docente_grupo FROM pea_docentes WHERE id_pea_docentes= :id_pea_docentes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el nombre del ejercicio
	public function traerNombreEjecicio($id_pea_ejercicios_global){
		$sql = "SELECT `nombre_ejercicios` FROM `pea_ejercicios` WHERE `id_pea_ejercicios`= :id_pea_ejercicios_global";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios_global", $id_pea_ejercicios_global);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar el programa
	public function comprobar($id_docente_grupo){
		$sql = "SELECT * FROM docente_grupos WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar una ejercicio
	public function insertarEjercicio($id_pea_ejercicios, $id_estudiante, $id_credencial, $comentario_ejercicios, $archivo_ejercicios, $fecha_enviado, $hora_enviado, $ciclo){
		$sql = "INSERT INTO pea_ejercicios_est (id_pea_ejercicios,id_estudiante,id_credencial,comentario_ejercicios,archivo_ejercicios,fecha_enviado,hora_enviado,ciclo)
		VALUES ('$id_pea_ejercicios','$id_estudiante','$id_credencial','$comentario_ejercicios','$archivo_ejercicios','$fecha_enviado','$hora_enviado','$ciclo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para mirar el programa
	public function taerArchivoEstudiante($id_pea_ejercicios, $id_estudiante){
		$sql = "SELECT * FROM pea_ejercicios_est WHERE id_pea_ejercicios= :id_pea_ejercicios and id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios", $id_pea_ejercicios);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para buscar Docente
	public function buscar_docente_h(){
		$sql = "SELECT * FROM docente_grupos INNER JOIN horario_especial ON docente_grupos.id_docente_grupo = horario_especial.id_docente_grupo INNER JOIN docente ON docente_grupos.id_docente = docente.id_usuario ";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":materia", $materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para buscar matera
	public function buscaridmateria_h(){
		$sql = "SELECT * FROM docente_grupos INNER JOIN horario_especial ON docente_grupos.id_docente_grupo = horario_especial.id_docente_grupo INNER JOIN docente ON docente_grupos.id_docente = docente.id_usuario ";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":materia", $materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para horario por docente grupo
	public function docente_grupo_horario($id_estudiante){
		$sql = "SELECT * FROM materias9 INNER JOIN horario_especial ON materias9.nombre_materia = horario_especial.nombre_materia INNER JOIN docente_grupos ON `docente_grupos`.`id_docente_grupo` = `horario_especial`.`id_docente_grupo`INNER JOIN docente ON docente_grupos.id_docente = docente.id_usuario WHERE  `materias9`.`id_estudiante` = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer datos estudiantes
	public function estudiante_datos($id_credencial){
		$sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para datos personales
	public function estudiante_datos_personales($id_credencial){
		$sql = "SELECT * FROM estudiantes_datos_personales WHERE id_credencial= :id_credencial";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}