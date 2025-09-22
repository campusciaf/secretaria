<?php 
require_once "../modelos/GeolocalizacionZona.php";

$geolocalizacionzona=new GeolocalizacionZona();

$departamento=isset($_POST["departamento"])? limpiarCadena($_POST["departamento"]):"";
$municipio=isset($_POST["municipio"])? limpiarCadena($_POST["municipio"]):"";
$cod_postal=isset($_POST["cod_postal"])? limpiarCadena($_POST["cod_postal"]):"";
$programa=isset($_POST["programa"])? limpiarCadena($_POST["programa"]):"";
$jornada=isset($_POST["jornada"])? limpiarCadena($_POST["jornada"]):"";
$semestre=isset($_POST["semestre"])? limpiarCadena($_POST["semestre"]):"";


switch ($_GET["op"]){
		
	case 'listar':
		$data= Array();
		// consulta para listar solo cuando seleccionar todo
		if($programa=="todas" and $jornada=="todas" and $semestre=="todas"){
			$rspta=$geolocalizacionzona->listar($cod_postal);
		}
		if($programa != "todas" and $jornada=="todas" and $semestre=="todas"){
			$rspta=$geolocalizacionzona->listarPrograma($programa,$cod_postal);
		}
		if($programa=="todas" and $jornada!="todas" and $semestre=="todas"){
			$rspta=$geolocalizacionzona->listarJornada($jornada,$cod_postal);
		}
		if($programa=="todas" and $jornada=="todas" and $semestre!="todas"){
			$rspta=$geolocalizacionzona->listarSemestre($semestre,$cod_postal);
		}
		if($programa!="todas" and $jornada!="todas" and $semestre=="todas"){
			$rspta=$geolocalizacionzona->listarProgramaJornada($programa,$jornada,$cod_postal);
		}
		if($programa!="todas" and $jornada!="todas" and $semestre!="todas"){
			$rspta=$geolocalizacionzona->listarProgramaJornadaSemestre($programa,$jornada,$semestre,$cod_postal);
		}
		if($programa!="todas" and $jornada=="todas" and $semestre!="todas"){
			$rspta=$geolocalizacionzona->listarProgramaSemestre($programa,$semestre,$cod_postal);
		}
			
			$reg=$rspta;
			for ($i=0;$i<count($reg);$i++){
				
				$rspta2=$geolocalizacionzona->listarDatos($reg[$i]["id_credencial"]);
				$data [] = array(
					'0' => $rspta2["latitud"],
					'1' => $rspta2["longitud"],
					'2' => $rspta2["id_credencial"]. "-" . $rspta2["municipio"]. " - " . $rspta2["credencial_nombre"] . " " . $rspta2["credencial_nombre_2"] . " " . $rspta2["credencial_apellido"] . " " . $rspta2["credencial_apellido_2"] . " - " . $rspta2["celular"] . " " . $rspta2["email"],
					'3' => count($reg),
					'4' => $programa,
					'5' => $jornada,
					'6' => $semestre,
					'7' => $cod_postal,
					
				); 
			}
	
		
		
		$results = array($data);
 		echo json_encode($data) ;
		
		
	break;
	
		
		
		case "selectPrograma":	
		$rspta = $geolocalizacionzona->selectPrograma();
		echo "<option value=''>Seleccionar Programa</option>";
		echo "<option value='todas'>Todos los Programas</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
	
	case "selectJornada":	
		$rspta = $geolocalizacionzona->selectJornada();
		echo "<option value=''>Seleccionar Jornada</option>";
		echo "<option value='todas'>Todas los Jornadas</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
		
	case "selectDepartamento":	
		$rspta = $geolocalizacionzona->selectDepartamento();
		echo "<option value=''>Seleccionar Departamento</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
				}
	break;
		
	case "selectMunicipio":
		$id_departamento=$_POST["id_departamento"];
		$rspta = $geolocalizacionzona->selectMunicipio($id_departamento);
		echo "<option value=''>Seleccionar Municipio</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
				}
	break;		
	case "selectPostal":
		$id_municipio=$_POST["id_municipio"];
		$rspta = $geolocalizacionzona->selectCodPostal($id_municipio);
		echo "<option value=''>Seleccionar Código</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["codigo"] . "'>" . $rspta[$i]["codigo"] . ' - ' . $rspta[$i]["tipo"] . ' - ' . $rspta[$i]["limite_sur"] . ' -hasta- ' . $rspta[$i]["limite_este"] ."</option>";
				}
	break;	
		
		
	case 'listarTabla':
		$programa=$_GET["programa"];
		$jornada=$_GET["jornada"];
		$semestre=$_GET["semestre"];
		$cod_postal=$_GET["cod_postal"];
		
		$data= Array();
		// consulta para listar solo cuando seleccionar todo
		
		if($programa=="todas" and $jornada=="todas" and $semestre=="todas"){
			$rspta=$geolocalizacionzona->listar($cod_postal);
		}	
		if($programa != "todas" and $jornada=="todas" and $semestre=="todas"){
			$rspta=$geolocalizacionzona->listarPrograma($programa,$cod_postal);
		}
		if($programa=="todas" and $jornada!="todas" and $semestre=="todas"){
			$rspta=$geolocalizacionzona->listarJornada($jornada,$cod_postal);
		}
		if($programa=="todas" and $jornada=="todas" and $semestre!="todas"){
			$rspta=$geolocalizacionzona->listarSemestre($semestre,$cod_postal);
		}
		if($programa!="todas" and $jornada!="todas" and $semestre=="todas"){
			$rspta=$geolocalizacionzona->listarProgramaJornada($programa,$jornada,$cod_postal);
		}
		if($programa!="todas" and $jornada!="todas" and $semestre!="todas"){
			$rspta=$geolocalizacionzona->listarProgramaJornadaSemestre($programa,$jornada,$semestre,$cod_postal);
		}
		if($programa!="todas" and $jornada=="todas" and $semestre!="todas"){
			$rspta=$geolocalizacionzona->listarProgramaSemestre($programa,$semestre,$cod_postal);
		}

			$reg=$rspta;
			for ($i=0;$i<count($reg);$i++){
				
				$rspta2=$geolocalizacionzona->listarDatos($reg[$i]["id_credencial"]);
				$data [] = array(
					'0' => $rspta2["credencial_identificacion"],
					'1' => $rspta2["credencial_nombre"] . " " . $rspta2["credencial_nombre_2"] . " " . $rspta2["credencial_apellido"] . " " . $rspta2["credencial_apellido_2"],
					'2' => $rspta2["celular"],
					'3' => $rspta2["credencial_login"],
					'4' => $rspta2["barrio"] . " " .$rspta2["direccion"] ,
				); 
			}
		
		

 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
		
		
	
//	case "selectPeriodo":	
//		$rspta = $geolocalizacionzona->selectPeriodo();
//		echo "<option value=''>Seleccionar</option>";
//		echo "<option value='todas'>Todas los Periodos</option>";
//		for ($i=0;$i<count($rspta);$i++)
//				{
//					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
//				}
//	break;	
		
}
?>