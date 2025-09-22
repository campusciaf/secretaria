<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class certificadoEstudianteServicioSocial
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
	




	

	
	public function ListarUsuariosPostulados($id_usuario)
{
    $sql = "SELECT * FROM serviciosocial_contratacion WHERE id_empresa = :id_usuario";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $resultado ?: []; 
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



public function listarDatosprograma($credencial_estudiante)
{
    $sql = "SELECT * FROM `estudiantes` WHERE `id_credencial` = :credencial_estudiante AND periodo=:periodo_actual";
    
    global $mbd;
    $sentencia = $mbd->prepare($sql);
    $sentencia->bindParam(":credencial_estudiante", $credencial_estudiante, PDO::PARAM_INT);
	$sentencia->bindParam(":periodo_actual", $_SESSION["periodo_actual"], PDO::PARAM_STR);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
    return $registro ?: false;
}


public function listarActividadesConEmpresa($credencial_estudiante)
{
    $sql = "SELECT 
                a.id_credencial,
                a.id_empresa,
                a.ac_realizadas, a.actividades_competencias,
                e.usuario_nombre AS nombre_empresa
            FROM actividades_servicio_social a
            JOIN empresa e ON a.id_empresa = e.id_usuario
            WHERE a.id_credencial = :credencial_estudiante";

    global $mbd;
    $sentencia = $mbd->prepare($sql);
    $sentencia->bindParam(":credencial_estudiante", $credencial_estudiante);
    $sentencia->execute();
    $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    return $registros ?: false;
}


public function fechaesp($date) {
	$dia 	= explode("-", $date, 3);
	$year 	= $dia[0];
	$month 	= (string)(int)$dia[1];
	$day 	= (string)(int)$dia[2];

	$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
	$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

	$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

	return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
}


}
