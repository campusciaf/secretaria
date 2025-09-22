<?php
require "../config/Conexion.php";

Class OncenterInteresados
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
	
	//Implementamos un método para insertar seguimiento
	public function insertarSeguimiento($id_usuario,$id_estudiante_agregar,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora)
	{
		$sql="INSERT INTO on_seguimiento (id_usuario,id_estudiante,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento)
		VALUES ('$id_usuario','$id_estudiante_agregar','$motivo_seguimiento','$mensaje_seguimiento','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
				//Implementamos un método para editar registros
	public function actualizarSegui($id_estudiante)
	{
		$sql="UPDATE on_interesados SET segui=0 WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
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
	
	
	//Implementar un método para listar los estados del proceso
	public function listarcriterios()
	{	
		$sql="SELECT * FROM on_criterio WHERE estado=1";
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
	public function listar($periodo,$nombre_criterio)
	{	
		
		date_default_timezone_set("America/Bogota");	

		$fecha=date('Y-m-d');
		$hora=date('H:i:s');
		
		$estado="Interesado";
		
		if($nombre_criterio=="Interesado"){
			$sql="SELECT * FROM on_interesados WHERE estado='".$estado."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		
		if($nombre_criterio=="Sin-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE estado='".$estado."' and segui=1 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		
		if($nombre_criterio=="Con-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE estado='".$estado."' and segui=0 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="del-dia"){
			$sql="SELECT * FROM on_interesados WHERE estado='".$estado."' and fecha_ingreso='".$fecha."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

	}
	
		//Implementar un método para listar los interesados por medio
	public function listarpormedio($medio,$periodo,$nombre_criterio)
	{	
		date_default_timezone_set("America/Bogota");	

		$fecha=date('Y-m-d');
		$hora=date('H:i:s');
		
		$estado="Interesado";
		
		if($nombre_criterio=="Interesado"){		
			$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado='".$estado."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Sin-seguimiento"){		
			$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado='".$estado."' and segui=1 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Con-seguimiento"){		
			$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado='".$estado."' and segui=0 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="del-dia"){		
			$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado='".$estado."' and fecha_ingreso='".$fecha."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
	}
			//Implementar un método para listar los estados del proceso
	public function listarmedioscantidad($nombre_criterio,$medio,$periodo)
	{	
		date_default_timezone_set("America/Bogota");	

		$fecha=date('Y-m-d');
		$hora=date('H:i:s');
		
		$estado="Interesado";
		
		if($nombre_criterio=="Interesado"){
			$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado='".$estado."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Sin-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado='".$estado."' and segui=1 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Con-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado='".$estado."' and segui=0 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="del-dia"){
			$sql="SELECT * FROM on_interesados WHERE medio= :medio and estado='".$estado."' and fecha_ingreso='".$fecha."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		
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
	public function listarprogramajornada($programa,$jornada,$nombre_criterio,$periodo)
	{	
		date_default_timezone_set("America/Bogota");	

		$fecha=date('Y-m-d');
		$hora=date('H:i:s');
		
		$estado="Interesado";
		
		if($nombre_criterio=="Interesado"){
			$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and estado='".$estado."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":programa", $programa);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		
		if($nombre_criterio=="Sin-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and estado='".$estado."' and segui=1 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":programa", $programa);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Con-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and estado='".$estado."' and segui=0 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":programa", $programa);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="del-dia"){
			$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and fecha_ingreso='".$fecha."' and estado='".$estado."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":programa", $programa);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		
			
	}
	
	
	
	
	//Implementar un método para listar los estados del proceso con el medio
	public function listarprogramamedio($programa,$jornada,$medio,$nombre_criterio,$periodo)
	{	
		date_default_timezone_set("America/Bogota");	

		$fecha=date('Y-m-d');
		$hora=date('H:i:s');
		
		$estado="Interesado";
		
		if($nombre_criterio=="Interesado"){
			$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and medio= :medio and estado='".$estado."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":programa", $programa);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Sin-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and medio= :medio and estado='".$estado."' and segui=1 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":programa", $programa);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Con-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and medio= :medio and estado='".$estado."' and segui=0 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":programa", $programa);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="del-dia"){
			$sql="SELECT * FROM on_interesados WHERE fo_programa= :programa and jornada_e= :jornada and medio= :medio and estado='".$estado."' and fecha_ingreso='".$fecha."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":programa", $programa);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		
	}
	
	//Implementar un método para sumar los datos por jornada
	public function sumaporjornada($jornada,$nombre_criterio,$periodo)
	{	
		date_default_timezone_set("America/Bogota");	

		$fecha=date('Y-m-d');
		$hora=date('H:i:s');
		
		$estado="Interesado";
		
		if($nombre_criterio=="Interesado"){
			$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and estado='".$estado."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Sin-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and estado='".$estado."' and segui=1 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Con-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and estado='".$estado."' and segui=0 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="del-dia"){
			$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and estado='".$estado."' and fecha_ingreso='".$fecha."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		
	}
	
		//Implementar un método para sumar los datos por jornada
	public function sumapormedio($jornada,$medio,$nombre_criterio,$periodo)
	{	
		
		date_default_timezone_set("America/Bogota");	

		$fecha=date('Y-m-d');
		$hora=date('H:i:s');
		
		$estado="Interesado";
		
		if($nombre_criterio=="Interesado"){
			$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and medio= :medio and estado='".$estado."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Sin-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and medio= :medio and estado='".$estado."' and segui=1 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="Con-seguimiento"){
			$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and medio= :medio and estado='".$estado."' and segui=0 and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		if($nombre_criterio=="del-dia"){
			$sql="SELECT * FROM on_interesados WHERE jornada_e= :jornada and medio= :medio and estado='".$estado."' and fecha_ingreso='".$fecha."' and periodo_campana= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":medio", $medio);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
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
	
		//Implementar un método para listar las modalidades de camapañas
	public function selectModalidadCampana()
	{	
		$sql="SELECT * FROM on_modalidad_campana";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para ver si el nuevo documento existe 
	public function nuevoDocumento($nuevodocumento)
	{	
		$sql="SELECT * FROM on_interesados WHERE identificacion= :nuevodocumento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevodocumento", $nuevodocumento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
			//Implementamos un método para editar registros
	public function actualizarDocumento($id_estudiante_documento,$nuevodocumento,$modalidad_campana)
	{
		$clave=md5($id_estudiante_documento);
		
		$sql="UPDATE on_interesados SET identificacion= :nuevodocumento, clave= :clave, nombre_modalidad= :modalidad_campana, estado='Preinscrito', segui='0' WHERE id_estudiante= :id_estudiante_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nuevodocumento", $nuevodocumento);
		$consulta->bindParam(":modalidad_campana", $modalidad_campana);
		$consulta->bindParam(":id_estudiante_documento", $id_estudiante_documento);
		$consulta->bindParam(":clave", $clave);
		return $consulta->execute();

	}			
	
	//Implementamos un método para actualziar el estado
	public function moverUsuario($id_estudiante_mover,$estado)
	{
		$sql="UPDATE on_interesados SET estado= :estado WHERE id_estudiante= :id_estudiante_mover";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":estado", $estado);
		$consulta->bindParam(":id_estudiante_mover", $id_estudiante_mover);
		return $consulta->execute();

	}
		//Implementamos un método para insertar un seguimiento
	public function registrarSeguimiento($id_usuario,$id_estudiante_documento,$motivo,$mensaje_seguimiento,$fecha,$hora)
	{
		$sql="INSERT INTO on_seguimiento (id_usuario,id_estudiante,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento) VALUES ('$id_usuario','$id_estudiante_documento','$motivo','$mensaje_seguimiento','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
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
	
		//Implementamos un método para insertar la evidencia del eliminado
	public function insertarEliminar($id_estudiante,$estado,$fecha,$hora,$id_usuario)
	{
		$sql="INSERT INTO on_eliminados (id_estudiante,estado,fecha,hora,id_usuario) VALUES ('$id_estudiante','$estado','$fecha','$hora','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
	}
	
		//Implementar un método para listar los programas en un select
	public function selectPrograma()
	{	
		$sql="SELECT * FROM on_programa WHERE estado=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para listar los jornadas en un select
	public function selectJornada()
	{	
		$sql="SELECT * FROM on_jornadas";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los tipo de documentos en un select
	public function selectTipoDocumento()
	{	
		$sql="SELECT * FROM on_tipo_documento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para listar niveles e escolaridad
	public function selectNivelEscolaridad()
	{	
		$sql="SELECT * FROM on_nivel_escolaridad";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para mostrar los datos de un registro a modificar
	public function perfilEstudiante($id_estudiante)
	{
		$sql="SELECT * FROM on_interesados oi INNER JOIN on_interesados_datos oin ON oi.id_estudiante=oin.id_estudiante WHERE oi.id_estudiante= :id_estudiante";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementamos un método para actualziar el perfil
	public function editarPerfil($id_estudiante,$fo_programa,$jornada_e,$tipo_documento,$nombre,$nombre_2,$apellidos,$apellidos_2,$celular,$email,$nivel_escolaridad,$nombre_colegio,$fecha_graduacion)
	{
		$sql="UPDATE on_interesados oi INNER JOIN on_interesados_datos oid ON oi.id_estudiante=oid.id_estudiante SET oi.fo_programa= :fo_programa, oi.jornada_e= :jornada_e, oi.tipo_documento= :tipo_documento, oi.nombre= :nombre, oi.nombre_2= :nombre_2, oi.apellidos= :apellidos, oi.apellidos_2= :apellidos_2, oi.celular= :celular, oi.email= :email, oid.nivel_escolaridad= :nivel_escolaridad, oid.nombre_colegio= :nombre_colegio, oid.fecha_graduacion= :fecha_graduacion WHERE oi.id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":fo_programa", $fo_programa);
		$consulta->bindParam(":jornada_e", $jornada_e);
		$consulta->bindParam(":tipo_documento", $tipo_documento);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":nombre_2", $nombre_2);
		$consulta->bindParam(":apellidos", $apellidos);
		$consulta->bindParam(":apellidos_2", $apellidos_2);
		$consulta->bindParam(":celular", $celular);
		$consulta->bindParam(":email", $email);
		$consulta->bindParam(":nivel_escolaridad", $nivel_escolaridad);
		$consulta->bindParam(":nombre_colegio", $nombre_colegio);
		$consulta->bindParam(":fecha_graduacion", $fecha_graduacion);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

	}
	
		
		//Implementar un método para mostrar el formulario del estudiante
	public function verFormularioEstudiante($id_estudiante)
	{
		$sql="SELECT * FROM on_interesados WHERE id_estudiante= :id_estudiante";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
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

	    //traer el numero de whatsapp estudiantes
		public function traerCelularEstudiante($numero_documento){
			global $mbd;
			$hoy = date("Y-m-d");
			$sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
			$sentencia->bindParam(":numero_documento", $numero_documento);
			$sentencia->execute();
			$registro = $sentencia->fetch(PDO::FETCH_ASSOC);
			return $registro;
		}
	
		public function etiquetas()
		{
			global $mbd;
			$sentencia = $mbd->prepare(" SELECT * FROM `etiquetas` WHERE `etiqueta_dependencia` = 'Mercadeo'");
			$sentencia->execute();
			return $sentencia->fetchAll(PDO::FETCH_ASSOC);
		}
	
		public function cambiarEtiqueta($id_estudiante,$valor)
		{
			global $mbd;
			$sentencia = $mbd->prepare(" UPDATE `on_interesados` SET id_etiqueta= :valor WHERE id_estudiante= :id_estudiante");
			$sentencia->bindParam(":id_estudiante",$id_estudiante);
			$sentencia->bindParam(":valor",$valor);
			$sentencia->execute();
			$resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}
	
	
	
}

?>