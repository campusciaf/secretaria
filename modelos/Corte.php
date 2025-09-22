<?php
require "../config/Conexion.php";
class Corte
{
    public function consulta()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `corte` WHERE 1 ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        echo json_encode($registro);
    }
    public function cambiarCorte($newCorte)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `corte` SET `corte`= :corte  WHERE `id` = 1 ");
        $sentencia->bindParam(":corte",$newCorte);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "Error, no se pudo cambiar el corte, ponte en contacto con el administrador.";
        }
        echo json_encode($data);
    }

}
?>