<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/DocenteGruposAnterior.php";
require("../public/mail/sendSolicitud.php");
require("../public/mail/templateComunicadoDocente.php");
require("../public/mail/sendMailFalta.php");
require("../public/mail/templateInfluencer.php");
require("../mail/aviso_director_falta.php");
$docentegrupos = new DocenteGruposAnterior();
$id_docente = $_SESSION['id_usuario'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$rsptaperiodo = $docentegrupos->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
/* reporte influencer */
$id_estudiante_in = isset($_POST["id_estudiante_in"]) ? limpiarCadena($_POST["id_estudiante_in"]) : "";
$id_docente_in = isset($_POST["id_docente_in"]) ? limpiarCadena($_POST["id_docente_in"]) : "";
$id_programa_in = isset($_POST["id_programa_in"]) ? limpiarCadena($_POST["id_programa_in"]) : "";
$id_materia_in = isset($_POST["id_materia_in"]) ? limpiarCadena($_POST["id_materia_in"]) : "";
$influencer_mensaje = isset($_POST["influencer_mensaje"]) ? limpiarCadena($_POST["influencer_mensaje"]) : "";
switch ($_GET["op"]) {
	case 'listarMotivos': //Listar motivo de casos
		$rsta = $docentegrupos->listarMotivos();
		$data = array();
		$motivo = array();
		if (empty($rsta)) {
			$data = array(
				'exito' => '0',
				'info' => 'Revisa, no se encontraron datos.'
			);
		} else {
			//print_r($rsta);
			for ($i = 0; $i < count($rsta); $i++) {
				$motivo[] = array($rsta[$i]["motivo"]);
			}
			$data = array(
				'exito' => '1',
				'info' => $motivo
			);
		}
		echo json_encode($data);
		break;
	case 'listargrupos':
		$rspta = $docentegrupos->listargrupos($id_docente);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			// consuta pra traer los datos de la materia
			$datosmateriaciafi = $docentegrupos->materiaDatos($reg[$i]["id_materia"]); 
			// nombre de la materia
			$nombreMateria = $datosmateriaciafi["nombre"]; 
			// contiene el ciclo del programa
			$id_docente_grupo = $reg[$i]["id_docente_grupo"];
			// contiene el ciclo del programa
			$ciclo = $reg[$i]["ciclo"];
			// contiene la materia
			$materia = $nombreMateria;
			// contiene el id del programa
			$id_programa = $reg[$i]["id_programa"];
			// contiene la variable del grupo
			$grupo = $reg[$i]["grupo"];
			// consulta para traer el nombre del programa
			$rsptaprograma = $docentegrupos->programaacademico($id_programa);
			// contiene el nombre de la jornada
			$jornada = $reg[$i]["jornada"];
			// consulta para traer el nombre del programa
			$rsptajornada = $docentegrupos->jornada($jornada);
			// consulta para traer el formato de la hora
			$hora = $reg[$i]["hora"];
			$rsptahora = $docentegrupos->horasFormato($hora);
			// consulta para traer el formato de hasta
			$hasta = $reg[$i]["hasta"];
			$rsptahasta = $docentegrupos->horasFormato($hasta);
			//datos en array
			// <a href="peadocente.php?id=' . $reg[$i]["id_docente_grupo"] . '" class="btn btn-danger btn-xs">Gestión PEA </a>
			$tienepeaasignatura = $docentegrupos->tienepea($reg[$i]["id_materia"]); // consulta para saber si tiene PEA la asignatura
			$tienepeaasignaturaresultado = $tienepeaasignatura ? 'si' : 'no';
			if ($tienepeaasignaturaresultado == 'si') {
				$id_pea = $tienepeaasignatura["id_pea"]; // id pea de la tabla PEA
				$tienepeadocente = $docentegrupos->tienepeadocente($reg[$i]["id_docente_grupo"], $periodo_anterior); // consulta para saber si el docente ya activo el PEA
				$tienepeadocenteresultado = $tienepeadocente ? 'si' : 'no';
				if ($tienepeadocenteresultado == "si") {
					$pea = '<a href="peadocente.php?id=' . $reg[$i]["id_docente_grupo"] . '" class="badge badge-primary pointer text-white" id="b-paso9">Gestión PEA </a>';
				} else {
					$pea = '<a onclick="activarPea(' . $reg[$i]["id_docente_grupo"] . ',' . $id_pea . ')" class="badge badge-danger pointer text-white" title="Activar el plan educativo de aula" id="b-paso9">Activar PEA </a>';
				}
			} else {
				$pea = ""; // o tiene pea desde la dirección
			}
			$pea = '<a href="peadocente.php?id=' . $reg[$i]["id_docente_grupo"] . '" class="btn btn-primary btn-xs text-sm pointer text-white" id="b-paso9" style="font-size: .75rem !important;">Gestión PEA </a>';

			$data[] = array(
				"0" => ' <span class="badge"> G-' . $reg[$i]["grupo"] . '</span> ' . $rsptaprograma["nombre"],
				"1" => $materia,
				"2" => $reg[$i]["jornada"],
				"3" => $reg[$i]["semestre"],
				"4" => $reg[$i]["dia"] . ' De ' . $rsptahora["formato"] . ' Hasta ' . $rsptahasta["formato"] . '- Corte' . $reg[$i]["corte"],
				"5" => $reg[$i]["salon"],
				"6" => '<div class="btn-group">
							<button onclick="listar(' . $id_docente_grupo . ')" class="btn btn-success btn-xs text-sm pointer text-white" title="Ver listado de grupo" id="b-paso8" style="font-size: .75rem !important;">Listar Grupo</button>
							' . $pea . '
						</div>'
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


	case 'listar':
		//dias de la semana en array
		$dias = array("Domingo" => 0, "Lunes" => 1, "Martes" => 2, "Miercoles" => 3, "Jueves" => 4, "Viernes" => 5, "Sabado" => 6);
		$data = array();
		$data["datos1"] = "";
		$data["datos2"] = "";
		//docente enviado por post
		$id_docente_grupo = $_GET["id_docente_grupo"];
		//listar todos los grupos que 
		$listarelgrupo = $docentegrupos->listarelgrupo($id_docente_grupo);
		// para saber a que tabla consultar
		$ciclo = $listarelgrupo["ciclo"];
		// materia docente
		$id_materia = $listarelgrupo["id_materia"];
		// jornada de la materia
		$jornada = $listarelgrupo["jornada"];
		// programa de la materia
		$id_programa = $listarelgrupo["id_programa"];
		// grupo del programa de la materia
		$grupo = $listarelgrupo["grupo"];
		// semestre del programa de la materia
		$semestre = $listarelgrupo["semestre"];
		//dia  de la semana en que ser da la clase
		$dia_de_la_clase = $listarelgrupo["dia"];
		// convertimos el dia de la clase a numero
		$dia_de_la_clase = $dias[$dia_de_la_clase];
		//numero del dia de hoy
		$numero_hoy = date('w');
		//con la variables recolectadas, listamos los estudiantes
		$datosmateriaciafi = $docentegrupos->materiaDatos($id_materia); 
		// consuta pra traer los datos de la materia
		$materia = $datosmateriaciafi["nombre"]; // nombre de la materia
		//agregamos a la lista de docentes los estudiantes que estan en homologación  
		$reg = $docentegrupos->listar($ciclo, $materia, $jornada, $id_programa, $grupo);
		//trae los estudioantes de otros programas agregados al grupo
		$registros_especiales = $docentegrupos->listarEspeciales($id_docente_grupo);
		
		// Iteramos por cada uno de los estudiantes dependiendo de
		for ($x = 0; $x < count($registros_especiales); $x++) {
			$ciclo_matriculado = $registros_especiales[$x]["ciclo_matriculado"];
			$id_estudiante_especial = $registros_especiales[$x]["id_estudiante"];
			$estudiantes = $docentegrupos->listarGruposEspeciales($id_docente_grupo, $ciclo_matriculado, $id_estudiante_especial);
			$reg = array_merge($reg, $estudiantes);
		}
		$estado = "";
		$rspta2 = $docentegrupos->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$nombre_programa = $rspta2["nombre"];
		$inicio_cortes = 1;
		$data["datos2"] .= '<div class="line-height-16 pt-2"><span class="line-height-16">' . $nombre_programa . '</span><p class="line-height-16 titulo-2 fs-14">' . $materia . '</p></div>';
		$data["datos1"] .= '<div class="row d-flex justify-content-end pl-2">';
		$data["datos1"] .= '
			<div class="col-xl-auto col-lg-auto col-md-auto col-12 tono-3 py-2 m-xl-2 m-lg-2 m-md-2 m-1 pointer" onClick="enviarCorreos(`' . $ciclo . '`, `' . $jornada . '`, `' . trim($id_programa) . '`, `' . $grupo . '`)" class="" data-toggle="modal" data-target="#modalEmail" id="t2-paso13">
				<div class="row align-items-center " >
					<div class="pl-2">
						<span class="rounded bg-light-red p-2 text-danger ">
							<i class="fas fa-envelope-square"></i>
						</span> 
					</div>
					<div class="px-2 line-height-18">
						<span class="">Enviar</span> <br>
						<span class="titulo-2 text-semibold fs-16 line-height-16">Mensaje</span> 
					</div>
				</div>
			</div>
			<div class="col-xl-auto col-lg-auto col-md-auto col-12 tono-3 py-2 m-xl-2 m-lg-2 m-md-2 m-1 pointer" onClick="consultaContacto(`' . $ciclo . '`,`' . $jornada . '`,`' . trim($id_programa) . '`,`' . $grupo . '`,`' . $materia . '`)" id="t2-paso14"> 
				<div class="row align-items-center d-inline-flex">
					<div class="pl-2">
						<span class="rounded bg-light-green p-2 text-success">
							<i class="fas fa-envelope-square"></i>
						</span> 
					</div>
					<div class="px-2 line-height-18">
						<span class="">Datos</span> <br>
						<span class="titulo-2 text-semibold fs-16 line-height-16">Contacto</span> 
					</div>
				</div>
			</div>
			<div class="col-xl-auto col-lg-auto col-md-auto col-12 tono-3 py-2 m-xl-2 m-lg-2 m-md-2 m-1 pointer" onclick="consultaReporteFinal(' . $id_docente . ', ' . $ciclo . ', `' . $materia . '`, `' . $jornada . '`, ' . trim($id_programa) . ', ' . $grupo . ', ' . $semestre . ')" data-toggle="modal" data-target="#modalReporteFinal" id="t2-paso15">
				<div class="row align-items-center d-inline-flex">
					<div class="pl-2">
						<span class="rounded bg-light-orange p-2 text-orange">
							<i class="fa-solid fa-print"></i>
						</span> 
					</div>
					<div class="px-2 line-height-18">
						<span class="">Reporte</span> <br>
						<span class="titulo-2 text-semibold fs-16 line-height-16">Final</span> 
					</div>
				</div>
			</div>'
		;
		$data["datos1"] .= '<div class="col-12" id="t2-paso16"><a onClick="volver()" id="volver" class="btn btn-info text-white py-2" title="Volver atrás" ><i class="fas fa-arrow-circle-left" ></i> Volver</a></div>';
		$data["datos1"] .= '</div>';
		$data["datos1"] .= '
		<div class="col-12 table-responsive">
			<table id="example" class="table table-hover table-sm" style="width:100%">
				<thead>
					<tr>
						<th id="t2-paso1">Opciones</th>
						<th id="t2-paso6">Identificación</th>
						<th id="t2-paso7">Foto</th>
						<th id="t2-paso8">Apellidos</th>
						<th id="t2-paso9">Nombres</th>
						<th id="t2-paso10">Faltas</th>';
		while ($inicio_cortes <= $cortes) {
			$data["datos1"] .= '<th id="t2-paso11">C' . $inicio_cortes . '</th>';
			$inicio_cortes++;
		}
		$data["datos1"] .= '
						<th id="t2-paso12">Final</th>
					</tr>
				</thead>
				<tbody>';
		$num_id = 1;
		for ($i = 0; $i < count($reg); $i++) {
			$rspta3 = $docentegrupos->id_estudiante($reg[$i]["id_estudiante"]);
			$id_credencial = $rspta3["id_credencial"];
			$rspta4 = $docentegrupos->estudiante_datos($id_credencial);
			if (file_exists('../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg')) {
				$foto = '<img src=../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg width=36px height=36px class=rounded-circle>';
			} else {
				$foto = '<img src=../files/null.jpg width=36px height=36px class=rounded-circle>';
			}
			if ($rspta3["estado"] == 1) {
				$estado = "<a class='btn btn-success btn-sm text-white' title='Esta activo' id='t2-paso2'>Si</a>";
			} else {
				$estado = "<a class='btn btn-danger btn-sm text-white' title='Esta activo'>No</a>";
			}
			$carseres=$docentegrupos->verificarseres($id_credencial);
            $data["seres"] = $carseres ? '1' : '0';
            $carinspiradores=$docentegrupos->verificarinspiradores($id_credencial);
            $data["insp"] = $carinspiradores ? '1' : '0';
            $carempresas=$docentegrupos->verificarempresas($id_credencial);
            $data["empresas"] = $carempresas ? '1' : '0';
            $carconfiamos=$docentegrupos->verificarconfiamos($id_credencial);
            $data["confiamos"] = $carconfiamos ? '1' : '0';
            $carexp=$docentegrupos->verificarexp($id_credencial);
            $data["exp"] = $carexp ? '1' : '0';
            $carbienestar=$docentegrupos->verificarbienestar($id_credencial);
            $data["bienestar"] = $carbienestar ? '1' : '0';
            if ($data["seres"] == '1' && $data["insp"] == '1' && $data["empresas"] == '1' && $data["confiamos"] == '1' && $data["exp"] == '1' && $data["bienestar"] == '1'){
				$caracterizado = "<a class='btn btn-success btn-sm text-white' title='Esta caracterizado'>Si</a>";
            }else{
                $caracterizado = "<a class='btn btn-warning btn-sm text-white' title='Esta caracterizado' id='t2-paso3'>No</a>";
            }
			
		
			$boton_psicologia = ($rspta4["psicologia"] == 0) ? '<a class="btn btn-danger btn-sm text-white" title="Caso Especial" id="t2-paso17"><i class="fas fa-asterisk"></i></a>' : '';
		
			$data["datos1"] .= '<tr>
				<td class="" style="width:100px">
					<div class="btn-group">'
				. $estado . ' '
				. $caracterizado . ' '
				. $boton_psicologia . ' 
					<a onclick=horarioEstudiante("' . $reg[$i]["id_estudiante"] . '","' . $reg[$i]["ciclo_estudiante"] . '","' . $reg[$i]["programa"] . '","' . $reg[$i]["grupo"] . '") title="Ver horario de clase" class="btn btn-primary btn-xs text-white" id="t2-paso4">
					<i class="fa-solid fa-calendar fa-1x"></i>
					</a>
					<a onclick=reporteInfluencer("' . $reg[$i]["id_estudiante"] . '","' . $id_docente . '","' . $reg[$i]["programa"]  . '","' . $id_materia . '")
						class="btn bg-purple btn-xs text-white" 
						title="Reporte Influencer" id="t2-paso5">
							<i class="fa-solid fa-comment"></i>
					</a>
				</div>
			</td>
			<td class="ancho-md"><input type="hidden" value="' . $materia . '" id="materia">' .
			$rspta4["credencial_identificacion"] . '
			</td>
			<td class="ancho-sm"><input type="hidden" value="' . $materia . '" id="materia">' .
			$foto . '
			</td>
			<td>' .
			$rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . '
			</td>
			<td>' .
			$rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"] . '
			</td>';
			if($numero_hoy == $dia_de_la_clase){
				$data["datos1"] .= '<td class="text-center ancho-sm ">
					<span class="badge bg-warning">'. $reg[$i]["faltas"] . '</span>
					<div class="btn-group seleccion-falta_' . $rspta4["id_credencial"] . '">
						<button type="button" id="t2-paso18" onclick="marcarAsitio(' . $rspta4["id_credencial"] . ')" class=" tooltips btn btn-sm btn-success pointer" title="Marcar Que Asistió"> <i class="fas fa-check"></i> </button>' .'
						<button onclick="modalFalta(' . $rspta4["id_credencial"] . ',' . $id_docente_grupo . ',' . $ciclo . ',' . $reg[$i]["id_estudiante"] . ',' . $id_programa . ',' . $reg[$i]["id_materia"] . ')" class=" tooltips btn btn-sm btn-danger pointer" title="Reportar una falta"> <i class="fas fa-close"></i> </button>
					</div>	
				</td>';
			}else{
				$data["datos1"] .= '<td class="text-center ancho-sm">
					<span class="badge bg-warning">' . $reg[$i]["faltas"] . '</span>	
				</td>';
			}
		
			$inicio_cortes = 1;
			$corte = $docentegrupos->consultaCorte($id_programa, $id_materia, $id_docente, $reg[$i]["semestre"], $jornada);
			$corte_nota = "";
			while ($inicio_cortes <= $cortes) {
				$corte_nota = "c" . $inicio_cortes;
				$retVal = ($corte[$corte_nota] == "1") ? '<input type="text" value="' . $reg[$i][$corte_nota] . '" onchange="nota(`' . base64_encode($reg[$i]["id_materia"]) . '`, this.value, `' . $corte_nota . '`, `' . $reg[$i]["ciclo_estudiante"] . '`, `' . $reg[$i]["programa"] . '`, `' . $id_docente_grupo . '`)" class="col-xl-12 col-lg-12 col-md-12 col-8 form-control" style="width:70px">' : $reg[$i][$corte_nota];
				$data["datos1"] .= '<td class="ancho-sm" >' . $retVal. '</td>';
				$inicio_cortes++;
			}
			$data["datos1"] .= '	
				<td class="ancho-sm" style="width:80px">' . round($reg[$i]["promedio"], 2) . '</td>';
			$data["datos1"] .= '</tr>';
			$semestre_grupo = $reg[$i]["semestre"];
		}
		if ($ciclo == "11") {
			$homologados = $docentegrupos->listar_homologados($materia, $id_docente_grupo);
			$id_programa_grupo = $id_programa;
			$ciclo_grupo = $ciclo;
			for ($i = 0; $i < count($homologados); $i++) {
				//* aqui sigue el codigo pra los especiales que aparezcan en los listados///
				$id_programa = $homologados[$i]["programa"];
				$huella = $homologados[$i]["huella"];
				$rspta3 = $docentegrupos->id_estudiante($homologados[$i]["id_estudiante"]);
				$id_credencial = $rspta3["id_credencial"];
				$rspta4 = $docentegrupos->estudiante_datos($id_credencial);
				if (file_exists('../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg')) {
					$foto = '<img src=../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg width=40px height=40px class=rounded-circle>';
				} else {
					$foto = '<img src=../files/null.jpg width=40px height=40px class=rounded-circle>';
				}
				if ($rspta3["estado"] == 1) {
					$estado = "<span class='badge badge-success'>Activo</span>";
				} else {
					$estado = "<span class='badge badge-danger'>Inactivo</span>";
				}
				$habeas_carac = $docentegrupos->est_carac_habeas($id_credencial);
				if (empty($habeas_carac)) {
					$caracterizado = "<span class='badge badge-warning'>No</span>";
				} else {
					$caracterizado = "<span class='badge badge-primary'>Si</span>";
				}
				$data["0"] .= '
							<tr>
								<td class="ancho-lg">
									<span title="Estado del estudiante">' . $estado . '</span> | 
									<span title="Esta caracterizado">' . $caracterizado . '</span> |
									<a onclick=horarioEstudiante("' . $homologados[$i]["id_estudiante"] . '","' . $ciclo . '","' . $id_programa . '","' . $grupo . '") title="Ver horario de clase" class="btn btn-primary btn-xs text-white">
										Horario
									</a>
								</td>
								<td class="ancho-md"><input type="hidden" value="' . $materia . '" id="materia">' .$rspta4["credencial_identificacion"] . '</td>
								<td class="ancho-sm"><input type="hidden" value="' . $materia . '" id="materia">' .$foto . '</td>
								<td>' . $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' </td>
								<td>' . $rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"] . '</td>
								<td class="ancho-sm"><button type="button" onclick="modalFalta(' . $rspta4["id_credencial"] . ',' . $id_docente_grupo . ',' . $ciclo . ',' . $homologados[$i]["id_estudiante"] . ',' . $id_programa . ',' . $homologados[$i]["id_materia"] . ')" class="btn btn-warning " title="faltas">' . $homologados[$i]["faltas"] . '</button>
								</td>';
				$inicio_cortes = 1;
				$corte = $docentegrupos->consultaCorte($id_programa_grupo, $id_materia, $id_docente, $semestre_grupo, $jornada);
				$corte_nota = "";
				while ($inicio_cortes <= $cortes) {
					$corte_nota = "c" . $inicio_cortes;
					$retVal = ($corte[$corte_nota] == "1") ? '<input type="text" value="' . $homologados[$i][$corte_nota] . '" onchange="nota(`' . base64_encode($homologados[$i]["id_materia"]) . '`, this.value, `' . $corte_nota . '`, `' . $ciclo . '`, `' . $id_programa . '`, `' . $id_docente_grupo . '`)" class="col-xl-12 col-lg-12 col-md-12 col-8 form-control">' : $homologados[$i][$corte_nota];
					$data["0"] .= '<td class="ancho-sm" >' . $retVal . '</td>';
					$inicio_cortes++;
				}
				$data["0"] .= '	
								<td class="ancho-sm">' . round($homologados[$i]["promedio"], 2) . '</td>
							</tr>';
			}
		}
		/*  hasta aqui los especiales */
		$data["datos1"] .= '
				</tbody>
			</table>
		</div>';
		$results = array($data);
		echo json_encode($results);
		break;



	case 'aggfalta':
		$id_credencial = $_POST['id_credencial'];
		$id_docente_grupo = $_POST['id_docente_grupo'];
		$id_docente = $_SESSION['id_usuario'];
		$ciclo = $_POST['ciclo'];
		$id_estudiante = $_POST['id_estudiante'];
		$id_programa = $_POST['id_programa'];
		$programa = $_POST['programa'];
		$id_materia = $_POST['id_materia'];
		$motivo_falta = $_POST['motivo_falta'];
		$fecha = date("Y-m-d");
		$tabla = "materias" . $ciclo;
		$data['cuantasfaltas'] = 0;
		//echo "$id_credencial ,$id_docente_grupo ,$id_docente ,$ciclo ,$id_estudiante ,$id_programa ,$programa ,$id_materia ,$fecha ,$tabla";
		$buscarsitienefalta = $docentegrupos->buscarsitienefalta($id_estudiante, $id_materia, $id_docente, $fecha);
		$nombremateriafalta = $docentegrupos->buscarnombremateria($tabla, $id_materia);
		$nombre_materia = $nombremateriafalta["nombre_materia"];
		if ($buscarsitienefalta) { //si tiene falta ese dia
			$data['tienefalta'] = 1;
		} else {
			//si no tiene falta ese dia
			$data['tienefalta'] = 0;
			$agregarfaltaenmaterias = $docentegrupos->agregarfaltaenmaterias($tabla, $id_materia);
			$agregarfaltaenfaltas = $docentegrupos->agregarfaltaenfaltas($id_estudiante, $id_materia, $id_docente, $fecha, $ciclo, $id_programa, $nombre_materia, $motivo_falta);
			$correo = $docentegrupos->consultaCorreoCredencial($id_credencial);
			$identificacion = $correo["credencial_identificacion"];
			$nombre = $correo["credencial_apellido"] . ' ' . $correo["credencial_apellido_2"] . ' ' . $correo["credencial_nombre"] . ' ' . $correo["credencial_nombre_2"];
			$destino = $correo["credencial_login"];
			$asunto = $nombre_materia;
			$mensaje = "El docente reporto una falta el día de hoy<br><br>Correo seguro y certificado.";
			error_reporting(0);
			// enviar_correo($destino, $asunto, $mensaje);
			// consulta para mirar cuntas faltas tiene el estudiante en la asignatura que le acaban de colocar la falta
			$consultarfaltas = $docentegrupos->consultarfaltas($tabla, $id_materia);
			$numerofaltas = $consultarfaltas["faltas"];
			/* ******************************************************* */
			if ($numerofaltas >= 3) { // si el numero de faltas es mayor o igual a tres, enviamos un correo al director del programa
				$fecha_formato = $docentegrupos->convertir_fecha($fecha);
				$datos_programa = $docentegrupos->programa($id_programa);
				$nombreprogramaac = $datos_programa["nombre"];
				$escuela = $datos_programa["escuela"];
				$buscarcorreodir = $docentegrupos->buscarcorreodir($escuela); // consulta para traer el corero del director del programa
				$correodir = $buscarcorreodir["usuario_login"];
				$buscarnombredocente = $docentegrupos->datosDocente($id_docente); // consulta para traer el nombre del docente
				$nombredoc = $buscarnombredocente["usuario_apellido"] . ' ' . $buscarnombredocente["usuario_apellido_2"] . ' ' . $buscarnombredocente["usuario_nombre"] . ' ' . $buscarnombredocente["usuario_nombre_2"];
				$asuntodir = "Faltas";
				$mensajedir = set_template($nombreprogramaac, $nombre_materia, $numerofaltas, $motivo_falta, $fecha_formato, $identificacion, $nombre, $nombredoc);
				//enviar_correo($correodir, $asuntodir, $mensajedir);
			}
		}
		$data['id_docente_grupo'] = $id_docente_grupo;
		echo json_encode($data);
		break;
	case 'listarFaltas':
		$id_docente = $_SESSION['id_usuario'];
		$id_estudiante = $_POST['id_estudiante'];
		$id_materia = $_POST['id_materia'];
		$ciclo = $_POST['ciclo'];
		$reg = $docentegrupos->listarFaltas($id_estudiante, $id_materia, $id_docente);
		$data = array();
		$datetime1 = new DateTime(date("Y-m-d H:i:s")); //start time
		for ($i = 0; $i < count($reg); $i++) {
			$datetime2 = new DateTime($reg[$i]["create_dt"]); //end time
			$interval = $datetime1->diff($datetime2);
			$hours = $interval->format('%d');
			//print_r($interval);
			if ($hours < 1) {
				$boton_eliminar = "
					<div class='text-center'>
						<button class='btn btn-danger btn-xs' onclick='eliminarFalta(" . $reg[$i]["id_falta"] . ", $id_estudiante, $id_materia, $ciclo)'> <i class='fas fa-trash'></i> </button>
					</div>	
					";
			} else {
				$boton_eliminar = "<span class='badge badge-info'> No se puede eliminar</span>";
			}
			$data[] = array(
				"0" => $boton_eliminar,
				"1" => $reg[$i]["create_dt"],
				"2" => $reg[$i]["motivo_falta"]
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
	case 'eliminarFalta':
		$falta_id = isset($_POST["falta_id"]) ? $_POST["falta_id"] : die(json_encode(array("status" => 0, "info" => "No ha seleccionado nada")));
		$ciclo = isset($_POST["ciclo"]) ? $_POST["ciclo"] : die(json_encode(array("status" => 0, "info" => "No ha seleccionado nada")));
		$id_materia = isset($_POST["id_materia"]) ? $_POST["id_materia"] : die(json_encode(array("status" => 0, "info" => "Nada seleccionado")));
		$rsptaDoc = $docentegrupos->eliminarFalta($falta_id);
		$tabla = "materias$ciclo";
		if ($rsptaDoc) {
			$docentegrupos->eliminarFaltaenMaterias($tabla, $id_materia);
			$data = array("status" => 1, "info" => "Eliminado satisfactoriamente");
		} else {
			$data = array("s" => 0, "info" => "Error al eliminar");
		}
		echo json_encode($data);
		break;
	case 'consultaContacto':
		$ciclo = $_GET['ciclo'];
		$materia = $_GET['materia'];
		$jornada = $_GET['jornada'];
		$id_programa = $_GET['id_programa'];
		$grupo = $_GET['grupo'];
		$rsptaDoc = $docentegrupos->datosDocente($id_docente);
		$data['docente'] = $rsptaDoc['usuario_nombre'] . ' ' . $rsptaDoc['usuario_nombre_2'] . ' ' . $rsptaDoc['usuario_apellido'] . ' ' . $rsptaDoc['usuario_apellido_2'];
		$listado_homologados = "";
		if ($ciclo == "11") {
			$listado_homologados = $docentegrupos->listarhomolog($ciclo, $materia);
		}
		$listado_normales = $docentegrupos->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo);
		if ($listado_homologados == NULL) {
			$listado = array_merge($listado_normales);
		} else {
			$listado = array_merge($listado_normales, $listado_homologados);
		}
		//Vamos a declarar un array
		$data = array();
		for ($i = 0; $i < count($listado); $i++) {
			$id_estudiante = $listado[$i]["id_estudiante"];
			$buscardatos = $docentegrupos->estudianteDatos($id_estudiante);
			$data[] = array(
				"0" => $buscardatos["credencial_identificacion"],
				"1" => $buscardatos["credencial_apellido"] . ' ' . $buscardatos["credencial_apellido_2"] . ' ' . $buscardatos["credencial_nombre"] . ' ' . $buscardatos["credencial_nombre_2"],
				"2" => $buscardatos["email"],
				"3" => $buscardatos["credencial_login"],
				"4" => $buscardatos["celular"]
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
	case 'consultaContacto2':
		//print_r($id);
		$cantidad = count($id);
		$data['table'] = "";
		$data['table'] .= '
			<table class="table table-hover" id="tbl_listar" style="width:100%">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Email</th><th scope="col">Email CIAF</th><th scope="col">Cel</th>
					</tr>
				</thead>
				<tbody>';
		for ($i = 0; $i < $cantidad; $i++) {
			$datos = $docentegrupos->estudiante_datos_completos($id[$i]['0']);
			//print_r($datos);
			$data['table'] .= '<tr>
					<td>' . $datos['credencial_identificacion'] . '</td>
					<td>' . $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . ' ' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'] . '</td>
					<td>' . $datos['email'] . '</td>
					<td>' . $datos['credencial_login'] . '</td>
					<td>' . $datos['celular'] . '</td>
				</tr>';
		}
		$data['table'] .= '	</tbody></table>';
		$data['materia'] = $materia;
		$data['jornada'] = $jornada;
		$data['fecha'] = date("d/m/Y");
		$progra = $docentegrupos->programaacademico($id_programa);
		$data['programa'] = $progra['nombre'];
		echo json_encode($data);
		break;
	case 'consultaEstudiante':
		$ciclo = $_POST['ciclo'];
		$materia = $_POST['materia'];
		$jornada = $_POST['jornada'];
		$id_programa = $_POST['id_programa'];
		$grupo = $_POST['grupo'];
		$medio = $_POST['medio'];
		$rsptaDoc = $docentegrupos->datosDocente($id_docente);
		$data['docente'] = $rsptaDoc['usuario_nombre'] . ' ' . $rsptaDoc['usuario_nombre_2'] . ' ' . $rsptaDoc['usuario_apellido'] . ' ' . $rsptaDoc['usuario_apellido_2'];
		if ($medio == "1") {
			$id = $docentegrupos->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo, $medio);
			//print_r($id);
			$cantidad = count($id);
			$data['table'] = "";
			$data['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Email</th><th scope="col">Email CIAF</th><th scope="col">Cel</th>
					</tr>
				</thead>
				<tbody>';
			for ($i = 0; $i < $cantidad; $i++) {
				$datos = $docentegrupos->estudiante_datos_completos($id[$i]['0']);
				//print_r($datos);
				$data['table'] .= '<tr>
					<td>' . $datos['credencial_identificacion'] . '</td>
					<td>' . $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . ' ' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'] . '</td>
					<td>' . $datos['email'] . '</td>
					<td>' . $datos['credencial_login'] . '</td>
					<td>' . $datos['celular'] . '</td>
				</tr>';
			}
			$data['table'] .= '	</tbody></table>';
			$data['materia'] = $materia;
			$data['jornada'] = $jornada;
			$data['fecha'] = date("d/m/Y");
			$progra = $docentegrupos->programaacademico($id_programa);
			$data['programa'] = $progra['nombre'];
			echo json_encode($data);
		}
		if ($medio == "2") {
			$id = $docentegrupos->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo, $medio);
			$cantidad = count($id);
			$data['table'] = "";
			$data['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Firma</th><th scope="col">Firma 2</th>
					</tr>
				</thead>
				<tbody>';
			for ($i = 0; $i < $cantidad; $i++) {
				$datos = $docentegrupos->estudiante_datos_completos($id[$i]['0']);
				$data['table'] .= '<tr>
					<td>' . $datos['credencial_identificacion'] . '</td>
					<td>' . $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . ' ' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'] . '</td>
					<td></td>
					<td></td>
				</tr>';
			}
			$data['table'] .= '	</tbody></table>';
			$data['materia'] = $materia;
			$data['jornada'] = $jornada;
			$data['fecha'] = date("d/m/Y");
			$progra = $docentegrupos->programaacademico($id_programa);
			$data['programa'] = $progra['nombre'];
			echo json_encode($data);
		}
		if ($medio == "3") {
			$id = $docentegrupos->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo, $medio);
			$cantidaEstu = count($id);
			$a = 0;
			$e = 0;
			$fechas = "";
			$datos['table'] = "";
			$datos['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Fecha</th>
					</tr>
				</thead>
				<tbody>';
			while ($a < $cantidaEstu) {
				$result = $docentegrupos->consultaInasistencia($id[$a]['0']);
				if (count($result) > 0) {
					$datos['table'] .= "<tr>";
					$fechas = "";
					$i = 0;
					while ($i < count($result)) {
						$fechas .= "Falta N° " . ($i + 1) . " : " . $docentegrupos->convertir_fecha($result[$i]['fecha_falta']) . " \n <br>" . PHP_EOL;
						$i++;
					}
					$datosPerso = $docentegrupos->estudiante_datos_completos($id[$a]['0']);
					$data[] = array(
						"0" => '<td>' . $datosPerso['credencial_identificacion'] . '</td>',
						"1" => '<td>' . $datosPerso['credencial_nombre'] . ' ' . $datosPerso['credencial_nombre_2'] . ' ' . $datosPerso['credencial_apellido'] . ' ' . $datosPerso['credencial_apellido_2'] . '</td>',
						"2" => '<td>' . $fechas . '</td>'
					);
					$datos['table'] .= $data[$e]['0'];
					$datos['table'] .= $data[$e]['1'];
					$datos['table'] .= $data[$e]['2'];
					$e++;
					$datos['table'] .= "</tr>";
				}
				/* $datos['table'] .= '</tbody></table>';*/
				$datos['materia'] = $materia;
				$datos['jornada'] = $jornada;
				$datos['fecha'] = date("d/m/Y");
				$progra = $docentegrupos->programaacademico($id_programa);
				$datos['programa'] = $progra['nombre'];
				$a++;
			}
			echo json_encode($datos);
		}
		break;
	case 'consultaReporteFinal':
		$id_docente = $_POST['id_docente'];
		$ciclo = $_POST['ciclo'];
		$materia = $_POST['materia'];
		$jornada = $_POST['jornada'];
		$id_programa = $_POST['id_programa'];
		$grupo = $_POST['grupo'];
		//Vamos a declarar un array
		$data = array();
		$data["table"] = "";
		$rsptaDoc = $docentegrupos->datosDocente($id_docente);
		$data['docente'] = $rsptaDoc['usuario_nombre'] . ' ' . $rsptaDoc['usuario_nombre_2'] . ' ' . $rsptaDoc['usuario_apellido'] . ' ' . $rsptaDoc['usuario_apellido_2'];
		$listado_homologados = "";
		if ($ciclo == "11") {
			$listado_homologados = $docentegrupos->listarhomolog($ciclo_homologados, $materia);
		}
		$listado_normales = $docentegrupos->listar($ciclo, $materia, $jornada, $id_programa, $grupo);
		if ($listado_homologados == NULL) {
			$rspta = array_merge($listado_normales);
		} else {
			$rspta = array_merge($listado_normales, $listado_homologados);
		}
		$reg = $rspta;
		$estado = "";
		$rspta2 = $docentegrupos->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$inicio_cortes = 1;
		$data['programa'] = $rspta2['nombre']; // variable que sirve para imprimir el programa y utilizarlo en datatable
		$data["table"] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th>
						<th scope="col">Estudiante(Nombre completo)</th>
						<th scope="col">Faltas</th>';
		while ($inicio_cortes <= $cortes) {
			$data["table"] .= '<th>C' . $inicio_cortes . '</th>';
			$inicio_cortes++;
		}
		$data["table"] .= '
						<th>Final</th>
            		</tr>
        		</thead>
        <tbody>';
		$num_id = 1;
		for ($i = 0; $i < count($reg); $i++) {
			$rspta3 = $docentegrupos->id_estudiante($reg[$i]["id_estudiante"]);
			$id_credencial = $rspta3["id_credencial"];
			$rspta4 = $docentegrupos->estudiante_datos($id_credencial);
			if (file_exists('../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg')) {
				$foto = '<img src=../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg width=50px height=50px class=img-circle>';
			} else {
				$foto = '<img src=../files/null.jpg width=50px height=50px class=img-circle>';
			}
			if ($rspta3["estado"] == 1) {
				$estado = "<span class='label label-success'>Activo</span>";
			} else {
				$estado = "<span class='label label-warning'>Inactivo</span>";
			}
			$habeas_carac = $docentegrupos->est_carac_habeas($id_credencial);
			if (empty($habeas_carac)) {
				$caracterizado = "<span class='label bg-orange'>No</span>";
			} else {
				$caracterizado = "<span class='label bg-navy'>Si</span>";
			}
			$data["table"] .= '
			<tr>
				<td>
					<input type="hidden" value="' . $materia . '" id="materia">' .
				$rspta4["credencial_identificacion"] . ' | ' . $estado . ' | ' . $caracterizado . '
				</td>
				<td>' .
				$rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"] . ' ' . $rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . ' ' . '
				</td>
				<td>' . $reg[$i]["faltas"] . '</td>';
			$inicio_cortes = 1;
			$corte = $docentegrupos->consultaCorte($id_programa, $materia, $id_docente, $reg[$i]["semestre"], $jornada);
			$corte_nota = "";
			while ($inicio_cortes <= $cortes) {
				$corte_nota = "c" . $inicio_cortes;
				$data["table"] .= '<td class="col-md-1">' . $reg[$i][$corte_nota] . '</td>';
				$inicio_cortes++;
			}
			$data["table"] .= '	
				<td>' . round($reg[$i]["promedio"], 2) . '</td>	
			</tr>';
		}
		$data["table"] .= '
			</tbody>
    	</table>';
		//$results = array($data);
		echo json_encode($data);
		break;
	case 'enviarCorreos':
		$ciclo = $_POST['ciclo'];
		$materia = $_POST['materia'];
		$jornada = $_POST['jornada'];
		$id_programa = $_POST['id_programa'];
		$grupo = $_POST['grupo'];
		$contenido = $_POST['contenido'];
		$medio = "";
		$id = $docentegrupos->consultaDatosContacto($ciclo, $materia, $jornada, $id_programa, $grupo, $medio);
		$nombreDocente = $_SESSION['usuario_nombre'] . " " . $_SESSION['usuario_apellido'];
		$correoDocente = $_SESSION['usuario_login'];
		//correo enviado al docente para que quede evidencia
		$asunto_docente = "Evidencia Comunicado docente";
		$template_mensaje = set_templateComunicadoDocente($contenido, $nombreDocente);
		$asunto_estudiantes = "Comunicado Docente - " . $nombreDocente;
		enviar_correo($correoDocente, $asunto_docente, $template_mensaje);
		//ciclo para ir enviardo a cada uno de los estudiantes el correo
		for ($i = 0; $i < count($id); $i++) {
			//toma el correo del estudiante
			$correo = $docentegrupos->consultaCorreoEstudiante($id[$i]["id_estudiante"]);
			//mail para los estudiantes
			enviar_correo($correo['credencial_login'], $asunto_estudiantes, $template_mensaje);
		}
		$data['result'] = "ok";
		echo json_encode($data);
		break;
	case 'nota':
		$id_docente = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : die(json_encode(array("status" => "Su sesión ha caducado, actualiza la ventana e inicia sesion.")));
		//id materia
		$id = $_POST['id'];
		//nota asignada por el profe
		$nota = $_POST['nota'];
		//corte 
		$tl = $_POST['tl'];
		//ciclo
		$c = $_POST['c'];
		//programa
		$pro = $_POST['pro'];
		//agregar nota
		$rspta = $docentegrupos->agreganota($id, $nota, $tl, $c, $pro);
		echo json_encode(($rspta) ? array("status" => "ok") : array("status" => "err"));
		/*$consulta_programas = $docentegrupos->consulta_programas($_SESSION['id_usuario']);
		for ($j = 0; $j < count($consulta_programas); $j++) {
			$vernombreestudiante = $docentegrupos->vernombreestudiante($_SESSION['id_usuario']);
			$nombre_estudiante = $vernombreestudiante[$j]["credencial_nombre"] ." ".$vernombreestudiante[$j]["credencial_nombre_2"]." ".$vernombreestudiante[$j]["credencial_apellido"]." ".$vernombreestudiante[$j]["credencial_apellido_2"];
			$correo_electronico = $vernombreestudiante[$j]['credencial_login'];
			echo $correo_electronico;
			$mensaje = set_template($nombre_estudiante, $nota, $c, $pro);
			if(enviar_correo($correo_electronico, "Entrevista CIAF", $mensaje)){
				$inserto = array( "estatus" => 1, "valor" => "Cita Agendada con exito");
				echo json_encode($inserto);     
			}else{
				$inserto = array("estatus" => 1, "valor" => "Error al enviar el correo");
				echo json_encode($inserto);
			}
		} */
		//echo base64_decode($id);
		break;
	case 'programa':
		$id_programa = $_GET["id_programa"]; // variable que contiene el id del programa
		$buscar_programa = $docentegrupos->programa($id_programa); // consulta para buscar el nombre de la materia	
		echo  $buscar_programa["nombre"];
		break;
	case 'iniciarcalendario':
		$id_estudiante = $_GET["id_estudiante"]; // id del estudiante
		$ciclo = $_GET["ciclo"]; // ciclo
		$id_programa = $_GET["id_programa"]; // programa del estudiante
		$grupo = $_GET["grupo"]; // programa del estudiante
		$impresion = "";
		$rspta = $docentegrupos->listarDos($id_estudiante, $ciclo, $grupo);
		$rspta2 = $docentegrupos->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$inicio_cortes = 1;
		$reg = $rspta;
		$impresion .= '[';
		for ($i = 0; $i < count($reg); $i++) {
			$buscaridmateria = $docentegrupos->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
			$idmateriaencontrada = $buscaridmateria["id"];
			$rspta3 = $docentegrupos->docente_grupo($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
			@$id_docente = $rspta3["id_docente"];
			@$id_docente_grupo = $rspta3["id_docente_grupo"];
			@$id_materia = $rspta3["id_materia"];
			@$salon = $rspta3["salon"];
			@$diasemana = $rspta3["dia"];
			@$horainicio = $rspta3["hora"];
			@$horafinal = $rspta3["hasta"];
			@$corte = $rspta3["corte"];
			$datosmateria = $docentegrupos->BuscarDatosAsignatura($id_materia);
			@$nombre_materia = $datosmateria["nombre"];
			if ($id_docente == null) {
				$nombre_docente = "Sin Asignar";
			} else {
				$datosdocente = $docentegrupos->datosDocente($id_docente);
				$nombre_docente = $datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_apellido"];
			}
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
			}
			if ($corte == "1") {
				$color = "#fff";
			} else {
				$color = "#252e53";
			}
			$impresion .= '{"title":"' . $nombre_materia . ' - Salón ' . $salon . ' - doc: ' . $nombre_docente . ' ","daysOfWeek":"' . $dia . '","startTime":"' . $horainicio . '","endTime":"' . $horafinal . '","color":"' . $color . '"}';
			if ($i + 1 < count($reg)) {
				$impresion .= ',';
			}
		}
		$impresion .= ']';
		echo $impresion;
		break;
	case 'horarioestudiante':
		$id = $_POST["id"]; // id del estudiante
		$ciclo = $_POST["ciclo"]; // ciclo
		$id_programa = $_POST["id_programa"]; // programa del estudiante
		$grupo = $_POST["grupo"]; // programa del estudiante
		$rspta = $docentegrupos->listarDos($id, $ciclo, $grupo);
		$rspta2 = $docentegrupos->programaacademico($id_programa);
		$cortes = $rspta2["cortes"];
		$inicio_cortes = 1;
		//Vamos a declarar un array
		$data = array();
		$data["0"] = "";
		$traercredencial = $docentegrupos->id_estudiante($id);
		$credencialestudiante = $traercredencial["id_credencial"];
		$datosestudiante = $docentegrupos->estudiante_datos($credencialestudiante);
		$nombrecompleto = $datosestudiante["credencial_nombre"] . ' ' . $datosestudiante["credencial_nombre_2"];
		$apellidocompleto = $datosestudiante["credencial_apellido"] . ' ' . $datosestudiante["credencial_apellido_2"];
		$data["0"] .= '
		<div class="row">
			<div class="col-xl-8 col-lg-8 col-md-8 col-6 py-3 pl-2 ">
				<div class="row align-items-center pt-2">
				<div class="col-xl-auto col-lg-auto col-md-auto col-2">
					<span class="rounded bg-light-green p-3 text-success ">
						<i class="fa-solid fa-headset" aria-hidden="true"></i>
					</span> 
				</div>
				<div class="col-xl-10 col-lg-10 col-md-10 col-10">
					<span class="fs-14 line-height-18">' . $apellidocompleto . '</span> <br>
					<span class="text-semibold fs-16 titulo-2 line-height-16" id="dato_periodo">' . $nombrecompleto . ' </span> 
				</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-6  pt-3 pr-4 text-right">
				<button onclick=iniciarcalendario("' . $id . '","' . $ciclo . '","' . $id_programa . '","' . $grupo . '") title="Ver horario de clase" class="btn btn-primary btn-xs  text-white">
					Ver calendario
				</button>
			</div>
		</div>';
		$data["0"] .= '
		<div class="col-12 p-4 card">
				<table class="table table-hover" style="width:100%">
					<thead>
						<tr>
							<th>Asignatura</th>
							<th >Docente</th>
							';
		$data["0"] .= '
							<th >Horario</th>
							<th >Faltas</th>
						</tr>
					</thead>
					<tbody class="titulo-2 fs-12 line-height-16">';
		$reg = $rspta;
		$num_id = 1;
		for ($i = 0; $i < count($reg); $i++) {
			$buscaridmateria = $docentegrupos->buscaridmateria($id_programa, $reg[$i]["nombre_materia"]);
			$idmateriaencontrada = $buscaridmateria["id"];
			$rspta3 = $docentegrupos->docente_grupo($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa, $grupo);
			@$id_docente = $rspta3["id_docente"];
			@$id_docente_grupo = $rspta3["id_docente_grupo"];
			@$dia = $rspta3["dia"];
			@$hora = $rspta3["hora"];
			@$hasta = $rspta3["hasta"];
			if ($id_docente == true) { // si existe grupo
				$rspta4 = $docentegrupos->docente_datos($id_docente);
				$nombre_docente = $rspta4["usuario_nombre"] . ' ' . $rspta4["usuario_nombre_2"] . ' <br>' . $rspta4["usuario_apellido"] . ' ' . $rspta4["usuario_apellido_2"];
				$dia_clase = $dia . ' <br> ' . $hora . ' - ' . $hasta;
			} else {
				$nombre_docente = "";
				$dia_clase = "";
			}
			$data["0"] .= '
						<tr>
							<td>
							<span id=' . $num_id . '>
							';
			$data["0"] .= '
							</span>
								<span class="label label-default" title="Créditos">[' . $reg[$i]["creditos"] . ']</span> ' .
				$reg[$i]["nombre_materia"] . '
							</td>
							<td>' . $nombre_docente . '
							</td>';
			$data["0"] .= '	
							<td>' . $dia_clase . '</td>
							<td>' . $reg[$i]["faltas"] . '</td>
						</tr>
						';
			$num_id++;
		}
		$data["0"] .= '
						</tbody>
				</table>
			</div>';
		$results = array($data);
		echo json_encode($results);
		break;
	case 'activarPea':
		$id_docente_grupo = $_POST["id_docente_grupo"];
		$id_pea = $_POST["id_pea"];
		$resutlado = "";
		$activarpea = $docentegrupos->activarpea($id_pea, $id_docente_grupo, $fecha, $hora, $periodo_anterior);
		$activarpearesultado = $activarpea ? 'si' : 'no';
		if ($activarpearesultado == "si") {
			$resultado = 1;
		} else {
			$resultado = 2;
		}
		echo json_encode($resultado);
		break;
	case 'reporteinfluencer':
		$traerdirector = $docentegrupos->programaacademico($id_programa_in);
		$id_director = $traerdirector["programa_director"];
		$traerdatosusuario = $docentegrupos->traerdatosusuario($id_director);
		$correodir = $traerdatosusuario["usuario_login"];
		$traerdatosdocente = $docentegrupos->datosDocente($id_docente_in);
		$nombre_docente = $traerdatosdocente["usuario_nombre"] . ' ' . $traerdatosdocente["usuario_nombre_2"] . ' ' . $traerdatosdocente["usuario_apellido_2"] . ' ' . $traerdatosdocente["usuario_apellido_2"];
		$traerdatosestuidantes = $docentegrupos->estudianteDatos($id_estudiante_in);
		$nombre_estudiante = $traerdatosestuidantes["credencial_nombre"] . ' ' . $traerdatosestuidantes["credencial_nombre_2"] . ' ' . $traerdatosestuidantes["credencial_apellido"]  . ' ' . $traerdatosestuidantes["credencial_apellido_2"];
		$identificacion = $traerdatosestuidantes["credencial_identificacion"];
		$correo = $correodir;
		$asunto = "Influencer";
		$mensaje = set_template_influencer($influencer_mensaje, $nombre_docente, $nombre_estudiante, $identificacion);
		enviar_correo($correo, $asunto, $mensaje);
		$rspta = $docentegrupos->insertarreporteinfluencer($id_estudiante_in, $id_docente_in, $id_programa_in, $id_materia_in, $influencer_mensaje, $fecha, $hora, $periodo_anterior);
		$data["0"] = $rspta ? "ok" : "error";
		$results = array($data);
		echo json_encode($results);
		break;
}
