<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Caracterizacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementar un método para traer los datos personales
	public function datosestudiante($id_credencial)
	{
		$sql = "SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes est ON ce.id_credencial=est.id_credencial WHERE ce.id_credencial= :id_credencial and est.estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_variable", $id_variable);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para insertar data
	public function insertardata($id_credencial, $id_programa, $jornada, $semestre, $fecha_respuesta, $periodo){
		$sql = "INSERT INTO caracterizacion_data (id_credencial,id_programa,jornada,semestre,fecha,periodo)
		VALUES ('$id_credencial','$id_programa','$jornada','$semestre','$fecha_respuesta','$periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para insertar variable
	public function insertar($id_usuario, $id_categoria, $id_variable, $respuesta, $fecha_respuesta, $hora_respuesta){
		$id_categoria = (empty($id_categoria))?NULL: $id_categoria;
		$id_variable = (empty($id_variable))?NULL: $id_variable;
		$sql = "INSERT INTO caracterizacion (id_usuario,id_categoria,id_variable,respuesta,fecha_respuesta,hora_respuesta)
		VALUES ('$id_usuario', :id_categoria, :id_variable,'$respuesta','$fecha_respuesta','$hora_respuesta')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->bindParam(":id_variable", $id_variable);
		return $consulta->execute();
	}

	//Implementamos un método para editar registros de los campos
	public function editar($id_caracterizacion, $id_usuario, $id_variable, $respuesta, $fecha_respuesta, $hora_respuesta)
	{
		$sql = "UPDATE caracterizacion SET respuesta='$respuesta', fecha_respuesta='$fecha_respuesta', hora_respuesta='$hora_respuesta' WHERE id_caracterizacion='$id_caracterizacion'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para insertar una opcion
	public function insertaropcion($id_variable, $nombre_opcion)
	{
		$sql = "INSERT INTO variables_opciones (id_variable,nombre_opcion)
		VALUES ('$id_variable','$nombre_opcion')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


	//Implementar un método para traer los datos personales
	public function aceptoData($id_credencial)
	{
		$sql = "SELECT * FROM caracterizacion_data WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_variable", $id_variable);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



	//Implementar un método para mostrar los botones que activan las preguntas
	public function listarbotones()
	{
		$sql = "SELECT * FROM categoria WHERE categoria_estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function listar($id_categoria)
	{
		$sql = "SELECT * FROM variables WHERE id_categoria= :id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para traer los datos personales
	public function datosPersonales($id_credencial)
	{
		$sql = "SELECT * FROM estudiantes_datos_personales WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_variable", $id_variable);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementar un método para saber que opcion esta activa en los select
	public function listarActivo($respuesta)
	{
		$sql = "SELECT * FROM variables_opciones WHERE id_variables_opciones= :respuesta";
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
		$sql = "SELECT * FROM variables WHERE id_variable= :prerequisito";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para saber si la condicion es si o no
	public function listarVariableSiNo($prerequisito, $id_usuario)
	{
		$sql = "SELECT * FROM caracterizacion WHERE id_variable= :prerequisito and id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para saber la respuesta final de la condicion
	public function valor($respuesta)
	{
		$sql = "SELECT * FROM variables_opciones WHERE id_variables_opciones= :respuesta";
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
		$sql = "SELECT * FROM departamentos WHERE departamento= :respuesta";
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
		$sql = "SELECT * FROM municipios WHERE municipio= :respuesta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_variable", $id_variable);
		$consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para saber si ya contesto la variable
	public function verificarCampo($id_usuario, $id_variable)
	{
		$sql = "SELECT * FROM caracterizacion WHERE id_usuario= :id_usuario and id_variable= :id_variable";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para saber cuantas variables realizo
	public function totalRespuestas($id_usuario, $id_categoria)
	{
		$sql = "SELECT * FROM caracterizacion WHERE id_usuario= :id_usuario and id_categoria= :id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para listar los values de los select
	public function listarVariableOpciones($id_variable)
	{
		$sql = "SELECT * FROM variables_opciones WHERE id_variable= :id_variable";
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
		$sql = "SELECT * FROM categoria WHERE id_categoria= :id_categoria";
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
		$sql = "SELECT * FROM lista_tipo_pregunta";
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
		$sql = "SELECT * FROM lista_tipo_pregunta  WHERE id_lista_tipo_pregunta= :id_tipo_pregunta";
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
		$sql = "SELECT * FROM departamentos";
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
		$sql = "SELECT * FROM municipios ";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}



	//Implementar un método para mostrar los datos de un registro a modificar
	public function datosVariablesHead($id_categoria)
	{
		$sql = "SELECT * FROM variables WHERE id_categoria=:id_categoria";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_categoria", $id_categoria);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function respuestaUno($id_credencial, $id_variable)
	{
		$sql = "SELECT id_usuario,id_variable,respuesta FROM caracterizacion  WHERE id_usuario= :id_credencial and id_variable= :id_variable";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":id_variable", $id_variable);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function respuesta($respuesta)
	{
		$sql = "SELECT * FROM variables_opciones WHERE id_variables_opciones= :respuesta";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":respuesta", $respuesta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function consultarregistro($id_usuario, $tabla)
	{

		$sql = "SELECT * FROM $tabla WHERE id_credencial= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function crearregistro($id_usuario, $tabla)
	{

		$sql = "INSERT INTO $tabla (id_credencial)
			VALUES ('$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	public function actualizarcampo($id_usuario, $tabla, $respuesta, $campotabla)
	{

		$sql = "UPDATE $tabla SET r$campotabla='$respuesta' WHERE id_credencial='$id_usuario'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	public function actualizarestado($id_usuario, $tabla, $fecha_respuesta, $hora_respuesta)
	{
		$sql = "UPDATE $tabla SET estado='0', fecha='$fecha_respuesta', hora='$hora_respuesta' WHERE id_credencial='$id_usuario'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
}
