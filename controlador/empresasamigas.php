<?php 
session_start(); 
require_once "../modelos/EmpresasAmigas.php";

$empresasamigas=new EmpresasAmigas();

$id_ejes=isset($_POST["id_ejes"])? limpiarCadena($_POST["id_ejes"]):"";
$nombre_ejes=isset($_POST["nombre_ejes"])? limpiarCadena($_POST["nombre_ejes"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$objetivo=isset($_POST["objetivo"])? limpiarCadena($_POST["objetivo"]):"";

switch ($_GET["op"]){

case 'listar2':
		// $periodo=$_POST["periodo"];
		// $data= Array();
		// $data["0"] ="";
		// /* consulta para traer el header de la tabla */
		// $data["0"] .= '<thead>';
		// 	$data["0"] .= '<th> Credencial</th>';
		// 	$data["0"] .= '<th> Nombre</th>';
		// 	$data["0"] .= '<th> Celular</th>';
		// 	$data["0"] .= '<th> Correo P</th>';
		// 	$data["0"] .= '<th> Correo CIAF</th>';
		// 	$data["0"] .= '<th> Periodo</th>';
		// 	$data["0"] .= '<th> Programa</th>';
		
		// 	$nombre_variables_head=$empresasamigas->datosVariablesHead();

		// 	for ($b=0;$b<count($nombre_variables_head);$b++){
		// 		$variable_nombre_head=$nombre_variables_head[$b]["nombre_variable"];

		// 		$data["0"] .= '<th>' .$variable_nombre_head .'</th>';
		// 	}
		
		// $data["0"] .= '</thead>';
		// /* ********************************* */
		
		// $rspta=$empresasamigas->listar($periodo);
		// for ($a=0;$a<count($rspta);$a++){
			
		// 	$id_credencial= $rspta[$a]["id_credencial"];

		// 	$data["0"] .= '<tr>';
		// 		$data["0"] .= '<td>';
		// 			$data["0"] .= $id_credencial;
		// 		$data["0"] .= '</td>';
		// 		$data["0"] .= '<td>';
		// 			$data["0"] .= '<p class="text-uppercase">'. $rspta[$a]["credencial_apellido"] .' '. $rspta[$a]["credencial_apellido_2"] . ' ' .$rspta[$a]["credencial_nombre"] .' '. $rspta[$a]["credencial_nombre_2"] ;
		// 		$data["0"] .= '</td>';
		// 		$data["0"] .= '<td>';
		// 			$data["0"] .= $rspta[$a]["celular"];
		// 		$data["0"] .= '</td>';
		// 		$data["0"] .= '<td>';
		// 			$data["0"] .= $rspta[$a]["email"];
		// 		$data["0"] .= '</td>';
		// 		$data["0"] .= '<td>';
		// 			$data["0"] .= $rspta[$a]["credencial_login"];
		// 		$data["0"] .= '</td>';
		// 		$data["0"] .= '<td>';
		// 			$data["0"] .= $rspta[$a]["periodo"];
		// 		$data["0"] .= '</td>';
			
		// 		$programaac=$empresasamigas->programaac($id_credencial);
		// 		$data["0"] .= '<td>';
		// 			$data["0"] .= $programaac["fo_programa"];
		// 		$data["0"] .= '</td>';
			
		// 	$id_variables_head=$empresasamigas->datosVariablesHead();
		// 	for ($c=0;$c<count($id_variables_head);$c++){
		// 		$id_variable_head=$id_variables_head[$c]["id_variable"];
		// 		$id_tipo_pregunta=$id_variables_head[$c]["id_tipo_pregunta"];
				
		// 		$respuesta=$empresasamigas->respuestaUno($id_credencial,$id_variable_head);			
		// 		if($id_tipo_pregunta==1){
		// 			$data["0"] .= '<th>' .$respuesta["respuesta"] .'</th>';
		// 		}else{
		// 			$dato_respuesta=$empresasamigas->respuesta($respuesta["respuesta"]);
		// 			$data["0"] .= '<th>' .$dato_respuesta["nombre_opcion"] .'</th>';
		// 		}
		// 	}
		
			
		// 	$data["0"] .= '</tr>';
		
		// }
 		
		
 		// $results = array($data);
 		// echo json_encode($results);
break;
		
	
case 'listar':
		$id_programa=$_POST["id_programa"];
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
			
		
			$nombre_variables_head=$empresasamigas->datosVariablesHead();
			for ($b=0;$b<count($nombre_variables_head);$b++){
				$variable_nombre_head=$nombre_variables_head[$b]["nombre_variable"];

				$data["0"] .= '<th>' .$variable_nombre_head .'</th>';
			}
		
		
		$data["0"] .= '</thead>';
		/* ********************************* */
		
		$rspta=$empresasamigas->listar($id_programa,$periodo);
		for ($a=0;$a<count($rspta);$a++){
			

						
			$id_credencial= $rspta[$a]["id_credencial"];
			$credencial_identificacion = $rspta[$a]["credencial_identificacion"];

			/* ********************************************************* */
			$campotabla="";
			$buscar_nombre_categoria=$empresasamigas->mostrar(3);// consulta para buscar el nombre de la categoria
			$tabla=$buscar_nombre_categoria["tabla"];// variable que contiene el nombre de la tabla donde se reigran los datos de la categoria

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
				
		
				$id_variables_head=$empresasamigas->datosVariablesHead();

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
	$rspta = $empresasamigas->selectPrograma();
	echo "<option value=''>Seleccionar</option>";
	for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
			}
break;


		
	case 'datostabla':
		
		$data= Array();
		$data["usuario"] ="";
		
		$data["usuario"] .= $_SESSION['usuario_cargo'];

 		echo json_encode($data);
	break;
		
	case "selectPeriodo":	
		$rspta = $empresasamigas->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

		
}
?>