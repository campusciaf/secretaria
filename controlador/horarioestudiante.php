<?php 
session_start();
require_once "../modelos/HorarioEstudiante.php";

$horarioestudiante=new HorarioEstudiante();
$periodo_actual=$_SESSION['periodo_actual'];

date_default_timezone_set("America/Bogota");	

	$fecha=date('Y-m-d-H:i:s');

$id_credencial=isset($_POST["id_credencial"])? limpiarCadena($_POST["id_credencial"]):"";


switch ($_GET["op"]){
		

				
		
	case 'verificardocumento': 
		$credencial_identificacion=$_POST["credencial_identificacion"];
		$rspta=$horarioestudiante->verificardocumento($credencial_identificacion);
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";
		$reg=$rspta;
		if(count($reg)==0){
			$data["0"] .=$credencial_identificacion;
			$data["1"] = false;
		}else{
			for ($i=0;$i<count($reg);$i++){	
				$data["0"] .= $reg[$i]["id_credencial"];
			}
			$data["1"] = true;
		}
		
		$results = array($data);
 		echo json_encode($results);
		
	break;
		
	case 'listar':
		$id_credencial=$_GET["id_credencial"];
		$rspta=$horarioestudiante->listar($id_credencial);
 		//Vamos a declarar un array
 		$data= Array();

			$i = 0;			
			while ($i < count($rspta)){
				
				$rspta2=$horarioestudiante->listarEstado($rspta[$i]["estado"]);
				
				$data[]=array(
				"0"=>'
						  
				<button class="btn btn-primary btn-xs" onclick="mostrarmaterias('.$rspta[$i]["id_estudiante"].','.$rspta[$i]["ciclo"].','.$rspta[$i]["id_programa_ac"].','.$rspta[$i]["grupo"].')" title="Ver horario"><i class="fas fa-plus-square"></i> Ver Horario</button>',
				
				"1"=>$rspta[$i]["id_estudiante"],
 				"2"=>$rspta[$i]["fo_programa"],
				"3"=>$rspta[$i]["jornada_e"],
				"4"=>$rspta[$i]["semestre_estudiante"],
				"5"=>$rspta[$i]["grupo"],
				"6"=>$rspta2["estado"],
				"7"=>$rspta[$i]["periodo"],
				"8"=>$rspta[$i]["periodo_activo"],
					
 				);
				$i++;
			}
		
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "mostrardatos":
		$id_credencial=$_POST["id_credencial"];
		$rspta = $horarioestudiante->mostrardatos($id_credencial);
		$data= Array();
		$data["0"] ="";

					   
				if (file_exists('../files/estudiantes/'.$rspta["credencial_identificacion"].'.jpg')) {
					$foto='<img src=../files/estudiantes/'.$rspta["credencial_identificacion"].'.jpg class="img-circle img-bordered-sm" width=50px height=50px> ';
				}else{
					$foto='<img src=../files/null.jpg width=40px height=40px class="rounded-circle">';
				}
				

			$data["0"] .= '

			<div class="row">

                    <div class="col-12">
                      <h3 class="titulo-2 fs-14">Datos estudiante:</h3>
                    </div>

                    <div class="col-4 px-2 py-2 ">
                      <div class="row align-items-center">
                          <div class="col-2">
							'.$foto.'
                          </div>
                          <div class="col-10">
                            <span class="">'.$rspta["credencial_nombre"].' '.$rspta["credencial_nombre_2"].'</span> <br>
                            <span class="text-semibold fs-12">'.$rspta["credencial_apellido"].' '.$rspta["credencial_apellido_2"].'</span> 
                          </div>
                      </div>
                    </div>

                    <div class="col-4 px-2 py-2 ">
                      <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="rounded bg-light-red p-2 text-danger">
                              <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                            </span>
                          </div>
                          <div class="col-10">
                            <span class="">Correo electrónico</span> <br>
                            <span class="text-semibold fs-12">'.$rspta["credencial_login"].'</span> 
                          </div>
                      </div>
                    </div>

                    <div class="col-4 px-2 py-2 ">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="rounded bg-light-green p-2 text-success">
                            <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                          </span> 
                        </div>
                        <div class="col-10">
                          <span class="">Número celular</span> <br>
                          <span class="text-semibold fs-14">'.$rspta["celular"].'</span> 
                        </div>
                      </div>
                    </div>
                  </div>

			<div class="row bg-success rounded-left">
				<div class="user-block">
				
					<span class="username">
						 
					</span>
				<span class="description text-white"></span>
				</div>
			</div>
			
			
			';
				
		$results = array($data);
 		echo json_encode($results);
	
		
	break;


		
		
	case 'mostrarmaterias':
		
		$id=$_POST["id"];// id del estudiante
		$ciclo=$_POST["ciclo"];// ciclo
		$id_programa=$_POST["id_programa"];// programa del estudiante
		$grupo=$_POST["grupo"];// programa del estudiante
		
		$rspta=$horarioestudiante->listarDos($id,$ciclo,$grupo);

		$rspta2 = $horarioestudiante->programaacademico($id_programa);	
		
		$cortes=$rspta2["cortes"];
		$inicio_cortes=1;
		
		
		
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";

		//$data["0"] .= '<a onclick="listarHorario('.$id_programa.','.$ciclo.','.$grupo.','.$id.')" class="btn btn-primary float-right"> Descargar Horario </a><br><br>';
		$data["0"] .= '
		<div class="row">
			<div class="card col-12 table-responsive">	
				<table id="example" class="table table-hover" style="width:100%">
					<thead>
						<tr>
							<th>Asignatura</th>
							<th >Foto</th>
							<th >Docente</th>
							
							';
					while($inicio_cortes <= $cortes){
						$data["0"] .= '<th >C'.$inicio_cortes.'</th>';
						$inicio_cortes++;
					}
					
					$data["0"] .= '

							<th >Final</th>
							<th >Horario</th>
							<th >Faltas</th>
							<th >Salón</th>
							<th >Corte</th>
							<th >Modelo</th>
						</tr>
					</thead>
					<tbody>';
					
					$reg=$rspta;

					if($ciclo == 9){
						$num_id=1;

						for ($i=0;$i<count($reg);$i++){
						


						$buscaridmateria=$horarioestudiante->buscaridmateria_h($id_programa,$reg[$i]["nombre_materia"]);
						$idmateriaencontrada=$buscaridmateria["id_materia"];
						$modelo=$buscaridmateria["modelo"];

						if($modelo==1){// si es presencial
							$modelo ='<span class="badge badge-primary float-right">Presencial</span>';
							}else{// es modelo pat
								$modelo ='<span class="badge bg-maroon float-right">PAT</span>';
							}
						
						$rspta3 = $horarioestudiante->docente_grupo_horario($idmateriaencontrada);
						@$id_docente=$rspta3[$i]["id_docente"];
						@$id_docente_grupo=$rspta3[$i]["id_docente_grupo"];
						


						@$dia=$rspta3[$i]["dia"];
						@$hora=$rspta3[$i]["hora"];
						@$hasta=$rspta3[$i]["hasta"];
						$huella=$reg[$i]["huella"];

						@$salon=$rspta3["salon"];
						@$corte=$rspta3["corte"];


						if($id_docente==true){// si existe grupo
							$rspta4 = $horarioestudiante->docente_datos($id_docente);
							
							if (file_exists('../files/docentes/'.$rspta4["usuario_identificacion"].'.jpg')) {
								$foto='<img src=../files/docentes/'.$rspta4["usuario_identificacion"].'.jpg width=50px height=50px class=img-circle>';
							}else{
								$foto='<img src=../files/null.jpg width=50px height=50px class=img-circle>';
							}
			
							$nombre_docente=$rspta4["usuario_nombre"]. ' ' . $rspta4["usuario_nombre_2"].' <br>' . $rspta4["usuario_apellido"]. ' ' . $rspta4["usuario_apellido_2"];
			
							
							$dia_clase=$dia.' <br> '. $hora.' - '.$hasta;
						}else{

							
							$foto='<img src=../files/null.jpg width=50px height=50px class=img-circle>';
							$nombre_docente="";
							$dia_clase="";

						}

						

						if($huella ==""){

							$data["0"] .= '
							<tr>
								
								<td>
								
								<span id='.$num_id.'>
								';
									if($reg[$i]["id_pea"]!=""){
										$data["0"] .= '
											<a onclick=verPea('.$id_docente_grupo.') class="btn btn-success btn-xs" title="Plan Educativo de Aula">PEA</a>
											';
									}else{
										$data["0"] .= '
											<a onclick=validarPea('.$num_id.','.$ciclo.','.$reg[$i]["id_materia"].','.$id_docente_grupo.') class="btn btn-danger btn-xs" title="PLan Educativo sin Activar">PEA</a>
											';
										
									}
									
							$data["0"] .= '
								</span>
								<span id="mostrar_'.$num_id.'" style="display:none">
									<a onclick=verPea('.$id_docente_grupo.') class="btn btn-success btn-xs" title="Plan Educativo de Aula">PEA</a>
								</span>
								
									<span class="label label-default" title="Créditos">['.$reg[$i]["creditos"].']</span> '.
									$reg[$i]["nombre_materia"] .'
								</td>
								<td>'.
									$foto.'
								</td>
								<td>'.$nombre_docente.'
								</td>';
							
							$inicio_cortes=1;
							$corte_nota="";
							while($inicio_cortes <= $cortes){
								$corte_nota="c".$inicio_cortes;
								$data["0"] .= '<td>'.$reg[$i][$corte_nota].'</td>';
								$inicio_cortes++;
							}
							
					
					
						
					$data["0"] .= '	
			
							<td>'.$reg[$i]["promedio"].'</td>
							
							<td>' .$dia_clase.'</td>
							
							<td>'.$reg[$i]["faltas"].'</td>
							<td>'.$salon.'</td>
							<td>'.$corte.'</td>
							<td>'.$modelo.'</td>
							
						</tr>
						';
						$num_id++;

						}

					
					
					
					
					}


				}else{

					$num_id=1;
						for ($i=0;$i<count($reg);$i++){
			
						$buscaridmateria=$horarioestudiante->buscaridmateria($id_programa,$reg[$i]["nombre_materia"]);
						$idmateriaencontrada=$buscaridmateria["id"];

						$modelo=$buscaridmateria["modelo"];

						if($modelo==1){// si es presencial
							$modelo ='<span class="badge badge-primary float-right">Presencial</span>';
							}else{// es modelo pat
								$modelo ='<span class="badge bg-maroon float-right">PAT</span>';
							}
						
						$rspta3 = $horarioestudiante->docente_grupo($idmateriaencontrada,$reg[$i]["jornada"],$reg[$i]["periodo"],$reg[$i]["semestre"],$id_programa,$grupo);

						
						// id docente grupo especial
						$id_docente_grupo_esp = $reg[$i]["id_docente_grupo_esp"];
						$rspta4 = $horarioestudiante->docente_grupo_por_id($id_docente_grupo_esp);
						// si existe registro
						$resultadorspta4 = $rspta4 ? 1 : 0;

						if($resultadorspta4==1){// si es un grupo especial
							@$id_docente=$rspta4["id_docente"];
							@$id_docente_grupo=$rspta4["id_docente_grupo"];
							@$dia=$rspta4["dia"];
							@$hora=$rspta4["hora"];
							@$hasta=$rspta4["hasta"];

							@$salon=$rspta4["salon"];
							@$corte=$rspta4["corte"];
							$codigo="<span class='badge badge-danger'>Esp</span>";
						}else{
							@$id_docente=$rspta3["id_docente"];
							@$id_docente_grupo=$rspta3["id_docente_grupo"];
							@$dia=$rspta3["dia"];
							@$hora=$rspta3["hora"];
							@$hasta=$rspta3["hasta"];

							@$salon=$rspta3["salon"];
							@$corte=$rspta3["corte"];
							$codigo="";
						}


						
						if($id_docente==true){// si existe grupo
							$rspta4 = $horarioestudiante->docente_datos($id_docente);
							
							if (file_exists('../files/docentes/'.$rspta4["usuario_identificacion"].'.jpg')) {
								$foto='<img src=../files/docentes/'.$rspta4["usuario_identificacion"].'.jpg width=40px height=40px class=img-circle>';
							}else{
								$foto='<img src=../files/null.jpg width=40px height=40px class=img-circle>';
							}
			
							$nombre_docente=$rspta4["usuario_nombre"]. ' ' . $rspta4["usuario_nombre_2"].' <br>' . $rspta4["usuario_apellido"]. ' ' . $rspta4["usuario_apellido_2"];
			
							
							$dia_clase=$dia.' <br> '. $hora.' - '.$hasta;
						}else{
							$foto='<img src=../files/null.jpg width=50px height=50px class=img-circle>';
							$nombre_docente="";
							$dia_clase="";
						}
						
					$data["0"] .= '
						<tr>
							
							<td>
							
							<span id='.$num_id.'>';
								if($reg[$i]["id_pea"]!=""){
									$data["0"] .= '
										<a onclick=verPea('.$id_docente_grupo.') class="btn btn-success btn-xs" title="Plan Educativo de Aula">PEA</a>
										';
								}else{
									$data["0"] .= '
										<a onclick=validarPea('.$num_id.','.$ciclo.','.$reg[$i]["id_materia"].','.$id_docente_grupo.') class="btn btn-danger btn-xs" title="PLan Educativo sin Activar">PEA</a>
										';
									
								}
								
						$data["0"] .= $codigo . '
							</span>
							<span id="mostrar_'.$num_id.'" style="display:none">
								<a onclick=verPea('.$id_docente_grupo.') class="btn btn-success btn-xs" title="Plan Educativo de Aula">PEA</a>
							</span>
							
								<span class="label label-default" title="Créditos">['.$reg[$i]["creditos"].']</span> '.
								$reg[$i]["nombre_materia"] .'
							</td>
							<td>'.
								$foto.'
							</td>
							<td>'.$nombre_docente.'
							</td>';
						
						$inicio_cortes=1;
						$corte_nota="";
						while($inicio_cortes <= $cortes){
							$corte_nota="c".$inicio_cortes;
							$data["0"] .= '<td>'.$reg[$i][$corte_nota].'</td>';
							$inicio_cortes++;
						}
						
					
					
					
						
					$data["0"] .= '	

							<td>'.$reg[$i]["promedio"].'</td>
							
							<td>' .$dia_clase.'</td>
							
							<td>'.$reg[$i]["faltas"].'</td>


							<td>'.$salon.'</td>
							<td>'.$corte.'</td>
							<td>'.$modelo.'</td>
							
						</tr>
						';
						$num_id++;
						}
					
				}
					$data["0"] .= '
						</tbody>
				</table>
			</div>
		</div>';
		
		$results = array($data);
 		echo json_encode($results);  
	break;	
		
		


}
?>