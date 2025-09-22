<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class OncenterValFormulario{
	//Implementamos nuestro constructor
	public function __construct() {}
	public function periodoactual()
	{
		$sql = "SELECT * FROM on_periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql = "INSERT INTO on_programa (nombre) VALUES ('$nombre')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar registros
	public function editar($id_programa, $nombre)
	{
		$sql = "UPDATE on_programa SET nombre='$nombre' WHERE id_programa='$id_programa'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();
	}
	//Implementar un método para listar los registros
	public function listar($periodo_actual)
	{
		$sql = "SELECT * FROM on_interesados WHERE estado='Preinscrito' and periodo_campana= :periodo_actual";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function perfilEstudiante($id_estudiante)
	{
		$sql = "SELECT * FROM on_interesados oi INNER JOIN on_interesados_datos oin ON oi.id_estudiante=oin.id_estudiante WHERE oi.id_estudiante= :id_estudiante";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los programas en un select
	public function selectPrograma()
	{
		$sql = "SELECT * FROM on_programa WHERE estado=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los jornadas en un select
	public function selectJornada()
	{
		$sql = "SELECT * FROM on_jornadas";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los tipo de documentos en un select
	public function selectTipoDocumento()
	{
		$sql = "SELECT * FROM on_tipo_documento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar niveles e escolaridad
	public function selectNivelEscolaridad()
	{
		$sql = "SELECT * FROM on_nivel_escolaridad";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function verDatosEstudiante($id_estudiante)
	{
		$sql = "SELECT * FROM on_interesados WHERE id_estudiante= :id_estudiante";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function verFormularioEstudiante($id_estudiante)
	{
		$sql = "SELECT * FROM on_interesados WHERE id_estudiante= :id_estudiante";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para actualziar el perfil
	public function editarPerfil($id_estudiante, $fo_programa, $jornada_e, $tipo_documento, $nombre, $nombre_2, $apellidos, $apellidos_2, $celular, $email, $nivel_escolaridad, $nombre_colegio, $fecha_graduacion)
	{
		$sql = "UPDATE on_interesados oi INNER JOIN on_interesados_datos oid ON oi.id_estudiante=oid.id_estudiante SET oi.fo_programa= :fo_programa, oi.jornada_e= :jornada_e, oi.tipo_documento= :tipo_documento, oi.nombre= :nombre, oi.nombre_2= :nombre_2, oi.apellidos= :apellidos, oi.apellidos_2= :apellidos_2, oi.celular= :celular, oi.email= :email, oid.nivel_escolaridad= :nivel_escolaridad, oid.nombre_colegio= :nombre_colegio, oid.fecha_graduacion= :fecha_graduacion WHERE oi.id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->bindParam(":jornada_e", $jornada_e);
		$consulta->bindParam(":tipo_documento", $tipo_documento);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":nombre_2", $nombre_2);
		$consulta->bindParam(":apellidos", $apellidos);
		$consulta->bindParam(":apellidos_2", $apellidos_2);
		$consulta->bindParam(":celular", $celular);
		$consulta->bindParam(":email", $email);
		$consulta->bindParam(":nivel_escolaridad", $nivel_escolaridad);
		$consulta->bindParam(":nombre_colegio", $nombre_colegio);
		$consulta->bindParam(":fecha_graduacion", $fecha_graduacion);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el estado del formulario
	public function actualizarFormulario($id_estudiante)
	{
		$sql = "UPDATE on_interesados SET formulario=0 WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementamos un método para insertar un seguimiento
	public function registrarSeguimiento($id_usuario, $id_estudiante_documento, $motivo, $mensaje_seguimiento, $fecha, $hora)
	{
		$sql = "INSERT INTO on_seguimiento (id_usuario,id_estudiante,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento) VALUES ('$id_usuario','$id_estudiante_documento','$motivo','$mensaje_seguimiento','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
	}
	//Implementamos un método para cambio de estado a inscrito
	public function cambioEstado($id_estudiante)
	{
		$sql = "UPDATE on_interesados SET estado='Inscrito' WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	public function registrarestado($id_usuario, $id_estudiante, $estado, $fecha, $hora, $periodo_campana)
	{
		$sql = "INSERT INTO on_cambioestado (id_usuario,id_estudiante,estado,fecha_seguimiento,hora_seguimiento,periodo)
		VALUES ('$id_usuario','$id_estudiante','$estado','$fecha','$hora','$periodo_campana')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para listar lod formualrios validados
	public function listarDatos($mensaje_seguimiento, $periodo)
	{
		$sql = "SELECT * FROM on_seguimiento os INNER JOIN on_interesados oi ON os.id_estudiante=oi.id_estudiante WHERE oi.periodo_campana= :periodo AND os.mensaje_seguimiento like '%$mensaje_seguimiento%'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":mensaje_seguimiento", $mensaje_seguimiento);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar lod formualrios validados
	public function listarDatosFecha($mensaje_seguimiento, $periodo, $fecha)
	{
		$sql = "SELECT * FROM on_seguimiento os INNER JOIN on_interesados oi ON os.id_estudiante=oi.id_estudiante WHERE oi.periodo_campana= :periodo AND os.mensaje_seguimiento like '%$mensaje_seguimiento%' AND os.fecha_seguimiento <= :fecha";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":mensaje_seguimiento", $mensaje_seguimiento);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":fecha", $fecha);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estudiantes que validaron formulario y que ahora estan matriculados
	public function listarDatosMatriculados($mensaje_seguimiento, $periodo)
	{
		$sql = "SELECT * FROM on_seguimiento os INNER JOIN on_interesados oi ON os.id_estudiante=oi.id_estudiante WHERE oi.periodo_campana= :periodo AND os.mensaje_seguimiento like '%$mensaje_seguimiento%' AND oi.estado='Matriculado'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar lod formualrios validados
	public function listarDatosMatriculadosFecha($mensaje_seguimiento, $periodo, $fecha)
	{
		$sql = "SELECT * FROM on_seguimiento os INNER JOIN on_interesados oi ON os.id_estudiante=oi.id_estudiante WHERE oi.periodo_campana= :periodo AND os.mensaje_seguimiento like '%$mensaje_seguimiento%' AND oi.estado='Matriculado' AND os.fecha_seguimiento <= :fecha ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":mensaje_seguimiento", $mensaje_seguimiento);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":fecha", $fecha);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function calPorcentaje($dato1, $dato2)
	{ // calcula el incremento o decremento de dos variables
		$porcentaje = (($dato1 - $dato2) / $dato1) * 100;
		return round($porcentaje, 2);
	}
}