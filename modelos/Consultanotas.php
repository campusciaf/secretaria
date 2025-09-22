<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();

class Consulta
{
    public function progra($val)
    {
       global $mbd;
       $sentencia = $mbd->prepare(" SELECT *  FROM `programa_ac` WHERE id_programa = :id ");
       $sentencia->bindParam(":id",$val);
       $sentencia->execute();
       $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

       echo json_encode($registro);
    }

    public function consul($programa,$semestre,$c,$jornada,$pe){
        global $mbd;
        $mate = "materias".$c;
        /*$pe = $_SESSION['periodo_actual'];*/

        $jor = ($jornada == "Ninguno") ? "jornada != ''" : "jornada = '$jornada' " ;
        $se = ($semestre == "todos") ? "semestre != ''" : "semestre = '$semestre' " ;

        $sentencia = $mbd->prepare(" SELECT * FROM $mate WHERE $jor AND periodo = '$pe' AND $se AND programa = '$programa' ");
        /* $sentencia->bindParam(":pe",$pe);
        $sentencia->bindParam(":pro",$programa); */
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
        //print_r($sentencia);
    }

    public function datos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(tres.credencial_nombre,' ',tres.credencial_nombre_2,' ',tres.credencial_apellido,' ',tres.credencial_apellido_2) AS nombre, dos.telefono, dos.email AS correo_p, tres.credencial_login AS correo, tres.credencial_identificacion AS cc FROM estudiantes AS uno INNER JOIN estudiantes_datos_personales AS dos ON uno.id_credencial = dos.id_credencial INNER JOIN credencial_estudiante AS tres ON dos.id_credencial = tres.id_credencial WHERE uno.id_estudiante = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }
    public function programa($id){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE `id_programa` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }
    
    public function periodos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT periodo FROM `periodo` ORDER BY `periodo`.`periodo` DESC");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

}


?>