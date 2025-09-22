<?php
require_once "../modelos/ContratoDocentes.php";
$contrato_docente = new ContratoDocentes();
$id_docente_contrato = $_GET['uid'];
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';
$rspta_usuario = $contrato_docente->BuscarDocenteContratado($id_docente_contrato, $periodo);
if (!empty($rspta_usuario)) {
    $nombre_docente = $rspta_usuario[0]['nombre_docente'];
    $nombre_apellido = $rspta_usuario[0]['nombre_apellido'];
    $nombre_completo = $nombre_docente . " " . $nombre_apellido;
    $documento_docente = $rspta_usuario[0]['documento_docente'];
    $tipo_contrato = $rspta_usuario[0]['tipo_contrato'];
    $valor_contrato = $rspta_usuario[0]['valor_contrato'];
    $fecha_inicio = $rspta_usuario[0]['fecha_inicio'];
    $fecha_final = $rspta_usuario[0]['fecha_final'];
    $periodo = $rspta_usuario[0]['periodo'];
    $auxilio_transporte = $rspta_usuario[0]['auxilio_transporte'];
    $usuario_email_p = $rspta_usuario[0]['usuario_email_p'];
    // variables para hora catedra
    $cantidad_horas = $rspta_usuario[0]['cantidad_horas'];
    $valor_horas = $rspta_usuario[0]['valor_horas'];
    $materia_docente = $rspta_usuario[0]['materia_docente'];
    // tomamos el id usuario para mostrar quien elaboro el contrato.
    $id_usuario = $rspta_usuario[0]['id_usuario'];
    $rspta_usuario = $contrato_docente->Nombre_Usuario_Creo_Contrato($id_usuario);
    $nombre_completo_realizo = $rspta_usuario[0]['usuario_nombre'] . " " . $rspta_usuario[0]['usuario_nombre_2'] . " " . $rspta_usuario[0]['usuario_apellido'] . " " . $rspta_usuario[0]['usuario_apellido_2'];
    $nombre_usuario_creo_contrato = ucwords(strtolower($nombre_completo_realizo));
    // Convertir el mes de inicio a texto
    $meses = [
        '01' => 'enero',
        '02' => 'febrero',
        '03' => 'marzo',
        '04' => 'abril',
        '05' => 'mayo',
        '06' => 'junio',
        '07' => 'julio',
        '08' => 'agosto',
        '09' => 'septiembre',
        '10' => 'octubre',
        '11' => 'noviembre',
        '12' => 'diciembre'
    ];
    // variables para el inicio del contrato 
    $fecha_inicio_array = explode('-', $fecha_inicio);
    $anio_inicio = $fecha_inicio_array[0];
    $mes_inicio_numero = $fecha_inicio_array[1];
    $dia_inicio = $fecha_inicio_array[2]; //02
    $mes_inicio_texto = $meses[$mes_inicio_numero]; //febrero
    $anio_inicio_letras = "dos mil veinticinco "; // año en letra
    // Procesar la fecha final
    $fecha_final_array = explode('-', $fecha_final);
    $anio_final = $fecha_final_array[0];
    $mes_final_numero = $fecha_final_array[1];
    // variables para el final del contrato
    $dia_final = $fecha_final_array[2]; //31
    $mes_final_texto = $meses[$mes_final_numero]; //diciembre
    //realiazmos condicional para no perjudicar algun campo que tome el cargo, y los colocamos de manera manual
    if ($id_usuario == 98) {
        $cargo_usuario = "Analista Jurídica";
    } elseif ($id_usuario == 78) {
        $cargo_usuario = "Asistente de Talento Humano";
    } else {
        $cargo_usuario = "";
    }
} else {
    $nombre_docente = $documento_docente = $tipo_contrato = $fecha_inicio = $fecha_final = '____________';
}
