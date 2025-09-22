<?php
require_once "../modelos/SofiBaseOriginacion.php";
$consulta = new SofiBaseOriginacion();
switch ($_GET['op']) {
    case 'listarBaseOriginacion': //Listar el ultimo interes mora insertado 
        $rsta = $consulta->listarBaseOriginacion();
        $estrato_arr = array("" => "", "1" =>"Bajo - Bajo", "2" => "Bajo", "3" => "Medio - Bajo", "4" => "Medio", "5" => "Medio - Alto", "6" => "Alto");
        $array  = array();
        for ($i = 0; $i < count($rsta); $i++) {
            $nombres = $rsta[$i]["nombres"];
            $apellidos = $rsta[$i]["apellidos"];
            $tipo_documento = $rsta[$i]["tipo_documento"];
            $consecutivo = $rsta[$i]["consecutivo"];
            $numero_documento = $rsta[$i]["numero_documento"];
            $genero = $rsta[$i]["genero"];
            $fecha_nacimiento = isset($rsta[$i]["fecha_nacimiento"])? $rsta[$i]["fecha_nacimiento"]:'0000-00-00';
            $fecha_nacimiento = date("d/m/Y", strtotime($fecha_nacimiento));
            $edad = $rsta[$i]["edad"];
            $estado_civil = $rsta[$i]["estado_civil"];
            $numero_hijos = $rsta[$i]["numero_hijos"];
            $nivel_educativo = $rsta[$i]["nivel_educativo"];
            $ocupacion = $rsta[$i]["ocupacion"];
            $sector_laboral = $rsta[$i]["sector_laboral"];
            $tiempo_servicio = $rsta[$i]["tiempo_servicio"];
            $create_dt = $rsta[$i]["create_dt"];
            $salario = $rsta[$i]["salario"];
            $tipo_vivienda = $rsta[$i]["tipo_vivienda"];
            $ciudad = $rsta[$i]["ciudad"];
            $nacionalidad = $rsta[$i]["nacionalidad"];
            $persona_a_cargo = $rsta[$i]["persona_a_cargo"];
            $fecha_inicial = date("d/m/Y", strtotime($rsta[$i]["fecha_inicial"]));
            $ultima_fecha_cuota = date("d/m/Y", strtotime($rsta[$i]["ultima_fecha_cuota"]));
            $valor_financiacion = $rsta[$i]["valor_financiacion"];
            $cantidad_tiempo = $rsta[$i]["cantidad_tiempo"];
            $programa = $rsta[$i]["programa"];
            $semestre = $rsta[$i]["semestre"];
            $periodo = $rsta[$i]["periodo"];
            $estrato = $rsta[$i]["estrato"];

            $array[] = array(
                "0" => $nombres. " ".$apellidos,
                "1" => $tipo_documento,
                "2" => $numero_documento,
                "3" => $consecutivo,
                "4" => $genero,
                "5" => $fecha_nacimiento,
                "6" => $edad,
                "7" => $estado_civil,
                "8" => $estrato_arr[$estrato],
                "9" => $numero_hijos,
                "10" => $nivel_educativo,
                "11" => $ocupacion,
                "12" => $sector_laboral,
                "13" => $tiempo_servicio,
                "14" => $salario,
                "15" => $tipo_vivienda,
                "16" => $ciudad,
                "17" => $nacionalidad,
                "18" => $persona_a_cargo,
                "19" => $fecha_inicial,
                "20" => $ultima_fecha_cuota,
                "21" => $valor_financiacion,
                "22" => $cantidad_tiempo,
                "23" => $programa,
                "24" => $semestre,
                "25" => $periodo,
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
}
