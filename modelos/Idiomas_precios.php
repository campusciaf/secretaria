<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class IdioPreci
{
    public function listar()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT uno.id, uno.valor, dos.nombre, dos.cant_asignaturas FROM `ingles_precios` as uno INNER JOIN programa_ac as dos ON uno.id_programa = dos.id_programa ORDER BY `dos`.`nombre` ASC; ");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function editar_val($id,$valor)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `ingles_precios` SET `valor`= :valor WHERE `id` = :id ");
        $sentencia->bindParam(":valor",$valor);
        $sentencia->bindParam(":id",$id);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
            $data['msj'] = 'Valores actualizados con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al actualizar los valores.';
        }

        echo json_encode($data);
        
    }
    
}


?>