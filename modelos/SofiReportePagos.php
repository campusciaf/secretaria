<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class SofiReportePagos{
	//Implementamos nuestro constructor
	public function __construct(){}
	//Función para listar los pagos
	public function listarPagosPorPeriodo($periodo)
	{
		$sql = "SELECT * FROM `sofi_pagos_epayco` WHERE `periodo` = :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Función para listar los pagos
	public function listarPagosPorDia($inicio, $fin)
	{
		$sql = "SELECT * FROM `sofi_pagos_epayco` WHERE `x_respuesta` = 'Aceptada' AND DATE(`x_fecha_transaccion`) BETWEEN :inicio AND :fin";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":inicio", $inicio);
		$consulta->bindParam(":fin", $fin);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Función para listar los pagos
	public function listarPagosPorConsecutivo($consecutivo)
	{
		$sql = "SELECT * FROM `sofi_pagos_epayco` WHERE `consecutivo` = :consecutivo AND `x_respuesta` = 'Aceptada'" ;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":consecutivo", $consecutivo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Función para listar los pagos
	public function listarPagosConsecutivo($consecutivo){
		$sql = "SELECT * FROM `sofi_pagos_epayco` WHERE `consecutivo` = :consecutivo AND `x_respuesta` = 'Aceptada'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":consecutivo", $consecutivo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//listar pago detalle
	public function listarPagosDetalle($id_pago)
	{
		$sql = "SELECT * FROM `sofi_pagos_epayco` WHERE `id_pagos` = :id_pago";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pago", $id_pago);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}