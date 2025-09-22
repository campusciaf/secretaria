<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class CargarFoto
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	// consulta para buscar 
	public function consultaBuscar($cedula,$ubicacion)
    {

        if ($ubicacion == "1") {
           $sql = "SELECT * FROM `credencial_estudiante` WHERE `credencial_identificacion` = :cedula ";
        }
        if ($ubicacion == "2") {
            $sql = "SELECT * FROM `docente` WHERE `usuario_identificacion` = :cedula ";
        }

        if ($ubicacion == "3") {
            $sql = "SELECT * FROM `usuario` WHERE `usuario_identificacion` = :cedula ";
        }

        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":cedula", $cedula);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
    }

	//Implementamos un método para editar la imagen
	public function editar($cedula, $usuario_imagen)
	{
		global $mbd;
		$sql="UPDATE usuario SET usuario_imagen='$usuario_imagen' WHERE `usuario_identificacion` = :cedula";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":cedula", $cedula);
		$consulta->execute();
		$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado2;
	}

	public function editardocente($cedula, $usuario_imagen)
	{
		global $mbd;
		$sql="UPDATE docente SET usuario_imagen='$usuario_imagen' WHERE `usuario_identificacion` = :cedula";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":cedula", $cedula);
		$consulta->execute();
		$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado2;
		


	}

}

?>