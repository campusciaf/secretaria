<?php
require_once "../modelos/ClavesGestion.php";
session_start();

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:s');

$clavesgestion = new ClavesGestion();

$id_oculto_salon=isset($_POST["id_oculto_salon"])? limpiarCadena($_POST["id_oculto_salon"]):"";

$id_clave=isset($_POST["id_clave"])? limpiarCadena($_POST["id_clave"]):"";
$clave_plataforma_m=isset($_POST["clave_plataforma_m"])? limpiarCadena($_POST["clave_plataforma_m"]):"";
$clave_url_m=isset($_POST["clave_url_m"])? limpiarCadena($_POST["clave_url_m"]):"";
$clave_usuario_m=isset($_POST["clave_usuario_m"])? limpiarCadena($_POST["clave_usuario_m"]):"";
$clave_contrasena_m=isset($_POST["clave_contrasena_m"])? limpiarCadena($_POST["clave_contrasena_m"]):"";
$clave_descripcion_m=isset($_POST["clave_descripcion_m"])? limpiarCadena($_POST["clave_descripcion_m"]):"";


$id_usuario=$_SESSION['id_usuario'];

switch ($_GET['op']) {
		
    case 'listarClaves':
		 $rspta = $clavesgestion->listarClaves();
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){

            $datoarea = $clavesgestion->datosCargo($rspta[$i]['id_usuario']);
			

            $button = ($rspta[$i]['clave_estado'] == "0")? '<button onclick=estado("'.$rspta[$i]['id_clave'].'",1) class="btn btn-success btn-xs"><i class="fas fa-lock-open"></i></button>':'<button onclick=estado("'.$rspta[$i]['id_clave'].'",0) class="btn btn-danger btn-xs"><i class="fas fa-lock"></i></button>';
            $e = ($rspta[$i]['clave_estado'] == "1")? '<span class="label label-success">Activo</span>':'<span  class="label label-danger">Desactivado</span>';

 			$data[]=array(
 				"0"=>'
                <button class="tooltip-agregar btn btn-warning btn-xs" onclick="mostrarplataforma(`'.$rspta[$i]['id_clave'].'`)" title="Editar Plataforma" data-toggle="tooltip" data-placement="top">
                    <i class="fas fa-pencil-alt"></i>
                 </button>
                 <button onclick=eliminarPlataforma("'.$rspta[$i]['id_clave'].'") class="btn btn-danger btn-xs" title="Eliminar registro"><i class="far fa-trash-alt"></i></button> '.$button,
                 
 				"1"=>$rspta[$i]['clave_plataforma'],
 				"2"=>$rspta[$i]['clave_url'],
 				"3"=>$rspta[$i]['clave_usuario'],
 				"4"=>$rspta[$i]['clave_contrasena'],
 				"5"=>$rspta[$i]['clave_descripcion'],
 				"6"=>$e,
                "7"=>$datoarea["usuario_cargo"],
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

    case 'agregar':
        $data['conte'] = '';
        $data['id'] = '';
        
        $clave_plataforma = $_POST['clave_plataforma'];
        $clave_url = $_POST['clave_url'];
        $clave_usuario = $_POST['clave_usuario'];
        $clave_contrasena = $_POST['clave_contrasena'];
        $clave_descripcion = $_POST['clave_descripcion'];
        $clave_estado=1;

        $rspta=$clavesgestion->agregar($clave_plataforma, $clave_url, $clave_usuario, $clave_contrasena, $clave_descripcion, $clave_estado, $fecha, $hora, $id_usuario);

        $data['conte'] .= $rspta ? "1" : "0";
        $data['id'] .= $id_usuario;

        echo json_encode($data);

    break;

    case 'eliminar':
        $data['conte'] = '';
        $data['id'] = '';
            $id = $_POST['id'];
            $rspta=$clavesgestion->eliminar($id);
        $data['conte'] .= $rspta ? "1" : "0";
        $data['id'] .= $id_usuario;
        echo json_encode($data);
    break;

    case 'estado':
        $data['conte'] = '';
        $data['id'] = '';

        $id = $_POST['id'];
        $est = $_POST['est'];

        $rspta=$clavesgestion->estado($id,$est,$fecha,$hora);

        $data['conte'] .= $rspta ? "1" : "0";
        $data['id'] .= $id_usuario;

        echo json_encode($data);

    break;
        
	case 'mostrarplataforma':
		$rspta = $clavesgestion->mostrarplataforma($id_clave);
		echo json_encode($rspta);
	break;

    case 'guardaryeditardocente':

		$rspta = $cajaherramientasboton->editardocente($id_usuario, $permiso_software);
		echo $rspta ? "Permiso actualizado" : "Permiso no se pudo actualizar";
		
	break;

    case 'guardaryeditarplataforma':

        $data['conte'] = '';
        $data['id'] = '';

		$rspta = $clavesgestion->editarplataforma($id_clave,$clave_plataforma_m, $clave_url_m, $clave_usuario_m, $clave_contrasena_m, $clave_descripcion_m, $fecha, $hora, $id_usuario);
        
        $data['conte'] .= $rspta ? "1" : "0";
        $data['id'] .= $id_usuario;

        echo json_encode($data);

	break;
}
?>