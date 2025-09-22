<?php 
require_once "../modelos/Banner_Campus.php";
$fecha=date('Y-m-d');
$hora=date('H:i');

$ip = $_SERVER['REMOTE_ADDR']; 
// error_reporting(1); 
$banner_campus = new Banner_Campus();

// variables globales para agregar la imagen
$id_banner=isset($_POST["id_banner"])? limpiarCadena($_POST["id_banner"]):"";
// variables globales para imagen
$agregar_imagen=isset($_POST["agregar_imagen"])? limpiarCadena($_POST["agregar_imagen"]):"";
$editarguardarimg=isset($_POST["editarguardarimg"])? limpiarCadena($_POST["editarguardarimg"]):"";

// variables globales para editar la imagen
$id_banner_editar=isset($_POST["id_banner_editar"])? limpiarCadena($_POST["id_banner_editar"]):"";
$agregar_imagen_editar=isset($_POST["agregar_imagen_editar"])? limpiarCadena($_POST["agregar_imagen_editar"]):"";
$agregar_editar_imagen_editar=isset($_POST["agregar_editar_imagen_editar"])? limpiarCadena($_POST["agregar_editar_imagen_editar"]):"";

$imagen_banner=isset($_POST["imagen_banner"])? limpiarCadena($_POST["imagen_banner"]):"";

$id_usuario = $_SESSION['id_usuario'];

switch ($_GET["op"]){

	case 'listarbanner':
		$rspta	= $banner_campus->mostrarimagen();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i ++){


			$id_banner = $reg[$i]["id_banner"];
			$imagen_banner  = $reg[$i]["imagen_banner"];


			// $imagen_banner_2  = $reg[$i]["imagen_banner"];

			$estado  = $reg[$i]["estado"];

			$estado = ($estado == 1) ?'<span class="badge badge-success p-1">Activado</span>' :'<span class="badge badge-danger p-1">Desactivado</span>';

			$ruta_img = '../public/banner_campus/';
			$imagen_banner = ($estado == 1)?"":$imagen_banner;				
			$url_imagen = ($estado == 1)?$imagen_banner:'<img width="100%" src="'.$ruta_img.$imagen_banner.' ">';


			$data[]=array(	

				"0"=>'<button class="tooltip-agregar btn btn-warning btn-xs" onclick="mostrar_imagen('.$id_banner.')"  title="Editar Banner" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>'.'
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_imagenes('.$id_banner.',`'.$imagen_banner.'`)" title="Eliminar Banner" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>',
					"1"=>'
					<div style="width:100px !important; ">
						'.$url_imagen.'
					</div>
					',
					"2"=>$estado

				
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
		$rspta = $banner_campus->mostrar_imagen($id_banner);
		echo json_encode($rspta);
	break;

	case 'guardaryeditarbannercampus':

		$ext = explode(".", $_FILES["agregar_imagen_editar"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/banner_campus/';
		if (!file_exists($_FILES['agregar_imagen_editar']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name']))
		{
			$imagen_banner=$agregar_editar_imagen_editar;
		}else{
			
			if ($_FILES['agregar_imagen_editar']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . ""."bg-login$fecha.webp"; 
		
				if (move_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name'], $img1path_movil)) {
					$imagen_banner = "bg-login$fecha.webp";
				} 
			}else{
				echo "Error Extensión No Valida"."<br>";
				$imagen_banner=$agregar_editar_imagen_editar;
			}
		
		}


		$rspta = $banner_campus->editarimagen($imagen_banner, $id_banner_editar);
		echo $rspta ? "Actualizado" : "no se pudo actualizar";	

	break;

	case 'eliminar_imagenes':
		$imagen_banner = $_POST["imagen_banner"];
		$eliminar_imagenes = $banner_campus->eliminarImagen($id_banner);
		
		unlink("../public/banner_campus/".$imagen_banner);  
		echo json_encode($eliminar_imagenes);
		
	break;

	
	case 'agregarimagen':

			$ext = explode(".", $_FILES["agregar_imagen"]["name"]);
			$imagen = round(microtime(true)) . '.' . end($ext);
			$target_path = '../public/banner_campus/';
			if (!file_exists($_FILES['agregar_imagen']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen']['tmp_name']))
			{
				$imagen_banner=$editarguardarimg;
			}else{
				
				if ($_FILES['agregar_imagen']['type'] == "image/webp")
				{

					$img1path_movil = $target_path . ""."bg-login$fecha.webp"; 
			
					if (move_uploaded_file($_FILES['agregar_imagen']['tmp_name'], $img1path_movil)) {
						$imagen_banner = "bg-login$fecha.webp";
					} 

					if (empty($id_banner)){				
						$estado=1;
						$extension_categoria_imagen=2;

						$rspta = $banner_campus->insertarimagen($id_banner, $imagen_banner,$estado, $ip, $hora, $fecha, $id_usuario);
						echo $rspta ? "Registrado " : "Error Extensión No Valida";	
					}
				}
				else{
					echo "Error Extensión No Valida";
					
				}
			
			}
	break;




	//listo los ejes 
	case 'boton_agregar':
		$rspta = $banner_campus->mostrarimagen();

		$data[0] = '';

		$data[0] .= '
			<h1 class="m-0">
		<span class="titulo-4">Administrador Banner Campus</span>';

		// Verificar si $rspta está vacío
		if (empty($rspta)) {
			$data[0] .= '
				<button class="btn btn-success pull-right" id="btnagregar" onclick="mostraragregarimagen(true)"><i class="fa fa-plus-circle"></i> Agregar Imagen</button>';
		}

		echo json_encode($data);
		
	break;


}
