<?php 

require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");
session_start();

class IngresoCampusColaborador
{
	//Implementar un método para mostrar el id del programa
	public function listar($id_usuario,$fecha_ingreso)
	{
		
		$sql="SELECT * FROM `ingresos_campus` WHERE id_usuario= :id_usuario AND fecha= :fecha_ingreso ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha_ingreso", $fecha_ingreso);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
    	
	//Implementar un método para listar los tipos de sangre
	public function colaboradores()
	{	
		$sql="SELECT * FROM usuario WHERE usuario_condicion='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    public function fechaesp($date) {
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}

    public function datosusuario($id_usuario)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE id_usuario = :id_usuario ");
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return  $registro;
    }

    public function ultimoRegistro($id_usuario) {
        global $mbd;
        $sentencia = $mbd->prepare("
        SELECT * 
        FROM ingresos_campus
        WHERE id_usuario = :id_usuario 
        ORDER BY fecha DESC, hora DESC 
        LIMIT 1");

        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return  $registro;
    }
}


?>