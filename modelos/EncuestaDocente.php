<?php
require "../config/Conexion.php";
class EncuestaDocente{
	//Implementar un método para listar los registros
	public function listar(){
		$sql="SELECT * FROM `autoevaluacion_docente` `autoevaluacion` INNER JOIN `docente` `doc` ON `autoevaluacion`.`id_usuario` = `doc`.`id_usuario`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}		
}
?>