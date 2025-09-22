<?php
require_once "../modelos/Permiso.php";
$permiso = new Permiso();
$id_permiso = isset($_POST["id_permiso"]) ? limpiarCadena($_POST["id_permiso"]) : "";
$permiso_nombre = isset($_POST["permiso_nombre"]) ? limpiarCadena($_POST["permiso_nombre"]) : "";
$orden = isset($_POST["orden"]) ? limpiarCadena($_POST["orden"]) : "";
$icono = isset($_POST["icono"]) ? limpiarCadena($_POST["icono"]) : "";
$menu = isset($_POST["menu"]) ? limpiarCadena($_POST["menu"]) : "";
$permiso_nombre_original = isset($_POST["permiso_nombre_original"]) ? limpiarCadena($_POST["permiso_nombre_original"]) : "";
$ultima_orden = isset($_POST["orden"]) ? limpiarCadena($_POST["orden"]) : "";
$permiso_nombre_editar = isset($_POST["permiso_nombre_editar"]) ? limpiarCadena($_POST["permiso_nombre_editar"]) : "";
$orden_editar = isset($_POST["orden_editar"]) ? limpiarCadena($_POST["orden_editar"]) : "";
$icono_editar = isset($_POST["icono_editar"]) ? limpiarCadena($_POST["icono_editar"]) : "";
$permiso_nombre_original_editar = isset($_POST["permiso_nombre_original_editar"]) ? limpiarCadena($_POST["permiso_nombre_original_editar"]) : "";
// variables para insertar el funcionario.
$funcionario_seleccionado = isset($_POST["funcionario_seleccionado"]) ? limpiarCadena($_POST["funcionario_seleccionado"]) : "";
$id_permiso_insertar = isset($_POST["id_permiso_insertar"]) ? limpiarCadena($_POST["id_permiso_insertar"]) : "";
switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($id_programa)) {
			$rspta = $permiso->insertar($permiso_nombre, $ultima_orden, $menu, $permiso_nombre_original, $icono);
			echo $rspta ? "Permiso registrado " : "No se pudo registrar el permiso";
		}
		break;
	case 'mostrar':
		$rspta = $programa->mostrar($id_programa);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case 'listar':
		$menu_p = 0;
		//lista los permisos(el menu de los permisos comienzan por 0)
		$rspta = $permiso->listarPermisos($menu_p);
		$reg = $rspta;
		$data = array();
		$data["0"] = "";
		$data["0"] .= '<ul class="timeline">';
		for ($i = 0; $i < count($reg); $i++) {
			$orden = $reg[$i]["orden"];
			$id_permiso_agregar_funcionario = $reg[$i]["id_permiso"];
			$data["0"] .= '
			<div class="row">
				<div class="col-md-12">
					<div class="timeline">
						<div class="time-label">
							<span class="bg-red">' . $reg[$i]["permiso_nombre_original"] . '</span>  <button class="btn btn-success" onclick="agregar_permiso(' . $orden . ')"><i class="fa fa-plus-circle"></i> Agregar
							</button>
							<button class="btn btn-success btn-sm" onclick="agregarmenufuncionario(' . $id_permiso_agregar_funcionario . ')" title="agregar menu">
						<i class="fas fa-user-shield"></i>
						</div>
					<div>
					<i class="fas fa-user bg-green"></i>
					<div class="timeline-item">
						<h3 class="timeline-header no-border">
					</button>
						<div class="row">';
			$rspta2 = $permiso->listarSubmenu($reg[$i]["orden"]);
			$reg2 = $rspta2;
			for ($k = 0; $k < count($reg2); $k++) {
				$id_permiso = $reg2[$k]["id_permiso"];
				$data["0"] .= '
								<div class="col-xl-3 col-lg-6 col-md-6 col-12 ">
									<div class="info-box">
										<span class="info-box-icon bg-info elevation-1">' . $reg2[$k]["icono"] . '</span>
										<a> <button class="btn btn-warning btn-sm position-absolute" style="top: 5px; right: 5px;" onclick="editar_formulario_permiso(' . $id_permiso . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button> </a>
										<br>
										<a> <button class="btn btn-success btn-sm position-absolute mt-5" style="top: 5px; right: 5px;" onclick="mostrar_permiso_general(' . $id_permiso . ')" title="Activar y Desactivar Permisos"><i class="fas fa-user-shield"></i></button> </a>
										<div class="info-box-content mt-3">
											<span class="info-box-text">' . $reg2[$k]["permiso_nombre_original"] . '</span>
											<span class="info-box-number">' . $reg2[$k]["orden"] . '</span>
										</div>
									</div>
								</div>';
			}
			$data["0"] .= '
						</div>
						</h3>
					</div>
				</div>
			</div>
			</div>
			</div>';
		}
		$data["0"] .= '</ul>';
		$results = array($data);
		echo json_encode($results);
		break;
		//Formulario para agregar los permisos, en el ultimo orden y con su respectivo menu
	case 'agregar_permiso':
		$orden = $_POST['orden'];
		$data[0] = "";
		$rspta2 = $permiso->listarSubmenuUltimoRegistro($orden);
		$ultima_orden = 0; // Inicializamos el valor de $ultima_orden en cero
		for ($k = 0; $k < count($rspta2); $k++) {
			$orden = $rspta2[$k]["orden"];
			$menu = $rspta2[$k]["menu"];
			$ultima_orden = $orden;
		}
		if (strpos($ultima_orden, '.') !== false && substr_count($ultima_orden, '.') == 1) {
			$partes = explode('.', $ultima_orden);
			$entero = $partes[0];
			$decimal = $partes[1];
			$ultimo_digito = substr($decimal, -1); // Obtener el último dígito decimal
			$nuevo_decimal = $decimal + 1; // Sumar 1 al último dígito decimal
			$resultado = $entero . '.' . $nuevo_decimal; // Combinar la parte entera y el nuevo decimal
		} else {
			// Si el número es de la forma "xx.x", simplemente sumar 0.1 al número
			$ultima_orden = $ultima_orden + 0.1;
		}
		$data[0] .= '
			<section class="content" style="padding-top: 0px;">
				<div class="card col-12" id="formularioregistros" style="padding: 2%">
					<form name="formulario" id="formulario" method="POST">
						<div class="row">
						<input type="number" class="d-none" id="menu" value = "' . $menu . '" name="menu">';
		if (strpos($ultima_orden, '.') !== false && substr_count($ultima_orden, '.') == 1) {
			$data[0] .= '<input type="number" class="d-none" id="orden" value = "' . $resultado . '" name="orden">';
		} else {
			$nuevo_numero = $ultima_orden + 0.1;
			$data[0] .= '<input type="number" class="d-none" id="orden" value = "' . $nuevo_numero . '" name="orden">';
		}
		$data[0] .= '
						<div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
							<label>Nombre del Permiso(*):</label>
							<input type="text" class="form-control" name="permiso_nombre" id="permiso_nombre" maxlength="100" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<label>Nombre para botón</label>
							<input type="text" class="form-control" name="permiso_nombre_original" id="permiso_nombre_original">
						</div>
						<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<label>Url Icono</label>
							<input type="text" class="form-control" name="icono" id="icono">
						</div>
						<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button class="btn btn-primary" onclick = "guardaryeditar()"id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
							<button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
						</div>
						</div>
					</form>
				</div>
			</section>';
		echo json_encode($data);
		break;
		//Formulario para agregar los permisos, en el ultimo orden y con su respectivo menu
	case 'editar_formulario_permiso':
		$orden = $_POST['id_permiso'];
		$data[0] = "";
		$listar_editar = $permiso->mostrar($orden);
		$permiso_nombre_editar = $listar_editar["permiso_nombre"];
		$permiso_nombre_original_editar = $listar_editar["permiso_nombre_original"];
		$icono_editar = htmlspecialchars($listar_editar["icono"]);
		$data[0] .= '
			<section class="content" style="padding-top: 0px;">
				<div class="card col-12" id="formulario_editado" style="padding: 2%">
					<form name="formulario_editar_consecutivo" id="formulario_editar_consecutivo" method="POST">
						<div class="row">
						<div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
							<label>Nombre del Permiso(*):</label>
							<input type="text" class="form-control" name="permiso_nombre_editar" value="' . $permiso_nombre_editar . '" id="permiso_nombre_editar" maxlength="100" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<label>Nombre para botón</label>
							<input type="text" class="form-control" name="permiso_nombre_original_editar"  value="' . $permiso_nombre_original_editar . '" id="permiso_nombre_original_editar">
						</div>
						<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<label>Url Icono</label>
							<input type="text" class="form-control" name="icono_editar" id="icono_editar" value="' . $icono_editar . '">
						</div>
						<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="number" class="d-none" id="orden_editar" value = "' . $orden . '" name="orden">
							<button class="btn btn-primary" onclick = "editar_formulario()"><i class="fa fa-save"></i> Guardar</button>
							<button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
						</div>
						</div>
					</form>
				</div>
			</section>';
		echo json_encode($data);
		break;
	case 'editar_formulario':
		$rspta = $permiso->listarSubmenuUltimoRegistroEditar($orden, $permiso_nombre_editar, $permiso_nombre_original_editar, $icono_editar);
		echo $rspta ? "Permiso actualizado" : "Permiso no se pudo actualizar";
		break;
	case 'mostrar_permiso_general':
		$id_permiso = $_GET['id_permiso'];
		$mostrar_permisos_funcionario = $permiso->Mostrar_Funcionarios_Permiso();
		$listar_permisos = $permiso->TraerPermisoFuncionarios($id_permiso);
		// Inicializa $usuarios_permiso como un array vacío para evitar undefined variable warnings
		$usuarios_permiso = [];
		// Llena $usuarios_permiso solo si $listar_permisos contiene elementos
		if (is_array($listar_permisos) && count($listar_permisos) > 0) {
			foreach ($listar_permisos as $permiso) {
				$usuarios_permiso[] = $permiso["id_usuario"];
			}
		}
		$data = []; // Asegúrate de que $data esté definida también
		if (is_array($mostrar_permisos_funcionario) && count($mostrar_permisos_funcionario) > 0) {
			foreach ($mostrar_permisos_funcionario as $funcionario) {
				$id_usuario = $funcionario["id_usuario"];
				$permiso_funcionario = in_array($id_usuario, $usuarios_permiso);
				// $boton_estado_permiso = $permiso_funcionario ?
				// 	' <button class="btn btn-danger btn-xs" onclick="desactivar_permiso(' . $id_permiso . ',' . $id_usuario . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button>' :
				// 	' <button class="btn btn-primary btn-xs" onclick="activar_permiso(' . $id_permiso . ',' . $id_usuario . ')" title="Activar"><i class="fas fa-lock"></i></button>';
				$boton_estado_permiso = $permiso_funcionario ?
					' <button class="btn btn-danger btn-xs" onclick="desactivar_permiso(' . $id_permiso . ',' . $id_usuario . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button> <span class="text-success">Sí</span>' :
					' <button class="btn btn-primary btn-xs" onclick="activar_permiso(' . $id_permiso . ',' . $id_usuario . ')" title="Activar"><i class="fas fa-lock"></i></button> <span class="text-danger">No</span>';
				$credencial_identificacion = $funcionario["usuario_identificacion"];
				$nombre_usuario = $funcionario["usuario_nombre"] . " " . $funcionario["usuario_nombre_2"] . " " . $funcionario["usuario_apellido"] . " " . $funcionario["usuario_apellido_2"];
				$data[] = array(
					"0" => $boton_estado_permiso,
					"1" => $credencial_identificacion,
					"2" => $nombre_usuario,
				);
			}
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
		//case para activar el permiso 
	case 'activar_permiso':
		$id_permiso = $_POST['id_permiso'];
		$id_usuario = $_POST['id_usuario'];
		// Si el funcionario no está registrado, intentar insertarlo.
		$rspta = $permiso->InsertarFuncionario($id_usuario, $id_permiso);
		echo json_encode($rspta);
		break;
		//desactivar el permiso.
	case 'desactivar_permiso':
		$id_permiso = $_POST['id_permiso'];
		$id_usuario = $_POST['id_usuario'];
		$rspta = $permiso->Desactivar_Permiso($id_permiso, $id_usuario);
		echo json_encode($rspta);
		break;
	case 'agregarmenufuncionario':
		$usuarios_permiso = array();
		$orden = $_GET['orden'];
		$mostrar_permisos_funcionario = $permiso->Mostrar_Funcionarios_Permiso();
		$listar_permisos = $permiso->TraerPermisoFuncionariosMenu($orden);
		for ($x = 0; $x < count($listar_permisos); $x++) {
			$usuarios_permiso[] = $listar_permisos[$x]["id_usuario"];
		}
		for ($i = 0; $i < count($mostrar_permisos_funcionario); $i++) {
			$id_usuario = $mostrar_permisos_funcionario[$i]["id_usuario"];
			$permiso_funcionario = in_array($id_usuario, $usuarios_permiso);
			$boton_estado_permiso = $permiso_funcionario ?
				' <button class="btn btn-danger btn-xs" onclick="desactivar_permiso_menu(' . $orden . ',' . $id_usuario . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button> <span class="text-success">Sí</span>' :
				' <button class="btn btn-primary btn-xs" onclick="activar_permiso_menu(' . $orden . ',' . $id_usuario . ')" title="Activar"><i class="fas fa-lock"></i></button> <span class="text-danger">No</span>';
			$credencial_identificacion = $mostrar_permisos_funcionario[$i]["usuario_identificacion"];
			$nombre_usuario = $mostrar_permisos_funcionario[$i]["usuario_nombre"] . " " . $mostrar_permisos_funcionario[$i]["usuario_nombre_2"] . " " . $mostrar_permisos_funcionario[$i]["usuario_apellido"] . " " . $mostrar_permisos_funcionario[$i]["usuario_apellido_2"];
			$data[] = array(
				"0" => $boton_estado_permiso,
				"1" => $credencial_identificacion,
				"2" => $nombre_usuario,
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
	case 'desactivar_permiso_menu':
		$id_permiso = $_POST['orden'];
		$id_usuario = $_POST['id_usuario'];
		// Si el funcionario no está registrado, intentar insertarlo.
		$rspta = $permiso->Desactivar_PermisoMenu($id_permiso, $id_usuario);
		echo json_encode($rspta);
		break;
	case 'activar_permiso_menu':
		$id_permiso = $_POST['orden'];
		$id_usuario = $_POST['id_usuario'];
		// Si el funcionario no está registrado, intentar insertarlo.
		$rspta = $permiso->InsertarFuncionarioMenu($id_usuario, $id_permiso);
		echo json_encode($rspta);
		break;
}