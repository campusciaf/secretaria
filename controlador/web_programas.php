<?php 
require_once "../modelos/Web_Programas.php";
// variables para datos de registro
$fecha=date('Y-m-d');
$hora=date('H:i');
$ip = $_SERVER['REMOTE_ADDR']; 
//variable para saber que usuario hizo el registro
$id_usuario = $_SESSION['id_usuario'];
// error_reporting(1); 

$web_programas = new Web_Programas();


// variables globales para agregar programa
$titulo_programa=isset($_POST["titulo_programa"])? limpiarCadena($_POST["titulo_programa"]):"";
$subtitulo_programa=isset($_POST["subtitulo_programa"])? limpiarCadena($_POST["subtitulo_programa"]):"";
$nombre_programa=isset($_POST["nombre_programa"])? limpiarCadena($_POST["nombre_programa"]):"";
$snies=isset($_POST["snies"])? limpiarCadena($_POST["snies"]):"";
$frase_programa=isset($_POST["frase_programa"])? limpiarCadena($_POST["frase_programa"]):"";
$id_programas=isset($_POST["id_programas"])? limpiarCadena($_POST["id_programas"]):"";
$agregar_imagen_programa=isset($_POST["agregar_imagen_programa"])? limpiarCadena($_POST["agregar_imagen_programa"]):"";
$imagen_celuar_programa=isset($_POST["imagen_celuar_programa"])? limpiarCadena($_POST["imagen_celuar_programa"]):"";
$guardar_img_programas=isset($_POST["guardar_img_programas"])? limpiarCadena($_POST["guardar_img_programas"]):"";
$guardar_img_programas_celular=isset($_POST["guardar_img_programas_celular"])? limpiarCadena($_POST["guardar_img_programas_celular"]):"";

// variables globales para editar 

$titulo_programa_editar=isset($_POST["titulo_programa_editar"])? limpiarCadena($_POST["titulo_programa_editar"]):"";
$subtitulo_programa_editar=isset($_POST["subtitulo_programa_editar"])? limpiarCadena($_POST["subtitulo_programa_editar"]):"";
$nombre_programa_editar=isset($_POST["nombre_programa_editar"])? limpiarCadena($_POST["nombre_programa_editar"]):"";
$snies_editar=isset($_POST["snies_editar"])? limpiarCadena($_POST["snies_editar"]):"";
$frase_programa_editar=isset($_POST["frase_programa_editar"])? limpiarCadena($_POST["frase_programa_editar"]):"";
$id_programas=isset($_POST["id_programas"])? limpiarCadena($_POST["id_programas"]):"";
$agregar_imagen_programa_editar=isset($_POST["agregar_imagen_programa_editar"])? limpiarCadena($_POST["agregar_imagen_programa_editar"]):"";
$guardar_img_programas_editar=isset($_POST["guardar_img_programas_editar"])? limpiarCadena($_POST["guardar_img_programas_editar"]):"";

$imagen_celuar_programa_editar=isset($_POST["imagen_celuar_programa_editar"])? limpiarCadena($_POST["imagen_celuar_programa_editar"]):"";
$guardar_imagen_celuar_programa_editar=isset($_POST["guardar_imagen_celuar_programa_editar"])? limpiarCadena($_POST["guardar_imagen_celuar_programa_editar"]):"";



switch ($_GET["op"]){

	case 'listarprogramas':
		$rspta	= $web_programas->mostrarprogramas();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i ++){
			// $titulo = $reg[$i]["titulo"];
			// $subtitulo = $reg[$i]["subtitulo"];
			$nombre_programa = $reg[$i]["nombre_programa"];
			$snies = $reg[$i]["snies"];
			$frase_programa = $reg[$i]["frase_programa"];

			$id_programas  = $reg[$i]["id_programas"];
			$img_programas  = $reg[$i]["img_programas"];
			$img_programas_movil  = $reg[$i]["img_programas_movil"];
			
			$estado  = $reg[$i]["estado"];

			$ruta_img = '../public/web_programas/';

			$estado = ($estado == 1) ?'<span class="badge badge-success p-1">Activado</span>' :'<span class="badge badge-danger p-1">Desactivado</span>';

			$imagen_eliminar = ($estado == 1) ? "" :$img_programas;
			
			$url_imagen = ($estado == 1)?'':'<img width="100%" src="'.$ruta_img.$img_programas.'">';
			$url_imagen_celular = ($estado == 1)?'':'<img width="80%" src="'.$ruta_img.$img_programas_movil.'">';

			$data[]=array(	
			"0"=>($reg[$i]["estado"])?'
					<div class="btn-group">
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_programas('.$id_programas.')"  title="Editar Programa" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>'.'
					<button class="tooltip-agregar btn btn-danger btn-xs d-none" onclick=eliminar_programas('.$id_programas.',`'.$imagen_eliminar.'`,`'.$img_programas_movil.'`) title="Eliminar Programa" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>'.
					' <button class="btn btn-success btn-xs" onclick="desactivar_programas('.$id_programas.')" title="Desactivar"><i class="fas fa-lock-open"></i></button>':
					
					' <button class="btn btn-secondary btn-xs" onclick="activar_programas('.$id_programas.')" title="Activar"><i class="fas fa-lock"></i></button></div>',
					
					"1"=>'
					<div style="width:150px !important;">
						'.$url_imagen.'
						</style>
					</div>
					'
					,
				
					"2"=>'
					<div style="width:150px !important;">
						'.$url_imagen_celular.'
						</style>
					</div>
					',

					"3"=>$nombre_programa,
					"4"=>$snies,
					"5"=>$frase_programa,
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

		$ext = explode(".", $_FILES["agregar_imagen_programa"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_programas/';
		if (!file_exists($_FILES['agregar_imagen_programa']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_programa']['tmp_name']))
		{
			$agregar_imagen_programa=$guardar_img_programas;
		}else{
			
			if ($_FILES['agregar_imagen_programa']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_imagen_programa"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_imagen_programa']['tmp_name'], $img1path_movil)) {
					$agregar_imagen_programa = $_FILES['agregar_imagen_programa']['name'];
					$imagen = getimagesize($img1path_movil);//Sacamos la información
					$ancho = $imagen[0];
					$alto = $imagen[1]; 
				} 
			}
			else{
				echo "<br>"."Error Extensión No Valida";
				
			}
		}

		$ext = explode(".", $_FILES["imagen_celuar_programa"]["name"]);
		$imagen_movil = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_programas/';
		if (!file_exists($_FILES['imagen_celuar_programa']['tmp_name']) || !is_uploaded_file($_FILES['imagen_celuar_programa']['tmp_name']))
		{
			$imagen_celuar_programa=$guardar_img_programas_celular;
		}else{
			
			if ($_FILES['imagen_celuar_programa']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "" .$_FILES["imagen_celuar_programa"]["name"]; 
		
				if (move_uploaded_file($_FILES['imagen_celuar_programa']['tmp_name'], $img1path_movil)) {
					$imagen_celuar_programa = $_FILES['imagen_celuar_programa']['name'];
					
				} 
				// echo "Imagen celuar agregada"."<br>";
			}else{
				echo "<br>"."Error Imagen Celular No Valida";
			}

			$imagen_celular_tamaño = getimagesize($img1path_movil); //Sacamos la información
			$ancho_celular = $imagen_celular_tamaño[0]; 
			$alto_celular = $imagen_celular_tamaño[1]; 
		
		}

		if (empty($id_programas) || $ancho == 1728 || $alto == 1024 || $ancho_celular == 428 || $alto_celular == 400){				
			$estado=1;

			$rspta = $web_programas->insertarprogramas($id_programas, $agregar_imagen_programa, $imagen_celuar_programa, $nombre_programa, $snies, $frase_programa, $estado, $ip, $hora, $fecha, $id_usuario);
			echo $rspta ? "Programa registrado " : "<br>"."Programa no insertado";	
		}
		elseif($ancho < 1728){
			echo "Error verificar tamaño de la imagen Escritorio";
		}else{
			echo "Error verificar tamaño de la imagen Móvil";
		}
		
	break;

	case 'mostrar_programas':
		$rspta = $web_programas->mostrar_programas($id_programas);
		echo json_encode($rspta);
	break;

	case 'guardaryeditarprogramas':
		// $ancho_escritorio_editar = 0; 
		// $alto_escritorio_editar = 0; 

		// $ancho_editar_celular =0;
		// $alto_editar_celular = 0; 

		$ancho_escritorio_editar = ""; 
		$ancho_editar_celular = "";

		$ext = explode(".", $_FILES["agregar_imagen_programa_editar"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_programas/';

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
					
					if ($agregar_imagen_programa_editar !== $guardar_img_programas_editar && file_exists("../public/web_programas/".$guardar_img_programas_editar)) {
						unlink("../public/web_programas/".$guardar_img_programas_editar);
					}
				} 
			}
			else {
				echo "<br>"."Error Extensión No Valida";
			}

			$imagen_escritorio_tamaño = getimagesize($img1path_escritorio); //Sacamos la información
			$ancho_escritorio_editar = $imagen_escritorio_tamaño[0]; 
			$alto_escritorio_editar = $imagen_escritorio_tamaño[1]; 
		}


		// codigo para editar la imagen del celular 

		$ext = explode(".", $_FILES["imagen_celuar_programa_editar"]["name"]);
		$imagen_movil = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_programas/';

		if (!file_exists($_FILES['imagen_celuar_programa_editar']['tmp_name']) || !is_uploaded_file($_FILES['imagen_celuar_programa_editar']['tmp_name']))
		{
			$imagen_celuar_programa_edito = $guardar_imagen_celuar_programa_editar;
		}
		else
		{
			if ($_FILES['imagen_celuar_programa_editar']['type'] == "image/webp")
			{
				$img1path_movil_celular = $target_path . "" .$_FILES["imagen_celuar_programa_editar"]["name"]; 
				
				if (move_uploaded_file($_FILES['imagen_celuar_programa_editar']['tmp_name'], $img1path_movil_celular)) {
					$imagen_celuar_programa_edito = $_FILES['imagen_celuar_programa_editar']['name'];
					
					if($imagen_celuar_programa_edito !== $guardar_imagen_celuar_programa_editar && file_exists($guardar_imagen_celuar_programa_editar)) {
						unlink("../public/web_programas/".$guardar_imagen_celuar_programa_editar);
					}
				} 
			}
			else {
				echo "<br>"."Error Imagen Celular No Valida";
			}
			
			$imagen = getimagesize($img1path_movil_celular);//Sacamos la información
			$ancho_editar_celular = $imagen[0];
			$alto_editar_celular = $imagen[1]; 
		}
		


		if($ancho_escritorio_editar == 1728 || $ancho_editar_celular <= 428){

		$estado=1;
		$rspta = $web_programas->editarprogramas($agregar_imagen_programa_editar,$imagen_celuar_programa_edito,$nombre_programa_editar,$snies_editar,$frase_programa_editar, $id_programas);
		echo $rspta ? "Programa actualizado" : "<br>"."Programa no se pudo actualizar";	
		}
		

	break;

	case 'eliminar_programas':
		// $img_programas 
		$img_programas = $_POST["imagen_eliminar"];
		$img_programas_movil = $_POST["img_programas_movil"];
		$eliminar_programas = $web_programas->eliminarPrograma($id_programas);
		
		unlink("../public/web_programas/".$img_programas);  
		unlink("../public/web_programas/".$img_programas_movil);  
		echo json_encode($eliminar_programas);
		
	break;


	case 'desactivar_programas':
		$rspta=$web_programas->desactivar_programa($id_programas);
		echo json_encode($rspta);
	break;

	case 'activar_programas':
		$rspta=$web_programas->activar_programa($id_programas);
		echo json_encode($rspta);
	break;

}
