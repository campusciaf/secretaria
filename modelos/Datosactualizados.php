<?php 
require "../config/Conexion.php";
session_start();
class Consulta
{
    public function datos($estado)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare("SELECT DISTINCT id_credencial FROM `estudiantes` WHERE periodo_activo = '$periodo' ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function consultaDatos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial = edp.id_credencial INNER JOIN estudiantes est ON ce.id_credencial=est.id_credencial WHERE ce.id_credencial = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;

    }
    public function programa($id)
    {
        global $mbd;
        $data = array();
        $sentencia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE id_programa = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro['nombre'];

    }
    
    //Implementar un método para mirar data del estudiante
	public function est_carac_habeas($id_credencial){
    	$sql="SELECT * FROM caracterizacion_data WHERE id_credencial= :id_credencial"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	function calculaedad($fechanacimiento){
		list($ano,$mes,$dia) = explode("-",$fechanacimiento);
		$ano_diferencia  = date("Y") - $ano;
		$mes_diferencia = date("m") - $mes;
		$dia_diferencia   = date("d") - $dia;
		if ($dia_diferencia < 0 || $mes_diferencia < 0)
		$ano_diferencia--;
		return $ano_diferencia;
	}
}


?>