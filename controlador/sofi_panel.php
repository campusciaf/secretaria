<?php
require_once "../modelos/SofiPanel.php";
$consulta = new SofiPanel();
$periodo_actual = $_SESSION["periodo_actual"];
$periodo_comparado = $_SESSION["periodo_comparado"];

switch ($_GET['op']) {
    case 'DatosPanel': 
        //Listar el ultimo interes mora insertado 
        $listarInteres = $consulta->listarInteres();
        $data['exito'] = '1';
        $data['procentaje'] = @$listarInteres["porcentaje"];
        //Listar lo que se ha recaudado hoy 
        $RecaudadoHoy = $consulta->RecaudadoHoy();
        $data["RecaudadoHoy"] = $consulta->moneyFormat($RecaudadoHoy["RecaudadoHoy"]);
        //Listar lo que no se ha recuaudado hoy  
        $NoRecaudadoHoy = $consulta->NoRecaudadoHoy();
        $data["NoRecaudadoHoy"] = $consulta->moneyFormat($NoRecaudadoHoy["NoRecaudadoHoy"]);
        //Listar todas las cuotas vencidas .3 dias 
        $CuotasAVencer = $consulta->listarCuotasVencidas();
        $data["CuotasVencidas"] = @$CuotasAVencer["cantidad"]; 
        //Listar todas las cuotas a vencer 
        $CuotasAVencer = $consulta->listarCuotasAVencer();
        $data["CuotasAVencer"] = @$CuotasAVencer["cantidad"]; 
        //Listar atrasados 
        $atrasados = $consulta->listarAtrasados();
        $data["atrasados"] = $atrasados["cantidad"];
        //Listar todo lo que aun no se pagado desde lel principio 
        $fecha_inicial = $consulta->fechaPrimerCreditoPeriodo($periodo_actual)["fecha_inicial"];
        $fecha_hoy = date("Y-m-d");
        $NoRecaudadoTotal = $consulta->NoRecaudadoTotal($periodo_actual, $fecha_inicial, $fecha_hoy);
        $data["NoRecaudadoTotal"] = $consulta->moneyFormat($NoRecaudadoTotal["NoRecaudadoTotal"]);
        echo json_encode($data);
    break;
    case 'listarCategorias': //Listar el ultimo interes mora insertado 
        $rsta = $consulta->listarCategorias();
        if (empty($rsta)) {
            $data = array(
                'exito' => '0',
                'info' => 'Revisa, no se encontraron datos.'
            );
        } else {
            $data = array(
                'exito' => '1',
                'info_sin_categoria' => $rsta[0]["cantidad"],
                'info_categoria_a' => $rsta[1]["cantidad"],
                'info_categoria_b' => $rsta[2]["cantidad"],
                'info_categoria_c' => $rsta[3]["cantidad"],
                'info_categoria_d' => $rsta[4]["cantidad"],
                'info_categoria_e' => $rsta[5]["cantidad"],
            );
        }
        echo json_encode($data);
    break;
    case 'listarTotalCreditos':
        $data["info_actual"]["Pre-Aprobado"] = 0;
        $data["info_actual"]["Aprobado"] = 0;
        $data["info_actual"]["Pendiente"] = 0;
        $data["info_actual"]["Anulado"] = 0;
        $data["info_comparado"]["Pre-Aprobado"] = 0;
        $data["info_comparado"]["Aprobado"] = 0;
        $data["info_comparado"]["Pendiente"] = 0;
        $data["info_comparado"]["Anulado"] = 0;
        //Listar Aprobados año actual y comparado 
        $actual = $consulta->listarTotalCreditos($periodo_actual);
        $comparado = $consulta->listarTotalCreditos($periodo_comparado);
        if (empty($actual)) {
            $data = array(
                'exito' => '0',
                'info' => 'Revisa, no se encontraron datos.'
            );
        } else {
            $data["exito"] = 1;
            for ($i = 0; $i < count($actual); $i++) {
                $data["info_actual"][$actual[$i]["estado"]] = $actual[$i]["cantidad"];
            }
            for ($i = 0; $i < count($comparado); $i++) {
                $data["info_comparado"][$comparado[$i]["estado"]] = $comparado[$i]["cantidad"];
            }
        }
        echo json_encode($data);
        break;
    case 'BarChar': //Listar el ultimo interes mora insertado
        $rsta = $consulta->cantidadCarteraRecuado($periodo_actual);
        $data = array();
        if (empty($rsta)) {
            $data["exito"] = 0;
        } else {
            $data["exito"] = 1;
            $data['info_actual'] = '[{"y": ' . $rsta['cartera'] . ', "label":"Financiado","color":"#007bff"}, {"y":' . $rsta['pagado'] . ', "label":"Recaudado","color":"green"}]';
        }
        $rsta = $consulta->cantidadCarteraRecuado($periodo_comparado);
        if (empty($rsta)) {
            $data["exito"] = 0;
        } else {
            $data["exito"] = 1;
            $data['info_comparado'] = '[{"y": ' . $rsta['cartera'] . ', "label":"Financiado","color":"#007bff"}, {"y":' . $rsta['pagado'] . ', "label":"Recaudado","color":"green"}]';
        }
        echo json_encode($data);
        break;
    case 'CharProyeccion': //Listar Proyeccion estadisitca 
        $total_cartera = 0; 
        $total_recaudado = 0; 
        $mes_nombre = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']; //arreglo para identificar el mes
        $semestre = explode("-", $periodo_actual); //sacamos en que parte del semestre estamos
        $mes = ($semestre[1] == 1)?1:7;
        for ($i = 0; $i < 6; $i++) {
            $rsta = $consulta->charProyeccion($mes, $semestre[0]); //se traen los datos desde la base 
            $PorRecaudar[] = array("label" =>  $mes_nombre[$mes - 1], "y" => (intval($rsta['total']) - intval($rsta['entro'])));
            $Recaudado[] = array("label" =>  $mes_nombre[$mes - 1], "y" => intval($rsta['entro']) );
            $Total[] = array("label" =>  $mes_nombre[$mes - 1], "y" => intval($rsta['total']));
            $total_recaudado = intval($rsta['entro']) + $total_recaudado;
            $total_cartera = intval($rsta['total']) + $total_cartera;
            $mes++;
        }
        $porcentaje_avance_cartera = round((100 * $total_recaudado) / $total_cartera, 2);
        $data = array('exito' => '1', 'PorRecaudar' => $PorRecaudar, "Recaudado" => $Recaudado, "Total" => $Total, "porcentaje_avance_cartera" => $porcentaje_avance_cartera);
        echo json_encode($data);
        break;
}
