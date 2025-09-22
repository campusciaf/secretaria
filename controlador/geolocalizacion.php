<?php 
require_once "../modelos/Geolocalizacion.php";

$geolocalizacion=new Geolocalizacion();

$programa=isset($_POST["programa"])? limpiarCadena($_POST["programa"]):"";
$jornada=isset($_POST["jornada"])? limpiarCadena($_POST["jornada"]):"";
$semestre=isset($_POST["semestre"])? limpiarCadena($_POST["semestre"]):"";


switch ($_GET["op"]){
		
	case 'listar':
		$data= Array();
		// consulta para listar solo cuando seleccionar todo
		if($programa=="todas" and $jornada=="todas" and $semestre=="todas"){
			$rspta=$geolocalizacion->listar();
		}
		if($programa != "todas" and $jornada=="todas" and $semestre=="todas"){
			$rspta=$geolocalizacion->listarPrograma($programa);
		}
		if($programa=="todas" and $jornada!="todas" and $semestre=="todas"){
			$rspta=$geolocalizacion->listarJornada($jornada);
		}
		if($programa=="todas" and $jornada=="todas" and $semestre!="todas"){
			$rspta=$geolocalizacion->listarSemestre($semestre);
		}
		if($programa!="todas" and $jornada!="todas" and $semestre=="todas"){
			$rspta=$geolocalizacion->listarProgramaJornada($programa,$jornada);
		}
		if($programa != "todas" and $jornada != "todas" and $semestre != "todas"){
			$rspta=$geolocalizacion->listarProgramaJornadaSemestre($programa,$jornada,$semestre);
		}
		
		if($programa!="todas" and $jornada=="todas" and $semestre!="todas"){
			$rspta=$geolocalizacion->listarProgramaSemestre($programa,$semestre);
		}
			
			$reg=$rspta;
			for ($i=0;$i<count($reg);$i++){
				
				$rspta2=$geolocalizacion->listarDatos($reg[$i]["id_credencial"]);
				$data [] = array(
					'0' => $rspta2["latitud"],
					'1' => $rspta2["longitud"],
					'2' => $rspta2["id_credencial"]. "-" . $rspta2["municipio"]. " - " . $rspta2["credencial_nombre"] . " " . $rspta2["credencial_nombre_2"] . " " . $rspta2["credencial_apellido"] . " " . $rspta2["credencial_apellido_2"] . " - " . $rspta2["celular"] . " " . $rspta2["email"],
					'3' => count($reg),
				); 
			}
		
		$results = array($data);
 		echo json_encode($data) ;
	break;
	
		
		
		case "selectPrograma":	
		$rspta = $geolocalizacion->selectPrograma();
		echo "<option value=''>Seleccionar Programa</option>";
		echo "<option value='todas'>Todos los Programas</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
	
	case "selectJornada":	
		$rspta = $geolocalizacion->selectJornada();
		echo "<option value=''>Seleccionar Jornada</option>";
		echo "<option value='todas'>Todas los Jornadas</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
	
//	case "selectPeriodo":	
//		$rspta = $geolocalizacion->selectPeriodo();
//		echo "<option value=''>Seleccionar</option>";
//		echo "<option value='todas'>Todas los Periodos</option>";
//		for ($i=0;$i<count($rspta);$i++)
//				{
//					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
//				}
//	break;	
		
}
?>