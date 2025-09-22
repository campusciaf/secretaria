<?php 

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";


class OnPanel
{
    public function consulta($val){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `on_interesados` WHERE $val");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consulta_id($id){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_interesados` WHERE `id_estudiante` = $id ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
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

	//Implementamos un método para insertar seguimiento
	public function insertarSeguimiento($id_usuario, $id_estudiante, $motivo_seguimiento, $mensaje_seguimiento, $fecha,$hora)
	{
		$sql="INSERT INTO on_seguimiento (id_usuario, id_estudiante, motivo_seguimiento, mensaje_seguimiento, fecha_seguimiento, hora_seguimiento)
		VALUES ('$id_usuario','$id_estudiante','Seguimiento','$mensaje_seguimiento','$fecha','$hora')";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	public function VerHistorial($id_estudiante){	
		$sql="SELECT * FROM on_interesados oni INNER JOIN on_interesados_datos onid ON oni.id_estudiante = onid.id_estudiante WHERE oni.id_estudiante = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }	

	public function soporte_inscripcion($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_soporte_inscripcion` WHERE `id_estudiante` = $id ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

	public function select_onprogramas()
	{	

		$sql="SELECT * FROM on_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function select_on_estado()
	{	

		$sql="SELECT * FROM on_estado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function select_on_jornada()
	{	
		$sql="SELECT * FROM on_jornadas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function select_on_periodo()
	{	
		$sql="SELECT * FROM on_periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditonombre($id_estudiante, $nombre)
	{
		$sql="UPDATE `on_interesados` SET  `nombre` = '$nombre' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditonombre_2($id_estudiante, $nombre_2)
	{
		$sql="UPDATE `on_interesados` SET  `nombre_2` = '$nombre_2' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}
	//Implementamos un método para editar registros del estudiante
	public function guardoeditoapellidos($id_estudiante, $apellidos)
	{
		$sql="UPDATE `on_interesados` SET  `apellidos` = '$apellidos' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}
	//Implementamos un método para editar registros del estudiante
	public function guardoeditoapellidos_2($id_estudiante, $apellidos_2)
	{
		$sql="UPDATE `on_interesados` SET  `apellidos_2` = '$apellidos_2' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}
	
	//Implementamos un método para editar registros del estudiante
	public function guardoeditoidentificacion($id_estudiante, $identificacion)
	{
		$sql="UPDATE `on_interesados` SET  `identificacion` = '$identificacion' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditoestado($id_estudiante, $estado)
	{
		$sql="UPDATE `on_interesados` SET  `estado` = '$estado' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}
	//Implementamos un método para editar registros del estudiante
	public function guardoeditofoprorgama($id_estudiante, $fo_programa)
	{
		$sql="UPDATE `on_interesados` SET  `fo_programa` = '$fo_programa' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditojornadae($id_estudiante, $jornada_e)
	{
		$sql="UPDATE `on_interesados` SET  `jornada_e` = '$jornada_e' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditofechanacimiento($id_estudiante, $fecha_nacimiento)
	{
		$sql="UPDATE `on_interesados` SET  `fecha_nacimiento` = '$fecha_nacimiento' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditocelular($id_estudiante, $celular)
	{
		$sql="UPDATE `on_interesados` SET  `celular` = '$celular' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditoemailpersonal($id_estudiante, $email)
	{
		$sql="UPDATE `on_interesados` SET  `email` = '$email' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}


	//Implementamos un método para editar registros del estudiante
	public function guardoeditoemailciaf($id_estudiante, $email_ciaf)
	{
		$sql="UPDATE `on_interesados` SET  `email_ciaf` = '$email_ciaf' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}


	//Implementamos un método para editar registros del estudiante
	public function guardoeditoperiodocampana($id_estudiante, $periodo_campana)
	{
		$sql="UPDATE `on_interesados` SET  `periodo_campana` = '$periodo_campana' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditoformulario($id_estudiante, $formulario)
	{
		$sql="UPDATE `on_interesados` SET `formulario` = '$formulario' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}
	//Implementamos un método para editar registros del estudiante
	public function guardoeditoinscripcion($id_estudiante, $inscripcion)
	{
		$sql="UPDATE `on_interesados` SET  `inscripcion` = '$inscripcion' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditoentrevista($id_estudiante, $entrevista)
	{
		$sql="UPDATE `on_interesados` SET  `entrevista` = '$entrevista' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}

	//Implementamos un método para editar registros del estudiante
	public function guardoeditodocumentos($id_estudiante, $documentos)
	{
		$sql="UPDATE `on_interesados` SET  `documentos` = '$documentos' WHERE `id_estudiante` = '$id_estudiante'";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}


	//Implementamos un método para insertar el estado que se guarda en on_cambioestado
	
	public function insertarestado( $id_usuario, $id_estudiante, $estado, $fecha,$hora, $periodo)
	{	

		$sql="INSERT INTO `on_cambioestado` (id_usuario, id_estudiante, estado, fecha, hora, periodo)
		VALUES ('$id_usuario','$id_estudiante','$estado','$fecha','$hora','$periodo')";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);	
		return $consulta->execute();
	}

}


?>