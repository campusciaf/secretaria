<?php
    require_once("../modelos/PagosAgregadorSofi.php");
    require_once("../YeminusApi/modelos/Yeminus.php");
    $obj_pago = new PagosAgregador();
    $yeminus = new Yeminus();
	date_default_timezone_set("America/Bogota");	
	$fecha = date('Y-m-d H:i:s');
	$usuario = "epayco";
	//datos de epayco
	$x_id_factura = isset($_GET["x_id_factura"])?$_GET["x_id_factura"]:"";// numero de la factura
    $x_description = isset($_GET["x_description"])?$_GET["x_description"]:"";// nombre de la compra
    $x_amount_base = isset($_GET["x_amount_base"])?$_GET["x_amount_base"]:0;// monto
    $monto_yeminus = isset($_GET["x_amount_base"])?$_GET["x_amount_base"]:0;// monto
    $x_currency_code = isset($_GET["x_currency_code"])?$_GET["x_currency_code"]:"COP";// tipo de moneda
    $x_bank_name = isset($_GET["x_bank_name"])?$_GET["x_bank_name"]:"";// nombre entidad por la que realizo el pago
    $x_respuesta = isset($_GET["x_respuesta"])?$_GET["x_respuesta"]:"";// estado del pago
    $x_fecha_transaccion = isset($_GET["x_fecha_transaccion"])?$_GET["x_fecha_transaccion"]:"";// fecha del pago
    $x_franchise = isset($_GET["x_franchise"])?$_GET["x_franchise"]:"";// franquisia (la entida recaudadora de dinero)
    $x_customer_doctype = isset($_GET["x_customer_doctype"])?$_GET["x_customer_doctype"]:"CC";// tipo documento
    $x_customer_document = isset($_GET["x_customer_document"])?$_GET["x_customer_document"]:"";// documento
    $x_customer_name = isset($_GET["x_customer_name"])?$_GET["x_customer_name"]:"";// nombre
    $x_customer_lastname = isset($_GET["x_customer_lastname"])?$_GET["x_customer_lastname"]:""; // apellido
    $x_customer_email = isset($_GET["x_customer_email"])?$_GET["x_customer_email"]:"";//correo
    $x_customer_phone = isset($_GET["x_customer_phone"])?$_GET["x_customer_phone"]:"";// telefono fijo
    $x_customer_movil = isset($_GET["x_customer_movil"])?$_GET["x_customer_movil"]:"";// celular
    $x_customer_ind_pais = isset($_GET["x_customer_ind_pais"])?$_GET["x_customer_ind_pais"]:null;// pais
    $x_customer_country = isset($_GET["x_customer_country"])?$_GET["x_customer_country"]:"CO"; //indicativo del pais
    $x_customer_city = isset($_GET["x_customer_city"])?$_GET["x_customer_city"]:"N/A"; // ciudad
    $x_customer_address = isset($_GET["x_customer_address"])?$_GET["x_customer_address"]:"N/A"; //dirección
    $x_customer_ip = isset($_GET["x_customer_ip"])?$_GET["x_customer_ip"]:""; // ip del pago
	//datos de nuestra base 
	$credencial_id = isset($_GET["x_extra1"])?$_GET["x_extra1"]:"";// trae la credencial del estudiante del estudiante
	$credencial_identificacion = isset($_GET["x_extra2"])?$_GET["x_extra2"]:""; // trae la cédula del estudiante
	$id_conceptos_pago = isset($_GET["x_extra3"])?$_GET["x_extra3"]:""; // trae el concepto de pago a realizar
	//datos para Yeminus
	$forma_pago_yeminus = isset($_GET["x_extra5"]) ? $_GET["x_extra5"] : ""; // Forma de pago para yeminus
	$cuenta_contable_yeminus = isset($_GET["x_extra6"]) ? $_GET["x_extra6"] : ""; // cuenta contable para yeminus
	//insercion en la tabla de pagos de sofi
    $stmt = $obj_pago->insertarPagoSofi($x_id_factura, $id_persona, $consecutivo, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $tipo_pago);
	if($x_respuesta == "Aceptada"){
		
	}
	if ($stmt) {
		die(json_encode(array("status" => "OK", "info" => "valor_pagar = $valor_pagar, amount_base = $monto_yeminus, tipo_pago = $reporte_tipo_pago")));
	} else {
		die(json_encode(array("status" => "ERR")));
	}
?>