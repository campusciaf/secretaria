<?php
session_start();
date_default_timezone_set("America/Bogota");
require_once "../modelos/AgregarSeguiTareas.php";
$consulta = new AgregarSeguiTareas();
$id_usuario = $_SESSION['id_usuario'];
$periodo_actual = $_SESSION['periodo_actual'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fechahora = date('Y-m-d H:i:s');
switch ($_GET['op']) {
    case 'agregar':
        $id_estudiante = $_POST["id_estudiante"];
        $data = array(); //Vamos a declarar un array
        $data["0"] = ""; //iniciamos el arreglo
        $data["0"] .= '';
        $results = array($data);
        echo json_encode($results);
        break;
    case 'agregarSeguimiento':
        $id_credencial = isset($_POST["id_credencial_segui"]) ? limpiarCadena($_POST["id_credencial_segui"]) : "";
        $id_persona = isset($_POST["id_persona_segui"]) ? limpiarCadena($_POST["id_persona_segui"]) : "";
        $seg_descripcion = isset($_POST["seg_descripcion"]) ? limpiarCadena($_POST["seg_descripcion"]) : "";
        $seg_tipo = isset($_POST["seg_tipo"]) ? limpiarCadena($_POST["seg_tipo"]) : "";
        $rspta = $consulta->insertarSeguimiento($seg_descripcion, $seg_tipo, $id_usuario, $fechahora, $id_persona, $id_credencial);
        echo $rspta ? "Seguimiento registrado" : "Seguimiento no se pudo registrar";
        break;
    case 'agregarTarea':
        $id_persona = isset($_POST["id_persona_tarea"]) ? limpiarCadena($_POST["id_persona_tarea"]) : "";
        $id_credencial = isset($_POST["id_credencial_tarea"]) ? limpiarCadena($_POST["id_credencial_tarea"]) : "";
        $tarea_motivo = isset($_POST["tarea_motivo"]) ? limpiarCadena($_POST["tarea_motivo"]) : "";
        $tarea_observacion = isset($_POST["tarea_observacion"]) ? limpiarCadena($_POST["tarea_observacion"]) : "";
        $tarea_fecha = isset($_POST["tarea_fecha"]) ? limpiarCadena($_POST["tarea_fecha"]) : "";
        $tarea_hora = isset($_POST["tarea_hora"]) ? limpiarCadena($_POST["tarea_hora"]) : "";
        $rspta = $consulta->insertarTarea($id_persona, $id_credencial, $id_usuario, $tarea_motivo, $tarea_observacion, $fechahora, $tarea_fecha, $tarea_hora);
        echo $rspta ? "Tarea Programada" : "Tarea no se pudo Programar";
        break;
    case 'verHistorial':
        $id_credencial = $_POST["id_credencial"];
        $data = array(); //Vamos a declarar un array
        $data["0"] = ""; //iniciamos el arreglo
        $results = array($data);
        echo json_encode($results);
        break;
}
