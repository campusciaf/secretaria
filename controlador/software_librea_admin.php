<?php
session_start();
require_once "../modelos/SoftwareLibreAdmin.php";

$software_libre = new SoftwareLibre();
$opcion = isset($_POST["opcion"])? limpiarCadena($_POST["opcion"]):"";
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
		$categoria = $_POST['txtCategoria'];
		if(move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path)){
			$ruta_img = $_FILES['file_url']['name'];
			$agregar_sw = $software_libre->agregarSoftwareLibre($nombre,$sitio,$url,$ruta_img,$descripcion,$valor,$categoria);
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
	case 'mostrar':
		$data[0] = "";
		$respuesta = $software_libre->mostrarElementos();
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
	case 'mostrar_admin':
		$data[0] = "";
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
		$id_software_seleccionado = $_POST['id_software'];
		$cargar_modal = $software_libre->cargarFormModal($id_software_seleccionado);
		echo json_encode($cargar_modal);
		break;
	case 'modificar':
	$id_software_modificar = $_POST['id_software_libre'];
	$file_edit = $_FILES['file_url']['name'];
	$respaldoimagen = $_POST['respaldoimagen'];
	$nombre = $_POST['txtNombre'];
	$sitio = $_POST['txtSitio'];
	$url = $_POST['txtUrl'];
	$descripcion = $_POST['txtDescripcion'];
	$valor = $_POST['txtValor'];
	$categoria = $_POST['txtCategoria'];

	if ($file_edit == "") {
		$portada = $_POST['respaldoimagen'];
		$modificar_sw = $software_libre->modificarSoftwareLibre($id_software_modificar,$nombre,$sitio,$url,$portada,$descripcion,$valor,$categoria);
	}else {
		$target_path = '../public/img/software_libre/';
    	$img1path = $target_path . $_FILES['file_url']['name'];
        if(move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path))
        {
			$url = $_FILES['file_url']['name'];
            $nombre_imagen = $_FILES['file_url']['name'];
            unlink('../public/img/software_libre/'.$respaldoimagen);
            $modificar_sw = $software_libre->modificarSoftwareLibre($id_software_modificar,$nombre,$sitio,$url,$nombre_imagen,$descripcion,$valor,$categoria);
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
	case 'filtrar':
	// $opcion = $_POST['opcion'];
	$data[0] = "";
	$respuesta = $software_libre->filtrarSoftwareLibre($opcion);
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
							<a href="'.$respuesta[$i]["url"].'" class="link" target="_blank">Leer mas</a>
							<button class="btn btn-info infoLibro" onclick="abrirModalSW('.($respuesta[$i]["id_software"]).')">Editar</button>
						</div>
					</div>
				</div>
			</div>';
		}
	echo json_encode($data);
	break;
	
	default:
		# code...
		break;
}
 ?>