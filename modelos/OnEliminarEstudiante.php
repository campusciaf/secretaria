<?php
require "../config/Conexion.php";
class OnEliminarEstudiante
{
	public function consulta($val)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT * FROM `on_interesados` WHERE $val ");
		// echo $sentencia;
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fechaesp($date)
	{
		if (empty($date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
			// Retornar un valor predeterminado o manejar el error
			return "Fecha no disponible";
		}
		$parts = explode("-", $date, 3);
		if (count($parts) !== 3) {
			// Si la fecha no se puede dividir correctamente en año, mes y día
			return "Formato de fecha incorrecto";
		}
		$year   = $parts[0];
		$month  = (int)$parts[1];  // Convertir a entero para eliminar ceros no significativos
		$day    = (int)$parts[2];
		$days       = array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
		$dayOfWeek  = $days[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))];
		$months = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $dayOfWeek . ", " . $day . " de " . $months[$month] . " de " . $year;
	}
	//Implementamos un método para ver el soporte pruebas
	public function soporteCompromiso($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_compromiso WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function eliminar_soporte_compromiso($id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare("DELETE FROM `on_soporte_compromiso` WHERE `id_compromiso` = :id_estudiante");
		$sentencia->bindParam(":id_estudiante", $id_estudiante);
		return $sentencia->execute();
	}

	//Implementamos un método para ver el soporte pruebas
	public function misoporteProteccionDatos($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_proteccion_datos WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminar_soporte_proteccion_datos($id_proteccion_datos)
	{
		global $mbd;
		$sentencia = $mbd->prepare("DELETE FROM `on_soporte_proteccion_datos` WHERE `id_proteccion_datos` = :id_proteccion_datos");
		$sentencia->bindParam(":id_proteccion_datos", $id_proteccion_datos);
		return $sentencia->execute();
	}
	//Implementamos un método para ver el soporte de la cédula
	public function soporteCedula($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_cedula WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminar_soporte_cc($id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_cedula` WHERE `id_cedula` = :id_estudiante ");
		$sentencia->bindParam(":id_estudiante", $id_estudiante);
		return $sentencia->execute();
	}
	//Implementamos un método para ver el soporte del diploma
	public function soporteDiploma($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_diploma WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminar_soporte_diploma($id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_diploma` WHERE `id_diploma` = :id_estudiante ");
		$sentencia->bindParam(":id_estudiante", $id_estudiante);
		return $sentencia->execute();
	}
	//Implementamos un método para ver el soporte del diploma
	public function soporteActa($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_acta WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminar_soporte_acta($id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_acta` WHERE `id_acta` = :id_estudiante ");
		$sentencia->bindParam(":id_estudiante", $id_estudiante);
		return $sentencia->execute();
	}
	//Implementamos un método para ver el soporte pruebas
	public function soportePrueba($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_prueba WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminar_soporte_prueba($id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_prueba` WHERE `id_prueba` = :id_estudiante ");
		$sentencia->bindParam(":id_estudiante", $id_estudiante);
		return $sentencia->execute();
	}
	//Implementamos un método para ver el soporte de salud
	public function soporteSalud($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_salud WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function eliminar_soporte_salud($id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_salud` WHERE `id_salud` = :id_estudiante ");
		$sentencia->bindParam(":id_estudiante", $id_estudiante);
		return $sentencia->execute();
	}
	public function soporte_inscripcion($id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT * FROM `on_soporte_inscripcion` WHERE `id_estudiante` = $id_estudiante ");
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
	}

	public function eliminar_soporte_inscripcion($id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_inscripcion` WHERE `id_inscripcion` = :id_estudiante ");
		$sentencia->bindParam(":id_estudiante", $id_estudiante);
		return $sentencia->execute();
	}
	// elimina los datos del estudiante en las tablas on_
	public function eliminar($id_estudiante)
	{
		$sql = "DELETE FROM on_interesados WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminarDatos($id_estudiante)
	{
		$sql = "DELETE FROM on_interesados_datos WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
	}
	public function eliminarSeguimiento($id_estudiante)
	{
		$sql = "DELETE FROM on_seguimiento WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
	}
	public function eliminarTareas($id_estudiante)
	{
		$sql = "DELETE FROM on_interesados_tareas_programadas WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		$resultado;
	}
	public function insertarEliminar($id_estudiante, $estado, $fecha, $hora, $id_usuario)
	{
		$sql = "INSERT INTO on_eliminados (id_estudiante,estado,fecha,hora,id_usuario) VALUES ('$id_estudiante','$estado','$fecha','$hora','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
	}

}
