<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class BolsaEmpleoOfertas
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Implementar un método para listar los registros
	public function Listar_Ofertas_Laborales()
	{
		$sql = "SELECT * FROM bolsa_empleo_ofertas WHERE `estado_oferta` = 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//traemos el nombre de la empresa 
	public function nombre_empresa($id_usuario)
	{
		$sql = "SELECT * FROM `empresa` WHERE `id_usuario` = :id_usuario";
		global $mbd;
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function mostrar_ofertas_laborales($id_bolsa_empleo_oferta)
	{
		$sql = "SELECT * FROM `bolsa_empleo_ofertas` WHERE `id_bolsa_empleo_oferta` = :id_bolsa_empleo_oferta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_bolsa_empleo_oferta", $id_bolsa_empleo_oferta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function insertarofertalaboral($cargo, $tipo_contrato, $salario, $fecha_contratacion, $id_usuario, $modalidad_trabajo, $ciclo_propedeutico, $perfil, $programa_estudio, $funciones)
	{
		global $mbd;
		$sql = "INSERT INTO bolsa_empleo_ofertas (cargo, tipo_contrato, salario, fecha_contratacion,id_usuario, modalidad_trabajo, ciclo_propedeutico,perfil, programa_estudio, funciones) VALUES ('$cargo', '$tipo_contrato', '$salario', '$fecha_contratacion','$id_usuario', '$modalidad_trabajo', '$ciclo_propedeutico','$perfil', '$programa_estudio', '$funciones')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function editarofertalaboral($id_bolsa_empleo_oferta, $cargo, $tipo_contrato, $salario, $fecha_contratacion, $id_usuario, $modalidad_trabajo, $ciclo_propedeutico, $perfil, $programa_estudio, $funciones)
	{
		$sql = "UPDATE `bolsa_empleo_ofertas` SET `id_bolsa_empleo_oferta` = '$id_bolsa_empleo_oferta',`cargo` = '$cargo',`tipo_contrato` = '$tipo_contrato',`salario` = '$salario',`fecha_contratacion` = '$fecha_contratacion',`id_usuario` = '$id_usuario',`modalidad_trabajo` = '$modalidad_trabajo',`ciclo_propedeutico` = '$ciclo_propedeutico',`perfil` = '$perfil',`programa_estudio` = '$programa_estudio',`funciones` = '$funciones' WHERE `id_bolsa_empleo_oferta` = '$id_bolsa_empleo_oferta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
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
	public function ListarUsuariosPostulados($id_bolsa_empleo_oferta)
	{
		$sql = "SELECT * FROM `bolsa_empleo_postulados` WHERE id_bolsa_empleo_oferta = :id_bolsa_empleo_oferta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_bolsa_empleo_oferta", $id_bolsa_empleo_oferta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarDatosPostulados($credencial_estudiante)
	{
		global $mbd;
		$sql = "SELECT * FROM credencial_estudiante INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial WHERE credencial_estudiante.id_credencial = :credencial_estudiante";
		$sentencia = $mbd->prepare($sql);
		$sentencia->bindParam(":credencial_estudiante", $credencial_estudiante, PDO::PARAM_INT);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	public function editarmotivofinalizacion($id_bolsa_empleo_oferta, $motivo_finalizacion)
	{
		$sql = "UPDATE bolsa_empleo_ofertas SET motivo_finalizacion = :motivo_finalizacion,estado_oferta= 0 WHERE id_bolsa_empleo_oferta = :id_bolsa_empleo_oferta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':motivo_finalizacion', $motivo_finalizacion);
		$consulta->bindParam(':id_bolsa_empleo_oferta', $id_bolsa_empleo_oferta);
		return $consulta->execute();
	}

	public function selectlistarProgramas()
	{
		$sql = "SELECT * FROM escuelas WHERE estado = 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
}
