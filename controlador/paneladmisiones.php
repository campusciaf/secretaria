<?php 
require_once "../modelos/PanelAdmisiones.php";
$consulta = new Modelos();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";
$fecha_anterior=date("Y-m-d",strtotime($fecha."- 1 days"));
$semana = date("Y-m-d",strtotime($fecha."- 1 week")); 
$semana_area = date("Y-m-d",strtotime($fecha."- 1 week")); 

$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_campana = $rsptaperiodo["periodo_campana"];
$periodo_medible = $rsptaperiodo["periodo_medible"];
$id_usuario = $_SESSION['id_usuario'];


switch ($_GET["op"]){

	case "selectPeriodo":	
		$rspta = $consulta->selectPeriodo();
        echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

	case 'listar':

		$data= Array();
		$data="";
		$periodo=$_POST["periodo"];

		$totalcampana=$consulta->totalCampana($periodo);
		$totalmatriculados=$consulta->totalMatriculados($periodo);
		$interesados=count($totalcampana);
		$matriculados=count($totalmatriculados);
      
		$data .= "Interesados:".$interesados." Matriculados:".$matriculados;

		
		if ($interesados > 0) {
			$conversion = ($matriculados / $interesados) * 100;
			$conversion = round($conversion, 2); // redondear a 2 decimales
		} else {
			$conversion = 0;
		}

		$data .= '
	
			<div class="col-xl-4">
				<div class="card border-0 mb-4">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<i class="fa-solid fa-graduation-cap avatar avatar-40 bg-light-blue rounded me-2"></i>
							</div>
							<div class="col-auto">

							</div>
						</div>
					</div>
					<div class="card-body">
						<p class="mb-2">Interesados</p>
						<p class="fs-18 text-muted mb-4">'.$interesados.' <span class="small">Est.</span></p>

						<h5 class="mb-1">'.$matriculados.' <small>Matriculados</small></h5>
						<p class="small text-theme"><i class="fa-solid fa-arrow-up"></i>'.$conversion.'% conversión</p>
					</div>
				</div>
			</div>
		';
        echo json_encode($data);

	break;



}

?>