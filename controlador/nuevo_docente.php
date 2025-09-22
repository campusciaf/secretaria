<?php
error_reporting(1);
session_start();
require_once "../modelos/Nuevo_Docente.php";
$nuevo_docente = new Nuevo_Docente();
$periodo_actual = $_SESSION['periodo_actual'];
$id_usuario_actual = $_SESSION['id_usuario'];
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d-H:i:s');
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');
$usuario_identificacion = isset($_POST["usuario_identificacion"]) ? limpiarCadena($_POST["usuario_identificacion"]) : "";
$crear_usuario_identificacion = isset($_POST["crear_usuario_identificacion"]) ? limpiarCadena($_POST["crear_usuario_identificacion"]) : "";
$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$crear_usuario_tipo_documento = isset($_POST["crear_usuario_tipo_documento"]) ? limpiarCadena($_POST["crear_usuario_tipo_documento"]) : "";
$crear_usuario_nombre = isset($_POST["crear_usuario_nombre"]) ? limpiarCadena($_POST["crear_usuario_nombre"]) : "";
$crear_usuario_nombre_2 = isset($_POST["crear_usuario_nombre_2"]) ? limpiarCadena($_POST["crear_usuario_nombre_2"]) : "";
$crear_usuario_apellido = isset($_POST["crear_usuario_apellido"]) ? limpiarCadena($_POST["crear_usuario_apellido"]) : "";
$crear_usuario_apellido_2 = isset($_POST["crear_usuario_apellido_2"]) ? limpiarCadena($_POST["crear_usuario_apellido_2"]) : "";
$crear_usuario_estado_civil = isset($_POST["crear_usuario_estado_civil"]) ? limpiarCadena($_POST["crear_usuario_estado_civil"]) : "";
$crear_usuario_direccion = isset($_POST["crear_usuario_direccion"]) ? limpiarCadena($_POST["crear_usuario_direccion"]) : "";
$crear_usuario_telefono = isset($_POST["crear_usuario_telefono"]) ? limpiarCadena($_POST["crear_usuario_telefono"]) : "";
$crear_usuario_celular = isset($_POST["crear_usuario_celular"]) ? limpiarCadena($_POST["crear_usuario_celular"]) : "";
$crear_usuario_email_p = isset($_POST["crear_usuario_email_p"]) ? limpiarCadena($_POST["crear_usuario_email_p"]) : "";
$crear_usuario_fecha_nacimiento = isset($_POST["crear_usuario_fecha_nacimiento"]) ? limpiarCadena($_POST["crear_usuario_fecha_nacimiento"]) : "";
$crear_usuario_departamento_nacimiento = isset($_POST["crear_usuario_departamento_nacimiento"]) ? limpiarCadena($_POST["crear_usuario_departamento_nacimiento"]) : "";
$usuario_municipio_nacimiento = isset($_POST["usuario_municipio_nacimiento"]) ? limpiarCadena($_POST["usuario_municipio_nacimiento"]) : "";
$crear_usuario_tipo_contrato = isset($_POST["crear_usuario_tipo_contrato"]) ? limpiarCadena($_POST["crear_usuario_tipo_contrato"]) : "";
$crear_usuario_tipo_sangre = isset($_POST["crear_usuario_tipo_sangre"]) ? limpiarCadena($_POST["crear_usuario_tipo_sangre"]) : "";
$crear_usuario_email_ciaf = isset($_POST["crear_usuario_email_ciaf"]) ? limpiarCadena($_POST["crear_usuario_email_ciaf"]) : "";
$usuario_imagen_nuevo_docente = isset($_POST["usuario_imagen_nuevo_docente"]) ? limpiarCadena($_POST["usuario_imagen_nuevo_docente"]) : "";
$crear_usuario_municipio_nacimiento = isset($_POST["crear_usuario_municipio_nacimiento"]) ? limpiarCadena($_POST["crear_usuario_municipio_nacimiento"]) : "";
$verificacion_documento = isset($_POST["verificacion_documento"]) ? limpiarCadena($_POST["verificacion_documento"]) : "";
$usuario_genero = isset($_POST["usuario_genero"]) ? limpiarCadena($_POST["usuario_genero"]) : "";
switch ($_GET["op"]) {
	case 'verificardocumento':

		$tipo = $_POST['tipo'];
		$usuario_identificacion = $_POST["usuario_identificacion"];
		$tabla = '';
		$tabla = ($tipo == "1") ? 'usuario_identificacion' : (($tipo == "2") ? 'telefono' : null);
		$rspta = $nuevo_docente->verificardocumento($tabla, $usuario_identificacion);
		$data = array();
		$data["0"] = "";
		$reg = $rspta;
		if (is_array($reg)) {
			$data = array("exito" => 1, "info" => $reg["usuario_identificacion"]);
		} else {
			$data = array("exito" => 0, "info" => $usuario_identificacion);
		}
		echo json_encode($data);
		break;
	case 'consultardocentenuevo':
		$usuario_identificacion_2 = $_GET["usuario_identificacion"];
		$rspta = $nuevo_docente->verificardocumento_docente($usuario_identificacion_2);
		$reg = $rspta;
		if (is_array($reg)) {
			$data = array("exito" => 1,  "info" => $reg["usuario_identificacion"]);
		} else {
			$data = array("exito" => 0,  "info" => $usuario_identificacion_2);
		}
		echo json_encode($data);
		break;
	case 'mostrar_datos_docente':
		$usuario_identificacion = $_POST["usuario_identificacion"];
		$rspta = $nuevo_docente->MostrarDatosDocente($usuario_identificacion);
		echo json_encode($rspta);
		break;
	case "selectTipoDocumento":
		$rspta = $nuevo_docente->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectTipoSangre":
		$rspta = $nuevo_docente->selectTipoSangre();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre_sangre"] . "'>" . $rspta[$i]["nombre_sangre"] . "</option>";
		}
		break;
	case "selectTipoContrato":
		$rspta = $nuevo_docente->selectTipoContrato();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectDepartamento":
		$rspta = $nuevo_docente->selectDepartamento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
		}
		break;
	case "selectMunicipio":
		$rspta = $nuevo_docente->selectMunicipio();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
		}
		break;
	case "selectListaEstadoCivil":
		$rspta = $nuevo_docente->selectEstadoCivil();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectListaSiNo":
		$rspta = $nuevo_docente->selectListaSiNo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["valor"] . "'>" . $rspta[$i]["nombre_lista"] . "</option>";
		}
		break;

	case "selectListaGenero":
		$rspta = $nuevo_docente->selectGenero();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["genero"] . "'>" . $rspta[$i]["genero"] . "</option>";
		}
		break;
	// case 'creadocentenuevo':
	// 	if ($verificacion_documento == $crear_usuario_identificacion) {
	// 		if (!file_exists($_FILES['usuario_imagen_nuevo_docente']['tmp_name']) || !is_uploaded_file($_FILES['usuario_imagen_nuevo_docente']['tmp_name'])) {
	// 			$imagen = $_POST["imagenactual"];
	// 		} else {
	// 			$ext = explode(".", $_FILES["usuario_imagen_nuevo_docente"]["name"]);
	// 			if ($_FILES['usuario_imagen_nuevo_docente']['type'] == "image/jpg" || $_FILES['usuario_imagen_nuevo_docente']['type'] == "image/jpeg" || $_FILES['usuario_imagen_nuevo_docente']['type'] == "image/png" || $_FILES['usuario_imagen_nuevo_docente']['type'] == "application/pdf") {
	// 				$imagen = $crear_usuario_identificacion . '.' . end($ext);
	// 				move_uploaded_file($_FILES["usuario_imagen_nuevo_docente"]["tmp_name"], "../files/docentes/" . $imagen);
	// 			}
	// 		}
	// 		$usuario_clave = md5($crear_usuario_identificacion);
	// 		// $usuario_fecha_expedicion = NULL;
	// 		$usuario_periodo_ingreso = $_SESSION['periodo_actual'];
	// 		// agregamos validacion al campo del correo ciaf para que solo deje registrar un nuevo docente cuando su correo termine en @ciaf.edu.co
	// 		if (strpos($crear_usuario_email_ciaf, '@ciaf.edu.co') !== false) {
	// 			$rspta = $nuevo_docente->insertar($crear_usuario_tipo_documento, $crear_usuario_identificacion, $crear_usuario_nombre, $crear_usuario_nombre_2, $crear_usuario_apellido, $crear_usuario_apellido_2, $usuario_genero, $crear_usuario_estado_civil, $crear_usuario_fecha_nacimiento, $crear_usuario_departamento_nacimiento, $crear_usuario_municipio_nacimiento, $crear_usuario_direccion, $crear_usuario_telefono, $crear_usuario_celular, $crear_usuario_email_p, $crear_usuario_tipo_sangre, $crear_usuario_email_ciaf, $usuario_periodo_ingreso, $usuario_clave, $imagen);
	// 			$rspta = $nuevo_docente->insertar_tipo_contrato($crear_usuario_identificacion, $crear_usuario_tipo_contrato, $id_usuario_actual, $usuario_periodo_ingreso, $fecha_actual, $hora_actual);
	// 			if($rspta){
	// 				$data = array('exito' => 1, "info" => "Docente registrado" );
	// 			}else{
	// 				$data = array('exito' => 0, "info" => "No se pudieron registrar todos los datos del usuario" );
	// 			}
	// 		} else {
	// 			$data = array('exito' => 0, "info" => "El correo electrónico Email CIAF/Login debe terminar en (@ciaf.edu.co)<br>No se pudo registrar" );
	// 		}
	// 	} else {
	// 		$data = array('exito' => 0, "info" => "Los Documentos no coiciden" );
	// 	}
	// 	echo json_encode($data);
	// 	break;


	case 'creadocentenuevo':
		if ($verificacion_documento == $crear_usuario_identificacion) {
			if (!file_exists($_FILES['usuario_imagen_nuevo_docente']['tmp_name']) || !is_uploaded_file($_FILES['usuario_imagen_nuevo_docente']['tmp_name'])) {
				$imagen = $_POST["imagenactual"];
			} else {
				$ext = explode(".", $_FILES["usuario_imagen_nuevo_docente"]["name"]);
				if ($_FILES['usuario_imagen_nuevo_docente']['type'] == "image/jpg" || $_FILES['usuario_imagen_nuevo_docente']['type'] == "image/jpeg" || $_FILES['usuario_imagen_nuevo_docente']['type'] == "image/png" || $_FILES['usuario_imagen_nuevo_docente']['type'] == "application/pdf") {
					$imagen = $crear_usuario_identificacion . '.' . end($ext);
					move_uploaded_file($_FILES["usuario_imagen_nuevo_docente"]["tmp_name"], "../files/docentes/" . $imagen);
				}
			}
			$usuario_clave = md5($crear_usuario_identificacion);
			// $usuario_fecha_expedicion = NULL;
			$usuario_periodo_ingreso = $_SESSION['periodo_actual'];
			$data = [];
			$data[0] = '';
			$documentosarray = [];
			$rspta = $nuevo_docente->obtener_id_usuario_cv($crear_usuario_identificacion);
			$id_usuario_cv = $rspta[0]['id_usuario_cv'];

			$tipos_documentos = [
				"Cédula de ciudadanía",
				"Certificación Bancaria",
				"Antecedentes Judiciales Policía",
				"Antecedentes Contraloría",
				"Antecedentes Procuraduría",
				"Referencias Laborales",
				"Certificado Afiliación EPS",
				"Certificado Afiliación AFP",
				"Registro Único Tributario",
				"Tarjeta Profesional"
			];
			// almacenamos el total de los documentos
			$documentos_presentes = 0;
			$documentos_requeridos = 0;
			for ($i = 0; $i < count($tipos_documentos); $i++) {
				$documento = $tipos_documentos[$i];
				// consulta para filtrar los documentos
				$documentos_usuario = $nuevo_docente->listarDocumentosObligatorios($id_usuario_cv, $documento);
				//dependiendo del estado de este documento se toma como obligatorio o no obligatorio
				if ($documento == "Registro Único Tributario" || $documento == "Tarjeta Profesional") {
					//si estado == 1 es requerido como documento obligatorio
					if (count($documentos_usuario) > 0 && $documentos_usuario[0]['estado'] == 1) {
						$documentos_requeridos++;
						$documentos_presentes++;
					}
					// si estado == 0 no es requerido 
				} else {
					// documentos obligatorios
					$documentos_requeridos++;
					if (count($documentos_usuario) > 0) {
						$documentos_presentes++;
					}
				}
			}
			if ($documentos_presentes == $documentos_requeridos) {
				// agregamos validacion al campo del correo ciaf para que solo deje registrar un nuevo docente cuando su correo termine en @ciaf.edu.co
				if (strpos($crear_usuario_email_ciaf, '@ciaf.edu.co') !== false) {
					$rspta = $nuevo_docente->insertar($crear_usuario_tipo_documento, $crear_usuario_identificacion, $crear_usuario_nombre, $crear_usuario_nombre_2, $crear_usuario_apellido, $crear_usuario_apellido_2, $usuario_genero, $crear_usuario_estado_civil, $crear_usuario_fecha_nacimiento, $crear_usuario_departamento_nacimiento, $crear_usuario_municipio_nacimiento, $crear_usuario_direccion, $crear_usuario_telefono, $crear_usuario_celular, $crear_usuario_email_p, $crear_usuario_tipo_sangre, $crear_usuario_email_ciaf, $usuario_periodo_ingreso, $usuario_clave, $imagen);
					$rspta = $nuevo_docente->insertar_tipo_contrato($crear_usuario_identificacion, $crear_usuario_tipo_contrato, $id_usuario_actual, $usuario_periodo_ingreso, $fecha_actual, $hora_actual);
					if ($rspta) {
						$data = array('exito' => 1, "info" => "Docente registrado");
					} else {
						$data = array('exito' => 0, "info" => "No se pudieron registrar todos los datos del usuario");
					}
				} else {
					$data = array('exito' => 0, "info" => "El correo electrónico Email CIAF/Login debe terminar en (@ciaf.edu.co)<br>No se pudo registrar");
				}
			} else {
				$data = array('exito' => 0, "info" => "Falta Documentacion Obligatoria por subir. ");
			}
		} else {
			$data = array('exito' => 0, "info" => "Los Documentos no coinciden");
		}
		echo json_encode($data);
		break;


	case 'mostrar_documentos_obligatorios':
		$usuario_identificacion = $_POST["usuario_identificacion"];
		$data = [];
		$data[0] = '';

		$tipos_documentos = [
			"Cédula de ciudadanía",
			"Certificación Bancaria",
			"Antecedentes Judiciales Policía",
			"Antecedentes Contraloría",
			"Antecedentes Procuraduría",
			"Referencias Laborales",
			"Certificado Afiliación EPS",
			"Certificado Afiliación AFP",
			"Registro Único Tributario",
			"Tarjeta Profesional"
		];
		$rspta = $nuevo_docente->obtener_id_usuario_cv($usuario_identificacion);
		$id_usuario_cv = $rspta[0]['id_usuario_cv'];
		$data[0] .= '
				<table id="documentosobligatorios" style="width:100%">
					<thead>
						<tr>
							<th scope="col">Nombre</th>
							<th scope="col">Estado</th>
						</tr>
					</thead>
					<tbody>';

		$documentos_count = count($tipos_documentos);
		for ($i = 0; $i < $documentos_count; $i++) {
			$documento = $tipos_documentos[$i];
			// Verificar si el usuario tiene el documento con su nombre actual.
			$documentos_usuario = $nuevo_docente->listarDocumentosObligatorios($id_usuario_cv, $documento);
			if ($documento == "Registro Único Tributario" || $documento == "Tarjeta Profesional") {
				if (count($documentos_usuario) > 0) {
					$estado = $documentos_usuario[0]['estado'];
					if ($estado == 0) {
						// Saltamos el documento si está deshabilitado
						continue;
					}
				} else {
					// Si no está cargado, asumimos que está pendiente, pero solo mostrarlo si se requiere (estado = 1)
					continue;
				}
			}


			$estado = !empty($documentos_usuario)
				? '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Realizado</span>'
				: '<span class="bg-warning p-1"><i class="fas fa-clock"></i> Pendiente</span>';
			$data[0] .= '
					<tr>
						<td>' . $documento . '</td>
						<td>' . $estado . '</td>
					</tr>';
		}
		$data[0] .= '    
					</tbody>
				</table>';
		echo json_encode($data);
		break;
}
