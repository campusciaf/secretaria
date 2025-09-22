<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class SacListarDependencia
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

	//Implementar un método para listar el nombre de la meta responsable
	public function listarMetaUsuario($id_ejes, $anio)
	{

		// $anio = $_SESSION["sac_periodo"];

		// SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE `sac_meta`.`id_proyecto` = :id_proyecto AND `sac_meta`.`anio_eje` = :anio
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE sac_meta.id_eje = :id_ejes  and anio_eje= :anio";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar el nombre de la metas general
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

	public function fechaDiaMes($date)
	{
		$dia 	= explode("-", $date, 3);
		$month 	= (int)$dia[1];
		$day 	= (int)$dia[2];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $day . " de " . $meses[$month];
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

	public function cambiofechainicio($nuevafecha, $id_meta)
	{
		$sql = "UPDATE `sac_meta` SET fecha_inicio= :nuevafecha WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevafecha", $nuevafecha);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		return $consulta;
	}

	public function cambiofechafinal($nuevafecha, $id_meta)
	{
		$sql = "UPDATE `sac_meta` SET meta_fecha= :nuevafecha WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevafecha", $nuevafecha);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		return $consulta;
	}

	public function cambioNombreMeta($nombre, $id_meta)
	{
		$sql = "UPDATE `sac_meta` SET meta_nombre= :nombre WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		return $consulta;
	}
	public function SacNuevaMeta($meta_nombre, $fecha_inicio, $meta_fecha, $anio_eje, $id_eje, $id_proyecto, $meta_responsable, $plan_mejoramiento, $fecha_creacion, $hora_creacion)
	{
		$sql = "INSERT INTO sac_meta (`meta_nombre`, `fecha_inicio`, `meta_fecha`, `anio_eje`, `id_eje`,`id_proyecto`,`meta_responsable`, `plan_mejoramiento`,`fecha_creacion`,`hora_creacion`) VALUES (:meta_nombre, :fecha_inicio, :meta_fecha, :anio_eje, :id_eje, :id_proyecto,:meta_responsable, :plan_mejoramiento, :fecha_creacion, :hora_creacion);";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_nombre", $meta_nombre);
		$consulta->bindParam(":fecha_inicio", $fecha_inicio);
		$consulta->bindParam(":meta_fecha", $meta_fecha);
		$consulta->bindParam(":anio_eje", $anio_eje);
		$consulta->bindParam(":id_eje", $id_eje);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":plan_mejoramiento", $plan_mejoramiento);
		$consulta->bindParam(":fecha_creacion", $fecha_creacion);
		$consulta->bindParam(":hora_creacion", $hora_creacion);
		$consulta->execute();
		return $consulta;
	}

	public function cambiofechaaccion($nuevafecha, $id_accion)
	{
		$sql = "UPDATE `sac_accion` SET fecha_fin= :nuevafecha WHERE id_accion= :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevafecha", $nuevafecha);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		return $consulta;
	}

	public function cambioNombreAccion($nombre, $id_accion)
	{
		$sql = "UPDATE `sac_accion` SET nombre_accion= :nombre WHERE id_accion= :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		return $consulta;
	}








	//Implementar un método para listar las condiciones institucionales
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
	//Implementar un método para listar las condiciones institucionales
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
	//Implementar un método para listar las condiciones de programa marcadas
	public function listarcondicionesdependencia($id_meta)
	{
		$sql = "SELECT * FROM `dependencias` INNER JOIN `sac_meta_con_dep` ON `sac_meta_con_dep`.`id_con_dep` = `dependencias`.`id_dependencias` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar las acciones
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

	//Implementar un método para mostrar las acciones
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

	//Implementar un método para listar el nombre de la accion
	public function listarNombreAccion($meta_responsable)
	{

		$anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT `sac_accion`.`nombre_accion`, `sac_meta`.`meta_nombre` FROM `sac_accion` INNER JOIN `sac_meta` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico` INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo` INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes` WHERE `sac_meta`.`meta_responsable` = :meta_responsable AND `sac_meta`.`anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_accion($id_accion)
	{
		$sql = "SELECT * FROM `sac_accion` WHERE `id_accion` = :id_accion";
		global $mbd;
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
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

		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	public function editarestadometa($estado_meta, $id_meta)
	{
		$sql = "UPDATE `sac_meta` SET `estado_meta` = '$estado_meta' WHERE `id_meta` = $id_meta";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	//Implementar un método para listar la ejecucion
	public function listarusuariopoa()
	{
		global $mbd;
		$sql = "SELECT * FROM `usuario` WHERE `usuario_poa` = 1";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar la ejecucion
	public function contarmeta($meta_responsable, $anio)
	{
		// $anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT * FROM sac_meta INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario  WHERE usuario.id_usuario = :meta_responsable and anio_eje= :anio";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function porcentajeavance($meta_responsable, $anio)
	{
		// $anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT * FROM sac_meta INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario  WHERE usuario.id_usuario = :meta_responsable and anio_eje= :anio AND `sac_meta`.estado_meta = 1";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
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


	//Funcion para mostrar la meta 
	public function mostrar_meta($id_meta)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` WHERE `sac_meta`.`id_meta` = :id_meta";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
	public function listarCondicionInstitucionalMarcada($id_meta)
	{
		$sql = "SELECT * FROM `sac_meta_con_ins` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarCondicionProgramaMarcada($id_meta)
	{
		$sql = "SELECT * FROM `sac_meta_con_pro` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarCondicionDependencia($id_meta)
	{
		$sql = "SELECT * FROM `sac_meta_con_dep` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectlistarCargo()
	{
		$sql = "SELECT * FROM usuario WHERE `usuario_condicion` = 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectlistarResponsableTarea()
	{
		$sql = "SELECT * FROM usuario WHERE usuario_condicion = 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectListarTiposIndicadores()
	{
		$sql = "SELECT * FROM sac_tipo_indicadores";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listardependencias()
	{
		$sql = "SELECT * FROM `dependencias` where `ayuda` =1";
		global $mbd;
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarCondicionesPrograma()
	{
		$sql = "SELECT * FROM condiciones_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarCondicionesInstitucionales()
	{
		$sql = "SELECT * FROM condiciones_institucionales";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarhistoricoindicadores($id_meta)
	{

		global $mbd;
		$sql = "SELECT * FROM `registro_indicadores` WHERE `id_meta` = :id_meta";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// public function saccrearmeta($plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_proyecto, $id_con_ins, $id_con_pro, $anio_eje, $nombre_indicador, $estado_meta,$porcentaje_avance)
	// {
	// 	global $mbd;
	// 	//insertar la meta  tipo_indicador
	// 	$sql = "INSERT INTO `sac_meta`(`id_meta`,`plan_mejoramiento`,`meta_nombre`, `meta_fecha`, `id_proyecto`, `meta_responsable`,`anio_eje`,`nombre_indicador`,`estado_meta`,`porcentaje_avance` ) VALUES(NULL,'$plan_mejoramiento','$meta_nombre', '$meta_fecha', '$id_proyecto', '$meta_responsable', '$anio_eje','$nombre_indicador','$estado_meta','$porcentaje_avance')";
	// 	$consulta = $mbd->prepare($sql);
	// 	// echo $sql;
	// 	if ($consulta->execute()) {
	// 		$id_meta = $mbd->lastInsertId();
	// 		//insertar las condiciones institucionales
	// 		for ($i = 0; $i < count($id_con_ins); $i++) {
	// 			$sql_detalle = "INSERT INTO `sac_meta_con_ins`(`id_con_ins`, `id_meta`) VALUES('" . $id_con_ins[$i] . "', $id_meta)";
	// 			$consulta2 = $mbd->prepare($sql_detalle);
	// 			$consulta2->execute();
	// 		}
	// 		// insertar codiciones de programa
	// 		for ($i = 0; $i < count($id_con_pro); $i++) {
	// 			$sql_detalle_2 = "INSERT INTO `sac_meta_con_pro`(`id_con_pro`, `id_meta`) VALUES('" . $id_con_pro[$i] . "', $id_meta)";
	// 			$consulta3 = $mbd->prepare($sql_detalle_2);
	// 			$consulta3->execute();
	// 		}
	// 		// insertar dependencias
	// 		// for ($i = 0; $i < count($id_con_dep); $i++) {
	// 		// 	$sql_detalle_4 = "INSERT INTO `sac_meta_con_dep`(`id_con_dep`, `id_meta`) VALUES('" . $id_con_dep[$i] . "', $id_meta)";
	// 		// 	$consulta4 = $mbd->prepare($sql_detalle_4);
	// 		// 	$consulta4->execute();
	// 		// }
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }


	public function SacCrearMeta($meta_nombre, $plan_mejoramiento, $meta_fecha, $meta_responsable, $id_eje, $id_proyecto, $id_con_ins, $id_con_pro, $anio_eje, $nombre_indicador, $porcentaje_avance)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_meta`(`id_meta`, `meta_nombre`, `plan_mejoramiento`, `meta_fecha`, `meta_responsable`, `id_eje`,`id_proyecto`, `anio_eje`, `nombre_indicador`, `porcentaje_avance` )
			VALUES (NULL, '$meta_nombre', '$plan_mejoramiento', '$meta_fecha', '$meta_responsable', '$id_eje','$id_proyecto', '$anio_eje', '$nombre_indicador','$porcentaje_avance')";

		$consulta = $mbd->prepare($sql);
		// echo $sql;
		if ($consulta->execute()) {
			$id_meta = $mbd->lastInsertId();
			//insertar las condiciones institucionales
			for ($i = 0; $i < count($id_con_ins); $i++) {
				$sql_detalle = "INSERT INTO `sac_meta_con_ins`(`id_con_ins`, `id_meta`) VALUES('" . $id_con_ins[$i] . "', $id_meta)";
				$consulta2 = $mbd->prepare($sql_detalle);
				$consulta2->execute();
			}
			// insertar codiciones de programa
			for ($i = 0; $i < count($id_con_pro); $i++) {
				$sql_detalle_2 = "INSERT INTO `sac_meta_con_pro`(`id_con_pro`, `id_meta`) VALUES('" . $id_con_pro[$i] . "', $id_meta)";
				$consulta3 = $mbd->prepare($sql_detalle_2);
				$consulta3->execute();
			}

			return true;
		} else {
			return false;
		}
	}



	//Implementar un método para eliminar los datos de un registro de sac metas con institucion 
	public function eliminar_con_ins($id_meta)
	{
		$sql = "DELETE FROM `sac_meta_con_ins` WHERE `id_meta` = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
	}

	//Implementar un método para eliminar los datos de un registro sac metas con programas
	public function eliminar_con_pro($id_meta)
	{
		$sql = "DELETE FROM `sac_meta_con_pro` WHERE `id_meta` = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
	}

	//Implementar un método para eliminar los datos de un registro sac metas con dependencia
	public function eliminar_con_dep($id_meta)
	{
		$sql = "DELETE FROM `sac_meta_con_dep` WHERE `id_meta` = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
	}

	public function saceditomesta($id_meta, $plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_con_ins, $id_con_pro, $anio_eje, $nombre_indicador, $meta_lograda, $porcentaje_avance)
	{
		$sql = "UPDATE `sac_meta` SET  `plan_mejoramiento` = '$plan_mejoramiento',  `meta_nombre` = '$meta_nombre',  `meta_fecha` = '$meta_fecha', `meta_responsable` = '$meta_responsable', `anio_eje` = '$anio_eje', `nombre_indicador` = '$nombre_indicador', `estado_meta` = '$meta_lograda', `porcentaje_avance` = '$porcentaje_avance' WHERE `id_meta` = '$id_meta'";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		if ($consulta->execute()) {
			//insertar las condiciones institucionales
			for ($i = 0; $i < count($id_con_ins); $i++) {
				$sql_detalle = "INSERT INTO `sac_meta_con_ins`(`id_con_ins`, `id_meta`) VALUES('" . $id_con_ins[$i] . "', $id_meta)";
				$consulta2 = $mbd->prepare($sql_detalle);
				$consulta2->execute();
			}
			// insertar codiciones de programa
			for ($i = 0; $i < count($id_con_pro); $i++) {
				$sql_detalle_2 = "INSERT INTO `sac_meta_con_pro`(`id_con_pro`, `id_meta`) VALUES('" . $id_con_pro[$i] . "', $id_meta)";
				$consulta3 = $mbd->prepare($sql_detalle_2);
				$consulta3->execute();
			}
			// insertar codiciones de programa
			// for ($i = 0; $i < count($id_con_dep); $i++) {
			// 	$sql_detalle_3 = "INSERT INTO `sac_meta_con_dep`(`id_con_dep`, `id_meta`) VALUES('" . $id_con_dep[$i] . "', $id_meta)";
			// 	$consulta4 = $mbd->prepare($sql_detalle_3);
			// 	$consulta4->execute();
			// }
			return true;
		} else {
			return false;
		}
	}



	public function saceditometa($id_meta, $plan_mejoramiento, $meta_nombre, $meta_fecha, $id_eje, $meta_responsable, $id_con_ins, $id_con_pro, $anio_eje, $nombre_indicador, $porcentaje_avance, $id_proyecto)
	{
		$sql = "UPDATE `sac_meta` SET  `plan_mejoramiento` = '$plan_mejoramiento', `meta_nombre` = '$meta_nombre',  `meta_fecha` = '$meta_fecha', `id_eje` = '$id_eje', `meta_responsable` = '$meta_responsable', `anio_eje` = '$anio_eje', `nombre_indicador` = '$nombre_indicador', `porcentaje_avance` = '$porcentaje_avance', `id_proyecto` = '$id_proyecto' WHERE `id_meta` = '$id_meta'";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		if ($consulta->execute()) {
			//insertar las condiciones institucionales
			for ($i = 0; $i < count($id_con_ins); $i++) {
				$sql_detalle = "INSERT INTO `sac_meta_con_ins`(`id_con_ins`, `id_meta`) VALUES('" . $id_con_ins[$i] . "', $id_meta)";
				$consulta2 = $mbd->prepare($sql_detalle);
				$consulta2->execute();
			}
			// insertar codiciones de programa
			for ($i = 0; $i < count($id_con_pro); $i++) {
				$sql_detalle_2 = "INSERT INTO `sac_meta_con_pro`(`id_con_pro`, `id_meta`) VALUES('" . $id_con_pro[$i] . "', $id_meta)";
				$consulta3 = $mbd->prepare($sql_detalle_2);
				$consulta3->execute();
			}

			return true;
		} else {
			return false;
		}
	}

	public function insertareditarregistroindicadores($puntaje_actual, $puntaje_anterior, $tipo_indicador, $tipo_pregunta, $participa, $poblacion, $select_tipo_indicador, $id_meta, $fecha, $hora)
	{
		$sql = "INSERT INTO `registro_indicadores` (`id_registro_indicador`,`puntaje_actual`,`puntaje_anterior`,`tipo_indicador`,`tipo_pregunta`,`participa`,`poblacion`,`select_tipo_indicador`, `id_meta`, `fecha`, `hora`) VALUES (NULL, :puntaje_actual, :puntaje_anterior, :tipo_indicador, :tipo_pregunta, :participa, :poblacion, :select_tipo_indicador, :id_meta, :fecha, :hora);";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":puntaje_actual", $puntaje_actual);
		$consulta->bindParam(":puntaje_anterior", $puntaje_anterior);
		$consulta->bindParam(":tipo_indicador", $tipo_indicador);
		$consulta->bindParam(":tipo_pregunta", $tipo_pregunta);
		$consulta->bindParam(":participa", $participa);
		$consulta->bindParam(":poblacion", $poblacion);
		$consulta->bindParam(":select_tipo_indicador", $select_tipo_indicador);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->bindParam(":fecha", $fecha);
		$consulta->bindParam(":hora", $hora);
		$consulta->execute();
		return $consulta;
	}



	public function eliminar_meta_listar_dependencia($id_meta)
	{
		$sql = "DELETE FROM sac_meta WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		return $consulta;
	}



	public function selectlistarEjes()
	{
		$sql = "SELECT * FROM sac_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function datosEjes($id_eje)
	{
		$sql = "SELECT * FROM sac_ejes WHERE id_ejes = :id_eje";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_eje", $id_eje);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function selectlistarProyectos($id_ejes)
	{
		$sql = "SELECT * FROM sac_proyecto WHERE id_ejes = :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
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

	// public function insertartarea($nombre_tarea, $fecha_entrega_tarea, $responsable_tarea, $id_accion, $periodo_tarea, $id_meta)
	// {
	// 	global $mbd;
	// 	$sql = "INSERT INTO sac_tareas (nombre_tarea, fecha_entrega_tarea, responsable_tarea, id_accion, periodo_tarea, id_meta)
	//     VALUES (?, ?, ?, ?, ?, ?)";

	// 	$consulta = $mbd->prepare($sql);
	// 	return $consulta->execute([
	// 		$nombre_tarea,
	// 		$fecha_entrega_tarea,
	// 		$responsable_tarea,
	// 		$id_accion,
	// 		$periodo_tarea,
	// 		$id_meta
	// 	]);
	// }

	public function insertartarea($nombre_tarea, $fecha_entrega_tarea, $responsable_tarea, $id_accion, $periodo_tarea, $id_meta)
	{
		global $mbd;

		$sql = "INSERT INTO sac_tareas ( nombre_tarea, fecha_entrega_tarea, responsable_tarea, id_accion, periodo_tarea, id_meta) VALUES ( :nombre_tarea, :fecha_entrega_tarea, :responsable_tarea, :id_accion, :periodo_tarea, :id_meta)";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_tarea", $nombre_tarea);
		$consulta->bindParam(":fecha_entrega_tarea", $fecha_entrega_tarea);
		$consulta->bindParam(":responsable_tarea", $responsable_tarea);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->bindParam(":periodo_tarea", $periodo_tarea);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		return $consulta;
	}
	public function eliminar_accion($id_accion)
	{
		$sql = "DELETE FROM sac_accion WHERE id_accion= :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		if ($consulta->execute()) {
			return true; // Eliminación exitosa
		} else {
			return false; // Hubo un error
		}
	}
	public function terminar_accion($id_accion)
	{
		$sql = "UPDATE `sac_accion` SET `accion_estado` = '1' WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
	}

	public function terminar_tarea($id_tarea_sac)
	{
		$sql = "UPDATE `sac_tareas` SET `estado_tarea` = '1' WHERE `id_tarea_sac` = :id_tarea_sac";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		$consulta->execute();
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

	public function mostrar_tarea($id_tarea_sac)
	{
		$sql = "SELECT * FROM `sac_tareas` WHERE `id_tarea_sac` = :id_tarea_sac";
		global $mbd;
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function editartarea($nombre_tarea, $fecha_entrega_tarea, $responsable_tarea, $link_evidencia_tarea, $id_tarea_sac)
	{
		$sql = "UPDATE `sac_tareas` SET `nombre_tarea` = '$nombre_tarea', `fecha_entrega_tarea` = '$fecha_entrega_tarea' , `responsable_tarea` = '$responsable_tarea', `link_evidencia_tarea` = '$link_evidencia_tarea' WHERE `id_tarea_sac` = $id_tarea_sac";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}

	public function eliminar_tarea($id_tarea_sac)
	{
		$sql = "DELETE FROM sac_tareas WHERE id_tarea_sac= :id_tarea_sac";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		$consulta->execute();
		return $consulta;
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

	public function traer_proyecto($id_proyecto)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto` WHERE `id_proyecto` = :id_proyecto";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
	public function traer_proyecto_eje($id_eje)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto` WHERE `id_ejes` = :id_eje";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_eje", $id_eje);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
	
	public function traer_eje_nombre($id_ejes)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_ejes` WHERE `id_ejes` = :id_ejes";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}


	public function cambioNombreResponsable($meta_responsable, $id_meta)
	{
		$sql = "UPDATE `sac_meta` SET meta_responsable= :meta_responsable WHERE id_meta= :id_meta";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		return $consulta;
	}


	public function selectlistarResponsable()
	{
		$sql = "SELECT * FROM usuario WHERE usuario_condicion = 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function cambioNombreTarea($nombre_tarea, $id_tarea_sac)
	{
		$sql = "UPDATE `sac_tareas` SET nombre_tarea= :nombre_tarea WHERE id_tarea_sac= :id_tarea_sac";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_tarea", $nombre_tarea);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		$consulta->execute();
		return $consulta;
	}

	public function cambioNombreResponsableTarea($responsable_tarea, $id_tarea_sac)
	{
		$sql = "UPDATE `sac_tareas` SET responsable_tarea= :responsable_tarea WHERE id_tarea_sac= :id_tarea_sac";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":responsable_tarea", $responsable_tarea);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		$consulta->execute();
		return $consulta;
	}

	public function cambiofechatarea($nuevafecha, $id_tarea_sac)
	{
		$sql = "UPDATE `sac_tareas` SET fecha_entrega_tarea= :nuevafecha WHERE id_tarea_sac= :id_tarea_sac";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevafecha", $nuevafecha);
		$consulta->bindParam(":id_tarea_sac", $id_tarea_sac);
		$consulta->execute();
		return $consulta;
	}
}
