<?php
session_start();
require_once "../modelos/ReingresoGeneral.php";

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:S');

$consulta = new ReingresoGeneral();

$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo['periodo_actual'];

switch ($_GET["op"]) {

    case 'listarescuelas':
        $data = array(); //Vamos a declarar un array
        $data["mostrar"] = ""; //iniciamos el arreglo
        $data["mostrar"] .= '<div class="row">';
        $traerescuelas = $consulta->listarescuelas();
        for ($a = 0; $a < count($traerescuelas); $a++) {
            $escuela = $traerescuelas[$a]["escuelas"];
            $color = $traerescuelas[$a]["color"];
            $color_ingles = $traerescuelas[$a]["color_ingles"];
            $nombre_corto = $traerescuelas[$a]["nombre_corto"];
            $id_escuelas = $traerescuelas[$a]["id_escuelas"];
            $data["mostrar"] .= '
            
            <div style="width:170px">
                <a onclick="listar(' . $id_escuelas . ')" title="ver cifras" class="row pointer m-2">
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
        $data["mostrar"] .= '</div>';
        echo json_encode($data);
    break;

    case 'listar':
        $data = array(); //Vamos a declarar un array
        $id_escuela = $_GET["escuela"];

        $nombreescuela = $consulta->nombreescuela($id_escuela);
        $nombre=$nombreescuela["escuelas"] ;
        $color=$nombreescuela["color"];
        // consulta para traer los activos de la tabla estudiantes
        $traerestudiantes = $consulta->traerestudiantesunicos($id_escuela);
        
		for ($i = 0; $i < count($traerestudiantes); $i++) {
            $id_credencial=$traerestudiantes[$i]["id_credencial"];
            $identificacion=$traerestudiantes[$i]["credencial_identificacion"];

            $datosestudiante=$consulta->datosestudiante($id_credencial);// traer los datos del estudiante
            $nombre=$datosestudiante["credencial_nombre"] . ' ' . $datosestudiante["credencial_apellido"];
            $identificacion=$datosestudiante["credencial_identificacion"];

            $termino=$consulta->terminoProfesional($id_credencial,3); // consulta para saber quienes terminaron el programa profesional, para no incluirlos           
            if($termino){

            }else{
                $estaestudiando=$consulta->estaActivo($id_credencial,$periodo_actual);// consulta para saber si se encuentra estudiando este periodo para no tenerlo encuenta
                if($estaestudiando){

                }
               else{
                    $buscarciclo1=$consulta->traersiguiente($id_credencial,1);
                    if($buscarciclo1){
                        $programa1=$buscarciclo1["fo_programa"];
                        $periodoma1=$buscarciclo1["periodo"];
                        $periodoac1=$buscarciclo1["periodo_activo"];
                        $estado=$buscarciclo1["estado"];
                        /* estado */
                            if($estado==1){
                                $estado="Matriculado";
                            }else if($estado==2){
                                $estado="Graduado";
                            }
                            else if($estado==3){
                                $estado="Aplazado";
                            }
                            else if($estado==4){
                                $estado="Inactivo";
                            }
                            else if($estado==5){
                                $estado="Egresado";
                            }else{
                                $estado="no Iden.";
                            }
                        /* *************** */
                    }else{
                        $programa1="no";
                        $periodoma1="";
                        $periodoac1="";
                        $estado="";
                    }

                    $buscarciclo2=$consulta->traersiguiente($id_credencial,2);
                    if($buscarciclo2){
                        $programa2=$buscarciclo2["fo_programa"];
                        $periodoma2=$buscarciclo2["periodo"];
                        $periodoac2=$buscarciclo2["periodo_activo"];
                        $estado2=$buscarciclo2["estado"];
                        /* estado */
                            if($estado2==1){
                                $estado2="Matriculado";
                            }else if($estado2==2){
                                $estado2="Graduado";
                            }
                            else if($estado2==3){
                                $estado2="Aplazado";
                            }
                            else if($estado2==4){
                                $estado2="Inactivo";
                            }
                            else if($estado2==5){
                                $estado2="Egresado";
                            }else{
                                $estado2="no Iden.";
                            }
                        /* *************** */
                    }else{
                        $programa2="no";
                        $periodoma2="no";
                        $periodoac2="no";
                        $estado2="no";
                    }

                    $buscarciclo3=$consulta->traersiguiente($id_credencial,3);
                    if($buscarciclo3){
                        $programa3=$buscarciclo3["fo_programa"];
                        $periodoma3=$buscarciclo3["periodo"];
                        $periodoac3=$buscarciclo3["periodo_activo"];
                        $estado3=$buscarciclo3["estado"];
                        /* estado */
                            if($estado3==1){
                                $estado3="Matriculado";
                            }else if($estado3==2){
                                $estado3="Graduado";
                            }
                            else if($estado3==3){
                                $estado3="Aplazado";
                            }
                            else if($estado3==4){
                                $estado3="Inactivo";
                            }
                            else if($estado3==5){
                                $estado3="Egresado";
                            }else{
                                $estado3="no Iden.";
                            }
                        /* *************** */
                    }else{
                        $programa3="no";
                        $periodoma3="no";
                        $periodoac3="no";
                        $estado3="no";
                    }
                $data[] = array(
                    "0" => '',
                    "1" => $identificacion,
                    "2" => $nombre,
                    "3" => $programa1,
                    "4" => $estado,
                    "5" => $periodoma1,
                    "6" => $periodoac1,
                    "7" => $programa2,
                    "8" => $estado2,
                    "9" => $periodoma2,
                    "10" => $periodoac2,
                    "11" => $programa3,
                    "12" => $estado3,
                    "13" => $periodoma3,
                    "14" => $periodoac3,
                );
               }
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
}