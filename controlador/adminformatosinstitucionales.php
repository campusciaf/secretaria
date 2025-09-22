<?php
session_start(); 
require_once "../modelos/AdminFormatosInstitucionales.php";

date_default_timezone_set("America/Bogota");
$fecha=date('Y-m-d');
$hora=date('H:i:s');

$adminformatosinstitucionales=new AdminFormatosInstitucionales();

$id_formato=isset($_POST["id_formato"])? limpiarCadena($_POST["id_formato"]):"";
$formato_nombre=isset($_POST["formato_nombre"])? limpiarCadena($_POST["formato_nombre"]):"";
$formato_archivo=isset($_POST["formato_archivo"])? limpiarCadena($_POST["formato_archivo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['formato_archivo']['tmp_name']) || !is_uploaded_file($_FILES['formato_archivo']['tmp_name']))
		{
			$archivo=$_POST["archivoactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["formato_archivo"]["name"]);
			
				$archivo = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["formato_archivo"]["tmp_name"], "../files/formatos/" . $archivo);
			
		}

		if (empty($id_formato)){
			$rspta=$adminformatosinstitucionales->insertar($formato_nombre,$archivo,$fecha,$hora);
			
			echo $rspta ? "Formato registrado " : "No se pudieron registrar Lso formatos";
				
		}
		else {
			$rspta=$adminformatosinstitucionales->editar($id_formato,$formato_nombre,$archivo);
			
			echo $rspta ? "Formato actualizado" : "Formato no se pudo actualizar";
			
		}
	break;



	case 'mostrar':
	
			$rspta=$adminformatosinstitucionales->mostrar($id_formato);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

	break;

	case 'listar':
		$rspta=$adminformatosinstitucionales->listar();
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
 			$data[]=array(
 				"0"=>'<button class="btn btn-danger btn-xs" onclick=eliminarFormato('.$reg[$i]["id_formato"].',"'.$reg[$i]["formato_archivo"].'") title="Editar"><i class="fas fa-trash-alt"></i></button>
				
				<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg[$i]["id_formato"].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>',
				
 				"1"=>$reg[$i]["formato_nombre"],
 				"2"=>'<a href="../files/formatos/'.$reg[$i]["formato_archivo"].'" target="_blank"><i class="fas fa-file-download"></i> Descargar Formato</a>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
		
			
	case 'eliminarFormato':
		
		$rspta=$adminformatosinstitucionales->eliminarFormato($_POST["id_formato"]);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
		unlink("../files/formatos/" . $_POST["formato_archivo"]);
		
	break;


		
}
?>




