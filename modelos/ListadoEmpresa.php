<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class ListadoEmpresa
{
	//Implementamos nuestro constructor
	public function __construct() {}
	//Implementar un método para listar los registros
	
	public function Listar_empresa()
	{
		$sql = "SELECT * FROM empresa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	

	public function mostrar_empresa($id_usuario)
	{
		$sql = "SELECT * FROM `empresa` WHERE `id_usuario` = :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	public function insertarempresa($usuario_nit, $usuario_nombre, $usuario_area_ss, $usuario_representante, $usuario_celular, $usuario_horario_pactado)
	{
		global $mbd;
		$sql = "INSERT INTO empresa (usuario_nit, usuario_nombre, usuario_area_ss, usuario_representante, usuario_celular, usuario_horario_pactado) 
				VALUES (:usuario_nit, :usuario_nombre, :usuario_area_ss, :usuario_representante, :usuario_celular, :usuario_horario_pactado)";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':usuario_nit', $usuario_nit);
		$consulta->bindParam(':usuario_nombre', $usuario_nombre);
		$consulta->bindParam(':usuario_area_ss', $usuario_area_ss);
		$consulta->bindParam(':usuario_representante', $usuario_representante);
		$consulta->bindParam(':usuario_celular', $usuario_celular);
		$consulta->bindParam(':usuario_horario_pactado', $usuario_horario_pactado);
		return $consulta->execute();
	}


public function editarempresa($id_usuario,$usuario_nit, $usuario_nombre, $usuario_area_ss, $usuario_representante, $usuario_celular, $usuario_horario_pactado)
{
    $sql = "UPDATE `empresa` SET `id_usuario` = :id_usuario,`usuario_nit` = :usuario_nit, `usuario_nombre` = :usuario_nombre, `usuario_area_ss` = :usuario_area_ss,   `usuario_representante` = :usuario_representante, `usuario_celular` = :usuario_celular, `usuario_horario_pactado` = :usuario_horario_pactado  WHERE `id_usuario` = :id_usuario";
    global $mbd;
    $consulta = $mbd->prepare($sql);
	$consulta->bindParam(':id_usuario', $id_usuario);
    $consulta->bindParam(':usuario_nit', $usuario_nit);
    $consulta->bindParam(':usuario_nombre', $usuario_nombre);
    $consulta->bindParam(':usuario_area_ss', $usuario_area_ss);
    $consulta->bindParam(':usuario_representante', $usuario_representante);
    $consulta->bindParam(':usuario_celular', $usuario_celular);
    $consulta->bindParam(':usuario_horario_pactado', $usuario_horario_pactado);
    return $consulta->execute();
}
	
	
public function eliminar($id_usuario)
	{
		$sql="DELETE FROM empresa WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
	
	}
	
	public function ListarUsuariosPostulados($id_usuario)
{
    $sql = "SELECT * FROM serviciosocial_contratacion WHERE id_empresa = :id_usuario";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $resultado ?: []; // Devuelve un arreglo vacío si no hay resultados
}


public function listarDatosPostulados($credencial_estudiante)
{
    $sql = "SELECT 
                credencial_estudiante.credencial_nombre, 
                credencial_estudiante.credencial_nombre_2, 
                credencial_estudiante.credencial_apellido, 
                credencial_estudiante.credencial_apellido_2, 
                estudiantes_datos_personales.celular, 
                estudiantes_datos_personales.email 
            FROM credencial_estudiante 
            INNER JOIN estudiantes_datos_personales 
            ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial 
            WHERE credencial_estudiante.id_credencial = :credencial_estudiante";
    
    global $mbd;
    $sentencia = $mbd->prepare($sql);
    $sentencia->bindParam(":credencial_estudiante", $credencial_estudiante, PDO::PARAM_INT);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
    return $registro ?: false;
}



}
