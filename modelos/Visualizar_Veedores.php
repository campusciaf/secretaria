<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Visualizar_Veedores
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function listar_veedores()
	{
		global $mbd;
		$sql = "SELECT `credencial_estudiante`.credencial_nombre,`credencial_estudiante`.credencial_nombre_2,`credencial_estudiante`.credencial_apellido,`credencial_estudiante`.credencial_apellido_2,`credencial_estudiante`.credencial_identificacion,`credencial_estudiante`.credencial_login,`programa_ac`.nombre,`veedores`.estado FROM `credencial_estudiante` INNER JOIN `veedores` ON `credencial_estudiante`.`id_credencial`=`veedores`.`id_credencial` INNER JOIN `programa_ac` ON `programa_ac`.`id_programa`=`veedores`.`id_programa_ac`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	

	
	
	
}
