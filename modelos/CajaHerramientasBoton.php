<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class CajaHerramientasBoton
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	
	//Muestra el total de acciones por proyecto 
	public function mostrartotaldocentes(){	
		global $mbd;
		$sql="SELECT * FROM `docente`";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para mostrar los datos del docente
	public function mostrar_docente($id_usuario){

		$sql = "SELECT * FROM `docente` WHERE `id_usuario` = :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para editar el permiso del docente
	public function editardocente($id_usuario, $permiso_software){
		$sql="UPDATE `docente` SET `id_usuario` = '$id_usuario', `permiso_software` = '$permiso_software' WHERE `id_usuario` = $id_usuario";

		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

}

?>