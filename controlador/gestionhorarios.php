<?php
date_default_timezone_set("America/Bogota");

require_once "../public/mail/sendmailClave.php";
require_once "../mail/templateNotDocenteDelReserva.php";

require_once "../modelos/GestionHorarios.php";
$gestionhorarios = new GestionHorarios();

require_once "../modelos/PerColaborador.php";
$percolaborador = new PerColaborador();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$id_programa_ac = isset($_POST["programa_ac"]) ? limpiarCadena($_POST["programa_ac"]) : "";
$jornada = isset($_POST["jornada"]) ? limpiarCadena($_POST["jornada"]) : "";
// $dia=isset($_POST["dia"])? limpiarCadena($_POST["dia"]):"";
// $periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$grupo = isset($_POST["grupo"]) ? limpiarCadena($_POST["grupo"]) : "";
$semestre = isset($_POST["semestre"]) ? limpiarCadena($_POST["semestre"]) : "";
// modal asignar horario
$id_horario_fijo = isset($_POST["id_horario_fijo"]) ? limpiarCadena($_POST["id_horario_fijo"]) : "";
$id_materia = isset($_POST["id_materia"]) ? limpiarCadena($_POST["id_materia"]) : "";
$jornadamateria = isset($_POST["jornadamateria"]) ? limpiarCadena($_POST["jornadamateria"]) : "";
$grupomateria = isset($_POST["grupomateria"]) ? limpiarCadena($_POST["grupomateria"]) : "";
$dia = isset($_POST["dia"]) ? limpiarCadena($_POST["dia"]) : "";
$corte = isset($_POST["corte"]) ? limpiarCadena($_POST["corte"]) : "";
$hora = isset($_POST["hora"]) ? limpiarCadena($_POST["hora"]) : "";
$hasta = isset($_POST["hasta"]) ? limpiarCadena($_POST["hasta"]) : "";
$diferencia = isset($_POST["diferencia"]) ? limpiarCadena($_POST["diferencia"]) : "";
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');
$rsptaperiodo = $gestionhorarios->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
switch ($_GET["op"]) {
	case 'buscar':
		$data = array();
		$data["0"] = "";
		// este codigo se ejecuta cuando se elimina un matareia del horario, para que reargue
		@$valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
		if ($valor == 1) {
			$id_programa_ac = $_POST["id_programa"];
			$semestre = $_POST["semestre"];
			$jornada = $_POST["jornada"];
			$grupo = $_POST["grupo"];
		}
		/* ****************************************** */
		$datos_programa = $gestionhorarios->listarMaterias($id_programa_ac, $semestre);
		$data["0"] .= '
			<div class="col-12 py-2">
				<div class="row align-items-center">
					<div class="pl-2">
							<span class="rounded bg-light-green p-2 text-success ">
							<i class="fa-regular fa-calendar"></i>
							</span> 
					</div>
					<div class="col-10">
					<div class="col-8 fs-14 line-height-18"> 
							<span class="">Asignaturas</span> <br>
							<span class="text-semibold fs-16">Semestre ' . $semestre . '</span> 
					</div> 
					</div>
				</div>
			</div>
		';
		$data["0"] .= '<div class="col-12">';
		for ($i = 0; $i < count($datos_programa); $i++) {
			$id_materia = $datos_programa[$i]["id"];
			$nombre_materia = $datos_programa[$i]["nombre"];
			$modelo = $datos_programa[$i]["modelo"];
			$data["0"] .= '
				<div class="col-12 borde-bottom-2 pt-2"></div>
                     <div class="col-12 p-2">
                        <div class="row">
							<div class="col-2 p-0 m-0 text-center">';
			if ($modelo == 1) { // si es presencial
				$data["0"] .= '<span class="badge badge-primary ">Sede</span>';
			} else { // es modelo pat
				$data["0"] .= '<span class="badge bg-maroon ">PAT</span>';
			}
			$data["0"] .= '
								<figure class="pt-1">
								<img src="../files/null.jpg" alt="" class="rounded-circle" width="36px" height="36px">
								</figure>
							</div>
							<div class="col-10">
								<div class="row">';
			$data["0"] .= '
									<div class="col-8 titulo-2 fs-12 line-height-16 text-semibold">' . $nombre_materia . '</div>';
			$traerhorariodocentegrupos = $gestionhorarios->TraerHorarioDocenteGrupos($id_materia, $jornada, $grupo, $periodo_actual); // traer el horario de la tabla horario_fijo
			if ($traerhorariodocentegrupos == true) { // si esta ya creado en la tabla docente grupos
				$data["0"] .= '<div class="col-4"><a class="badge badge-info text-white pointer" onclick=crear(' . $id_materia . ',"' . $jornada . '",' . $semestre . ',' . $grupo . ') title="Asignar Horario"><i class="fa fa-plus fa-1x"></i> Nuevo día</a></div>';
				for ($k = 0; $k < count($traerhorariodocentegrupos); $k++) { // trae los dias de clase de horario fijo
					$id_docente_grupo = $traerhorariodocentegrupos["$k"]["id_docente_grupo"];
					$hora_formato_doc = $gestionhorarios->traeridhora($traerhorariodocentegrupos["$k"]["hora"]);
					$hasta_formato_doc = $gestionhorarios->traeridhora($traerhorariodocentegrupos["$k"]["hasta"]);
					$data["0"] .= '
											<div class="col-12 fs-12">
												<i class="fa-solid fa-caret-right"></i> 
												' . $traerhorariodocentegrupos["$k"]["dia"] .
						' ' . $hora_formato_doc["formato"] .
						' a ' . $hasta_formato_doc["formato"] .
						' - c:' . $traerhorariodocentegrupos["$k"]["corte"] .
						'<a class="btn btn-link text-danger" onclick=eliminarhorario(' . $id_docente_grupo . ') title="Eliminar Horario">x</a>
											</div>';
					if ($traerhorariodocentegrupos["$k"]["salon"] == true) {
						$data["0"] .= '
												<span class="btn-group">
													<button class="btn btn-link text-success btn-xs" onclick=listarSalones("' . $id_docente_grupo . '","' . $traerhorariodocentegrupos["$k"]["dia"] . '","' . $traerhorariodocentegrupos["$k"]["hora"] . '","' . $traerhorariodocentegrupos["$k"]["hasta"] . '","' . $traerhorariodocentegrupos["$k"]["id_programa"] . '","' . $traerhorariodocentegrupos["$k"]["grupo"] . '") class="btn btn-dark btn-xs text-" title="Asignar Salón">
														<i class="fa fa-school"></i>  ' . $traerhorariodocentegrupos["$k"]["salon"] . ' 
													</button>
													<button class="btn btn-link text-danger btn-xs" onclick=quitarSalon("' . $id_docente_grupo . '") title="Quitar salón">x</button>
												</span>';
					} else {
						$data["0"] .= '<button class="btn btn-link text-primary btn-xs" onclick=listarSalones("' . $id_docente_grupo . '","' . $traerhorariodocentegrupos["$k"]["dia"] . '","' . $traerhorariodocentegrupos["$k"]["hora"] . '","' . $traerhorariodocentegrupos["$k"]["hasta"] . '","' . $traerhorariodocentegrupos["$k"]["id_programa"] . '","' . $traerhorariodocentegrupos["$k"]["grupo"] . '")  title="Asignar Salón">
													<i class="fa-solid fa-plus"></i> Salón
												</button>';
					}
					/*  codigo para asignar docente */
					$datosdocente = $gestionhorarios->datosDocente($traerhorariodocentegrupos["$k"]["id_docente"]); // consulta para traer los datos del docente
					if ($traerhorariodocentegrupos["$k"]["id_docente"] == true) { // si hay docente asignado
						$data["0"] .= '
												<span class="btn-group">
													<button class="btn btn-link text-success btn-xs" onclick=listarDocentes("' . $id_docente_grupo . '","' . $traerhorariodocentegrupos["$k"]["dia"] . '","' . $traerhorariodocentegrupos["$k"]["hora"] . '","' . $traerhorariodocentegrupos["$k"]["hasta"] . '","' . $traerhorariodocentegrupos["$k"]["id_programa"] . '","' . $traerhorariodocentegrupos["$k"]["grupo"] . '") class="btn btn-dark btn-xs text-" title="' . $datosdocente["usuario_nombre"] . ' ' .  $datosdocente["usuario_apellido"] . ' ">
														<i class="fas fa-user"></i> ' . $datosdocente["usuario_nombre"] . '
													</button>
													<button class="btn btn-link text-danger btn-xs" onclick=quitarDocente("' . $id_docente_grupo . '") >x</button>
												</span>';
					} else {
						$data["0"] .= '<button class="btn btn-link text-primary btn-xs" onclick=listarDocentes("' . $id_docente_grupo . '","' . $traerhorariodocentegrupos["$k"]["dia"] . '","' . $traerhorariodocentegrupos["$k"]["hora"] . '","' . $traerhorariodocentegrupos["$k"]["hasta"] . '","' . $traerhorariodocentegrupos["$k"]["id_programa"] . '","' . $traerhorariodocentegrupos["$k"]["grupo"] . '") class="btn btn-dark btn-xs text-" title="Asignar Docente">
													<i class="fa-solid fa-plus"></i> Docente  
												</button>';
					}
					/* ******************************** */
					// $data["0"] .='<div class="css-1a5jqy3 m-2" style="width: 96%; border-top: 2px dotted rgb(228, 228, 228);margin:auto"></div>';
				}
			}
			// consulta para mirar las clases de horario fijo 
			$traerhorario = $gestionhorarios->TraerHorario($id_materia, $jornada, $grupo); // traer el horario de la tabla horario_fijo
			if ($traerhorario == true) { // si tiene horario fijo en la tabla horario fijo
				for ($j = 0; $j < count($traerhorario); $j++) { // trae los dias de clase de horario fijo
					$hora_formato = $gestionhorarios->traeridhora($traerhorario["$j"]["hora"]);
					$hasta_formato = $gestionhorarios->traeridhora($traerhorario["$j"]["hasta"]);
					$mirardocentegrupo = $gestionhorarios->mirarHorarioDocenteGrupo($id_materia, $jornada, $grupo, $traerhorario["$j"]["dia"], $traerhorario["$j"]["hora"], $traerhorario["$j"]["hasta"], $periodo_actual); // mirar si ya esta la materia agregada en docente grupos
					if ($mirardocentegrupo == true) { // si el grupo ya esta creado endocente grupos, que no imprima el boton de agregar horario
					} else { // si no esta en docente grupos que imprima en boton agregar horario
						$id_horario_fijo = $traerhorario["$j"]["id_horario_fijo"];
						$data["0"] .= '<div class="col-12 fs-12"><i class="fa-solid fa-caret-right"></i> ' . $traerhorario["$j"]["dia"] . ' ' . $hora_formato["formato"] . ' a ' . $hasta_formato["formato"] . ' - ' . $traerhorario["$j"]["salon"] . ' - c:' . $traerhorario["$j"]["corte"] . '</div>';
						$data["0"] .= '<button onclick=agregarAlHorario("' . $id_horario_fijo . '") class="btn btn-link text-warning btn-xs" title="Agregar al horario">  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Publicar</button>';
					}
				}
			} else { // si no tiene horario fijo creado en la tabla horario fijo
				$data["0"] .= '<button class="btn btn-success btn-xs" onclick=crear(' . $id_materia . ',"' . $jornada . '",' . $semestre . ',' . $grupo . ') title="Asignar Horario"><i class="fa fa-plus fa-1x"></i> Crear</button>';
			}
			$data["0"] .= '
								</div>
							</div>
						</div>
					</div>
				</div>
			';
			/* ************************************* */
			// if($traerhorario==true){
			// 	$jornada=$traerhorario["jornada"];
			// 	$id_horario_fijo=$traerhorario["id_horario_fijo"];
			// 	$traerjornadareal=$gestionhorarios->selectJornadaReal($jornada);
			// 	$jornadareal=$traerjornadareal["codigo"];
			// 	$hora_formato=$gestionhorarios->traeridhora($traerhorario["hora"]);
			// 	$hasta_formato=$gestionhorarios->traeridhora($traerhorario["hasta"]);
			// 	$data["0"] .='<b class="text-primary">' .$traerhorario["dia"]. '</b> '.$hora_formato["formato"] . ' a ' . $hasta_formato["formato"] . ' - ' . $traerhorario["salon"]. ' - c:' . $traerhorario["corte"];
			// 	$data["0"] .='<br></b><button class="btn btn-danger btn-xs" onclick=eliminarhorario('.$id_horario_fijo.') title="Eliminar Horario"><i class="fas fa-trash-alt"></i></button>';
			// 	$data["0"] .='<button class="btn btn-warning btn-xs" onclick=editar('.$id_horario_fijo.') title="Editar Horario"><i class="fas fa-pen"></i></button>';
			// 	$data["0"] .='<button class="btn btn-success btn-xs" onclick=listarSalones("'.$id_horario_fijo.'","'.$traerhorario["dia"].'","'.$traerhorario["hora"].'","'.$traerhorario["hasta"].'","'.$id_programa_ac.'","'.$grupo.'") class="btn btn-dark btn-xs text-" title="Asignar Salón">
			// 		<i class="fa fa-school"></i> Salón '.$traerhorario["salon"].' 
			// 	</button>';
			// }else{
			// 	$data["0"] .='
			// 	<button class="btn btn-info btn-xs" onclick=crear('.$id_materia.',"'.$jornada.'",'.$semestre.','.$grupo.') title="Asignar Horario"><i class="fa fa-plus fa-1x"></i></button>';
			// }
		}
		$data["0"] .= "</div>";
		$results = array($data);
		echo json_encode($results);
		break;
	case 'iniciarcalendario':
		$id_programa = $_GET["id_programa"];
		$jornada = $_GET["jornada"];
		$semestre = $_GET["semestre"];
		$grupo = $_GET["grupo"];
		$impresion = "";

		$startDate = new DateTime($_GET["start"]);
		$endDate   = new DateTime($_GET["end"]);

		$fechaInicio = $startDate->format("Y-m-d");
		$fechaFin   = $endDate->format("Y-m-d");
		
		$traerhorario = $gestionhorarios->TraerHorariocalendario($id_programa, $jornada, $semestre, $grupo, $periodo_actual);
		
		$getReserve = $gestionhorarios->getReservasCalendario($id_programa, $jornada, $semestre, $grupo, $periodo_actual, $fechaInicio, $fechaFin);

		$impresion .= '[';
		for ($i = 0; $i < count($traerhorario); $i++) {
			$id_materia = $traerhorario[$i]["id_materia"];
			$diasemana = $traerhorario[$i]["dia"];
			$horainicio = $traerhorario[$i]["hora"];
			$horafinal = $traerhorario[$i]["hasta"];
			$salon = $traerhorario[$i]["salon"];
			$corte = $traerhorario[$i]["corte"];
			$id_usuario_doc = $traerhorario[$i]["id_docente"];
			$datosmateria = $gestionhorarios->BuscarDatosAsignatura($id_materia);
			$nombre_materia = $datosmateria["nombre"];

			if ($id_usuario_doc == null) {
				$nombre_docente = "Sin Asignar";
			} else {
				$datosdocente = $gestionhorarios->datosDocente($id_usuario_doc);
				$nombre_docente = $datosdocente["usuario_nombre"];
			}

			//$nombre_docente=$id_docente;
			switch ($diasemana) {
				case 'Lunes':
					$dia = 1;
					break;
				case 'Martes':
					$dia = 2;
					break;
				case 'Miercoles':
					$dia = 3;
					break;
				case 'Jueves':
					$dia = 4;
					break;
				case 'Viernes':
					$dia = 5;
					break;
				case 'Sabado':
					$dia = 6;
					break;
				case 'Domingo':
					$dia = 0;
					break;
			}

			if ($corte == "1") {
				$color = "#fff";
			} else {
				$color = "#252e53";
			}
			$impresion .= '{"title":"' . $nombre_materia . ' - Salón ' . $salon . ' - doc: ' . $nombre_docente . ' ","daysOfWeek":"' . $dia . '","startTime":"' . $horainicio . '","endTime":"' . $horafinal . '","color":"' . $color . '",  "clickable": false}';
			
			if (count($getReserve) == 0) {
				if ($i + 1 < count($traerhorario)) {
					$impresion .= ',';
				}
			} else {
				$impresion .= ',';
			}
		}

		$modo = $percolaborador->listarTema();
		$modeDark = $modo["modo_ui"];

		foreach ($getReserve as $key => $reserve) {
			$id = $reserve['id'];
			$title = $reserve['detalle_reserva'];
			$salon  = $reserve['salon'];
			$horainicio = $reserve['horario'];
			$horafinal = $reserve['hora_f'];
			$nombre_docente = $reserve['usuario_nombre'] .' '. $reserve['usuario_nombre_2'] .' '. $reserve['usuario_apellido'] .' '. $reserve['usuario_apellido_2'];

			$dia = date("w", strtotime($reserve['fecha_reserva']));

			if ($modeDark == 1) {
				$color = "#F8EEED";
			} else {
				$color = "#FEE685";
			}
			
			$impresion .= '{"id": "'.$id.'", "title":"' . $nombre_materia . ' - Salón ' . $salon . ' - doc: ' . $nombre_docente . ' ","daysOfWeek":"' . $dia . '","startTime":"' . $horainicio . '","endTime":"' . $horafinal . '","color":"' . $color . '", "clickable": true, "data_id": "'.$id.'"}';
			
			if ($key + 1 < count($getReserve)) {
				$impresion .= ',';
			}
		}

		//$impresion .= '{"title":"Reserva secretaria - Salón c- 202 - doc: Oscar Salazar","daysOfWeek":"1","startTime":"14:00","endTime":"17:00","color":"#E8B74A"}';

		$impresion .= ']';
		echo $impresion;
		break;
	case 'agregarAlHorario':
		$data = array();
		$data["0"] = "";
		$id_horario_fijo = $_POST["id_horario_fijo"];
		$traerhorario = $gestionhorarios->TraerHorarioFijo($id_horario_fijo); // traer el horario de la tabla horario_fijo
		$id_programa = $traerhorario["id_programa"];
		$id_materia = $traerhorario["id_materia"];
		$jornada = $traerhorario["jornada"];
		$semestre = $traerhorario["semestre"];
		$grupo = $traerhorario["grupo"];
		$dia = $traerhorario["dia"];
		$hora = $traerhorario["hora"];
		$hasta = $traerhorario["hasta"];
		$diferencia = $traerhorario["diferencia"];
		$salon = $traerhorario["salon"];
		$corte = $traerhorario["corte"];
		$ciclo = $traerhorario["ciclo"];
		/* codigo pra sumerle un minuto a la hora inicial */
		$horaInicial = $hora;
		$minutoAnadir = 1;
		$segundos_horaInicial = strtotime($horaInicial);
		$segundos_minutoAnadir = $minutoAnadir * 60;
		$nuevaHoraInicial = date("H:i:s", $segundos_horaInicial + $segundos_minutoAnadir);
		/* ************************************* */
		/* codigo pra sumerle un minuto a la hora final (el hasta) */
		$horaHasta = $hasta;
		$minutoRestar = 1;
		$segundos_horaHasta = strtotime($horaHasta);
		$segundos_minutoRestar = $minutoRestar * 60;
		$nuevaHoraHasta = date("H:i:s", $segundos_horaHasta - $segundos_minutoRestar);
		/* ************************************* */
		if ($salon == null) { // si la materia que se va a gregar no trae salon definido en horario fijo
			$mirarcruce = $gestionhorarios->crucemateriadocentegrupos($id_programa, $jornada, $semestre, $grupo, $dia, $nuevaHoraInicial, $nuevaHoraHasta, $corte, $periodo_actual);
			if ($mirarcruce == true) { // si encuentra un cruce de materia sin salón
				$data["0"] = "2"; // cruce de horario
			} else { // no encuentra cruce de horario
				$agregarhorario = $gestionhorarios->agregarHorario($id_programa, $id_materia, $jornada, $semestre, $grupo, $dia, $hora, $hasta, $diferencia, $salon, $corte, $ciclo, $periodo_actual);
				if ($agregarhorario == true) {
					$data["0"] = "1"; // correcto
				} else {
					$data["0"] = "0"; // incorrecto
				}
			}
		} else { // si la materia llega con salon desde horario fijo
			$mirarcruce = $gestionhorarios->crucemateriadocentegrupossalon($dia, $nuevaHoraInicial, $nuevaHoraHasta, $salon, $periodo_actual);
			if ($mirarcruce == true) { // si encuentra un cruce de materia con salon
				$data["0"] = "3"; // cruce de salon
			} else { // no encuentra cruce de salon
				$agregarhorario = $gestionhorarios->agregarHorario($id_programa, $id_materia, $jornada, $semestre, $grupo, $dia, $hora, $hasta, $diferencia, $salon, $corte, $ciclo, $periodo_actual);
				if ($agregarhorario == true) {
					$data["0"] = "1"; // correcto
				} else {
					$data["0"] = "0"; // incorrecto
				}
			}
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'mostrareditar':
		$id_horario_fijo = $_POST["id_horario_fijo"];
		$rspta = $gestionhorarios->mostrarDatosEditar($id_horario_fijo);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case "selectPrograma":
		$rspta = $gestionhorarios->selectPrograma();
		echo "<option value=''>-- Seleccionar --</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectJornada":
		$rspta = $gestionhorarios->selectJornada();
		echo "<option value=''>-- Seleccionar --</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . " - " . $rspta[$i]["codigo"] . " </option>";
		}
		break;
	case "selectDia":
		$rspta = $gestionhorarios->selectDia();
		echo "<option value=''>-- Seleccionar --</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "prerequisito":
		$rspta = $gestionhorarios->prerequisito($nombre);
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectHora":
		$rspta = $gestionhorarios->listarHorasDia();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["horas"] . "'>" . $rspta[$i]["formato"] . "</option>";
		}
		break;
	case "selectHasta":
		$hora = $_POST["hora"];
		$traeridhora = $gestionhorarios->traeridhora($hora);
		$idhorainicio = $traeridhora["id_horas"];
		$rspta = $gestionhorarios->listarHorasDia();
		echo "<option value=''>Seleccionar</option>";
		for ($i = $idhorainicio; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["horas"] . "'>" . $rspta[$i]["formato"] . "</option>";
		}
		break;
	case "calcularHoras":
		$horainicial = $_POST["horainicial"];
		$hasta = $_POST["hasta"];
		$diferencia = $gestionhorarios->calcularHoras($horainicial, $hasta);
		echo $diferencia;
		break;
	case 'guardaryeditar':
		$data = array();
		$data["0"] = "";
		$buscardatosasignatura = $gestionhorarios->BuscarDatosAsignatura($id_materia); // consulta para traer el id del programa asociado a la materia
		$id_programa_ac = $buscardatosasignatura["id_programa_ac"];
		$semestremateria = $buscardatosasignatura["semestre"];
		$buscardatosprograma = $gestionhorarios->datosPrograma($id_programa_ac);
		$ciclo = $buscardatosprograma["ciclo"];
		if (empty($id_horario_fijo)) {
			// vamos a mirar que la nueva clase no se cruce
			/* codigo pra sumerle un minuto a la hora inicial */
			$horaInicial = $hora;
			$minutoAnadir = 1;
			$segundos_horaInicial = strtotime($horaInicial);
			$segundos_minutoAnadir = $minutoAnadir * 60;
			$nuevaHoraInicial = date("H:i:s", $segundos_horaInicial + $segundos_minutoAnadir);
			/* ************************************* */
			/* codigo pra sumerle un minuto a la hora final (el hasta) */
			$horaHasta = $hasta;
			$minutoRestar = 1;
			$segundos_horaHasta = strtotime($horaHasta);
			$segundos_minutoRestar = $minutoRestar * 60;
			$nuevaHoraHasta = date("H:i:s", $segundos_horaHasta - $segundos_minutoRestar);
			/* ************************************* */
			$mirarcruce = $gestionhorarios->crucemateria($id_programa_ac, $jornadamateria, $semestremateria, $grupomateria, $dia, $nuevaHoraInicial, $nuevaHoraHasta, $corte);
			if ($mirarcruce == true) {
				$data["0"] = '2'; // cruce de materia
			} else { //todo correcto
				// consulta para insertar la materia si cumple con todo
				$insertarhorario = $gestionhorarios->insertarhorario($id_programa_ac, $id_materia, $jornadamateria, $semestremateria, $grupomateria, $dia, $hora, $hasta, $diferencia, $corte, $ciclo);
				if ($insertarhorario == true) {
					$data["0"] = "1"; // resgitro correcto
				} else {
					$data["0"] = "0"; // error
				}
				// ********************************************************
			}
		} else {
			$editarhorario = $gestionhorarios->editarhorario($id_horario_fijo, $dia, $hora, $hasta, $diferencia);
			if ($editarhorario == true) {
				$data["0"] = "1"; // resgitro correcto
			} else {
				$data["0"] = "0"; // resgitro incorrectoa
			}
		}
		$results = array($data);
		echo json_encode($results);
		break;

	case 'eliminarReserva':
		$data = array();
		$data["0"] = "";
		$id_reserva = $_POST["id_reserva"];

		$reserva = $gestionhorarios->getReserva($id_reserva);

		$nombre_docente= $reserva["usuario_nombre"].' '.$reserva["usuario_nombre_2"].' '.$reserva["usuario_apellido"].' '.$reserva["usuario_apellido_2"];
		$espacio= $reserva["salon"];
		$fecha_hora= $reserva["fecha_reserva"] . " de ". $reserva["horario"] . " a ". $reserva["hora_f"];

		$destino = $reserva["usuario_nombre"] . ", sistemasdeinformacion@ciaf.edu.co";
		$asunto = "Reserva cancelada";
		$template = template_a_docente_eliminacion_reserva($nombre_docente, $espacio, $fecha_hora);

		if (enviar_correo($destino, $asunto, $template)) {
			$eliminarreserva = $gestionhorarios->eliminarReserva($id_reserva);

			if ($eliminarreserva == true) {
				$data["0"] = "1";
			} else {
				$data["0"] = "0";
			}
		} else {
			$data = array(
				"0" => "0",
				'exito' => '0',
				'info' => 'Error correo fallo'
			);
		}

		$results = array($data);
		echo json_encode($results);
		break;

	case 'eliminarhorario':
		$data = array();
		$data["0"] = "";
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$eliminarhorario = $gestionhorarios->eliminarhorario($id_docente_grupo);
		if ($eliminarhorario == true) {
			$data["0"] = "1"; // correcto
		} else {
			$data["0"] = "0"; // incorrecto
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'listarSalones':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$dia = $_POST["dia"];
		$hora = $_POST["hora"];
		$hasta = $_POST["hasta"];
		$id_programa = $_POST["id_programa"];
		$grupo = $_POST["grupo"];
		$datogrupo = $gestionhorarios->datoGrupo($id_docente_grupo);
		$salonactual = $datogrupo["salon"];
		$fusion_salon = $datogrupo["fusion_salon"];
		$rspta = $gestionhorarios->listarSalones();
		$reg = $rspta;
		$data = array();
		$data["0"] = "";
		/* codigo pra sumerle un minuto a la hora inicial */
		$horaInicial = $hora;
		$minutoAnadir = 1;
		$segundos_horaInicial = strtotime($horaInicial);
		$segundos_minutoAnadir = $minutoAnadir * 60;
		$nuevaHoraInicial = date("H:i:s", $segundos_horaInicial + $segundos_minutoAnadir);
		/* ************************************* */
		/* codigo pra sumerle un minuto a la hora final (el hasta) */
		$horaHasta = $hasta;
		$minutoRestar = 1;
		$segundos_horaHasta = strtotime($horaHasta);
		$segundos_minutoRestar = $minutoRestar * 60;
		$nuevaHoraHasta = date("H:i:s", $segundos_horaHasta - $segundos_minutoRestar);
		/* ************************************* */
		$data["0"] .= '
			<div class="row col-12 m-0 p-0">
			<div class="col-12 tono-3 px-3 py-2">
				<div class="row">
					<div class="col-6">
						<div class="row align-items-center">
							<div class="pl-2">
								<span class="rounded bg-light-green p-3 text-success ">
									<i class="fa-regular fa-calendar" aria-hidden="true"></i>
								</span> 
							</div>
							<div class="col-10">
								<div class="col-8 fs-14 line-height-18"> 
										<span class="">Salón para</span> <br>
										<span class="titulo-2 text-semibold fs-16">' . $dia . '</span> 
								</div> 
							</div>
						</div>
					</div>
					<div class="col-6 py-3">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
				</div>
			</div>
			<div class="col-12 px-4">
              	<table class="table table-hover" style="width:100%">
					<tbody>
					<tr class="titulo-2 fs-14">
					  <th>Salón</th>
					  <th>Capacidad</th>
					  <th style="width: 40px">Sede</th>
					  <th>Acción</th>
					  <th>Información</th>
					</tr>';
		$data["0"] .=
			'<tr>';
		$data["0"] .= '<td> PAT </td>';
		$data["0"] .= '<td> --- </td>';
		$data["0"] .= '<td> Remoto </td>';
		$data["0"] .= '<td> 
											<a onclick=asignarSalon("' . $id_docente_grupo . '","PAT") class="badge badge-success pointer text-white" title="Asignar salón"> Asignar</a>
									</td>';
		$data["0"] .= '<td></td>';
		for ($i = 0; $i < count($reg); $i++) {
			$salon = $reg[$i]["codigo"];
			$rspta2 = $gestionhorarios->listarSalonesDisponibles($salon, $dia, $nuevaHoraInicial, $nuevaHoraHasta, $periodo_actual);
			$reg2 = $rspta2;
			if (count($reg2) == 0) {
				$data["0"] .= '<tr>';
				$data["0"] .= '<td>' . $salon . '</td>';
				$data["0"] .= '<td>' . $reg[$i]["capacidad"] . '</td>';
				$data["0"] .= '<td>' . $reg[$i]["sede"] . '</td>';
				$data["0"] .= '<td> <a onclick=asignarSalon("' . $id_docente_grupo . '","' . $salon . '") class="badge badge-success pointer text-white" title="Asignar salón"> Asignar</a></td>';
				$data["0"] .= '<td></td>';
				$data["0"] .= '</tr>';
			} else {
				$rspta3 = $gestionhorarios->listarSalonesOcupado($salon, $dia, $nuevaHoraInicial, $nuevaHoraHasta, $periodo_actual); // consulta para traer los salones ocupados
				$id_programa_ocupado = $rspta3["id_programa"];
				$id_materia_ocupado = $rspta3["id_materia"];
				$hora_ocupado = $rspta3["hora"];
				$hasta_ocupado = $rspta3["hasta"];
				$dato_programa = $gestionhorarios->datosPrograma($id_programa_ocupado);
				$dato_materia = $gestionhorarios->BuscarDatosAsignatura($id_materia_ocupado);
				$hora_formato_ocupado = $gestionhorarios->traeridhora($hora_ocupado);
				$hasta_formato_ocupado = $gestionhorarios->traeridhora($hasta_ocupado);
				$data["0"] .= '<tr>';
				$data["0"] .= '<td>' . $salon . '</td>';
				$data["0"] .= '<td>' . $reg[$i]["capacidad"] . '</td>';
				$data["0"] .= '<td>' . $reg[$i]["sede"] . '</td>';
				if ($salonactual == $salon) {
					$data["0"] .= '<td> <div class="badge bg-orange text-white p-2">Actual</div> </td>';
				} else {
					$data["0"] .= '<td> <a onclick=asignarSalonFusion("' . $id_docente_grupo . '","' . $salon . '") class="badge badge-info btn-xs text-white pointer" title="Fusionar salón"> Fusionar</a></td>';
				}
				if ($fusion_salon == 0) { // tiene fusión el grupo
					$data["0"] .= '
							<td><span class="text-danger">Fusionado con:</span>
								<span class="text-sm">' . $dato_programa["nombre"] . ' - ' . $dato_materia["nombre"] . ' ' . $hora_formato_ocupado["formato"] . ' ' . $hasta_formato_ocupado["formato"] . ' </span>
							</td>';
				} else {
					$data["0"] .= '<td><span class="text-sm">' . $dato_programa["nombre"] . ' - ' . $dato_materia["nombre"] . ' ' . $hora_formato_ocupado["formato"] . ' ' . $hasta_formato_ocupado["formato"] . ' </span></td>';
				}
				$data["0"] .= '</tr>';
			}
		}
		$data["0"] .= '
						  </tbody>
				</table>
			</div>
		</div>
		<!-- /.box-body -->
		</div>';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'asignarSalon':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$salon = $_POST["salon"];
		$rspta = $gestionhorarios->asignarSalon($id_docente_grupo, $salon);
		echo json_encode($rspta);
		break;
	case 'asignarSalonFusion':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$salon = $_POST["salon"];
		$rspta = $gestionhorarios->asignarSalonFusion($id_docente_grupo, $salon);
		echo json_encode($rspta);
		break;
	case 'asignarDocenteFusion':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$id_usuario_doc = $_POST["id_usuario_doc"];
		$rspta = $gestionhorarios->asignarDocenteFusion($id_docente_grupo, $id_usuario_doc);
		echo json_encode($rspta);
		break;
	case 'listarDocentes':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$dia = $_POST["dia"];
		$hora = $_POST["hora"];
		$hasta = $_POST["hasta"];
		$id_programa = $_POST["id_programa"];
		$grupo = $_POST["grupo"];
		$datogrupo = $gestionhorarios->datoGrupo($id_docente_grupo);
		$docenteactual = $datogrupo["id_docente"];
		$fusion_docente = $datogrupo["fusion_docente"];
		$rspta = $gestionhorarios->listarDocentes();
		$reg = $rspta;
		$data = array();
		$data["0"] = "";
		/* codigo pra sumerle un minuto a la hora inicial */
		$horaInicial = $hora;
		$minutoAnadir = 1;
		$segundos_horaInicial = strtotime($horaInicial);
		$segundos_minutoAnadir = $minutoAnadir * 60;
		$nuevaHoraInicial = date("H:i:s", $segundos_horaInicial + $segundos_minutoAnadir);
		/* ************************************* */
		/* codigo pra sumerle un minuto a la hora final (el hasta) */
		$horaHasta = $hasta;
		$minutoRestar = 1;
		$segundos_horaHasta = strtotime($horaHasta);
		$segundos_minutoRestar = $minutoRestar * 60;
		$nuevaHoraHasta = date("H:i:s", $segundos_horaHasta - $segundos_minutoRestar);
		/* ************************************* */
		$data["0"] .= '
			<div class="row col-12 m-0 p-0">
				<div class="col-12 tono-3 px-3 py-2">
					<div class="row">
						<div class="col-6">
							<div class="row align-items-center">
								<div class="pl-2">
									<span class="rounded bg-light-green p-3 text-success ">
										<i class="fa-regular fa-calendar" aria-hidden="true"></i>
									</span> 
								</div>
								<div class="col-10">
									<div class="col-8 fs-14 line-height-18"> 
											<span class="">Docente para</span> <br>
											<span class="titulo-2 text-semibold fs-16">' . $dia . '</span> 
									</div> 
								</div>
							</div>
						</div>
						<div class="col-6 py-3">
							<button type="button" class="close" data-dismiss="modal">×</button>
						</div>
					</div>
				</div>
				<div class="col-12  px-3 px-4">
              	<table class="table table-hover" style="width:100%">
					<tbody>
					<tr class="titulo-2 fs-14">
					  <th>Nombre</th>
					  <th>Vinculación</th>
					  <th style="width: 40px">horas</th>
					  <th>Acción</th>
					  <th>Información</th>
					</tr>';
		for ($i = 0; $i < count($reg); $i++) {
			$id_usuario_doc = $reg[$i]["id_usuario"];
			$nombre_completo = $reg[$i]["usuario_nombre"] . ' ' . $reg[$i]["usuario_apellido"];
			$usuario_tipo_contrato = $reg[$i]["usuario_tipo_contrato"];
			$rspta2 = $gestionhorarios->listarDocentesDisponibles($id_usuario_doc, $dia, $nuevaHoraInicial, $nuevaHoraHasta, $periodo_actual);
			$reg2 = $rspta2;
			$horasdocente = $gestionhorarios->horasDocente($id_usuario_doc, $periodo_actual);
			$totalhorasdocente = $horasdocente["suma_horas"];
			if (count($reg2) == 0) {
				$data["0"] .= '<tr>';
				$data["0"] .= '<td>' . $nombre_completo . '</td>';
				$data["0"] .= '<td>' . $usuario_tipo_contrato . '</td>';
				$data["0"] .= '<td>' . $totalhorasdocente . '</td>';
				$data["0"] .= '<td> <a onclick=asignarDocente("' . $id_docente_grupo . '","' . $id_usuario_doc . '") class="badge badge-success text-white pointer" title="Asignar docente"> Asignar</a></td>';
				$data["0"] .= '<td></td>';
				$data["0"] .= '</tr>';
			} else {
				$rspta3 = $gestionhorarios->listarDocenteOcupado($id_usuario_doc, $dia, $nuevaHoraInicial, $nuevaHoraHasta, $periodo_actual); // consulta para traer los salones ocupados
				$id_programa_ocupado = $rspta3["id_programa"];
				$id_materia_ocupado = $rspta3["id_materia"];
				$hora_ocupado = $rspta3["hora"];
				$hasta_ocupado = $rspta3["hasta"];
				$dato_programa = $gestionhorarios->datosPrograma($id_programa_ocupado);
				$dato_materia = $gestionhorarios->BuscarDatosAsignatura($id_materia_ocupado);
				$hora_formato_ocupado = $gestionhorarios->traeridhora($hora_ocupado);
				$hasta_formato_ocupado = $gestionhorarios->traeridhora($hasta_ocupado);
				$data["0"] .= '<tr>';
				$data["0"] .= '<td>' . $nombre_completo . '</td>';
				$data["0"] .= '<td>' . $usuario_tipo_contrato . '</td>';
				$data["0"] .= '<td>' . $totalhorasdocente . '</td>';
				if ($docenteactual == $id_usuario_doc) {
					$data["0"] .= '<td> <div class="badge bg-orange py-2">Actual</div> </td>';
				} else {
					$data["0"] .= '<td> <a onclick=asignarDocenteFusion("' . $id_docente_grupo . '","' . $id_usuario_doc . '") class="badge badge-info text-white" title="Fusionar docente"> Fusionar </a></td>';
				}
				if ($fusion_docente == 0) { // tiene fusión el grupo
					$data["0"] .= '
							<td><span class="text-danger">Fusionado con:</span>
								<span class="text-sm">' . $dato_programa["nombre"] . ' - ' . $dato_materia["nombre"] . ' ' . $hora_formato_ocupado["formato"] . ' ' . $hasta_formato_ocupado["formato"] . '
							</td>';
				} else {
					$data["0"] .= '<td><span class="text-sm">' . $dato_programa["nombre"] . ' - ' . $dato_materia["nombre"] . ' ' . $hora_formato_ocupado["formato"] . ' ' . $hasta_formato_ocupado["formato"] . ' </span></td>';
				}
				$data["0"] .= '</tr>';
			}
		}
		$data["0"] .= '
						  </tbody>
					</table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'asignarDocente':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$id_usuario_doc = $_POST["id_usuario_doc"];
		$rspta = $gestionhorarios->asignarDocente($id_docente_grupo, $id_usuario_doc);
		echo json_encode($rspta);
		break;
	case 'quitarDocente':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$rspta = $gestionhorarios->quitarDocente($id_docente_grupo);
		echo json_encode($rspta);
		break;
	case 'quitarSalon':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$rspta = $gestionhorarios->quitarSalon($id_docente_grupo);
		echo json_encode($rspta);
		break;

	default:
		$data["message"] = "No encontrado";
		$results = array($data);
		echo json_encode($results);
}
