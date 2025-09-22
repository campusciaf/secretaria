<?php 
require_once "../modelos/Corresponsabilidad.php";

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:S');


$corresponsabilidad=new Corresponsabilidad();


switch ($_GET["op"]){
	
	case 'listar':
		$num=0;
		$contador=0;
		
		$rsptaperiodo=$corresponsabilidad->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		
		
		$rspta=$corresponsabilidad->listarValidaciones($periodo_actual);
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";

		$reg=$rspta;
		$data["0"] .= '<div class="row">';
 		for ($i=0;$i<count($reg);$i++){	
			
			$rspta1 = $corresponsabilidad->buscarUsuario($reg[$i]["id_compromiso"]);			
			$reg1 = $rspta1;
		
			
			@$rspta2=$corresponsabilidad->datosUsuario($reg1['id_usuario']);			
			$reg2=$rspta2;
			
			
			$rspta3=$corresponsabilidad->listarFuente($reg[$i]["id_meta"]);			
			$reg3=$rspta3;
			
			$fecha_tarea=$reg[$i]["fecha_val_usuario"];	
			
			$fecha1 = new DateTime($fecha);
			$fecha2 = new DateTime($fecha_tarea);
			$resultado = $fecha1->diff($fecha2);
			$signo=$resultado->format('%R%');
			$diferencia=$resultado->format('%d');
			

			if($reg[$i]["meta_val_admin"]==0){
				$color="#f7f7f7";
			}
			else{
				$color="#dff0d8";
			}
			
		$data["0"] .= '
		
		<div class="col-xl-6 col-sm-6">
			<div class="position-relative p-3" style="background-color:#f9fbf9; margin:4px 0px">
			  <div class="ribbon-wrapper ribbon-lg">';
			
					if($reg[$i]["meta_val_admin"]==1){
						$data["0"] .= '<div class="ribbon bg-success">Finalizado</div>';
					}
					else if($reg[$i]["meta_val_admin"]==0 and $reg[$i]["meta_val_usuario"]==1){
						$data["0"] .= '<div class="ribbon bg-warning">Revisión</div>';
					}
					else{
						$data["0"] .= '<div class="ribbon bg-danger">sin gestión</div>';
					}
				  
			$data["0"] .= '	  
				
			  </div>
			  <img src="../files/usuarios/'.@$reg2['usuario_imagen'].'" class="rounded float-left" style="width: 50px;height: 70px; margin-right: 5px">
			  
			  '.@$reg2["usuario_cargo"].' <br>' 
			  .@$reg2["usuario_nombre"]. " " . @$reg2["usuario_apellido"].'<br>'
			  . @$reg2["usuario_email"] .'
			  
			  <hr>
			  <small>'.$reg[$i]["meta_nombre"].'</small>';

		$data["0"] .= '	
				<br><b>Plazo limite Evidencia:</b> <i class="fas fa-calendar"></i> '.$corresponsabilidad->fechaesp($reg[$i]["meta_fecha"]).'
				
				<br><b>Publicación evidencia:</b> '.$corresponsabilidad->fechaesp($reg[$i]["fecha_val_usuario"]).'
				
				<br><b>Fecha de aprobación:</b> '.$corresponsabilidad->fechaesp($reg[$i]["fecha_val_admin"]);
				if($reg[$i]["meta_val_usuario"]==1){
					$data["0"] .= '	
					<br><a href="../files/fuentes/'.$reg3["fuente_archivo"].'" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-paperclip"></i> Ver archivo'.$reg3["fuente_archivo"].'</a> ';
				}else{
					$data["0"] .= '<br><span class="btn btn-danger disabled">Pendiente</span>';
				}
			
		$data["0"] .= '			
			</div>
		  </div>';
		

		}
		$data["0"] .= '</div>';
		
 		$results = array($data);
 		echo json_encode($results);

	break;
		

	case 'validarMeta':
		$id_meta_val=$_POST["id_meta"];
		$fecha=$_POST["fecha"];
		$rspta=$corresponsabilidad->validarMeta($id_meta_val,$fecha);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
		
	case 'noValidarMeta':
		$id_meta_val=$_POST["id_meta"];
		$fecha=$_POST["fecha"];
		$rspta=$corresponsabilidad->noValidarMeta($id_meta_val,$fecha);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	
}
?>