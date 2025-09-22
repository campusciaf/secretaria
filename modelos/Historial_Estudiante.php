<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Historial_Estudiante
{
	//Implementamos nuestro constructor
	public function __construct() {}

	//Implementar un método para listar los registros
	public function verificardocumento($credencial_identificacion)
	{
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `credencial_identificacion` = :credencial_identificacion";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function listar($id_credencial)
	{
		$sql = "SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial";
		// echo $sql;
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para traer el nombre del estado
	public function listarEstado($id_estado_academico)
	{
		$sql = "SELECT * FROM estado_academico WHERE id_estado_academico= :id_estado_academico ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado_academico", $id_estado_academico);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function cedula_estudiante($id_credencial)
	{
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial";
		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar los datos de un registro a modificar

	public function sofipersona($id_credencial)
	{
		$sql = "SELECT id_persona, id_credencial 
				FROM `sofi_persona` 
				WHERE `id_credencial` = :id_credencial 
				ORDER BY id_persona DESC 
				LIMIT 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function id_estudiante_datos($id_credencial)
	{
		$sql = "SELECT * FROM `estudiantes_datos_personales` WHERE `id_credencial` = :id_credencial";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function id_estudiante_oncenter($identificacion)
	{
		$sql = "SELECT * FROM `on_interesados` WHERE `identificacion` = :identificacion";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":identificacion", $identificacion);
		$consulta->execute();

		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function soporte_inscripcion($id_estudiante)
	{
		$sql = "SELECT * FROM `on_soporte_inscripcion` WHERE `id_estudiante` = :id_estudiante";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function entrevista($id_estudiante)
	{
		$sql = "SELECT * FROM `on_entrevista` WHERE `id_estudiante` = :id_estudiante";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrardatos($id_credencial)
	{
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa)
	{
		$sql = "SELECT * FROM `programa_ac` WHERE `id_programa` = :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos del programa del estudiante
	public function datosEstudiante($id_estudiante)
	{
		$sql = "SELECT * FROM `estudiantes` WHERE `id_estudiante` = :id_estudiante";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarMaterias($id_estudiante, $ciclo, $semestre)
	{

		$sql = "SELECT * FROM $ciclo WHERE id_estudiante= :id_estudiante and semestre= :semestre";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function traerCodigoMateria($nombre_materia)
	{

		$sql = "SELECT id AS id_materia FROM materias_ciafi WHERE nombre = :nombre_materia";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC)["id_materia"];
		return $resultado;
	}
	
	public function valorhuella()
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT * FROM `valor_huella` ");
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function verEntrevista($id_estudiante)
	{
		$sql = "SELECT * FROM on_entrevista WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar los ingresos e los estudiantes
	public function consulta_por_mes_2($id_usuario, $fecha)
	{
		$sql = "SELECT count(id_usuario) as total_ingreso, `fecha` as fecha FROM `ingresos_campus` WHERE `id_usuario` LIKE :id_usuario AND `fecha` LIKE '%$fecha%' GROUP BY `fecha`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function caso_por_estudiante($credencial_identificacion)
	{
		// SELECT `credencial_estudiante`.`credencial_identificacion`, `casos`.`caso_id`, `casos`.`caso_asunto`, `casos`.`created_at`, `casos`.`area_id`, `casos`.`cerrado_por` FROM `casos` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `casos`.`id_estudiante` WHERE casos.caso_id = 146 ORDER BY `casos`.`created_at` DESC
		$sql = "SELECT * FROM `casos` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `casos`.`id_estudiante` WHERE `credencial_estudiante`.`credencial_identificacion` = :credencial_identificacion";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function verAyuda($id_credencial)
	{
		$sql = "SELECT * FROM ayuda ayd INNER JOIN credencial_estudiante ce ON ayd.id_credencial=ce.id_credencial WHERE ce.id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function buscarasunto($id_asunto)
	{
		$sql = "SELECT * FROM asunto WHERE id_asunto= :id_asunto";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_asunto", $id_asunto);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function buscaropcionasunto($id_asunto_opcion)
	{
		$sql = "SELECT * FROM asunto_opcion WHERE id_asunto_opcion = :id_asunto_opcion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_asunto_opcion", $id_asunto_opcion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
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
	public function listarRespuesta($id_ayuda)
	{
		$sql = "SELECT * FROM ayuda_respuesta WHERE id_ayuda='" . $id_ayuda . "'";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function datosDependencia($dependencia)
	{
		$sql = "SELECT * FROM usuario WHERE id_usuario='" . $dependencia . "'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para ver el soporte de la cédula
	public function soporteCedula($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_cedula WHERE id_estudiante= :id_estudiante";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para ver el soporte del diploma
	public function soporteDiploma($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_diploma WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para ver el soporte del diploma
	public function soporteActa($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_acta WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementamos un método para ver el soporte de salud
	public function soporteSalud($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_salud WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para ver el soporte pruebas
	public function soportePrueba($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_prueba WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para ver el soporte pruebas
	public function soporteCompromiso($id_estudiante)
	{
		$sql = "SELECT * FROM on_soporte_compromiso WHERE id_estudiante= :id_estudiante";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// consultas para ver los casos del estudiante

	public function caso($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT * FROM `casos` WHERE `caso_id` = :id ");

		$sentencia->bindParam(":id", $id);
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
	}
	public function seguimientos($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT seguimiento_contenido, seguimiento_tipo_encuentro, seguimiento_beneficio,created_at,docente,evidencia_seguimiento FROM `seguimientos` WHERE caso_id = :id ORDER BY `seguimientos`.`created_at` ASC ");
		// echo $sentencia;
		$sentencia->bindParam(":id", $id);
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}
	public function tareas($id_caso)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT tarea_asunto,tarea_contenido,tarea_fecha_ejecucion,created_at,docente FROM tareas WHERE caso_id = :id ORDER BY `tareas`.`created_at` ASC ");
		$sentencia->bindParam(":id", $id_caso);
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}
	public function remsiones($id_caso)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT remision_observacion,remision_para,remision_desde, remision_fecha as created_at FROM remisiones WHERE caso_id = :id ORDER BY `created_at` ASC ");
		$sentencia->bindParam(":id", $id_caso);
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}

	public function nombre_docente($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT CONCAT(usuario_nombre,' ',usuario_nombre_2,' ',usuario_apellido,' ',usuario_apellido_2) AS nombre FROM `docente` WHERE `id_usuario` = $id ");
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro['nombre'];
	}

	public function consulta_dependencia($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT `usuario_cargo`,`usuario_email` FROM `usuario` WHERE `id_usuario` = $id ");
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
	}
	public function periodo()
	{
		$sql = "SELECT * FROM periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function listarporestudiante($numero_documento)
	{
		$sql = "SELECT `sofi_persona`.`estado` AS estado_credito , `sofi_persona`.*, `sofi_matricula`.* FROM (`sofi_persona` INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) WHERE `numero_documento` = :numero_documento ORDER BY `sofi_matricula`.`periodo` DESC";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":numero_documento", $numero_documento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

		return $resultado;
	}

	public function listarCuotas($tipo_busqueda, $dato_busqueda)
	{
		global $mbd;
		$sql = "SELECT `sofi_persona`.`estado` AS estado_credito , `sofi_persona`.*, `sofi_matricula`.*
                FROM (`sofi_persona` 
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
		//condicion para listar los datos
		if ($tipo_busqueda == 1) {
			$condition = "WHERE `sofi_persona`.`numero_documento` = :dato_busqueda ORDER BY `sofi_matricula`.`periodo` DESC";
		} else if ($tipo_busqueda == 2) {
			$sql = "SELECT `sofi_persona`.`estado` AS estado_credito, `sofi_persona`.*, `sofi_financiamiento`.*, `sofi_matricula`.* 
                FROM ((`sofi_financiamiento` 
                INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`)
                INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`) ";
			$condition = "WHERE `sofi_financiamiento`.`id_matricula` = :dato_busqueda  ORDER BY `sofi_financiamiento`.`numero_cuota` ASC";
		} else {
			$dato_busqueda = "%" . $dato_busqueda . "%";
			$condition = "WHERE `sofi_persona`.`nombres` LIKE :dato_busqueda OR `sofi_persona`.`apellidos` LIKE :dato_busqueda ORDER BY `sofi_matricula`.`periodo` DESC";
		}
		$sql = $sql . $condition;
		// echo $sql;
		$sentencia = $mbd->prepare($sql);
		$sentencia->bindParam(":dato_busqueda", $dato_busqueda);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}

	//muestra total cuotas por CONSECUTIVO
	public function cuotasTotales($consecutivo)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT COUNT(*) as `total` FROM `sofi_financiamiento` where id_matricula = :consecutivo");
		$sentencia->bindParam(':consecutivo', $consecutivo);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	//muestra a un solicitante especifico por CONSECUTIVO
	public function CuotasPagadas($consecutivo)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT COUNT(*) as `total` FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` = 'Pagado'");
		$sentencia->bindParam(':consecutivo', $consecutivo);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}

	public function formatoDinero($valor)
	{
		$moneda = array(2, ',', '.'); // Peso colombiano 
		return number_format($valor, $moneda[0], $moneda[1], $moneda[2]);
	}
	public function diferenciaFechas($inicial, $final, $formatoDiferencia = '%a')
	{
		$datetime1 = date_create($inicial);
		$datetime2 = date_create($final);
		$intervalo = date_diff($datetime1, $datetime2);
		return $intervalo->format($formatoDiferencia);
	}

	public function Pagos_Sofi_Estudiante($id_matricula)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT * FROM `sofi_financiamiento` WHERE `sofi_financiamiento`.`id_matricula` = :id_matricula ORDER BY `sofi_financiamiento`.`numero_cuota` ASC ");
		// echo $sentencia;
		$sentencia->bindParam(":id_matricula", $id_matricula);
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}


	public function verCasosTabla($id_credencial)
	{
		$sql = "SELECT * FROM ayuda ayd INNER JOIN credencial_estudiante ce ON ayd.id_credencial=ce.id_credencial WHERE ce.id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function datosCategoria()
	{
		$sql = "SELECT * FROM categoria";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}



	//lista los datos del estudiante para la caracterizacion
	public function listardatos($id_credencial)
	{
		$sql = "SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial WHERE ce.id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function datosVariablesContestadas($id_credencial, $id_categoria)
	{
		$sql = "SELECT * FROM caracterizacion WHERE id_usuario= :id_credencial and id_categoria= :id_categoria";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function datosVariables($id_variable)
	{
		$sql = "SELECT * FROM variables WHERE id_variable= :id_variable";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function respuesta($respuesta)
	{
		$sql = "SELECT * FROM variables_opciones WHERE id_variables_opciones= :respuesta";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



	public function listaDatos($id_credencial)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM credencial_estudiante INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial WHERE credencial_estudiante.id_credencial = :id_credencial");
		$sentencia->bindParam(":id_credencial", $id_credencial);
		$sentencia->execute();
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}

	//traer el numero de whatsapp estudiantes
	public function traerCelularEstudiante($numero_documento)
	{
		global $mbd;
		$hoy = date("Y-m-d");
		$sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
		$sentencia->bindParam(":numero_documento", $numero_documento);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}

	public function obtenerRegistroWhastapp($numero_celular)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `whatsapp_registros` WHERE `numero_whatsapp` LIKE :numero_celular ORDER BY `numero_whatsapp` ASC");
		$sentencia->bindParam(':numero_celular', $numero_celular);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}

	//cambia el estado de Ciafi
	public function cambiarEstadoCiafi($estado_ciafi, $consecutivo)
	{
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE `sofi_matricula`
				SET `estado_ciafi` = :estado_ciafi 
				WHERE `sofi_matricula`.`id` = :consecutivo");
		$sentencia->bindParam(':consecutivo', $consecutivo);
		$sentencia->bindParam(':estado_ciafi', $estado_ciafi);
		return $sentencia->execute();
	}

	//lista todos los financiados
	public function crearRegistro($consecutivo, $id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare("INSERT INTO `sofi_historial_bloqueos`(`consecutivo`,`estado`,`id_usuario`) VALUES(:consecutivo, 'Bloqueo', :id_usuario);");
		$sentencia->bindParam(":consecutivo", $consecutivo);
		$sentencia->bindParam(":id_usuario", $id_usuario);
		return $sentencia->execute();
	}

	public function listarestudiante($id_credencial)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial ");
		$sentencia->bindParam(':id_credencial', $id_credencial);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function listarfuncionario($usuario_cargo)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `usuario` WHERE `usuario_cargo` = :usuario_cargo ");
		$sentencia->bindParam(':usuario_cargo', $usuario_cargo);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function verificarseres($id_credencial)
	{
		$sql = "SELECT * FROM carseresoriginales WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificar($id_credencial)
	{
		$sql = "SELECT * FROM carinspiradores WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarempresas($id_credencial)
	{
		$sql = "SELECT * FROM carempresas WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarconfiamos($id_credencial)
	{
		$sql = "SELECT * FROM carconfiamos WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function verificarexp($id_credencial)
	{
		$sql = "SELECT * FROM carexperiencia WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function verificarbienestar($id_credencial)
	{
		$sql = "SELECT * FROM carbienestar WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function selectlistaranios()
	{
		$sql = "SELECT * FROM anios";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	// buscamos el estudiante por la cedula y filtramos el estado matriculado
	// public function buscar_id_estudiante($identificacion)
	// {
	// 	$sql = "SELECT * FROM on_interesados WHERE identificacion= :identificacion AND estado = 'Matriculado'";
	// 	// echo $sql;
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":identificacion", $identificacion);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
	// 	return $resultado;
	// }

	// // buscamos el id_estudiante para saber que porcentaje de probabilidad de desercion tiene
	// public function verEntrevistaprobabilidad($id_estudiante)
	// {
	// 	$sql = "SELECT * FROM on_entrevista WHERE id_estudiante= :id_estudiante";
	// 	// echo $sql;
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":id_estudiante", $id_estudiante);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
	// 	return $resultado;
	// }
	// dependiendo del porcenaje mostramos la barra del color.
	function getBarraProgreso($porcentaje)
	{
		if ($porcentaje === null || $porcentaje === '') {
			return '
            <div class="progress" style="height: 20px;">
                <div class="progress-bar bg-secondary" role="progressbar" style="width:100%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>';
		}

		$color = 'bg-success';
		if ($porcentaje >= 80) {
			$color = 'bg-danger';
		} elseif ($porcentaje >= 60) {
			$color = 'bg-warning';
		} elseif ($porcentaje >= 40) {
			$color = 'bg-info';
		}

		return '
        <div class="progress" style="height: 20px;">
            <div class="progress-bar ' . $color . '" role="progressbar" style="width: ' . $porcentaje . '%;" aria-valuenow="' . $porcentaje . '" aria-valuemin="0" aria-valuemax="100">
                ' . $porcentaje . '%
            </div>
        </div>';
	}

	 public function Listar_influencer_estudiante($id_credencial) {
    global $mbd;
    $sql = "SELECT ir.id_influencer_reporte,
                   ir.influencer_mensaje,
                   ir.influencer_nivel_accion,
                   ir.influencer_dimension,
				   ir.reporte_estado,
				   ir.area_responsable,
                   ir.fecha,
                   ir.hora,
                   ir.periodo,
                   d.usuario_nombre,
                   d.usuario_nombre_2,
                   d.usuario_apellido,
                   d.usuario_apellido_2
            FROM influencer_reporte ir
            INNER JOIN docente d ON ir.id_docente = d.id_usuario
            INNER JOIN estudiantes e ON ir.id_estudiante = e.id_estudiante
            INNER JOIN credencial_estudiante ce ON e.id_credencial = ce.id_credencial
            WHERE ce.id_credencial = :id_credencial
            ORDER BY ir.fecha DESC, ir.hora DESC";

    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_credencial", $id_credencial, PDO::PARAM_INT);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

function respuestasReporteInfluencer($id_influencer_reporte){
		global $mbd;
		$sql = "SELECT `ir`.`id_influencer_respuesta`, `u`.`usuario_nombre`, `u`.`usuario_apellido`, `ir`.`mensaje_respuesta`, `ir`.`created_dt` 
		FROM `influencer_respuesta` `ir` INNER JOIN `usuario` `u` ON `ir`.`id_usuario` = `u`.`id_usuario`
		WHERE `ir`.`id_influencer_reporte` = :id_influencer_reporte ORDER BY `ir`.`created_dt` ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_influencer_reporte", $id_influencer_reporte);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;	
	}

public function verFormularioEstudiante($id_estudiante)
	{
		$sql = "SELECT * FROM on_interesados WHERE id_estudiante= :id_estudiante";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para actualziar el perfil
	public function editarPerfil($id_estudiante, $fo_programa, $jornada_e, $tipo_documento, $nombre, $nombre_2, $apellidos, $apellidos_2, $celular, $email, $nivel_escolaridad, $nombre_colegio, $fecha_graduacion)
	{
		$sql = "UPDATE on_interesados oi INNER JOIN on_interesados_datos oid ON oi.id_estudiante=oid.id_estudiante SET oi.fo_programa= :fo_programa, oi.jornada_e= :jornada_e, oi.tipo_documento= :tipo_documento, oi.nombre= :nombre, oi.nombre_2= :nombre_2, oi.apellidos= :apellidos, oi.apellidos_2= :apellidos_2, oi.celular= :celular, oi.email= :email, oid.nivel_escolaridad= :nivel_escolaridad, oid.nombre_colegio= :nombre_colegio, oid.fecha_graduacion= :fecha_graduacion WHERE oi.id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->bindParam(":jornada_e", $jornada_e);
		$consulta->bindParam(":tipo_documento", $tipo_documento);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":nombre_2", $nombre_2);
		$consulta->bindParam(":apellidos", $apellidos);
		$consulta->bindParam(":apellidos_2", $apellidos_2);
		$consulta->bindParam(":celular", $celular);
		$consulta->bindParam(":email", $email);
		$consulta->bindParam(":nivel_escolaridad", $nivel_escolaridad);
		$consulta->bindParam(":nombre_colegio", $nombre_colegio);
		$consulta->bindParam(":fecha_graduacion", $fecha_graduacion);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}

		public function selectPrograma()
	{
		$sql = "SELECT * FROM on_programa WHERE estado=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los jornadas en un select
	public function selectJornada()
	{
		$sql = "SELECT * FROM on_jornadas";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los tipo de documentos en un select
	public function selectTipoDocumento()
	{
		$sql = "SELECT * FROM on_tipo_documento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar niveles e escolaridad
	public function selectNivelEscolaridad()
	{
		$sql = "SELECT * FROM on_nivel_escolaridad";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function perfilEstudiante($id_estudiante)
	{
		$sql = "SELECT * FROM on_interesados oi INNER JOIN on_interesados_datos oin ON oi.id_estudiante=oin.id_estudiante WHERE oi.id_estudiante= :id_estudiante";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
