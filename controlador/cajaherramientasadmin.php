<?php
session_start();
require_once "../modelos/CajaHerramientaAdmin.php";

$software_libre_admin = new SoftwareLibreAdmin();

$op = (isset($_GET['op'])) ? $_GET['op'] : 'mostrar';

$id_software  = isset($_POST["id_software"]) ? limpiarCadena($_POST["id_software"]) : "";

$nombre  = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "efwewfwe";
$sitio  = isset($_POST["sitio"]) ? limpiarCadena($_POST["sitio"]) : "ewfewfew";
$url  = isset($_POST["url"]) ? limpiarCadena($_POST["url"]) : "fwefefwe";
$nombre_imagen  = isset($_POST["nombre_imagen"]) ? limpiarCadena($_POST["nombre_imagen"]) : "efwefewweff";
$descripcion  = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "ewfwefwe";
$valor  = isset($_POST["valor"]) ? limpiarCadena($_POST["valor"]) : "efwweffwe";
$ruta_img  = isset($_POST["ruta_img"]) ? limpiarCadena($_POST["ruta_img"]) : "ewfwe";

$categoria_software = isset($_POST["categoria_software"])? limpiarCadena($_POST["categoria_software"]):"";
$permiso_software  = isset($_POST["permiso_software"])? limpiarCadena($_POST["permiso_software"]):"";
$opcion = isset($_POST["opcion"])? limpiarCadena($_POST["opcion"]):"";


// $file_edit  = isset($_FILES['file_url']['name'])? limpiarCadena($_FILES['file_url']['name']):"";
// $file_url  = isset($_POST["file_url"])? limpiarCadena($_POST["file_url"]):"";

switch ($_GET["op"]) {


	case 'mostrar_elementos_software':
		
		$data[0] = "";
		$respuesta = $software_libre_admin->mostrarElementos();
		for ($i = 0; $i < count($respuesta); $i++) {

			


			$data[0] .= '
			<div class="col-6 col-md-3 col-lg-3 col-xl-2 ">

				<div class="card card-primary card-outline direct-chat direct-chat-primary p-2"> 
				
				<div class="float-right">
					<a> <button class="btn btn-danger btn-sm float-right" onclick="eliminar_software(' . ($respuesta[$i]["id_software"]) . ')" title="Eliminar"><i class="far fa-trash-alt"></i></button> </a>
					<a>
					<button class="btn btn-warning btn-sm float-right" onclick="mostrar_software(' . ($respuesta[$i]["id_software"]) . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
					</a>

				</div>
				
				
					<div class="contenedor-img ejemplo-1">
						<center>
							<img src="../public/img/software_libre/' . $respuesta[$i]["ruta_img"] . '" width="70%">
						</center>
						<span class="titulo-4"><b>' . $respuesta[$i]["nombre"] . '</b></span>  
						<hr width="90%" size="1px" style="border: dashed 1px gray">
						<span class="titulo8">' . $respuesta[$i]["sitio"] . '</span><br>
						<br><span class="titulo1">' . $respuesta[$i]["valor"] . '</span><br><br>
						<div class="mascara">
						<h2>' . $respuesta[$i]["nombre"] . '</h2><p>
							' . $respuesta[$i]["descripcion"] . '</p>
							<a href="' . $respuesta[$i]["url"] . '" class="link" target="_blank">Leer más</a>
						</div>
					</div>
				</div>
			</div>

			
			
	
	
			';
		}
		echo json_encode($data);
		break;

	case 'mostrar_software_admin':
		$rspta = $software_libre_admin->mostrarSoftware($id_software);
		// print_r($rspta);
		echo json_encode($rspta);
		break;
		//guardo el nombre del proyecto
	case 'guardaryeditarsoftware':
		

		if ($id_software == "") {
			$target_path = '../public/img/software_libre/';
			$img1path = $target_path . $_FILES['file_url']['name'];

			// print_r($_FILES['file_url']['name']);
			if (move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path)) {
				// $ruta_img = $_FILES['file_url']['name'];
				$ruta_img = $_FILES['file_url']['name'];
				// print_r($ruta_img);
				// unlink('../public/img/software_libre/'.$ruta_img);

				$agregar_sw = $software_libre_admin->agregarSoftwareLibre($nombre, $sitio, $url, $ruta_img, $descripcion, $valor, $categoria_software);
				// echo $agregar_sw;
			}
		
			// echo $agregar_sw ? "Software registrado" : "Software no se pudo registrar";
		} else {




			$target_path = '../public/img/software_libre/';
			$img1path = $target_path . $_FILES['file_url']['name'];

			// print_r($_FILES['file_url']['name']);
			if (move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path)) {
				// $ruta_img = $_FILES['file_url']['name'];
				$ruta_img = $_FILES['file_url']['name'];
				// print_r($ruta_img);
				// unlink('../public/img/software_libre/'.$ruta_img);


				$modificar_sw = $software_libre_admin->modificarSoftwareLibre($id_software, $nombre, $sitio, $url, $ruta_img, $descripcion, $valor, $categoria_software);

			}
		}

		// echo json_encode($modificar_sw);

		break;

		case 'mostrarcategorias':
			$data[0] = "";
			
			$data[0] .=" 
			<div class='btn-group btn-group-toggle p-0 border-left border-white' data-toggle='buttons role='group' aria-label='Basic example''>
				<label class='btn bg-olive' onclick= 'mostrarElementosSoftware()'>
					<input type='radio' name='options' autocomplete='off'>Todos</span>
				</label>
			</div>
		
		";
		
			
	
			$respuesta = $software_libre_admin->SoftwareLibrecategorias();
			for($i = 0;$i < count($respuesta);$i++ ) {
					
					$data[0] .='
	
					<div class="btn-group btn-group-toggle p-0 border-left border-white" data-toggle="buttons role="group" aria-label="Basic example"">
					
						<label class="btn bg-olive" onclick="filtrarSoftware('.($i+1).')">
							<input type="radio" name="options" autocomplete="off">  <span id="'.($i+1).'">'.$respuesta[$i]["nombre_categoria"].'</span>
						</label>
					</div>
					
					';
				}
			echo json_encode($data);
			break;	


		case 'eliminar_software':
		$eliminar_sw = $software_libre_admin->eliminarSoftwareLibre($id_software);
		echo json_encode($eliminar_sw);
		break;



		// listamos el cargo 
		case "softwareCategoria":	

			
			$rspta = $software_libre_admin->software_categoria();
			
			echo "<option selected>Nothing selected</option>";
			for ($i=0;$i<count($rspta);$i++){
				$nombre_categoria = $rspta[$i]["nombre_categoria"];
				$id_software_categoria  = $rspta[$i]["id_software_categoria"];
				echo "<option value='".$id_software_categoria."'>" .$nombre_categoria. "</option>" ;
			
			}
			
	
		break;


		case 'filtrar':
			// $opcion = $_POST['opcion'];
			$data[0] = "";
		
			// $permiso_software = 1;
				
				// if ($permiso_software == 0) {
				// 	$data[0] .=
					
				// 	'<div class="card col-xl-12 m-2 p-2">
				// 	<button class="btn btn-primary btn-sm float-right" onclick="mostrar_software()" title="Agregar"><i class="fa fa-plus"></i></button>
				// 	</div>';
					
					
				// }
			$respuesta = $software_libre_admin->filtrarSoftwareLibre($opcion);
			for($i = 0;$i < count($respuesta);$i++ ) {
		
					$data[0] .='
					<div class="col-6 col-md-3 col-lg-3 col-xl-2 ">
						<div class="card card-primary card-outline direct-chat direct-chat-primary p-2">
						<div class="float-right">
					<a> <button class="btn btn-danger btn-sm float-right" onclick="eliminar_software(' . ($respuesta[$i]["id_software"]) . ')" title="Eliminar"><i class="far fa-trash-alt"></i></button> </a>
					<a>
					<button class="btn btn-warning btn-sm float-right" onclick="mostrar_software(' . ($respuesta[$i]["id_software"]) . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
					</a>

				</div>
							<div class="contenedor-img ejemplo-1">
								<center>
									<img src="../public/img/software_libre/'.$respuesta[$i]["ruta_img"].'">
								</center>
								<span class="titulo-4"><b>'.$respuesta[$i]["nombre"].'</b></span>  
								<hr width="90%" size="1px" style="border: dashed 1px gray">
								<span class="titulo8">'.$respuesta[$i]["sitio"].'</span><br>
								<br><span class="titulo1">'.$respuesta[$i]["valor"].'</span><br><br>
								<div class="mascara">
									<h2>'.$respuesta[$i]["nombre"].'</h2><p>
									'.$respuesta[$i]["descripcion"].'</p>
									<a href="'.$respuesta[$i]["url"].'" class="link" target="_blank">Leer mas</a>
									<button class="btn btn-info infoLibro" onclick="abrirModalSW('.($respuesta[$i]["id_software"]).')">Editar</button>
								</div>
							</div>
						</div>
					</div>';
				}
			echo json_encode($data);
			break;


			case 'mostrar':
				$data[0] = "";
				$respuesta = $software_libre_admin->mostrarElementos();
				for($i = 0;$i < count($respuesta);$i++ ) {
					$data[0] .='
					<div class="col-6 col-md-3 col-lg-3 col-xl-2 ">
						<div class="card card-primary card-outline direct-chat direct-chat-primary p-2">
							<div class="contenedor-img ejemplo-1">
								<center>
									<img src="../public/img/software_libre/'.$respuesta[$i]["ruta_img"].'">
								</center>
								<span class="titulo-4"><b>'.$respuesta[$i]["nombre"].'</b></span>  
								<hr width="90%" size="1px" style="border: dashed 1px gray">
								<span class="titulo8">'.$respuesta[$i]["sitio"].'</span><br>
								<br><span class="titulo1">'.$respuesta[$i]["valor"].'</span><br><br>
								<div class="mascara">
								<h2>'.$respuesta[$i]["nombre"].'</h2><p>
									'.$respuesta[$i]["descripcion"].'</p>
									<a href="'.$respuesta[$i]["url"].'" class="link" target="_blank">Leer más</a>
								</div>
							</div>
						</div>
					</div>';
				}
				echo json_encode($data);
			break;



}
