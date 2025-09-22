<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class DocenteGruposAnterior{
	//Implementamos nuestro constructor
	public function __construct(){}
	public function periodoactual(){
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarMotivos(){
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `motivos_falta`;");
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}
	//Implementar un método para listar las materias
	public function listargrupos($id_docente){
		$sql = "SELECT * FROM `docente_grupos` WHERE `id_docente` = :id_docente AND periodo = :periodo_anterior ";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":periodo_anterior", $_SESSION["periodo_anterior"]);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las materias
	public function listarDocenteGrupo($id_docente_grupo){
		$sql = "SELECT * FROM `docente_grupos` WHERE `id_docente_grupo` = :id_docente_grupo AND periodo = :periodo_anterior ";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":periodo_anterior", $_SESSION["periodo_anterior"]);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para buscar los datos de la materia a matricular
	public function materiaDatos($id){
		$sql = "SELECT * FROM materias_ciafi WHERE id= :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las materias
	public function listarelgrupo($id_docente_grupo){
		$sql = "SELECT * FROM docente_grupos WHERE id_docente_grupo= :id_docente_grupo and periodo='" . $_SESSION["periodo_anterior"] . "' ";
		// echo $sql;
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las materias
	public function listar($ciclo, $materia, $jornada, $id_programa, $grupo){
		$tabla = "materias" . $ciclo;
		$periodo_anterior = $_SESSION["periodo_anterior"];
		$sql = "SELECT *, $ciclo AS `ciclo_estudiante` FROM $tabla WHERE `nombre_materia` = :materia AND `jornada` = :jornada AND `programa` = :id_programa AND `periodo` = '$periodo_anterior' AND `grupo` = :grupo AND `activar_grupo_esp` = 0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las materias
	public function listarGruposEspeciales($id_docente_grupo, $ciclo_matriculado, $id_estudiante)
	{
		$periodo_anterior = $_SESSION["periodo_anterior"];
		$sql = "SELECT *, $ciclo_matriculado AS `ciclo_estudiante` FROM `materias$ciclo_matriculado` WHERE `periodo` LIKE :periodo_anterior AND `id_docente_grupo_esp` = :id_docente_grupo AND `activar_grupo_esp` = 1 AND `id_estudiante` = :id_estudiante ORDER BY `id_docente_grupo_esp` DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_anterior", $periodo_anterior);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las materias
	public function listarEspeciales($id_docente_grupo){
		$periodo_anterior = $_SESSION["periodo_anterior"];
		$sql = "SELECT * FROM `horario_especial` WHERE `id_docente_grupo` = :id_docente_grupo AND `periodo_especial` LIKE :periodo_anterior";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":periodo_anterior", $periodo_anterior);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listar_homologados($materia, $id_docente_grupo){
		$periodo_anterior = $_SESSION["periodo_anterior"];
		// SELECT * FROM materias11 INNER JOIN horario_especial ON materias11.nombre_materia = horario_especial.nombre_materia WHERE materias11.`nombre_materia` = :materia AND materias11.`jornada` = :jornada AND materias11.`periodo` = :periodo AND materias11.`grupo` = :grupo AND horario_especial.id_docente_grupo = :id_docente_grupo
		$sql = "SELECT * FROM materias11 INNER JOIN horario_especial ON materias11.nombre_materia = horario_especial.nombre_materia WHERE materias11.`nombre_materia` = :materia AND materias11.`periodo` = :periodo_anterior AND horario_especial.id_docente_grupo = :id_docente_grupo";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		// $consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":periodo_anterior", $periodo_anterior);
		// $consulta->bindParam(":grupo", $grupo);
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
	//Implementar un método para mirar la joranda
	public function jornada($jornada){
		$sql = "SELECT * FROM jornada WHERE nombre= :jornada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar la hora
	public function horasFormato($horas){
		$sql = "SELECT * FROM horas_del_dia WHERE horas= :horas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":horas", $horas);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para tener los datos del docente
	public function datosDocente($id_usuario){
		$sql = "SELECT * FROM docente WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
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
	//Implementar un método para mirar el id del estudiante
	public function id_estudiante($id_estudiante){
		$sql = "SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar datos del estudiante
	public function estudiante_datos($id_credencial){
		$sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar datos del estudiante
	public function est_carac_habeas($id_credencial){
		$sql = "SELECT * FROM caracterizacion_data WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar datos del estudiante
	public function estudiante_datos_completos($id_estudiante){
		global $mbd;
		$sql2 = " SELECT * FROM `estudiantes_datos_personales` INNER JOIN `credencial_estudiante` ON estudiantes_datos_personales.id_credencial = `credencial_estudiante`.id_credencial WHERE estudiantes_datos_personales.id_credencial = :id_creden ";
		$consulta2 = $mbd->prepare($sql2);
		$consulta2->bindParam(":id_creden", $id_estudiante);
		$consulta2->execute();
		$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		return $resultado2;
	}
	//Implementar un método para mirar si el docente tiene PEA
	public function docente_pea($id_docente_materia){
		$sql = "SELECT * FROM pea_docentes WHERE id_materia= :id_docente_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_materia", $id_docente_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para asigar el id a la materia del estudiante
	public function asignar_pea_docente($numero_id_pea_encontrado, $id_estudiante_materia){
		$sql = "UPDATE materias SET id_pea= :numero_id_pea_encontrado WHERE id_materia= :id_estudiante_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":numero_id_pea_encontrado", $numero_id_pea_encontrado);
		$consulta->bindParam(":id_estudiante_materia", $id_estudiante_materia);
		return $consulta->execute();
	}
	//Implementar un método para listar el contenido del PEA
	public function listar_pea($id_estudiante_materia){
		$sql = "SELECT * FROM pea_docentes WHERE id_materia= :id_estudiante_materia ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante_materia", $id_estudiante_materia);
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
	public function listar_actividades($id_tema, $id_materia){
		$sql = "SELECT * FROM pea_actividades WHERE id_tema= :id_tema and id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las actividades
	public function listar_archivos($id_pea_actividades){
		$sql = "SELECT * FROM pea_archivos WHERE id_pea_actividad= :id_pea_actividades";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_actividades", $id_pea_actividades);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para buscar si tiene falta
	public function buscarsitienefalta($id_estudiante, $id_materia, $id_docente, $fecha){
		global $mbd;
		$sql = "SELECT * FROM `faltas` WHERE `id_estudiante` = :id_estudiante AND `id_materia` = :id_materia AND `id_docente` = :id_docente AND `fecha_falta` = :fecha";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":fecha", $fecha);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar faltas
	public function listarFaltas($id_estudiante, $id_materia, $id_docente){
		global $mbd;
		$sql = "SELECT * FROM `faltas` WHERE `id_estudiante` = :id_estudiante AND `id_materia` = :id_materia AND `id_docente` = :id_docente";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para buscar el nombre de la materia
	public function buscarnombremateria($tabla, $id_materia){
		global $mbd;
		$sql = "SELECT * FROM $tabla WHERE `id_materia` = :id_materia";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$registro = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	//Implementar un método para agregar falta en la tabla materias
	public function agregarfaltaenmaterias($tabla, $id_materia){
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE $tabla SET faltas = faltas + 1 WHERE `id_materia` = :id_materia");
		$sentencia->bindParam(":id_materia", $id_materia);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	//Implementar un método para agregar falta en la tabla materias
	public function eliminarFaltaenMaterias($tabla, $id_materia){
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE $tabla SET `faltas` = `faltas` - 1 WHERE `id_materia` = :id_materia");
		$sentencia->bindParam(":id_materia", $id_materia);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	//Implementamos un método para insertar una falta en la tabla faltas
	public function agregarfaltaenfaltas($id_estudiante, $id_materia, $id_docente, $fecha_falta, $ciclo, $id_programa, $materia_falta, $motivo_falta){
		global $mbd;
		$periodo_falta = $_SESSION['periodo_anterior'];
		$sql = "INSERT INTO `faltas`(`id_estudiante`, `id_materia`, `id_docente`, `fecha_falta`, `ciclo`, `programa`, `materia_falta`, `periodo_falta`, `motivo_falta`) VALUES('$id_estudiante', '$id_materia', '$id_docente', '$fecha_falta', '$ciclo', '$id_programa', '$materia_falta', '$periodo_falta', '$motivo_falta')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para insertar una falta en la tabla faltas
	public function eliminarFalta($falta_id){
		global $mbd;
		$sql = "DELETE FROM `faltas` WHERE `id_falta` = $falta_id";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para saber cuantas faltas tiene por materia
	public function consultarfaltas($tabla, $id_materia){
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM $tabla WHERE  `id_materia` = :id_materia");
		$sentencia->bindParam(":id_materia", $id_materia);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	//consulta datos de contacto del estudiante por programa
	public function consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo){
		$tabla = "materias" . $ciclo;
		$periodo = $_SESSION['periodo_anterior'];
		$sql = " SELECT * FROM $tabla WHERE nombre_materia = '$materia' AND jornada = '$jornada' AND programa = '$id_programa' AND periodo = '$periodo' AND grupo= '$grupo'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar datos del estudiante
	public function estudianteDatos($id_estudiante){
		global $mbd;
		$sql2 = " SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_estudiante = :id_estudiante";
		$consulta2 = $mbd->prepare($sql2);
		$consulta2->bindParam(":id_estudiante", $id_estudiante);
		$consulta2->execute();
		$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		return $resultado2;
	}
	//consulta insasistencia del estudiante
	public function consultaInasistencia($id){
		$data = array();
		$periodo = $_SESSION['periodo_anterior'];
		$sql = "SELECT * FROM faltas WHERE id_estudiante = :id AND periodo_falta = :periodo AND  id_docente = :id_d ";
		global $mbd;
		$id_d = $_SESSION['id_usuario'];
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":id_d", $id_d);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//consulta correo del estudiante
	public function consultaCorreoEstudiante($id){
		$sql = "SELECT * FROM `credencial_estudiante` INNER JOIN `estudiantes` ON `credencial_estudiante`.`id_credencial` = `estudiantes`.`id_credencial` WHERE `estudiantes`.`id_estudiante`= :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//consulta correo del estudiante
	public function consultaCorreoCredencial($id){
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `credencial_estudiante`.`id_credencial`= :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function convertir_fecha($date){
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
	//consulta correo del estudiante
	public function consultaCorte($programa, $materia, $id_docente, $semestre, $jornada){
		global $mbd;
		//LA OMITIMOS PARA HACER PRUEBAS CON ESPECIALES AND `semestre` = :semestre
		$pe = $_SESSION['periodo_anterior'];
		$sql = "SELECT * FROM `docente_grupos` WHERE `id_programa` = :progra AND `id_materia` = :mate AND `jornada` = :jorna AND `id_docente` = :id_docente AND `periodo` = :pe";
		/* $sql_2 = "SELECT * FROM `docente_grupos` WHERE `id_programa` = $programa AND `materia` = $materia AND `jornada` = $jornada AND `semestre` = $semestre AND `periodo` = $pe";
		echo $sql_2; */
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":progra", $programa);
		$consulta->bindParam(":mate", $materia);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":jorna", $jornada);
		//$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":pe", $pe);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function agreganota($id, $nota, $tl, $c, $pro){
		global $mbd;
		$mate = "materias" . $c;
		$col_fecha = "fecha_" . $tl;
		$fecha = date("Y-m-d H:i:s");
		$col_ip = "ip_" . $tl;
		$ip = $_SERVER['REMOTE_ADDR'];
		$i = base64_decode($id);
		$sentencia = $mbd->prepare("UPDATE $mate SET $tl = :nota, $col_fecha = :fecha, $col_ip = :ip WHERE `id_materia` = :id");
		$sentencia->bindParam(":nota", $nota);
		$sentencia->bindParam(":fecha", $fecha);
		$sentencia->bindParam(":ip", $ip);
		$sentencia->bindParam(":id", $i);
		if ($sentencia->execute()) {
			if ($c == 4) {
				$sentencia = $mbd->prepare("UPDATE $mate SET `promedio` = c1 WHERE `id_materia` = :id");
			} elseif($c == 6){
				$sentencia = $mbd->prepare("UPDATE $mate SET `promedio` = ROUND((`c1` * 0.3) + (`c2` * 0.2) + (`c3` * 0.5), 2) WHERE `id_materia` = :id");
			}else {
				$sentencia = $mbd->prepare(
				"UPDATE $mate SET `promedio` =
				CASE 
					WHEN ROUND((`c1` * 0.3) + (`c2` * 0.3) + (`c3` * 0.4), 2) >= 2.96 
						AND ROUND((`c1` * 0.3) + (`c2` * 0.3) + (`c3` * 0.4), 2) < 3 
					THEN 3
					ELSE ROUND((`c1` * 0.3) + (`c2` * 0.3) + (`c3` * 0.4), 2)
				END 
				WHERE `id_materia` = :id");
			}
			$sentencia->bindParam(":id", $i);
			$sentencia->execute();
			return true;
		} else {
			return false;
		}
	}
	public function datosMateria($id, $c){
		global $mbd;
		$mate = "materias" . $c;
		$i = base64_decode($id);
		$sentencia = $mbd->prepare("SELECT $mate.*, `estudiantes`.`id_credencial` FROM $mate INNER JOIN `estudiantes` ON `estudiantes`.`id_estudiante` = $mate.`id_estudiante` WHERE `id_materia` = :id ");
		//echo "SELECT $mate.*, `estudiante`.`id_credencial` FROM $mate INNER JOIN `estudiante` ON `estudiante`.`id_estudiante` = $mate.`id_estudiante` WHERE `id_materia` = $i ";
		$sentencia->bindParam(":id", $i);
		$sentencia->execute();
		$resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function trazabilidadNota($id_materia, $id_estudiante, $nota_anterior, $nota_nueva, $corte, $id_docente_grupo, $ciclo, $id_credencial){
		global $mbd;
		$fecha = date("Y-m-d");
		$sentencia = $mbd->prepare("INSERT `trazabilidad_notas`(`id_trazabilidad`, `id_materia`, `id_docente_grupo`, `fecha`, `corte`, `nota_anterior`, `nota_nueva`, `ciclo`, `id_estudiante`, `id_credencial`) VALUES(NULL, :id_materia, :id_docente_grupo, :fecha, :corte, :nota_anterior, :nota_nueva, :ciclo, :id_estudiante, :id_credencial)");
		$sentencia->bindParam(":id_materia", $id_materia);
		$sentencia->bindParam(":id_docente_grupo", $id_docente_grupo);
		$sentencia->bindParam(":fecha", $fecha);
		$sentencia->bindParam(":corte", $corte);
		$sentencia->bindParam(":nota_anterior", $nota_anterior);
		$sentencia->bindParam(":nota_nueva", $nota_nueva);
		$sentencia->bindParam(":ciclo", $ciclo);
		$sentencia->bindParam(":id_estudiante", $id_estudiante);
		$sentencia->bindParam(":id_credencial", $id_credencial);
		return $sentencia->execute();
		if ($sentencia->execute()) {
			//$con = self::promedio($pro,$id,$c);
			$data['status'] = "ok";
		} else {
			$data['status'] = "Error al agregar la nota";
		}
		echo json_encode($data);
	}
	public function promedio($id, $id_mate, $c){
		global $mbd;
		$prome = 0;
		$im = base64_decode($id_mate);
		$sentencia = $mbd->prepare(" SELECT * FROM `cortes_programas` WHERE `id_programa` = $id ");
		//$sentencia->bindParam(":id",$id);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$mate = "materias" . $c;
		for ($i = 0; $i < count($registro); $i++) {
			$sentencia2 = $mbd->prepare(" SELECT * FROM $mate WHERE `id_materia` = $im ");
			$sentencia2->execute();
			$registro2 = $sentencia2->fetch(PDO::FETCH_ASSOC);
			$multi = ($registro2[$registro[$i]['corte_programa']] * $registro[$i]['valor_corte']) / 100;
			$prome = $prome + $multi;
		}
		$sentencia3 = $mbd->prepare(" UPDATE $mate SET promedio = :pro WHERE `id_materia` = :id ");
		$sentencia3->bindParam(":pro", $prome);
		$sentencia3->bindParam(":id", $im);
		if ($sentencia3->execute()) {
			$data['status'] = "ok";
		} else {
			$data['status'] = "error";
		}
	}
	//Implementar un método para traer el nombre del programa
	public function programa($id_programa){
		$sql = "SELECT * FROM programa_ac WHERE id_programa= :id_programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer los datos de la tabla estudiante
	public function traerDatosEstudiante($id_estudiante){
		$sql = "SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las materias
	public function listarDos($id, $ciclo, $grupo){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id and periodo='" . $_SESSION['periodo_anterior'] . "' and grupo= :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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
	//Implementar un método para traer la hora de la materia
	public function horas_grupos($id_docente_grupo){
		$sql = "SELECT * FROM horas_grupos WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el id de la materia matriculada por el estudiante
	public function tienepea($id_materia){
		$sql = "SELECT id_pea,id_materia,estado FROM pea WHERE id_materia= :id_materia and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el id de la materia matriculada por el estudiante
	public function tienepeadocente($id_docente_grupo, $periodo_anterior){
		$sql = "SELECT * FROM pea_docentes WHERE id_docente_grupo= :id_docente_grupo and periodo_pea= :periodo_anterior";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":periodo_anterior", $periodo_anterior);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar una falta en la tabla faltas
	public function activarpea($id_pea, $id_docente_grupo, $fecha, $hora, $periodo_anterior){
		global $mbd;
		$sql = "INSERT INTO `pea_docentes` (`id_pea`, `id_docente_grupo`, `fecha_pea`, `hora_pea`, `periodo_pea`) VALUES('$id_pea', '$id_docente_grupo', '$fecha', '$hora', '$periodo_anterior')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function vernombreestudiante($id_credencial){
		// metodo que trae los programas activos
		global $mbd;
		$periodo = $_SESSION['periodo_anterior'];
		$consulta = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial");
		$consulta->bindParam(":id_credencial", $id_credencial);
		// $consulta->bindParam(":periodo",$periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function consulta_programas($id){
		// metodo que trae los programas activos
		global $mbd;
		$periodo = $_SESSION['periodo_anterior'];
		$consulta = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_credencial` = :id AND `periodo_activo` = :periodo and estado = '1'");
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las materias
	public function listarhomolog($ciclo, $materia){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla INNER JOIN horario_especial ON materias11.nombre_materia = horario_especial.nombre_materia WHERE $tabla.`nombre_materia` = :materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mirar el id del estudiante
	public function estudiante_datos_homologados($id_estudiante){
		$sql = "SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar datos del estudiante
	public function estudiante_datos_homolo($id_credencial){
		$sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para consultar el correo del director
	public function buscarcorreodir($escuela){
		$sql = "SELECT usuario_login,escuela_dir FROM usuario WHERE escuela_dir= :escuela";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function insertarreporteinfluencer($id_estudiante, $id_docente, $id_programa, $id_materia, $influencer_mensaje, $fecha, $hora, $periodo){
		global $mbd;
		$sql = "INSERT INTO `influencer_reporte`(`id_estudiante`, `id_docente`, `id_programa`, `id_materia`, `influencer_mensaje`, `fecha`, `hora`, `periodo` ) VALUES('$id_estudiante','$id_docente','$id_programa','$id_materia','$influencer_mensaje','$fecha','$hora','$periodo')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para traer los dartos de la tabla usuario
	public function traerdatosusuario($id_usuario){
		$sql = "SELECT id_usuario,usuario_login FROM usuario WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarseres($id_credencial)
	{
		$sql="SELECT * FROM carseresoriginales WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarinspiradores($id_credencial)
	{
		$sql="SELECT * FROM carinspiradores WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarempresas($id_credencial)
	{
		$sql="SELECT * FROM carempresas WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarconfiamos($id_credencial)
	{
		$sql="SELECT * FROM carconfiamos WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarexp($id_credencial)
	{
		$sql="SELECT * FROM carexperiencia WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarbienestar($id_credencial)
	{
		$sql="SELECT * FROM carbienestar WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}