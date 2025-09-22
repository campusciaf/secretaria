<?php 
session_start(); 
require_once "../modelos/Inspiradores.php";

$inspiradores=new Inspiradores();

$id_ejes=isset($_POST["id_ejes"])? limpiarCadena($_POST["id_ejes"]):"";
$nombre_ejes=isset($_POST["nombre_ejes"])? limpiarCadena($_POST["nombre_ejes"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$objetivo=isset($_POST["objetivo"])? limpiarCadena($_POST["objetivo"]):"";

switch ($_GET["op"]){

case 'listar':
		$periodo=$_POST["periodo"];
		$data= Array();
		$data["0"] ="";
		/* consulta para traer el header de la tabla */
		$data["0"] .= '<thead>';
			$data["0"] .= '<th> Credencial</th>';
			$data["0"] .= '<th> Identificacion</th>';
			$data["0"] .= '<th> Nombre</th>';
			$data["0"] .= '<th> Celular</th>';
			$data["0"] .= '<th> Correo</th>';
			$data["0"] .= '<th> Periodo</th>';
		
			$nombre_variables_head=$inspiradores->datosVariablesHead();

			for ($b=0;$b<count($nombre_variables_head);$b++){
				$variable_nombre_head=$nombre_variables_head[$b]["nombre_variable"];

				$data["0"] .= '<th>' .$variable_nombre_head .'</th>';
			}
		
		$data["0"] .= '</thead>';
		/* ********************************* */
		
		$rspta=$inspiradores->listar($periodo);
		for ($a=0;$a<count($rspta);$a++){

			
			
			
			$id_credencial= $rspta[$a]["id_credencial"];
			$credencial_identificacion = $rspta[$a]["credencial_identificacion"];

			/* ********************************************************* */
			$campotabla="";
			$buscar_nombre_categoria=$inspiradores->mostrar(2);// consulta para buscar el nombre de la categoria
			$tabla=$buscar_nombre_categoria["tabla"];// variable que contiene el nombre de la tabla donde se reigran los datos de la categoria


			/* ********************************************************* */



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
					$data["0"] .= $rspta[$a]["fo_programa"];
				$data["0"] .= '</td>';
			
			$id_variables_head=$inspiradores->datosVariablesHead();

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
		
	case 'datostabla':
		
		$data= Array();
		$data["usuario"] ="";
		
		$data["usuario"] .= $_SESSION['usuario_cargo'];

 		echo json_encode($data);
	break;
		
	case "selectPeriodo":	
		$rspta = $inspiradores->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

		
}
?>