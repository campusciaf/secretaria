<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class SacSeguimiento
{
	//Implementamos nuestro constructor
	public function __construct() {

	}

	//Implementamos un método para insertar una accion
	public function insertaroejecucion($nombre_accion, $id_meta, $fecha_accion, $fecha_fin){
		global $mbd;
		$sql="INSERT INTO `sac_accion`(`nombre_accion`,`id_meta`,`fecha_accion`, `fecha_fin` ) VALUES('$nombre_accion','$id_meta', '$fecha_accion', '$fecha_fin')";
		//echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


	//Implementamos un método para editar una accion
	public function editarejecucion($id_accion, $nombre_accion, $id_meta, $fecha_accion, $fecha_fin){
		$sql="UPDATE `sac_accion` SET `id_accion` = '$id_accion', `nombre_accion` = '$nombre_accion' , `id_meta` = '$id_meta', `fecha_accion` = '$fecha_accion' , `fecha_fin` = '$fecha_fin' WHERE `id_accion` = $id_accion";

		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;	
	}
	

	//Implementar un método para mostrar los datos de un registro a modificar
	public function listaracciones($id_meta){
		$sql = "SELECT * FROM `sac_accion` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_accion($id_accion){
		$sql = "SELECT * FROM `sac_accion` WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function eliminar_accion($id_accion){
		$sql = "DELETE FROM `sac_accion` WHERE `id_accion` = :id_accion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_accion", $id_accion);
		return $consulta->execute();
	}

	//Implementamos un método para editar la evidencia
	public function editarImagen($id_meta, $evidencia_imagen){
		$sql="UPDATE `sac_meta` SET `evidencia_imagen` = :evidencia_imagen, `accion_estado` = 1 WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta",$id_meta);
		$consulta->bindParam(":evidencia_imagen",$evidencia_imagen);
        $consulta->execute();
        return $consulta;	
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrarImagen($id_meta){
		$sql = "SELECT * FROM `sac_accion` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar la ejecucion
	public function listarmetaejecucion($meta_responsable, $periodo){	

		// SELECT `sac_meta`.`id_meta`, `sac_meta`.`meta_nombre`, `sac_meta`.`meta_fecha`,`sac_meta`.`evidencia_imagen`, `sac_meta`.`accion_estado`, `sac_objetivo_especifico`.`nombre_objetivo_especifico`, `sac_objetivo_general`.`nombre_objetivo`, `sac_ejes`.`nombre_ejes`, `usuario`.`id_usuario`, `usuario`.`usuario_poa` FROM ((((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`) INNER JOIN `usuario`) WHERE `sac_meta`.`meta_responsable` = 'Docente' AND `sac_meta`.`anio_eje` = 2022 AND  `usuario`.`usuario_poa` = 1;

		global $mbd;
		$sql="SELECT `sac_meta`.`id_meta`, `sac_meta`.`meta_nombre`, `sac_meta`.`meta_fecha`,`sac_meta`.`evidencia_imagen`, `sac_meta`.`accion_estado`, `sac_objetivo_especifico`.`nombre_objetivo_especifico`, `sac_objetivo_general`.`nombre_objetivo`, `sac_ejes`.`nombre_ejes` FROM (((`sac_meta` INNER JOIN `sac_objetivo_especifico` ON `sac_objetivo_especifico`.`id_objetivo_especifico` = `sac_meta`.`id_objetivo_especifico`) INNER JOIN `sac_objetivo_general` ON `sac_objetivo_especifico`.`id_objetivo` = `sac_objetivo_general`.`id_objetivo`) INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes`) WHERE `sac_meta`.`meta_responsable` = :meta_responsable AND `sac_meta`.`anio_eje` = :periodo ORDER BY `sac_ejes`.`nombre_ejes` DESC, `sac_objetivo_general`.`nombre_objetivo` DESC, `sac_objetivo_especifico`.`nombre_objetivo_especifico` DESC";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":meta_responsable", $meta_responsable);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar la ejecucion
	public function listarusuariopoa(){	
		global $mbd;
		$sql="SELECT * FROM `usuario` WHERE `usuario_poa` = 1";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	
	//Implementar un método para listar la ejecucion
	public function mostrarusuario($id_usuario){	
		global $mbd;
		$sql="SELECT * FROM `usuario` WHERE `id_usuario` = :id_usuario";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch();
		return $resultado;
	}

	//Implementar un método para listar las condiciones institucionales
	public function listarCondicionInstitucionalMeta ($id_meta){
		$sql= "SELECT * FROM `condiciones_institucionales` INNER JOIN `sac_meta_con_ins` ON `sac_meta_con_ins`.`id_con_ins` = `condiciones_institucionales`.`id_condicion_institucional` WHERE `id_meta` = :id_meta";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_meta', $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar las condiciones institucionales
	public function listarCondicionProgramaMeta($id_meta){
		$sql= "SELECT * FROM `condiciones_programa` INNER JOIN `sac_meta_con_pro` ON `sac_meta_con_pro`.`id_con_pro` = `condiciones_programa`.`id_condicion_programa` WHERE `id_meta` = :id_meta";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_meta', $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las condiciones institucionales
	public function listarCondicionDependencia($id_meta){
		$sql= "SELECT * FROM `dependencias` INNER JOIN `sac_meta_con_dep` ON `sac_meta_con_dep`.`id_con_dep` = `dependencias`.`id_dependencias` WHERE `id_meta` = :id_meta";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_meta', $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar las condiciones insitucioanles marcadas
	public function listarCondicionInstitucionalMarcada($id_meta){
		$sql = "SELECT * FROM `sac_meta_con_ins` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar las condiciones insitucioanles marcadas
	public function listarCondicionProgramaMarcada($id_meta){
		$sql = "SELECT * FROM `sac_meta_con_pro` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar las condiciones insitucioanles marcadas
	public function listarCondicionDependenciaMarcada($id_meta){
		$sql = "SELECT * FROM `sac_meta_con_dep` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los registros
	public function listarMeta($id_objetivo_especifico){	
		$sql= "SELECT * FROM `sac_meta` WHERE `id_objetivo_especifico` = :id_objetivo_especifico AND anio_eje=2022";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_objetivo_especifico', $id_objetivo_especifico);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	//Implementar un método para listar los compromisos
	public function listarObjetivoEspecifico($id_objetivo){	
		global $mbd;
		$sql="SELECT * FROM sac_objetivo_especifico WHERE id_objetivo = :id_objetivo";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_objetivo", $id_objetivo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
}

?>

