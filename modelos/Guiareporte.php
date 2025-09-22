<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Reporte
{
    public function categorias()
    {
        global $mbd;
        $sentecia = $mbd->prepare(" SELECT * FROM `categoria_casos` ");
        $sentecia->execute();
        return $sentecia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guia_traer_docentes(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `docente` WHERE `usuario_condicion` = 1");
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }

    public function programas()
    {
        global $mbd;
        $sentecia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE estado = 1 ORDER BY `programa_ac`.`nombre` ASC ");
        $sentecia->execute();
        return $sentecia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscar($categoria, $id_docente, $mes)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $ano=date('Y');
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_casos` as uno INNER JOIN docente as dos ON uno.id_docente = dos.id_usuario WHERE uno.categoria_caso = :categoria AND dos.id_usuario = :id_docente AND uno.created_at LIKE '$ano-$mes-%' ");
        $sentencia->bindParam(":categoria",$categoria);
        $sentencia->bindParam(":id_docente",$id_docente);
        // $sentencia->bindParam(":mes",$mes);
        // $sentencia->bindParam(":ano",$ano);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscar2($categoria,$mes)
    {
        global $mbd;
        $ano=date('Y');
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_casos` as uno WHERE uno.categoria_caso = :categoria AND uno.created_at LIKE '$ano-$mes-%' ");
        $sentencia->bindParam(":categoria",$categoria);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function categorias_cerrados()
    {
        global $mbd;
        $sentecia = $mbd->prepare(" SELECT * FROM `categoria_casos_cerrados` ");
        $sentecia->execute();
        return $sentecia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar_cerrados($categoria, $id_docente, $mes)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $ano=date('Y');
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_casos` as uno INNER JOIN docente as dos ON uno.id_docente = dos.id_usuario WHERE uno.categoria_caso = :categoria AND dos.id_usuario = :id_docente AND uno.created_at LIKE '$ano-$mes-%' ");
        $sentencia->bindParam(":categoria",$categoria);
        $sentencia->bindParam(":id_docente" , $id_docente) ;
        // $sentencia->bindParam(":mes",$mes);
        // $sentencia->bindParam(":ano",$ano);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscar2_cerrados($categoria, $mes)
    {
        global $mbd;
        $ano=date('Y');
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_casos` as uno  WHERE uno.categoria_caso = :categoria AND uno.created_at LIKE '$ano-$mes-%' ");
        $sentencia->bindParam(":categoria",$categoria);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>