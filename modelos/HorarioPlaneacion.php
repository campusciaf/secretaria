<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class HorarioPlaneacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	

	
		//Implementar un método para mostrar los datos del programa
	public function datosPrograma($id_programa)
	{
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para listar los registros
	public function listarMaterias($id_programa,$semestre)
	{
		$sql="SELECT * FROM materias_ciafi WHERE id_programa_ac= :id_programa and semestre= :semestre";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para listar las escuelas
	public function selectPrograma()
	{	
		$sql="SELECT * FROM programa_ac WHERE estado='1'";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar las jornadas
	public function selectJornada()
	{	
		$sql="SELECT * FROM jornada WHERE estado='1'";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los dias
	public function selectDia()
	{	
		$sql="SELECT * FROM dia";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las materias
	public function prerequisito($prerequisito)
	{	
		$sql="SELECT * FROM materias_ciafi WHERE id= :prerequisito";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar los datos del programa
	public function TraerHorario($id_materia,$jornada,$grupo)
	{
		$sql="SELECT * FROM horario_fijo WHERE id_materia= :id_materia and jornada= :jornada and grupo= :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar las horas del dia
	public function listarHorasDia()
	{
		$sql="SELECT * FROM horas_del_dia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}

		//Implementar un método para listar las horas hasta
		public function traeridhora($hora)
		{
			$sql="SELECT * FROM horas_del_dia WHERE horas= :hora";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":hora", $hora);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
			
		}

		public function calcularHoras($horaini,$horafin)
		{
			$f1 = new DateTime($horaini);
			$f2 = new DateTime($horafin);
			$d = $f1->diff($f2);
			$horas=$d->format('%H:%I:%S');
			
			switch ($horas){
				case '00:45:00':
					return $diferencia=1;
				break;
				case '01:00:00':
					return $diferencia=1;
				break;
				case '01:15:00':
					return $diferencia=2;
				break;
				case '01:30:00':
					return $diferencia=2;
				break;
				case '02:00:00':
					return $diferencia=2;
				break;
				case '02:15:00':
					return $diferencia=3;
				break;
				case '02:30:00':
					return $diferencia=3;
				break;
				case '02:45:00':
					return $diferencia=3;
				break;
				case '03:00:00':
					return $diferencia=4;
				break;
				case '03:15:00':
					return $diferencia=4;
				break;
				case '03:45:00':
					return $diferencia=5;
				break;
				case '04:00:00':
					echo $diferencia=5;
				break;
				default:
					return $diferencia=0;
			}
			
		}

	//Implementar un método para traer el id del programa de la materia
	public function BuscarDatosAsignatura($id_materia)
	{
		$sql="SELECT id_programa_ac,nombre,semestre FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}


	//Implementamos un método para insertar el horario de la asignatura
	public function insertarhorario($id_programa_ac,$id_materia,$jornadamateria,$semestremateria,$grupomateria,$dia,$hora,$hasta,$diferencia,$corte,$ciclo)
	{
		$sql="INSERT INTO horario_fijo (id_programa,id_materia,jornada,semestre,grupo,dia,hora,hasta,diferencia,corte,ciclo)
		VALUES ('$id_programa_ac','$id_materia','$jornadamateria','$semestremateria','$grupomateria','$dia','$hora','$hasta','$diferencia','$corte','$ciclo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();

	}

	
	//Implementar un método para listar las horas del dia
	public function TraerHorariocalendario($id_programa,$jornada,$semestre,$grupo)
	{
		$sql="SELECT * FROM horario_fijo WHERE id_programa= :id_programa and jornada= :jornada and semestre= :semestre and grupo= :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

	//Implementar un método para saber la joranda real
	public function selectJornadaReal($nombre)
	{	
		$sql="SELECT * FROM jornada WHERE nombre= :nombre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


//Implementar un método para mostrar los datos a editar
	public function mostrarDatosEditar($id_horario_fijo)
	{	
		$sql="SELECT * FROM horario_fijo WHERE id_horario_fijo= :id_horario_fijo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_horario_fijo", $id_horario_fijo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	// consulta para editar el horario de la materia

	public function editarhorario($id_horario_fijo,$dia,$hora,$hasta,$diferencia)
	{
		$sql="UPDATE horario_fijo SET dia= :dia, hora= :hora, hasta= :hasta, diferencia= :diferencia WHERE id_horario_fijo= :id_horario_fijo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_horario_fijo", $id_horario_fijo);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":diferencia", $diferencia);
		return $consulta->execute();
	}

	public function crucemateria($id_programa_ac,$jornadamateria,$semestremateria,$grupomateria,$dia,$hora,$hasta,$corte){
			
		$sql="SELECT * FROM horario_fijo WHERE id_programa= :id_programa_ac and jornada= :jornadamateria and semestre= :semestremateria and grupo= :grupomateria and dia= :dia and (:hora BETWEEN hora AND hasta or :hasta BETWEEN hora AND hasta) and corte= :corte";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->bindParam(":jornadamateria", $jornadamateria);
		$consulta->bindParam(":semestremateria", $semestremateria);
		$consulta->bindParam(":grupomateria", $grupomateria);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":corte", $corte);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para eliminar un horario
	public function eliminarhorario($id_horario_fijo)
	{
		$sql="DELETE FROM horario_fijo WHERE id_horario_fijo= :id_horario_fijo"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_horario_fijo", $id_horario_fijo);
		$consulta->execute();
		return $consulta;

	}

	
	//Implementar un método para listar los salones
	public function listarSalones()
	{	
		$sql="SELECT * FROM salones";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los salones
	public function listarSalonesDisponibles($salon,$dia,$hora,$hasta)
	{	
		$sql="SELECT * FROM horario_fijo WHERE salon = :salon and dia = :dia and (:hora BETWEEN hora AND hasta or :hasta BETWEEN hora AND hasta)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":salon", $salon);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para asignar el salón
	public function asignarSalon($id_horario_fijo,	$salon)
	{
		$sql="UPDATE horario_fijo SET salon= :salon WHERE id_horario_fijo= :id_horario_fijo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_horario_fijo", $id_horario_fijo);
		$consulta->bindParam(":salon", $salon);
		return $consulta->execute();
	}
	

}

?>