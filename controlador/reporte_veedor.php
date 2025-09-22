<?php
require_once "../modelos/Reporte_Veedor.php";

require("../public/mail/templateInfluencer.php");
date_default_timezone_set("America/Bogota");
$reporte_veedor = new Reporte_Veedor();
$rsptaperiodo = $reporte_veedor->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$id_estudiante_in = isset($_POST["id_estudiante_in"]) ? limpiarCadena($_POST["id_estudiante_in"]) : "";
$id_docente_in = isset($_POST["id_docente_in"]) ? limpiarCadena($_POST["id_docente_in"]) : "";
$id_programa_in = isset($_POST["id_programa_in"]) ? limpiarCadena($_POST["id_programa_in"]) : "";
$id_materia_in = isset($_POST["id_materia_in"]) ? limpiarCadena($_POST["id_materia_in"]) : "";
$influencer_mensaje = isset($_POST["influencer_mensaje"]) ? limpiarCadena($_POST["influencer_mensaje"]) : "";
$id_credencial_in = isset($_POST["id_credencial_in"]) ? limpiarCadena($_POST["id_credencial_in"]) : "";
switch ($_GET["op"]) {

	case 'listar':
		$id_credencial = $_SESSION['id_usuario'];
		$consutlar_veedor = $reporte_veedor->consutlar_veedor($id_credencial);
		$id_estudiante = $consutlar_veedor["id_estudiante"];
		$id_programa = $consutlar_veedor["id_programa_ac"];
		$rspta2 = $reporte_veedor->programaacademico($id_programa);
		$ciclo = $rspta2["ciclo"];
		$reg = $reporte_veedor->listar($id_estudiante, $ciclo);
		$data = array();
		$data["0"] = "";
		$data["0"] .= '
				<div class="row borde-bottom">
					<div class="col-6 tono-3 pb-4">
						<div class="row align-items-center">
							<div class="pl-4">
								<span class="rounded bg-light-blue p-3 text-primary ">
									<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
								</span> 
							</div>
							<div class="col-10">
								<div class="col-5 fs-14 line-height-18"> 
									<span class="">Horario</span> <br>
									<span class="text-semibold fs-20">de clases</span> 
								</div> 
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 p-4 table-responsive">	
				<table id="tabla_reporte_veedor" class="table table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Asignatura</th>
						<th>Docente</th>
						<th>Acciones</th>
					</tr>
				</thead>
            <tbody>';
			
		for ($i = 0; $i < count($reg); $i++) {
			$nombre_materia = $reg[$i]["nombre_materia"];
			$grupo = $reg[$i]["grupo"];
			$buscaridmateria = $reporte_veedor->buscaridmateria($id_programa, $nombre_materia);
			$idmateriaencontrada = $buscaridmateria["id"];
			$rspta3 = $reporte_veedor->docente_grupo($idmateriaencontrada, $reg[$i]["jornada"], $reg[$i]["periodo"], $reg[$i]["semestre"], $id_programa);
			$resultadorspta3 = $rspta3 ? 1 : 0;
			if ($resultadorspta3 == 1) {
				$id_docente = $rspta3["id_docente"];
				$rspta4 = $reporte_veedor->docente_datos($id_docente);
				$nombredeldocente = $rspta4["usuario_nombre"] . ' ' . $rspta4["usuario_nombre_2"] . ' <br>' . $rspta4["usuario_apellido"] . ' ' . $rspta4["usuario_apellido_2"];
			} else {
				$nombredeldocente = "No asignado";
			}
			$data["0"] .= '
				<tr>
					<td><b>[' . $reg[$i]["creditos"] . ']</b>' . $nombre_materia . '</td>
					<td>' . $nombredeldocente . '</td>
					<td>
					<div class="btn-group">
					<a onclick="listar_estudiantes( ' . $ciclo . ', `' . $nombre_materia . '`, `' . $reg[$i]["jornada"] . '`,' . $id_programa . ' ,' . $grupo . ', '.$id_docente.')" class="badge badge-success pointer text-white" title="Ver listado de grupo" id="b-paso8">Listar Grupo</a>
				
				</div></td>
				</tr>';
				
				
		}
		
		
		

		$data["0"] .= '
            </tbody>
        </table>
    </div>';
	
	
		$results = array($data);
		echo json_encode($results);
		
		break;
		
	case 'listar_estudiantes':

		$ciclo = $_POST["ciclo"];
		$nombre_materia = $_POST["nombre_materia"];
		$jornada = $_POST["jornada"];
		$id_programa = $_POST["id_programa"];
		$grupo = $_POST["grupo"];
		$listar_estudiantes = $reporte_veedor->listar_estudiantes($ciclo, $nombre_materia, $jornada, $id_programa, $grupo);

		
		$data["0"] = "";
		$data["0"] .= '<div class="col-md-6 offset-md-6 pt-2 pb-4">';
$data["0"] .= '<a onClick="volver()" id="volver" class="btn btn-danger text-white py-3 float-right" title="Volver atrás"><i class="fas fa-arrow-circle-left"></i> Volver</a>';
$data["0"] .= '</div>';



		
$data["0"] .= '<div class="col-12 table-responsive">';
$data["0"] .= '<table id="tabla_listar_estudiantes" class="table table-hover" style="width:100%">';
$data["0"] .= '<thead>';
$data["0"] .= '<tr>';
$data["0"] .= '<th id="t2-paso1">Opciones</th>';
$data["0"] .= '<th id="t2-paso6">Identificación</th>';
$data["0"] .= '<th id="t2-paso7">Foto</th>';
$data["0"] .= '<th id="t2-paso8">Apellidos</th>';
$data["0"] .= '<th id="t2-paso9">Nombres</th>';
$data["0"] .= '</tr>';
$data["0"] .= '</thead>';
$data["0"] .= '<tbody>';




		for ($i = 0; $i < count($listar_estudiantes); $i++) {
			$rspta3 = $reporte_veedor->id_estudiante($listar_estudiantes[$i]["id_estudiante"]);
			$id_credencial = $rspta3["id_credencial"];
			$rspta4 = $reporte_veedor->estudiante_datos($id_credencial);
			if (file_exists('../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg')) {
				$foto = '<img src=../files/estudiantes/' . $rspta4["credencial_identificacion"] . '.jpg width=36px height=36px class=rounded-circle>';
			} else {
				$foto = '<img src=../files/null.jpg width=36px height=36px class=rounded-circle>';
			}

			$data["0"] .= '<tr>
				<td class="" style="width:100px">
					<div class="btn-group">
						<a onclick=reporteInfluencer("' . $listar_estudiantes[$i]["id_estudiante"] . '","' . $id_programa . '","' . $listar_estudiantes[$i]["id_materia"] . '","' . $id_credencial . '")
							class="btn bg-purple btn-xs text-white" 
							title="Reporte Influencer" id="t2-paso5">
								<i class="fa-solid fa-comment"></i>
						</a>
					</div>
				</td>

				<td class="ancho-md"><input type="hidden" value="" id="materia">' .
				$rspta4["credencial_identificacion"] . '
				</td>
				<td class="ancho-sm"><input type="hidden" value="" id="materia">' .
				$foto . '
				</td>
				<td>' .
				$rspta4["credencial_apellido"] . ' ' . $rspta4["credencial_apellido_2"] . '
				</td>
				<td>' .
				$rspta4["credencial_nombre"] . ' ' . $rspta4["credencial_nombre_2"] . '
				</td>';
		}
		$data["0"] .= '
				</tbody>
				
			</table>
			
			
		</div>';
		

		$results = array($data);
		echo json_encode($results);

		break;
		
		case 'reporteveedor':
			$traerdirector = $reporte_veedor->programaacademico($id_programa_in);
		$id_director = $traerdirector["programa_director"];
		$traerdatosusuario = $reporte_veedor->traerdatosusuario($id_director);
		$correodir = $traerdatosusuario["usuario_login"];
			$nombre_estudiante = $_SESSION["usario_nombre"]  . ' '.$_SESSION["usario_apellido"];
			$rspta4 = $reporte_veedor->docente_datos($id_docente);
				$id_usuario_docente = $rspta4["id_usuario"];
				$nombredeldocente = $rspta4["usuario_nombre"] . ' ' . $rspta4["usuario_nombre_2"] . ' <br>' . $rspta4["usuario_apellido"] . ' ' . $rspta4["usuario_apellido_2"];
				$rspta3 = $reporte_veedor->id_estudiante($id_estudiante_in);
				$id_credencial_reportado = $rspta3["id_credencial"];
				$estudiante_reportado = $reporte_veedor->estudiante_datos($id_credencial_reportado);
				$nombre_estudiante_reportado = $estudiante_reportado["credencial_nombre"] . ' ' . $estudiante_reportado["credencial_nombre_2"] .' '. $estudiante_reportado["credencial_apellido"] . ' ' . $estudiante_reportado["credencial_apellido_2"];
				$credencial_identificacion = $estudiante_reportado["credencial_identificacion"];
			// $correo = $correodir;
			// $asunto = "Influencer";
			// $mensaje = set_template_influencer($influencer_mensaje, $nombre_estudiante,$nombre_estudiante_reportado, $credencial_identificacion);
			// enviar_correo($correo, $asunto, $mensaje);
			$rspta = $reporte_veedor->insertarreporteinfluencer($id_estudiante_in, $id_programa_in, $id_materia_in, $influencer_mensaje, $fecha, $hora, $periodo_actual,$id_credencial_in);
			// $data["0"] = $rspta ? "ok" : "error";
			// $results = array($data);
			echo json_encode($results);
			break;
}
