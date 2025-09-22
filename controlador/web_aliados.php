<?php 
require_once "../modelos/Web_Aliados.php";
$fecha=date('Y-m-d');
$hora=date('H:i');

$ip = $_SERVER['REMOTE_ADDR']; 
$web_aliados = new Web_Aliados();

//variables globales para insertar la imagen 
$id_web_aliados=isset($_POST["id_web_aliados"])? limpiarCadena($_POST["id_web_aliados"]):"";
$nombre_aliado=isset($_POST["nombre_aliado"])? limpiarCadena($_POST["nombre_aliado"]):"";
$url_aliado=isset($_POST["url_aliado"])? limpiarCadena($_POST["url_aliado"]):"";
$editarguardarimg=isset($_POST["editarguardarimg"])? limpiarCadena($_POST["editarguardarimg"]):"";
$imagen_aliados=isset($_POST["imagen_aliados"])? limpiarCadena($_POST["imagen_aliados"]):"";
$agregar_imagen=isset($_POST["agregar_imagen"])? limpiarCadena($_POST["agregar_imagen"]):"";
$id_usuario = $_SESSION['id_usuario'];

//variables globales para editar la imagen 
$id_web_aliados_editar=isset($_POST["id_web_aliados_editar"])? limpiarCadena($_POST["id_web_aliados_editar"]):"";
$nombre_aliado_editar=isset($_POST["nombre_aliado_editar"])? limpiarCadena($_POST["nombre_aliado_editar"]):"";
$url_aliado_editar=isset($_POST["url_aliado_editar"])? limpiarCadena($_POST["url_aliado_editar"]):"";
$editarguardarimg_editar=isset($_POST["editarguardarimg_editar"])? limpiarCadena($_POST["editarguardarimg_editar"]):"";
$imagen_aliados_editar=isset($_POST["imagen_aliados_editar"])? limpiarCadena($_POST["imagen_aliados_editar"]):"";
$agregar_imagen_editar=isset($_POST["agregar_imagen_editar"])? limpiarCadena($_POST["agregar_imagen_editar"]):"";


switch ($_GET["op"]){

	case 'listaraliados':
		$rspta	= $web_aliados->mostraraliados();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i ++){
			$titulo = $reg[$i]["nombre_aliado"];
			$imagen_aliado = $reg[$i]["imagen_aliado"];
			$contenido = $reg[$i]["url_aliado"];
			$id_web_aliados  = $reg[$i]["id_web_aliados"];
			$estado  = $reg[$i]["estado"];
			$estado = ($estado == 1) ?'<span class="badge badge-success p-1">Activado</span>' :'<span class="badge badge-danger p-1">Desactivado</span>';
			$ruta_img = '../public/web_aliados/';
			$imagen_aliado = ($estado == 1)?"":$imagen_aliado;				
			$url_imagen = ($estado == 1)?$imagen_aliado:'<img width="100%" src="'.$ruta_img.$imagen_aliado.' ">';
			
			$data[]=array(	

				"0"=>($reg[$i]["estado"])?'<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_imagen_editar('.$id_web_aliados.')"  title="Editar Aliado" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>'.'
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_aliados('.$id_web_aliados.',`'.$imagen_aliado.'`)" title="Eliminar Aliado" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
					
					'.
					' <button class="btn btn-success btn-xs" onclick="desactivar_aliados('.$id_web_aliados.')" title="Desactivar"><i class="fas fa-lock-open"></i></button>':
					
					' <button class="btn btn-secondary btn-xs" onclick="activar_aliados('.$id_web_aliados.')" title="Activar"><i class="fas fa-lock"></i></button>',
					
					"1"=>'
					<div style="width:100px !important; ">
						'.$url_imagen.'
					</div>
					',
					"2"=>$titulo,
					"3"=>$contenido,
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
		$rspta = $web_aliados->mostrar_aliados($id_web_aliados);
		echo json_encode($rspta);
	break;

	case 'agregarimagen':

		$ext = explode(".", $_FILES["agregar_imagen"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_aliados/';
		if (!file_exists($_FILES['agregar_imagen']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen']['tmp_name']))
		{
			$imagen_aliados=$editarguardarimg;
		}else{
			
			if ($_FILES['agregar_imagen']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_imagen"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_imagen']['tmp_name'], $img1path_movil)) {
					$imagen_aliados = $_FILES['agregar_imagen']['name'];
				} 

				if (empty($id_web_aliados)){				
					$estado=1;
					$rspta = $web_aliados->insertaraliados($id_web_aliados, $nombre_aliado, $imagen_aliados, $url_aliado, $ip, $hora, $fecha,$id_usuario);
					echo $rspta ? "Imagen registrada" : "<br>"."Error Extensión No Valida false";	
				}
			}
			else{
				echo "Error Extensión No Valida";
				$imagen_aliados=$editarguardarimg;
				
			}
		
		}

	break;

	case 'guardaryeditaraliados':

		$ext = explode(".", $_FILES["agregar_imagen_editar"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_aliados/';
		if (!file_exists($_FILES['agregar_imagen_editar']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name']))
		{
			$imagen_aliados_editar=$editarguardarimg_editar;
		}else{
			
			if ($_FILES['agregar_imagen_editar']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_imagen_editar"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name'], $img1path_movil)) {
					$imagen_aliados_editar = $_FILES['agregar_imagen_editar']['name'];
					// echo "Imagen Editada";
				} 
			}
			else{
				echo "Error Extensión No Valida";
				$imagen_aliados_editar=$editarguardarimg_editar;
			}
		
		}

		$rspta = $web_aliados->editaraliados($nombre_aliado_editar, $imagen_aliados_editar, $url_aliado_editar, $id_web_aliados_editar);
		echo $rspta ? "<br>"."Aliado actualizado" : "Aliado no se pudo actualizar";	
	
	break;

	case 'eliminar_aliados':
		$imagen_aliado = $_POST["imagen_aliado"];
		$eliminar_aliados = $web_aliados->eliminarAliado($id_web_aliados);
		unlink("../public/web_aliados/".$imagen_aliado);  
		echo json_encode($eliminar_aliados);
	break;


	case 'desactivar_aliados':
		$rspta=$web_aliados->desactivar_aliados($id_web_aliados);
		echo json_encode($rspta);
	break;

	case 'activar_aliados':
		$rspta=$web_aliados->activar_aliados($id_web_aliados);
		echo json_encode($rspta);
	break;





	

}
