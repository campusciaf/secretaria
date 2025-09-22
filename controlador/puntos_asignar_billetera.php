<?php
session_start();
require_once "../modelos/PuntosAsignarBilletera.php";
$puntos_billetera = new PuntosAsignarBilletera();
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');
$periodos = $puntos_billetera->periodoactual();
$periodo_actual_historico = $periodos["periodo_actual"];
switch ($_GET["op"]) {
	case 'listar':
		$reg = $puntos_billetera->listar();
		//Vamos a declarar un array
		$data = array();
		for ($i = 0; $i < count($reg); $i++) {
			$nombres = $reg[$i]['usuario_nombre'] . ' ' . $reg[$i]['usuario_nombre_2'];
			$apellidos = $reg[$i]['usuario_apellido'] . ' ' . $reg[$i]['usuario_apellido_2'];
			$usuario_identificacion = $reg[$i]['usuario_identificacion'];
			// $usuario_email_p_contrato =;
			$usuario_cargo = $puntos_billetera->MostrarCargoDocentes($usuario_identificacion, $periodo_actual_historico);
			if ($usuario_cargo) {
				$ultimo_contrato = $usuario_cargo['tipo_contrato'];
				//dependiendo del numero que llega muestra el nombre en la tabla
				$tipos_contrato = [
					1 => 'MEDIA JORNADA',
					2 => 'TIEMPO COMPLETO',
					3 => 'HORA CÁTEDRA',
					4 => 'PRESTACIÓN DE SERVICIOS'
				];
				$contrato_nombre = $tipos_contrato[$ultimo_contrato];
			} else {
				$contrato_nombre = '';
			}
			$total_puntos_billetera = $puntos_billetera->TotalPuntosBilletera($reg[$i]['id_usuario']);
			$data[] = array(
				"0" => '<button class="btn btn-xs btn-info tooltips" onclick="mostrar(' . $reg[$i]['id_usuario'] . ')" title="Asignar Puntos"> <i class="fas fa-plus"> </i>  </button>
					<button class="btn btn-xs bg-purple tooltips" title="Ver Billeteras" onclick="billeterasActivas(' . $reg[$i]['id_usuario'] . ')"> <i class="fas fa-eye"> </i>  </button>',
				"1" => $apellidos,
				"2" => $nombres,
				"3" => $reg[$i]["usuario_identificacion"],
				"4" => $reg[$i]["usuario_celular"],
				"5" => $reg[$i]["usuario_email_ciaf"],
				"6" => $contrato_nombre,
				"7" => $total_puntos_billetera,
				"8" => "<img src='../files/docentes/" . $reg[$i]["usuario_identificacion"] . ".jpg' height='40px' width='40px' >",
				"9" => '<span class="badge badge-success">Activado</span>'
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
	case 'billeterasActivas':
		$id_docente = isset($_POST["id_docente"]) ? $_POST["id_docente"] : "";
		$rspta = $puntos_billetera->billeterasActivas($id_docente);
		//Vamos a declarar un array
		$data["exito"] = 1;
		$data["info"] = "";
		foreach ($rspta as $reg) {
			$data["info"] .= '<tr>
				<td>' . $reg['punto_nombre'] . '</td>
				<td>' . $reg['puntos_cantidad'] . '</td>
				<td>' . $reg['punto_maximo'] . '</td>
				<td>' . $reg['punto_periodo'] . '</td>
				<td>' . $reg['punto_fecha_limite'] . '</td>
				<td>' . $reg['punto_create_dt'] . '</td>
			</tr>';
		}
		echo json_encode($data);
		break;
	case 'guardaryeditar':
		$punto_nombre = isset($_POST["punto_nombre"]) ? $_POST["punto_nombre"] : "";
		$puntos_cantidad = isset($_POST["puntos_cantidad"]) ? $_POST["puntos_cantidad"] : "";
		$punto_fecha_limite = isset($_POST["punto_fecha_limite"]) ? $_POST["punto_fecha_limite"] : "";
		$punto_maximo = isset($_POST["punto_maximo"]) ? $_POST["punto_maximo"] : "";
		$id_docente = isset($_POST["id_docente"]) ? $_POST["id_docente"] : "";
		$rspta = $puntos_billetera->insertarPuntos($punto_nombre, $puntos_cantidad, $punto_fecha_limite, $id_docente, $periodo_actual_historico, $punto_maximo);
		if ($rspta) {
			$array = array(
				"exito" => 1,
				"info" => "Puntos Insertados Con Exito"
			);
		} else {
			$array = array(
				"exito" => 0,
				"info" => "Error Al Insertar Los Puntos"
			);
		}
		echo json_encode($array);
		break;
}
