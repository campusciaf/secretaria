<?php
session_start(); 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class HeaderDocente{
    //Implementamos nuestro constructor
    public function __construct(){}

    public function periodoactual(){
        $sql="SELECT * FROM periodo_actual"; 

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listarTema()
    {
        $id=$_SESSION['id_usuario'];
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT id_usuario,modo_ui FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    /* función para traer los datos del docente */
    public function consultadocente()
    {
        global $mbd;        
        $id = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

    }

    public function verificarInduccionPlataforma(){
        global $mbd;        
        $id = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare("SELECT * FROM `induccion_docente_categorias` `idc` WHERE NOT EXISTS ( SELECT 1 FROM `induccion_docente_aprobada` `ida` WHERE `idc`.`id_induccion_docente_categoria` = `ida`.`id_induccion_docente_categorias` AND `ida`.`id_docente` = :id ); ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

    }
    public function listarPuntos()
    {
        $id = $_SESSION['id_usuario'];
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT id_usuario,puntos,nivel FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

    } 

    public function docenteDestacado()
    {
        $identificacion=$_SESSION['usuario_identificacion'];
        $periodo_anterior=$_SESSION['periodo_anterior'];
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `evaluaciondocente_general` WHERE identificacion= :identificacion  AND periodo= :periodo_anterior");
        $sentencia->bindParam(":identificacion", $identificacion);
        $sentencia->bindParam(":periodo_anterior", $periodo_anterior);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

    }  

}
?>
