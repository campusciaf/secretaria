<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
//session_start();

Class PagoGeneral
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function listarConceptos(){
		$anio = date("Y");
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `conceptos_pago` WHERE `conceptos_pago_anio` = :anio");
		$sentencia->bindParam(":anio", $anio);
		$sentencia->execute();
		return $sentencia->fetchAll(PDO::FETCH_ASSOC);
	}
	public function gestionPago($id_conceptos_pago){
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `conceptos_pago` WHERE `id_conceptos_pago` = :id_conceptos_pago");
		$sentencia->bindParam(":id_conceptos_pago", $id_conceptos_pago);
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
	}

	public function cifrar($id, $claveSecreta, $metodoCifrado){
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($metodoCifrado));
		$idCifrado = openssl_encrypt($id, $metodoCifrado, $claveSecreta, 0, $iv);
		return base64_encode($iv . $idCifrado);
	}

	public function descifrar($idCifrado, $claveSecreta, $metodoCifrado){
		$idCifrado = base64_decode($idCifrado);
		$ivTamano = openssl_cipher_iv_length($metodoCifrado);
		$iv = substr($idCifrado, 0, $ivTamano);
		$idCifrado = substr($idCifrado, $ivTamano);
		return openssl_decrypt($idCifrado, $metodoCifrado, $claveSecreta, 0, $iv);
	}

}

?>
