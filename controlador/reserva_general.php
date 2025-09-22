<?php
require_once "../modelos/ReservaGeneral.php";
$consulta = new ReservaGeneral();
$days = array("Lunes" => 1, "Martes" => 2, "Miercoles" => 3, "Jueves" => 4, "Viernes" => 5, "Sabado" => 6);

date_default_timezone_set("America/Bogota");

$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];




switch ($_GET['op']) {

    case 'historialReservas':
        
        $rspta = $consulta->historialReservas($periodo_actual);
        $data = array();
        for ($i = 0; $i < count($rspta); $i++) {
            $data[] = array(
                "0" => $rspta[$i]["salon"],
                "1" => !empty($rspta[$i]["detalle_reserva"]) ? $rspta[$i]["detalle_reserva"] : "Sin motivo",
                "2" => !empty($rspta[$i]["nombre_docente"]) ? $rspta[$i]["nombre_docente"] : "Sin nombre",
                "3" => $consulta->convertir_fecha_completa($rspta[$i]["fecha_reserva"]),
                "4" => $rspta[$i]["horario"] . " A " . $rspta[$i]["hora_f"],
                "5" => '<span class="badge badge-success">' . (($rspta[$i]["estado"] == 1) ? "Finalizada" : "activa") . '</span>',
                "6" => '<button type="button" class="btn btn-success" onclick="mostrarReserva(' . $rspta[$i]["id"] . ')" data-toggle="modal" data-target="#modalReserva">
            <i class="fas fa-eye"></i>
        </button>'
            );
        }
        $result = array(
            "sEcho" => 1, //Información para el datatble
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($result);
        break;

    case 'mostrar_reserva_por_id':
        $id = $_POST['id'];
        $rspta = $consulta->consultar_reserva_por_id($id);
        echo json_encode($rspta);
        break;


}
