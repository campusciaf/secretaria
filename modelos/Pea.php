<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Pea
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_pea,$sesion,$conceptuales)
	{
		$sql="INSERT INTO pea_temas (id_pea,sesion,conceptuales)
		VALUES ('$id_pea','$sesion','$conceptuales')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para insertar rerefencias
	public function insertarreferencia($id_pea,$referencia)
	{
		$sql="INSERT INTO pea_referencia (id_pea,referencia)
		VALUES ('$id_pea','$referencia')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
		//Implementamos un método para editar registros
	public function editar($id_tema,$conceptuales)
	{
		$sql="UPDATE pea_temas SET conceptuales='$conceptuales' WHERE id_tema='$id_tema'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();

	}

	//Implementamos un método para editar referencia
	public function editarreferencia($id_pea_referencia,$referencia)
	{
		$sql="UPDATE pea_referencia SET referencia='$referencia' WHERE id_pea_referencia='$id_pea_referencia'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();

	}
	
	//Implementamos un método para insertar un PEA nuevo
	public function insertarPea($ciclo,$id_programa,$semestre,$materia,$id_materia,$fecha_aprobacion,$version)
	{
		$sql="INSERT INTO pea (ciclo,id_programa,semestre,materia,id_materia,fecha_aprobacion,version)
		VALUES ('$ciclo','$id_programa','$semestre','$materia','$id_materia','$fecha_aprobacion','$version')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
	//Implementar un método para listar los registros
	public function listar($programa)
	{
		$sql="SELECT * FROM materias_ciafi WHERE programa= :programa";
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
		$sql="SELECT * FROM materias_ciafi WHERE programa= :original";
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
		$sql="SELECT * FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
			//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrareditartema($id_tema)
	{
		$sql="SELECT * FROM pea_temas WHERE id_tema= :id_tema";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrareditarreferencia($id_pea_referencia)
	{
		$sql="SELECT * FROM pea_referencia WHERE id_pea_referencia= :id_pea_referencia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_referencia", $id_pea_referencia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
			//Implementar un método para mostrar el id del programa
	public function mostrarIdPrograma($programa)
	{
		$sql="SELECT * FROM programa_ac WHERE nombre= :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
			//Implementar un método para mostrar el id del programa
	public function mostrarDatosPrograma($id_programa)
	{
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	
		//Implementar un método para listar las escuelas
	public function selectPrograma()
	{	
		$sql="SELECT * FROM programa_ac WHERE pertenece =1";//pertenece es que aparezca como programa propio
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para mostrar los temas de los PEA
	public function verPea($id_pea)
	{
		$sql="SELECT * FROM pea_temas WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar los temas de los PEA
	public function verPeaReferencia($id_pea)
	{
		$sql="SELECT * FROM pea_referencia WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para mostrar el consecutivo del tema
	public function numeroTema($id_pea)
	{
		$sql="SELECT * FROM pea_temas WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
	//Implementar un método para mostrar los pea de la materia
	public function pea($id_programa,$id_materia)
	{
		$sql="SELECT * FROM pea WHERE id_programa= :id_programa and id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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
	
			//Implementamos un método para desactivar categorías
	public function datospea($id_pea)
	{
		$sql="SELECT * FROM pea WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	

		//Implementamos un método para desactivar categorías
	public function desactivar($id_pea)
	{
		$sql="UPDATE pea SET estado='0' WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}


	//Implementamos un método para activar categorías
	public function activar($id_pea)
	{
		$sql="UPDATE pea SET estado='1' WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para actualziar la descripcion
	public function actualizardescripcion($contenido,$id_pea,$valor)
	{
		if($valor==1){// se actualiza la metologia
			$sql="UPDATE pea SET competencias= :contenido WHERE id_pea= :id_pea";
		}
		if($valor==2){// se actualiza la metologia
			$sql="UPDATE pea SET resultado= :contenido WHERE id_pea= :id_pea";
		}
		if($valor==3){// se actualiza la metologia
			$sql="UPDATE pea SET criterio= :contenido WHERE id_pea= :id_pea";
		}
		if($valor==4){// se actualiza la metologia
			$sql="UPDATE pea SET metodologia= :contenido WHERE id_pea= :id_pea";
		}
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":contenido", $contenido);
		$consulta->bindParam(":id_pea", $id_pea);
		return $consulta->execute();

		
	}

	//Implementar un método para eliminar un tema
	public function eliminartema($id_tema)
	{
		$sql="DELETE FROM pea_temas WHERE id_tema= :id_tema"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->execute();
		return $consulta;

	}

	//Implementar un método para eliminar un tema
	public function eliminarreferencia($id_pea_referencia)
	{
		$sql="DELETE FROM pea_referencia WHERE id_pea_referencia= :id_pea_referencia"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_referencia", $id_pea_referencia);
		$consulta->execute();
		return $consulta;

	}

	public function pea_consulta_estado_activo($id_programa,$id_materia)
	{
		$sql="SELECT * FROM pea WHERE id_programa= :id_programa and id_materia= :id_materia AND estado = 1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	

	
	
	
	
}

?>