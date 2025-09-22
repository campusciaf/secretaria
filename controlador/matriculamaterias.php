<?php
error_reporting(0);
session_start();
require_once "../modelos/MatriculaMaterias.php";
$matriculamaterias = new MatriculaMaterias();
$periodo_actual = $_SESSION['periodo_actual'];
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d-H:i:s');
$fecha_corta = date('Y-m-d');
$hora = date('H:i:s');
$id_credencial = isset($_POST["id_credencial"]) ? limpiarCadena($_POST["id_credencial"]) : "";
$credencial_nombre = isset($_POST["credencial_nombre"]) ? limpiarCadena($_POST["credencial_nombre"]) : "";
$credencial_nombre_2 = isset($_POST["credencial_nombre_2"]) ? limpiarCadena($_POST["credencial_nombre_2"]) : "";
$credencial_apellido = isset($_POST["credencial_apellido"]) ? limpiarCadena($_POST["credencial_apellido"]) : "";
$credencial_apellido_2 = isset($_POST["credencial_apellido_2"]) ? limpiarCadena($_POST["credencial_apellido_2"]) : "";
$credencial_login = isset($_POST["credencial_login"]) ? limpiarCadena($_POST["credencial_login"]) : "";
$fo_programa = isset($_POST["fo_programa"]) ? limpiarCadena($_POST["fo_programa"]) : "";
$jornada_e = isset($_POST["jornada_e"]) ? limpiarCadena($_POST["jornada_e"]) : "";
switch ($_GET["op"]) {
	case 'guardaryeditar':
		$credencial_identificacion = $_GET["credencial_identificacion"];
		$credencial_clave = md5($credencial_identificacion);
		$rspta = $matriculamaterias->insertar($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave);
		$data["0"] = $rspta ? "Estudiante registrado(a) " : "No se pudo registrar el estudiante";
		$rspta = $matriculamaterias->traeridcredencial($credencial_identificacion);
		$data["1"] = $rspta["id_credencial"];
		$results = array($data);
		echo json_encode($results);
		break;
	case 'verificardocumento':
		$credencial_identificacion = $_POST["credencial_identificacion"];
		$rspta = $matriculamaterias->verificardocumento($credencial_identificacion);
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
	case 'listar':
		$id_credencial = $_GET["id_credencial"];
		$rspta = $matriculamaterias->listar($id_credencial);
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$rspta2 = $matriculamaterias->listarEstado($rspta[$i]["estado"]);
			$data[] = array(
				"0" => '
					<div class="btn-group text-center">
						<button class="btn btn-primary btn-xs" onclick="mostrarmaterias(' . $rspta[$i]["id_programa_ac"] . ',' . $rspta[$i]["id_estudiante"] . ')" title="Matricular Materias"> <i class="fas fa-plus-square"></i> Materias </button>
						<button class="btn btn-danger btn-xs" onclick="verdetalle(' . $rspta[$i]["id_programa_ac"] . ',' . $rspta[$i]["id_estudiante"] . ')" title="Ver Detalle"> <i class="fas fa-eye"></i> </button>	
					</div>',
				"1" => $rspta[$i]["id_estudiante"],
				"2" => $rspta[$i]["fo_programa"],
				"3" => $rspta[$i]["jornada_e"],
				"4" => $rspta[$i]["semestre_estudiante"],
				"5" => $rspta[$i]["grupo"],
				"6" => $rspta2["estado"],
				"7" => $rspta[$i]["periodo"],
				"8" => $rspta[$i]["periodo_activo"],
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
	case "mostrardatos":
		$id_credencial = $_POST["id_credencial"];
		$rspta = $matriculamaterias->mostrardatos($id_credencial);

		$cedula_estudiante = $rspta["credencial_identificacion"];
		$datos_personales_estudiante = $matriculamaterias->telefono_estudiante($cedula_estudiante);
		$celular_estudiante = $datos_personales_estudiante["celular"] ?? "";
		$data = array();
		$data["0"] = "";
		if (file_exists('../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg')) {
			$foto = '<img src=../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg  width=35px height=35px class=img-circle img-bordered-sm>';
		} else {
			$foto = '<img src=../files/null.jpg width=35px height=35px class=img-circle img-bordered-sm>';
		}
		$data["0"] .= '
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2 ">
					<div class="row align-items-center">
						<div class="col-2">
							<span class="rounded  text-gray ">
								' . $foto . '
							</span> 
						</div>
						<div class="col-10 line-height-16">
							<span class="fs-12">' . $rspta["credencial_nombre"] . ' ' . $rspta["credencial_nombre_2"] . '  </span> <br>
							<span class="text-semibold fs-12 titulo-2 line-height-16">' . $rspta["credencial_apellido"] . ' ' . $rspta["credencial_apellido_2"] . ' </span> 
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
					<div class="row align-items-center">
						<div class="col-2">
							<span class="rounded bg-light-red p-2 text-red">
								<i class="fa-regular fa-envelope" aria-hidden="true"></i>
							</span> 
						</div>
						<div class="col-10">
							<span class="fs-12">Correo electrónico</span> <br>
							<span class="text-semibold fs-12 titulo-2 line-height-16">' . $rspta["credencial_login"] . '</span> 
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
					<div class="row align-items-center">
						<div class="col-2">
							<span class="rounded bg-light-green p-2 text-success">
								<i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
							</span> 
						</div>
						<div class="col-10">
							<span class="fs-12">Número celular</span> <br>
							<span class="text-semibold fs-12 titulo-2 line-height-16">' . (!empty($celular_estudiante) ? $celular_estudiante : 'El estudiante no tiene número de teléfono registrado.') . '</span>
						</div>
					</div>
				</div>
			</div>';
		$results = array($data);
		echo json_encode($results);
		break;
	case "mostrarmaterias":
		$id_programa_ac = $_POST["id_programa_ac"];
		$id_estudiante = $_POST["id_estudiante"];
		//consulta para ver los datos del programa
		$rspta2 = $matriculamaterias->datosPrograma($id_programa_ac);
		$reg2 = $rspta2;
		//consulta para ver los datos del programa en que se matriculo el estudiante
		$rspta4 = $matriculamaterias->datosEstudiante($id_estudiante);
		$reg4 = $rspta4;
		$jornada_estudio = $reg4["jornada_e"];
		$data = array();
		$data["0"] = "";
		$semestres_del_programa = $reg2["semestres"];
		$ciclo = "materias" . $reg2["ciclo"]; // para saber en que tabla debe buscar las materias
		$cortes = $reg2["cortes"]; // para saber en que tabla debe busar las materias
		if ($semestres_del_programa == 1) {
			$anchodiv = '<div class="col-xl-6 col-lg-6 col-md-6 col-12 p-2">';
		} else if ($semestres_del_programa == 2) {
			$anchodiv = '<div class="col-xl-6 col-lg-6 col-md-6 col-12 p-2">';
		} else if ($semestres_del_programa == 3) {
			$anchodiv = '<div class="col-xl-4 col-lg-4 col-md-4 col-12 p-2">';
		} else if ($semestres_del_programa == 4) {
			$anchodiv = '<div class="col-xl-3 col-lg-3 col-md-3 col-12 p-2">';
		} else if ($semestres_del_programa == 5) {
			$anchodiv = '<div class="col-xl-2 col-lg-2 col-md-3 col-12 p-2">';
		}
		$semestres = 1;
		while ($semestres <= $semestres_del_programa) {
			$data["0"] .= $anchodiv.'
				<div class="card col-12">
					<div class="row">
						<div class="col-12 p-2 tono-3">
							<div class="row align-items-center">
								<div class="col-auto">
									<span class="rounded bg-light-blue p-2 text-primary ">
										<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
									</span> 	
								</div>
								<div class="col-10">
									<div class="col-5 fs-14 line-height-18"> 
										<span class="">Semestre</span> <br>
										<span class="titulo-2 line-height-16 fs-18">' . $semestres . '</span> 
									</div> 
								</div>
							</div>
						</div>		
						<div class="col-12 pb-2">
							<div class="row col-12">';
			$rspta = $matriculamaterias->listarMaterias($id_programa_ac, $semestres);
			$reg = $rspta;
			for ($i = 0; $i < count($reg); $i++) {
				$id_materia = $reg[$i]["id"];
				$id_programa_ac = $reg[$i]["id_programa_ac"];
				$materia = $reg[$i]["nombre"]; // nombre de la materia 
				$creditos = $reg[$i]["creditos"];
				$modalidad_grado = $reg[$i]["modalidad_grado"];
				//echo "datosMateriaMatriculada($ciclo, $id_estudiante, $materia, $semestres)";
				$rspta3 = $matriculamaterias->datosMateriaMatriculada($ciclo, $id_estudiante, $materia, $semestres);
				$reg3 = $rspta3;
				$id_materia_matriculada = isset($reg3["id_materia"])? $reg3["id_materia"]:"";
				$promedio_materia_matriculada = isset($reg3["promedio"])? $reg3["promedio"]:"";
				$grupo = isset($reg3["grupo"])? $reg3["grupo"]:"";
				$periodo_matriculada = isset($reg3["periodo"])? $reg3["periodo"]:"";
				$jornada_matriculada = isset($reg3['jornada'])? $reg3['jornada']:"";

				if ($periodo_actual == $periodo_matriculada) {
					$color = "blue";
					$boton_eliminar = '<button type="button" class="close fs-18" data-dismiss="alert" aria-hidden="true"  title="Eliminar" onclick="eliminarMateria(' . $id_estudiante . ', ' . $id_programa_ac . ', ' . $id_materia . ', ' . $semestres_del_programa . ', ' . $id_materia_matriculada . ', ' . $promedio_materia_matriculada . ' )">×</button>';
				} else if ($periodo_actual != $periodo_matriculada) {
					$boton_eliminar = '';
					if ($promedio_materia_matriculada > 0 and $promedio_materia_matriculada < 3) {
						$color = "red";
					} else if ($promedio_materia_matriculada >= 3) {
						$color = "green";
					} else {
						$color = "white";
					}
				}
				$data["0"] .= '
					<div class="col-12 mt-2 p-2 bg-light-' . $color . ' titulo-2 fs-12 line-height-16">
						<div class="row">
							<div class="col-12">
								<span class="fs-14" data-toggle="tooltip" data-placement="top" title="Créditos"> [' . $creditos . '] </span>
								<span class="fs-14"> ' . $materia . ' </span>
								<span class="float-right"> ' . $boton_eliminar . ' </span>
							</div> ';
				$inicio_corte = 1;
				if ($rspta3) {
					$data["0"] .= '<div class="col-12">';
					while ($inicio_corte <= $cortes) {
						$nota = "c" . $inicio_corte;
						$tnota = "C" . $inicio_corte;
						$data["0"] .= '<span class="label label-default mt-1 borde"> ' . $tnota . ': <span class="fs-14">' . $reg3[$nota] . '</span></span> ';
						$inicio_corte++;
					}
					$data["0"] .= '
							<span class="badge badge-info text-white float-right" data-toggle="tooltip" data-placement="top" title="Promedio">Prom: ' . $promedio_materia_matriculada . '</span>
						</div>
						<div class="col-12 btn-group">';
					if ($periodo_actual != $periodo_matriculada) {
						$data["0"] .= '
							<div class="col-12 p-0"><span class="pr-2" data-toggle="tooltip" data-placement="top" title="Jornada"><i class="fa fa-calendar-alt"></i> ' . $jornada_matriculada . ' </span>
							<span data-toggle="tooltip" data-placement="top" title="Periodo matriculado"><i class="fa fa-hourglass-start" ></i> ' . $periodo_matriculada . '</span></div>';
					} else {
						$data["0"] .= '
							<button class="btn btn-warning btn-xs mt-1" onclick="cambioJornada(' . $id_materia_matriculada . ', `' . $jornada_matriculada . '`, `' . $ciclo . '`, ' . $id_programa_ac . ', ' . $id_estudiante . ')" data-toggle="tooltip" data-placement="top" title="Jornada">' . $jornada_matriculada . '</button>
							<button class="btn btn-info btn-xs mt-1" onclick="cambioPeriodo(' . $id_materia_matriculada . ', `' . $periodo_matriculada . '`, `' . $ciclo . '`, ' . $id_programa_ac . ', ' . $id_estudiante . ')" data-toggle="tooltip" data-placement="top" title="Periodo">' . $periodo_matriculada . '</button><button class="btn btn-primary btn-xs mt-1" onclick="cambioGrupo(' . $id_materia_matriculada . ', `' . $periodo_matriculada . '`, `' . $ciclo . '`, ' . $id_programa_ac . ', ' . $id_estudiante . ', ' . $grupo . ')" data-toggle="tooltip" data-placement="top" title="Grupo"> Grupo: ' . $grupo . '</button>';
						if ($rspta3["activar_grupo_esp"] == 1) {
							//echo "entro ".$rspta3["id_docente_grupo_esp"];
							$list = $matriculamaterias->listarDocentePorGrupo($rspta3["id_docente_grupo_esp"]);
							$listar_docente = $list;
							//print_r($listar_docente);
							$nombre_docente = ucfirst(mb_strtolower(trim($listar_docente["usuario_nombre"]) . " " . trim($listar_docente["usuario_nombre_2"]) . " " . trim($listar_docente["usuario_apellido"]) . " " . trim($listar_docente["usuario_apellido_2"]), 'UTF-8'));
							$dia = $listar_docente["dia"];
							$hora = $listar_docente["hora"];
							$hasta = $listar_docente["hasta"];
							$data["0"] .=  '<button class="btn btn-xs bg-danger mt-1" data-toggle="tooltip" data-placement="top" data-html="true" title="Horario especial: ' . $dia . ' - ' . $hora . ' a ' . $hasta . '<br> Docente: ' . $nombre_docente . '" onclick="EliminarHorarioEspecial(' . $id_materia_matriculada . ', `' . $ciclo . '`, '. $id_estudiante.', '. $rspta3["id_docente_grupo_esp"].')"> <i class="fas fa-trash text-white"></i> </button>';
						} else {
							$data["0"] .= '<button class="btn btn-xs bg-orange mt-1" data-toggle="tooltip" data-placement="top" title="Agregar horario especial" onclick="mostrarTodasLasClases(' . $id_materia_matriculada . ', `' . $ciclo . '`, '. $id_estudiante.')"> <i class="fas fa-user-clock text-white"></i> </button>';
						}
					}
					$data["0"] .= '</div>';
				} else {
					$data["0"] .= '
					<div class="col-12">
						<button type="button" class="btn btn-success btn-xs" onclick="matriculaMateriaNormal(' . $id_estudiante . ', ' . $id_programa_ac . ', ' . $id_materia . ', ' . $semestres_del_programa . ')">Matricular
						</button>
					</div>';
				}
				$data["0"] .= '
					</div>
				</div>';
				$sihaymodalidad = $matriculamaterias->buscarmodalidadmatriculada($id_estudiante, $id_materia, $periodo_actual);
				if ($sihaymodalidad) { // si tiene la modalidad matriculada no puede matricular
					$id_materias_modalidad = $sihaymodalidad["id_materias_modalidad"];
					$id_materias_ciafi_modalidad = $sihaymodalidad["id_materias_ciafi_modalidad"]; // variable que tiene el ide de la modalidad matriculada
					$datosmodalidadmatriculada = $matriculamaterias->datosmodalidadmatriculada($id_materias_ciafi_modalidad);
					$data["0"] .= '
						<div class="col-12">
							<table class="table table-sm table-bordered">
								<tr class="text-center">
									<td>' . $datosmodalidadmatriculada["modalidad"] . '</td>
									<td>
										<button class="btn btn-danger btn-xs" onclick="delmodalidad(' . $id_materias_modalidad . ')" title="Eliminar modalidad">
											<i class="far fa-trash-alt fa-1x" aria-hidden="true"></i>
										</button>
									</td>
								</tr>
							</table>
						</div>';
				} else { // si no esta matriculada la modalidad puede matricular
					if ($modalidad_grado == 0 and $periodo_actual == $periodo_matriculada) {
						$buscar_modalidades = $matriculamaterias->buscarmodalidad($id_materia);
						$data["0"] .= '
							<div class="col-12">
								<div class="card-header">
									<h3 class="card-title">Seleccionar una opción</h3>
								</div>
								<table class="table table-sm">
									<thead>
										<tr>
											<th >Opción</th>
											<th style="width: 10px">Acción</th>
										</tr>
									</thead>
									<tbody>';
						for ($mo = 0; $mo < count($buscar_modalidades); $mo++) {
							$id_materias_ciafi_modalidad = $buscar_modalidades["$mo"]["id_materias_ciafi_modalidad"];
							$nombre_modalidad = $buscar_modalidades["$mo"]["modalidad"];
							$data["0"] .= '
										<tr>
											<td>' . $nombre_modalidad . '</td>
											<td>
												<button class="btn btn-info btn-xs" onclick="addmodalidad(' . $id_programa_ac . ',' . $id_materia . ',' . $id_estudiante . ',' . $id_materias_ciafi_modalidad . ')" title="Matricular modalidad">
													<i class="fa fa-plus fa-1x" aria-hidden="true"></i>
												</button>
											</td>
										</tr>';
						}
						$data["0"] .= '
									</tbody>
								</table>
							</div>';
					}
				}
			} 
			$data["0"] .= '
								</div>
							</div>
						</div>
					</div> <!-- ancho row -->
				</div> <!-- cierra card -->
			</div> <!-- ancho div -->';  
			$semestres++;
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case "matriculaMateriaNormal":
		$usuario = $_SESSION['usuario_cargo'];
		$id_estudiante = $_POST["id_estudiante"];
		$id_materia = $_POST["id_materia"];
		$semestres_del_programa = $_POST["semestres_del_programa"];
		$rspta2 = $matriculamaterias->MateriaDatos($id_materia);
		$nombre_materia = $rspta2["nombre"];
		$semestre = $rspta2["semestre"];
		$creditos = $rspta2["creditos"];
		$rspta3 = $matriculamaterias->datosEstudiante($id_estudiante);
		$id_programa_ac = $rspta3["id_programa_ac"];
		$jornada_e = $rspta3["jornada_e"]; // trae la jornada de estudio del estudiante
		$programa = $rspta3["fo_programa"];
		$ciclo = $rspta3["ciclo"];
		$grupo = $rspta3["grupo"];
		$rspta4 = $matriculamaterias->insertarmateria($id_estudiante, $nombre_materia, $jornada_e, $periodo_actual, $semestre, $creditos, $id_programa_ac, $ciclo, $fecha, $usuario, $grupo);
		if ($rspta4) {
			$rspta5 = $matriculamaterias->actualizarperiodo($id_estudiante, $periodo_actual);
			$rspta6 = $matriculamaterias->creditosMatriculados($id_estudiante, $ciclo); //suma el total de creditos matriculados
			$creditos_matriculados = $rspta6["suma_creditos"];
			$rspta7 = $matriculamaterias->datosPrograma($id_programa_ac); // trae creditos por semestre
			$inicio_semestre = $rspta7["inicio_semestre"];
			$semestre_nuevo = 0;
			$suma_creditos_tabla = 0;
			while ($inicio_semestre <= $semestres_del_programa) {
				$campo = "c" . $inicio_semestre;
				$semestre_nuevo++;
				$suma_creditos_tabla += $rspta7[$campo];
				if ($creditos_matriculados <= $suma_creditos_tabla) {
					$inicio_semestre = $semestres_del_programa + 1;
				} else {
					$inicio_semestre++;
				}
			}
			$rspta8 = $matriculamaterias->actualizarsemestre($id_estudiante, $semestre_nuevo); // trae creditos por semestre
		}
		echo json_encode($rspta4);
		break;
	case "eliminarMateria":
		$usuario = $_SESSION['usuario_cargo'];
		$id_estudiante = $_POST["id_estudiante"];
		$id_materia = $_POST["id_materia"];
		$semestres_del_programa = $_POST["semestres_del_programa"];
		$id_materia_matriculada = $_POST["id_materia_matriculada"];
		$promedio_materia_matriculada = $_POST["promedio_materia_matriculada"];
		$rspta2 = $matriculamaterias->MateriaDatos($id_materia);
		$nombre_materia = $rspta2["nombre"];
		$semestre = $rspta2["semestre"];
		$creditos = $rspta2["creditos"];
		$rspta3 = $matriculamaterias->datosEstudiante($id_estudiante);
		$id_programa_ac = $rspta3["id_programa_ac"];
		$jornada_e = $rspta3["jornada_e"]; // trae la jornada de estudio del estudiante
		$programa = $rspta3["fo_programa"];
		$ciclo = $rspta3["ciclo"];
		$rspta9 = $matriculamaterias->trazabilidadMateriaEliminada($id_estudiante, $nombre_materia, $jornada_e, $periodo_actual, $semestre, $promedio_materia_matriculada, $programa, $fecha, $usuario);
		$rspta4 = $matriculamaterias->eliminarMateria($id_materia_matriculada, $ciclo);
		if ($rspta4) {
			$rspta6 = $matriculamaterias->creditosMatriculados($id_estudiante, $ciclo); //suma el total de creditos matriculados
			$creditos_matriculados = $rspta6["suma_creditos"];
			$rspta7 = $matriculamaterias->datosPrograma($id_programa_ac); // trae creditos por semestre
			$inicio_semestre = $rspta7["inicio_semestre"];
			$semestre_nuevo = 0;
			$suma_creditos_tabla = 0;
			while ($inicio_semestre <= $semestres_del_programa) {
				$campo = "c" . $inicio_semestre;
				$semestre_nuevo++;
				$suma_creditos_tabla += $rspta7[$campo];
				if ($creditos_matriculados <= $suma_creditos_tabla) {
					$inicio_semestre = $semestres_del_programa + 1;
				} else {
					$inicio_semestre++;
				}
			}
			$rspta8 = $matriculamaterias->actualizarsemestre($id_estudiante, $semestre_nuevo); // trae creditos por semestre
		}
		echo json_encode($rspta4);
		break;
	case "selectJornada":
		$rspta = $matriculamaterias->selectJornada();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectPrograma":
		$rspta = $matriculamaterias->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["original"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectPeriodo":
		$rspta = $matriculamaterias->selectPeriodo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
		break;
	case "selectGrupo":
		$rspta = $matriculamaterias->selectGrupo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["grupo"] . "'>" . $rspta[$i]["grupo"] . "</option>";
		}
		break;
	case "actualizarJornada":
		$id_materia = $_POST["id_materia"];
		$ciclo = $_POST["ciclo"];
		$jornada_e = $_POST["jornada_e"];
		$id_estudiante = $_POST["id_estudiante"];
		$id_programa_ac = $_POST["id_programa_ac"];
		$data = array();
		$data["0"] = "";
		$rspta = $matriculamaterias->actualizarJornada($id_materia, $jornada_e, $ciclo);
		$data["0"] .= $id_programa_ac;
		$data["1"] = $id_estudiante;
		$results = array($data);
		echo json_encode($results);
		break;
	case "actualizarPeriodo":
		$id_materia = $_POST["id_materia_j"];
		$ciclo = $_POST["ciclo_j"];
		$periodo = $_POST["periodo"];
		$id_estudiante = $_POST["id_estudiante_j"];
		$id_programa_ac = $_POST["id_programa_ac_j"];
		$data = array();
		$data["0"] = "";
		$rspta = $matriculamaterias->actualizarPeriodoMateria($id_materia, $periodo, $ciclo);
		$data["0"] .= $id_programa_ac;
		$data["1"] = $id_estudiante;
		$results = array($data);
		echo json_encode($results);
		break;
	case "actualizarGrupo":
		$id_materia = $_POST["id_materia_g"];
		$ciclo = $_POST["ciclo_g"];
		$grupo = $_POST["grupo"];
		$id_estudiante = $_POST["id_estudiante_g"];
		$id_programa_ac = $_POST["id_programa_ac_g"];
		$data = array();
		$data["0"] = "";
		$rspta = $matriculamaterias->actualizarGrupoMateria($id_materia, $grupo, $ciclo);
		$data["0"] .= $id_programa_ac;
		$data["1"] = $id_estudiante;
		$results = array($data);
		echo json_encode($results);
		break;
	case 'ListarClasesEscuela':
		error_reporting(1);
		$escuela = $_GET["escuela"];
		$days = array( "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
		$impresion = '[';
		for ($x = 0; $x < 7; $x++) {
			$traerhorario = $matriculamaterias->ListarClasesEscuela($days[$x], $escuela);
			for ($i = 0; $i < count($traerhorario); $i++) {
				$id_docente_grupo = $traerhorario[$i]["id_docente_grupo"];
				$id_docente = $traerhorario[$i]["id_docente"];
				$nombre_docente = ucfirst(mb_strtolower(trim($traerhorario[$i]["usuario_nombre"]) . " " . trim($traerhorario[$i]["usuario_nombre_2"]) . " " . trim($traerhorario[$i]["usuario_apellido"]) . " " . trim($traerhorario[$i]["usuario_apellido_2"]), 'UTF-8'));
				$materia = $traerhorario[$i]["nombre"];
				$salon = $traerhorario[$i]["salon"];
				$fecha_inicial = $traerhorario[$i]["hora"];
				$fecha_final = $traerhorario[$i]["hasta"];
				$color = $traerhorario[$i]["color"];
				$impresion .= '{"title":"' . $materia . ' - ' . $salon . ' " , "daysOfWeek": "' . $x . '", "startTime":"' . $fecha_inicial . '","endTime":"' . $fecha_final . '", "color": "' . $color . '", "id_docente_grupo": "' . $id_docente_grupo . '", "id_docente": "' . $id_docente . '", "nombre_docente": "' . $nombre_docente . '"},';
			}
		}
		$impresion = substr($impresion, 0, -1);
		$impresion .= ']';
		echo $impresion;
		break;
	case 'asignarDocenteGrupo':
		$id_docente_grupo = ($_POST["id_docente_grupo"]) ? $_POST["id_docente_grupo"] : "";
		$id_materia_matriculada = ($_POST["id_materia_matriculada"]) ? $_POST["id_materia_matriculada"] : "";
		$ciclo_matriculado = ($_POST["ciclo_matriculado"]) ? $_POST["ciclo_matriculado"] : "";
		$id_estudiante_especial = ($_POST["id_estudiante_especial"]) ? $_POST["id_estudiante_especial"] : "";
		//$periodo_actual 
		$actualizar_docente_grupo = $matriculamaterias->asignarDocenteGrupoEspecial($id_docente_grupo, $id_materia_matriculada, $ciclo_matriculado);
		if ($actualizar_docente_grupo) {
			$matriculamaterias->CrearHorarioEspecial($id_docente_grupo, $periodo_actual, $ciclo_matriculado, $id_estudiante_especial); 
			$data = array("exito" => 1, "info" => "Docente asignado con éxito.");
		} else {
			$data = array("exito" => 0, "info" => "Error al asignar el docente.");
		}
		echo json_encode($data);
		break;
	case 'eliminarHorarioEspecial':
		$id_materia_matriculada = ($_POST["id_materia_matriculada"]) ? $_POST["id_materia_matriculada"] : "";
		$ciclo_matriculado = ($_POST["ciclo_matriculado"]) ? $_POST["ciclo_matriculado"] : "";
		$id_estudiante_especial = ($_POST["id_estudiante_especial"]) ? $_POST["id_estudiante_especial"] : "";
		$id_docente_grupo_esp = ($_POST["id_docente_grupo_esp"]) ? $_POST["id_docente_grupo_esp"] : "";
		$eliminarHorarioEspecial = $matriculamaterias->eliminarHorarioEspecial($id_docente_grupo_esp, $id_estudiante_especial);
		if ($eliminarHorarioEspecial) {
			$matriculamaterias->limpiarHorarioEspecial($id_materia_matriculada, $ciclo_matriculado);
			$data = array("exito" => 1, "info" => "Horario eliminado con éxito.");
		} else {
			$data = array("exito" => 0, "info" => "Error al eliminar el horario.");
		}
		echo json_encode($data);
		break;
	case "addmodalidad":
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$id_estudiante = $_POST["id_estudiante"];
		$id_materia = $_POST["id_materia"];
		$id_programa_ac = $_POST["id_programa_ac"];
		$id_materias_ciafi_modalidad = $_POST["id_materias_ciafi_modalidad"];
		$perdida = "no";
		$creditosmatriculados = 0;
		$fraude3 = 0;
		$datos_estudiante = $matriculamaterias->datos_estudiante($id_estudiante); // si el id credencial corresponde al id estudiante
		$id_credencial = $datos_estudiante["id_credencial"];
		/* se uede adicionar la modalidad*/
		$addasignatura = $matriculamaterias->addasignaturamodalidad($id_credencial, $id_estudiante, $id_programa_ac, $id_materia, $id_materias_ciafi_modalidad, $periodo_actual, $fecha_corta, $hora);
		$data["0"] .= "1"; // correcto todo
		/* ******************************* */
		echo json_encode($data);
		break;
	case "delmodalidad":
		$id_materias_modalidad = $_POST["id_materias_modalidad"];
		$rspta4 = $matriculamaterias->eliminarModalidad($id_materias_modalidad);
		echo json_encode($rspta4);
		break;
		//muestra los detalles del usuario que lo matriculo  
	case "verdetalle":
		$id_estudiante = $_POST["id_estudiante"];
		$id_programa_ac = $_POST["id_programa_ac"];
		$data = array();
		$datos_estudiante = $matriculamaterias->datos_estudiante($id_estudiante); // si el id credencial corresponde al id estudiante
		$id_usuario_matriculo = $datos_estudiante["id_usuario_matriculo"];
		$fecha_matricula = $matriculamaterias->fechaesp($datos_estudiante["fecha_matricula"]);
		$fecha_matricula_condicional = ($datos_estudiante["fecha_matricula"]);
		$hora_matricula = $datos_estudiante["hora_matricula"];
		$nombre_docente = $matriculamaterias->datos_usuario_ingreso($id_usuario_matriculo); // si el id credencial corresponde al id estudiante
		$nombre_docente_ver_detalle = $nombre_docente["usuario_nombre"] . " " . $nombre_docente["usuario_nombre_2"] . " " . $nombre_docente["usuario_apellido"] . " " . $nombre_docente["usuario_apellido_2"];
		$data[0] = "";
		if ($id_usuario_matriculo == "0") {
			$data[0] .= '
				<div class="modal fade" id="myModalverdetelles" role="dialog">
					<div class="modal-dialog modal-sm modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h6 class="modal-title">Ver Detalles</h6>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<div class="form-group col-12">
									<div class="alert alert-warning" role="alert">
									No tienes datos.
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</div>
				</div>';
		} else {
			$data[0] .= '
				<div class="modal fade" id="myModalverdetelles" role="dialog">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h6 class="modal-title">Ver Detalles de la matricula</h6>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<form name="formularioverdetalle" id="formularioverdetalle" method="POST">
									<div class="col-12 card p-4 form-group col-12">
										<table id="tablaverdetalles" class="table table-hover" style="width:100%">
											<thead>
												<tr>
													<th scope="col">Nombre Usuario</th>
													<th scope="col">Fecha Matricula</th>
													<th scope="col">Hora Matricula</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>' . $nombre_docente_ver_detalle . '</td>
													<td>' . $fecha_matricula . '</td>
													<td>' . $hora_matricula . '</td>
												</tr>
											</tbody>
										</table>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>';
		}
		echo json_encode($data);
		break;
	default:
		echo json_encode(array("exito" => 0, "info" => "No seleccionaste ninguna opcion."));
		break;
}
