<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class OncenterConsultas
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
	
	
    	//Implementar un método para mostrar los botones que activan las preguntas
	public function listar($periodo_campana)
	{
		$sql="SELECT id_estudiante,identificacion,fo_programa,jornada_e,nombre,nombre_2,apellidos,apellidos_2,fecha_nacimiento,celular,email,periodo_ingreso,fecha_ingreso,medio,conocio,contacto,nombre_modalidad,estado,segui,mailing,periodo_campana,formulario,inscripcion,entrevista,documentos,matricula,programa_m FROM on_interesados WHERE periodo_campana= :periodo_campana";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_campana", $periodo_campana);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	    

	
	
	//Implementar un método para listar los programas en un select
	public function selectCampana()
	{	
		$sql="SELECT * FROM on_periodo ORDER BY periodo DESC";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	

	
}

?>