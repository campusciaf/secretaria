<?php
session_start();
require_once "../modelos/MatriculaConfigurar.php";

$matriculaconfigurar = new MatriculaConfigurar();

$credencial_usuario = $_SESSION['usuario_cargo']; // trae la sesion del cargo del usuario

date_default_timezone_set("America/Bogota");
$credencial_fecha = date('Y-m-d-H:i:s');

$id_credencial = isset($_POST["id_credencial"]) ? limpiarCadena($_POST["id_credencial"]) : "";
$credencial_nombre = isset($_POST["credencial_nombre"]) ? limpiarCadena($_POST["credencial_nombre"]) : "";
$credencial_nombre_2 = isset($_POST["credencial_nombre_2"]) ? limpiarCadena($_POST["credencial_nombre_2"]) : "";
$credencial_apellido = isset($_POST["credencial_apellido"]) ? limpiarCadena($_POST["credencial_apellido"]) : "";
$credencial_apellido_2 = isset($_POST["credencial_apellido_2"]) ? limpiarCadena($_POST["credencial_apellido_2"]) : "";
$credencial_login = isset($_POST["credencial_login"]) ? limpiarCadena($_POST["credencial_login"]) : "";

$fo_programa = isset($_POST["fo_programa"]) ? limpiarCadena($_POST["fo_programa"]) : "";
$jornada_e = isset($_POST["jornada_e"]) ? limpiarCadena($_POST["jornada_e"]) : "";
$grupo = isset($_POST["grupo"]) ? limpiarCadena($_POST["grupo"]) : "";

switch ($_GET["op"]) {

	case 'guardaryeditar':

		$credencial_identificacion = $_GET["credencial_identificacion"];
		$credencial_clave = md5($credencial_identificacion);

		$rspta = $matriculaconfigurar->insertar($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave, $credencial_usuario, $credencial_fecha);


		$data["0"] = $rspta ? "Estudiante registrado(a) " : "No se pudo registrar el estudiante";

		$rspta = $matriculaconfigurar->traeridcredencial($credencial_identificacion);
		$data["1"] = $rspta["id_credencial"]; // trae el id credencial del que se acabo de regsitrar

		$insertardatosestudainte = $matriculaconfigurar->insertardatosestudiante($rspta["id_credencial"]);

		$results = array($data);
		echo json_encode($results);

		break;
	case 'guardaryeditar2':
		$periodo_activo = $_SESSION['periodo_actual'];
		$id_credencial = $_GET["id_credencial"];


		$rspta1 = $matriculaconfigurar->mostrarescuela($fo_programa);
		$escuela_ciaf = $rspta1["escuela"];
		$id_programa_ac = $rspta1["id_programa"];
		$ciclo = $rspta1["ciclo"];
		$admisiones = "no";

		$rspta = $matriculaconfigurar->insertarnuevoprograma($id_credencial, $id_programa_ac, $fo_programa, $jornada_e, $escuela_ciaf, $periodo_activo, $ciclo, $periodo_activo, $grupo, $admisiones);

		echo $rspta ? "Nuevo programa registrado(a) " : "No se pudo registrar el nuevo programa";


		break;
	case 'verificardocumento':
		$credencial_identificacion = $_POST["credencial_identificacion"];
		$rspta = $matriculaconfigurar->verificardocumento($credencial_identificacion);
		//Vamos a declarar un array
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
		$rspta = $matriculaconfigurar->listar($id_credencial);
		//Vamos a declarar un array
		$arreglo_datos = array();
		$arreglo_jornadas = array();
		$arreglo_periodos = array();
		$arreglo_periodos_activos = array();


		$arreglo_jornadas = $matriculaconfigurar->cargarJornadas();
		$arreglo_datos = $matriculaconfigurar->cargarEstadosAcademicos();
		$arreglo_grupos = $matriculaconfigurar->cargarGrupos();
		$arreglo_periodos = $matriculaconfigurar->cargarPeriodos();
		$arreglo_periodos_activos = $matriculaconfigurar->cargarPeriodos();

		$data = array();
		$a = 0;
		$b = 0;
		$c = 0;
		$d = 0;
		$e = 0;
		$i = 0;
		$p = 0;
		$k = 0;
		$f = 0;
		$s = 0;
		$v = 0;

		
		while ($i < count($rspta)) {
			$option = '';
			if ($rspta[$i]["estado"] == 2) {
				$option .= '<option value="2" selected>Graduado</option> ';
			} else {
				$option .= '<select name="estado_academico" id="estado_academico" onchange="cambiarEstado(this.value,' . $rspta[$i]["id_estudiante"] . ',' . $rspta[$i]["id_credencial"] . ',' . $rspta[$i]["id_programa_ac"] . ',' . $rspta[$i]["ciclo"] . ')" >';
				while ($a < count($arreglo_datos)) {
					if ($rspta[$i]["estado"] == $arreglo_datos[$a]['id_estado_academico']) {

						$option .= '<option value="' . $arreglo_datos[$a]['id_estado_academico'] . '" selected>' . $arreglo_datos[$a]['estado'] . '</option>';
					} else {
						$option .= '<option value="' . $arreglo_datos[$a]['id_estado_academico'] . '" d-none>' . $arreglo_datos[$a]['estado'] . '</option>';
					}
					$a++;
				}
				$option .= '</select>';
			}
			$a = 0;

			$option_grupo = '';
			if ($rspta[$i]["estado"] == 2) {
				$option_grupo .= $rspta[$i]['grupo'];
				
			} 
			else {

				$option_grupo .= '<select name="grupo_academico" onchange="cambiarGrupo(this.value,' . $rspta[$i]["id_estudiante"] . ')" id="grupo_academico">';

				while ($b < count($arreglo_grupos)) {

					if ($rspta[$i]['grupo'] == $arreglo_grupos[$b]['id_grupo']) {
						$option_grupo .= '<option value="' . $arreglo_grupos[$b]['id_grupo'] . '" selected >' . $arreglo_grupos[$b]['grupo'] . '</option>';
					} else {
						$option_grupo 
						.= '<option value="' . $arreglo_grupos[$b]['id_grupo'] . '"d-none>' . $arreglo_grupos[$b]['grupo'] . '</option>';
						
					}
					$b++;
				}
				$option_grupo .= '</select>';
			}
			$b = 0;

			if ($rspta[$i]["estado"] == 2) {
				$option_jornada = $rspta[$i]['jornada_e'];
			} else {
				$option_jornada = '<select name="jornada_e" onchange="cambiarJornada(this.value,' . $rspta[$i]["id_estudiante"] . ')" id="jornada_e">';
				while ($c < count($arreglo_jornadas)) {
					if ($rspta[$i]['jornada_e'] == $arreglo_jornadas[$c]['nombre']) {
						$option_jornada .= '<option value="' . $arreglo_jornadas[$c]['nombre'] . '" selected >' . $arreglo_jornadas[$c]['nombre'] . '</option>';
					} else {
						$option_jornada .= '<option value="' . $arreglo_jornadas[$c]['nombre'] . '" d-none>' . $arreglo_jornadas[$c]['nombre'] . '</option>';
					}
					$c++;
				}
				$option_jornada .= '</select>';
			}
			$c = 0;

			$option_periodo_activo = '';
			if ($rspta[$i]["estado"] == 2) {

				$option_periodo_activo = $rspta[$i]["periodo_activo"];
			} else {

				
				$option_periodo_activo .= '<select name="periodo_activo" id="periodo_activo" onchange="cambiarPeriodoActivo(this.value,' . $rspta[$i]["id_estudiante"] . ')" >';
				while ($e < count($arreglo_periodos_activos)) {
					if ($rspta[$i]["periodo"] == $arreglo_periodos[$e]['periodo']) {

						$option_periodo_activo .= '<option value="' . $arreglo_periodos_activos[$e]['periodo'] . '" selected >' . $arreglo_periodos_activos[$e]['periodo'] . '</option>';
					} else {
						$option_periodo_activo .= '<option value="' . $arreglo_periodos_activos[$e]['periodo'] . '"d-none>' . $arreglo_periodos_activos[$e]['periodo'] . '</option>';

						
					}
					$e++;
				}
				$option_periodo_activo .= '</select>';
			}
			$e = 0;

			$option_periodo = '';
			if ($rspta[$i]["estado"] == 2) {

				$option_periodo = $rspta[$i]["periodo"];
			} else {
				$option_periodo .= '<select name="periodo_ingreso" id="periodo_ingreso" onchange="cambiarPeriodo(this.value,' . $rspta[$i]["id_estudiante"] . ')" >';
				while ($d < count($arreglo_periodos)) {
					if ($rspta[$i]["estado"] == $arreglo_periodos[$d]['periodo']) {

						$option_periodo .= '<option value="' . $arreglo_periodos[$d]['periodo'] . '" selected>' . $arreglo_periodos[$d]['periodo'] . '</option>';
					} else {
						$option_periodo .= '<option value="' . $arreglo_periodos[$d]['periodo'] . '"d-none> ' . $arreglo_periodos[$d]['periodo'] . '</option>';
					}
					$d++;
				}
				$option_periodo .= '</select>';
			}
			$d = 0;

			// Condicional para saber las jornadas lo igualamos a 5 (Egresados) para que no puedan editar los demas campos solo el estado
			if ($rspta[$i]["estado"] == 5) {
				$option_jornada_egresado = $rspta[$i]['jornada_e'];

				
			} else {
				$option_jornada_egresado = '<select name="jornada_e" onchange="cambiarJornada(this.value,' . $rspta[$i]["id_estudiante"] . ')" id="jornada_e">';
				while ($p < count($arreglo_jornadas)) {
					if ($rspta[$i]['jornada_e'] == $arreglo_jornadas[$p]['nombre']) {
						$option_jornada_egresado .= '<option value="' . $arreglo_jornadas[$p]['nombre'] . '" selected >' . $arreglo_jornadas[$p]['nombre'] . '</option>';
					} else {
						$option_jornada_egresado .= '<option value="' . $arreglo_jornadas[$p]['nombre'] . '"d-none>' . $arreglo_jornadas[$p]['nombre'] . '</option>';
					}
					$p++;
				}
				$option_jornada_egresado .= '</select>';
			}
			$p = 0;

			// Ciclo para listar los periodos 
			if ($rspta[$i]["estado"] == 5) {
				$option_periodo_egresado = $rspta[$i]["periodo"];
			} else {
				$option_periodo_egresado = '<select name="periodo_ingreso" onchange="cambiarPeriodo(this.value,' . $rspta[$i]["id_estudiante"] . ')" id="periodo_ingreso">';
				while ($f < count($arreglo_periodos)) {
					if ($rspta[$i]['periodo'] == $arreglo_periodos[$f]['periodo']) {
						$option_periodo_egresado .= '<option value="' . $arreglo_periodos[$f]['periodo'] . '" selected >' . $arreglo_periodos[$f]['periodo'] . '</option>';
					} else {
						$option_periodo_egresado .= '<option value="' . $arreglo_periodos[$f]['periodo'] . '"d-none>' . $arreglo_periodos[$f]['periodo'] . '</option>';
					}
					$f++;
				}
				$option_periodo_egresado .= '</select>';
			}
			$f = 0;

			// Ciclo para listar los periodos activos

			$option_periodo_activo_egresado = "";
			if ($rspta[$i]["estado"] == 5) {
				$option_periodo_activo_egresado = $rspta[$i]["periodo_activo"];
			} else {


				$option_periodo_activo_egresado .= '<select name="periodo_activo" id="periodo_activo" onchange="cambiarPeriodoActivo(this.value,' . $rspta[$i]["id_estudiante"] . ')" >';
				while ($e < count($arreglo_periodos_activos)) {
					if ($rspta[$i]["periodo_activo"] == $arreglo_periodos[$e]['periodo']) {

						$option_periodo_activo_egresado .= '<option value="' . $arreglo_periodos_activos[$e]['periodo'] . '" selected >' . $arreglo_periodos_activos[$e]['periodo'] . '</option>';
					} else {
						$option_periodo_activo_egresado .= '<option value="' . $arreglo_periodos_activos[$e]['periodo'] . '"d-none>' . $arreglo_periodos_activos[$e]['periodo'] . '</option>';

						
					}
					$e++;
				}
				$option_periodo_activo_egresado .= '</select>';

			}

			//Condicional para saber los grupos 
			if ($rspta[$i]["estado"] == 5) {
				$option_grupo_egresado = $rspta[$i]["grupo"];
			} else {
				$option_grupo_egresado = '<select name="grupo_academico" onchange="cambiarGrupo(this.value,' . $rspta[$i]["id_estudiante"] . ')" id="grupo_academico">';
				while ($v < count($arreglo_grupos)) {
					if ($rspta[$i]['grupo'] == $arreglo_grupos[$v]['id_grupo']) {
						$option_grupo_egresado .= '<option value="' . $arreglo_grupos[$v]['id_grupo'] . '" selected >' . $arreglo_grupos[$v]['id_grupo'] . '</option>';
					} else {
						$option_grupo_egresado .= '<option value="' . $arreglo_grupos[$v]['id_grupo'] . '"d-none>' . $arreglo_grupos[$v]['id_grupo'] . '</option>';
					}
					$v++;
				}
				$option_grupo_egresado .= '</select>';
			}
			$v = 0;

			if ($rspta[$i]["estado"] == 2) {
				$prueba = $option_jornada;
			} else {
				$prueba = $option_jornada_egresado;
			}

			if ($rspta[$i]["estado"] == 2) {
				$prueba_periodo = $rspta[$i]["periodo"];
			} else {
				$prueba_periodo = $option_periodo_egresado;
			}

			if ($rspta[$i]["estado"] == 2) {
				$prueba_periodo_activo = $rspta[$i]["periodo_activo"];
			} else {
				$prueba_periodo_activo = $option_periodo_activo_egresado;
			}

			if ($rspta[$i]["estado"] == 2) {
				$muestro_grupo = $rspta[$i]['grupo'];
			} 
			else {
				$muestro_grupo = $option_grupo_egresado;
			}

			$escuela_ciaf = $rspta[$i]["escuela_ciaf"];
			$escuela_listar = $matriculaconfigurar->listar_escuelas($escuela_ciaf);

			$escuela_ciaf_listar = $escuela_listar["escuelas"];

			$modopago=$rspta[$i]["pago_renovar"];
			if($modopago==1){
				$active_modo1="selected";
				$active_modo0="";
			}else{
				$active_modo1="";
				$active_modo0="selected";
			}

			$pago_select="<select name='forma_pago' id='forma_pago' onchange='cambiarPago(this.value,".$rspta[$i]['id_estudiante'].")'>";

			$pago_select.="<option value='1' ".$active_modo1.">Pago normal</option>";
			$pago_select.= "<option value='0' ".$active_modo0.">Pago con nivelatorio </option>";
			
			$pago_select.="</select>";

			// select para cambiar el estado de perfil
			$mostrar_estado_perfil=$rspta[$i]["perfil"];
			if($mostrar_estado_perfil==1){
				$perfil_si="selected";
				$perfil_no="";
			}else{
				$perfil_si="";
				$perfil_no="selected";
			}
			$perfil_select="<select name='perfil_select' id='perfil_select' onchange='cambiarPerfil(this.value,".$rspta[$i]['id_estudiante'].")'>";
			$perfil_select.="<option value='1' ".$perfil_si.">SI</option>";
			$perfil_select.= "<option value='0' ".$perfil_no.">NO </option>";
			$perfil_select.="</select>";

			// select para cambiar el estado de admisiones
			$mostrar_estado_admisiones=$rspta[$i]["admisiones"];
			if($mostrar_estado_admisiones=="si"){
				$si="selected";
				$no="";
			}else{
				$si="";
				$no="selected";
			}
			$admisiones_select="<select name='admisiones_select' id='admisiones_select' onchange='cambiarAdmisiones(this.value,".$rspta[$i]['id_estudiante'].")'>";
			$admisiones_select.="<option value='si' ".$si.">SI</option>";
			$admisiones_select.= "<option value='no' ".$no.">NO </option>";
			$admisiones_select.="</select>";

			// select para cambiar el estado de homologado
			$mostrar_estado_homologado=$rspta[$i]["homologado"];
			if($mostrar_estado_homologado==0){
				$homologado_si="selected";
				$homologado_no="";
			}else{
				$homologado_si="";
				$homologado_no="selected";
			}
			$homologado_select="<select name='homologado_select' id='homologado_select' onchange='cambiarHomologado(this.value,".$rspta[$i]['id_estudiante'].")'>";
			$homologado_select.="<option value='0' ".$homologado_si.">SI</option>";
			$homologado_select.= "<option value='1' ".$homologado_no.">NO </option>";
			$homologado_select.="</select>"; 

			// select para cambiar el estado de renovar
			$mostrar_estado_renovar=$rspta[$i]["renovar"];
			if($mostrar_estado_renovar==1){
				$renovar_si="selected";
				$renovar_no="";
			}else{
				$renovar_si="";
				$renovar_no="selected";
			}
			$renovar_select="<select name='renovar_select' id='renovar_select' onchange='cambiarRenovar(this.value,".$rspta[$i]['id_estudiante'].")'>";
			$renovar_select.="<option value='1' ".$renovar_si.">SI</option>";
			$renovar_select.= "<option value='0' ".$renovar_no.">NO </option>";
			$renovar_select.="</select>";
			
			// select para cambiar el estado de pago_renovar
			$mostrar_estado_pago_renovar=$rspta[$i]["pago_renovar"];
			if($mostrar_estado_pago_renovar==1){
				$pago_renovar_si="selected";
				$pago_renovar_no="";
			}else{
				$pago_renovar_si="";
				$pago_renovar_no="selected";
			}
			$pago_renovar_select="<select name='pago_renovar_select' id='pago_renovar_select' onchange='cambiarPagoRenovar(this.value,".$rspta[$i]['id_estudiante'].")'>";
			$pago_renovar_select.="<option value='1' ".$pago_renovar_si.">SI</option>";
			$pago_renovar_select.= "<option value='0' ".$pago_renovar_no.">NO </option>";
			$pago_renovar_select.="</select>";

			// select para cambiar el estado de consulta_cifras
			$mostrar_estado_consulta_cifras=$rspta[$i]["consulta_cifras"];
			if($mostrar_estado_consulta_cifras==1){
				$consulta_cifras_si="selected";
				$consulta_cifras_no="";
			}else{
				$consulta_cifras_si="";
				$consulta_cifras_no="selected";
			}
			$consulta_cifras_select="<select name='consulta_cifras_select' id='consulta_cifras_select' onchange='cambiarConsultaCifras(this.value,".$rspta[$i]['id_estudiante'].")'>";
			$consulta_cifras_select.="<option value='1' ".$consulta_cifras_si.">SI</option>";
			$consulta_cifras_select.= "<option value='0' ".$consulta_cifras_no.">NO </option>";
			$consulta_cifras_select.="</select>";
			

			$editar_temporada = '<input type="text" name="editar_temporada" id="editar_temporada" onchange="cambiarTemporada(this.value,' . $rspta[$i]['id_estudiante'] . ')" value="' . $rspta[$i]["temporada"] . '" class="form-control" placeholder="Temporada">';
			
			$data[] = array(
				"0" => $rspta[$i]["id_estudiante"],
				"1" => $rspta[$i]["fo_programa"],
				"2" => $prueba,
				"3" => $pago_select,
				"4" => $option,
				"5" => $muestro_grupo,
				"6" => $prueba_periodo,
				"7" => $prueba_periodo_activo,
				"8" => $perfil_select,
				"9" => $admisiones_select,
				"10" => $homologado_select,
				"11" => $renovar_select,
				"12" => $editar_temporada,
				"13" => $pago_renovar_select,
				"14" => $consulta_cifras_select,
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
	case "cambiarEstado":
		$nuevo_estado = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarEstado($nuevo_estado, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
		break;
	case 'registrarGraduado':
		$nuevo_estado = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$id_credencial = $_POST['id_credencial'];
		$id_programa_ac = $_POST['id_programa_ac'];
		$periodo_grado = $_POST['periodo_grado'];
		$saber_pro = $_POST['saber_pro'];
		$acta_grado = $_POST['acta_grado'];
		$folio = $_POST['folio'];
		$fecha_grado = $_POST['fecha_grado'];
		if (empty($id_programa_ac) || empty($periodo_grado) || empty($saber_pro) || empty($acta_grado) || empty($folio) || empty($fecha_grado)) {
			echo 2;
		} else {
			$insertar_graduado = $matriculaconfigurar->registrarGraduado($id_estudiante, $id_credencial, $periodo_grado, $id_programa_ac, $saber_pro, $acta_grado, $folio, $fecha_grado);
			$rspta = $matriculaconfigurar->cambiarEstado($nuevo_estado, $id_estudiante);
			if ($insertar_graduado) {
				echo 1;
			} else {
				echo 0;
			}
		}
		break;
	case "cambiarPeriodo":
		$nuevo_periodo = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarPeriodo($nuevo_periodo, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
		break;
	case "cambiarPeriodoActivo":
		$nuevo_periodo = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarPeriodoActivo($nuevo_periodo, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;
	case "cambiarPago":
		$nuevo_pago = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarPago($nuevo_pago, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;

	case "cambiarAdmision":
		$admision = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarAdmision($admision, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;

	case "cambiarHomologado":
		$homologado = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarHomologado($homologado, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;

	case "cambiarRenovar":
		$renovar = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarRenovar($renovar, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;

	case "cambiarPagoRenovar":
		$renovar = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarPagoRenovar($renovar, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;

	case "cambiarTemporada":
		$renovar = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarTemporada($renovar, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;

	case "cambiarConsultaCifras":
		$renovar = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarConsultaCifras($renovar, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;

	case "cambiarPerfil":
		$perfil = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarPerfil($perfil, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;
	case "cambiarGrupo":
		$nuevo_grupo = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarGrupo($nuevo_grupo, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;
	case "cambiarJornada":
		$nueva_jornada = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaconfigurar->cambiarJornada($nueva_jornada, $id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case "mostrardatos":
		$id_credencial = $_POST["id_credencial"];
		$rspta = $matriculaconfigurar->mostrardatos($id_credencial);
		$cedula_estudiante = $rspta["credencial_identificacion"];
		$datos_personales_estudiante = $matriculaconfigurar->telefono_estudiante($cedula_estudiante);
		$celular_estudiante = $datos_personales_estudiante["celular"] ?? "";
		$data = array();
		$data["0"] = "";


		if (file_exists('../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg')) {
			$foto = '<img src=../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg class=img-circle img-bordered-sm>';
		} else {
			$foto = '<img src=../files/null.jpg width=50px height=50px class=img-circle img-bordered-sm>';
		}
		$data["0"] .= '
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
					<div class="row align-items-center">
						<div class="col-2">
							<span class="rounded text-gray">
								' . $foto . '
							</span>
						</div>
						<div class="col-10 line-height-16">
							<span class="fs-12">' . $rspta["credencial_nombre"] . ' ' . $rspta["credencial_nombre_2"] . '</span><br>
							<span class="text-semibold fs-12 titulo-2 line-height-16">' . $rspta["credencial_apellido"] . ' ' . $rspta["credencial_apellido_2"] . '</span>
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
							<span class="fs-12">Correo electrónico</span><br>
							<span class="text-semibold fs-12 titulo-2 line-height-16">' . $rspta["credencial_login"] . '</span>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
					<div class="d-flex justify-content-between align-items-center">
						<div class="d-flex align-items-start">
							<span class="rounded bg-light-green p-2 text-success mr-2">
								<i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
							</span>
							<div>
								<span class="fs-12">Número celular</span><br>
								<span class="text-semibold fs-12 titulo-2 line-height-16">
									' . (!empty($celular_estudiante) ? $celular_estudiante : 'El estudiante no tiene número de teléfono registrado.') . '
								</span>
							</div>
						</div>
						<button onclick="mostraragregarprograma(' . $rspta["id_credencial"] . ')" class="btn btn-success">
							Matricular nuevo Programa
						</button>
					</div>
				</div>
			</div>
		';
		// $data["0"] .= '
		// 			<div class="row">
		// 				<div class="col-6">
		// 					<div class="user-block">
		// 					' . $foto . '
		// 						<span class="username">
		// 						' . $rspta["credencial_nombre"] . ' ' . $rspta["credencial_nombre_2"] . ' ' . $rspta["credencial_apellido"] . ' ' . $rspta["credencial_apellido_2"] . '
		// 						</span>
		// 						<span class="description">' . $rspta["credencial_login"] . '</span>
        //                         <span class="description">Credencial: ' . $rspta["id_credencial"] . '</span>
		// 					</div>
		// 				</div>
		// 			';

		$results = array($data);
		echo json_encode($results);


		break;
	case 'mostrar':
		$id = $_POST["id"];
		$rspta = $matriculaconfigurar->mostrar($id);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);

		break;
	case "selectJornada":
		$rspta = $matriculaconfigurar->selectJornada();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectPrograma":
		$rspta = $matriculaconfigurar->selectPrograma();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;
	case "selectGrupo":
		$rspta = $matriculaconfigurar->selectGrupo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["grupo"] . "'>" . $rspta[$i]["grupo"] . "</option>";
		}
		break;

		case 'guardarcertificado':
			$id_estudiante_certificado = $_POST['id_estudiante_certificado'];
			$id_credencial_certificado = $_POST['id_credencial_certificado'];
			$id_programa_ac_certificado = $_POST['id_programa_ac_certificado'];
			$acta_certificacion = $_POST['acta_certificacion'];
			$fecha_certificacion = $_POST['fecha_certificacion'];
			$folio_certificado = $_POST['folio_certificado'];
			$data_ciclo = $_POST['data_ciclo'];
			$rspta = $matriculaconfigurar->insertargraduadocertificado($id_estudiante_certificado, $id_credencial_certificado, $id_programa_ac_certificado, $acta_certificacion, $folio_certificado, $fecha_certificacion);
			if ($rspta) {
				$rspta_cambio_estado = $matriculaconfigurar->cambiarEstado($data_ciclo, $id_estudiante_certificado);
				echo $rspta_cambio_estado ? 1 : 0;
			} else {
				echo 0;
			}
			break;
}
