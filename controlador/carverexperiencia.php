<?php 
session_start(); 
require_once "../modelos/CarVerExperiencia.php";

$carverexperiencia=new CarVerExperiencia();

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

            $data["0"] .= '<th>¿Qué te motivó a estudiar</th>';
            $data["0"] .= '<th>¿Cómo te enteraste de CIAF?</th>';
            $data["0"] .= '<th>¿Cuál de las siguientes áreas es de tu preferencia?</th>';
            $data["0"] .= '<th>¿De qué manera aprendes más fácil?</th>';
            $data["0"] .= '<th>¿Te gustaría realizar una doble titulación en nuestros programas?</th>';
            $data["0"] .= '<th>¿Qué programa te interesaría?</th>';
            $data["0"] .= '<th>¿Dominas un segundo idioma?</th>';
            $data["0"] .= '<th>¿Qué idioma?</th>';
            $data["0"] .= '<th>¿En qué nivel te encuentras?</th>';
            $data["0"] .= '<th>¿Cuál es el nombre completo de tu segundo contacto de emergencia?</th>';


			

		$data["0"] .= '</thead>';
		$data["0"] .= '<tbody>';
		/* ********************************* */
		if($valor==0){
			$rspta=$carverexperiencia->listar();
		}else{
			$rspta=$carverexperiencia->listar2($valor);
		}
		
		for ($a=0;$a<count($rspta);$a++){
			
			$id_credencial= $rspta[$a]["id_credencial"];
			

			$datosestudiante=$carverexperiencia->datosestudiante($id_credencial);
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
			for($r=1;$r<=10;$r++){

				$res='eap'. '' . $r;
				if($r==5){// doble tituloacion
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==7){// segundo idfioma
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
		$rspta = $carverexperiencia->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

		
}
?>