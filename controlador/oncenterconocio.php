<?php 
require_once "../modelos/OncenterConocio.php";

$oncenterconocio=new OncenterConocio();

$id_conocio=isset($_POST["id_conocio"])? limpiarCadena($_POST["id_conocio"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$opcion=isset($_POST["opcion"])? limpiarCadena($_POST["opcion"]):"";


switch ($_GET["op"]){
		
	case 'guardaryeditar':
		$data= Array();
		$data["estado"] ="";

		if (empty($id_conocio)){
			$rspta=$oncenterconocio->insertar($nombre,$opcion);
			$datos=$rspta ? "1" : "2";	
		}
		else {
			$rspta=$oncenterconocio->editar($id_conocio,$nombre,$opcion);
			$datos=$rspta ? "3" : "4";	
		}
		$data["estado"] = $datos;
        echo json_encode($data);
	break;	
		
	
	case 'listar':
		$rspta=$oncenterconocio->listar();
 		//Vamos a declarar un array
 		$data= Array();

			$i = 0;			
			while ($i < count($rspta)){
				$est = ($rspta[$i]["estado"])?'1':'0';
				$data[]=array(
				"0"=>($rspta[$i]["estado"])?'
				<button id="t-El" class="btn btn-danger btn-xs" onclick="eliminar('.$rspta[$i]["id_conocio"].')" title="Eliminar"><i class="far fa-trash-alt"></i> </button>
				<button id="t-edit" class="btn btn-primary btn-xs" onclick="mostrar('.$rspta[$i]["id_conocio"].')" title="Editar"><i class="fas fa-pencil-alt"></i> </button>'.
					
 					' <button id="t-desc" class="btn btn-success btn-xs" onclick="desactivar('.$rspta[$i]["id_conocio"].')" title="Desactivar"><i class="fas fa-lock-open"></i> </button>':
					
					'<button class="btn btn-danger btn-xs" onclick="eliminar('.$rspta[$i]["id_conocio"].')" title="Eliminar"><i class="far fa-trash-alt"></i> </button>'.
					
					'<button class="btn btn-primary btn-xs" onclick="mostrar('.$rspta[$i]["id_conocio"].')" title="editar"><i class="fas fa-pencil-alt"></i> </button>'.
					
 					'<button class="btn btn-secondary btn-xs" onclick="activar('.$rspta[$i]["id_conocio"].')" title="Activar"><i class="fas fa-lock"></i> </button>',
					
 				"1"=>$rspta[$i]["nombre"],
				"2"=>$rspta[$i]["opcion"],
				"3"=>($rspta[$i]["estado"])?'si':'No',
				
					
 				);
				$i++;
			}
		
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
		
	case 'mostrar':
	
		$rspta=$oncenterconocio->mostrar($id_conocio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

	break;	
		

		
	case 'desactivar':
		
		$rspta=$oncenterconocio->desactivar($id_conocio);
		
		if($rspta==0){
			echo "1";
		}else{
			
			echo "0";
		}
 		
	break;

	case 'activar':
		$rspta=$oncenterconocio->activar($id_conocio);
	
		if($rspta==0){
			echo "1";
		}else{
			echo "0";
		}

	break;
		
	case 'eliminar':
		$rspta=$oncenterconocio->eliminar($id_conocio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;	
	case "selectOpcion":	
		$rspta = $oncenterconocio->selectOpcion();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["opcion"] . "'>" . $rspta[$i]["opcion"] . "</option>";
				}
	break;
	
		
}
?>