<?php
require_once "../modelos/Pea.php";
$pea = new Pea();
$id_tema = isset($_POST["id_tema"]) ? limpiarCadena($_POST["id_tema"]) : "";
$id_pea = isset($_POST["id_pea"]) ? limpiarCadena($_POST["id_pea"]) : "";
$conceptuales = isset($_POST["conceptuales"]) ? limpiarCadena($_POST["conceptuales"]) : "";
$procedimentales = isset($_POST["procedimentales"]) ? limpiarCadena($_POST["procedimentales"]) : "";
$actitudinales = isset($_POST["actitudinales"]) ? limpiarCadena($_POST["actitudinales"]) : "";
$criterios = isset($_POST["criterios"]) ? limpiarCadena($_POST["criterios"]) : "";
$id_materia = isset($_POST["id_materia"]) ? limpiarCadena($_POST["id_materia"]) : "";
$version = isset($_POST["version"]) ? limpiarCadena($_POST["version"]) : "";
$fecha_aprobacion = isset($_POST["fecha_aprobacion"]) ? limpiarCadena($_POST["fecha_aprobacion"]) : "";
$id_pea_referencia = isset($_POST["id_pea_referencia"]) ? limpiarCadena($_POST["id_pea_referencia"]) : "";
$id_pea_2 = isset($_POST["id_pea_2"]) ? limpiarCadena($_POST["id_pea_2"]) : "";
$referencia = isset($_POST["referencia"]) ? limpiarCadena($_POST["referencia"]) : "";
switch ($_GET["op"]) {
	case 'guardaryeditar':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		if (empty($id_tema)) { //si el id esta vacio es que se insertara un nuevo tema
			$rspta1 = $pea->numeroTema($id_pea); // consulta para saber que tema sigue
			$sesion = count($rspta1) + 1; // crea e numero del tema que es la sesion #
			$rspta = $pea->insertar($id_pea, $sesion, $conceptuales); // inserta el tema
			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
		} else { // si el id tiene algo
			$rspta = $pea->editar($id_tema, $conceptuales);
			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		$data["1"] = $id_pea;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'guardarpea':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$dato_programa = $pea->mostrar($id_materia); // consulta para saber el programa a que pertenece
		$id_del_programa = $dato_programa["id_programa_ac"]; //variable que contiene el id del programa
		$nombre_materia = $dato_programa["nombre"]; //variable que contieneel nombre de la materia
		$semestre = $dato_programa["semestre"]; //variable que contiene el id del programa
		$buscar_ciclo = $pea->mostrarDatosPrograma($id_del_programa);
		$nombre_programa = $buscar_ciclo["nombre"];
		$ciclo = $buscar_ciclo["ciclo"];
		$rspta = $pea->insertarPea($ciclo, $id_del_programa, $semestre, $nombre_materia, $id_materia, $fecha_aprobacion, $version); // inserta el tema
		$data["0"] .= $rspta ? "PEA registrado " : "No se pudo registrar el PEA";
		$data["1"] .= $nombre_programa;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'guardaryeditarreferencia':
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		if (empty($id_pea_referencia)) { //si el id esta vacio es que se insertara una nueva referencia
			$rspta = $pea->insertarreferencia($id_pea_2, $referencia); // inserta el tema
			$resultado = $rspta ? "1" : "2";
			$data["0"] .= $resultado;
		} else { // si el id_referencia tiene algo
			$rspta = $pea->editarreferencia($id_pea_referencia, $referencia);
			$resultado = $rspta ? "3" : "4";
			$data["0"] .= $resultado;
		}
		$data["1"] = $id_pea_2;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'listar':
		$programa = $_GET["programa"]; // variable que contiene el nombre del programa
		$rspta = $pea->listar($programa);
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$respea = $pea->pea($rspta[$i]["id_programa_ac"], $rspta[$i]["id"]); //id_programa_ac contiene el id del programa y id contene el id de la materia
			//consultamos unicamente los pea que estan activos para mostrarlos.
			$respea_activo = $pea->pea_consulta_estado_activo($rspta[$i]["id_programa_ac"], $rspta[$i]["id"]);
			// si tiene un registro tiene pea acitvo.
			if (count($respea_activo) > 0) {
				$estado_pea = '<span class="badge bg-success">Sí</span>';
			} else {
				$estado_pea = '<span class="badge bg-danger">No</span>';
			}
			$data[] = array(
				"0" => '<a onclick="crearpea(' . $rspta[$i]["id_programa_ac"] . ',' . $rspta[$i]["id"] . ')" class="btn btn-success text-white btn-xs" title="Crear PEA"> 
						<i class="fas fa-plus-square"></i>
					  </a>',
				"1" => (count($respea) > 0) ? '<a onclick="versionPea(' . $rspta[$i]["id_programa_ac"] . ',' . $rspta[$i]["id"] . ')" title="Editar PEA" class="btn btn-warning btn-xs text-dark"><i class="fas fa-pencil-alt"></i> </a>' : '',
				"2" => $estado_pea,
				"3" => $rspta[$i]["nombre"],
				"4" => $rspta[$i]["semestre"],
				"5" => $rspta[$i]["area"],
				"6" => $rspta[$i]["creditos"],
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
		$rspta = $pea->mostrar($id);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case 'actualizardescripcion':
		$data = array();
		$data["0"] = "";
		$contenido = $_POST["contenido"];
		$id_pea = $_POST["id_pea"];
		$valor = $_POST["valor"];
		$rspta = $pea->actualizardescripcion($contenido, $id_pea, $valor);
		$resultado = $rspta ? "1" : "2";
		$data["0"] .= $resultado;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'mostrareditartema':
		$id_tema = $_POST["id_tema"];
		$rspta = $pea->mostrareditartema($id_tema);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case 'mostrareditarreferencia':
		$id_pea_referencia = $_POST["id_pea_referencia"];
		$rspta = $pea->mostrareditarreferencia($id_pea_referencia);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case 'listarVersiones':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_programa_ac = $_POST["id_programa_ac"]; // variable que contiene el id del programa
		$id_materia = $_POST["id_materia"]; // variable que contiene el id de la materia
		$buscar_nombre_materia = $pea->mostrar($id_materia); // consulta para buscar el nombre de la materia
		$nombre_materia = $buscar_nombre_materia["nombre"]; // variable que contiene el nombre de la materia
		$data["0"] .= '<div class="alert alert-info">' . $nombre_materia . '</div>';
		$data["0"] .= '
		<table class="table table-hover table-condensed">
			<thead>
			  <tr>
				<th>Fecha de Aprobación</th>
				<th>Versión</th>
				<th>Acciones</th>
			  </tr>
			</thead>
			<tbody>';
		$respea = $pea->pea($id_programa_ac, $id_materia); //id_programa_ac contiene el id del programa y id contene el id de la materia
		for ($j = 0; $j < count($respea); $j++) {
			$id_pea = $respea[$j]["id_pea"]; // variable que contiene el id pea
			$fecha_aprobacion = $respea[$j]["fecha_aprobacion"]; // variable que contiene la fecha de aprobación del PEA
			$version = $respea[$j]["version"]; // variable que contiene la version del PEA
			$estado = $respea[$j]["estado"]; // variable que contiene el estado del pea, para saber si esta activo
			$data["0"] .= '<tr>';
			$data["0"] .= '<td>' . $pea->fechaesp($fecha_aprobacion) . '</td>';
			$data["0"] .= '<td>' . $version . '</td>';
			$data["0"] .= '<td>';
			$data["0"] .= '<div class="btn-group">
			<a onclick=ver_pea(' . $id_pea . ') class="btn btn-success text-white btn-xs" title="Ver Contenido">Ver</a>';
			$data["0"] .= ($estado) ? '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $id_pea . ')" title="Desactivar"><i class="fas fa-lock-open"></i></button>' : ' <button class="btn btn-primary btn-xs" onclick="activar(' . $id_pea . ')" title="Activar"><i class="fas fa-lock"></i></button>';
			$data["0"] .= '
						</div>
			</td>';
			$data["0"] .= '</tr>';
		}
		$data["0"] .= '</<tbody>';
		$data["0"] .= '</<table>';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'crearPea':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_programa_ac = $_POST["id_programa_ac"]; // variable que contiene el id del programa
		$id_materia = $_POST["id_materia"]; // variable que contiene el id del programa
		$buscar_nombre_materia = $pea->mostrar($id_materia); // consulta para buscar el nombre de la materia
		$nombre_materia = $buscar_nombre_materia["nombre"]; // variable que contiene el nombre de la materia
		$data["0"] .= '<div class="alert alert-info">' . $nombre_materia . '</div>';
		$version = 1;
		$respea = $pea->pea($id_programa_ac, $id_materia); //id_programa_ac contiene el id del programa y id contene el id de la materia
		if (count($respea) > 0) {
			for ($j = 0; $j < count($respea); $j++) {
				$fecha_aprobacion = $respea[$j]["fecha_aprobacion"]; // variable que contiene la fecha de aprobación del PEA
				$version = $respea[$j]["version"]; // variable que contiene la version del PEA				
				$data["0"] .= '<span class="bg-primary" style="margin:1%; padding:1%">Existe la versión: ' . $version . "</span><br>";
				$data["1"] = $version + 1;
				$version++;
			}
			$data["0"] .= '<hr>';
		} else {
			$data["1"] = '0' . $version;
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'verPea':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$id_pea = $_POST["id_pea"]; // variable que contiene el id del PEA
		$datosdelpea = $pea->datospea($id_pea);
		$data["0"] .= '<div class="card col-12 mt-4 p-2">';
		$data["0"] .= '<div class="col-12 bg-1 p-2 m-0 text-white text-center"> COMPETENCIA DE LA ASIGNATURA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0 text-white text-center"> 
								<textarea id="competencias" name="competencias" rows="5" class="form-control">' . $datosdelpea["competencias"] . '</textarea>
							</div>
							<div class="col-12 text-center"><a onclick="actualizardescripcion(1,' . $id_pea . ')" class="btn btn-success text-white">Actualizar Competencias</a></div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="card col-12 mt-4 p-2">';
		$data["0"] .= '<div class="col-12 bg-1 p-2 m-0 text-white text-center"> RESULTADO DE APRENDIZAJE </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0 text-white text-center"> 
								<textarea id="resultado_apre" name="resultado_apre" rows="5" class="form-control">' . $datosdelpea["resultado"] . '</textarea>
							</div>
							<div class="col-12 text-center"><a onclick="actualizardescripcion(2,' . $id_pea . ')" class="btn btn-success text-white">Actualizar Resultado</a></div>';
		$data["0"] .= '</div>';
		$data["0"] .= '<div class="card col-12 mt-4 p-2">';
		$data["0"] .= '<div class="col-12 bg-1 p-2 m-0 text-white text-center"> CRITERIOS DE EVALUACIÓN DE LA ASIGNATURA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0 text-white text-center"> 
                    <textarea id="criterio" name="criterio" rows="5" class="form-control">' . $datosdelpea["criterio"] . '</textarea>
                </div>
                <!-- <div class="col-12 text-center"><a onclick="actualizardescripcion(3,' . $id_pea . ')" class="btn btn-success text-white">Actualizar Criterio</a></div> -->';

		$data["0"] .= '</div>';
		$data["0"] .= '<div class="card col-12 mt-4 p-2">';
		$data["0"] .= '<div class="col-12 bg-1 p-2 m-0 text-white text-center"> METODOLOGÍA </div>';
		$data["0"] .= '<div class="col-12 p-2 m-0 text-white text-center"> 
								<textarea id="metodologia" name="metodologia" rows="5" class="form-control">' . $datosdelpea["metodologia"] . '</textarea>
							</div>
							<div class="col-12 text-center"><a onclick="actualizardescripcion(4,' . $id_pea . ')" class="btn btn-success text-white">Actualizar Metodología</a></div>';
		$data["0"] .= '</div>';
		$data["0"] .= '
			<div class="col-12 p-4">
				<button class="btn btn-success text-white float-right" id="btnagregar" onclick="agregartema(' . $id_pea . ')">
					<i class="fa fa-plus-circle"></i> Agregar Tema
				</button>
			</div>';
		$data["0"] .= '<div class="card col-12 mt-4 p-2">';
		$data["0"] .= '<div class="col-12 bg-1 p-2 m-0 text-white text-center"> Contenidos </div>';
		$data["0"] .= '<ul>';
		$rspta = $pea->verPea($id_pea); //Consulta para ver los Temas del PEA
		for ($i = 0; $i < count($rspta); $i++) {
			$data["0"] .= '<li>
											<a onclick="mostrareditartema(' . $rspta[$i]["id_tema"] . ',' . $id_pea . ')" title="Editar Tema" class="btn btn-warning btn-xs text-white"><i class="fas fa-pencil-alt"></i></a> 
											<a onclick="eliminartema(' . $rspta[$i]["id_tema"] . ',' . $id_pea . ')" title="Eliminar Tema" class="btn btn-danger btn-xs text-white"><i class="fas fa-trash-alt"></i></a> '
				. $rspta[$i]["conceptuales"] .
				'</li>';
		}
		$data["0"] .= '</ul>';
		$data["0"] .= '</div>';
		$data["0"] .= '
		<div class="col-12 p-4 text-right">
			<button class="btn btn-success text-white" id="btnagregar" onclick="agregarreferencia(' . $id_pea . ')">
				<i class="fa fa-plus-circle"></i> Agregar referencia
			</button>
		</div>';
		$data["0"] .= '<div class="card col-12 mt-4 p-2">';
		$data["0"] .= '<div class="col-12 bg-1 p-2 m-0 text-white text-center"> REFERENCIAS </div>';
		$data["0"] .= '<ul>';
		$rspta2 = $pea->verPeaReferencia($id_pea); //Consulta para ver los Temas del PEA
		for ($j = 0; $j < count($rspta2); $j++) {
			$data["0"] .= '<li>
											<a onclick="mostrareditarreferencia(' . $rspta2[$j]["id_pea_referencia"] . ',' . $id_pea . ')" title="Editar Referencia" class="btn btn-warning btn-xs text-white"><i class="fas fa-pencil-alt"></i></a> 
											<a onclick="eliminarreferencia(' . $rspta2[$j]["id_pea_referencia"] . ',' . $id_pea . ')" title="Eliminar Referencia" class="btn btn-danger btn-xs text-white"><i class="fas fa-trash-alt"></i></a> '
				. $rspta2[$j]["referencia"] .
				'</li>';
		}
		$data["0"] .= '</ul>';
		$data["0"] .= '</div>';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'verPea2':
		$id_pea = $_GET["id_pea"]; // variable que contiene el id del PEA
		$rspta = $pea->verPea($id_pea); //COnsulta para ver los Temas del PEA
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$data[] = array(
				"0" => '<a onclick="mostrareditartema(' . $rspta[$i]["id_tema"] . ')" title="Editar Tema" class="btn"><i class="fas fa-pencil-alt"></i></a>',
				"1" => $rspta[$i]["sesion"],
				"2" => $rspta[$i]["conceptuales"],
				"3" => $rspta[$i]["procedimentales"],
				"4" => $rspta[$i]["actitudinales"],
				"5" => $rspta[$i]["criterios"],
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
	case "selectPrograma":
		$rspta = $pea->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case 'desactivar':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$data["2"] = "";
		$rspta = $pea->desactivar($id_pea); // consulta para traer el id del pea
		$datos = $pea->datospea($id_pea); // consulta para traer los dates del pea
		$id_programa = $datos["id_programa"]; // variable que contiene el id del programa
		$id_materia = $datos["id_materia"]; // variable que contiene el id de la materia
		if ($rspta == 0) { // si es correcto
			$data["0"] .= "1";
		} else { // en caso de que no sea correcto
			$data["0"] .= "0";
		}
		$data["1"] .= $id_programa; // variable que mada el id del programa
		$data["2"] .= $id_materia; // variable que manda el id de la materia
		$results = array($data);
		echo json_encode($results);
		break;
	case 'activar':
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$data["2"] = "";
		$rspta = $pea->activar($id_pea); // consulta para traer el id del pea
		$datos = $pea->datospea($id_pea); // consulta para traer los dates del pea
		$id_programa = $datos["id_programa"]; // variable que contiene el id del programa
		$id_materia = $datos["id_materia"]; // variable que contiene el id de la materia
		if ($rspta == 0) {
			$data["0"] .= "1";
		} else {
			$data["0"] .= "0";
		}
		$data["1"] .= $id_programa; // variable que mada el id del programa
		$data["2"] .= $id_materia; // variable que manda el id de la materia
		$results = array($data);
		echo json_encode($results);
		break;
	case 'eliminartema':
		$data = array();
		$data["0"] = "";
		$id_tema = $_POST["id_tema"];
		$eliminartema = $pea->eliminartema($id_tema);
		if ($eliminartema == true) {
			$data["0"] = "1"; // correcto
		} else {
			$data["0"] = "0"; // incorrecto
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'eliminarreferencia':
		$data = array();
		$data["0"] = "";
		$id_pea_referencia = $_POST["id_pea_referencia"];
		$eliminareferencia = $pea->eliminarreferencia($id_pea_referencia);
		if ($eliminareferencia == true) {
			$data["0"] = "1"; // correcto
		} else {
			$data["0"] = "0"; // incorrecto
		}
		$results = array($data);
		echo json_encode($results);
		break;
}
