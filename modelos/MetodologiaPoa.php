<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class MetodologiaPoa
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
	//Implementar un método para listar la ejecucion
	public function listarproyecto()
	{
		global $mbd;
		$sql = "SELECT * FROM sac_proyecto";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar la ejecucion
	public function listarproyectousuario($id_proyecto, $responsable, $anio_eje)
	{
		global $mbd;
		$sql = "SELECT * FROM sac_meta WHERE id_proyecto= :id_proyecto and meta_responsable= :responsable and anio_eje = :anio_eje";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":responsable", $responsable);
		$consulta->bindParam(":anio_eje", $anio_eje);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las matas del usuario dependiendo del proyecto
	public function listarmeta($meta_responsable, $id_proyecto, $anio)
	{
		// $anio = 2023;
		// $anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT * FROM sac_meta WHERE meta_responsable= :meta_responsable and id_proyecto= :id_proyecto and anio_eje= :anio ";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para insertar una accion
	public function insertaraccion($nombre_accion, $id_meta, $fecha_accion, $fecha_fin, $hora)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_accion`(`nombre_accion`,`id_meta`,`fecha_accion`, `fecha_fin` , `hora` ) VALUES('$nombre_accion','$id_meta', '$fecha_accion', '$fecha_fin' , '$hora')";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar una accion
	public function editaraccion($id_accion, $nombre_accion, $id_meta, $fecha_accion, $fecha_fin)
	{
		$sql = "UPDATE `sac_accion` SET `id_accion` = '$id_accion', `nombre_accion` = '$nombre_accion' , `id_meta` = '$id_meta', `fecha_accion` = '$fecha_accion' , `fecha_fin` = '$fecha_fin' WHERE `id_accion` = $id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	//Implementar un método para mostrar lasacciones
	public function listaracciones($id_meta)
	{
		$sql = "SELECT * FROM `sac_accion` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_accion($id_accion)
	{
		$sql = "SELECT * FROM `sac_accion` WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminar_accion($id_accion)
	{
		$sql = "DELETE FROM sac_accion WHERE id_accion= :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
	}
	public function terminar_accion($id_accion)
	{
		$sql = "UPDATE `sac_accion` SET `accion_estado` = '1' WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
	}
	public function fechaesp($date)
	{
		$dia     = explode("-", $date, 3);
		$year     = $dia[0];
		$month     = (string)(int)$dia[1];
		$day     = (string)(int)$dia[2];

		$dias         = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}

	public function selectlistarCargo()
	{
		$sql = "SELECT * FROM usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementamos un método para insertar una accion
	public function insertartarea($nombre_tarea, $fecha_entrega_tarea, $responsable_tarea, $id_accion, $periodo_tarea)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_tareas`(`nombre_tarea`,`fecha_entrega_tarea`,`responsable_tarea`, `id_accion` , `periodo_tarea` ) VALUES('$nombre_tarea','$fecha_entrega_tarea', '$responsable_tarea', '$id_accion', '$periodo_tarea')";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar una accion
	public function editartarea($id_accion, $nombre_accion, $id_meta, $fecha_accion, $fecha_fin)
	{
		$sql = "UPDATE `sac_accion` SET `id_accion` = '$id_accion', `nombre_accion` = '$nombre_accion' , `id_meta` = '$id_meta', `fecha_accion` = '$fecha_accion' , `fecha_fin` = '$fecha_fin' WHERE `id_accion` = $id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}

	public function mostrartareas($id_accion)
	{
		$sql = "SELECT * FROM `sac_tareas`  WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function tareas_finalizadas($id_accion)
	{
		$sql = "SELECT * FROM `sac_tareas`  WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	// public function calcularPorcentajeAvance($id_accion)
	// {
	// 	global $mbd;

	// 	// Total de tareas para esta acción
	// 	$sql_total = "SELECT COUNT(*) as total FROM sac_tareas WHERE id_accion = :id_accion";
	// 	$consulta_total = $mbd->prepare($sql_total);
	// 	$consulta_total->bindParam(":id_accion", $id_accion);
	// 	$consulta_total->execute();
	// 	// Cuenta todas las tareas en la tabla sac_tareas que tienen el id_accion proporcionado.
	// 	$total = $consulta_total->fetch(PDO::FETCH_ASSOC)["total"];
	// 	//  Verifica si hay tareas
	// 	if ($total == 0) return 0;
	// 	// Total de tareas finalizadas (estado_tarea = 1)
	// 	$sql_completadas = "SELECT COUNT(*) as finalizadas FROM sac_tareas WHERE id_accion = :id_accion AND estado_tarea = 1";
	// 	$consulta_finalizadas = $mbd->prepare($sql_completadas);
	// 	$consulta_finalizadas->bindParam(":id_accion", $id_accion);
	// 	$consulta_finalizadas->execute();
	// 	$finalizadas = $consulta_finalizadas->fetch(PDO::FETCH_ASSOC)["finalizadas"];

	// 	// Calcula porcentaje
	// 	$porcentaje = round(($finalizadas / $total) * 100);
	// 	return $porcentaje;
	// }

	public function contarTareasPorAccion($id_accion)
	{
		global $mbd;

		$sql = "SELECT COUNT(*) AS total FROM sac_tareas WHERE id_accion = :id_accion";
		$stmt = $mbd->prepare($sql);
		$stmt->bindParam(":id_accion", $id_accion);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['total'];
	}

	public function contarTareasFinalizadasPorAccion($id_accion)
	{
		global $mbd;

		$sql = "SELECT COUNT(*) AS finalizadas FROM sac_tareas WHERE id_accion = :id_accion AND estado_tarea = 1";
		$stmt = $mbd->prepare($sql);
		$stmt->bindParam(":id_accion", $id_accion);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['finalizadas'];
	}

	public function terminar_tarea($id_tarea_sac)
	{
		global $mbd;

		$sql = "UPDATE sac_tareas SET estado_tarea = 1 WHERE id_tarea_sac = :id_tarea_sac";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		return $consulta->execute();
	}
}
