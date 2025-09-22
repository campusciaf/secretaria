<?php
session_start();
require_once "../modelos/CertificadoEstudianteServicioSocial.php";

$id_credencial = isset($_GET["id_credencial"]) ?$_GET["id_credencial"] : "";


$certificado_estudiante = new certificadoEstudianteServicioSocial();

$datos_estudiante = $certificado_estudiante->listarDatosPostulados($id_credencial);
		
				
$nombre_estudiante = $datos_estudiante['credencial_nombre'] . ' ' . $datos_estudiante['credencial_nombre_2']." ". $datos_estudiante['credencial_apellido'] . ' ' . $datos_estudiante['credencial_apellido_2'];

$datos_programa = $certificado_estudiante->listarDatosPrograma($id_credencial);

$fo_programa = $datos_programa['fo_programa'];
$semestre_estudiante = $datos_programa['semestre_estudiante'];

$datos_empresa = $certificado_estudiante->listarActividadesConEmpresa($id_credencial);

if ($datos_empresa && is_array($datos_empresa)) {
    $nombre_empresa = isset($datos_empresa[0]['nombre_empresa']) ? $datos_empresa[0]['nombre_empresa'] : "Nombre no disponible";
    $ac_realizadas = isset($datos_empresa[0]['ac_realizadas']) ? $datos_empresa[0]['ac_realizadas'] : "Actividades no disponibles";
	$actividades_competencias = isset($datos_empresa[0]['actividades_competencias']) ? $datos_empresa[0]['actividades_competencias'] : "Actividades no disponibles";
} else {
    $nombre_empresa = "Nombre no disponible";
    $ac_realizadas = "Actividades no disponibles";
}

$fecha_actual = date('Y-m-d');//2023-10-01
$fecha_actual= $certificado_estudiante->fechaesp($fecha_actual);//miercoles, 01 de octubre de 2023
