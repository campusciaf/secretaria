<?php
require "../config/Conexion.php";
class PagosAgregador{
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
	public function insertarpagorematricula($x_id_factura, $identificacion_estudiante, $id_estudiante, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip, $tiempo_pago, $periodo_pecuniario, $tipo_pago, $semestre_matricular, $realiza_proceso){
		$sql = "INSERT INTO `pagos_rematricula`(`x_id_factura`, `identificacion_estudiante`, `id_estudiante`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`, `tiempo_pago`, `periodo_pecuniario`, `matricula`, `semestre`, `realiza_proceso`) VALUES ('$x_id_factura', '$identificacion_estudiante', '$id_estudiante', '$x_description', '$x_amount_base', '$x_currency_code', '$x_bank_name', '$x_respuesta', '$x_fecha_transaccion', '$x_franchise', '$x_customer_doctype', '$x_customer_document', '$x_customer_name', '$x_customer_lastname', '$x_customer_email', '$x_customer_phone', '$x_customer_movil', '$x_customer_ind_pais', '$x_customer_country',  '$x_customer_city', '$x_customer_address', '$x_customer_ip','$tiempo_pago','$periodo_pecuniario', '$tipo_pago', '$semestre_matricular', '$realiza_proceso')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para listar las materias pagadas
	public function seleccionarMateriasPagas($id_estudiante, $ciclo){
		$tabla = "rematricula" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE `id_estudiante` = $id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
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
	public function insertarmateria($id_estudiante, $nombre_materia, $jornada_e, $periodo, $semestre, $creditos, $programa, $ciclo, $fecha, $usuario, $grupo)
	{
		$tabla = "materias" . $ciclo;
		$sql = "INSERT INTO $tabla (id_estudiante,nombre_materia,jornada_e,jornada,periodo,semestre,creditos,programa,fecha,usuario,grupo)
		VALUES ('$id_estudiante','$nombre_materia','$jornada_e','$jornada_e','$periodo','$semestre','$creditos','$programa','$fecha','$usuario','$grupo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para actualizar el periodo activo
	public function actualizarperiodoactivo($periodo_pecuniario, $id_estudiante)
	{
		$sql = "UPDATE estudiantes SET periodo_activo= :periodo_pecuniario WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}

	//Implementar un método para listar los creditos matriculados
	public function creditosMatriculados($id_estudiante, $ciclo)
	{
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
	public function datosPrograma($id_programa)
	{
		$sql = "SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para actualizar el semestre del estudiante
	public function actualizarsemestre($id_estudiante, $semestre_nuevo)
	{
		$sql = "UPDATE estudiantes SET semestre_estudiante= :semestre_nuevo WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre_nuevo", $semestre_nuevo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
}
