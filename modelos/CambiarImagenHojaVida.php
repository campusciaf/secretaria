<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class CambiarImagenHojaVida
{
    function actualizarCampoBDHojaVida($campo, $id_cvadministrativos)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `cvadministrativos` SET `usuario_imagen` = :campo WHERE `id_cvadministrativos` = :id_cvadministrativos ");
        // echo $sentencia;
        $sentencia->bindParam(":campo", $campo);
        $sentencia->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        if ($sentencia->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function base64_to_jpeg($base64_string, $output_file)
    {
        if (empty($output_file)) {
            return false;
        }
        $ifp = fopen($output_file, 'wb');
        if (!$ifp) {
            return false;
        }
        $data = explode(',', $base64_string);
        if (count($data) < 2) {
            fclose($ifp);
            return false;
        }
        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);
        return $output_file;
    }
}
