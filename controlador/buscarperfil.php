<?php
session_start();
require_once "../modelos/BuscarPerfil.php";

date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:s');

$buscar_perfil = new BuscarPerfil();
$cedula_estu = isset($_POST["cedula_estu"]) ? limpiarCadena($_POST["cedula_estu"]) : "";
// variable para llenar el formulario del estudiante
$id_credencial_oculto = isset($_POST["id_credencial_oculto"]) ? limpiarCadena($_POST["id_credencial_oculto"]) : "";
$id_credencial_guardar_estudiante = isset($_POST["id_credencial_guardar_estudiante"]) ? limpiarCadena($_POST["id_credencial_guardar_estudiante"]) : "";
$lugar_nacimiento_oculto = isset($_POST["lugar_nacimiento_oculto"]) ? limpiarCadena($_POST["lugar_nacimiento_oculto"]) : "";
//Filtra la cedula del estudiante.
$cedula = isset($_POST["cedula"]) ? limpiarCadena($_POST["cedula"]) : "";
// variables para formulario perfil estudiante.
$cedula_estudiante = isset($_POST["cedula_estudiante"]) ? limpiarCadena($_POST["cedula_estudiante"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$genero = isset($_POST["genero"]) ? limpiarCadena($_POST["genero"]) : "";
$expedido_en = isset($_POST["expedido_en"]) ? limpiarCadena($_POST["expedido_en"]) : "";

$fecha_expedicion = isset($_POST["fecha_expedicion"]) ? limpiarCadena($_POST["fecha_expedicion"]) : "NULL";

$fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? limpiarCadena($_POST["fecha_nacimiento"]) : "";


$departamento_nacimiento = isset($_POST["departamento_nacimiento"]) ? limpiarCadena($_POST["departamento_nacimiento"]) : "";
$municipio_nacimiento_estudiante = isset($_POST["municipio_nacimiento_estudiante"]) ? limpiarCadena($_POST["municipio_nacimiento_estudiante"]) : "";
$id_municipio_nac = isset($_POST["id_municipio_nac"]) ? limpiarCadena($_POST["id_municipio_nac"]) : "";
// $departamento_residencia = isset($_POST["departamento_residencia"]) ? limpiarCadena($_POST["departamento_residencia"]) : "";
$municipio = isset($_POST["municipio"]) ? limpiarCadena($_POST["municipio"]) : "";
$tipo_residencia = isset($_POST["tipo_residencia"]) ? limpiarCadena($_POST["tipo_residencia"]) : "";
$direccion_residencia = isset($_POST["direccion_residencia"]) ? limpiarCadena($_POST["direccion_residencia"]) : "";
$barrio_residencia = isset($_POST["barrio_residencia"]) ? limpiarCadena($_POST["barrio_residencia"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$celular = isset($_POST["celular"]) ? limpiarCadena($_POST["celular"]) : "";
$tipo_sangre = isset($_POST["tipo_sangre"]) ? limpiarCadena($_POST["tipo_sangre"]) : "";
$codigo_pruebas = isset($_POST["codigo_pruebas"]) ? limpiarCadena($_POST["codigo_pruebas"]) : "";
$credencial_nombre = isset($_POST["credencial_nombre"]) ? limpiarCadena($_POST["credencial_nombre"]) : "";
$credencial_nombre_2 = isset($_POST["credencial_nombre_2"]) ? limpiarCadena($_POST["credencial_nombre_2"]) : "";
$credencial_apellido = isset($_POST["credencial_apellido"]) ? limpiarCadena($_POST["credencial_apellido"]) : "";
$credencial_apellido_2 = isset($_POST["credencial_apellido_2"]) ? limpiarCadena($_POST["credencial_apellido_2"]) : "";
$credencial_login = isset($_POST["credencial_login"]) ? limpiarCadena($_POST["credencial_login"]) : "";
$estado_civil = isset($_POST["estado_civil"]) ? limpiarCadena($_POST["estado_civil"]) : "";
$grupo_etnico = isset($_POST["grupo_etnico"]) ? limpiarCadena($_POST["grupo_etnico"]) : "";
$nombre_etnico = isset($_POST["nombre_etnico"]) ? limpiarCadena($_POST["nombre_etnico"]) : "";
$desplazado_violencia = isset($_POST["desplazado_violencia"]) ? limpiarCadena($_POST["desplazado_violencia"]) : "";
$conflicto_armado = isset($_POST["conflicto_armado"]) ? limpiarCadena($_POST["conflicto_armado"]) : "";
$depar_residencia = isset($_POST["depar_residencia"]) ? limpiarCadena($_POST["depar_residencia"]) : "";
$zona_residencia = isset($_POST["zona_residencia"]) ? limpiarCadena($_POST["zona_residencia"]) : "";
$cod_postal = isset($_POST["cod_postal"]) ? limpiarCadena($_POST["cod_postal"]) : "";
$estrato = isset($_POST["estrato"]) ? limpiarCadena($_POST["estrato"]) : "";
$whatsapp = isset($_POST["whatsapp"]) ? limpiarCadena($_POST["whatsapp"]) : "";
$instagram = isset($_POST["instagram"]) ? limpiarCadena($_POST["instagram"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$fecha_actualizacion = isset($_POST["fecha_actualizacion"]) ? limpiarCadena($_POST["fecha_actualizacion"]) : "";
$op = (isset($_GET['op'])) ? $_GET['op'] : 'mostrar';
switch ($op) {
	case 'verificar':
		// dato que llega en el filtro
		$dato = $_POST["dato"];
		// tipo de dato(Indentificación, correo, celular)
		$tipo = $_POST["tipo"];
		// $id_credencial_seleccionado = $_POST["id_credencial_seleccionado"]; #id_credencial seleccionado por la tabla

		$valor_seleccionado = '';
		if ($tipo == "1") {
			$valor_seleccionado = 'credencial_identificacion = ' . $dato;
		}
		if ($tipo == "2") {
			$valor_seleccionado = "`credencial_estudiante`.`credencial_login` = '" . $dato . "'";
		}
		if ($tipo == "3") {
			$valor_seleccionado = 'celular = ' . $dato;
		}

		if ($tipo == "4") {
			$valor_seleccionado = "`credencial_estudiante`.`credencial_nombre` LIKE '" . $dato . "' OR `credencial_nombre_2` LIKE '" . $dato . "'";
		}


		// consulta para validar el estudiante si esta registrado 
		$verificar_cedula = $buscar_perfil->verificarDocumento($valor_seleccionado);
		if (is_array($verificar_cedula)) {
			$data = array("exito" => 1, "info" => $verificar_cedula);
			$informacion_carrera = $buscar_perfil->cargarInformacion($verificar_cedula['id_credencial']);
			$fo_programa_general = "";
			$fo_programa_idiomas = "";
			foreach ($informacion_carrera as $programa) {
				if (strpos($programa['fo_programa'], "Idiomas") !== false) {
					$fo_programa_idiomas .= '<div class="col-auto borde py-2">' . $programa['fo_programa'] . '</div>';
				} else {
					$fo_programa_general .= '<div class="col-auto borde py-2">' . $programa['fo_programa'] . '</div>';
				}
			}
			$fo_programa = '	
				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-12 text-semibold fs-14 titulo-2">Programas Generales</div>
							' . $fo_programa_general . '
						</div>
					</div>
					<div class="col-sm-12">
						<div class="row">
							<div class="col-12 text-semibold fs-14 titulo-2">Escuela de idiomas</div>
							' . $fo_programa_idiomas . '
						</div>
					</div>
				</div>';

			$data["info"]["fo_programa"] = $fo_programa;
		} else {
			$data = array("exito" => 0, "info" => "El estudiante no existe");
		}
		echo json_encode($data);
		break;
	case 'editar_personal':
		$fecha_expedicion = empty($fecha_expedicion) ? '' : $fecha_expedicion;
		$fecha_nacimiento = empty($fecha_nacimiento) ? '' : $fecha_nacimiento;
		$municipio = empty($municipio) ? '' : $municipio;
		$telefono = empty($telefono) ? '' : $telefono;
		$desplazado_violencia = empty($desplazado_violencia) ? '' : $desplazado_violencia;
		$tipo_documento = empty($tipo_documento) ? '' : $tipo_documento;
		$tipo_residencia = empty($tipo_residencia) ? '' : $tipo_residencia;
		$codigo_pruebas = empty($codigo_pruebas) ? '' : $codigo_pruebas;
		$expedido_en = empty($expedido_en) ? '' : $expedido_en;
		$estado_civil = empty($estado_civil) ? '' : $estado_civil;
		$conflicto_armado = empty($conflicto_armado) ? '' : $conflicto_armado;
		$zona_residencia = empty($zona_residencia) ? '' : $zona_residencia;
		$cod_postal = empty($cod_postal) ? '' : $cod_postal;
		$whatsapp = empty($whatsapp) ? '' : $whatsapp;
		$instagram = empty($instagram) ? '' : $instagram;
		$buscar_perfil->editarDatospersonales( $credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $genero, $fecha_nacimiento, $departamento_nacimiento, $municipio_nacimiento_estudiante, $depar_residencia, $municipio, $tipo_documento, $cedula_estudiante, $fecha_expedicion, $estrato, $id_municipio_nac, $tipo_residencia, $direccion_residencia, $barrio_residencia, $telefono, $celular, $tipo_sangre, $codigo_pruebas, $email, $expedido_en, $credencial_login, $estado_civil, $grupo_etnico, $nombre_etnico, $desplazado_violencia, $conflicto_armado, $zona_residencia, $cod_postal, $whatsapp, $instagram, $id_credencial_guardar_estudiante);
		break;
	case "selectMunicipio":
		$departamento = $_POST["departamento"];
		$rspta = $buscar_perfil->selectMunicipio($departamento);
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
		}
		break;

	case "selectDepartamento":
		if ($departamento_nacimiento == "") {
			$rspta = $buscar_perfil->selectDepartamentoMunicipioActivo($id_credencial_oculto);
			$departamento_actual = $rspta["departamento_nacimiento"];
			echo "<option value='" . $departamento_actual . "'>" . $departamento_actual . "</option>";
		}

		$rspta = $buscar_perfil->selectDepartamento();
		echo "<option value='" . $departamento_nacimiento . "'>" . $departamento_nacimiento . "</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
		}
		break;
	case "selectGenero":
		$rspta = $buscar_perfil->selectGenero();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["genero"] . "'>" . $rspta[$i]["genero"] . "</option>";
		}
		break;
	case "selectTipo_sangre":
		$rspta = $buscar_perfil->selectTipo_sangre();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre_sangre"] . "'>" . $rspta[$i]["nombre_sangre"] . "</option>";
		}
		break;
	case "selectGrupoEtnico":
		$rspta = $buscar_perfil->selectGrupoEtnico();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["grupo_etnico"] . "'>" . $rspta[$i]["grupo_etnico"] . "</option>";
		}
		break;
	case "selectEstado_civil":
		$rspta = $buscar_perfil->selectEstado_civil();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;


	case 'listar_datos_estudiantes':
		$idCredencial = isset($_GET['id_credencial']) ? $_GET['id_credencial'] : null; #idcredencial estudiante
		$valor = isset($_GET['valor_global']) ? $_GET['valor_global'] : null; #dependiendo del numero trae los datos
		$dato = isset($_GET['dato']) ? $_GET['dato'] : null; #palabra buscada en el filtro
		if ($valor == "4") {
			$registro = $buscar_perfil->buscar_por_nombre($dato);
		} else {
			$registro = $buscar_perfil->trae_id_credencial($idCredencial);
		}
		$data = array();
		// print_r($registro);
		for ($i = 0; $i < count($registro); $i++) {
			$id_credencial_seleccionado = $registro[$i]['id_credencial'];
			$data[] = array(
				'0' => '<button onclick="mostrar_formulario_editar(' . $id_credencial_seleccionado . ')" class="btn btn-primary btn-xs"><i class="far fa-edit"></i></button> ' . $registro[$i]['credencial_identificacion'],
				'1' => $registro[$i]['credencial_apellido'] . ' ' . $registro[$i]['credencial_apellido_2'],
				'2' => $registro[$i]['credencial_nombre'] . ' ' . $registro[$i]['credencial_nombre_2']
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



	case 'mostrar_formulario_editar':
		//id credencial para modificar los datos personales del estudiante que se selecciona en la tabla
		$id_credencial_seleccionado = $_POST["id_credencial_seleccionado"]; #id_credencial seleccionado por la tabla

		// consulta el estudiante seleccionado y trae los datos al formulario
		$verificar_cedula = $buscar_perfil->editar_datos_formulario($id_credencial_seleccionado);
		if (is_array($verificar_cedula)) {
			$data = array("exito" => 1, "info" => $verificar_cedula);
		} else {
			$data = array("exito" => 0, "info" => "El estudiante no existe");
		}
		echo json_encode($data);
		break;
}
