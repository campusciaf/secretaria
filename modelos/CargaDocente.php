<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CargaDocente
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
	
	

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM docente WHERE usuario_condicion=1";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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


	
	//Implementar un método para listar los registros
	public function listarGrupos($id_usuario,$periodo)
	{
		$sql="SELECT * FROM docente_grupos WHERE id_docente= :id_usuario and periodo= :periodo and (fusion_salon ='1' and fusion_docente='1')";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}
	
	//Implementar un método para listar los dias en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo order by periodo DESC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar las horas de la noche
	public function listarHorasDia()
	{
		$sql="SELECT * FROM horas_del_dia";// mayor a 48, para que coja la jornada de la noche
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}
	
	//Implementar un método para traer las clase que corresponde al filtro
	public function docenteGrupos($id_docente,$periodo,$dia)
	{
		$sql="SELECT * FROM docente_grupos dg INNER JOIN horas_grupos hg ON dg.id_docente_grupo=hg.id_docente_grupo WHERE  dg.id_docente= :id_docente and dg.periodo= :periodo and hg.dia= :dia";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":dia", $dia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para mostrar los datos de un programa seleccionado
	public function mostrarDatosPrograma($id_programa)
	{
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
	//Implementar un método para mostrar los datos de docente
	public function mostrarDatosDocente($id_docente)
	{
		$sql="SELECT * FROM docente WHERE id_usuario= :id_docente";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function mostrarhorasaconvenir($id_usuario)
    {

        global $mbd;
        $sentencia = $mbd->prepare("SELECT `escuela`, `observacion` FROM `horas_a_convenir` where `id_usuario` = :id_usuario");
        // echo $sentencia;
		$sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->execute();
		
        $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;

    }

	//Implementamos un método para insertar el estado que se guarda en on_cambioestado
	public function insertarconvenir( $id_convenir, $id_usuario, $escuela, $observacion)
	{	

		$sql="INSERT INTO `horas_a_convenir`(`id_convenir`, `id_usuario`, `escuela`, `observacion`)
		VALUES ('$id_convenir','$id_usuario','$escuela','$observacion')";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);	
		return $consulta->execute();
	}
	
	//Implementamos un método para insertar el estado que se guarda en on_cambioestado
	public function editarconvenir($id_convenir, $id_usuario, $escuela, $observacion)
	{	

		$sql="UPDATE `horas_a_convenir` SET `id_convenir`='$id_convenir',`id_usuario`='$id_usuario',`escuela`='$escuela',`observacion`='$observacion' WHERE $id_convenir";
		// echo $sql;	
		global $mbd;
		$consulta = $mbd->prepare($sql);	
		return $consulta->execute();
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

	

}

?>