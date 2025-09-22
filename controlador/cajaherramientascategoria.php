<?php 
require_once "../modelos/CajaHerramientasCategoria.php";

$meses = array( "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre","Noviembre","Diciembre");

$cajaherramientascategoria = new CajaHerramientasCategoria();


$nombre_categoria=isset($_POST["nombre_categoria"])? limpiarCadena($_POST["nombre_categoria"]):"";
$id_software_categoria=isset($_POST["id_software_categoria"])? limpiarCadena($_POST["id_software_categoria"]):"";

switch ($_GET["op"]){
	//listamos las categorias
	case 'listarcategorias':
		
		$rspta	= $cajaherramientascategoria->mostrarcategoria();
		//Vamos a declarar un array
		$data = array();
		$categoria = $rspta;
		
		for ($i = 0; $i < count($categoria); $i ++){

			$nombre_categoria =  $categoria[$i]["nombre_categoria"];

			$data[]=array(

				"0"=>'
				<div>
					
					<button class="tooltip-agregar btn btn-warning btn-xs" onclick="mostrar_categoria('.$categoria[$i]["id_software_categoria"]. ')" title="Editar Proyecto" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
			
					<button class="tooltip-agregar btn btn-danger btn-xs" onclick="eliminar_categoria('.$categoria[$i]["id_software_categoria"]. ')" title="Eliminar Proyecto" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
				</div>',
				
				"1"=>$nombre_categoria,
				
				
			
			);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);

	break;

	//se muestra la categoria para usarla en el boton de editar
	case 'mostrar_categoria':
		$rspta = $cajaherramientascategoria->mostrar_categoria($id_software_categoria);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;
	
	//se guarda y edita la categoria 
	case 'guardaryeditarcategoria':
		if (empty($id_software_categoria)){
			$rspta = $cajaherramientascategoria->insertarCategoria($nombre_categoria, $id_software_categoria);
			echo $rspta ? "Categoría registrado" : "Categoría no se pudo registrar";
		}else{
			$rspta = $cajaherramientascategoria->editarCategoria($id_software_categoria, $nombre_categoria);
			echo $rspta ? "Categoría actualiada" : "Categoría no se pudo actualizar";
		}
	break;

	//eliminar una categoria
	case 'eliminar_categoria':
		$rspta = $cajaherramientascategoria->eliminarcategoria($id_software_categoria);
		echo json_encode($rspta);
	break;
	

}
