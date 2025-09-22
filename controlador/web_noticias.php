<?php
require_once "../modelos/Web_Noticias.php";
$fecha_noticias = date('Y-m-d');
$hora = date('H:i');

$ip = $_SERVER['REMOTE_ADDR'];
// error_reporting(1); 
$web_noticias = new Web_Noticias();

// variables globales para editar 
$id_noticias = isset($_POST["id_noticias"]) ? limpiarCadena($_POST["id_noticias"]) : "";
$titulo_noticias = isset($_POST["titulo_noticias"]) ? limpiarCadena($_POST["titulo_noticias"]) : "";
$subtitulo_noticias = isset($_POST["subtitulo_noticias"]) ? limpiarCadena($_POST["subtitulo_noticias"]) : "";
$contenido_noticias_editar = isset($_POST["contenido_noticias_editar"]) ? limpiarCadena($_POST["contenido_noticias_editar"]) : "";
$link_noticia_imagen_editar = isset($_POST["link_noticia_imagen_editar"]) ? limpiarCadena($_POST["link_noticia_imagen_editar"]) : "";

$categoria_noticias = isset($_POST["categoria_noticias"]) ? limpiarCadena($_POST["categoria_noticias"]) : "";
$imagen_noticias = isset($_POST["imagen_noticias"]) ? limpiarCadena($_POST["imagen_noticias"]) : "";
$imagen_noticias_video = isset($_POST["imagen_noticias_video"]) ? limpiarCadena($_POST["imagen_noticias_video"]) : "";
$imageneditarguardar = isset($_POST["imageneditarguardar"]) ? limpiarCadena($_POST["imageneditarguardar"]) : "";
$editarguardarimg = isset($_POST["editarguardarimg"]) ? limpiarCadena($_POST["editarguardarimg"]) : "";
$material_estado = isset($_POST["material_estado"]) ? limpiarCadena($_POST["material_estado"]) : "";
$imagen_iframe = isset($_POST["mostrar_video_noticia"]) ? limpiarCadena($_POST["mostrar_video_noticia"]) : "";
$id_usuario = $_SESSION['id_usuario'];

// variables globales para video
$url_video = isset($_POST["url_video"]) ? limpiarCadena($_POST["url_video"]) : "";
$titulo_noticias_video = isset($_POST["titulo_noticias_video"]) ? limpiarCadena($_POST["titulo_noticias_video"]) : "";
$contenido_noticias_video = isset($_POST["contenido_noticias_video"]) ? limpiarCadena($_POST["contenido_noticias_video"]) : "";
$subtitulo_noticias_video = isset($_POST["subtitulo_noticias_video"]) ? limpiarCadena($_POST["subtitulo_noticias_video"]) : "";
$categoria_noticias_video = isset($_POST["categoria_noticias_video"]) ? limpiarCadena($_POST["categoria_noticias_video"]) : "";
$link_noticia_video = isset($_POST["link_noticia_video"]) ? limpiarCadena($_POST["link_noticia_video"]) : "";

// variables globales para imagen
$agregar_imagen = isset($_POST["agregar_imagen"]) ? limpiarCadena($_POST["agregar_imagen"]) : "";
$agregar_editar_imagen = isset($_POST["agregar_editar_imagen"]) ? limpiarCadena($_POST["agregar_editar_imagen"]) : "";
$agregar_editar_imagen_video = isset($_POST["agregar_editar_imagen_video"]) ? limpiarCadena($_POST["agregar_editar_imagen_video"]) : "";

$titulo_noticias_imagen = isset($_POST["titulo_noticias_imagen"]) ? limpiarCadena($_POST["titulo_noticias_imagen"]) : "";
$contenido_noticias_imagen = isset($_POST["contenido_noticias_imagen"]) ? limpiarCadena($_POST["contenido_noticias_imagen"]) : "";
$subtitulo_noticias_imagen = isset($_POST["subtitulo_noticias_imagen"]) ? limpiarCadena($_POST["subtitulo_noticias_imagen"]) : "";
$categoria_noticias_imagen = isset($_POST["categoria_noticias_imagen"]) ? limpiarCadena($_POST["categoria_noticias_imagen"]) : "";
$link_noticia_imagen = isset($_POST["link_noticia_imagen"]) ? limpiarCadena($_POST["link_noticia_imagen"]) : "";

$agregar_imagen_con_video = isset($_POST["agregar_imagen_con_video"]) ? limpiarCadena($_POST["agregar_imagen_con_video"]) : "";
$editarvideoguardar = isset($_POST["editarvideoguardar"]) ? limpiarCadena($_POST["editarvideoguardar"]) : "";
// $guardaimagennoticia_imagnen=isset($_POST["guardaimagennoticia_imagnen"])? limpiarCadena($_POST["guardaimagennoticia_imagnen"]):"";

switch ($_GET["op"]) {

	case 'listarnoticias':
		$rspta	= $web_noticias->mostrarnoticias();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$titulo = $reg[$i]["titulo_noticias"];
			$subtitulo = $reg[$i]["subtitulo_noticias"];
			$contenido = $reg[$i]["contenido_noticias"];
			$id_noticias  = $reg[$i]["id_noticias"];
			$material  = $reg[$i]["material"];
			$material_num = $reg[$i]["material"];
			$img_noticias  = $reg[$i]["img_noticias"];

			$material2  = $reg[$i]["material"];
			$estado  = $reg[$i]["estado"];
			$url_video_ok  = $reg[$i]["url_video"];

			$ruta_img = '../public/web_noticias/';

			$estado = ($estado == 1) ? '<span class="badge badge-success p-1">Activado</span>' : '<span class="badge badge-danger p-1">Desactivado</span>';
			$material = ($material == 1) ? '<span class="badge badge-warning p-1">Video</span>' : '<span class="badge badge-primary p-1">Imagen</span>';

			$material2 = ($material2 == 1) ? '<span">Video</span>' : '<span>Imagen</span>';

			$imagen_eliminar = ($url_video_ok == "" && $material_num == 1) ? "" : $img_noticias;

			$url_imagen = ($material_num == 1 && $material_num == 2 && $imagen_noticias == "<iframe") ? '' : '<img width="100%" src="' . $ruta_img . $img_noticias . '">';
				$url_imagen_con_video = !empty($url_video_ok) ? '
				<div>
					<button class="btn btn-danger pull-right" id="btnagregar" onclick="ver_video(' . $id_noticias . ')">
						<i class="fa fa-play" aria-hidden="true"></i>
					</button>
				</div>'
				: '';
			$data[] = array(
				"0" => ($reg[$i]["estado"]) ? '
				  <div class="btn-group">
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_noticias(' . $id_noticias . ')" title="Editar Noticia" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>   
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_noticia(' . $id_noticias . ',`' . $imagen_eliminar . '`)" title="Eliminar Noticia" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
					<button class="tooltip-agregar btn btn-success btn-xs" onclick="desactivar_noticia(' . $id_noticias . ')" title="Desactivar" data-toggle="tooltip" data-placement="top"><i class="fas fa-lock-open"></i></button>
				  </div>' :
				  

					'<button class="btn btn-secondary btn-xs" onclick="activar_noticia(' . $id_noticias . ')" title="Activar"><i class="fas fa-lock"></i> </button>
					',

				"1" => '
					<div style="width:150px !important;">
						' . $url_imagen . '
						</style>
					<style>
						.mini iframe{
							height:150px !important;
							width:150px !important;
						}
					</style>
					
					</div>
					',

				"2" => $url_imagen_con_video,
				"3" => $titulo,
				"4" => $subtitulo,
				"5" => '<div style="overflow:hidden; height:100px">' . $contenido . '</div>',
				"6" => $material,
				"7" => $estado


			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
	break;

	case 'mostrar_noticias':
		$rspta = $web_noticias->mostrar_noticias($id_noticias);
		echo json_encode($rspta);
		break;
	case 'mostrar_video':
		$rspta = $web_noticias->mostrar_noticias($id_noticias);
		echo json_encode($rspta);
		break;
	case 'mostrar_imagen':
		$rspta = $web_noticias->mostrar_noticias($id_noticias);
		echo json_encode($rspta);
		break;

	case 'guardaryeditarnoticias':

		if ($material_estado == 1) {
			// $imagen_noticias=$imagen_iframe;
			$ext = explode(".", $_FILES["agregar_editar_imagen_video"]["name"]);
			$imagen = round(microtime(true)) . '.' . end($ext);
			$target_path = '../public/web_noticias/';
			if (!file_exists($_FILES['agregar_editar_imagen_video']['tmp_name']) || !is_uploaded_file($_FILES['agregar_editar_imagen_video']['tmp_name'])) {
				// unlink($_FILES['agregar_editar_imagen_video']['tmp_name']);
				$imagen_noticias_video = $imageneditarguardar;
			} else {

				if ($_FILES['agregar_editar_imagen_video']['type'] == "image/webp") {

					$img1path_movil = $target_path . "" . $_FILES["agregar_editar_imagen_video"]["name"];

					if (move_uploaded_file($_FILES['agregar_editar_imagen_video']['tmp_name'], $img1path_movil)) {
						$imagen_noticias_video = $_FILES['agregar_editar_imagen_video']['name'];

						if (!file_exists($imageneditarguardar)) {
							echo "";
						} else {
							unlink("../public/web_noticias/" . $imageneditarguardar);
						}
					}
					echo "Imagen Editada" . "<br>";
				} else {
					echo "<br>" . "Error Extensión No Valida";
				}
			}

			$rspta = $web_noticias->editarnoticias($imagen_iframe, $imagen_noticias_video, $titulo_noticias, $subtitulo_noticias, $contenido_noticias_editar, $categoria_noticias, $id_noticias, $link_noticia_imagen_editar);
			echo $rspta ? "Video actualizado" : "<br>" . "Noticia no se pudo actualizar";
		} else {
			$ext = explode(".", $_FILES["agregar_editar_imagen"]["name"]);
			$imagen = round(microtime(true)) . '.' . end($ext);
			$target_path = '../public/web_noticias/';
			if (!file_exists($_FILES['agregar_editar_imagen']['tmp_name']) || !is_uploaded_file($_FILES['agregar_editar_imagen']['tmp_name'])) {

				$imagen_noticias = $imageneditarguardar;
			} else {

				if ($_FILES['agregar_editar_imagen']['type'] == "image/webp") {

					$img1path_movil = $target_path . "" . $_FILES["agregar_editar_imagen"]["name"];

					if (move_uploaded_file($_FILES['agregar_editar_imagen']['tmp_name'], $img1path_movil)) {
						$imagen_noticias = $_FILES['agregar_editar_imagen']['name'];
						unlink("../public/web_noticias/" . $imageneditarguardar);
					}
					echo "Imagen Editada" . "<br>";
				} else {
					echo "<br>" . "Error Extensión No Valida";
				}
			}
			$rspta = $web_noticias->editarnoticiasimagen($imagen_noticias, $titulo_noticias, $subtitulo_noticias, $contenido_noticias_editar, $categoria_noticias, $id_noticias, $link_noticia_imagen_editar);
			echo $rspta ? "Noticia actualizado" : "Noticia no se pudo actualizar";
		}


		break;

	case 'eliminar_noticia':
		// $img_noticias 
		$img_noticias = $_POST["img_noticias"];
		$eliminar_noticia = $web_noticias->eliminarNoticia($id_noticias);

		unlink("../public/web_noticias/" . $img_noticias);
		echo json_encode($eliminar_noticia);

		break;

	case "Categoria_noticia":
		$rspta = $web_noticias->noticias_categoria();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			$nombre_categoria = $rspta[$i]["nombre_categoria"];
			$id_categoria_noticias  = $rspta[$i]["id_categoria_noticias"];
			echo "<option value='" . $id_categoria_noticias . "'>" . $nombre_categoria . "</option>";
		}
		break;

	case "Categoria_video":
		$rspta = $web_noticias->noticias_categoria();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			$nombre_categoria = $rspta[$i]["nombre_categoria"];
			$id_categoria_noticias  = $rspta[$i]["id_categoria_noticias"];
			echo "<option value='" . $id_categoria_noticias . "'>" . $nombre_categoria . "</option>";
		}
		break;


		case 'desactivar_noticia':
			$desactivar_noticia = $web_noticias->desactivar_noticia($id_noticias);
			echo json_encode($desactivar_noticia);
			break;

	case 'activar_noticia':
		$rspta = $web_noticias->activar_noticia($id_noticias);
		echo json_encode($rspta);

		break;

	case 'imagenyvideo':

		$data[0] = '';
		$rspta	= $web_noticias->mostrar_noticias($id_noticias);

		$material = $rspta["material"];
		$imagen_noticias_video = $rspta["img_noticias"];
		$url_video = $rspta["url_video"];
		$contenido_noticias_video = $rspta["contenido_noticias"];
		$ruta = "../public/web_noticias/" . $imagen_noticias_video;
		if ($material == 1) {

			$data[0] .= '
			<br>

			<div class="form-group col-12" >
					<div class="form-group mb-3 position-relative check-valid">
						<div class="form-floating">
							<input type="text" placeholder="" value="' . $url_video . '" required="" class="form-control border-start-0" name="mostrar_video_noticia" id="mostrar_video_noticia" maxlength="100" required>
							<label>Url Video</label>
						</div>
					</div>
					<div class="invalid-feedback">Please enter valid input</div>	';

			$data[0] .= '<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12" >
		<br>
			<label for="agregar_editar_imagen_video" style="cursor: pointer">
				<img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto mobile">
			</label>
			<input id="agregar_editar_imagen_video" name="agregar_editar_imagen_video" type="file" style="display: none" />
		</div>';
		} elseif ($material == 2) {

			$data[0] .= '
			<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12" >
			<br>
				<label for="agregar_editar_imagen" style="cursor: pointer">
					<img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto mobile">
				</label>
				<input id="agregar_editar_imagen" name="agregar_editar_imagen" type="file" style="display: none" />
			</div>';
		}

		echo json_encode($data);
		break;

	case 'cambiar_formato':
		$rspta = $web_noticias->cambiar_formato($id_noticias);
		break;


	case 'agregarvideo':

		$ext = explode(".", $_FILES["agregar_imagen_con_video"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_noticias/';
		if (!file_exists($_FILES['agregar_imagen_con_video']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_con_video']['tmp_name'])) {
			$agregar_imagenvideo = $editarvideoguardar;
		} else {

			if ($_FILES['agregar_imagen_con_video']['type'] == "image/webp") {

				$img1path_movil = $target_path . "" . $_FILES["agregar_imagen_con_video"]["name"];

				if (move_uploaded_file($_FILES['agregar_imagen_con_video']['tmp_name'], $img1path_movil)) {
					$agregar_imagenvideo = $_FILES['agregar_imagen_con_video']['name'];
				}
			} else {
				echo "<br>" . "Error Extensión No Valida";
			}
		}

		if (empty($id_noticias)) {
			$estado = 1;
			$extension_categoria_video = 1;
			$rspta = $web_noticias->insertarnoticiasimagenyvideo($id_noticias, $url_video, $agregar_imagenvideo, $titulo_noticias_video, $subtitulo_noticias_video, $contenido_noticias_video, $fecha_noticias, $categoria_noticias_video, $link_noticia_video, $estado, $ip, $hora, $fecha_noticias, $id_usuario, $extension_categoria_video);
			echo $rspta ? "Video registrado " : "<br>" . "Video no insertado";
		}

		break;


	case 'agregarimagen':

		$ext = explode(".", $_FILES["agregar_imagen"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_noticias/';
		if (!file_exists($_FILES['agregar_imagen']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen']['tmp_name'])) {
			$imagen_noticias = $editarguardarimg;
		} else {

			if ($_FILES['agregar_imagen']['type'] == "image/webp") {

				$img1path_movil = $target_path . "" . $_FILES["agregar_imagen"]["name"];

				if (move_uploaded_file($_FILES['agregar_imagen']['tmp_name'], $img1path_movil)) {
					$imagen_noticias = $_FILES['agregar_imagen']['name'];
				}

				if (empty($id_noticias)) {
					$estado = 1;
					$extension_categoria_imagen = 2;
					$rspta = $web_noticias->insertarnoticias($id_noticias, $imagen_noticias, $titulo_noticias_imagen, $subtitulo_noticias_imagen, $contenido_noticias_imagen, $fecha_noticias, $categoria_noticias_imagen, $link_noticia_imagen, $estado, $ip, $hora, $fecha_noticias, $id_usuario, $extension_categoria_imagen);
					echo $rspta ? "Imagen registrado " : "<br>" . "Error Extensión No Valida";
				}
			} else {
				echo "<br>" . "Error Extensión No Valida";
			}
		}

		break;

	case 'ver_video':
		$id_noticias = $_POST["id_noticias"];
		$ver_video = $web_noticias->mostrar_noticias($id_noticias);
		$url_video = $ver_video["url_video"];

		$data[0] = "";
		$data[0] .= '
			<iframe src="https://www.youtube.com/embed/' . $url_video . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  style="width: 478px !important; height: 341px !important;"></iframe>
			';
		echo json_encode($data);
		break;
}
