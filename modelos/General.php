<?php
require "../config/Conexion.php";

class General
{
	// Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function listaringresos($fecha, $roll)
    {
        $sql = "SELECT DISTINCT id_usuario FROM ingresos_campus WHERE fecha= :fecha and roll= :roll";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarfaltas($fecha)
    {
        $sql = "SELECT * FROM faltas WHERE fecha_falta= :fecha";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarQuedate($fecha)
    {
        $sql = "SELECT * FROM casos WHERE created_at= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarContactanos($fecha)
    {
        $sql = "SELECT * FROM ayuda WHERE fecha_solicitud= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarCaracterizados($fecha)
    {
        $sql = "SELECT * FROM caracterizacion_data WHERE fecha = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarActividades($fecha)
    {
        // $sql = "SELECT * FROM pea_documentos WHERE fecha_actividad = :fecha";
        $sql = "SELECT * FROM `pea_documentos` INNER JOIN `pea_documento_carpeta` ON `pea_documentos`.`id_pea_documento_carpeta` = `pea_documento_carpeta`.`id_pea_documento_carpeta` INNER JOIN `pea_docentes` ON `pea_docentes`.`id_pea_docentes` = `pea_documento_carpeta`.`id_pea_docentes` INNER JOIN `docente_grupos` ON `pea_docentes`.`id_docente_grupo` = `docente_grupos`.`id_docente_grupo` INNER JOIN `docente` ON `docente`.`id_usuario` = `docente_grupos`.`id_docente` WHERE fecha_actividad = :fecha";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarCv($fecha)
    {
        // $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_areas_de_conocimiento` ON `cv_usuario`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') = :fecha GROUP BY `usuario_identificacion`";
        $sql = "SELECT cv_usuario.usuario_identificacion, MAX(cv_areas_de_conocimiento.nombre_area) as area FROM `cv_usuario` INNER JOIN `cv_areas_de_conocimiento` ON cv_usuario.id_usuario_cv = cv_areas_de_conocimiento.id_usuario_cv INNER JOIN `cv_informacion_personal` ON cv_informacion_personal.id_usuario_cv = cv_areas_de_conocimiento.id_usuario_cv WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') = :fecha GROUP BY cv_usuario.usuario_identificacion;   ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    
	public function listarPerfilAdminRango($fecha)
    {
        $sql = "  SELECT * FROM `usuario` WHERE fecha_actualizacion >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        // $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function perfilactualizadodocente($fecha)
    {
        $sql = "SELECT * FROM `docente` WHERE `fecha_actualizacion` >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        // $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function perfilactualizadoestudiante($fecha)
    {
        $sql = "SELECT * FROM estudiantes_datos_personales INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` =`estudiantes_datos_personales`.`id_credencial` WHERE fecha_actualizacion >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listaringresossemana($fecha, $roll)
    {

        // SELECT DISTINCT `credencial_nombre`,`credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`ingresos_campus`.`ip` , `ingresos_campus`.`hora` FROM `ingresos_campus` INNER JOIN `credencial_estudiante` ON `ingresos_campus`.`id_usuario` = `credencial_estudiante`.`id_credencial` WHERE `roll` LIKE 'Estudiante' AND `fecha` >= :fecha_actual
        $sql = "SELECT DISTINCT `credencial_nombre`,`credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`ingresos_campus`.`ip` , `ingresos_campus`.`hora` FROM `ingresos_campus` INNER JOIN `credencial_estudiante` ON `ingresos_campus`.`id_usuario` = `credencial_estudiante`.`id_credencial` WHERE fecha >= :fecha and roll= :roll";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarFaltasSemana($fecha)
    {
        $sql = "SELECT * FROM faltas WHERE fecha_falta >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarQuedateSemana($fecha)
    {
        $sql = "SELECT * FROM casos WHERE created_at >= :fecha";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarContactanosSemana($fecha)
    {
        $sql = "SELECT * FROM ayuda WHERE fecha_solicitud >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarCaracterizadosSemana($fecha)
    {
        $sql = "SELECT * FROM caracterizacion_data WHERE fecha >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function listarActividadesSemana($fecha)
    {
        // $sql = "SELECT * FROM pea_documentos WHERE fecha_actividad >= :fecha";
        $sql = "SELECT * FROM `pea_documentos` INNER JOIN `pea_documento_carpeta` ON `pea_documentos`.`id_pea_documento_carpeta` = `pea_documento_carpeta`.`id_pea_documento_carpeta` INNER JOIN `pea_docentes` ON `pea_docentes`.`id_pea_docentes` = `pea_documento_carpeta`.`id_pea_docentes` INNER JOIN `docente_grupos` ON `pea_docentes`.`id_docente_grupo` = `docente_grupos`.`id_docente_grupo` INNER JOIN `docente` ON `docente`.`id_usuario` = `docente_grupos`.`id_docente` WHERE fecha_actividad >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarCvSemana($fecha)
{
    // Corrección en la consulta SQL: marcador de posición para la fecha y comilla invertida eliminada
    $sql = "SELECT cv_usuario.usuario_identificacion, MAX(cv_areas_de_conocimiento.nombre_area) AS area FROM cv_usuario  INNER JOIN cv_areas_de_conocimiento ON cv_usuario.id_usuario_cv = cv_areas_de_conocimiento.id_usuario_cv INNER JOIN cv_informacion_personal ON cv_informacion_personal.id_usuario_cv = cv_areas_de_conocimiento.id_usuario_cv WHERE create_dt >= :fecha GROUP BY cv_usuario.usuario_identificacion"; 
    
    global $mbd;
    $consulta = $mbd->prepare($sql);
    
    // Usa bindParam para asociar la variable de fecha al marcador de posición :fecha
    $consulta->bindParam(":fecha", $fecha);
    
    $consulta->execute();
    
    $resultado = $consulta->fetchAll();
    
    return $resultado;
}

	public function listaringresosrango($fecha_inicial, $fecha_final, $roll)
    {


        $sql = "SELECT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip` FROM ingresos_campus INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and roll= :roll";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listaringresosrangodocente($fecha_inicial, $fecha_final, $roll)
    {
        // SELECT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip` FROM ingresos_campus INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= "2022-06-01" and fecha <= "2022-06-08" and roll= "Funcionario"

        // SELECT DISTINCT * FROM ingresos_campus  WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and roll= :roll

        $sql = "SELECT DISTINCT * FROM ingresos_campus INNER JOIN `docente` ON ingresos_campus.id_usuario= docente.id_usuario WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and roll= :roll ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarFaltasRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM faltas WHERE fecha_falta >= :fecha_inicial and fecha_falta <= :fecha_final ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarQuedateRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM casos WHERE created_at >= :fecha_inicial and created_at <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function listarContactanosRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM ayuda WHERE fecha_solicitud >= :fecha_inicial and fecha_solicitud <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarCaracterizadosRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM caracterizacion_data WHERE fecha >= :fecha_inicial and fecha <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarActividadesRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM `pea_documentos` INNER JOIN `pea_documento_carpeta` ON `pea_documentos`.`id_pea_documento_carpeta` = `pea_documento_carpeta`.`id_pea_documento_carpeta` INNER JOIN `pea_docentes` ON `pea_docentes`.`id_pea_docentes` = `pea_documento_carpeta`.`id_pea_docentes` INNER JOIN `docente_grupos` ON `pea_docentes`.`id_docente_grupo` = `docente_grupos`.`id_docente_grupo` INNER JOIN `docente` ON `docente`.`id_usuario` = `docente_grupos`.`id_docente` WHERE fecha_actividad >= :fecha_inicial  and fecha_actividad <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function listarCvRango5($fecha_inicial, $fecha_final)
    {


        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_areas_de_conocimiento` ON `cv_usuario`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') >= :fecha_inicial and DATE_FORMAT(create_dt, '%Y-%m-%d') <= :fecha_final GROUP BY `usuario_identificacion`";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function listarPerfilDocRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM `docente` WHERE `fecha_actualizacion` >= :fecha_inicial and `fecha_actualizacion` <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarPerfilEstRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM estudiantes_datos_personales WHERE fecha_actualizacion >= :fecha_inicial and fecha_actualizacion <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function periodoactual()
    {
        $sql = "SELECT * FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
	public function caracterizacion($fecha)
    {
        $sql = "SELECT * FROM `caracterizacion_data` INNER JOIN `credencial_estudiante` ON `caracterizacion_data`.`id_credencial` = `credencial_estudiante`.`id_credencial` WHERE `fecha` = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function fechaesp($date)
    {
        $dia     = explode("-", $date, 3);
        $year     = $dia[0];
        $month     = (string)(int)$dia[1];
        $day     = (string)(int)$dia[2];

        $dias         = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
        $tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
    }

	public function caracterizacionsemana($fecha)
    {
        $sql = "SELECT * FROM `caracterizacion_data` INNER JOIN `credencial_estudiante` ON `caracterizacion_data`.`id_credencial` = `credencial_estudiante`.`id_credencial` WHERE `fecha` >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarCaracterizadosPorRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM `caracterizacion_data` INNER JOIN `credencial_estudiante` ON `caracterizacion_data`.`id_credencial` = `credencial_estudiante`.`id_credencial`  WHERE fecha >= :fecha_inicial and fecha <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listaringresosrangoestudiante($fecha_inicial, $fecha_final)
    {

        $sql = "SELECT * FROM ingresos_campus INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `ingresos_campus`.`id_usuario` WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and roll= 'Estudiante'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        //  $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function hojadevida($fecha)
    {

        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_areas_de_conocimiento` ON `cv_usuario`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') = :fecha GROUP BY `usuario_identificacion`";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function hojadevidasemanaymes($fecha)
    {
        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_areas_de_conocimiento` ON `cv_usuario`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') >= :fecha GROUP BY `usuario_identificacion`";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listarPorCvRango($fecha_inicial, $fecha_final)
    {



        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_areas_de_conocimiento` ON `cv_usuario`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') >= :fecha_inicial and DATE_FORMAT(create_dt, '%Y-%m-%d') <= :fecha_final GROUP BY `usuario_identificacion`";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function mostrarfuncionarios($fecha_actual)
    {


        $sql = "SELECT DISTINCT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip`,`usuario`.`usuario_identificacion` FROM `ingresos_campus` INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE `fecha` >= :fecha_actual and roll= 'Funcionario'";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
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

	public function listaringresosrangofuncionario($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip`,`usuario`.`usuario_identificacion` FROM ingresos_campus INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and roll= 'Funcionario'";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function mostrardocente($fecha_actual)
    {
        $sql = "SELECT DISTINCT `usuario_nombre`,`usuario_nombre_2`,`usuario_apellido`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip`,`docente`.`usuario_identificacion` FROM `docente` INNER JOIN `ingresos_campus` ON `ingresos_campus`.`id_usuario` = `docente`.`id_usuario` WHERE `roll` LIKE 'Docente' AND `fecha` >= :fecha_actual";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function mostrarestudiantes($fecha_actual)
    {

        $sql = "SELECT DISTINCT `credencial_nombre`,`credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`ingresos_campus`.`ip` , `ingresos_campus`.`hora`,`credencial_estudiante`.`credencial_identificacion` FROM `ingresos_campus` INNER JOIN `credencial_estudiante` ON `ingresos_campus`.`id_usuario` = `credencial_estudiante`.`id_credencial` WHERE `roll` LIKE 'Estudiante' AND `fecha` >= :fecha_actual";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listaringresosrangoestudiantes($fecha_inicial, $fecha_final)
    {


        $sql = "SELECT * FROM `estudiantes_datos_personales` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `estudiantes_datos_personales`.`id_credencial` WHERE `fecha_actualizacion` >= :fecha_inicial and `fecha_actualizacion` <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        //  $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function mostrarfaltas($fecha_actual)
    {
        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `fecha_falta` >= :fecha_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function mostrarfaltasayer($fecha_actual)
    {
        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `fecha_falta` = :fecha_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	    //Implementar un método para listar las faltas del rango
		public function listarFaltasPorRango5($fecha_inicial, $fecha_final)
		{
			$sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE fecha_falta >= :fecha_inicial and fecha_falta <= :fecha_final ";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":fecha_inicial", $fecha_inicial);
			$consulta->bindParam(":fecha_final", $fecha_final);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		public function casoquedate($fecha_actual)
    {
        $sql = "SELECT DISTINCT `credencial_nombre`,  `usuario`.`usuario_cargo`, `casos`.`updated_at` ,`credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`caso_id`,`caso_asunto`,`credencial_estudiante`.`credencial_identificacion`,`credencial_estudiante`.`credencial_identificacion`  FROM `casos` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `casos`.`id_estudiante` inner join `usuario` on `usuario`.`id_usuario` = `casos`.`area_id`  WHERE `created_at` = :fecha_actual";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function casoquedateultimasemana($fecha_actual)
    {
        $sql = "SELECT DISTINCT `credencial_nombre`,  `usuario`.`usuario_cargo`, `casos`.`updated_at` ,`credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`caso_id`,`caso_asunto`,`credencial_estudiante`.`credencial_identificacion`  FROM `casos` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `casos`.`id_estudiante` inner join `usuario` on `usuario`.`id_usuario` = `casos`.`area_id`  WHERE `created_at` >= :fecha_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function listarQuedatePorRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT DISTINCT `credencial_nombre`,  `usuario`.`usuario_cargo`, `casos`.`updated_at` ,`credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`caso_id`,`caso_asunto` ,`credencial_estudiante`.`credencial_identificacion` FROM `casos` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `casos`.`id_estudiante` inner join `usuario` on `usuario`.`id_usuario` = `casos`.`area_id`  WHERE created_at >= :fecha_inicial and created_at <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function contactanos($fecha_actual)
    {
        $sql = "SELECT * FROM `ayuda` INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ayuda`.`id_usuario` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial`= `ayuda`.`id_credencial` WHERE `fecha_solicitud` >= :fecha_actual";
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function listarContactanosPorRango5($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM `ayuda` INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ayuda`.`id_usuario` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial`= `ayuda`.`id_credencial` WHERE fecha_solicitud >= :fecha_inicial and fecha_solicitud <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
	public function listarEscuelas()
    {
        global $mbd;
        $consulta = $mbd->prepare("SELECT * FROM `escuelas` WHERE `estado` = 1;");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
	public function ListarClasesEscuela($dia, $escuela)
    {
        global $mbd;
        $periodo = $_SESSION["periodo_actual"];
        $sql = "SELECT * FROM `docente_grupos` AS `dc` INNER JOIN `materias_ciafi` AS `mc` ON `mc`.`id` = `dc`.`id_materia` INNER JOIN `programa_ac` ON `programa_ac`.`id_programa` = `dc`.`id_programa` INNER JOIN `escuelas` ON `escuelas`.`id_escuelas` = `programa_ac`.`escuela` WHERE `dc`.`dia` LIKE :dia AND `dc`.`periodo` = :periodo AND `escuelas`.`id_escuelas` = :escuela;";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":dia", $dia);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":escuela", $escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

	public function nombrePrograma($id_programa)
    {
        $sql = "SELECT * FROM `programa_ac` WHERE  `id_programa` = :id_programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

	public function nombreDocente($id_docente)
    {
        $sql = "SELECT * FROM `docente` WHERE  `id_usuario`= :id_docente";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
	public function listarClasesDelDia($dia)
    {
        global $mbd;
        $periodo = $_SESSION["periodo_actual"];
        $sql = "SELECT * FROM `docente_grupos` AS `dc` INNER JOIN `materias_ciafi` AS `mc` ON `mc`.`id` = `dc`.`id_materia` INNER JOIN `programa_ac` ON `programa_ac`.`id_programa` = `dc`.`id_programa` INNER JOIN `escuelas` ON `escuelas`.`id_escuelas` = `programa_ac`.`escuela` WHERE `dc`.`dia` LIKE :dia AND `dc`.`periodo` = :periodo;";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":dia", $dia);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

}
