<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/egresadoPerfil.php";
require "../mail/send.php";
require "../mail/template_rifa.php";

$conectar = new EgresadoPerfil();
$id_credencial = $_SESSION['id_usuario'];
$periodo_actual = $_SESSION['periodo_actual'];

$fecha = date('Y-m-d');
$hora = date('H:i:s');
switch ($_GET["op"]) {

	case 'aceptoData':

		$verificaregresado = $conectar->verificarEgresado($id_credencial);

		if (!empty($verificaregresado)) {
			$datos_acepto = $conectar->aceptoData($id_credencial);
			echo json_encode($datos_acepto ? 1 : 2);
		} else {
			// No es egresado
			echo json_encode($datos_acepto=3);
		}

		
    break;

    case 'guardardata':

		$data = array();
		$data["estado"] = "";

		$aceptodata = 1;
		$rspta = $conectar->insertardata($id_credencial, $aceptodata, $fecha);
		$datos = $rspta ? "si" : "no";

		$data["credencial"] = $id_credencial;

		$data["estado"] = $datos;
		echo json_encode($data);
    break;

    case 'listarPreguntas':

		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$pre = $conectar->listar($id_credencial);
		$data["0"] .= '';
		$data["0"] .= '<div class="row">';



		$data["0"] .= '

		<div class="row">

			<!-- id_credencial (oculto) -->
			<input type="hidden" name="id_credencial_estudiante" id="id_credencial_estudiante" value="'.htmlspecialchars($pre["id_credencial"] ?? "", ENT_QUOTES).'">

			<!-- vida_graduado -->
			<div class="col-12">
				<div class="form-group mb-3">
					<label for="vida_graduado" class="form-label">¿Qué ha pasado en tu vida desde que te graduaste?</label>
					<textarea class="form-control" name="vida_graduado" id="vida_graduado" rows="3" required>'.htmlspecialchars($pre["vida_graduado"] ?? "", ENT_QUOTES).'</textarea>
				</div>
			</div>

			<!-- significado_egresado -->
			<div class="col-xl-6 col-lg-4 col-md-6 col-12">
			<label for="significado_egresado">¿Qué significa ser egresado de CIAF?</label>
				<div class="form-group mb-3">
					<div class="form-floating">
						<input type="text" class="form-control" name="significado_egresado" id="significado_egresado" value="'.htmlspecialchars($pre["significado_egresado"] ?? "", ENT_QUOTES).'" required>
					</div>
				</div>
			</div>

			<!-- familiares_estudian_ciaf -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<div class="form-group mb-3">
			<label for="familiares_estudian_ciaf">¿Tienes familiares o personas cercanas que actualmente estudian en CIAF</label>
			<div class="form-floating">
						<select class="form-control" name="familiares_estudian_ciaf" id="familiares_estudian_ciaf">
							<option value="0" '.(($pre["familiares_estudian_ciaf"] ?? "") == "0" ? "selected" : "").'>No</option>
							<option value="1" '.(($pre["familiares_estudian_ciaf"] ?? "") == "1" ? "selected" : "").'>Sí</option>
						</select>
						
					</div>
				</div>
			</div>

			<!-- tiene_hijos -->
			<div class="col-xl-2 col-lg-4 col-md-6 col-12">
				<div class="form-group mb-3">
				<label for="tiene_hijos">¿Tienes hijos?</label>
					<div class="form-floating">
						<select class="form-control" name="tiene_hijos" id="tiene_hijos" required>
							<option value="0" '.(($pre["tiene_hijos"] ?? "") == "0" ? "selected" : "").'>No</option>
							<option value="1" '.(($pre["tiene_hijos"] ?? "") == "1" ? "selected" : "").'>Sí</option>
						</select>
					</div>
				</div>
			</div>


			<!-- situacion_laboral -->
			<div class="col-xl-4 col-lg-4 col-md-6 col-12">
				<div class="form-group mb-3">
				<label for="situacion_laboral">¿Cuál es tu situación laboral actual?</label>
					<div class="form-floating">
						<select class="form-control" name="situacion_laboral" id="situacion_laboral" required>
						<option value="1" '.(($pre["situacion_laboral"] ?? "") == "1" ? "selected" : "").'>Empleado a tiempo completo</option>
						<option value="2" '.(($pre["situacion_laboral"] ?? "") == "2" ? "selected" : "").'>Empleado a tiempo parcial</option>
						<option value="3" '.(($pre["situacion_laboral"] ?? "") == "3" ? "selected" : "").'>Emprendedor</option>
						<option value="4" '.(($pre["situacion_laboral"] ?? "") == "4" ? "selected" : "").'>Desempleado buscando empleo</option>
						<option value="5" '.(($pre["situacion_laboral"] ?? "") == "5" ? "selected" : "").'>Desempleado no buscando empleo</option>
						<option value="6" '.(($pre["situacion_laboral"] ?? "") == "6" ? "selected" : "").'>Estudiando</option>
						<option value="7" '.(($pre["situacion_laboral"] ?? "") == "7" ? "selected" : "").'>Voluntario</option>
					</select>
					</div>
				</div>
			</div>
			<!-- nombre de la empresa -->
			<div class="col-xl-6 col-lg-4 col-md-6 col-12">
			<label for="nombre_empresa">Nombre de la empresa en la que labora (si no labora, coloque "no aplica").</label>
				<div class="form-group mb-3">
					<div class="form-floating">
						<input type="text" class="form-control" name="nombre_empresa" id="nombre_empresa" value="'.htmlspecialchars($pre["nombre_empresa"] ?? "", ENT_QUOTES).'" required>
					</div>
				</div>
			</div>
			<!-- relacion_campo_estudio -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
				<label for="relacion_campo_estudio">Si estás empleado, ¿tu puesto de trabajo está relacionado con tu campo de estudio?</label>
					<div class="form-floating">	
									
						<select class="form-control" name="relacion_campo_estudio" id="relacion_campo_estudio">
							<option value="1" '.(($pre["relacion_campo_estudio"] ?? "") == "1" ? "selected" : "").'>Directamente relacionado</option>
							<option value="2" '.(($pre["relacion_campo_estudio"] ?? "") == "2" ? "selected" : "").'>Parcialmente relacionado</option>
							<option value="3" '.(($pre["relacion_campo_estudio"] ?? "") == "3" ? "selected" : "").'>No relacionado</option>
							<option value="4" '.(($pre["relacion_campo_estudio"] ?? "") == "4" ? "selected" : "").'>No aplica</option>
						</select>
					</div>
				</div>
			</div>

			<!-- aporte_ciaf -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<label for="aporte_ciaf">¿Sientes que tu carrera en CIAF te ayudó a llegar hasta ahí?</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="aporte_ciaf" id="aporte_ciaf" required>
							<option value="1" '.(($pre["aporte_ciaf"] ?? "") == "1" ? "selected" : "").'>Poco</option>
							<option value="2" '.(($pre["aporte_ciaf"] ?? "") == "2" ? "selected" : "").'>Algo</option>
							<option value="3" '.(($pre["aporte_ciaf"] ?? "") == "3" ? "selected" : "").'>Mucho</option>
						</select>
					</div>
				</div>
			</div>

			<!-- preparacion_laboral -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
				<label for="preparacion_laboral">¿Consideras que la formación recibida en la universidad te preparó adecuadamente para el mercado laboral?</label>
					<div class="form-floating">	
						
						<select class="form-control" name="preparacion_laboral" id="preparacion_laboral" required>
							<option value="1" '.(($pre["preparacion_laboral"] ?? "") == "1" ? "selected" : "").'>No adecuadamente</option>
							<option value="2" '.(($pre["preparacion_laboral"] ?? "") == "2" ? "selected" : "").'>Parcialmente</option>
							<option value="3" '.(($pre["preparacion_laboral"] ?? "") == "3" ? "selected" : "").'>Sí, adecuadamente</option>
							<option value="4" '.(($pre["preparacion_laboral"] ?? "") == "4" ? "selected" : "").'>Sí, muy adecuadamente</option>
						</select>
					</div>
				</div>
			</div>


			<!-- tipo_emprendimiento -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<div class="form-group mb-3">
			<label for="tipo_emprendimiento">Si eres emprendedor, ¿qué tipo de empresa o proyecto has desarrollado?</label>
					<div class="form-floating">	
						
						<select class="form-control" name="tipo_emprendimiento" id="tipo_emprendimiento" required>
							<option value="1" '.(($pre["tipo_emprendimiento"] ?? "") == "1" ? "selected" : "").'>Servicios</option>
							<option value="2" '.(($pre["tipo_emprendimiento"] ?? "") == "2" ? "selected" : "").'>Productos</option>
							<option value="3" '.(($pre["tipo_emprendimiento"] ?? "") == "3" ? "selected" : "").'>Startup tecnológico</option>
							<option value="4" '.(($pre["tipo_emprendimiento"] ?? "") == "4" ? "selected" : "").'>Proyecto social/cultural</option>
							<option value="5" '.(($pre["tipo_emprendimiento"] ?? "") == "5" ? "selected" : "").'>Freelance</option>
							<option value="6" '.(($pre["tipo_emprendimiento"] ?? "") == "6" ? "selected" : "").'>Otro</option>
							<option value="7" '.(($pre["tipo_emprendimiento"] ?? "") == "7" ? "selected" : "").'>No aplica</option>
						</select>
					</div>
				</div>
			</div>

			<!-- tipo_emprendimiento_otro -->
			<div class="col-12" id="bloque_tipo_emprendimiento_otro" style="display:none">
			<label for="tipo_emprendimiento_otro">Otro tipo de emprendimiento (si aplica)</label>
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="tipo_emprendimiento_otro" id="tipo_emprendimiento_otro"
						value="'.htmlspecialchars($pre["tipo_emprendimiento_otro"] ?? "", ENT_QUOTES).'">
				</div>
			</div>

			<!-- ingreso_mensual -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
				<label for="ingreso_mensual">¿Cuál es tu rango de ingreso mensual aproximado?</label>
					<div class="form-floating">	
						
						<select class="form-control" name="ingreso_mensual" id="ingreso_mensual" required>
							<option value="1" '.(($pre["ingreso_mensual"] ?? "") == "1" ? "selected" : "").'>Menos de 1 SMMLV</option>
							<option value="2" '.(($pre["ingreso_mensual"] ?? "") == "2" ? "selected" : "").'>Entre 1 y 2 SMMLV</option>
							<option value="3" '.(($pre["ingreso_mensual"] ?? "") == "3" ? "selected" : "").'>Entre 2 y 3 SMMLV</option>
							<option value="4" '.(($pre["ingreso_mensual"] ?? "") == "4" ? "selected" : "").'>Más de 3 SMMLV</option>
							<option value="5" '.(($pre["ingreso_mensual"] ?? "") == "5" ? "selected" : "").'>Prefiero no responder</option>
						</select>
					</div>
				</div>
			</div>

			<!-- estado_posgrado -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<label for="estado_posgrado">¿Has realizado o tienes planes de realizar estudios de posgrado (especialización, maestría, doctorado)?</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="estado_posgrado" id="estado_posgrado" required>
							<option value="1" '.(($pre["estado_posgrado"] ?? "") == "1" ? "selected" : "").'>Ya completé un posgrado</option>
							<option value="2" '.(($pre["estado_posgrado"] ?? "") == "2" ? "selected" : "").'>Actualmente cursando un posgrado</option>
							<option value="3" '.(($pre["estado_posgrado"] ?? "") == "3" ? "selected" : "").'>Tengo planes en 1-2 años</option>
							<option value="4" '.(($pre["estado_posgrado"] ?? "") == "4" ? "selected" : "").'>Planes a largo plazo</option>
							<option value="5" '.(($pre["estado_posgrado"] ?? "") == "5" ? "selected" : "").'>No tengo planes</option>
						</select>
					</div>
				</div>
			</div>

			<!-- satisfaccion_general -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<label for="satisfaccion_formacion">¿Qué tan satisfecho estás con la formación recibida en la universidad en general?</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
					
						<select class="form-control" name="satisfaccion_formacion" id="satisfaccion_formacion" required>
							<option value="1" '.(($pre["satisfaccion_formacion"] ?? "") == "1" ? "selected" : "").'>Muy insatisfecho</option>
							<option value="2" '.(($pre["satisfaccion_formacion"] ?? "") == "2" ? "selected" : "").'>Insatisfecho</option>
							<option value="3" '.(($pre["satisfaccion_formacion"] ?? "") == "3" ? "selected" : "").'>Neutral</option>
							<option value="4" '.(($pre["satisfaccion_formacion"] ?? "") == "4" ? "selected" : "").'>Satisfecho</option>
							<option value="5" '.(($pre["satisfaccion_formacion"] ?? "") == "5" ? "selected" : "").'>Muy satisfecho</option>
						</select>
					</div>
				</div>
			</div>

			<!-- capacitaciones_complementarias -->
			<div class="col-xl-6">
				<div class="form-group mb-3">
					<label>¿Qué tipo de capacitaciones o cursos complementarios has tomado desde tu graduación? </label>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="capacitaciones_complementarias[]" value="1" '.(in_array("1", explode(",", $pre["capacitaciones_complementarias"] ?? "")) ? "checked" : "").'> Cursos de software
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="capacitaciones_complementarias[]" value="2" '.(in_array("2", explode(",", $pre["capacitaciones_complementarias"] ?? "")) ? "checked" : "").'> Cursos de idiomas
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="capacitaciones_complementarias[]" value="3" '.(in_array("3", explode(",", $pre["capacitaciones_complementarias"] ?? "")) ? "checked" : "").'> Seminarios / talleres
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="capacitaciones_complementarias[]" value="4" '.(in_array("4", explode(",", $pre["capacitaciones_complementarias"] ?? "")) ? "checked" : "").'> Diplomados / certificaciones
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="capacitaciones_complementarias[]" value="5" '.(in_array("5", explode(",", $pre["capacitaciones_complementarias"] ?? "")) ? "checked" : "").'> Habilidades blandas
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="capacitaciones_complementarias[]" value="6" '.(in_array("6", explode(",", $pre["capacitaciones_complementarias"] ?? "")) ? "checked" : "").'> Ninguno
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="capacitaciones_complementarias[]" value="7" '.(in_array("7", explode(",", $pre["capacitaciones_complementarias"] ?? "")) ? "checked" : "").'> Otro
					</div>
				</div>

				<!-- capacitaciones_otro -->
				<div class="col-12" id="bloque_capacitaciones_otro">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="capacitaciones_otro" id="capacitaciones_otro"
							value="'.htmlspecialchars($pre["capacitaciones_otro"] ?? "", ENT_QUOTES).'">
					<label for="capacitaciones_otro">¿Cúal otro tipo de capacitación?</label>
					</div>
				</div>


			</div>

		

			<!-- competencias_utiles -->
			<div class="col-xl-6">
				<div class="form-group mb-3">
					<label>¿Qué competencias o habilidades adquiridas en la universidad consideras que han sido las más útiles en tu vida profesional? </label>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="habilidades_utiles[]" value="1" '.(in_array("1", explode(",", $pre["habilidades_utiles"] ?? "")) ? "checked" : "").'> Pensamiento crítico
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="habilidades_utiles[]" value="2" '.(in_array("2", explode(",", $pre["habilidades_utiles"] ?? "")) ? "checked" : "").'> Comunicación efectiva
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="habilidades_utiles[]" value="3" '.(in_array("3", explode(",", $pre["habilidades_utiles"] ?? "")) ? "checked" : "").'> Trabajo en equipo
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="habilidades_utiles[]" value="4" '.(in_array("4", explode(",", $pre["habilidades_utiles"] ?? "")) ? "checked" : "").'> Liderazgo
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="habilidades_utiles[]" value="5" '.(in_array("5", explode(",", $pre["habilidades_utiles"] ?? "")) ? "checked" : "").'> Conocimientos técnicos
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="habilidades_utiles[]" value="6" '.(in_array("6", explode(",", $pre["habilidades_utiles"] ?? "")) ? "checked" : "").'> Adaptación y aprendizaje
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="habilidades_utiles[]" value="7" '.(in_array("7", explode(",", $pre["habilidades_utiles"] ?? "")) ? "checked" : "").'> Ética profesional
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="habilidades_utiles[]" value="8" '.(in_array("8", explode(",", $pre["habilidades_utiles"] ?? "")) ? "checked" : "").'> Gestión del tiempo
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="habilidades_utiles[]" value="9" '.(in_array("9", explode(",", $pre["habilidades_utiles"] ?? "")) ? "checked" : "").'> Otro
					</div>
				</div>

				<!-- competencias_utiles_otro -->
				<div class="col-12" id="bloque_habilidades_otro" style="display: none;">
				<label for="habilidades_otro">Otra competencia útil</label>
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="habilidades_otro" id="habilidades_otro"
							value="'.htmlspecialchars($pre["habilidades_otro"] ?? "", ENT_QUOTES).'" >
					</div>
				</div>

			</div>

			

			<!-- sugerencias_curriculo -->
			<div class="col-xl-6">
				<div class="form-group mb-3">
					<label>¿Qué habilidades o conocimientos adicionales crees que la universidad debería reforzar en el plan de estudios actual? (Selección múltiple)</label>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="sugerencias_plan_estudio[]" value="1" '.(in_array("1", explode(",", $pre["sugerencias_plan_estudio"] ?? "")) ? "checked" : "").'> Habilidades digitales
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="sugerencias_plan_estudio[]" value="2" '.(in_array("2", explode(",", $pre["sugerencias_plan_estudio"] ?? "")) ? "checked" : "").'> Emprendimiento
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="sugerencias_plan_estudio[]" value="3" '.(in_array("3", explode(",", $pre["sugerencias_plan_estudio"] ?? "")) ? "checked" : "").'> Habilidades blandas
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="sugerencias_plan_estudio[]" value="4" '.(in_array("4", explode(",", $pre["sugerencias_plan_estudio"] ?? "")) ? "checked" : "").'> Idiomas
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="sugerencias_plan_estudio[]" value="5" '.(in_array("5", explode(",", $pre["sugerencias_plan_estudio"] ?? "")) ? "checked" : "").'> Sostenibilidad
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="sugerencias_plan_estudio[]" value="6" '.(in_array("6", explode(",", $pre["sugerencias_plan_estudio"] ?? "")) ? "checked" : "").'> Análisis de datos
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="sugerencias_plan_estudio[]" value="7" '.(in_array("7", explode(",", $pre["sugerencias_plan_estudio"] ?? "")) ? "checked" : "").'> Finanzas personales
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="sugerencias_plan_estudio[]" value="8" '.(in_array("8", explode(",", $pre["sugerencias_plan_estudio"] ?? "")) ? "checked" : "").'> Plan actual es adecuado 
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="sugerencias_plan_estudio[]" value="9" '.(in_array("9", explode(",", $pre["sugerencias_plan_estudio"] ?? "")) ? "checked" : "").'> Otro 
					</div>
				</div>

				<!-- sugerencias_curriculo_otro -->
				<div class="col-12" id="bloque_sugerencias_otro" style="display: none;">
				<label for="sugerencias_curriculo_otro">Otra sugerencia curricular</label>
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="sugerencias_otro" id="sugerencias_otro"
							value="'.htmlspecialchars($pre["sugerencias_otro"] ?? "", ENT_QUOTES).'">
					</div>
				</div>

			</div>

			<!-- forma_conexion_universidad -->
			<div class="col-xl-6">
				<div class="form-group mb-3">
					<label>¿Cómo te gustaría seguir conectado con la universidad?</label>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="formas_conexion[]" value="1" '.(in_array("1", explode(",", $pre["formas_conexion"] ?? "")) ? "checked" : "").'> Recibir información
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="formas_conexion[]" value="2" '.(in_array("2", explode(",", $pre["formas_conexion"] ?? "")) ? "checked" : "").'> Mentoría
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="formas_conexion[]" value="3" '.(in_array("3", explode(",", $pre["formas_conexion"] ?? "")) ? "checked" : "").'> Charlas
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="formas_conexion[]" value="4" '.(in_array("4", explode(",", $pre["formas_conexion"] ?? "")) ? "checked" : "").'> Investigación
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="formas_conexion[]" value="5" '.(in_array("5", explode(",", $pre["formas_conexion"] ?? "")) ? "checked" : "").'> Talleres
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="formas_conexion[]" value="6" '.(in_array("6", explode(",", $pre["formas_conexion"] ?? "")) ? "checked" : "").'> Ferias de empleo
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="formas_conexion[]" value="7" '.(in_array("7", explode(",", $pre["formas_conexion"] ?? "")) ? "checked" : "").'> Apoyo financiero
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="formas_conexion[]" value="8" '.(in_array("8", explode(",", $pre["formas_conexion"] ?? "")) ? "checked" : "").'> No me interesa
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="formas_conexion[]" value="9" '.(in_array("9", explode(",", $pre["formas_conexion"] ?? "")) ? "checked" : "").'> Otro
					</div>
				</div>

				<!-- otra forma de conectar con la universidad -->
				<div class="col-12" id="bloque_formas_conexion_otro" style="display: none;">
				<label for="formas_conexion_otro">Otra forma de conectar</label>
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="formas_conexion_otro" id="formas_conexion_otro"
							value="'.htmlspecialchars($pre["formas_conexion_otro"] ?? "", ENT_QUOTES).'">
					</div>
				</div>

			</div>



			<!-- servicios_egresado_utiles -->
			<div class="col-xl-6">
				<div class="form-group mb-3">
					<label>¿Qué iniciativas o servicios para egresados te parecerían más útiles o atractivos? </label>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="servicios_utiles[]" value="1" '.(in_array("1", explode(",", $pre["servicios_utiles"] ?? "")) ? "checked" : "").'> Bolsa de empleo
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="servicios_utiles[]" value="2" '.(in_array("2", explode(",", $pre["servicios_utiles"] ?? "")) ? "checked" : "").'> Educación continua
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="servicios_utiles[]" value="3" '.(in_array("3", explode(",", $pre["servicios_utiles"] ?? "")) ? "checked" : "").'> Networking y eventos
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="servicios_utiles[]" value="4" '.(in_array("4", explode(",", $pre["servicios_utiles"] ?? "")) ? "checked" : "").'> Asesoría profesional
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="servicios_utiles[]" value="5" '.(in_array("5", explode(",", $pre["servicios_utiles"] ?? "")) ? "checked" : "").'> Acceso a instalaciones
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="servicios_utiles[]" value="6" '.(in_array("6", explode(",", $pre["servicios_utiles"] ?? "")) ? "checked" : "").'> Publicaciones
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="servicios_utiles[]" value="7" '.(in_array("7", explode(",", $pre["servicios_utiles"] ?? "")) ? "checked" : "").'> Club de egresados
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="servicios_utiles[]" value="8" '.(in_array("8", explode(",", $pre["servicios_utiles"] ?? "")) ? "checked" : "").'> Ninguno
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="servicios_utiles[]" value="9" '.(in_array("9", explode(",", $pre["servicios_utiles"] ?? "")) ? "checked" : "").'> Otro
					</div>
				</div>

				<!-- otros servicio utiles -->
				<div class="col-12" id="bloque_servicios_utiles_otro" style="display: none;">
				<label for="servicios_utiles_otro">Otros servicios utiles</label>
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="servicios_utiles_otro" id="servicios_utiles_otro"
							value="'.htmlspecialchars($pre["servicios_utiles_otro"] ?? "", ENT_QUOTES).'">
					</div>
				</div>

			</div>

			

			<!-- participacion_actividades -->
			<div class="col-xl-12 col-lg-12 col-md-12 col-12">
			<label for="disposicion_participar">¿Estarías dispuesto a participar en actividades de la universidad, como conferencias, ferias de empleo o proyectos de investigación?</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="disposicion_participar" id="disposicion_participar" required>
							<option value="1" '.(($pre["disposicion_participar"] ?? "") == "1" ? "selected" : "").'>Sí, activamente</option>
							<option value="2" '.(($pre["disposicion_participar"] ?? "") == "2" ? "selected" : "").'>Sí, ocasionalmente</option>
							<option value="3" '.(($pre["disposicion_participar"] ?? "") == "3" ? "selected" : "").'>Tal vez</option>
							<option value="4" '.(($pre["disposicion_participar"] ?? "") == "4" ? "selected" : "").'>No</option>
						</select>
					</div>
				</div>
			</div>

			<!-- medio_contacto_preferido -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<label for="canal_contacto_preferido">¿Dónde prefieres recibir noticias o invitaciones de CIAF?</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="canal_contacto_preferido" id="canal_contacto_preferido" required>
							<option value="1" '.(($pre["canal_contacto_preferido"] ?? "") == "1" ? "selected" : "").'>WhatsApp</option>
							<option value="2" '.(($pre["canal_contacto_preferido"] ?? "") == "2" ? "selected" : "").'>Correo electrónico</option>
							<option value="3" '.(($pre["canal_contacto_preferido"] ?? "") == "3" ? "selected" : "").'>Redes sociales</option>
							<option value="4" '.(($pre["canal_contacto_preferido"] ?? "") == "4" ? "selected" : "").'>No deseo</option>
						</select>
					</div>
				</div>
			</div>

			<!-- recomendaria_ciaf -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<label for="recomendaria_ciaf">¿Recomendarías a CIAF como una buena opción de formación profesional a tus amigos o familiares? </label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="recomendaria_ciaf" id="recomendaria_ciaf" required>
							<option value="1" '.(($pre["recomendaria_ciaf"] ?? "") == "1" ? "selected" : "").'>Sí, sin duda</option>
							<option value="2" '.(($pre["recomendaria_ciaf"] ?? "") == "2" ? "selected" : "").'>Tal vez</option>
							<option value="3" '.(($pre["recomendaria_ciaf"] ?? "") == "3" ? "selected" : "").'>No</option>
						</select>
					</div>
				</div>
			</div>

			<!-- celular -->
			<div class="col-xl-6 col-12">
			<label for="celular">Número de celular (con WhatsApp)</label>
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="celular" id="celular" value="'.htmlspecialchars($pre["celular"] ?? "", ENT_QUOTES).'">
				</div>
			</div>

			<!-- correo_actual -->
			<div class="col-xl-6 col-12">
			<label for="correo">Correo electrónico actual</label>
				<div class="form-floating mb-3">
					<input type="email" class="form-control" name="correo" id="correo" value="'.htmlspecialchars($pre["correo_actual"] ?? "", ENT_QUOTES).'">
				</div>
			</div>

			<!-- red_social_preferida -->
			<div class="col-xl-4 col-lg-4 col-md-6 col-12">
			<label for="red_social_activa">¿Cuál es tu red social más activa?</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="red_social_activa" id="red_social_activa">
							<option value="1" '.(($pre["red_social_activa"] ?? "") == "1" ? "selected" : "").'>Facebook</option>
							<option value="2" '.(($pre["red_social_activa"] ?? "") == "2" ? "selected" : "").'>Instagram</option>
							<option value="3" '.(($pre["red_social_activa"] ?? "") == "3" ? "selected" : "").'>LinkedIn</option>
							<option value="4" '.(($pre["red_social_activa"] ?? "") == "4" ? "selected" : "").'>TikTok</option>
							<option value="5" '.(($pre["red_social_activa"] ?? "") == "5" ? "selected" : "").'>Otra</option>
						</select>
					</div>
				</div>

				<!-- usuario_red -->
				

			</div>

			<div class="col-xl-4 col-lg-4 col-md-6 col-12" id="bloque_nombre_red_social" style="display:none">
			<label for="nombre_red_social">¿Cuál es el nombre en esa red?</label>
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="nombre_red_social" id="nombre_red_social" value="'.htmlspecialchars($pre["nombre_red_social"] ?? "", ENT_QUOTES).'">
				</div>
			</div>

			<div class="col-xl-4 col-lg-4 col-md-6 col-12" >
			<label for="usuario_red_social">¿Cuál es tu usuario en esa red?</label>
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="usuario_red_social" id="usuario_red_social" value="'.htmlspecialchars($pre["usuario_red_social"] ?? "", ENT_QUOTES).'">
				</div>
			</div>



			<!-- grupo_etnico -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<label for="grupo_etnico">¿Te identificas como parte de algún grupo étnico o cultural?</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="grupo_etnicos" id="grupo_etnicos">
							<option value="1" '.(($pre["grupo_etnicos"] ?? "") == "1" ? "selected" : "").'>Indígena</option>
							<option value="2" '.(($pre["grupo_etnicos"] ?? "") == "2" ? "selected" : "").'>Afrodescendiente</option>
							<option value="3" '.(($pre["grupo_etnicos"] ?? "") == "3" ? "selected" : "").'>Raizal</option>
							<option value="4" '.(($pre["grupo_etnicos"] ?? "") == "4" ? "selected" : "").'>Palenquero/a</option>
							<option value="5" '.(($pre["grupo_etnicos"] ?? "") == "5" ? "selected" : "").'>Gitano/a (Rom)</option>
							<option value="6" '.(($pre["grupo_etnicos"] ?? "") == "6" ? "selected" : "").'>Comunidad LGBTIQ+</option>
							<option value="7" '.(($pre["grupo_etnicos"] ?? "") == "7" ? "selected" : "").'>Víctima de conflicto armado</option>
							<option value="8" '.(($pre["grupo_etnicos"] ?? "") == "8" ? "selected" : "").'>Persona migrante</option>
							<option value="9" '.(($pre["grupo_etnicos"] ?? "") == "9" ? "selected" : "").'>Ninguno de los anteriores</option>
							<option value="10" '.(($pre["grupo_etnicos"] ?? "") == "10" ? "selected" : "").'>Prefiero no responder</option>
							<option value="11" '.(($pre["grupo_etnicos"] ?? "") == "11" ? "selected" : "").'>Otro</option>
						</select>
					</div>
				</div>
			</div>

			<div class="col-12" id="bloque_grupo_etnico_otro" style="display:none">
			<label for="grupo_etnico_otro">¿Cuál otro grupo?</label>
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="grupo_etnico_otro" id="grupo_etnico_otro"
						value="'.htmlspecialchars($pre["grupo_etnico_otro"] ?? "", ENT_QUOTES).'">
				</div>
			</div>


			<!-- discapacidad -->
			<div class="col-xl-12 col-lg-12 col-md-12 col-12">
			<label for="discapacidad">¿Tienes alguna discapacidad, condición de salud (física o mental) o dificultad de aprendizaje que debamos tener en cuenta para brindarte apoyos o ajustes razonables?</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="tiene_discapacidad" id="tiene_discapacidad">
							<option value="1" '.(($pre["tiene_discapacidad"] ?? "") == "1" ? "selected" : "").'>Sí</option>
							<option value="0" '.(($pre["tiene_discapacidad"] ?? "") == "0" ? "selected" : "").'>No</option>
							<option value="2" '.(($pre["tiene_discapacidad"] ?? "") == "2" ? "selected" : "").'>Prefiero no responder</option>
						</select>
					</div>
				</div>
				<!-- descripcion_discapacidad -->
				<div class="col-12"  id="bloque_descripcion_discapacidad" style="display:none">
				<label for="descripcion_discapacidad">Descripción (opcional)</label>
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="descripcion_discapacidad" id="descripcion_discapacidad" value="'.htmlspecialchars($pre["descripcion_discapacidad"] ?? "", ENT_QUOTES).'">
					</div>
				</div>
			</div>

			

			<!-- primer_profesional_familia -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<label for="primer_profesional">¿Eres el primer profesional en tu familia?</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="primer_profesional" id="primer_profesional">
							<option value="1" '.(($pre["primer_profesional"] ?? "") == "1" ? "selected" : "").'>Sí</option>
							<option value="0" '.(($pre["primer_profesional"] ?? "") == "0" ? "selected" : "").'>No</option>
						</select>
					</div>
				</div>
			</div>

			<!-- estrato -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<label for="estrato_socioeconomico">Estrato socioeconómico</label>
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="estrato_socioeconomico" id="estrato_socioeconomico">
							<option value="1" '.(($pre["estrato_socioeconomico"] ?? "") == "1" ? "selected" : "").'>1</option>
							<option value="2" '.(($pre["estrato_socioeconomico"] ?? "") == "2" ? "selected" : "").'>2</option>
							<option value="3" '.(($pre["estrato_socioeconomico"] ?? "") == "3" ? "selected" : "").'>3</option>
							<option value="4" '.(($pre["estrato_socioeconomico"] ?? "") == "4" ? "selected" : "").'>4</option>
							<option value="5" '.(($pre["estrato_socioeconomico"] ?? "") == "5" ? "selected" : "").'>5</option>
							<option value="6" '.(($pre["estrato_socioeconomico"] ?? "") == "6" ? "selected" : "").'>6</option>
						</select>
					</div>
					
				</div>
			</div>
			';

		$data["0"] .= '<div class="my-4 px-4">
				<div class="form-group mb-4 pb-4  check-valid text-right">
					<button type="submit" class="btn btn-success">Guardar datos</button>
				</div>
			</div>
		</div>';



		$data["0"] .= '</div>';
		$data["0"] .= '';

		$results = array($data);
		echo json_encode($data);


    break;

	case 'guardar_editar_caracter':
		$data = array();
		$data["estado"] = "";
		$data["credencial"] = "";

		// 🔄 Recolectar todos los datos del formulario
		$vida_graduado = limpiarCadena($_POST["vida_graduado"] ?? "");
		$significado_egresado = limpiarCadena($_POST["significado_egresado"] ?? "");
		$familiares_estudian_ciaf = limpiarCadena($_POST["familiares_estudian_ciaf"] ?? "");
		$tiene_hijos = limpiarCadena($_POST["tiene_hijos"] ?? "");
		$situacion_laboral = limpiarCadena($_POST["situacion_laboral"] ?? "");
		$relacion_campo_estudio = limpiarCadena($_POST["relacion_campo_estudio"] ?? "");
		$aporte_ciaf = limpiarCadena($_POST["aporte_ciaf"] ?? "");
		$preparacion_laboral = limpiarCadena($_POST["preparacion_laboral"] ?? "");
		$tipo_emprendimiento = limpiarCadena($_POST["tipo_emprendimiento"] ?? "");
		$tipo_emprendimiento_otro = limpiarCadena($_POST["tipo_emprendimiento_otro"] ?? "");
		$ingreso_mensual = limpiarCadena($_POST["ingreso_mensual"] ?? "");
		$estado_posgrado = limpiarCadena($_POST["estado_posgrado"] ?? "");
		//se agrega campo de nombre de empresa.
		$nombre_empresa = limpiarCadena($_POST["nombre_empresa"] ?? "");

		// Arrays → convertimos a cadena con comas
		$capacitaciones_complementarias = isset($_POST["capacitaciones_complementarias"]) ? implode(",", $_POST["capacitaciones_complementarias"]) : "";
		$capacitaciones_otro = limpiarCadena($_POST["capacitaciones_otro"] ?? "");

		$habilidades_utiles = isset($_POST["habilidades_utiles"]) ? implode(",", $_POST["habilidades_utiles"]) : "";
		$habilidades_otro = limpiarCadena($_POST["habilidades_otro"] ?? "");

		$sugerencias_plan_estudio = isset($_POST["sugerencias_plan_estudio"]) ? implode(",", $_POST["sugerencias_plan_estudio"]) : "";
		$sugerencias_otro = limpiarCadena($_POST["sugerencias_otro"] ?? "");

		$satisfaccion_formacion = limpiarCadena($_POST["satisfaccion_formacion"] ?? "");

		$formas_conexion = isset($_POST["formas_conexion"]) ? implode(",", $_POST["formas_conexion"]) : "";
		$formas_conexion_otro = limpiarCadena($_POST["formas_conexion_otro"] ?? "");

		$servicios_utiles = isset($_POST["servicios_utiles"]) ? implode(",", $_POST["servicios_utiles"]) : "";
		$servicios_utiles_otro = limpiarCadena($_POST["servicios_utiles_otro"] ?? "");

		$disposicion_participar = limpiarCadena($_POST["disposicion_participar"] ?? "");
		$canal_contacto_preferido = limpiarCadena($_POST["canal_contacto_preferido"] ?? "");
		$recomendaria_ciaf = limpiarCadena($_POST["recomendaria_ciaf"] ?? "");

		$celular = limpiarCadena($_POST["celular"] ?? "");
		$correo = limpiarCadena($_POST["correo"] ?? "");

		$red_social_activa = limpiarCadena($_POST["red_social_activa"] ?? "");
		$usuario_red_social = limpiarCadena($_POST["usuario_red_social"] ?? "");

		$grupo_etnicos = limpiarCadena($_POST["grupo_etnicos"] ?? "");
		$grupo_etnico_otro = limpiarCadena($_POST["grupo_etnico_otro"] ?? "");

		$tiene_discapacidad = limpiarCadena($_POST["tiene_discapacidad"] ?? "");
		$descripcion_discapacidad = limpiarCadena($_POST["descripcion_discapacidad"] ?? "");

		$primer_profesional = limpiarCadena($_POST["primer_profesional"] ?? "");
		$estrato_socioeconomico = limpiarCadena($_POST["estrato_socioeconomico"] ?? "");



		// 🔧 Enviar todos los datos al modelo (ajusta tu función editarCaracter si es necesario)
		$rspta = $conectar->editarCaracter(
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
			$nombre_empresa,
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
			$usuario_red_social,
			$grupo_etnicos,
			$grupo_etnico_otro,
			$tiene_discapacidad,
			$descripcion_discapacidad,
			$primer_profesional,
			$estrato_socioeconomico,
			$fecha
		);

		$data["credencial"] .= $id_credencial;
		$data["estado"] = $rspta ? "si" : "no";

		$datos = $conectar->datoscredencial($id_credencial);
		$credencial_nombre= $datos["credencial_nombre"];
		$credencial_login= $datos["credencial_login"];
		$id_egresados_caracterizacion= $datos["id_egresados_caracterizacion"];

		 $contenido = set_template($credencial_nombre,$id_egresados_caracterizacion);
		enviar_correo($credencial_login, "¡Gracias por seguir siendo parte de CIAF!", $contenido);

		echo json_encode($data);
	break;

}