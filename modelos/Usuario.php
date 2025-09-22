<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($usuario_tipo_documento,$usuario_identificacion,$usuario_nombre,$usuario_nombre_2,$usuario_apellido,$usuario_apellido_2,$usuario_fecha_nacimiento,$usuario_departamento_nacimiento,$usuario_municipio_nacimiento,$usuario_direccion,$usuario_telefono,$usuario_celular,$usuario_email,$usuario_cargo,$usuario_tipo_sangre,$usuario_login,$usuario_clave,$usuario_imagen,$usuario_poa,$permisos,$pagina_web,$al_lado)
	{
		$sql="INSERT INTO usuario (usuario_tipo_documento,usuario_identificacion,usuario_nombre,usuario_nombre_2,usuario_apellido,usuario_apellido_2,usuario_fecha_nacimiento,usuario_departamento_nacimiento,usuario_municipio_nacimiento,usuario_direccion,usuario_telefono,usuario_celular,usuario_email,usuario_cargo,usuario_tipo_sangre,usuario_login,usuario_clave,usuario_imagen,usuario_poa,usuario_condicion,fecha_actualizacion,pagina_web,al_lado)
		VALUES ('$usuario_tipo_documento','$usuario_identificacion','$usuario_nombre','$usuario_nombre_2','$usuario_apellido','$usuario_apellido_2','$usuario_fecha_nacimiento','$usuario_departamento_nacimiento','$usuario_municipio_nacimiento','$usuario_direccion','$usuario_telefono','$usuario_celular','$usuario_email','$usuario_cargo','$usuario_tipo_sangre','$usuario_login','$usuario_clave','$usuario_imagen','$usuario_poa','1',NULL,'$pagina_web','$al_lado')";
		
		//return ejecutarConsulta($sql);
		//$idusuarionew=ejecutarConsulta_retornarID($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		
		//retorno el ultimo id
		$idusuarionew = $mbd->lastInsertId();
		
		
		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(id_usuario, id_permiso) VALUES('$idusuarionew', '$permisos[$num_elementos]')";
			
			$consulta2 = $mbd->prepare($sql_detalle);
			$consulta2->execute() or $sw = false;
			
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($id_usuario,$usuario_tipo_documento,$usuario_identificacion,$usuario_nombre,$usuario_nombre_2,$usuario_apellido,$usuario_apellido_2,$usuario_fecha_nacimiento,$usuario_departamento_nacimiento,$usuario_municipio_nacimiento,$usuario_direccion,$usuario_telefono,$usuario_celular,$usuario_email,$usuario_poa,$usuario_cargo,$usuario_tipo_sangre,$usuario_login,$usuario_imagen,$permisos,$pagina_web,$al_lado)
	{
		$sql="UPDATE usuario SET usuario_tipo_documento='$usuario_tipo_documento',usuario_identificacion='$usuario_identificacion',usuario_nombre='$usuario_nombre',usuario_nombre_2='$usuario_nombre_2',usuario_apellido='$usuario_apellido',usuario_apellido_2='$usuario_apellido_2',usuario_fecha_nacimiento='$usuario_fecha_nacimiento',usuario_departamento_nacimiento='$usuario_departamento_nacimiento',usuario_municipio_nacimiento='$usuario_municipio_nacimiento',usuario_direccion='$usuario_direccion',usuario_telefono='$usuario_telefono',usuario_celular='$usuario_celular',usuario_email='$usuario_email',usuario_poa='$usuario_poa',usuario_cargo='$usuario_cargo',usuario_tipo_sangre='$usuario_tipo_sangre',usuario_login='$usuario_login',usuario_imagen='$usuario_imagen',pagina_web='$pagina_web',al_lado='$al_lado' WHERE id_usuario= :id_usuario";
		//ejecutarConsulta($sql);
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM usuario_permiso WHERE id_usuario= :id_usuario";
		//ejecutarConsulta($sqldel);
		
		
		$consulta2 = $mbd->prepare($sqldel);
		$consulta2->bindParam(":id_usuario", $id_usuario);
		$consulta2->execute();
		$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			
			$sql_detalle = "INSERT INTO usuario_permiso(id_usuario, id_permiso) VALUES('$id_usuario', '$permisos[$num_elementos]')";
			
			$consulta = $mbd->prepare($sql_detalle);
			$consulta->execute() or $sw = false;
			 
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_usuario)
	{
		$sql="UPDATE usuario SET usuario_condicion='0' WHERE id_usuario= :id_usuario";
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
		$sql="UPDATE usuario SET usuario_condicion='1' WHERE id_usuario= :id_usuario";
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
		$sql="SELECT * FROM usuario WHERE id_usuario= :id_usuario";
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
		$sql="SELECT * FROM usuario";
//		return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}
	//Implementar un método para listar los permisos marcados
	public function listarmarcados($id_usuario)
	{
		$sql="SELECT * FROM usuario_permiso WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar las titulaciones
	public function listartitulaciones($id_credencia)
	{
		$sql="SELECT * FROM estudiantes WHERE id_credencial= :id_credencia and estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencia", $id_credencia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para listar las titulaciones
	public function listarcursos($id_docente)
	{
		$periodo_actual=$_SESSION['periodo_actual'];
		$sql="SELECT * FROM docente_grupos WHERE id_docente= :id_docente and periodo='".$periodo_actual."' ORDER BY jornada ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para actualizar el campo ultimo ingreso de la tabla docente
	public function ingresoupdate($id_usuario,$fecha)
	{
		$sql="UPDATE docente SET ultimo_ingreso= :fecha WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":fecha", $fecha);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

			//Implementar un método para traer los datos del programa
	public function datosPrograma($id_programa)
	{
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para traer el nombre real de la jornada
	public function datosDiaReal($jornada)
	{
		$sql="SELECT * FROM jornada WHERE nombre= :jornada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para traer el dia y la hora de la clase
	public function horaGrupo($id_docente_grupo)
	{
		$sql="SELECT * FROM horas_grupos WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	

	//Función para verificar el acceso al sistema
	public function verificarfuncionario($usuario_login,$clave)
    {
    	$sql= "SELECT `id_usuario`, `usuario_nombre`, `usuario_apellido`, `usuario_tipo_documento`, `usuario_identificacion`, `usuario_telefono`, `usuario_email`, `usuario_cargo`, `usuario_login`, `usuario_imagen`, `id_dependencia` FROM `usuario` WHERE `usuario_login` = :usuario_login AND `usuario_clave` = :clave AND usuario_condicion = '1';"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_login", $usuario_login);
		$consulta->bindParam(":clave", $clave);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
		//Función para verificar el acceso al sistema
	public function verificardocente($login,$clave)
    {
    	$sql= "SELECT id_usuario,usuario_nombre,usuario_apellido,usuario_tipo_documento,usuario_identificacion,usuario_telefono,usuario_email_ciaf,usuario_login,usuario_imagen,influencer_mas FROM docente WHERE usuario_login='".$login."' AND usuario_clave='".$clave."' AND usuario_condicion='1'"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
    }
	
	
		//Función para verificar el acceso al sistema
	public function verificarestudiante($login,$clave)
    {
		$sql="SELECT id_credencial,credencial_identificacion,credencial_nombre,credencial_nombre_2,credencial_apellido,credencial_apellido_2,credencial_identificacion,credencial_login,credencial_clave,credencial_condicion,status_update FROM credencial_estudiante WHERE credencial_login='".$login."' AND credencial_clave='".$clave."' AND credencial_condicion='1'"; 
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	public function periodoactual()
    {
    	$sql="SELECT * FROM periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	
	//Implementar un método para listar los tipos documentos
	public function selectTipoDocumento()
	{	
		$sql="SELECT * FROM tipo_documento";
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
		$sql="SELECT * FROM tipo_sangre";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los cargos
	public function selectDependencia()
	{	
		$sql="SELECT * FROM dependencias";
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
		$sql="SELECT * FROM departamentos";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para listar los departamentos en un select
	public function selectDepartamentoDos($departamento)
	{	
		$sql="SELECT * FROM departamentos WHERE departamento= :departamento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":departamento", $departamento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	
	//Implementar un método para listar los municipios en un select
	public function selectMunicipio($id_departamento)
	{	
		$sql="SELECT * FROM municipios WHERE departamento_id= :id_departamento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_departamento", $id_departamento);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
					//Implementar un método para listar los municipios en un select
	public function selectDepartamentoMunicipioActivo($id_usuario)
	{	
		$sql="SELECT * FROM usuario WHERE id_usuario= :id_usuario";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	
			//Implementar un método para listar los si o no
	public function selectlistaSiNo()
	{	
		$sql="SELECT * FROM lista_si_no";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para mirar si tiene pea activado
	public function buscarpeadocente($id_docente_grupo)
    {
    	$sql="SELECT * FROM pea_docentes WHERE id_docente_grupo= :id_docente_grupo"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	//Implementamos un método para insertar el ingreso al campus
	public function ingreso($id_usuario,$roll,$fecha,$hora,$ip)
	{
		$sql="INSERT INTO ingresos_campus (id_usuario,roll,fecha,hora,ip) VALUES ('$id_usuario','$roll','$fecha','$hora','$ip')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para mirar el id para reestablecer la clave
	public function buscaridlink($email,$tablalink,$campo)
    {	
    	$sql="SELECT * FROM $tablalink WHERE $campo= :email"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":email", $email);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	//Implementamos un método para insertar la solicitud de cambio de clave
	public function insertarLink($id_credencial,$roll_link,$email_link,$token,$codigo,$fecha,$hora)
	{
		$sql="INSERT INTO password (id_credencial,roll_link,email_link,token,codigo,fecha,hora) VALUES ('$id_credencial','$roll_link','$email_link','$token','$codigo','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementar un método para mirar el id para reestablecer la clave
	public function consultar_Estado_Estudiante($cedula)
    {	
    	$sql="SELECT estado_ciafi FROM `sofi_persona` INNER JOIN sofi_matricula on sofi_matricula.id_persona = sofi_persona.id_persona WHERE numero_documento = :cedula ORDER BY `sofi_persona`.`id_persona` DESC"; 
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":cedula", $cedula);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	

	public function mostrarImagenBanner()
	{	
		$sql="SELECT * FROM banner_campus";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	public function consultar_Estado_Veedor($id_credencial){	
    	$sql="SELECT * FROM `veedores` WHERE `id_credencial` = :id_credencial"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    } 
	
	public function	verificarestudianteegresado($id_credencial)
	{	
		$sql="SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial AND ciclo=3 AND `estado` In (2,5)"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
}

?>