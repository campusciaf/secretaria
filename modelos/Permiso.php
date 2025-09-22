<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Permiso{
	//Implementamos nuestro constructor
	public function __construct() {}
	public function insertar($permiso_nombre, $orden, $menu, $permiso_nombre_original, $icono){
		$sql = "INSERT INTO permiso (permiso_nombre,orden,menu,permiso_nombre_original,icono)
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
	public function mostrar($id_permiso){
		$sql = "SELECT * FROM permiso WHERE id_permiso= :id_permiso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_permiso", $id_permiso);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listar(){
		$sql = "SELECT * FROM permiso";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listarPermisos($menu){
		$sql = "SELECT * FROM permiso WHERE menu= :menu";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":menu", $menu);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listarSubmenu($orden){
		$sql = "SELECT * FROM permiso WHERE menu= :orden";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":orden", $orden);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarSubmenuUltimoRegistro($orden){
		$sql = "SELECT * FROM permiso WHERE menu= :orden ORDER BY `id_permiso` DESC LIMIT 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":orden", $orden);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Implementamos un método para editar un proyecto
	public function listarSubmenuUltimoRegistroEditar($id_permiso, $permiso_nombre, $permiso_nombre_original, $icono){
		$sql = "UPDATE `permiso` SET `permiso_nombre` = :permiso_nombre , `permiso_nombre_original` = :permiso_nombre_original ,`icono` = :icono WHERE `id_permiso` = :id_permiso";
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
	public function Mostrar_Funcionarios_Permiso(){
		$sql = "SELECT * FROM `usuario` WHERE `usuario`.`usuario_condicion` = 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function InsertarFuncionario($id_usuario, $id_permiso){
		$sql = "INSERT INTO `usuario_permiso`(`id_usuario`, `id_permiso`) VALUES('$id_usuario', '$id_permiso')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function Desactivar_Permiso($id_permiso, $id_usuario){
		$sql = "DELETE FROM usuario_permiso WHERE id_permiso= :id_permiso AND id_usuario= :id_usuario ";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_permiso", $id_permiso);
		$consulta->bindParam(":id_usuario", $id_usuario);
		return $consulta->execute();
	}
	public function InsertarFuncionarioMenu($id_usuario, $id_permiso){
		$sql = "INSERT INTO `usuario_permiso`(`id_usuario`, `id_permiso`) VALUES('$id_usuario', '$id_permiso')";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function Desactivar_PermisoMenu($id_permiso, $id_usuario){
		$sql = "DELETE FROM usuario_permiso WHERE id_permiso= :id_permiso AND id_usuario= :id_usuario ";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_permiso", $id_permiso);
		$consulta->bindParam(":id_usuario", $id_usuario);
		return $consulta->execute();
	}
	public function TraerPermisoFuncionarios($id_permiso){
		$sql = "SELECT id_usuario FROM usuario_permiso WHERE id_permiso= :id_permiso";
		//echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_permiso", $id_permiso);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function TraerPermisoFuncionariosMenu($id_permiso){
		$sql = "SELECT id_usuario FROM usuario_permiso WHERE id_permiso = :id_permiso";
		//echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_permiso", $id_permiso);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
}