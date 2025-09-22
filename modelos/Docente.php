<?php 
session_start(); 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Docente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar las materias
	public function listar($ciclo,$materia,$jornada,$id_programa,$grupo)
	{
		$tabla="materias".$ciclo;
		$sql="SELECT * FROM $tabla WHERE nombre_materia= :materia and jornada= :jornada and programa= :id_programa and periodo='".$_SESSION["periodo_actual"]."' and grupo= :grupo";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para mirar el programa
	public function programaacademico($id_programa)
    {
    	$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
		//Implementar un método para tener los datos del docente
	public function datosDocente($id_usuario)
    {
    	$sql="SELECT * FROM docente WHERE id_usuario= :id_usuario"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	//Implementar un método para mirar el docente
	public function docente_grupo($materia,$jornada,$periodo,$programa)
    {
    	$sql="SELECT * FROM docente_grupos WHERE materia= :materia and jornada= :jornada and periodo= :periodo and  programa= :programa "; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	//Implementar un método para mirar el id del estudiante
	public function id_estudiante($id_estudiante)
    {
    	$sql="SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	//Implementar un método para mirar datos del estudiante
	public function estudiante_datos($id_credencial)
    {
    	$sql="SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    
    //Implementar un método para mirar datos del estudiante
	public function est_carac_habeas($id_credencial){
    	$sql="SELECT * FROM caracterizacion_data WHERE id_credencial= :id_credencial"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para mirar datos del estudiante
	public function estudiante_datos_completos($id_estudiante)
    {
		global $mbd;
    	$sql2=" SELECT * FROM `estudiantes_datos_personales` INNER JOIN `credencial_estudiante` ON estudiantes_datos_personales.id_credencial = `credencial_estudiante`.id_credencial WHERE estudiantes_datos_personales.id_credencial = :id_creden "; 
		$consulta2 = $mbd->prepare($sql2);
		$consulta2->bindParam(":id_creden", $id_estudiante);
		$consulta2->execute();
		$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		
		return $resultado2;
    }
	
	
	//Implementar un método para mirar si el docente tiene PEA
	public function docente_pea($id_docente_materia)
    {
    	$sql="SELECT * FROM pea_docentes WHERE id_materia= :id_docente_materia"; 		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_materia", $id_docente_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	//Implementar un método para asigar el id a la materia del estudiante
	public function asignar_pea_docente($numero_id_pea_encontrado,$id_estudiante_materia)
    {
    	$sql="UPDATE materias SET id_pea= :numero_id_pea_encontrado WHERE id_materia= :id_estudiante_materia"; 		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":numero_id_pea_encontrado", $numero_id_pea_encontrado);
		$consulta->bindParam(":id_estudiante_materia", $id_estudiante_materia);
		return $consulta->execute();

    }
	
		//Implementar un método para listar el contenido del PEA
	public function listar_pea($id_estudiante_materia)
	{	
		$sql="SELECT * FROM pea_docentes WHERE id_materia= :id_estudiante_materia ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante_materia", $id_estudiante_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para listar el contenido del PEA
	public function listar_temas($id_pea)
	{	
		$sql="SELECT * FROM pea_temas WHERE id_pea= :id_pea ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
	//Implementar un método para listar las actividades
	public function listar_actividades($id_tema,$id_materia)
	{	
		$sql="SELECT * FROM pea_actividades WHERE id_tema= :id_tema and id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		
	//Implementar un método para listar las actividades
	public function listar_archivos($id_pea_actividades)
	{	
		$sql="SELECT * FROM pea_archivos WHERE id_pea_actividad= :id_pea_actividades";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_actividades", $id_pea_actividades);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para agregar falta
	public function aggfalta($ciclo,$id_estudiante,$id_programa,$programa,$id_materia,$fecha)
	{
		global $mbd;
		#consulta primero si el estudiante ya tiene la falta esa fecha

		$sentencia0 = $mbd->prepare("SELECT * FROM `faltas` WHERE id_estudiante = :id_estudiante AND id_docente = :id_docente AND fecha_falta = :fecha AND ciclo = :ciclo AND programa = :programa AND materia_falta = :materia AND periodo_falta = :periodo");
		$sentencia0->bindParam(":id_estudiante",$id_estudiante);
		$sentencia0->bindParam(":id_docente", $_SESSION['id_usuario']);
		$sentencia0->bindParam(":fecha", $fecha);
		$sentencia0->bindParam(":ciclo", $ciclo);
		$sentencia0->bindParam(":programa", $id_programa);
		$sentencia0->bindParam(":materia", $programa);
		$sentencia0->bindParam(":periodo", $_SESSION['periodo_actual']);
		$sentencia0->execute();
		$registro = $sentencia0->fetch(PDO::FETCH_ASSOC);
		
		

		#inserción en la tabla materias
		$materia = 'materias'.$ciclo;
		
		$sentencia = $mbd->prepare("UPDATE $materia SET faltas = faltas+1 WHERE `id_materia` = :id");
		$sentencia->bindParam(":id", $id_materia);


		#inserción en la tabla faltas
		$sentencia2 = $mbd->prepare("INSERT INTO `faltas`(`id_estudiante`, `id_docente`, `id_materia`, `fecha_falta`, `ciclo`, `programa`, `materia_falta`, `periodo_falta`) VALUES (:id_estudiante,:id_docente,:id_materia,:fecha,:ciclo,:programa,:materia,:periodo)");
		$sentencia2->bindParam(":id_estudiante",$id_estudiante);
		$sentencia2->bindParam(":id_docente", $_SESSION['id_usuario']);
		$sentencia2->bindParam(":id_materia", $id_materia);
		$sentencia2->bindParam(":fecha", $fecha);
		$sentencia2->bindParam(":ciclo", $ciclo);
		$sentencia2->bindParam(":programa", $id_programa);
		$sentencia2->bindParam(":materia", $programa);
		$sentencia2->bindParam(":periodo", $_SESSION['periodo_actual']);


		if ($registro !== false) {
			$data['status'] = "existe";
		} else {
			if ($sentencia->execute()) {
				if ($sentencia2->execute()) {
					$data['status'] = "ok";
				} else {
					$data['status'] = "err";
				}
			} else {
				$data['status'] = "err";
			}
		}

		

		echo json_encode($data);
		

	}
	//consulta datos de contacto del estudiante por programa
	public function consultaDatosContacto($ciclo,$materia,$jornada,$id_programa,$grupo,$medio)
	{
		$tabla="materias".$ciclo;
		$periodo = $_SESSION['periodo_actual'];
		$data = array();
		$sql=" SELECT id_credencial FROM $tabla as uno INNER JOIN estudiantes ON uno.id_estudiante = estudiantes.id_estudiante WHERE uno.nombre_materia = :materia AND uno.jornada = :jornada AND uno.programa = :id_programa AND uno.periodo = :periodo AND uno.grupo= :grupo ";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
			
			$data[]=array(                
				"0"=>$resultado['id_credencial']
			);
			
		}
		//echo $sql;
		return $data;

	}

	//consulta insasistencia del estudiante
	public function consultaInasistencia($id)
	{
		$data = array();
		$periodo = $_SESSION['periodo_actual'];
		$sql="SELECT * FROM faltas WHERE id_estudiante = :id AND periodo_falta = :periodo AND  id_docente = :id_d ";
		global $mbd;
		$id_d = $_SESSION['id_usuario'];
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":id_d", $id_d);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;

	}

	//consulta correo del estudiante
	public function consultaCorreoEstudiante($id)
	{
		$sql=" SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}

	public function convertir_fecha($date) 
	{
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
    }

	//consulta correo del estudiante
	public function consultaCorte($programa,$materia,$docente,$semestre,$jornada)
	{
		$sql=" SELECT * FROM `docente_grupos` WHERE `id_programa` = :progra AND `materia` = :mate AND `jornada` = :jorna AND `semestre` = :semestre AND `periodo` = :pe  ";
		global $mbd;
		$pe = $_SESSION['periodo_actual'];
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":progra", $programa);
		$consulta->bindParam(":mate", $materia);
		$consulta->bindParam(":jorna", $jornada);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":pe", $pe);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

	}

	public function agreganota($id,$nota,$tl,$c,$pro)
	{
		global $mbd;
		$mate = "materias".$c;
		$i = base64_decode($id);
		$sentencia = $mbd->prepare(" UPDATE $mate SET $tl = :nota WHERE `id_materia` = :id ");
		$sentencia->bindParam(":nota", $nota);
		$sentencia->bindParam(":id", $i);
		if ($sentencia->execute()) {
			$con = self::promedio($pro,$id,$c);
			$data['status'] = "ok";
		} else {
			$data['status'] = "Error al agregar la nota";
		}

		echo json_encode($data);
		
	}

	public function promedio($id,$id_mate,$c)
	{
		global $mbd;
		$prome = 0;
		$im = base64_decode($id_mate);
		$sentencia = $mbd->prepare(" SELECT * FROM `cortes_programas` WHERE `id_programa` = $id ");
		//$sentencia->bindParam(":id",$id);
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$mate = "materias".$c;
		for ($i=0; $i < count($registro); $i++) {
			$sentencia2 = $mbd->prepare(" SELECT * FROM $mate WHERE `id_materia` = $im ");
			$sentencia2->execute();
			$registro2 = $sentencia2->fetch(PDO::FETCH_ASSOC);

			$multi = ($registro2[$registro[$i]['corte_programa']] * $registro[$i]['valor_corte'])/ 100;

			$prome = $prome+$multi;

			//echo json_encode($sentencia2);
		}

		$sentencia3 = $mbd->prepare(" UPDATE $mate SET promedio = :pro WHERE `id_materia` = :id ");
		$sentencia3->bindParam(":pro", $prome);
		$sentencia3->bindParam(":id", $im);
		if ($sentencia3->execute()) {
			$data['status'] = "ok";
		} else {
			$data['status'] = "error";
		}
		
		//echo json_encode($data);


	}
	
			//Implementar un método para traer el nombre del programa
	public function programa($id_programa)
	{	
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


}

?>