<?php
session_start();
require_once "../modelos/Especial_Es.php";

date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:s');

$especial = new Especial();


$cedula_estu = isset($_POST["cedula_estu"]) ? limpiarCadena($_POST["cedula_estu"]) : "";
// variable para llenar el formulario del estudiante
$id_credencial_oculto = isset($_POST["id_credencial_oculto"]) ? limpiarCadena($_POST["id_credencial_oculto"]) : "";
$id_credencial_guardar_estudiante = isset($_POST["id_credencial_guardar_estudiante"]) ? limpiarCadena($_POST["id_credencial_guardar_estudiante"]) : "";
//Filtra la cedula del estudiante.
$cedula = isset($_POST["cedula"]) ? limpiarCadena($_POST["cedula"]) : "";
// variables para formulario perfil estudiante.
$cedula_estudiante = isset($_POST["cedula_estudiante"]) ? limpiarCadena($_POST["cedula_estudiante"]) : "";
$credencial_nombre = isset($_POST["credencial_nombre"]) ? limpiarCadena($_POST["credencial_nombre"]) : "";
$credencial_nombre_2 = isset($_POST["credencial_nombre_2"]) ? limpiarCadena($_POST["credencial_nombre_2"]) : "";
$credencial_apellido = isset($_POST["credencial_apellido"]) ? limpiarCadena($_POST["credencial_apellido"]) : "";
$credencial_apellido_2 = isset($_POST["credencial_apellido_2"]) ? limpiarCadena($_POST["credencial_apellido_2"]) : "";
$credencial_login = isset($_POST["credencial_login"]) ? limpiarCadena($_POST["credencial_login"]) : "";

$op = (isset($_GET['op'])) ? $_GET['op'] : 'mostrar';
switch ($op) {

	
	case 'verificar':
		// dato que llega en el filtro
		$dato = $_POST["dato"];
		// tipo de dato(Indentificación, correo, celular)
		$tipo = $_POST["tipo"];
		// $id_credencial_seleccionado = $_POST["id_credencial_seleccionado"]; #id_credencial seleccionado por la tabla

		$valor_seleccionado = '';
		if ($tipo == "1") {
			$valor_seleccionado = 'credencial_identificacion = ' . $dato;
		}
		if ($tipo == "2") {
			$valor_seleccionado = "`credencial_estudiante`.`credencial_login` = '" . $dato . "'";
		}
		if ($tipo == "3") {
			$valor_seleccionado = 'celular = ' . $dato;
		}

		if ($tipo == "4") {
			$valor_seleccionado = "`credencial_estudiante`.`credencial_nombre` LIKE '" . $dato . "' OR `credencial_nombre_2` LIKE '" . $dato . "'";
		}


		// consulta para validar el estudiante si esta registrado 
		$verificar_cedula = $especial->verificarDocumento($valor_seleccionado);
		if (is_array($verificar_cedula)) {
			$data = array("exito" => 1, "info" => $verificar_cedula);
			$informacion_carrera = $especial->cargarInformacion($verificar_cedula['id_credencial']);
			$fo_programa_general = "";
			$fo_programa_idiomas = "";
			foreach ($informacion_carrera as $programa) {
				if (strpos($programa['fo_programa'], "Idiomas") !== false) {
					$fo_programa_idiomas .= '<div class="col-auto borde py-2">' . $programa['fo_programa'] . '</div>';
				} else {
					$fo_programa_general .= '<div class="col-auto borde py-2">' . $programa['fo_programa'] . '</div>';
				}
			}
			$fo_programa = '	
				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-12 text-semibold fs-14 titulo-2">Programas Generales</div>
							' . $fo_programa_general . '
						</div>
					</div>
					<div class="col-sm-12">
						<div class="row">
							<div class="col-12 text-semibold fs-14 titulo-2">Escuela de idiomas</div>
							' . $fo_programa_idiomas . '
						</div>
					</div>
				</div>';

			$data["info"]["fo_programa"] = $fo_programa;
		} else {
			$data = array("exito" => 0, "info" => "El estudiante no existe");
		}
		echo json_encode($data);
		break;

		case 'listar_datos_estudiantes':
			$idCredencial = isset($_GET['id_credencial']) ? $_GET['id_credencial'] : null; #idcredencial estudiante
			$valor = isset($_GET['valor_global']) ? $_GET['valor_global'] : null; #dependiendo del número trae los datos
			$dato = isset($_GET['dato']) ? $_GET['dato'] : null; #palabra buscada en el filtro
			if ($valor == "4") {
				$registro = $especial->buscar_por_nombre($dato);
			} else {
				$registro = $especial->trae_id_credencial($idCredencial);
			}
			$data = array();
			for ($i = 0; $i < count($registro); $i++) {
				$id_credencial_seleccionado = $registro[$i]['id_credencial'];
				$data[] = array(
					'0' => '<button onclick="cambiarEstadoEspecial(' . $id_credencial_seleccionado . ')" title="Marcar caso" class="btn btn-warning btn-xs"><i class="fas fa-person-rays"></i></button> ' . $registro[$i]['credencial_identificacion'],
					'1' => $registro[$i]['credencial_apellido'] . ' ' . $registro[$i]['credencial_apellido_2'],
					'2' => $registro[$i]['credencial_nombre'] . ' ' . $registro[$i]['credencial_nombre_2']
				);
			}
	
			$results = array(
				"sEcho" => 1, //Información para el datatables
				"iTotalRecords" => count($data), //total registros
				"iTotalDisplayRecords" => count($data), //total registros a visualizar
				"aaData" => $data
			);
			echo json_encode($results);
			break;
	
		case 'cambiar_estado_especial':
			$id_credencial = $_POST["id_credencial"];
			$resultado = $especial->cambiarEstadoEspecial($id_credencial);
			echo json_encode(["resultado" => $resultado ? "exito" : "error"]);
			break;


			case 'listarescuelas':
				$data = array(); //Vamos a declarar un array
				$data["mostrar"] = ""; //iniciamos el arreglo
				$data["mostrar"] .= '
					<div class="row">
						<div class="col-12 pl-4 pt-2">
							<p class="titulo-2 fs-14">Buscar por:</p>
						</div>
						<div class="col-12 pl-4 mb-2">
							<div class="row">';
									
							$traerescuelas = $especial->listarescuelas();
								for ($a = 0; $a < count($traerescuelas); $a++) {
		
									
									$escuela = $traerescuelas[$a]["escuelas"];
									$color = $traerescuelas[$a]["color"];
									$color_ingles = $traerescuelas[$a]["color_ingles"];
									$nombre_corto = $traerescuelas[$a]["nombre_corto"];
									$id_escuelas = $traerescuelas[$a]["id_escuelas"];
		
									if( $id_escuelas==4){
		
									}else{
										
										$data["mostrar"] .= '
		
										<div style="width:170px">
											<a onclick="listar(' . $id_escuelas . ')" title="ver Estudiantes" class="row pointer m-2">
												<div class="col-3 rounded bg-light-'.$color_ingles.'">
													<div class="text-red text-center pt-1">
														<i class="fa-regular fa-calendar-check fa-2x  text-'.$color_ingles.'" ></i>
													</div>
													
												</div>
												<div class="col-9 borde">
													<span>Escuela de</span><br>
													<span class="titulo-2 fs-12 line-height-16"> ' . $nombre_corto . '</span>
												</div>
											</a>
										</div>';
									}
										
								}
		
							$data["mostrar"] .= '
						</div>
					</div>
				</div>
		
					
					';
				echo json_encode($data);
			break;
	

			case 'listar':
				// Se toman las variables que vienen del get del datatable
				$id_escuela = $_GET['id_escuela'];
				// Se carga el periodo anterior que será el principal 
				// filtro de búsqueda de estudiantes a renovar
				$cargar_periodo = $especial->cargarPeriodo();
				$periodo_anterior = $cargar_periodo['periodo_anterior'];
			
				// Se trae la información de la tabla estudiantes para 
				// verificar en las otras tablas según el filtro
				$listar_estudiantes = $especial->listar($id_escuela, $periodo_anterior);
				$resultado = $listar_estudiantes;
			
				// Bucle para recorrer el resultado de la consulta listar()
				$data = [];
				for ($i = 0; $i < count($resultado); $i++) {
					$id_credencial_seleccionado = $resultado[$i]['id_credencial'];
					$nom_escuela = $especial->traer_nom_escuela($resultado[$i]["escuela"]);
					$nom_programa = $especial->traer_nom_programa($resultado[$i]["programa"]);
			
					if ($resultado[$i]["escuela"] == '4' || ($resultado[$i]["nivel"] == 3 && $resultado[$i]["graduado"] == 0) || ($resultado[$i]["nivel"] == 7 && $resultado[$i]["graduado"] == 0)) {
						// Excluir idiomas
					} else {
						// Asignar nivel
						switch ($resultado[$i]["nivel"]) {
							case 1:
								$nivelTexto = "Técnico";
								break;
							case 2:

								$nivelTexto = "Tecnólogo";
								break;
							case 3:
								$nivelTexto = "Profesional";
								break;
							case 5:
								$nivelTexto = "Nivelatorios";
								break;
							case 7:
								$nivelTexto = "Laborales";
								break;
							default:
								$nivelTexto = "Desconocido"; // Para valores no reconocidos
								break;
						}
				

						$marcar_caso =  '<button onclick="desmarcar(' .$id_credencial_seleccionado . ')" title="Desmarcar caso" class="btn  bg-lightblue btn-xs"><i class="fas fa-person-circle-minus""></i></button> ';
						$data[] = array(
							"0"=>$marcar_caso. $tareas .  $anadir . $boton_whatsapp,
							"1" => $resultado[$i]["credencial_identificacion"],
							"2" => $resultado[$i]["credencial_apellido"] . ' ' . $resultado[$i]["credencial_apellido_2"] . ' ' . $resultado[$i]["credencial_nombre"] . ' ' . $resultado[$i]["credencial_nombre_2"],
							"3" => $nom_programa["nombre"],
							"4" => $nivelTexto,
							"5" => $estadotermino,
							"6" => $resultado[$i]["jornada_e"],
							"7" => $resultado[$i]["semestre"],
							"8" => $resultado[$i]["email"],
							"9" => $resultado[$i]["celular"],
							"10" => $resultado[$i]["periodo"],
							"11" => 'Esc ' . @$nom_escuela["escuelas"]
						);
					}
				}
				// Enviar los resultados al datatable
				$data = isset($data) ? $data : array();
				$results = array(
					"sEcho" => 1, // Información para el datatables
					"iTotalRecords" => count($data), // Total registros al datatable
					"iTotalDisplayRecords" => count($data), // Total registros a visualizar
					"aaData" => $data
				);
				echo json_encode($results);
				break;
			

				case 'desmarcar':
					$id_credencial = $_POST["id_credencial"];
					$resultado = $especial->desmarcar($id_credencial);
					echo json_encode(["resultado" => $resultado ? "exito" : "error"]);
					break;
		
		

	case 'listar_especiales_matriculados':
        $registros = $especial->listarEspecialesMatriculados();
        $data = array();
        for ($i = 0; $i < count($registros); $i++) {
            $id_credencial = $registros[$i]['id_credencial'];
            $nombre = $registros[$i]['credencial_nombre'];
            $apellido = $registros[$i]['credencial_apellido'];
            $identificacion = $registros[$i]['credencial_identificacion'];
            $boton = '<button onclick="cambiarEstadoEspecial(' . $id_credencial . ')" title="Marcar caso" class="btn btn-warning btn-xs"><i class="fas fa-person-rays"></i></button>';
            $data[] = array(
                $boton,
                $identificacion,
                $nombre,
                $apellido
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

}
