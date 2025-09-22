<?php 
require_once "../modelos/MiCompromiso.php";
require_once "../public/mail/sendPoa.php";

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:S');


$micompromiso=new MiCompromiso();

$id_meta=isset($_POST["id_meta"])? limpiarCadena($_POST["id_meta"]):"";
$id_compromiso=isset($_POST["id_compromiso"])? limpiarCadena($_POST["id_compromiso"]):"";
$id_eje=isset($_POST["meta_ejes"])? limpiarCadena($_POST["meta_ejes"]):"";
$meta_nombre=isset($_POST["meta_nombre"])? limpiarCadena($_POST["meta_nombre"]):"";
$meta_fecha=isset($_POST["meta_fecha"])? limpiarCadena($_POST["meta_fecha"]):"";
$meta_val_admin=isset($_POST["meta_val_admin"])? limpiarCadena($_POST["meta_val_admin"]):"";
$meta_val_usuario=isset($_POST["meta_val_usuario"])? limpiarCadena($_POST["meta_val_usuario"]):"";
$meta_valida=isset($_POST["meta_valida"])? limpiarCadena($_POST["meta_valida"]):"";
$meta_periodo=isset($_POST["meta_periodo"])? limpiarCadena($_POST["meta_periodo"]):"";

$id_fuente=isset($_POST["id_fuente"])? limpiarCadena($_POST["id_fuente"]):"";
$id_meta_fuente=isset($_POST["id_meta_fuente"])? limpiarCadena($_POST["id_meta_fuente"]):"";
$fuente_archivo=isset($_POST["fuente_archivo"])? limpiarCadena($_POST["fuente_archivo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_meta)){
			$rspta=$micompromiso->insertar($id_compromiso,$id_eje,$meta_nombre,$meta_fecha,'0','0',$meta_valida,$meta_periodo);
			echo $rspta ? "meta registrado" : "meta no se pudo registrar";
		}
		else {
			$rspta=$micompromiso->editar($id_meta,$id_compromiso,$id_eje,$meta_nombre,$meta_fecha,$meta_valida,$meta_periodo);
			echo $rspta ? "meta actualizado" : "meta no se pudo actualizar";
		}
	break;

		
	case 'guardaryeditarfuente':
		$fuente="";
		if (!file_exists($_FILES['fuente_archivo']['tmp_name']) || !is_uploaded_file($_FILES['fuente_archivo']['tmp_name']))
		{
			$fuente=$_POST["fuenteactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["fuente_archivo"]["name"]);
			
				$fuente = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["fuente_archivo"]["tmp_name"], "../files/fuentes/" . $fuente);
			
		}
		
		
		if (empty($id_fuente)){
			if($fuente!=""){
				$rspta=$micompromiso->insertarfuente($id_meta_fuente,$fuente,$fecha);
				echo $rspta ? "Fuente registrada" : "Fuente no se pudo registrar";
			}
			else{
				echo "error";
			}
		}
		else {
			$rspta=$micompromiso->editarfuente($id_meta_fuente,$nombre_archivo,$fecha);
			echo $rspta ? "Fuente actualizada" : "Fuente no se pudo actualizar";
		}
	break;	
		
		
	case 'mostrar':
		$rspta=$micompromiso->mostrar($id_meta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'mostrarfuente':
		$rspta=$micompromiso->mostrar($id_meta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;	
		
		
	case 'listar':
		$num=0;
		$contador=0;
		$rsptaperiodo=$micompromiso->buscarperiodo();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		
		$total_metas=0;// variable para saber la cantidad de metas y colocarlas en progress bar
		$total_metas_terminadas=0;
		
		$rspta=$micompromiso->listarMiCompromiso($periodo_actual);
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";
		
		
		
		$color=array('primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt','primary','secondary','success','info','warning','danger','lignt');
		$abrir="show";
		
		$data["0"] .= '
		
		<div class="panel-body table-responsive" id="listadoregistros">
			<div class="card-body">
				<div id="accordion">
		';
		
		//bg-'.$color[$contador].'//
 		$reg=$rspta;
		
		
		
 		for ($i=0;$i<count($reg);$i++){		
			
			
			if($contador==0){
				//$abrir="in"; si queremos que el primer acordeon aparezca abierto
				$abrir="show";
			}else{
				$abrir="";
			}
			
			/*consulta para buscar el id del compromiso */

				$data["0"] .= '
				
				 <div class="card box box-'.$color[$contador].'">
                  <div class="card-header">
                      <h4 class="card-title w-100">
						<button class="btn btn-success btn-sm" id="btnagregar" title="Agregar meta" onclick=mostrarform(true);numerocampo('.$reg[$i]["id_compromiso"].',"'.$reg[$i]["compromiso_fecha"].'")><i class="fa fa-plus-circle"></i> Agregar Metas </button> 

						<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$contador.'" aria-expanded="false" class="collapsed">
							<i class="fas fa-trophy fa-1x"></i> '.$reg[$i]["compromiso_nombre"] .'
						</a>
                    </h4>
                  </div>
				  
			<div id="collapse'.$contador.'" class="collapse '.$abrir.'" data-parent="#accordion">
				<div class="box-body">
				<div class="row">
				  
				';
		
			$rsptadatos=$micompromiso->listarMiMeta($reg[$i]["id_compromiso"],$periodo_actual);
			$regdatos=$rsptadatos;
			
			
			
			for ($j=0;$j<count($regdatos);$j++){	
			
			$total_metas++;	// variable que suma las metas
				
				
			$rsptaeje=$micompromiso->buscarEjes($regdatos[$j]["id_eje"]);
			$regeje=$rsptaeje;
			
			$rsptfuente=$micompromiso->buscarFuente($regdatos[$j]["id_meta"]);
			$regfuente=$rsptfuente;
			
				
			$fecha_tarea=$regdatos[$j]["meta_fecha"];	
				
			$fecha1 = new DateTime($fecha);
			$fecha2 = new DateTime($fecha_tarea);
			$resultado = $fecha1->diff($fecha2);
			$signo=$resultado->format('%R%');
			$diferencia=$resultado->format('%d');
				
				
			$data["0"] .='
			
			<div class="col-xl-6 col-lg-12 col-md-12 col-12">
                    <div class="position-relative p-3" style="background-color:#f9fbf9; margin:4px 0px">
                      <div class="ribbon-wrapper ribbon-lg">';
				
						if($regdatos[$j]["meta_val_admin"]==1){ //si el admin valida
							$data["0"] .= '<div class="ribbon bg-success"> Aprobado</div>';
						}else{
							if($regdatos[$j]["meta_val_usuario"]==0){// si el usuario no envio a validar
								$data["0"] .= '<div class="ribbon bg-danger"> pendiente</div>';
							}else{
								$data["0"] .= '<div class="ribbon bg-warning"> en revisión</div>';
							}
							
						}
				
           	$data["0"] .='
                      </div>
					  
                      <i class="fas fa-hands-helping"></i> '.$regdatos[$j]["meta_nombre"].' <br>
					  <b class="text-success"> '.$regeje["nombre_ejes"].'</b><br>
					  <b>Verifica: </b> '.$regdatos[$j]["meta_valida"].'<br>
					  <b>Corresponsable: </b> '.$regdatos[$j]["corresponsabilidad"].'<br>
					  <i class="far fa-calendar-alt"></i> '.$micompromiso->fechaesp($regdatos[$j]["meta_fecha"]).'';
				
					// codigo para calular los dias que se paso
						if($regdatos[$j]["meta_val_admin"]==0){

							if ($signo == "-" ){	

								$data["0"] .='
								<small class="label label-danger"><i class="fa fa-clock-o"></i> '.$signo.' '.$diferencia.' Dias</small>';

								}
							if ($signo == "+" and $diferencia < 8){	

								$data["0"] .='
								<small class="label label-warning"><i class="fa fa-clock-o"></i> '.$signo.' '.$diferencia.' Dias</small>';

							}if ($signo == "+" and $diferencia > 8){	
								$data["0"] .='
								<small class="label label-success"><i class="fa fa-clock-o"></i> '.$signo.' '.$diferencia.' Dias</small>';
							}
						}
					// ************************* //
				
				
					if($regdatos[$j]["meta_val_admin"]==1){ //si el admin valida

						$total_metas_terminadas++;//sumar metas terminadas

						if($regfuente["fuente_archivo"]!=""){
							$data["0"] .='
							 <br><a href="../files/fuentes/'.$regfuente["fuente_archivo"].'" target="_blank" class="btn btn-success btn-sm"> <i class="fas fa-paperclip"></i> Ver Evidencia: '.$regfuente["fuente_archivo"].'</a>
							';
						}

					}
					else{

						if($regdatos[$j]["meta_val_usuario"]==0){
							
							if(@$regfuente["fuente_archivo"]!=""){
								$data["0"] .='
								 <br><a href="../files/fuentes/'.$regfuente["fuente_archivo"].'" target="_blank" class="btn btn-secondary btn-sm"> <i class="fas fa-paperclip"></i> Ver Evidencia: '.$regfuente["fuente_archivo"].'</a>
								';
							}

							if(@$regfuente["fuente_archivo"]=="" and $reg[$i]["aprobado"]==1){

							$data["0"] .= '						
									<br><a class="btn btn-primary" onclick="mostrarfuente('.$regdatos[$j]["id_meta"].')" title="Fuente de Verificación"><i class="fas fa-paperclip"> Subir Evidencia</i></a>';
							}
							else{
								
							}
							// este comentario es por si queremos activar el editar y el eliminar

							//				<button class="btn btn-warning btn-xs btn-block" onclick="mostrar('.$regdatos[$j]["id_meta"].'),activarCampos()" title="Editar Compromiso"><i class="fas fa-pencil-alt"></i> Editar </button>
							//				<button class="btn btn-danger btn-xs btn-block" onclick="eliminar('.$regdatos[$j]["id_meta"].')" title="Eliminar Meta"><i class="far fa-trash-alt"></i> Eliminar</button>
							$usuario_login=$_SESSION['usuario_login'];

								if(@$regfuente["fuente_archivo"]!= ""){
									if($regdatos[$j]["meta_val_usuario"]==0 ){
										$data["0"] .= '
										<a href="#" onclick=eliminarFuente("'.$regfuente["fuente_archivo"].'",'.$regdatos[$j]["id_meta"].') class="btn"><i class="far fa-window-close"></i>Eliminar </a>';
									}

									$data["0"] .= '
									
									<button class="btn btn-danger btn-sm" onclick=validarMeta('.$regdatos[$j]["id_meta"].',"'.$fecha.'","'.$usuario_login.'") title="Validar Meta">
									  <span class="spinner-border spinner-border-sm"></span> Enviar a validación
									</button>';
								}else{
									$data["0"] .= '';
								}
						}else{
							$total_metas_terminadas++;
							if($regdatos[$j]["meta_val_admin"]==0){
								$data["0"] .= '<br><a class="btn bg-olive btn-sm">             
									<i class="fa fa-coffee"></i> En Revisión
								</a>';
							}else{
								$data["0"] .= '<a class="btn btn-app">             
									<i class="fas fa-business-time fa-2x" style="color:#FF0000"></i><br>Meta Vencida
								</a>';
							}
						}

					}	
				
				
				$data["0"] .='
                    </div>
                  </div>';
                            
			
			}
			

			$contador++;
			
			$data["0"] .= '
				</div>
				</div>
			  </div>
			</div>';
			
 		}
		
		$data["0"] .= '
				<!-- /.box-body -->
			  </div>
		</div>
		';
		
		$progreso=round(($total_metas_terminadas*100)/$total_metas);
		if($progreso<40){
			$barra="progress-bar-danger";
		}
		else if($progreso<60){
			$barra="progress-bar-warning";
		}
		else if($progreso<80){
			$barra="";
		}
		else{
			$barra="progress-bar-success";
		}
		$data["1"] = '<div class="progress-bar '.$barra.' progress-bar-striped active" role="progressbar"
					  aria-valuenow="'.$progreso.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$progreso.'%"> Total Metas:'
						.$total_metas.'/' .$total_metas_terminadas. ' - - '.$progreso.'% Progreso (success)
					</div>';
 
		
 		$results = array($data);
 		echo json_encode($results);

	break;
		
	case 'eliminar':
		
		$rspta=$micompromiso->eliminar($id_meta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	case 'eliminarFuente':
		
		$rspta=$micompromiso->eliminarFuente($_POST["id_meta"]);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
		unlink("../files/fuentes/" . $_POST["fuente"]);
		
	break;
		
	case 'validarMeta':
		$id_meta_val=$_POST["id_meta"];
		$fecha=$_POST["fecha"];
		$remite=$_POST["correo_usuario"];
		
		$rspta=$micompromiso->validarMeta($id_meta_val,$fecha);// actualiza la meta a enviado

		$rspta2=$micompromiso->mostrar($id_meta_val);
		$meta=$rspta2["meta_nombre"];
		$meta_valida=$rspta2["meta_valida"];
		$rspta3=$micompromiso->correoDestinatario($meta_valida);
		$destinatario=$rspta3["usuario_login"];
		
		$mensaje="Cordial saludo: Para reportar una nueva evidencia en la plataforma de <b>COMPROMISOS</b> <br><br>";
		$asunto="Nueva Evidencia";
		
		mensajePoa($remite,$destinatario,$mensaje,$meta,$asunto);
		//el valor lo trae el correo si es correcto trae 1
	break;	
	
	case "selectEjes":	
		$rspta = $micompromiso->selectEjes();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_ejes"] . "'>" . $rspta[$i]["nombre_ejes"] . "</option>";
				}
	break;
		
	case "selectPeriodo":	
		$rspta = $micompromiso->selectPeriodo();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"]. "</option>";
				}
	break;
		
	case "selectListaSiNo":	
	$rspta = $micompromiso->selectListaSiNo();
	for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["valor"] . "'>" . $rspta[$i]["nombre_lista"] . "</option>";
			}
	break;	
		
	case "selectListaCargo":	
	$rspta = $micompromiso->selectlistaCargo();
	for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["usuario_cargo"]. "'>" . $rspta[$i]["usuario_cargo"] . "</option>";
			}
	break;
	
}
?>