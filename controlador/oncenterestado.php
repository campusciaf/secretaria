<?php 
require_once "../modelos/OncenterEstado.php";

$oncenterestado=new OncenterEstado();

$id_estado=isset($_POST["id_estado"])? limpiarCadena($_POST["id_estado"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";



switch ($_GET["op"]){
		
	case 'guardaryeditar':
		$data= Array();
		$data["estado"] ="";

		if (empty($id_estado)){
			$rspta=$oncenterestado->insertar($nombre);
			$datos=$rspta ? "1" : "2";	
		}
		else {
			$rspta=$oncenterestado->editar($id_estado,$nombre);
			$datos=$rspta ? "3" : "4";	
		}

		$data["estado"] = $datos;
        echo json_encode($data);

	break;	
		
	
	case 'listar':
		$rspta=$oncenterestado->listar();
 		//Vamos a declarar un array
 		$data= Array();

			$i = 0;			
			while ($i < count($rspta)){
				$est = ($rspta[$i]["estado"])?'1':'0';
				$data[]=array(
				"0"=>($rspta[$i]["estado"])?'
				<button id="t-El" class="btn btn-danger btn-xs" onclick="eliminar('.$rspta[$i]["id_estado"].')" title="Eliminar"><i class="far fa-trash-alt"></i> </button>
				<button id="t-ed" class="btn btn-primary btn-xs" onclick="mostrar('.$rspta[$i]["id_estado"].')" title="Editar"><i class="fas fa-pencil-alt"></i> </button>'.
					
 					' <button id="t-desc" class="btn btn-success btn-xs" onclick="desactivar('.$rspta[$i]["id_estado"].')" title="Desactivar"><i class="fas fa-lock-open"></i> </button>':
					
					'<button class="btn btn-danger btn-xs" onclick="eliminar('.$rspta[$i]["id_estado"].')" title="Eliminar"><i class="far fa-trash-alt"></i> </button>'.
					
					'<button class="btn btn-primary btn-xs" onclick="mostrar('.$rspta[$i]["id_estado"].')" title="editar"><i class="fas fa-pencil-alt"></i> </button>'.
					
 					'<button class="btn btn-secondary btn-xs" onclick="activar('.$rspta[$i]["id_estado"].')" title="Activar"><i class="fas fa-lock"></i> </button>',
					
 				"1"=>$rspta[$i]["nombre_estado"],
				"2"=>($rspta[$i]["estado"])?'si':'No',
				
					
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
	
		$rspta=$oncenterestado->mostrar($id_estado);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

	break;	
		

		
	case 'desactivar':
		
		$rspta=$oncenterestado->desactivar($id_estado);
		
		if($rspta==0){
			echo "1";
		}else{
			
			echo "0";
		}
 		
	break;

	case 'activar':
		$rspta=$oncenterestado->activar($id_estado);
	
		if($rspta==0){
			echo "1";
		}else{
			echo "0";
		}

	break;
		
	case 'eliminar':
		$rspta=$oncenterestado->eliminar($id_estado);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;	

	
		
}
?>