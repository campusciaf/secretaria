<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Programa{
	//Implementamos nuestro constructor
	public function __construct(){
	}
	// nombre, cod_programa_pea, ciclo, cod_snies, pertenece, cant_asignaturas, semestres, inicio_semestre, original, estado, estado_nuevos, estado_activos, estado_graduados, panel_academico, por_renovar, escuela, universidad, relacion, carnet, corte, corte1, corte2, corte3, corte4, corte5, corte6, corte7, corte8, corte9, corte10 
	//Implementamos un método para insertar registros
	public function insertar($nombre, $cod_programa_pea, $ciclo, $cod_snies, $pertenece, $cant_asignaturas, $semestres, $inicio_semestre, $original, $estado, $estado_nuevos, $estado_activos, $estado_graduados, $panel_academico, $por_renovar, $escuela, $universidad, $terminal, $relacion, $programa_director,$centro_costo_yeminus, $codigo_producto, $carnet, $corte, $corte1, $corte2, $corte3, $corte4, $corte5, $corte6, $corte7, $corte8, $corte9, $corte10){
		$sql="INSERT INTO programa_ac (nombre, cod_programa_pea, ciclo, cod_snies, pertenece, cant_asignaturas, semestres, inicio_semestre, original, estado, estado_nuevos, estado_activos, estado_graduados, panel_academico, por_renovar, escuela, universidad, terminal, relacion, programa_director, centro_costo_yeminus, codigo_producto, carnet, cortes, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10)
		VALUES ('$nombre', '$cod_programa_pea', '$ciclo', '$cod_snies', '$pertenece', '$cant_asignaturas', '$semestres', '$inicio_semestre', '$original', '$estado', '$estado_nuevos', '$estado_activos', '$estado_graduados', '$panel_academico', '$por_renovar', '$escuela', '$universidad', '$terminal', '$relacion', '$programa_director', '$centro_costo_yeminus', '$codigo_producto', '$carnet', '$corte', '$corte1', '$corte2', '$corte3', '$corte4', '$corte5', '$corte6', '$corte7', '$corte8', '$corte9', '$corte10' )";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para editar registros
	public function editar($id_programa, $nombre, $cod_programa_pea, $ciclo, $cod_snies, $pertenece, $cant_asignaturas, $semestres, $inicio_semestre, $original, $estado, $estado_nuevos, $estado_activos, $estado_graduados, $panel_academico, $por_renovar, $escuela, $universidad, $terminal, $relacion, $programa_director, $centro_costo_yeminus, $codigo_producto, $carnet){
		$sql="UPDATE programa_ac SET nombre = '$nombre', cod_programa_pea = '$cod_programa_pea', cod_snies = '$cod_snies', pertenece = '$pertenece', cant_asignaturas = '$cant_asignaturas', semestres = '$semestres',  inicio_semestre = '$inicio_semestre', original = '$original', estado = '$estado', estado_nuevos = '$estado_nuevos', estado_activos = '$estado_activos', estado_graduados = '$estado_graduados', panel_academico = '$panel_academico',  por_renovar = '$por_renovar', escuela = '$escuela', universidad = '$universidad', terminal = '$terminal', relacion = '$relacion', programa_director = '$programa_director', `centro_costo_yeminus` = '$centro_costo_yeminus', `codigo_producto` = '$codigo_producto', carnet = '$carnet' WHERE `id_programa` = '$id_programa'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para listar los registros
	public function listar(){
		$sql="SELECT * FROM programa_ac";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos del programa
	public function mostrar($id_programa){
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa",  $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las escuelas
	public function selectEscuela(){	
		$sql="SELECT * FROM escuelas";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para desactivar programa
	public function desactivar($id_programa){
		$sql="UPDATE programa_ac SET estado = '0' WHERE id_programa= :id_programa";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa",  $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para activar programa
	public function activar($id_programa){
		$sql="UPDATE programa_ac SET estado='1' WHERE id_programa= :id_programa";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa",  $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//implementar promedio de cada corte
	public function agregarcorte($c1, $c2, $c3, $c4, $c5, $c6, $cantidad, $id){
		global $mbd;
		$data = array(
			'1'=> $c1, 
			'2'=> $c2, 
			'3'=> $c3, 
			'4'=> $c4, 
			'5'=> $c5, 
			'6'=> $c6
		);
		for ($i=0; $i < $cantidad; $i++) {
			$v = $data[($i+1)];
			$c = "c".($i+1);
			$sentencia = $mbd->prepare(" INSERT INTO `cortes_programas`(`id_programa`,  `corte_programa`,  `valor_corte`) VALUES ('$id',  '$c' ,  '$v') ");
			if(!$sentencia->execute()){
				$dato['status'] = die("Error al agregar el corte".($i+1));
			}else {
				$dato['status'] = "ok";
				$dato['result'] = "Cortes agregados con exito.";
			}
		}
		echo json_encode($dato);
	}
	public function consultaCortes($id_programa){
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT * FROM `cortes_programas` WHERE id_programa = :id ");
		$sentencia->bindParam(":id",  $id_programa);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		if ($registro) {
			return $registro;
		} else {
			return false; 
		}
	}
	public function editarcorte($c1, $c2, $c3, $c4, $c5, $c6, $cantidad, $id, $id1, $id2, $id3, $id4, $id5, $id6){
		global $mbd;
		$data = array(
			'1'=> $c1, 
			'2'=> $c2, 
			'3'=> $c3, 
			'4'=> $c4, 
			'5'=> $c5, 
			'6'=> $c6
		);
		$id_t = array(
			'1'=> $id1, 
			'2'=> $id2, 
			'3'=> $id3, 
			'4'=> $id4, 
			'5'=> $id5, 
			'6'=> $id6
		);
		for ($i=0; $i < $cantidad; $i++) {
			$v = $data[($i+1)];
			$id_i = $id_t[($i+1)];
			$sentencia = $mbd->prepare(" UPDATE `cortes_programas` SET `valor_corte`= '$v'  WHERE `id_corte_programa` = '$id_i' ");
			if(!$sentencia->execute()){
				$dato['status'] = die("Error al agregar el corte".($i+1));
			}else {
				$dato['status'] = "ok";
				$dato['result'] = "Cortes actualiazados con exito.";
			}
		}
		echo json_encode($dato);
	}
	//Implementar un método para traer el periodo pecuniario
	public function traerperiodopecuniario(){
		$sql="SELECT periodo_pecuniario FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		// $consulta->bindParam(":id_programa",  $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}	
	//Implementar un método para traer el valor del derecho pecuniario si es que lo tiene
	public function lista_precio_pecuniario($id_programa, $periodo_pecuniario){
		$sql="SELECT * FROM lista_precio_pecuniario WHERE id_programa= :id_programa and periodo= :periodo_pecuniario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa",  $id_programa);
		$consulta->bindParam(":periodo_pecuniario",  $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar el valor pecuniario
	public function guardarpecuniario($id_programa_monetizar, $valor_pecuniario, $periodo_pecuniario){
		$sql="INSERT INTO lista_precio_pecuniario(id_programa, valor_pecuniario, periodo)
		VALUES ('$id_programa_monetizar', '$valor_pecuniario', '$periodo_pecuniario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para guardar el valor pecuniario por semestre
	public function guardarsemestres($id_programa_monetizar_semestres, $periodo_pecuniario, $semestrep, $matricula_ordinaria, $aporte_social, $matricula_extraordinaria, $valor_por_credito, $pago_renovar){
		$sql="INSERT INTO lista_precio_programa(id_programa, periodo, semestre, matricula_ordinaria, aporte_social, matricula_extraordinaria, valor_por_credito, pago_renovar)
		VALUES ('$id_programa_monetizar_semestres', '$periodo_pecuniario', '$semestrep', '$matricula_ordinaria', '$aporte_social', '$matricula_extraordinaria', '$valor_por_credito', '$pago_renovar')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para mostrar los precios del programa por semestre
	public function tablaprecios($id_programa, $periodo_pecuniario){
		$sql="SELECT * FROM lista_precio_programa WHERE id_programa= :id_programa and periodo= :periodo_pecuniario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa",  $id_programa);
		$consulta->bindParam(":periodo_pecuniario",  $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}	
	//Implementar un método para eliminar el valor de la tabla lista_precio_programa
	public function eliminar($id_lista_precio_programa){
		$sql="DELETE FROM lista_precio_programa WHERE id_lista_precio_programa= :id_lista_precio_programa"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_lista_precio_programa",  $id_lista_precio_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos del docente
	public function mostrareditar($id_lista_precio_programa){
		$sql = "SELECT * FROM `lista_precio_programa` WHERE `id_lista_precio_programa` = :id_lista_precio_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_lista_precio_programa",  $id_lista_precio_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function editarvalores($id_lista_precio_programa, $semestre_m, $ordinaria_m, $aporte_m, $extra_m, $valor_credito_m, $pago_renovar_m){
		$sql="UPDATE `lista_precio_programa` SET `semestre` = '$semestre_m', `matricula_ordinaria` = '$ordinaria_m',  `aporte_social` = '$aporte_m',  `matricula_extraordinaria` = '$extra_m',  `valor_por_credito` = '$valor_credito_m',  `pago_renovar` = '$pago_renovar_m' WHERE `id_lista_precio_programa` = '$id_lista_precio_programa'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}
	//Implementar un método para traer el valor del derecho pecuniario si es que lo tiene
	public function traer_ultima_posicion(){
		$sql="SELECT * FROM `programa_ac` ORDER BY `programa_ac`.`cod_programa_pea` DESC;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function traer_ciclos(){
		$sql="SELECT * FROM `ciclos`;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar las escuelas
	public function selectRelacion(){	
		$sql="SELECT * FROM relacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectCiclo(){	
		$sql="SELECT * FROM ciclos";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para buscar el nombre de la escuela
	public function buscarnombreescuela($id_escuela){
		$sql="SELECT * FROM escuelas WHERE id_escuelas= :id_escuela";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_escuela",  $id_escuela);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para buscar el nombre del ciclo
	public function buscarnombreciclo($id_ciclo){
		$sql="SELECT * FROM ciclos WHERE id_ciclo= :id_ciclo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_ciclo",  $id_ciclo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los usuario activos para marcar como director
	public function selectDirector(){
		$sql="SELECT * FROM usuario WHERE usuario_condicion=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function actualizarPecuniario($id_programa, $valor){
		$sql="UPDATE `lista_precio_pecuniario` SET `valor_pecuniario`= :valor WHERE `id_programa`= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":valor",  $valor);
		$consulta->bindParam(":id_programa",  $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}
}
