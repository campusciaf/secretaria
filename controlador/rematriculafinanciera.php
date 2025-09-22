<?php
session_start();
require_once "../modelos/RematriculaFinanciera.php";
require_once "../Datacredito_Api/funciones.php";
require_once "../mail/send.php";
require_once "../public/sofi_mail/templatePreAprobado.php";
$rematriculafinanciera = new RematriculaFinanciera();
$datacredito_api = new DatacreditoApi();
$periodo_actual = $_SESSION['periodo_actual'];
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$rsptaperiodo = $rematriculafinanciera->periodoactual(); //trae el periodo	]
$periodo_pecuniario = $rsptaperiodo["periodo_pecuniario"]; // contiene el perido a matricular
$periodo_anterior = $rsptaperiodo["periodo_anterior"]; // contiene el perido anterior
switch ($_GET["op"]) {
	case 'listar':
		//Creamso un array vacio
		$data = array();
		//en la posicion cero del array se encuentra el html a imprimir en cliente
		$data["0"] = '<div class="row ">';
		//Tomamos la credencial del estudiante que esta en sesion
		$id_credencial = $_SESSION['id_usuario'];
		//Listamos todos los programas activos a los que este vinculado el estudiante
		$rspta = $rematriculafinanciera->listar($id_credencial);
		//ciclo de la cantidad de programas
		$valor_pago = "";
		$tiempo_pago = "";
		$respuesta = "";
		for ($i = 0; $i < count($rspta); $i++) {
			/* consulta para saber si elpago es normal o viene de algun nivelatorio 1= normal 0=viene de nivelatorio */
			$pago_renovar = $rspta[$i]["pago_renovar"];
			//tomamos el id del estudiante 
			$id_estudiante = $rspta[$i]["id_estudiante"];
			//echo $id_estudiante;
			//tomamos el id programa del estudiante 
			$id_programa_ac = $rspta[$i]["id_programa_ac"];
			//tomamos el ciclo del estudiante 
			$ciclo = $rspta[$i]["ciclo"];
			//tomamos el periodo activo del estudiante 
			$periodo_activo = $rspta[$i]["periodo_activo"];
			$estadoprograma = $rspta[$i]["estado"];
			//cedula del estudiante
			//$ciclo = "credencial_identificacion";
			// trae los datos del progama academico del estudiante
			$datosdelprograma = $rematriculafinanciera->datosPrograma($id_programa_ac);
			// trae los datos del semestre progama
			$semestresprograma = $datosdelprograma["semestres"]; //variable que contine la cantidad de semestres que tiee el programa
			//variable que contiene si el programa esta activo para descargar soporte 
			$descarga_soporte = $datosdelprograma["descarga_soporte"];
			/***************  ******* */
			//almacenamos la fecha ordinaria del periodo pecuniario
			$fecha_ordinaria_semana = $rsptaperiodo["fecha_ordinaria_semana"];
			$fecha_ordinaria_fds = $rsptaperiodo["fecha_ordinaria_fds"];
			//almacenamos la fecha extraaordinaria del periodo pecuniario
			$fecha_extraordinaria_semana = $rsptaperiodo["fecha_extraordinaria_semana"];
			$fecha_extraordinaria_fds = $rsptaperiodo["fecha_extraordinaria_fds"];
			// consulta para saber si la joranda puede realizar matricula financiera
			$rspta2 = $rematriculafinanciera->listarEstado($rspta[$i]["estado"]);
			//estado de a jornada
			$estado_joranda = $rspta2["estado"];
			//trae los datos basicos del estudiante en la tabla credenciales
			$datos_credencial_estudiante = $rematriculafinanciera->mostrardatos($id_credencial);
			//numero de documento del estudiante
			$identificacion = $datos_credencial_estudiante["credencial_identificacion"];
			/* consulta para traer los valores pecuniarios */
			//verificamos por medio de la jornada del estudiante la para verificar si esta activo el proceso de rematricula
			$verificarjornadaactiva = $rematriculafinanciera->verificarjornadaactiva($rspta[$i]["jornada_e"]);
			//consulta para mirar si la jornada esta activa para rematricula/
			$esta_activa_jornada = $verificarjornadaactiva["rematricula"];
			// cosulta para saber a que grupo pertenece si a fds o semana
			$pertenece = $verificarjornadaactiva["grupo_pecuniario"];
			//quiere decir que el estudiante es de jornada semana
			if ($pertenece == 0) {
				//fecha de descuento referenta a la jornada semana
				$fecha_descuento = $rsptaperiodo["fecha_des_semana"];
				//Sino quiere decir que els estuidante es de jornada FDS
			} else {
				//fecha de descuento referenta a la jornada FDS
				$fecha_descuento = $rsptaperiodo["fecha_des_fds"];
			}
			// fecha actual es menor o igual a la de la base de datos habra descuento por pronto pago
			if ($fecha <= $fecha_descuento) {
				//se muestra el porcentaje de descuento
				$titulodescuento =  'Hoy <span class="fs-20 text-success px-2 rounded-circle font-weight-bolder bg-success py-2"> ' . $rsptaperiodo["descuento"] . '% </span>';
				// fecha actual NO es menor o igual a la de la base de datos SOLO RENOVAR
			} else {
				//no tiene descuento 
				$titulodescuento = "Renovar programa";
			}
			//Nombre del programa
			$programa = $rspta[$i]["fo_programa"];
			//Semestre del programa
			$semestre_estudiante = $rspta[$i]["semestre_estudiante"];
			/* condicional para saber el semestre en que queda el estudiante */
			// si el semetre del estudiante es igual a la cantidad de semestres del programa, lo deja en el mismo semestre
			// si el semestre es el ultimo cursado debe mostar el siguiente nivel el 
				// trae los datos dela tabla sofi persona y sofi matriculas
				$versitienecredito = $rematriculafinanciera->vercreditosofi($identificacion, $periodo_pecuniario);
				@$valortotal = $versitienecredito["valor_total"];
				@$valorfinanciacion = $versitienecredito["valor_financiacion"];
				@$id_persona = $versitienecredito["id_persona"];
				$btn_solicitud_credito = "";
				$btn_estado_credito = "";
				if ($versitienecredito) {
					$btn_estado_credito .= '<a onclick="verestadocredito(' . $id_persona . ')" class="btn btn-info btn-lg text-white col-12" id="t-paso3"><i class="fas fa-eye"></i> Ver estado crédito</a>';
				} else {
					//echo "$identificacion, $periodo_pecuniario, $id_programa_ac";
					$versitienecreditoPendiente = $rematriculafinanciera->vercreditoPendientes($identificacion, $periodo_pecuniario, $id_programa_ac);
					if ($versitienecreditoPendiente) {
						$separar = (explode(" ", $versitienecreditoPendiente["create_dt"]));
						$fecha_solicitud = $separar["0"];
						$fecha_limite_estudio = date('Y-m-d', strtotime($fecha_solicitud . ' + 3 days'));
						$valor_estudio_credito = $rematriculafinanciera->traerValorEstudioCredito();
						$verSiPagoEstudio = $rematriculafinanciera->verSiPagoEstudioCredito($id_estudiante, $periodo_pecuniario);
						if (isset($verSiPagoEstudio["id_pagos"])) {
							$data["0"] .= '
								<div class="row align-items-center pb-4">
									<div class="col-xl-12 col-lg-12 col-md-12 col-12">
										<span class="titulo-2 fs-20 text-semibold"> Pago Estudio de crédito </span> 
										<br> Fecha limite: ' . $rematriculafinanciera->fechaesp($fecha_limite_estudio) . '
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-auto text-right">
										<b>$' . number_format($valor_estudio_credito, 0) . '</b><br>
									</div>
									<div class="col-xl-auto col-lg-auto col-auto text-center">
										<span class="badge bg-success">Pago realizado</span>
									</div>
								</div>';
						} else {
							$data["0"] .= '
								<div class="row align-items-center bg-light-blue pb-4">
									<div class="col-xl-12 col-lg-12 col-md-12 col-12">
										<span class="titulo-2 fs-20 text-semibold"> Pago estudio de crédito </span> 
										<br> Fecha limite: ' . $rematriculafinanciera->fechaesp($fecha_limite_estudio) . '
									</div>
									<div class="col-xl-12 col-lg-12 col-md-12 col-12">
										<span class="fs-48"><b>$' . number_format($valor_estudio_credito, 0) . '</b></span><br>
									</div>
									<div class="col-xl-auto col-lg-auto col-auto">
										<!-- =====================================================================
											///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
											===================================================================== -->
										<form >
											<script src="https://checkout.epayco.co/checkout.js" 
												data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
												class="epayco-button" 
												data-epayco-amount="' . $valor_estudio_credito . '" 
												data-epayco-tax="0"
												data-epayco-tax-base="' . $valor_estudio_credito . '"
												data-epayco-name="Estudio de credito periodo ' . $versitienecreditoPendiente["periodo"] . '" 
												data-epayco-description="Estudio de credito periodo ' . $versitienecreditoPendiente["periodo"] . '" 
												data-epayco-extra1="' . $versitienecreditoPendiente["id_persona"] . '"
												data-epayco-extra2="' . $periodo_pecuniario . '"
												data-epayco-extra3="' . $id_estudiante . '"
												data-epayco-extra4="' . $semestrematricular . '"
												data-epayco-extra5="' . $id_programa_ac . '"
												data-epayco-currency="cop"    
												data-epayco-country="CO" 
												data-epayco-test="false" 
												data-epayco-external="true"
												data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
												data-epayco-confirmation="https://ciaf.digital/vistas/pagosEstudioCredito.php" 
												data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp">
											</script> 
										</form>
									</div> 
									<div class="col-xl-auto col-lg-auto col-auto">
										<!-- ================================================================== -->
										<!-- Gateway -->
										<form>
											<script src="https://checkout.epayco.co/checkout.js"
												data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
												class="epayco-button" 
												data-epayco-amount="' . $valor_estudio_credito . '" 
												data-epayco-tax="0"
												data-epayco-tax-base="' . $valor_estudio_credito . '"
												data-epayco-name="Estudio de credito periodo ' . $versitienecreditoPendiente["periodo"] . '" 
												data-epayco-description="Estudio de credito periodo ' . $versitienecreditoPendiente["periodo"] . '" 
												data-epayco-extra1="' . $versitienecreditoPendiente["id_persona"] . '"
												data-epayco-extra2="' . $periodo_pecuniario . '"
												data-epayco-extra3="' . $id_estudiante . '"
												data-epayco-extra4="' . $semestrematricular . '"
												data-epayco-extra5="' . $id_programa_ac . '"
												data-epayco-currency="cop"    
												data-epayco-country="CO" 
												data-epayco-test="false" 
												data-epayco-external="true"
												data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
												data-epayco-confirmation="https://ciaf.digital/vistas/pagosEstudioCredito.php" 
												data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp"> 
											</script> 
										</form>
									</div>
									</div>
								</div>';
						}
					}
					$verTicketAbierto = $rematriculafinanciera->verTicketAbierto($id_estudiante);
					if ($verTicketAbierto) {
						if ($verTicketAbierto["fecha_limite"] >= date("Y-m-d")) {
							$valor_ticket = $verTicketAbierto["valor_ticket"];
							$id_ticket = $verTicketAbierto["id_ticket"];
							$data["0"] .= '
									<div class="row align-items-center bg-light-blue py-4 px-2">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<span class="titulo-2 fs-20 text-semibold"> Pagar cuota inicial   </span> 
											<br> Fecha limite: ' . $rematriculafinanciera->fechaesp($verTicketAbierto["fecha_limite"]) . '
										</div>
										<div class="col-xl-8 col-lg-12 col-md-8 col-8">
											<span class="fs-48"><b>$' . number_format($verTicketAbierto["valor_ticket"], 0) . '</b></span><br>
										</div>
										<div class="col-xl-4 col-lg-4 col-md-4 col-4"> 
											<button class="btn btn-info btn-sm" onclick="abrirModificarTicket(' . $id_ticket . ', '. $valor_ticket.')"> <i class="fas fa-pencil"></i> Nuevo valor </button>
										</div>
										<div class="col-xl-auto col-lg-auto col-auto">
											<!-- ==================================================================
												///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
												===================================================================== -->
											<form>
												<script src="https://checkout.epayco.co/checkout.js" 
													data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
													class="epayco-button" 
													data-epayco-amount="' . $verTicketAbierto["valor_ticket"] . '" 
													data-epayco-tax="0"
													data-epayco-tax-base="' . $verTicketAbierto["valor_ticket"] . '"
													data-epayco-name="Ticket pago crédito ' . $verTicketAbierto["id_persona"] . '" 
													data-epayco-description="Ticket pago crédito ' . $verTicketAbierto["id_persona"] . '" 
													data-epayco-extra1="' . $verTicketAbierto["id_persona"] . '"
													data-epayco-extra2="' . $verTicketAbierto["id_ticket"] . '"
													data-epayco-extra3="' . $id_estudiante . '"
													data-epayco-currency="cop"
													data-epayco-country="CO" 
													data-epayco-test="false"
													data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
													data-epayco-confirmation="https://ciaf.digital/vistas/pagosTicketCredito.php" 
													data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp">
												</script> 
											</form> 
										</div>
										<div class="col-xl-auto col-lg-auto col-auto">
											<!-- ================================================================== -->
											<!-- Gateway -->
											<form>
												<script src="https://checkout.epayco.co/checkout.js"
													data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
													class="epayco-button" 
													data-epayco-amount="' . $verTicketAbierto["valor_ticket"] . '" 
													data-epayco-tax="0"
													data-epayco-tax-base="' . $verTicketAbierto["valor_ticket"] . '"
													data-epayco-name="Ticket pago crédito ' . $verTicketAbierto["id_persona"] . '" 
													data-epayco-description="Ticket pago crédito ' . $verTicketAbierto["id_persona"] . '" 
													data-epayco-extra1="' . $verTicketAbierto["id_persona"] . '"
													data-epayco-extra2="' . $verTicketAbierto["id_ticket"] . '"
													data-epayco-extra3="' . $id_estudiante . '"
													data-epayco-currency="cop"
													data-epayco-country="CO" 
													data-epayco-test="false"
													data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
													data-epayco-confirmation="https://ciaf.digital/vistas/pagosTicketCredito.php" 
													data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp"> 
												</script> 
											</form>
										</div>
									</div>';
						}
					} else {
						$btn_solicitud_credito .= '
							<a class="btn btn-success py-2 text-white btn-block" onclick="mostrarModalCredito(' . $id_programa_ac . ', ' . $id_credencial . ')" id="t-paso3">
								<i class="fas fa-hand-holding-usd"></i> Solicitar crédito
							</a>';
					}
				}
			if ($semestresprograma == $semestre_estudiante && ($rspta[$i]["estado"] == 3 or $rspta[$i]["estado"] == 5)) {
				$semestrematricular = 1;
				$nuevoidprograma = $datosdelprograma["next-level"];
				$tienenuevonivel = $rematriculafinanciera->mirarnuevoprograma($id_credencial, $nuevoidprograma);
				if ($tienenuevonivel) {
					$data["0"] .= '';
				} else {
					$nuevo_nivel = $rematriculafinanciera->datosPrograma($nuevoidprograma);
					$data[0] .= '<div class="row">';
					$data[0] .= '<div class="col-12"><h2>Vamos al siguiente nivel</h2></div>';
					$data[0] .= '<div class="col-12">Ahora puede continuar con el proceso de matrícula financiera</div>';
					$data[0] .= '<div class="col-12 pb-4"><b>' . $nuevo_nivel["nombre"] . '</b></div>';
					$data[0] .= '<a class="btn btn-success text-white" onclick="nuevoNivel(' . $nuevoidprograma . ',' . $id_estudiante . ',' . $id_programa_ac . ',' . $ciclo . ')">Iniciar Proceso</a>';
					$data[0] .= '</div>';
				}
			} else { //matricular programa activo
				//el semestre a matricular toma el valor del semestre actual del estudiante mas uno
				if ($semestresprograma == $semestre_estudiante) { // si el semestre del estuidante es el ultimo pero no ha terminado
					$semestrematricular = $semestre_estudiante;
				} else {
					$semestrematricular = $semestre_estudiante + 1;
				}
				$buscarticket = $rematriculafinanciera->buscarticket($id_estudiante, $periodo_pecuniario);
				if (count($buscarticket) > 0) {
					$btn_solicitud_credito = "";
					$btn_estado_credito = "";
					for ($k = 0; $k < count($buscarticket); $k++) {
						if ($buscarticket[$k]["fecha_limite"] >= $fecha) { // si tiene un ticket generado
							// traer el nombre de la joranda en español
							$traerjornadareal = $rematriculafinanciera->traernombrejornadaespanol($rspta[$i]["jornada_e"]);
							$jornadaespanol = $traerjornadareal["codigo"];
							$data["0"] .= '
							<div class="row">
								<div class="col-12 py-4 tono-2">
									<div class="row align-items-center">
										<div class="col-auto">
											<span class="rounded bg-light-green p-3 text-success ">
												<i class="fa-solid fa-headset" aria-hidden="true"></i>
											</span> 
										</div>
										<div class="col-9 line-height-18">
											<span class="fs-18 font-weight-bolder">' . $datosdelprograma["original"] . '</span>
										</div>
									</div>
								</div>
								<div class="col-xl-2 col-lg-3 col-md-12 tono-3">
									<div class="row" id="t-paso1">
										<div class="col-12">
											<div class="row">
												<div class="col-xl-12 col-lg-12 col-md-4 col-5 p-0">
													<img src="../public/img/rematricula.jpg" alt="Photo 1" class="rounded" width="100%">
												</div>
												<div class="col-xl-12 col-lg-12 col-md-8 col-7 py-2">
													<div class="text-bold fs-16 pt-2">' . $titulodescuento . '</div>
													<div class="fs-14">' . $rspta[$i]["fo_programa"] . ' </div> 
													<span class="badge bg-primary">' . $jornadaespanol . '</span> 
													<span class="badge bg-primary"> Semestre ' . $semestrematricular . '</span><br>
												</div>
											</div>
										</div>
									</div>
								</div>';
							$data["0"] .= '
									<div class="col-xl-9 col-lg-9 col-md-12 col-12 px-2 pb-4 mb-4">
										<div class="row align-items-center border-bottom pb-2">
											<div class="col-xl-4 col-lg-5 col-md-5 col-12">
												<p>
													<span class="titulo-2 fs-20 text-semibold">Ticket Nuevo Valor</span><br>
													<span class="fs-14">Fecha limite: ' . $rematriculafinanciera->fechaesp($buscarticket[$k]["fecha_limite"]) . '</span>
												</p>
											</div>
											<div class="col-xl-2 col-lg-2 col-md-2 col-3 text-right">
												<span class="font-weight-bolder fs-16 text-success">$' . number_format($buscarticket[$k]["nuevo_valor"], 0) . '</span>
											</div>
											<div class="col-xl-2 col-lg-auto col-md-auto col-auto">
												<form>
													<script src="https://checkout.epayco.co/checkout.js" 
														data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
														class="epayco-button" 
														data-epayco-amount="' . $buscarticket[$k]["nuevo_valor"] . '" 
														data-epayco-tax="0"
														data-epayco-tax-base="' . $buscarticket[$k]["nuevo_valor"] . '"
														data-epayco-name="' . $programa . '" 
														data-epayco-description="' . $programa . ' sem. ' . $semestre_estudiante . ' cc. ' . $identificacion . '" 
														data-epayco-extra1="' . $identificacion . '"
														data-epayco-extra2="' . $id_estudiante . '"
														data-epayco-extra3="' . $ciclo . '"
														data-epayco-extra4="ordinaria-e"
														data-epayco-extra5="1"    
														data-epayco-extra6="' . $semestrematricular . '"
														data-epayco-extra7="21"
														data-epayco-extra8="11100611" 
														data-epayco-extra9="ticket" 
														data-epayco-currency="cop"    
														data-epayco-country="CO" 
														data-epayco-test="false" 
														data-epayco-external="true" 
														data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
														data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
														data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp">
													</script> 
												</form> 
											</div>
											<div class="col-xl-4 col-lg-auto col-md-auto col-auto">
												<!-- Gateway -->
												<form>
													<script src="https://checkout.epayco.co/checkout.js"
														data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
														class="epayco-button" 
														data-epayco-amount="' . $buscarticket[$k]["nuevo_valor"] . '" 
														data-epayco-tax="0"
														data-epayco-tax-base="' . $buscarticket[$k]["nuevo_valor"] . '"
														data-epayco-name="' . $programa . '" 
														data-epayco-description="' . $programa . ' sem. ' . $semestre_estudiante . ' cc. ' . $identificacion . '" 
														data-epayco-extra1="' . $identificacion . '"
														data-epayco-extra2="' . $id_estudiante . '"
														data-epayco-extra3="' . $ciclo . '"
														data-epayco-extra4="ordinaria-e"
														data-epayco-extra5="1"    
														data-epayco-extra6="' . $semestrematricular . '"  
														data-epayco-extra7="16"
														data-epayco-extra8="11100506"  
														data-epayco-extra9="ticket" 
														data-epayco-currency="cop"    
														data-epayco-country="CO" 
														data-epayco-test="false" 
														data-epayco-external="true" 
														data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
														data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
														data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp"> 
													</script> 
												</form>
											</div>
										</div>';
						}
					}
				} else {
					if ($estadoprograma == 1) { // que me muestre solo si el programa esta en estado matriculado
						//traer los precios del programa
						$tablaprecios = $rematriculafinanciera->tablaprecios($id_programa_ac, $periodo_pecuniario, $semestrematricular, $pago_renovar);
						$matricula_ordinaria = isset($tablaprecios["matricula_ordinaria"]) ? $tablaprecios["matricula_ordinaria"] : 0;
						$matricula_extra_ordinaria = isset($tablaprecios["matricula_extraordinaria"]) ? $tablaprecios["matricula_extraordinaria"] : 0;
						$aporte_social = isset($tablaprecios["aporte_social"]) ? $tablaprecios["aporte_social"] : 0;
						if ($fecha <= $fecha_descuento) {
							$matriculaprontopago = $matricula_ordinaria - ($matricula_ordinaria * ($rsptaperiodo["descuento"]/100));
						} else {
							$matriculaprontopago = $matricula_ordinaria;
						}
						// traer el valor pecuniario
						$traervalorpecuniario = $rematriculafinanciera->lista_precio_pecuniario($id_programa_ac, $periodo_pecuniario);
						$valorpecuniario = isset($traervalorpecuniario["valor_pecuniario"]) ? $traervalorpecuniario["valor_pecuniario"] : 0;
						// si la joranda esta activa para la matricula financiera
						if ($esta_activa_jornada == 1) {
							// traer el nombre de la joranda en español
							$traerjornadareal = $rematriculafinanciera->traernombrejornadaespanol($rspta[$i]["jornada_e"]);
							$jornadaespanol = $traerjornadareal["codigo"];
							$traerpago = $rematriculafinanciera->traerpagoaceptado($id_estudiante, $periodo_pecuniario); // consulta que trae el pago aceptado
							$valor_pago = $traerpago["x_amount_base"];
							$tiempo_pago = $traerpago["tiempo_pago"];
							$respuesta = $traerpago["x_respuesta"];
							$data["0"] .= '
							<div class="row ">';
							if ($traerpago) { // si tiene pago
								$data["0"] .= '
								<div class="col-12">
									<div class="row">
										<div class="col-12 rounded  p-4">
											<h2 class="mt-3 mb-3 fs-28"> Renovación Aprobada</h2>
											<h5 class="text-right font-weight-normal"> <span class="btn-sm mb-3 bg-purple rounded-pill pl-3 pr-3">Semestre activo</span> </h5>
											<h5 class="mb-1">' . $datosdelprograma["campus"] . '</h5>
											<h6 class="font-weight-normal"> ' . $rspta[$i]["fo_programa"] . '</h6>
											<ul class="list-unstyled mt-4 mb-4">
												<li class="mb-3"> <i class="fas fa-circle-check"></i> Jornada ' . $jornadaespanol . '</li>
												<li class="mb-3"> <i class="fas fa-circle-check"></i> Semestre ' . $semestrematricular . '</li>
												<li class="mb-3"> <i class="fas fa-circle-check"></i> Detalle $' . number_format($valor_pago, 0)  . ' - ' . $tiempo_pago . '  -' . $respuesta .  '</li>
											</ul>';
								// si el usuario realizo pago normal quiere decir que ya pago la matricula
								if ($tiempo_pago == "pp" or $tiempo_pago == "pp-e" or $tiempo_pago == "ordinaria" or $tiempo_pago == "ordinaria-e" or $tiempo_pago == "extra" or $tiempo_pago == "extra-e") {
									if ($respuesta == "Aceptada") { //si el pago fue aceptado
										$data["0"] .= '
										<div class="col-12 py-4" >
											<div class="row align-items-center">
												<div class="col-auto ">
													<span class="rounded bg-success p-3 text-success ">
														<i class="fa-solid fa-check" aria-hidden="true"></i>
													</span> 
												</div>
												<div class="col-9 line-height-18">
													<span class="">Pago realizado</span> <br>
													<span class="text-semibold fs-20">Renovación exitosa </span> 
												</div>
											</div>
										</div>
										';
									} // cierra el if si el pago fue aceptado
								} //cierra el if si realizo pago normal
								$data["0"] .= '
										</div>
									</div>
								</div>';
							} else { // si no tiene pago
								$data["0"] .= '
								<div class="col-xl-3 px-4 d-none">
									<div class="row">
										<div class="col-12 rounded bg-1 text-white p-4">
											<h2 class="mt-3 mb-3"> Renueva tu semestre</h2>
											<h5 class="text-right font-weight-normal"> <span class="btn-sm mb-3 bg-purple rounded-pill pl-3 pr-3">' . $titulodescuento . '  de descuento</span> </h5>
											<h5 class="mt-4">' . $datosdelprograma["campus"] . '</h5>
											<h6 class="font-weight-normal"> ' . $rspta[$i]["fo_programa"] . '</h6>
											<ul class="list-unstyled mt-4 mb-4">
												<li class="mb-3"> <i class="fas fa-circle-check"></i> Jornada ' . $jornadaespanol . '</li>
												<li class="mb-3"> <i class="fas fa-circle-check"></i> Semestre ' . $semestrematricular . '</li>
												<li class="mb-3"> <i class="fas fa-circle-check"></i> Incluye seguro estudiantil</li>
											</ul>
										</div>
									</div>
								</div>';
							}
							// no ha realizado pago de la matricula esta pendiente por renovar financieramente
							if ($respuesta != "Aceptada") {
								$data["0"] .= '
									<div class="col-xl-12 col-lg-12 col-md-12 col-12 px-2 mb-4 mt-2">
										<div class="col-12 pb-4">
											<div class="row ">
												<div class="col-xl-6 col-6 p-2">
													<span class="f-14">Valor matrícula</span><br>
													<span class="fs-12 text-semibold">Beca: Aporte social</span><br>
													<span class="titulo-2 fs-18 text-semibold ">Total matrícula<br>
												</div>
												<div class="col-xl-6 col-6 text-right p-2">
													<span class="font-weight-bolder fs-14">$' . number_format($valorpecuniario, 0) . '</span><br>
													<span class="font-weight-bolder fs-12">- $' . $aporte_ciaf = number_format($valorpecuniario - $matricula_ordinaria, 0) . '</span><br>
													<span class="font-weight-bolder fs-18"> $' . number_format($matricula_ordinaria, 0).  '</span>
												</div>
												<div class="col-12 border-bottom pb-2"></div>
											</div>';
								// pago de la matricula con descuento
								if ($fecha <= $fecha_descuento) {
									$data["0"] .= '
													<div class="row align-items-center rounded mt-1">
														<div class="col-xl-12 col-lg-12 col-md-12 col-12">
															<div class=" badge bg-success fs-24 float-right"> Descuento -' . $rsptaperiodo["descuento"] . '% </div>
															<div class="titulo-2 fs-20 text-semibold">Pronto Pago</div><br>
															<div class="fs-14 ">Fecha limite: ' . $rematriculafinanciera->fechaesp($fecha_descuento) . '</div>
														</div>
														<div class="col-xl-12 col-lg-12 col-md-12 col-12 ">
															<span class="f-montserrat-bold fs-48"><span class="text-success">$' . number_format($matriculaprontopago, 0) . '</span>
														</div>
														<div class="col-xl-auto col-lg-auto col-auto">
															<!-- =====================================================================
															///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
															===================================================================== -->
															<form>
																<script src="https://checkout.epayco.co/checkout.js" 
																	data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
																	class="epayco-button" 
																	data-epayco-amount="' . $matriculaprontopago . '" 
																	data-epayco-tax="0"
																	data-epayco-tax-base="' . $matriculaprontopago . '"
																	data-epayco-name="' . $programa . '" 
																	data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																	data-epayco-extra1="' . $identificacion . '"
																	data-epayco-extra2="' . $id_estudiante . '"
																	data-epayco-extra3="' . $ciclo . '"
																	data-epayco-extra4="pp-e"
																	data-epayco-extra5="1"    
																	data-epayco-extra6="' . $semestrematricular . '"    
																	data-epayco-extra7="21"
																	data-epayco-extra8="11100611"
																	data-epayco-extra9="estudiante" 
																	data-epayco-currency="cop"    
																	data-epayco-country="CO" 
																	data-epayco-test="false" 
																	data-epayco-external="true" 
																	data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																	data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																	data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp"> 
																</script> 
															</form> 
															<!-- ================================================================== -->
														</div>
														<div class="col-xl-auto col-lg-auto col-auto">
															<!-- Gateway -->
																<form>
																	<script src="https://checkout.epayco.co/checkout.js"
																		data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
																		class="epayco-button" 
																		data-epayco-amount="' . $matriculaprontopago . '" 
																		data-epayco-tax="0"
																		data-epayco-tax-base="' . $matriculaprontopago . '"
																		data-epayco-name="' . $programa . '" 
																		data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																		data-epayco-extra1="' . $identificacion . '"
																		data-epayco-extra2="' . $id_estudiante . '"
																		data-epayco-extra3="' . $ciclo . '"
																		data-epayco-extra4="pp-e"
																		data-epayco-extra5="1"    
																		data-epayco-extra6="' . $semestrematricular . '"    
																		data-epayco-extra7="16"
																		data-epayco-extra8="11100506"
																		data-epayco-extra9="estudiante" 
																		data-epayco-currency="cop"    
																		data-epayco-country="CO" 
																		data-epayco-test="false" 
																		data-epayco-external="true" 
																		data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																		data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																		data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp"> 
																	</script> 
																</form>
															<!-- ================================================================== -->
														</div>
														<div class="col-12 border-bottom pb-2"> </div>
													</div>';
								}
								if ($rspta[$i]["jornada_e"] == "F01" or $rspta[$i]["jornada_e"] == "S01") { // si la jornada es fds
									// pago de la matricula ordinaria
									if ($fecha <= $fecha_ordinaria_fds) {
										$data["0"] .= '
														<div class="row align-items-center mt-1">
															<div class="col-xl-12 col-lg-12 col-md-12 col-12">
																<p>
																	<span class="titulo-2 fs-20 text-semibold">Matrícula Ordinaria</span><br>
																	<span class="fs-14">Fecha limite: ' . $rematriculafinanciera->fechaesp($fecha_ordinaria_fds) . '</span>
																</p>
															</div>
															<div class="col-xl-12 col-lg-12 col-md-12 col-12 ">
																<span class="f-montserrat-bold fs-48">$' . number_format($matricula_ordinaria, 0) . '
															</div>
															<div class="col-xl-auto col-lg-auto col-auto">
																<!-- =====================================================================
																///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
																===================================================================== -->
																	<form id="t-paso6">
																		<script src="https://checkout.epayco.co/checkout.js" 
																			data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
																			class="epayco-button" 
																			data-epayco-amount="' . $matriculaprontopago . '" 
																			data-epayco-tax="0"
																			data-epayco-tax-base="' . $matriculaprontopago . '"
																			data-epayco-name="' . $programa . '" 
																			data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																			data-epayco-extra1="' . $identificacion . '"
																			data-epayco-extra2="' . $id_estudiante . '"
																			data-epayco-extra3="' . $ciclo . '"
																			data-epayco-extra4="ordinaria-e"
																			data-epayco-extra5="1"    
																			data-epayco-extra6="' . $semestrematricular . '"
																			data-epayco-extra7="21"
																			data-epayco-extra8="11100611"  
																			data-epayco-extra9="estudiante" 
																			data-epayco-currency="cop"    
																			data-epayco-country="CO" 
																			data-epayco-test="false" 
																			data-epayco-external="true" 
																			data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																			data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																			data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp">
																		</script> 
																	</form> 
																<!-- ================================================================== -->
															</div>
															<div class="col-xl-auto col-lg-auto col-auto">
																<!-- Gateway -->
																<form id="t-paso7">
																	<script src="https://checkout.epayco.co/checkout.js"
																		data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
																		class="epayco-button" 
																		data-epayco-amount="' . $matriculaprontopago . '" 
																		data-epayco-tax="0"
																		data-epayco-tax-base="' . $matriculaprontopago . '"
																		data-epayco-name="' . $programa . '" 
																		data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																		data-epayco-extra1="' . $identificacion . '"
																		data-epayco-extra2="' . $id_estudiante . '"
																		data-epayco-extra3="' . $ciclo . '"
																		data-epayco-extra4="ordinaria-e"
																		data-epayco-extra5="1"    
																		data-epayco-extra6="' . $semestrematricular . '"
																		data-epayco-extra7="16"
																		data-epayco-extra8="11100506" 
																		data-epayco-extra9="estudiante" 
																		data-epayco-currency="cop"    
																		data-epayco-country="CO" 
																		data-epayco-test="false" 
																		data-epayco-external="true" 
																		data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																		data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																		data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp" > 
																	</script> 
																</form>
															</div>
															<div class="col-12 border-bottom pb-2"> </div>
														</div>';
									}
									// pago de la matricula extra ordinaria
									if ($fecha <= $fecha_extraordinaria_fds) {
										$data["0"] .= '
														<div class="row align-items-center">
															<div class="col-xl-12 col-lg-12 col-md-12 col-12">
																<p>
																	<span class="titulo-2 fs-20 text-semibold">Matrícula Extra Ordinaria</span><br>
																	<span class="fs-14 ">Fecha limite: ' . $rematriculafinanciera->fechaesp($fecha_extraordinaria_fds)  . '</span>
																</p>
															</div>
															<div class="col-xl-12 col-lg-12 col-md-12 col-12">
																<span class="f-montserrat-bold fs-48">$' . number_format($matricula_extra_ordinaria, 0) . '
															</div>
															<div class="col-xl-auto col-lg-auto col-auto">
																<!-- =====================================================================
																///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
																===================================================================== -->
																<form >
																	<script src="https://checkout.epayco.co/checkout.js" 
																		data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
																		class="epayco-button" 
																		data-epayco-amount="' . $matriculaprontopago . '" 
																		data-epayco-tax="0"
																		data-epayco-tax-base="' . $matriculaprontopago . '"
																		data-epayco-name="' . $programa . '" 
																		data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																		data-epayco-extra1="' . $identificacion . '"
																		data-epayco-extra2="' . $id_estudiante . '"
																		data-epayco-extra3="' . $ciclo . '"
																		data-epayco-extra4="extra-e"
																		data-epayco-extra5="1"    
																		data-epayco-extra6="' . $semestrematricular . '"
																		data-epayco-extra7="21"
																		data-epayco-extra8="11100611" 
																		data-epayco-extra9="estudiante" 
																		data-epayco-currency="cop"    
																		data-epayco-country="CO" 
																		data-epayco-test="false" 
																		data-epayco-external="true" 
																		data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																		data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																		data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp">
																	</script> 
																</form>
															</div>
															<div class="col-xl-auto col-lg-auto col-auto">
																<!-- Gateway -->
																<form>
																	<script src="https://checkout.epayco.co/checkout.js"
																		data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
																		class="epayco-button" 
																		data-epayco-amount="' . $matriculaprontopago . '" 
																		data-epayco-tax="0"
																		data-epayco-tax-base="' . $matriculaprontopago . '"
																		data-epayco-name="' . $programa . '" 
																		data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																		data-epayco-extra1="' . $identificacion . '"
																		data-epayco-extra2="' . $id_estudiante . '"
																		data-epayco-extra3="' . $ciclo . '"
																		data-epayco-extra4="extra-e"
																		data-epayco-extra5="1"    
																		data-epayco-extra6="' . $semestrematricular . '"  
																		data-epayco-extra7="16"
																		data-epayco-extra8="11100506"  
																		data-epayco-extra9="estudiante" 
																		data-epayco-currency="cop"    
																		data-epayco-country="CO" 
																		data-epayco-test="false" 
																		data-epayco-external="true" 
																		data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																		data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																		data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp"> 
																	</script> 
																</form>
															</div>
															<div class="col-12 border-bottom pb-2 col-auto"> </div>
														</div>';
									}
								} else {
									// pago de la matricula ordinaria
									if ($fecha <= $fecha_ordinaria_semana) {
										$data["0"] .= '
														<div class="row align-items-center mt-1">
															<div class="col-xl-12 col-lg-12 col-md-12 col-12">
																<p>
																	<span class="titulo-2 fs-20 text-semibold">Matrícula Ordinaria</span><br>
																	<span class="fs-14">Fecha limite: ' . $rematriculafinanciera->fechaesp($fecha_ordinaria_semana) . '</span>
																</p>
															</div>
															<div class="col-xl-12 col-lg1-2 col-md-12 col-12">
																<span class="f-montserrat-bold fs-48">$' . number_format($matricula_ordinaria, 0) . '
															</div>
															<div class="col-xl-auto col-lg-auto col-auto">
																<!-- =====================================================================
																///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
																===================================================================== -->
																	<form id="t-paso6">
																		<script src="https://checkout.epayco.co/checkout.js" 
																			data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
																			class="epayco-button" 
																			data-epayco-amount="' . $matriculaprontopago . '" 
																			data-epayco-tax="0"
																			data-epayco-tax-base="' . $matriculaprontopago . '"
																			data-epayco-name="' . $programa . '" 
																			data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																			data-epayco-extra1="' . $identificacion . '"
																			data-epayco-extra2="' . $id_estudiante . '"
																			data-epayco-extra3="' . $ciclo . '"
																			data-epayco-extra4="ordinaria-e"
																			data-epayco-extra5="1"    
																			data-epayco-extra6="' . $semestrematricular . '"
																			data-epayco-extra7="21"
																			data-epayco-extra8="11100611"  
																			data-epayco-extra9="estudiante" 
																			data-epayco-currency="cop"    
																			data-epayco-country="CO" 
																			data-epayco-test="false" 
																			data-epayco-external="true" 
																			data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																			data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																			data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp">
																		</script> 
																	</form> 
																<!-- ================================================================== -->
															</div>
															<div class="col-xl-auto col-lg-auto col-auto">
																<!-- Gateway -->
																<form id="t-paso7">
																	<script src="https://checkout.epayco.co/checkout.js"
																		data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
																		class="epayco-button" 
																		data-epayco-amount="' . $matriculaprontopago . '" 
																		data-epayco-tax="0"
																		data-epayco-tax-base="' . $matriculaprontopago . '"
																		data-epayco-name="' . $programa . '" 
																		data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																		data-epayco-extra1="' . $identificacion . '"
																		data-epayco-extra2="' . $id_estudiante . '"
																		data-epayco-extra3="' . $ciclo . '"
																		data-epayco-extra4="ordinaria-e"
																		data-epayco-extra5="1"    
																		data-epayco-extra6="' . $semestrematricular . '"
																		data-epayco-extra7="16"
																		data-epayco-extra8="11100506" 
																		data-epayco-extra9="estudiante" 
																		data-epayco-currency="cop"    
																		data-epayco-country="CO" 
																		data-epayco-test="false" 
																		data-epayco-external="true" 
																		data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																		data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																		data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp" > 
																	</script> 
																</form>
															</div>
															<div class="col-12 border-bottom pb-2"> </div>
														</div>';
									}
									// pago de la matricula extra ordinaria
									if ($fecha <= $fecha_extraordinaria_semana) {
										$data["0"] .= '
														<div class="row align-items-center">
															<div class="col-xl-12 col-lg-12 col-md-12 col-12">
																<p>
																	<span class="titulo-2 fs-20 text-semibold">Matrícula Extra Ordinaria</span><br>
																	<span class="fs-14 ">Fecha limite: ' . $rematriculafinanciera->fechaesp($fecha_extraordinaria_semana)  . '</span>
																</p>
															</div>
															<div class="col-xl-12 col-lg-12 col-md-12 col-12 ">
																<span class="f-montserrat-bold fs-48">$' . number_format($matricula_extra_ordinaria, 0) . '
															</div>
															<div class="col-xl-auto col-lg-auto col-auto">
																<!-- =====================================================================
																///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
																===================================================================== -->
																<form >
																	<script src="https://checkout.epayco.co/checkout.js" 
																		data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
																		class="epayco-button" 
																		data-epayco-amount="' . $matriculaprontopago . '" 
																		data-epayco-tax="0"
																		data-epayco-tax-base="' . $matriculaprontopago . '"
																		data-epayco-name="' . $programa . '" 
																		data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																		data-epayco-extra1="' . $identificacion . '"
																		data-epayco-extra2="' . $id_estudiante . '"
																		data-epayco-extra3="' . $ciclo . '"
																		data-epayco-extra4="extra-e"
																		data-epayco-extra5="1"    
																		data-epayco-extra6="' . $semestrematricular . '"
																		data-epayco-extra7="21"
																		data-epayco-extra8="11100611" 
																		data-epayco-extra9="estudiante" 
																		data-epayco-currency="cop"    
																		data-epayco-country="CO" 
																		data-epayco-test="false" 
																		data-epayco-external="true" 
																		data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																		data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																		data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp">
																	</script> 
																</form>
															</div>
															<div class="col-xl-auto col-lg-auto col-auto">
																<!-- Gateway -->
																<form>
																	<script src="https://checkout.epayco.co/checkout.js"
																		data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
																		class="epayco-button" 
																		data-epayco-amount="' . $matriculaprontopago . '" 
																		data-epayco-tax="0"
																		data-epayco-tax-base="' . $matriculaprontopago . '"
																		data-epayco-name="' . $programa . '" 
																		data-epayco-description="' . $programa . ' sem. ' . $semestrematricular . ' cc. ' . $identificacion . '" 
																		data-epayco-extra1="' . $identificacion . '"
																		data-epayco-extra2="' . $id_estudiante . '"
																		data-epayco-extra3="' . $ciclo . '"
																		data-epayco-extra4="extra-e"
																		data-epayco-extra5="1"    
																		data-epayco-extra6="' . $semestrematricular . '"  
																		data-epayco-extra7="16"
																		data-epayco-extra8="11100506"  
																		data-epayco-extra9="estudiante" 
																		data-epayco-currency="cop"    
																		data-epayco-country="CO" 
																		data-epayco-test="false" 
																		data-epayco-external="true" 
																		data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
																		data-epayco-confirmation="https://ciaf.digital/vistas/pagosrematriculaagregador.php" 
																		data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp"> 
																	</script> 
																</form>
															</div>
															<div class="col-12 border-bottom pb-2 col-auto"> </div>
														</div>';
									}
								}
							}
						}
					}
				}
				if ($respuesta != "Aceptada") { // si no ha realizado pago que aparezcan los botnes de descargar recibo y de solictar credito
					if ($estadoprograma == 1) {
						$data["0"] .= '
						<div class="row mt-2 justify-content-center">
							<div class="col-11">
								' . $btn_solicitud_credito . '
							</div>
							<div class="col-11">
								' . $btn_estado_credito . '
							</div>
							<div class="col-11">
								<a  onclick="descargarrecibo(' . $id_estudiante . ')" class="btn btn-block btn-outline-info py-2" id="t-paso2" > 
									<i class="fas fa-download text-info" ></i> Descargar factura matrícula
								</a>
							</div>
						</div>';
					}
				} else { // que aparezcan solo los botones de descargar recibo y de solicitar crédito
					$data["0"] .= '
						<div class="row mt-2 justify-content-center">
							<div class="col-11">
								' . $btn_solicitud_credito . '
							</div>
							<div class="col-11">
								' . $btn_estado_credito . '
							</div>
							<div class="col-11 pb-4">
								<a onclick="descargarrecibo(' . $id_estudiante . ')" class="btn btn-light py-2 btn-block" id="t-paso2">
									<i class="fas fa-download"></i> Descargar factura matrícula
								</a>
							</div>
						</div>';
				}
				$data["0"] .= '</div>';
				$data["0"] .= '</div>';
			}
		} /* cierra el for */
		$data["0"] .= '</div>';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'guardarCredito':
		$tipo_documento = isset($_POST["tipo_documento"]) ? $_POST["tipo_documento"] : "";
		$numero_documento = isset($_POST["numero_documento"]) ? $_POST["numero_documento"] : "";
		$nombres = isset($_POST["nombres"]) ? $_POST["nombres"] : "";
		$apellidos = isset($_POST["apellidos"]) ? $_POST["apellidos"] : "";
		$primer_apellido = explode(" ", $apellidos);
		$primer_apellido = $primer_apellido[0];
		$fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? $_POST["fecha_nacimiento"] : die(array("estatus" => 0, "info" => "Debes ingresar tu fecha de nacimiento"));
		$estado_civil = isset($_POST["estado_civil"]) ? $_POST["estado_civil"] : "";
		$direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
		$ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : "";
		$celular = isset($_POST["celular"]) ? $_POST["celular"] : "";
		$estrato = isset($_POST["estrato"]) ? $_POST["estrato"] : "";
		$email = isset($_POST["email"]) ? $_POST["email"] : "";
		$personas_a_cargo = isset($_POST["personas_a_cargo"]) ? $_POST["personas_a_cargo"] : "0";
		$genero = isset($_POST["genero"]) ? $_POST["genero"] : "0";
		$numero_hijos = isset($_POST["numero_hijos"]) ? $_POST["numero_hijos"] : "0";
		$nivel_educativo = isset($_POST["nivel_educativo"]) ? $_POST["nivel_educativo"] : "0";
		$nacionalidad = isset($_POST["nacionalidad"]) ? $_POST["nacionalidad"] : "0";
		$ocupacion = isset($_POST["ocupacion"]) ? $_POST["ocupacion"] : "";
		$id_programa = isset($_POST["id_programa"]) ? $_POST["id_programa"] : "";
		$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "Solicitante";
		$labora = isset($_POST["view2"]) ? $_POST["view2"] : "SI";
		//Ingresos
		$sector_laboral = isset($_POST["sector_laboral"]) ? $_POST['sector_laboral'] : "";
		$tiempo_servicio = isset($_POST["tiempo_servicio"]) ? $_POST['tiempo_servicio'] : "";
		$salario = isset($_POST["salario"]) ? $_POST['salario'] : "";
		$tipo_vivienda = isset($_POST["tipo_vivienda"]) ? $_POST['tipo_vivienda'] : "";
		//Codeudor
		$codeudornombre = isset($_POST["codeudornombre"]) ? $_POST["codeudornombre"] : "";
		$codeudortelefono = isset($_POST["codeudortelefono"]) ? $_POST["codeudortelefono"] : "";
		/*Referencias*/
		$familiarnombre = isset($_POST["familiarnombre"]) ? $_POST["familiarnombre"] : "";
		$familiartelefono = isset($_POST["familiartelefono"]) ? $_POST["familiartelefono"] : "";
		$idsolicitante = isset($idsolicitante) ? $idsolicitante : "0";
		$fechaActual = new DateTime();
		$fechaIngresada = new DateTime($fecha_nacimiento);
		$edad = $fechaActual->diff($fechaIngresada);
		$estado = "Pendiente";
		$id_persona = $rematriculafinanciera->insertarSolicitud($tipo_documento, $numero_documento, $nombres, $apellidos, $fecha_nacimiento, $estado_civil, $direccion, $ciudad, $celular, $email, $personas_a_cargo, $ocupacion, $tipo, $estado, $idsolicitante, $labora, $genero, $numero_hijos, $nivel_educativo, $nacionalidad, $codeudornombre, $codeudortelefono, $id_programa, $estrato);
		if ($id_persona) {
			$ingresos = $rematriculafinanciera->insertarIngresos($sector_laboral, $tiempo_servicio, $salario, $tipo_vivienda, $id_persona);
			if ($ingresos) {
				$referencias = $rematriculafinanciera->insertar_referencia($familiarnombre, $familiartelefono, $id_persona);
				//echo $referencias; 
				if ($referencias) {
					if ($edad->y < 18) {
						$nombre_completo_acudiente = isset($_POST["nombre_completo_acudiente"]) ? $_POST["nombre_completo_acudiente"] : "";
						$numero_documento_acudiente = isset($_POST["numero_documento_acudiente"]) ? $_POST["numero_documento_acudiente"] : "";
						$fecha_expedicion_acudiente = isset($_POST["fecha_expedicion_acudiente"]) ? $_POST["fecha_expedicion_acudiente"] : "";
						$parentesco = isset($_POST["parentesco"]) ? $_POST["parentesco"] : "";
						$representante = $rematriculafinanciera->InsertarReprensentante($nombre_completo_acudiente, $numero_documento_acudiente, $fecha_expedicion_acudiente, $parentesco, $id_persona);
						if ($representante) {
							$mensaje = set_template_preAprobar($nombres);
							enviar_correo($email, "CIAF - Aprobación Crédito Educativo", $mensaje);
							$data = array("estatus" => 1, "info" => "Solicitud Enviada Con éxito");
						} else {
							$data = array("estatus" => 0, "info" => "Error al insertar representante legal");
						}
					} else {
						$mensaje = set_template_preAprobar($nombres);
						enviar_correo($email, "CIAF - Aprobación Crédito Educativo", $mensaje);
						$data = array("estatus" => 1, "info" => "Solicitud Enviada Con éxito");
					}
					$ultimo_score = $rematriculafinanciera->obtenerUltimoScore($numero_documento);
					$fecha_ultimo_score = isset($ultimo_score["create_dt"]) ? new DateTime($ultimo_score["create_dt"]) : new DateTime('2024-10-02 00:00:00');
					$anios_diferencia = $fecha_ultimo_score->diff(new DateTime())->y;
					$meses_diferencia = $fecha_ultimo_score->diff(new DateTime())->m;
					$meses_diferencia = ($anios_diferencia * 12) + $meses_diferencia;
					if ($meses_diferencia >= 4 && $edad->y >= 18) {
						$dataToken = $datacredito_api->generarToken();
						if (isset($dataToken['access_token'])) {
							$token_datacredito = $dataToken['access_token'];
							$resultadoServicio = $datacredito_api->consumirServicio($token_datacredito, $numero_documento, $primer_apellido);
							if (isset($resultadoServicio['ReportHDCplus']['productResult']['responseCode'])) {
								$codigo_respuesta = $resultadoServicio['ReportHDCplus']['productResult']['responseCode'];
								if ($codigo_respuesta == "13") {
									$scoreValue = $resultadoServicio['ReportHDCplus']['models'][0]['scoreValue'];
									$rematriculafinanciera->generarScoreDatacredito($id_persona, $numero_documento, $primer_apellido, $scoreValue);
								} else if ($codigo_respuesta == "09") {
									$data = array("estatus" => 1, "info" => "El número de identificación enviado no existe en los archivos de validación de la base de datos.");
								} else {
									$data = array("estatus" => 1, "info" => "Error Code#001: El API presenta fallas, informa al area de desarrollo.");
								}
							} else {
								$data = array("estatus" => 1, "info" => $resultadoServicio);
							}
						} else {
							$data = array("estatus" => 1, "info" => "Error Code#003: El API presenta fallas al generar credenciales, informa al area de desarrollo.");
						}
					}
				} else {
					$data = array("estatus" => 0, "info" => "Error al insertar las referencias");
				}
			} else {
				$data = array("estatus" => 0, "info" => "Error al insertar los ingresos");
			}
		} else {
			$data = array("estatus" => 0, "info" => "Error al insertar la solicitud");
		}
		echo json_encode($data);
		break;
	case 'descargarrecibo':
		//generar array vacio
		$data = array();
		//posicion 0 vacia
		$data["0"] = "";
		//posicion 1 vacia
		$data["1"] = "";
		//tomamos el post que trae el id del estudiante
		$id_estudiante = $_POST["id_estudiante"];
		//definimos por defecto la variable de creditos en 0
		$creditosmatriculados = 0;
		//definimos por defecto la variable de semestre en 1
		$semestrematricular = 1;
		//valor pecuniario vaci0
		$valorpecuniariototal = "";
		//el valor del aporte social vacio
		$aporte_socialtotal = "";
		//la matricula extraordinaria por defecto vacia
		$matricula_extraordinariatotal = "";
		//el total de todo por defecto vacio
		$totaloferta = "";
		//traemos del modelo los datos del programa estudiante
		$datostablaestudiantes = $rematriculafinanciera->traerdatostablaestudiante($id_estudiante);
		//guardamos el ciclo
		$ciclo = $datostablaestudiantes["ciclo"];
		//guardamos el id del programa
		$id_programa_ac = $datostablaestudiantes["id_programa_ac"];
		//echo "$id_programa_ac, $ciclo";
		//aqui se verifica si el estudiante tiene materias guardadas en la tabla de rematricula
		$compras = $rematriculafinanciera->vercompras($id_estudiante, $ciclo);
		//creamos el div que almacena el numero de creditos
		$data["0"] .= '<div id="numcreditos"></div>';
		//creamos el div que almacena header del recibo a descargar 
		$data["0"] .= '
			<div class="p-2">
				<table border="0" width="100%">
					<tr>
						<td>
							<img src="../public/img/logo_print.jpg" width="150px" alt="ciaf educación superior">
						</td>
						<td>
							<center>
								<span style="font-size:18px"><b>LIQUIDACIÓN DE MATRÍCULA</b></span><br>
								<span class="text-black-50">Nit. 891.408.248-5</span>
							</center>
						</td>
						<td>
							<span class="text-black-50">El reto es continuar unidos</span>
							<img src="../public/img/logo-cc.png" width="40px" alt="creatividad par un mundo en evolución" style="float-right">
						</td>
					</tr>
				</table>
			</div>';
		// este for imprime las materia matriculadas si tiene datos sino lo omite //
		for ($i = 0; $i < count($compras); $i++) {
			//almacenamos todos los datos
			$taerdatosmateria = $rematriculafinanciera->traerdatosmateria($compras[$i]["id_materia"]);
			//almacenamos el id de la rematricula
			$id_rematricula = $compras[$i]["id_rematricula"];
			//almacenamos si la materia esta o no esta perdida
			$perdida = $compras[$i]["perdida"];
			//almacenamos el nombre de la materia
			$nombre_materia = $taerdatosmateria["nombre"];
			//almacenamos los creditos de la materia
			$creditos = $taerdatosmateria["creditos"];
			//almacenamos el id del programa
			$id_programa_ac = $taerdatosmateria["id_programa_ac"];
			//sumamos los creditos matriculados junto con los de la materia 
			$creditosmatriculados = $creditosmatriculados + $creditos;
		}
		// traer el periodo pecuniario de la tabla periodo actual
		$traerperiodopecuniario = $rematriculafinanciera->traerperiodopecuniario();
		// almacena el periodo pecuniario de la tabla periodo actual
		$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
		// descuento para pago de contado
		$descuento = $traerperiodopecuniario[0]["descuento"];
		// fecha descuento semana
		$fecha_ordinaria_semana = $traerperiodopecuniario[0]["fecha_ordinaria_semana"];
		$fecha_extraordinaria_semana = $traerperiodopecuniario[0]["fecha_extraordinaria_semana"];
		// fecha descuento fds
		$fecha_ordinaria_fds = $traerperiodopecuniario[0]["fecha_ordinaria_fds"];
		$fecha_extraordinaria_fds = $traerperiodopecuniario[0]["fecha_extraordinaria_fds"];
		// traer datos del programa
		$datosPrograma = $rematriculafinanciera->datosPrograma($id_programa_ac);
		// traer los semestres que tiene el programa
		$semestresprograma = $datosPrograma["semestres"];
		// almacena el nombre del programa
		$nombreprograma = $datosPrograma["nombre"];
		// almacena el nombre orginal del programa
		$nombreoriginal = $datosPrograma["original"];
		// traer datos de la tabla estudiantes
		$traerdatostablaestudiante = $rematriculafinanciera->traerdatostablaestudiante($id_estudiante);
		/* consulta para saber si elpago es normal o viene de algun nivelatorio 1= normal 0=viene de nivelatorio */
		$pago_renovar = $traerdatostablaestudiante["pago_renovar"];
		//almacenamos el semestre del estudiante	
		$semestre_estudiante = $traerdatostablaestudiante["semestre_estudiante"];
		//almacenamos la jornada del estudiante	
		$jornada_e = $traerdatostablaestudiante["jornada_e"];
		//almacenamos el id credencial del estudiante	
		$id_credencial = $traerdatostablaestudiante["id_credencial"];
		// cosulta para saber a que grupo pertenece si a fds o semana
		$grupo_pecuniario = $rematriculafinanciera->verificarjornadaactiva($jornada_e);
		// almacenamos si pertenece fds o semana
		$pertenece = $grupo_pecuniario["grupo_pecuniario"];
		//si pertenece quiere decir que el estudiante es de jornada semana
		if ($pertenece == 0) {
			//almacenamos el descuento para los de semana
			$fecha_descuento = $traerperiodopecuniario[0]["fecha_des_semana"];
			// quiere de cir que els estuidante es de jornada FDS
		} else {
			//almacenamos el descuento para los de fin de semana
			$fecha_descuento = $traerperiodopecuniario[0]["fecha_des_fds"];
		}
		// traer el nombre de la joranda en español
		$traerjornadareal = $rematriculafinanciera->traernombrejornadaespanol($jornada_e);
		// almacena el nombre de la joranda en español
		$jornadaespanol = $traerjornadareal["codigo"];
		// si el estudiante va en el mismo semestre del programa, se almacena el semestre programa en el semestre a matricular  */
		if (
			$semestresprograma == $semestre_estudiante
		) {
			//se almacena el semestre programa en el semestre a matricular 
			$semestrematricular = $semestresprograma;
		} else {
			//se almacena el semestre del estudiante mas 1 en el semestre a matricular 
			$semestrematricular = $semestre_estudiante + 1;
		}
		// buscar los datos de la tabla credencial estudiante 
		$datostablacredencial = $rematriculafinanciera->mostrardatos($id_credencial);
		// almacena la cedula
		$numero_cedula = $datostablacredencial["credencial_identificacion"];
		// almacena el primer nombre
		$credencial_nombre = $datostablacredencial["credencial_nombre"];
		// almacena el segundo nombre
		$credencial_nombre_2 = $datostablacredencial["credencial_nombre_2"];
		// almacena el primer apellido
		$credencial_apellido = $datostablacredencial["credencial_apellido"];
		// almacena el segundo apellido
		$credencial_apellido_2 = $datostablacredencial["credencial_apellido_2"];
		//almacena los creditos permitidos del programa
		$creditospermitidos = $datosPrograma["c" . $semestrematricular];
		//consultamos la tabla de precios dependiendo del programa, periodo pecuniario y semestre a matricular
		$tablaprecios = $rematriculafinanciera->tablaprecios($id_programa_ac, $periodo_pecuniario, $semestrematricular, $pago_renovar); // traer los precios del programa
		// almacenamos el valor de la matricula ordinaria
		$matricula_ordinaria = $tablaprecios["matricula_ordinaria"];
		// almacenamos el valor del aporte social a restar
		$aporte_social = $tablaprecios["aporte_social"];
		// almacenamos el valor de la matricula extra-ordinaria
		$matricula_extraordinaria = $tablaprecios["matricula_extraordinaria"];
		// traer el valor pecuniario
		$traervalorpecuniario = $rematriculafinanciera->lista_precio_pecuniario($id_programa_ac, $periodo_pecuniario);
		$valorpecuniario = $traervalorpecuniario["valor_pecuniario"];
		$total_aporte_social = $valorpecuniario - $matricula_ordinaria; // variable que contiene el aporte social de CIAF
		$pronto_pago = $matricula_ordinaria - ($matricula_ordinaria * ($descuento / 100));
		//verificamos si tiene algun ticket activo en pagos_rematricula_ticket
		$tickets = $rematriculafinanciera->verificarTicketsRematricula($id_estudiante);
		if (count($tickets) > 0) {
			//creamos el div que almacena el numero de creditos
			$data["0"] .= '<div id="numcreditos"></div>';
			//creamos el div que almacena header del recibo a descargar 
			$data["0"] .= '
			<div class="row p-0 m-0" style="border:1px solid #e5e5e5">
				<table style="width:100%">
					<tr>
						<td style="width:50%">
							<table>
								<tr>
									<td>
										<strong>Nombres y apellidos</strong><br>
										<small>
											' . $credencial_nombre . ' ' . $credencial_nombre_2 . ' 
											' . $credencial_apellido . ' ' . $credencial_apellido_2 . '
										</small><br>
										<strong>Identificación</strong><br>
										<small>' . $numero_cedula . '</small><br>
										<strong>Programa:</strong><br>
										<small>' . $nombreoriginal . '</small><br>
										<small style="margin-left:20px">' . $nombreprograma . '</small><br>
										<strong>Jornada</strong> <small>' . $jornadaespanol . '</small><br>
										<strong>Periodo a renovar </strong> <small>' . $periodo_pecuniario . '</small>
									</td>
								</tr>
							</table>
						</td>
						<td style="width:50%">
							<table class="table table-sm" align="right" cellpadding="5px">';
			for ($t = 0; $t < count($tickets); $t++) {
				$data[0] .= '<tr>
								<td class="text-right">
									<strong>Ticket Nuevo Valor:  </span></strong> <br>
									<small> Hasta ' . $rematriculafinanciera->fechaesp($tickets[$t]["fecha_limite"]) . '</small>
								</td>
								<td class="text-right"><br>
									$ ' . number_format($tickets[$t]["nuevo_valor"]) . '
								</td>
							</tr>';
			}
		} else {
			//genaramos el cuerpo del recibo con todos los datos recolectados
			$data["0"] .= '
						<div class="row p-0 m-0" style="border:1px solid #e5e5e5">
							<table style="width:100%">
								<tr>
									<td style="width:50%">
										<table>
											<tr>
												<td>
													<strong>Nombres y apellidos</strong><br>
													<small>
														' . $credencial_nombre . ' ' . $credencial_nombre_2 . ' 
														' . $credencial_apellido . ' ' . $credencial_apellido_2 . '
													</small><br>
													<strong>Identificación</strong><br>
													<small>' . $numero_cedula . '</small><br>
													<strong>Programa:</strong><br>
													<small>' . $nombreoriginal . '</small><br>
													<small style="margin-left:20px">' . $nombreprograma . '</small><br>
													<strong>Jornada</strong> <small>' . $jornadaespanol . '</small><br>
													<strong>Periodo a renovar </strong> <small>' . $periodo_pecuniario . '</small>
												</td>
											</tr>
										</table>
									</td>
									<td style="width:50%">
										<table class="table table-sm table-hover" align="right" cellpadding="5px">';
			$data["0"] .= '
											<tr id="t-paso4">
												<td class="text-right">
													<strong>
														<font style="vertical-align: inherit;">
															<font style="vertical-align: inherit;" >
																Valor matricula:<br >
																<span class="text-success" >Beca: Aporte social</span>:<br>
															</font>
														</font>
													</strong>
												</td>
												<td class="text-right">
														$ ' . number_format($valorpecuniario) . '<br>- 
														$ ' . number_format($total_aporte_social) . '
												</td>
											</tr>';
			if ($fecha <= $fecha_descuento) {
				$data["0"] .= '
											<tr>
												<td class="text-right">
													<strong>Pronto pago: Descuento del <span class="text-success">' . $descuento . '% </span></strong> <br>
													<small> Hasta ' . $rematriculafinanciera->fechaesp($fecha_descuento) . '</small>
												</td>
												<td class="text-right">
													<strike>$ ' . number_format($matricula_ordinaria) . '</strike><br>
													$ ' . number_format($pronto_pago) . '
												</td>
											</tr>';
			}
			if ($jornada_e == "F01" or $jornada_e == "S01") {
				if ($fecha <= $fecha_ordinaria_fds) {
					$data["0"] .= '
													<tr>
														<td class="text-right">
															<strong>Valor Ordinaria:</strong><br>
															<small> Hasta ' . $rematriculafinanciera->fechaesp($fecha_ordinaria_fds) . '</small> <br>
														</td>
														<td class="text-right">
															$ ' . number_format($matricula_ordinaria_fds) . ' 
														</td>
													</tr>';
				}
				if ($fecha <= $fecha_extraordinaria_fds) {
					$data["0"] .= '
													<tr>
														<td class="text-right">
															<strong>Valor Extraordinaria:</strong><br>
															<small> Hasta ' . $rematriculafinanciera->fechaesp($fecha_extraordinaria_fds) . '</small> <br>
														</td>
														<td class="text-right">
															<font style="vertical-align: inherit;">
																<font style="vertical-align: inherit;">
																$ ' . number_format($matricula_extraordinaria_fds) . '
																</font>
															</font>
														</td>
													</tr>';
				}
			} else {
				if ($fecha <= $fecha_ordinaria_semana) {
					$data["0"] .= '
													<tr>
														<td class="text-right">
															<strong>Valor Ordinaria:</strong><br>
															<small> Hasta ' . $rematriculafinanciera->fechaesp($fecha_ordinaria_semana) . '</small> <br>
														</td>
														<td class="text-right">
															$ ' . number_format($matricula_ordinaria) . ' 
														</td>
													</tr>';
				}
				if ($fecha <= $fecha_extraordinaria_semana) {
					$data["0"] .= '
													<tr>
														<td class="text-right">
															<strong>Valor Extraordinaria:</strong><br>
															<small> Hasta ' . $rematriculafinanciera->fechaesp($fecha_extraordinaria_semana) . '</small> <br>
														</td>
														<td class="text-right">
															<font style="vertical-align: inherit;">
																<font style="vertical-align: inherit;">
																$ ' . number_format($matricula_extraordinaria) . '
																</font>
															</font>
														</td>
													</tr>';
				}
			}
			$data["0"] .= '
										</table>
									</td>
								</tr>
							</table>
						</div><br>
						<div class="col-12" style="padding:5px; background-color:#132252;color:#fff"><center>Sede carrera 6 # 24-56 Pereira Tel: 3400 100 www.ciaf.edu.co</center></div>	
						<div class="col-12 text-xs text-center"><i>CIAF Educación Superior SNIES 4825- Personería Jurídica Res. No.19348 - Vigilada Ministerio de Educación</i></div>';
			$data["1"] .= $creditosmatriculados;
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'nuevonivel':
		//generar array vacio
		$data = array();
		//posicion 0 vacia
		$data["0"] = "";
		$nuevoidprograma = $_POST["nuevoid"];
		$jornada_e = "N01";
		$grupo = 1;
		/* datos para la malla actual */
		$id_estudiante = $_POST["est"];
		$id_programa_ac = $_POST["pac"];
		$ciclo = $_POST["cic"];
		/* ******************** */
		$nuevo_nivel = $rematriculafinanciera->datosPrograma($nuevoidprograma);
		$nuevo_id = $nuevo_nivel["id_programa"];
		$nuevo_programa = $nuevo_nivel["nombre"];
		$nuevo_ciclo = $nuevo_nivel["ciclo"];
		$id_credencial = $_SESSION['id_usuario'];
		$escuela_ciaf = $nuevo_nivel["escuela"];
		$periodo_ingreso = $periodo_pecuniario;
		$periodo_activo = $periodo_pecuniario;
		$id_usuario_matriculo = $id_credencial;
		$admisiones = "no";
		$pago = "1";
		$rr = 0;
		$buscarmateriasperdidas = $rematriculafinanciera->buscarmateriasperdidas($ciclo, $id_estudiante, $id_programa_ac);
		if ($buscarmateriasperdidas) { //verificar si tiene materias perdidas
			$data["0"] .= 'perdio';
		} else { // todo esta bien
			$tienenuevonivel = $rematriculafinanciera->mirarnuevoprograma($id_credencial, $nuevo_id);
			if ($tienenuevonivel) {
				$data["0"] .= 'negado';
			} else {
				$rspta = $rematriculafinanciera->insertarnuevoprograma($id_credencial, $nuevo_id, $nuevo_programa, $jornada_e, $escuela_ciaf, $periodo_ingreso, $nuevo_ciclo, $periodo_activo, $grupo, $id_usuario_matriculo, $fecha, $hora, $admisiones, $pago);
				$data["0"] .= 'ok';
			}
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'datosCredito':
		$credencial_identificacion = $_SESSION['credencial_identificacion'];
		//$credencial_identificacion = 1004681758;
		//almacenamos los datos del credito
		$datos_credito = $rematriculafinanciera->datosCreditos($credencial_identificacion);
		if (empty($datos_credito)) {
			$data = array("exito" => 0, "info" => "No se encontraron datos del crédito.");
		} else {
			$data = array(
				"exito" => 1,
				"tipo_documento" => isset($datos_credito["tipo_documento"])?$datos_credito["tipo_documento"]:"",
				"numero_documento" => isset($datos_credito["numero_documento"])?$datos_credito["numero_documento"]:"",
				"nombres" => isset($datos_credito["nombres"])?$datos_credito["nombres"]:"",
				"apellidos" => isset($datos_credito["apellidos"])?$datos_credito["apellidos"]:"",
				"fecha_nacimiento" => isset($datos_credito["fecha_nacimiento"])?$datos_credito["fecha_nacimiento"]:"",
				"genero" => isset($datos_credito["genero"])?$datos_credito["genero"]:"",
				"estado_civil" => isset($datos_credito["estado_civil"])?$datos_credito["estado_civil"]:"",
				"numero_hijos" => isset($datos_credito["numero_hijos"])?$datos_credito["numero_hijos"]:"",
				"nivel_educativo" => isset($datos_credito["nivel_educativo"])?$datos_credito["nivel_educativo"]:"",
				"nacionalidad" => isset($datos_credito["nacionalidad"])?$datos_credito["nacionalidad"]:"",
				"direccion" => isset($datos_credito["direccion"])?$datos_credito["direccion"]:"",
				"departamento" => isset($datos_credito["departamento"])?$datos_credito["departamento"]:"",
				"ciudad" => isset($datos_credito["ciudad"])?$datos_credito["ciudad"]:"",
				"celular" => isset($datos_credito["celular"])?$datos_credito["celular"]:"",
				"email" => isset($datos_credito["email"])?$datos_credito["email"]:"",
				"ocupacion" => isset($datos_credito["ocupacion"])?$datos_credito["ocupacion"]:"",
				"personas_a_cargo" => isset($datos_credito["persona_a_cargo"])?$datos_credito["persona_a_cargo"]:"",
				"sector_laboral" => isset($datos_credito["sector_laboral"])?$datos_credito["sector_laboral"]:"",
				"tiempo_servicio" => isset($datos_credito["tiempo_servicio"])?$datos_credito["tiempo_servicio"]:"",
				"salario" => isset($datos_credito["salario"])?$datos_credito["salario"]:"",
				"tipo_vivienda" => isset($datos_credito["tipo_vivienda"])?$datos_credito["tipo_vivienda"]:"",
				"familiarnombre" => isset($datos_credito["familiarnombre"])?$datos_credito["familiarnombre"]:"",
				"familiartelefono" => isset($datos_credito["familiartelefono"])?$datos_credito["familiartelefono"]:"",
				"codeudornombre" => isset($datos_credito["codeudornombre"])?$datos_credito["codeudornombre"]:"",
				"codeudortelefono" => isset($datos_credito["codeudortelefono"])?$datos_credito["codeudortelefono"]:"",
				"nombre_completo_acudiente" => isset($datos_credito["nombre_completo_acudiente"])?$datos_credito["nombre_completo_acudiente"]:"",
				"numero_documento_acudiente" => isset($datos_credito["numero_documento_acudiente"])?$datos_credito["numero_documento_acudiente"]:"",
				"fecha_expedicion_acudiente" => isset($datos_credito["fecha_expedicion_acudiente"])?$datos_credito["fecha_expedicion_acudiente"]:"",
				"parentesco" => isset($datos_credito["parentesco"])?$datos_credito["parentesco"]:"",
			);
		}
		echo json_encode($data);
		break;
	case 'verificarValorMinimoTicket':
		$id_ticket = $_POST["id_ticket"];
		$valor_ticket_usuario = $_POST["valor_ticket"];
		$ticket = $rematriculafinanciera->verificarValorMinimoTicket($id_ticket);
		if ($ticket) {
			$valor_ticket_real = $ticket["valor_ticket"];
			if ($valor_ticket_usuario >= $valor_ticket_real) {
				$data = array("exito" => 1);
			} else {
				//formato dinero 
				$valor_ticket_real = number_format($valor_ticket_real, 0, ',', '.');
				$data = array("exito" => 0, "info" => "El valor del ticket debe ser mayor o igual a $ $valor_ticket_real");
			}
		} else {
			$data = array("exito" => 0, "info" => "El ticket no existe o ha sido eliminado.");
		}
		echo json_encode($data);
		break;
	case "ModificarTicket":
		$id_ticket = $_POST["id_ticket"];
		$valor_ticket = $_POST["valor_ticket"];
		$ticket_modificado = $rematriculafinanciera->modificarTicket($id_ticket, $valor_ticket);
		if ($ticket_modificado) {
			$data = array("exito" => 1, "info" => "Ticket modificado con éxito.");
		} else {
			$data = array("exito" => 0, "info" => "Error al modificar el ticket.");
		}
		echo json_encode($data);
		break;
}
