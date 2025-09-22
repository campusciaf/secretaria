<?php 
session_start(); 
require_once "../modelos/AdminCalendario.php";

$admin_calendario = new AdminCalendario();

$accion = (isset($_GET['accion']))?$_GET['accion']:'leer';
switch ($accion) {
	case 'agregar':
	// Recibir datos del POST
		$actividad = $_POST['title'];
		$fecha_inicio = $_POST['start'];
		$fecha_final = $_POST['end'];
		$color = $_POST['color'];

		$respuesta=$admin_calendario->insertarEventos($actividad,$fecha_inicio,$fecha_final,$color);
		echo json_encode($respuesta);
	// Insertar datos de evento en la tabla calendario
		
		break;
	case 'eliminar':
	// Recibir id del POST
		$id = $_POST['id'];
		$respuesta = false;
		// Condicional para validar que haya id
		if (isset($id)) {
			// Eliminar evento en la tabla calendario
			$respuesta = $admin_calendario->eliminarEventos($id);
			echo json_encode($respuesta);		
		}
		break;
	case 'modificar':
	// Recibir id del POST
		$id = $_POST['id'];
		$actividad = $_POST['title'];
		$fecha_inicio = $_POST['start'];
		$fecha_final = $_POST['end'];
		$color = $_POST['color'];
		$respuesta = false;
		// Condicional para validar que haya id
		if (isset($id)) {
			// Modificar evento en la tabla calendario
			$respuesta = $admin_calendario->modificarEventos($id,$actividad,$fecha_inicio,$fecha_final,$color);
			echo json_encode($respuesta);
		}
		break;
	default:
		$consulta=$admin_calendario->mostrarEventos();
 		//Codificar el resultado utilizando json
 		echo json_encode($consulta);
		break;
}


 ?>