<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Widgets
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function insertar($permiso_nombre,$orden,$menu,$permiso_nombre_original,$icono)
	{
		$sql="INSERT INTO permiso (permiso_nombre,orden,menu,permiso_nombre_original,icono)
		VALUES ('$permiso_nombre','$orden','$menu','$permiso_nombre_original','$icono')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


	public function mostrarPermisos($id_permiso){
		global $mbd;
		$sql_mostrar = "SELECT * FROM `permiso` WHERE `id_permiso` = :id_permiso";
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->bindParam(":id_permiso", $id_permiso);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetch(PDO::FETCH_ASSOC);
		return $resultado_mostrar;
	}




	
	
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_permiso)
	{
		$sql="SELECT * FROM permiso WHERE id_permiso= :id_permiso";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_permiso", $id_permiso);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM permiso";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los registros
	public function listarPermisos($menu)
	{
		$sql="SELECT * FROM permiso WHERE menu= :menu";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":menu", $menu);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para listar los registros
	public function listarSubmenu($orden)
	{
		$sql="SELECT * FROM permiso WHERE menu= :orden";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":orden", $orden);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function listarSubmenuUltimoRegistro($orden)
	{
		$sql="SELECT * FROM permiso WHERE menu= :orden ORDER BY `id_permiso` DESC LIMIT 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":orden", $orden);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	// Implementamos un método para editar un proyecto
	public function listarSubmenuUltimoRegistroEditar($id_permiso,$permiso_nombre,$permiso_nombre_original,$icono){
		$sql="UPDATE `permiso` SET `permiso_nombre` = :permiso_nombre , `permiso_nombre_original` = :permiso_nombre_original ,`icono` = :icono WHERE `id_permiso` = :id_permiso";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_permiso", $id_permiso);
		$consulta->bindParam(":permiso_nombre", $permiso_nombre);
		$consulta->bindParam(":permiso_nombre_original", $permiso_nombre_original);
		$consulta->bindParam(":icono", $icono);
		$consulta->execute();
		return $consulta;	
	}


}

?>