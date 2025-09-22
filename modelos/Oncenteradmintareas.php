<?php 
require "../config/Conexion.php";
class Consulta
{
    public function periodoactual(){
    	$sql="SELECT * FROM on_periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    public function asesores()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `asesor` = 0 ORDER BY `usuario`.`usuario_nombre` ASC ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function consulta_datos($id,$tipo,$fecha_tarea)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados_tareas_programadas` WHERE `id_usuario` = :id AND motivo_tarea = :tipo AND fecha_registro>= :fecha_tarea");
        $sentencia->bindParam(':id',$id);
        $sentencia->bindParam(':tipo',$tipo);
        $sentencia->bindParam(':fecha_tarea',$fecha_tarea);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consulta_datos_hoy($id,$tipo,$fecha_programada)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados_tareas_programadas` WHERE `id_usuario` = :id AND motivo_tarea = :tipo and `fecha_programada` = :fecha_programada and estado = 1 ");
        // echo $sentencia;
        $sentencia->bindParam(':id',$id);
        $sentencia->bindParam(':tipo',$tipo);
        $sentencia->bindParam(':fecha_programada',$fecha_programada);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id,$tipo,$consulta,$fecha_tarea_tabla)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados_tareas_programadas` WHERE `id_usuario` = :id AND motivo_tarea $tipo $consulta AND fecha_registro>= :fecha_tarea_tabla");
        $sentencia->bindParam(':id',$id);
        $sentencia->bindParam(':fecha_tarea_tabla',$fecha_tarea_tabla);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }


    public function buscarhoy($id,$tipo,$consulta)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados_tareas_programadas` WHERE `id_usuario` = :id AND motivo_tarea $tipo $consulta ");
        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }


    public function datos_estudiante($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados` WHERE id_estudiante = :id ");
        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function cambiarasesor($id_tarea,$id_asesor,$usuario_anterior)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `on_interesados_tareas_programadas` SET id_usuario = :id_asesor WHERE id_tarea = :id_tarea ");
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

    public function cambiarfecha($id_tarea,$fecha,$fecha_anterior)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `on_interesados_tareas_programadas` SET fecha_programada = :fecha WHERE id_tarea = :id_tarea ");
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
        public function insertarTarea($id_usuario,$id_estudiante_tarea,$motivo_tarea,$mensaje_tarea,$fecha_registro,$hora_registro,$fecha_programada,$hora_programada,$fecha_realizo,$hora_realizo,$periodo_actual)
        {
            $sql="INSERT INTO on_interesados_tareas_programadas (id_usuario,id_estudiante,motivo_tarea,mensaje_tarea,fecha_registro,hora_registro,fecha_programada,hora_programada,fecha_realizo,hora_realizo,periodo)
            VALUES ('$id_usuario','$id_estudiante_tarea','$motivo_tarea','$mensaje_tarea','$fecha_registro','$hora_registro','$fecha_programada','$hora_programada','$fecha_realizo','$hora_realizo','$periodo_actual')";
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


    public function validarTarea($id_tarea,$hora,$fecha)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `on_interesados_tareas_programadas` SET `estado`= 0, fecha_realizo = :fecha, hora_realizo = :hora WHERE `id_tarea` = :id ");
        $sentencia->bindParam(":id",$id_tarea);
        $sentencia->bindParam(":fecha",$fecha);
        $sentencia->bindParam(":hora",$hora);
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
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados_tareas_programadas` WHERE id_tarea = :id ");
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



}


?>