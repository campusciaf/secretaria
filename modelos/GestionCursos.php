<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");

class GestionCursos
{
    //Implementar un método para listar los registros
    public function listarCursos()
    {
        global $mbd;
        $sql = "SELECT * FROM `web_educacion_continuada` ORDER BY `web_educacion_continuada`.`create_dt` DESC;";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para listar los registros
    public function listarDocentesActivos()
    {
        global $mbd;
        $sql = "SELECT * FROM `docente` WHERE `usuario_condicion` = 1;";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para listar los registros
    public function listarDocente($id_usuario)
    {
        global $mbd;
        $sql = "SELECT CONCAT(`usuario_nombre`, ' ', `usuario_nombre_2`, ' ', `usuario_apellido`, ' ', `usuario_apellido_2`) AS `nombre_completo` FROM `docente` WHERE `id_usuario` = :id_usuario;";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //lista los empleados activos
    public function mostrarCurso($id_curso)
    {
        global $mbd;
        $sql = 'SELECT * FROM `web_educacion_continuada` WHERE `id_curso` = :id_curso';
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_curso", $id_curso);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //inserta la cita en la tabla de rojas
    public function insertarCurso($nombre_curso, $docente_curso, $descripcion_curso, $modalidad_curso, $fecha_inicio, $fecha_fin, $horario_curso, $sede_curso, $precio_curso, $categoria, $nivel_educacion, $duracion_educacion, $imagen)
    {
        global $mbd;
        $query = "INSERT INTO `web_educacion_continuada`(`id_curso`, `nombre_curso`, `docente_curso`, `descripcion_curso`, `modalidad_curso`, `fecha_inicio`, `fecha_fin`, `horario_curso`, `sede_curso`, `precio_curso`, `categoria`, `nivel_educacion`, `duracion_educacion`, `imagen_curso`, `estado_curso`) VALUES ( NULL, :nombre_curso, :docente_curso, :descripcion_curso, :modalidad_curso, :fecha_inicio , :fecha_fin, :horario_curso,  :sede_curso, :precio_curso, :categoria, :nivel_educacion, :duracion_educacion, :imagen, 1)";
        $stmt = $mbd->prepare($query);
        $stmt->bindParam(':nombre_curso', $nombre_curso);
        $stmt->bindParam(':docente_curso', $docente_curso);
        $stmt->bindParam(':descripcion_curso',$descripcion_curso, PDO::PARAM_STR);
        $stmt->bindParam(':modalidad_curso', $modalidad_curso);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':horario_curso', $horario_curso);
        $stmt->bindParam(':sede_curso', $sede_curso);
        $stmt->bindParam(':precio_curso', $precio_curso);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':nivel_educacion', $nivel_educacion);
        $stmt->bindParam(':duracion_educacion', $duracion_educacion);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->execute();
        if ($stmt) {
            return $mbd->lastInsertId();
        }
        return FALSE;
    }
    //edita la cita en la tabla de rojas
    public function editarCurso($id_curso, $nombre_curso, $docente_curso, $descripcion_curso, $modalidad_curso, $fecha_inicio, $fecha_fin, $horario_curso,  $sede_curso, $precio_curso, $categoria, $nivel_educacion, $duracion_educacion, $imagen)
    {
        global $mbd;
        $query = "UPDATE `web_educacion_continuada` SET `nombre_curso` = :nombre_curso, `docente_curso` = :docente_curso, `descripcion_curso` = :descripcion_curso, `modalidad_curso` = :modalidad_curso, `fecha_inicio` = :fecha_inicio, `fecha_fin` = :fecha_fin, `horario_curso` = :horario_curso,  `sede_curso` = :sede_curso, `precio_curso` = :precio_curso, `categoria` = :categoria, `nivel_educacion` = :nivel_educacion, `duracion_educacion` = :duracion_educacion, `imagen_curso` = :imagen WHERE `id_curso` = :id_curso";
        $stmt = $mbd->prepare($query);
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->bindParam(':nombre_curso', $nombre_curso);
        $stmt->bindParam(':docente_curso', $docente_curso);
        $stmt->bindParam(':descripcion_curso', $descripcion_curso);
        $stmt->bindParam(':modalidad_curso', $modalidad_curso);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':horario_curso', $horario_curso);
        $stmt->bindParam(':sede_curso', $sede_curso);
        $stmt->bindParam(':precio_curso', $precio_curso);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':nivel_educacion', $nivel_educacion);
        $stmt->bindParam(':duracion_educacion', $duracion_educacion);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->execute();
        return $stmt;
    }
    public function eliminarCurso($id_curso)
    {
        global $mbd;
        $query = "DELETE FROM `web_educacion_continuada` WHERE `id_curso` = :id_curso";
        $stmt = $mbd->prepare($query);
        $stmt->bindParam(':id_curso', $id_curso);
        return $stmt->execute();
    }
    public function estadoCurso($id_curso, $estado_educacion)
    {
        global $mbd;
        $query = "UPDATE `web_educacion_continuada` SET `estado_educacion` = :estado_educacion WHERE `web_educacion_continuada`.`id_curso` = :id_curso;";
        $stmt = $mbd->prepare($query);
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->bindParam(':estado_educacion', $estado_educacion);
        return $stmt->execute();
    }
    // funcin para convertir la fecha a formato español //	
    function fechaesp($date)
    {
        $dia     = explode("-", $date, 3);
        $year     = $dia[0];
        $month     = (string)(int)$dia[1];
        $day     = (string)(int)$dia[2];
        $dias         = array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
        $tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return $tomadia . ", " . $day . " " . $meses[$month] . "  " . $year;
    }
    //por medio de fecha trae el nombre del dia
    function get_nombre_dia($fecha)
    {
        $fechats = strtotime($fecha); //pasamos a timestamp
        switch (date('w', $fechats)) {
            case 0:
                return "domingo";
                break;
            case 1:
                return "lunes";
                break;
            case 2:
                return "martes";
                break;
            case 3:
                return "miercoles";
                break;
            case 4:
                return "jueves";
                break;
            case 5:
                return "viernes";
                break;
            case 6:
                return "sabado";
                break;
        }
    }
}
