<?php
require "../config/Conexion.php";

class PagosRematriculaAgregador{
	//Implementamos nuestro constructor
	public function __construct(){}

	public function periodoactual(){
    	$sql = "SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	//Implementamos un método para insertar un pago de la rematricula
	public function insertarpagorematricula($x_id_factura, $identificacion_estudiante, $id_estudiante, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $tiempo_pago, $periodo_pecuniario, $matricula, $semestre, $realiza_proceso){
		global $mbd;
		$sql = "INSERT INTO `pagos_rematricula`(`x_id_factura`, `identificacion_estudiante`, `id_estudiante`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`, `tiempo_pago`, `periodo_pecuniario`, `matricula`, `semestre`, `realiza_proceso`) VALUES('$x_id_factura', '$identificacion_estudiante', '$id_estudiante', '$x_description', '$x_amount_base', '$x_currency_code', '$x_bank_name', '$x_respuesta', '$x_fecha_transaccion', '$x_franchise', '$x_customer_doctype', '$x_customer_document', '$x_customer_name', '$x_customer_lastname', '$x_customer_email', '$x_customer_phone', '$x_customer_movil', '$x_customer_ind_pais', '$x_customer_country',  '$x_customer_city', '$x_customer_address', '$x_customer_ip','$tiempo_pago','$periodo_pecuniario','$matricula', '$semestre', '$realiza_proceso')";
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para traer los datos del estudiante
	public function datosEstudiante($id_estudiante)
	{
		$sql="SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	
}

?>