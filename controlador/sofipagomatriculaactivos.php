<?php
require_once("../public/sofi_mail/send.php");
require_once("../public/sofi_mail/templatePreAprobado.php");
require_once "../modelos/SofiPagoMatriculaActivos.php";
$consulta = new SofiPagoMatriculaActivos();

$rsta = $consulta->periodoActualyAnterior();
$periodo_actual = $rsta["periodo_actual"];
$periodo_anterior = $rsta["periodo_anterior"];

$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : die(json_encode(array("exito" => 0, "info" => "Su sesión ha caducado, vuelva a iniciar sesión")));
switch ($_GET['op']) {
    case 'listarFinanciados': //Listar el ultimo interes mora insertado
        $periodo = $_GET["periodo"];
        $rsta = $consulta->listarActivos($periodo);
        $array = array();
        for ($i = 0; $i < count($rsta); $i++) {
            $id_estudiante = $rsta[$i]["id_estudiante"];
            $buscarprograma = $consulta->traerNombrePrograma($rsta[$i]["programa"]);
            $buscar_pago_rematricula = $consulta->buscarPagoRematricula($id_estudiante, $periodo);
            $buscar_credito = $consulta->buscarCredito($rsta[$i]["credencial_identificacion"], $periodo, $rsta[$i]["programa"]);
            $buscar_pago_Web = $consulta->buscarPagoWeb($rsta[$i]["credencial_identificacion"], $periodo);
            $array[] = array(
                "0" => $id_estudiante . ' - ' . $rsta[$i]["credencial_identificacion"],
                "1" => $rsta[$i]["credencial_nombre"] . " " . $rsta[$i]["credencial_apellido"],
                "2" => $rsta[$i]["credencial_login"],
                "3" => $buscarprograma["nombre"],
                "4" => $rsta[$i]["jornada_e"],
                "5" => $rsta[$i]["semestre"],
                "6" => @$buscar_pago_rematricula["x_amount_base"],
                "7" => @$buscar_pago_rematricula["realiza_proceso"],
                "8" => @$buscar_credito["estado"],
                "9" => @$buscar_pago_Web["x_amount_base"]
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
    case 'listarPeriodos': //mostrar el id especifico
        $rsta = $consulta->periodosEnSofi();
        if ($rsta >= 1) {
            $option = "";
            for ($i = 0; $i < count($rsta); $i++) {
                $option  .= "<option " . (($rsta[$i]['periodo'] == $periodo_actual) ? "selected" : "") . " value='" . $rsta[$i]['periodo'] . "'>" . $rsta[$i]['periodo'] . "</option>";
            }
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
}