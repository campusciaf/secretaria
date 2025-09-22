<?php
date_default_timezone_set("America/Bogota");
session_start();
require_once "../modelos/SofiReportePagos.php";
$reporte_pagos = new SofiReportePagos();
$consecutivo = isset($_POST['consecutivo']) ? $_POST['consecutivo'] : "";
$si_no = array("fas fa-times-circle", "fas fa-check-circle");
$si_no_texto = array("No", "Si");
$color = array("text-danger", "text-success");
$tipo_busqueda = isset($_POST['tipo_busqueda']) ? $_POST['tipo_busqueda'] : "";
$dato_busqueda = isset($_POST['dato_busqueda']) ? $_POST['dato_busqueda'] : "";
switch ($_GET["op"]) {
	case 'listar':
		if ($tipo_busqueda == "dia") {
			$inicio = $dato_busqueda["inicio"];
			$fin = $dato_busqueda["fin"];
			$datos = $reporte_pagos->listarPagosPorDia($inicio, $fin);
		} else if ($tipo_busqueda == "consecutivo") {
			$datos = $reporte_pagos->listarPagosPorConsecutivo($dato_busqueda);
		} else if ($tipo_busqueda == "periodo") {
			$datos = $reporte_pagos->listarPagosPorPeriodo($dato_busqueda);
		}
		$data = array();
		for ($i = 0; $i < count($datos); $i++) {
			$yeminus_ok = $datos[$i]["yeminus_ok"];
			$data[] = array(
				"0" => '<div class="text-center">
				<i class="' . $color[$yeminus_ok] . " " . $si_no[$yeminus_ok] . '"></i> '.$si_no_texto[$yeminus_ok].'	
				</div>',
				"1" => '<button class="btn btn-sm btn-outline-primary" onclick="detalletransaccion(' . $datos[$i]["id_pagos"] . ')"> <i class="fas fa-list"></i> ' . $datos[$i]["id_pagos"] . '</button>',
				"2" => explode(" ", $datos[$i]["x_fecha_transaccion"])[0],
				"3" => $datos[$i]["consecutivo"],
				"4" => $datos[$i]["x_amount_base"],
				"5" => $datos[$i]["x_customer_document"],
				"6" => $datos[$i]["x_customer_name"]." ". $datos[$i]["x_customer_lastname"],
				"7" => $datos[$i]["x_customer_movil"],
				"8" => $datos[$i]["x_franchise"],
				"9" => $datos[$i]["x_description"],
				"10" => $datos[$i]["x_respuesta"] == "Aceptada" ? "<span style='color:#B7EC1E'><b>Aceptada</b></span>" : $datos[$i]["x_respuesta"],
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
	case "detalletransaccion":
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$id_pago = $_POST["id_pago"];
		$datos = $reporte_pagos->listarPagosDetalle($id_pago);
		$data["0"] .= '
		<div class="row">
			<div class="col-xl-8">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Detalle de la transacción</h3>
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
											' . $datos["id_persona"] . '
										</span>
									</div>              
								</div>
								<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
									<div class="item">                
										<span class="product-title">Extra2 </span>
										<span class="product-description">
											' . $datos["consecutivo"] . '
										</span>
									</div>              
								</div>
								<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
									<div class="item">                
										<span class="product-title">Extra3</span>
										<span class="product-description">
											' . $datos["tipo_pago"] . '
										</span>
									</div>              
								</div>
							</div>
						</div>
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
		</div>';
		echo json_encode($data);
		break;
}