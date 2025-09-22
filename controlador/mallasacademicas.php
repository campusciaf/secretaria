<?php 
require_once "../modelos/MallasAcademicas.php";

$mallasacademicas=new MallasAcademicas();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$programa=isset($_POST["programa"])? limpiarCadena($_POST["programa"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$semestre=isset($_POST["semestre"])? limpiarCadena($_POST["semestre"]):"";
$area=isset($_POST["area"])? limpiarCadena($_POST["area"]):"";
$creditos=isset($_POST["creditos"])? limpiarCadena($_POST["creditos"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$presenciales=isset($_POST["presenciales"])? limpiarCadena($_POST["presenciales"]):"";
$independiente=isset($_POST["independiente"])? limpiarCadena($_POST["independiente"]):"";
$escuela=isset($_POST["escuela"])? limpiarCadena($_POST["escuela"]):"";



switch ($_GET["op"]){
		
		
	case 'listar':
		$id_programa=$_POST["id_programa"];
 		$data= Array();
		$data["0"] ="";
		
		$datos_programa=$mallasacademicas->datosPrograma($id_programa);
		$semestres=$datos_programa["semestres"];
		$contador=1;
		
		if($semestres==5){// pra programas con 4 semestres
				$columnas='<div class="card col-xl-2 col-lg-2 col-md-6 col-12">';
			}

			if($semestres==4){// pra programas con 4 semestres
				$columnas='<div class="card col-xl-3 col-lg-3 col-md-6 col-12">';
			}
			if($semestres==3){// pra programas con 4 semestres
				$columnas='<div class="card col-xl-4 col-lg-4 col-md-6 col-12">';
			}
			if($semestres==2){// pra programas con 4 semestres
				$columnas='<div class="card col-xl-4 col-lg-6 col-md-6 col-12">';
			}
			if($semestres==1){// pra programas con 4 semestres
				$columnas='<div class="card col-xl-6 col-lg-6 col-md-12 col-12">';
			}

		$rspta=$mallasacademicas->listar($id_programa);
		
		$data["0"] .= '<div class="row col-12">';

			while($contador <= $semestres){
				$data["0"] .= $columnas;
				$data["0"] .= '<div style="background-color:#f5f5f5; padding:1%"><center><b>semestre '.$contador.'</b></center></div>';
					for ($i=0;$i<count($rspta);$i++){

						$nombre=$rspta[$i]["nombre"];
						$semestre_materia=$rspta[$i]["semestre"];
						$prerequisito=$rspta[$i]["prerequisito"];
						$datosprerequisito=$mallasacademicas->prerequisito($prerequisito);
						$nombre_prerequisito=$datosprerequisito["nombre"];

						if($semestre_materia==$contador){
							$data["0"] .= '
							<div class="alert"><b>'. $nombre. '</b> <br> <span class="text-black-50">' .$nombre_prerequisito.'</span></div>
							<div class="css-1a5jqy3" style="width: 96%; border-top: 2px dotted rgb(228, 228, 228);margin:auto"></div>';
						}
					}
				$data["0"] .="</div>";
				$contador++;
			}
		
		$data["0"] .= '</div>';
		
		
		
		
		$results = array($data);
 		echo json_encode($results);
	break;
		
	case 'mostrar':
	
		$rspta=$mallasacademicas->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

	break;	
		

	case "selectEscuela":	
		$rspta = $mallasacademicas->selectEscuela();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["escuelas"] . "'>" . $rspta[$i]["escuelas"] . "</option>";
				}
	break;
		
	case "selectPrograma":	
		$rspta = $mallasacademicas->selectPrograma();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
		
	case "selectArea":	
		$rspta = $mallasacademicas->selectArea();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["area_nombre"] . "'>" . $rspta[$i]["area_nombre"] . "</option>";
				}
	break;
	case "prerequisito":	
		$rspta = $mallasacademicas->prerequisito($nombre);
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
		

		

}
?>