<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class AbrirReporteInfluencer
{
    public function consultaEstudiante($dato_busqueda)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM credencial_estudiante INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial WHERE credencial_estudiante.credencial_identificacion = :dato_busqueda ");
        $sentencia->bindParam(":dato_busqueda", $dato_busqueda);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }

    public function consultaCasos($dato_busqueda, $id_usuario)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `influencer_reporte` `ir` INNER JOIN `estudiantes` `e` ON `e`.`id_estudiante` = `ir`.`id_estudiante` INNER JOIN `credencial_estudiante` `ce` ON `ce`.`id_credencial` = `e`.`id_credencial`  WHERE `ir`.`id_usuario` = :id_usuario AND `ce`.`credencial_identificacion` = :dato_busqueda ORDER BY `e`.`id_programa_ac` ASC");
        $sentencia->bindParam(":dato_busqueda", $dato_busqueda);
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }

    public function consultaProgramas($id_credencial)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial ORDER BY `estudiantes`.`id_programa_ac` ASC ");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function GuardarCaso($id_credencial, $asunto, $caterogia_caso, $id_usuario, $fecha)
    {
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `casos`(`caso_asunto`, `categoria_caso`, `id_estudiante`, `area_id`,`created_at`) VALUES(:asunto, :categoria, :id_credencial, :id_usuario,:fecha)");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->bindParam(":asunto", $asunto);
        $sentencia->bindParam(":categoria", $caterogia_caso);
        $sentencia->bindParam(":fecha", $fecha);
        return $sentencia->execute();
    }

    public function mostrarPeriodo()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `periodo` ORDER BY `periodo`.`periodo` DESC ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($registro);
    }

    public function listarCategorias()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `categoria_casos`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function consulta_casos($id)
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `casos` WHERE caso_id = $id AND area_id = $id_user ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function consulta_remisiones($id)
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `remisiones` WHERE caso_id = $id AND remision_para = $id_user ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
    //Implementar un método para traer los dartos de la tabla usuario
    public function traerDatosDirector($id_usuario)
    {
        $sql = "SELECT id_usuario,usuario_login FROM usuario WHERE id_usuario= :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para mirar datos del estudiante
    public function estudianteDatos($id_estudiante)
    {
        global $mbd;
        $sql2 = " SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_estudiante = :id_estudiante";
        $consulta2 = $mbd->prepare($sql2);
        $consulta2->bindParam(":id_estudiante", $id_estudiante);
        $consulta2->execute();
        $resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
        return $resultado2;
    }
    public function insertarreporteinfluencer($id_estudiante, $id_usuario, $id_programa, $id_materia, $influencer_mensaje, $fecha, $hora, $periodo, $influencer_nivel_accion, $influencer_dimension)
    {
        global $mbd;
        $sql = "INSERT INTO `influencer_reporte`(`id_estudiante`, `id_usuario`, `id_programa`, `id_materia`, `influencer_mensaje`, `fecha`, `hora`, `periodo`, `influencer_nivel_accion`, `influencer_dimension` ) VALUES('$id_estudiante','$id_usuario','$id_programa','$id_materia','$influencer_mensaje','$fecha','$hora','$periodo', '$influencer_nivel_accion', '$influencer_dimension')";
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }
    function mostrarInfoReporte($id_influencer_reporte)
    {
        global $mbd;
        $sql = "SELECT CONCAT(`u`.`usuario_nombre`, ' ' ,`u`.`usuario_apellido`) AS `docente_nombre`, `ce`.`credencial_identificacion`, CONCAT(`ce`.`credencial_nombre`, ' ', `ce`.`credencial_nombre_2`, ' ', `ce`.`credencial_apellido`, ' ', `ce`.`credencial_apellido_2`) AS nombre_estudiante, `ce`.`credencial_login`, `e`.`fo_programa`, `ir`.`influencer_nivel_accion`, `ir`.`influencer_mensaje`, `ir`.`fecha`, `ir`.`hora`, `ir`.`id_influencer_reporte` , `ir`.`reporte_estado`
		FROM `influencer_reporte` `ir`
		INNER JOIN `estudiantes` `e` ON `ir`.`id_estudiante` = `e`.`id_estudiante`
		INNER JOIN `credencial_estudiante` `ce` ON `e`.`id_credencial` = `ce`.`id_credencial`
		INNER JOIN `usuario` `u` ON `ir`.`id_usuario` = `u`.`id_usuario`
		WHERE `ir`.`id_influencer_reporte` = :id_influencer_reporte";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_influencer_reporte", $id_influencer_reporte);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Funcion para mostrar las fechas con letras
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
    function respuestasReporteInfluencer($id_influencer_reporte)
    {
        global $mbd;
        $sql = "SELECT `u`.`id_usuario`, `ir`.`id_influencer_respuesta`, `u`.`usuario_nombre`, `u`.`usuario_apellido`, `ir`.`mensaje_respuesta`, `ir`.`created_dt` 
		FROM `influencer_respuesta` `ir` INNER JOIN `usuario` `u` ON `ir`.`id_usuario` = `u`.`id_usuario`
		WHERE `ir`.`id_influencer_reporte` = :id_influencer_reporte ORDER BY `ir`.`created_dt` ASC";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_influencer_reporte", $id_influencer_reporte);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    function cerrarReporteInfluencer($influencer_tipo_cierre, $influencer_reflexion, $influencer_acciones, $influencer_resultado_final, $influencer_comentario_final, $id_influencer_reporte)
    {
        global $mbd;
        $sql = "UPDATE influencer_reporte SET `influencer_tipo_cierre` = :influencer_tipo_cierre, `influencer_reflexion` = :influencer_reflexion, `influencer_acciones` = :influencer_acciones, `influencer_resultado_final` = :influencer_resultado_final, `influencer_comentario_final` = :influencer_comentario_final, `reporte_estado` = 0
        WHERE `id_influencer_reporte` = :id_influencer_reporte";
        $stmt = $mbd->prepare($sql);
        // Asignar parámetros
        $stmt->bindParam(':influencer_tipo_cierre', $influencer_tipo_cierre, PDO::PARAM_STR);
        $stmt->bindParam(':influencer_reflexion', $influencer_reflexion, PDO::PARAM_STR);
        $stmt->bindParam(':influencer_acciones', $influencer_acciones, PDO::PARAM_STR);
        $stmt->bindParam(':influencer_resultado_final', $influencer_resultado_final, PDO::PARAM_STR);
        $stmt->bindParam(':influencer_comentario_final', $influencer_comentario_final, PDO::PARAM_STR);
        $stmt->bindParam(':id_influencer_reporte', $id_influencer_reporte, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
