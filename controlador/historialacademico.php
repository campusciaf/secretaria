<?php 
session_start();
require_once "../modelos/HistorialAcademico.php";

$historialacademico=new HistorialAcademico();
$periodo_actual=$_SESSION['periodo_actual'];
$id_credencial=$_SESSION['id_usuario'];

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d-H:i:s');


switch ($_GET["op"]){

	case 'listar':

		$rspta=$historialacademico->listar($id_credencial);
 		//Vamos a declarar un array
 		$data= Array();

			$i = 0;			
			while ($i < count($rspta)){
				$id_estudiante=$rspta[$i]["id_estudiante"];
				$rspta2=$historialacademico->listarEstado($rspta[$i]["estado"]);
				
				$data[]=array(
				"0"=>'		  
				<button id="t-paso2" class="btn btn-primary btn-xs" onclick="mostrarmaterias('.$rspta[$i]["id_programa_ac"].','.$rspta[$i]["ciclo"].','.$id_estudiante.')" title="Ver Historial"><i class="fas fa-plus-square"></i> Ver Historial</button>',
 				"1"=>$rspta[$i]["fo_programa"],
				"2"=>$rspta[$i]["jornada_e"],
				"3"=>$rspta[$i]["semestre_estudiante"],
				"4"=>$rspta[$i]["grupo"],
				"5"=>$rspta2["estado"],
				"6"=>$rspta[$i]["periodo_activo"],
					
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

		$rspta = $historialacademico->mostrardatos($id_credencial);
		$data= Array();
		$data["0"] ="";

					   
					   	if (file_exists('../files/estudiantes/'.$rspta["credencial_identificacion"].'.jpg')) {
							$foto='<img src=../files/estudiantes/'.$rspta["credencial_identificacion"].'.jpg class=img-circle img-bordered-sm>';
						}else{
							$foto='<img src=../files/null.jpg width=50px height=50px class=img-circle img-bordered-sm>';
						}
					 
		
					$data["0"] .= '
					<div style="margin:2%">
						<div class="user-block">
						'.$foto.'
							<span class="username">
							  <a href="#">'.$rspta["credencial_nombre"].' '.$rspta["credencial_nombre_2"].' '.$rspta["credencial_apellido"].' '.$rspta["credencial_apellido_2"].'
							</span>
						<span class="description">'.$rspta["credencial_login"].'</span>
					  </div>
					</div>
					
					
					';
				
		$results = array($data);
 		echo json_encode($results);
	
		
	break;
		
	case "mostrarmaterias":
		$data= Array();
		$data["0"] ="";
		
		$id_programa_ac=$_POST["id_programa_ac"];
		$id_estudiante=$_POST["id_estudiante"];
		
		//consulta para ver los datos del programa
		$rspta2 = $historialacademico->datosPrograma($id_programa_ac);
		$reg2=$rspta2;
		
		$semestres_del_programa=$reg2["semestres"];
		$nombre_programa=$reg2["nombre"];
		$ciclo="materias".$reg2["ciclo"];// para saber en que tabla debe busar las materias
		$cortes=$reg2["cortes"];// para saber en que tabla debe busar las materias
		$inicio_cortes=1;
		
		//consulta para ver los datos del programa en que se matriculo el estudiante
		$rspta4 = $historialacademico->datosEstudiante($id_credencial);
		$reg4=$rspta4;
		
		$jornada_estudio=$reg4["jornada_e"];
		
		$semestres=1;
		
		$data["0"] .= '
		
			<div class="row">
				<div class="col-6 tono-3 py-4">
					<div class="row align-items-center">
						<div class="col-auto pl-4">
							<span class="rounded bg-light-blue p-3 text-primary ">
								<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
							</span> 
						</div>
						<div class="col-10 line-height-18">
							<span class="">Historial</span> <br>
							<span class="text-semibold fs-14">'.$nombre_programa.'</span> 
						</div>
					</div>
				</div>
				<div class="col-6 pt-4 pr-4">
					<a onClick="volver()" id="volver" class="btn btn-danger text-white float-right"><i class="fas fa-arrow-circle-left"></i> Volver</a>
				</div>';
			
			
				while($semestres <= $semestres_del_programa){
				

					$data["0"] .='
					<div class="col-12 p-4">
						<h3 class="fs-18 text-semibold">Semestre ' .$semestres.'</h3>';
							$data["0"] .='	
							<table class="table table-hover">
								<thead>
									<th>Asignaturas</th>';

									//for ($i=1; $i <= $cortes; $i++) { 
									//$data["0"] .= '<th>C'.$i.'</th>';
									//}

									$data["0"] .='<th>Promedio</th>
								</thead>
								<tbody>';
							
								$rspta = $historialacademico->listarMaterias($id_estudiante,$ciclo,$semestres);
								$reg=$rspta;

								for ($i=0;$i<count($reg);$i++){
									$materia=$reg[$i]["nombre_materia"];// nombre de la materia 
									if($reg[$i]["promedio"]>=2.95){
										$promedio="Aprobado";
									}else{
										$promedio="No aprobado";
									}

									$data["0"] .='
									<tr>
										<td>'.$materia.'</td>';
									
										$inicio_cortes=1;
										$corte_nota="";
										//while($inicio_cortes <= $cortes){
										//$corte_nota="c".$inicio_cortes;
											//$data["0"] .= '<td class="ancho-sm-fijo">'.$reg[$i][$corte_nota].'</td>';
											//$inicio_cortes++;
										//}

							
										$da = $historialacademico->valorhuella();
										$data["0"] .='
										<td class="ancho-sm-fijo">'.$reg[$i]["promedio"].'</td>
									</tr>';
								}// cierra el for
							
							
								
								$data["0"] .=' 
								</tbody>
							</table>
					</div>';
						
					
					$semestres++;
					
				}//cierra el while
		
			$data["0"] .='
			</div>';
		
		
		$results = array($data);
 		echo json_encode($results);
	
		
	break;	

	
	
		
	case "eliminarMateria":	
		$usuario=$_SESSION['usuario_cargo'];
		
		$id_estudiante=$_POST["id_estudiante"];
		$id_materia=$_POST["id_materia"];
		$semestres_del_programa=$_POST["semestres_del_programa"];
		$id_materia_matriculada=$_POST["id_materia_matriculada"];
		$promedio_materia_matriculada=$_POST["promedio_materia_matriculada"];
		
		$rspta2 =$historialacademico->MateriaDatos($id_materia);
		$nombre_materia=$rspta2["nombre"];
		$semestre=$rspta2["semestre"];
		$creditos=$rspta2["creditos"];
		
		$rspta3 =$historialacademico->datosEstudiante($id_estudiante);
		$id_programa_ac=$rspta3["id_programa_ac"];
		$jornada_e=$rspta3["jornada_e"];// trae la jornada de estudio del estudiante
		$programa=$rspta3["fo_programa"];
		$ciclo=$rspta3["ciclo"];
		
		$rspta9 = $historialacademico->trazabilidadMateriaEliminada($id_estudiante,$nombre_materia,$jornada_e,$periodo_actual,$semestre,$promedio_materia_matriculada,$programa,$fecha,$usuario);
		
		$rspta4 = $historialacademico->eliminarMateria($id_materia_matriculada,$ciclo);
		
		if($rspta4){


			$rspta6 = $historialacademico->creditosMatriculados($id_estudiante,$ciclo);//suma el total de creditos matriculados
			$creditos_matriculados=$rspta6["suma_creditos"];

			$rspta7 = $historialacademico->datosPrograma($id_programa_ac);// trae creditos por semestre
			$inicio_semestre=$rspta7["inicio_semestre"];
			$semestre_nuevo=0;
			$suma_creditos_tabla=0;

			while($inicio_semestre <= $semestres_del_programa){
				$campo="c".$inicio_semestre;

				$semestre_nuevo++;		
				$suma_creditos_tabla+=$rspta7[$campo];

				if($creditos_matriculados <= $suma_creditos_tabla){
					$inicio_semestre = $semestres_del_programa+1;

				}else{

					$inicio_semestre++;
				}

			}
			$rspta8 = $historialacademico->actualizarsemestre($id_estudiante,$semestre_nuevo);// trae creditos por semestre
			
			
		}
		echo json_encode($rspta4);
	break;
		
	case "selectJornada":	
		$rspta = $historialacademico->selectJornada();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
		
	case "selectPrograma":	
		$rspta = $historialacademico->selectPrograma();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["original"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
		
	case "selectPeriodo":	
		$rspta = $historialacademico->selectPeriodo();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"]. "</option>";
				}
	break;
		
	case "selectGrupo":	
		$rspta = $historialacademico->selectGrupo();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["grupo"] . "'>" . $rspta[$i]["grupo"]. "</option>";
				}
	break;	

	case "actualizarJornada":
		$id_materia=$_POST["id_materia"];
		$ciclo=$_POST["ciclo"];
		$jornada_e=$_POST["jornada_e"];
		$id_estudiante=$_POST["id_estudiante"];
		$id_programa_ac=$_POST["id_programa_ac"];
		
		$data= Array();
		$data["0"] ="";
		
		$rspta = $historialacademico->actualizarJornada($id_materia,$jornada_e,$ciclo);
		
			
			$data["0"] .=$id_programa_ac;
			$data["1"] = $id_estudiante;

		$results = array($data);
 		echo json_encode($results);
		
	break;
		
	case "actualizarPeriodo":
		
		$id_materia=$_POST["id_materia_j"];
		$ciclo=$_POST["ciclo_j"];
		$periodo=$_POST["periodo"];
		$id_estudiante=$_POST["id_estudiante_j"];
		$id_programa_ac=$_POST["id_programa_ac_j"];
		
		$data= Array();
		$data["0"] ="";
		
		$rspta = $historialacademico->actualizarPeriodoMateria($id_materia,$periodo,$ciclo);
		
			
			$data["0"] .=$id_programa_ac;
			$data["1"] = $id_estudiante;

		$results = array($data);
 		echo json_encode($results);
		
	break;
		
	case "actualizarGrupo":
		
		$id_materia=$_POST["id_materia_g"];
		$ciclo=$_POST["ciclo_g"];
		$grupo=$_POST["grupo"];
		$id_estudiante=$_POST["id_estudiante_g"];
		$id_programa_ac=$_POST["id_programa_ac_g"];
		
		$data= Array();
		$data["0"] ="";
		
		$rspta = $historialacademico->actualizarGrupoMateria($id_materia,$grupo,$ciclo);
		
			
			$data["0"] .=$id_programa_ac;
			$data["1"] = $id_estudiante;

		$results = array($data);
 		echo json_encode($results);
		
	break;

	case 'huella':
		
		$id = $_POST['id'];
		$val = $_POST['val'];
		$c = $_POST['c'];
		$historialacademico->huella($id,$val,$c);
	break;
	case 'nota':
		$id = $_POST['id'];
		$nota = $_POST['nota'];
		$tl = $_POST['tl'];
		$c = $_POST['c'];
		$pro = $_POST['pro'];
		$historialacademico->agreganota($id,$nota,$tl,$c,$pro);
	break;

	case 'promedio':
		$id = $_POST['id'];
		$val = $_POST['val'];
		$c = $_POST['c'];
		$historialacademico->promedio($id,$val,$c);
	break;
}
?>