<?php
require "../config/Conexion.php";
class Registro{
    public function tipoSangre(){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `tipo_sangre` ");
        $sentencia->execute();
        $resgistro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resgistro);
    }
    public function grupoEtnico(){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `grupo_etnico` ");
        $sentencia->execute();
        $resgistro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resgistro);
    }
    public function nombreEtnico($id){
        $sql = "";
        if ($id == "Comunidad negra") {
            $sql = " SELECT * FROM `nombre_etnico` WHERE categoria = '1' ";
        }
        if ($id == "Pueblo indígena") {
            $sql = " SELECT * FROM `nombre_etnico` WHERE categoria = '0' ";
        }
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->execute();
        $resgistro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resgistro);
    }
    public function mostrarEscuela(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `escuelas`");
        $sentencia->execute();
        $resgistro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resgistro);
    }
    public function mostrarJornada(){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM jornada ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($registro);
    }
    public function mostrarprograma(){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM on_programa ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($registro);
    }
    public function agregar($tipo_documento, $identificacion, $expedido_en, $fecha_expedicion, $nombre, $nombre_2, $apellidos, $apellidos_2, $lugar_nacimiento, $fecha_nacimiento, $genero, $tipo_sangre, $eps, $fo_programa, $titulo_estudiante, $escuela_ciaf, $jornada_e, $periodo, $grupo_etnico, $nombre_etnico, $discapacidad, $nombre_discapacidad, $direccion, $barrio, $municipio, $telefono, $telefono2, $celular, $email, $nombre_colegio, $tipo_institucion, $jornada_institucion, $ano_terminacion, $ciudad_institucion, $fecha_presen_icfes, $codigo_icfes, $trabaja_actualmente, $cargo_en_empresa, $empresa_trabaja, $sector_empresa, $tel_empresa, $email_empresa, $segundo_idioma, $cual_idioma, $aficiones, $tiene_pc, $tiene_internet, $tiene_hijos, $estado_civil, $persona_emergencia, $direccion_emergencia, $email_emergencia, $tel_fijo_emergencia, $celular_emergencia){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `estudiantes_antes_2012`(`tipo_documento`, `identificacion`, `fo_programa`, `jornada_e`, `nombre`, `nombre_2`, `apellidos`, `apellidos_2`, `fecha_expedicion`, `expedido_en`, `genero`, `fecha_nacimiento`, `lugar_nacimiento`, `estado_civil`, `grupo_etnico`, `nombre_etnico`, `discapacidad`, `nombre_discapacidad`, `eps`, `direccion`, `barrio`, `municipio`,   `telefono`, `telefono2`, `celular`, `email`, `tipo_sangre`,`nombre_colegio`, `ano_terminacion`, `tipo_institucion`, `jornada_institucion`, `ciudad_institucion`, `codigo_icfes`, `fecha_presen_icfes`, `trabaja_actualmente`, `empresa_trabaja`, `sector_empresa`, `cargo_en_empresa`, `tel_empresa`, `email_empresa`, `segundo_idioma`, `cual_idioma`, `aficiones`, `tiene_pc`, `tiene_internet`, `tiene_hijos`, `persona_emergencia`, `direccion_emergencia`, `email_emergencia`,  `tel_fijo_emergencia`, `celular_emergencia`, `periodo`, `escuela_ciaf`, `titulo_estudiante`) VALUES (:tipo_documento, :identificacion,:fo_programa,:jornada_e ,:nombre, :nombre_2, :apellidos, :apellidos_2, :fecha_expedicion, :expedido_en, :genero, :fecha_nacimiento, :lugar_nacimiento, :estado_civil, :grupo_etnico, :nombre_etnico, :discapacidad, :nombre_discapacidad, :eps, :direccion, :barrio, :municipio,  :telefono, :telefono2, :celular, :email, :tipo_sangre, :nombre_colegio, :ano_terminacion, :tipo_institucion, :jornada_institucion, :ciudad_institucion, :codigo_icfes, :fecha_presen_icfes, :trabaja_actualmente, :empresa_trabaja, :sector_empresa, :cargo_en_empresa, :tel_empresa, :email_empresa, :segundo_idioma, :cual_idioma, :aficiones, :tiene_pc, :tiene_internet, :tiene_hijos, :persona_emergencia, :direccion_emergencia, :email_emergencia, :tel_fijo_emergencia, :celular_emergencia, :periodo, :escuela_ciaf, :titulo_estudiante)");
        $sentencia->bindParam(":tipo_documento", $tipo_documento);
        $sentencia->bindParam(":identificacion", $identificacion);
        $sentencia->bindParam(":fo_programa", $fo_programa);
        $sentencia->bindParam(":jornada_e", $jornada_e);
        $sentencia->bindParam(":nombre", $nombre);
        $sentencia->bindParam(":nombre_2", $nombre_2);
        $sentencia->bindParam(":apellidos", $apellidos);
        $sentencia->bindParam(":apellidos_2", $apellidos_2);
        $sentencia->bindParam(":fecha_expedicion", $fecha_expedicion);
        $sentencia->bindParam(":expedido_en", $expedido_en);
        $sentencia->bindParam(":genero", $genero);
        $sentencia->bindParam(":fecha_nacimiento", $fecha_nacimiento);
        $sentencia->bindParam(":lugar_nacimiento", $lugar_nacimiento);
        $sentencia->bindParam(":estado_civil", $estado_civil);
        $sentencia->bindParam(":grupo_etnico", $grupo_etnico);
        $sentencia->bindParam(":nombre_etnico", $nombre_etnico);
        $sentencia->bindParam(":discapacidad", $discapacidad);
        $sentencia->bindParam(":nombre_discapacidad", $nombre_discapacidad);
        $sentencia->bindParam(":eps", $eps);
        $sentencia->bindParam(":direccion", $direccion);
        $sentencia->bindParam(":barrio", $barrio);
        $sentencia->bindParam(":municipio", $municipio);
        $sentencia->bindParam(":telefono", $telefono);
        $sentencia->bindParam(":telefono2", $telefono2);
        $sentencia->bindParam(":celular", $celular);
        $sentencia->bindParam(":email", $email);
        $sentencia->bindParam(":tipo_sangre", $tipo_sangre);
        $sentencia->bindParam(":nombre_colegio", $nombre_colegio);
        $sentencia->bindParam(":ano_terminacion", $ano_terminacion);
        $sentencia->bindParam(":tipo_institucion", $tipo_institucion);
        $sentencia->bindParam(":jornada_institucion", $jornada_institucion);
        $sentencia->bindParam(":ciudad_institucion", $ciudad_institucion);
        $sentencia->bindParam(":codigo_icfes", $codigo_icfes);
        $sentencia->bindParam(":fecha_presen_icfes", $fecha_presen_icfes);
        $sentencia->bindParam(":trabaja_actualmente", $trabaja_actualmente);
        $sentencia->bindParam(":empresa_trabaja", $empresa_trabaja);
        $sentencia->bindParam(":sector_empresa", $sector_empresa);
        $sentencia->bindParam(":cargo_en_empresa", $cargo_en_empresa);
        $sentencia->bindParam(":tel_empresa", $tel_empresa);
        $sentencia->bindParam(":email_empresa", $email_empresa);
        $sentencia->bindParam(":segundo_idioma", $segundo_idioma);
        $sentencia->bindParam(":cual_idioma", $cual_idioma);
        $sentencia->bindParam(":aficiones", $aficiones);
        $sentencia->bindParam(":tiene_pc", $tiene_pc);
        $sentencia->bindParam(":tiene_internet", $tiene_internet);
        $sentencia->bindParam(":tiene_hijos", $tiene_hijos);
        $sentencia->bindParam(":persona_emergencia", $persona_emergencia);
        $sentencia->bindParam(":direccion_emergencia", $direccion_emergencia);
        $sentencia->bindParam(":email_emergencia", $email_emergencia);
        $sentencia->bindParam(":tel_fijo_emergencia", $tel_fijo_emergencia);
        $sentencia->bindParam(":celular_emergencia", $celular_emergencia);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":escuela_ciaf", $escuela_ciaf);
        $sentencia->bindParam(":titulo_estudiante", $titulo_estudiante);
        return $sentencia->execute();
    }
    public function editar($id_estudiante, $tipo_documento, $identificacion, $expedido_en, $fecha_expedicion, $nombre, $nombre_2, $apellidos, $apellidos_2, $lugar_nacimiento, $fecha_nacimiento, $genero, $tipo_sangre, $eps, $fo_programa, $titulo_estudiante, $escuela_ciaf, $jornada_e, $periodo, $grupo_etnico, $nombre_etnico, $discapacidad, $nombre_discapacidad, $direccion, $barrio, $municipio, $telefono, $telefono2, $celular, $email, $nombre_colegio, $tipo_institucion, $jornada_institucion, $ano_terminacion, $ciudad_institucion, $fecha_presen_icfes, $codigo_icfes, $trabaja_actualmente, $cargo_en_empresa, $empresa_trabaja, $sector_empresa, $tel_empresa, $email_empresa, $segundo_idioma, $cual_idioma, $aficiones, $tiene_pc, $tiene_internet, $tiene_hijos, $estado_civil, $persona_emergencia, $direccion_emergencia, $email_emergencia, $tel_fijo_emergencia, $celular_emergencia){
        $sql = "UPDATE `estudiantes_antes_2012` SET `tipo_documento` = :tipo_documento, `identificacion` = :identificacion,`fo_programa` = :fo_programa, `jornada_e` = :jornada_e, `nombre` = :nombre, `nombre_2` = :nombre_2, `apellidos` = :apellidos, `apellidos_2` = :apellidos_2, `fecha_expedicion` = :fecha_expedicion, `expedido_en` = :expedido_en, `genero` = :genero, `fecha_nacimiento` = :fecha_nacimiento, `lugar_nacimiento` = :lugar_nacimiento,`estado_civil` = :estado_civil,`grupo_etnico` = :grupo_etnico, `nombre_etnico` = :nombre_etnico, `discapacidad` = :discapacidad,`nombre_discapacidad` = :nombre_discapacidad, `eps` = :eps,`direccion` = :direccion, `barrio` = :barrio, `municipio` = :municipio, `telefono` = :telefono, `telefono2` = :telefono2, `celular` = :celular, `email` = :email, `tipo_sangre` = :tipo_sangre, `nombre_colegio` = :nombre_colegio, `ano_terminacion` = :ano_terminacion, `tipo_institucion` = :tipo_institucion, `jornada_institucion` = :jornada_institucion, `ciudad_institucion` = :ciudad_institucion,`codigo_icfes` = :codigo_icfes, `fecha_presen_icfes` = :fecha_presen_icfes, `trabaja_actualmente` = :trabaja_actualmente, `empresa_trabaja` = :empresa_trabaja, `sector_empresa` = :sector_empresa,`cargo_en_empresa` = :cargo_en_empresa, `tel_empresa` = :tel_empresa, `email_empresa` = :email_empresa, `segundo_idioma` = :segundo_idioma, `cual_idioma` = :cual_idioma, `aficiones` = :aficiones, `tiene_pc` = :tiene_pc,`tiene_internet` = :tiene_internet, `tiene_hijos` = :tiene_hijos, `persona_emergencia` = :persona_emergencia,`direccion_emergencia` = :direccion_emergencia, `email_emergencia` = :email_emergencia, `tel_fijo_emergencia` = :tel_fijo_emergencia,`celular_emergencia` = :celular_emergencia, `periodo` = :periodo, `escuela_ciaf` = :escuela_ciaf, `titulo_estudiante` = :titulo_estudiante WHERE `id_estudiante` = :id_estudiante";
        //ejecutarConsulta($sql);
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->bindParam(":tipo_documento", $tipo_documento);
        $consulta->bindParam(":identificacion", $identificacion);
        $consulta->bindParam(":fo_programa", $fo_programa);
        $consulta->bindParam(":jornada_e", $jornada_e);
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":nombre_2", $nombre_2);
        $consulta->bindParam(":apellidos", $apellidos);
        $consulta->bindParam(":apellidos_2", $apellidos_2);
        $consulta->bindParam(":fecha_expedicion", $fecha_expedicion);
        $consulta->bindParam(":expedido_en", $expedido_en);
        $consulta->bindParam(":genero", $genero);
        $consulta->bindParam(":fecha_nacimiento", $fecha_nacimiento);
        $consulta->bindParam(":lugar_nacimiento", $lugar_nacimiento);
        $consulta->bindParam(":estado_civil", $estado_civil);
        $consulta->bindParam(":grupo_etnico", $grupo_etnico);
        $consulta->bindParam(":nombre_etnico", $nombre_etnico);
        $consulta->bindParam(":discapacidad", $discapacidad);
        $consulta->bindParam(":nombre_discapacidad", $nombre_discapacidad);
        $consulta->bindParam(":eps", $eps);
        $consulta->bindParam(":direccion", $direccion);
        $consulta->bindParam(":barrio", $barrio);
        $consulta->bindParam(":municipio", $municipio);
        $consulta->bindParam(":telefono", $telefono);
        $consulta->bindParam(":telefono2", $telefono2);
        $consulta->bindParam(":celular", $celular);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":tipo_sangre", $tipo_sangre);
        $consulta->bindParam(":nombre_colegio", $nombre_colegio);
        $consulta->bindParam(":ano_terminacion", $ano_terminacion);
        $consulta->bindParam(":tipo_institucion", $tipo_institucion);
        $consulta->bindParam(":jornada_institucion", $jornada_institucion);
        $consulta->bindParam(":ciudad_institucion", $ciudad_institucion);
        $consulta->bindParam(":codigo_icfes", $codigo_icfes);
        $consulta->bindParam(":fecha_presen_icfes", $fecha_presen_icfes);
        $consulta->bindParam(":trabaja_actualmente", $trabaja_actualmente);
        $consulta->bindParam(":empresa_trabaja", $empresa_trabaja);
        $consulta->bindParam(":sector_empresa", $sector_empresa);
        $consulta->bindParam(":cargo_en_empresa", $cargo_en_empresa);
        $consulta->bindParam(":tel_empresa", $tel_empresa);
        $consulta->bindParam(":email_empresa", $email_empresa);
        $consulta->bindParam(":segundo_idioma", $segundo_idioma);
        $consulta->bindParam(":cual_idioma", $cual_idioma);
        $consulta->bindParam(":aficiones", $aficiones);
        $consulta->bindParam(":tiene_pc", $tiene_pc);
        $consulta->bindParam(":tiene_internet", $tiene_internet);
        $consulta->bindParam(":tiene_hijos", $tiene_hijos);
        $consulta->bindParam(":persona_emergencia", $persona_emergencia);
        $consulta->bindParam(":direccion_emergencia", $direccion_emergencia);
        $consulta->bindParam(":email_emergencia", $email_emergencia);
        $consulta->bindParam(":tel_fijo_emergencia", $tel_fijo_emergencia);
        $consulta->bindParam(":celular_emergencia", $celular_emergencia);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":escuela_ciaf", $escuela_ciaf);
        $consulta->bindParam(":titulo_estudiante", $titulo_estudiante);
        return $consulta->execute();
    }
    public function listar(){
        $sql = "SELECT *, `e`.`identificacion` AS `numero_documento`, `e`.`periodo` AS `periodo_estudiante`, `es`.`titulo` AS `titulo_acta`  FROM `estudiantes_antes_2012` `e` LEFT JOIN `estado_estudiantes_antes_2012` `es` ON `e`.`id_estudiante` = `es`.`id_estudiante_acta` ORDER BY `e`.`id_estudiante` DESC";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function mostrar($id_estudiante){
        $sql = "SELECT * FROM estudiantes_antes_2012 WHERE id_estudiante= :id_estudiante";
        //return ejecutarConsultaSimpleFila($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function InsertarActa($id_estudiante_acta, $titulo, $identificacion, $estado_est, $numero_acta, $folio, $ano_graduacion, $periodo, $libro){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `estado_estudiantes_antes_2012`(`id_estudiante_acta`, `titulo`, `identificacion`, `estado`, `numero_acta`, `folio`, `ano_graduacion`, `periodo`, `libro`) VALUES (:id_estudiante_acta, :titulo, :identificacion, :estado_est, :numero_acta, :folio, :ano_graduacion,  :periodo, :libro);");
        $sentencia->bindParam(":id_estudiante_acta", $id_estudiante_acta);
        $sentencia->bindParam(":titulo", $titulo);
        $sentencia->bindParam(":identificacion", $identificacion);
        $sentencia->bindParam(":estado_est", $estado_est);
        $sentencia->bindParam(":numero_acta", $numero_acta);
        $sentencia->bindParam(":folio", $folio);
        $sentencia->bindParam(":ano_graduacion", $ano_graduacion);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":libro", $libro);
        return $sentencia->execute();
    }
    public function EditarActa($id_so, $id_estudiante_acta, $titulo, $estado_est, $numero_acta, $folio, $ano_graduacion, $periodo, $libro){
        $sql = "UPDATE `estado_estudiantes_antes_2012` SET `id_estudiante_acta` = :id_estudiante_acta, `titulo` = :titulo, `estado` = :estado_est, `numero_acta` = :numero_acta, `folio` = :folio, `ano_graduacion` = :ano_graduacion, `periodo` = :periodo, `libro` = :libro WHERE `id_so` = :id_so";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":titulo", $titulo);
        $consulta->bindParam(":id_estudiante_acta", $id_estudiante_acta);
        $consulta->bindParam(":estado_est", $estado_est);
        $consulta->bindParam(":numero_acta", $numero_acta);
        $consulta->bindParam(":folio", $folio);
        $consulta->bindParam(":ano_graduacion", $ano_graduacion);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":libro", $libro);
        $consulta->bindParam(":id_so", $id_so);
        return $consulta->execute();
    }
    public function mostrar_datos_acta($id_estudiante_acta){
        $sql = "SELECT * FROM estado_estudiantes_antes_2012 WHERE id_estudiante_acta = :id_estudiante_acta ORDER BY `estado_estudiantes_antes_2012`.`id_so` DESC LIMIT 1";
        //return ejecutarConsultaSimpleFila($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante_acta", $id_estudiante_acta);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function listar_materias($identificacion){
        $sql = "SELECT `identificacion`,`nombre_materia`,`estado`,`jornada`,`periodo`,`semestre`,`nota` FROM `materias_antes_2012` WHERE identificacion= :identificacion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":identificacion", $identificacion);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function aggMaterias($cc, $programa, $materia, $creditos, $semestre, $nota, $periodo, $jornada){
        global $mbd;
        $sentencia = $mbd->prepare(" INSERT INTO `materias_antes_2012`(`identificacion`, `nombre_materia`,  `estado`, `jornada`, `periodo`, `semestre`, `nota`, `creditos`, `programa`, `escuela`) VALUES ('$cc', '$materia', 'Registrado', '$jornada', '$periodo', '$semestre', $nota, '$creditos', '$programa', 'CIAF') ");
        return $sentencia->execute();
    }
    public function eliminar($id_estudiante){
        global $mbd;
            $sql1 = "DELETE FROM `estudiantes_antes_2012` WHERE `id_estudiante` = :id_estudiante; 
                     DELETE FROM `estado_estudiantes_antes_2012` WHERE `id_estudiante_acta` = :id_estudiante";
            $consulta1 = $mbd->prepare($sql1);
            $consulta1->bindParam(":id_estudiante", $id_estudiante);
            return $consulta1->execute();
            
    }

    public function EditarEstadoFallecido($identificacion, $estado_fallecido) {
        global $mbd;  
        $sql = "UPDATE estudiantes_antes_2012 SET estado_fallecido = :estado_fallecido WHERE identificacion = :identificacion";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':estado_fallecido', $estado_fallecido);
        $stmt->bindParam(':identificacion', $identificacion);
        return $stmt->execute();
    }

    



}
