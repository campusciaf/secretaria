<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class AdminCalendarioEventos
{

	//Implementamos nuestro constructor
	public function __construct() {}

	public function periodoactual()
	{
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Traemos los datos que llenen el calendario
	public function mostrarEventos()
	{
		$sql_leer = "SELECT ce.id_evento as id, ce.evento as title, ce.fecha_inicio as start, ce.fecha_final as end, ca.color as color, ca.id_actividad, ce.descripcion, ce.id_actividad as id_actividad, ce.hora FROM calendario_eventos ce INNER JOIN calendario_actividad ca ON ce.id_actividad=ca.id_actividad";
		global $mbd;
		$consulta_leer = $mbd->prepare($sql_leer);
		$consulta_leer->execute();
		$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_leer;
	}
	//Insertar evento en la base de datos
	public function insertarEventos($evento, $descripcion, $fecha_inicio, $fecha_final, $hora, $id_actividad, $anno)
	{
		$sql_insertar = "INSERT INTO calendario_eventos (evento,descripcion,fecha_inicio,fecha_final,hora,id_actividad,anno) VALUES(:evento,:descripcion,:fecha_inicio,:fecha_final,:hora,:id_actividad,:anno)";
		global $mbd;
		$consulta_insertar = $mbd->prepare($sql_insertar);
		$consulta_insertar->execute(array(
			"evento" => $evento,
			"descripcion" => $descripcion,
			"fecha_inicio" => $fecha_inicio,
			"fecha_final" => $fecha_final,
			"hora" => $hora,
			"id_actividad" => $id_actividad,
			"anno" => $anno
		));
		return $consulta_insertar;
	}
	//Eliminar evento de la base de datos
	public function eliminarEventos($id)
	{
		$sql_eliminar = "DELETE FROM calendario_eventos WHERE id_evento=:id";
		global $mbd;
		$consulta_eliminar = $mbd->prepare($sql_eliminar);
		$consulta_eliminar->execute(array(
			"id" => $id
		));
		return $consulta_eliminar;
	}
	//Modificar evento de la base de datos
	public function modificarEventos($id, $actividad, $descripcion, $fecha_inicio, $fecha_final, $hora, $id_actividad)
	{
		$sql_modificar = "UPDATE calendario_eventos SET evento=:evento, descripcion=:descripcion, fecha_inicio=:fecha_inicio, fecha_final=:fecha_final, hora=:hora, id_actividad=:id_actividad WHERE id_evento=:id";
		global $mbd;
		$consulta_modificar = $mbd->prepare($sql_modificar);
		$consulta_modificar->execute(array(
			"id" => $id,
			"evento" => $actividad,
			"descripcion" => $descripcion,
			"fecha_inicio" => $fecha_inicio,
			"fecha_final" => $fecha_final,
			"hora" => $hora,
			"id_actividad" => $id_actividad
		));
		return $consulta_modificar;
	}
	public function alertacalendario($evento)
	{
		global $mbd;
		$consulta = $mbd->prepare("SELECT `evento`, `fecha_inicio`, `fecha_final` FROM `calendario_eventos` WHERE `fecha_inicio` = `fecha_final`");
		$consulta->bindParam(":evento", $evento);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// public function listarEventos(){	
	// 	global $mbd;
	// 	$sql="SELECT * FROM `calendario_eventos` ORDER BY `calendario_eventos`.`fecha_inicio` ASC";
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll();
	// 	return $resultado;
	// }
	public function listarEventosPorAnnio($anno)
	{
		global $mbd;
		$sql = "SELECT * FROM `calendario_eventos` WHERE anno= :anno ORDER BY `calendario_eventos`.`fecha_inicio` ASC";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anno", $anno);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function listarEventos()
	{
		global $mbd;
		$sql = "SELECT * FROM calendario_eventos ORDER BY calendario_eventos.fecha_inicio ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function listarEventosActual($anno)
	{
		global $mbd;
		$sql = "SELECT * FROM `calendario_eventos` WHERE anno= :anno ORDER BY `calendario_eventos`.`fecha_inicio` ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anno", $anno);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectActividad()
	{
		global $mbd;
		$sql = "SELECT * FROM `calendario_actividad`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectActividadActiva($id_actividad)
	{
		$sql = "SELECT * FROM `calendario_actividad` WHERE id_actividad= :id_actividad";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_actividad", $id_actividad);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarEventoActividad($id_actividad)
	{
		global $mbd;
		$sql = "SELECT * FROM `calendario_eventos` WHERE id_actividad= :id_actividad";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_actividad", $id_actividad);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarEventoModificar($id_evento)
	{
		global $mbd;
		$sql = "SELECT * FROM `calendario_eventos` WHERE id_evento= :id_evento";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_evento", $id_evento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function fechaesp($date)
	{
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
	public function selecttipoasistente()
	{
		global $mbd;
		$sql = "SELECT * FROM `tipo_asistente`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para insertar los asistentes
	public function insertarasistente($id_evento, $id_tipo_asistente, $id_actividad)
	{
		$sql = "INSERT INTO calendario_asistentes (id_evento,id_tipo_asistente,id_actividad)
			VALUES ('$id_evento','$id_tipo_asistente','$id_actividad')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function listarasistentesevento($id_evento)
	{
		global $mbd;
		$sql = "SELECT * FROM `calendario_asistentes` WHERE id_evento= :id_evento";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_evento", $id_evento);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function nombreasistente($id_tipo_asistente)
	{
		global $mbd;
		$sql = "SELECT * FROM `tipo_asistente` WHERE id_tipo_asistente= :id_tipo_asistente";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tipo_asistente", $id_tipo_asistente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminarasistente($id_calendario_asistente)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `calendario_asistentes` WHERE id_calendario_asistente= :id_calendario_asistente ");
		$sentencia->bindParam(":id_calendario_asistente", $id_calendario_asistente);
		return $sentencia->execute();
	}
	//Implementamos un método para actualziar el numero de participantes
	public function actualizarparticipantes($id_calendario_asistente, $total)
	{
		$sql = "UPDATE calendario_asistentes SET total= :total WHERE id_calendario_asistente= :id_calendario_asistente";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":total", $total);
		$consulta->bindParam(":id_calendario_asistente", $id_calendario_asistente);
		return $consulta->execute();
	}
	//Implementamos un método para suamr lo participantes por actividad
	public function totalactividad($id_evento)
	{
		$sql = "SELECT sum(total) as total_participantes  FROM `calendario_asistentes` WHERE id_evento= :id_evento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_evento", $id_evento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para suamr lo participantes por actividad
	public function totalactividadgeneral($id_actividad)
	{
		$sql = "SELECT sum(total) as total_participantes  FROM `calendario_asistentes` WHERE id_actividad= :id_actividad";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_actividad", $id_actividad);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function estudiantesactivos($periodo_actual)
	{
		global $mbd;
		$sql = "SELECT DISTINCT id_credencial FROM `estudiantes` WHERE periodo_activo= :periodo_actual";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function mostrarPeriodos()
	{
		$sql = "SELECT * FROM periodo ORDER BY `periodo` DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function mostrarAnios()
	{
		$sql = "SELECT * FROM anios ORDER BY anio DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
}
