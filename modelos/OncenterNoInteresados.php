<?php
require "../config/Conexion.php";

Class OncenterNoInteresados
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
	public function periodoactual()
    {
    	$sql="SELECT * FROM on_periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	//Implementar un método para listar los estados del proceso
	public function listarestados()
	{	
		$sql="SELECT * FROM on_estado WHERE arreglo=1 and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para listar los estados del proceso
	public function listarmedios()
	{	
		$sql="SELECT * FROM on_medio WHERE estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los interesados
	public function listar($periodo,$estado)
	{	
		$sql="SELECT * FROM on_interesados WHERE estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para listar los interesados por medio
	public function listarmedio($medio,$periodo,$estado)
	{	
		$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":medio", $medio);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
			//Implementar un método para listar los estados del proceso
	public function listarmedioscantidad($estado,$medio,$periodo)
	{	
		$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":medio", $medio);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
	
	
	//Implementar un método para mostrar el id del programa
	public function listarPrograma()
	{
		$sql="SELECT * FROM on_programa where estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para mostrar el id del programa
	public function listarJornada()
	{
		$sql="SELECT * FROM on_jornadas where estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
				//Implementar un método para listar los estados del proceso
	public function listarprogramajornada($programa,$jornada,$estado,$periodo)
	{	
		$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
	
	
	//Implementar un método para listar los estados del proceso con el medio
	public function listarprogramamedio($programa,$jornada,$medio,$estado,$periodo)
	{	
		$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and medio= :medio and estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":medio", $medio);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para sumar los datos por jornada
	public function sumaporjornada($jornada,$estado,$periodo)
	{	
		$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para sumar los datos por jornada
	public function sumapormedio($jornada,$medio,$estado,$periodo)
	{	
		$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and medio= :medio and estado= :estado and periodo_campana= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":medio", $medio);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":periodo", $periodo);
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
	
		//Implementar un método para listar los departamentos en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM on_periodo";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para listar los estados
	public function selectEstado()
	{	
		$sql="SELECT * FROM on_estado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
			//Implementar un método para listar los departamentos en un select
	public function selectPeriodoDos()
	{	
		$sql="SELECT * FROM on_periodo ORDER BY id_periodo ASC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementamos un método para actualziar el estado
	public function moverUsuario($id_estudiante_mover,$estado,$periodo_dos)
	{
		$sql="UPDATE on_interesados SET estado= :estado, periodo_campana= :periodo_dos WHERE id_estudiante= :id_estudiante_mover";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":id_estudiante_mover", $id_estudiante_mover);
		$consulta->bindParam(":periodo_dos", $periodo_dos);
		return $consulta->execute();

	}
	
		//Implementamos un método para insertar seguimiento
	public function insertarSeguimiento($id_usuario,$id_estudiante_agregar,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora)
	{
		$sql="INSERT INTO on_seguimiento (id_usuario,id_estudiante,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento)
		VALUES ('$id_usuario','$id_estudiante_agregar','$motivo_seguimiento','$mensaje_seguimiento','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
		//Implementamos un método para insertar una tarea
	public function insertarTarea($id_usuario,$id_estudiante_tarea,$motivo_tarea,$mensaje_tarea,$fecha_registro,$hora_registro,$fecha_programada,$hora_programada,$periodo_actual)
	{
		$sql="INSERT INTO on_interesados_tareas_programadas (id_usuario,id_estudiante,motivo_tarea,mensaje_tarea,fecha_registro,hora_registro,fecha_programada,hora_programada,fecha_realizo,hora_realizo,periodo)
		VALUES ('$id_usuario','$id_estudiante_tarea','$motivo_tarea','$mensaje_tarea','$fecha_registro','$hora_registro','$fecha_programada','$hora_programada',NULL,NULL,'$periodo_actual')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
			//Implementar un método para listar los interesados
	public function VerHistorial($id_estudiante)
	{	
		$sql="SELECT * FROM on_interesados oni INNER JOIN on_interesados_datos onid ON oni.id_estudiante=onid.id_estudiante WHERE oni.id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
			//Implementar un método para listar el historial de seguimiento
	public function verHistorialTabla($id_estudiante)
	{	
		$sql="SELECT * FROM on_seguimiento WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
			//Implementar un método para listar el historial de seguimiento
	public function verHistorialTablaTareas($id_estudiante)
	{	
		$sql="SELECT * FROM on_interesados_tareas_programadas WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
			//Implementar un método para eliminar el interesado
	public function datosAsesor($id_usuario)
    {
    	$sql="SELECT * FROM usuario WHERE id_usuario= :id_usuario"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

    }
		//Implementar un método para eliminar el interesado
	public function eliminarDatos($id_estudiante)
    {
    	$sql="DELETE FROM on_interesados_datos WHERE id_estudiante= :id_estudiante"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    }
	
			//Implementar un método para eiminar el seguimiento
	public function eliminarSeguimiento($id_estudiante)
	{	
		$sql="DELETE FROM on_seguimiento WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();

	}
		//Implementar un método para eiminar tareas
	public function eliminarTareas($id_estudiante)
	{	
		$sql="DELETE FROM on_interesados_tareas_programadas WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		$resultado;
	}
	
			//Implementar un método para eliminar el interesado
	public function eliminar($id_estudiante)
    {
    	$sql="DELETE FROM on_interesados WHERE id_estudiante= :id_estudiante"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

    }
	
			//Implementamos un método para insertar la evidencia del eliminado
	public function insertarEliminar($id_estudiante,$estado,$fecha,$hora,$id_usuario)
	{
		$sql="INSERT INTO on_eliminados (id_estudiante,estado,fecha,hora,id_usuario) VALUES ('$id_estudiante','$estado','$fecha','$hora','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
	}
	
}

?>