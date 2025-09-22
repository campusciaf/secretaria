<?php
require "../config/Conexion.php";

class Claves
{
    public function listarClaves($id_usuario)
    {
        $sql = "SELECT * FROM clave WHERE id_usuario= :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function agregar($clave_plataforma, $clave_url, $clave_usuario, $clave_contrasena, $clave_descripcion, $clave_estado, $clave_fecha, $clave_hora, $id_usuario)
    {
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `clave`(`clave_plataforma`, `clave_url`, `clave_usuario`, `clave_contrasena`,`clave_descripcion`,`clave_estado`,`clave_fecha`,`clave_hora`,`id_usuario`) 
                                    VALUES (:clave_plataforma,:clave_url,:clave_usuario,:clave_contrasena,:clave_descripcion,:clave_estado,:clave_fecha,:clave_hora,:id_usuario)");

        $sentencia->bindParam(":clave_plataforma",$clave_plataforma);
        $sentencia->bindParam(":clave_url",$clave_url);
        $sentencia->bindParam(":clave_usuario",$clave_usuario);
        $sentencia->bindParam(":clave_contrasena",$clave_contrasena);
        $sentencia->bindParam(":clave_descripcion",$clave_descripcion);
        $sentencia->bindParam(":clave_estado",$clave_estado);
        $sentencia->bindParam(":clave_fecha",$clave_fecha);
        $sentencia->bindParam(":clave_hora",$clave_hora);
        $sentencia->bindParam(":id_usuario",$id_usuario);
        return $sentencia->execute();


    }

    public function eliminar($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("DELETE FROM `salones` WHERE `codigo` = :id ");
        $sentencia->bindParam(":id",$id);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        }else {
            $data['status'] = "Error al eliminar el salón, ponte en contacto con el administrador.";
        }
        echo json_encode($data);
    }

    public function estado($id,$est,$fecha,$hora)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `clave` SET `clave_estado` = :est, clave_fecha= :fecha, clave_hora= :hora WHERE `id_clave` = :id ");
        $sentencia->bindParam(":est",$est);
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":fecha",$fecha);
        $sentencia->bindParam(":hora",$hora);
        return $sentencia->execute();
        
    }



    	//Implementar un método para mostrar los datos del docente
	public function mostrarplataforma($id_clave){

		$sql = "SELECT * FROM `clave` WHERE `id_clave` = :id_clave";
        
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_clave", $id_clave);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function listar_salones()
	{	
		$sql="SELECT `codigo`,`capacidad`,`piso` FROM salones";
        // echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}


    public function editarplataforma($id_clave, $clave_plataforma, $clave_url, $clave_usuario, $clave_contrasena, $clave_descripcion, $clave_fecha, $clave_hora, $id_usuario){
		$sql="UPDATE `clave` SET 
        `clave_plataforma` = '$clave_plataforma',
        `clave_url` = '$clave_url', 
        `clave_usuario` = '$clave_usuario', 
        `clave_contrasena` = '$clave_contrasena',
        `clave_descripcion` = '$clave_descripcion',
        `clave_fecha` = '$clave_fecha',
        `clave_hora` = '$clave_hora',
        `id_usuario` = '$id_usuario' 
        WHERE `id_clave` = '$id_clave'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

}


?>