<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/Licitaciones.php";
$proceso = new ProcesosExtension();
$carpeta = isset($_POST["carpeta"]) ? limpiarCadena($_POST["carpeta"]) : "";
$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('H:i:s');
$fechaarchivo = date('d-h-i-s');
$id_usuario = $_SESSION['id_usuario'];
// valida si la tarea entra para insertar o editar
$id_licitaciones_tarea = isset($_POST["id_licitaciones_tarea"]) ? limpiarCadena($_POST["id_licitaciones_tarea"]) : "";
// valida si el item entra para insertar o editar
$crear_editar_id_licitaciones_item = isset($_POST["crear_editar_id_licitaciones_item"]) ? limpiarCadena($_POST["crear_editar_id_licitaciones_item"]) : "";
$item_id_licitaciones_tarea = isset($_POST["item_id_licitaciones_tarea"]) ? limpiarCadena($_POST["item_id_licitaciones_tarea"]) : "";
$nombre_elemento = isset($_POST["nombre_elemento"]) ? limpiarCadena($_POST["nombre_elemento"]) : '';
$usuario_responsableitem = isset($_POST["usuario_responsableitem"]) ? limpiarCadena($_POST["usuario_responsableitem"]) : '';
$fecha_inicio_item = isset($_POST["fecha_inicio_item"]) ? limpiarCadena($_POST["fecha_inicio_item"]) : '';
$fecha_entregar_item = isset($_POST["fecha_entregar_item"]) ? limpiarCadena($_POST["fecha_entregar_item"]) : '';
// metodo post del formulario para crear las tareas.
$nombre_tarea = isset($_POST["nombre_tarea"]) ? limpiarCadena($_POST["nombre_tarea"]) : "";
$usuario_responsable = isset($_POST["usuario_responsable"]) ? limpiarCadena($_POST["usuario_responsable"]) : "";
$progreso_tarea = isset($_POST["progreso_tarea"]) ? limpiarCadena($_POST["progreso_tarea"]) : "";
$prioridad = isset($_POST["prioridad"]) ? limpiarCadena($_POST["prioridad"]) : "";
$fecha_inicio = isset($_POST["fecha_inicio"]) ? limpiarCadena($_POST["fecha_inicio"]) : "";
$fecha_vencimiento = isset($_POST["fecha_vencimiento"]) ? limpiarCadena($_POST["fecha_vencimiento"]) : "";
$notas = isset($_POST["notas"]) ? limpiarCadena($_POST["notas"]) : "";
$codigo_licitacion = isset($_POST["codigo_licitacion"]) ? limpiarCadena($_POST["codigo_licitacion"]) : "";
$valor = isset($_POST["valor"]) ? limpiarCadena($_POST["valor"]) : "";
$entidad_contratante = isset($_POST["entidad_contratante"]) ? limpiarCadena($_POST["entidad_contratante"]) : "";
$facultad = isset($_POST["facultad"]) ? limpiarCadena($_POST["facultad"]) : "";
$tipo_contratacion = isset($_POST["tipo_contratacion"]) ? limpiarCadena($_POST["tipo_contratacion"]) : "";
//hasta esta parte se insertan en licitaciones_tareas
$lista_comprobacion = isset($_POST["lista_comprobacion"]) ? limpiarCadena($_POST["lista_comprobacion"]) : "";
$agregar_archivos = isset($_POST["agregar_archivos"]) ? limpiarCadena($_POST["agregar_archivos"]) : "";
//metodo post para guardar los archivos por medio de cada item
$id_elemento_archivo_items = isset($_POST["id_elemento_archivo_items"]) ? limpiarCadena($_POST["id_elemento_archivo_items"]) : "";
$global_id_licitaciones_items = isset($_POST["global_id_licitaciones_items"]) ? limpiarCadena($_POST["global_id_licitaciones_items"]) : "";
$agregar_archivo_item = isset($_POST["agregar_archivo_item"]) ? limpiarCadena($_POST["agregar_archivo_item"]) : "";
// utilizamos la variable global de id_licitaciones para agregarla junto con las listas
$id_licitaciones_tarea_global = isset($_POST["id_licitaciones_tarea_global"]) ? limpiarCadena($_POST["id_licitaciones_tarea_global"]) : "";
$comentario = isset($_POST["comentario"]) ? limpiarCadena($_POST["comentario"]) : "";
$id_licitaciones_item = isset($_POST["id_licitaciones_item"]) ? limpiarCadena($_POST["id_licitaciones_item"]) : "";
// para el formulario de validar el estado
$id_licitaciones_tarea_aprobado = isset($_POST["id_licitaciones_tarea_aprobado"]) ? limpiarCadena($_POST["id_licitaciones_tarea_aprobado"]) : "";
$aprobado = isset($_POST["aprobado"]) ? limpiarCadena($_POST["aprobado"]) : "";
$porque_aprobado = isset($_POST["porque_aprobado"]) ? limpiarCadena($_POST["porque_aprobado"]) : "";
$id_elemento_comentario_global = isset($_POST["id_elemento_comentario_global"]) ? limpiarCadena($_POST["id_elemento_comentario_global"]) : "";
$comentario_global = isset($_POST["comentario_global"]) ? limpiarCadena($_POST["comentario_global"]) : "";
$enlace_proceso = isset($_POST["enlace_proceso"]) ? limpiarCadena($_POST["enlace_proceso"]) : "";
$tipo_de_proceso = isset($_POST["tipo_de_proceso"]) ? limpiarCadena($_POST["tipo_de_proceso"]) : "";
$observaciones = isset($_POST["observaciones"]) ? limpiarCadena($_POST["observaciones"]) : "";
switch ($_GET["op"]) {
	case 'listar_tareas':
		$rspta = $proceso->verTareas();
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$id_licitaciones_tarea = $reg[$i]["id_licitaciones_tarea"];
			$nombre_tarea = $reg[$i]["nombre_tarea"];
			$progreso_tarea = $reg[$i]["progreso_tarea"];
			$prioridad = $reg[$i]["prioridad"];
			$enlace_proceso = $reg[$i]["enlace_proceso"];
			$entidad_contratante = $reg[$i]["entidad_contratante"];
			$notas = $reg[$i]["notas"];
			$prioridad = $reg[$i]["prioridad"];
			$fecha_inicio = $reg[$i]["fecha_inicio"];
			$fecha_vencimiento = $reg[$i]["fecha_vencimiento"];
			$porque_aprobado = $reg[$i]["porque_aprobado"];
			$aprobado = ($reg[$i]["aprobado"]) ? "Aprobada" : (is_null($reg[$i]["aprobado"]) ? "" : "No Aprobada");
			$buscar_prioridad = $proceso->Buscar_Prioridad($prioridad);
			$nombre_prioridad = $buscar_prioridad["progreso"];
			$total_item_por_licitacion = $proceso->ListarItemAvance($id_licitaciones_tarea);
			$total_item = count($total_item_por_licitacion);
			$total_item_terminados = $proceso->ListarItemAvanceTerminado($id_licitaciones_tarea);
			$total_terminado = count($total_item_terminados);
			if ($total_item_por_licitacion > 0 && $total_item > 0) {
				$resultado_items_porcentaje = floor(($total_terminado / $total_item) * 100);
			} else {
				$resultado_items_porcentaje = 0;
			}
			if ($resultado_items_porcentaje > 96) {
				$clase_barra = 'bg-success';
			} elseif ($resultado_items_porcentaje > 70) {
				$clase_barra = 'bg-warning';
			} else {
				$clase_barra = 'bg-danger';
			}
			$data[] = array(
				"0" => '
					<div class="text-center btn-group">
						<a onclick="MostrarTarea(' . $id_licitaciones_tarea . ')" class="btn btn-primary btn-sm" title="Ver Licitación">
							<i class="fas fa-eye"></i>
						</a>
						<button class="tooltip-mostrar btn btn-info btn-xs ms-2" onclick="listar_items(' . $id_licitaciones_tarea . ', `' . $fecha_inicio . '`, `' . $fecha_vencimiento . '`)" title="Listar Items" data-toggle="tooltip" data-placement="top"><i class="fas fa-list-ul"></i></button>
						<button class="tooltip-eliminar btn btn-danger btn-xs" onclick="eliminar_licitacion(' . $id_licitaciones_tarea . ')" title="Eliminar Licitación" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
						<button class="tooltip-estado_completado btn btn-success btn-xs" onclick="estado_completado(' . $id_licitaciones_tarea . ')" title="Estado Completado" data-toggle="tooltip" data-placement="top"><i class="fas fa-check"></i></button>	
						<button class="tooltip-agregar btn btn-info btn-xs ms-2" onclick="mostrar_comentarios_globales(' . $id_licitaciones_tarea . ')" title="Listar Comentarios Globales" data-toggle="tooltip" data-placement="top"><i class="fas fa-comments"></i></button>
						</div>',
				"1" => $nombre_tarea,
				"2" => $progreso_tarea . " " . $aprobado . " " . $porque_aprobado,
				"3" => $nombre_prioridad,
				"4" => $notas,
				"5" => "<a href='" . $enlace_proceso . "' target='_blank'>Abrir enlace</a>",
				"6" => $entidad_contratante,
				"7" => $proceso->fechaesp($fecha_inicio),
				"8" => $proceso->fechaesp($fecha_vencimiento),
				"9" => '
					<div class="col-12 ">
						<div class="row">
							<div class="col-12">
								<span class="text-semibold fs-12">' . $resultado_items_porcentaje . '% de Avance</span>
							</div>
							<div class="col-12">
								<div class="progress progress-sm">
									<div class="progress-bar ' . $clase_barra . '" style="width: ' . $resultado_items_porcentaje . '%"></div>
								</div>
							</div>
						</div>
					</div>',
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
	case 'mostrar_tarea':
		$id_licitaciones_tarea = $_POST["id_licitaciones_tarea"];
		$rspta = $proceso->Mostrar_Tarea($id_licitaciones_tarea);
		echo json_encode($rspta);
		break;
	case 'guardaryeditartarea':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		if (empty($id_licitaciones_tarea)) {
			$id_licitacion = $proceso->InsertarTareas($nombre_tarea, $progreso_tarea, $prioridad, $fecha_inicio, $fecha_vencimiento, $notas, $id_usuario, $codigo_licitacion, $valor, $entidad_contratante, $facultad, $tipo_contratacion, $enlace_proceso, $tipo_de_proceso, $observaciones);
			if ($id_licitacion) {
				$proceso->insertarItemDefault($id_licitacion);
				$resultado = $id_licitacion ? "1" : "2";
				$data["0"] .= $resultado;
			}
		} else {
			$rspta = $proceso->EditarTarea($id_licitaciones_tarea, $nombre_tarea, $progreso_tarea, $prioridad, $fecha_inicio, $fecha_vencimiento, $notas, $codigo_licitacion, $valor, $entidad_contratante, $facultad, $tipo_contratacion, $enlace_proceso, $tipo_de_proceso, $observaciones);
			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		$data["1"] = $id_usuario;
		$results = array($data);
		echo json_encode($results);
		break;
	case "UsuariosActivos":
		$rspta = $proceso->selectlistarUsuarios();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			$usuario = $rspta[$i]["usuario_nombre"] . " " .
				$rspta[$i]["usuario_nombre_2"] . " " .
				$rspta[$i]["usuario_apellido"] . " " .
				$rspta[$i]["usuario_apellido_2"];
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $usuario . "</option>";
		}
		break;
	case "Prioridad_Tarea":
		$rspta = $proceso->selectlistarPrioridad();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_licitacion_prioridad"] . "'>" . $rspta[$i]["progreso"] . "</option>";
		}
		break;
	case 'finalizarelemento':
		$fecha_finalizado = date('Y-m-d');
		$hora_finalizado = date('H:i:s');
		$id_usuario_finalizado = $_SESSION['id_usuario'];
		$id_licitaciones_item = isset($_POST["id_licitaciones_item"]) ? limpiarCadena($_POST["id_licitaciones_item"]) : '';
		$estado_item = isset($_POST["estado_item"]) ? limpiarCadena($_POST["estado_item"]) : '';
		$motivo_incumplido = isset($_POST["motivo_incumplido"]) ? limpiarCadena($_POST["motivo_incumplido"]) : '';
		$rspta = $proceso->FinalizarElemento($id_licitaciones_item, $estado_item, $fecha_finalizado, $hora_finalizado, $id_usuario_finalizado, $motivo_incumplido);
		// obtenemos el nombre para el elemento finalizado 
		$nombreElemento = $proceso->ObtenerNombreElemento($id_licitaciones_item);
		if ($rspta) {
			echo json_encode(['success' => true, 'nombre_elemento' => $nombreElemento['nombre_elemento']]);
		} else {
			echo json_encode(['success' => false]);
		}
		break;
	case 'subirarchivoform':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$target_path = '../files/licitaciones_archivos/';
		$archivo_documento = $_FILES['agregar_archivos']['name'];
		$img1path = $target_path . $archivo_documento;
		if (move_uploaded_file($_FILES['agregar_archivos']['tmp_name'], $img1path)) {
			$archivo_documento_final = $_FILES['agregar_archivos']['name'];
			$id_licitacion = isset($_POST['id_licitaciones_tarea']) ? $_POST['id_licitaciones_tarea'] : '';
			$fecha = date("Y-m-d");
			$hora = date("H:i:s");
			$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';
			$rspta = $proceso->InsertarArchivoLicitacion($id_licitacion, $archivo_documento_final, $id_usuario, $fecha, $hora);
			$data["0"] = $rspta ? "1" : "2";
		} else {
			$data["0"] = "3";
		}
		echo json_encode(["resultado" => $data["0"]]);
		break;
	case 'mostrar_archivos':
		$id_licitaciones_tarea = isset($_POST['id_licitaciones_tarea']) ? $_POST['id_licitaciones_tarea'] : '';
		$global_id_licitaciones_tarea = isset($_POST['global_id_licitaciones_tarea']) ? $_POST['global_id_licitaciones_tarea'] : '';
		$id_usar = !empty($global_id_licitaciones_tarea) ? $global_id_licitaciones_tarea : $id_licitaciones_tarea;
		$data[0] = "";
		if (!empty($id_usar)) {
			$archivos = $proceso->ObtenerArchivosPorTarea($id_usar);
			if (!empty($archivos)) {
				foreach ($archivos as $archivo) {
					$data[0] .= '
						<div class="archivo-item" style="display: inline-block; margin: 10px; text-align: center;">
							<a href="../files/licitaciones_archivos/' . $archivo['nombre_archivo'] . '" target="_blank" title="' . $archivo['nombre_archivo'] . '">
								<img src="../files/licitaciones_archivos/' . $archivo['nombre_archivo'] . '" alt="' . $archivo['nombre_archivo'] . '" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ccc; border-radius: 5px; cursor: pointer;">
							</a>
							<p style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . $archivo['nombre_archivo'] . '</p>
						</div>';
				}
			} else {
				$data[0] = '<p>No hay archivos disponibles para esta tarea.</p>';
			}
		} else {
			$data[0] = '<p>Se debe proporcionar un ID válido para la tarea.</p>';
		}
		echo json_encode($data);
		break;
	case 'listar_items':
		$id_licitaciones_tarea = $_POST["id_licitaciones_tarea"];
		$rspta = $proceso->ListarItems($id_licitaciones_tarea);
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$id_licitaciones_item = $reg[$i]["id_licitaciones_item"];
			$nombre_elemento = $reg[$i]["nombre_elemento"];
			$nombre_completo = $reg[$i]["nombre_completo"];
			$estado_terminado = $reg[$i]["estado_terminado"];
			$motivo_incumplido = $reg[$i]["motivo_incumplido"];
			$tipo_estado = $reg[$i]["tipo_estado"];
			$opciones = '
				<button class="tooltip-subir_archivos btn btn-secondary btn-xs ms-2" onclick="subir_archivos_item(' . $id_licitaciones_item . ')" title="Subir Archivos Por Item" data-toggle="tooltip" data-placement="top"><i class="fas fa-upload"></i></button>
				<button class="tooltip-agregar btn btn-info btn-xs ms-2" onclick="mostrar_comentarios_elementos(' . $id_licitaciones_item . ')" title="Listar Comentarios" data-toggle="tooltip" data-placement="top"><i class="fas fa-comments"></i></button>
				<button class="btn btn-warning btn-xs ms-2" onclick="editarItem(' . $id_licitaciones_item . ')" title="Editar Items"><i class="fas fa-edit"></i></button>
				<button class="tooltip-eliminar btn btn-danger btn-xs" onclick="eliminar_item(' . $id_licitaciones_item . ')" title="Eliminar Licitación" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
			if ($tipo_estado == "Aprobar") {
				$opciones = "";
				$boton_estado = '<button class="btn btn-success btn-xs ms-2" onclick="finalizarElemento(' .  $id_licitaciones_item . ', 0)" type="button" title="Item Cumplido"><i class="fas fa-check"></i> Si </button> <button class="btn bg-danger btn-xs ms-2" onclick="finalizarElemento(' .  $id_licitaciones_item . ', 2)" type="button" title="No"><i class="fas fa-xmark"></i> No </button>';
			} else {
				$boton_estado = '<button class="btn btn-primary btn-xs ms-2" onclick="finalizarElemento(' .  $id_licitaciones_item . ', 0)" type="button" title="Item Cumplido"><i class="fas fa-check"></i></button><button class="btn bg-orange btn-xs ms-2" onclick="finalizarElemento(' .  $id_licitaciones_item . ', 2)" type="button" title="No Cumplido"><i class="fas fa-xmark"></i></button>';
			}
			if ($estado_terminado == 0) {
				$badge_estado = '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Cumplido</span>';
				$boton_estado = "";
			} else if ($estado_terminado == 2) {
				$badge_estado = '<span class="badge bg-danger tooltips" title="' . $motivo_incumplido . '"><i class="fas fa-xmark"></i> No se cumplió </span>';
				$boton_estado = "";
			} else {
				$badge_estado = '<span class="badge bg-warning"><i class="fas fa-user-clock"></i> Pendiente </span>';
			}
			$boton_no_cumplido = $estado_terminado == 2 ? '<span class="badge bg-danger"><i class="fas fa-times"></i> </span>' :
				'<button class="btn bg-orange text-white btn-xs ms-2 tooltips" onclick="finalizarElemento(' .  $id_licitaciones_item . ', 2)" type="button" title="No se cumplio"><i class="fas fa-times"></i></button>';
			$data[] = array(
				"0" => '<div class="text-center btn-group">' . $opciones . $boton_estado  . '</div>',
				"1" => $nombre_elemento,
				"2" => $nombre_completo,
				"3" => $badge_estado,
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
	case 'mostrar_comentarios_elementos':
		$id_licitaciones_item = isset($_POST["id_licitaciones_item"]) ? limpiarCadena($_POST["id_licitaciones_item"]) : '';
		// Llamamos al método para obtener los comentarios de ese elemento
		$comentarios = $proceso->ListarComentariosPorItem($id_licitaciones_item);
		$data = array();
		$data[0] = '';
		if (!empty($comentarios)) {
			$data[0] .= '
				<table id="mostrar_comentarios" class="table" style="width:100%">
					<thead>
						<tr>
							<th>Comentario</th>
							<th>Fecha/Hora</th>
							<th>Responsable</th>
						</tr>
					</thead><tbody>';
			for ($i = 0; $i < count($comentarios); $i++) {
				$comentario = $comentarios[$i];
				$nombre_completo = $comentario['usuario_nombre'] . " " . $comentario['usuario_nombre_2'] . " " . $comentario['usuario_apellido'] . " " . $comentario['usuario_apellido_2'];
				$data[0] .= '
					<tr>
						<td>' . $comentario['comentario'] . '</td>
						<td>' . $comentario['fecha'] . ' ' . $comentario['hora'] . '</td>
						<td>' . $nombre_completo . '</td>
					</tr>';
			}
			$data[0] .= '</tbody></table>';
		} else {
			$data[0] = '<div class="alert alert-info">No hay comentarios para este elemento.</div>';
		}
		$data[0] .= '
			<div class="text-right mb-3">
				<button class="btn btn-primary" type="button" onclick="mostrarFormularioComentario()">Agregar Comentario</button>
			</div>
			<div id="formAgregarComentario" style="display:none;">
				<form name="formulariocomentario" id="formulariocomentario" method="POST">
					<input type="hidden" name="id_licitaciones_item" value="' . $id_licitaciones_item . '">
					<div class="form-group">
						<label for="comentario">Nuevo comentario:</label>
						<textarea class="form-control" name="comentario" id="comentario" rows="3" placeholder="Escribe tu comentario aquí"></textarea>
					</div>
					<button type="button" class="btn btn-success" onclick="guardarComentario()">Guardar comentario</button>
					<button type="button" class="btn btn-secondary" onclick="ocultarFormularioComentario()">Cancelar</button>
				</form>
			</div>';
		echo json_encode($data);
		break;
	case 'guardarcomentarioitem':
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$id_usuario = $_SESSION['id_usuario'];
		$resultado = $proceso->GuardarComentarioItem($id_licitaciones_item, $comentario, $id_usuario, $fecha, $hora);
		if ($resultado) {
			$htmlComentario = '
				<div class="comentario">
					<small class="text-muted">' . $fecha . ' ' . $hora . '</small><br>
						<p>' . $comentario . '</p>
				</div>';
			echo json_encode(['success' => true, 'commentHtml' => $htmlComentario]);
		} else {
			echo json_encode(['success' => false, 'message' => 'No se pudo guardar el comentario.']);
		}
		break;
	//crear o editar el item.
	case 'guardaryeditaritems':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		if (empty($crear_editar_id_licitaciones_item)) {
			$rspta = $proceso->AgregarElemento($nombre_elemento, $usuario_responsableitem, $item_id_licitaciones_tarea, $fecha_inicio_item, $fecha_entregar_item);
			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
		} else {
			$rspta = $proceso->EditarElemento($crear_editar_id_licitaciones_item, $nombre_elemento, $usuario_responsableitem, $fecha_inicio_item, $fecha_entregar_item);
			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		$data["1"] = $id_usuario;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'eliminar_licitacion':
		$rspta1 = $proceso->BuscarArchivoEliminarPorLicitacion($id_licitaciones_tarea);
		for ($i = 0; $i < count($rspta1); $i++) {
			$nombre_archivo = $rspta1[$i]['nombre_archivo'];
			$nombre_sin_extension = pathinfo($nombre_archivo, PATHINFO_FILENAME);
			unlink("../files/licitaciones_archivos/" . $nombre_archivo);
		}
		$rspta = $proceso->EliminarLicitacion($id_licitaciones_tarea);
		echo json_encode($rspta);
		break;
	case 'eliminar_item':
		$id_licitaciones_item = $_POST["id_licitaciones_item"];
		$rspta1 = $proceso->BuscarArchivoEliminar($id_licitaciones_item);
		for ($i = 0; $i < count($rspta1); $i++) {
			$nombre_archivo = $rspta1[$i]['nombre_archivo'];
			$nombre_sin_extension = pathinfo($nombre_archivo, PATHINFO_FILENAME);
			unlink("../files/licitaciones_archivos/" . $nombre_archivo);
		}
		$rspta = $proceso->EliminarItem($id_licitaciones_item);
		echo json_encode($rspta);
		break;
	case 'mostrar_elemento':
		$id_licitaciones_item = $_POST["id_licitaciones_item"];
		$rspta = $proceso->mostrar_elemento($id_licitaciones_item);
		echo json_encode($rspta);
		break;
	case 'subir_archivos_item':
		$id_licitaciones_item = isset($_POST["id_licitaciones_item"]) ? limpiarCadena($_POST["id_licitaciones_item"]) : '';
		$global_id_licitaciones_items = isset($_POST["global_id_licitaciones_items"]) ? limpiarCadena($_POST["global_id_licitaciones_items"]) : '';
		$archivos_listado_items = $proceso->ListarArchivosPorItems($id_licitaciones_item);
		$ruta_carpeta = '../files/licitaciones_archivos/';
		$data = array();
		$data[0] = '';
		if (!empty($archivos_listado_items)) {
			$data[0] .= '
			<table id="mostrar_archivo_por_items" class="table" style="width:100%">
				<thead>
					<tr>
						<th>Archivo</th>
						<th>Fecha/Hora</th>
						<th>Responsable</th>
					</tr>
				</thead><tbody>';
			for ($i = 0; $i < count($archivos_listado_items); $i++) {
				$archivo_item = $archivos_listado_items[$i];
				$nombre_completo = $archivo_item['usuario_nombre'] . " " . $archivo_item['usuario_nombre_2'] . " " . $archivo_item['usuario_apellido'] . " " . $archivo_item['usuario_apellido_2'];
				$ruta_archivo = $ruta_carpeta . $archivo_item['nombre_archivo'];
				$data[0] .= '
					<tr>
						<td><a href="' . $ruta_archivo . '" target="_blank">' . $archivo_item['nombre_archivo'] . '</a></td>
						<td>' . $proceso->fechaesp($archivo_item['fecha']) . ' ' . $archivo_item['hora'] . '</td>
						<td>' . $nombre_completo . '</td>
					</tr>';
			}
			$data[0] .= '</tbody></table>';
		} else {
			$data[0] = '<div class="alert alert-secondary">No hay archivos para este item.</div>';
		}
		// archivo_id_licitaciones_item para saber a que item va cuando se agrega el archivo.
		// global_id_licitaciones_items para saber a que licitacion va el archivo cuando se agrega.
		$data[0] .= '
			<div class="text-right mb-3">
				<button class="btn btn-primary" type="button" onclick="mostrarFormularioArchivoItems()">Agregar Archivo</button>
			</div>
			<div id="formAgregarArchivoItems" style="display:none;">
				<form name="formulariosubirArchivoItems" id="formulariosubirArchivoItems" method="POST">
					<input type="hidden" name="archivo_id_licitaciones_item" value="' . $id_licitaciones_item . '">
					<input type="hidden" name="global_id_licitaciones_items" value="' . $global_id_licitaciones_items . '">
					<div id="subidaArchivoItem">
						<label for="agregar_archivo_item" class="form-label mt-3">Subir Archivo</label>
						<input type="file" name="agregar_archivo_item" id="agregar_archivo_item" class="form-control mb-2">
					</div>
					<div class="mt-3">
					<button type="button" class="btn btn-success" onclick="guardarSubirArchivoItem()">Guardar Archivo</button>
					<button type="button" class="btn btn-secondary" onclick="ocultarFormularioArchivoItems()">Cancelar</button>
					</div>
				</form>
			</div>';
		echo json_encode($data);
		break;
	case 'guardarSubirArchivoItem':
		$archivo_id_licitaciones_item = isset($_POST["archivo_id_licitaciones_item"]) ? limpiarCadena($_POST["archivo_id_licitaciones_item"]) : "";
		$data = array();
		$data[0] = false;
		$data[1] = '';
		$target_path = '../files/licitaciones_archivos/';
		$archivo_documento = $_FILES['agregar_archivo_item']['name'];
		// Extraer la extensión del archivo
		$extension = pathinfo($archivo_documento, PATHINFO_EXTENSION);
		// Obtener el nombre base del archivo (sin extensión)
		$nombre_base = pathinfo($archivo_documento, PATHINFO_FILENAME);
		// Obtener la fecha y hora actual (formato: YYYY-MM-DD-HH-MM-SS)
		$fecha_hora = date("Y-m-d-H-i-s");
		// Crear el nuevo nombre concatenando nombre base, fecha y hora, y la extensión
		$nuevo_nombre = $nombre_base . "-" . $fecha_hora . "." . $extension;
		$img1path = $target_path . $nuevo_nombre;
		if (move_uploaded_file($_FILES['agregar_archivo_item']['tmp_name'], $img1path)) {
			$fecha = date("Y-m-d");
			$hora = date("H:i:s");
			$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';
			$resultado = $proceso->GuardarArchivoItem($archivo_id_licitaciones_item, $nuevo_nombre, $id_usuario, $fecha, $hora, $global_id_licitaciones_items);
			if ($resultado) {
				$data[0] = true;
				$data[1] = "Archivo agregado con éxito";
			} else {
				$data[1] = "Error al guardar el archivo";
			}
		} else {
			$data[1] = "Error al subir el archivo";
		}
		echo json_encode($data);
		break;
	case 'guardaryeditarfueaprobado':
		$rspta = $proceso->EditarEstadoCompletado($id_licitaciones_tarea_aprobado, $aprobado, $porque_aprobado);
		$resultado = $rspta ? "1" : "2";
		$data = array();
		$data["0"] = $resultado;
		echo json_encode($data);
		break;
	case 'mostrar_comentarios_globales':
		$id_licitaciones_tarea = isset($_POST["id_licitaciones_tarea"]) ? limpiarCadena($_POST["id_licitaciones_tarea"]) : '';
		// Llamamos al método para obtener los comentarios de ese elemento
		$comentarios = $proceso->ListarComentariosGlobales($id_licitaciones_tarea);
		$data = array();
		$data[0] = '';
		if (!empty($comentarios)) {
			$data[0] .= '
				<table id="mostrar_comentarios_globales" class="table" style="width:100%">
					<thead>
						<tr>
							<th>Comentario</th>
							<th>Fecha/Hora</th>
							<th>Responsable</th>
						</tr>
					</thead><tbody>';
			for ($i = 0; $i < count($comentarios); $i++) {
				$comentario = $comentarios[$i];
				$nombre_completo = $comentario['usuario_nombre'] . " " . $comentario['usuario_nombre_2'] . " " . $comentario['usuario_apellido'] . " " . $comentario['usuario_apellido_2'];
				$data[0] .= '
					<tr>
						<td>' . $comentario['comentario'] . '</td>
						<td>' . $proceso->fechaesp($comentario['fecha']) . ' ' . $comentario['hora'] . '</td>
						<td>' . $nombre_completo . '</td>
					</tr>';
			}
			$data[0] .= '</tbody></table>';
		} else {
			$data[0] = '<div class="alert alert-info">No hay comentarios para este elemento.</div>';
		}
		$data[0] .= '
			<div class="text-right mb-3">
				<button class="btn btn-primary" type="button" onclick="mostrarFormularioComentarioGlobal()">Agregar Comentario</button>
			</div>
			<div id="formAgregarComentarioGlobal" style="display:none;">
				<form name="formulariocomentarioglobal" id="formulariocomentarioglobal" method="POST">
					<input type="hidden" name="id_elemento_comentario_global" value="' . $id_licitaciones_tarea . '">
					<div class="form-group">
						<label for="comentario">Nuevo comentario:</label>
						<textarea class="form-control" name="comentario_global" id="comentario_global" rows="3" placeholder="Escribe tu comentario aquí"></textarea>
					</div>
					<button type="button" class="btn btn-success" onclick="guardarComentarioGlobal()">Guardar comentario</button>
					<button type="button" class="btn btn-secondary" onclick="ocultarFormularioComentarioGlobal()">Cancelar</button>
				</form>
			</div>';
		echo json_encode($data);
		break;
	case 'guardarComentarioGlobal':
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$id_usuario = $_SESSION['id_usuario'];
		$resultado = $proceso->GuardarComentarioGlobal($id_elemento_comentario_global, $comentario_global, $id_usuario, $fecha, $hora);
		if ($resultado) {
			$data[0] .= '
				<div class="comentario">
					<small class="text-muted">' . $fecha . ' ' . $hora . '</small><br>
						<p>' . $comentario . '</p>
				</div>';
			echo json_encode(['success' => true, 'commentHtml' => $data[0]]);
		} else {
			echo json_encode(['success' => false, 'message' => 'No se pudo guardar el comentario.']);
		}
		break;
	case 'comentarios_totales':
		$id_licitaciones_tarea = isset($_POST["global_id_licitaciones_items"]) ? limpiarCadena($_POST["global_id_licitaciones_items"]) : '';
		$nombre_licitacion = $proceso->TraerNombreLicitacion($id_licitaciones_tarea);
		$data = array();
		$data[0] = '';
		//consulta nombre licitacion
		$data[0] .=
			'<div class="timeline">
			<div class="time-label">
				<span class="bg-red">' . $nombre_licitacion[0]['nombre_tarea'] . '</span>
			</div>';
		//consulta comentarios globales
		$comentarios_globales = $proceso->ListarComentariosGlobales($id_licitaciones_tarea);
		if (!empty($comentarios_globales)) {
			for ($i = 0; $i < count($comentarios_globales); $i++) {
				$nombre_tarea = $comentarios_globales[$i]['comentario'];
				$nombre_asesor = $comentarios_globales[$i]['usuario_nombre'] . " " . $comentarios_globales[$i]['usuario_nombre_2'] . " " . $comentarios_globales[$i]['usuario_apellido'] . " " . $comentarios_globales[$i]['usuario_apellido_2'];
				$fecha = $comentarios_globales[$i]['fecha'];
				$hora = $comentarios_globales[$i]['hora'];
				$fecha_hora_comentarios = 'Fecha/Hora no definida';
				$data[0] .=
					'<div>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            <span class="time"> 
								<i class="fas fa-clock"></i> 
								' . $proceso->fechaesp($fecha)  . " " . $hora . '
								<br>
								<i class="fas fa-user"></i> 
								<small class="text-info">
								<b>' . $nombre_asesor . '</b>	
								</small> 
							</span>
                            <br>
                            <br>
                            ' . $nombre_tarea . '
                        </div>
                    </div>
                </div>';
			}
		} else {
			$data[0] .=
				'<div class="timeline">
			<div class="time-label">
				<span class="bg-red">No hay comentarios globales</span>
			</div>';
		}
		//consulta para listar item
		$nombre_item = $proceso->NombreItem($id_licitaciones_tarea);
		for ($i = 0; $i < count($nombre_item); $i++) {
			$nombre_elemento = $nombre_item[$i]['nombre_elemento'];
			$id_licitaciones_item = $nombre_item[$i]['id_licitaciones_item'];
			//for para items
			$data[0] .=
				'<div class="time-label">
			<span class="bg-green"><i class="fas fa-hashtag"></i> ' . $nombre_elemento . '</span>
			</div>';
			$nombre_por_item = $proceso->ComentariosPorItem($id_licitaciones_item);
			//consulta para comentarios de items
			if (!empty($nombre_por_item)) {
				for ($j = 0; $j < count($nombre_por_item); $j++) {
					$comentario = $nombre_por_item[$j]['comentario'];
					$fecha = $nombre_por_item[$j]['fecha'];
					$hora = $nombre_por_item[$j]['hora'];
					//for para comentarios de items
					$data[0] .=
						'<div>
                        <div class="timeline-item">
                            <div class="timeline-body">
                                <span class="time"> <i class="fas fa-clock"></i> ' . $proceso->fechaesp($fecha) . " " . $hora . ' </span>
                                <br>
								' . $comentario . '
                            </div>
                        </div>
                    </div>';
				}
			} else {
				$data[0] .=
					'<div>
                        <div class="timeline-item">
                            <div class="timeline-body">
                                No hay comentarios globales
                            </div>
                        </div>
                    </div>';
			}
		}
		$data[0] .=
			'<div>
                    <i class="fas fa-clock bg-gray"></i>
                </div>
            </div>';
		echo json_encode($data);
		break;
	case 'HistoricoArchivos':
		$id_licitaciones_tarea = isset($_POST["global_id_licitaciones_items"]) ? limpiarCadena($_POST["global_id_licitaciones_items"]) : '';
		$nombre_licitacion = $proceso->TraerNombreLicitacion($id_licitaciones_tarea);
		$data = array();
		$data[0] = '';
		//consulta nombre licitacion
		$data[0] .=
			'<div class="timeline">
			<div class="time-label">
				<span class="bg-red">' . $nombre_licitacion[0]['nombre_tarea'] . '</span>
			</div>';
		//consulta para listar item
		$nombre_item = $proceso->NombreItem($id_licitaciones_tarea);
		for ($i = 0; $i < count($nombre_item); $i++) {
			$nombre_elemento = $nombre_item[$i]['nombre_elemento'];
			$id_licitaciones_item = $nombre_item[$i]['id_licitaciones_item'];
			//for para items
			$data[0] .=
				'<div class="time-label">
			<span class="bg-green"><i class="fas fa-hashtag"></i> ' . $nombre_elemento . '</span>
			</div>';
			$archivos = $proceso->ArchivosPorItem($id_licitaciones_item);
			//consulta para comentarios de items
			if (!empty($archivos)) {
				for ($j = 0; $j < count($archivos); $j++) {
					$nombre_archivo = $archivos[$j]['nombre_archivo'];
					$fecha = $archivos[$j]['fecha'];
					$hora = $archivos[$j]['hora'];
					$nombre_asesor = $archivos[$j]['usuario_nombre'] . " " . $archivos[$j]['usuario_nombre_2'] . " " . $archivos[$j]['usuario_apellido'] . " " . $archivos[$j]['usuario_apellido_2'];
					//for para comentarios de items
					$data[0] .=
						'<div>
							<div class="timeline-item">
							<div class="timeline-body">
									<i class="fas fa-clock"></i> Fecha: ' . $proceso->fechaesp($fecha) . " " . $hora . '<br>
									<i class="fas fa-user"></i> Usuario:  <small class="text-info"> <b>' . $nombre_asesor . '</b> </small><br>
									<i class="fas fa-file-import"></i> Archivo:
									<a href="../files/licitaciones_archivos/' . $nombre_archivo . '" target="_blank" title="' . $nombre_archivo . '">	
										' . $nombre_archivo . '
									</a>
								</div>
							</div>
						</div>';
				}
			} else {
				$data[0] .=
					'<div>
                        <div class="timeline-item">
                            <div class="timeline-body">
                                No hay archivos para este item
                            </div>
                        </div>
                    </div>';
			}
		}
		$data[0] .=
			'<div>
                    <i class="fas fa-clock bg-gray"></i>
                </div>
            </div>';
		echo json_encode($data);
		break;
	case 'buscarCodigo':
		$data = array();
		$numero_codigo = isset($_POST["numero_codigo"]) ? limpiarCadena($_POST["numero_codigo"]) : '';
		$rspta = $proceso->BuscarCodigo($numero_codigo);
		for ($i = 0; $i < count($rspta); $i++) {
			$data[] = array(
				"0" => $rspta[$i]["numero_codigo"],
				"1" => $rspta[$i]["nombre_codigo"],
				"2" => '<button class="btn btn-success btn-xs" onclick="agregarCodigo(' . $rspta[$i]["numero_codigo"] . ')"><i class="fas fa-plus"></i></button>',
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
	case "listarEntidadesContratantes":
		$rspta = $proceso->listarEntidadesContratantes();
		echo "<option selected>Selecciona una opción</option>";
		echo "<option value='otra'>Nueva u Otra</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			$texto = $rspta[$i]["razon_social"];
			echo "<option value='" . $texto . "'>" . $texto . "</option>";
		}
		break;
	case "generarCodigoPrivado":
		$year = date("Y");
		$rspta = $proceso->generarCodigoPrivado();
		if (isset($rspta["codigo"])) {
			$codigo = $rspta["codigo"];
			#el codigo es AP01-2025, necesito tomar el 01 y sumarle 1
			$numero_codigo = explode("-", $codigo);
			$numero_codigo = explode("P", $numero_codigo[0]);
			$numero_codigo = intval($numero_codigo[1]) + 1;
			$rspta = array("exito" => 1, "codigo" => "AP" . (($numero_codigo < 10) ? "0" . $numero_codigo : $numero_codigo) . "-" . $year);
		} else {
			$rspta = array("exito" => 1, "codigo" => "AP01-" . $year);
		}
		echo json_encode($rspta);
		break;
	case "AgregarEntidadContratante":
		$otra_entidad_contratante = isset($_POST["otra_entidad_contratante"]) ? limpiarCadena($_POST["otra_entidad_contratante"]) : '';
		$rspta = $proceso->AgregarEntidadContratante($otra_entidad_contratante);
		if ($rspta) {
			$data = array("exito" => 1, "info" => "<option value='" . $otra_entidad_contratante . "'>" . $otra_entidad_contratante . "</option>");
		} else {
			$data = array("exito" => 0, "info" => "Error al agregar la entidad contratante");
		}
		echo json_encode($data);
		break;
}
