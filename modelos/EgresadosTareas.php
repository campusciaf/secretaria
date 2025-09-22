<?php 
require "../config/Conexion.php";
class EgresadosTareas
{
    public function asesores()
    {
        global $mbd;
        $id_usuario = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `id_usuario` = $id_usuario ORDER BY `usuario`.`usuario_nombre` ASC ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function asesores_todos()
    {
        global $mbd;
        $id_usuario = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `asesor` = 0 ORDER BY `usuario`.`usuario_nombre` ASC ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consulta_datos($id,$tipo)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiante_tareas_programadas` WHERE `id_usuario` = :id AND motivo_tarea = :tipo ");
        // echo $sentencia;
        $sentencia->bindParam(':id',$id);
        $sentencia->bindParam(':tipo',$tipo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consulta_datos_hoy($id,$tipo,$fecha_programada)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiante_tareas_programadas` WHERE `id_usuario` = :id AND motivo_tarea = :tipo and `fecha_programada` = :fecha_programada and estado = 1");
        // echo $sentencia;
        $sentencia->bindParam(':id',$id);
        $sentencia->bindParam(':tipo',$tipo);
        $sentencia->bindParam(':fecha_programada',$fecha_programada);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id,$tipo,$consulta)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiante_tareas_programadas` WHERE `id_usuario` = :id AND motivo_tarea $tipo $consulta ");
        // echo $sentencia;
        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function datos_estudiante($id_credencial)
    {
        global $mbd;

        // SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE ce.id_credencial = :id_credencial
        $sentencia = $mbd->prepare(" SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE ce.id_credencial = :id_credencial ");
        $sentencia->bindParam(':id_credencial',$id_credencial);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function nombreasesores($id_usuario)
    {
        global $mbd;
        // $id_usuario = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `id_usuario` = :id_usuario ORDER BY `usuario`.`usuario_nombre` ASC ");
        $sentencia->bindParam(':id_usuario',$id_usuario);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarasesor($id_tarea,$id_asesor,$usuario_anterior)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `estudiante_tareas_programadas` SET id_usuario = :id_asesor WHERE id_tarea = :id_tarea ");
        $sentencia->bindParam(":id_asesor",$id_asesor);
        $sentencia->bindParam(":id_tarea",$id_tarea);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
            self::trazabilidad_asesor($id_tarea,$usuario_anterior,$id_asesor);
        } else {
            $data['status'] = 'error';
        }

        echo json_encode($data);
        
    }

    public function fechashoymodal($fecha_programada, $id_usuario)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiante_tareas_programadas` WHERE `fecha_programada` = :fecha_programada and estado = 1 and `id_usuario`= :id_usuario");
        // echo $sentencia;
        $sentencia->bindParam(':id_usuario',$id_usuario);
        // $sentencia->bindParam(':tipo',$tipo);
        $sentencia->bindParam(':fecha_programada',$fecha_programada);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarfecha($id_tarea,$fecha,$fecha_anterior)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `estudiante_tareas_programadas` SET fecha_programada = :fecha WHERE id_tarea = :id_tarea ");
        $sentencia->bindParam(":fecha",$fecha);
        $sentencia->bindParam(":id_tarea",$id_tarea);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
            self::trazabilidad_fecha($id_tarea,$fecha_anterior,$fecha);
        } else {
            $data['status'] = 'error';
        }

        echo json_encode($data);
    }

    // inicio agregar tareas, seguimiento y historial

         //Implementamos un método para insertar seguimiento del estudiante inactivo
    public function insertarSeguimiento($id_usuario,$id_estudiante_agregar,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora,$id_estudiante){
        $sql="INSERT INTO estudiante_seguimiento (id_usuario,id_credencial,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento,id_estudiante)
        VALUES ('$id_usuario','$id_estudiante_agregar','$motivo_seguimiento','$mensaje_seguimiento','$fecha','$hora','$id_estudiante')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }
        
        //Implementamos un método para insertar una tarea
    public function insertarTarea($id_usuario,$id_estudiante_tarea,$motivo_tarea,$mensaje_tarea,$fecha_registro,$hora_registro,$fecha_programada,$hora_programada,$fecha_realizo,$hora_realizo,$periodo_actual,$id_estudiante){
        $sql="INSERT INTO estudiante_tareas_programadas (id_usuario,id_credencial,motivo_tarea,mensaje_tarea,fecha_registro,hora_registro,fecha_programada,hora_programada,fecha_realizo,hora_realizo,periodo,id_estudiante)
        VALUES ('$id_usuario','$id_estudiante_tarea','$motivo_tarea','$mensaje_tarea','$fecha_registro','$hora_registro','$fecha_programada','$hora_programada','$fecha_realizo','$hora_realizo','$periodo_actual','$id_estudiante')";
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
        public function fechaesp($date) {
            $dia 	= explode("-", $date, 3);
            $year 	= $dia[0];
            $month 	= (string)(int)$dia[1];
            $day 	= (string)(int)$dia[2];

            $dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
            $tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

            $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

            return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
        }
        //Implementar un método para listar los interesados
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
        //Implementar un método para listar el historial de seguimiento
        public function verHistorialTabla($id_credencial)
        {	
            $sql="SELECT * FROM estudiante_seguimiento WHERE id_credencial= :id_credencial";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_credencial", $id_credencial);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }
        
        //Implementar un método para listar el historial de seguimiento
        public function verHistorialTablaTareas($id_estudiante)
        {	
            $sql="SELECT * FROM estudiante_tareas_programadas WHERE id_estudiante= :id_estudiante";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_estudiante", $id_estudiante);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }
    // fin agregar tareas, seguimiento y historial

    public function validarTarea($id_tarea)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `estudiante_tareas_programadas` SET `estado`= 0 WHERE `id_tarea` = :id ");
        $sentencia->bindParam(":id",$id_tarea);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
        } else {
            $data['status'] = 'error';
        }
        
        echo json_encode($data);
    }

    public function consultaTarea($id_tarea)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiante_tareas_programadas` WHERE id_tarea = :id ");
        $sentencia->bindParam(":id",$id_tarea);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    
    public function trazabilidad_fecha($id_tarea,$fecha_anterior,$fecha_nueva)
    {
        global $mbd;
        $id_usuario = $_SESSION['id_usuario'];
        $periodo_actual = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" INSERT INTO `on_trazabilidad_tareas`(`id_usuario`, `tipo`, `id_tarea`, `fecha_anterior`, `fecha_nueva`,`periodo`) VALUES (:id_usuario,1,:id_tarea,:fecha_anterior,:fecha_nueva,:periodo_actual) ");
        $sentencia->bindParam(":id_usuario",$id_usuario);
        $sentencia->bindParam(":id_tarea",$id_tarea);
        $sentencia->bindParam(":fecha_anterior",$fecha_anterior);
        $sentencia->bindParam(":fecha_nueva",$fecha_nueva);
        $sentencia->bindParam(":periodo_actual",$periodo_actual);
        $sentencia->execute();
    }

    public function trazabilidad_asesor($id_tarea,$usuario_anterior,$usuario_nuevo)
    {
        global $mbd;
        $id_usuario = $_SESSION['id_usuario'];
        $periodo_actual = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" INSERT INTO `on_trazabilidad_tareas`(`id_usuario`, `tipo`, `id_tarea`, `usuario_anterior`, `usuario_nuevo`,`periodo`) VALUES (:id_usuario,2,:id_tarea,:usuario_anterior,:usuario_nuevo,:periodo_actual) ");
        $sentencia->bindParam(":id_usuario",$id_usuario);
        $sentencia->bindParam(":id_tarea",$id_tarea);
        $sentencia->bindParam(":usuario_anterior",$usuario_anterior);
        $sentencia->bindParam(":usuario_nuevo",$usuario_nuevo);
        $sentencia->bindParam(":periodo_actual",$periodo_actual);
        $sentencia->execute();
    }

    public function vernombreestudiantesinactivos($id_credencial){
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE ce.id_credencial = :id_credencial";
        global $mbd;
        
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado; 
    }


    //Implementar un método para listar los estados de los egresados
	public function selectEstado(){	
		$sql="SELECT * FROM reingreso_estados";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
    // muestra la categoria por id 
	public function mostrar_estados($id_credencial){
		global $mbd;
		$sql = "SELECT * FROM `seguimiento_reingreso` WHERE `id_credencial` = :id_credencial";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
        $registros = $consulta->fetchAll();
		return $registros;
	}

    	//Implementamos un método para editar el estado del egresado
	public function editarreingreso($nombre_estado, $id_credencial, $id_estudiante){
		$sql="UPDATE `seguimiento_reingreso` SET `nombre_estado` = '$nombre_estado', `id_credencial` = '$id_credencial' , `id_estudiante` = '$id_estudiante' WHERE `id_credencial` = $id_credencial";
		
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

    //Implementamos un método para agregar un proyecto
	public function insertarEstadoEgresado($nombre_estado, $id_credencial,$id_estudiante){
		global $mbd;
		$sql="INSERT INTO `seguimiento_reingreso`(`nombre_estado`, `id_credencial`, `id_estudiante`) VALUES('$nombre_estado', '$id_credencial', '$id_estudiante')";
		// echo $sql;  
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

}


?>