<?php 
session_start();
require_once "../modelos/EliminarMateria.php";
$eliminar_materia = new EliminarMateria();
$periodo_actual = $_SESSION['periodo_actual'];
date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d-H:i:s');
$id_credencial=isset($_POST["id_credencial"])? limpiarCadena($_POST["id_credencial"]):"";
$credencial_nombre=isset($_POST["credencial_nombre"])? limpiarCadena($_POST["credencial_nombre"]):"";
$credencial_nombre_2=isset($_POST["credencial_nombre_2"])? limpiarCadena($_POST["credencial_nombre_2"]):"";
$credencial_apellido=isset($_POST["credencial_apellido"])? limpiarCadena($_POST["credencial_apellido"]):"";
$credencial_apellido_2=isset($_POST["credencial_apellido_2"])? limpiarCadena($_POST["credencial_apellido_2"]):"";
$credencial_login=isset($_POST["credencial_login"])? limpiarCadena($_POST["credencial_login"]):"";
$fo_programa=isset($_POST["fo_programa"])? limpiarCadena($_POST["fo_programa"]):"";
$jornada_e=isset($_POST["jornada_e"])? limpiarCadena($_POST["jornada_e"]):"";
switch ($_GET["op"]){
	case 'verificardocumento': 
		$credencial_identificacion=$_POST["credencial_identificacion"];
		$rspta=$eliminar_materia->verificardocumento($credencial_identificacion);
 		$data = Array();
		$data["0"] ="";
		$reg = $rspta;
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
		$id_credencial = $_GET["id_credencial"];
		$rspta = $eliminar_materia->listar($id_credencial);
 		$data = Array();
        $i = 0;	
        while ($i < count($rspta)){
			$rspta2 = $eliminar_materia->listarEstado($rspta[$i]["estado"]);
            $data[]=array(
                "0"=>'<button class="btn btn-primary btn-xs" onclick="mostrarmaterias( '.$rspta[$i]["id_programa_ac"].', '.$rspta[$i]["id_estudiante"].')" title="Cancelar Materias"><i class="fas fa-plus-square"></i> Ver materias</button>',
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
		$id_credencial = $_POST["id_credencial"];
		$rspta = $eliminar_materia->mostrardatos($id_credencial);
		$cedula_estudiante = $rspta["credencial_identificacion"];
		$datos_personales_estudiante = $eliminar_materia->telefono_estudiante($cedula_estudiante);
		$celular_estudiante = $datos_personales_estudiante["celular"] ?? "";
		$data = array();
		$data["0"] = "";
			if (file_exists('../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg')) {
				$foto = '<img src=../files/estudiantes/' . $rspta["credencial_identificacion"] . '.jpg  width=35px height=35px class=img-circle img-bordered-sm>';
			} else {
				$foto = '<img src=../files/null.jpg width=35px height=35px class=img-circle img-bordered-sm>';
			}


			$data["0"] .= '
				<div class="row">
					<div class="col-4 py-2 ">
						<div class="row align-items-center">
							<div class="col-auto">
								<span class="rounded  text-gray ">
									'.$foto.'
								</span> 
							
							</div>
							<div class="col-10 line-height-16">
								<span class="fs-12">'.$rspta["credencial_nombre"].' '.$rspta["credencial_nombre_2"].'  </span> <br>
								<span class="text-semibold fs-12 titulo-2 line-height-16">'.$rspta["credencial_apellido"].' '.$rspta["credencial_apellido_2"].' </span> 
							</div>
						</div>
					</div>

					<div class="col-4 py-2">
						<div class="row align-items-center">
							<div class="auto">
								<span class="rounded bg-light-red p-2 text-red">
									<i class="fa-regular fa-envelope" aria-hidden="true"></i>
								</span> 
							
							</div>
							<div class="col-10">
								<span class="fs-12">Correo electrónico</span> <br>
								<span class="text-semibold fs-12 titulo-2 line-height-16">'.$rspta["credencial_login"].'</span> 
							</div>
						</div>
					</div>

					<div class="col-4 py-2">
						<div class="row align-items-center">
							<div class="col-auto">
								<span class="rounded bg-light-green p-2 text-success">
									<i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
								</span> 
							
							</div>
							<div class="col-10">
								<span class="fs-12">Número celular</span> <br>
								<span class="text-semibold fs-12 titulo-2 line-height-16">' . (!empty($celular_estudiante) ? $celular_estudiante : 'El estudiante no tiene número de teléfono registrado.') . '</span> 
							</div>
						</div>
					</div>
				</div>
			';
		$results = array($data);
		echo json_encode($results);
	break;

	case "mostrarmaterias":
		$id_programa_ac=$_POST["id_programa_ac"];
		$id_estudiante=$_POST["id_estudiante"];
		//consulta para ver los datos del programa
		$rspta2 = $eliminar_materia->datosPrograma($id_programa_ac);
		$reg2 = $rspta2;
		//consulta para ver los datos del programa en que se matriculo el estudiante
		$rspta4 = $eliminar_materia->datosEstudiante($id_estudiante);
		$reg4 = $rspta4;
		$jornada_estudio=$reg4["jornada_e"];
		$id_credencial = $reg4['id_credencial'];
		$data= Array();
		$data["0"] = "";
        $semestres_del_programa = $reg2["semestres"];
        $ciclo = "materias".$reg2["ciclo"];// para saber en que tabla debe busar las materias
        $cortes = $reg2["cortes"];// para saber en que tabla debe busar las materias

		if ($semestres_del_programa == 1) {
			$anchodiv = '<div class="col-xl-6 col-lg-6 col-md-6 col-12 p-2">';
		} else if ($semestres_del_programa == 2) {
			$anchodiv = '<div class="col-xl-6 col-lg-6 col-md-6 col-12 p-2">';
		} else if ($semestres_del_programa == 3) {
			$anchodiv = '<div class="col-xl-4 col-lg-4 col-md-4 col-12 p-2">';
		} else if ($semestres_del_programa == 4) {
			$anchodiv = '<div class="col-xl-3 col-lg-3 col-md-3 col-12 p-2">';
		} else if ($semestres_del_programa == 5) {
			$anchodiv = '<div class="col-xl-2 col-lg-2 col-md-3 col-12 p-2">';
		}


		$semestres = 1;

        while($semestres <= $semestres_del_programa){
			$data["0"] .= $anchodiv;
				$data["0"] .= '<div class="card col-12 ">';
					$data["0"] .= '<div class="row">';
						$data["0"] .= '
							<div class="col-12 p-2 tono-3">
								<div class="row align-items-center">
									<div class="col-auto">
										<span class="rounded bg-light-blue p-2 text-primary ">
											<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
										</span> 
									
									</div>
									<div class="col-10">
									<div class="col-5 fs-14 line-height-18"> 
										<span class="">Semestre</span> <br>
										<span class="titulo-2 line-height-16 fs-18">' . $semestres . '</span> 
									</div> 
									</div>
								</div>
							</div>';

							$color = "green";
							$rspta = $eliminar_materia->listarMaterias($id_programa_ac,$semestres);
							$reg = $rspta;
							for ($i=0; $i<count($reg); $i++){
								$id_materia=$reg[$i]["id"];
								$id_programa_ac=$reg[$i]["id_programa_ac"];
								$materia=$reg[$i]["nombre"];// nombre de la materia 
								$creditos=$reg[$i]["creditos"];
								$rspta3 = $eliminar_materia->datosMateriaMatriculada($ciclo, $id_estudiante, $materia, $semestres);
								$reg3=$rspta3;
								@$id_materia_matriculada=$reg3["id_materia"];
								@$promedio_materia_matriculada=$reg3["promedio"];
								@$grupo=$reg3["grupo"];
								if(@$periodo_actual != @$reg3["periodo"]){
									if(@$reg3["promedio"] > 0 and @$reg3["promedio"] < 3){
										$color="red";
									}else if(@$reg3["promedio"] >= 3){
										$color="green";
									}else{
										$color="white";
									}
								}

								$data["0"] .= '<div class="col-12 px-3">';
									$data["0"] .= '<div class="row">';
										$data["0"] .= '<div class="col-12 alert bg-light-'.$color.'">';
											$data["0"] .= '<div class="row">';
												$data["0"] .= '<div class="col-12 fs-14 titulo-2 line-height-16">
																	['.$creditos.'] ' . $materia .'
																</div>';
												$inicio_corte = 1;
												@$jornada_matriculada=$reg3['jornada'];
												@$periodo_matriculada=$reg3["periodo"];
												if($rspta3){
													$data["0"] .= '<div class="col-12 fs-14 titulo-2 line-height-16 py-2">';
														while($inicio_corte <= $cortes ){
															$nota="c".$inicio_corte;
															$tnota="C".$inicio_corte;
															$data["0"] .= '<span class="label label-default borde">' . $tnota .': '. $reg3[$nota] .'</span> ';
																$inicio_corte++;
														}
													
														if($reg3['promedio']> 0 and $reg3['promedio'] < 3) {
															$data["0"] .='<span class="badge badge-danger float-right text-white" title="Promedio">Promedio: ' .$reg3["promedio"] . '</span> ';
														}else if($reg3['promedio'] == 0) {
															$data["0"] .='<span class="badge badge-warning float-right text-white" title="Promedio">Promedio: ' .$reg3["promedio"] . '</span> ';
														}else{
															$data["0"] .='<span class="badge badge-success  float-right text-white" title="Promedio">Promedio: ' .$reg3["promedio"] . '</span> ';
														}
													$data["0"] .= '</div>';
													$data["0"] .= '<div class="col-12 fs-14 titulo-2 line-height-16 py-2">';

														if($periodo_actual != $reg3["periodo"]){
															$data["0"] .= '<i class="fa fa-calendar-alt"></i> '. $reg3["jornada"];
															$data["0"] .= ' <i class="fa fa-hourglass-start"></i> '.$reg3["periodo"];
															if ($reg3['promedio']>= 0 and $reg3['promedio'] < 3) {
																$data["0"] .= '
																	<a class="btn btn-success btn-xs float-right" onclick="cancelarMateria('.$id_credencial.', '.$id_estudiante.', '.$id_programa_ac.', '.$id_materia.', '.$semestres_del_programa.', '.$id_materia_matriculada.', '.$promedio_materia_matriculada.', `'.$reg3["periodo"].'`)" title="Cancelar Materia">Cancelar Materia</a> ';
															}
														}
													$data["0"] .= '</div>';
												}
											$data["0"] .= '</div>';	
										$data["0"] .= '</div>';
									$data["0"] .= '</div>';
								$data["0"] .= '</div>';
							}
					$data["0"] .='</div>
				</div>';
            $data["0"] .='</div>';
            $semestres++;	
        }
		$results = array($data);
 		echo json_encode($results);
	break;

	case "cancelarMateria":	
		$usuario=$_SESSION['usuario_cargo'];
		$id_credencial = $_POST['id_credencial'];
		$id_estudiante=$_POST["id_estudiante"];
		$id_programa_ac = $_POST['id_programa_ac'];
		$id_materia=$_POST["id_materia"];
		$semestres_del_programa=$_POST["semestres_del_programa"];
		$id_materia_matriculada=$_POST["id_materia_matriculada"];
		$promedio_materia_matriculada=$_POST["promedio_materia_matriculada"];
		$periodo = $_POST['periodo'];
		$rspta2 =$eliminar_materia->MateriaDatos($id_materia);
		$nombre_materia=$rspta2["nombre"];
		$semestre=$rspta2["semestre"];
		$creditos=$rspta2["creditos"];
		$rspta3 =$eliminar_materia->datosEstudiante($id_estudiante);
		$id_programa_ac=$rspta3["id_programa_ac"];
		$jornada_e=$rspta3["jornada_e"];// trae la jornada de estudio del estudiante
		$programa=$rspta3["fo_programa"];
		$ciclo=$rspta3["ciclo"];
		$rspta9 = $eliminar_materia->trazabilidadMateriaCancelada($id_credencial, $id_estudiante, $id_programa_ac, $id_materia, $nombre_materia, $promedio_materia_matriculada, $periodo, $usuario, $fecha);
		$rspta4 = $eliminar_materia->eliminarMateria($id_materia_matriculada,$ciclo);
		echo json_encode($rspta4);
	break;
}
?>