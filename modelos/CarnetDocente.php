<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class CarnetDocente
{


    // Implementamos una función para cargar los estudiantes que estan pendientes por renovar
    public function datosdocente(){
        $id = $_SESSION['id_usuario'];
        $sql = "SELECT * FROM docente WHERE id_usuario= :id";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function consultaprograma($id)
    {
        $sql="SELECT * FROM `programa_ac` WHERE `id_programa` = :id"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id",$id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

    }

    public function consultaestudiante()
    {
        global $mbd;        
        $id = $_SESSION['id_usuario'];

        $sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

    }

    public function consultadocente()
    {
        global $mbd;        
        $id = $_SESSION['id_usuario'];

        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

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

    public function mostrarconvenios(){	
		global $mbd;
		$sql="SELECT * FROM `web_bienestar_convenios` ORDER BY `web_bienestar_convenios`.`estado` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
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

}


?>