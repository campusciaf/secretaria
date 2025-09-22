<?php 
require "../config/Conexion.php";
class Restablecer{
    public function consultaEstudiante($dato, $ubicacion, $seleccion_nav) {
        global $mbd;
    
        // Determinar la tabla y el campo basados en $ubicacion y $seleccion_nav
        switch ($ubicacion) {
            //cuadno es 1 filtra la tabla para el estudiante
            case "1":
                $tabla = "credencial_estudiante";
                $campo = ($seleccion_nav == "1") ? "credencial_identificacion" : (($seleccion_nav == "2") ? "credencial_login" : "correo");
                break;
            //cuadno es 2 filtra la tabla para el docente
            case "2":
                $tabla = "docente";
                $campo = ($seleccion_nav == "1") ? "usuario_identificacion" : (($seleccion_nav == "2") ? "usuario_email_ciaf" : "correo");
                break;
            //cuadno es 2 filtra la tabla para el funcionario
            case "3": 
                $tabla = "usuario";
                $campo = ($seleccion_nav == "1") ? "usuario_identificacion" : (($seleccion_nav == "2") ? "usuario_login" : "correo");
                break;
        }
        $sql = "SELECT * FROM `$tabla` WHERE `$campo` = :dato";
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(':dato', $dato);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

    }

    public function consultardocentetipo($valor_seleccionado)
    {
        global $mbd;
        $sentencia = $mbd->prepare("$valor_seleccionado");
        // echo $sentencia;
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    //restablecer contraseña
    public function restablecerContrasena($id, $cedula, $ubicacion){
        $pass = md5($cedula);
        if ($ubicacion == "1") {
            $sql = "UPDATE  `credencial_estudiante` SET `credencial_clave` = :pass WHERE `id_credencial` = :id ";
        }elseif($ubicacion == "2") {
            $sql = "UPDATE  `docente` SET `usuario_clave` = :pass WHERE `id_usuario` = :id ";
        }elseif ($ubicacion == "3") {
            $sql = "UPDATE  `usuario` SET `usuario_clave` = :pass WHERE `id_usuario` = :id ";
        }
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":pass", $pass);
        $sentencia->bindParam(":id", $id);
        return $sentencia->execute();
    }
}
?>