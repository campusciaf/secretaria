<?php
require_once "../modelos/ConsultaEgresado.php";
session_start();
$consultaegresado = new ConsultaEgresado();
$periodo_actual = $_SESSION['periodo_actual'];

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i');

/* **************************************************** */
//variable para traer el estado
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";
// trae el id credencial del estudiante
$id_credencial = isset($_POST["id_credencial"]) ? limpiarCadena($_POST["id_credencial"]) : "";
// trae el estado del egresado
$id_egresdado_est = isset($_POST["id_egresdado_est"]) ? limpiarCadena($_POST["id_egresdado_est"]) : "";
$id_egresado_estado = isset($_POST["id_egresado_estado"]) ? limpiarCadena($_POST["id_egresado_estado"]) : "";



$id_credencial_tarea = isset($_POST["id_credencial_tarea"]) ? limpiarCadena($_POST["id_credencial_tarea"]) : "";
$id_credencial_tabla = isset($_POST["id_credencial_tabla"]) ? limpiarCadena($_POST["id_credencial_tabla"]) : "";
$motivo_seguimiento = isset($_POST["motivo_seguimiento"]) ? limpiarCadena($_POST["motivo_seguimiento"]) : "";
$mensaje_seguimiento = isset($_POST["mensaje_seguimiento"]) ? limpiarCadena($_POST["mensaje_seguimiento"]) : "";


/* variables para programar tarea */
$motivo_tarea = isset($_POST["motivo_tarea"]) ? limpiarCadena($_POST["motivo_tarea"]) : "";
$mensaje_tarea = isset($_POST["mensaje_tarea"]) ? limpiarCadena($_POST["mensaje_tarea"]) : "";
$fecha_programada = isset($_POST["fecha_programada"]) ? limpiarCadena($_POST["fecha_programada"]) : "";
$hora_programada = isset($_POST["hora_programada"]) ? limpiarCadena($_POST["hora_programada"]) : "";
/* ********************* */

$id_usuario = $_SESSION['id_usuario'];
// trae los datos para guardar el numero de celular en la api de whastapp y tambien trae el mensaje que se va a enviar.
$numero_celular = isset($_POST["numero_celular"]) ? limpiarCadena($_POST["numero_celular"]) : "";

// $nombre_estado=isset($_POST["nombre_estado"])? limpiarCadena($_POST["nombre_estado"]):"";

$envio_mensaje = isset($_POST["envio_mensaje"]) ? limpiarCadena($_POST["envio_mensaje"]) : "";

switch ($_GET["op"]) {
		//consultamos los programas de nivel 3 por estado 5 y 2 (5 == "Egresado" and 2 == "Graduado")
	case 'consultaegresados':

		$egresados = $consultaegresado->programasnivel3();

		$data = array();

		foreach ($egresados as $i => $egresado) {
			$estado = $egresado["estado"];
			$programa = $egresado["fo_programa"];
			$numero_celular = '57' . $egresado["celular"];

			$nombre_estudiante = trim(
				($egresado["credencial_nombre"] ?? '') . " " .
					($egresado["credencial_nombre_2"] ?? '') . " " .
					($egresado["credencial_apellido"] ?? '') . " " .
					($egresado["credencial_apellido_2"] ?? '')
			);

			$estado_nombre = ($estado == 2) ? '<span class="badge badge-primary p-1">Graduado</span>' : '<span class="badge badge-success p-1">Egresado</span>';


			$folio = $egresado["folio"] ?? 'No tiene folio'; // Obtener folio, manejar casos nulos

			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
								<a onclick="verHistorial(' . $egresado["id_credencial"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye" style="color: white;"></i></a>
								<a onclick="agregar_seguimiento_egresado(' . $egresado["id_credencial"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus" style="color: white;"></i></a>
								<button class="btn btn-warning btn-xs" onclick="mostrar_egresado(' . $egresado["id_estudiante"] . ',' . $egresado["id_credencial"] . ')" title="Editar"> <i class="fas fa-pencil-alt"></i> </button>
								<a class="d-none" onclick="enviarnumero(' . $numero_celular . ')" class="btn btn-success btn-xs" title="Enviar Mensaje"><i class="fab fa-whatsapp" style="color: white;"></i></a>
								<a onclick="aceptoData(' . $egresado["id_credencial"] . ')" class="btn btn-info btn-xs" title="caracterización egresado"><i class="fas fa-user" style="color: white;"></i></a>
							</div></div>',
				"1" => '<div>' . $egresado["credencial_identificacion"] . ' </div>',
				"2" => $nombre_estudiante,
				"3" => '<div class="tooltips">' . $egresado["celular"] . '<span class="tooltiptext">' . "_____" . ' ' . $egresado["telefono"] . '</span></div>',
				"4" => $egresado["email"],
				"5" => $egresado["credencial_login"],
				"6" => $programa,
				"7" => $egresado["jornada_e"],
				"8" => $estado_nombre,
				"9" => $folio, // Mostrar folio aquí
				"10" => $egresado["periodo_activo"],
			);
		}

		$results = array(
			"sEcho" => 1, // Información para el datatables
			"iTotalRecords" => count($data), // Enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), // Enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;

		//agregamos el seguimiento para el egresado
	case 'agregarSeguimiento':
		$rspta = $consultaegresado->insertarSeguimiento($id_usuario, $id_credencial_tabla, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora);
		echo $rspta ? "Seguimiento registrado" : "Seguimiento no se pudo registrar";
		break;

		//agregamos el seguimiento para el egresado
	case 'mensaje':
		$url = 'https://graph.facebook.com/v14.0/101778699370563/messages';
		$header = array("Authorization: Bearer EAAIdKNXDyRoBAGve2EHfaiJP1egsj2SaRpHGf5u0YoaCqfISPchKrnmslCZAv62SwnLPM7PWPl4QtZBVndpG4rLeIGUWdCpLZC5MJQFcQuO8z7RVzR8w89skiZCw8vUWUGRLv32qjOEFQZBmyIHEkv5ZAFOWUqBZAmkrm0ZABPBuObDba3WJAZBYDn8Ek9rVSFZCvO6w6jOzZBXgwZDZD", "Content-Type: application/json");

		$data = '{
			"messaging_product": "whatsapp",
			"recipient_type": "individual",
			"to": ' . $numero_celular . ',
			"type": "text",
			"text": {
			"preview_url": false,
			"body":"' . $envio_mensaje . '"
			}
		}';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);



		curl_close($ch);
		// $response = json_decode($result); 
		// print_r($result);

		// echo $result;  
		curl_close($ch);

		break;

		//enviar plantilla para el egresado
	case 'mensaje_plantilla':
		$url = 'https://graph.facebook.com/v14.0/101778699370563/messages';
		$header = array("Authorization: Bearer EAAIdKNXDyRoBAGve2EHfaiJP1egsj2SaRpHGf5u0YoaCqfISPchKrnmslCZAv62SwnLPM7PWPl4QtZBVndpG4rLeIGUWdCpLZC5MJQFcQuO8z7RVzR8w89skiZCw8vUWUGRLv32qjOEFQZBmyIHEkv5ZAFOWUqBZAmkrm0ZABPBuObDba3WJAZBYDn8Ek9rVSFZCvO6w6jOzZBXgwZDZD", "Content-Type: application/json");

		$data = '


		{
			"messaging_product": "whatsapp",
			"to": ' . $numero_celular . ',
			"type": "template",
			"template": {
				"name": "plantilla_ciaf_egresados",
				"language": {
					"code": "es"
				}
			}
		}
		
		
		';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);



		curl_close($ch);


		// echo $result;  
		curl_close($ch);

		break;

		//agregamos el seguimiento para el egresado
	case 'agregarMensaje':

		$fecha_mensaje = date('Y-m-d');
		$hora_mensaje = date('H:i:S');

		$rspta = $consultaegresado->insertarmensaje($numero_celular, $envio_mensaje, $fecha_mensaje, $hora_mensaje, $id_usuario);
		echo $rspta ? "Mensaje registrado" : "Mensaje no se pudo registrar";
		break;

		// agregamos la tarea para el egresado
	case 'agregarTarea':
		$fecha_realizo = NULL;
		$hora_realizo = NULL;
		$rspta = $consultaegresado->insertarTarea($id_usuario, $id_credencial_tarea, $motivo_tarea, $mensaje_tarea, $fecha, $hora, $fecha_programada, $hora_programada, $fecha_realizo, $hora_realizo, $periodo_actual);
		echo $rspta ? "Tarea Programada" : "Tarea no se pudo Programar";
		break;

		//tabla para ver el historial del seguimiento del egresado
	case 'verHistorialTabla':
		$id_credencial_tabla = $_GET["id_credencial_tabla"];

		$rspta = $consultaegresado->verHistorialSeguimientoEgresados($id_credencial_tabla);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;

		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $consultaegresado->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];

			$data[] = array(
				"0" => $reg[$i]["id_credencial"],
				"1" => $reg[$i]["motivo_seguimiento"],
				"2" => $reg[$i]["mensaje_seguimiento"],
				"3" => $consultaegresado->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],
				"4" => $nombre_usuario

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


		//tabla para ver el historial de las tareas por egresado
	case 'verTareasHistorialTabla':
		$id_credencial_tarea = $_GET["id_credencial_tarea"];

		$rspta = $consultaegresado->verHistorialTareasEgresados($id_credencial_tarea);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;

		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $consultaegresado->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];

			$data[] = array(
				"0" => $reg[$i]["id_credencial"],
				"1" => $reg[$i]["motivo_tarea"],
				"2" => $reg[$i]["mensaje_tarea"],
				"3" => $consultaegresado->fechaesp($reg[$i]["fecha_registro"]) . ' a las ' . $reg[$i]["hora_registro"],
				"4" => $nombre_usuario

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

	case 'mostrar_egresado':
		$id_estudiante = $_POST["id_estudiante"];
		$rspta = $consultaegresado->mostrar_egresado($id_estudiante);
		echo json_encode($rspta);
		break;


	case "selectTipoSangre":
		$rspta = $consultaegresado->selectTipoSangre();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre_sangre"] . "'>" . $rspta[$i]["nombre_sangre"] . "</option>";
		}
		break;




	case "selectDepartamento":
		$departamento_nacimiento = ""; // Inicializar la variable

		if (isset($_POST['departamento_nacimiento'])) {
			$departamento_nacimiento = $_POST['departamento_nacimiento'];
		}

		$rspta = $consultaegresado->selectDepartamento();
		echo "<option value='" . $departamento_nacimiento . "'>" . $departamento_nacimiento . "</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
		}
	break;


	case "selectMunicipio":
		$departamento = ""; // Inicializar la variable

		if (isset($_POST['departamento'])) {
			$departamento= $_POST['departamento'];
		}

		$rspta = $consultaegresado->selectMunicipio($departamento);
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
		}
		break;

	
		case 'editar':
		// Variables para credencial estudiante
		$id_credencial = isset($_POST['id_credencial_global']) ? limpiarCadena($_POST['id_credencial_global']) : "";
		$credencial_nombre = isset($_POST['credencial_nombre']) ? limpiarCadena($_POST['credencial_nombre']) : "";
		$credencial_nombre_2 = isset($_POST['credencial_nombre_2']) ? limpiarCadena($_POST['credencial_nombre_2']) : "";
		$credencial_apellido = isset($_POST['credencial_apellido']) ? limpiarCadena($_POST['credencial_apellido']) : "";
		$credencial_apellido_2 = isset($_POST['credencial_apellido_2']) ? limpiarCadena($_POST['credencial_apellido_2']) : "";
		$credencial_identificacion = isset($_POST['credencial_identificacion']) ? limpiarCadena($_POST['credencial_identificacion']) : "";

		// Variables para datos estudiante
		$fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? limpiarCadena($_POST['fecha_nacimiento']) : "";
		$tipo_sangre = isset($_POST['tipo_sangre']) ? limpiarCadena($_POST['tipo_sangre']) : "";
		$genero = isset($_POST['genero']) ? limpiarCadena($_POST['genero']) : "";
		$grupo_etnico = isset($_POST['grupo_etnico']) ? limpiarCadena($_POST['grupo_etnico']) : "";
		$nombre_etnico = isset($_POST['nombre_etnico']) ? limpiarCadena($_POST['nombre_etnico']) : "";
		$departamento_nacimiento = isset($_POST['departamento_nacimiento']) ? limpiarCadena($_POST['departamento_nacimiento']) : "";
		$lugar_nacimiento = isset($_POST['lugar_nacimiento']) ? limpiarCadena($_POST['lugar_nacimiento']) : "";
		$direccion = isset($_POST['direccion']) ? limpiarCadena($_POST['direccion']) : "";
		$barrio = isset($_POST['barrio']) ? limpiarCadena($_POST['barrio']) : "";
		$telefono = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : "";
		$celular = isset($_POST['celular']) ? limpiarCadena($_POST['celular']) : "";
		$email = isset($_POST['email']) ? limpiarCadena($_POST['email']) : "";
		$instagram = isset($_POST['instagram']) ? limpiarCadena($_POST['instagram']) : "";

		// Actualizar datos del egresado en credencial_estudiante
		$rspta = $consultaegresado->EditarEgresado(
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
		);
		break;






	
		case 'listarPreguntas':

		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$id_credencial_e = $_POST["id_credencial"];
		$pre = $consultaegresado->listar($id_credencial_e);


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
					<textarea class="form-control" name="vida_graduado" id="vida_graduado" rows="3">'.htmlspecialchars($pre["vida_graduado"] ?? "", ENT_QUOTES).'</textarea>
				</div>
			</div>

			<!-- significado_egresado -->
			<div class="col-xl-6 col-lg-4 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">
						<input type="text" class="form-control" name="significado_egresado" id="significado_egresado" value="'.htmlspecialchars($pre["significado_egresado"] ?? "", ENT_QUOTES).'">
						<label for="significado_egresado">¿Qué significa ser egresado de CIAF?</label>
					</div>
				</div>
			</div>

			<!-- familiares_estudian_ciaf -->
			<div class="col-xl-6 col-lg-4 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">
						<select class="form-control" name="familiares_estudian_ciaf" id="familiares_estudian_ciaf">
							<option value="0" '.(($pre["familiares_estudian_ciaf"] ?? "") == "0" ? "selected" : "").'>No</option>
							<option value="1" '.(($pre["familiares_estudian_ciaf"] ?? "") == "1" ? "selected" : "").'>Sí</option>
						</select>
						<label for="familiares_estudian_ciaf">¿Tienes familiares o personas cercanas que actualmente estudian en CIAF</label>
					</div>
				</div>
			</div>

			<!-- tiene_hijos -->
			<div class="col-xl-2 col-lg-4 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">
						<select class="form-control" name="tiene_hijos" id="tiene_hijos">
							<option value="0" '.(($pre["tiene_hijos"] ?? "") == "0" ? "selected" : "").'>No</option>
							<option value="1" '.(($pre["tiene_hijos"] ?? "") == "1" ? "selected" : "").'>Sí</option>
						</select>
						<label for="tiene_hijos">¿Tienes hijos?</label>
					</div>
				</div>
			</div>


			<!-- situacion_laboral -->
			<div class="col-xl-4 col-lg-4 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">
						<select class="form-control" name="situacion_laboral" id="situacion_laboral">
						<option value="1" '.(($pre["situacion_laboral"] ?? "") == "1" ? "selected" : "").'>Empleado a tiempo completo</option>
						<option value="2" '.(($pre["situacion_laboral"] ?? "") == "2" ? "selected" : "").'>Empleado a tiempo parcial</option>
						<option value="3" '.(($pre["situacion_laboral"] ?? "") == "3" ? "selected" : "").'>Emprendedor</option>
						<option value="4" '.(($pre["situacion_laboral"] ?? "") == "4" ? "selected" : "").'>Desempleado buscando empleo</option>
						<option value="5" '.(($pre["situacion_laboral"] ?? "") == "5" ? "selected" : "").'>Desempleado no buscando empleo</option>
						<option value="6" '.(($pre["situacion_laboral"] ?? "") == "6" ? "selected" : "").'>Estudiando</option>
						<option value="7" '.(($pre["situacion_laboral"] ?? "") == "7" ? "selected" : "").'>Voluntario</option>
					</select>
						<label for="situacion_laboral">¿Cuál es tu situación laboral actual?</label>
					</div>
				</div>
			</div>


			<!-- relacion_campo_estudio -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
									
						<select class="form-control" name="relacion_campo_estudio" id="relacion_campo_estudio">
							<option value="1" '.(($pre["relacion_campo_estudio"] ?? "") == "1" ? "selected" : "").'>Directamente relacionado</option>
							<option value="2" '.(($pre["relacion_campo_estudio"] ?? "") == "2" ? "selected" : "").'>Parcialmente relacionado</option>
							<option value="3" '.(($pre["relacion_campo_estudio"] ?? "") == "3" ? "selected" : "").'>No relacionado</option>
							<option value="4" '.(($pre["relacion_campo_estudio"] ?? "") == "4" ? "selected" : "").'>No aplica</option>
						</select>
						<label for="relacion_campo_estudio">Si estás empleado, ¿tu puesto de trabajo está relacionado con tu campo de estudio?</label>
					</div>
				</div>
			</div>

			<!-- aporte_ciaf -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="aporte_ciaf" id="aporte_ciaf">
							<option value="1" '.(($pre["aporte_ciaf"] ?? "") == "1" ? "selected" : "").'>Poco</option>
							<option value="2" '.(($pre["aporte_ciaf"] ?? "") == "2" ? "selected" : "").'>Algo</option>
							<option value="3" '.(($pre["aporte_ciaf"] ?? "") == "3" ? "selected" : "").'>Mucho</option>
						</select>
						<label for="aporte_ciaf">¿Sientes que tu carrera en CIAF te ayudó a llegar hasta ahí?</label>
					</div>
				</div>
			</div>

			<!-- preparacion_laboral -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="preparacion_laboral" id="preparacion_laboral">
							<option value="1" '.(($pre["preparacion_laboral"] ?? "") == "1" ? "selected" : "").'>No adecuadamente</option>
							<option value="2" '.(($pre["preparacion_laboral"] ?? "") == "2" ? "selected" : "").'>Parcialmente</option>
							<option value="3" '.(($pre["preparacion_laboral"] ?? "") == "3" ? "selected" : "").'>Sí, adecuadamente</option>
							<option value="4" '.(($pre["preparacion_laboral"] ?? "") == "4" ? "selected" : "").'>Sí, muy adecuadamente</option>
						</select>
						<label for="preparacion_laboral">¿Consideras que la formación recibida en la universidad te preparó adecuadamente para el mercado laboral?</label>
					</div>
				</div>
			</div>


			<!-- tipo_emprendimiento -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="tipo_emprendimiento" id="tipo_emprendimiento">
							<option value="1" '.(($pre["tipo_emprendimiento"] ?? "") == "1" ? "selected" : "").'>Servicios</option>
							<option value="2" '.(($pre["tipo_emprendimiento"] ?? "") == "2" ? "selected" : "").'>Productos</option>
							<option value="3" '.(($pre["tipo_emprendimiento"] ?? "") == "3" ? "selected" : "").'>Startup tecnológico</option>
							<option value="4" '.(($pre["tipo_emprendimiento"] ?? "") == "4" ? "selected" : "").'>Proyecto social/cultural</option>
							<option value="5" '.(($pre["tipo_emprendimiento"] ?? "") == "5" ? "selected" : "").'>Freelance</option>
							<option value="6" '.(($pre["tipo_emprendimiento"] ?? "") == "6" ? "selected" : "").'>Otro</option>
							<option value="7" '.(($pre["tipo_emprendimiento"] ?? "") == "7" ? "selected" : "").'>No aplica</option>
						</select>
						<label for="tipo_emprendimiento">Si eres emprendedor, ¿qué tipo de empresa o proyecto has desarrollado?</label>
					</div>
				</div>
			</div>

			<!-- tipo_emprendimiento_otro -->
			<div class="col-12" id="bloque_tipo_emprendimiento_otro" style="display:none">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="tipo_emprendimiento_otro" id="tipo_emprendimiento_otro"
						value="'.htmlspecialchars($pre["tipo_emprendimiento_otro"] ?? "", ENT_QUOTES).'">
					<label for="tipo_emprendimiento_otro">Otro tipo de emprendimiento (si aplica)</label>
				</div>
			</div>

			<!-- ingreso_mensual -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="ingreso_mensual" id="ingreso_mensual">
							<option value="1" '.(($pre["ingreso_mensual"] ?? "") == "1" ? "selected" : "").'>Menos de 1 SMMLV</option>
							<option value="2" '.(($pre["ingreso_mensual"] ?? "") == "2" ? "selected" : "").'>Entre 1 y 2 SMMLV</option>
							<option value="3" '.(($pre["ingreso_mensual"] ?? "") == "3" ? "selected" : "").'>Entre 2 y 3 SMMLV</option>
							<option value="4" '.(($pre["ingreso_mensual"] ?? "") == "4" ? "selected" : "").'>Más de 3 SMMLV</option>
							<option value="5" '.(($pre["ingreso_mensual"] ?? "") == "5" ? "selected" : "").'>Prefiero no responder</option>
						</select>
						<label for="ingreso_mensual">¿Cuál es tu rango de ingreso mensual aproximado?</label>
					</div>
				</div>
			</div>

			<!-- estado_posgrado -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="estado_posgrado" id="estado_posgrado">
							<option value="1" '.(($pre["estado_posgrado"] ?? "") == "1" ? "selected" : "").'>Ya completé un posgrado</option>
							<option value="2" '.(($pre["estado_posgrado"] ?? "") == "2" ? "selected" : "").'>Actualmente cursando un posgrado</option>
							<option value="3" '.(($pre["estado_posgrado"] ?? "") == "3" ? "selected" : "").'>Tengo planes en 1-2 años</option>
							<option value="4" '.(($pre["estado_posgrado"] ?? "") == "4" ? "selected" : "").'>Planes a largo plazo</option>
							<option value="5" '.(($pre["estado_posgrado"] ?? "") == "5" ? "selected" : "").'>No tengo planes</option>
						</select>
						<label for="estado_posgrado">¿Has realizado o tienes planes de realizar estudios de posgrado (especialización, maestría, doctorado)?</label>
					</div>
				</div>
			</div>

			<!-- satisfaccion_general -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
					
						<select class="form-control" name="satisfaccion_formacion" id="satisfaccion_formacion">
							<option value="1" '.(($pre["satisfaccion_formacion"] ?? "") == "1" ? "selected" : "").'>Muy insatisfecho</option>
							<option value="2" '.(($pre["satisfaccion_formacion"] ?? "") == "2" ? "selected" : "").'>Insatisfecho</option>
							<option value="3" '.(($pre["satisfaccion_formacion"] ?? "") == "3" ? "selected" : "").'>Neutral</option>
							<option value="4" '.(($pre["satisfaccion_formacion"] ?? "") == "4" ? "selected" : "").'>Satisfecho</option>
							<option value="5" '.(($pre["satisfaccion_formacion"] ?? "") == "5" ? "selected" : "").'>Muy satisfecho</option>
						</select>
						<label for="satisfaccion_formacion">¿Qué tan satisfecho estás con la formación recibida en la universidad en general?</label>
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
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="habilidades_otro" id="habilidades_otro"
							value="'.htmlspecialchars($pre["habilidades_otro"] ?? "", ENT_QUOTES).'" >
						<label for="habilidades_otro">Otra competencia útil</label>
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
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="sugerencias_otro" id="sugerencias_otro"
							value="'.htmlspecialchars($pre["sugerencias_otro"] ?? "", ENT_QUOTES).'">
						<label for="sugerencias_curriculo_otro">Otra sugerencia curricular</label>
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
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="formas_conexion_otro" id="formas_conexion_otro"
							value="'.htmlspecialchars($pre["formas_conexion_otro"] ?? "", ENT_QUOTES).'">
						<label for="formas_conexion_otro">Otra forma de conectar</label>
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
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="servicios_utiles_otro" id="servicios_utiles_otro"
							value="'.htmlspecialchars($pre["servicios_utiles_otro"] ?? "", ENT_QUOTES).'">
						<label for="servicios_utiles_otro">Otros servicios utiles</label>
					</div>
				</div>

			</div>

			

			<!-- participacion_actividades -->
			<div class="col-xl-12 col-lg-12 col-md-12 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="disposicion_participar" id="disposicion_participar">
							<option value="1" '.(($pre["disposicion_participar"] ?? "") == "1" ? "selected" : "").'>Sí, activamente</option>
							<option value="2" '.(($pre["disposicion_participar"] ?? "") == "2" ? "selected" : "").'>Sí, ocasionalmente</option>
							<option value="3" '.(($pre["disposicion_participar"] ?? "") == "3" ? "selected" : "").'>Tal vez</option>
							<option value="4" '.(($pre["disposicion_participar"] ?? "") == "4" ? "selected" : "").'>No</option>
						</select>
						<label for="disposicion_participar">¿Estarías dispuesto a participar en actividades de la universidad, como conferencias, ferias de empleo o proyectos de investigación?</label>
					</div>
				</div>
			</div>

			<!-- medio_contacto_preferido -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="canal_contacto_preferido" id="canal_contacto_preferido" required>
							<option value="1" '.(($pre["canal_contacto_preferido"] ?? "") == "1" ? "selected" : "").'>WhatsApp</option>
							<option value="2" '.(($pre["canal_contacto_preferido"] ?? "") == "2" ? "selected" : "").'>Correo electrónico</option>
							<option value="3" '.(($pre["canal_contacto_preferido"] ?? "") == "3" ? "selected" : "").'>Redes sociales</option>
							<option value="4" '.(($pre["canal_contacto_preferido"] ?? "") == "4" ? "selected" : "").'>No deseo</option>
						</select>
						<label for="canal_contacto_preferido">¿Dónde prefieres recibir noticias o invitaciones de CIAF?</label>
					</div>
				</div>
			</div>

			<!-- recomendaria_ciaf -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="recomendaria_ciaf" id="recomendaria_ciaf" required>
							<option value="1" '.(($pre["recomendaria_ciaf"] ?? "") == "1" ? "selected" : "").'>Sí, sin duda</option>
							<option value="2" '.(($pre["recomendaria_ciaf"] ?? "") == "2" ? "selected" : "").'>Tal vez</option>
							<option value="3" '.(($pre["recomendaria_ciaf"] ?? "") == "3" ? "selected" : "").'>No</option>
						</select>
						<label for="recomendaria_ciaf">¿Recomendarías a CIAF como una buena opción de formación profesional a tus amigos o familiares? </label>
					</div>
				</div>
			</div>

			<!-- celular -->
			<div class="col-xl-6 col-12">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="celular" id="celular" value="'.htmlspecialchars($pre["celular"] ?? "", ENT_QUOTES).'">
					<label for="celular">Número de celular (con WhatsApp)</label>
				</div>
			</div>

			<!-- correo_actual -->
			<div class="col-xl-6 col-12">
				<div class="form-floating mb-3">
					<input type="email" class="form-control" name="correo" id="correo" value="'.htmlspecialchars($pre["correo"] ?? "", ENT_QUOTES).'">
					<label for="correo">Correo electrónico actual</label>
				</div>
			</div>

			<!-- red_social_preferida -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="red_social_activa" id="red_social_activa" required>
							<option value="1" '.(($pre["red_social_activa"] ?? "") == "1" ? "selected" : "").'>Facebook</option>
							<option value="2" '.(($pre["red_social_activa"] ?? "") == "2" ? "selected" : "").'>Instagram</option>
							<option value="3" '.(($pre["red_social_activa"] ?? "") == "3" ? "selected" : "").'>LinkedIn</option>
							<option value="4" '.(($pre["red_social_activa"] ?? "") == "4" ? "selected" : "").'>TikTok</option>
							<option value="5" '.(($pre["red_social_activa"] ?? "") == "5" ? "selected" : "").'>Otra</option>
						</select>
						<label for="red_social_activa">¿Cuál es tu red social más activa?</label>
					</div>
				</div>
			</div>

			<!-- usuario_red -->
				<div class="col-6" id="bloque_nombre_red_social" style="display:none">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="nombre_red_social" id="nombre_red_social" value="'.htmlspecialchars($pre["nombre_red_social"] ?? "", ENT_QUOTES).'">
						<label for="nombre_red_social">¿Cuál es el nombre de la red?</label>
					</div>
				</div>

			<div class="col-6">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="usuario_red_social" id="usuario_red_social" value="'.htmlspecialchars($pre["usuario_red_social"] ?? "", ENT_QUOTES).'">
						<label for="usuario_red_social">¿Cuál es tu usuario en esa red?</label>
					</div>
				</div>



			<!-- grupo_etnico -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="grupo_etnicos" id="grupo_etnicos" required>
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
						<label for="grupo_etnico">¿Te identificas como parte de algún grupo étnico o cultural?</label>
					</div>
				</div>
			</div>

			<div class="col-12" id="bloque_grupo_etnico_otro" style="display:none">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="grupo_etnico_otro" id="grupo_etnico_otro"
						value="'.htmlspecialchars($pre["grupo_etnico_otro"] ?? "", ENT_QUOTES).'">
					<label for="grupo_etnico_otro">¿Cuál otro grupo?</label>
				</div>
			</div>


			<!-- discapacidad -->
			<div class="col-xl-12 col-lg-12 col-md-12 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="tiene_discapacidad" id="tiene_discapacidad">
							<option value="1" '.(($pre["tiene_discapacidad"] ?? "") == "1" ? "selected" : "").'>Sí</option>
							<option value="0" '.(($pre["tiene_discapacidad"] ?? "") == "0" ? "selected" : "").'>No</option>
							<option value="2" '.(($pre["tiene_discapacidad"] ?? "") == "2" ? "selected" : "").'>Prefiero no responder</option>
						</select>
						<label for="discapacidad">¿Tienes alguna discapacidad, condición de salud (física o mental) o dificultad de aprendizaje que debamos tener en cuenta para brindarte apoyos o ajustes razonables?</label>
					</div>
				</div>
				<!-- descripcion_discapacidad -->
				<div class="col-12"  id="bloque_descripcion_discapacidad" style="display:none">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="descripcion_discapacidad" id="descripcion_discapacidad" value="'.htmlspecialchars($pre["descripcion_discapacidad"] ?? "", ENT_QUOTES).'">
						<label for="descripcion_discapacidad">Descripción (opcional)</label>
					</div>
				</div>
			</div>

			

			<!-- primer_profesional_familia -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						
						<select class="form-control" name="primer_profesional" id="primer_profesional">
							<option value="1" '.(($pre["primer_profesional"] ?? "") == "1" ? "selected" : "").'>Sí</option>
							<option value="0" '.(($pre["primer_profesional"] ?? "") == "0" ? "selected" : "").'>No</option>
						</select>
						<label for="primer_profesional">¿Eres el primer profesional en tu familia?</label>
					</div>
				</div>
			</div>

			<!-- estrato -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-12">
				<div class="form-group mb-3">
					<div class="form-floating">	
						<select class="form-control" name="estrato_socioeconomico" id="estrato_socioeconomico" required>
							<option value="1" '.(($pre["estrato_socioeconomico"] ?? "") == "1" ? "selected" : "").'>1</option>
							<option value="2" '.(($pre["estrato_socioeconomico"] ?? "") == "2" ? "selected" : "").'>2</option>
							<option value="3" '.(($pre["estrato_socioeconomico"] ?? "") == "3" ? "selected" : "").'>3</option>
							<option value="4" '.(($pre["estrato_socioeconomico"] ?? "") == "4" ? "selected" : "").'>4</option>
							<option value="5" '.(($pre["estrato_socioeconomico"] ?? "") == "5" ? "selected" : "").'>5</option>
							<option value="6" '.(($pre["estrato_socioeconomico"] ?? "") == "6" ? "selected" : "").'>6</option>
						</select>
						<label for="estrato_socioeconomico">Estrato socioeconómico</label>
					</div>
				</div>
			</div>
			';

		$data["0"] .= '<div class="">
				<div class="form-group mb-2  check-valid text-right">
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
		$id_credencial_estudiante  = limpiarCadena($_POST["id_credencial_estudiante"] ?? "");
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
		$nombre_red_social = limpiarCadena($_POST["nombre_red_social"] ?? "");
		$usuario_red_social = limpiarCadena($_POST["usuario_red_social"] ?? "");

		$grupo_etnicos = limpiarCadena($_POST["grupo_etnicos"] ?? "");
		$grupo_etnico_otro = limpiarCadena($_POST["grupo_etnico_otro"] ?? "");

		$tiene_discapacidad = limpiarCadena($_POST["tiene_discapacidad"] ?? "");
		$descripcion_discapacidad = limpiarCadena($_POST["descripcion_discapacidad"] ?? "");

		$primer_profesional = limpiarCadena($_POST["primer_profesional"] ?? "");
		$estrato_socioeconomico = limpiarCadena($_POST["estrato_socioeconomico"] ?? "");



		// 🔧 Enviar todos los datos al modelo (ajusta tu función editarCaracter si es necesario)
		$rspta = $consultaegresado->editarCaracter(
			$id_credencial_estudiante,
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
		);

		$data["credencial"] .= $id_credencial_estudiante;
		$data["estado"] = $rspta ? "si" : "no";
		echo json_encode($data);
	break;


	case 'aceptoData':
		$id_credencial_e = $_POST["id_credencial"];
		$datos_acepto = $consultaegresado->aceptoData($id_credencial_e);
		echo json_encode($datos_acepto ? 1 : 2);
		break;

	
		case 'guardardata':

		$data = array();
		$data["estado"] = "";


		$aceptodata = 0;
		$id_credencial = isset($_POST['id_credencial_e']) ? limpiarCadena($_POST['id_credencial_e']) : "";
		$rspta = $consultaegresado->insertardata($id_credencial, $aceptodata, $fecha);
		$datos = $rspta ? "si" : "no";

		$data["credencial"] = $id_credencial;

		$data["estado"] = $datos;
		echo json_encode($data);
		break;

	
		case 'listar':
		$datos = $consultaegresado->listar($id_credencial);
		echo json_encode($datos);
	break;


	// case 'mostrar_caracters':

	// 	$egresados = $consultaegresado->programasnivel3_C();

	// 	$data = array();

	// 	foreach ($egresados as $i => $egresado) {
	// 		$programa = $egresado["fo_programa"];
	// 		$numero_celular = '57' . $egresado["celular"];

	// 		$egresados_tiene_hijos = $egresado["egresados_tiene_hijos"];
	// 		$egresados_num_hijos = $egresado["egresados_num_hijos"];
	// 		$egresados_trabaja = $egresado["egresados_trabaja"];
	// 		$egresados_tipo_trabajador = $egresado["egresados_tipo_trabajador"];
	// 		$egresados_empresa = $egresado["egresados_empresa"];
	// 		$egresados_sector_empresa = $egresado["egresados_sector_empresa"];
	// 		$egresados_cargo = $egresado["egresados_cargo"];
	// 		$egresados_profesion = $egresado["egresados_profesion"];
	// 		$egresados_salario = $egresado["egresados_salario"];
	// 		$egresados_estudio_adicional = $egresado["egresados_estudio_adicional"];
	// 		$egresados_formacion = $egresado["egresados_formacion"];
	// 		$egresados_tipo_formacion = $egresado["egresados_tipo_formacion"];
	// 		$egresados_informacion = $egresado["egresados_informacion"];
	// 		$egresados_posgrado = $egresado["egresados_posgrado"];
	// 		$egresados_colaborativa = $egresado["egresados_colaborativa"];
	// 		$egresados_actualizacion = $egresado["egresados_actualizacion"];
	// 		$egresados_recomendar = $egresado["egresados_recomendar"];

	// 		$nombre_estudiante = trim(
	// 			($egresado["credencial_nombre"] ?? '') . " " .
	// 				($egresado["credencial_nombre_2"] ?? '') . " " .
	// 				($egresado["credencial_apellido"] ?? '') . " " .
	// 				($egresado["credencial_apellido_2"] ?? '')
	// 		);
			



	// 		$datosestudiante = $consultaegresado->datosestudiante_C($egresado["id_estudiante"]); // datos estudiante

	// 		$data[] = array(
	// 			"0" => $nombre_estudiante,
	// 			"1" => '<div class="tooltips">' . $datosestudiante["celular"] . '<span class="tooltiptext">' . "_____" . ' ' . $datosestudiante["telefono"] . '</span></div>',
	// 			"2" => $datosestudiante["email"],
	// 			"3" => $programa,
	// 			"4" => $egresados_tiene_hijos,
	// 			"5" => $egresados_num_hijos,
	// 			"6" => $egresados_trabaja,
	// 			"7" => $egresados_tipo_trabajador,
	// 			"8" => $egresados_empresa,
	// 			"9" => $egresados_sector_empresa,
	// 			"10" => $egresados_cargo,
	// 			"11" => $egresados_profesion,
	// 			"12" => $egresados_salario,
	// 			"13" => $egresados_estudio_adicional,
	// 			"14" => $egresados_formacion,
	// 			"15" => $egresados_tipo_formacion,
	// 			"16" => $egresados_informacion,
	// 			"17" => $egresados_posgrado,
	// 			"18" => $egresados_colaborativa,
	// 			"19" => $egresados_actualizacion,
	// 			"20" => $egresados_recomendar
	// 		);
	// 	}

	// 	$results = array(
	// 		"sEcho" => 1, // Información para el datatables
	// 		"iTotalRecords" => count($data), // Enviamos el total registros al datatable
	// 		"iTotalDisplayRecords" => count($data), // Enviamos el total registros a visualizar
	// 		"aaData" => $data
	// 	);
	// 	echo json_encode($results);
	// break;


	case 'listarcaracterizacion':

		$egresados = $consultaegresado->trercaracterizacion();

		$data = array();

		// Diccionarios para traducción
		$mapa_situacion_laboral = [
			"1" => "Empleado a tiempo completo",
			"2" => "Empleado a tiempo parcial",
			"3" => "Emprendedor",
			"4" => "Desempleado buscando empleo",
			"5" => "Desempleado no buscando empleo",
			"6" => "Estudiando",
			"7" => "Voluntario"
		];
		$mapa_relacion_campo_estudio = [
			"1" => "Directamente relacionado",
			"2" => "Parcialmente relacionado",
			"3" => "No relacionado",
			"4" => "No aplica"
		];
		$mapa_aporte_ciaf = [
			"1" => "Poco",
			"2" => "Algo",
			"3" => "Mucho"
		];
		$mapa_preparacion_laboral = [
			"1" => "No adecuadamente",
			"2" => "Parcialmente",
			"3" => "Sí, adecuadamente",
			"4" => "Sí, muy adecuadamente"
		];
		$mapa_tipo_emprendimiento = [
			"1" => "Servicios",
			"2" => "Productos",
			"3" => "Startup tecnológico",
			"4" => "Proyecto social/cultural",
			"5" => "Freelance",
			"6" => "Otro",
			"7" => "No aplica"
		];
		$mapa_ingreso_mensual = [
			"1" => "Menos de 1 SMMLV",
			"2" => "Entre 1 y 2 SMMLV",
			"3" => "Entre 2 y 3 SMMLV",
			"4" => "Más de 3 SMMLV",
			"5" => "Prefiero no responder"
		];
		$mapa_estado_posgrado = [
			"1" => "Ya completé un posgrado",
			"2" => "Actualmente cursando un posgrado",
			"3" => "Tengo planes en 1-2 años",
			"4" => "Planes a largo plazo",
			"5" => "No tengo planes"
		];

		$mapa_satisfaccion_formacion = [
			"1" => "Muy insatisfecho",
			"2" => "Insatisfecho",
			"3" => "Neutral",
			"4" => "Satisfecho",
			"5" => "Muy satisfecho"
		];
		$mapa_capacitaciones_complementarias = [
			"1" => "Cursos de software",
			"2" => "Cursos de idiomas",
			"3" => "Seminarios / talleres",
			"4" => "Diplomados / certificaciones",
			"5" => "Habilidades blandas",
			"6" => "Ninguno",
			"7" => "Otro"
		];
		$mapa_habilidades_utiles = [
			"1" => "Pensamiento crítico",
			"2" => "Comunicación efectiva",
			"3" => "Trabajo en equipo",
			"4" => "Liderazgo",
			"5" => "Conocimientos técnicos",
			"6" => "Adaptación y aprendizaje",
			"7" => "Ética profesional",
			"8" => "Gestión del tiempo",
			"9" => "otro"
		];
		$mapa_sugerencias_plan_estudio = [
			"1" => "Habilidades digitales",
			"2" => "Emprendimiento",
			"3" => "Habilidades blandas",
			"4" => "Idiomas",
			"5" => "Sostenibilidad",
			"6" => "Análisis de datos",
			"7" => "Finanzas personales",
			"8" => "Plan actual es adecuado",
			"9" => "Otro"
		];
		$mapa_formas_conexion = [
			"1" => "Recibir información",
			"2" => "Mentoría",
			"3" => "Charlas",
			"4" => "Investigación",
			"5" => "Talleres",
			"6" => "Ferias de empleo",
			"7" => "Apoyo financiero",
			"8" => "No me interesa",
			"9" => "Otro"
		];
		$mapa_servicios_utiles = [
			"1" => "Bolsa de empleo",
			"2" => "Educación continua",
			"3" => "Networking y eventos",
			"4" => "Asesoría profesional",
			"5" => "Acceso a instalaciones",
			"6" => "Publicaciones",
			"7" => "Club de egresados",
			"8" => "Ninguno",
			"9" => "Otro"
		];

		$mapa_disposicion_participar = [
			"1" => "Sí, activamente",
			"2" => "Sí, ocasionalmente",
			"3" => "Tal vez",
			"4" => "No"
		];
		$mapa_canal_contacto_preferido = [
			"1" => "WhatsApp",
			"2" => "Correo electrónico",
			"3" => "Redes sociales",
			"4" => "No deseo recibir información"
		];
		$mapa_red_social_activa = [
			"1" => "Facebook",
			"2" => "Instagram",
			"3" => "LinkedIn",
			"4" => "TikTok",
			"5" => "Otra"
		];
		$mapa_grupo_etnicos = [
			"1" => "Indígena",
			"2" => "Afrodescendiente",
			"3" => "Raizal",
			"4" => "Palenquero/a",
			"5" => "Gitano/a (Rom)",
			"6" => "Comunidad LGBTIQ+",
			"7" => "Víctima de conflicto armado",
			"8" => "Persona migrante",
			"9" => "Ninguno de los anteriores",
			"10" => "Prefiero no responder",
			"11" => "Otro"
		];
		$mapa_tiene_discapacidad = [
			"1" => "Sí",
			"0" => "No",
		];
		$mapa_estrato_socioeconomico = [
			"1" => "1",
			"2" => "2",
			"3" => "3",
			"4" => "4",
			"5" => "5",
			"6" => "6"
		];


		foreach ($egresados as $egresado) {

			$datos_estudiante = $consultaegresado->datosestudiante($egresado["id_credencial"]);
			$cedula = $datos_estudiante["credencial_identificacion"] ?? 'N/A';
			$correo_ciaf = $datos_estudiante["credencial_login"] ?? 'N/A';
			$nombre = ($datos_estudiante["credencial_nombre"] ?? '') . ' ' .($datos_estudiante["credencial_nombre_2"] ?? '') . ' ' .($datos_estudiante["credencial_apellido"] ?? '') . ' ' .($datos_estudiante["credencial_apellido_2"] ?? '');

			$data[] = array(

				$cedula,
				$correo_ciaf,
				$nombre,
				$egresado["vida_graduado"],
				$egresado["significado_egresado"],
				$consultaegresado->traducirBinario($egresado["familiares_estudian_ciaf"]),
				$consultaegresado->traducirBinario($egresado["tiene_hijos"]),
				$consultaegresado->traducirUnico($egresado["situacion_laboral"], $mapa_situacion_laboral),
				$consultaegresado->traducirUnico($egresado["relacion_campo_estudio"], $mapa_relacion_campo_estudio),
				$consultaegresado->traducirUnico($egresado["aporte_ciaf"], $mapa_aporte_ciaf),
				$consultaegresado->traducirUnico($egresado["preparacion_laboral"], $mapa_preparacion_laboral),
				$consultaegresado->traducirUnico($egresado["tipo_emprendimiento"], $mapa_tipo_emprendimiento),
				$egresado["tipo_emprendimiento_otro"],
				$consultaegresado->traducirUnico($egresado["ingreso_mensual"], $mapa_ingreso_mensual),
				$consultaegresado->traducirUnico($egresado["estado_posgrado"], $mapa_estado_posgrado),
				$consultaegresado->traducirArreglo($egresado["capacitaciones_complementarias"], $mapa_capacitaciones_complementarias),
				$egresado["capacitaciones_otro"],
				$consultaegresado->traducirArreglo($egresado["habilidades_utiles"], $mapa_habilidades_utiles),
				$egresado["habilidades_otro"],
				$consultaegresado->traducirArreglo($egresado["sugerencias_plan_estudio"], $mapa_sugerencias_plan_estudio),
				$egresado["sugerencias_otro"],
				$consultaegresado->traducirUnico($egresado["satisfaccion_formacion"], $mapa_satisfaccion_formacion),
				$consultaegresado->traducirArreglo($egresado["formas_conexion"], $mapa_formas_conexion),
				$egresado["formas_conexion_otro"],
				$consultaegresado->traducirArreglo($egresado["servicios_utiles"], $mapa_servicios_utiles),
				$egresado["servicios_utiles_otro"],
				$consultaegresado->traducirUnico($egresado["disposicion_participar"], $mapa_disposicion_participar),
				$consultaegresado->traducirUnico($egresado["canal_contacto_preferido"], $mapa_canal_contacto_preferido),
				$consultaegresado->traducirBinario($egresado["recomendaria_ciaf"]),
				$egresado["celular"],
				$egresado["correo"],
				$consultaegresado->traducirUnico($egresado["red_social_activa"], $mapa_red_social_activa),
				$egresado["nombre_red_social"],
				$egresado["usuario_red_social"],
				$consultaegresado->traducirUnico($egresado["grupo_etnicos"], $mapa_grupo_etnicos),
				$egresado["grupo_etnico_otro"],
				$consultaegresado->traducirBinario($egresado["tiene_discapacidad"], $mapa_tiene_discapacidad),
				$egresado["descripcion_discapacidad"],
				$consultaegresado->traducirBinario($egresado["primer_profesional"]),
				$consultaegresado->traducirUnico($egresado["estrato_socioeconomico"], $mapa_estrato_socioeconomico)
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



	case 'ListarProgramaSeleccionado':
		$programa_seleccionado = $_GET["programa_seleccionado"];
		$programas = [
			1 => "Administración",
			2 => "Contaduría",
			3 => "Nivel 3 - Profesional en Seguridad y Salud en el Trabajo",
			4 => "Software",
			5 => "Industrial"
		];
		$nombre_programa = isset($programas[$programa_seleccionado]) ? $programas[$programa_seleccionado] : "";
		$egresados = $consultaegresado->listarporprogramaterminal($nombre_programa);
		
		$data = array();
		foreach ($egresados as $i => $egresado) {
			$estado = $egresado["estado"];
			$programa = $egresado["fo_programa"];
			$numero_celular = '57' . $egresado["celular"];
			$nombre_estudiante = trim(
				($egresado["credencial_nombre"] ?? '') . " " .
					($egresado["credencial_nombre_2"] ?? '') . " " .
					($egresado["credencial_apellido"] ?? '') . " " .
					($egresado["credencial_apellido_2"] ?? '')
			);
			$estado_nombre = ($estado == 2) ? '<span class="badge badge-primary p-1">Graduado</span>' : '<span class="badge badge-success p-1">Egresado</span>';
			$folio = $egresado["folio"] ?? 'No tiene folio'; // Obtener folio, manejar casos nulos

			$data[] = array(
				"0" => '<div>' . $egresado["credencial_identificacion"] . ' </div>',
				"1" => $nombre_estudiante,
				"2" => '<div class="tooltips">' . $egresado["celular"] . '<span class="tooltiptext">' . "_____" . ' ' . $egresado["telefono"] . '</span></div>',
				"3" => $egresado["email"],
				"4" => $egresado["credencial_login"],
				"5" => $programa,
				"6" => $egresado["jornada_e"],
				"7" => $estado_nombre,
				"8" => $folio, // Mostrar folio aquí
				"9" => $egresado["periodo_activo"],
			);
		}

		$results = array(
			"sEcho" => 1, // Información para el datatables
			"iTotalRecords" => count($data), // Enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), // Enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
		case 'mostrar_total_por_programa':
			$egresados = $consultaegresado->listarPorProgramasTerminalContar();
			// lista de programas
			$nombresProgramas = ['Administración', 'CONTADURIA', 'Nivel 3 - Profesional en Seguridad y Salud en el Trabajo', 'Software', 'Industrial','Todos'];
			$data = array();
			for ($i = 0; $i < count($nombresProgramas); $i++) {
				$data[$nombresProgramas[$i]] = 0;
			}
			for ($i = 0; $i < count($egresados); $i++) {
				$nombrePrograma = ($egresados[$i]['fo_programa']);
				for ($j = 0; $j < count($nombresProgramas); $j++) {
					$palabra_econtrada = ($nombresProgramas[$j]);
					if ($palabra_econtrada !== 'Todos' && stripos($nombrePrograma, $palabra_econtrada) !== false) {
						$data[$palabra_econtrada]++;
						$data['Todos']++; // <--- Aquí se suma al total general
						break;
					}
				}
			}

			echo json_encode($data);
	break;

}
