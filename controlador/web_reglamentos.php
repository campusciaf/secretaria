<?php 
require_once "../modelos/Web_Reglamentos.php";
$fecha=date('Y-m-d');
$hora=date('H:i');

$ip = $_SERVER['REMOTE_ADDR']; 
$web_reglamento = new Web_Reglamentos();

//variables globales para insertar la pdf 
$id_web_reglamento=isset($_POST["id_web_reglamento"])? limpiarCadena($_POST["id_web_reglamento"]):"";
$nombre_reglamento=isset($_POST["nombre_reglamento"])? limpiarCadena($_POST["nombre_reglamento"]):"";
$editarguardarimg=isset($_POST["editarguardarimg"])? limpiarCadena($_POST["editarguardarimg"]):"";
$pdf_reglamento=isset($_POST["pdf_reglamento"])? limpiarCadena($_POST["pdf_reglamento"]):"";
$agregar_pdf=isset($_POST["agregar_pdf"])? limpiarCadena($_POST["agregar_pdf"]):"";
$id_usuario = $_SESSION['id_usuario'];
$id_categoria_reglamento=isset($_POST["categoria_reglamento"])? limpiarCadena($_POST["categoria_reglamento"]):""; 

//variables globales para editar la pdf 
$id_web_reglamento_editar=isset($_POST["id_web_reglamento_editar"])? limpiarCadena($_POST["id_web_reglamento_editar"]):"";
$nombre_reglamento_editar=isset($_POST["nombre_reglamento_editar"])? limpiarCadena($_POST["nombre_reglamento_editar"]):"";
$editarguardarimg_editar=isset($_POST["editarguardarimg_editar"])? limpiarCadena($_POST["editarguardarimg_editar"]):"";
$pdf_reglamento_editar=isset($_POST["pdf_reglamento_editar"])? limpiarCadena($_POST["pdf_reglamento_editar"]):"";
$agregar_pdf_editar=isset($_POST["agregar_pdf_editar"])? limpiarCadena($_POST["agregar_pdf_editar"]):"";
$id_categoria_reglamento_editar=isset($_POST["categoria_reglamento_editar"])? limpiarCadena($_POST["categoria_reglamento_editar"]):""; 

switch ($_GET["op"]){

	case 'listarreglamento':
		$rspta	= $web_reglamento->mostrarreglamento();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i ++){
			$titulo = $reg[$i]["nombre_reglamento"];
			$pdf_reglamento = $reg[$i]["url_reglamento"];
			$id_web_reglamento  = $reg[$i]["id_web_reglamentos"];
			$id_categoria_reglamento = $reg[$i]["id_categoria_reglamento"];
			$estado  = $reg[$i]["estado"];
			$estado = ($estado == 1) ?'<span class="badge badge-success p-1">Activado</span>' :'<span class="badge badge-danger p-1">Desactivado</span>';

			$nombre_id_categoria_reglamento=$web_reglamento->mostrarnombrereglamento($id_categoria_reglamento);
			$data[]=array(	

				"0"=>($reg[$i]["estado"])?'
				<div class="btn-group">
					<button class="tooltip-agregar btn btn-primary btn-xs" onclick="mostrar_pdf_editar('.$id_web_reglamento.')"  title="Editar reglamento" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>'.'
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_reglamento('.$id_web_reglamento.',`'.$pdf_reglamento.'`)" title="Eliminar reglamento" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>'.
					'<button class="tooltip-agregar btn btn-success btn-xs" onclick="desactivar_reglamento('.$id_web_reglamento.')" title="Desactivar"><i class="fas fa-lock-open"></i></button>
				</div>':'<button class="tooltip-agregar btn btn-secondary btn-xs" onclick="activar_reglamento('.$id_web_reglamento.')" title="Activar"><i class="fas fa-lock"></i></button>',
					
				
					"1"=>$titulo,
					"2"=>'<a class="tooltip-agregar" title="Descargar Formato" data-toggle="tooltip" data-placement="top" href="../public/web_reglamentos/'.$pdf_reglamento.'" target="_blank"><i class="fas fa-file-download"></i></a>',
					"3"=>$nombre_id_categoria_reglamento["categoria_reglamento"],
					"4"=>$estado
			);
			
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
	break;

	case "selectCategoriasReglamentos":
		$rspta = $web_reglamento->selectCategoriasReglamentos();
		echo "<option value=''>Seleccionar Categoria </option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["id_categoria_reglamento"] . "'>" . $rspta[$i]["categoria_reglamento"] . "</option>";
		}
	break;


	
	case 'mostrar_pdf':
		$rspta = $web_reglamento->mostrar_reglamento($id_web_reglamento);
		echo json_encode($rspta);
	break;

	case 'agregarpdf':

		$ext = explode(".", $_FILES["agregar_pdf"]["name"]);
		$prueba_tamaño_archivo = $_FILES['agregar_pdf']['size'];
		$pdf = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_reglamentos/';
		if (!file_exists($_FILES['agregar_pdf']['tmp_name']) || !is_uploaded_file($_FILES['agregar_pdf']['tmp_name']))
		{
			$pdf_reglamento=$editarguardarimg;
		}else{
			
			if ($_FILES['agregar_pdf']['type'] == "application/pdf" AND $prueba_tamaño_archivo <= 5242880)
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_pdf"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_pdf']['tmp_name'], $img1path_movil)) {
					$pdf_reglamento = $_FILES['agregar_pdf']['name'];
					
				} 

				if (empty($id_web_reglamento)){				
					$estado=1;
					$rspta = $web_reglamento->insertarreglamento($id_web_reglamento, $nombre_reglamento, $pdf_reglamento, $ip, $hora, $fecha,$id_usuario,$id_categoria_reglamento);
					echo $rspta ? "Reglamento registrada" : "<br>"."Error excediste el limite del archivo";	
				}
			}
			else{
				echo "Error excediste el limite del archivo";
				$pdf_reglamento=$editarguardarimg;
				
			}
		
		}

	break;

	case 'guardaryeditarreglamento':

		$ext = explode(".", $_FILES["agregar_pdf_editar"]["name"]);
		$pdf = round(microtime(true)) . '.' . end($ext);
		$target_path = '../public/web_reglamentos/';
		if (!file_exists($_FILES['agregar_pdf_editar']['tmp_name']) || !is_uploaded_file($_FILES['agregar_pdf_editar']['tmp_name']))
		{
			$pdf_reglamento_editar=$editarguardarimg_editar;
		}else{
			
			if ($_FILES['agregar_pdf_editar']['type'] == "application/pdf" AND $prueba_tamaño_archivo <= 5242880)
			{
				
				$img1path_movil = $target_path . "".$_FILES["agregar_pdf_editar"]["name"]; 
		
				if (move_uploaded_file($_FILES['agregar_pdf_editar']['tmp_name'], $img1path_movil)) {
					$pdf_reglamento_editar = $_FILES['agregar_pdf_editar']['name'];
					// echo "pdf Editada";
				} 
			}
			else{
				echo "Error Extensión No Valida";
				$pdf_reglamento_editar=$editarguardarimg_editar;
			}
		
		}

		$rspta = $web_reglamento->editarreglamento($nombre_reglamento_editar, $pdf_reglamento_editar, $id_web_reglamento_editar, $id_categoria_reglamento_editar);
		echo $rspta ? "Reglamento actualizado" : "Error excediste el limite del archivo";	
	
	break;

	case 'eliminar_reglamento':
		$pdf_reglamento = $_POST["pdf_reglamento"];
		$eliminar_reglamento = $web_reglamento->eliminarreglamento($id_web_reglamento);
		unlink("../public/web_reglamentos/".$pdf_reglamento);  
		echo json_encode($eliminar_reglamento);
	break;


	case 'desactivar_reglamento':
		$rspta=$web_reglamento->desactivar_reglamento($id_web_reglamento);
		echo json_encode($rspta);
 		//echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;
	

	case 'activar_reglamento':
		$rspta=$web_reglamento->activar_reglamento($id_web_reglamento);
		echo json_encode($rspta);
	break;





	

}
