<?php 
require "../config/conexion.php";

class SolcitudesAprobadas{

    public function listar()
    {
        global $mbd;
        $periodo = '2019-2';
        $data=array();
			
			$sql_solicitudes_aprobadas = $mbd->prepare("SELECT solicitudes_viaticos.id,solicitudes_viaticos.fecha_solicitud,solicitudes_viaticos.estado,docente.usuario_nombre,docente.usuario_nombre_2,docente.usuario_apellido,docente.usuario_apellido_2,docente.usuario_identificacion,docente.usuario_tipo_contrato FROM solicitudes_viaticos LEFT JOIN docente ON solicitudes_viaticos.id_docentes=docente.id_usuario  WHERE solicitudes_viaticos.periodo=:periodo AND (solicitudes_viaticos.estado='3' || solicitudes_viaticos.estado='5') ORDER BY id DESC ");
			$sql_solicitudes_aprobadas->bindParam(":periodo", $periodo);
            
            $sql_solicitudes_aprobadas->execute();
			
			while($result_solicitudes_aprobadas = $sql_solicitudes_aprobadas->fetch(PDO::FETCH_ASSOC))
			{
                $sentencia=	$mbd->prepare("SELECT SUM(colegios_articulacion.tarifa) AS valor_viaticos FROM colegios_articulacion LEFT JOIN detalle_solicitud ON colegios_articulacion.id=detalle_solicitud.id_colegio  WHERE detalle_solicitud.id_solicitud='".$result_solicitudes_aprobadas['id']."' ");

                $sentencia->execute();
                
                $sql_valor_viaticos = $sentencia->fetch(PDO::FETCH_ASSOC);

				$total_viaticos    = 0;
				$total_viaticos    = $total_viaticos + $sql_valor_viaticos['valor_viaticos'];
				
				
                $sentencia2   =	$mbd->prepare("SELECT SUM(valor_pago) AS valor_pago FROM pagos_viaticos   WHERE id_solicitud='".$result_solicitudes_aprobadas['id']."' ");
                $sentencia2->execute();
                $sql_valor_pagos = $sentencia2->fetch(PDO::FETCH_ASSOC);

				$total_abonado     =    0;
				$total_abonado     =    $total_abonado + $sql_valor_pagos['valor_pago'];
				
				$saldo_pendiente   = 	$total_viaticos - $total_abonado;
				$nombre			   =	$result_solicitudes_aprobadas["usuario_nombre"];
				$nombre_2		   =	$result_solicitudes_aprobadas["usuario_nombre_2"];
				$apellidos		   =	$result_solicitudes_aprobadas["usuario_apellido"];
				$apellidos_2	   =	$result_solicitudes_aprobadas["usuario_apellido_2"];
				$nombre_com		   =	$nombre." ".$nombre_2." ".$apellidos." ". $apellidos_2;
				$cargo 			   =	'Docente';
				$contrato		   =	$result_solicitudes_aprobadas['usuario_tipo_contrato'];
				$ruta_foto         =	"";
				$div_foto          =	"";
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
                $sentencia3 = $mbd->prepare("SELECT COUNT(id) AS numero_solicitudes FROM detalle_solicitud WHERE id_solicitud='".$result_solicitudes_aprobadas['id']."'");
                $sentencia3->execute();
                $sql_numero_actividades = $sentencia3->fetch(PDO::FETCH_ASSOC);
				
				$mensaje_pagar	=	"";
				// bloque de condicional para mirar si la solicitud esta en estado 3 ó 5 
				if($result_solicitudes_aprobadas['estado']== "3")
				{
					$mensaje_pagar = '<a class="btn btn-success btn-sm" title="Realizar pago" onclick="abrir_pagar_viaticos('.$result_solicitudes_aprobadas['id'].')"><i class="fa fa-file-invoice-dollar"></i> </a>';
				}
				else
				{
					$mensaje_pagar = "";
				}
				
				// bloque de concicional para mirar si la persona tiene foto o no 
				if (file_exists("../files/".$ruta_foto."/".$result_solicitudes_aprobadas["usuario_identificacion"].".jpg"))
				{
					$div_foto = '<div class="ancho-sm">
								 	<img style="width: 90px;height:50px;" class="img-thumbnail" src="../files/'.$ruta_foto.'/'.$result_solicitudes_aprobadas["usuario_identificacion"].'.jpg">
							      </div>';
				}
				else
				{
					$div_foto = '<div class="col-lg-4">
								 	<img style="width: 50px;" class="img-thumbnail" src="../files/null.jpg" >
							     </div>';
				}
				
				$data[]=array(
					"0"=>$div_foto,
					"1"=>'<div class="">
								'.$nombre_com.'<br>
								<i class="fa fa-address-card"></i>'.$result_solicitudes_aprobadas['usuario_identificacion'].'<br>
								<i class="fa fa-calendar-alt"></i>'.$contrato.'<br>
							</div>',
					"2"=>$result_solicitudes_aprobadas['fecha_solicitud'],
					"3"=>$total_viaticos.'<br/>'.$mensaje_pagar,
					"4"=>$total_abonado.'<br/>
					<a title="Ver pagos realizados" onclick="ver_pagos('.$result_solicitudes_aprobadas['id'].')" class="btn btn-sm btn-info">
						<i class="fa fa-eye"></i>
					</a>',
					"5"=>$saldo_pendiente,
					"6"=>'<a title="Ver clases registradas" onclick="ver_actividades('.$result_solicitudes_aprobadas['id'].','.$result_solicitudes_aprobadas['estado'].')" class="btn btn-sm btn-default">'.$sql_numero_actividades['numero_solicitudes'].'&nbsp;<i class="fa fa-search"></i></a>',
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
    }

    public function listarPagos($id)
    {
        global $mbd;
        $data=array();
            $sql_pagos = $mbd->prepare("SELECT id,fecha_pago,observaciones_admin,valor_pago FROM pagos_viaticos WHERE id_solicitud=".$id);
            $sql_pagos->execute();
			while($result_sql_pagos = $sql_pagos->fetch(PDO::FETCH_ASSOC))
			{
				$data[]=array(
					"0"=>$result_sql_pagos['valor_pago'],
					"1"=>self::convertir_fecha($result_sql_pagos['fecha_pago']),
					"2"=>$result_sql_pagos['observaciones_admin'],
					"3"=>'<div class="btn-group">
							  <a title="Modificar valor" onclick="modificar_valor('.$result_sql_pagos['id'].','.$_GET['id_solicitud'].')" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
							  <a title="Eliminar pago" onclick="eliminar_pago('.$result_sql_pagos['id'].','.$_GET['id_solicitud'].')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
						  </div>',
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
    }

    public function modificarPagos($id)
    {
        global $mbd;
        $data=array();
        $sentencia = $mbd->prepare("SELECT * FROM pagos_viaticos WHERE id = :ids");
        $sentencia->bindParam(":ids", $id);
        $sentencia->execute();
        $datos = $sentencia->fetchAll();
		echo json_encode ($datos);
    }

    public function updatePago($id,$id_soli,$valor,$obser)
    {

		
		$total_pagado    = self::valor_pagos_2($id_soli,$id);
		$total_pagado    = $total_pagado + $valor;
		
		$valor_solicitud = self::valor_solicitud($id_soli);
		
		$saldo_pendiente = $valor_solicitud - $total_pagado;
		
		if($saldo_pendiente >= 0)
		{
			global $mbd;
			$sentencia = $mbd->prepare('UPDATE pagos_viaticos SET valor_pago = :valor, observaciones_admin = :obser WHERE id=:id');
			$sentencia->bindParam(":valor", $valor);
			$sentencia->bindParam(":obser", $obser);
			$sentencia->bindParam(":id", $id);
			$sentencia->execute();

			if($sentencia)
			{
				if($saldo_pendiente == 0)
				{
					$sql_editar_estado = $mbd->prepare("UPDATE solicitudes_viaticos SET estado='5' WHERE id= :id_soli ");
					$sql_editar_estado->bindParam(":id_soli", $id_soli);
					if($sql_editar_estado->execute()){
						$data['status'] = 'ok';				//estado con ok
						$data['result'] = 'Registro guardado con exito';
						
					}else{
						$data['status'] = 'err';				//estado con ok
						$data['result'] = 'No se guardo el registro';
					}

					$mbd = null;
					echo json_encode($data);

				}
				else
				{
					$sql_editar_estado = $mbd->prepare("UPDATE solicitudes_viaticos SET estado='3' WHERE id=:id_soli ");
					$sql_editar_estado->bindParam(":id_soli", $id_soli);

					if($sql_editar_estado->execute()){
						$data['status'] = 'ok';				//estado con ok
						$data['result'] = 'Registro guardado con exito';
						
					}else{
						$data['status'] = 'err';				//estado con ok
						$data['result'] = 'No se guardo el registro';
					}

					$mbd = null;
					echo json_encode($data);

				}
				echo 1;
			}
			else
			{
				echo 0;
			}	
		}
		// final if donde entra cuando si se puede editar el valor del pago
		// else donde entra cuando no se puede editar un pago
		else
		{
			echo "saldo";
		}

        global $mbd;
		$sentencia = $mbd->prepare('UPDATE pagos_viaticos SET valor_pago = :valor, observaciones_admin = :obser WHERE id=:id');
		$sentencia->bindParam(":valor", $valor);
		$sentencia->bindParam(":obser", $obser);
		$sentencia->bindParam(":id", $id);
		if($sentencia->execute()){
			$data['status'] = 'ok';				//estado con ok
			$data['result'] = 'Registro guardado con exito';
			
		}else{
			$data['status'] = 'err';				//estado con ok
            $data['result'] = 'No se guardo el registro';
		}

		$mbd = null;
		echo json_encode($data);
    }

    public function deletePago($id_pa,$id_sol)
    {
        global $mbd;
        $sentencia = $mbd->prepare("DELETE FROM pagos_viaticos WHERE id= :id");
		$sentencia->bindParam(":id", $id_pa);
        $sentencia->execute();
        if($sentencia)
        {
            $sentencia2 = $mbd->prepare("UPDATE solicitudes_viaticos SET estado='3' WHERE id=:id");
            $sentencia2->bindParam(":id", $id_sol);
            
            $sentencia2->execute();

            echo "ok";
        }
        else
        {
            echo "error";
        }
    }

    public function aggPago($id,$valor,$obser)
    {

		global $mbd;
        $periodo = "2018-1";
        $fecha = date('Y-m-d');
		
		$total_pagado    = self::valor_pagos($id);		
		$valor_solicitud = self::valor_solicitud($id);		
		$saldo_pendiente = $valor_solicitud - $total_pagado;		
		if($valor <= $saldo_pendiente)
		{

			$sentencia = $mbd->prepare("INSERT INTO pagos_viaticos (id_solicitud, valor_pago, periodo, observaciones_admin, fecha_pago) VALUES(:id, :valor, :periodo, :obser, :fecha) ");
			$sentencia->bindParam(":id", $id);
			$sentencia->bindParam(":valor", $valor);
			$sentencia->bindParam(":periodo", $periodo);
			$sentencia->bindParam(":fecha", $fecha);
			$sentencia->bindParam(":obser", $obser);
			
			
			if($sentencia->execute())
			{
				if($saldo_pendiente == $valor)
				{
					$sql_editar_estado = $mbd->prepare("UPDATE solicitudes_viaticos SET estado='5' WHERE id= :id ");
					$sql_editar_estado->bindParam(":id", $id);

					if($sql_editar_estado->execute()){
					$data['status'] = 'ok';				//estado con ok
					$data['result'] = 'Registro guardado con exito';
					
					}else{
						$data['status'] = 'err';				//estado con ok
						$data['result'] = 'No se guardo el registro';
					}

					$mbd = null;
					echo json_encode($data);

				}

				echo 1;
				
			}
			else
			{
				echo 0;
			}
		}
		else
		{
			echo "saldo";
		}
        
	}

	public function valor_pagos($id)
	{
		global $mbd;
		$sql_valor_pagos   =	$mbd->prepare("SELECT SUM(valor_pago) AS valor_pago FROM pagos_viaticos WHERE id_solicitud='$id' ");
		$sql_valor_pagos->execute();
		$sentencia = $sql_valor_pagos->fetchAll();
		
		return $sentencia[0]['valor_pago'];
	}
	
	public function valor_solicitud($id)
	{
		global $mbd;
		$sql_valor_viaticos=	$mbd->prepare("SELECT SUM(colegios_articulacion.tarifa) AS valor_viaticos FROM colegios_articulacion LEFT JOIN detalle_solicitud ON colegios_articulacion.id=detalle_solicitud.id_colegio  WHERE detalle_solicitud.id_solicitud='$id' ");
		$sql_valor_viaticos->execute();
		$sentencia = $sql_valor_viaticos->fetchAll();
		return $sentencia[0]['valor_viaticos'];
	}
	
	public function valor_pagos_2($id,$id_pago)
	{
		global $mbd;
		$sql_valor_pagos=$mbd->prepare("SELECT SUM(valor_pago) AS valor_pago FROM pagos_viaticos WHERE id_solicitud='$id' AND id!='$id_pago' ");
		$sql_valor_pagos->execute();
		$sentencia = $sql_valor_pagos->fetchAll();
		return $sentencia[0]['valor_pago'];
	}

	public function listar_clases_solicitud($id)
	{
		$data=array();
		global $mbd;
		$sql_listar_clases=$mbd->prepare("SELECT detalle_solicitud.id,solicitudes_viaticos.estado,colegios_articulacion.nombre AS nombre_colegio,docente_grupos.materia,detalle_solicitud.fecha_actividad,municipios_articulacion.nombre AS nombre_municipio,colegios_articulacion.tarifa FROM detalle_solicitud LEFT JOIN solicitudes_viaticos ON detalle_solicitud.id_solicitud=solicitudes_viaticos.id LEFT JOIN docente_grupos ON detalle_solicitud.id_grupo = docente_grupos.id_docente LEFT JOIN colegios_articulacion ON detalle_solicitud.id_colegio=colegios_articulacion.id LEFT JOIN municipios_articulacion ON colegios_articulacion.id_municipio=municipios_articulacion.id WHERE detalle_solicitud.id_solicitud=:id");
		$sql_listar_clases->bindParam(":id", $id);
		$sql_listar_clases->execute();

		while($result_sql_clases = $sql_listar_clases->fetch(PDO::FETCH_ASSOC))
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
				"4"=>self::convertir_fecha($result_sql_clases['fecha_actividad']),
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
    
}

    

?>