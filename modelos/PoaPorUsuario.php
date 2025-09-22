<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class PoaPorUsuario
{
	//Implementamos nuestro constructor
	public function __construct() {}


	//seleccionamos el cargo 
	public function selectlistarCargo()
	{
		$sql = "SELECT * FROM usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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
	public function listarMetaProyectosPorUsuario($id_proyecto, $globalperidioseleccionado, $id_usuario)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `usuario` ON `sac_meta`.`meta_responsable` = `usuario`.`id_usuario` WHERE `sac_meta`.`id_proyecto` = :id_proyecto AND `sac_meta`.`anio_eje` = :globalperidioseleccionado AND `sac_meta`.`meta_responsable` = :id_usuario";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":globalperidioseleccionado", $globalperidioseleccionado);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
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
	public function saccrearmeta($plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_proyecto, $id_con_ins, $id_con_pro, $id_con_dep, $anio_eje)
	{
		global $mbd;
		//insertar la meta  tipo_indicador
		$sql = "INSERT INTO `sac_meta`(`id_meta`,`plan_mejoramiento`,`meta_nombre`, `meta_fecha`, `id_proyecto`, `meta_responsable`,`anio_eje`) VALUES(NULL,'$plan_mejoramiento','$meta_nombre', '$meta_fecha', '$id_proyecto', '$meta_responsable', '$anio_eje')";
		// echo $sql;
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
			for ($i = 0; $i < count($id_con_dep); $i++) {
				$sql_detalle_4 = "INSERT INTO `sac_meta_con_dep`(`id_con_dep`, `id_meta`) VALUES('" . $id_con_dep[$i] . "', $id_meta)";
				$consulta4 = $mbd->prepare($sql_detalle_4);
				$consulta4->execute();
			}
			return true;
		} else {
			return false;
		}
	}
	//Implementamos unç método para editar registros de la meta
	public function saceditometa($id_meta,$plan_mejoramiento, $meta_nombre, $meta_fecha, $meta_responsable, $id_con_ins, $id_con_pro, $id_con_dep, $anio_eje)
	{
		$sql = "UPDATE `sac_meta` SET `plan_mejoramiento` = '$plan_mejoramiento', `meta_nombre` = '$meta_nombre',  `meta_fecha` = '$meta_fecha', `meta_responsable` = '$meta_responsable', `anio_eje` = '$anio_eje' WHERE `id_meta` = '$id_meta'";
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
			for ($i = 0; $i < count($id_con_dep); $i++) {
				$sql_detalle_3 = "INSERT INTO `sac_meta_con_dep`(`id_con_dep`, `id_meta`) VALUES('" . $id_con_dep[$i] . "', $id_meta)";
				$consulta4 = $mbd->prepare($sql_detalle_3);
				$consulta4->execute();
			}
			return true;
		} else {
			return false;
		}
	}
	public function mostrar_eje_grafico($id_ejes)
	{
		global $mbd;
		// La consulta SQL con marcador de posición para el parámetro
		$sql = "SELECT * FROM `sac_proyecto` WHERE id_ejes = :id_ejes";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function total_metas_grafica_cumplidas($idsProyecto, $anio, $id_usuario)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM `sac_meta` WHERE `sac_meta`.`id_proyecto` IN ($idsProyecto) AND `sac_meta`.`anio_eje` = :anio AND `sac_meta`.`meta_responsable` = :id_usuario AND `sac_meta`.`estado_meta` = 1";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		return $consulta->fetchColumn();
	}
	public function total_metas_grafica_no_cumplidas($idsProyecto, $anio, $id_usuario)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM `sac_meta` WHERE `sac_meta`.`id_proyecto` IN ($idsProyecto) AND `sac_meta`.`anio_eje` = :anio AND `sac_meta`.`meta_responsable` = :id_usuario AND `sac_meta`.estado_meta = 0 ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		return $consulta->fetchColumn();
	}
	public function totalmetasporejes($idsProyecto, $anio, $id_usuario)
	{
		global $mbd;
		$sql = "SELECT COUNT(*) FROM `sac_meta` WHERE `sac_meta`.`id_proyecto` IN ($idsProyecto) AND `sac_meta`.`anio_eje` = :anio AND `sac_meta`.`meta_responsable` = :id_usuario AND `sac_meta`.estado_meta = 0 ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		return $consulta->fetchColumn();
	}
	public function totaldemetas($id_ejes, $anio, $id_usuario)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` WHERE `sac_meta`.`anio_eje` = :anio and`id_ejes` = :id_ejes AND `sac_meta`.`meta_responsable` = :id_usuario ORDER BY `nombre_proyecto` ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->bindParam(":id_usuario", $id_usuario);
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
	public function totalMetasPorProyecto($id_proyecto, $anio, $id_usuario)
	{
		global $mbd;
		$sql = "SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` RIGHT JOIN `usuario` ON `sac_meta`.`meta_responsable` = `usuario`.`id_usuario` WHERE `sac_meta`.`id_proyecto` = :id_proyecto and `sac_meta`.`anio_eje` = :anio and `usuario`.`usuario_condicion` = 1 AND `sac_meta`.`meta_responsable` = :id_usuario";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
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
	public function terminar_accion($id_accion)
	{
		$sql = "UPDATE `sac_accion` SET `accion_estado` = '1' WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		return $consulta->execute();
	}
	public function eliminarmeta($id_meta)
	{
		$sql = "DELETE FROM sac_meta WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
	}
}
