<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class SacListarCondicion
{
	//Implementamos nuestro constructor
	public function __construct() {}

	//Implementar un método para listar la ejecucion
	public function mostrarcondicionesprograma()
	{
		global $mbd;
		$sql = "SELECT * FROM `condiciones_programa` WHERE lista='1' ORDER BY `nombre_condicion` ASC";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function contarmetacondicionprograma($id_con_pro, $anio)
	{
		global $mbd;
		$sql = "SELECT `sac_meta`.`id_meta`, `sac_meta_con_pro`.`id_con_pro` FROM `sac_meta` INNER JOIN `sac_meta_con_pro` ON `sac_meta`.`id_meta` = `sac_meta_con_pro`.`id_meta` WHERE `sac_meta_con_pro`.`id_con_pro` = :id_con_pro";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_con_pro", $id_con_pro);
		if ($anio != 0) {
			$consulta->bindParam(":anio", $anio);
		}

		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}


	public function contarmetacondiciontareas($id_con_pro, $anio)
	{
		global $mbd;

		$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` INNER JOIN `sac_tareas` ON `sac_accion`.`id_accion` = `sac_tareas`.`id_accion` INNER JOIN `sac_meta_con_pro` ON `sac_meta`.`id_meta` = `sac_meta_con_pro`.`id_meta` WHERE `sac_meta_con_pro`.`id_con_pro` = :id_con_pro";

		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_con_pro", $id_con_pro, PDO::PARAM_INT);

		if ($anio != 0) {
			$consulta->bindParam(":anio", $anio, PDO::PARAM_INT);
		}

		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function listartareasprograma($id_con_pro, $anio)
	{
		global $mbd;

		$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` INNER JOIN `sac_tareas` ON `sac_accion`.`id_accion` = `sac_tareas`.`id_accion` INNER JOIN `sac_meta_con_pro` ON `sac_meta`.`id_meta` = `sac_meta_con_pro`.`id_meta` WHERE `sac_meta_con_pro`.`id_con_pro` = :id_con_pro";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_con_pro', $id_con_pro);
		if ($anio != 0) {
			$consulta->bindParam(':anio', $anio);
		}
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function contartareasprograma($id_con_pro, $anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(`sac_tareas`.`id_tarea_sac`) AS total_tareas FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` INNER JOIN `sac_tareas` ON `sac_accion`.`id_accion` = `sac_tareas`.`id_accion` INNER JOIN `sac_meta_con_pro` ON `sac_meta`.`id_meta` = `sac_meta_con_pro`.`id_meta` WHERE `sac_meta_con_pro`.`id_con_pro` = :id_con_pro";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_con_pro", $id_con_pro);
		if ($anio != 0) {
			$consulta->bindParam(":anio", $anio);
		}
		$consulta->execute();
		return $consulta->fetch(PDO::FETCH_ASSOC);
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
	public function contaraccionprograma($id_con_pro, $anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(`sac_accion`.`id_meta`) AS total_accion FROM `sac_accion` INNER JOIN `sac_meta_con_pro` ON `sac_accion`.`id_meta` = `sac_meta_con_pro`.`id_meta` INNER JOIN `sac_meta` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` WHERE `sac_meta_con_pro`.`id_con_pro` = :id_con_pro";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_con_pro", $id_con_pro);
		if ($anio != 0) {
			$consulta->bindParam(":anio", $anio);
		}
		$consulta->execute();
		return $consulta->fetch(PDO::FETCH_ASSOC);
	}
	//Implementar un método para listar la ejecucion
	public function mostrarcondicionesinstitucional()
	{
		global $mbd;
		$sql = "SELECT * FROM `condiciones_institucionales` WHERE lista='1' ORDER BY `nombre_condicion` ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function contarcondicioninstitucionalactual($id_con_ins, $anio)
	{
		global $mbd;
		$sql = "SELECT `sac_meta`.`id_meta`, `sac_meta_con_ins`.`id_con_ins` FROM `sac_meta` INNER JOIN `sac_meta_con_ins` ON `sac_meta`.`id_meta` = `sac_meta_con_ins`.`id_meta` WHERE `sac_meta_con_ins`.`id_con_ins` = :id_con_ins";
		// Solo filtramos por año si $anio no es 0
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_con_ins", $id_con_ins);
		if ($anio != 0) {
			$consulta->bindParam(":anio", $anio);
		}
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function contaraccioninstitucional($id_con_ins, $anio)
	{
		global $mbd;

		$sql = "SELECT COUNT(`sac_accion`.`id_meta`) AS total_accion_inst FROM `sac_accion` INNER JOIN `sac_meta_con_ins` ON `sac_accion`.`id_meta` = `sac_meta_con_ins`.`id_meta` INNER JOIN `sac_meta` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` WHERE `sac_meta_con_ins`.`id_con_ins` = :id_con_ins";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_con_ins", $id_con_ins);
		if ($anio != 0) {
			$consulta->bindParam(":anio", $anio);
		}
		$consulta->execute();
		return $consulta->fetch(PDO::FETCH_ASSOC);
	}
	//Implementar un método para listar los registros
	public function listarMetaConPro($id_con_pro, $anio)
	{
		global $mbd;

		$sql = "SELECT `sac_meta`.`meta_nombre`, `sac_meta_con_pro`.`id_con_pro` FROM `sac_meta` INNER JOIN `sac_meta_con_pro` ON `sac_meta`.`id_meta` = `sac_meta_con_pro`.`id_meta` WHERE `sac_meta_con_pro`.`id_con_pro` = :id_con_pro";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_con_pro', $id_con_pro);
		if ($anio != 0) {
			$consulta->bindParam(':anio', $anio);
		}
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	//Implementar un método para listar los registros de accion programa
	public function listaraccionprograma($id_con_pro, $anio)
	{
		global $mbd;

		$sql = "SELECT `sac_accion`.`nombre_accion`, `sac_meta`.`meta_nombre` FROM `sac_accion` INNER JOIN `sac_meta_con_pro` ON `sac_accion`.`id_meta` = `sac_meta_con_pro`.`id_meta` INNER JOIN `sac_meta` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` WHERE `sac_meta_con_pro`.`id_con_pro` = :id_con_pro";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_con_pro', $id_con_pro);
		if ($anio != 0) {
			$consulta->bindParam(':anio', $anio);
		}
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}


	//Implementar un método para listar los registros
	public function listaraccioninstitucion($id_con_ins, $anio)
	{
		global $mbd;

		$sql = "SELECT * FROM `sac_accion` INNER JOIN `sac_meta_con_ins` ON `sac_accion`.`id_meta` = `sac_meta_con_ins`.`id_meta` INNER JOIN `sac_meta` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` WHERE `sac_meta_con_ins`.`id_con_ins` = :id_con_ins";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_con_ins', $id_con_ins);
		if ($anio != 0) {
			$consulta->bindParam(':anio', $anio);
		}
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}


	//Implementar un método para listar los registros
	public function listarMetaConIns($id_con_ins, $anio_actual)
	{
		global $mbd;

		$sql = "SELECT `sac_meta`.`meta_nombre`, `sac_meta_con_ins`.`id_con_ins` FROM `sac_meta` INNER JOIN `sac_meta_con_ins` ON `sac_meta`.`id_meta` = `sac_meta_con_ins`.`id_meta` WHERE `sac_meta_con_ins`.`id_con_ins` = :id_con_ins";
		if ($anio_actual != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_con_ins', $id_con_ins);
		if ($anio_actual != 0) {
			$consulta->bindParam(':anio', $anio_actual);
		}
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}

	public function contarcondicioninstitucional($id_con_ins, $anio_actual)
	{
		global $mbd;

		$sql = "SELECT `sac_meta`.`id_meta`, `sac_meta_con_ins`.`id_con_ins` FROM `sac_meta` INNER JOIN `sac_meta_con_ins` ON `sac_meta`.`id_meta` = `sac_meta_con_ins`.`id_meta` WHERE `sac_meta_con_ins`.`id_con_ins` = :id_con_ins";
		if ($anio_actual != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_con_ins", $id_con_ins);
		if ($anio_actual != 0) {
			$consulta->bindParam(":anio", $anio_actual);
		}
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
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


	public function listaraccioninstituciontareas($id_con_ins, $anio)
	{
		global $mbd;

		$sql = "SELECT * FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` INNER JOIN `sac_tareas` ON `sac_accion`.`id_accion` = `sac_tareas`.`id_accion` INNER JOIN `sac_meta_con_ins` ON `sac_meta`.`id_meta` = `sac_meta_con_ins`.`id_meta` WHERE `sac_meta_con_ins`.`id_con_ins` = :id_con_ins";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_con_ins', $id_con_ins);
		if ($anio != 0) {
			$consulta->bindParam(':anio', $anio);
		}
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}




	public function contaraccioninstitucionaltareas($id_con_ins, $anio)
	{
		global $mbd;
		$sql = "SELECT COUNT(`sac_tareas`.`id_tarea_sac`) AS total_tareas FROM `sac_proyecto` INNER JOIN `sac_meta` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` INNER JOIN `sac_tareas` ON `sac_accion`.`id_accion` = `sac_tareas`.`id_accion` INNER JOIN `sac_meta_con_ins` ON `sac_meta`.`id_meta` = `sac_meta_con_ins`.`id_meta` WHERE `sac_meta_con_ins`.`id_con_ins` = :id_con_ins";
		if ($anio != 0) {
			$sql .= " AND `sac_meta`.`anio_eje` = :anio";
		}
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_con_ins", $id_con_ins);
		if ($anio != 0) {
			$consulta->bindParam(":anio", $anio);
		}
		$consulta->execute();
		return $consulta->fetch(PDO::FETCH_ASSOC);
	}
}
