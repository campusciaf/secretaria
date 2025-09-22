<?php 
session_start(); 
require_once "../modelos/CarVerInspiradores.php";

$carverinspiradores=new CarVerInspiradores();

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

			$data["0"] .= '<th>Estado civil</th>';
            $data["0"] .= '<th>¿Tienes hijos?</th>';
            $data["0"] .= '<th>¿Cuántos hijos tienes?</th>';
            $data["0"] .= '<th>¿Tu padre se encuentra vivo?</th>';
            $data["0"] .= '<th>Nombre completo de tu padre</th>';
            $data["0"] .= '<th>Teléfono de contacto del padre</th>';
            $data["0"] .= '<th>Nivel educativo de tu padre</th>';
            $data["0"] .= '<th>¿Tu madre se encuentra viva?</th>';
            $data["0"] .= '<th>Nombre completo de tu madre</th>';
            $data["0"] .= '<th>Teléfono de contacto de la madre</th>';
            $data["0"] .= '<th>Nivel educativo de tu madre</th>';
            $data["0"] .= '<th>¿Cuál es la situación laboral actual de tus padres?</th>';
            $data["0"] .= '<th>¿En qué industria o sector trabajan tus padres?</th>';
            $data["0"] .= '<th>¿Qué cursos o diplomados de interés para tus padres?</th>';
            $data["0"] .= '<th>¿Tienes pareja actualmente?</th>';
            $data["0"] .= '<th>¿Nombre de tu pareja?</th>';
            $data["0"] .= '<th>¿Número de celular de tu pareja?</th>';
            $data["0"] .= '<th>¿Tienes hermanos?</th>';
            $data["0"] .= '<th>¿Cuántos hermanos tienes?</th>';
            $data["0"] .= '<th>¿En qué rango de edad se encuentran tus hermanos?</th>';
            $data["0"] .= '<th>¿Con quién vive?</th>';
            $data["0"] .= '<th>¿Tienes personas a tu cargo?</th>';
            $data["0"] .= '<th>¿Cuántas personas tienes a cargo?</th>';
            $data["0"] .= '<th>¿Quién es la persona que te inspiró a estudiar?</th>';
            $data["0"] .= '<th>¿Cuál es el nombre de tu inspirador?</th>';
            $data["0"] .= '<th>WhatsApp del inspirador</th>';
            $data["0"] .= '<th>Correo electrónico del inspirador</th>';
            $data["0"] .= '<th>¿Nivel de formación de tu inspirador?</th>';
            $data["0"] .= '<th>¿Cuál es la situación laboral actual de tu inspirador?</th>';
            $data["0"] .= '<th>¿En qué industria o sector trabaja tu inspirador?</th>';
            $data["0"] .= '<th>¿Qué cursos o diplomados de interés para tu inspirador?</th>';

			

		$data["0"] .= '</thead>';
		$data["0"] .= '<tbody>';
		/* ********************************* */
		if($valor==0){
			$rspta=$carverinspiradores->listar();
		}else{
			$rspta=$carverinspiradores->listar2($valor);
		}
		
		for ($a=0;$a<count($rspta);$a++){
			
			$id_credencial= $rspta[$a]["id_credencial"];
			

			$datosestudiante=$carverinspiradores->datosestudiante($id_credencial);
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
			for($r=1;$r<=31;$r++){

				$res='ip'. '' . $r;
				if($r==2){// esta embarazada
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
				else if($r==4){//papa vivo
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==8){//mama viva
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==15){//tienes pareja
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==18){//tienes hermanos
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==22){//tienes personas a cargo
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
		$rspta = $carverinspiradores->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

		
}
?>