<?php
require "../config/Conexion.php";

Class OncenterNuevoCliente
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
	

	//Implementamos un método para insertar seguimiento
	public function insertarCliente($tipo_documento,$identificacion,$fo_programa,$jornada_e,$nombre,$nombre_2,$apellidos,$apellidos_2,$celular,$email,$clave,$periodo_ingreso,$fecha,$hora,$medio,$conocio,$contacto,$estado,$periodo_campana,$ref_familiar,$ref_telefono,$id_usuario)
	{
		$sql="INSERT INTO on_interesados(tipo_documento,identificacion,fo_programa,jornada_e,nombre,nombre_2,apellidos,apellidos_2,celular,email,clave,periodo_ingreso,fecha_ingreso,hora_ingreso,medio,conocio,contacto,estado,periodo_campana,ref_familiar,ref_telefono,id_usuario) VALUES('$tipo_documento','$identificacion','$fo_programa','$jornada_e','$nombre','$nombre_2','$apellidos','$apellidos_2','$celular','$email','$clave','$periodo_ingreso','$fecha','$hora','$medio','$conocio','$contacto','$estado','$periodo_campana','$ref_familiar','$ref_telefono','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		
		$id_retorna = $mbd->lastInsertId();	
				// $fecha_graduacion=NULL;
				$sql3="INSERT INTO on_interesados_datos(id_estudiante,fecha_graduacion)
				VALUES ('$id_retorna',NULL)";
				global $mbd;
				$consulta3 = $mbd->prepare($sql3);
				$consulta3->execute();
		if($sql){
			return ("Registro Exitoso");
		}else{
			return("No se pudo registrar");
		}
		
		 
	}
	
		//Implementar un método para listar los estados del proceso
	public function listarmedios()
	{	
		$sql="SELECT * FROM on_medio WHERE estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	

	//Implementar un método para mostrar el id del programa
	public function listarPrograma()
	{
		$sql="SELECT * FROM on_programa where estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para mostrar el id del programa
	public function listarJornada()
	{
		$sql="SELECT * FROM on_jornadas where estado=1";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
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
	
		//Implementar un método para listar los departamentos en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM on_periodo";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
		//Implementar un método para listar los programas en un select
	public function selectPrograma()
	{	
		$sql="SELECT * FROM on_programa WHERE estado=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para listar los jornadas en un select
	public function selectJornada()
	{	
		$sql="SELECT * FROM on_jornadas";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para listar los tipo de documentos en un select
	public function selectTipoDocumento()
	{	
		$sql="SELECT * FROM on_tipo_documento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
			//Implementar un método para listar como nos conocio
	public function selectMedio()
	{	
		$sql="SELECT * FROM on_medio WHERE estado=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para listar como nos conocio
	public function selectConocio()
	{	
		$sql="SELECT * FROM on_conocio WHERE opcion='Conocio' and estado=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
			//Implementar un método para listar como nos contacto
	public function selectContacto()
	{	
		$sql="SELECT * FROM on_conocio WHERE opcion='Contacto' and estado=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	
}

?>