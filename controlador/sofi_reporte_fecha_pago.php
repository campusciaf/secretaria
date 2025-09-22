<?php
session_start();
date_default_timezone_set("America/Bogota");
require_once "../modelos/SofiReporteFechaPago.php";
$reporte_fecha_pago = new SofiReporteFechaPago();
$dato_busqueda = isset($_POST["dato_busqueda"]) ? $_POST["dato_busqueda"] : "";
$tipo_busqueda = isset($_POST["tipo_busqueda"]) ? $_POST["tipo_busqueda"] : "";
switch ($_GET["op"]) {
	case 'selectPeriodo':
		$rspta = $reporte_fecha_pago->listarPeriodos();
		echo json_encode($rspta);
		break;
	case 'listar':
		if($tipo_busqueda == "dia"){
			$inicio = $dato_busqueda["inicio"];
			$fin = $dato_busqueda["fin"];
			$datos = $reporte_fecha_pago->listarPagosPorDia($inicio, $fin);
		}else if($tipo_busqueda == "porFechaPago"){
			$inicio = $dato_busqueda["inicio"];
			$fin = $dato_busqueda["fin"];
			$datos = $reporte_fecha_pago->porFechaPago($inicio, $fin);
		}else if($tipo_busqueda == "identificacion"){
			$datos = $reporte_fecha_pago->listarPagosPorIdentificacion($dato_busqueda);
		}else if ($tipo_busqueda == "periodo") {
			$datos = $reporte_fecha_pago->listarPagosPorPeriodo($dato_busqueda);
		}
		$data = array();
		for ($i = 0; $i < count($datos); $i++) {
			$consecutivo = $datos[$i]["consecutivo"];
			$numero_documento = $datos[$i]["numero_documento"];
			$nombres = $datos[$i]["nombres"];
			$apellidos = $datos[$i]["apellidos"];
			$celular = $datos[$i]["celular"];
			$email = $datos[$i]["email"];
			$numero_cuota = $datos[$i]["numero_cuota"];
			$fecha_pago = $datos[$i]["fecha_pago"];
			$fecha_pagada = $datos[$i]["fecha_pagada"];
			$valor_pagado = $datos[$i]["valor_pagado"];
			$periodo = $datos[$i]["periodo"];
			$semestre_estudiante = $reporte_fecha_pago->traersemestre($id_estudiante);
			$data[] = array(
				"0" => $consecutivo,
				"1" => $numero_documento,
				"2" => $nombres,
				"3" => $apellidos,
				"4" => $celular,
				"5" => $email,
				"6" => $numero_cuota,
				"7" => $fecha_pago,
				"8" => $fecha_pagada,
				"9" => $valor_pagado,
				"10" =>$periodo,
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
}