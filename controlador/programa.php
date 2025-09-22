<?php
session_start();
require_once "../modelos/Programa.php";
$programa = new Programa();
$id_programa = isset($_POST["id_programa"]) ? limpiarCadena($_POST["id_programa"]) : "";
//variables para agregar el programa 
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$cod_programa_pea = isset($_POST["cod_programa_pea"]) ? limpiarCadena($_POST["cod_programa_pea"]) : "";
$ciclo = isset($_POST["ciclo"]) ? limpiarCadena($_POST["ciclo"]) : "";
$cod_snies = isset($_POST["cod_snies"]) ? limpiarCadena($_POST["cod_snies"]) : "";
$pertenece = isset($_POST["pertenece"]) ? limpiarCadena($_POST["pertenece"]) : "";
$cant_asignaturas = isset($_POST["cant_asignaturas"]) ? limpiarCadena($_POST["cant_asignaturas"]) : "";
$semestres = isset($_POST["semestres"]) ? limpiarCadena($_POST["semestres"]) : "";
$inicio_semestre = isset($_POST["inicio_semestre"]) ? limpiarCadena($_POST["inicio_semestre"]) : "";
$original = isset($_POST["original"]) ? limpiarCadena($_POST["original"]) : "";
$panel_academico = isset($_POST["panel_academico"]) ? limpiarCadena($_POST["panel_academico"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";
$estado_nuevos = isset($_POST["estado_nuevos"]) ? limpiarCadena($_POST["estado_nuevos"]) : "";
$estado_activos = isset($_POST["estado_activos"]) ? limpiarCadena($_POST["estado_activos"]) : "";
$estado_graduados = isset($_POST["estado_graduados"]) ? limpiarCadena($_POST["estado_graduados"]) : "";
$por_renovar = isset($_POST["por_renovar"]) ? limpiarCadena($_POST["por_renovar"]) : "";
$escuela = isset($_POST["escuela"]) ? limpiarCadena($_POST["escuela"]) : "";
$universidad = isset($_POST["universidad"]) ? limpiarCadena($_POST["universidad"]) : "";
$terminal = isset($_POST["terminal"]) ? limpiarCadena($_POST["terminal"]) : "";
$relacion = isset($_POST["relacion"]) ? limpiarCadena($_POST["relacion"]) : "";
$programa_director = isset($_POST["programa_director"]) ? limpiarCadena($_POST["programa_director"]) : "";
$centro_costo_yeminus = isset($_POST["centro_costo_yeminus"]) ? limpiarCadena($_POST["centro_costo_yeminus"]) : "";
$codigo_producto = isset($_POST["codigo_producto"]) ? limpiarCadena($_POST["codigo_producto"]) : "";

$carnet = isset($_POST["carnet"]) ? limpiarCadena($_POST["carnet"]) : "";
$corte = isset($_POST["corte"]) ? limpiarCadena($_POST["corte"]) : "";
$corte1 = isset($_POST["corte1"]) ? limpiarCadena($_POST["corte1"]) : 0;
$corte2  = isset($_POST["corte2"]) ? limpiarCadena($_POST["corte2"]) : 0;
$corte3  = isset($_POST["corte3"]) ? limpiarCadena($_POST["corte3"]) : 0;
$corte4  = isset($_POST["corte4"]) ? limpiarCadena($_POST["corte4"]) : 0;
$corte5  = isset($_POST["corte5"]) ? limpiarCadena($_POST["corte5"]) : 0;
$corte6  = isset($_POST["corte6"]) ? limpiarCadena($_POST["corte6"]) : 0;
$corte7  = isset($_POST["corte7"]) ? limpiarCadena($_POST["corte7"]) : 0;
$corte8  = isset($_POST["corte8"]) ? limpiarCadena($_POST["corte8"]) : 0;
$corte9  = isset($_POST["corte9"]) ? limpiarCadena($_POST["corte9"]) : 0;
$corte10 = isset($_POST["corte10"]) ? limpiarCadena($_POST["corte10"]) : 0;
/* guardar pecuniario */
$id_programa_monetizar = isset($_POST["id_programa_monetizar"]) ? limpiarCadena($_POST["id_programa_monetizar"]) : "";
$valor_pecuniario = isset($_POST["valor_pecuniario"]) ? limpiarCadena($_POST["valor_pecuniario"]) : "";
/* guardar valor  */
$id_programa_monetizar_semestres = isset($_POST["id_programa_monetizar_semestres"]) ? limpiarCadena($_POST["id_programa_monetizar_semestres"]) : "";
$semestrep = isset($_POST["semestre"]) ? limpiarCadena($_POST["semestre"]) : "";
$matricula_ordinaria = isset($_POST["matricula_ordinaria"]) ? limpiarCadena($_POST["matricula_ordinaria"]) : "";
$aporte_social = isset($_POST["aporte_social"]) ? limpiarCadena($_POST["aporte_social"]) : "";
$matricula_extraordinaria = isset($_POST["matricula_extraordinaria"]) ? limpiarCadena($_POST["matricula_extraordinaria"]) : "";
$valor_por_credito = isset($_POST["valor_por_credito"]) ? limpiarCadena($_POST["valor_por_credito"]) : "";
$pago_renovar = isset($_POST["pago_renovar"]) ? limpiarCadena($_POST["pago_renovar"]) : "";
/* ***************** */
// editar valores
$id_lista_precio_programa = isset($_POST["id_lista_precio_programa"]) ? limpiarCadena($_POST["id_lista_precio_programa"]) : "";
// actualziar datos
$id_lista_precio_programa_m = isset($_POST["id_lista_precio_programa_m"]) ? limpiarCadena($_POST["id_lista_precio_programa_m"]) : "";
$id_programa_m = isset($_POST["id_programa_m"]) ? limpiarCadena($_POST["id_programa_m"]) : "";
$semestre_m = isset($_POST["semestre_m"]) ? limpiarCadena($_POST["semestre_m"]) : "";
$ordinaria_m = isset($_POST["ordinaria_m"]) ? limpiarCadena($_POST["ordinaria_m"]) : "";
$aporte_m = isset($_POST["aporte_m"]) ? limpiarCadena($_POST["aporte_m"]) : "";
$extra_m = isset($_POST["extra_m"]) ? limpiarCadena($_POST["extra_m"]) : "";
$valor_credito_m = isset($_POST["valor_credito_m"]) ? limpiarCadena($_POST["valor_credito_m"]) : "";
$pago_renovar_m = isset($_POST["pago_renovar_m"]) ? limpiarCadena($_POST["pago_renovar_m"]) : "";
$corte = isset($_POST["corte"]) ? limpiarCadena($_POST["corte"]) : "";
switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($id_programa)) {
			$rspta = $programa->insertar($nombre, $cod_programa_pea, $ciclo, $cod_snies, $pertenece, $cant_asignaturas, $semestres, $inicio_semestre, $original, $estado, $estado_nuevos, $estado_activos, $estado_graduados, $panel_academico, $por_renovar, $escuela, $universidad, $terminal, $relacion, $programa_director, $centro_costo_yeminus, $codigo_producto, $carnet, $corte, $corte1, $corte2, $corte3, $corte4, $corte5, $corte6, $corte7, $corte8, $corte9, $corte10);
			$data = ($rspta)?array("exito" =>1, "info" => "Programa registrado"): array("exito" => 1, "info" => "No se pudo registrar el programa");
		} else {
			$rspta = $programa->editar($id_programa, $nombre, $cod_programa_pea, $ciclo, $cod_snies, $pertenece, $cant_asignaturas, $semestres, $inicio_semestre, $original, $estado, $estado_nuevos, $estado_activos, $estado_graduados, $panel_academico, $por_renovar, $escuela, $universidad, $terminal, $relacion, $programa_director,$centro_costo_yeminus, $codigo_producto, $carnet);
			$data = ($rspta) ? array("exito" => 1, "info" => "Programa Actualizado") : array("exito" => 1, "info" => "No se pudo Actualizado el programa");
		}
		echo json_encode($data);
		break;
	case 'listar':
		$rspta = $programa->listar();
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$buscarnombreciclo = $programa->buscarnombreciclo($rspta[$i]["ciclo"]);
			$buscarnombreescuela = $programa->buscarnombreescuela($rspta[$i]["escuela"]);
			$est = ($rspta[$i]["estado"]) ? '1' : '0';
			$data[] = array(
				"0" => '<div class="btn-group">' . (($rspta[$i]["estado"] == 1) ? '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $rspta[$i]["id_programa"] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
				<button class="btn bg-purple btn-xs" onclick=cortes("' . $rspta[$i]["id_programa"] . '","' . $rspta[$i]["cortes"] . '","' . $est . '") title="Cortes"><i class="fas fa-percent"></i></button>
				<button class="btn btn-success btn-xs" onclick=monetizar("' . $rspta[$i]["id_programa"] . '") title="Monetizar"><i class="fas fa-dollar-sign"></i></button>' . '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $rspta[$i]["id_programa"] . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button>' :
					'<button class="btn btn-success btn-xs" onclick=monetizar("' . $rspta[$i]["id_programa"] . '") title="Monetizar"><i class="fas fa-dollar-sign"></i></button>
				<button class="btn bg-purple btn-xs" onclick=cortes("' . $rspta[$i]["id_programa"] . '","' . $rspta[$i]["cortes"] . '","' . $est . '") title="Cortes"><i class="fas fa-percent"></i></button>' .
					'<button class="btn btn-primary btn-xs" onclick="activar(' . $rspta[$i]["id_programa"] . ')" title="Activar"><i class="fas fa-lock"></i></button>') .'</div>',
				"1" => '<span title="id programa: ' . $rspta[$i]["id_programa"] . '">' . $rspta[$i]["nombre"] . '</span>',
				"2" => $rspta[$i]["cod_programa_pea"],
				"3" => $rspta[$i]["ciclo"] . ' - ' . @$buscarnombreciclo["nombre_programa"],
				"4" => $rspta[$i]["cod_snies"],
				"5" => $rspta[$i]["cant_asignaturas"],
				"6" => $rspta[$i]["semestres"],
				"7" => $rspta[$i]["cortes"],
				"8" => $rspta[$i]["inicio_semestre"],
				"9" => $buscarnombreescuela["escuelas"],
				"10" => ($rspta[$i]["estado"]) ? '<small class="badge badge-success">Activo</small>' : '<small class="badge badge-danger">Inactivo</small>',
			);
			$i++;
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'mostrar':
		$rspta = $programa->mostrar($id_programa);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case "selectEscuela":
		$rspta = $programa->selectEscuela();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_escuelas"] . "'>" . $rspta[$i]["escuelas"] . "</option>";
		}
		break;
	case "selectRelacion":
		$rspta = $programa->selectRelacion();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_relacion"] . "'>" . $rspta[$i]["nombre_relacion"] . "</option>";
		}
		break;
	case "selectCiclo":
		$rspta = $programa->selectCiclo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_ciclo"] . "'>" . $rspta[$i]["nombre_programa"] . "</option>";
		}
		break;
	case "selectDirector":
		$rspta = $programa->selectDirector();
		for ($i = 0; $i < count($rspta); $i++) {
			$nombre = $rspta[$i]["usuario_apellido"] . " " . $rspta[$i]["usuario_apellido_2"] . " " . $rspta[$i]["usuario_nombre"] . " " .  $rspta[$i]["usuario_nombre_2"];
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $nombre . "</option>";
		}
		break;
	case 'desactivar':
		$rspta = $programa->desactivar($id_programa);
		if ($rspta == 0) {
			echo "1";
		} else {
			echo "0";
		}
		break;
	case 'activar':
		$rspta = $programa->activar($id_programa);
		if ($rspta == 0) {
			echo "1";
		} else {
			echo "0";
		}
		break;
	case 'listarCortes':
		$id_programa = $_POST['id_programa'];
		$cantidad = $_POST['cantidad'];
		$data['conte'] = "";
		$da = $programa->consultaCortes($id_programa);
		if ($da) {
			$data['conte'] .= '<div class="row">
			<input type="hidden" name="id" value="' . $id_programa . '" class="form-control id">
			<input type="hidden" name="cantidad" value="' . $cantidad . '" class="form-control canti">
			<input type="hidden" name="medio" value="1" class="form-control canti">';
			for ($i = 0; $i < count($da); $i++) {
				$data['conte'] .= '<div class="col-xl-4 col-lg-4 col-md-4 col-12">
						<label>Corte' . ($i + 1) . '</label>
						<input type="hidden" name="id' . ($i + 1) . '" value="' . $da[$i]['id_corte_programa'] . '">
						<input type="number" name="c' . ($i + 1) . '" value="' . $da[$i]['valor_corte'] . '" class="form-control c' . ($i + 1) . '">
					</div>';
			}
			$data['conte'] .= '</br></br><div class="col-xl-12 col 12">
						<br><button type="submit" class="btn btn-warning btn-block">Editar</button>
					</div>';
			$data['conte'] .= '</div>';
			$data['status'] = "ok";
		} else {
			if ($cantidad !== "0") {
				$data['conte'] .= '<div class="row">
				<input type="hidden" name="id" value="' . $id_programa . '" class="form-control id">
				<input type="hidden" name="cantidad" value="' . $cantidad . '" class="form-control canti">
				<input type="hidden" name="medio" value="0" class="form-control canti">';
				for ($i = 0; $i < $cantidad; $i++) {
					$data['conte'] .= '<div class="col-xl-4 col-lg-4 col-md-4 col-12">
							<label>Corte' . ($i + 1) . '</label>
							<br><input type="number" name="c' . ($i + 1) . '" class="form-control c' . ($i + 1) . '" required>
						</div>';
				}
				$data['conte'] .= '</br></br><div class="col-xl-12 col-12 text-right">
							<button type="submit" class="btn btn-success btn-block">Agregar</button>
						</div>';
				$data['conte'] .= '</div>';
				$data['status'] = "ok";
			} else {
				$data['status'] = "No hay cortes para agregar.";
			}
		}
		echo json_encode($data);
		break;
	case 'agregar':
		@$c1 = ($_POST['c1'] !== "") ? $_POST['c1'] : "";
		@$c2 = ($_POST['c2'] !== "") ? $_POST['c2'] : "";
		@$c3 = ($_POST['c3'] !== "") ? $_POST['c3'] : "";
		@$c4 = ($_POST['c4'] !== "") ? $_POST['c4'] : "";
		@$c5 = ($_POST['c5'] !== "") ? $_POST['c5'] : "";
		@$c6 = ($_POST['c6'] !== "") ? $_POST['c6'] : "";
		$cantidad = $_POST['cantidad'];
		$id = $_POST['id'];
		$medio = $_POST['medio'];
		if ($medio == "0") {
			$programa->agregarcorte($c1, $c2, $c3, $c4, $c5, $c6, $cantidad, $id);
		} else {
			@$id1 = ($_POST['id1'] !== "") ? $_POST['id1'] : "";
			@$id2 = ($_POST['id2'] !== "") ? $_POST['id2'] : "";
			@$id3 = ($_POST['id3'] !== "") ? $_POST['id3'] : "";
			@$id4 = ($_POST['id4'] !== "") ? $_POST['id4'] : "";
			@$id5 = ($_POST['id5'] !== "") ? $_POST['id5'] : "";
			@$id6 = ($_POST['id6'] !== "") ? $_POST['id6'] : "";
			$programa->editarcorte($c1, $c2, $c3, $c4, $c5, $c6, $cantidad, $id, $id1, $id2, $id3, $id4, $id5, $id6);
		}
		break;
	case 'monetizar':
		$data['0'] = ""; // contiene el valor pecuniario
		$data['1'] = ""; // contiene el valor pecuniario
		$traerperiodopecuniario = $programa->traerperiodopecuniario(); // traer el periodo pecuniario de la tabla periodo actual
		$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
		$traerdatosprograma = $programa->mostrar($id_programa); // trae los datos del programa
		$nombre_programa = $traerdatosprograma["nombre"];
		$data['1'] .= $nombre_programa;
		$id_programa = $_POST["id_programa"];
		$traervalorpecuniario = $programa->lista_precio_pecuniario($id_programa, $periodo_pecuniario);
		@$valorpecuniario = $traervalorpecuniario["valor_pecuniario"];
		if ($valorpecuniario > 0) {
			$data['0'] .= $valorpecuniario;
		} else {
			// no tiene valor
			$data['0'] .= ""; 
		}
		echo json_encode($data);
		break;
	case 'guardarpecuniario':
		$data['0'] = "";
		$traerperiodopecuniario = $programa->traerperiodopecuniario(); // traer el periodo pecuniario de la tabla periodo actual
		$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
		// guarda el valor pecuniario
		$guardarpecuniario = $programa->guardarpecuniario($id_programa_monetizar, $valor_pecuniario, $periodo_pecuniario); 
		$data['0'] .= $id_programa_monetizar;
		echo json_encode($data);
		break;
	case 'guardarsemestres':
		$data['0'] = "";
		// traer el periodo pecuniario de la tabla periodo actual
		$traerperiodopecuniario = $programa->traerperiodopecuniario(); 
		$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
		// guarda el valor pecuniario por semestre
		$guardarsemestres = $programa->guardarsemestres($id_programa_monetizar_semestres, $periodo_pecuniario, $semestrep, $matricula_ordinaria, $aporte_social, $matricula_extraordinaria, $valor_por_credito, $pago_renovar); 
		$data['0'] .= $id_programa_monetizar_semestres;
		echo json_encode($data);
		break;
	case 'tablaprecios':
		$data['0'] = "";
		$id_programa = $_POST["id_programa"];
		$traerperiodopecuniario = $programa->traerperiodopecuniario(); // traer el periodo pecuniario de la tabla periodo actual
		$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
		$tablaprecios = $programa->tablaprecios($id_programa, $periodo_pecuniario); // traer los precios del programa
		$por_renovar = "";
		$data['0'] .= '
				<div class="col-12 py-4 tono-3">
					<div class="row align-items-center">
						<div class="pl-3">
						<span class="rounded bg-light-blue p-2 text-primary ">
								<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
						</span> 	
						</div>
						<div class="col-10">
						<div class="col-5 fs-14 line-height-18"> 
						<span class="">Precios</span> <br>
						<span class="text-semibold fs-18 titulo-2 line-height-16">' . $periodo_pecuniario . '</span> 
						</div> 
						</div>
					</div>
				</div>
				<div class="col-12 p-4">
				<table class="table table-hover">
					<tr>
						<th>Opc.</th>
						<th>Semestre</th>
						<th>Valor ordinaria</th>
						<th>Aporte social</th>
						<th>Valor extraordinaria</th>
						<th>Valor por crédito</th>
						<th>Pago</th>
					</tr>';
		for ($i = 0; $i < count($tablaprecios); $i++) {
			if ($tablaprecios[$i]["pago_renovar"] == 1) {
				$por_renovar = "Normal";
				$text_linea = "text-black";
			} else {
				$por_renovar = "Con Nivelatorio";
				$text_linea = "text-blue";
			}
			$data["0"] .= '<tr class="titulo-2 line-height-16 fs-14">';
			$data["0"] .= '<td class="' . $text_linea . '">
								<button title="Eliminar" class="btn btn-danger btn-xs" onclick="eliminar(' . $tablaprecios[$i]["id_lista_precio_programa"] . ',' . $id_programa . ')"><i class="fa fa-trash" aria-hidden="true"></i></button>
								<button title="Editar" class="btn btn-warning btn-xs" onclick="mostrareditar(' . $tablaprecios[$i]["id_lista_precio_programa"] . ',' . $id_programa . ')" title="Editar"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>
							</td>';
			$data["0"] .= '<td class="' . $text_linea . '">' . $tablaprecios[$i]["semestre"] . '</td>';
			$data["0"] .= '<td class="' . $text_linea . '">' . number_format($tablaprecios[$i]["matricula_ordinaria"]) . '</td>';
			$data["0"] .= '<td class="' . $text_linea . '">$ ' . $tablaprecios[$i]["aporte_social"] . '</td>';
			$data["0"] .= '<td class="' . $text_linea . '">$ ' . number_format($tablaprecios[$i]["matricula_extraordinaria"]) . '</td>';
			$data["0"] .= '<td class="' . $text_linea . '">$' . number_format($tablaprecios[$i]["valor_por_credito"]) . '</td>';
			$data["0"] .= '<td class="' . $text_linea . '">' . $por_renovar . '</td>';
			$data["0"] .= '</tr>';
		}
		$data['0'] .= '
				</table>
			</div>';
		echo json_encode($data);
		break;
	case 'eliminar':
		$id_lista_precio_programa = $_POST['id_lista_precio_programa'];
		$rspta = $programa->eliminar($id_lista_precio_programa);
		if (!$rspta) {
			$data['status'] = 1;
		} else {
			$data['status'] = 0;
		}
		echo json_encode($data);
		break;
	case 'actualizarpecuniario':
		$id_programa = $_POST['id_programa'];
		$valor = $_POST["valor"];
		$traerperiodopecuniario = $programa->traerperiodopecuniario(); // traer el periodo pecuniario de la tabla periodo actual
		$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
		$rspta = $programa->actualizarPecuniario($id_programa, $valor, $periodo_pecuniario);
		if (!$rspta) {
			$data['status'] = 1;
		} else {
			$data['status'] = 0;
		}
		echo json_encode($data);
		break;
	case 'mostrareditar':
		$rspta = $programa->mostrareditar($id_lista_precio_programa);
		echo json_encode($rspta);
		break;
	case 'editarvalores':
		$data['status'] = "";
		$data['id_programa'] = "";
		$rspta = $programa->editarvalores($id_lista_precio_programa_m, $semestre_m, $ordinaria_m, $aporte_m, $extra_m, $valor_credito_m, $pago_renovar_m);
		if ($rspta == 0) {
			$data['status'] = 1;
			$data['id_programa'] = $id_programa_m;
		} else {
			$data['status'] = 2;
			$data['id_programa'] = $id_programa_m;
		}
		echo json_encode($data);
		break;
	case 'mostrar_agregar_programa':
		$cortes_cantidad = $_POST['cortes_cantidad'];
		if ($cortes_cantidad >= 1 && $cortes_cantidad <= 10) {
			$html_cortes = '<div class="row">';
			for ($i = 1; $i <= $cortes_cantidad; $i++) {
				$html_cortes .= '
						<div class="form-group col-sm-12 col-md-4 col-lg-3" id="porcentaje' . $i . '">
							<label>#Créditos ' . $i . ' </label>
							<input type="number" id="corte' . $i . '" name="corte' . $i . '" class="form-control campo-corte">
						</div>';
			}
			$html_cortes .= '</div>';
		} else {
			$html_cortes = '<div class="alert alert-danger col-sm-3" role="alert">Debes escoger un numero entre 1 y 10.
					</div>';
		}
		// trae la ultima posicion de codigo pea
		$rspta = $programa->traer_ultima_posicion();
		$ultimo_cod_programa_pea = $rspta["cod_programa_pea"] + 1;
		// trae una lista para los ciclos
		$nombre_programa = "";
		// $ciclos_options = "";
		// $traer_ciclos = $programa->traer_ciclos();
		// $ciclos_options = '';
		// foreach ($traer_ciclos as $ciclo) {
		// 	$ciclo_numero = $ciclo["nombre_programa"]; // Suponiendo que la columna se llama "numero"
		// 	$id_ciclo = $ciclo["id_ciclo"]; // Suponiendo que la columna se llama "numero"
		// 	$ciclos_options .= '<option value="' . $id_ciclo . '">' . $ciclo_numero . '</option>';
		// }
		//declaramos un array para llevar los datos a la vista 
		$data = array(
			'ultimo_pea' => $ultimo_cod_programa_pea,
			'cortes_cantidad' => $html_cortes
		);
		echo json_encode($data);
		break;
}
