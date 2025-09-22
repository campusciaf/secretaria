<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Estado
{
   public function casos($periodo_actual)
{
    global $mbd;
    $id_user = $_SESSION['id_usuario'];

    // Si solo pasas el año como '2025', esto lo convierte en '2025-%'
    $periodo_like = $periodo_actual . '%';

    $sql = " SELECT credencial_estudiante.credencial_identificacion, casos.caso_id, casos.caso_asunto, casos.created_at, casos.area_id, casos.cerrado_por FROM casos INNER JOIN credencial_estudiante ON credencial_estudiante.id_credencial = casos.id_estudiante INNER JOIN estudiantes ON estudiantes.id_credencial = casos.id_estudiante WHERE casos.area_id = :id_user AND casos.created_at LIKE :periodo_like AND estudiantes.fo_programa IN ( 'Nivel 1 - Técnica profesional en programación de software', 'Nivel 1 - Técnico Profesional en Logística de Producción', 'Nivel 1 - Técnico Profesional en Procesos de Seguridad y Salud en el Trabajo', 'Nivel 1 - Técnico Profesional en Procesos Empresariales', 'Nivel 2 - Tecnología en Gestión de la Seguridad y Salud en el Trabajo', 'Nivel 2 - Tecnología en Gestión Industrial', 'Nivel 2 - Tecnología en Gestión y auditoria administrativa', 'Nivel 2- Tecnología en desarrollo de software', 'Nivel 3 - Administración de empresas', 'Nivel 3 - Profesional en ingeniería de software', 'Nivel 3 - Profesional en Ingeniería Industrial', 'Nivel 3 - Profesional en Seguridad y Salud en el Trabajo', 'Profesional en Administración de Empresas', 'Profesional en Contaduría', 'PROFESIONAL EN CONTADURIA PUBLICA INTEP 2021', 'Técnica Profesional en Gestión Empresarial', 'Técnica Profesional en Gestión Financiera', 'Técnico Laboral en Mecánica y Mantenimiento de Motocicletas', 'Técnico Laboral por Competencias en Administrativo en Salud', 'Técnico Laboral por Competencias en Asistencia en Cuidado al Adulto Mayor', 'Técnico laboral por competencias en auxiliar de veterinaria y cuidado de mascotas', 'Técnico laboral por competencias en auxiliar en enfermería', 'Técnico laboral por competencias en mecánica de motocicletas', 'Técnico profesional en operaciones contables y financieras', 'Tecnología en Gestión Contable INTEP', 'TECNOLOGIA EN GESTION CONTABLE INTEP 2021', 'TECNOLOGIA EN GESTION CONTABLE INTEP 2025') ORDER BY casos.created_at DESC
    ";

    $sentencia = $mbd->prepare($sql);
    $sentencia->bindParam(':id_user', $id_user);
    $sentencia->bindParam(':periodo_like', $periodo_like);
    $sentencia->execute();

    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}



   public function remisiones($ano)
{
    global $mbd;
    $id_user = $_SESSION['id_usuario'];

    // Busca fechas que inicien con el año seleccionado, por ejemplo: "2025-"
    $anio_like = $ano . '%';

    $sql = "SELECT * FROM remisiones 
            WHERE remision_para = :id_user 
            AND remision_fecha LIKE :anio 
            ORDER BY remision_fecha DESC";

    $sentencia = $mbd->prepare($sql);
    $sentencia->bindParam(':id_user', $id_user);
    $sentencia->bindParam(':anio', $anio_like);
    $sentencia->execute();

    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}


    public function consulta_caso($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `casos` WHERE `caso_id` = $id ");
        $sentencia->execute();
        return $sentencia->fetch();
    }

    public function nombre_usuario($id)
    {
        global $mbd;

        $sql = "SELECT CONCAT(`usuario_nombre`, ' ', `usuario_nombre_2`, ' ', `usuario_apellido`, ' ', `usuario_apellido_2`) AS nombre 
            FROM `usuario` 
            WHERE `id_usuario` = :id";

        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();

        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro ? $registro['nombre'] : null;
    }


    public function fechaesp($date)
    {
        $dia     = explode("-", $date, 3);
        $year     = $dia[0];
        $month     = (string)(int)$dia[1];
        $day     = (string)(int)$dia[2];

        $dias         = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
        $tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
    }
}
