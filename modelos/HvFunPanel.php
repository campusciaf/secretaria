<?php

session_start(); 

//Incluímos inicialmente la conexión a la base de datos

require "../config/Conexion.php";
class Panel{
	//Implementamos nuestro constructor
	public function __construct(){

	}
	//Implementar un método para listar los micompromisos
	public function cv_listar(){	
		$sql="SELECT * FROM educacion_continuada WHERE estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function cv_traerIdUsuario($documento){
        $sql = "SELECT `id_usuario_cv` FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    } 

}

?>