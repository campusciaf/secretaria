<?php 
session_start(); 
require_once "../modelos/CarVerBienestar.php";

$carverbienestar=new CarVerBienestar();

$id_ejes=isset($_POST["id_ejes"])? limpiarCadena($_POST["id_ejes"]):"";
$nombre_ejes=isset($_POST["nombre_ejes"])? limpiarCadena($_POST["nombre_ejes"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$objetivo=isset($_POST["objetivo"])? limpiarCadena($_POST["objetivo"]):"";

switch ($_GET["op"]){

case 'listar':
		$periodo=$_POST["periodo"];
		$valor=$_POST["valor"];
		$data= Array();
		$data["0"] ="";
		/* consulta para traer el header de la tabla */
		$data["0"] .= '<thead>';
			$data["0"] .= '<th> Credencial</th>';
			$data["0"] .= '<th> Identificacion</th>';
			$data["0"] .= '<th> Nombre</th>';
			$data["0"] .= '<th> Celular</th>';
			$data["0"] .= '<th> Correo</th>';
			$data["0"] .= '<th> Programa académico</th>';
			$data["0"] .= '<th> Periodo ingreso </th>';
			$data["0"] .= '<th> Jornada </th>';
			$data["0"] .= '<th> Semestre </th>';
			$data["0"] .= '<th> Caracterización </th>';


            $data["0"] .= '<th>¿Tienes alguna enfermedad física?</th>';
            $data["0"] .= '<th>¿Qué enfermedad física?</th>';
            $data["0"] .= '<th>¿Recibes algún tratamiento para esta enfermedad que padeces?</th>';
            $data["0"] .= '<th>¿Has sido diagnosticado con algún trastorno mental?</th>';
            $data["0"] .= '<th>¿Qué trastorno mental?</th>';
            $data["0"] .= '<th>¿Recibes tratamiento médico del trastorno mental que presentas?</th>';
            $data["0"] .= '<th>¿Hay algún aspecto específico que desees compartir sobre tu bienestar emocional o psicológico?</th>';
            $data["0"] .= '<th>¿A cuál EPS está afiliado actualmente?</th>';
            $data["0"] .= '<th>¿Consumes algún medicamento de manera permanente?</th>';
            $data["0"] .= '<th>¿Qué medicamentos?</th>';
            $data["0"] .= '<th>¿Tienes alguna habilidad especial o talento que te gustaría mencionar?</th>';
            $data["0"] .= '<th>¿Cuál habilidad?</th>';
            $data["0"] .= '<th>¿Participas en actividades extracurriculares relacionadas con tus habilidades o talentos?</th>';
            $data["0"] .= '<th>¿Has recibido algún tipo de reconocimiento o premio por tus habilidades o talentos?</th>';
            $data["0"] .= '<th>¿Cómo integras tus habilidades o talentos en tu vida universitaria y cotidiana?</th>';
            $data["0"] .= '<th>¿Cuáles son las actividades de tu interés?</th>';
            $data["0"] .= '<th>¿Pertenece a algún tipo de voluntariado?</th>';
            $data["0"] .= '<th>¿Cuál voluntariado?</th>';
            $data["0"] .= '<th>¿Desearía participar en CIAF cómo?</th>';
            $data["0"] .= '<th>¿Seleccione los temas de tu interés?</th>';
            $data["0"] .= '<th>¿Música de tu preferencia?</th>';
            $data["0"] .= '<th>¿Qué habilidades o talentos te gustaría desarrollar durante tu tiempo en la universidad?</th>';
			$data["0"] .= '<th>¿Cuál es tu deporte de interés?</th>';
            
			
			

		$data["0"] .= '</thead>';
		$data["0"] .= '<tbody>';
		/* ********************************* */
		if($valor==0){
			$rspta=$carverbienestar->listar();
		}else{
			$rspta=$carverbienestar->listar2($valor);
		}
		
		for ($a=0;$a<count($rspta);$a++){
			
			$id_credencial= $rspta[$a]["id_credencial"];
			

			$datosestudiante=$carverbienestar->datosestudiante($id_credencial);
			$credencial_identificacion = $datosestudiante["credencial_identificacion"];

			$data["0"] .= '<tr>';
				$data["0"] .= '<td>';
					$data["0"] .= $id_credencial;
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $credencial_identificacion;
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= '<p class="text-uppercase">'. $datosestudiante["credencial_apellido"] .' '. $datosestudiante["credencial_apellido_2"] .' '. $datosestudiante["credencial_nombre"] .' '. $datosestudiante["credencial_nombre_2"] ;
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["celular"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["email"] .'<br>'. $datosestudiante["credencial_login"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["fo_programa"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["periodo"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["jornada_e"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["semestre_estudiante"];
				$data["0"] .= '</td>';

			


			$miestado=$rspta[$a]["estado"]=="0" ? "Finalizado":"pendiente";
			$data["0"] .= '<td>';
					$data["0"] .= $miestado;
			$data["0"] .= '</td>';

			$res=0;
			for($r=1;$r<=23;$r++){

				$res='bp'. '' . $r;
				if($r==1){// enfermedad
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==4){// trasntorno
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}

                else if($r==9){// trasntorno
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==11){// habilidad
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==17){// valuntario
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}

				else{
					$data["0"] .= '<td>';
						$data["0"] .= $rspta[$a][$res];
					$data["0"] .= '</td>';
				}

				

			}
			
			$data["0"] .= '</tr>';
		
		}
 		
		$data["0"] .= '</tbody>';
 		$results = array($data);
 		echo json_encode($results);
	break;
		
	case 'datostabla':
		
		$data= Array();
		$data["usuario"] ="";
		
		$data["usuario"] .= $_SESSION['usuario_cargo'];

 		echo json_encode($data);
	break;
		
	case "selectPeriodo":	
		$rspta = $carverbienestar->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

		
}
?>