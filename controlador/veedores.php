<?php
require_once "../modelos/Veedores.php";
// enviar correo a estudiante.
require "../mail/sendVeedores.php";
require "../mail/template_veedores.php";

$veedores = new Veedores();
$op = (isset($_GET['op'])) ? $_GET['op'] : 'mostrar';

$fecha = date('Y-m-d');
$hora = date('H:i:s');
$ip_publica = $_SERVER['REMOTE_ADDR'];

switch ($op) {
		//consulta y verifica el estudiante buscado por el input del filtro.
	case 'verificar_estudiante':
		$dato = $_POST["dato"];
		$tipo = $_POST["tipo"];
		$valor_seleccionado = '';
		$id_credencial_cedula = "";
		if ($tipo == "1") {
			$valor_seleccionado = 'credencial_identificacion =' . $dato;
			$verificar_cedula = $veedores->verificarDocumento($valor_seleccionado);
			$id_credencial_cedula = !empty($verificar_cedula['id_credencial']) ? $verificar_cedula['id_credencial'] : null;
		}
		if ($tipo == "2") {
			$verificar_cedula = $veedores->buscar_por_nombre($dato); // No es necesario agregar comodines aquí
			$id_credencial_cedula = !empty($verificar_cedula['id_credencial']) ? $verificar_cedula['id_credencial'] : null;
		}
		// consulta para validar el estudiante si esta registrado 
		if (is_array($verificar_cedula)) {
			$informacion_carrera = $veedores->cargarInformacion($id_credencial_cedula);
			$data = array("exito" => 1, "info" => $verificar_cedula);
			$jornada = "";
			$semestre_estudiante = "";
			$id_estudiante = "";
			$perido = "";
			$id_programa_ac = "";
			foreach ($informacion_carrera as $programa) {

				// $jornada = $programa['jornada_e'];
				$id_estudiante = $programa['id_estudiante'];

				$perido = $programa['periodo_activo'];
				$jornada = $programa['jornada_e'];
				$id_programa_ac = $programa['id_programa_ac'];

				$semestre_estudiante = $programa['semestre_estudiante'];
			}

			$data["info"]["jornada"] = $jornada;
			$data["info"]["semestre_estudiante"] = $semestre_estudiante;
			$data["info"]["id_estudiante"] = $id_estudiante;
			$data["info"]["perido"] = $perido;
			$data["info"]["id_programa_ac"] = $id_programa_ac;
		} else {
			$data = array("exito" => 0, "info" => "El estudiante no existe");
		}
		echo json_encode($data);
		break;

		//Funcion para enviar el correo al estudiante sobre el desafio de liderazgo.
	case 'enviar_correo':

		$global_id_credencial = isset($_POST['global_id_credencial']) ? $_POST['global_id_credencial'] : 0;
		$global_id_estudiante = isset($_POST['global_id_estudiante']) ? $_POST['global_id_estudiante'] : 0;
		$global_semestre_estudiante = isset($_POST['global_semestre_estudiante']) ? $_POST['global_semestre_estudiante'] : 0;
		$global_credencial_login = isset($_POST['global_credencial_login']) ? $_POST['global_credencial_login'] : 0;
		$global_id_programa_ac = isset($_POST['global_id_programa_ac']) ? $_POST['global_id_programa_ac'] : 0;
		$global_perido = isset($_POST['global_perido']) ? $_POST['global_perido'] : '';
		$global_jornada = isset($_POST['global_jornada']) ? $_POST['global_jornada'] : '';
		$global_perido = empty($global_perido) ? 0 : $global_perido;
		$global_jornada = empty($global_jornada) ? 0 : $global_jornada;
		$global_id_estudiante = empty($global_id_estudiante) ? 0 : $global_id_estudiante;
		$global_id_programa_ac = empty($global_id_programa_ac) ? 0 : $global_id_programa_ac;
		$global_semestre_estudiante = empty($global_semestre_estudiante) ? 0 : $global_semestre_estudiante;
		$existe_registro = $veedores->verificarExistenciaIdCredencial($global_id_credencial);

		if (!$existe_registro) {
			// Si no existe un registro con el mismo id_credencial, procede a insertar el nuevo proveedor
			$registrar_veedores = $veedores->insertarveedores($global_id_credencial, $global_id_estudiante, $global_perido, $global_jornada, $global_id_programa_ac, $global_semestre_estudiante, $fecha, $hora, $ip_publica);
			$contenido = set_template_veedores($global_id_estudiante);
			enviar_correo($global_credencial_login, "¡Desafío de liderazgo! ¿Estás listo para crear experiencias extraordinarias?", $contenido);

			$data = array("exito" => "1", "info" => "El correo se envió correctamente");
		} else {
			// Si ya existe un registro con el mismo id_credencial, muestra un mensaje de error o realiza alguna otra acción
			$data = array("exito" => "0", "info" => "Ya está registrado.");
		}
		echo json_encode($data);
		break;


	case 'listar_datos_estudiantes_filtrado':
		// $idCredencial = isset($_GET['id_credencial']) ? $_GET['id_credencial'] : null; #idcredencial estudiante
		$valor = isset($_GET['valor_global']) ? $_GET['valor_global'] : null; #dependiendo del numero trae los datos
		$dato = isset($_GET['dato']) ? $_GET['dato'] : null; #palabra buscada en el filtro

		if ($valor == "2") {
			$registro = $veedores->buscar_por_nombre($dato);
		
		}
		$data = array();
		// print_r($registro);
		for ($i = 0; $i < count($registro); $i++) {
			$id_credencial_seleccionado = $registro[$i]['id_credencial'];
			$credencial_login_seleccionado = $registro[$i]['credencial_login'];
			$data[] = array(
				'0' => '<div class="col-xl-12 col-lg-12 col-md-12 col-12 px-3 pb-2 mt-4" onclick="enviarcorreopornombre(' . $id_credencial_seleccionado . ',`' . $credencial_login_seleccionado . '`)" id="tour_btn_enviar">
                        <button class="btn border border-success titulo-2 fs-12 text-semibold" title="Enviar Invitación">
                        <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>',
				'1' => $registro[$i]['credencial_identificacion'],
				'2' => $registro[$i]['credencial_apellido'] . ' ' . $registro[$i]['credencial_apellido_2'],
				'3' => $registro[$i]['credencial_nombre'] . ' ' . $registro[$i]['credencial_nombre_2']
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




		case 'registrar_por_nombre_veevdor':
			$dato = $_POST["dato"];
			$tipo = $_POST["tipo"];
			$valor_seleccionado = '';
			$id_credencial_cedula = "";
			if ($tipo == "1") {
				$valor_seleccionado = 'credencial_identificacion =' . $dato;
				$verificar_cedula = $veedores->verificarDocumento($valor_seleccionado);
				$id_credencial_cedula = !empty($verificar_cedula['id_credencial']) ? $verificar_cedula['id_credencial'] : null;
			}
			if ($tipo == "2") {
				$verificar_cedula = $veedores->buscar_por_nombre($dato); // No es necesario agregar comodines aquí
				$id_credencial_cedula = !empty($verificar_cedula['id_credencial']) ? $verificar_cedula['id_credencial'] : null;
			}
			// consulta para validar el estudiante si esta registrado 
			if (is_array($verificar_cedula)) {
				$informacion_carrera = $veedores->cargarInformacion($id_credencial_cedula);
				$data = array("exito" => 1, "info" => $verificar_cedula);
				$jornada = "";
				$semestre_estudiante = "";
				$id_estudiante = "";
				$perido = "";
				$id_programa_ac = "";
				foreach ($informacion_carrera as $programa) {
					$id_estudiante = $programa['id_estudiante'];
					$perido = $programa['periodo_activo'];
					$jornada = $programa['jornada_e'];
					$id_programa_ac = $programa['id_programa_ac'];
					$semestre_estudiante = $programa['semestre_estudiante'];
				}
	
				$data["info"]["jornada"] = $jornada;
				$data["info"]["semestre_estudiante"] = $semestre_estudiante;
				$data["info"]["id_estudiante"] = $id_estudiante;
				$data["info"]["perido"] = $perido;
				$data["info"]["id_programa_ac"] = $id_programa_ac;
			} else {
				$data = array("exito" => 0, "info" => "El estudiante no existe");
			}
			echo json_encode($data);
			break;
			
			case 'enviar_correo_por_nombre':
				$id_credencial_seleccionado = isset($_POST['id_credencial_seleccionado']) ? $_POST['id_credencial_seleccionado'] : "";
				$credencial_login_seleccionado = isset($_POST['credencial_login_seleccionado']) ? $_POST['credencial_login_seleccionado'] : "";

				$informacion_carrera = $veedores->cargarInformacion($id_credencial_seleccionado);
				$jornada = "";
				$semestre_estudiante = "";
				$id_estudiante = "";
				$perido = "";
				$id_programa_ac = "";
				foreach ($informacion_carrera as $programa) {
					$id_estudiante = $programa['id_estudiante'];
					$perido = $programa['periodo_activo'];
					$jornada = $programa['jornada_e'];
					$id_programa_ac = $programa['id_programa_ac'];
					$semestre_estudiante = $programa['semestre_estudiante'];
				}

				$existe_registro = $veedores->verificarExistenciaIdCredencial($id_credencial_seleccionado);
		
				if (!$existe_registro) {
					// Si no existe un registro con el mismo id_credencial, procede a insertar el nuevo proveedor
					$registrar_veedores = $veedores->insertarveedores($id_credencial_seleccionado, $id_estudiante, $perido, $jornada, $id_programa_ac, $semestre_estudiante, $fecha, $hora, $ip_publica);
					$contenido = set_template_veedores($id_credencial_seleccionado);
					enviar_correo($credencial_login_seleccionado, "¡Desafío de liderazgo! ¿Estás listo para crear experiencias extraordinarias?", $contenido);
		
					$data = array("exito" => "1", "info" => "El correo se envió correctamente");
				} else {
					// Si ya existe un registro con el mismo id_credencial, muestra un mensaje de error o realiza alguna otra acción
					$data = array("exito" => "0", "info" => "Ya está registrado.");
				}
				echo json_encode($data);
				break;





}
