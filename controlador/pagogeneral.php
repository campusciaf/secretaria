<?php
// Clave para realizar un cifrado que no pueda ser descifrado
$claveSecreta = 'pagos'; 
// Método de cifrado AES-256-CBC
$metodoCifrado = 'aes-256-cbc'; 
session_start();
require_once "../modelos/PagoGeneral.php";
$pagogeneral = new PagoGeneral();
$periodo_actual = $_SESSION['periodo_actual'];
$id_credencial = $_SESSION['id_usuario'];
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d-H:i:s');
switch ($_GET["op"]) {
	case 'listarConceptos':
		$listado = $pagogeneral->listarConceptos();
		for ($i = 0; $i <count($listado) ; $i++) { 
			$listado[$i]["id_conceptos_pago"] = $pagogeneral->cifrar($listado[$i]["id_conceptos_pago"], $claveSecreta, $metodoCifrado);
		}
		echo json_encode($listado);
		break;
	case 'gestionPago':
		$id_conceptos_pago = $_POST["id_conceptos_pago"];
		$id_conceptos_pago = $pagogeneral->descifrar($id_conceptos_pago, $claveSecreta, $metodoCifrado);
		$concepto_pago = $pagogeneral->gestionPago($id_conceptos_pago);
		$concepto_pago["id_conceptos_pago"] = $pagogeneral->cifrar($concepto_pago["id_conceptos_pago"], $claveSecreta, $metodoCifrado);
		echo json_encode($concepto_pago);
		break;
	case 'calcularValor':
		$id_conceptos_pago = $_POST["id_conceptos_pago"];
		$cantidad_productos = $_POST["cantidad_productos"];
		$id_conceptos_pago = $pagogeneral->descifrar($id_conceptos_pago, $claveSecreta, $metodoCifrado);
		$conceptos_pago_valor = intval($concepto_pago["conceptos_pago_valor"]) * $cantidad_productos;  
		echo json_encode(array("conceptos_pago_valor" => $conceptos_pago_valor));
		break;
	case 'mostrarBotonesEpayco':
		$id_conceptos_pago = $_POST["id_conceptos_pago"];
		$id_conceptos_pago = $pagogeneral->descifrar($id_conceptos_pago, $claveSecreta, $metodoCifrado);
		$concepto_pago = $pagogeneral->gestionPago($id_conceptos_pago);
		$conceptos_pago_nombre = $_POST["conceptos_pago_nombre"];
		$cantidad_productos = $_POST["cantidad_productos"];
		$conceptos_pago_valor = intval($concepto_pago["conceptos_pago_valor"]) * $cantidad_productos;  

		$medio_pago = $_POST["medio_pago"];
		$boton_epayco = '';
		if ($medio_pago == "pse") {
			$boton_epayco = '
			<form class="col-12 text-center">
				<script src="https://checkout.epayco.co/checkout.js"
					data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
					class="epayco-button" 
					data-epayco-amount="' . $conceptos_pago_valor . '" 
					data-epayco-tax="0"
					data-epayco-tax-base="' . $conceptos_pago_valor . '"
					data-epayco-name="'.$conceptos_pago_nombre.' - '. $_SESSION["credencial_identificacion"]. '" 
					data-epayco-description="' . $conceptos_pago_nombre . ' - ' . $_SESSION["credencial_identificacion"] . '" 
					data-epayco-extra1="' . $_SESSION["id_usuario"] . '"
					data-epayco-extra2="' . $_SESSION["credencial_identificacion"] . '"
					data-epayco-extra3="' . $id_conceptos_pago . '"
					data-epayco-extra4=""
					data-epayco-extra5="16"
					data-epayco-extra6="11100506"
					data-epayco-currency="cop"    
					data-epayco-country="CO" 
					data-epayco-test="false" 
					data-epayco-external="true" 
					data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
					data-epayco-confirmation="https://ciaf.digital/vistas/pagosagregadorgeneral.php" 
					data-epayco-button="https://ciaf.digital/public/img/btn-enlinea.png"> 
				</script> 
			</form>';
		}else if ($medio_pago == "efectivo") {
			$boton_epayco = '
			<form class="col-12 text-center">
				<script src="https://checkout.epayco.co/checkout.js" 
					data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
					class="epayco-button" 
					data-epayco-amount="' . $conceptos_pago_valor . '" 
					data-epayco-tax="0"
					data-epayco-tax-base="' . $conceptos_pago_valor . '"
					data-epayco-name="' . $conceptos_pago_nombre . ' - ' . $_SESSION["credencial_identificacion"] . '" 
					data-epayco-description="' . $conceptos_pago_nombre . ' - ' . $_SESSION["credencial_identificacion"] . '" 
					data-epayco-extra1="' . $_SESSION["id_usuario"] . '"
					data-epayco-extra2="' . $_SESSION["credencial_identificacion"] . '"
					data-epayco-extra3="' . $id_conceptos_pago . '"
					data-epayco-extra4=""
					data-epayco-extra5="21"
					data-epayco-extra6="11100611"
					data-epayco-currency="cop"    
					data-epayco-country="CO" 
					data-epayco-test="false" 
					data-epayco-external="true"
					data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
					data-epayco-confirmation="https://ciaf.digital/vistas/pagosagregadorgeneral.php" 
					data-epayco-button="https://ciaf.digital/public/img/btn-efectivo.png"> 
				</script> 
			</form>';
		}
		echo json_encode(array("boton_epayco" => $boton_epayco));
		break;
}