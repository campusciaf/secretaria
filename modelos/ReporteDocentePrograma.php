<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class ReporteDocentePrograma
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function ConsultarProgramaxDocente($id_programa,$jornada,$periodo)
	{

		$sql="SELECT * FROM `docente_grupos` INNER JOIN `docente` ON `docente`.`id_usuario` = `docente_grupos`.`id_docente` WHERE `docente_grupos`.`id_programa` = :id_programa and `docente_grupos`.`jornada` = :jornada  and  `docente_grupos`.`periodo` = :periodo ORDER BY `docente_grupos`.`semestre` ASC";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
		
	public function Consultar_Materias_Ciafi($id)
	{
		$sql="SELECT * FROM `materias_ciafi`  WHERE `id` = :id ";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar los programas en un select
	public function selectDocente()
	{	
		$sql="SELECT id_usuario,usuario_nombre,usuario_nombre_2,usuario_apellido,usuario_apellido_2 FROM docente WHERE usuario_condicion=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los dias en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo order by periodo DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function selectJornada()
	{	
		$sql="SELECT * FROM jornada ORDER BY `jornada`.`nombre` ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los programas activos
	public function selectPrograma()
	{	
		$sql="SELECT * FROM programa_ac WHERE estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	



}
