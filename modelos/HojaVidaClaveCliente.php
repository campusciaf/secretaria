<?php 
require "../config/Conexion.php";
class HojaVidaClaveCliente
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


	//Implementar un método para listar los registros
    public function listar(){
        $sql = "SELECT `cv_usuario`.`id_usuario_cv`,`cv_usuario`.`usuario_identificacion`,`cv_usuario`.`usuario_nombre`,`cv_usuario`.`usuario_clave`,`cv_usuario`.`usuario_apellido`,`cv_usuario`.`usuario_email`, `cv_usuario`.`usuario_condicion`, `cv_informacion_personal`.`telefono`, `cv_informacion_personal`.`estado`, `cv_informacion_personal`.`create_dt` FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv`";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


	//Consultar datos del estudiante
    public function consultaUsuarioCV($usuario_identificacion){

		$sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv` WHERE `cv_usuario`.`usuario_identificacion` = :usuario_identificacion";
		// echo $sql;
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":usuario_identificacion", $usuario_identificacion);
        $sentencia->execute();
        $registro = $sentencia->fetchAll();
        return $registro;
    }

	public function restablecerContrasena($clave, $usuario_email){
       

		$sql = "UPDATE  `cv_usuario` SET `usuario_clave` = :clave WHERE `usuario_email` = :usuario_email ";
		// echo $sql;
        
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":clave", $clave);
        $sentencia->bindParam(":usuario_email", $usuario_email);
        return $sentencia->execute();
    }

	//seleccionamos el cargo 
	public function Listar_Usarios($usuario_identificacion)
	{	
		$sql="SELECT * FROM cv_usuario WHERE `usuario_identificacion` = :usuario_identificacion";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
		return $resultado;		
	}


}




?>