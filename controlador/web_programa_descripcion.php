<?php 
require_once "../modelos/Web_Programa_Descripcion.php";
// variables para datos de registro
$fecha=date('Y-m-d');
$hora=date('H:i');
$ip = $_SERVER['REMOTE_ADDR']; 
//variable para saber que usuario hizo el registro
$id_usuario = $_SESSION['id_usuario'];
error_reporting(1); 

$web_programas = new Web_Programa_Descripcion();

$id_programa=isset($_POST["id_programa"])? limpiarCadena($_POST["id_programa"]):"";

// variables globals para agregar 
$titulo_descripcion=isset($_POST["titulo_descripcion"])? limpiarCadena($_POST["titulo_descripcion"]):"";
$descripcion_programa=isset($_POST["descripcion_programa"])? limpiarCadena($_POST["descripcion_programa"]):"";
$id_web_programa_descripcion=isset($_POST["id_web_programa_descripcion"])? limpiarCadena($_POST["id_web_programa_descripcion"]):"";
$url_video=isset($_POST["url_video"])? limpiarCadena($_POST["url_video"]):"";
$categoria_noticias_video=isset($_POST["categoria_noticias_video"])? limpiarCadena($_POST["categoria_noticias_video"]):"";
$categoria_programas=isset($_POST["categoria_programas"])? limpiarCadena($_POST["categoria_programas"]):"";
$nombre_desempenate=isset($_POST["nombre_desempenate"])? limpiarCadena($_POST["nombre_desempenate"]):"";

// variables globals para editar
$id_web_programa_descripcion_editar=isset($_POST["id_web_programa_descripcion_editar"])? limpiarCadena($_POST["id_web_programa_descripcion_editar"]):"";
$titulo_descripcion_editar=isset($_POST["titulo_descripcion_editar"])? limpiarCadena($_POST["titulo_descripcion_editar"]):"";
$descripcion_programa_editar=isset($_POST["descripcion_programa_editar"])? limpiarCadena($_POST["descripcion_programa_editar"]):"";
$url_video_editar=isset($_POST["url_video_editar"])? limpiarCadena($_POST["url_video_editar"]):"";
$categoria_noticias_video_editar=isset($_POST["categoria_noticias_video_editar"])? limpiarCadena($_POST["categoria_noticias_video_editar"]):"";
$categoria_programas_editar=isset($_POST["categoria_programas_editar"])? limpiarCadena($_POST["categoria_programas_editar"]):"";
$guardar_img_programas_editar=isset($_POST["guardar_img_programas_editar"])? limpiarCadena($_POST["guardar_img_programas_editar"]):"";
$nombre_desempenate_editar=isset($_POST["nombre_desempenate_editar"])? limpiarCadena($_POST["nombre_desempenate_editar"]):"";
$id_programa_desempenate=isset($_POST["id_programa_desempenate"])? limpiarCadena($_POST["id_programa_desempenate"]):"";
$id_desempenate_descripcion_editar=isset($_POST["id_desempenate_descripcion_editar"])? limpiarCadena($_POST["id_desempenate_descripcion_editar"]):"";


switch ($_GET["op"]){

	case 'listarprogramas':
		$rspta	= $web_programas->mostrarprogramas();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i ++){
			$titulo_descripcion = $reg[$i]["titulo_descripcion"];
			$descripcion_programa = $reg[$i]["descripcion_programa"];
			$id_web_programa_descripcion   = $reg[$i]["id_web_programa_descripcion"];
			$img_programas  = $reg[$i]["imagen_descripcion"];
			$img_programas_movil  = $reg[$i]["video_descripcion"];
			// $video_descripcion  = $reg[$i]["video_descripcion"];
			$id_programas  = $reg[$i]["id_programas"];
			$nombre_programa  = $reg[$i]["nombre_programa"];
			$url_imagen_con_video ='
			<div>
				<button class="btn btn-danger pull-right" id="btnagregar" onclick="ver_video(' . $id_web_programa_descripcion_editar . ')"><i class="fa fa-play" aria-hidden="true"></i></button>
			</div>';

			$estado  = $reg[$i]["estado"];
			$ruta_img = '../public/web_programa_descripcion/';
			$estado = ($estado == 1) ?'<span class="badge badge-success p-1">Activado</span>' :'<span class="badge badge-danger p-1">Desactivado</span>';
			$imagen_eliminar = ($estado == 1) ? "" :$img_programas;
			$url_imagen = ($estado == 1)?'':'<img width="100%" src="'.$ruta_img.$img_programas.'">';

			$url_imagen_con_video ='
			<div>
				<button class="btn btn-danger pull-right" id="btnagregar" onclick="ver_video(' . $id_programas . ')"><i class="fa fa-play" aria-hidden="true"></i></button>
			</div>';
			$data[]=array(	
			"0"=>($reg[$i]["estado"])?'
				<div class="btn-group">
					<button class="tooltip-agregar btn btn-success btn-xs" onclick=mostrar_programas_desempenate('.$id_web_programa_descripcion.','.$id_programas.') title="Agregar campo profesional"> <i class="fas fa-plus"></i> 
					</button>'.'
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_programas_descripcion('.$id_web_programa_descripcion .')" title="Editar Programa" data-toggle="tooltip" data-placement="top"> <i class="fas fa-pencil-alt"></i>
					</button>'.'
					<button class="tooltip-agregar btn btn-success btn-xs" onclick="desactivar_programas('.$id_web_programa_descripcion .')" title="Desactivar"><i class="fas fa-lock-open"></i></button>
				</div>':'<button class="tooltip-agregar btn btn-secondary btn-xs" onclick="activar_programas('.$id_web_programa_descripcion .')" title="Activar"><i class="fas fa-lock"></i></button>',
					"1"=>$nombre_programa,
					"2"=>'
					<div style="width:150px !important;">
						'.$url_imagen.'
						</style>
					</div>',
					"3"=>$url_imagen_con_video,
					"4"=>'<div style="overflow:hidden; height:100px">'.$titulo_descripcion,
					"5"=>'<div style="overflow:hidden; height:100px">'.$descripcion_programa,
					"6"=>$estado
			);

				
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
	break;

	case 'agregarprorgama':

		$ext = explode(".", $_FILES["agregar_imagen_descripcion"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_programa_descripcion/';
		if (!file_exists($_FILES['agregar_imagen_descripcion']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_descripcion']['tmp_name']))
		{
			$agregar_imagen_descripcion=$guardar_img_programas;
		}else{
			
			if ($_FILES['agregar_imagen_descripcion']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_imagen_descripcion"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_imagen_descripcion']['tmp_name'], $img1path_movil)) {
					$agregar_imagen_descripcion = $_FILES['agregar_imagen_descripcion']['name'];

				} 
			}
			else{
				echo "<br>"."Error Extensión No Valida";
				
			}
		}
			$estado=1;
			$rspta = $web_programas->insertarprogramas($id_web_programa_descripcion,$categoria_programas, $agregar_imagen_descripcion, $url_video, $titulo_descripcion, $descripcion_programa, $estado, $ip, $hora, $fecha, $id_usuario);
			echo $rspta ? "Descripción registrado " : "<br>"."Descripción no insertado";
	break;


	case 'agregarprorgamadesempenate':
		$rspta = $web_programas->insertarprogramasdesempenate($id_programa_desempenate,$id_programa, $nombre_desempenate);
		echo $rspta ? "Desempeñate registrado " : "Desempeñate no insertado";	
	break;

	case 'imagenyvideo':

		$data[0] = '';
		$rspta	= $web_programas->mostrar_programas_descripcion($id_web_programa_descripcion);
		
		$video_descripcion = $rspta["video_descripcion"];
		$titulo_descripcion = $rspta["titulo_descripcion"];
		
		$data[0] .= '
		<div class="form-group mb-3 position-relative check-valid">
			<div class="form-floating">
				<input type="text" placeholder="" value="'.$titulo_descripcion.'" required="" class="form-control border-start-0" name="url_video_editar" id="url_video_editar" maxlength="100" required>
				<label>Url Video</label>
			</div>
		</div>
		<div class="invalid-feedback">Please enter valid input</div>

		';
		echo json_encode($data);
		break;
		
		case 'desempenatemodal':
			$id_programa_post = $_POST["id_programa"];
			$data[0] = '';	
			$data[0] .= '
			<div class="form-group col-12">
				<label for="exampleFormControlTextarea1">Prorgama Desempeñate</label>
				<textarea class="form-control" name="nombre_desempenate" id="nombre_desempenate" rows="5"></textarea>
			</div>';
			$data[0].='
			<div class="col-12">
				<button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Agregar campo profesional</button>
			</div><br>';
			
			$rspta_desempenate	= $web_programas->mostrar_programa_desempenate($id_programa_post);
			$data[0] .= '	
			<div class="container">
				<div class="row">
					<div class="col-12">

						<div class="panel-body table-responsive p-4">
							<table id="refrescartabla_accion" class="table" style="width:100%">
								<thead>
									<th scope="col">Nombre</th>
									<th scope="col">Acción</th>
								</thead>
								<tbody>
						</div>';
							for ($i=0;$i<count($rspta_desempenate);$i++){

								$nombre_desempenate = $rspta_desempenate[$i]["nombre_desempenate"];
								$id_programa_desempenate  = $rspta_desempenate[$i]["id_programa_desempenate"];
								$data[0] .= '						
									<tr>
										<td>'.$nombre_desempenate.'</td>
										<td>
											<spam class="btn btn-primary btn-xs" onclick="mostrar_modal_desempenate('.$id_programa_desempenate.')" title="Editar Programa Desempenate" data-placement="top"><i class="fas fa-pencil-alt"></i></spam>
											<spam class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_programa_desempenate('.$id_programa_desempenate.')" title="Programa Desempenate" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></spam>									
										</td>
									</tr>';
							}				
							$data[0] .= '
							
							</tbody>
							</table>
					</div>
				</div>
			</div>';

		echo json_encode($data);
	break;

	case 'mostrar_desempenate_editar':
		$rspta = $web_programas->desempenate_editar($id_programa_desempenate);
		echo json_encode($rspta);
	break;

	case 'mostrar_programas_descripcion':
		$rspta = $web_programas->mostrar_programas_descripcion($id_web_programa_descripcion);
		echo json_encode($rspta);
	break;

	case 'guardaryeditarprogramas':
		$ext = explode(".", $_FILES["agregar_imagen_programa_editar"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_programa_descripcion/';

		if (!file_exists($_FILES['agregar_imagen_programa_editar']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_programa_editar']['tmp_name']))
		{
			$agregar_imagen_programa_editar = $guardar_img_programas_editar;
		}
		else
		{
			if ($_FILES['agregar_imagen_programa_editar']['type'] == "image/webp")
			{
				$img1path_escritorio = $target_path . "".$_FILES["agregar_imagen_programa_editar"]["name"]; 
				
				if (move_uploaded_file($_FILES['agregar_imagen_programa_editar']['tmp_name'], $img1path_escritorio)) {
					$agregar_imagen_programa_editar = $_FILES['agregar_imagen_programa_editar']['name'];
					
					if ($agregar_imagen_programa_editar !== $guardar_img_programas_editar && file_exists($target_path.$guardar_img_programas_editar)) {
						unlink($target_path.$guardar_img_programas_editar);
					}
				} 
			}
			else {
				echo "<br>"."Error Extensión No Valida";
			}
		}

		$estado=1;
		$rspta = $web_programas->editarprogramas($agregar_imagen_programa_editar, $url_video_editar,$titulo_descripcion_editar,$descripcion_programa_editar, $id_web_programa_descripcion,$categoria_programas_editar);
		echo $rspta ? "Descripción actualizado" : "<br>"."Descripción no se pudo actualizar";	
	break;
	
	case 'guardaryeditardesempenate':
		$rspta = $web_programas->editarprogramasdesempenate($nombre_desempenate_editar,$id_desempenate_descripcion_editar);
		echo $rspta ? "Desempeñate actualizado" : "<br>"."Desempeñate no se pudo actualizar";	
	break;

	case 'eliminar_programas':
		$img_programas = $_POST["imagen_eliminar"];
		$eliminar_programas = $web_programas->eliminarPrograma($id_web_programa_descripcion);
		unlink("../public/web_programa_descripcion/".$img_programas);  
		echo json_encode($eliminar_programas);
		
	break;


	case 'desactivar_programas':
		$rspta=$web_programas->desactivar_programa($id_web_programa_descripcion);
		echo json_encode($rspta);

	break;

	case 'activar_programas':
		$rspta=$web_programas->activar_programa($id_web_programa_descripcion);
		echo json_encode($rspta);

	break;

	case "Categoria_video":	
		$rspta = $web_programas->noticias_categoria();
		echo "<option selected>Nothing selected</option>";
		for ($i=0;$i<count($rspta);$i++){
			$nombre_categoria = $rspta[$i]["nombre_desempenate"];
			$id_programa_desempenate  = $rspta[$i]["id_programa_desempenate"];
			echo "<option value='".$id_programa_desempenate."'>" .$nombre_categoria. "</option>" ;
		}
	break;

	case "Categoria_Prorgama":	
		$rspta = $web_programas->noticias_categoria_programas();
		echo "<option selected>Nothing selected</option>";
		for ($i=0;$i<count($rspta);$i++){
			$nombre_categoria = $rspta[$i]["nombre_programa"];
			$id_programa_desempenate  = $rspta[$i]["id_programas"];
			echo "<option value='".$id_programa_desempenate."'>" .$nombre_categoria. "</option>" ;
		}
	break;
	case 'ver_video':
		$id_programas = $_POST["id_programas"];
		$ver_video_programas = $web_programas->mostrar_video_programa($id_programas);
		$video_descripcion = $ver_video_programas["video_descripcion"];

		$data[0] = "";
		$data[0] .= '

		<iframe src="https://www.youtube.com/embed/' . $video_descripcion . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  style="width: 478px !important; height: 341px !important;"></iframe>';

		echo json_encode($data);
		break;

		case 'eliminar_programa_desempenate':
			$rspta = $web_programas->eliminar_programa_desempenate($id_programa_desempenate);
			echo json_encode($rspta);
		break;
	

}
