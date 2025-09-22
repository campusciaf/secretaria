<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Variables
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar categorias
	public function insertar($categoria_nombre,$categoria_publico,$imagen,$categoria_estado)
	{
		$sql="INSERT INTO categoria (categoria_nombre,categoria_publico,categoria_imagen,categoria_estado)
		VALUES ('$categoria_nombre','$categoria_publico','$imagen','$categoria_estado')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
    
    //Implementamos un método para insertar variable
	public function insertarvariable($id_categoria,$id_tipo_pregunta,$variable,$obligatorio)
	{
		$sql="INSERT INTO variables (id_categoria,id_tipo_pregunta,nombre_variable,obligatoria)
		VALUES ('$id_categoria','$id_tipo_pregunta','$variable','$obligatorio')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	} 
    
    //Implementamos un método para insertar una opcion
	public function insertaropcion($id_variable,$nombre_opcion)
	{
		$sql="INSERT INTO variables_opciones (id_variable,nombre_opcion)
		VALUES ('$id_variable','$nombre_opcion')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
		//Implementamos un método para editar registros
	public function editar($id_categoria,$categoria_nombre,$categoria_publico,$categoria_imagen,$categoria_estado)
	{
		$sql="UPDATE categoria SET categoria_nombre='$categoria_nombre', categoria_publico='$categoria_publico', categoria_imagen='$categoria_imagen',categoria_estado='$categoria_estado'  WHERE id_categoria='$id_categoria'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();

	}
	
		//Implementamos un método para crear la condición
	public function prerequisito($id_variable,$prerequisito)
	{
		$sql="UPDATE variables SET prerequisito='$prerequisito' WHERE id_variable='$id_variable'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();

	}
	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
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
    
        	//Implementar un método para listar los registros de la varaible select que se le agrego una nueva opción
	public function listarVariableRecargar($id_variable)
	{
		$sql="SELECT * FROM variables WHERE id_variable= :id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
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
		$sql="SELECT * FROM municipios";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	        //Implementar un método para listar los municipios en un select
	public function selectCondicion()
	{	
		$sql="SELECT * FROM variables WHERE id_tipo_pregunta=7 ";
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
	
	
		//Implementamos un método para desactivar programa
	public function desactivar($id_programa)
	{
		$sql="UPDATE programa_ac SET estado='0' WHERE id_programa= :id_programa";
		//return ejecutarConsulta($sql);
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	
		//Implementamos un método para activar programa
	public function activar($id_programa)
	{
		$sql="UPDATE programa_ac SET estado='1' WHERE id_programa= :id_programa";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function editar_pregunta_variables($nombre_variable, $id_variable){
		$sql="UPDATE `variables` SET `nombre_variable` = '$nombre_variable' WHERE `id_variable` = $id_variable";
		// echo $sql;

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}
	
}

?>