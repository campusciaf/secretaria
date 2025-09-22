<?php 
require_once "../modelos/ResultadoVariables.php";
session_start();

$resultadovariables=new ResultadoVariables();

$id_categoria=isset($_POST["id_categoria"])? limpiarCadena($_POST["id_categoria"]):"";

$id_usuario=$_SESSION['id_usuario'];
$id_caracterizacion=isset($_POST["id_caracterizacion"])? limpiarCadena($_POST["id_caracterizacion"]):"";
$respuesta=isset($_POST["respuesta"])? limpiarCadena($_POST["respuesta"]):"";
$id_variable=isset($_POST["id_variable"])? limpiarCadena($_POST["id_variable"]):"";

date_default_timezone_set("America/Bogota");
$fecha_respuesta=date('Y-m-d');
$hora_respuesta=date('h:i:sa');


switch ($_GET["op"]){

    case 'listarbotones':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo
		
        $data["0"] .= '<div class="row">';
        $rspta=$resultadovariables->listarbotones();// consulta para listar los botones
        //Codificar el resultado utilizando json
        for ($i=0;$i<count($rspta);$i++){// bucle para imprimir la consulta
            
            $rspta2=$resultadovariables->listar($rspta[$i]["id_categoria"]);// consulta para saber cuantas preguntas son
            $total_preguntas=count($rspta2);
            
            //$rspta3=$resultadovariables->totalRespuestas($rspta[$i]["id_categoria"]);// consulta para saber la cantidad de respuestas por categoria
         	//$total_respuestas=count($rspta3);
            
           @$porcentaje= ($total_respuestas*100)/$total_preguntas;
            
         $data["0"] .= ' 
		<div class="col-xl-4">
		 <div class="card card-widget widget-user-2">
              <div class="widget-user-header bg-success">
                <div class="widget-user-image">
				  <img class="img-circle elevation-2" src="../files/caracterizacion/'.$rspta[$i]["categoria_imagen"].'" alt="User Avatar">
                </div>
                <h3 class="widget-user-username">'.$rspta[$i]["categoria_nombre"].'</h3>
                <h5 class="widget-user-desc">...</h5>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link" onclick=listarVariable('.$rspta[$i]["id_categoria"].')>
						Variables <span class="float-right badge bg-blue">'.$total_preguntas.'</span>
					</a>
                  </li>';
			$rsptausuarios=$resultadovariables->totalUsuarios($rspta[$i]["id_categoria"]);
			$total_usuarios=count($rsptausuarios);
			$data["0"] .= '
				  <li class="nav-item">
                    <a href="#" class="nav-link" onclick=listarEstudiantes("'.$rspta[$i]["id_categoria"].'")>
						Usuarios <span class="float-right badge bg-green">'.$total_usuarios.'</span>
					</a>
                  </li>
                </ul>
              </div>
		  </div>
	  </div>';


        }
		
		 $data["0"] .= '</div>';
 		$results = array($data);
 		echo json_encode($results);
    break;

     case 'listarVariable':
        $id_categoria=$_POST["id_categoria"];// variable que contiene el id de la catergoria
		$rspta=$resultadovariables->listarVariable($id_categoria); //Consulta para listar las variables
        
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";//iniciamos el arreglo
        $obligatoria=""; 
        $borde="";

		$data["0"] .= '<div class="row">';
		$data["0"] .= '<div class="col-lg-12">
			<a onclick="volver()" class="btn btn-primary float-right">Volver
			</a></div><br><br>';
			for ($i=0;$i<count($rspta);$i++){// bucle para imprimir la consulta
				
                if($rspta[$i]["id_tipo_pregunta"]==1){// se ejecuta cuando la pregunta es de tipo respuesta corta
                    
                    if($rspta[$i]["obligatoria"]==1){$obligatoria="required";} else{$obligatoria="";}// condición para saber si es obligatiro el campo
                    if($rspta[$i]["estado_variable"]==1){$borde="";} else{$borde="border: solid 1px #FF0000";}// condición para saber si esta activada
					
					$rsptausuarios=$resultadovariables->totalUsuarios($rspta[$i]["id_categoria"]);// consulta para ver el total de usuarios
					$total_usuarios=count($rsptausuarios);// variable que contiene el total de usuarios
					 
					 
				$data["0"] .='
					<div class="col-xl-4 col-lg-6 col-md-12 col-12">
					  <div class="card">
						<div class="box-header with-border" style="height:60px">';
					
						$rspta2=$resultadovariables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]);//consulta para imprimir el icono
						$data["0"] .=$rspta2["icono_tipo_pregunta"];
					
					  	$data["0"] .= " <b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
					 
						$data["0"] .='
						  <div class="box-tools float-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						  </div>
						</div>
						<div class="box-body caja_variables">';
					  $respuestas=$resultadovariables->totalRespuestasVariable($rspta[$i]["id_variable"]);// consulta para traer los values del select

					 $data["0"] .= "<table class='table table-bordered'>";					 
							for ($j=0;$j<count($respuestas);$j++)// bucle para imprimir las opciones del select
								{
								
									$data["0"] .= "<tr>";
										$data["0"] .= "<td width='70%'>";
											$data["0"] .= "<span>" . $respuestas[$j]["respuesta"] ."</span>";
										$data["0"] .= "</td>";
										$data["0"] .= "<td align='center'>";
											$data["0"] .='<span class="badge bg-blue">'.$respuestas[$j]["id_usuario"].'</span>';	
										$data["0"] .= "</td>";
										
								$data["0"] .= "</tr>";
								
								}
					 			
					$data["0"] .= "</table>";						
				 $data["0"] .='
					</div>
				  </div>
				</div>';					 
  
                }
                
                else if($rspta[$i]["id_tipo_pregunta"]==2){// se ejecuta cuando la pregunta es de tipo respuesta larga
                    
                    if($rspta[$i]["obligatoria"]==1){$obligatoria="required";} else{$obligatoria="";}// condición para saber si es obligatiro el campo
                    if($rspta[$i]["estado_variable"]==1){$borde="";} else{$borde="border: solid 1px #FF0000";}// condición para saber si esta activada
					
				$data["0"] .='
					<div class="col-xl-4 col-lg-6 col-md-12 col-12">
					  <div class="card">
						<div class="box-header with-border" style="height:60px">';
					
					 		$rspta2=$resultadovariables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]);//consulta para imprimir el icono
                            $data["0"] .=$rspta2["icono_tipo_pregunta"];
					
						  $data["0"] .= " <b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
					$data["0"] .='
						  <div class="box-tools float-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						  </div>
						</div>
						<!-- /.box-header -->
						<div class="box-body caja_variables">
						  The body of the box
						</div>
					  </div>
					</div>';
					
                    
                }
                else if($rspta[$i]["id_tipo_pregunta"]==3){// se ejecuta cuando la pregunta es de tipo fecha
                    
                    if($rspta[$i]["obligatoria"]==1){$obligatoria="required";} else{$obligatoria="";}// condición para saber si es obligatiro el campo
                    if($rspta[$i]["estado_variable"]==1){$borde="";} else{$borde="border: solid 1px #FF0000";}// condición para saber si esta activada
                    
				$data["0"] .='
					<div class="col-xl-4 col-lg-6 col-md-12 col-12">
					  <div class="card">
						<div class="box-header with-border" style="height:60px">';
					
					 		$rspta2=$resultadovariables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]);//consulta para imprimir el icono
                            $data["0"] .=$rspta2["icono_tipo_pregunta"];
					
						  $data["0"] .= " <b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
					$data["0"] .='
						  <div class="box-tools float-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						  </div>
						</div>';
						
					$rsptafecha=$resultadovariables->respuestaFecha($id_categoria,$rspta[$i]["id_variable"]);
					 for ($j=0;$j<count($rsptafecha);$j++)// bucle para imprimir las opciones del select
						{
						 $data["0"] .='<div class="box-body">';
							 $fecha=$rsptafecha[$j]["respuesta"];
							 $data["0"] .=$fecha;
						 		$rsptaedad=$resultadovariables->edad($fecha);
						 		$data["0"] .='<span class="float-right badge bg-blue">'.$rsptaedad.'</span>';
								
						 $data["0"] .='</div>';
						 
					 	}

						$data["0"] .='
					  </div>
					</div>';
                    
                }
				

                
                 else if($rspta[$i]["id_tipo_pregunta"]==4){// se ejecuta cuando la pregunta es de tipo select
                    
                    if($rspta[$i]["obligatoria"]==1){$obligatoria="required";} else{$obligatoria="";}// condición para saber si es obligatiro el campo
                    if($rspta[$i]["estado_variable"]==1){$borde="";} else{$borde="border: solid 1px #FF0000";}// condición para saber si esta activada
					 
					 $rsptausuarios=$resultadovariables->totalUsuarios($rspta[$i]["id_categoria"]);// consulta para ver el total de usuarios
					$total_usuarios=count($rsptausuarios);// variable que contiene el total de usuarios
					 
					 
				$data["0"] .='
					<div class="col-xl-4 col-lg-6 col-md-12 col-12">
					  <div class="card">
						<div class="box-header with-border" style="height:60px">';
					
					 		$rspta2=$resultadovariables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]);//consulta para imprimir el icono
                            $data["0"] .=$rspta2["icono_tipo_pregunta"];
					
						  $data["0"] .= " <b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
					 
				 
					 
					$data["0"] .='
						  <div class="box-tools float-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						  </div>
						</div>
						<div class="box-body caja_variables">';
					  $variables_opciones=$resultadovariables->listarVariableOpciones($rspta[$i]["id_variable"]);// consulta para traer los values del select

					 $data["0"] .= "<table class='table table-bordered'>";					 
							for ($j=0;$j<count($variables_opciones);$j++)// bucle para imprimir las opciones del select
								{
								$respuesta=$variables_opciones[$j]["nombre_opcion"];// contiene la respuesta
								$respuesta_id_variable=$variables_opciones[$j]["id_variables_opciones"];// contiene la respuesta en id
									$rsptacant=$resultadovariables->respuestaPorVariable($id_categoria,$rspta[$i]["id_variable"],$respuesta_id_variable);
								
										$porcentaje=(count($rsptacant)*100)/$total_usuarios;// formula para calcular el porcentaje 
										$porcentaje=round($porcentaje,0);// quitar decimales al porcentaje
									$data["0"] .= "<tr>";
										$data["0"] .= "<td width='70%'>";
											$data["0"] .= "<span>" . $respuesta ."</span>";
										$data["0"] .= "</td>";
										$data["0"] .= "<td align='center'>";
											$data["0"] .='<a onclick=verEstudiantes('.$id_categoria.','.$rspta[$i]["id_variable"].','.$respuesta_id_variable.') class="btn btn-primary btn-xs">'.count($rsptacant).'</a>';
										$data["0"] .= "</td>";
										$data["0"] .= "<td align='center'>";
											$data["0"] .='<span class="badge bg-orange">'.$porcentaje.'%</span>';
										$data["0"] .= "</td>";
								$data["0"] .= "</tr>";
								}
					 			
						$data["0"] .= "</table>";						
					 $data["0"] .='
					 	</div>
					  </div>
					</div>';					 

                }
 
                
                 else if($rspta[$i]["id_tipo_pregunta"]==5){// se ejecuta cuadno la pregunta es de tipo departamento
                    
                    if($rspta[$i]["obligatoria"]==1){$obligatoria="required";} else{$obligatoria="";}// condición para saber si es obligatiro el campo
                    if($rspta[$i]["estado_variable"]==1){$borde="";} else{$borde="border: solid 1px #FF0000";}// condición para saber si esta activada
                    
                    $data["0"] .='
					<div class="col-xl-4 col-lg-6 col-md-12 col-12">
					  <div class="card">
						<div class="box-header with-border" style="height:60px">';
					
					 		$rspta2=$resultadovariables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]);//consulta para imprimir el icono
                            $data["0"] .=$rspta2["icono_tipo_pregunta"];
					
						  $data["0"] .= " <b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
					$data["0"] .='
						  <div class="box-tools float-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						  </div>
						</div>';
					 
					$rsptacantdep=$resultadovariables->respuestaPorVariableDep($id_categoria,$rspta[$i]["id_variable"]);
					 for ($j=0;$j<count($rsptacantdep);$j++)// bucle para imprimir las opciones del select
						{
						 $data["0"] .='<div class="box-body">';
							 $departamento=$rsptacantdep[$j]["respuesta"];
							 $data["0"] .=$departamento;
								$rsptacountdep=$resultadovariables->respuestaTotalDep($departamento);
						 		$data["0"] .='<span class="float-right badge bg-blue">'.count($rsptacountdep).'</span>';
								
						 $data["0"] .='</div>';
						 
					 	}
					 
						$data["0"] .='  
						</div>
					  </div>
					</div>';
                    
                }  
                
                else if($rspta[$i]["id_tipo_pregunta"]==6){// se ejecuta cuando la pregunta es de tipo municipio
                    
                    if($rspta[$i]["obligatoria"]==1){$obligatoria="required";} else{$obligatoria="";}// condición para saber si es obligatiro el campo
                    if($rspta[$i]["estado_variable"]==1){$borde="";} else{$borde="border: solid 1px #FF0000";}// condición para saber si esta activada
                    
                   $data["0"] .='
					<div class="col-xl-4 col-lg-6 col-md-12 col-12">
					  <div class="card">
						<div class="box-header with-border" style="height:60px">';
					
					 		$rspta2=$resultadovariables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]);//consulta para imprimir el icono
                            $data["0"] .=$rspta2["icono_tipo_pregunta"];
					
						  $data["0"] .= " <b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
					$data["0"] .='
						  <div class="box-tools float-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						  </div>
						</div>';
					 
					$rsptacantmun=$resultadovariables->respuestaPorVariableDep($id_categoria,$rspta[$i]["id_variable"]);
					 for ($j=0;$j<count($rsptacantmun);$j++)// bucle para imprimir las opciones del select
						{
						 $data["0"] .='<div class="box-body">';
							 $municipio=$rsptacantmun[$j]["respuesta"];
							 $data["0"] .=$municipio;
								$rsptacountmun=$resultadovariables->respuestaTotalDep($municipio);
						 		$data["0"] .='<span class="float-right badge bg-blue">'.count($rsptacountmun).'</span>';
								
						 $data["0"] .='</div>';
						 
					 	}
					 
						$data["0"] .='  
						</div>
					  </div>
					</div>';
                    
                } 
				
				
				else if($rspta[$i]["id_tipo_pregunta"]==7){// se ejecuta cuando la pregunta es condicional
                    
                    if($rspta[$i]["obligatoria"]==1){$obligatoria="required";} else{$obligatoria="";}// condición para saber si es obligatiro el campo
                    if($rspta[$i]["estado_variable"]==1){$borde="";} else{$borde="border: solid 1px #FF0000";}// condición para saber si esta activada
					
					$rsptausuarios=$resultadovariables->totalUsuarios($rspta[$i]["id_categoria"]);// consulta para ver el total de usuarios
					$total_usuarios=count($rsptausuarios);// variable que contiene el total de usuarios
					 
				$data["0"] .='
					<div class="col-xl-4 col-lg-6 col-md-12 col-12">
					  <div class="card">
						<div class="box-header with-border" style="height:60px">';
					
					 		$rspta2=$resultadovariables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]);//consulta para imprimir el icono
                            $data["0"] .=$rspta2["icono_tipo_pregunta"];
					
						  $data["0"] .= " <b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
					 
				
					 
					 
					$data["0"] .='
						  <div class="box-tools float-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						  </div>
						</div>
						<div class="box-body caja_variables">';
					  $variables_opciones=$resultadovariables->listarVariableOpciones($rspta[$i]["id_variable"]);// consulta para traer los values del select

					 $data["0"] .= "<table class='table table-bordered'>";					 
							for ($j=0;$j<count($variables_opciones);$j++)// bucle para imprimir las opciones del select
								{
								$respuesta=$variables_opciones[$j]["nombre_opcion"];// contiene la respuesta
								$respuesta_id_variable=$variables_opciones[$j]["id_variables_opciones"];// contiene la respuesta en id
									$rsptacant=$resultadovariables->respuestaPorVariable($id_categoria,$rspta[$i]["id_variable"],$respuesta_id_variable);
										$porcentaje=(count($rsptacant)*100)/$total_usuarios;// formula para calcular el porcentaje 
										$porcentaje=round($porcentaje,0);// quitar decimales al porcentaje
									$data["0"] .= "<tr>";
										$data["0"] .= "<td width='70%'>";
											$data["0"] .= "<span>" . $respuesta ."</span>";
										$data["0"] .= "</td>";
										$data["0"] .= "<td align='center'>";
											$data["0"] .='<a onclick=verEstudiantes('.$id_categoria.','.$rspta[$i]["id_variable"].','.$respuesta_id_variable.') class="btn btn-primary btn-xs">'.count($rsptacant).'</a>';	
										$data["0"] .= "</td>";
										$data["0"] .= "<td align='center'>";
											$data["0"] .='<span class="badge bg-orange">'.$porcentaje.'%</span>';
										$data["0"] .= "</td>";
								$data["0"] .= "</tr>";
								}
					 			
						$data["0"] .= "</table>";
					
						
					 $data["0"] .='
					 	</div>
					  </div>
					</div>';					 

                }
				
				
				else if($rspta[$i]["id_tipo_pregunta"]==8){// se ejecuta cuando la pregunta es de tipo respuesta corta
                    
                    if($rspta[$i]["obligatoria"]==1){$obligatoria="required";} else{$obligatoria="";}// condición para saber si es obligatiro el campo
                    if($rspta[$i]["estado_variable"]==1){$borde="";} else{$borde="border: solid 1px #FF0000";}// condición para saber si esta activada
					
					$rsptausuarios=$resultadovariables->totalUsuarios($rspta[$i]["id_categoria"]);// consulta para ver el total de usuarios
					$total_usuarios=count($rsptausuarios);// variable que contiene el total de usuarios
					 
					 
				$data["0"] .='
					<div class="col-xl-4 col-lg-6 col-md-12 col-12">
					  <div class="card">
						<div class="box-header with-border" style="height:60px">';
					
						$rspta2=$resultadovariables->listarTipoPregunta($rspta[$i]["id_tipo_pregunta"]);//consulta para imprimir el icono
						$data["0"] .=$rspta2["icono_tipo_pregunta"];
					
					  	$data["0"] .= " <b>".$rspta[$i]["nombre_variable"]. ' (<span class="text-success">' . $obligatoria ."</span>) </b>"; // variable que contiene el nombre del campo
					 
					 	$rsptapre=$resultadovariables->listarVariablePre($rspta[$i]["prerequisito"]);// consulta para saber con que esta relacionada
                     	$data["0"] .= $rsptapre["nombre_variable"];// imprime la variable con que se relaciono
					 
					 
						$data["0"] .='
						  <div class="box-tools float-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						  </div>
						</div>
						<div class="box-body caja_variables">';
					  $respuestas=$resultadovariables->totalRespuestasVariable($rspta[$i]["id_variable"]);// consulta para traer los values del select

					 $data["0"] .= "<table class='table table-bordered'>";					 
							for ($j=0;$j<count($respuestas);$j++)// bucle para imprimir las opciones del select
								{
								
									$data["0"] .= "<tr>";
										$data["0"] .= "<td width='70%'>";
											$data["0"] .= "<span>" . $respuestas[$j]["respuesta"] ."</span>";
										$data["0"] .= "</td>";
										$data["0"] .= "<td align='center'>";
											$data["0"] .='<span class="badge bg-blue">'.$respuestas[$j]["id_usuario"].'</span>';	
										$data["0"] .= "</td>";
										
								$data["0"] .= "</tr>";
								
								}
					 			
					$data["0"] .= "</table>";						
				 $data["0"] .='
					</div>
				  </div>
				</div>';					 
  
                }
				
				

            }
		 $data["0"] .='</div>';
 		$results = array($data);
 		echo json_encode($results);

	break; 
		
	case 'listarEstudiantes':
		$id_categoria=$_GET["id_categoria"];// metodo post que captura el id_categoria
		
		$listado=$resultadovariables->listarEstudiantes($id_categoria);// consulta para traer los estudiantes
		//Vamos a declarar un array
		$data= Array();
		
		 for ($i=0;$i<count($listado);$i++){
			$id_credencial=$listado[$i]["id_usuario"];// variable que contiene la credencial
			$listadoDatos=$resultadovariables->listarEstudiantesDatos($id_credencial);// consulta para traer los datos de los estudiantes
			if($listadoDatos["fecha_nacimiento"]="0000-00-00"){
				$calcularedad="sin fecha";
			}else{
				$calcularedad=$resultadovariables->calculaEdad($listadoDatos["fecha_nacimiento"]);
			}
			

 			$data[]=array(
				"0"=>$id_credencial,
 				"1"=>$listadoDatos["credencial_identificacion"],
 				"2"=>$listadoDatos["credencial_nombre"] .' '. $listadoDatos["credencial_nombre_2"] .' '. $listadoDatos["credencial_apellido"] .' '. $listadoDatos["credencial_apellido_2"],
				"3"=>$listadoDatos["genero"],
				"4" => $calcularedad,
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
		
	case 'verEstudiantes':
		$id_categoria=$_GET["id_categoria"];// metodo post que captura el id_categoria
		$id_variable=$_GET["id_variable"];// metodo post que captura el id_categoria
		$respuesta_id_variable=$_GET["respuesta_id_variable"];// metodo post que captura el id_categoria
		$listado = $resultadovariables->listarEstudiantesRespuestas($id_categoria,$id_variable,$respuesta_id_variable);// consulta para traer los estudiantes
		
		//Vamos a declarar un array
		$data = Array();
		
		for ($i=0;$i<count($listado);$i++){
			$id_credencial=$listado[$i]["id_usuario"];// variable que contiene la credencial
			 
 			$data[] = array(
				"0"=>$id_credencial,
 				"1"=>$listado[$i]["credencial_identificacion"],
 				"2"=>$listado[$i]["credencial_nombre"] .' '. $listado[$i]["credencial_nombre_2"] .' '. $listado[$i]["credencial_apellido"] .' '. $listado[$i]["credencial_apellido_2"],
				"3"=>$listado[$i]["genero"],
				"4"=>$resultadovariables->calculaEdad($listado[$i]["fecha_nacimiento"]),
				"5"=>$listado[$i]["celular"],
				"6"=>$listado[$i]["email"],
				"7"=>$listado[$i]["credencial_login"],
				"8"=>$listado[$i]["periodo"]
			);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
   
    
		
}
?>