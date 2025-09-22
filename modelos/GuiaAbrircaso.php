<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Guiaabrircaso{
    public function guiaConsultaDocente($dato_busqueda){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `docente` WHERE `usuario_identificacion` = :dato_busqueda");
        $sentencia->bindParam(":dato_busqueda", $dato_busqueda);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;

    }
    
    public function guiaConsultaCasos($dato_busqueda){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `guia_casos`.* , `usuario`.`usuario_cargo` 
                                    FROM `guia_casos` 
                                    INNER JOIN `usuario` ON `usuario`.`id_usuario` = `guia_casos`.`area_id` 
                                    INNER JOIN `docente` ON `docente`.`id_usuario` = `guia_casos`.`id_docente` 
                                    WHERE `docente`.`usuario_identificacion` = :dato_busqueda");
        $sentencia->bindParam(":dato_busqueda",$dato_busqueda);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    
    public function guiaConsultaProgramas($id_docente){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `dg`.`materia`, `dg`.`jornada`, `dg`.`semestre`, `pc`.`nombre` FROM `docente_grupos` AS `dg` INNER JOIN `programa_ac` AS `pc` ON `pc`.`id_programa` = `dg`.`id_programa` WHERE `id_docente` = :id_docente AND `dg`.`periodo` = :periodo");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $_SESSION["periodo_actual"]);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        
        return $registro;
    }
    
    public function GuiaGuardarCaso($id_credencial, $asunto, $categoria_caso, $id_usuario, $fecha){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `guia_casos`(`caso_asunto`, `categoria_caso`, `id_docente`, `area_id`, `created_at`) VALUES(:asunto, :categoria, :id_docente, :id_usuario, :fecha)");
        //echo "INSERT INTO `guia_casos`(`caso_asunto`, `categoria_caso`, `id_docente`, `area_id`, `created_at`) VALUES($asunto, $categoria_caso, $id_credencial, $id_usuario, $fecha)";
        $sentencia->bindParam(":id_docente", $id_credencial);
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->bindParam(":asunto", $asunto);
        $sentencia->bindParam(":categoria", $categoria_caso);
        $sentencia->bindParam(":fecha", $fecha);
        return $sentencia->execute();

    }
    
    public function guiaListarCategorias(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `guia_categoria`;");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function guiaConsulta_casos($id)
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_casos` WHERE caso_id = $id AND area_id = $id_user ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function guiaConsultaremisiones($id)
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `remisiones` WHERE caso_id = $id AND remision_para = $id_user ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

}


?>