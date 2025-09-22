<?php
session_start();
require_once "../modelos/BibliotecaCiaf.php";

$bibliotecaciaf = new BibliotecaCiaf();

$op = (isset($_GET['op']))?$_GET['op']:'mostrar';
switch ($op) {
	case 'agregar':
		$target_path = '../public/img/biblioteca/';
        $img1path = $target_path . $_FILES['file_url']['name'];
		$titulo = $_POST['txtTitulo'];
		$fechaLanz = $_POST['txtFechaLanz'];
		$autor = $_POST['txtAutor'];
		$categoria = $_POST['txtCategoria'];
		$programa = $_POST['txtPrograma'];
		$editorial = $_POST['txtEditorial'];
		$isbn = $_POST['txtISBN'];
		$idioma = $_POST['txtIdioma'];
		$paginas = $_POST['paginas'];
		$formato = $_POST['txtFormato'];
		$descripcion = $_POST['txtDesc'];
		$palabclave = $_POST['txtPalClav'];
		$ejemplares = $_POST['ejemplares'];
		if(move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path)){
			$url = $_FILES['file_url']['name'];
			$agregar_libro = $bibliotecaciaf->agregarLibro($url,$titulo,$fechaLanz,$autor,$categoria,$programa,$editorial,$isbn,$idioma,$paginas,$formato,$descripcion,$palabclave,$ejemplares);
		echo json_encode($agregar_libro);
		}
		
		break;
	case 'mostrar':
		$data[0] = "";
		$respuesta = $bibliotecaciaf->mostrarLibros();
		for($i = 0;$i < count($respuesta);$i++ ) {
			$data[0] .='
			<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2" style="margin:10px 0px; padding:0px">
						<div class="contenedor-img ejemplo-1">
							<img src="../public/img/biblioteca/'.$respuesta[$i]["portada"].'" style="width:225px; height:300px;" class="img-thumbnail">
							<div class="mascara">
								<h2>'.$respuesta[$i]["titulo"].'</h2>
								<button class="btn btn-info infoLibro" onclick="abrirModalLibro('.($respuesta[$i]["id_libro"]).')">Leer Más</button>
							</div>
						</div>
					</div>';
		}
		echo json_encode($data);
	break;
	case 'cargarFormulario':
		$id_libro_seleccionado = $_POST['id_libro'];
		$cargar_modal = $bibliotecaciaf->cargarFormModal($id_libro_seleccionado);
		echo json_encode($cargar_modal);
		break;
	case 'modificar':
		$id_libro_modificar = $_POST['id_libro'];
		$file_edit = $_FILES['file_url']['name'];
		$respaldoimagen = $_POST['respaldoimagen'];
		$titulo = $_POST['txtTitulo'];
		$fechaLanz = $_POST['txtFechaLanz'];
		$autor = $_POST['txtAutor'];
		$categoria = $_POST['txtCategoria'];
		$programa = $_POST['txtPrograma'];
		$editorial = $_POST['txtEditorial'];
		$isbn = $_POST['txtISBN'];
		$idioma = $_POST['txtIdioma'];
		$paginas = $_POST['paginas'];
		$formato = $_POST['txtFormato'];
		$descripcion = $_POST['txtDesc'];
		$palabclave = $_POST['txtPalClav'];
		$ejemplares = $_POST['ejemplares'];

		if ($file_edit == "") {
			$portada = $_POST['respaldoimagen'];
			$modificar_libro = $bibliotecaciaf->modificarLibro($id_libro_modificar,$portada,$titulo,$fechaLanz,$autor,$categoria,$programa,$editorial,$isbn,$idioma,$paginas,$formato,$descripcion,$palabclave,$ejemplares);
		}else {
			$target_path = '../public/img/biblioteca/';
        	$img1path = $target_path . $_FILES['file_url']['name'];
            if(move_uploaded_file($_FILES['file_url']['tmp_name'], $img1path))
            {
				$url = $_FILES['file_url']['name'];
                $nombre_imagen = $_FILES['file_url']['name'];
                unlink('../public/img/biblioteca/'.$respaldoimagen);
                $modificar_libro = $bibliotecaciaf->modificarLibro($id_libro_modificar,$nombre_imagen,$titulo,$fechaLanz,$autor,$categoria,$programa,$editorial,$isbn,$idioma,$paginas,$formato,$descripcion,$palabclave,$ejemplares);
            }
		}
		echo json_encode($modificar_libro);
		break;

	case 'eliminar':
		$id_libro_eliminar = $_POST['id_libro'];
		$eliminar_libro = false;
		if (isset($id_libro_eliminar)) {
			$eliminar_libro = $bibliotecaciaf->eliminarLibro($id_libro_eliminar);
			echo json_encode($eliminar_libro);
		}
		break;
	case 'buscar':
		$busqueda = $_POST['busqueda'];
		$data[0] = "";
		$respuesta = $bibliotecaciaf->buscarLibros($busqueda);
		for($i = 0;$i < count($respuesta);$i++ ) {
			$data[0] .='
			<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2" style="margin:10px 0px; padding:0px">
				<div class="contenedor-img ejemplo-1">
					<img src="../public/img/biblioteca/'.$respuesta[$i]["portada"].'" style="width:225px; height:300px;" class="img-thumbnail">
					<div class="mascara">
						<h2>'.$respuesta[$i]["titulo"].'</h2>
						<button class="btn btn-info infoLibro" onclick="abrirModalLibro('.($respuesta[$i]["id_libro"]).')">Leer Más</button>
					</div>
				</div>
			</div>';
		}
		echo json_encode($data);

	break;
	default:
	break;
}
 ?>