<?php
session_start();
require_once "../modelos/WhatsappSeguimiento.php";
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$consulta = new WhatsappSeguimiento();
$rsptaperiodo = $consulta->periodoactual();
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
$fecha_tareas = $rsptaperiodo['fecha_sofi_segui'];
$periodo_actual = $_SESSION['periodo_actual'];
$usuario_cargo = $_SESSION['usuario_cargo'];
$id_usuario = $_SESSION['id_usuario'];
$usuario = isset($_POST["usuario"]) ? limpiarCadena($_POST["usuario"]) : "";
$fecha_desde = isset($_POST["fecha_desde"]) ? limpiarCadena($_POST["fecha_desde"]) : "";
$fecha_hasta = isset($_POST["fecha_hasta"]) ? limpiarCadena($_POST["fecha_hasta"]) : "";
switch ($_GET["op"]) {
	case 'listar':
		$id_usuario = $_GET["usuario"];
		$fecha_desde = $_GET["fecha_desde"];
		$fecha_hasta = $_GET["fecha_hasta"];
		$rspta = $consulta->listar($id_usuario, $fecha_desde, $fecha_hasta);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$id_credencial = $reg[$i]["id_credencial"];
			$datetime = $reg[$i]["created_at"];
			$date = new DateTime($datetime);
			$fechaseguimeinto = $date->format('Y-m-d');
			$hora = $date->format('H:i:s');
			$datosestudiantes = $consulta->datosEstudiante($id_credencial);
			$identificacion = $datosestudiantes["credencial_identificacion"];
			$nombre = $datosestudiantes["credencial_nombre"] . ' ' . $datosestudiantes["credencial_apellido"];
			$consultaretiqueta = $consulta->consultaretiqueta($reg[$i]["id_etiqueta"]);

			$celular_estudiante = $consulta->traerCelularEstudiante($identificacion);
            $mensajes_no_vistos = 0;
            if (isset($celular_estudiante["celular"])) {
                $estilo_whatsapp = 'btn-success';
                $numero_celular = $celular_estudiante["celular"];
                $registro_whatsapp = $consulta->obtenerRegistroWhastapp($numero_celular);
                $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
            } else {
                $estilo_whatsapp = 'btn-danger disabled';
                $numero_celular = '';
            }
            $boton_whatsapp = '
            <button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                <i class="fab fa-whatsapp"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    ' . $mensajes_no_vistos . '
                </span>
            </button>';




			$data[] = array(
				"0" => $boton_whatsapp ,
				"1" => $identificacion,
				"2" => $nombre,
				"3" => $reg[$i]["seg_tipo"],
				"4" => $reg[$i]["seg_descripcion"],
				"5" => $consulta->fechaesp($fechaseguimeinto),
				"6" => $hora,
				"7" => $reg[$i]["usuario_nombre"] . ' ' . $reg[$i]["usuario_apellido"],
				"8" => $consultaretiqueta["etiqueta_nombre"],
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
	case "selectUsuario":
		$rspta = $consulta->selectUsuario();
		echo "<option value='' selected disabled>" . $usuario_nombre . "</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			$nombre_completo = $rspta[$i]["usuario_nombre"] . " " . $rspta[$i]["usuario_apellido"];
			$usuario_nombre = mb_convert_case(mb_strtolower($nombre_completo, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $usuario_nombre . "</option>";
		}
		break;
	case "datos":
		$data['citas'] = "";
		$data['llamada'] = "";
		$data['segui'] = "";
		$data['whatsapp'] = "";
		$citas = $consulta->datos($fecha_tareas, "Cita");
		$data['citas'] .= count($citas);
		$llamada = $consulta->datos($fecha_tareas, "Llamada");
		$data['llamada'] .= count($llamada);
		$seguimiento = $consulta->datos($fecha_tareas, "Seguimiento");
		$data['segui'] .= count($seguimiento);
		$whatsapp = $consulta->datos($fecha_tareas, "Whatsapp");
		$data['whatsapp'] .= count($whatsapp);
		echo json_encode($data);
		break;
	case "datosEtiquetas":
		$data['datos'] = "";
		$traeretiquetas = $consulta->traerEtiquetas();
		$data['datos'] .= '<div class="row">';
		for ($i = 0; $i < count($traeretiquetas); $i++) {
			$etiqueta = $traeretiquetas[$i]["etiqueta_nombre"];
			$id_etiqueta = $traeretiquetas[$i]["id_etiquetas"];
			if ($id_etiqueta != 1) {
				$datos = $consulta->traerSeguiEtiquetas($fecha_tareas, $id_etiqueta);
				$data['datos'] .= '	
					<div class="col text-center">
						<div class="row justify-content-center">
							<div class="col-12">
								<span class="fw-bolder text-regular fs-14">' . count($datos) . '</span><br>
								<span class="small text-secondary mb-1 line-height-16">' . $etiqueta . '</span>
							</div>
						</div>
					</div>';
			}
		}
		$data['datos'] .= '</div>';
		echo json_encode($data);
		break;
}
