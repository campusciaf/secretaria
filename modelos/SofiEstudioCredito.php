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
    public function listarPrecioIngles(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `ingles_precios`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro;
    }
	//Implementar un método para listar las escuelas
	public function selectPrograma(){
		$sql = "SELECT * FROM `programa_ac`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function periodoactual(){
		global $mbd;
		$sql = "SELECT * FROM `periodo_actual`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function traerProgramasEstudiante($identificacion){
		global $mbd;
		$sql = "SELECT `e`.`id_programa_ac` AS `id_programa`, `e`.`fo_programa` AS `nombre` FROM `estudiantes` `e` INNER JOIN `credencial_estudiante` `ce` ON `ce`.`id_credencial` = `e`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :identificacion";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":identificacion", $identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function	traerCedulaEstudiante($id_persona){
		global $mbd;
		$sql = "SELECT `sofi_persona`.`numero_documento`, `sofi_persona`.`periodo`, `programa_ac`.`nombre`, `programa_ac`.`centro_costo_yeminus` FROM `sofi_persona` INNER JOIN `programa_ac` ON `programa_ac`.`id_programa` = `sofi_persona`.`id_programa` WHERE `id_persona` = :id_persona ORDER BY `id_persona` DESC;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function traerIdEstudiante($identificacion, $id_programa){
		global $mbd;
		$sql = "SELECT `e`.`id_estudiante` FROM `estudiantes` `e` INNER JOIN `credencial_estudiante` `ce` ON `ce`.`id_credencial` = `e`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :identificacion AND `e`.`id_programa_ac` = :id_programa;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":identificacion", $identificacion);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Función para listar los pagos
    public function listarPagosEstudio($id_persona){
		global $mbd;
        $sql = "SELECT * FROM `sofi_epayco_estudio` WHERE `id_persona` = :id_persona AND `x_respuesta` = 'Aceptada'";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->execute();
		$resultado = $consulta->fetch();
		return $resultado;
	}
	//Función para listar los pagos
    public function listarTickets($id_persona){
		global $mbd;
        $sql = "SELECT * FROM `sofi_ticket_financion` WHERE `id_persona` = :id_persona AND `estado_ticket` = 0";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Función para listar los pagos
    public function listarTicketActivo($id_persona){
		global $mbd;
        $sql = "SELECT * FROM `sofi_ticket_financion` WHERE `id_persona` = :id_persona AND `estado_ticket` = 0";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->execute();
		$resultado = $consulta->fetch();
		return $resultado;
	}
	//Función para listar los pagos
	public function eliminarTicket($id_ticket){
		global $mbd;
		$sql = "DELETE FROM `sofi_ticket_financion` WHERE `id_ticket` = :id_ticket";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ticket", $id_ticket);
		return $consulta->execute();
	}
	//Función para listar los pagos
    public function listarSolicitudesPendientes($periodo){
		global $mbd;
        $sql = "SELECT * FROM `sofi_persona` WHERE `periodo` = :periodo AND (`estado` = 'Pendiente' OR `estado` = 'Pre-Aprobado' )  ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa){
		global $mbd;
		$sql = "SELECT * FROM `programa_ac` WHERE `id_programa` = :id_programa";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Función para listar los pagos
    public function sofiDatosEstudiante($id_persona){
        $sql = "SELECT * FROM `sofi_persona` WHERE `id_persona` = :id_persona";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->execute();
		$resultado = $consulta->fetch();
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function campusDatosEstudiante($id_estudiante){
		global $mbd;
		$sql = "SELECT * FROM `estudiantes` WHERE `id_estudiante` = :id_estudiante ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch();
		return $resultado;
	}
	//Implementar un método para mostrar los precios del programa por semestre
	public function tablaprecios($id_programa, $periodo_pecuniario, $semestre){
		global $mbd;
		$sql = "SELECT * FROM `lista_precio_programa` WHERE `id_programa` = :id_programa AND `periodo` = :periodo_pecuniario AND `semestre` = :semestre";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	function guardarTicket($id_estudiante, $valor_total, $valor_ticket, $valor_financiacion, $tipo_pago, $fecha_limite, $ticket_semestre, $id_persona, $valor_descuento, $tiempo_pago){
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
	//Implementar un método para listar los registros
	public function AprobarEstudio($id_persona, $periodo_pecuniario, $id_estudiante){
		global $mbd;
		$fecha_hoy = date("Y-m-d H:i:s");
		$sql = "INSERT INTO `sofi_epayco_estudio` (`id_pagos`, `x_id_factura`, `id_persona`, `periodo_pecuniario`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`, `id_estudiante`) VALUES (NULL, '0000', :id_persona, :periodo_pecuniario, 'Estudio de credito periodo 20222', '45000', 'COP', 'NA', 'Aceptada', :fecha_hoy, 'N/A', 'N/A', 'N/A', 'NA', 'NA', 'N/A', '0000000', 'N/A', '', 'CO', '', 'NA', '0.0.00.', :id_estudiante)";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":fecha_hoy", $fecha_hoy);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementar un método para listar los registros
	public function guardarTicketAprobado($id_estudiante, $valor_ticket, $programa_matriculado, $identificacion_estudiante, $tiempo_pago, $periodo_pecuniario, $matricula, $semestre, $realiza_proceso){
		global $mbd;
		$fecha_hoy = date("Y-m-d H:i:s");
		$x_description = "Ticket Financiacion $programa_matriculado"; 
		$sql = "INSERT INTO `pagos_rematricula`(`id_pagos`, `x_id_factura`, `identificacion_estudiante`, `id_estudiante`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`, `tiempo_pago`, `periodo_pecuniario`, `matricula`, `semestre`, `realiza_proceso`) VALUES (NULL, :x_id_factura, :identificacion_estudiante, :id_estudiante, :x_description, :x_amount_base, 'COP', 'NA', 'Aceptada', :fecha_hoy, 'N/A', 'N/A', 'N/A', 'NA', 'NA', 'N/A', '0000000', 'N/A', 'N/A', 'CO', 'N/A', 'NA', '0.0.00.0', :tiempo_pago, :periodo_pecuniario, :matricula, :semestre, :realiza_proceso )";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":x_id_factura", $id_estudiante);
		$consulta->bindParam(":identificacion_estudiante", $identificacion_estudiante);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":x_description", $x_description );
		$consulta->bindParam(":x_amount_base", $valor_ticket);
		$consulta->bindParam(":fecha_hoy", $fecha_hoy);
		$consulta->bindParam(":tiempo_pago", $tiempo_pago);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":matricula", $matricula);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":realiza_proceso", $realiza_proceso);
		if($consulta->execute()){
			return $mbd->lastInsertId();
		}else{
			return false;
		}
	}
	//actualiza la columna que indicia que que el recibo se creo sobre esa financiacion
	public function ActualizarIdPagoTicket($id_pagos, $id_ticket)
	{
		$sql = "UPDATE `sofi_ticket_financiacion` SET `id_pagos` = :id_pagos WHERE `id_ticket` = :id_ticket";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pagos", $id_pagos);
		$consulta->bindParam(":id_ticket", $id_ticket);
		return $consulta->execute();
	}
	//Implementar un método para listar los registros
	public function detalleTransaccionTicket($id_pagos){
		global $mbd;
		$sql = "SELECT * FROM `pagos_rematricula` WHERE `id_pagos` = :id_pagos AND `x_respuesta` = 'Aceptada'";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pagos", $id_pagos);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function traerIdTicket($id_persona){
		global $mbd;
		$sql = "SELECT `id_ticket` FROM `sofi_ticket_financion` WHERE `id_persona` = :id_persona";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
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
	#Actualizar el estudio de credito 
	function cambiarEstadoEstudio($id_persona){
		global $mbd;
		$sql = "UPDATE `sofi_persona` SET `estudio_credito` = 1 WHERE `id_persona` = :id_persona ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		return $consulta->execute();
	}
	//Actulizar Programa en caso de no pagr en linea
	function cambiarProgramaEstudio($id_persona, $id_programa){
		global $mbd;
		$sql = "UPDATE `sofi_persona` SET `id_programa` = :id_programa, `estado` = 'Pre-Aprobado' WHERE `id_persona` = :id_persona ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();
	}
	//listar pago detalle
    public function listarPagosDetalle($id_pago){  
		$sql= "SELECT * FROM `sofi_epayco_estudio` INNER JOIN `sofi_persona` ON `sofi_epayco_estudio`.`id_persona` = `sofi_persona`.`id_persona` WHERE `id_pagos` = :id_pago ";  
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pago", $id_pago);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	//taer semestre actual
	public function traersemestre($id_estudiante){  
		$sql="SELECT `id_estudiante`, `semestre_estudiante` FROM `estudiantes` WHERE `id_estudiante` = :id_estudiante";  
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar funcion para tarer el valor pecuniario
	public function listarPrecioPecuniario($id_programa_ac, $periodo){
		$sql = "SELECT `valor_pecuniario` FROM `lista_precio_pecuniario` WHERE `id_programa` = :id_programa_ac AND `periodo` = '$periodo';";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		$consulta = null;
		return isset($resultado["valor_pecuniario"]) ? $resultado["valor_pecuniario"] : 0;
	}
	//Implementar funcion para Guardar el numero de factura generado en yeminus
	public function updateFacturaYeminus($id_persona, $factura_yeminus){
		$sql = "UPDATE `sofi_persona` SET `factura_yeminus` = :factura_yeminus WHERE `sofi_persona`.`id_persona` = :id_persona;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":factura_yeminus", $factura_yeminus);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		$consulta = null;
		return isset($resultado["valor_pecuniario"]) ? $resultado["valor_pecuniario"] : 0;
	}
	//Implementar funcion para tarer el valor pecuniario
	public function mostrarTicket($id_ticket){
		$sql = "SELECT * FROM `sofi_ticket_financion` WHERE `id_ticket` = :id_ticket";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ticket", $id_ticket);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		$consulta = null;
		return $resultado;
	}
	function editarTicket($id_ticket, $valor_total, $valor_ticket, $valor_financiacion, $tipo_pago, $fecha_limite, $valor_descuento, $tiempo_pago){
		global $mbd;
		$sql = "UPDATE `sofi_ticket_financion` SET `valor_total` = :valor_total, `valor_ticket` = :valor_ticket, `valor_financiacion` = :valor_financiacion, `tipo_pago` = :tipo_pago, `fecha_limite` = :fecha_limite, `valor_descuento` = :valor_descuento, `tiempo_pago` = :tiempo_pago WHERE `id_ticket` = :id_ticket;";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ticket", $id_ticket);
		$consulta->bindParam(":valor_total", $valor_total);
		$consulta->bindParam(":valor_ticket", $valor_ticket);
		$consulta->bindParam(":valor_financiacion", $valor_financiacion);
		$consulta->bindParam(":tipo_pago", $tipo_pago);
		$consulta->bindParam(":fecha_limite", $fecha_limite);;
		$consulta->bindParam(":valor_descuento", $valor_descuento);
		$consulta->bindParam(":tiempo_pago", $tiempo_pago);
		return $consulta->execute();
	}
	//actualiza la columna que indicia que se genero factura o recibo en yeminus
	public function ActualizarPagoRematricula($id_pagos){
		$sql = "UPDATE `pagos_rematricula` SET `yeminus_ok` = '1' WHERE `id_pagos` = :id_pagos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pagos", $id_pagos);
		return $consulta->execute();
	}
	public function verificarScoreDatacredito($numero_documento) {
		$sql = "SELECT `numero_documento`, COALESCE(`score_value`, 0) AS `score_value` FROM `sofi_datacredito_score` WHERE `numero_documento` = :numero_documento;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":numero_documento", $numero_documento);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		// Verifica si hay resultados antes de acceder al arreglo
		if ($registros === false) {
			return 0; // Retorna un valor predeterminado si no hay registros
		}
		return $registros["score_value"];
	}
	// Función para realizar la solicitud cURL
	public function realizarPeticionCurl($url, $method, $headers, $data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		$result = curl_exec($ch);
		//print_r($result);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $result;
	}
	public function generarScoreDatacredito($id_persona, $numero_documento, $primer_apellido, $score_value){
		$sql = "INSERT INTO `sofi_datacredito_score` (`id_persona`, `numero_documento`, `primer_apellido`, `score_value`)
		VALUES (:id_persona, :numero_documento, :primer_apellido, :score_value)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->bindParam(":numero_documento", $numero_documento);
		$consulta->bindParam(":primer_apellido", $primer_apellido);
		$consulta->bindParam(":score_value", $score_value);
		return $consulta->execute();
	}	
}
