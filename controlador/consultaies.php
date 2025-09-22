<?php
session_start();
require_once "../modelos/ConsultaIes.php";
$consultaIes = new ConsultaIes();


switch ($_GET['op']) {
	case "selectIES":	
		$rspta = $consultaIes->selectIes();
		echo "<option value='todos2'>Todas</option>";
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["jornada"] . "'>" . $rspta[$i]["sede"] . "</option>";
        }
	break;
	case "selectPeriodo":	
		$rspta = $consultaIes->selectPeriodo();
		echo "<option value='todos2'>Todas</option>";
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
        }
	break;
    case 'consultaies':
        $jornada = $_POST['jornada'];
        $periodo = $_POST['periodo'];
        $rspta=$consultaIes->consultaies($jornada,$periodo);
        $data=array();
        for ($i=0;$i<count($rspta);$i++){
            $rspta2 = $consultaIes->consultafaltas($rspta[$i]["id_estudiante"], $rspta[$i]["periodo_activo"]);
            @$cantidad_faltas=$rspta2["cantidad_faltas"];
            $data[]=array( 
            "0"=>$rspta[$i]["credencial_identificacion"],
            "1"=>$rspta[$i]["credencial_nombre"]." ".$rspta[$i]["credencial_nombre_2"]." ".$rspta[$i]["credencial_apellido"]." ".$rspta[$i]["credencial_apellido_2"], 
            "2"=>$rspta[$i]["fo_programa"],
            "3"=>$rspta[$i]["jornada_e"],
            "4"=>$rspta[$i]["semestre_estudiante"],
            "5"=>$rspta[$i]["periodo"],
            "6"=>$rspta[$i]["periodo_activo"],
            "7"=>'<button class="btn btn-info" data-cantidadfaltas="'.$cantidad_faltas.'" onclick="mostrarModal('.$rspta[$i]["id_estudiante"].',`'.$rspta[$i]["periodo_activo"].'`)"><i class="fas fa-eye"></i> <span class="cantidad-faltas-badge">'.$cantidad_faltas.'</span></button>',
        
        );
       }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;

    case 'mostrar':
        
		$periodo_actual=$_SESSION["periodo_actual"];
        $rspta=$consultaIes->mostrar($periodo_actual);
        $data=array();
        for ($i=0;$i<count($rspta);$i++){
            $rspta2 = $consultaIes->consultafaltas($rspta[$i]["id_estudiante"], $rspta[$i]["periodo_activo"]);
            @$cantidad_faltas=$rspta2["cantidad_faltas"];
            $data[]=array( 
            "0"=>$rspta[$i]["sede"],
            "1"=>$rspta[$i]["credencial_nombre"]." ".$rspta[$i]["credencial_nombre_2"]." ".$rspta[$i]["credencial_apellido"]." ".$rspta[$i]["credencial_apellido_2"], 
            "2"=>$rspta[$i]["fo_programa"],
            "3"=>$rspta[$i]["jornada_e"],
            "4"=>$rspta[$i]["semestre_estudiante"],
            "5"=>$rspta[$i]["periodo"],
            "6"=>$rspta[$i]["periodo_activo"],
            "7"=>'<button class="btn btn-info" style="display: flex; align-items: center;" data-cantidadfaltas="'.$cantidad_faltas.'" onclick="mostrarModal('.$rspta[$i]["id_estudiante"].',`'.$rspta[$i]["periodo_activo"].'`)">
            <i class="fas fa-eye" style="margin-right: 5px;"></i> <span class="cantidad-faltas-badge">'.$cantidad_faltas.'</span>
            </button>'
        
        );
       }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;


    case 'verfaltas':
        $id_estudiante = $_POST['id_estudiante'];
        $periodo_activo = $_POST['periodo_activo'];
        $rspta=$consultaIes->verfaltas($id_estudiante,$periodo_activo);
        $data=array();
        for ($i=0;$i<count($rspta);$i++){
            $data[]=array( 
            "0"=>$rspta[$i]["fecha_falta"],
            "1"=>$rspta[$i]["periodo_falta"],
            "2"=>$rspta[$i]["motivo_falta"],
            "3"=>$rspta[$i]["materia_falta"],
        
        );
       }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
}
?>