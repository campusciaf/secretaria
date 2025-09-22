<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Estado
{
    public function guia_casos()
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_casos` WHERE `area_id` = $id_user ORDER BY `guia_casos`.`created_at` DESC ");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function guia_remisiones()
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_remisiones` WHERE remision_para = $id_user ORDER BY `guia_remisiones`.`remision_fecha` DESC ");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function guia_consulta_caso($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_casos` WHERE `caso_id` = $id ");
        $sentencia->execute();
        return $sentencia->fetch();
    }

    public function guia_nombre_usuario($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT CONCAT(`usuario_nombre`,' ',`usuario_nombre_2`,' ',`usuario_apellido`,' ',`usuario_apellido_2`) AS nombre FROM `usuario` WHERE `id_usuario` = $id ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        if (is_array($registro)) {
            return $registro;
        }else{
            $registro['nombre'] = "";
            return $registro;
        }
    }

}
