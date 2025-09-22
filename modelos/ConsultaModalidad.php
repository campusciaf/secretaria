<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class ConsultaModalidad{
    //lista todos los financiados
    public function periodoactual()
    {
    	$sql="SELECT * FROM on_periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
    public function selectPeriodo(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `periodo` ORDER BY `periodo`.`periodo` DESC");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
        //Implementar un método para listar las materias matriculadas
    public function listarMateriasModalidad($periodo)
    {	
        $sql="SELECT * FROM materias_modalidad mm INNER JOIN estudiantes est ON mm.id_estudiante=est.id_estudiante INNER JOIN credencial_estudiante ce ON mm.id_credencial=ce.id_credencial WHERE mm.periodo= :periodo";	
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function datosmateria($id_materia){
        
        $sql = "SELECT * FROM `materias_ciafi` WHERE id= :id_materia";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_materia", $id_materia);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    public function datosmateriamodalidad($id_materias_ciafi_modalidad){
        
        $sql = "SELECT * FROM `materias_ciafi_modalidad` WHERE id_materias_ciafi_modalidad= :id_materias_ciafi_modalidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_materias_ciafi_modalidad", $id_materias_ciafi_modalidad);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

   
}
?>