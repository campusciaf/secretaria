<?php
require "../config/Conexion.php";
//session_start();
class EstudiantePagosEnLinea{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Implementar un método para listar los certificados expedidos con diploma
	public function listar(){
		$sql = "SELECT * FROM `tipos_pagos_en_linea`;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	function obtenerDatosEstudiante($id_credencial){
		$sql = "SELECT * FROM `estudiantes_datos_personales` WHERE `id_credencial` = :id_credencial;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	function obtenerDatosPagoEnLinea($id_encrypt){
		$sql = "SELECT * FROM `tipos_pagos_en_linea` WHERE `id_encrypt` = :id_encrypt;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_encrypt", $id_encrypt);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function CreditosActivos($numero_documento)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT `sm`.`id`, `sm`.`motivo_financiacion` FROM `sofi_matricula` `sm` INNER JOIN `sofi_persona` `sp` ON `sm`.`id_persona` = `sp`.`id_persona` WHERE `sp`.`numero_documento` = :numero_documento AND `sm`.`credito_finalizado` = 0 ORDER BY `id` DESC;");
		$sentencia->bindParam(':numero_documento', $numero_documento);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function traerCuotas($consecutivo)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND estado != 'Pagado' ORDER BY `plazo_pago` ASC;");
		$sentencia->bindParam(':consecutivo', $consecutivo);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
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
	//Vuelve cualquier int en formato de dinero
	public function formatoDinero($valor)
	{
		$moneda = array(2, ',', '.'); // Peso colombiano 
		return number_format($valor, $moneda[0], $moneda[1], $moneda[2]);
	}
	//devuelve la diferencia entre 2 fechas el formato %A es para devolver en dias
	public function diferenciaFechas($inicial, $final, $formatoDiferencia = '%a')
	{
		$datetime1 = date_create($inicial);
		$datetime2 = date_create($final);
		$intervalo = date_diff($datetime1, $datetime2);
		return $intervalo->format($formatoDiferencia);
	}
}
