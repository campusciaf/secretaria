<?php
require "../config/Conexion.php";

class BuscarPerfil
{
	// Implementamos nuestro constructor
	public function __construct() {}

	public function trae_id_credencial($id_credencial)
	{
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial";
		// echo $sql;

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function buscar_por_nombre($credencial_nombre)
	{
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `credencial_nombre` LIKE :credencial_nombre OR `credencial_nombre_2` LIKE :credencial_nombre";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_nombre", $credencial_nombre);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarDocumento($valor_seleccionado)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT `credencial_estudiante`.id_credencial FROM `credencial_estudiante` INNER JOIN `estudiantes_datos_personales` ON `credencial_estudiante`.`id_credencial` = `estudiantes_datos_personales`.`id_credencial` WHERE $valor_seleccionado");
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
	}
	public function cargarInformacion($id_credencial)
	{
		$sql_cargar_info = "SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial ORDER BY `estudiantes`.`fo_programa` ASC";
		global $mbd;
		$consulta_cargar_info = $mbd->prepare($sql_cargar_info);
		$consulta_cargar_info->execute(array(":id_credencial" => $id_credencial));
		$resultado_cargar = $consulta_cargar_info->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_cargar;
	}
	public function editarDatospersonales( $credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $genero, $fecha_nacimiento, $departamento_nacimiento, $municipio_nacimiento_estudiante, $depar_residencia, $municipio, $tipo_documento, $cedula_estudiante, $fecha_expedicion, $estrato, $id_municipio_nac, $tipo_residencia, $direccion_residencia, $barrio_residencia, $telefono, $celular, $tipo_sangre, $codigo_pruebas, $email, $expedido_en, $credencial_login, $estado_civil, $grupo_etnico, $nombre_etnico, $desplazado_violencia, $conflicto_armado, $zona_residencia, $cod_postal, $whatsapp, $instagram, $id_credencial_guardar_estudiante) {
		global $mbd;

		$fecha_expedicion = empty($fecha_expedicion) ? NULL : $fecha_expedicion;
		$fecha_nacimiento = empty($fecha_nacimiento) ? NULL : $fecha_nacimiento;
		$sentencia = $mbd->prepare("UPDATE credencial_estudiante AS uno INNER JOIN estudiantes_datos_personales AS dos ON uno.id_credencial = dos.id_credencial SET uno.credencial_nombre = :credencial_nombre, uno.credencial_nombre_2 = :credencial_nombre_2, uno.credencial_apellido = :credencial_apellido, uno.credencial_apellido_2 = :credencial_apellido_2, dos.genero = :genero, dos.fecha_nacimiento = :fecha_nacimiento, dos.departamento_nacimiento = :departamento_nacimiento, dos.lugar_nacimiento = :lugar_nacimiento,  dos.depar_residencia = :depar_residencia, dos.municipio = :municipio, dos.tipo_documento = :tipo_documento, uno.credencial_identificacion = :credencial_identificacion, dos.fecha_expedicion = :fecha_expedicion, dos.estrato = :estrato, dos.id_municipio_nac = :id_municipio_nac, dos.tipo_residencia = :tipo_residencia, dos.direccion = :direccion, dos.barrio = :barrio, dos.telefono = :telefono, dos.celular = :celular, dos.tipo_sangre = :tipo_sangre, dos.codigo_pruebas = :codigo_pruebas, dos.email = :email, dos.expedido_en = :expedido_en, uno.credencial_login = :credencial_login, dos.estado_civil = :estado_civil, dos.grupo_etnico = :grupo_etnico, dos.nombre_etnico = :nombre_etnico, dos.desplazado_violencia = :desplazado_violencia, dos.conflicto_armado = :conflicto_armado, dos.zona_residencia = :zona_residencia, dos.cod_postal = :cod_postal, dos.whatsapp = :whatsapp, dos.instagram = :instagram WHERE uno.id_credencial = :id_credencial_guardar_estudiante");
		$sentencia->bindParam(":credencial_nombre", $credencial_nombre);
		$sentencia->bindParam(":fecha_expedicion", $fecha_expedicion);
		$sentencia->bindParam(":credencial_nombre_2", $credencial_nombre_2);
		$sentencia->bindParam(":credencial_apellido", $credencial_apellido);
		$sentencia->bindParam(":credencial_apellido_2", $credencial_apellido_2);
		$sentencia->bindParam(":genero", $genero);
		$sentencia->bindParam(":fecha_nacimiento", $fecha_nacimiento);
		$sentencia->bindParam(":departamento_nacimiento", $departamento_nacimiento);
		$sentencia->bindParam(":lugar_nacimiento", $municipio_nacimiento_estudiante);
		$sentencia->bindParam(":depar_residencia", $depar_residencia);
		$sentencia->bindParam(":municipio", $municipio);
		$sentencia->bindParam(":tipo_documento", $tipo_documento);
		$sentencia->bindParam(":credencial_identificacion", $cedula_estudiante);
		$sentencia->bindParam(":estrato", $estrato);
		$sentencia->bindParam(":id_municipio_nac", $id_municipio_nac);
		$sentencia->bindParam(":tipo_residencia", $tipo_residencia);
		$sentencia->bindParam(":direccion", $direccion_residencia);
		$sentencia->bindParam(":barrio", $barrio_residencia);
		$sentencia->bindParam(":telefono", $telefono);
		$sentencia->bindParam(":celular", $celular);
		$sentencia->bindParam(":tipo_sangre", $tipo_sangre);
		$sentencia->bindParam(":codigo_pruebas", $codigo_pruebas);
		$sentencia->bindParam(":email", $email);
		$sentencia->bindParam(":expedido_en", $expedido_en);
		$sentencia->bindParam(":credencial_login", $credencial_login);
		$sentencia->bindParam(":estado_civil", $estado_civil);
		$sentencia->bindParam(":grupo_etnico", $grupo_etnico);
		$sentencia->bindParam(":nombre_etnico", $nombre_etnico);
		$sentencia->bindParam(":desplazado_violencia", $desplazado_violencia);
		$sentencia->bindParam(":conflicto_armado", $conflicto_armado);
		$sentencia->bindParam(":zona_residencia", $zona_residencia);
		$sentencia->bindParam(":cod_postal", $cod_postal);
		$sentencia->bindParam(":whatsapp", $whatsapp);
		$sentencia->bindParam(":instagram", $instagram);
		$sentencia->bindParam(":id_credencial_guardar_estudiante", $id_credencial_guardar_estudiante);
		if ($sentencia->execute()) {
			$data['status'] = "ok";
			$_SESSION['status_update'] = 1;
		} else {
			$data['status'] = "Error al actualizar los datos personales.";
		}
		echo json_encode($data);
	}
	public function selectDepartamentoMunicipioActivo($documento)
	{
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` INNER JOIN `estudiantes_datos_personales` ON `credencial_estudiante`.`id_credencial` = `estudiantes_datos_personales`.`id_credencial` WHERE `credencial_estudiante`.`credencial_identificacion` = :documento";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento", $documento);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
	public function selectDepartamento()
	{
		$sql = "SELECT * FROM departamentos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function selectMunicipio($departamento)
	{
		$sql_buscar = "SELECT `municipios`.`municipio` FROM `departamentos` INNER JOIN `municipios` ON `departamentos`.`id_departamento` = `municipios`.`departamento_id` WHERE `departamentos`.`departamento` = :departamento;";
		global $mbd;
		$consulta_buscar = $mbd->prepare($sql_buscar);
		$consulta_buscar->bindParam(':departamento', $departamento);
		$consulta_buscar->execute();
		$resultado_buscar = $consulta_buscar->fetchall(PDO::FETCH_ASSOC);
		return $resultado_buscar;
	}
	public function selectGenero()
	{
		$sql = "SELECT * FROM genero";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectTipo_sangre()
	{
		$sql = "SELECT * FROM tipo_sangre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectGrupoEtnico()
	{
		$sql = "SELECT * FROM grupo_etnico";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectEstado_civil()
	{
		$sql = "SELECT * FROM estado_civil";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function editar_datos_formulario($id_credencial)
	{
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` INNER JOIN `estudiantes_datos_personales` ON `credencial_estudiante`.`id_credencial` = `estudiantes_datos_personales`.`id_credencial` WHERE `credencial_estudiante`.`id_credencial` = :id_credencial";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
}
