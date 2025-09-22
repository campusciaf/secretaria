<?php 
session_start(); 
require_once "../modelos/CarVerSeresoriginales.php";

$carverseresoriginales=new CarVerSeresoriginales();

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

			$data["0"] .= '<th> ¿Estás embarazada?</th>';
			$data["0"] .= '<th> Cuántos meses de embarazo tienes</th>';
			$data["0"] .= '<th> Eres desplazado(a) por la violencia</th>';
			$data["0"] .= '<th> qué tipo de desplazamiento </th>';
			$data["0"] .= '<th> A qué grupo poblacional perteneces</th>';
			$data["0"] .= '<th> Perteneces a la comunidad LGBTIQ+? </th>';
			$data["0"] .= '<th> A cual comunidad? </th>';
			$data["0"] .= '<th> nombre primer contacto de emergencia</th>';
			$data["0"] .= '<th> tu relación con esta persona</th>';
			$data["0"] .= '<th> correo contacto de emergencia</th>';
			$data["0"] .= '<th> telefono contacto de emergencia</th>';
			$data["0"] .= '<th> nombresegundo contacto de emergencia</th>';
			$data["0"] .= '<th> relación con esta persona</th>';
			$data["0"] .= '<th> correo electrónico de este contacto </th>';
			$data["0"] .= '<th> número de teléfono de este contacto </th>';
			$data["0"] .= '<th> Tienes un computador o tablet</th>';
			$data["0"] .= '<th>Tienes conexión a internet en casa</th>';
			$data["0"] .= '<th> Tienes planes de datos en tu celular</th>';

			

		$data["0"] .= '</thead>';
		$data["0"] .= '<tbody>';
		/* ********************************* */
		if($valor==0){
			$rspta=$carverseresoriginales->listar();
		}else{
			$rspta=$carverseresoriginales->listar2($valor);
		}
		
		for ($a=0;$a<count($rspta);$a++){
			
			$id_credencial= $rspta[$a]["id_credencial"];
			

			$datosestudiante=$carverseresoriginales->datosestudiante($id_credencial);
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
			for($r=1;$r<=18;$r++){

				$res='p'. '' . $r;
				if($r==1){// esta embarazada
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
				else if($r==3){//desplazado por al violencia
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
				else if($r==6){//pertenece a una comunidad
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
		$rspta = $carverseresoriginales->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

		
}
?>