<?php
date_default_timezone_set("America/Bogota");
session_start();
require_once "../modelos/Header_Estudiante.php";
require "../public/phpqrcode/qrlib.php";
$headerestudiante = new Header_Estudiante();
$id_credencial = $_SESSION["id_usuario"];
$fecha = date('Y-m-d');
$hora = date('H:i:s');
/* ************************** encuesta *********************** */
$pre1 = isset($_POST["pre1"]) ? limpiarCadena($_POST["pre1"]) : "";
$pre2 = isset($_POST["pre2"]) ? limpiarCadena($_POST["pre2"]) : "";
$pre3 = isset($_POST["pre3"]) ? limpiarCadena($_POST["pre3"]) : "";
$pre4 = isset($_POST["pre4"]) ? limpiarCadena($_POST["pre4"]) : "";
$pre5 = isset($_POST["pre5"]) ? limpiarCadena($_POST["pre5"]) : "";
$pre6 = isset($_POST["pre6"]) ? limpiarCadena($_POST["pre6"]) : "";
$pre7 = isset($_POST["pre7"]) ? limpiarCadena($_POST["pre7"]) : "";
/* ************************** encuesta *********************** */
switch ($_GET['op']) {
	case 'verificarcaracterizacion':
        $data = array(); //Vamos a declarar un arra
		$data["seres"] = ""; //iniciamos el arregloy
		$data["insp"] = ""; //iniciamos el arreglo
		$data["empresas"] = ""; //iniciamos el arreglo
		$data["confiamos"] = ""; //iniciamos el arreglo
		$data["exp"] = ""; //iniciamos el arreglo
		$data["bienestar"] = ""; //iniciamos el arreglo

		    $rspta1=$headerestudiante->verificarseres($id_credencial);
			$data["seres"] = $rspta1 ? '1' : '0';
			$rspta2=$headerestudiante->verificarinspiradores($id_credencial);
			$data["insp"] = $rspta2 ? '1' : '0';
			$rspta3=$headerestudiante->verificarempresas($id_credencial);
			$data["empresas"] = $rspta3 ? '1' : '0';
			$rspta4=$headerestudiante->verificarconfiamos($id_credencial);
			$data["confiamos"] = $rspta4 ? '1' : '0';
			$rspta5=$headerestudiante->verificarexp($id_credencial);
			$data["exp"] = $rspta5 ? '1' : '0';
			$rspta6=$headerestudiante->verificarbienestar($id_credencial);
			$data["bienestar"] = $rspta6 ? '1' : '0';
        
			$results = array($data);
			echo json_encode($results);

		
	break;
	case 'verificar_veedor':
		$datos = $headerestudiante->verificar_veedor($_SESSION['id_usuario']);
		if (isset($datos["id_credencial"])) {
			$data = array("exito" => 1);
		} else {
			$data = array("exito" => 0);
		}
		echo json_encode($data);
		break;
	case 'listarTema':
		$datos = $headerestudiante->listarTema($id_credencial);
		$modo_ui = $datos["modo_ui"];

		$data['conte'] = $modo_ui;
		echo json_encode($data);

	break;

	case 'heteroevaluacion':
		$data = array(); //Vamos a declarar un arra
		$data["estado"] = ""; //iniciamos el arregloy
		$data["conte"] = ""; //iniciamos el arreglo
		$data["egresado"] = ""; //iniciamos el arreglo
		$data["jornada"] = ""; //iniciamos el arreglo

		$estado_evaluacion = $headerestudiante->verificarEstadoEvaluacion();// mira si la evaluacion esta activa
		$estado=$estado_evaluacion["estado"];
		$terminoeva =$headerestudiante->verificarCalificaciones($_SESSION['id_usuario']);//mira si termino la evaluacion
		$egresado =$headerestudiante->egresadaperiodoactual($_SESSION['id_usuario']) ? 'no' : 'si';//mira si es egresado en este periodo
		$datosestudiante=$headerestudiante->egresadaperiodoactual($_SESSION['id_usuario']);

		if($estado==1 && empty($terminoeva)){// quiere decir activa
			$data["estado"] .= 1;
			$_SESSION['status_titulaciones'] = 1;
		}else{
			$data["estado"] .= 0; //inactiva
		}

		$data["jornada"] = $datosestudiante["jornada_e"];

		$data["egresado"]=$egresado;

		$results = array($data);
		echo json_encode($results);
	break;

	case 'menu_titulaciones':
		$data = array(); //Vamos a declarar un array
		$data["programas"] = ""; //iniciamos el arreglo
		$data["num"] = ""; //iniciamos el arreglo
		$data["pro"] = ""; //nombre del programa
		$data["campus"] = "Egresado"; //nombre del programa en campus

		$dato = $headerestudiante->listartitulaciones($_SESSION['id_usuario']);
		$data["num"] = count($dato); // tiene el numero de programas activos
		for ($k = 0; $k < count($dato); $k++) { // muestra el programa en el ménu
			$nombredelprogramaterminal = $headerestudiante->nombredelprogramaterminal($dato[$k]["id_programa_ac"]); // trae el programa terminal 
			$data["programas"] .=
				'
					<a href="estudiante.php?id=' . $dato[$k]["id_estudiante"] . '&ciclo=' . $dato[$k]["ciclo"] . '&id_programa=' . $dato[$k]["id_programa_ac"] . '&grupo=' . $dato[$k]["grupo"] . '" class="nav-link" title="' . $nombredelprogramaterminal["nombre"] . '">
						<span>' . $nombredelprogramaterminal["original"] . '</span>
					</a>
				';
				if($dato[$k]["ciclo"]==3 or $dato[$k]["ciclo"]==2 or $dato[$k]["ciclo"]==1){
					$data["pro"] .= $nombredelprogramaterminal["carnet"];
					$data["campus"] = $nombredelprogramaterminal["campus"];
				}else{
					$data["pro"] .= "";
				}
		}
		$results = array($data);
		echo json_encode($results);
	break;
	case 'menu_titulaciones2':
		$data = array(); //Vamos a declarar un array
		$data["0"] = ""; //iniciamos el arreglo
		$data["1"] = ""; //contiene la cantidad de programas matriculados
		$data["2"] = ""; //muestra los progrmas matriculados para el menu del estudiante
		//almacena la cantidad de materias que el estudiante tiene matriculadas
		$matriculadas = 0;
		$matriculadas_docente = 0;
		//acumula las materias que ya hayan sido evaluadas por el estudiante
		$evaluadas = 0;
		$terminadas_evaluacion_docente = 0;
		//trae los programas activos de el estudiante en session
		$consulta_programas = $headerestudiante->consulta_programas($_SESSION['id_usuario']);
		//ciclo por cada programa que tenga activo
		for ($i = 0; $i < count($consulta_programas); $i++) {
			//almacenamos el id
			$id_estudiante = $consulta_programas[$i]['id_estudiante'];
			//almacenamos el ciclo
			$ciclo = $consulta_programas[$i]['ciclo'];
			//almacenamos el grupo
			$grupo = $consulta_programas[$i]['grupo'];
			//consultamos las materia del estudiante activas por cada curso
			$consulta_materias = $headerestudiante->consulta_materias($id_estudiante, $ciclo); // trae las materias matriculadas
			//ciclo por las materias matriculadas
			for ($j = 0; $j < count($consulta_materias); $j++) {
				//almacenamos el nombre de la materia
				$nombre_materia = $consulta_materias[$j]['nombre_materia'];
				//almacenamos LA JORNADA de la materia
				$jornada = $consulta_materias[$j]['jornada'];
				//almacenamos el semestre
				$semestre = $consulta_materias[$j]['semestre'];
				//almacenamos el programa
				$programa = $consulta_materias[$j]['programa'];
				//consultamos el docente grupo que tiene asignada esa materia
				//$data[4] = "$nombre_materia, $jornada, $semestre, $programa, $grupo";
				$consulta_grupo = $headerestudiante->consulta_grupo($nombre_materia, $jornada, $semestre, $programa, $grupo); // trae los datos del docente grupo
				//almacenamos el id del docente
				@$id_docente = $consulta_grupo["id_docente"];
				//almacenamos el id de la tabla docente_grupos
				@$id_docente_grupo = $consulta_grupo["id_docente_grupo"];
				//almacenamos el estado del docente_grupo
				@$estado = $consulta_grupo["estado"];
				$data["5"] = "$nombre_materia, $jornada, $semestre, $programa, $grupo";
				// tomamos la cantidad de las materias matriculadas del estudiante
				$matriculadas_docente++;
				$consulta_evaluacion_docente = $headerestudiante->consulta_evaluacion_docente($id_estudiante, $id_docente, $id_docente_grupo); //trae las materias evaluadas 
				//si ya lo evaluo, sumamos al contador de materias evaluadas
				// var_dump($consulta_evaluacion_docente);
				if ($consulta_evaluacion_docente) { //si evaluo asigantura que sume
					$terminadas_evaluacion_docente++;
				}
				//si el estado es uno quiere decir que la materia esta matriculada
				if ($estado == 1) {
					//sumamos a la cuenta de matriculadas
					$matriculadas++;
					//consultamos si el estudiante ya evaluo a ese docente por la materia especifica
					$consulta_heteroevaluacion = $headerestudiante->consulta_heteroevaluacion($id_estudiante, $id_docente, $id_docente_grupo); //trae las materias evaluadas 
					//si ya lo evaluo, sumamos al contador de materias evaluadas
					if ($consulta_heteroevaluacion) { //si evaluo asigantura que sume
						$evaluadas++;
					}
				}
			}
		}
		//LO ACTIVO CUANDO ACTIVO LA EVALUACIÓN DOCENTE, para activar la evaluación docente toca cambiar el estado a 0 de la tabla docente grupos
		//si la cantidad de materias NO son igual a la cantidad de evaluadas entonces tenemos que listar las que tiene que evaluar
		$estado_evaluacion = $headerestudiante->verificarEstadoEvaluacion()["estado"];
		//LO ACTIVO CUADO NO TENEMOS EVALUACIÓN DOCENTE
		$dato = $headerestudiante->listartitulaciones($_SESSION['id_usuario']);
		if ($estado_evaluacion == 1) {
			$data["estado_evaluacion_estudiante"] = 1; // Heteroevaluación activa
			if ($matriculadas == $evaluadas) {
				$data["evaluacion_docente_finalizada"] = 1; // Finalizo la evaluacion
				$_SESSION['status_titulaciones'] = 0;
			} else {
				$data["evaluacion_docente_finalizada"] = 0; // Faltan evaluaciones
				$_SESSION['status_titulaciones'] = 1;
			}
		}else{
			$data["estado_evaluacion_estudiante"] = 0; // Heteroevaluación inactiva
		}
		// // Guardamos el estado de la evaluación docente preguntas bienestar si esta activada o no 
		// $estado_evaluacion_docente = $headerestudiante->verificarEstadoEvaluacionDocente()["estado"];
		// //guardamos el valor del estado de la evaluacion docente 
		// $data["estado_evaluacion_docente"] = $estado_evaluacion_docente;
		// // contamos el total de las materias evaluadas por el estudiante en la tabla encuesta_evaluacion
		// $data["terminadas_evaluacion_docente"] = $terminadas_evaluacion_docente;
		// // Si la evaluación preguntas bienestar está activa (estado == 1)
		// if ($estado_evaluacion_docente == 1) {
		// 	// validamos de que el estudiante realizo todas las evaluaciones
		// 	if ($matriculadas_docente == $terminadas_evaluacion_docente) {
		// 		// si fue asi se crea la variable evalaucion_docente_finalizada con 1 para saber que el estudiante completo la evaluacion
		// 		$data["evaluacion_docente_finalizada"] = 1; // finalizo la evaluacion
		// 		$_SESSION['status_titulaciones_docente'] = 0; //variable para el permiso de la vista 
		// 	} else {
		// 		// en caso de que falten preguntas de la evaluacion por responder entra aqui
		// 		$data["evaluacion_docente_finalizada"] = 0; //pendiente por terminar
		// 		$_SESSION['status_titulaciones_docente'] = 1; //variable para el permiso de la vista 
		// 	}
		// }
		$data["1"] = count($dato); // tiene el numero de programas activos=
		for ($k = 0; $k < count($dato); $k++) { // muestra el programa en el ménu
			$nombredelprogramaterminal = $headerestudiante->nombredelprogramaterminal($dato[$k]["id_programa_ac"]); // trae el programa terminal 
			$data["2"] .=
				'<li class="nav-item">
					<a href="estudiante.php?id=' . $dato[$k]["id_estudiante"] . '&ciclo=' . $dato[$k]["ciclo"] . '&id_programa=' . $dato[$k]["id_programa_ac"] . '&grupo=' . $dato[$k]["grupo"] . '" class="nav-link" title="' . $nombredelprogramaterminal["original"] . '">
						<span>' . $nombredelprogramaterminal["original"] . '</span>
					</a>
				</li>';
		}
		$results = array($data);
		echo json_encode($results);
	break;

	case 'generarqr':
		$rst = $headerestudiante->consultaestudiante();
		$tempDir = "../temp/";
		// we need to generate filename somehow, 
		$codeContents = base64_encode($rst['credencial_identificacion']);
		// with md5 or with database ID used to obtains $codeContents...
		$fileName = base64_encode($rst['credencial_identificacion']) . '.png';
		$pngAbsoluteFilePath = $tempDir . $fileName;
		// generating
		if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_Q, 5, 1);
		}
		$logo = "../public/img/logo_qr.png";
		$originalQR = @imagecreatefrompng($pngAbsoluteFilePath);
		$logoYT = @imagecreatefrompng($logo);
		$dataQR = getimagesize($pngAbsoluteFilePath);
		$dataYT = getimagesize($logo);
		list($width, $height) = getimagesize($pngAbsoluteFilePath);
		list($ytwidth, $ytheight) = getimagesize($logo);
		$newQR = imagecreatetruecolor($width, $height);
		imagecopy($newQR, $originalQR, 0, 0, 0, 0, $width, $height);
		imagecopy($newQR, $logoYT, round(($width / 2) - ($ytwidth / 2)), round(($height / 2) - ($ytheight / 2)), 0, 0, $ytwidth, $ytheight);
		imagepng($newQR, $pngAbsoluteFilePath, 0);
		$data['status'] = "ok";
		$data['conte'] = '<img src="' . $pngAbsoluteFilePath . '" style="width:250px">';
		echo json_encode($data);
		break;
	case 'encuentaEstDigital':
		$credencial =  $_SESSION["id_usuario"];
		$consulta = $headerestudiante->encuentaEstDigital($credencial);
		$resultado = $consulta ? 1 : 2;
		echo json_encode($resultado);
		break;
	case "guardarencuentaEstDigital":
		$credencial =  $_SESSION["id_usuario"];
		$rspta = $headerestudiante->insertarencuesta($credencial, $fecha, $hora, $pre1, $pre2, $pre3, $pre4, $pre5, $pre6, $pre7);
		if ($rspta == true) {
			$data["estado"] = "1";
		} else {
			$data["estado"] = "2";
		}
		echo json_encode($data);
		break;
	case "guardarConfirmacionVeedor":
		$credencial =  $_SESSION["id_usuario"];
		$rspta = $headerestudiante->guardarConfirmacionVeedor($credencial);
		if ($rspta) {
			$data["exito"] = 1;
		} else {
			$data["exito"] = 0;
		}
		echo json_encode($data);
		break;
	case "guardarencuentaEstDigitalNo":
		$credencial =  $_SESSION["id_usuario"];
		$pre1 = "no";
		$pre2 = Null;
		$pre3 = Null;
		$pre4 = Null;
		$pre5 = Null;
		$pre6 = Null;
		$pre7 = Null;

		$rspta = $headerestudiante->insertarencuesta($credencial, $fecha, $hora, $pre1, $pre2, $pre3, $pre4, $pre5, $pre6, $pre7);
		if ($rspta == true) {
			$data["estado"] = "1";
		} else {
			$data["estado"] = "2";
		}
		echo json_encode($data);
		break;
	case "listarPuntos":
		$credencial =  $_SESSION["id_usuario"];
		$rspta = $headerestudiante->listarPuntos($credencial);
		if ($rspta) {
			$data["exito"] = $rspta["puntos"];
			
		} else {
			$data["exito"] = "error";
			
		}
		$data["nivel"] ='
		<div class="col-10 next-level p-4">
			<h2 class="fs-18 text-white">Nivel actual</h2>
			<div class="col-12 text-center"><i class="fas fa-star fa-4x text-primary"></i> <span class="text-white next-numero fs-32">'.$rspta["nivel"].'</span></div>
			<div class="col-12 py-2">
				<span class="text-white">Total: </span><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:18px;height:18px"> <span class="text-danger font-weight-bolder"> '.$rspta["puntos"].' pts</span>
			</div>
			<div class="col-12">
				<div class="row">
					<div class="col-8">
						<div class="progress">
							<div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<p class="text-white small line-height-16">Siguiente nivel <span class="font-weight-bolder">10.000 pts</span></p>
					</div>
					<div class="col-4">
						<i class="fas fa-star fa-3x text-warning"></i><span class="text-white next-numero fs-22">2</span>
					</div>
				</div>
			</div>
		</div>';

		echo json_encode($data);
	break;
}
