<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class PuntosAsignarBilletera
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT * FROM `docente` WHERE `usuario_condicion` = 1 ORDER BY `usuario_apellido` ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function billeterasActivas($id_docente)
	{
		$fecha_hoy = date("Y-m-d");
		$sql = "SELECT * FROM `puntos_billetera_docente` WHERE `id_docente` = :id_docente AND punto_fecha_limite >= :fecha_hoy";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":fecha_hoy", $fecha_hoy);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar registros
	public function insertarPuntos($punto_nombre, $puntos_cantidad, $punto_fecha_limite, $id_docente, $periodo_actual, $punto_maximo)
	{
		$sql = "INSERT INTO `puntos_billetera_docente`(`id_docente`, `punto_nombre`, `puntos_cantidad`, `punto_maximo`, `punto_periodo`, `punto_fecha_limite`) VALUES (:id_docente, :punto_nombre, :puntos_cantidad, :punto_maximo, :punto_periodo, :punto_fecha_limite)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":punto_nombre", $punto_nombre);
		$consulta->bindParam(":puntos_cantidad", $puntos_cantidad);
		$consulta->bindParam(":punto_maximo", $punto_maximo);
		$consulta->bindParam(":punto_periodo", $periodo_actual);
		$consulta->bindParam(":punto_fecha_limite", $punto_fecha_limite);
		return $consulta->execute();
	}
	public function MostrarCargoDocentes($documento_docente, $periodo)
	{
		global $mbd;
		$sql = "SELECT * FROM contrato_docente WHERE documento_docente = :documento_docente AND periodo = :periodo ORDER BY fecha_realizo DESC LIMIT 1";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function periodoactual()
	{
		$sql = "SELECT periodo_actual FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function TotalPuntosBilletera($id_docente)
	{
		global $mbd;
		$fecha_hoy = date("Y-m-d");
		$sentencia = $mbd->prepare("SELECT IFNULL(SUM(`puntos_cantidad`), 0) AS `total_puntos` FROM `puntos_billetera_docente` WHERE `id_docente` = :id_docente AND `punto_fecha_limite` >= :fecha_hoy;");
		$sentencia->bindParam(":id_docente", $id_docente);
		$sentencia->bindParam(":fecha_hoy", $fecha_hoy);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro["total_puntos"];
	}
}
