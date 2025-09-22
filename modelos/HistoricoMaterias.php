<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class HistoricoMaterias
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

    public function periodoactual()
	{
		$sql = "SELECT periodo_actual FROM periodo_actual";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function listar()
	{

		$sql = "SELECT * FROM docente_grupos dg INNER JOIN materias_ciafi mc ON dg.id_materia=mc.id";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}




    public function datosDocente($id_docente){	
		global $mbd;
		$sql="SELECT * FROM `docente` WHERE id_usuario= :id_docente ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



		
}
