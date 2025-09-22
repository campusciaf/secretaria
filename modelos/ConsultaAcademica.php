<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
//session_start();

Class ConsultaAcademica
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($credencial_nombre,$credencial_nombre_2,$credencial_apellido,$credencial_apellido_2,$credencial_identificacion,$credencial_login,$credencial_clave)
	{
		$sql="INSERT INTO credencial_estudiante (credencial_nombre,credencial_nombre_2,credencial_apellido,credencial_apellido_2,credencial_identificacion,credencial_login,credencial_clave)
		VALUES ('$credencial_nombre','$credencial_nombre_2','$credencial_apellido','$credencial_apellido_2','$credencial_identificacion','$credencial_login','$credencial_clave')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	

	public function insertarnuevoprograma($id_credencial,$fo_programa,$jornada_e,$escuela_ciaf,$periodo_ingreso,$periodo_activo)
	{
		$sql="INSERT INTO estudiantes (id_credencial,fo_programa,jornada_e,escuela_ciaf,periodo,periodo_activo)
		VALUES ('$id_credencial','$fo_programa','$jornada_e','$escuela_ciaf','$periodo_ingreso','$periodo_activo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	

	
	
		//Implementamos un método para editar registros
	public function editar($id,$programa,$nombre,$semestre,$area,$creditos,$codigo,$presenciales,$independiente,$escuela)
	{
		$sql="UPDATE materias_ciafi SET programa='$programa', nombre='$nombre', semestre='$semestre', area='$area', creditos='$creditos', codigo='$codigo', presenciales='$presenciales', independiente='$independiente', escuela='$escuela' WHERE id='$id'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":id_programa", $id_programa);
		return $consulta->execute();

	}
	
		//Implementamos un método para actualizar el periodo activo del estudiante
	public function actualizarperiodo($id_estudiante,$periodo_activo)
	{
		$sql="UPDATE estudiantes SET periodo_activo= :periodo_activo WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_activo", $periodo_activo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	
	//Implementar un método para listar los registros
	public function verificardocumento($credencial_identificacion)
	{
		$sql="SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Implementar un método para traer el id del estudiante cuando se crea una credencial
	public function traeridcredencial($credencial_identificacion)
	{
		$sql="SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para listar los registros
	public function listar($id_credencial)
	{
		$sql="SELECT * FROM estudiantes WHERE id_credencial= :id_credencial";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para listar los registros
	public function listarMaterias($id_estudiante,$ciclo,$semestre)
	{
		
		$sql="SELECT * FROM $ciclo WHERE id_estudiante= :id_estudiante and semestre= :semestre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
			//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrardatos($id_credencial)
	{
		$sql="SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
			//Implementar un método para mostrar a que programa pertenece
	public function mostrarescuela($programa)
	{
		$sql="SELECT * FROM programa_ac WHERE nombre= :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para traer el nombre del estado
	public function listarEstado($id_estado_academico)
	{
		$sql="SELECT * FROM estado_academico WHERE id_estado_academico= :id_estado_academico ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado_academico", $id_estado_academico);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para listar las escuelas
	public function selectJornada()
	{	
		$sql="SELECT * FROM jornada";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para listar las escuelas
	public function selectPrograma()
	{	
		$sql="SELECT * FROM programa_ac";
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
	
			//Implementar un método para listar los grupos en un select
	public function selectGrupo()
	{	
		$sql="SELECT * FROM grupo ORDER BY grupo ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;		
	}
	
	//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa)
	{	
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para mostrar los datos de una materia matriculada
	public function datosMateriaMatriculada($ciclo,$id_estudiante,$materia,$semestre)
	{	
		$sql="SELECT * FROM $ciclo WHERE id_estudiante= :id_estudiante and nombre_materia= :materia and semestre= :semestre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		//$consulta->bindParam(":ciclo", $ciclo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para mostrar los datos del programa del estudiante
	public function datosEstudiante($id_estudiante)
	{
		$sql="SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
	//Implementar un método para buscar los datos de la materia a matricular
	public function MateriaDatos($id)
	{
		$sql="SELECT * FROM materias_ciafi WHERE id= :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para insertar registros
	public function insertarmateria($id_estudiante,$nombre_materia,$jornada_e,$periodo,$semestre,$creditos,$programa,$ciclo,$fecha,$usuario,$grupo)
	{
		$tabla="materias".$ciclo;
		$sql="INSERT INTO $tabla (id_estudiante,nombre_materia,jornada_e,jornada,periodo,semestre,creditos,programa,fecha,usuario,grupo)
		VALUES ('$id_estudiante','$nombre_materia','$jornada_e','$jornada_e','$periodo','$semestre','$creditos','$programa','$fecha','$usuario','$grupo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	

	
			//Implementar un método para listar los creditos matriculados
	public function creditosMatriculados($id_estudiante,$ciclo)
	{
		$tabla="materias".$ciclo;
		$sql="SELECT sum(creditos) as suma_creditos FROM $tabla WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementamos un método para actualizar el semestre del estudiante
	public function actualizarsemestre($id_estudiante,$semestre_nuevo)
	{
		$sql="UPDATE estudiantes SET semestre_estudiante= :semestre_nuevo WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre_nuevo", $semestre_nuevo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}

	//Implementamos un método para ieliminar la materia
	public function eliminarMateria($id_materia_matriculada,$ciclo)
	{
		$tabla="materias".$ciclo;
		$sql="DELETE FROM $tabla WHERE id_materia= :id_materia_matriculada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia_matriculada", $id_materia_matriculada);
		return $consulta->execute();
	}
	
		//Implementamos un método para insertar registros
	public function trazabilidadMateriaEliminada($id_estudiante,$nombre_materia,$jornada_e,$periodo,$semestre,$promedio,$programa,$fecha,$usuario)
	{

		$sql="INSERT INTO trazabilidad_materias_eliminadas (id_estudiante,nombre_materia,jornada_e,periodo,semestre,promedio,programa,fecha,usuario)
		VALUES ('$id_estudiante','$nombre_materia','$jornada_e','$periodo','$semestre','$promedio','$programa','$fecha','$usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
	
	
		//Implementamos un método para actualizar la jornada de la ateria matriculada
	public function actualizarJornada($id_materia,$jornada,$ciclo)
	{
		$sql="UPDATE $ciclo SET jornada= :jornada WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_materia", $id_materia);
		return $consulta->execute();
	}
	
	
		//Implementamos un método para actualizar el periodo de la materia matriculada
	public function actualizarPeriodoMateria($id_materia,$periodo,$ciclo)
	{
		$sql="UPDATE $ciclo SET periodo= :periodo WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":id_materia", $id_materia);
		return $consulta->execute();
	}
	
	//Implementamos un método para actualizar el grupo de la materia matriculada
	public function actualizarGrupoMateria($id_materia,$grupo,$ciclo)
	{
		$sql="UPDATE $ciclo SET grupo= :grupo WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":id_materia", $id_materia);
		return $consulta->execute();
	}

	public function valorhuella()
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT * FROM `valor_huella` ");
		$sentencia->execute();
		$registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
	}

	public function huella($id,$val,$c)
	{
		global $mbd;
		$materia = "materias".$c;
		$i = base64_decode($id);
		$sentencia = $mbd->prepare(" UPDATE $materia SET huella = :val WHERE id_materia = :id ");
		$sentencia->bindParam(":val",$val);
		$sentencia->bindParam(":id",$i);
		$tl = "huella";
		$can = self::trazabilidadhuella($i,$tl,$materia,$val);
		if ($sentencia->execute()) {
			$data['status'] = "ok";
		} else {
			$data['status'] = "Erro al agregar el valor de la huella";
		}

		echo json_encode($data);
		
	}

	public function agreganota($id,$nota,$tl,$c,$pro)
	{
		global $mbd;
		$mate = "materias".$c;
		$i = base64_decode($id);
		$sentencia = $mbd->prepare(" UPDATE $mate SET $tl = :nota WHERE `id_materia` = :id ");
		$sentencia->bindParam(":nota", $nota);
		$sentencia->bindParam(":id", $i);
		$can = self::trazabilidadhuella($i,$tl,$mate,$nota);
		if ($sentencia->execute()) {
			$con = self::calcularpromedio($pro,$id,$c);
			
			$data['status'] = "ok";
		} else {
			$data['status'] = "Error al agregar la nota";
		}

		echo json_encode($data);
		
	}

	public function calcularpromedio($id,$id_mate,$c)
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

	public function promedio($id,$val,$c)
	{
		global $mbd;
		$materia = "materias".$c;
		$i = base64_decode($id);
		$sentencia = $mbd->prepare(" UPDATE $materia SET promedio = :val WHERE id_materia = :id ");
		$sentencia->bindParam(":val",$val);
		$sentencia->bindParam(":id",$i);
		$tl = "promedio";
		$can = self::trazabilidadhuella($i,$tl,$materia,$val);
		if ($sentencia->execute()) {
			$data['status'] = "ok";
		} else {
			$data['status'] = "Erro al agregar el promedio";
		}

		echo json_encode($data);
	}

	public function trazabilidadhuella($i,$tl,$mate,$nota)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT * FROM $mate WHERE `id_materia` = :id ");
		$sentencia->bindParam(":id",$i);
		$sentencia->execute();
		$registro = $sentencia->fetch(PDO::FETCH_ASSOC);

		$nota_anterior = $registro[$tl];
		$id_estudiante = $registro['id_estudiante'];

		$id_usuario = $_SESSION['id_usuario'];
		$pe = $_SESSION['periodo_actual'];

		$sentencia2 = $mbd->prepare(" INSERT INTO `trazabilidad_huella`(`id_usuario`, `id_estudiante`, `dato_anterior`, `dato_nuevo`, `campo`, `periodo`) VALUES (:id_u, :id_e ,:nota_a,:nota, :corte, :pe) ");
		$sentencia2->bindParam(":id_u",$id_usuario);
		$sentencia2->bindParam(":id_e",$id_estudiante);
		$sentencia2->bindParam(":nota_a",$nota_anterior);
		$sentencia2->bindParam(":nota",$nota);
		$sentencia2->bindParam(":corte",$tl);
		$sentencia2->bindParam(":pe",$pe);
		$sentencia2->execute();
		//echo json_encode($registro);

	}

}

?>
