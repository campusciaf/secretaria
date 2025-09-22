	
<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class SacTareas
{
	//Implementamos nuestro constructor
	public function __construct() {}

	public function listarTareasPorEjeUsuario($id_ejes, $id_usuario, $anio)
	{
		global $mbd;
		$sql = "SELECT DISTINCT sac_meta.*, sac_proyecto.nombre_proyecto  FROM sac_ejes INNER JOIN sac_proyecto ON sac_ejes.id_ejes = sac_proyecto.id_ejes INNER JOIN sac_meta ON sac_proyecto.id_proyecto = sac_meta.id_proyecto INNER JOIN sac_accion ON sac_meta.id_meta = sac_accion.id_meta INNER JOIN sac_tareas ON sac_accion.id_accion = sac_tareas.id_accion WHERE sac_ejes.id_ejes = :id_ejes AND sac_tareas.responsable_tarea = :id_usuario AND sac_meta.anio_eje = :anio";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_ejes', $id_ejes);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':anio', $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	// public function listarMetaUsuario($meta_responsable, $anio)
	// {
	// 	global $mbd;
	// 	$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE usuario.id_usuario = :meta_responsable and anio_eje= :anio";
	// 	// echo $sql;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":meta_responsable", $meta_responsable);
	// 	$consulta->bindParam(":anio", $anio);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll();
	// 	return $resultado;
	// }

	public function listarCondicionInstitucionalMeta($id_meta)
	{
		$sql = "SELECT * FROM `condiciones_institucionales` INNER JOIN `sac_meta_con_ins` ON `sac_meta_con_ins`.`id_con_ins` = `condiciones_institucionales`.`id_condicion_institucional` WHERE `id_meta` = :id_meta";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_meta', $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function listarCondicionProgramaMeta($id_meta)
	{
		$sql = "SELECT * FROM `condiciones_programa` INNER JOIN `sac_meta_con_pro` ON `sac_meta_con_pro`.`id_con_pro` = `condiciones_programa`.`id_condicion_programa` WHERE `id_meta` = :id_meta";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_meta', $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	// public function listaracciones($id_meta)
	// {
	// 	$id_usuario=$_SESSION['id_usuario'] ;
	// 	$sql = "SELECT * FROM `sac_accion` sa INNER JOIN `sac_tareas` st ON sa.id_accion=st.id_accion WHERE sa.id_meta = :id_meta and st.responsable_tarea= :id_usuario ";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":id_meta", $id_meta);
	// 	$consulta->bindParam(":id_usuario", $id_usuario);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll();
	// 	return $resultado;
	// }



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



	public function listaraccionesCuadriculaTotal($id_meta)
	{
		global $mbd;
		$sql = "SELECT sac_accion.*, sac_meta.meta_nombre, sac_proyecto.nombre_proyecto FROM sac_accion INNER JOIN sac_meta ON sac_accion.id_meta = sac_meta.id_meta INNER JOIN sac_proyecto ON sac_meta.id_proyecto = sac_proyecto.id_proyecto WHERE sac_accion.id_meta = :id_meta";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_meta', $id_meta);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}






	public function listaraccionesPanel($id_usuario, $id_meta)
	{
		global $mbd;
		$sql = "SELECT  sac_accion.*, sac_meta.meta_nombre, sac_proyecto.nombre_proyecto FROM sac_accion INNER JOIN sac_meta ON sac_accion.id_meta = sac_meta.id_meta INNER JOIN sac_proyecto ON sac_meta.id_proyecto = sac_proyecto.id_proyecto INNER JOIN sac_tareas ON sac_accion.id_accion = sac_tareas.id_accion WHERE sac_tareas.responsable_tarea = :id_usuario AND sac_accion.id_meta = :id_meta GROUP BY sac_accion.id_accion";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':id_meta', $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}




	// 	public function listaraccionesPanel($id_meta, $id_usuario)
	// {
	// 	global $mbd;

	// 	$sql = "SELECT DISTINCT *
	// 	        FROM sac_tareas st
	// 	        INNER JOIN sac_accion sa ON st.id_accion = sa.id_accion
	// 	        WHERE sa.id_meta = :id_meta
	// 	          AND st.responsable_tarea = :id_usuario";

	// 	$stmt = $mbd->prepare($sql);
	// 	$stmt->bindParam(':id_meta', $id_meta);
	// 	$stmt->bindParam(':id_usuario', $id_usuario);
	// 	$stmt->execute();

	// 	return $stmt->fetchAll(PDO::FETCH_ASSOC);
	// }



	public function listaraccionesDetalle($id_usuario, $id_meta)
	{
		global $mbd;
		$sql = "SELECT  sac_accion.*, sac_meta.meta_nombre, sac_proyecto.nombre_proyecto FROM sac_accion INNER JOIN sac_meta ON sac_accion.id_meta = sac_meta.id_meta INNER JOIN sac_proyecto ON sac_meta.id_proyecto = sac_proyecto.id_proyecto INNER JOIN sac_tareas ON sac_accion.id_accion = sac_tareas.id_accion WHERE sac_tareas.responsable_tarea = :id_usuario AND sac_accion.id_meta = :id_meta GROUP BY sac_accion.id_accion";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':id_meta', $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}




	public function listaraccionesmias($id_accion)
	{
		$sql = "SELECT * FROM `sac_accion`  WHERE id_accion = :id_accion ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarMimeta($id_meta)
	{
		$sql = "SELECT * FROM `sac_meta`  WHERE id_meta = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


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
	// mostramos las tareas por usuario
	public function mostrar_tareas_usuario($responsable_tarea, $periodo_tarea)
	{
		$sql = "SELECT * FROM sac_tareas WHERE responsable_tarea= :responsable_tarea AND periodo_tarea= :periodo_tarea";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":responsable_tarea", $responsable_tarea);
		$consulta->bindParam(":periodo_tarea", $periodo_tarea);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	// Listar tareas pendientes por usuario y periodo
	public function listar_tareas_pendientes($responsable_tarea, $periodo_tarea)
	{
		global $mbd;
		$sql = "SELECT * FROM sac_tareas WHERE responsable_tarea= :responsable_tarea AND periodo_tarea= :periodo_tarea AND estado_tarea = 0";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":responsable_tarea", $responsable_tarea);
		$consulta->bindParam(":periodo_tarea", $periodo_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}

	// Listar tareas finalizadas por usuario y periodo
	public function listar_tareas_finalizadas($responsable_tarea, $periodo_tarea)
	{
		global $mbd;
		$sql = "SELECT * FROM sac_tareas WHERE responsable_tarea= :responsable_tarea AND periodo_tarea= :periodo_tarea AND estado_tarea = 1";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":responsable_tarea", $responsable_tarea);
		$consulta->bindParam(":periodo_tarea", $periodo_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	//convertimos la fecha en texto 
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
	// guarda el link de la tarea
	public function guardarlinktarea($id_tarea_sac, $link)
	{
		global $mbd;
		$sql = "UPDATE sac_tareas SET link_evidencia_tarea = :link WHERE id_tarea_sac = :id_tarea_sac";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":link", $link);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		return $consulta->execute();
	}

	// validamos la tarea.
	// public function terminar_tarea($id_tarea_sac)
	// {
	// 	$sql = "UPDATE `sac_tareas` SET `validacion_tarea` = '1' WHERE `id_tarea_sac` = :id_tarea_sac";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
	// 	$consulta->execute();
	// }

	public function terminar_tarea($id_tarea_sac)
	{
		$sql = "UPDATE `sac_tareas` SET `estado_tarea` = '1' WHERE `id_tarea_sac` = :id_tarea_sac";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		$consulta->execute();
	}



	public function mostrartareas($id_accion,$id_usuario )
	{
		$sql = "SELECT * FROM `sac_tareas`  WHERE `id_accion` = :id_accion and responsable_tarea= :id_usuario ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function DatosUsuario($id_usuario)
	{
		$sql = "SELECT * FROM usuario WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function datosEjes($id_eje)
	{
		global $mbd;
		$sql = "SELECT * FROM sac_ejes WHERE id_ejes = :id_eje";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_eje", $id_eje);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function datosProyecto($id_proyecto)
	{
		global $mbd;
		$sql = "SELECT * FROM sac_proyecto WHERE id_proyecto = :id_proyecto";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function listarEjes()
	{
		global $mbd;
		$sql = "SELECT * FROM sac_ejes";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function periodoactual()
	{
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function traerDetallesTarea($id_tarea_sac)
	{
		$sql = "SELECT * FROM sac_tareas WHERE id_tarea_sac= :id_tarea_sac";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function traerResponsableTarea($id_usuario)
	{
		$sql = "SELECT * FROM usuario WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//prueba panel


	public function selectlistarEjes()
	{
		$sql = "SELECT * FROM sac_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function listarMetaUsuario($id_ejes, $anio)
	{

		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE sac_meta.id_eje = :id_ejes and anio_eje= :anio";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function listarresponsables($id_meta)
	{
		$sql = "SELECT DISTINCT responsable_tarea FROM sac_tareas WHERE id_meta= :id_meta 
		";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_COLUMN);  // devuelve array solo con id_meta
	}

	public function fechaCompletaCorta($date)
	{
		$partes = explode("-", $date, 3);
		$year   = (int)$partes[0];
		$month  = (int)$partes[1];
		$day    = (int)$partes[2];

		$dias = array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		$timestamp = mktime(0, 0, 0, $month, $day, $year);
		$nombreDia = $dias[date("w", $timestamp)];

		return $nombreDia . ", " . $day . " de " . $meses[$month];
	}

	public function listarMetaGeneral($anio)
	{
		global $mbd;
		$sql = "SELECT * FROM sac_meta  WHERE  anio_eje= :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function listarTareas($id_meta)
	{
		$sql = "SELECT * FROM `sac_tareas` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function listarTareasCuadricula($id_meta, $responsable_tarea)
	{
		$sql = "SELECT * FROM `sac_tareas` WHERE `id_meta` = :id_meta AND `responsable_tarea` = :responsable_tarea ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->bindParam(":responsable_tarea", $responsable_tarea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	// public function listarTareasPorUsuarioCuadricula($id_usuario, $anio)
	// {
	// 	global $mbd;
	// 	$sql = "SELECT DISTINCT sac_meta.*, sac_proyecto.nombre_proyecto FROM sac_ejes INNER JOIN sac_proyecto ON sac_ejes.id_ejes = sac_proyecto.id_ejes INNER JOIN sac_meta ON sac_proyecto.id_proyecto = sac_meta.id_proyecto INNER JOIN sac_accion ON sac_meta.id_meta = sac_accion.id_meta INNER JOIN sac_tareas ON sac_accion.id_accion = sac_tareas.id_accion WHERE sac_tareas.responsable_tarea = :id_usuario AND sac_meta.anio_eje = :anio";
	// 	// echo $sql;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(':id_usuario', $id_usuario);
	// 	$consulta->bindParam(':anio', $anio);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
	// 	return $resultado;
	// }


	public function listarTareasPorUsuarioCuadricula($id_usuario, $anio)
	{
		global $mbd;

		$sql = "SELECT DISTINCT sac_meta.*, sac_proyecto.nombre_proyecto FROM sac_ejes INNER JOIN sac_proyecto ON sac_ejes.id_ejes = sac_proyecto.id_ejes INNER JOIN sac_meta ON sac_proyecto.id_proyecto = sac_meta.id_proyecto INNER JOIN sac_accion ON sac_meta.id_meta = sac_accion.id_meta INNER JOIN sac_tareas ON sac_accion.id_accion = sac_tareas.id_accion WHERE sac_tareas.responsable_tarea = :id_usuario AND sac_meta.anio_eje = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':anio', $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function listarMimetaNombre($id_meta)
	{
		$sql = "SELECT * FROM `sac_meta`  WHERE id_meta = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function listaraccionescuadricula($id_usuario, $id_meta)
	{
	
		$sql = "SELECT DISTINCT id_accion FROM sac_tareas WHERE id_meta= :id_meta and responsable_tarea = :id_usuario";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_COLUMN);  // devuelve array solo con id_meta
	}

	public function mostrarnombreaccion($id_accion)
	{
		$sql = "SELECT * FROM `sac_accion`  WHERE id_accion = :id_accion ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function mostrartareasPanel($id_accion, $id_usuario)
	{

		$sql = "SELECT * FROM `sac_tareas`  WHERE `id_accion` = :id_accion and responsable_tarea= :id_usuario ";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	
	public function marcarTareaPendienteFinalizada($id_tarea_sac)
	{
		global $mbd;
		$sql = "UPDATE sac_tareas SET estado_tarea = 1 WHERE id_tarea_sac = :id_tarea_sac";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		return $consulta->execute();
	}
}
