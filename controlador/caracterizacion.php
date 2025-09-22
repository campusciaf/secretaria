<?php
require_once "../modelos/Caracterizacion.php";
session_start();

$caracterizacion = new Caracterizacion();
$periodo = $_SESSION['periodo_actual'];
$id_categoria = isset($_POST["id_categoria"]) ? limpiarCadena($_POST["id_categoria"]) : "";
$id_usuario = $_SESSION['id_usuario']; // es el id credencial
$id_caracterizacion = isset($_POST["id_caracterizacion"]) ? limpiarCadena($_POST["id_caracterizacion"]) : "";
$respuesta = isset($_POST["respuesta"]) ? limpiarCadena($_POST["respuesta"]) : "";
$id_variable = isset($_POST["id_variable"]) ? limpiarCadena($_POST["id_variable"]) : "";

date_default_timezone_set("America/Bogota");
$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('h:i:s');


switch ($_GET["op"]) {

	case 'guardaryeditar':

		//Vamos a declarar un array
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$obligatoria = "";

		if (empty($id_caracterizacion)) {

			$rspta = $caracterizacion->insertar($id_usuario, $id_categoria, $id_variable, $respuesta, $fecha_respuesta, $hora_respuesta);
			$data["0"] .= $rspta ? "Variable registrada " : "No se pudo registrar la variable";
			$data["1"] = $_SESSION["id_categoria"];
			$results = array($data);
			echo json_encode($results);
		} else {
			$rspta = $caracterizacion->editar($id_caracterizacion, $id_usuario, $id_variable, $respuesta, $fecha_respuesta, $hora_respuesta);
			$data["0"] .= $rspta ? "Variable actualizada" : "Variable no se pudo actualizar";
			$data["1"] = $_SESSION["id_categoria"];
			$results = array($data);
			echo json_encode($results);
		}
		break;

	case 'guardardata':
		$buscar_datos = $caracterizacion->datosestudiante($id_usuario);
		$id_programa = $buscar_datos["id_programa_ac"];
		$jornada = $buscar_datos["jornada_e"];
		$semestre = $buscar_datos["semestre_estudiante"];

		$rspta = $caracterizacion->insertardata($id_usuario, $id_programa, $jornada, $semestre, $fecha_respuesta, $periodo);
		echo $rspta ? "datos Protegidos" : "Proceso cancelado";
		break;





	case 'guardaryeditaropcion':

		$rspta = $caracterizacion->insertaropcion($id_variable, $nombre_opcion);

		echo $rspta ? "Opcion registrada " : "No se pudo registrar la Opción";
		break;

	case 'aceptoData':
		$datos_acepto = $caracterizacion->aceptoData($id_usuario);
		echo json_encode($datos_acepto);

		break;

	case 'listarbotones':
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo


		$datos_personales = $caracterizacion->datosPersonales($id_usuario);
		$genero = $datos_personales["genero"];



		$rspta = $caracterizacion->listarbotones(); // consulta para listar los botones
		//Codificar el resultado utilizando json

		$data["0"] .= '<div class="row">';
		$data["0"] .= '<div class="col-12">';
		$data["0"] .= '<table class="table">';
		$data["0"] .= '<thead class="thead-dark">';
		$data["0"] .= '<tr>';
		$data["0"] .= '<th style="width:40px"></th>';
		$data["0"] .= '<th id="t-pasoC">Categoria</th>';
		$data["0"] .= '<th></th>';
		$data["0"] .= '<th id="t-pasoE">Estado</th>';
		$data["0"] .= '</tr>';
		$data["0"] .= '</thead>';
		$data["0"] .= '<tbody>';

		for ($i = 0; $i < count($rspta); $i++) { // bucle para imprimir la consulta

			$buscar_nombre_categoria = $caracterizacion->mostrar($rspta[$i]["id_categoria"]); // consulta para buscar el nombre de la categoria
			$tabla = $buscar_nombre_categoria["tabla"]; // variable que contiene el nombre de la tabla donde se reigran los datos de la categoria

			$consultarregistro = $caracterizacion->consultarregistro($id_usuario, $tabla);
			@$miestado = $consultarregistro["estado"];
			if ($consultarregistro and $miestado == 0) {
				$estado = "Actualizado";
			} else {
				$estado = "pendiente";
			}

			$data["0"] .= '<tr  id="t-paso' . $i . '">';

			$rspta2 = $caracterizacion->listar($rspta[$i]["id_categoria"]); // consulta para saber cuantas preguntas son
			$total_preguntas = count($rspta2);

			$rspta3 = $caracterizacion->totalRespuestas($id_usuario, $rspta[$i]["id_categoria"]); // consulta para saber que variables contexto
			$total_respuestas = count($rspta3);

			@$porcentaje = ($total_respuestas * 100) / $total_preguntas;

			if ($genero == "Masculino" and $rspta[$i]["categoria_publico"] == 0 or $genero == "Masculino" and $rspta[$i]["categoria_publico"] == 1) {

				$data["0"] .= '
										<td class="text-center" >
											<img class="img-circle" src="../files/caracterizacion/' . $rspta[$i]["categoria_imagen"] . '" alt="' . $rspta[$i]["categoria_nombre"] . '" width="50px">
										</td>';
				$data["0"] .= '
										<td class="pt-4" >
											<h3 class="" style="font-size:20px">' . $rspta[$i]["categoria_nombre"] . '</h3>
										</td>';
				$data["0"] .= '
										<td class="pt-4" >
											<button id="t-pasoB" class="btn btn-success btn-xs" id="btnagregar" onclick="listar (' . $rspta[$i]["id_categoria"] . ')" ><i class="fa fa-plus-circle" ></i> Empezar </button>
										</td>';
				$data["0"] .= '
										<td>
											' . @$estado . '
										</td>';
			}

			if ($genero == "Femenino" and $rspta[$i]["categoria_publico"] == 0 or $genero == "Femenino" and $rspta[$i]["categoria_publico"] == 2) {

				$data["0"] .= '
										<td class="text-center">
											<img class="img-circle" src="../files/caracterizacion/' . $rspta[$i]["categoria_imagen"] . '" alt="' . $rspta[$i]["categoria_nombre"] . '" width="50px">
										</td>';
				$data["0"] .= '
										<td class="pt-4>
											<h3 class="" style="font-size:20px">' . $rspta[$i]["categoria_nombre"] . '</h3>
										</td>';
				$data["0"] .= '
										<td class="pt-4" >
											<button class="btn btn-success btn-xs" id="btnagregar" onclick="listar(' . $rspta[$i]["id_categoria"] . ')"><i class="fa fa-plus-circle"></i> Empezar </button>
										</td>';
				$data["0"] .= '
										<td>
											' . @$estado . '
										</td>';
			}
			$data["0"] .= '</tr>';
		}

		$data["0"] .= '<tbody';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		$data["0"] .= '</div>';

		$results = array($data);
		echo json_encode($results);
		break;

	case 'listarbotones2':
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo


		$datos_personales = $caracterizacion->datosPersonales($id_usuario);
		$genero = $datos_personales["genero"];



		$rspta = $caracterizacion->listarbotones(); // consulta para listar los botones
		//Codificar el resultado utilizando json

		$data["0"] .= '<div class="row">';

		for ($i = 0; $i < count($rspta); $i++) { // bucle para imprimir la consulta

			$rspta2 = $caracterizacion->listar($rspta[$i]["id_categoria"]); // consulta para saber cuantas preguntas son
			$total_preguntas = count($rspta2);

			$rspta3 = $caracterizacion->totalRespuestas($id_usuario, $rspta[$i]["id_categoria"]); // consulta para saber que variables contexto
			$total_respuestas = count($rspta3);

			@$porcentaje = ($total_respuestas * 100) / $total_preguntas;

			if ($genero == "Masculino" and $rspta[$i]["categoria_publico"] == 0 or $genero == "Masculino" and $rspta[$i]["categoria_publico"] == 1) {

				$data["0"] .= '

			 <div class="col-xl-6 col-lg-12 col-md-6 col-12">
			  <div class="card card-widget widget-user-2">
				<div class="widget-user-header bg-info">
				  <div class="widget-user-image">
				  <img class="img-circle" src="../files/caracterizacion/' . $rspta[$i]["categoria_imagen"] . '" alt="User Avatar">

				  </div>
				  <h3 class="widget-user-username">' . $rspta[$i]["categoria_nombre"] . '</h3>
				  <h5 class="widget-user-desc">
					<button class="btn btn-success btn-xs" id="btnagregar" onclick="listar(' . $rspta[$i]["id_categoria"] . ')"><i class="fa fa-plus-circle"></i> Empezar </button></h5>       
				</div>
				<div class="card-footer p-0">
				  <ul class="nav flex-column">
					<li class="nav-item">
						<a href="#" class="nav-link">Variables <span class="pull-right badge bg-blue">' . $total_preguntas . '</span></a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">Respuestas <span class="pull-right badge bg-aqua">' . $total_respuestas . '</span></a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">Progreso:</a>                
						<div class="progress sm">
						<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $porcentaje . '%">
						  <span class="sr-only">40% Complete (success)</span>
						</div>
					  </div>
					</li>

				  </ul>
				</div>
			  </div>
			</div>';
			}

			if ($genero == "Femenino" and $rspta[$i]["categoria_publico"] == 0 or $genero == "Femenino" and $rspta[$i]["categoria_publico"] == 2) {

				$data["0"] .= ' 
			 
			 <div class="col-xl-6 col-lg-12 col-md-6 col-12">
			  <div class="card card-widget widget-user-2">
				<div class="widget-user-header bg-info">
				  <div class="widget-user-image">
				  <img class="img-circle elevation-2" src="../files/caracterizacion/' . $rspta[$i]["categoria_imagen"] . '" alt="User Avatar">

				  </div>
				  <h3 class="widget-user-username">' . $rspta[$i]["categoria_nombre"] . '</h3>
				  <h5 class="widget-user-desc">
					<button class="btn btn-success btn-xs" id="btnagregar" onclick="listar(' . $rspta[$i]["id_categoria"] . ')"><i class="fa fa-plus-circle"></i> Empezar </button></h5>       
				</div>
				<div class="card-footer p-0">
				  <ul class="nav flex-column">
					<li class="nav-item">
						<a href="#" class="nav-link">Variables <span class="pull-right badge bg-blue">' . $total_preguntas . '</span></a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">Respuestas <span class="pull-right badge bg-aqua">' . $total_respuestas . '</span></a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">Progreso:</a>                
						<div class="progress sm">
						<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $porcentaje . '%">
						  <span class="sr-only">40% Complete (success)</span>
						</div>
					  </div>
					</li>

				  </ul>
				</div>
			  </div>
			</div>';
			}
		}
		$data["0"] .= '</div>';

		$results = array($data);
		echo json_encode($results);
		break;


	case 'listar':
		$_SESSION["id_categoria"] = $_POST["id_categoria"];
		$id_categoria = $_SESSION["id_categoria"]; // variable que contiene el id de la catergoria
		$rspta = $caracterizacion->listar($id_categoria); //Consulta paralistar las variables

		//Vamos a declarar un array
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$data["1"] = ""; //iniciamos el arreglo
		$obligatoria = "";
		$borde = "";
		$numerodiv = 0;
		$i = $_POST["indice"];

		$buscar_nombre_categoria = $caracterizacion->mostrar($id_categoria); // consulta para buscar el nombre de la categoria
		$tabla = $buscar_nombre_categoria["tabla"]; // variable que contiene el nombre de la tabla donde se reigran los datos de la categoria


		$consultarregistro = $caracterizacion->consultarregistro($id_usuario, $tabla);
		if (!$consultarregistro) {
			$crearregistro = $caracterizacion->crearregistro($id_usuario, $tabla);
		}




		if ($i < count($rspta)) { // condicion para saber cuantas preguntas son por categoria

			$verificarcampo = $caracterizacion->verificarCampo($id_usuario, $rspta[$i]["id_variable"]);
			@$id_caracterizacion = $verificarcampo["id_caracterizacion"];
			@$respuesta = $verificarcampo["respuesta"];
			//$data["0"] .= $i;

			//for ($i=0;$i<count($rspta);$i++){// bucle para imprimir la consulta
			$data["0"] .= '<div id="fila' . $numerodiv . '">';

			$data["0"] .= '<center><h3><i class="fas fa-bullhorn"></i> Recuerde no recargar la página </h3></center><br><br>';



			if ($rspta[$i]["id_tipo_pregunta"] == 1) {

				if ($rspta[$i]["prerequisito"] == 0) { // si la pregunta es de respuesta corta

					if ($rspta[$i]["obligatoria"] == 1) {
						$obligatoria = "required";
					} else {
						$obligatoria = "";
					} // condición para saber si es obligatiro el campo
					if ($rspta[$i]["estado_variable"] == 1) {
						$borde = "";
					} else {
						$borde = "border: solid 1px #FF0000";
					} // condición para saber si esta activada

					$data["0"] .= '<div class="well" style="' . $borde . '">';
					$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo
					$data["0"] .= '<div class="input-group">';
					$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
					$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
					$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
					$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
					$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';
					$data["0"] .= '<input type="text" name="respuesta" ' . $obligatoria . ' class="form-control" value="' . $respuesta . '">';
					$data["0"] .= "</div>";
					$data["0"] .= "</div>";
				} else { // la pregunta tiene condición
					$cualcondiciona = $caracterizacion->listarVariableCondiciona($rspta[$i]["prerequisito"]);
					$data["0"] .= 'Esta ligado con';
					$data["0"] .= $cualcondiciona['nombre_variable'] . '<br>';

					$listarsino = $caracterizacion->listarVariableSiNo($rspta[$i]["prerequisito"], $id_usuario); // consulta para saber la respuesta

					$valoropcion = $caracterizacion->valor($listarsino['respuesta']); // consulta para decodificar la respuesta
					$valor = $valoropcion['nombre_opcion'];

					if ($valor == "Si") { // muestra la pregunta
						if ($rspta[$i]["obligatoria"] == 1) {
							$obligatoria = "required";
						} else {
							$obligatoria = "";
						} // condición para saber si es obligatiro el campo
						if ($rspta[$i]["estado_variable"] == 1) {
							$borde = "";
						} else {
							$borde = "border: solid 1px #FF0000";
						} // condición para saber si esta activada

						$data["0"] .= '<div class="well" style="' . $borde . '">';
						$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo



						$data["0"] .= '<div class="input-group">';
						$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
						$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
						$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
						$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
						$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';
						$data["0"] .= '<input type="text" name="respuesta" ' . $obligatoria . ' class="form-control" value="' . $respuesta . '">';


						$data["0"] .= "</div>";
						$data["0"] .= "</div>";
					}
					//else{// no muestra la pregunta
					//$data["0"] .='<script>listar('.$id_categoria.')</script>';
					//}


				}
			} else if ($rspta[$i]["id_tipo_pregunta"] == 2 && $rspta[$i]["prerequisito"] == 0) { // si la pregunta es de respuesta larga

				if ($rspta[$i]["obligatoria"] == 1) {
					$obligatoria = "required";
				} else {
					$obligatoria = "";
				} // condición para saber si es obligatiro el campo
				if ($rspta[$i]["estado_variable"] == 1) {
					$borde = "";
				} else {
					$borde = "border: solid 1px #FF0000";
				} // condición para saber si esta activada

				$data["0"] .= '<div class="well" style="' . $borde . '">';
				$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo
				$data["0"] .= '<div class="input-group">';
				$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
				$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';
				$data["0"] .= '<textarea name="respuesta" ' . $obligatoria . ' class="form-control">' . $respuesta . '</textarea>';
				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			} else if ($rspta[$i]["id_tipo_pregunta"] == 3 && $rspta[$i]["prerequisito"] == 0) { //si la pregunta es una fecha

				if ($rspta[$i]["obligatoria"] == 1) {
					$obligatoria = "required";
				} else {
					$obligatoria = "";
				} // condición para saber si es obligatiro el campo
				if ($rspta[$i]["estado_variable"] == 1) {
					$borde = "";
				} else {
					$borde = "border: solid 1px #FF0000";
				} // condición para saber si esta activada

				$data["0"] .= '<div class="well" style="' . $borde . '">';
				$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo
				$data["0"] .= '<div class="input-group">';
				$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
				$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';
				$data["0"] .= '<input type="date" name="respuesta" ' . $obligatoria . ' class="form-control" value="' . $respuesta . '">';
				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			} else if ($rspta[$i]["id_tipo_pregunta"] == 4) { // si la pregunta es un lista menu
				if ($rspta[$i]["prerequisito"] == 0) { // si la pregunta es normal

					if ($rspta[$i]["obligatoria"] == 1) {
						$obligatoria = "required";
					} else {
						$obligatoria = "";
					} // condición para saber si es obligatiro el campo
					if ($rspta[$i]["estado_variable"] == 1) {
						$borde = "";
					} else {
						$borde = "border: solid 1px #FF0000";
					} // condición para saber si esta activada

					$data["0"] .= '<div class="well" style="' . $borde . '">';
					$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo



					$data["0"] .= '<div class="input-group">';
					$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
					$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
					$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
					$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
					$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';

					$variables_opciones = $caracterizacion->listarVariableOpciones($rspta[$i]["id_variable"]); // consulta para traer los values del select

					$data["0"] .= '<select name="respuesta" ' . $obligatoria . ' class="form-control" >';
					$opcion = trim($respuesta);
					$veractivo = $caracterizacion->listarActivo($opcion);
					$data["0"] .= "<option value='" . @$veractivo["id_variables_opciones"] . "'>" . @$veractivo["nombre_opcion"] .  "</option>";

					for ($j = 0; $j < count($variables_opciones); $j++) // bucle para imprimir las opciones del select
					{
						$data["0"] .= "<option value='" . $variables_opciones[$j]["id_variables_opciones"] . "'>" . $variables_opciones[$j]["nombre_opcion"] .  "</option>";
					}

					$data["0"] .= '</select>';

					$data["0"] .= "</div>";
					$data["0"] .= "</div>";
				} // cierra pregunta normal
				else { // la pregunta tiene condición
					$cualcondiciona = $caracterizacion->listarVariableCondiciona($rspta[$i]["prerequisito"]);
					$data["0"] .= 'Esta ligado con';
					$data["0"] .= $cualcondiciona['nombre_variable'] . '<br>';

					$listarsino = $caracterizacion->listarVariableSiNo($rspta[$i]["prerequisito"], $id_usuario); // consulta para saber la respuesta

					$valoropcion = $caracterizacion->valor($listarsino['respuesta']); // consulta para decodificar la respuesta
					$valor = $valoropcion['nombre_opcion'];

					if ($valor == "Si") { // muestra la pregunta
						if ($rspta[$i]["obligatoria"] == 1) {
							$obligatoria = "required";
						} else {
							$obligatoria = "";
						} // condición para saber si es obligatiro el campo
						if ($rspta[$i]["estado_variable"] == 1) {
							$borde = "";
						} else {
							$borde = "border: solid 1px #FF0000";
						} // condición para saber si esta activada

						$data["0"] .= '<div class="well" style="' . $borde . '">';
						$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo



						$data["0"] .= '<div class="input-group">';
						$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
						$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
						$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
						$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
						$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';

						$variables_opciones = $caracterizacion->listarVariableOpciones($rspta[$i]["id_variable"]); // consulta para traer los values del select

						$data["0"] .= '<select name="respuesta" ' . $obligatoria . ' class="form-control" >';
						$opcion = trim($respuesta);
						$veractivo = $caracterizacion->listarActivo($opcion);

						$data["0"] .= "<option value='" . @$veractivo["id_variables_opciones"] . "'>" . @$veractivo["nombre_opcion"] .  "</option>";

						for ($j = 0; $j < count($variables_opciones); $j++) // bucle para imprimir las opciones del select
						{
							$data["0"] .= "<option value='" . $variables_opciones[$j]["id_variables_opciones"] . "'>" . $variables_opciones[$j]["nombre_opcion"] .  "</option>";
						}

						$data["0"] .= '</select>';

						$data["0"] .= "</div>";
						$data["0"] .= "</div>";
					}

					$data["0"] .= '<h3>Solo de guardar y continuar</h3>';
					//else{// no muestra la pregunta
					// $data["0"] .='<script>listar('.$id_categoria.')</script>';
					// }


				}
			} else if ($rspta[$i]["id_tipo_pregunta"] == 5 && $rspta[$i]["prerequisito"] == 0) { // si la pregunta es seleccionar un departamento

				if ($rspta[$i]["obligatoria"] == 1) {
					$obligatoria = "required";
				} else {
					$obligatoria = "";
				} // condición para saber si es obligatiro el campo
				if ($rspta[$i]["estado_variable"] == 1) {
					$borde = "";
				} else {
					$borde = "border: solid 1px #FF0000";
				} // condición para saber si esta activada

				$data["0"] .= '<div class="well" style="' . $borde . '">';
				$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo



				$data["0"] .= '<div class="input-group">';
				$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
				$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';

				$variables_opciones = $caracterizacion->selectDepartamento(); // consulta para traer los values del select

				$data["0"] .= '<select name="respuesta" ' . $obligatoria . ' class="form-control">';
				$opcion = trim($respuesta);

				$veractivo = $caracterizacion->listarDepActivo($opcion);
				$data["0"] .= "<option value='" . $veractivo["departamento"] . "'>" . $veractivo["departamento"] .  "</option>";

				for ($j = 0; $j < count($variables_opciones); $j++) // bucle para imprimir las opciones del select
				{
					$data["0"] .= "<option value='" . $variables_opciones[$j]["departamento"] . "'>" . $variables_opciones[$j]["departamento"] .  "</option>";
				}

				$data["0"] .= '</select>';

				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			} else if ($rspta[$i]["id_tipo_pregunta"] == 6 && $rspta[$i]["prerequisito"] == 0) { // si la pregunta es seleccionar un municipio

				if ($rspta[$i]["obligatoria"] == 1) {
					$obligatoria = "required";
				} else {
					$obligatoria = "";
				} // condición para saber si es obligatiro el campo
				if ($rspta[$i]["estado_variable"] == 1) {
					$borde = "";
				} else {
					$borde = "border: solid 1px #FF0000";
				} // condición para saber si esta activada

				$data["0"] .= '<div class="well" style="' . $borde . '">';
				$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo



				$data["0"] .= '<div class="input-group">';
				$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
				$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';

				$variables_opciones = $caracterizacion->selectMunicipio(); // consulta para traer los values del select

				$data["0"] .= '<select name="respuesta" ' . $obligatoria . ' class="form-control" >';
				$opcion = trim($respuesta);

				$veractivo = $caracterizacion->listarMunActivo($opcion);
				$data["0"] .= "<option value='" . $veractivo["municipio"] . "'>" . $veractivo["municipio"] .  "</option>";

				for ($j = 0; $j < count($variables_opciones); $j++) // bucle para imprimir las opciones del select
				{
					$data["0"] .= "<option value='" . $variables_opciones[$j]["municipio"] . "'>" . $variables_opciones[$j]["municipio"] .  "</option>";
				}

				$data["0"] .= '</select>';

				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			} else if ($rspta[$i]["id_tipo_pregunta"] == 7 && $rspta[$i]["prerequisito"] == 0) { // si la pregunta es un lista menu

				if ($rspta[$i]["obligatoria"] == 1) {
					$obligatoria = "required";
				} else {
					$obligatoria = "";
				} // condición para saber si es obligatiro el campo
				if ($rspta[$i]["estado_variable"] == 1) {
					$borde = "";
				} else {
					$borde = "border: solid 1px #FF0000";
				} // condición para saber si esta activada

				$data["0"] .= '<div class="well" style="' . $borde . '">';
				$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo



				$data["0"] .= '<div class="input-group">';
				$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
				$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';

				$variables_opciones = $caracterizacion->listarVariableOpciones($rspta[$i]["id_variable"]); // consulta para traer los values del select

				$data["0"] .= '<select name="respuesta" ' . $obligatoria . ' class="form-control" >';
				$opcion = trim($respuesta);
				$veractivo = $caracterizacion->listarActivo($opcion);
				$data["0"] .= "<option value='" . @$veractivo["id_variables_opciones"] . "'>" . @$veractivo["nombre_opcion"] .  "</option>";

				for ($j = 0; $j < count($variables_opciones); $j++) // bucle para imprimir las opciones del select
				{
					$data["0"] .= "<option value='" . $variables_opciones[$j]["id_variables_opciones"] . "'>" . $variables_opciones[$j]["nombre_opcion"] .  "</option>";
				}

				$data["0"] .= '</select>';

				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			} else  if ($rspta[$i]["id_tipo_pregunta"] == 8  && $rspta[$i]["prerequisito"] == 0) { // si la pregunta es correo

				if ($rspta[$i]["obligatoria"] == 1) {
					$obligatoria = "required";
				} else {
					$obligatoria = "";
				} // condición para saber si es obligatiro el campo
				if ($rspta[$i]["estado_variable"] == 1) {
					$borde = "";
				} else {
					$borde = "border: solid 1px #FF0000";
				} // condición para saber si esta activada

				$data["0"] .= '<div class="well" style="' . $borde . '">';
				$data["0"] .= "<b>" . $rspta[$i]["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo
				$data["0"] .= '<div class="input-group">';
				$rspta2 = $caracterizacion->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
				$data["0"] .= '<input type="hidden" name="id_categoria" value="' . $rspta[$i]["id_categoria"] . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_caracterizacion" value="' . $id_caracterizacion . '" class="form-control" >';
				$data["0"] .= '<input type="hidden" name="id_variable" value="' . $rspta[$i]["id_variable"] . '" class="form-control" >';
				$data["0"] .= '<input type="email" name="respuesta" ' . $obligatoria . ' class="form-control" value="' . $respuesta . '">';
				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			}



			$data["0"] .= '</div>';
			$numerodiv++;

			// }

		} // cierra el if
		else {
			$data["1"] .= 1;
		}

		$results = array($data);
		echo json_encode($results);

		break;


	case 'mostrar':

		$rspta = $caracterizacion->mostrar($id_programa);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);

		break;



	case 'crearVariable':

		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";

		$id_categoria = $_POST["id_categoria"]; // variable que contiene el id de la categoria

		$buscar_nombre_categoria = $caracterizacion->mostrar($id_categoria); // consulta para buscar el nombre de la materia
		$nombre_categoria = $buscar_nombre_categoria["nombre_categoria"]; // variable que contiene el nombre de la materia

		$data["0"] .= '<div class="alert alert-info">' . $nombre_categoria . '</div>';

		$data["0"] .= "<h3>Tipo de pregunta</h3>";
		$data["0"] .= "<div class='btn-group'>";
		$rspta = $caracterizacion->selectTipoPregunta();
		for ($i = 0; $i < count($rspta); $i++) {
			$data["0"] .=  '<button type="button" onclick=crearVariableDos(' . $id_categoria . ',' . $rspta[$i]["id_lista_tipo_pregunta"] . ') class="btn btn-default">' . $rspta[$i]["icono_tipo_pregunta"] . ' ' . $rspta[$i]["nombre_tipo_pregunta"] . '</button>';
		}
		$data["0"] .= "</div>";

		$results = array($data);
		echo json_encode($results);

		break;

	case "selectTipoPregunta":
		$rspta = $caracterizacion->selectTipoPregunta();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_lista_tipo_pregunta"] . "'>" . $rspta[$i]["nombre_tipo_pregunta"] .  "</option>";
		}
		break;

	case "insertardatosfinales":

		$id_categoria = $_POST["id_categoria"];
		$campotabla = "";

		$buscar_nombre_categoria = $caracterizacion->mostrar($id_categoria); // consulta para buscar el nombre de la categoria
		$tabla = $buscar_nombre_categoria["tabla"]; // variable que contiene el nombre de la tabla donde se reigran los datos de la categoria

		$data = array();
		$data["0"] = "";
		/* consulta para traer el header de la tabla */
		$data["0"] .= '<thead>';

		$nombre_variables_head = $caracterizacion->datosVariablesHead($id_categoria);
		for ($b = 0; $b < count($nombre_variables_head); $b++) {
			$variable_nombre_head = $nombre_variables_head[$b]["nombre_variable"];

			$data["0"] .= '<th>' . $variable_nombre_head . '</th>';
		}


		$data["0"] .= '</thead>';
		/* ********************************* */


		$id_variables_head = $caracterizacion->datosVariablesHead($id_categoria);

		for ($c = 0; $c < count($id_variables_head); $c++) {

			$campotabla = $c + 1;

			$id_variable_head = $id_variables_head[$c]["id_variable"];
			$id_tipo_pregunta = $id_variables_head[$c]["id_tipo_pregunta"];

			$respuesta = $caracterizacion->respuestaUno($id_usuario, $id_variable_head);
			if ($id_tipo_pregunta == 1 or $id_tipo_pregunta == 8) {
				@$data["0"] .= '<td>' . $respuesta["respuesta"] . '</td>';
				@$actualizarcampo = $caracterizacion->actualizarcampo($id_usuario, $tabla, $respuesta["respuesta"], $campotabla);
			} else {
				@$dato_respuesta = $caracterizacion->respuesta($respuesta["respuesta"]);
				@$data["0"] .= '<td>' . $dato_respuesta["nombre_opcion"] . '</td>';
				@$actualizarcampo = $caracterizacion->actualizarcampo($id_usuario, $tabla, $dato_respuesta["nombre_opcion"], $campotabla);
			}
		}

		$actualizarestado = $caracterizacion->actualizarestado($id_usuario, $tabla, $fecha_respuesta, $hora_respuesta);


		$results = array($data);
		echo json_encode($results);
		break;
}
