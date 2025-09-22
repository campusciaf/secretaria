<?php
require_once("../modelos/PagosAgregadorSofi.php");
require_once("../YeminusApi/modelos/Yeminus.php");
$obj_pago = new PagosAgregador();
$yeminus = new Yeminus();
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d H:i:s');
$usuario = "epayco";
//datos de epayco
$x_id_factura = isset($_GET["x_id_factura"]) ? $_GET["x_id_factura"] : ""; // numero de la factura
$x_description = isset($_GET["x_description"]) ? $_GET["x_description"] : ""; // nombre de la compra
$x_amount_base = isset($_GET["x_amount_base"]) ? $_GET["x_amount_base"] : 0; // monto
$x_currency_code = isset($_GET["x_currency_code"]) ? $_GET["x_currency_code"] : "COP"; // tipo de moneda
$x_bank_name = isset($_GET["x_bank_name"]) ? $_GET["x_bank_name"] : ""; // nombre entidad por la que realizo el pago
$x_respuesta = isset($_GET["x_respuesta"]) ? $_GET["x_respuesta"] : ""; // estado del pago
$x_fecha_transaccion = isset($_GET["x_fecha_transaccion"]) ? $_GET["x_fecha_transaccion"] : ""; // fecha del pago
$x_franchise = isset($_GET["x_franchise"]) ? $_GET["x_franchise"] : ""; // franquisia (la entida recaudadora de dinero)
$x_customer_doctype = isset($_GET["x_customer_doctype"]) ? $_GET["x_customer_doctype"] : "CC"; // tipo documento
$x_customer_document = isset($_GET["x_customer_document"]) ? $_GET["x_customer_document"] : ""; // documento
$x_customer_name = isset($_GET["x_customer_name"]) ? $_GET["x_customer_name"] : ""; // nombre
$x_customer_lastname = isset($_GET["x_customer_lastname"]) ? $_GET["x_customer_lastname"] : ""; // apellido
$x_customer_email = isset($_GET["x_customer_email"]) ? $_GET["x_customer_email"] : ""; //correo
$x_customer_phone = isset($_GET["x_customer_phone"]) ? $_GET["x_customer_phone"] : ""; // telefono fijo
$x_customer_movil = isset($_GET["x_customer_movil"]) ? $_GET["x_customer_movil"] : ""; // celular
$x_customer_ind_pais = isset($_GET["x_customer_ind_pais"]) ? $_GET["x_customer_ind_pais"] : null; // pais
$x_customer_country = isset($_GET["x_customer_country"]) ? $_GET["x_customer_country"] : "CO"; //indicativo del pais
$x_customer_city = isset($_GET["x_customer_city"]) ? $_GET["x_customer_city"] : "N/A"; // ciudad
$x_customer_address = isset($_GET["x_customer_address"]) ? $_GET["x_customer_address"] : "N/A"; //dirección
$x_customer_ip = isset($_GET["x_customer_ip"]) ? $_GET["x_customer_ip"] : ""; // ip del pago
//datos para sofi
$id_persona = isset($_GET["x_extra1"]) ? $_GET["x_extra1"] : ""; // trae la cédula del estudiante
$consecutivo = isset($_GET["x_extra2"]) ? $_GET["x_extra2"] : ""; // trae la cédula del estudiante
$tipo_pago = isset($_GET["x_extra3"]) ? $_GET["x_extra3"] : ""; // trae el ciclo del estudiante
//datos para Yeminus
$forma_pago_yeminus = isset($_GET["x_extra5"]) ? $_GET["x_extra5"] : ""; // Forma de pago para yeminus
$cuenta_contable_yeminus = isset($_GET["x_extra6"]) ? $_GET["x_extra6"] : ""; // cuenta contable para yeminus
$prefijo_yeminus = isset($_GET["x_extra7"]) ? $_GET["x_extra7"] : ""; // Prefijo para yeminus
$tipoDocumento_yeminus = isset($_GET["x_extra8"]) ? $_GET["x_extra8"] : ""; // tipo documento para yeminus
$documento_yeminus = isset($_GET["x_extra9"]) ? $_GET["x_extra9"] : ""; // documento para yeminus
$interes_total = isset($_GET["x_extra10"]) ? $_GET["x_extra10"] : ""; // Total de interes moratorio
//insercion en la tabla de pagos de sofi
$stmt = $obj_pago->insertarPagoSofi($x_id_factura, $id_persona, $consecutivo, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $tipo_pago);
$valor_pagar = 0;
$monto_yeminus = 0;
$reporte_tipo_pago = null;
if ($x_respuesta == "Aceptada") {
	$cuota_minima = $obj_pago->consultarCuotaMinima($consecutivo);
	$valor_real_cuota = $cuota_minima["valor_pagar"];
	$numero_cuota = $cuota_minima["numero_cuota"];
	$fecha_pago = $cuota_minima["fecha_pago"];
	$id_financiamiento = $cuota_minima["id_financiamiento"];
	if ($interes_total != 0) {
		$valor_que_pago = $x_amount_base - $interes_total;
		$monto_yeminus = $valor_que_pago;
		$obj_pago->pagarMora($consecutivo, $numero_cuota, $fecha_pago, $interes_total);
	} else {
		$monto_yeminus = $x_amount_base;
		$valor_que_pago = $x_amount_base;
	}
	if ($valor_real_cuota == $valor_que_pago) { //pago parcial
		$rsta = $obj_pago->pagarCuota($id_financiamiento, $consecutivo);
		if ($rsta) {
			$obj_pago->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_que_pago, $id_financiamiento);
			$array = array("exito" => 1, "info" => "Pago realizado con éxito", "consecutivo" => $consecutivo);
		} else {
			$array = array("exito" => 0, "info" => "Error al realizar el Pago");
		}
	} else if ($valor_real_cuota < $valor_que_pago) { //ADELANTO
		$rsta = $obj_pago->consultarCuotasNoPagadasTotales($consecutivo);
		$flag = true;
		for ($i = 0; $i < count($rsta) && $flag == true; $i++) {
			$id_financiamiento = $rsta[$i]["id_financiamiento"];
			$numero_cuota = $rsta[$i]["numero_cuota"];
			$fecha_pago = $rsta[$i]["fecha_pago"];
			$estado = $rsta[$i]["estado"];
			$valor_a_pagar = intval($rsta[$i]["valor_cuota"] - $rsta[$i]["valor_pagado"]);
			if ($valor_a_pagar <= $valor_que_pago) {
				$obj_pago->pagarCuota($id_financiamiento, $consecutivo);
				$obj_pago->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_a_pagar, $id_financiamiento);
				$valor_que_pago = $valor_que_pago - $valor_a_pagar;
			} else {
				$obj_pago->abonarCuota($id_financiamiento, $valor_que_pago);
				$obj_pago->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_que_pago, $id_financiamiento);
				$flag = false;
			}
			$array = array("exito" => 1, "info" => "Adelanto realizado con éxito", "consecutivo" => $consecutivo);
		}
	} else if ($valor_real_cuota > $valor_que_pago) { //abono
		$rsta = $obj_pago->abonarCuota($id_financiamiento, $valor_que_pago);
		if ($rsta) {
			$obj_pago->generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_que_pago, $id_financiamiento);
			$array = array("exito" => 1, "info" => "Abono realizado con éxito", "consecutivo" => $consecutivo);
		} else {
			$array = array("exito" => 0, "info" => "Error al realizar el abono");
		}
	}
	// Obtener la fecha y hora actual en formato ISO 8601 con la zona horaria
	$fecha_actual = new DateTime('now', new DateTimeZone('America/Bogota'));
	// Clonar la fecha actual en otra variable
	$fecha_vencimiento = clone $fecha_actual;
	// Añadir 30 días a la fecha futura
	$fecha_vencimiento->modify('+30 days');
	// Obtener las fechas en formato ISO 8601
	$fecha_actual_iso = $fecha_actual->format('c');
	$fecha_vencimiento_iso = $fecha_vencimiento->format('c');
	//documento obligatorio, prefijo y documentoYeminus FV - ELEC 
	$data = array( 
		'recibo' => array(
			'tipoDocumento' => 'RC',
			'prefijo' => 'API',
			'numero' => 0,
			'nitCliente' => $documento_yeminus,
			'centroCosto' => '',
			'fecha' => $fecha_actual_iso,
			"fechaRealPago" => $fecha_actual_iso,
			"fechaLegalizacion" => $fecha_actual_iso,
			"descripcion" => $x_description,
			"valor" => $monto_yeminus,
			"valorNoAplicado" => 0,
			"formaPago" => $forma_pago_yeminus,
			"claseRecibo" => "F",
			"cuentaContableBanco" => $cuenta_contable_yeminus,
			"factorConversion" => 0,
			"caja" => "1",
			"usuario" => "API",
			"abonos" => array(
				array(
					"numero" => "$tipoDocumento_yeminus-$prefijo_yeminus-$consecutivo",
					"tipoDocumento" => $tipoDocumento_yeminus,
					"prefijoDocumento" => $prefijo_yeminus,
					"numeroObligacion" => $consecutivo,
					"fechaVencimiento" => $fecha_vencimiento_iso,
					"noCuota" => 1,
					"valorAbono" => $monto_yeminus,
					"valorOriginal" => $monto_yeminus,
					"clienteCuenta" => "13170101",
					"tipoDcto" => "F",
					"nit" => $documento_yeminus,
					"saldoEnOtrasMonedas" => $monto_yeminus,
					"valorDescuentoFactura" => 0,
					"valorSinImpuestoFactura" => $monto_yeminus,
					"valorConImpuestoFactura" => $monto_yeminus,
					"nombreVendedor" => "CIAF"
				)
			)
		)
	);
	$response = $yeminus->CrearReciboCaja($data);
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	if ($response['esExitoso'] == 1) {
		//echo $x_id_factura;
		$obj_pago->actualizarPagoEpaycoSofi($x_id_factura);
		echo json_encode(array("status" => "OK"));
	} else {
		echo json_encode(array("status" => "$tipoDocumento_yeminus-$prefijo_yeminus-$consecutivo"));
	}
}
if ($stmt) {
	die(json_encode(array("status" => "OK", "info" => "valor_pagar = $valor_pagar, amount_base = $monto_yeminus, tipo_pago = $reporte_tipo_pago")));
} else {
	die(json_encode(array("status" => "ERR")));
}