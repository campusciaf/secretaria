<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ResultadoVariables
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
    
    	//Implementar un método para listar los registros
	public function listar($id_categoria)
	{
		$sql="SELECT * FROM variables WHERE id_categoria= :id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	    	//Implementar un método para listar los estudiantes
	public function listarEstudiantes($id_categoria)
	{
		$sql="SELECT DISTINCT id_usuario FROM caracterizacion WHERE id_categoria= :id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
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
	public function listarEstudiantesRespuestas($id_categoria,$id_variable,$respuesta_id_variable)
	{
		$sql="SELECT * FROM caracterizacion car INNER JOIN credencial_estudiante ce ON car.id_usuario=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON car.id_usuario=edp.id_credencial INNER JOIN caracterizacion_data cd ON car.id_usuario=cd.id_credencial WHERE id_categoria= :id_categoria and id_variable= :id_variable and respuesta= :respuesta_id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->bindParam(":id_variable", $id_variable);
		$consulta->bindParam(":respuesta_id_variable", $respuesta_id_variable);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
	    	//Implementar un método para listar los registros
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
	
		    	//Implementar un método para listar el registro con el cual se enlazo la pregunta
	public function listarVariablePre($prerequisito)
	{
		$sql="SELECT * FROM variables WHERE id_variable= :prerequisito";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    
        	//Implementar un método para saber que opcion esta activa en los select
	public function listarActivo($respuesta)
	{
		$sql="SELECT * FROM variables_opciones WHERE id_variables_opciones= :respuesta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        //$consulta->bindParam(":id_variable", $id_variable);
        $consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	    
        	//Implementar un método para saber cual es la variable con que esta condicionando
	public function listarVariableCondiciona($prerequisito)
	{
		$sql="SELECT * FROM variables WHERE id_variable= :prerequisito";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	        	//Implementar un método para saber si la condicion es si o no
	public function listarVariableSiNo($prerequisito)
	{
		$sql="SELECT * FROM caracterizacion WHERE id_variable= :prerequisito";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		 //Implementar un método para saber la respuesta final de la condicion
	public function valor($respuesta)
	{
		$sql="SELECT * FROM variables_opciones WHERE id_variables_opciones= :respuesta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    
    
          	//Implementar un método para saber que opcion esta activa en los select
	public function listarDepActivo($respuesta)
	{
		$sql="SELECT * FROM departamentos WHERE departamento= :respuesta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        //$consulta->bindParam(":id_variable", $id_variable);
        $consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    
              	//Implementar un método para saber que opcion esta activa en los select
	public function listarMunActivo($respuesta)
	{
		$sql="SELECT * FROM municipios WHERE municipio= :respuesta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        //$consulta->bindParam(":id_variable", $id_variable);
        $consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	

    
        //Implementar un método para saber si ya contesto la variable
	public function verificarCampo($id_usuario,$id_variable)
	{
		$sql="SELECT * FROM caracterizacion WHERE id_usuario= :id_usuario and id_variable= :id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    
            //Implementar un método para saber cuantas respuestas tenemos sobre la categoria
	public function totalRespuestas($id_categoria)
	{
		$sql="SELECT * FROM caracterizacion WHERE id_categoria= :id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	 //Implementar un método para saber cuantas respuestas tenemos por respuestas cortas
	public function totalRespuestasVariable($id_variable)
	{
		$sql="SELECT * FROM caracterizacion WHERE id_variable= :id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	            //Implementar un método para saber cuantas variables realizo
	public function totalUsuarios($id_categoria)
	{
		$sql="SELECT DISTINCT id_usuario FROM caracterizacion WHERE id_categoria= :id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
    
            //Implementar un método para saber respuestas por variable
	public function respuestaPorVariable($id_categoria,$id_variable,$respuesta)
	{
		$sql="SELECT * FROM caracterizacion WHERE id_categoria= :id_categoria and id_variable= :id_variable and respuesta= :respuesta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
        $consulta->bindParam(":id_variable", $id_variable);
		$consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	 //Implementar un método para saber respuestas por variable departamento
	public function respuestaPorVariableDep($id_categoria,$id_variable)
	{
		$sql="SELECT DISTINCT respuesta FROM caracterizacion WHERE id_categoria= :id_categoria and id_variable= :id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
        $consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	 //Implementar un método para saber el total de respuestas por departamento
	public function respuestaTotalDep($departamento)
	{
		$sql="SELECT * FROM caracterizacion WHERE respuesta= :departamento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":departamento", $departamento);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
		 //Implementar un método para saber respuestas por variable fecha
	public function respuestaFecha($id_categoria,$id_variable)
	{
		$sql="SELECT * FROM caracterizacion WHERE id_categoria= :id_categoria and id_variable= :id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_categoria", $id_categoria);
        $consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
  
	public function edad($fecha_nacimiento) { 
		$tiempo = strtotime($fecha_nacimiento); 
		$ahora = time(); 
		$edad = ($ahora-$tiempo)/(60*60*24*365.25); 
		$edad = floor($edad); 
		return $edad; 
	} 
       	//Implementar un método para listar los values de los select
	public function listarVariableOpciones($id_variable)
	{
		$sql="SELECT * FROM variables_opciones WHERE id_variable= :id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_categoria)
	{
		$sql="SELECT * FROM categoria WHERE id_categoria= :id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para listar el tipo de pregunta
	public function selectTipoPregunta()
	{	
		$sql="SELECT * FROM lista_tipo_pregunta";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
    
    //Implementar un método para listar las escuelas
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
    
    	//Implementar un método para listar los departamentos en un select
	public function selectDepartamento()
	{	
		$sql="SELECT * FROM departamentos";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
    
    //Implementar un método para listar los municipios en un select
	public function selectMunicipio()
	{	
		$sql="SELECT * FROM municipios ";
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