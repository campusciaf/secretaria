<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class SacObjectivosGenerales
{
	//Implementamos nuestro constructor
	public function __construct() {

	}
	//Implementamos un método para agregar un objetivo general
	public function insertarObjetivoGeneral($nombre_objetivo, $id_ejes){
		global $mbd;
		$sql="INSERT INTO `sac_objetivo_general`(`nombre_objetivo`, `id_ejes`) VALUES('$nombre_objetivo', '$id_ejes')";
		echo $sql;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar registros
	public function editarobjetivogeneral($id_objetivo,$nombre_objetivo){
		$sql="UPDATE `sac_objetivo_general` SET `id_objetivo` = '$id_objetivo', `nombre_objetivo` = '$nombre_objetivo' WHERE `id_objetivo` = '$id_objetivo'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
	public function eliminar_objetivo_especifico($id_objetivo_especifico){
		$sql = "DELETE FROM `sac_objetivo_especifico` WHERE `id_objetivo_especifico` = :id_objetivo_especifico";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_objetivo_especifico", $id_objetivo_especifico);
		return $consulta->execute();
	}
	
	public function eliminar_objetivo_general($id_objetivo){
		$sql = "DELETE FROM `sac_objetivo_general` WHERE `id_objetivo` = :id_objetivo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_objetivo", $id_objetivo);
		return $consulta->execute();
	}
	//Implementar un método para listar los compromisos
	public function listarObjetivoGeneral($id_ejes){	
		global $mbd;
		$sql="SELECT * FROM `sac_objetivo_general` INNER JOIN `sac_ejes` ON `sac_ejes`.`id_ejes` = `sac_objetivo_general`.`id_ejes` WHERE `sac_objetivo_general`.`id_ejes` = :id_ejes";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ejes", $id_ejes);
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
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_objetivos_especificos($id_objetivo_especifico){
		$sql = "SELECT * FROM `sac_objetivo_especifico` WHERE `id_objetivo_especifico` = :id_objetivo_especifico";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_objetivo_especifico", $id_objetivo_especifico);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para agregar un objetivo general
	public function sacinsertometa($meta_nombre, $meta_fecha, $meta_responsable, $id_objetivo_especifico, $id_con_ins, $id_con_pro, $id_con_dep, $anio_eje){
		global $mbd;
		$sql = "INSERT INTO `sac_meta`(`meta_nombre`, `meta_fecha`, `id_objetivo_especifico`, `meta_responsable`,`anio_eje`) VALUES('$meta_nombre', '$meta_fecha', '$id_objetivo_especifico', '$meta_responsable', $anio_eje)";
		$consulta = $mbd->prepare($sql);
		if($consulta->execute()){
			$id_meta = $mbd->lastInsertId();
			//insertar las condiciones institucionales
			for ($i=0; $i < count($id_con_ins) ; $i++) { 
				$sql_detalle = "INSERT INTO `sac_meta_con_ins`(`id_con_ins`, `id_meta`) VALUES('".$id_con_ins[$i]."', $id_meta)";
				$consulta2 = $mbd->prepare($sql_detalle);
				$consulta2->execute();
			}
			// insertar codiciones de programa
			for($i = 0; $i < count($id_con_pro); $i++){
				$sql_detalle_2 = "INSERT INTO `sac_meta_con_pro`(`id_con_pro`, `id_meta`) VALUES('" . $id_con_pro[$i] . "', $id_meta)";
				$consulta3 = $mbd->prepare($sql_detalle_2);
				$consulta3->execute();
			}
			// insertar dependencias
			for($i = 0; $i < count($id_con_dep); $i++){
				$sql_detalle_4 = "INSERT INTO `sac_meta_con_dep`(`id_con_dep`, `id_meta`) VALUES('" . $id_con_dep[$i] . "', $id_meta)";
				$consulta4 = $mbd->prepare($sql_detalle_4);
				$consulta4->execute();
			}
			return true;
		}else{
			return false;
		}
	}
	
	//Implementar un método para eliminar los datos de un registro 
	public function eliminar_con_ins($id_meta){
		$sql = "DELETE FROM `sac_meta_con_ins` WHERE `id_meta` = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
	}
	
	//Implementar un método para eliminar los datos de un registro 
	public function eliminar_con_pro($id_meta){
		$sql = "DELETE FROM `sac_meta_con_pro` WHERE `id_meta` = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
	}

	//Implementar un método para eliminar los datos de un registro 
	public function eliminar_con_dep($id_meta){
		$sql = "DELETE FROM `sac_meta_con_dep` WHERE `id_meta` = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
	}
	
	//Implementamos unç método para editar registros
	public function saceditometa($id_meta, $meta_nombre, $meta_fecha, $meta_responsable, $id_objetivo_especifico, $id_con_ins, $id_con_pro, $id_con_dep, $anio_eje){
		$sql = "UPDATE `sac_meta` SET  `meta_nombre` = '$meta_nombre',  `meta_fecha` = '$meta_fecha', `meta_responsable` = '$meta_responsable', `anio_eje` = '$anio_eje' WHERE `id_meta` = '$id_meta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);	
		if($consulta->execute()){
			//insertar las condiciones institucionales
			for ($i = 0; $i < count($id_con_ins); $i++) {
				$sql_detalle = "INSERT INTO `sac_meta_con_ins`(`id_con_ins`, `id_meta`) VALUES('" . $id_con_ins[$i] . "', $id_meta)";
				$consulta2 = $mbd->prepare($sql_detalle);
				$consulta2->execute();
			}
			// insertar codiciones de programa
			for ($i = 0; $i < count($id_con_pro); $i++) {
				$sql_detalle_2 = "INSERT INTO `sac_meta_con_pro`(`id_con_pro`, `id_meta`) VALUES('" . $id_con_pro[$i] . "', $id_meta)";
				$consulta3 = $mbd->prepare($sql_detalle_2);
				$consulta3->execute();
			}
			// insertar codiciones de programa
			for ($i = 0; $i < count($id_con_dep); $i++) {
				$sql_detalle_3 = "INSERT INTO `sac_meta_con_dep`(`id_con_dep`, `id_meta`) VALUES('" . $id_con_dep[$i] . "', $id_meta)";
				$consulta4 = $mbd->prepare($sql_detalle_3);
				$consulta4->execute();
			}
			return true;
		}else{
			return false;
		}
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrarMetaEdito($id_objetivo)
	{
		$sql="SELECT * FROM sac_objetivo_especifico WHERE id_objetivo= :id_objetivo";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_objetivo", $id_objetivo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	// //Implementar un método para mostrar las metas de los compromisos
	// public function mostrarMeta($id_ejes,$meta_anio)
	// {
	// 	$sql="SELECT * FROM sac_meta3 WHERE id_ejes= :id_ejes AND meta_anio='$meta_anio'";
	// 	global $mbd;
	// 	$consulta = $mbd->prepare($sql);
	// 	$consulta->bindParam(":id_ejes", $id_ejes);
	// 	$consulta->execute();
	// 	$resultado = $consulta->fetchAll();
	// 	return $resultado;
	// }

	public function eliminar_meta($id_meta)
	{
		$sql = "DELETE FROM `sac_meta` WHERE `id_meta` = :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		return $consulta->execute();
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_objetivo)
	{
		$sql="SELECT * FROM sac_objetivo_especifico WHERE id_objetivo= :id_objetivo";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_objetivo", $id_objetivo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

		//Implementar un metodo para buscar el periodo
		public function buscarperiodo()
		{	
			$sql="SELECT * FROM periodo_actual WHERE id='1'";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}


		//Implementar un método para listar las condiciones institucionales
		public function listarCondicionesInstitucionales()
		{
			$sql="SELECT * FROM condiciones_institucionales";
			//return ejecutarConsulta($sql);
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		//Implementar un método para listar las condiciones institucionales
		public function listarCondicionInstitucionalMeta($id_meta){
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
		public function listarCondicionDependencia($id_meta){
			$sql = "SELECT * FROM `sac_meta_con_dep` WHERE `id_meta` = :id_meta";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_meta", $id_meta);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para imrpimir el eje 
		public function buscarEjes($id_ejes)
		{
			$sql="SELECT * FROM sac_ejes WHERE id_ejes='".$id_ejes."'";
			//return ejecutarConsulta($sql);
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->execute();
			//$consulta->bindParam(":id_ejes", $id_ejes);
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
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

		//Implementar un método para listar las condiciones de programa marcadas
		public function listarcondicionesmarcadasprograma($id_meta)
		{
			$sql="SELECT * FROM meta_con_pro WHERE id_meta_2= :id_meta";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_meta", $id_meta);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para listar las condiciones de programa marcadas
		public function listarcondicionesdependencia($id_meta)
		{
			$sql="SELECT * FROM `dependencias` INNER JOIN `sac_meta_con_dep` ON `sac_meta_con_dep`.`id_con_dep` = `dependencias`.`id_dependencias` WHERE `id_meta` = :id_meta";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_meta", $id_meta);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para listar las condiciones de programa
		public function listarCondicionesPrograma()
		{
			$sql="SELECT * FROM condiciones_programa";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para listar las condiciones de programa
		public function listardependencias()
		{
			$sql="SELECT * FROM `dependencias` where `ayuda` =1";
			global $mbd;
			// echo $sql;
			$consulta = $mbd->prepare($sql);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para mostrar los datos de un registro a modificar
		public function mostrarMetaEditar($id_meta)
		{
			$sql="SELECT * FROM sac_meta WHERE id_meta= :id_meta";
			//return ejecutarConsultaSimpleFila($sql);
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_meta", $id_meta);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//Implementar un método para mostrar los datos de un registro a modificar
		public function mostrar_objetivos_generales($id_objetivo){
			$sql = "SELECT * FROM `sac_objetivo_general` WHERE `id_objetivo` = :id_objetivo";
			//return ejecutarConsultaSimpleFila($sql);
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_objetivo", $id_objetivo);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

	
		//Implementar un método para mostrar los datos de un registro a modificar
		public function mostrar_editar_meta($id_meta){
		$sql = "SELECT * FROM `sac_meta` WHERE `id_meta` = :id_meta";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta",$id_meta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


		//Implementar un método para eliminar los datos de un registro 
		public function eliminarmeta2($id_objetivo_especifico)
		{
			$sql="DELETE FROM sac_objetivo_especifico WHERE id_objetivo_especifico = :id_objetivo_especifico ";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_objetivo_especifico ", $id_objetivo_especifico );
			$consulta->execute();
		}

	
		public function selectlistarCargo()
		{	
			$sql="SELECT * FROM usuario";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;		
		}
	

		//Implementar un método para listar los registros
		public function listarMeta($id_objetivo_especifico){	
			$sql= "SELECT * FROM `sac_meta` WHERE `id_objetivo_especifico` = :id_objetivo_especifico ";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(':id_objetivo_especifico', $id_objetivo_especifico);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;		
		}

		//Implementar un método para eliminar los datos de un registro 
		public function eliminar($id_objetivo)
		{
			global $mbd;
			//Eliminamos la meta
			$sql1="DELETE FROM sac_objetivo_especifico WHERE id_objetivo_especifico= id_objetivo_especifico";
			$consulta1 = $mbd->prepare($sql1);
			$consulta1->bindParam(":id_objetivo", $id_objetivo);
			$consulta1->execute();
			$consulta1->fetch(PDO::FETCH_ASSOC);
		
		// //Eliminamos todos las condiciones institucionales de la meta
		// $sqldel="DELETE FROM sac_meta_con_ins WHERE id_compromiso_con_ins= :id_compromiso_con_ins";
		// $consulta2 = $mbd->prepare($sqldel);
		// $consulta2->bindParam(":id_compromiso_con_ins", $id_compromiso_con_ins);
		// $consulta2->execute();
		// $resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		
		// //Eliminamos todos las condiciones programa de la meta
		// $sqldel3="DELETE FROM sac_meta_con_pro WHERE id_compromiso_2= :id_compromiso";
		// $consulta3 = $mbd->prepare($sqldel3);
		// $consulta3->bindParam(":id_objetivo_especifico", $id_objetivo_especifico);
		// $consulta3->execute();
		// $resultado3 = $consulta3->fetch(PDO::FETCH_ASSOC);
			

		//Eliminamos el compromiso
		$sql="DELETE FROM sac_meta3 WHERE id_meta = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta ", $id_meta );
		return $consulta->execute();
	}

	//Implementar un método para eliminar las metas cuando se eliminar el compromiso
	public function eliminarCompromisoMeta($id_meta)
	{
		$sql="DELETE FROM sac_meta WHERE id_meta = :id_meta ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta ", $id_meta );
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
}

?>