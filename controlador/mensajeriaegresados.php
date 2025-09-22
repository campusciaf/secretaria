<?php 
require_once "../modelos/ConsultaEgresado.php";
session_start();
$consultaegresado=new ConsultaEgresado();
$periodo_actual=$_SESSION['periodo_actual'];
//variable para traer el estado
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$id_credencial=isset($_POST["id_credencial"])? limpiarCadena($_POST["id_credencial"]):"";
$id_credencial_tarea=isset($_POST["id_credencial_tarea"])? limpiarCadena($_POST["id_credencial_tarea"]):"";
$id_credencial_seguimiento=isset($_POST["id_credencial_seguimiento"])? limpiarCadena($_POST["id_credencial_seguimiento"]):"";
$motivo_seguimiento=isset($_POST["motivo_seguimiento"])? limpiarCadena($_POST["motivo_seguimiento"]):"";
$mensaje_seguimiento=isset($_POST["mensaje_seguimiento"])? limpiarCadena($_POST["mensaje_seguimiento"]):"";
date_default_timezone_set("America/Bogota");	
$fecha=date('Y-m-d');
$hora=date('H:i:S');

/* variables para programar tarea */
$motivo_tarea=isset($_POST["motivo_tarea"])? limpiarCadena($_POST["motivo_tarea"]):"";
$mensaje_tarea=isset($_POST["mensaje_tarea"])? limpiarCadena($_POST["mensaje_tarea"]):"";
$fecha_programada=isset($_POST["fecha_programada"])? limpiarCadena($_POST["fecha_programada"]):"";
$hora_programada=isset($_POST["hora_programada"])? limpiarCadena($_POST["hora_programada"]):"";
/* ********************* */

$id_usuario=$_SESSION['id_usuario'];

switch ($_GET["op"]){
	
	
	//consultamos los programas de nivel 3 por estado 5 y 2 (5 == "Egresado" and 2 == "Graduado")
	case 'consultaegresados':
		
		$egresados=$consultaegresado->programasnivel3();
		
		$data = array();
		for ($i = 0; $i < count($egresados); $i ++){
			
			$estado = $egresados[$i]["estado"];
			$programa = $egresados[$i]["fo_programa"];
			
			$nombre_estudiante = $egresados[$i]["credencial_nombre"]." ".$egresados[$i]["credencial_nombre_2"]." ".$egresados[$i]["credencial_apellido"]." ".$egresados[$i]["credencial_apellido_2"];

			// condicional para tomar los estudiantes egresados y graduados			
			if($estado == 5 or $estado ==2){
				
				$estado_nombre = ($estado == 2) ?'<span class="badge badge-primary p-1">Graduado</span>' :'<span class="badge badge-success p-1">Egresado</span>';
				$data[]=array(
					"0"=>'<div class="fila'.$i.'"><div class="btn-group">
						
						<a onclick="verHistorial('.$egresados[$i]["id_estudiante"].')" class="btn btn-primary btn-xs" title="Ver General"><i class="fas fa-eye" style="color: white;"></i></a>
						<a onclick="agregar_seguimiento_egresado('.$egresados[$i]["id_estudiante"].')" class="btn btn-success btn-xs" title="Agregar Seguimiento"><i class="fas fa-plus" style="color: white;"></i></a>
					</div></div>',
					"1"=>'<div class="tooltips">'.$egresados[$i]["credencial_identificacion"].'<span class="tooltiptext">'.$egresados[$i]["id_credencial"].'<br>'.$egresados[$i]["id_estudiante"].'</span> </div>'
					
					,	
					
					"2"=>$nombre_estudiante,	
					"3"=>'<div class="tooltips">'.$egresados[$i]["celular"].'<span class="tooltiptext">'.$egresados[$i]["telefono"].' ' .$egresados[$i]["celular"].'</span></div>',
					"4"=>'<div class="tooltips">'.$egresados[$i]["email"].'<span class="tooltiptext">'.$egresados[$i]["email"].' ' .$egresados[$i]["credencial_login"].'</span></div>',
					
					"5"=>$programa,		
					"6"=>'<div class="tooltips">'.$egresados[$i]["jornada_e"].'<span class="tooltiptext">'.$egresados[$i]["semestre_estudiante"].'</span> </div>',	
					"7"=>$estado_nombre,
					"8"=>$egresados[$i]["periodo_activo"],
					
				
				);
			}

		
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
	break;

	//agregamos el seguimiento para el estudiante
	case 'agregarSeguimiento':
		$rspta=$consultaegresado->insertarSeguimiento($id_usuario,$id_credencial,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora);
			echo $rspta ? "Seguimiento registrado" : "Seguimiento no se pudo registrar";
	break;

	// agregamos la tarea para el estudiante
	case 'agregarTarea':
		$fecha_realizo=NULL;
		$hora_realizo=NULL;
		$rspta=$consultaegresado->insertarTarea($id_usuario,$id_credencial_tarea,$motivo_tarea,$mensaje_tarea,$fecha,$hora,$fecha_programada,$hora_programada,$fecha_realizo,$hora_realizo,$periodo_actual);
			echo $rspta ? "Tarea Programada" : "Tarea no se pudo Programar";
	break;

	//tabla para ver el historial del seguimiento del estudiante
	case 'verHistorialTabla':
		$id_credencial_tabla=$_GET["id_credencial_tabla"];
	
		$rspta=$consultaegresado->verHistorialSeguimientoEgresados($id_credencial_tabla);
		//Vamos a declarar un array
		$data= array();
		$reg=$rspta;
		
		for ($i=0;$i<count($reg);$i++){
			$datoasesor=$consultaegresado->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
			
			$data[]=array(
				"0"=>$reg[$i]["id_credencial"],
				"1"=>$reg[$i]["motivo_seguimiento"],
				"2"=>$reg[$i]["mensaje_seguimiento"],
				"3"=>$consultaegresado->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],			
				"4"=>$nombre_usuario
				
				);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);

	break;	


	//tabla para ver el historial de las tareas 
	case 'verTareasHistorialTabla':
		$id_credencial_tarea=$_GET["id_credencial_tarea"];
	
		$rspta=$consultaegresado->verHistorialTareasEgresados($id_credencial_tarea);
		//Vamos a declarar un array
		$data= array();
		$reg=$rspta;
		
		for ($i=0;$i<count($reg);$i++){
			$datoasesor=$consultaegresado->datosAsesor($reg[$i]["id_usuario"]);
			$nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
			
			$data[]=array(
				"0"=>$reg[$i]["id_credencial"],
				"1"=>$reg[$i]["motivo_tarea"],
				"2"=>$reg[$i]["mensaje_tarea"],
				"3"=>$consultaegresado->fechaesp($reg[$i]["fecha_registro"]) . ' a las ' . $reg[$i]["hora_registro"],			
				"4"=>$nombre_usuario
				
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