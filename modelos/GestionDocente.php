<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class GestionDocente
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Implementamos un método para insertar registros
	public function insertar($usuario_tipo_documento, $usuario_identificacion, $usuario_fecha_expedicion, $usuario_nombre, $usuario_nombre_2, $usuario_apellido, $usuario_apellido_2, $usuario_estado_civil, $usuario_fecha_nacimiento, $usuario_departamento_nacimiento, $usuario_municipio_nacimiento, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email_p, $usuario_tipo_contrato, $usuario_tipo_sangre, $usuario_email_ciaf, $usuario_periodo_ingreso, $usuario_clave, $usuario_imagen)
	{
		$sql = "INSERT INTO docente (usuario_tipo_documento,usuario_identificacion,usuario_fecha_expedicion,usuario_nombre,usuario_nombre_2,usuario_apellido,usuario_apellido_2,usuario_estado_civil,usuario_fecha_nacimiento,usuario_departamento_nacimiento,usuario_municipio_nacimiento,usuario_direccion,usuario_telefono,usuario_celular,usuario_email_p,usuario_tipo_contrato,usuario_tipo_sangre,usuario_email_ciaf,usuario_periodo_ingreso,usuario_clave,usuario_login,usuario_imagen,usuario_condicion)
		VALUES ('$usuario_tipo_documento','$usuario_identificacion','$usuario_fecha_expedicion','$usuario_nombre','$usuario_nombre_2','$usuario_apellido','$usuario_apellido_2','$usuario_estado_civil','$usuario_fecha_nacimiento','$usuario_departamento_nacimiento','$usuario_municipio_nacimiento','$usuario_direccion','$usuario_telefono','$usuario_celular','$usuario_email_p','$usuario_tipo_contrato','$usuario_tipo_sangre','$usuario_email_ciaf',$usuario_periodo_ingreso,'$usuario_clave','$usuario_email_ciaf','$usuario_imagen','1')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar registros
	public function editar($id_usuario, $usuario_tipo_documento, $usuario_identificacion, $usuario_nombre, $usuario_nombre_2, $usuario_apellido, $usuario_apellido_2, $usuario_estado_civil, $usuario_fecha_nacimiento, $usuario_departamento_nacimiento, $usuario_municipio_nacimiento, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email_p, $usuario_tipo_sangre, $usuario_email_ciaf, $usuario_genero, $usuario_imagen)
	{
		$sql = "UPDATE `docente` SET `usuario_tipo_documento` = '$usuario_tipo_documento', `usuario_identificacion` = '$usuario_identificacion', usuario_nombre = '$usuario_nombre',usuario_nombre_2='$usuario_nombre_2',usuario_apellido='$usuario_apellido',usuario_apellido_2='$usuario_apellido_2',usuario_estado_civil='$usuario_estado_civil',usuario_fecha_nacimiento='$usuario_fecha_nacimiento',usuario_departamento_nacimiento='$usuario_departamento_nacimiento',usuario_municipio_nacimiento='$usuario_municipio_nacimiento',usuario_direccion='$usuario_direccion',usuario_telefono='$usuario_telefono',usuario_celular='$usuario_celular',usuario_email_p='$usuario_email_p',usuario_tipo_sangre='$usuario_tipo_sangre',usuario_email_ciaf='$usuario_email_ciaf',usuario_login='$usuario_email_ciaf', usuario_genero='$usuario_genero',usuario_imagen='$usuario_imagen' WHERE id_usuario= :id_usuario";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		return $consulta->execute();
	}
	//Implementamos un método para desactivar categorías
	public function desactivar($id_usuario)
	{
		$sql = "UPDATE docente SET usuario_condicion='0' WHERE id_usuario= :id_usuario";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para activar categorías
	public function activar($id_usuario)
	{
		$sql = "UPDATE docente SET usuario_condicion='1' WHERE id_usuario= :id_usuario";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_usuario)
	{
		$sql = "SELECT * FROM docente WHERE id_usuario= :id_usuario";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		// SELECT * FROM docente ORDER BY `docente`.`usuario_apellido` ASC
		// SELECT * FROM docente INNER JOIN docente_tipo_contrato ON docente.usuario_identificacion = docente_tipo_contrato.documento_docente ORDER BY `usuario_condicion` ASC
		$sql = "SELECT * FROM docente ORDER BY `docente`.`usuario_apellido` ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
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
	//Implementar un método para listar los tipos documentos
	public function selectTipoDocumento()
	{
		$sql = "SELECT * FROM tipo_documento";
		//return ejecutarConsulta($sql);	
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
	//Implementar un método para listar los tipos de contrato
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
	//Implementar un método para listar los departamentos en un select
	public function selectDepartamento()
	{
		$sql = "SELECT * FROM departamentos";
		//return ejecutarConsulta($sql);
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
	//Implementamos un método para editar los aliados
	public function editar_tipo_contrato($documento_docente_editar, $tipo_contrato, $id_usuario_actual, $periodo_actual, $fecha_actual, $hora_actual)
	{
		$sql = "INSERT INTO `docente_tipo_contrato` (`id_docente_tipo_contrato`, `documento_docente` , `tipo_contrato` ,`id_usuario`,`periodo`,`fecha_creacion`,`hora`) VALUES (NULL, :documento_docente_editar, :tipo_contrato, :id_usuario, :periodo, :fecha_actual, :hora_actual );";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente_editar", $documento_docente_editar);
		$consulta->bindParam(":tipo_contrato", $tipo_contrato);
		$consulta->bindParam(":id_usuario", $id_usuario_actual);
		$consulta->bindParam(":periodo", $periodo_actual);
		$consulta->bindParam(":fecha_actual", $fecha_actual);
		$consulta->bindParam(":hora_actual", $hora_actual);
		$consulta->execute();
		return $consulta;
	}
	public function InsertarContratoDocente($documento_docente, $tipo_contrato, $fecha_inicio, $fecha_final, $id_usuario, $periodo, $nombre_docente, $nombre_apellido, $valor_contrato, $usuario_email_p, $auxilio_transporte, $cargo_docente, $cantidad_horas, $valor_horas, $materia_docente)
	{
		$sql = "INSERT INTO `contrato_docente` (`id_docente_contrato`, `documento_docente`, `tipo_contrato`, `fecha_inicio`, `fecha_final`, `id_usuario`, `periodo`, `nombre_docente`, `nombre_apellido`, `valor_contrato`, `usuario_email_p`, `auxilio_transporte`, `cargo_docente`, `cantidad_horas`, `valor_horas`, `materia_docente`) VALUES (NULL, :documento_docente, :tipo_contrato, :fecha_inicio, :fecha_final, :id_usuario, :periodo, :nombre_docente, :nombre_apellido, :valor_contrato, :usuario_email_p, :auxilio_transporte, :cargo_docente, :cantidad_horas, :valor_horas, :materia_docente);";
		echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente);
		$consulta->bindParam(":tipo_contrato", $tipo_contrato);
		$consulta->bindParam(":fecha_inicio", $fecha_inicio);
		$consulta->bindParam(":fecha_final", $fecha_final);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":nombre_docente", $nombre_docente);
		$consulta->bindParam(":nombre_apellido", $nombre_apellido);
		$consulta->bindParam(":valor_contrato", $valor_contrato);
		$consulta->bindParam(":usuario_email_p", $usuario_email_p);
		$consulta->bindParam(":auxilio_transporte", $auxilio_transporte);
		$consulta->bindParam(":cargo_docente", $cargo_docente);
		$consulta->bindParam(":cantidad_horas", $cantidad_horas);
		$consulta->bindParam(":valor_horas", $valor_horas);
		$consulta->bindParam(":materia_docente", $materia_docente);
		$consulta->execute();
		return $consulta;
	}
	public function BuscarDocenteContratado($documento_docente)
	{
		global $mbd;
		$sql = "SELECT * FROM `contrato_docente` WHERE `documento_docente` = :documento_docente ORDER BY `fecha_inicio` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente, PDO::PARAM_STR);
		$consulta->execute();
		return $consulta->fetch(PDO::FETCH_ASSOC);
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
	// filtramos con IN unicamente por id_usuario_cv los documentos que tengamos agregados para proceder a hacer la validacion 
	public function eliminarContrato($id_docente_contrato)
	{
		$sql = "DELETE FROM contrato_docente WHERE id_docente_contrato= :id_docente_contrato";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_contrato", $id_docente_contrato);
		$consulta->execute();
		return $consulta;
		if ($consulta->rowCount() > 0) {
			echo json_encode("eliminado");
		} else {
			echo json_encode("error");
		}
	}
	public function paso1($usuario_identificacion)
	{
		$sql = "SELECT * FROM cv_informacion_personal INNER JOIN cv_usuario ON cv_informacion_personal.id_usuario_cv = cv_usuario.id_usuario_cv WHERE cv_usuario.usuario_identificacion = :usuario_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':usuario_identificacion', $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarpaso1($usuario_identificacion)
	{
		$sql = "SELECT * FROM cv_informacion_personal INNER JOIN cv_usuario ON cv_informacion_personal.id_usuario_cv = cv_usuario.id_usuario_cv WHERE cv_usuario.usuario_identificacion = :usuario_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function paso2($id_usuario_cv)
	{
		global $mbd;
		$sql = "SELECT * FROM cv_educacion_formacion WHERE id_usuario_cv = :id_usuario_cv";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
	public function listarpaso2($id_usuario_cv)
	{
		$sql = "SELECT * FROM cv_educacion_formacion WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function selectPeriodo()
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `periodo` ORDER BY `periodo`.`periodo` DESC");
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function ListarContratosDocente($documento_docente)
	{
		$sql = "SELECT * FROM `contrato_docente` WHERE `documento_docente` LIKE :documento_docente";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function id_usuario_cv($usuario_identificacion)
	{
		$sql = "SELECT id_usuario_cv FROM cv_usuario WHERE usuario_identificacion = :usuario_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function cv_traerIdUsuario($documento)
	{
		$sql = "SELECT `id_usuario_cv` FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
		global $mbd;
		$stmt = $mbd->prepare($sql);
		$stmt->bindParam(':documento', $documento);
		$stmt->execute();
		$registro = $stmt->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function cv_listareducacion($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_educacion_formacion` WHERE `id_usuario_cv` = :id_usuario_cv";
		// $sql = "SELECT * FROM `cv_educacion_formacion` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		return $consulta;
	}
	public function listareducacion($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_educacion_formacion` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function cv_listarExperiencias($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_experiencia_laboral` WHERE id_usuario_cv = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		return $consulta;
	}
	public function listarExperiencias($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_experiencia_laboral` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function listarHabilidad($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_habilidades_aptitudes` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		return $consulta;
	}
	public function Habilidad($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_habilidades_aptitudes` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function listarPortafolio($id_usuario_cv)
	{
		$sql = "SELECT * FROM cv_portafolio WHERE id_usuario_cv = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		return $consulta;
	}
	public function cv_listarPortafolio($id_usuario_cv)
	{
		$sql = "SELECT * FROM cv_portafolio WHERE id_usuario_cv = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function listarArea($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_areas_de_conocimiento` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function cvlistarReferencias($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_referencias_personal` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		return $consulta;
	}
	public function cvalistarDocumentosAdicionales($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv AND `tipo_documento` = 'Adicional'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		return $consulta;
	}
	public function listarDocumentosAdicionales($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv AND `tipo_documento` = 'Adicional'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function cv_listarArea($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_areas_de_conocimiento` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		return $consulta;
	}
	public function listarDocumentosObligatorios($id_usuario_cv, $documento_nombre)
	{
		$sql = "SELECT * FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv AND `documento_nombre` = :documento_nombre ORDER BY `id_documentacion` DESC LIMIT 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->bindParam(":documento_nombre", $documento_nombre);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function cv_documentosObligatorios($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv  ORDER BY `id_documentacion` DESC LIMIT 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listar_documentosObligatorios($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function cv_listarReferencias($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_referencias_laborales` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		return $consulta;
	}
	public function listarReferencias($id_usuario_cv)
	{
		$sql = "SELECT * FROM `cv_referencias_laborales` WHERE `id_usuario_cv` = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado ? $resultado : false;
	}
	public function traer_departamento($id_departamento)
	{
		$sql = "SELECT * FROM departamentos WHERE id_departamento = :id_departamento";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_departamento', $id_departamento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function traer_municipio($id_municipio)
	{
		$sql = "SELECT * FROM municipios WHERE id_municipio = :id_municipio";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_municipio', $id_municipio);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function obtenerCertificados($id_usuario_cv)
	{
		$sql = "SELECT * FROM cv_educacion_formacion WHERE id_usuario_cv = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_usuario_cv', $id_usuario_cv);
		$consulta->execute();
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC); // <--- CAMBIA ESTO
		return $resultados;
	}
	public function obtenerDocumentacion($id_usuario_cv)
	{
		$sql = "SELECT * FROM cv_documentacion_usuario WHERE id_usuario_cv = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_usuario_cv', $id_usuario_cv);
		$consulta->execute();
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultados;
	}
	public function obtenerPortafolio($id_usuario_cv)
	{
		$sql = "SELECT * FROM cv_portafolio WHERE id_usuario_cv = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_usuario_cv', $id_usuario_cv);
		$consulta->execute();
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultados;
	}
	public function cv_traer_usuario_vacio($documento)
	{
		$sql = "SELECT `id_usuario_cv` FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
		global $mbd;
		$stmt = $mbd->prepare($sql);
		$stmt->bindParam(':documento', $documento);
		$stmt->execute();
		$registro = $stmt->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function UsuarioUltimaActualizacionCV($id_usuario_cv)
	{
		$sql = "SELECT ultima_actualizacion FROM cv_informacion_personal WHERE id_usuario_cv = :id_usuario_cv";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// se ajusta la funcion para que al momento de que algunas fechas salgan martes, 0 de de 0000 no las muestre asi si no que directamente las muestra como vacias.
	public function fechaesp_ajustada_formato_vacio($date)
	{
		if (empty($date) || $date == "0000-00-00" || $date == "0000-00-00 00:00:00") {
			return "No actualizada";
		}
		$dia = explode("-", $date);
		if (count($dia) < 3 || !checkdate((int)$dia[1], (int)$dia[2], (int)$dia[0])) {
			return "No actualizada";
		}
		$year  = $dia[0];
		$month = (int)$dia[1];
		$day   = (int)$dia[2];
		$dias  = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
		$meses = ["", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
		$weekdayIndex = date("w", mktime(0, 0, 0, $month, $day, $year));
		$tomadia = $dias[$weekdayIndex];
		return "$tomadia, $day de {$meses[$month]} de $year";
	}
	public function ObtenerTipoContratoDocente($documento_docente, $periodo_actual)
	{
		global $mbd;
		$sql = " SELECT  CASE  WHEN  (SELECT COUNT(*) FROM contrato_docente c WHERE c.documento_docente = :documento_docente) = 0  THEN 'Antiguo' WHEN  (SELECT COUNT(*) FROM contrato_docente c2  WHERE c2.documento_docente = :documento_docente  AND c2.periodo <> :periodo_actual ) > 0  THEN 'Antiguo' WHEN  (SELECT COUNT(*) FROM contrato_docente c3 WHERE c3.documento_docente = :documento_docente) = 0 AND EXISTS ( SELECT 1 FROM usuario u WHERE u.usuario_identificacion = :documento_docente ) THEN 'Antiguo' ELSE 'Nuevo' END AS tipo_contrato_tiempo LIMIT 1";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente, PDO::PARAM_STR);
		$consulta->bindParam(":periodo_actual", $periodo_actual, PDO::PARAM_STR);
		$consulta->execute();
		return $consulta->fetch(PDO::FETCH_ASSOC);
	}
	public function actualizar_influencer_mas($id_usuario, $influencer_mas)
	{
		global $mbd;
		$sql = "UPDATE `docente` SET `influencer_mas` = :influencer_mas WHERE `docente`.`id_usuario` = :id_usuario;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":influencer_mas", $influencer_mas);
		return $consulta->execute();
	}
	public function insertarComentarioDocente($id_usuario_cv_comentario_docente, $mensaje_docente, $fecha_actual, $hora_actual, $periodo_actual_historico, $quien_comento)
	{
		global $mbd;
		$sql = "INSERT INTO `docentes_comentarios`(`id_usuario_cv_comentario`, `mensaje_docente_comentario`, `fecha_comentario`, `hora_comentario`, `periodo_comentario`, `quien_comento_comentario`) VALUES( '$id_usuario_cv_comentario_docente','$mensaje_docente','$fecha_actual','$hora_actual','$periodo_actual_historico','$quien_comento')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	public function ListarComentariosDocente($id_usuario_cv)
	{
		$sql = "SELECT * FROM `docentes_comentarios` WHERE `id_usuario_cv_comentario` = :id_usuario_cv_comentario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_cv_comentario", $id_usuario_cv);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
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
}
