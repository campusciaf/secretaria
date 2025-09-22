<?php 
session_start();
require_once "../modelos/Plantilla.php";

$plantilla=new Plantilla();

$periodo_actual=$_SESSION['periodo_actual'];
$id_credencial=$_SESSION['id_usuario'];

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d-H:i:s');


switch ($_GET["op"]){

	case 'listar':


	break;
}
?>