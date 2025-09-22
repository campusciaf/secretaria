<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class AdminCalendario
{

	//Implementamos nuestro constructor
	public function __construct(){

	}

	//Traemos los datos que llenen el calendario
	public function mostrarEventos(){
		$sql_leer="SELECT id_actividad as id, actividad as title, fecha_inicio as start, fecha_final as end, color FROM calendario";
		global $mbd;
		$consulta_leer = $mbd->prepare($sql_leer);
		$consulta_leer->execute();
		$resultado_leer = $consulta_leer->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_leer;
	}

	//Insertar evento en la base de datos
	public function insertarEventos($actividad,$fecha_inicio,$fecha_final,$color){
		$sql_insertar="INSERT INTO calendario (actividad,fecha_inicio,fecha_final,color) VALUES(:actividad,:fecha_inicio,:fecha_final,:color)";

		global $mbd;
		$consulta_insertar = $mbd->prepare($sql_insertar);
		$consulta_insertar->execute(array(
			"actividad" => $actividad,
			"fecha_inicio" => $fecha_inicio,
			"fecha_final" => $fecha_final,
			"color" => $color
		));
		return $consulta_insertar;
		
	}

	//Eliminar evento de la base de datos
	public function eliminarEventos($id){
		$sql_eliminar = "DELETE FROM calendario WHERE id_actividad=:id";

		global $mbd;
		$consulta_eliminar = $mbd->prepare($sql_eliminar);
		$consulta_eliminar->execute(array(
			"id" => $id));
		return $consulta_eliminar;
	}

	//Modificar evento de la base de datos
	public function modificarEventos($id,$actividad,$fecha_inicio,$fecha_final,$color){
		$sql_modificar = "UPDATE calendario SET actividad=:actividad, fecha_inicio=:fecha_inicio,fecha_final=:fecha_final,color=:color WHERE id_actividad=:id";

		global $mbd;
		$consulta_modificar = $mbd->prepare($sql_modificar);
		$consulta_modificar->execute(array(
			"id" => $id,
			"actividad" => $actividad,
			"fecha_inicio" => $fecha_inicio,
			"fecha_final" => $fecha_final,
			"color" => $color));
		return $consulta_modificar;
	}
}


?>
