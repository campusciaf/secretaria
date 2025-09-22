<?php

require "../config/Conexion.php";

class CvEducacionFormacion
{
    public function insertarEducacion($id_usuario_cv, $institucion_academica, $titulo_obtenido, $desde_cuando_f, $hasta_cuando_f, $mas_detalles_f, $imagen, $nivel_formacion)
    {
        $sql = "INSERT INTO `cv_educacion_formacion`(`id_usuario_cv`, `institucion_academica`, `titulo_obtenido`, `desde_cuando_f`, `hasta_cuando_f`, `mas_detalles_f`, `nivel_formacion`) VALUES(:id_usuario_cv, :institucion_academica, :titulo_obtenido, :desde_cuando_f, :hasta_cuando_f, :mas_detalles_f, :nivel_formacion);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->bindParam(":institucion_academica", $institucion_academica);
        $consulta->bindParam(":titulo_obtenido", $titulo_obtenido);
        $consulta->bindParam(":desde_cuando_f", $desde_cuando_f);
        $consulta->bindParam(":hasta_cuando_f", $hasta_cuando_f);
        $consulta->bindParam(":mas_detalles_f", $mas_detalles_f);
        $consulta->bindParam(":nivel_formacion", $nivel_formacion);
        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }

    public function traeriddocente($id_usuario)
    {
        $sql = "SELECT * FROM `docente` WHERE `id_usuario` = :id_usuario";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function cv_traerIdUsuario($documento)
    {
        $sql = "SELECT `id_usuario_cv` ,`porcentaje_avance` FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    //experiencia_laboral
    public function cv_insertarEducacion($id_usuario_cv, $institucion_academica, $titulo_obtenido, $desde_cuando_f, $hasta_cuando_f, $mas_detalles_f, $imagen)
    {
        $sql = "INSERT INTO `cv_educacion_formacion`(`id_usuario_cv`, `institucion_academica`, `titulo_obtenido`, `desde_cuando_f`, `hasta_cuando_f`, `mas_detalles_f`) VALUES(:id_usuario_cv, :institucion_academica, :titulo_obtenido, :desde_cuando_f, :hasta_cuando_f, :mas_detalles_f);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
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

    public function editarEducacion($id_usuario_cv, $institucion_academica, $titulo_obtenido, $desde_cuando_f, $hasta_cuando_f, $mas_detalles_f, $id_formacion, $imagen, $nivel_formacion)
    {

        $sql = "UPDATE `cv_educacion_formacion` SET `id_usuario_cv`=:id_usuario_cv, `institucion_academica`=:institucion_academica, `titulo_obtenido`=:titulo_obtenido, `desde_cuando_f`= :desde_cuando_f, `hasta_cuando_f`=:hasta_cuando_f, `mas_detalles_f`=:mas_detalles_f, `nivel_formacion`=:nivel_formacion WHERE `id_formacion` =  :id_formacion";
        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->bindParam(":id_formacion", $id_formacion);
        $consulta->bindParam(":institucion_academica", $institucion_academica);
        $consulta->bindParam(":titulo_obtenido", $titulo_obtenido);
        $consulta->bindParam(":desde_cuando_f", $desde_cuando_f);
        $consulta->bindParam(":hasta_cuando_f", $hasta_cuando_f);
        $consulta->bindParam(":mas_detalles_f", $mas_detalles_f);
        $consulta->bindParam(":nivel_formacion", $nivel_formacion);

        return ($consulta->execute());
    }

    public function cv_listareducacion($id_usuario_cv)
    {
        $sql = "SELECT * FROM `cv_educacion_formacion` WHERE `id_usuario_cv` = :id_usuario_cv";
        // $sql = "SELECT * FROM `cv_educacion_formacion` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }

    public function listarEducacionEspecifica($id_formacion)
    {
        $sql = "SELECT * FROM `cv_educacion_formacion` WHERE `id_formacion` = :id_formacion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_formacion", $id_formacion);
        $consulta->execute();
        return $consulta;
    }

    public function eliminarEducacion($id_formacion)
    {
        $sql = "DELETE FROM `cv_educacion_formacion` WHERE `id_formacion` = :id_formacion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_formacion", $id_formacion);
        $consulta->execute();
        return $consulta;
    }

    public function editarCertificado($id_formacion, $nombre_img)
    {
        $sql = "UPDATE `cv_educacion_formacion` SET `certificado_educacion` = :certificado_educacion WHERE `id_formacion` = :id_formacion";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_formacion", $id_formacion);
        $consulta->bindParam(":certificado_educacion", $nombre_img);
        $consulta->execute();
        return $consulta;
    }

    public function selectlistarNivelFormacion()
    {
        $sql = "SELECT * FROM cv_nivel_formacion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function CuentoRegistros($id_usuario_cv)
    {
        $sql = "SELECT COUNT(*) as total FROM cv_educacion_formacion WHERE id_usuario_cv = :id_usuario_cv";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id_usuario_cv', $id_usuario_cv);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function actualizar_porcentaje_personal($porcentaje_avance, $id_usuario_cv)
    {
        $sql = "UPDATE `cv_usuario` SET `porcentaje_avance` = :porcentaje_avance WHERE `id_usuario_cv` = :id_usuario_cv";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":porcentaje_avance", $porcentaje_avance);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }

    public function obtenerPorcentajeAvance_dinamico($id_usuario_cv)
    {
        $sql = "SELECT porcentaje_avance FROM cv_usuario WHERE id_usuario_cv = :id_usuario_cv";
        // echo $sql;
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id_usuario_cv', $id_usuario_cv);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function actualizar_porcentaje_personal_dinamico($porcentaje_avance, $id_usuario_cv)
    {
        $sql = "UPDATE `cv_usuario` SET `porcentaje_avance` = :porcentaje_avance WHERE `id_usuario_cv` = :id_usuario_cv";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":porcentaje_avance", $porcentaje_avance);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }
}
