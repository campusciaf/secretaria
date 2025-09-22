<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Periodo
{
    public function periodoActual()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `periodo_actual`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        echo json_encode($registro);
    }
    public function updatePeriodo($periodo)
    {
        global $mbd;
        
        $semes = explode("-", $periodo);

        if ($semes[1] == "1") {
            $siguiente = $semes[0].'-2';
            $anterior = ($semes[0]-1).'-2';
        }else {
            $siguiente = ($semes[0]+1).'-1';
            $anterior = $semes[0].'-1';
        }

        $sentencia = $mbd->prepare("UPDATE `periodo_actual` SET periodo_anterior = :ante, `periodo_actual`= :periodo, semestre_actual = :se, periodo_siguiente = :sig WHERE `id` = '1' ");
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":se", $semes[1]);
        $sentencia->bindParam(":ante", $anterior);
        $sentencia->bindParam(":sig", $siguiente);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "err";
        }

        echo json_encode($data);
        
    }

    public function aggPeriodo($periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `periodo`(`periodo`) VALUES (:periodo)");
        $sentencia->bindParam(":periodo",$periodo);
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "err";
        }
        echo json_encode($data);
        
    }
}


?>