<?php 
require "../config/Conexion.php";
class OncenterClaveCliente
{
	//Implementamos un método para desactivar categorías
	public function reestablecer($id_estudiante,$clave)
	{
		$sql="UPDATE on_interesados SET clave= :clave WHERE id_estudiante= :id_estudiante";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":clave", $clave);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

	//Consultar datos del estudiante
    public function consultaEstudiante($id_estudiante){

		$sql = "SELECT * FROM `on_interesados` WHERE `id_estudiante` = :id_estudiante";
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

	public function restablecerContrasena($clave, $id_estudiante){
       
        
		$sql = "UPDATE  `on_interesados` SET `clave` = :clave WHERE `id_estudiante` = :id_estudiante ";
		// echo $sql;
        
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":clave", $clave);
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        return $sentencia->execute();
    }

}




?>