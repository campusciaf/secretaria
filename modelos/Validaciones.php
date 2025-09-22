<?php
session_start(); 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";



Class Validaciones
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}



	//Implementamos un método para editar registros
	public function editar($id_meta,$id_compromiso,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo)
	{
		$sql="UPDATE meta SET id_compromiso='$id_compromiso',id_eje='$id_eje', meta_nombre='$meta_nombre', meta_fecha='$meta_fecha', meta_val_admin='$meta_val_admin', meta_val_usuario='$meta_val_usuario', meta_valida='$meta_valida', meta_periodo='$meta_periodo' WHERE id_meta='$id_meta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	
	
	//Implementar un método para listar los micompromisos
	public function listarValidaciones()
	{	
		$sql="SELECT * FROM meta WHERE meta_valida='".$_SESSION['usuario_cargo']."' and meta_val_usuario='1' ORDER BY meta_fecha ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_compromiso", $id_compromiso);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los micompromisos
	public function listarFuente($id_meta)
	{	
		$sql="SELECT * FROM meta_fuente WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para listar los micompromisos
	public function buscarUsuario($id_compromiso)
	{	
		$sql="SELECT * FROM compromiso WHERE id_compromiso = :id_compromiso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_compromiso", $id_compromiso);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	
	}

	//Implementar un método para listar los micompromisos
	public function datosUsuario($id_usuario)
	{	
		$sql="SELECT * FROM usuario WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para validar meta por usuario 
	public function validarMeta($id_meta,$fecha)
	{
		$sql="UPDATE meta SET meta_val_admin='1',fecha_val_admin='".$fecha."' WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		return $consulta->execute();

		
	}
	
		//Implementar un método para no validar meta por usuario 
	public function noValidarMeta($id_meta)
	{
		$sql="UPDATE meta SET meta_val_usuario='0',fecha_val_usuario='' WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		return $consulta->execute();

		
	}
	
	public function fechaesp($date) {
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}
	
	//Implementar un método para ver los datos del usuario logueado
	public function datosUsuarioCorreo()
	{	
		$id_usuario=$_SESSION['id_usuario'];
		
		$sql="SELECT * FROM usuario WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para ver los dartos de la meta 
	public function datosMeta($id_meta)
	{	
	
		$sql="SELECT * FROM meta WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

}

?>