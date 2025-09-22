<?php 
require "../config/Conexion.php";
class OncenterCliente
{

	public function periodoactual(){
    	$sql="SELECT * FROM on_periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    public function consulta($val)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados` WHERE $val ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consulta_id($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados` WHERE `id_estudiante` = $id ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function entrevista($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_entrevista` WHERE `id_estudiante` = $id ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
	}
	
	public function datos_personales($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados_datos` WHERE `id_estudiante` = $id ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }


    public function soporte_inscripcion($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_soporte_inscripcion` WHERE `id_estudiante` = $id ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

	public function soporte_compromiso($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_soporte_compromiso` WHERE `id_estudiante` = $id ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    // inicio agregar tareas, seguimiento y historial

        //Implementamos un método para insertar seguimiento
        public function insertarSeguimiento($id_usuario,$id_estudiante_agregar,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora)
        {
            $sql="INSERT INTO on_seguimiento (id_usuario,id_estudiante,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento)
            VALUES ('$id_usuario','$id_estudiante_agregar','$motivo_seguimiento','$mensaje_seguimiento','$fecha','$hora')";
			
            global $mbd;
            $consulta = $mbd->prepare($sql);
            return $consulta->execute();
        }
        
        //Implementamos un método para insertar una tarea
        public function insertarTarea($id_usuario,$id_estudiante_tarea,$motivo_tarea,$mensaje_tarea,$fecha_registro,$hora_registro,$fecha_programada,$hora_programada,$periodo_actual)
        {
            $sql="INSERT INTO on_interesados_tareas_programadas (id_usuario,id_estudiante,motivo_tarea,mensaje_tarea,fecha_registro,hora_registro,fecha_programada,hora_programada,fecha_realizo,hora_realizo,periodo)
            VALUES ('$id_usuario','$id_estudiante_tarea','$motivo_tarea','$mensaje_tarea','$fecha_registro','$hora_registro','$fecha_programada','$hora_programada',NULL,NULL,'$periodo_actual')";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            return $consulta->execute();
        }
        //Implementar un método para eliminar el interesado
        public function datosAsesor($id_usuario)
        {
            $sql="SELECT * FROM usuario WHERE id_usuario= :id_usuario"; 
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_usuario", $id_usuario);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;

        }
        // public function fechaesp($date) {
        //     $dia 	= explode("-", $date, 3);
        //     $year 	= $dia[0];
        //     $month 	= (string)(int)$dia[1];
        //     $day 	= (string)(int)$dia[2];

        //     $dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
        //     $tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

        //     $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        //     return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
        // }

		public function fechaesp($date) {
			if (empty($date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
				// Retornar un valor predeterminado o manejar el error
				return "Fecha no disponible";
			}
		
			$parts = explode("-", $date, 3);
			if (count($parts) !== 3) {
				// Si la fecha no se puede dividir correctamente en año, mes y día
				return "Formato de fecha incorrecto";
			}
		
			$year   = $parts[0];
			$month  = (int)$parts[1];  // Convertir a entero para eliminar ceros no significativos
			$day    = (int)$parts[2];
		
			$days       = array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
			$dayOfWeek  = $days[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))];
		
			$months = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		
			return $dayOfWeek . ", " . $day . " de " . $months[$month] . " de " . $year;
		}
		
        //Implementar un método para listar el historial de seguimiento
        public function verHistorialTabla($id_estudiante)
        {	
            $sql="SELECT * FROM on_seguimiento WHERE id_estudiante= :id_estudiante";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_estudiante", $id_estudiante);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }
        
        //Implementar un método para listar el historial de seguimiento
        public function verHistorialTablaTareas($id_estudiante)
        {	
            $sql="SELECT * FROM on_interesados_tareas_programadas WHERE id_estudiante= :id_estudiante";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_estudiante", $id_estudiante);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }
    // fin agregar tareas, seguimiento y historial

    //Implementamos un método para actualziar el estado del mailing
	public function actualizarMailing($id_estudiante)
	{
		$sql="UPDATE on_interesados SET mailing=0 WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

    }
	 //Implementamos un método para actualziar el campo segui
	public function actualizarSegui($id_estudiante)
	{
		$sql="UPDATE on_interesados SET segui=0 WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

    }
    //Implementamos un método para insertar un seguimiento
	public function registrarSeguimiento($id_usuario,$id_estudiante_documento,$motivo,$mensaje_seguimiento,$fecha,$hora)
	{
		$id_usuario = $_SESSION['id_usuario'];
		$sql="INSERT INTO on_seguimiento (id_usuario,id_estudiante,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento) VALUES ('$id_usuario','$id_estudiante_documento','$motivo','$mensaje_seguimiento','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
    }
    //Implementar un método para listar los interesados

	// pendiente por borrar
	public function VerHistorial($id_estudiante)
	{	
		$sql="SELECT * FROM on_interesados oni INNER JOIN on_interesados_datos onid ON oni.id_estudiante=onid.id_estudiante WHERE oni.id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
    
    //Implementamos un método para actualizar el estado del formulario
	public function actualizarDocumentos($id_estudiante)
	{
		$sql="UPDATE on_interesados SET documentos=0 WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

    }
    
    //Implementar un método para mostrar los datos de un registro a modificar
	public function verDatosEstudiante($id_estudiante)
	{
		$sql="SELECT * FROM on_interesados WHERE id_estudiante= :id_estudiante";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	    //Implementamos un método para cambio de estado a inscrito
	public function cambioEstadoInscrito($id_estudiante)
	{
		$sql="UPDATE on_interesados SET estado='Inscrito' WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

    }
	
    //Implementamos un método para cambio de estado a admitido
	public function cambioEstadoAdmitido($id_estudiante)
	{
		$sql="UPDATE on_interesados SET estado='Admitido' WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

    }
	
	    //Implementamos un método para actualizar el estado del formulario de inscripción
	public function actualizarFormularioInscripcion($id_estudiante)
	{
		$sql="UPDATE on_interesados SET formulario=0 WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

    }
    
    //Implementamos un método para actualizar el estado del recibo de inscripción
	public function actualizarInscripcion($id_estudiante)
	{
		$sql="UPDATE on_interesados SET inscripcion=0 WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

    }
    
    //Implementamos un método para ver el recibo de inscripcion
	public function verEntrevista($id_estudiante)
	{
		$sql="SELECT * FROM on_entrevista WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

    }
	public function actualizarEntrevistaAsesor($parametros)
{
    global $mbd;

    $sql = "UPDATE on_entrevista SET
        salud_fisica = :salud_fisica,
        salud_mental = :salud_mental,
        condicion_especial = :condicion_especial,
        nombre_condicion_especial = :nombre_condicion_especial,
        estres_reciente = :estres_reciente,
        desea_apoyo_mental = :desea_apoyo_mental,
        costea_estudios = :costea_estudios,
        labora_actualmente = :labora_actualmente,
        donde_labora = :donde_labora,
        tiempo_laborando = :tiempo_laborando,
        desea_beca = :desea_beca,
        responsabilidades_familiares = :responsabilidades_familiares,
        seguridad_carrera = :seguridad_carrera,
        penso_abandonar = :penso_abandonar,
        desea_referir = :desea_referir,
        rendimiento_prev = :rendimiento_prev,
        necesita_apoyo_academico = :necesita_apoyo_academico,
        nombre_materia = :nombre_materia,
        tiene_habilidades_organizativas = :tiene_habilidades_organizativas,
        comodidad_herramientas_digitales = :comodidad_herramientas_digitales,
        acceso_internet = :acceso_internet,
        acceso_computador = :acceso_computador,
        estrato = :estrato,
        municipio_residencia = :municipio_residencia,
        direccion_residencia = :direccion_residencia,
        nombre_referencia_familiar = :nombre_referencia_familiar,
        telefono_referencia_familiar = :telefono_referencia_familiar,
        parentesco_referencia_familiar = :parentesco_referencia_familiar
    WHERE id_estudiante = :id_estudiante";

    $consulta = $mbd->prepare($sql);

    foreach ($parametros as $clave => $valor) {
        $consulta->bindParam(':' . $clave, $parametros[$clave]);
    }

    return $consulta->execute();
}

    
    //Implementamos un método para actualizar el estado del formulario
	public function actualizarEntrevista($id_estudiante)
	{
		$sql="UPDATE on_interesados SET entrevista=0, estado='Seleccionado' WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

    }
    
    //Implementamos un método para ver el soporte de la cédula
	public function soporteCedula($id_estudiante)
	{
		$sql="SELECT * FROM on_soporte_cedula WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}

    //Implementamos un método para ver el soporte del diploma
	public function soporteDiploma($id_estudiante)
	{
		$sql="SELECT * FROM on_soporte_diploma WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}	

    //Implementamos un método para ver el soporte del diploma
	public function soporteActa($id_estudiante)
	{
		$sql="SELECT * FROM on_soporte_acta WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}
	
    //Implementamos un método para ver el soporte de salud
	public function soporteSalud($id_estudiante)
	{
		$sql="SELECT * FROM on_soporte_salud WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}
    //Implementamos un método para ver el soporte pruebas
	public function soportePrueba($id_estudiante)
	{
		$sql="SELECT * FROM on_soporte_prueba WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}
	//Implementamos un método para ver el soporte pruebas
	public function soporteCompromiso($id_estudiante)
	{
		$sql="SELECT * FROM on_soporte_compromiso WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}
	

	//Implementamos un método para ver el soporte pruebas
	public function misoporteProteccionDatos($id_estudiante)
	{
		$sql="SELECT * FROM on_soporte_proteccion_datos WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}
	
	//Implementamos un método para ver el soporte pruebas
	public function misoporteIngles($id_estudiante)
	{
		$sql="SELECT * FROM on_soporte_ingles WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}
    //Implementamos un método para validar los documentos
	public function validar($id_estudiante,$soporte,$fecha,$hora,$usuario)
	{
		if($soporte==1){
			$tabla="on_soporte_cedula";	
		}
		if($soporte==2){
			$tabla="on_soporte_diploma";	
		}
		if($soporte==3){
			$tabla="on_soporte_acta";	
		}
		if($soporte==4){
			$tabla="on_soporte_salud";	
		}
		if($soporte==5){
			$tabla="on_soporte_prueba";	
		}
		
		$sql="UPDATE $tabla SET fecha_validacion='$fecha', hora_validacion='$hora', usuario_validacion='$usuario', validado=0 WHERE id_estudiante='$id_estudiante'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();

	}

	public function agregar_soporte_inscripcion($id,$evidencia,$fecha,$hora,$id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" INSERT INTO `on_soporte_inscripcion`(`id_estudiante`, `nombre_archivo`, `fecha_subida`, `hora_subida`, `usuario_subida`) VALUES (:id_estudiante,:evidencia,:fecha,:hora,:id_usuario) ");
		$sentencia->bindParam(":id_estudiante",$id);
		$sentencia->bindParam(":evidencia",$evidencia);
		$sentencia->bindParam(":fecha",$fecha);
		$sentencia->bindParam(":hora",$hora);
		$sentencia->bindParam(":id_usuario",$id_usuario);
		if ($sentencia->execute()) {
			$data['id_estudiante'] = $id;
			$data['status'] = 'ok';
			$data['msj'] = 'Soporte registrado con exito';
		} else {
			$data['status'] = 'error';
			$data['msj'] = 'Error al registar el soporte';
		}

		echo json_encode($data);
		
	}

	public function agregar_soporte_digitales1($id,$evidencia,$fecha,$hora,$id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" INSERT INTO `on_soporte_cedula`(`id_estudiante`, `nombre_archivo`, `fecha_subida`, `hora_subida`, `usuario_subida`) VALUES (:id_estudiante,:evidencia,:fecha,:hora,:id_usuario) ");
		$sentencia->bindParam(":id_estudiante",$id);
		$sentencia->bindParam(":evidencia",$evidencia);
		$sentencia->bindParam(":fecha",$fecha);
		$sentencia->bindParam(":hora",$hora);
		$sentencia->bindParam(":id_usuario",$id_usuario);
		if ($sentencia->execute()) {
			$data['status'] = 'ok';
			$data['msj'] = 'Soporte registrado con exito';
		} else {
			$data['status'] = 'error';
			$data['msj'] = 'Error al registar el soporte';
		}

		echo json_encode($data);
		
	}
	public function agregar_soporte_digitales2($id,$evidencia,$fecha,$hora,$id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" INSERT INTO `on_soporte_diploma`(`id_estudiante`, `nombre_archivo`, `fecha_subida`, `hora_subida`, `usuario_subida`) VALUES (:id_estudiante,:evidencia,:fecha,:hora,:id_usuario) ");
		$sentencia->bindParam(":id_estudiante",$id);
		$sentencia->bindParam(":evidencia",$evidencia);
		$sentencia->bindParam(":fecha",$fecha);
		$sentencia->bindParam(":hora",$hora);
		$sentencia->bindParam(":id_usuario",$id_usuario);
		if ($sentencia->execute()) {
			$data['status'] = 'ok';
			
			$data['msj'] = 'Soporte registrado con exito';
		} else {
			$data['status'] = 'error';
			$data['msj'] = 'Error al registar el soporte';
		}

		echo json_encode($data);
		
	}
	public function agregar_soporte_digitales3($id,$evidencia,$fecha,$hora,$id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" INSERT INTO `on_soporte_acta` (`id_estudiante`, `nombre_archivo`, `fecha_subida`, `hora_subida`, `usuario_subida`) VALUES (:id_estudiante,:evidencia,:fecha,:hora,:id_usuario) ");
		$sentencia->bindParam(":id_estudiante",$id);
		$sentencia->bindParam(":evidencia",$evidencia);
		$sentencia->bindParam(":fecha",$fecha);
		$sentencia->bindParam(":hora",$hora);
		$sentencia->bindParam(":id_usuario",$id_usuario);
		if ($sentencia->execute()) {
			$data['status'] = 'ok';
			$data['msj'] = 'Soporte registrado con exito';
		} else {
			$data['status'] = 'error';
			$data['msj'] = 'Error al registar el soporte';
		}

		echo json_encode($data);
		
	}
	public function agregar_soporte_digitales4($id,$evidencia,$fecha,$hora,$id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" INSERT INTO `on_soporte_salud` (`id_estudiante`, `nombre_archivo`, `fecha_subida`, `hora_subida`, `usuario_subida`) VALUES (:id_estudiante,:evidencia,:fecha,:hora,:id_usuario) ");
		$sentencia->bindParam(":id_estudiante",$id);
		$sentencia->bindParam(":evidencia",$evidencia);
		$sentencia->bindParam(":fecha",$fecha);
		$sentencia->bindParam(":hora",$hora);
		$sentencia->bindParam(":id_usuario",$id_usuario);
		if ($sentencia->execute()) {
			$data['status'] = 'ok';
			$data['msj'] = 'Soporte registrado con exito';
		} else {
			$data['status'] = 'error';
			$data['msj'] = 'Error al registar el soporte';
		}

		echo json_encode($data);
		
	}
	public function agregar_soporte_digitales5($id,$evidencia,$fecha,$hora,$id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" INSERT INTO `on_soporte_prueba` (`id_estudiante`, `nombre_archivo`, `fecha_subida`, `hora_subida`, `usuario_subida`) VALUES (:id_estudiante,:evidencia,:fecha,:hora,:id_usuario) ");
		$sentencia->bindParam(":id_estudiante",$id);
		$sentencia->bindParam(":evidencia",$evidencia);
		$sentencia->bindParam(":fecha",$fecha);
		$sentencia->bindParam(":hora",$hora);
		$sentencia->bindParam(":id_usuario",$id_usuario);
		if ($sentencia->execute()) {
			$data['status'] = 'ok';
			$data['msj'] = 'Soporte registrado con exito';
		} else {
			$data['status'] = 'error';
			$data['msj'] = 'Error al registar el soporte';
		}

		echo json_encode($data);
		
	}




	public function agregar_soporte_compromiso($id,$evidencia,$fecha,$hora,$id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" INSERT INTO `on_soporte_compromiso`(`id_estudiante`, `nombre_archivo`, `fecha_subida`, `hora_subida`, `usuario_subida`) VALUES (:id_estudiante,:evidencia,:fecha,:hora,:id_usuario)");
		$sentencia->bindParam(":id_estudiante",$id);
		$sentencia->bindParam(":evidencia",$evidencia);
		$sentencia->bindParam(":fecha",$fecha);
		$sentencia->bindParam(":hora",$hora);
		$sentencia->bindParam(":id_usuario",$id_usuario);
		if ($sentencia->execute()) {
			$data['status'] = 'ok';
			$data['msj'] = 'Soporte registrado con exito';
		} else {
			$data['status'] = 'error';
			$data['msj'] = 'Error al registar el soporte';
		}

		echo json_encode($data);
		
	}

	public function agregar_soporte_proteccion_datos($id,$evidencia,$fecha,$hora,$id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" INSERT INTO `on_soporte_proteccion_datos`(`id_estudiante`, `nombre_archivo`, `fecha_subida`, `hora_subida`, `usuario_subida`) VALUES (:id_estudiante,:evidencia,:fecha,:hora,:id_usuario)");
		$sentencia->bindParam(":id_estudiante",$id);
		$sentencia->bindParam(":evidencia",$evidencia);
		$sentencia->bindParam(":fecha",$fecha);
		$sentencia->bindParam(":hora",$hora);
		$sentencia->bindParam(":id_usuario",$id_usuario);
		if ($sentencia->execute()) {
			$data['status'] = 'ok';
			$data['msj'] = 'Soporte registrado con exito';
		} else {
			$data['status'] = 'error';
			$data['msj'] = 'Error al registar el soporte';
		}

		echo json_encode($data);
		
	}

	public function agregar_soporte_ingles($id,$evidencia,$fecha,$hora,$id_usuario)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" INSERT INTO `on_soporte_ingles`(`id_estudiante`, `nombre_archivo`, `fecha_subida`, `hora_subida`, `usuario_subida`) VALUES (:id_estudiante,:evidencia,:fecha,:hora,:id_usuario)");
		$sentencia->bindParam(":id_estudiante",$id);
		$sentencia->bindParam(":evidencia",$evidencia);
		$sentencia->bindParam(":fecha",$fecha);
		$sentencia->bindParam(":hora",$hora);
		$sentencia->bindParam(":id_usuario",$id_usuario);
		if ($sentencia->execute()) {
			$data['status'] = 'ok';
			$data['msj'] = 'Soporte registrado con exito';
		} else {
			$data['status'] = 'error';
			$data['msj'] = 'Error al registar el soporte';
		}

		echo json_encode($data);
		
	}

	public function eliminar_soporte_inscripcion($id,$id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_inscripcion` WHERE `id_inscripcion` = :id ");
		$sentencia->bindParam(":id",$id);
		return $sentencia->execute();
	}

	public function eliminar_soporte_cc($id,$id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_cedula` WHERE `id_cedula` = :id ");
		$sentencia->bindParam(":id",$id);
		return $sentencia->execute();
	}

	public function eliminar_soporte_diploma($id,$id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_diploma` WHERE `id_diploma` = :id ");
		$sentencia->bindParam(":id",$id);
		return $sentencia->execute();
	}

	public function eliminar_soporte_acta($id,$id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_acta` WHERE `id_acta` = :id ");
		$sentencia->bindParam(":id",$id);
		return $sentencia->execute();
	}

	public function eliminar_soporte_salud($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_salud` WHERE `id_salud` = :id ");
		$sentencia->bindParam(":id",$id);
		return $sentencia->execute();
	}

	public function eliminar_soporte_prueba($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" DELETE FROM `on_soporte_prueba` WHERE `id_prueba` = :id ");
		$sentencia->bindParam(":id",$id);
		return $sentencia->execute();
	}

	public function eliminar_soporte_compromiso($id_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare("DELETE FROM `on_soporte_compromiso` WHERE `id_compromiso` = :id_estudiante");
		$sentencia->bindParam(":id_estudiante",$id_estudiante);
		return $sentencia->execute();
	}

	public function eliminar_soporte_proteccion_datos($id_proteccion_datos)
	{
		global $mbd;
		$sentencia = $mbd->prepare("DELETE FROM `on_soporte_proteccion_datos` WHERE `id_proteccion_datos` = :id_proteccion_datos");
		$sentencia->bindParam(":id_proteccion_datos",$id_proteccion_datos);
		return $sentencia->execute();
	}

	
	public function eliminar_soporte_ingles($id_ingles)
	{
		global $mbd;
		$sentencia = $mbd->prepare("DELETE FROM `on_soporte_ingles` WHERE `id_ingles` = :id_ingles");
		$sentencia->bindParam(":id_ingles",$id_ingles);
		return $sentencia->execute();
	}


		//Implementar un método para listar los estados
	public function selectEstado()
	{	
		$sql="SELECT * FROM on_estado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementamos un método para actualziar el estado
	public function moverUsuario($id_estudiante_mover,$estado)
	{
		$sql="UPDATE on_interesados SET estado= :estado WHERE id_estudiante= :id_estudiante_mover";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":id_estudiante_mover", $id_estudiante_mover);
		return $consulta->execute();

	}
		//Implementar un método para listar las modalidades de camapañas
	public function selectModalidadCampana()
	{	
		$sql="SELECT * FROM on_modalidad_campana";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		
	//Implementar un método para ver si el nuevo documento existe 
	public function nuevoDocumento($nuevodocumento)
	{	
		$sql="SELECT * FROM on_interesados WHERE identificacion= :nuevodocumento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevodocumento", $nuevodocumento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
	//Implementamos un método para editar registros
	public function actualizarDocumento($id_estudiante_documento,$nuevodocumento,$modalidad_campana)
	{
		$clave=md5($id_estudiante_documento);
		
		$sql="UPDATE on_interesados SET identificacion= :nuevodocumento, clave= :clave, nombre_modalidad= :modalidad_campana, estado='Preinscrito', segui='0' WHERE id_estudiante= :id_estudiante_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevodocumento", $nuevodocumento);
		$consulta->bindParam(":modalidad_campana", $modalidad_campana);
		$consulta->bindParam(":id_estudiante_documento", $id_estudiante_documento);
		$consulta->bindParam(":clave", $clave);
		return $consulta->execute();

	}
				//Implementamos un método para editar registros
	public function actualizarDocumentoIdentificacion($id_estudiante_documento,$nuevodocumento,$modalidad_campana)
	{
		$clave=md5($id_estudiante_documento);
		
		$sql="UPDATE on_interesados SET identificacion= :nuevodocumento, clave= :clave, nombre_modalidad= :modalidad_campana, estado='Preinscrito', segui='0' WHERE id_estudiante= :id_estudiante_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevodocumento", $nuevodocumento);
		$consulta->bindParam(":modalidad_campana", $modalidad_campana);
		$consulta->bindParam(":id_estudiante_documento", $id_estudiante_documento);
		$consulta->bindParam(":clave", $clave);
		return $consulta->execute();

	}	
	public function datos_personales_interesados($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados` WHERE `id_estudiante` = $id ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

	
	public function registrarestado($id_usuario,$id_estudiante,$estado,$fecha,$hora,$periodo_campana)
	{
		$sql="INSERT INTO on_cambioestado (id_usuario,id_estudiante,estado,fecha_seguimiento,hora_seguimiento,periodo)
		VALUES ('$id_usuario','$id_estudiante','$estado','$fecha','$hora','$periodo_campana')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	

}


?>