<?php 
require "../config/Conexion.php";
class AgregarSeguiTareas
{

	
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

    //Implementamos un método para insertar seguimiento

    public function insertarSeguimiento($seg_descripcion, $seg_tipo, $id_usuario, $fechahora, $id_persona, $id_credencial){
        // Asigna NULL si $id_persona está vacío
        $id_persona = empty($id_persona) ? null : $id_persona;

        $sql = "INSERT INTO sofi_seguimientos (seg_descripcion, seg_tipo, id_asesor, created_at, id_persona, id_credencial)
                VALUES (:seg_descripcion, :seg_tipo, :id_usuario, :fechahora, :id_persona, :id_credencial)";

        global $mbd;
        $consulta = $mbd->prepare($sql);

        // Asigna los parámetros
        $consulta->bindParam(":seg_descripcion", $seg_descripcion);
        $consulta->bindParam(":seg_tipo", $seg_tipo);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fechahora", $fechahora);
        $consulta->bindValue(":id_persona", $id_persona, $id_persona === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $consulta->bindParam(":id_credencial", $id_credencial);

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

	//Implementamos un método para insertar una tarea
	public function insertarTarea($id_persona, $id_credencial, $id_usuario, $tarea_motivo, $tarea_observacion, $fechahora, $tarea_fecha, $tarea_hora)
	{
        $id_persona = empty($id_persona) ? null : $id_persona;

		$sql = "INSERT INTO sofi_tareas (id_persona, id_credencial, id_asesor, tarea_motivo, tarea_observacion, tarea_creacion, tarea_fecha, tarea_hora)
                VALUES (:id_persona, :id_credencial, :id_usuario, :tarea_motivo, :tarea_observacion, :fechahora, :tarea_fecha, :tarea_hora)";
        global $mbd;
        $consulta = $mbd->prepare($sql);

         // Asociamos los parámetros con valores
         $consulta->bindValue(":id_persona", $id_persona, $id_persona === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
         $consulta->bindParam(":id_credencial", $id_credencial);
         $consulta->bindParam(":id_usuario", $id_usuario);
         $consulta->bindParam(":tarea_motivo", $tarea_motivo);
         $consulta->bindParam(":tarea_observacion", $tarea_observacion);
         $consulta->bindParam(":fechahora", $fechahora);
         $consulta->bindParam(":tarea_fecha", $tarea_fecha);
         $consulta->bindParam(":tarea_hora", $tarea_hora);

         return $consulta->execute();

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
    public function sofiSeguimientos($id_credencial)
    {	
        $sql="SELECT * FROM sofi_seguimientos WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    
    //Implementar un método para listar el historial de seguimiento
    public function sofiTareasProgramadas($id_credencial)
    {	
        $sql="SELECT * FROM sofi_tareas WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //datos del asesor
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


}
?>