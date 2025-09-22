<?php
session_start();
require_once "../modelos/Docente_Reporte.php";
$docente_reporte = new Docente_Reporte();
$periodo = isset($_POST["periodo"]) ? limpiarCadena($_POST["periodo"]) : "";
$escuela = isset($_POST["escuela"]) ? limpiarCadena($_POST["escuela"]) : "";
$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$observacion = isset($_POST["observacion"]) ? limpiarCadena($_POST["observacion"]) : "";
$id_convenir = isset($_POST["id_convenir"]) ? limpiarCadena($_POST["id_convenir"]) : "";

switch ($_GET["op"]) {

	//listamos los docentes por periodo
	case 'listar':
		$periodo = $_GET["periodo"];

		// Obtener los grupos
		$grupos = $docente_reporte->listarGrupos($periodo);
		$data = array();

		foreach ($grupos as $grupo) {

			$docenteDetails = $docente_reporte->listar_docentes($grupo['id_docente']);

			if (!empty($docenteDetails)) {
				$usuario_identificacion_contrato = $docenteDetails[0]['usuario_identificacion'];

				$nombre_docente = $docenteDetails[0]["usuario_nombre"] . " " . $docenteDetails[0]["usuario_nombre_2"] . " " . $docenteDetails[0]["usuario_apellido"] . " " . $docenteDetails[0]["usuario_apellido_2"];


				$id_docente = $grupo['id_docente'];

				$usuario_celular = $docenteDetails[0]["usuario_celular"];
				$usuario_telefono = $docenteDetails[0]["usuario_telefono"];


				$usuario_email_p = $docenteDetails[0]["usuario_email_p"];
				$usuario_email_ciaf = $docenteDetails[0]["usuario_email_ciaf"];
				$usuario_genero = $docenteDetails[0]["usuario_genero"];



				$usuario_cargo = $docente_reporte->MostrarCargoDocentes($usuario_identificacion_contrato, $periodo);
				if ($usuario_cargo) {
					$ultimo_contrato = $usuario_cargo['tipo_contrato'];
				} else {
					$ultimo_contrato = '';
				}

				$mis_horas = 0;
				$grupos_individual = 0;
				$grupos = $docente_reporte->listarGrupos_3($grupo['id_docente'], $periodo);
				// $total_grupos = count($grupos);



				for ($j = 0; $j < count($grupos); $j++) {
					$grupos_individual = $j + 1;
					$diaclase = $grupos[$j]["dia"];
					$diferencia = $grupos[$j]["diferencia"];
					$corte = $grupos[$j]["corte"];
					$mis_horas = $diferencia;
				}

				$data[] = array(
					"0" => "<img src='../files/docentes/" . $usuario_identificacion_contrato . ".jpg' height='40px' width='40px' >",
					"1" => $usuario_identificacion_contrato,
					"2" => $nombre_docente,
					"3" => '<div class="tooltips">' . $usuario_celular . '<span class="tooltiptext">' . $usuario_telefono . ' ' . $usuario_celular . '</span></div>',
					"4" => '<div class="tooltips">' . $usuario_email_p . '<span class="tooltiptext">' . $usuario_email_p . ' ' . $usuario_email_ciaf . '</span></div>',
					"5" => $ultimo_contrato,
					"6" => $usuario_genero,
					"7" => $mis_horas,
					"8" => $corte,
					"9" => $grupos_individual
				);
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

	case "selectPeriodo":
		$rspta = $docente_reporte->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
		break;
}
