<?php
	error_reporting(1);
	session_start();
	require_once "../modelos/HorarioEspecial.php";
	$horarioespecial = new HorarioEspecial();
	$periodo_actual = $_SESSION['periodo_actual'];
	date_default_timezone_set("America/Bogota");	
	$fecha = date('Y-m-d-H:i:s');
	$id_credencial = isset($_POST["id_credencial"])? limpiarCadena($_POST["id_credencial"]):"";
	$credencial_nombre = isset($_POST["credencial_nombre"])? limpiarCadena($_POST["credencial_nombre"]):"";
	$credencial_nombre_2 = isset($_POST["credencial_nombre_2"])? limpiarCadena($_POST["credencial_nombre_2"]):"";
	$credencial_apellido = isset($_POST["credencial_apellido"])? limpiarCadena($_POST["credencial_apellido"]):"";
	$credencial_apellido_2 = isset($_POST["credencial_apellido_2"])? limpiarCadena($_POST["credencial_apellido_2"]):"";
	$credencial_login = isset($_POST["credencial_login"])? limpiarCadena($_POST["credencial_login"]):"";
	$fo_programa = isset($_POST["fo_programa"])? limpiarCadena($_POST["fo_programa"]):"";
	$jornada_e = isset($_POST["jornada_e"])? limpiarCadena($_POST["jornada_e"]):"";
	// $id_horas_grupos=isset($_POST["id_horas_grupos"])? limpiarCadena($_POST["id_horas_grupos"]):"";
	$semestres = isset($_POST["semestres"])? limpiarCadena($_POST["semestres"]):"";
	$nombre_materia = isset($_POST["$nombre_materia"])? limpiarCadena($_POST["$nombre_materia"]):"";
	$ciclo_homologacion = isset($_POST["ciclo_homologacion"])? limpiarCadena($_POST["ciclo_homologacion"]):"";
	// $id_horas_grupos_input=isset($_POST["id_horas_grupos"])? limpiarCadena($_POST["id_horas_grupos"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		$credencial_identificacion = $_GET["credencial_identificacion"];
		$credencial_clave = md5($credencial_identificacion);
        $rspta = $horarioespecial->insertar($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave);
        $data["0"] = $rspta ? "Estudiante registrado(a) " : "No se pudo registrar el estudiante";
        $rspta = $horarioespecial->traeridcredencial($credencial_identificacion);
        $data["1"] = $rspta["id_credencial"];
        $results = array($data);
        echo json_encode($results);
	break;
	case 'verificardocumento': 
		$credencial_identificacion = $_POST["credencial_identificacion"];
		$rspta = $horarioespecial->verificardocumento($credencial_identificacion);
 		$data = array();
		$data["0"] ="";
		$reg = $rspta;
		if(count($reg) == 0){
			$data["0"] .= $credencial_identificacion;
			$data["1"] = false;
		}else{
			for ($i = 0; $i < count($reg); $i++){	
				$data["0"] .= $reg[$i]["id_credencial"];
			}
			$data["1"] = true;
		}
		$results = array($data);
 		echo json_encode($results);
	break;

	case 'listar':
		$id_credencial = $_GET["id_credencial"];
		$ciclo_ = 9;
		$rspta = $horarioespecial->listar($id_credencial,$ciclo_);
 		//Vamos a declarar un array
 		$data = array();
        $i = 0;			
        while ($i < count($rspta)){
            $rspta2 = $horarioespecial->listarEstado($rspta[$i]["estado"]);
            $data[] = array(
            "0" => '<button class="btn btn-primary btn-xs" onclick="mostrarmaterias('.$rspta[$i]["id_programa_ac"].', '.$rspta[$i]["id_estudiante"].')" title="Matricular Materias"><i class="fas fa-plus-square"></i> Materias</button>',
                "1" => $rspta[$i]["id_estudiante"],
                "2" => $rspta[$i]["fo_programa"],
                "3" => $rspta[$i]["jornada_e"],
                "4" => $rspta[$i]["semestre_estudiante"],
                "5" => $rspta[$i]["grupo"],
                "6" => $rspta[$i]["escuela_ciaf"],
                "7" => $rspta2["estado"],
                "8" => $rspta[$i]["periodo"],
                "9" => $rspta[$i]["periodo_activo"],
            );
            $i++;
        }
 		$results = array(
 			"sEcho" => 1, //Información para el datatables
 			"iTotalRecords" => count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
 			"aaData" => $data);
 		echo json_encode($results);
	break;
	case "mostrardatos":
		$id_credencial = $_POST["id_credencial"];
		$rspta = $horarioespecial->mostrardatos($id_credencial);
		$data = array();
		$data["0"] = "";
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
		$id_programa_ac = $_POST["id_programa_ac"];
		$id_estudiante = $_POST["id_estudiante"];
		// usamos el metodo post para saber el nombre del docente
		//consulta para ver los datos del programa
		$rspta2 = $horarioespecial->datosPrograma($id_programa_ac);
		$reg2 = $rspta2;
		//consulta para ver los datos del programa en que se matriculo el estudiante
		$rspta4 = $horarioespecial->datosEstudiante($id_estudiante);
		$reg4 = $rspta4;
		$jornada_estudio = $reg4["jornada_e"];
		$data = array();
		$data["0"] = "";
        $semestres_del_programa = $reg2["semestres"];
        $ciclo = "materias".$reg2["ciclo"];// para saber en que tabla debe buscar las materias
        $cortes = $reg2["cortes"];// para saber en que tabla debe busar las materias
		$anchodiv = 0;
		switch ($semestres_del_programa) {
			case 1:
				$anchodiv .= '<div class="col-xl-6 col-lg-6 col-md-6 col-12">';
			break;
			case 2:
				$anchodiv .= '<div class="col-xl-6 col-lg-6 col-md-6 col-12">';
			break;
			case 3:
				$anchodiv .= '<div class="col-xl-4 col-lg-4 col-md-4 col-12">';
			break;
			case 4:
				$anchodiv .= '<div class="col-xl-3 col-lg-3 col-md-3 col-12">';
			break;
			case 5:
				$anchodiv .= '<div class="col-xl-2 col-lg-2 col-md-3 col-12">';				
			break;
		}
		$semestres = 1;
        while($semestres <= $semestres_del_programa){
            $data["0"] .= $anchodiv;
                $data["0"] .= '
                <div class="card">
                    <div class="card-header border-1">
                        <h3 class="card-title"> Semestre ' .$semestres.' </h3>
                        <div class="card-tools">
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">';
                        $rspta = $horarioespecial->listarMaterias($id_programa_ac,$semestres);
                        $reg = $rspta;
                        for ($i=0;$i<count($reg);$i++){
                            $id_materia=$reg[$i]["id"];
                            $id_programa_ac=$reg[$i]["id_programa_ac"];
                            $materia=$reg[$i]["nombre"];// nombre de la materia 
                            $creditos=$reg[$i]["creditos"];
                            $rspta3 = $horarioespecial->datosMateriaMatriculada($ciclo,$id_estudiante,$materia,$semestres);
                            $reg3=$rspta3;
							// print_r($reg3);
                            $id_materia_matriculada=$reg3["id_materia"];
                            // $estado_homologado=$reg3["huella"];
							$estado_homologacion=$reg3["huella"];
                            $promedio_materia_matriculada=$reg3["promedio"];
                            $grupo = $reg3["grupo"];
                            if($periodo_actual == $reg3["periodo"] ){
                                $color = "success";
                            }else if($periodo_actual != $reg3["periodo"]){
                                $boton_eliminar = '';
                                if($reg3["promedio"] > 0 and $reg3["promedio"] < 3){
                                    $color = "danger";
                                }else if($reg3["promedio"] >= 3){
                                    $color = "success";
                                }else{
                                    $color = "info";
                                }
                            }
                            $data["0"] .= '<div class="alert bg-'.$color.'">';
                            $data["0"] .= $boton_eliminar;
                            $data["0"] .= '<small class="label text-white">['.$creditos.']</small>';
                            $data["0"] .= $materia .'<br><br>';
                            $inicio_corte = 1;
                            $jornada_matriculada=$reg3['jornada'];
                            $periodo_matriculada=$reg3["periodo"];

                            if($rspta3){
								$id_docente=$_POST["id_docente"];
								$nombre_materia = $materia;
								$rspta_especial = $horarioespecial->horarioEspecial($nombre_materia);
								$dia_especial = "";
								$hora_especial = "";
								$salon_especial = "";
								$hasta_especial = "";
								$docente_asignado_h  = "";
								// $id_docente_grupo_homologacion = "";
								$nombre_docente_h = "";
								$id_horas_grupos = "";
								for ($s = 0; $s < count($rspta_especial); $s++){
									// print_r($rspta_especial);
									$dia_especial =  $rspta_especial[$s]["dia"];
									$hora_especial =  $rspta_especial[$s]["hora"];
									$hasta_especial =  $rspta_especial[$s]["hasta"];
									$salon_especial =  $rspta_especial[$s]["salon"];
									$docente_asignado_h  =  $rspta_especial[$s]["docente_asignado"];
									$id_docente_grupo_homologacion =  $rspta_especial[$s]["id_docente_grupo"];
									$id_horas_grupos =  $rspta_especial[$s]["id_horas_grupos"];
									$nombre_docente = $horarioespecial->nombre_docente($id_docente_grupo_homologacion);
									$nombre_docente_h =  $nombre_docente["usuario_nombre"]. ' '.$nombre_docente["usuario_nombre_2"]. ' '.$nombre_docente["usuario_apellido"]. ' '.$nombre_docente["usuario_apellido_2"];
								}
								if($estado_homologacion == "Homomologación"){
                                    $data["0"] .= '
									<label> Promedio: </label>
									<a class="btn bg-gradient-secondary btn-xs"  title="Promedio">'.$promedio_materia_matriculada.'</a>';
									$estado_homologacion = $reg3["huella"];
									$data["0"] .= $estado_homologacion = ($estado_homologacion == "Homomologación") ?'<br> <span class="badge badge-danger p-2 mt-3">Homologada</span>' :'<br> <br><span class="badge badge-warning p-2">Sin Homologar</span> ';
					
                                }if($docente_asignado_h == ""){
									$data["0"] .='
									<div class="form-row">
										<div class="col">
										<div id="btn_docente" class="btn btn-xs bg-gradient-secondary btn-flat" onclick="seleccionar_docente('.$id_materia_matriculada.', `'.$periodo_matriculada.'`, `'.$ciclo.'`, `'.$nombre_materia.'`)" title="Asignar Docente">Asignar Docente</div><br>
										</div>
										<div class="col">
										<div id="btn_docente" class="btn btn-xs bg-gradient-secondary btn-flat" onclick="seleccionar_cualquier_docente('.$id_materia_matriculada.', `'.$periodo_matriculada.'`, `'.$ciclo.'`,`'.$materia.'`,`'.$semestres.'`)" title="Asignar Docente">Docente Libre</div><br>
										</div>
									</div>';
										}if($docente_asignado_h == 1){
											// echo $docente_asignado_h;
											$data["0"] .= '
											<br>
											<div class="float-md-right">
												<button onclick="mostrar_editar_docente('.$id_materia_matriculada.', `'.$periodo_matriculada.'`, `'.$ciclo.'`, `'.$id_horas_grupos.'`,`'.$nombre_materia.'`)" class="btn btn-warning btn-xs" title="Editar Docente" data-toggle="tooltip" data-placement="top"> <i class="fas fa-pencil-alt"></i> </button>
												<button onclick="eliminar_docente('.$id_horas_grupos.')" class="btn btn-danger btn-xs" title="Eliminar Docente" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>
											</div>
											<div class="row">
												<div class="col-6 col-sm-3 col-xl-3 col-lg-3 col-md-3 col-12">
												<label> Dia: </label>
												'. $dia_especial . '</div>
												<div class="col-6 col-sm-3 col-xl-3 col-lg-3 col-md-3 col-12">
												<label> Inicio: </label>
												'. $hora_especial . '</div>
												<div class="col-6 col-sm-3 col-xl-3 col-lg-3 col-md-3 col-12">
												<label> Final: </label>
												'. $hasta_especial . '</div>
												<div class="col-6 col-sm-3 col-xl-3 col-lg-3 col-md-3 col-12">
												<label> Salón: </label>
												'. $salon_especial . '</div>
												<div class="col-6  col-12">
												<label> Docente:  </label>
												'. $nombre_docente_h . '</div>
											</div><br><br>';
										}
                            }else{
								$estado_homologacion=$reg3["huella"];
								$data["0"] .=	$estado_homologacion = ($estado_homologacion == "Homomologación") ?'<span class="badge badge-danger p-2 ">Homologada</span>' :'<span class="badge badge-warning p-2">Sin Homologar</span>';
							}
                            $data["0"] .= '</div>';
                        }
                        $data["0"] .='</div>
                                </div>';
                $data["0"] .='</div>';
            $data["0"] .='</div>';
            $data["0"] .='</div>';
            $data["0"] .='</div>';
            $data["0"] .='</div>';
            $semestres++;
        }
        $results = array($data);
        echo json_encode($results);
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
					</thead>
					<tbody>';
		$rspta = $horarioespecial->mostrarmateriasdisponibles($nombre_materia);
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
			$id_horas_grupos =  $rspta[$i]["id_horas_grupos"];
			$nombre_docente =  $rspta[$i]["usuario_nombre"]. ' '.$rspta[$i]["usuario_nombre_2"]. ' '.$rspta[$i]["usuario_apellido"]. ' '.$rspta[$i]["usuario_apellido_2"];
			$data["0"] .='<tr>'
							.'<td>' .$nombre_docente . '</td>'
							.'<td>' .$usuario_identificacion . '</td>'
							.'<td>'.$dia .'</td>'
							.'<td>'.$hora.'</td>'
							.'<td>'.$hasta.'</td>'
							.'<td>'.$salon.'</td>'
							.'<td>'.$periodo.'</td>'
							.'<td>'.$jornada.'</td>';
			$data["0"] .='<td> 

			<span class="btn btn-success" onclick="asignar_docente('.$id_docente_grupo.', `'.$dia.'`, `'.$hora.'`,`'.$hasta.'`,`'.$diferencia.'`,`'.$salon.'`,`'.$nombre_materia.'`, `'.$periodo.'`)" title="Asignar Docente">
			<i class="fas fa-plus"></i>
			</span>
			</td>
			
			
			
			';
			$data["0"] .='</tr>';
			
		}
		
		$data["0"] .='
		</tbody>
		</table>
			</div>
		</div>';
		
		echo json_encode($data);
	break;


	
	case 'asignar_docente':
		$data["0"] ="";
		$id_docente = $_POST['id_docente_grupo'];
		$dia = $_POST['dia'];
		$hora = $_POST['hora'];
		$hasta = $_POST['hasta'];
		$diferencia = $_POST['diferencia'];
		$salon = $_POST['salon'];
		$nombre_materia = $_POST['nombre_materia'];
		$periodo = $_POST['periodo'];

		$horarioespecial->asignar_docente($id_docente,$dia,$hora,$hasta,$diferencia,$salon,$nombre_materia,$periodo);

		echo $horarioespecial ? "Docente Asignado" : "Docente no se pudo asignar";
		
	break;


	case 'asignar_cualquier_docente':
		$data["0"] ="";
		$id_docente = $_POST['id_docente_grupo'];
		$dia = $_POST['dia'];
		$hora = $_POST['hora'];
		$hasta = $_POST['hasta'];
		$diferencia = $_POST['diferencia'];
		$salon = $_POST['salon'];
		$nombre_materia = $_POST['materia'];
		$periodo = $_POST['periodo'];

		$horarioespecial->asignar_docente($id_docente,$dia,$hora,$hasta,$diferencia,$salon,$nombre_materia,$periodo);

		echo $horarioespecial ? "Docente Asignado" : "Docente no se pudo asignar";
		
	break;

	case 'seleccionar_cualquier_docente':


		$nombre_materia = $_POST['nombre'];
		$periodo = $_POST['periodo'];

		$materia=$_POST["materia"];
		$data["0"] ="";
			$data["0"] .='
			<div class="box">
            <!-- /.box-header -->
            <div class="box-body no-padding">
			<h4> <b></b></h4>
				<table id="mostrardocentes_todos" class="table table-striped table-bordered table-condensed table-hover">
					
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

		$rspta = $horarioespecial->mostrarmateriasdisponiblestodos();
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
			$id_horas_grupos =  $rspta[$i]["id_horas_grupos"];

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

			<span class="btn btn-success" onclick="asignar_cualquier_docente('.$id_docente_grupo.', `'.$dia.'`, `'.$hora.'`,`'.$hasta.'`,`'.$diferencia.'`,`'.$salon.'`,`'.$materia.'`, `'.$periodo.'`)" title="Asignar Docente">
			<i class="fas fa-plus"></i>
			</span>
			</td>';
			$data["0"] .='</tr>';
			
		}
		
		$data["0"] .='
		</tbody>
		</table>
			</div>
		</div>';
		
		echo json_encode($data);
	break;


	case 'mostrar_docente':
		$id_horas_grupos=$_POST["id_horas_grupos"];
		$rspta = $horarioespecial->mostrar_docente($id_horas_grupos);
		// print_r($rspta);
		echo json_encode($rspta);
	break;

	case 'eliminar_docente':
		$id_horas_grupos = $_POST["id_horas_grupos"];
		$eliminar = $horarioespecial->eliminarDocente($id_horas_grupos);
		echo json_encode($eliminar);
	break;



	case 'mostrar_editar_docente':

		$id_horas_grupos_input = $_POST['id_horas_grupos'];

		$data["0"] ="";
			$data["0"] .='
			<div class="box">
            <!-- /.box-header -->
            <div class="box-body no-padding">
			<h4> <b></b></h4>
				<table id="editar_docentes_todos" class="table table-striped table-bordered table-condensed table-hover">
					
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

		$rspta = $horarioespecial->mostrarmateriasdisponiblestodos();
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
			$id_horas_grupos =  $rspta[$i]["id_horas_grupos"];
			
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

			

			<span class="btn btn-success" onclick="editar_asignar_cualquier_docente( `'.$dia.'`, `'.$hora.'`,`'.$hasta.'`,`'.$salon.'`,`'.$id_horas_grupos_input.'`,`'.$id_docente_grupo.'`)" title="Asignar Docente">
			<i class="fas fa-plus"></i>
			</span>
			</td>';
			$data["0"] .='</tr>';
			
		}
		
		$data["0"] .='
		</tbody>
		</table>
			</div>
		</div>';
		
		echo json_encode($data);
	break;


	case 'editar_asignar_cualquier_docente':
		$data["0"] ="";
		$id_horas_grupos_input = $_POST['id_horas_grupos_input'];
		$dia = $_POST['dia'];
		$hora = $_POST['hora'];
		$hasta = $_POST['hasta'];
		$salon = $_POST['salon'];
		$id_docente_grupo = $_POST['id_docente_grupo'];

		$horarioespecial->EditarDocenteCualquiera($dia, $hora, $hasta, $salon,$id_horas_grupos_input,$id_docente_grupo);

		echo $horarioespecial ? "Docente Editado" : "Docente no se pudo Editar";
		
	break;





}
