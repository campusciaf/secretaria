<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class ConsultaGraduadosGeneral
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Funcion para mostrar el proyecto 

	//Implementar un método para listar las condiciones institucionales
	public function mostrargraduados($ciclo)
	{
		global $mbd;

		if ($ciclo == 0) { // significa todas las escuelas
			$sql = "SELECT credencial_estudiante.id_credencial,credencial_estudiante.credencial_nombre, credencial_estudiante.credencial_nombre_2, credencial_estudiante.credencial_apellido, credencial_estudiante.credencial_apellido_2, credencial_estudiante.credencial_identificacion, graduados.pruebas_saber_pro,  estudiantes_datos_personales.email, estudiantes_datos_personales.celular, graduados.acta_grado, graduados.folio, graduados.fecha_grado,graduados.periodo_grado, credencial_estudiante.credencial_login, estudiantes.fo_programa,estudiantes.periodo,jornada_e,estado,ciclo,periodo_activo
			FROM graduados INNER JOIN credencial_estudiante ON credencial_estudiante.id_credencial = graduados.id_credencial INNER JOIN estudiantes_datos_personales ON estudiantes_datos_personales.id_credencial = graduados.id_credencial INNER JOIN estudiantes ON estudiantes.id_estudiante = graduados.id_estudiante";
			$consulta = $mbd->prepare($sql);
			$consulta->execute();
		} else { 
			$sql = "SELECT credencial_estudiante.id_credencial,credencial_estudiante.credencial_nombre, credencial_estudiante.credencial_nombre_2, credencial_estudiante.credencial_apellido, credencial_estudiante.credencial_apellido_2, credencial_estudiante.credencial_identificacion, graduados.pruebas_saber_pro,  estudiantes_datos_personales.email, estudiantes_datos_personales.celular, graduados.acta_grado, graduados.folio, graduados.fecha_grado,graduados.periodo_grado, credencial_estudiante.credencial_login, estudiantes.fo_programa,estudiantes.periodo,jornada_e,estado,ciclo,periodo_activo FROM graduados 
			INNER JOIN credencial_estudiante ON credencial_estudiante.id_credencial = graduados.id_credencial INNER JOIN estudiantes_datos_personales ON estudiantes_datos_personales.id_credencial = graduados.id_credencial INNER JOIN estudiantes ON estudiantes.id_estudiante = graduados.id_estudiante WHERE estudiantes.ciclo = :ciclo";
			
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":ciclo", $ciclo);
			$consulta->execute();
		}

		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//traer la temporada del periodo
	public function termporada($periodo)
	{
		$sql = "SELECT * FROM periodo WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



	//Implementamos un método para insertar seguimiento
	public function insertarSeguimiento($id_usuario, $id_credencial, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora)
	{
		$sql = "INSERT INTO egresados_seguimiento (id_usuario,id_credencial,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento)
		VALUES ('$id_usuario','$id_credencial','$motivo_seguimiento','$mensaje_seguimiento','$fecha','$hora')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementar un método para listar el historial de las tareas
	public function verHistorialTareasEgresados($id_credencial)
	{
		$sql = "SELECT * FROM egresados_tareas WHERE id_credencial= :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar el historial de seguimiento
	public function verHistorialSeguimientoEgresados($id_credencial)
	{
		$sql = "SELECT * FROM egresados_seguimiento WHERE id_credencial= :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//informacion del usuario que creo el seguimiento o la tarea
	public function datosAsesor($id_usuario)
	{
		$sql = "SELECT * FROM usuario WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//consultar la fecha por letra
	public function fechaesp($date)
	{
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}


	//Implementamos un método para insertar una tarea
	public function insertarTarea($id_usuario, $id_credencial, $motivo_tarea, $mensaje_tarea, $fecha_registro, $hora_registro, $fecha_programada, $hora_programada, $fecha_realizo, $hora_realizo, $periodo_actual)
	{
		$sql = "INSERT INTO egresados_tareas (id_usuario,id_credencial,motivo_tarea,mensaje_tarea,fecha_registro,hora_registro,fecha_programada,hora_programada,fecha_realizo,hora_realizo,periodo)
		VALUES ('$id_usuario','$id_credencial','$motivo_tarea','$mensaje_tarea','$fecha_registro','$hora_registro','$fecha_programada','$hora_programada','$fecha_realizo','$hora_realizo','$periodo_actual')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}



	//Implementamos un método para insertar un mensaje
	public function insertarmensaje($numero_celular, $mensaje, $fecha, $hora, $id_usuario)
	{
		$sql = "INSERT INTO `egresados_mensaje`(`numero_celular`, `mensaje`, `fecha`, `hora`, `id_usuario`)
	VALUES ('$numero_celular','$mensaje','$fecha','$hora','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}



	public function mostrar_egresado($id_credencial)
	{
		$sql = "SELECT * FROM `credencial_estudiante` INNER JOIN `estudiantes_datos_personales` ON `credencial_estudiante`.`id_credencial` = `estudiantes_datos_personales`.`id_credencial` WHERE `credencial_estudiante`.`id_credencial` = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



	public function selectTipoSangre()
	{
		$sql = "SELECT * FROM tipo_sangre";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function selectDepartamentoMunicipioActivo($documento)
	{
		global $mbd;
		$sql = "SELECT * FROM credencial_estudiante INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial WHERE credencial_estudiante.credencial_identificacion = :documento";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento", $documento);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}

	public function selectDepartamento()
	{
		$sql = "SELECT * FROM departamentos";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function selectDepartamentoDos($departamento)
	{
		$sql = "SELECT * FROM departamentos WHERE departamento= :departamento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":departamento", $departamento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function selectMunicipio($departamento)
	{
		$sql_buscar = "SELECT municipios.municipio FROM departamentos INNER JOIN municipios ON departamentos.id_departamento = municipios.departamento_id WHERE departamentos.departamento = :departamento;";
		global $mbd;
		$consulta_buscar = $mbd->prepare($sql_buscar);
		$consulta_buscar->bindParam(':departamento', $departamento);
		$consulta_buscar->execute();
		$resultado_buscar = $consulta_buscar->fetchall(PDO::FETCH_ASSOC);
		return $resultado_buscar;
	}



	public function EditarEgresado(
		$credencial_nombre,
		$credencial_nombre_2,
		$credencial_apellido,
		$credencial_apellido_2,
		$genero,
		$fecha_nacimiento,
		$departamento_nacimiento,
		$lugar_nacimiento,
		$credencial_identificacion,
		$direccion,
		$barrio,
		$telefono,
		$celular,
		$tipo_sangre,
		$email,
		$grupo_etnico,
		$nombre_etnico,
		$instagram,
		$id_credencial
	) {
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE credencial_estudiante AS uno INNER JOIN estudiantes_datos_personales AS dos ON uno.id_credencial = dos.id_credencial SET uno.credencial_nombre = :credencial_nombre, uno.credencial_nombre_2 = :credencial_nombre_2, uno.credencial_apellido = :credencial_apellido, uno.credencial_apellido_2 = :credencial_apellido_2, dos.genero = :genero, dos.fecha_nacimiento = :fecha_nacimiento, dos.departamento_nacimiento = :departamento_nacimiento, dos.lugar_nacimiento = :lugar_nacimiento,  uno.credencial_identificacion = :credencial_identificacion,dos.direccion = :direccion, dos.barrio = :barrio, dos.telefono = :telefono, dos.celular = :celular, dos.tipo_sangre = :tipo_sangre,  dos.email = :email, dos.grupo_etnico = :grupo_etnico, dos.nombre_etnico = :nombre_etnico,dos.instagram = :instagram WHERE uno.id_credencial = :id_credencial");
		// echo $sentencia;
		$sentencia->bindParam(":credencial_nombre", $credencial_nombre);
		$sentencia->bindParam(":credencial_nombre_2", $credencial_nombre_2);
		$sentencia->bindParam(":credencial_apellido", $credencial_apellido);
		$sentencia->bindParam(":credencial_apellido_2", $credencial_apellido_2);
		$sentencia->bindParam(":genero", $genero);
		$sentencia->bindParam(":fecha_nacimiento", $fecha_nacimiento);
		$sentencia->bindParam(":departamento_nacimiento", $departamento_nacimiento);
		$sentencia->bindParam(":lugar_nacimiento", $lugar_nacimiento);
		$sentencia->bindParam(":credencial_identificacion", $credencial_identificacion);
		$sentencia->bindParam(":direccion", $direccion);
		$sentencia->bindParam(":barrio", $barrio);
		$sentencia->bindParam(":telefono", $telefono);
		$sentencia->bindParam(":celular", $celular);
		$sentencia->bindParam(":tipo_sangre", $tipo_sangre);
		$sentencia->bindParam(":email", $email);
		$sentencia->bindParam(":grupo_etnico", $grupo_etnico);
		$sentencia->bindParam(":nombre_etnico", $nombre_etnico);
		$sentencia->bindParam(":instagram", $instagram);
		$sentencia->bindParam(":id_credencial", $id_credencial);
		if ($sentencia->execute()) {
			$data['status'] = "ok";
			$_SESSION['status_update'] = 1;
		} else {
			$data['status'] = "Error al actualizar los datos personales.";
		}
		echo json_encode($data);
	}

	public function aceptoData($id_credencial)
	{
		$sql = "SELECT * FROM egresados_caracterizacion WHERE id_credencial = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function insertardata($id_credencial, $aceptodata, $fechaaceptodata)
	{
		$sql = "INSERT INTO egresados_caracterizacion (id_credencial, aceptodata, fechaaceptodata)
            VALUES (:id_credencial, :aceptodata, :fechaaceptodata)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":aceptodata", $aceptodata);
		$consulta->bindParam(":fechaaceptodata", $fechaaceptodata);
		return $consulta->execute();
	}


	public function listar($id_credencial)
	{
		$sql = "SELECT * FROM egresados_caracterizacion WHERE id_credencial = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function datosestudiante_C($id_credencial)
	{
		$sql = "SELECT * FROM estudiantes est 
            INNER JOIN credencial_estudiante ce ON est.id_credencial = ce.id_credencial 
            INNER JOIN estudiantes_datos_personales edp ON est.id_credencial = edp.id_credencial 
            WHERE est.id_credencial = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial, PDO::PARAM_INT);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



	public function programasnivel3_C()
	{
		$sql = "SELECT 
    estudiantes.*,
    credencial_estudiante.*,
    estudiantes_datos_personales.*,
    graduados.folio,
    egresados_caracterizacion.egresados_tiene_hijos,
    egresados_caracterizacion.egresados_num_hijos,
    egresados_caracterizacion.egresados_trabaja,
    egresados_caracterizacion.egresados_tipo_trabajador,
    egresados_caracterizacion.egresados_empresa,
    egresados_caracterizacion.egresados_sector_empresa,
    egresados_caracterizacion.egresados_cargo,
    egresados_caracterizacion.egresados_profesion,
    egresados_caracterizacion.egresados_salario,
    egresados_caracterizacion.egresados_estudio_adicional,
    egresados_caracterizacion.egresados_formacion,
    egresados_caracterizacion.egresados_tipo_formacion,
    egresados_caracterizacion.egresados_informacion,
    egresados_caracterizacion.egresados_posgrado,
    egresados_caracterizacion.egresados_colaborativa,
    egresados_caracterizacion.egresados_actualizacion,
    egresados_caracterizacion.egresados_recomendar 
FROM 
    graduados 
INNER JOIN 
    credencial_estudiante ON credencial_estudiante.id_credencial = graduados.id_credencial
INNER JOIN 
    estudiantes_datos_personales ON estudiantes_datos_personales.id_credencial = graduados.id_credencial
INNER JOIN 
    estudiantes ON estudiantes.id_estudiante = graduados.id_estudiante
INNER JOIN 
    egresados_caracterizacion ON estudiantes.id_credencial = egresados_caracterizacion.id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}



	public function editarCaracter($id_credencial, $egresados_tiene_hijos, $egresados_num_hijos, $egresados_trabaja, $egresados_tipo_trabajador, $egresados_empresa, $egresados_sector_empresa, $egresados_cargo, $egresados_profesion, $egresados_salario, $egresados_estudio_adicional, $egresados_formacion, $egresados_tipo_formacion, $egresados_informacion, $egresados_posgrado, $egresados_colaborativa, $egresados_actualizacion, $egresados_recomendar, $fecha)
	{
		$sql = "UPDATE egresados_caracterizacion SET egresados_tiene_hijos = '$egresados_tiene_hijos',egresados_num_hijos = '$egresados_num_hijos', egresados_trabaja = '$egresados_trabaja', egresados_tipo_trabajador = '$egresados_tipo_trabajador', egresados_empresa = '$egresados_empresa', egresados_sector_empresa = '$egresados_sector_empresa', egresados_cargo = '$egresados_cargo', egresados_profesion = '$egresados_profesion', egresados_salario = '$egresados_salario', egresados_estudio_adicional = '$egresados_estudio_adicional', egresados_formacion = '$egresados_formacion', egresados_tipo_formacion = '$egresados_tipo_formacion', egresados_informacion = '$egresados_informacion', egresados_posgrado = '$egresados_posgrado', egresados_colaborativa = '$egresados_colaborativa', egresados_actualizacion = '$egresados_actualizacion', egresados_recomendar = '$egresados_recomendar', egresados_update = '$fecha' WHERE id_credencial = $id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":id_credencial", $id_credencial);
		// $consulta->bindParam(":egresados_tiene_hijos", $egresados_tiene_hijos);
		// $consulta->bindParam(":egresados_num_hijos", $egresados_num_hijos);
		// $consulta->bindParam(":egresados_trabaja", $egresados_trabaja);
		// $consulta->bindParam(":egresados_tipo_trabajador", $egresados_tipo_trabajador);
		// $consulta->bindParam(":egresados_empresa", $egresados_empresa);
		// $consulta->bindParam(":egresados_sector_empresa", $egresados_sector_empresa);
		// $consulta->bindParam(":egresados_cargo", $egresados_cargo);
		// $consulta->bindParam(":egresados_profesion", $egresados_profesion);
		// $consulta->bindParam(":egresados_salario", $egresados_salario);
		// $consulta->bindParam(":egresados_estudio_adicional", $egresados_estudio_adicional);
		// $consulta->bindParam(":egresados_formacion", $egresados_formacion);
		// $consulta->bindParam(":egresados_tipo_formacion", $egresados_tipo_formacion);
		// $consulta->bindParam(":egresados_informacion", $egresados_informacion);
		// $consulta->bindParam(":egresados_posgrado", $egresados_posgrado);
		// $consulta->bindParam(":egresados_colaborativa", $egresados_colaborativa);
		// $consulta->bindParam(":egresados_actualizacion", $egresados_actualizacion);
		// $consulta->bindParam(":egresados_recomendar", $egresados_recomendar);
		// $consulta->bindParam(":fecha", $fecha);
		return $consulta->execute();
	}

	public function listarPorProgramasTerminalContar()
{
    global $mbd;
    $sql = "SELECT credencial_estudiante.id_credencial,credencial_estudiante.credencial_nombre, credencial_estudiante.credencial_nombre_2, credencial_estudiante.credencial_apellido, credencial_estudiante.credencial_apellido_2, credencial_estudiante.credencial_identificacion, graduados.pruebas_saber_pro,  estudiantes_datos_personales.email, estudiantes_datos_personales.celular, graduados.acta_grado, graduados.folio, graduados.fecha_grado,graduados.periodo_grado, credencial_estudiante.credencial_login, estudiantes.fo_programa,estudiantes.periodo,jornada_e,estado,ciclo,periodo_activo
			FROM graduados INNER JOIN credencial_estudiante ON credencial_estudiante.id_credencial = graduados.id_credencial INNER JOIN estudiantes_datos_personales ON estudiantes_datos_personales.id_credencial = graduados.id_credencial INNER JOIN estudiantes ON estudiantes.id_estudiante = graduados.id_estudiante";
    $consulta = $mbd->prepare($sql);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

}
