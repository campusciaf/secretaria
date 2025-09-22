<?php
session_start();
require_once "../modelos/HorariosControl.php";
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:S');


$horarioscontrol = new HorariosControl();
$rsptaperiodo = $horarioscontrol->periodoactual();
$periodo_actual = $rsptaperiodo['periodo_actual'];
$periodo_anterior = $rsptaperiodo['periodo_anterior'];


switch ($_GET["op"]) {
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

                        $traerescuelas = $horarioscontrol->listarescuelas();
                        for ($a = 0; $a < count($traerescuelas); $a++) {
                            $escuela = $traerescuelas[$a]["escuelas"];
                            $nombre_corto = $traerescuelas[$a]["nombre_corto"];
                            $color = $traerescuelas[$a]["color"];
                            $coloringles = $traerescuelas[$a]["color_ingles"];
                            $id_escuelas = $traerescuelas[$a]["id_escuelas"];
                                $data["mostrar"] .= '
                               
                            <div style="width:160px" id="t-E">
                            

                                <a onclick="listar(' . $id_escuelas . ')" title="ver cifras" class="row pointer m-2">
                                    <div class="col-3 rounded bg-light-' . $coloringles . '">
                                        <div class="text-' . $coloringles . ' text-center pt-1">
                                            <i class="fa-regular fa-calendar-check fa-2x"></i>
                                        </div>
                                        
                                    </div>
                                    <div class="col-9 borde" >
                                        <span>Escuela de</span><br>
                                        <span class="titulo-2 fs-12 line-height-16"> ' . $nombre_corto . '</span>
                                    </div>
                                </a>
                            </div>
                                
                                ';
                        }
                        $data["mostrar"] .= '
                    </div>
                </div>
            </div>';
        echo json_encode($data);
    break;

    case 'listar':
        $id_escuela = $_GET["id_escuela"];

        $rspta = $horarioscontrol->listar($id_escuela,$periodo_actual);
		$data = array();
		$reg = $rspta;
		for ($i=0;$i<count($reg);$i++){
            $ciclo=$reg[$i]["ciclo_doc_grupos"];
            $materia_nombre=$reg[$i]["materia_nombre"];
            $jornada=$reg[$i]["doc_grupo_jornada"];
            $semestre=$reg[$i]["doc_grupo_semestre"];
            $id_programa=$reg[$i]["id_programa"];
            $grupo=$reg[$i]["doc_grupo_grupo"];

            $docente=$reg[$i]["usuario_apellido"] .' ' . $reg[$i]["usuario_nombre"];
            

            $traernumestudiantes=$horarioscontrol->traerestudiantes($ciclo,$materia_nombre,$jornada,$periodo_actual,$semestre,$id_programa,$grupo);
            $totalestudiantes=$traernumestudiantes["total_matriculadas"];

            $hora = $reg[$i]["hora"];
			$rsptahora = $horarioscontrol->horasFormato($hora);
			// consulta para traer el formato de hasta
			$hasta = $reg[$i]["hasta"];
			$rsptahasta = $horarioscontrol->horasFormato($hasta);
			
			$data[]=array(
				"0"=> $docente,
                "1"=>$materia_nombre,
                "2"=>$reg[$i]["dia"],
                "3"=>'<span title="'.$rsptahora["formato"] .' a ' . $rsptahasta["formato"].'">'.$reg[$i]["hora"] . ' ' . $reg[$i]["hasta"] .'</span>',
                "4" => $jornada,
                "5" => $reg[$i]["diferencia"],
                "6" => ' <span class="badge badge-primary" title="Fusión por salón">'.$reg[$i]["fusion_salon"] . '</span> - <span class="badge badge-info" title="Fusión por docente"> ' . $reg[$i]["fusion_docente"],
                "7" => $totalestudiantes,
                "8" => $reg[$i]["salon"],
                "9" => $semestre,
                "10" => $reg[$i]["ciclo"],
			);
		}

		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data
		);

		echo json_encode($results);

    break;
        /* traer estudiantes de la sede CIAF en la tabla */
    case 'traerdatos':
        $periodo_anterior = $_GET["periodo_anterior"];
        $id_escuela = $_GET["id_escuela"];
        $sede = $_GET["sede"];
        //Vamos a declarar un array
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerdatos($id_escuela, $periodo_anterior);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            $id_estudiante_activo = $buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["programa"];
            $buscar_jornada = $horarioscontrol->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $horarioscontrol->validarprograma($id_programa);
            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];
            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1) {
                $dato_estudiante = $horarioscontrol->dato_estudiante($id_estudiante);
                $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                    $estado=$dato_estudiante["estado"];
                    $miciclo=$dato_estudiante["ciclo"];

                } else {
                    $programa = "a - No esta matriculado";
                }
                $datos_estudiantes = $horarioscontrol->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                $mi_estado_academico="";

                $miestado = $horarioscontrol->miestado($estado);

                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                    
                } else {
                    if($miciclo=="3" and ($estado=='2' or $estado=='5')){
                        $estado_renovacion = "Graduado Terminal";
                    }
                  
                    else{
                         $estado_renovacion = "Pendiente";
                    }
                   
                    
                }
                $data[] = array(
                    "0" => $id_estudiante_activo,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,
                    "7" => @$miestado["estado"] 
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;

    case 'traerdatoscontaduriasede':
        $periodo_anterior = $_GET["periodo_anterior"];
        $id_escuela = $_GET["id_escuela"];
        $sede = $_GET["sede"];

        //Vamos a declarar un array
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerdatos($id_escuela, $periodo_anterior);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            $id_estudiante_activo = $buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["programa"];
            $buscar_jornada = $horarioscontrol->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $horarioscontrol->validarprograma($id_programa);
            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];
            $siessede= $buscar_programa = $buscar_programa["universidad"];
            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1 and $siessede!="INTEP") {
                $dato_estudiante = $horarioscontrol->dato_estudiante($id_estudiante);
                $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                    $estado=$dato_estudiante["estado"];
                    $miciclo=$dato_estudiante["ciclo"];

                } else {
                    $programa = "a - No esta matriculado";
                }
                $datos_estudiantes = $horarioscontrol->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                $mi_estado_academico="";

                $miestado = $horarioscontrol->miestado($estado);

                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                    
                } else {
                    if($miciclo=="3" and ($estado=='2' or $estado=='5')){
                        $estado_renovacion = "Graduado Terminal";
                    }
                  
                    else{
                         $estado_renovacion = "Pendiente";
                    }
                   
                    
                }
                $data[] = array(
                    "0" => $id_estudiante_activo,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,
                    "7" => @$miestado["estado"]  
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;

    case 'traerdatoscontaduriaintep':
        $periodo_anterior = $_GET["periodo_anterior"];
        $id_escuela = $_GET["id_escuela"];
        $sede = $_GET["sede"];

        //Vamos a declarar un array
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerdatos($id_escuela, $periodo_anterior);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            $id_estudiante_activo = $buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["programa"];
            $buscar_jornada = $horarioscontrol->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $horarioscontrol->validarprograma($id_programa);
            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];
            $siessede= $buscar_programa = $buscar_programa["universidad"];

            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1 and $siessede == "INTEP") {
                $dato_estudiante = $horarioscontrol->dato_estudiante($id_estudiante);
                $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                    $estado=$dato_estudiante["estado"];
                    $miciclo=$dato_estudiante["ciclo"];

                } else {
                    $programa = "a - No esta matriculado";
                }
                $datos_estudiantes = $horarioscontrol->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                $mi_estado_academico="";

                $miestado = $horarioscontrol->miestado($estado);

                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                    
                } else {
                    if($miciclo=="3" and ($estado=='2' or $estado=='5')){
                        $estado_renovacion = "Graduado Terminal";
                    }
                  
                    else{
                         $estado_renovacion = "Pendiente";
                    }
                   
                    
                }
                $data[] = array(
                    "0" => $id_estudiante_activo,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,
                    "7" => @$miestado["estado"] 
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;
        /* traer estudiantes de la sede CIAF en la tabla */
    case 'traerdatosarticulacion':
        $periodo_anterior = $_GET["periodo_anterior"];
        $id_escuela = $_GET["id_escuela"];
        $jornadaarticulacion = $_GET["jornadaarticulacion"];
        //Vamos a declarar un array
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerdatosarticulacion($id_escuela, $periodo_anterior, $jornadaarticulacion);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            $id_estudiante_activo = $buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["programa"];
            $buscar_jornada = $horarioscontrol->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $horarioscontrol->validarprograma($id_programa);
            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];
            $dato_estudiante = $horarioscontrol->dato_estudiante($id_estudiante);
            $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
            if ($dato_estudiante) {
                $programa = $dato_estudiante["fo_programa"];
                $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                $celular = $dato_estudiante["celular"];
                $estado=$dato_estudiante["estado"];
                $miciclo=$dato_estudiante["ciclo"];
            } else {
                $programa = "a - No esta matriculado";
            }
            $datos_estudiantes = $horarioscontrol->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
            $estado_renovacion = "";
            $mi_estado_academico="";

            $miestado = $horarioscontrol->miestado($estado);

            if ($datos_estudiantes) {
                $estado_renovacion = "Renovó";
            } else {
                if($miciclo=="3" and ($estado=='2' or $estado=='5')){
                    $estado_renovacion = "Graduado Terminal";
                }
              
                else{
                     $estado_renovacion = "Pendiente";
                }
            }
            $data[] = array(
                "0" => $id_estudiante_activo,
                "1" => $credencial_identificacion,
                "2" => $credencial_nombre,
                "3" => $programa,
                "4" => $jornada_e,
                "5" => $celular,
                "6" => $estado_renovacion,
                "7" => @$miestado["estado"] 
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
    case 'traerdatosnuevos':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $jornada = $_GET["jornada"];
        //Vamos a declarar un array
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerdatosestudiantesnuevossede($id_escuela, $periodo_actual);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $programa = $buscarjornadameta[$b]["fo_programa"];
            $celular = $buscarjornadameta[$b]["celular"];
            $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
            $credencial_identificacion = $dato_credencial["credencial_identificacion"];
            $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
            $estado_renovacion = "Nuevo";
            $data[] = array(
                "0" => $id_estudiante,
                "1" => $credencial_identificacion,
                "2" => $credencial_nombre,
                "3" => $programa,
                "4" => $jornada_e,
                "5" => $celular,
                "6" => $estado_renovacion,
                "7" => ''
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
    case 'traerdatosrenovacion':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerdatosestudiantesrenovacionsede($id_escuela, $periodo_actual);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            // $id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["id_programa_ac"];
            $buscar_jornada = $horarioscontrol->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $horarioscontrol->validarprograma($id_programa);
            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];
            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1) {
                $dato_estudiante = $horarioscontrol->dato_estudiante($id_estudiante);
                $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                } else {
                    $programa = "a - No esta matriculado";
                }
                $datos_estudiantes = $horarioscontrol->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                } else {
                    $estado_renovacion = "Pendiente";
                }
                $data[] = array(
                    "0" => $id_estudiante,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,
                    "7" => ''
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;
    case 'traerdatosreintegro':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerdatosestudiantesrenovacionsede($id_escuela, $periodo_actual);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            // $id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["id_programa_ac"];
            $buscar_jornada = $horarioscontrol->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $horarioscontrol->validarprograma($id_programa);
            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];

            $buscar_estudiante_activo = $horarioscontrol->validarrenovacion($id_estudiante,$periodo_anterior);

            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1 and !$buscar_estudiante_activo) {
                $dato_estudiante = $horarioscontrol->dato_estudiante($id_estudiante);
                $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                } else {
                    $programa = "a - No esta matriculado";
                }
                $datos_estudiantes = $horarioscontrol->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                } else {
                    $estado_renovacion = "Pendiente";
                }
                $data[] = array(
                    "0" => $id_estudiante,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,
                    "7" => ''
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;
    case 'traerdatosreintegrointerno':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerdatosestudiantesrenovacioninternasede($id_escuela, $periodo_actual);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            // $id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["id_programa_ac"];
            $buscar_jornada = $horarioscontrol->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $horarioscontrol->validarprograma($id_programa);
            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];

            $buscar_estudiante_activo_interno = $horarioscontrol->validarrenovacioninterno($id_credencial,$periodo_anterior);

            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1 and !$buscar_estudiante_activo_interno ) {
                $dato_estudiante = $horarioscontrol->dato_estudiante($id_estudiante);
                $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                } else {
                    $programa = "a - No esta matriculado";
                }
                $datos_estudiantes = $horarioscontrol->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                } else {
                    $estado_renovacion = "Pendiente";
                }
                $data[] = array(
                    "0" => $id_estudiante,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,
                    "7" => ''
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;
    case 'traerdatosrenovacioninterna':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerdatosestudiantesrenovacioninternasede($id_escuela, $periodo_actual);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            // $id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["id_programa_ac"];
            $buscar_jornada = $horarioscontrol->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $horarioscontrol->validarprograma($id_programa);
            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];

           


            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1) {
                $dato_estudiante = $horarioscontrol->dato_estudiante($id_estudiante);
                $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                } else {
                    $programa = "a - No esta matriculado";
                }
                $datos_estudiantes = $horarioscontrol->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                } else {
                    $estado_renovacion = "Pendiente";
                }
                $data[] = array(
                    "0" => $id_estudiante,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,
                    "7" => ''
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;
    case 'traerdatosrenovacioninternaarticulacion':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $id_escuela = $_GET["id_escuela"];
        $jornadaarticulacion = $_GET["jornada"];
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerestudiantesjornadaciafrenovaroninternos($id_escuela, $periodo_actual, $jornadaarticulacion);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            // $id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $programa = $buscarjornadameta[$b]["fo_programa"];
            $celular = $buscarjornadameta[$b]["celular"];
            $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
            $credencial_identificacion = $dato_credencial["credencial_identificacion"];
            $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
            $estado_renovacion = "Renovó";
            $data[] = array(
                "0" => $id_estudiante,
                "1" => $credencial_identificacion,
                "2" => $credencial_nombre,
                "3" => $programa,
                "4" => $jornada_e,
                "5" => $celular,
                "6" => $estado_renovacion,
                "7" => ''
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
    case 'traerdatosrenovacionarticulacion': 
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $id_escuela = $_GET["id_escuela"];
        $jornadaarticulacion = $_GET["jornada"];
        $data = array();
        $buscarjornadameta = $horarioscontrol->traerestudiantesjornadaciafrenovaron($id_escuela, $periodo_actual, $jornadaarticulacion);
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            //$id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $programa = $buscarjornadameta[$b]["fo_programa"];
            $celular = $buscarjornadameta[$b]["celular"];
            $dato_credencial = $horarioscontrol->dato_estudiante_credencial($id_credencial);
            $credencial_identificacion = $dato_credencial["credencial_identificacion"];
            $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
            $estado_renovacion = "Renovó";
            $data[] = array(
                "0" => $id_estudiante,
                "1" => $credencial_identificacion,
                "2" => $credencial_nombre,
                "3" => $programa,
                "4" => $jornada_e,
                "5" => $celular,
                "6" => $estado_renovacion,
                "7" => ''
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
} 