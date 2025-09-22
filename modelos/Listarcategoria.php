<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Listar
{
    public function listarMateria()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `programa_ac` WHERE `programa_ac`.`estado` = 1 ORDER BY `programa_ac`.`nombre` ASC");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($registro);
    }
    public function listarJornada()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `jornada`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($registro);
    }
    public function consultaDatosEstuciante($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE id_credencial = :id");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

    }

    public function consultaPrograma($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT nombre FROM `programa_ac` WHERE id_programa = :id");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;

    }

    public function consultaEstudiantes($programa,$jornada,$semestre)
    {
        $sql = " SELECT * FROM `estudiantes` WHERE 1 ";
        $a = 0;
        if ($programa != "todos1") {
            $sql .= " AND `id_programa_ac` = $programa ";
        }
        
        if ($jornada != "todos2") {
                $sql .= " AND `jornada_e` = '$jornada' ";
        } 
        
        if ($semestre != "todos3") {
            $sql .= " AND `semestre_estudiante` = $semestre ";
        }



        global $mbd;
        
        $sentencia = $mbd->prepare($sql);
        $sentencia->execute();
        if ($sentencia->rowCount() > 0) {
            while ($registro = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $datos = self::consultaDatosEstuciante($registro['id_credencial']);
            $programa = self::consultaPrograma($registro['id_programa_ac']);
            if (file_exists('../files/estudiantes/'.$datos['credencial_identificacion'].'.jpg')) {
                $foto = '../files/estudiantes/'.$datos['credencial_identificacion'].'.jpg';
            } else {
                $foto = '../files/null.jpg';
            }
            $data[]=array(
                '0'=> $datos['credencial_identificacion'],
                '1'=> $datos['credencial_nombre'].' '.$datos['credencial_nombre_2'].' '.$datos['credencial_apellido'].''.$datos['credencial_apellido_2'].'',
                '2'=> $programa['nombre'],
                '3'=> $registro['jornada_e'],
                '4'=> $registro['semestre_estudiante'],
                '5'=> '<img src="'.$foto.'" height="40px" width="40px">',
                '6'=> ($datos['credencial_condicion'] == "1")? '<span class="label label-success">Activo</span>':'<span  class="label label-danger">Desactivado</span>'
            );
        }
        } else {
            $data[]=array(
                '0'=> '',
                '1'=> '',
                '2'=> '0 Datos',
                '3'=> '',
                '4'=> '',
                '5'=> '',
                '6'=> ''
            );
        }
        
        
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    }
}


?>