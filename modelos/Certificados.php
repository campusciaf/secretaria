<?php
require "../config/Conexion.php";
class Certificados{
	// Implementamos nuestro constructor
	public function __construct() {}
	// Función para validar que el documento digitado se encuentre en la base de datos
	public function verificarDocumento($cedula){
		$sql_verificar_documento = "SELECT * FROM credencial_estudiante WHERE credencial_identificacion =:documento";
		global $mbd;
		$consulta_verificar_documento = $mbd->prepare($sql_verificar_documento);
		$consulta_verificar_documento->execute(array(
			"documento" => $cedula
		));
		$resultado_verificar_documento = $consulta_verificar_documento->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_verificar_documento;
	}
	// Función para listar los datos del estudiante de los programas en los que está matriculado
	public function listar($id_credencial){
		$sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	// Función para cargar los datos del estudiante en la vista
	public function cargarInformacion($id_credencial){
		$sql_cargar_info = "SELECT * FROM estudiantes WHERE id_credencial =:id_credencial";
		global $mbd;
		$consulta_cargar_info = $mbd->prepare($sql_cargar_info);
		$consulta_cargar_info->execute(array("id_credencial" => $id_credencial));
		$resultado_cargar = $consulta_cargar_info->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_cargar;
	}
	public function verHistorialCertificados($credencial, $cedula){
		$sql = "SELECT * FROM certificados_expedidos  WHERE id_credencial= :credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial", $credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para traer el nombre del certificado expedido
	public function nombreCertificado($id_tipo_certificado){
		$sql = "SELECT * FROM certificado_tipo WHERE id_certificado_tipo= :id_tipo_certificado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tipo_certificado", $id_tipo_certificado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el nombre del programa el cetificado expedido
	public function nombrePrograma($id_programa){
		$sql = "SELECT id_programa,nombre FROM programa_ac WHERE id_programa= :id_programa";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	// Función para validar si el estudiante tiene certificados expedidos
	public function validarCertificadosExpedidos($id_estudiante){
		$sql_verificar_certificados = ("SELECT * FROM certificados_expedidos WHERE id_credencial =" . $id_estudiante);
		global $mbd;
		$consulta_verificar_certificados = $mbd->prepare($sql_verificar_certificados);
		$consulta_verificar_certificados->execute(array("id_estudiante" => $id_estudiante));
		$resultado_verificar_certificados = $consulta_verificar_certificados->fetch(PDO::FETCH_ASSOC);
		return $resultado_verificar_certificados;
	}
	// Función para convertir la fecha al formato español
	public function convertir_fecha($date){
		$dia    = explode("-", $date, 3);
		$year   = $dia[0];
		$month  = (string)(int)$dia[1];
		$day    = (string)(int)$dia[2];
		$dias       = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia    = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return "(" . $tomadia . "), " . $day . " de " . $meses[$month] . " de (" . $year . ")";
	}
	// Función para cargar los datos del estudiante que se imprimirán en el certificado seleccionado
	public function cargarDatosEstudiante($id_estudiante, $id_credencial){
		// Consultas a las tablas que se necesitan para recolectar los datos de los certificados
		$sql_datosEstudiante = "SELECT id_programa_ac, jornada_e, semestre_estudiante, periodo_activo, estado FROM estudiantes WHERE id_estudiante =:id_estudiante";
		$sql_datosCredencial = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		$sql_datosPersonales = "SELECT tipo_documento, expedido_en FROM estudiantes_datos_personales WHERE id_credencial= :id_credencial";
		$sql_datosPrograma = "SELECT nombre, semestres, ciclo FROM programa_ac WHERE id_programa =:id_programa";
		$sql_datos_periodo = "SELECT * FROM periodo_actual";
		global $mbd;
		$data = array();
		// Consulta para cargar los datos del estudiante
		$consulta_cargarDatosEstudiante = $mbd->prepare($sql_datosEstudiante);
		$consulta_cargarDatosEstudiante->execute(array("id_estudiante" => $id_estudiante));
		$resultado_cargarDatosEstudiante = $consulta_cargarDatosEstudiante->fetch(PDO::FETCH_ASSOC);
		// Se asignan las variables de la consulta a la tabla estudiantes
		$id_programa = $resultado_cargarDatosEstudiante['id_programa_ac'];
		$jornada_e = $resultado_cargarDatosEstudiante['jornada_e'];
		$semestre_estudiante = $resultado_cargarDatosEstudiante['semestre_estudiante'];
		$semestre_siguiente = $semestre_estudiante + 1;
		$periodo_activo = $resultado_cargarDatosEstudiante['periodo_activo'];
		$estado = $resultado_cargarDatosEstudiante['estado'];
		// Establecemos el número romano dependiendo del semestre en el que está el estudiante
		if ($semestre_estudiante == 1) {
			$romano = "I";
		} else if ($semestre_estudiante == 2) {
			$romano = "II";
		} else if ($semestre_estudiante == 3) {
			$romano = "III";
		} else if ($semestre_estudiante == 4) {
			$romano = "IV";
		} else if ($semestre_estudiante == 5) {
			$romano = "V";
		} else if ($semestre_estudiante == 6) {
			$romano = "VI";
		} else if ($semestre_estudiante == 7) {
			$romano = "VII";
		} else if ($semestre_estudiante == 8) {
			$romano = "VIII";
		} else if ($semestre_estudiante == 9) {
			$romano = "IX";
		} else if ($semestre_estudiante == 10) {
			$romano = "X";
		}
		// Consulta para cargar los datos de las credenciales de acceso
		$consulta_cargarDatosCredencial = $mbd->prepare($sql_datosCredencial);
		$consulta_cargarDatosCredencial->execute(array("id_credencial" => $id_credencial));
		$resultado_cargarDatosCredencial = $consulta_cargarDatosCredencial->fetch(PDO::FETCH_ASSOC);
		// Se asignan las variables de la consulta a la tabla credencial_estudiante
		$identificacion = $resultado_cargarDatosCredencial['credencial_identificacion'];
		$nombre = $resultado_cargarDatosCredencial['credencial_nombre'];
		$nombre_2 = $resultado_cargarDatosCredencial['credencial_nombre_2'];
		$apellidos = $resultado_cargarDatosCredencial['credencial_apellido'];
		$apellidos_2 = $resultado_cargarDatosCredencial['credencial_apellido_2'];
		$nombre_completo = $nombre . " " . $nombre_2 . " " . $apellidos . " " . $apellidos_2;
		// Consulta para cargar los datos personales del estudiante
		$consulta_cargarDatosPersonales = $mbd->prepare($sql_datosPersonales);
		$consulta_cargarDatosPersonales->execute(array("id_credencial" => $id_credencial));
		$resultado_cargarDatosPersonales = $consulta_cargarDatosPersonales->fetch(PDO::FETCH_ASSOC);
		// Se asignan las variables de la consulta a la tabla estudiantes_datos_personales
		$tipo_documento = $resultado_cargarDatosPersonales['tipo_documento'];
		$expedido_en = $resultado_cargarDatosPersonales['expedido_en'];
		// Consulta para cargar los datos del programa de la tabla programa_ac
		$consulta_cargarDatosPrograma = $mbd->prepare($sql_datosPrograma);
		$consulta_cargarDatosPrograma->execute(array("id_programa" => $id_programa));
		$resultado_cargarDatosPrograma = $consulta_cargarDatosPrograma->fetch(PDO::FETCH_ASSOC);
		// Se asignan las variables de la consulta a la tabla programa_ac
		$nombre_original_programa = $resultado_cargarDatosPrograma['nombre'];
		$semestres_programa = $resultado_cargarDatosPrograma['semestres'];
		$ciclo_programa = $resultado_cargarDatosPrograma['ciclo'];
		// Consulta para cargar los datos del periodo_actual
		$consulta_datos_periodo = $mbd->prepare($sql_datos_periodo);
		$consulta_datos_periodo->execute();
		$resultado_datos_periodo = $consulta_datos_periodo->fetch(PDO::FETCH_ASSOC);
		// Se asignan las variables de las consulta a la tabla periodo_actual
		$periodo_anterior = $resultado_datos_periodo["periodo_anterior"];
		$periodo_actual = $resultado_datos_periodo["periodo_actual"];
		$periodo_siguiente = $resultado_datos_periodo["periodo_siguiente"];
		// Excepción convenio Salud Ocupacional
		if ($nombre_original_programa == "Tecnología en Salud Ocupacional") {
			$convenio = "la cual se ofrece en convenio con la <b> FUNDACIÓN TECNOLOGÍCA ANTONIO DE AREVALO – TECNAR</b>, con código SNIES 101705,";
		} else {
			$convenio = "";
		}
		// Arreglo que almacena todos los datos que se imprimen en las plantillas de los certificados
		$data[] = array(
			"0" => $nombre_completo,
			"1" => $tipo_documento,
			"2" => $identificacion,
			"3" => $expedido_en,
			"4" => $romano,
			"5" => $nombre_original_programa,
			"6" => $ciclo_programa,
			"7" => $semestres_programa,
			"8" => $semestre_estudiante,
			"9" => $periodo_activo,
			"10" => $convenio,
			"11" => $periodo_actual,
			"12" => $periodo_anterior,
			"13" => $periodo_siguiente,
			"14" => $estado,
			"15" => $jornada_e,
			"16" => $semestre_siguiente
		);
		echo json_encode($data);
	}
	// Función para cargar los datos del certificado Calificaciones Todos los semestres
	public function cargarTodasCalificaciones($id_estudiante, $ciclo, $semestres_programa, $semestre_estudiante){
		global $mbd;
		//Traer los datos de calificaciones y creditos para hacer los cálculos de cuántos semestres son
		$sql_materias = "SELECT semestre, creditos FROM materias" . $ciclo . " WHERE id_estudiante =:id_estudiante ORDER BY semestre ASC";
		$consulta_materias = $mbd->prepare($sql_materias);
		$consulta_materias->execute(array("id_estudiante" => $id_estudiante));
		$resultado_materias = $consulta_materias->fetchAll(PDO::FETCH_ASSOC);
		// Variable para almacenar la cantidad de materias
		$cantidad_materias_matriculadas = count($resultado_materias);
		// Arreglo para almacenar la cantidad de créditos, dependiendo de la cantidad de semestres que tenga el programa
		$total_creditos_semestres = array();
		// Bucle para calcular la cantidad de créditos por semestre, calculando cada materia matriculada por el estudiante
		for ($j = 1; $j <= $semestre_estudiante; $j++) {
			$total_creditos_semestres['semestre ' . $j] = 0;
			for ($i = 0; $i < $cantidad_materias_matriculadas; $i++) {
				if ($resultado_materias[$i]['semestre'] == $j) {
					$total_creditos_semestres['semestre ' . $j] +=  $resultado_materias[$i]['creditos'];
				}
			}
		}
		// Variable que almacenará la cantidad de semestres 
		$cantidad_semestres = count($total_creditos_semestres);
		$semestre_contador = 1;
		$promedio_ponderado_final = 0;
		$promedio_semestre = 0;
		// Imprimir organizado en tablas las materias con calificación y cantidad de créditos
		while ($semestre_contador <= $cantidad_semestres) {
			// Consultar el total de créditos 
			$sql_consultar_creditos = "SELECT SUM(creditos) as total_creditos FROM materias" . $ciclo . " WHERE id_estudiante =:id_estudiante ORDER BY semestre ASC";
			$consulta_creditos = $mbd->prepare($sql_consultar_creditos);
			$consulta_creditos->execute(array("id_estudiante" => $id_estudiante));
			$resultado_total_creditos = $consulta_creditos->fetch(PDO::FETCH_ASSOC);
			// Variable que almacena el total de créditos matriculados del estudiante
			$total_creditos = $resultado_total_creditos['total_creditos'];
			$promedio_ponderado_semestre = 0;
			// Consulta para almacenar las calificaciones y los nombres de las materias
			$sql_calificaciones = "SELECT nombre_materia, semestre, promedio, creditos, periodo FROM materias" . $ciclo . " WHERE id_estudiante=:id_estudiante AND semestre=:semestre_contador ORDER BY semestre ASC";
			$consulta_calificaciones = $mbd->prepare($sql_calificaciones);
			$consulta_calificaciones->execute(array("id_estudiante" => $id_estudiante, "semestre_contador" => $semestre_contador));
			$resultado_calificaciones = $consulta_calificaciones->fetchAll(PDO::FETCH_ASSOC);
			$cantidad_materias_semestre = count($resultado_calificaciones);
			if ($total_creditos > 0) {
				// Tabla para imprimir las materias, calificaciones y créditos
				echo "<br><font size='3'><b>" . $semestre_contador . " Semestre </font><br>";
				echo "<table border='1px' class='table table-bordered' cellpadding='4' style='border-collapse: collapse'>";
				echo "	<td width='400px'><b> Asignatura </b></td> 
					<td><b> Créditos </b></td>
					<td><b> Nota </b></td>
					<td><b> Periodo </b></td>";
				// Asignar los datos de la consulta
				for ($cont = 0; $cont < $cantidad_materias_semestre; $cont++) {
					$nombre_materia = $resultado_calificaciones[$cont]['nombre_materia'];
					$promedio = $resultado_calificaciones[$cont]['promedio'];
					$creditos = $resultado_calificaciones[$cont]['creditos'];
					$periodo = $resultado_calificaciones[$cont]['periodo'];
					echo "</tr>";
					echo "<tr align='center'>";
					echo "<td align='left'>" . $nombre_materia . "</td>" .
						"<td align='center'>" . $creditos . "</td>" .
						"<td>" . number_format($promedio, 2) . "</td>" .
						"<td align='center'>" . $periodo . "</td>";
					echo "</tr>";
					$cont_semestre = $cont + 1;
					$promedio_pon_final = ($creditos / $total_creditos_semestres['semestre ' . $semestre_contador]) * $promedio;
					$promedio_ponderado_semestre = number_format($promedio_ponderado_semestre + $promedio_pon_final, 2);
				}
				echo "<tr align='center'>";
				echo "<td></td>";
				echo "<td>" . $total_creditos_semestres['semestre ' . $semestre_contador] . "</td>";
				$promedio_semestre = number_format($promedio_ponderado_semestre, 2);
				echo "<td>" . $promedio_semestre . "</td>";
				echo "</tr></table>";
			}
			$promedio_ponderado_final = ($promedio_ponderado_final + $promedio_semestre);
			$semestre_contador++;
		}
		$promedio_ponderado_final = number_format($promedio_ponderado_final / ($semestre_contador - 1), 2);
		echo "
		<br/><b>Promedio acumulado por los " . $cantidad_semestres . " semestres  <u>" .  $promedio_ponderado_final . " </u></b>
		<br/>";
	}
	// Función para cargar los datos del certificado Calificaciones Semestre Actual
	public function cargarSemestreActual($id_estudiante, $ciclo, $semestre_estudiante){
		global $mbd;
		// Consultar el total de créditos 
		$sql_consultar_creditos = "SELECT SUM(creditos) as total_creditos FROM materias" . $ciclo . " WHERE id_estudiante=:id_estudiante AND semestre=:semestre_estudiante";
		$consulta_creditos = $mbd->prepare($sql_consultar_creditos);
		$consulta_creditos->execute(array("id_estudiante" => $id_estudiante, "semestre_estudiante" => $semestre_estudiante));
		$resultado_total_creditos = $consulta_creditos->fetch(PDO::FETCH_ASSOC);
		// Variable que almacena el total de créditos matriculados del estudiante
		$total_creditos = $resultado_total_creditos['total_creditos'];
		$promedio_ponderado_semestre = 0;
		$promedio_semestre = 0;
		// Consulta para revisar las calificaciones del estudiante
		$sql_calificaciones = "SELECT nombre_materia, semestre, promedio, creditos FROM materias" . $ciclo . " WHERE id_estudiante=:id_estudiante AND semestre=:semestre_estudiante";
		$consulta_calificaciones = $mbd->prepare($sql_calificaciones);
		$consulta_calificaciones->execute(array("id_estudiante" => $id_estudiante, "semestre_estudiante" => $semestre_estudiante));
		$resultado_calificaciones = $consulta_calificaciones->fetchAll(PDO::FETCH_ASSOC);
		$cantidad_materias = count($resultado_calificaciones);
		if ($total_creditos > 0) {
			// Tabla para imprimir las materias, calificaciones y créditos
			echo "<br><font size='3'><b>" . $semestre_estudiante . " Semestre </font><br>";
			echo "<table border='1px' class='table table-bordered' cellpadding='4' style='border-collapse: collapse'>";
			echo "	<td width='400px'><b> Asignatura </b></td> 
				<td><b> Créditos </b></td> 
				<td><b> Notas </b></td>
				<td><b> I.H.S </b></td>";
			// Asignar los datos de la consulta
			for ($cont = 0; $cont < $cantidad_materias; $cont++) {
				$nombre_materia = $resultado_calificaciones[$cont]['nombre_materia'];
				$promedio = $resultado_calificaciones[$cont]['promedio'];
				$creditos = $resultado_calificaciones[$cont]['creditos'];
				echo "</tr>";
				echo "<tr align='center'>";
				echo "<td align='left'>" . $nombre_materia . "</td>" .
					"<td align='center'>" . $creditos . "</td>" .
					"<td>" . number_format($promedio, 2) . "</td>" .
					"<td align='center'>" . $creditos . "</td>";
				echo "</tr>";
				$promedio_pon = ($creditos / $total_creditos) * $promedio;
				$promedio_ponderado_semestre = number_format($promedio_ponderado_semestre + $promedio_pon, 2);
			}
			echo "</tr>";
			echo "</table></center><br>";
		}
		echo "<table border='0' width='450px' cellpadding='0' cellpadding='0'>
			<tr valign='top'>
				<td>
					Asignaturas Matriculadas:<span class='titulo7'> $cantidad_materias </span><br>
					Créditos Matriculados: <span class='titulo7'> $total_creditos </span>
				</td>
				<td align='right'>
					Promedio Ponderado <span class='titulo7'> $promedio_ponderado_semestre </span><br>
				</td>
			</tr>
		</table>";
		echo "<center>
		<br><br>
		<font size='3px'>Las asignaturas se califican de 0.0 a 5.0, siendo 3.0 la calificación aprobatoria.</font><br><br>
		</center>";
	}
	// Función para cargar los datos del certificado Calificaciones Semestre Anterior
	public function cargarSemestreAnterior($id_estudiante, $ciclo, $semestre_anterior, $periodo_anterior){
		global $mbd;
		// Consultar el total de créditos 
		$sql_consultar_creditos = "SELECT SUM(creditos) as total_creditos FROM materias" . $ciclo . " WHERE id_estudiante=:id_estudiante AND semestre=:semestre_anterior";
		$consulta_creditos = $mbd->prepare($sql_consultar_creditos);
		$consulta_creditos->execute(array("id_estudiante" => $id_estudiante, "semestre_anterior" => $semestre_anterior));
		$resultado_total_creditos = $consulta_creditos->fetch(PDO::FETCH_ASSOC);
		// Variable que almacena el total de créditos matriculados del estudiante
		$total_creditos = $resultado_total_creditos['total_creditos'];
		$promedio_ponderado_semestre = 0;
		$promedio_semestre = 0;
		// Consulta para revisar las calificaciones del estudiante
		$sql_calificaciones = "SELECT nombre_materia, semestre, promedio, creditos FROM materias" . $ciclo . " WHERE id_estudiante=:id_estudiante AND semestre=:semestre_anterior";
		$consulta_calificaciones = $mbd->prepare($sql_calificaciones);
		$consulta_calificaciones->execute(array("id_estudiante" => $id_estudiante, "semestre_anterior" => $semestre_anterior));
		$resultado_calificaciones = $consulta_calificaciones->fetchAll(PDO::FETCH_ASSOC);
		$cantidad_materias = count($resultado_calificaciones);
		if ($total_creditos > 0) {
			// Tabla para imprimir las materias, calificaciones y créditos
			echo "<br><font size='3'><b>" . $semestre_anterior . " Semestre </font><br>";
			echo "<table border='1px' class='table table-bordered' cellpadding='4' style='border-collapse: collapse'>";
			echo "	<td width='400px'><b> Asignatura </b></td> 
				<td><b> Créditos </b></td> 
				<td><b> Notas </b></td>
				<td><b> I.H.S </b></td>";
			// Asignar los datos de la consulta
			for ($cont = 0; $cont < $cantidad_materias; $cont++) {
				$nombre_materia = $resultado_calificaciones[$cont]['nombre_materia'];
				$promedio = $resultado_calificaciones[$cont]['promedio'];
				$creditos = $resultado_calificaciones[$cont]['creditos'];
				echo "</tr>";
				echo "<tr align='center'>";
				echo "<td align='left'>" . $nombre_materia . "</td>" .
					"<td align='center'>" . $creditos . "</td>" .
					"<td>" . number_format($promedio, 2) . "</td>" .
					"<td align='center'>" . $creditos . "</td>";
				echo "</tr>";
				$promedio_pon = ($creditos / $total_creditos) * $promedio;
				$promedio_ponderado_semestre = number_format($promedio_ponderado_semestre + $promedio_pon, 2);
			}
			echo "</tr>";
			echo "</table></center><br>";
		}
		echo "<table border='0' width='450px' cellpadding='0' cellpadding='0'>
			<tr valign='top'>
				<td>
					Asignaturas Matriculadas:<span class='titulo7'> $cantidad_materias </span><br>
					Créditos Matriculados: <span class='titulo7'> $total_creditos </span>
				</td>
				<td align='right'>
					Promedio Ponderado <span class='titulo7'> $promedio_ponderado_semestre </span><br>
				</td>
			</tr>
		</table>";
		echo "<center>
		<br><br>
		<font size='3px'>Las asignaturas se califican de 0.0 a 5.0, siendo 3.0 la calificación aprobatoria.</font><br><br>
		</center>";
	}
	// Función para guardar en la base de datos el registro del certificado que se generó 
	public function guardar_registro_certificado($tipo_certificado, $id_estudiante, $id_credencial, $id_programa, $fechahoyesp, $id_usuario){
		$sql = "INSERT INTO certificados_expedidos (`id_tipo_certificado`, `id_estudiante`, `id_credencial`, `id_programa`, `fecha_carga`, `id_usuario`)
		VALUES ('$tipo_certificado','$id_estudiante','$id_credencial','$id_programa','$fechahoyesp','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function insertarDiploma($tipo_certificado, $id_estudiante, $id_credencial, $id_programa, $certificado_archivo, $fechahoyesp, $id_usuario){
		$sql = "INSERT INTO certificados_expedidos (`id_tipo_certificado`, `id_estudiante`, `id_credencial`, `id_programa`, `certificado_archivo`, `fecha_carga`, `id_usuario`)
		VALUES ('$tipo_certificado','$id_estudiante','$id_credencial','$id_programa','$certificado_archivo','$fechahoyesp','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function estado_datos($estado){
		$sql = "SELECT * FROM estado_academico WHERE id_estado_academico= :estado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":estado", $estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para listar los registros
	public function selectcertificados(){
		$sql = "SELECT * FROM certificado_tipo ";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Implementar un método para eliminar la falta
	public function eliminardiploma($id_certificado){
		$sql = "DELETE FROM certificados_expedidos WHERE id_certificado= :id_certificado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_certificado", $id_certificado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para traer el nombre del certificado expedido
	public function archivoeliminar($id_certificado){
		$sql = "SELECT * FROM certificados_expedidos WHERE id_certificado= :id_certificado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_certificado", $id_certificado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}