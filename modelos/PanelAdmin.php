<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class PanelAdmin
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
    public function listarEscuelas()
    {
        global $mbd;
        $consulta = $mbd->prepare("SELECT * FROM `escuelas` WHERE `estado` = 1;");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para listar los ingresos e los funcionarios
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
    //Implementar un método para listar las faltas
    public function listarfaltas($fecha)
    {
        $sql = "SELECT * FROM faltas WHERE fecha_falta= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las faltas
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
    //Implementar un método para listar las faltas
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
    //Implementar un método para listar los casso de l quedate semana y mes actual
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
    //Implementar un método para listar los casso de l quedate semana y mes actual
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
    //Implementar un método para listarlas hojas de vida nuevas en plataforma
    public function listarCv($fecha)
    {
        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_areas_de_conocimiento` ON `cv_usuario`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') = :fecha GROUP BY `usuario_identificacion`";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados
    public function listarPerfil($fecha)
    {
        $sql = "SELECT * FROM usuario WHERE fecha_actualizacion = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados
    public function listarPerfilDoc($fecha)
    {
        $sql = "SELECT * FROM docente WHERE fecha_actualizacion = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados de estudiantes
    public function listarPerfilEst($fecha)
    {
        $sql = "SELECT * FROM estudiantes_datos_personales WHERE fecha_actualizacion = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los ingresos por semana y mes actual
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
    //Implementar un método para listar las faltas de la semana y mes actual
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
    //Implementar un método para listar los casso de l quedate semana y mes actual
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
    //Implementar un método para listar los casos del contactanos semana y mes actual
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
    //Implementar un método para listar los casos del contactanos semana y mes actual
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
    //Implementar un método para listar los casos del contactanos semana y mes actual
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
    //Implementar un método para listar las hojas de vida nueva
    public function listarCvSemana($fecha)
    {
        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_areas_de_conocimiento` ON `cv_usuario`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') >= :fecha GROUP BY `usuario_identificacion`";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados de la semana y el mes
    public function listarPerfilSemana($fecha)
    {
        $sql = "SELECT * FROM usuario WHERE fecha_actualizacion >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados de la semana y el mes
    public function listarPerfilDocSemana($fecha)
    {
        $sql = "SELECT fecha_actualizacion FROM docente WHERE fecha_actualizacion >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados de la semana del estudiante
    public function listarPerfilEstSemana($fecha)
    {
        $sql = "SELECT fecha_actualizacion FROM estudiantes_datos_personales WHERE fecha_actualizacion >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los ingresos por una fecha
    public function listaringresosrangofecha($fecha_inicial)
    {
        // SELECT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip` FROM ingresos_campus INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= :fecha_inicial and roll= :roll
        $sql = "SELECT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip` FROM ingresos_campus INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= :fecha_inicial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        // $consulta->bindParam(":fecha_final", $fecha_final);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar el rol y por fecha
    public function listaringresosfecharol($fecha_inicial, $roll)
    {
        $sql = "SELECT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip` FROM ingresos_campus INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= :fecha_inicial and roll= :roll";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        // $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las compras por semana
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
    //Implementar un método para listar las compras por semana
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
    //Implementar un método para listar las compras por semana
    public function listaringresosrangofuncionario($fecha_inicial, $fecha_final)
    {
        // SELECT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip` FROM ingresos_campus INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= "2022-06-01" and fecha <= "2022-06-08" and roll= "Funcionario"
        // SELECT DISTINCT * FROM ingresos_campus  WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and roll= :roll
        $sql = "SELECT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip`,`usuario`.`usuario_identificacion` FROM ingresos_campus INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and roll= 'Funcionario'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        //   $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las compras por semana
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
    //Implementar un método para listar la fecha actual y por rol
    public function listaringresosrangoporroldocente($fecha_inicial)
    {
        // SELECT `usuario`.`id_usuario`, `usuario`.`usuario_nombre`, `usuario`.`usuario_apellido`,`usuario`.`usuario_nombre_2`, `ingresos_campus`.`fecha`, `ingresos_campus`.`hora`,`ingresos_campus`.`ip` FROM ingresos_campus INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= "2022-06-01" and fecha <= "2022-06-08" and roll= "Funcionario"
        // SELECT DISTINCT * FROM ingresos_campus  WHERE fecha >= :fecha_inicial and fecha <= :fecha_final and roll= :roll
        $sql = "SELECT * FROM ingresos_campus INNER JOIN `docente` ON `docente`.`id_usuario` = `ingresos_campus`.`id_usuario` WHERE fecha >= :fecha_inicial and roll= 'Docente'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        //  $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las compras por semana
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
    //Implementar un método para listar la fecha actual y por rol
    public function listaringresosrangoporrolestudiante($fecha_inicial)
    {
        $sql = "SELECT * FROM ingresos_campus INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `ingresos_campus`.`id_usuario` WHERE fecha >= :fecha_inicial and roll= 'Estudiante'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        //  $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las faltas del rango
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
    //Implementar un método para listar las faltas del rango
    public function listarFaltasPorRango5($fecha_inicial, $fecha_final)
    {
        // SELECT * FROM `faltas` INNER JOIN `docente` ON `faltas`.`id_docente` = `docente`.`id_usuario` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `docente`.`id_usuario` WHERE fecha_falta >= "2022-06-01" and fecha_falta <= "2022-06-10"
        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE fecha_falta >= :fecha_inicial and fecha_falta <= :fecha_final ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los casso de l quedate semana y mes actual
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
    //Implementar un método para listar los casso de l quedate semana y mes actual
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
    //Implementar un método para listar los casos del contactanos semana y mes actual
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
    //Implementar un método para listar los casos del contactanos semana y mes actual
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
    //Implementar un método para listar los casos del contactanos semana y mes actual
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
    //Implementar un método para listar los casos del contactanos semana y mes actual
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
    //Implementar un método para listar los casos del contactanos semana y mes actual
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
    //Implementar un método para listar las hojas de vida nueva
    public function listarCvRango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM cv_informacion_personal WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') >= :fecha_inicial and DATE_FORMAT(create_dt, '%Y-%m-%d') <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las hojas de vida nueva
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
    //Implementar un método para listar las hojas de vida nueva
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
    //Implementar un método para listar las hojas de vida nueva
    public function listarPorCvRangoconareaconocimiento($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM `cv_areas_de_conocimiento` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') >= :fecha_inicial and DATE_FORMAT(create_dt, '%Y-%m-%d') <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados del rango seleccionado
    public function listarPerfilPorRango($fecha_inicial, $fecha_final)
    {
        // 
        // WHERE fecha_actualizacion >= :fecha_inicial and fecha_actualizacion <= :fecha_final
        $sql = "SELECT * FROM usuario INNER JOIN docente INNER JOIN estudiantes_datos_personales WHERE estudiantes_datos_personales.fecha_actualizacion >= :fecha_inicial and estudiantes_datos_personales.fecha_actualizacion <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados del rango seleccionado
    public function listarPerfilAdminRango($fecha)
    {
        $sql = "SELECT * FROM `usuario` WHERE fecha_actualizacion >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        // $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados del rango seleccionado
    public function listarPerfilAdminRangoMesActual($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT * FROM `usuario` WHERE `fecha_actualizacion` >= :fecha_inicial and `fecha_actualizacion` <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados del rango seleccionado
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
    //Implementar un método para listar los perfiles actualizados del rango seleccionado
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
    // public function listarcalendarioacademico($fecha)
    // {
    //     global $mbd;
    //     $sql = "SELECT * FROM calendario WHERE :fecha BETWEEN fecha_inicio AND fecha_final ";
    //     // echo $sql;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":fecha", $fecha);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll();
    //     return $resultado;
    // }
    // /*  LIKE "Lunes" AND `dc`.`periodo` = "2022-2"; */
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
    public function traercalendario($fecha_actual)
    {
        $sql_buscar = "SELECT * FROM `calendario` WHERE `fecha_inicio` LIKE '%$fecha_actual%'";
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
    //Implementar un método para listar los ingresos e los funcionarios
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
    //Implementar un método para listar las compras por semana
    public function mostrarfuncionariosporrango($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT DISTINCT id_usuario FROM ingresos_campus  WHERE fecha >= :fecha_inicial and fecha <= :fecha_final roll= 'Funcionario'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los ingresos e los funcionarios
    public function contaringresosfuncionarios($fecha_actual, $id_usuario)
    {
        $sql = "SELECT DISTINCT id_usuario FROM ingresos_campus WHERE fecha >= :fecha and roll= 'Funcionario' and `id_usuario` = :id_usuario";
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
    public function listarusuario($id_usuario)
    {
        $sql = "SELECT * FROM `usuario` WHERE `id_usuario` = :id_usuario";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los ingresos e los funcionarios
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
    //Implementar un método para listar los ingresos e los funcionarios
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
    //Implementar un método para listar los ingresos e los funcionarios
    public function mostrarfaltas($fecha_actual)
    {
        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `fecha_falta` >= :fecha_actual";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los ingresos e los funcionarios
    public function mostrarfaltasayer($fecha_actual)
    {
        $sql = "SELECT * FROM `estudiantes` inner join `credencial_estudiante` on `estudiantes`.`id_credencial` = `credencial_estudiante`.`id_credencial` inner join `faltas` on `estudiantes`.`id_estudiante` = `faltas`.`id_estudiante` inner join `docente` on `docente`.`id_usuario` = `faltas`.`id_docente` WHERE `fecha_falta` = :fecha_actual";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los ingresos e los funcionarios
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
    //Implementar un método para listar los ingresos e los funcionarios
    public function casoquedateultimasemana($fecha_actual)
    {
        $sql = "SELECT DISTINCT `credencial_nombre`,  `usuario`.`usuario_cargo`, `casos`.`updated_at` ,`credencial_nombre_2`,`credencial_apellido`,`credencial_apellido_2`,`caso_id`,`caso_asunto`,`credencial_estudiante`.`credencial_identificacion`  FROM `casos` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial` = `casos`.`id_estudiante` inner join `usuario` on `usuario`.`id_usuario` = `casos`.`area_id`  WHERE `created_at` >= :fecha_actual";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los ingresos e los funcionarios
    public function contactanos($fecha_actual)
    {
        $sql = "SELECT * FROM `ayuda` INNER JOIN `usuario` ON `usuario`.`id_usuario` = `ayuda`.`id_usuario` INNER JOIN `credencial_estudiante` ON `credencial_estudiante`.`id_credencial`= `ayuda`.`id_credencial` WHERE `fecha_solicitud` >= :fecha_actual";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_actual", $fecha_actual);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los casso de l quedate semana y mes actual
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
    //Implementar un método para listar los casso de l quedate semana y mes actual
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
    //Implementar un método para listar los casso de l quedate semana y mes actual
    public function actividades($fecha)
    {
        $sql = "SELECT * FROM pea_documentos WHERE fecha_actividad = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listarlas hojas de vida nuevas en plataforma
    public function usuariohojadevida($fecha)
    {
        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_usuario`.`id_usuario_cv` = `cv_informacion_personal`.`id_usuario_cv` INNER JOIN `cv_areas_de_conocimiento` ON `cv_usuario`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function perfilesactualizados($fecha)
    {
        $sql = "SELECT * FROM `usuario` INNER JOIN `ingresos_campus` ON `usuario`.id_usuario = `ingresos_campus`.`id_usuario` WHERE fecha_actualizacion >= :fecha";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las compras por semana
    public function listaringresosrangoperfiles($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT DISTINCT id_usuario FROM ingresos_campus  WHERE fecha >= :fecha_inicial and fecha <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        // $consulta->bindParam(":roll", $roll);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los perfiles actualizados del rango seleccionado
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
    //Implementar un método para listar los perfiles actualizados de la semana del estudiante
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
    public function hojadevidaayer($fecha)
    {
        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_usuario`.`id_usuario_cv` = `cv_informacion_personal`.`id_usuario_cv`  WHERE DATE_FORMAT(create_dt, '%Y-%m-%d')= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
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
    public function hojadevidamesareasdeconocimiento($fecha)
    {
        $sql = "SELECT * FROM `cv_areas_de_conocimiento` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d') >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function hojadevidaayerareasdeconocimiento($fecha)
    {
        $sql = "SELECT * FROM `cv_areas_de_conocimiento` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_areas_de_conocimiento`.`id_usuario_cv` WHERE DATE_FORMAT(create_dt, '%Y-%m-%d')= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
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
    public function listarDetallesCursoEc($id_curso)
    {
        $sql = "SELECT * FROM `web_educacion_continuada` WHERE `estado_educacion` = 1 AND `id_curso` = :id_curso";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_curso", $id_curso);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
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
    public function verificarInscritoEC($id_usuario, $roll, $id_curso)
    {
        $sql = "SELECT `estado_inscrito` FROM `educacion_continuada_inscritos` WHERE `id_credencial` = :id_usuario AND `roll` = :roll AND `id_curso` = :id_curso";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":roll", $roll);
        $consulta->bindParam(":id_curso", $id_curso);
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
    public function insertarInscritoEC($id_curso, $id_usuario, $roll, $periodo_actual)
    {
        $sql = "INSERT INTO `educacion_continuada_inscritos`(`id_inscrito`, `id_curso`, `id_credencial`, `roll`, `estado_inscrito`, `pago`, `periodo_actual`) VALUES(NULL, :id_curso, :id_usuario, :roll, 'inscrito', 0, :periodo_actual)";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":roll", $roll);
        $consulta->bindParam(":id_curso", $id_curso);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        return $consulta->execute();
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
    public function eliminarinscripcion($id)
    {
        $sql = "DELETE FROM `educacion_continuada_interesados` WHERE `id_edu_cont_in` = :id";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
        return $consulta->execute();
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
    public function listarcalendarioacademico()
    {
        global $mbd;
        $sql = "SELECT * FROM calendario";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
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
    // funcion para insertar las respuestas de Monitoriando Administrativos.
    // public function GuardarMonitoriandoAdministrativos($id_usuario,$p1,$p2){
    //     $sql = "INSERT INTO `monitoriando_administrativos`(`id_usuario`, `p1`, `p2`) VALUES(:id_usuario, :p1 , :p2);";
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":id_usuario",$id_usuario);
    //     $consulta->bindParam(":id_usuario",$id_usuario);
    //     $consulta->bindParam(":p1",$p1);
    //     $consulta->bindParam(":p2",$p2);
    //     if($consulta->execute()){
    //         return($mbd->lastInsertId());  
    //     }else{
    //         return FALSE;
    //     }     
    // }
    // Función para insertar las respuestas de Monitoriando Administrativos.
    public function GuardarMonitoriandoAdministrativos($id_usuario, $fecha,  $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15, $p16, $p17, $p18, $p19, $p20, $p21, $p22, $p23, $p24, $p25, $p26, $p27, $p28, $p29, $p30, $p31, $p32, $p33, $p34, $p35, $p36, $p37, $p38, $p39, $p40, $p41, $p42, $p43, $p44)
    {
        $sql = "INSERT INTO `monitoriando_administrativos`(`id_usuario` , `fecha` ,  `p1`, `p2`, `p3`, `p4`, `p5`, `p6`, `p7`, `p8`, `p9`, `p10`, `p11`, `p12`, `p13`, `p14`, `p15`, `p16`, `p17`, `p18`, `p19`, `p20`, `p21`, `p22`, `p23`, `p24`, `p25`, `p26`, `p27`, `p28`, `p29`, `p30`, `p31`, `p32`, `p33`, `p34`, `p35`, `p36`, `p37`, `p38`, `p39`, `p40`, `p41`, `p42`, `p43`, `p44`) 
            VALUES (:id_usuario , :fecha , :p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, :p11, :p12, :p13, :p14, :p15, :p16, :p17, :p18, :p19, :p20, :p21, :p22, :p23, :p24, :p25, :p26, :p27, :p28, :p29, :p30, :p31, :p32, :p33, :p34, :p35, :p36, :p37, :p38, :p39, :p40, :p41, :p42, :p43, :p44);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
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
        $consulta->bindParam(":p37", $p37);
        $consulta->bindParam(":p38", $p38);
        $consulta->bindParam(":p39", $p39);
        $consulta->bindParam(":p40", $p40);
        $consulta->bindParam(":p41", $p41);
        $consulta->bindParam(":p42", $p42);
        $consulta->bindParam(":p43", $p43);
        $consulta->bindParam(":p44", $p44);
        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }
    public function verificarRegistromonitoreandoadministrativo($id_usuario)
    {
        global $mbd;
        $sql = "SELECT * FROM `monitoriando_administrativos` WHERE `id_usuario` = :id_usuario ";
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function estadoModalMonitorando($id_usuario)
    {
        $sql = "SELECT * FROM `monitoriando_administrativos` WHERE  `id_usuario`= :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function usuarioSinFoto($id_usuario)
    {
        $sql = "SELECT usuario_imagen FROM usuario WHERE id_usuario = :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        // Retorna true si NO tiene foto
        return (empty($resultado['usuario_imagen']));
    }

    public function puntos()
    {
        $sql = "SELECT SUM(`puntos_cantidad`) AS total_puntos FROM `puntos`";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado['total_puntos'] ?? 0;
    }

    public function puntos_docente()
   {
        $sql = "SELECT SUM(`puntos_cantidad`) AS total_puntos FROM `puntos_docente`";
        global $mbd;
       $consulta = $mbd->prepare($sql);
        $consulta->execute();
       $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado['total_puntos'] ?? 0;
   }

   
     public function puntos_colaborador()
   {
        $sql = "SELECT SUM(`puntos_cantidad`) AS total_puntos FROM `puntos_colaboradores`";
        global $mbd;
       $consulta = $mbd->prepare($sql);
        $consulta->execute();
       $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado['total_puntos'] ?? 0;
   }
    
       //Implementar un método para listar los ingresos e los estudiantes
    public function ingresoDia($id_usuario, $fecha)
    {
        $sql = "SELECT * FROM ingresos_campus WHERE id_usuario = :id_usuario and fecha = :fecha and roll='Funcionario'";
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

		$sql=" SELECT * FROM puntos_colaboradores WHERE id_usuario= :id_usuario and punto_nombre= :evento and punto_fecha= :fecha";
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
		$sql="INSERT INTO puntos_colaboradores (`id_usuario`, `punto_nombre`, `puntos_cantidad`, `punto_fecha`, `punto_hora`, `punto_periodo`) VALUES ('$id_usuario','$punto_nombre','$puntos_cantidad','$punto_fecha','$punto_hora','$punto_periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

        //Implementar un método para ver los puntos del colaborador
	public function verpuntos($id_usuario){	
		$sql=" SELECT * FROM usuario WHERE id_usuario= :id_usuario";
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
		$sql="UPDATE usuario SET puntos= :puntos WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":puntos", $puntos);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}


}
