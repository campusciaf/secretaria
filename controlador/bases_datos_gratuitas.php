<?php
session_start();
require_once "../modelos/BasesDatosGratuitas.php";

$bd_gratuita = new BDGratuita();

$op = (isset($_GET['op']))?$_GET['op']:'mostrar';
switch ($op) {
	case 'agregar':
		$target_path = '../public/img/bd_gratuitas/';
        $img1path = $target_path . $_FILES['file_url']['name'];
		$nombre = $_POST['txtNombre'];
		$sitio = $_POST['txtSitio'];
		$url = $_POST['txtUrl'];
		$descripcion = $_POST['txtDescripcion'];
		$valor = $_POST['txtValor'];
		if(move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path)){
			$ruta_img = $_FILES['file_url']['name'];
			$agregar_bd = $bd_gratuita->agregarBaseDatos($nombre,$sitio,$url,$ruta_img,$descripcion,$valor);
		echo json_encode($agregar_bd);
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
		$respuesta = $bd_gratuita->mostrarElementos();
		for($i = 0;$i < count($respuesta);$i++ ) {
			$data[0] .='
			<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3" >
				<div class="contenedor-img ejemplo-1">
					<center>
						<img src="../public/img/bd_gratuitas/'.$respuesta[$i]["ruta_img"].'">
					</center>
					<span class="titulo6"><b>'.$respuesta[$i]["nombre"].'</b></span>  
					 <hr width="90%" size="1px" style="border: dashed 1px gray">
					<span class="titulo8">'.$respuesta[$i]["sitio"].'</span><br>
					<br><span class="titulo1">'.$respuesta[$i]["valor"].'</span><br><br>
					 <div class="mascara" style="width:315px, height: 295px;">
					 <h2>'.$respuesta[$i]["nombre"].'</h2> 
					 	<p>'.$respuesta[$i]["descripcion"].'</p>
						 <a href="'.$respuesta[$i]["url"].'" class="link" target="_blank">Leer mas</a>
					 </div>
				</div>
			</div>';
		}
		echo json_encode($data);
	break;
	case 'mostrar_admin':
		$data[0] = "";
		$respuesta = $bd_gratuita->mostrarElementos();
		for($i = 0;$i < count($respuesta);$i++ ) {
			$data[0] .='
			<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3" >
				<div class="contenedor-img ejemplo-1">
					<center>
						<img src="../public/img/bd_gratuitas/'.$respuesta[$i]["ruta_img"].'">
					</center>
					<span class="titulo6"><b>'.$respuesta[$i]["nombre"].'</b></span>  
					 <hr width="90%" size="1px" style="border: dashed 1px gray">
					<span class="titulo8">'.$respuesta[$i]["sitio"].'</span><br>
					<br><span class="titulo1">'.$respuesta[$i]["valor"].'</span><br><br>
					 <div class="mascara" style="width:315px, height: 295px;">
					 <h2>'.$respuesta[$i]["nombre"].'</h2> 
					 	<p>'.$respuesta[$i]["descripcion"].'</p>
						 <a href="'.$respuesta[$i]["url"].'" class="link" target="_blank">Leer más</a>
						 <button class="btn btn-info" onclick="abrirModalBD('.($respuesta[$i]["id_base_datos"]).')">Editar</button>
					 </div>
				</div>
			</div>';
		}
		echo json_encode($data);
	break;
	case 'cargarFormulario':
		$id_base_datos_seleccionada = $_POST['id_base_datos'];
		$cargar_modal = $bd_gratuita->cargarFormModal($id_base_datos_seleccionada);
		echo json_encode($cargar_modal);
		break;
	case 'modificar':
	$id_bd_modificar = $_POST['id_base_datos'];
	$file_edit = $_FILES['file_url']['name'];
	$respaldoimagen = $_POST['respaldoimagen'];
	$nombre = $_POST['txtNombre'];
	$sitio = $_POST['txtSitio'];
	$url = $_POST['txtUrl'];
	$descripcion = $_POST['txtDescripcion'];
	$valor = $_POST['txtValor'];

	if ($file_edit == "") {
		$portada = $_POST['respaldoimagen'];
		$modificar_bd = $bd_gratuita->modificarBaseDatos($id_bd_modificar,$nombre,$sitio,$url,$portada,$descripcion,$valor);
	}else {
		$target_path = '../public/img/bd_gratuitas/';
    	$img1path = $target_path . $_FILES['file_url']['name'];
        if(move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path))
        {
			$url = $_FILES['file_url']['name'];
            $nombre_imagen = $_FILES['file_url']['name'];
            unlink('../public/img/bd_gratuitas/'.$respaldoimagen);
            $modificar_bd = $bd_gratuita->modificarBaseDatos($id_bd_modificar,$nombre,$sitio,$url,$nombre_imagen,$descripcion,$valor);
        }
	}
	echo json_encode($modificar_bd);
	break;

case 'eliminar':
	$id_bd_eliminar = $_POST['id_base_datos'];
	$eliminar_bd = false;
	if (isset($id_bd_eliminar)) {
		$eliminar_bd = $bd_gratuita->eliminarBaseDatos($id_bd_eliminar);
		echo json_encode($eliminar_bd);
	}
	break;
	
	default:
		# code...
		break;
}
 ?>