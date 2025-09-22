<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Nuevo_Docente
{
	//Implementamos nuestro constructor
	public function __construct() {}

	public function verificardocumento($tabla, $valor)
	{
		global $mbd;
		$sql = "  SELECT * FROM `cv_informacion_personal` INNER JOIN `cv_usuario` ON `cv_usuario`.`id_usuario_cv` = `cv_informacion_personal`.`id_usuario_cv` WHERE $tabla = :valor";
		$sentencia = $mbd->prepare($sql);
		$sentencia->bindParam(':valor', $valor);
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
	}
	public function verificardocumento_docente($usuario_identificacion)
	{
		$sql = "SELECT * FROM `docente` WHERE `usuario_identificacion` = :usuario_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function MostrarDatosDocente($usuario_identificacion)
	{
		$sql = "SELECT * FROM `cv_informacion_personal` INNER JOIN `cv_usuario` ON `cv_usuario`.`id_usuario_cv` = `cv_informacion_personal`.`id_usuario_cv` WHERE `cv_usuario`.`usuario_identificacion` = :usuario_identificacion ORDER BY `cv_usuario`.`id_usuario_cv` DESC LIMIT 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para insertar registros
	public function insertar($usuario_tipo_documento, $usuario_identificacion, $usuario_nombre, $usuario_nombre_2, $usuario_apellido, $usuario_apellido_2, $usuario_genero, $usuario_estado_civil, $usuario_fecha_nacimiento, $usuario_departamento_nacimiento, $usuario_municipio_nacimiento, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email_p, $usuario_tipo_sangre, $usuario_email_ciaf, $usuario_periodo_ingreso, $usuario_clave, $usuario_imagen)
	{
		$sql = "INSERT INTO docente (usuario_tipo_documento,usuario_identificacion,usuario_fecha_expedicion,usuario_nombre,usuario_nombre_2,usuario_apellido,usuario_apellido_2,usuario_genero,usuario_estado_civil,usuario_fecha_nacimiento,usuario_departamento_nacimiento,usuario_municipio_nacimiento,usuario_direccion,usuario_telefono,usuario_celular,usuario_email_p,usuario_tipo_sangre,usuario_email_ciaf,usuario_periodo_ingreso,usuario_clave,usuario_login,usuario_imagen,usuario_condicion)
		VALUES ('$usuario_tipo_documento','$usuario_identificacion',NULL,'$usuario_nombre','$usuario_nombre_2','$usuario_apellido','$usuario_apellido_2','$usuario_genero','$usuario_estado_civil','$usuario_fecha_nacimiento','$usuario_departamento_nacimiento','$usuario_municipio_nacimiento','$usuario_direccion','$usuario_telefono','$usuario_celular','$usuario_email_p','$usuario_tipo_sangre','$usuario_email_ciaf',$usuario_periodo_ingreso,'$usuario_clave','$usuario_email_ciaf','$usuario_imagen','1')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar registros de los docentes
	public function editar($id_usuario, $usuario_tipo_documento, $usuario_identificacion, $usuario_nombre, $usuario_nombre_2, $usuario_apellido, $usuario_apellido_2, $usuario_estado_civil, $usuario_fecha_nacimiento, $usuario_departamento_nacimiento, $usuario_municipio_nacimiento, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email_p, $usuario_tipo_contrato, $usuario_tipo_sangre, $usuario_email_ciaf, $usuario_imagen)
	{
		$sql = "UPDATE docente SET usuario_tipo_documento='$usuario_tipo_documento',usuario_identificacion='$usuario_identificacion',usuario_nombre='$usuario_nombre',usuario_nombre_2='$usuario_nombre_2',usuario_apellido='$usuario_apellido',usuario_apellido_2='$usuario_apellido_2',usuario_estado_civil='$usuario_estado_civil',usuario_fecha_nacimiento='$usuario_fecha_nacimiento',usuario_departamento_nacimiento='$usuario_departamento_nacimiento',usuario_municipio_nacimiento='$usuario_municipio_nacimiento',usuario_direccion='$usuario_direccion',usuario_telefono='$usuario_telefono',usuario_celular='$usuario_celular',usuario_email_p='$usuario_email_p',usuario_tipo_contrato='$usuario_tipo_contrato',usuario_tipo_sangre='$usuario_tipo_sangre',usuario_email_ciaf='$usuario_email_ciaf',usuario_imagen='$usuario_imagen' WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		return $consulta->execute();
	}
	//Implementar un método para listar los tipos documentos
	public function selectTipoDocumento()
	{
		$sql = "SELECT * FROM tipo_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los tipos de sangre
	public function selectTipoSangre()
	{
		$sql = "SELECT * FROM tipo_sangre";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los tipos de contrato
	public function selectTipoContrato()
	{
		$sql = "SELECT * FROM tipo_contrato";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los tipos de contrato
	public function selectEstadoCivil()
	{
		$sql = "SELECT * FROM estado_civil";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los departamentos en un select
	public function selectDepartamento()
	{
		$sql = "SELECT * FROM departamentos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los municipios en un select
	public function selectMunicipio()
	{
		$sql = "SELECT * FROM municipios";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los si o no
	public function selectlistaSiNo()
	{
		$sql = "SELECT * FROM lista_si_no";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function insertar_tipo_contrato($documento_docente, $tipo_contrato, $id_usuario, $periodo, $fecha_actual, $hora_actual)
	{
		$sql = "INSERT INTO `docente_tipo_contrato` (`id_docente_tipo_contrato`,`documento_docente`, `tipo_contrato`, `id_usuario`, `periodo`, `fecha_creacion`, `hora`) 
            VALUES (NULL,:documento_docente, :tipo_contrato, :id_usuario, :periodo, :fecha_actual, :hora_actual);";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente);
		$consulta->bindParam(":tipo_contrato", $tipo_contrato);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":fecha_actual", $fecha_actual);
		$consulta->bindParam(":hora_actual", $hora_actual);
		$consulta->execute();
		return $consulta;
	}
	public function selectGenero()
	{
		$sql = "SELECT * FROM genero";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarDocumentosObligatorios($id_usuario_cv, $documento_nombre)
	{
		$sql = "SELECT * FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv AND `documento_nombre` = :documento_nombre";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->bindParam(":documento_nombre", $documento_nombre);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function obtener_id_usuario_cv($usuario_identificacion)
	{
		$sql = "SELECT * FROM `cv_usuario` WHERE `usuario_identificacion` = :usuario_identificacion";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// usamos la funcion MAX(id_documentacion) para obtener el ultimo id ingresado 
	public function listarDocumentosObligatoriosPorUsuario($id_usuario_cv)
	{
		$sql = "SELECT DISTINCT id_usuario_cv,documento_nombre,documento_archivo FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` =  :id_usuario_cv AND `documento_nombre` IN ('Cédula de ciudadanía', 'Certificación Bancaria', 'Antecedentes Judiciales Policía', 'Antecedentes Contraloría', 'Antecedentes Procuraduría', 'Referencias Laborales', 'Certificado Afiliación EPS', 'Certificado Afiliación AFP')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	
}
