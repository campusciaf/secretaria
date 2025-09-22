<?php
session_start();
require_once "../modelos/SofiPagosRematricula.php";
require_once "../YeminusApi/modelos/Yeminus.php";
$sofipagosrematricula = new SofiPagosRematricula();
$yeminus = new Yeminus();
$periodo_actual = $_SESSION['periodo_actual'];
$usuario = $_SESSION['usuario_cargo'];
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d H:i:s');
// campos para generar ticket
$id_estudiante = isset($_POST["id_estudiante"]) ? limpiarCadena($_POST["id_estudiante"]) : "";
$nuevo_valor = isset($_POST["nuevo_valor"]) ? limpiarCadena($_POST["nuevo_valor"]) : "";
$motivo = isset($_POST["motivo"]) ? limpiarCadena($_POST["motivo"]) : "";
$fecha_limite = isset($_POST["fecha_limite"]) ? limpiarCadena($_POST["fecha_limite"]) : "";
// campos para generar ticket con financiacion aprobada por el sofi
$id_estudiante_financiacion = isset($_POST["id_estudiante_financiacion"]) ? limpiarCadena($_POST["id_estudiante_financiacion"]) : "";
$nuevo_valor_financiacion = isset($_POST["nuevo_valor_financiacion"]) ? limpiarCadena($_POST["nuevo_valor_financiacion"]) : "";
$motivo_financiado = isset($_POST["motivo_financiado"]) ? limpiarCadena($_POST["motivo_financiado"]) : "";
$fecha_limite_financiado = isset($_POST["fecha_limite_financiado"]) ? limpiarCadena($_POST["fecha_limite_financiado"]) : "";
$tipo_pago = isset($_POST["tipo_pago"]) ? limpiarCadena($_POST["tipo_pago"]) : "";
//trae el periodo	
$rsptaperiodo = $sofipagosrematricula->periodoactual();
//contiene el perido a matricular
$periodo_pecuniario = $rsptaperiodo["periodo_pecuniario"];
switch ($_GET["op"]) {
	case 'crearticket':
		$datos_estudiante = $sofipagosrematricula->datosEstudiante($id_estudiante);
		//semestre del estudiante 
		$semestre_estudiante = $datos_estudiante["semestre_estudiante"];
		// trae los datos del semestre progama
		$semestresprograma = $datos_estudiante["semestre_programa"];
		//si son iguales los deja asi
		if ($semestresprograma == $semestre_estudiante) {
			//el semestre a matricular toma el valor del total de semestres del programa
			$semestrematricular = $semestresprograma;
		} else {
			//el semestre a matricular toma el valor del semestre actual del estudiante mas uno
			$semestrematricular = $semestre_estudiante + 1;
		}
		$rspta = $sofipagosrematricula->crearticket($id_estudiante, $nuevo_valor, $motivo, $fecha_limite, $fecha, $periodo_pecuniario, $tipo_pago, $semestrematricular);
		$data["0"] = $rspta ? "1" : "2";
		$data["1"] = $id_estudiante;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'guardarfinanciacion':
		$rspta = $sofipagosrematricula->crearticketfinanciado($id_estudiante_financiacion, $nuevo_valor_financiacion, $motivo_financiado, $fecha_limite_financiado, $fecha, $periodo_pecuniario);
		$data["0"] = $rspta ? "1" : "2";
		$data["1"] = $id_estudiante_financiacion;
		$results = array($data);
		echo json_encode($results);
		break;

	case 'verificardocumento':
		$credencial_identificacion = $_POST["credencial_identificacion"];
		$rspta = $sofipagosrematricula->verificardocumento($credencial_identificacion);
		$data = array();
		$data["0"] = "";
		$reg = $rspta;
		if (count($reg) == 0) {
			$data["0"] .= $credencial_identificacion;
			$data["1"] = false;
		} else {
			for ($i = 0; $i < count($reg); $i++) {
				$data["0"] .= $reg[$i]["id_credencial"];
			}
			$data["1"] = true;
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'listar':
		$id_credencial = $_GET["id_credencial"];
		$rspta = $sofipagosrematricula->listar($id_credencial);
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {

			$id_programa_ac=$rspta[$i]['id_programa_ac'];
			$semestre_estudiante=$rspta[$i]["semestre_estudiante"];
			$id_estudiante=$rspta[$i]["id_estudiante"];
			$id_credencial=$rspta[$i]["id_credencial"];
			$btnnuevonivel="";

			$datosdelprograma = $sofipagosrematricula->datosPrograma($rspta[$i]['id_programa_ac']);
			$semestresprograma = $datosdelprograma["semestres"];
			
			
			

			if ($semestresprograma == $semestre_estudiante) {
				$semestrematricular = 1;
				$nuevoidprograma = $datosdelprograma["next-level"];
				$tienenuevonivel = $sofipagosrematricula->mirarnuevoprograma($id_credencial, $nuevoidprograma);
				if ($tienenuevonivel) {
					$btnnuevonivel="";
				} else {
					$nuevo_nivel = $sofipagosrematricula->datosPrograma($nuevoidprograma);
					$nuevoprogramaac=$nuevo_nivel["nombre"]; 
					$ciclo=$nuevo_nivel["ciclo"];

					$btnnuevonivel='<a class="btn btn-success text-white" title="'.$nuevoprogramaac.'" onclick="nuevoNivel(' . $nuevoidprograma . ',' . $id_estudiante . ',' . $id_programa_ac . ',' . $ciclo . ','.$id_credencial.')">Siguiente Nivel</a>';

				}
			}



			$rspta2 = $sofipagosrematricula->listarEstado($rspta[$i]["estado"]);
			$data[] = array(
				"0" => ($rspta2["estado"] == "Matriculado") 
					? '<button class="btn btn-primary btn-xs" onclick="carrito(' . $rspta[$i]["id_estudiante"] . ')" title="Ver proceso">
						<i class="fas fa-plus-square"></i> Ver Proceso
					</button>'
					: '<span>'.$btnnuevonivel.'</span>',
				"1" => $id_estudiante,
				"2" => $rspta[$i]["fo_programa"],
				"3" => $rspta[$i]["jornada_e"],
				"4" => $semestre_estudiante,
				"5" => $rspta[$i]["grupo"],
				"6" => $rspta[$i]["pago_renovar"] == 1 ? 'Normal' : 'Con Nivelatorio',
				"7" => $rspta2["estado"],
				"8" => $rspta[$i]["periodo"],
				"9" => $rspta[$i]["periodo_activo"],
			);
			$i++;
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case "mostrardatos":
		$id_credencial = $_POST["id_credencial"];
		$rspta = $sofipagosrematricula->mostrardatos($id_credencial);
		$data = array();
		$data["0"] = "";
		if (file_exists('../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg')) {
			$foto = '<img src=../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg class=img-circle img-bordered-sm>';
		} else {
			$foto = '<img src=../files/null.jpg width=50px height=50px class=img-circle img-bordered-sm>';
		}
		$data["0"] .= '
				<div style="margin:2%">
				    <div class="user-block">
						' . $foto . '
                        <span class="username">
							 <a href="#">' . $rspta["credencial_nombre"] . ' ' . $rspta["credencial_nombre_2"] . ' ' . $rspta["credencial_apellido"] . ' ' . $rspta["credencial_apellido_2"] . '
				        </span>
						<span class="description">' . $rspta["credencial_login"] . '</span>
				    </div>
				</div>';
		$results = array($data);
		echo json_encode($results);
		break;
		/* case "mostrarmaterias":
		$ciclo = $_POST["ciclo"];
		$id_estudiante = $_POST["id_estudiante"];
		$data = array();
		$data["0"] ="";//iniciamos el arreglo
		//consulta para ver los datos del programa
		$rspta2 = $sofipagosrematricula->vercarrito($id_estudiante,$ciclo);
		for ($j=0;$j<count($rspta2);$j++){
			$data["0"] .=$rspta2[$j]["id_materia"];
		}
        $results = array($data);
        echo json_encode($results);
		break;*/
	case 'carrito':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$id_estudiante = $_POST["id_estudiante"];
		$creditosmatriculados = 0;
		$semestrematricular = 1;
		$valorpecuniariototal = "";
		$aporte_socialtotal = "";
		$matricula_extraordinariatotal = "";
		$totaloferta = "";
		$datostablaestudiantes = $sofipagosrematricula->traerdatostablaestudiante($id_estudiante);

		$ciclo = $datostablaestudiantes["ciclo"];
		$id_programa_ac = $datostablaestudiantes["id_programa_ac"];
		/* if(count($compras)==0){ */
		$pagorematricula = $sofipagosrematricula->pagorematricula($id_estudiante, $periodo_pecuniario);
		$id_pagos = isset($pagorematricula["id_pagos"]) ? $pagorematricula["id_pagos"] : 0;
		$x_amount_base_pago = isset($pagorematricula["x_amount_base"]) ? $pagorematricula["x_amount_base"] : 0;
		$x_fecha_transaccion_pago = isset($pagorematricula["x_fecha_transaccion"]) ? $pagorematricula["x_fecha_transaccion"] : 0;
		$x_bank_name_pago = isset($pagorematricula["x_bank_name"]) ? $pagorematricula["x_bank_name"] : 0;
		$x_tiempo_pago_pago = isset($pagorematricula["tiempo_pago"]) ? $pagorematricula["tiempo_pago"] : 0;
		if (isset($pagorematricula["id_pagos"])) { // si ya tiene el pago realizado
			$data["0"] .= '
				<div class="col-xl-12">
					<div class="alert alert-success">Pago Realizado </div>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td class="text-right">
										<strong><font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">Subtotal:</font>
										</strong>
									</td>
									<td class="text-right">
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">$ ' . number_format($x_amount_base_pago) . '</font>
										</font>
									</td>
								</tr>
								<tr>
									<td class="text-right">
										<strong><font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">Fecha de pago</font>
										</strong>
									</td>
									<td class="text-right">
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;"> ' . $sofipagosrematricula->fechaesp($x_fecha_transaccion_pago) . '</font>
										</font>
									</td>
								</tr>
								<tr>
									<td class="text-right">
										<strong><font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">Hora de pago</font>
										</strong>
									</td>
									<td class="text-right">
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;"> ' . date("h:j:s", strtotime($x_fecha_transaccion_pago)) . '</font>
											' . date("a", strtotime($x_fecha_transaccion_pago)) . '
										</font>
									</td>
								</tr>
								<tr>
									<td class="text-right">
										<strong><font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">Medio Pago</font>
										</strong>
									</td>
									<td class="text-right">
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;"> ' . $x_bank_name_pago . '</font>
										</font>
									</td>
								</tr>
								<tr>
									<td class="text-right">
										<strong><font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">Tiempo Pago</font>
										</strong>
									</td>
									<td class="text-right">
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;"> ' . $x_tiempo_pago_pago . '</font>
										</font>
									</td>
								</tr>
							
							</tbody>
						</table>
				';
		} else { // entra cuando tiene matricula realizada pero pago pendiente
			// traer el periodo pecuniario de la tabla periodo actual
			$traerperiodopecuniario = $sofipagosrematricula->traerperiodopecuniario();
			$periodo_pecuniario = isset($traerperiodopecuniario[0]["periodo_pecuniario"]) ? $traerperiodopecuniario[0]["periodo_pecuniario"] : 0;
			// descuento para pago de contado
			$descuento = isset($traerperiodopecuniario[0]["descuento"]) ? $traerperiodopecuniario[0]["descuento"] : 0;
			// fecha descuento fds
			$fecha_des_fds = isset($traerperiodopecuniario[0]["fecha_des_fds"]) ? $traerperiodopecuniario[0]["fecha_des_fds"] : 0;
			// fecha descuento fds
			$fecha_des_semana = isset($traerperiodopecuniario[0]["fecha_des_semana"]) ? $traerperiodopecuniario[0]["fecha_des_semana"] : 0;
			// fecha descuento fds
			$fecha_ordinaria_semana = isset($traerperiodopecuniario[0]["fecha_ordinaria_semana"]) ? $traerperiodopecuniario[0]["fecha_ordinaria_semana"] : 0;
			$fecha_ordinaria_fds = isset($traerperiodopecuniario[0]["fecha_ordinaria_fds"]) ? $traerperiodopecuniario[0]["fecha_ordinaria_fds"] : 0;
			// fecha descuento fds
			$fecha_extraordinaria_semana = isset($traerperiodopecuniario[0]["fecha_extraordinaria_semana"]) ? $traerperiodopecuniario[0]["fecha_extraordinaria_semana"] : 0;
			$fecha_extraordinaria_fds = isset($traerperiodopecuniario[0]["fecha_extraordinaria_fds"]) ? $traerperiodopecuniario[0]["fecha_extraordinaria_fds"] : 0;
			$datosPrograma = $sofipagosrematricula->datosPrograma($id_programa_ac); // traer datos del programa
			$semestresprograma = $datosPrograma["semestres"];
			$nombreprograma = $datosPrograma["nombre"];
			$traerdatostablaestudiante = $sofipagosrematricula->traerdatostablaestudiante($id_estudiante);	// traer datos de la tabla estudiantes
			$pago_renovar = $traerdatostablaestudiante["pago_renovar"]; // si es 1 es pago normal si es 0, es que viene de nivelatorio
			$semestre_estudiante = $traerdatostablaestudiante["semestre_estudiante"];
			$jornada_e = $traerdatostablaestudiante["jornada_e"];
			$id_credencial = $traerdatostablaestudiante["id_credencial"];
			//  condicional para saber el semestre en que queda el estudiante */	
			if ($semestresprograma == $semestre_estudiante) {
				$semestrematricular = $semestresprograma;
			} else {
				$semestrematricular = $semestre_estudiante + 1;
			}
			/* buscar los datos de la tabla credencial estudiante */
			$datostablacredencial = $sofipagosrematricula->mostrardatos($id_credencial);
			$numero_cedula = $datostablacredencial["credencial_identificacion"];
			$creditospermitidos = $datosPrograma["c" . $semestrematricular];
			//traer los precios del programa
			$tablaprecios = $sofipagosrematricula->tablaprecios($id_programa_ac, $periodo_pecuniario, $semestrematricular, $pago_renovar);
			$matricula_ordinaria = isset($tablaprecios["matricula_ordinaria"]) ? $tablaprecios["matricula_ordinaria"] : 0;
			$aporte_social = isset($tablaprecios["aporte_social"]) ? $tablaprecios["aporte_social"] : 0;
			$matricula_extraordinaria = isset($tablaprecios["matricula_extraordinaria"]) ? $tablaprecios["matricula_extraordinaria"] : 0;
			// traer el valor pecuniario
			$traervalorpecuniario = $sofipagosrematricula->lista_precio_pecuniario($id_programa_ac, $periodo_pecuniario);
			$valorpecuniario = isset($traervalorpecuniario["valor_pecuniario"]) ? $traervalorpecuniario["valor_pecuniario"] : 0;
			$data["0"] .= '<br> <div class="col-xl-12" style="background-color: #f5f5f5; padding-top:10px">';
			$valorpecuniariototal = $valorpecuniario;
			$matricula_ordinariatotal = $matricula_ordinaria;
			$valorpecuniariototal = $valorpecuniario;
			$matricula_ordinariatotal = $matricula_ordinaria;
			$aporte_socialtotal = $valorpecuniariototal * ((int)$aporte_social / 100);
			$matricula_extraordinariatotal = $matricula_extraordinaria;
			$oferta = $matricula_ordinariatotal * ($descuento / 100); // descuento pago de contado
			$totaloferta = $matricula_ordinariatotal - $oferta;
			$data["0"] .= '<table class="table table-bordered">
				<tbody>
					<tr>
						<td class="text-right">
							<strong>
								<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
									Subtotal:
								</font>
							</strong>
						</td>
						<td class="text-right">
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">
									$ ' . number_format($valorpecuniariototal) . '
								</font>
							</font>
						</td>
					</tr>
					<tr class="bg-success">
						<td class="text-right">
							<strong>Nuestro Aporte Social:</strong>
						</td>
						<td class="text-right">
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">-$ ' . number_format($aporte_socialtotal) . '</font>
							</font>
						</td>
					</tr>';
			// si las jornadas son fds
			if ($jornada_e == "F01" or $jornada_e == "S01" and  $fecha <= $fecha_des_fds) {
				$data["0"] .= '
				<tr>
					<td class="text-right">
						<strong>Matricula Ordinaria (Precios 2024):</strong><br>
						<small>Valor hasta: ' . $sofipagosrematricula->fechaesp($fecha_des_fds) . '</small>
					</td>
					<td class="text-right">
						<font style="vertical-align: inherit;">
							<font style="vertical-align: inherit;">-$ ' . number_format($oferta) . '<br>$ ' . number_format($totaloferta) . '</font>
						</font>
					</td>
				</tr>';
				// las jornadas son en semana
			} else if ($fecha <= $fecha_des_semana) {
				$total_enviar = $totaloferta;
				$data["0"] .= '
				<tr>
					<td class="text-right">
						<strong>Matricula Ordinaria (Precios 2024):</strong><br>
						<small>Valor hasta: ' . $sofipagosrematricula->fechaesp($fecha_des_semana) . '</small>
					</td>
					<td class="text-right">
						<font style="vertical-align: inherit;">
							<font style="vertical-align: inherit;">-$ ' . number_format($oferta) . '<br>$ ' . number_format($totaloferta) . '</font>
						</font>
					</td>
				</tr>';
			}
			if ($fecha <= $fecha_ordinaria_semana && ($jornada_e == "N01" || $jornada_e == "D01")) { // si esta en la fecha del pago ordinario
				$data["0"] .= '				
				<tr>
					<td class="text-right">
						<strong>
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">
									Matrícula Ordinaria (Precios 2025):<br><small>Valor hasta: ' . $sofipagosrematricula->fechaesp($fecha_ordinaria_semana) . '</small>
								</font>
							</font>
						</strong>
					</td>
					<td class="text-right">
						<font style="vertical-align: inherit;">
							<font style="vertical-align: inherit;">
								$ ' . number_format($matricula_ordinariatotal) . '
							</font>
						</font>
					</td>
				</tr>';
			}
			if ($fecha <= $fecha_ordinaria_fds  && ($jornada_e == "F01" || $jornada_e == "S01")) { // si esta en la fecha del pago ordinario
				$data["0"] .= '				
				<tr>
					<td class="text-right">
						<strong>
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">
									Matrícula Ordinaria (Precios 2025):<br><small>Valor hasta: ' . $sofipagosrematricula->fechaesp($fecha_ordinaria_fds) . '</small>
								</font>
							</font>
						</strong>
					</td>
					<td class="text-right">
						<font style="vertical-align: inherit;">
							<font style="vertical-align: inherit;">
								$ ' . number_format($matricula_ordinariatotal) . '
							</font>
						</font>
					</td>
				</tr>';
			}
			if ($fecha <= $fecha_extraordinaria_semana && ($jornada_e == "N01" || $jornada_e == "D01")) { // si esta en la fecha del pago ordinario
				$data["0"] .= '
				<tr>
					<td class="text-right">
						<strong>
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">
									Valor Extraordinaria:<br><small>Fecha limite hasta: ' . $sofipagosrematricula->fechaesp($fecha_extraordinaria_semana) . '</small>
								</font>
							</font>
						</strong>
					</td>
					<td class="text-right">
						<font style="vertical-align: inherit;">
							<font style="vertical-align: inherit;">
								$' . number_format($matricula_extraordinariatotal) . '
							</font>
						</font>
					</td>
				</tr>';
			}
			if ($fecha <= $fecha_extraordinaria_fds  && ($jornada_e == "F01" || $jornada_e == "S01")) { // si esta en la fecha del pago ordinario
				$data["0"] .= '
				<tr>
					<td class="text-right">
						<strong>
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">
									Valor Extraordinaria:<br><small>Fecha limite hasta: ' . $sofipagosrematricula->fechaesp($fecha_extraordinaria_fds) . '</small>
								</font>
							</font>
						</strong>
					</td>
					<td class="text-right">
						<font style="vertical-align: inherit;">
							<font style="vertical-align: inherit;">
								$' . number_format($matricula_extraordinariatotal) . '
							</font>
						</font>
					</td>
				</tr>';
			}
			$buscarticket = $sofipagosrematricula->buscarticket($id_estudiante, $periodo_pecuniario);
			for ($k = 0; $k < count($buscarticket); $k++) {
				if ($buscarticket[$k]["fecha_limite"] >= $fecha) { // si tiene un ticket generado
					$data["0"] .= '
					<tr>
						<td class="text-right">
							<strong>
								<font style="vertical-align: inherit;">
									<font style="vertical-align: inherit;">
										Ticket:<br><small>Fecha limite hasta: ' . $sofipagosrematricula->fechaesp($buscarticket[$k]["fecha_limite"]) . '</small>
									</font>
								</font>
							</strong>
						</td>
						<td class="text-right">
							<font style="vertical-align: inherit;">
								<font style="vertical-align: inherit;">
									$' . number_format($buscarticket[$k]["nuevo_valor"]) . '
								</font>
							</font>
						<a onclick="eliminarticket(' . $buscarticket[$k]["id_ticket"] . ',' . $id_estudiante . ')" class="btn close" style="float:right" title="Eliminar ticket">x</a>
						<!-- 
						=====================================================================
							///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
							===================================================================== --> 
							<form>
								<script src="https://checkout.epayco.co/checkout.js" 
									data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
									class="epayco-button" 
									data-epayco-amount="' . $buscarticket[$k]["nuevo_valor"] . '" 
									data-epayco-tax="0"
									data-epayco-tax-base="' . $buscarticket[$k]["nuevo_valor"] . '"
									data-epayco-name="' . $nombreprograma . '" 
									data-epayco-description="' . $nombreprograma . ' sem. ' . $semestre_estudiante . ' cc. ' . $numero_cedula . '" 
									data-epayco-extra1="' . $numero_cedula . '"
									data-epayco-extra2="' . $id_estudiante . '"
									data-epayco-extra3="' . $ciclo . '"
									data-epayco-extra4="ordinaria-e"
									data-epayco-extra5="' . $buscarticket[$k]["tipo_pago"] . '"
									data-epayco-extra6="' . $buscarticket[$k]["semestre"] . '"
									data-epayco-extra7="ticket"
									data-epayco-currency="cop"    
									data-epayco-country="CO" 
									data-epayco-test="false" 
									data-epayco-external="true" 
									data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
									data-epayco-confirmation="https://ciaf.digital/vistas/pagosagregador.php" 
									data-epayco-button="https://ciaf.digital/public/img/btn-efectivo.png"> 
								</script> 
							</form> <!-- ================================================================== -->
							</td>
					</tr>';
				}
			}
			$data["0"] .= '			
				</tbody>
			</table>';
			$data["0"] .= '';
			//trae datos de la tabla estudiante
			$datostablaestudiantes = $sofipagosrematricula->traerdatostablaestudiante($id_estudiante);
			$id_credencial = $datostablaestudiantes["id_credencial"];
			// trae datos de la tabla credencial estudiante
			$datoscredencial = $sofipagosrematricula->mostrardatos($id_credencial);
			$credencial_identificacion = $datoscredencial["credencial_identificacion"];
			// trae los datos dela tabla sofi persona y sofi matriculas
			$versitienecredito = $sofipagosrematricula->vercreditosofi($credencial_identificacion, $periodo_pecuniario);
			$valortotal = isset($versitienecredito["valor_total"]) ? $versitienecredito["valor_total"] : 0;
			$valorfinanciacion = isset($versitienecredito["valor_financiacion"]) ? $versitienecredito["valor_financiacion"] : 0;
			$id_persona = isset($versitienecredito["id_persona"]) ? $versitienecredito["id_persona"] : 0;
			$btn_credito = "";
			if ($versitienecredito) {
				$btn_credito .= '<a onclick="verestadocredito(' . $id_persona . ')" class="btn-sm btn btn-outline-info "><i class="fas fa-eye"></i> Ver estado crédito</a>';
			}
			$data["0"] .= '		
				</div>
				<div class="col-12 btn-group">
					<a onclick="volver()" class="btn-sm btn btn-outline-secondary text-center"><i class="fas fa-arrow-left"></i> VOLVER</a>
					' . $btn_credito . '
					<a onclick="descargarrecibo(' . $id_estudiante . ')" class="btn-sm btn btn-outline-danger text-center"><i class="fas fa-download"></i> Descargar recibo matricula</a>
					<a onclick="nuevopago(1,' . $id_estudiante . ')" class="btn-sm btn btn-outline-warning">Nuevo valor EPAYCO</a>
					<a onclick="financiacion(' . $id_estudiante . ')" class="btn-sm btn btn-outline-primary">Financiación</a>
					<a onclick="modalAprobarMatricula(' . $id_estudiante . ')" class="btn-sm btn btn-outline-success">Aprobar matricula</a>
				</div>
			</div>';
		}
		$data["0"] .= '			
				</div>
			</div>
		</div>';
		$data["1"] .= $creditosmatriculados;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'nuevopago':
		$data = array();
		$data["0"] = "";
		$data["0"] .= 'hola';


		$results = array($data);
		echo json_encode($results);

		break;

	case 'financiacion':
		$id_estudiante = $_POST["id_estudiante"];
		$data = array();
		$data["identificacion"] = "";
		$data["valortotal"] = "";
		$data["financiacion"] = "";
		$data["valorapagar"] = "";
		$data["estado"] = "";
		$datostablaestudiantes = $sofipagosrematricula->traerdatostablaestudiante($id_estudiante); //trae datos de la tabla estudiante
		$id_credencial = $datostablaestudiantes["id_credencial"];
		$fo_programa = $datostablaestudiantes["fo_programa"];
		$datoscredencial = $sofipagosrematricula->mostrardatos($id_credencial); // trae datos de la tabla credencial estudiante
		$credencial_identificacion = $datoscredencial["credencial_identificacion"];
		$data["identificacion"] .= $credencial_identificacion;
		$consultacreditosofi = $sofipagosrematricula->consultacreditosofi($credencial_identificacion, $periodo_pecuniario); // trae los datos dela tabla sofi persona y sofi matriculas
		@$valortotal = $consultacreditosofi["valor_total"];
		@$valorfinanciacion = $consultacreditosofi["valor_financiacion"];
		$data["valortotal"] .= $valortotal;
		$data["financiacion"] .= $valorfinanciacion;
		$valor_a_pagar = $valortotal - $valorfinanciacion;
		$data["valorapagar"] .= $valor_a_pagar;
		if ($consultacreditosofi) { // si tiene un credito aprobado
			$data["estado"] .= "Aprobado";
		} else {
			$data["estado"] .= "noaprobado";
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'verestadocredito':
		$id_persona = $_POST["id_persona"];
		$data = array();
		$data["0"] = "";
		$verestado = $sofipagosrematricula->verestadocreditosofi($id_persona, $periodo_pecuniario);
		$estado = $verestado["estado"];
		$data["0"] .= "<table class='table table-bordered'>";
		$data["0"] .= "<thead>";
		$data["0"] .= "<tr>";
		$data["0"] .= "<th>Caso Sofi</th>";
		$data["0"] .= "<th>Estado</th>";
		$data["0"] .= "</tr>";
		$data["0"] .= "</thead>";
		$data["0"] .= "<tbody>";
		$data["0"] .= "<tr>";
		$data["0"] .= "<td>" . $id_persona . "</td>";
		$data["0"] .= "<td>" . $estado . "</td>";
		$data["0"] .= "</tr>";
		$data["0"] .= "</tbody>";
		$data["0"] .= "<table>";
		$results = array($data);
		echo json_encode($results);
		break;
	case "selectMotivo":
		$rspta = $sofipagosrematricula->selectMotivo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_motivo"] . "'>" . $rspta[$i]["motivo"] . "</option>";
		}
		break;
	case 'eliminarticket':
		$id_ticket = $_POST["id_ticket"];
		$rspta = $sofipagosrematricula->eliminarticket($id_ticket);
		$data["0"] = $rspta ? "1" : "2";
		$results = array($data);
		echo json_encode($results);
		break;
	case 'AprobarMatricula':
		$crear_factura = 0;
		$cierre_venta = 0;
		$contabilizar = 0;
		$numeroFactura = 0;
		$crear_recibo_caja = 0;
		$id_estudiante_matricula = isset($_POST["id_estudiante_matricula"]) ? $_POST["id_estudiante_matricula"] : "";
		$total_pecuniario = isset($_POST["total_pecuniario"]) ? $_POST["total_pecuniario"] : "";
		$porcentaje_descuento = isset($_POST["porcentaje_descuento"]) ? $_POST["porcentaje_descuento"] : "";
		$tiempo_pago = isset($_POST["tiempo_pago"]) ? $_POST["tiempo_pago"] : "";
		$porcentaje_extraordinaria = isset($_POST["porcentaje_extraordinaria"]) ? $_POST["porcentaje_extraordinaria"] : "";
		$valor_real_pago = isset($_POST["totaloferta"]) ? $_POST["totaloferta"] : "";
		$tipo_pago_matricula = isset($_POST["tipo_pago_matricula"]) ? $_POST["tipo_pago_matricula"] : "";
		$forma_de_pago_fv = isset($_POST["forma_de_pago_fv"]) ? $_POST["forma_de_pago_fv"] : "";
		$forma_de_pago_rc = isset($_POST["forma_de_pago_rc"]) ? $_POST["forma_de_pago_rc"] : "";
		$codigo_producto = isset($_POST["codigo_yeminus"]) ? $_POST["codigo_yeminus"] : "";
		$centro_costo_yeminus = isset($_POST["centro_de_costos"]) ? $_POST["centro_de_costos"] : "";
		$porcentaje_total_aplicado = isset($_POST["porcentaje_total_aplicado"]) ? $_POST["porcentaje_total_aplicado"] : "";
		$valor_descuento = ($total_pecuniario * ($porcentaje_total_aplicado/100))  ;
		//trae los datos del estudiante de la tabla estudiante
		$datosestudiante = $sofipagosrematricula->datosEstudiante($id_estudiante_matricula);
		$id_credencial = $datosestudiante["id_credencial"];
		$fo_programa = $datosestudiante["fo_programa"];
		$jornada_e = $datosestudiante["jornada_e"];
		$ciclo = $datosestudiante["ciclo"];
		$grupo = $datosestudiante["grupo"];
		$semestre_estudiante = $datosestudiante["semestre_estudiante"];
		// trae los datos del semestre progama
		$semestresprograma = $datosestudiante["semestre_programa"];
		//si son iguales los deja asi
		if ($semestresprograma == $semestre_estudiante) {
			//el semestre a matricular toma el valor del total de semestres del programa
			$semestrematricular = $semestresprograma;
		} else {
			//el semestre a matricular toma el valor del semestre actual del estudiante mas uno
			$semestrematricular = $semestre_estudiante + 1;
		}
		$datoscredencial = $sofipagosrematricula->mostrardatos($id_credencial);
		$x_id_factura = $id_estudiante_matricula;
		$identificacion_estudiante = $datoscredencial["credencial_identificacion"];
		$x_description = $fo_programa;
		$x_description = substr($x_description, 0, 50);
		$x_amount_base = $valor_real_pago;
		$x_currency_code = "COP";
		$x_bank_name = "NA";
		$x_respuesta = "Aceptada";
		$x_fecha_transaccion = $fecha;
		$x_franchise = "N/A";
		$x_customer_doctype = "N/A";
		$x_customer_document = $identificacion_estudiante;
		$x_customer_name = $datoscredencial["credencial_nombre"];
		$x_customer_lastname = $datoscredencial["credencial_apellido"];
		$x_customer_email = $datoscredencial["credencial_login"];
		$x_customer_phone = "0000000";
		$x_customer_movil = "N/A";
		$x_customer_ind_pais = "";
		$x_customer_country = "CO";
		$x_customer_city = "";
		$x_customer_address = "";
		$x_customer_ip = $_SERVER['REMOTE_ADDR'];
		$tiempo_pago = "ordinaria-e";
		$realiza_proceso = "Administrativa";
		$id_pagos_rematricula = $sofipagosrematricula->insertarpagorematricula($x_id_factura, $identificacion_estudiante, $id_estudiante_matricula, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $tiempo_pago, $periodo_pecuniario, $tipo_pago_matricula, $semestrematricular, $realiza_proceso);
		/* CREATE TABLE `ciaf_v4`.`gestion_yeminus` (`id_gestion_yeminus` INT(11) NOT NULL AUTO_INCREMENT , `id_pagos_rematricula` TINYINT(1) NULL , `crear_factura` TINYINT(1) NULL , `cerrar_venta` TINYINT(1) NULL , `contabilizar` TINYINT(1) NULL , `crear_recibo_caja` TINYINT(1) NULL , PRIMARY KEY (`id_gestion_yeminus`)) ENGINE = InnoDB; */
		if ($id_pagos_rematricula) {
			/* $id_gestion_yeminus = $sofipagosrematricula->generarGestionYeminus($id_pagos_rematricula);
			// Obtener la fecha y hora actual en formato ISO 8601 con la zona horaria
			$fecha_actual = new DateTime('now', new DateTimeZone('America/Bogota'));
			// Clonar la fecha actual en otra variable
			$fecha_vencimiento = clone $fecha_actual;
			// Añadir 30 días a la fecha futura
			$fecha_vencimiento->modify('+30 days');
			// Obtener las fechas en formato ISO 8601
			$fecha_actual_iso = $fecha_actual->format('c');
			$fecha_vencimiento_iso = $fecha_vencimiento->format('c');
			$documento = array(
				"tipoDocumento" => "FV",
				"prefijo" => "ELEC",
				"numero" => 0,
				"fechaDocumento" => $fecha_actual_iso,
				"fechaVencimiento" => $fecha_vencimiento_iso,
				"codigoTercero1" => $identificacion_estudiante,
				"numeroDeCaja" => "1",
				"descripcionDeCaja" => "SUCURSAL UNICA",
				"codigoFormaPago" => $forma_de_pago_fv,
				"tipoPlazo" => "D",
				"plazo" => 30,
				"codigoVendedor" => "01",
				"observaciones" => $x_description,
				"codigoPatronContable" => "FV1",
				"numeroCaja" => "1",
				"items" => array(
					array(
						"cantidad" => 1,
						"cantidadUnidadMedidaMovimiento" => 1,
						"incluirCalculoCopago" => "S",
						//MIENTRAS SE SOLUCIONA LO DE DENYS
						"producto" => $codigo_producto,
						"descripcionProducto" => $x_description,
						"unidadMedidaProducto" => "und",
						"porcentajeImpuesto" => 0,
						"costoUnitario" => 0,
						"costoTotalSinImpuesto" => 0,
						//traer descuento de la tabla lista_precio_programa
						"porcentajeDescuentoDelPrecio" => $porcentaje_total_aplicado, //32  
						"precioMinimoProducto" => 0,
						"precioUnitario" => $total_pecuniario, //3,474,204
						"precioTotalEnMonedaExtranjera" => 0,
						"precioMonedaExtIncludImpuesto" => 0,
						"valorUnitarioDescuentoPrecio" => 0,
						"valorDescuentoDelPrecio" => $valor_descuento, //1,111,745
						"valorDescuento2" => 0,
						"valorDescuento3" => 0,
						//este no afecta el proceso
						"precioUnitarioNeto" => $total_pecuniario,
						//resta de total y porcentaje
						"precioTotal" => $valor_real_pago, //2,126,700 
						"valorUnitarioImpuestoDelPrecio" => 0,
						"valorImpuestoDelPrecio" => 0,
						//este no afecta el proceso
						"precioUnitarioIncluidoImpuesto" => $total_pecuniario,
						//este si afecta y tiene que tener el valor con el incluido
						"precioTotalIncluidoImpuesto" => $total_pecuniario, //2,126,700 
						"almacen" => "01",
						"centroDeCosto" => $centro_costo_yeminus
					)
				)
			);
			$response = $yeminus->crearFacturaVenta($documento);
			if ($response["exito"] == 1 && isset($response["numero"])) {
				$numeroFactura = $response["numero"];
				$sofipagosrematricula->gestionCreacionDeFactura($id_gestion_yeminus, $numeroFactura );
				$crear_factura = 1;
				$data_pagar_factura = array(
					"valorPagadoSinPropina" => $valor_real_pago,
					"tipoTransaccion" => "FV",
					"prefijo" => "ELEC",
					"numeroFactura" => $numeroFactura,
					"año" => date("Y"),
					"mes" => date("m"),
					"valorPagado" => $valor_real_pago, //valor que toma la funcion para aplicar el cierre
					"fecha" => $fecha_actual_iso,
					"cambio" => 0,
					"propina" => 0,
					"numeroSeparado" => 0,
					"numeroBono" => 0,
					"valorPagadoOriginal" => $valor_real_pago, //este no es el que cuadra la contabilizacion
					"codigoFormaPago" => $forma_de_pago_fv,
					"caja" => "1"
				);
				$response_pagar_documento = $yeminus->PagarDocumento($data_pagar_factura);
				if ($response_pagar_documento["exito"] == 1) {
					$sofipagosrematricula->gestionCierreVenta($id_gestion_yeminus);
					$cierre_venta = 1;
					$tipoDocumento = "FV";
					$prefijo = "ELEC";
					$response_contabilizar_documento = $yeminus->ContabilizarDocumento($tipoDocumento, $prefijo, $numeroFactura, $fecha_actual_iso);
					if ($response_contabilizar_documento["exito"] == 1) {
						$sofipagosrematricula->gestionContabilizar($id_gestion_yeminus);
						$contabilizar = 1;
						$data = array(
							'recibo' => array(
								'tipoDocumento' => 'RC',
								'prefijo' => 'API',
								'numero' => 0,
								'nitCliente' => $identificacion_estudiante,
								'centroCosto' => '',
								'fecha' => $fecha_actual_iso,
								"fechaRealPago" => $fecha_actual_iso,
								"fechaLegalizacion" => $fecha_actual_iso,
								"descripcion" => $x_description,
								"valor" => $x_amount_base,
								"valorNoAplicado" => 0,
								"formaPago" => $forma_de_pago_rc,
								"claseRecibo" => "F",
								"cuentaContableBanco" => $forma_de_pago_rc,
								"factorConversion" => 0,
								"caja" => "1",
								"usuario" => "API",
								"abonos" => array(
									array(
										"numero" => "$tipoDocumento-$prefijo-$numeroFactura",
										"tipoDocumento" => $tipoDocumento,
										"prefijoDocumento" => $prefijo,
										"numeroObligacion" => $numeroFactura,
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
						$response_recibo_caja = $yeminus->CrearReciboCaja($data);
						if ($response_recibo_caja["exito"] == 1) {
							$sofipagosrematricula->gestionCreacionReciboCaja($id_gestion_yeminus);
							$crear_recibo_caja = 1;
						}
					}
				}
			} */ 	
			$data = array("exito" => "1", "info" =>"la matricula fue aprobada", "crear_factura" =>$crear_factura, "crear_recibo_caja" => $crear_recibo_caja, "contabilizar" => $contabilizar, "cierre_venta" => $cierre_venta, "numeroFactura" => $numeroFactura);
		} else {
			$data = array("exito" => "0", "info" => "la matricula no fue aprobada");
		}
		echo json_encode($data);
		break;
	case 'descargarrecibo':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$id_estudiante = $_POST["id_estudiante"];
		$creditosmatriculados = 0;
		$semestrematricular = 1;
		$valorpecuniariototal = "";
		$aporte_socialtotal = "";
		$matricula_extraordinariatotal = "";
		$totaloferta = "";
		$datostablaestudiantes = $sofipagosrematricula->traerdatostablaestudiante($id_estudiante);
		$ciclo = $datostablaestudiantes["ciclo"];
		$compras = $sofipagosrematricula->vercompras($id_estudiante, $ciclo);
		$data["0"] .= '<div id="numcreditos"></div>';
		if (count($compras) == 0) {
			$data["0"] .= '<p class="text-center"><br>Tu carrito esta vacio!</p>';
		} else {
			$data["0"] .= '
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
				<div class="row" style="width:100%">';
			// este for imprimia las materia matriculadas //
			for ($i = 0; $i < count($compras); $i++) {
				$taerdatosmateria = $sofipagosrematricula->traerdatosmateria($compras[$i]["id_materia"]);
				$id_rematricula = $compras[$i]["id_rematricula"];
				$perdida = $compras[$i]["perdida"];
				$nombre_materia = $taerdatosmateria["nombre"];
				$creditos = $taerdatosmateria["creditos"];
				$id_programa_ac = $taerdatosmateria["id_programa_ac"];
				$creditosmatriculados = $creditosmatriculados + $creditos;
			}
			// ********* //
			$traerperiodopecuniario = $sofipagosrematricula->traerperiodopecuniario(); // traer el periodo pecuniario de la tabla periodo actual
			$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
			$descuento = $traerperiodopecuniario[0]["descuento"]; // descuento para pago de contado
			$fecha_des_fds = $traerperiodopecuniario[0]["fecha_des_fds"]; // fecha descuento fds
			$fecha_des_semana = $traerperiodopecuniario[0]["fecha_des_semana"]; // fecha descuento fds
			$fecha_ordinaria = $traerperiodopecuniario[0]["fecha_ordinaria"]; // fecha descuento fds
			$fecha_extraordinaria = $traerperiodopecuniario[0]["fecha_extraordinaria"]; // fecha descuento fds
			$datosPrograma = $sofipagosrematricula->datosPrograma($id_programa_ac); // traer datos del programa
			$semestresprograma = $datosPrograma["semestres"];
			$nombreprograma = $datosPrograma["nombre"];
			$nombreoriginal = $datosPrograma["original"];
			// traer datos de la tabla estudiantes
			$traerdatostablaestudiante = $sofipagosrematricula->traerdatostablaestudiante($id_estudiante);
			$pago_renovar = $traerdatostablaestudiante["pago_renovar"]; // si es 1 es pago normal si es 0, es que viene de nivelatorio
			$semestre_estudiante = $traerdatostablaestudiante["semestre_estudiante"];
			$jornada_e = $traerdatostablaestudiante["jornada_e"];
			$id_credencial = $traerdatostablaestudiante["id_credencial"];
			$traerjornadareal = $sofipagosrematricula->traernombrejornadaespanol($jornada_e); // traer el nombre de la joranda en español
			$jornadaespanol = $traerjornadareal["codigo"];
			/*  condicional para saber el semestre en que queda el estudiante */
			if ($semestresprograma == $semestre_estudiante) {
				$semestrematricular = $semestresprograma;
			} else {
				$semestrematricular = $semestre_estudiante + 1;
			}
			/* ************************* */
			/* buscar los datos de la tabla credencial estudiante */
			$datostablacredencial = $sofipagosrematricula->mostrardatos($id_credencial);
			$numero_cedula = $datostablacredencial["credencial_identificacion"];
			$credencial_nombre = $datostablacredencial["credencial_nombre"];
			$credencial_nombre_2 = $datostablacredencial["credencial_nombre_2"];
			$credencial_apellido = $datostablacredencial["credencial_apellido"];
			$credencial_apellido_2 = $datostablacredencial["credencial_apellido_2"];
			/* ************************************** */
			$creditospermitidos = $datosPrograma["c" . $semestrematricular];
			$tablaprecios = $sofipagosrematricula->tablaprecios($id_programa_ac, $periodo_pecuniario, $semestrematricular, $pago_renovar); // traer los precios del programa
			$matricula_ordinaria = $tablaprecios["matricula_ordinaria"];
			$aporte_social = $tablaprecios["aporte_social"];
			$matricula_extraordinaria = $tablaprecios["matricula_extraordinaria"];
			// traer el valor pecuniario
			$traervalorpecuniario = $sofipagosrematricula->lista_precio_pecuniario($id_programa_ac, $periodo_pecuniario);
			$valorpecuniario = $traervalorpecuniario["valor_pecuniario"];
			$data["0"] .= '<br><div class="col-xl-12" style="padding-top:10px">';
			/* condicional pra saber el valor pecuniario de acuardo al numero de creditos*/
			// si los creditos son menores a 7 es medio semestre medio semestre
			if ($creditosmatriculados <= 7) {
				$valorpecuniariototal = $valorpecuniario / 2;
				$matricula_ordinariatotal = $matricula_ordinaria / 2;
				$aporte_socialtotal = $valorpecuniariototal * ($aporte_social / 100);
				$matricula_extraordinariatotal = $matricula_extraordinaria / 2;
				$data["0"] .= '<div class="alert alert-warning" style="padding:10px; border:1px solid #f5f5f5"> Medio Semestre </div>
					<table class="table table-bordered" width="100%" cellspacing="0px">
							<tbody>
							<tr>
								<td class="text-left" style="border:1px solid #f5f5f5; padding:10px">
									<strong>Programa</strong><br>
									<small>' . $nombreoriginal . '</small>
								</td>
								<td class="text-left" style="border:1px solid #f5f5f5; padding:10px">
									<strong>Jornada</strong> <small>' . $jornadaespanol . '</small><br>
										<strong>Periodo</strong> <small>' . $periodo_pecuniario . '</small>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="border:1px solid #f5f5f5; padding:10px">
									<strong>Nombres y apellidos</strong><br>
									<small>
										' . $credencial_nombre . ' ' . $credencial_nombre_2 . ' 
										' . $credencial_apellido . ' ' . $credencial_apellido_2 . '
									
									</small>
								</td>
								<td class="text-left" style="border:1px solid #f5f5f5; padding:10px">
									<strong>Doc. Identidad</strong><br>
									<small>' . $numero_cedula . '</small>
								</td>
							</tr>
							<tr>
								<td class="text-right" style="text-align:right; padding:10px">
									<strong>
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">Subtotal:<br>
												<span class="text-success">Nuestro Aporte Social</span>:
											</font>
										</font>
									</strong>
								</td>
								<td class="text-right" class="text-right">
									<font style="vertical-align: inherit;">
										<font style="vertical-align: inherit;">$ ' . number_format($valorpecuniariototal) . '<br>- $ ' . number_format($aporte_socialtotal) . '</font>
									</font>
								</td>
							</tr>
							<tr>
								<td class="text-right" style="text-align:right; padding:10px">
									<strong>
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">Matrícula Ordinaria (Precios 2025):<br>Valor Extraordinaria:</font>
										</font>
									</strong>
								</td>
								<td class="text-right"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">$ ' . number_format($matricula_ordinariatotal) . '<br> $ ' . number_format($matricula_extraordinariatotal) . '</font></font></td>
							</tr>';
				$buscarticket = $sofipagosrematricula->buscarticket($id_estudiante, $periodo_pecuniario);
				for ($k = 0; $k < count($buscarticket); $k++) {
					if ($buscarticket[$k]["fecha_limite"] >= $fecha) { // si tiene un ticket generado
						$data["0"] .= '
							<tr>
								<td class="text-right" style="text-align:right; padding:5px 10px">
									<strong>
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">
												Ticket:<br><small>Fecha limite hasta: ' . $sofipagosrematricula->fechaesp($buscarticket[$k]["fecha_limite"]) . '</small>
											</font>
										</font>
									</strong>
								</td>
								<td class="text-right">
									<font style="vertical-align: inherit;">
										<font style="vertical-align: inherit;">
											$' . number_format($buscarticket[$k]["nuevo_valor"]) . '
										</font>
									</font>
								</td>
							</tr>';
					}
				}
				$data["0"] .= '
						</tbody>
					</table>
						<hr>
					<div class="col-12 bg-gray" style="padding:5px"><center>Sede carrera 6 # 24-56 Pereira Tel: 3400 100 www.ciaf.edu.co</center></div>	
					<div class="col-12 text-xs text-center"><i>CIAF Educación Superior SNIES 4825- Personería Jurídica Res. No.19348 - Vigilada Ministerio de Educación</i></div>';
			} else { // semestre completo
				$valorpecuniariototal = $valorpecuniario;
				$matricula_ordinariatotal = $matricula_ordinaria;
				$valorpecuniariototal = $valorpecuniario;
				$matricula_ordinariatotal = $matricula_ordinaria;
				$aporte_socialtotal = $valorpecuniariototal * ($aporte_social / 100);
				$matricula_extraordinariatotal = $matricula_extraordinaria;
				$oferta = $matricula_ordinariatotal * ($descuento / 100); // descuento pago de contado
				$totaloferta = $matricula_ordinariatotal - $oferta;
				$data["0"] .= '
						<table style="width:100%" cellspacing="0">
							  <tbody>
								<tr>
									<td class="text-left" style="border:1px solid #f5f5f5; padding:10px">
								  		<strong>Programa</strong><br>
										<small>' . $nombreoriginal . '</small>
									</td>
									<td class="text-left" style="border:1px solid #f5f5f5; padding:10px">
								  		<strong>Jornada</strong> <small>' . $jornadaespanol . '</small><br>
										  <strong>Periodo</strong> <small>' . $periodo_pecuniario . '</small>
									</td>
								</tr>
								<tr>
									<td class="text-left" style="border:1px solid #f5f5f5; padding:10px">
								  		<strong>Nombres y apellidos</strong><br>
										<small>
											' . $credencial_nombre . ' ' . $credencial_nombre_2 . ' 
											' . $credencial_apellido . ' ' . $credencial_apellido_2 . '
										
										</small>
									</td>
									<td class="text-left" style="border:1px solid #f5f5f5; padding:10px">
								  		<strong>Doc. Identidad</strong><br>
										<small>' . $numero_cedula . '</small>
									</td>
								</tr>
								<tr>
								 	<td class="text-right" style="text-align:right; padding:10px">
										<strong>
											<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
												Subtotal:
											</font>
										</strong>
									</td>
									<td class="text-right">
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">
												$ ' . number_format($valorpecuniariototal) . '
											</font>
										</font>
									</td>
								</tr>
								<tr class="bg-success" bgcolor="#28a745">
									<td class="text-right" style="text-align:right; padding:10px">
								  		<strong>Nuestro Aporte Social:</strong>
									</td>
									<td class="text-right">
								  		<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">-$ ' . number_format($aporte_socialtotal) . '</font>
										</font>
									</td>
								</tr>';
				if ($jornada_e == "F01" or $jornada_e == "S01" and  $fecha <= $fecha_des_fds) { // si las jornadas son fds
					$data["0"] .= '
						<tr>
							<td class="text-right" style="text-align:right; padding:5px 10px">
								<strong>Matrícula Ordinaria (Precios 2024):</strong><br>
								<small>Valor hasta: ' . $sofipagosrematricula->fechaesp($fecha_des_fds) . '</small>
							</td>
							<td class="text-right">
								<font style="vertical-align: inherit;">
									<font style="vertical-align: inherit;">-$ ' . number_format($oferta) . '<br>$ ' . number_format($totaloferta) . '</font>
								</font>
							</td>
							
						</tr>';
				} else if ($fecha <= $fecha_des_semana) { // las jornadas son en semana
					$total_enviar = $totaloferta;

					$data["0"] .= '
						<tr>
							<td class="text-right" style="text-align:right; padding:5px 10px">
								<strong>Matrícula Ordinaria (Precios 2024):</strong><br>
								<small>Valor hasta: ' . $sofipagosrematricula->fechaesp($fecha_des_semana) . '</small>
							</td>
							<td class="text-right">
								<font style="vertical-align: inherit;">
									<font style="vertical-align: inherit;">-$ ' . number_format($oferta) . '<br>$ ' . number_format($totaloferta) . '</font>
								</font>
							</td>
						</tr>';
				}
				if ($fecha <= $fecha_ordinaria) { // si esta en la fecha del pago ordinario
					$data["0"] .= '				
						<tr>
							<td class="text-right" style="text-align:right; padding:5px 10px">
								<strong>
									<font style="vertical-align: inherit;">
										<font style="vertical-align: inherit;">
											Matrícula Ordinaria (Precios 2025):<br><small>Valor hasta: ' . $sofipagosrematricula->fechaesp($fecha_ordinaria) . '</small>
										</font>
									</font>
								</strong>
							</td>
							<td class="text-right">
								<font style="vertical-align: inherit;">
									<font style="vertical-align: inherit;">
										$ ' . number_format($matricula_ordinariatotal) . '
									</font>
								</font>
							</td>
						</tr>';
				}
				if ($fecha <= $fecha_extraordinaria) { // si esta en la fecha del pago ordinario
					$data["0"] .= '
						<tr>
							<td class="text-right" style="text-align:right; padding:5px 10px">
								<strong>
									<font style="vertical-align: inherit;">
										<font style="vertical-align: inherit;">
											Valor Extraordinaria:<br><small>Fecha limite hasta: ' . $sofipagosrematricula->fechaesp($fecha_extraordinaria) . '</small>
										</font>
									</font>
								</strong>
							</td>
							<td class="text-right">
								<font style="vertical-align: inherit;">
									<font style="vertical-align: inherit;">
										$' . number_format($matricula_extraordinariatotal) . '
									</font>
								</font>
							</td>
						</tr>';
				}
				$buscarticket = $sofipagosrematricula->buscarticket($id_estudiante, $periodo_pecuniario);

				for ($k = 0; $k < count($buscarticket); $k++) {

					if ($buscarticket[$k]["fecha_limite"] >= $fecha) { // si tiene un ticket generado
						$data["0"] .= '<tr>
								<td class="text-right" style="text-align:right; padding:5px 10px">
									<strong>
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">
												Ticket:<br><small>Fecha limite hasta: ' . $sofipagosrematricula->fechaesp($buscarticket[$k]["fecha_limite"]) . '</small>
											</font>
										</font>
									</strong>
								</td>
								<td class="text-right">
									<font style="vertical-align: inherit;">
										<font style="vertical-align: inherit;">
											$' . number_format($buscarticket[$k]["nuevo_valor"]) . '
										</font>
									</font>
								</td>
							</tr>';
					}
				}
				$data["0"] .= '			
							</tbody>
					</table>
					<hr>
				<div class="col-12 bg-gray" style="padding:5px"><center>Sede carrera 6 # 24-56 Pereira Tel: 3400 100 www.ciaf.edu.co</center> </div>	
				<div class="col-12 text-xs text-center"> <i> CIAF Educación Superior SNIES 4825- Personería Jurídica Res. No.19348 - Vigilada Ministerio de Educación</i> </div>';
			}
			$data["0"] .= '		
				</div>
			</div>';
		}
		$data["0"] .= '			
				</div>
			</div>
		</div>';
		$data["1"] .= $creditosmatriculados;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'generarDatosMatricula':
		$id_estudiante = isset($_POST["id_estudiante"]) ? $_POST["id_estudiante"] : 0;
		$datos_estudiante = $sofipagosrematricula->datosEstudiante($id_estudiante);
		if (isset($datos_estudiante["id_credencial"])) {
			$semestre_estudiante = $datos_estudiante["semestre_estudiante"];
			$semestre_estudiante++;
			$semestre_programa = $datos_estudiante["semestre_programa"];
			$id_programa_ac = $datos_estudiante["id_programa_ac"];
			$centro_costo_yeminus = $datos_estudiante["centro_costo_yeminus"];
			$codigo_producto = $datos_estudiante["codigo_producto"];
			$pago_renovar = $datos_estudiante["pago_renovar"];
			$dato_pecuniario = $sofipagosrematricula->lista_precio_pecuniario($id_programa_ac, $periodo_pecuniario);
			//verifica que haya un valor pecuniario
			if(isset($dato_pecuniario["valor_pecuniario"])){
				$valor_pecuniario = $dato_pecuniario["valor_pecuniario"];
				$dato_precio_programa = $sofipagosrematricula->tablaprecios($id_programa_ac, $periodo_pecuniario, $semestre_estudiante, $pago_renovar);
				if (isset($dato_precio_programa["id_lista_precio_programa"])) {
					$aporte_social = $dato_precio_programa["aporte_social"];
					$data = array(
						"exito" => 1,
						"valor_pecuniario" => $valor_pecuniario,
						"aporte_social" => $aporte_social,
						"centro_costo_yeminus" => $centro_costo_yeminus,
						"codigo_producto" => $codigo_producto,
					);
				} else {
					$data = array("exito" => 0, "info" => "No hay un procentaje de Nuestro aporte social para este programa.");
				}
			}else{
				$data = array("exito" => 0, "info" => "No hay un valor pecuniario para este programa.");
			}
		} else {
			$data = array("exito" => 0, "info" => "El estudiante no existe - $id_estudiante.");
		}
		echo json_encode($data);
		break;

		
	case 'nuevonivel':
		//generar array vacio
		$data = array();
		//posicion 0 vacia
		$data["0"] = "";

		$nuevoidprograma = $_POST["nuevoid"];
		$id_credencial=$_POST["id_credencial"];
		$jornada_e = "N01";
		$grupo = 1;

		/* datos para la malla actual */
		$id_estudiante = $_POST["est"];
		$id_programa_ac = $_POST["pac"];
		$ciclo = $_POST["cic"];
		/* ******************** */

		$nuevo_nivel = $sofipagosrematricula->datosPrograma($nuevoidprograma);
		$nuevo_id = $nuevo_nivel["id_programa"];
		$nuevo_programa = $nuevo_nivel["nombre"];
		$nuevo_ciclo = $nuevo_nivel["ciclo"];
		$escuela_ciaf = $nuevo_nivel["escuela"];
		$periodo_ingreso = $periodo_pecuniario;
		$periodo_activo = $periodo_pecuniario;
		$id_usuario_matriculo = $_SESSION['id_usuario'];
		$admisiones = "no";
		$pago = "1";
		$rr = 0;

		$buscarmateriasperdidas = $sofipagosrematricula->buscarmateriasperdidas($ciclo, $id_estudiante, $id_programa_ac);


		if ($buscarmateriasperdidas) { //verificar si tiene materias perdidas
			$data["0"] .= 'perdio';
		} else { // todo esta bien
			$tienenuevonivel = $sofipagosrematricula->mirarnuevoprograma($id_credencial, $nuevo_id);
			if ($tienenuevonivel) {
				$data["0"] .= 'negado';
			} else {

				$rspta = $sofipagosrematricula->insertarnuevoprograma($id_credencial, $nuevo_id, $nuevo_programa, $jornada_e, $escuela_ciaf, $periodo_ingreso, $nuevo_ciclo, $periodo_activo, $grupo, $id_usuario_matriculo, $fecha, $hora, $admisiones, $pago);
				$data["0"] .= 'ok';
			}
		}


		$results = array($data);
		echo json_encode($results);
		break;



		/* 
		Aprobar matricula
		$datoscredencial = $sofipagosrematricula->mostrardatos($id_credencial);// trae datos de la tabla credencial estudiante
		$datospagas = $sofipagosrematricula->seleccionarMateriasPagas($id_estudiante,$ciclo);// trae el dato de las materias matriculadas
		for ($i = 0; $i < count($datospagas); $i++){// inserta las materias en la tabla materias
			$id_materia = $datospagas[$i]["id_materia"];
			$datosmateria = $sofipagosrematricula->traerdatosmateria($id_materia);// trae los datos de las materias
			$nombre_materia = $datosmateria["nombre"];
			$semestre = $datosmateria["semestre"];
			$creditos = $datosmateria["creditos"];
			$id_programa_ac = $datosmateria["id_programa_ac"];
			// inserta las materias pagas en la tabla materias
			$rspta4 = $sofipagosrematricula->insertarmateria($id_estudiante, $nombre_materia, $jornada_e, $periodo_pecuniario, $semestre,$creditos, $id_programa_ac, $ciclo, $fecha, $usuario, $grupo);
		}
		// actualiza el periodo activo en la tabla estudiante
		$actualizarperiodoactivo = $sofipagosrematricula->actualizarperiodoactivo($periodo_pecuniario,$id_estudiante);
		/* codigo para actualiar el periodo 
		$rspta6 = $sofipagosrematricula->creditosMatriculados($id_estudiante,$ciclo);//suma el total de creditos matriculados
		$creditos_matriculados=$rspta6["suma_creditos"];
		$rspta7 = $sofipagosrematricula->datosPrograma($id_programa_ac);// trae creditos por semestre
		$inicio_semestre=$rspta7["inicio_semestre"];
		$semestres_del_programa=$rspta7["semestres"];
		$semestre_nuevo=0;
		$suma_creditos_tabla=0;
		while($inicio_semestre <= $semestres_del_programa){
			$campo="c".$inicio_semestre;
			$semestre_nuevo++;		
			$suma_creditos_tabla+=$rspta7[$campo];
			if($creditos_matriculados <= $suma_creditos_tabla){
				$inicio_semestre = $semestres_del_programa+1;
			}else{
				$inicio_semestre++;
			}
			$rspta8 = $sofipagosrematricula->actualizarsemestre($id_estudiante,$semestre_nuevo);// traer creditos por semestre
		} */
		/* ********************************** */

	}


