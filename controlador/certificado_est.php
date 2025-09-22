<?php
session_start();
require_once "../modelos/CertificadoEst.php";

date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:s');
$certificado_estudiante = new CertificadoEst();


switch ($_GET["op"]) { 
	case 'Listar':
		$rspta = $certificado_estudiante->ListarEstudiantesConHoras(); 
		$data = array();
		$reg = $rspta;
	
		for ($i = 0; $i < count($reg); $i++) {
			$data[] = array(
				"0" => $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"], 
				"1" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"],
				"2" => $reg[$i]["celular"], 
				"3" => $reg[$i]["email"], 
				"4" => '
					<div class="text-center">
						' . $reg[$i]["horas_acumuladas"] . 'Horas
						<a class="btn btn-success btn-xs ml-2" href="certificado_estudiante_servicio_social.php?id_credencial='.$reg[$i]["id_credencial"].'" target="_blank" title="Descargar Certificado" data-toggle="tooltip" data-placement="top">
							<i class="fas fa-download"></i>
						</a>
					</div>',
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);
	
		echo json_encode($results);
		break;
	
}
