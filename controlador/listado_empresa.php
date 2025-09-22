<?php
session_start();
require_once "../modelos/ListadoEmpresa.php";
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$listado_empresa = new ListadoEmpresa();
// variables para el formulario de agregar empresa.
$usuario_nit = isset($_POST["usuario_nit"]) ? limpiarCadena($_POST["usuario_nit"]) : "";
$usuario_nombre = isset($_POST["usuario_nombre"]) ? limpiarCadena($_POST["usuario_nombre"]) : "";
$usuario_area_ss = isset($_POST["usuario_area_ss"]) ? limpiarCadena($_POST["usuario_area_ss"]) : "";
$usuario_representante = isset($_POST["usuario_representante"]) ? limpiarCadena($_POST["usuario_representante"]) : "";
$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$usuario_celular = isset($_POST["usuario_celular"]) ? limpiarCadena($_POST["usuario_celular"]) : "";
$usuario_horario_pactado = isset($_POST["usuario_horario_pactado"]) ? limpiarCadena($_POST["usuario_horario_pactado"]) : "";
switch ($_GET["op"]) {
	// listamos las ofertas disponibles 
	case 'Listar_empresa':
		$rspta = $listado_empresa->Listar_empresa(); // sin parámetro
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$data[] = array(
				"0" => '
				<div class="btn-group">
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_empresa(' . $reg[$i]["id_usuario"] . ')" title="Editar Empresa" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar(' . $reg[$i]["id_usuario"] . ')" title="Eliminar Empresa" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
				</div>',
				"1" => $reg[$i]["usuario_nit"],
				"2" => $reg[$i]["usuario_nombre"],
				"3" => $reg[$i]["usuario_area_ss"],
				"4" => $reg[$i]["usuario_representante"],
				"5" => $reg[$i]["usuario_celular"],
				"6" => $reg[$i]["usuario_horario_pactado"],
				"7" => '<button class="tooltip-listar btn btn-info btn-flat btn-xs" onclick="listar_postulados(' . $reg[$i]["id_usuario"] . ')" title="Ver Postulados" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></button>',
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
	case 'mostrar_empresa':
		$rspta = $listado_empresa->mostrar_empresa($id_usuario);
		echo json_encode($rspta);
		break;
	case 'guardaryeditareditarempresa':
		if (empty($id_usuario)) {
			$rspta = $listado_empresa->insertarempresa($usuario_nit, $usuario_nombre, $usuario_area_ss, $usuario_representante, $usuario_celular, $usuario_horario_pactado);
		} else {
			$rspta = $listado_empresa->editarempresa($id_usuario, $usuario_nit, $usuario_nombre, $usuario_area_ss, $usuario_representante, $usuario_celular, $usuario_horario_pactado);
		}
		if ($rspta) {
			$data = array("exito" => 1);
		} else {
			$data = array("exito" => 0);
		}
		echo json_encode($data);
		break;
	case 'eliminar':
		$rspta = $listado_empresa->eliminar($id_usuario);
		echo json_encode($rspta);
		break;
	case 'mostrar_listado_postulados':
		$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
		$data = array();
		$data[0] = '';
		$data[0] .= '		
				<table id="mostrarusuariospostulados" class="table" style="width:100%">
				<thead>
				<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Nombre</th>
					<th scope="col" class="text-center">Apellido</th>
					<th scope="col" class="text-center">Celular</th>
					<th scope="col" class="text-center">Correo</th>
				</tr>
				</thead>';
		$listar_postulados_bolsa = $listado_empresa->ListarUsuariosPostulados($id_usuario);
		for ($n = 0; $n < count($listar_postulados_bolsa); $n++) {
			$id_credencial = $listar_postulados_bolsa[$n]["id_credencial"] ?? null;
			if (!$id_credencial) {
				continue;
			}
			$datos_estudiante = $listado_empresa->listarDatosPostulados($id_credencial);
			if (!$datos_estudiante) {
				continue;
			}
			$nombre_estudiante = $datos_estudiante['credencial_nombre'] . ' ' . $datos_estudiante['credencial_nombre_2'];
			$apellido_estudiante = $datos_estudiante['credencial_apellido'] . ' ' . $datos_estudiante['credencial_apellido_2'];
			$celular = $datos_estudiante['celular'];
			$email = $datos_estudiante['email'];
			$data[0] .= '
					<tbody>
						<tr>
							<th scope="row">' . ($n + 1) . '</th>
							<td class="text-center">' . $nombre_estudiante . '</td>
							<td class="text-center">' . $apellido_estudiante . '</td>
							<td class="text-center">' . $celular . '</td>
							<td class="text-center">' . $email . '</td>
						</tr>
					</tbody>';
		}
		$data[0] .= '</table>';
		echo json_encode($data);
		break;
}
