<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class ConsultaEgresado
{
	//Implementamos nuestro constructor
	public function __construct() {}


	//Consulta para mostrar solo los programas de nivel 3
	// public function programasnivel3()
	// {

	// 	$sql="SELECT * FROM `estudiantes` INNER JOIN `credencial_estudiante` ON `estudiantes`.id_credencial = `credencial_estudiante`.id_credencial INNER JOIN `estudiantes_datos_personales` ON `credencial_estudiante`.id_credencial = `estudiantes_datos_personales`.id_credencial WHERE `fo_programa` LIKE '%Nivel 3%'";
	// 	// echo $periodo;
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	// $consulta->bindParam(":periodo", $periodo);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
	// 	return $resultado;
	// }


	public function datosestudiante($id_credencial)
	{

		$sql = "SELECT*FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial = ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial = edp.id_credencial WHERE est.id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function programasnivel3()
	{
		$sql = "SELECT estudiantes.*, credencial_estudiante.*, estudiantes_datos_personales.*, graduados.folio
				FROM estudiantes
				INNER JOIN credencial_estudiante ON estudiantes.id_credencial = credencial_estudiante.id_credencial
				INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial
				LEFT JOIN graduados ON estudiantes.id_estudiante = graduados.id_estudiante
				WHERE estudiantes.ciclo='3' and (estudiantes.estado='2' or estudiantes.estado='5')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
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


	//Implementamos un método para insertar un mensaje
	public function insertarmensaje($numero_celular, $mensaje, $fecha, $hora, $id_usuario)
	{
		$sql = "INSERT INTO `egresados_mensaje`(`numero_celular`, `mensaje`, `fecha`, `hora`, `id_usuario`)
		VALUES ('$numero_celular','$mensaje','$fecha','$hora','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementar un método para traer el id del estudiante cuando se crea una credencial
	public function tienefolio($id_estudiante)
	{
		$sql = "SELECT * FROM graduados WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}





	public function mostrar_egresado($id_estudiante)
	{
		$sql = "SELECT * FROM estudiantes est 
            INNER JOIN credencial_estudiante ce ON est.id_credencial = ce.id_credencial 
            INNER JOIN estudiantes_datos_personales edp ON est.id_credencial = edp.id_credencial 
            WHERE est.id_estudiante = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
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
		$sentencia = $mbd->prepare("UPDATE credencial_estudiante AS uno INNER JOIN estudiantes_datos_personales AS dos ON uno.id_credencial = dos.id_credencial SET uno.credencial_nombre = :credencial_nombre, uno.credencial_nombre_2 = :credencial_nombre_2, uno.credencial_apellido = :credencial_apellido, uno.credencial_apellido_2 = :credencial_apellido_2, dos.genero = :genero, dos.fecha_nacimiento = :fecha_nacimiento, dos.departamento_nacimiento = :departamento_nacimiento, dos.lugar_nacimiento = :lugar_nacimiento, uno.credencial_identificacion = :credencial_identificacion, dos.direccion = :direccion, dos.barrio = :barrio, dos.telefono = :telefono, dos.celular = :celular, dos.tipo_sangre = :tipo_sangre, dos.email = :email, dos.grupo_etnico = :grupo_etnico, dos.nombre_etnico = :nombre_etnico, dos.instagram = :instagram WHERE uno.id_credencial = :id_credencial");

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

		$data = array();
		if ($sentencia->execute()) {
			$data['status'] = "ok";
			$data['message'] = "Datos Actualizados";
		} else {
			$data['status'] = "error";
			$data['message'] = "Error al actualizar los datos personales.";
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
		$sql = "INSERT INTO egresados_caracterizacion (id_credencial, acepta_terminos, fecha_acepto_data)
            VALUES (:id_credencial, :aceptodata, :fechaaceptodata)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":aceptodata", $aceptodata);
		$consulta->bindParam(":fechaaceptodata", $fechaaceptodata);
		return $consulta->execute();
	}

public function editarCaracter(
	$id_credencial,
	$vida_graduado,
	$significado_egresado,
	$familiares_estudian_ciaf,
	$tiene_hijos,
	$situacion_laboral,
	$relacion_campo_estudio,
	$aporte_ciaf,
	$preparacion_laboral,
	$tipo_emprendimiento,
	$tipo_emprendimiento_otro,
	$ingreso_mensual,
	$estado_posgrado,
	$capacitaciones_complementarias,
	$capacitaciones_otro,
	$habilidades_utiles,
	$habilidades_otro,
	$sugerencias_plan_estudio,
	$sugerencias_otro,
	$satisfaccion_formacion,
	$formas_conexion,
	$formas_conexion_otro,
	$servicios_utiles,
	$servicios_utiles_otro,
	$disposicion_participar,
	$canal_contacto_preferido,
	$recomendaria_ciaf,
	$celular,
	$correo,
	$red_social_activa,
	$nombre_red_social,
	$usuario_red_social,
	$grupo_etnicos,
	$grupo_etnico_otro,
	$tiene_discapacidad,
	$descripcion_discapacidad,
	$primer_profesional,
	$estrato_socioeconomico,
	$fecha
) {
	global $mbd;

	$sql = "UPDATE egresados_caracterizacion SET
		vida_graduado = :vida_graduado,
		significado_egresado = :significado_egresado,
		familiares_estudian_ciaf = :familiares_estudian_ciaf,
		tiene_hijos = :tiene_hijos,
		situacion_laboral = :situacion_laboral,
		relacion_campo_estudio = :relacion_campo_estudio,
		aporte_ciaf = :aporte_ciaf,
		preparacion_laboral = :preparacion_laboral,
		tipo_emprendimiento = :tipo_emprendimiento,
		tipo_emprendimiento_otro = :tipo_emprendimiento_otro,
		ingreso_mensual = :ingreso_mensual,
		estado_posgrado = :estado_posgrado,
		capacitaciones_complementarias = :capacitaciones_complementarias,
		capacitaciones_otro = :capacitaciones_otro,
		habilidades_utiles = :habilidades_utiles,
		habilidades_otro = :habilidades_otro,
		sugerencias_plan_estudio = :sugerencias_plan_estudio,
		sugerencias_otro = :sugerencias_otro,
		satisfaccion_formacion = :satisfaccion_formacion,
		formas_conexion = :formas_conexion,
		formas_conexion_otro = :formas_conexion_otro,
		servicios_utiles = :servicios_utiles,
		servicios_utiles_otro = :servicios_utiles_otro,
		disposicion_participar = :disposicion_participar,
		canal_contacto_preferido = :canal_contacto_preferido,
		recomendaria_ciaf = :recomendaria_ciaf,
		celular = :celular,
		correo= :correo,
		red_social_activa = :red_social_activa,
		nombre_red_social = :nombre_red_social,
		usuario_red_social = :usuario_red_social,
		grupo_etnicos = :grupo_etnicos,
		grupo_etnico_otro = :grupo_etnico_otro,
		tiene_discapacidad = :tiene_discapacidad,
		descripcion_discapacidad = :descripcion_discapacidad,
		primer_profesional = :primer_profesional,
		estrato_socioeconomico = :estrato_socioeconomico,
		fecha_actualizacion = :fecha
	WHERE id_credencial = :id_credencial";

	$consulta = $mbd->prepare($sql);

	$consulta->bindParam(':id_credencial', $id_credencial);
	$consulta->bindParam(':vida_graduado', $vida_graduado);
	$consulta->bindParam(':significado_egresado', $significado_egresado);
	$consulta->bindParam(':familiares_estudian_ciaf', $familiares_estudian_ciaf);
	$consulta->bindParam(':tiene_hijos', $tiene_hijos);
	$consulta->bindParam(':situacion_laboral', $situacion_laboral);
	$consulta->bindParam(':relacion_campo_estudio', $relacion_campo_estudio);
	$consulta->bindParam(':aporte_ciaf', $aporte_ciaf);
	$consulta->bindParam(':preparacion_laboral', $preparacion_laboral);
	$consulta->bindParam(':tipo_emprendimiento', $tipo_emprendimiento);
	$consulta->bindParam(':tipo_emprendimiento_otro', $tipo_emprendimiento_otro);
	$consulta->bindParam(':ingreso_mensual', $ingreso_mensual);
	$consulta->bindParam(':estado_posgrado', $estado_posgrado);
	$consulta->bindParam(':capacitaciones_complementarias', $capacitaciones_complementarias);
	$consulta->bindParam(':capacitaciones_otro', $capacitaciones_otro);
	$consulta->bindParam(':habilidades_utiles', $habilidades_utiles);
	$consulta->bindParam(':habilidades_otro', $habilidades_otro);
	$consulta->bindParam(':sugerencias_plan_estudio', $sugerencias_plan_estudio);
	$consulta->bindParam(':sugerencias_otro', $sugerencias_otro);
	$consulta->bindParam(':satisfaccion_formacion', $satisfaccion_formacion);
	$consulta->bindParam(':formas_conexion', $formas_conexion);
	$consulta->bindParam(':formas_conexion_otro', $formas_conexion_otro);
	$consulta->bindParam(':servicios_utiles', $servicios_utiles);
	$consulta->bindParam(':servicios_utiles_otro', $servicios_utiles_otro);
	$consulta->bindParam(':disposicion_participar', $disposicion_participar);
	$consulta->bindParam(':canal_contacto_preferido', $canal_contacto_preferido);
	$consulta->bindParam(':recomendaria_ciaf', $recomendaria_ciaf);
	$consulta->bindParam(':celular', $celular);
	$consulta->bindParam(':correo', $correo);
	$consulta->bindParam(':red_social_activa', $red_social_activa);
	$consulta->bindParam(':nombre_red_social', $nombre_red_social);
	$consulta->bindParam(':usuario_red_social', $usuario_red_social);
	$consulta->bindParam(':grupo_etnicos', $grupo_etnicos);
	$consulta->bindParam(':grupo_etnico_otro', $grupo_etnico_otro);
	$consulta->bindParam(':tiene_discapacidad', $tiene_discapacidad);
	$consulta->bindParam(':descripcion_discapacidad', $descripcion_discapacidad);
	$consulta->bindParam(':primer_profesional', $primer_profesional);
	$consulta->bindParam(':estrato_socioeconomico', $estrato_socioeconomico);
	$consulta->bindParam(':fecha', $fecha);

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



	public function datosestudiante_C($id_estudiante)
	{

		$sql = "SELECT*FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial = ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial = edp.id_credencial WHERE est.id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function programasnivel3_C1()
	{
		$sql = "SELECT  estudiantes.*,  credencial_estudiante.*,  estudiantes_datos_personales.*,  graduados.folio,egresados_caracterizacion.tiene_hijos,egresados_caracterizacion.egresados_trabaja,egresados_caracterizacion.egresados_tipo_trabajador,egresados_caracterizacion.egresados_empresa,egresados_caracterizacion.egresados_sector_empresa,
    egresados_caracterizacion.egresados_cargo,egresados_caracterizacion.egresados_profesion,
    egresados_caracterizacion.egresados_salario,egresados_caracterizacion.egresados_estudio_adicional,egresados_caracterizacion.egresados_formacion,egresados_caracterizacion.egresados_tipo_formacion,
    egresados_caracterizacion.egresados_informacion,egresados_caracterizacion.egresados_posgrado,egresados_caracterizacion.egresados_colaborativa,egresados_caracterizacion.egresados_actualizacion, egresados_caracterizacion.egresados_recomendar FROM  estudiantes INNER JOIN  credencial_estudiante  ON estudiantes.id_credencial = credencial_estudiante.id_credencial
INNER JOIN  estudiantes_datos_personales  ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial
LEFT JOIN  graduados  ON estudiantes.id_estudiante = graduados.id_estudiante LEFT JOIN  egresados_caracterizacion  ON estudiantes.id_credencial = egresados_caracterizacion.id_credencial WHERE estudiantes.fo_programa LIKE '%Nivel 3%'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function trercaracterizacion()
	// {	$sql = "SELECT * FROM egresados_caracterizacion";
	{	$sql = "SELECT 
				ec.*, 
				ce.credencial_identificacion AS cedula,
				CONCAT(ce.credencial_nombre, ' ', ce.credencial_nombre_2, ' ', ce.credencial_apellido, ' ', ce.credencial_apellido_2) AS nombre,
				ce.credencial_login AS correo_ciaf
			FROM egresados_caracterizacion ec
			INNER JOIN credencial_estudiante ce ON ec.id_credencial = ce.id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	function traducirBinario($valor) {// respuesta si o no
		return $valor == "1" ? "Sí" : ($valor == "0" ? "No" : "N/A");
	}

	function traducirArreglo($valores, $opciones) {// respuesta mutiple
		$ids = explode(",", $valores);
		$nombres = array_map(function($id) use ($opciones) {
			return $opciones[trim($id)] ?? "Otro ($id)";
		}, $ids);
		return implode(", ", $nombres);
	}

	function traducirUnico($valor, $opciones) {// select on unica opcion
		return $opciones[$valor] ?? "Otro ($valor)";
	}




	public function listarporprogramaterminal($programa)
	{
		$sql = "SELECT estudiantes.*, credencial_estudiante.*, estudiantes_datos_personales.*, graduados.folio FROM estudiantes INNER JOIN credencial_estudiante ON estudiantes.id_credencial = credencial_estudiante.id_credencial INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial LEFT JOIN graduados ON estudiantes.id_estudiante = graduados.id_estudiante WHERE estudiantes.ciclo = '3'  AND (estudiantes.estado = '2' OR estudiantes.estado = '5') AND estudiantes.fo_programa LIKE :programa";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute([':programa' => "%$programa%"]);
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function listarPorProgramasTerminalContar()
	{
		global $mbd;
		$sql = "SELECT estudiantes.*, credencial_estudiante.*, estudiantes_datos_personales.*, graduados.folio FROM estudiantes INNER JOIN credencial_estudiante ON estudiantes.id_credencial = credencial_estudiante.id_credencial INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial LEFT JOIN graduados ON estudiantes.id_estudiante = graduados.id_estudiante WHERE estudiantes.ciclo = '3' AND (estudiantes.estado = '2' OR estudiantes.estado = '5') AND (estudiantes.fo_programa LIKE '%Administración%' OR estudiantes.fo_programa LIKE '%CONTADURIA%' OR estudiantes.fo_programa LIKE '%Nivel 3 - Profesional en Seguridad y Salud en el Trabajo%' OR estudiantes.fo_programa LIKE '%Software%' OR estudiantes.fo_programa LIKE '%Industrial%')";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
