<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class VerEncuestaDocente
{
    public function consulta_programas($id)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiantes` WHERE `id_credencial` = :id AND `periodo_activo` = :periodo ");
        $sentencia->bindParam(":id", $id);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function consulta_grupo($materia, $jornada, $semestre, $programa, $grupo)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare("SELECT `docente_grupos`.*, `materias_ciafi`.`nombre` FROM `docente_grupos` INNER JOIN `materias_ciafi` ON `materias_ciafi`.`id` = `docente_grupos`.`id_materia` WHERE `materias_ciafi`.`nombre` = :materia AND `docente_grupos`.`jornada` = :jornada AND `docente_grupos`.`semestre` = :semestre AND `docente_grupos`.`id_programa` = :programa AND `docente_grupos`.`periodo` = :periodo AND `docente_grupos`.`grupo` = :grupo");
        $sentencia->bindParam(":materia", $materia);
        $sentencia->bindParam(":jornada", $jornada);
        $sentencia->bindParam(":semestre", $semestre);
        $sentencia->bindParam(":programa", $programa);
        $sentencia->bindParam(":grupo", $grupo);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function estado()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `estado` FROM `activar_evaluaciones` WHERE `tipo` = 'evaluaciondocente'");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function datos_docente($id_docente)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id_docente);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function registro_bienestar($id_docente_grupo, $id_docente, $id_estudiante, $pregunta1b, $pregunta2b, $pregunta3b, $pregunta4b, $pregunta5b, $pregunta6b)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $total = ($pregunta1b + $pregunta2b + $pregunta3b + $pregunta4b + $pregunta5b + $pregunta6b);
        // Preparar la consulta con placeholders (parámetros)
        $sentencia = $mbd->prepare("INSERT INTO `encuesta_evaluacion` 
            (`id_estudiante`, `id_docente`, `id_docente_grupos`, `p1`, `p2`, `p3`, `p4`, `p5`, `p6`, `total`, `fecha`, `hora`, `periodo`) 
            VALUES (:id_estudiante, :id_docente, :id_docente_grupo, :pregunta1b, :pregunta2b, :pregunta3b, :pregunta4b, :pregunta5b, :pregunta6b, :total, :fecha, :hora, :periodo)");
        // Bindear (vincular) los parámetros con los valores
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":id_docente_grupo", $id_docente_grupo);
        $sentencia->bindParam(":pregunta1b", $pregunta1b);
        $sentencia->bindParam(":pregunta2b", $pregunta2b);
        $sentencia->bindParam(":pregunta3b", $pregunta3b);
        $sentencia->bindParam(":pregunta4b", $pregunta4b);
        $sentencia->bindParam(":pregunta5b", $pregunta5b);
        $sentencia->bindParam(":pregunta6b", $pregunta6b);
        $sentencia->bindParam(":total", $total);
        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->bindParam(":hora", $hora);
        $sentencia->bindParam(":periodo", $periodo);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
        } else {
            $data['status'] = 'error';
        }
        echo json_encode($data);
    }
    public function consulta_respondio_docente($id_docente_grupo, $id_docente, $id_estudiante)
    {
        global $mbd;  // Acceso al objeto de conexión PDO
        // Consulta para verificar si ya existe un registro en la tabla encuesta_evaluacion
        $sentencia = $mbd->prepare("SELECT COUNT(*) FROM encuesta_evaluacion WHERE id_docente_grupos = :id_docente_grupo AND id_docente = :id_docente AND id_estudiante = :id_estudiante");
        // Vincular los parámetros
        $sentencia->bindParam(':id_docente_grupo', $id_docente_grupo);
        $sentencia->bindParam(':id_docente', $id_docente);
        $sentencia->bindParam(':id_estudiante', $id_estudiante);
        $sentencia->execute();
        // Retorna true si existe un registro, de lo contrario false
        return $sentencia->fetchColumn() > 0;
    }
    //toma el estado para saber el id docente grup epecial y normal.
    public function consulta_materias($id, $ciclo)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `materias$ciclo` WHERE `id_estudiante` = :id AND `periodo` = :periodo ");
        $sentencia->bindParam(":id", $id);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function docente_grupo_por_id($id_docente_grupo){
		$sql = "SELECT * FROM `docente_grupos` WHERE `id_docente_grupo` = :id_docente_grupo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
