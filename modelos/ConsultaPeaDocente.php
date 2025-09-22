<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class ConsultaPeaDocente
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function periodoactual()
	{
		$sql = "SELECT * FROM periodo_actual";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método verificar el documento existe o no 
	public function verificardocumento($usuario_identificacion)
	{
		$sql = "SELECT * FROM docente WHERE usuario_identificacion= :usuario_identificacion";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function listar($usuario_identificacion)
	{
		$sql = "SELECT * FROM `docente` WHERE `usuario_identificacion` = :usuario_identificacion";

		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function docente_grupo_consulta($id_docente,$periodo)
	{

		$sql = "SELECT * FROM `docente_grupos` WHERE `id_docente` = :id_docente and `periodo` = :periodo";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function pea_docentes_consulta($id_docente_grupo)
	{

		$sql = "SELECT * FROM `pea_docentes` WHERE `id_docente_grupo` = :id_docente_grupo";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function pea_documento_carpeta_consulta($id_pea_docentes)
	{

		$sql = "SELECT * FROM `pea_documento_carpeta` WHERE `id_pea_docentes` = :id_pea_docentes";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function pea_enlaces_consulta($id_pea_docentes)
	{

		$sql = "SELECT * FROM `pea_enlaces` WHERE `id_pea_docentes` = :id_pea_docentes";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function fechaesp($date)
	{
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}

	public function pea_documentos_consulta($id_pea_documento_carpeta_array)
	{
		// Crear un array de placeholders
		$placeholders = implode(',', array_fill(0, count($id_pea_documento_carpeta_array), '?'));

		$sql = "SELECT * FROM `pea_documentos` WHERE `id_pea_documento_carpeta` IN ($placeholders)";

		global $mbd;
		$consulta = $mbd->prepare($sql);

		// Bind each value from the array
		foreach ($id_pea_documento_carpeta_array as $k => $id) {
			$consulta->bindValue(($k + 1), $id);
		}

		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function pea_ejercicios($id_pea_ejercicios_carpeta)
	{
		// Verificar si el array está vacío
		if (empty($id_pea_ejercicios_carpeta)) {
			return array();
		}
		// Crear un array de placeholders
		$placeholders = implode(',', array_fill(0, count($id_pea_ejercicios_carpeta), '?'));

		$sql = "SELECT * FROM `pea_ejercicios` WHERE `id_pea_ejercicios_carpeta` IN ($placeholders)";

		global $mbd;
		$consulta = $mbd->prepare($sql);

		// Bind each value from the array
		foreach ($id_pea_ejercicios_carpeta as $k => $id) {
			$consulta->bindValue(($k + 1), $id);
		}

		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function pea_ejercicios_carpeta($id_pea_docentes)
	{

		$sql = "SELECT * FROM `pea_ejercicios_carpeta` WHERE `id_pea_docentes` = :id_pea_docentes";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	
}
