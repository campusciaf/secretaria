<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Abrircaso{
    public function consultaEstudiante($dato_busqueda){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM credencial_estudiante INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial WHERE credencial_estudiante.credencial_identificacion = :dato_busqueda");
        $sentencia->bindParam(":dato_busqueda",$dato_busqueda);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;

    }
    
    public function consultaCasos($dato_busqueda){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT casos.*, usuario.usuario_cargo FROM casos inner join credencial_estudiante on credencial_estudiante.id_credencial = casos.id_estudiante inner join usuario on usuario.id_usuario = casos.area_id WHERE credencial_estudiante.credencial_identificacion = :dato_busqueda");
        $sentencia->bindParam(":dato_busqueda",$dato_busqueda);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    
    public function consultaProgramas($id_credencial){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `estudiantes` where id_credencial = :id_credencial ");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        
        return $registro;
    }
    
      public function GuardarCaso($id_credencial, $asunto,$caterogia_caso, $id_usuario,$fecha){
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
    
    public function listarCategorias(){
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

}


?>