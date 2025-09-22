<?php 

require "../config/conexion.php";
require ('../public/mail/sendSolicitud.php');
require ('../public/mail/templateSolicitud.php');

class Solicitudes
{
    

    public function __construct(){
    }

    public function convertir_fecha($date) 
	{
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}

    public function listar($guia)
	{
        global $mbd;
        $data= array();
        $periodo = "2019-1";
		/* $sentencia = $mbd->prepare("");
        $sentencia->execute(); */


        if($guia=="enviadas")
        {
                $sentencia = $mbd->prepare("SELECT solicitudes_viaticos.id,solicitudes_viaticos.id_docentes,solicitudes_viaticos.fecha_solicitud,solicitudes_viaticos.estado,estados_solicitudes_movilizacion.nombre AS estado_solicitud,docente.id_usuario,docente.usuario_nombre,docente.usuario_nombre_2,docente.usuario_apellido,docente.usuario_apellido_2,docente.usuario_identificacion,docente.usuario_tipo_contrato FROM solicitudes_viaticos LEFT JOIN estados_solicitudes_movilizacion ON solicitudes_viaticos.estado=estados_solicitudes_movilizacion.id  LEFT JOIN docente ON solicitudes_viaticos.id_docentes=docente.id_usuario WHERE solicitudes_viaticos.periodo=$periodo AND solicitudes_viaticos.estado='2'");
                $sentencia->execute();
        }
        else
        {
            if( ($guia=="3") || ($guia=="5") )
            {
                $sentencia = $mbd->prepare("SELECT solicitudes_viaticos.id,solicitudes_viaticos.id_docentes,solicitudes_viaticos.fecha_solicitud,solicitudes_viaticos.estado,estados_solicitudes_movilizacion.nombre AS estado_solicitud,docente.id_usuario,docente.usuario_nombre,docente.usuario_nombre_2,docente.usuario_apellido,docente.usuario_apellido_2,docente.usuario_identificacion,docente.usuario_tipo_contrato FROM solicitudes_viaticos LEFT JOIN estados_solicitudes_movilizacion ON solicitudes_viaticos.estado=estados_solicitudes_movilizacion.id  LEFT JOIN docente ON solicitudes_viaticos.id_docentes=docente.id_usuario WHERE  solicitudes_viaticos.periodo=$periodo AND (solicitudes_viaticos.estado='3' || solicitudes_viaticos.estado='5'  )");
                $sentencia->execute();
            }
            else
            {
                $sentencia = $mbd->prepare("SELECT solicitudes_viaticos.id,solicitudes_viaticos.id_docentes,solicitudes_viaticos.fecha_solicitud,solicitudes_viaticos.estado,estados_solicitudes_movilizacion.nombre AS estado_solicitud,docente.id_usuario,docente.usuario_nombre,docente.usuario_nombre_2,docente.usuario_apellido,docente.usuario_apellido_2,docente.usuario_identificacion,docente.usuario_tipo_contrato FROM solicitudes_viaticos LEFT JOIN estados_solicitudes_movilizacion ON solicitudes_viaticos.estado=estados_solicitudes_movilizacion.id LEFT JOIN docente ON solicitudes_viaticos.id_docentes=docente.id_usuario WHERE solicitudes_viaticos.periodo=$periodo AND solicitudes_viaticos.estado='4'");
                $sentencia->execute();
            }	
        }
        while($result_sql_solicitudes = $sentencia->fetch(PDO::FETCH_ASSOC))
			{
                $consulta	=	$mbd->prepare("SELECT SUM(colegios_articulacion.tarifa) AS valor_viaticos FROM colegios_articulacion LEFT JOIN detalle_solicitud ON colegios_articulacion.id=detalle_solicitud.id_colegio  WHERE detalle_solicitud.id_solicitud='".$result_sql_solicitudes['id']."' ");
                $consulta->execute();
                $sql_valor_viaticos = $consulta->fetch(PDO::FETCH_ASSOC);

				$total_viaticos    = 0;
				$total_viaticos    = $total_viaticos + $sql_valor_viaticos['valor_viaticos'];
				
				
                $consultaPrecios   =	$mbd->prepare("SELECT SUM(valor_pago) AS valor_pago FROM pagos_viaticos   WHERE id_solicitud='".$result_sql_solicitudes['id']."' ");
                $consultaPrecios->execute();
                $sql_valor_pagos   = $consultaPrecios->fetch(PDO::FETCH_ASSOC);
				$total_abonado     =    0;
				$total_abonado     =    $total_abonado + $sql_valor_pagos['valor_pago'];
				
				$saldo_pendiente   = 	$total_viaticos - $total_abonado;
				$label = "";
				$mensaje_estado ="";
				$nombre			=$result_sql_solicitudes["usuario_nombre"];
				$nombre_2		=$result_sql_solicitudes["usuario_nombre_2"];
				$apellidos		=$result_sql_solicitudes["usuario_apellido"];
				$apellidos_2	=$result_sql_solicitudes["usuario_apellido_2"];
				$nombre_com=$nombre." ".$nombre_2." ".$apellidos." ". $apellidos_2;
				$cargo 			='Docente';
				$contrato		=$result_sql_solicitudes['usuario_tipo_contrato'];
				$ruta_foto      ="";
				$div_foto       ="";
				switch ($cargo) 
				{
					case 'Docente':
						$ruta_foto="docentes";
						break;
					case 'Administrativo':
						$ruta_foto="fotos_administrativos";
						break;
					case 'Docente Administrativo':
						$ruta_foto="fotos_administrativos";
						break;
				}
				
				if($result_sql_solicitudes['estado'] == "5" ||  $result_sql_solicitudes['estado'] == "3")
				{
					$label = "label-success";
					if($result_sql_solicitudes['estado'] == "3")
					{
						$mensaje_estado = '<h5><label class="label '.$label.'">'.$result_sql_solicitudes['estado_solicitud'].'</label></h5>';
					}
					else
					{
						$mensaje_estado = '<h5><label class="label '.$label.'">'.$result_sql_solicitudes['estado_solicitud'].'</label></h5>';
					}
					
				}
				else if($result_sql_solicitudes['estado'] == "2")
				{
					$label = "label-primary";
					$mensaje_estado = '<h5><label class="label '.$label.'">'.$result_sql_solicitudes['estado_solicitud'].'</label></h5>
										<div class="btn-group">
									   		<a title="Aceptar solicitud" onclick="gestion_solicitud_dir('.$result_sql_solicitudes['id'].',3)" class="btn btn-sm btn-success">
												<i class="fa fa-check"></i>
											</a>
											<a title="Rechazar solicitud" onclick="gestion_solicitud_dir('.$result_sql_solicitudes['id'].',4)" class="btn btn-sm btn-danger">
												<i class="fa fa-times"></i>
											</a>
									   </div>';
				}
				else if($result_sql_solicitudes['estado'] == "4")
				{
					$label = "label-danger";
					$mensaje_estado = '<h5><label class="label '.$label.'">'.$result_sql_solicitudes['estado_solicitud'].'</label></h5>';
				}
				
                $consultaActividades = $mbd->prepare("SELECT COUNT(id) AS numero_solicitudes FROM detalle_solicitud WHERE id_solicitud='".$result_sql_solicitudes['id']."'");
                $consultaActividades->execute();
                
                $sql_numero_actividades = $consultaActividades->fetch(PDO::FETCH_ASSOC);;
				
				if (file_exists("../files/".$ruta_foto."/".$result_sql_solicitudes["usuario_identificacion"].".jpg"))
				{
					$div_foto = '<div class="col-lg-6">
								 	<img style="width: 50px;" class="img-thumbnail" src="../files/'.$ruta_foto.'/'.$result_sql_solicitudes["usuario_identificacion"].'.jpg">
							      </div>';
				}
				else
				{
					$div_foto = '<div class="col-lg-6">
								 	<img style="width: 50px;" class="img-thumbnail" src="../files/null.jpg" >
							     </div>';
				}
				$data[]=array(
					"0"=>	$div_foto.
							'<div class="col-lg-6">
								'.$nombre_com.'<br>
								<i class="fa fa-address-card"></i>'.$result_sql_solicitudes['usuario_identificacion'].'<br>
								<i class="fa fa-calendar-alt"></i>'.$contrato.'<br>
							</div>',
					"1"=>self::convertir_fecha($result_sql_solicitudes['fecha_solicitud']),
					"2"=>$total_viaticos,
					"3"=>$mensaje_estado,
					"4"=>'<a title="Ver clases registradas" onclick="ver_actividades('.$result_sql_solicitudes['id'].','.$result_sql_solicitudes['estado'].')" class="btn btn-sm btn-default">'.$sql_numero_actividades['numero_solicitudes'].'&nbsp;<i class="fa fa-search"></i></a>',
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
        
        
        
    }
    
    public function listarClasesSolicitadas($id)
    {
        global $mbd;
        $data= array();
            $sentencia = $mbd->prepare("SELECT detalle_solicitud.id,solicitudes_viaticos.estado,colegios_articulacion.nombre AS nombre_colegio,docente_grupos.materia,detalle_solicitud.fecha_actividad,municipios_articulacion.nombre AS nombre_municipio,colegios_articulacion.tarifa FROM detalle_solicitud LEFT JOIN solicitudes_viaticos ON detalle_solicitud.id_solicitud=solicitudes_viaticos.id LEFT JOIN docente_grupos ON detalle_solicitud.id_grupo = docente_grupos.id_docente LEFT JOIN colegios_articulacion ON detalle_solicitud.id_colegio=colegios_articulacion.id LEFT JOIN municipios_articulacion ON colegios_articulacion.id_municipio=municipios_articulacion.id WHERE detalle_solicitud.id_solicitud=$id");

            $sentencia->execute();
            
			while($result_sql_clases = $sentencia->fetch(PDO::FETCH_ASSOC))
			{
				$opciones = "";
				if($result_sql_clases['estado']=='1')
				{
					$opciones = '<div class="btn-group">
									<a title="Editar actividad" onclick="abrir_editar_actividad('.$result_sql_clases['id'].')" class="btn btn-sm btn-warning">
										<i class="fa fa-edit"></i>
									</a>
									<a title="Eliminar Actividad" onclick="abrir_eliminar_actividad('.$result_sql_clases['id'].')" class="btn btn-sm btn-danger">
										<i class="fa fa-trash"></i>
									</a>
							     </div>';
				}
				$data[]=array(
					"0"=>$result_sql_clases['nombre_municipio'],
					"1"=>$result_sql_clases['nombre_colegio'],
					"2"=>$result_sql_clases['tarifa'],
					"3"=>$result_sql_clases['materia'],
					"4"=> self::convertir_fecha($result_sql_clases['fecha_actividad']),
					"5"=>$opciones
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
    }

	public function respuestaSolicitud($id,$guia)
	{
		$respuesta = "";
		$mensaje   = "";
		if($guia == "3")
		{
			$respuesta = "Aprobada";	
			$mensaje   = "recuerde imprimir el documento para reclamar el dinero y llevarlo a coordinación adminsitrativa para que se realize el pago, ingresando a la plataforma institucional y posteriormente al  módulo de movilizaciones y presionando el botón <img src='https://www.ciaf.digital/iconos/print_solicitud.svg' width='20px'> de la solicitud";
		}
		else
		{
			$respuesta = "Rechazada";
			$mensaje   = 'su solicitud de gastos de movilización ha sido rechazada, comuniquese con dirección de escuela para obtener mas detalles';
		}

		global $mbd;

		$sentencia= $mbd->prepare("SELECT id_docentes,fecha_solicitud FROM solicitudes_viaticos WHERE id='$id' ");
		$sentencia->execute();
		$sql_id_docente_solicitud = $sentencia->fetch(PDO::FETCH_ASSOC);		
		
		$sentencia2=$mbd->prepare("SELECT usuario_nombre,usuario_nombre_2,usuario_apellido,usuario_apellido_2,usuario_email_ciaf FROM docente WHERE id_usuario='".$sql_id_docente_solicitud['id_docentes']."' ");
		$sentencia2->execute();
		$sql_info_docente = $sentencia2->fetch(PDO::FETCH_ASSOC);

		$docente = $sql_info_docente['usuario_nombre']." ".$sql_info_docente['usuario_nombre_2']." ".$sql_info_docente['usuario_apellido']." ".$sql_info_docente['usuario_apellido_2'];

		$asunto = "Solicitud Viaticos";
		$mensaje2 = set_template($mensaje,$docente);
		enviar_correo($sql_info_docente['usuario_email_ciaf'],$asunto,$mensaje2);
		
		//correo_respuesta_solicitud($sql_id_docente_solicitud['fecha_solicitud'],$mensaje);
		
		if( $guia == '4' )
		{
			$sql_cambiar_estado_detalles = $mbd->prepare(" UPDATE detalle_solicitud SET estado='0' WHERE id_solicitud='$id' ");
			$sql_cambiar_estado_detalles->execute();
		}
		
		$sql_enviar_solicitud = $mbd->prepare("UPDATE solicitudes_viaticos SET estado='$guia' WHERE id='$id' ");
		echo $sql_enviar_solicitud->execute();
	}
    

}
?>