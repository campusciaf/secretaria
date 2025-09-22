<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
//session_start();

Class Shopping
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para genrar varificar si ya tiene una participació
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


	//Implementamos un método para genrar varificar si ya tiene una participació
	public function verificar($id_credencial)
	{
		$sql="SELECT * FROM shopping WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
	}

		//Implementamos un método para genrar registro de que dio clic en participar
	public function participar($id_credencial,$fecha,$hora)
	{
		$sql="INSERT INTO shopping (id_credencial,fecha,hora) VALUES ('$id_credencial','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para desactivar categorías
	public function editar($id_credencial,$shopping_nombre,$shopping_descripcion)
	{
		$sql="UPDATE shopping SET shopping_nombre= :shopping_nombre, shopping_descripcion= :shopping_descripcion WHERE id_credencial= :id_credencial and shopping_participar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":shopping_nombre", $shopping_nombre);
		$consulta->bindParam(":shopping_descripcion", $shopping_descripcion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	//Implementamos un método para desactivar categorías
	public function ActualizarImagen($id_credencial, $nombre_archivo){
		$sql = "UPDATE `shopping` SET shopping_img = :nombre_archivo WHERE `id_credencial` = :id_credencial and shopping_participar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":nombre_archivo", $nombre_archivo);
		return $consulta->execute();
	}
	//Implementamos un método para desactivar categorías
	public function EliminarImagen($id_credencial){
		$sql = "UPDATE `shopping` SET shopping_img = '' WHERE `id_credencial` = :id_credencial and shopping_participar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		return $consulta->execute();
	}

	//Implementamos un método para desactivar categorías
	public function editarredes($id_credencial,$campo,$valor)
	{
		$sql="UPDATE shopping SET $campo= :valor WHERE id_credencial= :id_credencial and shopping_participar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":valor", $valor);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

			//Implementamos un método para enviar la propueta a revisión
	public function enviar($id_credencial){
		$sql = "UPDATE `shopping` SET shopping_participar='2' WHERE `id_credencial` = :id_credencial and shopping_participar='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		return $consulta->execute();
	}

	//Implementamos un método para autorizar publicar los emprendimientos en las redes sociales de CIAF
	public function autorizo($id_credencial){
		$sql = "UPDATE `shopping` SET shopping_autorizo='0' WHERE `id_credencial` = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		return $consulta->execute();
	}


}

?>
