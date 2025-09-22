<?php
require_once "../modelos/ConsultaGraduadosGeneral.php";
session_start();

$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

$proyecto = new ConsultaGraduadosGeneral();

$periodo_actual = $_SESSION['periodo_actual'];

$id_credencial = $_SESSION['id_estudiante'];
$id_credencial_estudiante = isset($_POST["id_credencial_estudiante"]) ? limpiarCadena($_POST["id_credencial_estudiante"]) : "";
$egresados_tiene_hijos = isset($_POST["egresados_tiene_hijos"]) ? limpiarCadena($_POST["egresados_tiene_hijos"]) : "";
$egresados_num_hijos = isset($_POST["egresados_num_hijos"]) ? limpiarCadena($_POST["egresados_num_hijos"]) : "";
$egresados_trabaja = isset($_POST["egresados_trabaja"]) ? limpiarCadena($_POST["egresados_trabaja"]) : "";
$egresados_tipo_trabajador = isset($_POST["egresados_tipo_trabajador"]) ? limpiarCadena($_POST["egresados_tipo_trabajador"]) : "";
$egresados_empresa = isset($_POST["egresados_empresa"]) ? limpiarCadena($_POST["egresados_empresa"]) : "";
$egresados_sector_empresa = isset($_POST["egresados_sector_empresa"]) ? limpiarCadena($_POST["egresados_sector_empresa"]) : "";
$egresados_cargo = isset($_POST["egresados_cargo"]) ? limpiarCadena($_POST["egresados_cargo"]) : "";
$egresados_profesion = isset($_POST["egresados_profesion"]) ? limpiarCadena($_POST["egresados_profesion"]) : "";
$egresados_salario = isset($_POST["egresados_salario"]) ? limpiarCadena($_POST["egresados_salario"]) : "";
$egresados_estudio_adicional = isset($_POST["egresados_estudio_adicional"]) ? limpiarCadena($_POST["egresados_estudio_adicional"]) : "";
$egresados_formacion = isset($_POST["egresados_formacion"]) ? limpiarCadena($_POST["egresados_formacion"]) : "";
$egresados_tipo_formacion = isset($_POST["egresados_tipo_formacion"]) ? limpiarCadena($_POST["egresados_tipo_formacion"]) : "";
$egresados_informacion = isset($_POST["egresados_informacion"]) ? limpiarCadena($_POST["egresados_informacion"]) : "";
$egresados_posgrado = isset($_POST["egresados_posgrado"]) ? limpiarCadena($_POST["egresados_posgrado"]) : "";
$egresados_colaborativa = isset($_POST["egresados_colaborativa"]) ? limpiarCadena($_POST["egresados_colaborativa"]) : "";
$egresados_actualizacion = isset($_POST["egresados_actualizacion"]) ? limpiarCadena($_POST["egresados_actualizacion"]) : "";
$egresados_recomendar = isset($_POST["egresados_recomendar"]) ? limpiarCadena($_POST["egresados_recomendar"]) : "";

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
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i');

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


$credencial_nombre=isset($_POST["credencial_nombre"])? limpiarCadena($_POST["credencial_nombre"]):"";
$credencial_nombre_2=isset($_POST["credencial_nombre_2"])? limpiarCadena($_POST["credencial_nombre_2"]):"";
$credencial_apellido=isset($_POST["credencial_apellido"])? limpiarCadena($_POST["credencial_apellido"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$celular=isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$folio=isset($_POST["folio"])? limpiarCadena($_POST["folio"]):"";
$fecha_grado=isset($_POST["fecha_grado"])? limpiarCadena($_POST["fecha_grado"]):"";
$periodo_grado=isset($_POST["periodo_grado"])? limpiarCadena($_POST["periodo_grado"]):"";
$credencial_login=isset($_POST["credencial_login"])? limpiarCadena($_POST["credencial_login"]):"";


switch ($_GET["op"]) {

	case 'listargraduados':

		$ciclo_escuela = $_GET["ciclo_escuela"];
		// lista todos los graduados
		$rspta	= $proyecto->mostrargraduados($ciclo_escuela);
		// print_r($rspta);
		// print_r($rspta);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;

		for ($i = 0; $i < count($reg); $i++) {
			$credencial_nombre = $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' .  $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"];
			$credencial_identificacion =  $reg[$i]["credencial_identificacion"];
			$pruebas_saber_pro = $reg[$i]["pruebas_saber_pro"];
			$fo_programa = $reg[$i]["fo_programa"];
			$email = $reg[$i]["email"];
			$celular = $reg[$i]["celular"];
			$acta_grado = $reg[$i]["acta_grado"];
			$folio = $reg[$i]["folio"];
			$fecha_grado = $reg[$i]["fecha_grado"];
			$periodo_grado = $reg[$i]["periodo_grado"];
			$credencial_login = $reg[$i]["credencial_login"];
			$periodo_ingreso = $reg[$i]["periodo"];
			$id_credencial_estudiante= $reg[$i]["id_credencial"];
			$jornada_e = $reg[$i]["jornada_e"];
			$estado = $reg[$i]["estado"];
			$ciclo = $reg[$i]["ciclo"];
			$periodo_activo = $reg[$i]["periodo_activo"];
			$numero_celular = '57' . $reg["celular"];

			$traertemporada_ingreso = $proyecto->termporada($periodo_ingreso);
			$traertemporada_ingreso["temporada"];

			$traertemporada_grado = $proyecto->termporada($periodo_grado);
			$traertemporada_grado["temporada"];

			$duracion = $traertemporada_grado["temporada"] - $traertemporada_ingreso["temporada"];

			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
								<a onclick="verHistorial(' .$id_credencial_estudiante.')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye" style="color: white;"></i></a>
								<a onclick="agregar_seguimiento_egresado(' .$id_credencial_estudiante . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus" style="color: white;"></i></a>
								<button class="btn btn-warning btn-xs" onclick="mostrar_egresado('.$id_credencial_estudiante  . ')" title="Editar"> <i class="fas fa-pencil-alt"></i> </button>
								<a class="d-none" onclick="enviarnumero(' . $numero_celular . ')" class="btn btn-success btn-xs" title="Enviar Mensaje"><i class="fab fa-whatsapp" style="color: white;"></i></a>
								<a onclick="aceptoData(' .$id_credencial_estudiante  . ')" class="btn btn-info btn-xs" title="caracterización egresado"><i class="fas fa-user" style="color: white;"></i></a>
							</div></div>',
				"1" => $credencial_nombre,
				"2" => $credencial_identificacion,
				"3" => $celular,
				"4" => $pruebas_saber_pro,
				"5" => $fo_programa,
				"6" => $email,
				"7" => $credencial_login,
				"8" => $acta_grado,
				"9" => $folio,
				"10" => $fecha_grado,
				"11" => $periodo_ingreso,
				"12" => $periodo_grado,
				"13" => $duracion,
				"14" => $jornada_e,
				"15" => $estado,
				"16" => $ciclo,
				"17" => $periodo_activo
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


	case 'agregarSeguimiento':
		$rspta = $proyecto->insertarSeguimiento($id_usuario, $id_credencial_tabla, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora);
		echo $rspta ? "Seguimiento registrado" : "Seguimiento no se pudo registrar";
		break;




		//tabla para ver el historial del seguimiento del egresado
	case 'verHistorialTabla':
		$id_credencial_tabla = $_GET["id_credencial_tabla"];

		$rspta = $proyecto->verHistorialSeguimientoEgresados($id_credencial_tabla);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;

		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $proyecto->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];

			$data[] = array(
				"0" => $reg[$i]["id_credencial"],
				"1" => $reg[$i]["motivo_seguimiento"],
				"2" => $reg[$i]["mensaje_seguimiento"],
				"3" => $proyecto->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],
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

		$rspta = $proyecto->verHistorialTareasEgresados($id_credencial_tarea);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;

		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $proyecto->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];

			$data[] = array(
				"0" => $reg[$i]["id_credencial"],
				"1" => $reg[$i]["motivo_tarea"],
				"2" => $reg[$i]["mensaje_tarea"],
				"3" => $proyecto->fechaesp($reg[$i]["fecha_registro"]) . ' a las ' . $reg[$i]["hora_registro"],
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


	case 'agregarTarea':
		$fecha_realizo = NULL;
		$hora_realizo = NULL;
		$rspta = $proyecto->insertarTarea($id_usuario, $id_credencial_tarea, $motivo_tarea, $mensaje_tarea, $fecha, $hora, $fecha_programada, $hora_programada, $fecha_realizo, $hora_realizo, $periodo_actual);
		echo $rspta ? "Tarea Programada" : "Tarea no se pudo Programar";
		break;


		//agregamos el seguimiento para el egresado
	case 'agregarMensaje':

		$fecha_mensaje = date('Y-m-d');
		$hora_mensaje = date('H:i:S');

		$rspta = $proyecto->insertarmensaje($numero_celular, $envio_mensaje, $fecha_mensaje, $hora_mensaje, $id_usuario);
		echo $rspta ? "Mensaje registrado" : "Mensaje no se pudo registrar";
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



	case 'mostrar_egresado':
		$id_credencial = $_POST["id_credencial"];
		$rspta = $proyecto->mostrar_egresado($id_credencial);
		echo json_encode($rspta);
		break;

	case "selectTipoSangre":
		$rspta = $proyecto->selectTipoSangre();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre_sangre"] . "'>" . $rspta[$i]["nombre_sangre"] . "</option>";
		}
		break;




	case "selectDepartamento":
		if ($departamento_nacimiento == "") {
			$rspta = $proyecto->selectDepartamentoMunicipioActivo($id_credencial_oculto);
			$departamento_actual = $rspta["departamento_nacimiento"];
			echo "<option value='" . $departamento_actual . "'>" . $departamento_actual . "</option>";
		}

		$rspta = $proyecto->selectDepartamento();
		echo "<option value='" . $departamento_nacimiento . "'>" . $departamento_nacimiento . "</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
		}
		break;

	case "selectMunicipio":
		$departamento = $_POST["departamento"];
		$rspta = $proyecto->selectMunicipio($departamento);
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
		}
		break;


		case 'editar_estudiante':


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
	
	
			$rspta = $proyecto->EditarEgresado( $credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $genero, $fecha_nacimiento, $departamento_nacimiento,$lugar_nacimiento,$credencial_identificacion,$direccion,$barrio,$telefono,$celular,$tipo_sangre,$email,$grupo_etnico,$nombre_etnico,$instagram,$id_credencial);
			break;




		


	case 'listarPreguntas':

		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$id_credencial_e = $_POST["id_credencial"];
		$pre = $proyecto->listar($id_credencial_e);

		$data["0"] .= '';
		$data["0"] .= '<div class="row">';

		$data["0"] .= '
			
					<div class="row">
						<!-- Sección: Información Personal -->
						<div class="col-12">
							<h6 class="title">Información Personal</h6>
						</div>
			
						<input type="hidden" value="' . $id_credencial_e . '" class="form-control border-start-0" name="id_credencial_estudiante" id="id_credencial_estudiante">
			
						<div class="col-xl-4 col-lg-4 col-md-4  col-12">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_tiene_hijos" id="egresados_tiene_hijos" onchange="mostrarNumHijos(this.value)">
										<option value="no"' . ($pre["egresados_tiene_hijos"] == "no" ? ' selected' : '') . '>No</option>
										<option value="si"' . ($pre["egresados_tiene_hijos"] == "si" ? ' selected' : '') . '>Si</option>
									</select>
									<label>Tienes hijos (si/no)</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12 si_hijos d-none">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_num_hijos" id="egresados_num_hijos">
									<option value="0"' . ($pre["egresados_num_hijos"] == "0" ? ' selected' : '') . '>No aplica</option>
										<option value="1"' . ($pre["egresados_num_hijos"] == "1" ? ' selected' : '') . '>1</option>
										<option value="2"' . ($pre["egresados_num_hijos"] == "2" ? ' selected' : '') . '>2</option>
										<option value="3"' . ($pre["egresados_num_hijos"] == "3" ? ' selected' : '') . '>3 o más</option>
									</select>
									<label>¿Cuántos hijos tienes?</label>
								</div>
							</div>
						</div>
			
						<!-- Sección: Información Laboral -->
						<div class="col-12">
							<h6 class="title">Información Laboral</h6>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_trabaja" id="egresados_trabaja" onchange="mostrarLabora(this.value)">
										<option value="no"' . ($pre["egresados_trabaja"] == "no" ? ' selected' : '') . '>No</option>
										<option value="si"' . ($pre["egresados_trabaja"] == "no" ? ' selected' : '') . '>Si</option>
									</select>
									<label>¿Trabajas actualmente?</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12 si_labora d-none">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_tipo_trabajador" id="egresados_tipo_trabajador">
									<option value="No aplica"' . ($pre["egresados_tipo_trabajador"] == "No aplica" ? ' selected' : '') . '>No aplica</option>
										<option value="Empleado"' . ($pre["egresados_tipo_trabajador"] == "Empleado" ? ' selected' : '') . '>Empleado</option>
										<option value="Independiente"' . ($pre["egresados_tipo_trabajador"] == "Independiente" ? ' selected' : '') . '>Independiente</option>
										<option value="Emprendedor"' . ($pre["egresados_tipo_trabajador"] == "Emprendedor" ? ' selected' : '') . '>Emprendedor</option>
										<option value="Empresario"' . ($pre["egresados_tipo_trabajador"] == "Empresario" ? ' selected' : '') . '>Empresario</option>
										<option value="Freelance"' . ($pre["egresados_tipo_trabajador"] == "Freelance" ? ' selected' : '') . '>Freelance</option>
									</select>
									<label>¿Qué tipo de trabajador eres?</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12 si_labora d-none">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<input type="text" value="' . $pre["egresados_empresa"] . '" class="form-control border-start-0" name="egresados_empresa" id="egresados_empresa" maxlength="100">
									<label>Nombre de la empresa en que laboras</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12 si_labora d-none">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_sector_empresa" id="egresados_sector_empresa">
										<option value="No aplica"' . ($pre["egresados_sector_empresa"] == "No aplica" ? ' selected' : '') . '>No aplica</option>
										<option value="Público"' . ($pre["egresados_sector_empresa"] == "Público" ? ' selected' : '') . '>Público</option>
										<option value="Servicios"' . ($pre["egresados_sector_empresa"] == "Servicios" ? ' selected' : '') . '>Servicios</option>
										<option value="Industrial"' . ($pre["egresados_sector_empresa"] == "Industrial" ? ' selected' : '') . '>Industrial</option>
										<option value="Comercio"' . ($pre["egresados_sector_empresa"] == "Comercio" ? ' selected' : '') . '>Comercio</option>
										<option value="Agropecuario"' . ($pre["egresados_sector_empresa"] == "Agropecuario" ? ' selected' : '') . '>Agropecuario</option>
										<option value="Transporte y/o distribución"' . ($pre["egresados_sector_empresa"] == "Transporte y/o distribución" ? ' selected' : '') . '>Transporte y/o distribución</option>
										<option value="Turismo"' . ($pre["egresados_sector_empresa"] == "Turismo" ? ' selected' : '') . '>Turismo</option>
										<option value="Tecnología"' . ($pre["egresados_sector_empresa"] == "Tecnología" ? ' selected' : '') . '>Tecnología</option>
										<option value="Cultura y entretenimiento"' . ($pre["egresados_sector_empresa"] == "Cultura y entretenimiento" ? ' selected' : '') . '>Cultura y entretenimiento</option>
										<option value="Educación"' . ($pre["egresados_sector_empresa"] == "Educación" ? ' selected' : '') . '>Educación</option>
										<option value="Financiero"' . ($pre["egresados_sector_empresa"] == "Financiero" ? ' selected' : '') . '>Financiero</option>
										<option value="Salud"' . ($pre["egresados_sector_empresa"] == "Salud" ? ' selected' : '') . '>Salud</option>
									</select>
									<label>Sector de la empresa en que laboras</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12 si_labora d-none">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<input type="text" value="' . $pre["egresados_cargo"] . '" class="form-control border-start-0" name="egresados_cargo" id="egresados_cargo" maxlength="100">
									<label>¿Qué cargo desempeñas?</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12 si_labora d-none">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_profesion" id="egresados_profesion">
										<option value="NO"' . ($pre["egresados_profesion"] == "NO" ? ' selected' : '') . '>NO</option>
										<option value="SI"' . ($pre["egresados_profesion"] == "SI" ? ' selected' : '') . '>SI</option>
									</select>
									<label>¿Laboras en el campo de tu profesión?</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12 si_labora d-none" >
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_salario" id="egresados_salario">
										<option value="Ninguno"' . ($pre["egresados_salario"] == "Ninguno" ? ' selected' : '') . '>Ninguno</option>
										<option value="Entre 0 a 1 SMLV"' . ($pre["egresados_salario"] == "Entre 0 a 1 SMLV" ? ' selected' : '') . '>Entre 0 a 1 SMLV</option>
										<option value="De 1 SMLV A 3SMLV"' . ($pre["egresados_salario"] == "De 1 SMLV A 3SMLV" ? ' selected' : '') . '>De 1 SMLV A 3SMLV</option>
										<option value="4 o más SMLC"' . ($pre["egresados_salario"] == "4 o más SMLC" ? ' selected' : '') . '>4 o más SMLC</option>
									</select>
									<label>¿Qué salario mensual devengas?</label>
								</div>
							</div>
						</div>
						
						<div class="col-xl-4 col-lg-4 col-md-4 col-12 ">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<input type="text" value="' . $pre["egresados_estudio_adicional"] . '" class="form-control border-start-0" name="egresados_estudio_adicional" id="egresados_estudio_adicional" maxlength="100">
									<label>¿Qué estudios adicionales requieres para complementar tu perfil profesional?</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_formacion" id="egresados_formacion">
										<option value="NO"' . ($pre["egresados_formacion"] == "NO" ? ' selected' : '') . '>NO</option>
										<option value="SI"' . ($pre["egresados_formacion"] == "SI" ? ' selected' : '') . '>SI</option>
									</select>
									<label>¿Tiene necesidades de formación profesional en este momento?</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-4 col-lg-4 col-md-4 col-12">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<input type="text" value="' . $pre["egresados_tipo_formacion"] . '" class="form-control border-start-0" name="egresados_tipo_formacion" id="egresados_tipo_formacion" maxlength="100">
									<label>Si su respuesta es sí, por favor especifique las necesidades de formación</label>
								</div>
							</div>
						</div>
			
						<!-- Sección: Informacion CIAF -->
						<div class="col-12">
							<h6 class="title">Informacion CIAF</h6>
						</div>
			
						<div class="col-xl-6 col-lg-4 col-md-4 col-12">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_informacion" id="egresados_informacion">
										<option value="Correo"' . ($pre["egresados_informacion"] == "Correo" ? ' selected' : '') . '>Correo</option>
										<option value="Campus virtual"' . ($pre["egresados_informacion"] == "Campus virtual" ? ' selected' : '') . '>Campus virtual</option>
										<option value="Redes sociales"' . ($pre["egresados_informacion"] == "Redes sociales" ? ' selected' : '') . '>Redes sociales</option>
										<option value="Llamada telefónica"' . ($pre["egresados_informacion"] == "Llamada telefónica" ? ' selected' : '') . '>Llamada telefónica</option>
										<option value="WhatsApp"' . ($pre["egresados_informacion"] == "WhatsApp" ? ' selected' : '') . '>WhatsApp</option>
									</select>
									<label>¿Por cuál medio recibes la información institucional de CIAF?</label>
								</div>
							</div>
						</div>
			
			
						<div class="col-xl-6 col-lg-4 col-md-4 col-12">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_posgrado" id="egresados_posgrado">
									<option value="Ninguno"' . ($pre["egresados_posgrado"] == "Ninguno" ? ' selected' : '') . '>Ninguno</option>
										<option value="Diplomado"' . ($pre["egresados_posgrado"] == "Diplomado" ? ' selected' : '') . '>Diplomado</option>
										<option value="Especialización"' . ($pre["egresados_posgrado"] == "Especialización" ? ' selected' : '') . '>Especialización</option>
										<option value="Maestría"' . ($pre["egresados_posgrado"] == "Maestría" ? ' selected' : '') . '>Maestría</option>
										<option value="Doctorado"' . ($pre["egresados_posgrado"] == "Doctorado" ? ' selected' : '') . '>Doctorado</option>
									</select>
									<label>¿En la actualidad se encuentra realizando algún tipo de posgrado?</label>
								</div>
							</div>
						</div>
			
			
						<div class="col-xl-6 col-lg-6 col-md-6 col-12">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_colaborativa" id="egresados_colaborativa">
										<option value="Voluntariado"' . ($pre["egresados_colaborativa"] == "Voluntariado" ? ' selected' : '') . '>Voluntariado</option>
										<option value="Apadrinamiento estudiantil"' . ($pre["egresados_colaborativa"] == "Apadrinamiento estudiantil" ? ' selected' : '') . '>Apadrinamiento estudiantil</option>
										<option value="Comparte la Experiencia"' . ($pre["egresados_colaborativa"] == "Comparte la Experiencia" ? ' selected' : '') . '>Comparte la Experiencia</option>
										<option value="En ninguno"' . ($pre["egresados_colaborativa"] == "En ninguno" ? ' selected' : '') . '>En ninguno</option>
									</select>
									<label>¿Le gustaría participar en alguno de los siguientes programas para fomentar la red colaborativa de egresados CIAF?</label>
								</div>
							</div>
						</div>
			
						<div class="col-xl-6 col-lg-4 col-md-4 col-12">
							<div class="form-group mb-3 position-relative check-valid">
								<div class="form-floating">
									<select class="form-control border-start-0" name="egresados_actualizacion" id="egresados_actualizacion">
										<option value="NO"' . ($pre["egresados_actualizacion"] == "NO" ? ' selected' : '') . '>NO</option>
										<option value="SI"' . ($pre["egresados_actualizacion"] == "SI" ? ' selected' : '') . '>SI</option>
									</select>
									<label>¿Conoces las últimas actualizaciones de CIAF?</label>
								</div>
							</div>
						</div>
			
			
					<div class="col-xl-6 col-lg-4 col-md-4 col-12">
						<div class="form-group mb-3 position-relative check-valid">
							<div class="form-floating">
								<select class="form-control border-start-0" name="egresados_recomendar" id="egresados_recomendar">
									<option value="1"' . ($pre["egresados_recomendar"] == "1" ? ' selected' : '') . '>1</option>
									<option value="2"' . ($pre["egresados_recomendar"] == "2" ? ' selected' : '') . '>2</option>
									<option value="3"' . ($pre["egresados_recomendar"] == "3" ? ' selected' : '') . '>3</option>
									<option value="4"' . ($pre["egresados_recomendar"] == "4" ? ' selected' : '') . '>4</option>
									<option value="5"' . ($pre["egresados_recomendar"] == "5" ? ' selected' : '') . '>5</option>
								</select>
								<label>De 1 a 5, ¿qué tan probable es que recomiendes a CIAF con otra persona?</label>
							</div>
							
						</div>
					</div>';

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
		$data["credencial"] = $id_credencial_estudiante;

		$rspta = $proyecto->editarCaracter(
			$id_credencial_estudiante,
			$egresados_tiene_hijos,
			$egresados_num_hijos,
			$egresados_trabaja,
			$egresados_tipo_trabajador,
			$egresados_empresa,
			$egresados_sector_empresa,
			$egresados_cargo,
			$egresados_profesion,
			$egresados_salario,
			$egresados_estudio_adicional,
			$egresados_formacion,
			$egresados_tipo_formacion,
			$egresados_informacion,
			$egresados_posgrado,
			$egresados_colaborativa,
			$egresados_actualizacion,
			$egresados_recomendar,
			$fecha
		);
		$datos = $rspta ? "si" : "no";

		$data["estado"] = $datos;
		echo json_encode($data);
		break;

	case 'aceptoData':
		$id_credencial_e = $_POST["id_credencial"];
		$datos_acepto = $proyecto->aceptoData($id_credencial_e);
		echo json_encode($datos_acepto ? 1 : 2);
		break;

	case 'guardardata':

		$data = array();
		$data["estado"] = "";


		$aceptodata = 0;
		$id_credencial = isset($_POST['id_credencial_e']) ? limpiarCadena($_POST['id_credencial_e']) : "";
		$rspta = $proyecto->insertardata($id_credencial, $aceptodata, $fecha);
		$datos = $rspta ? "si" : "no";

		$data["credencial"] = $id_credencial;

		$data["estado"] = $datos;
		echo json_encode($data);
		break;

	case 'listar':
		$datos = $proyecto->listar($id_credencial);
		echo json_encode($datos);
		break;


		case 'mostrar_caracter':

			$egresados = $proyecto->programasnivel3_C();
		
			$data = array();
		
			foreach ($egresados as $i => $egresado) {
				$programa = $egresado["fo_programa"];
				$numero_celular = '57' . $egresado["celular"];
		
				$egresados_tiene_hijos = $egresado["egresados_tiene_hijos"];
				$egresados_num_hijos = $egresado["egresados_num_hijos"];
				$egresados_trabaja = $egresado["egresados_trabaja"];
				$egresados_tipo_trabajador = $egresado["egresados_tipo_trabajador"];
				$egresados_empresa = $egresado["egresados_empresa"];
				$egresados_sector_empresa = $egresado["egresados_sector_empresa"];
				$egresados_cargo = $egresado["egresados_cargo"];
				$egresados_profesion = $egresado["egresados_profesion"];
				$egresados_salario = $egresado["egresados_salario"];
				$egresados_estudio_adicional = $egresado["egresados_estudio_adicional"];
				$egresados_formacion = $egresado["egresados_formacion"];
				$egresados_tipo_formacion = $egresado["egresados_tipo_formacion"];
				$egresados_informacion = $egresado["egresados_informacion"];
				$egresados_posgrado = $egresado["egresados_posgrado"];
				$egresados_colaborativa = $egresado["egresados_colaborativa"];
				$egresados_actualizacion = $egresado["egresados_actualizacion"];
				$egresados_recomendar = $egresado["egresados_recomendar"];
		
				$nombre_estudiante = trim(
					($egresado["credencial_nombre"] ?? '') . " " .
					($egresado["credencial_nombre_2"] ?? '') . " " .
					($egresado["credencial_apellido"] ?? '') . " " .
					($egresado["credencial_apellido_2"] ?? '')
				);
		
				$datosestudiante = $proyecto->datosestudiante_C($egresado["id_estudiante"]); // datos estudiante
		
				$data[] = array(
					"0" => $nombre_estudiante,
					"1" => '<div class="tooltips">' . $datosestudiante["celular"] . '<span class="tooltiptext">' . "_____" . ' ' . $datosestudiante["telefono"] . '</span></div>',
					"2" => $datosestudiante["email"],
					"3" => $programa,
					"4" => $egresados_tiene_hijos,
					"5" => $egresados_num_hijos,
					"6" => $egresados_trabaja,
					"7" => $egresados_tipo_trabajador,
					"8" => $egresados_empresa,
					"9" => $egresados_sector_empresa,
					"10" => $egresados_cargo,
					"11" => $egresados_profesion,
					"12" => $egresados_salario,
					"13" => $egresados_estudio_adicional,
					"14" => $egresados_formacion,
					"15" => $egresados_tipo_formacion,
					"16" => $egresados_informacion,
					"17" => $egresados_posgrado,
					"18" => $egresados_colaborativa,
					"19" => $egresados_actualizacion,
					"20" => $egresados_recomendar
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
				$egresados = $proyecto->listarPorProgramasTerminalContar();
			
				$data = [
					"Tecnico Laboral" => 0,
					"Tecnico Profesional" => 0,
					"Tecnologo" => 0,
					"Profesional" => 0,
					"Total General" => count($egresados)
				];
			
				for ($i = 0; $i < count($egresados); $i++) {
					$ciclo = $egresados[$i]['ciclo'];
					if ($ciclo == 7) {
						$data["Tecnico Laboral"]++;
					} elseif ($ciclo == 1) {
						$data["Tecnico Profesional"]++;
					} elseif ($ciclo == 2) {
						$data["Tecnologo"]++;
					} elseif ($ciclo == 3) {
						$data["Profesional"]++;
					}
				}
			
				echo json_encode($data);
				break;
			
			
		
}
