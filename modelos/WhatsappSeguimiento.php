<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class WhatsappSeguimiento{
	//Implementamos nuestro constructor
	public function __construct() {
	}
	public function periodoactual(){
		$sql = "SELECT * FROM `periodo_actual`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listar($id_usuario, $fecha_desde, $fecha_hasta){
		$sql = "SELECT * FROM `sofi_seguimientos` `sof` INNER JOIN `usuario` `us` ON `sof`.`id_asesor` = `us`.`id_usuario` INNER JOIN `sofi_matricula` `sofma` ON `sofma`.`id_persona` = `sof`.`id_persona` WHERE `sof`.`id_asesor` = :id_usuario AND DATE(`sof`.`created_at`) >= :fecha_desde AND DATE(`sof`.`created_at`) <= :fecha_hasta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":fecha_desde", $fecha_desde);
		$consulta->bindParam(":fecha_hasta", $fecha_hasta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectUsuario(){
		$sql = "SELECT * FROM `usuario` WHERE `usuario_condicion` = 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function fechaesp($date){
		$dia = explode("-", $date, 3);
		$year = $dia[0];
		$month = (string)(int)$dia[1];
		$day = (string)(int)$dia[2];
		$dias = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
	public function datosEstudiante($id_credencial){
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function consultaretiqueta($id_etiqueta){
		$sql = "SELECT * FROM `etiquetas` WHERE `id_etiquetas` = :id_etiqueta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_etiqueta", $id_etiqueta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function datos($fecha_tareas, $motivo){
		$sql = "SELECT * FROM `sofi_seguimientos` WHERE DATE(`created_at`)>= :fecha_tareas AND `seg_tipo`= :motivo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":fecha_tareas", $fecha_tareas);
		$consulta->bindParam(":motivo", $motivo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function traerEtiquetas(){
		$sql = "SELECT * FROM `etiquetas` WHERE `etiqueta_dependencia` = 'Financiera'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function traerSeguiEtiquetas($fecha_tareas, $id_etiqueta){
		$sql = "SELECT * FROM `sofi_seguimientos` `sofs` INNER JOIN `sofi_matricula` `sofm` ON `sofs`.`id_persona` = `sofm`.`id_persona` WHERE `sofs`.`created_at` >= :fecha_tareas AND `sofm`.`id_etiqueta` = :id_etiqueta;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":fecha_tareas", $fecha_tareas);
		$consulta->bindParam(":id_etiqueta", $id_etiqueta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	    //traer el numero de whatsapp estudiantes
		public function traerCelularEstudiante($numero_documento)
		{
			global $mbd;
			$hoy = date("Y-m-d");
			$sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
			$sentencia->bindParam(":numero_documento", $numero_documento);
			$sentencia->execute();
			$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
			return $registro;
		}

		public function obtenerRegistroWhastapp($numero_celular)
		{
			global $mbd;
			$sentencia = $mbd->prepare("SELECT * FROM `whatsapp_registros` WHERE `numero_whatsapp` LIKE :numero_celular ORDER BY `numero_whatsapp` ASC");
			$sentencia->bindParam(':numero_celular', $numero_celular);
			$sentencia->execute();
			$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
			return $registro;
		}

}
