<?php
require_once "../modelos/ConsultaModalidad.php";
//modelo en el cual estan las funciones a base de datos 
$consultamodalidad = new ConsultaModalidad();


switch ($_GET['op']){


    case 'periodo':
		$data= Array();
		$rsptaperiodo = $consultamodalidad->periodoactual();
		$periodo_campana=$rsptaperiodo["periodo_campana"];	
        $data["periodo"]=$periodo_campana;

		echo json_encode($data);

	break;

    case "selectDatos":
        $data= Array();
		$data["0"] ="";

        $data["0"] .=$_SESSION['usuario_cargo'];

        echo json_encode($data);

    break;

    case "selectPeriodo":
        $rspta = $consultamodalidad->selectPeriodo();
        echo "<option value='' selected disabled>- Selecciona un periodo -</option>";
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
        }
    break;
    case 'listarModalidad': //Listar todas la modalidades matriculadas

        

        $periodo = isset($_POST["periodo"])? $_POST["periodo"]:"";
        $rsta = $consultamodalidad->listarMateriasModalidad($periodo);
        $array = array();
            for ($i = 0; $i < count($rsta); $i++) {
                
                $id_estudiante=$rsta[$i]["id_estudiante"];
                $programa=$rsta[$i]["fo_programa"];
                $id_materia=$rsta[$i]["id_materia"];
                $id_materias_ciafi_modalidad=$rsta[$i]["id_materias_ciafi_modalidad"];

                $jornada=$rsta[$i]["jornada_e"];
                $semestre=$rsta[$i]["semestre_estudiante"];

                $id_credencial=$rsta[$i]["id_credencial"];
                $identificacion=$rsta[$i]["credencial_identificacion"];
                $nombre=$rsta[$i]["credencial_apellido"] . ' ' . $rsta[$i]["credencial_apellido_2"] . ' ' . $rsta[$i]["credencial_nombre"] . ' ' . $rsta[$i]["credencial_nombre_2"];
                

                $consultarmateria=$consultamodalidad->datosmateria($id_materia);
                $nombre_materia=$consultarmateria["nombre"];
                
                $consultarmateriamodalidad=$consultamodalidad->datosmateriamodalidad($id_materias_ciafi_modalidad);
                @$modalidad=$consultarmateriamodalidad["modalidad"];

                $array[] = array(
                    "0" => $identificacion,
                    "1" => $nombre,
                    "2" => $programa,
                    "3" => $jornada,
                    "4" => $semestre,
                    "5" => $nombre_materia,
                    "6" => $modalidad,

                );
            }
        
        //se crea otro array para almacenar toda la informacion que analizara el datatable
		$results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($array), //enviamos el total registros a visualizar
            "aaData"=>$array);

        echo json_encode($results);
    break;

}
?>