<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class VerShopping
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


    public function datos_estudiante($id_credencial)
	{
		$sql="SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
	}



	
	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM shopping";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	
		//Implementamos un método para desactivar programa
	public function negar($id_shopping)
	{
		$sql="UPDATE shopping SET shopping_participar='1' WHERE id_shopping= :id_shopping";
		//return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_shopping", $id_shopping);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	
		//Implementamos un método para activar programa
	public function validar($id_shopping)
	{
		$sql="UPDATE shopping SET shopping_participar='3' WHERE id_shopping= :id_shopping";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_shopping", $id_shopping);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

}

?>