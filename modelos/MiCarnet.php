<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class MiCarnet
{
    public function buscar($cc)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT tres.id_estudiante, uno.credencial_nombre, uno.credencial_nombre_2, uno.credencial_apellido, uno.credencial_apellido_2, uno.credencial_identificacion, tres.id_programa_ac, tres.estado, dos.tipo_sangre, dos.tipo_documento FROM `credencial_estudiante` AS uno INNER JOIN estudiantes_datos_personales AS dos ON uno.id_credencial = dos.id_credencial INNER JOIN estudiantes AS tres ON uno.id_credencial = tres.id_credencial WHERE uno.credencial_identificacion = :cc ORDER BY `tres`.`id_estudiante` DESC LIMIT 1;");
        $sentencia->bindParam(":cc",$cc);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
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


    public function buscarprogramaestudiante($cc)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` AS uno INNER JOIN estudiantes_datos_personales AS dos ON uno.id_credencial = dos.id_credencial INNER JOIN estudiantes AS tres ON uno.id_credencial = tres.id_credencial WHERE uno.credencial_identificacion = :cc and `tres`.`estado` = 1");
        // echo $sentencia;
        $sentencia->bindParam(":cc",$cc);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }




}


?>