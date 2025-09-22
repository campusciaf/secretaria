<?php

require "../config/Conexion.php";

class Promedio
{
    public function listarPeriodo()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `periodo` ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($registro);
    }




    public function consultaPromedio($programa,$periodo)
    {
        $ciclo = self::consultaMateria($programa);
        $materia = "materias".$ciclo['ciclo'];
        $data = array();
        $datos = array();
        $sql = " SELECT DISTINCT id_estudiante FROM $materia WHERE periodo = :periodo AND programa = :programa ";
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->bindParam(":programa",$programa);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function promediosPonderado($id,$programa,$periodo)
    {
        $ciclo = self::consultaMateria($programa);
        $materia = "materias".$ciclo['ciclo'];
        $data = array();
        $datos = array();
        $sql = " SELECT * FROM $materia WHERE id_estudiante = :id AND periodo = :periodo AND programa = :programa ";
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $cantidad = 0;
        $suma = 0;
        $i = 0;
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->bindParam(":programa",$programa);
        $sentencia->execute();
        while ($registro = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $data[] = array(
                '0' => $registro['promedio'],
                '1' => $registro['creditos'],
                '2' => $registro['id_estudiante']
            );
        $datos['jornada'] = $registro['jornada'];
        $datos['semestre'] = $registro['semestre'];
            $cantidad = $cantidad+$registro['creditos'];
            $i++;
        }

        

        for ($i=0; $i < count($data); $i++) { 
           $result = ($data[$i]['1']/$cantidad)*$data[$i]['0'];
           $suma = $suma+$result;

        }
        //echo json_encode($data['3']['3']);

        $datos['promedio_ponderado'] = $suma;
        $datos['cantidadmatrias'] = $i;
        

        return $datos;
    }

    public function consultaDatos($id)
    {
        
        global $mbd;

        $sentencia2 = $mbd->prepare(" SELECT id_credencial FROM `estudiantes` WHERE id_estudiante = :id ");
        $sentencia2->bindParam(":id",$id);
        $sentencia2->execute();
        $registro2 = $sentencia2->fetch(PDO::FETCH_ASSOC);

        $sentencia = $mbd->prepare(" SELECT CONCAT(credencial_nombre,' ',credencial_nombre_2) as nombres, CONCAT(credencial_apellido,' ',credencial_apellido_2) as apellidos FROM `credencial_estudiante` WHERE id_credencial = :id ");
        $sentencia->bindParam(":id",$registro2['id_credencial']);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function consultaMateria($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `id_programa`,`nombre`,ciclo FROM `programa_ac` WHERE id_programa = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
}


?>