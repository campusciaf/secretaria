<?php

require "../config/Conexion.php";
class HvFunHojaDeVida{
    public $Obligario = "Obligatorio";
    public $Adicional = "Adicional";
    public function __construct(){

	}
    public function cv_traerIdUsuario($documento){
        $sql = "SELECT `id_cvadministrativos` FROM `cvadministrativos` WHERE `cvadministrativos_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    } 
    public function cv_getInfoHoja($id_cvadministrativos){
        $sql = "SELECT `cvadministrativos`.`cvadministrativos_identificacion`, `cvadministrativos`.`cvadministrativos_nombre`, `cvadministrativos`.`usuario_apellido`,  `cvadministrativos`.`usuario_imagen`, `cvadministrativos`.`cvadministrativos_correo`, `hv_fun_informacion_personal`.* FROM `cvadministrativos` INNER JOIN `hv_fun_informacion_personal` ON `hv_fun_informacion_personal`.`id_cvadministrativos` = `cvadministrativos`.`id_cvadministrativos` WHERE `cvadministrativos`.`id_cvadministrativos` = :id_cvadministrativos";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
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
    public function cv_listarExperiencias($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_experiencia_laboral` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        // $sql = "SELECT * FROM `hv_fun_experiencia_laboral` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    } 
    public function cv_listarExperienciasHoja($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_experiencia_laboral` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        // $sql = "SELECT * FROM `hv_fun_experiencia_laboral` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    } 
    public function cv_listareducacion($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_educacion_formacion` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    } 
    public function cv_listarHabilidad($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_habilidades_aptitudes` WHERE `id_cvadministrativos` = :id_cvadministrativos ";
        // $sql = "SELECT * FROM `cv_habilidades_aptitudes` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    }
    public function listarReferencias($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_referencias_personal` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->execute();
        return $consulta;
    } 

    public function listarReferenciasL($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_referencias_laborales` WHERE `id_cvadministrativos` = :id_cvadministrativos";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->execute();
        return $consulta;

    } 
    public function listarDocumentosObligatorios($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_documentacion_usuario` WHERE `id_cvadministrativos` = :id_cvadministrativos AND `tipo_documento` = :tipo_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->bindParam(":tipo_documento", $this->Obligario);
        $consulta->execute();
        return $consulta;
    }
    public function listarDocumentosAdicionales($id_cvadministrativos){
        $sql = "SELECT * FROM `hv_fun_documentacion_usuario` WHERE `id_cvadministrativos` = :id_cvadministrativos  AND `tipo_documento` = :tipo_documento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos",$id_cvadministrativos);
        $consulta->bindParam(":tipo_documento", $this->Adicional);
        $consulta->execute();
        return $consulta;
    }
}

?>