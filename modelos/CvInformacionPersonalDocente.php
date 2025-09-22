<?php

require "../config/Conexion.php";
date_default_timezone_set('America/Bogota');
class CvInformacionPersonalDocente{
	public function __construct(){
	}
    public function cv_insertar($id_usuario_cv, $fecha_nacimiento, $estado_civil, $departamento, $ciudad, $direccion, $celular, $nacionalidad, $pagina_web, $titulo_profesional, $categoria_profesion, $situacion_laboral, $resumen_perfil, $experiencia_docente){
        $actualizacion = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `cv_informacion_personal`(`id_usuario_cv`, `estado_civil`, `fecha_nacimiento`, `departamento`, `ciudad`, `direccion`, `telefono`, `nacionalidad`, `pagina_web`, `titulo_profesional`, `categoria_profesion`, `situacion_laboral`, `perfil_descripcion`, `experiencia_docente`, `ultima_actualizacion`) VALUES (:id_usuario_cv, :estado_civil, :fecha_nacimiento, :departamento, :ciudad, :direccion, :celular, :nacionalidad, :pagina_web, :titulo_profesional, :categoria_profesion, :situacion_laboral, :resumen_perfil, :experiencia_docente, :actualizacion)";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":fecha_nacimiento",$fecha_nacimiento);
        $consulta->bindParam(":estado_civil",$estado_civil);
        $consulta->bindParam(":departamento",$departamento);
        $consulta->bindParam(":ciudad",$ciudad);
        $consulta->bindParam(":direccion",$direccion);
        $consulta->bindParam(":celular",$celular);
        $consulta->bindParam(":nacionalidad",$nacionalidad);
        $consulta->bindParam(":pagina_web",$pagina_web);
        $consulta->bindParam(":titulo_profesional",$titulo_profesional);
        $consulta->bindParam(":categoria_profesion",$categoria_profesion);
        $consulta->bindParam(":situacion_laboral",$situacion_laboral);
        $consulta->bindParam(":resumen_perfil",$resumen_perfil);
        $consulta->bindParam(":experiencia_docente",$experiencia_docente);
        $consulta->bindParam(":actualizacion",$actualizacion);
        return($consulta->execute());
    }
    public function cv_editar($id_usuario_cv, $fecha_nacimiento, $estado_civil, $departamento, $ciudad, $direccion, $celular, $nacionalidad, $pagina_web, $titulo_profesional, $categoria_profesion,  $situacion_laboral, $resumen_perfil, $experiencia_docente,$id_informacion_personal){
        $actualizacion = date("Y-m-d H:i:s");
        $sql = "UPDATE `cv_informacion_personal` SET `id_usuario_cv` = :id_usuario_cv, `estado_civil` = :estado_civil, `fecha_nacimiento`= :fecha_nacimiento, `departamento` = :departamento, `ciudad` = :ciudad, `direccion` = :direccion, `telefono` = :celular, `nacionalidad` = :nacionalidad, `pagina_web` = :pagina_web, `titulo_profesional` = :titulo_profesional, `categoria_profesion` = :categoria_profesion, `situacion_laboral` = :situacion_laboral, `perfil_descripcion` = :resumen_perfil, `experiencia_docente` = :experiencia_docente, `ultima_actualizacion` = :actualizacion WHERE `id_informacion_personal` = :id_informacion_personal";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":fecha_nacimiento",$fecha_nacimiento);
        $consulta->bindParam(":estado_civil",$estado_civil);
        $consulta->bindParam(":departamento",$departamento);
        $consulta->bindParam(":ciudad",$ciudad);
        $consulta->bindParam(":direccion",$direccion);
        $consulta->bindParam(":celular",$celular);
        $consulta->bindParam(":nacionalidad",$nacionalidad);
        $consulta->bindParam(":pagina_web",$pagina_web);
        $consulta->bindParam(":titulo_profesional",$titulo_profesional);
        $consulta->bindParam(":categoria_profesion",$categoria_profesion);
        $consulta->bindParam(":situacion_laboral",$situacion_laboral);
        $consulta->bindParam(":resumen_perfil",$resumen_perfil);    
        $consulta->bindParam(":experiencia_docente",$experiencia_docente);
        $consulta->bindParam(":id_informacion_personal",$id_informacion_personal);
        $consulta->bindParam(":actualizacion",$actualizacion);
        return($consulta->execute());
    }
    public function getInfoUser($id_usuario_cv){
        $sql = "SELECT * FROM `cv_informacion_personal` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }
    public function getInfoHoja($id_usuario_cv){
        $sql = "SELECT * FROM `cv_informacion_personal` INNER JOIN `cv_usuario` ON `cv_usuario`.`id_usuario_cv` = `informacion_personal`.`id_usuario_cv`  WHERE `cv_usuario`.`usuario_identificacion` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }
    public function editarImagen($id_usuario_cv, $usuario_imagen){
        $sql = "UPDATE `cv_usuario` SET `usuario_imagen` = :usuario_imagen WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":usuario_imagen",$usuario_imagen);
        $consulta->execute();
        return $consulta;
    }
    public function editarUser($nombres,$apellidos,$id_usuario_cv){
        $sql = "UPDATE `cv_usuario` SET `usuario_nombre` = :nombres, `usuario_apellido` = :apellidos WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":nombres",$nombres);
        $consulta->bindParam(":apellidos",$apellidos);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }
    public function get_all_states(){
        global $mbd;
        $sql = "SELECT * FROM departamentos";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;
    }
    public function get_municipio($id_municipio){
        global $mbd;
        $sql = "SELECT municipio FROM municipios WHERE id_municipio = :id_municipio";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_municipio",$id_municipio);
        $consulta->execute();
        return $consulta;
    }
    public function get_departamento($id_departamento){
        global $mbd;
        $sql = "SELECT departamento FROM departamentos WHERE id_departamento = :id_departamento";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_departamento",$id_departamento);
        $consulta->execute();
        return $consulta;
    }
    public function cv_get_cities_for_state($departamento){
        global $mbd;
        $sql = "SELECT id_municipio, municipio FROM municipios WHERE departamento_id = :departamento";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":departamento",$departamento);
        $consulta->execute();
        return $consulta;
    }
    public function getAllCategories(){
        global $mbd;
        $sql = "SELECT * FROM cv_categoria_profesion";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;
    }
    //experiencia_laboral
    public function cv_insertarExperiencia($id_usuario_cv,$nombre_empresa,$cargo_empresa,$desde_cuando, $hasta_cuando, $mas_detalles){
        $sql = "INSERT INTO `cv_experiencia_laboral`(`id_usuario_cv`, `nombre_empresa`, `cargo_empresa`, `desde_cuando`, `hasta_cuando`, `mas_detalles`) VALUES(:id_usuario_cv, :nombre_empresa, :cargo_empresa, :desde_cuando, :hasta_cuando, :mas_detalles);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":nombre_empresa",$nombre_empresa);
        $consulta->bindParam(":cargo_empresa",$cargo_empresa);
        $consulta->bindParam(":desde_cuando",$desde_cuando);
        $consulta->bindParam(":hasta_cuando",$hasta_cuando);
        $consulta->bindParam(":mas_detalles",$mas_detalles);
        return($consulta->execute());
    }
    public function cveditarExperiencia($id_usuario_cv,$nombre_empresa,$cargo_empresa,$desde_cuando, $hasta_cuando, $mas_detalles,$id_experiencia){
        $sql = "UPDATE `cv_experiencia_laboral` SET `id_usuario_cv`=:id_usuario_cv, `nombre_empresa`=:nombre_empresa, `cargo_empresa`=:cargo_empresa, `desde_cuando`= :desde_cuando, `hasta_cuando`=:hasta_cuando, `mas_detalles`=:mas_detalles WHERE `id_experiencia` =  :id_experiencia";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":id_experiencia",$id_experiencia);
        $consulta->bindParam(":nombre_empresa",$nombre_empresa);
        $consulta->bindParam(":cargo_empresa",$cargo_empresa);
        $consulta->bindParam(":desde_cuando",$desde_cuando);
        $consulta->bindParam(":hasta_cuando",$hasta_cuando);
        $consulta->bindParam(":mas_detalles",$mas_detalles);
        return($consulta->execute());
    }
    public function cv_listarExperiencias($id_usuario_cv){
        $sql = "SELECT * FROM `cv_experiencia_laboral` WHERE id_usuario_cv = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        return $consulta;
    } 
    public function cv_listarExperienciaEspecifica($id_experiencia){
        $sql = "SELECT * FROM `cv_experiencia_laboral` WHERE `id_experiencia` = :id_experiencia";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_experiencia",$id_experiencia);
        $consulta->execute();
        return $consulta;
    }

    public function cv_eliminarExperiencia($id_experiencia){
        $sql = "DELETE FROM `cv_experiencia_laboral` WHERE `id_experiencia` = :id_experiencia";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_experiencia",$id_experiencia);
        $consulta->execute();
        return $consulta;
    }

    public function cv1_insertarEducacion($id_usuario_cv,$institucion_academica,$titulo_obtenido,$desde_cuando_f, $hasta_cuando_f, $mas_detalles_f,$imagen){

        $sql = "INSERT INTO `cv_educacion_formacion`(`id_usuario_cv`, `institucion_academica`, `titulo_obtenido`, `desde_cuando_f`, `hasta_cuando_f`, `mas_detalles_f`) VALUES(:id_usuario_cv, :institucion_academica, :titulo_obtenido, :desde_cuando_f, :hasta_cuando_f, :mas_detalles_f);";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":institucion_academica",$institucion_academica);
        $consulta->bindParam(":titulo_obtenido",$titulo_obtenido);
        $consulta->bindParam(":desde_cuando_f",$desde_cuando_f);
        $consulta->bindParam(":hasta_cuando_f",$hasta_cuando_f);
        $consulta->bindParam(":mas_detalles_f",$mas_detalles_f);
        if($consulta->execute()){
            return($mbd->lastInsertId());  
        }else{
            return FALSE;
        }
    }
    public function cv_traerIdUsuario($documento){
        $sql = "SELECT `id_usuario_cv` FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    } 
}

?>