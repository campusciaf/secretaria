<?php
session_start(); 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";


Class MiCompromiso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_compromiso,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo)
	{
		$sql="INSERT INTO meta (id_compromiso,id_eje,meta_nombre,meta_fecha,meta_val_admin,meta_val_usuario,meta_valida,meta_periodo)
		VALUES ('$id_compromiso','$id_eje','$meta_nombre','$meta_fecha','$meta_val_admin','$meta_val_usuario','$meta_valida','$meta_periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para editar registros
	public function editar($id_meta,$id_compromiso,$id_eje,$meta_nombre,$meta_fecha,$meta_valida,$meta_periodo)
	{
		$sql="UPDATE meta SET id_compromiso='$id_compromiso',id_eje='$id_eje', meta_nombre='$meta_nombre', meta_fecha='$meta_fecha', meta_valida='$meta_valida', meta_periodo='$meta_periodo' WHERE id_meta='$id_meta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		return $consulta->execute();
	}

	
	//Implementamos un método para insertar fuentes
	public function insertarfuente($id_meta_fuente,$fuente_archivo,$fecha_fuente)
	{
		$sql="INSERT INTO meta_fuente (id_meta,fuente_archivo,fecha_fuente)
		VALUES ('$id_meta_fuente','$fuente_archivo','$fecha_fuente')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();

	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_meta)
	{
		$sql="SELECT * FROM meta WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para eliminar las metas 
	public function eliminar($id_meta)
	{
		$sql="DELETE FROM meta WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		return $consulta->execute();
	}

	//Implementar un método para validar meta por usuario 
	public function validarMeta($id_meta,$fecha)
	{
		$sql="UPDATE meta SET meta_val_usuario='1',fecha_val_usuario='".$fecha."' WHERE id_meta='$id_meta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		return $consulta->execute();
		
	}
	//Implementar un método para eliminar lola fuente de verificación 
	public function eliminarFuente($id_meta)
	{
		$sql="DELETE FROM meta_fuente WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		return $consulta->execute();

	}
	//Implementar un metodo para buscar el periodo
	public function buscarperiodo()
	{	
		$sql="SELECT * FROM periodo_actual WHERE id='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para listar los micompromisos
	public function listar()
	{	
		$sql="SELECT * FROM compromiso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los micompromisos
	public function listarMiCompromiso($periodo_actual)
	{	
		$sql="SELECT * FROM compromiso WHERE id_usuario= :id_usuario and compromiso_periodo= :periodo_actual";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $_SESSION['id_usuario']);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar mis compromisos
	public function listarMiMeta($id_compromiso,$periodo_actual)
	{	
		$sql="SELECT * FROM meta WHERE id_compromiso= :id_compromiso and meta_periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_compromiso", $id_compromiso);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;

	}
	
	//Implementar un método para listar los usuarios que pueden tener poa
	public function listarUsuarioPoa()
	{	
		$sql="SELECT * FROM usuario WHERE usuario_poa='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
	//Implementar un método para imprimir la fuente de verificacion 
	public function buscarFuente($id_meta)
	{
		$sql="SELECT * FROM meta_fuente WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
	//Implementar un método para listar los registros en un select
	public function select()
	{	
		$sql="SELECT * FROM compromiso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
	public function selectlistaCargo()
	{	
		$sql="SELECT * FROM usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	//Implementar un método para imrpimir el eje 
	public function buscarEjes($id_ejes)
	{
		$sql="SELECT * FROM ejes WHERE id_ejes='".$id_ejes."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		//$consulta->bindParam(":id_ejes", $id_ejes);
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
	
	//Implementar un método para listar los ejes en un select
	public function selectEjes()
	{	
		$sql="SELECT * FROM ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
	//Implementar un método para listar los periodos en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo ORDER BY id_periodo DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
				//Implementar un método para listar los si o no
	public function selectlistaSiNo()
	{	
		$sql="SELECT * FROM lista_si_no";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
		//Implementar un método para ver el correo destinatario
	public function correoDestinatario($cargo)
	{
		$sql="SELECT usuario_cargo,usuario_login FROM usuario WHERE usuario_cargo= :cargo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":cargo", $cargo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
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


}

?>