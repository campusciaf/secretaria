<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Estado
{
    public function guia_estado_buscar($val)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_casos` WHERE `caso_estado` = '$val' ORDER BY `guia_casos`.`updated_at` ASC ");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function guia_estado_nombre_usuario($id)
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

    public function guia_estado_consulta_caso($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `guia_casos` WHERE `caso_id` = $id ");
        $sentencia->execute();
        return $sentencia->fetch();
    }

}


?>