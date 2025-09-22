<?php
require "../config/Conexion.php";
class Consulta
{
    public function listar($id){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT `id_programa`, `nombre`, `semestres` FROM `programa_ac` WHERE `id_programa` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }

    public function consultaCantidad($id,$semestre,$jornada,$periodo){
        global $mbd;
        $sentencia=$mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_programa_ac` = :id AND `jornada_e` = :jorna AND `semestre_estudiante` = :semestre AND `periodo_activo` = :periodo");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":jorna",$jornada);
        $sentencia->bindParam(":semestre",$semestre);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return count($registros);
    }

    public function consultaCantidadPorRenovar($id, $semestre, $jornada, $periodo){
        global $mbd;
        $sentencia=$mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_programa_ac` = :id AND `jornada_e` = :jorna AND `semestre_estudiante` = :semestre AND `periodo_activo` = :periodo");
        $sentencia->bindParam(":id", $id);
        $sentencia->bindParam(":jorna", $jornada);
        $sentencia->bindParam(":semestre", $semestre);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }

    public function listarEstudiante($id,$semestre,$jornada,$periodo){
        global $mbd;
        $sentencia=$mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_programa_ac` = :id AND `jornada_e` = :jorna AND `semestre_estudiante` = :semestre AND `periodo_activo` = :periodo");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":jorna",$jornada);
        $sentencia->bindParam(":semestre",$semestre);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        while ($registros = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $datos = self::datosEstudiante($registros['id_credencial']);
            $data[] = array(
                "0" => $datos['credencial_identificacion'],
                "1" => $datos['credencial_nombre'].' '.$datos['credencial_nombre_2'].' '.$datos['credencial_apellido'].' '.$datos['credencial_apellido_2'],
                "2" => $datos['celular'],
                "3" => $datos['credencial_login']
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    }

    public function listarTotal($id,$jornada,$periodo){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiantes` WHERE `id_programa_ac` = :id AND `jornada_e` = :jorna AND `periodo_activo` = :periodo ");
    
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":jorna",$jornada);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        $data = array();
        while ($registros = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $datos = self::datosEstudiante($registros['id_credencial']);
            $data[] = array(
                "0" => $datos['credencial_identificacion'],
                "1" => $datos['credencial_nombre'].' '.$datos['credencial_nombre_2'].' '.$datos['credencial_apellido'].' '.$datos['credencial_apellido_2'],
                "2" => $datos['celular'],
                "3" => $datos['credencial_login']
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    }

    public function listarTotalRenovar($id,$jornada,$periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_programa_ac` = :id AND `jornada_e` = :jorna AND `periodo_activo` = :periodo ");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":jorna",$jornada);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }

    static function datosEstudiante($id){
       global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` INNER JOIN estudiantes_datos_personales ON credencial_estudiante.`id_credencial` = estudiantes_datos_personales.`id_credencial` WHERE credencial_estudiante.`id_credencial` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro  = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
       
    }
    /* `----------------------------------------- pór renovar --------------------------------------- */
    
    // Implementamos una función para cargar el periodo anterior
    public function cargarPeriodo(){
        $sql = "SELECT periodo_anterior FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado["periodo_anterior"];
    }
    // Implementamos una función para cargar los datos en credencial
    public function cargarDatosCredencial($id_credencial){
        $sql = "SELECT `edp`.`celular`, `ce`.* FROM `estudiantes_datos_personales` AS `edp` INNER JOIN `credencial_estudiante` AS ce ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`id_credencial` = :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function estudiantePorRenovar($id, $jornada, $id_credencial, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_programa_ac` = :id AND `jornada_e` = :jorna AND `periodo_activo` = :periodo AND  `id_credencial` = :id_credencial");
        $sentencia->bindParam(":id", $id);
        $sentencia->bindParam(":jorna", $jornada);
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
}


?>