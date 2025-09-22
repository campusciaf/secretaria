<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class SacEje
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementamos un método para insertar registros
	public function sac_insertar($nombre_ejes)
	{
		$sql="INSERT INTO sac_ejes (nombre_ejes)
		VALUES ('$nombre_ejes')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar registros
	public function editar($id_ejes,$nombre_ejes)
	{
		$sql="UPDATE sac_ejes SET nombre_ejes='$nombre_ejes' WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		return $consulta->execute();
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_ejes)
	{
		$sql="SELECT * FROM sac_ejes WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para eliminar los datos de un registro 
	public function eliminar($id_ejes)
	{
		$sql="DELETE FROM sac_ejes WHERE id_ejes= :id_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
		$consulta->execute();
	}
	//Implementar un método para listar los registros
	public function listar()
	{	
		$sql="SELECT * FROM sac_ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	//Implementar un método para listar los registros en un select
	public function select()
	{	
		$sql="SELECT * FROM sac_ejes";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar la ejecucion
	public function contarmetaeje($id_ejes){
		$anio = $_SESSION["sac_periodo"];

		global $mbd;


		$sql="SELECT `sac_meta`.`id_meta`, `sac_meta`.`meta_nombre`, `sac_ejes`.`nombre_ejes`, `sac_ejes`.`id_ejes` FROM (((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`) WHERE `sac_ejes`.`id_ejes` = :id_ejes AND `anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);	
		$consulta->bindParam(":anio", $anio);	
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function listarMetaEje($id_ejes){	

		$anio = $_SESSION["sac_periodo"];
		global $mbd;	
		$sql= "SELECT `sac_meta`.`meta_nombre` FROM (((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`) WHERE `sac_ejes`.`id_ejes` = :id_ejes AND `anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_ejes', $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;		
	}

	public function contaraccion($id_meta){	
		$anio = $_SESSION["sac_periodo"];
		global $mbd;
		$sql="SELECT COUNT(`sac_accion`.`id_meta`) AS total_accion FROM ((((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`)  INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta`) WHERE `sac_accion`.`id_meta` = :id_meta AND `anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function listarAccionEje($id_ejes){	

		$anio = $_SESSION["sac_periodo"];
		global $mbd;	
		$sql= "SELECT `sac_meta`.`meta_nombre`, `sac_accion`.`nombre_accion` FROM ((((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`) INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta`) WHERE `sac_ejes`.`id_ejes` = :id_ejes AND `anio_eje` = :anio";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_ejes', $id_ejes);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;		
	}

	
}

?>