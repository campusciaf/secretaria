<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class MatriculaConfigurar
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Implementamos un método para insertar registros
	public function insertar($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave, $credencial_usuario, $credencial_fecha)
	{
		$sql = "INSERT INTO credencial_estudiante (credencial_nombre,credencial_nombre_2,credencial_apellido,credencial_apellido_2,credencial_identificacion,credencial_login,credencial_clave,credencial_usuario,credencial_fecha)
		VALUES ('$credencial_nombre','$credencial_nombre_2','$credencial_apellido','$credencial_apellido_2','$credencial_identificacion','$credencial_login','$credencial_clave','$credencial_usuario','$credencial_fecha')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function insertarnuevoprograma($id_credencial, $id_programa_ac, $fo_programa, $jornada_e, $escuela_ciaf, $periodo_ingreso, $ciclo, $periodo_activo, $grupo, $admisiones)
	{
		$sql = "INSERT INTO estudiantes (id_credencial,id_programa_ac,fo_programa,jornada_e,escuela_ciaf,periodo,ciclo,periodo_activo,grupo,admisiones)
		VALUES ('$id_credencial','$id_programa_ac','$fo_programa','$jornada_e','$escuela_ciaf','$periodo_ingreso','$ciclo','$periodo_activo','$grupo','$admisiones')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para insertar registros
	public function matriculaprograma($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave)
	{
		$sql = "INSERT INTO estudiantes (credencial_nombre,credencial_nombre_2,credencial_apellido,credencial_apellido_2,credencial_identificacion,credencial_login,credencial_clave)
		VALUES ('$credencial_nombre','$credencial_nombre_2','$credencial_apellido','$credencial_apellido_2','$credencial_identificacion','$credencial_login','$credencial_clave')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para insertar registros en la tabla estudiantes datos personales
	public function insertardatosestudiante($id_credencial)
	{
		$fecha_expedicion = NULL;
		$fecha_nacimiento = NULL;
		$sql = "INSERT INTO estudiantes_datos_personales (id_credencial,fecha_expedicion,fecha_nacimiento)
		VALUES ('$id_credencial','$fecha_expedicion','$fecha_nacimiento')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para editar registros
	public function editar($id, $programa, $nombre, $semestre, $area, $creditos, $codigo, $presenciales, $independiente, $escuela)
	{
		$sql = "UPDATE materias_ciafi SET programa='$programa', nombre='$nombre', semestre='$semestre', area='$area', creditos='$creditos', codigo='$codigo', presenciales='$presenciales', independiente='$independiente', escuela='$escuela' WHERE id='$id'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();
	}
	//Implementar un método para listar los registros
	public function verificardocumento($credencial_identificacion)
	{
		$sql = "SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer el id del estudiante cuando se crea una credencial
	public function traeridcredencial($credencial_identificacion)
	{
		$sql = "SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listar($id_credencial)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Cargar los estados académicos
	public function cargarEstadosAcademicos()
	{
		$sql = "SELECT * FROM estado_academico";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	// Registrar los datos del Graduado
	public function registrarGraduado($id_estudiante, $id_credencial, $periodo_grado, $id_programa_ac, $saber_pro, $acta_grado, $folio, $fecha_grado)
	{
		$sql = "INSERT INTO graduados (`id_graduado`, `id_estudiante`, `id_credencial`, `periodo_grado`, `id_programa_ac`, `pruebas_saber_pro`, `acta_grado`, `folio`, `fecha_grado`) 
		VALUES (NULL, '$id_estudiante', '$id_credencial', '$periodo_grado', '$id_programa_ac', '$saber_pro', '$acta_grado', '$folio', '$fecha_grado')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	// Cargar jornadas
	public function cargarJornadas()
	{
		$sql = "SELECT * FROM jornada WHERE estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Actualizar la jornada
	public function cambiarJornada($nueva_jornada, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET jornada_e=:nueva_jornada WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("nueva_jornada" => $nueva_jornada, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}

	// Cargar los periodos
	public function cargarPeriodos()
	{
		$sql = "SELECT * FROM periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Actualizar el periodo de ingreso
	public function cambiarPeriodo($nuevo_periodo, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET periodo= :nuevo_periodo WHERE id_estudiante = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("nuevo_periodo" => $nuevo_periodo, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}

	// Actualizar el periodo activo
	public function cambiarPeriodoActivo($nuevo_periodo, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET periodo_activo= :nuevo_periodo WHERE id_estudiante = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("nuevo_periodo" => $nuevo_periodo, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}

	// Cargar los grupos
	public function cargarGrupos()
	{
		$sql = "SELECT * FROM grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	// Actualizar el grupo
	public function cambiarPago($nuevo_pago, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET pago_renovar=:nuevo_pago WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("nuevo_pago" => $nuevo_pago, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}

	public function cambiarAdmision($admisiones, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET admisiones=:admisiones WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("admisiones" => $admisiones, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}


	public function cambiarHomologado($homologado, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET homologado=:homologado WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("homologado" => $homologado, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}

	public function cambiarRenovar($renovar, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET renovar=:renovar WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("renovar" => $renovar, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}


	public function cambiarPagoRenovar($pago_renovar, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET pago_renovar=:pago_renovar WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("pago_renovar" => $pago_renovar, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}


	public function cambiarTemporada($temporada, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET temporada=:temporada WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("temporada" => $temporada, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}
	public function cambiarConsultaCifras($consulta_cifras, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET consulta_cifras=:consulta_cifras WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("consulta_cifras" => $consulta_cifras, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}
	public function cambiarPerfil($perfil, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET perfil=:perfil WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("perfil" => $perfil, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}


	// Actualizar el grupo
	public function cambiarGrupo($nuevo_grupo, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET grupo=:nuevo_grupo WHERE id_estudiante =:id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute(array("nuevo_grupo" => $nuevo_grupo, "id_estudiante" => $id_estudiante));
		$resultado = $consulta;
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listarMaterias($original)
	{
		$sql = "SELECT * FROM materias_ciafi WHERE programa= :original";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":original", $original);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrardatos($id_credencial)
	{
		$sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar a que programa pertenece
	public function mostrarescuela($programa)
	{
		$sql = "SELECT * FROM programa_ac WHERE nombre= :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_materia)
	{
		$sql = "SELECT * FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar las escuelas
	public function selectJornada()
	{
		$sql = "SELECT * FROM jornada";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las escuelas
	public function selectPrograma()
	{
		$sql = "SELECT * FROM programa_ac";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los grupos en un select
	public function selectGrupo()
	{
		$sql = "SELECT * FROM grupo ORDER BY grupo ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function listar_escuelas($id_escuelas)
	{
		$sql = "SELECT * FROM escuelas WHERE id_escuelas = :id_escuelas";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_escuelas", $id_escuelas);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	// public function insertargraduadocertificado($id_estudiante, $id_credencial, $id_programa_ac, $acta_grado, $folio, $fecha_grado)
	// {
	// 	$sql = "INSERT INTO `graduados` (`id_estudiante`, `id_credencial`, `id_programa_ac`, `acta_grado`, `folio`, `fecha_grado`, `periodo_grado`, `pruebas_saber_pro`) VALUES (:id_estudiante, :id_credencial, :id_programa_ac, :acta_grado, :folio, :fecha_grado, NULL, NULL);";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":id_estudiante", $id_estudiante);
	// 	$consulta->bindParam(":id_credencial", $id_credencial);
	// 	$consulta->bindParam(":id_programa_ac", $id_programa_ac);
	// 	$consulta->bindParam(":acta_grado", $acta_grado);
	// 	$consulta->bindParam(":folio", $folio);
	// 	$consulta->bindParam(":fecha_grado", $fecha_grado);
	// 	$consulta->execute();
	// 	return $consulta;
	// }

	// Actualizar los estados académicos
	// public function cambiarEstado($nuevo_estado, $id_estudiante)
	// {
	// 	$sql = "UPDATE estudiantes SET estado=:nuevo_estado WHERE id_estudiante =:id_estudiante";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->execute(array("nuevo_estado" => $nuevo_estado, "id_estudiante" => $id_estudiante));
	// 	$resultado = $consulta;
	// 	return $resultado;
	// }

	public function cambiarEstado($nuevo_estado, $id_estudiante) {
		$sql = "UPDATE estudiantes SET estado = :nuevo_estado WHERE id_estudiante = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevo_estado", $nuevo_estado);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$resultado = $consulta->execute();
		return $resultado;
	}
	public function insertargraduadocertificado($id_estudiante, $id_credencial, $id_programa_ac, $acta_grado, $folio, $fecha_grado)
	{
		$sql = "INSERT INTO `graduados` (`id_estudiante`, `id_credencial`, `id_programa_ac`, `acta_grado`, `folio`, `fecha_grado`, `periodo_grado`, `pruebas_saber_pro`) VALUES (:id_estudiante, :id_credencial, :id_programa_ac, :acta_grado, :folio, :fecha_grado, NULL, NULL);";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->bindParam(":acta_grado", $acta_grado);
		$consulta->bindParam(":folio", $folio);
		$consulta->bindParam(":fecha_grado", $fecha_grado);
		$realizado = $consulta->execute();
		return $realizado;
	}
	public function telefono_estudiante($identificacion)
	{
		$sql = "SELECT * FROM on_interesados WHERE identificacion= :identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":identificacion", $identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
