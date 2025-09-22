<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class GestionHorarios
{
	//Implementamos nuestro constructor
	public function __construct() {}
	public function periodoactual()
	{
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos del programa
	public function datosPrograma($id_programa)
	{
		$sql = "SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listarMaterias($id_programa, $semestre)
	{
		$sql = "SELECT * FROM materias_ciafi WHERE id_programa_ac= :id_programa and semestre= :semestre";
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
		$sql = "SELECT * FROM programa_ac WHERE estado='1'";
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
		$sql = "SELECT * FROM jornada WHERE estado='1'";
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
		$sql = "SELECT * FROM dia";
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
		$sql = "SELECT * FROM materias_ciafi WHERE id= :prerequisito";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el horario dela tabla horario fijo
	public function TraerHorario($id_materia, $jornada, $grupo)
	{
		$sql = "SELECT * FROM horario_fijo WHERE id_materia= :id_materia and jornada= :jornada and grupo= :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer el horario dela tabla horario fijo
	public function mirarHorarioDocenteGrupo($id_materia, $jornada, $grupo, $dia, $hora, $hasta, $periodo_actual)
	{
		$sql = "SELECT * FROM docente_grupos WHERE id_materia= :id_materia and jornada= :jornada and grupo= :grupo and dia= :dia and hora= :hora and hasta= :hasta and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el horario dela tabla docente_grupos
	public function TraerHorarioDocenteGrupos($id_materia, $jornada, $grupo, $periodo_actual)
	{
		$sql = "SELECT * FROM docente_grupos WHERE id_materia= :id_materia and jornada= :jornada and grupo= :grupo and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer el horario dela tabla horario fijo
	public function TraerHorarioFijo($id_horario_fijo)
	{
		$sql = "SELECT * FROM horario_fijo WHERE id_horario_fijo= :id_horario_fijo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_horario_fijo", $id_horario_fijo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// funcion para mirar si la materia esta en docnete grupos cuando el salon llega null desde horario fijo
	public function crucemateriadocentegrupos($id_programa, $jornada, $semestre, $grupo, $dia, $hora, $hasta, $corte, $periodo_actual)
	{
		$sql = "SELECT * FROM docente_grupos WHERE id_programa= :id_programa and jornada= :jornada and semestre= :semestre and grupo= :grupo and dia= :dia and (:hora BETWEEN hora AND hasta or :hasta BETWEEN hora AND hasta) and corte= :corte and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":corte", $corte);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// funcion para mirar si la materia esta en docnete grupos cuando el salon llega null desde horario fijo
	public function crucemateriadocentegrupossalon($dia, $hora, $hasta, $salon, $periodo_actual)
	{
		$sql = "SELECT * FROM docente_grupos WHERE dia= :dia and (:hora BETWEEN hora AND hasta or :hasta BETWEEN hora AND hasta) and salon= :salon and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":salon", $salon);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// implementar un metodo para agregar el horio en docente grupos
	public function agregarHorario($id_programa, $id_materia, $jornada, $semestre, $grupo, $dia, $hora, $hasta, $diferencia, $salon, $corte, $ciclo, $periodo_actual)
	{
		$sql = "INSERT INTO docente_grupos (id_programa,id_materia,jornada,semestre,grupo,dia,hora,hasta,diferencia,salon,corte,ciclo,periodo)
		VALUES ('$id_programa','$id_materia','$jornada','$semestre','$grupo','$dia','$hora','$hasta','$diferencia','$salon','$corte','$ciclo','$periodo_actual')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;
	}
	//Implementar un método para listar las horas del dia
	public function listarHorasDia()
	{
		$sql = "SELECT * FROM horas_del_dia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las horas hasta
	public function traeridhora($hora)
	{
		$sql = "SELECT * FROM horas_del_dia WHERE horas= :hora";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":hora", $hora);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function calcularHoras($horaini, $horafin)
	{
		$f1 = new DateTime($horaini);
		$f2 = new DateTime($horafin);
		$d = $f1->diff($f2);
		$horas = $d->format('%H:%I:%S');
		switch ($horas) {
			case '00:45:00':
				return $diferencia = 1;
				break;
			case '01:00:00':
				return $diferencia = 1;
				break;
			case '01:15:00':
				return $diferencia = 2;
				break;
			case '01:30:00':
				return $diferencia = 2;
				break;
			case '02:00:00':
				return $diferencia = 2;
				break;
			case '02:15:00':
				return $diferencia = 3;
				break;
			case '02:30:00':
				return $diferencia = 3;
				break;
			case '02:45:00':
				return $diferencia = 3;
				break;
			case '03:00:00':
				return $diferencia = 4;
				break;
			case '03:15:00':
				return $diferencia = 4;
				break;
			case '03:45:00':
				return $diferencia = 5;
				break;
			case '04:00:00':
				echo $diferencia = 5;
				break;
			default:
				return $diferencia = 0;
		}
	}
	//Implementar un método para traer el id del programa de la materia
	public function BuscarDatosAsignatura($id_materia)
	{
		$sql = "SELECT id_programa_ac,nombre,semestre FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar el horario de la asignatura
	public function insertarhorario($id_programa_ac, $id_materia, $jornadamateria, $semestremateria, $grupomateria, $dia, $hora, $hasta, $diferencia, $corte, $ciclo)
	{
		$sql = "INSERT INTO horario_fijo (id_programa,id_materia,jornada,semestre,grupo,dia,hora,hasta,diferencia,corte,ciclo)
		VALUES ('$id_programa_ac','$id_materia','$jornadamateria','$semestremateria','$grupomateria','$dia','$hora','$hasta','$diferencia','$corte','$ciclo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
	//Implementar un método para listar las horas del dia
	public function TraerHorariocalendario($id_programa, $jornada, $semestre, $grupo, $periodo_actual)
	{
		$sql = "SELECT * FROM docente_grupos WHERE id_programa= :id_programa and jornada= :jornada and semestre= :semestre and grupo= :grupo and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar las horas del dia
	public function getReservasCalendario(
		$id_programa,
		$jornada,
		$semestre,
		$grupo,
		$periodo_actual,
		$fechaInicio,
		$fechaFin,
	) {	
		$sql = "SELECT
					rs.id,
					rs.detalle_reserva,
					rs.fecha_reserva,
					rs.horario,
					rs.hora_f,
					rs.salon,
					COALESCE(d.usuario_nombre, u.usuario_nombre) AS usuario_nombre,
					COALESCE(d.usuario_nombre_2, u.usuario_nombre_2) AS usuario_nombre_2,
					COALESCE(d.usuario_apellido, u.usuario_apellido) AS usuario_apellido,
					COALESCE(d.usuario_apellido_2, u.usuario_apellido_2) AS usuario_apellido_2
				FROM reservas_salones rs
				LEFT JOIN docente d 
					ON d.id_usuario = rs.id_docente 
					AND rs.tipo_usuario = 'd'
				LEFT JOIN usuario u 
					ON u.id_usuario = rs.id_docente 
					AND rs.tipo_usuario = 'f'
				WHERE rs.periodo = '2025-2'
				AND rs.estado = 0
				AND rs.fecha_reserva BETWEEN :fechaInicio AND :fechaFin;";
		
		global $mbd;

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":fechaInicio", $fechaInicio);
		$consulta->bindParam(":fechaFin", $fechaFin);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	

	//Implementar un método para saber la joranda real
	public function selectJornadaReal($nombre)
	{
		$sql = "SELECT * FROM jornada WHERE nombre= :nombre";
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
		$sql = "SELECT * FROM horario_fijo WHERE id_horario_fijo= :id_horario_fijo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_horario_fijo", $id_horario_fijo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// consulta para editar el horario de la materia
	public function editarhorario($id_horario_fijo, $dia, $hora, $hasta, $diferencia)
	{
		$sql = "UPDATE horario_fijo SET dia= :dia, hora= :hora, hasta= :hasta, diferencia= :diferencia WHERE id_horario_fijo= :id_horario_fijo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_horario_fijo", $id_horario_fijo);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":diferencia", $diferencia);
		return $consulta->execute();
	}
	public function crucemateria($id_programa_ac, $jornadamateria, $semestremateria, $grupomateria, $dia, $hora, $hasta, $corte)
	{
		$sql = "SELECT * FROM horario_fijo WHERE id_programa= :id_programa_ac and jornada= :jornadamateria and semestre= :semestremateria and grupo= :grupomateria and dia= :dia and (:hora BETWEEN hora AND hasta or :hasta BETWEEN hora AND hasta) and corte= :corte";
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
	public function eliminarhorario($id_docente_grupo)
	{
		$sql = "DELETE FROM docente_grupos WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		return $consulta;
	}

	public function getReserva($id_reserva) {
		$sql = "SELECT
					rs.id,
					rs.fecha_reserva,
					rs.horario,
					rs.hora_f,
					rs.salon,
					COALESCE(d.usuario_nombre, u.usuario_nombre) AS usuario_nombre,
					COALESCE(d.usuario_nombre_2, u.usuario_nombre_2) AS usuario_nombre_2,
					COALESCE(d.usuario_apellido, u.usuario_apellido) AS usuario_apellido,
					COALESCE(d.usuario_apellido_2, u.usuario_apellido_2) AS usuario_apellido_2,
					COALESCE(d.usuario_email_ciaf, u.usuario_email) AS usuario_email
				FROM reservas_salones rs
				LEFT JOIN docente d 
					ON d.id_usuario = rs.id_docente 
					AND rs.tipo_usuario = 'd'
				LEFT JOIN usuario u 
					ON u.id_usuario = rs.id_docente 
					AND rs.tipo_usuario = 'f'
				WHERE rs.id = :idReserva;";
		
		global $mbd;

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":idReserva", $id_reserva);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para eliminar un horario
	public function eliminarReserva($id_reserva)
	{
		$sql = "DELETE FROM reservas_salones WHERE id = :id_reserva";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_reserva", $id_reserva);
		$consulta->execute();
		return $consulta;
	}

	//Implementar un método para listar los salones
	public function listarSalones()
	{
		$sql = "SELECT * FROM salones";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los docents activos
	public function listarDocentes()
	{
		$sql = "SELECT * FROM docente WHERE usuario_condicion='1'";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los docents activos
	public function datosDocente($id_usuario)
	{
		$sql = "SELECT * FROM docente WHERE id_usuario= :id_usuario";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los salones disponibles
	public function listarSalonesDisponibles($salon, $dia, $hora, $hasta, $periodo_actual)
	{
		$sql = "SELECT * FROM docente_grupos WHERE salon = :salon and dia = :dia and (:hora BETWEEN hora AND hasta or :hasta BETWEEN hora AND hasta) and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":salon", $salon);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los docentes disponibles
	public function listarDocentesDisponibles($id_usuario_doc, $dia, $hora, $hasta, $periodo_actual)
	{
		$sql = "SELECT * FROM docente_grupos WHERE id_docente = :id_usuario_doc and dia = :dia and (:hora BETWEEN hora AND hasta or :hasta BETWEEN hora AND hasta) and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_doc", $id_usuario_doc);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los salones ocupados
	public function listarSalonesOcupado($salon, $dia, $hora, $hasta, $periodo_actual)
	{
		$sql = "SELECT * FROM docente_grupos WHERE salon = :salon and dia = :dia and (:hora BETWEEN hora AND hasta or :hasta BETWEEN hora AND hasta) and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":salon", $salon);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los salones ocupados
	public function listarDocenteOcupado($id_usuario_doc, $dia, $hora, $hasta, $periodo_actual)
	{
		$sql = "SELECT * FROM docente_grupos WHERE id_docente = :id_usuario_doc and dia = :dia and (:hora BETWEEN hora AND hasta or :hasta BETWEEN hora AND hasta) and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_doc", $id_usuario_doc);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->bindParam(":hasta", $hasta);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para asignar el salón
	public function asignarSalon($id_docente_grupo, $salon)
	{
		$sql = "UPDATE docente_grupos SET salon= :salon WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":salon", $salon);
		return $consulta->execute();
	}
	//Implementamos un método para asignar el salón
	public function asignarSalonFusion($id_docente_grupo, $salon)
	{
		$sql = "UPDATE docente_grupos SET salon= :salon, fusion_salon='0' WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":salon", $salon);
		return $consulta->execute();
	}
	//Implementamos un método para asignar el salón
	public function asignarDocente($id_docente_grupo, $id_usuario_doc)
	{
		$sql = "UPDATE docente_grupos SET id_docente= :id_usuario_doc WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":id_usuario_doc", $id_usuario_doc);
		return $consulta->execute();
	}
	//Implementamos un método para asignar docente fusion
	public function asignarDocenteFusion($id_docente_grupo, $id_usuario_doc)
	{
		$sql = "UPDATE docente_grupos SET id_docente= :id_usuario_doc, fusion_docente='0' WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":id_usuario_doc", $id_usuario_doc);
		return $consulta->execute();
	}
	//Implementamos un método para asignar el salón
	public function quitarDocente($id_docente_grupo)
	{
		$sql = "UPDATE docente_grupos SET id_docente=NULL, fusion_docente='1' WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		return $consulta->execute();
	}
	//Implementamos un método para asignar el salón
	public function quitarSalon($id_docente_grupo)
	{
		$sql = "UPDATE docente_grupos SET salon=NULL,fusion_salon='1' WHERE id_docente_grupo= :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		return $consulta->execute();
	}
	//Implementamos un método para traer los datos del grupo creado en la tabla docente grupos
	public function datoGrupo($id_docente_grupo)
	{
		$sql = "SELECT salon,id_docente,fusion_salon,fusion_docente FROM docente_grupos WHERE id_docente_grupo = :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las horas del docente
	public function horasDocente($id_usuario_doc, $perido_actual)
	{
		$sql = "SELECT sum(diferencia) as suma_horas FROM docente_grupos WHERE id_docente= :id_usuario_doc and periodo= :perido_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario_doc", $id_usuario_doc);
		$consulta->bindParam(":perido_actual", $perido_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
