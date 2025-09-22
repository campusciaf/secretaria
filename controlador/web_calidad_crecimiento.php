<?php 
require_once "../modelos/Web_Calidad_Crecimiento.php";
$fecha=date('Y-m-d');
$hora=date('H:i');

$ip = $_SERVER['REMOTE_ADDR']; 
$web_calidad_crecimiento = new Web_Calidad_Crecimiento();

//variables globales para insertar la imagen 
$id_web_calidad_crecimiento=isset($_POST["id_web_calidad_crecimiento"])? limpiarCadena($_POST["id_web_calidad_crecimiento"]):"";
$titulo_calidad_agregar=isset($_POST["titulo_calidad_agregar"])? limpiarCadena($_POST["titulo_calidad_agregar"]):"";
$url_calidad=isset($_POST["url_calidad"])? limpiarCadena($_POST["url_calidad"]):"";
$editarguardarimg=isset($_POST["editarguardarimg"])? limpiarCadena($_POST["editarguardarimg"]):"";
$imagen_calidad=isset($_POST["imagen_calidad"])? limpiarCadena($_POST["imagen_calidad"]):"";
$agregar_imagen=isset($_POST["agregar_imagen"])? limpiarCadena($_POST["agregar_imagen"]):"";
$id_usuario = $_SESSION['id_usuario'];

//variables globales para editar la imagen 
$id_web_calidad_crecimiento_editar=isset($_POST["id_web_calidad_crecimiento_editar"])? limpiarCadena($_POST["id_web_calidad_crecimiento_editar"]):"";
$titulo_calidad_editar=isset($_POST["titulo_calidad_editar"])? limpiarCadena($_POST["titulo_calidad_editar"]):"";
$url_calidad_editar=isset($_POST["url_calidad_editar"])? limpiarCadena($_POST["url_calidad_editar"]):"";
$editarguardarimg_editar=isset($_POST["editarguardarimg_editar"])? limpiarCadena($_POST["editarguardarimg_editar"]):"";
$imagen_calidad_editar=isset($_POST["imagen_calidad_editar"])? limpiarCadena($_POST["imagen_calidad_editar"]):"";
$agregar_imagen_editar=isset($_POST["agregar_imagen_editar"])? limpiarCadena($_POST["agregar_imagen_editar"]):"";


switch ($_GET["op"]){

	case 'listarcalidad':
		$rspta	= $web_calidad_crecimiento->mostrarcalidad();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i ++){
			$titulo = $reg[$i]["titulo_calidad"];
			$imagen_calidad = $reg[$i]["imagen_calidad"];
			$url_calidad = $reg[$i]["url_calidad"];
			$id_web_calidad_crecimiento  = $reg[$i]["id_web_calidad_crecimiento"];
			$estado  = $reg[$i]["estado"];
			$estado = ($estado == 1) ?'<span class="badge badge-success p-1">Activado</span>' :'<span class="badge badge-danger p-1">Desactivado</span>';
			$ruta_img = '../public/web_calidad_crecimiento/';
			$imagen_calidad = ($estado == 1)?"":$imagen_calidad;				
			$url_imagen = ($estado == 1)?$imagen_calidad:'<img width="100%" src="'.$ruta_img.$imagen_calidad.' ">';
			
			$data[]=array(	

				"0"=>($reg[$i]["estado"])?'
					<div class="btn-group">
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_imagen_editar('.$id_web_calidad_crecimiento.')"  title="Editar Calidad" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>'.'
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_calidad('.$id_web_calidad_crecimiento.',`'.$imagen_calidad.'`)" title="Eliminar Calidad" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
					
					'.
					' <button class="tooltip-agregar btn btn-success btn-xs" onclick="desactivar_calidad('.$id_web_calidad_crecimiento.')" title="Desactivar"><i class="fas fa-lock-open"></i></button>':
					
					' <button class="tooltip-agregar btn btn-secondary btn-xs" onclick="activar_calidad('.$id_web_calidad_crecimiento.')" title="Activar"><i class="fas fa-lock"></i></button></div>',
					
					"1"=>'
					<div style="width:100px !important; ">
						'.$url_imagen.'
					</div>
					',
					"2"=>$titulo,
					"3"=>$url_calidad,
					"4"=>$estado
			);
			
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
	break;
	
	case 'mostrar_imagen':
		$rspta = $web_calidad_crecimiento->mostrar_calidad($id_web_calidad_crecimiento);
		echo json_encode($rspta);
	break;

	case 'agregar_imagen':

		$ext = explode(".", $_FILES["agregar_imagen"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_calidad_crecimiento/';
		if (!file_exists($_FILES['agregar_imagen']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen']['tmp_name']))
		{
			$imagen_calidad=$editarguardarimg;
		}else{
			
			if ($_FILES['agregar_imagen']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_imagen"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_imagen']['tmp_name'], $img1path_movil)) {
					$imagen_calidad = $_FILES['agregar_imagen']['name'];
				} 

				if (empty($id_web_calidad_crecimiento)){				
					$estado=1;

					$rspta = $web_calidad_crecimiento->insertarcalidad($id_web_calidad_crecimiento, $titulo_calidad_agregar, $imagen_calidad, $url_calidad, $ip, $hora, $fecha,$id_usuario,$estado);
					echo $rspta ? "Calidad registrada" : "<br>"."Error Extensión No Valida false";	
				}
			}
			else{
				echo "Error Extensión No Valida";
				$imagen_calidad=$editarguardarimg;
				
			}
		
		}

	break;

	case 'guardaryeditarcalidad':

		$ext = explode(".", $_FILES["agregar_imagen_editar"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_calidad_crecimiento/';
		if (!file_exists($_FILES['agregar_imagen_editar']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name']))
		{
			$imagen_calidad_editar=$editarguardarimg_editar;
		}else{
			
			if ($_FILES['agregar_imagen_editar']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_imagen_editar"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name'], $img1path_movil)) {
					$imagen_calidad_editar = $_FILES['agregar_imagen_editar']['name'];
					unlink("../public/web_calidad_crecimiento/".$editarguardarimg_editar);
				} 
			}
			else{
				echo "Error Extensión No Valida";
				$imagen_calidad_editar=$editarguardarimg_editar;
			}
		
		}

		$rspta = $web_calidad_crecimiento->editarcalidad($titulo_calidad_editar, $imagen_calidad_editar, $url_calidad_editar, $id_web_calidad_crecimiento_editar);
		echo $rspta ? "<br>"."Calidad actualizado" : "Calidad no se pudo actualizar";	
	
	break;

	case 'eliminar_calidad':
		$imagen_calidad = $_POST["imagen_calidad"];
		$eliminar_calidad = $web_calidad_crecimiento->eliminarCalidad($id_web_calidad_crecimiento);
		unlink("../public/web_calidad_crecimiento/".$imagen_calidad);  
		echo json_encode($eliminar_calidad);
	break;


	case 'desactivar_calidad':
		$rspta=$web_calidad_crecimiento->desactivar_calidad($id_web_calidad_crecimiento);
		echo json_encode($rspta);

	
	break;

	case 'activar_calidad':
		$rspta=$web_calidad_crecimiento->activar_calidad($id_web_calidad_crecimiento);
		echo json_encode($rspta);
	break;





	

}
