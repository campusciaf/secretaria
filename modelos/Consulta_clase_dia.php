<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Consultas
{
    public function listarperiodo()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `periodo` ORDER BY `periodo`.`periodo` DESC ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($registro);

    }

    public function consultaDatos($dia,$periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `horas_grupos` WHERE `dia` LIKE :dia AND `periodo_hora` = :periodo ");
        $sentencia->bindParam(":dia",$dia);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function datosGrupo($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `docente_grupos` WHERE `id_docente_grupo` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function datosdocente($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro['usuario_nombre'].' '.$registro['usuario_nombre_2'].' '.$registro['usuario_apellido'].' '.$registro['usuario_apellido_2'];
    }

    public function consultaPrograma($id){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT nombre FROM `programa_ac` WHERE id_programa = :id");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

}


?>