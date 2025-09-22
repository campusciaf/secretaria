<?php
require "../config/Conexion.php";
class PagosPse{
	//Implementamos nuestro constructor
	public function __construct(){}
	public function periodoactual(){
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function insertarPagoPse($x_id_factura, $documento, $nombre_completo, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $celular, $periodo, $numero_factura_yeminus, $tiempo_pago){
		global $mbd;
		$sql = "INSERT INTO `web_pagos_pse`(`x_id_factura`, `identificacion_estudiante`, `nombre_completo`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`, `celular`, `periodo`, `yeminus_ok`, `factura_yeminus`, `tiempo_pago`) VALUES(:x_id_factura, :documento, :nombre_completo, :x_description, :x_amount_base, :x_currency_code, :x_bank_name, :x_respuesta, :x_fecha_transaccion, :x_franchise, :x_customer_doctype, :x_customer_document, :x_customer_name, :x_customer_lastname, :x_customer_email, :x_customer_phone, :x_customer_movil, :x_customer_ind_pais, :x_customer_country,  :x_customer_city, :x_customer_address, :x_customer_ip, :celular, :periodo, '0', :numero_factura_yeminus, :tiempo_pago)";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":x_id_factura", $x_id_factura);
		$consulta->bindParam(":documento", $documento);
		$consulta->bindParam(":nombre_completo", $nombre_completo);
		$consulta->bindParam(":x_description", $x_description);
		$consulta->bindParam(":x_amount_base", $x_amount_base);
		$consulta->bindParam(":x_currency_code", $x_currency_code);
		$consulta->bindParam(":x_bank_name", $x_bank_name);
		$consulta->bindParam(":x_respuesta", $x_respuesta);
		$consulta->bindParam(":x_fecha_transaccion", $x_fecha_transaccion);
		$consulta->bindParam(":x_franchise", $x_franchise);
		$consulta->bindParam(":x_customer_doctype", $x_customer_doctype);
		$consulta->bindParam(":x_customer_document", $x_customer_document);
		$consulta->bindParam(":x_customer_name", $x_customer_name);
		$consulta->bindParam(":x_customer_lastname", $x_customer_lastname);
		$consulta->bindParam(":x_customer_email", $x_customer_email);
		$consulta->bindParam(":x_customer_phone", $x_customer_phone);
		$consulta->bindParam(":x_customer_movil", $x_customer_movil);
		$consulta->bindParam(":x_customer_ind_pais", $x_customer_ind_pais);
		$consulta->bindParam(":x_customer_country", $x_customer_country);
		$consulta->bindParam(":x_customer_city", $x_customer_city);
		$consulta->bindParam(":x_customer_address", $x_customer_address);
		$consulta->bindParam(":x_customer_ip", $x_customer_ip);
		$consulta->bindParam(":celular", $celular);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":numero_factura_yeminus", $numero_factura_yeminus);
		$consulta->bindParam(":tiempo_pago", $tiempo_pago);
		return $consulta->execute();
	}
	public function actualizarPagoEpayco($x_id_factura){
		$sql = "UPDATE `web_pagos_pse` SET `yeminus_ok` = '1' WHERE `x_id_factura` = :x_id_factura";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":x_id_factura", $x_id_factura);
		return $consulta->execute();
	}
}

?>