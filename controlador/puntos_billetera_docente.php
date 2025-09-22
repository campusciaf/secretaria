<?php
session_start();
date_default_timezone_set("America/Bogota");
require_once "../modelos/PuntosBilleteraDocente.php";
$billetera_docente = new PuntosBilleteraDocente();
require_once "../PuntosFirebaseClass.php";
$obj_firebase = new PuntosFirebaseClass();
$fecha = date('Y-m-d');
$hora = date('H:i:s');
switch ($_GET["op"]) {
	case 'ListarNombrePuntos':
		$rspta = $billetera_docente->ListarNombrePuntos($_SESSION["id_usuario"]);
		if (count($rspta) > 0) {
			$array = array("exito" => 1, "info" => "<option selected disabled value=''> Ver Billeteras </option>");
			foreach ($rspta as $reg) {
				$array["info"] .= '<option value="' . $reg["id_punto"] . '" onclick="ObtenerPuntosMaximos(' . $reg["id_punto"] . ')"> ' . $reg["punto_nombre"] . ' </option>';
			}
		} else {
			$array = array("exito" => 1, "info" => "<option selected disabled value=''> No Tienes Billetera Asignada </option>");
		}
		echo json_encode($array);
		break;
	case 'ObtenerPuntosMaximos':
		$id_punto = isset($_POST["id_punto"]) ? $_POST["id_punto"] : "";
		$rspta = $billetera_docente->ObtenerPuntosMaximos($id_punto, $_SESSION["id_usuario"]);
		if (isset($rspta["punto_maximo"])) {
			$array = array("exito" => 1, "info" => $rspta["punto_maximo"]);
		} else {
			$array = array("exito" => 1, "info" => 0);
		}
		echo json_encode($array);
		break;
	case 'BusquedaEstudiante':
		$documento_estudiante = isset($_POST["documento_estudiante"]) ? $_POST["documento_estudiante"] : "";
		$rspta = $billetera_docente->BusquedaEstudiante($documento_estudiante);
		if (isset($rspta["id_credencial"])) {
			$array = array(
				"exito" => 1,
				"nombre_estudiante" => $rspta["credencial_nombre"] . " " . $rspta["credencial_nombre_2"] . " " . $rspta["credencial_apellido"] . " " . $rspta["credencial_apellido_2"],
				"correo_electronico" => $rspta["credencial_login"],
				"id_credencial" => $rspta["id_credencial"],
				"es_estudiante" => 1,
			);
		} else {
			$rspta = $billetera_docente->BusquedaInteresado($documento_estudiante);
			if (isset($rspta["identificacion"])) {
				$array = array(
					"exito" => 1,
					"nombre_estudiante" => $rspta["nombre"] . " " . $rspta["nombre_2"] . " " . $rspta["apellidos"] . " " . $rspta["apellidos_2"],
					"correo_electronico" => $rspta["email"],
					"id_credencial" => $rspta["identificacion"],
					"es_estudiante" => 0,
				);
			} else {
				$array = array(
					"exito" => 1,
					"nombre_estudiante" => "",
					"correo_electronico" => "No Hay Correo Aún",
					"id_credencial" => $documento_estudiante,
					"es_estudiante" => 0,
				);
			}
		}
		echo json_encode($array);
		break;
	case 'InsercionPuntos':
		$id_punto = isset($_POST["punto_nombre"]) ? $_POST["punto_nombre"] : "";
		$nombre_estudiante = isset($_POST["nombre_estudiante"]) ? $_POST["nombre_estudiante"] : "";
		$id_credencial = isset($_POST["id_credencial"]) ? $_POST["id_credencial"] : "";
		$es_estudiante = isset($_POST["es_estudiante"]) ? $_POST["es_estudiante"] : "";
		$punto_docente = isset($_POST["punto_maximo"]) ? $_POST["punto_maximo"] : "";
		$datos_puntos = $billetera_docente->ObtenerPuntosMaximos($id_punto, $_SESSION["id_usuario"]);
		if (isset($_SESSION["id_usuario"]) && !empty($id_credencial) && isset($datos_puntos["punto_maximo"])) {
			$punto_nombre = $datos_puntos["punto_nombre"];
			$punto_maximo = $datos_puntos["punto_maximo"];
			if($punto_docente > $punto_maximo){
				$data = array("exito" => 0, "info" => "El Nro. De Puntos Maximos No Puede Ser Mayor A: ".$punto_maximo);
			}else{
				$rspta = $billetera_docente->InsercionPuntos($punto_nombre, $punto_docente, $id_credencial, $es_estudiante, $_SESSION["id_usuario"], $_SESSION["periodo_actual"], $nombre_estudiante );
				if ($rspta) {
					$billetera_docente->ActualizarPuntosBilleteraCredencial($_SESSION["id_usuario"], $id_credencial, $punto_docente, $id_punto);
					$total_puntos = $billetera_docente->TotalPuntosEstudiante($id_credencial, $es_estudiante);
					$obj_firebase->RankingInduccion($id_credencial, $nombre_estudiante, $total_puntos["TotalPuntos"]);
					$data = array("exito" => 1, "info" => "Puntos Asignados Exitosamente, Total: ".$total_puntos["TotalPuntos"]);
				} else {
					$data = array("exito" => 0, "info" => "Error Al Asignar Los Puntos");
				}
			}
		} else {
			$data = array("exito" => 0, "info" => "Ha Ocurrido Un Problema, Intentalo Mas Tarde");
		}
		echo json_encode($data);
		break;
}
