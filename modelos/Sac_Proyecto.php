<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class SacProyecto
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Funcion para mostrar el proyecto 
	public function mostrar_proyecto($id_proyecto)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto` WHERE `id_proyecto` = :id_proyecto";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
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
	public function traer_nombre_indicador($id_meta)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_meta_nombre_indicador` WHERE `sac_meta_nombre_indicador`.`id_meta` = :id_meta";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
	//Implementamos un método para agregar un proyecto
	public function insertarProyecto($nombre_proyecto, $id_ejes)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_proyecto`(`nombre_proyecto`, `id_ejes`) VALUES('$nombre_proyecto', '$id_ejes')";
		//echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar un proyecto
	public function editarproyecto($id_proyecto, $nombre_proyecto)
	{
		$sql = "UPDATE `sac_proyecto` SET `nombre_proyecto` = :nombre_proyecto  WHERE `id_proyecto` = :id_proyecto";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":nombre_proyecto", $nombre_proyecto);
		$consulta->execute();
		return $consulta;
	}
	public function eliminarproyecto($id_proyecto)
	{
		$sql = "DELETE FROM sac_proyecto WHERE id_proyecto= :id_proyecto";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->execute();
		return $consulta;
	}
	public function eliminarmeta($id_meta)
	{
		$sql = "DELETE FROM sac_meta WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		return $consulta;
	}
	//Implementar un método para listar el nombre de la meta responsable
	public function ContarMetas($id_proyecto)
	{
		global $mbd;
		$sql = "SELECT `sac_meta`.`id_meta`, `sac_meta`.`meta_nombre`, `sac_ejes`.`nombre_ejes`, `sac_ejes`.`id_ejes` FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_proyecto`.`id_proyecto` = `sac_meta`.`id_proyecto` INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_proyecto`.`id_ejes` WHERE `sac_meta`.`id_proyecto` = :id_proyecto";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		// $consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return count($resultado);
	}
	//Funcion para mostrar las fechas con letras
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
	//Implementar un método para listar las condiciones de programa
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
	//Implementar un método para listar las condiciones dependencias marcadas
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
	//Implementar un método para listar el nombre de la meta responsable
	public function listarAccionUsuario($id_meta)
	{
		$anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT `sac_accion`.`nombre_accion` FROM `sac_accion` INNER JOIN `sac_meta` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` WHERE `sac_accion`.`id_meta` = :id_meta AND `sac_meta`.`anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las condiciones institucionales
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
	//Implementar un método para listar las dependencias
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
	//Implementar un método para listar las condiciones de programa
	public function listarCondicionesPrograma()
	{
		$sql = "SELECT * FROM condiciones_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//seleccionamos el cargo 
	public function selectlistarCargo()
	{
		$sql = "SELECT * FROM usuario WHERE `usuario_poa` = 1 ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_editar_meta($id_meta)
	{
		$sql = "SELECT * FROM `sac_meta` WHERE `id_meta` = :id_meta";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las condiciones insitucioanles marcadas
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
	//Implementar un método para listar las condiciones de programa marcadas
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
	//Implementar un método para listar las dependencias marcadas
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
	//Implementamos un método para agregar las metas
	public function sacinsertometa($plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_proyecto, $id_con_ins, $id_con_pro, $anio_eje, $nombre_indicador, $porcentaje_avance)
	{
		global $mbd;
		//insertar la meta  tipo_indicador
		$sql = "INSERT INTO `sac_meta`(`id_meta`,`plan_mejoramiento`,`meta_nombre`, `meta_fecha`, `id_proyecto`, `meta_responsable`,`anio_eje`,`nombre_indicador`,`porcentaje_avance` ) VALUES(NULL,'$plan_mejoramiento','$meta_nombre', '$meta_fecha', '$id_proyecto', '$meta_responsable', '$anio_eje','$nombre_indicador','$porcentaje_avance')";
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
			// insertar dependencias
			// for ($i = 0; $i < count($id_con_dep); $i++) {
			// 	$sql_detalle_4 = "INSERT INTO `sac_meta_con_dep`(`id_con_dep`, `id_meta`) VALUES('" . $id_con_dep[$i] . "', $id_meta)";
			// 	$consulta4 = $mbd->prepare($sql_detalle_4);
			// 	$consulta4->execute();
			// }
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
	//Implementamos unç método para editar registros de la meta
	public function saceditometa($id_meta, $plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_con_ins, $id_con_pro, $anio_eje, $nombre_indicador, $porcentaje_avance)
	{
		$sql = "UPDATE `sac_meta` SET  `plan_mejoramiento` = '$plan_mejoramiento',  `meta_nombre` = '$meta_nombre',  `meta_fecha` = '$meta_fecha', `meta_responsable` = '$meta_responsable', `anio_eje` = '$anio_eje', `nombre_indicador` = '$nombre_indicador', `porcentaje_avance` = '$porcentaje_avance' WHERE `id_meta` = '$id_meta'";
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
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT * FROM sac_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros de los proyectos
	public function listarproyecto($id_ejes)
	{
		$sql = "SELECT * FROM `sac_proyecto` WHERE id_ejes='$id_ejes' ";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para eliminar los datos de los ejes 
	public function eliminar($id_ejes)
	{
		$sql = "DELETE FROM sac_ejes WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		return $consulta;
	}
	//Implementar un método para listar los registros de las metas
	public function listarMetaEje($id_ejes)
	{
		$anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT `sac_meta`.`meta_nombre` FROM (((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`) WHERE `sac_ejes`.`id_ejes` = :id_ejes AND `anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_ejes', $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las acciones 
	public function listarAccionEje($id_ejes)
	{
		$anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT `sac_meta`.`meta_nombre`, `sac_accion`.`nombre_accion` FROM ((((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`) INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta`) WHERE `sac_ejes`.`id_ejes` = :id_ejes AND `anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_ejes', $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar la ejecucion
	public function mostrarnombre_responsable($meta_responsable)
	{
		$anio = $_SESSION["sac_periodo"];
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
	public function totalaccionesporeje($id_meta)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_accion` WHERE `id_meta` = :id_meta";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar la ejecucion
	public function contarmetaeje($id_ejes)
	{
		$anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT `sac_meta`.`id_meta`, `sac_meta`.`meta_nombre`, `sac_ejes`.`nombre_ejes`, `sac_ejes`.`id_ejes` FROM (((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`) WHERE `sac_ejes`.`id_ejes` = :id_ejes AND `anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function contaraccion($id_meta)
	{
		$anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT COUNT(`sac_accion`.`id_meta`) AS total_accion FROM ((((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`)  INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta`) WHERE `sac_accion`.`id_meta` = :id_meta AND `anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function totalproyectos()
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	// public function totalacciones($anio)
	// {
	// 	global $mbd;
	// 	$sql = "SELECT * FROM `sac_accion` WHERE `anio_eje` = :anio";
	// 	// echo $sql;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":anio", $anio);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll();
	// 	return $resultado;
	// }

	public function totalacciones()
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_accion`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function porvencer()
	{
		$fecha_actual = date('Y-m-d');
		// convertimos la fecha 
		$fechaComoEntero = strtotime($fecha_actual);
		// mostramos el mes actual
		$mes = date("m", $fechaComoEntero);
		global $mbd;
		$sql = "SELECT * FROM `sac_accion` WHERE $mes > `fecha_fin` and `accion_estado` = 0";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function porvencer_accion()
	{
		global $mbd;
		$consulta = $mbd->prepare("SELECT * FROM `sac_accion` INNER JOIN `sac_meta` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` WHERE  `fecha_fin` <= :fecha_fin");
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Muestra el total de acciones por proyecto 
	public function totaldeacciones($id_ejes, $anio)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` WHERE `id_ejes` = :id_ejes and `sac_meta`.anio_eje = :anio";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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
	public function eliminar_accion($id_accion)
	{
		$sql = "DELETE FROM sac_accion WHERE id_accion= :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		return $consulta;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function terminar_accion($id_accion)
	{
		$sql = "UPDATE `sac_accion` SET `accion_estado` = '1' WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		return $consulta->execute();
	}
	//Implementamos un método para insertar una accion
	public function insertaraccion($nombre_accion, $id_meta, $fecha_fin)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_accion`(`nombre_accion`,`id_meta`, `fecha_fin` ) VALUES('$nombre_accion','$id_meta', '$fecha_fin')";
		//echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar una accion
	public function editaraccion($id_accion, $nombre_accion, $id_meta, $fecha_fin, $hora)
	{
		$sql = "UPDATE `sac_accion` SET `id_accion` = '$id_accion', `nombre_accion` = '$nombre_accion' , `id_meta` = '$id_meta', `fecha_fin` = '$fecha_fin', `hora` = '$hora' WHERE `id_accion` = $id_accion";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	public function listar_metas()
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_meta`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listar_acciones()
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_accion`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function mostraraccionespormeta($anio)
	{
		global $mbd;
		// SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE `sac_meta`.`id_proyecto` = :id_proyecto AND `sac_meta`.`anio_eje` = :anio
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` AND `sac_meta`.`anio_eje` = :anio ORDER BY `sac_proyecto`.`id_proyecto` ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listar_proyectos()
	{
		$sql = "SELECT * FROM sac_proyecto";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar lasacciones
	public function listaracciones($id_meta)
	{
		$sql = "SELECT * FROM `sac_accion` WHERE `id_meta` = :id_meta";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function totalaccionespormeta()
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_accion` WHERE `id_meta` = :id_meta";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Muestra el total de acciones por proyecto 
	public function mostrarmetaconproyecto()
	{
		$anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_proyecto`.`id_ejes` WHERE `sac_meta`.`anio_eje` = $anio";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros de los proyectos
	public function mostrarproyectoaccion()
	{
		$sql = "SELECT `nombre_proyecto` FROM `sac_proyecto` ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Muestra el total de acciones por proyecto 
	public function mostrarmetaconproyect()
	{
		$anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_proyecto`.`id_ejes` WHERE `sac_meta`.`anio_eje` = $anio";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros de los proyectos
	public function mostrarproyectos()
	{
		$sql = "SELECT * FROM `sac_proyecto`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function cuentatotalproyectos()
	{
		global $mbd;
		$sql = "SELECT * FROM  `sac_proyecto` ORDER BY `sac_proyecto`.`id_proyecto` ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar el nombre de la meta responsable
	public function listarMetaProyectos_2022($id_proyecto)
	{
		$anio = 2022;
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE `sac_meta`.`id_proyecto` = :id_proyecto AND `sac_meta`.`anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarMetaProyectos_2024($id_proyecto)
	{
		$anio = 2024;
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE `sac_meta`.`id_proyecto` = :id_proyecto AND `sac_meta`.`anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarMetaProyectos_2025($id_proyecto)
	{
		$anio = 2025;
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE `sac_meta`.`id_proyecto` = :id_proyecto AND `sac_meta`.`anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar el nombre de la meta responsable
	public function listarMetaProyectos($id_proyecto)
	{
		$anio = 2023;
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE `sac_meta`.`id_proyecto` = :id_proyecto AND `sac_meta`.`anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
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
	//Implementamos un método para agregar un proyecto
	public function Insertarnombre_indicadorIndicador($nombre_indicador, $id_meta)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_meta_nombre_indicador`(`nombre_indicador`, `id_meta`) VALUES('$nombre_indicador', '$id_meta')";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function traer_ultimo_id_meta()
	{
		global $mbd;
		// SELECT MAX(columna) FROM tabla;
		$sql = "SELECT MAX(id_meta) as ultima_meta FROM `sac_meta`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
	public function eliminarnombre_indicador($id_meta)
	{
		$sql = "DELETE FROM sac_meta_nombre_indicador WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
	}
	public function mostrar_nombre_indicador($id_meta)
	{
		global $mbd;
		$sql = "SELECT nombre_indicador FROM `sac_meta_nombre_indicador` WHERE `id_meta` = :id_meta";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//seleccionamos el cargo 
	// public function selectListarTiposIndicadores()
	// {
	// 	$sql = "SELECT * FROM sac_tipo_indicadores";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll();
	// 	return $resultado;
	// }
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
	// public function listarhistoricoindicadores($id_meta)
	// {
	// 	global $mbd;
	// 	$sql = "SELECT * FROM `registro_indicadores` WHERE `id_meta` = :id_meta";
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":id_meta", $id_meta);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
	// 	return $resultado;
	// }
	public function obtenerNumeroTotaldemetas()
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM `sac_meta`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta->fetchColumn();
	}

	public function totaldemetas($id_ejes, $anio)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` WHERE `sac_meta`.`anio_eje` = :anio and`id_ejes` = :id_ejes ORDER BY `nombre_proyecto` ASC";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function totaldemetass($id_ejes, $anio)
	{
		global $mbd;
		$sql = "SELECT `sac_meta`.`id_meta`, `sac_meta`.`meta_nombre`, `sac_ejes`.`nombre_ejes`, `sac_ejes`.`id_ejes` FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_proyecto`.`id_proyecto` = `sac_meta`.`id_proyecto` INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_proyecto`.`id_ejes` WHERE `sac_meta`.`anio_eje`  = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function obtenerNumeroMetasNoCumplidas($anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM `sac_meta` WHERE `estado_meta` = 0 and `sac_meta`.`anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}
	public function obtenerNumeroMetasCumplidas($anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM `sac_meta` WHERE `estado_meta` = 1 AND `sac_meta`.`anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}



	public function sac_registro_fecha($id_usuario, $fecha_accion_anterior, $fecha_accion_nueva, $hora_anterior, $hora_nueva)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_registro_fecha`(`id_usuario`,`fecha_accion_anterior`,`fecha_accion_nueva` ,`hora_anterior`,`hora_nueva` ) VALUES('$id_usuario','$fecha_accion_anterior', '$fecha_accion_nueva', '$hora_anterior', '$hora_nueva')";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


	public function totalMetasPorProyecto($id_proyecto, $anio)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` RIGHT JOIN `usuario` ON `sac_meta`.`meta_responsable` = `usuario`.`id_usuario` WHERE `sac_meta`.`id_proyecto` = :id_proyecto and `sac_meta`.`anio_eje` = :anio and `usuario`.`usuario_condicion` = 1";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementar un método para listar el nombre de la meta responsable
	public function listarMetaProyectosanioactual($id_proyecto, $anio)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE `sac_meta`.`id_proyecto` = :id_proyecto AND `sac_meta`.`anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function totaldetareas($id_ejes, $anio)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` INNER JOIN `sac_tareas` ON `sac_accion`.`id_accion` = `sac_tareas`.`id_accion` WHERE `sac_proyecto`.`id_ejes` = :id_ejes and `sac_meta`.anio_eje = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
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
	//datos para la grafica

	public function mostrar_eje_grafico($id_ejes)
	{
		global $mbd;
		// La consulta SQL con marcador de posición para el parámetro
		$sql = "SELECT * FROM `sac_proyecto` WHERE id_ejes = :id_ejes";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes, PDO::PARAM_INT);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function totaldetareasgrafica($id_ejes, $anio)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` INNER JOIN `sac_tareas` ON `sac_accion`.`id_accion` = `sac_tareas`.`id_accion` WHERE `sac_proyecto`.`id_ejes` = :id_ejes and `sac_meta`.anio_eje = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	// public function total_metas_grafica_cumplidas($idsProyecto, $anio)
	// {
	// 	global $mbd;
	// 	$sql = "SELECT COUNT(*) FROM `sac_meta` WHERE `sac_meta`.`id_proyecto` IN ($idsProyecto) AND `sac_meta`.`anio_eje` = :anio AND `sac_meta`.estado_meta = 1 ";
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":anio", $anio);
	// 	$consulta->execute();
	// 	return $consulta->fetchColumn();
	// }
	// public function total_metas_grafica_no_cumplidas($idsProyecto, $anio)
	// {
	// 	global $mbd;
	// 	$sql = "SELECT COUNT(*) FROM `sac_meta` WHERE `sac_meta`.`id_proyecto` IN ($idsProyecto) AND `sac_meta`.`anio_eje` = :anio AND `sac_meta`.estado_meta = 0 ";
	// 	// echo $sql;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":anio", $anio);
	// 	$consulta->execute();
	// 	return $consulta->fetchColumn();
	// }

	public function total_metas_grafica_cumplidas($idsProyecto, $anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM sac_meta 
            WHERE id_proyecto IN ($idsProyecto) 
            AND anio_eje = :anio 
            AND porcentaje_avance >= 100"; // se cumple si el avance es 100 o más
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}

	public function total_metas_grafica_no_cumplidas($idsProyecto, $anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM sac_meta 
            WHERE id_proyecto IN ($idsProyecto) 
            AND anio_eje = :anio 
            AND porcentaje_avance < 100"; // aún no cumplidas
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}

	public function totalmetas($anio)
	{
		global $mbd;
		$sql = "SELECT `sac_meta`.`id_meta`, `sac_meta`.`meta_nombre`, `sac_ejes`.`nombre_ejes`, `sac_ejes`.`id_ejes` FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_proyecto`.`id_proyecto` = `sac_meta`.`id_proyecto` INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_proyecto`.`id_ejes` WHERE `anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function totalmetasporejes($idsProyecto, $anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM `sac_meta` WHERE `sac_meta`.`id_proyecto` IN ($idsProyecto) AND `sac_meta`.`anio_eje` = :anio AND `sac_meta`.estado_meta = 0 ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}


	public function total_tareas_cumplidas_por_eje($id_ejes, $anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM sac_proyecto INNER JOIN sac_meta ON sac_meta.id_proyecto = sac_proyecto.id_proyecto INNER JOIN sac_accion ON sac_meta.id_meta = sac_accion.id_meta INNER JOIN sac_tareas ON sac_accion.id_accion = sac_tareas.id_accion WHERE sac_proyecto.id_ejes = :id_ejes  AND sac_meta.anio_eje = :anio AND sac_tareas.estado_tarea = 1";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}

	public function total_tareas_no_cumplidas_por_eje($id_ejes, $anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM sac_proyecto INNER JOIN sac_meta ON sac_meta.id_proyecto = sac_proyecto.id_proyecto INNER JOIN sac_accion ON sac_meta.id_meta = sac_accion.id_meta INNER JOIN sac_tareas ON sac_accion.id_accion = sac_tareas.id_accion WHERE sac_proyecto.id_ejes = :id_ejes AND sac_meta.anio_eje = :anio AND sac_tareas.estado_tarea = 0";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}

	// tarea
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

	public function insertartarea($nombre_tarea, $fecha_entrega_tarea, $responsable_tarea, $id_accion, $periodo_tarea, $id_meta, $link_evidencia_tarea)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_tareas`(`nombre_tarea`,`fecha_entrega_tarea`,`responsable_tarea`, `id_accion` , `periodo_tarea` , `id_meta` , `link_evidencia_tarea` ) VALUES('$nombre_tarea','$fecha_entrega_tarea', '$responsable_tarea', '$id_accion', '$periodo_tarea', '$id_meta' , '$link_evidencia_tarea')";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
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

	public function selectlistarResponsableTarea()
	{
		$sql = "SELECT * FROM usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
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
	// actualiazmos el porcentaje de avance dependiendo del id_meta
	public function actualizarPorcentajeMeta($id_meta, $porcentaje_avance)
	{
		$sql = "UPDATE `sac_meta` SET `porcentaje_avance` = :porcentaje WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':porcentaje', $porcentaje_avance);
		$consulta->bindParam(':id_meta', $id_meta);
		return $consulta->execute();
	}


	public function promedio_avance_metas_por_eje($idsProyecto, $anio)
	{
		$sql = "SELECT AVG(porcentaje_avance) FROM sac_meta WHERE id_proyecto IN ($idsProyecto)  AND anio_eje = :anio";
		global $mbd;
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}

	public function totaldemetasporanio($id_ejes, $anio)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` WHERE `sac_meta`.`anio_eje` = :anio and`id_ejes` = :id_ejes ORDER BY `nombre_proyecto` ASC";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function selectlistaranios()
	{
		$sql = "SELECT * FROM anios";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	// public function mostrar_tareas($periodo_tarea)
	// {
	// 	global $mbd;
	// 	$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_accion`.`id_meta` = `sac_meta`.`id_meta` INNER JOIN `sac_tareas` ON `sac_tareas`.`id_accion` = `sac_accion`.`id_accion` WHERE `sac_tareas`.`periodo_tarea` LIKE :periodo_tarea ORDER BY `sac_tareas`.`periodo_tarea` DESC";
	// 	$sentencia = $mbd->prepare($sql);
	// 	$sentencia->bindParam(':periodo_tarea', $periodo_tarea);
	// 	$sentencia->execute();
	// 	return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	// }


	// mostramos las tareas 
	public function total_tareas($periodo_tarea)
	{
		global $mbd;
		$sql = "SELECT * FROM sac_tareas  WHERE periodo_tarea LIKE :periodo_tarea ORDER BY periodo_tarea DESC";
		$sentencia = $mbd->prepare($sql);
		$sentencia->bindParam(':periodo_tarea', $periodo_tarea);
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}



	public function mostrar_tareas($periodo_tarea)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_tareas` LEFT JOIN `sac_accion`  ON `sac_accion`.`id_accion` = `sac_tareas`.`id_accion` LEFT JOIN `sac_meta` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` LEFT JOIN `sac_proyecto` ON `sac_proyecto`.`id_proyecto` = `sac_meta`.`id_proyecto` WHERE `sac_tareas`.`periodo_tarea` LIKE :periodo_tarea ORDER BY `sac_tareas`.`periodo_tarea` DESC";


		$sentencia = $mbd->prepare($sql);
		$sentencia->bindParam(':periodo_tarea', $periodo_tarea);
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}


	public function nombre_funcionario($id_usuario)
	{
		global $mbd;
		$sql = "SELECT usuario_nombre, usuario_nombre_2, usuario_apellido, usuario_apellido_2 FROM `usuario` WHERE `id_usuario` = :id_usuario LIMIT 1";
		$stmt = $mbd->prepare($sql);
		$stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC); // una sola fila
	}

	public function obtenerNumeroTareasCumplidas($anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM `sac_tareas` WHERE `estado_tarea` = 1 AND `sac_tareas`.`periodo_tarea` = :anio";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}


	public function obtenerNumeroTareasNoCumplidas($anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM `sac_tareas` WHERE `estado_tarea` = 0 and `sac_tareas`.`periodo_tarea` = :anio";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		return $consulta->fetchColumn();
	}
}
