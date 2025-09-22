<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
date_default_timezone_set('America/Bogota');

class SofiReporteDatacredito{
	//Función para listar los pagos
    public function listarCreditosActivos(){
        //novedad
        // 01  (al dia) 
        // 05  (pago voluntario o pago total) 
        // 06  (mora 30)  
        // 07  (mora 60) 
        // 08  (mora 90) 
        // 09  (mora 120 o mas)  
        // 12  (dudoso recuado) 
        // 13  (cartera castigada)  
        // 14  (cartera recuperada)

        // situacion_cartera
        //Situacion de la OBLIGACION al momendo DEL REPORTE  
        //(0) normal  
        //(1) reestructuracion 
        //(2) refinanciacion 
        //(3) transferencia otro producto 
        //(4) comprada 
        //(5) normal reestructurada 
        //(6) normal refinanciada

        //Valor disponible (No aplica para obligaciones de credito educativo)
        //Aplica solo para obligaciones con CUPO ASIGNADO  , es  la diferencia entre el valor inicial y valor usado (DEUDA).

        $sql = "SELECT  tipo_documento,  cedula, UPPER(REGEXP_REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(TRIM(nombre)), 'Ñ','N'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U'), '[^A-Z ]','')  ) AS nombre_completo, consecutivo, DATE(fecha_inicio) AS fecha_inicio, DATE(ultima_fecha_cuota) AS ultima_fecha_cuota, '00' AS responsable,  CASE WHEN atraso = 0 THEN '01' WHEN atraso BETWEEN 1 AND 30  THEN '06'  WHEN atraso BETWEEN 31 AND 60  THEN '07'  WHEN atraso BETWEEN 61 AND 90  THEN '08'  WHEN atraso BETWEEN 91 AND 120 THEN '09'  WHEN atraso > 120 THEN '12'  WHEN en_cobro = 1 THEN '13'   ELSE '01' END AS novedad,  0 AS situacion_cartera,  credito, faltante,  0 AS valor_disponible, ROUND(credito / NULLIF(cuotas,0), 2) AS valor_cuota, cuotas, CASE WHEN cuotas_atrasadas = 0 THEN 0 ELSE 1 END AS cuotas_en_mora,  COALESCE(DATE(fecha_ultimo_pago), 0) AS fecha_ultimo_pago, cuotas_pagadas, email, celular, direccion, ciudad FROM creditos_control ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function fechaesp($date) {
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}
}
?>