<?php

require "../config/Conexion.php";
date_default_timezone_set('America/Bogota');
class HvFunInformacionPersonal
{
    public function __construct() {}
    // traemos el id_cvadministrativos del usuario por medio del documento
    public function cv_traerIdUsuario($documento)
    {
        $sql = "SELECT `id_cvadministrativos`,`porcentaje_avance` FROM `cvadministrativos` WHERE `cvadministrativos_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //editamos los datos del usuario 
    public function cv_editar($id_cvadministrativos, $fecha_nacimiento, $estado_civil, $departamento, $ciudad, $direccion, $celular, $nacionalidad, $pagina_web, $titulo_profesional, $categoria_profesion, $situacion_laboral, $resumen_perfil, $experiencia_docente, $hv_fun_id_informacion_personal, $nombre_emergencia, $parentesco, $numero_telefonico_emergencia, $genero, $genero_otro, $tipo_vivienda, $estrato, $hijos_menores_10, $numero_hijos, $personas_a_cargo, $nivel_escolaridad)
    {
        $actualizacion = date("Y-m-d H:i:s");
        $sql = "UPDATE `hv_fun_informacion_personal` SET  `id_cvadministrativos` = :id_cvadministrativos, `estado_civil` = :estado_civil, `fecha_nacimiento` = :fecha_nacimiento, `departamento` = :departamento, `ciudad` = :ciudad, `direccion` = :direccion, `telefono` = :celular, `nacionalidad` = :nacionalidad, `pagina_web` = :pagina_web, `titulo_profesional` = :titulo_profesional, `categoria_profesion` = :categoria_profesion, `situacion_laboral` = :situacion_laboral, `perfil_descripcion` = :resumen_perfil, `experiencia_docente` = :experiencia_docente, `ultima_actualizacion` = :actualizacion, `nombre_emergencia` = :nombre_emergencia, `parentesco` = :parentesco, `numero_telefonico_emergencia` = :numero_telefonico_emergencia, `genero` = :genero, `genero_otro` = :genero_otro, `tipo_vivienda` = :tipo_vivienda, `estrato` = :estrato, `hijos_menores_10` = :hijos_menores_10, `numero_hijos` = :numero_hijos, `personas_a_cargo` = :personas_a_cargo, `nivel_escolaridad` = :nivel_escolaridad WHERE `hv_fun_id_informacion_personal` = :hv_fun_id_informacion_personal";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":fecha_nacimiento", $fecha_nacimiento);
        $consulta->bindParam(":estado_civil", $estado_civil);
        $consulta->bindParam(":departamento", $departamento);
        $consulta->bindParam(":ciudad", $ciudad);
        $consulta->bindParam(":direccion", $direccion);
        $consulta->bindParam(":celular", $celular);
        $consulta->bindParam(":nacionalidad", $nacionalidad);
        $consulta->bindParam(":pagina_web", $pagina_web);
        $consulta->bindParam(":titulo_profesional", $titulo_profesional);
        $consulta->bindParam(":categoria_profesion", $categoria_profesion);
        $consulta->bindParam(":situacion_laboral", $situacion_laboral);
        $consulta->bindParam(":resumen_perfil", $resumen_perfil);
        $consulta->bindParam(":experiencia_docente", $experiencia_docente);
        $consulta->bindParam(":actualizacion", $actualizacion);
        $consulta->bindParam(":nombre_emergencia", $nombre_emergencia);
        $consulta->bindParam(":parentesco", $parentesco);
        $consulta->bindParam(":numero_telefonico_emergencia", $numero_telefonico_emergencia);
        $consulta->bindParam(":genero", $genero);
        $consulta->bindParam(":genero_otro", $genero_otro);
        $consulta->bindParam(":tipo_vivienda", $tipo_vivienda);
        $consulta->bindParam(":estrato", $estrato);
        $consulta->bindParam(":hijos_menores_10", $hijos_menores_10);
        $consulta->bindParam(":numero_hijos", $numero_hijos);
        $consulta->bindParam(":personas_a_cargo", $personas_a_cargo);
        $consulta->bindParam(":nivel_escolaridad", $nivel_escolaridad);
        $consulta->bindParam(":hv_fun_id_informacion_personal", $hv_fun_id_informacion_personal);

        return ($consulta->execute());
    }

    public function cv_insertar($id_cvadministrativos, $fecha_nacimiento, $estado_civil, $departamento, $ciudad, $direccion, $celular, $nacionalidad, $pagina_web, $titulo_profesional, $categoria_profesion, $situacion_laboral, $resumen_perfil, $experiencia_docente, $nombre_emergencia, $parentesco, $numero_telefonico_emergencia, $genero, $genero_otro, $tipo_vivienda, $estrato, $hijos_menores_10, $numero_hijos, $personas_a_cargo, $nivel_escolaridad)
    {
        $actualizacion = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `hv_fun_informacion_personal`(`id_cvadministrativos`,`estado_civil`,`fecha_nacimiento`,`departamento`,`ciudad`,`direccion`,`telefono`,`nacionalidad`,`pagina_web`,`titulo_profesional`,`categoria_profesion`,`situacion_laboral`,`perfil_descripcion`,`experiencia_docente`,`ultima_actualizacion`,`nombre_emergencia`,`parentesco`,`numero_telefonico_emergencia`,`genero`,`genero_otro`,`tipo_vivienda`,`estrato`,`hijos_menores_10`,`numero_hijos`,`personas_a_cargo`,`nivel_escolaridad`) VALUES ( :id_cvadministrativos, :estado_civil, :fecha_nacimiento, :departamento, :ciudad, :direccion, :celular, :nacionalidad, :pagina_web, :titulo_profesional, :categoria_profesion, :situacion_laboral, :resumen_perfil, :experiencia_docente, :actualizacion, :nombre_emergencia, :parentesco, :numero_telefonico_emergencia, :genero, :genero_otro, :tipo_vivienda, :estrato, :hijos_menores_10, :numero_hijos, :personas_a_cargo, :nivel_escolaridad)";
        //  echo json_encode("INSERT INTO `hv_fun_informacion_personal`(`id_cvadministrativos`,`estado_civil`,`fecha_nacimiento`,`departamento`,`ciudad`,`direccion`,`telefono`,`nacionalidad`,`pagina_web`,`titulo_profesional`,`categoria_profesion`,`situacion_laboral`,`perfil_descripcion`,`experiencia_docente`,`ultima_actualizacion`,`nombre_emergencia`,`parentesco`,`numero_telefonico_emergencia`,`genero`,`genero_otro`,`tipo_vivienda`,`estrato`,`hijos_menores_10`,`numero_hijos`,`personas_a_cargo`,`nivel_escolaridad`) VALUES ( '$id_cvadministrativos', '$estado_civil', '$fecha_nacimiento', '$departamento', '$ciudad', '$direccion', '$celular', '$nacionalidad', '$pagina_web', '$titulo_profesional', '$categoria_profesion', '$situacion_laboral', '$resumen_perfil', '$experiencia_docente', '$actualizacion', '$nombre_emergencia', '$parentesco', '$numero_telefonico_emergencia', '$genero', '$genero_otro', '$tipo_vivienda', '$estrato', '$hijos_menores_10', '$numero_hijos', '$personas_a_cargo', '$nivel_escolaridad')");

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":fecha_nacimiento", $fecha_nacimiento);
        $consulta->bindParam(":estado_civil", $estado_civil);
        $consulta->bindParam(":departamento", $departamento);
        $consulta->bindParam(":ciudad", $ciudad);
        $consulta->bindParam(":direccion", $direccion);
        $consulta->bindParam(":celular", $celular);
        $consulta->bindParam(":nacionalidad", $nacionalidad);
        $consulta->bindParam(":pagina_web", $pagina_web);
        $consulta->bindParam(":titulo_profesional", $titulo_profesional);
        $consulta->bindParam(":categoria_profesion", $categoria_profesion);
        $consulta->bindParam(":situacion_laboral", $situacion_laboral);
        $consulta->bindParam(":resumen_perfil", $resumen_perfil);
        $consulta->bindParam(":experiencia_docente", $experiencia_docente);
        $consulta->bindParam(":actualizacion", $actualizacion);
        $consulta->bindParam(":nombre_emergencia", $nombre_emergencia);
        $consulta->bindParam(":parentesco", $parentesco);
        $consulta->bindParam(":numero_telefonico_emergencia", $numero_telefonico_emergencia);
        $consulta->bindParam(":genero", $genero);
        $consulta->bindParam(":genero_otro", $genero_otro);
        $consulta->bindParam(":tipo_vivienda", $tipo_vivienda);
        $consulta->bindParam(":estrato", $estrato);
        $consulta->bindParam(":hijos_menores_10", $hijos_menores_10);
        $consulta->bindParam(":numero_hijos", $numero_hijos);
        $consulta->bindParam(":personas_a_cargo", $personas_a_cargo);
        $consulta->bindParam(":nivel_escolaridad", $nivel_escolaridad);
        return ($consulta->execute());
    }



    //experiencia_laboral
    public function cv_insertarExperiencia($id_cvadministrativos, $nombre_empresa, $cargo_empresa, $desde_cuando, $hasta_cuando, $mas_detalles, $imagen, $estado_trabajo_actual)
    {
        $sql = "INSERT INTO `hv_fun_experiencia_laboral`(`id_cvadministrativos`, `nombre_empresa`, `cargo_empresa`, `desde_cuando`, `hasta_cuando`, `mas_detalles`, `estado_trabajo_actual`) VALUES(:id_cvadministrativos, :nombre_empresa, :cargo_empresa, :desde_cuando, :hasta_cuando, :mas_detalles, :estado_trabajo_actual);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":nombre_empresa", $nombre_empresa);
        $consulta->bindParam(":cargo_empresa", $cargo_empresa);
        $consulta->bindParam(":desde_cuando", $desde_cuando);
        $consulta->bindParam(":hasta_cuando", $hasta_cuando);
        $consulta->bindParam(":mas_detalles", $mas_detalles);
        $consulta->bindParam(":estado_trabajo_actual", $estado_trabajo_actual);
        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }
    public function cveditarExperiencia($id_cvadministrativos, $nombre_empresa, $cargo_empresa, $desde_cuando, $hasta_cuando, $mas_detalles, $id_experiencia, $imagen, $estado_trabajo_actual)
    {
        $sql = "UPDATE `hv_fun_experiencia_laboral` SET `id_cvadministrativos`=:id_cvadministrativos, `nombre_empresa`=:nombre_empresa, `cargo_empresa`=:cargo_empresa, `desde_cuando`= :desde_cuando, `hasta_cuando`=:hasta_cuando, `mas_detalles`=:mas_detalles, `estado_trabajo_actual`=:estado_trabajo_actual WHERE `id_experiencia` =  :id_experiencia";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":id_experiencia", $id_experiencia);
        $consulta->bindParam(":nombre_empresa", $nombre_empresa);
        $consulta->bindParam(":cargo_empresa", $cargo_empresa);
        $consulta->bindParam(":desde_cuando", $desde_cuando);
        $consulta->bindParam(":hasta_cuando", $hasta_cuando);
        $consulta->bindParam(":mas_detalles", $mas_detalles);
        $consulta->bindParam(":estado_trabajo_actual", $estado_trabajo_actual);
        return ($consulta->execute());
    }


    public function getInfoUser($id_cvadministrativos)
    {
        global $mbd;
        $sql = "SELECT * FROM cvadministrativos LEFT JOIN hv_fun_informacion_personal  ON cvadministrativos.id_cvadministrativos = hv_fun_informacion_personal.id_cvadministrativos WHERE cvadministrativos.id_cvadministrativos = :id_cvadministrativos";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }

    public function getInfoHoja($id_cvadministrativos)
    {
        $sql = "SELECT * FROM `hv_fun_informacion_personal` INNER JOIN `cvadministrativos` ON `cvadministrativos`.`id_cvadministrativos` = `hv_fun_informacion_personal`.`id_cvadministrativos`  WHERE `cvadministrativos`.`cvadministrativos_identificacion` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }
    public function editarImagen($id_cvadministrativos, $usuario_imagen)
    {
        $sql = "UPDATE `cvadministrativos` SET `usuario_imagen` = :usuario_imagen WHERE `id_cvadministrativos` = :id_cvadministrativos";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":usuario_imagen", $usuario_imagen);
        $consulta->execute();
        return $consulta;
    }
    public function editarUser($nombres, $apellidos, $id_cvadministrativos)
    {
        $sql = "UPDATE `cvadministrativos` SET `cvadministrativos_nombre` = :nombres, `usuario_apellido` = :apellidos WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":nombres", $nombres);
        $consulta->bindParam(":apellidos", $apellidos);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }
    public function get_all_states()
    {
        global $mbd;
        $sql = "SELECT * FROM departamentos";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;
    }
    public function get_municipio($id_municipio)
    {
        global $mbd;
        $sql = "SELECT municipio FROM municipios WHERE id_municipio = :id_municipio";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_municipio", $id_municipio);
        $consulta->execute();
        return $consulta;
    }
    public function get_departamento($id_departamento)
    {
        global $mbd;
        $sql = "SELECT departamento FROM departamentos WHERE id_departamento = :id_departamento";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_departamento", $id_departamento);
        $consulta->execute();
        return $consulta;
    }
    public function cv_get_cities_for_state($departamento)
    {
        global $mbd;
        $sql = "SELECT id_municipio, municipio FROM municipios WHERE departamento_id = :departamento";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":departamento", $departamento);
        $consulta->execute();
        return $consulta;
    }
    public function getAllCategories()
    {
        global $mbd;
        $sql = "SELECT * FROM cv_categoria_profesion";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;
    }

    public function cv_listarExperiencias($id_cvadministrativos)
    {
        $sql = "SELECT * FROM `hv_fun_experiencia_laboral` WHERE id_cvadministrativos = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }
    public function cv_listarExperienciaEspecifica($id_experiencia)
    {
        $sql = "SELECT * FROM `hv_fun_experiencia_laboral` WHERE `id_experiencia` = :id_experiencia";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_experiencia", $id_experiencia);
        $consulta->execute();
        return $consulta;
    }

    public function cv_eliminarExperiencia($id_experiencia)
    {
        $sql = "DELETE FROM `hv_fun_experiencia_laboral` WHERE `id_experiencia` = :id_experiencia";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_experiencia", $id_experiencia);
        $consulta->execute();
        return $consulta;
    }

    public function cv1_insertarEducacion($id_cvadministrativos, $institucion_academica, $titulo_obtenido, $desde_cuando_f, $hasta_cuando_f, $mas_detalles_f, $imagen)
    {

        $sql = "INSERT INTO `hv_fun_educacion_formacion`(`id_cvadministrativos`, `institucion_academica`, `titulo_obtenido`, `desde_cuando_f`, `hasta_cuando_f`, `mas_detalles_f`) VALUES(:id_cvadministrativos, :institucion_academica, :titulo_obtenido, :desde_cuando_f, :hasta_cuando_f, :mas_detalles_f);";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":institucion_academica", $institucion_academica);
        $consulta->bindParam(":titulo_obtenido", $titulo_obtenido);
        $consulta->bindParam(":desde_cuando_f", $desde_cuando_f);
        $consulta->bindParam(":hasta_cuando_f", $hasta_cuando_f);
        $consulta->bindParam(":mas_detalles_f", $mas_detalles_f);
        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }

    public function CuentoRegistros($id_cvadministrativos)
    {
        $sql = "SELECT COUNT(*) as total FROM hv_fun_experiencia_laboral WHERE id_cvadministrativos = :id_cvadministrativos";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id_cvadministrativos', $id_cvadministrativos);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }


    public function actualizar_porcentaje_personal($porcentaje_avance, $id_cvadministrativos)
    {
        $sql = "UPDATE `cvadministrativos` SET `porcentaje_avance` = :porcentaje_avance WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":porcentaje_avance", $porcentaje_avance);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }
    public function CuentoRegistrosDatosPersonales($id_cvadministrativos)
    {
        $sql = "SELECT COUNT(*) as total FROM cvadministrativos WHERE id_cvadministrativos = :id_cvadministrativos";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id_cvadministrativos', $id_cvadministrativos);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function obtener_porcentaje_actual($id_cvadministrativos)
    {
        global $mbd;
        $sql = "SELECT porcentaje_avance FROM cvadministrativos WHERE id_cvadministrativos = :id";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id', $id_cvadministrativos);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return isset($registro['porcentaje_avance']) ? $registro['porcentaje_avance'] : 0;  // Devuelve el porcentaje actualizado
    }


    public function cv_listarEducacionFormacion($id_formacion)
    {
        $sql = "SELECT * FROM `hv_fun_educacion_formacion` WHERE `id_formacion` = :id_formacion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_formacion", $id_formacion);
        $consulta->execute();
        return $consulta;
    }
    // actualizamos el estado de la experiencia docente.
    public function editarEstadoExperienciaDocente($id_cvadministrativos, $experiencia_docente)
    {
        $sql = "UPDATE `hv_fun_informacion_personal` SET `experiencia_docente` = :experiencia_docente WHERE `id_cvadministrativos` = :id_cvadministrativos";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":experiencia_docente", $experiencia_docente);
        $consulta->execute();
        return $consulta;
    }
    public function editarEstadoPoliticamenteExpuesto($id_cvadministrativos, $politicamente_expuesta)
    {
        $sql = "UPDATE `hv_fun_informacion_personal` SET `politicamente_expuesta` = :politicamente_expuesta WHERE `id_cvadministrativos` = :id_cvadministrativos";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":politicamente_expuesta", $politicamente_expuesta);
        $consulta->execute();
        return $consulta;
    }


    public function editarCertificadoLabral($id_experiencia, $nombre_img)
    {
        $sql = "UPDATE `hv_fun_experiencia_laboral` SET `certificado_laboral` = :nombre_img WHERE `id_experiencia` = :id_experiencia";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_experiencia", $id_experiencia);
        $consulta->bindParam(":nombre_img", $nombre_img);
        $consulta->execute();
        return $consulta;
    }




    // public function editarCertificadoLabral($id_experiencia, $nombre_img)
    // {
    //     $sql = "UPDATE `hv_fun_experiencia_laboral` SET `certificado_laboral` = :nombre_img WHERE `id_experiencia` = :id_experiencia ";
    //     // echo  $sql;
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":id_experiencia ", $id_experiencia);
    //     $consulta->bindParam(":certificado_laboral", $nombre_img);
    //     $consulta->execute();
    //     return $consulta;
    // }
}
