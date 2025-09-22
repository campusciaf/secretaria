<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class MateriasPrograma
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementamos un método para insertar registros
	public function insertar($id_programa, $programa, $nombre, $semestre, $area, $creditos, $codigo, $presenciales, $independiente, $escuela, $modelo, $modalidad_grado)
	{
		$sql = "INSERT INTO materias_ciafi (id_programa_ac,programa,nombre,semestre,area,creditos,codigo,presenciales,independiente,escuela,modelo,modalidad_grado)
		VALUES ('$id_programa','$programa','$nombre','$semestre','$area','$creditos','$codigo','$presenciales','$independiente','$escuela','$modelo','$modalidad_grado')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para editar registros
	public function editar($id, $programa, $nombre, $semestre, $area, $creditos, $codigo, $presenciales, $independiente, $escuela, $modelo, $modalidad_grado)
	{
		$sql = "UPDATE materias_ciafi SET programa='$programa', nombre='$nombre', semestre='$semestre', area='$area', creditos='$creditos', codigo='$codigo', presenciales='$presenciales', independiente='$independiente', escuela='$escuela', modelo='$modelo', modalidad_grado='$modalidad_grado' WHERE id='$id'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();
	}
	//Implementar un método para listar los registros
	public function listar($programa)
	{
		$sql = "SELECT * FROM materias_ciafi WHERE programa= :programa";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function listarMaterias($original)
	{
		$sql = "SELECT * FROM materias_ciafi WHERE programa= :original";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":original", $original);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_materia)
	{
		$sql = "SELECT * FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar el id del programa
	public function mostrarIdPrograma($programa)
	{
		$sql = "SELECT * FROM programa_ac WHERE nombre= :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar las escuelas
	public function selectEscuela()
	{
		$sql = "SELECT * FROM escuelas";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar las escuelas
	public function selectPrograma()
	{
		$sql = "SELECT * FROM programa_ac";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar las escuelas
	public function selectArea()
	{
		$sql = "SELECT * FROM area";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function ModalidadGrado($id_materia)
	{
		$sql = "SELECT * FROM materias_ciafi_modalidad WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para insertar registros
	public function insertarModalidad($id_materia_add, $modalidad_add)
	{
		$sql = "INSERT INTO materias_ciafi_modalidad (id_materia,modalidad)
		VALUES ('$id_materia_add','$modalidad_add')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementar un método para eliminar la modalidad
	public function eliminarmodalidad($id_materias_ciafi_modalidad)
	{
		$sql = "DELETE FROM materias_ciafi_modalidad WHERE id_materias_ciafi_modalidad= :id_materias_ciafi_modalidad";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materias_ciafi_modalidad", $id_materias_ciafi_modalidad);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
