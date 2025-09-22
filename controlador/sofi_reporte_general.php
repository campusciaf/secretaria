<?php
session_start();
require_once "../modelos/SofiReporteGeneral.php";
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:S');
$sofiReporteGeneral = new sofiReporteGeneral();
$periodo = isset($_POST['periodo'])? $_POST['periodo']: $_SESSION['periodo_campaña'];
switch ($_GET["op"]) {
	case 'listar_estudiantes':
		//definir array 
		$data = array();
		//consecutivos creados en sofi_matricula
		$pagos_creditos = $sofiReporteGeneral->listar_creditos($periodo);
		//pagos rematricula
		$pagos_rematricula = $sofiReporteGeneral->listar_rematricula($periodo);
		$pagos_web = $sofiReporteGeneral->listar_pagos_web($periodo);
		$pagos_sofi_de_contado = $sofiReporteGeneral->listar_pagos_sofi_de_contado($periodo);
		$datos_pago = array_merge($pagos_creditos, $pagos_rematricula, $pagos_web, $pagos_sofi_de_contado);
		//ciclo de iteracion para cada una de las listas
		for ($i = 0; $i < count($datos_pago); $i++) {
			$data[] = array(
				"0" => $datos_pago[$i]["numero_documento"],
				"1" => $datos_pago[$i]["nombres"] . " " . $datos_pago[$i]["apellidos"],
				"2" => @$datos_pago[$i]["semestre"],
				"3" => @$datos_pago[$i]["jornada"],
				"4" => @$datos_pago[$i]["id_programa"],
				"5" => $datos_pago[$i]["programa"],
				"6" => 0,
				"7" => @$datos_pago[$i]["valor_total"],
				"8" => 0,
				"9" => @$datos_pago[$i]["valor_pagado"],	
				"10" => 0,
				"11" => @$datos_pago[$i]["valor_financiacion"],
				"12" => $datos_pago[$i]["tipo_matricula"],
				"13" => "",
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
	/* case 'listar_estudiantes_antiguo':
		//almacenar tipo de busqueda elegida por el usuario 
		$tipo_busqueda = $_POST["tipo_busqueda"];
		//definimos este arreglo para cuando seleccionen todos que interactue por cada uno de las funciones
		$arreglo_informacion_estudiante = array();
		//obtener escuelas
		$listarescuelas = $sofiReporteGeneral->listarEscuelas();
		for ($c = 0; $c < count($listarescuelas) ; $c++) {
			//alamcenar el nombre de la escuela en la clave del id
			$escuela[$listarescuelas[$c]["id_escuelas"]] =  $listarescuelas[$c]["escuelas"];
		}
		//definir array 
		$data = array(); 
		//dependiendo del tipo de busqueda, entra al if especifico
		if ($tipo_busqueda == "nuevos") {
			//lista todos los estudiantes que son nuevos 
			$informacion_estudiante = $sofiReporteGeneral->listarTotalEstudiantesNuevos($periodo);
			//almacenar la informacion y el tipo de estudiante
			$arreglo_informacion_estudiante[] = array("Nuevos", $informacion_estudiante);  
		}elseif($tipo_busqueda == "homologados"){
			//lista todos los estudiantes que son homologados 
			$informacion_estudiante = $sofiReporteGeneral->listarTotalHomologados($periodo);
			//almacenar la informacion y el tipo de estudiante
			$arreglo_informacion_estudiante[] = array("Homologación", $informacion_estudiante);
		}elseif ($tipo_busqueda == "internos") {
			//lista todos los estudiantes que son internos 
			$informacion_estudiante = $sofiReporteGeneral->listarTotalInternos($periodo);
			//almacenar la informacion y el tipo de estudiante
			$arreglo_informacion_estudiante[] = array("Interno", $informacion_estudiante);
		}elseif ($tipo_busqueda == "rematricula") {
			//lista todos los estudiantes que son internos 
			$informacion_estudiante = $sofiReporteGeneral->listarTotalRematriculas($periodo);
			//almacenar la informacion y el tipo de estudiante
			$arreglo_informacion_estudiante[] = array("Rematricula", $informacion_estudiante);
		}elseif ($tipo_busqueda == "todos") {
			//lista todos los estudiantes que son nuevos 
			$informacion_estudiante = $sofiReporteGeneral->listarTotalEstudiantesNuevos($periodo);
			//almacenar la informacion y el tipo de estudiante
			$arreglo_informacion_estudiante[] = array("Nuevos", $informacion_estudiante);
			//lista todos los estudiantes que son homologados 
			$informacion_estudiante = $sofiReporteGeneral->listarTotalHomologados($periodo);
			//almacenar la informacion y el tipo de estudiante
			$arreglo_informacion_estudiante[] = array("Homologación", $informacion_estudiante);
			//lista todos los estudiantes que son internos 
			$informacion_estudiante = $sofiReporteGeneral->listarTotalInternos($periodo);
			//almacenar la informacion y el tipo de estudiante
			$arreglo_informacion_estudiante[] = array("Interno", $informacion_estudiante);
			//lista todos los estudiantes que son internos 
			$informacion_estudiante = $sofiReporteGeneral->listarTotalRematriculas($periodo);
			//almacenar la informacion y el tipo de estudiante
			$arreglo_informacion_estudiante[] = array("Rematricula", $informacion_estudiante);
		}
		//ciclo de iteracion para cada una de las listas
		for ($a = 0; $a < count($arreglo_informacion_estudiante) ; $a++) {
			//obtenemos la informacion de los estudiante 
			$informacion_estudiante = $arreglo_informacion_estudiante[$a][1];
			//ciclo de iteracion para ir por cada uno de los estudiantes
			for ($i = 0; $i < count($informacion_estudiante); $i++) {
				//almacenar numero de documento
				$numero_documento = $informacion_estudiante[$i]["credencial_identificacion"];
				//almacenar el id del programa al cual se matriculo
				$id_programa_ac = $informacion_estudiante[$i]["id_programa_ac"];
				//obtenemos datos del credito, solo si tiene un credito en sofi
				$verificar_credito = $sofiReporteGeneral->VerificarCreditoSofi($numero_documento, $periodo);
				//Almacenar el valor pecuniario del programa
				$valor_pecuniario = $sofiReporteGeneral->listarPrecioPecuniario($id_programa_ac, $periodo);
				//Obtener datos sobre aporte social 
				$datos_aporte_social = $sofiReporteGeneral->listarAporteSocial($id_programa_ac, $informacion_estudiante[$i]["semestre_estudiante"], $periodo);
				//calculo de valor de aporte, basado en el valor pecuniario
				$valor_aporte = round((@$valor_pecuniario * @$datos_aporte_social["aporte_social"]) / 100);
				//si existe la variable id quiere decir que si existe un credito
				if (isset($verificar_credito["id"])) {
					//por medio del id de la persona en la tabla sofi_persona, traemos el valor del abono
					$datos_ticket_financiacion = $sofiReporteGeneral->listarValorTicket($verificar_credito["id_persona"]);
					//almacenar el valor del ticket
					$valor_ticket = @$datos_ticket_financiacion["valor_ticket"];
					//almacenar el valor del descuento
					$valor_descuento = @$datos_ticket_financiacion["valor_descuento"];
					//almacenar todas las variables para el datatable
					$data[] = array(
						"0" => $informacion_estudiante[$i]["credencial_identificacion"],
						"1" => $informacion_estudiante[$i]["credencial_nombre"] . " " . $informacion_estudiante[$i]["credencial_nombre_2"] . " " . $informacion_estudiante[$i]["credencial_apellido"] . " " . $informacion_estudiante[$i]["credencial_apellido_2"],
						"2" => $informacion_estudiante[$i]["semestre_estudiante"],
						"3" => $informacion_estudiante[$i]["jornada_e"],
						"4" => $escuela[$informacion_estudiante[$i]["escuela_ciaf"]],
						"5" => $informacion_estudiante[$i]["fo_programa"],
						"6" => $valor_pecuniario,
						"7" => @$datos_aporte_social["matricula_ordinaria"],
						"8" => $valor_aporte,
						"9" => $valor_ticket,
						"10" => $valor_descuento,
						"11" => $verificar_credito["valor_financiacion"],
						"12" => "Financiado",
						"13" => $arreglo_informacion_estudiante[$a][0],
					);
				} else {
					$valor_pagado = 0;
					$descuento = 0;
					$verificar_de_contado = $sofiReporteGeneral->VerificarDeContadoSofi($numero_documento, $periodo);
					if (isset($verificar_de_contado["valor_pagado"])) {
						$valor_pagado = @$verificar_de_contado["valor_pagado"];
						$descuento = @$verificar_de_contado["descuento"];
						$tiempo_pago = @$verificar_de_contado["tiempo_pago"];
					} else {
						$verificar_pago_web = $sofiReporteGeneral->VerificarPagosWebPse($numero_documento, $periodo);
						if (isset($verificar_pago_web["x_amount_base"])) {
							$valor_pagado = @$verificar_pago_web["x_amount_base"];
							$tiempo_pago = @$verificar_pago_web["tiempo_pago"];
						} else {
							$verificar_pago_rematricula = $sofiReporteGeneral->VerificarPagosRematricula($numero_documento, $periodo);
							if (isset($verificar_pago_rematricula["x_amount_base"])) {
								$valor_pagado = @$verificar_pago_rematricula["x_amount_base"];
								$tiempo_pago = @$verificar_pago_rematricula["tiempo_pago"];
							}
						}
					}
					$data[] = array(
						"0" => $informacion_estudiante[$i]["credencial_identificacion"],
						"1" => $informacion_estudiante[$i]["credencial_nombre"] . " " . $informacion_estudiante[$i]["credencial_nombre_2"] . " " . $informacion_estudiante[$i]["credencial_apellido"] . " " . $informacion_estudiante[$i]["credencial_apellido_2"],
						"2" => $informacion_estudiante[$i]["semestre_estudiante"],
						"3" => $informacion_estudiante[$i]["jornada_e"],
						"4" => $escuela[$informacion_estudiante[$i]["escuela_ciaf"]],
						"5" => $informacion_estudiante[$i]["fo_programa"],
						"6" => $valor_pecuniario,
						"7" => @$datos_aporte_social["matricula_ordinaria"],
						"8" => $valor_aporte,
						"9" => $valor_pagado,
						"10" => $descuento,
						"11" => 0,
						"12" => @$tiempo_pago,
						"13" => $arreglo_informacion_estudiante[$a][0],
					);
				}
			}
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
		*/
}
