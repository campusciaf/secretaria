<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Header
{
    public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    public function listarTema()
    {
        global $mbd;
        $id = intval($_SESSION["id_usuario"]);
        $sentencia = $mbd->prepare(" SELECT id_usuario,modo_ui FROM `usuario` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function listarPuntos()
    {
        $id = $_SESSION['id_usuario'];
        global $mbd;
        $sentencia = $mbd->prepare("SELECT id_usuario,puntos,nivel FROM `usuario` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    } 


    	//Implementar un método para saber si actualizo el perfil
        public function verPerfilActualizadofuncionario($id_usuario,$fecha)
        {
            $sql="SELECT * FROM usuario WHERE id_usuario= :id_usuario and fecha_actualizacion >= :fecha";
            
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_usuario", $id_usuario);
            $consulta->bindParam(":fecha", $fecha);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

    	//Implementar un método para saber si actualizo el perfil
        public function verPerfilActualizadodocente($id_usuario,$fecha)
        {
            $sql="SELECT * FROM docente WHERE id_usuario= :id_usuario and fecha_actualizacion >= :fecha";
            
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_usuario", $id_usuario);
            $consulta->bindParam(":fecha", $fecha);
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

        
	//Implementamos un método para actualizar el perfil
	public function actualizarperfil($id_usuario,$usuario_direccion,$usuario_telefono,$usuario_celular,$usuario_email,$fecha)
	{
		$sql="UPDATE usuario SET usuario_direccion= :usuario_direccion, usuario_telefono= :usuario_telefono, usuario_celular= :usuario_celular, usuario_email= :usuario_email, fecha_actualizacion= :fecha   WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":usuario_direccion", $usuario_direccion);
        $consulta->bindParam(":usuario_telefono", $usuario_telefono);
        $consulta->bindParam(":usuario_celular", $usuario_celular);
        $consulta->bindParam(":usuario_email", $usuario_email);
        $consulta->bindParam(":fecha", $fecha);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

    public function consultaAdmin()
    {
        global $mbd;        
        $id = $_SESSION['id_usuario'];

        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

    }


    //consulta para traer el periodo actual para el carnet 
    public function PeriodoActualCarnet(){
        $sql="SELECT periodo_actual FROM `periodo_actual`"; 
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function buscarPermiso(){// busca el permiso, en la tabla usuaruioi consulta si es un asesor con valor 0
        global $mbd;        
        $id = $_SESSION['id_usuario'];

        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    /* consulta que trae las tareas programadas en el rango de tiempo establecido */
    public function buscarTareas($fecha,$horai,$horaf)
    {	
        $id = isset($_SESSION['id_usuario'])? $_SESSION['id_usuario']:0;
        $sql="SELECT * FROM on_interesados_tareas_programadas WHERE id_usuario= :id and fecha_programada= :fecha and hora_programada BETWEEN :horai and :horaf and estado=1 and recordar=1";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":horai", $horai);
        $consulta->bindParam(":horaf", $horaf);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    /* consulta que cambia el estado del recordatorio */
    public function recordatorioTarea($id_tarea)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `on_interesados_tareas_programadas` SET `recordar`= 0 WHERE `id_tarea` = :id ");
        $sentencia->bindParam(":id",$id_tarea);
        $sentencia->execute();
 
    }








    
}


?>