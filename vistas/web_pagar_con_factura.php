<?php
require_once("../modelos/WebPagosPse.php");
require_once("../YeminusApi/modelos/Yeminus.php");
$obj_pago = new PagosPse();
$rsptaperiodo = $obj_pago->periodoactual(); //trae el periodo	
$periodo_pecuniario = $rsptaperiodo["periodo_pecuniario"]; // contiene el perido a matricular

$x_id_factura = isset($_GET["x_id_factura"]) ? $_GET["x_id_factura"] : ""; // numero de la factura
$x_description = isset($_GET["x_description"]) ? $_GET["x_description"] : ""; // nombre de la compra
$x_amount_base = isset($_GET["x_amount_base"]) ? $_GET["x_amount_base"] : 0; // monto
$x_currency_code = isset($_GET["x_currency_code"]) ? $_GET["x_currency_code"] : "COP"; // tipo de moneda
$x_bank_name = isset($_GET["x_bank_name"]) ? $_GET["x_bank_name"] : ""; // nombre entidad por la que realizo el pago
$x_respuesta = isset($_GET["x_respuesta"]) ? $_GET["x_respuesta"] : ""; // estado del pago
$x_fecha_transaccion = isset($_GET["x_fecha_transaccion"]) ? $_GET["x_fecha_transaccion"] : ""; // fecha del pago
$x_franchise = isset($_GET["x_franchise"]) ? $_GET["x_franchise"] : ""; // franquisia (la entida recaudadora de dinero)
$documento = isset($_GET["x_extra1"]) ? $_GET["x_extra1"] : ""; // trae la cédula del estudiante
$nombre_completo = isset($_GET["x_extra2"]) ? $_GET["x_extra2"] : ""; // trae la cédula del estudiante
$celular = isset($_GET["x_extra3"]) ? $_GET["x_extra3"] : ""; // trae el ciclo del estudiante

$numero_factura_yeminus = isset($_GET["x_extra4"]) ? $_GET["x_extra4"] : ""; //Número factura Yeminus
$forma_pago_yeminus = isset($_GET["x_extra5"]) ? $_GET["x_extra5"] : ""; // Forma de pago para yeminus
$cuenta_contable_yeminus = isset($_GET["x_extra6"]) ? $_GET["x_extra6"] : ""; // cuenta contable para yeminus
$prefijo_yeminus = isset($_GET["x_extra7"]) ? $_GET["x_extra7"] : ""; // Prefijo para yeminus
$tipoDocumento_yeminus = isset($_GET["x_extra8"]) ? $_GET["x_extra8"] : ""; // tipo documento para yeminus

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
$tipo_pago = "No Aplica";

$stmt = $obj_pago->insertarPagoPse($x_id_factura, $documento, $nombre_completo, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $celular, $periodo_pecuniario, $numero_factura_yeminus, $tipo_pago);

if ($stmt) {
    if ($x_respuesta == "Aceptada") {
        // Uso de la clase y función
        $yeminus = new Yeminus();
        // Obtener la fecha y hora actual en formato ISO 8601 con la zona horaria
        $fecha_actual = new DateTime('now', new DateTimeZone('America/Bogota'));
        // Clonar la fecha actual en otra variable
        $fecha_vencimiento = clone $fecha_actual;
        // Añadir 30 días a la fecha futura
        $fecha_vencimiento->modify('+30 days');
        // Obtener las fechas en formato ISO 8601
        $fecha_actual_iso = $fecha_actual->format('c');
        $fecha_vencimiento_iso = $fecha_vencimiento->format('c');
        $data = array(
            'recibo' => array(
                'tipoDocumento' => 'RC',
                'prefijo' => 'API',
                'numero' => 0,
                'nitCliente' => $documento,
                'centroCosto' => '',
                'fecha' => $fecha_actual_iso,
                "fechaRealPago" => $fecha_actual_iso,
                "fechaLegalizacion" => $fecha_actual_iso,
                "descripcion" => $x_description,
                "valor" => $x_amount_base,
                "valorNoAplicado" => 0,
                "formaPago" => $forma_pago_yeminus,
                "claseRecibo" => "F",
                "cuentaContableBanco" => $cuenta_contable_yeminus,
                "factorConversion" => 0,
                "caja" => "1",
                "usuario" => "API",
                "abonos" => array(
                    array(
                        "numero" => "$tipoDocumento_yeminus-$prefijo_yeminus-$numero_factura_yeminus",
                        "tipoDocumento" => $tipoDocumento_yeminus,
                        "prefijoDocumento" => $prefijo_yeminus,
                        "numeroObligacion" => $numero_factura_yeminus,
                        "fechaVencimiento" => $fecha_vencimiento_iso,
                        "noCuota" => 1,
                        "saldoActual" => $x_amount_base,
                        "valorAbono" => $x_amount_base,
                        "valorOriginal" => $x_amount_base,
                        "clienteCuenta" => "13170101",
                        "tipoDcto" => "F",
                        "nit" => $documento,
                        "saldoEnOtrasMonedas" => $x_amount_base,
                        "valorDescuentoFactura" => 0,
                        "valorSinImpuestoFactura" => $x_amount_base,
                        "valorConImpuestoFactura" => $x_amount_base,
                        "nombreVendedor" => "CIAF"
                    )
                )
            )
        );
        //echo json_encode($data);
        $response = $yeminus->CrearReciboCaja($data);
        /* echo "<pre>";
        print_r($response);
        echo "</pre>"; */
        if ($response['esExitoso'] == 1) {
            //echo $x_id_factura;
            $obj_pago->actualizarPagoEpayco($x_id_factura);
            echo json_encode(array("status" => "OK"));
        } else {
            echo json_encode(array("status" => "ERR RESPONSE"));
        }
    } else {
        echo json_encode(array("status" => "OK, NO ACEPTADA"));
    }
} else {
    echo json_encode(array("status" => "ERR INSERT"));
}
?>