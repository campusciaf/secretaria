<?php 
require_once "../modelos/Web_Convenios.php";
$fecha=date('Y-m-d');
$hora=date('H:i');

$ip = $_SERVER['REMOTE_ADDR']; 
// error_reporting(1); 
$web_convenios = new Web_Convenios();

// variables globales para agregar el convenio
$id_web_convenio=isset($_POST["id_web_convenio"])? limpiarCadena($_POST["id_web_convenio"]):"";
$nombre_convenio=isset($_POST["nombre_convenio"])? limpiarCadena($_POST["nombre_convenio"]):"";
$url_convenio=isset($_POST["url_convenio"])? limpiarCadena($_POST["url_convenio"]):"";
$descripcion_convenio=isset($_POST["descripcion_convenio"])? limpiarCadena($_POST["descripcion_convenio"]):"";
$categoria_convenios_imagen=isset($_POST["categoria_convenios_imagen"])? limpiarCadena($_POST["categoria_convenios_imagen"]):"";
// variables globales para imagen
$agregar_imagen=isset($_POST["agregar_imagen"])? limpiarCadena($_POST["agregar_imagen"]):"";
$editarguardarimg=isset($_POST["editarguardarimg"])? limpiarCadena($_POST["editarguardarimg"]):"";

// variables globales para editar el convenio
$id_web_convenio_editar=isset($_POST["id_web_convenio_editar"])? limpiarCadena($_POST["id_web_convenio_editar"]):"";
$nombre_convenio_editar=isset($_POST["nombre_convenio_editar"])? limpiarCadena($_POST["nombre_convenio_editar"]):"";
$url_convenio_editar=isset($_POST["url_convenio_editar"])? limpiarCadena($_POST["url_convenio_editar"]):"";
$descripcion_convenio_editar=isset($_POST["descripcion_convenio_editar"])? limpiarCadena($_POST["descripcion_convenio_editar"]):"";
$categoria_convenios_imagen_editar=isset($_POST["categoria_convenios_imagen_editar"])? limpiarCadena($_POST["categoria_convenios_imagen_editar"]):"";
// variables globales para imagen
$agregar_imagen_editar=isset($_POST["agregar_imagen_editar"])? limpiarCadena($_POST["agregar_imagen_editar"]):"";
$agregar_editar_imagen_editar=isset($_POST["agregar_editar_imagen_editar"])? limpiarCadena($_POST["agregar_editar_imagen_editar"]):"";

$imagen_convenio=isset($_POST["imagen_convenio"])? limpiarCadena($_POST["imagen_convenio"]):"";

$id_usuario = $_SESSION['id_usuario'];

switch ($_GET["op"]){

	case 'listarconvenios':
		$rspta	= $web_convenios->mostrarconvenios();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i ++){
			$nombre_convenio = $reg[$i]["nombre_convenio"];
			$descripcion_convenio = $reg[$i]["descripcion_convenio"];
			$id_web_convenio = $reg[$i]["id_web_convenio"];
			$url_convenio  = $reg[$i]["url_convenio"];
			$imagen_convenio  = $reg[$i]["imagen_convenio"];
			$imagen_convenio_2  = $reg[$i]["imagen_convenio"];

			$estado  = $reg[$i]["estado"];

			$estado = ($estado == 1) ?'<span class="badge badge-success p-1">Activado</span>' :'<span class="badge badge-danger p-1">Desactivado</span>';

			$ruta_img = '../public/web_convenios/';
			$imagen_convenio = ($estado == 1)?"":$imagen_convenio;				
			$url_imagen = ($estado == 1)?$imagen_convenio:'<img width="100%" src="'.$ruta_img.$imagen_convenio.' ">';


			$data[]=array(	

				"0"=>($reg[$i]["estado"])?'
				<div class="btn-group">
				
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_convenios('.$id_web_convenio.')"  title="Editar Convenio" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>'.'
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_convenios('.$id_web_convenio.',`'.$imagen_convenio.'`)" title="Eliminar Convenio" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
					
					'.
					' <button class="btn btn btn-success btn-xs" onclick="desactivar_convenio('.$id_web_convenio.')" title="Desactivar"><i class="fas fa-lock-open"></i></button>':
					
					' <button class="btn btn-secondary btn-xs" onclick="activar_convenio('.$id_web_convenio.')" title="Activar"><i class="fas fa-lock"></i></button>',
					
					"1"=>'
					<div style="width:100px !important; ">
						'.$url_imagen.'
					</div>
					</div>
					',
					"2"=>$nombre_convenio,
					"3"=>$descripcion_convenio,
					"4"=>$url_convenio,
					"5"=>$estado

				
			);

				
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
	break;

	case 'mostrar_convenios':
		$rspta = $web_convenios->mostrar_convenio($id_web_convenio);
		echo json_encode($rspta);
	break;

	case 'guardaryeditarconvenios':

		$ext = explode(".", $_FILES["agregar_imagen_editar"]["name"]);
				$imagen = round(microtime(true)) . '.' . end($ext);
				$target_path = '../public/web_convenios/';
				if (!file_exists($_FILES['agregar_imagen_editar']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name']))
				{
					$imagen_convenio=$agregar_editar_imagen_editar;
				}else{
					
					if ($_FILES['agregar_imagen_editar']['type'] == "image/webp")
					{
						
						$img1path_movil = $target_path . "".$_FILES["agregar_imagen_editar"]["name"]; 
				
						if (move_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name'], $img1path_movil)) {
							$imagen_convenio = $_FILES['agregar_imagen_editar']['name'];
						} 
						echo "Imagen Editada";
					}else{
						echo "Error Extensión No Valida"."<br>";
						$imagen_convenio=$agregar_editar_imagen_editar;
					}
				
				}


				$rspta = $web_convenios->editarconvenio($imagen_convenio,$nombre_convenio_editar,$descripcion_convenio_editar,$url_convenio_editar,$categoria_convenios_imagen_editar, $id_web_convenio_editar);
				echo $rspta ? "Convenio actualizado" : "Convenio no se pudo actualizar";	

	break;

	case 'eliminar_convenios':
		$imagen_convenio = $_POST["imagen_convenio"];
		$eliminar_convenios = $web_convenios->eliminarConvenio($id_web_convenio);
		
		unlink("../public/web_convenios/".$imagen_convenio);  
		echo json_encode($eliminar_convenios);
		
	break;

	case "Categoria_Programas":	
		$rspta = $web_convenios->bienestar_programas();
		echo "<option selected>Nothing selected</option>";
		for ($i=0;$i<count($rspta);$i++){
			$nombre_categoria = $rspta[$i]["programa"];
			$id_bienestar_programas  = $rspta[$i]["id_bienestar_programas"];
			echo "<option value='".$id_bienestar_programas."'>" .$nombre_categoria. "</option>" ;
		}
		

	break;
	
	case 'agregarconvenio':

			$ext = explode(".", $_FILES["agregar_imagen"]["name"]);
			$imagen = round(microtime(true)) . '.' . end($ext);
			$target_path = '../public/web_convenios/';
			if (!file_exists($_FILES['agregar_imagen']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen']['tmp_name']))
			{
				$imagen_convenio=$editarguardarimg;
			}else{
				
				if ($_FILES['agregar_imagen']['type'] == "image/webp")
				{
					
					$img1path_movil = $target_path . "".$_FILES["agregar_imagen"]["name"]; 
			
					if (move_uploaded_file($_FILES['agregar_imagen']['tmp_name'], $img1path_movil)) {
						$imagen_convenio = $_FILES['agregar_imagen']['name'];
					} 

					if (empty($id_web_convenio)){				
						$estado=1;
						$extension_categoria_imagen=2;

						$rspta = $web_convenios->insertarconvenio($id_web_convenio, $imagen_convenio, $nombre_convenio, $descripcion_convenio, $url_convenio, $categoria_convenios_imagen,$estado, $ip, $hora, $fecha, $id_usuario);
						echo $rspta ? "Convenio registrado " : "Error Extensión No Valida";	
					}
				}
				else{
					echo "Error Extensión No Valida";
					
				}
			
			}
	break;

	case 'desactivar_convenio':
		$rspta=$web_convenios->desactivar_convenio($id_web_convenio);
		echo json_encode($rspta);
	break;

	case 'activar_convenio':
		$rspta=$web_convenios->activar_convenio($id_web_convenio);
		echo json_encode($rspta);
	break;


}
