<?php
require_once "../modelos/EstudiantePagosEnLinea.php";
date_default_timezone_set("America/Bogota");
session_start();
$estudiantePagosEnLinea = new EstudiantePagosEnLinea();
$periodo_actual = $_SESSION['periodo_actual'];
switch ($_GET["op"]) {
	case 'listar':
		$color_texto = array("text-success", "text-primary");
		$color_fondo = array("bg-light-green", "bg-light-blue");
		$data["exito"] = 0;
		$html = "";
		$rspta = $estudiantePagosEnLinea->listar();
		//Vamos a declarar un array
		for ($i = 0; $i < count($rspta); $i++) {
			$id_encrypt = $rspta[$i]["id_encrypt"];
			$nombre_pago_en_linea = $rspta[$i]["nombre_pago_en_linea"];
            $precio_pago_en_linea = $rspta[$i]["precio_pago_en_linea"];
            $precio_pago_en_linea = number_format($precio_pago_en_linea, 0, ',', '.');
			$data["exito"] = 1;
			$html .= '
                <div class="col-11 col-sm-11 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                    <div class="col-12 p-3">
                        <div class="shadow-box border-animate" onclick="generarFacturaPago(`' . $id_encrypt . '`)">
                            <div class="card-body p-4 mt-3 mb-3"> 
                                <h2 class="font-weight-normal"> $ '. $precio_pago_en_linea. ' </h2><br>
                                <h4 class="font-weight-normal"> '. $nombre_pago_en_linea.'</h4>
                                <hr>
                                <h5 class="font-weight-normal">
                                    <small> Certificado digital </small>
                                </h5>
                                <h5 class="font-weight-normal">
                                    <small> Insignia por redes sociales </small>
                                </h5>
                                <h5 class="font-weight-normal">
                                    <small> Invitados a ceremonias </small>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>';
		}
		$data["info"] = $html;
		echo json_encode($data);
		break;
	case 'generarFacturaPago':
		$id_usuario = $_SESSION['id_usuario'];
		$nombre_completo = $_SESSION['usuario_nombre'] . " " . $_SESSION['usuario_apellido'];
		$id_encrypt = isset($_POST["id_encrypt"])?$_POST["id_encrypt"]:"";
		$cantidad_semestres = isset($_POST["cantidad_semestres"])?$_POST["cantidad_semestres"]:"";
		$datos_estudiante = $estudiantePagosEnLinea->obtenerDatosEstudiante($id_usuario);
		$datos_pago_en_linea = $estudiantePagosEnLinea->obtenerDatosPagoEnLinea($id_encrypt);
		if(isset($datos_pago_en_linea["id_encrypt"])){
            $valor_transaccion = $cantidad_semestres * $datos_pago_en_linea["precio_pago_en_linea"];
			$data = array(
			"exito" => 1,
			"numero_documento" => $_SESSION['credencial_identificacion'],
			"nombre_completo" => $nombre_completo,
			"valor_transaccion" => number_format($valor_transaccion, 2, '.', ','), // Salida: 12,345.68,
			"nombre_pago_en_linea" => $datos_pago_en_linea["nombre_pago_en_linea"],
			"celular_estudiante" => $datos_estudiante["celular"],
            "requiere_cantidad" => $datos_pago_en_linea["requiere_cantidad"],
			'botones_pago' => '
                    <div class="row my-3">
                        <div class="text-center col-6">
                            <!-- Gateway -->
                            <form>
                                <script src="https://checkout.epayco.co/checkout.js"
                                    data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
                                    class="epayco-button" 
                                    data-epayco-amount="' . $valor_transaccion . '" 
                                    data-epayco-tax="0"
                                    data-epayco-tax-base="' . $valor_transaccion . '"
                                    data-epayco-name="Pago '. $datos_pago_en_linea["nombre_pago_en_linea"].' CC. ' . $_SESSION['credencial_identificacion']. '" 
                                    data-epayco-description="Pago ' . $datos_pago_en_linea["nombre_pago_en_linea"] . ' CC. ' . $_SESSION['credencial_identificacion'] . '" 
                                    data-epayco-extra1="' . $_SESSION['credencial_identificacion'] . '"
                                    data-epayco-extra2="' . $nombre_completo . '"
                                    data-epayco-extra3="' . $datos_estudiante["celular"] . '"
                                    data-epayco-extra4="0"
                                    data-epayco-currency="cop"    
                                    data-epayco-country="CO" 
                                    data-epayco-test="false" 
                                    data-epayco-external="true" 
                                    data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
                                    data-epayco-confirmation="https://ciaf.digital/vistas/web_pagos_pse.php" 
                                    data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp"> 
                                </script> 
                            </form>
                        </div> 
                        <div class="col-6 text-center">
                            <!-- ePayco agregador  -->
                            <form>
                                <script src="https://checkout.epayco.co/checkout.js" 
                                    data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
                                    class="epayco-button" 
                                    data-epayco-amount="' . $valor_transaccion . '" 
                                    data-epayco-tax="0"
                                    data-epayco-tax-base="' . $valor_transaccion . '"
                                    data-epayco-name="Pago ' . $datos_pago_en_linea["nombre_pago_en_linea"] . ' CC. ' . $_SESSION['credencial_identificacion'] . '" 
                                    data-epayco-description="Pago ' . $datos_pago_en_linea["nombre_pago_en_linea"] . ' CC. ' . $_SESSION['credencial_identificacion'] . '" 
                                    data-epayco-extra1="' . $_SESSION['credencial_identificacion'] . '"
                                    data-epayco-extra2="' . $nombre_completo . '"
                                    data-epayco-extra3="' . $datos_estudiante["celular"] . '"
                                    data-epayco-extra4="0"
                                    data-epayco-currency="cop"
                                    data-epayco-country="CO" 
                                    data-epayco-test="false" 
                                    data-epayco-external="true" 
                                    data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
                                    data-epayco-confirmation="https://ciaf.digital/vistas/web_pagos_pse.php" 
                                    data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp">
                                </script> 
                            </form>
                        </div>
                    </div>'
		);
		}else{
			$data = array("exito" => 0, "info" => "El Producto no existe");
		}
		echo json_encode($data);
		break;
    case 'listarCuotaActual':
        $numero_documento = $_SESSION['credencial_identificacion'];
        $creditos_activos = $estudiantePagosEnLinea->creditosActivos($numero_documento);
        $valor_acumulado_cuotas = 0;
        $array["exito"] = 0;
        $array["html"] = "";
        //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
        for ($i = 0; $i < count($creditos_activos); $i++) {
            $array["exito"] = 1;
            $consecutivo = $creditos_activos[$i]["id"];
            $motivo_financiacion = $creditos_activos[$i]["motivo_financiacion"];
            $traer_cuota = $estudiantePagosEnLinea->traerCuotas($consecutivo);
            $flag = true;
            for ($j = 0; $j < count($traer_cuota) && $flag; $j++) {
                $plazo_pago = $traer_cuota[$j]["plazo_pago"];
                $estado = $traer_cuota[$j]["estado"];
                $valor_cuota = $traer_cuota[$j]["valor_cuota"];
                $valor_pagado = $traer_cuota[$j]["valor_pagado"];
                $valor_cuota = $valor_cuota - $valor_pagado;
                $dias_atraso = $estudiantePagosEnLinea->diferenciaFechas(date("Y-m-d"), $plazo_pago);
                $fecha_limite = $estudiantePagosEnLinea->fechaesp($traer_cuota[0]["plazo_pago"]);
                $hoy = date("Y-m-d");
                if (strtotime($hoy) < strtotime($plazo_pago)) {
                    $flag = false;
                } else {
                    $dias_atraso = ($estado == "A Pagar" && strtotime($hoy) >= strtotime($plazo_pago)) ? $dias_atraso : (($estado == "A Pagar" && strtotime($hoy) < strtotime($plazo_pago)) ? "-" . $dias_atraso : 0);
                }
                $valor_acumulado_cuotas += $valor_cuota;
            }
            $formato_cuota = $estudiantePagosEnLinea->formatoDinero($valor_acumulado_cuotas);
            $array["html"] .= '
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                    <form action="#" method="POST" id="formularioCuota">
                        <div class="rounded mb-3 bg-gris">
                        <h6 class="font-weight-normal p-3 mb-0"> <span class="badge bg-success pl-3 pr-3">Activo</span> </h6>  
                            <div class="row no-gutters">
                                <div class="col-md-7">
                                    <div class="card-body pt-1 pb-1">
                                        <h5 class="font-weight-normal mb-3 text-dark"> ' . $motivo_financiacion . ' #' . $consecutivo . ' </h5>
                                        <h4 class="text-dark"> $ ' . $formato_cuota . '</h4>
                                        <h5 class="font-weight-normal mb-3 text-secondary"> <small> Fecha limite de Pago: ' . $fecha_limite . ' </small></h5>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card-body pt-1 ">
                                        <label class="label-pilled">
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="pago_minimo" checked />
                                            <span>Pago Mínimo(cuota)</span>
                                        </label>
                                        <br>
                                        <label class="label-pilled">
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="pago_total" />
                                            <span>Pago Total</span>
                                        </label>
                                        <br>
                                        <label class="label-pilled">
                                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="pago_parcial" />
                                            <span>Otro Valor</span>
                                        </label>
                                        <div class="form-group mb-3 position-relative check-valid div_otro_valor">
                                            <div class="form-floating">
                                                <input type="text" name="otro_valor" id="otro_valor" value="" class="form-control" disabled>
                                                <label>Ingresa el valor</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3 px-3">
                                    <button class="btn bg-morado btn-block text-white" type="submit"> Pagar Cuota </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            ';
        }
        echo json_encode($array);
        break;
}
