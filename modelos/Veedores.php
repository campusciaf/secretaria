<?php
require "../config/Conexion.php";

class Veedores
{
	// Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function verificarDocumento($valor_seleccionado)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` INNER JOIN `estudiantes_datos_personales` ON `credencial_estudiante`.`id_credencial` = `estudiantes_datos_personales`.`id_credencial` WHERE $valor_seleccionado");
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
	}
	public function buscar_por_nombre($credencial_nombre)
	{
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `credencial_nombre` LIKE :credencial_nombre OR `credencial_nombre_2` LIKE :credencial_nombre";	
		
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_nombre", $credencial_nombre);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	public function trae_id_credencial($id_credencial)
	{
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial";
		// echo $sql;
		
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function cargarInformacion($id_credencial)
	{
		$sql_cargar_info = "SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial AND estado = 1 ORDER BY `estudiantes`.`fo_programa` ASC";
		global $mbd;
		$consulta_cargar_info = $mbd->prepare($sql_cargar_info);
		$consulta_cargar_info->execute(array(":id_credencial" => $id_credencial));
		$resultado_cargar = $consulta_cargar_info->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_cargar;
	}
	public function registrar_envio($id_credencial){
		$sql = "UPDATE  `credencial_estudiante` SET `estado_correo` = '1' WHERE `id_credencial` = :id_credencial ";
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":id_credencial", $id_credencial);
        return $sentencia->execute();
    }


	public function insertarveedores($id_credencial, $id_estudiante, $periodo_activo, $jornada, $id_programa_ac, $semestre, $fecha, $hora, $ip)
	{
		// fecha
		global $mbd;
		$sql = "INSERT INTO `veedores`(`id_credencial`,`id_estudiante`,`periodo_activo`, `jornada`, `id_programa_ac`, `semestre` , `fecha`, `hora`, `ip` ) VALUES('$id_credencial','$id_estudiante', '$periodo_activo', '$jornada', '$id_programa_ac', '$semestre', '$fecha', '$hora', '$ip')";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	public function verificarExistenciaIdCredencial($id_credencial) {
		global $mbd;
		$sql = "SELECT COUNT(*) FROM veedores WHERE id_credencial = :id_credencial";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_credencial', $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchColumn();
		if ($resultado > 0) {
			return true; // Si hay al menos un registro, el id_credencial ya está registrado
		} else {
			return false; // Si no hay ningún registro, el id_credencial no está registrado
		}
	}
	








}
