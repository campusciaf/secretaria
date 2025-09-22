<?php 
require_once "../modelos/Docente.php";
require ('../public/mail/sendDocente.php');
require ('../public/mail/templateComunicadoDocente.php');
$docente=new Docente();
$id_docente=$_SESSION['id_usuario'];
	
switch ($_GET["op"]){
		
	case 'listar':
		
		$id=$_GET["id"];// id del docente
		$ciclo=$_GET["ciclo"];// materia docente
		$materia=$_GET["materia"];// materia docente
		$jornada=$_GET["jornada"];// jornada de la materia
		$id_programa=$_GET["id_programa"];// programa de la materia
		$grupo=$_GET["grupo"];// grupo del programa de la materia
		
		$rspta=$docente->listar($ciclo,$materia,$jornada,$id_programa,$grupo);
		$reg=$rspta;
		$estado="";
		
		$rspta2 = $docente->programaacademico($id_programa);	
		$cortes=$rspta2["cortes"];
		$inicio_cortes=1;
		
 		//Vamos a declarar un array
 		$data= Array();
		$data["0"] ="";
		
		
		$data["0"] .= '

			<div class="btn-group pull-right">
                  <button type="button" class="btn btn-success">Opciones de descarga</button>
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a onClick=consulta("'.$ciclo.'","'.$jornada.'","'.trim($id_programa).'","'.$grupo.'","1")>Datos de Contacto</a></li>
                    <li><a onClick=consulta("'.$ciclo.'","'.$jornada.'","'.trim($id_programa).'","'.$grupo.'","2")>Formato para Asistencia</a></li>
                    <li><a onClick=consultaAsistecia("'.$ciclo.'","'.$jornada.'","'.trim($id_programa).'","'.$grupo.'","3")>Reporte de Inasistencia</a></li>				
                    <li class="divider"></li>';
		  $data["0"] .= "     
					<li><a onclick='reporteFinal(".$id_docente.",".$ciclo.",`".$materia."`,`".$jornada."`,".trim($id_programa).",".$grupo.")'>Reporte de Notas</a></li>
                  </ul>
                </div>";
		
			$data["0"] .= '	
				<button onClick=enviarCorreos("'.$ciclo.'","'.$jornada.'","'.trim($id_programa).'","'.$grupo.'") class="btn btn-default pull-right" data-toggle="modal" data-target="#modalEmail"><i class="fas fa-envelope-square text-red"></i> Enviar Mensaje</button>
		';

		$data["0"] .= '
		
		<table id="example" class="table table-bordered table-striped dataTable" style="width:100%">
        <thead>
            <tr>
                <th>Identificación</th>
				<th>Nombre</th>
				<th>Faltas</th>';
		while($inicio_cortes <= $cortes){
			$data["0"] .= '<th>C'.$inicio_cortes.'</th>';
			$inicio_cortes++;
		}
		$data["0"] .= '
                <th>Final</th>
				
            </tr>
        </thead>
        <tbody>';
		$num_id=1;
		for ($i=0;$i<count($reg);$i++){
			
			$rspta3 = $docente->id_estudiante($reg[$i]["id_estudiante"]);
			$id_credencial=$rspta3["id_credencial"];
			
			
			$rspta4 = $docente->estudiante_datos($id_credencial);
			
			if (file_exists('../files/estudiantes/'.$rspta4["credencial_identificacion"].'.jpg')) {
				$foto='<img src=../files/estudiantes/'.$rspta4["credencial_identificacion"].'.jpg width=50px height=50px class=img-circle>';
			}else{
				$foto='<img src=../files/null.jpg width=50px height=50px class=img-circle>';
			}
			
			if($rspta3["estado"]==1){
				$estado="<span class='label label-success'>Activo</span>";
			}else{
				$estado="<span class='label label-warning'>Inactivo</span>";
			}
			
            $habeas_carac = $docente->est_carac_habeas($id_credencial);
            
            if(empty($habeas_carac)){
                $caracterizado = "<span class='label bg-orange'>No</span>";
            }else{
                $caracterizado = "<span class='label bg-navy'>Si</span>";    
            }
            
            
		$data["0"] .= '
			<tr>
				<td><input type="hidden" value="'.$materia.'" id="materia">'.
					$foto.'  '.$rspta4["credencial_identificacion"].' | '.$estado .' | '.$caracterizado .'
				</td>
				<td>'.
					$rspta4["credencial_nombre"]. ' ' . $rspta4["credencial_nombre_2"].' <br>' . $rspta4["credencial_apellido"]. ' ' . $rspta4["credencial_apellido_2"].' ' .'
				</td>
				<td><button type="button" onclick="modalFalta('.$ciclo.','.$reg[$i]["id_estudiante"].','.$id_programa.','.$reg[$i]["id_materia"].')" class="btn btn-warning">'.$reg[$i]["faltas"].'</button></td>
				';
			
				$inicio_cortes=1;
				$corte = $docente->consultaCorte($id_programa,$materia,$docente,$reg[$i]["semestre"],$jornada);
				$corte_nota="";
				while($inicio_cortes <= $cortes){
					$corte_nota="c".$inicio_cortes;
					$retVal = ($corte[$corte_nota] == "1") ? '<input type="text" value="'.$reg[$i][$corte_nota].'" onchange=nota("'.base64_encode($reg[$i]["id_materia"]).'",this.value,"'.$corte_nota.'","'.$ciclo.'") class="form-control">' : $reg[$i][$corte_nota];
					$data["0"] .= '<td class="col-md-1">'.$retVal.'</td>';
					$inicio_cortes++;
				}
				
			$data["0"] .= '	
				<td>'.round($reg[$i]["promedio"], 2).'</td>
				
				
			</tr>
		';
		}

		
		
		$data["0"] .= '
			</tbody>
    	</table>';
		
		
		$results = array($data);
 		echo json_encode($results);	
		break;

	case 'aggfalta':

		$ciclo = $_POST['ciclo'];
		$id_estudiante = $_POST['id_estudiante'];
		$id_programa = $_POST['id_programa'];
		$programa = $_POST['programa'];
		$id_materia = $_POST['id_materia'];
		$fecha = $_POST['fecha'];

		$docente->aggfalta($ciclo,$id_estudiante,$id_programa,$programa,$id_materia,$fecha);
		break;
	case 'consultaEstudiante':
		$ciclo = $_POST['ciclo'];
		$materia = $_POST['materia'];
		$jornada = $_POST['jornada'];
		$id_programa = $_POST['id_programa'];
		$grupo = $_POST['grupo'];
		$medio = $_POST['medio'];

		if ($medio == "1") {
			$id = $docente->consultaDatosContacto($ciclo,$materia,$jornada,$id_programa,$grupo,$medio);
			//print_r($id);
			$cantidad = count($id);
			$data['table'] = "";


			$data['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Email</th><th scope="col">Email CIAF</th><th scope="col">Cel</th>
					</tr>
				</thead>
				<tbody>
			';
			for ($i=0; $i < $cantidad ; $i++) { 
				$datos = $docente->estudiante_datos_completos($id[$i]['0']);
				//print_r($datos);
				$data['table'] .= '<tr>
					<td>'.$datos['credencial_identificacion'].'</td>
					<td>'.$datos['credencial_nombre'].' '.$datos['credencial_nombre_2'].' '.$datos['credencial_apellido'].' '.$datos['credencial_apellido_2'].'</td>
					<td>'.$datos['email'].'</td>
					<td>'.$datos['credencial_login'].'</td>
					<td>'.$datos['celular'].'</td>
				</tr>';

			}
			$data['table'] .= '	</tbody></table>';

			$data['docente'] = $_SESSION['id_usuario'];
			$data['materia'] = $materia;
			$data['jornada'] = $jornada;
			$data['fecha'] = date("d/m/Y");
			$progra = $docente->programaacademico($id_programa);
			$data['programa'] = $progra['nombre'];
			echo json_encode($data);
		}

		if ($medio == "2") {
			$id = $docente->consultaDatosContacto($ciclo,$materia,$jornada,$id_programa,$grupo,$medio);
			$cantidad = count($id);
			$data['table'] = "";


			$data['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Firma</th><th scope="col">Firma 2</th>
					</tr>
				</thead>
				<tbody>
			';
			for ($i=0; $i < $cantidad ; $i++) { 
				$datos = $docente->estudiante_datos_completos($id[$i]['0']);
				$data['table'] .= '<tr>
					<td>'.$datos['credencial_identificacion'].'</td>
					<td>'.$datos['credencial_nombre'].' '.$datos['credencial_nombre_2'].' '.$datos['credencial_apellido'].' '.$datos['credencial_apellido_2'].'</td>
					<td></td>
					<td></td>
				</tr>';

			}
				$data['table'] .= '	</tbody></table>';

				$data['docente'] = $_SESSION['id_usuario'];
				$data['materia'] = $materia;
				$data['jornada'] = $jornada;
				$data['fecha'] = date("d/m/Y");
				$progra = $docente->programaacademico($id_programa);
				$data['programa'] = $progra['nombre'];
			echo json_encode($data);
		}

		if ($medio == "3") {
			$id = $docente->consultaDatosContacto($ciclo,$materia,$jornada,$id_programa,$grupo,$medio);
			$cantidaEstu = count($id);
			$a = 0;
			$e = 0;
			$fechas = "";
			$datos['table'] = "";
			$datos['table'] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th><th scope="col">Estudiante(Nombre completo)</th><th scope="col">Fecha</th>
					</tr>
				</thead>
				<tbody>';

			while ($a < $cantidaEstu){
				$result = $docente->consultaInasistencia($id[$a]['0']);
				
				if (count($result) > 0  ){
					$datos['table'] .= "<tr>";
					$fechas = "";
					$i = 0;
					while($i < count($result)){
						$fechas .= "Falta N° ".($i+1)." : ".$docente->convertir_fecha($result[$i]['fecha_falta'])." \n <br>".PHP_EOL;
						$i++;
					}
					$datosPerso = $docente->estudiante_datos_completos($id[$a]['0']);
					$data[] = array(
						"0" => '<td>'.$datosPerso['credencial_identificacion'].'</td>',
						"1" => '<td>'.$datosPerso['credencial_nombre'].' '.$datosPerso['credencial_nombre_2'].' '.$datosPerso['credencial_apellido'].' '.$datosPerso['credencial_apellido_2'].'</td>',
						"2" => '<td>'.$fechas.'</td>'
					);
					$datos['table'] .= $data[$e]['0'];
					$datos['table'] .= $data[$e]['1'];
					$datos['table'] .= $data[$e]['2'];
					$e++;
					$datos['table'] .= "</tr>";
				}
				/* $datos['table'] .= '</tbody></table>';*/

				$datos['docente'] = $_SESSION['id_usuario'];
				$datos['materia'] = $materia;
				$datos['jornada'] = $jornada;
				$datos['fecha'] = date("d/m/Y");
				$progra = $docente->programaacademico($id_programa);
				$datos['programa'] = $progra['nombre'];
				$a++;
			}
			echo json_encode($datos);
		}

		break;
		
		
	case 'consultaReporteFinal':

			
		$id_docente = $_POST['id_docente'];
		$ciclo = $_POST['ciclo'];
		$materia = $_POST['materia'];
		$jornada = $_POST['jornada'];
		$id_programa = $_POST['id_programa'];
		$grupo = $_POST['grupo'];
		
		//Vamos a declarar un array
		$data= Array();
		$data["table"] ="";

		
		$rsptaDoc=$docente->datosDocente($id_docente);
		$data['docente'] = $rsptaDoc['usuario_nombre'] .' '. $rsptaDoc['usuario_nombre_2'].' '. $rsptaDoc['usuario_apellido'].' '. $rsptaDoc['usuario_apellido_2'];
		
		
		$rspta=$docente->listar($ciclo,$materia,$jornada,$id_programa,$grupo);
		$reg=$rspta;
		$estado="";
		
		$rspta2 = $docente->programaacademico($id_programa);	
		$cortes=$rspta2["cortes"];
		$inicio_cortes=1;
		$data['programa'] = $rspta2['nombre'];// variable que sirve para imprimir el programa y utilizarlo en datatable


			$data["table"] .= '
			<table class="table" id="tbl_listar">
				<thead>
					<tr>
						<th scope="col">Identificación</th>
						<th scope="col">Estudiante(Nombre completo)</th>
						<th scope="col">Faltas</th>';

						while($inicio_cortes <= $cortes){
							$data["table"] .= '<th>C'.$inicio_cortes.'</th>';
							$inicio_cortes++;
						}
			$data["table"] .= '
						<th>Final</th>
				
            		</tr>
        		</thead>
        <tbody>';
		$num_id=1;
		for ($i=0;$i<count($reg);$i++){
			
			$rspta3 = $docente->id_estudiante($reg[$i]["id_estudiante"]);
			$id_credencial=$rspta3["id_credencial"];
			
			
			$rspta4 = $docente->estudiante_datos($id_credencial);
			
			if (file_exists('../files/estudiantes/'.$rspta4["credencial_identificacion"].'.jpg')) {
				$foto='<img src=../files/estudiantes/'.$rspta4["credencial_identificacion"].'.jpg width=50px height=50px class=img-circle>';
			}else{
				$foto='<img src=../files/null.jpg width=50px height=50px class=img-circle>';
			}
			
			if($rspta3["estado"]==1){
				$estado="<span class='label label-success'>Activo</span>";
			}else{
				$estado="<span class='label label-warning'>Inactivo</span>";
			}
			
            $habeas_carac = $docente->est_carac_habeas($id_credencial);
            
            if(empty($habeas_carac)){
                $caracterizado = "<span class='label bg-orange'>No</span>";
            }else{
                $caracterizado = "<span class='label bg-navy'>Si</span>";    
            }
            
            
		$data["table"] .= '
			<tr>
				<td><input type="hidden" value="'.$materia.'" id="materia">'.
					$rspta4["credencial_identificacion"].' | '.$estado .' | '.$caracterizado .'
				</td>
				<td>'.
					$rspta4["credencial_nombre"]. ' ' . $rspta4["credencial_nombre_2"]. ' ' . $rspta4["credencial_apellido"]. ' ' . $rspta4["credencial_apellido_2"].' ' .'
				</td>
				<td>'.$reg[$i]["faltas"].'</td>';
			
				$inicio_cortes=1;
				$corte = $docente->consultaCorte($id_programa,$materia,$docente,$reg[$i]["semestre"],$jornada);
				$corte_nota="";
				while($inicio_cortes <= $cortes){
					$corte_nota="c".$inicio_cortes;
					
					$data["table"] .= '<td class="col-md-1">'.$reg[$i][$corte_nota].'</td>';
					$inicio_cortes++;
				}
				
			$data["table"] .= '	
				<td>'.round($reg[$i]["promedio"], 2).'</td>
				
				
			</tr>
		';
		}

		
		
		$data["table"] .= '
			</tbody>
    	</table>';
		
		
		//$results = array($data);
 		echo json_encode($data);	
		break;
			
		
	case 'enviarCorreos':
		$ciclo = $_POST['ciclo'];
		$materia = $_POST['materia'];
		$jornada = $_POST['jornada'];
		$id_programa = $_POST['id_programa'];
		$grupo = $_POST['grupo'];
		$contenido = $_POST['contenido'];
		$medio = "";
		
		$id = $docente->consultaDatosContacto($ciclo,$materia,$jornada,$id_programa,$grupo,$medio);
		$cantidad = count($id);
		$mensaje = $contenido;
		$asunto = "Comunicado docente";
		$asunto2 = "Evidencia Comunicado docente";
		$nombreDocente = $_SESSION['nombre_docen'];
		$correoDocente = $_SESSION['usuario_login'];
		$mensaje2 = set_templateComunicadoDocente($mensaje,$nombreDocente);
		enviar_correo($correoDocente,$asunto2,$mensaje2);
		for ($i=0; $i < $cantidad; $i++) { 
			$correo = $docente->consultaCorreoEstudiante($id[$i][0]);
			$email = enviar_correo($correo['credencial_login'],$asunto,$mensaje2);
			//print_r($correo['credencial_login']);
		}
		$data['result'] = "ok";
		echo json_encode($data);
		
		break;
	case 'nota':
		$id = $_POST['id'];
		$nota = $_POST['nota'];
		$tl = $_POST['tl'];
		$c = $_POST['c'];
		$pro = $_POST['pro'];
		$docente->agreganota($id,$nota,$tl,$c,$pro);
		//echo base64_decode($id);
		break;
		
		
		case 'programa':

	
		$id_programa=$_GET["id_programa"];// variable que contiene el id del programa
		
		$buscar_programa=$docente->programa($id_programa);// consulta para buscar el nombre de la materia	
		echo  $buscar_programa["nombre"];


	break; 	
}

	

?>
