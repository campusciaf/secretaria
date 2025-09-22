<?php 
require_once "../modelos/CajaHerramientasBoton.php";

$meses = array( "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre","Noviembre","Diciembre");

$cajaherramientasboton = new CajaHerramientasBoton();

$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$permiso_software=isset($_POST["permiso_software"])? limpiarCadena($_POST["permiso_software"]):"";

switch ($_GET["op"]){

	case 'listardocente':
		
		$id_usuario = $_GET["id_usuario"];

		$rspta	= $cajaherramientasboton->mostrartotaldocentes();
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;
		
		for ($i = 0; $i < count($reg); $i ++){

			$usuario_nombre =  $reg[$i]["usuario_nombre"]." ".$reg[$i]["usuario_nombre_2"]." ".$reg[$i]["usuario_apellido"]." ".$reg[$i]["usuario_apellido_2"];

			$permiso_software = $reg[$i]["permiso_software"];

			$permiso_software = ($permiso_software == 1) ?'<span class="badge badge-danger p-1">Sin Permiso</span>' :'<span class="badge badge-success p-1">Con permiso</span>';

			$data[]=array(

				"0"=>'
				<div>
					
					<button class="tooltip-agregar btn btn-warning btn-xs" onclick="mostrar_docente('.$reg[$i]["id_usuario"]. ')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button>
				</div>',
				
				"1"=>$usuario_nombre,
				"2"=>$permiso_software,
				
				
			
			);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);

	break;

	case 'mostrar_docentes':
		$rspta = $cajaherramientasboton->mostrar_docente($id_usuario);
		echo json_encode($rspta);
	break;

	//guardar y editar un docente
	case 'guardaryeditardocente':

		$rspta = $cajaherramientasboton->editardocente($id_usuario, $permiso_software);
		echo $rspta ? "Permiso actualizado" : "Permiso no se pudo actualizar";
		
	break;

}
