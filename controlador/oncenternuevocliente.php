<?php 
session_start();
require_once "../modelos/OncenterNuevoCliente.php";
date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:s');


$oncenternuevocliente=new OncenterNuevoCliente();


$usuario_cargo=$_SESSION['usuario_cargo'];
$id_usuario=$_SESSION['id_usuario'];

/* variables para editar perfil*/

$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$identificacion=isset($_POST["identificacion"])? limpiarCadena($_POST["identificacion"]):"";
$fo_programa=isset($_POST["fo_programa"])? limpiarCadena($_POST["fo_programa"]):"";
$jornada_e=isset($_POST["jornada_e"])? limpiarCadena($_POST["jornada_e"]):"";

$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$nombre_2=isset($_POST["nombre_2"])? limpiarCadena($_POST["nombre_2"]):"";
$apellidos=isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
$apellidos_2=isset($_POST["apellidos_2"])? limpiarCadena($_POST["apellidos_2"]):"";
$celular=isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$ref_familiar=isset($_POST["ref_familiar"])? limpiarCadena($_POST["ref_familiar"]):"";
$ref_telefono=isset($_POST["ref_telefono"])? limpiarCadena($_POST["ref_telefono"]):"";
$medio=isset($_POST["medio"])? limpiarCadena($_POST["medio"]):"";
$conocio=isset($_POST["conocio"])? limpiarCadena($_POST["conocio"]):"";
$contacto=isset($_POST["contacto"])? limpiarCadena($_POST["contacto"]):"";
/* ********************* */



switch ($_GET["op"]){
	
	case 'guardaryeditar':
		$clave=md5($identificacion);
		$estado="Interesado";
		
		$buscar_periodo=$oncenternuevocliente->periodoactual();
		$periodo_ingreso=$buscar_periodo["periodo_actual"];
		$periodo_campana=$buscar_periodo["periodo_campana"];
		
		$rspta=$oncenternuevocliente->insertarCliente($tipo_documento,$identificacion,$fo_programa,$jornada_e,$nombre,$nombre_2,$apellidos,$apellidos_2,$celular,$email,$clave,$periodo_ingreso,$fecha,$hora,$medio,$conocio,$contacto,$estado,$periodo_campana,$ref_familiar,$ref_telefono,$id_usuario);
			echo $rspta ? "Cliente Registrado" : "Cliente no se pudo registrar";
	break;	
		

	case "selectPrograma":
		echo "<option value=''>Seleccionar</option>";
		$rspta = $oncenternuevocliente->selectPrograma();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
	case "selectJornada":	
		$rspta = $oncenternuevocliente->selectJornada();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
	case "selectTipoDocumento":	
		$rspta = $oncenternuevocliente->selectTipoDocumento();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
		
	case "selectMedio":	
		$rspta = $oncenternuevocliente->selectMedio();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
		
	case "selectConocio":	
		$rspta = $oncenternuevocliente->selectConocio();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
		
	case "selectContacto":	
		$rspta = $oncenternuevocliente->selectContacto();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;		
		
	
		

		

		
}


	



?>
