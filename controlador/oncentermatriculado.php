<?php
session_start();
require_once "../modelos/OncenterMatriculado.php";
date_default_timezone_set("America/Bogota");
require_once "../mail/send_matriculado.php"; //para realizar el envio del correo.
require_once "../mail/template_matriculado.php"; //creamos template para el envio de la clave, usuario y programa
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$oncentermatriculado = new OncenterMatriculado();
$rsptaperiodo = $oncentermatriculado->periodoactual();
$periodo_campana = $rsptaperiodo["periodo_campana"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
$periodo_actual = $_SESSION['periodo_actual'];
//$periodo_siguiente=$_SESSION['periodo_siguiente'];
$usuario_cargo = $_SESSION['usuario_cargo'];
$id_usuario = $_SESSION['id_usuario'];
/* variables agregar sefuimiento */
$id_estudiante_agregar = isset($_POST["id_estudiante_agregar"]) ? limpiarCadena($_POST["id_estudiante_agregar"]) : "";
$motivo_seguimiento = isset($_POST["motivo_seguimiento"]) ? limpiarCadena($_POST["motivo_seguimiento"]) : "";
$mensaje_seguimiento = isset($_POST["mensaje_seguimiento"]) ? limpiarCadena($_POST["mensaje_seguimiento"]) : "";
/* ********************* */
/* variables para programar tarea */
$id_estudiante_tarea = isset($_POST["id_estudiante_tarea"]) ? limpiarCadena($_POST["id_estudiante_tarea"]) : "";
$motivo_tarea = isset($_POST["motivo_tarea"]) ? limpiarCadena($_POST["motivo_tarea"]) : "";
$mensaje_tarea = isset($_POST["mensaje_tarea"]) ? limpiarCadena($_POST["mensaje_tarea"]) : "";
$fecha_programada = isset($_POST["fecha_programada"]) ? limpiarCadena($_POST["fecha_programada"]) : "";
$hora_programada = isset($_POST["hora_programada"]) ? limpiarCadena($_POST["hora_programada"]) : "";
/* ********************* */
/* variables para cambio de documento*/
$id_estudiante_documento = isset($_POST["id_estudiante_documento"]) ? limpiarCadena($_POST["id_estudiante_documento"]) : "";
$modalidad_campana = isset($_POST["modalidad_campana"]) ? limpiarCadena($_POST["modalidad_campana"]) : "";
/* ********************* */
/* variables para mover usuario*/
$id_estudiante_mover = isset($_POST["id_estudiante_mover"]) ? limpiarCadena($_POST["id_estudiante_mover"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";
/* ********************* */
/* variables para editar perfil*/
$id_estudiante = isset($_POST["id_estudiante"]) ? limpiarCadena($_POST["id_estudiante"]) : "";
$fo_programa = isset($_POST["fo_programa"]) ? limpiarCadena($_POST["fo_programa"]) : "";
$jornada_e = isset($_POST["jornada_e"]) ? limpiarCadena($_POST["jornada_e"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$nombre_2 = isset($_POST["nombre_2"]) ? limpiarCadena($_POST["nombre_2"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$apellidos_2 = isset($_POST["apellidos_2"]) ? limpiarCadena($_POST["apellidos_2"]) : "";
$celular = isset($_POST["celular"]) ? limpiarCadena($_POST["celular"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$nivel_escolaridad = isset($_POST["nivel_escolaridad"]) ? limpiarCadena($_POST["nivel_escolaridad"]) : "";
$nombre_colegio = isset($_POST["nombre_colegio"]) ? limpiarCadena($_POST["nombre_colegio"]) : "";
$fecha_graduacion = isset($_POST["fecha_graduacion"]) ? limpiarCadena($_POST["fecha_graduacion"]) : "";
/* ********************* */
/* variables para crear perfil*/
$id_estudiante_credencial = isset($_POST["id_estudiante_credencial"]) ? limpiarCadena($_POST["id_estudiante_credencial"]) : "";
$identificacion_credencial = isset($_POST["identificacion_credencial"]) ? limpiarCadena($_POST["identificacion_credencial"]) : "";
$nombre_credencial = isset($_POST["nombre_credencial"]) ? limpiarCadena($_POST["nombre_credencial"]) : "";
$nombre2_credencial = isset($_POST["nombre2_credencial"]) ? limpiarCadena($_POST["nombre2_credencial"]) : "";
$apellido_credencial = isset($_POST["apellido_credencial"]) ? limpiarCadena($_POST["apellido_credencial"]) : "";
$apellido2_credencial = isset($_POST["apellido2_credencial"]) ? limpiarCadena($_POST["apellido2_credencial"]) : "";
$email_credencial = isset($_POST["email_credencial"]) ? limpiarCadena($_POST["email_credencial"]) : "";
/* ********************* */
switch ($_GET["op"]) {

	case 'moverUsuario':
		$rspta = $oncentermatriculado->moverUsuario($id_estudiante_mover, $estado);
		echo $rspta ? "Usuario Actualizado" : "Usuario no se pudo mover";
		if ($rspta == "Usuario Actualizado") { // se puede insertar un  seguimiento
			$motivo_seguimiento = "Seguimiento";
			$mensaje_seguimiento = "Cambio de estado a: " . $estado;
			$rspta2 = $oncentermatriculado->insertarSeguimiento($id_usuario, $id_estudiante_mover, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora);
		}
		break;
	case 'listar':
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$consulta2 = $oncentermatriculado->listar($periodo_campana); // consulta para traer los preinscritos de la
		
		$rsptaperiodo = $oncentermatriculado->periodoactual();	
		$periodo_campana=$rsptaperiodo["periodo_campana"];
		//resultado de la campaña actual por el periodo actual.
		$porcentajecampañaactual = $oncentermatriculado->CantidadCasosPorCampaña($periodo_campana);
		

		$data["0"] .= '	
			<div class="col-8 py-3 pl-4" id="t-ea">
					
				</div>
				<div class="col-4">
					<div class="row">
						<div class="col-4 mnw-100 text-center " id="t-cp">
							<i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-green text-green rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
							<h4 title="Periodo Actual" class="titulo-2 fs-18 mb-0">'.$periodo_campana.'</h4>
							<p class="small text-secondary">Campaña</p>
						</div>
						<div class="col-4 mnw-100 text-center" id="t-co">
							<i class="fa-solid fa-trophy avatar avatar-50 bg-light-orange text-orange rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
							<h4 title="Casos Periodo Actual" class="titulo-2 fs-18 mb-0">'.count($porcentajecampañaactual ).' </h4>
							<p class="small text-secondary">Caso Periodo Actual</p>
						</div>
					</div>
				</div>
			<div class="col-4 m-0 p-2">
				<div class="row p-0 m-0">
					<div class="card col-12 p-0 m-0" id="t-ea">
						<div class="row p-0 m-0">
							<div class="col-12 py-3 tono-3">
								<div class="row align-items-center">
									<div class="pl-2">
										<span class="rounded bg-light-red p-2 text-danger">
											<i class="fas fa-users " aria-hidden="true"></i>
										</span> 
									</div>
									<div class="col-10">
									<div class="col-8 fs-14 line-height-18"> 
										<span class="">Estado</span> <br>
										<span class="text-semibold fs-16">Seleccionado</span> 
									</div> 
									</div>
								</div>
							</div>
							<div class="col-12">
								<ul class="nav flex-column">
								<li class="nav-item">
								<a id="t-ca" href="#" class="nav-link" onclick=listarDos("' . $periodo_campana . '")>Campaña Actual 
										<span class="float-right badge bg-primary">' . count($consulta2) . '</span>
									</a>
								</li>
									<li class="nav-item" id="t-cn">
										<div style="height:50px; padding-top:10px">
											<div class="row">
												<div class="nav-link col-lg-6">Campañas Anteriores</div>
												<div class="col-lg-6">
													<form action="">
														<select name="periodo_buscar" id="periodo_buscar" class="form-control-sm float-right" data-live-search="true" onChange=listarDos(this.value)>
													</select>
													<form>
												</div>
											</div>
										</div>
									</li>';
		$consulta3 = $oncentermatriculado->listarmedios(); // consulta para traer los estudiantes por medio
		for ($b = 0; $b < count($consulta3); $b++) {
			$medio = $consulta3[$b]["nombre"];
			$consulta4 = $oncentermatriculado->listarmedioscantidad($medio, $periodo_campana); // cantidad de estudiantes por medio		
			$data["0"] .= '
											<li class="nav-item" id="t-paso' . $b . '">
												<a href="#" onclick="listarTres(`' . $medio . '`,`' . $periodo_campana . '`)" class="nav-link" >' . $medio . ' <span class="float-right badge bg-green">' . count($consulta4) . '</span>
												</a>
											</li>';
		}
		$data["0"] .= '
								</ul>
              				</div>
            			</div>
          			</div>
				</div>
			</div>
			<div class="col-5 d-flex align-items-center">

			</div>
			<div class="col-3 d-flex align-items-center p-0 m-0" id="t-esm">
				<div class="col-12 bg-tips p-0 m-0">
					<div class="card-header tono-3">
					<div class="row align-items-center">
						<div class="col">
							<h6 class="titulo-2 fs-18 text-semibold">
							<i class="fa-regular fa-lightbulb text-warning" aria-hidden="true"></i>
								Tips
							</h6>
						</div>
					</div>
					</div>
					<div class="card-body">
					<h2 class="titulo-2 fs-24 text-semibold">Estado Matriculado</h2>
					<p>En esta parte el asesor se encarga de validar los documentos requisitos para ser parte de CIAF</p>
					<p>Para realizar el proceso de ingreso del cliente  a la plataforma, se debe realizar en el siguiente link 
						<a href="https://ciaf.digital/inscripciones/" target="_blank">Proceso de admisiones</a>
					</p>
					</div>
				</div>
			</div>
		';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'listarDos':
		// $medio=$_POST["medio"];
		$periodo = $_POST["periodo"];
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$data["0"] .= '
		<div class="col-12">
			<div class="row">
				<div class="col-6 p-4 tono-3">
					<div class="row align-items-center">
						<div class="pl-1">
							<span class="rounded bg-light-blue p-3 text-primary ">
								<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
							</span> 
						</div>
						<div class="col-10">
						<div class="col-5 fs-14 line-height-18"> 
							<span class="">Resultados estado</span> <br>
							<span class="text-semibold fs-20"></span> 
						</div> 
						</div>
					</div>
				</div>
				<div class="col-6 tono-3 pt-3 pr-4" id="t2-vol">
					<a onClick="volver()" id="volver" class="btn btn-danger float-right text-white"><i class="fas fa-arrow-circle-left"></i> Volver</a>
				</div>
			</div>
		</div>';
		$data["0"] .= '<div class="card col-12" >';
		$data["0"] .= '<table id="tbllistado" class="table table-hover" width="100%" >';
		$data["0"] .= '<thead>';
		$data["0"] .= '<th >Programas</th>';
		$consulta1 = $oncentermatriculado->listarJornada(); // consulta para listar las jornadas en la tabla
		for ($a = 0; $a < count($consulta1); $a++) {
			$data["0"] .= '<th> ' . $consulta1[$a]["nombre"] . '</th>';
		}
		$data["0"] .= '<thead>';
		$data["0"] .= '<tbody >';
		$consulta2 = $oncentermatriculado->listarPrograma(); // consulta para traer los programas activos
		for ($b = 0; $b < count($consulta2); $b++) {
			$nombre_programa = $consulta2[$b]["nombre"];
			$data["0"] .= '<tr>';
			$data["0"] .= '<td>';
			$data["0"] .= $nombre_programa;
			$data["0"] .= '</td>';
			$consulta3 = $oncentermatriculado->listarJornada(); // consulta pra listar el total por jornadas y programa
			for ($c = 0; $c < count($consulta3); $c++) {
				$jornada = $consulta3[$c]["nombre"];
				$consulta4 = $oncentermatriculado->listarprogramajornada($nombre_programa, $jornada, $periodo);
				$data["0"] .= '<td>';
				$data["0"] .= '<a onclick="verEstudiantes(`' . $nombre_programa . '`,`' . $jornada . '`,`' . $periodo . '`,`' . $usuario_cargo . '`)" class="btn">' . count($consulta4) . '</a>';
				$data["0"] .= '</td>';
			}
			$data["0"] .= '</tr>';
		}
		$data["0"] .= '<tr>';
		$data["0"] .= '<td><b>ZTotal Estudiantes</b></td>';
		$consulta4 = $oncentermatriculado->listarJornada(); // consulta pra listar las sumas de las columnas
		for ($d = 0; $d < count($consulta4); $d++) {
			$jornadasuma = $consulta4[$d]["nombre"];
			$consulta5 = $oncentermatriculado->sumaporjornada($jornadasuma, $periodo);
			$data["0"] .= '<td>';
			$data["0"] .= '<a onclick="verEstudiantesSuma(`' . $jornadasuma . '`,`' . $periodo . '`,`' . $usuario_cargo . '`)" class="btn btn-primary btn-sm">' . count($consulta5) . '</a>';
			$data["0"] .= '</td>';
		}
		$data["0"] .= '</tr>';
		$data["0"] .= '</tbody>';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		$consulta6 = $oncentermatriculado->listar($periodo); // consulta para traer los interesados de la 
		$data["0"] .= '<div class="alert float-right"><h3>Total General <a onclick="verEstudiantesTotal(`' . $periodo . '`,`' . $usuario_cargo . '`)" class="btn btn-primary">' . count($consulta6) . '</a></h3></div>';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'listarTres':
		$medio = $_POST["medio"];
		$periodo = $_POST["periodo"];
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$data["0"] .= '
		<div class="col-12">
			<div class="row">
				<div class="col-6 p-4 tono-3">
					<div class="row align-items-center">
						<div class="pl-1">
							<span class="rounded bg-light-blue p-3 text-primary ">
								<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
							</span> 
						</div>
						<div class="col-10">
						<div class="col-5 fs-14 line-height-18"> 
							<span class="">Resultados estado</span> <br>
							<span class="text-semibold fs-20">' . $estado . '</span> 
						</div> 
						</div>
					</div>
				</div>
				<div class="col-6 tono-3 pt-3 pr-4">
					<a onClick="volver()" id="t2-vol" class="btn btn-danger float-right text-white"><i class="fas fa-arrow-circle-left"></i> Volver</a>
				</div>
			</div>
		</div>';
		$data["0"] .= '<div class="card col-12">';
		$data["0"] .= '<table id="tbllistado" class="table table-hover">';
		$data["0"] .= '<thead>';
		$data["0"] .= '<th id="t2-paso0">Programa</th>';
		$consulta1 = $oncentermatriculado->listarJornada(); // consulta pra lñistar las jornadas en la tabla
		$num_paso = 1;
		for ($a = 0; $a < count($consulta1); $a++) {
			$data["0"] .= '<th id="t2-paso' . $num_paso . '">' . $consulta1[$a]["nombre"] . '</th>';
			$num_paso++;
		}
		$data["0"] .= '<thead>';
		$data["0"] .= '<tbody>';
		$consulta2 = $oncentermatriculado->listarPrograma(); // consulta para traer los programas activos
		for ($b = 0; $b < count($consulta2); $b++) {
			$nombre_programa = $consulta2[$b]["nombre"];
			$data["0"] .= '<tr>';
			$data["0"] .= '<td>';
			$data["0"] .= $nombre_programa;
			$data["0"] .= '</td>';
			$consulta3 = $oncentermatriculado->listarJornada(); // consulta pra listar el total por jornadas y programa
			for ($c = 0; $c < count($consulta3); $c++) {
				$jornada = $consulta3[$c]["nombre"];
				$consulta4 = $oncentermatriculado->listarprogramamedio($nombre_programa, $jornada, $medio, $periodo);
				$data["0"] .= '<td>';
				$data["0"] .= '<a onclick="verEstudiantesmedio(`' . $nombre_programa . '`,`' . $jornada . '`,`' . $medio . '`,`' . $periodo . '`,`' . $usuario_cargo . '`)" class="btn">' . count($consulta4) . '</a>';
				$data["0"] .= '</td>';
			}
			$data["0"] .= '</tr>';
		}
		$data["0"] .= '<tr>';
		$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';
		$consulta4 = $oncentermatriculado->listarJornada(); // consulta pra listar las sumas de las columnas
		for ($d = 0; $d < count($consulta4); $d++) {
			$jornadasuma = $consulta4[$d]["nombre"];
			$consulta5 = $oncentermatriculado->sumapormedio($jornadasuma, $medio, $periodo);
			$data["0"] .= '<td>';
			$data["0"] .= '<a onclick="verEstudiantesSumaMedio(`' . $nombre_programa . '`,`' . $jornadasuma . '`,`' . $medio . '`,`' . $periodo . '`,`' . $usuario_cargo . '`)" class="btn btn-primary btn-sm">' . count($consulta5) . '</a>';
			$data["0"] .= '</td>';
		}
		$data["0"] .= '</tr>';
		$data["0"] .= '</tbody>';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		$consulta6 = $oncentermatriculado->listarpormedio($medio, $periodo); // consulta para traer los interesados de la 
		$data["0"] .= '<div class="alert float-right"><h3>Total General <a onclick="verEstudiantesTotalMedio(`' . $medio . '`,`' . $periodo . '`,`' . $usuario_cargo . '`)" class="btn btn-primary">' . count($consulta6) . '</a></h3></div>';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'verEstudiantes':
		$nombre_programa = $_GET["nombre_programa"];
		$jornada = $_GET["jornada"];
		$estado = $_GET["estado"];
		$periodo = $_GET["periodo"];
		$rspta = $oncentermatriculado->listarprogramajornada($nombre_programa, $jornada, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}
			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"3" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"4" => '<div class="fila' . $i . '">' . $reg[$i]["fo_programa"] . '</div>',
				"5" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '</div>',
				"6" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing_matriculado"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"7" => '<div class="fila' . $i . '">' . $reg[$i]["contacto"] . '</div>',
				"8" => '<div class="fila' . $i . '">' . $reg[$i]["medio"] . '</div>'
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
	case 'verEstudiantesMedio':
		$nombre_programa = $_GET["nombre_programa"];
		$jornada = $_GET["jornada"];
		$medio = $_GET["medio"];
		$estado = $_GET["estado"];
		$periodo = $_GET["periodo"];
		$rspta = $oncentermatriculado->listarprogramamedio($nombre_programa, $jornada, $medio, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}
			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"3" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"4" => '<div class="fila' . $i . '">' . $reg[$i]["fo_programa"] . '</div>',
				"5" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '</div>',
				"6" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing_matriculado"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ' ,' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"7" => '<div class="fila' . $i . '">' . $reg[$i]["contacto"] . '</div>',
				"8" => '<div class="fila' . $i . '">' . $reg[$i]["medio"] . '</div>'
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
	case 'verEstudiantesSuma':
		$jornada = $_GET["jornada"];
		$estado = $_GET["estado"];
		$periodo = $_GET["periodo"];
		$rspta = $oncentermatriculado->sumaporjornada($jornada, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}
			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"3" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"4" => '<div class="fila' . $i . '">' . $reg[$i]["fo_programa"] . '</div>',
				"5" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '</div>',
				"6" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing_matriculado"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"7" => '<div class="fila' . $i . '">' . $reg[$i]["contacto"] . '</div>',
				"8" => '<div class="fila' . $i . '">' . $reg[$i]["medio"] . '</div>'
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
	case 'verEstudiantesSumaMedio':
		$jornada = $_GET["jornada"];
		$medio = $_GET["medio"];
		$periodo = $_GET["periodo"];
		$rspta = $oncentermatriculado->sumapormedio($jornada, $medio, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}
			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"3" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"4" => '<div class="fila' . $i . '">' . $reg[$i]["fo_programa"] . '</div>',
				"5" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '</div>',
				"6" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing_matriculado"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"7" => '<div class="fila' . $i . '">' . $reg[$i]["contacto"] . '</div>',
				"8" => '<div class="fila' . $i . '">' . $reg[$i]["medio"] . '</div>'
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
	case 'verEstudiantesTotal':
		$periodo = $_GET["periodo"];
		$rspta = $oncentermatriculado->listar($periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}
			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"3" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"4" => '<div class="fila' . $i . '">' . $reg[$i]["fo_programa"] . '</div>',
				"5" => '<div class="fila' . $i . '">' . $reg[$i]["jornada_e"] . '</div>',
				"6" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '</div>',
				"7" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing_matriculado"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"8" => '<div class="fila' . $i . '">' . $reg[$i]["contacto"] . '</div>',
				"9" => '<div class="fila' . $i . '">' . $reg[$i]["medio"] . '</div>'
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
	case 'verEstudiantesTotalMedio':
		$medio = $_GET["medio"];
		$periodo = $_GET["periodo"];
		$rspta = $oncentermatriculado->listarpormedio($medio, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}
			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"3" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"4" => '<div class="fila' . $i . '">' . $reg[$i]["fo_programa"] . '</div>',
				"5" => '<div class="fila' . $i . '">' . $reg[$i]["jornada_e"] . '</div>',
				"6" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '</div>',
				"7" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing_matriculado"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"8" => '<div class="fila' . $i . '">' . $reg[$i]["contacto"] . '</div>',
				"9" => '<div class="fila' . $i . '">' . $reg[$i]["medio"] . '</div>'
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
	case "selectPeriodo":
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$rspta = $oncentermatriculado->selectPeriodo();
		$data["0"] .= '<option value="">Seleccionar</option>';
		for ($i = 0; $i < count($rspta); $i++) {
			$data["0"] .= "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case 'verHistorial':
		$id_estudiante = $_POST["id_estudiante"];
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$consulta1 = $oncentermatriculado->verHistorial($id_estudiante); // consulta para traer los interesados
		$nombre = $consulta1["nombre"];
		$nombre_2 = $consulta1["nombre_2"];
		$apellidos = $consulta1["apellidos"];
		$apellidos_2 = $consulta1["apellidos_2"];
		$programa = $consulta1["fo_programa"];
		$jornada = $consulta1["jornada_e"];
		$celular = $consulta1["celular"];
		$email = $consulta1["email"];
		$periodo_ingreso = $consulta1["periodo_ingreso"];
		$fecha_ingreso = $consulta1["fecha_ingreso"];
		$hora_ingreso = $consulta1["hora_ingreso"];
		$medio = $consulta1["medio"];
		$conocio = $consulta1["conocio"];
		$contacto = $consulta1["contacto"];
		$modalidad = $consulta1["nombre_modalidad"];
		$estado = $consulta1["estado"];
		$periodo_campana = $consulta1["periodo_campana"];
		$nivel_escolaridad = $consulta1["nivel_escolaridad"];
		$nombre_colegio = $consulta1["nombre_colegio"];
		$fecha_graduacion = $consulta1["fecha_graduacion"];
		$jornada_academico = $consulta1["jornada_academico"];
		$departamento_academico = $consulta1["departamento_academico"];
		$municipio_academico = $consulta1["municipio_academico"];
		$codigo_pruebas = $consulta1["codigo_pruebas"];
		$codigo_saber_pro = $consulta1["codigo_saber_pro"];
		$colegio_articulacion = $consulta1["colegio_articulacion"];
		$grado_articulacion = $consulta1["grado_articulacion"];
		$data["0"] .= '
			<div class="row">
				<div class="col-12" id="accordion">
					<div class="card-header tono-4">
						<h4 class="card-title w-100">
						<a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
							<i class="fa-regular fa-address-card bg-light-blue text-primary p-2"></i>
							Datos de Contacto
						</a>
						</h4>
					</div>
					<div id="collapseOne" class="collapse in" data-parent="#accordion" style="">
						<div class="card-body tono-3">
							<div class="row">
								<div class="col-xl-6">
									<dt>Nombre</dt>
									<dd>' . $nombre . ' ' . $nombre_2 . ' ' . $apellidos . ' ' . $apellidos_2 . '</dd>
									<dt>Programa</dt>
									<dd>' . $programa . '</dd>
									<dt>Celular</dt>
									<dd>' . $celular . '</dd>
									<dt>Email</dt>
									<dd>' . $email . '</dd>
									<dt>Fecha de Ingreso</dt>
									<dd>' . $oncentermatriculado->fechaesp($fecha_ingreso) . ' a las ' . $hora_ingreso . ' del ' . $periodo_ingreso . '</dd>
									<dt>Medio</dt>
									<dd>' . $medio . '</dd>
								</div>
									<div class="col-xl-6">							
									<dt>Conocio</dt>
									<dd>' . $conocio . '</dd>
									<dt>Contacto</dt>
									<dd>' . $contacto . '</dd>
									<dt>Modalidad</dt>
									<dd>' . $modalidad . '</dd>
									<dt>Estado</dt>
									<dd>' . $estado . '</dd>
									<dt>Campaña</dt>
									<dd>' . $periodo_campana . '</dd>
									</dl>
								</div>
							</div>
						</div>
					</div>
					<div class="card-header tono-4">
						<h4 class="card-title w-100">
						<a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseTwo">
							<i class="fa-solid fa-school bg-light-blue p-2 text-primary"></i>
							Datos Academicos
						</a>
						</h4>
					</div>
					<div id="collapseTwo" class="collapse" data-parent="#accordion">
						<div class="card-body tono-3">
							<div class="row">
								<div class="col-xl-6">
									<dl class="dl-horizontal">
										<dt>Nivel de Escolaridad</dt>
										<dd>' . $nivel_escolaridad . '</dd>
										<dt>Nombre Colegio</dt>
										<dd>' . $nombre_colegio . '</dd>
										<dt>Fecha Graduacion</dt>
										<dd>' . $fecha_graduacion . '</dd>
										<dt>Jornada Academico</dt>
										<dd>' . $jornada_academico . '</dd>
										<dt>Departamento Academico</dt>
										<dd>' . $departamento_academico . '</dd>
										<dt>Municipio Academico</dt>
										<dd>' . $municipio_academico . '</dd>
									</dl>
								</div>
								<div class="col-xl-6">
									</dl>
										<dt>Codigo Pruebas</dt>
										<dd>' . $codigo_pruebas . '</dd>
										<dt>Codigo Saber Pro</dt>
										<dd>' . $codigo_saber_pro . '</dd>
										<dt>Colegio Articulacion</dt>
										<dd>' . $colegio_articulacion . '</dd>
										<dt>Grado Articulacion</dt>
										<dd>' . $grado_articulacion . '</dd>
										<dt>Campaña</dt>
										<dd>' . $periodo_campana . '</dd>
									</dl>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'verHistorialTabla':
		$id_estudiante = $_GET["id_estudiante"];
		$rspta = $oncentermatriculado->verHistorialTabla($id_estudiante);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $oncentermatriculado->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];
			$data[] = array(
				"0" => $reg[$i]["id_estudiante"],
				"1" => $reg[$i]["motivo_seguimiento"],
				"2" => $reg[$i]["mensaje_seguimiento"],
				"3" => $oncentermatriculado->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],
				"4" => $nombre_usuario
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
	case 'verHistorialTablaTareas':
		$id_estudiante = $_GET["id_estudiante"];
		$rspta = $oncentermatriculado->verHistorialTablaTareas($id_estudiante);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $oncentermatriculado->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];
			$data[] = array(
				"0" => ($reg[$i]["estado"] == 1) ? 'Pendiente' : 'Realizada',
				"1" => $reg[$i]["motivo_tarea"],
				"2" => $reg[$i]["mensaje_tarea"],
				"3" => $oncentermatriculado->fechaesp($reg[$i]["fecha_programada"]) . ' a las ' . $reg[$i]["hora_programada"],
				"4" => $nombre_usuario
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

	case "selectModalidadCampana":
		$rspta = $oncentermatriculado->selectModalidadCampana();
		echo '<option value="">Seleccionar</option>';
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_modalidad_campana"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectEstado":
		$rspta = $oncentermatriculado->selectEstado();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre_estado"] . "'>" . $rspta[$i]["nombre_estado"] . "</option>";
		}
		break;

	//case 'eliminar':
		//$id_estudiante = $_POST["id_estudiante"];
		//$rspta1 = $oncentermatriculado->eliminarDatos($id_estudiante);
		//$rspta2 = $oncentermatriculado->eliminarSeguimiento($id_estudiante);
		//$rspta3 = $oncentermatriculado->eliminarTareas($id_estudiante);
		//$rspta = $oncentermatriculado->eliminar($id_estudiante);
		//if ($rspta == 0) {
			//echo "1";
			//$estado = "Interesado";
			//$rspta4 = $oncentermatriculado->insertarEliminar($id_estudiante, $estado, $fecha, $hora, $id_usuario);
		//} else {
			//echo "0";
		//}
		//break;


	case "selectPrograma":
		$rspta = $oncentermatriculado->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectJornada":
		$rspta = $oncentermatriculado->selectJornada();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectTipoDocumento":
		$rspta = $oncentermatriculado->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectNivelEscolaridad":
		$rspta = $oncentermatriculado->selectNivelEscolaridad();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case 'perfilEstudiante':
		$id_estudiante = $_POST["id_estudiante"];
		$rspta = $oncentermatriculado->perfilEstudiante($id_estudiante);
		echo json_encode($rspta);
		break;


	case 'correo':
		$id_estudiante = $_POST["id_estudiante"];
		$data = array(); //Vamos a declarar un array
		$data["resultado"] = "";
		// actualiza el estado del envio del mail al estudiante.
		$rspta = $oncentermatriculado->actualizarMailing($id_estudiante);
		$data["resultado"] .= $rspta ? "1" : "0";
		$motivo = "Seguimiento";
		$mensaje_seguimiento = "Envio de mailing, usuario y clave";
		// registra el seguimiento 
		$ressegui = $oncentermatriculado->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);
		$correo = $oncentermatriculado->VerHistorial($id_estudiante);
		// enviar con copia al correo personal
		$correo_personal = $correo["email"];
		// la cedula sera la clave inicial.
		$identificacion_clave = $correo["identificacion"];
		// tomamos el correo institucional 
		$correo_ciaf = $oncentermatriculado->buscar_correo_ciaf($identificacion_clave);
		$credencial_login = $correo_ciaf["credencial_login"];
		// enviamos el correo al estudiante
		$destino = $correo_personal . ',' . $credencial_login;
		$mensaje = set_template_matriculado($credencial_login,$identificacion_clave);
		enviar_correo($destino, "Bienvenido a CIAF", $mensaje);
		echo json_encode($data);
	break;



	
}