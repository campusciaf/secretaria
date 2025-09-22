<?php
session_start();
require_once "../modelos/OncenterReferidos.php";
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$oncenterreferidos = new OncenterReferidos();
$rsptaperiodo = $oncenterreferidos->periodoactual();
$periodo_campana = $rsptaperiodo["periodo_campana"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
$periodo_medible = $rsptaperiodo["periodo_medible"];
$periodo_actual = $_SESSION['periodo_actual'];
switch ($_GET["op"]) {
	case 'periodo':
		$data = array();
		$rsptaperiodo = $oncenterreferidos->periodoactual();
		$periodo_campana = $rsptaperiodo["periodo_campana"];
		$data["periodo"] = $periodo_campana;
		echo json_encode($data);
		break;
	case 'listar':
		$periodo_campana = $_GET["periodo_campana"];
		$rspta = $oncenterreferidos->listar($periodo_campana);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$datosrefierea = $oncenterreferidos->refierea($reg[$i]["id_estudiante"]);
			$data[] = array(
				"0" => $reg[$i]["nombre"],
				"1" => $reg[$i]["correo"],
				"2" => $reg[$i]["celular"],
				"3" => $oncenterreferidos->fechaesp($reg[$i]["fecha"]),
				"4" => @$datosrefierea["nombre"] . ' ' . @$datosrefierea["nombre_2"] . ' ' . @$datosrefierea["apellidos"] . ' ' . @$datosrefierea["apellidos_2"],
				"5" => @$datosrefierea["id_estudiante"],
				"6" => @$datosrefierea["estado"]
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
	case "selectCampana":
		$rspta = $oncenterreferidos->selectCampana();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
		break;
	case 'listarDatos':
		$nuevafecha = strtotime('-1 year', strtotime($fecha)); //Se quita un año para comparar con el año pasado los datos
		$nuevafecha = date('Y-m-d', $nuevafecha);
		$data = array(); //Vamos a declarar un array
		$data["data1"] = ""; //iniciamos el arreglo
		$rspta = $oncenterreferidos->listarDatos($periodo_campana); // referidos campaña actual
		$rspta3 = $oncenterreferidos->listarDatosFecha($periodo_medible, $nuevafecha); // referidos en la campaña medible (la de hace un año)
		$rspta4 = $oncenterreferidos->listarReferidoEstado($periodo_campana, 'Matriculado'); // referidos en estado matriculado
		$rspta5 = $oncenterreferidos->listarReferidoEstado($periodo_campana, 'Seleccionado'); // referidos en estado seleccionado
		$rspta6 = $oncenterreferidos->listarReferidoEstado($periodo_campana, 'Interesado'); // referidos en estado insteresado
		$avance = $oncenterreferidos->calPorcentaje(count($rspta), count($rspta3));
		if ($avance > 0) {
			$davance = '<span class="text-success">' . @round($avance, 2) . ' % <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></span>';
		} else {
			$davance = '<span class="text-danger">' . @round($avance, 2) . ' % <i class="fa-solid fa-arrow-down"></i></span>';
		}
		$data["data1"] .= '
			<div class="col-xl-6 col-12 py-1 pl-xl-4 m-0 ml-xl-0 ml-4" id="t-data">
				<h5 class="fw-light mb-4 text-secondary">Referidos,</h5>
				<h1 class="titulo-2 fs-36 text-semibold"><span>' . count($rspta) . '</span> <small>a la fecha</small></h1>
				<h5 class="titulo-2 fs-18 text-semibold"><span title="Entrevistas validadas campaña comparada">' . count($rspta3) . '</span> <small>' . $davance . '</small></h5>
			</div>
			<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 d-flex align-items-center">
				<div class="row col-12 d-flex justify-content-end">
					<div class="col-auto" id="t-data2">
						<div class="row justify-content-center">
							<div class="col-12 hidden">
									<div class="row align-items-center">
										<div class="col-auto">
										<div class="avatar rounded bg-light-blue text-primary">
											<i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
										</div>
										</div>
										<div class="col ps-0">
										<div class="small mb-0">Total</div>
										<h4 class="text-dark mb-0">
												<span class="text-semibold" id="dato_caracterizados">' . count($rspta6) . '</span> 
										</h4>
										<div class="small">Interesados <span class="text-green"></span></div>
										</div>
									</div>
							</div>
						</div>
					</div>
					<div class="col-auto" id="t-data3">
						<div class="row justify-content-center">
							<div class="col-12 hidden">
									<div class="row align-items-center">
										<div class="col-auto">
										<div class="avatar rounded bg-light-yellow text-warning">
											<i class="fa-solid fa-xmark" aria-hidden="true"></i>
										</div>
										</div>
										<div class="col ps-0">
										<div class="small mb-0">Total</div>
										<h4 class="text-dark mb-0">
											<span class="text-semibold" id="dato_caracterizados">' . count($rspta5) . '</span> 
										</h4>
										<div class="small">Seleccionado <span class="text-green"></span></div>
										</div>
									</div>
							</div>
						</div>
					</div>
					<div class="col-auto" id="t-data4">
						<div class="row justify-content-center">
							<div class="col-12 hidden">
								<div class="row align-items-center">
									<div class="col-auto">
										<div class="avatar rounded bg-light-green text-success">
											<i class="fa-solid fa-check" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col ps-0">
										<div class="small mb-0">Total</div>
										<h4 class="text-dark mb-0">
											<span class="text-semibold" id="dato_caracterizados">' . count($rspta4) . '</span> 
										</h4>
										<div class="small">Matriculados <span class="text-green"></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		';
		echo json_encode($data);
		break;
}
