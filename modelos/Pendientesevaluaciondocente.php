<?php 

require "../config/Conexion.php";
session_start();
class Pendiente{
    public function estudiantes($id_escuela){
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare("SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial WHERE est.periodo_activo = '$periodo' and est.escuela_ciaf= :id_escuela");
        $sentencia->bindParam(":id_escuela",$id_escuela);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }


        //Implementar un método para listar los creditos matriculados
	public function cant_materias($id_estudiante,$ciclo)
	{
        $periodo = $_SESSION['periodo_actual'];
		$sql="SELECT COUNT(id_estudiante) as cantidad_matriculadas FROM `materias$ciclo` WHERE id_estudiante= :id_estudiante AND periodo='".$periodo."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    //Implementar un método para listar los creditos matriculados
	public function cant_respondidas($id_estudiante)
	{
        $periodo = $_SESSION['periodo_actual'];
		$sql="SELECT COUNT(id_estudiante) as cantidad_respuesta FROM heteroevaluacion WHERE id_estudiante= :id_estudiante AND periodo = :periodo  ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->bindParam(":periodo",$periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    

    public function datos_estudiantes($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT credencial_identificacion,credencial_nombre,credencial_apellido,status_update FROM `credencial_estudiante` WHERE id_credencial = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    //Implementar un método para traer las escuelas
    public function listarescuelas()
    {	
    
        $sql="SELECT * FROM escuelas WHERE estado='1' ORDER BY orden ASC";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }



}


?>