<?php
require_once "../modelos/Variables.php";

$variables = new Variables();

$id_categoria_principal = isset($_POST["id_categoria_principal"]) ? limpiarCadena($_POST["id_categoria_principal"]) : "";
$categoria_nombre = isset($_POST["categoria_nombre"]) ? limpiarCadena($_POST["categoria_nombre"]) : "";
$categoria_publico = isset($_POST["categoria_publico"]) ? limpiarCadena($_POST["categoria_publico"]) : "";
$categoria_estado = isset($_POST["categoria_estado"]) ? limpiarCadena($_POST["categoria_estado"]) : "";

$prerequisito = isset($_POST["prerequisito"]) ? limpiarCadena($_POST["prerequisito"]) : "";
$id_variable_pre = isset($_POST["id_variable_pre"]) ? limpiarCadena($_POST["id_variable_pre"]) : "";

$id_tipo_pregunta = isset($_POST["id_tipo_pregunta"]) ? limpiarCadena($_POST["id_tipo_pregunta"]) : "";
$variable = isset($_POST["variable"]) ? limpiarCadena($_POST["variable"]) : "";
$obligatorio = isset($_POST["obligatorio"]) ? limpiarCadena($_POST["obligatorio"]) : "";
$id_categoria = isset($_POST["id_categoria"]) ? limpiarCadena($_POST["id_categoria"]) : "";
$id_variable = isset($_POST["id_variable"]) ? limpiarCadena($_POST["id_variable"]) : "";
$nombre_opcion = isset($_POST["nombre_opcion"]) ? limpiarCadena($_POST["nombre_opcion"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (!file_exists($_FILES['categoria_imagen']['tmp_name']) || !is_uploaded_file($_FILES['categoria_imagen']['tmp_name'])) {
			$imagen = $_POST["imagenactual"];
		} else {
			$ext = explode(".", $_FILES["categoria_imagen"]["name"]);
			if ($_FILES['categoria_imagen']['type'] == "image/jpg" || $_FILES['categoria_imagen']['type'] == "image/jpeg" || $_FILES['categoria_imagen']['type'] == "image/png" || $_FILES['categoria_imagen']['type'] == "application/pdf") {
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["categoria_imagen"]["tmp_name"], "../files/caracterizacion/" . $imagen);
			}
		}
		if (empty($id_categoria_principal)) {
			$rspta = $variables->insertar($categoria_nombre, $categoria_publico, $imagen, $categoria_estado);
			echo $rspta ? "Categoria registrada " : "No se pudo registrar la categoria";
		} else {
			$rspta = $variables->editar($id_categoria, $categoria_nombre, $categoria_publico, $imagen, $categoria_estado);
			echo $rspta ? "Categoria actualizado" : "Categoria no se pudo actualizar";
		}
		break;
	case 'guardaryeditarvariable':
		$rspta = $variables->insertarvariable($id_categoria, $id_tipo_pregunta, $variable, $obligatorio);
		echo $rspta ? "Variable registrada " : "No se pudo registrar la variable";
		break;
	case 'guardaryeditaropcion':
		$rspta = $variables->insertaropcion($id_variable, $nombre_opcion);
		echo $rspta ? "Opcion registrada " : "No se pudo registrar la Opción";
		break;
	case 'guardaryeditarcondicion':
		$rspta = $variables->prerequisito($id_variable_pre, $prerequisito);
		echo $rspta ? "Condición aceptada " : "No se pudo realizar al condición";
		break;
	case 'listar':
		$rspta = $variables->listar();
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$data[] = array(
				"0" => '<a onclick="crearvariable(' . $rspta[$i]["id_categoria"] . ')" class="btn btn-success btn-xs" title="Crear Variable"> 
						<i class="fas fa-plus-square"></i>
					  </a>                    
                      <a onclick="listarVariable(' . $rspta[$i]["id_categoria"] . ')" class="btn btn-primary btn-xs" title="Ver Variable"> 
						<i class="fas fa-eye"></i>
					  </a>',
				"1" => $rspta[$i]["categoria_nombre"],
				"2" => '<img src="../files/caracterizacion/' . $rspta[$i]["categoria_imagen"] . '" width="50px" class="img-circle">',
				"3" => ($rspta[$i]["categoria_estado"] == 1) ? 'Activado' : 'Desactivado',
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
	case 'listarVariable':
		// variable que contiene el id de la catergoria
		$id_categoria = $_POST["id_categoria"]; 
		//Consulta paralistar las variables
		$rspta = $variables->listarVariable($id_categoria); 
		//Vamos a declarar un array
		$data = array();
		//iniciamos el arreglo
		$data["0"] = ""; 
		//pregunta si la pregunta es obligatoria(required)
		$obligatoria = "";
		//
		$borde = "";
		$numerodiv = 0;
		// bucle para imprimir la consulta
		for ($i = 0; $i < count($rspta); $i++) { 
			$data["0"] .= '<div id="fila' . $numerodiv . '">';
			// se ejecuta cuando la pregunta es de tipo respuesta corta
			if ($rspta[$i]["id_tipo_pregunta"] == 1) {
				// condición para saber si es obligatiro el campo
				$obligatoria = ($rspta[$i]["obligatoria"] == 1)?"required":"";
				// condición para saber si esta activada
				$borde = ($rspta[$i]["estado_variable"] == 1) ?"":"border: solid 1px #FF0000";
				//creamos el div que va a contener la informacion
				$data["0"] .= '<div class="card p-1" style="' . $borde . '">';
				// consulta para saber con que esta relacionada
				$rsptapre = $variables->listarVariablePre($rspta[$i]["prerequisito"]); 
				// imprime la variable con que se relaciono
				$data["0"] .= @$rsptapre["nombre_variable"];

				$data["0"] .= '<div class="form-group col-12">';
				//consulta para imprimir el icono
				$rspta2 = $variables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); 
				// 		$data["0"] .="<label><b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b></label>";		
				// 		$data["0"] .='<div class="input-group mb-3">
				//           				<div class="input-group-prepend">
				// 							<span class="input-group-text">'.$rspta2["icono_tipo_pregunta"].'</span>
				//           				</div>';
				//   						$data["0"] .='<input type="text" name="var'.$rspta[$i]["id_variable"].'" '.$obligatoria.' class="form-control">
				//        				</div>
				//     		</div>

				// </div>';
				$data["0"] .= '
						<div class=" text-right">
							<b>(<span class="text-success">' . $obligatoria . '</span>) </b>
						</div>
						<div class="input-group input-group-sm mb-3 mt-3">
							<div class="input-group-append">	
								<span class="btn btn-info tooltipVariable editar_pregunta_' . $rspta[$i]["id_variable"] . '" onclick="editar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Editar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-pen"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-danger tooltipVariable cancelar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="cancelar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Cancelar cambio" data-toggle="tooltip" data-placement="top"><i class="fas fa-arrow-left"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-success tooltipVariable guardar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="guardar_cambios(' . $rspta[$i]["id_variable"] . ')" title="guardar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></span>
							</div>
							<input type="text" class="form-control" value="' . $rspta[$i]["nombre_variable"] . '" id="nombre_variable_editar' . $rspta[$i]["id_variable"] . '" readonly>
							<input type="hidden" id="nombre_real_editar' . $rspta[$i]["id_variable"] . '" value="' . $rspta[$i]["nombre_variable"] . '" >
						</div>';
			} else if ($rspta[$i]["id_tipo_pregunta"] == 2) { // se ejecuta cuando la pregunta es de tipo respuesta larga

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
				$data["0"] .= '<div class="card p-1" style="' . $borde . '">';
				// $data["0"] .= "<b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
				$data["0"] .= '<div class=" text-right">
							<b>(<span class="text-success">' . $obligatoria . '</span>) </b>
						</div>
						<div class="input-group input-group-sm mb-3 mt-3">
							<div class="input-group-append">	
								<span class="btn btn-info tooltipVariable editar_pregunta_' . $rspta[$i]["id_variable"] . '" onclick="editar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Editar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-pen"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-danger tooltipVariable cancelar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="cancelar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Cancelar cambio" data-toggle="tooltip" data-placement="top"><i class="fas fa-arrow-left"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-success tooltipVariable guardar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="guardar_cambios(' . $rspta[$i]["id_variable"] . ')" title="guardar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></span>
							</div>
							<input type="text" class="form-control" value="' . $rspta[$i]["nombre_variable"] . '" id="nombre_variable_editar' . $rspta[$i]["id_variable"] . '" readonly>
							<input type="hidden" id="nombre_real_editar' . $rspta[$i]["id_variable"] . '" value="' . $rspta[$i]["nombre_variable"] . '" >
						</div>';
				$data["0"] .= '<div class="input-group">';
				$rspta2 = $variables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
				$data["0"] .= '<textarea name="var' . $rspta[$i]["id_variable"] . '" ' . $obligatoria . ' class="form-control"></textarea>';
				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			} else if ($rspta[$i]["id_tipo_pregunta"] == 3) { // se ejecuta cuando la pregunta es de tipo fecha

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

				$data["0"] .= '<div class=" p-1" style="' . $borde . '">';
				// $data["0"] .= "<b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo

				$data["0"] .= '<div class=" text-right">
							<b>(<span class="text-success">' . $obligatoria . '</span>) </b>
						</div>
						<div class="input-group input-group-sm mb-3 mt-3">
							<div class="input-group-append">	
								<span class="btn btn-info tooltipVariable editar_pregunta_' . $rspta[$i]["id_variable"] . '" onclick="editar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Editar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-pen"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-danger tooltipVariable cancelar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="cancelar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Cancelar cambio" data-toggle="tooltip" data-placement="top"><i class="fas fa-arrow-left"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-success tooltipVariable guardar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="guardar_cambios(' . $rspta[$i]["id_variable"] . ')" title="guardar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></span>
							</div>
							<input type="text" class="form-control" value="' . $rspta[$i]["nombre_variable"] . '" id="nombre_variable_editar' . $rspta[$i]["id_variable"] . '" readonly>
							<input type="hidden" id="nombre_real_editar' . $rspta[$i]["id_variable"] . '" value="' . $rspta[$i]["nombre_variable"] . '" >
						</div>';
				$data["0"] .= '<div class="input-group">';
				$rspta2 = $variables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';
				$data["0"] .= '<input type="date" name="var' . $rspta[$i]["id_variable"] . '" ' . $obligatoria . ' class="form-control" >';
				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			} else if ($rspta[$i]["id_tipo_pregunta"] == 4) { // se ejecuta cuando la pregunta es de tipo select
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
				$data["0"] .= '<div class="card p-1" style="' . $borde . '">';
				$rspta2 = $variables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				// $data["0"] .="<label>

				// 	<b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>";
				// 	$data["0"] .= '<a onclick=agregarOpcion('.$rspta[$i]["id_variable"].','.$numerodiv.') class="btn btn-success btn-xs" title="Añadir Opción"><i class="fas fa-plus"></i> Añadir Opción</a>';//  boton para agregar una opcion

				// 	$data["0"] .= '<a onclick=prerequisito('.$rspta[$i]["id_variable"].','.$numerodiv.') class="btn bg-purple btn-xs" title="Añadir Condición"><i class="fas fa-code-branch"></i> Si ejecuta</a>';//  boton para agregar una opcion al select
				$data["0"] .= '
							<div class=" text-right">
								<b>(<span class="text-success">' . $obligatoria . '</span>) </b>
								<a onclick="agregarOpcion(' . $rspta[$i]["id_variable"] . ',' . $numerodiv . ')" class="btn btn-success btn-xs" title="Añadir Opción"><i class="fas fa-plus"></i>Añadir Opción</a>
								<a onclick="prerequisito(' . $rspta[$i]["id_variable"] . ',' . $numerodiv . ')" class="btn bg-purple btn-xs" title="Añadir Condición"><i class="fas fa-code-branch"></i>Si ejecuta</a>
							</div>
							<div class="input-group input-group-sm mb-3 mt-3">
								<div class="input-group-append">	
									<span class="btn btn-info tooltipVariable editar_pregunta_' . $rspta[$i]["id_variable"] . '" onclick="editar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Editar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-pen"></i></span>
								</div>
								<div class="input-group-append">	
									<span class="btn btn-danger tooltipVariable cancelar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="cancelar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Cancelar cambio" data-toggle="tooltip" data-placement="top"><i class="fas fa-arrow-left"></i></span>
								</div>
								<div class="input-group-append">	
									<span class="btn btn-success tooltipVariable guardar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="guardar_cambios(' . $rspta[$i]["id_variable"] . ')" title="guardar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></span>
								</div>
								<input type="text" class="form-control" value="' . $rspta[$i]["nombre_variable"] . '" id="nombre_variable_editar' . $rspta[$i]["id_variable"] . '" readonly>
								<input type="hidden" id="nombre_real_editar' . $rspta[$i]["id_variable"] . '" value="' . $rspta[$i]["nombre_variable"] . '" >
							</div>';
				$rsptapre = $variables->listarVariablePre($rspta[$i]["prerequisito"]); // consulta para saber con que esta relacionada
				$data["0"] .= @$rsptapre["nombre_variable"]; // imprime la variable con que se relaciono
				$data["0"] .= "</label>";
				$data["0"] .= '<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">' . $rspta2["icono_tipo_pregunta"] . '</span>
									</div>';
				$variables_opciones = $variables->listarVariableOpciones($rspta[$i]["id_variable"]); // consulta para traer los values del select
				$data["0"] .= '<select name="var' . $rspta[$i]["id_variable"] . '" ' . $obligatoria . ' class="form-control" >';
				// bucle para imprimir las opciones del select
				for ($j = 0; $j < count($variables_opciones); $j++) {
					$data["0"] .= "<option value='" . $variables_opciones[$j]["id_variables_opciones"] . "'>" . $variables_opciones[$j]["nombre_opcion"] .  "</option>";
				}
				$data["0"] .= '</select>';
				$data["0"] .= '</div>
    						</div>';
				$data["0"] .= "</div>";
			} else if ($rspta[$i]["id_tipo_pregunta"] == 5) { // se ejecuta cuadno la pregunta es de tipo departamento
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

				$data["0"] .= '<div class="card p-1" style="' . $borde . '">';
				// $data["0"] .= "<b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo


				$data["0"] .= '<div class=" text-right">
							<b>(<span class="text-success">' . $obligatoria . '</span>) </b>
						</div>
						<div class="input-group input-group-sm mb-3 mt-3">
							<div class="input-group-append">	
								<span class="btn btn-info tooltipVariable editar_pregunta_' . $rspta[$i]["id_variable"] . '" onclick="editar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Editar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-pen"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-danger tooltipVariable cancelar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="cancelar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Cancelar cambio" data-toggle="tooltip" data-placement="top"><i class="fas fa-arrow-left"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-success tooltipVariable guardar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="guardar_cambios(' . $rspta[$i]["id_variable"] . ')" title="guardar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></span>
							</div>
							<input type="text" class="form-control" value="' . $rspta[$i]["nombre_variable"] . '" id="nombre_variable_editar' . $rspta[$i]["id_variable"] . '" readonly>
							<input type="hidden" id="nombre_real_editar' . $rspta[$i]["id_variable"] . '" value="' . $rspta[$i]["nombre_variable"] . '" >
						</div>';

				$data["0"] .= '<div class="input-group">';
				$rspta2 = $variables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';

				$variables_opciones = $variables->listarVariableOpciones($rspta[$i]["id_variable"]); // consulta para traer los values del select

				$data["0"] .= '<select name="var' . $rspta[$i]["id_variable"] . '" ' . $obligatoria . ' class="form-control" >';

				$rsptadep = $variables->selectDepartamento();
				for ($k = 0; $k < count($rsptadep); $k++) {
					$data["0"] .= "<option value='" . $rsptadep[$k]["departamento"] . "'>" . $rsptadep[$k]["departamento"] . "</option>";
				}

				$data["0"] .= '</select>';

				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			} else if ($rspta[$i]["id_tipo_pregunta"] == 6) { // se ejecuta cuando la pregunta es de tipo municipio

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

				$data["0"] .= '<div class="card p-1" style="' . $borde . '">';
				// $data["0"] .= "<b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
				$data["0"] .= '
						<div class=" text-right">
							<b>(<span class="text-success">' . $obligatoria . '</span>) </b>
						</div>
						<div class="input-group input-group-sm mb-3 mt-3">
							<div class="input-group-append">	
								<span class="btn btn-info tooltipVariable editar_pregunta_' . $rspta[$i]["id_variable"] . '" onclick="editar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Editar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-pen"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-danger tooltipVariable cancelar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="cancelar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Cancelar cambio" data-toggle="tooltip" data-placement="top"><i class="fas fa-arrow-left"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-success tooltipVariable guardar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="guardar_cambios(' . $rspta[$i]["id_variable"] . ')" title="guardar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></span>
							</div>
							<input type="text" class="form-control" value="' . $rspta[$i]["nombre_variable"] . '" id="nombre_variable_editar' . $rspta[$i]["id_variable"] . '" readonly>
							<input type="hidden" id="nombre_real_editar' . $rspta[$i]["id_variable"] . '" value="' . $rspta[$i]["nombre_variable"] . '" >
						</div>';

				$data["0"] .= '<div class="input-group">';
				$rspta2 = $variables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';

				$variables_opciones = $variables->listarVariableOpciones($rspta[$i]["id_variable"]); // consulta para traer los values del select

				$data["0"] .= '<select name="var' . $rspta[$i]["id_variable"] . '" ' . $obligatoria . ' class="form-control" >';

				$rsptadep = $variables->selectMunicipio();
				for ($k = 0; $k < count($rsptadep); $k++) {
					$data["0"] .= "<option value='" . $rsptadep[$k]["municipio"] . "'>" . $rsptadep[$k]["municipio"] . "</option>";
				}

				$data["0"] .= '</select>';

				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			} else if ($rspta[$i]["id_tipo_pregunta"] == 7) { // se ejecuta cuando la pregunta es de tipo condicion

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


				$data["0"] .= '<div class="card form-group col-12 p-1">';
				$rspta2 = $variables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono
				// $data["0"] .="<label>
				// <b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>";

				// $data["0"] .= '<a onclick=agregarOpcion('.$rspta[$i]["id_variable"].','.$numerodiv.') class="btn btn-success btn-xs" title="Añadir Opción"><i class="fas fa-plus"></i> Añadir Opción</a>';//  boton para agregar una opcion al select
				$data["0"] .= '
							<div class=" text-right">
								<b>(<span class="text-success">' . $obligatoria . '</span>) </b>
								<a onclick="agregarOpcion(' . $rspta[$i]["id_variable"] . ',' . $numerodiv . ')" class="btn btn-success btn-xs" title="Añadir Opción"><i class="fas fa-plus"></i>Añadir Opción</a>
							</div>
							<div class="input-group input-group-sm mb-3 mt-3">
								<div class="input-group-append">	
									<span class="btn btn-info tooltipVariable editar_pregunta_' . $rspta[$i]["id_variable"] . '" onclick="editar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Editar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-pen"></i></span>
								</div>
								<div class="input-group-append">	
									<span class="btn btn-danger tooltipVariable cancelar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="cancelar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Cancelar cambio" data-toggle="tooltip" data-placement="top"><i class="fas fa-arrow-left"></i></span>
								</div>
								<div class="input-group-append">	
									<span class="btn btn-success tooltipVariable guardar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="guardar_cambios(' . $rspta[$i]["id_variable"] . ')" title="guardar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></span>
								</div>
								<input type="text" class="form-control" value="' . $rspta[$i]["nombre_variable"] . '" id="nombre_variable_editar' . $rspta[$i]["id_variable"] . '" readonly>
								<input type="hidden" id="nombre_real_editar' . $rspta[$i]["id_variable"] . '" value="' . $rspta[$i]["nombre_variable"] . '" >
							</div>';
				$data["0"] .= "</label>";
				$data["0"] .= '<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">' . $rspta2["icono_tipo_pregunta"] . '</span>
									</div>';
				$variables_opciones = $variables->listarVariableOpciones($rspta[$i]["id_variable"]); // consulta para traer los values del select
				$data["0"] .= '<select name="var' . $rspta[$i]["id_variable"] . '" ' . $obligatoria . ' class="form-control" >';
				// bucle para imprimir las opciones del select
				for ($j = 0; $j < count($variables_opciones); $j++) {
					$data["0"] .= "<option value='" . $variables_opciones[$j]["id_variables_opciones"] . "'>" . $variables_opciones[$j]["nombre_opcion"] .  "</option>";
				}
				$data["0"] .= '</select>';
				$data["0"] .= '</div>
                        	</div>';
				$data["0"] .= "</div>";
			}
			if ($rspta[$i]["id_tipo_pregunta"] == 8) { // se ejecuta cuando la pregunta es de tipo respuesta es un correo

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
				$rspta2 = $variables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]); //consulta para imprimir el icono

				$data["0"] .= '<div class="card p-1" style="' . $borde . '">';
				// $data["0"] .= "<b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
				$data["0"] .= '
						<div class=" text-right">
							<b>(<span class="text-success">' . $obligatoria . '</span>) </b>
						</div>
						<div class="input-group input-group-sm mb-3 mt-3">
							<div class="input-group-append">	
								<span class="btn btn-info tooltipVariable editar_pregunta_' . $rspta[$i]["id_variable"] . '" onclick="editar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Editar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-pen"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-danger tooltipVariable cancelar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="cancelar_pregunta(' . $rspta[$i]["id_variable"] . ')" title="Cancelar cambio" data-toggle="tooltip" data-placement="top"><i class="fas fa-arrow-left"></i></span>
							</div>
							<div class="input-group-append">	
								<span class="btn btn-success tooltipVariable guardar_pregunta_' . $rspta[$i]["id_variable"] . ' d-none" onclick="guardar_cambios(' . $rspta[$i]["id_variable"] . ')" title="guardar Variable" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></span>
							</div>
							<input type="text" class="form-control" value="' . $rspta[$i]["nombre_variable"] . '" id="nombre_variable_editar' . $rspta[$i]["id_variable"] . '" readonly>
							<input type="hidden" id="nombre_real_editar' . $rspta[$i]["id_variable"] . '" value="' . $rspta[$i]["nombre_variable"] . '" >
						</div>';
				$data["0"] .= '<div class="input-group mb-3">
                              				<div class="input-group-prepend">
												<span class="input-group-text">' . $rspta2["icono_tipo_pregunta"] . '</span>
                              				</div>';
				$data["0"] .= '<input type="mail" name="var' . $rspta[$i]["id_variable"] . '" ' . $obligatoria . ' class="form-control" >';
				$data["0"] .= "</div>";
				$data["0"] .= "</div>";
			}
			$data["0"] .= '</div>';
			$data["0"] .= '</div>';
			$numerodiv++;
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'recargaropcion':

		$data = array();
		$data["0"] = ""; //iniciamos el arreglo

		$id_variable = $_POST["id_variable"];
		$numerodiv = $_POST["camponumerodiv"];
		$rspta = $variables->listarVariableRecargar($id_variable); //Consulta paralistar las variables

		if ($rspta["obligatoria"] == 1) {
			$obligatoria = "required";
		} else {
			$obligatoria = "";
		} // condición para saber si es obligatiro el campo
		if ($rspta["estado_variable"] == 1) {
			$borde = "";
		} else {
			$borde = "border: solid 1px #FF0000";
		} // condición para saber si esta activada

		$data["0"] .= '<div class="well" style="' . $borde . '">';
		$data["0"] .= "<b>" . $rspta["nombre_variable"] . ' (<span class="text-success">' . $obligatoria . "</span>) </b>"; // variable que contiene el nombre del campo
		$data["0"] .= '<a onclick=agregarOpcion(' . $rspta["id_variable"] . ',' . $numerodiv . ') class="btn btn-success btn-xs" title="Añadir Opción"><i class="fas fa-plus"></i> Añadir Opción</a>'; //  boton para agregar una opcion al select

		$data["0"] .= '<a onclick=prerequisito(' . $rspta["id_variable"] . ',' . $numerodiv . ') class="btn bg-purple btn-xs" title="Añadir Condición"><i class="fas fa-code-branch"></i> Si ejecuta</a>'; //  boton para agregar una opcion al select

		$rsptapre = $variables->listarVariablePre($rspta["prerequisito"]); // consulta para saber con que esta relacionada
		$data["0"] .= $rsptapre["nombre_variable"]; // imprime la variable con que se relaciono


		$data["0"] .= '<div class="input-group">';
		@$rspta2 = $variables->listarTipoPregunta($rspta["id_tipo_pregunta"]); //consulta para imprimir el icono
		$data["0"] .= '<span class="input-group-addon">' . $rspta2["icono_tipo_pregunta"] . '</span>';

		$variables_opciones = $variables->listarVariableOpciones($rspta["id_variable"]); // consulta para traer los values del select

		$data["0"] .= '<select name="var' . $rspta["id_variable"] . '" ' . $obligatoria . ' class="form-control" >';

		for ($j = 0; $j < count($variables_opciones); $j++) // bucle para imprimir las opciones del select
		{
			$data["0"] .= "<option value='" . $variables_opciones[$j]["id_variables_opciones"] . "'>" . $variables_opciones[$j]["nombre_opcion"] .  "</option>";
		}

		$data["0"] .= '</select>';

		$data["0"] .= "</div>";

		$data["0"] .= "</div>";


		$results = array($data);
		echo json_encode($results);

		break;

	case 'mostrar':

		$rspta = $variables->mostrar($id_programa);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);

		break;



	case 'crearVariable':

		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";

		$id_categoria = $_POST["id_categoria"]; // variable que contiene el id de la categoria

		$buscar_nombre_categoria = $variables->mostrar($id_categoria); // consulta para buscar el nombre de la materia
		$nombre_categoria = $buscar_nombre_categoria["categoria_nombre"]; // variable que contiene el nombre de la materia

		$data["0"] .= '<div class="alert alert-info">' . $nombre_categoria . '</div>';

		$data["0"] .= "<h3>Tipo de pregunta</h3>";
		$data["0"] .= "<div class='row btn-group'>";
		$rspta = $variables->selectTipoPregunta();
		for ($i = 0; $i < count($rspta); $i++) {
			$data["0"] .=  '<button type="button" onclick=crearVariableDos(' . $id_categoria . ',' . $rspta[$i]["id_lista_tipo_pregunta"] . ') class="btn btn-default">' . $rspta[$i]["icono_tipo_pregunta"] . ' ' . $rspta[$i]["nombre_tipo_pregunta"] . '</button>';
		}
		$data["0"] .= "</div>";

		$results = array($data);
		echo json_encode($results);

		break;

	case "selectTipoPregunta":
		$rspta = $variables->selectTipoPregunta();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_lista_tipo_pregunta"] . "'>" . $rspta[$i]["nombre_tipo_pregunta"] .  "</option>";
		}
		break;

	case "selectCondicion":
		$rspta = $variables->selectCondicion();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_variable"] . "'>" . $rspta[$i]["nombre_variable"] .  "</option>";
		}
		break;

	case 'desactivar':

		$rspta = $variables->desactivar($id_programa);

		if ($rspta == 0) {
			echo "1";
		} else {

			echo "0";
		}

		break;

	case 'activar':
		$rspta = $variables->activar($id_programa);

		if ($rspta == 0) {
			echo "1";
		} else {
			echo "0";
		}

		break;


	case 'guardaryeditareditar_pregunta':
		$id_variable = $_POST["id_variable"];
		$nombre_variable = $_POST["nombre_variable"];

		$rspta = $variables->editar_pregunta_variables($nombre_variable, $id_variable);
		if($rspta){
			$data = array("exito" => 1, "info" => "Variable actualizado");
		}else{
			$data = array("exito" => 0, "info" => "Variable no se pudo actualizar");
		}
		echo json_encode($data);
		break;
}