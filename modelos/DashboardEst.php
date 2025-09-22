<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class DashboardEst
{
    // metodo para traer el periodo
    public function periodoactual()
    {
        $sql = "SELECT * FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Implementar un método para listar las titulaciones
    public function listartitulaciones($id_credencial)
    {
        $sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and estado=1"; // el estado solo muestra las matriculadas
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para consulta si el estudiante actualizo los datos
    public function consulta_estado($id_credencial)
    {
        $sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch();
        return $resultado;
    }

    public function consulta_programas($id,$periodo)
    {
        // metodo que trae los programas activos
        global $mbd;
        $consulta = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_credencial` = :id AND `periodo_activo` = :periodo and estado = '1' and `ciclo` IN (1, 2, 3, 5, 7) ");
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function vernombreestudiante($id_credencial)
    {
        // metodo que trae los programas activos
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $consulta = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial");
        $consulta->bindParam(":id_credencial", $id_credencial);
        // $consulta->bindParam(":periodo",$periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function consulta_materias($id, $ciclo)
    {
        // metodo que trae las materias matriculadas
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $consulta = $mbd->prepare(" SELECT * FROM `materias$ciclo` WHERE `id_estudiante` = :id AND `periodo` = :periodo ");
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function consulta_grupo($materia, $jornada, $semestre, $programa, $grupo)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $consulta = $mbd->prepare(" SELECT * FROM `docente_grupos` WHERE `materia` = :materia AND `jornada` = :jornada AND `semestre` = :semestre AND `id_programa` = :programa AND `periodo` = :periodo AND grupo = :grupo ");
        $consulta->bindParam(":materia", $materia);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":programa", $programa);
        $consulta->bindParam(":grupo", $grupo);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function consulta_heteroevaluacion($id_estudiante, $id_docente, $id_docente_grupo)
    {
        $periodo = $_SESSION['periodo_actual'];

        global $mbd;
        $consulta = $mbd->prepare("SELECT * FROM `heteroevaluacion` WHERE `id_estudiante` = :id_estudiante AND id_docente = :id_docente AND id_docente_grupos = :id_docente_grupo AND periodo = :periodo");
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function nombredelprogramaterminal($id_programa_ac)
    {
        global $mbd;
        $consulta = $mbd->prepare("SELECT * FROM `programa_ac` WHERE `id_programa` = :id_programa_ac");
        $consulta->bindParam(":id_programa_ac", $id_programa_ac);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function verificarEstadoEvaluacion()
    {
        global $mbd;
        $consulta = $mbd->prepare("SELECT `estado` FROM `activar_evaluaciones` WHERE `tipo` = 'heteroevaluacion'");
        $consulta->bindParam(":id_programa_ac", $id_programa_ac);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function jornada_PAT($jornada, $programa)
    {
        global $mbd;
        $consulta = $mbd->prepare("SELECT `jornadas_pat`.`url` FROM `jornadas_pat` INNER JOIN `programa_ac` ON `programa_ac`.`carnet` = `jornadas_pat`.`programa` WHERE `jornadas_pat`.`jornada` = :jornada AND `programa_ac`.`nombre` = :programa");
        $consulta->bindParam(":programa", $programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function alertacalendario()
    {
        global $mbd;
        $fecha_actual = date('Y-m-d');
        $consulta = $mbd->prepare("SELECT * FROM `calendario` WHERE `fecha_inicio` <= :fecha_actual AND `fecha_final` >= :fecha_actual");
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function selectActividadActiva($id_actividad)
    {
        $sql = "SELECT * FROM `calendario_actividad` WHERE id_actividad= :id_actividad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_actividad", $id_actividad);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listarcalendarioacademico()
    {
        global $mbd;
        $sql = "SELECT * FROM calendario";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    //Implementamos un método para suamr lo participantes por actividad
    public function totalactividad($id_evento)
    {

        $sql = "SELECT sum(total) as total_participantes  FROM `calendario_asistentes` WHERE id_evento= :id_evento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_evento", $id_evento);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function traercalendariopic()
    {

        global $mbd;
        $fecha_actual = date('Y-m-d');
        $consulta = $mbd->prepare("SELECT * FROM calendario WHERE :fecha_actual BETWEEN fecha_inicio AND fecha_final ");
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function fechaespcalendario($date)
    {
        $dia     = explode("-", $date, 3);
        $year     = $dia[0];
        $month     = (string)(int)$dia[1];
        $day     = (string)(int)$dia[2];

        $dias         = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
        $tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia . ", " . $day . " de " . $meses[$month];
    }

    public function fechaesp($date)
    {
        @$dia = explode("-", $date, 3);
        @$year = $dia[0];
        @$month = (string)(int)$dia[1];
        @$day = (string)(int)$dia[2];
        @$dias = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
        @$tomadia = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
        @$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
    }

    //Implementar un método para listar los ingresos e los estudiantes
    public function listaringresos($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM ingresos_campus WHERE id_usuario = :id_usuario and fecha = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los ingresos e los funcionarios
    // public function listarfaltas($id_usuario, $fecha_actual)
    // {

    //     $sql="SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `faltas`.`id_estudiante`= :id_usuario and `fecha_falta`= :fecha_actual";
    //     // echo $sql;
    //     global $mbd;

    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":fecha_actual", $fecha_actual);
    //     $consulta->bindParam(":id_usuario", $id_usuario);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll();
    //     return $resultado;
    // }

    //Implementar un método para listar las faltas de los estudiantes
    
    
    // public function listarfaltas($id_usuario, $fecha){
    //     $sql = "SELECT COUNT(*) AS total_faltas FROM faltas WHERE id_estudiante = :id_usuario AND fecha_falta = :fecha";
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":id_usuario", $id_usuario);
    //     $consulta->bindParam(":fecha", $fecha);
    //     $consulta->execute();
    //     $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    //     // Retornar el total de faltas como un número
    //     return $resultado['total_faltas'] ?? 0;
    // }
    
    public function listarfaltas($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM faltas WHERE id_credencial= :id_usuario and fecha_falta= :fecha";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los ingresos por semana y mes actual
    public function listaringresossemana($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM ingresos_campus WHERE id_usuario= :id_usuario and fecha >= :fecha and roll='Estudiante'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar las faltas por semana y mes actual
    public function listarfaltassemana($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM faltas WHERE id_credencial= :id_usuario and fecha_falta >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para mostrar la ultima fecha de actualización del perfil
    public function fechaperfilactualizado($id_credencial)
    {
        $sql = "SELECT id_credencial,fecha_actualizacion,mapa_validado FROM estudiantes_datos_personales WHERE id_credencial= :id_credencial";
        //return ejecutarConsultaSimpleFila($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para mostrar la ultima fecha de actualización del perfil
    public function caracterizado($id_credencial)
    {
        $sql = "SELECT * FROM caracterizacion_data WHERE id_credencial= :id_credencial";
        //return ejecutarConsultaSimpleFila($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para saber si actualizo el perfil
    public function verPerfilActualizado($id_usuario, $fecha)
    {
        $sql = "SELECT id_credencial,fecha_actualizacion FROM estudiantes_datos_personales WHERE id_credencial= :id_usuario and fecha_actualizacion >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($id_usuario)
    {
        $sql = "SELECT * FROM estudiantes_datos_personales WHERE id_credencial= :id_usuario";
        //return ejecutarConsultaSimpleFila($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementamos un método para actualizar el perfil
    public function actualizarperfil($id_credencial, $estrato, $telefono, $celular, $email, $barrio, $direccion, $fecha)
    {
        $sql = "UPDATE estudiantes_datos_personales SET estrato= :estrato, telefono= :telefono, celular= :celular, email= :email, barrio= :barrio, direccion= :direccion, fecha_actualizacion= :fecha   WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":estrato", $estrato);
        $consulta->bindParam(":telefono", $telefono);
        $consulta->bindParam(":celular", $celular);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":barrio", $barrio);
        $consulta->bindParam(":direccion", $direccion);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para verificar si realizo la encuesta
    public function verificarencuesta($id_usuario)
    {
        $sql = "SELECT * FROM encuesta_docente WHERE credencial_estudiante = :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar los docentes activos
    public function listardocentesactivos()
    {
        $sql = "SELECT * FROM docente WHERE usuario_condicion='1' ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function insertarencuesta($id_usuario, $fecha, $hora, $pre1, $pre2, $pre3)
    {
        $sql = "INSERT INTO encuesta_docente (credencial_estudiante,fecha,hora,pre1,pre2,pre3) VALUES ('$id_usuario','$fecha','$hora','$pre1','$pre2','$pre3')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }

    //Implementar un método para listar los ingresos e los funcionarios
    public function mostrarestudiantes($id_usuario, $fecha_actual)
    {

        $sql = "SELECT `credencial_nombre`,`credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`ingresos_campus`.`ip`, `ingresos_campus`.`fecha`,`ingresos_campus`.`hora` FROM `ingresos_campus` INNER JOIN `credencial_estudiante` ON `ingresos_campus`.`id_usuario` = `credencial_estudiante`.`id_credencial` WHERE `roll` LIKE 'Estudiante' AND `fecha` = :fecha_actual and `ingresos_campus`.`id_usuario` = :id_usuario";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    //Implementar un método para listar los ingresos e los funcionarios
    public function mostrarestudiantessemana($id_usuario, $fecha_actual)
    {

        $sql = "SELECT `credencial_nombre`,`credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`ingresos_campus`.`ip`, `ingresos_campus`.`fecha`,`ingresos_campus`.`hora` FROM `ingresos_campus` INNER JOIN `credencial_estudiante` ON `ingresos_campus`.`id_usuario` = `credencial_estudiante`.`id_credencial` WHERE `roll` LIKE 'Estudiante' AND `fecha` >= :fecha_actual and `ingresos_campus`.`id_usuario` = :id_usuario";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    //Implementar un método para listar los ingresos e los funcionarios
    public function mostrarfaltas($id_usuario, $fecha_actual)
    {

        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `faltas`.`id_estudiante`= :id_usuario and `fecha_falta`= :fecha_actual";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los ingresos e los funcionarios
    public function mostrarfaltasemana($id_usuario, $fecha_actual)
    {

        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `faltas`.`id_estudiante`= :id_usuario and `fecha_falta` >= :fecha_actual";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }



    //Implementar un método para listar los casso de l quedate semana y mes actual
    // public function actividades($fecha)
    // {
    //     $sql="SELECT * FROM pea_actividades WHERE fecha_actividad = :fecha";
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":fecha", $fecha);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll();
    //     return $resultado;
    // }

    //Implementar un método para listar los casso de l quedate semana y mes actual
    // public function actividadesmes($fecha)
    // {
    //     $sql="SELECT * FROM pea_actividades WHERE fecha_actividad >= :fecha";
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":fecha", $fecha);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll();
    //     return $resultado;
    // }


    //Implementar un método para listar los casso de l quedate semana y mes actual
    public function id_foprograma($id_programa)
    {
        $sql = "SELECT * FROM `docente_grupos` WHERE `id_programa` = :id_programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los ingresos e los funcionarios
    public function notasreportadas($id_credencial, $jornada, $periodo, $semestre, $id_programa)
    {

        $sql = "SELECT * FROM `docente_grupos` INNER JOIN `estudiantes` ON `docente_grupos`.`id_programa` = `estudiantes`.`id_programa_ac` INNER JOIN `credencial_estudiante` ON `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` WHERE `jornada`= :jornada and `docente_grupos`.`periodo`= :periodo and `semestre`= :semestre and `id_programa`= :id_programa and `credencial_estudiante`.`id_credencial` = :id_credencial";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    
    

    public function consulta_notas($id_estudiante, $ciclo,$fecha,$periodo)
    {
        // metodo que trae las materias matriculadas
        global $mbd;
        $consulta = $mbd->prepare(" SELECT * FROM `materias$ciclo` WHERE `id_estudiante` = :id_estudiante AND `periodo` = :periodo AND (
            DATE(`fecha_c1`) = :fecha OR DATE(`fecha_c2`) = :fecha OR DATE(`fecha_c3`) = :fecha)");
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
       return $resultado;
    }


    public function consulta_clasedeldia($id_estudiante,$ciclo,$periodo){
        // metodo que trae las materias matriculadas
        global $mbd;
        // $fecha = date('Y-m-d');
        $consulta = $mbd->prepare(" SELECT * FROM `materias$ciclo` WHERE `id_estudiante` = :id_estudiante AND `periodo` = :periodo");
        // echo $consulta;  
        $consulta->bindParam(":id_estudiante",$id_estudiante);
        $consulta->bindParam(":periodo",$periodo);
        // $consulta->bindParam(":fecha",$fecha);
        $consulta->execute();
    	$resultado = $consulta->fetchAll();
    	return $resultado;
    }


    //Implementar un método para listar los ingresos e los funcionarios
    public function consulta_materias_nota($id_estudiante, $semestre)
    {

        $sql = "SELECT * FROM `materias3` WHERE `id_estudiante` = :id_estudiante AND `semestre` = :semestre";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);

        $consulta->bindParam(":semestre", $semestre);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    public function listar($id, $ciclo, $grupo){
		$tabla = "materias" . $ciclo;
		$sql = "SELECT * FROM $tabla WHERE id_estudiante= :id and periodo='" . $_SESSION['periodo_actual'] . "' and grupo= :grupo";
        // echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


    public function docente_grupo_clases($id_materia, $jornada, $periodo, $semestre, $id_programa, $grupo){
		$sql = "SELECT * FROM docente_grupos WHERE id_materia= :id_materia and jornada= :jornada and periodo= :periodo and semestre= :semestre and id_programa= :id_programa and grupo= :grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":semestre", $semestre);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


    




    //Implementar un método para listar las materias
    // public function listar($ciclo)
    // {
    //     $tabla = "materias" . $ciclo;
    //     $sql = "SELECT * FROM $tabla WHERE id_estudiante='" . $_SESSION['id_usuario'] . "' and periodo='" . $_SESSION['periodo_actual'] . "'";
    //     echo $sql;
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     // $consulta->bindParam(":id", $id);
    //     // $consulta->bindParam(":grupo", $grupo);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll();
    //     return $resultado;
    // }

    //Implementar un método para mirar el programa
    public function programaacademico($id_programa)
    {
        $sql = "SELECT * FROM programa_ac WHERE id_programa= :id_programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para traer el id de la materia matriculada por el estudiante
    public function buscaridmateria($id_programa_ac, $nombre)
    {
        $sql = "SELECT id FROM materias_ciafi WHERE id_programa_ac= :id_programa_ac and nombre= :nombre";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa_ac", $id_programa_ac);
        $consulta->bindParam(":nombre", $nombre);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para mirar el docente
    public function docente_grupo($id_materia, $jornada, $periodo, $semestre, $id_programa, $grupo)
    {
        $sql = "SELECT * FROM docente_grupos WHERE id_materia= :id_materia and jornada= :jornada and periodo= :periodo and semestre= :semestre and id_programa= :id_programa and grupo= :grupo";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_materia", $id_materia);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":grupo", $grupo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para traer el id del programa de la materia
    public function BuscarDatosAsignatura($id_materia)
    {
        $sql = "SELECT id_programa_ac,nombre,semestre FROM materias_ciafi WHERE id= :id_materia";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_materia", $id_materia);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para mirar datos del docente
    public function docente_datos($id_docente)
    {
        $sql = "SELECT * FROM docente WHERE id_usuario= :id_docente";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para traer el horario dela tabla docente_grupos
    public function TraerHorarioDocenteGrupos($id_materia, $jornada, $grupo, $periodo_actual)
    {
        $sql = "SELECT * FROM docente_grupos WHERE id_materia= :id_materia and jornada= :jornada and grupo= :grupo and periodo= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_materia", $id_materia);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":grupo", $grupo);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar las horas hasta
    public function traeridhora($hora)
    {
        $sql = "SELECT * FROM horas_del_dia WHERE horas= :hora";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":hora", $hora);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar los docents activos
    public function datosDocente($id_usuario)
    {
        $sql = "SELECT * FROM docente WHERE id_usuario= :id_usuario";
        //return ejecutarConsulta($sql);	
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para traer el horario dela tabla horario fijo
    public function TraerHorario($id_materia, $jornada, $grupo)
    {
        $sql = "SELECT * FROM horario_fijo WHERE id_materia= :id_materia and jornada= :jornada and grupo= :grupo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_materia", $id_materia);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":grupo", $grupo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listarMaterias($id_programa, $semestre)
    {
        $sql = "SELECT * FROM materias_ciafi WHERE id_programa_ac= :id_programa and semestre= :semestre";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar las horas del dia
    public function TraerHorariocalendario($jornada, $periodo, $semestre, $id_programa, $grupo, $dia)
    {

        $sql = "SELECT * FROM docente_grupos WHERE jornada= :jornada and periodo= :periodo and semestre= :semestre and id_programa= :id_programa and grupo= :grupo and dia= :dia";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":grupo", $grupo);
        $consulta->bindParam(":dia", $dia);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar las actividades subidas
    public function listaractividades($fecha)
    {
        $sql = "SELECT * FROM pea_documentos WHERE fecha_actividad= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        // $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar las actividades subidas
    public function listaractividadespordocente($fecha, $id_docente_grupo)


    {
        $sql = "SELECT * FROM `pea_documentos` INNER JOIN `pea_documento_carpeta` ON `pea_documentos`.`id_pea_documento_carpeta` = `pea_documento_carpeta`.`id_pea_documento_carpeta` INNER JOIN `pea_docentes` ON `pea_docentes`.`id_pea_docentes` = `pea_documento_carpeta`.`id_pea_docentes` WHERE `pea_docentes`.`id_docente_grupo` = :id_docente_grupo AND fecha_actividad = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Implementar un método para listar las horas del dia
    public function TraerHorariocalendarioactividadespea($id_programa, $jornada, $semestre, $grupo)
    {
        $sql = "SELECT * FROM horario_fijo WHERE id_programa= :id_programa and jornada= :jornada and semestre= :semestre and grupo= :grupo";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":grupo", $grupo);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Implementar un método para traer el id del programa de la materia
    public function TraerIddocentegrupo($id_materia)
    {
        $sql = "SELECT * FROM docente_grupos WHERE `id_materia`= :id_materia";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_materia", $id_materia);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar las actividades subidas
    public function listaractividadessemana($fecha)
    {
        $sql = "SELECT * FROM pea_documentos WHERE fecha_actividad >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar las actividades subidas
    public function listaractividadespordocentesemana($fecha, $id_docente_grupo)


    {
        $sql = "SELECT * FROM `pea_documentos` INNER JOIN `pea_documento_carpeta` ON `pea_documentos`.`id_pea_documento_carpeta` = `pea_documento_carpeta`.`id_pea_documento_carpeta` INNER JOIN `pea_docentes` ON `pea_docentes`.`id_pea_docentes` = `pea_documento_carpeta`.`id_pea_docentes` WHERE `pea_docentes`.`id_docente_grupo` = :id_docente_grupo AND fecha_actividad >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function traercalendario($fecha_actual)
    {
        $sql_buscar = "SELECT * FROM `calendario` WHERE `fecha_inicio` LIKE '%$fecha_actual%' ";
        // echo $sql_buscar;
        global $mbd;
        $consulta_buscar = $mbd->prepare($sql_buscar);
        $consulta_buscar->execute();
        $resultado_buscar = $consulta_buscar->fetchall();
        return $resultado_buscar;
    }

    public function listarEventos($fecha_actual)
    {
        $sql_buscar = "SELECT * FROM `calendario_eventos` WHERE `fecha_inicio` LIKE '%$fecha_actual%' ";
        // echo $sql_buscar;
        global $mbd;
        $consulta_buscar = $mbd->prepare($sql_buscar);
        $consulta_buscar->execute();
        $resultado_buscar = $consulta_buscar->fetchall();
        return $resultado_buscar;
    }

    //Implementar un método para listar los departamentos en un select
    public function selectDepartamento()
    {
        $sql = "SELECT * FROM departamentos";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los municipios en un select
    public function selectMunicipio($id_departamento)
    {
        $sql = "SELECT * FROM municipios WHERE departamento_id= :id_departamento";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_departamento", $id_departamento);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los municipios en un select
    public function selectBarrio($id_municipio)
    {
        $sql = "SELECT * FROM barrio WHERE id_municipio= :id_municipio";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_municipio", $id_municipio);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementamos un método para actualizar la latitud y longitud
    public function actualizarMapa($latitud, $longitud, $id_credencial)
    {
        $sql = "UPDATE estudiantes_datos_personales SET latitud= :latitud, longitud= :longitud, mapa_validado='0'   WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":latitud", $latitud);
        $consulta->bindParam(":longitud", $longitud);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function EstudianteIngresos($fecha, $id_usuario) {
        $sql = "SELECT fecha, COUNT(*) AS cantidad_ingresos, id_usuario, roll 
                FROM ingresos_campus 
                WHERE roll = 'Estudiante' AND id_usuario = :id_usuario AND fecha >= :fecha
                GROUP BY fecha, id_usuario, roll 
                ORDER BY fecha ASC";
        
        global $mbd; 
        $sql_mostrar = $mbd->prepare($sql);
        $sql_mostrar->bindParam(":id_usuario", $id_usuario);
        $sql_mostrar->bindParam(":fecha", $fecha);
        $sql_mostrar->execute();
        $result = $sql_mostrar->fetchAll(PDO::FETCH_ASSOC); // Fetching all results as associative array
        return $result;
    }
}
?>