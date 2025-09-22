<?php
require "../config/Conexion.php";
class PagosAgregadorEC{
	//Implementamos nuestro constructor
	public function __construct() {}
	//traemos el periodo actual de la base de datos
	public function periodoactual(){
		$sql = "SELECT * FROM `periodo_actual`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar un pago de la rematricula
	public function insertarPagoEC($x_id_factura, $id_curso, $identificacion, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip){
		global $mbd;
		$sql = "INSERT INTO pagos_epayco_educacion_continuada(`x_id_factura`, `id_curso`, `identificacion`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`) VALUES ('$x_id_factura', '$id_curso', '$identificacion', '$x_description', '$x_amount_base', '$x_currency_code', '$x_bank_name', '$x_respuesta', '$x_fecha_transaccion', '$x_franchise', '$x_customer_doctype', '$x_customer_document', '$x_customer_name', '$x_customer_lastname', '$x_customer_email', '$x_customer_phone', '$x_customer_movil', '$x_customer_ind_pais', '$x_customer_country',  '$x_customer_city', '$x_customer_address', '$x_customer_ip')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function traeridpago($id_curso, $usuario_identificacion, $x_respuesta){
		$sql = "SELECT * FROM pagos_epayco_educacion_continuada WHERE id_curso=:id_curso and identificacion= :usuario_identificacion and x_respuesta= :x_respuesta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_curso', $id_curso);
		$consulta->bindParam(':usuario_identificacion', $usuario_identificacion);
		$consulta->bindParam(':x_respuesta', $x_respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function updateInscritoEC($id_curso, $usuario_identificacion, $idpago){
		$sql = "UPDATE educacion_continuada_interesados SET estado_interesado='matriculado',matricula='0', ref_pago= :idpago WHERE id_curso= :id_curso and identificacion= :usuario_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_curso", $id_curso);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->bindParam(":idpago", $idpago);
		return $consulta->execute();
	}
	//Implementamos un método para insertar un seguimiento
	public function insertarInscritoEC($id_curso, $usuario_identificacion, $fecha, $hora, $periodo_actual){
		$sql = "INSERT INTO educacion_continuada_inscritos(`id_curso`, `identificacion`, `fecha_registro`, `hora_registro`, `periodo_actual`) VALUES('$id_curso','$usuario_identificacion','$fecha','$hora','$periodo_actual')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//muestra el historial de pagos  del financiamiento
	public function pagoTotalCuota($consecutivo){
		global $mbd;
		$sentencia = $mbd->prepare("SELECT *, CAST((SUM(`valor_cuota`) - SUM(`valor_pagado`)) AS INT) AS `valor_total` 
        FROM `sofi_financiamiento` 
        WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' 
        ORDER BY `sofi_financiamiento`.`fecha_pago` ASC 
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
	public function consultarCuotasNoPagadas($consecutivo){
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo AND `estado` <> 'Pagado' ORDER BY `sofi_financiamiento`.`fecha_pago` ASC");
		$sentencia->bindParam(':consecutivo', $consecutivo);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}
	//pagar el total de la cuota
	public function abonarCuota($id_financiamiento, $valor_pagado){
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE `sofi_financiamiento`
                SET `valor_pagado` = `valor_pagado` + :valor_pagado, `estado` = 'Abonado' 
                WHERE `sofi_financiamiento`.`id_financiamiento` = :id_financiamiento");
		$sentencia->bindParam(':id_financiamiento', $id_financiamiento);
		$sentencia->bindParam(':valor_pagado', $valor_pagado);
		return $sentencia->execute();
	}
	//Implementar un método para traer los datos del estudiante
	public function datosEstudiante($id_estudiante){
		$sql = "SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer los datos de la materia
	public function datosMateria($id_materia){
		$sql = "SELECT * FROM materias_ciafi WHERE id= :id_materia ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar las materias
	public function insertarmateria($id_estudiante, $nombre_materia, $jornada_e, $periodo, $semestre, $creditos, $programa, $ciclo, $fecha, $usuario, $grupo){
		$tabla = "materias" . $ciclo;
		$sql = "INSERT INTO $tabla (id_estudiante,nombre_materia,jornada_e,jornada,periodo,semestre,creditos,programa,fecha,usuario,grupo)
		VALUES ('$id_estudiante','$nombre_materia','$jornada_e','$jornada_e','$periodo','$semestre','$creditos','$programa','$fecha','$usuario','$grupo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el periodo activo
	public function actualizarperiodoactivo($periodo_pecuniario, $id_estudiante){
		$sql = "UPDATE estudiantes SET periodo_activo= :periodo_pecuniario WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementar un método para listar los creditos matriculados
	public function creditosMatriculados($id_estudiante, $ciclo){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT sum(creditos) as suma_creditos FROM $tabla WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa){
		$sql = "SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para actualizar el semestre del estudiante
	public function actualizarsemestre($id_estudiante, $semestre_nuevo){
		$sql = "UPDATE estudiantes SET semestre_estudiante= :semestre_nuevo WHERE id_estudiante = :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre_nuevo", $semestre_nuevo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el semestre del estudiante
	public function preaprobarCredito($id_persona){
		$sql = "UPDATE `sofi_persona` SET `estado`= 'Pre-Aprobado' WHERE id_persona = :id_persona";
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
}