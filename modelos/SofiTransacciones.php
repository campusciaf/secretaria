<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class SofiTransacciones{
	//Implementamos nuestro constructor
	public function __construct(){}
    //listar todos periodos
    public function listarPeriodos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `periodo` FROM `periodo` ORDER BY `periodo`.`periodo` DESC");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
	//Función para listar los pagos
    public function listarPagosPorPeriodo($periodo){
        $sql="SELECT * FROM `pagos_rematricula` WHERE periodo_pecuniario= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Función para listar los pagos
    public function listarPagosPorDia($inicio, $fin){
        $sql= "SELECT * FROM `pagos_rematricula` WHERE DATE(`x_fecha_transaccion`) BETWEEN :inicio AND :fin";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":inicio", $inicio);
		$consulta->bindParam(":fin", $fin);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Función para listar los pagos
    public function listarPagosPorIdentificacion($identificacion){
        $sql= "SELECT * FROM `pagos_rematricula` WHERE `identificacion_estudiante` = :identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":identificacion", $identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	 //listar pago detalle
    public function listarPagosDetalle($id_pago){  
		$sql="SELECT * FROM `pagos_rematricula` WHERE id_pagos= :id_pago";  
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pago", $id_pago);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

		 //taer semestre actual
		 public function traersemestre($id_estudiante){  
			$sql="SELECT id_estudiante,semestre_estudiante FROM `estudiantes` WHERE id_estudiante= :id_estudiante";  
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_estudiante", $id_estudiante);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

}