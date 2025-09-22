<?php
session_start();
require_once "../modelos/GestionDocente.php";
$gestiondocente = new GestionDocente();
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');
$periodos = $gestiondocente->periodoactual();
$periodo_actual_historico = $periodos["periodo_actual"];
$id_usuario_actual = $_SESSION['id_usuario'];
$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$usuario_tipo_documento = isset($_POST["usuario_tipo_documento"]) ? limpiarCadena($_POST["usuario_tipo_documento"]) : "";
$usuario_identificacion = isset($_POST["usuario_identificacion"]) ? limpiarCadena($_POST["usuario_identificacion"]) : "";
$usuario_nombre = isset($_POST["usuario_nombre"]) ? limpiarCadena($_POST["usuario_nombre"]) : "";
$usuario_nombre_2 = isset($_POST["usuario_nombre_2"]) ? limpiarCadena($_POST["usuario_nombre_2"]) : "";
$usuario_apellido = isset($_POST["usuario_apellido"]) ? limpiarCadena($_POST["usuario_apellido"]) : "";
$usuario_apellido_2 = isset($_POST["usuario_apellido_2"]) ? limpiarCadena($_POST["usuario_apellido_2"]) : "";
$usuario_estado_civil = isset($_POST["usuario_estado_civil"]) ? limpiarCadena($_POST["usuario_estado_civil"]) : "";
$usuario_direccion = isset($_POST["usuario_direccion_2"]) ? limpiarCadena($_POST["usuario_direccion_2"]) : "";
$usuario_telefono = isset($_POST["usuario_telefono_2"]) ? limpiarCadena($_POST["usuario_telefono_2"]) : "";
$usuario_celular = isset($_POST["usuario_celular_2"]) ? limpiarCadena($_POST["usuario_celular_2"]) : "";
$usuario_email_p = isset($_POST["usuario_email_p"]) ? limpiarCadena($_POST["usuario_email_p"]) : "";
$usuario_fecha_nacimiento = isset($_POST["usuario_fecha_nacimiento"]) ? limpiarCadena($_POST["usuario_fecha_nacimiento"]) : "";
$usuario_departamento_nacimiento = isset($_POST["usuario_departamento_nacimiento"]) ? limpiarCadena($_POST["usuario_departamento_nacimiento"]) : "";
$usuario_municipio_nacimiento = isset($_POST["usuario_municipio_nacimiento"]) ? limpiarCadena($_POST["usuario_municipio_nacimiento"]) : "";
$usuario_tipo_contrato = isset($_POST["usuario_tipo_contrato"]) ? limpiarCadena($_POST["usuario_tipo_contrato"]) : "";
$usuario_tipo_sangre = isset($_POST["usuario_tipo_sangre"]) ? limpiarCadena($_POST["usuario_tipo_sangre"]) : "";
$usuario_email_ciaf = isset($_POST["usuario_email_ciaf"]) ? limpiarCadena($_POST["usuario_email_ciaf"]) : "";
$usuario_imagen = isset($_POST["usuario_imagen"]) ? limpiarCadena($_POST["usuario_imagen"]) : "";
$documento_docente_editar = isset($_POST["documento_docente_editar"]) ? limpiarCadena($_POST["documento_docente_editar"]) : "";
$tipo_contrato = isset($_POST["tipo_contrato"]) ? limpiarCadena($_POST["tipo_contrato"]) : "";
$usuario_genero = isset($_POST["usuario_genero"]) ? limpiarCadena($_POST["usuario_genero"]) : "";
// datos para generar el tipo de contrato para el docente 
$documento_docente_contrato = isset($_POST["documento_docente_contrato"]) ? limpiarCadena($_POST["documento_docente_contrato"]) : "";
$nombre_docente_contrato = isset($_POST["nombre_docente_contrato"]) ? limpiarCadena($_POST["nombre_docente_contrato"]) : "";
$apellido_docente_contrato = isset($_POST["apellido_docente_contrato"]) ? limpiarCadena($_POST["apellido_docente_contrato"]) : "";
$tipo_contrato_docente = isset($_POST["tipo_contrato_docente"]) ? limpiarCadena($_POST["tipo_contrato_docente"]) : "";
$fecha_inicio_contrato = isset($_POST["fecha_inicio_contrato"]) ? limpiarCadena($_POST["fecha_inicio_contrato"]) : "";
$fecha_final_contrato = isset($_POST["fecha_final_contrato"]) ? limpiarCadena($_POST["fecha_final_contrato"]) : "";
$salario_docente = isset($_POST["salario_docente"]) ? limpiarCadena($_POST["salario_docente"]) : "";
$usuario_email_p_contrato = isset($_POST["usuario_email_p_contrato"]) ? limpiarCadena($_POST["usuario_email_p_contrato"]) : "";
$auxilio_transporte = isset($_POST["auxilio_transporte"]) ? limpiarCadena($_POST["auxilio_transporte"]) : "";
// campos nuevos para el contrato de 3
// $cantidad_horas = isset($_POST["cantidad_horas"]) ? limpiarCadena($_POST["cantidad_horas"]) : "0";
// $valor_horas = isset($_POST["valor_horas"]) ? limpiarCadena($_POST["valor_horas"]) : "0";
// $materia_docente = isset($_POST["materia_docente"]) ? limpiarCadena($_POST["materia_docente"]) : "";
// $cargo_docente = isset($_POST["cargo_docente"]) ? limpiarCadena($_POST["cargo_docente"]) : "";
$materia_docente = isset($_POST['materia_docente']) ? $_POST['materia_docente'] : 'NULL';
$cargo_docente = isset($_POST['cargo_docente']) ? $_POST['cargo_docente'] : 'NULL';
$salario_docente = isset($_POST['salario_docente']) ? intval($_POST['salario_docente']) : 'NULL';
$cantidad_horas = isset($_POST['cantidad_horas']) ? intval($_POST['cantidad_horas']) : 0;
$valor_horas = isset($_POST['valor_horas']) ? intval($_POST['valor_horas']) : 0;
$usuario_email_p_contrato = isset($_POST['usuario_email_p_contrato']) ? $_POST['usuario_email_p_contrato'] : 0;
$periodo_contrato_seleccionado = isset($_POST["periodo"]) ? limpiarCadena($_POST["periodo"]) : "";
// comentario docente
$id_usuario_cv_comentario_docente = isset($_POST["id_usuario_cv_comentario_docente"]) ? limpiarCadena($_POST["id_usuario_cv_comentario_docente"]) : "";
$mensaje_docente = isset($_POST["mensaje_docente"]) ? limpiarCadena($_POST["mensaje_docente"]) : "";

if ($_SESSION["usuario_cargo"] == 'Docente') {
	$cadena = $_SESSION["usuario_imagen"];
	$separador = ".";
	$separada = explode($separador, $cadena);
	$cedula = $separada[0];
	$rspta_usuario = $gestiondocente->cv_traerIdUsuario($cedula);
} else {
	$cedula = $_SESSION["usuario_identificacion"];
	$rspta_usuario = $gestiondocente->cv_traerIdUsuario($cedula);
}
$id_usuario_cv = $rspta_usuario["id_usuario_cv"];
switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (!file_exists($_FILES['usuario_imagen']['tmp_name']) || !is_uploaded_file($_FILES['usuario_imagen']['tmp_name'])) {
			$imagen = $_POST["imagenactual"];
		} else {
			$ext = explode(".", $_FILES["usuario_imagen"]["name"]);
			if ($_FILES['usuario_imagen']['type'] == "image/jpg" || $_FILES['usuario_imagen']['type'] == "image/jpeg" || $_FILES['usuario_imagen']['type'] == "image/png" || $_FILES['usuario_imagen']['type'] == "application/pdf") {
				$imagen = $usuario_identificacion . '.' . end($ext);
				move_uploaded_file($_FILES["usuario_imagen"]["tmp_name"], "../files/docentes/" . $imagen);
			}
		}
		// $usuario_tipo_contrato
		// $usuario_clave = md5($usuario_identificacion);
		$rspta = $gestiondocente->editar($id_usuario, $usuario_tipo_documento, $usuario_identificacion, $usuario_nombre, $usuario_nombre_2, $usuario_apellido, $usuario_apellido_2, $usuario_estado_civil, $usuario_fecha_nacimiento, $usuario_departamento_nacimiento, $usuario_municipio_nacimiento, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email_p, $usuario_tipo_sangre, $usuario_email_ciaf, $usuario_genero, $usuario_imagen);
		echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
		// if (empty($id_usuario)){
		// 	$usuario_fecha_expedicion = NULL;
		// 	$usuario_periodo_ingreso = $_SESSION['periodo_actual'];
		// 	$rspta=$gestiondocente->insertar($usuario_tipo_documento, $usuario_identificacion, $usuario_fecha_expedicion, $usuario_nombre, $usuario_nombre_2, $usuario_apellido, $usuario_apellido_2, $usuario_estado_civil, $usuario_fecha_nacimiento, $usuario_departamento_nacimiento, $usuario_municipio_nacimiento, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email_p, $usuario_tipo_contrato, $usuario_tipo_sangre, $usuario_email_ciaf, $usuario_periodo_ingreso, $usuario_clave, $usuario_imagen);
		// 	echo $rspta ? "Usuario registrado " : "No se pudieron registrar todos los datos del usuario";
		// }
		// else {
		// }
		break;
	case 'desactivar':
		$rspta = $gestiondocente->desactivar($id_usuario);
		if ($rspta == 0) {
			echo "1";
		} else {
			echo "0";
		}
		//echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
		break;
	case 'activar':
		$rspta = $gestiondocente->activar($id_usuario);
		if ($rspta == 0) {
			echo "1";
		} else {
			echo "0";
		}
		//echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
		break;
	case 'mostrar':
		$rspta = $gestiondocente->mostrar($id_usuario);
		echo json_encode($rspta);
		break;
	case 'listar':
		$rspta = $gestiondocente->listar();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		$rsptaperiodo = $gestiondocente->periodoactual();
		$periodo_actual = $rsptaperiodo["periodo_actual"];
		for ($i = 0; $i < count($reg); $i++) {
			$nombres = $reg[$i]['usuario_nombre'] . ' ' . $reg[$i]['usuario_nombre_2'];
			$apellidos = $reg[$i]['usuario_apellido'] . ' ' . $reg[$i]['usuario_apellido_2'];
			$usuario_identificacion = $reg[$i]['usuario_identificacion'];
			// $usuario_email_p_contrato =;
			$usuario_cargo = $gestiondocente->MostrarCargoDocentes($usuario_identificacion, $periodo_actual);
			$tipo_contrato_info = $gestiondocente->ObtenerTipoContratoDocente($usuario_identificacion, $periodo_actual);
			$tipo_contrato_tiempo = isset($tipo_contrato_info['tipo_contrato_tiempo']) ? $tipo_contrato_info['tipo_contrato_tiempo'] : 'desconocido';
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
			// agregamos las cedulas para que queden con el contrato anterior 
			$usuarios_con_formato_viejo = array(
				'1088280263',
				'1088006014',
				'7555650',
				'1087988174'
			);
			$docente_tipo_contrato = $gestiondocente->BuscarDocenteContratado($reg[$i]["usuario_identificacion"]);
			$tipo_contrato_docente = isset($docente_tipo_contrato['tipo_contrato']) ? $docente_tipo_contrato['tipo_contrato'] : "";
			$ruta_contrato = '';
			if (in_array($reg[$i]["usuario_identificacion"], $usuarios_con_formato_viejo)) {
				if ($tipo_contrato_docente == '1') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_media_jornada.php'; // Ruta del contrato viejo
				} elseif ($tipo_contrato_docente == '2') {
					$ruta_contrato = 'contratacion_docente_termino_fijo.php'; // Ruta del contrato viejo
				} elseif ($tipo_contrato_docente == '3') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_hora_catedra.php'; // Ruta del contrato por horas
				} elseif ($tipo_contrato_docente == '4') {
					$ruta_contrato = 'contratacion_docente_prestacion_servicios.php'; // Ruta del contrato por horas
				}
			} else {
				// Lógica para los contratos nuevos
				if ($tipo_contrato_docente == '1') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_media_jornada_v2.php';
				} elseif ($tipo_contrato_docente == '2') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_v2.php';
				} elseif ($tipo_contrato_docente == '3') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_hora_catedra.php'; // Ruta del contrato por horas
				} elseif ($tipo_contrato_docente == '4') {
					$ruta_contrato = 'contratacion_docente_prestacion_servicios.php'; // Ruta del contrato por horas
				}
			}
			// $contratos = '<button class="btn btn-secondary btn-flat btn-xs" 
			// 	onclick="mostrarContratos(' . $reg[$i]["usuario_identificacion"] . ')" 
			// 
			$contrato = ($tipo_contrato_docente && $ruta_contrato) ? '<a class="dropdown-item" href="#" onclick="mostrarContratos(' . $reg[$i]["usuario_identificacion"] . ')" title="Listar contratos"><i class="fas fa-list text-secondary"></i> Ver Contratos </a>' : '';
			$perfilprofesional = $gestiondocente->paso1($reg[$i]["usuario_identificacion"]);
			//traemos la ultima actualizacion de la hoja de vida
			$traer_id_usuario_cv = $gestiondocente->cv_traer_usuario_vacio($reg[$i]["usuario_identificacion"]);
			// en caso de que no tenga la hoja de vida lo mandamos como null para evitar errores.
			$id_usuario_cv = isset($traer_id_usuario_cv['id_usuario_cv']) ? $traer_id_usuario_cv['id_usuario_cv'] : null;
			$ultima_actualizacion = $gestiondocente->UsuarioUltimaActualizacionCV($id_usuario_cv);
			$ultima_actualizacion_hj = (is_array($ultima_actualizacion) && isset($ultima_actualizacion["ultima_actualizacion"])) ? $ultima_actualizacion["ultima_actualizacion"] : null;
			// En caso de que no este actualizada la hoja de vida mostramos un mensaje de no actualizada.
			$actualizacion_hoja_de_vida = !empty($ultima_actualizacion_hj) ? $gestiondocente->fechaesp_ajustada_formato_vacio($ultima_actualizacion_hj) : "No actualizada";
			// cuando no tengan titulo seleccionado se muestra en blanco para evitar errores.
			$titulo_profesional = (is_array($perfilprofesional) && isset($perfilprofesional['titulo_profesional'])) ? $perfilprofesional['titulo_profesional'] : '';
			$dropdown = '
			<div class="dropdown">
				<button class="btn btn-outline-info btn-xs rounded-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Opciones </button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#" onclick="mostrar(' . $reg[$i]["id_usuario"] . ')" title="Editar"> <i class="fas fa-pencil-alt text-warning"></i> Editar</a>';
			if ($reg[$i]["usuario_condicion"]) {
				$dropdown .= '<a class="dropdown-item" href="#" onclick="desactivar(' . $reg[$i]["id_usuario"] . ')" title="Desactivar"> <i class="fas fa-lock-open text-danger"></i> Desactivar </a>';
				$dropdown .= '<a class="dropdown-item" href="#" onclick="mostrar_info_personal(' . $reg[$i]["usuario_identificacion"] . ')" title="Ver CV"><i class="fas fa-eye text-success"></i> Ver CV </a>';
				$dropdown .= '<a class="dropdown-item" href="#" onclick="crearcontrato(' . $reg[$i]["usuario_identificacion"] . ',`' . $nombres . '`,`' . $apellidos . '`,`' . $reg[$i]['usuario_email_p'] . '`)" title="Crear Contrato"><i class="fas fa-file-contract text-primary"></i> Crear Contrato </a>';
				$dropdown .= $contrato;
				$dropdown .= '<a class="dropdown-item" href="../controlador/gestiondocente.php?op=descargarzip&usuario_identificacion=' . $reg[$i]["usuario_identificacion"] . '"> <i class="fas fa-download text-info"></i> Descargar </a>';
				$estado_influencer = ($reg[$i]["influencer_mas"] == 1) ? "Si" : "No";
				$dropdown .= '<a class="dropdown-item" href="#" onclick="influencer_mas(' . $reg[$i]["id_usuario"] . ',' . $reg[$i]["influencer_mas"] . ' )" title="Influencer +"><i class="fas fa-plus text-indigo"></i> Influencer Activo:  <b class="text-info estado_influencer_mas_' . $reg[$i]["id_usuario"] . '">' . $estado_influencer . '</b> </a>';

				$dropdown .= '<a class="dropdown-item" href="#" onclick="comentarios_docentes(' . $id_usuario_cv . ')" title="Comentario Docente"><i class="fas fa-comment text-purple"></i> Comentarios Docentes</a>';
			} else {
				$dropdown .= '<a class="dropdown-item" href="#" onclick="activar(' . $reg[$i]["id_usuario"] . ')" title="Activar"><i class="fas fa-lock text-primary"></i> Activar </a>';
			}
			$dropdown .= '	</div>';
			$dropdown .= '</div>';
			$data[] = array(
				"0" => $dropdown,
				"1" => $apellidos,
				"2" => $nombres,
				"3" => $titulo_profesional,
				"4" => $reg[$i]["usuario_identificacion"],
				"5" => $reg[$i]["usuario_celular"],
				"6" => $reg[$i]["usuario_email_p"],
				"7" => $reg[$i]["usuario_email_ciaf"],
				"8" => $contrato_nombre,
				"9" => $tipo_contrato_tiempo,
				"10" => "<img src='../files/docentes/" . $reg[$i]["usuario_identificacion"] . ".jpg' height='40px' width='40px' >",
				"11" => $actualizacion_hoja_de_vida,
				"12" => ($reg[$i]["usuario_condicion"]) ? '<span class="badge badge-success">Activado</span>' :
					'<span class="badge badge-danger">Desactivado</span>',
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
	case "selectTipoDocumento":
		$rspta = $gestiondocente->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectTipoSangre":
		$rspta = $gestiondocente->selectTipoSangre();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre_sangre"] . "'>" . $rspta[$i]["nombre_sangre"] . "</option>";
		}
		break;
	case "selectTipoContrato":
		$rspta = $gestiondocente->selectTipoContrato();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectDepartamento":
		$rspta = $gestiondocente->selectDepartamento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
		}
		break;
	case "selectMunicipio":
		$rspta = $gestiondocente->selectMunicipio();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
		}
		break;
	case "selectListaEstadoCivil":
		$rspta = $gestiondocente->selectEstadoCivil();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectListaGenero":
		$rspta = $gestiondocente->selectGenero();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["genero"] . "'>" . $rspta[$i]["genero"] . "</option>";
		}
		break;
	case "selectListaSiNo":
		$rspta = $gestiondocente->selectListaSiNo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["valor"] . "'>" . $rspta[$i]["nombre_lista"] . "</option>";
		}
		break;
	case 'guardaryeditarfuncionario':
		$rspta = $gestiondocente->editar_tipo_contrato($documento_docente_editar, $tipo_contrato, $id_usuario_actual, $periodo_actual_historico, $fecha_actual, $hora_actual);
		echo $rspta ? "Actualizada" : "No se pudo actualizar";
		break;
	case 'guardaryeditarcontrato':
		// $tipos_documentos = [
		// 	"Cédula de ciudadanía",
		// 	"Certificación Bancaria",
		// 	"Antecedentes Judiciales Policía",
		// 	"Antecedentes Contraloría",
		// 	"Antecedentes Procuraduría",
		// 	"Referencias Laborales",
		// 	"Certificado Afiliación EPS",
		// 	"Certificado Afiliación AFP",
		// ];
		// $rspta = $gestiondocente->obtener_id_usuario_cv($documento_docente_contrato);
		// $id_usuario_hoja_vida = $rspta[0]['id_usuario_cv'];
		// $total_documentos = count($tipos_documentos);
		// $documentos_actuales_docente = 0;
		// for ($i = 0; $i < $total_documentos; $i++) {
		// 	$documento = $tipos_documentos[$i];
		// 	$documentos_usuario = $gestiondocente->listarDocumentosObligatorios($id_usuario_hoja_vida, $documento);
		// 	if (!empty($documentos_usuario)) {
		// 		$documentos_actuales_docente++;
		// 	}
		// }
		// if ($documentos_actuales_docente < $total_documentos) {
		// 	echo "No se puede agregar el contrato. Faltan documentos obligatorios.";
		// 	break;
		// }
		$rspta = $gestiondocente->InsertarContratoDocente($documento_docente_contrato, $tipo_contrato_docente, $fecha_inicio_contrato, $fecha_final_contrato, $id_usuario_actual, $periodo_contrato_seleccionado, $nombre_docente_contrato, $apellido_docente_contrato, $salario_docente, $usuario_email_p_contrato, $auxilio_transporte, $cargo_docente, $cantidad_horas, $valor_horas, $materia_docente);
		echo $rspta ? "Contrato Agregado" : "Contrato no se pudo agregar";
		break;
	case 'buscarContratos':
		$usuario_identificacion = $_POST["usuario_identificacion"];
		$data["0"] = "";
		// Listar los perfiles actualizados de los Estudiantes
		$listar_contratos_docentes = $gestiondocente->ListarContratosDocente($usuario_identificacion);
		$data[0] .=
			'		
			<table id="mostrarcontratos" class="table" style="width:100%">
			<thead>
				<tr>
					<th scope="col" class="text-center">Fecha de inicio</th>	
					<th scope="col" class="text-center">Fecha de Final</th>	
					<th scope="col" class="text-center">Periodo</th>	
					<th scope="col" class="text-center">Tipo de Contrato</th>	
					<th scope="col" class="text-center">Acciones</th>	
				</tr>
			</thead>
		<tbody>';
		$usuarios_con_formato_viejo = array(
			'1088280263',
			'1088006014',
			'7555650',
			'1087988174'
		);
		for ($i = 0; $i < count($listar_contratos_docentes); $i++) {
			$tipo_contrato_docente = $listar_contratos_docentes[$i]["tipo_contrato"];
			$ruta_contrato = '';
			if (in_array($listar_contratos_docentes[$i]["usuario_identificacion"], $usuarios_con_formato_viejo)) {
				if ($tipo_contrato_docente == '1') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_media_jornada.php'; // Ruta del contrato viejo
				} elseif ($tipo_contrato_docente == '2') {
					$ruta_contrato = 'contratacion_docente_termino_fijo.php'; // Ruta del contrato viejo
				} elseif ($tipo_contrato_docente == '3') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_hora_catedra.php'; // Ruta del contrato por horas
				} elseif ($tipo_contrato_docente == '4') {
					$ruta_contrato = 'contratacion_docente_prestacion_servicios.php'; // Ruta del contrato por horas
				}
			} else {
				// Lógica para los contratos nuevos
				if ($tipo_contrato_docente == '1') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_media_jornada_v2.php';
				} elseif ($tipo_contrato_docente == '2') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_v2.php';
				} elseif ($tipo_contrato_docente == '3') {
					$ruta_contrato = 'contratacion_docente_termino_fijo_hora_catedra.php'; // Ruta del contrato por horas
				} elseif ($tipo_contrato_docente == '4') {
					$ruta_contrato = 'contratacion_docente_prestacion_servicios.php'; // Ruta del contrato por horas
				}
			}
			$periodo_contrato = $listar_contratos_docentes[$i]["periodo"];
			$periodo_contrato_separado = explode("-", $periodo_contrato);
			$anio_contrato_docente = $periodo_contrato_separado[0];
			$ocultar_boton_eliminar = '';
			// si es igual al año acutual va a dejar eliminar el contrato, si es menor al año actual no lo va a dejar eliminar
			if ($anio_contrato_docente == date("Y")) {
				$ocultar_boton_eliminar = '<button onclick="eliminarContrato(' . $listar_contratos_docentes[$i]["id_docente_contrato"] . ')" class="btn btn-danger btn-xs" title="Eliminar Contrato" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
			}
			//dependiendo del numero que llega muestra el nombre en la tabla
			$tipos_contrato = [
				1 => 'MEDIA JORNADA',
				2 => 'TIEMPO COMPLETO',
				3 => 'HORA CATEDRA',
				4 => 'PRESTACIÓN DE SERVICIOS'
			];
			$contrato_nombre = $tipos_contrato[$tipo_contrato_docente];
			$id_docente_contrato = $listar_contratos_docentes[$i]["id_docente_contrato"];
			$data[0] .= '
			<tr>
			<td class="text-center">' . $listar_contratos_docentes[$i]["fecha_inicio"] . '</td>
			<td class="text-center">' . $listar_contratos_docentes[$i]["fecha_final"] . '</td>
			<td class="text-center">' . $listar_contratos_docentes[$i]["periodo"] . '</td>
			<td class="text-center">' . $contrato_nombre . '</td>
			<td class="text-center">
				<a class="btn btn-info btn-flat btn-xs" 
				href="' . $ruta_contrato . '?uid=' . $id_docente_contrato . '&tipo=' . $tipo_contrato_docente . '&periodo=' . $periodo_contrato . '" 
				target="_blank" 
				title="Ver contrato">
					<i class="fas fa-eye"></i>
				</a>
				' . $ocultar_boton_eliminar . '
			</td>
			</tr>
			';
		}
		$data[0] .= '</tbody></table>';
		echo json_encode($data);
		break;
	case 'eliminarContrato':
		$id_docente_contrato = $_POST['id_docente_contrato'];
		$rspta = $gestiondocente->eliminarContrato($id_docente_contrato);
		echo json_encode($rspta);
		break;
	case 'paso_1':
		$usuario_identificacion = $_POST["usuario_identificacion"];
		$traer_datos = $gestiondocente->paso1($usuario_identificacion);
		if (is_array($traer_datos)) {
			$data = array("exito" => 1, "info" => $traer_datos);
		} else {
			$data = array("exito" => 0, "info" => "El docente no existe");
		}
		echo json_encode($data);
		break;
	case 'traer_departamento':
		$departamento = $_POST["departamento"];
		$traer_datos = $gestiondocente->traer_departamento($departamento);
		if (is_array($traer_datos)) {
			$data = array("exito" => 1, "info" => $traer_datos);
		} else {
			$data = array("exito" => 0, "info" => "El docente no existe");
		}
		echo json_encode($data);
		break;
	case 'traer_municipio':
		$ciudad = $_POST["ciudad"];
		$traer_datos = $gestiondocente->traer_municipio($ciudad);
		if (is_array($traer_datos)) {
			$data = array("exito" => 1, "info" => $traer_datos);
		} else {
			$data = array("exito" => 0, "info" => "El docente no existe");
		}
		echo json_encode($data);
		break;
	case "selectPeriodo":
		$rspta = $gestiondocente->selectPeriodo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
		break;
	case 'paso_2':
		$id_usuario_cv = $_POST["id_usuario_cv"];
		$traer_datos = $gestiondocente->paso2($id_usuario_cv);
		if (is_array($traer_datos)) {
			$data = array("exito" => 1, "info" => $traer_datos);
		} else {
			$data = array("exito" => 0, "info" => "El docente no existe");
		}
		echo json_encode($data);
		break;
	case 'mostrarEducacion':
		$id_usuario_cv = $_POST['id_usuario_cv'];
		$educacions_stmt = $gestiondocente->cv_listareducacion($id_usuario_cv);
		if ($educacions_stmt->rowCount() > 0) {
			$educacions_arr = array();
			while ($row_educacions = $educacions_stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row_educacions);
				$educacions_arr[] = array(
					'id_usuario' => $id_usuario_cv,
					'titulo_obtenido' => $titulo_obtenido,
					'institucion_academica' => $institucion_academica,
					'desde_cuando_f' => $desde_cuando_f,
					'hasta_cuando_f' => $hasta_cuando_f,
					'mas_detalles_f' => $mas_detalles_f,
					'certificado_educacion' => $certificado_educacion,
					'id_formacion' => $id_formacion
				);
			}
		} else {
			$educacions_arr[] = array(
				'id_usuario_cv' => '0',
				'titulo_obtenido' => '',
				'institucion_academica' => '',
				'desde_cuando_f' => '',
				'hasta_cuando_f' => '',
				'mas_detalles_f' => '',
				'certificado_educacion' => '',
				'id_formacion' => ''
			);
		}
		echo (json_encode($educacions_arr));
		break;
	case 'mostrarexperiencias':
		$id_usuario_cv = $_POST['id_usuario_cv'];
		$experiencias_stmt = $gestiondocente->cv_listarExperiencias($id_usuario_cv);
		$experiencias_arr = array();
		if ($experiencias_stmt->rowCount() > 0) {
			while ($row_experiencias = $experiencias_stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row_experiencias);
				$experiencias_arr[] = array(
					'id_usuario_cv' => $id_usuario_cv,
					'nombre_empresa' => $nombre_empresa,
					'cargo_empresa' => $cargo_empresa,
					'desde_cuando' => $desde_cuando,
					'hasta_cuando' => $hasta_cuando,
					'mas_detalles' => $mas_detalles,
					'id_experiencia' => $id_experiencia
				);
			}
		} else {
			$experiencias_arr[] = array(
				'id_usuario_cv' => "0",
				'nombre_empresa' => "",
				'cargo_empresa' => "",
				'desde_cuando' => "",
				'hasta_cuando' => "",
				'mas_detalles' => "",
				'id_experiencia' => ""
			);
		}
		echo (json_encode($experiencias_arr));
		break;
	case 'obtener_id_usuario_cv':
		$usuario_identificacion = $_POST['usuario_identificacion'];
		$result = $gestiondocente->cv_traerIdUsuario($usuario_identificacion);
		if ($result) {
			$id_usuario_cv = $result['id_usuario_cv'];
			$referencias = $gestiondocente->listarReferencias($id_usuario_cv);
			$data["referencias"] = ($referencias && !empty($referencias)) ? '1' : '0';
			$obligatorios = $gestiondocente->listar_documentosObligatorios($id_usuario_cv);
			$data["obligatorios"] = ($obligatorios && !empty($obligatorios)) ? '1' : '0';
			$adicionales = $gestiondocente->listarDocumentosAdicionales($id_usuario_cv);
			$data["adicionales"] = ($adicionales && !empty($adicionales)) ? '1' : '0';
			$area = $gestiondocente->listarArea($id_usuario_cv);
			$data["area"] = ($area && !empty($area)) ? '1' : '0';
			$portafolio = $gestiondocente->cv_listarPortafolio($id_usuario_cv);
			$data["portafolio"] = ($portafolio && !empty($portafolio)) ? '1' : '0';
			$habilidad = $gestiondocente->Habilidad($id_usuario_cv);
			$data["habilidad"] = ($habilidad && !empty($habilidad)) ? '1' : '0';
			$educacion = $gestiondocente->listareducacion($id_usuario_cv);
			$data["educacion"] = ($educacion && !empty($educacion)) ? '1' : '0';
			$experiencia = $gestiondocente->listarExperiencias($id_usuario_cv);
			$data["experiencia"] = ($experiencia && !empty($experiencia)) ? '1' : '0';
			$paso1 = $gestiondocente->listarpaso1($usuario_identificacion);
			$data["paso1"] = ($paso1 && !empty($paso1)) ? '1' : '0';
			$paso2 = $gestiondocente->listarpaso2($id_usuario_cv);
			$data["paso2"] = ($paso2 && !empty($paso2)) ? '1' : '0';
			echo json_encode(array('exito' => 1, 'id_usuario_cv' => $id_usuario_cv, 'info' => $data));
		} else {
			echo json_encode(array('exito' => 0, 'info' => 'No se encontró el usuario.'));
		}
		break;
	case 'mostrarHabilidades':
		$id_usuario_cv = $_POST['id_usuario_cv'];
		$habilidad_stmt = $gestiondocente->listarHabilidad($id_usuario_cv);
		if ($habilidad_stmt->rowCount() > 0) {
			$habilidad_arr = array();
			while ($row_habilidad = $habilidad_stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row_habilidad);
				$habilidad_arr[] = array(
					'id_habilidad' => $id_habilidad,
					'nombre_categoria' => $nombre_categoria,
					'nivel_habilidad' => $nivel_habilidad,
					'id_usuario_cv' => $id_usuario_cv,
				);
			}
		} else {
			$habilidad_arr[] = array(
				'id_habilidad' => "",
				'nombre_categoria' => "",
				'nivel_habilidad' => "",
				'id_usuario_cv' => "0"
			);
		}
		echo (json_encode($habilidad_arr));
		break;
	case 'mostrarPortafolio':
		$id_usuario_cv = $_POST["id_usuario_cv"];
		$portafolios_stmt = $gestiondocente->listarPortafolio($id_usuario_cv);
		if ($portafolios_stmt->rowCount() > 0) {
			$portafolios_arr = array();
			while ($row_portafolios = $portafolios_stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row_portafolios);
				$portafolios_arr[] = array(
					'id_usuario_cv' => $id_usuario_cv,
					'video_portafolio' => $video_portafolio,
					'titulo_portafolio' => $titulo_portafolio,
					'descripcion_portafolio' => $descripcion_portafolio,
					'portafolio_archivo' => $portafolio_archivo,
					'id_portafolio' => $id_portafolio
				);
			}
		} else {
			$portafolios_arr[] = array(
				'id_usuario_cv' => "0",
				'video_portafolio' => "",
				'titulo_portafolio' => "",
				'descripcion_portafolio' => "",
				'id_portafolio' => ""
			);
		}
		echo (json_encode($portafolios_arr));
		break;
	case 'mostrarReferenciasPersonales':
		$id_usuario_cv = isset($_POST["id_usuario_cv"]) ? $_POST["id_usuario_cv"] : "";
		$referencias_stmt = $gestiondocente->cvlistarReferencias($id_usuario_cv);
		$referencias_arr = array();
		if ($referencias_stmt->rowCount() > 0) {
			while ($row_referencias = $referencias_stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row_referencias);
				$referencias_arr[] = array(
					'id_referencias' => $id_referencias,
					'referencias_nombre' => $referencias_nombre,
					'referencias_profesion' => $referencias_profesion,
					'referencias_empresa' => $referencias_empresa,
					'referencias_telefono' => $referencias_telefono,
					'id_usuario' => $id_usuario_cv,
				);
			}
		} else {
			$referencias_arr[] = array(
				'id_referencias' => "",
				'referencias_nombre' => "",
				'referencias_profesion' => "",
				'referencias_empresa' => "",
				'referencias_telefono' => "",
				'id_usuario' => "0"
			);
		}
		echo (json_encode($referencias_arr));
		break;
	case 'mostrarDocumentosAdicionales':
		$id_usuario_cv = $_POST['id_usuario_cv'];
		$documentosA_stmt = $gestiondocente->cvalistarDocumentosAdicionales($id_usuario_cv);
		if ($documentosA_stmt->rowCount() > 0) {
			$documentosA_arr = array();
			while ($documentosArow_ = $documentosA_stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($documentosArow_);
				$documentosA_arr[] = array(
					'id_documentoA' => $id_documentacion,
					'documento_nombreA' => $documento_nombre,
					'documento_archivoA' => $documento_archivo,
					'id_usuario_cv' => $id_usuario_cv,
				);
			}
		} else {
			$documentosA_arr[] = array(
				'id_documentoA' => "",
				'documento_nombreA' => "",
				'documento_archivoA' => "",
				'id_usuario_cv' => "0",
			);
		}
		echo (json_encode($documentosA_arr));
		break;
	case 'mostrarAreas':
		$id_usuario_cv = $_POST['id_usuario_cv'];
		$area_stmt = $gestiondocente->cv_listarArea($id_usuario_cv);
		if ($area_stmt->rowCount() > 0) {
			$area_arr = array();
			while ($row_area = $area_stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row_area);
				$area_arr[] = array(
					'id_area' => $id_area,
					'nombre_area' => $nombre_area
				);
			}
		} else {
			$area_arr[] = array(
				'id_area' => "",
				'nombre_area' => ""
			);
		}
		echo (json_encode($area_arr));
		break;
	case 'mostrarDocumentosObligatorios':
		$id_usuario_cv = $_POST['id_usuario_cv'];
		$data = [''];
		$data[0] = '
			<table id="mostrardocumentosobligatorios" style="width:100%">
			<thead>
			<tr>
				<th scope="col" class="text-center">Tipo Archivo</th>
				<th scope="col" class="text-center">Archivo Nombre</th>
			</tr>
			</thead>
			<tbody>';
		$tipos_documentos = [
			"Cédula de ciudadanía",
			"Certificación Bancaria",
			"Antecedentes Judiciales Policía",
			"Antecedentes Contraloría",
			"Antecedentes Procuraduría",
			"Referencias Laborales",
			"Certificado Afiliación EPS",
			"Certificado Afiliación AFP (Fondo de Pensión)",
			"Registro Único Tributario (RUT)",
			"Tarjeta Profesional"
		];
		$documentos_count = count($tipos_documentos);
		for ($i = 0; $i < $documentos_count; $i++) {
			$nombre_documentos = $tipos_documentos[$i];
			$nombre_documentos_filtrado = trim(preg_replace('/\s*\(.*?\)\s*/', '', $nombre_documentos));
			// Verificar si el usuario tiene el documento con su nombre actual
			$documentos_usuario = $gestiondocente->listarDocumentosObligatorios($id_usuario_cv, $nombre_documentos_filtrado);
			if (is_array($documentos_usuario) && count($documentos_usuario) > 0 && !empty($documentos_usuario[0]['documento_archivo'])) {
				$ruta_documento_obligatorio = '<a href="' . $documentos_usuario[0]['documento_archivo'] . '" target="_blank">Abrir Archivo</a>';
			} else {
				$ruta_documento_obligatorio = 'Falta Subir';
			}
			$data[0] .= '
										<tr>
											<td>' . $nombre_documentos . '</td>
											<td>' . $ruta_documento_obligatorio . '</td>
										</tr>';
		}
		$data[0] .= '</tbody></table>';
		echo json_encode($data);
		break;
	case 'mostrarReferenciasLaborales':
		$id_usuario_cv = $_POST['id_usuario_cv'];
		$referencias_stmt = $gestiondocente->cv_listarReferencias($id_usuario_cv);
		$referencias_arr = array();
		if ($referencias_stmt->rowCount() > 0) {
			while ($row_referencias = $referencias_stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row_referencias);
				$referencias_arr[] = array(
					'id_referenciasl' => $id_referencias,
					'referencias_nombrel' => $referencias_nombre,
					'referencias_profesionl' => $referencias_profesion,
					'referencias_empresal' => $referencias_empresa,
					'referencias_telefonol' => $referencias_telefono,
					'id_usuario_cv' => $id_usuario_cv,
				);
			}
		} else {
			$referencias_arr[] = array(
				'id_referenciasl' => "",
				'referencias_nombrel' => "",
				'referencias_profesionl' => "",
				'referencias_empresal' => "",
				'referencias_telefonol' => "",
				'id_usuario_cv' => "0"
			);
		}
		echo (json_encode($referencias_arr));
		break;
	case 'obtenerestado':
		break;
	case 'descargarzip':
		if (!isset($_GET['usuario_identificacion'])) {
			http_response_code(400);
			echo "Cédula no proporcionada.";
			exit;
		}
		$usuario_identificacion = preg_replace('/[^0-9]/', '', $_GET['usuario_identificacion']);
		$rspta_usuario = $gestiondocente->cv_traerIdUsuario($usuario_identificacion);
		if (!$rspta_usuario || empty($rspta_usuario["id_usuario_cv"])) {
			http_response_code(404);
			echo "No se encontró el usuario.";
			exit;
		}
		$id_usuario_cv = $rspta_usuario["id_usuario_cv"];
		$certificados = $gestiondocente->obtenerCertificados($id_usuario_cv) ?: [];
		$documentacion = $gestiondocente->obtenerDocumentacion($id_usuario_cv) ?: [];
		$portafolio = $gestiondocente->obtenerPortafolio($id_usuario_cv) ?: [];
		$zip_filename = "documentos_" . $usuario_identificacion . ".zip";
		$zip_path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zip_filename;
		if (file_exists($zip_path)) {
			unlink($zip_path);
		}
		$zip = new ZipArchive();
		if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
			$archivos_encontrados = 0;
			$ruta_base = realpath(__DIR__ . '/../cv/files/');
			// 1. CERTIFICADOS DE EDUCACIÓN
			$certCount = count($certificados);
			for ($i = 0; $i < $certCount; $i++) {
				if (empty($certificados[$i]['certificado_educacion'])) continue;
				$archivo_relativo = $certificados[$i]['certificado_educacion'];
				$subpath = str_replace('../files/', '', $archivo_relativo);
				$archivo = $ruta_base . DIRECTORY_SEPARATOR . $subpath;
				if (is_file($archivo)) {
					$zip->addFile($archivo, 'certificados/' . basename($archivo));
					$archivos_encontrados++;
				}
			}
			// 2. DOCUMENTACIÓN DE USUARIO
			$docCount = count($documentacion);
			for ($i = 0; $i < $docCount; $i++) {
				if (empty($documentacion[$i]['documento_archivo'])) continue;
				$archivo_relativo = $documentacion[$i]['documento_archivo'];
				$subpath = ltrim(str_replace(['../cv/files/', './', '../'], '', $archivo_relativo), '/\\');
				$archivo = $ruta_base . DIRECTORY_SEPARATOR . $subpath;
				if (is_file($archivo)) {
					$zip->addFile($archivo, 'documentacion/' . basename($archivo));
					$archivos_encontrados++;
				}
			}
			// 3. PORTAFOLIO
			$portCount = count($portafolio);
			for ($i = 0; $i < $portCount; $i++) {
				if (empty($portafolio[$i]['portafolio_archivo'])) continue;
				$archivo_relativo = $portafolio[$i]['portafolio_archivo'];
				$subpath = str_replace('../files/', '', $archivo_relativo);
				$archivo = $ruta_base . DIRECTORY_SEPARATOR . $subpath;
				if (is_file($archivo)) {
					$zip->addFile($archivo, 'portafolio/' . basename($archivo));
					$archivos_encontrados++;
				}
			}
			// Si no hay archivos, agrega un README que diga que no tiene archivos.
			if ($archivos_encontrados === 0) {
				$zip->addFromString("README.txt", "No se encontraron documentos para el usuario $usuario_identificacion.");
			}
			$zip->close();
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename="' . $zip_filename . '"');
			header('Content-Length: ' . filesize($zip_path));
			readfile($zip_path);
			unlink($zip_path);
			exit;
		} else {
			http_response_code(500);
			echo "No se pudo crear el archivo ZIP.";
		}
		break;
	case 'influencer_mas':
		$id_usuario = isset($_POST["id_usuario"]) ? $_POST["id_usuario"] : "";
		$estado = isset($_POST["estado"]) ? $_POST["estado"] : "";
		$actualizar_influencer_mas = $gestiondocente->actualizar_influencer_mas($id_usuario, $estado);
		if ($actualizar_influencer_mas) {
			$data = array("exito" => 1);
		} else {
			$data = array("exito" => 0);
		}
		echo json_encode($data);
		break;
	// insertamos los comentarios docentes.
	case 'comentario_docente':
		$rspta = $gestiondocente->insertarComentarioDocente($id_usuario_cv_comentario_docente, $mensaje_docente, $fecha_actual, $hora_actual, $periodo_actual_historico, $id_usuario_actual);
		$data["0"] = $rspta ? "ok" : "error";
		$results = array($data);
		echo json_encode($results);
		break;
	// listamos los comentarios del docente seleccionado.
	case 'ListarComentariosDocente':
		$id_usuario_cv = $_POST['id_usuario_cv'];
		$rspta = $gestiondocente->ListarComentariosDocente($id_usuario_cv);
		$data["info"] = "";
		for ($i = 0; $i < count($rspta); $i++) {
			$data["info"] .=
				"<tr>". 
				"<td>" . $rspta[$i]['mensaje_docente_comentario'] . "</td>" .
				"<td>" . $gestiondocente->fechaesp($rspta[$i]['fecha_comentario']) . "</td>" .
				"<td>" . $rspta[$i]['hora_comentario'] . "</td>" .
				"<td>" . $rspta[$i]['periodo_comentario'] . "</td>
			</tr>";
		}
		echo json_encode($data);
		break;
}
