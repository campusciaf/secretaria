<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class PuntosBilleteraDocente
{
	public function __construct() {}
	public function ListarNombrePuntos($id_docente)
	{
		global $mbd;
		$fecha_hoy = date("Y-m-d");
		$sentencia = $mbd->prepare("SELECT * FROM `puntos_billetera_docente` WHERE `id_docente` = :id_docente AND `punto_fecha_limite` >= :fecha_hoy");
		$sentencia->bindParam(":id_docente", $id_docente);
		$sentencia->bindParam(":fecha_hoy", $fecha_hoy);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function ObtenerPuntosMaximos($id_punto, $id_docente)
	{
		global $mbd;
		$fecha_hoy = date("Y-m-d");
		$sentencia = $mbd->prepare("SELECT `punto_nombre`, `punto_maximo` FROM `puntos_billetera_docente` WHERE `id_docente` = :id_docente AND `punto_fecha_limite` >= :fecha_hoy AND `id_punto` = :id_punto");
		$sentencia->bindParam(":id_docente", $id_docente);
		$sentencia->bindParam(":fecha_hoy", $fecha_hoy);
		$sentencia->bindParam(":id_punto", $id_punto);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function BusquedaEstudiante($documento_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT `id_credencial`, `credencial_nombre`, `credencial_nombre_2`, `credencial_apellido`, `credencial_apellido_2`, `credencial_identificacion`, `credencial_login` FROM `credencial_estudiante` WHERE `credencial_identificacion` = :documento_estudiante;");
		$sentencia->bindParam(":documento_estudiante", $documento_estudiante);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function BusquedaInteresado($documento_estudiante)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT `identificacion`, `nombre`, `nombre_2`, `apellidos`, `apellidos_2`, `email` FROM `on_interesados` WHERE `identificacion` = :documento_estudiante;");
		$sentencia->bindParam(":documento_estudiante", $documento_estudiante);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function InsercionPuntos($punto_nombre, $punto_maximo, $id_credencial, $es_estudiante, $id_docente, $punto_periodo, $nombre_estudiante)
	{
		$punto_fecha = date("Y-m-d");
		$punto_hora = date("H:i:s");
		if($es_estudiante == 1){
			$sql = "INSERT INTO `puntos`(`id_credencial`, `punto_nombre`, `puntos_cantidad`, `id_docente`, `punto_fecha`, `punto_hora`, `punto_periodo`) VALUES(:id_credencial, :punto_nombre, :punto_maximo, :id_docente, :punto_fecha, :punto_hora, :punto_periodo)";
		}else{
			$sql = "INSERT INTO `puntos_no_estudiantes`(`id_credencial`, `nombre_estudiante`, `punto_nombre`, `puntos_cantidad`, `id_docente`, `punto_fecha`, `punto_hora`, `punto_periodo`) VALUES(:id_credencial, :nombre_estudiante, :punto_nombre, :punto_maximo, :id_docente, :punto_fecha, :punto_hora, :punto_periodo)";
		}
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		if($es_estudiante == 0){
			$consulta->bindParam(":nombre_estudiante", $nombre_estudiante);
		} 
		$consulta->bindParam(":punto_nombre", $punto_nombre);
		$consulta->bindParam(":punto_maximo", $punto_maximo);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":punto_fecha", $punto_fecha);
		$consulta->bindParam(":punto_hora", $punto_hora);
		$consulta->bindParam(":punto_periodo", $punto_periodo);
		$consulta->execute();
		return $mbd->lastInsertId();
	}
	public function TotalPuntosEstudiante($id_credencial, $es_estudiante)
	{
		$table = ($es_estudiante == 1)?'puntos':'puntos_no_estudiantes';
		$sql = "SELECT SUM(`puntos_cantidad`) AS `TotalPuntos` FROM `$table` WHERE `id_credencial` = :id_credencial AND `punto_nombre` = 'induccion';";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function ActualizarPuntosBilleteraCredencial($id_docente, $id_credencial, $puntos_cantidad, $id_punto)
	{
		$sql = "UPDATE `credencial_estudiante` SET `puntos`= `puntos` + :puntos_cantidad WHERE `id_credencial` = :id_credencial;
		UPDATE `puntos_billetera_docente` SET `puntos_cantidad` = `puntos_cantidad` - :puntos_cantidad WHERE `id_punto` = :id_punto AND `id_docente` = :id_docente;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":puntos_cantidad", $puntos_cantidad);
		$consulta->bindParam(":id_punto", $id_punto);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}