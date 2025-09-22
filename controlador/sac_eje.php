<?php 
require_once "../modelos/Sac_Eje.php";

$eje=new SacEje();

$id_eje=isset($_POST["id_eje"])? limpiarCadena($_POST["id_eje"]):"";
$nombre_eje=isset($_POST["nombre_eje"])? limpiarCadena($_POST["nombre_eje"]):"";	
$total_meta  = isset($_POST["total_meta"])? limpiarCadena($_POST["total_meta"]):"";
$id_meta  = isset($_POST["id_meta"])? limpiarCadena($_POST["id_meta"]):"";
$total_acciones  = isset($_POST["total_acciones"])? limpiarCadena($_POST["total_acciones"]):"";
$id_meta  = isset($_POST["id_meta"])? limpiarCadena($_POST["id_meta"]):"";
$meta_nombre  = isset($_POST["meta_nombre"])? limpiarCadena($_POST["meta_nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_eje)){
			$rspta=$eje->sac_insertar($nombre_eje);			
			echo $rspta ? "ejes registrada" : "ejes no se pudo registrar";
		}
		else {
			$rspta=$eje->editar($id_eje, $nombre_eje);
			echo $rspta ? "ejes actualizada" : "ejes no se pudo actualizar";
		}
	break;
	case 'mostrar':
		$rspta=$eje->mostrar($id_eje);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$eje->listar();
		//Vamos a declarar un array
		$data= array();
		$reg=$rspta;
		
		for ($i=0;$i<count($reg);$i++){
			
			$total_meta = $eje->contarmetaeje($reg[$i]["id_ejes"]);

			
			$total_acciones = 0;
			for ($j=0; $j < count($total_meta) ; $j++) { 
				// print_r($total_meta);
				$rsptaccion = $eje->contaraccion($total_meta[$j]["id_meta"]);
				$total_acciones += $rsptaccion["total_accion"];
				
			}

			
			$data[]=array(
				"0"=>'<button class="btn btn-warning btn-sm btn-flat" onclick="mostrar('.$reg[$i]["id_ejes"].')" title="Editar"><i class="fas fa-pencil-alt"></i></button><a href="sac_proyecto.php?op=ver&id_ejes='.$reg[$i]["id_ejes"].'" class="btn btn-primary btn-sm btn-flat" title="ver proyecto"><i class="fas fa-eye"></i></a><button class="btn btn-danger btn-sm btn-flat" onclick="eliminar('.$reg[$i]["id_ejes"].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>',
				"1"=>$reg[$i]["nombre_ejes"],
				
				"2"=> 
					

				'<span class="badge pb-0"> 
				<button type="button" class="btn btn-outline-dark float-right btn-sm btn-flat tooltip-agregar " onclick="nombre_ejes('.$reg[$i]["id_ejes"].')" title="Ver Eje Meta">'.count($total_meta).' </button>				
				</span>',

				"3"=> '<span class="badge pb-0"> 
				<button type="button" class="btn btn-outline-dark float-right btn-sm btn-flat tooltip-agregar " onclick="nombre_accion_ejes('.$reg[$i]["id_ejes"].')" title="Ver Eje Meta">'.($total_acciones).' </button>				
				</span>
				
				'
				
				// '<span class="badge bg-secondary pb-1">'.($total_acciones).'</span>'
			);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);

	break;

	case 'eliminar':
		$rspta=$eje->eliminar($id_eje);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;

	//listar las dependencias
	case 'nombre_ejes':
		$nombre_meta = $eje->listarMetaEje($id_eje);
		$data[0] = "";
		for ($a = 0; $a < count($nombre_meta) ; $a++) { 
			$meta = $nombre_meta[$a]["meta_nombre"];
			$data[0] .='
			<div class="alert alert-success alert-dismissible">
			<h6> <i class="icon fa fa-check"> </i>'.$meta.'</h6>
			</div>';
		}	
		echo json_encode($data);
	break;

	case 'nombre_accion_ejes':

		$nombre_accion = $eje->listarAccionEje($id_eje);

		$data[0] = "";
		$meta_nombre = ''; 
		for ($r = 0; $r < count($nombre_accion) ; $r++) {
			
			$accion = $nombre_accion[$r]["nombre_accion"];
			
			$nombre_meta_actual = $nombre_accion[$r]["meta_nombre"];
			
			$nombre_meta_anterior = isset($nombre_accion[($r - 1)]["meta_nombre"])?$nombre_accion[($r - 1)]["meta_nombre"]:"";
			$nombre_accion_anterior = isset($nombre_accion[($r - 1)]["nombre_accion"])?$nombre_accion[($r - 1)]["nombre_accion"]:"";

			if($nombre_meta_anterior != $nombre_meta_actual){
				
				$data[0].='<hr><strong> Meta:</strong><strong class="text-secondary"><br>'.$nombre_meta_actual.'</strong>
				<br> 
				';
			
				$data[0].='<br><label>Acciones: </label>';

			};
			if($nombre_accion_anterior != $accion){
				$data[0].='
				
				<strong class="text-secondary"><br>'.($r + 1). '</span>: </b>'.$accion.'</strong>
				<br> ';
			
			};
			
		}	
		echo json_encode($data);
	break;

	// //listar las dependencias
	// case 'nombre_accion_ejes':
	// 	$nombre_accion = $eje->listarAccionEje($id_eje);
	// 	$data[0] = "";
	// 	for ($e = 0; $e < count($nombre_accion) ; $e++) { 
	// 		$accion = $nombre_accion[$e]["meta_nombre"];
	// 		$data[0] .='
	// 		<div class="alert alert-success alert-dismissible">
	// 		<h6>'.$e.' <i class="icon fa fa-check"> </i>'.$accion.'</h6>
	// 		</div>';
	// 	}	
	// 	echo json_encode($data);
	// break;
}
?>