<?php 
require "../config/Conexion.php";
class Oncentertrazabilidad
{
    public function periodoactual(){
    	$sql="SELECT * FROM on_periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    public function buscar($val,$periodo_campana)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `on_trazabilidad_tareas` WHERE tipo = :val AND periodo = :periodo_campana ");
        $sentencia->bindParam(":val",$val);
        $sentencia->bindParam(":periodo_campana",$periodo_campana);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function nombre_usuario($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(`usuario_nombre`,' ',`usuario_apellido`) AS nombre FROM `usuario` WHERE `id_usuario` = $id ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro['nombre'];
    }
    
}

?>