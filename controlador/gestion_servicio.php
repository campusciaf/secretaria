<?php
session_start();
require_once "../modelos/GestionServicio.php";

date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:s');

$usuario = new Usuario();

$id_empresa = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$cedula_estu = isset($_POST["cedula_estu"]) ? limpiarCadena($_POST["cedula_estu"]) : "";
// variable para llenar el formulario del estudiante
$id_credencial_oculto = isset($_POST["id_credencial_oculto"]) ? limpiarCadena($_POST["id_credencial_oculto"]) : "";
$id_credencial_guardar_estudiante = isset($_POST["id_credencial_guardar_estudiante"]) ? limpiarCadena($_POST["id_credencial_guardar_estudiante"]) : "";
//Filtra la cedula del estudiante.
$cedula = isset($_POST["cedula"]) ? limpiarCadena($_POST["cedula"]) : "";
// variables para formulario perfil estudiante.
$cedula_estudiante = isset($_POST["cedula_estudiante"]) ? limpiarCadena($_POST["cedula_estudiante"]) : "";
$credencial_nombre = isset($_POST["credencial_nombre"]) ? limpiarCadena($_POST["credencial_nombre"]) : "";
$credencial_nombre_2 = isset($_POST["credencial_nombre_2"]) ? limpiarCadena($_POST["credencial_nombre_2"]) : "";
$credencial_apellido = isset($_POST["credencial_apellido"]) ? limpiarCadena($_POST["credencial_apellido"]) : "";
$credencial_apellido_2 = isset($_POST["credencial_apellido_2"]) ? limpiarCadena($_POST["credencial_apellido_2"]) : "";
$credencial_login = isset($_POST["credencial_login"]) ? limpiarCadena($_POST["credencial_login"]) : "";
$ac_realizadas = isset($_POST["ac_realizadas"]) ? limpiarCadena($_POST["ac_realizadas"]) : "";
		$fecha_participacion = isset($_POST["fecha_participacion"]) ? limpiarCadena($_POST["fecha_participacion"]) : "";
		$firma_servicio = isset($_POST["firma_servicio"]) ? limpiarCadena($_POST["firma_servicio"]) : "";
		$horas_servicio = isset($_POST["horas_servicio"]) ? limpiarCadena($_POST["horas_servicio"]) : "";
$actividades_competencias = isset($_POST["actividades_competencias"]) ? limpiarCadena($_POST["actividades_competencias"]) : "";



$op = (isset($_GET['op'])) ? $_GET['op'] : 'mostrar';
switch ($op) {
	case 'listar_datos_estudiantes':
		// dato que llega en el filtro
		$dato = $_GET["dato"];
		// tipo de dato(Indentificación, correo, celular)
		$tipo = $_GET["tipo"];
		$registro = $usuario->trae_id_credencial($dato);
		$data = array();
		for ($i = 0; $i < count($registro); $i++) {
			$id_credencial_seleccionado = $registro[$i]['id_credencial'];
			$data[] = array(
				'0' => '<button onclick="guardar_credencial(' . $id_credencial_seleccionado . ')" title="Agregar servicio social" class="btn btn-success btn-xs"><i class="fab fa-black-tie"></i></button> ' . $registro[$i]['credencial_identificacion'],
				'1' => $registro[$i]['credencial_apellido'] . ' ' . $registro[$i]['credencial_apellido_2'],
				'2' => $registro[$i]['credencial_nombre'] . ' ' . $registro[$i]['credencial_nombre_2'],
				'3' => $registro[$i]['usuario_nombre'] . ' ' . $registro[$i]['usuario_apellido'],
				'4' => $registro[$i]['fecha_registro'],
	'5' => '<div class="d-flex">
        <button class="tooltip-listar btn btn-info btn-flat btn-xs me-1" onclick="listar_postulados(' . $id_credencial_seleccionado . ')" title="Visualizar actividades" data-toggle="tooltip" data-placement="top">
            <i class="fas fa-eye"></i>
        </button>
        <button class="tooltip-listar btn btn-primary btn-flat btn-xs" onclick="agregarActividad(' . $id_credencial_seleccionado  . ')" title="Agregar actividades" data-toggle="tooltip" data-placement="top">
            <i class="fas fa-plus"></i>
        </button>
		<a href="https://drive.google.com/drive/folders/1ZCiDxx1i_Z9IU7_DkYAkBJwCA-w3VJTY?usp=drive_link" target="_blank" class="tooltip-listar btn btn-warning btn-flat btn-xs" title="Drive de evidencias" data-toggle="tooltip" data-placement="top">
    <i class="fas fa-folder-open"></i>
</a>
    </div>',

			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //total registros
			"iTotalDisplayRecords" => count($data), //total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;



	case 'contratar':
		$fecha_registro = isset($_POST["fecha_registro"]) ? limpiarCadena($_POST["fecha_registro"]) : "";
		$id_empresa = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
		$id_credencial = isset($_POST["id_credencial_contrato"]) ? limpiarCadena($_POST["id_credencial_contrato"]) : "";
		$rspta = $usuario->registrarServicioSocial($id_credencial, $id_empresa, $fecha_registro);
		echo $rspta ? "Oferta de empleo registrada" : "Oferta de empleo no se pudo registrar";
		break;

	case "ListarEmpresas":
		$rspta = $usuario->selectlistarEmpresas();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_nombre"] . "</option>";
		}
		break;

		
		


			
	case 'Actividad':
		$id_empresa = isset($_POST["id_usuario_actividad"]) ? limpiarCadena($_POST["id_usuario_actividad"]) : "";
		$ac_realizadas = isset($_POST["ac_realizadas"]) ? limpiarCadena($_POST["ac_realizadas"]) : "";
		$fecha_participacion = isset($_POST["fecha_participacion"]) ? limpiarCadena($_POST["fecha_participacion"]) : "";
		$firma_servicio = isset($_POST["firma_servicio"]) ? limpiarCadena($_POST["firma_servicio"]) : "";
		$horas_servicio = isset($_POST["horas_servicio"]) ? limpiarCadena($_POST["horas_servicio"]) : "";
		$id_credencial = isset($_POST["id_credencial_actividad"]) ? limpiarCadena($_POST["id_credencial_actividad"]) : "";
		$actividades_competencias = isset($_POST["actividades_competencias"]) ? limpiarCadena($_POST["actividades_competencias"]) : "";
		$rspta = $usuario->registraractividad($id_credencial, $ac_realizadas, $fecha_participacion, $firma_servicio, $horas_servicio,$id_empresa,$actividades_competencias);
		echo $rspta ? "Oferta de empleo registrada" : "Oferta de empleo no se pudo registrar";
		break;



		case 'mostrar_listado_postulados':
			$id_credencial = isset($_POST["id_credencial"]) ? limpiarCadena($_POST["id_credencial"]) : "";
			$listar_postulados_bolsa = $usuario->ListarActividades($id_credencial);
		
			$data = array();
			$html = '
				<table id="mostrarusuariospostulados" class="table" style="width:100%">
					<thead>
						<tr>
							<th>#</th>
							<th class="text-center">Actividades realizadas</th>
							<th class="text-center">Fecha de participación</th>
							<th class="text-center">Firma</th>
							<th class="text-center">Número de horas</th>
						</tr>
					</thead>
					<tbody>';
		
			if (is_array($listar_postulados_bolsa) && count($listar_postulados_bolsa) > 0) {
				foreach ($listar_postulados_bolsa as $i => $fila) {
					$html .= '
						<tr>
							<th scope="row">' . ($i + 1) . '</th>
							<td class="text-center">' . $fila['ac_realizadas'] . '</td>
							<td class="text-center">' . $fila['fecha_participacion'] . '</td>
							<td class="text-center">' . $fila['firma_servicio'] . '</td>
							<td class="text-center">' . $fila['horas_servicio'] . '</td>
						</tr>';
				}
			} else {
				$html .= '
					<tr>
						<td colspan="5" class="text-center">No se encontraron actividades.</td>
					</tr>';
			}
		
			$html .= '</tbody></table>';
			$data[0] = $html;
			echo json_encode($data);
			break;
		
		
}
