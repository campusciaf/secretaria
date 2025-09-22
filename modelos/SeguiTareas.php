<?php 
require "../config/Conexion.php";
class SeguiTareas
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