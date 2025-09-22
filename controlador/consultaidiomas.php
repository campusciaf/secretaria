<?php
session_start();
require_once "../modelos/Consultaidiomas.php";

$consulta = new Consulta();
$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo['periodo_actual'];
$periodo_anterior = $rsptaperiodo['periodo_anterior'];


date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:S');

switch ($_GET["op"]) {

    case "selectPeriodo":	
		$rspta = $consulta->selectPeriodo();
        echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
            {
                echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
            }
	break;
    case "selectEscuelas":	
		$rspta = $consulta->selectEscuelas();
        echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
            {
                echo "<option value='" . $rspta[$i]["id_escuelas"] . "'>" . $rspta[$i]["escuelas"] . "</option>";
            }
	break;



    case 'listar':

        $periodo = $_POST["periodo"];
        $id_escuela = $_POST["id_escuela"];

        if($periodo ==''){
            $periodo = $periodo_actual;
        }

		$rspta = $consulta->estudiantesactivos($periodo,$id_escuela);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;


		for ($i = 0; $i < count($reg); $i++) {
            $programa=$consulta->programa($reg[$i]["programa"]);



            $nivel12=$consulta->nivel($reg[$i]["id_credencial"],'105');
            $periodoact1=$nivel12["periodo_activo"];
            if($nivel12){
                $nivel12=$consulta->nivelasignatura($nivel12["id_estudiante"],'A1-2');
                $a12=$nivel12["promedio"];
            }else{
                $a12="no";
            }

            $nivel13=$consulta->nivel($reg[$i]["id_credencial"],'105');
            if($nivel13){
                $nivel13=$consulta->nivelasignatura($nivel13["id_estudiante"],'A1-3');
                $a13=$nivel13["promedio"];
            }else{
                $a13="no";
            }

            $nivel14=$consulta->nivel($reg[$i]["id_credencial"],'105');
            if($nivel14){
                $nivel14=$consulta->nivelasignatura($nivel14["id_estudiante"],'A1-4');
                $a14=$nivel14["promedio"];
            }else{
                $a14="no";
            }

            $nivel21=$consulta->nivel($reg[$i]["id_credencial"],'98');
            $periodoact2=$nivel21["periodo_activo"];
            if($nivel21){
                $nivel21=$consulta->nivelasignatura($nivel21["id_estudiante"],'A2-1');
                $a21=$nivel21["promedio"];
            }else{
                $a21="no";
            }

            $nivel22=$consulta->nivel($reg[$i]["id_credencial"],'98');
            if($nivel22){
                $nivel22=$consulta->nivelasignatura($nivel22["id_estudiante"],'A2-2');
                $a22=$nivel22["promedio"];
            }else{
                $a22="no";
            }

            $nivel23=$consulta->nivel($reg[$i]["id_credencial"],'98');
            if($nivel23){
                $nivel23=$consulta->nivelasignatura($nivel23["id_estudiante"],'A2-3');
                $a23=$nivel23["promedio"];
            }else{
                $a23="no";
            }

            $nivelb1=$consulta->nivel($reg[$i]["id_credencial"],'99');
            $periodoact3=$nivelb1["periodo_activo"];
            if($nivelb1){
                $nivelb1=$consulta->nivelasignatura($nivelb1["id_estudiante"],'B1-1');
                $b1=$nivelb1["promedio"];
            }else{
                $b1="no";
            }

            $nivelb2=$consulta->nivel($reg[$i]["id_credencial"],'99');
            if($nivelb2){
                $nivelb2=$consulta->nivelasignatura($nivelb2["id_estudiante"],'B1-2');
                $b2=$nivelb2["promedio"];
            }else{
                $b2="no";
            }

            $nivelb3=$consulta->nivel($reg[$i]["id_credencial"],'99');
            if($nivelb3){
                $nivelb3=$consulta->nivelasignatura($nivelb3["id_estudiante"],'B1-3');
                $b3=$nivelb3["promedio"];
            }else{
                $b3="no";
            }

			$data[] = array(
                "0" => $reg[$i]["id_credencial"],
                "1" => $reg[$i]["id_estudiante"],
                "2" => $reg[$i]["credencial_identificacion"],
				"3" => $reg[$i]["credencial_nombre"] . " " . $reg[$i]["credencial_nombre_2"] . " " . $reg[$i]["credencial_apellido"] . " " . $reg[$i]["credencial_apellido_2"],
                "4" => $programa["nombre"],
                "5" => $reg[$i]["jornada_e"],
                "6" => $reg[$i]["semestre"],
				"7" => $a12,
				"8" => $a13,
				"9" => $a14,
                "10" => $periodoact1,
				"11" => $a21,
                "12" => $a22,
                "13" => $a23,
                "14" => $periodoact2,
                "15" => $b1,
                "16" => $b2,
                "17" => $b3,
                "18" => $periodoact3
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