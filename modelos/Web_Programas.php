<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Web_Programas
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	public function mostrarprogramas(){	
		global $mbd;
		$sql="SELECT * FROM `web_programas` ORDER BY `web_programas`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar los programas por id
	public function mostrar_programas($id_programas){

		$sql = "SELECT * FROM `web_programas` WHERE `id_programas` = :id_programas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programas", $id_programas);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function insertarprogramas($id_programas, $img_programas, $img_programas_movil, $nombre_programa, $snies, $frase_programa, $estado, $ip, $hora, $fecha, $id_usuario){

		$sql="INSERT INTO `web_programas`(`id_programas`, `img_programas`, `img_programas_movil`, `nombre_programa`, `snies`, `frase_programa`, `estado`, `ip`, `hora`, `fecha`, `id_usuario`) VALUES (NULL,'$img_programas','$img_programas_movil','$nombre_programa','$snies','$frase_programa','$estado','$ip','$hora','$fecha','$id_usuario')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	public function editarprogramas($img_programas, $img_programas_movil,$nombre_programa,$snies,$frase_programa, $id_programas){
		$sql="UPDATE `web_programas` SET `img_programas` = '$img_programas',`img_programas_movil` = '$img_programas_movil', `nombre_programa` = '$nombre_programa', `snies` = '$snies', `frase_programa` = '$frase_programa'  WHERE `id_programas` = $id_programas";

		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}



	public function desactivar_programa($id_programas)
	{
		$sql="UPDATE web_programas SET estado='0' WHERE id_programas= :id_programas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programas", $id_programas);
		$consulta->execute();
	
	}

	public function activar_programa($id_programas)
	{
		$sql="UPDATE web_programas SET estado='1' WHERE id_programas= :id_programas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programas", $id_programas);
		$consulta->execute();
	
	}

	public function eliminarPrograma($id_programas)
	{
		$sql="DELETE FROM web_programas WHERE id_programas= :id_programas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programas", $id_programas);
		$consulta->execute();
	
	}
	

}

?>