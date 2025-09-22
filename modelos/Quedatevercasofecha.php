<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Estado
{
    public function buscar($mes,$ano)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT uno.caso_id, uno.caso_asunto, uno.created_at, uno.caso_estado, uno.categoria_caso, CONCAT(dos.credencial_nombre, ' ', dos.credencial_nombre_2, ' ', dos.credencial_apellido, ' ', dos.credencial_apellido_2) AS nombre, tres.fo_programa, tres.jornada_e FROM casos AS uno INNER JOIN credencial_estudiante AS dos ON uno.id_estudiante = dos.id_credencial INNER JOIN estudiantes AS tres ON uno.id_estudiante = tres.id_credencial WHERE uno.created_at LIKE '$ano-$mes%' AND tres.fo_programa IN ( 'Nivel 1 - Técnica profesional en programación de software','Nivel 1 - Técnico Profesional en Logística de Producción', 'Nivel 1 - Técnico Profesional en Procesos de Seguridad y Salud en el Trabajo', 'Nivel 1 - Técnico Profesional en Procesos Empresariales','Nivel 2 - Tecnología en Gestión de la Seguridad y Salud en el Trabajo', 'Nivel 2 - Tecnología en Gestión Industrial', 'Nivel 2 - Tecnología en Gestión y auditoria administrativa', 'Nivel 2- Tecnología en desarrollo de software','Nivel 3 - Administración de empresas','Nivel 3 - Profesional en ingeniería de software', 'Nivel 3 - Profesional en Ingeniería Industrial', 'Nivel 3 - Profesional en Seguridad y Salud en el Trabajo', 'Profesional en Administración de Empresas', 'Profesional en Contaduría', 'PROFESIONAL EN CONTADURIA PUBLICA INTEP 2021','Técnica Profesional en Gestión Empresarial','Técnica Profesional en Gestión Financiera','Técnico Laboral en Mecánica y Mantenimiento de Motocicletas', 'Técnico Laboral por Competencias en Administrativo en Salud','Técnico Laboral por Competencias en Asistencia en Cuidado al Adulto Mayor','Técnico laboral por competencias en auxiliar de veterinaria y cuidado de mascotas','Técnico laboral por competencias en auxiliar en enfermería',  'Técnico laboral por competencias en mecánica de motocicletas','Técnico profesional en operaciones contables y financieras','Tecnología en Gestión Contable INTEP','TECNOLOGIA EN GESTION CONTABLE INTEP 2021','TECNOLOGIA EN GESTION CONTABLE INTEP 2025' ) ORDER BY uno.created_at DESC;");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function nombre_usuario($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(`usuario_nombre`,' ',`usuario_nombre_2`,' ',`usuario_apellido`,' ',`usuario_apellido_2`) AS nombre FROM `usuario` WHERE `id_usuario` = $id ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro['nombre'];
    }

    public function convertir_fecha($date) 
    {
        $dia    = explode("-", $date, 3);
        $year   = $dia[0];
        $month  = (string)(int)$dia[1];
        $day    = (string)(int)$dia[2];

        $dias       = array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
        $tomadia    = $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
    }

}


?>