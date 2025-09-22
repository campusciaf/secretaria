<?php
require_once "../modelos/SacListarCondicion.php";
$SacListarCondicion = new SacListarCondicion();
// $accion = 0;
// $id_con_pro = 0;
$id_meta  = isset($_POST["id_meta"]) ? limpiarCadena($_POST["id_meta"]) : "";
$id_con_pro  = isset($_POST["id_con_pro"]) ? limpiarCadena($_POST["id_con_pro"]) : "";
$id_con_ins  = isset($_POST["id_con_ins"]) ? limpiarCadena($_POST["id_con_ins"]) : "";
$nombre_condicion  = isset($_POST["nombre_condicion"]) ? limpiarCadena($_POST["nombre_condicion"]) : "";
$contar_programa  = isset($_POST["contar_programa"]) ? limpiarCadena($_POST["contar_programa"]) : "";
$contar_institucion  = isset($_POST["contar_institucion"]) ? limpiarCadena($_POST["contar_institucion"]) : "";
$total_condicion_programa  = isset($_POST["total_condicion_programa"]) ? limpiarCadena($_POST["total_condicion_programa"]) : "";
$id_ejes  = isset($_POST["id_ejes"]) ? limpiarCadena($_POST["id_ejes"]) : "";
$id_objetivo_especifico  = isset($_POST["id_objetivo_especifico"]) ? limpiarCadena($_POST["id_objetivo_especifico"]) : "";
$id_condicion_institucional  = isset($_POST["id_condicion_institucional"]) ? limpiarCadena($_POST["id_condicion_institucional"]) : "";
$anio_actual = date("Y");
switch ($_GET["op"]) {

	case 'buscar':
		$val = $_POST['val'];
		$periodo = $_POST['periodo_global'];
		// cuando entra el $val a 1 entra en la tabla de listar condiciones de programa
		if ($val == 1) {
			$data['conte'] = '';
			$data['conte'] .= '
			<div id="listadoregistros">
			<table class="table table-striped" id="tbl_listar_condiciones_programa">
				<thead>
					<tr>
						<th id="tour_condiciones">Condiciones de Programa </th>
						<th id="tour_meta" class="text-center">Metas</th>
						<th id="tour_acciones" class="text-center">Acciones</th>
						<th id="tour_acciones" class="text-center">Tareas</th>
					</tr>
				</thead>
				<tbody>';

			$rsptacondicion = $SacListarCondicion->mostrarcondicionesprograma();

			for ($i = 0; $i < count($rsptacondicion); $i++) {
				$nombre_condicion = $rsptacondicion[$i]["nombre_condicion"];
				$condicion_pro_meta = $SacListarCondicion->contarmetacondicionprograma($rsptacondicion[$i]["id_condicion_programa"], $periodo);

				$condicion_pro_tareas = $SacListarCondicion->contarmetacondiciontareas($rsptacondicion[$i]["id_condicion_programa"], $periodo);

				$total_acciones = 0;
				$acumulados = array(); //creamos un arreglo vacio para registrar los id_con_pro que ya se han contado
				for ($e = 0; $e < count($condicion_pro_meta); $e++) {
					$id_con_pro = $condicion_pro_meta[$e]["id_con_pro"]; //muestra el id_con_pro actual 
					// verifica si el id_con_pro actual no ha sido procesado anteriormente
					if (!in_array($id_con_pro, $acumulados)) {
						//obtener el total de acciones para el id_con_pro actual
						$rsptaccion = $SacListarCondicion->contaraccionprograma($id_con_pro, $periodo);
						// suma el total de acciones
						$total_acciones += $rsptaccion["total_accion"];
						// evita contarlo nuevamente 
						$acumulados[] = $id_con_pro;
					}
				}

				$total_tareas = 0;
				$acumulados_tareas = array();
				for ($h = 0; $h < count($condicion_pro_tareas); $h++) {
					$id_con_pro = $condicion_pro_tareas[$h]["id_con_pro"]; // id_con_pro actual

					// Verifica si no ha sido contado antes
					if (!in_array($id_con_pro, $acumulados_tareas)) {
						// Obtener el total de tareas para este id_con_pro
						$rspttareas = $SacListarCondicion->contartareasprograma($id_con_pro, $periodo);

						// Sumar al total
						$total_tareas += $rspttareas["total_tareas"];

						// Marcar como procesado
						$acumulados_tareas[] = $id_con_pro;
					}
				}

				$data['conte'] .= '
                <tr>
                    <td>' . $nombre_condicion . '</td>
                    <td>' . '
					<div class="col-12 text-center"> 	
						<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="nombre_meta_con_pro(' . $rsptacondicion[$i]["id_condicion_programa"] . ')" title="Ver Condición de Programa">' . count($condicion_pro_meta) . ' </a>
					</div>' . '</td>
                    <td>' . '
					<div class="col-12 text-center"> 	
						<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="nombre_accion(' . $rsptacondicion[$i]["id_condicion_programa"] . ')" title="Ver Accion de Programa">' . ($total_acciones) . ' </a>
					</div> 
					' . '</td>

					<td>' . '
					
					
					<div class="col-12 text-center"> 	
						<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="tareas(' . $rsptacondicion[$i]["id_condicion_programa"] . ')" title="Tareas">' . $total_tareas . ' </a>
					</div>' . '</td>
                </tr>';
			}
			$data['conte'] .= '</div></tbody></table>';
			// cuando entra el $val a 2 entra en la tabla de listar condiciones institucionales
		} elseif ($val == 2) {
			$data['conte'] = '';
			$data['conte'] .= '
			<div id="listadoregistros2">
			<table class="table table-striped" id="tbl_listar_condiciones_programa">
				<thead>
					<tr>
						<th>Condiciones Institucionales</th>
						<th class="text-center">Metas</th>
						<th class="text-center">Acciones</th>
						<th class="text-center">Tareas</th>
					</tr>
				</thead>
				<tbody>
				
				';

			$condicioninstitucional = $SacListarCondicion->mostrarcondicionesinstitucional();

			for ($j = 0; $j < count($condicioninstitucional); $j++) {
				$nombre_condicion_institucional = $condicioninstitucional[$j]["nombre_condicion"];
				$condicion_por_ins = $SacListarCondicion->contarcondicioninstitucionalactual($condicioninstitucional[$j]["id_condicion_institucional"], $periodo);
				$contar_condicion = count($condicion_por_ins);

				$condicion_por_ins = $SacListarCondicion->contarcondicioninstitucionalactual($condicioninstitucional[$j]["id_condicion_institucional"], $periodo);


				$total_acciones_ins = 0;
				$acumulados_ins = array(); // Creamos un arreglo vacío para registrar los id_con_ins que ya se han contado
				for ($e = 0; $e < count($condicion_por_ins); $e++) {
					$id_con_ins = $condicion_por_ins[$e]["id_con_ins"]; // Muestra el id_con_ins actual
					if (!in_array($id_con_ins, $acumulados_ins)) {
						// Obtener el total de acciones para el id_con_ins actual
						$rsptaccionins = $SacListarCondicion->contaraccioninstitucional($id_con_ins, $periodo);
						// Sumar el total de acciones
						$total_acciones_ins += $rsptaccionins["total_accion_inst"];
						// Evitar contarlo nuevamente
						$acumulados_ins[] = $id_con_ins;
					}
				}

				$total_tareas_inst = 0;
				$acumulados_tareas_inst = array();
				for ($e = 0; $e < count($condicion_por_ins); $e++) {
					$id_con_ins = $condicion_por_ins[$e]["id_con_ins"];
					if (!in_array($id_con_ins, $acumulados_tareas_inst)) {
						$rspttareas = $SacListarCondicion->contaraccioninstitucionaltareas($id_con_ins, $periodo);
						$total_tareas_inst += $rspttareas["total_tareas"];
						$acumulados_tareas_inst[] = $id_con_ins;
					}
				}

				$data['conte'] .= '
                <tr>
                    <td>' . $nombre_condicion_institucional . '</td>
                    <td>' . '
					
					<div class="col-12 text-center"> 	
						<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="nombre_meta_con_ins(' . $condicioninstitucional[$j]["id_condicion_institucional"] . ')" title="Ver Accion de Programa"> ' . ($contar_condicion) . ' </a>
					</div>' . '</td>


                    <td>' . '
					
					
					<div class="col-12 text-center"> 	
						<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="nombre_accion_institucional(' . $condicioninstitucional[$j]["id_condicion_institucional"] . ')" title="Condición Por Institución">' . $total_acciones_ins . ' </a>
					</div>' . '</td>

					<td>' . '
					
					
					<div class="col-12 text-center"> 	
						<a href="#" class="badge badge-primary btn-sm btn-flat tooltip-agregar " onclick="tareas_insti(' . $condicioninstitucional[$j]["id_condicion_institucional"] . ')" title="Condición Por Institución">' . $total_tareas_inst . ' </a>
					</div>' . '</td>
                </tr>';
			}
			$data['conte'] .= '</div></tbody></table>';
		}

		echo json_encode($data);

		break;

	//listar las dependencias
	case 'nombre_meta_con_pro':
		$periodo = $_POST['periodo_global'];
		$nombre_meta = $SacListarCondicion->listarMetaConPro($id_con_pro, $periodo);
		$data[0] = "";
		for ($a = 0; $a < count($nombre_meta); $a++) {
			$meta = $nombre_meta[$a]["meta_nombre"];
			$data[0] .= '
			<div class="alert alert-success alert-dismissible">
			<h6><i class="icon fa fa-check"> </i> </b>' . $meta . '</h6>
			</div>';
		}
		echo json_encode($data);
		break;

	case 'nombre_accion':
		$periodo = $_POST['periodo_global'];
		$nombre_accion = $SacListarCondicion->listaraccionprograma($id_con_pro, $periodo);
		$data[0] = "";
		$meta_nombre = '';
		for ($r = 0; $r < count($nombre_accion); $r++) {
			$accion = $nombre_accion[$r]["nombre_accion"];
			$nombre_meta_actual = $nombre_accion[$r]["meta_nombre"];
			$nombre_meta_anterior = isset($nombre_accion[($r - 1)]["meta_nombre"]) ? $nombre_accion[($r - 1)]["meta_nombre"] : "";
			$nombre_accion_anterior = isset($nombre_accion[($r - 1)]["nombre_accion"]) ? $nombre_accion[($r - 1)]["nombre_accion"] : "";
			if ($nombre_meta_anterior != $nombre_meta_actual) {
				$data[0] .= '<hr><strong> Meta:</strong><strong class="text-secondary"><br> </b>' . $nombre_meta_actual . '</strong>
				<br> 
				';

				$data[0] .= '<br><label>Acciones: </label>';
			};
			if ($nombre_accion_anterior != $accion) {
				$data[0] .= '
				
				<strong class="text-secondary"><br>' . ($r + 1) . '</span>: </b>' . $accion . '</strong>
				<br> ';
			};
		}
		echo json_encode($data);
		break;


	case 'nombre_tareas':
		$periodo = $_POST['periodo_global'];
		$tareas = $SacListarCondicion->listartareasprograma($id_con_pro, $periodo);
		$data[0] = "";
		for ($r = 0; $r < count($tareas); $r++) {
			$meta_nombre_actual = $tareas[$r]["meta_nombre"];
			$accion_actual = $tareas[$r]["nombre_accion"];
			$responsable_tarea = $tareas[$r]["responsable_tarea"];
			$meta_nombre_anterior = isset($tareas[$r - 1]["meta_nombre"]) ? $tareas[$r - 1]["meta_nombre"] : "";
			$accion_anterior = isset($tareas[$r - 1]["nombre_accion"]) ? $tareas[$r - 1]["nombre_accion"] : "";
			$datosusuario = $SacListarCondicion->DatosUsuario($responsable_tarea);
			$nombre1 = $datosusuario["usuario_nombre"];
			$nombre2 = $datosusuario["usuario_nombre_2"];
			$apellido1 = $datosusuario["usuario_apellido"];
			$apellido2 = $datosusuario["usuario_apellido_2"];
			$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;
			$estado_tarea = ($tareas[$r]["estado_tarea"] == 0)  ? '<span class="bg-danger p-1"><i class="fas fa-times"></i> No Terminada</span>' : '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
			if ($meta_nombre_anterior != $meta_nombre_actual) {
				$data[0] .= '<hr><strong> Meta:</strong><strong class="text-secondary"><br> </b>' . $meta_nombre_actual . '</strong>
				<br> 
				';
				$data[0] .= '<br><label>Acciones:</label>';
			}
			if ($accion_anterior != $accion_actual) {

				$data[0] .= '
				<strong class="text-secondary"><br>' . ($r + 1) . '</span>: </b>' . $accion_actual . '</strong>
				<br> ';
				$data[0] .= '
				<div id="tareas_tabla">
				<table class="table" >
					<thead>
						<tr>
							<th>Nombre de Tarea</th>
							<th>Fecha de Entrega</th>
							<th>Responsable</th>
							<th>Estado</th>
							<th>Link tarea</th>
						</tr>
				</thead>
				<tbody>';
			}
			$data[0] .= '
            <tr>
                <td>' . $tareas[$r]["nombre_tarea"] . '</td>
                <td>' . $tareas[$r]["fecha_entrega_tarea"] . '</td>
                <td>' . $nombre_completo . '</td>
                <td>' . $estado_tarea . '</td>
                <td><a href="' . $tareas[$r]["link_evidencia_tarea"] . '" target="_blank">Ver Evidencia</a></td>
            </tr>
        ';
			$accion_siguiente = isset($tareas[$r + 1]["nombre_accion"]) ? $tareas[$r + 1]["nombre_accion"] : "";
			if ($accion_siguiente != $accion_actual) {
				$data[0] .= '</tbody></table>';
			}
		}
		echo json_encode($data);
		break;

	//listar la meta y nombre de la accion por la condicion institucional 
	case 'nombre_accion_institucional':
		$periodo = $_POST['periodo_global'];
		$nombre_accion_ins = $SacListarCondicion->listaraccioninstitucion($id_con_ins, $periodo);
		$data[0] = "";
		$meta_nombre = '';
		for ($d = 0; $d < count($nombre_accion_ins); $d++) {
			$accion_inst = $nombre_accion_ins[$d]["nombre_accion"];
			$nombre_meta_actual_ins = $nombre_accion_ins[$d]["meta_nombre"];
			$nombre_meta_anterior_ins = isset($nombre_accion_ins[($d - 1)]["meta_nombre"]) ? $nombre_accion_ins[($d - 1)]["meta_nombre"] : "";
			$nombre_accion_anterior_ins = isset($nombre_accion_ins[($d - 1)]["nombre_accion"]) ? $nombre_accion_ins[($d - 1)]["nombre_accion"] : "";
			if ($nombre_meta_anterior_ins != $nombre_meta_actual_ins) {
				$data[0] .= '<hr><strong> Meta:</strong><strong class="text-secondary"><br>' . $nombre_meta_actual_ins . '</strong>
				<br>';
				$data[0] .= '<br><label>Acciones: </label>';
			};
			if ($nombre_accion_anterior_ins != $accion_inst) {
				$data[0] .= '
				
				<strong class="text-secondary"><br> ' . ($d + 1) . '</span>: </b>' . $accion_inst . '</strong>
				<br>';
			};
		}
		echo json_encode($data);
		break;

	//listar las acciones de las inscripciones 
	case 'nombre_meta_con_ins':
		$periodo = $_POST['periodo_global'];
		$nombre_meta_con_ins = $SacListarCondicion->listarMetaConIns($id_con_ins, $periodo);
		$data[0] = "";
		for ($t = 0; $t < count($nombre_meta_con_ins); $t++) {
			$nombre_meta = $nombre_meta_con_ins[$t]["meta_nombre"];
			$data[0] .= '
			<div class="alert alert-success alert-dismissible">
			<h6><i class="icon fa fa-check"> </i>' . $nombre_meta . '</h6>
			</div>';
		}
		echo json_encode($data);
		break;

	//muestra el grafico de las condiciones de programa
	case "grafico1":
		$periodo = $_POST['periodo_global'];
		$data = array();
		$data["datosuno"] = "";
		$rsptacondicion = $SacListarCondicion->mostrarcondicionesprograma();
		$coma = ",";
		$data["datosuno"] .= '[ ';
		for ($i = 0; $i < count($rsptacondicion); $i++) {
			if ($i < count($rsptacondicion) - 1) {
				$coma = ",";
			} else {
				$coma = "";
			}
			$nombre_condicion = $rsptacondicion[$i]["nombre_condicion"];
			$condicion_pro_meta = $SacListarCondicion->contarmetacondicionprograma($rsptacondicion[$i]["id_condicion_programa"], $periodo);
			$contar_condicion = count($condicion_pro_meta);
			$data["datosuno"] .= '{ "y": ' . $contar_condicion . ', "name": "' . $nombre_condicion . '"}' . $coma . '';
		}
		$data["datosuno"] .= ' ]';
		echo json_encode($data);
		break;
	//muestra el grafico de las condiciones institucionales
	case "grafico2":
		$periodo = $_POST['periodo_global'];
		$data = array();
		$data["datosuno"] = "";
		$rsptacondicion = $SacListarCondicion->mostrarcondicionesinstitucional();
		$coma = ",";
		$data["datosuno"] .= '[ ';
		for ($i = 0; $i < count($rsptacondicion); $i++) {
			if ($i < count($rsptacondicion) - 1) {
				$coma = ",";
			} else {
				$coma = "";
			}
			$nombre_condicion = $rsptacondicion[$i]["nombre_condicion"];
			$condicion_pro_meta = $SacListarCondicion->contarcondicioninstitucional($rsptacondicion[$i]["id_condicion_institucional"], $periodo);
			$contar_condicion = count($condicion_pro_meta);
			$data["datosuno"] .= '{ "y": ' . $contar_condicion . ', "name": "' . $nombre_condicion . '"}' . $coma . '';
		}
		$data["datosuno"] .= ' ]';
		echo json_encode($data);

		break;


	case 'tareas_insti':
		$periodo = $_POST['periodo_global'];
		$tareas = $SacListarCondicion->listaraccioninstituciontareas($id_con_ins, $periodo);
		$data[0] = "";
		for ($r = 0; $r < count($tareas); $r++) {
			$meta_nombre_actual = $tareas[$r]["meta_nombre"];
			$accion_actual = $tareas[$r]["nombre_accion"];
			$responsable_tarea = $tareas[$r]["responsable_tarea"];
			$meta_nombre_anterior = isset($tareas[$r - 1]["meta_nombre"]) ? $tareas[$r - 1]["meta_nombre"] : "";
			$accion_anterior = isset($tareas[$r - 1]["nombre_accion"]) ? $tareas[$r - 1]["nombre_accion"] : "";
			$datosusuario = $SacListarCondicion->DatosUsuario($responsable_tarea);
			$nombre1 = $datosusuario["usuario_nombre"];
			$nombre2 = $datosusuario["usuario_nombre_2"];
			$apellido1 = $datosusuario["usuario_apellido"];
			$apellido2 = $datosusuario["usuario_apellido_2"];
			$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;
			$estado_tarea = ($tareas[$r]["estado_tarea"] == 0)  ? '<span class="bg-danger p-1"><i class="fas fa-times"></i> No Terminada</span>' : '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Terminada</span>';
			if ($meta_nombre_anterior != $meta_nombre_actual) {
				$data[0] .= '<hr><strong> Meta:</strong><strong class="text-secondary"><br> </b>' . $meta_nombre_actual . '</strong>
				<br> 
				';
				$data[0] .= '<br><label>Acciones:</label>';
			}
			if ($accion_anterior != $accion_actual) {

				$data[0] .= '
				<strong class="text-secondary"><br>' . ($r + 1) . '</span>: </b>' . $accion_actual . '</strong>
				<br> ';
				$data[0] .= '
				<div id="tareas_tabla">
				<table class="table" >
					<thead>
						<tr>
							<th>Nombre de Tarea</th>
							<th>Fecha de Entrega</th>
							<th>Responsable</th>
							<th>Estado</th>
							<th>Link tarea</th>
						</tr>
				</thead>
				<tbody>';
			}
			$data[0] .= '
            <tr>
                <td>' . $tareas[$r]["nombre_tarea"] . '</td>
                <td>' . $tareas[$r]["fecha_entrega_tarea"] . '</td>
                <td>' . $nombre_completo . '</td>
                <td>' . $estado_tarea . '</td>
                <td><a href="' . $tareas[$r]["link_evidencia_tarea"] . '" target="_blank">Ver Evidencia</a></td>
            </tr>
        ';
			$accion_siguiente = isset($tareas[$r + 1]["nombre_accion"]) ? $tareas[$r + 1]["nombre_accion"] : "";
			if ($accion_siguiente != $accion_actual) {
				$data[0] .= '</tbody></table>';
			}
		}
		echo json_encode($data);
		break;
}
