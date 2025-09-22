<?php 
require_once "../modelos/ConsultaVariablesPrograma.php";

$consultavariablesprograma=new ConsultaVariablesPrograma();

$id_categoria=isset($_POST["id_categoria"])? limpiarCadena($_POST["id_categoria"]):"";

$programa=isset($_POST["programa"])? limpiarCadena($_POST["programa"]):"";
$jornada=isset($_POST["jornada"])? limpiarCadena($_POST["jornada"]):"";
$semestre=isset($_POST["semestre"])? limpiarCadena($_POST["semestre"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";

switch ($_GET["op"]){



    case 'listar':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo
		$data["0"] .= '<div class="row">';        
        $rspta=$consultavariablesprograma->listarbotones();// consulta para listar los botones de la tabla categoria
        //Codificar el resultado utilizando json
        for ($i=0;$i<count($rspta);$i++){// bucle para imprimir la consulta
            $contestaron=0;
            $rspta2=$consultavariablesprograma->listarvariable($rspta[$i]["id_categoria"]);// consulta para saber cuantas preguntas son por categoria (las preguntas)
            $total_preguntas=count($rspta2);// contiene el total de variables o preguntas que tiene la categoria
            
            $rspta3=$consultavariablesprograma->totalUsuariosListosParaContestar($rspta[$i]["id_categoria"],$programa,$jornada,$semestre,$periodo);// consulta para saber la cantidad de usuarios que estan disponibes para contestar
         	$total_usuarios=count($rspta3);

			 // consulta para taer los que contestaron
            // for ($j=0;$j<count($rspta3);$j++){

            //     $id_credencial=$rspta3[$j]["id_credencial"]; 
            //     $rspta4=$consultavariablesprograma->totalUsuariosContestaronCategoria($id_credencial,$rspta[$i]["id_categoria"]);

            //     if($rspta4){
            //         $contestaron++;
            //     }
            // }

			// <a href="#" class="nav-link" onclick=listarEstudiantesContestaron("'.$rspta[$i]["id_categoria"].'","'.$programa.'","'.$jornada.'","'.$semestre.'","'.$periodo.'")>
			// 	Contestaron <span class="badge bg-primary">$contestaron</span>
			// </a>

           @$porcentaje= ($total_usuarios*100)/$total_preguntas;

				$data["0"] .= ' 
		 
		 
                <div class="row bg-white" style="border-bottom:solid 1px #e5e5e5; padding-bottom:10px; margin:5px 0px">
                    <div class="col-12 card bg-success" style="padding:10px">
						<div class="row">
							<div class="col-xl-1 text-right">
								<img class="img-circle elevation-2" src="../files/caracterizacion/'.$rspta[$i]["categoria_imagen"].'" alt="categoria" width="50px">
							</div>
							<div class="col-xl-11">
								<h3 class="widget-user-username">'.$rspta[$i]["categoria_nombre"].'</h3>
							</div>
						</div>
                    </div>
				
					<div class="col-4">
						
						<a href="#" class="nav-link" onclick=listarVariable("'.$rspta[$i]["id_categoria"].'","'.$programa.'","'.$jornada.'","'.$semestre.'","'.$periodo.'")>
							Variables <span class="badge bg-primary">'.$total_preguntas.'</span>
						</a>
					</div>
					<div class="col-4">
						<a href="#" class="nav-link" onclick=listarEstudiantes("'.$rspta[$i]["id_categoria"].'","'.$programa.'","'.$jornada.'","'.$semestre.'","'.$periodo.'")>
							Usuarios <span class="badge bg-primary">'.$total_usuarios.'</span>
						</a>
					</div>
					<div class="col-4">
						
					</div>
					<div class="col-12">
						<div class="row">';
						$contador=0;
						$imprimirvariable=$consultavariablesprograma->listarVariable($rspta[$i]["id_categoria"]);
						for ($k=0;$k<count($imprimirvariable);$k++){
							$contador++;
							$pregunta=$imprimirvariable[$k]["nombre_variable"];
							$id_variable=$imprimirvariable[$k]["id_variable"];
							$id_tipo_pregunta=$imprimirvariable[$k]["id_tipo_pregunta"];

							$data["0"] .= '<div class="col-4">
											<a onclick=respuestas("'.$rspta[$i]["id_categoria"].'","'.$id_variable.'","'.$id_tipo_pregunta.'","'.$programa.'","'.$jornada.'","'.$semestre.'","'.$periodo.'") class="btn btn-default btn-block">'. $contador .' - '.$pregunta.'
												</a>
											</div>';
						}

					$data["0"] .= ' 
						</div>
					</div>
					
                </div>';

         }
         
		$data["0"] .= '</div>';
		
 		$results = array($data);
 		echo json_encode($results);
	
    break;


    case 'listarEstudiantes':
		$id_categoria=$_GET["id_categoria"];// metodo post que captura el id_categoria
        $id_programa=$_GET["id_programa"];// metodo post que captura el id_programa
        $jornada_e=$_GET["jornada_e"];// metodo post que captura la jornada
        $semestre=$_GET["semestre"];// metodo post que captura el semestre
        $periodo=$_GET["periodo"];// metodo post que captura el periodo
		
		$listado=$consultavariablesprograma->listarEstudiantes($id_categoria,$id_programa,$jornada_e,$semestre,$periodo);// consulta para traer los estudiantes
		//Vamos a declarar un array
		$data= Array();
		
		 for ($i=0;$i<count($listado);$i++){
			$id_credencial=$listado[$i]["id_credencial"];// variable que contiene la credencial
			$listadoDatos=$consultavariablesprograma->listarEstudiantesDatos($id_credencial);// consulta para traer los datos de los estudiantes
			 
 			$data[]=array(
				"0"=>$id_credencial,
 				"1"=>$listadoDatos["credencial_identificacion"],
 				"2"=>$listadoDatos["credencial_nombre"] .' '. $listadoDatos["credencial_nombre_2"] .' '. $listadoDatos["credencial_apellido"] .' '. $listadoDatos["credencial_apellido_2"],
				"3"=>$listadoDatos["genero"],
				"4" => $consultavariablesprograma->calculaEdad($listadoDatos["fecha_nacimiento"]),
				"5"=>$listadoDatos["celular"],
				"6"=>$listadoDatos["email"],
				"7"=>$listadoDatos["credencial_login"],
				"8"=>$listadoDatos["periodo"],
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

    case 'listarEstudiantesContestaron':
        
		$id_categoria=$_GET["id_categoria"];// metodo post que captura el id_categoria
        $id_programa=$_GET["id_programa"];// metodo post que captura el id_programa
        $jornada_e=$_GET["jornada_e"];// metodo post que captura la jornada
        $semestre=$_GET["semestre"];// metodo post que captura el semestre
        $periodo=$_GET["periodo"];// metodo post que captura el periodo
		
		$listado=$consultavariablesprograma->listarEstudiantesContestaron($id_categoria,$id_programa,$jornada_e,$semestre,$periodo);// consulta para traer los estudiantes
		//Vamos a declarar un array
		$data= Array();
		
		 for ($i=0;$i<count($listado);$i++){
			$id_credencial=$listado[$i]["id_credencial"];// variable que contiene la credencial
			$listadoDatos=$consultavariablesprograma->listarEstudiantesDatos($id_credencial);// consulta para traer los datos de los estudiantes
			 
 			$data[]=array(
				"0"=>$id_credencial,
 				"1"=>$listadoDatos["credencial_identificacion"],
 				"2"=>$listadoDatos["credencial_nombre"] .' '. $listadoDatos["credencial_nombre_2"] .' '. $listadoDatos["credencial_apellido"] .' '. $listadoDatos["credencial_apellido_2"],
				"3"=>$listadoDatos["genero"],
				"4" => $consultavariablesprograma->calculaEdad($listadoDatos["fecha_nacimiento"]),
				"5"=>$listadoDatos["celular"],
				"6"=>$listadoDatos["email"],
				"7"=>$listadoDatos["credencial_login"],
				"8"=>$listadoDatos["periodo"],
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarVariable':
        $id_categoria=$_POST["id_categoria"];// variable que contiene el id de la catergoria
		$id_programa=$_POST["programa"];// variable que contiene el id de la catergoria
		$jornada_e=$_POST["jornada"];// variable que contiene el id de la catergoria
		$semestre=$_POST["semestre"];// variable que contiene el id de la catergoria
		$periodo=$_POST["periodo"];// variable que contiene el id de la catergoria


		$rspta=$consultavariablesprograma->listarVariable($id_categoria); //Consulta para listar las variables
        
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";//iniciamos el arreglo
        $obligatoria=""; 
        $borde="";

		$data["0"] .= '
		<div class="row">';
			$data["0"] .= '
			<div class="col-lg-12">
				<a onclick="volver()" class="btn btn-primary float-right">
					Volver
				</a>
			</div><br><br>';
				for ($i=0;$i<count($rspta);$i++){// bucle para imprimir la consulta

					$rspta2=$consultavariablesprograma->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]);//consulta para imprimir el icono

					if($rspta[$i]["obligatoria"]==1){$obligatoria="Obligatorio";} else{$obligatoria="No obligatorio";}// condición para saber si es obligatiro el campo
                    if($rspta[$i]["estado_variable"]==1){$borde="";} else{$borde="border: solid 1px #FF0000";}// condición para saber si esta activada

					if($rspta[$i]["id_tipo_pregunta"]==1){// si la pregunta es de respuesta unica como nombre de personas, telefonos, direcciones
						$data["0"] .='
						<div class="col-xl-6">
							<div class="card card-widget widget-user-2">
								<div class="widget-user-header" >
									<h3 style="font-size:16px">'.$rspta2["icono_tipo_pregunta"].' '.$rspta[$i]["nombre_variable"].' #'.$rspta[$i]["id_tipo_pregunta"] .' - ' . $rspta[$i]["id_categoria"] .' - ' . $rspta[$i]["id_variable"] .' </h3>
									<h5 style="font-size:16px">'.$obligatoria .'</h5>
								</div>
								<div class="card-footer p-0" style="height:350px; overflow:scroll">
									<table class="table table-bordered">';

									$contestaron=$consultavariablesprograma->listarEstudiantesContestaron($id_categoria,$id_programa,$jornada_e,$semestre,$periodo);
									for ($j=0;$j<count($contestaron);$j++){
										$respuestas=$consultavariablesprograma->listarEstudiantesDatosRespuesta($contestaron[$j]["id_credencial"],$rspta[$i]["id_categoria"],$rspta[$i]["id_variable"]);

										$data["0"] .='<tr>';	
											$data["0"] .='<td>';
												$data["0"] .=@$respuestas["credencial_nombre"] . ' ' . @$respuestas["credencial_apellido"];
											$data["0"] .='</td>';
											$data["0"] .='<td>';
												$data["0"] .=@$respuestas["respuesta"];
											$data["0"] .='</td>';
										$data["0"] .='</tr>';
									}

									$data["0"] .='
									</table>

								</div>
							</div>
						</div>';
					}

					if($rspta[$i]["id_tipo_pregunta"]==4){
						$data["0"] .='
						<div class="col-md-4">
							<div class="card card-widget widget-user-2">
								<div class="widget-user-header">
									<h3 style="font-size:16px">'.$rspta2["icono_tipo_pregunta"].' '.$rspta[$i]["nombre_variable"].' #'.$rspta[$i]["id_tipo_pregunta"].'</h3>
									<h5 style="font-size:16px">'.$obligatoria .'</h5>
								</div>
								<div class="card-footer p-0">
									<table class="table table-bordered">';

									$contestaron=$consultavariablesprograma->listarEstudiantesContestaron($id_categoria,$id_programa,$jornada_e,$semestre,$periodo);
									for ($j=0;$j<count($contestaron);$j++){

										$data["0"] .=$contestaron[$i]["id_credencial"];
										
									}
								$data["0"] .='
									</table>
								</div>
							</div>
						</div>';
					}
				}
	
		 $data["0"] .='</div>';
 		$results = array($data);
 		echo json_encode($results);

	break; 		





    case "selectPrograma":	
		$rspta = $consultavariablesprograma->selectPrograma();
		echo "<option value=''>Seleccionar</option>";
		echo "<option value='todas'>Todos los Programas</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
	
	case "selectJornada":	
		$rspta = $consultavariablesprograma->selectJornada();
		echo "<option value=''>Seleccionar</option>";
		echo "<option value='todas'>Todas los Jornadas</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
	
	case "selectPeriodo":	
		$rspta = $consultavariablesprograma->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		echo "<option value='todas'>Todas los Periodos</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;


	case 'respuestas':
        $id_categoria=$_POST["id_categoria"];// variable que contiene el id de la catergoria
		$id_variable=$_POST["id_variable"];// variable que contiene el id de la variable o pregunta
		$id_tipo_pregunta=$_POST["id_tipo_pregunta"]; // variable que contiene el tipo de pregunta
		$id_programa=$_POST["programa"];// variable que contiene el id de la catergoria
		$jornada_e=$_POST["jornada"];// variable que contiene el id de la catergoria
		$semestre=$_POST["semestre"];// variable que contiene el id de la catergoria
		$periodo=$_POST["periodo"];// variable que contiene el id de la catergoria
		//Vamos a declarar un array
		$data= Array();
		$data["0"] ="";//iniciamos el arreglo

		if($id_tipo_pregunta==1 or $id_tipo_pregunta==2 or $id_tipo_pregunta==3 or $id_tipo_pregunta==8){// si el tipo de respuesta es unica un campo de texto o longtext o fechas
			$data["0"] .= '<table class="table table-striped table-sm" id="myTable">';
				$data["0"] .= '<thead>';
					$data["0"] .= '<th>Identificacion</th>';
					$data["0"] .= '<th>Nombre</th>';
					$data["0"] .= '<th>Respuesta</th>';
				
				$data["0"] .= '</thead>';
				$data["0"] .= '</tbody>';	

				$rspta1=$consultavariablesprograma->respuestas($id_categoria,$id_variable,$programa,$jornada,$semestre,$periodo);// consulta que trae las personas que tienen respuestas

				for ($a=0;$a<count($rspta1);$a++){
					if($id_tipo_pregunta == 1){// si el tipo de pregunta es una respuesta corta
						$id_credencial=$rspta1[$a]["id_credencial"];
						$rspta3=$consultavariablesprograma->resultado($id_credencial,$id_variable);
						$datos_estudiante=$consultavariablesprograma->listarEstudiantesDatos($id_credencial);// trae los datos de los estudiantes

						$data["0"] .= '<tr>';
							$data["0"] .='<td>';
								$data["0"] .= $datos_estudiante["credencial_identificacion"];
							$data["0"] .='</td>';
							$data["0"] .='<td>';
								$data["0"] .= @$datos_estudiante["credencial_nombre"] .'  '. $datos_estudiante["credencial_nombre_2"] .'  '. $datos_estudiante["credencial_apellido"] .'  '. $datos_estudiante["credencial_apellido_2"];
							$data["0"] .='</td>';
							$data["0"] .='<td>';
								$data["0"] .= @$rspta3["respuesta"];
							$data["0"] .='</td>';
						$data["0"] .= '</tr>';	

					}
					if($id_tipo_pregunta == 2){// si el tipo de pregunta es una respuesta larga
						$id_credencial=$rspta1[$a]["id_credencial"];
						$rspta3=$consultavariablesprograma->resultado($id_credencial,$id_variable);
						$datos_estudiante=$consultavariablesprograma->listarEstudiantesDatos($id_credencial);// trae los datos de los estudiantes

						$data["0"] .= '<tr>';
							$data["0"] .='<td>';
								$data["0"] .= $datos_estudiante["credencial_identificacion"];
							$data["0"] .='</td>';
							$data["0"] .='<td>';
								$data["0"] .= @$datos_estudiante["credencial_nombre"] .'  '. $datos_estudiante["credencial_nombre_2"] .'  '. $datos_estudiante["credencial_apellido"] .'  '. $datos_estudiante["credencial_apellido_2"];
							$data["0"] .='</td>';
							$data["0"] .='<td>';
								$data["0"] .= @$rspta3["respuesta"];
							$data["0"] .='</td>';
						$data["0"] .= '</tr>';
					}

					if($id_tipo_pregunta == 3){// si el tipo de pregunta es una fecha
						$id_credencial=$rspta1[$a]["id_credencial"];
						$rspta3=$consultavariablesprograma->resultado($id_credencial,$id_variable);
						$datos_estudiante=$consultavariablesprograma->listarEstudiantesDatos($id_credencial);// trae los datos de los estudiantes

						$data["0"] .= '<tr>';
							$data["0"] .='<td>';
								$data["0"] .= $datos_estudiante["credencial_identificacion"];
							$data["0"] .='</td>';
							$data["0"] .='<td>';
								$data["0"] .= @$datos_estudiante["credencial_nombre"] .'  '. $datos_estudiante["credencial_nombre_2"] .'  '. $datos_estudiante["credencial_apellido"] .'  '. $datos_estudiante["credencial_apellido_2"];
							$data["0"] .='</td>';
							$data["0"] .='<td>';
								$data["0"] .= @$rspta3["respuesta"];
							$data["0"] .='</td>';
						$data["0"] .= '</tr>';
					}

					if($id_tipo_pregunta == 8){// si el tipo de pregunta es un correo
						$id_credencial=$rspta1[$a]["id_credencial"];
						$rspta3=$consultavariablesprograma->resultado($id_credencial,$id_variable);
						$datos_estudiante=$consultavariablesprograma->listarEstudiantesDatos($id_credencial);// trae los datos de los estudiantes

						$data["0"] .= '<tr>';
							$data["0"] .='<td>';
								$data["0"] .= $datos_estudiante["credencial_identificacion"];
							$data["0"] .='</td>';
							$data["0"] .='<td>';
								$data["0"] .= @$datos_estudiante["credencial_nombre"] .'  '. $datos_estudiante["credencial_nombre_2"] .'  '. $datos_estudiante["credencial_apellido"] .'  '. $datos_estudiante["credencial_apellido_2"];
							$data["0"] .='</td>';
							$data["0"] .='<td>';
								$data["0"] .= @$rspta3["respuesta"];
							$data["0"] .='</td>';
						$data["0"] .= '</tr>';
					}

			}
					$data["0"] .= '</tbody>';
				$data["0"] .= '</table>';

		

		}
		else if($id_tipo_pregunta==4 or $id_tipo_pregunta==7){

			if($id_tipo_pregunta == 4 or $id_tipo_pregunta==7){// si el tipo de pregunta es una un select pero no desprende algo mas
				$contestadas=0;
				$rspta2=$consultavariablesprograma->variableOpciones($id_variable);
				
				$data["0"] .='<div class="card col-xl-4">';
					$data["0"] .= '<table class="table table-striped table-sm">';
						for ($b=0;$b<count($rspta2);$b++){
							$contador=0;
							$total_preguntas=0;
							

							$data["0"] .= '<tr>';
								$data["0"] .= '<td>';
									$id_variable_opciones= $rspta2[$b]["id_variables_opciones"];
									$data["0"] .=$rspta2[$b]["nombre_opcion"];
								$data["0"] .= '</td>';	

								$rspta1=$consultavariablesprograma->respuestas($id_categoria,$id_variable,$programa,$jornada,$semestre,$periodo);// consulta que trae las personas que tienen respuestas
								
									for ($a=0;$a<count($rspta1);$a++){
										
										$id_credencial=$rspta1[$a]["id_credencial"];

										$rspta3=$consultavariablesprograma->resultado($id_credencial,$id_variable);
											$total_preguntas++;

											@$respuesta=$rspta3["respuesta"];
											if($id_variable_opciones==$respuesta){
												$contador++;
												$contestadas++;											
											}
											else{
												
											}
												
									}
									if($total_preguntas==0){
										$total_preguntas=1;
									}
									@$porcentaje=($contador*100)/$total_preguntas;
									

								$data["0"] .= '<td>';
									$data["0"] .='<span class="btn btn-success btn-sm">'.$contador . '</span> = ' . round($porcentaje,0) . '%';
								$data["0"] .= '</td>';


							$data["0"] .= '</tr>';
						}
						$pendientes=$total_preguntas-$contestadas;
						@$porcentajep=($pendientes*100)/$total_preguntas;
						$data["0"] .= '<tr>';
							$data["0"] .= '<td>Pendientes</td>';
							$data["0"] .= '<td><span class="btn btn-danger btn-sm">'.$pendientes.'</span> = ' . round($porcentajep,0) . '%</td>';
						$data["0"] .= '</tr>';
						$data["0"] .= '<tr>';
							$data["0"] .= '<td colspan="2"> 
											Activos<span class="badge badge-secondary">'. $total_preguntas.'</span>
											Contestaron <span class="badge badge-secondary">'.$contestadas.'</span>							
										</td>';
						$data["0"] .= '</tr>';
					$data["0"] .= '</table>';
				$data["0"] .='</div>';
			}

			$data["0"] .= '<h2>Muestra Poblacional</h2>';
			$data["0"] .= '<table class="table table-striped" id="myTable">';
				$data["0"] .= '<thead>';
					$data["0"] .= '<th>Identificación</th>';
					$data["0"] .= '<th>Nombre completo</th>';
					$data["0"] .= '<th>Respuesta</th>';
				$data["0"] .= '</thead>';
				$data["0"] .= '<tbody>';

				$rspta4=$consultavariablesprograma->respuestas($id_categoria,$id_variable,$programa,$jornada,$semestre,$periodo);// consulta que trae las personas que tienen respuestas
				for ($b=0;$b<count($rspta4);$b++){				
					$id_credencial=$rspta4[$b]["id_credencial"];
					$rspta5=$consultavariablesprograma->resultado($id_credencial,$id_variable);
					@$respuesta=$rspta5["respuesta"];

					$rspta6=$consultavariablesprograma->variableOpcionesRespuesta($respuesta);
					@$respuestafinal=$rspta6["nombre_opcion"];

					$datos_estudiante_tabla=$consultavariablesprograma->listarEstudiantesDatos($id_credencial);// trae los datos de los estudiantes
					

					$data["0"] .= '<tr>';
						$data["0"] .='<td>';
							$data["0"] .= $datos_estudiante_tabla["credencial_identificacion"];
						$data["0"] .='</td>';
						$data["0"] .='<td>';
							$data["0"] .= $datos_estudiante_tabla["credencial_nombre"] .'  '. $datos_estudiante_tabla["credencial_nombre_2"] .'  '. $datos_estudiante_tabla["credencial_apellido"] .'  '. $datos_estudiante_tabla["credencial_apellido_2"];
						$data["0"] .='</td>';
						$data["0"] .='<td>';
							$data["0"] .= $respuestafinal;
						$data["0"] .='</td>';
					$data["0"] .= '</tr>';
				
				}
				$data["0"] .= '</tbody>';
			$data["0"] .= '</table>';



		}








		

		 

 		$results = array($data);
 		echo json_encode($results);

	break; 		




		
}
?>

