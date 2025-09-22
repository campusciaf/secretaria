<?php
session_start();
require_once "../modelos/Usuario.php";
require_once "../public/mail/sendmailClave.php"; // incluye el codigo para enviar link de clave
require_once "../mail/templatesolicitudayuda.php"; // incluye el codigo para enviar link de clave
date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:s');

$usuario = new Usuario();

$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$usuario_tipo_documento = isset($_POST["usuario_tipo_documento"]) ? limpiarCadena($_POST["usuario_tipo_documento"]) : "";
$usuario_identificacion = isset($_POST["usuario_identificacion"]) ? limpiarCadena($_POST["usuario_identificacion"]) : "";
$usuario_nombre = isset($_POST["usuario_nombre"]) ? limpiarCadena($_POST["usuario_nombre"]) : "";
$usuario_nombre_2 = isset($_POST["usuario_nombre_2"]) ? limpiarCadena($_POST["usuario_nombre_2"]) : "";
$usuario_apellido = isset($_POST["usuario_apellido"]) ? limpiarCadena($_POST["usuario_apellido"]) : "";
$usuario_apellido_2 = isset($_POST["usuario_apellido_2"]) ? limpiarCadena($_POST["usuario_apellido_2"]) : "";
$usuario_fecha_nacimiento = isset($_POST["usuario_fecha_nacimiento"]) ? limpiarCadena($_POST["usuario_fecha_nacimiento"]) : "";
$usuario_departamento_nacimiento = isset($_POST["usuario_departamento_nacimiento"]) ? limpiarCadena($_POST["usuario_departamento_nacimiento"]) : "";
$usuario_municipio_nacimiento = isset($_POST["usuario_municipio_nacimiento"]) ? limpiarCadena($_POST["usuario_municipio_nacimiento"]) : "";
$usuario_direccion = isset($_POST["usuario_direccion"]) ? limpiarCadena($_POST["usuario_direccion"]) : "";
$usuario_telefono = isset($_POST["usuario_telefono"]) ? limpiarCadena($_POST["usuario_telefono"]) : "";
$usuario_celular = isset($_POST["usuario_celular"]) ? limpiarCadena($_POST["usuario_celular"]) : "";
$usuario_email = isset($_POST["usuario_email"]) ? limpiarCadena($_POST["usuario_email"]) : "";
$usuario_poa = isset($_POST["usuario_poa"]) ? limpiarCadena($_POST["usuario_poa"]) : "";
$usuario_cargo = isset($_POST["usuario_cargo"]) ? limpiarCadena($_POST["usuario_cargo"]) : "";
$usuario_tipo_sangre = isset($_POST["usuario_tipo_sangre"]) ? limpiarCadena($_POST["usuario_tipo_sangre"]) : "";
$usuario_login = isset($_POST["usuario_login"]) ? limpiarCadena($_POST["usuario_login"]) : "";
$usuario_imagen = isset($_POST["usuario_imagen"]) ? limpiarCadena($_POST["usuario_imagen"]) : "";

$pagina_web = isset($_POST["pagina_web"]) ? limpiarCadena($_POST["pagina_web"]) : "";
$al_lado = isset($_POST["al_lado"]) ? limpiarCadena($_POST["al_lado"]) : "";

/* campos del fiormulario para el envio del link y recuperar clave*/

$email_link = isset($_POST["email_link"]) ? limpiarCadena($_POST["email_link"]) : "";
$roll_link = isset($_POST["roll_link"]) ? limpiarCadena($_POST["roll_link"]) : "";

/* *********************************************** */

//variables enviar correo ayuda

$correo_ciaf = isset($_POST["correo_ciaf"]) ? limpiarCadena($_POST["correo_ciaf"]) : "";
$celular = isset($_POST["celular"]) ? limpiarCadena($_POST["celular"]) : "";
$mensaje = isset($_POST["mensaje"]) ? limpiarCadena($_POST["mensaje"]) : "";
$asunto = isset($_POST["asunto"]) ? limpiarCadena($_POST["asunto"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':

		$data = array();
		$data["estado"] = "";

		if (!file_exists($_FILES['usuario_imagen']['tmp_name']) || !is_uploaded_file($_FILES['usuario_imagen']['tmp_name'])) {
			$imagen = $_POST["imagenactual"];
		} else {
			$ext = explode(".", $_FILES["usuario_imagen"]["name"]);
			if ($_FILES['usuario_imagen']['type'] == "image/jpg" || $_FILES['usuario_imagen']['type'] == "image/jpeg" || $_FILES['usuario_imagen']['type'] == "image/png" || $_FILES['usuario_imagen']['type'] == "application/pdf") {
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["usuario_imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}
		}



		$clave = md5($usuario_identificacion);

		if (empty($id_usuario)) { //para registrar usuario
			$fecha = NULL;
			$rspta = $usuario->insertar($usuario_tipo_documento, $usuario_identificacion, $usuario_nombre, $usuario_nombre_2, $usuario_apellido, $usuario_apellido_2, $usuario_fecha_nacimiento, $usuario_departamento_nacimiento, $usuario_municipio_nacimiento, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email, $usuario_cargo, $usuario_tipo_sangre, $usuario_login, $clave, $imagen, $usuario_poa,  $_POST["permiso"], $pagina_web, $al_lado);
			$datos = $rspta ? "1" : "2";
		} else { // para actualziar datos del usuario
			$rspta = $usuario->editar($id_usuario, $usuario_tipo_documento, $usuario_identificacion, $usuario_nombre, $usuario_nombre_2, $usuario_apellido, $usuario_apellido_2, $usuario_fecha_nacimiento, $usuario_departamento_nacimiento, $usuario_municipio_nacimiento, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email, $usuario_poa, $usuario_cargo, $usuario_tipo_sangre, $usuario_login, $imagen, $_POST["permiso"], $pagina_web, $al_lado);
			$datos = $rspta ? "3" : "4";
		}

		$data["estado"] = $datos;
		echo json_encode($data);
		break;

	case 'desactivar':
		$rspta = $usuario->desactivar($id_usuario);

		if ($rspta == 0) {
			echo "1";
		} else {

			echo "0";
		}
		//echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
		break;

	case 'activar':
		$rspta = $usuario->activar($id_usuario);

		if ($rspta == 0) {
			echo "1";
		} else {
			echo "0";
		}
		//echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
		break;

	case 'mostrar':
		$rspta = $usuario->mostrar($id_usuario);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);

		break;

	case 'listar':
		$rspta = $usuario->listar();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;


		for ($i = 0; $i < count($reg); $i++) {
			$nombreCompleto = $reg[$i]["usuario_nombre"] . " " . $reg[$i]["usuario_nombre_2"] . " " . $reg[$i]["usuario_apellido"] . " " . $reg[$i]["usuario_apellido_2"];
			$nombreFormateado = mb_convert_case(mb_strtolower($nombreCompleto, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');

			$data[] = array(
				"0" => '<div class="btn-group">'.(($reg[$i]["usuario_condicion"]) ? '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg[$i]["id_usuario"] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>' .
					' <button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg[$i]["id_usuario"] . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button>' :
					'<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg[$i]["id_usuario"] . ')"><i class="fas fa-pencil-alt"></i></button>' .
					' <button class="btn btn-primary btn-xs" onclick="activar(' . $reg[$i]["id_usuario"] . ')" title="Activar"><i class="fas fa-lock"></i></button>').' </div>',
				"1" => "<img src='../files/usuarios/" . $reg[$i]["usuario_imagen"] . "' class='img-fluid img-thumbnail' height='40px' width='40px' >",
				"2" => $nombreFormateado,
				"3" => $reg[$i]["usuario_identificacion"],
				"4" => $reg[$i]["usuario_email"],
				"5" => $reg[$i]["usuario_cargo"],
				"6" => $reg[$i]["usuario_celular"],


				"7" => ($reg[$i]["usuario_condicion"]) ? '<span class="badge bg-green p-1">Activo</span>' :
					'<span class="badge bg-red p-1">Inactivo</span>'
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

	case 'permisos':
		//Obtenemos todos los permisos de la tabla permisos
		require_once "../modelos/Permiso.php";
		$permiso = new Permiso();
		$menu = 0;

		$rspta = $permiso->listarpermisos($menu);

		//Obtener los permisos asignados al usuario
		$id = $_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores = array();


		$i = 0;
		while ($i < count($marcados)) {
			array_push($valores, $marcados[$i]["id_permiso"]);
			$i++;
		}

		//		Mostramos la lista de permisos en la vista y si están o no marcados
		$j = 0;
		echo '<div class="row">';
		while ($j < count($rspta)) {
			$sw = in_array($rspta[$j]["id_permiso"], $valores) ? 'checked' : '';
			echo '<div class="col-12 ">';
			echo '<li class="bg-1 py-2 px-4"> 
						<input type="checkbox" ' . $sw . ' name="permiso[]" value="' . $rspta[$j]["id_permiso"] . '" id="permiso_' . $rspta[$j]["id_permiso"] . '"> 
						<label for="permiso_' . $rspta[$j]["id_permiso"] . '" class="titulo-2 fs-14 text-capitalize">' . $rspta[$j]["permiso_nombre"] . '</label>
					</li>';

			$orden = $rspta[$j]["orden"];
			$rsptasub = $permiso->listarSubmenu($orden);
			$reg2 = $rsptasub;
			for ($k = 0; $k < count($reg2); $k++) {

				$sw = in_array($reg2[$k]["id_permiso"], $valores) ? 'checked' : '';
				$color = in_array($reg2[$k]["id_permiso"], $valores) ? 'bg-light-green' : '';
				echo '<li class="m-2 p-2 ' . $color . '" style="float:left"> 
								<input type="checkbox" ' . $sw . ' id="permiso_' . $reg2[$k]["id_permiso"] . '" name="permiso[]" value="' . $reg2[$k]["id_permiso"] . '">
								<label for="permiso_' . $reg2[$k]["id_permiso"] . '" class="titulo-2 fs-14 text-capitalize">' . $reg2[$k]["permiso_nombre"] . '</label> 
							</li>';
			}
			$j++;
			echo '</div>';
		}
		echo '</div>';

		break;

	case 'verificar':
		$logina = $_POST['logina'];
		$clavea = $_POST['clavea'];
		$roll = $_POST['roll'];
		$_SESSION["roll"] = $roll;
		//md5 en la contraseña
		$clavehash = md5($clavea);
		if ($roll == "Funcionario") {
			$rspta = $usuario->verificarfuncionario($logina, $clavehash);
			if ($rspta == true) {
				$rspta2 = $usuario->periodoactual();
				$_SESSION['periodo_actual'] = $rspta2["periodo_actual"];
				$_SESSION['periodo_anterior'] = $rspta2["periodo_anterior"];
				$_SESSION['periodo_siguiente'] = $rspta2["periodo_siguiente"];
				$_SESSION['sac_periodo'] = $rspta2["sac_periodo"];
				$_SESSION['semestre_actual'] = $rspta2["semestre_actual"];
				$fetch = $rspta;
				if (isset($fetch)) {
					//Declaramos las variables de sesión
					$_SESSION['id_usuario'] = $fetch["id_usuario"];
					$_SESSION['usuario_nombre'] = $fetch["usuario_nombre"];
					$_SESSION['usuario_identificacion'] = $fetch["usuario_identificacion"];
					$_SESSION['usuario_apellido'] = $fetch["usuario_apellido"];
					$_SESSION['usuario_imagen'] = $fetch["usuario_imagen"];
					$_SESSION['usuario_login'] = $fetch["usuario_login"];
					$_SESSION['usuario_cargo'] = $fetch["usuario_cargo"];
					$_SESSION['id_dependencia'] = $fetch["id_dependencia"];
					//Obtenemos los permisos del usuario
					$marcados = $usuario->listarmarcados($fetch["id_usuario"]);
					//Declaramos el array para almacenar todos los permisos marcados
					$valores = array();
					//Almacenamos los permisos marcados en el array
					$i = 0;
					while ($i < count($marcados)) {
						array_push($valores, $marcados[$i]["id_permiso"]);
						$i++;
					}
					//Determinamos los accesos del usuario
					require_once "../modelos/Permiso.php";
					$permiso = new Permiso();
					$rspta2 = $permiso->listar();
					$numero = 0;
					for ($h = 1; $h <= count($rspta2); $h++) {
						$permiso_nombre = $rspta2[$numero]["permiso_nombre"];
						in_array($h, $valores) ? $_SESSION[$permiso_nombre] = 1 : $_SESSION[$permiso_nombre] = 0;
						$numero++;
					}
				}
			} else {
				$fetch = 1;
			}
			echo json_encode($fetch);
		}
		if ($roll == "Docente") {
			$rspta = $usuario->verificardocente($logina, $clavehash);
			if ($rspta == true) {
				// consulta para almacenar el periodo actual //
				$rspta2 = $usuario->periodoactual();
				$_SESSION['periodo_actual'] = $rspta2["periodo_actual"];
				$_SESSION['periodo_anterior'] = $rspta2["periodo_anterior"];
				$_SESSION['semestre_actual'] = $rspta2["semestre_actual"];
				$fetch = $rspta;
				if (isset($fetch)) {
					//Declaramos las variables de sesión
					$_SESSION['id_usuario'] = $fetch["id_usuario"];
					$_SESSION['usuario_identificacion'] = $fetch["usuario_identificacion"];
					$_SESSION['usuario_nombre'] = $fetch["usuario_nombre"];
					$_SESSION['usuario_apellido'] = $fetch["usuario_apellido"];
					$_SESSION['usuario_imagen'] = $fetch["usuario_identificacion"];
					$_SESSION['usuario_login'] = $fetch["usuario_login"];
					$_SESSION['influencer_mas'] = $fetch["influencer_mas"];
					$_SESSION['usuario_cargo'] = "Docente";
					// actualizamos el campo ultimo ingreso dela tabla docente
					$rsptaingreso = $usuario->ingresoupdate($_SESSION['id_usuario'], $fecha);
					/* ****************************** */
				}
			} else {
				$fetch = 1;
			}
			echo json_encode($fetch);
		}
		if ($roll == "Estudiante") {
			$rspta = $usuario->verificarestudiante($logina, $clavehash);
			if ($rspta == true) {
				// consulta para almacenar el periodo actual //
				$rspta2 = $usuario->periodoactual();
				$_SESSION['periodo_actual'] = $rspta2["periodo_actual"];
				$_SESSION['periodo_anterior'] = $rspta2["periodo_anterior"];
				$_SESSION['semestre_actual'] = $rspta2["semestre_actual"];
				$fetch = $rspta;
				if (isset($fetch)) {
					//Declaramos las variables de sesión
					$_SESSION['id_usuario'] = $fetch["id_credencial"];
					$_SESSION['credencial_identificacion'] = $fetch["credencial_identificacion"];
					// $_SESSION['usuario_identificacion'] = $fetch["credencial_identificacion"];
					$_SESSION['usuario_nombre'] = $fetch["credencial_nombre"];
					$_SESSION['usuario_apellido'] = $fetch["credencial_apellido"];
					$_SESSION['usuario_imagen'] = $fetch["credencial_identificacion"];
					$_SESSION['usuario_login'] = $fetch["credencial_login"];
					$_SESSION['usuario_cargo'] = "Estudiante";
					$_SESSION['status_update'] = $fetch["status_update"];

					// Verificar si es egresado
					$miraregresado = $usuario->verificarestudianteegresado($_SESSION['id_usuario']);
					$_SESSION['egresado'] = $miraregresado ? 1 : 0;

					// También puedes incluir el valor de 'egresado' en la respuesta JSON si es necesario
					$fetch['egresado'] = $_SESSION['egresado'];
				}
			} else {
				$fetch = 1;
			}
			echo json_encode($fetch);
		}
		break;
	case 'salir':
		//Limpiamos las variables de sesión   
		session_unset();
		//Destruìmos la sesión
		session_destroy();
		//Redireccionamos al login
		header("Location: ../");
		die();

		break;

	case "selectTipoDocumento":
		$rspta = $usuario->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;

	case "selectTipoSangre":
		$rspta = $usuario->selectTipoSangre();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre_sangre"] . "'>" . $rspta[$i]["nombre_sangre"] . "</option>";
		}
		break;

	case "selectDependencia":
		$rspta = $usuario->selectDependencia();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectDepartamento":
		$id_departamento = isset($id_departamento) ? $id_departamento : "";
		if ($id_departamento == "") {
			$rspta = $usuario->selectDepartamentoMunicipioActivo($_SESSION['id_usuario']);
			$departamento_actual = $rspta["usuario_departamento_nacimiento"];
			echo "<option value='" . $departamento_actual . "'>" . $departamento_actual . "</option>";
		}

		$rspta = $usuario->selectDepartamento();
		echo "<option value='" . $usuario_departamento_nacimiento . "'>" . $usuario_departamento_nacimiento . "</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
		}
		break;


	case "selectMunicipio":
		$departamento = isset($_POST["departamento"]) ? $_POST["departamento"] : "";

		if ($departamento == "") {
			$rspta = $usuario->selectDepartamentoMunicipioActivo($_SESSION['id_usuario']);
			$municipio_actual = $rspta["usuario_municipio_nacimiento"];
			echo "<option value='" . $municipio_actual . "'>" . $municipio_actual . "</option>";
		} else {
			$rspta2 = $usuario->selectDepartamentoDos($departamento);
			$id_departamento_final = $rspta2["id_departamento"];

			$rspta = $usuario->selectMunicipio($id_departamento_final);
			echo "<option value=''>Seleccionar Municipio</option>";
			for ($i = 0; $i < count($rspta); $i++) {
				echo "<option value='" . $rspta[$i]["municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
			}
		}
		break;

	case "selectListaSiNo":
		$rspta = $usuario->selectListaSiNo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["valor"] . "'>" . $rspta[$i]["nombre_lista"] . "</option>";
		}
		break;
	case "ingreso":
		$roll = $_POST['roll'];
		$usuario_ingreso = $_SESSION['id_usuario'];
		$ip = $_SERVER['REMOTE_ADDR'];

		
			$rspta = $usuario->ingreso($usuario_ingreso, $roll, $fecha, $hora, $ip);
		
		break;
	case "enviarlink":
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$data["1"] = ""; //iniciamos el arreglo

		$ttime = microtime(true) * 1000;
		$token = $ttime . str_shuffle("ABCDEFGHIJKLNMOPQR");
		// $bytes = openssl_random_pseudo_bytes(5);



		// // $token = bin2hex($bytes);
		$codigo = rand(1000, 9999);
		if ($roll_link == "funcionario") {
			$tablalink = "usuario";
			$campo = "usuario_login";
			$idlink = "id_usuario";
		}
		if ($roll_link == "docente") {
			$tablalink = "docente";
			$campo = "usuario_login";
			$idlink = "id_usuario";
		}
		if ($roll_link == "estudiante") {
			$tablalink = "credencial_estudiante";
			$campo = "credencial_login";
			$idlink = "id_credencial";
		}
		$buscarid = $usuario->buscaridlink($email_link, $tablalink, $campo);
		$id_credencial = $buscarid[$idlink];
		$asunto = "Clave";
		$mensaje = "<p>Codigo:<b>$codigo</b>
                    <p> 
                        <a href=https://ciaf.digital/resetclave.php?email=$email_link&token=$token>  para restablecer da click aqui </a> 
                    </p>
					-- Este código expira en 5 minutos --
                    <p> 
                        <small>Si usted no envio este codigo favor de omitir</small> 
                    </p>";
		if ($id_credencial != 0) { // si se encuentra un id
			$estadomail = "";
			$rspta = $usuario->insertarLink($id_credencial, $roll_link, $email_link, $token, $codigo, $fecha, $hora); // inserta el registro
			$data["0"] .= "credencial enviada al correo electronico";

			((enviar_correo(trim($email_link), $asunto, $mensaje)) ? $estadomail = 1 : $estadomail = 0);
			if ($estadomail == 1) {
				$data["1"] .= 1;
			} else {
				$data["1"] .= 0;
			}
		} else {
			$data["0"] .= "Usuario no se encuentra";
		}
		$results = array($data);
		echo json_encode($results);
		break;




	case "imagen_banner_campus":


		$rspta = $usuario->mostrarImagenBanner();

		$data[0] = "";
	
			$imagen_banner = $rspta["imagen_banner"];
			$ruta = "public/banner_campus/" . $imagen_banner;

			$data[0] .= '


				<img class="lado-a-banner" src="' . $ruta . '">


				
				';
		
		echo json_encode($data);
		break;


	case "enviarcorreoayuda":
		$correo_ciaf = $_POST["correo_ciaf"];

		$dominio = explode('@', $correo_ciaf);

		$asunto = $_POST["asunto"];
		$celular = $_POST["celular"];
		$mensaje = $_POST["mensaje"];

		if (end($dominio) == 'ciaf.edu.co') {

			$template = set_template_solitar_ayuda($correo_ciaf, $celular, $mensaje);

			$destino = "sistemasdeinformacion@ciaf.edu.co";

			$data = array();
			if (enviar_correo($destino, $asunto, $template)) {
				$data = array(
					'exito' => '1',
					'info' => 'Enviado Correctamente.'
				);
			} else {
				$data = array(
					'exito' => '0',
					'info' => 'Error consulta fallo'
				);
			}
		} else {
			$data = array(
				'exito' => '0',
				'info' => ' el correo debe ser ciaf.edu.co'
			);
		}
		echo json_encode($data);




		break;







		// break;
}
