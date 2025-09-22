<?php
session_start();
require_once "../modelos/OncenterPreinscrito.php";
// require('../public/mail/sendMailPreinscrito.php');
require_once "../mail/send_preinscrito.php"; //para realizar el envio del correo.
require_once "../mail/template_preinscrito.php"; //creamos template para el envio de la clave, usuario y programa
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$oncenterpreinscrito = new OncenterPreinscrito();
$rsptaperiodo = $oncenterpreinscrito->periodoactual();
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
switch ($_GET["op"]) {

	case 'moverUsuario':
		$rspta = $oncenterpreinscrito->moverUsuario($id_estudiante_mover, $estado);
		echo $rspta ? "Usuario Actualizado" : "Usuario no se pudo mover";
		if ($rspta == "Usuario Actualizado") { // se puede insertar un  seguimiento
			$motivo_seguimiento = "Seguimiento";
			$mensaje_seguimiento =  $estado;
			$rspta2 = $oncenterpreinscrito->insertarSeguimiento($id_usuario, $id_estudiante_mover, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora);
		}
	break;

	case 'editarPerfil':
		if ($fecha_graduacion == "") {
			$fecha_graduacion = NULL;
		}
		$registrovalido = $oncenterpreinscrito->verFormularioEstudiante($id_estudiante);
		$formulario = $registrovalido["formulario"];
		if ($formulario == 1) { // si el formulario no se ha validado puede actualizar perfil
			$rspta = $oncenterpreinscrito->editarPerfil($id_estudiante, $fo_programa, $jornada_e, $tipo_documento, $nombre, $nombre_2, $apellidos, $apellidos_2, $celular, $email, $nivel_escolaridad, $nombre_colegio, $fecha_graduacion);
			echo $rspta ? "1" : "2";
		} else {
			echo "3";
		}
	break;

	case 'listar':
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$consulta1 = $oncenterpreinscrito->listarcriterios(); // consulta para traer los preinscritos

		$rsptaperiodo = $oncenterpreinscrito->periodoactual();	
		$periodo_campana=$rsptaperiodo["periodo_campana"];
		//resultado de la campaña actual por el periodo actual.
		$porcentajecampañaactual = $oncenterpreinscrito->CantidadCasosPorCampaña($periodo_campana);
		$periodo_anterior=$rsptaperiodo["periodo_anterior"];
		//resultado de la camapaña anterior por el periodo actual.
		$porcentajecampañaanterior = $oncenterpreinscrito->CantidadCasosPorCampañaAnterior($periodo_anterior);
		
		//tomamos la temporada actual
		$temporada_actual_info = $oncenterpreinscrito->temporadaanterior($periodo_campana);
$temporada_actual = isset($temporada_actual_info["temporada"]) ? $temporada_actual_info["temporada"] : null;

if ($temporada_actual) {
    // Calcular la temporada de hace un año
    $temporada_hace_un_ano = $temporada_actual - 1; // Cambiado de -2 a -1 para calcular correctamente hace un año
    $tomar_periodo_anterior = $oncenterpreinscrito->periodoactualtemporada($temporada_hace_un_ano);

    // Validar si se obtuvo un período válido
    $periodo_hace_un_año = isset($tomar_periodo_anterior["periodo"]) ? $tomar_periodo_anterior["periodo"] : null;

    if ($periodo_hace_un_año) {
        // Obtener los casos de hace un año
        $hace_un_año = $oncenterpreinscrito->CantidadCasosPorCampañaUnaño($periodo_hace_un_año);
    } else {
        $hace_un_año = []; // Si no hay período válido, inicializar como vacío
    }
} else {
    $hace_un_año = []; // Si no hay temporada actual, inicializar como vacío
}

// Calcular la variación porcentual
$valor_actual = count($porcentajecampañaactual);
$valor_hace_un_ano = count($hace_un_año);

if ($valor_hace_un_ano != 0) {
    $porcentaje_variacion = (($valor_actual - $valor_hace_un_ano) / $valor_hace_un_ano) * 100;
    $porcentaje_variacion = round($porcentaje_variacion, 2);
} else {
    $porcentaje_variacion = 0;
}

// Determinar el ícono y color según la variación
if ($porcentaje_variacion > 0) {
    $clase_icono = 'fa-arrow-up';
    $color_texto = 'text-success';
} elseif ($porcentaje_variacion < 0) {
    $clase_icono = 'fa-arrow-down';
    $color_texto = 'text-danger';
} else {
    $clase_icono = '';
    $color_texto = 'text-muted';
}
		
		$data["0"] .= '
			<div class="col-8 py-3 pl-4" id="t-ea">
					<h5 class="fw-light mb-4 text-secondary pl-4">Total Tareas,</h5>
					<h1 class="titulo-2 fs-36 pl-4 text-semibold" title="Casos Periodo Anterior">'.count($porcentajecampañaanterior).'</h1>

					<h5 class="pl-4 fs-18 text-semibold mb-0"> <span title="Casos Hace un año">' . count($hace_un_año) . '</span><small class="' . $color_texto . '" style="display:inline-block; margin-left:6px;"><span title="Comparación Hace Un Año">' . $porcentaje_variacion . '% <i class="fa-solid ' . $clase_icono .'" aria-hidden="true"></i></span><span class="fs-14 text-muted d-block" title="Periodo Anterior" style="line-height:1;">' . $periodo_anterior . '</span></small></h5>

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
		';
		for ($a = 0; $a < count($consulta1); $a++) {
			$nombre_criterio = $consulta1[$a]["nombre"];
			$icono = $consulta1[$a]["icono"];
			$consulta2 = $oncenterpreinscrito->listar($periodo_campana, $nombre_criterio); // consulta para traer los preinscritos de la campaña actual
			$data["0"] .= '	
			<div class="col-4 p-4">
				<div class="row">
					<div class="card col-12">
						<div class="row" id="t-ea">
							<div class="col-12 p-4 tono-3">
								<div class="row align-items-center">
									<div class="col-auto pl-2">
										<span class="rounded bg-light-blue p-3">
											' . $icono . '
										</span> 
									</div>
									<div class="col-auto">
										<div class="col-12 fs-14 line-height-18"> 
											<span class="">Resultados</span> <br>
											<span class="text-semibold fs-20">' . $nombre_criterio . '</span> 
										</div> 
									</div>
								</div>
							</div>
							<div class="col-12 p-2">
								<ul class="nav flex-column">
									<li class="nav-item" id="t-ca">
									<a href="#" onclick=listarDos("' . $periodo_campana . '","' . $nombre_criterio . '") class="nav-link">
										Campaña Actual  <span class="float-right badge bg-primary">' . count($consulta2) . '</span>
										</a>
									</li>
									<li class="nav-item" id="t-cn">
										<div style="height:50px; padding-top:10px">
											<div class="row">
												<div class="nav-link col-lg-6">Campañas Anteriores</div>
												<div class="col-lg-6">
													<form action="">
														<select name="periodo_buscar' . $a . '" id="periodo_buscar' . $a . '" class="form-control float-right form-control-sm" data-live-search="true" onChange=listarDos(this.value,"' . $nombre_criterio . '")>
														</select>
													<form>
												</div>
											</div>
										</div>	
									</li>';
			$consulta3 = $oncenterpreinscrito->listarmedios(); // consulta para traer los estudiantes por medio
			for ($b = 0; $b < count($consulta3); $b++) {
				$medio = $consulta3[$b]["nombre"];
				$consulta4 = $oncenterpreinscrito->listarmedioscantidad($nombre_criterio, $medio, $periodo_campana); // cantidad de estudiantes por medio	
				$data["0"] .= '
					<li class="nav-item" id="t-paso' . $b . '">
						<a href="#" onclick="listarTres(`' . $nombre_criterio . '`,`' . $medio . '`,`' . $periodo_campana . '`)" class="nav-link">' . $medio . ' <span class="float-right badge bg-green">' . count($consulta4) . '</span>
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
		';
		}
		$results = array($data);
		echo json_encode($results);
	break;

	case 'listarDos':
		$periodo = $_POST["periodo"];
		$nombre_criterio = $_POST["nombre_criterio"];
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$data["0"] .= '<div class="alert col-md-12">
			<a onClick="volver()" id="volver" class="btn btn-danger float-right text-white"><i class="fas fa-arrow-circle-left"></i> Volver</a>
			</div>';
		$data["0"] .= '<div class="card col-12">';
		$data["0"] .= '<table id="tbllistado" class="table table-hover" width="100%">';
		$data["0"] .= '<thead>';
		$data["0"] .= '<th>Programasx</th>';
		$consulta1 = $oncenterpreinscrito->listarJornada(); // consulta para listar las jornadas en la tabla
		for ($a = 0; $a < count($consulta1); $a++) {
			$data["0"] .= '<th>' . $consulta1[$a]["nombre"] . '</th>';
		}
		$data["0"] .= '<thead>';
		$data["0"] .= '<tbody>';
		$consulta2 = $oncenterpreinscrito->listarPrograma(); // consulta para traer los programas activos
		for ($b = 0; $b < count($consulta2); $b++) {
			$nombre_programa = $consulta2[$b]["nombre"];
			$data["0"] .= '<tr>';
			$data["0"] .= '<td>';
			$data["0"] .= $nombre_programa;
			$data["0"] .= '</td>';
			$consulta3 = $oncenterpreinscrito->listarJornada(); // consulta pra listar el total por jornadas y programa
			for ($c = 0; $c < count($consulta3); $c++) {
				$jornada = $consulta3[$c]["nombre"];
				$consulta4 = $oncenterpreinscrito->listarprogramajornada($nombre_programa, $jornada, $nombre_criterio, $periodo);
				$data["0"] .= '<td>';
				$data["0"] .= '<a onclick="verEstudiantes(`' . $nombre_programa . '`,`' . $jornada . '`,`' . $nombre_criterio . '`,`' . $periodo . '`)" class="btn">' . count($consulta4) . '</a>';
				$data["0"] .= '</td>';
			}
			$data["0"] .= '</tr>';
		}
		$data["0"] .= '<tr>';
		$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';
		$consulta4 = $oncenterpreinscrito->listarJornada(); // consulta pra listar las sumas de las columnas
		for ($d = 0; $d < count($consulta4); $d++) {
			$jornadasuma = $consulta4[$d]["nombre"];
			$consulta5 = $oncenterpreinscrito->sumaporjornada($jornadasuma, $nombre_criterio, $periodo);
			$data["0"] .= '<td>';
			$data["0"] .= '<a onclick="verEstudiantesSuma(`' . $jornadasuma . '`,`' . $nombre_criterio . '`,`' . $periodo . '`)" class="btn btn-primary btn-sm">' . count($consulta5) . '</a>';
			$data["0"] .= '</td>';
		}
		$data["0"] .= '</tr>';
		$data["0"] .= '</tbody>';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		$consulta6 = $oncenterpreinscrito->listar($periodo, $nombre_criterio); // consulta para traer los interesados de la 
		$data["0"] .= '<div class="alert float-right"><h3>Total General <a onclick="verEstudiantesTotal(`' . $periodo . '`,`' . $nombre_criterio . '`)" class="btn btn-primary">' . count($consulta6) . '</a></h3></div>';
		$results = array($data);
		echo json_encode($results);
	break;

	case 'listarTres':
		$nombre_criterio = $_POST["nombre_criterio"];
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
								<span class="text-semibold fs-20">' . $nombre_criterio . '</span> 
							</div> 
							</div>
						</div>
					</div>
					<div class="col-6 tono-3 pt-3 pr-4">
						<a onClick="volver()" id="t2-volt" class="btn btn-danger float-right text-white"><i class="fas fa-arrow-circle-left"></i> Volver</a>
					</div>
				</div>
			</div>';
		$data["0"] .= '<div class="card col-12">';
		// $data["0"] .= '<table id="tbllistado" class="table table-hover" style="width:100%">';
		$data["0"] .= '<table id="tbllistado" class="table table-hover" width="100%">';
		$data["0"] .= '<thead>';
		$data["0"] .= '<th id="t2-paso0">Programa</th>';
		$consulta1 = $oncenterpreinscrito->listarJornada(); // consulta pra lñistar las jornadas en la tabla
		$num_paso = 1;
		for ($a = 0; $a < count($consulta1); $a++) {
			$data["0"] .= '<th id="t2-paso' . $num_paso . '" >' . $consulta1[$a]["nombre"] . '</th>';
			$num_paso++;
		}
		$data["0"] .= '<thead>';
		$data["0"] .= '<tbody>';
		$consulta2 = $oncenterpreinscrito->listarPrograma(); // consulta para traer los programas activos
		for ($b = 0; $b < count($consulta2); $b++) {
			$nombre_programa = $consulta2[$b]["nombre"];
			$data["0"] .= '<tr>';
			$data["0"] .= '<td>';
			$data["0"] .= $nombre_programa;
			$data["0"] .= '</td>';
			$consulta3 = $oncenterpreinscrito->listarJornada(); // consulta pra listar el total por jornadas y programa
			for ($c = 0; $c < count($consulta3); $c++) {
				$jornada = $consulta3[$c]["nombre"];
				$consulta4 = $oncenterpreinscrito->listarprogramamedio($nombre_programa, $jornada, $medio, $nombre_criterio, $periodo);
				$data["0"] .= '<td>';
				$data["0"] .= '<a onclick="verEstudiantesmedio(`' . $nombre_programa . '`,`' . $jornada . '`,`' . $medio . '`,`' . $nombre_criterio . '`,`' . $periodo . '`)" class="btn">' . count($consulta4) . '</a>';
				$data["0"] .= '</td>';
			}
			$data["0"] .= '</tr>';
		}
		$data["0"] .= '<tr>';
		$data["0"] .= '<td><b>zTotal Estudiantes</b></td>';
		$consulta4 = $oncenterpreinscrito->listarJornada(); // consulta pra listar las sumas de las columnas
		for ($d = 0; $d < count($consulta4); $d++) {
			$jornadasuma = $consulta4[$d]["nombre"];
			$consulta5 = $oncenterpreinscrito->sumapormedio($jornadasuma, $medio, $nombre_criterio, $periodo);
			$data["0"] .= '<td>';
			$data["0"] .= '<a onclick="verEstudiantesSumaMedio(`' . $nombre_programa . '`,`' . $jornadasuma . '`,`' . $medio . '`,`' . $nombre_criterio . '`,`' . $periodo . '`)" class="btn btn-primary btn-sm">' . count($consulta5) . '</a>';
			$data["0"] .= '</td>';
		}
		$data["0"] .= '</tr>';
		$data["0"] .= '</tbody>';
		$data["0"] .= '</table>';
		$data["0"] .= '</div>';
		$consulta6 = $oncenterpreinscrito->listarpormedio($medio, $periodo, $nombre_criterio); // consulta para traer los interesados de la 
		$data["0"] .= '<div class="alert float-right"><h3>Total General <a onclick="verEstudiantesTotalMedio(`' . $medio . '`,`' . $periodo . '`,`' . $nombre_criterio . '`)" class="btn btn-primary">' . count($consulta6) . '</a></h3></div>';
		$results = array($data);
		echo json_encode($results);
	break;

	case 'verEstudiantes':
		$nombre_programa = $_GET["nombre_programa"];
		$jornada = $_GET["jornada"];
		$estado = $_GET["estado"];
		$periodo = $_GET["periodo"];
		$rspta = $oncenterpreinscrito->listarprogramajornada($nombre_programa, $jornada, $estado, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		$etiquetas = $oncenterpreinscrito->etiquetas();
		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}

			$select  = '';
                                
			$select .= '<select class="form-control asesor" onchange="cambiarEtiqueta('.$reg[$i]["id_estudiante"].',this.value)" style="height:auto;font-size:12px">';
				for ($s=0; $s < count($etiquetas); $s++) {
					
					if ($etiquetas[$s]['id_etiquetas'] == $reg[$i]["id_etiqueta"]) {
						$select .= '<option value="'.$etiquetas[$s]['id_etiquetas'].'" selected>'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					} else {
						$select .='<option value="'.$etiquetas[$s]['id_etiquetas'].'">'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					}
				}
			$select .= '</select>';

			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div style="width:200px">'.$select.'</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"3" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"4" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"5" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"6" => '<div class="fila' . $i . '">' . ($reg[$i]["formulario"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"7" => '<div class="fila' . $i . '">' . ($reg[$i]["inscripcion"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"8" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '<br>' . $reg[$i]["contacto"] . '</div>',
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

	case 'verEstudiantesMedio':
		$nombre_programa = $_GET["nombre_programa"];
		$jornada = $_GET["jornada"];
		$medio = $_GET["medio"];
		$estado = $_GET["estado"];
		$periodo = $_GET["periodo"];
		$rspta = $oncenterpreinscrito->listarprogramamedio($nombre_programa, $jornada, $medio, $estado, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		$etiquetas = $oncenterpreinscrito->etiquetas();
		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}

			$select  = '';

			$select .= '<select class="form-control asesor" onchange="cambiarEtiqueta('.$reg[$i]["id_estudiante"].',this.value)" style="height:auto;font-size:12px">';
				for ($s=0; $s < count($etiquetas); $s++) {
					
					if ($etiquetas[$s]['id_etiquetas'] == $reg[$i]["id_etiqueta"]) {
						$select .= '<option value="'.$etiquetas[$s]['id_etiquetas'].'" selected>'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					} else {
						$select .='<option value="'.$etiquetas[$s]['id_etiquetas'].'">'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					}
				}
			$select .= '</select>';

			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div style="width:200px">'.$select.'</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"3" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"4" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"5" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"6" => '<div class="fila' . $i . '">' . ($reg[$i]["formulario"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"7" => '<div class="fila' . $i . '">' . ($reg[$i]["inscripcion"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"8" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '<br>' . $reg[$i]["contacto"] . '</div>',
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

	case 'verEstudiantesSuma':
		$jornada = $_GET["jornada"];
		$estado = $_GET["estado"];
		$periodo = $_GET["periodo"];
		$rspta = $oncenterpreinscrito->sumaporjornada($jornada, $estado, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		$etiquetas = $oncenterpreinscrito->etiquetas();

		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}

			$select  = '';

			$select .= '<select class="form-control asesor" onchange="cambiarEtiqueta('.$reg[$i]["id_estudiante"].',this.value)" style="height:auto;font-size:12px">';
				for ($s=0; $s < count($etiquetas); $s++) {
					
					if ($etiquetas[$s]['id_etiquetas'] == $reg[$i]["id_etiqueta"]) {
						$select .= '<option value="'.$etiquetas[$s]['id_etiquetas'].'" selected>'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					} else {
						$select .='<option value="'.$etiquetas[$s]['id_etiquetas'].'">'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					}
				}
			$select .= '</select>';

			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div style="width:200px">'.$select.'</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"3" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"4" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"5" => '<div class="fila' . $i . '">' . $reg[$i]["fo_programa"] . '</div>',
				"6" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"7" => '<div class="fila' . $i . '">' . ($reg[$i]["formulario"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"8" => '<div class="fila' . $i . '">' . ($reg[$i]["inscripcion"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"9" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '<br>' . $reg[$i]["contacto"] . '</div>',
				"10" => '<div class="fila' . $i . '">' . $reg[$i]["medio"] . '</div>'
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
		$nombre_criterio = $_GET["nombre_criterio"];
		$periodo = $_GET["periodo"];
		$rspta = $oncenterpreinscrito->sumapormedio($jornada, $medio, $nombre_criterio, $periodo);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		$etiquetas = $oncenterpreinscrito->etiquetas();


		

		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}

			$select  = '';
		
			$select .= '<select class="form-control asesor" onchange="cambiarEtiqueta('.$reg[$i]["id_estudiante"].',this.value)" style="height:auto;font-size:12px">';
				for ($s=0; $s < count($etiquetas); $s++) {
					
					if ($etiquetas[$s]['id_etiquetas'] == $reg[$i]["id_etiqueta"]) {
						$select .= '<option value="'.$etiquetas[$s]['id_etiquetas'].'" selected>'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					} else {
						$select .='<option value="'.$etiquetas[$s]['id_etiquetas'].'">'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					}
				}
			$select .= '</select>';

			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div style="width:200px">'.$select.'</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"3" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"4" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"5" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"6" => '<div class="fila' . $i . '">' . ($reg[$i]["formulario"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"7" => '<div class="fila' . $i . '">' . ($reg[$i]["inscripcion"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"8" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '<br>' . $reg[$i]["contacto"] . '</div>',
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

	case 'verEstudiantesTotal':
		$nombre_criterio = $_GET["nombre_criterio"];
		$periodo = $_GET["periodo"];
		$rspta = $oncenterpreinscrito->listar($periodo, $nombre_criterio);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		$etiquetas = $oncenterpreinscrito->etiquetas();

		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}

			$select  = '';
		
			$select .= '<select class="form-control asesor" onchange="cambiarEtiqueta('.$reg[$i]["id_estudiante"].',this.value)" style="height:auto;font-size:12px">';
				for ($s=0; $s < count($etiquetas); $s++) {
					
					if ($etiquetas[$s]['id_etiquetas'] == $reg[$i]["id_etiqueta"]) {
						$select .= '<option value="'.$etiquetas[$s]['id_etiquetas'].'" selected>'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					} else {
						$select .='<option value="'.$etiquetas[$s]['id_etiquetas'].'">'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					}
				}
			$select .= '</select>';

			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div style="width:200px">'.$select.'</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"3" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"4" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"5" => '<div class="fila' . $i . '">' . $reg[$i]["fo_programa"] . '</div>',
				"6" => '<div class="fila' . $i . '">' . $reg[$i]["jornada_e"] . '</div>',
				"7" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></i>Enviar</a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"8" => '<div class="fila' . $i . '">' . ($reg[$i]["formulario"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"9" => '<div class="fila' . $i . '">' . ($reg[$i]["inscripcion"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"10" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '<br>' . $reg[$i]["contacto"] . '</div>',
				"11" => '<div class="fila' . $i . '">' . $reg[$i]["medio"] . '</div>'
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
		$nombre_criterio = $_GET["nombre_criterio"];
		$periodo = $_GET["periodo"];
		$rspta = $oncenterpreinscrito->listarpormedio($medio, $periodo, $nombre_criterio);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		$etiquetas = $oncenterpreinscrito->etiquetas();
		for ($i = 0; $i < count($reg); $i++) {
			if (isset($reg[$i]["celular"])) {
				$estilo_whatsapp = 'btn-success';
				$numero_celular = $reg[$i]["celular"];
			} else {
				$estilo_whatsapp = 'btn-danger disabled';
				$numero_celular = '';
			}

			$select  = '';
		
			$select .= '<select class="form-control asesor" onchange="cambiarEtiqueta('.$reg[$i]["id_estudiante"].',this.value)" style="height:auto;font-size:12px">';
				for ($s=0; $s < count($etiquetas); $s++) {
					
					if ($etiquetas[$s]['id_etiquetas'] == $reg[$i]["id_etiqueta"]) {
						$select .= '<option value="'.$etiquetas[$s]['id_etiquetas'].'" selected>'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					} else {
						$select .='<option value="'.$etiquetas[$s]['id_etiquetas'].'">'.$etiquetas[$s]['etiqueta_nombre'].'</option>';
					}
				}
			$select .= '</select>';

			$data[] = array(
				"0" => '<div class="fila' . $i . '"><div class="btn-group">
						<!--<a onclick="eliminar(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-danger btn-xs" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>-->
						<a onclick="mover(' . $reg[$i]["id_estudiante"] . ',' . $i . ')" class="btn btn-warning btn-xs" title="Mover Usuario"><i class="fas fa-exchange-alt"></i></a>
						<a onclick="verHistorial(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye"></i></a>
						<a onclick="agregar(' . $reg[$i]["id_estudiante"] . ')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus"></i></a>
						<button class="btn ' . $estilo_whatsapp . ' btn-sm" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> <i class="fab fa-whatsapp"></i></button>
					</div></div>',
				"1" => '<div style="width:200px">'.$select.'</div>',
				"2" => '<div class="fila' . $i . '">' . $reg[$i]["id_estudiante"] . '</div>',
				"3" => '<div class="fila' . $i . '">' . $reg[$i]["identificacion"] . '</div>',
				"4" => '<div class="fila' . $i . '"><a onclick="perfilEstudiante(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ',' . $i . ')" title="perfilEstudiante" class="btn btn-link">' . $reg[$i]["nombre"] . " " . $reg[$i]["nombre_2"] . " " . $reg[$i]["apellidos"] . " " . $reg[$i]["apellidos_2"] . '</a></div>',
				"5" => '<div class="fila' . $i . '">' . $reg[$i]["fo_programa"] . '</div>',
				"6" => '<div class="fila' . $i . '">' . $reg[$i]["jornada_e"] . '</div>',
				"7" => '<div class="fila' . $i . '">' . ($reg[$i]["mailing"] == 1 ? '<a class="btn btn-link" onclick=correo(' . $reg[$i]["id_estudiante"] . ',' . $reg[$i]["identificacion"] . ')><i class="fas fa-envelope text-red"></Enviar></a>' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"8" => '<div class="fila' . $i . '">' . ($reg[$i]["formulario"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"9" => '<div class="fila' . $i . '">' . ($reg[$i]["inscripcion"] == 1 ? 'Pendiente' : '<i class="fas fa-check-square text-green"></i>') . '</div>',
				"10" => '<div class="fila' . $i . '">' . $reg[$i]["conocio"] . '<br>' . $reg[$i]["contacto"] . '</div>',
				"11" => '<div class="fila' . $i . '">' . $reg[$i]["medio"] . '</div>'
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
		$data["1"] = ""; //iniciamos el arreglo
		$rspta = $oncenterpreinscrito->selectPeriodo();
		$data["0"] .= '<option value="">Seleccionar</option>';
		for ($i = 0; $i < count($rspta); $i++) {
			$data["0"] .= "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
		$data["1"] .= $i;
		$results = array($data);
		echo json_encode($results);
	break;

	case 'verHistorial':
		$id_estudiante = $_POST["id_estudiante"];
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$consulta1 = $oncenterpreinscrito->verHistorial($id_estudiante); // consulta para traer los interesados
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
										<dd>' . $oncenterpreinscrito->fechaesp($fecha_ingreso) . ' a las ' . $hora_ingreso . ' del ' . $periodo_ingreso . '</dd>
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
		$rspta = $oncenterpreinscrito->verHistorialTabla($id_estudiante);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $oncenterpreinscrito->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];
			$data[] = array(
				"0" => $reg[$i]["id_estudiante"],
				"1" => $reg[$i]["motivo_seguimiento"],
				"2" => $reg[$i]["mensaje_seguimiento"],
				"3" => $oncenterpreinscrito->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],
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
		$rspta = $oncenterpreinscrito->verHistorialTablaTareas($id_estudiante);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$datoasesor = $oncenterpreinscrito->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];
			$data[] = array(
				"0" => ($reg[$i]["estado"] == 1) ? 'Pendiente' : 'Realizada',
				"1" => $reg[$i]["motivo_tarea"],
				"2" => $reg[$i]["mensaje_tarea"],
				"3" => $oncenterpreinscrito->fechaesp($reg[$i]["fecha_programada"]) . ' a las ' . $reg[$i]["hora_programada"],
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
		$rspta = $oncenterpreinscrito->selectModalidadCampana();
		echo '<option value="">Seleccionar</option>';
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_modalidad_campana"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
	break;

	case 'verificarDocumento':
		$data = array();
		$data["estado"] = ""; //iniciamos el arreglo
		$data["coincidencia"] = ""; //iniciamos el arreglo
		$nuevodocumento = $_GET["nuevodocumento"];
		$rspta = $oncenterpreinscrito->nuevoDocumento($nuevodocumento);
		$id_estudiante = $rspta["id_estudiante"];
		if ($id_estudiante == "") { // quiere decir que el documento no existe
			$data["estado"] .= "0"; // quiere decir que no existe documento
			// actualizar documento y cambio de estado a preinscrito y sele actualiza el seguimiento a 1
			$actualizar = $oncenterpreinscrito->actualizarDocumento($id_estudiante_documento, $nuevodocumento, $modalidad_campana);
			/* ******************************** */
			$motivo = "Seguimiento";
			$mensaje_seguimiento = "Validación de documento";
			$regseguimiento = $oncenterpreinscrito->registrarSeguimiento($id_usuario, $id_estudiante_documento, $motivo, $mensaje_seguimiento, $fecha, $hora);
		} else {
			$data["coincidencia"] .= $id_estudiante;
			$data["estado"] .= "1"; // quiere decir que existe documento
		}
		echo json_encode($data);
	break;

	case "selectEstado":
		$rspta = $oncenterpreinscrito->selectEstado();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre_estado"] . "'>" . $rspta[$i]["nombre_estado"] . "</option>";
		}
	break;

	//case 'eliminar':
		//$id_estudiante = $_POST["id_estudiante"];
		//$rspta1 = $oncenterpreinscrito->eliminarDatos($id_estudiante);
		//$rspta2 = $oncenterpreinscrito->eliminarSeguimiento($id_estudiante);
		//$rspta3 = $oncenterpreinscrito->eliminarTareas($id_estudiante);
		//$rspta = $oncenterpreinscrito->eliminar($id_estudiante);
		//if ($rspta == 0) {
			//echo "1";
			//$estado = "Interesado";
			//$rspta4 = $oncenterpreinscrito->insertarEliminar($id_estudiante, $estado, $fecha, $hora, $id_usuario);
		//} else {
			//echo "0";
		//}
	//break;
	
	case "selectPrograma":
		$rspta = $oncenterpreinscrito->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
	break;

	case "selectJornada":
		$rspta = $oncenterpreinscrito->selectJornada();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
	break;

	case "selectTipoDocumento":
		$rspta = $oncenterpreinscrito->selectTipoDocumento();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
	break;

	case "selectNivelEscolaridad":
		$rspta = $oncenterpreinscrito->selectNivelEscolaridad();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
	break;

	case 'perfilEstudiante':
		$id_estudiante = $_POST["id_estudiante"];
		$rspta = $oncenterpreinscrito->perfilEstudiante($id_estudiante);
		echo json_encode($rspta);
	break;
	//se envia el correo al estudiante
	case 'correo':
		$id_estudiante = $_POST["id_estudiante"];
		$identificacion = $_POST["identificacion"];
		$data = array(); //Vamos a declarar un array
		$data["resultado"] = "";
		// actualiza el estado del envio del mail al estudiante.
		$rspta = $oncenterpreinscrito->actualizarMailing($id_estudiante);
		$data["resultado"] .= $rspta ? "1" : "0";
		$motivo = "Seguimiento";
		$mensaje_seguimiento = "Envio de mailing, usuario y clave";
		// registra el seguimiento 
		$ressegui = $oncenterpreinscrito->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);
		$correo = $oncenterpreinscrito->VerHistorial($id_estudiante);
		$correo_personal_enviar = $correo["email"];
		$identificacion = $correo["identificacion"];
		$clave = $correo["id_estudiante"];
		$mensaje = set_template_preinscrito($identificacion,$clave);
		enviar_correo($correo_personal_enviar, "Bienvenido a CIAF", $mensaje);
		echo json_encode($data);
	break;

	case 'cambiarEtiqueta':
        
        $id_estudiante = $_POST['id_estudiante'];
        $valor = $_POST['valor'];

        $rspta = $oncenterpreinscrito->cambiarEtiqueta($id_estudiante,$valor);

        if ($rspta == 0) {
			echo "1";
		} else {

			echo "0";
		}

    break;
}