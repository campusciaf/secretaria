<?php
session_start();
require_once "../modelos/OncenterValDocumentos.php";
$oncentervaldocumentos = new OncenterValDocumentos();
$rsptaperiodo = $oncentervaldocumentos->periodoactual();
$periodo_campana = $rsptaperiodo["periodo_campana"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
$periodo_actual = $_SESSION['periodo_actual'];
//$periodo_siguiente = $_SESSION['periodo_siguiente'];
$usuario_cargo = $_SESSION['usuario_cargo'];
$id_usuario = $_SESSION['id_usuario'];
/* variables para editar perfil */
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
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($id_programa)) {
			$rspta = $oncentervaldocumentos->insertar($nombre);
			echo $rspta ? "Programa registrado " : "No se pudo registrar el programa";
		} else {
			$rspta = $oncentervaldocumentos->editar($id_programa, $nombre);
			echo $rspta ? "Programa actualizado" : "Programa no se pudo actualizar";
		}
		break;
	case 'listar':
		$rspta = $oncentervaldocumentos->listar($periodo_campana);
		//Vamos a declarar un array
		$data = array();
		$i = 0;
		while ($i < count($rspta)) {
			$vercedula = $oncentervaldocumentos->verificarDocumentoCedula($rspta[$i]["id_estudiante"]);
			$verdiploma = $oncentervaldocumentos->verificarDocumentoDiploma($rspta[$i]["id_estudiante"]);
			$veracta = $oncentervaldocumentos->verificarDocumentoActa($rspta[$i]["id_estudiante"]);
			$versalud = $oncentervaldocumentos->verificarDocumentoSalud($rspta[$i]["id_estudiante"]);
			$verprueba = $oncentervaldocumentos->verificarDocumentoCompromiso($rspta[$i]["id_estudiante"]);
			$vercompromiso = $oncentervaldocumentos->verificarDocumentoPrueba($rspta[$i]["id_estudiante"]);
			$verdatos = $oncentervaldocumentos->verificarDocumentoDatos($rspta[$i]["id_estudiante"]);
			$veringles = $oncentervaldocumentos->verificarDocumentoIngles($rspta[$i]["id_estudiante"]);
			if ($vercedula == true) {
				$cedula = $vercedula["validado"];
			} else {
				$cedula = 1;
			}
			if ($verdiploma == true) {
				$diploma = $verdiploma["validado"];
			} else {
				$diploma = 1;
			}
			if ($veracta == true) {
				$acta = $veracta["validado"];
			} else {
				$acta = 1;
			}
			if ($versalud == true) {
				$salud = $versalud["validado"];
			} else {
				$salud = 1;
			}
			if ($verprueba == true) {
				$prueba = $verprueba["validado"];
			} else {
				$prueba = 1;
			}
			if ($vercompromiso == true) {
				$compromiso = $vercompromiso["validado"];
			} else {
				$compromiso = 1;
			}
			if ($verdatos == true) {
				$datos = $verdatos["validado"];
			} else {
				$datos = 1;
			}
			if ($veringles == true) {
				$ingles = $veringles["validado"];
			} else {
				$ingles = 1;
			}
			if ($cedula == 0 and $diploma == 0 and $acta == 0 and $salud == 0 and $prueba == 0 and $compromiso == 0 and $datos == 0 and $ingles == 0 and $rspta[$i]["documentos"] == 1) {
				$enlace = '<a class="btn btn-warning btn-xs" title="validar Documentos" onclick=validarDocumentos(' . $rspta[$i]["id_estudiante"] . ')><i class="fas fa-check-square text-white"></i> Validar </a>';
			} else {
				if ($rspta[$i]["documentos"] == 1) {
					$enlace = 'Pendiente';
				} else {
					$enlace = '<i class="fas fa-check-square text-green"></i> Validado';
				}
			}
			if (isset($rspta[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $rspta[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}
			$data[] = array(
				"0" => $rspta[$i]["id_estudiante"],
				"1" => $rspta[$i]["identificacion"],
				"2" => '<div class="tooltips fila' . $i . '"><a onclick="perfilEstudiante(' . $rspta[$i]["id_estudiante"] . ',' . $rspta[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link" style="padding:0px">' . $rspta[$i]["nombre"] . " " . $rspta[$i]["nombre_2"] . " " . $rspta[$i]["apellidos"] . " " . $rspta[$i]["apellidos_2"] . '</a></div>',
				"3" => '<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
				 <button onclick="agregar(' . $rspta[$i]['id_estudiante'] . ')" id="t2-seg" class="btn btn-outline-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button>',
				"4" => $rspta[$i]["fo_programa"],
				"5" => $rspta[$i]["jornada_e"],
				"6" => '<a onclick="verSoportes(' . $rspta[$i]["id_estudiante"] . ')" class="badge badge-primary pointer text-white" title="Ver Soportes"><i class="fas fa-eye"></i> Ver soporte</a>',
				"7" => $enlace,
				"8" => ($rspta[$i]["matricula"] == 1 ? '<i class="fas fa-check-square text-danger"></i> Pendiente' : '<i class="fas fa-check-square text-green"></i> Validado'),
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
	case 'perfilEstudiante':
		$id_estudiante = $_POST["id_estudiante"];
		$rspta = $oncentervaldocumentos->perfilEstudiante($id_estudiante);
		echo json_encode($rspta);
		break;
	case "selectPrograma":
		$rspta = $oncentervaldocumentos->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectJornada":
		$rspta = $oncentervaldocumentos->selectJornada();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectTipoDocumento":
		$rspta = $oncentervaldocumentos->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectNivelEscolaridad":
		$rspta = $oncentervaldocumentos->selectNivelEscolaridad();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case 'editarPerfil':
		$registrovalido = $oncentervaldocumentos->verFormularioEstudiante($id_estudiante);
		$formulario = $registrovalido["formulario"];
		if ($formulario == 1) { // si el formulario no se ha validado puede actualizar perfil
			$rspta = $oncentervaldocumentos->editarPerfil($id_estudiante, $fo_programa, $jornada_e, $tipo_documento, $nombre, $nombre_2, $apellidos, $apellidos_2, $celular, $email, $nivel_escolaridad, $nombre_colegio, $fecha_graduacion);
			echo $rspta ? "1" : "2";
		} else {
			echo $formulario;
		}
		break;
	case 'validarDocumentos':
		$id_estudiante = $_POST["id_estudiante"];
		$data = array(); //Vamos a declarar un array
		$data["resultado"] = ""; //iniciamos el arreglo
		$data["estado"] = ""; //iniciamos el arreglo
		$rspta = $oncentervaldocumentos->actualizarDocumentos($id_estudiante);
		$data["resultado"] .= $rspta ? "1" : "0";
		$motivo = "Seguimiento";
		$mensaje_seguimiento = "Validación Documentos";
		$ressegui = $oncentervaldocumentos->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);
		$rspta2 = $oncentervaldocumentos->verDatosEstudiante($id_estudiante);
		$documentos = $rspta2["documentos"];
		$matricula = $rspta2["matricula"];
		if ($documentos == 0 and $matricula == 0) {
			$rspta3 = $oncentervaldocumentos->cambioEstado($id_estudiante);
			$motivo2 = "Seguimiento";
			$mensaje_seguimiento2 = "Cambio de estado a Admitido";
			$ressegui2 = $oncentervaldocumentos->registrarSeguimiento($id_usuario, $id_estudiante, $motivo2, $mensaje_seguimiento2, $fecha, $hora);
			$registrarestado = $oncentervaldocumentos->registrarestado($id_usuario, $id_estudiante, 'Admitido', $fecha, $hora, $periodo_campana);
			$data["estado"] .= '1';
		} else {
			$data["estado"] .= '0';
		}
		echo json_encode($data);
		break;
	case 'verSoportes':
		$id_estudiante = $_POST["id_estudiante"];
		$data = array(); //Vamos a declarar un array
		$data["cedula"] = ""; //iniciamos el arreglo
		$data["diploma"] = ""; //iniciamos el arreglo
		$data["acta"] = ""; //iniciamos el arreglo
		$data["salud"] = ""; //iniciamos el arreglo
		$data["prueba"] = ""; //iniciamos el arreglo
		$data["compromiso"] = ""; //iniciamos el arreglo
		$data["proteccion_datos"] = ""; //iniciamos el arreglo
		$data["ingles"] = ""; //iniciamos el arreglo
		// consulta cedula
		$rspta = $oncentervaldocumentos->soporteCedula($id_estudiante);
		$rspta ? "1" : "0";
		if ($rspta) {
			$data["cedula"] .= "
					<table width='100%' cellpadding='5px'>
						<tr>
							<td>
								<a href='../files/oncenter/img_cedula/" . $rspta["nombre_archivo"] . "' class='btn btn-link' target='_blank'>
									<i class='fas fa-eye'></i> Cédula
								</a>
							</td>";
			if ($rspta["validado"] == 1) {
				$data["cedula"] .= "
							<td align='right'>
								<a class='badge badge-primary pointer text-white' onclick='validar(" . $id_estudiante . ",1)'> 
									Validar
								</a>
							</td>";
			} else {
				$data["cedula"] .= "
							<td align='right'>
								<span class='badge badge-success text-white'><i class='fas fa-check-double'></i> Ok.</span>
							</td>";
			}
			$data["cedula"] .= "
						</tr>
				</table>";
		} else {
			$data["cedula"] .= "<p class='alert alert-warning'>Sin Documento Cédula</p>";
		}
		/* ********************** */
		// consulta diploma
		$rspta2 = $oncentervaldocumentos->soporteDiploma($id_estudiante);
		$rspta2 ? "1" : "0";
		if ($rspta2) {
			$data["diploma"] .= "
					<table width='100%' cellpadding='5px'>
						<tr>
							<td>
								<a href='../files/oncenter/img_diploma/" . $rspta2["nombre_archivo"] . "' class='btn btn-link' target='_blank'>
									<i class='fas fa-eye'></i> Diploma
								</a>
							</td>";
			if ($rspta2["validado"] == 1) {
				$data["diploma"] .= "
								<td align='right'>
									<a class='badge badge-primary text-white' onclick='validar(" . $id_estudiante . ",2)'> 
										Validar
									</a>
								</td>";
			} else {
				$data["diploma"] .= "
								<td align='right'>
									<span class='badge badge-success text-white'><i class='fas fa-check-double'></i> Ok.</span>
								</td>";
			}
			$data["diploma"] .= "
						</tr>
					</table>";
		} else {
			$data["diploma"] .= "<p class='alert alert-warning'>Sin Documento Diploma</p>";
		}
		/* ********************** */
		// consulta acta
		$rspta3 = $oncentervaldocumentos->soporteActa($id_estudiante);
		$rspta3 ? "1" : "0";
		if ($rspta3) {
			$data["acta"] .= "
					<table width='100%' cellpadding='5px'>
						<tr>
							<td>
								<a href='../files/oncenter/img_acta/" . $rspta3["nombre_archivo"] . "' class='btn btn-link' target='_blank'>
									<i class='fas fa-eye'></i> Acta (grado)
								</a>
							</td>";
			if ($rspta3["validado"] == 1) {
				$data["acta"] .= "
							<td align='right'>
								<a class='badge badge-primary text-white' onclick='validar(" . $id_estudiante . ",3)'>
									Validar
								</a>
							</td>";
			} else {
				$data["acta"] .= "
							<td align='right'>
								<span class='badge badge-success text-white'><i class='fas fa-check-double'></i> Ok.</span>
							</td>";
			}
			$data["acta"] .= "
					</tr>
				</table>";
		} else {
			$data["acta"] .= "<p class='alert alert-warning'>Sin Documento Acta de Grado</p>";
		}
		/* ********************** */
		// consulta salud
		$rspta4 = $oncentervaldocumentos->soporteSalud($id_estudiante);
		$rspta4 ? "1" : "0";
		if ($rspta4) {
			$data["salud"] .= "
					<table width='100%' cellpadding='5px'>
						<tr>
							<td>
								<a href='../files/oncenter/img_salud/" . $rspta4["nombre_archivo"] . "' class='btn btn-link' target='_blank'>
									<i class='fas fa-eye'></i> Salud (EPS)
								</a>
							</td>";
			if ($rspta4["validado"] == 1) {
				$data["salud"] .= "
							<td align='right'>
								<a class='badge badge-primary text-white' onclick='validar(" . $id_estudiante . ",4)'> 
									Validar
								</a>
							</td>";
			} else {
				$data["salud"] .= "
							<td align='right'>
								<span class='badge badge-success text-white'><i class='fas fa-check-double'></i> Ok.</span>
							</td>";
			}
			$data["salud"] .= "
						</tr>
					</table>";
		} else {
			$data["salud"] .= "<p class='alert alert-warning'>Sin Documento Salud (EPS)</p>";
		}
		/* ********************** */
		// consulta pruebas
		$rspta5 = $oncentervaldocumentos->soportePrueba($id_estudiante);
		$rspta5 ? "1" : "0";
		if ($rspta5) {
			$data["prueba"] .= "
					<table width='100%' cellpadding='5px'>
						<tr>
							<td>
								<a href='../files/oncenter/img_prueba/" . $rspta5["nombre_archivo"] . "' class='btn btn-link' target='_blank'>
									<i class='fas fa-eye'></i> Pruebas (Estado)
								</a>
							</td>";
			if ($rspta5["validado"] == 1) {
				$data["prueba"] .= "
							<td align='right'>
								<a class='badge badge-primary text-white' onclick='validar(" . $id_estudiante . ",5)'>
									Validar
								</a>
							</td>";
			} else {
				$data["prueba"] .= "
							<td align='right'>
								<span class='badge badge-success text-white'><i class='fas fa-check-double'></i> Ok.</span>
							</td>";
			}
			$data["prueba"] .= "
						</tr>
					</table>";
		} else {
			$data["prueba"] .= "<p class='alert alert-warning'>Sin Documento Prueba Saber</p>";
		}
		/* ********************** */
		/* ********************** */
		// consulta pruebas
		$rspta6 = $oncentervaldocumentos->soporte_compromiso($id_estudiante);
		$rspta6 ? "1" : "0";
		if ($rspta6) {
			$data["compromiso"] .= "
					<table width='100%' cellpadding='5px'>
						<tr>
							<td>
								<a href='../files/oncenter/img_compromiso/" . $rspta6["nombre_archivo"] . "' class='btn btn-link' target='_blank'>
									<i class='fas fa-eye'></i> Compromiso
								</a>
							</td>";
			if ($rspta6["validado"] == 1) {
				$data["compromiso"] .= "
							<td align='right'>
								<a class='badge badge-primary text-white' onclick='validar(" . $id_estudiante . ",6)'>
									Validar
								</a>
							</td>";
			} else {
				$data["compromiso"] .= "
							<td align='right'>
								<span class='badge badge-success text-white'><i class='fas fa-check-double'></i> Ok.</span>
							</td>";
			}
			$data["compromiso"] .= "
						</tr>
					</table>";
		} else {
			$data["compromiso"] .= "<p class='alert alert-warning'>Sin Documento Compromiso</p>";
		}
		/* ********************** */
		/* ********************** */
		// consulta proteccion de datos
		$rspta7 = $oncentervaldocumentos->soporte_proteccion($id_estudiante);
		$rspta7 ? "1" : "0";
		if ($rspta7) {
			$data["proteccion_datos"] .= "
					<table width='100%' cellpadding='5px'>
						<tr>
							<td>
								<a href='../files/oncenter/img_proteccion_datos/" . $rspta7["nombre_archivo"] . "' class='btn btn-link' target='_blank'>
									<i class='fas fa-eye'></i> Protección datos
								</a>
							</td>";
			if ($rspta7["validado"] == 1) {
				$data["proteccion_datos"] .= "
							<td align='right'>
								<a class='badge badge-primary text-white' onclick='validar(" . $id_estudiante . ",7)'>
									Validar
								</a>
							</td>";
			} else {
				$data["proteccion_datos"] .= "
							<td align='right'>
								<span class='badge badge-success text-white'><i class='fas fa-check-double'></i> Ok.</span>
							</td>";
			}
			$data["proteccion_datos"] .= "
						</tr>
					</table>";
		} else {
			$data["proteccion_datos"] .= "<p class='alert alert-warning'>Sin Documento Protección de datos</p>";
		}
		/* ********************** */

		// consulta ingles
		$rspta8 = $oncentervaldocumentos->soporte_ingles($id_estudiante);
		$rspta8 ? "1" : "0";
		if ($rspta8) {
			$data["ingles"] .= "
					<table width='100%' cellpadding='5px'>
						<tr>
							<td>
								<a href='../files/oncenter/img_ingles/" . $rspta8["nombre_archivo"] . "' class='btn btn-link' target='_blank'>
									<i class='fas fa-eye'></i> Compromiso Ingles
								</a>
							</td>";
			if ($rspta8["validado"] == 1) {
				$data["ingles"] .= "
							<td align='right'>
								<a class='badge badge-primary text-white' onclick='validar(" . $id_estudiante . ",8)'>
									Validar
								</a>
							</td>";
			} else {
				$data["ingles"] .= "
							<td align='right'>
								<span class='badge badge-success text-white'><i class='fas fa-check-double'></i> Ok.</span>
							</td>";
			}
			$data["ingles"] .= "
						</tr>
					</table>";
		} else {
			$data["proteccion_datos"] .= "<p class='alert alert-warning'>Sin Documento Protección de datos</p>";
		}
		/* ********************** */

		echo json_encode($data);
	break;
	case 'validar':
		$id_estudiante = $_POST["id_estudiante"];
		$soporte = $_POST["soporte"];
		$rspta = $oncentervaldocumentos->validar($id_estudiante, $soporte, $fecha, $hora, $id_usuario);
		echo $rspta ? "1" : "0";
	break;
}
