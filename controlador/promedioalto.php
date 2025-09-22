<?php

require '../modelos/Promedioalto.php';

$promedio = new Promedio();

switch ($_GET['op']) {
    case 'listarPeriodo':
        $promedio->listarPeriodo();
    break;
    case 'consultaPromedio':
        $programa = $_POST['programa'];
        $periodo = $_POST['periodo'];
        $sentencia = $promedio->consultaPromedio($programa,$periodo);
        $a=0;
        $data = array();
        //$promedio->promediosPonderado('2184','5','2019-2');
        while ($a < count($sentencia) ) {
            $datos = $promedio->consultaDatos($sentencia[$a]['id_estudiante']);
            $pro = $promedio->promediosPonderado($sentencia[$a]['id_estudiante'],$programa,$periodo);
            if ($pro['promedio_ponderado'] >= 4.5) {
                $data[] = array(
                    '0' => $datos['nombres'],
                    '1' => $datos['apellidos'],
                    '2' => $pro['jornada'],
                    '3' => $pro['cantidadmatrias'],
                    '4' => $pro['semestre'],
                    '5' => round($pro['promedio_ponderado'], 3)
                );
            }
            $a++;
        }       
        $result = array(
			"sEcho"=>1, //Información para el datatble
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data
		);
		echo json_encode($result);
        break;
    case 'prueba':
        $id = "2";
        $programa = "17";
        $periodo = "2014-2";
        $ciclo = "1";
        $promedio->promediosPonderado($id,$programa,$periodo,$ciclo);
    break;
}
?>