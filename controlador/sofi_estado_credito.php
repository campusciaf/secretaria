<?php
require_once "../modelos/SofiEstadoCredito.php";
$consulta = new SofiEstadoCredito();
$periodo_actual = $_SESSION['periodo_actual'];
$estado_array = array('Pendiente' => 'bg-yellow', 'Pre-Aprobado' => 'bg-lightblue', 'Anulado' => 'bg-red', 'Aprobado' => 'bg-success');
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 0;
switch ($_GET['op']) {
        // Listar el ultimo interes mora insertado
    case 'listarCreditosActivos':
        $periodo = $_GET["periodo"];
        $array = array();
        $rsta = $consulta->listarCreditosActivos($periodo);
        $numero_cuota_anterior = 0;
        for ($i = 0; $i < count($rsta); $i++) {
            extract($rsta[$i]);
            $dias_de_atraso = 0;
            if ($estado != "Pagado" && $fecha_pago < date("Y-m-d")) {
                $credito_finalizado = "Atrasado";
                $datetime1 = new Datetime($fecha_pago);
                $datetime2 = new Datetime(date("Y-m-d"));
                $dias_de_atraso = date_diff($datetime1, $datetime2);
                $dias_de_atraso = $dias_de_atraso->format('%a');
            } 
            $array[] = array(
                "0" => $cedula,
                "1" => $id,
                "2" => strtoupper($nombres . " " . $apellidos),
                "3" => strtoupper($email),
                "4" => strtoupper($celular),
                "5" => strtoupper($programa),
                "6" => $semestre,
                "7" => strtoupper($jornada),
                "8" => $numero_cuota,
                "9" => $fecha_pago,
                "10" => $fecha_pagada,
                "11" => ($numero_cuota == $numero_cuota_anterior) ? "0" : $valor_cuota,
                "12" => $historico_valor_pagado,
                "13" => $periodo,
                "14" => strtoupper($motivo_financiacion),
                "15" => $dias_de_atraso,
                "16" => $credito_finalizado,
            );
            $numero_cuota_anterior = $numero_cuota;
        }
        $results = array(
            // Información para el datatables
            "sEcho" => 1,
            // Enviamos el total registros al datatable
            "iTotalRecords" => count($array),
            // Enviamos el total registros a visualizar
            "iTotalDisplayRecords" => count($array),
            // Arreglo  
            "aaData" => $array
        );
        echo json_encode($results);
        break;
        // Mostrar el id especifico
    case 'listarPeriodos':
        $rsta = $consulta->periodosEnSofi();
        if ($rsta >= 1) {
            $option = "<option disabled value=''>- Selecciona un periodos -</option>";
            for ($i = 0; $i < count($rsta); $i++) {
                $option  .= "<option " . (($rsta[$i]['periodo'] == $periodo_actual) ? "selected" : "") . " value='" . $rsta[$i]['periodo'] . "'>" . $rsta[$i]['periodo'] . "</option>";
            }
            $option .= "<option value='Todos'> Todos </option>";
            $array = array(
                "exito" => 1,
                "info" => $option,
            );
        } else {
            $array = array(
                "exito" => 0
            );
        }
        echo json_encode($array);
        break;
    case 'EliminarCeros':
        $rsta = $consulta->EliminarCeros();
        if ($rsta) {
            echo "listo";
        } else {
            echo "no listo";
        }
        break;
    case 'updateAllPagos':
        $rspta = $consulta->listarCuotasID();
        for ($i = 0; $i < count($rspta); $i++) {
            $id_historial = $rspta[$i]['id_historial'];
            $consecutivo = $rspta[$i]['consecutivo'];
            $numero_cuota = $rspta[$i]['numero_cuota'];

            $id_financiamiento = $consulta->financiamientoPorConsecutivoCuota($consecutivo, $numero_cuota);
            $consulta->UpdatePagos($id_historial, $id_financiamiento);
            echo "$id_financiamiento";
        }
        break;
}
