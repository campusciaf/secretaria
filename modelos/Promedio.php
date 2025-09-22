<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Promedio
{
    public function consulta($cedula)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` WHERE credencial_identificacion = :cedula ");
        $sentencia->bindParam(":cedula",$cedula);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }
    public function consultaProgramas($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT *  FROM `estudiantes` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function consultaMaterias($id_usuario,$id_programa,$ciclo,$semestre)
    {   
        $materia = "materias".$ciclo;
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM $materia WHERE `id_estudiante` = :id AND programa = :programa AND semestre = :semestre");
        $sentencia->bindParam(":id",$id_usuario);
        $sentencia->bindParam(":programa",$id_programa);
        $sentencia->bindParam(":semestre",$semestre);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registros;

    }

    public function cantidadSemestre($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT semestres FROM `programa_ac` WHERE id_programa = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }
}


?>