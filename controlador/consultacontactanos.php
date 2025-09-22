<?php
session_start();
require_once "../modelos/ConsultaContactanos.php";
$consultacontactanos = new ConsultaContactanos();

switch ($_GET['op']) {
	// Función para cargar los programas activos y mostrarlos en el selector de programa
	case 'cargarDependencias':
		$cargar_selector_dependencias = $consultacontactanos->cargarDependencias();
		$resultado = $cargar_selector_dependencias;
		$data = array();
		// Bucle para recorrer el resultado y almacenarlo en un array
		for ($i = 0; $i < count($resultado); $i++) {
			// Cargar datos del programa
			//$id_programa = $resultado[$i]['id_programa'];
			$id_usuario = $resultado[$i]['id_usuario'];
			$nombre = $resultado[$i]['usuario_cargo'];
			$data[] = array(
				"nombre" => $nombre,
				"id_usuario" => $id_usuario
			);
		}
		echo json_encode($data);
		break;
	// Función para cargar los semestres según el programa que se encuentre seleccionado
	case 'cargarPeriodo':
		$cargar_selector_periodo = $consultacontactanos->cargarPeriodo();
		$resultado = $cargar_selector_periodo;
		$data = array();
		// Bucle para recorrer el resultado y almacenarlo en un array
		for ($i = 0; $i < count($resultado); $i++) {
			// Cargar datos del programa
			//            $id_programa = $resultado[$i]['id_programa'];
			$nombre = $resultado[$i]['periodo'];
			$data[] = array(
				//                "id_programa" => $id_programa,
				"periodo" => $nombre
			);
		}
		echo json_encode($data);
		break;
	// Función para listar los estudiantes a renovar
	case 'listar':
		// Se toman las variables que vienen del get del datatable
		$dependencias = $_GET['dependencias'];
		$periodo = $_GET['periodo'];
		$listar_casos = $consultacontactanos->listar($dependencias, $periodo);
		$resultado = $listar_casos;
		$total_finalizado = 0;
		//Bucle para recorrer el resultado de la consulta listar()
		for ($i = 0; $i < count($resultado); $i++) {

			$total_finalizado = ($resultado[$i]["estado"] == 0) ? $total_finalizado + 1 : $total_finalizado;

			// codigo para calcular el tiempo de respuesta
			$fecha1 = new DateTime($resultado[$i]["fecha_solicitud"] . ' ' . $resultado[$i]["hora_solicitud"]);
			$fecha2 = new DateTime($resultado[$i]["fecha_cierre"] . ' ' . $resultado[$i]["hora_cierre"]);
			$intervalo = $fecha1->diff($fecha2);
			// ****************** //
			$buscarasunto = $consultacontactanos->buscarasunto($resultado[$i]["id_asunto"]); // busca el asunto
			$asunto = $buscarasunto["asunto"];
			$buscaropcionasunto = $consultacontactanos->buscaropcionasunto($resultado[$i]["id_asunto_opcion"]); // busca el asunto
			$opcion = $buscaropcionasunto["opcion"];
			$datosusuario = $consultacontactanos->datosDependencia($resultado[$i]["id_usuario"]);

			$datos_remitido = $consultacontactanos->remiteA($resultado[$i]["id_ayuda"]);
			$reg2 = $datos_remitido;


			$mensaje_info_tooltip = "";
			$mensaje_info_tabla = "";
			$mensaje_info_tabla_estilos = "";
			//determinamos la accion para entrar a saber si es remitido a 
			for ($j = 0; $j < count($reg2); $j++) {
				$rspta3 = $consultacontactanos->datosDependencia($reg2[$j]["id_remite_a"]);
				if ($reg2[$j]["accion"] == 0) {
					$mensaje_info_tabla .= '	
					
					' . $reg2[$j]["mensaje_dependencia"] . '
					</div>
					
					';
				} else {

					$mensaje_info_tabla_estilos .= '' . $reg2[$j]["mensaje_dependencia"] . '
					<div class="alert" style="margin-bottom:0px !important"><center>Caso redirigido <i class="fas fa-exchange-alt"></i>' . ((is_array($rspta3)) ? $rspta3["usuario_cargo"] : "") . ' - ' . $consultacontactanos->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las ' . $reg2[$j]["hora_respuesta"] . ' </center></div>';


					$mensaje_info_tooltip .= '' . $reg2[$j]["mensaje_dependencia"] . '<br>Caso redirigido' . ((is_array($rspta3)) ? $rspta3["usuario_cargo"] : "") . ' - ' . $consultacontactanos->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las ' . $reg2[$j]["hora_respuesta"] . '<br>';
				}

				$mensaje_info_tabla .= '  
				</div>
				<!-- /.direct-chat-msg -->';
			}
			// ajuste para mosrtar el mensaje en un tooltip
			// $mensaje_toltip = '<div class="expandir_texto" data-toggle="tooltip" data-html="true" title="' . htmlspecialchars($mensaje_info_tooltip.$mensaje_info_tabla) . '" style="height:50px; overflow:hidden; cursor:pointer;">' . ($mensaje_info_tabla_estilos.$mensaje_info_tabla) . '</div>';
			// --- construir el texto completo ---

			$limite = 20;
			// HISTORIAL
			$historial_texto_completo = html_entity_decode(strip_tags($mensaje_info_tabla), ENT_QUOTES, 'UTF-8');
			$historial_texto_completo = preg_replace('/\s+/u', ' ', trim($historial_texto_completo));
			if (mb_strlen($historial_texto_completo, 'UTF-8') > $limite) {
				$historial_texto_corto = mb_substr($historial_texto_completo, 0, $limite, 'UTF-8') . '...';
			} else {
				$historial_texto_corto = $historial_texto_completo;
			}
			$mensaje_toltip = '<div class="expandir_texto" data-toggle="tooltip" data-html="true" title="' . htmlspecialchars($mensaje_info_tooltip . $mensaje_info_tabla) . '" style="cursor:pointer;">' . ($mensaje_info_tabla_estilos . $historial_texto_corto) . '</div>';
			//MENSAJE
			$mensaje = $resultado[$i]['mensaje'];
			$mensaje_texto_completo = html_entity_decode(strip_tags($mensaje), ENT_QUOTES, 'UTF-8');
			$mensaje_texto_completo = preg_replace('/\s+/u', ' ', trim($mensaje_texto_completo));
			if (mb_strlen($mensaje_texto_completo, 'UTF-8') > $limite) {
				$mensaje_corto = mb_substr($mensaje_texto_completo, 0, $limite, 'UTF-8') . '...';
			} else {
				$mensaje_corto = $mensaje_texto_completo;
			}
			// ajuste para mosrtar el mensaje en un tooltip
			$mensaje = '<div class="expandir_texto" data-toggle="tooltip" data-html="true" title="' . htmlspecialchars($mensaje_texto_completo, ENT_QUOTES, 'UTF-8') . '" style="cursor:pointer;">' . htmlspecialchars($mensaje_corto, ENT_QUOTES, 'UTF-8') . '</div>';
			// $mensaje = '<div class="expandir_texto" data-toggle="tooltip" data-html="true" title="' . htmlspecialchars($resultado[$i]["mensaje"]) . '" style="height:50px; overflow:hidden; cursor:pointer;">' . $resultado[$i]["mensaje"] . '</div>';
			// mostramos el boton de whastapp
			$celular_estudiante = $consultacontactanos->traerCelularEstudiante($resultado[$i]["id_credencial"]);
			$mensajes_no_vistos = 0;
			if (isset($celular_estudiante["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $celular_estudiante["celular"];
				$registro_whatsapp = $consultacontactanos->obtenerRegistroWhastapp($numero_celular);
				$mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}
			$boton_whatsapp = '
		<button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
			<i class="fab fa-whatsapp"></i>
			<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
				' . $mensajes_no_vistos . '
			</span>
		</button>';


			$data[] = array(
				"0" => $boton_whatsapp,
				"1" => $asunto,
				"2" => $opcion,
				"3" => $mensaje,
				"4" => $mensaje_toltip,
				"5" => '<small>' . $consultacontactanos->fechaesp($resultado[$i]["fecha_solicitud"]) . '</small>',
				"6" => $datosusuario["usuario_cargo"],
				"7" => $resultado[$i]["periodo_ayuda"],
				"8" => ($resultado[$i]["estado"] == 1) ?
					'<a onclick=verAyudaTerminado(' . $resultado[$i]["id_ayuda"] . ') class="btn btn-danger btn-xs btn-block text-white">
						<i class="fas fa-exclamation"></i> Pendiente
					</a>' :
					'<a onclick=verAyudaTerminado(' . $resultado[$i]["id_ayuda"] . ') class="btn btn-success btn-xs btn-block text-white">
						<i class="fas fa-eye"></i> Finalizado
					</a>',
				"9" => '<small>' . $consultacontactanos->fechaesp($resultado[$i]["fecha_cierre"]) . '</small>',
				"10" => ($resultado[$i]["estado"] == 0) ? '<small>' . $intervalo->format(' %m mes %d dias %Hh %im') . '</small>' :
					''
			);
		}
		$data = isset($data) ? $data : array();
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data,
			"totalFinalizado" => $total_finalizado,
			"totalPendientes" => $i - $total_finalizado
		);
		echo json_encode($results);
		break;


	case 'verAyudaTerminado':
		$id_ayuda = $_POST["id_ayuda"];
		$rspta = $consultacontactanos->verAyuda($id_ayuda);
		$reg = $rspta;
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo



		for ($i = 0; $i < count($reg); $i++) {
			$nombre1 = $reg[$i]["credencial_nombre"];
			$nombre2 = $reg[$i]["credencial_nombre_2"];
			$apellido1 = $reg[$i]["credencial_apellido"];
			$apellido2 = $reg[$i]["credencial_apellido_2"];
			$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;

			$buscarasunto = $consultacontactanos->buscarasunto($reg[$i]["id_asunto"]); // busca el asunto
			$asunto = $buscarasunto["asunto"];

			$buscaropcionasunto = $consultacontactanos->buscaropcionasunto($reg[$i]["id_asunto_opcion"]); // busca el asunto
			$opcion = $buscaropcionasunto["opcion"];

			$data["0"] .= '
			<div class="col-md-12">
			<div class="box box-primary direct-chat direct-chat-primary">
				<div class="box-header with-border">
				<h3 class="box-title">' . $asunto . '</h3>
				<span>' . $opcion . '</span>

				</div>
				<!-- /.box-header -->
				<div class="box-body" style="overflow-x:none !important">
				<!-- Conversations are loaded here -->
				<div class="direct-chat-messages" style="height:auto !important">
					<!-- Message. Default to the left -->
					<div class="direct-chat-msg">
					<div class="direct-chat-info clearfix">
						<span class="direct-chat-name pull-left">' . $nombre_completo . '</span><br>
						<small><span class="direct-chat-timestamp">' . $consultacontactanos->fechaesp($reg[$i]["fecha_solicitud"]) . ' a las: ' . $reg[$i]["hora_solicitud"] . ' Del: ' . $reg[$i]["periodo_ayuda"] . '</span></small>
					</div>';

			if (file_exists('../files/estudiantes/' . $reg[$i]['credencial_identificacion'] . '.jpg')) {
				$data["0"] .= '<img src=../files/estudiantes/' . $reg[$i]['credencial_identificacion'] . '.jpg class=direct-chat-img>';
			} else {
				$data["0"] .= '<img src=../files/null.jpg class=direct-chat-img>';
			}

			$data["0"] .= '	
						<div class="direct-chat-text">
							' . $reg[$i]["mensaje"] . '
						</div>
					</div>';
			// hasta esta parte son las preguntas ///

			// ahora siguen las respuestas
			$rspta2 = $consultacontactanos->listarRespuesta($reg[$i]["id_ayuda"]);
			$reg2 = $rspta2;
			for ($j = 0; $j < count($reg2); $j++) {
				$datosusuario = $consultacontactanos->datosDependencia($reg2[$j]["id_usuario"]);
				error_reporting(0);
				$data["0"] .= '	
				
				<div class="direct-chat-msg right">
					<div class="direct-chat-info clearfix">
						<span class="direct-chat-name pull-right">' . $datosusuario["usuario_cargo"] . '</span><br>
						<small><span class="direct-chat-timestamp pull-left">' . $consultacontactanos->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las: ' . $reg2[$j]["hora_respuesta"] . ' Del: ' . $reg2[$j]["periodo_respuesta"] . '</span></small>
					</div>';


				$rspta3 = $consultacontactanos->datosDependencia($reg2[$j]["id_remite_a"]);

				if (file_exists('../files/usuarios/' . $datosusuario['usuario_imagen'])) {
					$data["0"] .= '<img src=../files/usuarios/' . $datosusuario['usuario_imagen'] . ' class=direct-chat-img>';
				} else {
					$data["0"] .= '<img src=../files/null.jpg class=direct-chat-img>';
				}

				if ($reg2[$j]["accion"] == 0) {
					$data["0"] .= '	
							<div class="direct-chat-text">
							' . $reg2[$j]["mensaje_dependencia"] . '
							</div>
							<!-- /.direct-chat-text -->
							';
				} else {

					$data["0"] .= '
						<div class="direct-chat-text alert alert-warning">
						' . $reg2[$j]["mensaje_dependencia"] . '
						</div>
						<div class="alert" style="margin-bottom:0px !important"><center>Caso redirigido <i class="fas fa-exchange-alt"></i>' . $rspta3["usuario_cargo"] . ' - ' . $consultacontactanos->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las ' . $reg2[$j]["hora_respuesta"] . ' </center></div>
						<!-- /.direct-chat-text -->
						';
				}
				$data["0"] .= '  
					</div>
					<!-- /.direct-chat-msg -->
				
				';

				// ******************************** //

			}
		}

		$results = array($data);
		echo json_encode($results);
		break;
}
