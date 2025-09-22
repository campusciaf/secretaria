<?php 
require_once "../modelos/ResultadoEstudiante.php";

$resultadoestudiante=new ResultadoEstudiante();

$id_ejes=isset($_POST["id_ejes"])? limpiarCadena($_POST["id_ejes"]):"";
$nombre_ejes=isset($_POST["nombre_ejes"])? limpiarCadena($_POST["nombre_ejes"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$objetivo=isset($_POST["objetivo"])? limpiarCadena($_POST["objetivo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_ejes)){
			$rspta=$resultadoestudiante->insertar($nombre_ejes,$periodo,$objetivo);			
			echo $rspta ? "ejes registrada" : "ejes no se pudo registrar";
		}
		else {
			$rspta=$resultadoestudiante->editar($id_ejes,$nombre_ejes,$periodo,$objetivo);
			
			echo $rspta ? "ejes actualizada" : "ejes no se pudo actualizar";
		}
	break;


	case 'mostrar':
		$id_credencial=$_POST["id_credencial"];
		
		$rspta=$resultadoestudiante->listardatos($id_credencial);
		
		$nombre_categoria=$resultadoestudiante->datosCategoria();
		
		$data= Array();
		$data["0"] ="";
		
		$data["0"] .= '<p class="text-uppercase">'. $rspta["credencial_nombre"] .' '. $rspta["credencial_nombre_2"] .' '. $rspta["credencial_apellido"] .' '. $rspta["credencial_apellido_2"] .'<br> Celular:'. $rspta["celular"].' Email: '. $rspta["email"] .' - '. $rspta["credencial_login"] .'</p>';
			
		for ($i=0;$i<count($nombre_categoria);$i++){	
			$id_categoria=$nombre_categoria[$i]["id_categoria"];
			$categoria_nombre=$nombre_categoria[$i]["categoria_nombre"];
			
			
					$data["0"] .= '<h2>'.  $categoria_nombre .'</h2>';
					$data["0"] .= '<br>';
			
					$nombre_variable_respuesta=$resultadoestudiante->datosVariablesContestadas($id_credencial,$id_categoria);
						$data["0"] .= '<table class="table table-bordered">';
						for ($j=0;$j<count($nombre_variable_respuesta);$j++){
							
							$id_variable=$nombre_variable_respuesta[$j]["id_variable"];	
							$respuesta_nombre=$nombre_variable_respuesta[$j]["respuesta"];
							$dato_variable=$resultadoestudiante->datosVariables($id_variable);
							$id_tipo_pregunta=$dato_variable["id_tipo_pregunta"];
							$nombre_variable=$dato_variable["nombre_variable"];
							$data["0"] .= '<tr>';
								$data["0"] .= '<td width="80%">';
									
									$data["0"] .=$nombre_variable;
									$data["0"] .= '<br>';
								$data["0"] .= '</td>';
								$data["0"] .= '<td>';
									if($id_tipo_pregunta==1){
									$data["0"] .= $respuesta_nombre;
									}else{
										$dato_respuesta=$resultadoestudiante->respuesta($respuesta_nombre);
										$data["0"] .= $dato_respuesta["nombre_opcion"];
									}
							
								$data["0"] .= '</td>';
							$data["0"] .= '</tr>';
						}
						$data["0"] .= '</table>';

			}
		
				
 		
		
 		$results = array($data);
 		echo json_encode($results);
	break;

	case 'listar':
		
		$periodo_ingreso=$_GET["periodo_ingreso"];
		$rspta=$resultadoestudiante->listar($periodo_ingreso);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
 		for ($i=0;$i<count($reg);$i++){
			
			//$rspta2= $resultadoestudiante->verificarDato($reg[$i]["id_credencial"]);
			//$suma=count($rspta2);
			
 			$data[]=array(
				"0"=>'<button class="btn btn-primary btn-sm" onclick="mostrar('.$reg[$i]["id_credencial"].')" title="Ver caracterización Caracterización"><i class="fas fa-eye"></i> Ver</button>',
				"1"=>$reg[$i]["credencial_identificacion"],
 				"2"=>$reg[$i]["credencial_nombre"] .' '. $reg[$i]["credencial_nombre_2"] .' '. $reg[$i]["credencial_apellido"] .' '. $reg[$i]["credencial_apellido_2"],
				"3"=>$reg[$i]["fo_programa"],
				"4"=>$reg[$i]["celular"],
				"5"=>$reg[$i]["email"] .' - '. $reg[$i]["credencial_login"],
				"6"=>'$suma',
				"7"=>$resultadoestudiante->fechaesp($reg[$i]["fecha"]),	
				"8"=>$reg[$i]["periodo"]
 				);
			
			
 		}
	
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
		case 'eliminar':
		$id_credencial=$_POST["id_credencial"];
		$rspta=$resultadoestudiante->eliminar($id_credencial);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


case "selectPeriodo":	
	$rspta = $resultadoestudiante->selectPeriodo();
	echo "<option value=''>Seleccionar</option>";
	echo "<option value='todas'>Todas los Periodos</option>";
	for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
			}
break;

}
?>