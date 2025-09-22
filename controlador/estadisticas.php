<?php 
require_once "../modelos/Estadistica.php";
date_default_timezone_set("America/Bogota");
session_start();
$consulta = new Estadistica();
$id_categoria = isset($_POST["id_categoria"])? limpiarCadena($_POST["id_categoria"]):"";
$id_usuario = $_SESSION['id_usuario'];
$id_caracterizacion = isset($_POST["id_caracterizacion"])? limpiarCadena($_POST["id_caracterizacion"]):"";
$respuesta = isset($_POST["respuesta"])? limpiarCadena($_POST["respuesta"]):"";
$id_variable = isset($_POST["id_variable"])? limpiarCadena($_POST["id_variable"]):"";
$fecha_respuesta = date('Y-m-d');
$hora_respuesta = date('h:i:sa');
switch ($_GET["op"]){
    case 'listarCategorias':
		$rspta = $consulta->listarCategoria();
		echo json_encode($rspta);
	break;
    case 'listarPeriodos':
		$rspta = $consulta->listarPeriodos();
		echo json_encode($rspta);
	break;
   	case 'listarEstudiantes':
		$id_categoria = $_GET["id_categoria"];// metodo get que captura el id_categoria
		$periodo = $_GET["periodo"];// metodo get que captura el periodo
		$listado = $consulta->listarEstudiantes($id_categoria, $periodo);// consulta para traer los estudiantes
		//Vamos a declarar un array
		$data = array();
		//creamos un array con el rango 
		$rangos = array("16-20","21-25", "26-30" , "31-35", "36-40", "41-45", "46-50", "51-55");
		//llenamos el array con el cero para poder realizar la suma
		for ($i = 0; $i < 8; $i++) { $cantidad[$i] = 0; }
		for ($i = 0; $i < count($listado); $i++){
			$id_credencial = $listado[$i]["id_usuario"];// variable que contiene la credencial
			$listadoDatos = $consulta->listarEstudiantesDatos($id_credencial); // consulta para traer los datos de los estudiantes
			$edad = $consulta->calculaEdad($listadoDatos["fecha_nacimiento"]);
			switch ($edad) {
				case $edad >= 16 && $edad <= 20:
					$cantidad[0]++;
				break;
				case $edad >= 21 && $edad <= 25:
					$cantidad[1]++;
				break;
				case $edad >= 26 && $edad <= 30:
					$cantidad[2]++;
				break;
				case $edad >= 31 && $edad <= 35:
					$cantidad[3]++;
				break;
				case $edad >= 36 && $edad <= 40:
					$cantidad[4]++;
				break;
				case $edad >= 41 && $edad <= 45:
					$cantidad[5]++;
				break;
				case $edad >= 46 && $edad <= 50:
					$cantidad[6]++;
				break;
				case $edad >= 51 && $edad <= 55:
					$cantidad[7]++;
				break;
			}
		}
		for ($i=0; $i < 8; $i++) { 
			$data[] = array(
				"0"=>$rangos[$i],
				"1"=>$cantidad[$i]
			);
		}
		$data[] = array( "0" => "<b> TOTAL </b>", "1" => array_sum($cantidad));
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;		
}
?>