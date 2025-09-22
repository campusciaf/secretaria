<?php
session_start();
require_once "../modelos/BolsaEmpleoOfertas.php";

date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:s');
$bolsa_empleo = new BolsaEmpleoOfertas();
// variables para el formulario de agregar oferta laboral.
$tipo_contrato = isset($_POST["tipo_contrato"]) ? limpiarCadena($_POST["tipo_contrato"]) : "";
$salario = isset($_POST["salario"]) ? limpiarCadena($_POST["salario"]) : "";
$modalidad_trabajo = isset($_POST["modalidad_trabajo"]) ? limpiarCadena($_POST["modalidad_trabajo"]) : "";
$ciclo_propedeutico = isset($_POST["ciclo_propedeutico"]) ? limpiarCadena($_POST["ciclo_propedeutico"]) : "";
$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$programa_estudio = isset($_POST["programa_estudio"]) ? limpiarCadena($_POST["programa_estudio"]) : "";
$perfil_oferta = isset($_POST["perfil_oferta"]) ? limpiarCadena($_POST["perfil_oferta"]) : "";
$funciones = isset($_POST["funciones"]) ? limpiarCadena($_POST["funciones"]) : "";
$fecha_contratacion = isset($_POST["fecha_contratacion"]) ? limpiarCadena($_POST["fecha_contratacion"]) : "";
$id_bolsa_empleo_oferta = isset($_POST["id_bolsa_empleo_oferta"]) ? limpiarCadena($_POST["id_bolsa_empleo_oferta"]) : "";
// para saber si entramos a editar o crear una oferta laboral.
$id_bolsa_empleo_oferta = isset($_POST["id_bolsa_empleo_oferta"]) ? limpiarCadena($_POST["id_bolsa_empleo_oferta"]) : "";

// motivo por el cual se elimina una oferta.
$id_bolsa_empleo_oferta_desactivar_oferta = isset($_POST["id_bolsa_empleo_oferta_desactivar_oferta"]) ? limpiarCadena($_POST["id_bolsa_empleo_oferta_desactivar_oferta"]) : "";
$motivo_finalizacion = isset($_POST["motivo_finalizacion"]) ? limpiarCadena($_POST["motivo_finalizacion"]) : "";
switch ($_GET["op"]) {
	// listamos las ofertas disponibles 
	case 'listar_ofertas_laborales':
		$rspta = $bolsa_empleo->Listar_Ofertas_Laborales();
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$nombre_empresa_listar = $bolsa_empleo->nombre_empresa($reg[$i]["id_usuario"]);
			$nombre_empresa = $nombre_empresa_listar["usuario_nombre"];
			$cargo = $reg[$i]["cargo"];
			$tipo_contrato = $reg[$i]["tipo_contrato"];
			$programa_estudio = $reg[$i]["programa_estudio"];
			$salario = $reg[$i]["salario"];
			$fecha_contratacion = $reg[$i]["fecha_contratacion"];
			$data[] = array(
				"0" => '
				<div class="btn-group">
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_ofertas_laborales(' . $reg[$i]["id_bolsa_empleo_oferta"] . ')" title="Editar Oferta" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="desactivar_oferta(' . $reg[$i]["id_bolsa_empleo_oferta"] . ')" title="Eliminar Oferta" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
				</div>',
				"1" => $nombre_empresa,
				"2" => $cargo,
				"3" => $tipo_contrato,
				"4" => $programa_estudio,
				"5" => $salario,
				"6" => $fecha_contratacion,
				"7" => '<button class="tooltip-listar btn btn-info btn-flat btn-xs" onclick="listar_postulados(' . $reg[$i]["id_bolsa_empleo_oferta"] . ')" title="Eliminar Oferta" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></button>'
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
	case 'mostrar_ofertas_laborales':
		$rspta = $bolsa_empleo->mostrar_ofertas_laborales($id_bolsa_empleo_oferta);
		echo json_encode($rspta);
		break;
	case 'guardaryeditareditarofertalaboral':
		if (empty($id_bolsa_empleo_oferta)) {
			$rspta = $bolsa_empleo->insertarofertalaboral($cargo, $tipo_contrato, $salario, $fecha_contratacion, $id_usuario, $modalidad_trabajo, $ciclo_propedeutico, $perfil_oferta, $programa_estudio, $funciones);
		} else {
			$rspta = $bolsa_empleo->editarofertalaboral($id_bolsa_empleo_oferta, $cargo, $tipo_contrato, $salario, $fecha_contratacion, $id_usuario, $modalidad_trabajo, $ciclo_propedeutico, $perfil_oferta, $programa_estudio, $funciones);
		}
		if ($rspta) {
			$data = array("exito" => 1);
		} else {
			$data = array("exito" => 0);
		}
		echo json_encode($data);
		break;
	case "ListarEmpresas":
		$rspta = $bolsa_empleo->selectlistarEmpresas();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_nombre"] . "</option>";
		}
		break;
	case 'listar_postulados':
		$rspta = $bolsa_empleo->mostrar_ofertas_laborales($id_bolsa_empleo_oferta);
		echo json_encode($rspta);
		break;
	case 'mostrar_listado_postulados':
		$id_bolsa_empleo_oferta = $_POST["id_bolsa_empleo_oferta"];
		$data = array();
		$data[0] = '';
		$data[0] .= '		
			<table id="mostrarusuariospostulados" class="table" style="width:100%">
			<thead>
			<tr>
			<th scope="col" class="text-center">#</th>
			<th scope="col" class="text-center">Nombre</th>
				<th scope="col" class="text-center">Apellido </th>
				<th scope="col" class="text-center">Celular</th>
				<th scope="col" class="text-center">Correo</th>
			</tr>
			</thead>';
		$listar_postulados_bolsa = $bolsa_empleo->ListarUsuariosPostulados($id_bolsa_empleo_oferta);
		for ($n = 0; $n < count($listar_postulados_bolsa); $n++) {
			$datos_estudiante = $bolsa_empleo->listarDatosPostulados($listar_postulados_bolsa[$n]["credencial_estudiante"]);
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

	case 'registrar_motivo_eliminacion':
		$rspta = $bolsa_empleo->editarmotivofinalizacion($id_bolsa_empleo_oferta_desactivar_oferta, $motivo_finalizacion);
		echo $rspta ? "Oferta Eliminada con exito" : "Oferta de empleo no se pudo eliminar";
		break;
		case "ListarProgramas":
			$rspta = $bolsa_empleo->selectlistarProgramas();
			echo "<option selected>Nothing selected</option>";
			for ($i = 0; $i < count($rspta); $i++) {
				echo "<option value='" . $rspta[$i]["id_escuelas"] . "'>" . $rspta[$i]["escuelas"] . "</option>";
			}
			break;
}
