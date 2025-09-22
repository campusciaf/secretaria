<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Estadistica{
	//Implementamos nuestro constructor
	public function __construct(){

	}
    //Implementar un método para mostrar los botones que activan las preguntas
	public function listarCategoria(){
		global $mbd;
		$sql = "SELECT * FROM `categoria` WHERE `categoria_estado` = 1";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
    //Implementar un método para mostrar los botones que activan las preguntas
	public function listarPeriodos(){
		global $mbd;
		$sql = "SELECT * FROM `periodo` ORDER BY `periodo`.`id_periodo` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estudiantes
	public function listarEstudiantes($id_categoria, $periodo){
		$sql= "SELECT DISTINCT `caracterizacion`.`id_usuario` FROM `caracterizacion`
		INNER JOIN `caracterizacion_data` 
		ON `caracterizacion`.`id_usuario` = `caracterizacion_data`.`id_credencial` 
		WHERE `caracterizacion`.`id_categoria` = :id_categoria AND `caracterizacion_data`.`periodo` = :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
        $consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los estudiantes
	public function listarEstudiantesDatos($id_credencial){
		$sql="SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial INNER JOIN caracterizacion_data cd ON ce.id_credencial=cd.id_credencial WHERE ce.id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//calcula la edad por medio de la fecha de nacimiento
	function calculaEdad($fechanacimiento){
		list($ano, $mes, $dia) = explode("-", $fechanacimiento);
		$ano_diferencia  = date("Y") - $ano;
		$mes_diferencia = date("m") - $mes;
		$dia_diferencia   = date("d") - $dia;
		if ($dia_diferencia < 0 || $mes_diferencia < 0)
		$ano_diferencia--;
		return $ano_diferencia;
	}
	
}

?>