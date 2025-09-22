<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class MetodologiaPoaGeneral
{
	//Implementamos nuestro constructor
	public function __construct() {}
	public function periodoactual()
	{
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar la ejecucion
	public function listarproyecto()
	{
		global $mbd;
		$sql = "SELECT * FROM sac_proyecto";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar la ejecucion
	public function listarproyectousuario($id_proyecto, $responsable, $anio_eje)
	{
		global $mbd;
		$sql = "SELECT * FROM sac_meta WHERE id_proyecto= :id_proyecto and meta_responsable= :responsable and anio_eje = :anio_eje";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":responsable", $responsable);
		$consulta->bindParam(":anio_eje", $anio_eje);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las matas del usuario dependiendo del proyecto
	public function listarmeta($meta_responsable, $id_proyecto, $anio)
	{
		// $anio = 2023;
		// $anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql = "SELECT * FROM sac_meta WHERE meta_responsable= :meta_responsable and id_proyecto= :id_proyecto and anio_eje= :anio ";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":id_proyecto", $id_proyecto);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para insertar una accion
	public function insertaraccion($nombre_accion, $id_meta, $fecha_accion, $fecha_fin, $hora)
	{
		global $mbd;
		$sql = "INSERT INTO `sac_accion`(`nombre_accion`,`id_meta`,`fecha_accion`, `fecha_fin` , `hora` ) VALUES('$nombre_accion','$id_meta', '$fecha_accion', '$fecha_fin' , '$hora')";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar una accion
	public function editaraccion($id_accion, $nombre_accion, $fecha_accion, $fecha_fin, $hora_accion)
	{
		$sql = "UPDATE `sac_accion` SET `id_accion` = '$id_accion', `nombre_accion` = '$nombre_accion' ,  `fecha_accion` = '$fecha_accion' , `fecha_fin` = '$fecha_fin' , `hora` = '$hora_accion' WHERE `id_accion` = $id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	//Implementar un método para mostrar lasacciones
	public function listaracciones($id_meta)
	{
		$sql = "SELECT * FROM `sac_accion` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_accion($id_accion)
	{
		$sql = "SELECT * FROM `sac_accion` WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function eliminar_accion($id_accion)
	{
		$sql = "DELETE FROM sac_accion WHERE id_accion= :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function terminar_accion($id_accion)
	{
		$sql = "UPDATE `sac_accion` SET `accion_estado` = '1' WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
	}
	public function fechaesp($date)
	{
		$dia     = explode("-", $date, 3);
		$year     = $dia[0];
		$month     = (string)(int)$dia[1];
		$day     = (string)(int)$dia[2];

		$dias         = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
    public function selectUsuario(){
		$sql = "SELECT * FROM `usuario` WHERE `usuario_poa` = 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($id_usuario_cv)
    {
        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv` WHERE `cv_usuario`.`id_usuario_cv`= :id_usuario_cv";
        //return ejecutarConsultaSimpleFila($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
