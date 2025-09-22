<?php 
require "../config/Conexion.php";

Class CertificadosPorSemestre {
    public function __construct() {
    }
    
    public function verificarDocumento($cedula) {
        $sql_verificar_documento = "SELECT * FROM credencial_estudiante WHERE credencial_identificacion =:documento";

        global $mbd;
        $consulta_verificar_documento = $mbd->prepare($sql_verificar_documento);
        $consulta_verificar_documento->execute(array(
            "documento" => $cedula
        ));
        $resultado_verificar_documento = $consulta_verificar_documento->fetchAll(PDO::FETCH_ASSOC);
        return $resultado_verificar_documento;
    }

    public function listar($id_credencial) {
        $sql="SELECT * FROM estudiantes WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function cargarInformacion($id_credencial) {
        $sql_cargar_info = "SELECT * FROM estudiantes WHERE id_credencial =:id_credencial";
        global $mbd;

        $consulta_cargar_info = $mbd->prepare($sql_cargar_info);
        $consulta_cargar_info->execute(array("id_credencial" => $id_credencial));
        $resultado_cargar = $consulta_cargar_info->fetchAll(PDO::FETCH_ASSOC);
        return $resultado_cargar;
    }

    public function cargarDatosEstudiante($id_estudiante, $id_credencial) {
        $sql_datosEstudiante = "SELECT id_programa_ac, jornada_e, semestre_estudiante, periodo_activo, estado FROM estudiantes WHERE id_estudiante =:id_estudiante";
        $sql_datosCredencial = "SELECT * FROM credencial_estudiante WHERE id_credencial =:id_credencial";
        $sql_datosPersonales = "SELECT tipo_documento, expedido_en FROM estudiantes_datos_personales WHERE id_credencial =:id_credencial";
        $sql_datosPrograma = "SELECT original, semestres, ciclo FROM programa_ac WHERE id_programa =:id_programa";
        $sql_datos_periodo = "SELECT * FROM periodo_actual";

        global $mbd;
        $data = array();

        $consulta_cargarDatosEstudiante = $mbd->prepare($sql_datosEstudiante);
        $consulta_cargarDatosEstudiante->execute(array("id_estudiante"=> $id_estudiante));
        $resultado_cargarDatosEstudiante = $consulta_cargarDatosEstudiante->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado_cargarDatosEstudiante === false) {
            return null;  // O manejar el error apropiadamente
        }

        $id_programa = $resultado_cargarDatosEstudiante['id_programa_ac'];
        $jornada_e = $resultado_cargarDatosEstudiante['jornada_e'];
        $semestre_estudiante = $resultado_cargarDatosEstudiante['semestre_estudiante'];
        $semestre_siguiente = $semestre_estudiante + 1;
        $periodo_activo = $resultado_cargarDatosEstudiante['periodo_activo'];
        $estado = $resultado_cargarDatosEstudiante['estado'];

        $romano = match($semestre_estudiante) {
            1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V",
            6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X",
            default => ""
        };

        $consulta_cargarDatosCredencial = $mbd->prepare($sql_datosCredencial);
        $consulta_cargarDatosCredencial->execute(array("id_credencial" => $id_credencial));
        $resultado_cargarDatosCredencial = $consulta_cargarDatosCredencial->fetch(PDO::FETCH_ASSOC);

        $identificacion = $resultado_cargarDatosCredencial['credencial_identificacion'];
        $nombre = $resultado_cargarDatosCredencial['credencial_nombre'];
        $nombre_2 = $resultado_cargarDatosCredencial['credencial_nombre_2'];
        $apellidos = $resultado_cargarDatosCredencial['credencial_apellido'];
        $apellidos_2 = $resultado_cargarDatosCredencial['credencial_apellido_2'];
        $nombre_completo = $nombre ." ". $nombre_2 ." ". $apellidos ." ". $apellidos_2;

        $consulta_cargarDatosPersonales = $mbd->prepare($sql_datosPersonales);
        $consulta_cargarDatosPersonales->execute(array("id_credencial"=>$id_credencial));
        $resultado_cargarDatosPersonales = $consulta_cargarDatosPersonales->fetch(PDO::FETCH_ASSOC);

        $tipo_documento = $resultado_cargarDatosPersonales['tipo_documento'];
        $expedido_en = $resultado_cargarDatosPersonales['expedido_en'];
        
        $consulta_cargarDatosPrograma = $mbd->prepare($sql_datosPrograma);
        $consulta_cargarDatosPrograma->execute(array("id_programa"=>$id_programa));
        $resultado_cargarDatosPrograma = $consulta_cargarDatosPrograma->fetch(PDO::FETCH_ASSOC);

        $nombre_original_programa = $resultado_cargarDatosPrograma['original'];
        $semestres_programa = $resultado_cargarDatosPrograma['semestres'];
        $ciclo_programa = $resultado_cargarDatosPrograma['ciclo'];

        $consulta_datos_periodo = $mbd->prepare($sql_datos_periodo);
        $consulta_datos_periodo->execute();
        $resultado_datos_periodo = $consulta_datos_periodo->fetch(PDO::FETCH_ASSOC);

        $periodo_anterior = $resultado_datos_periodo["periodo_anterior"];
        $periodo_actual = $resultado_datos_periodo["periodo_actual"];
        $periodo_siguiente = $resultado_datos_periodo["periodo_siguiente"];

        $convenio = ($nombre_original_programa == "Tecnología en Salud Ocupacional") 
            ? "la cual se ofrece en convenio con la <b> FUNDACIÓN TECNOLOGÍCA ANTONIO DE AREVALO – TECNAR</b>, con código SNIES 101705," 
            : "";

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
            "11" => $periodo_anterior,
            "12" => $periodo_actual,
            "13" => $periodo_siguiente,
            "14" => $estado,
            "15" => $jornada_e,
            "16" => $semestre_siguiente
        );
        echo json_encode($data);
    }

    public function convertir_fecha($date) {
        $dia = explode("-", $date, 3);
        $year = $dia[0];
        $month = (string)(int)$dia[1];
        $day = (string)(int)$dia[2];

        $dias = array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
        $tomadia = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return "(" . $tomadia . "), " . $day . " de " . $meses[$month] . " de (" . $year . ")";
    }

    // Función para cargar los datos del certificado Calificaciones Semestre Actual
	public function cargarSemestre($id_estudiante,$ciclo,$semestre_seleccionado){
		global $mbd;
		// Consultar el total de créditos 
		$sql_consultar_creditos = "SELECT SUM(creditos) as total_creditos FROM materias".$ciclo." WHERE id_estudiante=:id_estudiante AND semestre=:semestre_seleccionado"; 
		$consulta_creditos = $mbd->prepare($sql_consultar_creditos);
		$consulta_creditos->execute(array("id_estudiante"=> $id_estudiante, "semestre_seleccionado"=>$semestre_seleccionado));
		$resultado_total_creditos = $consulta_creditos->fetch(PDO::FETCH_ASSOC);
		// Variable que almacena el total de créditos matriculados del estudiante
		$total_creditos = $resultado_total_creditos['total_creditos'];
		$promedio_ponderado_semestre=0;
		$promedio_semestre=0;
		// Consulta para revisar las calificaciones del estudiante
		$sql_calificaciones = "SELECT nombre_materia, semestre, promedio, creditos FROM materias".$ciclo." WHERE id_estudiante=:id_estudiante AND semestre=:semestre_seleccionado";
		$consulta_calificaciones = $mbd->prepare($sql_calificaciones);
		$consulta_calificaciones->execute(array("id_estudiante" => $id_estudiante,"semestre_seleccionado"=>$semestre_seleccionado));
		$resultado_calificaciones = $consulta_calificaciones->fetchAll(PDO::FETCH_ASSOC);
		$cantidad_materias = count($resultado_calificaciones);
		if($total_creditos > 0){
			// Tabla para imprimir las materias, calificaciones y créditos
			echo "<br><font size='3'><b>".$semestre_seleccionado." Semestre </font><br>";
			echo "<table border='1px' class='table table-bordered' cellpadding='4' style='border-collapse: collapse'>"; 
			echo "	<td width='400px'><b> Asignatura </b></td> 
				<td><b> Créditos </b></td> 
				<td><b> Notas </b></td>
				<td><b> I.H.S </b></td>";
			// Asignar los datos de la consulta
			for ($cont=0; $cont < $cantidad_materias ; $cont++) { 
				$nombre_materia = $resultado_calificaciones[$cont]['nombre_materia'];
				$promedio = $resultado_calificaciones[$cont]['promedio'];
				$creditos = $resultado_calificaciones[$cont]['creditos'];
				echo "</tr>";
				echo "<tr align='center'>";
				echo "<td align='left'>". $nombre_materia . "</td>" . 
				"<td align='center'>". $creditos . "</td>" . 
				"<td>". number_format($promedio,2)."</td>".
				"<td align='center'>". $creditos . "</td>"; 
				echo "</tr>";
				$promedio_pon=($creditos / $total_creditos)*$promedio;
				$promedio_ponderado_semestre=number_format($promedio_ponderado_semestre+$promedio_pon,2);
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

	public function cargarOpciones($id_estudiante){
		$sql_cargar_opciones = "SELECT semestre_estudiante FROM estudiantes WHERE id_estudiante=:id_estudiante";
		global $mbd;
		$consulta_cargar_opciones = $mbd->prepare($sql_cargar_opciones);
		$consulta_cargar_opciones->execute(array("id_estudiante" => $id_estudiante));
		$resultado_cargar_opciones = $consulta_cargar_opciones->fetch(PDO::FETCH_ASSOC);
		return $resultado_cargar_opciones;
	}

    public function nombreescuela($id_escuela)
    {
        $sql="SELECT escuelas FROM escuelas WHERE id_escuelas= :id_escuela ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    
	public function estado_datos($estado){
		$sql="SELECT estado FROM estado_academico WHERE id_estado_academico= :estado";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":estado", $estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


}
