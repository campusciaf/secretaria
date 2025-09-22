<?php
    require_once("../modelos/PagosAgregadorSofi.php");
    $obj_pago = new PagosAgregador();
	date_default_timezone_set("America/Bogota");	
	$fecha = date('Y-m-d-H:i:s');
	$usuario = "epayco";
	$x_id_factura = isset($_GET["x_id_factura"])?$_GET["x_id_factura"]:"";// numero de la factura
    $x_description = isset($_GET["x_description"])?$_GET["x_description"]:"";// nombre de la compra
    $x_amount_base = isset($_GET["x_amount_base"])?$_GET["x_amount_base"]:0;// monto
    $x_currency_code = isset($_GET["x_currency_code"])?$_GET["x_currency_code"]:"COP";// tipo de moneda
    $x_bank_name = isset($_GET["x_bank_name"])?$_GET["x_bank_name"]:"";// nombre entidad por la que realizo el pago
    $x_respuesta = isset($_GET["x_respuesta"])?$_GET["x_respuesta"]:"";// estado del pago
    $x_fecha_transaccion = isset($_GET["x_fecha_transaccion"])?$_GET["x_fecha_transaccion"]:"";// fecha del pago
    $x_franchise = isset($_GET["x_franchise"])?$_GET["x_franchise"]:"";// franquisia (la entida recaudadora de dinero)
	$id_persona = isset($_GET["x_extra1"])?$_GET["x_extra1"]:"";// trae la cédula del estudiante
	$periodo_pecuniario = isset($_GET["x_extra2"])?$_GET["x_extra2"]:""; // trae el periodo_pecuniario_pecuniario
	$id_estudiante = isset($_GET["x_extra3"])?$_GET["x_extra3"]:"";// trae el ciclo del estudiante
	$semestreamatricular = isset($_GET["x_extra4"])?$_GET["x_extra4"]:"";// trae el ciclo del estudiante
	$id_programa_ac = isset($_GET["x_extra5"])?$_GET["x_extra5"]:"";// trae el ciclo del estudiante
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
    $stmt = $obj_pago->insertarPagoEstudioCredito($x_id_factura, $id_persona, $periodo_pecuniario, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $id_estudiante);
	if($x_respuesta == "Aceptada"){
        
		$obj_pago->preaprobarCredito($id_persona);
        $valor_semestre = $obj_pago->consultarValorSemestre($semestreamatricular, $id_programa_ac, $periodo_pecuniario);
        //obtener el 20% del valor del semestre
        $porcentaje = 0.20;
        $valor_pecuniario = $valor_semestre["valor_pecuniario"];
        echo "valor_pecuniario: $valor_pecuniario <br>";
        $aporte_social = $valor_semestre["aporte_social"];
        //restar aporte social al valor del semestre que viene en porcentaje
        $valor_aporte_social = $valor_pecuniario * ($aporte_social / 100);
        //calcular el valor de la cuota inicial
        $valor_matricula = $valor_pecuniario - $valor_aporte_social;
        $valor_pecuniario = $valor_pecuniario - $valor_aporte_social;
        //tomamos el 20% de valor para agregar al ticket
        $cuota_inicial = $valor_pecuniario * $porcentaje;
        //calcular el valor de financiacion
        $valor_financiacion = $valor_pecuniario - $cuota_inicial;
        //fecha limite de pago 10 dias habiles
        $fecha_limite = date('Y-m-d', strtotime(date("Y-m-d") . ' + 10 days'));
        //generar ticket inicial
        echo "id_estudiante: $id_estudiante <br>
        valor_matricula: $valor_matricula <br>
        cuota_inicial: $cuota_inicial <br>
        Aporte Social: $aporte_social <br>
        valor_financiacion: $valor_financiacion <br>
        fecha_limite: $fecha_limite <br>
        semestreamatricular: $semestreamatricular <br>
        id_persona: $id_persona <br>
        periodo_pecuniario: $periodo_pecuniario <br>
        semestreamatricular: $semestreamatricular <br>
        id_programa_ac: $id_programa_ac";

        $obj_pago->guardarTicket($id_estudiante, round($valor_pecuniario), round($cuota_inicial), round($valor_financiacion), 1, $fecha_limite, $semestreamatricular, $id_persona, 0, NULL);
	}
	if ($stmt) {
		die(json_encode(array("status" => "OK")));
	} else {
		die(json_encode(array("status" => "ERR")));
	}
?>