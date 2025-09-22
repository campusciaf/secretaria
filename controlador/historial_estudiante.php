<?php
error_reporting(0);
session_start();
require_once "../modelos/Historial_Estudiante.php";
$historial_estudiante = new Historial_Estudiante();
$periodo_actual = $_SESSION['periodo_actual'];
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d-H:i:s');
$id_credencial = isset($_POST["id_credencial"]) ? limpiarCadena($_POST["id_credencial"]) : "";
$credencial_nombre = isset($_POST["credencial_nombre"]) ? limpiarCadena($_POST["credencial_nombre"]) : "";
$credencial_nombre_2 = isset($_POST["credencial_nombre_2"]) ? limpiarCadena($_POST["credencial_nombre_2"]) : "";
$credencial_apellido = isset($_POST["credencial_apellido"]) ? limpiarCadena($_POST["credencial_apellido"]) : "";
$credencial_apellido_2 = isset($_POST["credencial_apellido_2"]) ? limpiarCadena($_POST["credencial_apellido_2"]) : "";
$credencial_login = isset($_POST["credencial_login"]) ? limpiarCadena($_POST["credencial_login"]) : "";
$fo_programa = isset($_POST["fo_programa"]) ? limpiarCadena($_POST["fo_programa"]) : "";
$jornada_e = isset($_POST["jornada_e"]) ? limpiarCadena($_POST["jornada_e"]) : "";

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

switch ($_GET["op"]) {

	//verifica el documento del estudiante si esta registrado o no
	case 'verificardocumento':
		$credencial_identificacion = $_POST["credencial_identificacion"];
		$rspta = $historial_estudiante->verificardocumento($credencial_identificacion);
		$data = array();
		$data["0"] = "";
		$reg = $rspta;
		if (count($reg) == 0) {
			$data["0"] .= $credencial_identificacion;
			$data["1"] = false;
		} else {
			for ($i = 0; $i < count($reg); $i++) {
				$data["0"] .= $reg[$i]["id_credencial"];
			}
			$data["1"] = true;
		}
		$results = array($data);
		echo json_encode($results);
		break;

	//lista los programas que cursados 
	case 'listar':
		$id_credencial = $_GET["id_credencial"];

		$rspta = $historial_estudiante->listar($id_credencial);
		//Vamos a declarar un array
		$data = array();
		for ($i = 0; $i < count($rspta); $i++) {
			$rspta2 = $historial_estudiante->listarEstado($rspta[$i]["estado"]);
			$estado_nombre = $rspta2["estado"];
			$id_estudiante = $rspta[$i]["id_estudiante"];
			$id_programa_ac = $rspta[$i]["id_programa_ac"];
			$fo_programa = $rspta[$i]["fo_programa"];
			$jornada_e = $rspta[$i]["jornada_e"];
			$semestre_estudiante = $rspta[$i]["semestre_estudiante"];
			$estado_ciclo = $rspta[$i]["estado"];
			$grupo = $rspta[$i]["grupo"];
			$escuela_ciaf = $rspta[$i]["escuela_ciaf"];
			$estado = $rspta2["estado"];
			$periodo = $rspta[$i]["periodo"];
			$periodo_activo = $rspta[$i]["periodo_activo"];

			$data[] = array(
				"0" => '<button class="btn btn-primary btn-xs" onclick="mostrarmaterias(' . $id_programa_ac . ',' . $id_estudiante . ')" title="Historial Estudiante"><i class="fas fa-plus-square"></i> Ver Historial</button>',
				"1" => $id_estudiante,
				"2" => $fo_programa,
				"3" => $jornada_e,
				"4" => $semestre_estudiante,
				"5" => $grupo,
				"6" => $escuela_ciaf,
				"7" => $estado,
				"8" => $periodo,
				"9" => $periodo_activo,
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


	//visualiza los botones del menu, historial academico, proceso de admisión, quedate,ingresos al campus 
	case "botonesvisualizar":
		$id_credencial = $_POST["id_credencial"];
		$data["0"] = "";
		// buscamos el estudiante por id credencial para traer la cedula
		$cedula_estudiante = $historial_estudiante->cedula_estudiante($id_credencial);
		$cedula_estudiante_on = $cedula_estudiante["credencial_identificacion"];
		$probabilidad_desercion = $cedula_estudiante["probabilidad_desercion"];
		$cedula_estudiante = $historial_estudiante->id_estudiante_datos($id_credencial);
		$id_estudiante_casos = $cedula_estudiante["id_estudiante"];
		//traemos los datos del estudiante por medio de la cedula en la tabla on_interesados
		$soporte_img = $historial_estudiante->id_estudiante_oncenter($cedula_estudiante_on);
		$id_estudiante_on = $soporte_img["id_estudiante"];
		$inscripcion = $soporte_img["inscripcion"];
		$entrevista = $soporte_img["entrevista"];
		$documentos = $soporte_img["documentos"];
		// soporte de inscripcion
		$soporte_img = $historial_estudiante->soporte_inscripcion($id_estudiante_on);

		// soporte de entrevista
		$ver_entrevista = $historial_estudiante->entrevista($id_estudiante_on);
		$tipo_busqueda = 1;

		$datospersona = $historial_estudiante->sofipersona($id_credencial);
		$id_persona = 'null';
		if ($id_persona) {
			$id_persona = $datospersona["id_persona"];
		}

		$celular_estudiante = $historial_estudiante->traerCelularEstudiante($cedula_estudiante_on);
		$mensajes_no_vistos = 0;
		if (isset($celular_estudiante["celular"])) {
			$estilo_whatsapp = 'btn-success';
			$numero_celular = $celular_estudiante["celular"];
			$registro_whatsapp = $historial_estudiante->obtenerRegistroWhastapp($numero_celular);
			$mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
		} else {
			$estilo_whatsapp = 'btn-danger disabled';
			$numero_celular = '';
		}
		$boton_whatsapp = '
		<button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
			<i class="fab fa-whatsapp"></i>
			<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
				' . $mensajes_no_vistos . '
			</span>
		</button>';
		// traer probabilidad por medio de la cedula.
		// $buscar_id_estudiante = $historial_estudiante->buscar_id_estudiante($cedula_estudiante_on);
		// $id_estudiante_probabilidad = $buscar_id_estudiante["id_estudiante"];
		// $valprobailidad = $historial_estudiante->verEntrevistaprobabilidad($id_estudiante_probabilidad);
		// $probabilidad_desercion = $valprobailidad["probabilidad_desercion"];
		// traer probabilidad_desercion por medio de la cedula. 	
		$porcentaje_probabilidad_desercion = '<div style="width:100px" data-toggle="tooltip" data-placement="top" title="Probabilidad de deserción">' . $historial_estudiante->getBarraProgreso($probabilidad_desercion) . '</div>';

		$tareas = '<button class="btn bg-lightblue btn-sm" title="Ver seguimientos" data-toggle="modal" onclick="verHistorial(' . $id_credencial . ')" data-target="#verTareas"><i data-toggle="tooltip" class="fas fa-eye" data-original-title="Ver y Añadir Seguimientos"></i></button>';
		$anadir = '<button class="btn bg-purple btn-sm" title="Nuevo seguimiento o tarea" data-toggle="modal" onclick="agregarTareaSegui(' . $id_credencial . ', ' . $id_persona . ')" data-target="#anadirTareas"><i data-toggle="tooltip" class="fa-solid fa-plus data-original-title="Añadir Seguimientos"></i></button>';

		$proceso_de_admision = '
		<a onclick="proceso_de_admision(' . $id_credencial . ')" class="btn btn-primary p-2" onclick="activarBotonDt(this)">
		<i class="fas fa-eye"></i> Proceso de Admisión</a>';

		$casos_por_estudiante = '
		<a onclick="casos_por_estudiante(' . $id_credencial . ')" class="btn btn-primary p-2" onclick="activarBotonDt(this)">
		<i class="fas fa-eye"></i> Quedate</a>';

		$influencer_por_estudiante = '
		<a onclick="influencer_por_estudiante(' . $id_credencial . ')" class="btn btn-primary p-2" onclick="activarBotonDt(this)">
		<i class="fas fa-eye"></i> Influencer</a>';


		$ingresos_campus = '<a onclick="ingresos_campus(' . $id_credencial . ')" class="btn btn-primary p-2" onclick="activarBotonDt(this)">
		<i class="fas fa-eye"></i> Ingresos Campus</a>';

		$pqr = '<a onclick="casos_pqr(' . $id_credencial . ')" class="btn btn-primary p-2" onclick="activarBotonDt(this)">
		<i class="fas fa-eye"></i> PQRSF</a>';

		$datos_perfil = '<a onclick="listaDatos(' . $id_credencial . ')" class="btn btn-primary  p-2 text-white" onclick="activarBotonDt(this)">
		<i class="fas fa-user text-white"></i> Datos del perfil</a>';

		$historial_academico = '
		<a onclick="historial_academico(' . $id_credencial . ')" class="btn btn-primary p-2" onclick="activarBotonDt(this)">
		<i class="fas fa-eye"></i> Historial Academico</a>';

		$volver_atras = '
		<button  id="bton_volver" onclick="volver()" class=" btn btn-danger btn-flat btn-xs mt-2"> Volver </button>';

		$creditos_estudiante = '
		<a onclick="listar_cuotas(' . $cedula_estudiante_on . ')" class="btn btn-primary  p-2" onclick="activarBotonDt(this)">
		<i class="fas fa-eye"></i> SOFI (Crédito)</a>
		';
		$caracterizacion = '
		<a onclick="listarcaracterizacionestudiante()" class="btn btn-primary p-2" onclick="activarBotonDt(this)">
		<i class="fas fa-eye"></i>Caracterización</a>
		';

		$data["0"] .= '
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex ">
			' . $tareas . '
			' . $anadir . '
			' . $boton_whatsapp . '
			<div class="ml-3" padding:2px;">
        ' . $porcentaje_probabilidad_desercion . '
    </div>
		</div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
			<div class="row">
				<div class="col-12 ">
					' . $volver_atras . '
					' . $datos_perfil . '
					' . $historial_academico . '
					' . $proceso_de_admision . '
					' . $casos_por_estudiante . '
					' . $influencer_por_estudiante . '
					' . $pqr . '
					' . $ingresos_campus . '
					' . $creditos_estudiante . '
					' . $caracterizacion . '

				</div>
			</div>
		</div>';

		echo json_encode($data);
		break;

	// muestra los datos del estudiante registrado
	case "mostrardatos":
		$id_credencial = $_POST["id_credencial"];
		$rspta = $historial_estudiante->mostrardatos($id_credencial);
		$data = array();
		$data["0"] = "";
		if (file_exists('../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg')) {
			$foto = '<img src=../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg class=img-circle img-bordered-sm>';
		} else {
			$foto = '<img src=../files/null.jpg width=50px height=50px class=img-circle img-bordered-sm>';
		}
		$data["0"] .= '
			<div style="margin:2%">
				<div class="user-block">
					' . $foto . '
					<div class="username">
						<span href="#">' . $rspta["credencial_nombre"] . ' ' . $rspta["credencial_nombre_2"] . ' ' . $rspta["credencial_apellido"] . ' ' . $rspta["credencial_apellido_2"] . '</span>
						<div class="">' . $rspta["credencial_login"] . '</div>';
		'
					</div>
				</div>
			</div>';
		$results = array($data);
		echo json_encode($results);
		break;

	// muestra las materias que esta cursando el estudiante
	case "mostrarmaterias":
		$id_programa_ac = $_POST["id_programa_ac"];
		$id_estudiante = $_POST["id_estudiante"];

		$data["0"] = "";
		//consulta para ver los datos del programa
		$rspta2 = $historial_estudiante->datosPrograma($id_programa_ac);
		$reg2 = $rspta2;
		$semestres_del_programa = $reg2["semestres"];
		$ciclo = "materias" . $reg2["ciclo"]; // para saber en que tabla debe busar las materias
		$cortes = $reg2["cortes"]; // para saber en que tabla debe busar las materias
		$inicio_cortes = 1;

		//consulta para ver los datos del programa en que se matriculo el estudiante
		$rspta4 = $historial_estudiante->datosEstudiante($id_estudiante);
		$reg4 = $rspta4;

		$jornada_estudio = $reg4["jornada_e"];

		$semestres = 1;
		while ($semestres <= $semestres_del_programa) {

			$data["0"] .= '
				<div class="col-12">
					<div class="box box-warning">
						<div class="box-header with-border">
						<h3 class="box-title">Semestre ' . $semestres . '</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">';


			$data["0"] .= '	
					<div class="box">
						<div class="box-body table-responsive no-padding">
						<table class="table table-hover" style="width:100%">
						<tbody><tr>
						<th>Asignatura</th>';

			for ($y = 1; $y <= $cortes; $y++) {
				$data["0"] .= '<th>C' . $y . '</th>';
			}

			$data["0"] .= '
				<th>Promedio</th>
				<th>Huella</th>
				<th>Periodo</th>
				<th>Faltas</th>
				<th>Quién lo matriculó</th>
				<th>Fecha</th>
				</tr>';

			$rspta = $historial_estudiante->listarMaterias($id_estudiante, $ciclo, $semestres);
			$reg = $rspta;

			

			for ($i = 0; $i < count($reg); $i++) {
				
				$materia = $reg[$i]["nombre_materia"]; // nombre de la materia 
				$id_materia = $historial_estudiante->traerCodigoMateria($reg[$i]["nombre_materia"]);

				$faltas = $reg[$i]["faltas"]; // nombre de la materia 
				$huella = $reg[$i]["huella"];
				$usuario = $reg[$i]["usuario"];

				($id_docente);
				if (ctype_digit($usuario)) {
					$traer_datos_estudiantes = $historial_estudiante->listarestudiante($usuario);
					$nombre = $traer_datos_estudiantes["credencial_nombre"] . ' ' . $traer_datos_estudiantes["credencial_nombre_2"] . ' ' . $traer_datos_estudiantes["credencial_apellido"] . ' ' . $traer_datos_estudiantes["credencial_apellido_2"];
				} else {
					// Si contiene letras u otros caracteres, asume que es nombre de funcionario
					$traer_datos_funcionario = $historial_estudiante->listarfuncionario($usuario);
					$nombre = $traer_datos_funcionario["usuario_nombre"] . " " . $traer_datos_funcionario["usuario_nombre_2"] . " " . $traer_datos_funcionario["usuario_apellido"] . " " . $traer_datos_funcionario["usuario_apellido_2"];
				}
				$fecha = $historial_estudiante->fechaesp($reg[$i]["fecha"]);
				if ($huella == "" || $huella == 0) {
					$huella = "No aplica";
				} else {

					$huella = $reg[$i]["huella"];
				}

				$data["0"] .= '
					<tr>
						<td>' . $materia . ' ' . $id_materia . '</td>';
				$inicio_cortes = 1;
				$corte_nota = "";
				while ($inicio_cortes <= $cortes) {
					$corte_nota = "c" . $inicio_cortes;

					$data["0"] .= '<td class="ancho-md">' . $reg[$i][$corte_nota] . '</td>';
					$inicio_cortes++;
				}

				$da = $historial_estudiante->valorhuella();
				$data["0"] .= '
							<td class="ancho-md">' . $reg[$i]["promedio"] . '</td>
							<td>' . $huella . '</td>
							<td>' . $reg[$i]["periodo"] . '</td>
							<td>' . $faltas . '</td>
							<td>' . $nombre . '</td>
							<td>' . $fecha . ' '.$id_docente.'</td>
							<td>' . $nombre_docente . '</td>
						</tr>';
			} // cierra el for

			$data["0"] .= ' 
						</tbody></table>
					</div>
					<!-- /.box-body -->
				</div>';

			$data["0"] .= '  
				</div>
				
				</div>
			
			</div>';

			$semestres++;
		} //cierra el while

		$results = array($data);
		echo json_encode($results);
		break;

	//trae los datos de la entrevista del estudiante
	case 'verEntrevista':
		$id_estudiante = $_POST["id_estudiante"];
		$rspta = $historial_estudiante->verEntrevista($id_estudiante);
		echo json_encode($rspta);
		break;

	// muestra los pqr
	case 'verAyudaTerminado':
		$id_credencial = $_POST["global_id_credencial"];

		$rspta = $historial_estudiante->verAyuda($id_credencial);
		$reg = $rspta;
		$data["0"] = "";

		if (empty($rspta)) {

			$data["0"] .= '
					<div class="alert alert-danger" role="alert">
						<h4 class="alert-heading"></h4>
						<p> No Tienes Casos Activos</p>
					</div>';
		} else {
			for ($i = 0; $i < count($reg); $i++) {
				$nombre1 = $reg[$i]["credencial_nombre"];
				$nombre2 = $reg[$i]["credencial_nombre_2"];
				$apellido1 = $reg[$i]["credencial_apellido"];
				$apellido2 = $reg[$i]["credencial_apellido_2"];
				$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;
				$id_asunto = $reg[$i]["id_asunto"];
				$buscarasunto = $historial_estudiante->buscarasunto($id_asunto); // busca el asunto
				$asunto = $buscarasunto["asunto"];
				$buscaropcionasunto = $historial_estudiante->buscaropcionasunto($reg[$i]["id_asunto_opcion"]); // busca el asunto
				$opcion = $buscaropcionasunto["opcion"];
				$estado = $reg[$i]["estado"];
				if ($estado == 0) {

					$data["0"] .= '
							<div class="col-md-12">
							
							<div class="box box-primary direct-chat direct-chat-primary">
								<div class="box-header with-border">
								<hr>
								<h3 class="box-title">' . $asunto . '</h3>
								<span>' . $opcion . '</span>
								</div>
								<!-- /.box-header -->
								<div class="box-body" style="overflow-x:none !important">
								<!-- Conversations are loaded here -->
								<div class="direct-chat-messages" style="height:auto !important">
									<!-- Message. Default to the left -->
									<div class="direct-chat-msg">
									<div class="direct-chat-info clearfix">
									
										<span class="direct-chat-name pull-left">' . $nombre_completo . '</span><br>
										
										<small><span class="direct-chat-timestamp">' . $historial_estudiante->fechaesp($reg[$i]["fecha_solicitud"]) . ' a las: ' . $reg[$i]["hora_solicitud"] . ' Del: ' . $reg[$i]["periodo_ayuda"] . '</span></small>
									</div>
									';

					if (file_exists('../files/estudiantes/' . $reg[$i]['credencial_identificacion'] . '.jpg')) {
						$data["0"] .= '<img src=../files/estudiantes/' . $reg[$i]['credencial_identificacion'] . '.jpg class=direct-chat-img>';
					} else {
						$data["0"] .= '<img src=../files/null.jpg class=direct-chat-img>';
					}

					$data["0"] .= '	
									<div class="direct-chat-text">
										' . $reg[$i]["mensaje"] . '
									</div>
								</div>';
					// ahora siguen las respuestas
					$rspta2 = $historial_estudiante->listarRespuesta($reg[$i]["id_ayuda"]);
					$reg2 = $rspta2;
					for ($j = 0; $j < count($reg2); $j++) {
						$datosusuario = $historial_estudiante->datosDependencia($reg2[$j]["id_usuario"]);
						error_reporting(0);
						$data["0"] .= '	
									
									<div class="direct-chat-msg right">
										<div class="direct-chat-info clearfix">
											<span class="direct-chat-name pull-right">' . $datosusuario["usuario_cargo"] . '</span><br>
											<small><span class="direct-chat-timestamp pull-left">' . $historial_estudiante->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las: ' . $reg2[$j]["hora_respuesta"] . ' Del: ' . $reg2[$j]["periodo_respuesta"] . '</span></small>
										</div>';

						$rspta3 = $historial_estudiante->datosDependencia($reg2[$j]["id_remite_a"]);

						if (file_exists('../files/usuarios/' . $datosusuario['usuario_imagen'])) {
							$data["0"] .= '<img src=../files/usuarios/' . $datosusuario['usuario_imagen'] . ' class=direct-chat-img>';
						} else {
							$data["0"] .= '<img src=../files/null.jpg class=direct-chat-img>';
						}

						if ($reg2[$j]["accion"] == 1) {
							$data["0"] .= '	
												<div class="direct-chat-text">
												
												' . $reg2[$j]["mensaje_dependencia"] . '
												</div>
												<!-- /.direct-chat-text -->
												';
						} else {

							$data["0"] .= '
											<div class="direct-chat-text alert alert-warning D" >
											' . $reg2[$j]["mensaje_dependencia"] . '
											</div>
											<div class="alert" style="margin-bottom:0px !important"><center>Caso redirigido <i class="fas fa-exchange-alt"></i>' . $rspta3["usuario_cargo"] . ' - ' . $historial_estudiante->fechaesp($reg2[$j]["fecha_respuesta"]) . ' a las ' . $reg2[$j]["hora_respuesta"] . ' </center></div>
											
											<!-- /.direct-chat-text -->';
						}

						$data["0"] .= '  
										</div>
										
								<!-- /.direct-chat-msg -->';
					}
				}
			}
		}

		echo json_encode($data);
		break;

	case 'proceso_de_admision_soportes':
		$id_credencial = $_GET["global_id_credencial"];
		// buscamos el estudiante por id credencial para traer la cedula
		$cedula_estudiante = $historial_estudiante->cedula_estudiante($id_credencial);
		$cedula_estudiante_on = $cedula_estudiante["credencial_identificacion"];
		$cedula_estudiante = $historial_estudiante->id_estudiante_datos($id_credencial);
		$id_estudiante_casos = $cedula_estudiante["id_estudiante"];
		//traemos los datos del estudiante por medio de la cedula en la tabla on_interesados
		$soporte_img = $historial_estudiante->id_estudiante_oncenter($cedula_estudiante_on);
		$id_estudiante_on = $soporte_img["id_estudiante"];
		$inscripcion = $soporte_img["inscripcion"];
		$entrevista = $soporte_img["entrevista"];
		$documentos = $soporte_img["documentos"];
		// soporte de inscripcion
		$soporte_img = $historial_estudiante->soporte_inscripcion($id_estudiante_on);
		// soporte de entrevista
		$ver_entrevista = $historial_estudiante->entrevista($id_estudiante_on);
		if ($ver_entrevista and $entrevista == 1) { //hay entrevista pero sin validar
			$entrevista = '<button class="btn btn-primary btn-xs col-6" onclick="verEntrevista(' . $id_estudiante_on . ')" ><i class="fas fa-eye"></i> Ver entrevista</button> 
			<span class="badge bg-warning"> Sin validar</span>';
		} else if ($ver_entrevista and $entrevista == 0) { //hay entrevista validada
			$entrevista = '<button class="btn btn-primary btn-xs col-6"onclick="verEntrevista(' . $id_estudiante_on . ')" ><i class="fas fa-eye"></i> Ver entrevista</button> ';
		}

		// consulta cedula
		$rspta = $historial_estudiante->soporteCedula($id_estudiante_on);
		$rspta ? "1" : "0";
		if ($rspta) {
			$cedula_tab .= "	
							<a href='../files/oncenter/img_cedula/" . $rspta["nombre_archivo"] . "' class='btn btn-primary btn-xs col-6' target='_blank'><i class='fas fa-eye'></i>Ver soporte Cédula</a>";
		} else {
			$cedula_tab .= '
				<span class="badge badge-primary">Sin validar</span>

				';
		}
		/* ********************** */

		// consulta diploma
		$rspta2 = $historial_estudiante->soporteDiploma($id_estudiante_on);
		$rspta2 ? "1" : "0";
		if ($rspta2) {
			$diploma .= "
											
						<a href='../files/oncenter/img_diploma/" . $rspta2["nombre_archivo"] . "' class='btn btn-primary btn-xs col-6' target='_blank'><i class='fas fa-eye'></i>Ver soporte Diploma</a>";
		} else {
			$diploma .= '
				<span class="badge badge-primary">Sin validar</span>';
		}

		/* ********************** */
		// consulta acta
		$rspta3 = $historial_estudiante->soporteActa($id_estudiante_on);
		$rspta3 ? "1" : "0";
		if ($rspta3) {
			$acta .= "
						
							<a href='../files/oncenter/img_acta/" . $rspta3["nombre_archivo"] . "' class='btn btn-primary btn-xs col-6' target='_blank'><i class='fas fa-eye'></i>Ver soporte acta</a>";
		} else {
			$acta .= '
					<span class="badge badge-primary">Sin Validar</span>
					';
		}

		/* ********************** */
		// consulta salud
		$rspta4 = $historial_estudiante->soporteSalud($id_estudiante_on);
		$rspta4 ? "1" : "0";
		if ($rspta4) {
			$salud .= "
							<a href='../files/oncenter/img_salud/" . $rspta4["nombre_archivo"] . "' class='btn btn-primary btn-xs col-6' target='_blank'><i class='fas fa-eye'></i> Ver soporte salud .....</a>";
		} else {
			$salud .= '
					<span class="badge badge-primary">Sin Validar</span>
					';
		}
		// consulta pruebas
		$rspta5 = $historial_estudiante->soportePrueba($id_estudiante_on);

		$rspta5 = $historial_estudiante->soportePrueba($id_estudiante);
		$rspta5 ? "1" : "0";
		if ($rspta5) {
			$prueba .= "
							<h5>Soporte Pruebas</h5>
							<a href='../files/oncenter/img_prueba/" . $rspta5["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'> <i class='fas fa-eye'></i>Ver soporte prueba ..</a>";
		} else {
			$prueba .= '
					<span class="badge badge-primary">Sin Validar</span>';
		}
		if ($datos[0]['mailing'] == 0) { // si el mailing se envio
			if ($datos[0]['formulario'] == 1) {
				$formulario = ' ';
			} else {
				$id_estudiante_btn = isset($id_estudiante_on) && $id_estudiante_on ? $id_estudiante_on : (isset($id_estudiante) ? $id_estudiante : '');
				$formulario = '<span class="badge bg-green"><i class="fas fa-check-double" title="Validado"></i> Validado</span> <button type="button" class="btn btn-primary btn-sm ms-2" title="Ver perfil" onclick="perfilEstudiante(' . $id_estudiante_btn . ')"> Ver Formulario</button>' ;
			}
		} else {
			$formulario = "Pendiente envio de mailing";
		}
		$compromiso = $historial_estudiante->soporteCompromiso($id_estudiante);
		$compromiso ? "1" : "0";
		if ($compromiso) {
			$compromiso .= "
						<div class='card'>
							<h5>Soporte Compromiso</h5>
							<div class='btn-group'>	
							<a href='../files/oncenter/img_compromiso/" . $compromiso["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte compromiso ..</a>";


			$compromiso .= "</div></div>";
		} else {
			$compromiso .= '
					<span class="badge badge-primary">Sin validar</span>
					';
		}

		if ($soporte_img) {
			$soporte_pago = '<a href="../files/oncenter/img_inscripcion/' . $soporte_img['nombre_archivo'] . '" target="_blank" class="btn btn-primary btn-xs col-6"><i class="fas fa-eye"></i> ver soporte </a> ';
		}

		$data[0] = ["Formulario", $formulario];
		$data[1] = ["Soporte Pago", $soporte_pago];
		$data[2] = ["Soporte diploma", $diploma];
		$data[3] = ["Soporte identificación", $cedula_tab];
		$data[4] = ["Soporte Salud", $salud];
		$data[5] = ["Soporte Acta de Grado", $acta];
		$data[6] = ["Entrevista", $entrevista];
		$data[7] = ["Prueba", $prueba];
		$data[8] = ["Compromiso", $compromiso];

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;

	case 'quedate_estudiante':
		$id_credencial = $_GET["global_id_credencial"];
		// buscamos el estudiante por id credencial para traer la cedula
		$cedula_estudiante = $historial_estudiante->cedula_estudiante($id_credencial);
		$cedula_estudiante_on = $cedula_estudiante["credencial_identificacion"];
		// $cedula_estudiante = $historial_estudiante->id_estudiante_datos($id_credencial);
		// $id_estudiante_casos = $cedula_estudiante["id_estudiante"];
		$datos = $historial_estudiante->caso_por_estudiante($cedula_estudiante_on);
		$data = array();
		for ($i = 0; $i < count($datos); $i++) {

			$casos_id = $datos[$i]['caso_id'];
			$caso_estado = $datos[$i]['caso_estado'];

			$estado_caso = ($caso_estado == "Activo") ? '<span class="badge badge-success p-1">' . $caso_estado . '</span>' : '<span class="badge badge-danger p-1">' . $caso_estado . '</span>';



			$casos_quedate = '
			<button class="btn btn-primary btn-xs" onclick="modal_casos_quedate(' . $casos_id . ')"><i class="fas fa-eye"></i>Ver Caso</button>';

			$data[] = array(

				"0" => $datos[$i]['caso_id'],
				"1" => $datos[$i]['created_at'],
				"2" => $datos[$i]['caso_asunto'],
				"3" => $estado_caso,
				"4" => $casos_quedate
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


	case 'mostrar_casos_quedate_estudiante':
		$id_caso = $_POST["casos_id"];
		// $data["0"] = "";
		$datos = $historial_estudiante->caso($id_caso);
		$datos_seguimiento = $historial_estudiante->seguimientos($id_caso);
		// print_r($datos_seguimiento);
		$datos_remsiones = $historial_estudiante->remsiones($id_caso);
		$datos_tareas = $historial_estudiante->tareas($id_caso);
		$data = array();
		$data_envia['conte'] = '';

		for ($i = 0; $i < count($datos_seguimiento); $i++) {
			if ($datos_seguimiento) {
				$data[] = array(
					'tipo' => 'seguimiento',
					'conte' => $datos_seguimiento[$i]
				);
			}
		}
		for ($i = 0; $i < count($datos_remsiones); $i++) {
			if ($datos_remsiones and $datos_seguimiento) {
				array_push($data, array(
					'tipo' => 'remisiones',
					'conte' => $datos_remsiones[$i]
				));
			} else {
				$data[] = array(
					'tipo' => 'remisiones',
					'conte' => $datos_remsiones[$i]
				);
			}
		}
		for ($i = 0; $i < count($datos_tareas); $i++) {
			if ($datos_tareas || $datos_seguimiento || $datos_remsiones) {
				array_push($data, array(
					'tipo' => 'tareas',
					'conte' => $datos_tareas[$i]
				));
			} else {
				$data[] = array(
					'tipo' => 'tareas',
					'conte' => $datos_tareas[$i]
				);
			}
		}
		function compara_fecha($a, $b)
		{
			return strtotime(trim($a['conte']['created_at'])) < strtotime(trim($b['conte']['created_at']));
		}

		$data_envia['conte'] .= '<ul class="nav nav-pills ml-auto pb-2">
			<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Caso # ' . $id_caso . '</a></li>
		</ul>';

		$button = ($datos['caso_estado'] == "Activo") ? '
                                <div class="col-12 col-md-6 text-right"></div>' : '';
		$color = ($datos['caso_estado'] == "Activo") ? 'success' : 'danger';
		$data_envia['conte'] .= '<h3 class="col-12 col-md-6 tab-content-title text-' . $color . '">
                ' . $datos['caso_asunto'] . '
                <span class="label label-' . $color . '" style="font-size: 50%; margin-left: 5px">' . $datos['caso_estado'] . '</span>
            </h3>' . $button . '
            <div class="timeline col-12 pt-2">';
		if ($datos_seguimiento || $datos_remsiones || $datos_tareas) {
			usort($data, 'compara_fecha');
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]['tipo'] == 'seguimiento') {
					$evidencia = '';
					if ($data[$i]['conte']['evidencia_seguimiento'] != "") {
						$extencion = explode(".", $data[$i]['conte']['evidencia_seguimiento']);
						$evidencia = ($extencion[1] == 'pdf') ? '<p> Evidencia: 
                            <a href="../public/evidencias_quedate/seguimiento/' . $data[$i]['conte']['evidencia_seguimiento'] . '" target="_blank" rel="noopener noreferrer" class="text-danger">
                                <i class="far fa-file-pdf fa-2x"></i>
                            </a>
                        </p>' : '<p> Evidencia: 
                            <a href="../public/evidencias_quedate/seguimiento/' . $data[$i]['conte']['evidencia_seguimiento'] . '" target="_blank" rel="noopener noreferrer">
                                <i class="far fa-image fa-2x"></i>
                            </a>
                        </p>';
					}
					$beneficio = ($data[$i]['conte']['seguimiento_beneficio'] == "") ? '' : 'Beneficio: ' . $data[$i]['conte']['seguimiento_beneficio'];
					$tipo_encuentro = ($data[$i]['conte']['seguimiento_tipo_encuentro'] == "") ? '' : 'Tipo de encuentro: ' . $data[$i]['conte']['seguimiento_tipo_encuentro'];
					$docente = ($data[$i]['conte']['docente'] == "") ? 'Docente involucrado: Ninguno' : 'Docente involucrado: ' . strtoupper($historial_estudiante->nombre_docente($data[$i]['conte']['docente']));
					$data_envia['conte'] .= '
                    <div>
                        <i class="fas fa-binoculars bg-green"></i>
                        <div class="timeline-item" >
                            <span class="text-muted time">' . $data[$i]['conte']['created_at'] . '</span>
                            <h3 class="timeline-header">
                                <a href="#"> Seguimiento</a>
                            </h3>
                            <div class="timeline-body">
                                <p>Contenido: ' . $data[$i]['conte']['seguimiento_contenido'] . '</p>
                                <p>' . $beneficio . '</p>
                                <p>' . $tipo_encuentro . '</p>
                                <p>' . $docente . '</p>
                                ' . $evidencia . '
                            </div>
                        </div>
                    </div>';
				}
				if ($data[$i]['tipo'] == 'remisiones') {
					$dependencia_desde = $historial_estudiante->consulta_dependencia($data[$i]['conte']['remision_desde']);
					$dependencia_para = $historial_estudiante->consulta_dependencia($data[$i]['conte']['remision_para']);
					$data_envia['conte'] .= '
                        <div>
                            <i class="fas fa-paper-plane bg-yellow"></i>
                            <div class="timeline-item" >
                                <span class="text-muted time">' . $data[$i]['conte']['created_at'] . '</span>
                                <h3 class="timeline-header">
                                    <a href="#"> Remisiones  </a>
                                </h3>
                                <div class="timeline-body">
                                    <small class="text-muted">' . $dependencia_desde['usuario_cargo'] . ' <i class="fas fa-long-arrow-alt-right"></i> ' . $dependencia_para['usuario_cargo'] . '</small>
                                    <p>Obersevación: ' . $data[$i]['conte']['remision_observacion'] . '</p>
                                </div>
                            </div>
                        </div>';
				}
				if ($data[$i]['tipo'] == 'tareas') {
					$contenido = ($data[$i]['conte']['tarea_contenido'] == '') ? '' : 'Contenido: ' . $data[$i]['conte']['tarea_contenido'];
					$docente = ($data[$i]['conte']['docente'] == "") ? 'Docente involucrado: Ninguno' : 'Docente involucrado: ' . strtoupper($historial_estudiante->nombre_docente($data[$i]['conte']['docente']));
					$data_envia['conte'] .= '
                        <div>
                            <i class="fas fa-user-clock bg-blue"></i>
                            <div class="timeline-item" >
                                <span class="text-muted time">' . $data[$i]['conte']['created_at'] . '</span>
                                <h3 class="timeline-header">
                                    <a href="#"> Tareas</a>
                                </h3>
                                <div class="timeline-body">
                                    <p>Asunto: ' . $data[$i]['conte']['tarea_asunto'] . '</p>
                                    <p>' . $contenido . '</p>
                                    <p>' . $docente . '</p>
                                </div>
                            </div>
                        </div>';
				}
			}
		}
		$data_envia['conte'] .= '</div>';
		echo json_encode($data_envia);

		break;

	//grafico para el ingreso de estudiantes
	case "grafico2":
		$id_credencial = $_POST["global_id_credencial"];
		$mes = isset($_POST["mes"]) ? $_POST["mes"] : date("m");
		$anio = isset($_POST["anio"]) ? $_POST["anio"] : date("Y");
		$data = array();
		$data["datosuno"] = "";
		$coma = ",";
		$valoranterior = 0;
		$valornuevo = 0;
		$figura = "circle";
		$color = "#6B8E24";
		$data["datosuno"] .= '[ ';
		$fecha_consulta = $anio . "-" . $mes;
		$caso_estudiante_por_mes = $historial_estudiante->consulta_por_mes_2($id_credencial, $fecha_consulta);
		for ($d = 0; $d < count($caso_estudiante_por_mes); $d++) {
			$casos_x_fecha = $caso_estudiante_por_mes[$d]["total_ingreso"];
			$fecha_creacion = $caso_estudiante_por_mes[$d]["fecha"];
			$separar_fecha = explode('-', $fecha_creacion);
			$dia_separado = $separar_fecha[2];
			$valornuevo = $casos_x_fecha;
			$data["datosuno"] .= '{ "label": "' . $dia_separado . '", "y": ' . $casos_x_fecha . ', "indexLabel": "' . $casos_x_fecha . '", "markerType": "' . $figura . '",  "markerColor": "' . $color . '" },';
			$valoranterior = $casos_x_fecha;
		}
		// eliminar la coma de la ultima columna para evitar error.
		$data["datosuno"] = substr($data["datosuno"], 0, -1);
		$data["datosuno"] .= ' ]';

		echo json_encode($data);
		break;

	case 'ingresos_campus_x_fecha':
		$casos_id = $_POST["global_id_credencial"];
		$data["0"] = "";

		// <select onchange="generarGrafica()" class="form-control" id="anio" name="anio">
		// 				<option value="2024" selected>2024</option>
		// 				<option value="2023">2023</option>
		// 				<option value="2022">2022</option>
		// 				<option value="2021">2021</option>
		// 			</select>
		$data["0"] .= '
		
		<div id="IngresosCampus">
		
			<form action="#" class="row" id="form_grafica">

			<div class="col">
				<div class="form-group mb-3 position-relative check-valid">
					<div class="form-floating">
						<select onchange="generarGrafica()" value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="anio" id="anio"></select>
						<label>Selecciona Año</label>
					</div>
				</div>
				<div class="invalid-feedback">Please enter valid input</div>
			</div>
			
			<div class="col">
				<select class="form-control" onchange="generarGrafica()" name="mes" id="mes">
					<option value="" disabled selected> Selecciona el mes </option>
					<option value="01">Enero</option>
					<option value="02">febrero</option>
					<option value="03">marzo</option>
					<option value="04">abril</option>
					<option value="05">mayo</option>
					<option value="06">junio</option>
					<option value="07">julio</option>
					<option value="08">agosto</option>
					<option value="09">septiembre</option>
					<option value="10">octubre</option>
					<option value="11">noviembre</option>
					<option value="12">diciembre</option>
				</select>
			</div>
			</form>
			<form name="consultafecha" id="consultafecha" method="POST" enctype="multipart/form-data">
				<div id="chartContainer2" style="height: 420px; max-width: 920px; margin: 0px auto;"></div>
			</form>
		</div>';

		echo json_encode($data);
		break;

	case 'listarCuotas': //Listar todos los financiados por medio de la cedula
		$tipo_busqueda = 1;
		$dato_busqueda = $_POST["global_id_credencial"];
		$cedula_estudiante = $historial_estudiante->cedula_estudiante($dato_busqueda);
		$cedula_estudiante_on = $cedula_estudiante["credencial_identificacion"];

		//hacemos peticion al modelo
		$rsta = $historial_estudiante->listarCuotas($tipo_busqueda, $cedula_estudiante_on);
		//creamos un array
		$array = array();
		//dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
		for ($t = 0; $t < count($rsta); $t++) {
			$totales = $historial_estudiante->cuotasTotales($rsta[$t]["id"])["total"];
			$pagadas = $historial_estudiante->cuotasPagadas($rsta[$t]["id"])["total"];
			if ($totales == $pagadas) {
				$color_boton = "btn-success";
				$tooltip = "Finalizado";
			} else {
				$color_boton = "btn-warning";
				$tooltip = "En Proceso";
			}

			$id_matricula = $rsta[$t]["id"];

			if ($rsta[$t]["estado_ciafi"] == 1) {
				$estadoingreso = 'Sin bloqueo';
			} else {
				$estadoingreso = '<button class="btn btn-flat btn-sm btn-danger" onclick="cambiar_estado_ciafi(' . $rsta[$t]["estado_ciafi"] . ',' . $id_matricula . ')">Bloqueado</button>';
			}

			$array[] = array(
				"0" => '<button class="btn ' . $color_boton . ' btn-flat tooltip-button" onclick="modal_traer_pagos(' . $id_matricula . ')" data-toggle="tooltip" data-html="true" title="<b>' . $tooltip . '</b>"> <i class="fas fa-calendar-alt"></i> </button>',
				"1" => $estadoingreso,
				"2" => $rsta[$t]["periodo"],
				"3" => $rsta[$t]["id"],
				"4" => $rsta[$t]["programa"],
				"5" => $historial_estudiante->formatoDinero($rsta[$t]["valor_total"]),
				"6" => $historial_estudiante->formatoDinero($rsta[$t]["valor_financiacion"]),
				"7" => $rsta[$t]["descuento"],
				"8" => date("Y-m-d", strtotime($rsta[$t]["fecha_inicial"])),
			);
		}

		//se crea otro array para almacenar toda la informacion que analizara el datatable
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($array), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
			"aaData" => $array
		);
		echo json_encode($results);
		break;

	case 'MostrarPagosEstudiante':
		$id_matricula = $_POST["id_matricula"];
		$rsta = $historial_estudiante->Pagos_Sofi_Estudiante($id_matricula);
		$data["0"] = "";
		$data[0] .= '		
			<table id="mostrarpagos" class="table table-striped table-condensed table-hover" style="width:100%">
			<thead>
				<tr>

					<th scope="col" class="text-center">Cuota</th>
					<th scope="col" class="text-center">Valor</th>
					<th scope="col" class="text-center">Pagado</th>
					<th scope="col" class="text-center">Fecha</th>
					<th scope="col" class="text-center">Plazo</th>
					<th scope="col" class="text-center">Atraso</th>
					<th scope="col" class="text-center">Pagar</th>
				</tr>
			</thead><tbody>';

		for ($i = 0; $i < count($rsta); $i++) {
			$btn_pagado = '<button class="btn btn-sm bg-green  btn-flat btn-block" disabled><i class="fas fa-check"></i><i> Pagado</i></button>';
			$btn_progreso_normal = '<button class="btn btn-sm bg-yellow btn-flat btn-block" disabled><i class="fas fa-spinner"></i><i> En proceso</i></button>';
			$btn_proceso_atrasado = '<button class="btn btn-sm btn-danger btn-flat btn-block" disabled> <i class="fas fa-calendar-times"></i> <i> Atrasado </i> </button>';
			$btn_anulado = '<button class="btn btn-sm bg-orange btn-flat btn-block" disabled><i class="fas fa-handshake-alt-slash"></i> <i> Anulado</i></button>';

			if (strtotime($hoy) >= strtotime($rsta[$i]["fecha_pago"]) and $flag) {
				$btn_progreso = $btn_proceso_atrasado;
			} else {
				$btn_progreso = $btn_progreso_normal;
			}

			//calculamos los dias de atraso
			$dias_atraso = $historial_estudiante->diferenciaFechas(date("Y-m-d"), $rsta[$i]["plazo_pago"]);

			//creamos las variables de los botones que tienen accion
			$e = $rsta[$i]["estado"];

			//id del financiamiento
			$id_cuota = $rsta[$i]["id_financiamiento"];

			//el valor de la cuota actual
			$valor_a_pagar = intval($rsta[$i]["valor_cuota"] - $rsta[$i]["valor_pagado"]);

			$btn_pagar = '<button class="btn btn-sm bg-navy btn-flat btn-block" data-toggle="modal" data-target="#modal_pagar_cuotas" disabled>
							<i data-toggle="tooltip" data-original-title="Pagar Cuota"><i class="fas fa-hand-holding-usd"> Pagar </i></i>
						</button>';
			$btn_abonar = '<button class="btn btn-sm btn-info btn-flat" disabled> <i data-toggle="tooltip" data-original-title="Abonar Cuota"><i class="fas fa-coins"></i></i> </button>';
			$btn_adelantar = '<button class="btn btn-sm btn-warning btn-flat" disabled> <i data-toggle="tooltip" data-original-title="Adelantar Cuota"><i class="fas fa-angle-double-right"></i></i></button>';
			$btn_atraso = '<button class="btn btn-sm btn-danger btn-flat btn-block" disabled>
						<i data-toggle="tooltip" data-original-title="Pagar Atrasado">
							<i class="fas fa-calendar-times"></i> 
							<i> Atrasado</i>
						</i>
					</button>';
			$btn_abonado = '<button class="btn btn-sm bg-teal btn-flat" disabled>
						<i data-toggle="tooltip" data-original-title="Pagar total abonado"><i class="fas fa-handshake"></i></i>
					</button>';
			//array con info
			$final = '<div class="text-center" style="padding:0px  !important; margin:0px !important;">
                            ' . (($rsta[$i]["estado_credito"] == "Anulado") ? $btn_anulado : (($e == "Pagado") ? $btn_pagado : (($flag) ? $btn_progreso : $btn_pagar))) . '
                        </div>';
			$numero_cuota =  $rsta[$i]["numero_cuota"];
			$valor_cuota = $historial_estudiante->formatoDinero($rsta[$i]["valor_cuota"]);
			$valor_pagado = $historial_estudiante->formatoDinero($rsta[$i]["valor_pagado"]);
			$fecha_pago = $historial_estudiante->fechaesp($rsta[$i]["fecha_pago"]);
			$plazo_pago = $historial_estudiante->fechaesp($rsta[$i]["plazo_pago"]);
			$estado = ($rsta[$i]["estado"] == "A Pagar" && strtotime($hoy) >= strtotime($rsta[$i]["fecha_pago"])) ? $dias_atraso : (($rsta[$i]["estado"] == "A Pagar" && strtotime($hoy) < strtotime($rsta[$i]["fecha_pago"])) ? "-" . $dias_atraso : 0);
			$flag = ($e == "Pagado") ? false : true;


			$data[0] .= '
				<tr>	
					<td class="text-center">' . $numero_cuota . '</td>
					<td class="text-center">' . $valor_cuota . '</td>
					<td class="text-center">' . $valor_pagado . '</td>
					<td class="text-center">' . $fecha_pago . '</td>
					<td class="text-center">' . $plazo_pago . '</td>
					<td class="text-center">' . $estado . '</td>
					<td class="text-center">' . $final . '</td>
				</tr>
				';
		}
		$data[0] .= '</tbody></table>';
		echo json_encode($data);

		break;

	case 'casos_pqr':
		$id_credencial = $_GET["global_id_credencial"];

		$casos_estudiante_pqr = $historial_estudiante->verCasosTabla($id_credencial);
		$data = array();
		for ($i = 0; $i < count($casos_estudiante_pqr); $i++) {

			$id_asunto = $casos_estudiante_pqr[$i]['id_asunto'];
			$id_asunto_opcion = $casos_estudiante_pqr[$i]['id_asunto_opcion'];
			$asunto = $casos_estudiante_pqr[$i]['asunto'];
			$fecha_solicitud = $casos_estudiante_pqr[$i]['fecha_solicitud'];
			$estado_caso = $casos_estudiante_pqr[$i]['estado'];
			$opciones = '<button class="btn btn-primary btn-xs" onclick="pqr(' . $casos_id . ')"><i class="fas fa-eye"></i>Ver PQRSF</button>';

			$estado_caso =  ($estado_caso == 1) ? '<span class="badge badge-danger p-1">Cerrado</span>' : '<span class="badge badge-success p-1">Abierto</span>';

			$buscarasunto = $historial_estudiante->buscarasunto($casos_estudiante_pqr[$i]["id_asunto"]); // busca el asunto
			$asunto = $buscarasunto["asunto"];

			$buscaropcionasunto = $historial_estudiante->buscaropcionasunto($casos_estudiante_pqr[$i]["id_asunto_opcion"]); // busca el asunto
			$opcion = $buscaropcionasunto["opcion"];

			$data[] = array(

				"0" => $asunto,
				"1" => $opcion,
				"2" => $fecha_solicitud,
				"3" => $estado_caso,
				"4" => $opciones
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
	case 'listarcaracterizacionestudiante':
		$id_credencial = $_POST["global_id_credencial"];
		$data[0] = '<h4 class="titulo-2 fs-18 text-semibold"> Seres Originales</h4>';
		$carseres = $historial_estudiante->verificarseres($id_credencial);
		if (isset($carseres["id_carseresoriginales"])) {
			$data[0] .= '
			<table class="table table-hover table-striped">
				<tr>
					<td>Fecha Acepto terminos:</td>
					<td>' . $carseres["fechaaceptodata"] . '</td>
				</tr>
				<tr>
					<td>¿Estás embarazada?:</td>
					<td>' . (($carseres["p1"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Cuántos meses de embarazo tienes?:</td>
					<td>' . $carseres["p2"] . '</td>
				</tr>
				<tr>
					<td>¿Eres desplazado(a) por la violencia?:</td>
					<td>' . (($carseres["p3"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Qué tipo de desplazamiento has experimentado?:</td>
					<td>' . $carseres["p4"] . '</td>
				</tr>
				<tr>
					<td>¿A qué grupo poblacional perteneces?:</td>
					<td>' . $carseres["p5"] . '</td>
				</tr>
				<tr>
					<td>¿Perteneces a la comunidad LGBTIQ+?</td>
					<td>' . (($carseres["p6"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>Perteneces a la comunidad LGBTIQ+</td>
					<td>' . $carseres["p7"] . '</td>
				</tr>
				<tr>
					<td>¿Cuál es el nombre completo de tu primer contacto de emergencia?</td>
					<td>' . $carseres["p8"] . '</td>
				</tr>
				<tr>
					<td>¿Cuál es tu relación o parentesco con esta persona?</td>
					<td>' . $carseres["p9"] . '</td>
				</tr>
				<tr>
					<td>¿Cuál es el correo electrónico de este contacto de emergencia?</td>
					<td>' . $carseres["p10"] . '</td>
				</tr>
				<tr>
					<td>Teléfono del contacto de emergencia</td>
					<td>' . $carseres["p11"] . '</td>
				</tr>
					<tr>
					<td>¿Cuál es el nombre completo de tu segundo contacto de emergencia?</td>
					<td>' . $carseres["p12"] . '</td>
				</tr>
				<tr>
					<td>¿Cuál es tu relación o parentesco con esta persona?</td>
					<td>' . $carseres["p13"] . '</td>
				</tr>
					<tr>
					<td>¿Cuál es el correo electrónico de este contacto de emergencia?</td>
					<td>' . $carseres["p14"] . '</td>
				</tr>
				<tr>
					<td>Teléfono del contacto de emergencia</td>
					<td>' . $carseres["p15"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes un computador o tablet?</td>
					<td>' . $carseres["p16"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes conexión a internet en casa?</td>
					<td>' . $carseres["p17"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes planes de datos en tu celular?</td>
					<td>' . $carseres["p18"] . '</td>
				</tr>
			</table>';
		}

		$data[0] .= '<h4 class="titulo-2 fs-18 text-semibold"> Inspiradores </h4>';
		$carinspiradores = $historial_estudiante->verificar($id_credencial);
		if (isset($carinspiradores["id_casinspiradores"])) {
			$data[0] .= '
			<table class="table table-hover table-striped">
				<tr>
					<td>Fecha Acepto terminos:</td>
					<td>' . $carinspiradores["fechaaceptodata"] . '</td>
				</tr>
				<tr>
					<td>Estado civil</td>
					<td>' . $carinspiradores["ip1"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes hijos?</td>
					<td>' . (($carinspiradores["ip2"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Cuántos hijos tienes?</td>
					<td>' . $carinspiradores["ip3"] . '</td>
				</tr>
				<tr>
					<td>¿Tu padre se encuentra vivo?</td>
					<td>' . (($carinspiradores["ip4"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>Nombre completo de tu padre</td>
					<td>' . $carinspiradores["ip5"] . '</td>
				</tr>
				<tr>
					<td>Teléfono de contacto del padre</td>
					<td>' . $carinspiradores["ip6"] . '</td>
				</tr>
				<tr>
					<td>Nivel educativo de tu padre</td>
					<td>' . $carinspiradores["ip7"] . '</td>
				</tr>
				<tr>
					<td>¿Tu madre se encuentra viva?</td>
					<td>' . (($carinspiradores["ip8"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>Nombre completo de tu madre</td>
					<td>' . $carinspiradores["ip9"] . '</td>
				</tr>
				<tr>
					<td>Teléfono de contacto de la madre</td>
					<td>' . $carinspiradores["ip10"] . '</td>
				</tr>
				<tr>
					<td>Nivel educativo de tu madre</td>
					<td>' . $carinspiradores["ip11"] . '</td>
				</tr>
				<tr>
					<td>¿En qué industria o sector trabajan tus padres?</td>
					<td>' . $carinspiradores["ip13"] . '</td>
				</tr>
				<tr>
					<td>¿Qué cursos o diplomados de interés para tus padres?</td>
					<td>' . $carinspiradores["ip14"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes pareja actualmente?</td>
					<td>' . (($carinspiradores["ip15"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Nombre de tu pareja?</td>
					<td>' . $carinspiradores["ip16"] . '</td>
				</tr>
				<tr>
					<td>¿Número de celular de tu pareja?</td>
					<td>' . $carinspiradores["ip17"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes hermanos?</td>
					<td>' . (($carinspiradores["ip18"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Cuántos hermanos tienes?</td>
					<td>' . $carinspiradores["ip19"] . '</td>
				</tr>
				<tr>
					<td>¿En qué rango de edad se encuentran tus hermanos?</td>
					<td>' . $carinspiradores["ip20"] . '</td>
				</tr>
				<tr>
					<td>¿Con quién vive?</td>
					<td>' . $carinspiradores["ip21"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes personas a tu cargo?</td>
					<td>' . (($carinspiradores["ip22"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Cuántas personas tienes a tu cargo?</td>
					<td>' . $carinspiradores["ip23"] . '</td>
				</tr>
					<tr>
					<td>¿Quién es la persona que te inspiró a estudiar?</td>
					<td>' . $carinspiradores["ip24"] . '</td>
				</tr>
				<tr>
					<td>¿Cuál es el nombre de tu inspirador?</td>
					<td>' . $carinspiradores["ip25"] . '</td>
				</tr>
				<tr>
					<td>WhatsApp del inspirador</td>
					<td>' . $carinspiradores["ip26"] . '</td>
				</tr>
				<tr>
					<td>Correo electrónico del inspirador</td>
					<td>' . $carinspiradores["ip27"] . '</td>
				</tr>
				<tr>
					<td>¿Nivel de formación de tu inspirador?</td>
					<td>' . $carinspiradores["ip28"] . '</td>
				</tr>
				<tr>
					<td>¿Cuál es la situación laboral actual de tu inspirador?</td>
					<td>' . $carinspiradores["ip29"] . '</td>
				</tr>
				<tr>
					<td>¿En qué industria o sector trabaja tu inspirador?</td>
					<td>' . $carinspiradores["ip30"] . '</td>
				</tr>
				<tr>
					<td>¿Qué cursos o diplomados de interés para tu inspirador?</td>
					<td>' . $carinspiradores["ip31"] . '</td>
				</tr>
			</table>';
		}
		$data[0] .= '<h4 class="titulo-2 fs-18 text-semibold"> Empresas Amigas </h4>';
		$carempresas = $historial_estudiante->verificarempresas($id_credencial);
		if (isset($carempresas["id_carempresas"])) {
			$data[0] .= '
			<table class="table table-hover table-striped">
				<tr>
					<td>Fecha Acepto terminos:</td>
					<td>' . $carempresas["fechaaceptodata"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes personas a tu cargo?</td>
					<td>' . (($carempresas["ep1"] == 1) ? "No" : "Si") . '</td>
				</tr>
					<tr>
					<td>¿Nombre de la empresa en la que trabajas ?</td>
					<td>' . $carempresas["ep2"] . '</td>
				</tr>
					<tr>
					<td>¿Tipo de sector de la empresa en la que trabajas?</td>
					<td>' . $carempresas["ep3"] . '</td>
				</tr>
					<tr>
					<td>¿Dirección de la empresa donde trabaja?</td>
					<td>' . $carempresas["ep4"] . '</td>
				</tr>
					<tr>
					<td>¿Teléfono de la empresa donde trabaja?</td>
					<td>' . $carempresas["ep5"] . '</td>
				</tr>
					<tr>
					<td>¿Jornada laboral?</td>
					<td>' . $carempresas["ep6"] . '</td>
				</tr>
					<tr>
					<td>¿Qué incentivos genera tu empresa para tu proceso de formación?</td>
					<td>' . $carempresas["ep7"] . '</td>
				</tr>
				<tr>
					<td>¿Alguien de tu trabajo actual o anteriores, te inspiró a estudiar?</td>
					<td>' . (($carempresas["ep8"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Nombre completo ?</td>
					<td>' . $carempresas["ep9"] . '</td>
				</tr>
				<tr>
					<td>¿Teléfono de contacto?</td>
					<td>' . $carempresas["ep10"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes una empresa legalmente constituida?</td>
					<td>' . (($carempresas["ep11"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Nombre y razón social de la empresa?</td>
					<td>' . $carempresas["ep12"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes una idea de negocio o emprendimiento?</td>
					<td>' . (($carempresas["ep13"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Nombre de la empresa, emprendimiento o idea de negocio?</td>
					<td>' . $carempresas["ep14"] . '</td>
				</tr>
				<tr>
					<td>¿Sector de la empresa, emprendimiento o idea de negocio?/td>
				<td>' . $carempresas["ep15"] . '</td>
				</tr>
				<tr>
					<td>¿Cuál fue tu principal motivación para emprender?/td>
					<td>' . $carempresas["ep16"] . '</td>
				</tr>
					<tr>
					<td>¿Qué recursos o apoyo necesitarías para desarrollar tu emprendimiento?</td>
				<td>' . $carempresas["ep17"] . '</td>
				</tr>
					<tr>
					<td>¿Has realizado algún curso o capacitación relacionada con emprendimiento?</td>
					<td>' . (($carempresas["ep18"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Cuál curso o capacitación?</td>
				<td>' . $carempresas["ep19"] . '</td>
				</tr>
			</table>';
		}
		$data[0] .= '<h4 class="titulo-2 fs-18 text-semibold">Confiamos</h4>';
		$carconfiamos = $historial_estudiante->verificarconfiamos($id_credencial);
		if (isset($carconfiamos["id_carconfiamos"])) {
			$data[0] .= '
			<table class="table table-hover table-striped">
				<tr>
					<td>Fecha Acepto terminos:</td>
					<td>' . $carconfiamos["fechaaceptodata"] . '</td>
				</tr>
				<tr>
					<td>¿Cuáles son tus ingresos mensuales? (en pesos colombianos)</td>
				<td>' . $carconfiamos["cop1"] . '</td>
				</tr>
				<tr>
					<td>¿Quién paga tu matrícula?</td>
				<td>' . $carconfiamos["cop2"] . '</td>
				</tr>
				<tr>
					<td>¿Cuentas con algún apoyo financiero?</td>
				<td>' . $carconfiamos["cop3"] . '</td>
				</tr>
				<tr>
					<td>¿En la actualidad recibes prima y/o cesantías?</td>
				<td>' . $carconfiamos["cop4"] . '</td>
				</tr>
					<tr>
					<td>¿Cuentas con obligaciones financieras?</td>
					<td>' . (($carconfiamos["cop5"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿De qué tipo?</td>
				<td>' . $carconfiamos["cop6"] . '</td>
				</tr>
			</table>';
		}

		$data[0] .= '<h4 class="titulo-2 fs-18 text-semibold">Experiencia Académica</h4>';
		$carexp = $historial_estudiante->verificarexp($id_credencial);
		if (isset($carexp["id_carexperiencia"])) {
			$data[0] .= '
			<table class="table table-hover table-striped">
				<tr>
					<td>Fecha Acepto terminos:</td>
					<td>' . $carexp["fechaaceptodata"] . '</td>
				</tr>
				<tr>
					<td>¿Qué te motivó a estudiar?</td>
				<td>' . $carexp["eap1"] . '</td>
				</tr>
					<tr>
					<td>¿Cómo te enteraste de CIAF?</td>
				<td>' . $carexp["eap2"] . '</td>
				</tr>
					<tr>
					<td>¿Cuál de las siguientes áreas es de tu preferencia?</td>
				<td>' . $carexp["eap3"] . '</td>
				</tr>
					<tr>
					<td>¿Cuál de las siguientes áreas es de tu preferencia?</td>
				<td>' . $carexp["eap4"] . '</td>
				</tr>
					<tr>
					<td>¿Te gustaría realizar una doble titulación en nuestros programas?</td>
					<td>' . (($carexp["eap5"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Qué programa te interesaría?</td>
				<td>' . $carexp["eap6"] . '</td>
				</tr>
					<tr>
					<td>¿Dominas un segundo idioma?</td>
					<td>' . (($carexp["eap7"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Qué idioma?</td>
				<td>' . $carexp["eap8"] . '</td>
				</tr>
				<tr>
					<td>¿En qué nivel te encuentras?</td>
				<td>' . $carexp["eap9"] . '</td>
				</tr>
				<tr>
					<td>¿Cuál es el nombre completo de tu segundo contacto de emergencia?</td>
				<td>' . $carexp["eap10"] . '</td>
				</tr>
			</table>';
		}

		$data[0] .= '<h4 class="titulo-2 fs-18 text-semibold">modelo de bienestar</h4>';
		$carbienestar = $historial_estudiante->verificarbienestar($id_credencial);
		if (isset($carbienestar["id_carbinestar"])) {
			$data[0] .= '
				<table class="table table-hover table-striped">
					<tr>
						<td>Fecha Acepto terminos:</td>
						<td>' . $carbienestar["fechaaceptodata"] . '</td>
					</tr>
					<tr>
					<td>¿Tienes alguna enfermedad física?</td>
					<td>' . (($carbienestar["bp1"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Qué enfermedad física?</td>
				<td>' . $carbienestar["bp2"] . '</td>
				</tr>
				<tr>
					<td>¿Recibes algún tratamiento para esta enfermedad que padeces?</td>
				<td>' . $carbienestar["bp3"] . '</td>
				</tr>
				<tr>
					<td>¿Has sido diagnosticado con algún trastorno mental?</td>
					<td>' . (($carbienestar["bp4"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿Qué trastorno mental?</td>
				<td>' . $carbienestar["bp5"] . '</td>
				</tr>
				<tr>
					<td>¿Recibes algún tratamiento para esta enfermedad que padeces?</td>
				<td>' . $carbienestar["bp6"] . '</td>
				</tr>
				<tr>
					<td>¿Hay algún aspecto específico que desees compartir sobre tu bienestar emocional o psicológico?</td>
				<td>' . $carbienestar["bp7"] . '</td>
				</tr>
				<tr>
					<td>¿A cuál EPS está afiliado actualmente?</td>
				<td>' . $carbienestar["bp8"] . '</td>
				</tr>
				<tr>
					<td>¿Consumes algún medicamento de manera permanente?</td>
					<td>' . (($carbienestar["bp9"] == 1) ? "No" : "Si") . '</td>
				</tr>
					<tr>
					<td>¿Qué medicamentos?</td>
				<td>' . $carbienestar["bp10"] . '</td>
				</tr>
				<tr>
					<td>¿Tienes alguna habilidad especial o talento que te gustaría mencionar?</td>
					<td>' . (($carbienestar["bp11"] == 1) ? "No" : "Si") . '</td>
				</tr>
					<tr>
					<td>¿Cual habilidad?</td>
				<td>' . $carbienestar["bp12"] . '</td>
				</tr>
					<tr>
					<td>¿Participas en actividades extracurriculares relacionadas con tus habilidades o talentos?</td>
				<td>' . $carbienestar["bp13"] . '</td>
				</tr>
					<tr>
					<td>¿Has recibido algún tipo de reconocimiento o premio por tus habilidades o talentos?</td>
				<td>' . $carbienestar["bp14"] . '</td>
				</tr>
				<tr>
					<td>¿Cómo integras tus habilidades o talentos en tu vida universitaria y cotidiana?</td>
				<td>' . $carbienestar["bp15"] . '</td>
				</tr>
				<tr>
					<td>¿Cuáles son las actividades de tu interés?</td>
				<td>' . $carbienestar["bp16"] . '</td>
				</tr>
				<tr>
					<td>¿Pertenece a algún tipo de voluntariado?</td>
					<td>' . (($carbienestar["bp17"] == 1) ? "No" : "Si") . '</td>
				</tr>
				<tr>
					<td>¿cuál voluntariado?</td>
				<td>' . $carbienestar["bp18"] . '</td>
				</tr>
				<tr>
					<td>¿Desearía participar en CIAF cómo?</td>
				<td>' . $carbienestar["bp19"] . '</td>
				</tr>
				<tr>
					<td>¿Seleccione los temas de tu interés?</td>
				<td>' . $carbienestar["bp20"] . '</td>
				</tr>
				<tr>
					<td>¿Música de tu preferencia?</td>
				<td>' . $carbienestar["bp21"] . '</td>
				</tr>
				<tr>
					<td>¿Qué habilidades o talentos te gustaría desarrollar durante tu tiempo en la universidad?</td>
				<td>' . $carbienestar["bp22"] . '</td>
				</tr>
				<tr>
					<td>¿Cuál es tu deporte de interés?</td>
				<td>' . $carbienestar["bp23"] . '</td>
				</tr>
				</table>';
		}
		echo json_encode($data);
		// $data["0"] ="";
		// $results = array($data);
		// echo json_encode($results);
		break;
	case 'listaDatos':
		$id_credencial = $_GET["id_credencial"];
		$datos = $historial_estudiante->listaDatos($id_credencial);
		$data = array();
		for ($i = 0; $i < count($datos); $i++) {
			$id_estudiante = $datos[$i]["id_estudiante"];

			$nombre1 = $datos[$i]["credencial_nombre"];
			$nombre2 = $datos[$i]["credencial_nombre_2"];
			$apellido1 = $datos[$i]["credencial_apellido"];
			$apellido2 = $datos[$i]["credencial_apellido_2"];
			$nombre_completo = $nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2;

			$genero = $datos[$i]["genero"];
			$fecha_nacimiento = $datos[$i]["fecha_nacimiento"];
			$departamento_nacimiento = $datos[$i]["departamento_nacimiento"];
			$lugar_nacimiento = $datos[$i]["lugar_nacimiento"];
			$depar_residencia = $datos[$i]["depar_residencia"];
			$muni_residencia = $datos[$i]["muni_residencia"];
			$direccion = $datos[$i]["direccion"];
			$barrio = $datos[$i]["barrio"];
			$estrato = $datos[$i]["estrato"];
			$telefono = $datos[$i]["telefono"];
			$celular = $datos[$i]["celular"];
			$grupo_etnico = $datos[$i]["grupo_etnico"];
			$nombre_etnico = $datos[$i]["nombre_etnico"];
			$tipo_sangre = $datos[$i]["tipo_sangre"];
			$instagram = $datos[$i]["instagram"];
			$email = $datos[$i]["email"];

			$data[] = array(
				"0" => $nombre_completo,
				"1" => $genero,
				"2" => $fecha_nacimiento,
				"3" => $departamento_nacimiento,
				"4" => $lugar_nacimiento,
				"5" => $depar_residencia,
				"6" => $muni_residencia,
				"7" => $direccion,
				"8" => $barrio,
				"9" => $estrato,
				"10" => $telefono,
				"11" => $celular,
				"12" => $grupo_etnico,
				"13" => $nombre_etnico,
				"14" => $tipo_sangre,
				"15" => $instagram,
				"16" => $email,


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

	case 'cambiarEstadoCiafi':
		$estado_ciafi = isset($_POST["estado_ciafi"]) ? $_POST["estado_ciafi"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
		$consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : "";
		$rsta = $historial_estudiante->cambiarEstadoCiafi((($estado_ciafi == 0) ? 1 : 0), $consecutivo);
		if ($rsta) {
			$id_usuario = $_SESSION['id_usuario'];
			$array = array("exito" => 1, "info" => "Cambio realizado con exito");
			$crearregistro = $historial_estudiante->crearRegistro($consecutivo, $id_usuario);
		} else {
			$array = array("exito" => 0, "info" => "Error al realizar el cambio");
		}
		echo json_encode($array);
		break;
	//traemos dinamicamente los años
	case "selectlistaranios":
		$rspta = $historial_estudiante->selectlistaranios();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_anio"] . "'>" . $rspta[$i]["anio"] . "</option>";
		}
		break;

case 'influencer_caso':
    $id_credencial = isset($_GET['global_id_credencial']) ? $_GET['global_id_credencial'] : 0;

    $color_nivel_accion = array(
        "Positiva" => "text-success",
        "Media"    => "text-warning",
        "Alta"     => "text-danger",
        "Neutra"   => "text-secondary"
    );

    $texto_nivel_accion = array(
        "Positiva" => "Positiva",
        "Media"    => "Atención Suave",
        "Alta"     => "Ruta Inmediata",
        "Neutra"   => "Sin Nivel"
    );

    $registros = $historial_estudiante->Listar_influencer_estudiante($id_credencial);

    $data = array();
    foreach ($registros as $row) {
        $influencer_nivel_accion = (empty($row['influencer_nivel_accion'])) ? "Neutra" : $row['influencer_nivel_accion'];

        // Fecha + hora en una sola variable
        $fecha_completa = $historial_estudiante->fechaesp($row['fecha']) . " " . date("g:i A", strtotime($row['hora']));

        $influencer_dimension = isset($row['influencer_dimension']) ? $row['influencer_dimension'] : '';
		$responsable = isset($row['area_responsable']) ? $row['area_responsable'] : '';
		
 $id_influencer_reporte = isset($row['id_influencer_reporte']) ? $row['id_influencer_reporte'] : 0;
		$rspta_reporte = $historial_estudiante->respuestasReporteInfluencer($id_influencer_reporte);
            $con_respuesta = count($rspta_reporte);

        // Mensaje con tooltip y texto reducido con ellipsis
        $mensaje = isset($row['influencer_mensaje']) ? $row['influencer_mensaje'] : '';
        $mensaje_html = '<div class="expandir_texto" 
                            data-toggle="tooltip" 
                            data-html="true" 
                            title="' . htmlspecialchars($mensaje) . '" 
                            style="max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; cursor:pointer;">'
                            . $mensaje . 
                        '</div>';

        // Nombre completo del docente
        $docente = trim(
            $row['usuario_nombre'] . " " .
            $row['usuario_nombre_2'] . " " .
            $row['usuario_apellido'] . " " .
            $row['usuario_apellido_2']
        );

        $reporte_estado = isset($row['reporte_estado']) ? $row['reporte_estado'] : 0;

        $data[] = array(
            "0" => $fecha_completa, // Fecha y hora juntas
            "1" => $mensaje_html,   // Mensaje con tooltip reducido
            "2" => '<span class="' . $color_nivel_accion[$influencer_nivel_accion] . '"><i class="fas fa-circle"></i> ' . $texto_nivel_accion[$influencer_nivel_accion] . '</span>', // Nivel acción
            "3" => $influencer_dimension, // Dimensión
            "4" => $docente,              // Docente
            "5" => $row['periodo'],       // Periodo
            "6" => ($reporte_estado == 0) 
                      ? '<span class="badge bg-info">Cerrado</span>' 
                      : '<span class="badge bg-warning">Abierto</span>' ,
				"7" => $responsable,	  // Estado
				"8" => ($con_respuesta == 0) ? '<span class="badge bg-secondary">Sin Respuesta</span>' : '<span class="badge bg-success">Con Respuesta</span>', // Respuestas
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

case "selectPrograma":
		$rspta = $historial_estudiante->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectJornada":
		$rspta = $historial_estudiante->selectJornada();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectTipoDocumento":
		$rspta = $historial_estudiante->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectNivelEscolaridad":
		$rspta = $historial_estudiante->selectNivelEscolaridad();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case 'editarPerfil':
		$registrovalido = $historial_estudiante->verFormularioEstudiante($id_estudiante);
		$formulario = $registrovalido["formulario"];
		if ($formulario == 1) { // si el formulario no se ha validado puede actualizar perfil
			$rspta = $historial_estudiante->editarPerfil($id_estudiante, $fo_programa, $jornada_e, $tipo_documento, $nombre, $nombre_2, $apellidos, $apellidos_2, $celular, $email, $nivel_escolaridad, $nombre_colegio, $fecha_graduacion);
			echo $rspta ? "1" : "2";
		} else {
			echo $formulario;
		}
		break;

case 'perfilEstudiante':
		$id_estudiante = $_POST["id_estudiante"];
		$rspta = $historial_estudiante->perfilEstudiante($id_estudiante);
		echo json_encode($rspta);
		break;
}