<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Remisiones
{
    public function guiabuscar($val)
    {
        global $mbd;
        $sentenica = $mbd->prepare(" SELECT * FROM `guia_remisiones` WHERE remision_visualizada = $val ");
        $sentenica->execute();
        return $sentenica->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guia_nombre_usuario($id){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(`usuario_nombre`,' ',`usuario_nombre_2`,' ',`usuario_apellido`,' ',`usuario_apellido_2`) AS nombre FROM `usuario` WHERE `id_usuario` = $id");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        if (is_array($registro)) {
            return $registro;
        }else{
            $registro["nombre"] = "";
            return $registro;
        }
    }

}


?>