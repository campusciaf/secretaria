<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CuentaDocente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

    }
	// Función para listar los docentes que se encuentran activos
    public function listar(){
        $sql="SELECT * FROM docente WHERE usuario_condicion = 1";
		//return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
    //Implementar un método para mirar datos del estudiante
	public function est_carac_habeas($id_credencial){
    	$sql="SELECT * FROM caracterizacion_data WHERE id_credencial= :id_credencial"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// Función para traer los grupos del docente seleccionado con id_docente y periodo
	public function cargarGrupos($id_docente,$periodo_actual){
		$sql = "SELECT * FROM  docente_grupos WHERE id_docente=:id_docente AND periodo=:periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// Función para cargar la información del programa
	public function cargarPrograma($id_programa){
		$sql = "SELECT * FROM programa_ac WHERE id_programa=:id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// Función para cargar la información del docente con el id_docente_grupos
	public function cargarPrograma2($id_docente_grupo){
		$sql = "SELECT * FROM  docente_grupos WHERE id_docente_grupo=:id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarEstudiantes($ciclo,$materia,$jornada,$id_programa,$grupo){
		$tabla="materias".$ciclo;
		$sql="SELECT * FROM $tabla WHERE nombre_materia= :materia and jornada= :jornada and programa= :id_programa and periodo='".$_SESSION['periodo_actual']."' and grupo= :grupo";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mirar el id del estudiante
	public function id_estudiante($id_estudiante){
    	$sql="SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	//Implementar un método para mirar datos del estudiante
	public function estudiante_datos($id_credencial){
    	$sql="SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar si tiene pea creado
	public function tienepea($id_docente_grupo){
    	$sql="SELECT * FROM pea_docentes WHERE id_docente_grupo= :id_docente_grupo"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar el programa
	public function pea($id_programa,$materia){
		$sql="SELECT * FROM pea WHERE id_programa= :id_programa and materia= :materia and estado=1"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":materia", $materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listarPea($id_pea){
		$sql="SELECT * FROM pea_temas WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}
	//Implementar un método listar las actividades
	public function listaractividades($id_tema,$id_docente_grupo){
		$sql="SELECT * FROM pea_actividades WHERE id_tema= :id_tema and id_docente_grupo= :id_docente_grupo"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}
	// Función para cargar la fecha en formato español
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
	//Implementar un método para listar las horas de la noche
	public function listarHorasDia(){
		$sql="SELECT * FROM horas_del_dia";// mayor a 48, para que coja la jornada de la noche
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer las clase que corresponde al filtro
	public function docenteGrupos($id_docente,$periodo,$dia,$hora){
		$sql="SELECT * FROM docente_grupos dg INNER JOIN horas_grupos hg ON dg.id_docente_grupo=hg.id_docente_grupo WHERE  (dg.id_docente= :id_docente and dg.periodo= :periodo and hg.dia= :dia and hg.hora= :hora) or (dg.id_docente= :id_docente and dg.periodo= :periodo and hg.dia= :dia and hg.hasta= :hora) ";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa seleccionado
	public function mostrarDatosPrograma($id_programa){
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer las clase que corresponde al filtro
	public function docenteGruposRow($id_docente,$periodo,$dia,$hora){
		$sql="SELECT * FROM docente_grupos dg INNER JOIN horas_grupos hg ON dg.id_docente_grupo=hg.id_docente_grupo WHERE  (dg.id_docente= :id_docente and dg.periodo= :periodo and hg.dia= :dia and (:hora BETWEEN hg.hora and hg.hasta))";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":dia", $dia);
		$consulta->bindParam(":hora", $hora);

		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

		//Implementar un método para mirar los datos de la materia
		public function datosmateria($id_materia){
			$sql="SELECT * FROM materias_ciafi WHERE id= :id_materia"; 
			
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_materia", $id_materia);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

			//Implementar un método para listar las horas del dia
	public function TraerHorariocalendario($id_docente,$periodo)
	{
		$sql="SELECT * FROM docente_grupos WHERE id_docente= :id_docente and periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
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

	//Implementar un método para listar los docentes activos
	public function datosDocente($id_usuario)
	{	
		$sql="SELECT * FROM docente WHERE id_usuario= :id_usuario";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function MostrarCargoDocentes($documento_docente, $periodo)
	{
		global $mbd;
		$sql = "SELECT * FROM contrato_docente WHERE documento_docente = :documento_docente AND periodo = :periodo ORDER BY fecha_realizo DESC LIMIT 1";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":documento_docente", $documento_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC); 
		return $resultado;
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
}