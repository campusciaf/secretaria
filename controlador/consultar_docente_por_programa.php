<?php
require_once "../modelos/ConsultarDocentePorPrograma.php";
$consulta_por_programa = new ConsultarDocentePorPrograma();
switch ($_GET["op"]) {
	case 'listarprogramaconsultados':
		$periodos = $consulta_por_programa->periodoactual();
		$periodo_actual = $periodos["periodo_actual"];
		$ciclo_escuela = $_GET["ciclo_escuela"];
		$rspta = $consulta_por_programa->programas($ciclo_escuela);
		$data = array();
		$listar = $rspta;
		for ($i = 0; $i < count($listar); $i++) {
			$usuario_cargo = $consulta_por_programa->MostrarContratoDocentes($listar[$i]['usuario_identificacion'],$periodo_actual);
			if ($usuario_cargo) {
				$ultimo_contrato = $usuario_cargo['tipo_contrato'];
			} else {
				$ultimo_contrato = ''; 
			}
			$nombre_docente = trim($listar[$i]["usuario_nombre"] . ' ' .$listar[$i]["usuario_nombre_2"] . ' ' .$listar[$i]["usuario_apellido"] . ' ' .$listar[$i]["usuario_apellido_2"]
			);
			$data[] = array(
				"0" => $nombre_docente,
				"1" => $listar[$i]["usuario_identificacion"],
				"2" => $listar[$i]["usuario_email_ciaf"],
				"3" => $listar[$i]["usuario_celular"],
				"4" => $ultimo_contrato
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);

		echo json_encode($results);
		break;
}
