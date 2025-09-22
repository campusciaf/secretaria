<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ConsultaVariablesPrograma
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
 	//Implementar un método para mostrar los botones que activan las preguntas
     public function listarbotones()
     {
         $sql="SELECT * FROM categoria WHERE categoria_estado=1";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }




    //Implementar un método para saber cuantas uuario pueden contestar la categoria
	public function totalUsuariosListosParaContestar($id_categoria,$programa,$jornada,$semestre,$periodo)
	{
		$programa_print="";
		$jornada_print="";
		$semestre_print="";
		$periodo_print="";
		
		if($programa=="todas"){$programa_print="";}else{$programa_print="cd.id_programa='$programa' and";}
		if($jornada=="todas"){$jornada_print="";}else{$jornada_print="cd.jornada='$jornada' and";}
		if($semestre=="todas"){$semestre_print="";}else{$semestre_print="cd.semestre='$semestre' and";}
		if($periodo=="todas"){$periodo_print="";}else{$periodo_print="est.periodo='$periodo'";}
		
		$sql="SELECT * FROM caracterizacion_data cd INNER JOIN estudiantes est ON cd.id_credencial=est.id_credencial WHERE $programa_print $jornada_print $semestre_print $periodo_print";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

        //Implementar un método para saber cuantas respuestas tenemos sobre la categoria
	public function totalUsuariosContestaronCategoria($id_credencial,$id_categoria)
	{
		$sql="SELECT * FROM caracterizacion WHERE  id_usuario= :id_credencial and id_categoria= :id_categoria ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
	}

	  //Implementar un método para saber cuantas usuario contestaron la pregunta
	  public function respuestas($id_categoria,$id_variable,$programa,$jornada,$semestre,$periodo)
	  {
		  $programa_print="";
		  $jornada_print="";
		  $semestre_print="";
		  $periodo_print="";
		  
		  if($programa=="todas"){$programa_print="";}else{$programa_print="cd.id_programa='$programa' and";}
		  if($jornada=="todas"){$jornada_print="";}else{$jornada_print="cd.jornada='$jornada' and";}
		  if($semestre=="todas"){$semestre_print="";}else{$semestre_print="cd.semestre='$semestre' and";}
		  if($periodo=="todas"){$periodo_print="";}else{$periodo_print="est.periodo='$periodo'";}
		  
		  $sql="SELECT * FROM caracterizacion_data cd INNER JOIN estudiantes est ON cd.id_credencial=est.id_credencial WHERE $programa_print $jornada_print $semestre_print $periodo_print";
		  global $mbd;
		  $consulta = $mbd->prepare($sql);
		  $consulta->execute();
		  $resultado = $consulta->fetchAll();
		  return $resultado;
	  }
	          //Implementar un método para saber cuantas respuestas tenemos sobre la categoria
	public function resultado($id_credencial,$id_variable)
	{
		$sql="SELECT * FROM caracterizacion WHERE  id_usuario= :id_credencial and id_variable= :id_variable ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
	}




	//Implementar un método para listar los estudiantes
	public function listarEstudiantes($id_categoria,$id_programa,$jornada_e,$semestre,$periodo)
	{
		$sql="SELECT * FROM caracterizacion_data cd INNER JOIN estudiantes est ON cd.id_credencial=est.id_credencial WHERE  cd.id_programa= :id_programa and cd.jornada= :jornada and cd.semestre= :semestre and est.periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada_e);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar los estudiantes
	public function listarEstudiantesContestaron($id_categoria,$id_programa,$jornada_e,$semestre,$periodo)
	{
		$sql="SELECT DISTINCT cd.id_credencial FROM caracterizacion_data cd INNER JOIN caracterizacion ct ON cd.id_credencial=ct.id_usuario INNER JOIN  estudiantes est ON cd.id_credencial=est.id_credencial WHERE ct.id_categoria= :id_categoria and cd.id_programa= :id_programa and cd.jornada= :jornada and cd.semestre= :semestre and est.periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":jornada", $jornada_e);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes
	public function listarEstudiantesDatos($id_credencial)
	{
		$sql="SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial INNER JOIN caracterizacion_data cd ON ce.id_credencial=cd.id_credencial WHERE ce.id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estudiantes
	public function listarEstudiantesDatosRespuesta($id_credencial,$id_categoria,$id_variable)
	{
		$sql="SELECT * FROM caracterizacion car INNER JOIN credencial_estudiante ce ON car.id_usuario=ce.id_credencial  WHERE car.id_usuario= :id_credencial and car.id_categoria= :id_categoria and car.id_variable= :id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para listar las variables
	public function listarVariable($id_categoria)
	{
		$sql="SELECT * FROM variables WHERE id_categoria= :id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para traer las opciones de las preguntas si es con select
	public function variableOpciones($id_variable)
	{
		$sql="SELECT * FROM variables_opciones WHERE id_variable= :id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para traer las opciones de las preguntas si es con select
	public function variableOpcionesRespuesta($respuesta)
	{
		$sql="SELECT * FROM variables_opciones WHERE id_variables_opciones= :respuesta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


    //Implementar un método para listar el tipo de pregunta
	public function listarTipoPregunta($id_tipo_pregunta)
	{	
		$sql="SELECT * FROM lista_tipo_pregunta  WHERE id_lista_tipo_pregunta= :id_tipo_pregunta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tipo_pregunta", $id_tipo_pregunta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    	//Implementar un método para listar los programas en un select
	public function selectPrograma()
	{	
		$sql="SELECT * FROM programa_ac WHERE estado=1";
		//return ejecutarConsulta($sql);	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
        //Implementar un método para listar los docentes activos
	public function selectJornada()
	{	
		$sql="SELECT * FROM jornada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
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

	function calculaEdad($fechanacimiento){
		list($ano, $mes, $dia) = explode("-", $fechanacimiento);
		$ano_diferencia  = date("Y") - $ano;
		$mes_diferencia = date("m") - $mes;
		$dia_diferencia   = date("d") - $dia;
		if ($dia_diferencia < 0 || $mes_diferencia < 0)
		$ano_diferencia--;
		return $ano_diferencia;
	}
	
}

?>

