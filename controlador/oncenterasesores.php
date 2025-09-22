<?php 
session_start();
require_once "../modelos/OncenterAsesores.php";
date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:s');


$consulta=new OncenterAsesores();

$rsptaperiodo = $consulta->periodoactual();	
$periodo_campana=$rsptaperiodo["periodo_campana"];
$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];
$fecha_tareas=$rsptaperiodo['fecha_tareas'];

$periodo_actual=$_SESSION['periodo_actual'];
//$periodo_siguiente=$_SESSION['periodo_siguiente'];
$usuario_cargo=$_SESSION['usuario_cargo'];
$id_usuario=$_SESSION['id_usuario'];


/* variables agregar sefuimiento */
$asesor=isset($_POST["asesor"])? limpiarCadena($_POST["asesor"]):"";
$fecha_desde=isset($_POST["fecha_desde"])? limpiarCadena($_POST["fecha_desde"]):"";
$fecha_hasta=isset($_POST["fecha_hasta"])? limpiarCadena($_POST["fecha_hasta"]):"";
/* ********************* */


switch ($_GET["op"]){
		
	case 'listar':
		$id_usuario=$_GET["asesor"];
		$fecha_desde=$_GET["fecha_desde"];
		$fecha_hasta=$_GET["fecha_hasta"];
		
		$rspta=$consulta->listar($id_usuario,$fecha_desde,$fecha_hasta);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			$id_etiqueta=$reg[$i]["id_etiqueta"];
			$consultaretiqueta=$consulta->consultaretiqueta($id_etiqueta);

			$fecha_obj = new DateTime($reg[$i]["hora_seguimiento"]);
            $formato_12_horas = $fecha_obj->format('g:i A');
			
 			$data[]=array(
 				"0"=>$reg[$i]["id_estudiante"],				
				"1"=>$reg[$i]["motivo_seguimiento"],
				"2"=>$reg[$i]["mensaje_seguimiento"],
 				"3"=>'<div style="width:250px">'.$consulta->fechaesp($reg[$i]["fecha_seguimiento"]).'</div>',
 				"4"=>'<div style="width:100px">'.$formato_12_horas.'</div>',
				"5"=>'<div style="width:150px">'.$consultaretiqueta["etiqueta_nombre"].'</div>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
			
	case "selectAsesor":	
		$rspta = $consulta->selectAsesor();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $rspta[$i]["usuario_nombre"] . " " . $rspta[$i]["usuario_apellido"] . "</option>";
				}
	break;

	case "datos":
		$data['citas'] = "";
		$data['llamada'] = "";
		$data['segui'] = "";
		$data['whatsapp'] = "";

		$citas = $consulta->datos($fecha_tareas,"Cita");
		$data['citas'] .= count($citas);

		$llamada = $consulta->datos($fecha_tareas,"Llamada");
		$data['llamada'] .= count($llamada);

		$seguimiento = $consulta->datos($fecha_tareas,"Seguimiento");
		$data['segui'] .= count($seguimiento);

		$whatsapp = $consulta->datos($fecha_tareas,"Whatsapp");
		$data['whatsapp'] .= count($whatsapp);

		echo json_encode($data);
	break;
	case "datosEtiquetas":
		$data['datos'] = "";
		$traeretiquetas = $consulta->traerEtiquetas();
		$data['datos'] .='<div class="row">';
	

	
			for($i=0; $i< count($traeretiquetas); $i++){
				$etiqueta=$traeretiquetas[$i]["etiqueta_nombre"];
				$id_etiqueta=$traeretiquetas[$i]["id_etiquetas"];
				if($id_etiqueta !=12){
					

					$datos = $consulta->traerSeguiEtiquetas($fecha_tareas,$id_etiqueta);
					$data['datos'] .='	
						<div class="col text-center">
							<div class="row justify-content-center">
								<div class="col-11  border">
									<span class="fw-bolder text-regular fs-24">'.count($datos).'</span><br>
									<span class="small text-secondary mb-1 line-height-16">'.$etiqueta.'</span>
								</div>
							</div>
							
						</div>';
				}
			}
		$data['datos'] .='</div>';


		echo json_encode($data);
	break;


}



?>
