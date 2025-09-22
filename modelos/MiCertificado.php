<?php 
require "../config/Conexion.php";
//session_start();

Class MiCertificado
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los certificados expedidos con diploma
	public function listar($id_credencial)
	{
		$sql="SELECT * FROM certificados_expedidos WHERE id_credencial= :id_credencial and id_tipo_certificado='9'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    	//Implementar un método para listar el nombre del programa
	public function programa($id_programa)
	{
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}




}

?>
