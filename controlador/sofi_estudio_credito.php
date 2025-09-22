<?php
session_start();
date_default_timezone_set("America/Bogota");
require_once "../modelos/SofiEstudioCredito.php";
require_once "../Datacredito_Api/funciones.php";
//require_once "../YeminusApi/modelos/Yeminus.php";
$fecha = date('Y-m-d');
//objeto de calse sofi
$sofi_estudio = new SofiTransacciones();
$datacredito_api = new DatacreditoApi();
//objeto de calse yeminus
//$yeminus = new Yeminus();
//periodo enviado desde el post
$periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
//periodo actual si no hay periodo seleccionad
$periodo = empty($periodo) ? $_SESSION['periodo_actual'] : $periodo;
//dependiendo del tiempo en que paga es el codigo
$codigo_producto = array("pp-e" => "MA01", "ordinaria-e" => "MA01", "extra-e" => "MA01");
switch ($_GET["op"]) {
	case 'selectPeriodo':
		$rspta = $sofi_estudio->listarPeriodos();
		echo json_encode($rspta);
		break;
	case 'listarPrecioIngles':
		$rspta = $sofi_estudio->listarPrecioIngles();
		echo json_encode($rspta);
		break;
	case 'selectPrograma':
		$rspta = $sofi_estudio->selectPrograma();
		echo json_encode($rspta);
		break;
	case 'traerProgramasEstudiante':
		$identificacion = isset($_POST["numero_documento"]) ? $_POST["numero_documento"] : "";
		$periodo_pecuniario = isset($_POST["periodo_pecuniario"]) ? $_POST["periodo_pecuniario"] : "";
		$rspta = $sofi_estudio->traerProgramasEstudiante($identificacion, $periodo_pecuniario);
		if (count($rspta) > 0) {
			echo json_encode($rspta);
		} else {
			$rspta = $sofi_estudio->selectPrograma();
			echo json_encode($rspta);
		}
		break;
	case 'listar':
		$datos_estudiante = $sofi_estudio->listarSolicitudesPendientes($periodo);
		$data = array();
		for ($i = 0; $i < count($datos_estudiante); $i++) {
			$datos = $sofi_estudio->listarPagosEstudio($datos_estudiante[$i]["id_persona"]);
			$id_estudiante = '';
			$id_pagos = '';
			$btn_tarifa = '';
			$btn_aprobar_tarifa = '';
			$factura_yeminus = '';
			$estado = "<span class='text-warning'><b>Pendiente</b></span>";
			if (isset($datos["x_respuesta"]) && $datos["x_respuesta"] == "Aceptada") {
				$id_estudiante = $datos["id_estudiante"];
				$estado = "<span style='color:#B7EC1E'><b>Aceptada</b></span>";
				$id_pagos = '<button class="btn btn-xs btn-outline-warning" onclick="detalletransaccion(' . $datos["id_pagos"] . ')"> <i class="fas fa-list"></i> ' . $datos["id_pagos"] . '</button>';
				$ticket = $sofi_estudio->listarTicketActivo($datos_estudiante[$i]["id_persona"]);
				if (isset($ticket["estado_ticket"])) {
					$factura_yeminus = ($datos_estudiante[$i]["factura_yeminus"] == 0) ? '' : $datos_estudiante[$i]["factura_yeminus"];
					$btn_tarifa = '<button class="btn btn-xs btn-outline-purple" onclick="aprobarTicket(' . $ticket["id_persona"] . ', `' . $factura_yeminus . '`)" title="Aprobar Ticket de pago"><i class="fas fa-check"></i> Ticket</button>';
				} elseif ($datos_estudiante[$i]["estado_ticket"] == 0) {
					$btn_tarifa = '<button class="btn btn-xs btn-outline-success" onclick="generarTicket(' . $datos_estudiante[$i]["id_programa"] . ', ' . $datos_estudiante[$i]["id_persona"] . ', `' . $datos_estudiante[$i]["periodo"] . '`, ' . $id_estudiante . ', ' . $datos_estudiante[$i]["agregar_ingles"] . ')" title="Generar Ticket de pago"><i class="fas fa-money-check-alt"></i></button>';
				} else {
					$factura_yeminus = ($datos_estudiante[$i]["factura_yeminus"] == 0) ? '' : $datos_estudiante[$i]["factura_yeminus"];
					$ticket_datos = $sofi_estudio->traerIdTicket($datos_estudiante[$i]["id_persona"]);
					$btn_tarifa = '<button class="btn btn-xs btn-outline-purple" onclick="detalleTransaccionTicket(' . @$ticket_datos["id_ticket"] . ')"> <i class="fas fa-list"></i> ' . @$ticket_datos["id_ticket"] . '</button>';
				}
			} else {
				$id_programa = ($datos_estudiante[$i]["id_programa"] == 0) ? 1 : $datos_estudiante[$i]["id_programa"];
				$id_estudiante = $sofi_estudio->traerIdEstudiante($datos_estudiante[$i]["numero_documento"], $id_programa);
				$id_estudiante = isset($id_estudiante['id_estudiante']) ? $id_estudiante['id_estudiante'] : 0;
				$btn_tarifa = '<button class="btn btn-xs btn-outline-info" onclick="AprEstudio(' . $datos_estudiante[$i]["id_persona"] . ', ' . $datos_estudiante[$i]["numero_documento"] . ', `' . $datos_estudiante[$i]["periodo"] . '` )" title="Aprobar Estudio"><i class="fas fa-check"></i> Estudio</button>';
			}
			$apellidos = isset($datos_estudiante[$i]["apellidos"]) ? $datos_estudiante[$i]["apellidos"] : "";
			$primer_apellido = explode(" ", $apellidos);
			$primer_apellido = $primer_apellido[0];
			$score_datacredito = $sofi_estudio->verificarScoreDatacredito($datos_estudiante[$i]["numero_documento"]);
			$btn_datacredito = '<div class="score_id_' . $datos_estudiante[$i]["id_persona"] . '">' . (($score_datacredito == 0) ? '<a onclick="mostrarDatosModal(' . $datos_estudiante[$i]["id_persona"] . ', ' . $datos_estudiante[$i]["numero_documento"] . ', `' . ucfirst(strtolower($primer_apellido)) . '`)" class="btn btn-xs btn-outline-primary" title="Generar Score" > <i class="fas fa-star"></i> Generar Score </a>' : $score_datacredito) . '</div>';
			$data[] = array(
				"0" => "<div class='col-12 text-center'>$factura_yeminus</div>",
				"1" => '<div class="btn-group" role="group">' . $id_pagos . $btn_tarifa . '</div>',
				"2" => $btn_datacredito,
				"3" => $datos_estudiante[$i]["numero_documento"],
				"4" => ucfirst(strtolower($datos_estudiante[$i]["nombres"])),
				"5" => ucfirst(strtolower($datos_estudiante[$i]["apellidos"])),
				"6" => ($datos_estudiante[$i]["agregar_ingles"])?"Si":"No",
				"7" => $datos_estudiante[$i]["email"],
				"8" => $datos_estudiante[$i]["celular"],
				"9" => $estado
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'guardarTicket':
		$id_estudiante = isset($_POST["id_estudiante_credito"]) ? $_POST["id_estudiante_credito"] : "";
		$id_persona = isset($_POST["id_persona_credito"]) ? $_POST["id_persona_credito"] : "";
		$valor_total = isset($_POST["valor_total"]) ? $_POST["valor_total"] : "";
		$valor_ticket = isset($_POST["valor_ticket"]) ? $_POST["valor_ticket"] : "";
		$valor_financiacion = isset($_POST["valor_financiacion"]) ? $_POST["valor_financiacion"] : "";
		$tipo_pago = isset($_POST["tipo_pago"]) ? $_POST["tipo_pago"] : "";
		$fecha_limite = isset($_POST["fecha_limite"]) ? $_POST["fecha_limite"] : "";
		$ticket_semestre = isset($_POST["ticket_semestre"]) ? $_POST["ticket_semestre"] : "";
		$porcentaje_descuento = isset($_POST["porcentaje_descuento"]) ? $_POST["porcentaje_descuento"] : "";
		$tiempo_pago = isset($_POST["tiempo_pago"]) ? $_POST["tiempo_pago"] : "";
		$stmt = $sofi_estudio->guardarTicket($id_estudiante, $valor_total, $valor_ticket, $valor_financiacion, $tipo_pago, $fecha_limite, $ticket_semestre, $id_persona, $porcentaje_descuento, $tiempo_pago);
		if ($stmt) {
			$informacion_estudiante = $sofi_estudio->traerCedulaEstudiante($id_persona);
			$identificacion_estudiante = $informacion_estudiante["numero_documento"];
			$programa_matriculado = $informacion_estudiante["nombre"];
			$centro_costo_yeminus = $informacion_estudiante["centro_costo_yeminus"];
			$data = array("exito" => 1, "info" => "<i class='fas fa-check text-success'></i> Ticket generado con exito <br> ");
			$sofi_estudio->cambiarEstadoEstudio($id_persona);
		} else {
			$data = array("exito" => 0, "info" => "<i class='fas fa-times text-danger'></i> Error al generar ticket <br>");
		}
		echo json_encode($data);
		break;
	case 'guardarTicketAprobado':
		$id_ticket = isset($_POST["id_ticket"]) ? $_POST["id_ticket"] : "";
		$id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : "";
		$id_estudiante = isset($_POST["id_estudiante"]) ? $_POST["id_estudiante"] : "";
		$valor_ticket = isset($_POST["valor_ticket"]) ? $_POST["valor_ticket"] : "";
		$factura_yeminus = isset($_POST["factura_yeminus"]) ? $_POST["factura_yeminus"] : "";
		$cuenta_contable_yeminus = isset($_POST["cuenta_contable"]) ? $_POST["cuenta_contable"] : "";
		$informacion_estudiante = $sofi_estudio->traerCedulaEstudiante($id_persona);
		$identificacion_estudiante = @$informacion_estudiante["numero_documento"];
		$programa_matriculado = @$informacion_estudiante["nombre"];
		$centro_costo_yeminus = @$informacion_estudiante["centro_costo_yeminus"];
		$periodo_pecuniario = @$informacion_estudiante["periodo"];
		$forma_pago_yeminus = ($cuenta_contable_yeminus == 11100611) ? 21 : 16;
		$informacion_ticket = $sofi_estudio->mostrarTicket($id_ticket);
		$tiempo_pago = @$informacion_ticket["tiempo_pago"];
		$tipo_matricula = @$informacion_ticket["tipo_pago"];
		$ticket_semestre = @$informacion_ticket["ticket_semestre"];
		$stmt_id = $sofi_estudio->guardarTicketAprobado($id_estudiante, $valor_ticket, $programa_matriculado, $identificacion_estudiante, $tiempo_pago, $periodo_pecuniario, $tipo_matricula, $ticket_semestre, "Administrativa");
		if ($stmt_id) {
			// Obtener la fecha y hora actual en formato ISO 8601 con la zona horaria
			$fecha_actual = new DateTime('now', new DateTimeZone('America/Bogota'));
			// Clonar la fecha actual en otra variable
			$fecha_vencimiento = clone $fecha_actual;
			// Añadir 30 días a la fecha futura
			$fecha_vencimiento->modify('+30 days');
			// Obtener las fechas en formato ISO 8601
			$fecha_actual_iso = $fecha_actual->format('c');
			$fecha_vencimiento_iso = $fecha_vencimiento->format('c');
			//sacamos el NUMERO de la factura
			$numero_factura_yeminus = @explode("-", $factura_yeminus)[2];
			$sofi_estudio->ActualizarTicket($id_persona, $id_ticket);
			$data = array("exito" => 1, "info" => "<i class='fas fa-check text-success'></i> Ticket aprobado con exito <br>");
			/* //data informacion
			$data_recibo_caja = array(
				'recibo' => array(
					'tipoDocumento' => 'RC',
					'prefijo' => 'API',
					'numero' => 0,
					'nitCliente' => $identificacion_estudiante,
					'centroCosto' => '',
					'fecha' => $fecha_actual_iso,
					"fechaRealPago" => $fecha_actual_iso,
					"fechaLegalizacion" => $fecha_actual_iso,
					"descripcion" => "Ticket financiación $programa_matriculado",
					"valor" => $valor_ticket,
					"valorNoAplicado" => 0,
					"formaPago" => $forma_pago_yeminus,
					"claseRecibo" => "F",
					"cuentaContableBanco" => $cuenta_contable_yeminus,
					"factorConversion" => 0,
					"caja" => "1",
					"usuario" => "API",
					"abonos" => array(
						array(
							"numero" => "$factura_yeminus",
							"tipoDocumento" => "FV",
							"prefijoDocumento" => "ELEC",
							"numeroObligacion" => $numero_factura_yeminus,
							"fechaVencimiento" => $fecha_vencimiento_iso,
							"noCuota" => 1,
							"saldoActual" => $valor_ticket,
							"valorAbono" => $valor_ticket,
							"valorOriginal" => $valor_ticket,
							"clienteCuenta" => "13170101",
							"tipoDcto" => "F",
							"nit" => $identificacion_estudiante,
							"saldoEnOtrasMonedas" => $valor_ticket,
							"valorDescuentoFactura" => 0,
							"valorSinImpuestoFactura" => $valor_ticket,
							"valorConImpuestoFactura" => $valor_ticket,
							"nombreVendedor" => "CIAF"
						)
					)
				)
			);
			$response = $yeminus->CrearReciboCaja($data_recibo_caja);
			if ($response['esExitoso'] == 1) {
				$sofi_estudio->ActualizarPagoRematricula($stmt_id);
				$sofi_estudio->ActualizarIdPagoTicket($stmt_id, $id_ticket);
				$data["info"] .= "<i class='fas fa-check text-success'></i> Recibo de caja creado <br>";
			}else{
				$data["info"] .= "<i class='fas fa-times text-danger'></i> Error al crear recibo de caja $numero_factura_yeminus (". $response['err_info'].") <br>";
			} */
		} else {
			$data = array("exito" => 0, "info" => "<i class='fas fa-times text-danger'></i> Error al guardar ticket <br>");
		}
		echo json_encode($data);
		break;
	case 'eliminarTicket':
		$id_ticket = isset($_POST["id_ticket"]) ? $_POST["id_ticket"] : "";
		$stmt = $sofi_estudio->eliminarTicket($id_ticket);
		if ($stmt) {
			$data = array("exito" => 1, "info" => "Ticket aprobado con exito");
		} else {
			$data = array("exito" => 0, "info" => "Error al guardar ticket");
		}
		echo json_encode($data);
		break;
	case 'AprobarEstudio':
		$id_persona = isset($_POST["id_persona_estudio"]) ? $_POST["id_persona_estudio"] : "";
		$id_programa = isset($_POST["id_programa_estudio"]) ? $_POST["id_programa_estudio"] : "";
		$numero_documento = isset($_POST["numero_documento_estudio"]) ? $_POST["numero_documento_estudio"] : "";
		$periodo_pecuniario = isset($_POST["periodo_pecuniario_estudio"]) ? $_POST["periodo_pecuniario_estudio"] : "";
		$id_estudiante = $sofi_estudio->traerIdEstudiante($numero_documento, $id_programa);
		$id_estudiante = isset($id_estudiante['id_estudiante']) ? $id_estudiante['id_estudiante'] : 0;
		$stmt = $sofi_estudio->AprobarEstudio($id_persona, $periodo_pecuniario, $id_estudiante);
		if ($stmt) {
			$data = array("exito" => 1, "info" => "Estudio de credito agregado con exito");
			$sofi_estudio->cambiarProgramaEstudio($id_persona, $id_programa);
		} else {
			$data = array("exito" => 0, "info" => "Error al generar estudio");
		}
		echo json_encode($data);
		break;
	case 'listarTickets':
		$id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : "";
		$factura_yeminus = isset($_POST["factura_yeminus"]) ? $_POST["factura_yeminus"] : "";
		$tickets = $sofi_estudio->listarTickets($id_persona);
		for ($i = 0; $i < count($tickets); $i++) {
			$data[] = array(
				"0" => '<div class="btn-group">
							<button class="btn btn-outline-danger btn-sm" onclick="eliminarTicket(' . $tickets[$i]["id_ticket"] . ')"> <i class="fas fa-trash"></i> </button> 
							<button class="btn btn-outline-warning btn-sm" onclick="mostrarTicket(' . $tickets[$i]["id_ticket"] . ')"> <i class="fas fa-edit"></i> </button> 
							<button class="btn btn-outline-info btn-sm" onclick="guardarTicketAprobado(' . $tickets[$i]["id_ticket"] . ', ' . $tickets[$i]["id_persona"] . ', ' . $tickets[$i]["id_estudiante"] . ', ' . $tickets[$i]["valor_ticket"] . ', `' . $factura_yeminus . '`)"> <i class="fas fa-check"></i> </button> 
						</div>',
				"1" => '$' . number_format($tickets[$i]["valor_ticket"], 0) . '',
				"2" => $tickets[$i]["fecha_limite"],
				"3" => (($tickets[$i]["tipo_pago"] == 1) ? "Completa" : "Media"),
				"4" => $tickets[$i]["ticket_semestre"],
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'precioPrograma':
		$datos_periodo = $sofi_estudio->periodoactual();
		//almacenamos la fecha ordinaria del periodo pecuniario
		$fecha_ordinaria = $datos_periodo["fecha_ordinaria"];
		//almacenamos la fecha extraaordinaria del periodo pecuniario
		$fecha_extraordinaria = $datos_periodo["fecha_extraordinaria"];
		//id programa por post
		$id_programa = isset($_POST["id_programa"]) ? $_POST["id_programa"] : "";
		//agregar ingles
		$agregar_ingles = isset($_POST["agregar_ingles"]) ? $_POST["agregar_ingles"] : "";
		// trae los datos del progama academico del estudiante
		$datosdelprograma = $sofi_estudio->datosPrograma($id_programa);
		//obtener el precio pecuniario del programa 
		$valor_pecuniario = $sofi_estudio->listarPrecioPecuniario($id_programa, $periodo);
		// trae los datos del semestre progama
		$semestresprograma = $datosdelprograma["semestres"];
		//id estudiante por post
		$id_estudiante = isset($_POST["id_estudiante"]) ? $_POST["id_estudiante"] : "";
		if ($id_estudiante != 0) {
			//datos del estudiante
			$rspta = $sofi_estudio->campusDatosEstudiante($id_estudiante);
			//Semestre del programa
			$semestre_estudiante = $rspta["semestre_estudiante"];
		} else {
			$semestre_estudiante = 1;
		}
		//periodo solicitud
		$periodo = isset($_POST["periodo"]) ? $_POST["periodo"] : "";
		// si el semetre del estudiante es igual a la cantidad de semestres del programa, lo deja en el mismo semestre
		if ($semestresprograma == $semestre_estudiante) {
			//el semestre a matricular toma el valor del total de semestres del programa
			$semestrematricular = $semestresprograma;
		} else {
			//el semestre a matricular toma el valor del semestre actual del estudiante mas uno
			$semestrematricular = $semestre_estudiante + 1;
		}
		//traer los precios del programa
		$tablaprecios = $sofi_estudio->tablaprecios($id_programa, $periodo, $semestrematricular);
		$matricula_ordinaria = isset($tablaprecios["matricula_ordinaria"]) ? $tablaprecios["matricula_ordinaria"] : 0;
		$matricula_extra_ordinaria = isset($tablaprecios["matricula_extraordinaria"]) ? $tablaprecios["matricula_extraordinaria"] : 0;
		$aporte_social = isset($tablaprecios["aporte_social"]) ? $tablaprecios["aporte_social"] : 0;
		$valor_aporte = round((@$valor_pecuniario * $aporte_social) / 100);
		$valor_credito = ($fecha <= $fecha_ordinaria) ? $matricula_ordinaria : $matricula_extra_ordinaria;
		$datos = array("valor_credito" => $valor_credito, "semestrematricular" => $semestrematricular, "valor_pecuniario" => $valor_pecuniario, "valor_aporte" => $valor_aporte);
		echo json_encode($datos);
		break;
	case "detalletransaccion":
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$id_pago = $_POST["id_pago"];
		$datos = $sofi_estudio->listarPagosDetalle($id_pago);
		$data["0"] .= '
		<div class="row">
			<div class="col-xl-8">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Detalle de la transacción <b>ESTUDIO DE CRÉDITO</b></h3>
						<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body p-0" style="display: block;">
						<div class="row">
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Ref.Payco</span>
								<span class="product-description">
									' . $datos["x_id_factura"] . '
								</span>
							</div>              
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Valor Total</span>
								<span class="product-description">
									$' . number_format($datos["x_amount_base"], 2) . ' ' . $datos["x_currency_code"] . '
								</span>
							</div>              
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Estado</span>
								<span class="product-description">
									' . $datos["x_respuesta"] . '
								</span>
							</div>              
							</div>
							<div class="css-1a5jqy3" style="width: 96%; border-top: 2px dotted rgb(228, 228, 228);margin:auto"></div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Factura</span>
								<span class="product-description">
									' . $datos["x_id_factura"] . '
								</span>
							</div>              
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">IVA</span>
								<span class="product-description">
									$0 ' . $datos["x_currency_code"] . '
								</span>
							</div>              
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Fecha Transacción</span>
								<span class="product-description">
									' . $datos["x_fecha_transaccion"] . '
								</span>
							</div>              
							</div>
							<div class="css-1a5jqy3" style="width: 96%; border-top: 2px dotted rgb(228, 228, 228);margin:auto"></div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-12" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Descripción Compra</span>
								<span class="product-description">
									' . $datos["x_description"] . '
								</span>
							</div>              
							</div>
							<div class="css-1a5jqy3" style="width: 96%; border-top: 2px dotted rgb(228, 228, 228);margin:auto"></div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">IP Transacción</span>
								<span class="product-description">
									' . $datos["x_customer_ip"] . '
								</span>
							</div>              
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Franquicia / Medio de Pago</span>
								<span class="product-description">
									' . $datos["x_franchise"] . '
								</span>
							</div>              
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Banco</span>
								<span class="product-description">
									' . $datos["x_bank_name"] . '
								</span>
							</div>              
							</div>
							<div class="css-1a5jqy3" style="width: 96%; border-top: 2px dotted rgb(228, 228, 228);margin:auto"></div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Extra1</span>
								<span class="product-description">
									' . $datos["numero_documento"] . '
								</span>
							</div>              
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
							<div class="item">                
								<span class="product-title">Extra2 </span>
								<span class="product-description">
									' . $datos["id_estudiante"] . '
								</span>
							</div>              
							</div> 
						</div>
					</div><!-- /.card-body -->
					</div>
				</div>
				<div class="col-xl-4">
				<div class="wc card bgb">
					<div class="card-header"><strong>Acciones</strong><small class="d-block cg"> Las siguientes acciones pueden no ser reversibles.</small></div>
					<div class="col-12 p-2">
						<div class="p-2 wc"><button class="btn btn-danger"><i class="fa fa-file-pdf mr-2"> </i> Descargar comprobante</button></div>
					</div>
					<div class="card-footer py-2"><a class="btn btn-link d-block py-3 px-2 text-left" data-dismiss="modal"><i class="fa fa-angle-double-left mr-2"></i> Volver a transacciones</a></div>
				</div>
				</div>
			</div>	
		';
		echo json_encode($data);
		break;
	case "detalleTransaccionTicket":
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$id_pagos = $_POST["id_pagos"];
		$datos = $sofi_estudio->detalleTransaccionTicket($id_pagos);
		$data["0"] .= '
		<div class="row">
			<div class="col-xl-8">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Detalle de la transacción <b>TICKET</b></h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body p-0" style="display: block;">
						<div class="row">
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Ref.Payco</span>
									<span class="product-description">
										' . $datos["x_id_factura"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Valor Total</span>
									<span class="product-description">
										$' . number_format($datos["x_amount_base"], 2) . ' ' . $datos["x_currency_code"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Estado</span>
									<span class="product-description">
										' . $datos["x_respuesta"] . '
									</span>
								</div>
							</div>
							<div class="css-1a5jqy3" style="width: 96%; border-top: 2px dotted rgb(228, 228, 228);margin:auto">
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Factura</span>
									<span class="product-description">
										' . $datos["x_id_factura"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">IVA</span>
									<span class="product-description">
										$0 ' . $datos["x_currency_code"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Fecha Transacción</span>
									<span class="product-description">
										' . $datos["x_fecha_transaccion"] . '
									</span>
								</div>
							</div>
							<div class="css-1a5jqy3" style="width: 96%; border-top: 2px dotted rgb(228, 228, 228);margin:auto">
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-12"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Descripción Compra</span>
									<span class="product-description">
										' . $datos["x_description"] . '
									</span>
								</div>
							</div>
							<div class="css-1a5jqy3" style="width: 96%; border-top: 2px dotted rgb(228, 228, 228);margin:auto">
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">IP Transacción</span>
									<span class="product-description">
										' . $datos["x_customer_ip"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Franquicia / Medio de Pago</span>
									<span class="product-description">
										' . $datos["x_franchise"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Banco</span>
									<span class="product-description">
										' . $datos["x_bank_name"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">id Estudiante </span>
									<span class="product-description">
										' . $datos["id_estudiante"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">tipo matrícula </span>
									<span class="product-description">
										' . (($datos["matricula"] == 1) ? "Completa" : "Media") . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Semestre </span>
									<span class="product-description">
										' . $datos["semestre"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Realiza el proceso </span>
									<span class="product-description">
										' . $datos["realiza_proceso"] . '
									</span>
								</div>
							</div>
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4"
								style="padding-left:24px !important">
								<div class="item">
									<span class="product-title">Tiempo de pago </span>
									<span class="product-description">
										' . $datos["tiempo_pago"] . '
									</span>
								</div>
							</div>
						</div>
					</div><!-- /.card-body -->
				</div>
			</div>
			<div class="col-xl-4">
				<div class="wc card bgb">
					<div class="card-header">
						<strong>Acciones</strong>
						<small class="d-block cg"> Las siguientes acciones pueden no ser reversibles.</small>
					</div>
					<div class="col-12 p-2">
						<div class="p-2 wc">
							<button class="btn btn-danger"><i class="fa fa-file-pdf mr-2"> </i> Descargar comprobante</button>
						</div>
					</div>
					<div class="card-footer py-2"><a class="btn btn-link d-block py-3 px-2 text-left" data-dismiss="modal">
						<i class="fa fa-angle-double-left mr-2"></i> Volver a transacciones</a>
					</div>
				</div>
			</div>
		</div>';
		echo json_encode($data);
		break;
	case 'mostrarTicket':
		$id_ticket = isset($_POST["id_ticket"]) ? $_POST["id_ticket"] : "";
		$datos_ticket = $sofi_estudio->mostrarTicket($id_ticket);
		echo json_encode($datos_ticket);
		break;
	case 'editarTicket':
		$id_ticket = isset($_POST["id_ticket"]) ? $_POST["id_ticket"] : "";
		$valor_total = isset($_POST["valor_total"]) ? $_POST["valor_total"] : "";
		$valor_ticket = isset($_POST["valor_ticket"]) ? $_POST["valor_ticket"] : "";
		$valor_financiacion = isset($_POST["valor_financiacion"]) ? $_POST["valor_financiacion"] : "";
		$tipo_pago = isset($_POST["tipo_pago"]) ? $_POST["tipo_pago"] : "";
		$fecha_limite = isset($_POST["fecha_limite"]) ? $_POST["fecha_limite"] : "";
		$porcentaje_descuento = isset($_POST["porcentaje_descuento"]) ? $_POST["porcentaje_descuento"] : "";
		$tiempo_pago = isset($_POST["tiempo_pago"]) ? $_POST["tiempo_pago"] : "";
		$stmt = $sofi_estudio->editarTicket($id_ticket, $valor_total, $valor_ticket, $valor_financiacion, $tipo_pago, $fecha_limite, $porcentaje_descuento, $tiempo_pago);
		if ($stmt) {
			$data = array("exito" => 1, "info" => "Ticket Editado");
		} else {
			$data = array("exito" => 0, "info" => "Error al editar ticket");
		}
		echo json_encode($data);
		break;
	case 'formularioDatacredito':
		$id_persona_score = $_POST["id_persona_score"];
		$datacredito_documento = $_POST["datacredito_documento"];
		$primer_apellido_datacredito = $_POST["primer_apellido_datacredito"];
		// Ejecución del flujo
		$dataToken = $datacredito_api->generarToken();
		if (isset($dataToken['access_token'])) {
			$token_datacredito = $dataToken['access_token'];
			// Consumir servicio con el token generado
			$resultadoServicio = $datacredito_api->consumirServicio($token_datacredito, $datacredito_documento, $primer_apellido_datacredito);
			// Procesar y mostrar los datos clave de la respuesta
			if (isset($resultadoServicio['ReportHDCplus']['productResult']['responseCode'])) {
				$codigo_respuesta = $resultadoServicio['ReportHDCplus']['productResult']['responseCode'];
				if ($codigo_respuesta == "13") {
					$scoreValue = $resultadoServicio['ReportHDCplus']['models'][0]['scoreValue'];
					$sofi_estudio->generarScoreDatacredito($id_persona_score, $datacredito_documento, $primer_apellido_datacredito, $scoreValue);
					echo json_encode(array("exito" => 1, "info" => "Consulta realizada con éxito. Score: " . $scoreValue, "scoreValue" => $scoreValue, "id_persona_score" => $id_persona_score));
				} else if ($codigo_respuesta == "09") {
					echo json_encode(array("exito" => 0, "info" => "El número de identificación enviado no existe en los archivos de validación de la base de datos."));
				} else {
					echo json_encode(array("exito" => 0, "info" => "Error Code#001: El API presenta fallas, informa al area de desarrollo."));
				}
			} else {
				//echo json_encode(array("exito"=> 0, "info" =>"Error Code#002: El API presenta fallas, informa al area de desarrollo."));
				echo json_encode(array("exito" => 0, "info" => $resultadoServicio));
			}
		} else {
			echo json_encode(array("exito" => 0, "info" => "Error Code#003: El API presenta fallas al generar credenciales, informa al area de desarrollo."));
		}
		break;
}
