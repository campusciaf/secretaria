<?php
require "../config/Conexion.php";

class Usuario
{
	// Implementamos nuestro constructor
	public function __construct() {}

	public function trae_id_credencial($documento){
		global $mbd;
		$sql = "SELECT `credencial_estudiante`.`id_credencial`,`credencial_estudiante`.`credencial_nombre`, `credencial_estudiante`.`credencial_nombre_2`,`credencial_estudiante`.`credencial_apellido`, `credencial_estudiante`.`credencial_apellido_2`, `credencial_estudiante`.`credencial_identificacion`, `serviciosocial_contratacion`.`fecha_registro`, `empresa`.`usuario_nombre` FROM `credencial_estudiante` LEFT JOIN `estudiantes_datos_personales` ON `credencial_estudiante`.`id_credencial` = `estudiantes_datos_personales`.`id_credencial` LEFT JOIN serviciosocial_contratacion ON credencial_estudiante.id_credencial = `serviciosocial_contratacion`.id_credencial LEFT JOIN empresa ON empresa.id_usuario = serviciosocial_contratacion.id_empresa WHERE credencial_estudiante.credencial_identificacion = :documento;";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento", $documento);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function buscar_por_nombre($credencial_nombre){
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `credencial_nombre` LIKE :credencial_nombre OR `credencial_nombre_2` LIKE :credencial_nombre";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_nombre", $credencial_nombre);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function cargarInformacion($id_credencial)
	{
		$sql_cargar_info = "SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial ORDER BY `estudiantes`.`fo_programa` ASC";
		global $mbd;
		$consulta_cargar_info = $mbd->prepare($sql_cargar_info);
		$consulta_cargar_info->execute(array(":id_credencial" => $id_credencial));
		$resultado_cargar = $consulta_cargar_info->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_cargar;
	}


	
	public function registrarServicioSocial($id_credencial, $id_empresa, $fecha_registro)
{
    $sql = "INSERT INTO serviciosocial_contratacion (fecha_registro, id_empresa, id_credencial) 
            VALUES (:fecha_registro, :id_empresa, :id_credencial)";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":fecha_registro", $fecha_registro);
    $consulta->bindParam(":id_empresa", $id_empresa);
    $consulta->bindParam(":id_credencial", $id_credencial);
    return $consulta->execute();
}

	
	

    public function selectlistarEmpresas()
	{
		$sql = "SELECT * FROM empresa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function ListarActividades($id_credencial)
{
    $sql = "SELECT * FROM actividades_servicio_social WHERE id_credencial = :id_credencial";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_credencial", $id_credencial);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
}



 

	public function registraractividad($id_credencial, $ac_realizadas, $fecha_participacion, $firma_servicio, $horas_servicio,$id_empresa,$actividades_competencias)
{
    $sql = "INSERT INTO actividades_servicio_social (id_credencial,ac_realizadas, fecha_participacion, firma_servicio, horas_servicio,id_empresa, actividades_competencias) 
            VALUES (:id_credencial, :ac_realizadas, :fecha_participacion,  :firma_servicio, :horas_servicio,:id_empresa, :actividades_competencias)";
    global $mbd;
    $consulta = $mbd->prepare($sql);
	$consulta->bindParam(":id_credencial", $id_credencial);
    $consulta->bindParam(":ac_realizadas", $ac_realizadas);
    $consulta->bindParam(":fecha_participacion", $fecha_participacion);
	$consulta->bindParam(":firma_servicio", $firma_servicio);
	$consulta->bindParam(":horas_servicio", $horas_servicio);
	$consulta->bindParam(":id_empresa", $id_empresa);
	$consulta->bindParam(":actividades_competencias", $actividades_competencias);

    return $consulta->execute();
}


}
