<?php
require_once "../modelos/RemisionContactanos.php";
require('../public/mail/sendAyuda.php'); // modelo que tiene el envio de correo
$remisioncontactanos = new RemisionContactanos();

$id_usuario = $_SESSION['id_usuario'];

$id_ayuda_respuesta = isset($_POST["id_ayuda_respuesta"]) ? limpiarCadena($_POST["id_ayuda_respuesta"]) : "";
$id_credencial = $_SESSION['id_usuario'];
$periodo_actual = $_SESSION['periodo_actual'];
$asunto = isset($_POST["asunto"]) ? limpiarCadena($_POST["asunto"]) : "";
$mensaje = isset($_POST["mensaje"]) ? limpiarCadena($_POST["mensaje"]) : "";
$dependencia = isset($_POST["dependencia"]) ? limpiarCadena($_POST["dependencia"]) : "";

$id_ayuda = isset($_POST["id_ayuda"]) ? limpiarCadena($_POST["id_ayuda"]) : "";
$id_credencial_estudiante = isset($_POST["id_credencial_estudiante"]) ? limpiarCadena($_POST["id_credencial_estudiante"]) : "";
$mensaje_dependencia = isset($_POST["mensaje_dependencia"]) ? limpiarCadena($_POST["mensaje_dependencia"]) : "";
$usuario_dependencia = $_SESSION['usuario_cargo'];

$id_ayuda_caso = isset($_POST["id_ayuda_caso"]) ? limpiarCadena($_POST["id_ayuda_caso"]) : "";
$mensaje_dependencia_remite = isset($_POST["mensaje_dependencia_remite"]) ? limpiarCadena($_POST["mensaje_dependencia_remite"]) : "";
$id_remite_a = isset($_POST["id_remite_a"]) ? limpiarCadena($_POST["id_remite_a"]) : "";

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');

switch ($_GET["op"]) {
	case 'guardaryeditar':
		$rspta = $remisioncontactanos->insertar($id_credencial, $asunto, $mensaje, $fecha, $hora, $dependencia, $periodo_actual);
		echo $rspta ? "Mensaje enviado" : "mensaje no se pudo Enviar";

		break;
	case 'guardarrespuesta':
		$accion = 0; //significa que contesta directamente
		$id_remite_a = 0;
		$rspta = $remisioncontactanos->guardarrespuesta($id_ayuda, $accion, $id_usuario, $id_remite_a, $mensaje_dependencia, $fecha, $hora, $periodo_actual);
		echo $rspta ? "Mensaje enviado" : "mensaje no se pudo Enviar";

		$buscarcorreo = $remisioncontactanos->contacto($id_credencial_estudiante);	// busca los datos del estudiante
		$destino = $buscarcorreo["credencial_login"];	// correo del estudiante	
		$asunto = "Solución caso contáctanos";
		//enviar_correo($destino, $asunto, $mensaje_dependencia);// metodo para enviar correo al estudiante
		echo $destino;
		break;

	case 'guardarrespuestaredireccionar':
		$accion = 1; //significa que remite
		$rspta = $remisioncontactanos->guardarrespuestaredireccionar($id_ayuda_caso, $accion, $id_usuario, $id_remite_a, $mensaje_dependencia_remite, $fecha, $hora, $periodo_actual);
		echo $rspta ? "Mensaje enviado" : "mensaje no se pudo Enviar";


		$buscarcorreo = $remisioncontactanos->datosDependencia($id_remite_a);	// busca los datos de la dependencia
		$destino = $buscarcorreo["usuario_login"];	// correo dependencia
		$asunto = "Remision caso " . $usuario_dependencia;
		//enviar_correo($destino, $asunto, $mensaje_dependencia_remite);// metodo para enviar correo al estudiante
		echo $destino;

		break;



		// case 'mostrar':
		// 	$rspta = $remisioncontactanos->mostrar($id_ayuda);
		// 	//Codificar el resultado utilizando json
		// 	echo json_encode($rspta);
		// 	break;

	case 'verAyuda':
		$id_ayuda = $_POST["id_ayuda"];
		$rspta = $remisioncontactanos->verAyuda($id_ayuda);
		$reg = $rspta;
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo

		for ($i = 0; $i < count($reg); $i++) {
			$nombre1 = $reg[$i]["credencial_nombre"];
			$nombre2 = $reg[$i]["credencial_nombre_2"];
			$apellido1 = $reg[$i]["credencial_apellido"];
			$apellido2 = $reg[$i]["credencial_apellido_2"];
			$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;

			$buscarasunto = $remisioncontactanos->buscarasunto($reg[$i]["id_asunto"]); // busca el asunto
			$asunto = $buscarasunto["asunto"];

			$buscaropcionasunto = $remisioncontactanos->buscaropcionasunto($reg[$i]["id_asunto_opcion"]); // busca el asunto
			$opcion = $buscaropcionasunto["opcion"];

			$data["0"] .= '
		<div class="col-md-12">
          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
              <h3 class="box-title">' . $asunto . '</h3>


            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:inherit !important">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages" style="height:auto !important">
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">' . $nombre_completo . '</span><br>
                    <small><span class="direct-chat-timestamp pull-right">' . $remisioncontactanos->fechaesp($reg[$i]["fecha_solicitud"]) . ' a las: ' . $reg[$i]["hora_solicitud"] . ' Del: ' . $reg[$i]["periodo_ayuda"] . '</span></small>
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
			$rspta2 = $remisioncontactanos->listarRespuesta($reg[$i]["id_ayuda"]);
			$reg2 = $rspta2;
			for ($j = 0; $j < count($reg2); $j++) {

				$datosusuario = $remisioncontactanos->datosDependencia($reg2[$j]["id_usuario"]);

				$data["0"] .= '	
			
			   <div class="direct-chat-msg right">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">' . $datosusuario["usuario_cargo"] . '</span><br>
                    <small><span class="direct-chat-timestamp pull-left">' . $remisioncontactanos->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las: ' . $reg2[$j]["hora_respuesta"] . ' Del: ' . $reg2[$j]["periodo_respuesta"] . '</span></small>
                  </div>';


				$rspta3 = $remisioncontactanos->datosDependencia($reg2[$j]["id_remite_a"]);

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
				  <div class="alert" style="margin-bottom:0px !important"><center>Caso redirigido <i class="fas fa-exchange-alt"></i>' . $rspta3["usuario_cargo"] . ' <br><small> ' . $remisioncontactanos->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las ' . $reg2[$j]["hora_respuesta"] . ' </small></center></div>
				  <!-- /.direct-chat-text -->
				  ';
				}
				$data["0"] .= '  
                </div>
                <!-- /.direct-chat-msg -->
				';

				// ******************************** //

			}
			$data["0"] .= '
			 </div>
              <!--/.direct-chat-messages-->



			  
			 	
			  <div class="box-footer">
              <form name="respuesta_directa" id="respuesta_directa" method="post">
			  <input type="hidden" name="id_credencial_estudiante" id="id_credencial_estudiante" value="' . $reg[$i]["id_credencial"] . '">
               <input type="hidden" name="id_ayuda" id="id_ayuda" value="' . $id_ayuda . '">
				<textarea name="mensaje_dependencia" id="mensaje_dependencia" class="form-control" rows="3" placeholder="Respuesta ..." required></textarea>
					<button type="submit" class="btn btn-primary btn-flat btn-block">Enviar Respuesta</button>
              </form>
			  
			  <h3>Remitir Ayuda</h3>
			  <form name="redireccionar" id="redireccionar" method="post">
			  <input type="hidden" name="id_ayuda_caso" id="id_ayuda_caso" value="' . $id_ayuda . '">
			  <textarea name="mensaje_dependencia_remite" id="mensaje_dependencia_remite" class="form-control" rows="3" placeholder="Respuesta ..." required></textarea>
                <div class="input-group">
					<select class="form-control" name="id_remite_a" id="id_remite_a" class="form-control selectpicker" data-live-search="true" required>
					</select>
                  
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning btn-flat">Remitir</button>
                      </span>
                </div>
              </form>
            </div>
			  
			  
</div>


          </div>
          <!--/.direct-chat -->
        </div>';
		}

		$results = array($data);
		echo json_encode($results);
		break;

	case 'verAyudaTerminado':
		$id_ayuda = $_POST["id_ayuda"];
		$rspta = $remisioncontactanos->verAyuda($id_ayuda);
		$reg = $rspta;
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo

		for ($i = 0; $i < count($reg); $i++) {
			$nombre1 = $reg[$i]["credencial_nombre"];
			$nombre2 = $reg[$i]["credencial_nombre_2"];
			$apellido1 = $reg[$i]["credencial_apellido"];
			$apellido2 = $reg[$i]["credencial_apellido_2"];
			$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;

			$buscarasunto = $remisioncontactanos->buscarasunto($reg[$i]["id_asunto"]); // busca el asunto
			$asunto = $buscarasunto["asunto"];

			$buscaropcionasunto = $remisioncontactanos->buscaropcionasunto($reg[$i]["id_asunto_opcion"]); // busca el asunto
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
                    <small><span class="direct-chat-timestamp">' . $remisioncontactanos->fechaesp($reg[$i]["fecha_solicitud"]) . ' a las: ' . $reg[$i]["hora_solicitud"] . ' Del: ' . $reg[$i]["periodo_ayuda"] . '</span></small>
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
			$rspta2 = $remisioncontactanos->listarRespuesta($reg[$i]["id_ayuda"]);
			$reg2 = $rspta2;
			for ($j = 0; $j < count($reg2); $j++) {

				$datosusuario = $remisioncontactanos->datosDependencia($reg2[$j]["id_usuario"]);

				$data["0"] .= '	
			
			   <div class="direct-chat-msg right">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">' . $datosusuario["usuario_cargo"] . '</span><br>
                    <small><span class="direct-chat-timestamp pull-left">' . $remisioncontactanos->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las: ' . $reg2[$j]["hora_respuesta"] . ' Del: ' . $reg2[$j]["periodo_respuesta"] . '</span></small>
                  </div>';


				$rspta3 = $remisioncontactanos->datosDependencia($reg2[$j]["id_remite_a"]);

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
				  <div class="alert" style="margin-bottom:0px !important"><center>Caso redirigido <i class="fas fa-exchange-alt"></i>' . $rspta3["usuario_cargo"] . ' <br><small> ' . $remisioncontactanos->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las ' . $reg2[$j]["hora_respuesta"] . '</small> </center></div>
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

	case 'listarTabla':
		$rspta = $remisioncontactanos->listarTabla($periodo_actual); // listar los casos ayuda
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;

		for ($i = 0; $i < count($reg); $i++) {
			$buscarasunto = $remisioncontactanos->buscarasunto($reg[$i]["id_asunto"]); // busca el asunto
			$asunto = $buscarasunto["asunto"];

			$buscaropcionasunto = $remisioncontactanos->buscaropcionasunto($reg[$i]["id_asunto_opcion"]); // busca el asunto
			$opcion = $buscaropcionasunto["opcion"];

			$data[] = array(
				"0" => ($reg[$i]["estado"] == 1) ?

					'<a onclick=contacto(' . $reg[$i]["id_credencial"] . ') class="btn btn-primary btn-xs btn-block" style="margin:0px">
					Datos Estudiante 
				</a>
				<a onclick=verAyuda(' . $reg[$i]["id_ayuda"] . ') class="btn btn-danger btn-xs btn-block" style="margin:0px">
					<i class="fas fa-paper-plane"></i> Solucionar
				</a>'

					:

					'<a onclick=contacto(' . $reg[$i]["id_credencial"] . ') class="btn btn-primary btn-xs btn-block" style="margin:0px">
				Datos estudiante</a>
				<span class="label label-success bg-success btn-block" style="padding:2%; margin:0px">
					<i class="fas fa-check-double"></i> Solucionado
				</span>',

				"1" => $asunto,
				"2" => $opcion,
				"3" => $reg[$i]["mensaje"],
				"4" => '<small>' . $remisioncontactanos->fechaesp($reg[$i]["fecha_solicitud"]) . ' a las: ' . $reg[$i]["hora_solicitud"] . ' Del: ' . $reg[$i]["periodo_ayuda"] . '</small>',
				"5" => ($reg[$i]["estado"] == 1) ?
					'<span class="badge badge-danger">
						<i class="fas fa-exclamation"></i> Pendiente</span>' :
					'<a onclick=verAyudaTerminado(' . $reg[$i]["id_ayuda"] . ') class="btn btn-success btn-xs">
						<i class="fas fa-eye"></i> Ver caso
					</span>'
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
		// case 'eliminar':
		// 	$rspta = $remisioncontactanos->eliminar($id_ayuda);
		// 	//Codificar el resultado utilizando json
		// 	echo json_encode($rspta);
		// 	break;

		// case "selectDependencia":
		// 	$rspta = $remisioncontactanos->selectDependencia();
		// 	echo "<option value=''>Seleccionar Dependencia</option>";
		// 	for ($i = 0; $i < count($rspta); $i++) {
		// 		echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
		// 	}
		// 	break;

	case "selectDependencia":
		$rspta = $remisioncontactanos->selectDependencia();
		echo "<option value=''>Seleccionar Dependencia</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" .
				$rspta[$i]["usuario_cargo"] .
				" - " .
				$rspta[$i]["usuario_nombre"] .
				"  " .
				$rspta[$i]["usuario_apellido"] .
				"</option>";
		}
		break;

	case 'contacto':
		$id_credencial = $_POST["id_credencial"];
		$rspta = $remisioncontactanos->contacto($id_credencial);
		$reg = $rspta;
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo


		$nombre1 = $reg["credencial_nombre"];
		$nombre2 = $reg["credencial_nombre_2"];
		$apellido1 = $reg["credencial_apellido"];
		$apellido2 = $reg["credencial_apellido_2"];
		$identificacion = $reg["credencial_identificacion"];
		$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;

		$data["0"] .= '<b>Identificación:</b> ' . $identificacion . '<br>';
		$data["0"] .= '<b>Nombre:</b> ' . $nombre_completo . '<br>';
		$data["0"] .= '<b>Telefono:</b> ' . $reg["celular"] . '<br>';
		$data["0"] .= '<b>Email Personal:</b> ' . $reg["email"] . '<br>';
		$data["0"] .= '<b>Email Institucional:</b> ' . $reg["credencial_login"] . '<br>';


		$results = array($data);
		echo json_encode($results);
		break;

	case 'datosDataTablePrint':

		$rspta = $remisioncontactanos->datosDataTablePrint($id_credencial);

		// print_r($rspta);


		// $reg = $rspta;
		$data["nombre"] = ""; //iniciamos el arreglo
		$data["dependencia"] = "";

		$nombre1 = $rspta["usuario_nombre"];
		$nombre2 = $rspta["usuario_nombre_2"];
		$apellido1 = $rspta["usuario_apellido"];
		$apellido2 = $rspta["usuario_apellido_2"];
		$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;


		$data["nombre"] .= $nombre_completo;
		$data["dependencia"] .= $rspta["usuario_cargo"];

		echo json_encode($data);
		break;
}
