<?php

require '../modelos/ConsultaPromedio.php';

$promedio = new ConsultaPromedio();

switch ($_GET['op']) {
    case 'listarPeriodo':
        $promedio->listarPeriodo();
    break;
    case 'consultaPromedio':
        $programa = $_POST['programa'];
        $periodo = $_POST['periodo'];
        $jornada = $_POST['jornada_promedio'];
        $sentencia = $promedio->consultaPromedio($programa, $periodo, $jornada);
        $a = 0;
        $data = array();
    
        while ($a < count($sentencia)) {
            $datos = $promedio->consultaDatos($sentencia[$a]['id_estudiante']);
            $pro = $promedio->promediosPonderado($sentencia[$a]['id_estudiante'], $programa, $periodo);
    
            $data[] = array(
                '0' => $datos['nombres'],
                '1' => $datos['apellidos'],
                '2' => $pro['jornada'],
                '3' => $pro['cantidadmatrias'],
                '4' => $pro['semestre'],
                '5' => round($pro['promedio_ponderado'], 3)
            );
    
            $a++;
        }
    
        $result = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
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

    case "selectJornada":
		$rspta = $promedio->selectJornada();
		echo "<option value=''>-- Seleccionar --</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . " - " . $rspta[$i]["codigo"] . " </option>";
		}
		break;
}
?>