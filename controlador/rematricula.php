<?php
session_start();
require_once "../modelos/Rematricula.php";
$rematricula = new Rematricula();
$periodo_actual = $_SESSION['periodo_actual'];
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fechahora = date('Y-m-d H:i:s');
$id_credencial = isset($_POST["id_credencial"]) ? limpiarCadena($_POST["id_credencial"]) : "";
$credencial_nombre = isset($_POST["credencial_nombre"]) ? limpiarCadena($_POST["credencial_nombre"]) : "";
$credencial_nombre_2 = isset($_POST["credencial_nombre_2"]) ? limpiarCadena($_POST["credencial_nombre_2"]) : "";
$credencial_apellido = isset($_POST["credencial_apellido"]) ? limpiarCadena($_POST["credencial_apellido"]) : "";
$credencial_apellido_2 = isset($_POST["credencial_apellido_2"]) ? limpiarCadena($_POST["credencial_apellido_2"]) : "";
$credencial_login = isset($_POST["credencial_login"]) ? limpiarCadena($_POST["credencial_login"]) : "";
$fo_programa = isset($_POST["fo_programa"]) ? limpiarCadena($_POST["fo_programa"]) : "";
$jornada_e = isset($_POST["jornada_e"]) ? limpiarCadena($_POST["jornada_e"]) : "";
$rsptaperiodo = $rematricula->periodoactual(); //trae el periodo	
$periodo_pecuniario = $rsptaperiodo["periodo_pecuniario"]; // contiene el perido a matricular
switch ($_GET["op"]) {
	case 'guardaryeditar':
		$credencial_identificacion = $_GET["credencial_identificacion"];
		$credencial_clave = md5($credencial_identificacion);
		$rspta = $rematricula->insertar($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave);
		$data["0"] = $rspta ? "Estudiante registrado(a) " : "No se pudo registrar el estudiante";
		$rspta = $rematricula->traeridcredencial($credencial_identificacion);
		$data["1"] = $rspta["id_credencial"];
		$results = array($data);
		echo json_encode($results);
		break;
	case 'verificardocumento':
		$credencial_identificacion = $_POST["credencial_identificacion"];
		$rspta = $rematricula->verificardocumento($credencial_identificacion);
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
		$id_credencial = $_SESSION['id_usuario'];
		$rspta = $rematricula->listar($id_credencial);
		// $periodo_pecuniario="2021-2";
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {

			$verificarjornadaactiva = $rematricula->verificarjornadaactiva($rspta[$i]["jornada_e"]); // consulta para mirar si la jornada esta activa para rematricula
			$esta_activa_jornada = $verificarjornadaactiva["rematricula"];

			$rspta2 = $rematricula->listarEstado($rspta[$i]["estado"]);
			if ($rspta2["id_estado_academico"] == 1) {

				$sipagomatricula = $rematricula->sipagomatricula($rspta[$i]["id_estudiante"], $periodo_pecuniario); // si ya realizo pago

				@$factura = $sipagomatricula["x_id_factura"];

				if ($factura) {
					if ($esta_activa_jornada == 1) {


						$programasemestre = $rematricula->traerdatostablaestudiante($rspta[$i]["id_estudiante"]);
						$programa = $programasemestre["fo_programa"];

						// if(($programa == "Nivel 3 - Administración de empresas" and $rspta[$i]["semestre_estudiante"] =="1") or ($programa == "PROFESIONAL EN CONTADURIA PUBLICA INTEP 2021" and $rspta[$i]["semestre_estudiante"] =="1")){
						//     $btnrenovar='<h2>Realizar rematricula presencial</h2>';
						// }else{
						// 	$btnrenovar='<button class="btn btn-success btn-lg" onclick="mostrarmaterias('.$rspta[$i]["id_programa_ac"].','.$rspta[$i]["id_estudiante"].')" title="Renovar matrícula"><i class="fas fa-cart-plus fa-lg mr-2"></i> Matricular Materias</button>';
						// }

						$btnrenovar = '<button class="btn btn-success btn-lg" onclick="mostrarmaterias(' . $rspta[$i]["id_programa_ac"] . ',' . $rspta[$i]["id_estudiante"] . ')" title="Renovar matrícula"><i class="fas fa-cart-plus fa-lg mr-2"></i> Matricular Materias</button>';
					} else {
						$btnrenovar = 'Proximamente';
					}
				} else {
					$btnrenovar = "Sin Acceso";
				}
			}




			$data[] = array(
				"0" => $btnrenovar,
				"1" => $rspta[$i]["fo_programa"],
				"2" => $rspta[$i]["jornada_e"],
				"3" => $rspta[$i]["semestre_estudiante"],
				"4" => $rspta2["estado"],

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
		$id_credencial = $_SESSION['id_usuario'];
		$rspta = $rematricula->mostrardatos($id_credencial);
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
                        <span class="username">
							 <a href="#">' . $rspta["credencial_nombre"] . ' ' . $rspta["credencial_nombre_2"] . ' ' . $rspta["credencial_apellido"] . ' ' . $rspta["credencial_apellido_2"] . '
				        </span>
						<span class="description">' . $rspta["credencial_login"] . '</span>
				    </div>
				</div>';
		$results = array($data);
		echo json_encode($results);
		break;

	case "mostrarmaterias":
		$id_credencial = $_SESSION['id_usuario'];
		$id_programa_ac = $_POST["id_programa_ac"];
		$id_estudiante = $_POST["id_estudiante"];
		$colorribbon = "";
		$textoribbon = "";
		$botoncompra = "";
		$perdida = "";
		//consulta para ver los datos del programa
		$rspta2 = $rematricula->datosPrograma($id_programa_ac);
		$reg2 = $rspta2;
		//consulta para ver los datos del programa en que se matriculo el estudiante
		$rspta4 = $rematricula->datosEstudiante($id_estudiante);
		$reg4 = $rspta4;
		$jornada_estudio = $reg4["jornada_e"];
		$semestre_actual_estudiante = $rspta4["semestre_estudiante"];
		$data = array();
		$data["0"] = "";
		$data["1"] = "";
		$semestres_del_programa = $reg2["semestres"];
		$ciclo = "materias" . $reg2["ciclo"]; // para saber en que tabla debe busar las materias
		$cortes = $reg2["cortes"]; // para saber en que tabla debe busar las materias
		$semestres = 1;
		$datospagorematricula = $rematricula->sipagomatricula($id_estudiante, $periodo_pecuniario);
		$matricula = $datospagorematricula["matricula"]; // creditos pagados, si es uno es completa, si es 2 es media matricula
		$semestrepagado = $datospagorematricula["semestre"]; // creditos permitidos pro el semestre del programa
		$creditospermitidos = $reg2["c" . $semestrepagado];
		$creditospagos = $creditospermitidos / $matricula; // esto son la cantidad de creditos que puede matricular
		$consultacreditosperdidos = $rematricula->creditosMatriculadosperdidos($id_estudiante, $ciclo, $periodo_pecuniario);
		$creditosperdidos = $consultacreditosperdidos["suma_creditos"];
		$consultacreditosmatriculados = $rematricula->creditosMatriculados($id_estudiante, $ciclo, $periodo_pecuniario);
		$creditosmatriculados = $consultacreditosmatriculados["suma_creditos"];
		$creditosdisponibles = $creditospagos - ($creditosperdidos + $creditosmatriculados);
		$data["0"] .= '<div class="col-lg-12 col-md-12 col-sm-12 col-12">Créditos permitidos' . $creditospagos . ' - ' . $creditosperdidos . ' - ' . $creditosmatriculados . ' = ' . $creditosdisponibles . '</div>';
		$primercontrol = $rematricula->primercontrol($id_credencial, $id_estudiante); // mirar si el id_estudiante pertenece  a la credencial
		$llave1 = ($primercontrol ? 1 : 0);
		$primercontrolprograma = $rematricula->primercontrolprograma($id_credencial, $id_programa_ac); // mirar si el programa pertenece a la credencial
		$llave2 = ($primercontrolprograma ? 1 : 0);
		if ($llave1 == 1 and $llave2 == 1) { // quiere decir que el id estudiante si esta vinculado a la credencial
			$data["1"] .= 1;
			if ($semestres_del_programa == 5) { // pra programas con 4 semestres
				$columnas = '<div class="col-xl-2 col-lg-2 col-md-6 col-12">';
			}
			if ($semestres_del_programa == 4) { // pra programas con 4 semestres
				$columnas = '<div class="col-xl-3 col-lg-3 col-md-6 col-12">';
			}
			if ($semestres_del_programa == 3) { // pra programas con 4 semestres
				$columnas = '<div class="col-xl-4 col-lg-4 col-md-6 col-12">';
			}
			if ($semestres_del_programa == 2) { // pra programas con 4 semestres
				$columnas = '<div class="col-xl-4 col-lg-6 col-md-6 col-12">';
			}
			if ($semestres_del_programa == 1) { // pra programas con 4 semestres
				$columnas = '<div class="col-xl-6 col-lg-6 col-md-12 col-12">';
			}
			while ($semestres <= $semestres_del_programa) {
				$data["0"] .= $columnas;
				$data["0"] .= '
					<div class="card">
						<div class="card-header border-1">
							<h3 class="card-title">Semestre ' . $semestres . '</h3>

						</div>
						<div style="padding:2px;">';
				$rspta = $rematricula->listarMaterias($id_programa_ac, $semestres);
				$reg = $rspta;
				for ($i = 0; $i < count($reg); $i++) {
					$id_materia = $reg[$i]["id"];
					$id_programa_ac = $reg[$i]["id_programa_ac"];
					$materia = $reg[$i]["nombre"]; // nombre de la materia 
					$creditos = $reg[$i]["creditos"];
					$modalidad_grado = $reg[$i]["modalidad_grado"];
					$rspta3 = $rematricula->datosMateriaMatriculada($ciclo, $id_estudiante, $materia, $semestres);
					$reg3 = $rspta3;
					if ($rspta3) { // si ya est matriculada la materia
						$id_materia_matriculada = $reg3["id_materia"];
						$promedio_materia_matriculada = $reg3["promedio"];
						$grupo = $reg3["grupo"];
						$periodomatriculada = $reg3["periodo"];
						$promediomatriculada = $reg3["promedio"];
						$jornada_matriculada = $reg3['jornada'];
					} else { // si no encuentra materias matriculadas
						$id_materia_matriculada = null;
						$promedio_materia_matriculada = null;
						$grupo = null;
						$periodomatriculada = null;
						$promediomatriculada = null;
						$jornada_matriculada = null;
					}
					if ($periodo_actual == $periodomatriculada) {
						$color = "success";
						$boton_eliminar = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true" title="eliminar" onclick="eliminarMateria(' . $id_estudiante . ', ' . $id_programa_ac . ', ' . $id_materia . ', ' . $semestres_del_programa . ', ' . $id_materia_matriculada . ', ' . $promedio_materia_matriculada . ' )">×</button>';
					} else if ($periodo_actual != $periodomatriculada) {
						$boton_eliminar = '';
						if ($promediomatriculada > 0 and $promediomatriculada < 3) {
							$color = "danger";
						} else if ($promediomatriculada >= 3) {
							$color = "success";
						} else {
							$color = "primary";
						}
					}
					if ($promediomatriculada <= "2.95" and $periodomatriculada != $periodo_pecuniario) { // para saber cuales materias estan perdidas
						$inicio_corte = 1;
						if ($rspta3) {
							$estaencarrito = $rematricula->estamatriculada($id_estudiante, $materia, $ciclo, $reg2["ciclo"]);
							if ($estaencarrito) { // si se encuentra matriculada la materia perdida
								$colorribbon = "danger";
								$textoribbon = "perdida";
								$botoncompra = "<dt class='text-success'><i class='fas fa-gift'></i> Matriculada obligatoriamente</dt>";
							} else { // si no esta matriculada la materia perdida
								$traerperiodopecuniario = $rematricula->traerperiodopecuniario(); // traer el periodo pecuniario de la tabla periodo actual
								$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
								$perdida = "si";
								//$addasignatura = $rematricula->addasignatura($id_credencial,$id_estudiante,$id_materia,$reg2["ciclo"],$perdida,$fecha,$periodo_pecuniario);//insertar de manera automatica la materia perdida
								$colorribbon = "danger";
								$textoribbon = "perdida";
								$botoncompra = '<a onclick="addcompraperdida(' . $id_estudiante . ',' . $id_materia_matriculada . ',' . $id_programa_ac . ')" class="btn btn-success btn-xs"><i class="fas fa-cart-plus fa-lg mr-2"></i> Matricular obligatoriamente</a>';
							}
						} else {
							$verprerequisito = $rematricula->preRequisito($reg[$i]["prerequisito"]); // consulta pra saber si tiene prerequisito
							if ($verprerequisito) { // si tiene información o si es verdadero
								$verprerequisitonombre = $verprerequisito["nombre"];
							} else { // si no encuentra datos
								$verprerequisitonombre = null;
							}
							$notaprerequisito = $rematricula->preRequisitoNota($reg2["ciclo"], $id_estudiante, $verprerequisitonombre); // consulta para traer la nota del prerequisito
							if ($notaprerequisito) { // si tiene información o si es verdadero
								$notaprerequisitopromedio = $notaprerequisito["promedio"];
							} else { // si no encuentra datos
								$notaprerequisitopromedio = null;
							}
							if ($verprerequisito and $notaprerequisitopromedio <= "2.95") {
								$colorribbon = "warning";
								$textoribbon = "Bloq";
								$botoncompra = "<small>Pendiente:" . $verprerequisito["nombre"] . "</small>";
							} else {
								$colorribbon = "success";
								$textoribbon = "Activa";
								$estaencarrito = $rematricula->estamatriculada($id_estudiante, $materia, $ciclo, $reg2["ciclo"]);
								if ($estaencarrito) {
									$botoncompra = "<dt class='text-success'><i class='fas fa-gift'></i> Matriculada</dt>";
								} else {
									$botoncompra = '<button type="button" class="btn btn-success btn-xs" onclick="addcompra(' . $id_estudiante . ',' . $id_materia . ',' . $id_programa_ac . ')"><i class="fas fa-cart-plus fa-lg mr-2"></i> Matricular</button>';
								}
							}
						}
						$data["0"] .= '
									<div class="col-12">
										<div class="position-relative p-3 " style="height: auto; background-color:whitesmoke">
											<div class="ribbon-wrapper">
												<div class="ribbon bg-' . $colorribbon . '">
													' . $textoribbon . '
												</div>
											</div>
											[' . $creditos . ']  ' . $materia . '<br>
											' . $botoncompra . '
										</div>
									</div><br>';
					} else { // ejecuta si la materia ya se aprobo
						if ($periodomatriculada == $periodo_pecuniario) {
							$data["0"] .= '
											<div class="col-12">
												<div class="position-relative p-3 bg-success" style="height: auto;">
													<div class="ribbon-wrapper">
														<div class="ribbon bg-orange">
															ok
														</div>
													</div>
													[' . $creditos . ']  ' . $materia . '<br>
													Matriculada
												</div>
											</div>';
							if ($modalidad_grado == 0) { // si la materia tiene modalidad de grado
								$buscarmatriculamodadlidad = $rematricula->buscarmatriculamodalidad($id_estudiante, $id_programa_ac, $id_materia, $periodo_pecuniario); // consulta para saber si ya tiene modalidad matriculada
								if ($buscarmatriculamodadlidad) { // si ya matriculo matria de modalidad de grado
									$id_materias_ciafi_modalidad_m = $buscarmatriculamodadlidad["id_materias_ciafi_modalidad"];
									$datosmodalidad = $rematricula->datosmodalidad($id_materias_ciafi_modalidad_m);
									$materiamodalidadm = $datosmodalidad["modalidad"];
									$data["0"] .= '
													<div class="card-header">
														<h3 class="card-title">Modalidad:<b>' . $materiamodalidadm . '</b> </h3>
													</div>';
								} else { //si no ha matriculado materia de modalidad de grado
									$buscar_modalidades = $rematricula->buscarmodalidad($id_materia);
									$data["0"] .= '<div class="col-12">';
									$data["0"] .= '
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
															</table>';

									$data["0"] .= '</div>';
								}
							}
						} else {
							$data["0"] .= '
										<div class="col-12">
											<div class="position-relative p-3 " style="height: auto; background-color:whitesmoke">
												<div class="ribbon-wrapper">
													<div class="ribbon bg-info">
														Aprobada
													</div>
												</div>
												[' . $creditos . ']  ' . $materia . '<br>
												Materia cursada
											</div>
										</div><br>';
						}
					}
				}
				$data["0"] .= '</div>
									</div>';
				$data["0"] .= '</div>';
				$data["0"] .= '</div>';
				$semestres++;
			}
		} else {
			$data["1"] .= "0";
			$data["0"] .= "";
		}
		$results = array($data);
		echo json_encode($results);
		break;
	case "addcompraperdida":
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$data["1"] = ""; //iniciamos el arreglo

		$id_credencial = $_SESSION['id_usuario'];
		$id_estudiante = $_POST["id_estudiante"];
		$id_materia = $_POST["id_materia"];
		$id_programa_ac = $_POST["id_programa_ac"];

		$perdida = "no";
		$creditosmatriculados = 0;
		$fraude3 = 0;

		$traerperiodopecuniario = $rematricula->traerperiodopecuniario(); // traer el periodo pecuniario de la tabla periodo actual
		$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];

		$datostablaestudiantes = $rematricula->traerdatostablaestudiante($id_estudiante); // traer datos de la tabla estudiante
		$ciclo = $datostablaestudiantes["ciclo"];
		$semestre_estudiante = $datostablaestudiantes["semestre_estudiante"];

		$traerdatos_materia_perdida = $rematricula->traerdatosmateriaperdida($id_materia, $id_estudiante, $ciclo); // consulta para traer los datos de lamateria perdida
		$nombre_materia_perdida = $traerdatos_materia_perdida["nombre_materia"];
		$promedio_materia_perdida = $traerdatos_materia_perdida["promedio"];
		$periodo_materia_perdida = $traerdatos_materia_perdida["periodo"];
		$usuario_cancelada = $id_credencial;

		$traerdatos_materias_ciafi = $rematricula->traerdatosmateria($id_programa_ac, $nombre_materia_perdida); // consulta para traer los datos de la matria en materias ciafi (el id)
		$id_materia_ciafi = $traerdatos_materias_ciafi["id"];

		$primercontrol = $rematricula->primercontrol($id_credencial, $id_estudiante);
		$llave1 = ($primercontrol ? 1 : 0);


		$datospagorematricula = $rematricula->sipagomatricula($id_estudiante, $periodo_pecuniario);
		$matricula = $datospagorematricula["matricula"]; // creditos pagados, si es uno es completa, si es 2 es media matricula
		$semestre_pago = $datospagorematricula["semestre"]; // semestre pago en la tabla pagos rematriculas

		$datosprograma = $rematricula->datosPrograma($id_programa_ac); // consulta para taer los datos del programa
		$creditospermitidos = $datosprograma["c" . $semestre_pago]; // creditos permitidos por el semestre del programa
		$cortes_programa = $datosprograma["cortes"]; // trae los cortes del programa

		$creditospagos = $creditospermitidos / $matricula; // esto son la cantidad de creditos que puede matricular

		$ciclocompleto = "materias" . $ciclo; // es el mismo ciclo solo que traer la palabra materias
		$consultacreditosperdidos = $rematricula->creditosMatriculadosperdidos($id_estudiante, $ciclocompleto, $periodo_pecuniario);
		$creditosperdidos = $consultacreditosperdidos["suma_creditos"];

		$consultacreditosmatriculados = $rematricula->creditosMatriculados($id_estudiante, $ciclocompleto, $periodo_pecuniario);
		$creditosmatriculados = $consultacreditosmatriculados["suma_creditos"];

		$creditosdisponibles = $creditospagos - ($creditosperdidos + $creditosmatriculados);

		$data["1"] .= '<div class="col-lg-12 col-md-12 col-sm-12 col-12">Créditos permitidos' . $creditospagos . ' - ' . $creditosperdidos . ' - ' . $creditosmatriculados . ' = ' . $creditosdisponibles . '</div>';



		if ($llave1 == 1) { // quiere decir que el id estudiante si esta vinculado a la credencial

			// inserta la materia perdida en la tabla materias canceladas
			//$consultainsertarperdida=$rematricula->insertarmateriaperdida($id_credencial, $id_estudiante, $id_programa_ac, $id_materia_ciafi, $nombre_materia_perdida, $promedio_materia_perdida, $periodo_materia_perdida, $usuario_cancelada, $fecha, $hora);
			// ***********************************

			$actualizar_materia_perdida = $rematricula->actualizar_materia_perdida($id_materia, $periodo_pecuniario, $ciclocompleto, $cortes_programa, $fechahora, $id_credencial);
			$data["0"] .= "1"; // matriculada correctamente

		} else {
			$data["0"] .= "4"; // posible fraude
		}

		echo json_encode($data);
		break;


	case "addcompra":
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$data["1"] = ""; //iniciamos el arreglo
		$id_credencial = $_SESSION['id_usuario'];
		$id_estudiante = $_POST["id_estudiante"];
		$id_materia = $_POST["id_materia"];
		$id_programa_ac = $_POST["id_programa_ac"];
		$perdida = "no";
		$creditosmatriculados = 0;
		$fraude3 = 0;
		$traerperiodopecuniario = $rematricula->traerperiodopecuniario(); // traer el periodo pecuniario de la tabla periodo actual
		$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
		$datostablaestudiantes = $rematricula->traerdatostablaestudiante($id_estudiante); // traer datos de la tabla estudiante
		$ciclo = $datostablaestudiantes["ciclo"];
		$semestre_estudiante = $datostablaestudiantes["semestre_estudiante"];
		$jornada_e = $datostablaestudiantes["jornada_e"];
		$grupo = $datostablaestudiantes["grupo"];
		$traerdatos_materias_ciafi = $rematricula->traerdatosmaterianormal($id_programa_ac, $id_materia); // consulta para traer los datos de la matria en materias ciafi (el id)
		$id_materia_ciafi = $traerdatos_materias_ciafi["id"];
		$semestre_materia_ciafi = $traerdatos_materias_ciafi["semestre"];
		$creditos_materia_ciafi = $traerdatos_materias_ciafi["creditos"];
		$nombre_materia_ciafi = $traerdatos_materias_ciafi["nombre"];
		$prerequisito_materia_cafi = $traerdatos_materias_ciafi["prerequisito"];
		$primercontrol = $rematricula->primercontrol($id_credencial, $id_estudiante);
		$llave1 = ($primercontrol ? 1 : 0);
		$datospagorematricula = $rematricula->sipagomatricula($id_estudiante, $periodo_pecuniario);
		$matricula = $datospagorematricula["matricula"]; // creditos pagados, si es uno es completa, si es 2 es media matricula
		$semestre_pago = $datospagorematricula["semestre"]; // semestre pago en la tabla pagos rematriculas
		$datosprograma = $rematricula->datosPrograma($id_programa_ac); // consulta para taer los datos del programa
		$creditospermitidos = $datosprograma["c" . $semestre_pago]; // creditos permitidos por el semestre del programa
		$cortes_programa = $datosprograma["cortes"]; // trae los cortes del programa
		$inicio_semestre = $datosprograma["inicio_semestre"];
		$semestres_del_programa = $datosprograma["semestres"];
		$creditospagos = $creditospermitidos / $matricula; // esto son la cantidad de creditos que puede matricular
		$ciclocompleto = "materias" . $ciclo; // es el mismo ciclo solo que traer la palabra materias
		$consultacreditosperdidos = $rematricula->creditosMatriculadosperdidos($id_estudiante, $ciclocompleto, $periodo_pecuniario);
		$creditosperdidos = $consultacreditosperdidos["suma_creditos"];
		$consultacreditosmatriculados = $rematricula->creditosMatriculados($id_estudiante, $ciclocompleto, $periodo_pecuniario);
		$creditosmatriculados = $consultacreditosmatriculados["suma_creditos"];
		$creditosdisponibles = $creditospagos - ($creditosperdidos + $creditosmatriculados);
		$data["1"] .= '<div class="col-lg-12 col-md-12 col-sm-12 col-12">Créditos permitidos' . $creditospagos . ' - ' . $creditosperdidos . ' - ' . $creditosmatriculados . ' = ' . $creditosdisponibles . '</div>';
		if ($llave1 == 1) { // quiere decir que el id estudiante si esta vinculado a la credencial
			$verprerequisito = $rematricula->preRequisito($prerequisito_materia_cafi); // consulta para saber si tiene prerequisito
			$fraude3 = ($verprerequisito ? 1 : 0);
			if ($verprerequisito) { // si tiene la materia un prerequisito
				$notaprerequisito = $rematricula->preRequisitoNota($ciclo, $id_estudiante, $verprerequisito["nombre"]); // consulta para traer la nota del prerequisito
				if ($fraude3 == 1 and $notaprerequisito["promedio"] < "3") { // matriculando materia prerequisitos						
					$data["0"] .= "4"; // esta tratando de matricular una materia prerequisito
				} else {
					// vuelvo y repito el codigo como si toto esta bien
					$verificarcreditos = $creditosdisponibles - $creditos_materia_ciafi;
					if ($verificarcreditos >= 0) { // tiene creditos para matricular materias
						$estado = "matriculada";
						$insertarmateria = $rematricula->insertarmateria($id_estudiante, $nombre_materia_ciafi, $estado, $jornada_e, $periodo_pecuniario, $semestre_materia_ciafi, $creditos_materia_ciafi, $id_programa_ac, $fechahora, $id_credencial, $grupo, $ciclocompleto); // inserta la materia en la tabla materias
						if ($insertarmateria) {
							/* codigo apra mirar en que semestre queda el estudiante */
							$consultacreditostotalmatriculados = $rematricula->creditosMatriculadostotal($id_estudiante, $ciclo); //suma el total de creditos matriculados
							$creditostotalmatriculados = $consultacreditostotalmatriculados["suma_creditos"];
							$semestre_nuevo = 0;
							$suma_creditos_tabla = 0;
							while ($inicio_semestre <= $semestres_del_programa) {
								$campo = "c" . $inicio_semestre;
								$semestre_nuevo++;
								$suma_creditos_tabla += $datosprograma[$campo];
								if ($creditostotalmatriculados <= $suma_creditos_tabla) {
									$inicio_semestre = $semestres_del_programa + 1;
								} else {
									$inicio_semestre++;
								}
							}
							$actualizarperiodoysemestre = $rematricula->actualizarsemestreyperiodo($id_estudiante, $semestre_nuevo, $periodo_pecuniario); // actualiza el semestre y el periodo del estudiante en la tabla estudiante
						}
						/* ************************************ */
						$data["0"] .= "1"; // matriculada correctamente
					} else { // no puede matricular por creditos
						$data["0"] .= "3"; // posible fraude
					}
					/* *************************************** esta bien*********************** */
				}
			} else { // esta todo normal			
				$verificarcreditos = $creditosdisponibles - $creditos_materia_ciafi;
				if ($verificarcreditos >= 0) { // tiene creditos para matricular materias
					$estado = "matriculada";
					$insertarmateria = $rematricula->insertarmateria($id_estudiante, $nombre_materia_ciafi, $estado, $jornada_e, $periodo_pecuniario, $semestre_materia_ciafi, $creditos_materia_ciafi, $id_programa_ac, $fechahora, $id_credencial, $grupo, $ciclocompleto); // inserta la materia en la tabla materias
					if ($insertarmateria) {
						/* codigo apra mirar en que semestre queda el estudiante */
						$consultacreditostotalmatriculados = $rematricula->creditosMatriculadostotal($id_estudiante, $ciclo); //suma el total de creditos matriculados
						$creditostotalmatriculados = $consultacreditostotalmatriculados["suma_creditos"];
						$semestre_nuevo = 0;
						$suma_creditos_tabla = 0;
						while ($inicio_semestre <= $semestres_del_programa) {
							$campo = "c" . $inicio_semestre;
							$semestre_nuevo++;
							$suma_creditos_tabla += $datosprograma[$campo];
							if ($creditostotalmatriculados <= $suma_creditos_tabla) {
								$inicio_semestre = $semestres_del_programa + 1;
							} else {
								$inicio_semestre++;
							}
						}
						$actualizarperiodoysemestre = $rematricula->actualizarsemestreyperiodo($id_estudiante, $semestre_nuevo, $periodo_pecuniario); // actualiza el semestre y el periodo del estudiante en la tabla estudiante
					}
					/* ************************************ */
					$data["0"] .= "1"; // matriculada correctamente
				} else { // no puede matricular por creditos
					$data["0"] .= "3"; // posible fraude
				}
			}
		} else {
			$data["0"] .= "4"; // posible fraude
		}
		echo json_encode($data);
		break;
	case "addmodalidad":
		$data = array();
		$data["0"] = ""; //iniciamos el arreglo
		$id_credencial = $_SESSION['id_usuario'];
		$id_estudiante = $_POST["id_estudiante"];
		$id_materia = $_POST["id_materia"];
		$id_programa_ac = $_POST["id_programa_ac"];
		$id_materias_ciafi_modalidad = $_POST["id_materias_ciafi_modalidad"];
		$perdida = "no";
		$creditosmatriculados = 0;
		$fraude3 = 0;
		$traerperiodopecuniario = $rematricula->traerperiodopecuniario(); // traer el periodo pecuniario de la tabla periodo actual
		$periodo_pecuniario = $traerperiodopecuniario[0]["periodo_pecuniario"];
		$primercontrol = $rematricula->primercontrol($id_credencial, $id_estudiante); // si el id credencial corresponde al id estudiante
		$llave1 = ($primercontrol ? 1 : 0);
		$siestarematriculada = $rematricula->siestarematriculadamodalidad($id_estudiante, $id_materia, $periodo_pecuniario); // si la modalidad no esta matriculada
		$llave2 = ($siestarematriculada ? 1 : 0);
		if ($llave1 == 1) { // quiere decir que el id estudiante si esta vinculado a la credencial
			if ($llave2 == 1) { // quiere decir que ya esta matriculada la modalidad
				$data["0"] .= "2"; // ya existe rematriculada
			} else {
				/* se puede adicionar la modalidad*/
				$addasignatura = $rematricula->addasignaturamodalidad($id_credencial, $id_estudiante, $id_programa_ac, $id_materia, $id_materias_ciafi_modalidad, $periodo_pecuniario, $fecha, $hora);
				$data["0"] .= "1"; // correcto todo
				/* ******************************* */
			}
		} else {
			$data["0"] .= "4"; // posible fraude
		}
		echo json_encode($data);
		break;
}