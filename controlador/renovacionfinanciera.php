<?php
session_start();
require_once "../modelos/RenovacionFinanciera.php";
$renovacionfinanciera = new RenovacionFinanciera();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');


$rsptaperiodo = $renovacionfinanciera->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$temporadaactual = $rsptaperiodo["temporada"];
$temporadainactivos=$temporadaactual-2;
$id_usuario = $_SESSION['id_usuario'];




switch ($_GET['op']) {


    case 'listargeneral':
        $data= Array();
        $data["total"]="";

        $debenrenovar=0;
        $listar_estudiantes_porrenovar = $renovacionfinanciera->listargeneralporrenovar($periodo_anterior);
        for($a=0;$a<count($listar_estudiantes_porrenovar);$a++){
            $id_programa=$listar_estudiantes_porrenovar[$a]["id_programa_ac"];
            $jornada=$listar_estudiantes_porrenovar[$a]["jornada_e"];

            $mirarprograma=$renovacionfinanciera->datosprograma($id_programa);
            $activo_programa=$mirarprograma["estado_renovacion_financiera"];

            $mirarjornada=$renovacionfinanciera->datosjornada($jornada);
            $sede_ciaf=$mirarjornada["sede"];

            if($activo_programa==1 and $sede_ciaf=="CIAF"){
                $debenrenovar = $debenrenovar+1;
            }
           
        }
        $listar_estudiantes = $renovacionfinanciera->listargeneralrenovaron($periodo_actual);

        $total_estudiantes_porrenovar=$debenrenovar;
        $totalgeneralrenovaron=count($listar_estudiantes);

        $totalsuma=$total_estudiantes_porrenovar+$totalgeneralrenovaron;

        $avancegeneral=($totalgeneralrenovaron/$totalsuma)*100;
        $faltageneral=(100-$avancegeneral);
        

        $renovaroncontadopp=$renovacionfinanciera->listargeneralrenovaroncontadopp($periodo_actual);
        $total_renovaroncontadopp=count($renovaroncontadopp);
        $data["total"].='<div class="row">';

            $data["total"].='<div class="col-xl-3">';

                $data["total"].='
                    <div class="col-12">
                        <div class="info-box bg-olive">
                            <div class="info-box-content">

                                <div class="progress-group">
                                    General
                                    <span class="float-right"><b>'.$totalsuma.'</b></span>
                                </div>

                                <div class="progress-group">
                                    Renovaron
                                    <span class="float-right">
                                        <b><a onclick=listarestudiantes("'.$periodo_actual.'","1") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">'.$totalgeneralrenovaron.'</a></b>/
                                        '.round($avancegeneral).'% </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width: '.round($avancegeneral).'%"></div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    Renovaron contado PP
                                    <span class="float-right">
                                        <b><a onclick=listarestudiantes("'.$periodo_actual.'","2") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">'.$total_renovaroncontadopp.'</a></b>/
                                        </span>
                                </div>

                                <div class="progress-group">
                                    Pendiente
                                    <span class="float-right"><b>
                                        <a onclick=listarestudiantesporrenovar("'.$periodo_anterior.'","1") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">'.$total_estudiantes_porrenovar.'</a></b>/
                                        '.round($faltageneral,0).'% </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width: '.round($faltageneral).'%"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>';

               

            $data["total"].='</div>';

            $data["total"].='<div class="col-xl-9">';
                $data["total"].='<div class="row">';


                    $data["total"].='
                        <div class="col-xl-3">
                            
                        </div>';



                $data["total"].='</div>';
            $data["total"].='</div>';



        $data["total"].='</div>';


		echo json_encode($data);
        break;



        case 'listarestudiantes':

            $periodo=$_GET["periodo"];
            $valor=$_GET["valor"];

            if($valor=="1"){
                $rspta=$renovacionfinanciera->listarestudaintesrenovaron($periodo);
            }
            if($valor=="2"){
                $rspta=$renovacionfinanciera->listarestudiantesrenovaroncontadopp($periodo);
            }

            if($valor=="3"){
                $rspta=$renovacionfinanciera->listargeneralporrenovar($periodo);
            }
                

            
             //Vamos a declarar un array
            $data= Array();
            $reg=$rspta;
            

        
            for ($i=0;$i<count($reg);$i++){

                $id_estudiante=$reg[$i]["id_estudiante"];
                $traerdatosestudiante=$renovacionfinanciera->traerdatosestudiante($id_estudiante);
                $programa=$traerdatosestudiante["fo_programa"];
                $nombre=$traerdatosestudiante["credencial_apellido"] ." ".$traerdatosestudiante["credencial_apellido_2"]  ." ".$traerdatosestudiante["credencial_nombre"]  ." ".$traerdatosestudiante["credencial_nombre_2"];
                $periodo_activo=$traerdatosestudiante["periodo_activo"];
                $renovo="";
                if($periodo_activo==$periodo_actual){
                    $renovo="Renovó";
                }
                else{
                    $renovo="Pendiente";
                }

                $data[]=array(
                    "0"=>$reg[$i]["identificacion_estudiante"],
                    "1"=>$nombre,
                    "2"=>$programa,
                    "3"=>$reg[$i]["semestre"],
                    "4"=>$renovo,

 
                );
            }
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
    
        break;

        case 'listarestudiantesporrenovar':
            //Vamos a declarar un array
            $data= Array();

            $periodo=$_GET["periodo"];
            $valor=$_GET["valor"];
            
            $listar_estudiantes_porrenovar = $renovacionfinanciera->listargeneralporrenovar($periodo);
            $debenrenovar=0;
            for ($i=0;$i<count($listar_estudiantes_porrenovar);$i++){

                $id_programa=$listar_estudiantes_porrenovar[$i]["id_programa_ac"];
                $jornada=$listar_estudiantes_porrenovar[$i]["jornada_e"];
    
                $mirarprograma=$renovacionfinanciera->datosprograma($id_programa);
                $activo_programa=$mirarprograma["estado_renovacion_financiera"];
    
                $mirarjornada=$renovacionfinanciera->datosjornada($jornada);
                $sede_ciaf=$mirarjornada["sede"];
    
                    if($activo_programa==1 and $sede_ciaf=="CIAF"){
                        $debenrenovar=$debenrenovar+1;
                        $programa=$listar_estudiantes_porrenovar[$i]["fo_programa"];
                        $id_estudiante=$listar_estudiantes_porrenovar[$i]["id_estudiante"];
                        $jornada=$listar_estudiantes_porrenovar[$i]["jornada_e"];
                        $periodo_activo=$listar_estudiantes_porrenovar[$i]["periodo_activo"];

                        $traerdatosestudiante= $renovacionfinanciera->traerdatosestudiante($id_estudiante);
                        $identificacion=$traerdatosestudiante["credencial_identificacion"];
                        $nombre=$traerdatosestudiante["credencial_apellido"] . ' ' . $traerdatosestudiante["credencial_apellido_2"] . ' ' .
                                $traerdatosestudiante["credencial_nombre"] . ' ' . $traerdatosestudiante["credencial_nombre_2"];
                    
                    $data[]=array(
                        "0"=>$identificacion,
                        "1"=>$nombre,
                        "2"=>$programa,
                        "3"=>$jornada,
                        "4"=>'Pendiente',
                        "5"=>'',
                        "6"=>''
    
                    );
                }
            }
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
    
        break;

        case 'configurar':

            $rspta=$renovacionfinanciera->totalprogramas();
            
             //Vamos a declarar un array
             $data= Array();
            $reg=$rspta;
            
        
             for ($i=0;$i<count($reg);$i++){
    
                $nombre=$reg[$i]["nombre"];
                $estado=$reg[$i]["estado_renovacion_financiera"];
                $id_programa=$reg[$i]["id_programa"];
    
                $boton="";
                if($estado==1){
                    $boton="<a onclick='cambioestado($id_programa,0)' class='btn btn-success btn-xs'>Activado</a>";
                }else{
                    $boton="<a onclick='cambioestado($id_programa,1)' class='btn btn-danger btn-xs'>Bloqueado</a>";
                }
    
                // $datoscredencialestudiante=$consultanuevos->datoscredencialestudiante($id_credencial);
                
                 $data[]=array(
                    "0"=>$nombre,
                     "1"=>$boton,
                     );
             }
             $results = array(
                 "sEcho"=>1, //Información para el datatables
                 "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                 "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                 "aaData"=>$data);
             echo json_encode($results);
    
        break;	

        
	case 'cambioestado':
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		
		$id_programa=$_POST["id_programa"];
		$estado=$_POST["estado"];

		$rspta = $renovacionfinanciera->cambioestado($id_programa,$estado);

		if ($rspta == 0) {
			$data["0"] = "1";
		} else {

			$data["0"] = "0";
		}

		echo json_encode($data);

	break;



}
?>