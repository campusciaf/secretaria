<?php
error_reporting(1); 
session_start();
require_once "../modelos/Homologacion.php";
$homologacion=new Homologacion();
$periodo_actual=$_SESSION['periodo_actual'];
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

$semestres=isset($_POST["semestres"])? limpiarCadena($_POST["semestres"]):"";


$ciclo_homologacion=isset($_POST["ciclo_homologacion"])? limpiarCadena($_POST["ciclo_homologacion"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		$credencial_identificacion = $_GET["credencial_identificacion"];
		$credencial_clave = md5($credencial_identificacion);
        $rspta=$homologacion->insertar($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave);
        $data["0"] = $rspta ? "Estudiante registrado(a) " : "No se pudo registrar el estudiante";
        $rspta=$homologacion->traeridcredencial($credencial_identificacion);
        $data["1"] =$rspta["id_credencial"];
        $results = array($data);
        echo json_encode($results);
	break;
	case 'verificardocumento': 
		$credencial_identificacion = $_POST["credencial_identificacion"];
		$rspta = $homologacion->verificardocumento($credencial_identificacion);
 		$data= Array();
		$data["0"] ="";
		$reg=$rspta;
		if(count($reg) == 0){
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
	
		$rspta=$homologacion->listar($id_credencial);
 		//Vamos a declarar un array
 		$data= Array();
        $i = 0;			
        while ($i < count($rspta)){
            $rspta2=$homologacion->listarEstado($rspta[$i]["estado"]);
            $data[]=array(
            "0"=>'<button class="btn btn-primary btn-xs" onclick="mostrarmaterias('.$rspta[$i]["id_programa_ac"].','.$rspta[$i]["id_estudiante"].')" title="Matricular Materias"><i class="fas fa-plus-square"></i> Materias</button>',
                "1"=>$rspta[$i]["id_estudiante"],
                "2"=>$rspta[$i]["fo_programa"],
                "3"=>$rspta[$i]["jornada_e"],
                "4"=>$rspta[$i]["semestre_estudiante"],
                "5"=>$rspta[$i]["grupo"],
                "6"=>$rspta[$i]["escuela_ciaf"],
                "7"=>$rspta2["estado"],
                "8"=>$rspta[$i]["periodo"],
                "9"=>$rspta[$i]["periodo_activo"],
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
		$rspta = $homologacion->mostrardatos($id_credencial);
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
				</div>';
		$results = array($data);
 		echo json_encode($results);
	break;

	// muestra las materias que tiene el estudiante registrado
	case "mostrarmaterias":
		$id_programa_ac=$_POST["id_programa_ac"];
		$id_estudiante=$_POST["id_estudiante"];
		//consulta para ver los datos del programa
		$rspta2 = $homologacion->datosPrograma($id_programa_ac);
		$reg2 = $rspta2;
		//consulta para ver los datos del programa en que se matriculo el estudiante
		$rspta4 = $homologacion->datosEstudiante($id_estudiante);
		$reg4 = $rspta4;
		$jornada_estudio = $reg4["jornada_e"];
		$data= Array();
		$data["0"] ="";
        $semestres_del_programa=$reg2["semestres"];
        $ciclo="materias".$reg2["ciclo"];// para saber en que tabla debe buscar las materias
        $cortes=$reg2["cortes"];// para saber en que tabla debe busar las materias
		$anchodiv=0;
		
		if($semestres_del_programa==1){
			$anchodiv .='<div class="col-xl-6 col-lg-6 col-md-6 col-12">';
		}
		else if($semestres_del_programa==2){
			$anchodiv .='<div class="col-xl-6 col-lg-6 col-md-6 col-12">';
		}
		else if($semestres_del_programa==3){
			$anchodiv .='<div class="col-xl-4 col-lg-4 col-md-4 col-12">';
		}
		else if($semestres_del_programa==4){
			$anchodiv .='<div class="col-xl-3 col-lg-3 col-md-3 col-12">';
		}
		else if($semestres_del_programa==5){
			$anchodiv .='<div class="col-xl-2 col-lg-2 col-md-3 col-12">';
		}

		
        $semestres = 1;
        while($semestres <= $semestres_del_programa){
            $data["0"] .=$anchodiv;
                $data["0"] .= '
                <div class="card">
                    <div class="card-header border-2">
                        <h3 class="card-title">Semestre ' .$semestres.'</h3>
                        <div class="card-tools">
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">';
                        $rspta = $homologacion->listarMaterias($id_programa_ac,$semestres);
                        $reg = $rspta;
                        for ($i=0;$i<count($reg);$i++){
                            $id_materia=$reg[$i]["id"];
                            $id_programa_ac=$reg[$i]["id_programa_ac"];
                            $materia=$reg[$i]["nombre"];// nombre de la materia 
                            $creditos=$reg[$i]["creditos"];
                            $rspta3 = $homologacion->datosMateriaMatriculada($ciclo,$id_estudiante,$materia,$semestres);
                            $reg3=$rspta3;
                            $id_materia_matriculada=$reg3["id_materia"];
                            $promedio_materia_matriculada=$reg3["promedio"];
                            $grupo=$reg3["grupo"];
							

                            if($periodo_actual == $reg3["periodo"] ){
                                $color="success";
                                $boton_eliminar = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true" title="eliminar" onclick="eliminarMateria('.$id_estudiante.', '.$id_programa_ac.', '.$id_materia.', '.$semestres_del_programa.', '.$id_materia_matriculada.', '.$promedio_materia_matriculada.' )">×</button>';
                            }else if($periodo_actual != $reg3["periodo"]){
                                $boton_eliminar = '';
                                if($reg3["promedio"] > 0 and $reg3["promedio"] < 3){
                                    $color="danger";
                                }else if($reg3["promedio"] >= 3){
                                    $color="success";
                                }else{
                                    $color="info";
                                }
                            }
                            $data["0"] .= '<div class="alert bg-'.$color.'">';
                            $data["0"] .= $boton_eliminar;
                            $data["0"] .= '<small class="label text-white">['.$creditos.']</small>';
                            $data["0"] .= $materia .'<br>';
                            $inicio_corte = 1;
                            $jornada_matriculada=$reg3['jornada'];
                            $periodo_matriculada=$reg3["periodo"];

                            if($rspta3){
                                while($inicio_corte <= $cortes ){
									
                                    $nota="c".$inicio_corte;
                                    $tnota="C".$inicio_corte;
                                    $data["0"] .= '<span class="label label-default">'.$tnota.':'.$reg3[$nota].'</span> ';
                                    $inicio_corte++;
                                }
                                $data["0"] .='<span class="btn bg-maroon btn-xs" title="Promedio">Promedio: ' .$reg3["promedio"] . '</span> <br><br>';
								
								if($periodo_actual != $reg3["periodo"]){
                                    $data["0"] .= '<i class="fa fa-calendar-alt"></i>'. $reg3["jornada"];
                                    $data["0"] .= '<i class="fa fa-hourglass-start"></i>'.$reg3["periodo"];
                                }else{

                                    $data["0"] .= '<a class="btn btn-warning btn-xs" onclick="cambioJornada('.$id_materia_matriculada.', `'.$jornada_matriculada.'`, `'.$ciclo.'`, '.$id_programa_ac.', '.$id_estudiante.')" title="Jornada">'. $reg3["jornada"] . '</a> 

									<a class="btn btn-info btn-xs" onclick="cambioPeriodo('.$id_materia_matriculada.', `'.$periodo_matriculada.'`, `'.$ciclo.'`, '.$id_programa_ac.', '.$id_estudiante.')" title="Periodo">'.$reg3["periodo"].'</a>
                                    
                                    <a class="btn btn-primary btn-xs" onclick="cambioGrupo('.$id_materia_matriculada.', `'.$periodo_matriculada.'`, `'.$ciclo.'`, '.$id_programa_ac.', '.$id_estudiante.', '.$grupo.')" title="Grupo"> Grupo: '.$grupo .'</a> 
									
									<a class="btn btn-primary btn-xs" onclick="homologacion_materia('.$id_materia_matriculada.', `'.$periodo_matriculada.'`, `'.$ciclo.'`, '.$id_programa_ac.', '.$id_estudiante.', '.$grupo.')" title="Homologación"> Homologación: '.$promedio_materia_matriculada .'</a>  ';
									
									$estado_homologacion=$reg3["huella"];

									$data["0"] .=	$estado_homologacion = ($estado_homologacion == "Homomologación") ?'<br> <span class="badge badge-danger p-2 mt-3">Homologada</span>' :'<br> <br><span class="badge badge-warning p-2">Sin Homologar</span> ';

								}
                            }else{

								
								$data["0"] .='<button type="button" class="btn btn-success btn-xs btn-block" onclick="matriculaMateriaNormal('.$id_estudiante.', '.$id_programa_ac.', '.$id_materia.', '.$semestres_del_programa.')">Matricular Materia</button> <br>';

								$estado_homologacion=$reg3["huella"];
									$data["0"] .=	$estado_homologacion = ($estado_homologacion == "Homomologación") ?'<br><span class="badge badge-danger p-2 ">Homologada</span>' :'<span class="badge badge-warning p-2">Sin Homologar</span>';
								

                                
                            
							
								
				
							}
                            $data["0"] .= '</div>';
                        }
                        $data["0"] .='</div>
                                </div>';
                $data["0"] .='</div>';
            $data["0"] .='</div>';
            $semestres++;
        }
		
        $results = array($data);
        echo json_encode($results);
	break;	

	case "matriculaMateriaNormal":	
		$usuario=$_SESSION['usuario_cargo'];
		$id_estudiante=$_POST["id_estudiante"];
		$id_materia=$_POST["id_materia"];
		$semestres_del_programa=$_POST["semestres_del_programa"];
		$rspta2 =$homologacion->MateriaDatos($id_materia);
		$nombre_materia=$rspta2["nombre"];
		$semestre=$rspta2["semestre"];
		$creditos=$rspta2["creditos"];
		$rspta3 =$homologacion->datosEstudiante($id_estudiante);
		$id_programa_ac=$rspta3["id_programa_ac"];
		$jornada_e=$rspta3["jornada_e"];// trae la jornada de estudio del estudiante
		$programa=$rspta3["fo_programa"];
		$ciclo=$rspta3["ciclo"];
		$grupo=$rspta3["grupo"];
		$rspta4 = $homologacion->insertarmateria($id_estudiante,$nombre_materia,$jornada_e,$periodo_actual,$semestre,$creditos,$id_programa_ac,$ciclo,$fecha,$usuario,$grupo);
		if($rspta4){
			$rspta5 = $homologacion->actualizarperiodo($id_estudiante,$periodo_actual);
			$rspta6 = $homologacion->creditosMatriculados($id_estudiante,$ciclo);//suma el total de creditos matriculados
			$creditos_matriculados=$rspta6["suma_creditos"];
			$rspta7 = $homologacion->datosPrograma($id_programa_ac);// trae creditos por semestre
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
			$rspta8 = $homologacion->actualizarsemestre($id_estudiante,$semestre_nuevo);// trae creditos por semestre
		}
		echo json_encode($rspta4);
	break;
    case "eliminarMateria":	
		$usuario=$_SESSION['usuario_cargo'];
		$id_estudiante=$_POST["id_estudiante"];
		$id_materia=$_POST["id_materia"];
		$semestres_del_programa=$_POST["semestres_del_programa"];
		$id_materia_matriculada=$_POST["id_materia_matriculada"];
		$promedio_materia_matriculada=$_POST["promedio_materia_matriculada"];
		$rspta2 =$homologacion->MateriaDatos($id_materia);
		$nombre_materia=$rspta2["nombre"];
		$semestre=$rspta2["semestre"];
		$creditos=$rspta2["creditos"];
		$rspta3 =$homologacion->datosEstudiante($id_estudiante);
		$id_programa_ac=$rspta3["id_programa_ac"];
		$jornada_e=$rspta3["jornada_e"];// trae la jornada de estudio del estudiante
		$programa=$rspta3["fo_programa"];
		$ciclo=$rspta3["ciclo"];
		$rspta9 = $homologacion->trazabilidadMateriaEliminada($id_estudiante, $nombre_materia, $jornada_e, $periodo_actual, $semestre, $promedio_materia_matriculada, $programa, $fecha, $usuario);
		$rspta4 = $homologacion->eliminarMateria($id_materia_matriculada,$ciclo);
		if($rspta4){
			$rspta6 = $homologacion->creditosMatriculados($id_estudiante,$ciclo);//suma el total de creditos matriculados
			$creditos_matriculados=$rspta6["suma_creditos"];
			$rspta7 = $homologacion->datosPrograma($id_programa_ac);// trae creditos por semestre
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
			$rspta8 = $homologacion->actualizarsemestre($id_estudiante,$semestre_nuevo);// trae creditos por semestre
		}
		echo json_encode($rspta4);
	break;	
    case "selectJornada":	
		$rspta = $homologacion->selectJornada();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;
	case "selectPrograma":	
		$rspta = $homologacion->selectPrograma();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["original"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;
	case "selectPeriodo":	
		$rspta = $homologacion->selectPeriodo();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"]. "</option>";
        }
	break;
	case "selectGrupo":	
		$rspta = $homologacion->selectGrupo();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["grupo"] . "'>" . $rspta[$i]["grupo"]. "</option>";
        }
	break;


	case "selectHomologacion":	
		$rspta = $homologacion->selectHomologacion();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"]. "</option>";
        }
	break;

	// case "selectDocentes":	
	// 	$rspta = $homologacion->listarDocentes();
	// 	for ($i=0;$i<count($rspta);$i++){
	// 			$nombre =  $rspta[$i]["usuario_nombre"]. ''.$rspta[$i]["usuario_nombre_2"]. ''.$rspta[$i]["usuario_apellido"]. ''.$rspta[$i]["usuario_apellido_2"];

    //         echo "<option value='" . $nombre . "'>" . $nombre. "</option>";
    //     }
	// break;


	case "actualizarJornada":
		$id_materia=$_POST["id_materia"];
		$ciclo=$_POST["ciclo"];
		$jornada_e=$_POST["jornada_e"];
		$id_estudiante=$_POST["id_estudiante"];
		$id_programa_ac=$_POST["id_programa_ac"];
		$data= Array();
		$data["0"] ="";
		$rspta = $homologacion->actualizarJornada($id_materia,$jornada_e,$ciclo);
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
		$rspta = $homologacion->actualizarPeriodoMateria($id_materia,$periodo,$ciclo);
        $data["0"] .= $id_programa_ac;
        $data["1"] = $id_estudiante;
		$results = array($data);
 		echo json_encode($results);
	break;
	case "actualizarGrupo":
		$id_materia=$_POST["id_materia_h"];
		$ciclo=$_POST["ciclo_h"];
		$grupo=$_POST["grupo"];
		$id_estudiante=$_POST["id_estudiante_h"];
		$id_programa_ac=$_POST["id_programa_ac_h"];

		$data= Array();
		$data["0"] ="";
		$rspta = $homologacion->actualizarGrupoMateria($id_materia,$grupo,$ciclo);			
        $data["0"] .=$id_programa_ac;
        $data["1"] = $id_estudiante;
		$results = array($data);
 		echo json_encode($results);
	break;

	case 'promedio':
		$id = $_POST['id'];
		$val = $_POST['val'];
		$c = $_POST['c'];

		$fecha_Homologacion = date('Y-m-d-H:i:s');
		$ip_publica = $_SERVER['REMOTE_ADDR'];

		$homologacion->promedio($id,$val,$c, $fecha_Homologacion);
	break;

	case 'huella':
		$id = $_POST['id'];
		$val = $_POST['val'];
		$c = $_POST['c'];
		$homologacion->huella($id,$val,$c);
	break;


	case 'homologacion_select':

		$id_materia = $_POST['id_materia'];
		$ciclo = $_POST['ciclo_materia'];
		$id_estudiante = $_POST['id_estudiante_'];
		$id_programa_ac_=$_POST["id_programa_ac_"];

		// separamos el ciclo para solo dejar el numero del ciclo 
		$ciclo_h = explode("s", $ciclo);
		$ciclo_homologacion =  $ciclo_h[1];		
		
		$data["0"] ="";
		
		$promedio_materia = 0;

		$semestres = 1;

		$rspta3 = $homologacion->datosMateriaMatriculadah($ciclo,$id_materia);

		$reg3=$rspta3;

		$promedio_materia_matriculada=$reg3["promedio"];

		$huella_resultado=$reg3["huella"];
		

		$data["0"] .= '<a class="btn btn-xs">';

		$data["0"] .='<div class="form-group col-12">		
			<label>Nota Homologación :</label>
			
			<div class="input-group">
				
				<td class="ancho-md"><input type="number" step="any" placeholder="Homologar materia" value="'.$promedio_materia_matriculada.'" onchange=promedio(this.value,"'.$ciclo_homologacion.'","'.( $id_materia).'") class="form-control"></td>'. '</a>
			</div>';
		
	

		$data["0"] .='
		

			<br>
			<td class="ancho-md">
		<label>Huella :</label>
			<select class="form-control col-12" onchange=huella(this.value,"'.$id_materia.'","'.$ciclo_homologacion.'")>';
			$data["0"] .= '<option></option>';

			$da = $homologacion->valorhuella();
			for ($a=0; $a < count($da); $a++) {
				$retVal = ($reg[$i]["huella"] == $da[$a]['nombre']) ? 'selected' : '' ;
				$data["0"] .= '<option '.$retVal.' value="'.$da[$a]['nombre'].'">'.$da[$a]['nombre'].'</option>';
			}

			$data["0"] .='</select>
		</td>
		</div>';
	
		echo json_encode($data);
	break;



	case 'selecionar_docente':


		$nombre_materia = $_POST['nombre_materia'];
		$periodo = $_POST['periodo'];

		$data["0"] ="";
			$data["0"] .='
			<div class="box">
            <!-- /.box-header -->
            <div class="box-body no-padding">
			<h4> <b></b></h4>
				<table id="mostrardocentes" class="table table-striped table-bordered table-condensed table-hover">
					
					<thead>
					<tr>
						<th>Docente</th>
						<th>Cedula</th>
						<th>Día</th>
						<th style="width: 40px">Hora</th>
						<th>Hasta</th>
						<th>Salón</th>
						<th>Periodo</th>
						<th>Jornada</th>
						<th>Acción</th>
					</tr>
					
					</thead><tbody>';

		$rspta = $homologacion->mostrarmateriasdisponibles($nombre_materia);
		
		for ($i=0;$i<count($rspta);$i++){

			$nombre_materia =  $rspta[$i]["nombre"];
			$dia =  $rspta[$i]["dia"];
			$jornada =  $rspta[$i]["jornada"];
			$hora =  $rspta[$i]["hora"];
			$hasta =  $rspta[$i]["hasta"];
			$diferencia =  $rspta[$i]["diferencia"];
			$salon =  $rspta[$i]["salon"];
			$periodo =  $rspta[$i]["periodo"];

			// tomamos el docente grupo
			$id_docente_grupo =  $rspta[$i]["id_docente_grupo"];
			$usuario_identificacion =  $rspta[$i]["usuario_identificacion"];

			$nombre_docente =  $rspta[$i]["usuario_nombre"]. ' '.$rspta[$i]["usuario_nombre_2"]. ' '.$rspta[$i]["usuario_apellido"]. ' '.$rspta[$i]["usuario_apellido_2"];

			$data["0"] .='<tr>';

			$data["0"] .= '<td>' .$nombre_docente . '</td>';
			$data["0"] .= '<td>' .$usuario_identificacion . '</td>';
			$data["0"] .='<td>'.$dia .'</td>';
			$data["0"] .='<td>'.$hora.'</td>';
			$data["0"] .='<td>'.$hasta.'</td>';
			$data["0"] .='<td>'.$salon.'</td>';
			$data["0"] .='<td>'.$periodo.'</td>';
			$data["0"] .='<td>'.$jornada.'</td>';
			$data["0"] .='<td> 
			
			<a class="btn btn-info btn-xs" onclick="asignar_docente('.$id_docente_grupo.', `'.$dia.'`, `'.$hora.'`,`'.$hasta.'`,`'.$diferencia.'`,`'.$salon.'`,`'.$nombre_materia.'`, `'.$periodo.'`)" title="Asignar Docente">Asignar Docente</a></td>';
			
			$data["0"] .='</tr>';
			
		}
		
		$data["0"] .='
		</tbody>
		</table>
		            </div>
            <!-- /.box-body -->
		</div>';
		
		echo json_encode($data);
	break;


	
	case 'asignar_docente':

		$id_docente = $_POST['id_docente_grupo'];
		$dia = $_POST['dia'];
		$hora = $_POST['hora'];
		$hasta = $_POST['hasta'];
		$diferencia = $_POST['diferencia'];
		$salon = $_POST['salon'];
		$nombre_materia = $_POST['nombre_materia'];
		$periodo = $_POST['periodo'];

		$homologacion->asignar_docente($id_docente,$dia,$hora,$hasta,$diferencia,$salon,$nombre_materia,$periodo);
		
	break;





}
