
<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class EstadisticaPoa
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros
	public function listar()
	{	
		$sql="SELECT * FROM meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
		//Implementar un método para listar los registros
	public function listarEjes()
	{	
		$sql="SELECT id_ejes,nombre_ejes FROM ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}

		//Implementar un método para listar los registros
		public function sumarMetas($id_eje)
	{	
		$sql="SELECT id_eje FROM meta WHERE id_eje='".$id_eje."'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
		//Implementar un método para listar los registros
		public function sumarMetasTerminadas($id_eje)
	{	
		$sql="SELECT id_eje,meta_val_admin FROM meta WHERE id_eje='".$id_eje."' and meta_val_admin=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
}

?>