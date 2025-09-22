<?php
require "../config/Conexion.php";
class PagosAgregador{
	//Implementamos nuestro constructor
	public function __construct(){}
	//Implementamos un método para insertar un pago de la rematricula
	public function insertarPagoSofi($x_id_factura, $id_persona, $consecutivo, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $tipo_pago){
		global $mbd;
		$sql = "INSERT INTO `sofi_pagos_epayco`(`x_id_factura`, `id_persona`, `consecutivo`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`, `tipo_pago`, `yeminus_ok`) VALUES ('$x_id_factura', '$id_persona', '$consecutivo', '$x_description', '$x_amount_base', '$x_currency_code', '$x_bank_name', '$x_respuesta', '$x_fecha_transaccion', '$x_franchise', '$x_customer_doctype', '$x_customer_document', '$x_customer_name', '$x_customer_lastname', '$x_customer_email', '$x_customer_phone', '$x_customer_movil', '$x_customer_ind_pais', '$x_customer_country',  '$x_customer_city', '$x_customer_address', '$x_customer_ip', '$tipo_pago', '0')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	} 
	//Implementamos un método para insertar un pago de la rematricula
	public function actualizarPagoEpaycoSofi($x_id_factura){
		global $mbd;
		$sql = "UPDATE `sofi_pagos_epayco` SET `yeminus_ok` = '1' WHERE `x_id_factura`= :x_id_factura ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":x_id_factura", $x_id_factura);
		return $consulta->execute();
	}
	//Implementamos un método para insertar un pago de la rematricula
	public function insertarPagoEstudioCredito($x_id_factura, $id_persona, $periodo_pecuniario, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $id_estudiante){
		global $mbd;
		$sql = "INSERT INTO sofi_epayco_estudio(`x_id_factura`, `id_persona`, `periodo_pecuniario`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`, `id_estudiante`) VALUES ('$x_id_factura', '$id_persona', '$periodo_pecuniario', '$x_description', '$x_amount_base', '$x_currency_code', '$x_bank_name', '$x_respuesta', '$x_fecha_transaccion', '$x_franchise', '$x_customer_doctype', '$x_customer_document', '$x_customer_name', '$x_customer_lastname', '$x_customer_email', '$x_customer_phone', '$x_customer_movil', '$x_customer_ind_pais', '$x_customer_country',  '$x_customer_city', '$x_customer_address', '$x_customer_ip', '$id_estudiante')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para insertar un pago de la rematricula
	public function insertarPagoTicketCredito($x_id_factura, $id_persona, $id_ticket, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $id_estudiante){
		global $mbd;
		$sql = "INSERT INTO sofi_ticket_epayco(`x_id_factura`, `id_persona`, `id_ticket`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`, `id_estudiante`) VALUES ('$x_id_factura', '$id_persona', '$id_ticket', '$x_description', '$x_amount_base', '$x_currency_code', '$x_bank_name', '$x_respuesta', '$x_fecha_transaccion', '$x_franchise', '$x_customer_doctype', '$x_customer_document', '$x_customer_name', '$x_customer_lastname', '$x_customer_email', '$x_customer_phone', '$x_customer_movil', '$x_customer_ind_pais', '$x_customer_country',  '$x_customer_city', '$x_customer_address', '$x_customer_ip', '$id_estudiante')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
		//Implementar un método para listar las materias pagadas
	public function consultarCuotaMinima($consecutivo){
		global $mbd;
		$sql = "SELECT *, CAST((`valor_cuota` - `valor_pagado`) AS SIGNED) AS `valor_pagar` 
        FROM `sofi_financiamiento` 
        WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' 
        ORDER BY `sofi_financiamiento`.`numero_cuota` ASC
        LIMIT 1";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":consecutivo", $consecutivo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//muestra el historial de pagos  del financiamiento
	public function pagoTotalCuota($consecutivo){
		global $mbd;
		$sentencia = $mbd->prepare("SELECT *, CAST((SUM(`valor_cuota`) - SUM(`valor_pagado`)) AS SIGNED) AS `valor_total` 
        FROM `sofi_financiamiento` 
        WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' 
        ORDER BY `sofi_financiamiento`.`numero_cuota` ASC 
        LIMIT 1");
		$sentencia->bindParam(':consecutivo', $consecutivo);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	//pagar el total de la cuota
	public function pagarCuota($id_financiamiento){
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE `sofi_financiamiento`
                SET `valor_pagado` = `valor_cuota`, `estado` = 'Pagado' 
                WHERE `sofi_financiamiento`.`id_financiamiento` = :id_financiamiento");
		$sentencia->bindParam(':id_financiamiento', $id_financiamiento);
		return $sentencia->execute();
	}
	//muestra el historial de pagos  del financiamiento
	public function consultarCuotasNoPagadasTotales($consecutivo){
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' ORDER BY `sofi_financiamiento`.`numero_cuota` ASC");
		$sentencia->bindParam(':consecutivo', $consecutivo);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}
	//muestra la cuota especifica
	public function consultarCuotasNoPagadasAtrasadas($consecutivo)
	{
		global $mbd;
		$fecha_actual = date("y-m-d");
		$sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' AND `plazo_pago` <= :fecha_actual ");
		$sentencia->bindParam(':consecutivo',
			$consecutivo
		);
		$sentencia->bindParam(':fecha_actual',
			$fecha_actual
		);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}
	//muestra la cantidad de interes mora 
	public function TraerInteresMora($fecha_interes)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `sofi_interes_mora`  WHERE `fecha_mes` like '$fecha_interes%' LIMIT 1;");
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	//muestra la cuota especifica
	public function consultarCuota($id_financiamiento)
	{
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE id_financiamiento = :id_financiamiento");
		$sentencia->bindParam(':id_financiamiento', $id_financiamiento);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
	}
	//Paga el valor de mora que se haya agregado
	public function pagarMora($consecutivo, $numero_cuota, $fecha_pago, $valor_a_pagar)
	{
		global $mbd;
		$hoy = date("Y-m-d");
		$sentencia = $mbd->prepare("INSERT INTO `sofi_pagos_mora` VALUES(NULL, :consecutivo, :numero_cuota, :fecha_pagada, :fecha_pago, :valor_a_pagar)");
		$sentencia->bindParam(":consecutivo", $consecutivo);
		$sentencia->bindParam(":numero_cuota", $numero_cuota);
		$sentencia->bindParam(":fecha_pagada", $hoy);
		$sentencia->bindParam(":fecha_pago", $fecha_pago);
		$sentencia->bindParam(":valor_a_pagar", $valor_a_pagar);
		return $sentencia->execute();
	}
	//lista todos los financiados
	public function generarHistorial($consecutivo, $numero_cuota, $fecha_pago, $valor_a_pagar, $id_financiamiento){
		global $mbd;
		$hoy = date("Y-m-d");
		$sentencia = $mbd->prepare("INSERT INTO `sofi_historial_pagos`(`id_historial`, `consecutivo`, `id_financiamiento`, `numero_cuota`, `fecha_pagada`, `fecha_pago`, `valor_pagado`) VALUES(NULL, :consecutivo, :id_financiamiento, :numero_cuota, :fecha_pagada, :fecha_pago, :valor_a_pagar)");
		$sentencia->bindParam(":consecutivo", $consecutivo);
		$sentencia->bindParam(":id_financiamiento", $id_financiamiento);
		$sentencia->bindParam(":numero_cuota", $numero_cuota);
		$sentencia->bindParam(":fecha_pagada", $hoy);
		$sentencia->bindParam(":fecha_pago", $fecha_pago);
		$sentencia->bindParam(":valor_a_pagar", $valor_a_pagar);
		return $sentencia->execute();
	}

	//pagar el total de la cuota
	public function abonarCuota($id_financiamiento, $valor_pagado){
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE `sofi_financiamiento`
                SET `valor_pagado` = `valor_pagado` + $valor_pagado, `estado` = 'Abonado' 
                WHERE `sofi_financiamiento`.`id_financiamiento` = :id_financiamiento");
		$sentencia->bindParam(':id_financiamiento', $id_financiamiento);
		return $sentencia->execute();
	}

	// Función para traer los eventos
	public function getAtrasado($consecutivo)
	{
		//fecha actual
		$hoy = date("Y-m-d");
		$hoy = date("Y-m-d", strtotime($hoy . " -5 days"));
		//return $hoy;
		//sentencia para traer datos de los estudiantes
		$sql = "SELECT 
					`sofi_financiamiento`.`plazo_pago`, 
					`sofi_matricula`.`estado_ciafi`, 
					COUNT(*) AS `cant_cuotas`, 
					`sofi_financiamiento`.`id_matricula` 
				FROM 
					`sofi_financiamiento` 
				INNER JOIN `sofi_matricula` 
					ON `sofi_matricula`.`id` = `sofi_financiamiento`.`id_matricula` 
				INNER JOIN `sofi_persona` 
					ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento` 
				WHERE 
					`sofi_financiamiento`.`plazo_pago` <= :hoy
					AND (`sofi_financiamiento`.`estado` = 'A Pagar' OR `sofi_financiamiento`.`estado` = 'Abonado') 
					AND `sofi_persona`.`estado` != 'Anulado' 
					AND `sofi_matricula`.`id` = :consecutivo 
				GROUP BY 
					`sofi_financiamiento`.`id_matricula`, 
					`sofi_financiamiento`.`plazo_pago`, 
					`sofi_matricula`.`estado_ciafi` 
				ORDER BY 
					MAX(`sofi_financiamiento`.`numero_cuota`) DESC;";
		//variable de conexion global
		global $mbd;
		//preparamos el $sql
		$consulta = $mbd->prepare($sql);
		//agregamos parametros
		$consulta->bindParam(":hoy", $hoy);
		$consulta->bindParam(":consecutivo", $consecutivo);
		//ejecutamos la consulta
		$consulta->execute();
		//transformamos datos en array
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		//devolvemos al objeto una array con los respectivos datos
		return $resultado;
	}
	//cambia el estado de Ciafi
	public function cambiarEstadoCiafi($estado_ciafi, $consecutivo)
	{
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE `sofi_matricula`
                SET `estado_ciafi` = :estado_ciafi 
                WHERE `sofi_matricula`.`id` = :consecutivo");
		$sentencia->bindParam(':consecutivo', $consecutivo);
		$sentencia->bindParam(':estado_ciafi', $estado_ciafi);
		return $sentencia->execute();
	}
	//Implementar un método para traer los datos del estudiante
	public function datosEstudiante($id_estudiante){
		$sql="SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
		//Implementar un método para traer los datos de la materia
	public function datosMateria($id_materia){
		$sql="SELECT * FROM materias_ciafi WHERE id= :id_materia ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementamos un método para insertar las materias
	public function insertarmateria($id_estudiante,$nombre_materia,$jornada_e,$periodo,$semestre,$creditos,$programa,$ciclo,$fecha,$usuario,$grupo)
	{
		$tabla="materias".$ciclo;
		$sql="INSERT INTO $tabla (id_estudiante,nombre_materia,jornada_e,jornada,periodo,semestre,creditos,programa,fecha,usuario,grupo)
		VALUES ('$id_estudiante','$nombre_materia','$jornada_e','$jornada_e','$periodo','$semestre','$creditos','$programa','$fecha','$usuario','$grupo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
		//Implementamos un método para actualizar el periodo activo
	public function actualizarperiodoactivo($periodo_pecuniario,$id_estudiante)
	{
		$sql="UPDATE estudiantes SET periodo_activo= :periodo_pecuniario WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	
			//Implementar un método para listar los creditos matriculados
	public function creditosMatriculados($id_estudiante,$ciclo)
	{
		$tabla="materias".$ciclo;
		$sql="SELECT sum(creditos) as suma_creditos FROM $tabla WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa)
	{	
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
			//Implementamos un método para actualizar el semestre del estudiante
	public function actualizarsemestre($id_estudiante,$semestre_nuevo)
	{
		$sql="UPDATE estudiantes SET semestre_estudiante= :semestre_nuevo WHERE id_estudiante = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre_nuevo", $semestre_nuevo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}

	//Implementamos un método para actualizar el semestre del estudiante
	public function preaprobarCredito($id_persona){
		$sql= "UPDATE `sofi_persona` SET `estado`= 'Pre-Aprobado', `estudio_credito` = 1  WHERE id_persona = :id_persona";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el semestre del estudiante
	public function ActualizarTicket($id_persona, $id_ticket){
		$sql = "UPDATE `sofi_persona` SET `estado_ticket` = 1 WHERE `id_persona` = :id_persona;
				UPDATE `sofi_ticket_financion` SET `estado_ticket` = 1 WHERE `id_ticket` = :id_ticket;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->bindParam(":id_ticket", $id_ticket);
		return $consulta->execute();
	}

	//Implementamos un método para consultar el valor del semestre
	public function consultarValorSemestre($semestre, $id_programa_ac, $periodo_pecuniario){
		global $mbd;
		$sql = "SELECT `lppe`.`valor_pecuniario`, `lppro`.`aporte_social` FROM `lista_precio_programa` `lppro` INNER JOIN `lista_precio_pecuniario` `lppe` ON `lppe`.`id_programa` = `lppro`.`id_programa` WHERE `lppro`.`semestre` = :semestre AND `lppro`.`id_programa` = :id_programa_ac AND `lppro`.`periodo` = :periodo_pecuniario LIMIT 1;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	function guardarTicket($id_estudiante, $valor_total, $valor_ticket, $valor_financiacion, $tipo_pago, $fecha_limite, $ticket_semestre, $id_persona, $valor_descuento, $tiempo_pago)
	{
		global $mbd;
		$fecha_creacion = date("Y-m-d");
		$sql = "INSERT INTO `sofi_ticket_financion`(`id_ticket`, `id_estudiante`, `valor_total`, `valor_ticket`, `valor_financiacion`, `tipo_pago`, `fecha_limite`, `fecha_creacion`, `ticket_semestre`, `id_persona`, `valor_descuento`, `tiempo_pago`) VALUES (NULL,:id_estudiante, :valor_total, :valor_ticket, :valor_financiacion, :tipo_pago, :fecha_limite, :fecha_creacion, :ticket_semestre, :id_persona, :valor_descuento, :tiempo_pago);";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->bindParam(":valor_total", $valor_total);
		$consulta->bindParam(":valor_ticket", $valor_ticket);
		$consulta->bindParam(":valor_financiacion", $valor_financiacion);
		$consulta->bindParam(":tipo_pago", $tipo_pago);
		$consulta->bindParam(":fecha_limite", $fecha_limite);
		$consulta->bindParam(":fecha_creacion", $fecha_creacion);
		$consulta->bindParam(":ticket_semestre", $ticket_semestre);
		$consulta->bindParam(":valor_descuento", $valor_descuento);
		$consulta->bindParam(":tiempo_pago", $tiempo_pago);
		return $consulta->execute();
	}
	
}

?>