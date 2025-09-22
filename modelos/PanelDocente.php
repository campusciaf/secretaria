<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class PanelDocente
{
    //Implementamos nuestro constructor
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


    //Implementar un método para listar los micompromisos
    public function listar()
    {
        $sql = "SELECT * FROM educacion_continuada WHERE estado=1";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // public function listarEventos()
    // {
    //     global $mbd;
    //     $sql = "SELECT * FROM `calendario_eventos`";
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll();
    //     return $resultado;
    // }

    public function listarcalendarioacademico($fecha)
    {
        global $mbd;
        $sql = "SELECT * FROM calendario WHERE  :fecha BETWEEN fecha_inicio AND fecha_final ";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
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

    //Implementar un método para saber si realizo la encuesta
    public function autoevaluacionEstado($id_usuario, $periodo_actual)
    {
        $sql = "SELECT * FROM `docente` WHERE `id_usuario` = :id_usuario AND `activar_autoevaluacion` = 0 ORDER BY `usuario_condicion` DESC";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para saber si realizo la encuesta
    public function consultarEstadoAutoevaluacion($tipo)
    {
        $sql = "SELECT * FROM `activar_evaluaciones` WHERE `tipo` = :tipo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":tipo", $tipo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para saber si realizo la encuesta
    public function actualizarEstadoAutoevaluacion($id_usuario)
    {
        $sql = "UPDATE `docente` SET `activar_autoevaluacion` = '1' WHERE `docente`.`id_usuario` = :id_usuario;";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        return $consulta->execute();
    }
    //Implementamos un método para insertar registros
    public function insertarEncuestaDocente($id_usuario, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $fecha, $hora, $periodo)
    {
        $sql = "INSERT INTO `autoevaluacion_docente`(id_usuario, r1, r2, r3, r4, r5, r6, r7, r8, r9, r10, fecha, hora, periodo) VALUES ('$id_usuario', '$r1', '$r2', '$r3', '$r4', '$r5', '$r6', '$r7', '$r8', '$r9', '$r10', '$fecha', '$hora', '$periodo')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }

    //Implementar un método para saber si actualizo el perfil
    public function verPerfilActualizado($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM docente WHERE id_usuario= :id_usuario and fecha_actualizacion >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Implementamos un método para actualizar el perfil
    public function actualizarperfil($id_usuario, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email, $fecha)
    {
        $sql = "UPDATE docente SET usuario_direccion= :usuario_direccion, usuario_telefono= :usuario_telefono, usuario_celular= :usuario_celular, usuario_email_p= :usuario_email, fecha_actualizacion= :fecha WHERE id_usuario= :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":usuario_direccion", $usuario_direccion);
        $consulta->bindParam(":usuario_telefono", $usuario_telefono);
        $consulta->bindParam(":usuario_celular", $usuario_celular);
        $consulta->bindParam(":usuario_email", $usuario_email);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($id_usuario)
    {
        $sql = "SELECT * FROM docente WHERE id_usuario= :id_usuario";
        //return ejecutarConsultaSimpleFila($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }




    //Implementar un método para listar los ingresos del docente
    public function listaringresos($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM ingresos_campus INNER JOIN `docente` ON `docente`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE ingresos_campus.id_usuario= :id_usuario and ingresos_campus.fecha = :fecha";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los ingresos del docente
    public function listaringresosemana($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM ingresos_campus WHERE id_usuario= :id_usuario and fecha>= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los ingresos e los funcionarios
    public function mostrardocente($id_usuario, $fecha_actual)
    {

        $sql = "SELECT DISTINCT `usuario_nombre`,`usuario_nombre_2`,`usuario_apellido`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip` FROM `docente` INNER JOIN `ingresos_campus` ON `ingresos_campus`.`id_usuario` = `docente`.`id_usuario` WHERE `roll` LIKE 'Docente' AND `fecha` = :fecha_actual and `ingresos_campus`.`id_usuario` = :id_usuario";
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
    public function mostrardocentesemana($id_usuario, $fecha_actual)
    {

        // $sql = "SELECT DISTINCT `usuario_nombre`,`usuario_nombre_2`,`usuario_apellido`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip` FROM `docente` INNER JOIN `ingresos_campus` ON `ingresos_campus`.`id_usuario` = `docente`.`id_usuario` WHERE `roll` LIKE 'Docente' AND `fecha` >= :fecha_actual and `ingresos_campus`.`id_usuario` = :id_usuario";

        $sql = "SELECT * FROM ingresos_campus INNER JOIN `docente` ON `docente`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE ingresos_campus.id_usuario = :id_usuario and ingresos_campus.fecha >= :fecha_actual";
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
    public function listarfaltas($id_usuario, $fecha_actual)
    {
        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `docente`.`id_usuario` = :id_usuario and `fecha_falta`= :fecha_actual";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    //Implementar un método para listar las faltas generadas por el docente
    // public function listarfaltas($id_usuario,$fecha)
    // {
    //     $sql="SELECT * FROM faltas WHERE id_docente= :id_usuario and fecha_falta= :fecha";
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":id_usuario", $id_usuario);
    //     $consulta->bindParam(":fecha", $fecha);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll();
    //     return $resultado;
    // }

    public function consulta_programas($id)
    {
        // metodo que trae los programas activos
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $consulta = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_credencial` = :id AND `periodo_activo` = :periodo and estado = '1'");
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }



    //Implementar un método para listar los ingresos e los funcionarios
    public function mostrarfaltassemana($id_usuario, $fecha_actual)
    {
        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `docente`.`id_usuario` = :id_usuario and `fecha_falta`>= :fecha_actual";
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
        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `docente`.`id_usuario` = :id_usuario and `fecha_falta`= :fecha_actual";
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
    public function actividades($fecha)
    {
        $sql = "SELECT * FROM pea_actividades WHERE fecha_actividad = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los ingresos e los funcionarios
    public function casoquedate($fecha_actual)
    {
        $sql = "SELECT DISTINCT `credencial_nombre`, `credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`caso_id`,`caso_asunto` FROM `casos` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `casos`.`id_estudiante` WHERE created_at >= :fecha_actual";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los perfiles actualizados del rango seleccionado
    public function perfilactualizadodocente($fecha, $id_usuario)
    {
        $sql = "SELECT * FROM docente WHERE fecha_actualizacion >= :fecha and `id_usuario` = :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        // $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los casos abiertos en guia
    public function perfilactualizadodocenterango($id_usuario, $fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM docente WHERE id_usuario= :id_usuario and DATE_FORMAT(fecha_actualizacion, '%Y-%m-%d') >= :fecha_inicial and DATE_FORMAT(fecha_actualizacion, '%Y-%m-%d') <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los perfiles actualizados del rango seleccionado
    public function perfilactualizadodocenteayer($fecha, $id_usuario)
    {
        $sql = "SELECT * FROM docente WHERE fecha_actualizacion = :fecha and `id_usuario` = :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        // $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listarlas hojas de vida nuevas en plataforma
    public function usuariohojadevida($fecha)
    {
        // SELECT * FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_usuario`.`id_usuario_cv` = `cv_informacion_personal`.`id_usuario_cv` WHERE cv_usuario.id_usuario_cv= :id_usuario_cv and DATE_FORMAT(create_dt, '%Y-%m-%d')>= "2022-06-21"

        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_usuario`.`id_usuario_cv` = `cv_informacion_personal`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d')>= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los casos abiertos en guia
    public function usuariohojadevidarango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_usuario`.`id_usuario_cv` = `cv_informacion_personal`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') >= :fecha_inicial and DATE_FORMAT(create_dt, '%Y-%m-%d') <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    public function hojadevidaayer($fecha)
    {


        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_usuario`.`id_usuario_cv` = `cv_informacion_personal`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d')= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
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

    //Implementar un método para listar los casos abiertos en guia
    public function listarguia($id_usuario, $fecha)
    {
        $sql = "SELECT `guia_casos`.* , `usuario`.`usuario_cargo` FROM guia_casos INNER JOIN `usuario` ON `usuario`.`id_usuario` = `guia_casos`.`area_id`  WHERE id_docente= :id_usuario and DATE_FORMAT(created_at, '%Y-%m-%d')= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los casos abiertos en guia
    public function listarguiaayer($id_usuario, $fecha)
    {
        $sql = "SELECT `guia_casos`.* , `usuario`.`usuario_cargo` FROM guia_casos INNER JOIN `usuario` ON `usuario`.`id_usuario` = `guia_casos`.`area_id`  WHERE id_docente= :id_usuario and DATE_FORMAT(created_at, '%Y-%m-%d')= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los casos abiertos en guia
    public function listarguiatablasemana($id_usuario, $fecha)
    {
        $sql = "SELECT `guia_casos`.* , `usuario`.`usuario_cargo` FROM guia_casos INNER JOIN `usuario` ON `usuario`.`id_usuario` = `guia_casos`.`area_id` WHERE id_docente= :id_usuario and DATE_FORMAT(created_at, '%Y-%m-%d')>= :fecha";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }



    //Implementar un método para listar los casos por rango 
    public function listarguiarango5($id_usuario, $fecha_inicial, $fecha_final)
    {
        $sql = "SELECT `guia_casos`.* , `usuario`.`usuario_cargo` FROM guia_casos INNER JOIN `usuario` ON `usuario`.`id_usuario` = `guia_casos`.`area_id` WHERE id_docente= :id_usuario and DATE_FORMAT(created_at, '%Y-%m-%d') >= :fecha_inicial and DATE_FORMAT(created_at, '%Y-%m-%d') <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    //Implementar un método para listar los ingresos por semana y mes actual
    public function listaringresossemana($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM ingresos_campus WHERE id_usuario= :id_usuario and fecha >= :fecha";

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
        $sql = "SELECT * FROM faltas WHERE id_docente= :id_usuario and fecha_falta >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
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

    //Implementar un método para listar los casos abiertos en guia
    public function listarguiasemana($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM guia_casos WHERE id_docente= :id_usuario and DATE_FORMAT(created_at, '%Y-%m-%d')>= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los ingresos por rango
    public function listaringresosrango($id_usuario, $fecha_inicial, $fecha_final)
    {

        $sql = "SELECT * FROM ingresos_campus  WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and id_usuario= :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los ingresos por rango para saber el nombre del docente
    public function listaringresosrangonombredocente($id_usuario, $fecha_inicial, $fecha_final)
    {
        // SELECT * FROM `ingresos_campus` INNER JOIN `docente` ON ingresos_campus.id_usuario = docente.id_usuario WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and `ingresos_campus`.id_usuario= :id_usuario;
        $sql = "SELECT * FROM `ingresos_campus` INNER JOIN `docente` ON `ingresos_campus`.`id_usuario` = `docente`.`id_usuario` WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and `ingresos_campus`.id_usuario= :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las faltas generadas por el docente
    public function listarfaltasrango($id_usuario, $fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `docente`.`id_usuario` = :id_usuario and fecha_falta >= :fecha_inicial and fecha_falta <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }




    //Implementar un método para listar las faltas generadas por el docente
    public function listarfaltasrangonombre($id_usuario, $fecha_inicial, $fecha_final)
    {



        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `docente`.`id_usuario` = :id_usuario and fecha_falta >= :fecha_inicial and fecha_falta <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }






    //Implementar un método para listar las actividades subidas
    public function listaractividadesrango($id_usuario, $fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM pea_actividades WHERE id_docente_grupo= :id_usuario and fecha_actividad >= :fecha_inicial and fecha_actividad <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los casos abiertos en guia
    public function listarguiarango($id_usuario, $fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM guia_casos WHERE id_docente= :id_usuario and DATE_FORMAT(created_at, '%Y-%m-%d') >= :fecha_inicial and DATE_FORMAT(created_at, '%Y-%m-%d') <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    //Implementar un método para mostrar la ultima fecha de actualización del perfil
    public function fechaperfilactualizado($id_usuario)
    {
        $sql = "SELECT id_usuario,usuario_identificacion,fecha_actualizacion FROM docente WHERE id_usuario= :id_usuario";
        // echo $sql;
        //return ejecutarConsultaSimpleFila($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para mostrar la ultima fecha de actualización de la hoja de vida
    public function fechacvactualizado($usuario_identificacion)
    {
        $sql = "SELECT usuario_identificacion,fecha_actualizacion FROM cv_usuario WHERE usuario_identificacion= :usuario_identificacion";
        //return ejecutarConsultaSimpleFila($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
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

















    public function consultaDatos($id)
    {
        $sql = "SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial = edp.id_credencial INNER JOIN estudiantes est ON ce.id_credencial = est.id_credencial WHERE ce.id_credencial = :id and est.estado=1";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function fechaesp($date)
    {
        $dia     = explode("-", $date, 3);
        $year     = $dia[0];
        @$month     = (string)(int)$dia[1];
        @$day     = (string)(int)$dia[2];

        $dias         = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
        @$tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
    }

    //Implementar un método para saber si actualizo el perfil
    public function encuestatic($id_usuario, $periodo_actual)
    {
        $sql = "SELECT * FROM encuesta_tic WHERE id_docente= :id_usuario and periodo= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //     //Implementamos un método para insertar registros
    // public function insertarencuestatic($id_usuario,$fecha,$hora,$periodo,$er1,$er2,$er3,$er4,$er5,$er6,$er7,$er8,$er9,$er10,$er11,$er12,$er13,$er14,$er15,$er16,$er17,$er18,$er19,$er20,$er21,$er22,$er23,$er24,$er25,$er26,$er27,$er28,$er29,$er30,$er31,$er32,$er33,$er34,$er35,$er36,$er37,$er38,$er39,$er40,$er41,$er42,$er43,$er44,$er45,$promedio){
    // 	$sql="INSERT INTO `encuesta_tic`(id_docente, fecha, hora, periodo, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10, p11, p12, p13, p14, p15, p16, p17, p18, p19, p20, p21, p22, p23, p24, p25, p26, p27, p28, p29, p30 , p31, p32, p33, p34, p35, p36, p37, p38, p39, p40, p41, p42, p43, p44, p45, promedio) VALUES ('$id_usuario', '$fecha', '$hora', '$periodo' , '$er1', '$er2' ,'$er3','$er4','$er5','$er6','$er7','$er8','$er9','$er10','$er11','$er12','$er13','$er14','$er15','$er16','$er17','$er18','$er19','$er20','$er21','$er22','$er23','$er24','$er25','$er26','$er27','$er28','$er29','$er30','$er31','$er32','$er33','$er34','$er35','$er36','$er37','$er38','$er39','$er40','$er41','$er42','$er43','$er44','$er45', '$promedio')";
    // 	global $mbd;
    // 	$consulta = $mbd->prepare($sql);
    // 	return $consulta->execute();
    // }


    //Implementamos un método para insertar registros
    public function insertarencuestatic($id_usuario, $fecha, $hora, $periodo, $id_pregunta, $er1)
    {
        $sql = "INSERT INTO `encuesta_tic`(id_docente, fecha, hora, periodo, id_pregunta, respuesta) VALUES ('$id_usuario', '$fecha', '$hora', '$periodo' , '$id_pregunta', '$er1')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }



    //Implementar un método para saber si actualizo el perfil
    public function encuestaticpreguntas($id_usuario, $periodo_actual)
    {
        $sql = "SELECT * FROM encuesta_tic WHERE id_docente= :id_usuario and periodo= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para saber si actualizo el perfil
    public function traerpregunta($pregunta)
    {
        $sql = "SELECT * FROM encuesta_tic_preguntas WHERE id_encuesta_tic= :pregunta";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":pregunta", $pregunta);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function estudiantesacargo($id_usuario)
    {
        $periodo = $_SESSION['periodo_actual'];
        $sql = "SELECT * FROM `docente_grupos` INNER JOIN `estudiantes` ON `estudiantes`.`id_programa_ac` = `docente_grupos`.`id_programa` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `estudiantes`.`id_estudiante` WHERE `id_docente` = :id_usuario AND `docente_grupos`.`periodo` = :periodo";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar las materias
    public function listargrupos($id_docente)
    {
        $sql = "SELECT * FROM docente_grupos WHERE id_docente= :id_docente and periodo='" . $_SESSION["periodo_actual"] . "' ";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar las materias
    public function listargrupos_dia_actual($id_docente, $dia)
    {
        $sql = "SELECT * FROM docente_grupos WHERE id_docente= :id_docente and dia=:dia and periodo='" . $_SESSION["periodo_actual"] . "' ";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->bindParam(":dia", $dia);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para buscar los datos de la materia a matricular
    public function MateriaDatos($id)
    {
        $sql = "SELECT * FROM materias_ciafi WHERE id= :id ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

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

    //Implementar un método para mirar la joranda
    public function jornada($jornada)
    {
        $sql = "SELECT * FROM jornada WHERE nombre= :jornada";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para mirar la hora
    public function horasFormato($horas)
    {
        $sql = "SELECT * FROM horas_del_dia WHERE horas= :horas";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":horas", $horas);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para traer el id de la materia matriculada por el estudiante
    public function tienepea($id_materia)
    {
        $sql = "SELECT id_pea,id_materia,estado FROM pea WHERE id_materia= :id_materia and estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_materia", $id_materia);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }



    //Implementar un método para listar las materias
    public function listarelgrupo($id_docente_grupo)
    {
        $sql = "SELECT * FROM docente_grupos WHERE id_docente_grupo= :id_docente_grupo and periodo='" . $_SESSION["periodo_actual"] . "' ";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para mirar el id del estudiante
    public function id_estudiante($id_estudiante)
    {
        $sql = "SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante";

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
        $sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar las materias
    public function listar_materias($ciclo, $materia, $jornada, $id_programa, $grupo)
    {

        $tabla = "materias" . $ciclo;
        $periodo_actual = $_SESSION["periodo_actual"];

        $sql = "SELECT * FROM $tabla WHERE `nombre_materia` = :materia AND `jornada` = :jornada AND `programa` = :id_programa AND `periodo` = '$periodo_actual' AND `grupo` = :grupo";
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

    //Implementar un método para tener los datos del docente
    public function datosDocente($id_usuario)
    {
        $sql = "SELECT * FROM docente WHERE id_usuario= :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para tener los datos del docente
    public function usuario_cv($usuario_identificacion)
    {
        $sql = "SELECT * FROM cv_usuario WHERE usuario_identificacion= :usuario_identificacion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para tener los datos del docente
    public function usuario_cv_personal($id_usuario_cv)
    {
        $sql = "SELECT * FROM cv_informacion_personal WHERE id_usuario_cv= :id_usuario_cv";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        // $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //  //Implementar un método para listar los casos abiertos en guia
    //  public function usuario_cv_personal_rango($id_usuario_cv,$fecha_inicial,$fecha_final)
    //  {
    //      $sql="SELECT * FROM cv_informacion_personal WHERE id_usuario_cv = :id_usuario_cv DATE_FORMAT(ultima_actualizacion, '%Y-%m-%d') >= :fecha_inicial and DATE_FORMAT(ultima_actualizacion, '%Y-%m-%d') <= :fecha_final";
    //      global $mbd;
    //      $consulta = $mbd->prepare($sql);
    //      $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
    //      $consulta->bindParam(":fecha_inicial", $fecha_inicial);
    //      $consulta->bindParam(":fecha_final", $fecha_final);
    //      $consulta->execute();
    //      $resultado = $consulta->fetchAll();
    //      return $resultado;
    //  }

    //Implementar un método para listar las faltas generadas por el docente
    public function usuario_cv_personal_rango($id_usuario_cv, $fecha_inicial, $fecha_final)
    {



        $sql = "SELECT * FROM `cv_informacion_personal` WHERE id_usuario_cv= :id_usuario_cv and ultima_actualizacion >= :fecha_inicial and ultima_actualizacion <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar las horas del dia
    public function TraerHorariocalendario($id_docente, $id_programa, $jornada, $semestre, $grupo)
    {
        // $id_docente = $_SESSION["id_usuario"];
        $sql = "SELECT * FROM docente_grupos WHERE id_docente= :id_docente and id_programa= :id_programa and jornada= :jornada and semestre= :semestre and grupo= :grupo";
        //    echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":grupo", $grupo);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
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

    public function listarGruposPeriodo($id_docente, $periodo)
    {
        global $mbd;
        $tabla = ($periodo >= "2022-2") ? "docente_grupos" : "docente_grupos_2";
        $sentencia = $mbd->prepare("SELECT $tabla.`id_docente_grupo`, $tabla.`id_materia`, `programa_ac`.`nombre` AS `nombre_programa` FROM $tabla INNER JOIN `programa_ac` ON `programa_ac`.`id_programa` = $tabla.`id_programa` WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function materiasPorDocente($id_docente, $periodo)
    {
        $tabla = ($periodo >= "2022-2") ? "docente_grupos" : "docente_grupos_2";
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS `total` FROM $tabla WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function listarResultados($id_docente_grupo, $periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(`id_docente_grupos`) as `cantidad`, SUM(`total`) AS `total`, `id_docente` , `id_docente_grupos`, (SUM(`total`) / COUNT(`id_docente_grupos`)) AS `promedio` FROM `heteroevaluacion` WHERE `id_docente_grupos` = :id_docente_grupo AND `periodo` = :periodo");
        $sentencia->bindParam(":id_docente_grupo", $id_docente_grupo);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function listarComentarios($id_docente, $periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `p23` FROM `heteroevaluacion` WHERE `id_docente` = :id_docente AND `periodo` = :periodo AND `p23` <> '';");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }

    //Implementar un método para listar las materias
    public function docente_grupo_actividades($id_docente)
    {
        $sql = "SELECT * FROM docente_grupos WHERE id_docente= :id_docente and periodo='" . $_SESSION["periodo_actual"] . "' ";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer el id de la materia matriculada por el estudiante
    public function tienepeadocente($id_docente_grupo)
    {
        $sql = "SELECT * FROM pea_docentes WHERE id_docente_grupo= :id_docente_grupo";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
        // $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar las actividades subidas
    public function listar_pea_actividades($fecha, $id_pea_documento)
    {
        $sql = "SELECT * FROM pea_documentos WHERE fecha_actividad= :fecha and `id_pea_documento` = :id_pea_documento";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_pea_documento", $id_pea_documento);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los ingresos del docente
    public function listar_pea_actividades_semana($id_usuario, $fecha_actividad)
    {
        $sql = "SELECT * FROM `docente` INNER JOIN `docente_grupos` ON `docente_grupos`.`id_docente` = `docente`.`id_usuario` INNER JOIN `pea_docentes` ON `docente_grupos`.`id_docente_grupo` = `pea_docentes`.`id_docente_grupo` INNER JOIN `pea_documentos` ON `pea_documentos`.`id_pea_documento` = `pea_docentes`.`id_pea` WHERE `docente`.`id_usuario` = :id_usuario and fecha_actividad >= :fecha_actividad and periodo = '" . $_SESSION["periodo_actual"] . "';";
        //echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha_actividad", $fecha_actividad);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function listar_actividades($id_usuario, $fecha_actividad)
    {
        $sql = "SELECT * FROM `docente` INNER JOIN `docente_grupos` ON `docente_grupos`.`id_docente` = `docente`.`id_usuario` INNER JOIN `pea_docentes` ON `docente_grupos`.`id_docente_grupo` = `pea_docentes`.`id_docente_grupo` INNER JOIN `pea_documentos` ON `pea_documentos`.`id_pea_documento` = `pea_docentes`.`id_pea` WHERE `docente`.`id_usuario` = :id_usuario and fecha_actividad = :fecha_actividad and periodo = '" . $_SESSION["periodo_actual"] . "';";
        //echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":fecha_actividad", $fecha_actividad);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar los ingresos por rango para saber el nombre del docente
    public function listar_actividades_por_fecha($id_usuario, $fecha_inicial, $fecha_final)
    {

        $sql = "SELECT * FROM `docente` INNER JOIN `docente_grupos` ON `docente_grupos`.`id_docente` = `docente`.`id_usuario` INNER JOIN `pea_docentes` ON `docente_grupos`.`id_docente_grupo` = `pea_docentes`.`id_docente_grupo` INNER JOIN `pea_documentos` ON `pea_documentos`.`id_pea_documento` = `pea_docentes`.`id_pea` WHERE fecha_actividad >= :fecha_inicial and fecha_actividad <= :fecha_final and `docente`.`id_usuario` = :id_usuario and periodo = '" . $_SESSION["periodo_actual"] . "';";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
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

    // public function listarEventos($fecha_actual,$fecha_actual_eventos)
    // {
    //     $sql_buscar = "SELECT * FROM `calendario_eventos` WHERE `fecha_inicio` LIKE '%$fecha_actual%' and `fecha_inicio` >= '$fecha_actual_eventos'";
    //     // echo $sql_buscar;
    //     global $mbd;
    //     $consulta_buscar = $mbd->prepare($sql_buscar);
    //     $consulta_buscar->execute();
    //     $resultado_buscar = $consulta_buscar->fetchall();
    //     return $resultado_buscar;
    // }


    public function listarEventos($fecha_actual, $fecha_actual_eventos)
    {
        $sql_buscar = "SELECT * FROM `calendario_eventos` WHERE `fecha_inicio` LIKE :fecha_actual AND `fecha_inicio` >= :fecha_actual_eventos";

        global $mbd;
        $consulta_buscar = $mbd->prepare($sql_buscar);
        $consulta_buscar->bindValue(':fecha_actual', "%$fecha_actual%");
        $consulta_buscar->bindValue(':fecha_actual_eventos', $fecha_actual_eventos);
        $consulta_buscar->execute();
        $resultado_buscar = $consulta_buscar->fetchAll();
        return $resultado_buscar;
    }



    public function mostrarElementos()
    {

        $sql_mostrar = "SELECT * FROM `software_libre` ORDER BY `software_libre`.`id_software` DESC LIMIT 16";
        global $mbd;
        $consulta_mostrar = $mbd->prepare($sql_mostrar);
        $consulta_mostrar->execute();
        $resultado_mostrar = $consulta_mostrar->fetchall();
        return $resultado_mostrar;
    }

    public function mostrarshopping()
    {

        $sql_mostrar = "SELECT * FROM `shopping` WHERE shopping_participar='3' ORDER BY `shopping`.`id_shopping` DESC";
        global $mbd;
        $consulta_mostrar = $mbd->prepare($sql_mostrar);
        $consulta_mostrar->execute();
        $resultado_mostrar = $consulta_mostrar->fetchall();
        return $resultado_mostrar;
    }

    public function mostrarcursosinscritos($identificacion)
    {
        $sql = "SELECT * FROM educacion_continuada_interesados eci INNER JOIN web_educacion_continuada wec ON eci.id_curso=wec.id_curso WHERE eci.identificacion= :identificacion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":identificacion", $identificacion);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function verificarInteresado($id_curso, $identificacion)
    {
        $sql = "SELECT * FROM `educacion_continuada_interesados` WHERE `id_curso` = :id_curso and `identificacion` = :identificacion ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_curso", $id_curso);
        $consulta->bindParam(":identificacion", $identificacion);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Implementamos un método para insertar un nuevo cliente de educacion continuada
    public function insertarInteresado($identificacion, $id_curso, $periodo_ingreso, $fecha, $hora, $estado, $periodo_campana, $id_usuario)
    {
        $sql = "INSERT INTO educacion_continuada_interesados(identificacion,id_curso,periodo_ingreso,fecha_ingreso,hora_ingreso,estado_interesado,periodo_campana,id_usuario) VALUES('$identificacion','$id_curso','$periodo_ingreso','$fecha','$hora','$estado','$periodo_campana','$id_usuario')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }

    public function eliminarinscripcion($id)
    {
        $sql = "DELETE FROM `educacion_continuada_interesados` WHERE `id_edu_cont_in` = :id";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
        return $consulta->execute();
    }

    public function GuardarmonitoreandoDocente($id_usuario_docente, $fecha,  $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15, $p16, $p17, $p18, $p19, $p20, $p21, $p22, $p23, $p24, $p25, $p26, $p27, $p28, $p29, $p30, $p31, $p32, $p33, $p34, $p35, $p36)
    {
        $sql = "INSERT INTO `monitoreando_docentes`(`id_usuario_docente` , `fecha` ,  `p1`, `p2`, `p3`, `p4`, `p5`, `p6`, `p7`, `p8`, `p9`, `p10`, `p11`, `p12`, `p13`, `p14`, `p15`, `p16`, `p17`, `p18`, `p19`, `p20`, `p21`, `p22`, `p23`, `p24`, `p25`, `p26`, `p27`, `p28`, `p29`, `p30`, `p31`, `p32`, `p33`, `p34` , `p35`, `p36` ) 
                VALUES (:id_usuario_docente , :fecha , :p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, :p11, :p12, :p13, :p14, :p15, :p16, :p17, :p18, :p19, :p20, :p21, :p22, :p23, :p24, :p25, :p26, :p27, :p28, :p29, :p30, :p31, :p32, :p33, :p34, :p35, :p36);";

        // echo $sql;

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_docente", $id_usuario_docente);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":p1", $p1);
        $consulta->bindParam(":p2", $p2);
        $consulta->bindParam(":p3", $p3);
        $consulta->bindParam(":p4", $p4);
        $consulta->bindParam(":p5", $p5);
        $consulta->bindParam(":p6", $p6);
        $consulta->bindParam(":p7", $p7);
        $consulta->bindParam(":p8", $p8);
        $consulta->bindParam(":p9", $p9);
        $consulta->bindParam(":p10", $p10);
        $consulta->bindParam(":p11", $p11);
        $consulta->bindParam(":p12", $p12);
        $consulta->bindParam(":p13", $p13);
        $consulta->bindParam(":p14", $p14);
        $consulta->bindParam(":p15", $p15);
        $consulta->bindParam(":p16", $p16);
        $consulta->bindParam(":p17", $p17);
        $consulta->bindParam(":p18", $p18);
        $consulta->bindParam(":p19", $p19);
        $consulta->bindParam(":p20", $p20);
        $consulta->bindParam(":p21", $p21);
        $consulta->bindParam(":p22", $p22);
        $consulta->bindParam(":p23", $p23);
        $consulta->bindParam(":p24", $p24);
        $consulta->bindParam(":p25", $p25);
        $consulta->bindParam(":p26", $p26);
        $consulta->bindParam(":p27", $p27);
        $consulta->bindParam(":p28", $p28);
        $consulta->bindParam(":p29", $p29);
        $consulta->bindParam(":p30", $p30);
        $consulta->bindParam(":p31", $p31);
        $consulta->bindParam(":p32", $p32);
        $consulta->bindParam(":p33", $p33);
        $consulta->bindParam(":p34", $p34);
        $consulta->bindParam(":p35", $p35);
        $consulta->bindParam(":p36", $p36);

        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }
    public function verificarRegistromonitoreandodocente($id_usuario_docente)
    {
        global $mbd;
        $sql = "SELECT * FROM `monitoreando_docentes` WHERE `id_usuario_docente` = :id_usuario_docente ";
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":id_usuario_docente", $id_usuario_docente);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function estadoModalMonitorandoDocente($id_usuario_docente)
    {
        $sql = "SELECT * FROM `monitoreando_docentes` WHERE  `id_usuario_docente`= :id_usuario_docente";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_docente", $id_usuario_docente);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function listarCursosEC($fecha)
    {
        $sql = "SELECT * FROM `web_educacion_continuada` WHERE `fecha_inicio` >= :fecha and `estado_educacion` = 1";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function convertirFechaAtexto($fecha)
    {
        $meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        //fecha inicio
        $date = $fecha;
        //fecha separada
        $date = explode("-", $date);
        //tomamos el dia 
        $datos["dia"] = $date[2];
        //tomamos el mes
        $mes = $date[1];
        //convertimos mes a texto
        $datos["mes_texto"] = $meses[($mes - 1)];
        //retornamos el arreglo
        return $datos;
    }

    public function docenteSinFoto($id_usuario)
{
    $sql = "SELECT usuario_imagen FROM docente WHERE id_usuario = :id_usuario";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_usuario", $id_usuario);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    // Retorna true si NO tiene foto
    return (empty($resultado['usuario_imagen']));
}

    //Implementar un método para listar los ingresos e los estudiantes
    public function ingresoDia($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM ingresos_campus WHERE id_usuario = :id_usuario and fecha = :fecha and roll='Docente'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

        	//Implementar un método para mirar si el punto esta otorgado
	public function validarpuntos($evento,$fecha,$id_usuario){	

		$sql=" SELECT * FROM puntos_docente WHERE id_usuario= :id_usuario and punto_nombre= :evento and punto_fecha= :fecha";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":evento", $evento);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}

        //Insertar punto en tabla puntos
	public function insertarPunto($id_usuario,$punto_nombre,$puntos_cantidad,$punto_fecha,$punto_hora,$punto_periodo)
	{
		$sql="INSERT INTO puntos_docente (`id_usuario`, `punto_nombre`, `puntos_cantidad`, `punto_fecha`, `punto_hora`, `punto_periodo`) VALUES ('$id_usuario','$punto_nombre','$puntos_cantidad','$punto_fecha','$punto_hora','$punto_periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

        //Implementar un método para ver los puntos del docenete
	public function verpuntos($id_usuario){	
		$sql=" SELECT * FROM docente WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}

    	//Implementamos un método para actualizar el valor de los puntos del docente
	public function actulizarValor($id_usuario,$puntos)
	{
		$sql="UPDATE docente SET puntos= :puntos WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":puntos", $puntos);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}



}
