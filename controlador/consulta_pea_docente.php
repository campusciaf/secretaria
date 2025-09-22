<?php
// error_reporting(1);
session_start();
require_once "../modelos/ConsultaPeaDocente.php";
$consulta_pea_docente = new ConsultaPeaDocente();
$rsptaperiodo = $consulta_pea_docente->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$usuario_identificacion = isset($_POST["usuario_identificacion"]) ? limpiarCadena($_POST["usuario_identificacion"]) : "";

if (!function_exists('array_column')) {
	function array_column(array $input, $columnKey, $indexKey = null) {
		$array = array();
		foreach ($input as $value) {
			if (!isset($value[$columnKey])) {
				continue;
			}
			if (is_null($indexKey)) {
				$array[] = $value[$columnKey];
			} else {
				$array[$value[$indexKey]] = $value[$columnKey];
			}
		}
		return $array;
	}
}

switch ($_GET["op"]) {
	//por medio de la cedula se busca el docente 
	case 'verificardocumento':
		$usuario_identificacion = $_POST["usuario_identificacion"];
		$rspta = $consulta_pea_docente->verificardocumento($usuario_identificacion);
		$data = array();
		$data["0"] = "";
		$reg = $rspta;
		if (count($reg) == 0) {
			$data["0"] .= $usuario_identificacion;
			$data["1"] = false;
		} else {
			for ($i = 0; $i < count($reg); $i++) {
				$data["0"] .= $reg[$i]["usuario_identificacion"];
			}
			$data["1"] = true;
		}
		$results = array($data);
		echo json_encode($results);
		break;

	case 'listar':
		$usuario_identificacion = $_GET["usuario_identificacion"];
		$data = array();
		// Buscamos el docente por medio de la cedula
		$id_usuario_docente = $consulta_pea_docente->listar($usuario_identificacion);
		for ($t = 0; $t < count($id_usuario_docente); $t++) {
			$id_usuario = $id_usuario_docente[$t]["id_usuario"];
		}
		// filtramos en la tabla el docente grupo para obtener el id_docente_grupo
		$docente_grupo_consulta = $consulta_pea_docente->docente_grupo_consulta($id_usuario, $periodo_actual);
		$id_docente_grupo_array = array(); // Almacenar los id_docente_grupo
		// Obtener todos los id_docente_grupo en un array
		for ($o = 0; $o < count($docente_grupo_consulta); $o++) {
			$id_docente_grupo_array[] = $docente_grupo_consulta[$o]["id_docente_grupo"];
		}
		foreach ($id_docente_grupo_array as $id_docente_grupo) {
			$pea_docentes_consulta = $consulta_pea_docente->pea_docentes_consulta($id_docente_grupo);
			// Verificamos si existe el id_docente_grupo en pea_docentes_consulta
			if (!empty($pea_docentes_consulta)) {
				$id_pea_docentes_array = array(); // guardamos los id_pea_docentes
				// Obtener todos los id_pea_docentes
				for ($p = 0; $p < count($pea_docentes_consulta); $p++) {
					$id_pea_docentes_array[] = $pea_docentes_consulta[$p]["id_pea_docentes"];
				}
				// Ahora que tenemos los id_pea_docentes, podemos usarlos en la consulta
				// buscamos por el id_pea_docente las carpetas que tiene creadas el docente
				foreach ($id_pea_docentes_array as $id_pea_docentes) {
					
					$pea_documento_carpeta_consulta = $consulta_pea_docente->pea_documento_carpeta_consulta($id_pea_docentes);
					$id_pea_carpeta_docente = array_column($pea_documento_carpeta_consulta, "id_pea_documento_carpeta");
					$consulta_documentos_pea = $consulta_pea_docente->pea_documentos_consulta($id_pea_carpeta_docente);
					for ($u = 0; $u < count($consulta_documentos_pea); $u++) {
						$nombre_documento = $consulta_documentos_pea[$u]["nombre_documento"];
						$descripcion_documento = $consulta_documentos_pea[$u]["descripcion_documento"];
						$archivo_documento = $consulta_documentos_pea[$u]["archivo_documento"];
						$hora_actividad = $consulta_documentos_pea[$u]["hora_actividad"];
						$ciclo = $consulta_documentos_pea[$u]["ciclo"];
						$linkdescarga = "../files/pea/ciclo" . $ciclo . "/documentos/" . $archivo_documento;
						$fecha_actividad = $consulta_pea_docente->fechaesp($consulta_documentos_pea[$u]["fecha_actividad"]);
						$data[] = array(
							"0" => $nombre_documento,
							"1" => $descripcion_documento,
							"2" => '<a href="' . $linkdescarga . '" target="_blank"><i class="fas fa-file-download"></i>' . " " . $archivo_documento . '</a>',
							"3" => $fecha_actividad,
							"4" => $hora_actividad
						);
					}
				}
			}
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);

		echo json_encode($results);
	break;
	//listar los nombres de meta por usuario
	case 'mostrar_tabla2':
		$data[0] = "";
		$data[0] .= '
			<label class="titulo-4"> Enlaces</label>
				<table id="mostrar_consulta_enlaces" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">Titulo Enlace</th>
				<th scope="col">Enlace</th>
				<th scope="col">Descripción Enlace</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead><tbody>';
		// Buscamos el docente por medio de la cedula
		$id_usuario_docente = $consulta_pea_docente->listar($usuario_identificacion);
		// print_r($id_usuario_docente);
		for ($t = 0; $t < count($id_usuario_docente); $t++) {
			$id_usuario = $id_usuario_docente[$t]["id_usuario"];
		}
		// filtramos en la tabla el docente grupo para obtener el id_docente_grupo
		$docente_grupo_consulta = $consulta_pea_docente->docente_grupo_consulta($id_usuario, $periodo_actual);
		$id_docente_grupo_array = array(); // Almacenar los id_docente_grupo
		// Obtener todos los id_docente_grupo en un array
		for ($o = 0; $o < count($docente_grupo_consulta); $o++) {
			$id_docente_grupo_array[] = $docente_grupo_consulta[$o]["id_docente_grupo"];
		}
		foreach ($id_docente_grupo_array as $id_docente_grupo) {
			$pea_docentes_consulta = $consulta_pea_docente->pea_docentes_consulta($id_docente_grupo);
			// Verificamos si existe el id_docente_grupo en pea_docentes_consulta
			if (!empty($pea_docentes_consulta)) {
				$id_pea_docentes_array = array(); // guardamos los id_pea_docentes
				// Obtener todos los id_pea_docentes
				for ($p = 0; $p < count($pea_docentes_consulta); $p++) {
					$id_pea_docentes_array[] = $pea_docentes_consulta[$p]["id_pea_docentes"];
				}
				// Ahora que tenemos los id_pea_docentes, podemos usarlos en la consulta
				foreach ($id_pea_docentes_array as $id_pea_docentes) {
					$pea_documento_carpeta_consulta = $consulta_pea_docente->pea_documento_carpeta_consulta($id_pea_docentes);
					$id_pea_documento_carpeta = "";
					for ($j = 0; $j < count($pea_documento_carpeta_consulta); $j++) {
						$id_pea_documento_carpeta = $pea_documento_carpeta_consulta[$j]["id_pea_documento_carpeta"];
					}
					$pea_enlaces_consulta = $consulta_pea_docente->pea_enlaces_consulta($id_pea_docentes);
					for ($n = 0; $n < count($pea_enlaces_consulta); $n++) {
						$titulo_enlace = $pea_enlaces_consulta[$n]["titulo_enlace"];
						$enlace = $pea_enlaces_consulta[$n]["enlace"];
						$descripcion_enlace = $pea_enlaces_consulta[$n]["descripcion_enlace"];
						$fecha_enlace = $consulta_pea_docente->fechaesp($pea_enlaces_consulta[$n]["fecha_enlace"]);
						$hora_enlace = $pea_enlaces_consulta[$n]["hora_enlace"];
						$data[0] .= '
							<tr>
								<td>' . $titulo_enlace . '</td>
								<td><a href="' . $enlace . '" target="_blank">' . $enlace . '</a></td>

								<td>' . $descripcion_enlace . '</td>
								<td>' . $fecha_enlace . '</td>
								<td>' . $hora_enlace . '</td>
							</tr>';
					}
				}
			}
		}
		$data[0] .= '</tbody></table>';
		echo json_encode($data);
	break;
	//listar los nombres de meta por usuario
	case 'mostrar_tabla3':
		$data[0] = "";
		$data[0] .= '
			<label class="titulo-4">Ejercicios</label>
				<table id="mostrar_consulta_ejercicio" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
				<thead>
				<tr>
				<th scope="col">Titulo Ejercicio</th>
				<th scope="col">Descripción Ejercicio</th>
				<th scope="col">Ejercicio</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				</tr>
				</thead><tbody>';
		// Buscamos el docente por medio de la cedula
		$id_usuario_docente = $consulta_pea_docente->listar($usuario_identificacion);
		for ($t = 0; $t < count($id_usuario_docente); $t++) {
			$id_usuario = $id_usuario_docente[$t]["id_usuario"];
		}
		// filtramos en la tabla el docente grupo para obtener el id_docente_grupo
		$docente_grupo_consulta = $consulta_pea_docente->docente_grupo_consulta($id_usuario, $periodo_actual);
		$id_docente_grupo_array = array(); // Almacenar los id_docente_grupo
		// Obtener todos los id_docente_grupo en un array
		for ($o = 0; $o < count($docente_grupo_consulta); $o++) {
			$id_docente_grupo_array[] = $docente_grupo_consulta[$o]["id_docente_grupo"];
		}
		foreach ($id_docente_grupo_array as $id_docente_grupo) {
			$pea_docentes_consulta = $consulta_pea_docente->pea_docentes_consulta($id_docente_grupo);
			// Verificamos si existe el id_docente_grupo en pea_docentes_consulta
			if (!empty($pea_docentes_consulta)) {
				$id_pea_docentes_array = array(); // guardamos los id_pea_docentes
				// Obtener todos los id_pea_docentes
				for ($p = 0; $p < count($pea_docentes_consulta); $p++) {
					$id_pea_docentes_array[] = $pea_docentes_consulta[$p]["id_pea_docentes"];
				}
				// Ahora que tenemos los id_pea_docentes, podemos usarlos en la consulta
				foreach ($id_pea_docentes_array as $id_pea_docentes) {

					$pea_documento_carpeta_consulta = $consulta_pea_docente->pea_ejercicios_carpeta($id_pea_docentes);
					$id_pea_ejercicios_carpeta = array_column($pea_documento_carpeta_consulta, "id_pea_ejercicios_carpeta");
					$pea_ejercicios_carpeta_consulta = $consulta_pea_docente->pea_ejercicios($id_pea_ejercicios_carpeta);
					for ($n = 0; $n < count($pea_ejercicios_carpeta_consulta); $n++) {
						$archivo_ejercicios = $pea_ejercicios_carpeta_consulta[$n]["archivo_ejercicios"];
						$ciclo = $pea_ejercicios_carpeta_consulta[$n]["ciclo"];
						$linkdescarga = "../files/pea/ciclo" . $ciclo . "/ejercicios/" . $archivo_ejercicios;
						$nombre_ejercicios = $pea_ejercicios_carpeta_consulta[$n]["nombre_ejercicios"];
						$descripcion_ejercicios = $pea_ejercicios_carpeta_consulta[$n]["descripcion_ejercicios"];
						$fecha_inicio = $consulta_pea_docente->fechaesp($pea_ejercicios_carpeta_consulta[$n]["fecha_inicio"]);
						$hora_publicacion = $pea_ejercicios_carpeta_consulta[$n]["hora_publicacion"];
						$data[0] .= '
							<tr>
								<td>' . $nombre_ejercicios . '</td>
								<td>' . $descripcion_ejercicios . '</td>
								<td>' . '<a href="' . $linkdescarga . '" target="_blank"><i class="fas fa-file-download"></i>' . " " . $archivo_ejercicios . '</a>' . '</td>
								<td>' . $fecha_inicio . '</td>
								<td>' . $hora_publicacion . '</td>
							</tr>';
						// }
					}
				}
			}
		}
		$data[0] .= '</tbody></table>';
		echo json_encode($data);
	break;
}
