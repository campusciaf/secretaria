<?php
require_once "../modelos/SofiInteresMora.php";
$consulta = new SofiInteresMora();
switch ($_GET['op']){
    case 'listarIntereses': //Listar el ultimo interes mora insertado 
        $rsta = $consulta->listarIntereses();
        
        for($i = 0; $i < count($rsta); $i++){
			$array[] = array(
 				"0"=>'<button class="btn bg-yellow color-palette btn-flat btn-sm btn-editar-usuario" onclick="mostrar('.$rsta[$i]["id_interes_mora"].')" data-idusuario="'.$rsta[$i]["id_interes_mora"].'"><i data-toggle="tooltip" title="" class="fa fa-pen"  data-original-title="Editar Interés Mora"></i></button> ',
 				"1"=>$rsta[$i]["nombre_mes"],
 				"2"=>$rsta[$i]["fecha_mes"],
 				"3"=>$rsta[$i]["porcentaje"],
 			);
 		}
		$results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($array), //enviamos el total registros a visualizar
            "aaData"=>$array);
        echo json_encode($results);
    break;
    case 'mostrarInteres': //mostrar el id especifico
        $id_interes = $_POST["id_interes"];
        $rsta = $consulta->mostrarInteres($id_interes);        
            if($rsta >= 1){
                $array = array(
                    "exito" => 1,
                    "id_interes_mora" => $rsta[0]["id_interes_mora"],
                    "nombre_mes" => $rsta[0]["nombre_mes"],
                    "fecha_mes" => $rsta[0]["fecha_mes"],
                    "porcentaje" => $rsta[0]["porcentaje"],
                );
            }else{
                $array = array(
                    "exito" => 0
                );
            }
        echo json_encode($array);
    break;
    case 'guardaryEditar': //Listar el ultimo interes mora insertado
        $id_interes = $_POST["id_interes"];
        $mes_anio = $_POST["mes_anio"];
        $aplica_hasta = $_POST["aplica_hasta"];
        $porcentaje = $_POST["porcentaje"];
        
        if(empty($id_interes)){
            $rsta = $consulta->insertarInteres($mes_anio, $aplica_hasta, $porcentaje);
        }else{
            $rsta = $consulta->editarInteres($id_interes,$mes_anio, $aplica_hasta, $porcentaje);
        }
        
        if($rsta){
            $array = array("exito" => 1);
        }else{
            $array = array("exito" => 0);
        }
        
        echo json_encode($array);
    break;
}

?>