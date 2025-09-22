<?php 
require_once "../modelos/Web_Emprendimientos.php";
$fecha=date('Y-m-d');
$hora=date('H:i');

$ip = $_SERVER['REMOTE_ADDR']; 
$web_emprendimientos = new Web_Emprendimientos();

//variables globales para insertar la imagen 
$id_web_emprendimientos=isset($_POST["id_web_emprendimientos"])? limpiarCadena($_POST["id_web_emprendimientos"]):"";
$nombre_emprendimiento=isset($_POST["nombre_emprendimiento"])? limpiarCadena($_POST["nombre_emprendimiento"]):"";
$nombre_emprendedor=isset($_POST["nombre_emprendedor"])? limpiarCadena($_POST["nombre_emprendedor"]):"";
$descripcion_emprendimiento=isset($_POST["descripcion_emprendimiento"])? limpiarCadena($_POST["descripcion_emprendimiento"]):"";
$telefono_contacto=isset($_POST["telefono_contacto"])? limpiarCadena($_POST["telefono_contacto"]):"";
$imagen_emprendimiento=isset($_POST["agregar_imagen"])? limpiarCadena($_POST["agregar_imagen"]):"";
$id_usuario = $_SESSION['id_usuario'];

//variables globales para editar la imagen 
$id_web_emprendimientos_editar=isset($_POST["id_web_emprendimientos_editar"])? limpiarCadena($_POST["id_web_emprendimientos_editar"]):"";
$nombre_emprendimiento_editar=isset($_POST["nombre_emprendimiento_editar"])? limpiarCadena($_POST["nombre_emprendimiento_editar"]):"";
$nombre_emprendedor_editar=isset($_POST["nombre_emprendedor_editar"])? limpiarCadena($_POST["nombre_emprendedor_editar"]):"";
$descripcion_emprendimiento_editar=isset($_POST["descripcion_emprendimiento_editar"])? limpiarCadena($_POST["descripcion_emprendimiento_editar"]):"";
$telefono_contacto_editar=isset($_POST["telefono_contacto_editar"])? limpiarCadena($_POST["telefono_contacto_editar"]):"";
$editarguardarimg_editar=isset($_POST["editarguardarimg_editar"])? limpiarCadena($_POST["editarguardarimg_editar"]):"";
$agregar_imagen_editar=isset($_POST["agregar_imagen_editar"])? limpiarCadena($_POST["agregar_imagen_editar"]):"";


switch ($_GET["op"]){

	case 'listar':
		$rspta	= $web_emprendimientos->listar();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i ++){
            $id_web_emprendimientos  = $reg[$i]["id_web_emprendimientos"];
			$nombre_emprendimiento = $reg[$i]["nombre_emprendimiento"];
            $nombre_emprendedor = $reg[$i]["nombre_emprendedor"];
            $descripcion_emprendimiento = $reg[$i]["descripcion_emprendimiento"];
            $telefono_contacto = $reg[$i]["telefono_contacto"];
			$imagen_emprendimiento = $reg[$i]["imagen_emprendimiento"];
			$estado_emprendimiento  = $reg[$i]["estado_emprendimiento"];
			$estado_emprendimiento = ($estado_emprendimiento == 1) ?'<span class="badge badge-success p-1">Activado</span>' :'<span class="badge badge-danger p-1">Desactivado</span>';
			$ruta_img = '../public/web_emprendimientos/';
			$imagen_emprendimiento = ($estado_emprendimiento == 1)?"":$imagen_emprendimiento;				
			$url_imagen = ($estado_emprendimiento == 1)?$imagen_emprendimiento:'<img width="100%" src="'.$ruta_img.$imagen_emprendimiento.' ">';
			
			$data[]=array(	

				"0"=>($reg[$i]["estado_emprendimiento"])?'
					<div class="btn-group">
						<button class="tooltip-agregar btn btn-primary btn-xs" onclick="editar('.$id_web_emprendimientos.')"  title="Editar" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>'.'
						<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_emprendimiento('.$id_web_emprendimientos.',`'.$imagen_emprendimiento.'`)" title="Eliminar" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
					</div>'.'<button class="tooltip-agregar btn btn-success btn-xs" onclick="desactivar_emprendimiento('.$id_web_emprendimientos.')" title="Desactivar"><i class="fas fa-lock-open"></i></button>':'<button class="tooltip-agregar btn btn-secondary btn-xs" onclick="activar_emprendimiento('.$id_web_emprendimientos.')" title="Activar"><i class="fas fa-lock"></i></button>',
					
					"1"=>'
					<div style="width:100px !important; ">
						'.$url_imagen.'
					</div>
					',
					"2"=>$nombre_emprendimiento,
					"3"=>$descripcion_emprendimiento,
                    "4"=>$telefono_contacto,
                    "5"=>$estado_emprendimiento,
                    
			);
			
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
	break;
	
	case 'editar':
		$rspta = $web_emprendimientos->mostrar_editar($id_web_emprendimientos);
		echo json_encode($rspta);
	break;

	case 'agregaremprendimiento':

		$ext = explode(".", $_FILES["agregar_imagen"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_emprendimientos/';
		if (!file_exists($_FILES['agregar_imagen']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen']['tmp_name']))
		{
			$imagen_emprendimiento=$imagen_emprendimiento;
		}else{
			
			if ($_FILES['agregar_imagen']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_imagen"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_imagen']['tmp_name'], $img1path_movil)) {
					$imagen_emprendimiento = $_FILES['agregar_imagen']['name'];
				} 

				if (empty($id_web_emprendimientos)){				
					$estado=1;

					$rspta = $web_emprendimientos->insertar($nombre_emprendimiento, $nombre_emprendedor, $descripcion_emprendimiento, $telefono_contacto, $imagen_emprendimiento, $estado, $fecha, $hora, $id_usuario);
					echo $rspta ? "Emprendimiento registrado" : "<br>"."Emprendimiento no se pudo registrar";	
				}
			}
			else{
				echo "Error Extensión No Valida";
				$imagen_emprendimiento=$imagen_emprendimiento;
			}
		}

	break;

	case 'guardaryeditar':

		$ext = explode(".", $_FILES["agregar_imagen_editar"]["name"]);
		$imagen = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_emprendimientos/';
		if (!file_exists($_FILES['agregar_imagen_editar']['tmp_name']) || !is_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name']))
		{
			$imagen_emprendimiento_editar=$editarguardarimg_editar;
		}else{
			
			if ($_FILES['agregar_imagen_editar']['type'] == "image/webp")
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_imagen_editar"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_imagen_editar']['tmp_name'], $img1path_movil)) {
					$imagen_emprendimiento_editar = $_FILES['agregar_imagen_editar']['name'];
					unlink("../public/web_emprendimientos/".$editarguardarimg_editar);
				} 
			}
			else{
				echo "Error Extensión No Valida";
				$imagen_emprendimiento_editar=$editarguardarimg_editar;
			}
		
		}

		$rspta = $web_emprendimientos->editaremprendimiento($id_web_emprendimientos_editar,$nombre_emprendimiento_editar, $nombre_emprendedor_editar, $descripcion_emprendimiento_editar, $telefono_contacto_editar, $imagen_emprendimiento_editar);
		echo $rspta ? "<br>"."Emprendimiento actualizado" : "Emprendimiento no se pudo actualizar";	
	
	break;

	case 'eliminar_emprendimiento':
		$imagen_emprendimiento = $_POST["imagen_emprendimiento"];
		$eliminar_emprendimiento = $web_emprendimientos->eliminarEmperendimiento($id_web_emprendimientos);
		unlink("../public/web_emprendimientos/".$imagen_emprendimiento);  
		echo json_encode($eliminar_emprendimiento);
	break;

	case 'desactivar_emprendimiento':
		$rspta=$web_emprendimientos->desactivarEmperendimiento($id_web_emprendimientos);
		echo json_encode($rspta);
 		//echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;

	case 'activar_emprendimiento':
		$rspta=$web_emprendimientos->activarEmperendimiento($id_web_emprendimientos);
		echo json_encode($rspta);
		
	break;





	

}
