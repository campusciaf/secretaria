<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Compromiso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_usuario,$compromiso_nombre,$compromiso_fecha,$compromiso_val_admin,$compromiso_val_usuario,$compromiso_valida,$compromiso_periodo)
	{
		$sql="INSERT INTO compromiso (id_usuario,compromiso_nombre,compromiso_fecha,compromiso_val_admin,compromiso_val_usuario,compromiso_valida,compromiso_periodo)
		VALUES ('$id_usuario','$compromiso_nombre','$compromiso_fecha','$compromiso_val_admin','$compromiso_val_usuario','$compromiso_valida','$compromiso_periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para editar registros
	public function editar($id_compromiso,$id_usuario,$compromiso_nombre,$compromiso_fecha,$compromiso_val_admin,$compromiso_val_usuario,$compromiso_valida,$compromiso_periodo)
	{
		$sql="UPDATE compromiso SET id_usuario='$id_usuario', compromiso_nombre='$compromiso_nombre', compromiso_fecha='$compromiso_fecha', compromiso_valida='$compromiso_valida', compromiso_periodo='$compromiso_periodo' WHERE id_compromiso='$id_compromiso'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
	    return $consulta->execute();
	}

	
		//Implementamos un método para insertar registros
	public function insertarmeta($id_compromiso_meta,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo,$corresponsabilidad,$condicion_institucional,$condicion_programa)
	{
		$sql="INSERT INTO meta (id_compromiso,id_eje,meta_nombre,meta_fecha,meta_val_admin,fecha_val_admin,meta_val_usuario,fecha_val_usuario,meta_valida,meta_periodo,corresponsabilidad)
		VALUES ('$id_compromiso_meta','$id_eje','$meta_nombre','$meta_fecha','$meta_val_admin','0000-00-00','$meta_val_usuario','0000-00-00','$meta_valida','$meta_periodo','$corresponsabilidad')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		
		//retorno el ultimo id
		$idusuarionew = $mbd->lastInsertId();
		
		
		$num_elementos=0;
		$sw=true;
		
		//insertar las condiciones institucionales
		while ($num_elementos < count($condicion_institucional))
		{
			$sql_detalle = "INSERT INTO meta_con_ins(id_compromiso,id_meta, condicion_institucional) VALUES('$id_compromiso_meta','$idusuarionew', '$condicion_institucional[$num_elementos]')";
			
			$consulta2 = $mbd->prepare($sql_detalle);
			$consulta2->execute() or $sw = false;
			
			$num_elementos=$num_elementos + 1;
		}
		$num_elementos_2=0;
		$sw_2=true;
		// insertar codiciones de programa
		while ($num_elementos_2 < count($condicion_programa))
		{
			$sql_detalle_2 = "INSERT INTO meta_con_pro(id_compromiso_2,id_meta_2, condicion_programa) VALUES('$id_compromiso_meta','$idusuarionew', '$condicion_programa[$num_elementos_2]')";
			
			$consulta3 = $mbd->prepare($sql_detalle_2);
			$consulta3->execute() or $sw_2 = false;
			
			$num_elementos_2=$num_elementos_2 + 1;
		}

		return $sw;
		
	}

	//Implementamos un método para editar registros
	public function editarmeta($id_meta,$id_compromiso_meta,$id_eje,$meta_nombre,$meta_fecha,$meta_val_admin,$meta_val_usuario,$meta_valida,$meta_periodo,$corresponsabilidad,$condicion_institucional,$condicion_programa)
	{
		$sql="UPDATE meta SET id_compromiso='$id_compromiso_meta',id_eje='$id_eje', meta_nombre='$meta_nombre', meta_fecha='$meta_fecha', meta_val_admin='$meta_val_admin', meta_val_usuario='$meta_val_usuario', meta_valida='$meta_valida', meta_periodo='$meta_periodo',corresponsabilidad='$corresponsabilidad' WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		return $consulta->execute();
		
		
		//Eliminamos todos las condicones institucionales asignados para volverlos a registrar
		$sqldel="DELETE FROM meta_con_ins WHERE id_meta= :id_meta";
		//ejecutarConsulta($sqldel);
		
		
		$consulta2 = $mbd->prepare($sqldel);
		$consulta2->bindParam(":id_meta", $id_meta);
		$consulta2->execute();
		$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		

		$num_elementos=0;
		$sw=true;
		// consulta para insertar codición institucional
		while ($num_elementos < count($condicion_institucional))
		{
			
			$sql_detalle = "INSERT INTO meta_con_ins(id_compromiso,id_meta, condicion_institucional) VALUES('$id_compromiso_meta','$id_meta', '$condicion_institucional[$num_elementos]')";
			
			$consulta = $mbd->prepare($sql_detalle);
			$consulta->execute() or $sw = false;
			 
			$num_elementos=$num_elementos + 1;
		}
		
		$num_elementos_2=0;
		$sw_2=true;
		// consulta para insertar codición programa
		while ($num_elementos_2 < count($condicion_programa))
		{
			
			$sql_detalle_2 = "INSERT INTO meta_con_pro(id_compromiso_2,id_meta_2, condicion_programa) VALUES('$id_compromiso_meta','$id_meta', '$condicion_programa[$num_elementos_2]')";
			
			$consulta_2 = $mbd->prepare($sql_detalle_2);
			$consulta_2->execute() or $sw_2 = false;
			 
			$num_elementos_2=$num_elementos_2 + 1;
		}

		return $sw;
		
	}
	
	

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_compromiso)
	{
		$sql="SELECT * FROM compromiso WHERE id_compromiso= :id_compromiso";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_compromiso", $id_compromiso);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrarMetaEditar($id_meta)
	{
		$sql="SELECT * FROM meta WHERE id_meta= :id_meta";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para mostrar los metas de los compromisos
	public function mostrarMeta($id_compromiso,$periodo_actual)
	{
		$sql="SELECT * FROM meta WHERE id_compromiso= :id_compromiso AND meta_periodo='$periodo_actual'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_compromiso", $id_compromiso);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para eliminar los datos de un registro 
	public function eliminar($id_compromiso)
	{
		
		
		global $mbd;
		
		//Eliminamos la meta
		$sql1="DELETE FROM meta WHERE id_compromiso= :id_compromiso";
		$consulta1 = $mbd->prepare($sql1);
		$consulta1->bindParam(":id_compromiso", $id_compromiso);
		$consulta1->execute();
		$resultado1 = $consulta1->fetch(PDO::FETCH_ASSOC);
		
		//Eliminamos todos las condiciones institucionales de la meta
		$sqldel="DELETE FROM meta_con_ins WHERE id_compromiso= :id_compromiso";
		$consulta2 = $mbd->prepare($sqldel);
		$consulta2->bindParam(":id_compromiso", $id_compromiso);
		$consulta2->execute();
		$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		
		//Eliminamos todos las condiciones programa de la meta
		$sqldel3="DELETE FROM meta_con_pro WHERE id_compromiso_2= :id_compromiso";
		$consulta3 = $mbd->prepare($sqldel3);
		$consulta3->bindParam(":id_compromiso", $id_compromiso);
		$consulta3->execute();
		$resultado3 = $consulta3->fetch(PDO::FETCH_ASSOC);
			

		//Eliminamos el compromiso
		$sql="DELETE FROM compromiso WHERE id_compromiso= :id_compromiso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_compromiso", $id_compromiso);
		return $consulta->execute();
	}
	
	//Implementar un método para eliminar las metas cuando se eliminar el compromiso
	public function eliminarCompromisoMeta($id_compromiso)
	{
		$sql="DELETE FROM meta WHERE id_compromiso= :id_compromiso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_compromiso", $id_compromiso);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
	//Implementar un método para eliminar las metas
	public function eliminarMeta($id_meta)
	{		
		global $mbd;
		
		//Eliminamos todos las condiciones institucionales de la meta
		$sqldel="DELETE FROM meta_con_ins WHERE id_meta= :id_meta";
		$consulta2 = $mbd->prepare($sqldel);
		$consulta2->bindParam(":id_meta", $id_meta);
		$consulta2->execute();
		$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		
		//Eliminamos todos las condiciones programa de la meta
		$sqldel3="DELETE FROM meta_con_pro WHERE id_meta_2= :id_meta";
		$consulta3 = $mbd->prepare($sqldel3);
		$consulta3->bindParam(":id_meta", $id_meta);
		$consulta3->execute();
		$resultado3 = $consulta3->fetch(PDO::FETCH_ASSOC);
		
		// eliminar meta
		$sql="DELETE FROM meta WHERE id_meta= :id_meta";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		return $consulta->execute();
	}
	
//Implementar un método para validar el compromiso
	public function validarCompromiso($id_compromiso)
	{
		$sql="UPDATE compromiso set aprobado='1' WHERE id_compromiso= :id_compromiso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_compromiso", $id_compromiso);
		return $consulta->execute();
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
	
	
	//Implementar un método para listar los compromisos
	public function listar()
	{	
		$sql="SELECT * FROM compromiso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los compromisos
	public function listarCompromiso($id_usuario,$periodo_actual)
	{	
		$sql="SELECT * FROM compromiso WHERE id_usuario= :id_usuario and compromiso_periodo='$periodo_actual'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los usuarios que pueden tener poa
	public function listarUsuarioPoa()
	{	
		$sql="SELECT * FROM usuario WHERE usuario_poa='1'";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para listar los usuarios que pueden tener poa
	public function listarImprimir($id_usuario)
	{	
		$sql="SELECT * FROM usuario WHERE id_usuario='".$id_usuario."'";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para listar los registros en un select
	public function select()
	{	
		$sql="SELECT * FROM compromiso";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
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
	
	//Implementar un método para imrpimir el eje 
	public function buscarEjes($id_ejes)
	{
		$sql="SELECT * FROM ejes WHERE id_ejes='".$id_ejes."'";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		//$consulta->bindParam(":id_ejes", $id_ejes);
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para imrpimir el cargo
	public function buscarCargo($id_usuario)
	{
		$sql="SELECT * FROM usuario WHERE id_usuario=: id_usuario";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		return $consulta->execute();
	}
	
	//Implementar un método para listar los ejes en un select
	public function selectEjes()
	{	
		$sql="SELECT * FROM ejes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
	
	//Implementar un método para listar los periodos en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo ORDER BY id_periodo DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
				//Implementar un método para listar los si o no
	public function selectlistaSiNo()
	{	
		$sql="SELECT * FROM lista_si_no";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;	
	}
	
	//Implementar un método para traer la fecha limite del compromiso
	public function fechaLimite($id_compromiso)
	{
		$sql="SELECT * FROM compromiso WHERE id_compromiso='".$id_compromiso."'";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_compromiso", $id_compromiso);
		$consulta->execute();
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
	
		//Implementar un método para listar las condiciones insitucioanles marcadas
	public function listarcondicionesmarcadas($id_meta)
	{
		$sql="SELECT * FROM meta_con_ins WHERE id_meta= :id_meta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_meta", $id_meta);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
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


}

?>