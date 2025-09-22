<?php
session_start();
date_default_timezone_set("America/Bogota");
require_once "../modelos/SofiTransacciones.php";
$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('h:i:s');
$sofi_transacciones = new SofiTransacciones();
$dato_busqueda = isset($_POST["dato_busqueda"]) ? $_POST["dato_busqueda"] : "";
$tipo_busqueda = isset($_POST["tipo_busqueda"]) ? $_POST["tipo_busqueda"] : "";
switch ($_GET["op"]) {
	case 'selectPeriodo':
		$rspta = $sofi_transacciones->listarPeriodos();
		echo json_encode($rspta);
		break;
	case 'listar':
		if($tipo_busqueda == "dia"){
			$inicio = $dato_busqueda["inicio"];
			$fin = $dato_busqueda["fin"];
			$datos = $sofi_transacciones->listarPagosPorDia($inicio, $fin);
		}else if($tipo_busqueda == "identificacion"){
			$datos = $sofi_transacciones->listarPagosPorIdentificacion($dato_busqueda);
		}else if ($tipo_busqueda == "periodo") {
			$datos = $sofi_transacciones->listarPagosPorPeriodo($dato_busqueda);
		}
		$data = array();
		for ($i = 0; $i < count($datos); $i++) {
			$id_pagos = $datos[$i]["id_pagos"];
			$x_id_factura = $datos[$i]["x_id_factura"];
			$identificacion_estudiante = $datos[$i]["identificacion_estudiante"];
			$id_estudiante = $datos[$i]["id_estudiante"];
			$x_description = $datos[$i]["x_description"];
			$x_franchise = $datos[$i]["x_franchise"];
			$x_amount_base = $datos[$i]["x_amount_base"];
			$x_currency_code = $datos[$i]["x_currency_code"];
			$x_respuesta = $datos[$i]["x_respuesta"];
			$tiempo_pago = $datos[$i]["tiempo_pago"];
			$identificacion_estudiante = $datos[$i]["identificacion_estudiante"];
			$x_fecha_transaccion = $datos[$i]["x_fecha_transaccion"];
			$semestre_estudiante = $sofi_transacciones->traersemestre($id_estudiante);
			$semestre_estudiante = isset($semestre_estudiante["semestre_estudiante"])? $semestre_estudiante["semestre_estudiante"]:"";
			$data[] = array(
				"0" => '<button class="btn btn-sm btn-outline-primary" onclick="detalletransaccion(' . $id_pagos . ')"> <i class="fas fa-list"></i> ' . $id_pagos . '</button>',
				"1" => $identificacion_estudiante,
				"2" => $x_id_factura,
				"3" => $x_description,
				"4" => $semestre_estudiante,
				"5" => $x_franchise,
				"6" => $x_amount_base,
				"7" => $x_currency_code,
				"8" => $x_respuesta == "Aceptada" ? "<span style='color:#B7EC1E'><b>Aceptada</b></span>" : $x_respuesta,
				"9" => substr(explode(":", $x_fecha_transaccion)[0],0,-3),
				"10" => $tiempo_pago,
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
		$datos = $sofi_transacciones->listarPagosDetalle($id_pago);
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
										' . $datos["identificacion_estudiante"] . '
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
							<div class="products-list product-list-in-card pl-2 pr-2 col-xl-4" style="padding-left:24px !important">			
								<div class="item">                
									<span class="product-title">Extra4</span>
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
					<div class="card-header"><strong>Acciones</strong><small class="d-block cg"> Las siguientes acciones pueden no ser reversibles.</small></div>
					<div class="col-12 p-2">
						<div class="p-2 wc"><button class="btn btn-danger"><i class="fa fa-file-pdf mr-2"> </i> Descargar comprobante</button></div>
					</div>
					<div class="card-footer py-2"><a class="btn btn-link d-block py-3 px-2 text-left" data-dismiss="modal"><i class="fa fa-angle-double-left mr-2"></i> Volver a transacciones</a></div>
				</div>
			</div>
		</div>	';
		echo json_encode($data);
		break;
}