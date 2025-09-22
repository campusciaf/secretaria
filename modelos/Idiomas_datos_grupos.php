<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Idiomas
{
    public function agregar_grupo($nombre,$dia,$hora1,$hora2)
    {
        global $mbd;
        $hora = $hora1.'-'.$hora2;
        $nombre = strtoupper($nombre);
        $sentencia = $mbd->prepare(" INSERT INTO `ingles_tipo_grupo`(`nombre`, `dia`, `hora`) VALUES (:nombre,:dia,:hora) ");
        $sentencia->bindParam(":nombre",$nombre);
        $sentencia->bindParam(":dia",$dia);
        $sentencia->bindParam(":hora",$hora);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
            $data['msj'] = 'Grupo creado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al crear el grupo.';
        }

        echo json_encode($data);
        
    }

    public function agregar_docente($nombre)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" INSERT INTO `ingles_docente`(`nombre`) VALUES (:nombre) ");
        $sentencia->bindParam(":nombre",$nombre);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
            $data['msj'] = 'Docente agregado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al agregar un docente.';
        }

        echo json_encode($data);
    }

    public function docente()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_docente` ORDER BY `ingles_docente`.`nombre` ASC ");
        $sentencia->execute();

        return $sentencia->fetchAll();
    }

    public function tipo_grupo()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_tipo_grupo` ORDER BY `ingles_tipo_grupo`.`nombre` ASC ");
        $sentencia->execute();

        return $sentencia->fetchAll();
    }

    public function crear_grupo($docente,$grupo)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" INSERT INTO `ingles_grupos`(`id_docente_ingles`, `id_tipo_grupo`, `periodo_activo`) VALUES (:docente,:grupo,:periodo) ");
        $sentencia->bindParam(":docente",$docente);
        $sentencia->bindParam(":grupo",$grupo);
        $sentencia->bindParam(":periodo",$periodo);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
            $data['msj'] = 'Grupo creado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al crear el grupo';
        }

        echo json_encode($data);
        

    }

    public function listar()
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_grupos` WHERE `periodo_activo` = :periodo ");
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function docente_datos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_docente` WHERE `id` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function tipo_grupo_datos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_tipo_grupo` WHERE `id` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }


}


?>