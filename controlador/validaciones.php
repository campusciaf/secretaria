<?php 

require_once "../modelos/Validaciones.php";
require_once "../public/mail/sendPoa.php";

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:S');


$validaciones=new Validaciones();


switch ($_GET["op"]){
	
	
		case 'listar':
		$rspta=$validaciones->listarValidaciones();
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
 		for ($i=0;$i<count($reg);$i++){	
			
			$rspta1 = $validaciones->buscarUsuario($reg[$i]["id_compromiso"]);			
			$reg1 = $rspta1;
		
			
			$rspta2=$validaciones->datosUsuario($reg1['id_usuario']);			
			$reg2=$rspta2;
			
			
			$rspta3=$validaciones->listarFuente($reg[$i]["id_meta"]);			
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
			
 			$data[]=array(
				"0"=>'<a href="#" class="ad-click-event">
                                    <img src="../files/usuarios/'.$reg2['usuario_imagen'].'" alt="'.$reg2["usuario_nombre"]. " " . $reg2["usuario_apellido"].'" title="'.$reg2["usuario_nombre"]. " " . $reg2["usuario_apellido"].'" class="media-object" style="width: 40px;height: 50px;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);">
                                </a>',
 				"1"=>$reg2["usuario_cargo"],
				"2"=>'<span style="margin-top: 0">'.$reg[$i]["meta_nombre"].'</span>',
				"3"=>'
					<i class="fas fa-paperclip"></i> 
					<a href="../files/fuentes/'.$reg3["fuente_archivo"].'" target="_blank">'.$reg3["fuente_archivo"].'</a>',
				"4"=>'<i class="fas fa-calendar"></i> '.$validaciones->fechaesp($reg[$i]["meta_fecha"]),
				"5"=>($reg[$i]["meta_val_usuario"]==1 and $reg[$i]["meta_val_admin"]==0)?
					'	
					<a href="#" onclick=validarMeta('.$reg[$i]["id_meta"].',"'.$fecha.'") class="btn btn-success btn-sm ad-click-event">
					VALIDAR META
					</a><br>
					<a href="#" onclick=noValidarMetaForm('.$reg[$i]["id_meta"].',"'.$reg2['usuario_email'].'") class="btn btn-danger btn-sm ad-click-event">
					NO VALIDAR....
					</a>
					':'<i class="fas fa-check-double" style="color:green"></i> Validado',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
		
		
	case 'listarp':

		$rspta=$validaciones->listarValidaciones();
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";

		$reg=$rspta;
		
 		for ($i=0;$i<count($reg);$i++){	
			
			$rspta1 = $validaciones->buscarUsuario($reg[$i]["id_compromiso"]);			
			$reg1 = $rspta1;
		
			
			$rspta2=$validaciones->datosUsuario($reg1['id_usuario']);			
			$reg2=$rspta2;
			
			
			$rspta3=$validaciones->listarFuente($reg[$i]["id_meta"]);			
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
	<div class="col-lg-6 col-md-12 col-sm-12">	
		<div class="box box-solid alto_div" style="background-color:'.$color.'">
                    <div class="box-body">
                        <h4 style="background-color:'.$color.'; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                            '.$reg2["usuario_cargo"].'
                        </h4>
                        <div class="media">
                            <div class="media-left">
                                <a href="#" class="ad-click-event">
                                    <img src="../files/usuarios/'.$reg2['usuario_imagen'].'" alt="'.$reg2["usuario_nombre"]. " " . $reg2["usuario_apellido"].'" title="'.$reg2["usuario_nombre"]. " " . $reg2["usuario_apellido"].'" class="media-object" style="width: 100px;height: 120px;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="clearfix">
                                    <p class="pull-right">';
										if($reg[$i]["meta_val_usuario"]==1 and $reg[$i]["meta_val_admin"]==0){
										$data["0"] .= '	
											<a href="#" onclick=validarMeta('.$reg[$i]["id_meta"].',"'.$fecha.'") class="btn btn-success btn-sm ad-click-event">
											VALIDAR META
											</a><br>
											<a href="#" onclick=noValidarMeta('.$reg[$i]["id_meta"].',"'.$fecha.'") class="btn btn-danger btn-sm ad-click-event">
											NO VALIDAR....
											</a>
											';
										}else{
											if($reg[$i]["meta_val_admin"]==0){
												$data["0"] .= '<button type="button" class="btn bg-orange btn-flat margin" onclick="info()">En proceso</button>';
											}else{
												$data["0"] .= '<i class="fas fa-check-double"></i>';
											}
										}
			$data["0"] .= '
	
                                    </p>

                                    <h4 style="margin-top: 0">'.$reg[$i]["meta_nombre"].'</h4>

                                    <p><i class="fas fa-paperclip"></i> <a href="../files/fuentes/'.$reg3["fuente_archivo"].'" target="_blank">'.$reg3["fuente_archivo"].'</a> </p>
									<p style="margin-bottom: 0">
									<i class="fas fa-calendar"></i> '.$validaciones->fechaesp($reg[$i]["meta_fecha"]).'
									</p>
			
                                    <p style="margin-bottom: 0">
										<b>Para revisión:</b> '.$validaciones->fechaesp($reg[$i]["fecha_val_usuario"]).'
                                    ';
			
									if ($reg[$i]["meta_val_admin"] == 0 and $reg[$i]["meta_val_usuario"] == 1 ){	
										if($diferencia <= 0){
											$data["0"] .='
											<small class="label label-success"><i class="fa fa-clock-o"></i> '.$diferencia.' Dias</small>';
										}else if($diferencia <= 2){
											$data["0"] .='
											<small class="label label-warning"><i class="fa fa-clock-o"></i> '.$diferencia.' Dias</small>';
										}else if($diferencia >= 3){
											$data["0"] .='
											<small class="label label-danger"><i class="fa fa-clock-o"></i> '.$diferencia.' Dias</small>';
										}
	
									}
								
				$data["0"] .= '</p>';
									if($reg[$i]["meta_val_admin"]==1){	
									$data["0"] .= '
									<p style="margin-bottom: 0">
									<b>Aprobación:</b> '.$validaciones->fechaesp($reg[$i]["fecha_val_admin"]).'
									</p>';
									}
				$data["0"] .= '					
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
		</div>
		';
		}
		
 		$results = array($data);
 		echo json_encode($results);

	break;
		
	case 'listar2':
		$rspta=$validaciones->listar();
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
 		for ($i=0;$i<count($reg);$i++){
 			$data[]=array(
				"0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg[$i]["id_ejes"].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
				
				<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg[$i]["id_ejes"].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>',
 				"1"=>$reg[$i]["nombre_ejes"],
 				"2"=>$reg[$i]["periodo"],
				"3"=>$reg[$i]["objetivo"]
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
		
		
	case 'validarMeta':
		$id_meta_val=$_POST["id_meta"];
		$fecha=$_POST["fecha"];
		$rspta=$validaciones->validarMeta($id_meta_val,$fecha);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
		
	case 'noValidarMeta':
		$id_meta_val=$_POST["id_meta"];
		$rspta=$validaciones->noValidarMeta($id_meta_val);
 		echo json_encode($rspta);
	break;
		
	case 'enviarMensaje':
		$destinatario=$_POST["correo"];
		$mensaje=$_POST["mensaje"];
		$id_meta=$_POST["id_meta"];
		
		$rspta=$validaciones->datosUsuarioCorreo();
		$remite=$rspta["usuario_login"];
		$rspta2=$validaciones->datosMeta($id_meta);
		$meta=$rspta2["meta_nombre"];
		$asunto="Meta No Aprobada";
		
		mensajePoa($remite,$destinatario,$mensaje,$meta,$asunto);
		
	break;
		
	
	
}
?>