<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class WebFuncionarios
{
	//Implementamos nuestro constructor
	public function __construct() {

	}

	public function listarFuncionariosActivos(){	
		global $mbd;
		$sql="SELECT * FROM `usuario` WHERE `usuario`.`usuario_condicion` = 1";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function listarUsuariosCargo($id_web_cargos){	
		global $mbd;
		$sql="SELECT `web_cargos_usuarios`.`id_cargo_web_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_nombre_2`, `usuario`.`usuario_apellido`, `usuario`.`usuario_apellido_2`, `usuario`.`usuario_login` FROM `usuario` INNER JOIN `web_cargos_usuarios` ON `usuario`.`id_usuario` = `web_cargos_usuarios`.`id_usuario` WHERE `usuario`.`usuario_condicion` = 1 AND `web_cargos_usuarios`.`id_web_cargos` = :id_web_cargos";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_web_cargos", $id_web_cargos);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function removerCargo($id_cargo_web_usuario)
	{
		$sql="DELETE FROM web_cargos_usuarios WHERE id_cargo_web_usuario= :id_cargo_web_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_cargo_web_usuario", $id_cargo_web_usuario);
		$consulta->execute();
	
	}
	
	public function listar_cargos_select(){	
		global $mbd;
		$sql="SELECT * FROM `web_cargos` ORDER BY `web_cargos`.`id_web_cargos` ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


		//Implementar un método para mostrar el id del aliados
	public function mostrar_funcionarios($id_usuario){

		$sql = "SELECT * FROM `usuario` WHERE `id_usuario` = :id_usuario";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para editar los aliados
	public function editar_cargo_funcionario($selec_funcionarios, $id_web_cargos){
		$sql="INSERT INTO `web_cargos_usuarios` (`id_cargo_web_usuario`, `id_usuario`, `id_web_cargos`) VALUES (NULL, :selec_funcionarios, :id_web_cargos);";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":selec_funcionarios", $selec_funcionarios);
		$consulta->bindParam(":id_web_cargos", $id_web_cargos);
		$consulta->execute();
		return $consulta;	
	}

	
}

?>