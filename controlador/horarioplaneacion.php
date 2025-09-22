<?php 
require_once "../modelos/HorarioPlaneacion.php";

$horarioplaneacion=new HorarioPlaneacion();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$id_programa_ac=isset($_POST["programa_ac"])? limpiarCadena($_POST["programa_ac"]):"";
$jornada=isset($_POST["jornada"])? limpiarCadena($_POST["jornada"]):"";
// $dia=isset($_POST["dia"])? limpiarCadena($_POST["dia"]):"";
// $periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$grupo=isset($_POST["grupo"])? limpiarCadena($_POST["grupo"]):"";
$semestre=isset($_POST["semestre"])? limpiarCadena($_POST["semestre"]):"";



// modal asignar horario
$id_horario_fijo=isset($_POST["id_horario_fijo"])? limpiarCadena($_POST["id_horario_fijo"]):"";
$id_materia=isset($_POST["id_materia"])? limpiarCadena($_POST["id_materia"]):"";
$jornadamateria=isset($_POST["jornadamateria"])? limpiarCadena($_POST["jornadamateria"]):"";
$grupomateria=isset($_POST["grupomateria"])? limpiarCadena($_POST["grupomateria"]):"";
$dia=isset($_POST["dia"])? limpiarCadena($_POST["dia"]):"";
$corte=isset($_POST["corte"])? limpiarCadena($_POST["corte"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";
$hasta=isset($_POST["hasta"])? limpiarCadena($_POST["hasta"]):"";
$diferencia=isset($_POST["diferencia"])? limpiarCadena($_POST["diferencia"]):"";



date_default_timezone_set("America/Bogota");	
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');


$rsptaperiodo = $horarioplaneacion->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];

switch ($_GET["op"]){
		
	
	case 'buscar':

		$data= Array();
		$data["0"] ="";

		// este codigo se ejecuta cuando se elimina un matareia del horario, para que reargue
		@$valor=$_POST["valor"];
		if($valor==1){
			$id_programa_ac=$_POST["id_programa"];
			$semestre=$_POST["semestre"];
			$jornada=$_POST["jornada"];
			$grupo=$_POST["grupo"];
		}
		/* ****************************************** */

		
		$datos_programa=$horarioplaneacion->listarMaterias($id_programa_ac,$semestre);

		$data["0"] .='
			<div class="col-12 py-2">
				<div class="row align-items-center">
					<div class="pl-2">
							<span class="rounded bg-light-green p-2 text-success ">
							<i class="fa-regular fa-calendar"></i>
							</span> 
					</div>
					<div class="col-10">
					<div class="col-8 fs-14 line-height-18"> 
							<span class="">Asignaturas</span> <br>
							<span class="text-semibold fs-16">Semestre '.$semestre.'</span> 
					</div> 
					</div>
				</div>
			</div>
		';



		$data["0"] .='<div class="col-12">';

			for ($i=0;$i<count($datos_programa);$i++){

				
				$id_materia=$datos_programa[$i]["id"];
				$nombre_materia=$datos_programa[$i]["nombre"];
				$modelo=$datos_programa[$i]["modelo"];
				$data["0"] .='

				<div class="col-12 borde-bottom-2 pt-2"></div>

				<div class="col-12 p-2">
					<div class="row">
						<div class="col-2 p-0 m-0 text-center">';

						if($modelo==1){// si es presencial
							$data["0"] .='<span class="badge badge-primary ">Sede</span>';
						}else{// es modelo pat
							$data["0"] .='<span class="badge bg-maroon ">PAT</span>';
						}

							$data["0"] .='
							<figure class="pt-1">
							<img src="../files/null.jpg" alt="" class="rounded-circle" width="36px" height="36px">
							</figure>
						</div>
						<div class="col-10">
							<div class="row">';

							
								$data["0"] .='
								<div class="col-8 titulo-2 fs-12 line-height-16 text-semibold">'.$nombre_materia.'</div>';

									$traerhorario=$horarioplaneacion->TraerHorario($id_materia,$jornada,$grupo);
									if($traerhorario==true){

										$data["0"] .='<div class="col-4"><a class="badge badge-info text-white pointer" onclick=crear('.$id_materia.',"'.$jornada.'",'.$semestre.','.$grupo.') title="Asignar Horario"><i class="fa fa-plus fa-1x"></i>Nuevo día</a></div>';			
										
										for ($j=0;$j<count($traerhorario);$j++){// trae los dias de clase de horario fijo
											
												$jornada=$traerhorario["$j"]["jornada"];
												$id_horario_fijo=$traerhorario["$j"]["id_horario_fijo"];

												$traerjornadareal=$horarioplaneacion->selectJornadaReal($jornada);
												$jornadareal=$traerjornadareal["codigo"];

												$hora_formato=$horarioplaneacion->traeridhora($traerhorario["$j"]["hora"]);
												$hasta_formato=$horarioplaneacion->traeridhora($traerhorario["$j"]["hasta"]);
												

												$data["0"] .='
													<div class="col-12 fs-12">
														<i class="fa-solid fa-caret-right"></i>
														'. $jornadareal. 
														' ' .$traerhorario["$j"]["dia"]. 
														' '.$hora_formato["formato"] . 
														' a ' . $hasta_formato["formato"] .  
														' - c:' . $traerhorario["$j"]["corte"] . 
													'</div>';
												
												$data["0"] .='
												<div class="col-12">
													<a class="btn btn-link text-danger btn-xs pointer" onclick=eliminarhorario('.$id_horario_fijo.') title="Eliminar Horario"><i class="fa-regular fa-trash-can"></i> </a>
													<a class="btn btn-link text-warning btn-xs" onclick=editar('.$id_horario_fijo.') title="Editar Horario"><i class="fas fa-pen fa-1x"></i> Editar</a>

													<a class="btn btn-link text-success btn-xs" onclick=listarSalones("'.$id_horario_fijo.'","'.$traerhorario["$j"]["dia"].'","'.$traerhorario["$j"]["hora"].'","'.$traerhorario["$j"]["hasta"].'","'.$id_programa_ac.'","'.$grupo.'") class="btn btn-dark btn-xs text-" title="Asignar Salón">
														<i class="fa fa-school fa-1x"></i> Salón '.$traerhorario["$j"]["salon"].' 
													</a>
												</div>';

										}
									}else{
										$data["0"] .='
										<button class="btn btn-success btn-xs" onclick=crear('.$id_materia.',"'.$jornada.'",'.$semestre.','.$grupo.') title="Crear Horario"><i class="fa fa-plus fa-1x"></i> Crear</button>';
									}
									$data["0"] .='
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
			$data["0"] .='
		</div>';
								

		$results = array($data);
			echo json_encode($results);
	break;

	case 'iniciarcalendario':

		$id_programa=$_GET["id_programa"];
		$jornada=$_GET["jornada"];
		$semestre=$_GET["semestre"];
		$grupo=$_GET["grupo"];

		$impresion="";

		$traerhorario=$horarioplaneacion->TraerHorariocalendario($id_programa,$jornada,$semestre,$grupo);
		
		$impresion .='[';

		for ($i=0;$i<count($traerhorario);$i++){
			$id_materia=$traerhorario[$i]["id_materia"];
			$diasemana=$traerhorario[$i]["dia"];
			$horainicio=$traerhorario[$i]["hora"];
			$horafinal=$traerhorario[$i]["hasta"];
			$salon=$traerhorario[$i]["salon"];
			$corte=$traerhorario[$i]["corte"];

			$datosmateria=$horarioplaneacion->BuscarDatosAsignatura($id_materia);
			$nombre_materia=$datosmateria["nombre"];

			switch($diasemana){
				case 'Lunes':
					$dia=1;
				break;
				case 'Martes':
					$dia=2;
				break;
				case 'Miercoles':
					$dia=3;
				break;
				case 'Jueves':
					$dia=4;
				break;
				case 'Viernes':
					$dia=5;
				break;
				case 'Sabado':
					$dia=6;
				break;
				case 'Domingo':
					$dia=0;
				break;
			}

			if($corte=="1"){
				$color="#fff";
			}else{
				$color="#252e53";
			}

			$impresion .= '{"title":"'.$nombre_materia.' - Salón '.$salon.'","daysOfWeek":"'.$dia.'","startTime":"'.$horainicio.'","endTime":"'.$horafinal.'","color":"'.$color.'"}';
			if($i+1<count($traerhorario)){
				$impresion .=',';
			}
		}

		
		
		$impresion .=']';

		echo $impresion;

	break;

	case 'mostrareditar':
		$id_horario_fijo=$_POST["id_horario_fijo"];
		$rspta=$horarioplaneacion->mostrarDatosEditar($id_horario_fijo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

	break;	
		
	case "selectPrograma":	
		$rspta = $horarioplaneacion->selectPrograma();
		echo "<option value=''>-- Seleccionar --</option>";	
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;

	case "selectJornada":	
		$rspta = $horarioplaneacion->selectJornada();
		echo "<option value=''>-- Seleccionar --</option>";	
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . " - " . $rspta[$i]["codigo"] . " </option>";
				}
	break;
		
	case "selectDia":	
		$rspta = $horarioplaneacion->selectDia();
		echo "<option value=''>-- Seleccionar --</option>";	
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;

	case "prerequisito":	
		$rspta = $horarioplaneacion->prerequisito($nombre);
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;

	case "selectHora":	
		$rspta = $horarioplaneacion->listarHorasDia();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["horas"] . "'>" . $rspta[$i]["formato"] . "</option>";
			}
	break;

	case "selectHasta":	
		$hora=$_POST["hora"];

		$traeridhora=$horarioplaneacion->traeridhora($hora);
		$idhorainicio=$traeridhora["id_horas"];

		$rspta = $horarioplaneacion->listarHorasDia();
		echo "<option value=''>Seleccionar</option>";
		for ($i=$idhorainicio;$i<count($rspta);$i++)
			{
				echo "<option value='" . $rspta[$i]["horas"] . "'>" . $rspta[$i]["formato"] . "</option>";
			}
	break;

	case "calcularHoras":	
		$horainicial=$_POST["horainicial"];
		$hasta=$_POST["hasta"];

		$diferencia = $horarioplaneacion->calcularHoras($horainicial,$hasta);

		echo $diferencia;

	break;


	case 'guardaryeditar':
		$data = array();
		$data["0"] ="";

		

		$buscardatosasignatura=$horarioplaneacion->BuscarDatosAsignatura($id_materia);// consulta para traer el id del programa asociado a la materia
		$id_programa_ac=$buscardatosasignatura["id_programa_ac"];
		$semestremateria=$buscardatosasignatura["semestre"];

		$buscardatosprograma=$horarioplaneacion->datosPrograma($id_programa_ac);
		$ciclo=$buscardatosprograma["ciclo"];

		if (empty($id_horario_fijo)){

		// vamos a mirar que la nueva clase no se cruce
		
			/* codigo pra sumerle un minuto a la hora inicial */
			$horaInicial=$hora;
			$minutoAnadir=1;
			$segundos_horaInicial=strtotime($horaInicial);
			$segundos_minutoAnadir=$minutoAnadir*60;
			$nuevaHoraInicial=date("H:i:s",$segundos_horaInicial+$segundos_minutoAnadir);	
		/* ************************************* */

		/* codigo pra sumerle un minuto a la hora final (el hasta) */
			$horaHasta=$hasta;
			$minutoRestar=1;
			$segundos_horaHasta=strtotime($horaHasta);
			$segundos_minutoRestar=$minutoRestar*60;
			$nuevaHoraHasta=date("H:i:s",$segundos_horaHasta-$segundos_minutoRestar);	
		/* ************************************* */

		$mirarcruce=$horarioplaneacion->crucemateria($id_programa_ac,$jornadamateria,$semestremateria,$grupomateria,$dia,$nuevaHoraInicial,$nuevaHoraHasta,$corte);
	

			if($mirarcruce==true){
				$data["0"] ='2'; // cruce de materia

			}else{//todo correcto

			// consulta para insertar la materia si cumple con todo
				$insertarhorario= $horarioplaneacion->insertarhorario($id_programa_ac,$id_materia,$jornadamateria,$semestremateria,$grupomateria,$dia,$hora,$hasta,$diferencia,$corte,$ciclo);
				if($insertarhorario==true){
					$data["0"] ="1"; // resgitro correcto
				}else{
					$data["0"] ="0"; // error
				}
			// ********************************************************
			}

		}else{
			$editarhorario= $horarioplaneacion->editarhorario($id_horario_fijo,$dia,$hora,$hasta,$diferencia);
			if($editarhorario==true){
				$data["0"] ="1"; // resgitro correcto
			}else{
				$data["0"] ="0"; // resgitro incorrecto
			}
		}
		$results = array($data);
		echo json_encode($results);
	break;

	case 'eliminarhorario':
		$data = array();
		$data["0"] ="";

        $id_horario_fijo = $_POST["id_horario_fijo"];

        $eliminarhorario=$horarioplaneacion->eliminarhorario($id_horario_fijo);

		if($eliminarhorario==true){
			$data["0"] ="1"; // correcto
		}else{
			$data["0"] ="0"; // incorrecto
		}

		$results = array($data);
		echo json_encode($results);
	break;

	case 'listarSalones':

		$id_horario_fijo=$_POST["id_horario_fijo"];
		$dia=$_POST["dia"];
		$hora=$_POST["hora"];
		$hasta=$_POST["hasta"];
		$id_programa=$_POST["id_programa"];
		$grupo=$_POST["grupo"];
		
		$rspta=$horarioplaneacion->listarSalones();
		$reg=$rspta;
		
		
		$data= Array();
		$data["0"] ="";

	
		/* codigo pra sumerle un minuto a la hora inicial */
			$horaInicial=$hora;
			$minutoAnadir=1;
			$segundos_horaInicial=strtotime($horaInicial);
			$segundos_minutoAnadir=$minutoAnadir*60;
			$nuevaHoraInicial=date("H:i:s",$segundos_horaInicial+$segundos_minutoAnadir);	
		/* ************************************* */
		/* codigo pra sumerle un minuto a la hora final (el hasta) */
			$horaHasta=$hasta;
			$minutoRestar=1;
			$segundos_horaHasta=strtotime($horaHasta);
			$segundos_minutoRestar=$minutoRestar*60;
			$nuevaHoraHasta=date("H:i:s",$segundos_horaHasta-$segundos_minutoRestar);	
		/* ************************************* */
			
		$data["0"] .='
		<div class="row col-12 m-0 p-0">

		<div class="col-12 tono-3 px-3 py-2">
			<div class="row">
				<div class="col-6">
					<div class="row align-items-center">
						<div class="pl-2">
							<span class="rounded bg-light-green p-3 text-success ">
								<i class="fa-regular fa-calendar" aria-hidden="true"></i>
							</span> 
						</div>
						<div class="col-10">
							<div class="col-8 fs-14 line-height-18"> 
									<span class="">Salón para</span> <br>
									<span class="titulo-2 text-semibold fs-16">'.$dia.'</span> 
							</div> 
						</div>
					</div>
				</div>
				<div class="col-6 py-3">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
			</div>
		</div>
		<div class="col-12 px-4">
		
			<table class="table table-hover" style="width:100%">
				<tbody>
					<tr class="titulo-2 fs-14">
					<th>Salón</th>
					<th>Capacidad</th>
					<th style="width: 40px">Sede</th>
					<th>Acción</th>
					</tr>';
	
					for ($i=0;$i<count($reg);$i++){
						$salon=$reg[$i]["codigo"];
						
						$rspta2=$horarioplaneacion->listarSalonesDisponibles($salon,$dia,$nuevaHoraInicial,$nuevaHoraHasta);
						$reg2=$rspta2;
						if(count($reg2) == 0){
							
								$data["0"] .='<tr>';
									$data["0"] .= '<td>' .$salon . '</td>';
									$data["0"] .='<td>'.$reg[$i]["capacidad"] .'</td>';
									$data["0"] .='<td>'.$reg[$i]["sede"] .'</td>';
									
									$data["0"] .='<td> <a onclick=asignarSalon("'.$id_horario_fijo.'","'.$salon.'") class="badge badge-success btn-xs text-white pointer" title="Asignar salón"><i class="fa fa-check"></i> Asignar</a></td>';
								$data["0"] .='</tr>';
								
						}
							
						
					}
					
					$data["0"] .='
				</tbody>
			</table>
		</div>';
		
 		$results = array($data);
 		echo json_encode($results);
	break;

	case 'asignarSalon':
		$id_horario_fijo=$_POST["id_horario_fijo"];
		$salon=$_POST["salon"];
		$rspta=$horarioplaneacion->asignarSalon($id_horario_fijo,$salon);
		
 		echo json_encode($rspta);
	break;


}
?>