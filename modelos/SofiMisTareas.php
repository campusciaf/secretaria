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
        $id_usuario = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `id_usuario` = $id_usuario ORDER BY `usuario`.`usuario_nombre` ASC ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function asesores_todos()
    {
        global $mbd;
        $id_usuario = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `asesor_cartera` = 0 ORDER BY `usuario`.`usuario_nombre` ASC ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function consulta_datos($id,$tipo)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `sofi_tareas` WHERE `id_asesor` = :id AND tarea_motivo = :tipo");
        $sentencia->bindParam(':id',$id);
        $sentencia->bindParam(':tipo',$tipo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }


    public function consulta_datos_hoy($id,$tipo,$fecha_programada)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `sofi_tareas` WHERE `id_asesor` = :id AND tarea_motivo = :tipo and `tarea_fecha` = :fecha_programada and tarea_estado = 1 ");
        // echo $sentencia;
        $sentencia->bindParam(':id',$id);
        $sentencia->bindParam(':tipo',$tipo);
        $sentencia->bindParam(':fecha_programada',$fecha_programada);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consulta_datos_dia($id,$tipo,$fecha_hoy)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `sofi_tareas` WHERE `id_asesor` = :id AND tarea_motivo = :tipo AND  tarea_fecha= :fecha_hoy");
        $sentencia->bindParam(':id',$id);
        $sentencia->bindParam(':tipo',$tipo);
        $sentencia->bindParam(':fecha_hoy',$fecha_hoy);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }


    public function buscar($id,$tipo,$consulta)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `sofi_tareas` WHERE `id_asesor` = :id AND tarea_motivo $tipo $consulta");
        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarhoy($id,$tipo,$consulta)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `sofi_tareas` WHERE `id_asesor` = :id AND tarea_motivo $tipo $consulta ");
        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function datos_estudiante($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` WHERE id_credencial = :id ");
        
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


    public function validarTarea($id_tarea,$fecha,$hora)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `sofi_tareas` SET `tarea_estado`= 1, fecha_realizo= :fecha, hora_realizo= :hora  WHERE `id_tarea` = :id ");
        $sentencia->bindParam(":id",$id_tarea);
        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->bindParam(":hora", $hora);
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

}


?>