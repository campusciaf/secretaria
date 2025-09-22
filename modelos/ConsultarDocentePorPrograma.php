<?php
session_start();
require "../config/Conexion.php";
class ConsultarDocentePorPrograma
{
	public function __construct() {}
	// Esta consulta obtiene una lista de docentes única (sin duplicados),
	// mostrando uno de los programas en los que están asignados (el primero en orden alfabético).
	// Se filtra por:
	// - programas académicos activos (pac.panel_academico = 1),
	// - docentes activos (d.usuario_condicion = 1),
	// - y el periodo actual (dg.periodo = :periodo).
	// Si se indica una escuela específica (escuela != 0), también se filtra por ella.
	// Se agrupan los resultados por número de identificación del docente para evitar duplicados.
	public function programas($escuela) {
		global $mbd;
		
		$sql = "SELECT MIN(pac.nombre) AS nombre_programa, d.usuario_nombre, d.usuario_nombre_2, d.usuario_apellido, d.usuario_apellido_2, d.usuario_email_ciaf, d.usuario_celular, d.usuario_identificacion FROM programa_ac pac INNER JOIN materias_ciafi mc ON mc.id_programa_ac = pac.id_programa INNER JOIN docente_grupos dg ON dg.id_materia = mc.id INNER JOIN docente d ON d.id_usuario = dg.id_docente WHERE d.usuario_condicion = 1";
		if ($escuela != 0) {
			$sql .= " AND pac.escuela = :escuela";
		}
		$sql .= "
			GROUP BY d.usuario_identificacion
			ORDER BY nombre_programa DESC, d.usuario_nombre ASC
		";
		$consulta = $mbd->prepare($sql);
		if ($escuela != 0) {
			$consulta->bindParam(":escuela", $escuela, PDO::PARAM_INT);
		}
		$consulta->execute();
		return $consulta->fetchAll();
	}
	
	public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	public function datosDocente($id_docente){	
		global $mbd;
		$sql="SELECT * FROM docente WHERE id_usuario = :id_docente LIMIT 1 ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function MostrarContratoDocentes($documento_docente, $periodo)
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
	


	//consulta para mostrar por programa en caso de necesitarse.
	// public function programas($escuela, $periodo) {
	// 	global $mbd;
	// 	$sql = "SELECT DISTINCT  pac.nombre AS nombre_programa, d.usuario_nombre, d.usuario_nombre_2, d.usuario_apellido, d.usuario_apellido_2, d.usuario_email_ciaf, d.usuario_celular, d.usuario_identificacion FROM programa_ac pac INNER JOIN materias_ciafi mc ON mc.id_programa_ac = pac.id_programa INNER JOIN docente_grupos dg ON dg.id_materia = mc.id INNER JOIN docente d ON d.id_usuario = dg.id_docente WHERE pac.panel_academico = 1 AND d.usuario_condicion = 1 AND dg.periodo = :periodo";
	// 	if ($escuela != 0) {
	// 		$sql .= " AND pac.escuela = :escuela";
	// 	}
	// 	$sql .= "
	// 		ORDER BY pac.nombre DESC, d.usuario_nombre ASC
	// 	";
	// 	$consulta = $mbd->prepare($sql);
	// 	// Vinculamos los parámetros
	// 	$consulta->bindParam(":periodo", $periodo, PDO::PARAM_STR);
	// 	if ($escuela != 0) {
	// 		$consulta->bindParam(":escuela", $escuela, PDO::PARAM_INT);
	// 	}
	
	// 	$consulta->execute();
	// 	return $consulta->fetchAll();
	// }

}
