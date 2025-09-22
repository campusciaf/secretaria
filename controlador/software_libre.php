<?php
session_start();
require_once "../modelos/SoftwareLibre.php";

$software_libre = new SoftwareLibre();
$id_software  = isset($_POST["id_software"])? limpiarCadena($_POST["id_software"]):"";
$nombre  = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$sitio  = isset($_POST["sitio"])? limpiarCadena($_POST["sitio"]):"";

$url  = isset($_POST["url"])? limpiarCadena($_POST["url"]):"";
$nombre_imagen  = isset($_POST["nombre_imagen"])? limpiarCadena($_POST["nombre_imagen"]):"";
$descripcion  = isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$valor  = isset($_POST["valor"])? limpiarCadena($_POST["valor"]):"";
// $categoria  = isset($_POST["categoria"])? limpiarCadena($_POST["categoria"]):"";
$categoria_software = isset($_POST["categoria_software"])? limpiarCadena($_POST["categoria_software"]):"";

$id_usuario  = isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$permiso_software  = isset($_POST["permiso_software"])? limpiarCadena($_POST["permiso_software"]):"";
$opcion = isset($_POST["opcion"])? limpiarCadena($_POST["opcion"]):"";
// $permiso_software  = isset($_POST["permiso_software"])? limpiarCadena($_POST["permiso_software"]):"";
$op = (isset($_GET['op']))?$_GET['op']:'mostrar';
switch ($op) {
	case 'agregar':
		$target_path = '../public/img/software_libre/';
        $img1path = $target_path . $_FILES['file_url']['name'];
		$nombre = $_POST['txtNombre'];
		$sitio = $_POST['txtSitio'];
		$url = $_POST['txtUrl'];
		$descripcion = $_POST['txtDescripcion'];
		$valor = $_POST['txtValor'];		
		$categoria_software = $_POST['txtCategoria'];
		if(move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path)){
			$ruta_img = $_FILES['file_url']['name'];
			$agregar_sw = $software_libre->agregarSoftwareLibre($nombre,$sitio,$url,$ruta_img,$descripcion,$valor,$categoria_software);
		echo json_encode($agregar_sw);
        $img1path = "";
		$nombre = "";
		$sitio = "";
		$url = "";
		$descripcion = "";
		$valor = "";
		}else{
			echo 1;
		}
		break;
	case 'mostrar_elementos':
		// $permiso_software = $_POST['permiso_software'];
		$data[0] = "";
		$respuesta = $software_libre->mostrarElementos();
		$respuesta_boton = $software_libre->mostrarSoftwareboton($id_usuario);
		
		$permiso_software = $respuesta_boton["permiso_software"];
		
		if ($permiso_software == 0) {
			$data[0] .=
			
			'<div class="card col-xl-12 m-2 p-2">
			<button class="btn btn-primary btn-sm float-right" onclick="mostrar_software()" title="Agregar"><i class="fa fa-plus"></i></button>
			</div>';
			
			
		}
		
		
		for($i = 0;$i < count($respuesta);$i++ ) {
			
			// print_r($permiso_software);
			
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
	case 'mostrar_admin':
		$data[0] = "";
		// $permiso_software = 1;
		
		$respuesta_boton = $software_libre->mostrarSoftwareboton($id_usuario);
		
		$permiso_software = $respuesta_boton["permiso_software"];
		
		// if ($permiso_software == 0) {
		// 	$data[0] .=
			
		// 	'<div class="card col-xl-12 m-2 p-2">
		// 	<button class="btn btn-primary btn-sm float-right" onclick="mostrar_software()" title="Agregar"><i class="fa fa-plus"></i></button>
		// 	</div>';
			
			
		// }
		$respuesta = $software_libre->mostrarElementos();
		for($i = 0;$i < count($respuesta);$i++ ) {
			$data[0] .='
			<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
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
			</div>';
		}
		echo json_encode($data);
	break;
	case 'cargarFormulario':
		$respuesta_boton = $software_libre->mostrarSoftwareboton($id_usuario);
		
		$permiso_software = $respuesta_boton["permiso_software"];
		
		if ($permiso_software == 0) {
			$data[0] .=
			
			'<div class="card col-xl-12 m-2 p-2">
			<button class="btn btn-primary btn-sm float-right" onclick="mostrar_software()" title="Agregar"><i class="fa fa-plus"></i></button>
			</div>';
			
			
		}
		$id_software_seleccionado = $_POST['id_software'];
		$cargar_modal = $software_libre->cargarFormModal($id_software_seleccionado);
		echo json_encode($cargar_modal);
		break;
	case 'modificar':
		$respuesta_boton = $software_libre->mostrarSoftwareboton($id_usuario);
		
		$permiso_software = $respuesta_boton["permiso_software"];
		
		// if ($permiso_software == 0) {
		// 	$data[0] .=
			
		// 	'<div class="card col-xl-12 m-2 p-2">
		// 	<button class="btn btn-primary btn-sm float-right" onclick="mostrar_software()" title="Agregar"><i class="fa fa-plus"></i></button>
		// 	</div>';
			
			
		// }
	$id_software_modificar = $_POST['id_software_libre'];
	$file_edit = $_FILES['file_url']['name'];
	$respaldoimagen = $_POST['respaldoimagen'];
	$nombre = $_POST['txtNombre'];
	$sitio = $_POST['txtSitio'];
	$url = $_POST['txtUrl'];
	$descripcion = $_POST['txtDescripcion'];
	$valor = $_POST['txtValor'];
	// $categoria_software = $_POST['txtCategoria'];

	if ($file_edit == "") {
		$portada = $_POST['respaldoimagen'];
		$modificar_sw = $software_libre->modificarSoftwareLibre($id_software_modificar,$nombre,$sitio,$url,$portada,$descripcion,$valor,$categoria_software);
	}else {
		$target_path = '../public/img/software_libre/';
    	$img1path = $target_path . $_FILES['file_url']['name'];
        if(move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path))
        {
			$url = $_FILES['file_url']['name'];
            $nombre_imagen = $_FILES['file_url']['name'];
            unlink('../public/img/software_libre/'.$respaldoimagen);
            $modificar_sw = $software_libre->modificarSoftwareLibre($id_software_modificar,$nombre,$sitio,$url,$nombre_imagen,$descripcion,$valor,$categoria_software);
        }
	}
	echo json_encode($modificar_sw);
	break;
	case 'eliminar':
	$id_sw_eliminar = $_POST['id_software_libre'];
	$eliminar_sw = false;
	if (isset($id_sw_eliminar)) {
		$eliminar_sw = $software_libre->eliminarSoftwareLibre($id_sw_eliminar);
		echo json_encode($eliminar_sw);
	}
	break;
	case 'filtrar':
	// $opcion = $_POST['opcion'];
	$data[0] = "";

	if ($permiso_software == 0) {
		$data[0] .=
		
		'<div class="card col-xl-12 m-2 p-2">
		<button class="btn btn-primary btn-sm float-right" onclick="mostrar_software()" title="Agregar"><i class="fa fa-plus"></i></button>
		</div>';
		
		
	}
		
		
	$respuesta = $software_libre->filtrarSoftwareLibre($opcion);
	for($i = 0;$i < count($respuesta);$i++ ) {

		

			$data[0] .=
			
			
			'
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
							<a href="'.$respuesta[$i]["url"].'" class="link" target="_blank">Leer mas</a>
							<button class="btn btn-info infoLibro" onclick="abrirModalSW('.($respuesta[$i]["id_software"]).')">Editar</button>
						</div>
					</div>
				</div>
			</div>';
		}
	echo json_encode($data);
	break;

	case 'mostrarcategorias':
		$data[0] = "";
		
		$data[0] .=" 
		<div class='btn-group btn-group-toggle p-1' data-toggle='buttons role='group' aria-label='Basic example''>
			<label class='btn bg-olive' onclick= 'mostrarElementos()'>
				<input type='radio' name='options' autocomplete='off'>Todos</span>
			</label>
		</div>
	
	";
	
		

		$respuesta = $software_libre->SoftwareLibrecategorias();
		for($i = 0;$i < count($respuesta);$i++ ) {
				
				$data[0] .='

				<div class="btn-group btn-group-toggle p-1" data-toggle="buttons role="group" aria-label="Basic example"">
				
					<label class="btn bg-olive" onclick="filtrarSoftware('.($i+1).')">
						<input type="radio" name="options" autocomplete="off">  <span id="'.($i+1).'">'.$respuesta[$i]["nombre_categoria"].'</span>
					</label>
				</div>
				
				';
			}
		echo json_encode($data);
		break;	

		// listamos el cargo 
		case "softwareCategoria":	

			
			$rspta = $software_libre->software_categoria();
			
			echo "<option selected>Nothing selected</option>";
			for ($i=0;$i<count($rspta);$i++){
				$nombre_categoria = $rspta[$i]["nombre_categoria"];
				$categoria_software  = $rspta[$i]["id_software_categoria"];
				echo "<option value='".$categoria_software."'>" .$nombre_categoria. "</option>" ;
			
			}
			
	
		break;


	case 'mostrar_software_admin':
		
		$respuesta = $software_libre->mostrarSoftware($id_software ,$nombre);
		// print_r($respuesta);
		echo json_encode($respuesta);
	break;

	//guardo el nombre del proyecto
	case 'guardaryeditarsoftware':
	
		if ($id_software == "") {

			$target_path = '../public/img/software_libre/';
			$img1path = $target_path . $_FILES['file_url']['name'];

			// print_r($_FILES['file_url']['name']);
		    if(move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path))
		    {
				// $ruta_img = $_FILES['file_url']['name'];
				$ruta_img = $_FILES['file_url']['name'];
				// print_r($ruta_img);
		        // unlink('../public/img/software_libre/'.$ruta_img);

				$agregar_sw = $software_libre->agregarSoftwareLibreDocente($nombre,$sitio,$url,$ruta_img,$descripcion,$valor,$categoria_software);
		    }

			echo $agregar_sw ? "Software registrado" : "Software no se pudo registrar";
		}
		
		
	break;
	
	default:
		# code...
		break;
}
 ?>