<?php
require_once "../modelos/Mi_Blog.php";
$fecha_blog = date('Y-m-d');
$hora = date('H:i');

$ip = $_SERVER['REMOTE_ADDR'];
// error_reporting(1); 
$mi_blog = new Mi_Blog();

// variables globales para editar 
$id_blog = isset($_POST["id_blog"]) ? limpiarCadena($_POST["id_blog"]) : "";
$titulo_blog = isset($_POST["titulo_blog"]) ? limpiarCadena($_POST["titulo_blog"]) : "";
$subtitulo_blog = isset($_POST["subtitulo_blog"]) ? limpiarCadena($_POST["subtitulo_blog"]) : "";
$contenido_blog_editar = isset($_POST["contenido_blog_editar"]) ? limpiarCadena($_POST["contenido_blog_editar"]) : "";
$link_noticia_imagen_editar = isset($_POST["link_noticia_imagen_editar"]) ? limpiarCadena($_POST["link_noticia_imagen_editar"]) : "";

$imagen_blog = isset($_POST["imagen_blog"]) ? limpiarCadena($_POST["imagen_blog"]) : "";
$imagen_blog_video = isset($_POST["imagen_blog_video"]) ? limpiarCadena($_POST["imagen_blog_video"]) : "";
$imageneditarguardar = isset($_POST["imageneditarguardar"]) ? limpiarCadena($_POST["imageneditarguardar"]) : "";
$editarguardarimg = isset($_POST["editarguardarimg"]) ? limpiarCadena($_POST["editarguardarimg"]) : "";
$material_estado = isset($_POST["material_estado"]) ? limpiarCadena($_POST["material_estado"]) : "";
$imagen_iframe = isset($_POST["mostrar_video_noticia"]) ? limpiarCadena($_POST["mostrar_video_noticia"]) : "";
$id_usuario = $_SESSION['id_usuario'];

// variables globales para video
$url_video = isset($_POST["url_video"]) ? limpiarCadena($_POST["url_video"]) : "";
$titulo_blog_video = isset($_POST["titulo_blog_video"]) ? limpiarCadena($_POST["titulo_blog_video"]) : "";
$contenido_blog_video = isset($_POST["contenido_blog_video"]) ? limpiarCadena($_POST["contenido_blog_video"]) : "";
$subtitulo_blog_video = isset($_POST["subtitulo_blog_video"]) ? limpiarCadena($_POST["subtitulo_blog_video"]) : "";
$link_noticia_video = isset($_POST["link_noticia_video"]) ? limpiarCadena($_POST["link_noticia_video"]) : "";

// variables globales para imagen
$agregar_imagen = isset($_POST["agregar_imagen"]) ? limpiarCadena($_POST["agregar_imagen"]) : "";
$agregar_editar_imagen = isset($_POST["agregar_editar_imagen"]) ? limpiarCadena($_POST["agregar_editar_imagen"]) : "";
$agregar_imagen_con_video = isset($_POST["agregar_imagen_con_video"]) ? limpiarCadena($_POST["agregar_imagen_con_video"]) : "";

$titulo_blog_imagen = isset($_POST["titulo_blog_imagen"]) ? limpiarCadena($_POST["titulo_blog_imagen"]) : "";
$contenido_blog_imagen = isset($_POST["contenido_blog_imagen"]) ? limpiarCadena($_POST["contenido_blog_imagen"]) : "";
$subtitulo_blog_imagen = isset($_POST["subtitulo_blog_imagen"]) ? limpiarCadena($_POST["subtitulo_blog_imagen"]) : "";
$link_noticia_imagen = isset($_POST["link_noticia_imagen"]) ? limpiarCadena($_POST["link_noticia_imagen"]) : "";
$editarvideoguardarconvideo = isset($_POST["editarvideoguardarconvideo"]) ? limpiarCadena($_POST["editarvideoguardarconvideo"]) : "";
// $guardaimagennoticia_imagnen=isset($_POST["guardaimagennoticia_imagnen"])? limpiarCadena($_POST["guardaimagennoticia_imagnen"]):"";

switch ($_GET["op"]) {

	case 'listarnoticias':
		$id_usuario = $_SESSION["id_usuario"];
		$rspta	= $mi_blog->mostrar_noticias_por_usuario($id_usuario);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$titulo = $reg[$i]["titulo_blog"];
			$subtitulo = $reg[$i]["subtitulo_blog"];
			$contenido = $reg[$i]["contenido_blog"];
			$id_blog  = $reg[$i]["id_blog"];
			$material  = $reg[$i]["material"];
			$material_num = $reg[$i]["material"];
			$blog_img  = $reg[$i]["blog_img"];

			$material2  = $reg[$i]["material"];
			$estado  = $reg[$i]["estado"];
			$url_video_ok  = $reg[$i]["url_video"];
			$ruta_img = '../public/web_blog/';

			$estado = ($estado == 1) ? '<span class="badge badge-success p-1">Activado</span>' : '<span class="badge badge-danger p-1">Desactivado</span>';
			$material = ($material == 1) ? '<span class="badge badge-warning p-1">Video</span>' : '<span class="badge badge-primary p-1">Imagen</span>';

			$material2 = ($material2 == 1) ? '<span">Video</span>' : '<span>Imagen</span>';

			$imagen_eliminar = ($url_video_ok == "" && $material_num == 1) ? "" : $blog_img;

			$url_imagen = ($material_num == 1 && $material_num == 2 && $imagen_blog == "<iframe") ? '' : '<img width="100%" src="' . $ruta_img . $blog_img . '">';
				$url_imagen_con_video = !empty($url_video_ok) ? '
				<div>
					<button class="btn btn-danger pull-right" id="btnagregar" onclick="ver_video(' . $id_blog . ')">
						<i class="fa fa-play" aria-hidden="true"></i>
					</button>
				</div>'
				: '';
			$data[] = array(
				"0" => ($reg[$i]["estado"]) ? '
				  <div class="btn-group">
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_blog(' . $id_blog . ')" title="Editar Noticia" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>   
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_blog(' . $id_blog . ',`' . $imagen_eliminar . '`)" title="Eliminar Noticia" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
					<button class="tooltip-agregar btn btn-success btn-xs" onclick="desactivar_noticia(' . $id_blog . ')" title="Desactivar" data-toggle="tooltip" data-placement="top"><i class="fas fa-lock-open"></i></button>
				  </div>' :
					'<button class="btn btn-secondary btn-xs" onclick="activar_noticia(' . $id_blog . ')" title="Activar"><i class="fas fa-lock"></i> </button>
					',

				"1" => 
					'<div style="width:150px !important;">
						' . $url_imagen . '
						</style>
					</div>',

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

	case 'mostrar_blog':
		$rspta = $mi_blog->mostrar_blog($id_blog);
		echo json_encode($rspta);
		break;
	case 'mostrar_video':
		$rspta = $mi_blog->mostrar_blog($id_blog);
		echo json_encode($rspta);
		break;
	case 'mostrar_imagen':
		$rspta = $mi_blog->mostrar_blog($id_blog);
		echo json_encode($rspta);
		break;

	case 'guardaryeditarnoticias':

		if ($material_estado == 1) {
			// $imagen_blog=$imagen_iframe;
			$ext = explode(".", $_FILES["agregar_imagen_con_video"]["name"]);
			$imagen = round(microtime(true)) . '.' . end($ext);
			$target_path = '../public/web_blog/';
			if (!file_exists($_FILES['agregar_imagen_con_video']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_con_video']['tmp_name'])) {
				// unlink($_FILES['agregar_imagen_con_video']['tmp_name']);
				$imagen_blog_video = $imageneditarguardar;
			} else {

				if ($_FILES['agregar_imagen_con_video']['type'] == "image/webp") {

					$img1path_movil = $target_path . "" . $_FILES["agregar_imagen_con_video"]["name"];

					if (move_uploaded_file($_FILES['agregar_imagen_con_video']['tmp_name'], $img1path_movil)) {
						$imagen_blog_video = $_FILES['agregar_imagen_con_video']['name'];

						if (!file_exists($imageneditarguardar)) {
							echo "";
						} else {
							unlink("../public/web_blog/" . $imageneditarguardar);
						}
					}
					echo "Imagen Editada" . "<br>";
				} else {
					echo "<br>" . "Error Extensión No Valida";
				}
			}

			$rspta = $mi_blog->editarnoticias($imagen_iframe, $imagen_blog_video, $titulo_blog, $subtitulo_blog, $contenido_blog_editar, $id_blog, $link_noticia_imagen_editar);
			echo $rspta ? "Video actualizado" : "<br>" . "Noticia no se pudo actualizar";
		} else {
			$ext = explode(".", $_FILES["agregar_editar_imagen"]["name"]);
			$imagen = round(microtime(true)) . '.' . end($ext);
			$target_path = '../public/web_blog/';
			if (!file_exists($_FILES['agregar_editar_imagen']['tmp_name']) || !is_uploaded_file($_FILES['agregar_editar_imagen']['tmp_name'])) {

				$imagen_blog = $imageneditarguardar;
			} else {

				if ($_FILES['agregar_editar_imagen']['type'] == "image/webp") {

					$img1path_movil = $target_path . "" . $_FILES["agregar_editar_imagen"]["name"];

					if (move_uploaded_file($_FILES['agregar_editar_imagen']['tmp_name'], $img1path_movil)) {
						$imagen_blog = $_FILES['agregar_editar_imagen']['name'];
						unlink("../public/web_blog/" . $imageneditarguardar);
					}
					echo "Imagen Editada" . "<br>";
				} else {
					echo "<br>" . "Error Extensión No Valida";
				}
			}
			$rspta = $mi_blog->editarnoticiasimagen($imagen_blog, $titulo_blog, $subtitulo_blog, $contenido_blog_editar, $id_blog, $link_noticia_imagen_editar);
			echo $rspta ? "Noticia actualizado" : "Noticia no se pudo actualizar";
		}

		break;

	case 'eliminar_blog':
		// $img_blog 
		$blog_img = $_POST["blog_img"];
		$eliminar_blog = $mi_blog->eliminarBlog($id_blog);

		unlink("../public/web_blog/" . $blog_img);

  

		echo json_encode($eliminar_blog);

		break;

	case "Categoria_noticia":
		$rspta = $mi_blog->noticias_categoria();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			$nombre_categoria = $rspta[$i]["nombre_categoria"];
			$id_categoria_noticias  = $rspta[$i]["id_categoria_noticias"];
			echo "<option value='" . $id_categoria_noticias . "'>" . $nombre_categoria . "</option>";
		}
		break;

	case "Categoria_video":
		$rspta = $mi_blog->noticias_categoria();
		echo "<option selected>Nothing selected</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			$nombre_categoria = $rspta[$i]["nombre_categoria"];
			$id_categoria_blog  = $rspta[$i]["id_categoria_blog"];
			echo "<option value='" . $id_categoria_blog . "'>" . $nombre_categoria . "</option>";
		}
		break;


		case 'desactivar_noticia':
			$desactivar_noticia = $mi_blog->desactivar_noticia($id_blog);
			echo json_encode($desactivar_noticia);
			break;

	case 'activar_noticia':
		$rspta = $mi_blog->activar_noticia($id_blog);
		echo json_encode($rspta);

		break;

	case 'imagenyvideo':

		$data[0] = '';
		$rspta	= $mi_blog->mostrar_blog($id_blog);

		$material = $rspta["material"];
		$imagen_blog_video = $rspta["blog_img"];
		$url_video = $rspta["url_video"];
		$contenido_blog_video = $rspta["contenido_blog"];
		$ruta = "../public/web_blog/" . $imagen_blog_video;
		if ($material == 1) {

			$data[0] .= '
			<br>

			<div class="form-group col-12" >
					<div class="form-group mb-3 position-relative check-valid">
						<div class="form-floating">
							<input type="text" placeholder="" value="' . $url_video . '" class="form-control border-start-0" name="mostrar_video_noticia" id="mostrar_video_noticia" maxlength="100" >
							<label>Url Video</label>
						</div>
					</div>
					<div class="invalid-feedback">Please enter valid input</div>	';

			$data[0] .= '<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12" >
		<br>
			<label for="agregar_imagen_con_video" style="cursor: pointer">
				<img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto mobile">
			</label>
			<input id="agregar_imagen_con_video" name="agregar_imagen_con_video" type="file" style="display: none" />
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
		$rspta = $mi_blog->cambiar_formato($id_blog);
		break;


	case 'agregarvideo':

		$ext = explode(".", $_FILES["agregar_imagen_con_video"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_blog/';
		if (!file_exists($_FILES['agregar_imagen_con_video']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_con_video']['tmp_name'])) {
			$agregar_imagenvideo = $editarvideoguardarconvideo;
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

		if (empty($id_blog)) {
			$estado = 1;
			$extension_categoria_video = 1;
			$rspta = $mi_blog->insertarblogimagenyvideo($id_blog, $url_video, $agregar_imagenvideo, $titulo_blog_video, $subtitulo_blog_video, $contenido_blog_video, $fecha_blog, $link_noticia_video, $estado, $ip, $hora, $fecha_blog, $id_usuario, $extension_categoria_video);
			echo $rspta ? "Video registrado " : "<br>" . "Video no insertado";
		}

		break;


	case 'agregarimagen':

		$ext = explode(".", $_FILES["agregar_imagen"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_blog/';
		if (!file_exists($_FILES['agregar_imagen']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen']['tmp_name'])) {
			$imagen_blog = $editarguardarimg;
		} else {

			if ($_FILES['agregar_imagen']['type'] == "image/webp") {

				$img1path_movil = $target_path . "" . $_FILES["agregar_imagen"]["name"];

				if (move_uploaded_file($_FILES['agregar_imagen']['tmp_name'], $img1path_movil)) {
					$imagen_blog = $_FILES['agregar_imagen']['name'];
				}

				if (empty($id_blog)) {
					$estado = 1;
					$extension_categoria_imagen = 2;
					$rspta = $mi_blog->insertarblog($id_blog, $imagen_blog, $titulo_blog_imagen, $subtitulo_blog_imagen, $contenido_blog_imagen, $fecha_blog, $link_noticia_imagen, $estado, $ip, $hora, $fecha_blog, $id_usuario, $extension_categoria_imagen);
					echo $rspta ? "Imagen registrado " : "<br>" . "Error Extensión No Valida";
				}
			} else {
				echo "<br>" . "Error Extensión No Valida";
			}
		}

		break;

	case 'ver_video':
		$id_blog = $_POST["id_blog"];
		$ver_video = $mi_blog->mostrar_blog($id_blog);
		$url_video = $ver_video["url_video"];

		$data[0] = "";
		$data[0] .= '
			<iframe class="video_blog" src="https://www.youtube.com/embed/' . $url_video . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  style="width: 478px !important; height: 341px !important;"></iframe>
			';
		echo json_encode($data);
		break;
}
