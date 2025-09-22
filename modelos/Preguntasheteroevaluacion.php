<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Preguntas
{
    public function listar()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `preguntas_heteroevaluacion` ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function guardar($pregunta,$id,$tipo)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `preguntas_heteroevaluacion` SET `pregunta`=:pregunta,`tipo`=:tipo WHERE  id = :id ");
        $sentencia->bindParam(":pregunta",$pregunta);
        $sentencia->bindParam(":tipo",$tipo);
        $sentencia->bindParam(":id",$id);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
        } else {
            $data['status'] = 'error';
        }

        echo json_encode($data);
        
    }
}


?>