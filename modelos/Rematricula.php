<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Rematricula{
	//Implementamos nuestro constructor
	public function __construct(){}
	public function periodoactual(){
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer los datos de la tabla estudiantes
	public function traerdatostablaestudiante($id_estudiante){
		$sql = "SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//verificar que sea el estudiante
	public function primercontrol($id_credencial, $id_estudiante){
		$sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and id_estudiante= :id_estudiante";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//verificar que sea el estudiante
	public function primercontrolprograma($id_credencial, $id_programa_ac){
		$sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and id_programa_ac= :id_programa_ac";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//verificar que la materia no este matriculada
	public function siestarematriculada($id_estudiante, $id_materia, $ciclo){
		$tabla = "rematricula" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id_estudiante and id_materia= :id_materia";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar rematriculas
	public function addasignatura($id_credencial, $id_estudiante, $id_materia, $ciclo, $perdida, $fecha, $periodo_actual){
		$tabla = "rematricula" . $ciclo;
		$sql = "INSERT INTO $tabla (id_credencial,id_estudiante,id_materia,ciclo,perdida,fecha,periodo_actual)
		VALUES ('$id_credencial','$id_estudiante','$id_materia','$ciclo','$perdida','$fecha','$periodo_actual')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute();
		return $resultado;
	}
	//metodo para traer los datos de la materia perdida
	public function traerdatosmateria($id_programa, $nombre){
		$sql = "SELECT * FROM materias_ciafi WHERE id_programa_ac= :id_programa and nombre= :nombre";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para traer los datos de la materia normal
	public function traerdatosmaterianormal($id_programa, $id_materia){
		$sql = "SELECT * FROM materias_ciafi WHERE id_programa_ac= :id_programa and id= :id_materia";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para traer los datos de la materia
	public function estamatriculada($id_estudiante, $nombre_materia, $ciclo){
		$tabla = $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id_estudiante and nombre_materia= :nombre_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar materia perdida en tabla canceladas
	public function insertarmateriaperdida($id_credencial, $id_estudiante, $id_programa, $id_materia, $nombre_materia, $promedio, $periodo, $usuario, $fecha, $hora){
		$sql = "INSERT INTO materias_canceladas (id_credencial, id_estudiante, id_programa, id_materia, nombre_materia, promedio, periodo, usuario, fecha, hora)
		VALUES ('$id_credencial', '$id_estudiante', '$id_programa', '$id_materia', '$nombre_materia', '$promedio', '$periodo', '$usuario', '$fecha', '$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//metodo para traer los datos de la materia
	public function traerdatosmateriaperdida($id_materia, $id_estudiante, $ciclo){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_materia= :id_materia and id_estudiante= :id_estudiante ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para actualizar el grupo de la materia matriculada
	public function actualizar_materia_perdida($id_materia, $periodo_pecuniario, $ciclocompleto, $cortes_programa, $fechahora, $id_credencial){
		//$ciclocompleto es la tabla materias
		if ($cortes_programa == 3) { // para saber cuantos cortes tiene para actualizar
			$corte = "c1=0, c2=0, c3=0";
		}
		if ($cortes_programa == 2) { // para saber cuantos cortes tiene para actualizar
			$corte = "c1=0, c2=0";
		}
		if ($cortes_programa == 1) { // para saber cuantos cortes tiene para actualizar
			$corte = "c1=0";
		}
		$sql = "UPDATE $ciclocompleto SET periodo= :periodo_pecuniario, $corte, faltas='0', promedio='0', fecha= :fechahora, usuario= :id_credencial  WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":fechahora", $fechahora);
		$consulta->bindParam(":id_credencial", $id_credencial);
		return $consulta->execute();
	}
	//Implementamos un método para matriular materia normal
	public function insertarmateria($id_estudiante, $nombre_materia_normal, $estado, $jornada_e, $periodo_pecuniario, $semestre_materia_ciafi, $creditos_materia_ciafi, $id_programa_ac, $fechahora, $id_credencial, $grupo, $ciclocompleto){
		$tabla = $ciclocompleto;

		$sql = "INSERT INTO $tabla (id_estudiante, nombre_materia, estado, jornada_e, jornada, periodo, semestre, creditos, programa, fecha, usuario, grupo)
		VALUES ('$id_estudiante', '$nombre_materia_normal', '$estado', '$jornada_e', '$jornada_e', '$periodo_pecuniario', '$semestre_materia_ciafi', '$creditos_materia_ciafi', '$id_programa_ac',' $fechahora', '$id_credencial','$grupo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute();
		return $resultado;
	}
	//Implementar un método para listar los creditos matriculados
	public function creditosMatriculadostotal($id_estudiante, $ciclo){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT sum(creditos) as suma_creditos FROM $tabla WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar registros
	public function insertar($credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $credencial_login, $credencial_clave){
		$sql = "INSERT INTO credencial_estudiante (credencial_nombre,credencial_nombre_2,credencial_apellido,credencial_apellido_2,credencial_identificacion,credencial_login,credencial_clave)
		VALUES ('$credencial_nombre','$credencial_nombre_2','$credencial_apellido','$credencial_apellido_2','$credencial_identificacion','$credencial_login','$credencial_clave')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el semestre del estudiante
	public function actualizarsemestreyperiodo($id_estudiante, $semestre_nuevo, $periodo){
		$sql = "UPDATE estudiantes SET semestre_estudiante= :semestre_nuevo, periodo_activo= :periodo WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre_nuevo", $semestre_nuevo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo", $periodo);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el periodo activo del estudiante
	public function actualizarperiodo($id_estudiante, $periodo_activo){
		$sql = "UPDATE estudiantes SET periodo_activo= :periodo_activo WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_activo", $periodo_activo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementar un método para listar los registros
	public function verificardocumento($credencial_identificacion){
		$sql = "SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer el id del estudiante cuando se crea una credencial
	public function traeridcredencial($credencial_identificacion){
		$sql = "SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :credencial_identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listar($id_credencial){
		$sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and estado=1";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function listarMaterias($id_programa_ac, $semestre){
		$sql = "SELECT * FROM materias_ciafi WHERE id_programa_ac= :id_programa_ac and semestre= :semestre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrardatos($id_credencial){
		$sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar a que programa pertenece
	public function mostrarescuela($programa){
		$sql = "SELECT * FROM programa_ac WHERE nombre= :programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para saber el prerequisito
	public function preRequisito($prerequisito){
		$sql = "SELECT * FROM materias_ciafi WHERE id= :prerequisito";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para saber la nota prerequisito
	public function preRequisitoNota($ciclo, $id_estudiante, $materia){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id_estudiante and nombre_materia= :materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":materia", $materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function verificarjornadaactiva($jornada_e){
		$sql = "SELECT * FROM jornada WHERE nombre= :jornada_e";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada_e", $jornada_e);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de un programa
	public function datosPrograma($id_programa){
		$sql = "SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de una materia matriculada
	public function datosMateriaMatriculada($ciclo, $id_estudiante, $materia, $semestre){
		$sql = "SELECT * FROM $ciclo WHERE id_estudiante= :id_estudiante and nombre_materia= :materia and semestre= :semestre";
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
	public function datosEstudiante($id_estudiante){
		$sql = "SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para buscar los datos de la materia a matricular
	public function MateriaDatos($id){
		$sql = "SELECT * FROM materias_ciafi WHERE id= :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el nombre del estado
	public function listarEstado($id_estado_academico){
		$sql = "SELECT * FROM estado_academico WHERE id_estado_academico= :id_estado_academico ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estado_academico", $id_estado_academico);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el nombre del estado
	public function sipagomatricula($id_estudiante, $periodo_pecuniario){
		$sql = "SELECT * FROM pagos_rematricula WHERE id_estudiante= :id_estudiante and periodo_pecuniario= :periodo_pecuniario and x_respuesta='Aceptada'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los creditos matriculados
	public function creditosMatriculadosperdidos($id_estudiante, $ciclo, $periodo_pecuniario){
		$tabla = $ciclo;
		$sql = "SELECT sum(creditos) as suma_creditos FROM $tabla WHERE id_estudiante= :id_estudiante and promedio < '3' and periodo!= :periodo_pecuniario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los creditos matriculados
	public function creditosMatriculados($id_estudiante, $ciclo, $periodo_pecuniario){
		$tabla = $ciclo;
		$sql = "SELECT sum(creditos) as suma_creditos FROM $tabla WHERE id_estudiante= :id_estudiante and periodo= :periodo_pecuniario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para actualizar el semestre del estudiante
	public function actualizarsemestre($id_estudiante, $semestre_nuevo){
		$sql = "UPDATE estudiantes SET semestre_estudiante= :semestre_nuevo WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":semestre_nuevo", $semestre_nuevo);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();
	}
	//Implementamos un método para ieliminar la materia
	public function eliminarMateria($id_materia_matriculada, $ciclo){
		$tabla = "materias" . $ciclo;
		$sql = "DELETE FROM $tabla WHERE id_materia= :id_materia_matriculada";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia_matriculada", $id_materia_matriculada);
		return $consulta->execute();
	}
	//Implementamos un método para insertar registros
	public function trazabilidadMateriaEliminada($id_estudiante, $nombre_materia, $jornada_e, $periodo, $semestre, $promedio, $programa, $fecha, $usuario){

		$sql = "INSERT INTO trazabilidad_materias_eliminadas (id_estudiante,nombre_materia,jornada_e,periodo,semestre,promedio,programa,fecha,usuario)
		VALUES ('$id_estudiante','$nombre_materia','$jornada_e','$periodo','$semestre','$promedio','$programa','$fecha','$usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar la jornada de la ateria matriculada
	public function actualizarJornada($id_materia, $jornada, $ciclo){
		$sql = "UPDATE $ciclo SET jornada= :jornada WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_materia", $id_materia);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el periodo de la materia matriculada
	public function actualizarPeriodoMateria($id_materia, $periodo, $ciclo){
		$sql = "UPDATE $ciclo SET periodo= :periodo WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":id_materia", $id_materia);
		return $consulta->execute();
	}
	//Implementamos un método para actualizar el grupo de la materia matriculada
	public function actualizarGrupoMateria($id_materia, $grupo, $ciclo){
		$sql = "UPDATE $ciclo SET grupo= :grupo WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->bindParam(":id_materia", $id_materia);
		return $consulta->execute();
	}
	//Implementar un método para traer el periodo pecuniario
	public function traerperiodopecuniario(){
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer el valor del derecho pecuniario si es que lo tiene
	public function lista_precio_pecuniario($id_programa, $periodo_pecuniario){
		$sql = "SELECT * FROM lista_precio_pecuniario WHERE id_programa= :id_programa and periodo= :periodo_pecuniario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los precios del programa por semestre
	public function tablaprecios($id_programa, $periodo_pecuniario, $semestre){
		$sql = "SELECT * FROM lista_precio_programa WHERE id_programa= :id_programa and periodo= :periodo_pecuniario and semestre= :semestre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function fechaesp($date){ // convertir la fecha corta en larga
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
	//Implementar un método traer el ide de la materia eliminar en rematricula
	public function datosEliminar($id_rematricula, $ciclo){
		$tabla = "rematricula" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_rematricula= :id_rematricula";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_rematricula", $id_rematricula);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para saber si se puede eliminar la materia
	public function controlParaEliminar($ciclo, $id_estudiante, $nombre_materia){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id_estudiante and nombre_materia= :nombre_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":nombre_materia", $nombre_materia);
		return $consulta->execute();
	}
	//metodo para traer los datos de la materia
	public function traernombrejornadaespanol($jornada_e){
		$sql = "SELECT * FROM jornada WHERE nombre= :jornada_e";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":jornada_e", $jornada_e);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para consultar si tiene credito aprobado
	public function vercreditosofi($credencial_identificacion, $periodo_pecuniario){
		$sql = "SELECT * FROM sofi_persona sp INNER JOIN sofi_matricula sm ON sp.id_persona=sm.id_persona WHERE sp.numero_documento= :credencial_identificacion and sp.periodo= :periodo_pecuniario and sm.motivo_financiacion='Financiación matricula'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para consultar si tiene credito aprobado
	public function verestadocreditosofi($id_persona, $periodo_pecuniario){
		$sql = "SELECT * FROM sofi_persona sp INNER JOIN sofi_matricula sm ON sp.id_persona=sm.id_persona WHERE sp.id_persona= :id_persona and sp.periodo= :periodo_pecuniario and sm.motivo_financiacion='Financiación matricula'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para consultar las modalidades de la materia
	public function buscarmodalidad($id_materia){
		$sql = "SELECT * FROM materias_ciafi_modalidad WHERE id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//verificar que la materia modalidad no este matriculada
	public function siestarematriculadamodalidad($id_estudiante, $id_materia, $periodo){
		$sql = "SELECT * FROM materias_modalidad WHERE id_estudiante= :id_estudiante and id_materia= :id_materia and periodo= :periodo";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para insertar rematriculas
	public function addasignaturamodalidad($id_credencial, $id_estudiante, $id_programa_ac, $id_materia, $id_materias_ciafi_modalidad, $periodo_pecuniario, $fecha, $hora){
		$sql = "INSERT INTO materias_modalidad (id_credencial,id_estudiante,id_programa,id_materia,id_materias_ciafi_modalidad,periodo,fecha,hora)
		VALUES ('$id_credencial','$id_estudiante','$id_programa_ac','$id_materia','$id_materias_ciafi_modalidad','$periodo_pecuniario','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute();
		return $resultado;
	}
	//metodo para consultar si tiene matriculada una modalidad de grado
	public function buscarmatriculamodalidad($id_estudiante, $id_programa, $id_materia, $periodo_pecuniario){
		$sql = "SELECT * FROM materias_modalidad WHERE id_estudiante= :id_estudiante and id_programa= :id_programa and id_materia= :id_materia and periodo= :periodo_pecuniario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//metodo para consultar el nombre de la modalidad
	public function datosmodalidad($id_materias_ciafi_modalidad_m){
		$sql = "SELECT * FROM materias_ciafi_modalidad WHERE id_materias_ciafi_modalidad= :id_materias_ciafi_modalidad_m";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materias_ciafi_modalidad_m", $id_materias_ciafi_modalidad_m);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}