<?php
require_once("../modelos/SofiDeContado.php");

$consulta = new DeContado();
$rsta = $consulta->periodoActualyAnterior();
$periodo_actual = $rsta["periodo_actual"];

switch ($_GET["op"]) {
    case 'listarContado':
        $array = array();
        $data = $consulta->listarContados();

        for($i = 0; $i < count($data); $i++) {
            $array[] = array(
                "0" => '<button class="btn bg-yellow btn-flat btn-sm btn-editar-usuario" onclick="mostrar('.$data[$i]["id_contado"].')" data-idusuario="'.$data[$i]["id_contado"].'"><i data-toggle="tooltip" title="" class="fa fa-pen" data-original-title="Editar Interes"></i></button>'.(($data[$i]["primer_curso"] == 1 && $data[$i]["matricula_campus"] == 1)?"<button onclick = 'enviarCampus(this, ".$data[$i]['id_contado'].")' class='btn btn-sm bg-primary btn-flat'><i data-toggle='tooltip' title='Enviar al campus' class='fas fa-share-square' data-original-title='Enviar Constancia al Campus'></i></button>":""),
                "1" => $data[$i]["documento"],
                "2" => $data[$i]["nombre"] . " " . $data[$i]["apellido"],
                "3" => $data[$i]["telefono"],
                "4" => $data[$i]["direccion"],
                "5" => $data[$i]["jornada"],
                "6" => $data[$i]["semestre"],
                "7" => $data[$i]["programa"],
                "8" => $data[$i]["valor_total"],
                "9" => $data[$i]["valor_pagado"],
                "10" => $data[$i]["descuento"],
                "11" => $data[$i]["motivo_descuento"],
                "12" => $data[$i]["periodo"],
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
    case 'listarProgramas':
        $rsta = $consulta->listarProgramas();
        $array = array();
        $html = "";
        for ($i = 0; $i < count($rsta); $i++) {
            $html .= "<option value='" . $rsta[$i]["nombre"] . "' >" . $rsta[$i]["nombre"] . "</option>";
        }
        $array = array("exito" => 1, "info" => $html);
        echo json_encode($array);
    break;
    case 'mostrarInfoEstudiante':
        $documento = isset($_POST["documento"])? $_POST["documento"] : "";
        $rsta = $consulta->mostrarInfoEstudiante($documento);
        if(is_array($rsta) && count($rsta) > 0){
            $data = array("exito" => 1, $rsta);
        }else{
            $data["exito"] = 0;
        }
        echo json_encode($data);
    break;
    case 'guardaryEditar':
        $id_contado = isset($_POST["id_contado"]) ? $_POST["id_contado"] : die(json_encode(array("exito" => 0, "info" => "Estuadiante obligatorio")));
        $documento = isset($_POST["documento"]) ? $_POST["documento"] : "";
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
        $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
        $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
        $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $programa = isset($_POST["programa"]) ? $_POST["programa"] : "";
        $semestre = isset($_POST["semestre"]) ? $_POST["semestre"] : "";
        $jornada = isset($_POST["jornada"]) ? $_POST["jornada"] : "";
        $valor_total = isset($_POST["valor_total"]) ? $_POST["valor_total"] : die(json_encode(array("exito" => 0, "info" => "Valor total obligatorio")));
        $valor_pagado = isset($_POST["valor_pagado"]) ? $_POST["valor_pagado"] : die(json_encode(array("exito" => 0, "info" => "Valor de pago obligatorio")));
        $motivo_pago = isset($_POST["motivo_pago"]) ? $_POST["motivo_pago"] : "";
        $primer_curso = isset($_POST["primer_curso"]) ? $_POST["primer_curso"] : "";
        $descuento = isset($_POST["descuento"]) ? $_POST["descuento"] : "";
        $descuento_por = isset($_POST["motivo_descuento"]) ? $_POST["motivo_descuento"] : "";
        $descuento = empty($descuento) ? 0 : $descuento;
        $descuento_por = empty($descuento_por) ? "No Aplica" : $descuento_por;
        $periodo = $periodo_actual;

        if(empty($id_contado)){
            $rspta = $consulta->insertarContado($documento, $nombre, $apellido, $direccion, $telefono, $email, $programa, $semestre, $jornada, $valor_total, $valor_pagado, $motivo_pago, $primer_curso, $descuento, $descuento_por, $periodo);
        }else{
            $rspta = $consulta->editarContado($id_contado, $documento, $nombre, $apellido, $direccion, $telefono, $email, $programa, $semestre, $jornada, $valor_total, $valor_pagado, $motivo_pago, $primer_curso, $descuento, $descuento_por, $periodo);
        }
        if($rspta){
            $data = array("exito" => 1, "info" => "Consulta realziada con exito");
        } else {
            $data = array("exito" => 0, "info" => "Eror al realiar la consulta");
        }
        echo json_encode($data);
    break;
    case "enviarCampus":
        //tomo el id desde la vista 
        $id_persona = isset($_POST['id_persona']) ? $_POST['id_persona'] : "";
        //consulto y almaceno el documento. la fecha y hora actual
        $rspta = $consulta->verInfoContado($id_persona);
        $documento = $rspta["documento"];
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        //busco el periodo de campaña en el cual estamos
        $res = $consulta->obtenerPeriodoCampana();
        $periodo = $res["periodo_campana"];
        //con el respectivo periodo y documento buscamos al interesado
        $rspta = $consulta->buscarInteresado($documento, $periodo);
        //si la respuesta tiene datos
        if (is_array($rspta)) {
            $datos = $rspta;
            $id_estudiante_agregar = $datos["id_estudiante"];
            $id_usuario = 38; //Jhuliana Blanco 
            $asesor = "Jhuliana Blanco";
            //si el estudiante tiene los documentos subidos, pasa inmediatamente a admitido y se insertan los respestivos seguimientos
            if ($datos["estado"] == "Seleccionado" && $datos["documentos"] == 0) {
                $rspta = $consulta->actualizar_seleccionado($id_estudiante_agregar);
                $motivo_seguimiento = 'Seguimiento';
                $mensaje_seguimiento = '<div style=background-color:#7AAD21> Cambio de estado: Admitido.</div>';
                $consulta->insertarSeguimientoOncenter($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $asesor);
                $mensaje_seguimiento = 'Validación de pago de matrícula';
                $consulta->insertarSeguimientoOncenter($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $asesor);
            } else { //si no solo se cambia el estado y se agrega el respectivo seguimiento
                $rspta = $consulta->actualizar_matriculado($id_estudiante_agregar);
                $motivo_seguimiento = 'Seguimiento';
                $mensaje_seguimiento = '<span style=background-color:#b806d8> Soporte recibo matrícula verificado</span>';
                $consulta->insertarSeguimientoOncenter($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $asesor);
            }
            //si todo sale correcto se cambias el estado en el sofi
            if ($rspta) {
                $rspta = $consulta->actualizarEnvioCampus($id_persona);
                if ($rspta) {
                    echo (json_encode(array("exito" => 1, "info" => "Todo se ha realizado con exito")));
                } else {
                    echo (json_encode(array("exito" => 0, "info" => "Error al actualizar el envio del SOFI")));
                }
            } else {
                echo (json_encode(array("exito" => 0, "info" => "Error al actualizar el estudiante")));
            }
        } else {
            echo (json_encode(array("exito" => 0, "info" => "No tiene ningún proceso de admisión")));
        }
    break;
    case 'mostrar':
        $id_contado = isset($_POST["id_contado"]) ? $_POST["id_contado"] : "";
        $rsta = $consulta->verInfoContado($id_contado);
        if (is_array($rsta) && count($rsta) > 0) {
            $data = array("exito" => 1, $rsta);
        } else {
            $data["exito"] = 0;
        }
        echo json_encode($data);
    break;
}
?>