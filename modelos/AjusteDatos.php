<?php
session_start();
require "../config/Conexion.php";
class AjusteDatos{
	public function __construct() {}
	public function periodoactual()
	{
		$sql = "SELECT * FROM periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar niveles de estudio
	public function niveles()
	{
		$sql = "SELECT * FROM nivel ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estudiantes unicos que estan activos en la tabla estudiantes
	public function estudiantesunicos($periodo_actual, $nivel)
	{
		$sql = "SELECT DISTINCT id_credencial FROM estudiantes WHERE periodo_activo= :periodo_actual and ciclo= :nivel";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->bindParam(":nivel", $nivel);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estudiantes que estan activos en la tabla estudiantes
	public function estudiantesactivos($periodo_actual, $nivel)
	{
		$sql = "SELECT id_estudiante,id_credencial,id_programa_ac,fo_programa,semestre_estudiante,ciclo,periodo_activo FROM estudiantes WHERE periodo_activo= :periodo_actual  and ciclo= :nivel ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->bindParam(":nivel", $nivel);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para verificar si los estudiantes activos tienen materias matriculadas
	public function verificarmaterias($id_estudiante, $ciclo, $periodo)
	{
		$tabla = "materias" . $ciclo;
		$sql = "SELECT id_estudiante,periodo FROM $tabla WHERE id_estudiante= :id_estudiante AND periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estudiantes que estan activos en la tabla estudiantes
	public function datoscredencial($id_credencial)
	{
		$sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer los programas activos
	public function programas()
	{
		$sql = "SELECT * FROM programa_ac WHERE por_renovar=1 ORDER BY id_programa ASC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer los programas activos
	public function programasnivelatorio()
	{
		$sql = "SELECT * FROM programa_ac WHERE ciclo=5";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function renuevan($id_programa, $semestres, $periodo_anterior)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce on est.id_credencial=ce.id_credencial WHERE est.id_programa_ac= :id_programa and est.semestre_estudiante= :semestres and est.periodo_activo= :periodo_anterior";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":semestres", $semestres);
		$consulta->bindParam(":periodo_anterior", $periodo_anterior);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para saber quienes perdieron materia y quiene ganaron
	public function promediorenovar($id_estudiante, $id_programa, $ciclo)
	{
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id_estudiante and programa= :id_programa and promedio < '3'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método cambiar el estado de los que no deben renovar
	public function actualizarestadorenovacion($id_estudiante)
	{
		$sql = "UPDATE estudiantes SET renovar='0' WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estudiantes que estan activos en la tabla estudiantes
	public function estudiantesperiodoactivo($periodo_actual)
	{
		$sql = "SELECT id_estudiante,id_credencial,id_programa_ac,fo_programa,jornada_e,semestre_estudiante,ciclo,periodo_activo FROM estudiantes WHERE periodo_activo= :periodo_actual and estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para consultar si el estudiante activo esta en la tabla estudiantes activos
	public function consultarsiesta($id_estudiante, $periodo_actual)
	{
		$sql = "SELECT * FROM estudiantes_activos WHERE id_estudiante= :id_estudiante and periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para traer el id de la escuela dependiendo del programa
	public function verescuela($id_programa)
	{
		$sql = "SELECT id_programa, nombre, escuela, cant_asignaturas FROM programa_ac WHERE id_programa= :id_programa ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function insertarestudianteactivo($id_estudiante, $id_credencial, $jornada_e, $periodo_actual, $semestre, $programa, $nivel, $escuela)
	{
		$sql = "INSERT INTO estudiantes_activos (id_estudiante,id_credencial,jornada_e,periodo,semestre,programa,nivel,escuela)
			VALUES ('$id_estudiante','$id_credencial','$jornada_e','$periodo_actual','$semestre','$programa','$nivel','$escuela')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function listarestudiantes($id_programa, $semestres)
	{ // consutla para traer todos lo estudaintes de un programa que no estan graduados ni egresados, que esten en matriculado
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce on est.id_credencial=ce.id_credencial WHERE est.id_programa_ac= :id_programa and est.semestre_estudiante= :semestres and est.estado='1'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":semestres", $semestres);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function listarmaterias($id_estudiante, $id_programa, $ciclo)
	{ // consulta para traer el total de materias matriculadas
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id_estudiante and programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método cambiar el estado a egresado
	public function actualizarestado($id_estudiante)
	{
		$sql = "UPDATE estudiantes SET estado='5' WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarestudiantesnivelatorio($id_programa)
	{ // consutla para traer todos lo estudaintes de un programa que no estan graduados ni egresados, que esten en matriculado
		$sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce on est.id_credencial=ce.id_credencial WHERE est.id_programa_ac= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para traer el nombre del estado academico
	public function nombreestado($estado)
	{
		$sql = "SELECT * FROM estado_academico  WHERE id_estado_academico= :estado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":estado", $estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function mirarprogramaterminal($id_credencial)
	{ // consulta para traer el total de materias matriculadas
		$sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and ciclo=3";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método cambiar el estado de pago renovar
	public function cambiarestadopago($id_estudiante)
	{
		$sql = "UPDATE estudiantes SET pago_renovar='0' WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estudiantes que estan activos en la tabla estudiantes
	public function estudiantestablaactivo($periodo_actual)
	{
		$sql = "SELECT * FROM estudiantes_activos WHERE periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para consultar si el estudiante de la tabla activo activo esta en la tabla estudiantes
	public function consultarsiestaactivo($id_estudiante, $periodo_actual)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante and periodo_activo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para consultar si el estudiante de la tabla activo activo esta en la tabla estudiantes
	public function datoTablaEstuidante($id_estudiante)
	{
		$sql = "SELECT * FROM estudiantes est INNER JOIN estado_academico estac ON est.estado= estac.id_estado_academico   WHERE est.id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para consultar si el estudiante de la tabla activo activo esta en la tabla estudiantes
	public function eliminaractivo($id_estudiante_activo)
	{
		$sql = "DELETE FROM estudiantes_activos WHERE id_estudiante_activo= :id_estudiante_activo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante_activo", $id_estudiante_activo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estudiantes de la tabla credencial estudiante
	public function listarcredencialestudiante()
	{
		$sql = "SELECT * FROM credencial_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para verificar si tienen los datos personales en la tabla estudiantes datos personales
	public function datospersonales($id_credencial)
	{
		$sql = "SELECT * FROM estudiantes_datos_personales WHERE id_credencial= :id_credencial ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para registrar la credencial en estudiantes datos eprsonales
	public function insertardatospersonales($id_credencial)
	{
		$sql = "INSERT INTO estudiantes_datos_personales (id_credencial) VALUES ('$id_credencial')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	//Implementar un método para listar los estudiantes qtienen materias matriculadas
	public function estudiantesactivosdos($periodo_actual, $nivel)
	{
		$tabla = "materias" . $nivel;
		$sql = "SELECT DISTINCT id_estudiante FROM $tabla WHERE periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para verificar si tienen los datos personales en la tabla estudiantes datos personales
	public function verificarperiodo($id_estudiante, $periodo_anterior)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante AND periodo_activo= :periodo_anterior ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":periodo_anterior", $periodo_anterior);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarmateriassemestre($id_estudiante, $id_programa, $ciclo, $semestre)
	{ // consulta para traer el total de materias matriculadas
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id_estudiante and programa= :id_programa and semestre= :semestre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estudiantes de la tabla credencial estudiante
	public function estudiantesdatospersonales()
	{
		$sql = "SELECT * FROM estudiantes_datos_personales WHERE `genero` IS NULL OR genero != 'Masculino' AND genero != 'Femenino' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para actualziar el sexo
	public function cambiosexo($id_credencial, $sexo)
	{
		$sql = "UPDATE `estudiantes_datos_personales` SET genero= :sexo WHERE id_credencial= :id_credencial ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":sexo", $sexo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementamos un método para eliminar el registero en estudiantes datos personales
	public function eliminarRegistrodato($id_credencial)
	{
		$sql = "DELETE FROM estudiantes_datos_personales WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estudiantes de la tabla credencial estudiante
	public function buscaractivostotal($nivel, $periodo)
	{
		$sql = "SELECT * FROM estudiantes_activos ea INNER JOIN estudiantes est ON ea.id_estudiante=est.id_estudiante INNER JOIN credencial_estudiante ce ON ea.id_credencial=ce.id_credencial WHERE ea.nivel= :nivel AND ea.periodo= :periodo ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nivel", $nivel);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para actualziar el estado graduado en activos
	public function actualizaractivoegresado($id_estudiante_activo)
	{
		$sql = "UPDATE `estudiantes_activos` SET graduado=0 WHERE id_estudiante_activo= :id_estudiante_activo ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante_activo", $id_estudiante_activo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function buscaractivostotalperiodo($periodo)
	{
		$sql = "SELECT * FROM estudiantes_activos ea INNER JOIN estudiantes est ON ea.id_estudiante=est.id_estudiante INNER JOIN credencial_estudiante ce ON ea.id_credencial=ce.id_credencial WHERE ea.periodo= :periodo ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para actualziar el estado graduado en activos
	public function actualizarestadomatricula($id_estudiante_activo, $estado)
	{
		$sql = "UPDATE `estudiantes_activos` SET estado_matricula= :estado WHERE id_estudiante_activo= :id_estudiante_activo ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante_activo", $id_estudiante_activo);
		$consulta->bindParam(":estado", $estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estudiantes de sofi pesona sin credencial
	public function sofi_persona()
	{
		$sql = "SELECT * FROM sofi_persona WHERE id_credencial IS NULL ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementamos un método para traer el id_credencial de la tabla credencial estudiante
	public function mirarCredencial($numero_documento)
	{
		$sql = "SELECT * FROM credencial_estudiante WHERE credencial_identificacion= :numero_documento ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":numero_documento", $numero_documento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Actualziar la credencial en sofi_persona
	public function actualizarCredencial($id_persona, $idcredencial)
	{
		$sql = "UPDATE `sofi_persona` SET id_credencial= :idcredencial WHERE id_persona= :id_persona";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->bindParam(":idcredencial", $idcredencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los estudiantes de sofi pesona sin credencial
	public function sofi_tareas()
	{
		$sql = "SELECT * FROM sofi_tareas st INNER JOIN sofi_persona sp ON st.id_persona=sp.id_persona WHERE st.id_credencial IS NULL ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Actualziar la credencial en sofi_persona
	public function actualizarCredencialTareas($id_persona, $idcredencial)
	{
		$sql = "UPDATE `sofi_tareas` SET id_credencial= :idcredencial WHERE id_persona= :id_persona";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_persona", $id_persona);
		$consulta->bindParam(":idcredencial", $idcredencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function listarCreditosActivos(){
		global $mbd;
		$sentencia = $mbd->prepare("SELECT * FROM `sofi_matricula` WHERE `credito_finalizado` = 0 ORDER BY `dias_atrasados` ASC");
		$sentencia->execute();
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}
	public function calcularValoresDeuda($consecutivo) {
		global $mbd;
		$sentencia = $mbd->prepare("SELECT SUM(`valor_cuota`) AS `total_deuda`, SUM(`valor_pagado`) AS `total_pagado` FROM `sofi_financiamiento` WHERE `id_matricula` = $consecutivo");
		$sentencia->execute();
		$registros = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
	public function finalizarCredito($id){
		global $mbd;
		$sentencia = $mbd->prepare("UPDATE `sofi_matricula` SET `sofi_matricula`.`credito_finalizado` = 1 WHERE `sofi_matricula`.`id` = :id;");
		$sentencia->bindParam(':id', $id);
		$sentencia->execute();
	}

		//Implementar un método para listar los seguimeintos que no tienen id persona
		public function sofipersonamatricula()
		{
			$sql = "SELECT * FROM sofi_seguimientos WHERE id_persona IS NULL ";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		public function buscarIdPersona($id_credencial){
			global $mbd;
			$sentencia = $mbd->prepare("SELECT * FROM sofi_persona sp INNER JOIN sofi_matricula sm ON sp.id_persona=sm.id_persona WHERE sp.id_credencial= :id_credencial AND sm.credito_finalizado='0'");
			$sentencia->bindParam(":id_credencial", $id_credencial);
			$sentencia->execute();
			$registros = $sentencia->fetch(PDO::FETCH_ASSOC);
			return $registros;
		}

			//Actualziar la credencial en sofi_persona
		public function actualizarIdPersonaSegui($id_seguimiento,$idencontrado)
		{
			$sql = "UPDATE `sofi_seguimientos` SET id_persona= :idencontrado WHERE id_segumiento= :id_seguimiento";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_seguimiento", $id_seguimiento);
			$consulta->bindParam(":idencontrado", $idencontrado);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		        
	public function debenrenovar($periodo){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo AND renovo_financiera='1' AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND (`jornada_e` IN ('N01','F01','D01','S01'))";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	    //Implementar un método para verificar a jornada de estudio si es una joranda para renovar
		public function buscarcredito($identificacion,$periodo_pecuniario)
		{
			$sql="SELECT * FROM sofi_persona WHERE numero_documento= :identificacion and periodo= :periodo_pecuniario and estado='Aprobado'";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":identificacion", $identificacion);
			$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		
		public function buscarpagos($identificacion,$periodo_pecuniario)
		{
			$sql="SELECT * FROM pagos_rematricula WHERE identificacion_estudiante= :identificacion and periodo_pecuniario= :periodo_pecuniario and x_respuesta='Aceptada'";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":identificacion", $identificacion);
			$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		public function buscarpagosweb($identificacion,$periodo_pecuniario)
		{
			$sql = "SELECT * FROM `web_pagos_pse`  WHERE identificacion_estudiante= :identificacion AND `periodo` = :periodo_pecuniario";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":identificacion", $identificacion);
			$consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		public function actualizarPagoRenovacion($id_estudiante_activo,$valor)
		{
			$sql = "UPDATE `estudiantes_activos` SET renovo_financiera= :valor WHERE id_estudiante_activo= :id_estudiante_activo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_estudiante_activo", $id_estudiante_activo);
			$consulta->bindParam(":valor", $valor);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		// consultas para ajustar los que debe renovar

		
	//Implementar un método para listar los estudiantes labroales

	public function general($periodo){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo  AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que no renovaron
	public function generalpendiente($periodoantes){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `renovo_financiera`=1 AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que si renovaron
	public function generalrenovo($periodoantes){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND (`renovo_financiera` IN (2,3)) AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
		//Implementar un método para listar los estudiantes que si renovaron
		public function generalrenovofc($periodoantes,$renovo){

			$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `renovo_financiera`= :renovo AND `jornada_e` in ('D01','N01','F01','S01')";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":periodoantes", $periodoantes);
			$consulta->bindParam(":renovo", $renovo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

	public function generalprograma($periodo,$escuela){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo AND `escuela`= :escuela AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que si renovaron
	public function programarenovo($periodoantes,$escuela){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND `escuela`= :escuela AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND (`renovo_financiera` IN (2,3)) AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estudiantes que si renovaron
	public function programarenovofc($periodoantes,$escuela,$renovo){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND `escuela`= :escuela AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `renovo_financiera`= :renovo AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->bindParam(":renovo", $renovo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que no renovaron
	public function programapendiente($periodoantes,$escuela){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND `escuela`= :escuela AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `renovo_financiera`=1 AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	

	public function generallaboral($periodo,$escuela,$programa){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo AND `escuela`= :escuela AND `programa`= :programa AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los estudiantes que si renovaron
	public function laboralrenovo($periodoantes,$escuela,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND `escuela`= :escuela AND `programa`= :programa AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND (`renovo_financiera` IN (2,3)) AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para listar los estudiantes que si renovaron
	public function laboralrenovofc($periodoantes,$escuela,$programa,$renovo){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND `escuela`= :escuela AND `programa`= :programa AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `renovo_financiera`= :renovo AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->bindParam(":programa", $programa);
		$consulta->bindParam(":renovo", $renovo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para listar los estudiantes que no renovaron
	public function laboralpendiente($periodoantes,$escuela,$programa){

		$sql="SELECT * FROM `estudiantes_activos` WHERE `periodo`= :periodoantes AND `escuela`= :escuela AND `programa`= :programa AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND `renovo_financiera`=1 AND `jornada_e` in ('D01','N01','F01','S01')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodoantes", $periodoantes);
		$consulta->bindParam(":escuela", $escuela);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function marcaracademica($periodo){

		$sql="SELECT * FROM estudiantes_activos WHERE periodo= :periodo  AND (`nivel` IN (1, 2, 5) OR (`nivel` IN (3, 7) AND `graduado` = 1)) AND (`jornada_e` IN ('N01','F01','D01','S01'))";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public function marcaracademicarenovo($id_credencial,$periodo){


		$sql = "SELECT * FROM estudiantes_activos WHERE id_credencial= :id_credencial AND periodo= :periodo and escuela !=4 ";
		 global $mbd;
		 $consulta = $mbd->prepare($sql);
		 $consulta -> bindParam(":id_credencial", $id_credencial);
		 $consulta -> bindParam(":periodo", $periodo);
		 $consulta -> execute();
		 $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		 return $resultado;
		   
	  
	 }

	//Implementar un método para traer el nombre del programa
	public function traer_nom_programa($id_programa)
	{
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function actualizarrenovoacademica($id_estudiante_activo,$renovo_academica,$renovo_academica_semestre)
	{
		$sql = "UPDATE `estudiantes_activos` SET renovo_academica= :renovo_academica, renovo_academica_semestre= :renovo_academica_semestre WHERE id_estudiante_activo= :id_estudiante_activo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante_activo", $id_estudiante_activo);
		$consulta->bindParam(":renovo_academica", $renovo_academica);
		$consulta->bindParam(":renovo_academica_semestre", $renovo_academica_semestre);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



	public function traer_estudiantes()
	{

		// SELECT es.id_credencial, es.credencial_nombre, es.credencial_nombre_2, es.credencial_apellido, es.credencial_apellido_2, es.credencial_identificacion, ed.fecha_nacimiento FROM credencial_estudiante es INNER JOIN estudiantes_datos_personales ed ON es.id_credencial = ed.id_credencial 

		// , est.periodo INNER JOIN estudiantes est ON es.id_credencial = est.id_credencial
		$sql = "SELECT es.id_credencial, es.credencial_nombre, es.credencial_nombre_2, es.credencial_apellido, es.credencial_apellido_2, es.credencial_identificacion, ed.fecha_nacimiento FROM credencial_estudiante es INNER JOIN estudiantes_datos_personales ed ON es.id_credencial = ed.id_credencial 
		
		
		";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	public function Insertar_Datos_Estudiantes($id_credencial, $credencial_nombre, $credencial_nombre_2, $credencial_apellido, $credencial_apellido_2, $credencial_identificacion, $fecha_nacimiento,$periodo,$fo_programa,$ciclo) {
		$sql = "INSERT INTO segmentacion_estudiantes (id_credencial, credencial_nombre, credencial_nombre_2, credencial_apellido, credencial_apellido_2, credencial_identificacion, fecha_nacimiento,periodo,fo_programa,ciclo) VALUES ('$id_credencial', '$credencial_nombre', '$credencial_nombre_2', '$credencial_apellido', '$credencial_apellido_2', '$credencial_identificacion', '$fecha_nacimiento', '$periodo', '$fo_programa','$ciclo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	
	public function verificarExistenciaDocumento($credencial_identificacion) {
		global $mbd;
		$sql = "SELECT COUNT(*) FROM segmentacion_estudiantes WHERE credencial_identificacion = :credencial_identificacion";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':credencial_identificacion', $credencial_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchColumn();
		return $resultado > 0; 
	}


	public function inicio_ingreso_estudiante($id_credencial)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_credencial = :id_credencial ORDER BY periodo ASC LIMIT 1";  
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$registro = $consulta->fetch(PDO::FETCH_ASSOC);
        return $registro;

		
	}

	// ajustes para subir el porcentaje de la hoja de vida 
	public function listar()
    {
        $sql = "SELECT `cv_usuario`.`id_usuario_cv`,`cv_usuario`.`usuario_identificacion`,`cv_usuario`.`usuario_nombre`,`cv_usuario`.`usuario_clave`,`cv_usuario`.`usuario_apellido`,`cv_usuario`.`usuario_email`, `cv_usuario`.`usuario_condicion`, `cv_informacion_personal`.`telefono`, `cv_informacion_personal`.`estado`, `cv_informacion_personal`.`create_dt` FROM `cv_usuario` LEFT JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv`";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function obtenerProgresoUsuario($id_usuario_cv)
    {
        global $mbd;
        // realizamos una subconsulta para optimizar el codigo
        $sql = "SELECT 
        (SELECT COUNT(*) FROM cv_informacion_personal WHERE id_usuario_cv = :id_usuario_cv) AS info_personal,
        (SELECT COUNT(*) FROM cv_educacion_formacion WHERE id_usuario_cv = :id_usuario_cv) AS educacion,
        (SELECT COUNT(*) FROM cv_experiencia_laboral WHERE id_usuario_cv = :id_usuario_cv) AS experiencia,
        (SELECT COUNT(*) FROM cv_habilidades_aptitudes WHERE id_usuario_cv = :id_usuario_cv) AS habilidades,
        (SELECT COUNT(*) FROM cv_referencias_personal WHERE id_usuario_cv = :id_usuario_cv) AS referencias_personales,
        (SELECT COUNT(*) FROM cv_portafolio WHERE id_usuario_cv = :id_usuario_cv) AS portafolio,
        (SELECT COUNT(*) FROM cv_referencias_laborales WHERE id_usuario_cv = :id_usuario_cv) AS referencias_laborales,
        (SELECT COUNT(*) FROM cv_documentacion_usuario WHERE id_usuario_cv = :id_usuario_cv) AS documentos_adicionales,
        (SELECT COUNT(*) FROM cv_documentacion_usuario WHERE id_usuario_cv = :id_usuario_cv) AS documentos_adicionales,
        (SELECT COUNT(*) FROM cv_areas_de_conocimiento WHERE id_usuario_cv = :id_usuario_cv) AS areas_conocimiento";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(':id_usuario_cv', $id_usuario_cv);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC); 
    }

	public function obtenertotaldocumentosobligatorios($id_usuario_cv)
    {
        global $mbd;
        $sql = "SELECT COUNT(DISTINCT documento_nombre) FROM cv_documentacion_usuario  WHERE id_usuario_cv = :id_usuario_cv AND documento_nombre IN ('Cédula de ciudadanía','Certificación Bancaria','Antecedentes Judiciales Policía','Antecedentes Contraloría','Antecedentes Procuraduría','Referencias Laborales','Certificado Afiliación EPS','Certificado Afiliación AFP')";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(':id_usuario_cv', $id_usuario_cv);
        $consulta->execute();
        return $consulta->fetchColumn(); // Devuelve un solo número
    }


	public function actualiazrporcentajehojavida($cedula, $porcentaje_avance)
{
    global $mbd;
    $sql = "UPDATE cv_usuario 
            SET porcentaje_avance = :porcentaje_avance 
            WHERE usuario_identificacion = :cedula";

    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(':porcentaje_avance', $porcentaje_avance);
    $consulta->bindParam(':cedula', $cedula);
    return $consulta->execute();
}



// para alimentar la tabla madre

	//Implementar un método para listar los estudiantes activos
	public function listarmadre($periodo)
	{	
		$sql="SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN programa_ac pac ON est.id_programa_ac=pac.id_programa INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo AND est.estado NOT IN ('3', '4') and pac.estado_activos='1' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	

		public function insertarmadreid($id_credencial,$identificacion,$nombreCompleto,$programaactual,$programa,$jornada,$escuela,$semestre,$nivel,$periodo)
	{
		$sql = "INSERT INTO estudiantes_info_completa (id_credencial,credencial_identificacion,nombre_completo,programa_actual,programa,jornada_e,escuela,semestre,nivel,periodo)
			VALUES ('$id_credencial','$identificacion','$nombreCompleto','$programaactual','$programa','$jornada','$escuela','$semestre','$nivel','$periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	public function listarcredencialmadre($periodo)
	{	
		$sql="SELECT * FROM estudiantes_info_completa WHERE periodo= :periodo ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para actualizar el perfil
	public function actualizarperfilmadre(
		$id_credencial,
		$genero,
		$periodo_ingreso,
		$fecha_nacimiento,
		$departamento_nacimiento,
		$municipio_nacimiento,
		$estado_civil,
		$grupo_etnico,
		$nombre_etnico,
		$desplazado_violencia,
		$conflicto_armado,
		$departamento_residencia,
		$municipio_residencia,
		$tipo_residencia,
		$zona_residencia,
		$direccion,
		$barrio,
		$estrato,
		$celular,
		$whatsapp,
		$instagram,
		$facebook,
		$twitter,
		$email_personal,
		$tipo_sangre
		) {
		$sql = "UPDATE estudiantes_info_completa SET 
			genero = :genero,
			periodo_ingreso = :periodo_ingreso,
			fecha_nacimiento = :fecha_nacimiento,
			departamento_nacimiento = :departamento_nacimiento,
			municipio_nacimiento = :municipio_nacimiento,
			estado_civil = :estado_civil,
			grupo_etnico = :grupo_etnico,
			nombre_etnico = :nombre_etnico,
			desplazado_violencia = :desplazado_violencia,
			conflicto_armado = :conflicto_armado,
			departamento_residencia = :departamento_residencia,
			municipio_residencia = :municipio_residencia,
			tipo_residencia = :tipo_residencia,
			zona_residencia = :zona_residencia,
			direccion = :direccion,
			barrio = :barrio,
			estrato = :estrato,
			celular = :celular,
			whatsapp = :whatsapp,
			instagram = :instagram,
			facebook = :facebook,
			twitter = :twitter,
			email_personal = :email_personal,
			tipo_sangre = :tipo_sangre
		WHERE id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute([
			':id_credencial'            => $id_credencial,
			':genero'                   => $genero,
			':periodo_ingreso'          => $periodo_ingreso,
			':fecha_nacimiento'         => $fecha_nacimiento,
			':departamento_nacimiento'  => $departamento_nacimiento,
			':municipio_nacimiento'     => $municipio_nacimiento,
			':estado_civil'             => $estado_civil,
			':grupo_etnico'             => $grupo_etnico,
			':nombre_etnico'            => $nombre_etnico,
			':desplazado_violencia'     => $desplazado_violencia,
			':conflicto_armado'         => $conflicto_armado,
			':departamento_residencia'  => $departamento_residencia,
			':municipio_residencia'     => $municipio_residencia,
			':tipo_residencia'          => $tipo_residencia,
			':zona_residencia'          => $zona_residencia,
			':direccion'                => $direccion,
			':barrio'                   => $barrio,
			':estrato'                  => $estrato,
			':celular'                  => $celular,
			':whatsapp'                 => $whatsapp,
			':instagram'                => $instagram,
			':facebook'                 => $facebook,
			':twitter'                  => $twitter,
			':email_personal'           => $email_personal,
			':tipo_sangre'              => $tipo_sangre
		]);

		return $resultado;
	}

	public function actualizarseresmadre(
		$id_credencial,
		$estas_embarazada,
		$meses_embarazo,
		$eres_desplazado_violencia,
		$tipo_desplazamiento,
		$grupo_poblacional,
		$comunidad_lgbtiq,
		$cual_comunidad,
		$contacto1_nombre,
		$contacto1_relacion,
		$contacto1_email,
		$contacto1_telefono,
		$contacto2_nombre,
		$contacto2_relacion,
		$contacto2_email,
		$contacto2_telefono,
		$tiene_computador_tablet,
		$conexion_internet_casa,
		$planes_datos_celular
		) {
		$sql = "UPDATE estudiantes_info_completa SET 
			estas_embarazada = :estas_embarazada,
			meses_embarazo = :meses_embarazo,
			eres_desplazado_violencia = :eres_desplazado_violencia,
			tipo_desplazamiento = :tipo_desplazamiento,
			grupo_poblacional = :grupo_poblacional,
			comunidad_lgbtiq = :comunidad_lgbtiq,
			cual_comunidad = :cual_comunidad,
			contacto1_nombre = :contacto1_nombre,
			contacto1_relacion = :contacto1_relacion,
			contacto1_email = :contacto1_email,
			contacto1_telefono = :contacto1_telefono,
			contacto2_nombre = :contacto2_nombre,
			contacto2_relacion = :contacto2_relacion,
			contacto2_email = :contacto2_email,
			contacto2_telefono = :contacto2_telefono,
			tiene_computador_tablet = :tiene_computador_tablet,
			conexion_internet_casa = :conexion_internet_casa,
			planes_datos_celular = :planes_datos_celular
		WHERE id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute([
			':id_credencial'            => $id_credencial,
			':estas_embarazada'         => $estas_embarazada,
			':meses_embarazo'           => $meses_embarazo,
			':eres_desplazado_violencia'=> $eres_desplazado_violencia,
			':tipo_desplazamiento'      => $tipo_desplazamiento,
			':grupo_poblacional'        => $grupo_poblacional,
			':comunidad_lgbtiq'         => $comunidad_lgbtiq,
			':cual_comunidad'           => $cual_comunidad,
			':contacto1_nombre'         => $contacto1_nombre,
			':contacto1_relacion'       => $contacto1_relacion,
			':contacto1_email'          => $contacto1_email,
			':contacto1_telefono'       => $contacto1_telefono,
			':contacto2_nombre'         => $contacto2_nombre,
			':contacto2_relacion'       => $contacto2_relacion,
			':contacto2_email'          => $contacto2_email,
			':contacto2_telefono'       => $contacto2_telefono,
			':tiene_computador_tablet'  => $tiene_computador_tablet,
			':conexion_internet_casa'   => $conexion_internet_casa,
			':planes_datos_celular'     => $planes_datos_celular
		]);

		return $resultado;
	}

	public function actualizarinspmadre(
		$id_credencial,
		$estado_civil_2,
		$tiene_hijos,
		$cantidad_hijos,
		$padre_vivo,
		$nombre_padre,
		$telefono_padre,
		$nivel_educativo_padre,
		$madre_viva,
		$nombre_madre,
		$telefono_madre,
		$nivel_educativo_madre,
		$situacion_laboral_padres,
		$sector_laboral_padres,
		$cursos_interes_padres,
		$tienes_pareja,
		$nombre_pareja,
		$celular_pareja,
		$tienes_hermanos,
		$cantidad_hermanos,
		$edad_hermanos,
		$con_quien_vive,
		$personas_a_cargo,
		$cantidad_personas_cargo,
		$inspirador_estudio,
		$nombre_inspirador,
		$whatsapp_inspirador,
		$email_inspirador,
		$nivel_formacion_inspirador,
		$situacion_laboral_inspirador,
		$sector_inspirador,
		$cursos_inspirador
		) {
		$sql = "UPDATE estudiantes_info_completa SET 
			estado_civil_2 = :estado_civil_2,
			tiene_hijos = :tiene_hijos,
			cantidad_hijos = :cantidad_hijos,
			padre_vivo = :padre_vivo,
			nombre_padre = :nombre_padre,
			telefono_padre = :telefono_padre,
			nivel_educativo_padre = :nivel_educativo_padre,
			madre_viva = :madre_viva,
			nombre_madre = :nombre_madre,
			telefono_madre = :telefono_madre,
			nivel_educativo_madre = :nivel_educativo_madre,
			situacion_laboral_padres = :situacion_laboral_padres,
			sector_laboral_padres = :sector_laboral_padres,
			cursos_interes_padres = :cursos_interes_padres,
			tienes_pareja = :tienes_pareja,
			nombre_pareja = :nombre_pareja,
			celular_pareja = :celular_pareja,
			tienes_hermanos = :tienes_hermanos,
			cantidad_hermanos = :cantidad_hermanos,
			edad_hermanos = :edad_hermanos,
			con_quien_vive = :con_quien_vive,
			personas_a_cargo = :personas_a_cargo,
			cantidad_personas_cargo = :cantidad_personas_cargo,
			inspirador_estudio = :inspirador_estudio,
			nombre_inspirador = :nombre_inspirador,
			whatsapp_inspirador = :whatsapp_inspirador,
			email_inspirador = :email_inspirador,
			nivel_formacion_inspirador = :nivel_formacion_inspirador,
			situacion_laboral_inspirador = :situacion_laboral_inspirador,
			sector_inspirador = :sector_inspirador,
			cursos_inspirador = :cursos_inspirador
		WHERE id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute([
			':id_credencial'                 => $id_credencial,
			':estado_civil_2'               => $estado_civil_2,
			':tiene_hijos'                  => $tiene_hijos,
			':cantidad_hijos'               => $cantidad_hijos,
			':padre_vivo'                   => $padre_vivo,
			':nombre_padre'                 => $nombre_padre,
			':telefono_padre'               => $telefono_padre,
			':nivel_educativo_padre'        => $nivel_educativo_padre,
			':madre_viva'                   => $madre_viva,
			':nombre_madre'                 => $nombre_madre,
			':telefono_madre'               => $telefono_madre,
			':nivel_educativo_madre'        => $nivel_educativo_madre,
			':situacion_laboral_padres'     => $situacion_laboral_padres,
			':sector_laboral_padres'        => $sector_laboral_padres,
			':cursos_interes_padres'        => $cursos_interes_padres,
			':tienes_pareja'                => $tienes_pareja,
			':nombre_pareja'                => $nombre_pareja,
			':celular_pareja'               => $celular_pareja,
			':tienes_hermanos'              => $tienes_hermanos,
			':cantidad_hermanos'            => $cantidad_hermanos,
			':edad_hermanos'                => $edad_hermanos,
			':con_quien_vive'               => $con_quien_vive,
			':personas_a_cargo'             => $personas_a_cargo,
			':cantidad_personas_cargo'      => $cantidad_personas_cargo,
			':inspirador_estudio'           => $inspirador_estudio,
			':nombre_inspirador'            => $nombre_inspirador,
			':whatsapp_inspirador'          => $whatsapp_inspirador,
			':email_inspirador'             => $email_inspirador,
			':nivel_formacion_inspirador'   => $nivel_formacion_inspirador,
			':situacion_laboral_inspirador' => $situacion_laboral_inspirador,
			':sector_inspirador'            => $sector_inspirador,
			':cursos_inspirador'            => $cursos_inspirador
		]);

		return $resultado;
	}

	public function actualizarempresasmadre(
		$id_credencial,
		$trabajas_actualmente,
		$empresa_trabajas,
		$sector_empresa_trabajas,
		$direccion_empresa,
		$telefono_empresa,
		$jornada_laboral,
		$incentivos_empresa_formacion,
		$alguien_trabajo_te_inspiro,
		$nombre_inspirador_trabajo,
		$telefono_inspirador_trabajo,
		$empresa_propia,
		$nombre_razon_empresa,
		$tienes_emprendimiento,
		$nombre_emprendimiento,
		$sector_emprendimiento,
		$motivacion_emprender,
		$recursos_emprendimiento,
		$curso_emprendimiento,
		$cual_curso_emprendimiento
		) {
		$sql = "UPDATE estudiantes_info_completa SET 
			trabajas_actualmente = :trabajas_actualmente,
			empresa_trabajas = :empresa_trabajas,
			sector_empresa_trabajas = :sector_empresa_trabajas,
			direccion_empresa = :direccion_empresa,
			telefono_empresa = :telefono_empresa,
			jornada_laboral = :jornada_laboral,
			incentivos_empresa_formacion = :incentivos_empresa_formacion,
			alguien_trabajo_te_inspiro = :alguien_trabajo_te_inspiro,
			nombre_inspirador_trabajo = :nombre_inspirador_trabajo,
			telefono_inspirador_trabajo = :telefono_inspirador_trabajo,
			empresa_propia = :empresa_propia,
			nombre_razon_empresa = :nombre_razon_empresa,
			tienes_emprendimiento = :tienes_emprendimiento,
			nombre_emprendimiento = :nombre_emprendimiento,
			sector_emprendimiento = :sector_emprendimiento,
			motivacion_emprender = :motivacion_emprender,
			recursos_emprendimiento = :recursos_emprendimiento,
			curso_emprendimiento = :curso_emprendimiento,
			cual_curso_emprendimiento = :cual_curso_emprendimiento
			WHERE id_credencial = :id_credencial";

			global $mbd;
			$consulta = $mbd->prepare($sql);
			$resultado = $consulta->execute([
				":trabajas_actualmente" => $trabajas_actualmente,
				":empresa_trabajas" => $empresa_trabajas,
				":sector_empresa_trabajas" => $sector_empresa_trabajas,
				":direccion_empresa" => $direccion_empresa,
				":telefono_empresa" => $telefono_empresa,
				":jornada_laboral" => $jornada_laboral,
				":incentivos_empresa_formacion" => $incentivos_empresa_formacion,
				":alguien_trabajo_te_inspiro" => $alguien_trabajo_te_inspiro,
				":nombre_inspirador_trabajo" => $nombre_inspirador_trabajo,
				":telefono_inspirador_trabajo" => $telefono_inspirador_trabajo,
				":empresa_propia" => $empresa_propia,
				":nombre_razon_empresa" => $nombre_razon_empresa,
				":tienes_emprendimiento" => $tienes_emprendimiento,
				":nombre_emprendimiento" => $nombre_emprendimiento,
				":sector_emprendimiento" => $sector_emprendimiento,
				":motivacion_emprender" => $motivacion_emprender,
				":recursos_emprendimiento" => $recursos_emprendimiento,
				":curso_emprendimiento" => $curso_emprendimiento,
				":cual_curso_emprendimiento" => $cual_curso_emprendimiento,
				":id_credencial" => $id_credencial
			]);

		return $resultado;
	}

	public function actualizarconfiamosmadre(
		$id_credencial,
		$ingresos_mensuales,
		$quien_paga_matricula,
		$apoyo_financiero,
		$recibe_prima_cesantias,
		$obligaciones_financieras,
		$tipo_obligaciones
		) {
		$sql = "UPDATE estudiantes_info_completa SET 
			ingresos_mensuales = :ingresos_mensuales,
			quien_paga_matricula = :quien_paga_matricula,
			apoyo_financiero = :apoyo_financiero,
			recibe_prima_cesantias = :recibe_prima_cesantias,
			obligaciones_financieras = :obligaciones_financieras,
			tipo_obligaciones = :tipo_obligaciones
			WHERE id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute([
			":ingresos_mensuales" => $ingresos_mensuales,
			":quien_paga_matricula" => $quien_paga_matricula,
			":apoyo_financiero" => $apoyo_financiero,
			":recibe_prima_cesantias" => $recibe_prima_cesantias,
			":obligaciones_financieras" => $obligaciones_financieras,
			":tipo_obligaciones" => $tipo_obligaciones,
			":id_credencial" => $id_credencial
		]);

		return $resultado;
	}


	public function actualizarexperienciamadre(
		$id_credencial,
		$motivacion_estudio,
		$como_enteraste_ciaf,
		$area_preferencia,
		$forma_aprendizaje,
		$doble_titulacion,
		$programa_interes,
		$dominas_segundo_idioma,
		$cual_idioma,
		$nivel_idioma,
		$segundo_contacto_emergencia_nombre
		) {
		$sql = "UPDATE estudiantes_info_completa SET 
			motivacion_estudio = :motivacion_estudio,
			como_enteraste_ciaf = :como_enteraste_ciaf,
			area_preferencia = :area_preferencia,
			forma_aprendizaje = :forma_aprendizaje,
			doble_titulacion = :doble_titulacion,
			programa_interes = :programa_interes,
			dominas_segundo_idioma = :dominas_segundo_idioma,
			cual_idioma = :cual_idioma,
			nivel_idioma = :nivel_idioma,
			segundo_contacto_emergencia_nombre = :segundo_contacto_emergencia_nombre
			WHERE id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute([
			":motivacion_estudio" => $motivacion_estudio,
			":como_enteraste_ciaf" => $como_enteraste_ciaf,
			":area_preferencia" => $area_preferencia,
			":forma_aprendizaje" => $forma_aprendizaje,
			":doble_titulacion" => $doble_titulacion,
			":programa_interes" => $programa_interes,
			":dominas_segundo_idioma" => $dominas_segundo_idioma,
			":cual_idioma" => $cual_idioma,
			":nivel_idioma" => $nivel_idioma,
			":segundo_contacto_emergencia_nombre" => $segundo_contacto_emergencia_nombre,
			":id_credencial" => $id_credencial
		]);

		return $resultado;
	}

	public function actualizarbienestarmadre(
		$id_credencial,
		$enfermedad_fisica,
		$cual_enfermedad_fisica,
		$tratamiento_enfermedad_fisica,
		$trastorno_mental,
		$cual_trastorno_mental,
		$tratamiento_mental,
		$bienestar_emocional,
		$eps_afiliado,
		$medicamentos_permanentes,
		$cuales_medicamentos,
		$habilidad_talento,
		$cual_habilidad,
		$actividades_extracurriculares,
		$reconocimientos_habilidad,
		$integracion_habilidad,
		$actividades_interes,
		$voluntariado,
		$cual_voluntariado,
		$participar_en_ciaf,
		$temas_interes,
		$musica_preferencia,
		$habilidades_a_desarrollar,
		$deporte_interes
		) {
		$sql = "UPDATE estudiantes_info_completa SET 
			enfermedad_fisica = :enfermedad_fisica,
			cual_enfermedad_fisica = :cual_enfermedad_fisica,
			tratamiento_enfermedad_fisica = :tratamiento_enfermedad_fisica,
			trastorno_mental = :trastorno_mental,
			cual_trastorno_mental = :cual_trastorno_mental,
			tratamiento_mental = :tratamiento_mental,
			bienestar_emocional = :bienestar_emocional,
			eps_afiliado = :eps_afiliado,
			medicamentos_permanentes = :medicamentos_permanentes,
			cuales_medicamentos = :cuales_medicamentos,
			habilidad_talento = :habilidad_talento,
			cual_habilidad = :cual_habilidad,
			actividades_extracurriculares = :actividades_extracurriculares,
			reconocimientos_habilidad = :reconocimientos_habilidad,
			integracion_habilidad = :integracion_habilidad,
			actividades_interes = :actividades_interes,
			voluntariado = :voluntariado,
			cual_voluntariado = :cual_voluntariado,
			participar_en_ciaf = :participar_en_ciaf,
			temas_interes = :temas_interes,
			musica_preferencia = :musica_preferencia,
			habilidades_a_desarrollar = :habilidades_a_desarrollar,
			deporte_interes = :deporte_interes
			WHERE id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute([
			":enfermedad_fisica" => $enfermedad_fisica,
			":cual_enfermedad_fisica" => $cual_enfermedad_fisica,
			":tratamiento_enfermedad_fisica" => $tratamiento_enfermedad_fisica,
			":trastorno_mental" => $trastorno_mental,
			":cual_trastorno_mental" => $cual_trastorno_mental,
			":tratamiento_mental" => $tratamiento_mental,
			":bienestar_emocional" => $bienestar_emocional,
			":eps_afiliado" => $eps_afiliado,
			":medicamentos_permanentes" => $medicamentos_permanentes,
			":cuales_medicamentos" => $cuales_medicamentos,
			":habilidad_talento" => $habilidad_talento,
			":cual_habilidad" => $cual_habilidad,
			":actividades_extracurriculares" => $actividades_extracurriculares,
			":reconocimientos_habilidad" => $reconocimientos_habilidad,
			":integracion_habilidad" => $integracion_habilidad,
			":actividades_interes" => $actividades_interes,
			":voluntariado" => $voluntariado,
			":cual_voluntariado" => $cual_voluntariado,
			":participar_en_ciaf" => $participar_en_ciaf,
			":temas_interes" => $temas_interes,
			":musica_preferencia" => $musica_preferencia,
			":habilidades_a_desarrollar" => $habilidades_a_desarrollar,
			":deporte_interes" => $deporte_interes,
			":id_credencial" => $id_credencial
		]);

		return $resultado;
	}

	public function actualizarsofimadre(
		$id_credencial,
		$estado_credito,
		$dias_atraso,
		$credito_finalizado,
		) {
		$sql = "UPDATE estudiantes_info_completa SET 
			estado_credito = :estado_credito,
			dias_atraso = :dias_atraso,
			credito_finalizado = :credito_finalizado
			WHERE id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$resultado = $consulta->execute([
			":id_credencial" => $id_credencial,
			":estado_credito" => $estado_credito,
			":dias_atraso" => $dias_atraso,
			":credito_finalizado" => $credito_finalizado
		]);

		return $resultado;
	}


		//Implementar un método para listar las preguntas de seres originales
		public function seresoriginales($id_credencial){	
			$sql="SELECT * FROM carseresoriginales WHERE id_credencial= :id_credencial";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_credencial", $id_credencial);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;		
		}

	//Implementar un método para listar las preguntas de inspiradores
		public function inspiradores($id_credencial){	
			$sql="SELECT * FROM carinspiradores WHERE id_credencial= :id_credencial";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_credencial", $id_credencial);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;		
		}

		//Implementar un método para listar las preguntas de inspiradores
		public function empresas($id_credencial){	
			$sql="SELECT * FROM carempresas WHERE id_credencial= :id_credencial";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_credencial", $id_credencial);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;		
		}
		//Implementar un método para listar las preguntas de inspiradores
		public function confiamos($id_credencial){	
			$sql="SELECT * FROM carconfiamos WHERE id_credencial= :id_credencial";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_credencial", $id_credencial);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;		
		}

		//Implementar un método para listar las preguntas de inspiradores
		public function experiencia($id_credencial){	
			$sql="SELECT * FROM carexperiencia WHERE id_credencial= :id_credencial";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_credencial", $id_credencial);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;		
		}

			//Implementar un método para listar las preguntas de inspiradores
		public function bienestar($id_credencial){	
			$sql="SELECT * FROM carbienestar WHERE id_credencial= :id_credencial";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_credencial", $id_credencial);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;		
		}

			//Implementar un método para listar datos del sofi
		public function sofi($identificacion,$periodo){	
			$sql="SELECT * FROM creditos_control WHERE cedula= :identificacion and periodo= :periodo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":identificacion", $identificacion);
			$consulta->bindParam(":periodo", $periodo);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;		
		}
		// public function datoTablaEstuidante($id_estudiante)
		// {
		// 	$sql = "SELECT * FROM estudiantes est INNER JOIN estado_academico estac ON est.estado= estac.id_estado_academico   WHERE est.id_estudiante= :id_estudiante";
		// 	global $mbd;
		// 	$consulta = $mbd->prepare($sql);
		// 	$consulta->bindParam(":id_estudiante", $id_estudiante);
		// 	$consulta->execute();
		// 	$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		// 	return $resultado;
		// }


	public function diasUnicosDesdeFechas($id_credencial, $fecha_inicial, $fecha_final) {
		$sql = "SELECT COUNT(DISTINCT DATE(fecha)) AS dias_unicos
				FROM ingresos_campus
				WHERE id_usuario = :id_credencial
				AND roll='Estudiante' AND fecha BETWEEN :fecha_inicial AND :fecha_final";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":fecha_inicial", $fecha_inicial);
		$consulta->bindParam(":fecha_final", $fecha_final);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado['dias_unicos'];
	}


	public function actualizarpordias($id_credencial, $porcentaje_ingreso) {
		$sql = "UPDATE estudiantes_info_completa
				SET uso_plataforma = :porcentaje_ingreso
				WHERE id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":porcentaje_ingreso", $porcentaje_ingreso);
		$consulta->bindParam(":id_credencial", $id_credencial);
		
		return $consulta->execute();
	}

		public function actualizaredad($id_credencial, $edad) {
		$sql = "UPDATE estudiantes_info_completa
				SET edad = :edad
				WHERE id_credencial = :id_credencial";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":edad", $edad);
		$consulta->bindParam(":id_credencial", $id_credencial);
		
		return $consulta->execute();
	}

	    //Listar docentes
    public function listarDocentes(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `docente`  ORDER BY `usuario_nombre` ASC");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function promedioCalculado($id_docente, $periodo){
        global $mbd;
        $sql = "SELECT SUM(`total`) * 1.0 / COUNT(*) AS `promedio` FROM `heteroevaluacion` WHERE `id_docente` = :id_docente  AND `periodo` = :periodo";
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(':id_docente', $id_docente, PDO::PARAM_INT);
        $sentencia->bindParam(':periodo', $periodo, PDO::PARAM_STR);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resultado['promedio']; // Devuelve el promedio directamente
    }

	public function buscarResultadoPeriodo($id_docente, $periodo_actual){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT ((`r1` + `r2` + `r3` + `r4` + `r5` + `r6` + `r7` + `r8` + `r9` + `r10`) * 100)/30 AS total  
                                    FROM `coevaluacion_docente` 
                                    WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":periodo", $periodo_actual);
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

	public function autoevaluacionDocente($id_docente, $periodo_actual){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT ((`r1` + `r2` + `r3` + `r4` + `r5` + `r6` + `r7` + `r8` + `r9` + `r10`) * 100)/30 AS `total`  FROM `autoevaluacion_docente` WHERE `id_usuario` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":periodo", $periodo_actual);
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

	public function evaluacionDocenteGeneral($identificacion,$heteroevaluacion,$autoevaluacion,$coevaluacion,$ponderado,$periodo)
	{
		$sql = "INSERT INTO evaluaciondocente_general (identificacion,heteroevaluacion,autoevaluacion,coevaluacion,ponderado,periodo)
			VALUES ('$identificacion','$heteroevaluacion','$autoevaluacion','$coevaluacion','$ponderado','$periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

		
	}