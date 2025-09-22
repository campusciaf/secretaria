<?php

require "../config/Conexion.php";

class HvFunDocumentosObligatorios
{
    //experiencia_laboral
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
    public $Obligario = "Obligatorio";
    public $Adicional = "Adicional";
    public function insertarDocumentosO($id_cvadministrativos, $documento_nombre)
    {
        $sql = "INSERT INTO `hv_fun_documentacion_usuario`(`id_cvadministrativos`, `documento_nombre`, `tipo_documento`) VALUES(:id_cvadministrativos, :documento_nombre, :tipo_documento);";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":documento_nombre", $documento_nombre);
        $consulta->bindParam(":tipo_documento", $this->Obligario);
        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }
    public function editarDocumento($id_documento, $nombre_img)
    {
        /*echo($id_documento." - ".$nombre_img);*/
        $sql = "UPDATE `hv_fun_documentacion_usuario` SET `documento_archivo` = :nombre_img WHERE `id_documentacion` = :id_documento";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_documento", $id_documento);
        $consulta->bindParam(":documento_archivo", $nombre_img);
        $consulta->execute();
        return $consulta;
    }

    public function insertarDocumentosA($id_usuario, $documento_nombre)
    {
        $sql = "INSERT INTO `hv_fun_documentacion_usuario`(`id_usuario`, `documento_nombre`, `tipo_documento`) VALUES(:id_usuario, :documento_nombre, :tipo_documento);";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":documento_nombre", $documento_nombre);
        $consulta->bindParam(":tipo_documento", $this->Adicional);
        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }
    public function cvlistarDocumentosObligatorios($documento)
    {
        $sql = "SELECT `hv_fun_documentacion_usuario`.* FROM `hv_fun_documentacion_usuario` INNER JOIN `cvadministrativos` ON `hv_fun_documentacion_usuario`.`id_cvadministrativos` = `cvadministrativos`.`id_cvadministrativos` WHERE `cvadministrativos`.`cvadministrativos_identificacion` = :documento AND `hv_fun_documentacion_usuario`.`tipo_documento` = :tipo_documento";
        // $sql = "SELECT * FROM `hv_fun_documentacion_usuario` WHERE `id_usuario` = :id_usuario AND `tipo_documento` = :tipo_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":documento", $documento);
        $consulta->bindParam(":tipo_documento", $this->Obligario);
        $consulta->execute();
        return $consulta;
    }



    public function cv_listarDocumentosAdicionales($documento)
    {
        $sql = "SELECT `hv_fun_documentacion_usuario`.* FROM `hv_fun_documentacion_usuario` INNER JOIN `cvadministrativos` ON `hv_fun_documentacion_usuario`.`id_cvadministrativos` = `cvadministrativos`.`id_cvadministrativos` WHERE `cvadministrativos`.`cvadministrativos_identificacion` = :documento AND `hv_fun_documentacion_usuario`.`tipo_documento` = :tipo_documento";
        // $sql = "SELECT * FROM `hv_fun_documentacion_usuario` WHERE `id_usuario` = :id_usuario  AND `tipo_documento` = :tipo_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":documento", $documento);
        $consulta->bindParam(":tipo_documento", $this->Adicional);
        $consulta->execute();
        return $consulta;
    }
    public function cvdocumentosOeliminar($id_cvadministrativos, $documento_nombre)
    {
        $sql = "DELETE FROM `hv_fun_documentacion_usuario` WHERE `id_cvadministrativos` = :id_cvadministrativos AND `documento_nombre` = :documento_nombre";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":documento_nombre", $documento_nombre);
        $consulta->execute();
        return $consulta;
    }
    public function documentosAeliminar($id_documentoA)
    {
        $sql = "DELETE FROM `hv_fun_documentacion_usuario` WHERE `id_documentacion` = :id_documento AND `tipo_documento` = :tipo_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_documento", $id_documentoA);
        $consulta->bindParam(":tipo_documento", $this->Adicional);
        $consulta->execute();
        return $consulta;
    }
    public function cveditarDocumento($id_documento, $nombre_img)
    {
        /*echo($id_documento." - ".$nombre_img);*/
        $sql = "UPDATE `hv_fun_documentacion_usuario` SET `documento_archivo` = :documento_archivo WHERE `id_documentacion` = :id_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_documento", $id_documento);
        $consulta->bindParam(":documento_archivo", $nombre_img);
        $consulta->execute();
        return $consulta;
    }


    // public function listarDocumentosObligatorios($id_cvadministrativos, $documento_nombre)
    // {
    //     $sql = "SELECT * FROM `hv_fun_documentacion_usuario` WHERE `id_cvadministrativos` = :id_cvadministrativos AND `documento_nombre` = :documento_nombre";
    //     // echo $sql;
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
    //     $consulta->bindParam(":documento_nombre", $documento_nombre);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    //     return $resultado;
    // }

    public function listarDocumentosObligatorios($id_cvadministrativos, $documento_nombre)
    {
        $sql = "SELECT * FROM `hv_fun_documentacion_usuario` WHERE `id_cvadministrativos` = :id_cvadministrativos AND `documento_nombre` = :documento_nombre ORDER BY `id_documentacion` DESC LIMIT 1";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":documento_nombre", $documento_nombre);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }



    public function listarDocumentosObligatoriosotrosestudios($id_cvadministrativos)
    {
        $sql = "SELECT * FROM `hv_fun_documentacion_usuario` WHERE `id_cvadministrativos` = :id_cvadministrativos AND documento_nombre ='Otros Estudios' ";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function cvdocumentosOeliminarotrosestudios($id_documentacion)
    {
        $sql = "DELETE FROM `hv_fun_documentacion_usuario` WHERE `id_documentacion` = :id_documentacion ";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_documentacion", $id_documentacion);
        $consulta->execute();
        return $consulta;
    }

    public function CuentoRegistros($id_cvadministrativos)
    {
        $sql = "SELECT COUNT(*) as total FROM hv_fun_educacion_formacion WHERE id_cvadministrativos = :id_cvadministrativos";
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
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":porcentaje_avance", $porcentaje_avance);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }


    public $Obligario2 = "Obligatorio";
    public function InsertarDocumentosRutTarjetaProfesional($documento_nombre, $estado, $id_cvadministrativos)

    {
        $sql = "INSERT INTO `hv_fun_documentacion_usuario`(`id_cvadministrativos`, `documento_nombre`, `estado`, `tipo_documento`) VALUES(:id_cvadministrativos, :documento_nombre, :estado, :tipo_documento);";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":estado", $estado);
        $consulta->bindParam(":documento_nombre", $documento_nombre);
        $consulta->bindParam(":tipo_documento", $this->Obligario2);
        if ($consulta->execute()) {
            return ($mbd->lastInsertId());
        } else {
            return FALSE;
        }
    }
    public function existeDocumentoUsuario($id_cvadministrativos, $documento_nombre)
    {
        global $mbd;
        $sql = "SELECT COUNT(*) FROM hv_fun_documentacion_usuario WHERE id_cvadministrativos = :id_cvadministrativos AND documento_nombre = :documento_nombre";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $stmt->bindParam(":documento_nombre", $documento_nombre);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function actualizarDocumentoEstado($id_documento, $estado)
    {
        global $mbd;
        $sql = "UPDATE `hv_fun_documentacion_usuario` SET `estado` = :estado WHERE `id_documentacion` = :id_documentacion";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":estado", $estado);
        $consulta->bindParam(":id_documentacion", $id_documento);
        return $consulta->execute();
    }

    public function obtenerIdDocumentoUsuario($id_cvadministrativos, $documento_nombre)
    {
        global $mbd;
        $sql = "SELECT id_documentacion FROM `hv_fun_documentacion_usuario` WHERE `id_cvadministrativos` = :id_cvadministrativos AND `documento_nombre` = :documento_nombre AND `tipo_documento` = :tipo_documento LIMIT 1";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":documento_nombre", $documento_nombre);
        $consulta->bindParam(":tipo_documento", $this->Obligario2); // "Obligatorio"
        if ($consulta->execute()) {
            $id = $consulta->fetchColumn();
            return $id ? $id : false;
        }
        return false;
    }

    public function ActualizarEstadoRutTarjetaProfesional($documento_nombre, $estado, $id_cvadministrativos)
    {
        global $mbd;
        $sql = "UPDATE `hv_fun_documentacion_usuario` SET `estado` = :estado WHERE `id_cvadministrativos` = :id_cvadministrativos AND `documento_nombre` = :documento_nombre AND `tipo_documento` = :tipo_documento";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":estado", $estado);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":documento_nombre", $documento_nombre);
        $consulta->bindParam(":tipo_documento", $this->Obligario2); // "Obligatorio"
        return $consulta->execute();
    }
}
