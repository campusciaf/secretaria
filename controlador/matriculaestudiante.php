<?php 
session_start();
require_once "../modelos/MatriculaEstudiante.php";

$matriculaestudiante=new MatriculaEstudiante();

$credencial_usuario=$_SESSION['usuario_cargo'];// trae la sesion del cargo del usuario

date_default_timezone_set("America/Bogota");	
$credencial_fecha=date('Y-m-d-H:i:s');

$fecha = date('Y-m-d');
$hora = date('H:i:s');

$id_usuario = $_SESSION['id_usuario'];

$id_credencial=isset($_POST["id_credencial"])? limpiarCadena($_POST["id_credencial"]):"";
$credencial_nombre=isset($_POST["credencial_nombre"])? limpiarCadena($_POST["credencial_nombre"]):"";
$credencial_nombre_2=isset($_POST["credencial_nombre_2"])? limpiarCadena($_POST["credencial_nombre_2"]):"";
$credencial_apellido=isset($_POST["credencial_apellido"])? limpiarCadena($_POST["credencial_apellido"]):"";
$credencial_apellido_2=isset($_POST["credencial_apellido_2"])? limpiarCadena($_POST["credencial_apellido_2"]):"";
$credencial_login=isset($_POST["credencial_login"])? limpiarCadena($_POST["credencial_login"]):"";

$fo_programa=isset($_POST["fo_programa"])? limpiarCadena($_POST["fo_programa"]):"";
$jornada_e=isset($_POST["jornada_e"])? limpiarCadena($_POST["jornada_e"]):"";
$grupo=isset($_POST["grupo"])? limpiarCadena($_POST["grupo"]):"";
$pago=isset($_POST["pago"])? limpiarCadena($_POST["pago"]):"";

switch ($_GET["op"]){
		
	case 'guardaryeditar':

		$credencial_identificacion=$_GET["credencial_identificacion"];
		$credencial_clave=md5($credencial_identificacion);
	
			$rspta=$matriculaestudiante->insertar($credencial_nombre,$credencial_nombre_2,$credencial_apellido,$credencial_apellido_2,$credencial_identificacion,$credencial_login,$credencial_clave,$credencial_usuario,$credencial_fecha);
		
			
			$data["0"] = $rspta ? "Estudiante registrado(a) " : "No se pudo registrar el estudiante";
				
			$rspta=$matriculaestudiante->traeridcredencial($credencial_identificacion);
			$data["1"] =$rspta["id_credencial"];// trae el id credencial del que se acabo de regsitrar

				$insertardatosestudainte=$matriculaestudiante->insertardatosestudiante($rspta["id_credencial"]);

			$results = array($data);
			echo json_encode($results);	

	break;	
	case 'guardaryeditar2':
			$periodo_activo=$_SESSION['periodo_actual'];
			$id_credencial=$_GET["id_credencial"];

		
			$rspta1=$matriculaestudiante->mostrarescuela($fo_programa);
			$escuela_ciaf=$rspta1["escuela"];
			$id_programa_ac=$rspta1["id_programa"];
			$ciclo=$rspta1["ciclo"];
			$admisiones="no";
		
			$rspta=$matriculaestudiante->insertarnuevoprograma($id_credencial,$id_programa_ac,$fo_programa,$jornada_e,$escuela_ciaf,$periodo_activo,$ciclo,$periodo_activo,$grupo,$id_usuario,$fecha,$hora,$admisiones,$pago);
			
			echo $rspta ? "Nuevo programa registrado(a) " : "No se pudo registrar el nuevo programa";


	break;
	case 'verificardocumento': 
		$credencial_identificacion=$_POST["credencial_identificacion"];
		$rspta=$matriculaestudiante->verificardocumento($credencial_identificacion);
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
		$rspta=$matriculaestudiante->listar($id_credencial);
 		//Vamos a declarar un array
 		$arreglo_datos = Array();
		$arreglo_jornadas=Array();
		 $arreglo_jornadas = $matriculaestudiante->cargarJornadas();
		 $arreglo_datos = $matriculaestudiante->cargarEstadosAcademicos();
		 $arreglo_grupos = $matriculaestudiante->cargarGrupos();
		 $data= Array();
			$a = 0;
			$b = 0;
			$c = 0;
			$i = 0;			
			while ($i < count($rspta)){
				$option = '';
				if($rspta[$i]["estado"] == 2 ){
					$option .= '<option value="2" selected>Graduado</option>';
				}else{
					$option .= '<select name="estado_academico" id="estado_academico" onchange="cambiarEstado(this.value,'.$rspta[$i]["id_estudiante"].','.$rspta[$i]["id_credencial"].','.$rspta[$i]["id_programa_ac"].')" disabled>';
					while($a < count($arreglo_datos)){
						if($rspta[$i]["estado"] == $arreglo_datos[$a]['id_estado_academico'])  {

							$option .= '<option value="'.$arreglo_datos[$a]['id_estado_academico'].'" selected>'.$arreglo_datos[$a]['estado'].'</option>';
						}else{
							$option .= '<option value="'.$arreglo_datos[$a]['id_estado_academico'].'" d-none>'.$arreglo_datos[$a]['estado'].'</option>';
						}
						$a++;
					}
					$option.='</select>';
				}
				
				$a = 0;
				$option_grupo = '';

				if($rspta[$i]["estado"] == 2 ){
					$option_grupo .=$arreglo_grupos[$b]['grupo'];
				}else{
					
					$option_grupo .= '<select name="grupo_academico" onchange="cambiarGrupo(this.value,'.$rspta[$i]["id_estudiante"].')" id="grupo_academico" disabled>';

					while($b < count($arreglo_grupos)){

						if ($rspta[$i]['grupo'] == $arreglo_grupos[$b]['id_grupo']) {
							$option_grupo .= '<option value="'.$arreglo_grupos[$b]['id_grupo'].'" selected >'.$arreglo_grupos[$b]['grupo'].'</option>';
						} else {
							$option_grupo .= '<option value="'.$arreglo_grupos[$b]['id_grupo'].'">'.$arreglo_grupos[$b]['grupo'].'</option>';
						}
						$b++;
					}
					$option_grupo.='</select>';
				}
				$b = 0;
				if($rspta[$i]["estado"] == 2){
					$option_jornada = $rspta[$i]['jornada_e'];
					// $option_jornada2 = $rspta[$i]['jornada_e'];
				}else{
					$option_jornada = '<select name="jornada_e" onchange="cambiarJornada(this.value,'.$rspta[$i]["id_estudiante"].')" id="grupo_academico" disabled>';
					while($c < count($arreglo_jornadas)){
						if ($rspta[$i]['jornada_e'] == $arreglo_jornadas[$c]['nombre']) {
							$option_jornada .= '<option value="'.$arreglo_jornadas[$c]['nombre'].'" selected >'.$arreglo_jornadas[$c]['nombre'].'</option>';
						} else {
							$option_jornada .= '<option value="'.$arreglo_jornadas[$c]['nombre'].'">'.$arreglo_jornadas[$c]['nombre'].'</option>';
						}
						$c++;
					}
					$option_jornada.='</select>';
				}
				
				$c = 0;

				$data[]=array(

					"0"=>$rspta[$i]["id_estudiante"],
					"1"=>$rspta[$i]["fo_programa"],
					"2"=>$rspta[$i]['jornada_e'],
					"3"=>$rspta[$i]["escuela_ciaf"],
					"4"=>$option,
					"5"=>$arreglo_grupos[$b]['grupo'],
					"6"=>$rspta[$i]["periodo"],
					"7"=>$rspta[$i]["periodo_activo"],	
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
	case "cambiarEstado":
		$nuevo_estado = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaestudiante->cambiarEstado($nuevo_estado,$id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;
	case 'registrarGraduado':
		$nuevo_estado = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$id_credencial = $_POST['id_credencial'];
		$id_programa_ac = $_POST['id_programa_ac'];
		$periodo_grado = $_POST['periodo_grado'];
		$saber_pro = $_POST['saber_pro'];
		$acta_grado = $_POST['acta_grado'];
		$folio = $_POST['folio'];
		$fecha_grado = $_POST['fecha_grado'];
		if (empty($id_programa_ac) || empty($periodo_grado) || empty($saber_pro) || empty($acta_grado) || empty($folio) || empty($fecha_grado)) {
			echo 2;
		}else{
			$insertar_graduado = $matriculaestudiante->registrarGraduado($id_estudiante,$id_credencial,$periodo_grado,$id_programa_ac,$saber_pro,$acta_grado,$folio,$fecha_grado);
			$rspta = $matriculaestudiante->cambiarEstado($nuevo_estado,$id_estudiante);
			if ($insertar_graduado) {
				echo 1;
			} else {
				echo 0;
			}
		}
	break; 
	case "cambiarGrupo":
		$nuevo_grupo = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaestudiante->cambiarGrupo($nuevo_grupo,$id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;
	case "cambiarJornada":
		$nueva_jornada = $_POST['data'];
		$id_estudiante = $_POST['id_estudiante'];
		$rspta = $matriculaestudiante->cambiarJornada($nueva_jornada,$id_estudiante);
		if ($rspta) {
			echo 1;
		} else {
			echo 0;
		}
	break;	
		
	case "mostrardatos":
		$id_credencial=$_POST["id_credencial"];
		$rspta = $matriculaestudiante->mostrardatos($id_credencial);
		$cedula_estudiante = $rspta["credencial_identificacion"];
		$datos_personales_estudiante = $matriculaestudiante->telefono_estudiante($cedula_estudiante);
		//if null
		$celular_estudiante = $datos_personales_estudiante["celular"] ?? "";
		$data= Array();
		$data["0"] ="";
			if (file_exists('../files/estudiantes/'.$rspta["credencial_identificacion"].'.jpg')) {
				$foto='<img src=../files/estudiantes/'.$rspta["credencial_identificacion"].'.jpg width=36px height=36px class=img-circle img-bordered-sm>';
			}else{
				$foto='<img src=../files/null.jpg width=36px height=36px class=img-circle img-bordered-sm>';
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
					<div class="col-12 p-4">
						<button onclick="mostraragregarprograma('.$rspta["id_credencial"].')" class="float-right btn btn-success">Matricular nuevo Programa</button>
					</div>
				</div>
			';
		
		$results = array($data);
 		echo json_encode($results);
	
		
	break;
	case 'mostrar':
	   $id = $_POST["id"];
        $rspta=$matriculaestudiante->mostrar($id);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);

	break;	
	case "selectJornada":	
		$rspta = $matriculaestudiante->selectJornada();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
	case "selectPrograma":	
		$rspta = $matriculaestudiante->selectPrograma();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
	case "selectGrupo":	
		$rspta = $matriculaestudiante->selectGrupo();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["grupo"] . "'>" . $rspta[$i]["grupo"]. "</option>";
				}
	break;
}
?>