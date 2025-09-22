<?php 
require "../config/Conexion.php";
class Consulta
{
    public function asesores()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `asesor_cartera` = 0 ORDER BY `usuario`.`usuario_nombre` ASC ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function consulta_datos($id,$tipo)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `sofi_tareas` WHERE `id_asesor` = :id AND tarea_motivo = :tipo ");
        $sentencia->bindParam(':id',$id);
        $sentencia->bindParam(':tipo',$tipo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id,$tipo,$consulta)
    {

        $sql="SELECT * FROM `sofi_tareas` WHERE `id_asesor` = :id AND tarea_motivo $tipo $consulta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id',$id);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;

    }
    public function datos_estudiante($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `sofi_persona` WHERE id_persona = :id ");
        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function cambiarasesor($id_tarea,$id_asesor,$usuario_anterior)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `sofi_tareas` SET id_asesor = :id_asesor WHERE id_tarea = :id_tarea ");
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
        $sentencia = $mbd->prepare(" UPDATE `sofi_tareas` SET tarea_fecha = :fecha WHERE id_tarea = :id_tarea ");
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
        public function VerHistorial($id_persona)
        {	
            $sql="SELECT * FROM sofi_persona sp INNER JOIN credencial_estudiante ce ON sp.numero_documento=ce.credencial_identificacion INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial WHERE sp.id_persona= :id_persona";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_persona", $id_persona);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

    // fin agregar tareas, seguimiento y historial


    public function validarTarea($id_tarea,$hora,$fecha)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `sofi_tareas` SET `tarea_estado`= 1, fecha_realizo = :fecha, hora_realizo = :hora WHERE `id_tarea` = :id ");
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
        $sentencia = $mbd->prepare(" SELECT * FROM `sofi_tareas` WHERE id_tarea = :id ");
        $sentencia->bindParam(":id",$id_tarea);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function trazabilidad_fecha($id_tarea,$fecha_anterior,$fecha_nueva)
    {
        global $mbd;
        $id_usuario = $_SESSION['id_usuario'];
        $periodo_actual = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" INSERT INTO `sofi_tareas_trazabilidad`(`id_usuario`, `tipo`, `id_tarea`, `fecha_anterior`, `fecha_nueva`,`periodo`) VALUES (:id_usuario,1,:id_tarea,:fecha_anterior,:fecha_nueva,:periodo_actual) ");
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
        $sentencia = $mbd->prepare(" INSERT INTO `sofi_tareas_trazabilidad`(`id_usuario`, `tipo`, `id_tarea`, `usuario_anterior`, `usuario_nuevo`,`periodo`) VALUES (:id_usuario,2,:id_tarea,:usuario_anterior,:usuario_nuevo,:periodo_actual) ");
        $sentencia->bindParam(":id_usuario",$id_usuario);
        $sentencia->bindParam(":id_tarea",$id_tarea);
        $sentencia->bindParam(":usuario_anterior",$usuario_anterior);
        $sentencia->bindParam(":usuario_nuevo",$usuario_nuevo);
        $sentencia->bindParam(":periodo_actual",$periodo_actual);
        $sentencia->execute();
    }


}


?>