<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class ResultadosGenerales{
    //listar periodos
    public function listarPeriodos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `periodo` FROM `periodo` WHERE lista_evaluacion_docente='1' ORDER BY `periodo`.`periodo` DESC");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    //Listar docentes
    public function listarDocentes(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `docente` WHERE `usuario_condicion` = 1  ORDER BY `usuario_nombre` ASC");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    //listar grupos 
    public function listarGrupos($id_docente, $periodo){
        global $mbd;
        $tabla = ($periodo >= "2022-2") ? "docente_grupos" : "docente_grupos_2";
        $sentencia = $mbd->prepare("SELECT $tabla.`id_docente_grupo`, $tabla.`ciclo` , $tabla.`id_programa` , $tabla.`jornada` , $tabla.`semestre` , $tabla.`grupo`, $tabla.`id_materia`, $tabla.`id_materia`, `programa_ac`.`nombre` AS `nombre_programa` FROM $tabla INNER JOIN `programa_ac` ON `programa_ac`.`id_programa` = $tabla.`id_programa` WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function materiasPorDocente($id_docente, $periodo){
        $tabla = ($periodo >= "2022-2") ? "docente_grupos" : "docente_grupos_2";
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS `total` FROM $tabla WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function listarResultados($id_docente_grupo, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("
            SELECT 
                `id_docente`,
                `id_docente_grupos`,
                COUNT(*) as `cantidad`, 
                SUM(`total`) AS `total`, 
                (SUM(`total`) / COUNT(*)) AS `promedio`
            FROM `heteroevaluacion`  
            WHERE `id_docente_grupos` = :id_docente_grupo AND `periodo` = :periodo
            GROUP BY `id_docente`, `id_docente_grupos`
        ");
        $sentencia->bindParam(":id_docente_grupo", $id_docente_grupo);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $result = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }
    // public function listarResultados($id_docente_grupo, $periodo){
    //     global $mbd;
    //     $sentencia = $mbd->prepare("
    //         SELECT COUNT(`id_docente_grupos`) as `cantidad`, SUM(`total`) AS `total`, `id_docente`, `id_docente_grupos`, (SUM(`total`) / COUNT(`id_docente_grupos`)) AS `promedio` FROM `heteroevaluacion`  WHERE `id_docente_grupos` = :id_docente_grupo AND `periodo` = :periodo ");
    //     $sentencia->bindParam(":id_docente_grupo", $id_docente_grupo);
    //     $sentencia->bindParam(":periodo", $periodo);
    //     $sentencia->execute();
    //     return $sentencia->fetch(PDO::FETCH_ASSOC);
    // }
    public function buscarResultadoPeriodo($id_docente, $periodo_actual){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT ((`r1` + `r2` + `r3` + `r4` + `r5` + `r6` + `r7` + `r8` + `r9` + `r10`) * 100)/30 AS total  
                                    FROM `coevaluacion_docente` 
                                    WHERE `id_docente` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":periodo", $periodo_actual);
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function autoevaluacionDocente($id_docente, $periodo_actual){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT ((`r1` + `r2` + `r3` + `r4` + `r5` + `r6` + `r7` + `r8` + `r9` + `r10`) * 100)/30 AS `total`  FROM `autoevaluacion_docente` WHERE `id_usuario` = :id_docente AND `periodo` LIKE :periodo");
        $sentencia->bindParam(":periodo", $periodo_actual);
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function promedioCalculado($id_docente, $periodo){
        global $mbd;
        $sql = "SELECT SUM(`total`) * 1.0 / COUNT(*) AS `promedio` FROM `heteroevaluacion` WHERE `id_docente` = :id_docente  AND `periodo` = :periodo";
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(':id_docente', $id_docente, PDO::PARAM_INT);
        $sentencia->bindParam(':periodo', $periodo, PDO::PARAM_STR);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resultado['promedio']; // Devuelve el promedio directamente
    }
}
