<?php
require_once "../modelos/SofiConsultaCreditos.php";

$consulta = new SofiConsultaCreditos();

$rsta = $consulta->periodoActualyAnterior();
$periodo_actual = $rsta["periodo_actual"];
$periodo_anterior = $rsta["periodo_anterior"];
$estado_array = array(
    'Pendiente' => 'bg-yellow',
    'Pre-Aprobado'=>'bg-lightblue',
    'Anulado'=>'bg-red',
    'Aprobado'=>'bg-success',
);
$id_usuario = isset($_SESSION['id_usuario'])?$_SESSION['id_usuario']:die(json_encode(array("exito" => 0, "info" => "Su sesión ha caducado, vuelva a iniciar sesión")));
switch ($_GET['op']){
    case 'listarPeriodos': //mostrar el id especifico
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
    case 'listarFinanciados': 
        $periodo = $_GET["periodo"];
        $array = array();
        $rsta = $consulta->listarFinanciados($periodo);   
        for($i = 0; $i < count($rsta); $i++){
            $array[] = array(
                "0" => $rsta[$i]["cedula"],
                "1" => $rsta[$i]["consecutivo"],
                "2" => $rsta[$i]["nombre"],
                "3" => $rsta[$i]["programa"],
                "4" => $rsta[$i]["semestre"],
                "5" => $rsta[$i]["jornada"],
                "6" => $rsta[$i]["credito"],
                "7" => $rsta[$i]["faltante"], 
                "8" => $rsta[$i]["cuotas"],
                "9" => $rsta[$i]["cuotas_atrasadas"],
                "10" => $rsta[$i]["periodo"],
                "11" => $rsta[$i]["motivo"], 
                "12" =>$rsta[$i]["atraso"], 
                "13" =>$rsta[$i]["estado"],
                "14" =>$rsta[$i]["fecha_ultimo_pago"], 
                "15" =>($rsta[$i]["credito_finalizado"] == 1)?"Si":"No", 
            );
 		}
		$results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array);
        echo json_encode($results);
    break;
}
?>