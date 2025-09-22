<?php

require "../config/Conexion.php";

class CvInformacionPersonal{
    public $Obligario = "Obligatorio";
    public $Adicional = "Adicional";
    public function __construct(){

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

    public function cv_getInfoHoja($id_usuario_cv){
        $sql = "SELECT `cv_usuario`.`usuario_identificacion`, `cv_usuario`.`usuario_nombre`,`cv_usuario`.`usuario_imagen`, `cv_usuario`.`usuario_apellido`, `cv_usuario`.`usuario_email`, `cv_informacion_personal`.* FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv` WHERE `cv_usuario`.`id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }
    public function cv_get_municipio($id_municipio){
        global $mbd;
        $sql = "SELECT municipio FROM municipios WHERE id_municipio = :id_municipio";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_municipio",$id_municipio);
        $consulta->execute();
        return $consulta;
    }    
    public function cv_get_departamento($id_departamento){
        global $mbd;
        $sql = "SELECT departamento FROM departamentos WHERE id_departamento = :id_departamento";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_departamento",$id_departamento);
        $consulta->execute();
        return $consulta;
    }
    public function cv_listarExperiencias($id_usuario_cv){
        $sql = "SELECT * FROM `cv_experiencia_laboral` WHERE `id_usuario_cv` = :id_usuario_cv";
        // $sql = "SELECT * FROM `cv_experiencia_laboral` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    } 
    public function cv_listarExperienciasHoja($id_usuario_cv){
        $sql = "SELECT * FROM `cv_experiencia_laboral` WHERE `id_usuario_cv` = :id_usuario_cv";
        // $sql = "SELECT * FROM `cv_experiencia_laboral` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    } 
    public function cv_listareducacion($id_usuario_cv){
        $sql = "SELECT * FROM `cv_educacion_formacion` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    } 
    public function cv_listarHabilidad($id_usuario_cv){
        $sql = "SELECT * FROM `cv_habilidades_aptitudes` WHERE `id_usuario_cv` = :id_usuario_cv ";
        // $sql = "SELECT * FROM `cv_habilidades_aptitudes` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    }
    public function listarReferencias($id_usuario_cv){
        $sql = "SELECT * FROM `cv_referencias_personal` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;
    } 

    public function listarReferenciasL($id_usuario_cv){
        $sql = "SELECT * FROM `cv_referencias_laborales` WHERE `id_usuario_cv` = :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->execute();
        return $consulta;

    } 
    public function listarDocumentosObligatorios($id_usuario_cv){
        $sql = "SELECT * FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv AND `tipo_documento` = :tipo_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":tipo_documento", $this->Obligario);
        $consulta->execute();
        return $consulta;
    }
    public function listarDocumentosAdicionales($id_usuario_cv){
        $sql = "SELECT * FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv  AND `tipo_documento` = :tipo_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv",$id_usuario_cv);
        $consulta->bindParam(":tipo_documento", $this->Adicional);
        $consulta->execute();
        return $consulta;
    }
}

?>