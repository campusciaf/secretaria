<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Remisiones
{
    // public function buscar($val,$ano)
    // {
    //     global $mbd;
    //     $sentenica = $mbd->prepare(" SELECT * FROM `remisiones` WHERE remision_visualizada = $val ");
    //     $sentenica->execute();
    //     return $sentenica->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function buscar($val, $ano)
{
    global $mbd;

    $sql = "SELECT * FROM remisiones WHERE remision_visualizada = :val AND YEAR(remision_fecha) = :anio";

    $sentencia = $mbd->prepare($sql);
    $sentencia->bindParam(':val', $val);
    $sentencia->bindParam(':anio', $ano);
    $sentencia->execute();

    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

    public function nombre_usuario($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(`usuario_nombre`,' ',`usuario_nombre_2`,' ',`usuario_apellido`,' ',`usuario_apellido_2`) AS nombre FROM `usuario` WHERE `id_usuario` = $id ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

}


?>