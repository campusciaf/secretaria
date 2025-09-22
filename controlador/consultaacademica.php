<?php 
session_start();
require_once "../modelos/ConsultaAcademica.php";
$consultaacademica=new ConsultaAcademica();
$periodo_actual=$_SESSION['periodo_actual'];
date_default_timezone_set("America/Bogota");	
$fecha=date('Y-m-d-H:i:s');
$id_credencial=isset($_POST["id_credencial"])? limpiarCadena($_POST["id_credencial"]):"";
$credencial_nombre=isset($_POST["credencial_nombre"])? limpiarCadena($_POST["credencial_nombre"]):"";
$credencial_nombre_2=isset($_POST["credencial_nombre_2"])? limpiarCadena($_POST["credencial_nombre_2"]):"";
$credencial_apellido=isset($_POST["credencial_apellido"])? limpiarCadena($_POST["credencial_apellido"]):"";
$credencial_apellido_2=isset($_POST["credencial_apellido_2"])? limpiarCadena($_POST["credencial_apellido_2"]):"";
$credencial_login=isset($_POST["credencial_login"])? limpiarCadena($_POST["credencial_login"]):"";
$fo_programa=isset($_POST["fo_programa"])? limpiarCadena($_POST["fo_programa"]):"";
$jornada_e=isset($_POST["jornada_e"])? limpiarCadena($_POST["jornada_e"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		$credencial_identificacion=$_GET["credencial_identificacion"];
		$credencial_clave=md5($credencial_identificacion);
        $rspta = $consultaacademica->insertar($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave);
        $data["0"] = $rspta ? "Estudiante registrado(a) " : "No se pudo registrar el estudiante";
        $rspta=$consultaacademica->traeridcredencial($credencial_identificacion);
        $data["1"] =$rspta["id_credencial"];
        $results = array($data);
        echo json_encode($results);	
	break;		
	case 'verificardocumento': 
		$credencial_identificacion=$_POST["credencial_identificacion"];
		$rspta=$consultaacademica->verificardocumento($credencial_identificacion);
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
		$rspta=$consultaacademica->listar($id_credencial);
 		//Vamos a declarar un array
 		$data= Array();
        $i = 0;			
        while ($i < count($rspta)){
            $rspta2 = $consultaacademica->listarEstado($rspta[$i]["estado"]);
            $data[]=array(
                "0"=>'<button class="btn btn-primary btn-xs" onclick="mostrarmaterias('.$rspta[$i]["id_programa_ac"].','.$rspta[$i]["id_estudiante"].','.$rspta[$i]["ciclo"].')" title="Matricular Materias"><i class="fas fa-plus-square"></i> Materias</button>',
                "1"=>$rspta[$i]["id_estudiante"],
                "2"=>$rspta[$i]["fo_programa"],
                "3"=>$rspta[$i]["jornada_e"],
                "4"=>$rspta[$i]["semestre_estudiante"],
                "5"=>$rspta[$i]["grupo"],
                "6"=>$rspta[$i]["escuela_ciaf"],
                "7"=>$rspta2["estado"],
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
		$rspta = $consultaacademica->mostrardatos($id_credencial);
		$data= Array();
		$data["0"] ="";
        if (file_exists('../files/estudiantes/'.$rspta["credencial_identificacion"].'.jpg')) {
            $foto='<img src=../files/estudiantes/'.$rspta["credencial_identificacion"].'.jpg class=img-circle img-bordered-sm>';
        }else{
            $foto='<img src=../files/null.jpg width=50px height=50px class=img-circle img-bordered-sm>';
        }
        $data["0"] .= '<div class="user-block">
            '.$foto.'
                <span class="username">
                    <a href="#">'.$rspta["credencial_nombre"].' '.$rspta["credencial_nombre_2"].' '.$rspta["credencial_apellido"].' '.$rspta["credencial_apellido_2"].'
                </span>
            <span class="description">'.$rspta["credencial_login"].'</span><br>
          </div>';
		$results = array($data);
 		echo json_encode($results);
	break;
	case "mostrarmaterias":
		$data= Array();
		$data["0"] ="";
		$id_programa_ac=$_POST["id_programa_ac"];
		$id_estudiante=$_POST["id_estudiante"];
		//consulta para ver los datos del programa
		$rspta2 = $consultaacademica->datosPrograma($id_programa_ac);
		$reg2=$rspta2;
		$semestres_del_programa=$reg2["semestres"];
		$ciclo="materias".$reg2["ciclo"];// para saber en que tabla debe busar las materias
		$cortes=$reg2["cortes"];// para saber en que tabla debe busar las materias
		$inicio_cortes=1;
		//consulta para ver los datos del programa en que se matriculo el estudiante
		$rspta4 = $consultaacademica->datosEstudiante($id_estudiante);
		$reg4=$rspta4;
		$jornada_estudio=$reg4["jornada_e"];
		$semestres=1;
		while($semestres <= $semestres_del_programa){
            $data["0"] .='<div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Semestre ' .$semestres.'</h3>
                        <div class="card-tools">
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">';
			$data["0"] .='<table class="table table-hover table-nowarp">
                <tbody>
                    <tr>
                        <th>Asignatura</th>';
            for ($i=1; $i <= $cortes; $i++) { 
                $data["0"] .= '<th>C'.$i.'</th>';
            }
            $data["0"] .='<th>Promedio</th>
                <th>Huella</th>
                <th>Periodo</th>
            </tr>';
            $rspta = $consultaacademica->listarMaterias($id_estudiante, $ciclo, $semestres);
            $reg = $rspta;
            for ($i=0;$i<count($reg);$i++){
                $materia=$reg[$i]["nombre_materia"];// nombre de la materia 
                $data["0"] .='<tr>
                  <td>'.$materia.'</td>';
                $inicio_cortes = 1;
                $corte_nota = "";
                while($inicio_cortes <= $cortes){
                    $corte_nota="c".$inicio_cortes;
                    $data["0"] .= '<td class="ancho-sm">'.$reg[$i][$corte_nota].'</td>';
                    $inicio_cortes++;
                }
                $da = $consultaacademica->valorhuella();
                $data["0"] .='<td class="ancho-sm">'.$reg[$i]["promedio"].'</td>	  
                    <td class="ancho-md">'.$reg[$i]["huella"].'</td>
                    <td class="ancho-sm">'.$reg[$i]["periodo"].'</td>
                </tr>';
            }
            $data["0"] .='</tbody>
                    </table>';
            $data["0"] .='</div>
				    </div>
				</div>';
            $semestres++;	
        }
		$results = array($data);
 		echo json_encode($results);
	break;	
	case 'mostrar':
        $rspta=$consultaacademica->mostrar($id);
 		//Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;	
	case "matriculaMateriaNormal":	
		$usuario=$_SESSION['usuario_cargo'];
		$id_estudiante=$_POST["id_estudiante"];
		$id_materia=$_POST["id_materia"];
		$semestres_del_programa=$_POST["semestres_del_programa"];
		$rspta2 =$consultaacademica->MateriaDatos($id_materia);
		$nombre_materia=$rspta2["nombre"];
		$semestre=$rspta2["semestre"];
		$creditos=$rspta2["creditos"];
		$rspta3 =$consultaacademica->datosEstudiante($id_estudiante);
		$id_programa_ac=$rspta3["id_programa_ac"];
		$jornada_e=$rspta3["jornada_e"];// trae la jornada de estudio del estudiante
		$programa=$rspta3["fo_programa"];
		$ciclo=$rspta3["ciclo"];
		$grupo=$rspta3["grupo"];
		$rspta4 = $consultaacademica->insertarmateria($id_estudiante, $nombre_materia, $jornada_e, $periodo_actual, $semestre, $creditos, $id_programa_ac, $ciclo, $fecha, $usuario, $grupo);
		if($rspta4){
            $rspta5 = $consultaacademica->actualizarperiodo($id_estudiante,$periodo_actual);
			$rspta6 = $consultaacademica->creditosMatriculados($id_estudiante,$ciclo);//suma el total de creditos matriculados
			$creditos_matriculados=$rspta6["suma_creditos"];
			$rspta7 = $consultaacademica->datosPrograma($id_programa_ac);// trae creditos por semestre
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
			$rspta8 = $consultaacademica->actualizarsemestre($id_estudiante,$semestre_nuevo);// trae creditos por semestre
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
		$rspta2 =$consultaacademica->MateriaDatos($id_materia);
		$nombre_materia=$rspta2["nombre"];
		$semestre=$rspta2["semestre"];
		$creditos=$rspta2["creditos"];
		$rspta3 =$consultaacademica->datosEstudiante($id_estudiante);
		$id_programa_ac=$rspta3["id_programa_ac"];
		$jornada_e=$rspta3["jornada_e"];// trae la jornada de estudio del estudiante
		$programa=$rspta3["fo_programa"];
		$ciclo=$rspta3["ciclo"];
		$rspta9 = $consultaacademica->trazabilidadMateriaEliminada($id_estudiante, $nombre_materia, $jornada_e, $periodo_actual, $semestre, $promedio_materia_matriculada, $programa, $fecha, $usuario);
		$rspta4 = $consultaacademica->eliminarMateria($id_materia_matriculada,$ciclo);
		if($rspta4){
            $rspta6 = $consultaacademica->creditosMatriculados($id_estudiante,$ciclo);//suma el total de creditos matriculados
			$creditos_matriculados=$rspta6["suma_creditos"];
			$rspta7 = $consultaacademica->datosPrograma($id_programa_ac);// trae creditos por semestre
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
			$rspta8 = $consultaacademica->actualizarsemestre($id_estudiante,$semestre_nuevo);// trae creditos por semestre
		}
		echo json_encode($rspta4);
	break;
	case "selectJornada":	
		$rspta = $consultaacademica->selectJornada();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;	
	case "selectPrograma":	
		$rspta = $consultaacademica->selectPrograma();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["original"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;
	case "selectPeriodo":	
		$rspta = $consultaacademica->selectPeriodo();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"]. "</option>";
        }
	break;
	case "selectGrupo":	
		$rspta = $consultaacademica->selectGrupo();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["grupo"] . "'>" . $rspta[$i]["grupo"]. "</option>";
        }
	break;
	case "actualizarJornada":
		$id_materia=$_POST["id_materia"];
		$ciclo=$_POST["ciclo"];
		$jornada_e=$_POST["jornada_e"];
		$id_estudiante=$_POST["id_estudiante"];
		$id_programa_ac=$_POST["id_programa_ac"];
		$data = array();
		$data["0"] ="";
		$rspta = $consultaacademica->actualizarJornada($id_materia,$jornada_e,$ciclo);
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
		$data = array();
		$data["0"] ="";
		$rspta = $consultaacademica->actualizarPeriodoMateria($id_materia,$periodo,$ciclo);
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
		$rspta = $consultaacademica->actualizarGrupoMateria($id_materia,$grupo,$ciclo);
        $data["0"] .=$id_programa_ac;
        $data["1"] = $id_estudiante;
		$results = array($data);
 		echo json_encode($results);
	break;
	case 'huella':
		$id = $_POST['id'];
		$val = $_POST['val'];
		$c = $_POST['c'];
		$consultaacademica->huella($id,$val,$c);
	break;
	case 'nota':
		$id = $_POST['id'];
		$nota = $_POST['nota'];
		$tl = $_POST['tl'];
		$c = $_POST['c'];
		$pro = $_POST['pro'];
		$consultaacademica->agreganota($id,$nota,$tl,$c,$pro);
	break;
	case 'promedio':
		$id = $_POST['id'];
		$val = $_POST['val'];
		$c = $_POST['c'];
		$consultaacademica->promedio($id,$val,$c);
	break;
}
?>