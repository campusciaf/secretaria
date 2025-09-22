<?php 
session_start(); 
require_once "../modelos/CaracterizacionPrograma.php";

$caracterizacionprograma=new CaracterizacionPrograma();


$id_programa_ac=isset($_POST["id_programa_ac"])? limpiarCadena($_POST["id_programa_ac"]):"";
$id_categoria=isset($_POST["id_categoria"])? limpiarCadena($_POST["id_categoria"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";




date_default_timezone_set("America/Bogota");	
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');


$rsptaperiodo = $caracterizacionprograma->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];

switch ($_GET["op"]){
		
	case 'listar':

		$datoscategoria=$caracterizacionprograma->datosCategoriaId($id_categoria);
		$tabla=$datoscategoria["tabla"];

		$data= Array();
		$data["0"] ="";
		/* consulta para traer el header de la tabla */
		$data["0"] .= '<thead>';
			$data["0"] .= '<th> Credencial</th>';
			$data["0"] .= '<th> Identificacion</th>';
			$data["0"] .= '<th> Nombre</th>';
			$data["0"] .= '<th> Celular</th>';
			$data["0"] .= '<th> Correo</th>';
			$data["0"] .= '<th> Jornada</th>';
			$data["0"] .= '<th> Semestre</th>';
			
		
			$nombre_variables_head=$caracterizacionprograma->datosVariablesHead($id_categoria);
			for ($b=0;$b<count($nombre_variables_head);$b++){
				$variable_nombre_head=$nombre_variables_head[$b]["nombre_variable"];

				$data["0"] .= '<th>' .$variable_nombre_head .'</th>';
			}
		
		
		$data["0"] .= '</thead>';
		/* ********************************* */
		
		$rspta=$caracterizacionprograma->listar($id_programa_ac,$tabla,$periodo);
		for ($a=0;$a<count($rspta);$a++){
			

						
			$id_credencial= $rspta[$a]["id_credencial"];
			$credencial_identificacion = $rspta[$a]["credencial_identificacion"];



			$data["0"] .= '<tr>';
				$data["0"] .= '<td>';
					$data["0"] .= $id_credencial;
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $credencial_identificacion;
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= '<p class="text-uppercase">'. $rspta[$a]["credencial_apellido"] .' '. $rspta[$a]["credencial_apellido_2"] .' '. $rspta[$a]["credencial_nombre"] .' '. $rspta[$a]["credencial_nombre_2"] ;
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $rspta[$a]["celular"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $rspta[$a]["email"] .'<br>'. $rspta[$a]["credencial_login"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $rspta[$a]["jornada_e"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $rspta[$a]["semestre_estudiante"];
				$data["0"] .= '</td>';
				
				
		
				$id_variables_head=$caracterizacionprograma->datosVariablesHead($id_categoria);

				for ($c=0;$c<count($id_variables_head);$c++){
					$id_variable_head=$id_variables_head[$c]["id_variable"];
					$id_tipo_pregunta=$id_variables_head[$c]["id_tipo_pregunta"];
					$campotabla=$c+1;

						$data["0"] .= '<td>' .@$rspta[$a]["r".$campotabla] .'</td>';
						
					
				}
			
			$data["0"] .= '</tr>';
		
		}
 		
		
 		$results = array($data);
 		echo json_encode($results);
	break;

    case "selectPrograma":	
		$rspta = $caracterizacionprograma->selectPrograma();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
    case "selectCategoria":	
		$rspta = $caracterizacionprograma->selectCategoria();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_categoria"] . "'>" . $rspta[$i]["categoria_nombre"] . "</option>";
				}
	break;
	
		
	case "selectPeriodo":	
		$rspta = $caracterizacionprograma->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

			
	case 'datostabla':
		
		$data= Array();
		$data["usuario"] ="";
		
		$data["usuario"] .= $_SESSION['usuario_cargo'];

 		echo json_encode($data);
	break;
		









}
?>