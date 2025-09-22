<?php
session_start();
require "../config/Conexion.php";
class SegmentacionEstudiantes
{


	public function __construct() {}

	public function TraerDatosGrafica($periodo)
	{
		$sql = "SELECT fecha_nacimiento FROM segmentacion_estudiantes WHERE periodo = :periodo";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function TraerDatosGraficaPorPrograma($periodo, $programa)
	{
		global $mbd;
		$sql = "SELECT fecha_nacimiento FROM segmentacion_estudiantes WHERE periodo = :periodo AND fo_programa = :fo_programa AND ciclo IN (1, 2, 3)";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":fo_programa", $programa);
		$consulta->execute();
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultados;
	}
	
	public function TraerDatosGraficaSinPrograma($periodo)
	{
		$sql = "SELECT fecha_nacimiento FROM segmentacion_estudiantes WHERE periodo = :periodo AND ciclo IN (1, 2, 3)";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultados;
	}



	
	public function TraerEdadPromedioPorPrograma($periodo, $programa)
	{
		$sql = "SELECT fo_programa AS programa, AVG(TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())) AS edad_promedio
				FROM segmentacion_estudiantes
				WHERE periodo = :periodo AND fo_programa = :programa
				GROUP BY fo_programa";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
	
		// Vinculación de parámetros
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":programa", $programa);
	
		$consulta->execute();
		return $consulta->fetchAll();
	}



	public function TraerEdadPromedioSinPorPrograma($periodo)
	{
		$sql = "SELECT AVG(TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())) AS edad_promedio
				FROM segmentacion_estudiantes
				WHERE periodo = :periodo ";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
	
		// Vinculación de parámetros
		$consulta->bindParam(":periodo", $periodo);
	
		$consulta->execute();
		return $consulta->fetchAll();
	}
	





	//Implementar un método para listar los programas en un select
	public function selectPeriodo()
	{
		$sql = "SELECT * FROM periodo ORDER BY id_periodo DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);  // Asegúrate de que el fetch mode es adecuado
	}

	public function selectPrograma()
	{
		$sql = "SELECT * FROM programa_ac WHERE estado = '1' AND ciclo IN (1, 2, 3)";
	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function periodoanterior($id_periodo)
	{
		$sql = "SELECT * FROM periodo WHERE id_periodo= :id_periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_periodo", $id_periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function selectPeriodoid($periodo)
	{
		$sql = "SELECT * FROM periodo WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function CompararPeriodos($programas = null)
	{
		// Consulta base para calcular el promedio de edad por periodo
		$sql = "SELECT periodo, AVG(TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())) AS edad_promedio FROM segmentacion_estudiantes";

		// Si se proporcionan programas, agregar condición para filtrar por ellos
		if (!empty($programas)) {
			// Asegurarse de que la lista de programas esté formateada correctamente para SQL, por ejemplo '("programa1", "programa2")'
			$sql .= " WHERE fo_programa IN ($programas)";
		}

		// Agregar agrupamiento y ordenamiento al final de la consulta
		$sql .= " GROUP BY periodo ORDER BY periodo";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		// No necesitas bindParam aquí porque no estás usando parámetros en tu consulta
		$consulta->execute();
		return $consulta->fetchAll();
	}
}
