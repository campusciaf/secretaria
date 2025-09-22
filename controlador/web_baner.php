<?php 
require_once "../modelos/Web_Baner.php";


$fecha=date('Y-m-d');
$hora=date('H:i:s');
$ip = $_SERVER['REMOTE_ADDR']; 
$web = new Web_Baner();

$id_banner=isset($_POST["id_banner"])? limpiarCadena($_POST["id_banner"]):"";

$titulo=isset($_POST["titulo"])? limpiarCadena($_POST["titulo"]):"";
$subtitulo=isset($_POST["subtitulo"])? limpiarCadena($_POST["subtitulo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$ruta_url=isset($_POST["ruta_url"])? limpiarCadena($_POST["ruta_url"]):"";

$imagen_escritorio_2=isset($_POST["img_pc"])? limpiarCadena($_POST["img_pc"]):"";
$imagen_celuar=isset($_POST["imagen_celuar"])? limpiarCadena($_POST["imagen_celuar"]):"";
$imagenmuestra_escritorio_2=isset($_POST["imagenmuestra_escritorio_2"])? limpiarCadena($_POST["imagenmuestra_escritorio_2"]):"";
$imagenmuestra_celular=isset($_POST["imagenmuestra_celular"])? limpiarCadena($_POST["imagenmuestra_celular"]):"";

 $id_usuario = $_SESSION['id_usuario'];

switch ($_GET["op"]){

	case 'listarbanner':
		$rspta	= $web->mostrarbanner();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		
		for ($i = 0; $i < count($reg); $i ++){
			$titulo = $reg[$i]["titulo"];
			$subtitulo = $reg[$i]["subtitulo"];
			$descripcion = $reg[$i]["descripcion"];
			$id_banner = $reg[$i]["id_banner"];

			$imagen_escritorio_2 = $reg[$i]["img_pc"];

			$data[]=array(

				"0"=>'
				<div class="btn-group">
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_banner('.$id_banner. ')" title="Editar Banner" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
			
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_banner('.$id_banner. ')" title="Eliminar Banner" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
				</div>',
				"1"=>$titulo,
				"2"=>$subtitulo,
				"3"=>$descripcion,
			);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);

	break;

	case 'mostrar_banner':
		$rspta = $web->mostrar_banner($id_banner);
		echo json_encode($rspta);
	break;

	case 'guardaryeditarbanner':

		//subir imagen de escritorio
		$ext = explode(".", $_FILES["imagen_escritorio_2"]["name"]);
		$imagen_pc = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_baner/';
		if (!file_exists($_FILES['imagen_escritorio_2']['tmp_name']) || !is_uploaded_file($_FILES['imagen_escritorio_2']['tmp_name']))
		{
			$imagen_escritorio_2=$imagenmuestra_escritorio_2;
		}else{

			if ($_FILES['imagen_escritorio_2']['type'] == "image/webp")
			{
				
				
				$img1path_escritorio = $target_path . "" . "pc_". $_FILES["imagen_escritorio_2"]["name"]; 
				if (move_uploaded_file($_FILES['imagen_escritorio_2']['tmp_name'], $img1path_escritorio)) {
					$imagen_escritorio_2 = "pc_".$_FILES['imagen_escritorio_2']['name'];
				}
				echo "Imagen Escritorio agregada";
			}else{
				echo "<br>"."Error Imagen Escritorio No Valida";
			}

		}

		$ext = explode(".", $_FILES["imagen_celuar"]["name"]);
		$imagen_movil = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_baner/';
		if (!file_exists($_FILES['imagen_celuar']['tmp_name']) || !is_uploaded_file($_FILES['imagen_celuar']['tmp_name']))
		{
			$imagen_celuar=$imagenmuestra_celular;
		}else{
			
			if ($_FILES['imagen_celuar']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "" . "movil_".$_FILES["imagen_celuar"]["name"]; 
		
				if (move_uploaded_file($_FILES['imagen_celuar']['tmp_name'], $img1path_movil)) {
					$imagen_celuar = "movil_".$_FILES['imagen_celuar']['name'];
				} 
				echo "<br>"."Imagen celuar agregada";
			}else{
				echo "<br>"."Error Imagen Celular No Valida";
			}
		
		}

		if (empty($id_banner)){
			
			
			$rspta = $web->insertarbanner($imagen_escritorio_2,$imagen_celuar,$titulo,$subtitulo,$descripcion,$ruta_url,$fecha,$hora,$ip,$id_usuario);
			echo $rspta ? "<br>"."Banner registrado " : "<br>"."Banner no insertado";	
		}
		else{
			
			$rspta = $web->editarbanner($imagen_escritorio_2,$imagen_celuar,$titulo,$subtitulo,$descripcion,$ruta_url,$id_banner);
			echo $rspta ? "<br>"."Banner actualizado" : "<br>"."Banner no se pudo actualizar";	
		}
		
	break;

	case 'eliminar_banner':
		$eliminar_banner = $web->eliminarBaner($id_banner);
		echo json_encode($eliminar_banner);
		break;

}
