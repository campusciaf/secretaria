<?php
session_start();
require_once "../modelos/Shopping.php";
require("../public/mail/sendFeria.php");
$shopping = new Shopping();
$periodo_actual = $_SESSION['periodo_actual'];
$id_credencial = $_SESSION['id_usuario'];

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');

switch ($_GET["op"]) {
	case 'verificar':
		$data['0'] = "";
		$data['0'] .= '';
		$rspta = $shopping->verificar($id_credencial);
		$data = $rspta ? '1' : '0';
		echo json_encode($data);
		break;
	case 'participar':
		$data['0'] = "";
		$data['0'] .= '';
		$rspta = $shopping->participar($id_credencial, $fecha, $hora);
		$data = $rspta ? '1' : '0';
		echo json_encode($data);
		break;
	case 'mostrar':
		$rspta = $shopping->verificar($id_credencial);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case 'editar':
		$campo = $_POST["campo"];
		$shopping_nombre = $_POST["valor1"];
		$shopping_descripcion = $_POST["valor2"];
		$rspta = $shopping->editar($id_credencial, $shopping_nombre, $shopping_descripcion);
		$data = $rspta ? '1' : '0';
		echo json_encode($data);
		break;
	case 'editarredes':
		$campo = $_POST["campo"];
		$valor = $_POST["valor"];
		if ($campo == '1') {
			$campo = "shopping_facebook";
		}
		if ($campo == '2') {
			$campo = "shopping_instagram";
		}
		$rspta = $shopping->editarredes($id_credencial, $campo, $valor);
		$data = $rspta ? '1' : '0';
		echo json_encode($data);
	break;
	case 'subirArchivo':
		$directorioDestino = "../files/shopping/";
		$archivoDestino = $directorioDestino . basename($_FILES["file"]["name"]);
		$tipoArchivo = strtolower(pathinfo($archivoDestino, PATHINFO_EXTENSION));
		// Verificar si el archivo es una imagen
		if (!in_array($tipoArchivo, ['jpg', 'jpeg'])) {
			$data["exito"] = 0;
			$data['info'] = "Solo se permiten archivos JPG ó JPEG. <br>";
		}else{
			// Verificar el tamaño del archivo
			if ($_FILES["file"]["size"] > 500000) {
				$data["exito"] = 0;
				$data['info'] .= "El archivo es demasiado grande. <br>";
			}else{
				$nombreNuevoArchivo =  $_SESSION['id_usuario'].'.' . $tipoArchivo; 
				$archivoDestino = $directorioDestino . $nombreNuevoArchivo;
				if (!file_exists($directorioDestino)) {
					mkdir($directorioDestino, 0777, true);
				}
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $archivoDestino)) {
					$shopping->ActualizarImagen($id_credencial, $nombreNuevoArchivo);
					$data = array('exito' => 1, 'info' => "El archivo " . htmlspecialchars(basename($_FILES["file"]["name"])) . " ha sido subido.");
				} else {
					$data["exito"] = 0;
					$data['info'] .= "Hubo un error al subir el archivo.";
				}
			}
		}
		echo json_encode($data);
	break;
	case 'EliminarImagen':
		$rspta = $shopping->EliminarImagen($id_credencial);
		if ($rspta) {
			// ruta del archivo a eliminar
			$filePath_jpg = '../files/shopping/' . $_SESSION['id_usuario'] . '.jpg';
			$filePath_jpeg = '../files/shopping/' . $_SESSION['id_usuario'] . '.jpeg';
			// Verificar si el archivo existe
			if (file_exists($filePath_jpg)) {
				if (unlink($filePath_jpg)) {
					$data["exito"] = 1;
					$data['info'] = "Se ha eliminado el archivo";
				} else {
					$data["exito"] = 0;
					$data['info'] = "Hubo un error al eliminar el archivo.";
				}
			} elseif (file_exists($filePath_jpeg)) {
				if (unlink($filePath_jpeg)) {
					$data["exito"] = 1;
					$data['info'] = "Se ha eliminado el archivo";
				} else {
					$data["exito"] = 0;
					$data['info'] = "Hubo un error al eliminar el archivo.";
				}
			} else {
				$data["exito"] = 0;
				$data['info'] = "No hay ningun archivo para eliminar.";
			}
		}else{
			$data["exito"] = 0;
			$data['info'] = "Hubo un error al eliminar el archivo.";
		}
		echo json_encode($data);
	break;
	case 'ImagenExistente':
		$filePath_jpg = '../files/shopping/'.$_SESSION['id_usuario'].'.jpg';
		$filePath_jpeg = '../files/shopping/'.$_SESSION['id_usuario'].'.jpeg';
		if (file_exists($filePath_jpg)) {
			// Obtiene el tamaño del archivo en bytes
			$peso_imagen = filesize($filePath_jpg);
			// Convierte bytes a megabytes con 3 decimales de precisión
			//$peso_imagen_megas = round($peso_imagen / 1024 / 1024, 3);
			$data["exito"] = 1;
			$data['info'] = $_SESSION['id_usuario'] . '.jpg';
			$data['size'] = $peso_imagen;
			$data['format'] = 'image/jpg';
		} else if (file_exists($filePath_jpeg)) {
			// Obtiene el tamaño del archivo en bytes
			$peso_imagen = filesize($filePath_jpeg);
			$data["exito"] = 1;
			$data['info'] = $_SESSION['id_usuario'] . '.jpeg';
			$data['size'] = $peso_imagen;
			$data['format'] = 'image/jpeg';
		} else {
			$data["exito"] = 0;
		}
		echo json_encode($data);
	break;
	case 'enviar':
		$rspta = $shopping->enviar($id_credencial);
		$data = $rspta ? '1' : '0';
		if($data=='1'){
			$datos_estudiante = $shopping->datos_estudiante($id_credencial);
			$nombre=$datos_estudiante["credencial_nombre"] . ' ' . $datos_estudiante["credencial_apellido"];

			$correo="bienestar@ciaf.edu.co";
			$asunto="Revisión emprendimiento";
			$mensaje="Nombre: " . $nombre . ' Identificacion: ' . $datos_estudiante["credencial_identificacion"];
			enviar_correo($correo,$asunto, $mensaje);
		}
		

		echo json_encode($data);
	break;

	case 'autorizo':
		$rspta = $shopping->autorizo($id_credencial);
		$data = $rspta ? '1' : '0';

		echo json_encode($data);
	break;
}
